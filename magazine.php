<?php
//$language = $_GET['language'] = $HTTP_GET_VARS['language'] = 'sc';
define('_MODE_KEY','magazine');
require_once('includes/application_top.php');

$error = false;
if($_POST['ajax']=="true"){
	$js_str = '[JS]';
	switch($_GET['action']){
		case "ajaxSubmitEmail":
			if(tep_validate_email($_POST['emailAddressSubscribe']) == false){
				$error = true;
				$js_str .= 'ajaxReturnString("�����ʼ���ʽ����");';
			}
			
			if($error == false){
				if(write_subscribe_email_address($_POST['emailAddressSubscribe'])){
					$js_str .= 'ajaxReturnString("��ϲ�����ĵ��������ַ�ύ�ɹ���");';
				}else{
					$js_str .= 'ajaxReturnString("���Ѿ��ύ���õ��������ַ��");';
				}
			}
		break;
		case "ajaxSubmitVote": 
			//print_r($_POST);
			//exit;
			
			$error_string="";
			if(!tep_not_null($_POST['v_s_i_o_text'][10][98])){
				$_POST['v_s_i_o_text'][10][98] = "------";
			}else{
				$_POST['v_s_i_o_text'][10][98] = ajax_to_general_string($_POST['v_s_i_o_text'][10][98]);
			}
			if(!tep_not_null($_POST['text_vote'][10][99])){
				$_POST['text_vote'][10][99] = "------";
			}else{
				$_POST['text_vote'][10][99] = ajax_to_general_string($_POST['text_vote'][10][99]);
			}
			if(!tep_not_null($_POST['text_vote'][10][102])){
				$_POST['text_vote'][10][102] = "------";
			}else{
				$_POST['text_vote'][10][102] = ajax_to_general_string($_POST['text_vote'][10][102]);
			}
			if(!tep_not_null($_POST['text_vote'][10][103])){
				$_POST['text_vote'][10][103] = "------";
			}else{
				$_POST['text_vote'][10][103] = ajax_to_general_string($_POST['text_vote'][10][103]);
			}
			
			$submit_vote = submit_vote($error_string, $customer_id);
			if(tep_not_null($error_string)){
				$error_string = html_to_db($error_string);
				$js_str .= 'jQuery("#submitVoteMsn").html("'.tep_db_input(tep_db_prepare_input($error_string)).'"); ';
			}elseif($submit_vote!=false){
				$msn_string = "����ϵͳ�Ѿ��������ύ�ĵ��飬лл����֧�֣�";
				if(!(int)$customer_id){
					$msn_string .= '<br>����δ��¼���� <a href="'.tep_href_link("login.php","", "SSL") .'" class="" style="font-size:14px;"><b>��¼</b></a> ��ȡ���֣������û�����ķ����ʺţ��� <a href="'.tep_href_link("create_account.php","", "SSL").'" class="" style="font-size:14px;"><b>ע��</b></a> ���Ա��ȡ���ε���Ļ��֡�';
				}else{
					$sql = tep_db_query('SELECT * FROM `vote_system` WHERE v_s_id ="'.$v_s_id.'" LIMIT 1');
					$row = tep_db_fetch_array($sql);
					$v_s_points = $row['v_s_points']; 
					if((int)$v_s_points){
						$msn_string .= '�����뱾�ε���� '.$v_s_points.' ���֣��Ѿ����������ʺš�';
					}
				}
				$js_str .= 'jQuery("#submitVoteMsn").html("'.tep_db_input(tep_db_prepare_input($msn_string)).'"); ';
				
				//��������ְҵ������
				if($_POST['v_s_i_o_id'][10][98]=="379"){
					tep_db_query('update vote_system_results set text_vote ="'.html_to_db(tep_db_input(tep_db_prepare_input(trim($_POST['v_s_i_o_text'][10][98])))).'" where v_s_id=10 and v_s_i_id=98 and v_s_i_o_id=379 and (text_vote="" || text_vote IS NULL )');
				}
			}
			
			$js_str .= 'jQuery("#submitVoteButton").html("�ύ�ʾ�")';
		break;	
	}
	
	$js_str .= '[/JS]';
	$js_str = preg_replace('/[[:space:]]+/',' ',$js_str);
	echo db_to_html($js_str);
	exit;
}


//2011-08-11���µ����ķ�E��{	
if(tep_not_null($_GET['version']) && $_GET['version']==2){
	//ȡ�õ�����Ϣv_s_id=10{
	$voteData=array();
	$v_s_id = 10;
	$ToDay = date('Y-m-d');
	$Whiere_Ex = ' AND ( v_s_end_date >="'.$ToDay.'" || v_s_end_date="" || v_s_end_date="0000-00-00" )';
	$vote_sql = tep_db_query('SELECT * FROM `vote_system` WHERE v_s_id="'.(int)$v_s_id.'" AND v_s_state ="1" AND  v_s_start_date <="'.$ToDay.'" '.$Whiere_Ex.' limit 1');
	if($_GET['action']=='preview'){
		$vote_sql = tep_db_query('SELECT * FROM `vote_system` WHERE v_s_id="'.(int)$v_s_id.'" limit 1');
	}
	//ȡ��vote_system
	while($vote_rows = tep_db_fetch_array($vote_sql)){
		$voteData['id'] = $vote_rows['v_s_id'];
		$voteData['title'] = $vote_rows['v_s_description'];
		//ȡ��vote_system_item
		
		$item_sql = tep_db_query('SELECT * FROM `vote_system_item` WHERE v_s_id="'.(int)$vote_rows['v_s_id'].'" Order By v_s_i_sort ASC, v_s_i_id ASC ');
		$item_num = 0;
		$voteData['item'] = array();
		while($item_rows = tep_db_fetch_array($item_sql)){
			$voteData['item'][$item_num] = array('id'=> $item_rows['v_s_i_id'],'title'=> $item_rows['v_s_i_title'],'type'=>$item_rows['v_s_i_type']);
			//ȡ�ô�ѡ��
			if((int)$item_rows['v_s_i_type']!='2'){	//��ѡ��ѡ
				$options_sql = tep_db_query('SELECT * FROM `vote_system_item_options` WHERE v_s_i_id="'.$item_rows['v_s_i_id'].'" Order By v_s_i_o_id ');
				$check_box_i = 0;
				while($options_rows = tep_db_fetch_array($options_sql)){
						if((int)$item_rows['v_s_i_type'] =='0'){
							$input_box = '<label>'.tep_draw_radio_field('v_s_i_o_id['.$vote_rows['v_s_id'].']['.(int)$item_rows['v_s_i_id'].']', (int)$options_rows['v_s_i_o_id'] , $checked ).$options_rows['v_s_i_o_title'].'</label>';
						}elseif((int)$item_rows['v_s_i_type'] =='1'){
							$input_box = '<label>'.tep_draw_checkbox_field('v_s_i_o_id['.$vote_rows['v_s_id'].']['.(int)$item_rows['v_s_i_id'].']['.$check_box_i.']', (int)$options_rows['v_s_i_o_id'] , $checked ).$options_rows['v_s_i_o_title'].'</label>';
							$check_box_i++;
						}
					$voteData['item'][$item_num]['answers'][] = array('id'=>$options_rows['v_s_i_o_id'], 'text'=>$options_rows['v_s_i_o_title'],'input'=>$input_box);
				}
			}else{ //�ı�
				$input_box = tep_draw_input_field('text_vote['.$vote_rows['v_s_id'].']['.(int)$item_rows['v_s_i_id'].']');
				$voteData['item'][$item_num]['answers'][] = array('input'=>$input_box);
			}
			$item_num++;
		}
	}
	//ȡ�õ�����Ϣ}
	
	$breadcrumb->add(db_to_html('���ķ�E��'), tep_href_link('index.php', '', 'NONSSL'));
	$content = 'magazine_201108';
	require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
	require(DIR_FS_INCLUDES . 'application_bottom.php');
	exit;
}
//2011-08-11���µ����ķ�E��}	

require_once(DIR_FS_FUNCTIONS . 'dleno.function.php');
$Title = '���ķ�E��';
$No = $_GET['No'];
!ereg('^[A-Za-z0-9_]+$',$No) && $No = 'new';

$NoRoot = 'images/'.'_'._MODE_KEY.'/'.$No.'/';

if(!is_dir(_TEP_ROOT_DIR_.$NoRoot)){
	$No = 'new';
	$NoRoot = 'images/'.'_'._MODE_KEY.'/'.$No.'/';
}
$WEBROOT = HTTP_SERVER.'/'.$NoRoot;
//$NoHtmlDir = _TEP_ROOT_DIR_.$NoRoot;
$NoHtmlDir = DIR_FS_CATALOG.$NoRoot;
$url_address = tep_href_link(_MODE_KEY.'.php','No='.$No);
$downloadUrl = tep_href_link(_MODE_KEY.'.php','No='.$No.'&download=1');
$downloadDir = DIR_FS_CATALOG.$NoRoot;
//echo $downloadDir;exit;
//Howard added ��������� start
if(tep_not_null($_GET['share']) && $_GET['share']=="1"){
	require_once('_'._MODE_KEY.'/share.php');
	exit;
}
//Howard added ��������� end

//$languageUrl = tep_href_link(_MODE_KEY.'.php','language=tw');
//$languageText = '����';
//if(CHARSET == 'big5'){
//	$languageUrl = tep_href_link(_MODE_KEY.'.php','language=sc');
//	$languageText = '����';
//}


$Content = readover($NoHtmlDir.'#index.html');
preg_match('~<No>(.+)</No>~is',$Content, $matches);
$No = trim($matches[1]);
$Content = str_replace("<No>$No</No>",'',$Content);
preg_match('~<title>(.+)</title>~is',$Content, $matches);
$Title = $matches[1].' - '.$Title;
$Content = str_replace("<title>".$matches[1]."</title>",'',$Content);

is_numeric($No) && $Title = '�� '.$No.' �� - '.$Title;

if(!isset($_GET['download']) || !(int)$_GET['download']){
	//====ע��=====�������Ժ��ǵ��������ʽ {
	if(file_exists($NoHtmlDir.'ebook/index.htm')){
		//echo ($NoHtmlDir.'ebook/index.htm');
		//echo '<hr>';
		$goToUrl = $WEBROOT.'ebook/index.htm';
		tep_redirect($goToUrl);
		exit;
	}
	//}
	
	if(CHARSET == 'big5'){
		$Content = str_replace('208.109.123.18','tw.usitrip.com',$Content);
		
		$Content = str_replace('"images/','"'.$WEBROOT.'images_ft/',$Content);
		$Content = str_replace('\'images/','\''.$WEBROOT.'images_ft/',$Content);
		$Content = str_replace(':images/',':'.$WEBROOT.'images_ft/',$Content);
	}else{
		//$Content = str_replace('208.109.123.18','cn.usitrip.com',$Content);
		
		$Content = str_replace('"images/','"'.$WEBROOT.'images/',$Content);
		$Content = str_replace('\'images/','\''.$WEBROOT.'images/',$Content);
		$Content = str_replace(':images/',':'.$WEBROOT.'images/',$Content);
	}
	$Content = str_replace('"css/','"'.$WEBROOT.'css/',$Content);
	$Content = str_replace('\'css/','\''.$WEBROOT.'css/',$Content);
	
	require(_SMARTY_ROOT_."write_smarty_vars.php");
	$smarty->display(_MODE_KEY . '.tpl.htm');
	
}else{
	
	$fileName = $downloadDir.'magazine'.str_replace('ZY-','',$No).'_usitrip_'.CHARSET.'.pdf';
	$basename = $Title.'.pdf';
	if($_GET['download']=="2"){
		$fileName = $downloadDir.'magazine'.str_replace('ZY-','',$No).'_usitrip_'.CHARSET.'.exe.rar';
		$basename = $Title.'.exe.rar';
	}
	//echo $fileName.":".$basename; exit;
	download($fileName,$basename);
	
}

?>
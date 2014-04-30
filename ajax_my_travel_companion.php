<?php
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );

require_once('includes/application_top.php');
require_once(DIR_FS_INCLUDES . 'ajax_encoding_control.php');

//�ر��°汾���ߵ���ʾ��Ϣ
if($_GET['action']=="HiddenNewVersionNote"){
	$HiddenNewVersionNote = 1;
	tep_session_register('HiddenNewVersionNote');
	exit;
}

//����û�
if(!tep_session_is_registered('customer_id') || !(int)$customer_id){
	echo db_to_html('[ERROR]�����µ�¼�˺ţ�[/ERROR]');
	exit;
}

//����ɾ����Ϣ start
if($_GET['action']=='remove_sms' && $error == false){
	$sis_ids = $_POST['sis_ids'];
	if(!tep_not_null($sis_ids)){
		echo db_to_html('[ERROR]��ѡ��Ҫɾ������Ϣ����[/ERROR]');
		exit;
	}
	$sis_ids_str = implode(',',$sis_ids);
	tep_db_query('DELETE FROM `site_inner_sms` WHERE `sis_id` in ('.$sis_ids_str.') and owner_id="'.(int)$customer_id.'" ');
	$sms = "[SUCCESS]1[/SUCCESS]";
	$remove_str = '';
	for($i=0; $i<count($sis_ids); $i++){
		$remove_str .= ' var tmp_obj'.$i.' = document.getElementById("Tab_myjb_item1_sms_'.$sis_ids[$i].'"); ';
		$remove_str .= ' tmp_obj'.$i.'.parentNode.removeChild(tmp_obj'.$i.'); ';
	}
	$sms .= "[JS]".$remove_str."[/JS]";
	echo db_to_html($sms);
	exit;
}
//����ɾ����Ϣ end

//���Ϊ�Ѷ� start
if($_GET['action']=='set_has_been_read' && $error == false){
	$sis_ids = $_POST['sis_ids'];
	if(!tep_not_null($sis_ids)){
		echo db_to_html('[ERROR]��ѡ��Ҫ��ǵ���Ϣ����[/ERROR]');
		exit;
	}
	$sis_ids_str = implode(',',$sis_ids);
	tep_db_query('UPDATE `site_inner_sms` SET has_read = "1" WHERE `sis_id` in ('.$sis_ids_str.') and owner_id="'.(int)$customer_id.'" ');
	$sms = "[SUCCESS]1[/SUCCESS]";
	$remove_str = '';
	for($i=0; $i<count($sis_ids); $i++){
		$remove_str .= ' var tmp_obj'.$i.' = document.getElementById("icons_'.$sis_ids[$i].'"); ';
		$remove_str .= ' if(tmp_obj'.$i.'.src.indexOf("News_send.gif") == -1){ tmp_obj'.$i.'.src = "image/icons/News_read.gif"; } ';
		$remove_str .= ' var Tab_myjb_item1_sms = document.getElementById("Tab_myjb_item1_sms_'.$sis_ids[$i].'"); ';
		$remove_str .= ' var Child_A = Tab_myjb_item1_sms.getElementsByTagName("a"); ';
		$remove_str .= ' for(i=0; i<Child_A.length; i++){ if(Child_A[i].title!=""){ Child_A[i].style.fontWeight ="normal"; } } ';
	}
	$sms .= "[JS]".$remove_str."[/JS]";
	echo db_to_html($sms);
	exit;
}

if($_GET['action']=='show_title' && $error == false){
	$sis_id = $_GET['sis_id'];
	if(!tep_not_null($sis_id)){
		echo db_to_html('[ERROR]��ѡ��Ҫ��ǵ���Ϣ����[/ERROR]');
		exit;
	}
	tep_db_query('UPDATE `site_inner_sms` SET has_read = "1" WHERE `sis_id` = "'.(int)$sis_id.'" and owner_id="'.(int)$customer_id.'" ');
	$sms = "[SUCCESS]1[/SUCCESS]";
	$sms .= '[JS] document.getElementById("icons_'.(int)$sis_id.'").src = "image/icons/News_read.gif";[/JS]';
	echo $sms;
	exit;
}

//���Ϊ�Ѷ� end

//��ͬ�⡢�ܾ���ȡ��֮ǰд��������� start
if($_GET['action']=='write_pop_sms' && $error == false){
	if(mb_strlen(preg_replace('/[[:space:]]+/','',$_POST['text_content']))<1){
		$js_str = ' alert("������������Ϣ��");';
	}else{
		$tca_verify_status = "1";
		if($_POST['agre_or_close']=="close"){ $tca_verify_status = "0"; }
		if($_POST['action_exc']=="refusal_verify"){ $tca_verify_status = "2"; }
		
		$verify_status_sms = $tca_verify_status.":".iconv('utf-8',CHARSET.'//IGNORE',tep_db_prepare_input($_POST['text_content']));
		$date_array = array('verify_status_sms' => $verify_status_sms);
		$date_array = html_to_db($date_array);
		tep_db_perform('travel_companion_application', $date_array, 'update', "tca_id = '" . (int)$_POST['tca_id'] . "'");
		
		$js_str = "";
		$js_str .= ' var tca_id="'.$_POST['tca_id'].'"; ';
		$js_str .= ' var agre_or_close="'.$_POST['agre_or_close'].'"; ';
		$js_str .= ' var skip_check="'.$_POST['skip_check'].'"; ';
		$js_str .= ' var action_exc="'.$_POST['action_exc'].'"; ';
		$js_str .= ' t_verify_action(tca_id, agre_or_close, skip_check, action_exc); ';
		$js_str .= ' closeDiv("GeneralNotes"); ';
		
	}
	$js_str = '[JS]'.preg_replace('/[[:space:]]+/',' ',$js_str).'[/JS]';
	
	echo db_to_html($js_str);
	exit;
}
//��ͬ�⡢�ܾ���ȡ��֮ǰд��������� end

//ͬ�⡢�ܾ���ȡ���Ѿ�ͬ��Ľ��ͬ������ strart
if($_GET['action']=='agre_verify' && $error == false){
	if(!(int)$_GET['tca_id']){
		$error_sms = "[ERROR]�����ڵ�tca_id��".$_GET['tca_id']."[/ERROR]";
		echo db_to_html($error_sms);
		exit;
	}
	$tca_id = (int)$_GET['tca_id'];
	//check out
	$check_sql = tep_db_query('SELECT tc.customers_id, tc.t_companion_id, tca.customers_id as tca_cus_id, tca.tca_cn_name, tca.tca_email_address FROM `travel_companion_application` tca, `travel_companion` tc WHERE tca.tca_id ="'.$tca_id.'" AND tc.t_companion_id = tca.t_companion_id limit 1');
	$check = tep_db_fetch_array($check_sql);
	if($check['customers_id']!=$customer_id){
		$error_sms = "[ERROR]����".$tca_id." �������Ľ��ͬ��������������[/ERROR]";
		echo db_to_html($error_sms);
		exit;
	}
	
	$t_companion_id = $check['t_companion_id'];
	
	if($_GET['close_agre']=='1'){	//ȡ��ͬ��
		tep_db_query('UPDATE `travel_companion_application` SET `tca_verify_status` = "0" WHERE `tca_id` =  "'.$tca_id.'" LIMIT 1 ;');
		$sms = "[SUCCESS]1[/SUCCESS]";
		$sms = "[JS] var agree_box = document.getElementById('agree_box_".$tca_id."'); if(agree_box!=null){ agree_box.innerHTML = '<button onclick=\"agre_verify(".$tca_id.")\" class=\"jb_my_sqcz\" type=\"button\">ͬ��</button>' }; var Close_Botton = document.getElementById('close_botton_".$tca_id."'); if(Close_Botton!=null){ Close_Botton.style.display = 'none'; }
		var RefusalVerifyA = document.getElementById('RefusalVerifyA_".$tca_id."');
		RefusalVerifyA.style.display = '';
[/JS]";
	}else{ //ͬ��
		
		if($_GET['check_per']=='true'){
		//���ͬ�������Ƿ��Ѿ������������� start
			$check_per_sql = tep_db_query('SELECT hope_people_man, hope_people_woman, hope_people_child FROM `travel_companion` WHERE t_companion_id ="'.(int)$t_companion_id.'" ');
			$check_per = tep_db_fetch_array($check_per_sql);
			$hope_per_num = (int)$check_per['hope_people_man']+(int)$check_per['hope_people_woman']+(int)$check_per['hope_people_child'];
			
			$checked_per_sql = tep_db_query('SELECT SUM(tca_people_num) as has_per_num FROM `travel_companion_application` WHERE t_companion_id ="'.(int)$t_companion_id.'" and tca_verify_status="1" Group By t_companion_id ');
			$checked_per = tep_db_fetch_array($checked_per_sql);
			$has_per_num = (int)$checked_per['has_per_num'];
			if($has_per_num >= $hope_per_num ){
				$tpl_content = file_get_contents(DIR_FS_CONTENT . 'html_tpl/'.'travel_companion_agre_warning.tpl.html');
				$tpl_content = db_to_html($tpl_content);
				$tpl_content = str_replace('{tca_id}',$tca_id,$tpl_content);
				
				$js_str = '
				var Notes = document.getElementById("GeneralNotes");
				var Content = document.getElementById("GeneralNotesContent");
				Content.innerHTML = "'.addslashes($tpl_content).'"; 
				showDiv(Notes.id);
				';
				$js_str = '[JS]'.preg_replace('/[[:space:]]+/',' ',$js_str).'[/JS]';
				echo $js_str;
				exit;
			}
		//���ͬ�������Ƿ��Ѿ������������� end
		}
		
		//ͬ��
		$show_str = "��ͬ��";
		$status_val = "1";
		if($_GET['action_exc']=="refusal_verify"){	//�ܾ�
			$show_str = "�Ѿܾ�";
			$status_val = "2";
		}
		
		tep_db_query('UPDATE `travel_companion_application` SET `tca_verify_status` = "'.$status_val.'" WHERE `tca_id` =  "'.$tca_id.'" LIMIT 1 ;');
		$sms = "[SUCCESS]1[/SUCCESS]";
		$sms = "[JS] var agree_box = document.getElementById('agree_box_".$tca_id."'); if(agree_box!=null){ agree_box.innerHTML = '".$show_str."'; } 
		var Close_Botton = document.getElementById('close_botton_".$tca_id."');
		if(Close_Botton!=null){ Close_Botton.style.display = ''; }
		var RefusalVerifyA = document.getElementById('RefusalVerifyA_".$tca_id."');
		RefusalVerifyA.style.display = 'none';
		var Notes = document.getElementById('GeneralNotes');
		var Content = document.getElementById('GeneralNotesContent');
		Content.innerHTML = ''; 
		closeDiv(Notes.id);
		[/JS]";
	}
	
	//�������˷�֪ͨ�ʼ��Ͷ���Ϣ
	/* �µķ��ʼ����� by lwkai add 2012-06-28 */
	if($_GET['close_agre']=='1'){ 					// ��ȡ��
		$send_mail_type = 'canceled';
	}elseif($_GET['action_exc']=="refusal_verify"){	// �ܾ�
		$send_mail_type = 'refuse';
	}else{											// ͬ��	
		$send_mail_type = 'agree';
	}
	
	if(class_exists('send_mail_ready') == false){
		require_once DIR_FS_CLASSES . 'send_mail_ready.php';
	}
	if(class_exists('companion_mail') == false) {
		require_once DIR_FS_CLASSES . 'companion_mail.php';
	}
	if(class_exists('result_application_companion_mail') == false) {
		require_once DIR_FS_CLASSES . 'result_application_companion_mail.php';
	}
	new result_application_companion_mail($tca_id, $send_mail_type);
	/* ���ʼ����� */
	
	
	
	$sms_content_reason = $_GET['sms_content'];
	//TOM ADDED д������
	$sms_content_reason = "[�Է���������]:" . html_to_db($sms_content_reason);
	
	
	/* ԭ���ķ��ʼ����� by  lwkai 2012-06-28 ע��
	$to_name = db_to_html(tep_db_output($check['tca_cn_name']));
	$to_email_address = $check['tca_email_address']; 
	$email_subject = db_to_html("���ķ����ͬ��--");
	$from_email_name = db_to_html("���ķ���");
	$from_email_address = "automail@usitrip.com";
	$email_text = "�𾴵�".html_to_db($to_name)."��\n";
	if($_GET['close_agre']=='1'){
		$email_subject.= db_to_html("��ȡ�� ");
		$email_text .= "���ź���������Ľ��ͬ���Ѿ���������".tep_get_customer_name($customer_id)."<b>ȡ����</b>";
		$sms_content = "������Ľ��ͬ���Ѿ���������ȡ����";
	}elseif($_GET['action_exc']=="refusal_verify"){
		$email_subject.= db_to_html("δ������ ");
		$email_text .= "���ź�������".tep_get_customer_name($customer_id)."����Ľ��ͬ�κ��ź�δ���Է����ܣ����߶Է��Ѿ�����ͬ���ߣ����ķ���������������ͬ����Ϣ���������з���һ����";
		$sms_content = "�������Ѿ��ܾ������Ľ�����룡";
	}else{
		$email_subject.= db_to_html("������ ");
		$email_text .= "��ϲ������".tep_get_customer_name($customer_id)."����Ľ��ͬ���Ѿ������������Ͽ�ȥ<a href='".tep_href_link('new_bbs_travel_companion_content.php','t_companion_id='.$t_companion_id)."'>�鿴</a>��";
		$sms_content = "�������Ѿ�ͬ�������Ľ�����룡";
	}
	$email_text.= "\n".'������ʹ�����·�����Է�ȡ����ϵ��';
	$email_text.= "\n".'�������ʼ�����'.tep_get_customers_email($customer_id)."��<a href='".tep_href_link('new_bbs_travel_companion_content.php','t_companion_id='.$t_companion_id)."'>��¼��ҳ���������Ϣ</a>"."\n";
	
	if(tep_not_null($sms_content_reason)){
		$email_text.= EMAIL_SEPARATOR."\n";
		$email_text.= strip_tags($sms_content_reason)."\n";
		$email_text.= EMAIL_SEPARATOR."\n";
	}
	$the_href = tep_href_link('my_travel_companion.php');
	$email_text.= "\n".'<a href="'.$the_href.'" target="_blank">�������鿴����</a>'."\n\n";
	
	$email_text.= CONFORMATION_EMAIL_FOOTER;
	
	$email_text = db_to_html($email_text);
	//howard add use session+ajax send email
	$n = count($_SESSION['need_send_email']);
	$_SESSION['need_send_email'][$n]['to_name'] = $to_name;
	$_SESSION['need_send_email'][$n]['to_email_address'] = $to_email_address;
	$_SESSION['need_send_email'][$n]['email_subject'] = $email_subject;
	$_SESSION['need_send_email'][$n]['email_text'] = $email_text;
	$_SESSION['need_send_email'][$n]['from_email_name'] = $from_email_name;
	$_SESSION['need_send_email'][$n]['from_email_address'] = $from_email_address;
	$_SESSION['need_send_email'][$n]['action_type'] = 'true';*/
	//howard add use session+ajax send email end
	
	//send inner_msm start
	$add_date = date("Y-m-d H:i:s");
	$type_name = "travel_companion";
	$key_id = (int)$check['t_companion_id'];
	$sms_content = db_to_html($sms_content).db_to_html($sms_content_reason);
	$sql_data_array = array('customers_id' => (int)$check['customers_id'],
							'type_name' => $type_name,
							'key_id' => $key_id,
							'to_customers_id' => (int)$check['tca_cus_id'],
							'sms_content' => $sms_content,
							'add_date' => $add_date,
							'owner_id' => (int)$check['tca_cus_id'],
							'sms_type' => '100');	//ϵͳ��Ϣ

	$sql_data_array = html_to_db($sql_data_array);
	tep_db_perform('`site_inner_sms`', $sql_data_array);
	//send inner_msm end
	$sms = preg_replace('/[[:space:]]+/',' ',$sms);
	echo db_to_html($sms);
	exit;
}
//ͬ���ȡ���Ѿ�ͬ��Ľ��ͬ������ end

//���������ѹ��ڣ������¿��� start
if($_GET['action']=='set_has_expired' && $error == false){
	if(!(int)$_GET['t_companion_id']){
		$error_sms = "[ERROR]�����ڵ�t_companion_id��".$_GET['t_companion_id']."[/ERROR]";
		echo db_to_html($error_sms);
		exit;
	}
	$t_companion_id = (int)$_GET['t_companion_id'];
	//check out
	$check_sql = tep_db_query('SELECT customers_id FROM `travel_companion` tc WHERE tc.t_companion_id = "'.$t_companion_id.'" limit 1');
	$check = tep_db_fetch_array($check_sql);
	if($check['customers_id']!=$customer_id){
		$error_sms = "[ERROR]����".$t_companion_id." ����������Ľ��ͬ������[/ERROR]";
		echo db_to_html($error_sms);
		exit;
	}
	tep_db_query('UPDATE `travel_companion` SET `has_expired` = "'.(int)$_GET['has_expired'].'" WHERE `t_companion_id` =  "'.$t_companion_id.'" LIMIT 1 ;');
	
	$a_href_string = '<a class="ui-setting-loss" href="javascript:void(0)" onclick="set_has_expired('.$t_companion_id.',1)">��Ϊ������</a>';
	if((int)$_GET['has_expired']=="1"){
		$a_href_string = '<a class="ui-setting-loss" href="javascript:void(0)" onclick="set_has_expired('.$t_companion_id.',0)">���¿������</a>';
	}
	
	$sms = "[SUCCESS]1[/SUCCESS]";
	$sms = "[JS] var set_expired_string = document.getElementById('set_expired_string_".$t_companion_id."'); if(set_expired_string!=null){ set_expired_string.innerHTML = '".$a_href_string."' } [/JS]";
	echo db_to_html($sms);
	exit;
}
//���������ѹ��ڣ������¿��� end

//ȡ����ɾ�����ͬ������
if($_GET['action']=='remove_app' && $error == false){
	if(!(int)$_GET['tca_id']){
		$error_sms = "[ERROR]�����ڵ�tca_id��".$_GET['tca_id']."[/ERROR]";
		echo db_to_html($error_sms);
		exit;
	}
	$tca_id = (int)$_GET['tca_id'];
	//check out
	$check_sql = tep_db_query('SELECT t_companion_id, customers_id, tca_verify_status FROM `travel_companion_application` WHERE tca_id = "'.$tca_id.'" limit 1');
	$check = tep_db_fetch_array($check_sql);
	if($check['customers_id']!=$customer_id){
		$error_sms = "[ERROR]����".$tca_id." ����������Ľ��ͬ�Ρ�[/ERROR]";
		echo db_to_html($error_sms);
		exit;
	}
	if($check['tca_verify_status']=="1"){
		$error_sms = "[ERROR]���󣬶Է��Ѿ�ͬ���飬��������Ϣ����ɾ����[/ERROR]";
		echo db_to_html($error_sms);
		exit;
	}
	
	tep_db_query('DELETE FROM `travel_companion_application` WHERE tca_id =  "'.$tca_id.'" LIMIT 1 ;');
	tep_db_query('DELETE FROM `travel_companion_application_list` WHERE tca_id =  "'.$tca_id.'" ;');
	$sms = "[SUCCESS]1[/SUCCESS]";
	$remove_str = "";
	if((int)$tca_id){
		$remove_str .= ' var tmp_obj_app = document.getElementById("Tab_myjb_item1_app_'.$tca_id.'"); ';
		$remove_str .= ' tmp_obj_app.parentNode.removeChild(tmp_obj_app); ';
		$remove_str .= ' var myjb_app = document.getElementById("myjb_content_ck_'.$tca_id.'"); ';
		//$remove_str .= ' myjb_app.parentNode.removeChild(myjb_app); ';
		$remove_str .= ' var myjb_app_id = "#"+myjb_app.id; $(myjb_app_id).slideUp(600); ';
	}
	$sms .= "[JS]".$remove_str."[/JS]";
	echo db_to_html($sms);
	
	if((int)$check['t_companion_id']){//�������˷��ʼ�֪ͨ�������Ѿ���ɾ������Ϣ
		$sql = tep_db_query('SELECT customers_id, email_address FROM `travel_companion` WHERE t_companion_id="'.(int)$check['t_companion_id'].'" ');
		$row = tep_db_fetch_array($sql);
		$to_email = $row['email_address'];
		if(tep_validate_email($row['email_address']) == false){
			$to_email = tep_get_customers_email($row['customers_id']);
		}
		if(tep_not_null($to_email)){
			$travel_companion_links = tep_href_link('new_bbs_travel_companion_content.php','t_companion_id='.(int)$check['t_companion_id']);
			$to_name = tep_customers_name($row['customers_id']);
			$to_email_address = $to_email;
			$email_subject = '���ͬ����������ȡ�� - ���ķ��� ';
			$email_text = "�𾴵�".$to_name."��\n";
			$email_text.= '���ķ�����'.tep_customers_name($customer_id).'���������Ľ��ͬ����<a href="'.$travel_companion_links.'">'.$travel_companion_links.'</a>�ϵ����������Ѿ���������������ȡ��������֪����'."\n\n";
			$email_text.= CONFORMATION_EMAIL_FOOTER;
			$from_email_name = STORE_OWNER;
			$from_email_address = 'automail@usitrip.com';
			
			$count = count($_SESSION['need_send_email']);
			$_SESSION['need_send_email'][$count]['to_name'] = $to_name;
			$_SESSION['need_send_email'][$count]['to_email_address'] = $to_email_address;
			$_SESSION['need_send_email'][$count]['email_subject'] = $email_subject;
			$_SESSION['need_send_email'][$count]['email_text'] = $email_text;
			$_SESSION['need_send_email'][$count]['from_email_name'] = $from_email_name;
			$_SESSION['need_send_email'][$count]['from_email_address'] = $from_email_address;
			$_SESSION['need_send_email'][$count]['action_type'] = 'true';
			$_SESSION['need_send_email'][$count]['email_charset'] = 'gb2312';
			
		}
	}	
	exit;
}

//�����û��˺�����(ֻ�����������Ա����ա����˱�ע)
if($_GET['action']=='submit_account_edit' && $error == false){
    $customers_firstname = tep_db_prepare_input($_POST['firstname']);
    $customers_lastname = tep_db_prepare_input($_POST['lastname']);
	$customers_gender = tep_db_prepare_input($_POST['gender']);
    if(!isset($_POST['dob'])){ $_POST['dob'] = $_POST['dob_year'].'-'.$_POST['dob_month'].'-'.$_POST['dob_day'];}
	$customers_dob = substr(tep_db_prepare_input($_POST['dob']),0,10).' 00:00:00';	
    $customers_remark = tep_db_prepare_input($_POST['customers_remark']);
	$customers_face = tep_db_prepare_input($_POST['customers_face']);
	$dob_secret = (int)$_POST['dob_secret'];
	$telephone_secret = (int)$_POST['telephone_secret'];
	$email_secret = (int)$_POST['email_secret'];
	$space_public = (int)$_POST['space_public'];
	
	$error = false;
	$error = '';
	if(strlen($customers_firstname) < ENTRY_FIRST_NAME_MIN_LENGTH){
		$error = true;
		$error_sms .= ENTRY_FIRST_NAME_ERROR;
	}
        /*
	if(strlen($customers_lastname) < ENTRY_LAST_NAME_MIN_LENGTH){
		$error = true;
		$error_sms .= ENTRY_LAST_NAME_ERROR;
	}*/
	if($customers_gender!="m" && $customers_gender!="f"){
		$error = true;
		$error_sms .= ENTRY_GENDER_ERROR;
	}
	if(check_date($customers_dob)==false || $max_date > date("Y-m-d H:i:s")){
		$error = true;
		$error_sms .= db_to_html('����������ȷ���������ڣ��磺1980-01-31');
	}elseif(date("Y-m-d H:i:s", strtotime($customers_dob.' +2 year')) > date("Y-m-d H:i:s")){
		$error = true;
		$error_sms .= db_to_html('����������ȷ���������ڣ��磺1980-01-31');
	}
	
	if($error == true){
		echo "[ERROR]".$error_sms."[/ERROR]";
		exit;
	}
    //��������ı��û���������Ϣ
	$sql_data_array = array(//'customers_firstname' => ajax_to_general_string($customers_firstname),
                            //'customers_lastname' => $customers_lastname,
                            'email_secret' => $email_secret,
							'telephone_secret' => $telephone_secret,
							'customers_gender' => $customers_gender,
                            'customers_dob' => $customers_dob,
							'dob_secret' => $dob_secret,
                            'customers_remark' => ajax_to_general_string($customers_remark),
							'customers_face' => $customers_face,
							'space_public' => $space_public);

    $sql_data_array = html_to_db($sql_data_array);
	tep_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int)$customer_id . "'");
    tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_account_last_modified = now() where customers_info_id = '" . (int)$customer_id . "'");

	$notes_content = '�������ϸ��³ɹ���';
	$out_time = 3; //�ӳ�3��ر�
	$tpl_content = file_get_contents(DIR_FS_CONTENT . 'html_tpl/'.'out_time_notes.tpl.html');
	$tpl_content = str_replace('{notes_content}',$notes_content,$tpl_content);
	$tpl_content = str_replace('{out_time}',$out_time,$tpl_content);
	
	$sms = '
	var gotourl = "";
	var notes_contes = "'.addslashes($tpl_content).'";
	write_success_notes('.$out_time.', notes_contes, gotourl);
	closeDiv("travel_companion_tips_2064");
	';
	$sms = '[JS]'.preg_replace('/[[:space:]]+/',' ',$sms).'[/JS]';

	echo db_to_html($sms);
	exit;
}
?>
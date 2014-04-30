<?php
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );

$p=array('/&amp;/','/&quot;/');
$r=array('&','"');

require_once('includes/application_top.php');
require_once(DIR_FS_INCLUDES . 'ajax_encoding_control.php');
//���дʹ���
include_once('includes/classes/word_filter.php');
$filter = new stringFilter();

//����û�
if(!tep_session_is_registered('customer_id') || !(int)$customer_id){
	if(!tep_not_null($_POST['password'])){
		echo db_to_html('[ERROR]���������ĵ�¼���룡[/ERROR]');
		exit;
	}
	if(!tep_not_null($HTTP_GET_VARS['action'])){ $HTTP_GET_VARS['action'] = 'process';}else{ $old_action = $HTTP_GET_VARS['action']; $HTTP_GET_VARS['action'] = 'process'; }
	$ajax = $_POST['ajax'];
	include('login.php');
	if(tep_not_null($old_action)){
		$HTTP_GET_VARS['action'] = $old_action;
	}
}

//������
if($_GET['action']=='confirm_update' && $error == false){
	$t_c_reply_content = tep_db_prepare_input($_POST['t_c_reply_content']);
	$t_c_reply_content = html_to_db(iconv('utf-8',CHARSET.'//IGNORE',$t_c_reply_content));
	try{
		$t_c_reply_content = $filter->checkString($t_c_reply_content, 'gb2312');
	} catch (Exception $e){
		echo($e->getMessage());
	}
	$sql_data_array = array(
						  	't_c_reply_content' => ($t_c_reply_content),
							'last_time' => date('Y-m-d H:i:s')
							);

	//$sql_data_array = html_to_db($sql_data_array);
	tep_db_perform('`travel_companion_reply`', $sql_data_array,'update', 't_c_reply_id="'.(int)$_POST['t_c_reply_id'].'" ');
	echo '[SUCCESS]'.(int)$_POST['t_c_reply_id'].'[/SUCCESS]';
	die();
}
//�ظ���
if($_GET['action']=='process' && $error == false){
	//$customers_name = tep_db_prepare_input($_POST['customers_name']);
	//$customers_name = $customer_first_name;	//��ֵ�����ݿ�ֱ��ȡ�����Բ������� 
	$customers_name='';
	if(!tep_not_null($customers_name)){
		//$customers_name = strip_tags( db_to_html(tep_customers_name((int)$customer_id)) );
		$customers_name = strip_tags(tep_customers_name((int)$customer_id));
	}
		
	$customers_phone = tep_db_prepare_input($_POST['customers_phone']);
	$email_address = tep_db_prepare_input($_POST['email_address']);
	$t_companion_id = tep_db_prepare_input($_POST['t_companion_id']);
	$t_c_reply_content = tep_db_prepare_input($_POST['t_c_reply_content']);
	$parent_id = tep_db_prepare_input($_POST['parent_id']);
	$gender = (int)$_POST['gender'];
	$parent_type = (int)$_POST['parent_type'];
	
	$date_time = date('Y-m-d H:i:s');
	$status = '1';
	$only_top_can_see = (int)$_POST['only_top_can_see'];
	
	$t_c_reply_content = html_to_db(iconv('utf-8',CHARSET.'//IGNORE',$t_c_reply_content));
	$customers_phone = html_to_db(iconv('utf-8',CHARSET.'//IGNORE',$customers_phone));
	
	// ����Ƿ���coupon_code �����ڷ����������С���
	$coupon_code_result = tep_db_query("select coupon_code from coupons");
	while($coupon_code = tep_db_fetch_array($coupon_code_result)) {
		if (strpos($t_c_reply_content, $coupon_code['coupon_code']) !== false || strpos($customers_phone,$coupon_code['coupon_code']) !== false) {
			$t_c_reply_content = str_replace($coupon_code['coupon_code'],'******',$t_c_reply_content);
			$customers_phone = str_replace($coupon_code['coupon_code'],'******', $customers_phone);
		}
	}
	
	// ���˹ؼ���
	try{
		$arr_replace=array('Ⱥ255745376','Ⱥ8983881','Ⱥ92823258');
		$t_c_reply_content=str_replace($arr_replace, '282972788', $t_c_reply_content);
		$t_c_reply_content = $filter->checkString($t_c_reply_content, 'gb2312');
		$customers_phone = $filter->checkString($customers_phone, 'gb2312');
	} catch (Exception $e){
		echo($e->getMessage());
	}
	
	$sql_data_array = array('customers_id' => (int)$customer_id ,
							'customers_name' => $customers_name,
						  	'customers_phone' => ($customers_phone),
						  	'email_address' => $email_address,
						  	't_companion_id' => (int)$t_companion_id,
						  	't_c_reply_content' => ($t_c_reply_content),
						  	'gender' => $gender,
							'status' => $status,
							'parent_id' => (int)$parent_id,
							'add_time' => $date_time,
							'last_time' => $date_time,
							'parent_type' => $parent_type,
							'only_top_can_see' => $only_top_can_see);

	tep_db_perform('`travel_companion_reply`', $sql_data_array);
	$t_c_reply_id = tep_db_insert_id();
	
	//���»����������Լ�������ʱ��
	$sql = tep_db_query('SELECT count(*) as total FROM `travel_companion_reply` WHERE t_companion_id="'.(int)$t_companion_id.'" AND status="1" ');
	$row = tep_db_fetch_array($sql);
	$row_total = (int)$row['total'];
	tep_db_query('UPDATE travel_companion SET reply_num="' . (int)$row_total.'", last_time="'.$date_time.'" WHERE t_companion_id="'.(int)$t_companion_id.'" ');
	//�Ż���
	tep_db_query('OPTIMIZE TABLE `travel_companion` , `travel_companion_reply`'); 
	
	
	/* �����˻ظ��ʼ�  by lwkai add 2012-06-26*/
	if (class_exists('send_mail_ready') == false) {
		require_once DIR_FS_CLASSES . 'send_mail_ready.php';
	}
	if (class_exists('companion_mail') == false) {
		require_once DIR_FS_CLASSES . 'companion_mail.php';
	}
	if (class_exists('reply_companion_mail') == false) {
		require_once DIR_FS_CLASSES . 'reply_companion_mail.php';
	}
	new reply_companion_mail($t_companion_id, $customer_id, $t_c_reply_id);
	
	/* �ظ��ʼ����� */
	
	
	/*
	//�ظ��ɹ����ʼ���¥��
	$mail_sql = tep_db_query('SELECT * FROM `travel_companion` WHERE t_companion_id="'.(int)$t_companion_id.'" Limit 1 ');
	$mail_rows = tep_db_fetch_array($mail_sql);
	
	$travel_companion_re_email_switch = TRAVEL_COMPANION_RE_EMAIL_SWITCH;
	if($travel_companion_re_email_switch == 'true' && $customer_id!=$mail_rows['customers_id'] ){	//�Լ��ص��򲻷��ʼ�
		$to_name = strip_tags($mail_rows['customers_name']) ." ";
		$to_email_address = strip_tags($mail_rows['email_address']);
		$from_email_name = STORE_OWNER;
		$from_email_address = STORE_OWNER_EMAIL_ADDRESS;
		
		$email_subject = '���ķ����ͬ�Ρ����˻��� ';
		$email_text = '�𾴵� '.strip_tags($mail_rows['customers_name'])."\n";
		$tTcPath = tep_get_category_patch($mail_rows['categories_id']);
		$email_text .= '�����������Ϊ ��'.strip_tags($mail_rows['t_companion_title'])."�� �Ľ��ͬ�Σ����˻ظ���һ�������ݣ�\n" . '������Ӳ鿴��<a href="'.tep_href_link('new_bbs_travel_companion_content.php','TcPath='.$tTcPath.'&t_companion_id='.(int)$t_companion_id).'" target="_blank">'.tep_href_link('new_bbs_travel_companion_content.php','t_companion_id='.(int)$t_companion_id).'</a> ע���������򲻿����븴�����ӣ�ճ�����������ַ���д򿪡�'."\n";
		$email_text .= '�����˵��������£�'."\n";
		$customer_info = tep_get_customers_info($customer_id);
		$email_text .= '������'.$customer_info['customers_firstname']."\n";
		$email_text .= '�������䣺'.$customer_info['customers_email_address']."\n\n";
		$email_text .= EMAIL_SEPARATOR."\n";
		$email_text .= '���������ݣ�'."\n".nl2br(tep_db_output($sql_data_array['t_c_reply_content']))."\n";
		$email_text .= EMAIL_SEPARATOR."\n\n";
		
		$email_text .= CONFORMATION_EMAIL_FOOTER;
		
		$array_i = count($_SESSION['need_send_email']);
		$_SESSION['need_send_email'][$array_i]['to_name'] = db_to_html($to_name);
		$_SESSION['need_send_email'][$array_i]['to_email_address'] = $to_email_address;
		$_SESSION['need_send_email'][$array_i]['email_subject'] = db_to_html($email_subject);
		$_SESSION['need_send_email'][$array_i]['email_text'] = db_to_html($email_text);
		$_SESSION['need_send_email'][$array_i]['from_email_name'] = db_to_html($from_email_name);
		$_SESSION['need_send_email'][$array_i]['from_email_address'] = $from_email_address;
		$_SESSION['need_send_email'][$array_i]['action_type'] = 'true';
	}
	*/
	//echo '[SUCCESS]'.(int)$t_companion_id.'[/SUCCESS]';
	$notes_content = '���Ѿ��ɹ��ظ���ף��˳�����ͬ�Ρ�';
	$out_time = 3; //�ӳ�3��ر�
	$tpl_content = file_get_contents(DIR_FS_CONTENT . 'html_tpl/'.'out_time_notes.tpl.html');
	$tpl_content = str_replace('{notes_content}',$notes_content,$tpl_content);
	$tpl_content = str_replace('{out_time}',$out_time,$tpl_content);
	$goto_url = preg_replace($p,$r,tep_href_link('new_bbs_travel_companion_content.php','t_companion_id='.(int)$t_companion_id.'&page=10000'));			
	$js_str = '
	var gotourl = "'.$goto_url.'";
	var notes_contes = "'.addslashes($tpl_content).'";
	write_success_notes('.$out_time.', notes_contes, gotourl);
	';
	$js_str = '[JS]'.preg_replace('/[[:space:]]+/',' ',$js_str).'[/JS]';
	echo db_to_html($js_str);
	exit;
	
	//ȡ����������
?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px dashed #6f6f6f;">
	  <tr>
		<td width="78%" height="20"  ></td>
		<td width="14%" nowrap="nowrap" > <?php echo $customers_name. db_to_html(' �Ļظ�')?></td>
	
		<td width="8%" align="right" nowrap="nowrap" ><span style="color:#6f6f6f;"><?php echo (int)$row_total.db_to_html('¥')?></span></td>
	  </tr>
	  <tr>
		<td height="32" colspan="3" style="color:#6f6f6f" ><p style="padding-left:8px"><?php echo nl2br(iconv('utf-8',CHARSET.'//IGNORE',tep_db_output($t_c_reply_content)));?></p></td>
	  </tr>
	</table>
<?php
}
?>
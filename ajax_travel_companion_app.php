<?php
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );

require_once('includes/application_top.php');
require_once(DIR_FS_INCLUDES . 'ajax_encoding_control.php');

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

//�ύ���ͬ������
if($_GET['action']=='process' && $error == false){
	$error_sms = "";	
	
	$t_companion_id = tep_db_prepare_input($_POST['t_companion_id']);
	if(!(int)$t_companion_id){ $t_companion_id = (int)$_GET['t_companion_id'];}
	if(!(int)$t_companion_id){
		$error_sms .= db_to_html('�޽��ͬ�����ݣ���ˢ��ҳ�棡\n\n');
		$error = true;
	}
	
	if((int)tep_check_travel_companion_app($customer_id, $t_companion_id)){
		$error_sms = db_to_html('���Ѿ�����ý�飬�����ظ����룡\n\n');
		$error = true;
		echo "[JS] style_alert('".$error_sms."'); closeDiv('travel_companion_tips_2064')[/JS]";
		exit;
	}
	
	$apped_num = tep_count_travel_companion_app_num($t_companion_id);
	$sql = tep_db_query('SELECT customers_id,hope_people_man,hope_people_woman,hope_people_child,open_ended, has_expired  FROM `travel_companion` WHERE t_companion_id='.(int)$t_companion_id.' ');
	$rows = tep_db_fetch_array($sql);
	//����Ƿ��Ѿ����˻��Ƿ��ѹ���
	if($rows['has_expired']=="1"){
		$error_sms = db_to_html('�Ѿ����ڣ�\n\n');
		$error = true;
		echo "[JS] style_alert('".$error_sms."'); closeDiv('travel_companion_tips_2064')[/JS]";
		exit;
	}
	
	$hope_pep_num = (int)$rows['hope_people_man']+(int)$rows['hope_people_woman']+(int)$rows['hope_people_child'];
	if($apped_num > $hope_pep_num && !(int)$rows['open_ended']){
		$error_sms = db_to_html('�������������������ˣ�������İɡ�\n\n');
		$error = true;
		echo "[JS] style_alert('".$error_sms."'); closeDiv('travel_companion_tips_2064')[/JS]";
		exit;
	}
	
	//����Ƿ���¥������
	if($rows['customers_id']==$customer_id){
		$error_sms = db_to_html('����¥�����������롣\n\n');
		$error = true;
		echo "[JS] style_alert('".$error_sms."'); closeDiv('travel_companion_tips_2064')[/JS]";
		exit;
	}
	
	$tca_cn_name = tep_db_prepare_input($_POST['tca_cn_name']);
    if (strlen($tca_cn_name) < ENTRY_FIRST_NAME_MIN_LENGTH) {
    	$error = true;
    	$error_sms .= db_to_html('���� ��������'.ENTRY_FIRST_NAME_MIN_LENGTH.'����\n\n');
	}
	$tca_en_name = tep_db_prepare_input($_POST['tca_en_name']);
    if (strlen($tca_en_name) < ENTRY_LAST_NAME_MIN_LENGTH) {
    	$error = true;
    	$error_sms .= db_to_html('Ӣ���� ��������'.ENTRY_LAST_NAME_MIN_LENGTH.'����\n\n');
	}
	$tca_gender = tep_db_prepare_input($_POST['tca_gender']);
    if (!(int)$tca_gender) {
    	$error = true;
    	$error_sms .= db_to_html('�Ա� ������д��ѡ��\n\n');
	}
	$tca_email_address = tep_db_prepare_input($_POST['email_address']);
	if(tep_validate_email($tca_email_address) == false){
    	$error = true;
    	$error_sms .= db_to_html('���� ��������Ч�ĵ�������\n\n');
	}
	$tca_people_num = (int)$_POST['tca_people_num'];
	if($tca_people_num == 0){
    	$error = true;
    	$error_sms .= db_to_html('���� ��������С��1\n\n');
	}
	
	$tca_phone = tep_db_prepare_input($_POST['tca_phone']);
	$tca_content = tep_db_prepare_input($_POST['tca_content']);
		
	if($error == true){
		//echo '[ERROR]'.$error_sms.'[/ERROR]';
		echo '[JS] alert("'.$error_sms.'"); [/JS]';
		exit;
	}
	
	$tca_verify_status = '0';
	$customers_id = $customer_id;
	
	$date_time = date('Y-m-d H:i:s');
	$status = '1';
	$sql_data_array = array('t_companion_id' => (int)$t_companion_id ,
							'tca_cn_name' => iconv('utf-8',CHARSET.'//IGNORE',$tca_cn_name),
						  	'tca_en_name' => iconv('utf-8',CHARSET.'//IGNORE',$tca_en_name),
						  	'tca_gender' => $tca_gender,
						  	'tca_email_address' => $tca_email_address,
						  	'tca_phone' => iconv('utf-8',CHARSET.'//IGNORE',$tca_phone),
						  	'tca_people_num' => $tca_people_num,
							'tca_content' => iconv('utf-8',CHARSET.'//IGNORE',$tca_content),
							'tca_verify_status' => (int)$tca_verify_status,
							'customers_id' => $customers_id,
							'date_time' => $date_time);

	$sql_data_array = html_to_db($sql_data_array);
	tep_db_perform('`travel_companion_application`', $sql_data_array);
	$t_c_reply_id = tep_db_insert_id();

	//�����û�����ʵ���������$will_update_accΪtrue�Ÿ���
	$will_update_acc = false;
	if(tep_not_null($tca_cn_name) && $will_update_acc==true){
		$sql_data_array1 = array('customers_firstname' => iconv('utf-8',CHARSET.'//IGNORE',$tca_cn_name),
								'customers_lastname' => iconv('utf-8',CHARSET.'//IGNORE',$tca_en_name) );
		if((int)$tca_gender){
			$sql_data_array1['customers_gender'] = ($tca_gender==1) ? 'm' : 'f';
		}
		$sql_data_array1 = html_to_db($sql_data_array1);
		$customer_first_name = $sql_data_array1['customers_firstname'];
		tep_session_register('customer_first_name');
		tep_db_perform('customers', $sql_data_array1,'update', ' customers_id="'.(int)$customer_id.'" ');
	}
	
	//�����������ʼ���¥��
	
	/* �����˻ظ��ʼ�  by lwkai add 2012-06-26*/
	if (class_exists('send_mail_ready') == false) {
		require_once DIR_FS_CLASSES . 'send_mail_ready.php';
	}
	if (class_exists('companion_mail') == false) {
		require_once DIR_FS_CLASSES . 'companion_mail.php';
	}
	if (class_exists('application_companion_mail') == false) {
		require_once DIR_FS_CLASSES . 'application_companion_mail.php';
	}
	new application_companion_mail($t_companion_id, $customer_id, $t_c_reply_id);
	
	/* �ظ��ʼ����� */
	
	/*$mail_sql = tep_db_query('SELECT * FROM `travel_companion` WHERE t_companion_id="'.(int)$t_companion_id.'" Limit 1 ');
	$mail_rows = tep_db_fetch_array($mail_sql);
	
	$travel_companion_app_email_switch = TRAVEL_COMPANION_RE_EMAIL_SWITCH;
	
	if($travel_companion_app_email_switch == 'true' && $customer_id!=$mail_rows['customers_id'] ){	//�Լ��ص��򲻷��ʼ�
		$to_name = strip_tags($mail_rows['customers_name']) ." ";
		$to_email_address = strip_tags($mail_rows['email_address']);
		$from_email_name = STORE_OWNER;
		$from_email_address = STORE_OWNER_EMAIL_ADDRESS;
		
		$email_subject = '���ķ����ͬ�Ρ��������� ';
		$email_text = '�𾴵� '.strip_tags($mail_rows['customers_name'])."\n";
		$tTcPath = tep_get_category_patch($mail_rows['categories_id']);
		/* ȡ�ý��ͬ��������·�����ƺ�URL��ַ * /
		$sql = tep_db_query("select p.products_urlname,pd.products_name from products as p,products_description as pd where p.products_id=pd.products_id and p.products_id='" . $mail_rows['products_id'] . "'");
		$product_row = tep_db_fetch_array($sql);
		$email_text .= '�����������Ϊ ��'.strip_tags($mail_rows['t_companion_title']).'���Ľ��ͬ��,���µ���Ա���롣';
		$email_text .= '��·�ǣ�<a href="' . tep_href_link($product_row['products_urlname'] . '.html') . '" target="_blank">' . $product_row['products_name'] . '</a>' . "\n";
		$email_text .= '������Ӳ鿴<a href="'.tep_href_link('my_travel_companion.php','action=my_sent') . '" target="_blank">'.tep_href_link('my_travel_companion.php','action=my_sent') . '</a> ע���������򲻿����븴�Ƹ����ӵ��������ַ���򿪡�'."\n\n";
		$email_text .= EMAIL_SEPARATOR."\n";
		$email_text .= '�����˵��������£�'."\n";
		$email_text .= '������'.$sql_data_array['tca_cn_name'].' ['.$sql_data_array['tca_en_name'].']'."\n";
		$email_text .= '�Ա�'.($sql_data_array['tca_gender']=="2" ? 'Ůʿ' : '����')."\n";
		$email_text .= '�������䣺'.$sql_data_array['tca_email_address']."\n";
		$email_text .= '�绰��'.$sql_data_array['tca_phone']."\n";
		$email_text .= '������'.$sql_data_array['tca_people_num']."\n";
		$email_text .= '�������ݣ�'.tep_db_output($sql_data_array['tca_content'])."\n";
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
	$notes_content = '��������Ϣ�Ѿ��ɹ��ύ��';
	$out_time = 3; //�ӳ�3��ر�
	$tpl_content = file_get_contents(DIR_FS_CONTENT . 'html_tpl/'.'out_time_notes.tpl.html');
	$tpl_content = str_replace('{notes_content}',$notes_content,$tpl_content);
	$tpl_content = str_replace('{out_time}',$out_time,$tpl_content);
	$goto_url = "";			
	
	$js_str = '
	var gotourl = "'.$goto_url.'";
	var notes_contes = "'.addslashes($tpl_content).'";
	write_success_notes('.$out_time.', notes_contes, gotourl);
	';
	$js_str = '[JS]'.preg_replace('/[[:space:]]+/',' ',$js_str).'[/JS]';
	echo db_to_html($js_str);
	exit;

}
?>
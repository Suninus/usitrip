<?php
require_once('includes/application_top.php');

  if (!(int)$customer_id || !(int)$affiliate_id) {
    $navigation->set_snapshot();
	if(tep_not_null($_COOKIE['LoginDate'])){
		$messageStack->add_session('login', LOGIN_OVERTIME);
		setcookie('LoginDate', '');
	}
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

if($action=='inputcode'){
	//echo '������֤�룡';
	$error = false;
	$validation_result = false;
	if(!tep_not_null($affiliate_email_address_verifi_code)){
		$error = true;
		$messageStack->add('validation',db_to_html('��������֤�룡'));
	}
	if($error == false){
		$sql = tep_db_query('SELECT affiliate_id, affiliate_email_address_verified FROM `affiliate_affiliate` WHERE affiliate_email_address_verifi_code="'.tep_db_input(tep_db_prepare_input($affiliate_email_address_verifi_code)).'" AND affiliate_id="'.(int)$affiliate_id.'" ');
		$row = tep_db_fetch_array($sql);
		if((int)$row['affiliate_id']){
			if(!(int)$row['affiliate_email_address_verified']){
				tep_db_query("UPDATE `affiliate_affiliate` SET `affiliate_email_address_verified` = '1' WHERE `affiliate_id` = '".(int)$affiliate_id."' LIMIT 1 ;");
				$messageStack->add('validation',db_to_html('������֤�ɹ���'),'success');
								
				$validation_result = true;
			}else{
				$validation_result = true;
				$messageStack->add('validation',db_to_html('�����ʺ��Ѿ�ͨ����֤�������ظ���֤��'),'success');
			}
		}else{
			$error = true;
			$messageStack->add('validation',db_to_html('���������֤�����'));
		}
	}
}

if($action=='resend'){
	//echo '���·�����֤�룡';
	$affiliate_email_address = tep_get_affiliate_email_address($affiliate_id);
	$re_send = send_affiliate_validation_mail($affiliate_email_address);
	if((int)$re_send){
		$messageStack->add('validation',db_to_html('������֤�ʼ����ͳɹ����뼸���Ӻ���������'.$affiliate_email_address.'������֤���ʼ���'),'success');
	}
}

$breadcrumb->add(db_to_html('������֤'));
$content = 'affiliate_validation';
require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
require(DIR_FS_INCLUDES . 'application_bottom.php');
?>
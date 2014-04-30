<?php
require_once('includes/application_top.php');

  if (!(int)$customer_id) {
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
	if(!tep_not_null($customers_validation_code)){
		$error = true;
		$messageStack->add('validation',db_to_html('��������֤�룡'));
	}
	if($error == false){
		$sql = tep_db_query('SELECT customers_id, customers_validation FROM `customers` WHERE customers_validation_code="'.tep_db_prepare_input($customers_validation_code).'" AND customers_id="'.$customer_id.'" ');
		$row = tep_db_fetch_array($sql);
		if((int)$row['customers_id']){
			if(!(int)$row['customers_validation']){
				tep_db_query("UPDATE `customers` SET `customers_validation` = '1' WHERE `customers_id` = '".(int)$customer_id."' LIMIT 1 ;");
				$customer_validation = '1';
				tep_session_register('customer_validation');
				$messageStack->add('validation',db_to_html('�˺���֤�ɹ���'),'success');
				//��ӻ��ֽ���
				// Points/Rewards system V2.1rc2a BOF
				if ((USE_POINTS_SYSTEM == 'true') && (VALIDATION_ACCOUNT_POINT_AMOUNT > 0)) {
				  tep_add_validation_points($row['customers_id']);
				  
				}
				// Points/Rewards system V2.1rc2a EOF
				
				$customer_validation = '1';
				tep_session_register('customer_validation');
								
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
	$re_send = send_validation_mail($customer_email_address);
	if((int)$re_send){
		$messageStack->add('validation',db_to_html('�˺���֤�ʼ����ͳɹ������Ժ���������'.$customer_email_address.'������֤���ʼ���'),'success');
	}
}

$breadcrumb->add(db_to_html('�˺���֤'));
$content = 'customers_validation';
require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
require(DIR_FS_INCLUDES . 'application_bottom.php');
?>
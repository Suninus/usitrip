<?php
require('includes/application_top.php');

$sql = tep_db_query('SELECT customers_id,customers_firstname, customers_email_address FROM `customers` WHERE customers_id > 0 AND customers_email_address="'.trim($customers_email_address).'" Order By customers_id limit 1');
$row = tep_db_fetch_array($sql);

$error = false;

if(tep_not_null($_POST['customers_email_address'])){

		$_POST['tours_customer_name'] = db_to_html($row['customers_firstname']);
	
	if(date('Ymd')>20090208){
		$error = true;
		$messageStack->add('feedback', db_to_html('�˵������ʱ��Ϊ<strong>2008��12��8��</strong>��<strong>2009��2��8��</strong>�������Ѿ�������'));
	}
	if(!tep_not_null($_POST['tours_age'])){
		$error = true;
		$messageStack->add('feedback', db_to_html('��ѡ����������'));
	}
	if(!tep_not_null($_POST['tours_gender'])){
		$error = true;
		$messageStack->add('feedback', db_to_html('��ѡ�������Ա�'));
	}
	if(!tep_not_null($_POST['tours_from'])){
		$error = true;
		$messageStack->add('feedback', db_to_html('��ѡ�� ����ͨ�����ַ�ʽ֪������վ��'));
	}
	if(!tep_not_null($_POST['ServicesEval'])){
		$error = true;
		$messageStack->add('feedback', db_to_html('��ѡ�� ���Ա�վ���������'));
	}
	if(!tep_not_null($_POST['tours_add_server'])){
		$error = true;
		$messageStack->add('feedback', db_to_html('��ѡ�� ������������Ҫ������Щ�����ҵ��/����'));
	}
	if(!tep_not_null($_POST['tours_i_rec'])){
		$error = true;
		$messageStack->add('feedback', db_to_html('��ѡ�� ���Ƽ���վ��Ʒ����������û'));
	}
	if(!tep_not_null($_POST['tours_consumer'])){
		$error = true;
		$messageStack->add('feedback', db_to_html('��ѡ�� ��һ�㻨�Ѷ�����һ�������г�����'));
	}
	
	if(!tep_not_null($_POST['tours_focus'])){
		$error = true;
		$messageStack->add('feedback', db_to_html('��ѡ�� �������ι����У����ں������е���һ��'));
	}
	
	if(!(int)count($_POST['tours_add_prod'])){
		$error = true;
		$messageStack->add('feedback', db_to_html('��ѡ�� ��ϣ����վ����רҵ�����β�Ʒ�⣬�����������Щ����������(�ɶ�ѡ)'));
	}
	if(strlen($_POST['tours_phone'])<5){
		$error = true;
		$messageStack->add('feedback', db_to_html('���������ĵ绰����'));
	}else{
		if($_POST['tours_phone']!=$_POST['tours_phone_re']){
			$error = true;
			$messageStack->add('feedback', db_to_html('����������ĵ绰���벻��'));
		}
	}
	
	$check_sql = tep_db_query('select feedback_id from feedback where customers_email_address ="'.tep_db_prepare_input($_POST['customers_email_address']).'" limit 1 ');
	$check_row = tep_db_fetch_array($check_sql);
	if($check_row['feedback_id']){
		$error = true;
		$messageStack->add('feedback', db_to_html('лл���Ĳ��룬��������'.$_POST['customers_email_address'].'�Ѿ��μӹ����飡'));
	}
	
	if($error==false){
		$sql_data=array('customers_email_address'=>tep_db_prepare_input($_POST['customers_email_address']),
						'tours_age'=>tep_db_prepare_input($_POST['tours_age']),
						'tours_gender'=>tep_db_prepare_input($_POST['tours_gender']),
						'tours_job'=>tep_db_prepare_input($_POST['tours_job']),
						'tours_like'=>tep_db_prepare_input($_POST['tours_like']),
						'tours_from'=>tep_db_prepare_input($_POST['tours_from']),
						'ServicesEval'=>tep_db_prepare_input($_POST['ServicesEval']),
						'tours_number'=>tep_db_prepare_input($_POST['tours_number']),
						'tours_add_server'=>tep_db_prepare_input($_POST['tours_add_server']),
						'tours_i_rec'=>tep_db_prepare_input($_POST['tours_i_rec']),
						'tours_consumer'=>tep_db_prepare_input($_POST['tours_consumer']),
						'tours_focus'=>tep_db_prepare_input($_POST['tours_focus']),
						'tours_add_prod'=>tep_db_prepare_input(implode(';',$_POST['tours_add_prod'])),
						'tours_site_improve'=>tep_db_prepare_input($_POST['tours_site_improve']),
						'tours_customer_name'=>tep_db_prepare_input($_POST['tours_customer_name']),
						'tours_phone'=>tep_db_prepare_input($_POST['tours_phone']),
						'add_date'=>date('Y-m-d H:i:s')
						);
		$sql_data = html_to_db($sql_data);
		tep_db_perform('feedback', $sql_data);
		
		foreach((array)$_POST['tours_add_prod'] as $key){
			if((int)$key){
				tep_db_query("INSERT INTO `feedback_add_prod` (`tours_add_prod` )VALUES ('".(int)$key."');");
			}
		}
		
		$email_text = "�𾴵� ���ķ����ͻ���\n\n" . "&nbsp;&nbsp;&nbsp;&nbsp;���Ĵ���ȯ���Ϊ��USD20 \n\n <b>��ע�⣺�˴���ȯ֧�ֵ���Ͷ������Ϊ$300��</b>������ĵ��Ŷ������С�$300���ô���ȯ������ʹ�ã�";
		$email_text .= "\n\n\n" . CONFORMATION_EMAIL_FOOTER;
		

		$to_email_address[0] = $_POST['customers_email_address'];
		$to_name = db_to_html('���ķ����ͻ�');
		$email_text = db_to_html(preg_replace('[\n\r\t]',' ',$email_text));
		$email_subject =db_to_html('usitrip ���ķ����ͻ�����ȯ��');
		$from_email_name ='usitrip';
		$from_email_address = 'service@usitrip.com';
		for($i=0; $i<count($to_email_address); $i++){
			@tep_mail($to_name, $to_email_address[$i], $email_subject, $email_text, $from_email_name, $from_email_address, 'true');
			//echo 'Send Ok!'.$to_email_address[$i].'<br />';
		}

		$hidden_feedback = true;
		//$messageStack->add('feedback', db_to_html('лл���Ĳ��룬�Ժ���鿴�������� '.$_POST['customers_email_address'].'�������Ѿ��Ѵ���ȯ���͵��������䣡'),'success');
		$messageStackStr = db_to_html('лл���Ĳ��룬�Ժ���鿴�������� '.$_POST['customers_email_address'].'�������Ѿ��Ѵ���ȯ���͵��������䣡�������1Сʱ����Ȼû���յ�����ȯ�ʼ�����ֱ�������ǵĿͷ���Ա��ϵ�� 400�绰��0086-4006-333-926');
	}
	
}


$content = 'customers-feedback';

require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
require(DIR_FS_INCLUDES . 'application_bottom.php');
?>
<?php
/**
 * @author yichi.sun@usitrip.com
 * @time 2011-08-18
 */
require('includes/application_top.php');
ini_set("max_execution_time", 7200);
set_time_limit(0);

if(!IS_LIVE_SITES){
	echo "������վ������ȡ���ж��ţ�";
	exit;
}

echo "���û��ظ��Ķ��ŷ��͵��ͷ�������service@usitrip.com"."\n\n";

!isset($GLOBALS['tmp_sms']) && $GLOBALS['tmp_sms'] = new cpunc_SMS;
$sms = $GLOBALS['tmp_sms'];
$moResult = $sms->getMO();
foreach($moResult as $mo){
	//$mo ��λ�� cpunc_sms.php ��� Mo ���� 	
 	$to_name = STORE_OWNER;
 	$to_email_address = STORE_OWNER_EMAIL_ADDRESS;
 	$sms_phone = trim($mo->getMobileNumber());
 	$email_subject = '�û�'.$sms_phone.'�ظ��Ķ���Ϣ ';
 	$sms_content = iconv("UTF-8","GB2312",$mo->getSmsContent());
 	$sms_time = $mo->getSentTime(); //��ʽ�磺20110819094119
	$sms_time = date('Y-m-d H:i:s', strtotime($sms_time));
 	$email_text = '';
 	$email_text .= 'Dear ' . STORE_OWNER . "\n\n";
	$email_text .= '&nbsp;&nbsp;&nbsp;&nbsp;�û��ظ��Ķ�����Ϣ���£�' . "\n" .
				   '&nbsp;&nbsp;&nbsp;&nbsp;�������ֻ��ţ�' . $sms_phone . "\n" .
				   '&nbsp;&nbsp;&nbsp;&nbsp;����ʱ�䣺' . $sms_time . "\n" .
				   '&nbsp;&nbsp;&nbsp;&nbsp;�������ݣ�' . $sms_content . "\n\n";
	
	$finance_phone = array('18982065453', '13808031192');
 	if(in_array($sms_phone, $finance_phone)){
 		$email_subject = 'From��ƣ���������'.$sms_time.'����֪ͨ'.' ';
 		$email_text = $sms_content.' ';
 	}
 	
 	$from_email_name = STORE_OWNER;
 	$from_email_address = STORE_OWNER_EMAIL_ADDRESS;
 	$mail_isNoReplay = true;
 	if(function_exists('tep_mail')){
 		tep_mail($to_name, $to_email_address, $email_subject, $email_text, $from_email_name, $from_email_address, 'true', 'gb2312');
 	}
 	else{
 		echo "�ʼ�û�з��ͳɹ���"."\n\n";
 	}
 	$sms->saveSMS($sms_phone, $sms_content, 0, 'b2m.cn-receive', $sms_time);
 	echo "�û� ".$sms_phone." �ظ��Ķ��ţ�".$sms_content."\n\n";
 	//$sms->saveSMS('13880695761', '����һ�·����ʼ�', 0, 'b2m.cn-receive', date('Y-m-d H:i:s'));
}

echo "Done";
?>
<?php
/**
 * ���ʶ���hi8d�����ݷ���ҳ
 */
//�������ǵ����ݿ��������
require('includes/application_top.php');
// ���÷�������
require('includes/classes/ensms.php');
try {
// ֱʵ�ķ��͵�ַ
	$a = new ensms('usitrip','a63b4be2106e3128057cae3ab7a6e2e4','http://www.sms01.com/ensms/servlet/WebSend','http://www.sms01.com/ensms/servlet/BalanceService',true);	
	// ����ǽ��շ���״̬��ҳ�棬���ж��Ƿ��з�������
	if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
		// ��¼���صķ���״̬
		$a->checkMsg($GLOBALS['HTTP_RAW_POST_DATA']);
	}
}catch (Exception $e) {
	echo $e->getMessage();
}
echo 1;
?>
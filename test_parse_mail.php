<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
require('includes/classes/mail_parse.php');
$email_name = isset($_GET['i']) ? $_GET['i'] : '';
if ($email_name == '') {
	exit('��������');
}
header('Content-Type:text/html;charset=utf-8');
try{
	$a = new mail_parse('/var/www/html/888trip.com/wwwroot/admin/email/'.$email_name);
	//ZC1709-tK47jWhAYZS3lQpaRm9ZD28.eml ZC0409-yNJpWL3AqF1~73Ag_1HOD28.eml ZC0815-uaO39RBBtEFquSZ2aCbge28.eml ZC2016-hZ8sM9anxjMfkQ5eV4OYL28.eml
	/*echo iconv('gb2312','utf-8//IGNORE','�ʼ�����:') . $a->get_subject() . '<br/>';
	echo iconv('gb2312','utf-8//IGNORE','�ʼ�������:<br/>');
	print_r($a->get_from());
	echo iconv('gb2312','utf-8//IGNORE','<br/>�ռ���:<br/>');
	print_r($a->get_to());
	echo iconv('gb2312','utf-8//IGNORE','<br/>���͸�:<br/>');
	var_dump($a->get_cc());
	echo iconv('gb2312','utf-8//IGNORE','<br/>�ʼ�����:<br/>'); 
	print_r($a->get_type());
	echo iconv('gb2312','utf-8//IGNORE','<br/>�ʼ���������:<br/>');
	print_r($a->get_date());
	echo iconv('gb2312','utf-8//IGNORE','<br/>�ʼ����뷽ʽ:<br/>');
	print_r($a->get_encode());
	echo iconv('gb2312','utf-8//IGNORE','<br/>�ʼ�����<br/>');*/
	//echo $a->get_other('separator');
	
	$a->format_mail_text();
	$from = $a->get_from();
	foreach ((array)$from as $key => $val) {
		echo 'form:' . $val . '&lt;' . $key . '&gt;<br/>';
	}
	echo 'Date:' . $a->get_date() . '<br/>';
	$to = $a->get_to();
	
	foreach ((array)$to as $key => $val) {
		echo 'to:' . $val . '&lt;' . $key . '&gt;<br/>';
	}
	echo 'subject:' . $a->get_subject() . '<br/>';
	$a->get_content();
	echo '<br/>attachment:<br/>';
	print_r($a->get_attachment());
	//echo '�ʼ��ı�����:' . $a->get_subject() . '<br/>';
	//$a->test();
}catch(Exception $e){
	header('Content-Type:text/html;charset=gb2312');
	var_dump($e);
	print_r($e);
}	
?>
<?php require(dirname(__FILE__).'/send_mail_funtoin.php'); ?>
<?php 
// set the level of error reporting
ini_set('display_errors', '1');
error_reporting(E_ALL & ~E_NOTICE);

$mail_to = '1773247305@qq.com';
$sendto_name = '����H�m�W�l�󤺮e';
$mail_title = '�l����D�l�󤺮e';
$mail_content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5" />
<title>Untitled Document</title>
</head>

<body>
<p>�گ�o�l��ܡH�i����ܹϤ����H</p>
<p><img src="http://www.google.cn/intl/zh-CN/images/logo_cn.gif" /> </p>
</body>
</html>
';

$code_array = array('gbk');

for($i=0; $i<count($code_array); $i++){
	// To send HTML mail, the Content-type header must be set 
	$sendto_email = $mail_to;	//����H�a�}
	$sendto_name = iconv('big5',$code_array[$i].'//IGNORE', $sendto_name);	//����H�m�W
	$subject = iconv('big5',$code_array[$i].'//IGNORE', $mail_title);			//�l����D
	$body = iconv('big5',$code_array[$i].'//IGNORE',$mail_content);//�l�󤺮e
	$FromName = iconv('big5',$code_array[$i].'//IGNORE','���|���');//�o��H�m�W
	
	$CharSet = $code_array[$i];//�l��s�X
	
	$send_state = smtp_mail($sendto_email, $sendto_name, $subject, $body, $CharSet, $FromName); 

}

echo 'Done';
?>
<?php
/*************************************************
APIError.php

Displays error parameters.

Called by DoDirectPaymentReceipt.php, TransactionDetails.php,
GetExpressCheckoutDetails.php and DoExpressCheckoutPayment.php.

*************************************************/
//Howard added{ 
define('INCLUDES_DIR',preg_replace('@/includes/.*@','',dirname(__FILE__))."/includes/");
require_once(INCLUDES_DIR."configure.php");
require_once(INCLUDES_DIR."functions/database.php");
tep_db_connect() or die('Unable to connect to database server!');
//����һЩ��Ҫ�ĺ�����
require_once(INCLUDES_DIR."functions/webmakers_added_functions.php");

//Howard added}

header("Content-type: text/html; charset=gb2312");
session_start();
$resArray=$_SESSION['reshash']; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN"><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta name="robots" content="noindex,nofollow">
<title>���ÿ�������ʾҳ��</title>
<link href="global.css" rel="stylesheet" type="text/css">

</head>

<body scroll="no" style="position:static;" bgcolor="#FFFFFF">
<style type="text/css">
/*��ת*/
#jump{	width:860px; position:absolute;left:50%;top:40%; margin:-229px 0 0 -430px;text-align:center; padding-top:20px; border:1px solid #e9e9e9;}
#jump h1{ display:inline;}
#jump .usitrip,#jump .usitrip h1{ font-size:24px; font-family:"΢���ź�",Arial, Helvetica, sans-serif; }
#jump td { text-align:left; padding-left:10px; }
.wait{ padding:0 40px; margin:10px auto;} 
.pop_copyright{ background:#f9f9f9; padding:20px 0; line-height:24px; color:#888;}
.wait .s_1{ padding:12px 0;}
.wait .s_2{ background:#ececec; height:16px; font-size:0; line-height:0; margin-bottom:7px;}
.wait .s_2 img{ width:243px; height:16px;}

</style>

<div id="jump">

<table width="280">
<tr>
		<td colspan="2" class="header">���ν��׳������´���</td>
	</tr>

<?php  //it will print if any URL errors 
	if(isset($_SESSION['curl_error_no'])) { 
			$errorCode= $_SESSION['curl_error_no'] ;
			$errorMessage=$_SESSION['curl_error_msg'] ;	
			session_unset();	
?>

   
<tr>
		<td>Error Number:</td>
		<td><?php echo $errorCode; ?></td>
	</tr>
	<tr>
		<td>Error Message:</td>
		<td><?php echo $errorMessage; ?></td>
	</tr>
	
	</center>
	</table>
<?php } else {

/* If there is no URL Errors, Construct the HTML page with 
   Response Error parameters.   
   */
?>

	<font size=2 color=black face=Verdana><b></b></font>
	<br><br>

	<b><img src="images/err.gif" /> ���ÿ�֧������</b><br><br>
	
    <table width ="600">
    <?php 
    
    //require 'ShowAllResponse.php';
    ?>
	<?php 
    //������Ϣ���Ļ�����
	$error_key = array( 'L_LONGMESSAGE0'  => '��������',
						'L_SHORTMESSAGE0' => '��������',
						'ACK' => '���׽��',
						'AMT' => '���׽��',
						'CURRENCYCODE'=>'����',
						'L_ERRORCODE0'=>'�������'
						); 
	$error_value = array('This transaction cannot be processed. Please enter a valid credit card number and type.'=>'������޷�������������Ч�����ÿ��ĺź����͡�',
						'Invalid Data'=>'��Ч���ݡ�',
						'Failure'=>'ʧ��',
						"Payer's account is denied"=>"�����ÿ��ſ��������⣬�ѱ�ϵͳ���գ�",
						"This transaction cannot be processed. Please use a valid credit card."=>'������޷�������������Ч�����ÿ���',
						'This transaction cannot be processed.' => "������޷�������ȷ�����ÿ���Ч���޻�CCV��֤���Ƿ������⡣"); 
	foreach($resArray as $key => $value) {
    	
		echo "<tr><td> ".strtr($key, $error_key).":</td><td>".strtr($value, $error_value)."</td>";
    }	
      ?>
    </table>
	
<?php 
}// end else
?>

<?php
if((int)$_GET['order_id']){

$_url = HTTP_SERVER.'/account_history_payment_method.php?order_id='.(int)$_GET['order_id'];
if(isset($_GET['remark2']) && $_GET['remark2']!=""){
	$_url = HTTP_SERVER.'/orders_travel_companion_info.php?order_id='.(int)$_GET['order_id'];
}

?>
<a class="home" id="CallsLink" href="DoDirectPayment.php?paymentType=Sale&order_id=<?php echo (int)$_GET['order_id']?>">�����ٴν���</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a class="home" href="<?php echo $_url?>">��������֧����ʽ</a>

<?php }?>

</div>

</body>
</html>
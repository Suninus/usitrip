<?php
set_time_limit(0);
require('includes/application_top.php');
// ��ע���ɾ��
if($_GET['ajax']=="true"){
	include DIR_FS_CLASSES . 'Remark.class.php';
	$remark = new Remark('offers_sms_notification');
	$remark->checkAction($_GET['action'], $login_id);//���ɾ��������ͳһ�ڷ������洦����
}
/* admin_files�� ��������  offers_sms_notification.php 0 5 1,28  */
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script type="text/javascript" src="includes/jquery-1.3.2/jquery-1.3.2.min.js"></script>
</head>

<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<?php
//echo $login_id;
include DIR_FS_CLASSES . 'Remark.class.php';
$listrs = new Remark('offers_sms_notification');
$list = $listrs->showRemark();
?>
<?php if(empty($_POST['content'])){ ?>
<form  action="offers_sms_notification.php"  method="post" name="name">
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="col_b1"><?php echo db_to_html('�Żݻ����֪ͨ:'); ?></td>
	 <tr><td class="col_b1"><textarea rows="10" name="content" cols="49" onFocus="if (value=='���ķ��������Żݻ�� ������Чʱ��Ϊ�� ������ӭ����½���ķ����˽�����Ż����飬�������У��ɴ˿�ʼ��'}" >���ķ��������Żݻ�� ������Чʱ��Ϊ�� ������ӭ����½���ķ����˽�����Ż����飬�������У��ɴ˿�ʼ��</textarea ></td></tr>
        <tr><td class="col_b1">
		<?php if($can_send_sms_to_customers === true){?>
		<input type="submit" value='send' />
		<?php }else{?>
		<input type="submit" value='send' disabled />
		<?php }?>
		</td></tr> 
    </tr>
</form>
<?php 
}
elseif(0){
	include('sms_send.php');
	$customer_sql = "select confirmphone, customers_cellphone, customers_mobile_phone, customers_telephone from customers where customers_notice = 1";
	$customer_query = tep_db_query($customer_sql);
	while($row_customer_info = tep_db_fetch_array($customer_query)){
		$phone = '';
		$result = check_phone($row_customer_info['confirmphone']);
		if(!empty($result))$phone = $result[0];
		else{
			$result = check_phone($row_customer_info['customers_cellphone']);
			if(!empty($result))$phone = $result[0];
			else{
				$result = check_phone($row_customer_info['customers_mobile_phone']);
				if(!empty($result))$phone = $result[0];
				else{
					$result = check_phone($row_customer_info['customers_telephone']);
					if(!empty($result))$phone = $result[0];
				}
			}
		}
		
		if(!empty($phone)){
			$content = $_POST['content'];
		    if(sms_send($phone,$content)=='1'){
		    	echo $phone.'�ÿ͵��Żݻ���ŷ��ͳɹ���';
			}
			else{
				echo $phone.'�ÿ͵��Żݻ���ŷ���ʧ�ܣ�';
			}
		}
	}
}
?>
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
<?php
require('includes/application_top.php');
//���ݶ������ж��Ƿ�ͨ�� COUPON CODE ������Ӷ��
function get_commission_source($order_id){
	$sql = "select title from orders_total where class='ot_coupon' and orders_id=" . (int)$order_id;
	$result = tep_db_query($sql);
	$row = tep_db_fetch_array($result);
	if ($row) {
		return true;
	}
	return false;
}

$action = strtolower($_GET['action']);
$affiliate_id = (int)$_GET['affiliate_id'];
$action == 'ispay' ? $title = '�Ѹ����б�' : $title = 'δ�����б�';

//SQL��ѯ start {
$fields = ' afs.affiliate_payment_date,afs.affiliate_orders_id,afs.affiliate_ipaddress,afs.affiliate_payment,ap.affiliate_paid_date ';
$tables = ' affiliate_sales as afs,affiliate_payment as ap ';
$where = ' where afs.affiliate_payment_id = ap.affiliate_payment_id and afs.affiliate_billing_status=1 ';
$order_by = ' order by afs.affiliate_payment_date desc ';
if($_GET['affiliate_id']){
	$affiliate_id = (int)$_GET['affiliate_id'];
	$where.= ' and afs.affiliate_id="' . $affiliate_id.'" ';
}
if($_GET['affiliate_payment_id']){
	$affiliate_payment_id = (int)$_GET['affiliate_payment_id'];
	$where.= ' and afs.affiliate_payment_id="' . $affiliate_payment_id.'" ';
}
if($action == 'ispay'){
	$where.= ' and ap.affiliate_payment_status=1 ';
}else{
	$where.=  ' and ap.affiliate_payment_status<>1 ';
}

$sql = "select  " .$fields. " from  ".$tables. $where . $order_by;
$result = tep_db_query($sql);

//SQL��ѯ end }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title>�������� -- <?php echo $title ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css" />
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/big5_gb-min.js"></script>
<script language="javascript" src="includes/javascript/add_global.js"></script>
<script type="text/javascript" src="includes/jquery-1.3.2/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="includes/javascript/calendar.js"></script>
<style type="text/css">
#connter{width:960px;margin:0 auto;}
table{border-collapse:collapse;border-spacing:0;}
table th,#TableList td{border:1px solid #DCDCDC;background:#eee;line-height:25px;}
#TableList td{background:#fff; text-align:center;}
</style>
</head>

<body>
<?php
require(DIR_WS_INCLUDES . 'header.php'); 
if ($messageStack->size > 0) {
	echo $messageStack->output();
}
?>
<div id="connter">
<div><h1><?php echo $title;?></h1></div>
<div style="padding:10px; text-align:right"><a class="a_btn" href="<?php echo $_SERVER['HTTP_REFERER']?>">����</a></div>
<table width="100%" id="TableList">
	<tr>
		<th>���ɱ���ʱ��</th>
		<th>������</th>
		<th>����ʱIP</th>
		<th>����ʱ��</th>
		<th>Ӷ����</th>
		<th>Ӷ����Դ</th>
		<th>֧������</th>
	</tr>
	<?php
	$total_money = 0;
	while ($row = tep_db_fetch_array($result)) {
		$total_money += $row['affiliate_payment'];
	?>
	<tr>
		<td><?php echo $row['affiliate_payment_date'];?></td>
		<td><a target="_blank" href="<?= tep_href_link('edit_orders.php','oID='.(int)$row['affiliate_orders_id'])?>"><?php echo $row['affiliate_orders_id'];?></a></td>
		<td <?php if(in_array($row['affiliate_ipaddress'], explode(',','24.176.192.22, 65.60.88.74,207.145.170.146,76.89.193.251,183.63.48.194,113.106.94.150,120.136.45.200,173.255.216.188'))){?> style="color:#F00" <?php }?>>
		<?php
		echo $row['affiliate_ipaddress'];
		?>
		</td>
		<td><?php echo tep_get_date_of_departure($row['affiliate_orders_id'])?></td>
		<td><?php echo $row['affiliate_payment'];?></td>
		<td><?php if (get_commission_source($row['affiliate_orders_id'])) {
			echo 'COUPON CODE';
		} else {
			echo '����';
		}?></td>
		<td><?php echo $row['affiliate_paid_date']?></td>
	</tr>
	<?php
	}?>
	<tr>
	<td colspan="3" style="text-align:right">&nbsp;</td>
	<td colspan="4" style="text-align:left;">&nbsp;<b>�ϼƣ�<?php echo $total_money;?></b></td>
	</tr>
</table>
</div>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>


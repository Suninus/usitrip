<?php
//���ŷ��͹���ҳ��

//ע�⣺

//���ڷ�������δ��ʽȷ��������Ŀǰ�����͵����������д�ġ�
//������ȷ������Ҫ���ļ���������滻����

set_time_limit(0);
require('includes/application_top.php');
header("Content-type: text/html; charset=".CHARSET."");
if($_POST['post']==1){
	include('sms_send.php');
	$phone = $_POST['phone'];
	if(trim($phone)==''){
		exit('û����дҪ���͵ĺ��룡');
	}
	$content = $_POST['content'];
	if(trim($content)==''){
		exit('û����дҪ���͵����ݣ�');
	}
	$return = sms_send($phone,$content);
	if($return == 1){
		echo '<h1 style="color:blue;">���ŷ��ͳɹ���</h1>';
	}else if($return == 2){
		echo '<h1 style="color:blue;">���Ų��ַ��ͳɹ���</h1><br><h1 style="color:red;">���Ų��ַ���ʧ�ܣ�</h1>';
	}else{
		echo '<h1 style="color:red;">���ŷ���ʧ�ܣ�</h1>';
	}
}else{
	
$content_ext = '�𾴵Ŀ��ˣ����ã�';

$smsData = array();
/*
$smsData[$sms]['title'] = '����';
$smsData[$sms]['change'] = 0/1;Ϊ1���ʾ��$sms�����⣬����Ҫ�����κβ���������Ϊ0
$smsData[$sms]['content'] = 'sprintf����';
*/

$smsData['HotelYZ']['title'] = '���������Ƿ���ס�Ƶꡢ���α���';
$smsData['HotelYZ']['change'] = 0;
$smsData['HotelYZ']['content'] = '���Ķ�����#%s���г̣�%s[%s]���Ƿ���Ҫ��ס�Ƶꡢ���α��գ�������Ҫ������ϵ���ǿͷ���';

$smsData['AirportShuttle']['title'] = '������/�ͷ������ȷ��';
$smsData['AirportShuttle']['change'] = 0;
$smsData['AirportShuttle']['content'] = '���Ķ�����#%s���г̣�%s[%s]�Ļ������������ǣ�%s,���в���������ϵ�ͷ���';

$smsData['HotelAddr']['title'] = '�г�ס�޾Ƶ꼰λ�ö���ȷ��';
$smsData['HotelAddr']['change'] = 0;
$smsData['HotelAddr']['content'] = '���Ķ�����#%s���г̣�%s[%s]��ס�޾Ƶ꼰λ���ǣ�%s,���в���������ϵ�ͷ���';

$smsData['ItineraryEnd']['title'] = '�û��г̽���-�����ʺ������ٴε�¼';
$smsData['ItineraryEnd']['change'] = 1;
$smsData['ItineraryEnd']['content'] = '�����г��ѽ�����ϣ������г����⣬����������飬����ϵ���ǵĿͷ��������ٴε�¼208.109.123.18,���߳�Ϊ������';

$smsData['NoLogin']['title'] = '�û�����û�е�¼-�����ʺ������ٴε�¼';
$smsData['NoLogin']['change'] = 1;
$smsData['NoLogin']['content'] = '�����Ѿ�����û�е�½���ǵ���վ�������ٴε�¼208.109.123.18,����������飬����ϵ���ǵĿͷ������߳�Ϊ������';

$smsData['NoOrder']['title'] = '�û�����û���µ�-�����ʺ������ٴε�¼';
$smsData['NoOrder']['change'] = 1;
$smsData['NoOrder']['content'] = '�����Ѿ�����û���µ��ˣ������ٴε�¼208.109.123.18,����������飬����ϵ���ǵĿͷ������߳�Ϊ������';

$sms = $_GET['sms'];
$stitle=$title = '���ŷ���';
$phone = '';
$haveSMS = false;
if($smsData[$sms]){
	$haveSMS = true;
	$stitle = $title = $smsData[$sms]['title'].' - '.$title;
	$title && $title .= ' - ';
	
	switch($sms){
		case 'HotelYZ':
			$orderid = intval($_GET['orderid']);
			$products_id = intval($_GET['products_id']);
			$sql = "SELECT 
					o.`orders_id`,o.`customers_id`,o.`customers_name`,
					c.`customers_firstname`,c.`customers_lastname`,c.`customers_email_address`,c.`confirmphone`,
					p.`products_id`,p.`products_model`,p.`products_name`
					
					FROM `orders` o,`customers` c,orders_products p
					WHERE o.`orders_id`=p.`orders_id` and o.`customers_id`=c.`customers_id` 
					and o.`orders_id`='{$orderid}' and p.`products_id`='{$products_id}'";
			$query = tep_db_query($sql);
			$Return_Data = tep_db_fetch_array($query);
			$phone = $Return_Data['confirmphone'];
			$Return_Data['products_name1']=strstr($Return_Data['products_name'], '**');
			if($Return_Data['products_name1']!='' && $Return_Data['products_name1']!==false){
				$Return_Data['products_name']=str_replace($Return_Data['products_name1'],'',$Return_Data['products_name']);
			}
			$content = sprintf($smsData[$sms]['content'],$orderid,$Return_Data['products_model'],$Return_Data['products_name']);
			break;
		case 'AirportShuttle':
			$orderid = intval($_GET['orderid']);
			$products_id = intval($_GET['products_id']);
			$sql = "SELECT 
					o.`orders_id`,o.`customers_id`,o.`customers_name`,
					c.`customers_firstname`,c.`customers_lastname`,c.`customers_email_address`,c.`confirmphone`,
					p.`products_id`,p.`products_model`,p.`products_name`,
					opat.*
					FROM `orders` o,`customers` c,orders_products p,`orders_products_airport_transfer` opat
					WHERE o.`orders_id`=p.`orders_id` and o.`orders_id`=opat.`orders_id` and o.`customers_id`=c.`customers_id` 
					and o.`orders_id`='{$orderid}' and p.`products_id`='{$products_id}'";
			$query = tep_db_query($sql);
			$Return_Data = tep_db_fetch_array($query);
			$phone = $Return_Data['confirmphone'];
			$Return_Data['products_name1']=strstr($Return_Data['products_name'], '**');
			if($Return_Data['products_name1']!='' && $Return_Data['products_name1']!==false){
				$Return_Data['products_name']=str_replace($Return_Data['products_name1'],'',$Return_Data['products_name']);
			}
			$airport_content = '###���ͻ�����###';
			$content = sprintf($smsData[$sms]['content'],$orderid,$Return_Data['products_model'],$Return_Data['products_name'],$airport_content);
			break;
		case 'HotelAddr':
			$orderid = intval($_GET['orderid']);
			$products_id = intval($_GET['products_id']);
			$ext_hotel_id = intval($_GET['ext_hotel_id']);
			$sql = "SELECT 
					o.`orders_id`,o.`customers_id`,o.`customers_name`,
					c.`customers_firstname`,c.`customers_lastname`,c.`customers_email_address`,c.`confirmphone`,
					p.`products_id`,p.`products_model`,p.`products_name`,
					opeh.*
					FROM `orders` o,`customers` c,orders_products p,`orders_products_extended_hotel` opeh
					WHERE o.`orders_id`=p.`orders_id` and o.`orders_id`=opeh.`orders_id` and o.`customers_id`=c.`customers_id` 
					and o.`orders_id`='{$orderid}' and p.`products_id`='{$products_id}' and opeh.`extended_hotel_id`='{$ext_hotel_id}'";
			$query = tep_db_query($sql);
			$Return_Data = tep_db_fetch_array($query);
			$phone = $Return_Data['confirmphone'];
			$Return_Data['products_name1']=strstr($Return_Data['products_name'], '**');
			if($Return_Data['products_name1']!='' && $Return_Data['products_name1']!==false){
				$Return_Data['products_name']=str_replace($Return_Data['products_name1'],'',$Return_Data['products_name']);
			}
			$exthotel_content = '###ס�޾Ƶ꼰λ������###';
			$content = sprintf($smsData[$sms]['content'],$orderid,$Return_Data['products_model'],$Return_Data['products_name'],$exthotel_content);
			break;
		case 'ItineraryEnd':
			$phone = array();
			$start_date = '2009-03-01 00:00:00';
			$space_day_num = 0;
			$ToDay = date('Y-m-d');
			$query = tep_db_query('SELECT 
								  o.orders_id,o.customers_id ,
								  c.`customers_firstname`,c.`customers_lastname`,c.`customers_email_address`,c.`confirmphone`
								  FROM `orders`o,`customers` c 
								  WHERE o.orders_status="100006" AND o.date_purchased > "'.$start_date.'"
								  And c.customers_id=o.customers_id and c.`confirmphone`!=""');
			while($orders_rows = tep_db_fetch_array($query)){
				$orders_prod_sql = tep_db_query('SELECT 
												p.products_durations,p.products_durations_type,op.products_departure_date
												FROM `orders_products` op,`products` p 
												WHERE  p.products_id=op.products_id AND op.orders_id="'.(int)$orders_rows['orders_id'].'" 
												Group By op.orders_id Order By op.products_departure_date DESC Limit 1');
				$orders_prod_row = tep_db_fetch_array($orders_prod_sql);
				if(!(int)$orders_prod_row['products_durations_type']){
					$back_date_max = date('Y-m-d', strtotime('-'.($orders_prod_row['products_durations']+$space_day_num).' day')). ' 00:00:00';
				}elseif((int)$orders_prod_row['products_durations_type']=='1'){
					$back_date_max = date('Y-m-d', strtotime('-'.(round($orders_prod_row['products_durations']/24, 1)+$space_day_num).' day')). ' 00:00:00';
				}elseif((int)$orders_prod_row['products_durations_type']=='2'){
					$back_date_max = date('Y-m-d', strtotime('-'.(round($orders_prod_row['products_durations']/24/60, 1)+$space_day_num).' day')). ' 00:00:00';
				}
				if($back_date_max >= $orders_prod_row['products_departure_date']){
					$phone[]=$orders_rows['confirmphone'];
				}
			}
			$phone = array_unique($phone);
			$phone = join(',',$phone);
			$content =$smsData[$sms]['content'];
			break;
		case 'NoLogin':
			$nologinCheckTime = time() - 183*24*60*60;
			$nologinCheckTime = date("Y-m-d H:i:s",$nologinCheckTime);
			$phone = array();
			$sql = "SELECT c.`customers_id`,c.`customers_firstname`,c.`customers_lastname`,c.`customers_email_address`,c.`confirmphone` FROM `customers` c,customers_info ci WHERE c.customers_id=ci.customers_info_id and ci.customers_info_date_of_last_logon<'{$nologinCheckTime}'";
			$query = tep_db_query($sql);
			while($rt = tep_db_fetch_array($query)){
				$phone[]=$rt['confirmphone'];
			}
			$phone = array_unique($phone);
			$phone = join(',',$phone);
			$content =$smsData[$sms]['content'];
			break;
		case 'NoOrder':
			$nologinCheckTime = time() - 183*24*60*60;
			$nologinCheckTime = date("Y-m-d H:i:s",$nologinCheckTime);
			$phone = array();
			$sql = "SELECT * from (SELECT c.`customers_id`,c.`customers_firstname`,c.`customers_lastname`,c.`customers_email_address`,c.`confirmphone`,max(o.date_purchased) as date_purchased FROM `customers` c,orders o WHERE c.customers_id=o.customers_id group by c.customers_id)tmp where date_purchased<'{$nologinCheckTime}'";
			$query = tep_db_query($sql);
			while($rt = tep_db_fetch_array($query)){
				$phone[]=$rt['confirmphone'];
			}
			$phone = array_unique($phone);
			$phone = join(',',$phone);
			$content =$smsData[$sms]['content'];
			break;
	}
	if($phone == ''){
		exit('û�пɷ��͵ĺ��룡');
	}else{
		$content = $content_ext.$content;	
	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo $title.TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css" />
<script type="text/javascript" src="includes/javascript/spiffyCal/spiffyCal_v2_1_2008_04_01-min.js"></script>
<script type="text/javascript" src="includes/menu.js"></script>
<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript" src="includes/jquery-1.3.2/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="includes/javascript/add_global.js"></script>
<script type="text/javascript" src="includes/javascript/categories.js"></script>
<script type="text/javascript" src="includes/big5_gb-min.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<div id="spiffycalendar" class="text"></div>
<?php require(DIR_WS_INCLUDES . 'header.php');?>
<style>
table#sendsmstab {background:#CCC;}
table#sendsmstab td {padding:5px;background:#FEFBED;}
table#sendsmstab td.head{ font-weight:bold; font-size:14px;background: none repeat scroll 0 0 #619FD4; color:#fff;}
</style>
<script type="text/javascript">
function check_sms(obj){
	obj = jQuery(obj);
	var val = jQuery.trim(obj.val());
	if(val!=''){
		var change = obj.find("option:selected").attr('change');
		if(change==1){
			window.location = '?sms='+val;
		}else{
			alert('�޲������˹��ܲ���ֱ����������У�');	
			obj.val('<?php echo $sms;?>');
		}
	}
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td>
<form action="" method="post">
    <table id="sendsmstab" width="800" border="0" cellpadding="10" cellspacing="1">
  <tr>
    <td colspan="2" class="head"><?php echo $stitle;?></td>
    </tr>
  <tr>
    <td width="128">���ŷ��͹��ܣ�</td>
    <td width="629"><select name="sms" id="sms" onchange="check_sms(this)">
    <?php if(!$haveSMS){?>
    <option value="">��ѡ��</option>
    <?php 
	}
	foreach($smsData as $key=>$val){
	?>
    	<option value="<?php echo $key;?>" change="<?php echo $val['change'];?>"<?php if($key==$sms){?> selected<?php }?> <?php if($val['change']==0){?> style="background-color:#CCC;"<?php }?>>
		<?php echo $val['title'];?>
        </option>
    <?php
	}
	?>
    </select></td>
  </tr>
  <tr>
    <td>Ҫ���͵ĺ��룺</td>
    <td><?php 
	$readonly = '';
	$smsData[$sms]['change']==0 && $readonly = ' readonly="readonly" onkeypress="return false;" onpaste="return false;" ';//firefox
	echo tep_draw_textarea_field('phone','wrap','40','5',$phone, ' class="textarea"'.$readonly);
	?><br />
*��������á�,���ŷָ���<?php if($smsData[$sms]['change']==0){?><font color="red">�����޸ķ��ͺ��룡</font><?php }?></td>
  </tr>
  <tr>
    <td>���͵����ݣ�</td>
    <td><?php echo tep_draw_textarea_field('content','wrap','40','5',$content, ' class="textarea"');?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><button class="Allbutton" type="submit">ȷ�����Ͷ���</button></td>
    </tr>
    </table>
<input type="hidden" name="post" value="1" />
</form>
    </td>
  </tr>
</table>
</body>
</html>
<?php }?>
<?php
require('includes/application_top.php');
require('includes/classes/visa.php');

$visa = new visa();

//��̨����Ա�µ���·��,�����ض�����
if($_GET['action'] == 'order')
{
//	$postdata=false;
//	$postdata['vis_tag_name']=$_POST['vis_tag_name'];
//	$postdata['orders_id']=$_POST['orders_id'];
//	$postdata['tdate']=$_POST['tdate'];
//	$postdata['vis_to_date']=$_POST['vis_to_date'];
//	$postdata['vis_req_date']=$_POST['vis_req_date'];	

	if( (int)$_POST['visa_random_number'] == (int)$_SESSION['visa_random_number'])
	{
		echo 'ERROR: re-submit';
		exit();
	}
	
	$_SESSION['visa_random_number']=(int)$_POST['visa_random_number'];
	
	$visa_id = $visa->visa_order_admin($_POST,$login_id);
	if ($visa_id ==0)
	{
		echo 'error';
	}
	else
	{
		echo '<br/><br/>';
		echo 'ǩ֤��������: <span style="font-size:24px; font-bolder:bolder; font-family:Arial; color:#0000FF;">'.$visa_id .'</span>';
		echo '<hr/><br/>�����ύ�ɹ���,����ˢ�´�ҳ��,���������ظ��µ�.<br/><br/>'.date('Y-m-d H:i:s');
		echo '<br/><br/><a href="edit_orders.php?language=sc&oID='.$_POST['orders_id'].'&action=edit">���ض�������ҳ��</a>';
	}
	exit();
}

//��̨����Ա�ֶ�����visa�����б����ķ����ݿ�
if($_GET['action'] == 'updatelistfromlujia')
{
	$rt = $visa->visa_update_order_list_fromlujia();
	if(true == $rt['result'])
	{
		echo 'һ��������'.$rt['inserted_count'].'�ʶ�������<hr/>'.date('Y-m-d H:i:s');
		echo '<br/><a href="javascript: history.go(-1)">��  ��</a>';
	}
	else
	{
		echo '<span style="color:#FF0000">ERROR:<br/>'.$rt['error_msg'].'</span><hr/>'.date('Y-m-d H:i:s');
	}
	exit();
}

//��̨����Աȥvisaϵͳ�鿴���˵Ķ����б�
if($_GET['action'] == 'admin_goto_view_customer_visa_order')
{
	$ORD_ID = $_GET['ORD_ID'];
	
	$visa_info = $visa->admin_goto_view_customer_visa_order($ORD_ID);
	
	if(is_array($visa_info))
	{
		$url = VISA_DOMAIN . $visa_info['URL_VISA_ORDER_LIST'];
		//echo $url;
		tep_redirect($url);
	}
	else
	{
		echo 'error:��Ա�˺��Ҳ���';
	}

	exit();
}


$_SESSION['visa_random_number']=0;

$download = (int)$_GET['download'];

if($download == "1"){
	$filename = 'visa_order_'.date("YmdHis").'.xls';
	header("Content-type: text/html; charset=utf-8");	//��utf-8��ʽ���ز���
	//header("Content-type: text/x-csv");
	header("Content-type: application/vnd.ms-excel");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Transfer-Encoding:binary");
	header("Content-Disposition: attachment;filename=".$filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
	header("HTTP/1.0 200 OK");
	header("Status: 200 OK");
}

if($download != "1"){
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?>----VISA��̨�µ�/�����鿴----�ڲ�ʹ��</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/big5_gb-min.js"></script>
<script language="javascript" src="includes/javascript/add_global.js"></script>
<!--<script type="text/javascript" src="includes/jquery-1.3.2/jquery-1.3.2.min.js"></script>//-->
<script type="text/javascript" src="includes/javascript/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="includes/javascript/calendar.js"></script>
<script language="javascript" type="text/javascript">
</script>
<style type="text/css">
.tbList { border:1px solid #CCCCCC; border-collapse:collapse; font-size:14px;}
.tbList th{ background-color:#006699; color:#FFFFFF; font-weight:bolder; font-size:90%; border:1px solid #CCCCCC; padding:3px;}
.tbList td{ border:1px solid #CCCCCC; padding:3px; font-size:90%;}
.tbList td span.imp2{color:#FF0000; font-weight:bolder;}
.tbList td span.imp1{color:#FF0000; font-weight:normal;}
.tbList td span.imp0{color:#000000; font-weight:normal;}
.tbList tr.bc{ background-color:#EEEEEE}
.tbList .finish{color:#0000FF;}
.tbList .remark{color:#666666; font-weight:normal; font-size:80%;}

ul.admin_list{float:left;}
ul.admin_list li{float:left; width:180px; margin:5px 5px;}
ul.admin_list a,ul.admin_list a:visited{padding:3px;}
ul.admin_list a:hover{background-color:#0000FF; color:#FFFFFF;}

input.formbox{width:200px;}

a:hover{font-weight:normal; color:#FF0000;}
</style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<?php 
	require(DIR_WS_INCLUDES . 'header.php');
}
//Ĭ���Ǻ�̨��ǩ֤����
if($_GET['action'] == 'list'){
/*
 * aben,2012-3-23
 * ���������hearer.php,��Ͳ�����д�����echo $messageStack->output();�ͼ���includes/big5_gb-min.js
 * */
//require(DIR_WS_INCLUDES . 'header.php');
  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }
?>
<script type="text/javascript" src="includes/big5_gb-min.js"></script>
<!-- header_eof //-->
<h2>�������µ�,Ĭ�������տ��, ��ȷ���Ѿ��յ�ǩ֤�ķ��ú����µ�.</h2>
ǩ֤�����б�(����ֻ��ʾ��̨�µ�����ʷ��¼):
<table class="tbList">
  <tr><th>VISA������</th><th>����Ŀ��</th><th>�µ�ʱ�ύ����Ϣ</th><th>�µ���</th><th>����ʱ��</th></tr>
<?php
$orders_id = $_GET['orders_id'];
$data = $visa->get_visa_order_list($orders_id);


$n = ($data == false) ? 0 : count($data);

for($i = 0; $i < $n; $i++)
{
?>
  <tr>
	<td><?php echo $data[$i]['visa_orderid'];?></td>
	<td><?php echo $data[$i]['vis_tag_name'];?></td>
	<td><?php echo $data[$i]['orders_info'];?></td>
	<td><?php echo $data[$i]['admin_job_number'];?></td>
	<td><?php echo $data[$i]['add_date'];?></td>
  </tr>
<?php
}
;?>
</table>
<?php
//print_r(preg_split("//",'��ѡ�����Ŀ��',-1, PREG_SPLIT_NO_EMPTY));
$data = false;
$data = $visa->prepare_info_for_visa($orders_id);
if (!is_array($data)){
	echo 'Error: order not list';
	exit();
}

$products= $visa ->get_visa_product_list();

?>
<script type="text/javascript" language="javascript">
function checkForm()
{
  var TAG_NAME=document.getElementById("vis_tag_name").options[document.getElementById("vis_tag_name").selectedIndex].value;
  if(TAG_NAME.length==0){ alert("��ѡ�����Ŀ��"); return false; }

  var tdate=document.getElementById("tdate").value;
  var VIS_TO_DATE=document.getElementById("vis_to_date").value;
  var VIS_REQ_DATE=document.getElementById("vis_req_date").value;
  if(tdate.length==0){ alert("��ѡ���������"); return false; }
  if(VIS_TO_DATE.length==0){ alert("��ѡ��Ԥ�Ƹ�������"); return false; }
  if(VIS_REQ_DATE.length==0){ alert("��ѡ��ϣ��ǩ֤����"); return false; }
  if(!confirm("��ȷ��Ҫ�ύ��?")){ return false; }
}
</script>
<br/>
<?php if ($n <= 0) {?>
<form action="visa.php?action=order" method="post" name="form1" onSubmit="return checkForm()">

<input name="visa_random_number" type="hidden" value="<?php echo rand(1,65535); ?>">
<input name="customers_id" type="hidden" value="<?php echo $data['customers_id'];?>"/>
<table width="775" border="1" cellpadding="0" cellspacing="0" class="tbList">
<tr><td width="116">����Ŀ��:</td>
<td width="647">

<select name="vis_tag_name" id="vis_tag_name" style="width:400px;">
  <option>-------------</option>
  <?php
  foreach($products AS $key=>$values)
  {
  ?>
  <option value="<?php echo $values['visa_vis_tag_name'].','.$values['visa_srv_unid'];?>"><?php echo $values['visa_purpose'].'___________��'.$values['visa_product_price'];?></option>
  <?php
  }
  ?>
</select>
<span style="color:#FF0000">*</span></td></tr>
<tr><td>������:</td><td><input name="orders_id" type="text" value="<?php echo $orders_id;?>" readonly=""/>
</td>
</tr>
<tr>
	<td>�ͻ�����:</td>
	<td><span style="color:#FF0000">�����г��˱������������г���Ա,�밴��ѡ��. ѡ�к�,�����޸�</span>
	<?php
	$i_guest=0;
	if (is_array($data)) {
	foreach($data['products'] AS $key=>$value)
	{
	?>
	<br/><b><?php echo $value['products_model'].' '.$value['products_name']; ?></b>
	<br/>
		<?php  
		$guest_name_arr = false;
		$guest_name_arr = $visa ->order_guest_name_fromstring_toarray( $value['guest_name'] );
		foreach($guest_name_arr AS $key2=>$value2)
		{
			//print_r($value2);
			if(count($value2[1])>0){
		?>
			<input type="checkbox" onClick="document.getElementById('guest_name_<?php echo $i_guest;?>').disabled=!this.checked;">
			<input name="guest_name[]" type="text" value="<?php echo $value2[1]?>" id="guest_name_<?php echo $i_guest;?>" disabled="disabled"><br/>
		<?php
				$i_guest +=1;
			}
		}
		?>
	<?php
	}
	}
	?>

	</td>
</tr>
<tr><td>��������:</td>
	<td><input name="tdate" id="tdate" type="text" value="<?php echo date("Y-m-d",strtotime($data['tdate']));?>"
	readonly="" onClick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);"/><span style="color:#FF0000">*</span>
	</td></tr>
<tr>
	<td>Ԥ�Ƹ������ڣ�</td>
	<td><input name="vis_to_date" id="vis_to_date" type="text" value="<?php echo date("Y-m-d",strtotime($data['tdate']));?>"
 readonly="" onClick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);"/><span style="color:#FF0000">*</span>
	</td>
</tr>
<tr>
	<td>ϣ��ǩ֤���ڣ�</td>
	<td><input name="vis_req_date" id="vis_req_date" type="text" value="" readonly=""
	onclick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);"/><span style="color:#FF0000">*</span>
	</td>
</tr>
<tr><td></td><td><input name="submit" type="submit" value="submit" /></td></tr>
</table>
</form>
<?php
}
}

if($_GET['action'] == 'vieworderlist'){
	$updatetimestring = $visa->get_updatetimestring_list();
	if(is_array($updatetimestring))
	{
?>
<form name="form1" action="visa.php?action=vieworderlist" method="get">
<?php echo tep_draw_hidden_field('action',$_GET['action']);?>
<fieldset>
	<legend>��ʾ����ʱ���б�</legend>
    ����ʱ���: 
	<?php 
	echo tep_draw_pull_down_menu('updatetimestring',  $updatetimestring,'','id="updatetimestring" '); ?>
	<input type="submit" value="Query">
</fieldset>

</form>
<?php
		$updatetimestring = tep_db_prepare_input($_GET['updatetimestring']);
		if (strlen($_GET['updatetimestring'])>0 )
		{
			$data_ordermain = $visa->get_visa_ordermain_list($updatetimestring);
			//print_r($data_ordermain);
			if(is_array($data_ordermain))
			{
?>
				<table class="tbList">
					<tr>
						<th title="ORD_ID">VISA������</th>
						<th>VISA��Ϣ</th>
						<th>���ķ�������</th><th>��Աemail</th><th>��Ա����</th>
						<!--<th>ORD_USR_STA_TAG</th><th>ORD_ADM_STA_TAG</th>//-->
						<th title="ORD_PAY_TAG">���ʽ</th><th title="ORD_PRICE">�����۸�</th><th title="ORD_PAY_MONEY">�Ѹ����</th>
						<!--<th>ORD_INV_TITLE<br/>��Ʊ̧ͷ</th><th>ORD_USR_NAME</th><th>ORD_USR_PHONE</th>	//-->				
						<th title="ORD_EXT1">����Ŀ��</th><th title="ORD_EXT2">Ԥ�Ƹ�������</th><th title="ORD_EXT3">ϣ��ǩ֤����</th>
						<!--<th title="ORD_DATE">�µ�����</th>//--><th title="ORD_CDATE">�µ�ʱ��</th><th title="ORD_MDATE">�����޸�ʱ��</th>
					</tr>
<?
				foreach($data_ordermain AS $keys=>$values)
				{
					$visa_order_user_info=$visa->get_order_user_info_by_visa_order_id($data_ordermain[$keys]['ORD_ID'],$data_ordermain[$keys]['USR_ID']);
?>
					<tr>
						<td><a href="?action=admin_goto_view_customer_visa_order&ORD_ID=<?php echo $data_ordermain[$keys]['ORD_ID'];?>" target="_blank"><?php echo $data_ordermain[$keys]['ORD_ID'];?></a></td>
						<td>
						<?php 
						$visa_status_name = $visa->get_visa_to_embassy_status_name($data_ordermain[$keys]['ORD_ID']);
						if (strlen($visa_status_name)>0){?>
						<a href="?action=view_visa_to_embassy_info&ORD_ID=<?php echo $data_ordermain[$keys]['ORD_ID'];?>"><?php echo $visa_status_name;?></a>
						<?php }?>
						</td>
						<td>
						<?php if(!empty($visa_order_user_info['orders_id'])){ ?>
						<a href="edit_orders.php?oID=<?php echo $visa_order_user_info['orders_id'];?>&action=edit" target="_blank"><?php echo $visa_order_user_info['orders_id'];?></a>
						<?php }?>
						</td>
						<td><?php echo $visa_order_user_info['customers_email_address'];?></td>
						<td><?php echo $visa_order_user_info['customers_name'];?></td>
						<!--<td><?php echo $data_ordermain[$keys]['ORD_USR_STA_TAG'];?></td><td><?php echo $data_ordermain[$keys]['ORD_ADM_STA_TAG'];?></td>//-->
						<td><?php echo $visa->match_visa_ORD_PAY_TAG($data_ordermain[$keys]['ORD_PAY_TAG']); ?></td>
						<td><?php echo $data_ordermain[$keys]['ORD_PRICE'];?></td><td><?php echo $data_ordermain[$keys]['ORD_PAY_MONEY'];?></td>
						<!--<td><?php echo $data_ordermain[$keys]['ORD_INV_TITLE'];?></td><td><?php echo $data_ordermain[$keys]['ORD_USR_NAME'];?></td><td><?php echo $data_ordermain[$keys]['ORD_USR_PHONE'];?></td>//-->					
						<td><?php echo $data_ordermain[$keys]['ORD_EXT1'];?></td><td><?php echo $data_ordermain[$keys]['ORD_EXT2'];?></td><td><?php echo $data_ordermain[$keys]['ORD_EXT3'];?></td>
						<!--<td><?php echo $data_ordermain[$keys]['ORD_DATE'];?></td>//--><td><?php echo $data_ordermain[$keys]['ORD_CDATE'];?></td><td><?php echo $data_ordermain[$keys]['ORD_MDATE'];?></td>
					</tr>
<?php
				}
?>
				</table>
<?
			}
			else
			{
				echo 'ERROR: no data.';
			}
		}
	}
	else
	{
		echo 'ERROR: no data found.';
	}	
}
?>

<?php
if($_GET['action'] == 'search' || !isset($_GET['action'])){
	
	if($download != "1"){
?>

<form name="visa_search" id="visa_search" method="get" action="visa.php?action=search">
<input name="action" type="hidden" value="search" />
<span style="font-weight:bolder; color:#0033FF">ǩ֤��������</span>
<table border="0" cellpadding="8" style="border:1px solid #CCCCCC; background-color: #EEEEEE; font-size:12px; text-align:center;">
	<tr>
		<td>���ķ�������<br/><?php echo tep_draw_input_field('orders_id','','style="ime-mode:none; width:60px;"');?></td>
		<td>ǩ֤������<br/><?php echo tep_draw_input_field('visa_orderid','','style="ime-mode:none; width:60px;"');?></td>
		<td>���ʽ<br/>
			<?php echo tep_draw_pull_down_menu('ORD_PAY_TAG', $visa->show_ORD_PAY_TAG(),'',' onchange="this.form.submit()"',false);?>
		</td>
		<td>����״̬<br/>
			<?php echo tep_draw_pull_down_menu('ORD_ADM_STA_TAG', $visa->show_ORD_ADM_STA_TAG(),'',' onchange="this.form.submit()"',false);?>
		</td>
		<td>ǩ֤״̬<br/>
			<?php echo tep_draw_pull_down_menu('VIS_STATUS', $visa->show_VIS_STATUS(),'',' onchange="this.form.submit()"',false);?>		
		</td>
		<td>����״̬<br/>
			<?php echo tep_draw_pull_down_menu('vis_pay_status', array(array("id"=>"","text"=>"----"),array("id"=>"1","text"=>"�Ѹ�"),array("id"=>"0","text"=>"δ��")),'',' onchange="this.form.submit()"',false);?>
		</td>
		<td>����ʱ��<br/>
		<?php echo tep_draw_input_field('pay_date_start','','style="ime-mode:none; width:80px;" readonly="" onClick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" title="��ʼ"');?>
		-<?php echo tep_draw_input_field('pay_date_end','','style="ime-mode:none; width:80px;" readonly="" onClick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" title="����"');?>
		</td>
		<td>��������<br/><?php echo tep_draw_input_field('customers_name','','style="width:60px;"');?></td>
		<td>���˵绰<br/><?php echo tep_draw_input_field('customers_telephone','','style="ime-mode:none; width:80px;"');?></td>
		<!--<td>��������:<?php echo tep_draw_input_field('customers_email_address','','style="ime-mode:none; width:80px;"');?></td>//-->
		<td><input name="" type="submit" vlaue="QUERY" /></td>
		<td><input name="" type="button" value="reset" onclick='jQuery("input[type=\"text\"]").val("");jQuery("select").val("");'></td>
		<td>
		<label style="cursor:pointer; color:#0066FF; border-bottom:1px solid #0033FF"><input name="download" type="checkbox" value="1" onClick="this.checked=true; this.form.submit(); this.checked=false;" style="display:none;">���ص�����</label>
		</td>
	</tr>
</table>
</form>
<?php 

$visa_com_not_done = $visa->visa_comunication_status_detial();


?>
<table class="tbList">
<tr>
<td width="200">·��δ�ظ�:<br/>
<?php
$arr_temp = $visa_com_not_done['lujia_not_replied'];
for($i=0,$n=count($arr_temp); $i<$n; $i++){
?>
	<a href="?action=communication&visa_order_id=<?php echo $arr_temp[$i]['visa_order_id'];?>" target="_blank"><?php echo $arr_temp[$i]['visa_order_id'];?>(<?php echo $arr_temp[$i]['e_count'];?>)</a>
<?php } ?>
</td>
<td width="200">·��δ��:<br/>
<?php
$arr_temp = $visa_com_not_done['lujia_not_read'];
for($i=0,$n=count($arr_temp); $i<$n; $i++){
?>
	<a href="?action=communication&visa_order_id=<?php echo $arr_temp[$i]['visa_order_id'];?>" target="_blank"><?php echo $arr_temp[$i]['visa_order_id'];?>(<?php echo $arr_temp[$i]['e_count'];?>)</a>
<?php }?>
</td>
<td width="200">���ķ�δ�ظ�:<br/>
<?php
$arr_temp = $visa_com_not_done['usitrip_not_replied'];
for($i=0,$n=count($arr_temp); $i<$n; $i++){
?>
	<a href="?action=communication&visa_order_id=<?php echo $arr_temp[$i]['visa_order_id'];?>" target="_blank"><?php echo $arr_temp[$i]['visa_order_id'];?>(<?php echo $arr_temp[$i]['e_count'];?>)</a>
<?php }?>
</td>
<td width="200">���ķ�δ��:<br/>
<?php
$arr_temp = $visa_com_not_done['usitrip_not_read'];
for($i=0,$n=count($arr_temp); $i<$n; $i++){
?>
	<a href="?action=communication&visa_order_id=<?php echo $arr_temp[$i]['visa_order_id'];?>" target="_blank"><?php echo $arr_temp[$i]['visa_order_id'];?>(<?php echo $arr_temp[$i]['e_count'];?>)</a>
<?php }?>
</td>
</tr>
</table>


<?php
	}
	
	if (is_array($_GET)){
?>

<?php if($download!="1"){?>
<div style="text-align:center;">�ܼ�: <span style="color:#FF9900; font-weight:bolder; font-size:24px; font-family:Arial, Helvetica, sans-serif;" id="price_total"></span></div>
<?php }?>
<table class="tbList" id="tbList">
  <tr role="head">
	<th width="70" title="ORD_ID" sort="true">ǩ֤������</th>
	<th width="70" sort="true">���ķ�������</th>
	<th width="70" sort="true">��Ա����</th>
	<th width="70" title="ORD_EXT1" sort="true">����Ŀ��</th>
	<th width="70">�µ�����</th>
	<th width="70">ǩ֤״̬</th>
	<th width="70" sort="true">ǩ֤����״̬</th>	
		
	<th title="ORD_EXT2" sort="true">Ԥ�Ƹ�������</th><th title="ORD_EXT3" sort="true">ϣ��ǩ֤����</th>
	<th title="ORD_CDATE" sort="true">�µ�ʱ��</th>	
	
	<th width="70" title="ORD_PAY_TAG" sort="true">���ʽ</th>
	<th width="70" title="ORD_PRICE" sort="true">�����۸�</th>
	<th width="70" title="ORD_PAY_MONEY" sort="true">����״̬</th>	
	<th width="70" sort="true">����ʱ��</th>
	<th width="200">·����������</th>
	<!--<th title="ORD_MDATE" sort="true">�����޸�ʱ��</th>//-->
  </tr>
<?php
		$sql = '';
		$orders_id = (int)$_GET['orders_id'];
		$visa_orderid = (int)$_GET['visa_orderid'];
		$ORD_PAY_TAG = tep_db_input($_GET['ORD_PAY_TAG']);
		$ORD_ADM_STA_TAG = tep_db_input($_GET['ORD_ADM_STA_TAG']);
		$VIS_STATUS = tep_db_input($_GET['VIS_STATUS']);
		$customers_name = tep_db_input($_GET['customers_name']);
		$customers_telephone = tep_db_input($_GET['customers_telephone']);
		$customers_email_address = tep_db_input($_GET['customers_email_address']);
		//���ݱ��ѯ
		$fields = 'b.ORD_ID,b.USR_ID ';
		$tables = ' visa_order_ordermain_from_lujia AS b ';
		$where = ' 1 ';
		$groupby = ' GROUP BY b.ORD_ID ';
		$orderby = '';
		
		if(!empty($orders_id) || !empty($visa_orderid)){
			
			
			if (!empty($orders_id)){
				//$sql2 = 'SELECT DISTINCT b.ORD_ID,b.USR_ID FROM visa_orders_byadmin AS a,visa_order_ordermain_from_lujia AS b WHERE a.orders_id=\''.$orders_id.'\' AND a.visa_orderid = b.ORD_ID';
				$tables.= ', visa_orders_byadmin AS a ';
				$where .= ' AND a.orders_id=\''.(int)$orders_id.'\' AND a.visa_orderid = b.ORD_ID ';
			}else{			
				//$sql2 = 'SELECT ORD_ID,USR_ID FROM visa_order_ordermain_from_lujia WHERE ORD_ID='.$visa_orderid.' LIMIT 0,1';
				$where .= ' AND ORD_ID='.(int)$visa_orderid.' ';
			}
		
		}else{
			
			$tables.= ', customers AS a ';
			$where .= ' AND b.USR_ID=a.customers_id ';
			
			$sql = 'SELECT customers_id FROM customers WHERE 1 ';
			if(!empty($customers_name)){
				//$sql .= ' AND (customers_firstname LIKE \'%'.$customers_name.'%\' OR customers_lastname LIKE \'%'.$customers_name.'%\')';
				$where .= ' AND (a.customers_firstname LIKE \'%'.$customers_name.'%\' OR a.customers_lastname LIKE \'%'.$customers_name.'%\')';
			}
			if(!empty($customers_email_address)){
				//$sql .= ' AND customers_email_address LIKE \'%'.$customers_email_address.'%\'';
				$where .= ' AND a.customers_email_address LIKE \'%'.$customers_email_address.'%\'';
			}
			if(!empty($customers_telephone)){
				//$sql .= ' AND customers_telephone LIKE \'%'.$customers_telephone.'\'%';
				$where .= ' AND a.customers_telephone LIKE \'%'.$customers_telephone.'\'%';
			}
			
			//���SQL�������������
			//$sql2 = 'SELECT DISTINCT ORD_ID,USR_ID FROM visa_order_ordermain_from_lujia AS b,('.$sql.') AS a WHERE b.USR_ID=a.customers_id ';
			
			if(!empty($ORD_PAY_TAG)){
				if ($ORD_PAY_TAG=="lujia_all"){
					//$sql2 .= ' AND b.ORD_PAY_TAG!=\'PAY_AGENT\'';
					$where.= ' AND b.ORD_PAY_TAG!=\'PAY_AGENT\'';
				}else{
					//$sql2 .= ' AND b.ORD_PAY_TAG=\''.$ORD_PAY_TAG.'\'';
					$where.= ' AND b.ORD_PAY_TAG=\''.$ORD_PAY_TAG.'\'';
				}				
			}	
			
			if (!empty($ORD_ADM_STA_TAG)){
				//$sql2 .= ' AND b.ORD_ADM_STA_TAG=\''.$ORD_ADM_STA_TAG.'\'';
				$where .= ' AND b.ORD_ADM_STA_TAG=\''.$ORD_ADM_STA_TAG.'\'';
			}
			
			$orderby = ' ORDER BY b.visa_order_ordermain_id DESC, b.ORD_ID DESC';
			
		}
		
			
		$pay_date_start = strtotime($_GET['pay_date_start']);
		//echo '<br/>'.$pay_date_start;
		$pay_date_end = strtotime($_GET['pay_date_end']);
		$sql2 = 'SELECT '.$fields.' FROM '.$tables.' WHERE '.$where.$groupby.$orderby;
		//echo $sql2.'<hr>';
		$price_total = 0;
		$query_numrows = 0;
		if($download != "1"){
			$_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_ADMIN, $sql2, $query_numrows);
		}
		$sql_query2 = tep_db_query($sql2);
		//echo $sql2;

		while($rows2 = tep_db_fetch_array($sql_query2)){
			$show_flag = 1;//�Ƿ���ʾ.��Ϊ����Ҫ�õ��Ƚϸ��ӵ�������ѯ...
			$data2 = $visa->get_visa_order_info_by_visa_order_id($rows2['ORD_ID']);
			$vis_pay_status = $_GET['vis_pay_status'];

			if ($vis_pay_status == '1'){
				if ($data2['ORD_PAY_MONEY'] < $data2['ORD_PRICE']) { $show_flag = 0; }				
			}
			if ($vis_pay_status == '0'){
				if ($data2['ORD_PAY_MONEY'] >= $data2['ORD_PRICE']) { $show_flag = 0; }		
			}
			
			//$visa_status_name = $visa->get_visa_to_embassy_status_name($rows2['ORD_ID']);
			
			if($show_flag == 1){
				$visa_VIS_STATUS = $visa->get_visa_to_embassy_status($rows2['ORD_ID']);
				if ( (!empty($VIS_STATUS)) && ($VIS_STATUS != $visa_VIS_STATUS) ){	$show_flag = 0;	}
			}
			
			/*����ʱ��β�ѯ����*/
			$visa_order_pay_date = $visa->get_visa_order_pay_date($rows2['ORD_ID']);
			$visa_order_pay_date_2 = strtotime($visa_order_pay_date);
			//echo '<br/>'.$rows2['ORD_ID'].' : '.$visa_order_pay_date;
			
			if( (!empty($pay_date_start)) || (!empty($pay_date_end))  )
			{
				
				if ( empty($visa_order_pay_date_2) )
				{
					$show_flag = 0;
				}
				else
				{
					if( (!empty($pay_date_start)) )
					{
						if( (!empty($pay_date_end)) )
						{
							if( $visa_order_pay_date_2 >= $pay_date_start && $visa_order_pay_date_2 <= $pay_date_end ){ $show_flag = 1; }
							else{ $show_flag = 0; }
						}
						else
						{
							if( $visa_order_pay_date_2 >= $pay_date_start ){ $show_flag = 1; }
							else{ $show_flag = 0; }
						}
					}
					else
					{
						if( (!empty($pay_date_end)) )
						{
							if( $visa_order_pay_date_2 <= $pay_date_end ){ $show_flag = 1; }
							else{ $show_flag = 0; }
						}				
					}
				}
			}
			
			if($show_flag == 1)
			{			
				$visa_order_user_info=$visa->get_order_user_info_by_visa_order_id($rows2['ORD_ID'], $rows2['USR_ID']);				
			?>
			<tr>
				<td>
				<?php if($can_edit_visa_orders === true){?>
				<a href="<?php echo tep_href_link('visa.php','action=admin_goto_view_customer_visa_order&ORD_ID='.$rows2['ORD_ID']);?>" target="_blank"><?php echo $rows2['ORD_ID'];?></a>
				<?php }else{?>
				<?= $rows2['ORD_ID'];?>
				<?php }?>
				</td>
				<td>
				<?php if(!empty($visa_order_user_info['orders_id'])){ ?>
				<a href="<?php echo tep_href_link('edit_orders.php','oID='.$visa_order_user_info['orders_id'].'&action=edit');?>" target="_blank"><?php echo $visa_order_user_info['orders_id'];?></a>
				<?php }?>
				</td>
				<td><?php echo $visa_order_user_info['customers_name'];?></td>
				<td><?php echo $data2['ORD_EXT1'];?></td>
				<td><?php 
				// by lwkai add 2012-08-20
				$sql_temp = "select a.admin_job_number from admin as a,visa_orders_byadmin as vob where a.admin_id = vob.login_id and vob.visa_orderid=" . $rows2['ORD_ID'];
				$result = tep_db_query($sql_temp);
				$num = tep_db_num_rows($result);
				if ($num > 0){
					$row = tep_db_fetch_array($result);
					echo $row['admin_job_number'];
				}
				// add end
				?></td>
				<td>
				<?php				
				if (strlen($visa_VIS_STATUS)>0){?>
				<a href="<?php echo tep_href_link('visa.php','action=view_visa_to_embassy_info&ORD_ID='.$rows2['ORD_ID']);?>" target="_blank">
				<?php echo $visa->match_visa_to_embassy_status_name($visa_VIS_STATUS);?></a>
				<?php }?>
				</td>			
				<td><?php 
				switch($data2['ORD_ADM_STA_TAG']){
					case 'ORD_ADM_CON':
						echo '<font style="color:#00f;font-weight:bold;">' . $visa->match_visa_order_status_name($data2['ORD_ADM_STA_TAG']) . '</font>';
						break;
					case 'ORD_ADM_OK':
						echo '<font style="color:#F00;font-weight:bold;">' . $visa->match_visa_order_status_name($data2['ORD_ADM_STA_TAG']) . '</font>';
						break;
					default:
						echo $visa->match_visa_order_status_name($data2['ORD_ADM_STA_TAG']);
				}
				?></td>				
				<td><?php echo $data2['ORD_EXT2'];?></td>
				<td><?php echo $data2['ORD_EXT3'];?></td>
				<td><?php echo date_format(date_create($data2['ORD_CDATE']),'Y-m-d');?></td>
				
				<td><?php
				echo $visa->match_visa_ORD_PAY_TAG($data2['ORD_PAY_TAG']);
				?>
				</td>
				<td><?php echo $data2['ORD_PAY_MONEY'];?></td>				
				<td title="�Ѹ�: <?php echo $data2['ORD_PAY_MONEY'];?>"><?php if ($data2['ORD_PAY_MONEY']>= $data2['ORD_PRICE']){ echo '�Ѹ���'; }else{ echo 'δ����';} ?></td>
				<td><?php echo $visa_order_pay_date;?></td>
				<td>
				<?php
				$visa_com_last_message = false;
				$visa_com_last_message = $visa->visa_com_get_lujia_last_mseeage_by_visa_order_id($rows2['ORD_ID']);
				if(is_array($visa_com_last_message)){
				?>
				<a href="?action=communication&visa_order_id=<?php echo $rows2['ORD_ID'];?>" target="_blank"><?php echo tep_db_output($visa_com_last_message['message']);?></a>
				<?php 				
				}elseif($can_edit_visa_orders === true){
				?>
				<a href="?action=communication&visa_order_id=<?php echo $rows2['ORD_ID'];?>" target="_blank">ȥ����</a>&gt;&gt;
				<?php }
				?>
				</td>
			</tr>				
			<?php
				$price_total += $data2['ORD_PRICE'];
			}
		}
	?>

</table>

<?php if(is_object($_split)){?>
<table border="0" cellspacing="0" cellpadding="2" >
  <tr>
	<td class="smallText" valign="top"><?php echo $_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ADMIN, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
	<td class="smallText" align="right"><?php echo $_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ADMIN, MAX_DISPLAY_PAGE_LINKS, $_GET['page'],tep_get_all_get_params(array('page','y','x', 'action'))); ?>&nbsp;</td>
  </tr>
</table>
<?php }?>
			
<div style="text-align:center;">�ܼ�: <span style="color:#FF9900; font-weight:bolder; font-size:24px; font-family:Arial, Helvetica, sans-serif;"><?php echo $price_total;?></span></div>
<?php if($download!="1"){?>
<script>jQuery("#price_total").html('<?php echo $price_total;?>');</script>
<?php }?>
<?php if($download!="1"){?>
<script language="javascript" type="text/javascript">
jQuery("#tbList tr:even").css("background-color","#EEEEEE"); 
</script>
<script type="text/javascript" src="includes/javascript/jquery-plugin-TableSort/TableSort.js"></script>
<script language="javascript" type="text/javascript">
	jQuery("#tbList").sorttable({
		ascImgUrl: "includes/javascript/jquery-plugin-TableSort/bullet_arrow_up.png",
		descImgUrl: "includes/javascript/jquery-plugin-TableSort/bullet_arrow_down.png",
		ascImgSize: "8px",
		descImgSize: "8px",
		onSorted: function (cell) {  }
	});

</script>
<?php }?>
	<?php
	}
?>
<?php
}?>

<?php
//==================================================ǩ֤��Ϣ=============================================================
if($_GET['action'] == 'view_visa_to_embassy_info')
{
?>
<table class="tbList" id="tbList">
  <tr>
	<th title="VIS_CDATE">����ʱ��</th>
	<th title="VIS_MDATE">�޸�ʱ��</th>
	<th title="VIS_STATUS">ǩ֤״̬</th>
	<th title="VIS_XML">ע������</th>
	<th title="VIS_IMG">ע������Ƭ</th>
	<th title="VIS_PRT">ȷ��ҳ</th>
	<th title="VIS_PRT1">ע�����ݽ�ͼ</th>
	<th title="ROB_APP_ID">ȷ��ҳ���</th>
  </tr>
<?php
	$ORD_ID = $_GET['ORD_ID'];
	$sql = 'SELECT VIS_CDATE,VIS_MDATE,VIS_STATUS, VIS_XML,VIS_IMG,VIS_PRT,VIS_PRT1,ROB_APP_ID FROM `visa_to_embassy_info` WHERE FRO_ORD_ID='.$ORD_ID;
	//echo $sql;
	$sql_query = tep_db_query($sql);
	$VIS_XML_i = 0;
	while($rows =  tep_db_fetch_array($sql_query))
	{
		$VIS_XML_i +=1;
?>
  <tr>
  	<td><?php echo $rows['VIS_CDATE'];?></td>
	<td><?php echo $rows['VIS_MDATE'];?></td>
	<td><?php echo $visa->match_visa_to_embassy_status_name($rows['VIS_STATUS']);?></td>
	<td>
	<a href="javascript:void(0)" onClick="document.getElementById('VIS_XML_<?php echo $VIS_XML_i;?>').style.display='block';" style="color:#FF6600">+��ʾ</a>
	<div id="VIS_XML_<?php echo $VIS_XML_i;?>" style="display:none;">
	<?php
	 	//echo $rows['VIS_XML'];
		$VIS_XML = str_replace('&gt;','>',str_replace('&lt;','<',iconv('gb2312','utf-8',$rows['VIS_XML'])));
		$VIS_XML_arr0 = xml2array('',1,'tag',$VIS_XML);
		$VIS_XML_arr = $visa->iconv_array_charencoding('utf-8','gb2312',$VIS_XML_arr0);
		//print_r($VIS_XML_arr);
		

echo('<br/><b>��1�� ����ҳ</b><br/>');
echo '<br/>�ύ����ĵص�:'.$VIS_XML_arr['user']['TargetSiteCd'];
echo('<br/><b>��2�� ������Ϣ</b><br/>');
echo '<br/>����ȫ��:'.$VIS_XML_arr['user']['FULL_NAME_NATIVE'];
echo '<br/>����:'.$VIS_XML_arr['user']['SURNAME_ZH'].$VIS_XML_arr['user']['SURNAME'];
echo '<br/>����:'.$VIS_XML_arr['user']['GIVEN_NAME_ZH'].$VIS_XML_arr['user']['GIVEN_NAME'];
echo '<br/>���Ƿ���������:'.$VIS_XML_arr['user']['OtherNames'];
echo '<br/> -��������:'.$VIS_XML_arr['user']['ALIAS_SURNAME_ZH'].$VIS_XML_arr['user']['ALIAS_SURNAME'];
echo '<br/> -��������:'.$VIS_XML_arr['user']['ALIAS_GIVEN_NAME_ZH'].$VIS_XML_arr['user']['ALIAS_GIVEN_NAME'];
echo '<br/>������������Ӧ�ĵ�����:'.$VIS_XML_arr['user']['TelecodeQuestion'];
echo '<br/> -���ϵĵ���:'.$VIS_XML_arr['user']['TelecodeSURNAME_ZH'].$VIS_XML_arr['user']['TelecodeSURNAME'];
echo '<br/> -���ֵĵ���:'.$VIS_XML_arr['user']['TelecodeGIVEN_NAME_ZH'].$VIS_XML_arr['user']['TelecodeGIVEN_NAME'];
echo '<br/>�Ա�:'.$VIS_XML_arr['user']['GENDER'];
echo '<br/>����״��(M:Married (�ѻ�),S:Single (����),W:Widowed (ɥż),D:Divorced (����),L:Legally Separated (�Ϸ��־�)):'.$VIS_XML_arr['user']['MARITAL_STATUS'];
echo '<br/>��������:'.$VIS_XML_arr['user']['862550547'];
echo '<br/>�����س���(����):'.$VIS_XML_arr['user']['POB_CITY_ZH'];
echo '<br/>�����س���(Ӣ��):'.$VIS_XML_arr['user']['POB_CITY'];
echo '<br/>����������/ʡ��(����):'.$VIS_XML_arr['user']['POB_ST_PROVINCE_ZH'];
echo '<br/>����������/ʡ��(Ӣ��):'.$VIS_XML_arr['user']['POB_ST_PROVINCE'];
echo '<br/>�����ع��� :'.$VIS_XML_arr['user']['POB_CNTRY'];
echo('<br/><b>��3�� ���������Ϣ</b><br/>');
echo '<br/>���� :'.$VIS_XML_arr['user']['APP_NATL'];
echo '<br/>�Ƿ�ӵ��һ�����Ϲ��� :'.$VIS_XML_arr['user']['APP_OTH_NATL_IND'];
echo '<br/> -�������� :'.$VIS_XML_arr['user']['OTHER_NATL'];
echo '<br/> -���Ƿ�������������Ļ���:'.$VIS_XML_arr['user']['OTHER_PPT_IND'];
echo '<br/>�������������Ļ��յĻ��պ���:'.$VIS_XML_arr['user']['OTHER_PPT_NUM'];
echo '<br/>���֤������ :'.$VIS_XML_arr['user']['APP_NATIONAL_ID'];
echo '<br/>������ᰲȫ��1:'.$VIS_XML_arr['user']['APP_SSN1'];
echo '<br/>������ᰲȫ��1:'.$VIS_XML_arr['user']['APP_SSN2'];
echo '<br/>������ᰲȫ��1:'.$VIS_XML_arr['user']['APP_SSN3'];
echo '<br/>������˰����ݺ���:'.$VIS_XML_arr['user']['APP_TAX_ID'];
echo('<br/><b>��4�� ��ͥ��ַ�͵绰��Ϣ</b><br/>');
echo '<br/>��ͥ�ֵ���ַ����һ�У� :'.$VIS_XML_arr['user']['ADDR_LN1_ZH'];
echo '<br/>��ͥ�ֵ���ַ����һ�У� :'.$VIS_XML_arr['user']['ADDR_LN1'];
echo '<br/>��ͥ�ֵ���ַ���ڶ��У�:'.$VIS_XML_arr['user']['ADDR_LN2_ZH'];
echo '<br/>��ͥ�ֵ���ַ���ڶ��У�:'.$VIS_XML_arr['user']['ADDR_LN2'];
echo '<br/>���� :'.$VIS_XML_arr['user']['ADDR_CITY_ZH'];
echo '<br/>���� :'.$VIS_XML_arr['user']['ADDR_CITY'];
echo '<br/>ʡ�� :'.$VIS_XML_arr['user']['ADDR_STATE_ZH'];
echo '<br/>ʡ�� :'.$VIS_XML_arr['user']['ADDR_STATE'];
echo '<br/>��������:'.$VIS_XML_arr['user']['ADDR_POSTAL_CD'];
echo '<br/>���� :'.$VIS_XML_arr['user']['ADDR_COUNTRY'];
echo '<br/>�����ʼĵ�ַ�Ƿ����ͥ��ַ��ͬ�� :'.$VIS_XML_arr['user']['MailingAddrSame'];
echo '<br/> -�ʼĵ�ַ����һ��:'.$VIS_XML_arr['user']['MAILING_ADDR_LN1_ZH'].$VIS_XML_arr['user']['MAILING_ADDR_LN1'];
echo '<br/> -�ʼĵ�ַ���ڶ��У� :'.$VIS_XML_arr['user']['MAILING_ADDR_LN2_ZH'].$VIS_XML_arr['user']['MAILING_ADDR_LN2'];
echo '<br/> -�ʼĳ��� :'.$VIS_XML_arr['user']['MAILING_ADDR_CITY_ZH'].$VIS_XML_arr['user']['MAILING_ADDR_CITY'];
echo '<br/> -�ʼ�ʡ��:'.$VIS_XML_arr['user']['MAILING_ADDR_STATE_ZH'].$VIS_XML_arr['user']['MAILING_ADDR_STATE'];
echo '<br/> -�ʼĵ�ַ�ʱ�:'.$VIS_XML_arr['user']['MAILING_ADDR_POSTAL_CD'];
echo '<br/> -�ʼĹ���:'.$VIS_XML_arr['user']['MailCountry'];
echo '<br/>��ͥ�绰 :'.$VIS_XML_arr['user']['HOME_TEL'];
echo '<br/>��λ�绰:'.$VIS_XML_arr['user']['BUS_TEL'];
echo '<br/>�ֻ�:'.$VIS_XML_arr['user']['MOBILE_TEL'];
echo '<br/>�����ʼ�:'.$VIS_XML_arr['user']['EMAIL_ADDR'];
echo('<br/><b>��5�� ������Ϣ</b><br/>');
echo '<br/>����/����֤������ :'.$VIS_XML_arr['user']['PPT_TYPE'];
echo '<br/>���պ� :'.$VIS_XML_arr['user']['PPT_NUM'];
echo '<br/>���ձ����:'.$VIS_XML_arr['user']['PPT_BOOK_NUM'];
echo '<br/>����ǩ������ :'.$VIS_XML_arr['user']['PPT_ISSUED_CNTRY'];
echo '<br/>����ǩ���س��� :'.$VIS_XML_arr['user']['PPT_ISSUED_IN_CITY_ZH'].$VIS_XML_arr['user']['PPT_ISSUED_IN_CITY'];
echo '<br/>ʡ�� :'.$VIS_XML_arr['user']['PPT_ISSUED_IN_STATE_ZH'].$VIS_XML_arr['user']['PPT_ISSUED_IN_STATE'];
echo '<br/>ǩ������ :'.$VIS_XML_arr['user']['PPT_ISSUED_IN_CNTRY'];
echo '<br/>ǩ������:'.$VIS_XML_arr['user']['20754705'];
echo '<br/>��Ч��:'.$VIS_XML_arr['user']['1661928093'];
echo '<br/>���ձ�͵���� :'.$VIS_XML_arr['user']['LOST_PPT_IND'];
echo '<br/> -��͵���պ���,������˿ɲ���:'.$VIS_XML_arr['user']['LOST_PPT_NUM'];
echo '<br/> -����ǩ������/����:'.$VIS_XML_arr['user']['LOST_PPT_NATL'];
echo '<br/> -��ʧԭ��:'.$VIS_XML_arr['user']['LOST_PPT_EXPL'];
echo('<br/><b>��6�� ������Ϣ</b><br/>');
echo '<br/>ǩ֤����:'.$VIS_XML_arr['user']['PurposeOfTrip'];
echo '<br/>ǩ֤����˵�� :'.$VIS_XML_arr['user']['OtherPurpose'];
echo '<br/>�Ƿ��ƶ�����ȷ�����мƻ� :'.$VIS_XML_arr['user']['SpecificTravel'];
echo '<br/> -(��)�ƻ�����ʱ��:'.$VIS_XML_arr['user']['-1028787741'];
echo '<br/> -(��)�ƻ�ͣ��ʱ��:'.$VIS_XML_arr['user']['TRAVEL_LOS'];
echo '<br/> -(��)�ƻ�����ͣ��ʱ��:'.$VIS_XML_arr['user']['TRAVEL_LOS_CD'];
echo '<br/> -������������(1):'.$VIS_XML_arr['user']['785637561'];
echo '<br/> -���ﺽ��:'.$VIS_XML_arr['user']['ArriveFlight'];
echo '<br/> -�������:'.$VIS_XML_arr['user']['ArriveCity_ZH'].$VIS_XML_arr['user']['ArriveCity'];
echo '<br/> -�뿪��������(1):'.$VIS_XML_arr['user']['-428343276'];
echo '<br/> -�뿪����:'.$VIS_XML_arr['user']['DepartFlight'];
echo '<br/> -�뿪����:'.$VIS_XML_arr['user']['DepartCity_ZH'].$VIS_XML_arr['user']['DepartCity'];
echo '<br/> -���ṩ�������ڼ�ƻ����ʵĵص�����:'.$VIS_XML_arr['user']['SPECTRAVEL_LOCATION_ZH'].$VIS_XML_arr['user']['SPECTRAVEL_LOCATION'];
echo '<br/>֧���г̵���֯��S,O,C�� :'.$VIS_XML_arr['user']['WhoIsPaying'];
echo '<br/>����ͣ����סַ-�ֵ�1 :'.$VIS_XML_arr['user']['StreetAddress1_ZH'].$VIS_XML_arr['user']['StreetAddress1_ZH'];
echo '<br/>����ͣ����סַ-�ֵ�2 :'.$VIS_XML_arr['user']['StreetAddress2_ZH'].$VIS_XML_arr['user']['StreetAddress2'];
echo '<br/>����ͣ����סַ-���� :'.$VIS_XML_arr['user']['CITY_ZH'].$VIS_XML_arr['user']['CITY'];
echo '<br/>����ͣ����סַ-�� :'.$VIS_XML_arr['user']['TravelState'];
echo '<br/>��������:'.$VIS_XML_arr['user']['ZIPCode'];
echo('<br/><b>��7�� ������Ա��Ϣ</b><br/>');
echo '<br/>�Ƿ���������ͬ��:'.$VIS_XML_arr['user']['OtherPersonsTravelingWithYou'];
echo '<br/> -��������Ϊһ���Ż���֯�ĳ�Ա:'.$VIS_XML_arr['user']['GroupTravel'];
echo '<br/> -������Ա������:'.$VIS_XML_arr['user']['TRAV_COMP_SURNAME_ZH'].$VIS_XML_arr['user']['TRAV_COMP_SURNAME'];
echo '<br/> -������Ա������:'.$VIS_XML_arr['user']['TRAV_COM_GIVEN_NAME_ZH'].$VIS_XML_arr['user']['TRAV_COM_GIVEN_NAME'];
echo '<br/> -������Ա�����Ĺ�ϵ:'.$VIS_XML_arr['user']['TRAV_COMP_Relationship'];
echo '<br/> -���Ա:'.$VIS_XML_arr['user']['GroupName_ZH'].$VIS_XML_arr['user']['GroupName'];

echo('<br/><b>��8�� ��������������Ϣ</b><br/>');
echo '<br/>����ȥ������ :'.$VIS_XML_arr['user']['PREV_US_TRAVEL_IND'];
echo '<br/> -��������(1):'.$VIS_XML_arr['user']['-511388955'];
echo '<br/> -ͣ��ʱ��:'.$VIS_XML_arr['user']['PREV_US_VISIT_LOS'];
echo '<br/> -ʱ������:'.$VIS_XML_arr['user']['PREV_US_VISIT_LOS_CD'];
echo '<br/> -������ȡ����������:'.$VIS_XML_arr['user']['PREV_US_DRIVER_LIC_IND'];
echo '<br/> -��ʻִ�յĺ���:'.$VIS_XML_arr['user']['US_DRIVER_LICENSE'];
echo '<br/> -��ʻִ����������:'.$VIS_XML_arr['user']['US_DRIVER_LICENSE_STATE'];
echo '<br/>�����������ǩ֤ :'.$VIS_XML_arr['user']['PREV_VISA_IND'];
echo '<br/> -��һ�λ������ǩ֤������:'.$VIS_XML_arr['user']['-947244896'];
echo '<br/> -ǩ֤����:'.$VIS_XML_arr['user']['PREV_VISA_FOIL_NUMBER'];
echo '<br/> -���˴��Ƿ�����ͬ��ǩ֤ :'.$VIS_XML_arr['user']['PREV_VISA_SAME_TYPE_IND'];
echo '<br/> -���˴��Ƿ���ǩ�����ϴθ���ǩ֤����ͬ�����ٴ����룬������������Ƿ�Ϊ�����Ҫ��ס���ң�:'.$VIS_XML_arr['user']['PREV_VISA_SAME_CNTRY_IND'];
echo '<br/> -���Ƿ���ȡ��ʮָָ�ƣ�:'.$VIS_XML_arr['user']['PREV_VISA_TEN_PRINT_IND'];
echo '<br/> -��������ǩ֤�Ƿ�������ʧ���߱���:'.$VIS_XML_arr['user']['PREV_VISA_LOST_IND'];
echo '<br/> -��������ǩ֤�Ƿ�������ע����������:'.$VIS_XML_arr['user']['PREV_VISA_CANCELLED_IND'];
echo '<br/>   -ԭ�����:'.$VIS_XML_arr['user']['PREV_VISA_CANCELLED_EXPL_ZH'];
echo '<br/>���Ƿ���������ǩ�����ܾ��뾳�������������뾳ʱ�����������뾳���룿 :'.$VIS_XML_arr['user']['PREV_VISA_REFUSED_IND'];
echo '<br/>�������ڹ�����������Ϊ������������� :'.$VIS_XML_arr['user']['IV_PETITION_IND'];

	?>
	<div style="margin-top:30px; color:#FF0000">-------------------��λ̫��,������----------------</div>
	</div>
	</td>
	<td><?php if(strlen($rows['VIS_IMG'])>0){?><a href="/<?php echo $rows['VIS_IMG'];?>" target="_blank">ע������Ƭ</a><?php }?></td>
	<td><?php if(strlen($rows['VIS_PRT'])>0){?><a href="/<?php echo $rows['VIS_PRT'];?>" target="_blank">ȷ��ҳ</a><?php }?></td>
	<td><?php if(strlen($rows['VIS_PRT1'])>0){?><a href="/<?php echo $rows['VIS_PRT1'];?>" target="_blank">ע�����ݽ�ͼ</a><?php }?></td>
	<td><?php echo $rows['ROB_APP_ID'];?></td>
  </tr>
<?php
	}
?>
</table>
<?php 
}
?>

<?php
//=========================================��·�ν���==============================================================================
if($_GET['action'] == 'communication')
{
	$visa_order_id = (int)$_GET['visa_order_id'];
	if($visa_order_id>0)
	{
?>
<script language="javascript" type="text/javascript">
function fn_visa_msg_read(id)
{
	var url = "visa.php?action=communication_read&id="+id;;

	jQuery.get(url, {}, function(data){
		if (data.substring(0,5).toUpperCase()=="ERROR"){ alert(data); }	else{ alert("�����ɹ�"); window.location.href = window.location.href; }
	}); 
}
</script>
	ǩ֤���� (������ <b><?php echo $visa_order_id;?></b>) ��·�ν���������:
	<div>
	<?php
	$data2 = $visa->get_visa_order_info_by_visa_order_id($visa_order_id);
	$visa_VIS_STATUS = $visa->get_visa_to_embassy_status($visa_order_id);
	?>
	<table class="tbList">
		<tr>
			<th>������</th>
			<th>�ͻ�����</th>
			<th>����Ŀ��</th>
			<th>ǩ֤״̬</th>
			<th>����״̬</th>
			<th>Ԥ�Ƹ�������</th>
			<th>ϣ��ǩ֤����</th>
		</tr>
		<tr>
			<td><?php echo $visa_order_id;?></td>
			<td><?php echo $data2['ORD_USR_NAME'];?></td>
			<td><?php echo $data2['ORD_NAME'];?></td>
			<td><?php echo $visa->match_visa_to_embassy_status_name($rows['VIS_STATUS']);?></td>
			<td><?php if ($data2['ORD_PAY_MONEY']>= $data2['ORD_PRICE']){ echo '�Ѹ���'; }else{ echo 'δ����';} ?></td>
			<td><?php echo $data2['ORD_EXT2'];?></td>
			<td><?php echo $data2['ORD_EXT3'];?></td>
		</tr>
	</table>
	</div>

	<div style="width:1100px;">
	<div style="float:left; width:500px; height:20px; background-color:#FFFFFF; overflow:hidden; border:1px solid #CCCCCC; padding:5px; margin:2px; text-align:center; font-weight:bolder; font-size:16px;">���ķ�</div>
	<div style="float:left; width:500px; height:20px; background-color:#CCFFFF; overflow:hidden; border:1px solid #CCCCCC; padding:5px; margin:2px; text-align:center; font-weight:bolder; font-size:16px;">·��</div>
	<?php
//	$sql = 'SELECT GROUP_CONCAT(a1.id2) AS ids FROM( SELECT CONCAT(CAST(a.visa_order_com_id AS char),\',\',CAST(IFNULL(b.visa_order_com_id,\'\') AS char)) AS id2  FROM(   select visa_order_com_id,visa_order_com_parent_id FROM visa_order_communication WHERE visa_order_id='.$visa_order_id.' ) AS a LEFT JOIN(   select visa_order_com_id,visa_order_com_parent_id FROM visa_order_communication WHERE visa_order_id='.$visa_order_id.' ) AS b ON a.visa_order_com_id = b.visa_order_com_parent_id ) AS a1';
//	$sql_query =  tep_db_query($sql);
//	while($rows1 = tep_db_fetch_array($sql_query))
//	{
//		$data = str_replace(',,',',',$rows1);
//	}
//	$data_str = $data['ids'].']';
//	$data_str = str_replace(',]','',$data_str);
//	$data_str = str_replace(']','',$data_str);
//	$data1 = split(',',$data_str);
//	$data2 = array_unique($data1);
//	
//	//$visa_order_com = $visa->visa_order_com_get_lists($visa_order_id);
//	//tep_get_admin_customer_name
//	foreach($data2 AS $key=>$value)
//	{
//		echo $value.'<br/>';
//	}
//	exit();

	$sql = 'SELECT * FROM visa_order_communication WHERE visa_order_id='.$visa_order_id.' ORDER BY CASE visa_order_com_root_id WHEN 0 THEN visa_order_com_id ELSE visa_order_com_root_id END DESC, visa_order_com_parent_id ASC, add_date ASC';
	$sql_query = tep_db_query($sql);
	
	$admin_id_temp = -1;
	$last_from = '';
	$last_from_temp = '';
	
	while($rows = tep_db_fetch_array($sql_query))
	{
		if ($rows['admin_id']>0) { 
			$last_from_temp = 'usi'; 
		} 
		else {
			$last_from_temp = 'lujia'; 
		}
	?>
	<?php
		if ((int)$rows['visa_order_com_root_id']==0) {
			$last_from = '';
	?>
	<div style="line-height:5px; height:15px; float:left; width:95%; background-color: #CCCCCC;">
		<a href="javascript:void(0)" style="float:right;">����</a>
	</div>
	<?php }?>
	<div>
		<?php if( ($rows['admin_id']==0 && (int)$rows['visa_order_com_root_id']==0) || ($last_from_temp == $last_from ) ){?>
		<div style="float:left; width:500px; height:86px; overflow:hidden; border:1px solid #FFFFFF; padding:5px; margin:2px;"></div>
		<?php }?>
		
		<div style="float:left; width:500px; height:86px; overflow:hidden; border:1px solid #CCCCCC; padding:5px; margin:2px; 
		<?php if($rows['admin_id']==0){ ?> background-color:#CCFFFF;<?php }?>
		<?php if ((int)$_GET['visa_order_com_parent_id']==(int)$rows['visa_order_com_id']){ ?> background-color:#FFCC33;<?php }?>
		">
			<div>
				<span style="color:#999999;"><?php if($rows['admin_id']>0){ echo tep_get_admin_customer_name($rows['admin_id']);}else{ echo '<b>'.tep_db_output($rows['sender_name']).'</b>';}?></span>
				<?php echo tep_db_output($rows['title']);?><br/>
				<div style=" padding:5px 3px; height:50px; overflow:auto;"><?php echo tep_db_output( $rows['message']);?>	</div>
			</div>
			<div style="">
				<span style="float:right;color:#666666;" title="���ʱ��">ʱ��:<?php echo $rows['add_date'];?></span>
			<?php
			if($rows['admin_id']==0){ $to_name = '���ķ�'; }else{ $to_name = '·��'; }
			
			if ($rows['need_reply']=='1')
			{ 				
				if($rows['is_replied']=='1'){ echo '<span style="color:#0000FF">'.$to_name.'�ѻظ�</span>'; }
				else{ echo '<span style="color:#FF0000">'.$to_name.'δ�ظ�</span>'; }			
			?>
			<a href="<?php 
			echo '?action=communication&visa_order_id='.$visa_order_id;
			
			if ($rows['visa_order_com_root_id']==0) { echo '&visa_order_com_root_id='.$rows['visa_order_com_id']; }
			else { echo '&visa_order_com_root_id='.$rows['visa_order_com_root_id']; }
			
			echo '&visa_order_com_parent_id='.$rows['visa_order_com_id'];
			echo '#a_form_add';
			?>">
				<?php 
				if($can_edit_visa_orders === true){
					if( $rows['admin_id']>0) {
						//if ($rows['is_replied']=='1'){ echo '׷��';} else { echo '�ظ�'; }
						echo '׷��';
					}else{
						if ($rows['is_replied']=='1'){ echo '׷��';} else { echo '�ظ�'; }
					}
				}
				?>
			</a>
			<?php 
			}
							
			if($rows['is_read']=='0'){ 
				echo '<span style="color:#FF0000">';
				if ($rows['admin_id']>0){ echo '·��';}else{ echo '���ķ�';}
				echo 'δ��</span>'; 
			}				
			
			if(($rows['admin_id']==0) && ($rows['is_read']=='0') && $can_edit_visa_orders === true){?>
			<input name="" type="button" value="���Ѷ�" onClick="fn_visa_msg_read(<?php echo $rows['visa_order_com_id'];?>)" style="font-size:12px; padding:0;">
			<?php
			}
			?>
			
			
			</div>
			

		</div>
	</div>
	<?php
		if ($rows['admin_id']>0) { 
			$last_from = 'usi';
		} 
		else {
			$last_from = 'lujia';
		}
	}
	?>
	</div>
	<?php if($can_edit_visa_orders === true){?>
	<div style="width:1000px; float:left; background-color:;">
	<a name="a_form_add"></a>
	<a href="?action=communication&visa_order_id=<?php echo $visa_order_id;?>">��·����������</a>
	<?php
	$data =false;
	$is_reply = false;
	$visa_order_com_parent_id = (int)$_GET['visa_order_com_parent_id'];
	$visa_order_com_root_id = (int)$_GET['visa_order_com_root_id'];
	if ($visa_order_com_parent_id>0){
		$sql = 'SELECT title,message FROM visa_order_communication WHERE visa_order_com_id='.$visa_order_com_parent_id;
		$is_reply = true;
		$sql_query = tep_db_query($sql);
		while($rows =  tep_db_fetch_array($sql_query))
		{
			$data = $rows ;
		}
	}
	?>
	<form name="form1" id="form1" action="?action=communication_add&visa_order_id=<?php echo $visa_order_id;?>&visa_order_com_root_id=<?php echo $visa_order_com_root_id?>&visa_order_com_parent_id=<?php echo $visa_order_com_parent_id?>" method="post" style=" margin-top:10px;">
	
	<table class="tbList">
		<tr>
			<td width="100" align="right">����:</td>
			<td width="700">
			<?php if ($is_reply == true){?>			
			<input name="title" type="text" style="width:300px;" value="<?php echo 're:'.$data['title'];?>">			
			<?php
			}else{ 
			?>
			<select name="title" style="width:300px;">
				<option value="��д���">��д���</option>
				<option value="������">������</option>
				<option value="�ύ�ɹ�">�ύ�ɹ�</option>
				<option value="ԤԼ��ǩ">ԤԼ��ǩ</option>
				<option value="����׼��">����׼��</option>
				<option value="��ǩ����">��ǩ����</option>
				<option value="ǩ֤���">ǩ֤���</option>
			</select>
			<?php
			}
			?>
		<span style="color:#FF0000">*</span></td>
		</tr>
		<?php if ($is_reply == true){?>
		<tr>
			<td align="right">����:</td><td><?php echo $data['message'];?></td>
		</tr>
		<?php } ?>
		<tr>
			<td align="right"><?php if ($is_reply == true){ echo '�ظ���';}?>����:</td>
			<td><textarea name="message" cols="50" rows="3"></textarea><span style="color:#FF0000">*</span></td>
		</tr>
		<tr>
			<td align="right">�Ƿ���Ҫ�ظ�:</td>
			<td>
			<label><input name="need_reply" type="radio" value="1" <?php if ($is_reply <> true){?>checked="checked"<?php }?>>�ǵ�,��Ҫ�Է��ظ�</label>
			<label><input name="need_reply" type="radio" value="0" <?php if ($is_reply == true){?>checked="checked"<?php }?>>��,����Ҫ�ظ�</label>
			</td>
		</tr>
		<tr><td></td><td><input name="" type="submit" value="<?php if ($is_reply == true){ echo '�ظ�';}else{ echo '����';}?>"></td></tr>				
	</table>
	</form>
	</div>
	<?php }?>
<?php
	}
	else
	{
		echo 'visa order id error';
	}
	exit();
}

//��·����������
if($_GET['action'] == 'communication_add')
{
	$visa_order_id = (int)$_GET['visa_order_id'];
	$visa_order_com_root_id = (int)$_GET['visa_order_com_root_id'];
	$visa_order_com_parent_id = (int)$_GET['visa_order_com_parent_id'];
	if($visa_order_id>0)
	{
		$data = false;
		
		$data['admin_id'] = $login_id;
		
		$data['title'] = tep_db_prepare_input($_POST['title']);
		$data['message'] = tep_db_prepare_input($_POST['message']);
		$data['need_reply'] = (int)$_POST['need_reply'];
		$data['visa_order_id'] = $visa_order_id;
		$data['add_date'] = date('Y-m-d H:i:s');	
		$data['visa_order_com_root_id'] = $visa_order_com_root_id;
		$data['visa_order_com_parent_id'] = $visa_order_com_parent_id;

		if(tep_not_null($data['title']) && tep_not_null($data['message']) )
		{
			if( $visa_order_com_parent_id >0 )
			{
				$sql = 'UPDATE visa_order_communication SET is_replied=\'1\',is_read=\'1\',read_date=\''.date('Y-m-d H:i:s').'\' WHERE visa_order_com_id='.$visa_order_com_parent_id.' AND admin_id=0  AND is_replied=\'0\'';
				tep_db_query($sql);
			}
			
			tep_db_fast_insert('visa_order_communication',$data);
?>
		<script language="javascript" type="text/javascript">
		alert("��ӳɹ�");
		window.location.href = "visa.php?action=communication&visa_order_id=<?php echo $visa_order_id; ?>";
		</script>
<?php
		}
		else
		{
			echo '<script>alert("ERROR: content empty.."); window.history.go(-1);</script>';
		}
		
	}	
}

//�����Ķ�����֮���ݲ���
if($_GET['action'] == 'communication_read')
{

	$id = (int)$_GET['id'];

	if($id>0)
	{	
		$sql = 'UPDATE visa_order_communication SET is_read=\'1\',read_date=\''.date('Y-m-d H:i:s').'\' WHERE visa_order_com_id='.$id.' AND is_read=\'0\'';
		tep_db_query($sql);
	}
	else
	{
		echo 'ERROR: parameter lost';
		exit();	
	}
}


?>


<?php
if($download != "1")
{
?>
<script language="javascript" type="text/javascript">
jQuery("#tbList tr:even").css("background-color","#EEEEEE"); 
</script>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
<?php
}
?>

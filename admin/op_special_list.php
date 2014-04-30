<?php
require('includes/application_top.php');
// ��ע���ɾ��
$remark_gid = isset($_GET['item']) ? $_GET['item'] : '';
if($_GET['ajax']=="true"){
	include DIR_FS_CLASSES . 'Remark.class.php';
	$remark = new Remark('op_special_list'.$remark_gid);
	$remark->checkAction($_GET['action'], $login_id);//���ɾ��������ͳһ�ڷ������洦����
}

require('includes/classes/op_special_list.php');	//�����ر�ܿ��б�����ļ�

$item = $_GET['item'];
$action = $_GET['action'];
$op_special_list = new op_special_list();

if($_GET['ajax']=="true"){
	if( "addremark" == $_GET['action'])/*�������ע�ļ�¼*/
	{
		$inserted_id = $op_special_list->add_remark($_POST['orders_id'], iconv("utf-8","gb2312",$_POST['remark']), $login_id);

		if ((int)$inserted_id>0)
		{
			echo 'success';
		}else{
			echo 'error: ����ʧ��';
		}
		exit();
	}
}

if($item==''){
	$item = 'need_op_check';
}


switch($item){
	case "op_think_it_problem":
		$orders_id = (int)$_GET['orders_id'];
		if ( ($action == 'finish') && ($orders_id>0) )
		{
			$inderted_id = $op_special_list->finish_problem($orders_id,100135,$login_id);
			tep_add_or_sub_op_think_problems_orders((int)$orders_id, $login_id, 'sub');
			if ($inderted_id > 0)
			{
				echo 'success';
				exit();
			}

		}
		break;
	default:
		break;
}

$admin_list = $op_special_list->admin_list();

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?>  OP�ر�ܿص��б�</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/big5_gb-min.js"></script>
<script language="javascript" src="includes/javascript/add_global.js"></script>
<script type="text/javascript" src="includes/javascript/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="includes/javascript/calendar.js"></script>
<script type="text/javascript" src="includes/javascript/jquery-plugin-TableSort/TableSort.js"></script>
<script type="text/javascript" language="javascript">
function fn_addremark(orders_id)
{
	var s=prompt("������� [ "+orders_id+" ] ���뱸ע������:");
	if (s.length==0){ alert("��������뱸ע����"); return false;}
	if (s.length>100){ alert("���ݳ��ȳ�������"); return false;}

	//ajax		
	var url="op_special_list.php?ajax=true&action=addremark&sid="+Math.random();

	jQuery.post(url, {"remark": s,"orders_id":orders_id }, function (data, textStatus){
		if('success' == data ){
			alert("ok");
			jQuery("#td_"+orders_id).html(s);
		}
		else
		{
			alert(data);
		}
	});	

}
</script>
<style type="text/css">
.tbList { border:1px solid #CCCCCC; border-collapse:collapse;}
.tbList th{ background-color:#006699; color:#FFFFFF; font-weight:bolder; font-size:80%; border:1px solid #CCCCCC; padding:3px;}
.tbList td{ border:1px solid #CCCCCC; padding:3px; font-size:80%;}
.tbList td span.imp2{color:#FF0000; font-weight:bolder;}
.tbList td span.imp1{color:#FF0000; font-weight:normal;}
.tbList td span.imp0{color:#000000; font-weight:normal;}
.tbList tr.bc{ background-color:#EEEEEE}
.tbList .finish{color:#0000FF;}

td.remark{}
td.remark span{color:#999999;}

ul.admin_list{float:left;}
ul.admin_list li{float:left; width:180px; margin:5px 5px;}
ul.admin_list a,ul.admin_list a:visited{padding:3px;}
ul.admin_list a:hover{background-color:#0000FF; color:#FFFFFF;}
a.cur{background-color:#666666; color:#FFFFFF;}
</style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<?php
//echo $login_id;
include DIR_FS_CLASSES . 'Remark.class.php';
$listrs = new Remark('op_special_list'.$remark_gid);
$list = $listrs->showRemark('item='.$remark_gid);
?>
<a href="op_special_list.php?item=need_op_check" <?php if ($item == 'need_op_check') echo 'class="cur"';?>>OP����˵Ķ����б�</a> | 
<a href="op_special_list.php?item=op_think_it_problem" <?php if ($item == 'op_think_it_problem') echo 'class="cur"';?>>����Ա��Ϊ������Ķ���</a>
<?php
if ($item == 'need_op_check'){
	$data = $op_special_list->getlist_need_op_check();
?>
<h2>OP����˵Ķ����б�:���µ����ؽӿ�ʼ����ƾ֤ǰ,��[δ����]��[�Ѹ���δ�µ�]��[�ѷ�����ƾ֤]�����ж���</h2>
<?php
	if(is_array($data)){
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2" class='tbList' id="table_op_special_control">
	<tr role="head">
		<th sort="true">������</th><th sort="true">�ͻ�����</th><th sort="true">�ͻ�email</th>
		<th sort="true">�����ͷ�</th><th sort="true">�µ�����</th>
		<th sort="true">����޸�</th><th sort="true">�޸���</th>
		<th sort="true">��ǰ������</th><th sort="true">��������</th>
		<th sort="true">�ؽ��ź�</th><th sort="true">����״̬</th>
		<th sort="true">�ؽ����ظ�ʱ��</th>
		<th>OP��ע</th>
	</tr>
	<?php for($i=0,$n=count($data); $i<$n; $i++){ ?>
	<tr onMouseOver="c=this.style.backgroundColor;this.style.backgroundColor='#CCFF66'" onMouseOut="this.style.backgroundColor=c">
		<td><a href="edit_orders.php?oID=<?php echo $data[$i]['orders_id'];?>&action=edit"><?php echo $data[$i]['orders_id'];?></a></td>
		<td><?php echo $data[$i]['customers_name'];?></td>
		<td><?php echo $data[$i]['customers_email_address'];?></td>
		<td><?php echo $op_special_list->get_admin_name($data[$i]['orders_owner_admin_id'],$admin_list);?></td>
		<td><?php echo $data[$i]['date_purchased'];?></td>
		<td><?php echo $data[$i]['last_modified'];?></td>
		<td><?php echo $op_special_list->get_admin_name($data[$i]['admin_id_orders'],$admin_list);?></td>
		<td><?php echo $op_special_list->get_admin_name($data[$i]['next_admin_id'],$admin_list);?></td>
		<td><?php $date = new DateTime($data[$i]['products_departure_date']); echo $date->format('Y-m-d');?></td>
		<td><?php echo $data[$i]['provider_tour_code'];?></td>
		<td><?php echo $data[$i]['orders_status_name'];?></td>
		<td><?php echo nl2br(tep_db_output($data[$i]['provider_last_reply_time']));?></td>
		<td class="remark">
		<div id="td_<?php echo $data[$i]['orders_id'];?>"><?php
		$orders_remark = $op_special_list->get_orders_remark($data[$i]['orders_id']);
		if(is_array($orders_remark))
		{
			echo nl2br(tep_db_output($orders_remark['remark'])).'<br/><span>('.$orders_remark['admin_job_number'].','.$orders_remark['add_date'].')</span>';
		}
		?>
		</div>
		<?php if($can_edit_op_special_list===true){?>
		<a href="javascript:void(0)" onClick="fn_addremark(<?php echo $data[$i]['orders_id'];?>)">���</a>
		<?php }?>
		</td>
	</tr>
	<?php
	}
	?>
</table>
<?php
	}else{
		echo '<br/> no data......';
	}
}
if ($item == 'op_think_it_problem'){
	$data = $op_special_list->getlist_eticketsent_op_think_it_problem();
?>
<script language="javascript" type="text/javascript">
function fnFinish(orders_id)
{
	if(confirm("��ȷ�϶���[ "+orders_id+" ] �������Ѿ�����ok��?"))
	{
		var url="op_special_list.php";
		jQuery.get(url, {"item":"op_think_it_problem","action":"finish","orders_id": orders_id}, function (data, textStatus){
			if(data == 'success'){	jQuery('#tr_'+orders_id).hide(); alert("ȷ��OK");}
		});	
	}
}
</script>
<h2>����Ա��Ϊ������Ķ���.</h2>
����:<br/>
<?php
$status_list = $op_special_list->get_status_list();
foreach($status_list AS $key=>$value)
{
	echo $value['os_groups_name'].' => '.$value['orders_status_name'].' (orders_status_id='.$value['orders_status_id'].')<br/>';
}
?>
	
<?php

	if(is_array($data)){
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2" class='tbList' id="table_op_special_control">
	<tr role="head">
		<th>����</th>
		<th sort="true" title="�����������"><span style="cursor:pointer">������</span></th>
		<th>OP��ע</th>
		<th>����״̬</th>
		<th sort="true" title="�����������"><span style="cursor:pointer">��������</span></th>
		<th sort="true" title="�����������"><span style="cursor:pointer">��������</span></th>
		<th sort="true" title="�����������"><span style="cursor:pointer">�µ�����</span></th>
		<th>�ؽ����ظ�ʱ��</th>
		<th sort="true" title="�����������"><span style="cursor:pointer">�ؽ��ź�</span></th>	
		<th sort="true" title="�����������"><span style="cursor:pointer">�ͻ�����</span></th>
		<th sort="true" title="�����������"><span style="cursor:pointer">�ͻ�email</span></th>
		
		
		<th sort="true" title="�����������"><span style="cursor:pointer">����޸�</span></th>
		<th sort="true" title="�����������"><span style="cursor:pointer">�޸���</span></th>
		<th sort="true" title="�����������"><span style="cursor:pointer">��ǰ������</span></th>
		
		



	</tr>
	<?php for($i=0,$n=count($data); $i<$n; $i++){ ?>
	<tr id="tr_<?php echo $data[$i]['orders_id'];?>">
		<td>
		<?php if($can_edit_op_special_list===true){?>
		<input type="button" value="ȷ�ϴ���ok" onClick="fnFinish(<?php echo $data[$i]['orders_id'];?>)"/>
		<?php }else{?>
		<input type="button" value="ȷ�ϴ���ok" disabled />
		<?php }?>
		</td>
		<td><a href="edit_orders.php?oID=<?php echo $data[$i]['orders_id'];?>&action=edit"><?php echo $data[$i]['orders_id'];?></a></td>
		<td class="remark">
		<div id="td_<?php echo $data[$i]['orders_id'];?>"><?php
		$orders_remark = $op_special_list->get_orders_remark($data[$i]['orders_id']);
		if(is_array($orders_remark))
		{
			echo nl2br(tep_db_output($orders_remark['remark'])).'<br/><span>('.$orders_remark['admin_job_number'].','.$orders_remark['add_date'].')</span>';
		}
		?>
		</div>
		<?php if($can_edit_op_special_list===true){?>
		<a href="javascript:void(0)" onClick="fn_addremark(<?php echo $data[$i]['orders_id'];?>)">���</a>
		<?php }?>
		</td>
		<td><?php echo $data[$i]['orders_status_name'];?></td>
		<td><?php echo $op_special_list->get_admin_name($data[$i]['orders_owner_admin_id'],$admin_list);?></td>
		<td><?php echo str_replace(',','<br/>',$data[$i]['products_departure_date']);?></td>
		<td><?php echo str_replace(',','<br/>',$data[$i]['date_purchased']);?></td>
		<td><nobr><?php
			$sql2 = "SELECT op.products_model, MAX(pops.provider_status_update_date) AS provider_last_send_time
    FROM provider_order_products_status_history AS pops, orders_products AS op
    WHERE pops.popc_user_type=1 AND op.orders_id= " . $data[$i]['orders_id'] . " AND pops.orders_products_id = op.orders_products_id
    GROUP BY pops.orders_products_id";
			$result2 = tep_db_query($sql2);
			while ($row = tep_db_fetch_array($result2)) {
				echo $row['products_model'] . '[' . $row['provider_last_send_time'] . ']' . '<br/>';
			}			
		?></nobr></td>
		<td><?php echo str_replace(',','<br/>',$data[$i]['provider_tour_code']);?></td>
		<td><?php echo $data[$i]['customers_name'];?></td>
		<td><?php echo $data[$i]['customers_email_address'];?></td>
		
		<td><?php echo $data[$i]['last_modified'];?></td>
		<td><?php echo $op_special_list->get_admin_name($data[$i]['admin_id_orders'],$admin_list);?></td>
		<td><?php echo $op_special_list->get_admin_name($data[$i]['next_admin_id'],$admin_list);?></td>
		
		

		

	</tr>
	<?php
	}
	?>
</table>
<?php
	}else{
		echo '<br/> no data......';
	}
}
?>
<script language="javascript" type="text/javascript">
jQuery(function () {
	jQuery("#table_op_special_control").sorttable({
		ascImgUrl: "includes/javascript/jquery-plugin-TableSort/bullet_arrow_up.png",
		descImgUrl: "includes/javascript/jquery-plugin-TableSort/bullet_arrow_down.png",
		ascImgSize: "8px",
		descImgSize: "8px",
		onSorted: function (cell) {  }
	});
});

</script>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
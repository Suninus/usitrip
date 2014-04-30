<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
header("Pragma: no-cache");
require 'includes/application_top.php';
// ��ע���ɾ��
if($_GET['ajax']=="true"){
	include DIR_FS_CLASSES . 'Remark.class.php';
	$remark = new Remark('regular_price');
	$remark->checkAction($_GET['action'], $login_id);//���ɾ��������ͳһ�ڷ������洦����
}
// if ($login_id == 246) {
// 	$can_edit_regular_price = 2;
// }
if ($_POST['ajax'] == 'true') {
	if (in_array($_POST['status'],array('update','checked','send'))) {
		$send_message=tep_db_prepare_input($_POST['send_message']);
		switch ($_POST['status']) {
			case 'update':
				switch($can_edit_regular_price){
					case 1:
						$status = '11';
						break;
					/*case 2:
						$status = '21';
						break;*/
					case 2:
						$status = '31';
						$send_message= '0';
						break;
				}
				break;
			case 'checked':
				if ($can_edit_regular_price == 1) {
					$status = '20';
				} else {
					echo '{"status":"error","msg":"Permission Denied"}';
					exit;
				}
				break;
			case 'send':
				if ($can_edit_regular_price == 2) {
					$status = '30';
				} else {
					echo '{"status":"error","msg":"Permission Denied"}';
					exit;
				}
				break;
		}
		$child_ask=tep_db_prepare_input($_POST['child_ask']);
		$child_upset=tep_db_prepare_input($_POST['child_upset']);
		$detail=$_POST['detail'];
		$detail && $detail = iconv('utf-8','gb2312//IGNORE',$detail);
		$detail = tep_db_prepare_input($detail);	
		$double_ask=tep_db_prepare_input($_POST['double_ask']);
		$double_upset=tep_db_prepare_input($_POST['double_upset']);
		$four_ask=tep_db_prepare_input($_POST['four_ask']);
		$four_upset=tep_db_prepare_input($_POST['four_upset']);
		$prices_from=tep_db_prepare_input($_POST['prices_from']);
		$products_id=tep_db_prepare_input($_POST['products_id']);
		
		$single_ask=tep_db_prepare_input($_POST['single_ask']);
		$single_room_ask=tep_db_prepare_input($_POST['single_room_ask']);
		$single_room_upset=tep_db_prepare_input($_POST['single_room_upset']);
		$single_upset=tep_db_prepare_input($_POST['single_upset']);
		$triple_ask=tep_db_prepare_input($_POST['triple_ask']);
		$triple_upset=tep_db_prepare_input($_POST['triple_upset']);
		$gross_profit = tep_db_prepare_input($_POST['gross_profit']);
		// �������ݼ�¼
		$tables = 'products_regular_price';
		$fields = '(products_id,status,detail,single_ask,single_upset,double_ask,double_upset,single_room_ask,single_room_upset,triple_ask,triple_upset,four_ask,four_upset,child_ask,child_upset,prices_from,gross_profit,last_modify)';
		$sql = "replace into " . $tables . $fields . " values ('" . $products_id . "','" . $status . "','" . $detail . "','" . $single_ask . "','" . $single_upset . "','" . $double_ask . "','" . $double_upset . "','" . $single_room_ask . "','" . $single_room_upset . "','" . $triple_ask . "','" . $triple_upset . "','" . $four_ask . "','" . $four_upset . "','" . $child_ask . "','" . $child_upset . "','" . $prices_from . "','" . $gross_profit . "','" . date('Y-m-d H:i:s') . "')";
		$rs = tep_db_query($sql);
		
		// ��¼������ʷ��¼
		$tables = 'products_regular_price_history';
		$fields = '(products_id,status,send_message,detail,single_ask,single_upset,double_ask,double_upset,single_room_ask,single_room_upset,triple_ask,triple_upset,four_ask,four_upset,child_ask,child_upset,prices_from,gross_profit,modify_time,modify_user_id)';
		$sql = "replace into " . $tables . $fields . " values ('" . $products_id . "','" . $status . "','" . $send_message . "','" . $detail . "','" . $single_ask . "','" . $single_upset . "','" . $double_ask . "','" . $double_upset . "','" . $single_room_ask . "','" . $single_room_upset . "','" . $triple_ask . "','" . $triple_upset . "','" . $four_ask . "','" . $four_upset . "','" . $child_ask . "','" . $child_upset . "','" . $prices_from . "','" . $gross_profit . "','" . date('Y-m-d H:i:s') . "','" . $login_id . "')";
		tep_db_query($sql);
		
		// ����Ƿ���״̬���������ݵ���Ʒ��
		if ($status === '30'){ //��30��ʾ״̬��SEND ����Ҫ���µ���Ʒ��
			if ($send_message == '1') {
				require(DIR_WS_CLASSES . 'Price_Change_Alert.class.php');
				$PCA = new Price_Change_Alert;
				//���²�Ʒ�۸�������ʱ�䣨��ǵ������������Ҫ���У�
				$PCA->update_product_price_last_modified($products_id,'Regular Price');
			}
			//��������һ����ۣ�����ǰ��������
			$qijia = false;
			
			$single_ask = floatval($single_ask);
			if ($single_ask > 0) {
				$qijia = $single_ask;
			}
			$double_ask = floatval($double_ask);
			if ($qijia > $double_ask && $double_ask > 0) {
				 $qijia = $double_ask;
			}
			$triple_ask = floatval($triple_ask);
			if ($qijia > $triple_ask && $triple_ask > 0){
				$qijia = $triple_ask;
			}
			$four_ask = floatval($four_ask);
			if ($qijia > $four_ask && $four_ask > 0){
				$qijia = $four_ask;
			}
			// ׼����������
			$data = array();
			$data['products_single'] = $single_ask;
			$data['products_single_cost'] = $single_upset;
			$data['products_single_pu'] = $single_room_ask;
			$data['products_single_pu_cost'] = $single_room_upset;
			$data['products_double'] = $double_ask;
			$data['products_double_cost'] = $double_upset;
			$data['products_triple'] = $triple_ask;
			$data['products_triple_cost'] = $triple_upset;
			$data['products_quadr'] = $four_ask;
			$data['products_quadr_cost'] = $four_upset;
			$data['products_kids'] = $child_ask;
			$data['products_kids_cost'] = $child_upset;
			$data['products_price'] = $qijia;
			$data['products_margin'] = $gross_profit;
			//���µ���Ʒ
			tep_db_fast_update('products', "products_id='".$products_id."'", $data);
		}
		if ($rs) {
			echo '{"status":"ok","permission":"' . $can_edit_regular_price . '"}';	
		}
	} else {
		echo '{"status":"error","msg":"Status Error"}'; 
	}
	exit;
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?>----�����Ʒ�۸�ά��</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/big5_gb-min.js"></script>
<script language="javascript" src="includes/javascript/add_global.js"></script>
<script type="text/javascript" src="includes/jquery-1.3.2/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="includes/javascript/calendar.js"></script>
<style type="text/css">
body,td{font-size:12px;}
.tbList { border:1px solid #CCCCCC; border-collapse:collapse;}
.tbList th{ background-color:#006699; color:#FFFFFF; font-weight:bolder; font-size:90%; border:1px solid #CCCCCC; padding:3px;}
.tbList td{ border:1px solid #CCCCCC; padding:3px; font-size:12px;}
.tbList td span.imp2{color:#FF0000; font-weight:bolder;}
.tbList td span.imp1{color:#FF0000; font-weight:normal;}
.tbList td span.imp0{color:#000000; font-weight:normal;}
.tbList tr.bc{ background-color:#EEEEEE}
.tbList .finish{color:#0000FF;}
.input{width:60px;}
</style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<?php 
require(DIR_WS_INCLUDES . 'header.php'); 
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>
<h1>��Ʒ����۸���ٸ���</h1>
<?php
//echo $login_id;
include DIR_FS_CLASSES . 'Remark.class.php';
$listrs = new Remark('regular_price');
$list = $listrs->showRemark();
?>
<fieldset>
<legend style="text-align:left">��������</legend>
<form name="" action="" method="get">
<table width="100%"><tr><td width="100">��ƷID���ţ�</td>
<td><input type="text" name="products_id" value="<?php echo isset($_GET['products_id']) ? $_GET['products_id'] : ''?>"/></td></tr>
<tr>
	<td><?php 
	$agency_sql = "select agency_id,agency_name from tour_travel_agency order by agency_id desc";
	$agency_result = tep_db_query($agency_sql);
	$data = array(array('id'=>'','text'=>'--none--'));
	while ($agency_rs = tep_db_fetch_array($agency_result)) {
		$data[] = array('id'=>$agency_rs['agency_id'],'text'=>$agency_rs['agency_name']);
	}
	?>�ؽ��̱�ţ�</td>
	<td><?php echo tep_draw_pull_down_menu('agency_id', $data, tep_db_input($_GET['agency_id']), ' id="agency_id"');//$rs['agency_id']?></td>
<tr>
	<td>��Ӧ���źţ�</td>
	<td><input type="text" name='provider_tour_code' value="<?php echo tep_db_input($_GET['provider_tour_code'])?>" id="provider_tour_code"/></td>
</tr>
<tr>
	<td>���ڣ�</td>
	<td><input type="text" name="products_durations" value="<?php echo tep_db_input($_GET['products_durations'])?>" id="products_durations"/><select name="products_durations_type">
	<option value="0">��</option>
	<option value="1">Сʱ</option>
	<option value="2">����</option>
	</select></td>
</tr>
<tr>
	<td>״̬��</td>
	<td><select name="status">
	<option value="">����</option>
	<option value="11" <?php if ($status == 11) echo 'selected'?>>��Ʒ�༭���ϴ�</option>
	<option value="20" <?php if ($status == 20) echo 'selected'?>>��Ʒ�༭�Ѹ���</option>
	<option value="21" <?php if ($status == 21) echo 'selected'?>>��Ʒ�༭���ϴ�</option>
	<option value="31" <?php if ($status == 31) echo 'selected'?>>���������Ʒ�������ϴ�</option>
	<option value="30" <?php if ($status == 30) echo 'selected'?>>���������Ʒ�����ѿ���</option>
	</select></td>
</tr>
<tr>
	<td colspan="2">
	&nbsp;<input type="button" onClick="location.href='<?php echo tep_href_link('regular_price.php',tep_get_all_get_params_fix('','products_id,provider_tour_code,status,agency_id'));?>'" value="�����������" />&nbsp;<input type="submit" value="��&nbsp;&nbsp;&nbsp;&nbsp;��" />
	</td>
</tr>
</table>
</form>
</fieldset>

<fieldset style="position:relative">
	<legend style="text-align:left">�б�</legend>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#header').css('width',jQuery('#t_conter').width());
	jQuery(window).scroll(function(){
		if (jQuery(window).scrollTop() >= (jQuery('#t_conter').offset().top-63)) {
			jQuery('#header').css({'position':'fixed','top':'0','left':(jQuery(window).scrollLeft()*-1)+jQuery('#t_conter').offset().left});
			
		} else {
			jQuery('#header').css({'position':'absolute','top':'','left':''});
		}
	});
	jQuery(window).resize(function(){
		jQuery('#header').css('width',jQuery('#t_conter').width());
	});
});
</script>
<?php 
$href_get_params = tep_get_all_get_params(array('page', 'action', 'sort', 'order'));
$img_up = '<img src="images/arrow_up.gif" border="0">';
$img_down = '<img src="images/arrow_down.gif" border="0">';
?>
	<table class="tbList" id="header" width="100%" style="min-width:1566px;position:absolute;">
		<tr>
			<th colspan="3"></th>
			<th colspan="6">����</th>
			<th colspan="6">�׼�</th>
			<th colspan="7"></th>
		</tr>
		<tr>
			<th style="width:100px;">��Ӧ���ź�<br/>
			<a href="<?php echo tep_href_link('regular_price.php','sort=provider_tour_code&order=asc&'.$href_get_params)?>"><?php echo $img_up?></a>
			<a href="<?php echo tep_href_link('regular_price.php','sort=provider_tour_code&order=desc&'.$href_get_params)?>"><?php echo $img_down ?></a></th>
			<th style="width:80px;">��Ʒ���<br/>
			<a href="<?php echo tep_href_link('regular_price.php','sort=products_model&order=asc&'.$href_get_params)?>"><?php echo $img_up?></a>
			<a href="<?php echo tep_href_link('regular_price.php','sort=products_model&order=desc&'.$href_get_params)?>"><?php echo $img_down ?></a></th>
			<th style="width:40px;">����</th>
			<th style="width:60px;">���˼۸�</th>
			<th style="width:60px;">�����䷿</th>
			<th style="width:60px;">˫�˼۸�</th>
			<th style="width:60px;">���˼۸�</th>
			<th style="width:60px;">���˼۸�</th>
			<th style="width:60px;">С���۸�</th>
			<th style="width:60px;">���˼۸�</th>
			<th style="width:60px;">�����䷿</th>
			<th style="width:60px;">˫�˼۸�</th>
			<th style="width:60px;">���˼۸�</th>
			<th style="width:60px;">���˼۸�</th>
			<th style="width:60px;">С���۸�</th>
			<!--<th>���</th>-->
			<th style="width:65px;">ë����</th>
            <th style="width:46px;"></th>
			<th style="width:85px;">���ռ۸�</th>
			<th style="width:50px;">״̬</th>
			<?php if ($can_edit_regular_price == 2) {?>
			<th style="width:40px;" title="֪ͨ����">֪ͨ</th>
			<?php }?>
			<th style="main-width:95px;">��ע</th>
			<th style="width:96px;">����</th>
		</tr>
		</table>

		<table class="tbList" id="t_conter" width="100%" style="min-width:1566px;margin-top:63px;">
		<?php
		//�������� start
		$where = "p.products_status=1";
		if (isset($_GET['products_id']) && tep_not_null($_GET['products_id'])) {
			$where .= " and (p.products_id = '" . tep_db_prepare_input(intval($_GET['products_id'])) . "' Or p.products_model = '" . tep_db_prepare_input($_GET['products_id']) . "')";
		}
		if (isset($_GET['provider_tour_code']) && tep_not_null($_GET['provider_tour_code'])) {
			$where .= " and p.provider_tour_code like '%" . tep_db_prepare_input($_GET['provider_tour_code']) . "%'";
		}
		if (isset($_GET['status']) && is_numeric($_GET['status'])) {
			$where .= " and prp.status = '" . intval($_GET['status']) . "'";
		}
		if (isset($_GET['agency_id']) && is_numeric($_GET['agency_id']) && intval($_GET['agency_id']) > 0) {
			$where .= " and p.agency_id='" . intval($_GET['agency_id']) . "'";
		}
		if (isset($_GET['products_durations']) && is_numeric($_GET['products_durations'])) {
			$where .= " and p.products_durations_type = '" . intval($_GET['products_durations_type']) . "'";
			$where .= " and p.products_durations = '" . tep_db_prepare_input($_GET['products_durations']) . "'";
		}
		//�������� end

		//���� start
		$orderby = ' order by ';
		$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
		$order = isset($_GET['order']) ? $_GET['order'] : '';
		switch ($sort) {
			case 'provider_tour_code':
				$sort = 'p.provider_tour_code';
				break;
			case 'products_model':
				$sort = 'p.products_model';
				break;
			default:
				$sort = '';
		}
		if ($order == 'asc' && $sort != '') {
			$orderby .= $sort . ' asc,';
		} elseif ($order == 'desc' && $sort != '') {
			$orderby .= $sort . ' desc,';
		}
		$orderby .= 'prp.last_modify desc';
		
		//���� end
		$sql = "select p.products_id as pid,p.products_durations_type,p.products_durations,p.provider_tour_code,p.products_model,p.products_single,p.products_double,p.products_triple,p.products_quadr,prp.* from products as p left join products_regular_price as prp on prp.products_id=p.products_id where " . $where . $orderby;
		$keywords_query_numrows = 0;
		$pageMaxRowsNum = 40; //ÿҳ��ʾ10����¼
		$_split = new splitPageResults($_GET['page'], $pageMaxRowsNum, $sql, $keywords_query_numrows);
		$result = tep_db_query($sql);
		$i = 0;
		while ($row = tep_db_fetch_array($result)) {
		?>
		<tr id="tr_<?php echo $row['pid']?>">
			<td style="width:100px;"><?php echo $row['provider_tour_code']?></td>
			<td style="width:80px;"><?php echo $row['products_model']?></td>
			<td style="width:40px;"><?php 
			//������
			switch ($row['products_durations_type ']) {
				case 0:
					echo $row['products_durations'] . '��';
					break;
				case 1:
					echo $row['products_durations'] . 'Сʱ';
					break;
				case 2:
					echo $row['products_durations'] . '����';
					break;
			}
			?></td>
			<td style="width:60px;"><input class="input" type="text" name="single_ask" value="<?php echo $row['single_ask']?>"/></td>
			<td style="width:60px;"><input class="input" type="text" name="single_room_ask" value="<?php echo $row['single_room_ask']?>"/></td>
			<td style="width:60px;"><input class="input" type="text" name="double_ask" value="<?php echo $row['double_ask']?>"/></td>
			<td style="width:60px;"><input class="input" type="text" name="triple_ask" value="<?php echo $row['triple_ask']?>"/></td>
			<td style="width:60px;"><input class="input" type="text" name="four_ask" value="<?php echo $row['four_ask']?>"/></td>
			<td style="width:60px;"><input class="input" type="text" name="child_ask" value="<?php echo $row['child_ask']?>"/></td>
			
			
			<td style="width:60px;"><input class="input" type="text" name="single_upset" value="<?php echo $row['single_upset']?>"/></td>
			<td style="width:60px;"><input class="input" type="text" name="single_room_upset" value="<?php echo $row['single_room_upset']?>"/></td>
			<td style="width:60px;"><input class="input" type="text" name="double_upset" value="<?php echo $row['double_upset']?>"/></td>
			<td style="width:60px;"><input class="input" type="text" name="triple_upset" value="<?php echo $row['triple_upset']?>"/></td>
			<td style="width:60px;"><input class="input" type="text" name="four_upset" value="<?php echo $row['four_upset']?>"/></td>
			<td style="width:60px;"><input class="input" type="text" name="child_upset" value="<?php echo $row['child_upset']?>"/></td>
			<!--<td><?php 
					$qijia = false;
					// ��׼�
					if ($row['products_single'] > 0) {
						$qijia = $row['products_single'];
					}
					if ($qijia > $row['products_double'] && $row['products_double'] >0) {
						 $qijia = $row['products_double'];
					}
					if ($qijia > $row['products_triple'] && $row['products_triple'] > 0){
						$qijia = $row['products_triple'];
					}
					if ($qijia > $row['products_quadr'] && $row['products_quadr']>0){
						$qijia = $row['products_quadr'];
					}
			?><input type="text" readonly="true" name="prices_from" value="<?php echo $qijia?>"/></td>-->
			<td style="width:70px;"><input type="button" onClick="gross('<?php echo $row['pid']?>')" value="��ë��"/><br/><input class="input" type="text" name="gross_profit" value="<?php echo $row['gross_profit']?>"/></td>
            <td style="width:46px;"><?php if ($i>0){?><input type="button" onClick="copy_to_pre(this)" value="ͬ��" /><?php }?></td>
			<td style="width:85px;"><a href="<?php echo tep_href_link('categories.php','pID=' . $row['pid'] .  '&action=new_product')?>" target="_blank" title="����鿴���ռ۸�">���ռ۸�</a></td>
			<td style="width:50px;" class="status_<?php echo $row['pid']?>"><?php
			switch($row['status']) {
				case '11':
					echo '<span title="���ϴ�">���ϴ�</span>';
					break;
				case '21':
					echo '<span title="���ϴ�">���ϴ�</span>';
					break;
				case '20':
					echo '<span title="�Ѹ���">�Ѹ���</span>';
					break;
				case '31':
					echo '<span title="���ϴ�">���ϴ�</span>';
					break;
				case '30':
					echo '<span title="�ѿ���" style="color:#f00">�ѿ���</span>';
					break;
				default:
					echo 'δ֪';
			}
			?></td>
			<?php if ($can_edit_regular_price == 2) {?>
			<td style="width:40px;"><input type="checkbox" name="send_message" checked="checked" value="1"/></td>
			<?php }?>
			<td><textarea  style="width:95px;height:50px;" name="detail"><?php echo $row['detail']?></textarea></td>
			<td style="width:96px;"><?php
			switch($can_edit_regular_price){
				case 0:
					echo '<input type="button" onClick="Save(\''.$row['pid'].'\',\'update\')" value="�ϴ�"/>';
					break;
				case 1:
					echo '<input type="button" onClick="Save(\''.$row['pid'].'\',\'update\')" value="�ϴ�"/>';
					echo '<br/><input  type="button" onClick="Save(\''.$row['pid'].'\',\'checked\')" value="��������"/>';
					echo '<br/><input type="button" onClick="window.open(\'' . tep_href_link('regular_price_history.php','products_id=' . $row['pid']) . '\')" value="������¼" />';
					break;
				case 2:
					echo '<input type="button" onClick="Save(\''.$row['pid'].'\',\'update\')" value="�ϴ�"/><br/><input type="button" onClick="Save(\''.$row['pid'].'\',\'send\')" value="����"/>';
					echo '<br/><input type="button" onClick="window.open(\'' . tep_href_link('regular_price_history.php','products_id=' . $row['pid']) . '\')" value="������¼" />';
					break;
				default:
					echo '��Ȩ����';
			}
			?></td>
		</tr>
		<?php 
			$i++;
		}
		?>
		<tr>
			<td colspan="22" align="center"><?php echo $_split->display_links($_split->query_num_rows,$pageMaxRowsNum,6, $_GET['page'],tep_get_all_get_params(array('page')))?></td>
		</tr>
	</table>
</fieldset>
<script type="text/javascript">
function copy_to_pre(obj){
	var cur = jQuery(obj).parents('tr');
	var pre = cur.prev('tr');
	var arr =['single_ask','single_room_ask','double_ask','triple_ask','four_ask','child_ask',
	           'single_upset','single_room_upset','double_upset','triple_upset','four_upset','child_upset','gross_profit'];
	for(name in arr){
		cur.find('input[name="' + arr[name] + '"]').val(pre.find('input[name="' + arr[name] + '"]').val());
	}
}
function Save(pid,action){
	var tr = jQuery('#tr_' + pid);
	var str = 'products_id=' + pid + '&ajax=true&status=' + action;
	var gross_profit = tr.find('input[name="gross_profit"]').val();
	if (isNaN(parseFloat(gross_profit)) ||  parseFloat(gross_profit)<= 0) {
		alert('��û��ë����!');
		return;
	}
	var single_ask = tr.find('input[name="single_ask"]').val();
	single_ask = single_ask || 0;
	var single_upset = tr.find('input[name="single_upset"]').val();
	single_upset = single_upset || 0;
	var single_room_ask = tr.find('input[name="single_room_ask"]').val();
	single_room_ask = single_room_ask || 0;
	var single_room_upset = tr.find('input[name="single_room_upset"]').val();
	single_room_upset = single_room_upset || 0;
	var double_ask = tr.find('input[name="double_ask"]').val();
	double_ask = double_ask || 0;
	var double_upset = tr.find('input[name="double_upset"]').val();
	double_upset = double_upset || 0;
	var triple_ask = tr.find('input[name="triple_ask"]').val();
	triple_ask = triple_ask || 0;
	var triple_upset = tr.find('input[name="triple_upset"]').val();
	triple_upset = triple_upset || 0;
	var four_ask = tr.find('input[name="four_ask"]').val();
	four_ask = four_ask || 0;
	var four_upset = tr.find('input[name="four_upset"]').val();
	four_upset = four_upset || 0;
	var child_ask = tr.find('input[name="child_ask"]').val();
	child_ask = child_ask || 0;
	var child_upset = tr.find('input[name="child_upset"]').val();
	child_upset = child_upset || 0;
	var prices_from = tr.find('input[name="prices_from"]').val();
	prices_from = prices_from || 0;
	var send_message = tr.find('input[name="send_message"]:checked').val();
	send_message = send_message || 0;
	var detail = tr.find('textarea[name="detail"]').val();
	str += '&single_ask=' + single_ask + '&single_upset=' + single_upset + '&single_room_ask=' + single_room_ask + '&single_room_upset=' + single_room_upset + 
	'&double_ask=' + double_ask + '&double_upset=' + double_upset + '&triple_ask=' + triple_ask + '&triple_upset=' + triple_upset + '&four_ask=' + four_ask + 
	'&four_upset=' + four_upset + '&child_ask=' + child_ask + '&child_upset=' + child_upset + '&prices_from=' + prices_from + '&send_message=' + send_message + '&detail=' + detail + 
	'&gross_profit=' + gross_profit;
	jQuery.post('<?php echo tep_href_link_noseo('regular_price.php')?>',str,function(r){
		if(r.status == 'ok') {
			var status_obj =  tr.find('.status_' + pid);
			console.log(status_obj);
			switch(action){
				case 'update':
					switch(r.permission) {
						case '0':
							status_obj.html('<span title="��Ʒ�༭���ϴ�">���ϴ�</span>');
							break;
						case '1':
							status_obj.html('<span title="��Ʒ�������ϴ�">���ϴ�</span>');
							break;
						case '2':
							status_obj.html('<span title="�������ϴ�">���ϴ�</span>');
							break;
					}	
					alert('���³ɹ�!');
					break;
				case 'checked':
					status_obj.html('<span title="��Ʒ�����Ѹ���">�Ѹ���</span>');
					alert('�˶�ȷ�ϲ����ɹ���');
					break;
				case 'send':
					status_obj.html('<span title="�����ѿ���" style="color:red">�ѿ���</span>');
					alert('��˲����ɹ���');
					break;
			}
		} else {
			if (r.msg) {
				alert(r.msg);
			}else
				alert('����ʧ�ܣ�');
		}
	},'json');

}

function gross(pid){
	var tr = jQuery('#tr_' + pid);
	var Retail = tr.find('input[name="single_ask"]').val();
	var Cost = tr.find('input[name="single_upset"]').val();
	var productsMargin = 0;
	if (parseFloat(Retail) > 0 && parseFloat(Cost) > 0) {
		productsMargin = (((Retail-Cost)/Retail)*100).toFixed(2);
	} else {
		alert('��ԭ�ۺ�����û��д�أ�'); 
		return false;
	}
	tr.find('input[name="gross_profit"]').val(productsMargin);
	if( productsMargin < 1){
		alert('�������͵׼ۣ�������˾Ҫ��Ǯ׬����');
	}
};
</script>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>



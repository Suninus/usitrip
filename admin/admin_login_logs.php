<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
header("Pragma: no-cache");
include 'includes/application_top.php';
require(DIR_FS_CLASSES . 'AdminLoginLogs.class.php');
$action = isset($_GET['action']) ? $_GET['action'] : '';
$chkbox = isset($_GET['delid']) ? array($_GET['delid']) : '';
if (!$action) {
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	$chkbox = isset($_POST['chkbox']) ? $_POST['chkbox'] : '';
}
if ($action == 'del' && $chkbox) {
	$delobj = new AdminLoginLogs();
	print_r($chkbox);

	$delobj->del($chkbox);
	$messageStack->add_session('�ɹ�ɾ����¼','success');
	tep_redirect(tep_href_link('admin_login_logs.php'));
	exit;
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?>----�ڲ�ʹ��</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/big5_gb-min.js"></script>
<script language="javascript" src="includes/javascript/add_global.js"></script>
<script type="text/javascript" src="includes/jquery-1.3.2/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="includes/javascript/calendar.js"></script>
<script language="javascript" type="text/javascript">
function checkForm1()
{
	var toid=$("#to_login_id_add").val(); if(toid.length==0){ alert("��ѡ�����Զ���!"); return false;}
	var scontent=$("#content_add").val(); if(scontent.length<5){ alert("������������Ҫ5����"); return false;}
}
</script>
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
</style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php 
require(DIR_WS_INCLUDES . 'header.php'); 
$startdate = isset($_GET['date_start']) ? $_GET['date_start'] : '';
$enddate = isset($_GET['date_end']) ? $_GET['date_end'] : '';
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$jobnumber = isset($_GET['jobnumber']) ? $_GET['jobnumber'] : '';
// if ($messageStack->size > 0) {
// 	echo $messageStack->output();
// }
?>
<h1>��̨����Ա��¼��־����</h1>
<!-- header_eof //-->
<fieldset>
<legend style="text-align:left">��������</legend>
<form action="" method="get">
	��¼ʱ�䣺
	<?php echo tep_draw_input_num_en_field('date_start',$startdate,'style="ime-mode: disabled;" onclick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" class="textTime"');?>
	��
	<?php echo tep_draw_input_num_en_field('date_end',$enddate,'style="ime-mode: disabled;" onclick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" class="textTime"');?>
	IP��
	<input type="text" value="<?php echo tep_db_input($ip)?>" name="ip" id="ip" />
	���ţ�
	<input type="text" value="<?php echo tep_db_input($jobnumber)?>" name="jobnumber" id="jobnumber" />
	<input type="submit" value="����" /> <input type="button" value="�����������" onclick="location.href='<?php echo tep_href_link('admin_login_logs.php',tep_get_all_get_params(array('date_start','date_end','ip','jobnumber')))?>'" />
</form>
</fieldset>
<?php
		$list = new AdminLoginLogs($startdate,$enddate,$ip,$jobnumber,40);
		$listRs = $list->getList();
?>
<fieldset>
<legend style="text-align:left">�б�</legend>
<form action="" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr class="tbList">
			<th>ID</th>
			<th><input type="checkbox" onClick="if(this.checked == true){jQuery('input[name=\'chkbox[]\']').attr('checked',true);}else{jQuery('input[name=\'chkbox[]\']').attr('checked',false);}" /></th>
			<th>����</th>
			<th>��¼IP</th>
			<th>�鿴IP���ڵ�</th>
			<th>��¼ʱ��</th>
			<th>��ز���</th>
		</tr>
		<?php
		foreach ($listRs['list'] as $key => $row){
		?>
		<tr class="tbList">
			<td align="center"><?php echo $row['id']?></td>
			<td align="center"><input type="checkbox" name="chkbox[]" value="<?php echo $row['id']?>" /></td>
			<td><?php echo $row['admin_job_number']?></td>
			<td><?php echo $row['ip']?></td>
			<td><a HREF="http://www.dnsstuff.com/tools/whois.ch?ip=<?php echo $row['ip']; ?>" target="_blank">1</A>&nbsp;<a HREF="http://openrbl.org/#<?php echo $row['ip']; ?>" target="_blank">2</A>&nbsp;<a href="http://www.ip138.com/ips.asp?ip=<?php echo $row['ip']; ?>&action=2" target="_blank">3</a></td>
			<td><?php echo $row['time']?></td>
			
			
			<td><a href="?action=del&delid=<?php echo $row['id']?>" onClick="if(confirm('��ȷ��Ҫɾ���˼�¼�𣿸ò��������棡')){} else {return false}">ɾ��</a></td>
		</tr>
		<?php 
		}?>
		<tr>
			<td></td>
			<td align="center"><input type="checkbox" onClick="if(this.checked == true){jQuery('input[name=\'chkbox[]\']').attr('checked',true);}else{jQuery('input[name=\'chkbox[]\']').attr('checked',false);}" />ȫѡ</td>
			<td colspan="7"><input type="button" value="��ѡ" onClick="unselect()"/> <input type="button" onClick="if(confirm('��ȷ��Ҫ����ɾ����Щ��¼�𣿸ò��������棡')){this.form.submit();} else {return false}" value="����ɾ��ѡ��" /></td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="action" value="del"/>
</form>
<div style="text-align:center"><?php echo $listRs['pagelink'] . $listRs['pagecount'];//$_split->display_links($_split->query_num_rows,$pageMaxRowsNum,6, $_GET['page'])?></div>
</fieldset>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<script type="text/javascript">
function unselect(){
	jQuery('input[name=\'chkbox[]\']').each(function(){
		if($(this).attr('checked')){
			$(this).attr('checked',false);
		} else {
			$(this).attr('checked',true);
		}
	});
}
</script>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>



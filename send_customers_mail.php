<?php
/*require('includes/application_top.php');
if($customer_id!="xmzhh2000@126.com"){
	print_r($_SESSION);
	die('Plx use xmzhh2000@126.com to Login !');
}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
</head>
<body>
*/?>
<?php
// get cus data
$where_exc = ' ';
//$where_exc .= ' AND ( customers_email_address ="xmzhh2000@gmail.com" || customers_email_address ="veraeland@gmail.com") ';
if((int)$customer_id){
	$sql = tep_db_query('SELECT customers_id,customers_firstname, customers_email_address FROM `customers` WHERE customers_id = "'.(int)$customer_id.$where_exc.'" Order By customers_id limit 1');
}
/*else{
	$sql = tep_db_query('SELECT customers_id,customers_firstname, customers_email_address FROM `customers` WHERE customers_id > 0 '.$where_exc.' Order By customers_id limit 1');
}*/

$row = tep_db_fetch_array($sql);
if(!(int)$row['customers_id']){
	die();
}

$email_text = '
<div style="clear: both; width: 600px; height:1000px; margin: 0px; padding:0px; background-color:#FFFFFF; font-size:12px; color:#223C6A; " ><form id="form1" name="form1" method="post" action="'.HTTP_SERVER.'/customers-feedback.php" target="_blank"><input name="customers_email_address" type="hidden" id="customers_email_address" value="'.$row['customers_email_address'].'" /><div style="width: 600px; float: none; margin-right: auto; margin-left: auto; clear: both; display: inline;"><div style="float:left; width:600px;"> <img src="'.HTTP_SERVER.'/image/newsletter2_r2_c2.jpg" width="600" height="13"/></div><div style="background-color:#223C6A; float :left; width:600px;"><div style="margin-bottom:4px; margin-left:3px; margin-top:4px; float:left"><img src="'.HTTP_SERVER.'/image/logo.gif" width="230" height="54" /></div></div></div><table width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#108BCD" style="margin-top:1px; color:#FFFFFF; float:left; font-size:12px;"><tr><td width="391" style="padding-left:3px;" ><p style="margin:0px;"><b>�𾴵�'.$row['customers_firstname'].'���ã�</b></p><p style="margin:0px;">Ϊ�˸�л�������ķ�����'.$_SERVER['HTTP_HOST'].'����֧�֣�ͬʱ���ϵ���<br />�����ķ����ķ���ˮƽ�;�Ӫ�����������ص��Ƴ��´��ͻ���������ƻ��� </p></td><td width="209" ><img src="'.HTTP_SERVER.'/image/banner_huikui.jpg" width="209" height="71" /></td></tr></table><div style="font-family:\'����\'; font-size: 12px; font-weight: bold; text-decoration: none; background-color: # FDD01B; width: 597px; padding: 5px 0px 3px 3px; float: left; margin-top:5px; color:#223C6A; margin-bottom: 4px;">ֻҪ�μ����ǵĵ�������ƻ������Ϳ��Ի�����ķ����ṩ��20��Ԫ�����δ���ȯ�� </div><p style="width:100%; float:left; line-height:16px; color:#223C6A; margin:0px; padding:3px 0px 3px 0px;">�˴���ȯ��������Ԥ��������վ��Ʒ��ʱ��ʹ�á�������Ԥ����Ʒ��ʱ����������д���Ǹ����ṩ�Ĵ���ȯ���룬�ô���ȯ��ֵ<strong>20</strong>��Ԫ�� <br />  �˵������ʱ��Ϊ<strong>2008��12��8��</strong>��<strong>2009��2��8��</strong>�� </p><table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%; float:left; margin-bottom:5px;">   <tr>     <td bgcolor="#FFF5CC" style="border:1px #FFCC00 solid; padding:4px 0px 4px 3px; color:#223C6A; font-size:12px;"><b>��ϸ�������£�</b></td>   </tr>   <tr>     <td style="border:1px #FFCC00 solid; border-top:0px; padding:2px 0px 2px 3px;">     <table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">   <tr>     <td width="12%" height="32" style="font-size:12px; color:#223C6A;">1����������</td>     <td width="4%" valign="middle">       <label>         <input type="radio" name="tours_age" id="tours_age0" value="18" />         </label> </td>     <td width="10%" style="font-size:12px; color:#223C6A;">18������</td>     <td width="4%">       <label>         <input type="radio" name="tours_age" id="tours_age1" value="18-30" />         </label>     </td>     <td width="8%" style="font-size:12px; color:#223C6A;">18-30</td>     <td width="4%">       <label>         <input type="radio" name="tours_age" id="tours_age2" value="31-45" />         </label>     </td>     <td width="8%" style="font-size:12px; color:#223C6A;">31-45</td>     <td width="4%">       <label>         <input type="radio" name="tours_age" id="tours_age3" value="45-60" />         </label>     </td>     <td width="8%" style="font-size:12px; color:#223C6A;">45-60</td>     <td width="4%">       <label>         <input type="radio" name="tours_age" id="tours_age4" value="60" />         </label>     </td>     <td width="34%" style="font-size:12px; color:#223C6A;">60����</td>   </tr></table>  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
<tr bgcolor="#FFFBEB">
<td width="12%" height="32" style="font-size:12px; color:#223C6A;">2�������Ա�</td>
<td width="4%">
<label>
<input type="radio" name="tours_gender" id="tours_gender0" value="m" />
</label>

</td>
<td width="10%" style="font-size:12px; color:#223C6A;">��</td>
<td width="4%">
<label>
<input type="radio" name="tours_gender" id="tours_gender1" value="f" />
</label>

</td>
<td width="70%" style="font-size:12px; color:#223C6A;">Ů</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
<tr>
<td width="13%" height="26" style="font-size:12px; color:#223C6A;">3������ְҵ</td>
<td width="87%">
<label>
<select name="tours_job" id="tours_job" style="font-size:12px; color:#223C6A;">
<option value="0">����ְҵ</option>
<option value="1">������</option>
<option value="2">IT</option>
<option value="3">����</option>
<option value="4">ѧ��</option>
<option value="5">��е</option>
<option value="6">����</option>
<option value="7">��Դ</option>
<option value="8">ҽ��</option>
<option value="9">��������</option>
<option value="10">����</option>
</select>
</label>

</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
<tr bgcolor="#FFFBEB">
<td width="17%" height="32" style="font-size:12px; color:#223C6A;">4���������ΰ���</td>
<td width="83%">
<label>
<select name="tours_like" id="tours_like" style="font-size:12px; color:#223C6A;">
<option value="0">������</option>
<option value="1">�Լ���</option>
<option value="2">����</option>
<option value="3">ֱ������</option>
<option value="4">�ɻ���</option>
<option value="5">����</option>
<option value="6">������</option>
<option value="7">��Ȼ����</option>
<option value="8">����</option>
</select>
</label> </td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%; ">
<tr>
<td height="32" colspan="13" style="font-size:12px; color:#223C6A;">5������ͨ�����ַ�ʽ֪������վ�ģ� </td>
</tr>
<tr>
<td width="3%" height="28" style="font-size:12px; color:#223C6A;">&nbsp;</td>
<td width="4%" valign="middle">
<label>
<input type="radio" name="tours_from" id="tours_from0" value="google" />
</label>
</td>
<td width="13%" style="font-size:12px; color:#223C6A;">Google�ȸ�</td>
<td width="4%">
<label>
<input type="radio" name="tours_from" id="tours_from1" value="baidu" />
</label>
</td>
<td width="13%" style="font-size:12px; color:#223C6A;">Baidu�ٶ�</td>
<td width="4%">
<label>
<input type="radio" name="tours_from" id="tours_from2" value="yahoo" />
</label>
</td>
<td width="12%" style="font-size:12px; color:#223C6A;">Yahoo�Ż�</td>
<td width="4%">
<label>
<input type="radio" name="tours_from" id="tours_from3" value="bbs" />
</label>
</td>
<td width="11%" style="font-size:12px; color:#223C6A;">��̳</td>
<td width="4%">
<label>
<input type="radio" name="tours_from" id="tours_from4" value="friend" />
</label>
</td>
<td width="12%" style="font-size:12px; color:#223C6A;">�����Ƽ�</td>
<td width="4%" style="font-size:12px; color:#223C6A;">
<label>
<input type="radio" name="tours_from" id="tours_from4" value="other" />
</label>
</td>
<td width="12%" style="font-size:12px; color:#223C6A;">����</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
<tr bgcolor="#FFFBEB">
<td width="22%" height="32" style="font-size:12px; color:#223C6A;">6�����Ա�վ���������</td>
<td width="4%" valign="middle">
<label>
<input type="radio" name="ServicesEval" id="ServicesEval0" value="0" />
</label>
</td>
<td width="8%" style="font-size:12px; color:#223C6A;">����</td>
<td width="4%">
<label>
<input type="radio" name="ServicesEval" id="ServicesEval1" value="1" />
</label>
</td>
<td width="8%" style="font-size:12px; color:#223C6A;">����</td>
<td width="4%">
<label>
<input type="radio" name="ServicesEval" id="ServicesEval2" value="2" />
</label>
</td>
<td width="9%" style="font-size:12px; color:#223C6A;">�е�</td>
<td width="4%">
<label>
<input type="radio" name="ServicesEval" id="ServicesEval3" value="3" />
</label>
</td>
<td width="8%" style="font-size:12px; color:#223C6A;">����</td>
<td width="4%">
<label>
<input type="radio" name="ServicesEval" id="ServicesEval4" value="4" />
</label>
</td>
<td width="7%" style="font-size:12px; color:#223C6A;">��</td>
<td width="4%" style="font-size:12px; color:#223C6A;">
<label>
<input type="radio" name="ServicesEval" id="ServicesEval5" value="5" />
</label>
</td>
<td width="14%" style="font-size:12px; color:#223C6A;">�ܲ�</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
<tr>
<td width="34%" height="26" style="font-size:12px; color:#223C6A;">7�����������ƽ��ÿ����м��Σ� </td>
<td width="66%">
<label>
<select name="tours_number" id="tours_number" style="font-size:12px; color:#223C6A;">
<option value="0">0</option>
<option value="0-1">0~1��</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5������</option>
</select>
</label>

</td>
</tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%;">
<tr>
<td height="26" nowrap="nowrap" style="font-size:12px; color:#223C6A;">8��������������Ҫ������Щ�����ҵ��/���� </td>
<td><label>
<input type="radio" name="tours_add_server" value="0" />��Ʊ 
</label></td>
<td>
<input type="radio" name="tours_add_server" value="1" />ǩ֤ 
</td>
<td>
<input type="radio" name="tours_add_server" value="2" />�⳵
</td>
<td><input type="radio" name="tours_add_server" value="3" />����</td>
</tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFBEB" style="width:100%; ">
<tr>
<td height="32" colspan="11" style="font-size:12px; color:#223C6A;">9�����Ƽ���վ��Ʒ����������û��
</td>
</tr>
<tr>
<td width="4%" height="20" style="font-size:12px; color:#223C6A;">&nbsp;</td>
<td width="3%" valign="middle"><span style="margin:0px;">
<input type="radio" name="tours_i_rec" id="tours_i_rec0" value="0" />
</span></td>
<td width="6%" style="font-size:12px; color:#223C6A;">û��</td>
<td width="4%"><span style="margin:0px;">
<input type="radio" name="tours_i_rec" id="tours_i_rec1" value="1" />
</span></td>
<td width="11%" style="font-size:12px; color:#223C6A;">׼���Ƽ�</td>
<td width="4%"><span style="margin:0px;">
<input type="radio" name="tours_i_rec" id="tours_i_rec2" value="2" />
</span></td>
<td width="12%" style="font-size:12px; color:#223C6A;">�Ƽ���1λ</td>
<td width="4%"><span style="margin:0px;">
<input type="radio" name="tours_i_rec" id="tours_i_rec3" value="3" />
</span></td>
<td width="12%" style="font-size:12px; color:#223C6A;">�Ƽ���2λ</td>
<td width="4%"><span style="margin:0px;">
<input type="radio" name="tours_i_rec" id="tours_i_rec4" value="4" />
</span></td>
<td width="36%" style="font-size:12px; color:#223C6A;">�Ƽ���3λ������</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
<tr>
<td height="26" style="font-size:12px; color:#223C6A;">10����һ�㻨�Ѷ�����һ�������г����أ� </td>
<td>
<span style="font-size:12px; color:#223C6A;">
<input type="radio" name="tours_consumer" value="0" />$100����
</span></td>
<td><span style="font-size:12px; color:#223C6A;">
<input type="radio" name="tours_consumer" value="1" />$100-$500
</span></td>
<td><span style="font-size:12px; color:#223C6A;">
<input type="radio" name="tours_consumer" value="2" />
$500-$1000</span></td>
<td><span style="font-size:12px; color:#223C6A;">
<input type="radio" name="tours_consumer" value="3" />$1000����
</span></td>
</tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFBEB" style="width:100%; ">
<tr>
<td height="32" colspan="11" style="font-size:12px; color:#223C6A;">11���������ι����У����ں������е���һ���أ� </td>
</tr>
<tr>
<td width="4%" height="20" style="font-size:12px; color:#223C6A;">&nbsp;</td>
<td width="4%" valign="middle"><span style="margin:0px;">
<input type="radio" name="tours_focus" id="radio9" value="0" />
</span></td>
<td width="7%" style="font-size:12px; color:#223C6A;">�Ƶ�</td>
<td width="3%"><span style="margin:0px;">
<input type="radio" name="tours_focus" id="radio10" value="1" />
</span></td>
<td width="8%" style="font-size:12px; color:#223C6A;">�г�</td>
<td width="4%"><span style="margin:0px;">
<input type="radio" name="tours_focus" id="radio11" value="2" />
</span></td>
<td width="7%" style="font-size:12px; color:#223C6A;">�۸�</td>
<td width="3%"><span style="margin:0px;">
<input type="radio" name="tours_focus" id="radio12" value="3" />
</span></td>
<td width="7%" style="font-size:12px; color:#223C6A;">����</td>
<td width="4%"><span style="margin:0px;">
<input type="radio" name="tours_focus" id="radio13" value="4" />
</span></td>
<td width="49%" style="font-size:12px; color:#223C6A;">��Ʊ</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%; ">
<tr>
<td height="32" colspan="15" style="font-size:12px; color:#223C6A;">12����ϣ����վ����רҵ�����β�Ʒ�⣬�����������Щ���������أ� </td>
</tr>
<tr>
<td width="1%" height="20" style="font-size:12px; color:#223C6A;">&nbsp;</td>
<td width="3%" valign="middle">
<label>
<input name="tours_add_prod[]" type="checkbox" id="tours_add_prod[]" value="1" />
</label>
</td>
<td width="10%" style="font-size:12px; color:#223C6A;">ǩ֤��ʶ</td>
<td width="4%">
<label>
<input name="tours_add_prod[]" type="checkbox" id="tours_add_prod[]" value="2" />
</label>
</td>
<td width="10%" style="font-size:12px; color:#223C6A;">���γ�ʶ</td>
<td width="4%"><span style="margin:0px;">

<label>
<input name="tours_add_prod[]" type="checkbox" id="tours_add_prod[]" value="3" />
</label>

</span></td>
<td width="9%" style="font-size:12px; color:#223C6A;">������Ѷ</td>
<td width="4%"><span style="margin:0px;">

<label>
<input name="tours_add_prod[]" type="checkbox" id="tours_add_prod[]" value="4" />
</label>

</span></td>
<td width="10%" style="font-size:12px; color:#223C6A;">ͬ�к���</td>
<td width="3%"><span style="margin:0px;">

<label>
<input name="tours_add_prod[]" type="checkbox" id="tours_add_prod[]" value="5" />
</label>

</span></td>
<td width="11%" style="font-size:12px; color:#223C6A;">����ͼƬ</td>
<td width="4%" style="font-size:12px; color:#223C6A;">
<label>
<input name="tours_add_prod[]" type="checkbox" id="tours_add_prod[]" value="6" />
</label>
</td>
<td width="10%" style="font-size:12px; color:#223C6A;">������Ƶ</td>
<td width="4%" style="font-size:12px; color:#223C6A;">
<label>
<input name="tours_add_prod[]" type="checkbox" id="tours_add_prod[]" value="7" />
</label>
</td>
<td width="13%" style="font-size:12px; color:#223C6A;">��������</td>
</tr>
<tr>
<td height="20" style="font-size:12px; color:#223C6A;">&nbsp;</td>
<td valign="middle">
<label>
<input name="tours_add_prod[]" type="checkbox" id="tours_add_prod[]" value="8" />
</label>
</td>
<td style="font-size:12px; color:#223C6A;">������</td>
<td>
<label>
<input name="tours_add_prod[]" type="checkbox" id="tours_add_prod[]" value="9" />
</label>
</td>
<td style="font-size:12px; color:#223C6A;">����</td>

<td colspan="10">&nbsp;</td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFBEB" style="width:100%;">
<tr >
<td height="32" colspan="5" style="font-size:12px; color:#223C6A;">13�������ñ�վ��Ҫ����Щ������иĽ���</td>
</tr>
<tr >
<td height="32" style="font-size:12px; color:#223C6A;"><input type="radio" name="tours_site_improve" value="0" />
ҳ�沼��</td>
<td style="font-size:12px; color:#223C6A;"><input type="radio" name="tours_site_improve" value="1" />
�������</td>
<td style="font-size:12px; color:#223C6A;"><input type="radio" name="tours_site_improve" value="2" />
��������</td>
<td style="font-size:12px; color:#223C6A;"><input type="radio" name="tours_site_improve" value="3" />
�ͷ�����</td>
<td style="font-size:12px; color:#223C6A;"><input type="radio" name="tours_site_improve" value="4" />
����</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
<tr >
<td height="32" style="font-size:12px; color:#223C6A;">14�����ĵ绰���룺</td>
<td>
<label>
<input name="tours_phone" type="text" id="tours_phone" maxlength="11"  size="30" height="20px;" style="border:1px #E4E4E4 solid; font-size:12px; color:#223C6A;" />
</label> </td>
</tr>
<tr >
<td height="32" style="font-size:12px; color:#223C6A;">15���ٴ��������ĵ绰���룺</td>
<td><input name="tours_phone_re" type="text" id="tours_phone_re" maxlength="11"  size="30" height="20px;" style="border:1px #E4E4E4 solid; font-size:12px; color:#223C6A;" /></td>
</tr>

</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
<tr bgcolor="#FFFBEB" >
<td height="32" style="font-size:14px; font-weight: bold;"><input style="border: 1px solid #81A7E8; cursor:hand; font-size:14px; font-weight: bold;" alt="�ύ����" title="�ύ����" name="ToursSubmitBotton" type="submit" value="�ύ����" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="border: 1px solid #81A7E8;" name="ToursReBotton" type="reset" id="ToursReBotton" value="����" />
</td>
<td width="68%">&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
<div style="float:left; width: 600px; background-color: #223C6A;"><p style="font-family: Tahoma; font-size: 11px; color: #FFF; text-decoration: none; text-align:right; line-height:16px;  margin-right:3px; margin-top:7px;"><a href="'.HTTP_SERVER.'" style="color:#fff; text-decoration:underline;">208.109.123.18 </a></p><img src="'.HTTP_SERVER.'/image/newsletter2_r2_c2_1.jpg" width="600" height="13" border="0" /></div>
</form>
</div>';

$to_email_address[0] = $row['customers_email_address'];
$to_name = db_to_html($row['customers_firstname']);
$email_text = db_to_html(preg_replace('[\n\r\t]',' ',$email_text));
$email_subject =db_to_html('usitrip ���ķ����ͻ��������飡');
$from_email_name ='usitrip';
$from_email_address = 'service@usitrip.com';
for($i=0; $i<count($to_email_address); $i++){
	@tep_mail($to_name, $to_email_address[$i], $email_subject, $email_text, $from_email_name, $from_email_address, 'true');
	//echo $to_email_address[$i].'<br />';
}

//echo $email_text;
?>
<?php /*
</body></html>
<script type="text/JavaScript">
<!--
location = 'send_customers_mail.php?language=sc&customers_id='+<?php echo $row['customers_id']?>;
//-->
</script>
*/
?>
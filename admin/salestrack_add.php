<?php
require('includes/application_top.php');


//$admin_list = $salestrack->admin_list();/*��ȡ��̨�û��б�,������ʾ�б���Ա����ƥ��*/
$action=$_GET['action'];
if($action=="add"){
	require('includes/classes/salestrack.php');	//�������۸��ٵ����ļ�
	$salestrack = new salestrack;
	$insert_id=$salestrack->addnew($_POST);
	if((int)($insert_id)){
	  echo 'success';
	  echo '<script language="javascript" type="text/javascript">window.opener.location.href=window.opener.location.href;window.close();</script>';
	  exit();
	}
}
/*
if($_POST['action']=="add"){
	$insert_id = $guestbooks->insert_or_update($_POST,'insert');
	if((int)$insert_id){
		tep_redirect('guestbook.php');
	}
}*/
if(!tep_not_null($_POST['is_important'])){ $is_important='0'; }
if(!tep_not_null($_POST['pay_status'])){ $pay_status='0'; }

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?>----���۸���---���Ӽ�¼----�ڲ�ʹ��</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/big5_gb-min.js"></script>
<script language="javascript" src="includes/javascript/add_global.js"></script>
<script type="text/javascript" src="includes/jquery-1.3.2/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="includes/javascript/calendar.js"></script>
<script language="javascript" type="text/javascript">
</script>
<style type="text/css">
.tbList { border:1px solid #CCCCCC; border-collapse:collapse;}
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
</style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php
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
<script language="javascript" type="text/javascript">
function checkForm(){
  var c_name=$('#customer_name').val();
  var c_tel=$('#customer_tel').val();
  var c_mobile=$('#customer_mobile').val();
  var c_email=$('#customer_email').val();
  var c_qq=$('#customer_qq').val();
  var c_msn=$('#customer_msn').val();
  var c_skype=$('#customer_skype').val();
  var c_info=$('#customer_info').val();
  if(c_name.length<2){alert('Error:\n\n�������������'); return false;}
  if(c_tel.length==0 && c_mobile.length==0 && c_email.length==0 && c_qq.length==0 && c_msn.length==0 && c_skype.length==0){alert('Error:\n\n���˵绰,�ֻ�,E-mail,QQ,MSN,SKYPE����Ҫ��дһ��'); return false;}
  if(c_email.length>0){
	  var reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	  if(!reg.test(c_email)){ alert('Error:\n\n email��ʽ����ȷ'); return false; }	  
  }
  if(c_info.length<2){alert('Error:\n\n�����������ѯ����'); return false;}
}
</script>
<!-- body //-->
<h3>�������۸���</h3>
    <form name="form1" method="post" action="?action=add" onsubmit="return checkForm()">
      <table class="tbList" border="0" align="center" bgcolor="#FFFFFF">
        <tr> 
          <td width="100" height="20" align="right">������:</td>
          <td align="left">
            <?php echo tep_draw_radio_field('is_important','2','','',' id="is_important2"');?>
            <label for="is_important2" style="font-weight:bolder; color:#FF0000">�ǳ�����</label>
            <?php echo tep_draw_radio_field('is_important','1','','',' id="is_important1"');?>
            <label for="is_important1" style="font-weight:normal; color:#FF0000;">����</label>
            <?php echo tep_draw_radio_field('is_important','0','','',' id="is_important0"');?>
            <label for="is_important0">��ͨ</label>
          </td>
        </tr>
        <tr> 
          <td align="right">����״̬:</td>
          <td align="left">
            <?php echo tep_draw_radio_field('pay_status','0','','',' id="payStatus0"');?>
            <label for="payStatus0" style="color:#FF0000">δ����</label>
            <?php echo tep_draw_radio_field('pay_status','1','','',' id="payStatus1"');?>
            <label for="payStatus1" style="color:#0000FF">�Ѹ���</label>
		  </td>
        </tr>
        <tr> 
          <td align="right">��������:</td>
          <td align="left">
          <?php echo tep_draw_input_field('customer_name','','id="customer_name" class="formbox"');?>
          <span style="color:#FF0000">*</span></td>
        </tr>
        <tr> 
          <td align="right">���˵绰:</td>
          <td align="left">
          <?php echo tep_draw_input_field('customer_tel','','id="customer_tel" class="formbox" style="ime-mode:disabled"');?>
          <span class="remark">���˵绰,�ֻ�,E-mail,QQ,MSN,SKYPE����Ҫ��дһ��</span></td>
        </tr>
        <tr> 
          <td align="right">�ֻ�:</td>
          <td align="left">
          <?php echo tep_draw_input_field('customer_mobile','','id="customer_mobile" class="formbox" style="ime-mode:disabled"');?>
          </td>
        </tr>
        <tr> 
          <td align="right"><span style="color:#0000FF;">E-mail</span>:</td>
          <td align="left">
          <?php echo tep_draw_input_field('customer_email','','id="customer_email" class="formbox" style="ime-mode:disabled"');?>
          </td>
        </tr>
        <tr> 
          <td align="right">QQ:</td>
          <td align="left">
          <?php echo tep_draw_input_field('customer_qq','','id="customer_qq" class="formbox" style="ime-mode:disabled"');?>
          </td>
        </tr>
        <tr> 
          <td align="right">MSN:</td>
          <td align="left">
          <?php echo tep_draw_input_field('customer_msn','','id="customer_msn" class="formbox" style="ime-mode:disabled"');?>
          </td>
        </tr>
        <tr> 
          <td align="right">SKYPE:</td>
          <td align="left">
          <?php echo tep_draw_input_field('customer_skype','','id="customer_skype" class="formbox" style="ime-mode:disabled"');?>
          </td>
        </tr>
        <tr> 
          <td align="right">�ƻ�����ʱ��:</td>
          <td align="left">
          <?php echo tep_draw_input_field('customer_plan_tdate','','id="customer_plan_tdate" onclick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" readonly=""');?>
          <span class="remark">���ѡ������</span></td>
        </tr>
        <tr> 
          <td align="right">�´���ϵʱ��:</td>
          <td align="left">
          <?php echo tep_draw_input_field('next_condate','','id="next_condate" onclick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" readonly=""');?>
          <span class="remark">���ѡ������</span></td>
        </tr>
		<tr> 
		  <td align="right" valign="top"><span style="color:#0000FF;">�ź�</span>:</td>
		  <td align="left">
		  <?php echo tep_draw_input_field('code','','id="code" class="formbox" style="ime-mode:disabled"');?>		  
		  <span class="remark">(����ź�֮������Ӣ�Ķ���(,)����, ���Ķ���(��)��Ч. �ź�����ð��Ӣ��)</span>
		  </td>
		</tr>
        <tr> 
          <td align="right" valign="top">�ͻ���ѯ����:</td>
          <td align="left">��ϸ����:<br/>
          <?php echo tep_draw_textarea_field('customer_info', '','80', '5', '',' id="customer_info"')?>
          <span style="color:#FF0000">*</span></td>
        </tr>
        <tr> 
          <td align="right" valign="top">������:</td>
          <td align="left">
          <?php echo tep_draw_input_num_en_field('orders_id','','id="orders_id" class="formbox"')?>                   
		  <span class="remark">(��д��,ϵͳ�����ڶ���������Զ��޸����۸��ٵĸ���״̬)</span>
		  </td>
        </tr>
        <tr> 
          <td colspan="2" align="center" valign="top"><input type="submit" id="submit" value="�ύ" />&nbsp;<input onclick="javascript:window.close()" type="button" value="�����б�" /></td>
        </tr>
      </table>
    </form>

<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
<?php
$table_bg_color = '#C0E1F6';
if($validation_result==true){
	$table_bg_color = '#ffffff';
}
?>
<table width="99%" border="0" cellpadding="0" cellspacing="0" bgcolor="<?=$table_bg_color?>" style="margin-top:10px;">

<?php
//$validation_result = false;
//$messageStack->add('validation',db_to_html('��������֤�룡'));
if($validation_result==false){

  if ($messageStack->size('validation') > 0) {
?>
	  
 <tr>
    <td width="70"  height="30" valign="top"  nowrap style="padding:10px 10px 10px 100px; background:#FFFEE9; border-top:1px solid #FFED8B; border-bottom:1px solid #FFED8B;">
	<img src="image/notice.jpg" alt="<?php echo db_to_html("����ʧ��!")?>">
	</td>
    <td valign="middle" style="font-size:14px; background:#FFFEE9; border-top:1px solid #FFED8B; border-bottom:1px solid #FFED8B;">
		<h2><?php echo strip_tags($messageStack->output('validation')); ?></h2>
	</td>
  </tr>
	  <tr>
		<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	  </tr>
<?php
  }
?>
  <tr>
    <td colspan="2"  height="30" style="padding:15px; padding-bottom:5px; padding-right:0px; font-size:14px;">
	<?php echo db_to_html('�����˺�Ŀǰ��δ������¼��������<br /> '.$affiliate_email_address.' ���ռ����ţ�����ʱ�����˺š�');?>
    </td>
  </tr>
  <tr>
    <td colspan="2"  height="30" valign="top" nowrap style="padding:15px; padding-top:3px; padding-right:0px; font-size:14px;">
    <form action="" method="post" name="resend" id="resend"><?php echo tep_template_image_submit('again_email.gif', 'Send Validation Mail','style="vertical-align:middle; "');  ?>
        <input name="action" type="hidden" id="action" value="resend" >
    </form>
    
  <form action="" method="post" name="inputcodeform" id="inputcodeform">
	<?php echo db_to_html('������������֤����м��');?>&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo tep_draw_input_field('affiliate_email_address_verifi_code','',' style="font-size:14px;" size="18" maxlength="10" ');?>	
    
    <?php echo tep_template_image_submit('queren_jihuo.gif', 'Enter Validation Code','style="vertical-align:middle; "'); ?><input name="action" type="hidden" id="action" value="inputcode">
  </form>
	
	</td>
  </tr>
<?php
}elseif($validation_result==true){
?>
  <tr>
    <td width="70"  height="30" valign="top" nowrap style="padding:10px 10px 25px 100px; background:#FFFEE9; border-top:1px solid #FFED8B; border-bottom:1px solid #FFED8B;">
	<img src="image/pay_success.gif" alt="OK">
	</td>
    <td valign="middle" style="padding-top:10px; font-size:14px; background:#FFFEE9; border-top:1px solid #FFED8B; border-bottom:1px solid #FFED8B;">
	<h2><?php echo db_to_html('��ϲ�������˺��ѳɹ�ͨ����֤��<small style="font-size:12px; font-weight:normal;">��������&nbsp;&nbsp;�ɴ˿�ʼ...</small>');?></h2>
	<?php echo '<a class="btn btnOrange" href="' . tep_href_link('affiliate_my_info.php','action=edit') . '" style="margin-top:8px;"><button type="button">' .db_to_html("�� ��") . '</button></a>'; ?>
	</td>
  </tr>
<?php
}
?>
</table>

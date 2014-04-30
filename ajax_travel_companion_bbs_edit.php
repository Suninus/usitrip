<?php
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );

require_once('includes/application_top.php');
require_once(DIR_FS_INCLUDES . 'ajax_encoding_control.php');

//����û�
if(!tep_session_is_registered('customer_id') || !(int)$customer_id){
	if(!tep_not_null($_POST['password'])){
		echo db_to_html('[ERROR]���������ĵ�¼���룡[/ERROR]');
		exit;
	}
	if(!tep_not_null($HTTP_GET_VARS['action'])){ $HTTP_GET_VARS['action'] = 'process';}else{ $old_action = $HTTP_GET_VARS['action']; $HTTP_GET_VARS['action'] = 'process'; }
	$ajax = $_POST['ajax'];
	include('login.php');
	if(tep_not_null($old_action)){
		$HTTP_GET_VARS['action'] = $old_action;
	}
}
//������
if($_GET['action']=='confirm_update' && $error == false){
	$t_companion_content = tep_db_prepare_input($_POST['t_companion_content']);
	$customers_name = tep_db_prepare_input($_POST['customers_name']);
	$t_companion_title = tep_db_prepare_input($_POST['t_companion_title']);
	$t_gender = (int)$_POST['t_gender'];
	$customers_phone = tep_db_prepare_input($_POST['customers_phone']);
	$t_show_email = (int)$_POST['t_show_email'];
	$sql_data_array = array(
						  	't_companion_content' => iconv('utf-8',CHARSET.'//IGNORE',$t_companion_content),
						  	'customers_name' => iconv('utf-8',CHARSET.'//IGNORE',$customers_name),
						  	't_gender' => iconv('utf-8',CHARSET.'//IGNORE',$t_gender),
						  	't_companion_title' => iconv('utf-8',CHARSET.'//IGNORE',$t_companion_title),
						  	'customers_phone' => iconv('utf-8',CHARSET.'//IGNORE',$customers_phone),
						  	't_show_email' => iconv('utf-8',CHARSET.'//IGNORE',$t_show_email),
							'last_time' => date('Y-m-d H:i:s')
							);
	$checkdate = checkdate($_POST['the_moth'],$_POST['the_day'],$_POST['the_year']);
	if($checkdate==true){
		$hope_departure_date = 
		$_POST['the_year'].'-'.
		$_POST['the_moth'].'-'.
		$_POST['the_day'];
		$sql_data_array['hope_departure_date'] = $hope_departure_date;
	}

	$sql_data_array = html_to_db($sql_data_array);
	tep_db_perform('`travel_companion`', $sql_data_array,'update', 't_companion_id="'.(int)$_POST['t_companion_id'].'" AND customers_id="'.(int)$customer_id.'" ');
	echo '[SUCCESS]'.(int)$_POST['t_companion_id'].'[/SUCCESS]';
	die();
}

//����Ҫ���µ�����
if($_GET['action']=='update' && $error == false){
	$sql = tep_db_query('SELECT * FROM `travel_companion` WHERE t_companion_id="'.(int)$_POST['t_companion_id'].'" AND customers_id="'.(int)$customer_id.'" ');
	$row = tep_db_fetch_array($sql);
	if(!(int)$row['t_companion_id']){
		echo '[ERROR]'.db_to_html('Ŀ���������ڣ�').'[/ERROR]';
		exit;
	}
	$t_companion_id = (int)$row['t_companion_id'];
	$customers_name = db_to_html(tep_db_output($row['customers_name']));
	$t_companion_title = db_to_html(tep_db_output($row['t_companion_title']));
	$t_gender = $row['t_gender'];
	$customers_phone = db_to_html(tep_db_output($row['customers_phone'])); 
	$email_address = db_to_html(tep_db_output($row['email_address'])); 
	$t_companion_content = db_to_html(tep_db_output($row['t_companion_content']));
	$hope_departure_date =  db_to_html(tep_db_output($row['hope_departure_date']));
	$t_top_day = (int)$row['t_top_day'];
	$t_show_email = $row['t_show_email'];
?>

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25" colspan="2" align="center" class="title_line">
	<?php echo db_to_html('<b>���ͬ�� �޸�����</b>')?><input name="t_companion_id" type="hidden" value="<?= $t_companion_id?>">
	</td>
    </tr>
  <tr>
    <td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('����')?>&nbsp;</td>
    <td align="left" valign="top"><?php echo tep_draw_input_field('customers_name','','  class="required validate-length-lastname" style="width: 242px;" title="'.db_to_html('����������').'"') ?>
	<span class="inputRequirement"> * </span></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('�Ա�')?>&nbsp;</td>
    <td align="left" valign="top">
	
	<?php
	echo tep_draw_radio_field('t_gender', '1','','class="" title="'.db_to_html('��ѡ�������Ա�').'"').db_to_html(' ��');
	echo '&nbsp;&nbsp;';
	echo tep_draw_radio_field('t_gender', '2','','class="" title="'.db_to_html('��ѡ�������Ա�').'"').db_to_html(' Ů');
	?>
	
	</td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('��ϵ�绰')?>&nbsp;</td>
    <td align="left" valign="top"><?php echo tep_draw_input_field('customers_phone','','  class="" style="width: 242px;" ') ?></td>
  </tr>
  
  <?php if(!(int)$customer_id){//no login?>
  <tr>
    <td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('�û���/����&nbsp;')?></td>
    <td align="left" valign="top">
	<?php echo tep_draw_input_field('email_address','','class="required validate-email" style="width: 160px;" title="'.db_to_html('���������ĵ�������').'"') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?>
	<?php echo db_to_html('���û����� <a href="'.tep_href_link("create_account.php","", "SSL").'" class="sp3">ע��</a>');?>	</td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('����')?>&nbsp;</td>
    <td align="left" valign="top"><input name="password" type="password" class="required" id="password" title="<?php echo db_to_html('��������ȷ������')?>" style="width: 160px;" /></td>
  </tr>
  <?php
  }else{//loging
	  if(!tep_not_null($email_address)){
		$email_address = $customer_email_address;
	  }
  ?>
  
  <tr>
    <td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('����')?>&nbsp;</td>
    <td align="left" valign="top"><?php echo tep_draw_input_field('email_address','',' readonly="true" class="required validate-email" style="width: 242px;" title="'.db_to_html('���������ĵ�������').'"') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
  </tr>
  
  <?php }?>
  
  
  <tr>
    <td height="25" align="right" valign="middle" class="title_line"><?php echo db_to_html('��������')?>&nbsp;</td>
    <td align="left" valign="top">
	<?php
	//echo $hope_departure_date;
	$date_arry = explode('-',$hope_departure_date);
	$the_year = $the_year_a[0]['id'] = $the_year_a[0]['text'] = $date_arry[0]; 
	$the_moth = $the_moth_a[0]['id'] = $the_moth_a[0]['text'] = $date_arry[1]; 
	$the_day = $the_day_a[0]['id'] = $the_day_a[0]['text'] = $date_arry[2];
	for($i=0; $i<2; $i++){
		$y_d = (date('Y')+$i);
		if($the_year!=$y_d){
			$cc = count($the_year_a);
			$the_year_a[$cc]['id'] = $the_year_a[$cc]['text'] = $y_d;
		}
	}
	for($i=1; $i<=12; $i++){
		
		if($i<10){
			$num = '0'.$i;
		}else{
			$num = $i;
		}
		
		$m_d = $num;
		if($m_d!=$the_moth){
			$cc = count($the_moth_a);
			$the_moth_a[$cc]['id'] = $the_moth_a[$cc]['text'] = $num;
		}
	}
	for($i=1; $i<=31; $i++){
		if($i<10){
			$num = '0'.$i;
		}else{
			$num = $i;
		}
		$d_d = $num;
		if($d_d!=$the_day){
			$cc = count($the_day_a);
			$the_day_a[$cc]['id'] = $the_day_a[$cc]['text'] = $num;
		}
	}
	
	echo tep_draw_pull_down_menu('the_year', $the_year_a).db_to_html('��');
	echo tep_draw_pull_down_menu('the_moth', $the_moth_a).db_to_html('��');
	echo tep_draw_pull_down_menu('the_day', $the_day_a).db_to_html('��');
	
	?>
	</td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('(50����/��)�ö�')?>&nbsp;</td>
    <td align="left" valign="top">
	<?php
	if(!(int)$t_top_day){
		echo db_to_html('���ö�');
	}else{
		echo $t_top_day.db_to_html('��');
	}
	?>
	
	</td>
  </tr>

  <tr>
    <td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('����')?>&nbsp;</td>
    <td align="left" valign="top"><?php echo tep_draw_input_field('t_companion_title','','  class="required" title="'.db_to_html('��Ϊ��������').'" style="width: 242px;"') ?><span class="inputRequirement"> * </span></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('����')?>&nbsp;</td>
    <td align="left" valign="top" style="padding-top:2px;"><?php echo tep_draw_textarea_field('t_companion_content', 'soft', '', '','',' class="required "  style="width: 242px; height: 80px; " id="t_companion_content" title="'.db_to_html('����������').'"'); ?><span class="inputRequirement"> * </span></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="title_line">&nbsp;</td>
    <td align="left" valign="top" style="padding-top:2px;">
	
	<?php
	//$t_show_email ='0';
	echo tep_draw_radio_field('t_show_email', '1').db_to_html(' ��');
	echo '&nbsp;&nbsp;';
	echo tep_draw_radio_field('t_show_email', '0').db_to_html(' ��');
	?>	
	<?php echo db_to_html(' ��ʾ�����ַ')?>
	</td>
  </tr>
  
  <tr>
    <td height="45" align="right" class="title_line">&nbsp;</td>
    <td align="left"><?php echo tep_template_image_submit('fabiao-button.gif', db_to_html('����')); ?><img id="loading_img" style="display:<?= 'none'?>" src="image/loading_16x16.gif" alt="<?php echo db_to_html("���ݷ�����...")?>" width="16" height="16" align="absmiddle" /></td>
  </tr>
</table>

<?php
}
?>
<?php
if($submit_vote!=false){
//�ύ�ɹ�����ʾҳ��
	$msn_string = "����ϵͳ�Ѿ��������ύ�ĵ��飬лл����֧�֣�";

	if(!(int)$customer_id){
		$msn_string .= '<br>����δ��¼���� <a href="'.tep_href_link("login.php","", "SSL") .'" class="" style="font-size:14px;"><b>��¼</b></a> ��ȡ���֣������û�����ķ����ʺţ��� <a href="'.tep_href_link("create_account.php","", "SSL").'" class="" style="font-size:14px;"><b>ע��</b></a> ���Ա��ȡ���ε���Ļ��֡�';
	}else{
		$sql = tep_db_query('SELECT * FROM `vote_system` WHERE v_s_id ="'.$v_s_id.'" LIMIT 1');
		$row = tep_db_fetch_array($sql);
		$v_s_points = $row['v_s_points']; 
		if((int)$v_s_points){
			$msn_string .= '�����뱾�ε���� '.$v_s_points.' ���֣��Ѿ����������ʺš�';
		}
	}
?>
<!--<meta http-equiv="refresh" content="10;URL=<?=tep_href_link('index.php', '')?>" />-->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td> 

	<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
	<tr>
	<td><table border="0" width="99%" cellspacing="0" cellpadding="0">
	<tr>
	<td valign="middle" class="pageHeading"><?php echo VOTE_SYSTEM_TITLE;?></td>
	</tr>
	<tr>
	<td height="150" class="main"  style="padding-bottom:8px; background-repeat:repeat-x; background-position:top; background-color:#FFFFFF" valign="middle"><table border="0" width="100%" cellspacing="0" cellpadding="2">
	
	<tr>
	<td align="center"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	</tr>
	<tr>
	<td align="center">
		<table border="0" cellspacing="1" cellpadding="0">
		  <tr>
			<td><img src="image/ok_img.jpg" /></td>
			<td class="main" align="left"><?php echo db_to_html($msn_string); ?></td>
		  </tr>
		</table>
	
	</td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	</tr>
	</table>

</td>
</tr>
</table>
<?php 
//�ύ�ɹ�����ʾҳ��
}else{

//������ʾҳ��
	echo tep_get_design_body_header(VOTE_SYSTEM_TITLE); 

	$v_s_id = ($_POST['v_s_id']) ? $_POST['v_s_id'] : $_GET['v_s_id'];
	$orders_id = ($_POST['orders_id']) ? $_POST['orders_id'] : $_GET['orders_id'];

	echo display_vote($v_s_id , '100%' , 'FormVote', 'post', '','', 'submit_bottom', CHARSET, $orders_id, 'Submit');
?>	

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong><?php echo db_to_html('��׬������֣�')?></strong><a href="<?php echo tep_href_link('vote_system_list.php')?>" class="sp3"><?php echo db_to_html('�������')?></a></td>
  </tr>
</table>


<?php
	echo tep_get_design_body_footer();
}
?>
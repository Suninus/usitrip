<?php
require('includes/application_top.php');
switch($_GET['action']){
	case 'setstate': 
		if((int)$_GET['t_c_reply_id']){
			tep_db_query('update travel_companion_reply set status="'.(int)$_GET['status'].'" where t_c_reply_id="'.(int)$_GET['t_c_reply_id'].'"');
		}
	 break;
	case 'DelConfirmed':
		if((int)$_GET['t_c_reply_id']){
			$sql = tep_db_query('SELECT t_companion_id FROM `travel_companion_reply` WHERE t_c_reply_id = "'.(int)$_GET['t_c_reply_id'].'" ');
			$row = tep_db_fetch_array($sql);
			$t_companion_id = $_GET['t_companion_id'] = $row['t_companion_id'];
			tep_db_query('DELETE FROM `travel_companion_reply` WHERE `t_c_reply_id` = "'.(int)$_GET['t_c_reply_id'].'" ');
			
			tep_db_query('UPDATE `travel_companion` SET `reply_num` = (reply_num-1) WHERE `t_companion_id` = "'.(int)$t_companion_id.'" ');
			
		}
	 break;
}

if($_POST['action']=='Update'){
	if((int)$_POST['t_companion_id']){
		$_GET['t_companion_id'] = $_POST['t_companion_id'];
		$t_companion_title = tep_db_prepare_input($HTTP_POST_VARS['t_companion_title']);
		$customers_name = tep_db_prepare_input($HTTP_POST_VARS['customers_name']);
		$customers_id = (int)$HTTP_POST_VARS['customers_id'];
		$customers_phone = tep_db_prepare_input($HTTP_POST_VARS['customers_phone']);
		$email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
		$t_companion_content = tep_db_prepare_input($HTTP_POST_VARS['t_companion_content']);
		$reply_num = (int)$HTTP_POST_VARS['reply_num'];
		$products_id = (int)$HTTP_POST_VARS['products_id'];
		$categories_id = (int)$HTTP_POST_VARS['categories_id'];
		$status = (int)$HTTP_POST_VARS['status'];
		$add_time = tep_db_prepare_input($HTTP_POST_VARS['add_time']);
		//$last_time = tep_db_prepare_input($HTTP_POST_VARS['last_time']);
		$last_time = date('Y-m-d H:i:s');
		$click_num = (int)($HTTP_POST_VARS['click_num']);
		$bbs_type = (int)($HTTP_POST_VARS['bbs_type']);
		$admin_id = 0;
		if(!(int)$customers_id){
			$admin_id = $login_id;
		}
		
		$error = false;
		$t_companion_title = tep_db_prepare_input($HTTP_POST_VARS['t_companion_title']);
		if(!tep_not_null($t_companion_title)){
			$error = true;
			$messageStack->add(db_to_html('���⣺����Ϊ��'),'error');
		}
		$t_companion_content = tep_db_prepare_input($HTTP_POST_VARS['t_companion_content']);
		if(!tep_not_null($t_companion_content)){
			$error = true;
			$messageStack->add(db_to_html('���ݣ�����Ϊ��'),'error');
		}
		if($error==false){
			$date_array = array('t_companion_title'=>$t_companion_title,
								'customers_name'=>$customers_name,
								'customers_id'=>$customers_id,
								'customers_phone'=>$customers_phone,
								'email_address'=>$email_address,
								't_companion_content'=>$t_companion_content,
								'reply_num'=>$reply_num,
								'products_id'=>$products_id,
								'categories_id'=>$categories_id,
								'status'=>$status,
								'add_time'=>$add_time,
								'last_time'=>$last_time,
								'click_num'=>$click_num,
								'bbs_type'=> $bbs_type,
								'admin_id'=> $admin_id
								 );
			tep_db_perform('travel_companion', $date_array,'update', 't_companion_id="'.(int)$_POST['t_companion_id'].'" ');
			$messageStack->add(db_to_html('���Ӹ��³ɹ�'), 'success');

		}
	}
}

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">

<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>

<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/big5_gb-min.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript">
<!--
<?php
$p=array('/&amp;/','/&quot;/');
$r=array('&','"');
?>

function DelTravel(t_id){
	if(t_id<1){ alert('no id'); return false;}
	if(window.confirm("�����Ҫɾ�����������\t")==true){
		parent.location = "<?php echo preg_replace($p,$r,tep_href_link('travel_companion_re.php','action=DelConfirmed'))?>&t_c_reply_id="+t_id;
		return false;
	}
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">





<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
        </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">���ͬ�α༭</td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
		<?php
		$sql = tep_db_query(' SELECT * FROM `travel_companion` WHERE t_companion_id="'.(int)$_GET['t_companion_id'].'" ');
		$row = tep_db_fetch_array($sql);
		$tInfo = new objectInfo($row);
		$t_companion_id = $tInfo-> t_companion_id;
		$t_companion_title = $tInfo-> t_companion_title;
		$customers_name = $tInfo-> customers_name;
		$customers_id = $tInfo-> customers_id;
		$customers_phone = $tInfo-> customers_phone;
		$email_address = $tInfo-> email_address;
		$t_companion_content = $tInfo-> t_companion_content;
		$reply_num = $tInfo-> reply_num;
		$products_id = $tInfo-> products_id;
		$categories_id = $tInfo-> categories_id;
		$status = $tInfo-> status;
		$add_time = $tInfo-> add_time;
		$last_time = $tInfo-> last_time;
		$click_num = $tInfo-> click_num;
		$bbs_type =  $tInfo-> bbs_type;
		?>
		
		<fieldset>
		  <legend align="left"> <?php echo tep_db_output($row['t_companion_title'])?> </legend>

		<table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td valign="top">
			<form action="<?php tep_href_link('travel_companion_re.php','action=Update')?>" method="post" name="edit_form" id="edit_form">
              <table border="0" cellspacing="1" cellpadding="2">
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">���ͣ�</td>
                <td align="left" nowrap="nowrap" class="dataTableRow dataTableContent">
				<?php
				$option_array = array();
				$t_sql = tep_db_query('SELECT * FROM `travel_companion_bbs_type` Order By type_id ASC ');
				while($t_rows=tep_db_fetch_array($t_sql)){
					$option_array[]=array('id'=> $t_rows['type_id'], 'text'=> $t_rows['type_name']);
				}
				
				echo tep_draw_pull_down_menu('bbs_type', $option_array);
				?>
				</td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">���⣺</td>
				<td align="left" nowrap="nowrap" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('t_companion_title','',' size="50" ')?></td>
				</tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">���ݣ�</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_textarea_field('t_companion_content','virtual',50,5)?></td>
				</tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">������</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('customers_name','',' size="50" ')?></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">�ͻ�ID��</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('customers_id')?></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">�绰��</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('customers_phone','',' size="50" ')?></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">�������䣺</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('email_address','',' size="50" ')?></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">��������</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('reply_num','',' readonly="true" size="10"')?></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">��ز�Ʒ��</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('products_id')?></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">���Ŀ¼��</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('categories_id')?></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">״̬��</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('status')?>0�ǹرգ�1����ʾ</td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">�������ڣ�</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('add_time','',' size="25" ')?></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">�������ڣ�</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('last_time','',' size="25" ')?></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableHeadingRow dataTableHeadingContent">�������</td>
                <td align="left" class="dataTableRow dataTableContent"><?php echo tep_draw_input_field('click_num')?></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" class="dataTableRow dataTableContent"><input name="action" type="hidden" id="action" value="Update">
                  <input name="t_companion_id" type="hidden" id="t_companion_id" value="<?= $t_companion_id?>"></td>
                <td align="left" class="dataTableRow dataTableContent"><input type="submit" name="Submit" value="ȷ��"><input type="reset" value="����"><input name="" type="button" onClick="MM_goToURL('parent','<?php echo tep_href_link('travel_companion.php')?>');return document.MM_returnValue" value="������һҳ"></td>
              </tr>
            </table>
			</form>			</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">
			<table border="0" width="100%" cellspacing="1" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td colspan="5" nowrap="nowrap" class="dataTableHeadingContent">��ػ���</td>
                </tr>
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" nowrap="nowrap">������</td>
				<td class="dataTableHeadingContent" nowrap="nowrap">��������</td>

				<td class="dataTableHeadingContent" nowrap="nowrap">ʱ��</td>

				<td class="dataTableHeadingContent" nowrap="nowrap">״̬</td>
				<td class="dataTableHeadingContent" nowrap="nowrap">����</td>
              </tr>
			<?php
			$companion_query = tep_db_query('SELECT * FROM `travel_companion_reply` WHERE t_companion_id="'.(int)$t_companion_id.'" order by last_time DESC ');
			while($rows = tep_db_fetch_array($companion_query)){
			    $rows_num++;
			
				if (strlen($rows) < 2) {
				  $rows_num = '0' . $rows_num;
				}
				
				$bg_color = "#F0F0F0";
				if((int)$rows_num %2 ==0 && (int)$rows_num){
					$bg_color = "#ECFFEC";
				}

			?>
              <tr class="dataTableRow" style="cursor:auto; background-color:<?= $bg_color;?>">
                <td class="dataTableContent"><?php echo tep_db_output($rows['customers_name']).'&nbsp;&nbsp;'.$rows['customers_id']?></td>
                <td class="dataTableContent"><?php echo nl2br(tep_db_output($rows['t_c_reply_content']))?></td>
				
				<td class="dataTableContent"><?php echo tep_db_output($rows['last_time'])?></td>
				<td class="dataTableContent">
				<?php
					  if ($rows['status'] == '1') {
						echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link('travel_companion_re.php', 'action=setstate&t_companion_id='.$rows['t_companion_id'].'&status=0&t_c_reply_id=' . $rows['t_c_reply_id'].(isset($HTTP_GET_VARS['page']) ? '&page=' . $HTTP_GET_VARS['page'] . '' : '').(isset($HTTP_GET_VARS['sortorder']) ? '&sortorder=' . $HTTP_GET_VARS['sortorder'] . '' : '')) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
					  } else {
						echo '<a href="' . tep_href_link('travel_companion_re.php', 'action=setstate&t_companion_id='.$rows['t_companion_id'].'&status=1&t_c_reply_id=' . $rows['t_c_reply_id'] .(isset($HTTP_GET_VARS['page']) ? '&page=' . $HTTP_GET_VARS['page'] . '' : ''). (isset($HTTP_GET_VARS['sortorder']) ? '&sortorder=' . $HTTP_GET_VARS['sortorder'] . '' : '')) .'">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
					  }
				?>				</td>
				<td nowrap class="dataTableContent">
				
				[<a href="JavaScript:void(0);" onClick="DelTravel(<?php echo $rows['t_c_reply_id']?>); return false;">ɾ��</a>]</td>
              </tr>
			<?php
			}
			?>  
            </table>
			</td>
          </tr>
        </table>
		</fieldset>		</td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

<?php
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );

require('includes/application_top.php');
require(DIR_FS_INCLUDES . 'ajax_encoding_control.php');

if($_GET['action']=="get_tours_day"){	// IE������onClick�¼� show_hotel_tours(1137,1040, 2,1);����Ҫ
	echo '11';
	exit;
}

if($_POST['ajax']=='true' && $_GET['action']=="process"){	//ajax start
	//ȡ�þƵ���Ϣ
	$hotel_sql = tep_db_query('SELECT p.products_id, p.products_image, pd.products_name, pd.products_small_description, ph.hotel_star, ph.hotel_address FROM `products` p, `products_description` pd, `products_hotels` ph WHERE p.products_id ="'.(int)$_POST['h_id'].'" AND p.products_id = pd.products_id AND ph.products_id = p.products_id AND p.products_status ="1" AND pd.language_id="'.(int)$languages_id.'" LIMIT 1');
	$hotel_row = tep_db_fetch_array($hotel_sql);
	if((int)$hotel_row['products_id']){ //
		//ȡ���г���Ϣ
		$tour_sql = tep_db_query('SELECT p.products_id, p.products_durations, pd.products_name, pd.products_description FROM `products` p, `products_description` pd WHERE p.products_id ="'.(int)$_POST['t_id'].'" AND p.products_id = pd.products_id AND p.products_status ="1" AND pd.language_id="'.(int)$languages_id.'" LIMIT 1');
		$tour_row = tep_db_fetch_array($tour_sql);
?>

	<div class="hotel_single_slect">
	<div id="day_for_all" style="display:<?= 'none'?>"><?php echo db_to_html('��'.((int)$_POST['No_day_for_all']+1).'��')?></div>
		 <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
			  <td width="23%" valign="top"><a href="<?= tep_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$hotel_row['products_id'])?>" target="_blank"><img src="images/<?php echo $hotel_row['products_image'];?>" width="150" height="104"></a></td>
			  <td width="4%">&nbsp;</td>
			  <td width="73%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="14%" height="20" valign="top"><?php echo db_to_html('�Ƶ�����')?></td>
				  <td width="86%" valign="top"><?php echo db_to_html(tep_db_output($hotel_row['products_name']));?></td>
				</tr>
				
				<tr>
				  <td height="18" valign="top"><?php echo db_to_html('�Ƶ��Ǽ�')?></td>
				  <td valign="top"><?php echo db_to_html(tep_db_output($hotel_row['hotel_star']). ' ��');?></td>
				</tr>
				
				<tr>
				  <td height="18" valign="top"><?php echo db_to_html('��ַ')?></td>
				  <td valign="top"><?php echo db_to_html(tep_db_output($hotel_row['hotel_address']));?></td>
				</tr>
				<?php /*���޵绰 
				<tr>
				  <td height="18" valign="top"><?php echo db_to_html('�绰')?></td>
				  <td valign="top">714-719-8500</td>
				</tr>
				*/?>
				<tr>
				  <td height="18" valign="top"><?php echo db_to_html('���')?></td>
				  <td valign="top"><?php echo db_to_html($hotel_row['products_small_description']);?></td>
				</tr>
				</table></td>
			</tr>
		 </table>
	</div>
	  
	<div class="pipei_note pipei_note_h"><?php echo db_to_html('���Ѿ�ѡ���� <a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$hotel_row['products_id']).'" target="_blank">'.tep_db_output($hotel_row['products_name']).'</a>(�Ƶ�) + <a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$tour_row['products_id']).'" target="_blank">'.tep_db_output($tour_row['products_name']).'</a>�г� �����,ռ����<span class="cu">'.$_POST['date_num'].'</span>���г��е� <span class="cu">'.$tour_row['products_durations'].'</span> ��');?>
	</div>
	
	<div id="products_description" class="pipei_note pipei_note_h">
	<?php
	//ȡ���ŵ�No_day����г�����
	//echo $_POST['No_day'];
	echo db_to_html($tour_row['products_description']);
	?>
	</div>
<?php
	}
}
//ajax end
?>

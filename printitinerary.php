<?php
/*
  $Id: printorder.php,v 1.1 2003/01 xaglo

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');



   $product_info_query = tep_db_query("select p.products_video, p.products_type, p.operate_start_date ,p.operate_end_date,p.products_single,p.products_double,p.products_triple,p.products_quadr,p.products_kids, p.display_room_option,p.maximum_no_of_guest,p.products_id, pd.products_name, pd.products_description, pd.products_pricing_special_notes,  pd.products_other_description, pd.products_package_excludes, pd.products_package_special_notes, p.products_is_regular_tour, p.products_model, p.products_quantity, p.products_image, p.products_image_med, p.products_image_lrg, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id, p.departure_city_id, p.departure_end_city_id, p.agency_id, p.display_pickup_hotels,pd.products_small_description,p.is_hotel from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);


  

  require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_ORDERS_PRINTABLE);
    require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);


?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo STORE_NAME . ' - '; ?><?php echo stripslashes(db_to_html($product_info['products_name'])); ?></title>
<base href="<?php echo (getenv('HTTPS') == 'on' ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="print.css">
<style type="text/css">
.xlin dl dt{text-align:center;}
.day{font-weight:bold;}
img{border:0;}
</style>
</head>
<body marginwidth="10" marginheight="10" topmargin="10" bottommargin="10" leftmargin="10" rightmargin="10">
<script type="text/javascript">
function my_print(){
	var html = document.getElementById('lwk_print').innerHTML;
	document.body.innerHTML = html;
	window.print();
}
if (window.print) {
	document.write('<table align="center" width="715" border="0" cellspacing="0" cellpadding="5">');
    document.write('<tr>');
    document.write('<td valign="top" align="left" class="main">');
    document.write('<a href="javascript:;" onClick="javascript:my_print()" onMouseOut=document.imprim.src="<?php echo (DIR_WS_IMAGES . 'printimage.gif'); ?>" onMouseOver=document.imprim.src="<?php echo (DIR_WS_IMAGES . 'printimage_over.gif'); ?>"><img src="<?php echo (DIR_WS_IMAGES . 'printimage.gif'); ?>" width="43" height="28" align="absbottom" border="0" name="imprim">' + '<?php echo IMAGE_BUTTON_PRINT; ?></a></center>');
    document.write('</td>');
    document.write('<td align="right" valign="bottom" class="main"><p align="right" class="main"><a href="javascript:window.close();"><img src="<?= DIR_WS_IMAGES;?>close_window.jpg" border=0></a></p></td>');
    document.write('</tr>');
    document.write('</table>');
}
</script>

<div id="lwk_print">

<table cellpadding="0" cellspacing="0" border="0" width="715" align="center">
	<tbody>
    	<tr>
        	<td style="border-bottom:3px solid #000099;padding-bottom:7px;"><img src="/image/logo24.png" width="190" height="67" /></td>
            <td style="border-bottom:3px solid #000099;padding-bottom:7px;text-align:right;">
            	<div style="margin:0;padding:0;text-align:right;">
                	<img src="/image/plus.png" width="40" height="40" style="float:right;margin-left:5px;margin-top:8px;" />
                	<p style="display:inline;margin:0;color:#000099;line-height:28px;font-family:'Microsoft Yahei';font-size:14px;font-weight:bold;"><?php echo db_to_html('ȫ������ѡ����������վ<br />����BBB��֤�����������');?></p>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<?php if ((int)$product_info['is_hotel'] == 0) { ?>
<table cellpadding="0" cellspacing="0" border="0" width="715" align="center" style="border:1px solid #548DD4;margin-top:10px;font-size:12px;color:#333333;">
	<thead>
    	<tr style="background:#4F81BD;line-height:24px;">
        	<th colspan="6" style="text-align:left;text-indent:5px;color:#ffffff;font-size:14px;" bgcolor="#4F81BD"><?php echo db_to_html('�г̻�����Ϣ');?></th>
        </tr>
    </thead>
    <tbody>
    	<tr style="line-height:26px;">
        	<td colspan="2" style="border-top:1px solid #548DD4;text-indent:10px;font-size:14px;font-weight:bold;"><?php echo db_to_html(preg_replace("/\*\*.+/","",$product_info['products_name']));?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td colspan="2" style="border-top:1px solid #548DD4;text-indent:10px;"><?php $smallNames = explode('**',$product_info['products_name']);
        	if (tep_not_null($smallNames[1])) {
        		echo db_to_html($smallNames[1] . '&nbsp;');
        	}?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td width="85" style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('�г̼۸�')?></td>
            <td style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;"><?php echo db_to_html($product_info['products_price'] . '��');?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td width="85" style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('�����źţ�')?></td>
            <td style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;"><?php echo db_to_html($product_info['products_model']) ?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td width="85" style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('�� �� �أ�')?></td>
            <td style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;"><?php $city_arr = tep_get_city_names($product_info['departure_city_id']);
            echo db_to_html(join(",",$city_arr));
            ?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td width="85" style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('�� �� �أ�')?></td>
            <td style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;"><?php $city_arr = tep_get_city_names($product_info['departure_end_city_id']);
            echo db_to_html(join(",",$city_arr));
            ?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td width="85" style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('����ʱ�䣺')?></td>
            <td style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;"><?php echo join('<br/>',tep_get_display_operate_info($product_info['products_id'],1));?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td width="85" style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;vertical-align:top;"><?php echo db_to_html('�г���ɫ��')?></td>
            <td style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;"><?php echo db_to_html($product_info['products_small_description']);?></td>
        </tr>     
    </tbody>
</table>
<?php } else { 
		/* ����ǾƵ� ����� �Ƶ���Ϣ */
		require_once(DIR_FS_FUNCTIONS . 'hotels_functions.php');
		$hotelQuery = tep_db_query("SELECT hotel_id, hotel_stars, meals_id, internet_id, approximate_location_id, hotel_phone, hotel_address FROM `hotel` WHERE products_id =".(int)$product_info['products_id']." Limit 1 ");
		$hotelRow = tep_db_fetch_array($hotelQuery);
		foreach((array)$hotelRow as $key => $val){
			$product_info[$key] = $hotelRow[$key];
		}
	?>

<table cellpadding="0" cellspacing="0" border="0" width="715" align="center" style="border:1px solid #548DD4;margin-top:10px;font-size:12px;color:#333333;">
	<thead>
    	<tr style="background:#4F81BD;line-height:24px;">
        	<th colspan="6" style="text-align:left;text-indent:5px;color:#ffffff;font-size:14px;"><?php echo db_to_html('�Ƶ������Ϣ');?></th>
        </tr>
    </thead>
    <tbody>
    	<tr style="line-height:26px;">
        	<td colspan="4" style="border-top:1px solid #548DD4;text-indent:10px;font-size:14px;font-weight:bold;"><?php echo db_to_html(preg_replace("/\*\*.+/","",$product_info['products_name']));?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td colspan="4" style="border-top:1px solid #548DD4;text-indent:10px;"><?php
        	if($product_info['departure_city_id'] == '')$product_info['departure_city_id'] = 0;
						$city_class_departure_at_query = tep_db_query("select c.city_id, c.city, s.zone_code, co.countries_iso_code_3  from " . TABLE_TOUR_CITY . " as c ," . TABLE_ZONES . " as s, ".TABLE_COUNTRIES." as co where c.state_id = s.zone_id and s.zone_country_id = co.countries_id and c.city_id in (" . $product_info['departure_city_id'] . ") order by c.city ");
						while($city_class_departure_at = tep_db_fetch_array($city_class_departure_at_query)) {
							$product_info['departure_city_name'] = $city_class_departure_at['city'];
							$product_info['���ڳ���'] = $city_class_departure_at['city'] . ', ' . $city_class_departure_at['zone_code'] . ', ' . $city_class_departure_at['countries_iso_code_3'];
							echo  db_to_html($city_class_departure_at['city']).', '.$city_class_departure_at['zone_code'].', '.$city_class_departure_at['countries_iso_code_3'].'&nbsp;';
						} 
        	echo db_to_html(getHotelApproximateLocation($product_info['approximate_location_id']));
        	?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td width="10%" style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('�Ƶ�۸�')?></td>
            <td width="40%" style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;border-right:1px solid #548DD4;"><?php echo db_to_html($product_info['products_price']);?></td>
            <td width="10%" style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('�Ƶ��ţ�')?></td>
            <td width="40%" style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;"><?php echo db_to_html($product_info['products_model']) ?></td>
        </tr>

        <tr style="line-height:26px;">
        	<td style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('���ڳ��У�')?></td>
            <td style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;border-right:1px solid #548DD4;"><?php echo db_to_html($product_info['���ڳ���'])?></td>
            <td style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('�Ƶ꼶��')?></td>
            <td style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;"><?php echo db_to_html($product_info['hotel_stars']."��");?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('��������');?></td>
            <td style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;border-right:1px solid #548DD4;"><?php echo db_to_html(getHotelMealsOptions($product_info['meals_id']));?></td>
            <td style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('��������');?></td>
            <td style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;"><?php echo db_to_html(getHotelInternetOptions($product_info['internet_id']));?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;"><?php echo db_to_html('�Ƶ��ַ��');?></td>
            <td colspan="3" style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;"><?php echo db_to_html($product_info['hotel_address']);?></td>
        </tr>
        <tr style="line-height:26px;">
        	<td style="border-top:1px solid #548DD4;text-align:right;font-weight:bold;vertical-align:top;"><?php echo db_to_html('�Ƶ��飺')?></td>
            <td colspan="3" style="border-top:1px solid #548DD4;text-align:left;padding-left:20px;"><?php echo db_to_html($product_info['products_small_description']);?></td>
        </tr>     
    </tbody>
</table>

<?php } ?>
<table cellpadding="0" cellspacing="0" border="0" width="715" align="center" style="border:1px solid #548DD4;margin-top:10px;font-size:12px;color:#333333;">
	<thead>
    	<tr style="background:#4F81BD;line-height:24px;">
        	<th colspan="6" style="text-align:left;text-indent:5px;color:#ffffff;font-size:14px;border-top:1px solid #548DD4;"><?php 
        	if ((int)$product_info['is_hotel'] == 0) {
        		echo db_to_html('�г�����');
        	} else {
        		echo db_to_html('�Ƶ����');
        	}?></th>
        </tr>
    </thead>
    <tbody>
    	<tr style="line-height:26px;">
        	<td style="border-top:1px solid #548DD4;padding:5px;">
        	<?php
			$products_travel_sql = tep_db_query('SELECT * FROM `products_travel` WHERE products_id="'.(int)$products_id.'" and langid="'.(int)$languages_id.'"  ORDER BY `travel_index` ASC ');
			$products_travel = tep_db_fetch_array($products_travel_sql);
			$products_travel_rows = tep_db_num_rows($products_travel_sql);
			if(tep_not_null($products_travel['travel_content'])){
				//��׼���г̽���
				$day_num = 0;
				do{
					$day_num++;
					if($products_travel_rows>1){
						$day_num_string = db_to_html('��'.$day_num.'��');
					}else{ $day_num_string =""; }
					?>
			  		<p style="margin:0;padding:0;font-weight:bold;font-size:14px;"><strong style="font-size:18px;">��</strong><?php echo $day_num_string;?> <?php echo db_to_html($products_travel['travel_name']);?></p>
					<?php if(tep_not_null($products_travel['travel_img'])){?>
						<p style="margin:0;padding:0;text-align:center"><img src="<?php
						if (strtolower(substr($products_travel['travel_img'],0,4)) == 'http' || substr($products_travel['travel_img'],0,1) == '/') {
							echo $products_travel['travel_img'];
						} else {
							echo 'images/' . $products_travel['travel_img'];
						}
						
						?>" alt="<?= $products_travel['travel_img'];?>" title="<?= $products_travel['travel_img'];?>" onload="if(this.width > 200){this.width=200}"/></p>
					<?php }?>
					<p style="margin:0;padding:0;"><?php echo nl2br(db_to_html($products_travel['travel_content']));?>
					<span><?php echo db_to_html('�Ƶ�: ' . $products_travel['travel_hotel'] . ' ����ͬ�ȼ��Ƶ�')?></span></p>
					<?php
				}while($products_travel = tep_db_fetch_array($products_travel_sql));
			}else{
				//���г̽���
				echo db_to_html($product_info['products_description']);
			}
		  ?>
            	<!--<p style="margin:0;padding:0;font-weight:bold;font-size:14px;"><strong style="font-size:18px;">��</strong>��һ�� ԭ�ӵ�(Hometown) - �ɽ�ɽ(San rancisco)</p>
                <p style="margin:0;padding:0;text-align:center"><img src="test.jpg" width="360" height="270" /></p>
                <p style="margin:0;padding:0;">�������ó̽����������ھɽ�ɽ�����ǿ̿�ʼ������ĵ��ν����������촦�Ⱥ����ĵ��������λ����������齵ľƵ꣬
���������а���?�µ�ʱ�䡣 �Ƶ꣺Marriott Courtyard Hotel ��ͬ���Ƶꡣ</p>
            	<p style="margin:0;padding:0;font-weight:bold;font-size:14px;"><strong style="font-size:18px;">��</strong>�ڶ��� ԭ�ӵ�(Hometown) - �ɽ�ɽ(San rancisco)</p>
                <p style="margin:0;padding:0;text-align:center"><img src="test.jpg" width="360" height="270" /></p>
                <p style="margin:0;padding:0;">�������ó̽����������ھɽ�ɽ�����ǿ̿�ʼ������ĵ��ν����������촦�Ⱥ����ĵ��������λ����������齵ľƵ꣬
���������а���?�µ�ʱ�䡣 �Ƶ꣺Marriott Courtyard Hotel ��ͬ���Ƶꡣ</p>-->
            </td>
        </tr> 
    </tbody>
</table>
<?php # print_r($product_info) ?>
<table width="715" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #548DD4;margin-top:10px;font-size:12px;color:#333333;border-right:0;">
<thead>
	<tr style="background:#4F81BD;line-height:24px;">
		<th colspan="5" style="text-align:left;text-indent:5px;color:#ffffff;font-size:14px;border-right:1px solid #548DD4;"><?php echo db_to_html('�۸���ϸ')?></th>
	</tr>
	</thead>
	<tbody>
	<tr style="line-height:26px;">
		<?php 
		if ((int)$product_info['display_room_option'] == 1) { 
			if ((int)$product_info['products_double'] > 0) {	
		?>
		<td align="center" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html('˫��һ��');?></td>
		<?php }
			if ((int)$product_info['products_triple'] > 0) { 
		?>
		<td align="center" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html('����һ��');?></td>
		<?php }
			if ((int)$product_info['products_quadr'] > 0) {
		?>
		<td align="center" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html('����һ��');?></td>
		<?php }
			if ((int)$product_info['products_single'] > 0) {
		?>
		<td align="center" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html('����һ��');?></td>
		<?php }
			if ((int)$product_info['products_kids'] > 0) {
		?>
		<td align="center" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html('С��');?></td>
		<?php }
		} else { 
			if ((int)$product_info['products_single'] > 0) {?>
		<td align="center" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html('����');?></td>
		<?php }
			if ((int)$product_info['products_kids'] > 0) { ?>
		<td align="center" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html('С��');?></td>
		<?php }
		} ?>
	</tr>
	<tr style="line-height:26px;">
	<?php if ((int)$product_info['display_room_option'] == 1) { 
		if ((int)$product_info['products_double'] > 0) {	?>
		<td align="center"  style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html($product_info['products_double']) ?></td>
		<?php }
			if ((int)$product_info['products_triple'] > 0) { 
		?>
		<td align="center" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html($product_info['products_triple']) ?></td>
		<?php }
			if ((int)$product_info['products_quadr'] > 0) {
		?>
		<td align="center" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html($product_info['products_quadr']) ?></td>
		<?php }
			if ((int)$product_info['products_single'] > 0) {
		?>
		<td align="center" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html($product_info['products_single']) ?></td>
		<?php }
			if ((int)$product_info['products_kids'] > 0) {
		?>
		<td align="center" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html($product_info['products_kids']) ?></td>
		<?php
			}
		} else { 
			if ((int)$product_info['products_single'] > 0) {?>
		<td align="center"  style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html($product_info['products_single']);?></td>
		<?php }
			if ((int)$product_info['products_kids'] > 0) { ?>
		<td align="center"  style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;"><?php echo db_to_html($product_info['products_kids']) ?></td>
		<?php }
		} ?>
	</tr>
	<tr style="line-height:26px;">
		<td colspan="5" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;padding:8px;">
		<p><?php echo db_to_html($product_info['products_pricing_special_notes']) ?></p>
		<p style="margin:0;padding:0;font-weight:bold;font-size:14px;"><strong style="font-size:18px;">��</strong><?php echo db_to_html('���ð���')?></p>
		<p><?php echo db_to_html($product_info['products_other_description']) ?></p>
		<p style="margin:0;padding:0;font-weight:bold;font-size:14px;"><strong style="font-size:18px;">��</strong><?php echo db_to_html('���ò�����');?></p>
		<p><?php echo db_to_html($product_info['products_package_excludes'])?></p>
		</td>
	</tr>
	</tbody>
</table>


	<?php 
			//����ʱ��͵ص� start
$departure_query_address = "select departure_id,departure_time,departure_address from " . TABLE_PRODUCTS_DEPARTURE . " where  products_id = " . (int) $product_info['products_id'] . "  order by departure_time desc";
$departure_row_address = tep_db_query($departure_query_address);
$totaldipacount = tep_db_num_rows($departure_row_address);
if ($totaldipacount > 0) {
?>
<table width="715" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #548DD4;margin-top:10px;font-size:12px;color:#333333;border-right:0;">
<thead>
	<tr style="background:#4F81BD;line-height:24px;">
		<th colspan="5" style="text-align:left;text-indent:5px;color:#ffffff;font-size:14px;border-right:1px solid #548DD4;"><?php echo db_to_html('����ʱ��/�ص�')?></th>
	</tr>
	</thead>
	<tbody>
<?php
while ($departure_result_address = tep_db_fetch_array($departure_row_address)) {
	?>
<tr style="line-height:26px;">
		<td colspan="5" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;padding:8px;">
		<?php 	
		echo db_to_html('����ʱ�䣺' . $departure_result_address['departure_time'] . '<br/>');
		echo db_to_html('�����ص㣺' . $departure_result_address['departure_address'] . '<br/>');
?>
		</td>
	</tr>
	<?php }?>
	</tbody>
</table>

<?php } ?>
<table width="715" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #548DD4;margin-top:10px;font-size:12px;color:#333333;border-right:0;">
<thead>
	<tr style="background:#4F81BD;line-height:24px;">
		<th colspan="5" style="text-align:left;text-indent:5px;color:#ffffff;font-size:14px;border-right:1px solid #548DD4;"><?php echo db_to_html('ע������')?></th>
	</tr>
	</thead>
	<tbody>
<tr style="line-height:26px;">
		<td colspan="5" style="border-top:1px solid #548DD4;border-right:1px solid #548DD4;padding:8px;">
			<?php echo db_to_html($product_info['products_package_special_notes']);?>
			
			<?php //Ԥ�����򼰵��Ӳ���ƾ֤ start
	echo '<h2>'.TEXT_HEADING_TOURS_DETAILS_RESERVATION_PROCCESS_ETICKET.'</h2>';
	$TOURS_DEFAULT_RESERVATION_PROCCESS_ETICKET = stripslashes2(TOURS_DEFAULT_RESERVATION_PROCCESS_ETICKET);
	if($isHotels){
		$TOURS_DEFAULT_RESERVATION_PROCCESS_ETICKET = str_replace(array('����','����'), array('��ס�Ƶ�','�Ƶ깤����Ա'),$TOURS_DEFAULT_RESERVATION_PROCCESS_ETICKET);
	}
	echo db_to_html($TOURS_DEFAULT_RESERVATION_PROCCESS_ETICKET);
	
//Ԥ�����򼰵��Ӳ���ƾ֤ end
//�������� start
	echo '<h2>'.TEXT_HEADING_TOURS_DETAILS_TERMS_AND_CONDITIONS.'</h2>';
	echo stripslashes2(db_to_html(TOURS_DEFAULT_TERMS_AND_CONDITIONS));
//�������� end 
?>
		</td>
	</tr>
	</tbody>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="715" align="center" style="font-size:14px;color:#333333;">
    <tbody>
    	<tr style="line-height:24px;">
        	<td style="padding:10px;">
            	<p style="margin:0;padding:0;">
                	<?php echo db_to_html('------------<br /><span style="text-decoration:underline;font-weight:bold;">208.109.123.18|���ķ�������</span><br />                    Your trip , Our care!<br />                    ��������,�ҵĹ�ע!');?>
                </p>
            </td>
        </tr>
    </tbody>
</table>
<?php ob_start() ?>
<table cellpadding="0" cellspacing="0" border="0" width="715" align="center">
	<tbody>
    	<tr style="line-height:24px;font-family:Tahoma;font-weight:bold;font-size:12px;color:#000099;">
        	<td style="border-top:3px solid #000099;text-align:left;">
            	<p style="margin:0;padding:0;">����(����):888-887-2816  FAX:(001) 225-757-1340<br />�й�(����):4006-333-926  FAX:(0086)0755-23036129</p>
            </td>
            <td style="border-top:3px solid #000099;text-align:right;">
            	<p style="margin:0;padding:0;">Unitedstars International Ltd<br />208.109.123.18|���ķ�������</p>
            </td>
        </tr>
    </tbody>
</table>

<?php echo db_to_html(ob_get_clean()) ?>

</div>


<?php // old code by lwkai 2012-05-07 ע��
		  /*
<!-- body_text //-->
<table width="600" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td align="center" class="main"><table align="center" width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td valign="top" align="left" class="main"><script language="JavaScript">
  if (window.print) {
    document.write('<a href="javascript:;" onClick="javascript:window.print()" onMouseOut=document.imprim.src="<?php echo (DIR_WS_IMAGES . 'printimage.gif'); ?>" onMouseOver=document.imprim.src="<?php echo (DIR_WS_IMAGES . 'printimage_over.gif'); ?>"><img src="<?php echo (DIR_WS_IMAGES . 'printimage.gif'); ?>" width="43" height="28" align="absbottom" border="0" name="imprim">' + '<?php echo IMAGE_BUTTON_PRINT; ?></a></center>');
  }
  else document.write ('<h2><?php echo IMAGE_BUTTON_PRINT; ?></h2>')
        </script></td>
        <td align="right" valign="bottom" class="main"><p align="right" class="main"><a href="javascript:window.close();"><img src='<?= DIR_WS_IMAGES;?>close_window.jpg' border=0></a></p></td>
      </tr>
    </table></td>
  </tr>
  <tr align="left">
    <td class="titleHeading"><?php echo tep_draw_separator('pixel_trans.gif', '1', '25'); ?></td>
  </tr>
  <tr>
    <td><table border="0" align="center" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" align="center" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo nl2br(db_to_html(STORE_NAME_ADDRESS)); ?></td>
            
          </tr>
		   <tr>
            <td colspan="2" >&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="main"><b><?php echo db_to_html('����������')?>: <?php echo stripslashes(db_to_html($product_info['products_name'])); ?></b></td>
          </tr>
		   <tr>
            <td colspan="2"  height="5"></td>
          </tr>
		   <tr>
            <td colspan="2" class="main"><b><?php echo db_to_html('��Ʒ���')?>: <?php echo db_to_html($product_info['products_model']);?></b></td>
          </tr>
          <tr>
            <td colspan="2"  height="5"></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td align="left" class="main">
	
		<table  width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
		 
		  <td width="100%" valign="top" class="main">
		  <?php //echo stripslashes($product_info['products_description']);		//It will lead to html pages refuse fonts  ?>
		  <?php
			$products_travel_sql = tep_db_query('SELECT * FROM `products_travel` WHERE products_id="'.(int)$products_id.'" and langid="'.(int)$languages_id.'"  ORDER BY `travel_index` ASC ');
			$products_travel = tep_db_fetch_array($products_travel_sql);
			$products_travel_rows = tep_db_num_rows($products_travel_sql);
			if((int)$products_travel['travel_index']){
				//��׼���г̽���
		?>
			<ul class="route">
			<?php
			$day_num = 0;
			do{
				$day_num++;
				if($products_travel_rows>1){
					$day_num_string = db_to_html('��'.$day_num.'��');
				}else{ $day_num_string =""; }
			?>
			  <li>
				<h1><b><?php echo $day_num_string;?></b> <?php echo db_to_html($products_travel['travel_name']);?></h1>
				<?php if(tep_not_null($products_travel['travel_img'])){?>
				<img src="images/<?= $products_travel['travel_img'];?>" alt="<?= $products_travel['travel_img'];?>" title="<?= $products_travel['travel_img'];?>" />
				<?php }?>
				<p><?php echo nl2br(db_to_html($products_travel['travel_content']));?></p>
				<span><?php echo db_to_html('�Ƶ�: Appletree Inn, Richfield ����ͬ�ȼ��Ƶ�')?></span>
			  </li>
			<?php
			}while($products_travel = tep_db_fetch_array($products_travel_sql));
			?>
			</ul>
		<?php
			}else{
				//���г̽���
				echo db_to_html($product_info['products_description']);
			}
		  ?>
		  </td>
		
		  </tr>
		   <tr>
            <td colspan="2"  height="10"></td>
          </tr>
		</table>
	</td>
  </tr>

</table>
<!-- body_text_eof //-->

*/
// old code end by lwkai 2012-05-07 ע�� 
?>		  

</body>
</html>
<?php require(DIR_FS_INCLUDES . 'application_bottom.php'); ?>

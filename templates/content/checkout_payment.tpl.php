<?php
$have_group_buy = false;
$haveHotel = false;	//�оƵ�
$haveTours = false;	//����ͨ�г�
//�Ƿ��������Ż����Ź���
$is_special = false;
//ͳ�����в�ƷID�������ж��Ƿ�ĳ����Ʒ����ʹ��ĳ��֧����ʽ by lwkai add 2013-5-13
$products_id_array = array();
for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
	$products_id_array[intval($order->products[$i]['id'])] = count($products_id_array);
	if((int)is_group_buy_product((int)$order->products[$i]['id'])){
		$have_group_buy = true;
	}
	$arrival_date = "";
	$departure_date = "";
	foreach ($_SESSION as $key => $val) {
		if (strstr($key, 'arrival_date' . $i)) {
			$arrival_date = $val;
		}
	}
	foreach ($_SESSION as $key => $val) {
		if (strstr($key, 'departure_date' . $i)) {
			$departure_date = $val;
		}
	}

	$is_hotel_tour=tep_check_product_is_hotel((int)$order->products[$i]['id']);
	if($is_hotel_tour == 1){
		$haveHotel = true;
	}else{
		$haveTours = true;
	}
	//�ж���û���ؼ۲�Ʒ �����Ź���Ʒ
	if ((int)special_detect($order->products[$i]['id'])) {
		$is_special = true;
	}
}

?>

<script type="text/javascript"><!--
function display_table(link_id,id){
	var link_id = document.getElementById(link_id);
	var id = document.getElementById(id);
	if(id.style.display=='none'){
		id.style.display ="";
		link_id.innerHTML = "<?php echo db_to_html('����');?>";
	}else{
		id.style.display ="none";
		link_id.innerHTML = "<?php echo db_to_html('��ʾ');?>";
	}
}

var DateForMat = "mm/dd/yyyy";	//����ѡ�������ڸ�ʽ
//--></script>
<script type="text/javascript" charset="gb2312" src="includes/javascript/calendar.js"><!--����ѡ���//--></script>

<?php echo tep_get_design_body_header(HEADING_TITLE); ?>
<!-- content main body start -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">

<tr>
<td class="main">

<?php echo tep_draw_form('checkout_payment', tep_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post', 'onsubmit="return check_form();" id="checkout_payment"'); ?><table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">

<tr>
<td align="center"><?php ob_start();?>
	<div class="cart_progress">
		<div class="cart_left">
    		<em class="cart_icon"></em><h3>�ҵĹ��ﳵ</h3>
    	</div>
    	<div class="cart_right">
    		<ul>
        		<li class="first"><span></span>1.ѡ���Ʒ</li>
            	<li><span></span>2.�鿴���ﳵ</li>
            	<li><span></span>3.ȷ���г���Ϣ</li>
            	<li class="cur"><span></span>4.��ɶ���</li>
            	<li class="last"><span class="cur"></span></li>
         	</ul>
    	</div>
	</div><?php echo db_to_html(ob_get_clean());?>
<!--<table width="0%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><a href="<?= tep_href_link('checkout_info.php', '', 'SSL');?>" class="broud-line"><?php echo tep_template_image_button('tours_info2.gif','','')?></a></td>
<td><img src="image/jiantou2.gif" style="margin-left:60px; margin-right:60px;" /></td>
<td><?php echo tep_template_image_button('payment-info.gif','','')?></td>
<td><img src="image/jiantou1.gif" style="margin-left:60px; margin-right:60px;" /></td>
<td><?php echo tep_template_image_button('check-info.gif','','')?></td>

</tr>
</table>-->
</td>
</tr>

<?php
if ($messageStack->size('checkout_payment') > 0) {
	?>
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	</tr>
	<tr>
	<td><?php echo $messageStack->output('checkout_payment'); ?></td>
	</tr>
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	</tr>
	<?php
}
?>


<?php
if (isset($HTTP_GET_VARS['guest_weight_error']) && $HTTP_GET_VARS['guest_weight_error']=='true') {
	?>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="main"><b><?php echo TEXT_GUEST_BODY_WEIGHT_ERROR; ?></b></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBoxNotice">
	<tr class="infoBoxNoticeContents">
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	<td class="main" width="100%" valign="top"><?php echo tep_output_string_protected($_GET['error']); ?></td>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
	</tr>
	<?php
}
?>
<?php
if (isset($HTTP_GET_VARS['guest_child_error']) && $HTTP_GET_VARS['guest_child_error']=='true') {
	?>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="main"><b><?php echo TEXT_GUEST_CHILD_BIRTH_DATE_ERROR; ?></b></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBoxNotice">
	<tr class="infoBoxNoticeContents">
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	<td class="main" width="100%" valign="top"><?php echo tep_output_string_protected($_GET['error']); ?></td>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
	</tr>
	<?php
}
?>

<?php
if (isset($HTTP_GET_VARS['guest_childage_error']) && $HTTP_GET_VARS['guest_childage_error']=='true') {
	?>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="main"><b><?php echo TEXT_GUEST_CHILD_AGE_ERROR; ?></b></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBoxNotice">
	<tr class="infoBoxNoticeContents">
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	<td class="main" width="100%" valign="top"><?php echo tep_output_string_protected($_GET['error']); ?></td>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
	</tr>
	<?php
}
?>
<?php
if (isset($HTTP_GET_VARS['guest_error']) && $HTTP_GET_VARS['guest_error']=='true') {
	?>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="main"><b><?php echo TEXT_GUEST_NAME_ERROR; ?></b></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBoxNotice">
	<tr class="infoBoxNoticeContents">
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	<td class="main" width="100%" valign="top"><?php echo tep_output_string_protected($_GET['error']); ?></td>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
	</tr>
	<?php
}
?>

<?php
if (isset($HTTP_GET_VARS['arrival_time_error']) && $HTTP_GET_VARS['arrival_time_error']=='true') {
	?>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="main"><b><?php echo TEXT_ARRIVAL_TIME_ERROR; ?></b></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBoxNotice">
	<tr class="infoBoxNoticeContents">
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	<td class="main" width="100%" valign="top"><?php
	echo TEXT_ARRIVAL_TIME_ERROR_MSG_DIS;
	//echo tep_output_string_protected($_GET['error']); ?></td>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
	</tr>
	<?php
}
?>
<?php
if (isset($HTTP_GET_VARS['departure_time_error']) && $HTTP_GET_VARS['departure_time_error']=='true') {
	?>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="main"><b><?php echo TEXT_DEPARTURE_TIME_ERROR; ?></b></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBoxNotice">
	<tr class="infoBoxNoticeContents">
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	<td class="main" width="100%" valign="top">
	<?php
	echo TEXT_DEPARTURE_TIME_ERROR_MSG_DIS;
	//echo tep_output_string_protected($_GET['error']); ?></td>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
	</tr>
	<?php
}
?>

<?php
if (isset($HTTP_GET_VARS['payment_error']) && is_object(${$HTTP_GET_VARS['payment_error']}) && ($error = ${$HTTP_GET_VARS['payment_error']}->get_error())) {
	?>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="main"><b><?php echo tep_output_string_protected($error['title']); ?></b></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBoxNotice">
	<tr class="infoBoxNoticeContents">
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	<td class="main" width="100%" valign="top"><?php echo tep_output_string_protected($error['error']); ?></td>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
	</tr>
	<?php
}
?>
<?php
if (isset($HTTP_GET_VARS['authorize_max_attempt_over_error']) && $HTTP_GET_VARS['authorize_max_attempt_over_error']=='true') {
	?>
	<tr>
	<td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBoxNotice">
	<tr class="infoBoxNoticeContents">
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	<td class="main" width="100%" valign="top"><?php echo AUTHORIZE_MAX_ATTEMPT_OVER_ERROR; ?></td>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	</tr>
	<?php
}
?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
	table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>

<tr>
<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
</tr>

<?php
//�����г���Ϣ start
$hidden_information = true;
if($hidden_information == true){
	//�����Ƿ��н��ͬ�ε���
	$jiebantongyou=false;
	for ($i=0, $n=sizeof($order->products); $i<$n; $i++){
		if($order->products[$i]['roomattributes'][5]=='1'){
			$jiebantongyou = true;
		}
	}

}else if($hidden_information!=true){
	// if customer REDEMPTIONS >= $1 , display on.
	if((int)(tep_get_shopping_points($customer_id) / REDEEM_POINT_VALUE)){
		?>
		<tr>
		<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="2">
		<tr>
		<td class="infoBoxHeading"><div class="heading_bg"><?php echo TABLE_HEADING_REDEEM_SYSTEM; ?></div> <div class="head_note"><span class="inputRequirement"><?php echo FORM_REQUIRED_INFORMATION; ?></span></div></td>
		</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<div class="infoBox_outer">
		<table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBox_new">
		<tr class="infoBoxContents_new">
		<td><table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr><td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td></tr>
		<tr>
		<td class="main" colspan="2">
		<table width="100%" align="center" cellpadding="0" cellspacing="0">
		<?php
		$jiebantongyou = false;
		for ($i=0, $n=sizeof($order->products); $i<$n; $i++){

			//howard added travel companion
			$jiebantongyong="";
			if($order->products[$i]['roomattributes'][5]=='1'){
				$jiebantongyou = true;
				$jiebantongyong = '&nbsp;<span style="color:#FF9900;font-weight: bold;">'.db_to_html('�����ͬ���ţ�').'</span>';
			}

			?>

			<tr>
			<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
			<td class="main"><b class="bluetext_font"><?php echo ($i+1).' '.db_to_html('������'.$order->products[$i]['name']) ?></b><?php echo $jiebantongyong;?><a href="<?php echo tep_href_link('shopping_cart.php');?>" class="sp1">[<?php echo db_to_html('�༭');?>]</a></td>
			<td align="right" class="sp1" valign="top"><b><?php echo $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']); ?></b></td>
			</tr>
			<?php
		}
		?>

		</table>
		</td>
		</tr>
		<tr><td><?php echo tep_draw_separator('pixel_trans.gif', '100%', min(15, (5*$n))); ?></td></tr>
		<tr>
		<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
		<?php /* ?><td class="main">Maximum discount available for this order is $<?php echo $total_allowable_discount; ?>.  <?php printf(TEXT_REDEEM_SYSTEM_START, $currencies->format(tep_calc_shopping_pvalue($customer_shopping_points)), $currencies->format($order->info['total']). $note); ?></td>
		<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
		</tr>
		<tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
		<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
		<td class="main"><?php printf(TEXT_REDEEM_SYSTEM_SPENDING, number_format($max_points,POINTS_DECIMAL_PLACES), $currencies->format(tep_calc_shopping_pvalue($max_points))); ?></td><?php */ ?>

		<td class="main">
		<b class="sp1">
		<?php echo R4F_REDEMPTIONS_TOTAL.'&nbsp;'.$currencies->format($order->info['total']); ?></b>

		</td></tr>

		<tr><td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td></tr>
		</table>
		</td>
		</tr>
		</table>
		</div>
		</td>
		</tr>
		<?php
	}
	// if customer REDEMPTIONS >= $1 , display on. end
}
//�����г���Ϣ end
?>

<?php
//���ȡ�ý��ƽ�ֵ��Ҹ��۸�
	$i_pay = array();
	$is_travel_companion = false;
	for ($i=0, $n=sizeof($order->products); $i<$n; $i++){
/* ������ͬ�� ����Ҫ������Ǯ ��checkout_confirmation.tpl.php �ļ�����ֲ�������ܸ�д�� by lwkai 2012-05-22*/
		if($order->products[$i]['roomattributes'][5]=='1'){

			$is_travel_companion = true;
			//$jiebantongyong = '&nbsp;<span style="color:#FF9900;font-weight: bold;">'.db_to_html('�����ͬ���ţ�').'</span>';
			
			//���ͬ�Σ�ƽ�������Ҹø����٣�
			$how_ipay[$i] = "";
			$adult_averages = $currencies->display_price(str_replace(',','',$order->products[$i]['adult_average']),$order->products[$i]['tax'], $order->products[$i]['qty']);
			$child_averages = $currencies->display_price(str_replace(',','',$order->products[$i]['child_average']),$order->products[$i]['tax'], $order->products[$i]['qty']);
			if($order->products[$i]['adult_average']>0){
				//$how_ipay[$i] .= '<br>'.ADULT_AVERAGE_PAY.$adult_averages;
			}
			if($order->products[$i]['child_average']>0){
				//$how_ipay[$i] .= '<br>'.CHILD_AVERAGE_PAY.$child_averages;
			}

			//ͳ����Щ����Ҫ�Ҹ���
			//˼·����PayerMeֵȡ�õڼ�������Ҫ�Ҹ��ͬʱ�ж��⼸�����Ǵ��˻���С��
			//����checkout_process.php
			$h=0;
			$i_pay[$i]=0;
			
			foreach($_SESSION as $key=>$val){
				if(strstr($key,'PayerMe')){
					if($_SESSION['PayerMe'.$h][$i]=='1'){
						//�Ҹ�
						if($_SESSION['guestchildage'.$h][$i] != ''){	//С��
							$i_pay[$i] += str_replace(',','',$order->products[$i]['child_average']);
						}else{	//����
							$i_pay[$i] += str_replace(',','',$order->products[$i]['adult_average']);
						}
					}																
					$h++;	
				}
				
			}
			//�Ҹ���
			//$how_ipay[$i] .= ('<br>�Ҹ���').$currencies->display_price($i_pay[$i],$order->products[$i]['tax'], $order->products[$i]['qty']);
			
			//print_r($how_ipay);
		}else{
			$i_pay[$i] += $order->products[$i]['final_price'];
		}
		/*  ������ͬ�δ������ */
	}
	if($is_travel_companion==true){
		 //�����ͬ�εĶ�������Ҫ������ܶ�
		$i_pay_total=0;
		for($pp=0; $pp<count($i_pay); $pp++){
			$i_pay_total += $i_pay[$pp]; 
		}
	}
		
// end 

//�����οͺͺ�����Ϣ start
$hidden_guest_info = true;
if($hidden_guest_info!=true){
	?>
	<tr>
	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
	</tr>

	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="infoBoxHeading"><div class="heading_bg"><?php echo TEXT_GUEST_INFO_FLIGHT_INFO; ?></div> <div class="head_note"><?php echo TEXT_FLIGHT_INFO_IF_AVAILABLE;?></div></td>
	</tr>

	</table></td>
	</tr>
	<tr>
	<td>
	<div class="infoBox_outer">
	<table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBox_new">
	<tr class="infoBoxContents_new">
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2" style="padding-bottom:10px;">

	<?php
	$jiebantongyou = false;
	$i_pay = array();
	$is_travel_companion = false;

	
	for ($i=0, $n=sizeof($order->products); $i<$n; $i++){

		//howard added travel companion
		$jiebantongyong="";
		if($order->products[$i]['roomattributes'][5]=='1'){
			$jiebantongyou = true;
			$jiebantongyong = '&nbsp;<span style="color:#FF9900;font-weight: bold;">'.db_to_html('�����ͬ���ţ�').'</span>';
		}
		
		
		
		// amit commented to remove child age ask
		$roomsinfo_string = trim($order->products[$i]['roomattributes'][3]);
		$ttl_rooms = get_total_room_from_str($roomsinfo_string);


		if($ttl_rooms>0){

			for($ir=0; $ir<$ttl_rooms; $ir++){
				//$totoal_child_room[$order->products[$i]['id']] = (int)$totoal_child_room[$order->products[$i]['id']] + tep_get_rooms_adults_childern($roomsinfo_string,$ir+1,'children');
				$chaild_adult_no_arr = tep_get_room_adult_child_persion_on_room_str($order->products[$i]['roomattributes'][3],$ir+1);
				$totoal_child_room[$order->products[$i]['id']] = (int)$totoal_child_room[$order->products[$i]['id']] + $chaild_adult_no_arr[1];

			}
		}else{
			$chaild_adult_no_arr = tep_get_room_adult_child_persion_on_room_str($order->products[$i]['roomattributes'][3],1);
			$totoal_child_room[$order->products[$i]['id']] = $chaild_adult_no_arr[1];
		}
		// amit commented to remove child age ask

		$class_pord_list = 'productListing-even';
		if($i%2!=0 ){
			$class_pord_list = 'productListing-odd';
		}
		echo '<tr class="'.$class_pord_list.'" >
					<td class="main" style="border-bottom:1px solid #B7E0F6; padding:10px;">
					'.'<table id="tour_list_'.$i.'" width="100%"><tr><td colspan="2">'.'<b class="bluetext_font">'.($i+1).' '.db_to_html($order->products[$i]['name']).'</b>'.$jiebantongyong.'
					</td>
					</tr>';

		//amit added to check helicopter tour
		if(tep_get_product_type_of_product_id((int)$order->products[$i]['id']) == 2){

			if($order->products[$i]['roomattributes'][2] != '')
			{
				$m=$order->products[$i]['roomattributes'][2];

				// amit commented to remove child age ask
				$tot_nos_of_child_in_tour = $m - (int)$totoal_child_room[$order->products[$i]['id']];
				/*echo 'm:'.$m;
				echo 'totoal_child_room:'.(int)$totoal_child_room[$order->products[$i]['id']];
				echo 'tot_nos_of_child_in_tour:'.$tot_nos_of_child_in_tour;*/
				// amit commented to remove child age ask


				for($h=0; $h<$m; $h++)
				{

					// amit commented to remove child age ask
					$needed_show_child_title = false;
					$default_show_adult_title = TXT_DIS_ENTRY_GUEST_ADULT;
					if( ($h >= $tot_nos_of_child_in_tour) && $tot_nos_of_child_in_tour > 0){
						$needed_show_child_title =  true;
						$default_show_adult_title = TXT_DIS_ENTRY_GUEST_CHILD;
					}
					// amit commented to remove child age ask
					if(($h%2)==0){
						echo '<tr>';
					}
					?>



					<td>
					<table width="100%" cellpadding="2" cellspacing="0"><tr><td class="main" width="20%" style="padding-left:30px; ">

					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<?php
					$guestname_title = sprintf(TEXT_INFO_GUEST_NAME,($h+1));
					$guestname_title_en = sprintf(db_to_html("�˿�%s����<b class=inputRequirement>Ӣ����</b>"),($h+1));

					//���ͬ��
					if((int)$order->products[$i]['roomattributes'][5]){
						$mail_name = sprintf(db_to_html("ƴ����%s��ע������"),$h);
						$guestname_title = sprintf(db_to_html('ƴ����%s������'),$h);
						$guestname_title_en = sprintf(db_to_html('ƴ����%s����<b class=inputRequirement>Ӣ����</b>'),$h);
						$readonly ='';
						$guestemail_onblur=' onBlur="check_and_get_guestname(&quot;GuestEmail'.$h.'_'.$i.'&quot;, &quot;guestname'.$h.'_'.$i.'&quot;)" ';
						if($h==0){
							$mail_name = db_to_html('�ҵ�ע������');
							$GuestEmail = 'GuestEmail'.$h.'['.$i.']';
							$$GuestEmail = $customer_email_address;
							$guestname_title = db_to_html('�˿�1������');
							$guestname_title_en = db_to_html('�˿�1�Ļ���<b class=inputRequirement>Ӣ����</b>');
							$readonly = ' readonly="true" ';
							$guestemail_onblur ='';
						}
						if($needed_show_child_title == true){
							$mail_name = sprintf(db_to_html("ƴ����%s��ע������"),$h);
							$guestname_title = db_to_html('��ͯ������');
							$guestname_title_en = db_to_html('��ͯ����<b class=inputRequirement>Ӣ����</b>');
						}
						//if($needed_show_child_title != true){
						?>
						<tr>
						<td align="right" valign="top" nowrap="nowrap">
						<?php echo db_to_html('�����ˣ�');?>&nbsp;
						</td>
						<td>
						<?php
						if($_SESSION['PayerMe'.$h][$i]=='1' || $h==0){
							$Payer_Me_Checked = true;
							$Payer_Me_Checked1 = false;
						}else{
							$Payer_Me_Checked = false;
							$Payer_Me_Checked1 = true;
						}
						echo tep_draw_radio_field('PayerMe'.$h.'['.$i.']', '1',$Payer_Me_Checked,' id="PayerMe'.$h.'_'.$i.'_A" onClick="determine_input_field(this,&quot;'.$h.'_'.$i.'&quot;)" ').db_to_html(' <label for="PayerMe'.$h.'_'.$i.'_A">�Ҹ�</label>');
						echo "&nbsp;";
						if($h>0){
							echo tep_draw_radio_field('PayerMe'.$h.'['.$i.']', '0',$Payer_Me_Checked1,' id="PayerMe'.$h.'_'.$i.'_A" onClick="determine_input_field(this,&quot;'.$h.'_'.$i.'&quot;)" ').db_to_html(' <label for="PayerMe'.$h.'_'.$i.'_B">�Ҳ�������</label>');
						}
						?>

						</td>
						</tr>

						<?php
						$guestemailstyle = '';
						if($needed_show_child_title == true){
							$guestemailstyle = 'display:none';
						}
						?>
						<tr style=" <?= $guestemailstyle?>">
						<td align="right" valign="top" nowrap="nowrap">
						<?php echo $mail_name?>&nbsp;
						</td>
						<td>
						<?php echo tep_draw_input_field('GuestEmail'.$h.'['.$i.']', $_SESSION['GuestEmail'.$h][$i],' id="GuestEmail'.$h.'_'.$i.''.'" class="required" autocomplete="off" onFocus="auto_list_customers_address(&quot;GuestEmail'.$h.'_'.$i.'&quot;,&quot;Layer'.$h.'_'.$i.'&quot;);" onkeyup="auto_list_customers_address(&quot;GuestEmail'.$h.'_'.$i.'&quot;,&quot;Layer'.$h.'_'.$i.'&quot;);" title="'.TEXT_PLEASE_INSERT_GUEST_EMAIL.'"'.$readonly.$guestemail_onblur);?>
						<span class="inputRequirement">*</span>
						<!--�����ʼ��б��-->
						<div style="position: absolute; width: auto; height: auto; z-index: 1; visibility: visible; margin-top: 0px; margin-left: 301px; display:none" class="meun_layer" id="Layer<?php echo $h.'_'.$i?>"></div>
						<!--�����ʼ��б��end-->
						</td>
						</tr>
						<?php
						//}
					}elseif(tep_not_null($_SESSION['GuestEmail'.$h][$i])){
						$_SESSION['GuestEmail'.$h][$i] = "";
					}
					//���ͬ��
					?>

					<?php
					// amit commented to remove child age ask
					if($needed_show_child_title == true){

						$dis_ext_clas_faild_for_wrong_chlidage = '';
						if(urldecode($HTTP_GET_VARS['wrgdate']) == tep_db_prepare_input($_SESSION['guestchildage'.$h][$i]) && isset($HTTP_GET_VARS['wrgdate'])){
							$dis_ext_clas_faild_for_wrong_chlidage = ' validation-failed';
						}
						?>
						<tr><td align="right" valign="top" nowrap="nowrap">
						<?php echo ENTRY_GUEST_CHILD_AGE;?>&nbsp;
						</td>
						<td>
						<?php echo tep_draw_input_field('guestchildage'.$h.'['.$i.']', tep_db_prepare_input($_SESSION['guestchildage'.$h][$i]), 'id="guestchildage'.$h.'['.$i.']" size="10" class="required validate-date-us'.$dis_ext_clas_faild_for_wrong_chlidage.'" title="'.TEXT_GUEST_ERROR_CHILD_BIRTH_DATE.'"'); ?>&nbsp;<span id="advice-required-guestchildage<?php echo $h.'['.$i.']'?>" class="validation-advice"><?php echo TEXT_GUEST_ERROR_CHILD_BIRTH_DATE;?></span>&nbsp;<span class="inputRequirement">*</span>
						</td></tr>
						<?php
					}
					// amit commented to remove child age ask

					?>

					<tr>
					<td align="right" nowrap="nowrap" width="1%"><?php echo $guestname_title;?>&nbsp;</td>
					<td><?php echo tep_draw_input_field('guestname'.$h.'['.$i.']', $_SESSION['guestname'.$h][$i], ' id="guestname'.$h.'_'.$i.'" class="required" title="'.TEXT_PLEASE_INSERT_GUEST_NAME.'"'); ?>&nbsp;<span class="inputRequirement">*</span></td>
					</tr>
					<tr>
					<td align="right" valign="top" nowrap="nowrap"><?php echo $guestname_title_en;?>&nbsp;</td>
					<td valign="top">
					<?php echo db_to_html('��')?>
					<?php echo tep_draw_input_field('GuestEngXing'.$h.'['.$i.']', $_SESSION['GuestEngXing'.$h][$i], ' id="GuestEngXing'.$h.'_'.$i.'" class="required" size="4" title="'.db_to_html('������').'" style="ime-mode: disabled;" '); ?>
					<?php echo db_to_html('��')?>
					<?php echo tep_draw_input_field('GuestEngName'.$h.'['.$i.']', $_SESSION['GuestEngName'.$h][$i], ' id="GuestEngName'.$h.'_'.$i.'" class="required" size="8" style="width:48px; ime-mode: disabled;" title="'.db_to_html('������').'"'); ?>&nbsp;<span class="inputRequirement">* </span><br />
					<span style="color:#6F6F6F"><?php echo db_to_html('��ȷ����������պ����뻤���ϵ�һ�¡�');?></span>
					</td>
					</tr>

					<tr>
					<td align="right" valign="top" nowrap="nowrap">
					<?php echo TEXT_INFO_GUEST_BODY_WEIGHT.($h+1).'):'.'&nbsp;'?>
					</td>
					<td>
					<?php echo  tep_draw_pull_down_menu('guestweighttype'.$h.'['.$i.']', $products_guestweight_array,  tep_db_prepare_input($_SESSION['guestweighttype'.$h][$i]), ' id="guestweighttype'.$h.'['.$i.']" style="width:65px;"') .' '. tep_draw_input_field('guestbodyweight'.$h.'['.$i.']', $_SESSION['guestbodyweight'.$h][$i], ' class="required" title="'.db_to_html('����������').'" id="guestbodyweight'.$h.'_'.$i.'"'); ?>&nbsp;<span class="inputRequirement">*</span>
					</td>

					</tr>
					</table>

					<?php //�Զ��ж��Ƿ�Ӳ���"�ɲ���"������ ?>
					<script type="text/javascript">
					var sobj = document.getElementById('PayerMe<?php echo $h.'_'.$i?>_B');
					if(sobj!=null){
						determine_input_field(sobj,"<?php echo $h.'_'.$i?>");
					}
								</script>
								<?php //�Զ��ж��Ƿ�Ӳ���"�ɲ���"������end?>
									
									</td></tr>
									
									</table>
									
									</td>
								<?php
								if(($h%2)!=0){
									echo '</tr>';
								}
				}// end of for($h=0; $h<$m; $h++)
			}
		}else{

			if($order->products[$i]['roomattributes'][2] != '')
			{
				$m=$order->products[$i]['roomattributes'][2];
				// amit commented to remove child age ask
				$tot_nos_of_child_in_tour = $m - (int)$totoal_child_room[$order->products[$i]['id']];
				/*echo 'm:'.$m;
				echo 'totoal_child_room:'.(int)$totoal_child_room[$order->products[$i]['id']];
				echo 'tot_nos_of_child_in_tour:'.$tot_nos_of_child_in_tour;*/
				// amit commented to remove child age ask


				for($h=0; $h<$m; $h++)
				{

					// amit commented to remove child age ask
					$needed_show_child_title = false;
					$default_show_adult_title = TXT_DIS_ENTRY_GUEST_ADULT;
					if( ($h >= $tot_nos_of_child_in_tour) && $tot_nos_of_child_in_tour > 0){
						$needed_show_child_title =  true;
						$default_show_adult_title = TXT_DIS_ENTRY_GUEST_CHILD;
					}
					// amit commented to remove child age ask

					if(($h%2)==0)
					echo '<tr>';
						?>

							<td style="padding-bottom:5px;">
							<table width="100%" cellpadding="2" cellspacing="0">
								<tr><td class="main">
								
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <?php
								  $guestname_title = sprintf(TEXT_INFO_GUEST_NAME,($h+1));
								  $guestname_title_en = sprintf(db_to_html("�˿�%s����<b class=inputRequirement>Ӣ����</b>"),($h+1));

								  //���ͬ��
								  if((int)$order->products[$i]['roomattributes'][5]){
								  	$mail_name = sprintf(db_to_html("ƴ����%s��ע������"),$h);
								  	$guestname_title = sprintf(db_to_html('ƴ����%s������'),$h);
								  	$guestname_title_en = sprintf(db_to_html('ƴ����%s����<b class=inputRequirement>Ӣ����</b>'),$h);
								  	$readonly ='';
								  	$guestemail_onblur=' onBlur="check_and_get_guestname(&quot;GuestEmail'.$h.'_'.$i.'&quot;, &quot;guestname'.$h.'_'.$i.'&quot;)" ';
								  	if($h==0){
								  		$mail_name = db_to_html('�ҵ�ע������');
								  		$GuestEmail = 'GuestEmail'.$h.'['.$i.']';
								  		$$GuestEmail = $customer_email_address;
								  		$guestname_title = db_to_html('�˿�1������');
								  		$guestname_title_en = db_to_html('�˿�1�Ļ���<b class=inputRequirement>Ӣ����</b>');
								  		$readonly = ' readonly="true" ';
								  		$guestemail_onblur ='';
								  	}
								  	if($needed_show_child_title == true){
								  		$mail_name = sprintf(db_to_html("ƴ����%s��ע������"),$h);
								  		$guestname_title = db_to_html('��ͯ������');
								  		$guestname_title_en = db_to_html('��ͯ����<b class=inputRequirement>Ӣ����</b>');
								  	}

								  	//if($needed_show_child_title != true){
								  ?>
										  <tr>
											<td align="right" valign="top" nowrap="nowrap">
											<?php echo db_to_html('�����ˣ�');?>&nbsp;									
											</td>
											<td>
											<?php
											if($_SESSION['PayerMe'.$h][$i]=='1' || $h==0){
												$Payer_Me_Checked = true;
												$Payer_Me_Checked1 = false;
											}else{
												$Payer_Me_Checked = false;
												$Payer_Me_Checked1 = true;
											}
											echo tep_draw_radio_field('PayerMe'.$h.'['.$i.']', '1',$Payer_Me_Checked,' id="PayerMe'.$h.'_'.$i.'_A" onClick="determine_input_field(this,&quot;'.$h.'_'.$i.'&quot;)" ').db_to_html(' <label for="PayerMe'.$h.'_'.$i.'_A">�Ҹ�</label>');
											echo "&nbsp;";
											if($h>0){
												echo tep_draw_radio_field('PayerMe'.$h.'['.$i.']', '0',$Payer_Me_Checked1,' id="PayerMe'.$h.'_'.$i.'_B" onClick="determine_input_field(this,&quot;'.$h.'_'.$i.'&quot;)" ').db_to_html(' <label for="PayerMe'.$h.'_'.$i.'_B">�Ҳ�������</label>');
											}
											?>
											
											</td>
										  </tr>
										  
										  <?php
										  $guestemailstyle = '';
										  if($needed_show_child_title == true){
										  	$guestemailstyle = 'display:none';
										  }
										  ?>
										  <tr style="<?= $guestemailstyle?>">
											<td align="right" valign="top" nowrap="nowrap">
											<?php echo $mail_name?>&nbsp;									
											</td>
											<td>
											<?php echo tep_draw_input_field('GuestEmail'.$h.'['.$i.']', $_SESSION['GuestEmail'.$h][$i],' id="GuestEmail'.$h.'_'.$i.''.'" class="required" autocomplete="off" onFocus="auto_list_customers_address(&quot;GuestEmail'.$h.'_'.$i.'&quot;,&quot;Layer'.$h.'_'.$i.'&quot;);" onkeyup="auto_list_customers_address(&quot;GuestEmail'.$h.'_'.$i.'&quot;,&quot;Layer'.$h.'_'.$i.'&quot;);" title="'.TEXT_PLEASE_INSERT_GUEST_EMAIL.'"'.$readonly.$guestemail_onblur);?>
											<span class="inputRequirement">*</span>
											<!--�����ʼ��б��-->
											<div style="position: absolute; width: auto; height: auto; z-index: 1; visibility: visible; margin-top: 0px; margin-left: 301px; display:none" class="meun_layer" id="Layer<?php echo $h.'_'.$i?>"></div>
											<!--�����ʼ��б��end-->
											</td>
										  </tr>
								  <?php
								  //}
								  }elseif(tep_not_null($_SESSION['GuestEmail'.$h][$i])){
								  	$_SESSION['GuestEmail'.$h][$i] = "";
								  }
								  //���ͬ��
								  ?>
								
								<?php										
								// amit commented to remove child age ask
								if($needed_show_child_title == true){
									$dis_ext_clas_faild_for_wrong_chlidage = '';
									if(urldecode($HTTP_GET_VARS['wrgdate']) == tep_db_prepare_input($_SESSION['guestchildage'.$h][$i]) && isset($HTTP_GET_VARS['wrgdate'])){
										$dis_ext_clas_faild_for_wrong_chlidage = ' validation-failed';
									}
								?>																					
								<tr><td align="right" valign="top" nowrap="nowrap">
								<?php echo ENTRY_GUEST_CHILD_AGE;?>&nbsp;
                                
								</td>
								<td>
								<?php echo tep_draw_input_field('guestchildage'.$h.'['.$i.']', tep_db_prepare_input($_SESSION['guestchildage'.$h][$i]), 'id="guestchildage'.$h.'['.$i.']" size="10" class="required validate-date-us'.$dis_ext_clas_faild_for_wrong_chlidage.'" title="'.TEXT_GUEST_ERROR_CHILD_BIRTH_DATE.'"'); ?>&nbsp;<span id="advice-required-guestchildage<?php echo $h.'['.$i.']'?>" class="validation-advice"><?php echo TEXT_GUEST_ERROR_CHILD_BIRTH_DATE;?></span>&nbsp;<span class="inputRequirement">*</span>
								</td></tr>
								<?php
								}
								// amit commented to remove child age ask

								?>
								  
								  <tr>
									<td align="right" nowrap="nowrap" width="1%"><?php echo $guestname_title;?>&nbsp;</td>
									<td><?php echo tep_draw_input_field('guestname'.$h.'['.$i.']', $_SESSION['guestname'.$h][$i], ' id="guestname'.$h.'_'.$i.'" class="required" title="'.TEXT_PLEASE_INSERT_GUEST_NAME.'"'); ?>&nbsp;<span class="inputRequirement">*</span></td>
								  </tr>
								  <tr>
									<td align="right" valign="top" nowrap="nowrap"><?php echo $guestname_title_en;?>&nbsp;</td>
									<td valign="top">
									<?php echo db_to_html('��')?>
									<?php echo tep_draw_input_field('GuestEngXing'.$h.'['.$i.']', $_SESSION['GuestEngXing'.$h][$i], ' id="GuestEngXing'.$h.'_'.$i.'" class="required" size="4" title="'.db_to_html('������').'" style="ime-mode: disabled;" '); ?>
									<?php echo db_to_html('��')?>
									<?php echo tep_draw_input_field('GuestEngName'.$h.'['.$i.']', $_SESSION['GuestEngName'.$h][$i], ' id="GuestEngName'.$h.'_'.$i.'" class="required" size="8" style="width:48px; ime-mode: disabled;" title="'.db_to_html('������').'"'); ?>&nbsp;<span class="inputRequirement">* </span><br />
									<span style="color:#6F6F6F"><?php echo db_to_html('��ȷ����������պ����뻤���ϵ�һ�¡�');?></span>
									</td>
								  </tr>
								  
								</table>

								<?php //�Զ��ж��Ƿ�Ӳ���"�ɲ���"������?>
								<script type="text/javascript">
								var sobj = document.getElementById('PayerMe<?php echo $h.'_'.$i?>_B');
								if(sobj!=null){
									determine_input_field(sobj,"<?php echo $h.'_'.$i?>");
								}
								</script>
								<?php //�Զ��ж��Ƿ�Ӳ���"�ɲ���"������end?>

								</td></tr>
								
							</table>
							</td>
							
						<?php
						if(($h%2)!=0)
						echo '</tr>';
				}// end of for($h=0; $h<$m; $h++)
			}

		}

		echo '<tr> <td colspan="2" class="main" style="border-top:1px dashed #6F6F6F; padding-top:8px;">';
					?>
					
					<?php
					$flight_info_display = 'none';
					$flight_info_link_text = '��ʾ';
					if(tep_not_null($airline_name[$i])){
						$flight_info_display = '';
						$flight_info_link_text = '����';
					}
					?>
					<div><b><?php echo TEXT_FLIGHT_INFO_IF_APPLICABLE;?></b> <a id="flight_info_link_<?php echo $i;?>" href="JavaScript:display_table('flight_info_link_<?php echo $i;?>', 'flight_info_<?php echo $i;?>');" style="text-decoration: underline;font-weight: bold;"><?php echo db_to_html($flight_info_link_text);?></a></div>
					<table border="0" width="100%" cellspacing="0" cellpadding="2" id="flight_info_<?php echo $i;?>" style="display:<?= $flight_info_display ?>">
					  <tr>
						<td class="main" width="20%"><?php echo TEXT_ARRIVAL_AIRLINE_NAME;?></td>
						<td width="30%"><?php echo tep_draw_input_field('airline_name['.$i.']', $airline_name[$i], ''); ?></td>
						<td class="main" width="20%"><?php echo TEXT_DEPARTURE_AIRLINE_NAME; ?></td>
						<td width="30%"><?php echo tep_draw_input_field('airline_name_departure['.$i.']', $airline_name_departure[$i], ''); ?></td>
					  </tr>
					  <tr>
						<td class="main"><?php echo TEXT_ARRIVAL_FLIGHT_NUMBER; ?></td>
						<td><?php echo tep_draw_input_field('flight_no['.$i.']', $flight_no[$i], ''); ?></td>
						<td class="main"><?php echo TEXT_DEPARTURE_FLIGHT_NUMBER; ?></td>
						<td><?php echo tep_draw_input_field('flight_no_departure['.$i.']', $flight_no_departure[$i], ''); ?></td>
					  </tr>
					  <tr>
						<td class="main"><?php echo TEXT_ARRIVAL_AIRPORT_NAME; ?></td>
						<td><?php echo tep_draw_input_field('airport_name['.$i.']', $airport_name[$i], ''); ?></td>
						<td class="main"><?php echo TEXT_DEPARTURE_AIRPORT_NAME; ?></td>
						<td><?php echo tep_draw_input_field('airport_name_departure['.$i.']', $airport_name_departure[$i], ''); ?></td>
					  </tr>
					  <tr>
						<td class="main"><?php echo TEXT_ARRIVAL_DATE;?></td>
						<td>
						<?php echo tep_draw_input_field('arrival_date'.$i, $arrival_date, ' onclick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" class="text_time'); ?>
						</td>
						<td class="main"><?php echo TEXT_DEPARTURE_DATE; ?></td>
						<td>
						<?php echo tep_draw_input_field('departure_date'.$i, $departure_date, ' onclick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" class="text_time'); ?>
						</td>
					  </tr>
					  <tr>
						<td class="main"><?php echo TEXT_ARRIVAL_TIME;?><br />(HH:MM) e.g. 15:30 pm</td>
						<td valign="top"><?php
						//, 'onBlur="return IsValidTimeMilitry(this.value)";'
						 echo tep_draw_input_field('arrival_time['.$i.']', $arrival_time[$i]); ?></td>
						<td class="main"><?php echo TEXT_DEPARTURE_TIME;?><br />(HH:MM) e.g. 09:30 am</td>
						<td valign="top"><?php echo tep_draw_input_field('departure_time['.$i.']', $departure_time[$i]); ?></td>
					  </tr>
					</table>
					<?php
					//echo '</td></tr> <tr> <td  class="main"><hr style="color:#108BCE;" size="1" /> </td></tr></table> </td></tr>';
					echo '</td></tr></table> </td></tr>';
	}
	
	
				?>			    
            </table>
			 
			 </td></tr>
			 <tr><td style="padding-left:10px; padding-right:10px; padding-bottom:10px;">
			 <table border="0" cellspacing="0" cellpadding="2">
						<tr><td colspan="2" class="main"></td></tr>
						<tr><td colspan="2" class="main"><b><?php echo str_replace(':','&nbsp;&nbsp;',TEXT_EMERGENCY_CONTACT_NUM);?></b><?php echo TEXT_EMERGENCY_CASE_AVALILABLE;?></td></tr>
						<tr><td width="84" class="main" align="right"><?php echo TEXT_CELL_NUMBER;?></td><td align="left"><?php echo tep_draw_input_field('customers_cellphone', tep_customers_cellphone($customer_id), ' style="ime-mode: disabled;" '); ?></td></tr>
			 </table>	
			</td>
          </tr>
        </table>
		</div>
		</td>
      </tr>	 
	  
<?php
}
//�����οͺͺ�����Ϣ end
?>


	  <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
      </tr>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
	table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
  
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
	table_image_border_top(false, false, TABLE_HEADING_PAYMENT_METHOD);
}else{
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="infoBoxHeading blue"><div class="heading_bg"><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></div></td>
          </tr>
        </table></td>
      </tr><!--</table>-->
      
<?php
}
// BOF: Lango Added for template MOD
?>
      <tr>
        <td>
		<div class="infoBox_outer">
		<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox_new">
          <tr class="infoBoxContents_new">
            <td>
			
<?php
$selection = $payment_modules->selection(array_flip($products_id_array));
$customer_credit_balance = tep_get_customer_credits_balance((int)$customer_id);

if($customer_credit_balance >= $order->info['total']){
	if(!isset($customer_apply_credit_bal)){ $customer_apply_credit_bal =1; }
	if(!isset($customer_apply_credit_bal) || $customer_apply_credit_bal == 1){
		if(!isset($payment) || !tep_not_null($payment)){
			$payment = "T4FCredit";
		}
	}
	$selection[] = array('id'=> 'T4FCredit', 'module'=> NEW_PAYMENT_METHOD_T4F_CREDIT);
}elseif($payment == "T4FCredit"){
	$payment = "paypal_nvp_samples";
}
//amit added to default selection start
if(!isset($payment)){ //���û��Ĭ�ϵ�ѡ�и��ʽ����Ĭ��ѡ�����ÿ�(��Ԫ)
	$payment = "paypal_nvp_samples";
}
//amit added to default selection end


?>
			<div class="cont pay">
				<div id="payment_list_table" class="payLeft">
				<ul>
				
<?php 
  //���ʽ�б� start
  $radio_buttons = 0;
  $show_all_pay_module = true;
  for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
  	// �����ǰ��������һ���ؼ۲�Ʒ�������Ź���Ʒ����֧����ʽֻ��ʾ ֧���� �� �й�����ת�� by lwkai 2012-09-03 add ,howard added �������������
  	if (($selection[$i]['id']!='alipay_direct_pay' && $selection[$i]['id']!='transfer' && $selection[$i]['id']!='netpay' && $selection[$i]['id'] != 'cashdeposit') && $is_special==true) {
  		//continue;
  	} 
  	if ($selection[$i]['id'] == 'cashdeposit'  && $order->info['total'] < 3000 ) {
		continue;
	}
  	// lwkai add end
  	if($selection[$i]['id']=="authorizenet" || $selection[$i]['id']=="paypal" || $show_all_pay_module == true){
		$margin_top = $i*40;
		

?>
              <li id="div_pay_list_<?= $selection[$i]['id']?>">
			  <label>
			  <?php 
			  $_checkd = false;
			  if($payment==$selection[$i]['id']){ $_checkd = true; }
			  echo tep_draw_radio_field('payment', $selection[$i]['id'],$_checkd,' id="payment_'.$selection[$i]['id'].'" ');
			  ?>
				<span class="font_size14"><?php echo $selection[$i]['module']; ?></span>
				</label>
				</li>
<?php
    $radio_buttons++;
  	}
  }
  //���ʽ�б� end
?>
      			
				</ul>
				</div>
				<div id="payment_list_content" class="payRight">
				<?php 
				//���ʽ�ұ���Ϣ�� start
				$show_all_expansion = true; //��ʾ�����ұߵ�����
				for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
					// �����ǰ��������һ���ؼ۲�Ʒ�������Ź���Ʒ����֧����ʽֻ��ʾ ֧���� �� �й�����ת�� by lwkai 2012-09-03 add ,howard added �������������,lwkai added ����ܽ�����3000����ʾ��������ת��
				  	if (($selection[$i]['id']!='alipay_direct_pay' && $selection[$i]['id']!='transfer' && $selection[$i]['id']!='netpay' && $selection[$i]['id'] != 'cashdeposit') && $is_special==true) {
				  		//continue;	//����������
				  	}
				  	// �������������ת��,�����ܽ����ڵ���3000 ����ʾ,������ʾ
				  	if ($selection[$i]['id'] == 'cashdeposit'  && $order->info['total'] < 3000 ) {
				  		continue;
				  	}
				  	// lwkai add end
					if (isset($selection[$i]['error'])) {
				?>
								  <div><?php echo $selection[$i]['error']; ?></div>
				<?php
					} elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields']) || $show_all_expansion == true) {
				?>
								  <div id="Expansion_<?php echo $selection[$i]['id']?>">
									<div class="tit"><h2 class="font_bold font_size14"><?php echo $selection[$i]['module'];?></h2><span class="font_bold color_orange"><?php echo db_to_html('����ѡ����').$selection[$i]['module'].db_to_html('��ʽ�����������֧������')?></span></div>
									<div class="cont">
									<table border="0" cellspacing="0" cellpadding="2">
									<?php	
									if($selection[$i]['id']=='authorizenet' || $selection[$i]['id']=='cc_cvc'){
									?>
									<tr><td colspan="4" class="font_black"><span class="sp1"><b><?php echo TEXT_NOTES_HEADING_DIS;?></b> </span><?php echo TEXT_NOTES_HEADING_HOLDER_CC_NOTE;?></td></tr>
									 <tr><td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td></tr>
									<?php
									}
									?>
				<?php
					  for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
				?>
									  <tr>
										<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
										<td class="main" height="25px;" align="right" nowrap="nowrap"><?php echo $selection[$i]['fields'][$j]['title']; ?>&nbsp;</td>
										<td class="main"><?php 
										if ($_SERVER['SERVER_PORT'] == 443) {
											echo preg_replace('/http:/i','https:',$selection[$i]['fields'][$j]['field']);
										} else {
											echo $selection[$i]['fields'][$j]['field'];
										} ?></td>
										<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
									  </tr>
				<?php
					  }
				?>
									</table>
									</div>
									<div class="pay2_warp">
								  <?php //��ܰ��ʾ��start
								  if(isset($selection[$i]['warm_tips'])){
								  	if ($_SERVER['SERVER_PORT'] == 443) {
								  		echo preg_replace('/http:/i','https:',$selection[$i]['warm_tips']);
								  	} else {
								  		echo $selection[$i]['warm_tips'];
								  	}
								  }
								  //��ܰ��ʾ��end?>
									</div>
								  </div>
				<?php
					}
				}
				//���ʽ�ұ���Ϣ�� end
				?>
				</div>
                <div class="clear"></div>
			</div>
			
<script type="text/javascript"><!--
jQuery(document).ready(function() {




    jQuery('#payment_list_table > ul').children().click(function(){
			
			jQuery(this).addClass('cur').siblings().removeClass('cur'); //    ���õ����LI��classΪcur ȥ������LI��cur��ʽ
			jQuery(this).find('input[type=radio]').attr('checked','true');//   ���û�δ�㵽input radio ����Ӧ���� ����л�����ǰ�����ѡ��ť��ѡ�е�����
			var index = jQuery('#payment_list_table > ul').children().index(this);//    ȡ�õ�ǰLI������ 
			jQuery('#payment_list_content').children().eq(index).show().siblings().hide(); //    ��li����������ʾ��Ӧ���ұ�����
	});
	/*    ���PHP�н���Ĭ��չʾ���� ��ע�͵�������� PHP�� ���LI ���� ����class = cur ��Ϊ��ǰչ������ұ����Ӧȥ��display:none ����      */
	jQuery('#payment_list_table >ul').children().eq(0).click().find('input').attr('checked','true');

});

<?php
for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
	if(isset($selection[$i]['fields']) && is_array($selection[$i]['fields']) && !isset($selection[$i]['error']) || $show_all_expansion == true){
		if ( $selection[$i]['id'] != $payment ) {
			echo 'if(document.getElementById("Expansion_'.$selection[$i]['id'].'")!= null){ document.getElementById("Expansion_'.$selection[$i]['id'].'").style.display="none";}'."\n";
		}
	}
}
?>

function display_cxpansion_tr(id){
	<?php
	for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
		echo 'if(document.getElementById("Expansion_'.$selection[$i]['id'].'")!= null){ document.getElementById("Expansion_'.$selection[$i]['id'].'").style.display="none";}'."\n";
	}
	?>

	var id = document.getElementById(id);
	if(id!=null){
		id.style.display = "";
	}
}

//--></script>

</td>
</tr>
</table>
</div>
</td>
</tr>

<tr>
<td class="separator"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
</tr>


<!--ͨ�ŵ�ַ-->
<?php /* //ͨ�ŵ�ַ?>
<tr>
<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr>
<td class="infoBoxHeading"><div class="heading_bg"><?php echo TABLE_HEADING_CONTACT_ADDRESS; ?></div> <div class="head_note" style="color:#f68711;"><?php //echo TABLE_HEADING_BILLING_ADDRESS_EXP; ?></div></td>
</tr>
</table>
</td>
</tr>

<tr>
<td>
<div id="response_ship_div">
<?php

$shipto = ((int)$shipto) ? $shipto : $customer_default_ship_address_id;

$check_address_blank_query = tep_db_query("select a.entry_firstname as firstname, a.entry_lastname as lastname, a.entry_company as company, a.entry_street_address as street_address, a.entry_suburb as suburb, a.entry_city as city, a.entry_postcode as postcode, a.entry_state as state, a.entry_zone_id as zone_id, a.entry_country_id as country_id, c.customers_telephone, c.customers_fax, c.customers_cellphone, c.customers_mobile_phone from " . TABLE_ADDRESS_BOOK . " a, ". TABLE_CUSTOMERS ." c where a.customers_id=c.customers_id and a.customers_id = '" . (int)$customer_id . "' and a.address_book_id = '" . (int)$shipto . "'");
$row_check_address_blank = tep_db_fetch_array($check_address_blank_query);


if($row_check_address_blank['street_address']=='' && $row_check_address_blank['city']==''){
	$style_show_address_div = ' style="display:none;"';
	$style_show_edit_address_div = '';
}else{
	$style_show_address_div = '';
	$style_show_edit_address_div = ' style="display:none;"';
}
$osCsid_string = '';
if(tep_not_null($_GET['osCsid'])){
	$osCsid_string = '&osCsid='.(string)$_GET['osCsid'];
}
?>

<div id="show_address_div" <?php echo $style_show_address_div; ?>>
<div class="infoBox_outer">
<table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBox_new">
<tr class="infoBoxContents_new">
<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr>
<td colspan="4"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
</tr>
<tr>
<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
<td class="main" colspan="3"><span class="sp1"><b><?php echo TEXT_NOTES_HEADING_DIS;?> </b></span><?php echo TEXT_NOTES_HEADING_BILLING_EDIT_INFORMATION;?></td>
</tr>
<tr>
<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
<td align="left" width="50%" valign="top"><table border="0" cellspacing="0" cellpadding="2">
<tr>

<td class="main" align="center" valign="top"><b><?php //echo TITLE_BILLING_ADDRESS; ?></b><?php //echo tep_image('image/'. 'arrow_south_east.gif'); ?></td>

<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
<td class="main" valign="top">
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top" nowrap="nowrap"><b><?php echo db_to_html(tep_address_label($customer_id, $shipto, true, ' ', '<br />'));?></b></td>
<td valign="top" style="padding-left:50px;" nowrap="nowrap">
<b>
<?php
//amit added shot telpphone number start
if($row_check_address_blank['customers_telephone'] != ''){
	echo '<br />'.TEXT_BILLING_INFO_TELEPHONE.' '.db_to_html($row_check_address_blank['customers_telephone']);
}
if($row_check_address_blank['customers_mobile_phone'] != ''){
	echo '<br />'.TEXT_BILLING_INFO_MOBILE.' '.db_to_html($row_check_address_blank['customers_mobile_phone']);
}
if($row_check_address_blank['customers_fax'] != ''){
	echo '<br />'.ENTRY_FAX_NUMBER.' '.db_to_html($row_check_address_blank['customers_fax']);
}
//amit added show telephone number end
?></b>

</td>
</tr>
</table>



</td>

<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
</tr>
</table></td>
<td align="right" class="main" width="50%" valign="top">
<?php echo TEXT_SELECTED_BILLING_DESTINATION; ?><br /><br />
<?php echo tep_template_image_button('button_edit_information.gif', IMAGE_BUTTON_CHANGE_ADDRESS,' onclick="show_edit_adderss()" style="cursor:pointer;"'); // onclick="toggel_div(\'address_edit_div\');" ?>					</td>
<td align="right" class="main" width="1%" valign="top"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
</tr>
<tr>
<td colspan="4"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
</tr>
</table></td>
</tr>
</table>
</div>
</div>

<div id="show_edit_address_div" <?php echo $style_show_edit_address_div; ?>>
<div class="infoBox_outer">
<table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBox_new"><tr class="infoBoxContents_new"><td>
<?php require(DIR_FS_MODULES . 'edit_ship_address.php');?>
</td></tr></table>
</div>
</div>
</div>
</td>
</tr>
<?php //ͨ�ŵ�ַend */?>
<!--ͨ�ŵ�ַend-->


<tr>
<td class="separator"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
</tr>
<?php ob_start();?>
<tr>
		<td class="infoBoxHeading blue">
			  <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-weight:normal">
              <tr><td width="80%">��·����</td>
              <td width="10%" align="center">��������</td>
              <td width="10%" align="center">�۸�</td>
              </tr>
              </table>
		</td>	
	  </tr>
      <tr>
			<td>
			<table cellpadding="0" cellspacing="1" bgcolor="#A2CBF4" border="0" width="100%">
            <?php
			$any_out_of_stock = 0;
			$cart->restore_contents();
			$products = $cart->get_products();
			for($i=0;$i < count($products); $i ++) {   ?>
            <tr bgcolor="#ffffff">
            	<td width="80%" height="37" style="padding-left:9px;"><?php echo $i+1 ?>.<?php echo $products[$i]['name'] . '<br/>' ?><?php
										if (is_array($order->products[$i]['attributes']) == true) { 
											foreach ($order->products[$i]['attributes'] as $key) {
												// ��Ϊ0 ����ʾ
												if ((int)$key['price'] > 0) {
													echo $key['option'] . '��' .$key['value'] . '&nbsp;' . $key['prefix'] . '&nbsp;' . $currencies->display_price($key['price'],$order->products[$i]['tax']) . '<br/>';
												}
											}
										}
										echo format_out_roomattributes_1($order->products[$i]['roomattributes'][1],(int)$order->products[$i]['roomattributes'][3]) . '<br/>';
										echo '�����ܼƣ�' . $currencies->format($order->products[$i]['roomattributes'][0]);?></td>
                <td width="10%" align="center"><?php echo $products[$i]['dateattributes'][0]?></td>
                <td width="10%" align="center" style="color:#FF6600;font-weight:bold;"><?php echo $currencies->format($products[$i]['roomattributes'][0]) ?></td>
            </tr>
            <?php 
				
			}
			?>
            <tr><td colspan="3" bgcolor="#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr><td style="line-height:25px;padding-left:9px;padding-bottom:10px;">
            <ul class="af_payment_list" style="margin-top:10px;">
            <li><input type="radio" id="af_hasNone"  name="afPayment" checked="checked" /><label for="af_hasNone">�������Ż��ۿ�</label></li>
            <?php 
			//�Ż�ȯ��ģ�飬�ڽ��ͬ��״̬�²�����
			//�����Ź��г̵�״̬Ҳ������
			//����������Ա����ݰ�����µ�ʱҲ������
			if($jiebantongyou==false && $have_group_buy==false && !(int)$Admin->login_id && !(int)$Admin->parent_orders_id){
				$ot_coupon = $order_total_modules->credit_selection();//ICW ADDED FOR CREDIT CLASS SYSTEM
				if(tep_not_null($ot_coupon)){
					//echo $ot_coupon;
					echo '<li><input type="radio" id="af_useTiket" name="afPayment" /><label for="af_useTiket">ʹ���ۿ�ȯ/�Ż���һ�:</label><div class="promocodeWrap" style="display:none;">�����������ۿ�ȯ/�Ż���';
					echo tep_draw_input_field('gv_redeem_code');
					echo '<button type="button" id="validation_promocode">ȷ�϶һ�</button></div></li>';
				}
			}
			
			if ((USE_POINTS_SYSTEM == 'true') && (USE_REDEEM_SYSTEM == 'true') && $jiebantongyou!=true && tep_get_shopping_points($_SESSION['customer_id']) > 0 ) {
			?>
            <li><input type="radio" id="af_usePoint" name="afPayment" <?php if($Admin->parent_orders_id){?> disabled="disabled" title="�����ж���������²�Ʒʱ�������" <?php }?> /><label for="af_usePoint">ʹ�û��ֶһ�(����Ż�100%)��</label><div style="display:none;color:#09F;"><?php 
			echo db_to_html(ob_get_clean());
			points_selection();
			ob_start();
	/*if (tep_not_null(USE_REFERRAL_SYSTEM) && (tep_count_customer_orders() == 0)) {
	echo referral_input();
	}*/
	?></div></li></ul><?php }?>
    <script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".af_payment_list > li").find("input[type='radio']").change(function(){
			if(jQuery(this).is(":checked")){
				jQuery(this).parent().find("div").show();
				jQuery(this).parent().siblings("li").find("div").hide();
				jQuery(this).parent().siblings("li").find("div").find('input').val("");
			}
		});
		jQuery(".promocodeWrap > button").click(function(){
			var pval = jQuery("form#checkout_payment input[name='gv_redeem_code']").val();
			if(pval == ""){
				alert("�������ۿ�ȯ/�Ż���");
			}else{
				jQuery.post(url_ssl("<?= tep_href_link_noseo('checkout_payment.php');?>"),{ajax : 'true' , action : 'checkCouponCode', gv_redeem_code : pval },function(data){
					if(data == 'true'){
						jQuery('#validation_promocode').html('��ȯ����');
						return true;
					}else{
						jQuery('#validation_promocode').html('ȷ�϶һ�');
						jQuery(".pDialogLayer").show();
						jQuery(".pDialogPanel").show();	
						jQuery("#error_string").html('<dt>'+ data +'</dt>');	
						
					}
				},"text");
			}
		});
		function setDialog(){
			var winW = jQuery(document).width();
			var winH = jQuery(document).height();
			jQuery(".pDialogLayer").css({"width":winW,"height":winH});
		}
		setDialog();
		jQuery(".pDialogClose").click(function(){
			jQuery(".pDialogLayer").hide();
			jQuery(".pDialogPanel").hide();
		});
		
		jQuery('.payment_msg a').hover(function(){
			jQuery('.pmsg_tips').show();
		},function(){
			jQuery('.pmsg_tips').hide();
		});
	});
	</script>
	<div class="pDialogLayer"></div>
    <div class="pDialogPanel">
    	<a href="javascript:void(0);" class="pDialogClose" title="�ر�"><span>�ر�</span></a>
        <div class="pDialogMsg">
        	<h3>���ź������Ķһ�ʧ�ܣ�</h3>
            <dl id="error_string">
            	<dt>�����Ƿ�������²��ܶһ��������</dt>
                <dd>1���ۿ�ȯ/�Ż���(Coupon Code)��д������˶Ժ����</dd>
                <dd>2�����ǵ�һ�����ѣ��һ�����200�����£�</dd>
                <dd>3���������С��700�����ǲ���ʹ���Ż���(Coupon Code)���д��۵ģ�</dd>
                <dd>4��������ȫ�ǲ����ظ��ŻݵĲ�Ʒ�������ؼۡ��Ź����Ƶꡢǩ֤�ȣ�</dd>
                <dd>5�������Ż��ۿ��޷�ʵ�ֵ�״��������ϵ�ͷ���</dd>
            </dl>
        </div>
        <div class="pDialogContact">
        	<p>�����ȷ����������������⣬����ϵ���ǵĿͻ�����</p>
            <dl>
            	<dt>��ѵ绰</dt>
                <dd>������<span>1-888-887-2816</span><span>1-626-898-7800</span>
                <dd>�й���<span>4006-333-926</span>���䣺<span>service@usitrip.com</span></dd>
            </dl>
        </div>
    </div>
            </td><td align="right" style="line-height:25px;padding-right:9px;vertical-align:text-top;padding-top:10px;">
           ����ܼƣ�<span title="��<?= (int)get_points_toadd($order)?>����"><?php echo $currencies->format($order->info['total'])?></span><!--�ۿ�ȯ�Żݣ�-$20�����ֶһ���-$5--><br/>
		   <?php
		   	if($is_travel_companion==true){
				echo '<span style="font-size:18px;font-weight:bold"><b>����Ҫ֧����<span style="color:#F60;font-size:24px;" id="total_prace">'.$currencies->display_price($i_pay_total,0,1).'</span>';
			} else { ?>
		   	<span style="font-size:18px;font-weight:bold">����Ҫ֧��:<span style="color:#F60;font-size:24px;" id="total_prace"><?php echo $currencies->format($order->info['total'])?></span>
		   <?php } ?></span>
            </td></tr>
            <tr>
            	<td colspan="3">
                	<div class="payment_msg">
                        <a href="javascript:void(0);">��ܰ��ʾ</a>
                        <div class="pmsg_tips" style="display:none;">
                        	<i></i>
                        	<p>1.��������״����ѣ���ѡ����ֶһ�����ֻ��ʹ��200���ϵĻ��ֲ��֣��´����������κ����ơ�</p>
                            <p>2.700�������µĶ����������Ż���(Coupon Code)���ۣ��ۿ�ȯ�޴����ơ�</p>
                            <p>3.�������������ؼۡ��Ź��Ȳ����ظ������Żݻ�Ĳ�Ʒ����ò�Ʒ��Ӧ�������Ż��ۿ�ˡ�����ṩ��</p>
                            <p>4.�������������˵Ļ�Ա�������������Ż��������Լ����ѡ�</p>
                            <p>5.�����Ż��ۿ۽���Զ���ʵ��״��Ϊ׼�����ķ��������������Ȩ�档</p>
                        </div>
                    </div>
                </td>
            </tr>
            </table>
            </td></tr>
            </table>
	</td>
	</tr>
    <?php echo db_to_html(ob_get_clean());?>
    <tr><td>
<?php 
/*$any_out_of_stock = 0;
$cart->restore_contents();
$products = $cart->get_products();	*/
//var_dump($products);
?>
</td></tr>
<?php
//����
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
	table_image_border_top(false, false, TABLE_HEADING_COMMENTS);
}else{
	?>
	<tr style="display:none">
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="infoBoxHeading"><div class="heading_bg"><?php echo TABLE_HEADING_COMMENTS; ?></div></td>
	</tr>
	</table></td>
	</tr>
	<?php
}
// BOF: Lango Added for template MOD
?>
<tr style="display:none">
<td>
<div class="infoBox_outer">
<table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBox_new">
<tr class="infoBoxContents_new">
<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php /*
<tr>
<td>
<?php echo HEADING_ORDER_COMMENTS_NOTES?>
</td>
</tr>
*/?>
<tr>
<td>
<?php
/*if(!tep_not_null($comments)){
	//$comments = db_to_html('�������г�������Ҫ��������ڴ����ԣ��Ա����Ǿ������š�');
}

if (html_to_db($comments) == '�������г�������Ҫ��������ڴ����ԣ��Ա����Ǿ������š�'){
	$default_message = '';
	unset($comments);
} else {
	$default_message = $comments;	
}


$default_message = str_replace('�������г�������Ҫ��������ڴ����ԣ��Ա����Ǿ������š�','',html_to_db($comments));
unset($comments);*/
#echo tep_draw_textarea_field('comments', 'virtual', '60', '5' ,'','style="width: 920px;" class="textarea_bg"');
echo tep_draw_textarea_field('comments', 'virtual', '60', '5' ,$default_message,'style="width: 920px;" class="textarea_bg"');
?>
</td>
</tr>
</table></td>
</tr>
</table>
</div>
</td>
</tr>
<?php
//���� end
?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
	table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>


<?php
//�Ż�ȯ��ģ�飬�ڽ��ͬ��״̬�²�����
//�����Ź��г̵�״̬Ҳ������
/*if($jiebantongyou==false && $have_group_buy==false){
	$ot_coupon = $order_total_modules->credit_selection();//ICW ADDED FOR CREDIT CLASS SYSTEM
	echo '
	<tr>
	<td class="separator">'.tep_draw_separator('pixel_trans.gif', '100%', '20').'</td>
	</tr>';

	if(tep_not_null($ot_coupon)){
		echo $ot_coupon;
	}
}*/
?>



<!-- Points/Rewards Module V2.1rc2a Redeemption box bof -->
<?php
//���ֶһ�
/*
if ((USE_POINTS_SYSTEM == 'true') && (USE_REDEEM_SYSTEM == 'true') && $jiebantongyou!=true) {
	?>
	<tr>
	<td class="separator"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="infoBoxHeading"><div class="heading_bg"><?php echo db_to_html('���ֶһ�'); ?></div></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td>
	<div class="infoBox_outer">
	<table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBox_new">
	<tr class="infoBoxContents_new">
	<td>
	<table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr><td>&nbsp;</td></tr>
	<?php echo points_selection();
	/ *if (tep_not_null(USE_REFERRAL_SYSTEM) && (tep_count_customer_orders() == 0)) {
	echo referral_input();
	}* /
	?>
	<tr><td>&nbsp;</td></tr>
	</table>
	</td>
	</tr>
	</table>
	</div>
	</td>
	</tr>

	<?php
}
*/
?>
<!-- Points/Rewards Module V2.1rc2a Redeemption box eof -->
<tr>
<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
</tr>
<?php //-- Credit Issued - Start --?>
<?php

if($customer_credit_balance > 0){
	if(MODULE_EASY_DISCOUNT_STATUS=='true'){
		// BOF: Lango Added for template MOD
		if (MAIN_TABLE_BORDER == 'yes'){
			table_image_border_top(false, false, MODULE_EASY_DISCOUNT_CREDIT_TITLE);
		}else{
			?>
			<tr>
			<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
			<tr>
			<td class="infoBoxHeading"><div class="heading_bg"><?php echo MODULE_EASY_DISCOUNT_CREDIT_TITLE;?></div></td>
			</tr>
			</table></td>
			</tr>
			<?php
		}
		?>
		<tr>
		<td><table width="100%" cellpadding="0" cellspacing="0" class="infoBox_outer">
		<tr><td>
		<table border="0" width="100%" cellspacing="4" cellpadding="4" class="infoBox_new">
		<tr>
		<td width="10">&nbsp;</td>
		<td class="main"><?php echo TXT_UR_CREDIT_BAL; ?><b>$<?php echo number_format($customer_credit_balance, 2); ?></b></td>
		</tr>
		<tr>
		<td width="10">&nbsp;</td>
		<td class="main"><?php //echo TEXT_GIFT_CERTIFICATE_CODE." ".(($gc_code!="")?$gc_code.tep_draw_hidden_field("gc_code", "", "id='gc_code'"):tep_draw_input_field("gc_code", "", "id='gc_code'".$disable_discount_fields, "text", false));
		echo CHECK_APPLY_CREDITS.'&nbsp;&nbsp;';
		switch ($customer_apply_credit_bal) {
			case '1': $is_credit_yes = true; $is_credit_no = false; break;
			case '0':
			default: $is_credit_yes = false; $is_credit_no = true;
		}
		echo tep_draw_radio_field('customer_apply_credit_bal', '1',$is_credit_yes, 'onclick="submitFunctionCredits(this.value);"') . '&nbsp;&nbsp;' . 'Yes' . '&nbsp;&nbsp;' . tep_draw_radio_field('customer_apply_credit_bal', '0',$is_credit_no,'class="validate-one-required" onclick="submitFunctionCredits(this.value);"') . '&nbsp;&nbsp;' . 'No';
		//echo tep_draw_hidden_field('customer_apply_credit_bal', 0);
		echo '<div id="show_credit_apply_inputbox" '.(isset($customer_apply_credit_bal) && $customer_apply_credit_bal > 0 ? '' : 'style="display:none;"' ).'>'.ENTRY_CREDIT_APPLY_AMT.' &nbsp; &nbsp; '.tep_draw_hidden_field('customer_credit_balance_limit', $customer_credit_balance).tep_draw_input_field('customer_apply_credit_amt', number_format($customer_credit_balance, 2, '.', ''), ' onchange="submitFunctionCredits(1);" class="validate-number validate-creditamt"').'</div>';
		?></td>
		</tr>
		</table>
		</td></tr>
		</table>
		</td>
		</tr>
		<?php }
}
?>
<?php //-- Credit Issued - End --?>

<tr>

<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
</tr>


<tr>
<td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
<tr class="infoBoxContents">
<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr>
<td width="30"><?php echo tep_draw_separator('pixel_trans.gif', '30', '1'); ?></td>
<!--
<td class="main"><?php echo '<b>'.TITLE_CONTINUE_CHECKOUT_PROCEDURE . TEXT_CONTINUE_CHECKOUT_PROCEDURE . '</b><br />'. TEXT_INFO_PROTECT; ?></td>
-->
<td class="main subbtn" align="right"><input type="submit" value="<?php echo db_to_html('ȥ֧��');?>" id="paynextBtn" /><?php #lwkaiRem echo tep_template_image_submit('button_continue_checkout.gif', IMAGE_BUTTON_CONTINUE); ?>
<br /><span><label for="agreeUstrip"><input type="checkbox" name="agreeUstrip" id="agreeUstrip" style="width:auto;height:auto;line-height:auto;vertical-align:middle;" /><?php echo db_to_html("���Ķ���ͬ��<a href='" . tep_href_link('order_agreement.php','','NONSSL',false) . "' target=\"_blank\">������Э�顷</a>");?></label></span>
<script type="text/javascript">
jQuery(document).ready(function(){
	var agreeIpt = jQuery("input#agreeUstrip");
	var paynextBtn = jQuery("#paynextBtn");
	agreeIpt.bind('click',function(){
	if(agreeIpt.is(":checked")){
			paynextBtn.removeAttr("disabled");
			agreeIpt.parents("span").css({"border":"none","background":"none","padding":"none"});
		}
	else{
			paynextBtn.attr("disabled","disabled");
			agreeIpt.parents("span").css({"border":"2px solid #c00","background":"#ffc","padding":"3px"});
		}
	});
	paynextBtn.bind('click',function(){
		if(agreeIpt.is(":checked")){
			paynextBtn.removeAttr("disabled");
			agreeIpt.parents("span").css({"border":"none","background":"none","padding":"none"});
			return true;
		}
		if(!(agreeIpt.is(":checked"))){
			paynextBtn.attr("disabled","disabled");
			agreeIpt.parents("span").css({"border":"2px solid #c00","background":"#ffc","padding":"3px"});
			return false;
		}
	});
});
</script>

</td>
<td width="20"><?php echo tep_draw_separator('pixel_trans.gif', '20', '1'); ?></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
<tr>
<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
</tr>

<tr>
<td align="center">
<?php /*
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>

<td width="25%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td width="50%"></td>
<td><?php echo tep_image('image/'. 'checkout_bullet.gif'); ?></td>
<td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
</tr>
</table></td>
<td width="25%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
<td width="25%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
<td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '1', '5'); ?></td>
</tr>
</table></td>
</tr>
<tr>

<td align="center" width="25%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_PAYMENT; ?></td>
<td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
<td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_FINISHED; ?></td>
</tr>
</table>
*/?>
<!--<table width="0%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><a href="<?= tep_href_link('checkout_info.php', '', 'SSL');?>" class="broud-line"><?php echo tep_template_image_button('tours_info2.gif','','')?></a></td>
<td><img src="image/jiantou2.gif" style="margin-left:60px; margin-right:60px;" /></td>
<td><?php echo tep_template_image_button('payment-info.gif','','')?></td>
<td><img src="image/jiantou1.gif" style="margin-left:60px; margin-right:60px;" /></td>
<td><?php echo tep_template_image_button('check-info.gif','','')?></td>

</tr>
</table>-->

</td>
</tr>
</table>
<?php


if($repeat_royal_customer_discount == 'apply_discount')
{
	echo tep_draw_hidden_field('gv_redeem_code_royal_customer_reward', md5($osCsid.$customer_id));
}
//echo md5($osCsid.$customer_id);?>
</form>
</td>
</tr>
<tr>
<td height="15"></td>
</tr>




</table><!-- content main body end -->
<script language="javascript" type="text/javascript"><!--

function formCallback(result, form) {
	window.status = "valiation callback for form '" + form.id + "': result = " + result;
}

var stop_use_var_submit_disabled = true;	//������ô˱�����Validation���ݵ��жϱ��ύ״̬�ı���submit_disabled��ʧЧ
var valid = new Validation('checkout_payment', {immediate : true,useTitles:true, onFormValidate : formCallback});
Validation.add('validate-creditamt', 'Invalid Amount', function(v) {
	var customer_credit_balance_limit = document.checkout_payment.customer_credit_balance_limit.value;
	return ((v > 0) && (parseFloat(v) <= parseFloat(customer_credit_balance_limit) )); // &&
});

function CVVPopUpWindow(url) {
	window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width=600,height=233,screenX=150,screenY=150,top=150,left=150')
}
//--></script>


<?php
$p=array('/&amp;/','/&quot;/');
$r=array('&','"');
?>

<script type="text/javascript">

function get_state(country_id,form_name,state_obj_name){
	var form = form_name;
	var state = form.elements[state_obj_name];
	var country_id = parseInt(country_id);
	if(country_id<1){
		alert('<?php echo ENTRY_COUNTRY.ENTRY_COUNTRY_ERROR ?>');
		return false;
	}
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('get_state_list_for_checkout_payment_ajax.php', 'country_id='))?>") +country_id;
	ajax.open('GET', url, true);
	ajax.send(null);
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200 ) {
			document.getElementById('state_td').innerHTML = ajax.responseText;
			document.getElementById('city_td').innerHTML ='<?php echo tep_draw_input_field('city','','id="city" class="required validate-length-city" title="'.ENTRY_CITY_ERROR.'"') . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?>';
		}
	}


}
function get_ship_state(country_id,form_name,state_obj_name){
	var ajax_ = false;
	if(window.XMLHttpRequest) {
		ajax_ = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		try {
			ajax_ = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				ajax_ = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	if (!ajax_) {
		window.alert("can not use ajax");
	}

	var form = form_name;
	var state = form.elements[state_obj_name];
	var country_id = parseInt(country_id);
	if(country_id<1){
		alert('<?php echo ENTRY_COUNTRY.ENTRY_COUNTRY_ERROR ?>');
		return false;
	}
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('get_ship_state_list_for_checkout_payment_ajax.php', 'country_id='))?>") +country_id;
	ajax_.open('GET', url, true);
	ajax_.send(null);
	ajax_.onreadystatechange = function() {
		if (ajax_.readyState == 4 && ajax_.status == 200 ) {
			document.getElementById('ship_state_td').innerHTML = ajax_.responseText;
			document.getElementById('ship_city_td').innerHTML ='<?php echo tep_draw_input_field('ship_city','','id="ship_city" class="required validate-length-ship_city" title="'.ENTRY_CITY_ERROR.'"') . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?>';
		}
	}


}
function get_city(state_name,form_name,city_obj_name){
	var form = form_name;
	var city = form.elements[city_obj_name];
	var state_name = state_name;
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('get_state_list_for_checkout_payment_ajax.php','', 'SSL')) ?>");
	var aparams=new Array();
	for(i=0; i<form.length; i++){
		var sparam=encodeURIComponent(form.elements[i].name);
		sparam+="=";
		sparam+=encodeURIComponent(form.elements[i].value);
		aparams.push(sparam);
	}
	var post_str=aparams.join("&");
	ajax.open("POST", url, true);
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send(post_str);
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200 ) {
			document.getElementById('city_td').innerHTML =ajax.responseText;
		}
	}
}
function get_ship_city(state_name,form_name,city_obj_name){
	var form = form_name;
	var city = form.elements[city_obj_name];
	var state_name = state_name;
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('get_ship_state_list_for_checkout_payment_ajax.php','', 'SSL')) ?>");
	var aparams=new Array();
	for(i=0; i<form.length; i++){
		var sparam=encodeURIComponent(form.elements[i].name);
		sparam+="=";
		sparam+=encodeURIComponent(form.elements[i].value);
		aparams.push(sparam);
	}
	var post_str=aparams.join("&");
	ajax.open("POST", url, true);
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send(post_str);
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200 ) {
			document.getElementById('ship_city_td').innerHTML =ajax.responseText;
		}
	}
}

var email_array = new Array();
var firstname_array = new Array();
<?php

/*$cus_sql = tep_db_query('SELECT customers_email_address FROM `customers` WHERE customers_email_address!="" Order By customers_email_address ');
$i=0;
while($cus_rows = tep_db_fetch_array($cus_sql)){
echo 'email_array['.$i.']="'.$cus_rows['customers_email_address'].'"; ';
$i++;
}*/
?>

<?php
//����js������ԭ���ǣ����f_id�ĳ��ȴ���2���ַ��Ϳ�ʼ�����û����������product_arrayС��1�ʹ����ݿ���ȡ����
?>
function auto_list_customers_address(f_id,layer_id){
	var numtag = f_id.replace('GuestEmail','');
	var PayerMeRaiod = document.getElementById("PayerMe" + numtag + "_A");
	if(PayerMeRaiod!=null && PayerMeRaiod.checked==true ){
		return false;
	}
	var ajax_query = false;
	var f= document.getElementById(f_id);
	var l= document.getElementById(layer_id);
	if(email_array.length>0){
		if(f.value.length>=1){
			var p=new RegExp("^" + f.value, 'i');
			var htmlval="";
			var j=0;
			for(i=0; i<email_array.length; i++){
				if(email_array[i].search(p)!= -1 && j<20 && f.value.length > 2 ){	//�����ַ�����2��ʱ����ʾ
					end_val = email_array[i].replace(p,'<span style="color:#009933;font-weight: bold;">'+f.value+'</span>');
					end_val += '  '+ firstname_array[i];
					htmlval+='<div class ="meun_sel" ';
					htmlval+=' onMouseOut="this.className=&quot;meun_sel&quot; "';
					htmlval+=' onMouseMove="this.className=&quot; meun_sel1&quot; ;select_mail_input_a(&quot;'+f_id+'&quot;, &quot;'+layer_id+'&quot;,&quot;'+ email_array[i] +'&quot;);"';
					htmlval+=' onclick="select_mail_input(&quot;'+f_id+'&quot;, &quot;'+layer_id+'&quot;,&quot;'+ email_array[i] +'&quot;)" >'+end_val+'</div>';
					j++;
				}
			}
			if(htmlval.length >1){
				l.innerHTML=htmlval;
				l.style.display="";
				//alert(htmlval);
			}else{l.style.display="none";}
		}else{l.style.display="none";}

	}else{
		ajax_query = true;
	}

	if(ajax_query == true){
		var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('get_customers_list_ajax.php','key=', 'SSL')) ?>")+ f.value;

		ajax.open("GET", url, true);
		ajax.send(null);
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4 && ajax.status == 200 ) {
				eval(ajax.responseText);
			}
		}
		//alert('net get ajax ');
	}
}

function select_mail_input(f_id, layer_id, set_val){
	var f= document.getElementById(f_id);
	var l= document.getElementById(layer_id);
	f.value = set_val;
	l.style.display="none";
}
function select_mail_input_a(f_id, layer_id, set_val){
	var f= document.getElementById(f_id);
	var l= document.getElementById(layer_id);
	f.value = set_val;
	//l.style.display="none";
}

//�Զ����ݹ���ֵѡʡ��
<?php if(!tep_not_null($state) && !tep_not_null($city)){?>
if(document.getElementById('country')!=null && document.getElementById('country').value>0){
	get_state(document.getElementById('country').value, document.getElementById('checkout_payment'), "state");
}
<?php }?>

<?php if(!tep_not_null($ship_state) && !tep_not_null($ship_city)){?>
if(document.getElementById('ship_country')!=null && document.getElementById('ship_country').value>0){
	get_ship_state(document.getElementById('ship_country').value,document.getElementById('checkout_payment'),'ship_state');
}
<?php }?>

function show_edit_adderss(){
	var show_edit_address_div = document.getElementById('show_edit_address_div');
	var show_address_div = document.getElementById('show_address_div');

	if(show_edit_address_div.style.display!="none"){
		show_edit_address_div.style.display="none";
	}else{
		show_edit_address_div.style.display="";
	}
	show_address_div.style.display="none";
}
function submitFunctionCredits(is_yes) {
	if(is_yes == 1){
		document.getElementById('show_credit_apply_inputbox').style.display = '';
	}else{
		document.getElementById('show_credit_apply_inputbox').style.display = 'none';
	}
	var order_total_amt = <?php echo $order->info['total']; ?>;
	var customer_credit_balance_amt = <?php echo tep_get_customer_credits_balance((int)$customer_id); ?>;
	var customer_apply_credit_amt = document.checkout_payment.customer_apply_credit_amt.value
	if(is_yes == 1 && customer_apply_credit_amt > 0 && customer_apply_credit_amt <= customer_credit_balance_amt && customer_apply_credit_amt >= order_total_amt){
		var total_methods = <?php echo sizeof($payment_modules->selection()); ?>;
		selectRowEffect(document.getElementById('tr_pay_list_T4FCredit'), total_methods);
		display_cxpansion_tr("Expansion_T4FCredit");
	}else{
		selectRowEffect(document.getElementById('tr_pay_list_authorizenet'), 0);
		display_cxpansion_tr("Expansion_authorizenet");
	}
}

</script>
<?php echo $payment_modules->javascript_validation(); ?>
<?php echo tep_get_design_body_footer();?>
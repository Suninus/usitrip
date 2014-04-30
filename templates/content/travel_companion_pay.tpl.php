<?php
$order_id = isset($_POST['order_id']) ? (int) $_POST['order_id'] : (int) $_GET['order_id'];
$orders_travel_companion_ids = isset($_POST['orders_travel_companion_ids']) ? (array) $_POST['orders_travel_companion_ids'] : (array) $_GET['orders_travel_companion_ids'];

$orders_travel_companion_id_str = implode(',', $orders_travel_companion_ids);

// �Ƿ��������Ż����Ź���
$is_special = false;
//ͳ�����в�ƷID�������ж��Ƿ�ĳ����Ʒ����ʹ��ĳ��֧����ʽ by lwkai add 2013-5-13
$products_id_array = array();
if (tep_not_null($orders_travel_companion_id_str)) {
	// ȡ�ø����ܶ�Ͳ�������Ϣ
	$payables_total_sql = tep_db_query('SELECT products_id, payables, guest_name, paid FROM `orders_travel_companion` WHERE orders_travel_companion_id IN(' . $orders_travel_companion_id_str . ') GROUP BY orders_travel_companion_id ');
	$payables_total = 0;
	$guest_name = '';
	while($payables_total_row = tep_db_fetch_array($payables_total_sql)) {
		
		$payables_total += $payables_total_row['payables'];
		// ��ȥ�Ѿ�����
		$payables_total -= $payables_total_row['paid'];
		
		$guest_name .= tep_db_output($payables_total_row['guest_name']) . ' , ';
		$products_id = $payables_total_row['products_id'];
		$products_id_array[intval($products_id)] = count($products_id_array);
		// �ж���û���ؼ۲�Ʒ �����Ź���Ʒ
		if ((int) special_detect($products_id)) {
			$is_special = true;
		}
	}
	$guest_name = preg_replace('/ , $/', '', $guest_name);
	?>
<form
	action="<?php echo tep_href_link('checkout_confirmation_travel_companion.php','','SSL')?>"
	method="post" name="checkout_payment" id="checkout_payment"
	onSubmit="return check_form();">
	<div>
		<table width="100%" border="0" cellpadding="0" cellspacing="0"
			bgcolor="#FFFFFF">
			<tr>
				<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
			</tr>


	<?php //�г���Ϣ?>
	<tr>
				<td>
					<table border="0" width="100%" cellspacing="0" cellpadding="2">
						<tr>
							<td class="infoBoxHeading">
								<div class="heading_bg"><?php echo db_to_html('�г���Ϣ'); ?></div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<div class="infoBox_outer">
						<table border="0" width="100%" cellspacing="1" cellpadding="2"
							class="infoBox_new">
							<tr class="infoBoxContents_new">
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0"
										style="padding: 10px;">
										<tr>
											<td align="right" nowrap="nowrap"><?php echo db_to_html('�����ţ�');?></td>
											<td align="left"><b><?php echo $order_id?></b><input
												name="order_id" type="hidden" id="order_id"
												value="<?php echo $order_id?>" size="50"> <input
												name="orders_travel_companion_ids" type="hidden"
												id="orders_travel_companion_ids"
												value="<?php echo $orders_travel_companion_id_str?>"></td>
										</tr>
										<tr>
											<td align="right"><?php echo db_to_html('�š�����');?></td>
											<td><b><?php echo db_to_html(tep_get_products_name($products_id))?></b></td>
										</tr>
										<tr>
											<td align="right"><?php echo db_to_html('�����ˣ�');?></td>
											<td><b><?php echo db_to_html($guest_name)?></b><input
												name="guest_names" type="hidden" id="guest_names"
												value="<?php echo db_to_html($guest_name)?>" size="80"></td>
										</tr>
										<tr>
											<td align="right"><?php echo db_to_html('�𡡶');?></td>
											<td><b><?php echo $currencies->display_price($payables_total,0, 1);?></b><input
												name="payables_total" type="hidden" id="payables_total"
												value="<?php echo $payables_total?>" size="50"></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
	<?php //�г���Ϣend?>

	<tr>
				<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
			</tr>

	<?php
	// ������ʾ
	if (isset($HTTP_GET_VARS['payment_error']) && is_object(${$HTTP_GET_VARS['payment_error']}) && ($error = ${$HTTP_GET_VARS['payment_error']}->get_error())) {
		?>
	<tr>
				<td>
					<table border="0" width="100%" cellspacing="0" cellpadding="2">
						<tr>
							<td class="main"><b><?php echo tep_output_string_protected($error['title']); ?></b></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" width="100%" cellspacing="1" cellpadding="2"
						class="infoBoxNotice">
						<tr class="infoBoxNoticeContents">
							<td>
								<table border="0" width="100%" cellspacing="0" cellpadding="2">
									<tr>
										<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
										<td class="main" width="100%" valign="top"><?php echo tep_output_string_protected($error['error']); ?></td>
										<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
			</tr>
	<?php
	}
	?>

	<?php //֧����ʽ?>
	<tr>
				<td>
					<table border="0" width="100%" cellspacing="0" cellpadding="2">
						<tr>
							<td class="infoBoxHeading">
								<div class="heading_bg"><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<div class="infoBox_outer">
						<table border="0" width="100%" cellspacing="1" cellpadding="2"
							class="infoBox_new">
							<tr class="infoBoxContents_new">
								<td><?php
	$selection = $payment_modules->selection(array_flip($products_id_array));
	// amit added to default selection start
	if (! isset($payment)) {
		$payment = "paypal_nvp_samples";
	}
	// amit added to default selection end
	
	?>

				<div class="cont pay">
										<div id="payment_list_table" class="payLeft">
											<ul>

				<?php
	// ���ʽ�б� start
	$radio_buttons = 0;
	$show_all_pay_module = true;
	$_checkdID = '';
	for($i = 0, $n = sizeof($selection); $i < $n; $i ++) {
		
		// �����ǰ��������һ���ؼ۲�Ʒ�������Ź���Ʒ����֧����ʽֻ��ʾ ֧���� �� �й�����ת�� by lwkai 2012-09-03 add ,howard added �������������,lwkai added ����ܽ�����3000����ʾ��������ת��
		if (($selection[$i]['id'] != 'alipay_direct_pay' && $selection[$i]['id'] != 'transfer' && $selection[$i]['id']!='netpay' && $selection[$i]['id'] != 'cashdeposit') && $is_special == true) {
			//continue; ���������� by lwkai rem 2013-03-25 13.24
		} 
		// �������������ת��,�����ܽ����ڵ���3000 ����ʾ,������ʾ
		if ($selection[$i]['id'] == 'cashdeposit'  && $payables_total < 3000 ) {
			continue;
		}
		if ($_checkdID == '') $_checkdID = "div_pay_list_" . $selection[$i]['id']; //����Ĭ��Ҫչʾ��֧����ʽ���ǵ�һ��
		// lwkai add end
		if ($selection[$i]['id'] == "authorizenet" || $selection[$i]['id'] == "paypal" || $show_all_pay_module == true) {
			$margin_top = $i * 40;
			
			?>
					<li id="div_pay_list_<?= $selection[$i]['id']?>"><label> <?php
			$_checkd = false;
			if ($payment == $selection[$i]['id']) {
				$_checkd = true;
				$_checkdID = "div_pay_list_" . $selection[$i]['id']; //�����û���ѡ֧����ʽ,�����Ϊ�û�ѡ���֧����ʽΪĬ��ѡ��֧����ʽ
			}
			echo tep_draw_radio_field('payment', $selection[$i]['id'], $_checkd, ' id="payment_' . $selection[$i]['id'] . '" ');
			?> <span class="font_size14"><?php echo $selection[$i]['module']; ?></span>
												</label></li>
					<?php
			$radio_buttons ++;
		}
	}
	// ���ʽ�б� end
	?>

				</ul>
										</div>
										<div id="payment_list_content" class="payRight"><?php
	// ���ʽ�ұ���Ϣ�� start
	$show_all_expansion = true; // ��ʾ�����ұߵ�����
	for($i = 0, $n = sizeof($selection); $i < $n; $i ++) {
		// �����ǰ��������һ���ؼ۲�Ʒ�������Ź���Ʒ����֧����ʽֻ��ʾ ֧���� �� �й�����ת�� by lwkai 2012-09-03 add ,howard added �������������,lwkai added ����ܽ�����3000����ʾ��������ת��
		if (($selection[$i]['id'] != 'alipay_direct_pay' && $selection[$i]['id'] != 'transfer' && $selection[$i]['id']!='netpay' && $selection[$i]['id'] != 'cashdeposit' ) && $is_special == true) {
			continue;
		} 
		// �������������ת��,�����ܽ����ڵ���3000 ����ʾ,������ʾ
		if ($selection[$i]['id'] == 'cashdeposit'  && $payables_total < 3000 ) {
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
												<div class="tit">
													<h2 class="font_bold font_size14"><?php echo $selection[$i]['module'];?></h2>
													<span class="font_bold color_orange"><?php echo db_to_html('����ѡ����').$selection[$i]['module'].db_to_html('��ʽ�����������֧������')?></span>
												</div>
												<div class="cont">
													<table border="0" cellspacing="0" cellpadding="2">
				<?php
			if ($selection[$i]['id'] == 'authorizenet' || $selection[$i]['id'] == 'cc_cvc') {
				?>
					<tr>
															<td colspan="4" class="font_black"><span class="sp1"><b><?php echo TEXT_NOTES_HEADING_DIS;?></b>
															</span><?php echo TEXT_NOTES_HEADING_HOLDER_CC_NOTE;?></td>
														</tr>
														<tr>
															<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
														</tr>
					<?php
			}
			?>
				<?php
			for($j = 0, $n2 = sizeof($selection[$i]['fields']); $j < $n2; $j ++) {
				?>
					<tr>
															<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
															<td class="main" height="25px;" align="right"
																nowrap="nowrap"><?php echo $selection[$i]['fields'][$j]['title']; ?>&nbsp;</td>
															<td class="main"><?php echo $selection[$i]['fields'][$j]['field']; ?></td>
															<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
														</tr>
					<?php
			}
			?>
				</table>
												</div>
												<div class="pay2_warp"><?php
			// ��ܰ��ʾ��start
			if (isset($selection[$i]['warm_tips'])) {
				echo $selection[$i]['warm_tips'];
			}
			// ��ܰ��ʾ��end			?></div>
											</div>
				<?php
		}
	}
	// ���ʽ�ұ���Ϣ�� end
	?></div>
										<div class="clear"></div>
									</div></td>
							</tr>
						</table>
					</div> <script type="text/javascript"><!--

jQuery(document).ready(function() {




    jQuery('#payment_list_table > ul').children().click(function(){
			
			jQuery(this).addClass('cur').siblings().removeClass('cur'); //    ���õ����LI��classΪcur ȥ������LI��cur��ʽ
			jQuery(this).find('input[type=radio]').attr('checked','true');//   ���û�δ�㵽input radio ����Ӧ���� ����л�����ǰ�����ѡ��ť��ѡ�е�����
			var index = jQuery('#payment_list_table > ul').children().index(this);//    ȡ�õ�ǰLI������ 
			jQuery('#payment_list_content').children().eq(index).show().siblings().hide(); //    ��li����������ʾ��Ӧ���ұ�����
	});
	/*    ���PHP�н���Ĭ��չʾ���� ��ע�͵�������� PHP�� ���LI ���� ����class = cur ��Ϊ��ǰչ������ұ����Ӧȥ��display:none ����      */
	jQuery('#<?php echo $_checkdID?>').click().find('input').attr('checked','true');

});


<?php
	for($i = 0, $n = sizeof($selection); $i < $n; $i ++) {
		if (isset($selection[$i]['fields']) && is_array($selection[$i]['fields']) && ! isset($selection[$i]['error']) || $show_all_expansion == true) {
			if (($selection[$i]['id'] != $payment)) {
				echo 'if(document.getElementById("Expansion_' . $selection[$i]['id'] . '")!= null){ document.getElementById("Expansion_' . $selection[$i]['id'] . '").style.display="none";}' . "\n";
			}
		}
	}
	?>

function display_cxpansion_tr(id){
	<?php
	for($i = 0, $n = sizeof($selection); $i < $n; $i ++) {
		echo 'if(document.getElementById("Expansion_' . $selection[$i]['id'] . '")!= null){ document.getElementById("Expansion_' . $selection[$i]['id'] . '").style.display="none";}' . "\n";
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
	<?php //֧����ʽend?>

	<tr>
				<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
			</tr>

	<?php
	if ($messageStack->size('travel_companion') > 0) {
		?>
	<tr>
				<td align="left"><?php echo $messageStack->output('travel_companion');?>
		</td>
			</tr>
	<?php
	}
	?>

	<?php //ͨ�ŵ�ַ?>
	<tr style="display: none">
				<td>
					<table border="0" width="100%" cellspacing="0" cellpadding="2">
						<tr>
							<td class="infoBoxHeading">
								<div class="heading_bg"><?php echo TABLE_HEADING_CONTACT_ADDRESS; ?></div>
								<div class="head_note" style="color: #f68711;"><?php //echo TABLE_HEADING_BILLING_ADDRESS_EXP; ?></div>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr style="display: none">
				<td>
					<div id="response_ship_div"><?php
	// amit added move billing address exits query above don't delete
	$shipto = ((int) $shipto) ? $shipto : $customer_default_ship_address_id;
	
	$check_address_blank_query = tep_db_query("select a.entry_firstname as firstname, a.entry_lastname as lastname, a.entry_company as company, a.entry_street_address as street_address, a.entry_suburb as suburb, a.entry_city as city, a.entry_postcode as postcode, a.entry_state as state, a.entry_zone_id as zone_id, a.entry_country_id as country_id, c.customers_telephone, c.customers_fax, c.customers_cellphone, c.customers_mobile_phone from " . TABLE_ADDRESS_BOOK . " a, " . TABLE_CUSTOMERS . " c where a.customers_id=c.customers_id and a.customers_id = '" . (int) $customer_id . "' and a.address_book_id = '" . (int) $shipto . "'");
	$row_check_address_blank = tep_db_fetch_array($check_address_blank_query);
	// amit added to move billing address exits query above don't delete
	
	if ($row_check_address_blank['street_address'] == '' && $row_check_address_blank['city'] == '') {
		$style_show_address_div = ' style="display:none;"';
		$style_show_edit_address_div = '';
	} else {
		$style_show_address_div = '';
		$style_show_edit_address_div = ' style="display:none;"';
	}
	$osCsid_string = '';
	if (tep_not_null($_GET['osCsid'])) {
		$osCsid_string = '&osCsid=' . (string) $_GET['osCsid'];
	}
	?>

		<div id="show_address_div" <?php echo $style_show_address_div; ?>>
							<div class="infoBox_outer">
								<table border="0" width="100%" cellspacing="0" cellpadding="2"
									class="infoBox_new">
									<tr class="infoBoxContents_new">
										<td>
											<table border="0" width="100%" cellspacing="0"
												cellpadding="2">
												<tr>
													<td colspan="4"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
												</tr>
												<tr>
													<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
													<td class="main" colspan="3"><span class="sp1"><b><?php echo TEXT_NOTES_HEADING_DIS;?>
						</b></span><?php echo TEXT_NOTES_HEADING_BILLING_EDIT_INFORMATION;?></td>
												</tr>
												<tr>
													<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
													<td align="left" width="50%" valign="top">
														<table border="0" cellspacing="0" cellpadding="2">
															<tr>

																<td class="main" align="center" valign="top"><b><?php //echo TITLE_BILLING_ADDRESS; ?></b><?php //echo tep_image('image/'. 'arrow_south_east.gif'); ?></td>

																<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
																<td valign="top" style="padding-left: 20px;"
																	nowrap="nowrap"><b><?php
	
	echo db_to_html(tep_address_label($customer_id, $shipto, true, ' ', '<br />'));
	// amit added shot telpphone number start
	if ($row_check_address_blank['customers_telephone'] != '') {
		echo '<br />' . TEXT_BILLING_INFO_TELEPHONE . ' ' . db_to_html($row_check_address_blank['customers_telephone']);
	}
	if ($row_check_address_blank['customers_mobile_phone'] != '') {
		echo '<br />' . TEXT_BILLING_INFO_MOBILE . ' ' . db_to_html($row_check_address_blank['customers_mobile_phone']);
	}
	if ($row_check_address_blank['customers_fax'] != '') {
		echo '<br />' . ENTRY_FAX_NUMBER . ' ' . db_to_html($row_check_address_blank['customers_fax']);
	}
	// amit added show telephone number end
	?></b></td>

																<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
															</tr>
														</table>
													</td>
													<td align="right" class="main" width="50%" valign="top"><?php echo TEXT_SELECTED_BILLING_DESTINATION; ?><br />
														<br /> <a href="javascript:void(0);"
														onclick="show_edit_adderss()" class="btn"><span></span><?php echo db_to_html('�޸���Ϣ') ?></a><?php # echo tep_template_image_button('button_edit_information.gif', IMAGE_BUTTON_CHANGE_ADDRESS,' onclick="show_edit_adderss()" style="cursor:pointer;"'); // onclick="toggel_div(\'address_edit_div\');" ?>
						</td>
													<td align="right" class="main" width="1%" valign="top"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
												</tr>
												<tr>
													<td colspan="4"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</div>
						</div>

						<div id="show_edit_address_div"
							<?php echo $style_show_edit_address_div; ?>>
							<div class="infoBox_outer">
								<table border="0" width="100%" cellspacing="0" cellpadding="2"
									class="infoBox_new">
									<tr class="infoBoxContents_new">
										<td><?php require(DIR_FS_MODULES . 'edit_ship_address.php');?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</td>
			</tr>
	<?php //ͨ�ŵ�ַend?>

	<tr>
				<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
			</tr>
			<tr>
				<td>


					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><a class="btn"
								href="<?php echo tep_href_link('orders_travel_companion_info.php', 'order_id='.(int)$order_id, 'SSL');?>"><span></span><?php echo db_to_html('����һҳ')?><?php # echo tep_image_button('button_back.gif', IMAGE_BUTTON_BACK); ?></a>
							</td>
							<td align="right" class="subbtn"><input type="submit"
								value="<?php echo db_to_html('����');?>"><?php # echo tep_template_image_submit('button_continue_checkout.gif', db_to_html('����'));?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>
</form>
<?php
} else {
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	style="margin-top: 10px;">
	<tr>
		<td><?php echo db_to_html('��û��ѡ��Ҫ�������Ա���뷵������ѡ��');?></td>
		<td align="right"><a class="btn" href="javascript:history.go(-1)"><span></span><?php echo db_to_html('������һҳ'); //echo tep_image_button('button_back.gif', IMAGE_BUTTON_BACK); ?></a></td>
	</tr>
</table>
<?php
}
?>


<?php
$p = array(
		'/&amp;/',
		'/&quot;/' 
);
$r = array(
		'&',
		'"' 
);
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

//-->

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

</script>

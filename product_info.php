<?php

/*
$Id: product_info.php,v 1.1.1.1 2004/03/04 23:38:02 ccwjr Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2003 osCommerce

Released under the GNU General Public License
*/

require('includes/application_top.php');

require(DIR_FS_INCLUDES . 'ajax_encoding_control.php');
require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);
//取得所有属于邮轮团的产品属性ID
$cruisesOptionIds = getAllCruisesOptionIds();

//客服销售跟踪
servers_sales_track::save_login_id_to_customer_browser(30);

if (isset($_GET['action']) && ($_GET['action'] == 'calculate')) {

	$date_str = date_add_day_product($_GET['addnofodays'], 'd', $_GET['selecteddate']);
	$weeks_str = en_to_china_weeks(substr($date_str, 10));
	$date_str = substr($date_str, 0, 10) . $weeks_str;
	echo $date_str;
	exit;
}

// 重定向产品ID key到value by Howard start{
//2011-11-21 恢复重定向
$redirect_array = array(
'120' => '2276',
);
if (array_key_exists(intval($_GET['products_id']), $redirect_array)){
	//tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $redirect_array[intval($_GET['products_id'])]));
}
// 重定向产品ID key到value by Howard  end}

//判断该产品是否是酒店
//if the products is hotels $is_hotels = true



$sql = "select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int) $_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int) $languages_id . "'";

if ($login_id && $_GET['preview'] == 'true') {
	$where_preview = "";
} else {
	$where_preview = " and p.products_status = '1' ";
}


$product_check_query = tep_db_query($sql . $where_preview);
$product_check = tep_db_fetch_array($product_check_query);

$tmp_var = false;
$not_found_product_message = "";



if ((int) $product_check['total']) {
	//howard added view history cookie
	$i = 0;
	foreach ((array)$_COOKIE['view_history'] as $j => $value) {
		if ($_COOKIE['view_history'][$j]['products_id'] == (int) $_GET['products_id']) {
			setcookie('view_history[' . $j . '][products_id]', (int) $_GET['products_id'], time() + (3600 * 3));
			setcookie('view_history[' . $j . '][date_time]', date('YmdHis'), time() + (3600 * 3));
			$tmp_var = true;
		}
		$i = ($j+1);
	}

	if ($tmp_var == false) {
		setcookie('view_history[' . $i . '][products_id]', (int) $_GET['products_id'], time() + (3600 * 3));
		setcookie('view_history[' . $i . '][date_time]', date('YmdHis'), time() + (3600 * 3));
	}
	//只保留6个产品浏览cookie记录
	$n = sizeof($_COOKIE['view_history']);
	if( $n >= 6){
		$_n = $n - 6;
		foreach($_COOKIE['view_history'] as $key => $value){
			if($_n <=0){ break; }
			setcookie('view_history[' . $key . '][products_id]', '', time()-3600);
			setcookie('view_history[' . $key . '][date_time]', '', time()-3600);
			$_n--;
		}
	}
	//howard added view history cookie end
	//替换搜索结果的颜色
	if ($ajax == true) {
		$new_key = addslashes(strip_tags(trim(iconv('utf-8', CHARSET . '//IGNORE', $_GET['keywords']))));
	} else {
		$new_key = addslashes(strip_tags(trim($_GET['keywords'])));
	}
	$get_key_par = '';
	if (tep_not_null($new_key)) {
		$get_key_par = '&keywords=' . $new_key;
	}

	$pieces_a = split('[[:space:]]+', $new_key);
	$pieces_a = array_unique($pieces_a);

	$key_pert = array();
	$key_rep = array();
	foreach ((array) $pieces_a as $key => $val) {
		if (strlen(trim($val)) > 1) {
			$key_pert[] = '/' . preg_quote(html_to_db($val)) . '/i';
			$key_rep[] = '<span style="color:#FFFF00; background-color: #F1740E;">' . html_to_db($val) . '</span>';
		}
	}

	//amit added to unregister session to ask continue without sing notification on each tab start
	if (tep_session_is_registered('customer_review_process_without_login')) {
		tep_session_unregister('customer_review_process_without_login');
		unset($customer_review_process_without_login);
	}
	//amit added to unregister session to ask continue without sing notification on each tab end
	//当前产品SQL start

	$product_info_query = tep_db_query("SELECT
			 p.products_info_tpl, p.tour_type_icon, p.products_class_id,p.products_class_content, p.products_durations,
			 p.products_durations_type, p.products_video, p.products_type, p.operate_start_date ,p.operate_end_date,
			 p.products_single,p.products_single_pu,p.products_double,p.products_triple,p.products_quadr,p.products_kids,
			 p.display_room_option,p.maximum_no_of_guest,p.products_id, p.is_visa_passport, pd.products_notes, pd.products_name,
			 pd.products_description, pd.products_small_description, pd.products_pricing_special_notes,  pd.products_other_description,
			 pd.products_package_excludes, pd.products_package_special_notes, p.products_is_regular_tour, p.products_model, p.provider_tour_code,
			 p.products_quantity, p.products_image, p.products_image_med, p.products_image_lrg, pd.products_url, p.products_price,
			 p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id, p.departure_city_id, p.departure_end_city_id,
			 p.agency_id, p.display_pickup_hotels, p.display_itinerary_notes, p.display_hotel_upgrade_notes,p.products_map, p.products_stock_status,
			 p.upgrade_to_product_id, p.only_our_free ,pd.travel_tips,p.expert_ids,
			 p.is_hotel, p.is_cruises,  pd.products_hotel_nearby_attractions,p.hotels_for_early_arrival,p.hotels_for_late_departure,p.is_transfer,p.transfer_type,p.recommend_transfer_id,
			 p.min_num_guest, p.with_air_transfer
			 FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
			 WHERE p.products_id = '" .  (int) $_GET['products_id'] . "'
			 AND pd.products_id = p.products_id
			 AND pd.language_id = '" . (int) $languages_id . "'" . $where_preview);

	$product_info = tep_db_fetch_array($product_info_query);
	//$product_info = MCache::product_detail($_GET['products_id']);/*缓存产品详情*/

	//Howard added 如果是酒店就添加相关的酒店数据{
	if($product_info['is_hotel']==1){
		$isHotels = true;
		require_once(DIR_FS_FUNCTIONS . 'hotels_functions.php');
		$hotelQuery = tep_db_query("SELECT hotel_id, hotel_stars, meals_id, internet_id, approximate_location_id, hotel_phone, hotel_address FROM `hotel` WHERE products_id =".(int)$product_info['products_id']." Limit 1 ");
		$hotelRow = tep_db_fetch_array($hotelQuery);
		foreach((array)$hotelRow as $key => $val){
			$product_info[$key] = $hotelRow[$key];
		}
	}
	//Howard added 如果是酒店就添加相关的酒店数据}
	//Howard added 如果是邮轮就添加相关的邮轮数据{
	unset($isCruises);
	if($product_info['is_cruises']==1){
		require_once(DIR_FS_FUNCTIONS . 'cruises_functions.php');
		$cruises_id = getProductsCruisesId((int)$product_info['products_id']);
		if((int)$cruises_id){
			$isCruises = true;
			$cruisesData = getProductsCruisesInfos($cruises_id, $product_info['products_id']);
		}
	}
	//Howard added 如果是邮轮就添加相关的邮轮数据}


	$parent_cat_array = array();
	tep_get_parent_categories($parent_cat_array, $current_category_id);
	//当前产品SQL end
	$priority_use_calendar = false; //是否优先使用日历框显示出发日期
	//如果标题包含有黄石的就取消日历框的优先显示
	if (preg_match('/黄石/', $product_info['products_name'])) {
		$priority_use_calendar = false;

	}
	$is_has_priority_attribute = tep_check_priority_mail_is_active((int)$HTTP_GET_VARS['products_id']);

	$product_info['products_name1']=strstr($product_info['products_name'], '**');
	if($product_info['products_name1']!='' && $product_info['products_name1']!==false)$product_info['products_name']=str_replace($product_info['products_name1'],'',$product_info['products_name']);
	//出团时间
	$product_info['operate'] = tep_get_display_operate_info($product_info['products_id'],1);
	//=============dleno added start===================================================================================
	$isTickets = false;
	//1天及以内
	if($product_info['products_durations_type']>=1 || ($product_info['products_durations_type']<1 && $product_info['products_durations']==1)){
		$checkTickets=array();
		//暂不对票做任何特殊处理
		//$checkTickets[]= array('环球影城','门票');
		//$checkTickets[]= array('环球影视城','门票');
		//$checkTickets[]= array('迪士尼','门票');
		//$checkTickets[]= array('迪斯尼','门票');
		//$checkTickets[]= array('海洋世界','门票');
		foreach($checkTickets as $ticketItem){
			$_tmp_check = false;
			foreach($ticketItem as $_item){
				if(strpos($product_info['products_name'],$_item)!==false){
					$_tmp_check = true;
				}else{
					$_tmp_check = false;
					break;
				}
			}
			if($_tmp_check){
				$isTickets = true;
				break;
			}
		}
	}
	//=============dleno added end======================================================================================
	$other_css_base_name = "product_detail";
	$validation_include_js = 'true';
	$validation_div_span ='span';
	$content = CONTENT_PRODUCT_INFO;
	$javascript = 'product_info.js.php';
	if (!(int) $customer_id) {
		$Show_Calendar_JS = "true";
	}
	// if is vegas show 如果是拉斯维加斯秀的产品则用新模板
	if (tep_not_null($product_info['products_info_tpl'])) {
		$content = $product_info['products_info_tpl'];
	}

	//amit modified to make sure price on usd
	$tour_agency_opr_currency = tep_get_tour_agency_operate_currency($product_info['products_id']);
	if ($tour_agency_opr_currency != 'USD' && $tour_agency_opr_currency != '') {
		$product_info['products_price'] = tep_get_tour_price_in_usd($product_info['products_price'], $tour_agency_opr_currency);
		$product_info['products_single'] = tep_get_tour_price_in_usd($product_info['products_single'], $tour_agency_opr_currency);
		$product_info['products_single_pu'] = tep_get_tour_price_in_usd($product_info['products_single_pu'], $tour_agency_opr_currency);
		$product_info['products_double'] = tep_get_tour_price_in_usd($product_info['products_double'], $tour_agency_opr_currency);
		$product_info['products_triple'] = tep_get_tour_price_in_usd($product_info['products_triple'], $tour_agency_opr_currency);
		$product_info['products_quadr'] = tep_get_tour_price_in_usd($product_info['products_quadr'], $tour_agency_opr_currency);
		$product_info['products_kids'] = tep_get_tour_price_in_usd($product_info['products_kids'], $tour_agency_opr_currency);
	}
	//amit modified to make sure price on usd
	$tax_rate_val_get = tep_get_tax_rate($product_info['products_tax_class_id']);
	$qi_string = "";
	if ($product_info['products_durations'] > 1 && !(int) $product_info['products_durations_type']) {
		$qi_string = '<span>起</span>';
	}

	tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int) $_GET['products_id'] . "' and language_id = '" . (int) $languages_id . "'");
	//MCache::update_product($_GET['products_id']);//不缓存点击数将在载入的时候更新当前点击数\评论等...
	if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
		//如果产品是特价团则需要把原价保存到新变量以备后面所用（紧记在数据中添加变量时使用驼峰法命名）
		$product_info['oldProductsPrice'] = $product_info['products_price'];
		$product_info['oldProductsSingle'] = $product_info['products_single'];
		$product_info['oldProductsSinglePu'] = $product_info['products_single_pu'];
		$product_info['oldProductsDouble'] = $product_info['products_double'];
		$product_info['oldProductsTriple'] = $product_info['products_triple'];
		$product_info['oldProductsQuadr'] = $product_info['products_quadr'];
		$product_info['oldProductsKids'] = $product_info['products_kids'];
		
		if($product_info['is_hotel'] == '1'){//<p><del>%s</del></p> <p><b>双人间%s/晚</b></p>
			$products_price = db_to_html(sprintf('<p><del>%s</del></p> <p><b>%s</b></p>',$currencies->display_price($product_info['products_price'], $tax_rate_val_get),$currencies->display_price($new_price, $tax_rate_val_get) . $qi_string));
		}else{
			$products_price = db_to_html(sprintf('<p><del>%s</del></p> <p><b>%s</b></p>',$currencies->display_price($product_info['products_price'], $tax_rate_val_get),$currencies->display_price($new_price, $tax_rate_val_get) . $qi_string));
		}

		$SaveNumStr = $currencies->display_price(($product_info['products_price'] - $new_price), $tax_rate_val_get);

	} else {
		if($product_info['is_hotel'] == '1'){ //<p><b>双人间 %s/晚</b></p>
			$products_price =db_to_html(sprintf("<p><b> %s</b></p>",$currencies->display_price($product_info['products_price'], $tax_rate_val_get) . $qi_string));
		}else{
			$products_price =db_to_html(sprintf("<p><b> %s </b></p>",$currencies->display_price($product_info['products_price'], $tax_rate_val_get) . $qi_string));
		}
	}



	if ($product_info['products_package_excludes'] != '') {
		$tous_with_new_design = 'true';
	}
	$products_name = $product_info['products_name'];
	$products_name1 = $product_info['products_name1'];

	/////////////////////////////product_info_module_right_1.php和product_info_module_right_3.php均用到的代码 start

	function get_products_class_name($produc_class_id=1) {
		$sql = tep_db_query('SELECT products_class_name FROM `products_class` WHERE products_class_id="' . $produc_class_id . '"');
		$row = tep_db_fetch_array($sql);
		return $row['products_class_name'];
	}

	function get_products_class_content($produc_class_id=1, $products_class_content='') {
		if (tep_not_null($products_class_content)) {
			return $products_class_content;
		}
		$sql = tep_db_query('SELECT products_class_defaults_content FROM `products_class` WHERE products_class_id="' . $produc_class_id . '"');
		$row = tep_db_fetch_array($sql);
		return $row['products_class_defaults_content'];
	}

	$avaliabledate = '<option value="">' . TEXT_SELECT_DEPARTURE_DATE . '</option>';
	$array_avaliabledate_store = get_avaliabledate($products_id);
	//if no deaparture date then mail send to provider@usitrip.com - start
	//给管理员发缺货邮件，目前不开放
	if (0 && sizeof($array_avaliabledate_store) == 0 && ($_SERVER['HTTP_HOST']=='cn.usitrip.com' || $_SERVER['HTTP_HOST']=='208.109.123.18')) {
		//if((substr($_SERVER['HTTP_HOST'],0,5)!='amit.')&&(substr($_SERVER['HTTP_HOST'],0,3)!='qa.')){
		$today_mail_date = date("Y-m-d");
		//check if already mail send today
		$check_already_send_query = tep_db_query("select products_id from " . TABLE_PRODUCTS_WITHOUT_DEPARTUREDATE_CRON . " where products_id = '" . (int) $_GET['products_id'] . "' and last_mail_sent_date='" . $today_mail_date . "'");
		if (tep_db_num_rows($check_already_send_query) == 0) {

			$email_address = 'provider@usitrip.com';
			$email_subject = 'Expired Departure Date (' . $product_info['products_model'] . ') (' . $product_info['provider_tour_code'] . ')';
			$email_text = "Please checkout url on " . STORE_NAME . " front end and back end as below.<br><a href=\"" . tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('info', 'mnu', 'rn', 'action'))) . "\">" . tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('info', 'mnu', 'rn', 'action'))) . "</a><br><a href=\"" . HTTP_SERVER . DIR_WS_HTTP_CATALOG . "admin/categories.php?cPath=" . $current_category_id . "&pID=" . $_GET['products_id'] . "&action=new_product\">" . HTTP_SERVER . DIR_WS_HTTP_CATALOG . "admin/categories.php?cPath=" . $current_category_id . "&pID=" . $_GET['products_id'] . "&action=new_product</a><br><br>Above tour does not have any valid departure date. Please fix it ASAP.<br><br>This is a daily auto-generated email by system program. This mail will not be sent out to you again once you finish updating departure date.<br><br>Please contact development team if any problem or question.<br><br>Thanks,<br>Development Team,<br>" . STORE_NAME . "";

			$headers = "From: usitrip <service@usitrip.com>\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$xtra_headers_added = "-f service@usitrip.com";

			@mail($email_address, $email_subject, $email_text, $headers, $xtra_headers_added);
			$prod_without_departuredate_cron_array = array(
			'products_id' => (int) $_GET['products_id'],
			'last_mail_sent_date' => $today_mail_date
			);
			tep_db_perform(TABLE_PRODUCTS_WITHOUT_DEPARTUREDATE_CRON, $prod_without_departuredate_cron_array);
		}//end if num rows
		//}//end if substr host name
	}

	//if no deaparture date then mail send to provider@usitrip.com - end
	//show product options start
	//汇率附加费 等产品选项


	$products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int) $_GET['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int) $languages_id . "'");
	$products_attributes = tep_db_fetch_array($products_attributes_query);
	if ($products_attributes['total'] > 0) {

		$dis_buy_steps_2_products_options_name = '';

		$products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int) $_GET['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int) $languages_id . "' order by popt.products_options_sort_order ASC, patrib.options_values_price ASC");
		$cruises_products_options = false;
		while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {

			$show_attr_themepark_note = false;
			$products_radio_array = array();
			$products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix, pa.single_values_price, pa.double_values_price, pa.triple_values_price, pa.quadruple_values_price, pa.kids_values_price, pov.is_per_order_option from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int) $_GET['products_id'] . "' and pa.options_id = '" . (int) $products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int) $languages_id . "' order by pa.products_options_sort_order, pa.options_values_price ASC");
			while ($products_options = tep_db_fetch_array($products_options_query)) {
				$products_radio_array[] = array('id' => $products_options['products_options_values_id'], 'value'=>$products_options['options_values_price'], 'text' => db_to_html($products_options['products_options_values_name']));
				if( preg_match("/在团上以现金方式支付/i", strtolower($products_options['products_options_values_name'])) || preg_match("/预订时支付/i", strtolower($products_options['products_options_values_name'])) ){
					$show_attr_themepark_note = true;
				}
				if ($products_options['options_values_price'] != '0') {
					//amit modified to make sure price on usd
					if ($tour_agency_opr_currency != 'USD' && $tour_agency_opr_currency != '') {
						$products_options['options_values_price'] = tep_get_tour_price_in_usd($products_options['options_values_price'], $tour_agency_opr_currency);
					}
					//amit modified to make sure price on usd
					$products_options_addon_attr_text = '';
					if($products_options['is_per_order_option'] == 0){
						$products_options_addon_attr_text = TEXT_ATTR_PER_PERSON;
					}else{
						$products_options_addon_attr_text = TEXT_ATTR_PER_ORDER;
					}
					$products_radio_array[sizeof($products_radio_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . $currencies->display_price($products_options['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . $products_options_addon_attr_text . ') ';
				}
				//amit added to show Holiday Surcharge -- for special price start
				if ($products_options['single_values_price'] > 0 || $products_options['double_values_price'] > 0 || $products_options['triple_values_price'] > 0 || $products_options['quadruple_values_price'] > 0 || $products_options['kids_values_price'] > 0) {
					if((int)$products_options_name['products_options_id'] == 189){	//189 - Add-on optional tour on Day2:
						$products_radio_array[sizeof($products_radio_array) - 1]['text'] .= TEXT_HEADING_PRODUCT_ATTRIBUTE_OPTIONS_TOUR;
					}else{
						$products_radio_array[sizeof($products_radio_array) - 1]['text'] .= ' (' . TEXT_HEADING_PRODUCT_ATTRIBUTE_SPECIAL_PRICE .') ';
					}
					$display_pricing_for_special_price_attribute = 'true';
				}
				//amit added to show Holiday Surcharge -- for special price end
			}

			///*
			
			/**
			* 如果产品选项属于邮轮客舱的选项则收集所有客舱甲板选项用于单选
			*/
			if($isCruises && in_array($products_options_name['products_options_id'],(array)$cruisesOptionIds)){
				//$cruises_products_options[客舱选项id] = 该客舱的甲板集
				
				//取得甲板的入住人数的上限和下限
				foreach((array)$products_radio_array as $key => $val){
					$sql = tep_db_query('SELECT max_per_of_guest, min_num_guest FROM  `cruises_cabin_deck` WHERE products_options_values_id="'.$val['id'].'" LIMIT 1');
					$row = tep_db_fetch_array($sql);
					if($row['min_num_guest']>0){
						$products_radio_array[$key]['min_num_guest'] = $row['min_num_guest'];
					}else{
						$products_radio_array[$key]['min_num_guest'] = $product_info['min_num_guest'];
					}
					if($row['max_per_of_guest']>0){
						$products_radio_array[$key]['max_per_of_guest'] = $row['max_per_of_guest'];
					}else{
						$products_radio_array[$key]['max_per_of_guest'] = $product_info['maximum_no_of_guest'];
					}
					
					//去掉产品属性选项值中 升级价格 的字眼
					$products_radio_array[$key]['text'] = str_replace(' (' .TEXT_HEADING_PRODUCT_ATTRIBUTE_SPECIAL_PRICE. ') ','',$products_radio_array[$key]['text']);
				}
				
				$cruises_products_options[] = array('id'=> $products_options_name['products_options_id'], 'text'=> $products_options_name['products_options_name'], 'products_options_value_obj'=>$products_radio_array);
			
			}else{
				
				$dis_buy_steps_2_products_options_name .= '<div>';
				$dis_buy_steps_2_products_options_name .= '<div class="conTitle" id="ConTitle_ProductsOptions'.$products_options_name['products_options_id'].'">';
				$dis_buy_steps_2_products_options_name .= '<h2>' . db_to_html($products_options_name['products_options_name'] . "：");
				if( $show_attr_themepark_note  == true && preg_match("/,".(int)$HTTP_GET_VARS['products_id'].",/i", ",".TOUR_IDS_FOR_ATTR_THEME_PARK_NOTE.",")){
					$dis_buy_steps_2_products_options_name .= '<a class="tipslayer sp3"  href="JavaScript:void(0)">[?]<span style="float:left; text-align:left;">'.ATTR_THEME_PARK_POP_TXT.'</span></a>';
				}
				$dis_buy_steps_2_products_options_name .= ' <a id="ConTitleA_ProductsOptions'.$products_options_name['products_options_id'].'" href="javascript:; " >' . db_to_html("可选择") . '</a></h2>';
				$dis_buy_steps_2_products_options_name .= '<div id="Close_ProductsOptions'.$products_options_name['products_options_id'].'" class="close timeClose" style="display: none;"><a href="javascript:void(0);"></a></div>';
				$dis_buy_steps_2_products_options_name .= '<div id="ProductsOptions' . $products_options_name['products_options_id'] . '" class="choosePop placePop" >';
				// */

				$dis_buy_steps_2_products_options_name .= '<table cellspacing="0" cellpadding="0"><tbody>';
				$radio_loop = 0;
				foreach($products_radio_array as $val){
					$radio_loop++;
					$selected_attribute = true;
					if($radio_loop>1){
						$selected_attribute = false;
					}
					$dis_buy_steps_2_products_options_name .= '<tr onmouseout="jQuery(this).removeClass(&quot;trHover&quot;)" onmouseover="jQuery(this).addClass(&quot;trHover&quot;)" onclick="jQuery(&quot;#radioid_' . $products_options_name['products_options_id'].'__'.$val['id'].'&quot;).attr(&quot;checked&quot;,true); onclick_products_options(this); '.($is_has_priority_attribute == 1 ? 'show_priority_mail_date('.$val['id'].');' : '').'"><td><span class="timeS">'.tep_draw_radio_field('id[' . $products_options_name['products_options_id'] . ']', $val['id'], $selected_attribute, 'id="radioid_' . $products_options_name['products_options_id'].'__'.$val['id'].'" onchange="'.($is_has_priority_attribute == 1 ? 'show_priority_mail_date(this.value);' : '').'"').'<em id="id_' . $products_options_name['products_options_id'].'__'.$val['id'].'" >'.$val['text'].'</em></span></td></tr>';
				}

				$dis_buy_steps_2_products_options_name .= '</tbody></table>';
				//PCC黄石公园团含餐说明的修改建议
				if(preg_match('/黄石/', $product_info['products_name']) && substr(trim($products_options_name['products_options_name']),0,4)=="餐食"){
					/**
			 * 关于中文站PCC黄石团“立即预订”栏目中[含餐说明]的技术优化说明
			 */
					$needupdate = array('LAPCC-YLS-6','LVPCC-YLS-6','SLCPCC-YGL-6','LAPCC-MRB-6','LVPCC-MRB-6','LAPCC-YGL-4','LVPCC-YGL-4','LAPCC-YLS-5','SLCPCC-DTP-5','DENPCC-DEN-5','LAPCC-YLS-7','LAPCC-YGL-7','LVPCC-MRB-7','DENPCC-DEN-7','SLCPCC-DTP-7','LAPCC-MRB-8');
					if(in_array($product_info['provider_tour_code'],$needupdate)){
						$dis_buy_steps_2_products_options_name .= db_to_html('<div style="padding:5px; background:#fafafa; border-bottom:1px dashed #ddd; line-height:18px;"><b style="color:#FF8302;">含餐说明：</b>整个行程提供包括中式美食佳肴、中西式海鲜自助餐、西部风味烤肉餐、美式精美套餐等种类的午餐/晚餐。</div>');
					}else{
						$dis_buy_steps_2_products_options_name .= db_to_html('<div style="padding:5px; background:#fafafa; border-bottom:1px dashed #ddd; line-height:18px;"><b style="color:#FF8302;">含餐说明：</b>整个行程共提供4餐(1午餐/3 晚餐) ，其中包括中式美食佳肴、中西式海鲜自助餐、西部风味烤肉餐、
美式精美套餐等。</div>');
					}
				}
				$dis_buy_steps_2_products_options_name .= '<div class="submit btnCenter"><a onclick="SetShowSteps2(' . $products_options_name['products_options_id'] . ');" href="javascript:;" class="btn btnOrange"><button type="button">' . db_to_html('确 定') . '</button></a><a href="javascript:void(0);" class="btn btnGrey"><button type="button">'.db_to_html('取 消').'</button></a></div>';
				$dis_buy_steps_2_products_options_name .= '</div>';

				$dis_buy_steps_2_products_options_name .= '</div>';
				$dis_buy_steps_2_products_options_name .= '<div id="TextBox_ProductsOptions' . $products_options_name['products_options_id'] . '" onclick="SetPopBox(&quot;ProductsOptions' . $products_options_name['products_options_id'] . '&quot;);" class="place">&nbsp;&nbsp;</div>';
				$dis_buy_steps_2_products_options_name .= '</div>';

				if($is_has_priority_attribute == 1){ //check if has priority attribute
					$div_priority_mail_date_field_style = 'style="display:none;"';
					if($selected_attribute == PRIORITY_MAIL_PRODUCTS_OPTIONS_ID){
						$div_priority_mail_date_field_style = '';
					}
					$dis_buy_steps_2_products_options_name .= '<div id="div_priority_mail_date_field" '.$div_priority_mail_date_field_style.'>';
					$dis_buy_steps_2_products_options_name .= '<div>
					<div class="conTitle"><h2>'. TXT_PRIORITY_MAIL_TICKET_NEEDED_DATE .'</h2></div><br />'.tep_draw_input_field('priority_mail_ticket_needed_date', tep_db_prepare_input(''), 'autocomplete="off" style="width: 120px; height: 16px; font-size: 12px; text-decoration: none; color:#223D6A;  margin-top:3px; padding:2px 0px 2px 5px; background:url('.DIR_WS_TEMPLATE_IMAGES.'time-selction.gif) no-repeat right center #FFFFFF;" id="priority_mail_ticket_needed_date" size="10" onclick="GeCalendar.SetUnlimited(0); GeCalendar.SetDate(this);" class="required" title="'.TEXT_DATE_ERROR.'"').'
					<div class="sp1"><span style="color:#f7860f">'.TEXT_SELECT_PRIORITY_MAIL_DATE_NOTE.'</span></div>
			</div>';

					if($product_info['agency_id'] == 89){

						$dis_buy_steps_2_products_options_name .= '<div>
				<div class="conTitle"><h2>'. TXT_PRIORITY_MAIL_DELIVERY_ADDRESS.'</h2></div><br />'.tep_draw_input_field('priority_mail_delivery_address', '', 'style="width: 178px;" id="priority_mail_delivery_address"').'
				<div class="sp1"><span style="color:#f7860f">'. TXT_PRIORITY_MAIL_DELIVERY_ADDRESS_NOTE.'</span></div>
			</div>';

						$dis_buy_steps_2_products_options_name .= '<div>
				<div class="conTitle"><h2>'. TXT_PRIORITY_MAIL_RECIPIENT_NAME.'</h2></div><br />'.tep_draw_input_field('priority_mail_recipient_name', '', 'style="width: 178px;" id="priority_mail_recipient_name"').'</div>';
					}
					$dis_buy_steps_2_products_options_name .= '</div>';
				}

			} //end check if has priority attribute


			if ($dis_buy_steps_2 != true) {
				$dis_buy_steps_2 == true; //中间显示第二步的标记，如果此变量不为true，那么最后一步的选择房间人数那里就应该是第2步。
			}

		}
		//邮轮团产品选项 Howard added
		if(is_array($cruises_products_options)){
		/**
		* 此文件需要从当前取得$cruises_products_options，$_GET['products_id']值，里面最关键的是甲板的单选按钮，要与普通产品选项值的单选按钮的格式一致。
		* 返回$dis_buy_steps_2_products_options_name
		**/
			$includeSource = 'product_info';
			include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'product_info_options_for_cruises.php');
		}
	}

	//汇率附加费 等产品选项 end
	//show product options end
	/////////////////////////////product_info_module_right_1.php和product_info_module_right_3.php均用到的代码 end
} else {
	//无产品时
	$not_found_product_message = TEXT_PRODUCT_NOT_FOUND;
}


//接送时间和地点 start
$departure_query_address = "select departure_id,departure_time from " . TABLE_PRODUCTS_DEPARTURE . " where  products_id = " . (int) $_GET['products_id'] . "  order by departure_time desc";
$departure_row_address = tep_db_query($departure_query_address);
$totaldipacount = tep_db_num_rows($departure_row_address);
while ($departure_result_address = tep_db_fetch_array($departure_row_address)) {
	$len = strlen($departure_result_address['departure_time']);
	if ($len == 6) {
		$depart_final = '0' . $departure_result_address['departure_time'];
	} else {
		$depart_final = $departure_result_address['departure_time'];
	}
	$depart_final = trim($depart_final);
	if (strstr($depart_final, 'pm')) {
		$pma[$departure_result_address['departure_id']] = $departure_result_address['departure_time'] . '##' . $departure_result_address['departure_id'];
	}
	if (strstr($depart_final, 'am')) {
		$ama[$departure_result_address['departure_id']] = $departure_result_address['departure_time'] . '##' . $departure_result_address['departure_id'];
	}
	////////////////////////
}

//stort array start
if ($ama != '') {
	array_multisort($ama, SORT_ASC, SORT_STRING);
}
if ($pma != '') {
	array_multisort($pma, SORT_ASC, SORT_STRING);
}
//shor array end
///new added for check more than 10 start

if ($ama != '' && $pma != '') {
	$final_departure_array_result = array_merge((array) $ama, (array) $pma);
} else if ($ama != '' && $pma == '') {
	$final_departure_array_result = $ama;
} else if ($ama == '' && $pma != '') {
	$final_departure_array_result = $pma;
}
//接送时间和地点 end

//howard added yellow table notes start
//显示旅游团的剩余座位
$show_yellow_table_notes = false;
$qry_remaining_seats = "SELECT products_id FROM products_remaining_seats as prs WHERE prs.products_id = '".(int)$_GET['products_id']."' limit 1";
$res_remaining_seats = tep_db_query($qry_remaining_seats);
$num_date = 0;
$ajax_array = '';

if(is_array($array_avaliabledate_store)){
	$array_avaliabledate_store = remove_soldout_dates((int)$_GET['products_id'], $array_avaliabledate_store);
	array_multisort($array_avaliabledate_store,SORT_ASC);
	foreach($array_avaliabledate_store as $avaliabledate_key=>$avaliabledate_val){
		$date_split = substr($avaliabledate_val,0,10);
		$departure_date_prs[$num_date] = $date_split;
		$ajax_array.=$date_split.'|';
		$num_date++;

		$first_date = date("Y-m-d H:i:s", strtotime(substr($avaliabledate_val,0,10)));
		if($first_date >= date('Y-m-d',strtotime($Today_date))){
			$product_info['FirstDate'] = $first_date;
			break;
		}
	}
}

if(tep_db_num_rows($res_remaining_seats)&&$departure_date_prs!=null){
	$show_yellow_table_notes = true;
}
//howard added yellow table notes end

//让走四方联系我
include(DIR_FS_CLASSES.'tff_contact_me.php');
$TffContactMe = new tff_contact_me;
$TffContactMe->post();

//SEO优化 所属分类 start
$seo_parent_cats = array();
//设置套餐团或短期团参数
if($product_info['products_durations_type']=="0" && $product_info['products_durations']>=TOURS_PACKAGE_MIN_DAY_NUM){
	$seo_parent_cats_get = '&mnu=vcpackages';
}else{
	$seo_parent_cats_get = '&mnu=tours';
}

$seo_cats_sql = tep_db_query("select p2c.categories_id, cd.categories_name from products_to_categories p2c, categories_description cd, categories c where p2c.products_id ='" . (int)$_GET['products_id'] . "' and cd.categories_id=p2c.categories_id and language_id='1' and c.categories_status='1' and c.categories_id=p2c.categories_id and c.parent_id>0 Group By p2c.categories_id");
while($seo_cats_rows = tep_db_fetch_array($seo_cats_sql)){
	if($seo_cats_rows['categories_id']!=$current_category_id){
		$seo_parent_cats[] = $seo_cats_rows;
	}
}
//SEO优化 所属分类 end

//新团购判断 start {
//广告基数--每个团的默认已经购人数
$ban_purchasedNum = array();
$ban_purchasedNum[1989] = 11;
$ban_purchasedNum[1990] = 8;
$ban_purchasedNum[1991] = 9;
$ban_purchasedNum[1992] = 7;

$TodayTime = strtotime($Today_date);
$product_info['GroupBuyType'] = is_group_buy_product($product_info['products_id']);
$product_info['purchasedNum'] = 100;
if((int)$product_info['GroupBuyType']){
	$sql = tep_db_query('SELECT s.start_date, s.expires_date, s.specials_max_buy_num, s.remaining_num FROM specials s WHERE s.products_id ="'.(int)$product_info['products_id'].'" ');
	$row = tep_db_fetch_array($sql);
	if($product_info['GroupBuyType']=="1"){
		$product_info['purchasedNum'] = tep_get_product_orders_guest_count($product_info['products_id'],$row['start_date'],$row['expires_date']);
		//如果已经人数少于20则在此基础加20人，相当于做广告
		if($product_info['purchasedNum']<20){
			$product_info['purchasedNum'] += $ban_purchasedNum[(int)$product_info['products_id']];
		}
		$balanceNum = max(0,(int)($row['specials_max_buy_num']-$product_info['purchasedNum']));
		//如果产品部有手工更新则以产品部的设置为准
		if($row['remaining_num']!=""){
			$balanceNum = $row['remaining_num'];
		}

		$product_info['orderNumMsn'] = '限<b>'.$row['specials_max_buy_num'].'</b>人&nbsp;&nbsp;还剩<b class="green">'.$balanceNum.'</b>人！';

		$product_info['CountdownEndTime'] = min((strtotime($product_info['FirstDate'])+86400),strtotime($row['expires_date'])) -$TodayTime;
	}elseif($product_info['GroupBuyType']=="2"){
		$product_info['purchasedNum'] = tep_get_product_orders_guest_count($product_info['products_id'],'',$Today_date);
		//如果已经人数少于20则在此基础加20人，相当于做广告
		if($product_info['purchasedNum']<20){
			$product_info['purchasedNum'] += 20;
		}
		$product_info['orderNumMsn'] = '<b>'.$product_info['purchasedNum'].'</b>人已经成功预订！';
		$product_info['CountdownEndTime'] = strtotime($row['expires_date'])-$TodayTime;
		if(!(int)strtotime($row['expires_date'])){
			$product_info['CountdownEndTime'] = strtotime($product_info['FirstDate'])+86400-$TodayTime;
		}
	}
	if(tep_not_null($SaveNumStr)){
		$products_price = str_replace('<del>','<del>'.db_to_html('<font style="font-family:\5b8b\4f53;">原价：</font>'),$products_price);
		$products_price = str_replace('<b>','<b class="group"><span>'.db_to_html('<font style="font-family:\5b8b\4f53;">团购价：</font></span>'),$products_price);
		$products_price = preg_replace('/\<\/p\>$/','',$products_price);

		$products_price .= "</p><p style=\"padding-bottom:10px;\"><span>".db_to_html('优惠：')."<font style=\"font-family:Tahoma;\">".$SaveNumStr."</font>";
		$products_price .= "</p>";
	}

	//处理导航栏的问题 {
	unset($breadcrumb->_trail);
	$breadcrumb->add(db_to_html('首页'), tep_href_link('index.php'));
	$breadcrumb->add(db_to_html('团购'), tep_href_link('group_buys.php'));

	$n = sizeof($breadcrumb->_trail);
	$breadcrumb->_trail[1] = $breadcrumb->_trail[($n-1)];
	if($product_info['GroupBuyType']=="1"){
		$tmp = '限量团';
	}elseif($product_info['GroupBuyType']=="2"){
		$tmp = '限时团';
	}
	$breadcrumb->add(db_to_html($tmp), tep_href_link('group_buys.php','gb_type='.$product_info['GroupBuyType']));
	$breadcrumb->add(db_to_html($product_info['products_model']), tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_info['products_id']));
	//处理导航栏的问题 }

}
//新团购判断 end }

//载入手工关联的产品类 Howard added 2012-10-13
require('includes/classes/products_expand/manualRelatedProducts.php');
$manualRelatedProducts = new manualRelatedProducts((int)$_GET['products_id']);
$manualRelatedProductsInfo = $manualRelatedProducts->getManualRelatedInfo();
//$manualRelatedProducts->inputManualRelated((int)$_GET['products_id'], '选乐园：', '53=>迪斯尼乐园;2387=>洛杉矶市区游;2388=>棕榈泉');

//JS快速切换页面开关
$display_fast = false;
if(defined('USE_JS_SHOW_PRODUCT_DETAIL_CONTENT') && USE_JS_SHOW_PRODUCT_DETAIL_CONTENT=='true'){
	$display_fast = true;
}

//
if(tep_not_null($not_found_product_message)){
	$content = 'product_info';
	//echo $not_found_product_message;
	//exit;
}

$javascript_external = $content . '.js';
//浏览所有 情况下 设置面包屑导航 vincent 2011.3.30
switch($_GET['seeAll']){
	case 'all-questions':$breadcrumb->add(db_to_html('所有咨询'), '');break;
	case 'all-reviews':$breadcrumb->add(db_to_html('所有评论'), '');break;
	case 'all-photos':$breadcrumb->add(db_to_html('所有照片'), '');break;
	default:{}
}

$js_get_parameters[] = 'content='.$content;
$js_get_parameters[] = 'products_id='.$products_id;

require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

require(DIR_FS_INCLUDES . 'application_bottom.php');
//echo $_SQL_QUERY_NUM;显示本页面的sql查询次数
?>

<?php
/*
$Id: ot_coupon.php,v 1.4 2004/03/09 17:56:06 ccwjr Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 osCommerce

Released under the GNU General Public License
*/
/**
 * �Ż�ȯ���ۿ�ȯ����
 * @package 
 */

class ot_coupon {
	var $title, $output;

	function ot_coupon() {

		$this->code = 'ot_coupon';
		$this->header = MODULE_ORDER_TOTAL_COUPON_HEADER;
		$this->title = MODULE_ORDER_TOTAL_COUPON_TITLE;
		$this->description = MODULE_ORDER_TOTAL_COUPON_DESCRIPTION;
		$this->user_prompt = '';
		$this->enabled = MODULE_ORDER_TOTAL_COUPON_STATUS;
		$this->sort_order = MODULE_ORDER_TOTAL_COUPON_SORT_ORDER;
		$this->include_shipping = MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING;
		$this->include_tax = MODULE_ORDER_TOTAL_COUPON_INC_TAX;
		$this->calculate_tax = MODULE_ORDER_TOTAL_COUPON_CALC_TAX;
		$this->tax_class  = MODULE_ORDER_TOTAL_COUPON_TAX_CLASS;
		$this->credit_class = true;
		$this->output = array();

	}
	/**
	 * �Ż�ȯִ�й���
	 *
	 */
	function process() {
		global $PHP_SELF, $order, $currencies, $customer_id ,$osCsid;
		$order_total=$this->get_order_total();
		$od_amount = $this->calculate_credit($order_total);
		//changes for ICW 510b
		$tod_amount = 0.0; //Fred
		$this->deduction = $od_amount;
		if ($this->calculate_tax != 'None') { //Fred - changed from 'none' to 'None'!
			$tod_amount = $this->calculate_tax_deduction($order_total, $this->deduction, $this->calculate_tax);
		}

		if ($od_amount > 0) {
			$order->info['total'] = $order->info['total'] - $od_amount;
			$this->output[] = array('title' => $this->title . ':' . $this->coupon_code .':','text' => '<b>-' . $currencies->format($od_amount) . '</b>', 'value' => $od_amount); //Fred added hyphen
			//Howard added ���Ż�ȯ��ʹ��ʱ��δ����״̬ʱ��ֱ�Ӱ����û������Ż�ȯ start
			tep_db_query('update coupons set restrict_to_customers="'.$customer_id.'" WHERE coupon_code = "'.$this->coupon_code.'" and (restrict_to_customers IS NULL || restrict_to_customers="") ');
			//Howard added ���Ż�ȯ��ʹ��ʱ��δ����״̬ʱ��ֱ�Ӱ����û������Ż�ȯ end
		}

		if (isset($_POST['gv_redeem_code_royal_customer_reward']) && $_POST['gv_redeem_code_royal_customer_reward']!='' && $_POST['gv_redeem_code_royal_customer_reward']==md5($osCsid.$customer_id)) {
			global $od_amount_royal;
			$od_amount_royal = ($order->info['total']*5)/100;
			$order->info['total'] = $order->info['total'] - $od_amount_royal;

			$this->output[] = array('title' =>   ' Royal Customer Reward :','text' => '<b><span class="productSpecialPrice">-' . $currencies->format($od_amount_royal) . '</span></b>', 'value' => $od_amount_royal); //Fred added hyphen
		}
	}
	//end change 510b
	function selection_test() {
		return false;
	}


	function pre_confirmation_check($order_total) {
		global $customer_id;
		return $this->calculate_credit($order_total);
	}

	function use_credit_amount() {
		return $output_string;
	}


	function credit_selection() {
		global $customer_id, $currencies, $language;
		$selection_string = '';
		$selection_string .= '<tr>' . "\n";
		$selection_string .= ' <td width="10">' .  tep_draw_separator('pixel_trans.gif', '10', '1') .'</td>';
		$selection_string .= ' <td class="main">' . "\n";
		//$image_submit = '<input type="image" name="submit_redeem" onclick="submitFunction()" src="' . DIR_WS_TEMPLATE_IMAGES.'buttons/' . $language . '/button_redeem.gif" style="border:0px;" alt="' . IMAGE_REDEEM_VOUCHER . '" title = "' . IMAGE_REDEEM_VOUCHER . '" />';
		$selection_string .= TEXT_ENTER_COUPON_CODE . tep_draw_input_field('gv_redeem_code') . '</td>';
		$selection_string .= ' <td align="right">' . $image_submit . '</td>';
		$selection_string .= ' <td width="10">' . tep_draw_separator('pixel_trans.gif', '10', '1') . '</td>';
		$selection_string .= '</tr>' . "\n";
		$selection_string .= '<tr><td>' . "\n";
		$selection_string .= tep_draw_separator('pixel_trans.gif', '1', '10'). "\n";
		$selection_string .= '</td></tr>' . "\n";
		return $selection_string;
	}

	/**
	 * �ռ�POST��Ϣ��������Ż�ȯ�Ƿ�������
	 * ��ajax����ͨ��ʽ�������ajax��ʽ�����$_POST['ajax'] == 'true' && $_POST['action'] == 'checkCouponCode'������
	 *
	 */
	function collect_posts() {
		global $messageStack, $customer_id, $currencies, $cc_id,$cart, $order;
		$affiliate_id = $_SESSION['affiliate_id'];
		$gvRedeemCode = tep_not_null($_POST['acc_gv_redeem_code']) ? $_POST['acc_gv_redeem_code'] : $_POST['gv_redeem_code'];
		$error_url = tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL');
		if (tep_not_null($gvRedeemCode)) {
			if($_POST['ajax'] == 'true' && ($_POST['action'] == 'checkCouponCode' || $_POST['action'] == 'submitCouponCode')){
				$check_method = 'ajax';
			}else {
				$check_method = 'general';
			}

			// get some info from the coupon table ICW change 5.10b
			$coupon_query=tep_db_query("select coupon_id, coupon_amount, coupon_type, coupon_minimum_order,uses_per_coupon, uses_per_user, restrict_to_products,restrict_to_categories, coupon_order_min_customers_num,check_email from " . TABLE_COUPONS . " where coupon_code='".$gvRedeemCode."' and coupon_active='Y'");

			$coupon_result=tep_db_fetch_array($coupon_query);

			if ($coupon_result['coupon_type'] != 'G') {	//����Ŀǰʹ�õ��Ż�ȯ����G����Ż�ȯ
				if(tep_not_null($_POST['customer_shopping_points_spending']) && strtolower(USE_COUPONS_TOO_CAN_USE_POINTS) != 'true'){	//���ϵͳ�����������Ż�ȯ�Ͳ����û��ֵĻ�������������ж�
					$error_string = db_to_html('�ܱ�Ǹ���������Ż�ȯ����ͬʱʹ�ã���ֻ��ʹ������һ���Żݡ�');
					if($check_method === 'ajax'){ echo $error_string; exit; }
					$messageStack->add_session('global', $error_string,'error');
					tep_redirect($error_url);
				}

				if (tep_db_num_rows($coupon_query)==0) {
					$error_string = ERROR_NO_INVALID_REDEEM_COUPON;
					if($check_method === 'ajax'){ echo $error_string; exit; }
					$messageStack->add_session('global', $error_string,'error');
					tep_redirect($error_url);
				}
				// howard added check customers number
				if((int)$coupon_result['coupon_order_min_customers_num']){
					$customers_num = 0;
					foreach($cart->contents as $key => $val){
						$customers_num += $cart->contents[$key]['roomattributes'][2];
					}
					if($_GET['order_id']){	//����Ǵ����ж���������Ҫ�Զ���������Ϊ׼
						$customers_num = 0;
						for ($i=0, $n=sizeof($order->products); $i<$n; $i++){
							$customers_num += sizeof(tep_get_orders_product_guest($order->products[$i]['orders_products_id']));
						}
					}
					if((int)$customers_num < (int)$coupon_result['coupon_order_min_customers_num']){
						$error_string = sprintf(ERROR_MIN_CUSTOMERS_NUM,$coupon_result['coupon_order_min_customers_num']);
						if($check_method === 'ajax'){ echo $error_string; exit; }
						$messageStack->add_session('global', $error_string,'error');
						tep_redirect($error_url);
					}
				}

				// below line changed for ICW 5.10b
				$date_query=tep_db_query("select coupon_start_date from " . TABLE_COUPONS . " where coupon_start_date <= now() and coupon_code='".$gvRedeemCode."'");

				if (tep_db_num_rows($date_query)==0) {
					$error_string = ERROR_INVALID_STARTDATE_COUPON;
					if($check_method === 'ajax'){ echo $error_string; exit; }
					$messageStack->add_session('global', $error_string,'error');
					tep_redirect($error_url);
				}
				// below line changed for ICW 5.10b
				$date_query=tep_db_query("select coupon_expire_date from " . TABLE_COUPONS . " where coupon_expire_date >= now() and coupon_code='".$gvRedeemCode."'");

				if (tep_db_num_rows($date_query)==0) {
					$error_string = ERROR_INVALID_FINISDATE_COUPON;
					if($check_method === 'ajax'){ echo $error_string; exit; }
					$messageStack->add_session('global', $error_string,'error');
					tep_redirect($error_url);
				}
				//below two lines changed for ICW 5.10b
				$coupon_count = tep_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $coupon_result['coupon_id']."'");
				$coupon_count_customer = tep_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $coupon_result['coupon_id']."' and customer_id = '" . $customer_id . "'");

				if (tep_db_num_rows($coupon_count)>=$coupon_result['uses_per_coupon'] && $coupon_result['uses_per_coupon'] > 0) {
					$error_string = ERROR_INVALID_USES_COUPON . $coupon_result['uses_per_coupon'] . TIMES;
					if($check_method === 'ajax'){ echo $error_string; exit; }
					$messageStack->add_session('global', $error_string,'error');
					tep_redirect($error_url);
				}

				if (tep_db_num_rows($coupon_count_customer)>=$coupon_result['uses_per_user'] && $coupon_result['uses_per_user'] > 0) {
					$error_string = ERROR_INVALID_USES_USER_COUPON . $coupon_result['uses_per_user'] . TIMES;
					if($check_method === 'ajax'){ echo $error_string; exit; }
					$messageStack->add_session('global', $error_string,'error');
					tep_redirect($error_url);
				}
				//Howard added ��������н�ֹʹ���ŻݵĲ�Ʒ start {
				if(defined('DISABLED_COUPON_PRODUCTS_IDS') && DISABLED_COUPON_PRODUCTS_IDS!=''){
					$without_products_ids = explode(',', DISABLED_COUPON_PRODUCTS_IDS);
					$pris = array_keys($cart->contents);
					for($i=0; $i<count($pris); $i++){
						if(in_array(tep_get_prid($pris[0]), $without_products_ids)){
							$error_string = db_to_html('�ܱ�Ǹ�����ڹ��ﳵ���в��μ��ۿ��ŻݵĲ�Ʒ������������ʹ�ô��Ż�ȯ:'.$gvRedeemCode.'���������ִζ�������');
							if($check_method === 'ajax'){ echo $error_string; exit; }
							$messageStack->add_session('global', $error_string,'error');
							tep_redirect($error_url);
							break;
						}
					}
				}

				//Howard added ��������н�ֹʹ���ŻݵĲ�Ʒ end }
				//Howard added ���������ƹ��õ��Ż�ȯ���� start {
				require_once(DIR_FS_CLASSES . 'affiliate.php');
				$_affiliate_id = (int)$affiliate_id ? $affiliate_id : $customer_id;
				$my_coupon_code = affiliate::couponCode($_affiliate_id);
				$is_suspicious = $this->checkSuspicious($gvRedeemCode, $customer_id, $order);	//�ж��Ż�ȯ�Ƿ��ǿ��ɵ�
				if (tep_not_null($gvRedeemCode) && strtolower(trim($gvRedeemCode)) == strtolower(trim($my_coupon_code))){
					$error_string = db_to_html('�ܱ�Ǹ��������ʹ���Լ���Coupon Code(�Ż���):'.$gvRedeemCode);
					if($check_method === 'ajax'){ echo $error_string; exit; }
					$messageStack->add_session('global', $error_string,'error');
					tep_redirect($error_url);
				}elseif($is_suspicious === true){
					$error_string = db_to_html('�Բ���������ʹ�ô�Coupon Code(�Ż���):'.$gvRedeemCode);
					if($check_method === 'ajax'){ echo $error_string; exit; }
					$messageStack->add_session('global', $error_string,'error');
					tep_redirect($error_url);

				}elseif (tep_not_null($gvRedeemCode)){	//�����Ż���ȡ���ƹ��˵�ID����¼��session��cookie
					$_id = affiliate::getAffiliateIdFromCouponCode($gvRedeemCode);
					if((int)$_id){
						//if(isset($_SESSION['affiliate_ref'])){
						//tep_session_unregister('affiliate_ref');
						//}
						$affiliate_ref = $_id;
						$_SESSION['affiliate_ref'] = $affiliate_ref;
						//tep_session_register('affiliate_clickthroughs_id');
						setcookie('affiliate_ref', $affiliate_ref, time() + AFFILIATE_COOKIE_LIFETIME);
					}
				}

				if($coupon_result['coupon_minimum_order']>0){	//�����ܶ�����������ʱ�ļ��
					$_total_value = $cart->show_total();
					if((int)$order->info['total_value']){
						$_total_value = $order->info['total_value'];
					}
					if($coupon_result['coupon_minimum_order'] > $_total_value ){
						$error_string = db_to_html('�ܱ�Ǹ����ȯ:'.$gvRedeemCode.'����Ͷ����޶�Ϊ��'.$currencies->format($coupon_result['coupon_minimum_order']));
						if($check_method === 'ajax'){ echo $error_string; exit; }
						$messageStack->add_session('global', $error_string,'error');
						tep_redirect($error_url);
						break;
					}
				}
				//Howard added ���������ƹ��õ��Ż�ȯ���� end }

				if ($coupon_result['coupon_type']=='S') {	//S�Ǵ�������ѵ��Ż�ȯ
					$coupon_amount = $order->info['shipping_cost'];
				} else {
					$coupon_amount = $currencies->format($coupon_result['coupon_amount']) . ' ';
				}
				if ($coupon_result['coupon_type']=='P') $coupon_amount = $coupon_result['coupon_amount'] . '% ';
				if ($coupon_result['coupon_minimum_order']>0) $coupon_amount .= 'on orders greater than ' . $coupon_result['coupon_minimum_order'];
				if (!tep_session_is_registered('cc_id')) tep_session_register('cc_id'); //Fred - this was commented out before
				$cc_id = $coupon_result['coupon_id']; //Fred ADDED, set the global and session variable
				// $_SESSION['cc_id'] = $coupon_result['coupon_id']; //Fred commented out, do not use $_SESSION[] due to backward comp. Reference the global var instead.
			}
			if ($_POST['submit_redeem_coupon_x'] && !$gvRedeemCode){
				$error_string = ERROR_NO_REDEEM_CODE;
				if($check_method === 'ajax'){ echo $error_string; exit; }
				$messageStack->add_session('global', $error_string,'error');
				tep_redirect($error_url);
			}
			
			if(''!=$coupon_result['check_email']){//����EMAIL��β��Ǽ��  start{
				$temp_result=true;
				$arr_tmp=explode(',', $coupon_result['check_email']);
				$customer_email=$_SESSION['customer_email_address'];
				$customer_len=strlen($customer_email);
				foreach($arr_tmp as $value){
					$temp_len=strlen($value);
					$str_tmp=substr($customer_email, $customer_len-$temp_len,$customer_len);
					if($value==$str_tmp&&$value!=''){
						$temp_result=false;
						break;
					}
				}
				//var_dump($temp_result);
				if($temp_result){
					tep_session_unregister('cc_id');
					$error_string=db_to_html('�ܱ�Ǹ���������䲻��'.$coupon_result['check_email'].'��β������');
					if($check_method === 'ajax'){ echo $error_string; exit; }
					$messageStack->add_session('global', $error_string,'error');
					tep_redirect($error_url);
				}
			}
			//����EMAIL��β��Ǽ��  end}
			
			//���ݿ��ò�Ʒ��Ŀ¼�ж��Ż�ȯ start {
			if($coupon_result['restrict_to_products'] || $coupon_result['restrict_to_categories']){
				$pass_products_categories = false;
				$restrict_to_products_array = split("[,]", $coupon_result['restrict_to_products']);
				$restrict_to_categories_array = split("[,]", $coupon_result['restrict_to_categories']);
				for ($i=0; $i<sizeof($order->products); $i++) {
					$current_products_id = tep_get_prid($order->products[$i]['id']);
					if(in_array($current_products_id, $restrict_to_products_array)){
						$pass_products_categories = true;
						break;
					}else{
						$tmp_sql = tep_db_query("select p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = '" . $current_products_id . "' and p.products_status = '1' and p.products_id = p2c.products_id ");
						while($tmp_rows = tep_db_fetch_array($tmp_sql)){
							if((int)$tmp_rows['categories_id'] && in_array($tmp_rows['categories_id'], $restrict_to_categories_array) ){
								$pass_products_categories = true;
								break;
							}
						}
					}
				}
				if($pass_products_categories !== true){
					tep_session_unregister('cc_id');
					$error_string=db_to_html('�ܱ�Ǹ�����Ż�ȯ����������Щ�г̣�');
					if($check_method === 'ajax'){ echo $error_string; exit; }
					$messageStack->add_session('global', $error_string,'error');
					tep_redirect($error_url);
				}
			}
			//���ݿ��ò�Ʒ��Ŀ¼�ж��Ż�ȯ end }
			
		}
	}

	/**
	 * �����ŻݵĽ����ֵ
	 *
	 * @param unknown_type $amount
	 * @return unknown
	 */
	function calculate_credit($amount) {
		global $customer_id, $order, $cc_id, $cart;
		//$cc_id = $_SESSION['cc_id']; //Fred commented out, do not use $_SESSION[] due to backward comp. Reference the global var instead.
		$od_amount = 0;	//��ʼ�������Żݵ�ֵ
		if (isset($cc_id) ) {
			$coupon_query = tep_db_query("select coupon_code from " . TABLE_COUPONS . " where coupon_id = '" . $cc_id . "'");
			if (tep_db_num_rows($coupon_query) !=0 ) {
				$coupon_result = tep_db_fetch_array($coupon_query);
				$this->coupon_code = $coupon_result['coupon_code'];
				$coupon_get = tep_db_query("select coupon_amount, coupon_minimum_order, restrict_to_products, restrict_to_categories, coupon_type from " . TABLE_COUPONS ." where coupon_code = '". $coupon_result['coupon_code'] . "'");
				$get_result = tep_db_fetch_array($coupon_get);
				$c_deduct = $get_result['coupon_amount'];	//����Ҫ�Żݵ�ֵ��������ʵ��Ҳ�����ǰٷ�����
				if ($get_result['coupon_type']=='S') $c_deduct = $order->info['shipping_cost'];
				if (($get_result['coupon_minimum_order'] <= $this->get_order_total()) || $this->get_order_total()<1) {
					if ($get_result['restrict_to_products'] || $get_result['restrict_to_categories']) {
						//////ָ���˲�Ʒ��Ŀ¼���Żݷ���
						
						for ($i=0; $i<sizeof($order->products); $i++) {
							$current_products_id = tep_get_prid($order->products[$i]['id']);

							if ($get_result['restrict_to_products']) {
								$pr_ids = split("[,]", $get_result['restrict_to_products']);
								if(in_array($current_products_id, (array)$pr_ids) && $get_result['coupon_type'] == 'P'){
									$pr_c = $order->products[$i]['final_price']*$order->products[$i]['qty'];
									$pod_amount = round($pr_c*10)/10*$c_deduct/100;
									$od_amount = $od_amount + $pod_amount;
								} else {
									$od_amount = $c_deduct;
								}

							} else {
								$cat_ids = split("[,]", $get_result['restrict_to_categories']);
								$my_path = tep_get_product_path($current_products_id);
								$tmp_var = false;

								$sub_cat_ids = split("[_]", $my_path);
								for ($iii = 0; $iii < count($sub_cat_ids); $iii++) {
									for ($ii = 0; $ii < count($cat_ids); $ii++) {

										if ($sub_cat_ids[$iii] == $cat_ids[$ii]) {
											$tmp_var = true;
										}else{
											//howard added exp cate
											$tmp_sql = tep_db_query("select p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = '" . $current_products_id . "' and p.products_status = '1' and p.products_id = p2c.products_id ");
											while($tmp_rows = tep_db_fetch_array($tmp_sql)){
												if($tmp_rows['categories_id']==$cat_ids[$ii] && (int)$tmp_rows['categories_id']){
													$tmp_var = true;
													break;
												}
											}
											//howard added exp cate end
										}

									}
								}

								if($tmp_var == true){
									if ($get_result['coupon_type'] == 'P') {

										$pr_c = $order->products[$i]['final_price']*$order->products[$i]['qty'];

										$pod_amount = round($pr_c*10)/10*$c_deduct/100;
										$od_amount = $od_amount + $pod_amount;

									} else {
										$od_amount = $c_deduct;
									}
								}

							}
						}

					} else {
						//////��ָ���Żݲ�Ʒ��Ŀ¼���Żݷ���
						if ($get_result['coupon_type'] =='P') {
							$od_amount = $amount * $get_result['coupon_amount'] / 100;
						} else {
							$od_amount = $c_deduct;
						}
					}
				}
			}
			if ($od_amount>$amount) $od_amount = $amount;
		}
		return $od_amount;
	}

	/**
	 * �����Ż�ȯ�۳��Ľ����(��˰)
	 *
	 * @param unknown_type $amount
	 * @param unknown_type $od_amount
	 * @param unknown_type $method
	 * @return unknown
	 */
	function calculate_tax_deduction($amount, $od_amount, $method) {
		global $customer_id, $order, $cc_id, $cart;
		//$cc_id = $_SESSION['cc_id']; //Fred commented out, do not use $_SESSION[] due to backward comp. Reference the global var instead.
		$coupon_query = tep_db_query("select coupon_code from " . TABLE_COUPONS . " where coupon_id = '" . $cc_id . "'");
		if (tep_db_num_rows($coupon_query) !=0 ) {
			$coupon_result = tep_db_fetch_array($coupon_query);
			$coupon_get = tep_db_query("select coupon_amount, coupon_minimum_order, restrict_to_products, restrict_to_categories, coupon_type from " . TABLE_COUPONS . " where coupon_code = '". $coupon_result['coupon_code'] . "'");
			$get_result = tep_db_fetch_array($coupon_get);
			if ($get_result['coupon_type'] != 'S') {
				//RESTRICTION--------------------------------
				if ($get_result['restrict_to_products'] || $get_result['restrict_to_categories']) {
					// What to do here.
					// Loop through all products and build a list of all product_ids, price, tax class
					// at the same time create total net amount.
					// then
					// for percentage discounts. simply reduce tax group per product by discount percentage
					// or
					// for fixed payment amount
					// calculate ratio based on total net
					// for each product reduce tax group per product by ratio amount.
					$products = $cart->get_products();
					//below line added for
					$valid_product = false;
					for ($i=0; $i<sizeof($products); $i++) {
						$valid_product = false;
						$t_prid = tep_get_prid($products[$i]['id']);
						$cc_query = tep_db_query("select products_tax_class_id from " . TABLE_PRODUCTS . " where products_id = '" . $t_prid . "'");
						$cc_result = tep_db_fetch_array($cc_query);
						$valid_product = false;
						if ($get_result['restrict_to_products']) {
							$pr_ids = split("[,]", $get_result['restrict_to_products']);
							for ($p = 0; $p < sizeof($pr_ids); $p++) {
								if ($pr_ids[$p] == $t_prid) $valid_product = true;
							}
						}
						if ($get_result['restrict_to_categories']) {
							$cat_ids = split("[,]", $get_result['restrict_to_categories']);
							for ($c = 0; $c < sizeof($cat_ids); $c++) {
								$cat_query = tep_db_query("select products_id from products_to_categories where products_id = '" . $products_id . "' and categories_id = '" . $cat_ids[$i] . "'");
								if (tep_db_num_rows($cat_query) !=0 ) $valid_product = true;
							}
						}
						if ($valid_product) {
							$price_excl_vat = $products[$i]['final_price'] * $products[$i]['quantity']; //Fred - added
							$price_incl_vat = $this->product_price($t_prid); //Fred - added
							$valid_array[] = array('product_id' => $t_prid, 'products_price' => $price_excl_vat, 'products_tax_class' => $cc_result['products_tax_class_id']); //jason //Fred - changed from $products[$i]['final_price'] 'products_tax_class' => $cc_result['products_tax_class_id']);
							//						$total_price += $price_incl_vat; //Fred - changed
							$total_price += $price_excl_vat; // changed
						}
					}
					if (sizeof($valid_array) > 0) { // if ($valid_product) {
						if ($get_result['coupon_type'] == 'P') {
							$ratio = $get_result['coupon_amount']/100;
						} else {
							$ratio = $od_amount / $total_price;
						}
						if ($get_result['coupon_type'] == 'S') $ratio = 1;
						if ($method=='Credit Note') {
							$tax_rate = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							$tax_desc = tep_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							if ($get_result['coupon_type'] == 'P') {
								$tod_amount = $od_amount / (100 + $tax_rate)* $tax_rate;
							} else {
								$tod_amount = $order->info['tax_groups'][$tax_desc] * $od_amount/100;
							}
							$order->info['tax_groups'][$tax_desc] -= $tod_amount;
							$order->info['total'] -= $tod_amount;
						} else {
							for ($p=0; $p<sizeof($valid_array); $p++) {
								$tax_rate = tep_get_tax_rate($valid_array[$p]['products_tax_class'], $order->delivery['country']['id'], $order->delivery['zone_id']);
								$tax_desc = tep_get_tax_description($valid_array[$p]['products_tax_class'], $order->delivery['country']['id'], $order->delivery['zone_id']);
								if ($tax_rate > 0) {
									$tod_amount[$tax_desc] += ($valid_array[$p]['products_price'] * $tax_rate)/100 * $ratio;
									$order->info['tax_groups'][$tax_desc] -= ($valid_array[$p]['products_price'] * $tax_rate)/100 * $ratio;
									$order->info['total'] -= ($valid_array[$p]['products_price'] * $tax_rate)/100 * $ratio;
								}
							}
						}
					}
					//NO RESTRICTION--------------------------------
				} else {
					if ($get_result['coupon_type'] =='F') {
						$tod_amount = 0;
						if ($method=='Credit Note') {
							$tax_rate = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							$tax_desc = tep_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							$tod_amount = $od_amount / (100 + $tax_rate)* $tax_rate;
							$order->info['tax_groups'][$tax_desc] -= $tod_amount;
						} else {
							//						$ratio1 = $od_amount/$amount;   // this produces the wrong ratipo on fixed amounts
							reset($order->info['tax_groups']);
							while (list($key, $value) = each($order->info['tax_groups'])) {
								$ratio1 = $od_amount/($amount-$order->info['tax_groups'][$key]); ////debug
								$tax_rate = tep_get_tax_rate_from_desc($key);
								$net = $tax_rate * $order->info['tax_groups'][$key];
								if ($net>0) {
									$god_amount = $order->info['tax_groups'][$key] * $ratio1;
									$tod_amount += $god_amount;
									$order->info['tax_groups'][$key] = $order->info['tax_groups'][$key] - $god_amount;
								}
							}
						}
						//below line changed for ICw 5.10b
						$order->info['total'] -= $tod_amount; //OLD
						$order->info['tax'] -= $tod_amount; //Fred - added

					}
					if ($get_result['coupon_type'] =='P') {
						$tod_amount=0;
						if ($method=='Credit Note') {
							$tax_desc = tep_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							$tod_amount = $order->info['tax_groups'][$tax_desc] * $od_amount/100;
							$order->info['tax_groups'][$tax_desc] -= $tod_amount;
						} else {
							reset($order->info['tax_groups']);
							while (list($key, $value) = each($order->info['tax_groups'])) {
								$god_amout=0;
								$tax_rate = tep_get_tax_rate_from_desc($key);
								$net = $tax_rate * $order->info['tax_groups'][$key];
								if ($net>0) {
									$god_amount = $order->info['tax_groups'][$key] * $get_result['coupon_amount']/100;
									$tod_amount += $god_amount;
									$order->info['tax_groups'][$key] = $order->info['tax_groups'][$key] - $god_amount;
								}
							}
						}// below line added for ICW 5.01b
						$order->info['total'] -= $tod_amount; // have to modify total also
						$order->info['tax'] -= $tod_amount;
					}
				}
			}
		}
		return $tod_amount;
	}

	function update_credit_account($i) {
		return false;
	}

	function apply_credit() {
		global $insert_id, $customer_id, $REMOTE_ADDR, $cc_id;
		//$cc_id = $_SESSION['cc_id']; //Fred commented out, do not use $_SESSION[] due to backward comp. Reference the global var instead.
		if ($this->deduction !=0) {
			tep_db_query("insert into " . TABLE_COUPON_REDEEM_TRACK . " (coupon_id, redeem_date, redeem_ip, customer_id, order_id) values ('" . $cc_id . "', now(), '" . $REMOTE_ADDR . "', '" . $customer_id . "', '" . $insert_id . "')");
		}
		tep_session_unregister('cc_id');
	}
	/**
	 * ȡ�ö����ܼ�
	 *
	 * @return unknown
	 */
	function get_order_total() {
		global  $order, $cart, $customer_id, $cc_id;
		//$cc_id = $_SESSION['cc_id']; //Fred commented out, do not use $_SESSION[] due to backward comp. Reference the global var instead.
		$order_total = is_numeric($order->info['total']) ? $order->info['total'] : $order->info['total_value'];
		// Check if gift voucher is in cart and adjust total
		$products = $cart->get_products();
		for ($i=0; $i<sizeof($products); $i++) {
			$t_prid = tep_get_prid($products[$i]['id']);
			$gv_query = tep_db_query("select products_price, products_tax_class_id, products_model from " . TABLE_PRODUCTS . " where products_id = '" . $t_prid . "'");
			$gv_result = tep_db_fetch_array($gv_query);
			if (ereg('^GIFT', addslashes($gv_result['products_model']))) {
				$qty = $cart->get_quantity($t_prid);
				$products_tax = tep_get_tax_rate($gv_result['products_tax_class_id']);
				if ($this->include_tax =='false') {
					$gv_amount = $gv_result['products_price'] * $qty;
				} else {
					$gv_amount = ($gv_result['products_price'] + tep_calculate_tax($gv_result['products_price'],$products_tax)) * $qty;
				}
				$order_total=$order_total - $gv_amount;
			}
		}
		if ($this->include_tax == 'false') $order_total=$order_total-$order->info['tax'];
		if ($this->include_shipping == 'false') $order_total=$order_total-$order->info['shipping_cost'];
		// OK thats fine for global coupons but what about restricted coupons
		// where you can only redeem against certain products/categories.
		// and I though this was going to be easy !!!
		$coupon_query=tep_db_query("select coupon_code  from " . TABLE_COUPONS . " where coupon_id='".$cc_id."'");
		if (tep_db_num_rows($coupon_query) >0) {
			$coupon_result=tep_db_fetch_array($coupon_query);
			$coupon_get=tep_db_query("select coupon_amount, coupon_minimum_order,restrict_to_products,restrict_to_categories, coupon_type from " . TABLE_COUPONS . " where coupon_code='".$coupon_result['coupon_code']."'");
			$get_result=tep_db_fetch_array($coupon_get);

			//����Ż�ȯָ����ʹ��Ŀ¼���Ҳ�Ʒ����ЩĿ¼�в�ʹ�ø�ȯ�Żݣ������¼Ƽ� start {
			$in_cat = true;
			if ($get_result['restrict_to_categories']) {
				$cat_ids = split("[,]", $get_result['restrict_to_categories']);
				$in_cat=false;
				for ($i = 0; $i < count($cat_ids); $i++) {
					if (is_array($this->contents)) {
						reset($this->contents);
						while (list($products_id, ) = each($this->contents)) {
							$cat_query = tep_db_query("select products_id from products_to_categories where products_id = '" . $products_id . "' and categories_id = '" . $cat_ids[$i] . "'");
							if (tep_db_num_rows($cat_query) >0 ) {
								$in_cat = true;
								$total_price += $this->get_product_price($products_id);
							}
						}
					}
				}
			}
			//����Ż�ȯָ����ʹ��Ŀ¼���Ҳ�Ʒ����ЩĿ¼�в�ʹ�ø�ȯ�Żݣ������¼Ƽ� end }
			//����Ż�ȯָ���˲�ƷID���Ҹò�Ʒ����ЩID�в�ʹ�ø�ȯ�Żݣ������¼Ƽ� start {
			$in_cart = true;
			if ($get_result['restrict_to_products']) {
				$pr_ids = split("[,]", $get_result['restrict_to_products']);
				$in_cart=false;
				$products_array = $cart->get_products();
				for ($i = 0; $i < sizeof($pr_ids); $i++) {
					for ($ii = 1; $ii<=sizeof($products_array); $ii++) {
						if (tep_get_prid($products_array[$ii-1]['id']) == $pr_ids[$i]) {
							$in_cart=true;
							$total_price += $this->get_product_price($products_array[$ii-1]['id']);
						}
					}
				}
				$order_total = $total_price;
			}
			//����Ż�ȯָ���˲�ƷID���Ҹò�Ʒ����ЩID�в�ʹ�ø�ȯ�Żݣ������¼Ƽ� end }
		}
		return $order_total;
	}
	/**
	 * ȡ�ö������ﳵ��ĳ����Ʒ�ļ۸�
	 *
	 * @param unknown_type $product_id
	 * @return unknown
	 */
	function get_product_price($product_id) {
		global $cart, $order;
		$products_id = tep_get_prid($product_id);
		// products price
		$qty = $cart->contents[$product_id]['qty'];
		$product_query = tep_db_query("select products_id, products_price, products_tax_class_id, products_weight from " . TABLE_PRODUCTS . " where products_id='" . $product_id . "'");
		if ($product = tep_db_fetch_array($product_query)) {
			$prid = $product['products_id'];
			$products_tax = tep_get_tax_rate($product['products_tax_class_id']);
			$products_price = $product['products_price'];
			$specials_query = tep_db_query("select specials_new_products_price from " . TABLE_SPECIALS . " where products_id = '" . $prid . "' and status = '1'");
			if (tep_db_num_rows ($specials_query)) {
				$specials = tep_db_fetch_array($specials_query);
				$products_price = $specials['specials_new_products_price'];
			}
			if ($this->include_tax == 'true') {
				$total_price += ($products_price + tep_calculate_tax($products_price, $products_tax)) * $qty;
			} else {
				$total_price += $products_price * $qty;
			}

			// attributes price
			if (isset($cart->contents[$product_id]['attributes'])) {
				reset($cart->contents[$product_id]['attributes']);
				while (list($option, $value) = each($cart->contents[$product_id]['attributes'])) {
					$attribute_price_query = tep_db_query("select options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $prid . "' and options_id = '" . $option . "' and options_values_id = '" . $value . "'");
					$attribute_price = tep_db_fetch_array($attribute_price_query);
					if ($attribute_price['price_prefix'] == '') {
						$attribute_price['price_prefix'] = '+';
					}
					if ($attribute_price['price_prefix'] == '+') {
						if ($this->include_tax == 'true') {
							$total_price += $qty * ($attribute_price['options_values_price'] + tep_calculate_tax($attribute_price['options_values_price'], $products_tax));
						} else {
							$total_price += $qty * ($attribute_price['options_values_price']);
						}
					} else {
						if ($this->include_tax == 'true') {
							$total_price -= $qty * ($attribute_price['options_values_price'] + tep_calculate_tax($attribute_price['options_values_price'], $products_tax));
						} else {
							$total_price -= $qty * ($attribute_price['options_values_price']);
						}
					}
				}
			}
		}
		if ($this->include_shipping == 'true') {
			$total_price += $order->info['shipping_cost'];
		}
		return $total_price;
	}

	/**
	 * �ж��û��ṩ���Ż�ȯ�Ƿ����
	 * ��1���Ż�ȯ���Ƽ�����ʹ���˵��û����ƣ�����������ͬʱ���ɣ�
	 * ��2�������Ĳ������������Ƽ��˵��û����ƣ�����������ͬʱ���ɣ�
	 * ��3�������µ������һ�ε�¼��IP���Ż�ȯ�Ƽ������һ�ε�¼��IP��ͬʱҲ���ɣ�
	 * @param string $coupon_code �Ż�ȯ����
	 * @param int $customers_id �û�id
	 * @param order $ordersObj ��������
	 * @return true|false ע��trueΪ����
	 */	
	public function checkSuspicious($coupon_code, $customers_id, order $ordersObj){
		include_once(DIR_FS_CLASSES . 'affiliate.php');
		if(!$ordersObj) return true;
		$customers_info = array_trim(tep_get_customers_info($customers_id));
		$affiliate_id = affiliate::getAffiliateIdFromCouponCode($coupon_code);	//��Ա��$affiliate_id����$customer_id����ȵ�
		$affiliate_info = array_trim(tep_get_customers_info($affiliate_id));
		$affiliate_info['customers_firstname'] = strtolower($affiliate_info['customers_firstname']);
		$affiliate_info['customers_lastname'] = strtolower($affiliate_info['customers_lastname']);		
		//��ʼ��һ�Ƚ�
		$contrast = array('customers_firstname', 'customers_lastname', 'customers_telephone', 'customers_cellphone', 'customers_fax', 'customers_info_register_ip', 'last_ip_address');
		$global_max_sim = 80;	//���ƶ�
		foreach ($contrast as $val){
			//���ƶ�>=80��������
			$max_sim = $global_max_sim;
			if(in_array($val,array('customers_info_register_ip', 'last_ip_address'))) $max_sim = 90;	//ip���ƶ�Ϊ90����
			if( similar_text(strtolower($customers_info[$val]), strtolower($affiliate_info[$val]), $sim) > 2 && $sim >= $max_sim ){
				return true;
			}
		}		
		//��ʼ�������������Ƚ�(����������ʱ)
		if(tep_not_null($ordersObj->products)){
			for ($i=0, $n=sizeof($ordersObj->products); $i<$n; $i++){
				$_g_names = tep_get_orders_product_guest($ordersObj->products[$i]['orders_products_id']);
				foreach ((array)$_g_names as $name ){
					$g_names = explode(',', tep_filter_guest_chinese_name($name));
					$name0 = strtolower(preg_replace('/[[:space:]]+/','',$g_names[0].$g_names[1]));
					$name1 = strtolower(preg_replace('/[[:space:]]+/','',$g_names[1].$g_names[0]));
					if( similar_text(strtolower($name0), strtolower($affiliate_info['customers_firstname']), $sim) > 2 && $sim >= $global_max_sim ){
						return true;
					}
					if( similar_text(strtolower($name1), strtolower($affiliate_info['customers_firstname']), $sim) > 2 && $sim >= $global_max_sim ){
						return true;
					}
					if( similar_text(strtolower($name0), strtolower($affiliate_info['customers_lastname']), $sim) > 2 && $sim >= $global_max_sim ){
						return true;
					}
					if( similar_text(strtolower($name1), strtolower($affiliate_info['customers_lastname']), $sim) > 2 && $sim >= $global_max_sim ){
						return true;
					}
				}
			}
		}
		//��ʼ�������������Ƚ�(������δ����ʱ)��Ҫ�Ƚ�SESSION
		for ($i=0, $n=sizeof($_SESSION['cart']->contents); $i<$n; $i++){
			foreach ((array)$_SESSION['GuestEngXing'.$i] as $key => $vals){
				$_guest_names = strtolower($vals . $_SESSION['GuestEngName'.$i][$key]);
				$_guest_names1 = strtolower($_SESSION['GuestEngName'.$i][$key] . $vals);
				if( similar_text(strtolower($_guest_names), strtolower($affiliate_info['customers_firstname']), $sim) > 2 && $sim >= $global_max_sim ){
					return true;
				}
				if( similar_text(strtolower($_guest_names1), strtolower($affiliate_info['customers_firstname']), $sim) > 2 && $sim >= $global_max_sim ){
					return true;
				}
				if( similar_text(strtolower($_guest_names), strtolower($affiliate_info['customers_lastname']), $sim) > 2 && $sim >= $global_max_sim ){
					return true;
				}
				if( similar_text(strtolower($_guest_names1), strtolower($affiliate_info['customers_lastname']), $sim) > 2 && $sim >= $global_max_sim ){
					return true;
				}
			}
		}
		return false;
	}

	//Added by Fred -- BOF -----------------------------------------------------
	//JUST RETURN THE PRODUCT PRICE (INCL ATTRIBUTE PRICES) WITH OR WITHOUT TAX
	/**
	 * ȡ�ö������ﳵ��ĳ����Ʒ�ļ۸񣨿۳��˷�֮��ļ۸�
	 * ����Ĵ������������ $order ��Դ����
	 * @param unknown_type $product_id
	 * @return unknown
	 */
	function product_price($product_id) {
		$total_price = $this->get_product_price($product_id);
		if ($this->include_shipping == 'true') $total_price -= $order->info['shipping_cost'];
		return $total_price;
	}
	//Added by Fred -- EOF -----------------------------------------------------

	function check() {
		if (!isset($this->check)) {
			$check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_COUPON_STATUS'");
			$this->check = tep_db_num_rows($check_query);
		}

		return $this->check;
	}

	function keys() {
		return array('MODULE_ORDER_TOTAL_COUPON_STATUS', 'MODULE_ORDER_TOTAL_COUPON_SORT_ORDER', 'MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING', 'MODULE_ORDER_TOTAL_COUPON_INC_TAX', 'MODULE_ORDER_TOTAL_COUPON_CALC_TAX', 'MODULE_ORDER_TOTAL_COUPON_TAX_CLASS');
	}

	function install() {
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display Total', 'MODULE_ORDER_TOTAL_COUPON_STATUS', 'true', 'Do you want to display the Discount Coupon value?', '6', '1','tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_COUPON_SORT_ORDER', '9', 'Sort order of display.', '6', '2', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Include Shipping', 'MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING', 'true', 'Include Shipping in calculation', '6', '5', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Include Tax', 'MODULE_ORDER_TOTAL_COUPON_INC_TAX', 'true', 'Include Tax in calculation.', '6', '6','tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Re-calculate Tax', 'MODULE_ORDER_TOTAL_COUPON_CALC_TAX', 'None', 'Re-Calculate Tax', '6', '7','tep_cfg_select_option(array(\'None\', \'Standard\', \'Credit Note\'), ', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax Class', 'MODULE_ORDER_TOTAL_COUPON_TAX_CLASS', '0', 'Use the following tax class when treating Discount Coupon as Credit Note.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
	}

	function remove() {
		$keys = '';
		$keys_array = $this->keys();
		for ($i=0; $i<sizeof($keys_array); $i++) {
			$keys .= "'" . $keys_array[$i] . "',";
		}
		$keys = substr($keys, 0, -1);

		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ")");
	}
}

?>
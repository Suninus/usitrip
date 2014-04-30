<?php
/*
$Id: account_history_info.php,v 1.1.1.1 2004/03/04 23:37:53 ccwjr Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2003 osCommerce

Released under the GNU General Public License
*/

require('includes/application_top.php');
/*
 * ����Ƿ���Ȩ�޶�ȡ���뺯
 */
function checkHaveInvitation($opid){
	$email=tep_get_customers_email($_SESSION['customer_id']);
	$str_sql='select orders_product_eticket_guest_id from orders_product_eticket_guest where guest_email="'.$email.'" and orders_products_id='.$opid;
	$sql_query=tep_db_query($str_sql);
	return tep_db_num_rows($sql_query);
}
if (!tep_session_is_registered('customer_id')) {
	$navigation->set_snapshot();
	if(tep_not_null($_COOKIE['LoginDate'])){
		$messageStack->add_session('login', LOGIN_OVERTIME);
		setcookie('LoginDate', '');
	}
	tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
}

if (!(int)$_GET['order_id']) {
	tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
}

//֧���ɹ������˷�֪ͨ�ʼ�
if(tep_not_null($_GET['need_send_payment_success_email']) && tep_not_null($_GET['success_payment'])){
	tep_send_payment_success_email((int)$_GET['order_id'], (string)$_GET['success_payment']);
}

$customer_info_query = tep_db_query("select customers_id from " . TABLE_ORDERS . " where orders_id = '". (int)$_GET['order_id'] . "'");
$customer_info = tep_db_fetch_array($customer_info_query);
if ($customer_info['customers_id'] != $customer_id) {
	tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
}

require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_HISTORY_INFO);
require(DIR_FS_LANGUAGES . $language . '/' . 'checkout_payment.php');

$breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
$breadcrumb->add(sprintf(NAVBAR_TITLE_3, $_GET['order_id']), tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . (int)$_GET['order_id'], 'SSL'));

require_once(DIR_FS_CLASSES . 'order.php');
$order_id = (int)$_POST['order_id'] ? $_POST['order_id'] : $_GET['order_id'];
$order = new order($_GET['order_id']);

//ajax �ύ start {
if($_POST['ajax'] == 'true'){
	require_once(DIR_FS_LANGUAGES . $language . '/' . 'modules/order_total/ot_coupon.php');
	require_once(DIR_FS_INCLUDES . 'modules/order_total/ot_coupon.php');
	$redeem_code = new ot_coupon;
	$error = false;
	//����ܷ����Ż�
	if($_POST['action']=='submitCouponCode' || $_POST['action']=='submitPoint'){
		if((int)$order->info['orders_paid']){
			$error = true;
			$error_msn = '�Ѹ���(�������ָ���)�Ķ���������ʹ���Ż�ȯ����ֵֿۣ�';
		}else{
			for($i=0, $n=sizeof($order->totals); $i<$n; $i++){
				if(in_array($order->totals[$i]['class'], array('ot_coupon', 'ot_redemptions'))){
					$error = true;
					$error_msn = '�������Ѿ����Żݺ�Ķ����ˣ����Բ�����ʹ���Ż�ȯ����ִ��ۣ�';
				}
				if($order->totals[$i]['class']=='ot_total'){
					$ot_total = $order->totals[$i]['value'];
				}
			}
		}
	}
	
	if($error == false){
		switch ($_POST['action']){
			case 'submitCouponCode':	//�ύ�û����Ż���
				if($_POST['acc_gv_redeem_code']){
					$cc_id = tep_db_get_field_value('coupon_id','coupons','coupon_code="'.tep_db_input(tep_db_prepare_input($_POST['acc_gv_redeem_code'])).'"');
					$amount = 0;
					//����Ż�ȯ start{
					$redeem_code->collect_posts();					
					//����Ż�ȯ end}
					if($error == false){
						$amount = $redeem_code->calculate_credit($ot_total);
						if($amount > 0){
							$ot_total = $ot_total - $amount;
							tep_db_query('UPDATE `orders_total`  set `text`="'.'<b>' . $currencies->format($ot_total) . '</b>'.'" ,`value`="'.$ot_total.'"  WHERE `orders_id`="'.$order_id.'" AND `class`="ot_total" ');
							tep_db_query('INSERT INTO `orders_total`  set `orders_id`="'.$order_id.'" ,`title`="'.html_to_db($redeem_code->title). ':' . $redeem_code->coupon_code .':'.'" ,`text`="'.'<b>-' . $currencies->format($amount) . '</b>'.'" ,`value`="'.$amount.'" ,`class`="'.$redeem_code->code.'" ,`sort_order`="'.$redeem_code->sort_order.'" ');
							//�����������Ƽ�����Ӽ�¼
							$_tmp_affiliate_id = tep_db_get_field_value('affiliate_id','`coupons`','coupon_code="'.strip_tags($_POST['acc_gv_redeem_code']).'" ');
							if((int)$_tmp_affiliate_id){
								unset($_SESSION['affiliate_ref']);
								$affiliate_ref = $_tmp_affiliate_id;
								$insert_id = $order_id;
								require(DIR_FS_INCLUDES . 'affiliate_checkout_process.php');
								//����sofiaҪ������һ�ε�������������˱���
								servers_sales_track::clear_ref_info();
							}
						}
						//���¼۸�
						echo 'true';
					}
				}
				unset($_SESSION['acc_gv_redeem_code']);	//Ԥ���û����µ�ʱ©��
				tep_session_unregister('acc_gv_redeem_code');
			break;

			case 'submitPoint':	//�ύ���ֶһ�
				require_once(DIR_FS_LANGUAGES . $language . '/' . 'modules/order_total/ot_redemptions.php');
				require_once(DIR_FS_INCLUDES . 'modules/order_total/ot_redemptions.php');
				$redemptions = new ot_redemptions;
				$_customer_shopping_points_spending = $_POST['_customer_shopping_points_spending'];
				//һ��Ҫ�����û����ö��ٻ��֣�ȡ��������߿��û��֡��û�������߿��û��֡��û�����Ķһ����� ����Сֵ��
				$customer_shopping_points = tep_get_shopping_points($_SESSION['customer_id']);
				$max_points_string = calculate_max_points($customer_shopping_points);
				$max_points1 = explode("-#-",$max_points_string);
				$order_max_points = (int)$max_points1[0];	//�������Ļ���
				//$total_allowable_discount = $max_points1[1];	//�������ı��ֿۼ۸�
	
				$_customer_shopping_points_spending = min($order_max_points, $_customer_shopping_points_spending);
				if ($_customer_shopping_points_spending > 0) {	//�һ�����
					tep_redeemed_points($customer_id, $order_id, $_customer_shopping_points_spending);
					$amount = tep_calc_shopping_pvalue($_customer_shopping_points_spending);
					$ot_total = $ot_total - $amount;
					tep_db_query('UPDATE `orders_total`  set `text`="'.'<b>' . $currencies->format($ot_total) . '</b>'.'" ,`value`="'.$ot_total.'"  WHERE `orders_id`="'.$order_id.'" AND `class`="ot_total" ');
					tep_db_query('INSERT INTO `orders_total`  set `orders_id`="'.$order_id.'" ,`title`="'.html_to_db($redemptions->title). ':'.'" ,`text`="'.'<span style=\"color:#FF0000\">-' . $currencies->format($amount) . '</span>'.'" ,`value`="'.$amount.'" ,`class`="'.$redemptions->code.'" ,`sort_order`="'.$redemptions->sort_order.'" ');
	
					echo 'true';
				}else{
					$error = true;
					$error_msn = "���ֶһ�ʧ�ܣ���������ԭ��\n��1�����Ļ��ֹ�������\n��2���˶�����Ʒ�Ƿ������û��֣�";
				}
				unset($_SESSION['_customer_shopping_points_spending']);	//Ԥ���û����µ�ʱ©��
				tep_session_unregister('_customer_shopping_points_spending');
			break;
		}
	}

	if($error == true){
		echo db_to_html($error_msn);
	}
	exit;
}
//ajax �ύ end }

//{
//�Ż�ȯ��ģ�飬�ڽ��ͬ��״̬�²�����
//�����Ź��г̵�״̬Ҳ������
//�����ؼ��г�Ҳ������
//�н�ֹ�ŻݵĲ�ƷҲ������
//����������Ա����ݰ�����µ�ʱҲ������
//Howard added by 2012-11-12
$enable_coupon_points = true;	//Ĭ�Ͽ����Ż���ͻ���ʹ�ù���
$without_products_ids = explode(',', DISABLED_COUPON_PRODUCTS_IDS);
if((int)$Admin->login_id){
	$enable_coupon_points = false;
}else{
	for ($i=0, $n=sizeof($order->products); $i<$n; $i++){
		if($order->products[$i]['roomattributes'][5]=='1'){
			$enable_coupon_points = false;
		}
		if((int)is_group_buy_product((int)$order->products[$i]['id'])){
			$enable_coupon_points = false;
		}
		if(check_is_specials((int)$order->products[$i]['id'])){
			$enable_coupon_points = false;
		}
		if(in_array((int)$order->products[$i]['id'], $without_products_ids)){
			$enable_coupon_points = false;
		}
	}
}
//}

//��ӱ������ƻ��˵Ķ���������ID������id
if(!(int)$Admin->login_id){
	tep_update_orders_ad_click_id($order_id, $customers_ad_click_id);
	tep_update_orders_affiliate_info($order_id, $_COOKIE['affiliate_ref']);
	tep_update_orders_from($order_id);
}

$content = CONTENT_ACCOUNT_HISTORY_INFO;
$javascript = 'popup_window.js';

$is_my_account = true;

require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

require(DIR_FS_INCLUDES . 'application_bottom.php');
?>

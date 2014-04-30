<?php
/*
$Id: checkout_success.php,v 1.3 2004/09/25 14:36 DMG Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2003 osCommerce

Released under the GNU General Public License
*/

require('includes/application_top.php');
// begin PayPal_Shopping_Cart_IPN 2.8 (DMG)
require(DIR_FS_MODULES . 'payment/paypal/classes/paypal_order.class.php');
// end PayPal_Shopping_Cart_IPN
// if the customer is not logged on, redirect them to the shopping cart page
if (!tep_session_is_registered('customer_id')) {
	tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
}

if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'update')) {
	$notify_string = 'action=notify&';
	$notify = $HTTP_POST_VARS['notify'];
	if (!is_array($notify)) $notify = array($notify);
	for ($i=0, $n=sizeof($notify); $i<$n; $i++) {
		$notify_string .= 'notify[]=' . $notify[$i] . '&';
	}
	if (strlen($notify_string) > 0) $notify_string = substr($notify_string, 0, -1);
	// BOF: daithik change for PWA//  DMG Merge w. Paypal IPN 2.8

	if (tep_session_is_registered('noaccount')) {
		tep_session_destroy();
		tep_redirect(tep_href_link(FILENAME_DEFAULT, '$notify_string', 'NONSSL'));
	}else{
		tep_redirect(tep_href_link(FILENAME_DEFAULT, $notify_string));
	}


} else if ((isset($HTTP_GET_VARS['action']) && $HTTP_GET_VARS['action'] == 'success')) {
	//begin PayPal_Shopping_Cart_IPN
	foreach($_POST as $key => $val){
		if(is_string($val)){
			$_POST[$key] = trim($val);
		}
	}
	if($payment=='paypal'){	
		if(($_POST['payment_status']=="Completed" || $_POST['payment_status']=="Pending")){
			//��¼������Ϣ���ͻ������¼��$_POST['payment_status']=="Completed"Ϊ�Ѿ���ȫ�յ��"Pending"��//������;��ĿǰPaypal�п��ܳ���״̬ΪPending��ʵ�����Ѿ�֧���ɹ�������� 
			$orders_id = (int)$_POST["invoice"];
			$usa_value = $_POST["payment_gross"];
			$orders_id_include_time = $_POST["invoice"];
			$comment = "����״̬��".$_POST['payment_status']."\n";
			$comment.= "��Ԫ��".$usa_value."\n";
			$comment.= "����ʱ�䣺".$_POST["payment_date"]."\n";
			$comment.= "��ˮ�ţ�".$_POST["txn_id"]."\n";
			$comment.= "�����ţ�".$_POST["invoice"]."\n";
			$comment.= "�����˵�Payal�˺ţ�".$_POST["payer_email"]."\n";
			$comment.= "֪ͨ���ͣ���ͬ��֪ͨ��\n".__FILE__;
			tep_payment_success_update($orders_id, $usa_value, 'paypal', $comment, 96, $orders_id_include_time);
		}
	}
	paypal_order::reset_checkout_cart_session();
}

//}
//end PayPal_Shopping_Cart_IPN
// EOF: daithik change for PWA
require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_SUCCESS);
require(DIR_FS_LANGUAGES . $language . '/modules/payment/banktransfer.php');
require(DIR_FS_LANGUAGES . $language . '/modules/payment/cashdeposit.php');
require(DIR_FS_LANGUAGES . $language . '/modules/payment/transfer.php');

$breadcrumb->add(NAVBAR_TITLE_1);
$breadcrumb->add(NAVBAR_TITLE_2);

$global_query = tep_db_query("select global_product_notifications from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$customer_id . "'");
$global = tep_db_fetch_array($global_query);

if ($global['global_product_notifications'] != '1') {
	$orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where customers_id = '" . (int)$customer_id . "' order by date_purchased desc limit 1");
	$orders = tep_db_fetch_array($orders_query);

	$products_array = array();
	$products_query = tep_db_query("select products_id, products_name from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$orders['orders_id'] . "' order by products_name");
	while ($products = tep_db_fetch_array($products_query)) {
		$products_array[] = array('id' => $products['products_id'],
		'text' => db_to_html($products['products_name']));
	}
}

// BOF: daithik change for PWA
if (tep_session_is_registered('noaccount')) {
	$order_update = array('purchased_without_account' => '1');
	tep_db_perform(TABLE_ORDERS, $order_update, 'update', "orders_id = '".$orders['orders_id']."'");
	//  tep_db_query("insert into " . TABLE_ORDERS . " (purchased_without_account) values ('1') where orders_id = '" . (int)$orders['orders_id'] . "'");
	tep_db_query("delete from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . tep_db_input($customer_id) . "'");
	tep_db_query("delete from " . TABLE_CUSTOMERS . " where customers_id = '" . tep_db_input($customer_id) . "'");
	tep_db_query("delete from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . tep_db_input($customer_id) . "'");
	tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . tep_db_input($customer_id) . "'");
	tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . tep_db_input($customer_id) . "'");
	tep_db_query("delete from " . TABLE_WHOS_ONLINE . " where customer_id = '" . tep_db_input($customer_id) . "'");
	if (!tep_session_is_registered('noaccount')){
		tep_session_destroy();
	}
}
// EOF: daithik change for PWA

//д�ɹ����ۼ�¼
//if((int)$_GET["order_id"] && (int)$customer_id){
//	$chanets->save_sales_records((int)$_GET["order_id"]);
//}

//���۰������ԭ��������²�Ʒ�Ĵ��� Howard added by 2013-06-10
if($Admin->login_id && $_tmp_id = $Admin->parent_orders_id){
	if($Admin->orders_push_to_orders((int)$_GET['order_id'])){
		echo db_to_html('<script type="text/javascript">alert("�²�Ʒ�Ѿ���ӵ�����'.$_tmp_id.'���뵽������̨��F5ˢ�´˶�����");window.close();</script>');
		exit;
	}
}

$goUrl = '';
$paymentmethod = tep_get_order_paymentmethod_orderid($_GET['order_id']);
switch($paymentmethod){
	case '֧����': $body_style = 'display:none'; $goUrl = MODULE_PAYMENT_ALIPAY_DIRECT_PAY_API_WEB_DIR.'alipayto.php?order_id='.$_GET['order_id']; $goUrlText = 'ȥ֧��������'; break;
	case '��������': $body_style = 'display:none'; $goUrl = MODULE_PAYMENT_A_CHINABANK_API_WEB_DIR.'Send.php?order_id='.$_GET['order_id']; $goUrlText = 'ȥ�������߸���'; break;
	case '��������': $body_style = 'display:none'; $goUrl = MODULE_PAYMENT_NETPAY_API_WEB_DIR.'order_submit.php?order_id='.$_GET['order_id']; $goUrlText = 'ȥ�������߸���'; break;
	case '���ÿ�����Ԫ��': $body_style = 'display:none'; $goUrl = MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_WEB_DIR.'DoDirectPayment.php?paymentType=Sale&order_id='.$_GET['order_id']; $goUrlText = 'ȥ�ύ���ÿ�����'; break;
	case 'Authorizenet���ÿ�2013��': $body_style = 'display:none'; $goUrl = MODULE_PAYMENT_AUTHORIZENET2013_API_WEB_DIR.'index.php?order_id='.$_GET['order_id']; $goUrlText = 'ȥ�ύ���ÿ�����'; break;
}


$validation_include_js = 'true';
$content = CONTENT_CHECKOUT_SUCCESS;
$javascript = 'popup_window_print.js';

require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

require(DIR_FS_INCLUDES . 'application_bottom.php');
?>

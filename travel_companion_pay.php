<?php
//���ͬ�� ֧�� ���ʱ�ҳ�治�õ�¼��ֻҪ�ѽ��ͬ�ε�id�Ͷ�����ȡ�ü��ɡ�$_GET��$_POST���ɣ���$_POST����

require('includes/application_top.php');
require(DIR_FS_LANGUAGES . $language . '/checkout_payment.php');

// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
	if(tep_not_null($_COOKIE['LoginDate'])){
		$messageStack->add_session('login', LOGIN_OVERTIME);
		setcookie('LoginDate', '');
	}
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  if (tep_session_is_registered('customer_id')) {
	  $is_my_account = true;
	  $breadcrumb->add(db_to_html('�ҵ��˺�'), tep_href_link('account.php', '', 'SSL'));
  }
  $breadcrumb->add(db_to_html('���ͬ�ζ���'), tep_href_link('orders_travel_companion.php', '', 'SSL'));
  $breadcrumb->add(db_to_html('���ͬ�θ���'), tep_href_link('travel_companion_pay.php', '', 'SSL'));

// load all enabled payment modules
  $travel_pay = true;
  require(DIR_FS_CLASSES . 'payment.php');
  $payment_modules = new payment;

  $validation_include_js = 'true';

  $content = 'travel_companion_pay';

  $javascript = CONTENT_CHECKOUT_PAYMENT . '.js.php';

  
  
  require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_FS_INCLUDES . 'application_bottom.php');

?>

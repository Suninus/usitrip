<?php
/*
  $Id: coupon_admin.php,v 1.2 2004/03/05 00:36:41 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('TOP_BAR_TITLE', 'Statistics');
define('HEADING_TITLE', 'Discount Coupons');
define('HEADING_TITLE_STATUS', 'Status : ');
define('TEXT_CUSTOMER', 'Customer:');
define('TEXT_COUPON', 'Coupon Name');
define('TEXT_COUPON_ALL', 'All Coupons');
define('TEXT_COUPON_ACTIVE', 'Active Coupons');
define('TEXT_COUPON_INACTIVE', 'Inactive Coupons');
define('TEXT_SUBJECT', 'Subject:');
define('TEXT_FROM', 'From:');
define('TEXT_FREE_SHIPPING', 'Free Shipping');
define('TEXT_MESSAGE', 'Message:');
define('TEXT_SELECT_CUSTOMER', 'Select Customer');
define('TEXT_ALL_CUSTOMERS', 'All Customers');
define('TEXT_NEWSLETTER_CUSTOMERS', 'To All Newsletter Subscribers');
define('TEXT_CONFIRM_DELETE', 'Are you sure you want to delete this Coupon?');

define('TEXT_TO_REDEEM', 'You can redeem this coupon during checkout. Just enter the code in the box provided, and click on the redeem button.');
define('TEXT_IN_CASE', ' in case you have any problems. ');
define('TEXT_VOUCHER_IS', 'The coupon code is ');
define('TEXT_REMEMBER', 'Don\'t lose the coupon code, make sure to keep the code safe so you can benefit from this special offer.');
define('TEXT_VISIT', 'when you visit ' . HTTP_SERVER . DIR_WS_CATALOG);
define('TEXT_ENTER_CODE', ' and enter the code ');

define('TABLE_HEADING_ACTION', 'Action');

define('CUSTOMER_ID', 'Customer id');
define('CUSTOMER_NAME', 'Customer Name');
define('REDEEM_DATE', 'Date Redeemed');
define('IP_ADDRESS', 'IP Address');

define('TEXT_REDEMPTIONS', 'Redemptions');
define('TEXT_REDEMPTIONS_TOTAL', 'In Total');
define('TEXT_REDEMPTIONS_CUSTOMER', 'For this Customer');
define('TEXT_NO_FREE_SHIPPING', 'No Free Shipping');

define('NOTICE_EMAIL_SENT_TO', 'Notice: Email sent to: %s');
define('ERROR_NO_CUSTOMER_SELECTED', 'Error: No customer has been selected.');
define('COUPON_NAME', 'Coupon Name');
//define('COUPON_VALUE', 'Coupon Value');
define('COUPON_AMOUNT', '�Ż�ȯ��ֵ');
define('COUPON_CODE', 'Coupon ����');
define('COUPON_STARTDATE', '��ʼ����');
define('COUPON_FINISHDATE', '��������');
define('COUPON_FREE_SHIP', '����ͻ�');
define('COUPON_DESC', 'Coupon ˵��');
define('COUPON_MIN_ORDER', '�����ܶ�����');
define('COUPON_USES_COUPON', '��ȯ�Ŀ����ܴ���');
define('COUPON_USES_USER', 'ÿ���˿Ϳ�ʹ�õ��ܴ���');
define('COUPON_PRODUCTS', '���õĲ�Ʒid�������Ʒid��Ӣ�Ķ��Ÿ������粻�������');
define('COUPON_CATEGORIES', '���õ�Ŀ¼id�����Ŀ¼id��Ӣ�Ķ��Ÿ������粻�������');
define('VOUCHER_NUMBER_USED', 'Number Used');
define('DATE_CREATED', '��������');
define('DATE_MODIFIED', '��������');
define('TEXT_HEADING_NEW_COUPON', '����һ�����Ż�ȯ');
define('TEXT_NEW_INTRO', '��Ϊ�µ��Ż�ȯ��д������Ϣ��<br>');


define('COUPON_NAME_HELP', 'A short name for the coupon');
define('COUPON_AMOUNT_HELP', 'The value of the discount for the coupon, either absolute or in % for a discount from the order total.');
define('COUPON_CODE_HELP', '<b style="color:red;">ע�⣺Coupon ����һ����ӱ㲻�ɸ��ģ�</b>');
define('COUPON_STARTDATE_HELP', 'The date the coupon will be valid from');
define('COUPON_FINISHDATE_HELP', 'The date the coupon expires');
define('COUPON_FREE_SHIP_HELP', 'The coupon gives free shipping on an order. Note: This overrides the coupon_amount figure but respects the minimum order value');
define('COUPON_DESC_HELP', 'A description of the coupon for the customer');
define('COUPON_MIN_ORDER_HELP', 'The minimum order value before the coupon is valid');
define('COUPON_USES_COUPON_HELP', 'The maximum number of times the coupon can be used; leave blank if you want no limit.');
define('COUPON_USES_USER_HELP', 'Number of times a user can use the coupon, leave blank for no limit.');
define('COUPON_PRODUCTS_HELP', 'A comma separated list of product_ids that this coupon can be used with. Leave blank for no restrictions.');
define('COUPON_CATEGORIES_HELP', 'A comma separated list of cpaths that this coupon can be used with, leave blank for no restrictions.');

define('BILUK_ADD', '�Ż�ȯ����');
define('BILUK_ADD_HELP', '��������д��ӵ��Ż�ȯ�������������Ҫ������Ӿ�����Ϊ0Ϊ�ռ��ɡ�<br><b style="color:red;">ע�⣺Coupon ������������ֽ�β�� ABC1000����1λ���ֲ�����0���������ɵ��Ż�ȯ�ڸ��»�ɾ��ʱ��ֻ��Ҫѡ������һ����Ա�Ż�ȯ���б༭��ɾ�����ɣ�</b>');
define('JS_BILUK_ADD_NOTES', '������������������ӹ��ܣ�����Coupon ������������ֽ�β�����ҵ�1λ���ֲ�����0��');
define('JS_BILUK_ADD_NOTES_NUM', '���������֣�');
define('BILUK_ADD_START_NUM', '��ʼ���룺');
define('BILUK_ADD_START_END', '�������룺');
define('USE_RANGE','ʹ�÷�Χ');
define('USE_RANGE_HELP','���������ԵĶ����֣����ײ��Ż������һ�ŵ�');
define('NEED_USER_ACTIVE','�Ƿ���Ҫ�ͻ��������ʹ��');
define('NEED_USER_ACTIVE_HELP','���ѡ������Ҫ�ͻ������ô���Ż�ȯ���뱻�ͻ�����֮�����ʹ�á�');
define('SUFFIX_RANDOM_NUMBER_LENGTH','��׺���������');
define('SUFFIX_RANDOM_NUMBER_LENGTH_HELP','��׺��������ȣ���������һ����׺������ĳ�����5λ������д5��0������������');
?>

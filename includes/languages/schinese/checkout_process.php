<?php
/*
  $Id: checkout_process.php,v 1.1.1.1 2003/03/22 16:56:02 nickle Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 osCommerce
  Released under the GNU General Public License

  Traditional Chinese language pack(Big5 code) for osCommerce 2.2 ms1
  Community: http://forum.kmd.com.tw 
  Author(s): Nickle Cheng (nickle@mail.kmd.com.tw)
  Released under the GNU General Public License ,too!!

*/

//define('EMAIL_TEXT_SUBJECT', STORE_NAME . '�Ķ���֪ͨ');
//define('EMAIL_TEXT_SUBJECT', db_to_html(STORE_NAME) . " Ԥ���� # %s (���ţ�%s)");
define('EMAIL_TEXT_SUBJECT', "���ķ�(Usitrip.com)����-%s֧��(�����ţ�%s) ");
define('EMAIL_TEXT_ORDER_NUMBER', "Reservation Number/������:");
define('EMAIL_TEXT_INVOICE_URL', "Detailed Invoice/�굥:");
define('EMAIL_TEXT_DATE_ORDERED', "Reservation Date/Ԥ������:");
define('EMAIL_TEXT_PRODUCTS', "Reservation List/�����б�");
define('EMAIL_TEXT_SUBTOTAL', "Subtotal \n С��:");
define('EMAIL_TEXT_TAX', '˰:        ');
define('EMAIL_TEXT_SHIPPING', '�ͻ�: ');
define('EMAIL_TEXT_TOTAL', "Grand Total \n �ܼ�:    ");
define('EMAIL_TEXT_DELIVERY_ADDRESS', "����ƾ֤�ʼĵ�ַ:");
define('EMAIL_TEXT_BILLING_ADDRESS', "���ÿ���ַ:");
define('EMAIL_TEXT_PAYMENT_METHOD', "֧����ʽ:");
define('EMAIL_TEXT_INVOICE_LINK', '�˵���ϸ��');
define('EMAIL_TEXT_DEPARTURE_TIME_AND_LOCATION', '�����ص㣺');

define('ERROR_SESSION_GUSET_LOSS','��������д��������Ϣ��ȫ������Ҫ������д�������ο���Ϣ���ܼ�����');

define('TEXT_EMAIL_VIA', '����');
// email signature
define('EMAIL_TEXT_SIGNATURE','лл���Ĵ���!' . "\n\n" . '����������ϵ��������κ�����������Ĵ���:' . "\n\n" . 'PHONE: +886-(0)2 2767 1689 - 0963-387766' . "\n\n" . 'Crystal Light Centrum' . "\n" . '����������· 30�� 102Ū 14��' . "\n" . '110 ̨����');
define('TXT_PROVIDER_STATUS_MAIL_FROM', '���ķ���');
define('EMAIL_ORDERS_PRODUCTS_STATUS_CHANGED_SUBJECT', TXT_PROVIDER_STATUS_MAIL_FROM.' has changed status of Reservation #%s (%s)');
define('EMAIL_ORDERS_PRODUCTS_STATUS_CHANGED_BODY', "Hi,\n\n %s has updated Reservation #%s as below, \n\n Tour: %s \n Reservation: #%s \n Start Date: %s \n Reservation Status: %s %s \n Message: %s. \n\n For review or reply please checkout below link,\n\n <a href='%s'>%s</a>\n\n Thanks \n %s \n");
if($_SERVER['HTTP_HOST'] == '208.109.123.18' || $_SERVER['HTTP_HOST'] == 'cn.usitrip.com'){ //only allow for demo site  
define('AUTO_CANCELED_EMAIL_TEXT_SUBJECT', 'Ԥ��#%s���Զ�ȡ�� ');
}else{
define('AUTO_CANCELED_EMAIL_TEXT_SUBJECT', 'Ԥ��#%s���Զ�ȡ�� - QA ORDER');
}
define('AUTO_CANCELED_EMAIL_TEXT_BODY', "�����ظ�Ԥ��������Ԥ����#%s��ϵͳ�Զ�ȡ�����������ڴ���������һ����ͬ����#%s������Ǵ���ȡ��������Ϊ�˶���Ǹ����ͨ�����·�ʽ�����������ǵĿͷ���Ա��ϵ�Ծ����� ����#%s�Ĵ�����\n\n�ʼ���service@usitrip.com\n");
define('TEXT_HOTEL_CHECK_IN_DATE', 'Check In Date and Time:');
define('TXT_RETURN_DEPARTURE_TIME_LOCATION', 'Return Departure Time & Location');
?>
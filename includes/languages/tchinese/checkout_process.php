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

//define('EMAIL_TEXT_SUBJECT', STORE_NAME . '���q��q��');
define('EMAIL_TEXT_SUBJECT', "���|��(Usitrip.com)�q��-%s��I(�q�渹�G%s) ");
define('EMAIL_TEXT_ORDER_NUMBER', "Reservation Number/�q�渹:");
define('EMAIL_TEXT_INVOICE_URL', "Detailed Invoice/�Գ�:");
define('EMAIL_TEXT_DATE_ORDERED', "Reservation Date/�w�q���:");
define('EMAIL_TEXT_PRODUCTS', "Reservation List/�q��C��");
define('EMAIL_TEXT_SUBTOTAL', "Subtotal \n �p�p:");
define('EMAIL_TEXT_TAX', '�|:        ');
define('EMAIL_TEXT_SHIPPING', '�e�f: ');
define('EMAIL_TEXT_TOTAL', "Grand Total \n �`�p:    ");
define('EMAIL_TEXT_DELIVERY_ADDRESS', "�ѹξ��Ҷl�H�a�}:");
define('EMAIL_TEXT_BILLING_ADDRESS', "�H�Υd�a�}:");
define('EMAIL_TEXT_PAYMENT_METHOD', "��I�覡:");
define('EMAIL_TEXT_INVOICE_LINK', '�b����Ӫ�');
define('EMAIL_TEXT_DEPARTURE_TIME_AND_LOCATION', '�X�o�a�I�G');

define('ERROR_SESSION_GUSET_LOSS','�ѩ�z��g����ƫH�������A�z�ݭn���s��g���㪺�C�ȫH���~���~��I');

define('EMAIL_SEPARATOR', '-----------------------------------------------------------------------------------------------------------');
define('TEXT_EMAIL_VIA', '�g��');
// email signature
define('EMAIL_TEXT_SIGNATURE','���±z������!' . "\n\n" . '�лP�ڭ��p�Y�p�G�z��������D����z������:' . "\n\n" . 'PHONE: +886-(0)2 2767 1689 - 0963-387766' . "\n\n" . 'Crystal Light Centrum' . "\n" . '�H�q�ϥæN�� 30�� 102�� 14��' . "\n" . '110 �x�_��');
define('TXT_PROVIDER_STATUS_MAIL_FROM', '���|���');
define('EMAIL_ORDERS_PRODUCTS_STATUS_CHANGED_SUBJECT', TXT_PROVIDER_STATUS_MAIL_FROM.' has changed status of Reservation #%s (%s)');
define('EMAIL_ORDERS_PRODUCTS_STATUS_CHANGED_BODY', "Hi,\n\n %s has updated Reservation #%s as below, \n\n Tour: %s \n Reservation: #%s \n Start Date: %s \n Reservation Status: %s %s \n Message: %s. \n\n For review or reply please checkout below link,\n\n <a href='%s'>%s</a>\n\n Thanks \n %s \n");
if($_SERVER['HTTP_HOST'] == '208.109.123.18' || $_SERVER['HTTP_HOST'] == 'tw.usitrip.com'){ //only allow for demo site  
define('AUTO_CANCELED_EMAIL_TEXT_SUBJECT', '�w�q# %s�Q�۰ʨ���');
}else{
define('AUTO_CANCELED_EMAIL_TEXT_SUBJECT', '�w�q# %s�Q�۰ʨ��� - QA ORDER');
}
define('AUTO_CANCELED_EMAIL_TEXT_BODY', "�ѩ󭫽ƹw�q�A�z���w�w��#%s�Q�t�Φ۰ʨ����C�ڭ̥��b�B�z�z���t�@�ӬۦP�q��#%s�C�p�G�O���~�����A�ڭ̬����ӹD�p�C�гq�L�H�U�覡�A���ֻP�ڭ̪��ȪA�H���pô�H�ȥ���q��#%s�����~�B�z�G \n\n �l��Gservice@usitrip.com \n");
define('TEXT_HOTEL_CHECK_IN_DATE', 'Check In Date and Time:');
define('TXT_RETURN_DEPARTURE_TIME_LOCATION', 'Return Departure Time & Location');
?>
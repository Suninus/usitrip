<?php
/*
  $Id: cc.php,v 1.2 2004/03/05 00:36:42 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce
 
  Released under the GNU General Public License
*/

/*
  //define('MODULE_PAYMENT_CC_CVC_TEXT_TITLE', 'Credit Card : International Credit Card</br> <div style="font-weight:normal;">Use this option only if you use a non U.S. issued credit card or your credit card can not be verified by our system.<br> Your photo ID and a signed Acknowledgement of Card Billing is required.</div>');
  define('MODULE_PAYMENT_CC_CVC_TEXT_TITLE', 'Credit Card : International Credit Card');
  define('MODULE_PAYMENT_CC_CVC_TEXT_TITLE_ADDON', '</br> <div style="font-weight:normal;">Use this option only if you use a non U.S. issued credit card or your credit card can not be verified by our system.<br> Your photo ID and a signed Acknowledgement of Card Billing is required.</div>');
  define('MODULE_PAYMENT_CC_CVC_TEXT_DESCRIPTION', 'Credit Card with CCV checking Test Info:<br><br>CC#: 4111111111111111<br>Expiry: Any');
  define('MODULE_PAYMENT_CC_CVC_TEXT_TYPE', 'Type:');
  define('MODULE_PAYMENT_CC_CVC_TEXT_CREDIT_CARD_TYPE', 'Credit Card Type:');
  define('MODULE_PAYMENT_CC_CVC_TEXT_CREDIT_CARD_OWNER', 'Credit Card Owner:');
  define('MODULE_PAYMENT_CC_CVC_TEXT_CREDIT_CARD_NUMBER', 'Credit Card Number:');
  define('MODULE_PAYMENT_CC_CVC_TEXT_CREDIT_CARD_EXPIRES', 'Credit Card Expiry Date:');
  define('MODULE_PAYMENT_CC_CVC_TEXT_JS_CC_OWNER', '* The owner\'s name of the credit card must be at least ' . CC_OWNER_MIN_LENGTH . ' characters.\n');
  define('MODULE_PAYMENT_CC_CVC_TEXT_CVV_LINK', 'What is it?');
  define('MODULE_PAYMENT_CC_CVC_TEXT_JS_CC_NUMBER', '* The credit card number must be at least ' . CC_NUMBER_MIN_LENGTH . ' characters.\n');
  define('MODULE_PAYMENT_CC_CVC_TEXT_ERROR', 'Credit Card Error!');
  define('MODULE_PAYMENT_CC_CVC_TEXT_DECLINED_MESSAGE', 'Your credit card was declined. Please try another card or contact your bank for more info.');
  define('MODULE_PAYMENT_CC_CVC_TEXT_ERROR', 'Credit Card Error!');
  define('MODULE_PAYMENT_CC_CVC_TEXT_JS_CC_CVV', '* You must enter a CCV number to proceed. Please click (What is it?) for help.\n');
  define('TEXT_CCVAL_ERROR_CARD_TYPE_MISMATCH', 'The credit card type you\'ve chosen does not match the credit card number entered. Please check the number and credit card type and try again.');
  define('TEXT_CCVAL_ERROR_CVV_LENGTH', 'The CVV number entered is incorrect. Please try again.');
 */
 define('MODULE_PAYMENT_CC_CVC_TEXT_TITLE', '���ÿ�:(�������⣩�������ÿ�');
  define('MODULE_PAYMENT_CC_CVC_TEXT_TITLE_ADDON', '</br> <div style="font-weight:normal;">����ʹ�������������ÿ����������ÿ��޷�������վ��֤ͨ��ʱѡ��������ѡ��ͻ���Ҫ�ṩ������Ƭ����Ч���֤����ǩ�����ÿ�֧����֤��</div>');
    define('MODULE_PAYMENT_CC_CVC_TEXT_DESCRIPTION', 'Credit Card with CCV checking Test Info:<br><br>CC#: 4111111111111111<br>Expiry: Any');
  define('MODULE_PAYMENT_CC_CVC_TEXT_TYPE', '�����');
 define('MODULE_PAYMENT_CC_CVC_TEXT_CREDIT_CARD_TYPE', '���ÿ�����:');
  define('MODULE_PAYMENT_CC_CVC_TEXT_CREDIT_CARD_OWNER', '�ֿ���:');
  define('MODULE_PAYMENT_CC_CVC_TEXT_CREDIT_CARD_NUMBER', '���ÿ�����:');
  define('MODULE_PAYMENT_CC_CVC_TEXT_CREDIT_CARD_EXPIRES', 'ʹ�ý�ֹ����:');
    define('MODULE_PAYMENT_CC_CVC_TEXT_CVV_LINK', '����ʲô?');
	define('MODULE_PAYMENT_CC_CVC_TEXT_CVV_NUMBER', 'CVV ��:');
	
  define('MODULE_PAYMENT_CC_CVC_TEXT_JS_CC_OWNER', '* �ֿ��������������� ' . CC_OWNER_MIN_LENGTH . ' ����\n');
  define('MODULE_PAYMENT_CC_CVC_TEXT_JS_CC_NUMBER', '* ���Ų������� ' . CC_NUMBER_MIN_LENGTH . ' λ��\n');
  define('MODULE_PAYMENT_CC_CVC_TEXT_ERROR', '��Ч�����ÿ�!');
define('MODULE_PAYMENT_CC_CVC_TEXT_DECLINED_MESSAGE', '�������ÿ�֧��ʧ�ܡ���ʹ���������ÿ�����ϵ�������ÿ������̻�ȡ������');

define('MODULE_PAYMENT_CC_CVC_TEXT_JS_CC_CVV', '* ����дCVV���룬�����������鿴������ʲô����');


define('TEXT_CCVAL_ERROR_CARD_TYPE_MISMATCH', '����ѡ�����ÿ����ͺ����ÿ����벻�����������ÿ����ͺͿ��Ų��������롣');
define('TEXT_CCVAL_ERROR_CVV_LENGTH', '�������CVV�����������������롣');
 

  define('MODULE_PAYMENT_CC_CVC_TEXT_AMEX', 'Amex');
  define('MODULE_PAYMENT_CC_CVC_TEXT_DISCOVER', 'Discover');
  define('MODULE_PAYMENT_CC_CVC_TEXT_MASTERCARD', 'Mastercard');
  define('MODULE_PAYMENT_CC_CVC_TEXT_VISA', 'Visa');
?>

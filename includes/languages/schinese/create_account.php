<?php
/*
  $Id: banktransfer.php,v 1.3 2002/05/31 19:02:02 thomasamoulton Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
  //define('HEADING_TITLE', '��ȫ���ע��');
  define('HEADING_TITLE_CREATE_ACCOUNT', '��ȫ���ע��');
  define('TEXT_ORIGIN_LOGIN', '��������&nbsp;&nbsp;�ɴ˿�ʼ');
   
   
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE', '���е��');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION', 'Please see below details for information needed for sending wire transfer.<br>'.
		  '<br>Bank Name: '.MODULE_PAYMENT_BANKTRANSFER_BANKNAM.
		  '<br>Account Name: ' . MODULE_PAYMENT_BANKTRANSFER_ACCNAM . 
		  '<br>Account #: ' . MODULE_PAYMENT_BANKTRANSFER_ACCNUM . 
		  '<br>Routing #: ' . MODULE_PAYMENT_BANKTRANSFER_ROUNUM . 
		  '<br>SWIFT #: ' . MODULE_PAYMENT_BANKTRANSFER_SORTCODE . ' (For International Wire Transfer)'.
		  '<br><br>Company Address:<br>' . nl2br(db_to_html (STORE_NAME_ADDRESS)) .
		  '<br><br>Note: Please reference your reservation number on bank form when you send wire transfer. Your reservation will NOT be confirmed until we receive payment.<br>'.

		  '<br>��ʹ���������鵽���е�����Ķ�������<br>'.
		  '<br>�������ơ� ' . MODULE_PAYMENT_BANKTRANSFER_BANKNAM . 
		  '<br>�ʻ����� ' . MODULE_PAYMENT_BANKTRANSFER_ACCNAM . 
		  '<br>�˺š� ' . MODULE_PAYMENT_BANKTRANSFER_ACCNUM . 
		  '<br>ABA���к���� ' . MODULE_PAYMENT_BANKTRANSFER_ROUNUM . 
		  '<br>SWIFT ����� ' . MODULE_PAYMENT_BANKTRANSFER_SORTCODE . ' (�������ʵ��ʹ��)' .
		  "<br><br>��˾��ַ��<br>" . nl2br(db_to_html (STORE_NAME_ADDRESS)) .
		  '<br><br>ע������ڷ��͵���ʱ�������б����ע�����Ķ����š���������������δ�յ�����֧����֮ǰ���ǽ�����ȷ�����Ķ������ǳ���л������ϡ�');

  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_EMAIL_FOOTER', "Please see below details for information needed for sending wire transfer.\n".
		  "\nBank Name: ".MODULE_PAYMENT_BANKTRANSFER_BANKNAM.
		  "\nAccount Name: " . MODULE_PAYMENT_BANKTRANSFER_ACCNAM . 
		  "\nAccount #: " . MODULE_PAYMENT_BANKTRANSFER_ACCNUM . 
		  "\nRouting #: " . MODULE_PAYMENT_BANKTRANSFER_ROUNUM . 
		  "\nSWIFT #: " . MODULE_PAYMENT_BANKTRANSFER_SORTCODE . " (For International Wire Transfer) \n ".
		  "\n\nCompany Address:\n" . nl2br(db_to_html (STORE_NAME_ADDRESS)) .
		  "\nNote: Please reference your reservation number on bank form when you send wire transfer. Your reservation will NOT be confirmed until we receive payment.\n".
		
		  "\n��ʹ���������鵽���е�����Ķ�������".
		  "\n�������ơ� " . MODULE_PAYMENT_BANKTRANSFER_BANKNAM . 
		  "\n�ʻ����� " . MODULE_PAYMENT_BANKTRANSFER_ACCNAM . 
		  "\n�˺š� " . MODULE_PAYMENT_BANKTRANSFER_ACCNUM . 
		  "\nABA���к���� " . MODULE_PAYMENT_BANKTRANSFER_ROUNUM . 
		  "\nSWIFT ����� " . MODULE_PAYMENT_BANKTRANSFER_SORTCODE . ' (�������ʵ��ʹ��)'.
		  "\n\n��˾��ַ��\n" . nl2br(db_to_html (STORE_NAME_ADDRESS)) .
		  "\n\nע������ڷ��͵���ʱ�������б����ע�����Ķ����š���������������δ�յ�����֧����֮ǰ���ǽ�����ȷ�����Ķ������ǳ���л������ϡ�");


// Points/Rewards system V2.1rc2a BOF
define('EMAIL_WELCOME_POINTS', '<li><strong>������ƻ�</strong> - ��Ϊ���ǻ�ӭ�µĿͻ��������Ѽ������� %s �ܹ��� %s ֵ�ù���� %s .' . "\n" . '����� %s �������������á�');
define('EMAIL_POINTS_ACCOUNT', '�����Accout');
define('EMAIL_POINTS_FAQ', '�����ƻ��ĳ��������');
// Points/Rewards system V2.1rc2a EOF
/*
// English Points/Rewards system V2.1rc2a BOF
define('EMAIL_WELCOME_POINTS', '<li><strong>Reward Point Program</strong> - As part of our Welcome to new customers, we have credited your %s with a total of %s Purchase Points worth %s .' . "\n" . 'Please refer to the %s as conditions may apply.');
define('EMAIL_POINTS_ACCOUNT', 'Purchase Points Accout');
define('EMAIL_POINTS_FAQ', 'Reward Point Program FAQ');
// Points/Rewards system V2.1rc2a EOF
*/
require_once('create_account_process.php'); 
?>

<?php
/*
  $Id: orders.php,v 1.2 2004/03/05 00:36:41 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Orders');
define('HEADING_TITLE_SEARCH', 'Order ID:');
define('HEADING_TITLE_STATUS', 'Status:');
define('HEADING_ORDER_ID', 'Order ID');
define('TABLE_HEADING_COMMENTS', 'Comments');
define('TABLE_HEADING_CUSTOMERS', 'Customers');
define('TABLE_HEADING_ORDER_TOTAL', 'Order Total');
define('TABLE_HEADING_DATE_PURCHASED', 'Date Purchased');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_QUANTITY', 'Qty.');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS', 'Products');
define('TABLE_HEADING_TAX', 'Tax');
define('TABLE_HEADING_TOTAL', 'Total');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Price (ex)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Price (inc)');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Total (ex)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Total (inc)');

define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Customer Notified');
define('TABLE_HEADING_DATE_ADDED', 'Date Added');

//begin PayPal_Shopping_Cart_IPN
define('TABLE_HEADING_PAYMENT_STATUS', 'Payment Status');
//end PayPal_Shopping_Cart_IPN

define('ENTRY_CUSTOMER', 'Customer:');
define('ENTRY_SOLD_TO', 'SOLD TO:');
define('ENTRY_DELIVERY_TO', 'Delivery To:');
define('ENTRY_SHIP_TO', 'SHIP TO:');
define('ENTRY_SHIPPING_ADDRESS', 'Shipping Address:');
define('ENTRY_BILLING_ADDRESS', 'Billing Address:');
define('ENTRY_PAYMENT_METHOD', 'Payment Method:');
define('ENTRY_CREDIT_CARD_TYPE', 'Credit Card Type:');
define('ENTRY_CREDIT_CARD_OWNER', 'Credit Card Owner:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Credit Card Number:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Credit Card Expires:');
define('ENTRY_CREDIT_CARD_CVV', 'Credit Card CVV:'); 
define('ENTRY_SUB_TOTAL', 'Sub-Total:');
define('ENTRY_TAX', 'Tax:');
define('ENTRY_SHIPPING', 'Shipping:');
define('ENTRY_TOTAL', 'Total:');
define('ENTRY_DATE_PURCHASED', 'Date Purchased:');
define('ENTRY_STATUS', 'Status:');
define('ENTRY_DATE_LAST_UPDATED', 'Date Last Updated:');
define('ENTRY_NOTIFY_CUSTOMER', 'Notify Customer:');
define('ENTRY_NOTIFY_COMMENTS', 'Append Comments:');
define('ENTRY_PRINTABLE', 'Print Invoice');

define('TEXT_INFO_HEADING_DELETE_ORDER', 'Delete Order');
define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this order?');
define('TEXT_INFO_DELETE_DATA', 'Customers Name  ');
define('TEXT_INFO_DELETE_DATA_OID', 'Order Number  ');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Restock product quantity');
define('TEXT_DATE_ORDER_CREATED', 'Date Created:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Last Modified:');
define('TEXT_INFO_PAYMENT_METHOD', 'Payment Method:');

define('TEXT_ALL_ORDERS', 'All Orders');
define('TEXT_NO_ORDER_HISTORY', 'No Order History Available');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Order Update');
define('EMAIL_TEXT_ORDER_NUMBER', 'Reservation Number:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
define('EMAIL_TEXT_DATE_ORDERED', 'Reservation Date:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Your reservation has been updated to the following status.' . "\n\n" . 'New status: %s' . "\n\n" . 'Please reply to this email if you have any questions.' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'The comments for your reservation are' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Error: Order does not exist.');
define('SUCCESS_ORDER_UPDATED', 'Success: Order has been successfully updated.');
define('WARNING_ORDER_NOT_UPDATED', 'Warning: Nothing to change. The order was not updated.');
// START - Added for eCheck Payment Modual
  define('MODULE_PAYMENT_ECHECK_TEXT_PAY_TO', 'Pay to the<BR>Order of:');
  define('MODULE_PAYMENT_ECHECK_TEXT_MEMO', 'Memo:');
  define('MODULE_PAYMENT_ECHECK_TEXT_MEMO1', 'Memo:');
  define('MODULE_PAYMENT_ECHECK_TEXT_MEMO2', 'Online Order #');
  define('MODULE_PAYMENT_ECHECK_TEXT_NO_SIG1', 'No Signature Required');
  define('MODULE_PAYMENT_ECHECK_TEXT_NO_SIG2', 'Signature:');
  define('MODULE_PAYMENT_ECHECK_TEXT_NO_SIG3', 'Authorized by E-mail');
// END - Added for eCheck Payment Modual


//James add for the email which was used to reply customers for update one's order status

//status id: 100001
define(EMAIL_TITLE_RECEIPT_SENT,'Receipt of Reservation');

//status id: 100002
define(EMAIL_TITLE_TICKET_ISSUED,'Your E-Ticket has been issued.');
define(EMAIL_COMMENTS_TICKET_ISSUED,"�z���ѹξ��Ҥw�o�e��z���q�l�l�c�C�ХJ�Ӿ\Ū�ѹξ��ҤW���Ҧ��H���A�p�G�����D�A�Фήɳq���ڭ̡C�ڭ̱N���|��b�X�Ϊ�72�p�ɤ��~�q���ѹξ��ҥX���ӳy���������G�Ӿ�d���C\n\n�z�٥i�H�q�L�X��http://208.109.123.18/login.php �A�u�d�ݡv�z���e�@�ӹw�q�A���I���u�ѹξ��ҡv���s�d�ݱz���ѹξ��ҡC");

//status id: 100000
define(EMAIL_TITLE_CONFIRMED,'Reservation Confirmation');
define(EMAIL_COMMENTS_CONFIRMED,"���P�z�I�z�busitrip���w�q�w�g�Q�T�w�F�C�ЫO�d���T�w�l��M�q�渹�H�ƥH��ϥΡC�ڭ̷|�b�z�X�o������e��ѩΤT�ѡA�]�i���u�ɶ����A�o���z�ѹξ��ҡC\n\n�p�G�z�w�q���Υ]�t������/�e���A�åB�z�٨S�����ѧڭ̱z����Z�H���A�бz���֨�http://208.109.123.18/account.php ��s�z����Z�H���C�p�G�S����Z�H���A�ڭ̱N�L�k�X���C");

//status id: 100003
define(EMAIL_TITLE_UPDATE,'Reservation Update');

//status id: 100004
define(EMAIL_COMMENTS_NOT_AVAILABLE,"�ܿ�ѡA�ڭ̼Ȯɤ���T�w�z���w�q�C��z�ҳy�������K�A�ڭ̲`�P��p�C");

//status id: 100005
define(EMAIL_COMMENTS_REFUNDED,"�ھڱz��z�w�q���ӽСA�ڭ̤w�g�h��$��z���H�Υd�W�C\n�b���B�z�Q�����T�w�e�A�i��Ȯɷ|��ܬ��ݩw���B�z�C�X�ѫ�A���K�|�b�z���d�W��ܡC\n�Ʊ��A�����z�A�ȡA���ݱz���U�����{");

//status id: 100007  Payment Adjusted
define(EMAIL_COMMENTS_PAYMENT_ADJUSTED,"�վ�᪺����:    �վ�᪺����:\n\n��l����G    ��l�����G");

//status id: 6  CANCELLED
define(EMAIL_COMMENTS_CANCELLED,"�ܿ�ѡA�{�b�ڭ̼Ȯɤ��ର�z�w�q���ΡA�����M�P�±z��ڭ̪����`.\n\n���ݱz���A���X�ݡC");

//status id: 100011  Charge Failed
define(EMAIL_COMMENTS_CHARGE_FAILED,"�ڭ̸չϦb�z���Ѫ��H�Υd�W����$  �A���t�ξާ@���ѤF�C\n\n�бz�P�z���H�Υd�o����p�Y�A�H�T�O�U���ڭ̦b����z������A���ާ@�ɥi�H���\�C\n\n�Ϊ̦p�G�z�Q�ϥΥt�@�i�H�Υd�A�Цb�H�Υd�b��e�U��W��g���᪺�H���A�ós�P���[���o�e���ڭ̡C\nhttp://208.109.123.18/acknowledgement_of_card_billing.php.\n�D�`�P�±z���ʶR�A���ݱz���֪��^���C ");

//status id: 100012  Flight Information Needed
define(EMAIL_COMMENTS_FLIGHT_INFO_NEEDED,"�Цb�z�w�q��Z��A���ֵn��http://208.109.123.18/account.php�b�z���b��H���ا�s�z����Z�H���C�S����Z�H���A�ڭ̱N�L�k�o�e�ѹξ��ҵ��z�C�Ʊ�z��b�������ާ@��o�l���service@usitrip.com�A�H�q���ڭ̱z�w�g�i��F��s�C�D�`�P�±z���ѻP�C");

//status id: 100013  Confirmed, Doc. Pending
define(EMAIL_COMMENTS_CONFIRM_DOC_PENDING,"���P�z�I�z�busitrip���w�q�w�g�Q�T�w�F�C�ЫO�d���T�w�l��M�q�渹�H�ƥH��ϥΡC\n\n�b����z�o�e���һݤ������ڭ̷|���ֵo���z�ѹξ��ҡ]�ѥ[�Ȧ�Ϊ����ҡ^�C\n�\Ū�һݤ�����Ա��H�Φp��o�e���A�аѦ�http://208.109.123.18/acknowledgement_of_card_billing.php\n�P�±z���ѻP�C");

//status id: 100014  Confirmed, Full Doc. Received
define(EMAIL_COMMENTS_CONFIRM_FULL_DOC_RECEIVED,"�P�±z�b�b�̵u���ɶ����o�e���ڭ̩һݪ����C�ڭ̤w�g�T�w����z�����A�@�����`�A�óB��i�{���C�ڭ̱N���ֵo���z�ѹξ��ҡC");

//status id: 100015  Confirmed, Partial Doc. Received
define(EMAIL_COMMENTS_CONFIRM_PARTIAL_DOC_RECEIVED,"�P�±z�b�b�̵u���ɶ����o�e���ڭ̩һݪ����C�ڭ̤w�g�T�w����z�����A���ٯʤֱz�����Ĩ������ҷӤ��C�p�G��K�A�о��ֵo�e���ڭ̡C");

//status id: 100016  Payment Pending
define(EMAIL_COMMENTS_PAYMENT_PENDING,"�Цb�I�ګᾨ�ֳq���ڭ̡A�H�K�ڭ̶i�@�B�B�z�z���w�q�C\n\n�D�`�P�±z���ѻP�C");

//status id: 100020  Cancellation Form Required
define(EMAIL_COMMENTS_CANCELLATION_FORM_REQUIRED,"�ڭ̤w�g����z�ӽШ����w�q���l��F���ھڡu�����M�h�ڬF���v�A�ڭ̤������l��ιq�l�l������C�z�����q�L��g�añ�W���ǯu�B�l��α��y���ӽШ�����i�����.");
?>
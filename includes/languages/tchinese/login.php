<?php
/*
  $Id: login.php,v 1.1.1.1 2003/03/22 16:56:02 nickle Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 osCommerce
  Released under the GNU General Public License

  Traditional Chinese language pack(Big5 code) for osCommerce 2.2 ms1
  Community: http://forum.kmd.com.tw 
  Author(s): Nickle Cheng (nickle@mail.kmd.com.tw)
  Released under the GNU General Public License ,too!!

*/

if ($HTTP_GET_VARS['origin'] == FILENAME_CHECKOUT_PAYMENT) {
  define('NAVBAR_TITLE', '�q��');
  define('HEADING_TITLE', '��K�ֱ����W�U�q��.');
  define('TEXT_STEP_BY_STEP', '�ڭ̱N���ӨB�J���U�z�v�B�������L�{.');
} else {
  define('NAVBAR_TITLE', '�n��');
  define('HEADING_TITLE', '�w����{�A�|���Хѥk���J�q�l�l��αK�X��n���A�s�Ȥ�Ы��~��s���U');
  define('TEXT_STEP_BY_STEP', ''); // should be empty
}

define('HEADING_NEW_CUSTOMER', '���U�㸹');
define('TEXT_NEW_CUSTOMER', '�ڬO�s�Ȥ�.');
define('TEXT_NEW_CUSTOMER_INTRODUCTION', '���|����|���i�H�o��٤ߦp�N���ȹC��{�A�ȡA�w������ȹC��T�M�S����T�C�M���|�����Ѫ��n�����y�p�e���z�i�H�q�L�q�ʲ��~�A�o����סA�W�ǷӤ��A�^�����D���覡Ĺ���{���馩�I');

define('HEADING_RETURNING_CUSTOMER', '�«Ȥ�');
define('TEXT_RETURNING_CUSTOMER', '�w���㸹');
define('ENTRY_EMAIL_ADDRESS', '�q�l�l�c:');
define('ENTRY_PASSWORD', '�K�X:');

define('TEXT_PASSWORD_FORGOTTEN', '�ѰO�K�X�H');
define('SUCCESS_PASSWORD_SENT', '�K�X�w�g���\�o�e��z���q�l�l�c�A�еy�J�d���I');

define('TEXT_LOGIN_ERROR', '<font color="#ff0000"><b>���~:</b></font>\'�q�l�l��a�}\' �� \'�K�X\'���šA�Э��s��J');
define('TEXT_VISITORS_CART', '<font color="#ff0000"><b>����:</b></font> �Y�z�n���b�Х��H�|���㸹�n���A�z��&quot;�X���ʪ���&quot;�ت��ӫ~�A�|�b�n����۰ʨ֤J&quot;�|���ʪ���&quot;�� <a href="javascript:session_win();">[��h����]</a>');

// +Login Page a la Amazon
define('TEXT_EMAIL_QUERY', '����O�z���q�l�l��?');
define('TEXT_EMAIL_IS', '�ڪ��q�l�l��O:');
define('TEXT_HAVE_PASSWORD', '�z���@�� '. STORE_NAME . ' �K�X��?');
define('TEXT_HAVE_PASSWORD_NO', '��, �ڬO�@�W�s�U�ȡC');
define('TEXT_HAVE_PASSWORD_YES', '�O, �ڪ��K�X�O:');
define('HEADING_CHECKOUT', '��������');
define('TEXT_CHECKOUT_INTRODUCTION', '�z�i�H��ܪ�������.�ڭ̱N���|�x�s��������z���ӤH���.��ܪ������㪺��,�z�L��N����A��ݱz���q�檬�A�Υ���q��O��.');
// -Login Page a la Amazon

// Points/Rewards Module V2.1rc2a
define('TEXT_CONTINUE_WITHOUT_LOGIN_MESSAGE','�z�N���|��o����n���C�z�i�H�i��U�C���C');
define('TEXT_ALREADY_LOGIN_MESSAGE','�z�w�n��');
define('TEXT_SUCCESS_LOGIN_MESSAGE','�n�����\�C ');

/* english
// Points/Rewards Module V2.1rc2a
define('TEXT_NOT_LOGIN_MESSAGE','You will not earn any points. You can proceed with the below Form.');
define('TEXT_ALREADY_LOGIN_MESSAGE','You have already logged in');
define('TEXT_SUCCESS_LOGIN_MESSAGE','You have logged in successfully. You will now earn points for ');
*/

?>
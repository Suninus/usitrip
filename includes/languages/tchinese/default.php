<?php
/*
  $Id: default.php,v 1.1.1.1 2003/03/22 16:56:02 nickle Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 osCommerce
  Released under the GNU General Public License

  Traditional Chinese language pack(Big5 code) for osCommerce 2.2 ms1
  Community: http://forum.kmd.com.tw 
  Author(s): Nickle Cheng (nickle@mail.kmd.com.tw)
  Released under the GNU General Public License ,too!!

*/

define('TEXT_MAIN', '���u�W�ʪ��t�ζȬ��i�ܤ��ΡA <b>����q�ʪ��ӫ~�����|�X�f�β��ͱb��</b>�A�Ҧ��ӫ~�������T�]�������L�ġC<br><br>�p�G�z�Q�U���o�ӽu�W�ʪ��t�ΩάO���ɵ{�����ڭ̡A�Ы��X<a href="http://oscommerce.com"><u>�䴩����</u></a>�C���u�W�ʪ��t�ά[�c�� <font color="#f0000"><b>' . PROJECT_VERSION . '</b></font>.<br><br>�Y�n�ק�W������ܪ���r�A�i�H��ʭק�A�ɮ׸��|�� [webroot]/catalog/includes/languages/tchinese/default.php<br>�άO�g�Ѩt�Τu��/�y�t�w�q�ﶵ�A�Ψt�Τu��/�ɮ��`�� �ӭק� default.php');

define('TABLE_HEADING_NEW_PRODUCTS', '%s���s�i�ӫ~');
define('TABLE_HEADING_UPCOMING_PRODUCTS', '�ӫ~�W���w�i');
define('TABLE_HEADING_DATE_EXPECTED', '�w�p�W�����');

if ($category_depth == 'products' || $HTTP_GET_VARS['manufacturers_id']) {
  define('HEADING_TITLE', '�ӫ~�C��');
  define('TABLE_HEADING_IMAGE', '');
  define('TABLE_HEADING_MODEL', '����');
  define('TABLE_HEADING_PRODUCTS', '�~�W');
  define('TABLE_HEADING_MANUFACTURER', '�s�y�t��');
  define('TABLE_HEADING_QUANTITY', '�ƶq');
  define('TABLE_HEADING_PRICE', '����');
  define('TABLE_HEADING_WEIGHT', '���q');
  define('TABLE_HEADING_BUY_NOW', '���W�R');
  define('TEXT_NO_PRODUCTS', '���ؿ��ثe�S������ӫ~.');
  define('TEXT_NO_PRODUCTS2', '���s�y���ӥثe�S������ӫ~.');
  define('TEXT_NUMBER_OF_PRODUCTS', '�ӫ~�ƶq: ');
  define('TEXT_SHOW', '<b>���:</b>');
  define('TEXT_BUY', '���W�R\'');
  define('TEXT_NOW', '\'');
  define('TEXT_ALL', '����');
} elseif ($category_depth == 'top') {
  define('HEADING_TITLE', '������s�A���H');
} elseif ($category_depth == 'nested') {
  define('HEADING_TITLE', '�ӫ~����');
}
?>
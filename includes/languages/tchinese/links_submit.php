<?php
/*
  $Id: links_submit.php,v 1.2 2004/03/05 00:36:42 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', '�쵲');
define('NAVBAR_TITLE_2', '�����쵲');

define('HEADING_TITLE', '�pô�H��');

define('TEXT_MAIN', '�ж�g�H�U���Ӵ���z�������C');

define('EMAIL_SUBJECT', '�w��Ө� ' . STORE_NAME . ' �챵�洫�C');
define('EMAIL_GREET_NONE', '�˷R�� %s' . "\n\n");
define('EMAIL_WELCOME', '�ڭ��w��z�̨� <b>' . STORE_NAME . '</b> �챵�洫�p���C' . "\n\n");
define('EMAIL_TEXT', '�z���챵�w���\����� ' . STORE_NAME . '�A�q�L�f�֫�z���챵�N���W�K�[��ڭ̪��C��W�C�z�N����@�ʳq�����檬�A���l��C�p�G�b���U�Ӫ�48�p�ɤ��z���ব��o�ʶl��A�Цb���s�����챵�e�P�ڭ��pô�C' . "\n\n");
define('EMAIL_CONTACT', '�����U�P�ڭ��pô��y�p���A�бz�o�e�q�l�l���G ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>Note:</b> �o�ӹq�l�l��a�}�O���ڭ̦b�@�����`����C�p�G��������D�A�еo�e�q�l�l��� ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
define('EMAIL_OWNER_SUBJECT', '�s������b' . STORE_NAME);
define('EMAIL_OWNER_TEXT', '�@�ӷs���챵���浹' . STORE_NAME . '�C�ثe�|����o���C�нT�{�o�ӳs���A�ñҰʡC' . "\n\n");

define('TEXT_LINKS_HELP_LINK', '&nbsp;Help&nbsp;[?]');

define('HEADING_LINKS_HELP', '�s�����U');
define('TEXT_LINKS_HELP', '<b>�����W�١G</b> ���z��������g�@�q�y�z�C<br><br><b>�����a�}URL:</b> ��J�z�������a�}�A�䤤�]�A \'http://\'.<br><br><b>���O�G</b> ���z�������]�m�@�ӾA�����O�C<br><br><b>�y�z�G</b> ²�n�y�z�z�������C<br><br><b>Image URL:</b> ��g�z������LOGO�ϼЦa�}�A�䤤�]�A \'http://\'. �o�ӹϼбN�H�۱z�������챵��ܡC<br>�Ҧp�G http://your-domain.com/path/to/your/image.gif <br><br><b>���W�G</b> �z�����W�C<br><br><b>Email:</b> �z���q�l�l��a�}�C�п�J�@�Ӧ��Ī��q�l�l��A�z�N�|����q�l�l��C<br><br><b>���f���G</b> �z���s���������諸URL�a�}�A�Z�챵��ڭ̪������A�N�Q�C��/�i�ܡC<br>�Ҧp�G http://your-domain.com/path/to/your/links_page.php');
define('TEXT_CLOSE_WINDOW', '<u>�������f</u> [x]');

// VJ todo - move to common language file
define('CATEGORY_WEBSITE', '�����Ա�');
define('CATEGORY_RECIPROCAL', '���f���Ա�');

define('ENTRY_LINKS_TITLE', '�����W�١G');
define('ENTRY_LINKS_TITLE_ERROR', '�챵���D�����]�t�ܤ� ' . ENTRY_LINKS_TITLE_MIN_LENGTH . ' �Ӧr�šC');
define('ENTRY_LINKS_TITLE_TEXT', '*');
define('ENTRY_LINKS_URL', 'URL:');
define('ENTRY_LINKS_URL_ERROR', 'URL �����]�t�ܤ� ' . ENTRY_LINKS_URL_MIN_LENGTH . '  �Ӧr�šC');
define('ENTRY_LINKS_URL_TEXT', '*');
define('ENTRY_LINKS_CATEGORY', '���O�G');
define('ENTRY_LINKS_CATEGORY_TEXT', '*');
define('ENTRY_LINKS_DESCRIPTION', '�y�z�G');
define('ENTRY_LINKS_DESCRIPTION_ERROR', '�y�z�����]�t�ܤ� ' . ENTRY_LINKS_DESCRIPTION_MIN_LENGTH . ' �Ӧr�šC');
define('ENTRY_LINKS_DESCRIPTION_TEXT', '*');
define('ENTRY_LINKS_IMAGE', 'Image URL:');
define('ENTRY_LINKS_IMAGE_TEXT', '');
define('ENTRY_LINKS_CONTACT_NAME', '���W�G');
define('ENTRY_LINKS_CONTACT_NAME_ERROR', '�z�����W�����]�t�ܤ� ' . ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH . ' �Ӧr�šC');
define('ENTRY_LINKS_CONTACT_NAME_TEXT', '*');
define('ENTRY_LINKS_RECIPROCAL_URL', '���f���G');
define('ENTRY_LINKS_RECIPROCAL_URL_ERROR', '���f�������]�t�ܤ� ' . ENTRY_LINKS_URL_MIN_LENGTH . ' �Ӧr�šC');
define('ENTRY_LINKS_RECIPROCAL_URL_TEXT', '*');
?>

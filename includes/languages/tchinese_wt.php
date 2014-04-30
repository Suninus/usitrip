<?php
/*
  $Id: tchinese.php,v 1.1.1.1 2003/08/07 07:54:24 nickle Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 osCommerce
  Released under the GNU General Public License

  Traditional Chinese language pack(Big5 code) for osCommerce 2.2
  Community: http://forum.kmd.com.tw 
  Author(s): Nickle Cheng (nickle@mail.kmd.com.tw)
  Released under the GNU General Public License ,too!!

*/

// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// �]�w���a�ɶ�
// RedHat 'zh_TW'
// FreeBSD 'zh_TW.Big5'
// Windows ''�޸����ťէY�i
//
@setlocale(LC_TIME, '');
define('DATE_FORMAT_SHORT', '%m/%d%/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%Y�~%m��%d�� %A'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'CNY');//�w�]��

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="zh-tw"');

// charset for web pages and emails
//define('CHARSET', 'big5');
define('CHARSET', 'gbr2312');

// page title
define('TITLE', STORE_NAME);

// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', '���U�㸹');
define('HEADER_TITLE_MY_ACCOUNT', '�ڪ��㸹');
define('HEADER_TITLE_CART_CONTENTS', '�ʪ���');
define('HEADER_TITLE_CHECKOUT', '���b');
define('HEADER_TITLE_CONTACT_US', '�p���ڭ�');
define('HEADER_TITLE_TOP', '����');
define('HEADER_TITLE_CATALOG', '�ӫ~�ؿ�');
define('HEADER_TITLE_LOGOFF', '�h�X');
define('HEADER_TITLE_LOGIN', '�n��');
define('HEADER_TITLE_ADMINISTRATION', '�t�κ޲z');

// box text in includes/boxes/administrators.php
define('BOX_HEADING_ADMINISTRATORS', '�t�κ޲z��');
define('BOX_ADMINISTRATORS_SETUP', '�]�w');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', '���s��,�۱q');

// text for gender
define('MALE', '�k');
define('FEMALE', '�k');
define('MALE_ADDRESS', '����');
define('FEMALE_ADDRESS', '�p�j');

// text for date of birth example
define('DOB_FORMAT_STRING', 'mm/dd/yyyy');

// categories box text in includes/boxes/categories.php
define('BOX_HEADING_CATEGORIES', '���I�ؿ�');

// manufacturers box text in includes/boxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', '�s�y�t��');

// whats_new box text in includes/boxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', '�s�W�[�ӫ~');

// quick_find box text in includes/boxes/quick_find.php
define('BOX_HEADING_SEARCH', '�ֳt�M��ӫ~');
define('BOX_SEARCH_TEXT', '��J����r�M��ӫ~');
define('BOX_SEARCH_ADVANCED_SEARCH', '�i���M��ӫ~');

// specials box text in includes/boxes/specials.php
define('BOX_HEADING_SPECIALS', '�S���ӫ~');

// reviews box text in includes/boxes/reviews.php
define('BOX_HEADING_REVIEWS', '�ӫ~����');
define('BOX_REVIEWS_WRITE_REVIEW', '�мg�U�z��o�Ӱӫ~������!');
define('BOX_REVIEWS_NO_REVIEWS', '�ثe�S������ӫ~����');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '���� %s �P��');

// shopping_cart box text in includes/boxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', '�ʪ���');
define('BOX_SHOPPING_CART_EMPTY', '�ʪ�������');

// order_history box text in includes/boxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', '�ʪ�����');

// best_sellers box text in includes/boxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', '�Z�P�ӫ~');
define('BOX_HEADING_BESTSELLERS_IN', '�Z�P�ӫ~�b<br>  ');

// notifications box text in includes/boxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', '�ӫ~���A�q��');
define('BOX_NOTIFICATIONS_NOTIFY', '<b>%s</b><br>��s�ɳq����');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', '<b>%s</b><br>��s�ɤ����q����');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', '�t�Ӫ�������T');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', ' %s ���D��');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', '�t�Ӫ���L�ӫ~');

// languages box text in includes/boxes/languages.php
define('BOX_HEADING_LANGUAGES', '�y��');

// currencies box text in includes/boxes/currencies.php
define('BOX_HEADING_CURRENCIES', '�f��');

// information box text in includes/boxes/information.php
define('BOX_HEADING_INFORMATION', '�A�ȥx');


define('BOX_INFORMATION_SHIPPING', '�h���f�ƶ�');


// tell a friend box text in includes/boxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', '���˵��ˤ�');
define('BOX_TELL_A_FRIEND_TEXT', '���˳o�Ӱӫ~���ˤ�');

// checkout procedure text
//define('CHECKOUT_BAR_CART_CONTENTS', '�ʪ������e');
//define('CHECKOUT_BAR_DELIVERY_ADDRESS', '�X�f�a�}');
//define('CHECKOUT_BAR_PAYMENT_METHOD', '�I�ڤ覡');
define('CHECKOUT_BAR_DELIVERY', '�X�f�H��');
define('CHECKOUT_BAR_PAYMENT', '��I��T');
define('CHECKOUT_BAR_CONFIRMATION', '�T�{�q��');
define('CHECKOUT_BAR_FINISHED', '����');

// pull down default text
define('PULL_DOWN_DEFAULT', '�п��');
define('TYPE_BELOW', '�b�U����J');

// javascript messages
define('JS_ERROR', '�b������L�{���X�{���~.\n\n�а��U�z�勵:\n\n');

define('JS_REVIEW_TEXT', '* \'���פ��e\' �����ܤ֥]�t ' . REVIEW_TEXT_MIN_LENGTH . ' �Ӧr��.\n');
define('JS_REVIEW_RATING', '* �z�������z���F���ת��ε�����.\n');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* �Ь��z���q���ܤ@�Ӥ�I�覡.\n');

define('JS_ERROR_SUBMITTED', '�o�Ӫ��w�g�e�X�A�Ы� Ok �ᵥ�ݳB�z');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', '�z������@�ӥI�ڤ覡.');

define('CATEGORY_COMPANY', '���q���');
define('CATEGORY_PERSONAL', '�ӤH���');
define('CATEGORY_ADDRESS', '�a�}');
define('CATEGORY_CONTACT', '�z���pô��T');
define('CATEGORY_OPTIONS', '�ﶵ');
define('CATEGORY_PASSWORD', '�K�X');

define('ENTRY_COMPANY', '���q�W��:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', '�ʧO:');
define('ENTRY_GENDER_ERROR', '�п�ܩʧO');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', '����m�W:');
define('ENTRY_FIRST_NAME_ERROR', ' <small><font color="#FF0000">'.ENTRY_FIRST_NAME.'�֩� ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' �Ӧr</font></small>');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', '�@�ӭ^��W:');
define('ENTRY_LAST_NAME_ERROR', ' <small><font color="#FF0000">'.ENTRY_LAST_NAME.'�֩� ' . ENTRY_LAST_NAME_MIN_LENGTH . ' �Ӧr</font></small>');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', '�ͤ�:');
define('ENTRY_DATE_OF_BIRTH_ERROR', ' <small><font color="#FF0000">(�ҡG05/21/1970)</font></small>');
define('ENTRY_DATE_OF_BIRTH_TEXT', ' <small>(�ҡG05/21/1970) <font color="#AABBDD">�������</font></small>');
define('ENTRY_EMAIL_ADDRESS', '�q�l�l�c:');
define('ENTRY_EMAIL_ADDRESS_ERROR', ' <small><font color="#FF0000">'.ENTRY_EMAIL_ADDRESS.'�֩� ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' �Ӧr</font></small>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', ' <small><font color="#FF0000">�q�l�l���}�榡���~!</font></small>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', ' <small><font color="#FF0000">�o�ӹq�l�l��w�g���U�L!�нT�{�δ��@�ӹq�l�l��</font></small>');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', '�ԲӦa�}:');
define('ENTRY_STREET_ADDRESS_ERROR', ' <small><font color="#FF0000">'.ENTRY_STREET_ADDRESS.'�֩� ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' �Ӧr</font></small>');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', '��D:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', '�l�F�s�X:');
define('ENTRY_POST_CODE_ERROR', ' <small><font color="#FF0000">'.ENTRY_POST_CODE.'�֩� ' . ENTRY_POSTCODE_MIN_LENGTH . ' �Ӧr</font></small>');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', '����:');
define('ENTRY_CITY_ERROR', ' <small><font color="#FF0000">'.ENTRY_CITY.'�֩� ' . ENTRY_CITY_MIN_LENGTH . ' �Ӧr</font></small>');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', '�{/��:');
define('ENTRY_STATE_ERROR', '�{/�ٳ̤֥��� ' . ENTRY_STATE_MIN_LENGTH . '�Ӧr');
define('ENTRY_STATE_ERROR_SELECT', '�бq�U�Ԧ���椤���');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', '��a/�a��:');
define('ENTRY_COUNTRY_ERROR', '�бq�U�Ԧ���椤���');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', '�q�ܸ��X:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '�q�ܸ��X���o�֩� ' . ENTRY_TELEPHONE_MIN_LENGTH . ' �Ӧr</font></small>');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', '���ʹq��:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', '�q�\���|���T�l��:');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', '-�q�\-');
define('ENTRY_NEWSLETTER_NO', '����');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', '�K�X:');
define('ENTRY_PASSWORD_ERROR', '�K�X���o�֩�' . ENTRY_PASSWORD_MIN_LENGTH . ' �Ӧr');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', '�K�X����');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', '�T�{�K�X:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', '��e�K�X:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', '�K�X���o�֩� ' . ENTRY_PASSWORD_MIN_LENGTH . ' �Ӧr');
define('ENTRY_PASSWORD_NEW', '�s�K�X:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', '�s�K�X���o�֩�' . ENTRY_PASSWORD_MIN_LENGTH . ' �Ӧr');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', '�K�X����');
define('PASSWORD_HIDDEN', '--����--');
define('FORM_REQUIRED_INFORMATION', '* ��ܸ���쥲����g');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', '�`����:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', '��� <b>%d</b> �� <b>%d</b> (�@<b>%d</b>�Ӱӫ~)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', '��� <b>%d</b> �� ��<b>%d</b> (�@<b>%d</b>���q��)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', '��� <b>%d</b> �� ��<b>%d</b> (�@<b>%d</b>���O��)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', '��� <b>%d</b> �� ��<b>%d</b> (�@<b>%d</b>�ӷs�ӫ~)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', '��� <b>%d</b> �� �� <b>%d</b> (�@ <b>%d</b> ���S��)');


define('PREVNEXT_TITLE_FIRST_PAGE', '�Ĥ@��');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', '�e�@��');
define('PREVNEXT_TITLE_NEXT_PAGE', '�U�@��');
define('PREVNEXT_TITLE_LAST_PAGE', '�̫�@��');
define('PREVNEXT_TITLE_PAGE_NO', '��%d��');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', '�e %d ��');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', '�� %d ��');
define('PREVNEXT_BUTTON_FIRST', '<<�̫e��');
define('PREVNEXT_BUTTON_PREV', '[<< ���e]');
define('PREVNEXT_BUTTON_NEXT', '[���� >>]');
define('PREVNEXT_BUTTON_LAST', '�̫᭱>>');

define('IMAGE_BUTTON_ADD_ADDRESS', '�s�W�a�}');
define('IMAGE_BUTTON_ADDRESS_BOOK', '�q�T��');
define('IMAGE_BUTTON_BACK', '�^�W��');
define('IMAGE_BUTTON_BUY_NOW', '���W�R');
define('IMAGE_BUTTON_CHANGE_ADDRESS', '�ܧ�a�}');
define('IMAGE_BUTTON_CHECKOUT', '���b');
define('IMAGE_BUTTON_CONFIRM_ORDER', '�T�{�q��');
define('IMAGE_BUTTON_CONTINUE', '�~��');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', '�~���ʪ�');
define('IMAGE_BUTTON_DELETE', '�R��');
define('IMAGE_BUTTON_EDIT_ACCOUNT', '�s��㸹');
define('IMAGE_BUTTON_HISTORY', '�q��O��');
define('IMAGE_BUTTON_LOGIN', '�n��');
define('IMAGE_BUTTON_IN_CART', '����ʪ���');
define('IMAGE_BUTTON_NOTIFICATIONS', '�q��');
define('IMAGE_BUTTON_QUICK_FIND', '�ֳt�M��');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', '�����ӫ~�q��');
define('IMAGE_BUTTON_REVIEWS', '����');
define('IMAGE_BUTTON_SEARCH', '�j�M');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', '�X�f�ﶵ');
define('IMAGE_BUTTON_TELL_A_FRIEND', '���˵��ˤ�');
define('IMAGE_BUTTON_UPDATE', '��s');
define('IMAGE_BUTTON_UPDATE_CART', '��s�ʪ���');
define('IMAGE_BUTTON_WRITE_REVIEW', '�g�g�ӫ~����');

define('SMALL_IMAGE_BUTTON_DELETE', '�R��');
define('SMALL_IMAGE_BUTTON_EDIT', '�s��');
define('SMALL_IMAGE_BUTTON_VIEW', '�˵�');

define('ICON_ARROW_RIGHT', '��h');
define('ICON_CART', '����ʪ���');
define('ICON_ERROR', '���~');
define('ICON_SUCCESS', '����');
define('ICON_WARNING', '�`�N');

define('TEXT_GREETING_PERSONAL', '<span class="greetUser">%s</span> �z�n�A�w����{�I �Q�ݬݦ�����<a href="%s"><u>�s�i�ӫ~</u></a>�H');
define('TEXT_GREETING_PERSONAL_RELOGON', '�p�G�z���O %s, �ХΦۤv���㸹<a href="%s"><u>�n��</u></a>');
define('TEXT_GREETING_GUEST', '<span class="greetUser">�X��</span>�A�w����{�A�p�G�z�w�g�O�|���Ъ���<a href="%s"><u>�n��</u></a>�H �άO<a href="%s"><u>���U���|��</u></a>�H');

define('TEXT_SORT_PRODUCTS', '�ӫ~�ƧǤ覡�G');
define('TEXT_DESCENDINGLY', '����A');
define('TEXT_ASCENDINGLY', '���W�A');
define('TEXT_BY', '�Ƨ���G');

define('TEXT_REVIEW_BY', '%s �ҵ��׼g�D�G');
define('TEXT_REVIEW_WORD_COUNT', '%s   �r');
define('TEXT_REVIEW_RATING', '����: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', '���פ��: %s');
define('TEXT_NO_REVIEWS', '�ثe�S������ӫ~����.');

define('TEXT_NO_NEW_PRODUCTS', '�ثe�S���s�i�ӫ~.');

define('TEXT_UNKNOWN_TAX_RATE', '�������|�v');

define('TEXT_REQUIRED', '<span class="errorText">����</span>');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>TEP ERROR:</small> �L�k�ѫ��w�� SMTP �D���ǰe�l��A���ˬd php.ini �]�w</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'ĵ�i�G �w�˥ؿ����M�s�b�G ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. ���w�����z�ѡA�бN�o�ӥؿ��R��');
define('WARNING_CONFIG_FILE_WRITEABLE', 'ĵ�i�G �]�w�ɤ��\�Q�g�J�G ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. �o�N�㦳��b���t�Φw�����I - �бN�ɮ׳]�w�����T���ϥ��v��');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'ĵ�i�G sessions ��Ƨ����s�b�G ' . tep_session_save_path() . '. �b�o�ӥؿ����إߤ��e Sessions �L�k���`�ʧ@');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'ĵ�i�G �L�k�g�Jsessions ��Ƨ��G ' . tep_session_save_path() . '. �b�ϥΪ̳\�i�v�����T�]�w���e Sessions �N�L�k���`�ʧ@');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'ĵ�i�G �U�����ӫ~�ؿ����s�b�G ' . DIR_FS_DOWNLOAD . '. �b�o�ӥؿ����إߤ��e�A�L�k�U���ӫ~');
define('WARNING_SESSION_AUTO_START', 'ĵ�i�G session.auto_start �w�Ұ� - �Ш� php.ini �������o�ӥ\��A�í��s�Ұʺ����D��');
define('TEXT_CCVAL_ERROR_INVALID_DATE', '��J���H�Υd�����L��<br>���ˬd�����A��');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', '�H�Υd�d���L��<br>���ˬd��A��');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', '�z��J���e�|�X�O: %s<br>�p�G���T�A�ڭ̥ثe�|�L�k���������H�Υd<br>�p�G���~�Э���');
/*
  The following copyright announcement can only be
  appropriately modified or removed if the layout of
  the site theme has been modified to distinguish
  itself from the default osCommerce-copyrighted
  theme.

  For more information please read the following
  Frequently Asked Questions entry on the osCommerce
  support site:

  http://www.oscommerce.com/community.php/faq,26/q,50

  Please leave this comment intact together with the
  following copyright announcement.
*/




define('FREE_TEXT', '<img src="' . DIR_WS_IMAGES . 'table_background_payment.gif">�K�O!</img>');

define('CALL_TEXT', '<font color=red>����Шӹq����</font>');
define('CALL_LINK_ON','1');
define('CALL_LINK_TEXT','���o�ػP�ڭ��p��');
define('CALL_LINK_OFF_TEXT','<font color=blue>���߹q�ܽм�: xxxx-xxx-xxx</font>');
define('CALL_INCART_LINK', '<B><A HREF="' . DIR_WS_CATALOG . 'contact_us.php">' . CALL_LINK_TEXT . '</A></B>    ');

define('SOON_TEXT', '<font color=red>�Y�N�W��...</font>');
define('SOON_LINK_ON','0');
define('SOON_LINK_TEXT','���o�ػP�ڭ��p��');
define('SOON_LINK_OFF_TEXT','<font color=blue>���߹q�ܽм�: xxxx-xxx-xxx</font>');
define('SOON_INCART_LINK', '<B><A HREF="' . DIR_WS_CATALOG . 'contact_us.php">' . SOON_LINK_TEXT . '</A></B>    ');

require(DIR_FS_LANGUAGES . $language . '/' . 'banner_manager.php');


define('BOX_INFORMATION_ABOUT_US','����ڭ�'); 
  define('BOX_INFORMATION_CONDITIONS', '�ϥα���');
  define('BOX_INFORMATION_SITE_MAP', '�����a��');
  define('BOX_INFORMATION_CONTACT', '�pô�ڭ�');
    //amit added new for language start
	define('FOOTER_TEXT_BODY', '���v &copy;2005-'.date('Y').' usitrip.com, �֦��̲׸����v. <br>����������M���~��{���i��|������ܰʡA�����t��q��. <br>usitrip.com����L����~�ް_�����K�t����d��. �Ҧ����L����~�ڭ̳��|�@���.');

  define('BOX_INFORMATION_PRIVACY_AND_POLICY', '���p����');
  define('BOX_INFORMATION_PAYMENT_FAQ','�I�ڱ`�����D');
  define('BOX_INFORMATION_COPY_RIGHT','���v');
  define('BOX_INFORMATION_CUSTOMER_AGREEMENT','�Ȥ��w');
  define('BOX_INFORMATION_LINK_TO_US','�ͱ��쵲');
  define('BOX_INFORMATION_CANCELLATION_REFUND_POLICY','�����M�h�ڱ���');  
  define('BOX_INFORMATION_VIEW_ALL_TOURS','�d�ݩҦ��ȹC');  
  
  
  /*advance search*/
define('DURATION', '����ɶ��G');
define('DEPARTURE_CITY', '��ܥX�o�����G');
define('TEXT_NONE', '-- ��ܥX�o���� --');
define('OPTIONAL_KEYWORD', '��J�j������r�G');
define('START_DATE', '�X�o����G');
define('IGNORE','����');

define('HEADING_SHIPPING_INFORMATION', '�q�l�ѹξ��ҡ]ETicket�^�H�e');

define('HEADING_ATTRACTION', '���I�G');
/*Begin Checkout Without Account images*/
define('IMAGE_BUTTON_CREATE_ACCOUNT', '�إ߱b��');
define('NAV_ORDER_INFO', '�q���T');

/*End Checkout WIthout Account images*/
define('ENTRY_TELEPHONE_NUMBER_COUNTRY_CODE', '��a�N�X ');
define('ENTRY_CELLPHONE_NUMBER',"�]�д��ѥ��n�ɪ��H�ƺ���pô���Ϊ����X�^�G");
define('ENTRY_CELLPHONE_NUMBER_TEXT', '');


define('BOX_INFORMATION_GV', '����§�骺�`�����D�ѵ�');
define('VOUCHER_BALANCE', '§��l�B');
define('BOX_HEADING_GIFT_VOUCHER', '§��b��'); 
define('GV_FAQ', '����§�骺�`�����D�ѵ�');
define('ERROR_REDEEMED_AMOUNT', '���߱z�A�z���I�����\�F');
define('ERROR_NO_REDEEM_CODE', '�z�٨S����J�I�����X.');  
define('ERROR_NO_INVALID_REDEEM_GV', '�L�Ī�§��N�X'); 
define('TABLE_HEADING_CREDIT', '���ĥd');
define('GV_HAS_VOUCHERA', '�z��§��b��W�����l�B�A�p�G�z�@�N<br>
                         �z�i�H�N���̱H�e�X�h�q�L<a class="pageResults" href="');       
define('GV_HAS_VOUCHERB', '"><b>�H�q�l�l��H��</b>����L�H'); 
define('ENTRY_AMOUNT_CHECK_ERROR', '�z�S��������§��H�e�o�Ӽƥ�.'); 
define('BOX_SEND_TO_FRIEND', '�H�e§��');
define('VOUCHER_REDEEMED', '§��w�g�I��');
define('CART_COUPON', '§�� :');
define('CART_COUPON_INFO', '��h��T');
//amit added new for language end
//define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', '��� <b>%d</b> �� <b>%d</b> (�@<b>%d</b>�Ӱӫ~)');
define('TEXT_DISPLAY_NUMBER_OF_FEATURED', '��� <b>%d</b> ��  <b>%d</b> (�@ <b>%d</b>)');  // featured tours
define('TEXT_DISPLAY_NUMBER_OF_REFERRALS', '��� <b>%d</b> ��  <b>%d</b> (�@ <b>%d</b>)'); // referrals
define('TEXT_DISPLAY_NUMBER_OF_QUESTIONS', '��� <b>%d</b> ��  <b>%d</b> (�@ <b>%d</b>)'); // questions

//added for product listing page start
define('TEXT_WELCOME_TO','�w��Ө�');
define('TEXT_CUSTOMER_AGREE_BOOK','�Цb���W�w�q���e�\Ū�ڭ̪��Ȥ��ĳ�C');
define('TEXT_TOUR_PICKUP_NOTE','�@��<FONT COLOR="#0000ff">���]�ȹC</FONT> �q�`�]�A���������e�A��.');
define('TEXT_SORT_BY','�ƧǤ覡�G');
define('TEXT_TELL_YOUR_FRIEND','�i�D�z���B��');
define('TEXT_ABOUT',' ���� ');
define('TEXT_AND_MAKE','�åB���o');
define('TEXT_COMMISSION','�Ī�');
define('TEXT_TOUR_ITINERARY','�ȹC���u�G');
define('TEXT_DEPART_FROM','�X�o�a�I�G');
define('TEXT_OPERATE','�X�Τ���G');
define('TEXT_PRICE','����G');
define('TEXT_HIGHLIGHTS','�D�n���I�G');
define('TEXT_DURATION','����ɶ��G');
define('TEXT_DETAILS','�d�ݸԱ�');
//added for product listing page end
//why book form us text

define('TEXT_TOP_HEADING_BOOK','�ڭ̪��u�աG');

define('TAB_SPECIALLY_DESIGN_TOURS','��߳]�p���ȹC��');
define('TAB_LOW_PRICE_GUANRANTEED','�C���O��');
define('TAB_EXPERIENCED_DRIVER','�g���״I���q��');
define('TAB_PROFESSIONAL_TOUR_DUIDE','�M�~���ɹC');
define('TAB_EXCELLETN_CUSTOMER_SERVICES','�u�誺�Ȥ�A��');

define('TEXT_PARA_SPECIALLY_DESIGN_TOURS','�ڭ̥u���Ȥᴣ�Ѻ�ߥ��y���Ȧ�C�ڭ̱��X���Ȧ�ΡA��p�`���j�a�߷R�����ۤ���M�`�Τs���ȡA�H���|�@�D�W���j�l�\�M���ȥ[�Ԥj�r�����ȨC�~���|�l�ަ��d�W�U���C�ȡC�ܺa���ڭ̯����z�y�N�@�q�@�����Ѫ����n�^�СC�̭��n���O�A�ڭ̰���C�����Ȧ�Υu�b�o�ش��ѡA�O�L�M�B�C');
define('TEXT_PARA_LOW_PRICE_GUANRANTEED','�@�����W�@�y���ȹC�����ӡA�]�O���W�̤j�����ݥN�z�ӡA�ڭ̴��ѳ��u�誺�A�ȩM�̨Ϊ��ȹC�ΡC�ھڧڭ̪��W�ҩM�A�ȡA�ڭ̦V�z�O�ҡA�z�N�|�H���u�f������ɨ��̺��N���Ȧ�C�p�G�z��ܦ۶O�C���ܡA�Ҫ᪺�����i��|�O�ڭ̪�3-4���A�u�����|����J�ର�z�٤U�̦h�����A�S�����z�R���P���Ȧ檺�ֽ�C');
define('TEXT_PARA_EXPERIENCED_DRIVER','���ۦh�~���������ȹC�M�Ȥ��~�N�չΤW�d���g��A�ڭ̤��ȯ����z�����ȹC���ֽ�A�ٯ����z���ȳ~�ΪA�ۦb�C���H��L�������´�������ȹC���q�A�ڭ̲`���b�@���Ŷ��U�p���N�����ΨT���ث׹L3-7�ѬO�h���������ơC�]���A�ڭ̮ɶ��������γ��|�ɯŨϥΪŶ��e���S�ξA�����بT���C�z���ȯ໴�P���b�z�����ȤW�H�N�𮧡A�ٯ�ɨ���ھڮ�Խո`���ŽաA�W�ɪ��\Ū�O�A�W�j�e�q���x���c�AVCD/DVD���񾹩M���b���𮧫ǡC�����ڭ̪��ȹC���Ȧ�A�z��P����a�@�몺�ξA�C�̭��n���O�A�ڭ̪��q�������ۦh�~���g��A�L�̹�o�ǮȹC�Ӧa���u���D�`���x�A�ӥB�L�̥����ٴN�O�̴Ϊ��ɹC�C');
define('TEXT_PARA_PROFESSIONAL_TOUR_DUIDE','�p�G�ɹC�ﴺ�I���{����z�٤֡A���N�O�@����V�|���ơC�ҥH�ڭ̥u�D��̳վǭ��쪺�M�~�ɹC�C�z���|�A���ɹC�]�������x���Ҧӿ��L�@�ӭ��n�����I�A�άO�L�tť�D��a���ǻ��G�ơC�ڭ̱M�~���ɹC�|���z���z��a���v�A���@�ǥ��Z�p�����z�}�h�A�ٷ|�η�a����D�֨Ƴr�z���Ӥ����C�b�ڭ̪��ȹC���ءA�z�û����|�P��L��C');
define('TEXT_PARA_EXCELLETN_CUSTOMER_SERVICES','���|����b�����w�֮ȵ{���P�ɡA�ڭ̩l�׺�O�A�z-�ڭ̪��U�ȡA�~�O�C�ӮȹC�Τ��̭��n�������C�ڭ̱M�~���ȪA�N��|�V�O�u�@�H�T�O�z-�ڭ̴L�Q���ȤH�A�b�ڭ̵L�L���ܪ��A�ȤU�A�ѩl�ܲ׳����o�ɿ��A���o�}�ߡA���|�d�U�@�I��ѡC�ڭ̪��v���N�O���C�Ȧʤ����ʪ����N�C');


define('TEXT_NO_QUESTION_FOUND','�S����������T�C');
define('TEXT_SEARCH_FOR_YOUR_TOUR','�j���ȹC���I');

define('TEXT_TITLE_TOURS_DEALS','���ˮȹC');

//JAMES ADD FOR OTHERS TEXT
define('TEXT_NORMAL_TELL_FRIEND', '�i�D�z���B��');
define('TEXT_NORMAL_ABOUT', '����');
define('TEXT_NORMAL_GAIN', '�åB���o');
define('TEXT_NORMAL_COMISSION', '���Ī�!');

//JAMES ADD FOR PRODUCT DURATION OPTIONS
define('TEXT_DURATION_OPTION_1','��ܫ���Ѽ�');
define('TEXT_DURATION_OPTION_2','1 ��');
define('TEXT_DURATION_OPTION_3','2 ��');
define('TEXT_DURATION_OPTION_4','2 �� 3 ��');
define('TEXT_DURATION_OPTION_5','3 ��');
define('TEXT_DURATION_OPTION_6','3 �� 4 ��');
define('TEXT_DURATION_OPTION_7','4 ��');
define('TEXT_DURATION_OPTION_8','4 �ѩΧ�h�Ѽ�');
define('TEXT_DURATION_OPTION_9','5 �ѩΧ�h�Ѽ�');

define('TEXT_ATTRACTION_OPTION_1','��ܴ��I');

define('TEXT_SORT_OPTION_1','--��ܱƧǤ覡--');
define('TEXT_SORT_OPTION_2','�ȹC����');
define('TEXT_SORT_OPTION_3','����Ѽ�');
define('TEXT_SORT_OPTION_4','���I�W��');

define('TEXT_POPULAR_TOURS','�Z�P���I');
?>

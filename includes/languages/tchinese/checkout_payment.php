<?php
/*
  $Id: checkout_payment.php,v 1.1.1.1 2003/03/22 16:56:02 nickle Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 osCommerce
  Released under the GNU General Public License

  Traditional Chinese language pack(Big5 code) for osCommerce 2.2 ms1
  Community: http://forum.kmd.com.tw 
  Author(s): Nickle Cheng (nickle@mail.kmd.com.tw)
  Released under the GNU General Public License ,too!!
  Released under the GNU General Public License

*/

define('NAVBAR_TITLE_1', '���b');
define('NAVBAR_TITLE_2', '��I�H��');
define('HEADING_TITLE', '��I�H��');
define('TABLE_HEADING_BILLING_ADDRESS', '�H�Υd���a�}');
define('TABLE_HEADING_CONTACT_ADDRESS', '�q�H�a�}');
//define('TEXT_SELECTED_BILLING_DESTINATION', '�p�G�z�Q�ܧ�H�Υd�a�}�A���I���U��"�ܧ�X�f�a�}"���s�A�åѳq�T�����s�W�ο���@�ضl�H�b�檺�q�T���');
define('TABLE_HEADING_BILLING_ADDRESS_EXP','�p�z�ϥΫH�Υd��I�A�ж�g���T�H�Υd�a�}�]billing address�^�A�p�ϥΨ�L�覡��I�A�ж�g���T�q�H�a�}');
define('TEXT_SELECTED_BILLING_DESTINATION', '');
define('TITLE_BILLING_ADDRESS', '�H�Υd/�q�T�a�}:');

define('TABLE_HEADING_PAYMENT_METHOD', '�I�ڤ覡');
define('TEXT_SELECT_PAYMENT_METHOD', '�Цb�H�U%d�ؤ覡����ܾA�X�z����I�覡�A���|�����o����Better Business Bureau�]BBB�^��A+�u�q���šA�N�T�O�z��I�ާ@���w���C');
define('TITLE_PLEASE_SELECT', '�п��');
define('TEXT_ENTER_PAYMENT_INFORMATION', '�o�O�ثe�ߤ@���I�ڤ覡');

define('TABLE_HEADING_COMMENTS', HEADING_ORDER_COMMENTS);

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '�~�򵲱b�y�{,');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '�U�@�B�T�{�q��');

//amit added new define
define('TEXT_GUEST_NAME_ERROR','��ȦW�ٶ�g���~');
define('TEXT_ARRIVAL_TIME_ERROR','��F�ɶ����~�I');
define('TEXT_DEPARTURE_TIME_ERROR','�X�o�ɶ����~�I');
define('TEXT_GUEST_INFO_FLIGHT_INFO','��ȫH���M��Z�H��');
define('TEXT_FLIGHT_INFO_IF_AVAILABLE','��ĳ�z�T�O�b����{�q�ʦ��\����A�ʶR�����A�M��A�n����z���b�ᤤ��ɯ�Z�H��');
define('TEXT_INFO_GUEST_NAME','�U��%s����W');
define('TEXT_FLIGHT_INFO_IF_APPLICABLE','��Z�H��');
define('TEXT_ARRIVAL_AIRLINE_NAME','��Ť��q');
define('TEXT_DEPARTURE_AIRLINE_NAME','��Ť��q');
define('TEXT_ARRIVAL_FLIGHT_NUMBER','������Z');
define('TEXT_DEPARTURE_FLIGHT_NUMBER','�e����Z');
define('TEXT_ARRIVAL_AIRPORT_NAME','��������');
define('TEXT_DEPARTURE_AIRPORT_NAME','�e������');
define('TEXT_ARRIVAL_DATE','�������');
define('TEXT_DEPARTURE_DATE','�e�����');
define('TEXT_ARRIVAL_TIME','��F�ɶ�');
define('TEXT_DEPARTURE_TIME','�_���ɶ�');
define('TEXT_EMERGENCY_CONTACT_NUM','���C�Ȥ��:');
define('TEXT_EMERGENCY_CASE_AVALILABLE','(���T�O��z���u��A�ȡA���|����ݭn�z���pô�q�ܴN�w�q�B��I�H�ξɹC�pô�һݡC�榡�G+��a�N�X �q�ܸ��X�A�p�G+86 13888888888)');
define('TEXT_CELL_NUMBER','���ʹq�ܸ��X:');

//define('TEXT_INFO_PROTECT','���F�O�@�z���v�q,�ڭ̱N�ֹ�z���H�Υd�M��I�a�}���H��,<br />�o�ӹL�{�q�`�ݭn��O30�������k�A���O�b�S�w�ɶ��q�i��|��O����ɶ��C');
  define('TEXT_INFO_PROTECT','���F�O�@�z���v�q,�ڭ̱N�ֹ�z���H�Υd�M��I��}����T,<br />�o�ӹL�{�q�`�ݭn����X����A�P�±z���@�ߵ��ݡC');

define('TEXT_INFO_GUEST_BODY_WEIGHT','�U�Ȫ��魫');
define('TEXT_GUEST_BODY_WEIGHT_ERROR','�ж�g�����魫!');

define('TEXT_ARRIVAL_TIME_ERROR_MSG_DIS','�п�J���Ī���F�ɶ�');
define('TEXT_DEPARTURE_TIME_ERROR_MSG_DIS','�п�J���Ī��X�o�ɶ�');


define('ENTRY_GUEST_FIRST_NAME', ENTRY_FIRST_NAME);
define('ENTRY_GUEST_LAST_NAME', ENTRY_LAST_NAME);

// Points/Rewards Module V2.1rc2a BOF
//define('TABLE_HEADING_REDEEM_SYSTEM', '�n�����馩 ');
define('TABLE_HEADING_REDEEM_SYSTEM', '�w�q���~�H�� ');
define('TABLE_HEADING_REFERRAL', '�d�ߨt��');
define('TEXT_REDEEM_SYSTEM_START', '�z���H�Υd�l�B %s �A�z�Q�Υ��Ӥ�I�o���R�O�H<br />���p�`�z�����ʡG %s .');
define('TEXT_REDEEM_SYSTEM_SPENDING', '�Цb�o�̨ϥγ̦h���n�����\�o�د��ǡC (%s �I %s)&nbsp;&nbsp;->');
define('TEXT_REDEEM_SYSTEM_NOTE', '<span class="pointWarning">�����`�B�j�󤹳\���̰��I�A�z�ٻݭn��ܥI�ڤ覡</span>');
define('TEXT_REFERRAL_REFERRED', '�p�G�z����F�ڭ̪��B�͡A�п�J�L�̪��q�l�l��a�}�b�o�̡C ');
define('R4F_REDEMPTIONS_TOTAL', '�`�p�G ');
define('R4F_REDEMPTIONS_BALANCE', '�z���n���G');
define('R4F_REDEMPTIONS_MAX_DISCOUNT', '���q��i�γ̰��n���G');
define('R4F_REDEMPTIONS_TOTAL_AFTER_DISCOUNT', '�馩���`���G ');
define('R4F_REDEMPTIONS_REDEEM_REWARDS', '�I�{���y ');
define('R4F_REDEMPTIONS_POINTS','�n��');
// Points/Rewards Module V2.1rc2a EOF


/* english
// Points/Rewards Module V2.1rc2a BOF
define('TABLE_HEADING_REDEEM_SYSTEM', 'Purchase Points Redemptions ');
define('TABLE_HEADING_REFERRAL', 'Referral System');
define('TEXT_REDEEM_SYSTEM_START', 'You have a credit balance of %s ,would you like to use it to pay for this order?<br />The estimated total of your purchase is: %s .');
define('TEXT_REDEEM_SYSTEM_SPENDING', 'Tick here to use Maximum Points allowed for this order. (%s points %s)&nbsp;&nbsp;->');
define('TEXT_REDEEM_SYSTEM_NOTE', '<span class="pointWarning">Total Purchase is greater than the maximum points allowed, you will also need to choose a payment method</span>');
define('TEXT_REFERRAL_REFERRED', 'If you were referred to us by a friend please enter their email address here. ');

define('R4F_REDEMPTIONS_TOTAL', 'Total: ');
define('R4F_REDEMPTIONS_BALANCE', 'Rewards4Fun Balance: ');
define('R4F_REDEMPTIONS_MAX_DISCOUNT', 'Max Allowable Discount: ');
define('R4F_REDEMPTIONS_TOTAL_AFTER_DISCOUNT', 'Total After Discount: ');
define('R4F_REDEMPTIONS_REDEEM_REWARDS', 'Redeem Rewards ');
// Points/Rewards Module V2.1rc2a EOF
*/
define('TEXT_GUEST_CHILD_AGE_ERROR','�ൣ�~�֥X���I'); //Guest Child Age Error!
define('TEXT_GUEST_CHILD_BIRTH_DATE_ERROR','�Ȥ�ൣ�X�ͤ�����~�I'); //Guest Child Birth Date Error!
define('ENTRY_GUEST_CHILD_AGE', '�ൣ�X�ͤ��'); //Child Birth Date

define('TEXT_GUEST_ERROR_CHILD_BIRTH_DATE','�榡�G���/���/�~�~�~�~');//Please use this date format: mm/dd/yyyy. e.g. 03/17/2006 for March 17, 2006

define('ENTRY_STREET_ADDRESS_LINE1','�ԲӦa�}:');

define('TEXT_ENTER_COUPON_CODE', '�p�G�S���馩��Щ�������');
define('TEXT_NOTES_HEADING_DIS','�`�N�G');
define('TEXT_NOTES_HEADING_HOLDER_CC_NOTE','�Цb��g�H�Υd��T�e�J�Ӿ\Ū���ɴ��ܡC');
define('TEXT_NOTES_HEADING_BILLING_EDIT_INFORMATION','�ж�g���㥿�T���q�H�a�}�A�H�K�ڭ̫��򬰱z�����u��A�ȡA�z�N�����|��o���|����ذe�����§�~�C �z�i�H�q�L�I�����s��a�}���s��M�ܧ�a�}�C');
define('TEXT_BILLING_INFO_MOBILE', '���ʹq��:');

define('AUTHORIZE_MAX_ATTEMPT_OVER_ERROR', '<b>�I�ڸ�T</b><br><b><u>�z���H�Υd��d��I�����\�A�о\Ū�H�U��T�C</u></b><br><br>�D�`�P�±z�b���|����w�w�ȹC��{�A�ڭ̫D�`��p�a�i���z�������H�Υd��d��I�����\�C�y���H�Υd��d��I���Ѫ���]�i�঳�G�H�Υd�d�����~�F�H�Υd�w�L���Ĵ����F�W�L�C���d���B�F�H���B�פ����F�H�Υd�b���}��g���~���C<br><br>�Ъ`�N�b�s��h����d�����\��A�X��w���Ҽ{�A�z�N����A�~��ϥγo�i�H�Υd��I�������w�w�C���o�ر��p�A�ڭ̫�ĳ�z�J�Ӯֹ�z���H�Υd��T�A�Ϊ̻P�z���o�d�Ȧ��pô�����h��T�C�P�ɡA�ڭ̤]��ĳ�z��Ψ�L��I�覡�A�p�G�Ȧ����]�i��2%�馩�u�f�^�A�q�ס]�i��2%�馩�u�f�^�APayPal�]�ثe�j���a��PayPal�Τ�Ȥ��䴩�^�A�ײ�/�Ȧ�䲼/�Ȧ�䲼�C<br><br>�p�G�z�٦���L�ðݡA���pô�ڭ̡G<br>�q�ܡG888-887-2816�]���[�K�O�^<br>1-626-898-7800�]��ڡ^<br>0086-4006-333-926�]����^<br>�l�c�G service@usitrip.com');

define('FLIGHT_NOTES_POP_TITLE',' ��Ū�G���������`�N�ƶ�');
define('FLIGHT_NOTES_POP_CONTENT',' ����P�C�Τ��P��Z��F�Q���`�N�ƶ�<br><b>�F�����M�\��{�G</b><br>���t�K�O�����A�Ȫ����~�A�C�ӭq�洣�Ѥ@���K�O���������A�ȡC�p�G�O���P��Z��F���Q���ݭn�@���H�W���B�~�����A�b9:00AM-10:00PM�����A�C�W�[�@���B�~�������A�ڭ̷|�����@���A�ȶO��$30.00�C<br>�`�N�G�]���ڭ̪��s�������w�ƦbEWR�����d��A�ҥH���F��X�z���ϥΧK�O�����귽�A�ɶq�NJFK�Ϊ�LGA����Z�H���o�e���ڭ̡A�w�Ʊ����CEWR������F���Q���Цۦ歼���s�����y���e���s���C�p�ݭק��Z�H�����ܡA��Z�H�����H�q�l�ѹξ��ҵo�X�@���ɶ��ɭ��C�p�G��Z�H����ʦb�q�l�Ȳ��o�X���e�A�ڭ̤�����������O�ΡC�p�G���ɹq�l�Ȳ��w�g�o�X�A�ڭ̱N�����C�ӭq��$30.00���ק�O�C<br><b>������M�\��{�G</b><br>���t�K�O�����A�Ȫ����~�A�C�ӭq�洣�Ѥ@���K�O���������A�ȡA�p�G�O�b���P��Z��F���Q���ݭn�@���H�W���B�~�����A�ڭ̻ݭn�����B�~�O�ΡA����ھڤH�ƨM�w�C�жl���service@usitrip.com�M�D�����C�p�G�z�ݭn�ק��Z�H�����ܡA��Z���H�q�l�ѹξ��ҵo�X�@���ɶ��ɭ��C�p�G��Z�H����ʦb�q�l�Ȳ��o�X���e�A�ڭ̤�����������O�ΡC�p�G���ɹq�l�Ȳ��w�g�o�X�A�ڭ̱N�����C�ӭq��$30.00���ק�O�C' );
define('ENTRY_GUEST_GENDER','�ʧO:');
define('TEXT_CHECKOUT_GENDER_MALE','�k');
define('TEXT_CHECKOUT_GENDER_FEMALE','�k');
define('ENTRY_GUEST_DATE_OF_BIRTH','�X�ͤ��:');
define('ERROR_GUEST_BIRTHDATE_FORMAT', 'Birth date should in mm/dd/yyyy format');
define('MODULE_EASY_DISCOUNT_CREDIT_TITLE','���ΫH��');
define('TXT_UR_CREDIT_BAL','�z���H�ξl�B���G ');
define('CHECK_APPLY_CREDITS','�z�Q�n���ΫH�ζܡH');
define('ENTRY_GUEST_HEIGHT','���� (ft/cm):');
define('TEXT_DOSE_TOUR_HOTEL_PICKUP','�z�w�q���δ��Ѱs�������A�ȶܡH');
define('TEXT_NOTE_HOTEL_INFO_BELOW','�мg�U�z���s���H���]�ԲӪ��a�}�^');
define('TEXT_YES','�O');
define('TEXT_NO','��');
define('TEXT_TOUR_HOTEL_PICKUP_NOTE','�`�N�G�p�G�ڭ̵L�k�b�z�Ҧb���s�������A�ڭ̱N���ѵ��z�Z���z�Ҵ��Ѧa�}�̪񪺤W���a�I�C');
define('TEXT_EXTRA_FEATURES_NOTE', '<span class="sp1"><b>�`�N�G</b></span>�]����{���A�Ψ����ꤺ����, ��Ť��q�W�w�ݴ��ѩҦ��ȤH���X�ͤ���B�ʧO�M�ѹΤH�m�W���H���C�аȥ��T�O�z���Ѫ��H���ݭn�P�@�ӤW���H���@�P�C');
define('TEXT_FEATURES_PROVIDER_NOTE', '<span class="sp1"><b>�`�N�G</b></span>�аȥ��T�O�z���Ѫ��H���ݭn�P�@�ӤW���H���@�P�C');
define('TEXT_CHECKOUT_WEIGHT_POUND','�S');
define('TEXT_CHECKOUT_WEIGHT_KG','�d�J');
?>
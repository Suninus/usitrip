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

define('NAVBAR_TITLE_1', '����');
define('NAVBAR_TITLE_2', '֧����Ϣ');
define('HEADING_TITLE', '֧����Ϣ');
define('TABLE_HEADING_BILLING_ADDRESS', '���ÿ��˵���ַ');
define('TABLE_HEADING_CONTACT_ADDRESS', 'ͨ�ŵ�ַ');
//define('TEXT_SELECTED_BILLING_DESTINATION', '������������ÿ���ַ�������·�"���������ַ"��ť������ͨѶ����������ѡȡһ���ʼ��˵���ͨѶ����');
define('TABLE_HEADING_BILLING_ADDRESS_EXP','����ʹ�����ÿ�֧��������д��ȷ���ÿ���ַ��billing address������ʹ��������ʽ֧��������д��ȷͨ�ŵ�ַ');
define('TEXT_SELECTED_BILLING_DESTINATION', '');
define('TITLE_BILLING_ADDRESS', '���ÿ�/ͨѶ��ַ:');

define('TABLE_HEADING_PAYMENT_METHOD', '���ʽ');
define('TEXT_SELECT_PAYMENT_METHOD', '��������%d�ַ�ʽ��ѡ���ʺ�����֧����ʽ�����ķ����������Better Business Bureau��BBB����A+������������ȷ����֧�������İ�ȫ��');
define('TITLE_PLEASE_SELECT', '��ѡ��');
define('TEXT_ENTER_PAYMENT_INFORMATION', '����ĿǰΨһ�ĸ��ʽ');

define('TABLE_HEADING_COMMENTS', HEADING_ORDER_COMMENTS);

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '������������,');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '��һ��ȷ�϶���');

//amit added new define
define('TEXT_GUEST_NAME_ERROR','�ο�������д����');
define('TEXT_ARRIVAL_TIME_ERROR','����ʱ������');
define('TEXT_DEPARTURE_TIME_ERROR','����ʱ������');
define('TEXT_GUEST_INFO_FLIGHT_INFO','�ο���Ϣ�ͺ�����Ϣ');
define('TEXT_FLIGHT_INFO_IF_AVAILABLE','������ȷ���ڴ��г̶����ɹ�֮���ٹ����Ʊ��Ȼ���ٵ�¼�������˻����������Ϣ');
define('TEXT_INFO_GUEST_NAME','�˿�%s������');
define('TEXT_FLIGHT_INFO_IF_APPLICABLE','������Ϣ');
define('TEXT_ARRIVAL_AIRLINE_NAME','���չ�˾');
define('TEXT_DEPARTURE_AIRLINE_NAME','���չ�˾');
define('TEXT_ARRIVAL_FLIGHT_NUMBER','�ӻ�����');
define('TEXT_DEPARTURE_FLIGHT_NUMBER','�ͻ�����');
define('TEXT_ARRIVAL_AIRPORT_NAME','�ӻ�����');
define('TEXT_DEPARTURE_AIRPORT_NAME','�ͻ�����');
define('TEXT_ARRIVAL_DATE','�ӻ�����');
define('TEXT_DEPARTURE_DATE','�ͻ�����');
define('TEXT_ARRIVAL_TIME','����ʱ��');
define('TEXT_DEPARTURE_TIME','���ʱ��');
define('TEXT_EMERGENCY_CONTACT_NUM','�����ο��ֻ�:');
define('TEXT_EMERGENCY_CASE_AVALILABLE','(Ϊȷ�����������ʷ������ķ�����Ҫ������ϵ�绰��Ԥ����֧���Լ�������ϵ���衣��ʽ��+���Ҵ��� �绰���룬�磺+86 13888888888)');
define('TEXT_CELL_NUMBER','�ƶ��绰����:');

//define('TEXT_INFO_PROTECT','Ϊ�˱�������Ȩ��,���ǽ���ʵ�������ÿ���֧����ַ����Ϣ,<br />�������ͨ����Ҫ����30�������ң��������ض�ʱ��ο��ܻỨ�Ѹ���ʱ�䡣');
  define('TEXT_INFO_PROTECT','Ϊ�˱�������Ȩ��,���ǽ���ʵ�������ÿ���֧����ַ����Ϣ,<br />�������ͨ����Ҫ���������񣬸�л�������ĵȴ���');

define('TEXT_INFO_GUEST_BODY_WEIGHT','�˿͵�����');
define('TEXT_GUEST_BODY_WEIGHT_ERROR','����д��Ч����!');

define('TEXT_ARRIVAL_TIME_ERROR_MSG_DIS','��������Ч�ĵִ�ʱ��');
define('TEXT_DEPARTURE_TIME_ERROR_MSG_DIS','��������Ч�ĳ���ʱ��');


define('ENTRY_GUEST_FIRST_NAME', ENTRY_FIRST_NAME);
define('ENTRY_GUEST_LAST_NAME', ENTRY_LAST_NAME);

// Points/Rewards Module V2.1rc2a BOF
//define('TABLE_HEADING_REDEEM_SYSTEM', '���ֻ��ۿ� ');
define('TABLE_HEADING_REDEEM_SYSTEM', 'Ԥ����Ʒ��Ϣ ');
define('TABLE_HEADING_REFERRAL', '��ѯϵͳ');
define('TEXT_REDEEM_SYSTEM_START', '�������ÿ���� %s ������������֧���������<br />���������Ĳɹ��� %s .');
define('TEXT_REDEEM_SYSTEM_SPENDING', '��������ʹ�����Ļ��������������� (%s �� %s)&nbsp;&nbsp;->');
define('TEXT_REDEEM_SYSTEM_NOTE', '<span class="pointWarning">�չ��ܶ�����������ߵ㣬������Ҫѡ�񸶿ʽ</span>');
define('TEXT_REFERRAL_REFERRED', '������ᵽ�����ǵ����ѣ����������ǵĵ����ʼ���ַ����� ');
define('R4F_REDEMPTIONS_TOTAL', '�ܼƣ� ');
define('R4F_REDEMPTIONS_BALANCE', '���Ļ��֣�');
define('R4F_REDEMPTIONS_MAX_DISCOUNT', '������������߻��֣�');
define('R4F_REDEMPTIONS_TOTAL_AFTER_DISCOUNT', '�ۿۺ��ܼۣ� ');
define('R4F_REDEMPTIONS_REDEEM_REWARDS', '���ֽ��� ');
define('R4F_REDEMPTIONS_POINTS','����');
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
define('TEXT_GUEST_CHILD_AGE_ERROR','��ͯ�������');//Guest Child Age Error!
define('TEXT_GUEST_CHILD_BIRTH_DATE_ERROR','�ͻ���ͯ�������ڴ���'); //Guest Child Birth Date Error!
define('ENTRY_GUEST_CHILD_AGE', '��ͯ��������'); //Child Birth Date
define('TEXT_GUEST_ERROR_CHILD_BIRTH_DATE','��ʽ������/����/��������'); //Please use this date format: mm/dd/yyyy. e.g. 03/17/2006 for March 17, 2006

define('ENTRY_STREET_ADDRESS_LINE1','��ϸ��ַ:');

define('TEXT_ENTER_COUPON_CODE', '���û���ۿ�ȯ����Դ���');
define('TEXT_NOTES_HEADING_DIS','ע�⣺');
define('TEXT_NOTES_HEADING_HOLDER_CC_NOTE','������д���ÿ���Ϣǰ��ϸ�Ķ���ܰ��ʾ��');
define('TEXT_NOTES_HEADING_BILLING_EDIT_INFORMATION','����д������ȷ��ͨ�ŵ�ַ���Ա����Ǻ���Ϊ���ṩ���ʷ��������л��������ķ������͵ľ�ϲ��Ʒ�� ������ͨ��������༭��ַ���༭�ͱ����ַ��');
define('TEXT_BILLING_INFO_MOBILE', '�ƶ��绰:');

define('AUTHORIZE_MAX_ATTEMPT_OVER_ERROR', '<b>������Ϣ</b><br><b><u>�������ÿ�ˢ��֧��δ�ɹ������Ķ�������Ϣ��</u></b><br><br>�ǳ���л�������ķ���Ԥ�������г̣����Ƿǳ���Ǹ�ظ�֪���ı������ÿ�ˢ��֧��δ�ɹ���������ÿ�ˢ��֧��ʧ�ܵ�ԭ������У����ÿ����Ŵ������ÿ��ѹ���Ч���ޣ�����ÿ��ˢ���޶���ö�Ȳ��㣻���ÿ��˵���ַ��д����ȡ�<br><br>��ע�����������ˢ�����ɹ��󣬳��ڰ�ȫ���ǣ����������ټ���ʹ���������ÿ�֧�����ε�Ԥ��������������������ǽ�������ϸ�˶��������ÿ���Ϣ�����������ķ���������ϵ��ȡ������Ϣ��ͬʱ������Ҳ��������������֧����ʽ���磺����ת�ˣ���㣬PayPal��Ŀǰ��½����PayPal�û��ݲ�֧�֣�����Ʊ/����֧Ʊ/����֧Ʊ��<br><br>����������������ʣ�����ϵ���ǣ�<br>�绰��888-887-2816��������ѣ�<br>1-626-898-7800�����ʣ�<br>0086-4006-333-926���й���<br>���䣺 service@usitrip.com');

define('FLIGHT_NOTES_POP_TITLE','�ض��������ӻ�ע������');
define('FLIGHT_NOTES_POP_CONTENT','���ͬ�λ�ͬ���ൽ����ע������<br><b>�������ײ��г̣�</b><br>���ں���ѽӻ�����Ĳ�Ʒ��ÿ�������ṩһ����ѻ�����Ӧ��������ǲ�ͬ���ൽ��Ĺ����Ҫһ�����ϵĶ����Ӧ����9:00AM-10:00PM֮�䣬ÿ����һ�ζ���Ľ�Ӧ�����ǻ���ȡһ�η������$30.00��<br>ע�⣺��Ϊ���ǵľƵ�ȫ��������EWR������Χ������Ϊ�˸������ʹ����ѽ�Ӧ��Դ��������JFK����LGA�ĺ�����Ϣ���͸����ǣ����Ž�Ӧ��EWR��������Ĺ�������г����Ƶ�Ӳ���ǰ���Ƶꡣ�����޸ĺ�����Ϣ�Ļ���������Ϣ�����Ե��Ӳ���ƾ֤������Ϊʱ����ޡ����������Ϣ�Ķ��ڵ��ӿ�Ʊ����֮ǰ�����ǲ���ȡ�κθ��ķ��á��������ʱ���ӿ�Ʊ�Ѿ����������ǽ���ȡÿ������$30.00���޸ķѡ�<br><b>�������ײ��г̣�</b><br>���ں���ѽӻ�����Ĳ�Ʒ��ÿ�������ṩһ����ѻ�����Ӧ����������ڲ�ͬ���ൽ��Ĺ����Ҫһ�����ϵĶ����Ӧ��������Ҫ��ȡ������ã��۸�����������������ʼ���service@usitrip.comѰ�󱨼ۡ��������Ҫ�޸ĺ�����Ϣ�Ļ�����������Ե��Ӳ���ƾ֤������Ϊʱ����ޡ����������Ϣ�Ķ��ڵ��ӿ�Ʊ����֮ǰ�����ǲ���ȡ�κθ��ķ��á��������ʱ���ӿ�Ʊ�Ѿ����������ǽ���ȡÿ������$30.00���޸ķѡ�');
define('ENTRY_GUEST_GENDER','�Ա�:');
define('TEXT_CHECKOUT_GENDER_MALE','��');
define('TEXT_CHECKOUT_GENDER_FEMALE','Ů');
define('ENTRY_GUEST_DATE_OF_BIRTH','��������:');
define('ERROR_GUEST_BIRTHDATE_FORMAT', 'Birth date should in mm/dd/yyyy format');
define('MODULE_EASY_DISCOUNT_CREDIT_TITLE','Ӧ������');
define('TXT_UR_CREDIT_BAL','�����������Ϊ��');
define('CHECK_APPLY_CREDITS','����ҪӦ��������');
define('ENTRY_GUEST_HEIGHT','��� (ft/cm):');
define('TEXT_DOSE_TOUR_HOTEL_PICKUP','��Ԥ�������ṩ�Ƶ��Ӧ������');
define('TEXT_NOTE_HOTEL_INFO_BELOW','��д�����ľƵ���Ϣ����ϸ�ĵ�ַ��');
define('TEXT_YES','��');
define('TEXT_NO','��');
define('TEXT_TOUR_HOTEL_PICKUP_NOTE','ע�⣺��������޷��������ڵľƵ��Ӧ�����ǽ��ṩ�������������ṩ��ַ������ϳ��ص㡣');

define('TEXT_EXTRA_FEATURES_NOTE', '<span class="sp1"><b>ע�⣺ </b></span>��Ϊ�г����漰���������ڻ�Ʊ, ���չ�˾�涨���ṩ���п��˵ĳ������ڡ��Ա�Ͳ�������������Ϣ�������ȷ�����ṩ����Ϣ��Ҫ�뻤���ϵ���Ϣһ�¡�');
define('TEXT_FEATURES_PROVIDER_NOTE', '<span class="sp1"><b>ע�⣺ </b></span>�����ȷ�����ṩ����Ϣ��Ҫ�뻤���ϵ���Ϣһ�¡�');
define('TEXT_CHECKOUT_WEIGHT_POUND','��');
define('TEXT_CHECKOUT_WEIGHT_KG','ǧ��');
?>
<?php
/*
  $Id: my_answer.php, V2.1rc2a 2008/OCT/01 16:04:22 dsa_ Exp $
  created by Ben Zukrel, Deep Silver Accessories
  http://www.deep-silver.com
  Reformatted by phocea to use CSS display

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
************************************************************/

// Initialisation of some required parameters for the FAQ answers
 if (tep_not_null(POINTS_AUTO_EXPIRES)){
   $answer_expire = 'Reward answer will expire ' . POINTS_AUTO_EXPIRES . ' months from the date issuance.';
 } else {
   $answer_expire = 'Reward answer do not expire and can be accumulated until you decide to use them.';
 }

if (POINTS_PER_AMOUNT_PURCHASE > 1) {
  $point_or_answer = 'answer';
} else {
  $point_or_answer = 'point';
}

define('NAVBAR_TITLE', '�ҵ��˺�');
define('NAVBAR_TITLE1', '���ֽ���FAQ');
define('NAVBAR_TITLE_2', '���ֽ���FAQ');
define('HEADING_TITLE', '���ֽ���FAQ');

// Definitions of the FAQ questions
define('POINTS_FAQ_1', '<b>ʲô�����ķ����ֻ�����</b>');
define('POINTS_FAQ_2', '<b>���ķ��Ļ��ֻ�������������ģ�</b>');
define('POINTS_FAQ_3', '<b>���ֵ��ֽ��ۿ��Ƕ��٣�</b>');
define('POINTS_FAQ_4', '<b>��ζһ����֣�</b>');
define('POINTS_FAQ_5', '<b>ʹ�û��ֿɻ�ȡ���ۿ��Ƕ��٣�</b>');
define('POINTS_FAQ_6', '<b>�ֻ��ֽ����ٻ���Ҫ��</b>');
define('POINTS_FAQ_7', '<b>�ؼ���Ҳ�л���������</b>');
define('POINTS_FAQ_8', '<b>����ʹ�û��ֹ����Ʒʱ���ɻ�ȡ������</b>');
define('POINTS_FAQ_9', '<b>ֻҪע��Ϳɻ�ȡ������</b>');
define('POINTS_FAQ_10', '<b>�������β�Ʒ׬ȡ����</b>');
define('POINTS_FAQ_11', '<b>�Ƽ����������ѻ�ȡ���֡�</b>');
define('POINTS_FAQ_12', '<b>ͨ��������;���ܣ��������ۣ��ϴ���;���˼��������ջ�ȡ���֡�</b>');
define('POINTS_FAQ_13', '<b>���ķ����ֻ�Ĺ�������Щ��</b>');
define('POINTS_FAQ_14', '<b>������й��ڻ��ֵ����ʣ�Ӧ����ϵ˭��</b>');
//define('POINTS_FAQ_15', '<b>��βμӻ��ֻ��</b>');
define('POINTS_FAQ_15', '<b>�������ķ����Ļ�Ա�����Բμӻ��ֻ��</b>');
define('POINTS_FAQ_16', '<b>�������߼���ҵĻ�����ʷ��¼��</b>');
//define('POINTS_FAQ_17', '<b>������ͬ�����Ż�һ��ʹ����</b>');
// Definition of the answer for each of the questions:

// FAQ1
define('TEXT_FAQ_1', 'Ϊ��л���ͻ������ķ�����֧�֣������ر��Ƴ������ķ����ֻ���Ի��ֻ�ȡ��Ԫ�ֽ��ۿ۵ķ�ʽ�����ͻ���<br><br>���ķ����ֻ����൱�򵥣�
��ֻҪ�������ǵĻ��վ�Ļ���ɻ�ȡ���֡����������������β�Ʒ��ʱ�򣬾Ϳ���ʹ��������֣�׬ȡ�ֽ��ۿۡ�<br><br>���ķ����ֻ�����' . db_to_html(tep_get_last_date('USE_POINTS_SYSTEM')) . '��ʽ�����������ڴ�����֮�������β�Ʒ�Ĺ˿;��ɻ�ȡ���֡�');


// FAQ2
define('TEXT_FAQ_2', '��Ϊһ�����ķ����ֻ�����Ĳ����ߣ�������ͨ�����·�ʽ����Ӯȡ���֣�<br />
ע���˺ţ�������;���ܣ��������ۣ��ϴ���;���գ�������Ʒ���Ƽ����ѣ��Լ��ڵ�������վ���������ķ�����<br />
ÿ�ַ�ʽ����Ϊ��Ӯȡһ���Ļ��֣�<a href="' . tep_href_link('points.php') . '" class="sp1">�������</a>���鿴�����ֵ�����ֻ����Ҫ���ķ�����֤ͨ������ܽ����ֻ��������˺ŵġ�<br />
һ�����ۻ���һ�����֣�������¶���ʱ����Щ������Ϊ�ֽ��ۿۣ���ȡ�Żݡ�<br />
���ķ�����ÿһ�����β�Ʒ����һ���Ļ��ַ�ֵ�������������ǵ����β�Ʒҳ��鿴��');


// FAQ3
define('TEXT_FAQ_3', (1/REDEEM_POINT_VALUE).'����=1��Ԫ��'.$currencies->format(1).'����');

// FAQ4
if(USE_POINTS_FOR_REDEEMED == 'false')  {
	define('TEXT_FAQ_4', '���ֶһ�����Ŀǰ��ʱ�رգ����ں�ʱ�ٿ��Ŵ˹��ܣ�����ǿ�ҽ����������鿴��ҳ�棬�Ա�֤�˽���ֻ�����¶�̬��');
}else{
	define('TEXT_FAQ_4', 'Ԥ���г�ʱ���ڽ��˹����еĸ�����Ϣҳ���·������ῴ��һ�����һ����֡��İ�ť�������ť��ϵͳ���Զ�Ϊ���һ����֡�<br />
�ڽ���ȷ��ҳ�棬���ῴ���˴ζ�����ͨ��ʹ�û�������ȡ���ֽ��ۿۡ�һ������ȷ�ϣ�����ʹ�õĻ��ֻ������ķ������˺������Զ��۳���');
}

// FAQ5
define('TEXT_FAQ_5', '���ֿɻ�ȡ���ۿ��Ǹ�����Ŀǰ����Ļ��֣��������ķ��������Ĵ�������Ԥ�����г����������������ġ�<br />�����ֽ��ۿ۱���<br />'.TEXT_SAVINGS);


// FAQ6 - conditionnal depending on the point limit value set in admin
if (POINTS_LIMIT_VALUE  > 0)  {
	define('TEXT_FAQ_6', '
	Ŀǰ���һ����ֵ���СֵΪ�� <b>' . number_format(POINTS_LIMIT_VALUE) . '</b> �� <b>(' . $currencies->format(tep_calc_shopping_pvalue(POINTS_LIMIT_VALUE)) . ')' . '</b> <br />
<br />����ǿ�ҽ����������鿴��ҳ�棬�Ա�֤�˽���ֻ�����¶�̬��
	<p align="right"><small>���������ڣ� ' . db_to_html(tep_get_last_date('POINTS_LIMIT_VALUE')) . '</small></p>');
} else {
	define('TEXT_FAQ_6', 'Ŀǰ������û�жԶһ����ֵ���Сֵ��Ҫ��<br />��ע��������������ķ������˺���ʹ�û����������Ʒ���ڽ���ʱ����Ȼ��Ҫѡ��һ��֧����ʽ��');
	
	
}

// FAQ7 - conditionnal depending on value set in admin for giving point on specials
if(USE_POINTS_FOR_SPECIALS == 'false')  {
	define('TEXT_FAQ_7', 'Ŀǰ���ؼ������޻������͡�
<br /> <br />����ǿ�ҽ����������鿴��ҳ�棬�Ա�֤�˽���ֻ�����¶�̬��
	<p align="right"><small>���������ڣ� ' . db_to_html(tep_get_last_date('USE_POINTS_FOR_SPECIALS')) . '</small></p>');
} else {
	define('TEXT_FAQ_7', '�ǵġ������������ֻʱ���ǽ��ؼ���Ҳ�������ڵġ�
<br />');
}

// FAQ8
define('TEXT_FAQ_8','���ԡ�������ʹ�û��ֹ����Ʒ�󣬰�����ʵ��֧����������������֣�Ҳ����ÿ����1$�ɻ���2�����ķ����֡�');

// FAQ9
define('TEXT_FAQ_9','�ǵģ�������ķ�����Աע�ἴ�ɻ�ȡ'.NEW_SIGNUP_POINT_AMOUNT.'���֣��������ĸ��������ֿɻ���100���֣��������Ƹ������ݲ��ֻ��30���֣����Ƶ�ַ���ֻ��30���֣�������ϵ��ʽ���ֻ��'.(NEW_SIGNUP_POINT_AMOUNT-30-30).'���֣��������ע�����̺�ɻ���200�֡�');

// FAQ10
define('TEXT_FAQ_10','�����г̿ɻ�û��ֽ�����Ŀǰ�ļ��㷽ʽΪ��ÿ����1��Ԫ��'.POINTS_PER_AMOUNT_PURCHASE.'�����֡�
�����ɹ�����󣬻����Զ����͡����жһ����ּ�¼������ <a href="'.tep_href_link('points_actions_history.php').'" class="sp1">����/�һ���¼</a>  �пɲ�ѯ������û��ʹ��ʱ�����ƣ�������������ʱ��ʹ�����ǡ�');

// FAQ11
if (tep_not_null(USE_REFERRAL_SYSTEM)){
	define('TEXT_FAQ_11','�����ǵ���վ�Ƽ����������ݻ����ѣ����ǳɹ��µ����������'.USE_REFERRAL_SYSTEM.'���ֽ�����');
}else{
	define('TEXT_FAQ_11', 'Ŀǰ�˹����ѱ����á�
	<p align="right"><small>���������ڣ� ' . db_to_html(tep_get_last_date('USE_REFERRAL_SYSTEM')) . '</small></p>');
}

// FAQ12
if (tep_not_null(USE_POINTS_FOR_REVIEWS)){
	define('TEXT_FAQ_12', '�����ķ���ͨ�������������θ��ܾ������ۣ�;�����գ����������ǸĽ����� Ҳ�ɰ������ǵ������ÿ�ѡ���ʺϵ�������·�Ͳ�Ʒ��<br /> 
ÿ��ͨ����֤�����ۣ��ɻ�� <b>'.USE_POINTS_FOR_REVIEWS.'</b> �����֡�<br />
ÿ��ͨ����֤����Ƭ���ɻ�� <b>100</b> �����֡�<br /><br />
�������ۺ���Ƭ��Ҫ��������Ҫ��<br />
 �������ԭ����<br />
 �������������ξ������·��ص����⡣<br />
 �񲻿ɸ����Ѿ����������ݡ�<br />
 �񷢱��������Ҫ�͹ۿ��š�<br />
 �����ݲ��ɰ���������Ϣ����ҵ��������ص����ӵȡ�<br />
 �񲻸����á�ɧ�š�����в���˵�����ȫ��<br /><br />
���ķ������������������������ۺ���Ƭ���н�ֹ��ɾ����Ȩ����<br />
���ķ��������乤����Ա�����ݴ���ֽ��и��ĵ�Ȩ����<br />
���ķ��������κη�ʽΪ�˿��������ۺ���Ƭ�е����Ρ�
');
}else{
	define('TEXT_FAQ_12', 'Ŀǰ�˹����ѱ����á�
	<p align="right"><small>���������ڣ� ' . db_to_html(tep_get_last_date('USE_POINTS_FOR_REVIEWS')) . '</small></p>');
}

// FAQ13
define('TEXT_FAQ_13', '�����Բ鿴 <a href="' . tep_href_link(FILENAME_REWARDS4FUN_TERMS) . '" class="sp1">���ķ����ֹ���</a> ҳ�棬�˽⵽���ǻ��ֻ����ϸ���� <br />��ע�⣬���Ǳ���Ȩ���ı��������߶���������֪ͨ�����Ρ����Ǳ����Ի���������޸ĵ�Ȩ����');

// FAQ14
define('TEXT_FAQ_14', '�������ķ����ֻ���κ����⣬�������� <a href="' . tep_href_link(FILENAME_CONTACT_US) . '" class="sp1">��ϵ����</a>��');

// FAQ15
//define('TEXT_FAQ_15', '�ڵ�¼���ķ���֮�󼴿����ɼ��롣��ϸ��Ϣ�� <a href="' . tep_href_link('points.php') . '" class="sp1">��������</a>��');

// FAQ16
define('TEXT_FAQ_15', '���ԡ�ֻҪ�������ķ������û���ϵͳ�Զ�Ĭ�����ǲ�����ֻ�Ļ�Ա��');

// FAQ17
define('TEXT_FAQ_16', '���ԡ��������ڵ�¼���������˺�ҳ��鿴��<a href="' . tep_href_link('points_actions_history.php') . '" class="sp1">�������</a>��');

// FAQ18
//define('TEXT_FAQ_17', '�����ԡ����ķ����ֻ������ͬ��վ�������Żݻһ��ʹ�á�');


define('TEXT_CANT_FIND','�޷��ҵ�������Ҫ�ģ�');	
define('TEXT_CLICK_HERE','�������');
define('TEXT_CANT_FIND_NEXT','��������ϵ��');


?>

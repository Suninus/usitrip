<?php
/*
  $Id: create_account_process.php,v 1.1.1.1 2003/03/22 16:56:02 nickle Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 osCommerce
  Released under the GNU General Public License

  Traditional Chinese language pack(Big5 code) for osCommerce 2.2 ms1
  Community: http://forum.kmd.com.tw 
  Author(s): Nickle Cheng (nickle@mail.kmd.com.tw)
  Released under the GNU General Public License ,too!!

*/

define('NAVBAR_TITLE_1', '����һ���˺�');
define('NAVBAR_TITLE_2', '����');
define('HEADING_TITLE', '�ҵ��˺�');

define('EMAIL_SUBJECT', '��ӭ���� ' . STORE_NAME);
/*define('EMAIL_GREET_MR', '�װ��� ' . stripslashes($HTTP_POST_VARS['lastname']) . ',' . "����\n\n");
define('EMAIL_GREET_MS', '�װ��� ' . stripslashes($HTTP_POST_VARS['lastname']) . ',' . "С��\n\n");*/
define('EMAIL_GREET_MR', '�װ��� ' . stripslashes($HTTP_POST_VARS['lastname']) . '��������,' . "\n\n");
define('EMAIL_GREET_MS', '�װ��� ' . stripslashes($HTTP_POST_VARS['lastname']) . 'С������,' . "\n\n");
define('EMAIL_GREET_NONE', '�װ��� ' . stripslashes($HTTP_POST_VARS['firstname']) . ',' . "\n\n");
define('EMAIL_WELCOME', '���Ƿǳ���ֿ�Ļ�ӭ������ <b>' . STORE_NAME . '</b>' . "\n");
/*define('EMAIL_TEXT', '����������������������Ϊ���ṩ��<b>���Ϸ���</b>. ��Щ�������:' . "\n\n" . '<li><b>���ﳵ</b> - Any products added to your online cart remain there until you remove them, or check them out.' . "\n" . '<li><b>Address Book</b> - We can now deliver your products to another address other than yours! This is perfect to send birthday gifts direct to the birthday-person themselves.' . "\n" . '<li><b>Order History</b> - View your history of purchases that you have made with us.' . "\n" . '<li><b>Products Reviews</b> - Share your opinions on products with our other customers.' . "\n\n");*/
define('EMAIL_TEXT', '����Ϊ�����ṩ<b>���Ϸ���</b>��' . "\n\n" . '<li><b>1.�ǻ��͹��ﳵ</b>��'."\n".'          �ŵ����ﳵ����Ʒ���������������Ƴ�����ʣ�������Ʒ����һֱ���ڹ��ﳵ��' . "\n\n" . '<li><b>2.����ͨѶ¼</b>��'."\n".'          �����ṩ�����������Ʒ��ֱ�Ӽ��͸�ͨѶ¼�������! ����õ�������������ʱ�����ǿ����������������������ֱ���͵���������' . "\n\n" . '<li><b>3.���������¼</b>��'."\n".'          ��������ʱ��¼����ѯ�ѹ�����Ʒ������״̬����¼' . "\n\n" . '<li><b>4.��Ʒ����</b>��'."\n".'          �������Ĺ��ﾭ�������������Ȥ����Ʒ' . "\n\n".'<li><b>5.��Ʒ֪ͨ</b>��'."\n".'          ��Ʒ֪ͨ����������ʱ�������ǵ���Ʒ��̬,��������ʧ�ؼ���Ʒ�������Żݵ�����' . "\n\n");
define('EMAIL_CONTACT', '�κ��й����Ϸ���Ľ��Ի����ʣ���д�Ÿ�������mailto:' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>��ע:</b>��������ʼ���ַ(E-mail address)�������ǵĿͻ��ṩ�����������Ը������Ա�������š� mailto:' . STORE_OWNER_EMAIL_ADDRESS . '�����ǻ����̽���������ɾ����' . "\n");
define('EMAIL_ACCOUNT_FOOTER', '<br><br>������ϵ���������usitripһ���������!' . "<br><br>".'��ϵ�,'. "<br><br>". '�»�Ա�ͷ�'."<br>".'<a href="'.HTTP_SERVER.'" target="_blank">www.usitrip.com</a>'. "<br> <br>");

	
define('CONFI_NEWSLLETTER_SUBJECT','��ӭ�������ķ�����usitrip��������Ѷ��');
?>

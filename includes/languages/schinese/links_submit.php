<?php
/*
  $Id: links_submit.php,v 1.2 2004/03/05 00:36:42 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', '����');
define('NAVBAR_TITLE_2', '�ύ����');

define('HEADING_TITLE', '��ϵ��Ϣ');

define('TEXT_MAIN', '����д���±�����ύ������վ��');

define('EMAIL_SUBJECT', '��ӭ���� ' . STORE_NAME . ' ���ӽ�����');
define('EMAIL_GREET_NONE', '�װ��� %s' . "\n\n");
define('EMAIL_WELCOME', '���ǻ�ӭ���ǵ� <b>' . STORE_NAME . '</b> ���ӽ����ƻ���' . "\n\n");
define('EMAIL_TEXT', '���������ѳɹ��ύ�� ' . STORE_NAME . '��ͨ����˺��������ӽ�������ӵ����ǵ��б��ϡ������յ�һ��֪ͨ�ύ״̬���ʼ�������ڽ�������48Сʱ����δ���յ�����ʼ������������ύ����ǰ��������ϵ��' . "\n\n");
define('EMAIL_CONTACT', 'Ϊ������������ϵ�����ƻ����������͵����ʼ����� ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>Note:</b> ��������ʼ���ַ�Ǹ�������һ�����ڵݽ���������κ����⣬�뷢�͵����ʼ��� ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
define('EMAIL_OWNER_SUBJECT', '���ӵݽ���' . STORE_NAME);
define('EMAIL_OWNER_TEXT', 'һ���µ������ύ��' . STORE_NAME . '��Ŀǰ��δ�����׼����ȷ��������ӣ���������' . "\n\n");

define('TEXT_LINKS_HELP_LINK', '&nbsp;Help&nbsp;[?]');

define('HEADING_LINKS_HELP', '�������');
define('TEXT_LINKS_HELP', '<b>��վ���ơ�</b> Ϊ������վ��дһ��������<br><br><b>��վ��ַURL:</b> ����������վ��ַ�����а��� \'http://\'.<br><br><b>����</b> ��������վ����һ���ʵ������<br><br><b>������</b> ��Ҫ����������վ��<br><br><b>Image URL:</b> ��д������վLOGOͼ���ַ�����а��� \'http://\'. ���ͼ�꽫����������վ������ʾ��<br>����� http://your-domain.com/path/to/your/image.gif <br><br><b>ȫ����</b> ����ȫ����<br><br><b>Email:</b> ���ĵ����ʼ���ַ��������һ����Ч�ĵ����ʼ����������յ������ʼ���<br><br><b>����ҳ��</b> ����������ҳ���Ե�URL��ַ�������ӵ����ǵ���վ��������Ϊ/չʾ��<br>����� http://your-domain.com/path/to/your/links_page.php');
define('TEXT_CLOSE_WINDOW', '<u>�رմ���</u> [x]');

// VJ todo - move to common language file
define('CATEGORY_WEBSITE', '��վ����');
define('CATEGORY_RECIPROCAL', '����ҳ����');

define('ENTRY_LINKS_TITLE', '��վ���ơ�');
define('ENTRY_LINKS_TITLE_ERROR', '���ӱ������������� ' . ENTRY_LINKS_TITLE_MIN_LENGTH . ' ���ַ���');
define('ENTRY_LINKS_TITLE_TEXT', '*');
define('ENTRY_LINKS_URL', 'URL:');
define('ENTRY_LINKS_URL_ERROR', 'URL ����������� ' . ENTRY_LINKS_URL_MIN_LENGTH . '  ���ַ���');
define('ENTRY_LINKS_URL_TEXT', '*');
define('ENTRY_LINKS_CATEGORY', '����');
define('ENTRY_LINKS_CATEGORY_TEXT', '*');
define('ENTRY_LINKS_DESCRIPTION', '������');
define('ENTRY_LINKS_DESCRIPTION_ERROR', '��������������� ' . ENTRY_LINKS_DESCRIPTION_MIN_LENGTH . ' ���ַ���');
define('ENTRY_LINKS_DESCRIPTION_TEXT', '*');
define('ENTRY_LINKS_IMAGE', 'Image URL:');
define('ENTRY_LINKS_IMAGE_TEXT', '');
define('ENTRY_LINKS_CONTACT_NAME', 'ȫ����');
define('ENTRY_LINKS_CONTACT_NAME_ERROR', '����ȫ������������� ' . ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH . ' ���ַ���');
define('ENTRY_LINKS_CONTACT_NAME_TEXT', '*');
define('ENTRY_LINKS_RECIPROCAL_URL', '����ҳ��');
define('ENTRY_LINKS_RECIPROCAL_URL_ERROR', '����ҳ����������� ' . ENTRY_LINKS_URL_MIN_LENGTH . ' ���ַ���');
define('ENTRY_LINKS_RECIPROCAL_URL_TEXT', '*');
?>

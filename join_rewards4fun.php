<?php
/*
  $Id: links.php,v 1.2 2004/03/12 19:28:57 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

require('includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_JOIN_REWARDS4FUN);

	//seo��Ϣ
	$the_title = db_to_html('���ֽ���-���ķ�������');
	$the_desc = db_to_html('�Ͽ��ж�����,Ӯȡ���ķ����ְ�,��Ծ���,���ֶ��,����׼�������ķ����������β�Ʒʱ,�Ϳɽ����û��ֻ����ֽ��ۿ�,���Ļ�����Զ������,�κ�ʱ��ʹ�þ���.');
	$the_key_words = db_to_html('���λ��ֽ���,�ؼ�������,�ؼ�����');
	//seo��Ϣ end

  $content = CONTENT_JOIN_REWARDS4FUN;

  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>

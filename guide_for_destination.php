<?php
/*
  $Id: specials.php,v 1.1.1.1 2004/03/04 23:38:03 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_TOUR_GUILD_FOR_DESTINATION);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_TOUR_GUILD_FOR_DESTINATION));

	//seo��Ϣ
	$the_title = db_to_html('Ŀ�ĵ�ָ��-�������ξ���Ŀ¼-���ķ�������');
	$the_desc = db_to_html('�ۺ��������ξ���Ŀ¼,������ϸ�����ξ����μǹ���,���ξ�������,���ξ������,���ξ���ͼƬ,������·�Ƽ��ȷḻ��������Ѷ��');
	$the_key_words = db_to_html('���ι���,���ξ���,�����μ�');
	//seo��Ϣ end

  $content = CONTENT_TOUR_GUILD_FOR_DESTINATION;

  require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_FS_INCLUDES . 'application_bottom.php');
?>

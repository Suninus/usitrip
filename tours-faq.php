<?php
/*
  $Id: links.php,v 1.2 2004/03/12 19:28:57 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  //require(DIR_FS_LANGUAGES . $language . '/payment-faq.php');

$where_exc = '';
if((int)$_GET['information_id']){
	$where_exc = ' AND information_id='.(int)$_GET['information_id'].' ';
}

$info_sql = tep_db_query('SELECT information_id,info_title,description FROM `information` WHERE info_type ="������ʶ" AND visible=1 '.$where_exc.' order by v_order limit 1');
$info_rows = tep_db_fetch_array($info_sql);

//׷�ӵ���
$breadcrumb->add(db_to_html('��������'), tep_href_link('tours-faq.php'));
$breadcrumb->add(db_to_html(tep_db_output($info_rows['info_title'])), "");

	//seo��Ϣ
	$the_title = db_to_html('��������-���ķ�������');
	$the_desc = db_to_html('��');
	$the_key_words = db_to_html('��');
	//seo��Ϣ end

$other_css_base_name = 'help';
  $content = 'tours-faq';

  require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_FS_INCLUDES . 'application_bottom.php');
?>

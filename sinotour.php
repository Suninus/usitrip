<?php
/*
  $Id: links.php,v 1.2 2004/03/12 19:28:57 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');


	//seo��Ϣ
	$the_title = db_to_html('�������-���ķ���');
	$the_desc = db_to_html('��');
	$the_key_words = db_to_html('��');
	//seo��Ϣ end

  $add_div_footpage_obj = true;
  $content = 'sinotour';
	$breadcrumb->add(db_to_html('�������'), 'sinotour.php');
  require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_FS_INCLUDES . 'application_bottom.php');

  
?>
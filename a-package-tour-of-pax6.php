<?php

  require('includes/application_top.php');
 
 //׷�ӵ���
$breadcrumb->add(db_to_html('�����״�6�˰����¸���'), "");

  
 $force_include_index_js = 'true';

  $content = 'a-package-tour-of-pax6';

	//require('advanced_search.php');
 require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

 require(DIR_FS_INCLUDES . 'application_bottom.php');
?>
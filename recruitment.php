<?php
  require('includes/application_top.php');

// define our link functions
  require(DIR_FS_FUNCTIONS . 'links.php');

  require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_ABOUT_US);

	//seo��Ϣ
	$the_title = db_to_html('��������-���ķ���');
	$the_desc = db_to_html('��');
	$the_key_words = db_to_html('��');
	//seo��Ϣ end

  $add_div_footpage_obj = true;
  $content = 'recruitment';
	$breadcrumb->add(db_to_html('�˲���Ƹ'), 'recruitment.php');

  require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_FS_INCLUDES . 'application_bottom.php');
  
?>
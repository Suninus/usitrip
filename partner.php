<?php

  require('includes/application_top.php');

// define our link functions
  require(DIR_FS_FUNCTIONS . 'links.php');

 require(DIR_FS_LANGUAGES . $language . '/site-map.php');

	//seo��Ϣ
	$the_title = db_to_html('��վ��ͼ-���ķ�������');
	$the_desc = db_to_html('��');
	$the_key_words = db_to_html('��');
	//seo��Ϣ end

  $content = 'partner';
$breadcrumb->add(db_to_html('�������'), 'partner.php');

// ��վ���˿���
if (strtolower(AFFILIATE_SWITCH) === 'true') {
  require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_FS_INCLUDES . 'application_bottom.php');
} else {
	echo '<div align="center">�˹����ݲ����ţ���<a href="' . tep_href_link('index.php') . '">��ҳ</a></div>';
}
?>
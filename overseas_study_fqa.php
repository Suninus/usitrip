<?php
/**
 * ������ѧFAQ
 * @package 
 * �ж����ĳ֧����ʽ�Ѿ��رվͲ�����ʾ������ݣ������������Ÿ������
 */

require('includes/application_top.php');

//seo��Ϣ
$the_title = db_to_html('������ѧFAQ-���ķ���');
$the_desc = db_to_html('��');
$the_key_words = db_to_html('��');
//seo��Ϣ end


$add_div_footpage_obj = true;
$content = 'overseas_study_fqa';
$breadcrumb->add(db_to_html('������ѧFAQ'), tep_href_link('overseas_study_fqa.php'));

require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
require(DIR_FS_INCLUDES . 'application_bottom.php');
?>

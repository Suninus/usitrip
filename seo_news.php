<?php
  require('includes/application_top.php');
  moved_permanently_301(tep_href_link('seo_news.php'));
  
  $breadcrumb->add(db_to_html('������Ѷ'), tep_href_link('seo_news.php'));

  $seo_title = '���������Σ�ŷ�����Σ�������Ѷ����-���ķ�������';
  $seo_keyword = '��������,ŷ������,������Ѷ';
  $seo_desc = '���ķ���Ϊ���ṩ����������ŷ�������г�Ԥ�����Ƶ�Ԥ�������ǵĹ˿Ϳ����������෱�࣬���ݷḻ������Ϊ�����Ƶ������ײ� ���Լ��������ʵķ���';
	//seo��Ϣ
	$the_desc = $seo_desc;
	$the_key_words = $seo_keyword;
	$the_title = $seo_title;
	$the_desc = db_to_html($the_desc);
	$the_key_words = db_to_html($the_key_words);
	$the_title = db_to_html($the_title);
	//seo��Ϣ end

  $content = 'seo_news';

  require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_FS_INCLUDES . 'application_bottom.php');
?>

<?php

  require('includes/application_top.php');
 
 //׷�ӵ���
$breadcrumb->add(db_to_html('Ŀ�ĵ�ָ��'), tep_href_link('destination_guide.php'));

//Ŀǰֻ��ʾ������ָ��
if(!(int)$_GET['dg_categories_id']){
	$dg_categories_id = $_GET['dg_categories_id'] = 1; //�Ǳ�����id
}else{
	$dg_categories_id = $_GET['dg_categories_id'];
}

$sql = tep_db_query('SELECT * FROM `destination_guide_categories` c,`destination_guide_categories_description` cd WHERE c.dg_categories_id ="'.(int)$dg_categories_id.'" AND c.dg_categories_id=cd.dg_categories_id AND c.dg_categories_state =1 AND c.parent_id =0 Limit 1 ');
$rows = tep_db_fetch_array($sql);


if((int)$dg_categories_id){
	$breadcrumb->add(db_to_html(tep_db_output($rows['dg_categories_name'])),'');
	
	//seo��Ϣ
	$the_desc = (tep_not_null($rows['meta_description'])) 
					? strip_tags($rows['meta_description'])
					: strip_tags($rows['dg_categories_name']);
	$the_key_words = (tep_not_null($rows['meta_keywords'])) 
						? strip_tags($rows['meta_keywords'])
						: strip_tags($rows['dg_categories_name']);
	$the_title = (tep_not_null($rows['meta_title'])) 
					? strip_tags($rows['meta_title'])
					: strip_tags($rows['dg_categories_name']);
	$the_desc = db_to_html($the_desc);
	$the_key_words = db_to_html($the_key_words);
	$the_title = db_to_html($the_title);
	//seo��Ϣ end
}
  $content = 'destination_guide';


 require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

 require(DIR_FS_INCLUDES . 'application_bottom.php');
?>
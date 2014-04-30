<?php

  require('includes/application_top.php');
 
 //׷�ӵ���
$breadcrumb->add(db_to_html('Ŀ�ĵ�ָ��'), tep_href_link('destination_guide.php'));

if(!(int)$_GET['dg_categories_id']){
	$dg_categories_id = $_GET['dg_categories_id'] = 1; //�Ǳ�����id
}

$sql = tep_db_query('SELECT * FROM `destination_guide_categories` c,`destination_guide_categories_description` cd WHERE c.dg_categories_id ="'.(int)$dg_categories_id.'" AND c.dg_categories_id=cd.dg_categories_id AND c.dg_categories_state =1 AND c.parent_id >0 Limit 1 ');
$rows = tep_db_fetch_array($sql);

if((int)$dg_categories_id){
	$breadcrumb->add(db_to_html(tep_db_output($rows['dg_categories_name'])),tep_href_link('destination_guide_details.php','dg_categories_id='.(int)$dg_categories_id));

	//Ĭ����ʾ�ſ�ҳ
	$full_text_conttent ='';
	switch($_GET['field']){
		case 'overview':
			$field = 'overview';
			$text_title = (tep_db_output($rows['dg_categories_name']).'�ſ�');
			$text_conttent = nl2br(cutword($rows['overview_info'],360));
			if(strlen($rows['overview_info'])>360){
				$text_conttent.= ' <a href="javascript:void(0)" onClick="show_all_text(0)" style="color:#3299DB">�鿴��ϸ</a>';
			}
			$full_text_conttent = nl2br($rows['overview_info']);
			$e_style ='';
			$overview_class = 'class="s"';

		break;
		case 'lodging':
			$field = 'lodging';
			$text_title = (tep_db_output($rows['dg_categories_name']).'ס��');
			$text_conttent = $rows['lodging_info'];
			$e_style =' style="width:auto" ';
			$lodging_class = 'class="s"';
		break;
		case 'traffic':
			$field = 'traffic';
			$text_title = (tep_db_output($rows['dg_categories_name']).'��ͨ');
			$text_conttent = $rows['traffic_info'];
			$e_style =' style="width:auto" ';
			$traffic_class = 'class="s"';
		break;
		case 'shopping':
			$field = 'shopping';
			$text_title = (tep_db_output($rows['dg_categories_name']).'����');
			$text_conttent = $rows['shopping_info'];
			$e_style =' style="width:auto" ';
			$shopping_class = 'class="s"';
		break;
		case 'food':
			$field = 'food';
			$text_title = (tep_db_output($rows['dg_categories_name']).'��ʳ');
			$text_conttent = $rows['food_info'];
			$e_style =' style="width:auto" ';
			$food_class = 'class="s"';
		break;
		case 'features':
			$field = 'features';
			$text_title = (tep_db_output($rows['dg_categories_name']).'������ɫ');
			$text_conttent = $rows['local_features'];
			$e_style =' style="width:auto" ';
			$features_class = 'class="s"';
		break;
		case 'map':
			$field = 'map';
			$text_title = (tep_db_output($rows['dg_categories_name']).'��ͼ');
			if(preg_match('/^\<iframe/',$rows['map_image'])){
				$text_conttent = $rows['map_image'];
			}elseif(preg_match('/^http:\/\//',$rows['map_image'])){
				$text_conttent = '<iframe width="712" height="420" frameborder="0" scrolling="no" src="';
				$text_conttent .= $rows['map_image'];
				$text_conttent .= '" marginwidth="0" marginheight="0" ></iframe>';
			}elseif(tep_not_null($rows['map_image'])){
				$text_conttent = '<img src="images/destination_guide/'.$rows['map_image'].'" alt="'.$text_title.'" border="0" />';
			}
			
			$e_style =' style="width:auto" ';
			$map_class = 'class="s"';
		break;
		default:
			$field = 'overview';
			$text_title = (tep_db_output($rows['dg_categories_name']).'�ſ�');
			$text_conttent = nl2br(cutword($rows['overview_info'],360));
			if(strlen($rows['overview_info'])>360){
				$text_conttent.= ' <a href="javascript:void(0)" onClick="show_all_text(0)" style="color:#3299DB">�鿴��ϸ</a>';
			}
			$full_text_conttent = nl2br($rows['overview_info']);
			$e_style ='';
			$overview_class = 'class="s"';
	}

	$breadcrumb->add(db_to_html($text_title),tep_href_link('destination_guide_details.php','dg_categories_id='.(int)$dg_categories_id.'&field='.$field));
	
	$description_name = $field.'_meta_title';
	$keywords_name = $field.'_meta_keywords';	
	$title_name = $field.'_meta_title';
		
	//seo��Ϣ
	$the_desc = (tep_not_null($rows[$description_name])) 
					? strip_tags($rows[$description_name])
					: strip_tags($rows['meta_description']);
	$the_key_words = (tep_not_null($rows[$keywords_name])) 
						? strip_tags($rows[$keywords_name])
						: strip_tags($rows['meta_keywords']);
	$the_title = (tep_not_null($rows[$title_name])) 
					? strip_tags($rows[$title_name])
					: strip_tags($rows['meta_title']);
	
	$the_desc = db_to_html($the_desc);
	$the_key_words = db_to_html($the_key_words);
	$the_title = db_to_html($the_title);
	//seo��Ϣ end
}

$content = 'destination_guide_details';
$other_css_base_name = 'destination_guide';

 require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

 require(DIR_FS_INCLUDES . 'application_bottom.php');
?>
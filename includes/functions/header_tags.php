<?php
// /catalog/includes/functions/header_tags.php
// WebMakers.com Added: Header Tags Generator v2.0

////
// Get products_head_title_tag
// TABLES: products_description
function tep_get_header_tag_products_title($product_id) {
  global $languages_id, $HTTP_GET_VARS;

  $product_header_tags = tep_db_query("select products_head_title_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where language_id = '" . (int)$languages_id . "' and products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'");
  $product_header_tags_values = tep_db_fetch_array($product_header_tags);

  return clean_html_comments($product_header_tags_values['products_head_title_tag']);
  }


////
// Get products_head_keywords_tag
// TABLES: products_description
function tep_get_header_tag_products_keywords($product_id) {
  global $languages_id, $HTTP_GET_VARS;

  $product_header_tags = tep_db_query("select products_head_keywords_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where language_id = '" . (int)$languages_id . "' and products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'");
  $product_header_tags_values = tep_db_fetch_array($product_header_tags);

  return $product_header_tags_values['products_head_keywords_tag'];
  }


////
// Get products_head_desc_tag
// TABLES: products_description
function tep_get_header_tag_products_desc($product_id) {
  global $languages_id, $HTTP_GET_VARS;

  $product_header_tags = tep_db_query("select products_head_desc_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where language_id = '" . (int)$languages_id . "' and products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'");
  $product_header_tags_values = tep_db_fetch_array($product_header_tags);

  return $product_header_tags_values['products_head_desc_tag'];
  }

///howard added for Categories Pages, return false or an Array
function tep_get_categories_header_tags_array($categories_id, $tab_tag){
	//echo $categories_id.'||'. $tab_tag;	
	global $languages_id;
	if(!tep_not_null($tab_tag)){ return false; }
	
	if($tab_tag=="tours" ){
		$sql = tep_db_query("select c.categories_id, cd.categories_head_desc_tag AS meta_description, cd.categories_head_title_tag AS meta_title, cd.categories_head_keywords_tag AS meta_keywords FROM " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $categories_id . "' and cd.categories_id = c.categories_id and cd.language_id = '" . $languages_id . "' limit 1 ");
		//$row = MCache::fetch_categories($categories_id);
		$row = tep_db_fetch_array($sql);
	}else{
		$sql = tep_db_query('SELECT categories_id, meta_title, meta_keywords, meta_description FROM `categories_meta_tags` WHERE categories_id="'.(int)$categories_id.'" and tab_tag ="'.tep_db_prepare_input($tab_tag).'" limit 1 ');
		$row = tep_db_fetch_array($sql);
	}	
	if((int)$row['categories_id'] && (tep_not_null($row['meta_title']) && tep_not_null($row['meta_keywords']) && tep_not_null($row['meta_description']) )){
		$Array = array();
		$Array['meta_title'] = $row['meta_title'];
		$Array['meta_keywords'] = $row['meta_keywords'];
		$Array['meta_description'] = $row['meta_description'];
		return $Array;
	}else{	/* �����̨û������Tab Meta��Ϣ��ʱ��,�Զ�ʹ��ģ�壨������+�̶����֣��������̨���ã���ʹ�����õ���Ϣ*/
		switch($tab_tag){
			case "introduction":
				$title_str = '%s����,%s���ξ������ - ���ķ���';
				$description_str = '%s�������,���ķ���%s���ξ������,�鿴%s������Щ���ξ���';
				$keywords_str = '%s����,%s���ξ���';
			break;
			case "vcpackages":
				$title_str = '%s����,%s�ȼ�,%s���ζȼ��г���·������Ԥ�� - ���ķ���';
				$description_str = '%s����,%s�ȼ��г���·������,�۸�,������Ϣ,���ķ���Ϊ���ṩ%s���ζȼ��г�����������Ԥ����רҵ����';
				$keywords_str = '%s����,%s�ȼ�';
			break;
			case "recommended":
				$title_str = '%s�����г���·�Ƽ�,%s�������Ƽ� - ���ķ���';
				$description_str = '%s�����г���·�Ƽ�,%s�������Ƽ�,���ķ����Ƽ���ȥ%s������·,�����ż۸�,������Ϣ���ṩ���Ƽ���%s��������Ԥ����רҵ����';
				$keywords_str = '%s�����Ƽ�';
			
			break;
			case "special":
				$title_str = '�ؼ�%s�����г���·, �ؼ�%s����������Ԥ�� - ���ķ���';
				$description_str = '�ؼ�%s�����г���·,%s�ؼ�������,�ؼ�ȥ%s������·,�����ż۸�,������Ϣ������Ԥ����רҵ����';
				$keywords_str = '%s�����ؼ�';
			
			break;
			case "diy": 
				$title_str = '%s������,%s������������Ԥ�� - ���ķ���';
				$description_str = '%s������,%s��������,�ؼ�ȥ%s��������·,�����ż۸�,������Ϣ������Ԥ����רҵ����';
				$keywords_str = '%s������';
			break;
			default:
				$title_str = '%s����,ȥ%s���μ۸�_%s�����г���·����������Ԥ�� - ���ķ���';
				$description_str = ' %s����,ȥ%s���μ۸�,����,�������г���·��Ϣ,���ķ���Ϊ���ṩ%s�����г�����������Ԥ����רҵ����';
				$keywords_str = '%s����,ȥ%s����';
			break;
		}
		$categories_name = tep_get_categories_name($categories_id);
		$categories_name = preg_replace('/ .+/','',$categories_name);
		$categories_name = str_replace('����','',$categories_name);
		$Array = array();
		$Array['meta_title'] = str_replace('%s',$categories_name, $title_str);
		$Array['meta_keywords'] = str_replace('%s',$categories_name, $keywords_str);
		$Array['meta_description'] = str_replace('%s',$categories_name, $description_str);
		return $Array;
	}
	return false;
}
?>

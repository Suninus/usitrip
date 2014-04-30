<?php
// /catalog/includes/header_tags.php
// WebMakers.com Added: Header Tags Generator v2.3
// Add META TAGS and Modify TITLE
//
// NOTE: Globally replace all fields in products table with current product name
// just to get things started:
// In phpMyAdmin use: UPDATE products_description set PRODUCTS_HEAD_TITLE_TAG =
// PRODUCTS_NAME
//

require(DIR_FS_LANGUAGES . $language . '/' . 'header_tags.php');

echo '<!-- BOF: Generated Meta Tags -->' . "\n";

// $the_desc='';
// $the_key_words='';
// $the_title='';

/**
 * ��Ҫ���޸Ĳ�Ʒ�б�ҳ��KDT
 * ����н���ɸѡ �����ǲ�Ʒ�б�ҳ �������Ҫ����д���ֻ��Բ�Ʒ�б�ҳ
 * @author lwkai add 2013-04-07
 */
if ($_SERVER['PHP_SELF'] == 'index.php' && (isset($_GET['fc']) || isset($_GET['tc']) || isset($_GET['vc']))) {
	// ��������
	$formCity = (isset($_GET['fc']) ? tep_get_city_name(intval($_GET['fc']),true) : '');
	// ��������
	$toCity = (isset($_GET['tc']) ? tep_get_city_name(intval($_GET['tc'])) : '');
	// ;������
	$viaCity = (isset($_GET['vc']) ? tep_get_city_name(intval($_GET['vc'])) : '');
	// �г�����
	$dayNum = (isset($_GET['d']) ? intval($_GET['d']) : '');
	// Ԥ��
	$Budget = (isset($_GET['m']) ? intval($_GET['m']) : '');
	// �Żݻ
	$Offer = (isset($_GET['of']) ? intval($_GET['of']) : '');
	// �������
	$orderby = (isset($_GET['st']) ? $_GET['st'] : '');
	// ҳ��
	$page_pp = (isset($_GET['pp']) ? intval($_GET['pp']) : 1);
	$title_str = '';
	$the_key_words = '';
	$desc_str = 'Usitrip���ķ���������Ϊ��֪������������,Ϊȫ����������';
	if ($formCity != '') {
		$title_str .= $formCity . '����';
		$the_key_words .= $formCity;
		$desc_str .= $formCity . '����';
	}
	$the_key_words .= '������·,';
	if ($viaCity != '') {
		$title_str .= ';��' . $viaCity;
		$the_key_words .= $viaCity . ',';
		$desc_str .= ';��' . $viaCity;
	}
	if ($toCity != '') {
		$title_str .= '��' . $toCity;
		$the_key_words .= $toCity;
		$desc_str .= '��' . $toCity;
	}
	if ($dayNum != '' && $_SEARCH_DATA['Days'][$dayNum]['name'] != '') {
		$title_str .= html_to_db(str_replace('��','��',$_SEARCH_DATA['Days'][$dayNum]['name']));
		$desc_str .= html_to_db(str_replace('��','��',$_SEARCH_DATA['Days'][$dayNum]['name']));
	}
	$title_str .= '������·���Ŷ���Ǯ';
	if ($Budget != '' && $_SEARCH_DATA['Price'][$Budget]['name']) {
		$title_str .= '_Ԥ����' . html_to_db($_SEARCH_DATA['Price'][$Budget]['name']);
	}
	if ($Offer != '' && $_SEARCH_DATA['Offer'][$Offer]['name'] != '') {
		$title_str .= html_to_db($_SEARCH_DATA['Offer'][$Offer]['name']);
	}
	$title_str .= '�����г�';
	if ($orderby != '') {
		switch($orderby){
			case 'p_d'://�۸���
				$title_str .= "���۸�������";
				break;
			case 'p_a'://�۸�����
				$title_str .= "���۸���������";
				break;
			case 'o_d'://��������
				$title_str .= "��������������";
				break;
			case 'o_a'://��������
				$title_str .= "��������������";
				break;
			case 'd_d'://����ʱ�併��
				$title_str .= "����ʱ�併������";
				break;
			case 'd_a'://����ʱ������
				$title_str .= "������ʱ����������";
				break;
			default:
				$title_str .= "��Ĭ������";
		}
	}
	$title_str .= '��' . $page_pp .'ҳ_usitrip���ķ�' . tep_get_categories_name($_GET['seo_categories_id']) . '���ػ���������';
	$the_title = db_to_html($title_str);
	$the_key_words = db_to_html($the_key_words. '����');
	$the_desc = db_to_html($desc_str . '�г̰���,' . tep_get_categories_name($_GET['seo_categories_id']) . '������·,�����Ž��ͬ��,���������ż۸񱨼�,���ξƵ��Ʊ�ȷ�����Ϣ.');
	//exit;
}

// ���KDT��һ��û�����ã�������
if (! isset($the_title) || ! isset($the_key_words) || ! isset($the_desc)) {
	// Define specific settings per page:

	switch (true) {
		// �������ҳ��SEO
		case ($content == 'advanced_search_result') :
			$the_desc = HEAD_DESC_TAG_ALL;
			$the_key_words = HEAD_KEY_TAG_ALL;
			$the_title = HEAD_TITLE_TAG_ALL;
			if (isset($_GET['keywords']) || isset($_GET['departure_city_id'])) {
				if (isset($_GET['departure_city_id'])) {
					$departure_city_id = $_GET['departure_city_id'];
					$departcity = 'select * from ' . TABLE_TOUR_CITY . ' where city_id ="' . $departure_city_id . '" ';
					$departcityresult = tep_db_query($departcity);
					$departcityrow = tep_db_fetch_array($departcityresult);
					$the_title .= db_to_html($departcityrow['city']) . " ";
				}
				if (isset($_GET['keywords'])) {
					$the_title .= " " . $_GET['keywords'];
				}
				$the_title .= " -usitrip";
			} else {
				$the_title = HEAD_TITLE_TAG_ALL;
			}
			
			break;
		// INDEX.PHP
		case (strstr($_SERVER['PHP_SELF'], FILENAME_DEFAULT) || strstr($PHP_SELF, FILENAME_DEFAULT)) :

			// parse cpatch to get category
			$the_category_query = tep_db_query("select cd.categories_name, cd.categories_head_desc_tag ,cd.categories_head_title_tag, cd.categories_head_keywords_tag from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $current_category_id . "' and cd.categories_id = '" . $current_category_id . "' and cd.language_id = '" . $languages_id . "'");
			$the_category = tep_db_fetch_array($the_category_query);
			
			if (empty($the_category['categories_head_desc_tag'])) {
				$the_desc = HEAD_DESC_TAG_DEFAULT;
			} else {
				if (HTDA_DEFAULT_ON == '1' && $the_category['categories_head_desc_tag'] != '') {
					$the_desc = db_to_html($the_category['categories_head_desc_tag']);
				} else {
					$the_desc = db_to_html($the_category['categories_head_desc_tag']) . '  ' . HEAD_DESC_TAG_DEFAULT;
				}
			}
			
			if (HTKA_DEFAULT_ON == '1' && $the_category['categories_head_keywords_tag'] != '') {
				$the_key_words = db_to_html(clean_html_comments($the_category['categories_head_keywords_tag']));
			} else {
				$the_key_words = db_to_html(clean_html_comments($the_category['categories_head_keywords_tag'])) . ' ' . HEAD_KEY_TAG_DEFAULT;
			}
			
			if (HTTA_DEFAULT_ON == '1') {
				$the_title = db_to_html($the_category['categories_head_title_tag']);
				
				if ($the_category['categories_head_title_tag'] == '') {
					$the_title = HEAD_TITLE_TAG_DEFAULT;
				}
			} else {
				$the_title = db_to_html($the_category['categories_head_title_tag']) . ' ' . HEAD_TITLE_TAG_ALL;
			}
			// �Զ��Ӵ�ȡ�뱾ҳ����ƥ��Ĺؼ��� start{
			/*
			 * $pat_content = strip_tags($the_category['categories_name']);
			 * $add_key = tep_add_meta_keywords_from_thesaurus($pat_content, 1);
			 * if(is_array($add_key) && count($add_key)>0){ $the_key_words .=
			 * ','.db_to_html(implode(',',$add_key)); }
			 */
			// �Զ��Ӵ�ȡ�뱾ҳ����ƥ��Ĺؼ��� end}
			break;
		
		// PRODUCT_INFO.PHP
		case (strstr($_SERVER['PHP_SELF'], 'product_info.php') || strstr($PHP_SELF, 'product_info.php')) :
			$the_product_info_query = tep_db_query("select pd.language_id, p.products_id, pd.products_name, pd.products_description, pd.products_small_description, pd.products_head_title_tag, pd.products_head_keywords_tag, pd.products_head_desc_tag, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . ( int ) $_GET['products_id'] . "' and pd.products_id = '" . ( int ) $_GET['products_id'] . "'" . " and pd.language_id ='" . ( int ) $languages_id . "'");
			$the_product_info = tep_db_fetch_array($the_product_info_query);
			
			if (empty($the_product_info['products_head_desc_tag'])) {
				$the_desc = HEAD_DESC_TAG_ALL;
			} else {
				if (HTDA_PRODUCT_INFO_ON == '1') {
					// $the_desc= $the_product_info['products_head_desc_tag'] .
					// ' ' . HEAD_DESC_TAG_ALL;
					$the_desc = db_to_html($the_product_info['products_head_desc_tag']);
				} else {
					$the_desc = db_to_html($the_product_info['products_head_desc_tag']);
				}
			}
			
			if (empty($the_product_info['products_head_keywords_tag'])) {
				$the_key_words = HEAD_KEY_TAG_ALL;
			} else {
				if (HTKA_PRODUCT_INFO_ON == '1') {
					// $the_key_words=
					// $the_product_info['products_head_keywords_tag'] . ' ' .
					// HEAD_KEY_TAG_ALL;
					$the_key_words = db_to_html($the_product_info['products_head_keywords_tag']);
				} else {
					$the_key_words = db_to_html($the_product_info['products_head_keywords_tag']);
				}
			}
			
			if (empty($the_product_info['products_head_title_tag'])) {
				$the_title = HEAD_TITLE_TAG_ALL;
			} else {
				if (HTTA_PRODUCT_INFO_ON == '1') {
					// $the_title= HEAD_TITLE_TAG_ALL . ' ' .
					// clean_html_comments($the_product_info['products_head_title_tag']);
					$the_title = db_to_html(clean_html_comments($the_product_info['products_head_title_tag']));
				} else {
					$the_title = db_to_html(clean_html_comments($the_product_info['products_head_title_tag']));
				}
			}
			// �Զ�ƥ��ؼ���
			/*
			 * $pat_content =
			 * strip_tags($the_product_info['products_description'].$the_product_info['products_small_description']);
			 * $add_key = tep_add_meta_keywords_from_thesaurus($pat_content, 2);
			 * if(is_array($add_key) && count($add_key)>0){ $the_key_words .=
			 * ','.db_to_html(implode(',',$add_key)); }
			 */
			switch ($mnu) {
				case "prices" :
					$the_title = db_to_html('�۸�,����,') . $the_title;
					$the_key_words = $the_key_words . db_to_html(',�۸�,����');
					$the_desc = $the_desc . db_to_html(',�۸���ϸ����');
					break;
				case "notes" :
					$the_title = db_to_html('ע������,') . $the_title;
					$the_key_words = $the_key_words . db_to_html(',ע������');
					$the_desc = $the_desc . db_to_html(',ע������');
					break;
				case "frequentlyqa" :
					$the_title = db_to_html('��������,') . $the_title;
					$the_key_words = $the_key_words . db_to_html(',��������');
					$the_desc = $the_desc . db_to_html(',��������');
					break;
				case "reviews" :
					$the_title = db_to_html('�ο�����,') . $the_title;
					$the_key_words = $the_key_words . db_to_html(',�ο�����');
					$the_desc = $the_desc . db_to_html(',�ο�����');
					break;
				case "traveler-photos" :
					$the_title = db_to_html('��Ƭ����,') . $the_title;
					$the_key_words = $the_key_words . db_to_html(',��Ƭ����');
					$the_desc = $the_desc . db_to_html(',��Ƭ����');
					break;
				case "question-&-answer" :
					$the_title = db_to_html('������ѯ,') . $the_title;
					$the_key_words = $the_key_words . db_to_html(',������ѯ');
					$the_desc = $the_desc . db_to_html(',������ѯ');
					break;
			}
			//by lwkai add 2013-04-07 13.38 ����Ʒ��ϸҳ��TITLE�Ӹ�β��
			$the_title .= db_to_html('_usitrip���ķ��������ػ���������');
			break;
		
		// �²�Ʒҳ�� PRODUCTS_NEW.PHP
		case (strstr($_SERVER['PHP_SELF'], 'products_new.php') || strstr($PHP_SELF, 'products_new.php')) :
			if (HEAD_DESC_TAG_WHATS_NEW != '') {
				if (HTDA_WHATS_NEW_ON == '1') {
					$the_desc = HEAD_DESC_TAG_WHATS_NEW . ' ' . HEAD_DESC_TAG_ALL;
				} else {
					$the_desc = HEAD_DESC_TAG_WHATS_NEW;
				}
			} else {
				$the_desc = HEAD_DESC_TAG_ALL;
			}
			
			if (HEAD_KEY_TAG_WHATS_NEW != '') {
				if (HTKA_WHATS_NEW_ON == '1') {
					$the_key_words = HEAD_KEY_TAG_WHATS_NEW . ' ' . HEAD_KEY_TAG_ALL;
				} else {
					$the_key_words = HEAD_KEY_TAG_WHATS_NEW;
				}
			} else {
				$the_key_words = HEAD_KEY_TAG_ALL;
			}
			
			if (HEAD_TITLE_TAG_WHATS_NEW != '') {
				if (HTTA_WHATS_NEW_ON == '1') {
					$the_title = HEAD_TITLE_TAG_ALL . ' ' . HEAD_TITLE_TAG_WHATS_NEW;
				} else {
					$the_title = HEAD_TITLE_TAG_WHATS_NEW;
				}
			} else {
				$the_title = HEAD_TITLE_TAG_ALL;
			}
			break;
		
		// �ؼ�ҳ��
		case (strstr($_SERVER['PHP_SELF'], 'specials.php') || strstr($PHP_SELF, 'specials.php')) :
			if (HEAD_DESC_TAG_SPECIALS != '') {
				if (HTDA_SPECIALS_ON == '1') {
					$the_desc = HEAD_DESC_TAG_SPECIALS . ' ' . HEAD_DESC_TAG_ALL;
				} else {
					$the_desc = HEAD_DESC_TAG_SPECIALS;
				}
			} else {
				$the_desc = HEAD_DESC_TAG_ALL;
			}
			
			if (HEAD_KEY_TAG_SPECIALS == '') {
				// Build a list of ALL specials product names to put in keywords
				$new = tep_db_query("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . ( int ) $languages_id . "' and s.status = '1' order by s.specials_date_added DESC ");
				$row = 0;
				$the_specials = '';
				while ( $new_values = tep_db_fetch_array($new) ) {
					$the_specials .= db_to_html(clean_html_comments($new_values['products_name'])) . ', ';
				}
				if (HTKA_SPECIALS_ON == '1') {
					$the_key_words = $the_specials . ' ' . HEAD_KEY_TAG_ALL;
				} else {
					$the_key_words = $the_specials;
				}
			} else {
				$the_key_words = HEAD_KEY_TAG_SPECIALS . ' ' . HEAD_KEY_TAG_ALL;
			}
			
			if (HEAD_TITLE_TAG_SPECIALS != '') {
				if (HTTA_SPECIALS_ON == '1') {
					$the_title = HEAD_TITLE_TAG_SPECIALS . ' - ' . HEAD_TITLE_TAG_ALL;
				} else {
					$the_title = HEAD_TITLE_TAG_SPECIALS;
				}
			} else {
				$the_title = HEAD_TITLE_TAG_ALL;
			}
			
			break;
		
		// PRODUCTS_REVIEWS_INFO.PHP and PRODUCTS_REVIEWS.PHP
		case (strstr($_SERVER['PHP_SELF'], 'product_reviews_info.php') || strstr($_SERVER['PHP_SELF'], 'product_reviews.php') || strstr($PHP_SELF, 'product_reviews_info.php') || strstr($PHP_SELF, 'product_reviews.php')) :
			if (HEAD_DESC_TAG_PRODUCT_REVIEWS_INFO == '') {
				if (HTDA_PRODUCT_REVIEWS_INFO_ON == '1') {
					$the_desc = db_to_html(tep_get_header_tag_products_desc(isset($_GET['reviews_id']))) . ' ' . HEAD_DESC_TAG_ALL;
				} else {
					$the_desc = db_to_html(tep_get_header_tag_products_desc(isset($_GET['reviews_id'])));
				}
			} else {
				$the_desc = HEAD_DESC_TAG_PRODUCT_REVIEWS_INFO;
			}
			
			if (HEAD_KEY_TAG_PRODUCT_REVIEWS_INFO == '') {
				if (HTKA_PRODUCT_REVIEWS_INFO_ON == '1') {
					$the_key_words = db_to_html(tep_get_header_tag_products_keywords(isset($_GET['reviews_id']))) . ' ' . HEAD_KEY_TAG_ALL;
				} else {
					$the_key_words = db_to_html(tep_get_header_tag_products_keywords(isset($_GET['reviews_id'])));
				}
			} else {
				$the_key_words = HEAD_KEY_TAG_PRODUCT_REVIEWS_INFO;
			}
			
			if (HEAD_TITLE_TAG_PRODUCT_REVIEWS_INFO == '') {
				if (HTTA_PRODUCT_REVIEWS_INFO_ON == '1') {
					$the_title = db_to_html(tep_get_header_tag_products_title(isset($_GET['reviews_id']))) . ' - ' . HEAD_TITLE_TAG_ALL;
				} else {
					$the_title = db_to_html(tep_get_header_tag_products_title(isset($_GET['reviews_id'])));
				}
			} else {
				$the_title = HEAD_TITLE_TAG_PRODUCT_REVIEWS_INFO;
			}
			
			break;
		// ������ϸҳ
		case (strstr($_SERVER['PHP_SELF'], 'question_detail.php')) :
			$str_sql = '
		SELECT
		q.*,
		p.products_id,
		pd.products_name,
		p.products_image,
		p.departure_city_id
		FROM `tour_question` q ,
		`products` p,
		`products_description` pd
		WHERE q.que_id=' . ( int ) $_GET['question_id'] . '
		and p.products_id = pd.products_id
		and q.products_id=p.products_id';
			$question_query = tep_db_query($str_sql);
			$question = tep_db_fetch_array($question_query);
			$the_title=cutword(db_to_html($question['question']), 80);
			$the_key_words=db_to_html($question['products_name']);
			$the_desc=db_to_html($question['question']);
			break;
		// ALL OTHER PAGES NOT DEFINED ABOVE
		default :

			// $the_desc= HEAD_DESC_TAG_ALL;
			// $the_key_words= HEAD_KEY_TAG_ALL;
			// $the_title= HEAD_TITLE_TAG_ALL;
			break;
	}
}

// set index page seo
if ($content == CONTENT_INDEX_DEFAULT) {
	/*
	 * $the_title =
	 * db_to_html('usitrip���ķ�-������ѡ����������_רҵ��������������_���ι��Ծ�����·_ǩ֤������ѧ��ѧ'); $the_desc
	 * =
	 * db_to_html('Usitrip���ķ���������Ϊȫ������ѡ����������վ,�������������������,��רҵ��������������,������·��ȫ,�۸����,Ϊȫ����������ȥ��������,���ô�����,ŷ�����εȳ���������·�Ź�,���ξ���,���ι���,���������ż۸񱨼�,ǩ֤����,��ѧ��ѧ,�ṩ��������ǩ֤,�Ƶ�Ԥ��,���ۻ�Ʊ,���ͬ��,ס�޹��Ե����η���');
	 * $the_key_words =
	 * db_to_html('usitrip���ķ�������,��������������,ȥ��������,���ι���,������·,���ξ���,���������ż۸񱨼�,ǩ֤����,��ѧ��ѧ');
	 */
	$the_title = db_to_html('��������������_����������_����������·_Usitrip���ķ������� ');
	$the_desc = db_to_html('���ķ�-�������˵���������;�ṩ��ʯ��԰����,ŦԼ����,���������εȡ�Ʒ����·,�ͼ۱���,��Ѻ��,�ͱ���,98%ǩ֤��,3000����·,7*24Сʱ�ͷ�,��Ӣ˫���˵��');
	$the_key_words = db_to_html('��������,��������ǩ֤,�������ػ���������,��ɼ����������,���������Ż�ȯ');
}

// ���е�������δ��ע��ҳ�棬����ͳһ����ͬһ��TKD���������ڵ�д��
if (! tep_not_null($the_desc)) {
	$the_desc = HEAD_DESC_TAG_ALL;
}
if (! tep_not_null($the_key_words)) {
	$the_key_words = HEAD_KEY_TAG_ALL;
}
if (! tep_not_null($the_title)) {
	$the_title = HEAD_TITLE_TAG_ALL;
}

// ����SEO��Ա�ṩ��seo��Ϣ��ȷ�����յ�$the_desc,$the_key_words,$the_title start {
function _update_seo_info(&$the_title, &$the_key_words, &$the_desc, $content) {
	$sql = tep_db_query('SELECT s_meta_title, s_meta_keywords, s_meta_description FROM `seo_for_page` WHERE s_tpl_name="' . tep_db_input(tep_db_prepare_input($content)) . '" LIMIT 1 ');
	$row = tep_db_fetch_array($sql);
	if (tep_not_null($row['s_meta_title'])) {
		$the_title = db_to_html(strip_tags($row['s_meta_title']));
	}
	if (tep_not_null($row['s_meta_keywords'])) {
		$the_key_words = db_to_html(strip_tags($row['s_meta_keywords']));
	}
	if (tep_not_null($row['s_meta_description'])) {
		$the_desc = db_to_html(strip_tags($row['s_meta_description']));
	}
}

if ($content != CONTENT_ADVANCED_SEARCH_RESULT) {
	
	_update_seo_info($the_title, $the_key_words, $the_desc, $content);
	// ����SEO��Ա�ṩ��seo��Ϣ��ȷ�����յ�$the_desc,$the_key_words,$the_title end }
	
	// ����ؼ��ʣ���֤���ظ�
	$the_key_words = db_to_html(str_replace('��', ',', html_to_db($the_key_words)));
	$the_key_words = preg_replace('/ *, */', ',', $the_key_words);
	$sort_key_words = explode(',', $the_key_words);
	$sort_key_words = array_unique($sort_key_words);
	// ֻ��5���ؼ���
	$max_key_num = 5;
	if (count($sort_key_words) > $max_key_num) {
		$tmp_array = array();
		for($i = 0; $i < $max_key_num; $i ++) {
			$tmp_array[$i] = $sort_key_words[$i];
		}
		$sort_key_words = $tmp_array;
		unset($tmp_array);
	}
	
	$the_key_words = implode(',', $sort_key_words);
}

echo ' <title>' . tep_db_output($the_title) . '</title>' . "\n";
echo ' <meta http-equiv="Content-Type" content="text/html; charset=' . CHARSET . '" />' . "\n";
echo ' <meta name="Description" content="' . tep_db_output($the_desc) . '" />' . "\n";
echo ' <meta name="Keywords" content="' . tep_db_output($the_key_words) . '" />' . "\n";
echo ' <meta name="Reply-to" content="' . HEAD_REPLY_TAG_ALL . '" />' . "\n";
/* ��ֹ����������¼ https����ҳ -Howard */
if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
	echo '<meta name="robots" content="noindex,follow" />' . "\n";
} else {
	echo '<meta name="robots" content="index, follow" />' . "\n";
}

// echo ' <META NAME="revisit-after" CONTENT="30 days">' . "\n";
// echo ' <META NAME="generator" CONTENT="CRELoaded osCommerce Version 6.15">' .
// "\n";

echo '<!-- EOF: Generated Meta Tags -->' . "\n";

if ($current_category_id) {
	// $first_sentence_query = tep_db_query("select * from
	// ".TABLE_CATEGORIES_DESCRIPTION." where categories_id = '".
	// $current_category_id ."'");
	$first_sentence_query = tep_db_query("select * from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . $current_category_id . "' and language_id= '" . ( int ) $languages_id . "'");
	$first_sentence = tep_db_fetch_array($first_sentence_query);
	$first_sentence = db_to_html($first_sentence["categories_first_sentence"]);
}
if ($first_sentence == '') {
	$first_sentence = db_to_html('���Ի�ʯ,��ʤ����,��Ͽ��,��ͳɽ����౱��ʤ��,��usitrip���������ʵķ����������ļ۸�');
}

?>

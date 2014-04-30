<?php
/*
$Id: affiliate_banners.php,v 1.1.1.1 2004/03/04 23:37:54 ccwjr Exp $

OSC-Affiliate

Contribution based on:

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 - 2003 osCommerce

Released under the GNU General Public License
*/
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );

require('includes/application_top.php');

// ��վ���˿���
if (strtolower(AFFILIATE_SWITCH) === 'false') {
	echo '<div align="center">�˹����ݲ����ţ���<a href="' . tep_href_link('index.php') . '">��ҳ</a></div>';
	exit();
}

if (!tep_session_is_registered('affiliate_id')) {
	$navigation->set_snapshot();
	if(tep_not_null($_COOKIE['LoginDate'])){
		$messageStack->add_session('login', LOGIN_OVERTIME);
		setcookie('LoginDate', '');
	}
	tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
}
checkAffiliateVerified();

require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_BANNERS);

$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_AFFILIATE_BANNERS));


$bLinkImage = $bLinkText = $bLinkImageText = "";
$bLinkImage = $bLink1Image = $bLink2Image = "";
//���ɸ��ַ�ʽ�����˴��� start {
if(tep_not_null($_GET['action']) && $_POST['ajax']=="true"){
	require(DIR_FS_INCLUDES . 'ajax_encoding_control.php');
	$js_str = '';
	switch ($_GET['action']){
		case "Products":	//ȡ��Ʒ��·����
		if(tep_not_null($_POST['products_model'])){
			$rProductsId = tep_db_get_field_value('products_id','products',' products_model="'.trim($_POST['products_model']).'" ');
		}else {
			$rProductsId = ((int)$_POST['rProductsId']) ? (int)$_POST['rProductsId'] : (int)$_GET['rProductsId'];
		}
		if((int)$rProductsId){
			$affiliate_pbanners_values = tep_db_query("select p.products_image, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . $rProductsId . "' and pd.products_id = '" . $rProductsId . "' and p.products_status = '1' and pd.language_id = '" . $languages_id . "'");

			while ($affiliate_pbanners = tep_db_fetch_array($affiliate_pbanners_values)) {
				$product_image = $affiliate_pbanners['products_image'];
				$product_image = (stripos($product_image,'http://') === false ? DIR_WS_IMAGES:'') . $product_image;
				$product_image = str_replace('/picture/detail_','/picture/thumb_',$product_image);

				$products_name = ($affiliate_pbanners['products_name']);

				//ͼƬ���
				$bLinkImage = '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO , 'ref=' . $affiliate_id . '&utm_source=' . $affiliate_id . '&utm_medium=af&utm_term=detaillink&' . '&products_id=' . $rProductsId . '&affiliate_banner_id=1').'" target="_blank"><img src="' . $product_image . '" border="0" alt="' . tep_db_output($affiliate_pbanners['products_name']) . '"></a>';
				$js_str .= 'jQuery("#codeProductsImages").val("'.tep_db_input(tep_db_prepare_input($bLinkImage)).'");';

				//���ֹ��
				$affiliate_pbanners['affiliate_banners_image'] = (stripos($product_image,'http://') === false ? DIR_WS_IMAGES:'') . $affiliate_pbanners['affiliate_banners_image'];
				$bLinkText = '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO , 'ref=' . $affiliate_id .'&utm_source=' . $affiliate_id . '&utm_medium=af&utm_term=detaillink&' . '&products_id=' . $rProductsId . '&affiliate_banner_id=1').'" target="_blank">' . tep_db_output($affiliate_pbanners['products_name']) . '</a>';
				$js_str.= 'jQuery("#codeProductsText").val("'.tep_db_input(tep_db_prepare_input($bLinkText)).'");';
				//ͼ�Ĺ��
				$iframe_src = tep_href_link('affiliate_banners_public.php','_ref='.$affiliate_id.'&_utm_source=' . $affiliate_id .'&_utm_medium=af&_utm_term=detaillink'. '&_products_id=' . $rProductsId . '&_affiliate_banner_id=1');
				$iframe_src .= '&iframe_action=products';
				$bLinkImageText = '<iframe scrolling="no" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="150" src="'.$iframe_src.'"></iframe>';
				$js_str.= 'jQuery("#codeProductsImagesText").val("'.tep_db_input(tep_db_prepare_input($bLinkImageText)).'");';
				//Ԥ������
				_switch_links_type($js_str);
			}
		}else {
			$js_str.= 'alert("��Ʒ�����ڣ�");';
		}

		$js_str .= 'jQuery("#createCodeButtonP").attr("disabled",false);';
		$js_str .= 'jQuery("#createCodeButtonP").html("���ɴ���");';
		break;

		case "Cat":	//ȡ����Ŀ¼����
		$rCatId = ((int)$_POST['rCatId']) ? (int)$_POST['rCatId'] : (int)$_GET['rCatId'];
		$aSql = tep_db_query("select pd.categories_name, p.categories_image from " . TABLE_CATEGORIES_DESCRIPTION . " as pd ," . TABLE_CATEGORIES . " as p where pd.categories_id = p.categories_id and pd.categories_id = '" .$rCatId . "' and pd.language_id = '" . $languages_id . "' Limit 1");
		while($aRows = tep_db_fetch_array($aSql)){
			$categories_name = preg_replace('/ .+$/','',trim($aRows['categories_name']));
			$categories_image = '';
			$_tmp_src = 'image/affiliate/banners/'.strtolower(CHARSET).'/'.strtolower($_POST['tips']).'/'.$rCatId.'/'.$_POST['image_size'].'.jpg';
			if(file_exists(DIR_FS_CATALOG.$_tmp_src)){
				//����ʹ���Ѿ���Ƶ�ͼƬ
				$categories_image = HTTP_SERVER.'/'.$_tmp_src;
			}else{
				if(!tep_not_null($aRows['categories_image'])){
					$categories_image = HTTP_SERVER . DIR_WS_HTTP_CATALOG.'image/q_a_touxiang.jpg';
				}else{
					$categories_image = (stripos($aRows['categories_image'],'http://') === false ? DIR_WS_IMAGES:'') . $aRows['categories_image'];
					$categories_image = str_replace('/picture/detail_','/picture/thumb_',$categories_image);
				}
			}
			//ͼƬ���
			$code_images = '<a href="' . tep_href_link(FILENAME_DEFAULT , 'cPath='.$rCatId.'&ref='.$affiliate_id.'&utm_source=' . $affiliate_id .'&utm_medium=af&utm_term=catgorylink') .'" target="_blank"><img src="' . $categories_image . '" border="0" alt="' . tep_db_output($categories_name) . '"></a>';
			$js_str.= 'jQuery("#codeProductsImages").val("'.tep_db_input(tep_db_prepare_input($code_images)).'");';
			//���ֹ��
			$code_text = '<a href="' . tep_href_link(FILENAME_DEFAULT , 'cPath='.$rCatId.'&ref='.$affiliate_id.'&utm_source=' . $affiliate_id .'&utm_medium=af&utm_term=catgorylink') .'" target="_blank">'.tep_db_output($categories_name).'</a>';
			$js_str.= 'jQuery("#codeProductsText").val("'.tep_db_input(tep_db_prepare_input($code_text)).'");';
			//ͼ�Ĺ��
			$code_image_text = '<div>'.$code_images.'<br>'.$code_text.'</div>';
			$js_str.= 'jQuery("#codeProductsImagesText").val("'.tep_db_input(tep_db_prepare_input($code_image_text)).'");';
			//Ԥ������
			_switch_links_type($js_str);
		}
		$js_str .= 'jQuery("#createCodeButtonC").html("���ɴ���");';
		$js_str .= 'jQuery("#createCodeButtonC").attr("disabled",false);';
		break;

		case 'Custom':	//ȡ�Զ������Ӵ���
		$textLink = $_POST['custom_links_url'].(strpos($_POST['custom_links_url'],'?')!==false ? '&' : '?').('ref='.$affiliate_id.'&utm_source=' . $affiliate_id .'&utm_medium=af&utm_term=customlink');
		$code_custom_html = '<a href="' . $textLink .'" target="_blank">'.html_to_db(ajax_to_general_string($_POST['custom_links_text'])).'</a>';
		$code_custom_url = $textLink;
		$js_str .= 'jQuery("#codeCustomHtml").val("'.tep_db_input(tep_db_prepare_input($code_custom_html)).'");';
		$js_str .= 'jQuery("#codeCustomUrl").val("'.tep_db_input(tep_db_prepare_input($code_custom_url)).'");';
		$js_str .= 'jQuery("#createCodeButtonD").html("���ɴ���");';
		$js_str .= 'jQuery("#createCodeButtonD").attr("disabled",false);';
		break;

		case 'Search':	//������Ƕ�����
		$iframe_src = tep_href_link('affiliate_banners_public.php','_ref='.$affiliate_id.'&_utm_source=' . $affiliate_id .'&_utm_medium=af&_utm_term=searchlink');
		$iframe_height = '271';
		if($_POST['searchType']=='all' || $_POST['searchType']=='side'){
			$iframe_src .= '&_searchType='.$_POST['searchType'];
			if($_POST['searchType']=='all'){
				if($_POST['search_logo']==='1'){
					$iframe_src .= '&_search_logo='.$_POST['search_logo'];
				}
				if($_POST['search_keywords']==='1'){
					$iframe_src .= '&_search_keywords='.$_POST['search_keywords'];
				}
				$iframe_src .= '&iframe_action=searchT';
				$iframe_height = '100';
			}else {
				$iframe_src .= '&iframe_action=searchB';
			}
		}

		$searchLinkHtml = '<iframe id="searchBI" scrolling="no" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="271"'.$iframe_height.'" src="'.$iframe_src.'"></iframe>';
		$js_str .= 'jQuery("#codeSearchHtml").val("'.tep_db_input(tep_db_prepare_input($searchLinkHtml)).'");';
		$js_str .= 'jQuery("#createCodeButtonE").html("���ɴ���");';
		$js_str .= 'jQuery("#createCodeButtonE").attr("disabled",false);';
		$js_str .= '_preview(\'codeSearchHtml\');';	//Ԥ��
		break;

		case 'Index':	//��ҳ���Ӵ���
		$link_adderss = HTTP_SERVER.'/?ref='.$affiliate_id.'&utm_source=' . $affiliate_id .'&utm_medium=af&utm_term=indexlink';
		$image_src = HTTP_SERVER.'/image/affiliate/banners/'.strtolower(CHARSET).'/'.strtolower($_POST['tips']).'/'.$_POST['image_size'].'.jpg';
		//ͼƬ���
		$code_images = '<a href="' . $link_adderss .'" target="_blank"><img src="' . $image_src . '" border="0" alt="���ķ�"></a>';
		$js_str.= 'jQuery("#codeProductsImages").val("'.tep_db_input(tep_db_prepare_input($code_images)).'");';
		//���ֹ��
		$code_text = '<a href="' . $link_adderss .'" target="_blank">���ķ�������</a>';;
		$js_str.= 'jQuery("#codeProductsText").val("'.tep_db_input(tep_db_prepare_input($code_text)).'");';
		//ͼ�Ĺ��
		$code_image_text = '<div>'.$code_images.'<br>'.$code_text.'</div>';
		$js_str.= 'jQuery("#codeProductsImagesText").val("'.tep_db_input(tep_db_prepare_input($code_image_text)).'");';
		//Ԥ������
		_switch_links_type($js_str);
		$js_str .= 'jQuery("#createCodeButtonF").html("������ҳ����");';
		$js_str .= 'jQuery("#createCodeButtonF").attr("disabled",false);';
		break;

		case 'Theme':	//�������Ӵ���
		$link_adderss = tep_href_link('affiliate_banners_public.php','ref='.$affiliate_id.'&utm_source=' . $affiliate_id .'&utm_medium=af&utm_term=themelink'.'&theme_name='.$_POST['theme_name']);
		$image_src = HTTP_SERVER.'/image/affiliate/banners/'.strtolower(CHARSET).'/'.strtolower($_POST['tips']).'/'.strtolower($_POST['theme_name']).'/'.$_POST['image_size'].'.jpg';
		$title_text = '���ķ�������';
		switch ($_POST['theme_name']){
			case 'googleapple': $title_text = '��ȿƼ�֮����ƻ���ȸ�'; break;
			case 'familyfun': $title_text = '������-һ����У���'; break;
			case 'shopping': $title_text = 'ȥ���������'; break;
			case '2012yellow_stone': $title_text = '��ʯ��԰�����д���'; break;
			case 'yhuts': $title_text = '������ס����ʯ��԰Сľ��'; break;
		}
		//ͼƬ���
		$code_images = '<a href="' . $link_adderss .'" target="_blank"><img src="' . $image_src . '" border="0" alt="'.$title_text.'"></a>';
		$js_str.= 'jQuery("#codeProductsImages").val("'.tep_db_input(tep_db_prepare_input($code_images)).'");';
		//���ֹ��
		$code_text = '<a href="' . $link_adderss .'" target="_blank">'.$title_text.'</a>';;
		$js_str.= 'jQuery("#codeProductsText").val("'.tep_db_input(tep_db_prepare_input($code_text)).'");';
		//ͼ�Ĺ��
		$code_image_text = '<div>'.$code_images.'<br>'.$code_text.'</div>';
		$js_str.= 'jQuery("#codeProductsImagesText").val("'.tep_db_input(tep_db_prepare_input($code_image_text)).'");';
		//Ԥ������
		_switch_links_type($js_str);
		$js_str .= 'jQuery("#createCodeButtonG").html("���ɴ���");';
		$js_str .= 'jQuery("#createCodeButtonG").attr("disabled",false);';
		break;

	}

	$js_str .= '';
	$js_str = preg_replace('/[[:space:]]+/', ' ',$js_str);
	echo '[JS]'.db_to_html($js_str).'[/JS]';
	exit;
}
//���ɸ��ַ�ʽ�����˴��� end }

/**
 * ������ʾԤ�������򣬴˺���ֻ���ڱ�ҳ�ģ�ͼ�Ĺ��������ҳ���������������·�г̣���������_��ͷ
 *
 * @param unknown_type $js_str
 */
function _switch_links_type(&$js_str){
	switch($_POST['links_type']){
		case 'imageTextAdPr':
			$js_str.= 'jQuery("#get_code_view_panel").html(jQuery("#codeProductsImagesText").val());';
			break;
		case 'imageAdPr':
			$js_str.= 'jQuery("#get_code_view_panel").html(jQuery("#codeProductsImages").val());';
			break;
		case 'textAdPr':
		default: $js_str.= 'jQuery("#get_code_view_panel").html(jQuery("#codeProductsText").val());';
	}
}


/*//�Ƽ���Ʒ
$referProducts = getAffiliateAllProducts(100);
*/
$rProductsId = ((int)$_POST['rProductsId']) ? (int)$_POST['rProductsId'] : (int)$_GET['rProductsId'];
$products_model = tep_get_products_model($rProductsId);

//�Ƽ�Ŀ¼{
$rfCats = array();
$rfCats[] = array('id'=>24,'name'=>'����');
$rfCats[] = array('id'=>25,'name'=>'����');
$rfCats[] = array('id'=>33,'name'=>'������');
$rfCats[] = array('id'=>34,'name'=>'�������');
$rfCats[] = array('id'=>54,'name'=>'���ô�');
$rfCats[] = array('id'=>208,'name'=>'��������');
$rfCats[] = array('id'=>157,'name'=>'ŷ��');
//$rfCats[] = array('id'=>182,'name'=>'�Ƶ�');
$rfCats[] = array('id'=>298,'name'=>'������ѧ');
//$rfCats[] = array('id'=>299,'name'=>'ǩ֤');
for($i=0, $n=sizeof($rfCats); $i < $n; $i++){
	$cSql = tep_db_query('SELECT c.categories_id, cd.categories_name FROM `categories` c, `categories_description` cd
							 WHERE c.categories_id=cd.categories_id and c.categories_status="1" and c.parent_id="'.$rfCats[$i]['id'].'" and cd.language_id="1" ORDER BY sort_order Limit 500');
	while($cRows = tep_db_fetch_array($cSql)){
		$rfCats[$i]['child'][] = array('id'=>$cRows['categories_id'], 'name'=>preg_replace('/ .+$/','',trim($cRows['categories_name'])));
	}
}
//print_r($rfCats);
//�Ƽ�Ŀ¼}

require(DIR_FS_CLASSES . 'affiliate.php');
$affiliate = new affiliate;
//�Զ���ͻ������Ż�ȯ����
$affiliate->createCouponCode($affiliate_id);

//�Զ����Ͽͻ������Ż��룬���ߺ����ܺ���ִ��һ�κ󼴿�ɾ���˴���(�Ѿ����)
//$affiliate->autoCreateCouponCodeForAllOldCustomers();

//�ҵ��Ż�ȯ����
$my_coupon_code = $affiliate->couponCode($affiliate_id);


$content = CONTENT_AFFILIATE_BANNERS;

$is_my_account = true;

require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

require(DIR_FS_INCLUDES . 'application_bottom.php');

?>
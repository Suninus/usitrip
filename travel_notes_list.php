<?php
//��Ƭ���μ��б�
require('includes/application_top.php');

//$customers_id�Ǳ��ĵ�Ψһ���û�id
$customers_id = isset($_GET['customers_id']) ? (int)$_GET['customers_id'] : (int)$customer_id;
if(!(int)$customers_id){
    $navigation->set_snapshot();
	if(tep_not_null($_COOKIE['LoginDate'])){
		$messageStack->add_session('login', LOGIN_OVERTIME);
		setcookie('LoginDate', '');
	}
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
}

$products_id = (int)$_GET['products_id'];
if(!(int)$products_id || !(int)$customers_id){
    tep_redirect(tep_href_link('index.php'));
}


//ȡ���û��ڸò�Ʒ�ڵ��μ��б�
$travel_notes_sql = 'SELECT * FROM `travel_notes` WHERE products_id="'.$products_id.'" AND customers_id="'.$customers_id.'" Order By travel_notes_id DESC ';
$travel_notes_split = new splitPageResults($travel_notes_sql, 10);
$travel_notes_query = tep_db_query($travel_notes_split->sql_query);
$travel_notes_rows = tep_db_fetch_array($travel_notes_query);



//�û�����
$customers_name = tep_customers_name($customers_id);
if($customers_id==$customer_id){ $customers_name = "��"; }

//���������ģ��ҳ�� start
$p_name = db_to_html(tep_get_products_name($products_id));
$p_href = tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_id);
$h3_2 = db_to_html($customers_name.'���μ�');
//���������ģ��ҳ�� end

$breadcrumb_title = $customers_name.'�ĸ�������';
$breadcrumb->add(db_to_html('���ͬ��'), tep_href_link('new_travel_companion_index.php'));
$breadcrumb->add(db_to_html($breadcrumb_title), tep_href_link('individual_space.php','customers_id='.$customers_id));
$breadcrumb->add($h3_2, tep_href_link('travel_notes_list.php','products_id='.$products_id.'&customers_id='.$customers_id));

$other_css_base_name = "new_travel_companion_index";
$javascript = 'new_travel_companion.js.php';
$is_travel_companion_bbs = true;
$content = 'travel_notes_list';	//��Ƭģ��

require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
require(DIR_FS_INCLUDES . 'application_bottom.php');

?>
<?php
require('includes/application_top.php');
require(DIR_FS_LANGUAGES . $language . '/products_departure_hotels.php');
require(DIR_FS_LANGUAGES . $language . '/product_info.php');

//������id��ʾ
$products_id = (int)$_GET['products_id'];
$hotel_ids = get_products_departure_hotel_ids($products_id);//��ؾƵ� ����

//ȡ�ò�Ʒ���Ƶ���Ϣ
$products_sql = tep_db_query('SELECT p.products_id, p.departure_city_id, p.display_room_option, pd.products_name FROM `products` p, `products_description` pd WHERE p.products_id="'.(int)$products_id.'" AND language_id=1 AND pd.products_id=p.products_id ');
$product_info = tep_db_fetch_array($products_sql);

//ȡ�ò�Ʒ���͵���Ϣ
//ȡ�ò�Ʒ����ʱ�������start
$departure_query_address = "select departure_id,departure_time from ".TABLE_PRODUCTS_DEPARTURE." where  products_id = ".(int)$products_id."  order by departure_time desc";
$departure_row_address = tep_db_query($departure_query_address);

$totaldipacount = tep_db_num_rows($departure_row_address);	//���͵�����
if($totaldipacount==0){
	tep_redirect(tep_href_link('product_info.php', 'products_id='.(int)$products_id));
}

while($departure_result_address = tep_db_fetch_array($departure_row_address)){
	$len=strlen($departure_result_address['departure_time']);
	if($len == 6){
		$depart_final = '0'.$departure_result_address['departure_time'];
	}else{
		$depart_final = $departure_result_address['departure_time'];
	}		
	$depart_final = trim($depart_final);			
	if(strstr($depart_final,'pm')){
		$pma [$departure_result_address['departure_id']] = $departure_result_address['departure_time'].'##'.$departure_result_address['departure_id'];
		$pma_time[$departure_result_address['departure_id']] = $departure_result_address['departure_time'];
	}
	if(strstr($depart_final,'am')){
		$ama[$departure_result_address['departure_id']] = $departure_result_address['departure_time'].'##'.$departure_result_address['departure_id'];
		$ama_time[$departure_result_address['departure_id']] = $departure_result_address['departure_time'];
	}
}	
			
//stort array start
if($ama != ''){						
	array_multisort($ama,SORT_ASC,SORT_STRING);
	array_multisort($ama_time,SORT_ASC,SORT_STRING);
	$ama_time = array_unique($ama_time);
}
if($pma != ''){
	array_multisort($pma,SORT_ASC,SORT_STRING);
	array_multisort($pma_time,SORT_ASC,SORT_STRING);
	$pma_time = array_unique($pma_time);
}
//shor array end
if($ama != '' && $pma != ''){
	$final_departure_array_result = array_merge((array)$ama, (array)$pma);	//������������Ľ���ʱ�� ��ַid ����
	$final_departure_time_array_result = array_merge((array)$ama_time,(array)$pma_time);
}else if($ama != '' && $pma == ''){
	$final_departure_array_result = $ama;
	$final_departure_time_array_result = $ama_time;
}else if($ama == '' && $pma != ''){
	$final_departure_array_result = $pma;
	$final_departure_time_array_result = $pma_time;
}
//ȡ�ò�Ʒ����ʱ�������end

//seo��Ϣ
$the_desc = $product_info['products_name'];
$the_key_words = $product_info['products_name'];
$the_title = $product_info['products_name'];

$the_desc = db_to_html($the_desc);
$the_key_words = db_to_html($the_key_words);
$the_title = db_to_html($the_title);
//seo��Ϣ end



//׷�ӵ���
$breadcrumb->add(db_to_html('���͵���Ƶ�'), tep_href_link('products_departure_hotels.php','products_id='.(int)$products_id));

$content = 'products_departure_hotels';
$javascript = 'products_departure_hotels.js.php';

$javascript_external = $content . '.js';

require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

require(DIR_FS_INCLUDES . 'application_bottom.php');
?>

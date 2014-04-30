<?php
/*
�����ŵ�ר�ú���
WebMakers.com Added: Additional Functions
Written by Linda McGrath osCOMMERCE@WebMakers.com
http://www.thewebmakerscorner.com

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 osCommerce

Released under the GNU General Public License
*/

/**
 * ����Ƿ����ظ�����������
 *
 * @param unknown_type $cruises_name
 * @param unknown_type $where
 * @return unknown
 */
function CheckCruisesName($cruises_name, $where = ""){
	$sql = tep_db_query('SELECT cruises_id  FROM `cruises` WHERE cruises_name ="'.$cruises_name.'" '.$where );
	$row = tep_db_fetch_array($sql);
	return (int)$row['cruises_id'];
}

/**
 * ȡ��ĳ�����ֵ�����
 *
 * @param unknown_type $cruises_id
 * @return unknown
 */
function getCruisesName($cruises_id){
	$sql = tep_db_query('SELECT cruises_name  FROM `cruises` WHERE cruises_id ="'.(int)$cruises_id.'" ');
	$row = tep_db_fetch_array($sql);
	return $row['cruises_name'];
}

/**
 * ȡ�����ֵ�ͼƬ���������ȡ�Ͳա��װ�ͼƬ�ȣ�
 *
 * @param unknown_type $id
 * @param unknown_type $type
 */
function getCruisesImages($id,$type='cruises',$cruises_id){
	$data = false;
	if(!(int)$id) return false;
	$sql = tep_db_query('SELECT * FROM `cruises_images` WHERE cruises_id="'.(int)$cruises_id.'" and images_link_id="'.(int)$id.'" AND images_type="'.tep_db_input(tep_db_prepare_input($type)).'" ORDER BY sort_id ASC, images_id DESC');
	while ($rows = tep_db_fetch_array($sql)){
		$data[] = $rows;
	}
	return $data;
}

/**
 * ȡ�����ֵĿͲ����������б�˵������ص�ID��products_options_id������cruises_cabin_id
 * �������
 */
function getCruisesCabinOptions($cruises_id){
	$data = false;
	$sql = tep_db_query('SELECT * FROM `cruises_cabin` WHERE cruises_id="'.(int)$cruises_id.'" ORDER BY sort_id, products_options_id DESC ');
	while($rows = tep_db_fetch_array($sql)){
		$data[] = array('id'=> $rows['products_options_id'], 'text'=> tep_db_output($rows['cruises_cabin_name']));
	}
	return $data;
}

/**
 * ȡ�ù�Ӧ�����ֵĿͲ�ѡ��
 * �˹�����ȡ�ù�Ӧ�̲�Ʒ�����е����ֵĿͲ�ѡ��
 * ��������
 * @param unknown_type $agency_id
 */
function getAgencyProductsOptions($agency_id, $filter_products_options_id=''){
	$data = false;
	$not_in = 0;
	if($filter_products_options_id!=""){
		$not_in = $filter_products_options_id;
	}
	$sql = tep_db_query('SELECT * FROM `products_options` p, `products_attributes_tour_provider` patp WHERE p.products_options_id=patp.products_options_id AND patp.agency_id="'.(int)$agency_id.'" AND p.products_options_id not in('.$not_in.') ORDER BY p.`products_options_sort_order` ');
	while ($rows=tep_db_fetch_array($sql)) {
		$data[] = array('id'=>$rows['products_options_id'],'text'=>$rows['products_options_name']);
	}
	return $data;
}

/**
 * ȡ�ò�Ʒ��Ӧ������ID��
 * @return 0 �� ���ֵ�ID��
 */
function getProductsCruisesId($products_id){
	$sql = tep_db_query('SELECT cruises_id FROM `products_to_cruises` WHERE products_id ="'.(int)$products_id.'" ');
	$row = tep_db_fetch_array($sql);
	return (int)$row['cruises_id'];
}

/**
 * ȡ�ò�Ʒ���ֵ���Ϣ�������۸���Ϣ���˹���Ҫ���ò�Ʒѡ��۸���Ϣ�����û����صĲ�Ʒѡ��������
 * ע�⣺�˺���ֻ���ڲ�Ʒ��ϸҳ��
 * @param unknown_type $cruises_id
 */
function getProductsCruisesInfos($cruises_id, $products_id){
	global $tour_agency_opr_currency;
	$data = false;
	$sql = tep_db_query('SELECT * FROM `cruises` WHERE 1 AND cruises_id="'.(int)$cruises_id.'" ');
	$data = tep_db_fetch_array($sql);
	//�жϲ�Ʒ�Ƿ�����ʾ����Ĳ�Ʒ
	$pSql = tep_db_query('SELECT display_room_option FROM `products` WHERE 1 AND products_id="'.(int)$products_id.'" ');
	$pRow = tep_db_fetch_array($pSql);

	//ȡ�ÿͲպͼװ�����
	$csql=tep_db_query('SELECT * FROM `cruises_cabin` WHERE cruises_id="'.(int)$cruises_id.'" ORDER BY sort_id ASC, products_options_id DESC');
	$data['cabins'] = array();
	$loop=0;
	while($crows = tep_db_fetch_array($csql)){
		$data['cabins'][$loop] = $crows;
		//ͼƬ
		$data['cabins'][$loop]['images'] = getCruisesImages($crows['products_options_id'], 'cabin', (int)$cruises_id);
		//�װ�
		$values_price_where = ' AND pa.options_values_price >0 ';
		if($pRow['display_room_option']=="1"){
			$values_price_where = ' AND (pa.single_values_price >0 || pa.double_values_price >0 || pa.triple_values_price >0 || pa.quadruple_values_price >0) ';
		}
		$dsql = tep_db_query('SELECT ccd.*,pa.options_values_price,pa.single_values_price,pa.double_values_price,pa.triple_values_price,pa.quadruple_values_price,pa.kids_values_price FROM `cruises_cabin_deck` ccd, products_attributes pa WHERE ccd.products_options_id="'.$crows['products_options_id'].'" AND pa.options_values_id=ccd.products_options_values_id '.$values_price_where.' AND pa.products_id="'.(int)$products_id.'" AND ccd.cruises_id="'.(int)$cruises_id.'" ORDER BY ccd.sort_id ASC, ccd.products_options_values_id DESC ');

		$lp1 = 0;
		while($drows=tep_db_fetch_array($dsql)){
			$data['cabins'][$loop]['decks'][$lp1] = $drows;
			$data['cabins'][$loop]['decks'][$lp1]['images'] = getCruisesImages($drows['products_options_values_id'], 'deck', (int)$cruises_id);
			if($pRow['display_room_option']=="1"){	// room
				$optionsValuesMinPrice = $drows['single_values_price'];
				if((int)$drows['double_values_price'] && $drows['double_values_price'] < $optionsValuesMinPrice){
					$optionsValuesMinPrice = $drows['double_values_price'];
				}
				if((int)$drows['triple_values_price'] && $drows['triple_values_price'] < $optionsValuesMinPrice){
					$optionsValuesMinPrice = $drows['triple_values_price'];
				}
				if((int)$drows['quadruple_values_price'] && $drows['quadruple_values_price'] < $optionsValuesMinPrice){
					$optionsValuesMinPrice = $drows['quadruple_values_price'];
				}
				/*
				if((int)$drows['kids_values_price'] && $drows['kids_values_price'] < $optionsValuesMinPrice){
					$optionsValuesMinPrice = $drows['kids_values_price'];
				}*/

			}else{	//no room
				$optionsValuesMinPrice = $drows['options_values_price'];
			}

			if ($tour_agency_opr_currency != 'USD' && $tour_agency_opr_currency != '') {
				$data['cabins'][$loop]['decks'][$lp1]['single_values_price']=tep_get_tour_price_in_usd($data['cabins'][$loop]['decks'][$lp1]['single_values_price'],$tour_agency_opr_currency);
				$data['cabins'][$loop]['decks'][$lp1]['double_values_price']=tep_get_tour_price_in_usd($data['cabins'][$loop]['decks'][$lp1]['double_values_price'],$tour_agency_opr_currency);
				$data['cabins'][$loop]['decks'][$lp1]['triple_values_price']=tep_get_tour_price_in_usd($data['cabins'][$loop]['decks'][$lp1]['triple_values_price'],$tour_agency_opr_currency);
				$data['cabins'][$loop]['decks'][$lp1]['quadruple_values_price']=tep_get_tour_price_in_usd($data['cabins'][$loop]['decks'][$lp1]['quadruple_values_price'],$tour_agency_opr_currency);
				$data['cabins'][$loop]['decks'][$lp1]['optionsValuesMinPrice']=tep_get_tour_price_in_usd($optionsValuesMinPrice,$tour_agency_opr_currency);
			}else{
				$data['cabins'][$loop]['decks'][$lp1]['optionsValuesMinPrice']=$optionsValuesMinPrice;
			}
			$lp1++;
			//print_r($drows);
		}
		//����ò���û�а����۸�ļװ���Ϣ��ȡ���ÿͲ���Ϣ
		if($lp1==0){
			unset($data['cabins'][$loop]);
		}else{
			$loop++;
		}
	}

	return $data;

}

/**
 * ȡ��������ÿ��Ҫ����˰��
 *
 * @param unknown_type $products_options_id
 * @return unknown
 */
function getCruisesPerPersonTaxT($products_options_id){
	$sql = tep_db_query('SELECT options_values_price FROM `products_options_values_to_products_options` povtp, `products_attributes` pa WHERE `products_options_id`="'.(int)$products_options_id.'" AND pa.options_id=povtp.products_options_id AND options_values_price>0 Limit 1');
	$row = tep_db_fetch_array($sql);
	return $row['options_values_price'];
}
?>
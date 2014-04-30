<?php
/*
WebMakers.com Added: Additional Functions
Written by Linda McGrath osCOMMERCE@WebMakers.com
http://www.thewebmakerscorner.com

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 osCommerce

Released under the GNU General Public License
*/

/**
 * �Ƶ����еĺ�����ǰ��̨���� Howard added
 */

/**
 * ȡ�þƵ��ʳѡ��
 * @param $mealsId��ʳid�����û��ID���������
 */
function getHotelMealsOptions($mealsId=0){
	$array = array();
	$array[] = array('id'=>1,'text'=>"�����");
	$array[] = array('id'=>2,'text'=>"�����");
	$array[] = array('id'=>3,'text'=>"�����");
	$array[] = array('id'=>4,'text'=>"����ͺ����");
	$array[] = array('id'=>5,'text'=>"����ͺ����");
	$array[] = array('id'=>6,'text'=>"����ͺ����");
	$array[] = array('id'=>7,'text'=>"����͡���ͺ����");
	$array[] = array('id'=>9,'text'=>"������");
	if((int)$mealsId){
		foreach($array as $key => $val){
			if($mealsId==$array[$key]['id']){
				return $array[$key]['text'];
			}
		}
		return '';
	}
	return $array;
}

/**
 * ȡ�þƵ���λ��ѡ��
 * @param $locationIdλ��id�����û��ID���������
 */
function getHotelApproximateLocation($locationId=0){
	$array = array();
	$array[] = array('id'=>1,'text'=>"��������");
	$array[] = array('id'=>2,'text'=>"������");
	$array[] = array('id'=>3,'text'=>"����");
	$array[] = array('id'=>4,'text'=>"����");
	$array[] = array('id'=>5,'text'=>"������");
	$array[] = array('id'=>6,'text'=>"��˹ά��˹���");
	
	if((int)$locationId){
		foreach($array as $key => $val){
			if($locationId==$array[$key]['id']){
				return $array[$key]['text'];
			}
		}
		return '';
	}
	return $array;
}

/**
 * �Ƶ���������
 * @param $optionsIdλ��id�����û��ID���������
 */
function getHotelInternetOptions($optionsId=0){
	$array = array();
	$array[] = array('id'=>1,'text'=>"��ѿ��");
	$array[] = array('id'=>2,'text'=>"�����������");
	$array[] = array('id'=>3,'text'=>"�����������");
	$array[] = array('id'=>4,'text'=>"��������");
	$array[] = array('id'=>5,'text'=>"�������������");
	$array[] = array('id'=>6,'text'=>"�����������");
	$array[] = array('id'=>9,'text'=>"����������");
	if((int)$optionsId){
		foreach($array as $key => $val){
			if($optionsId==$array[$key]['id']){
				return $array[$key]['text'];
			}
		}
		return '';
	}
	return $array;
}

/**
 * ȡ��ĳ�Ƶ������ͼƬ��Ϣ
 * @param $hotel_id
 * @return $infos[]
 */
function getHotelImagesInfos($hotel_id){
	$infos = array();
	$hotel_pic_sql = tep_db_query('SELECT * FROM `hotel_pic` WHERE hotel_id ="'.(int)$hotel_id.'" ORDER BY `hotel_pic_sort` ASC ');
	$hotel_pic_rows = tep_db_fetch_array($hotel_pic_sql);
	if((int)$hotel_pic_rows['hotel_pic_id']){
		$first_img_src = $hotel_pic_rows['hotel_pic_url'];
		if(!preg_match('/^http:\/\//',$first_img_src)){
			$first_img_src = DIR_WS_IMAGES.'hotel/'.$first_img_src;
		}
		$first_img_alt = tep_db_output($hotel_pic_rows['hotel_pic_alt']);
		$infos[]=array('src'=> $first_img_src, 'alt'=>ALT_VIEW_BIG_PIC, 'desc'=> $hotel_pic_rows['hotel_pic_alt']);
		do{
			$img_src =$hotel_pic_rows['hotel_pic_url'];
			if(!preg_match('/^http:\/\//',$img_src)){
				$img_src = DIR_WS_IMAGES.'hotel/'.$img_src;
			}
			$img_alt = tep_db_output($hotel_pic_rows['hotel_pic_alt']);

			$infos[]=array('src'=> $img_src, 'alt'=>$img_alt, 'desc'=> $img_alt);
		}while($hotel_pic_rows = tep_db_fetch_array($hotel_pic_sql));
	}
	if(!(int)sizeof($infos) || ((int)sizeof($infos)==1 && !tep_not_null($infos[0]['src'])) ){ return false; }
	return $infos;
}
?>
<?php
/**
 * ��Ʒ��Ƶ��
 * @author wtj
 * @date 2013-8-5
 */
class ProductVideo extends ProductList{
	/**
	 * ���췽��,����Ҫ��ѯ���ֶ�,����ִ��ʱ��
	 */
	function __construct(){
		$this->_fileds='p.agency_id,p.products_id,p.products_video,pd.products_name';
	}
	/**
	 * (non-PHPdoc)
	 * @see ProductList::createWhere()
	 */
	function createWhere($get){
		$str='';
		$str.=$get['agency_id']?' AND p.agency_id='.(int)$get['agency_id']:'';
		$str.=$get['product_id']?' AND p.products_id='.(int)$get['product_id']:'';
		$str.=$get['pri_key']?' AND p.products_video like"%'.$get['pri_key'].'%"':'';
		return $str;
	}
	/**
	 * �ı�һ��
	 * @param string $video ��Ƶ��ַ
	 * @param array $id ����������ǵ�һ�ֱ�ʾ
	 * @param int $type ����Ĭ��Ϊproducts_id,1Ϊ��Ӧ��ID
	 * @return number
	 */
	function changeOne($video,$id,$type=''){
		if(!$id)
			return;
		$str_sql='update '.$this->_product_table.' set products_video="'.$video.'" where ';
		$str='';
		if(is_array($id)){
		foreach ($id as $value){
			$str.=','.$value;
		}
		$str='('.substr($str, 1).')';}
		else $str='('.$id.')';
		switch ($type){
			case 1 :$str_sql.=' agency_id in'.$str;
			default:$str_sql.=' products_id in'.$str;
		}
		echo $str_sql;
		tep_db_query($str_sql);
		return 0;
	}
}
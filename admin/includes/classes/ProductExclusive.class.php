<?php
/**
 * �����ػ�
 * @author wtj
 * @date 2013-8-5
 */
class ProductExclusive extends ProductList{
	/**
	 * ���췽��,����Ҫ��ѯ���ֶ�,����ִ��ʱ��
	 */
	function __construct(){
		$this->_fileds='p.agency_id,p.products_id,p.only_our_free,pd.products_name';
	}
	/**
	 * (non-PHPdoc)
	 * @see ProductList::createWhere()
	 */
	function createWhere($get){
		$str='';
		$str.=$get['agency_id']?' AND p.agency_id='.(int)$get['agency_id']:'';
		$str.=$get['product_id']?' AND p.products_id='.(int)$get['product_id']:'';
		$str.=$get['pri_key']?' AND p.only_our_free like BINARY "%'.$get['pri_key'].'%"':'';
		return $str;
	}
	/**
	 * ���Ķ����ػ�
	 * @param string $content �����ػݵ�����
	 * @param array||int $id ��ƷID
	 * @return number
	 */
	function changeOne($content,$id){
		if(!$id)
			return;
		$str_sql='update '.$this->_product_table.' set only_our_free="'.$content.'" where ';
		$str='';
		if(is_array($id)){
		foreach ($id as $value){
			$str.=','.$value;
		}
		$str='('.substr($str, 1).')';}
		else $str='('.$id.')';
		$str_sql.=' products_id in'.$str;
		tep_db_query($str_sql);
		return 0;
	}
}
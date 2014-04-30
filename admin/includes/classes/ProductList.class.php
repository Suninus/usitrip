<?php
/**
 * ��Ʒ�б���
 * @author wtj
 * @date 2013-8-5
 */
class ProductList{
	protected $page_number=50;
	private $number;
	protected $_product_table='products';
	protected $_des_table='products_description';
	protected $_fileds='p.*,pd.*';
	function __construct(){
		
	}
	/**
	 * ��ȡproducts list
	 * @param int $agency_id ��Ӧ��ID
	 * @param string $order_by �����ֶ�����p==products,pd==products_description
	 * @return array ������ҳ��Ϣ
	 */
	public function getList($get,$order_by=''){
		$str_sql='select '.$this->_fileds.' from '.$this->_product_table.' p,'.$this->_des_table.' pd where p.products_id=pd.products_id ';
// 		$agency_id?$str_sql.=' AND p.agency_id='.$agency_id:'';
		$str_sql.=$this->createWhere($get);
		$str_sql.=' ORDER BY products_head_desc_tag,products_head_title_tag,products_head_keywords_tag';
		//$order_by?$str_sql.='order by '.$order_by:'';
		//$this->number = tep_db_num_rows(tep_db_query($str_sql));
		//$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$track_query_numrows = 0;
		//��ҳ�ĵط�����һ���Է��ػ�ȥ
		$track_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_ADMIN, $str_sql, $track_query_numrows);
		$a = $track_split->display_links($track_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ADMIN, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], tep_get_all_get_params(array (
				'page',
				'y',
				'x',
				'action'
		)));
		$b = $track_split->display_count($track_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ADMIN, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS);
		return array (
				'info' => $this->doSelect($str_sql),
				'a' => $a,
				'b' => $b
		);
	}
	/**
	 * ��ѯ
	 * @param string $str_sql ��ѯ��SQL���
	 * @return array
	 */
	protected function doSelect($str_sql) {
		$return = array ();
		$sql_query = tep_db_query($str_sql);
		while ($row = tep_db_fetch_array($sql_query)) {
			$return[] = $row;
		}
		return $return;
	}
	/**
	 * ����һ�ű��һ���ֶ�
	 * @param string $table ��
	 * @param string $id_name ��ID������
	 * @param int $id_value ��ID��ֵ
	 * @param string $fileds_name Ҫ���ĵ��ֶε�����
	 * @param string||int $fileds_value Ҫ�����ֶε�ֵ
	 * @return number
	 */
	protected function changeOneLine($table,$id_name,$id_value,$fileds_name,$fileds_value){
		$str_sql="UPDATE $table set $fileds_name='$fileds_value' WHERE $id_name=".(int)$id_value;
		tep_db_query($str_sql);
		return 0;
	}
	/**
	 * ����where���������ӷ�����
	 */
	protected function createWhere($get){
		
	}
}
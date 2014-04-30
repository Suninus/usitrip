<?php 
/**
 * ���ݴ����ID��ȡ��Ӧ���в�Ʒ�ĳ����������������
 * ���ڽ��ͬ����Ŀ�з������� ����ɸѡ ��·��
 * @author lwkai 2012-06-21
 *
 */
class companions_line_filter{
	/**
	 * ��ǰ����ID [���ID]
	 * @var int
	 */
	private $categories_id = 0;
	
	/**
	 * ����𼯺�
	 * @var string
	 */
	private $subcategory_ids = '0';

	
	private $products_ids = '';
	
	/**
	 * ���ݴ����IDȡ������С����ID
	 * @param int $categories_id �����ID
	 */
	public function __construct($categories_id){
		if((int)$categories_id > 0) {
			$this->categories_id = (int)$categories_id;
			$this->get_all_categories();
		}
	}
	
	/**
	 * ��������ID �õ������Ӿ���ID
	 */
	private function get_all_categories(){
		$sql = tep_db_query("select categories_id from categories where parent_id='" . $this->categories_id . "' and categories_status=1");
		if (tep_db_num_rows($sql) > 0) {
			while ($row = tep_db_fetch_array($sql)) {
				$rtn[] = $row['categories_id'];
			}
			$rtn = join(',',$rtn);
		}
		$rtn = ($rtn ? $rtn : '0');
		$this->subcategory_ids = $rtn;
	}
	
	/**
	 * ���������õ����в�ƷID
	 */
	private function get_all_products_id(){
		$sql = tep_db_query("select products_id from products_to_categories where categories_id in (" . $this->subcategory_ids . ") and products_id <> 0");
		if (tep_db_num_rows($sql) > 0) {
			while ($row = tep_db_fetch_array($sql)) {
				$rtn[] = $row['products_id']; 
			}
			$rtn = join(',',$rtn);
		}
		$rtn = ($rtn ? $rtn : '0');
		$this->products_ids = $rtn;
	}
	
	/**
	 * �����ӷ���IDȡ�ö�Ӧ��·�µ����н������� ID
	 * @return string
	 */
	private function get_departure_end_city_id(){
		$sql = tep_db_query("select DISTINCT p.departure_end_city_id  from products p, products_to_categories p2c  where p.products_status = '1' and p.products_id = p2c.products_id  and p2c.categories_id in (" . $this->subcategory_ids . ") and p2c.products_id <> 0");
		if (tep_db_num_rows($sql) > 0) {
			while ($row = tep_db_fetch_array($sql)) {
				$rtn[] = $row['departure_end_city_id'];
			}
			$rtn = join(',',$rtn);
			$rtn = preg_replace("/,+/",',',$rtn);
		}
		$rtn = ($rtn ? $rtn : '0');
		return $rtn;
	}
	
	/**
	 * �����ӷ���IDȡ�ö�Ӧ��·�µ����г�������ID
	 * @return string
	 */
	private function get_departure_city_ids(){
		$sql = "select DISTINCT p.departure_city_id  from products p, products_to_categories p2c  where p.products_status = '1' and p.products_id = p2c.products_id  and p2c.categories_id in (" . $this->subcategory_ids . ") and p2c.products_id <> 0";
		$sql = tep_db_query($sql);
		if (tep_db_num_rows($sql) > 0) {
			while ($row = tep_db_fetch_array($sql)) {
				$rtn[] = $row['departure_city_id'];
			}
			$rtn = join(',', $rtn);
			$rtn = preg_replace("/,+/",',',$rtn);
		}
		$rtn = ($rtn ? $rtn : '0');
		return $rtn;
	}
	
	/**
	 * ��ȡ��ǰ����������·�Ľ�������
	 * @return array [array('����ID'=>'��������')]
	 */
	public function get_end_departure_city(){
		$depature_city_ids = $this->get_departure_end_city_id();
		return $this->get_city($depature_city_ids);
	}
	
	/**
	 * ��ȡ��ǰ�����������·�ĳ�������
	 * @return array [array('����ID'=>'��������')]
	 */
	public function get_departure_city(){
		$depature_city_ids = $this->get_departure_city_ids();
		return $this->get_city($depature_city_ids);
	}
	
	/**
	 * ���ݴ���ĳ���IDȡ�ö�Ӧ�ĳ�������
	 * @param string $depature_city_ids ���е�ID[2,3,4,5]
	 * @return array [array('����ID'=>'��������')]
	 */
	private function get_city($depature_city_ids){
		$sql = tep_db_query("select city_id, city from tour_city where city_id in (" . $depature_city_ids . ") AND departure_city_status = '1' AND `is_attractions` !='1' order by city");
		$rtn = array();
		if (tep_db_num_rows($sql) > 0) {
			while ($row = tep_db_fetch_array($sql)) {
				$rtn[$row['city_id']] = $row['city'];
			}
		}
		return $rtn;
	}
	
	
	
	/**
	 * ���ݳ������л��߽��������ҳ��ɽ��н��ͬ�ε���·
	 * @param string $start_city_id ��������
	 * @param string $end_city_id  ��������
	 * @return array
	 */
	public function get_products_name($start_city_id,$end_city_id){
		if (TRAVEL_COMPANION_OFF_ON == 'true') {
			$sql = "select p.products_id,pd.products_name from products_description as pd,products as p where p.products_id = pd.products_id";
			if (tep_not_null($start_city_id) != false) {
				$sql .= ' and FIND_IN_SET("' . $start_city_id . '",p.departure_city_id)';
			}
			if (tep_not_null($end_city_id) != false) {
				$sql .= ' and FIND_IN_SET("' . $end_city_id . '",p.departure_end_city_id)';
			}
			$sql .= " and p.display_room_option = 1 and p.products_status=1 and p.is_hotel=0";
			$data = tep_db_query($sql);
			$rtn = array();
			while ($row = tep_db_fetch_array($data)) {
				$rtn[] = $row;
			}
			return $rtn;
		}
	}
}
?>
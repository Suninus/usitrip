<?php 
/**
 * ���ݶ���ID��ȡ��������Ҫ���Ŀ���
 * 
 * @author lwkai 2012-06-20
 *
 */
class companions_personal_pay{

	/**
	 * �û���Ҫ���Ŀ�
	 * eg: array('10045'=>'450','600004'=>'15200');
	 * array('�û�ID'=>'�踶����')
	 * @var array
	 *
	 */
	private $customers_pay = array();

	/**
	 * ��ǰ������
	 * @var int
	*/
	private $orders_id = 0;

	/**
	 * ��������ԭʼ��¼���� [���ݿ��ж�ȡ�����Ľ��������]
	 * @var array
	 */
	private $orders_data = array();

	/**
	 * ���ݶ���IDȡ�ø�������ҪҪ���Ŀ�
	 * @param int $orders_id ����ID��
	*/
	public function __construct($orders_id){
		if (is_numeric($orders_id) == true) {
			$this->orders_id = $orders_id;
			$this->getOrders();
		}
	}

	/**
	 * ȡ�õ�ǰ���������û�������
	 */
	private function getOrders(){
		$orders_sql = tep_db_query("select products_id,customers_id,guest_name,is_child,payables,paid from orders_travel_companion where orders_id='" . $this->orders_id . "'");
		if (tep_db_num_rows($orders_sql) > 0){
			while (false !== ($row = tep_db_fetch_array($orders_sql))){
				$this->orders_data[] = $row;
			}
		}
	}

	/**
	 * ��ʽ������
	 */
	private function formatData(){
		$child = array();
		$rtn = array();
		foreach($this->orders_data as $key => $val) {
			if ($val['is_child'] === 'true') {
				$child[$val['guest_name']] = $child[$val['guest_name']] + ($val['payables'] - $val['paid']);
			} else {
				$rtn[$val['customers_id']]['needpay'] = $rtn[$val['customers_id']]['needpay'] + $val['payables'];
				$rtn[$val['customers_id']]['paid'] = $rtn[$val['customers_id']]['paid'] + $val['paid'];
			}
		}
		foreach($rtn as $key => $val){
			$this->customers_pay[$key] = '����Ҫ���$' . number_format($val['needpay'],2);
			if ($val['paid'] > 0) {
				$this->customers_pay[$key] .= '<br/>�Ѹ��$' . number_format($val['paid'],2) . '<br/>���踶�$' . 
					($val['needpay'] - $val['paid'] > 0 ? number_format($val['needpay'] - $val['paid'],2) : 0) . '<br/>';
			}
		}
		foreach($child as $key => $val){
			$temp .= 'С����������' . tep_filter_guest_chinese_name($key) . '��,�踶�$' . number_format($val,2) . '<br/>';
		}
		$this->customers_pay['child'] = ($temp == '' ? '' : $temp . '<span style="color:#f00">ע�������������С�������踶��Ӧ���</span>');

	}

	/**
	 * ȡ���û�����Ҫ���Ŀ�
	 * @param string|int $customers �û���ID�Ż��������ַ
	 * @return multitype: �û���Ҫ����Ǯ
	 */
	public function getCustomersPay($customers){
		if (count($this->customers_pay) == 0) {
			$this->formatData();
		}
		if (is_numeric($customers) == false) {
			$customers_id = $this->getCustomersId($customers);
		} else {
			$customers_id = $customers;
		}
		if ((int)$customers_id > 0){
			return $this->customers_pay[$customers_id];
		} else {
			return 0;
		}
	}

	/**
	 * ���С��������Ҫ���Ŀ�
	 * @return multitype:
	 */
	public function getChildPay(){
		return $this->customers_pay['child'];
	}

	/**
	 * �����û�ע������ȡ���û�ID
	 * @param string $mail �û�ע��������ַ
	 * @return �û���ID
	 */
	private function getCustomersId($mail){
		if (tep_not_null($mail) == true) {
			$sql = tep_db_query("select customers_id from customers where customers_email_address='" . $mail . "'");
			if (tep_db_num_rows($sql) > 0){
				$row = tep_db_fetch_array($sql);
				return $row['customers_id'];
			} else {
				return 0;
			}
		}
	}
}
?>
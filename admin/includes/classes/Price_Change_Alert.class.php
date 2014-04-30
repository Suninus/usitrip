<?php
/**
 * ��Ʒ�۸�䶯������
 * @author Howard by 2013-04-08
 */
class Price_Change_Alert {
	/**
	 * ���²�Ʒ�۸����ĸ���ʱ��
	 * @param int $products_id ��Ʒ���\
	 * @param string $type_name ���¼۸��ģ������ by lwkai added 2013-07-01
	 * @return int
	 */
	public function update_product_price_last_modified($products_id,$type_name){
		tep_db_query('update products set products_price_last_modified=now() where products_id="'.(int)$products_id.'"');
		$rtn = tep_db_affected_rows();
		$data = array('admin_id'=>$_SESSION['login_id'],'time'=>date('Y-m-d H:i:s'),'type'=>$type_name,'products_id'=>intval($products_id));
		if (!isset($_SESSION['login_id']) || intval($_SESSION['login_id']) == 0) {
			$data['admin_id'] = '-1';
		}
		tep_db_fast_insert("products_update_price", $data);
		return $rtn;
	}
	
	/**
	 * ���¶�����Ʒ���Ĳ�Ʒ�۸��޸�ʱ�� (�Ӳ�Ʒ���и��¹���)
	 * ����¼���֪���˰�ť�Ĺ�����ʱ��
	 * @param int $orders_id �������
	 */
	public function update_orders_products_price_last_modified($orders_id) {
		tep_db_query('update `orders_products` op, products p set op.products_price_last_modified=p.products_price_last_modified where op.orders_id="'.(int)$orders_id.'" and op.products_id=p.products_id ');
		$rtn = tep_db_affected_rows();
		$data = array('orders_id'=>intval($orders_id),'click_time'=>date('Y-m-d H:i:s'));
		if (isset($_SESSION['login_id']) && intval($_SESSION['login_id']) > 0) {
			$data['job_number'] = tep_get_job_number_from_admin_id($_SESSION['login_id']);
		}
		tep_db_fast_insert("price_notification_validation", $data);
		return $rtn;
	}
	
	/**
	 * ȡ��δ�������Ʒ�۸��и��µĶ���
	 * @param string $payment_status �Ƿ��Ѹ���0Ϊδ����,1Ϊ�Ѹ���,2Ϊ�Ѿ����ָ���
	 * @param string $outwith_status ���ų��Ķ���״̬����,�ŷָ�
	 * @return array
	 */
	public function get_product_price_update_orders($payment_status = '0,2', $orders_id = '', $outwith_status = ''){
		$data = array();
		$str = 'SELECT DISTINCT o.orders_id FROM orders_products op, products p, orders o WHERE op.orders_id=o.orders_id and o.orders_status!="6" and p.products_id = op.products_id and op.products_price_last_modified!=p.products_price_last_modified and op.orders_products_payment_status IN ('.$payment_status.') and op.final_price > 0 ';
		if($orders_id){
			$str.= ' and o.orders_id="'.(int)$orders_id.'" ';
		}
		if($outwith_status){
			$str.= ' and o.orders_status not in('.implode(',',explode(',',$outwith_status)).') ';
		}
		$sql = tep_db_query($str);
		while ($rows = tep_db_fetch_array($sql)) {
			$data[] = $rows['orders_id'];
		}
		return $data;
	}
	
}
?>
<?php
/**
 * �����¼֮��ע(for ����)
 */
class payment_history_accounts_remark {
	var $login_id;	//��ǰ��¼�Ĺ���Աid
	/**
	 * �����¼֮��ע����������
	 */
	var $tables;
	
	/**
	 * payment_history_accounts_remark���캯��
	 *
	 * @param unknown_type $arr
	 */
	function __construct($arr = array()){
		global $login_id, $messageStack;
		if(is_array($arr) && count($arr)>0){
			foreach($arr as $key => $value){
				$this->$key = $value;
			}
		}
		$this->login_id = $login_id;
		$this->tables = 'orders_payment_account_remark_history'; //�����¼֮��ע����������
	}
	
	/**
	*������¼
	*@para int $orders_payment_history_id �����¼���
	*@para string $remark ��ע����
	*@para int $login_id ������
	*@return int inserted_id �����id
	*/
	public function add_remark($orders_payment_history_id, $remark, $login_id)
	{
		$orders_payment_history_id = (int)$orders_payment_history_id;
		$remark = substr($remark,0,100);
		$login_id = (int)$login_id;				
		if($orders_payment_history_id<1 || $login_id<1 ){ return false; }
		
		$inserted_id = 0;		
		$datetime = date('Y-m-d H:i:s');
		
		$data = false;
		$data[orders_payment_history_id] = $orders_payment_history_id;
		$data[remark] = tep_db_prepare_input($remark);
		$data[login_id] = $login_id;
		$data[add_date] = date('Y-m-d H:i:s');
		
		$inserted_id = tep_db_fast_insert(''.$this->tables.'',$data,'');

		return $inserted_id;
	}

	/**
	*��ʾ��¼
	*@para int $orders_payment_history_id �����¼���
	*@para bool $show_last �Ƿ�����ʾ���һ�ʼ�¼(Ĭ������ʾȫ��)
	*@return array
	*/
	public function show_history($orders_payment_history_id,$show_last=false)
	{
		$orders_payment_history_id = (int)$orders_payment_history_id;
		if($orders_payment_history_id<1){ return false; }
		
		$data = false;
		$sql = 'SELECT a.remark, b.admin_job_number, a.add_date FROM '.$this->tables.' AS a, admin AS b WHERE a.orders_payment_history_id='.$orders_payment_history_id.' AND a.login_id=b.admin_id ORDER BY a.add_date DESC ';
		if (true == $show_last)
		{
			$sql .= ' LIMIT 0,1';
		}
		//echo $sql;
		$sql_query = tep_db_query($sql);
		while( $rows =  tep_db_fetch_array($sql_query))
		{
			$data[] = $rows;
		}
		
		return $data;
	}

}
?>
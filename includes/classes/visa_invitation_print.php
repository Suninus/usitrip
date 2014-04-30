<?php
/**
 * ǩ֤�����뺯����
 * @author lwkai by 2012-10-10 17:57
 * @package ǩ֤�����뺯����
 */
class visa_invitation_print {
	
	/**
	 * ������ƷID
	 * @var int
	 */
	private $orders_products_id = 0;
	
	/**
	 * ������
	 * @var int
	 */
	private $orders_id = 0;
	
	/**
	 * ��ƷID
	 *
	 * @var int
	 */
	private $products_id = 0;
	
	/**
	 * ��ǰ������Ʒ���ܼ۸�
	 *
	 * @var float
	 */
	private $products_price = 0;
	/**
	 * ǩ֤ģ���ļ���ַ
	 *
	 * @var string
	 */
	private $template_file = 'email_tpl/visa_invitation.tpl.html';
	
	/**
	 * ������Ա�������ڻ��պ���������顣
	 * �������Ա𣬳������ڣ����պ��룬����
	 *
	 * @var array
	 */
	private $guest = array();
	
	/**
	 * �ʼ��ĵ�ַ
	 *
	 * @var ArrayObject;
	 */
	private $mail_array = array();
	
	/**
	 * �����������뺯��
	 * �������$orders_products_id�������� set_orders_products_id�����á�
	 * ��Ӧ����orders_products���orders_products_id
	 *
	 * @param int $orders_products_id
	 *        	������ƷID[��ѡ]
	 */
	public function __construct($orders_products_id = 0) {
		$this->set_orders_products_id($orders_products_id);
	}
	
	/**
	 * ����Ψһ��ʶ��
	 *
	 * @param string $uuid �����uuid
	 */
	function getEmailArray() {
		return $this->mail_array;
	}
	
	/**
	 * ���ö�����ƷID
	 *
	 * @param int $products_id
	 *        	��ƷID
	 */
	public function set_orders_products_id($orders_products_id) {
		if ((int)$orders_products_id > 0) {
			$this->orders_products_id = $orders_products_id;
		}
	}
	
	/**
	 * �������뺯ģ���ļ�·����
	 * ע����Ҫ��������·����
	 *
	 * @param string $file        	
	 */
	public function set_template_file($file) {
		if (isset($file) && ! empty($file)) {
			if (file_exists($file)) {
				$this->template_file = $file;
			}
		}
	}
	
	/**
	 * ���ÿ��˵����գ����պ��룬�������ϡ�
	 * �����һ����������������������ʽ�������Ĳ�����������Ҫ���������в���ȱһ���ɡ�
	 * ������ʽ
	 * array(
	 * 	'������ID'=>array(
	 * 		'dob'=>'��������',
	 * 		'passport_number'=>'���պ���',
	 * 		'nationality'=>'����',
	 * 		'money'=>'���',
	 * 		'guest_name'=>'����������',
	 * 		'email'=>'����������',
	 * 		'sex'=>'�������Ա�')
	 * 	[,'������ID'=>array(
	 * 		'dob'=>'��������',
	 * 		'passport_number' => '���պ���',
	 * 		'nationality'=>'����'
	 * 		...
	 * )'[,...]])
	 *
	 * @param array ������Ϣ����
	 * @throws Exception ����û���������������Ч�����׳��쳣
	 */
	public function set_user_dob($guest_id) {
		$this->guest = array();
		if (is_array($guest_id)) {
			foreach ( $guest_id as $key => $val ) {
				if (strtotime($val['dob']) === false) {
					throw new Exception('�ⲻ��һ����Ч������');
				}
				$this->guest[$key]['dob'] = date('Y-m-d', strtotime($val['dob']));
				$this->guest[$key]['passport_number'] = $val['passport_number'];
				$this->guest[$key]['nationality'] = $val['nationality'];
				$this->guest[$key]['money'] = $val['money'];
				$this->guest[$key]['is_send'] = 1;
				$this->guest[$key]['guest_name'] = $val['guest_name'];
				$this->guest[$key]['e_mail'] = $val['email'];
				$this->guest[$key]['guest_gender'] = $val['sex'];
				$this->mail_array[$val['email']] = $val['guest_name'];
			}
		}
	}

	/**
	 * ��ȡ���ο�ʼ��������
	 */
	private function _travel_period() {
		$sql = "select `products_id`,`products_departure_date`,`final_price` from `orders_products` where `orders_products_id`='" . $this->orders_products_id . "'";
		$result = tep_db_query($sql);
		$row = tep_db_fetch_array($result);
		$rtn = array();
		if ($row) {
			$rtn['start'] = $row['products_departure_date'];
			$rtn['end'] = tep_get_products_end_date($row['products_id'], $rtn['start']);
			$this->products_price = $row['final_price'];
		}
		return $rtn;
	}
	
	/**
	 * ��ȡ��ǰ������Ʒ�Ķ����źͲ�ƷID
	 *
	 * @throws Exception ���������ƷIDΪ�㣬���׳��쳣
	 */
	private function _get_ordersid_productsid() {
		if ($this->orders_products_id == 0) {
			throw new Exception('������ƷID����Ϊ�㣬�����ö�����ƷID��');
		}
		$sql = "select `orders_id`,`products_id` from `orders_product_eticket` where `orders_products_id`='" . $this->orders_products_id . "'";
		$result = tep_db_fetch_array(tep_db_query($sql));
		if ($result) {
			$this->orders_id = $result['orders_id'];
			$this->products_id = $result['products_id'];
		}
	}
	
	/**
	 * ����г�������Ϣ�б�
	 */
	private function get_day_list() {
		if ($this->products_id == 0) {
			$this->_get_ordersid_productsid();
		}
		$sql = "select `travel_name`,`travel_hotel`,`travel_index` from `products_travel` where `products_id`='" . $this->products_id . "' order by `travel_index` asc";
		$result = tep_db_query($sql);
		$rtn = array();
		while ( $row = tep_db_fetch_array($result) ) {
			$rtn[] = $row;
		}
		return $rtn;
	}
	
	/**
	 * ��ȡģ���ļ�
	 */
	private function read_file() {
		if (file_exists($this->template_file)) {
			return file_get_contents($this->template_file);
		}
	}
	
	/**
	 * �����Ա𷵻ض�Ӧ��Ms����Mr�����Ա𲻵�����Ҳ������Ůʱ�����ؿ�
	 *
	 * @param string $gender        	
	 */
	private function gender_prefix($gender) {
		$rtn = '';
		if (! empty($gender)) {
			if (trim($gender) == '��') {
				$rtn = 'Mr.';
			} elseif (trim($gender) == 'Ů') {
				$rtn = 'Ms.';
			} else {
				$rtn = '';
			}
		}
		return $rtn;
	}
	
	/**
	 * ����Ϣ��ģ�����ϣ����������Ϻ������
	 *
	 * @return string
	 * @throws Exception ���ģ���ļ�����Ϊ�գ����׳��쳣
	 */
	public function doit($email='') {
		$html = $this->read_file();
		if (! empty($html)) {
			// ��ȡ���г̵Ŀ�ʼ��������
			$dates = $this->_travel_period();
			// ��ò�ƷID�Ͷ�����
			$this->_get_ordersid_productsid();
			// ����г���Ϣ�б�
			$day_list_temp = $this->get_day_list();
			$day_list = '';
			$i = 0;
			// ����г���ϢΪһ���ַ���
			foreach ( $day_list_temp as $key => $val ) {
				$day_list .= 'DAY ' . $val['travel_index'] . ' (' . date('m/d', strtotime(date('Y-m-d H:i:s', strtotime($dates['start'])) . ' +' . $i . 'days')) . ') ' . $val['travel_name'] . ' <br />';
				$day_list .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hotel:' . $val['travel_hotel'] . '<br />';
				$i ++;
			}
			// ȡģ������Ҫѭ���ĵط�
			if (preg_match('/<!--\s+BEGIN list_start\s*-->(.*)\s*<!--\s*END list_start\s*-->/ism', $html, $matchs)) {
				$list_start = $matchs[1];
				$html = preg_replace('/<!--\s*BEGIN\s+list_start\s*-->(.*)<!--\s*END\s+list_start\s*-->/ism', '{list_start}', $html);
			}
			$list_start_handle = '';
			$name_all = '';
			$len = count($this->guest);
			if ($len == 0) { // ������ô˷�����ʱ�򣬻�û��ȡ�������ݣ������guest_nameȡ���û���Ϣ
				$this->createGuest($email);
				$len = count($this->guest);
			}
			foreach ( $this->guest as $key => $value ) {
				$i = 0;
				$mr = $this->gender_prefix($value['guest_gender']);
				if (($i + 1) == $len && $i != 0) {
					$name_all .= ' and ' . $mr . $value['guest_name'];
				} else {
					$name_all .= $mr . $value['guest_name'] . '&nbsp;';
				}
				$temp = str_replace(
						array('{name}','{date}','{passportnumber}','{nationality}'), 
						array($mr . $value['guest_name'],date('M.d<\s\up>S</\s\up>Y', strtotime($value['dob'])),$value['passport_number'],$value['nationality']), 
						$list_start
				);
				$list_start_handle .= $temp;
				$i ++;
			}
			if ($len > 1) {
				$is_have = ' have';
			} else {
				$is_have = ' has';
			}
			$date_start = date('M.d<\s\up>S</\s\up>Y', strtotime($dates['start']));
			$date_end = date('M.d<\s\up>S</\s\up>Y', strtotime($dates['end']));
			$money=$this->getMoney();
			if (empty($money)) {
				$money = '';
			} else {
				$money = 'COST : $ ' . $money;
			}
			$html = str_replace('{list_start}', $list_start_handle, $html);
			$html = str_replace(
					array('{start_date}','{end_date}','{orders_id}','{send_date}','{day_list}','{name_all}','{name_have}','{money}'), 
					array($date_start,$date_end,$this->orders_id,date('m/d/Y'),$day_list,$name_all,$is_have,$money), 
					$html
			);
			return db_to_html($html);
		} else {
			throw new Exception('ģ���ļ��쳣������Ϊ��!���飡');
		}
	}
	/**
	 * ����Ƿ���ڷ��ͼ�¼
	 * @param string $guest_id
	 */
	function checkHave($guest_id) {
		$str_sql = 'select orders_product_eticket_guest_id from orders_product_eticket_guest where orders_products_id=' . $this->orders_products_id . ' and guest_id="' . $guest_id . '"';
		$sql_query = tep_db_query($str_sql);
		$row = tep_db_fetch_array($sql_query);
		return $row;
	}
	/**
	 * ͳ�����еĽ��
	 * @return float
	 */
	function getMoney(){
		foreach($this->guest as $value){
			$money+=$value['money'];
		}
		return $money;
	}
	/**
	 * ������뺯��Ϣ�����ݿ�
	 */
	function addInvitationToDb() {
		$inset_id = '';
		$send_time = date('Y-m-d H:i:s');
		foreach ( $this->guest as $key => $val ) {
			$data = array(
					'guest_id' => $key,
					'guest_name' => $val['guest_name'],
					'orders_products_id' => $this->orders_products_id,
					'guest_dob' => $val['dob'],
					'passport_number' => $val['passport_number'],
					'nationality' => $val['nationality'],
					'guest_gender' => $val['guest_gender'],
					'send_time' => $send_time,
					'money' => $val['money'],
					'is_send' => $val['is_send'],
					'guest_email' => $val['e_mail'],
					'guest_gender' => $val['guest_gender']
			);
			if ($need_id = $this->checkHave($key)) {
				
				$need_id_id = $need_id['orders_product_eticket_guest_id'];
				$where = ' orders_product_eticket_guest_id =' . $need_id_id;
				$action = 'update';
				$data = tep_db_prepare_input($data);
				tep_db_perform('orders_product_eticket_guest', $data, $action, $where);
				$inset_id .= ',' . $need_id_id;
			} else {
				
				$where = '';
				$action = 'insert';
				$data = tep_db_prepare_input($data);
				tep_db_perform('orders_product_eticket_guest', $data, $action, $where);
				$inset_id .= ',' . tep_db_insert_id();
			}
		}
		$inset_id = substr($inset_id, 1);
		$str_sql = 'update orders_product_eticket_guest set connet_id_str="' . $inset_id . '" where orders_product_eticket_guest_id in(' . $inset_id . ')';
		// echo $str_sql;
		tep_db_query($str_sql);
	}
	/**
	 * ǰ̨ҳ��ͨ���û��ʼ���orders_product_id��������Ӧ�����뺯��Ϣ
	 *
	 * @param int $opid	orders_product_id
	 * @param string $email	�û��ʼ�
	 */
	function getInvitation($opid, $email) {
		$str_sql = 'select connet_id_str from orders_product_eticket_guest where orders_products_id=' . ( int ) $opid . ' and guest_email="' . $email . '"';
		$sql_query = tep_db_query($str_sql);
		$rows = tep_db_fetch_array($sql_query);
		if ($rows) {
			$data = array();
			$str_sql = 'select * from orders_product_eticket_guest where orders_product_eticket_guest_id in(' . $rows['connet_id_str'] . ')';
			$sql_query = tep_db_query($str_sql);
			while ( $rows = tep_db_fetch_array($sql_query) ) {
				$this->guest[] = $rows;
			}
			return;
		} else
			return;
	}
	/**
	 * ��ȡһ���ͻ������뺯��Ϣ
	 * @param string $guest_name �ͻ�����
	 * @return multitype:
	 */
	function getOneInvitation($guest_id) {
		if (is_numeric($guest_id)) {
			$str_sql = 'select * from orders_product_eticket_guest where orders_products_id=' . $this->orders_products_id . ' and guest_id="' . $guest_id . '"';
			$sql_query = tep_db_query($str_sql);
			$row = tep_db_fetch_array($sql_query);
			return $row;
		}
	}
	/**
	 * ��̨���ؿͻ�����Ϣ�����ڴ����б�
	 * @return multitype:unknown multitype:unknown number  Ambigous <>
	 */
	function getGuestName() {
		$sql = "select `guest_name`,`guest_gender`,guest_email from `orders_product_eticket` where `orders_products_id`='" . $this->orders_products_id . "'";
		$result = tep_db_query($sql);
		while ( $row = tep_db_fetch_array($result) ) {
			$temp = explode('<::>', $row['guest_name']);
			$gender = explode('<::>', $row['guest_gender']);
			$email_arr = explode('<::>', $row['guest_email']);
			for($i = 0, $len = count($temp); $i < $len - 1; $i ++) {
				if (preg_match('/([^\[]+)\]/', $temp[$i], $matchs)) {
					//$this->guest[$i]['guest_name'] = $matchs[1];
					if ($row = $this->getOneInvitation($i)) {
						$rtn[] = array(
								'guest_id' => $row['guest_id'],
								'guest_name' => $row['guest_name'],
								'dob' => $row['guest_dob'],
								'passport_number' => $row['passport_number'],
								'nationality' => $row['nationality'],
								'is_send' => $row['is_send'],
								'money' => $row['money'],
								'sex' => $gender[$i],
								'e_mail' => empty($email_arr[$i]) ? $row['guest_email'] : $email_arr[$i] 
						);
					} else {
						$rtn[] = array(
								'guest_id' => $i,
								'guest_name' => $matchs[1],
								'e_mail' => $email_arr[$i] 
						);
					}
				}
				//$this->guest[$i]['guest_gender'] = $gender[$i];
			}
		}
		return $rtn;
	}
	/**
	 * �û���¼�鿴���뺯��ʱ�򴴽��ͻ���Ϣ
	 * @param string $guest_email �û������ַ
	 */
	function createGuest($guest_email) {
		$str_sql = "select connet_id_str from orders_product_eticket_guest where orders_products_id=" . $this->orders_products_id . ' and guest_email="' . $guest_email . '" order by send_time desc';
		//echo $str_sql;
		$sql_query = tep_db_query($str_sql);
		$row = tep_db_fetch_array($sql_query);
		if ($row) {
			$str_sql = 'select * from orders_product_eticket_guest where orders_product_eticket_guest_id in(' . $row['connet_id_str'] . ')';
			$sql_query = tep_db_query($str_sql);
			while($row=tep_db_fetch_array($sql_query)){
				$this->guest[$row['guest_id']]['guest_name'] = $row['guest_name'];
				$this->guest[$row['guest_id']]['guest_gender'] = $row['guest_gender'];
				$this->guest[$row['guest_id']]['dob'] = $row['guest_dob'];
				$this->guest[$row['guest_id']]['passport_number'] = $row['passport_number'];
				$this->guest[$row['guest_id']]['nationality'] = $row['nationality'];
				$this->guest[$row['guest_id']]['money'] = $row['money'];
				
			}
		}
	}
}
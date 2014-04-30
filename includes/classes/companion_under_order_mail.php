<?php 
/**
 * ���ͬ�η������µ���������˷��ʼ�
 * �����������֧�������ʼ�
 * @author lwkai 2012-06-11
 *
 */
class companion_under_order_mail extends send_mail_ready{

	/**
	 * ������������
	 * @var string
	 */
	private $order_info_content = '';
	/**
	 * ����ID��
	 * @var int
	 */
	private $order_id = 0;

	/**
	 * order �������
	 * @var Class order
	 */
	private $order = null;
	
	/**
	 * companions_personal_pay �������
	 * @var Class companions_personal_pay
	 */
	private $personal_pay = null;
	/**
	 * �¶������û�����
	 * @var string
	 */
	private $customer_name = '';

	/**
	 * eg:
	 * @param string|array $to_email_address ������һ�����߶����Ҫ���͵������ʺ�
	 * @param unknown_type $order_id ����ID��
	 * @param order $order order���ʵ��
	 * @param unknown_type $action_type
	 */
	public function __construct($to_email_address,$order_id,$order = null,$action_type = 'true'){
		parent::__construct();
		$this->action_type = $action_type;
		$this->order_id =  (int)$order_id;
		$this->order_info_content = $this->init($order);
		
		// ������۸����
		require_once DIR_FS_CLASSES . 'companions_personal_pay.php';
		$this->personal_pay = new companions_personal_pay($this->order_id);
		
		if (is_array($to_email_address) === true) {
			foreach($to_email_address as $person => $mail){
				$this->morePerson($mail, $person);
			}
		} else {
			$person_arr = explode(',',$to_email_address);
			foreach ($person_arr as $key => $mail){
				$person = $this->getCustomersName($mail);
				$this->morePerson($mail, $person);
			}
		}
	}
	
	/**
	 * �����û������ַ��ȡ�û�����
	 * @param string $mail
	 * @return string
	 */
	private function getCustomersName($mail){
		return tep_get_customer_name_from_email($mail);
	}
	
	
	/** 
	 * �Զ��˷����ʼ�
	 * @param unknown_type $email
	 * @param unknown_type $toPerson
	 */
	private function morePerson($email,$toPerson){

		$this->to_name = $toPerson;
		$this->to_email_address = $email;
		$this->init_mail();
		$this->add_session();
	}

	/**
	 * ����ʼ�
	 */
	private function init_mail(){
		$this->mail_subject = "���ķ����ͬ��--�ȴ����" . " ";
		$this->mail_content = '�𾴵ġ�' . $this->to_name . '�����ã�'."\n\n";
		$this->mail_content .= '�ǳ���л��Ԥ���������ķ�(Usitrip.com)�����β�Ʒ��' . "\n";
			
		$links = tep_href_link('orders_travel_companion_info.php','order_id=' . $this->order_id ,'SSL');
		$links = str_replace('/admin/','/',$links);
			
		$this->mail_content .= '������Ľ��ͬ�Σ������ˡ�' . $this->customer_name . '�������˶�����������������֧�����Ķ���������ķ��ڴ˶�����ȫ֧���ɹ���ᾡ��ȷ�϶�����' . "\n";
		$this->mail_content .= '<a href="'.$links.'" target="_blank">' . $links . '</a>ע���������򲻿����ӣ��븴�Ƹõ�ַ���������ַ���򿪡�' . "\n\n";

		$this->mail_content .= $this->order_info_content;
		
		// ��ȡ��ǰ�ռ�����Ҫ֧���Ŀ���
		$this->mail_content .= $this->personal_pay->getCustomersPay($this->to_email_address) . "\n";
		$this->mail_content .= '<span style="color:#f00">ע�������������С�����ã�</span>' . "\n";
		// ��ȡ��ǰ��������Ҫ����С�����ã����Ҳ���С���Ĺ����ˡ�����ÿ���ʼ��ﶼ�г��˵�ǰ����������С���ķ��á�
		$this->mail_content .= $this->personal_pay->getChildPay() . "\n";
		
		$this->mail_content .= $this->mail_separator . "\n";
		
		$this->mail_content .= "���ʼ�Ϊϵͳ�Զ�����������ֱ�ӻظ���\n\n";
		$this->mail_content .= $this->mail_foot . "\n\n";
	}

	// ������ȡ�ö������� �������ʼ��Ĳ���

	/**
	 * ��ʼ��  ���� order ��
	 * @return string
	 */
	private function init($order) {
		if (is_object($order)){
			$this->order = $order;
		} else {
			if($this->order_id > 0){
				if (class_exists('order') == false) {
					require_once DIR_FS_CLASSES . 'order.php';
				}
				$this->order = new order($this->order_id);
			}
		}
		$this->customer_name = $this->order->customer['name'];
		return $this->getString();
	}

	/**
	 * ȡ�ö�Ӧ������·����
	 * @return string
	 */
	private function get_line_details(){
		$temp = $this->order->products;
		$mail_string = '�����ţ�' . $this->order_id . "\n";
		//print_r($temp);
		$mail_string .= $this->mail_separator . "\n";
		for ($k = 0, $len = count($temp); $k < $len; $k++) {
			if ($temp[$k]['is_hotel'] != '1'){
				$mail_string .= '��·���ƣ�' . $temp[$k]['name'] . "\n";
				$mail_string .= '�����źţ�' . $temp[$k]['model'] . "\n";
				$mail_string .= '�������ڣ�' . date('Y-m-d',strtotime($temp[$k]['products_departure_date'])) . "\n";
			} else {
				$mail_string .= '�Ƶ����ƣ�' . $temp[$k]['name'] . "\n";
				$mail_string .= '�Ƶ��ţ�' . $temp[$k]['model'] . "\n";
				$mail_string .= '��ס���ڣ�' . date('Y-m-d',strtotime($temp[$k]['products_departure_date'])) . "\n";
				$mail_string .= '�˷����ڣ�' . date('Y-m-d',strtotime($temp[$k]['hotel_checkout_date'])) . "\n";
			}

			$mail_string .= $temp[$k]['products_room_info'] . "\n"; //������Ϣ
			// ���û�г����ص� �������ʱ��Ҳû��
			if (tep_not_null($temp[$k]['products_departure_location'])) {
				$dtime = explode(' ', $temp[$k]['products_departure_time']);   //����ʱ��
				$mail_string .= '�����ص㣺' . $dtime[1] . ' ' . $temp[$k]['products_departure_location'] . "\n";   //�����ص�
			}
			$mail_string .= "\n";
		}
		return $mail_string;
	}

	/**
	 * ȡ�ö�Ӧ�������ܼ۸�
	 * @return string
	 */
	private function get_total_price(){
		$temp = $this->order->totals;
		$mail_string = $this->mail_separator . "\n";
		foreach($temp as $key => $val) {
			$mail_string .= $val['title'] . $val['text'] . "\n";
		}
		return $mail_string;
	}

	/**
	 * ȡ�ö������г����ܼ���ϳ��ַ���������
	 * @return string
	 */
	public function getString() {
		$mail_string = '�������飺' . $this->orders_id . "&nbsp;&nbsp;��������ʹ��Ԥ��ʱע���Email��¼�����ʻ�����ѯ�������飩\n";
		$mail_string .= $this->get_line_details();
		$mail_string .= $this->get_total_price();

		return $mail_string;

	}
}

?>
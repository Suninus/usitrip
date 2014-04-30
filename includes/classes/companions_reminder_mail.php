<?php 
/**
 * ���ͬ�δ߿��ʼ� [�������ʼ��뷢�����ʼ�]
 * @author lwkai 2012-06-29
 *
 */
class companions_reminder_mail extends send_mail_ready{
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
	 * �����˵������ַ
	 * @var unknown_type
	 */
	private $customer_address = '';
	
	/**
	 * �û��Լ������Ա���
	 * @var string
	 */
	private $customers_char_set = 'gb2312';
	
	/**
	 * �����ʼ��˵�ID
	 * @var int
	 */
	private $customers_id = 0;
	
	/**
	 * ���ͬ�δ߿��ʼ���ȡ�������ʼ�
	 * @param int $customers_id �ս��ʼ����˵�ID
	 * @param int $orders_id ����ID
	 * @param int $type �߿��ʼ�����ȡ�������ʼ� 1 �߿� 2 ȡ��
	 * @param string $action_type 'true'|'false'
	 */
	public function __construct($customers_id,$orders_id,$type = 1,$action_type='true'){
		$this->travel_companion_email_switch = 'true';
		parent::__construct();
		$this->action_type = $action_type;
		$this->order_id =  (int)$orders_id;
		$this->customers_id = (int)$customers_id;
		$this->get_customers_info();
		switch ($type) {
			case 1: // ���ʹ߿��ʼ�
				$this->order_info_content = $this->init();
				if ($this->to_email_address == $this->customer_address) { // ������Լ����Լ� ���ʾ�Ƿ��������˵ģ���ʱ����Ҫ������һ���ʼ�����ʵ���ݶ�һ����ֻ�Ǻ�˭��鲻һ������
					//echo '$this->to_email_address=' . $this->to_email_address . '<br/>$this->from_email_address' . $this->customer_address . '<br/>';
					$this->customer_name = join(',',$this->get_together_name());
					//return ;
				}
				// ������۸����
				require_once DIR_FS_CATALOG . 'includes' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'companions_personal_pay.php';
				$this->personal_pay = new companions_personal_pay($this->order_id);
				
				$this->init_mail();
				break;
			case 2:
				$this->init(false);
				if ($this->to_email_address == $this->customer_address) { // ������Լ����Լ� ���ʾ�Ƿ��������˵ģ���ʱ����Ҫ������һ���ʼ�����ʵ���ݶ�һ����ֻ�Ǻ�˭��鲻һ������
					//echo '$this->to_email_address=' . $this->to_email_address . '<br/>$this->from_email_address' . $this->customer_address . '<br/>';
					$this->customer_name = join(',',$this->get_together_name());
					//return ;
				}
				$this->cancel_mail();
				break;
			default:
				return;
		}

		$this->send_mail();
	}
	
	/**
	 * ȡ�������ʼ�����
	 */
	private function cancel_mail(){
		$this->mail_subject = "���ķ����ͬ��--����ȡ��" . " ";#�����ţ�" . $this->order_id . "����:" . date('Y-m-d H:i:s') . " ";
		$this->mail_content = '�𾴵ġ�' . $this->to_name . '�����ã�'."\n\n";
		$this->mail_content .= '�ǳ���л��Ԥ���������ķ�(Usitrip.com)�����β�Ʒ��' . "\n";
			
		$links = tep_href_link('orders_travel_companion_info.php','order_id=' . $this->order_id);
		$links = str_replace('/admin/','/',$links);
			
		$this->mail_content .= '���͡�' . $this->customer_name . '���Ľ��ͬ�ζ���[�����ţ�' . $this->order_id . ']';
		$this->mail_content .= '����һֱδ�յ�ȫ����������ѱ��Զ�ȡ����' . "\n";
		$lines = $this->get_products_name_url();
		foreach ($lines as $key => $val) {
			$this->mail_content .= '��·�ǣ�<a href="' . str_replace('/admin/','/',tep_href_link($val['products_urlname']) . '.html') . '" target="_blank">' . $val['products_name'] . '</a>' . "\n";
		}
		$this->mail_content .= '��������Ҫ�����г̣������������ķ�<a href="http://208.109.123.18/" target="_blank">208.109.123.18</a>��ѡ�񶩹�����������������ʱ��ϵ���ķ��ͷ���Ա��лл��' . "\n";
		$this->mail_content .= '������Ӳ鿴��ȡ���Ķ���<a href="'.$links.'" target="_blank">' . $links . '</a>����ע���������򲻿����ӣ��븴�Ƹõ�ַ���������ַ���򿪡���' . "\n\n";
		

		$this->mail_content .= "���ʼ�Ϊϵͳ�Զ�����������ֱ�ӻظ���\n\n";
		$this->mail_content .= $this->mail_foot . "\n\n";
	}

	/**
	 * ���ݶ�����ƷIDȡ����·������URL
	 * @return array
	 */
	private function get_products_name_url(){
		$sql = tep_db_query("select products_id from orders_travel_companion where orders_id='" . $this->order_id . "'");
		while($rows = tep_db_fetch_array($sql)){
			$products_id[]=$rows['products_id'];
		}
		$products_id = join(',',$products_id);
		if ( ! $products_id) $products_id = '0';
		$sql = tep_db_query("select p.products_urlname,pd.products_name from products as p,products_description as pd where p.products_id=pd.products_id and p.products_id in (" . $products_id . ") and p.is_hotel=0");
		$rtn = array();
		while($rows = tep_db_fetch_array($sql)) {
			$rtn[] = $rows;
		}
		return $rtn;
		
	}
	
	/**
	 * �߿��ʼ�����
	 */
	private function init_mail(){
		$this->mail_subject = "���ķ����ͬ��--�뼰ʱ����" . " ";#�����ţ�" . $this->order_id . "����:" . date('Y-m-d H:i:s') . " ";
		$this->mail_content = '�𾴵ġ�' . $this->to_name . '�����ã�'."\n\n";
		$this->mail_content .= '�ǳ���л��Ԥ���������ķ�(Usitrip.com)�����β�Ʒ��' . "\n";
			
		$links = tep_href_link('orders_travel_companion.php','order_id=' . $this->order_id);
		$links = str_replace('/admin/','/',$links);
			
		$this->mail_content .= '���͡�' . $this->customer_name . '���Ľ��ͬ�ζ���';
		$this->mail_content .= '<a href="'.$links.'" target="_blank">' . $links . '</a>,���һֱδ֧������������ȥ֧���������Ѿ�֧���ɹ���������ϵ���ķ������ͷ���Ա����ע���������򲻿����ӣ��븴�Ƹõ�ַ���������ַ���򿪡���' . "\n\n";
	
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
	
	/**
	 * �����ʼ�
	 */
	private function send_mail(){
		//if (in_array($this->to_email_address, array('2683692314@qq.com','1804690595@qq.com','1773247305@.qq.com'))){
		//echo $this->to_name . '<br/>';
		//echo $this->to_email_address . '<br/>';
		tep_mail(
			iconv(CHARSET,$this->customers_char_set.'//IGNORE',$this->to_name), 
			$this->to_email_address, 
			iconv(CHARSET,$this->customers_char_set.'//IGNORE',$this->mail_subject), 
			iconv(CHARSET,$this->customers_char_set.'//IGNORE',$this->mail_content), 
			iconv(CHARSET,$this->customers_char_set.'//IGNORE',$this->from_email_name), 
			$this->from_email_address, 
			'true', 
			$this->customers_char_set);
		//}
	}
	
	/**
	 * ���ݵ�ǰ�û�ID ȡ���ռ��˵������������ַ���û�ϰ�ߵı���
	 */
	private function get_customers_info(){
		$customers = tep_db_query("select customers_firstname, customers_email_address,customers_char_set from customers where customers_id = '" . (int)$this->customers_id . "'");
		$data = tep_db_fetch_array($customers);
		if (count($data) > 0) {
			$this->to_name = $data['customers_firstname'];
			$this->to_email_address = $data['customers_email_address'];
			if(tep_not_null($data['customers_char_set']) == true){
				$this->customers_char_set = $data['customers_char_set'];
			}
		}
	}
	
	/**
	 * �����ռ����û�ID��ȡ����ߵ��û�����
	 */
	private function get_together_name(){
		$sql = tep_db_query("select guest_name from orders_travel_companion where orders_id='" . $this->order_id . "' and customers_id <> '" . $this->customers_id . "' and is_child <> 'true' group by customers_id");
		$rtn = array();
		while ($temp = tep_db_fetch_array($sql)) {
			if (preg_match("/[^\[]+\[([^\]]+)/", $temp['guest_name'],$matchs)) {
				$rtn[] = $matchs[1];
			}
		}
		return $rtn;
	}
	
	// ������ȡ�ö������� �������ʼ��Ĳ���
	
	/**
	 * ��ʼ��  ���� order ��
	 * @param boolean $return �Ƿ��з��ض����������� Ĭ���Ƿ���
	 * @return string
	 */
	private function init($return = true) {
			if($this->order_id > 0){
				if (class_exists('order') == false) {
					require_once DIR_FS_CATALOG . 'includes' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'order.php';
				}
				$this->order = new order($this->order_id);
			}

		$this->customer_name = $this->order->customer['name'];
		$this->customer_address = $this->order->customer['email_address'];
		if ($return == true) {
			return $this->getString();
		}
	}
	
	/**
	 * ȡ�ö�Ӧ������·����
	 * @return string
	 */
	private function get_line_details(){
		$temp = $this->order->products;
		$mail_string = '';
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
		$mail_string = '�������飺������[' . $this->order_id . "]&nbsp;&nbsp;��������ʹ��Ԥ��ʱע���Email��¼�����ʻ�����ѯ�������飩\n";
		$mail_string .= $this->get_line_details();
		$mail_string .= $this->get_total_price();
	
		return $mail_string;
	
	}
}
?>
<?php 
/**
 * ������ͬ�ν���ʼ�
 * @author lwkai 2012-6-28
 *
 */
class result_application_companion_mail extends companion_mail{
	/**
	 * ���ͬ�η���������
	 * @var string
	 */
	private $sponsor_name = '';
	
	/**
	 * ���ͬ�η������Ա�
	 * @var string
	 */
	private $sponsor_gender = '';
	
	/**
	 * ���ͬ�η����������ַ
	 * @var string
	 */
	private $sponsor_email = '';
	
	/**
	 * ���ͬ�η����˵绰
	 * @var string
	 */
	private $sponsor_tel = '';
	
	/**
	 * ���ͬ����������
	 * @var int
	 */
	private $sponsor_people = 0;
	
	/**
	 * ���ͬ�θ��˱�ע
	 * @var string
	 */
	private $sponsor_message = '';
	
	/**
	 * ȡ��ͨ��������ʱ��������
	 * @var unknown_type
	 */
	private $canceled_message = '';
	
	/**
	 * �����¼��ID��
	 * @var int
	 */
	private $tca_id = 0;
	
	/**
	 * ͬ�⡢�ܾ���ȡ�� ���ͬ������
	 * status ֻ���� agree,refuse,canceled
	 * @param int $tca_id �����¼ID
	 * @param string $status ������״̬[agree ͬ�� ��refuse �ܾ���canceled ȡ��]
	 */
	public function __construct($tca_id,$status){
		$this->tca_id = $tca_id;
		$this->get_customers_info();
		$this->get_companion_user_info();
		$this->get_products_info();
		switch($status){
			case 'agree':
				$this->agree_mail();
				break;
			case 'refuse':
				$this->refuse_mail();
				break;
			case 'canceled':
				$this->canceled_mail();
				break;
			default:
				return;
				break;
		}
		$this->travel_companion_email_switch = 'true';
		parent::__construct();
		$this->add_session();
	}
	/**
	 * ͬ�������ʼ�
	 */
	private function agree_mail(){
		$this->mail_subject = '���ķ����ͬ�Ρ�����ͨ�� ';
		$this->mail_content = '�𾴵� ' . $this->to_name . "\n";
		$tTcPath = tep_get_category_patch($this->categories_id);
		$this->mail_content .= '��ϲ������ ��' . $this->sponsor_name . '����������Ϊ ��' . $this->companion_title . '���Ľ��ͬ��,������ͨ����' .
				'��·�ǣ�<a href="' . tep_href_link($this->products_urlname) . '" target="_blank">' . $this->products_name . '</a>' . "\n" .
				'������Ӳ鿴<a href="' . tep_href_link('my_travel_companion.php','action=my_applied') . '" target="_blank">' . tep_href_link('my_travel_companion.php','action=my_applied') .
				'</a> ע���������򲻿����븴�Ƹ����ӵ��������ַ���򿪡�' . "\n\n";
		
		$this->mail_content .= $this->mail_separator . "\n";
		$this->mail_content .= '�����˵��������£�'."\n";
		$this->mail_content .= '������' . $this->sponsor_name . "\n";
		$this->mail_content .= '�Ա�' . $this->sponsor_gender . "\n";
		$this->mail_content .= '�������䣺' . $this->sponsor_email . "\n";
		$this->mail_content .= '�绰��' . $this->sponsor_tel . "\n";
		$this->mail_content .= '������' . $this->sponsor_people . "\n";
		$this->mail_content .= '�������ݣ�' . $this->sponsor_message . "\n";
		$this->mail_content .= $this->mail_separator . "\n\n";
		$this->mail_content .= $this->mail_foot;
	}
	
	/**
	 * �ܾ������ʼ�
	 */
	private function refuse_mail(){
		$this->mail_subject = '���ķ����ͬ�Ρ�����δͨ�� ';
		$this->mail_content = '�𾴵� ' . $this->to_name . "\n";
		$tTcPath = tep_get_category_patch($this->categories_id);
		$this->mail_content .= '���ź������� ��' . $this->sponsor_name . '����������Ϊ ��' . $this->companion_title . '���Ľ��ͬ��,δ���Է��Ӱ����߶Է��Ѿ�����ͬ���ߡ�' . "\n" .
				'���ķ���������������ͬ����Ϣ���������з���һ��,'.
				'��·�ǣ�<a href="' . tep_href_link($this->products_urlname) . '" target="_blank">' . $this->products_name . '</a>' . "�Ľ��ͬ���� ��\n" .
				'������Ӳ鿴<a href="' . tep_href_link('my_travel_companion.php','action=my_applied') . '" target="_blank">' . tep_href_link('my_travel_companion.php','action=my_applied') .
				'</a> ע���������򲻿����븴�Ƹ����ӵ��������ַ���򿪡�' . "\n\n";
		
		$this->mail_content .= $this->mail_separator . "\n\n";
		$this->mail_content .= $this->mail_foot;
	}
	
	/**
	 * ȡ��ͬ���ʼ�
	 */
	private function canceled_mail(){
		$this->mail_subject = '���ķ����ͬ�Ρ����뱻ȡ�� ';
		$this->mail_content = '�𾴵� ' . $this->to_name . "\n";
		$tTcPath = tep_get_category_patch($this->categories_id);
		$this->mail_content .= '�ܱ�Ǹ������ ��' . $this->sponsor_name . '����������Ϊ ��' . $this->companion_title . '���Ľ��ͬ��,���뱻ȡ��ͨ����' .
				'���ķ���������������ͬ����Ϣ���������з���һ������·�ǣ�<a href="' . tep_href_link($this->products_urlname) . '" target="_blank">' . $this->products_name . '</a>�Ľ��ͬ������' . "\n" .
				'������Ӳ鿴<a href="' . tep_href_link('my_travel_companion.php','action=my_applied') . '" target="_blank">' . tep_href_link('my_travel_companion.php','action=my_applied') .
				'</a> ע���������򲻿����븴�Ƹ����ӵ��������ַ���򿪡�' . "\n\n";
		
		$this->mail_content .= $this->mail_separator . "\n";
		$this->mail_content .= '�����˸����������������£�'."\n";
		$this->mail_content .= $this->canceled_message . "\n";
		$this->mail_content .= $this->mail_separator . "\n\n";
		$this->mail_content .= $this->mail_foot;
	}
	
	/**
	 * ��д���෽��  ��ȡ�����˵������Ϣ
	 * (non-PHPdoc)
	 * @see companion_mail::get_companion_user_info()
	 */
	protected function get_companion_user_info(){
		//print_r('SELECT customers_id,customers_name,email_address,categories_id,t_companion_title FROM `travel_companion` WHERE t_companion_id="' . $this->companion_id . '" Limit 1 ');
		$mail_sql = tep_db_query('SELECT customers_id,t_gender,customers_phone,now_people_man,personal_introduction,customers_name,email_address,categories_id,t_companion_title,products_id FROM `travel_companion` WHERE t_companion_id="' . $this->companion_id . '" Limit 1 ');
		$mail_row = tep_db_fetch_array($mail_sql);
		$this->customers_id = $mail_row['customers_id'];
		$this->sponsor_name = strip_tags($mail_row['customers_name']) . " ";
		$this->sponsor_email = strip_tags($mail_row['email_address']);
		$this->sponsor_people = ($mail_row['now_people_man'] + $this->get_agree_application());
		$this->sponsor_message = $mail_row['personal_introduction'];
		$this->categories_id = $mail_row['categories_id'];
		$this->companion_title = $mail_row['t_companion_title'];
		$this->products_id = $mail_row['products_id'];
		switch($mail_row['t_gender']){
			case '1':
				$this->sponsor_gender = '��ʿ';
				break;
			case '2':
				$this->sponsor_gender = 'Ůʿ';
				break;
			default:
				$this->sponsor_gender = 'δ֪';
				break;
		}
	}
	
	/**
	 * ���������¼IDȡ����������Ϣ
	 * ��������
	 * ������ID
	 * �����ַ
	 * ͨ���������ȡ��ʱ������
	 */
	private function get_customers_info(){
		$sql = tep_db_query("select tca_cn_name,t_companion_id,tca_email_address,verify_status_sms from travel_companion_application where tca_id='" . $this->tca_id . "'");
		$temp = tep_db_fetch_array($sql);
		$this->to_name = $temp['tca_cn_name'];
		$this->companion_id = $temp['t_companion_id'];
		$this->to_email_address = $temp['tca_email_address'];
		$message = explode(':',$temp['verify_status_sms']);
		$this->canceled_message = $message[1];
	}
	
	/**
	 * ȡ���Ѿ�ͬ�����������
	 * @return int
	 */
	private function get_agree_application(){
		$sql = tep_db_query("select count(tca_id) as t from travel_companion_application where t_companion_id='" . $this->companion_id . "' and tca_verify_status = 1");
		$temp = tep_db_fetch_array($sql);
		return $temp['t'];
	}
}
?>
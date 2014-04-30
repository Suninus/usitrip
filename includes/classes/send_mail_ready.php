<?php 
/**
 * ���ʼ�����ã�����SESSION׼������
 * ���AJAX������ ����ֻ����SESSION �������������ķ���
 * @author lwkai 2012-06-11
 *
 */
abstract class send_mail_ready{

	/**
	 * �ռ�������
	 * @var string
	 */
	protected $to_name = '';

	/**
	 * �ռ��������ַ
	 * @var string
	 */
	protected $to_email_address = '';

	/**
	 * �ʼ�����
	 * @var string
	 */
	protected $mail_subject = '';

	/**
	 * �ʼ�����
	 * @var string
	 */
	protected $mail_content = '';

	/**
	 * �ʼ���˭�����巢��
	 * @var string
	 */
	protected $from_email_name = '';

	/**
	 * �����ʼ��������ַ
	 * @var string
	 */
	protected $from_email_address = '';

	/**
	 * �ʼ��ָ���
	 * @var unknown_type
	 */
	protected $mail_separator = EMAIL_SEPARATOR;

	/**
	 * �ʼ�ҳ�Ź�����Ϣ
	 * @var string
	 */
	protected $mail_foot = CONFORMATION_EMAIL_FOOTER;

	/**
	 * �ʼ��Դ��ı����ͻ���HTML true ��ʾhtml�ʼ�
	 * @var string 'true|false'
	 */
	protected $action_type = 'true';

	/**
	 * ���캯�� ��ʼ�� ���������뷢�������ַ
	 */
	public function __construct(){
		$this->from_email_name = (defined("STORE_OWNER") ? STORE_OWNER : '');
		$this->from_email_address = (defined("STORE_OWNER_EMAIL_ADDRESS") ? STORE_OWNER_EMAIL_ADDRESS : '');
	}

	/**
	 * ��ӽ�SESSION �Դ�����
	 */
	protected function add_session(){
		$a_i = count($_SESSION['need_send_email']);
		

		$_SESSION['need_send_email'][$a_i]['to_name'] = db_to_html($this->to_name);
		
		$_SESSION['need_send_email'][$a_i]['to_email_address'] = $this->to_email_address;
		
		$_SESSION['need_send_email'][$a_i]['email_subject'] = db_to_html($this->mail_subject);

		$_SESSION['need_send_email'][$a_i]['email_text'] = db_to_html($this->mail_content);
		
		$_SESSION['need_send_email'][$a_i]['from_email_name'] = db_to_html($this->from_email_name);
		
		$_SESSION['need_send_email'][$a_i]['from_email_address'] = $this->from_email_address;
		
		$_SESSION['need_send_email'][$a_i]['action_type'] = $this->action_type;

		/*$string = '';
		$string .= 'to_name:' . $this->to_name . "\n";
		$string .= 'to_email_address:' . $this->to_email_address . "\n";
		$string .= 'email_subject:' . $this->mail_subject . "\n";
		$string .= 'email_text:' . $this->mail_content . "\n";
		$string .= 'from_email_name:' . $this->from_email_name . "\n";
		$string .= 'from_email_name:' . $this->from_email_name . "\n";
		$string .= 'from_email_address:' . $this->from_email_address . "\n";
		
		$string .= 'action_type:' . $this->action_type . "\n";
		$this->save_to_file($string);*/
		
	}
	
	private function save_to_file($somecontent = ''){
		$filename = DIR_FS_CATALOG . 'test.txt';
		$somecontent .= file_get_contents($filename);
		file_put_contents($filename,$somecontent);
		
	}
}
?>
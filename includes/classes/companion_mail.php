<?php 
/**
 * ���ͬ�λ����� �벻Ҫֱ��ʵ����
 * @author lwkai 2012-06-11
 *
 */
class companion_mail extends send_mail_ready {
	/**
	 * ���ͬ�η�����ID
	 * @var int
	 */
	protected $companion_id = 0;

	/**
	 * ���ͬ�η�����ID
	 * @var int
	 */
	protected $customers_id = 0;

	/**
	 * ������ĿID
	 * @var int
	 */
	protected $categories_id = 0;

	/**
	 * ���ͬ�α���
	 * @var string
	 */
	protected $companion_title = '';

	/**
	 * �����ʼ����� Ĭ���ǹرշ����ʼ��ġ�
	 * @var string 'true|false'
	 */
	protected $travel_companion_email_switch = 'false';

	/**
	 * ��ƷID
	 * @var int
	 */
	protected $products_id = 0;
	
	/**
	 * ��Ʒҳ������ ��.html
	 * @var string
	 */
	protected $products_urlname = '';
	
	/**
	 * ��Ʒ���Ʊ���
	 * @var string
	 */
	protected $products_name = '';
	
	/**
	 * ���캯��
	 */
	public function __construct(){
		if ($this->travel_companion_email_switch == 'true') {
			parent::__construct();
		}
	}
	
	protected function add_session(){
		if ($this->travel_companion_email_switch == 'true') {
			parent::add_session();
		}
	}

	/**
	 * ȡ�ý��ͬ�η����˵������Ϣ
	 */
	protected function get_companion_user_info(){
		//print_r('SELECT customers_id,customers_name,email_address,categories_id,t_companion_title FROM `travel_companion` WHERE t_companion_id="' . $this->companion_id . '" Limit 1 ');
		$mail_sql = tep_db_query('SELECT customers_id,customers_name,email_address,categories_id,t_companion_title,products_id FROM `travel_companion` WHERE t_companion_id="' . $this->companion_id . '" Limit 1 ');
		$mail_row = tep_db_fetch_array($mail_sql);
		$this->customers_id = $mail_row['customers_id'];
		$this->to_name = strip_tags($mail_row['customers_name']) . " ";
		$this->to_email_address = strip_tags($mail_row['email_address']);
		$this->categories_id = $mail_row['categories_id'];
		$this->companion_title = $mail_row['t_companion_title'];
		$this->products_id = $mail_row['products_id'];
	}
	
	/**
	 * ȡ�ö�Ӧ��Ʒ������URLҳ���ַ
	 * @param int $products_id ��ƷID
	 */
	protected function get_products_info($products_id = 0){
		if ((int)$products_id == 0) {
			$products_id = $this->products_id;
		}
		if($products_id > 0) {
			/* ȡ�ý��ͬ��������·�����ƺ�URL��ַ */
			$sql = tep_db_query("select p.products_urlname,pd.products_name from products as p,products_description as pd where p.products_id=pd.products_id and p.products_id='" . $products_id . "'");
			if (tep_db_num_rows($sql) > 0) {
				$product_row = tep_db_fetch_array($sql);
				$this->products_urlname = $product_row['products_urlname'] . '.html';
				$this->products_name = $product_row['products_name'];
			}
		}
		
	}
}

?>

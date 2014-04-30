<?php 
/**
 * SMTP �����ʼ��� ������������smtp֧��
 * ��������WORD�ĵ�Ҳ���á�
 * @version 1.0
 * @author lwkai 2012-07-23 e-mail:1275124829@163.com
 * @package
 * @example
 * $mail = new mail_send_smtp();
 * $mail->set_from_address('27310221@usitrip.com');
 * $mail->set_from_name('���ķ�');
 * $mail->set_subject('�ʼ����⣭�������ʼ�');
 * $mail->set_charset('gb2312');
 * $mail->set_to_name('���Ŀ�');
 * $mail->set_to_address('2683692314@qq.com');
 * $mail->set_copy_to(array('1773247305@qq.com'=>'�ܺ���','643614934@qq.com'=>'������'));//����
 * $mail->set_mail_type('html');
 * $mail->set_body('<html><head><title>�����ʼ�</title></head><body><p style="font-size:30px;color:#FF0000;">����һ������ʼ�</p></body></html>');//�����ʼ�����
 * $ds = dirname(__FILE__) . DIRECTORY_SEPARATOR;
 * $mail->set_file(array($ds . 'http_imgload.jpg', $ds . 'keep_02.png'));//�����ʼ�����
 * $temp = $mail->combination_of_email(true); //����ʼ����������send_mail�������˷������Բ����ֶ����ã�ֱ��send_mail
 * $temp = $mail->get_word_content();//���ʼ����֮�󣬻�ȡ���������԰ѷ��ص����ݱ���Ϊ DOC �ĵ������û����أ�������Ϊ������ע��ֻ���� OFFICE �򿪡�WPS�򿪻ᱨ��
 * $mail->send_mail();//�����ʼ�
 *
 */
class mail_send_smtp{
	
	/**
	 * �ʼ����� ���ı��ʼ�����HTML�ʼ�
	 * @var string $mail_type text����html
	 */
	private $mail_type = 'text/plain';
	
	/**
	 * �ʼ���������
	 * array(array('charset'=>'���ֱ���','body'=>'��������')[,array('charset'=>'���ֱ���','body'=>'��������')[,...]])
	 * @var array $mail_body �ʼ�����
	 */
	private $mail_body = array();
	
	/**
	 * ����֮�󣬵ȴ����͵��ʼ����ģ�Ҳ����˵�Ǵ��������������ݡ�
	 * �������ʼ����ͣ�Ҳ�����ڱ���ΪDOC��һ���֡�
	 * @var string
	 */
	protected  $send_body = '';
	
	/**
	 * �ʼ���������
	 * @var array 
	 */
	private $mail_files = array();
	
	/**
	 * �����ߵ�����
	 * @var string 
	 */
	private $mail_to_name = '';
	
	/**
	 * �����ߵ������ַ
	 * @var string
	 */
	private $mail_to_address = '';
	
	/**
	 * �ʼ����͵�Ŀ���ַ
	 * @var string | array
	 */
	private $mail_copy_to = '';
	
	/**
	 * �ʼ����͵�Ŀ���ַ
	 */
	private $mail_bcc_to = '';
	
	/**
	 * �ʼ����ͷ�����
	 * @var string 
	 */
	private $mail_from_name = '';
	
	/**
	 * �ʼ����ͷ��������ַ
	 * @var string
	 */
	private $mail_from_address = '';
	
	/**
	 * �ʼ����ŵ�ַ
	 *
	 * @var string
	 */
	private $mail_return_address = '';
	
	/**
	 * �ʼ���Ϣͷ
	 *
	 * @var array
	 */
	protected $mail_header = array();
	
	/**
	 * �ʼ�����
	 * array('charset'=>'��������ֱ���','subject'=>'�������������');
	 * @var array
	 */
	protected $mail_subject = array();
	
	/**
	 * �ʼ����ı���
	 */
	protected $mail_charset = 'gb2312';
	
	/**
	 * �ʼ����ͳ�ȥ�ı��� �Թ����� �����ڼ��� gbk ���
	 * @var string
	 */
	protected $mail_to_charset = 'gbk';
	
	/**
	 * �ʼ�������ʲô���ܷ�ʽ���з���
	 * @var string
	 */
	protected $mail_body_encode = 'base64';
	
	/**
	 * �����Ҫ��HTML�е�ͼƬ���ݸ������ʼ��У�������ΪTRUE
	 * @var boolean
	 */	
	private $img_to_mail = false;
	
	private $sub_boundary = '';
	
	private $boundary = '';
	/**
	 * ����ʼ�������HTML�ģ�����ͼƬ��Ҫ�������ʼ���һ�����ͣ������������˿���
	 * @var unknown_type
	 */
	private $image_types = array(
		'gif'  => 'image/gif',
		'jpg'  => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'jpe'  => 'image/jpeg',
		'bmp'  => 'image/bmp',
		'png'  => 'image/png',
		'tif'  => 'image/tiff',
		'tiff' => 'image/tiff',
		'swf'  => 'application/x-shockwave-flash'
	);
	
	/**
	 * �����Ҫ��HTML�е�ͼƬ�������ʼ���һ�����ͣ�
	 * ����Ҫ����ͼƬ��ӦHTML�����е�ǰ׺���Ա�֤ͼƬ·����ȷ
	 * @var string
	 */
	private $images_dir = '';
	
	/**
	 * SMTP �����ʼ���ʼ��
	 *
	 * @param string $to_address	�����˵������ַ
	 * @param string $to_name		�����˵�����
	 * @param string $from_address	�����˵������ַ
	 * @param string $from_name		�����˵�����
	 * @param string $subject		���͵��ʼ�����
	 * @param string $body			���͵��ʼ�����
	 * @param string $charset		�ʼ����ֵı���
	 * @param string $emailType		���͵��ʼ���������[html/text]
	 */
	public function __construct($to_address = '', $to_name = '', $from_address = '', $from_name = '', $subject = '', $body = '', $charset='gb2312', $emailType = 'text'){
		$this->set_to_address($to_address);
		$this->set_to_name($to_name);
		$this->set_from_address($from_address);
		$this->set_from_name($from_name);
		$this->set_subject($subject);
		$this->set_body($body);
		$this->set_charset($charset);
		$this->set_mail_type($emailType);
		$this->mail_header[] = "MIME-Version:1.0";
	}
	
	/**
	 * �����ʼ���������
	 *
	 * @param string $type html/text
	 */
	public function set_mail_type($type){
		$type = strtolower($type);
		switch ($type) {
			case 'html':
				$this->mail_type = 'text/html';
				break;
			default:
				$this->mail_type = 'text/plain';
				break;
		}
	}
	
	/**
	 * �����ʼ����ͳ�ȥ�ı��룬Ĭ����GBK
	 */
	public function set_out_email_charset($charset){
		if (!empty($charset)) {
			$this->mail_to_charset = $charset;
		}
	}
	
	/**
	 * �����ʼ����ֱ���
	 *
	 * @param string $charset
	 */
	public function set_charset($charset){
		$this->mail_charset = $charset;
	}
	
	/**
	 * �����ռ��˵������ַ
	 *
	 * @param string $address
	 */
	public function set_to_address($address){
		if (empty($address) == false) {
			$this->mail_to_address = $address;
		}
	}
	
	/**
	 * �����ռ�������
	 *
	 * @param string $name
	 */
	public function set_to_name($name){
		if (empty($name) == false) {
			$this->mail_to_name = $name;
		}
	}
	
	/**
	 * �����ʼ�������
	 * @param array|string $copyto ���͸�ĳĳĳ
	 * @example 
	 * 		set_copy_to(array('123456@qq.com' => '������','55555@163.com' => '������'));
	 * @example 
	 *      set_copy_to('123456@qq.com');
	 */
	public function set_copy_to($copyto){
		$this->mail_copy_to = $copyto;
	}
	
	/**
	 * �����ʼ������� ���ʼ�������ʾ�����ռ��˵�������
	 * @param array|string $bcc_to ���͸�ĳĳĳ  
	 * @example
	 * 		set_bcc_to(array('123456@qq.com' => '������','55555@163.com' => '������'));
	 * @example
	 *      set_bcc_to('123456@qq.com');
	 */	
	public function set_bcc_to($bcc_to) {
		if (is_array($bcc_to)) {
			foreach($bcc_to as $mail => $name) {
				if (is_numeric($mail)) {
					$this->mail_bcc_to[$name] = $mail;
				} else {
					$this->mail_bcc_to[$mail] = $name;
				}
			}
		} else {
			$this->mail_bcc_to[$bcc_to] = '';
		}
	}
	
	/**
	 * �����ʼ����ĵı��뷽ʽ
	 * base64 | quoted-printable �� 7bit
	 * @param string $encode
	 */
	public function set_body_encode($encode){
		if (!empty($encode)) {
			$this->mail_body_encode = $encode;
		}
	}
	
	/**
	 * ���÷���������
	 * 
	 * @param string $address �����������ַ
	 */
	public function set_from_address($address) {
		if (empty($address) == false) {
			$this->mail_from_address = $address;
		}
	}
	
	/**
	 * ���÷���������
	 *
	 * @param string $name ����������
	 */
	public function set_from_name($name){
		if (empty($name) == false) {
			$this->mail_from_name = $name;
		}
	}
	
	/**
	 * �������ŵ�ַ
	 *
	 * @param string $address
	 */
	public function set_return_address($address){
		if (empty($address) == false) {
			$this->mail_return_address = $address;
		}
	}
	
	/**
	 * �����ʼ�����
	 *
	 * @param string $subject
	 * @param string  $charset
	 */
	public function set_subject($subject,$charset='') {
		if (empty($subject) == false) {
			if(IS_LIVE_SITES!=true){
				$subject = "�ʼ����� - " . $subject;
			}
			$this->mail_subject = array('subject' => $subject,'charset' => $charset);
		}
	}
	
	/**
	 * ����ʼ��������ݣ��ɵ��ö���ۼ���������
	 * 
	 *
	 * @param string $body �ʼ�����
	 * @param string $charset �ʼ����ĵ����ֱ���,��������ã�����֮ǰ���õı��룬���û���ã���Ĭ����gb2312
	 */
	public function set_body($body, $charset = ''){
		if (empty($body) == false) {
			$this->mail_body[] = array('charset' => $charset, 'body' => $body);
		}
	}
	
	/**
	 * �����ʼ���ͷ
	 *
	 * @param string|array $header
	 */
	public function set_header($header){
		if (is_array($header) == true) {
			foreach ($header as $val) {
				$this->mail_header[] = $val;
			}
		} else {
			$this->mail_header[] = $header;
		}
	}
	
	/**
	 * ����HTML�е�ͼƬ����λ�ã����HTML�е�����·����
	 * ���������ͼƬ���е�ַ
	 * @param string $dir
	 */
	public function set_image_dir($dir){
		if (!empty($dir)) {
			$this->images_dir = $dir;
		}
	}
	
	public function get_headers(){
		return $this->mail_header;
	}
	
	/**
	 * ������չ�������ض�Ӧ���ļ�����
	 *
	 * @param string $type �ļ���չ��
	 * @return string
	 */
	private function get_type($type){
		$rtn = '';
		if (isset($this->image_types[$type]) && $this->image_types[$type] != '') {
			$rtn = $this->image_types[$type];
		} else {
			$rtn = 'application/unknown';
		}
		return $rtn;
	}
	
	/**
	 * ��ȡ�ļ�����
	 * @param string $file ��Ҫ��ȡ���ļ���ַ
	 * @param string $content_id_name �����������Ҫ��ʾ��ͼƬ���������ͼƬ������Ҫ�������ʼ��У��������ļ���������
	 */
	private function read_file($file,$content_id_name = '') {
		if (file_exists($file) == true) {
			$file_content = file_get_contents($file);
			//$name = substr($file,strrpos($file,DIRECTORY_SEPARATOR) + 1);
			$name = basename($file);
			$ext = substr($name,strrpos($name,'.') + 1);
			$type = $this->get_type($ext);
			$this->set_file_content($file_content, $name, $type, $content_id_name);
		}
	}
	
	/**
	 * ֱ�����ø�������ֱ�Ӵ��������ݵķ�ʽ�����Ǵ��ļ�
	 * @param string $file_content �����ļ�����
	 * @param string $name �����ļ���
	 * @param string $type �������� 
	 * @param string $content_id_name ����Ǹ������ʼ������е�ͼƬ����SWF������Ҫָ����ID��
	 */
	public function set_file_content($file_content,$name,$type,$content_id_name = ''){
		if ($file_content != '' && $name != '' && $type != '') {
			if ($file_content) {
				//$len = count($this->mail_files);
				$this->mail_files[$name] = array(
						'content' => $file_content,
						'name'    => $name,
						'type'    => $type
				);
				if (!empty($content_id_name)) {
					$this->mail_files[$name]['Content-ID'] = $content_id_name;
				}
			}
		}
	}
	
	/**
	 * ��һ���ļ���ȡ���ݲ����ڸ��������У��Դ�����
	 * eg: $file = "/var/www/html/aaa/ttt.jpg"
	 *     $file = array('/var/www/html/aaa/aa.jpg','/var/www/html/aaa/bb.jpg')
	 *     windows 
	 *     $file = "d:\aaa\a.jpg"
	 *     $file = array('d:\aaa\a.jpg','d:\aaa\b.jpg')
	 * @param string | array $file ����������ַ
	 */
	public function set_file($file){
		if (is_array($file) == true) {
			foreach ($file as $val) {
				$this->read_file($val);
			}
		} else {
			$this->read_file($file);
		}
	}
	
	/**
	 * ���ռ�����������base64_encode���뻹���ʼ�����
	 * @param string $str Ҫ���������
	 * @param string $charset ���ֱ��롣��������ã���Ĭ�������õ��ʼ����ı��룬�����û���ã�Ĭ����gb2312
	 * @return string
	 */
	protected function base_encode($str, $charset = ""){
		if (empty($charset) == true) {
			$charset = $this->mail_charset;
		}
		if (!empty($str)) {
			return '=?' . $this->mail_to_charset . '?B?' . base64_encode(iconv($charset,$this->mail_to_charset . '//IGNORE',$str . " ")) . '?=';
		}
	}
	
	/**
	 * �ж��Ƿ���HTML���ݣ������html,table,div��ǣ�����HTML����
	 * @param string $html ��������
	 * @return string
	 */
	private function find_images($html){
		if(!preg_match('/\<html/i',$html) && !preg_match('/\<table/i',$html) && !preg_match('/\<div/i',$html)) {
			return $html;
		} else {
			$html = $this->search_html_images($html);
			return $html;
		}
	}
	
	/**
	 * �ӱ����趨��ͼƬ�����У��Ѵ����������������еķ���ͼƬ���͵�ͼƬ�ҳ�����
	 * �����ص����������У��Թ����͵���������ݣ�ͼƬ��������ʾ�����ش���������
	 * @param string $html ��������
	 * @return string
	 * @throws Exception ����ڵ��ô˷���֮ǰ����δ����images_dir���ͼƬ·�������׳�����
	 */
	private function search_html_images($html){
		if (is_array($this->image_types)) {
			foreach($this->image_types as $key => $val) {
				$extensions[] = $key;
			}
		}
		$images_dir = $this->images_dir;
		if ($this->images_dir == '') {
			throw new Exception('ͼƬ·��ǰ׺δ���ã������set_images_dir()���������ã�');
		}
		preg_match_all('/"([^"]+\.(' . implode('|', $extensions).'))"/Ui', $html, $images);
		
		for ($i=0; $i<count($images[1]); $i++) {
			if (file_exists($images_dir . $images[1][$i])) {
				$name = basename($images[1][$i]);
				$index = strrpos($name,'.');
				$t_name = substr($name,0,$index) . microtime(true) . '.' . substr($name,$index+1);
				
				$this->read_file($images_dir . $images[1][$i], $t_name);
				$html = str_replace($images[1][$i], 'cid:' . $t_name, $html);
			}
		}
		return $html;
	}
	
	/**
	 * �����Ҫ����ΪWORD������ô˷��������ص����ݼ��ɱ���ΪDOC�ļ�
	 */
	public function get_word_content(){
		$sub_word = clone $this;
		$arr = $sub_word->get_mail_header();
		if ($sub_word->send_body == '') {
			$sub_word->combination_of_email(true);
		}
		$body = $sub_word->send_body;
		$rtn = $arr['headers'];
		$rtn .= $body;
		return $rtn;
	}
	
	/**
	 * ����ʼ�HEADERͷ���֡����ص����鷽��mail�������ʼ���
	 * @return array('headers'=>'..','to_address'=>'...','subject'=>'...')
	 */
	private function get_mail_header(){
		$headers = join("\n", $this->mail_header);
		
		if ($this->mail_to_name != '') {
			$to_address = $this->base_encode($this->mail_to_name) . "<" . $this->mail_to_address . ">";
		} else {
			$to_address = $this->mail_to_address;
		}
		
		$subject = $this->base_encode($this->mail_subject['subject'],$this->mail_subject['charset']);
		return array(
			'headers'     => $headers,
			'to_address'  => $to_address,
			'subject'     => $subject,
			'bcc_address' => $this->mail_header['bcc']
		);
	}
	

	/**
	 * ����ʼ�
	 * @param boolean $images �Ƿ��HTML�е�ͼƬ�������ʼ��з���
	 * @throws Exception ����ڴ�֮ǰû����ͼƬ������λ�ã�[��Ӧ�ʼ������е�·��]����׳�����
	 */
	public function combination_of_email($images = false){
		$this->img_to_mail = $images;
		
		if (isset($this->mail_header['From']) == false) {
			$boundary = uniqid("");
			$this->boundary = $boundary;
			if ($this->mail_to_name != '') {
				$this->mail_header['From'] = "From: " . $this->base_encode($this->mail_from_name) . "<" . $this->mail_from_address . ">";
			} else {
				$this->mail_header['From'] = "From: " . $this->base_encode($this->mail_from_address)  . "<" . $this->mail_from_address . ">";
			}
		}
		
		if (!isset($boundary)) $boundary = $this->boundary;
		
		if ($this->mail_return_address != '' ) {//&& isset($this->mail_header['Return-Path']) != true
			$this->mail_header['Return-Path'] = "Return-Path: <" . $this->mail_return_address . ">";
		}
		
		if (isset($this->mail_header['cc']) == false) {
			if (is_array($this->mail_copy_to) == true) {
				foreach ($this->mail_copy_to as $key => $val) {
					if (!empty($val)) {
						$Cc[] = $this->base_encode($val) . "<" . $key . ">";
					} else {
						$Cc[] = $key;
					}
				}
				$this->mail_header['cc'] = "Cc: " . join(",",$Cc);
			} elseif (!empty($this->mail_copy_to)) {
				$this->mail_header['cc'] = "Cc: " . $this->mail_copy_to;
			}
		}
		
		if (isset($this->mail_header['bcc']) == false) {
			if (is_array($this->mail_bcc_to) == true) {
				foreach ($this->mail_bcc_to as $key => $val) {
					if (!empty($val)) {
						$Bcc[] = $this->base_encode($val) . "<" . $key . ">";
					} else {
						$Bcc[] = $key;
					}
				}
				$this->mail_header['bcc'] = "Bcc: " . join(",",$Bcc);
			} elseif (!empty($this->mail_bcc_to)) {
				$this->mail_header['bcc'] = "Bcc: " . $this->mail_bcc_to;
			}
		}
		
		
		if ($images == true) {
			if (isset($this->mail_header['boundary']) == false) { //����Ѿ����������ͷ��Ϣ���Ͳ�������
				$this->mail_header['boundary'] = "Content-type: multipart/mixed;boundary=\"$boundary\"\n";
				//$this->mail_header[] = "\nThis is a multi-part message in MIME format.\n";
				$this->mail_header[] = "--$boundary";
			}
		} else {
			if (isset($this->mail_header['boundary']) == false) { //����Ѿ����������ͷ��Ϣ���Ͳ�������
				$this->mail_header['boundary'] = "Content-type: multipart/mixed; boundary=\"$boundary\"";
			}
			$body = "--$boundary\n";
		}

		
		$body_temp = '';
	
		foreach ($this->mail_body as $key => $val){
			if (!empty($val['charset'])) {
				$body_temp .= iconv($val['charset'], $this->mail_to_charset . '//IGNORE', $val['body'] . " ") . "\n";
			} else {
				$body_temp .= iconv($this->mail_charset, $this->mail_to_charset . '//IGNORE', $val['body'] . " ") . "\n";
			}
		}
		
		
		if ($images == true) {
			
			if (isset($this->mail_header['subboundary']) == false) {
				$subboundary = uniqid("");
				$this->sub_boundary = $subboundary;
				$this->mail_header['subboundary'] = 'Content-Type: multipart/alternative;boundary="' . $subboundary . '"' . "\n\n";
			}
			if (!isset($subboundary)) $subboundary = $this->sub_boundary;
			
			$body .= '--' . $subboundary . "\n";
			
			$body .= 'Content-Type: ' . $this->mail_type . ';charset="' . $this->mail_to_charset . '"' . "\n";
			$body .= 'Content-Transfer-Encoding: ' . $this->mail_body_encode . "\n\n";
			
			
			$body_temp = $this->find_images($body_temp);
		} else {
			$body .= "Content-Type: $this->mail_type;charset=\"" . $this->mail_to_charset . "\"\n";
			$body .= "Content-transfer-encoding: " . $this->mail_body_encode . "\n\n";//8bit
		}

		
		if ($this->mail_type == 'text/html') {
			$temp = '<meta http-equiv="Content-Type" content="text/html; charset=' . $this->mail_to_charset . '" />';
			$body_temp = nl2br($temp . $body_temp);
		}
		switch ($this->mail_body_encode) {
			case 'base64':
				$body .= chunk_split(base64_encode(rtrim($body_temp)));
				break;
			case 'quoted-printable':
				$body .= $this->quoted_printable_encode($body_temp);
				break;
			default:
				$body .= $body_temp;
				break;
		}
		
		if ($images == true) {
			$body .= "\n--" . $subboundary . "--\n";
		}

		if (count($this->mail_files) > 0) {
			foreach ($this->mail_files as $val) {
				$body .= "\n--$boundary\n";
				$body .= "Content-type: " . $val['type'] . ";name=" . $val['name'] . "\n";
				if (isset($val['Content-ID']) && $val['Content-ID'] != '') {
					$body .= "Content-ID: <" . $val['Content-ID'] . ">\n";
				} else {
					$body .= "Content-disposition:attachment;filename=" . $val['name'] . "\n";
				}
				$body .= "Content-transfer-encoding: base64\n\n";
				$body .= chunk_split(base64_encode($val['content'])) . "\n";
			}
		}
		
		$body .= "--$boundary--\n";
		
		$this->send_body = $body;
		return $body;
	}
	
	/**
	 * �����ʼ�
	 * ���سɹ�����ʧ�� �� true false
	 * @param mail_send_agent_smtp $send_mail_obj
	 * @param boolean $repeat �Ƿ���Ҫ��������ʼ�����
	 * @return boolean
	 */
	public function send_mail($send_mail_obj = null, $repeat = false){
		if ($this->send_body == '' || $repeat == true) {
			$this->combination_of_email($this->img_to_mail);
		}
		$body = $this->send_body;
		$arr = $this->get_mail_header();

		if (SEND_EMAILS != 'true') {
			echo '�����ʼ����ܹرգ�';
			return false; //���ϵͳδ�򿪷��ʼ����ܣ��򲻷���
		}
		// ��Ӻ�̨����ʱ���� ��̨Ĭ�ϵķ��ʼ�����
		if (is_object($send_mail_obj)) {
			$send_mail_obj->connection();
			$rtn = $send_mail_obj->sendMail($arr['to_address'], $arr['subject'], $body, $arr['headers']);
		} else {
			$rtn = mail($arr['to_address'],$arr['subject'],$body,$arr['headers'],$arr['bcc_address']);
		}
		if ($rtn == true) {
			$rtn = true;
		} else {
			$rtn = false;
		}
		return $rtn;
	}
	
	/**
	 * �ɴ�ӡ�ַ����ñ���
	 * 
	 * @param string $input ��Ҫ���������
	 * @param int $line_max �п������76 Ĭ��Ҳ�����������Щ��������˿��
	 * @return string
	 */
	private function quoted_printable_encode($input , $line_max = 76) {
		$lines = preg_split("/\r\n|\r|\n/", $input);
		$eol = "\n";
		$escape = '=';
		$output = '';
		if (is_array($lines)) {
			foreach ($lines as $key => $line) {
				$linlen = strlen($line);
				$newline = '';
		
				for ($i = 0; $i < $linlen; $i++) {
					$char = substr($line, $i, 1);
					$dec = ord($char);
		
					// convert space at eol only
					if ( ($dec == 32) && ($i == ($linlen - 1)) ) {
						$char = '=20';
					} elseif ($dec == 9) {
						// Do nothing if a tab.
					} elseif ( ($dec == 61) || ($dec < 32 ) || ($dec > 126) ) {
						$char = $escape . strtoupper(sprintf('%02s', dechex($dec)));
					}
		
					// $this->lf is not counted
					if ((strlen($newline) + strlen($char)) >= $line_max) {
						// soft line break; " =\r\n" is okay
						$output .= $newline . $escape . $eol;
						$newline = '';
					}
					$newline .= $char;
				}
				$output .= $newline . $eol;
			}
		}
		// Don't want last crlf
		$output = substr($output, 0, -1 * strlen($eol));
	
		return $output;
	}
}
?>

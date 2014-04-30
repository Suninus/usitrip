<?php
/*ini_set('display_errors', '1');
error_reporting(E_ALL & ~E_NOTICE);
require_once 'imap_get_mail.php';*/
class mail_parse{
	
	/**
	 * ��Ҫ��ȡ�������ʼ�·��
	 * @var string
	 */
	private $email_file = '';
	
	/**
	 * ��ȡ�������ʼ�ͷ
	 * @var array
	 */
	private $email_header = array();
	
	/**
 	 * �ʼ�������,��������.
 	 * @var array
 	 */
	private $email_text = array();
	
	/**
	 * �ʼ�����
	 * @var array
	 */
	private $attachment = array();
	/**
	 * �ʼ�����
	 * @var string
	 */
	private $email_type = '';
	
	/**
	 * ��ʱͼƬ�洢λ��
	 * @var string
	 */
	private $img_temp_save_path = '/admin/img_tmp/';
	
	/**
	 * ������뷽ʽ,��Щ�ʼ�����û�б���,���Դ��ʼ��������ҳ�����,
	 * ����¼�ڴ�,���жϱ����Ƿ���Ҫ��һ��ת��
	 * @var string
	 */
	private $subject_charset = ''; 
	
	
	
	/**
	 * ������Ҫ��ȡ���ʼ��ļ�
	 * @param string $file
	 */
	public function set_file($file) {
		if (!empty($file)) {
			$this->email_file = $file;
			$this->read_mail();
		}
	}
	
	/**
	 * ������ʱͼƬ�洢·��,������/��β
	 * @param string $path
	 */
	public function set_img_temp_path($path){
		if (!empty($path)) {
			$this->img_temp_save_path = $path . date('Y-m-d') . '/';
		}
	}
	
	/**
	 * ���������ʼ���,�ʼ�ͷ�����ķֿ��ĵط�.
	 * ����ҵ�,�򷵻�����,���򷵻�-1
	 * @param array $arr
	 * @return int
	 */
	private function find_unknown_header_separated($arr){
		$rtn = -1;
		if (is_array($arr)) {
			for($i = 0,$len = count($arr); $i < $len; $i++) {
				if (strpos($arr[$i],':') == false) {
					$rtn = $i;
					break;
				}
			}
		}
		return $rtn;
	}
	
	/**
	 * ����һ���ʼ������� ,
	 * ������û����ôӷ������������ʼ���ʱ��,ͨ���÷���,�Ϳ���ֱ�������ʼ�������,������Ҫ�����´��ļ���ȡ.
	 * @param array $content �ʼ�����.�����е�ÿ����Ԫ�����ļ�����Ӧ��һ�У��������з�����
	 */
	public function set_mail_content($content){
		if (is_array($content)) {
			//var_dump($content);
			// ����ֻ�л��е���һ�� ���ϲ������ʼ�ͷ,���²���������

			$index = array_search("\r\n",$content);
			if ($index === false) { // ע��Ҫ�������Ⱥţ������һ��һ�о��ҵ��˷��ؼ�����0 �����Ⱥ� �� 0 Ҳ��FALSE
				$index = array_search("\n",$content);
			}
			if ($index === false) { //������ַ�ʽ���Ҳ���,������һ�������ʼ�.
				$index = $this->find_unknown_header_separated($content);
			}

			// һ�����б�ʾͷ�����ĵķָ�. array_splice ��ֿ�
			$head = array_splice($content, 0,$index);
			$this->set_mail_head($head);
			$this->set_mail_text($content);
		} else {
			throw new Exception('�ʼ����ı�����һ������,�����е�ÿ����Ԫ�����ļ�����Ӧ��һ�У��������з�����.');
		}
	}
	
	/**
	 * �����ʼ�ͷ����
	 * @param array $head
	 * @throws Exception �������Ĳ�������,���׳��쳣
	 */
	public function set_mail_head($head){
		if (is_array($head)){
			$head = $this->format_mail_head($head);
			$this->filter_head($head);
		} else {
			throw new Exception('�ʼ�ͷ������һ������.');
		}
	}
	
	/**
	 * �����ʼ���������,����������
	 * @param array $text
	 * @throws Exception
	 */
	public function set_mail_text($text) {
		if (is_array($text)) {
			$len = count($text);
			/* �����IMAP�յ��ʼ������������)��
			�����ڴ��ж�һ�������������һ���Ƿ���������ţ�
			����������ȥ��֮  */
			if (trim($text[$len-1]) == ')') { 
				array_splice($text, $len-1,1);
			}
			$this->email_text = $text;
		} else {
			throw new Exception('�ʼ����ı�����һ������.');
		}
	}
	
	/**
	 * ��ȡ�ʼ�����
	 * @return string
	 */
	public function get_subject(){
		return $this->email_header['subject'];
	}
	
	/**
	 * ��ȡ������,����array('����������'=>'����������')
	 * @return array
	 */
	public function get_from(){
		return $this->email_header['from_address'];
	}
	
	/**
	 * ��ȡ�ռ��� ���� array('�ռ����ʼ�'=>'�ռ�������')
	 * @return array
	 */
	public function get_to(){
		return $this->email_header['to_address'];
	}
	
	/**
	 * ��ȡ�ʼ�������,����array('�ռ�������'=>'�ʼ�������')
	 * ���û�г�����,�򷵻�NULL
	 * @return array|NULL
	 */
	public function get_cc(){
		return $this->email_header['copy_to_address'];
	} 
	
	/**
	 * ��ȡ�ʼ����͵�ַ
	 * @return array|NULL
	 */
	public function get_bcc(){
		return $this->email_header['bcc'];
	}
	
	/**
	 * �����������������
	 * eg:
	 *    text/html; charset="gbk"
	 */
	public function get_type(){
		return $this->email_header['content-type'];
	}
	
	/**
	 * ��ȡ�ʼ���������
	 * @return string
	 */
	public function get_date(){
		return $this->email_header['date'][0];
	}
	
	/**
	 * ���ص�ǰҳ����� ����Ǹ���ģʽ�ʼ�,���ܸ÷������ش���ı���
	 * @return string
	 */
	public function get_encode(){
		return $this->email_header['content-transfer-encoding'];
	}
	
	/**
	 * ��ȡ����ͷ�е�������Ϣ.
	 * @param unknown_type $name
	 */
	public function get_other($name){
		return $this->email_header[$name];
	}
	/**
	 * �����ʼ�����
	 * @param string $file �ʼ��ļ�·��
	 */
	public function __construct($file = '',$img_tmp_path = ''){
		$this->set_file($file);
		$img_tmp_path = (!empty($img_tmp_path) ? $img_tmp_path : '/var/www/html/888trip.com/wwwroot/admin/email/img_tmp/');
		$this->set_img_temp_path($img_tmp_path);
	}
	
	/**
	 * ��ȡ�ʼ�������
	 * @throws Exception ����ļ�������,���׳�����
	 */
	private function read_mail(){
		if (file_exists($this->email_file)) {
			$text = file($this->email_file);
			if (is_array($text) && count($text) > 0){
				$this->set_mail_content($text);
			} else {
				throw new Exception('�ļ�[' . $this->email_file . ']����Ϊ��!');
			}
		} else {
			throw new Exception('�ļ�[' . $this->email_file . ']������!');
		}
	}
	
	/**
	 * �����ʼ�ͷ�е����ݣ�����⣬�ռ��������뷢��������
	 * @param string $str ��Ҫת��������
	 * @return string
	 */
	private function head_decode($str){
		if (!empty($str)) {
			// �п���һ�����ֹ�������ʱ���ѱ���ʲô�ģ�Ū��������ʾ����������Ҫ�������ó���������Ͻ���ת��
			$str_arr = explode("\n",$str);
			$value = '';
			foreach ($str_arr as $val){
				if (strpos($val,'=?') === false) {
					$value .= $val;
				} else {
					$temp_arr = explode('?',$val);
					$charset = $temp_arr[1];
					$this->subject_charset = $charset; //��¼�ʼ���������ֱ���
					$b = strtolower($temp_arr[2]);
					switch ($b){
						case 'b'://������ǰ����ʱ��� �򲻽���BASE64����
							$value .= trim(iconv($charset,'utf-8//IGNORE',base64_decode($temp_arr[3])));
							break;
						case 'q':
							// quoted_printable_decode ϵͳ�Դ��Ľ��뺯��
							$value .= trim(iconv($charset, 'utf-8//IGNORE', quoted_printable_decode($temp_arr[3])));
							break;
						default:
							throw new Exception('�ʼ���������δ֪�ı��뷽ʽ!');
					}
				}
			}
				
			return $value;
				
		}
		return '';
	}
	
	/**
	 * ���շ��������������Ƹ�ʽ��
	 * @param unknown_type $str
	 * @return multitype:string unknown
	 */
	private function format_address_name($str){
		$rtn = array('address'=>'','name'=>'');
		if (!empty($str)) {
				
			if (preg_match("/\"?([^\"<]+)\"?\s*\<(.+)\>/", $str,$matches)) {
				$rtn['address'] = $matches[2];
				$rtn['name'] = $this->head_decode($matches[1]);
			} else {
				$rtn['address'] = $str;
			}
		}
		return $rtn;
	}
	
	/**
	 * ������Ϣͷ��Ϣ���ҳ���Ҫ������
	 * @param array $head
	 */
	private function filter_head($head) {
		if (is_array($head) == true) {
			foreach($head as $key => $val) {
				switch ($key){
					case 'subject': //�ʼ�����
						$this->email_header['subject'] = $this->head_decode($val[0]);
						break;
					case 'to': // �ռ���
						$to_temp = explode(",",$val[0]);
						foreach($to_temp as $key2 => $val2) {
							$address = $this->format_address_name($val2);
							$this->email_header['to_address'][$address['address']] = $address['name'];
						}
						break;
					case 'from': // ������
						$address = $this->format_address_name($val[0]);
						$this->email_header['from_address'][$address['address']] = $address['name'];
						break;
					case 'cc': //������
						$cc_temp = explode(",", $val[0]);
						foreach ($cc_temp as $key2=>$val2){
							$address = $this->format_address_name($val2);
							$this->email_header['copy_to_address'][$address['address']] = $address['name'];
						}
						break;
					case 'date'://�ʼ���������
						$week = strtok($val[0],",");
						$this->email_header['date'][] = date('Y-m-d H:i:s',strtotime(strtok("+-")));
						break;
					case 'received': //�ʼ����;����ķ�����
						$this->email_header['received'][] = $val;
						break;
					case 'bcc'://����(���������п������ʼ���������ʲô��,)
						$bcc_temp = explode(",", $val[0]);
						foreach ($bcc_temp as $key2 => $val2) {
							$address = $this->format_address_name($val2);
							$this->email_header['bcc'][$address['address']] = $address['name'];
						}
						break;
					case 'content-type'://�ʼ�����  ����� boundary ����ʼ���Ϊ�����.ÿ������в�ͬ����,����ĳһ����߼���Ϊ��������..
						$val[0] = str_replace(array("\r","\n"), "", $val[0]);
						//print_r($val[0]);
						$index = strpos($val[0],';');
						
						$content_type = substr($val[0],0,$index);
						$str = substr($val[0],$index+1);
						$name = $this->find_name(array($str), 'boundary', '=');
												
						if ($name != '') {
							
						//if (preg_match("/([^;]+.*?).*?boundary=\"?(.+)\"?/im", $val[0], $matchs)){
							$this->email_header['content-type'] = $content_type;//$temp[0];//$matchs[1];
							$this->email_header['separator'] = $name; //$value;//$separator[1];//$matchs[2];
						} else {
							$this->email_header['content-type'] = $val[0];
						}
						// �ϴ��������ȡ�������ļ�ҳ����������˸�\r\n  "Content-type: text/html; charset=gb2312\r\n"
						$this->email_header['content-type'] = str_replace(array('\r','\n'), '', $this->email_header['content-type']);
						break;
					default: // ������֪����Ϣ..
						$this->email_header[$key] = $val;
						break;
				}
			}
		}
	}
	
	/**
	 * ��ʽ��ԭʼ��Ϣͷ
	 * @param array $headers �ʼ�ͷ����
	 */
	private function format_mail_head($headers){
		$head = array();
		if (is_array($headers)) {
			foreach($headers as $val) {
				if (preg_match("/^\w+/", $val)) {
					$temp = strtolower(strtok($val,":"));
					$head[$temp][] = substr($val, strlen($temp) + 1);
				} else {
					$head[$temp][count($head[$temp]) - 1] .=  "\n" . $val;
				}
			}
			return $head;
		}
	}
	
	/**
	 * ��ȡ�����б�
	 */
	public function get_attachment(){
		return $this->attachment;
	}
	
	/**
	 * ȡ���ʼ�����
	 * ��html��text
	 * @param string $type �ʼ����Ĳ���,Ĭ����html����,��ʱ���д��ı�����
	 */
	public function get_content($type = 'html') {

		if ($type == 'text') {
			$type = 'text/plain';
		}
		if ($type == 'html') {
			$type = 'text/html';
		}
		if (empty($this->email_text['text'][$type])) {
			if (empty($this->email_text['text']['text/plain'])) {
				echo $this->email_text['text'][0];
			} else {
				echo $this->email_text['text']['text/plain'];
			}
		} else {
			echo $this->email_text['text'][$type];
		}
	}
	
	public function test(){
		print_r($this->email_text);
	}
	/**
	 * �Ա���,�ռ���,������,û���趨���ֱ�����ʼ�,���ж��α���ת��
	 * @param array|string $arr ��Ҫת���Ķ���
	 * @param string $charset ԭ���ֱ���
	 */
	private function iconv_subject($arr,$charset){
		if (is_array($arr)) {
			foreach ($arr as $key => &$val) {
				$val = iconv($charset,'utf-8//IGNORE',$val);
			}
		} elseif (is_string($arr)) {
			$arr = iconv($charset,'utf-8//IGNORE',$arr);
		}
		return $arr;
	}
	
	/**
	 * �ֽ��ʼ�����
	 * @param array $email_text �ʼ���������
	 * @param string $separator ����Ǹ����ʼ�,���Ϊ�ָ���
	 * @throws Exception �����ȡ�������ı���,�򵼳��쳣
	 */
	public function format_mail_text($email_text = '', $separator = ''){
		if (empty($email_text) == true) {
			$email_text = $this->email_text;
			$this->email_text = array();
		}
		if (empty($separator) == true) {
			if (!empty($this->email_header['separator'])) {
				$separator = $this->email_header['separator'];
			}
		}
		//var_dump($separator);
		if (empty($separator) == true) { //�ʼ��в��ֶ������.
			//print_r($this->email_header['content-type']);
			$index = strpos($this->email_header['content-type'],';');
			
			if ($index != false) {
				$charset = $this->find_name(array(substr($this->email_header['content-type'],$index + 1)), 'charset', '=');
				$type = trim(substr($this->email_header['content-type'],0,$index));
			} else {
				$charset = 'gb2312';
				$type = trim($this->email_header['content-type']);
			}
			//�жϱ����Ƿ��б���,���û��,����������ı��뷽ʽ����ת��. ����֤�ٷְٶ�.
			if ($this->subject_charset == '') {
				$this->email_header['subject']         = $this->iconv_subject($this->email_header['subject'], $charset);
				$this->email_header['to_address']      = $this->iconv_subject($this->email_header['to_address'], $charset);
				$this->email_header['from_address']    = $this->iconv_subject($this->email_header['from_address'], $charset);
				$this->email_header['copy_to_address'] = $this->iconv_subject($this->email_header['copy_to_address'], $charset);
				$this->email_header['bcc']             = $this->iconv_subject($this->email_header['bcc'], $charset);
			}

			$encode = '';
			if (!empty($this->email_header['content-transfer-encoding'][0])) {
				$encode = $this->email_header['content-transfer-encoding'][0];
			}
			if (is_array($email_text)){
				//$this->email_header['content-transfer-encoding'][0] �ʼ����ļ��ܷ�ʽ base64 bit7 ��
				
				$text = $this->decodeText(join('',$email_text),$encode);
				
			} elseif( is_string($email_text) && $email_text != '') {
				$text = $this->decodeText($email_text,$encode);
			}
			if ($type == 'text/plain') {
				$text = '<pre>' . $text . '</pre>';
			}

			$this->email_text['text'][$type] = iconv($charset,'utf-8//IGNORE',$text);

		} else {
			
			// �ҳ���ʼλ�� 
			$start = array_search('--' . $separator . "\r\n",$email_text);
			if ($start === false) { // �п��ܲ�����\r\n��β,�����п��ܷ���FALSE
				$start = array_search('--' . $separator . "\n",$email_text);
			}
			// ����λ��
			$end   = array_search('--' . $separator . "--\r\n", $email_text);
			if ($end === false) {
				$end = array_search('--' . $separator . "--\n", $email_text);
			}
			
			if ($end === false) {
				$end = array_search('--' . $separator . '--', $email_text);
			}
			// ������
			//ȡ�������ʼ������������� ������ܻ��ֳɼ���..
			// $start + 1 ��Ϊ��ȥ����һ�е� �ָ���
			
			$text = array_splice($email_text, $start + 1,$end - ($start+1)); 
			print_r($text);
			echo "\r\n===================================================================================\r\n";
			do{
				// ���ҷֽ���
				if (is_array($text)) {
					$next = array_search('--' . $separator . "\r\n", $text);
					if ($next === false) { //���\r\n �Ҳ��� ����� \n����
						$next = array_search('--' . $separator . "\n", $text);
					}
					echo '$next=' . $next . "\r\n<hr />";
					if ($next === false){
						$subText = $text;
					} else {
						$subText = array_splice($text, 0,$next);
					}
					print_r($subText);
					echo '<hr />';
					$start = array_search("\r\n", $subText);
					if ($start === false) {
						$start = array_search("\n", $subText);
					}
					$temp = array_splice($subText, 0, $start);

					if (count($temp) > 0){
						//print_r($temp);
						
						$key = $this->find_name($temp,'content-type',':');
						$key = trim(strtolower($key));
						switch($key){
							case 'image/jpeg': //ͼƬ
							case 'image/png':
							case 'application/octet-stream': //����
							case 'application/zip':
							case 'application/msword':
							case 'application/pdf':
							case 'application/vnd.ms-excel':
							case 'image/gif':
								$this->parse_img($temp,$subText,$key);
								break;
							case 'text/plain':
							case 'text/html':
							case 'multipart/alternative':
							case 'multipart/mixed':
								//$temp = join("<::>",$temp);
								$this->parse_text($temp,$subText,$start,$key);
								break;
							default:
								throw new Exception('δ֪�����Ϳ�.type=' . $key);
						}
					}
				} else {
					$temp = $text;
					$this->parse_text($temp,'',0);
					$next = false;
				}
			} while ($next);
			
			
		}
		$this->save_tep_image();
		$this->replace_img();
	}
	
	/**
	 * ����Ϣͷ�в����ļ���ĳһ��
	 * �ҵ����ض�Ӧ������,���򷵻ؿ�
	 * eg: 
	 * find_name(array(
	 * 				'Content-Type: image/jpeg;',
	 * 				'	name="ADCD9B9B@D0E18A01.F9632350.jpg"',
	 * 				'Content-Transfer-Encoding: base64',
	 * 				'Content-ID: <ADCD9B9B@D0E18A01.F9632350.jpg>'
	 * 			),'name');
	 * ���� ADCD9B9B@D0E18A01.F9632350.jpg
	 * @param array $arr ��Ϣ����
	 * @param string $name ��Ҫ���ҵ�����
	 * @param string $separator ������ֵ֮��ķָ���
	 * @return string
	 */
	private function find_name($arr,$name,$separator) {
		$rtn = '';
		if (is_array($arr)) {
			foreach($arr as $key => $val) {
				$temp_arr = explode(';', $val);
				foreach ($temp_arr as $key2 => $val2) {
					$index = strpos($val2, $separator);
					if ($index != false) {
						$temp = substr($val2,0,$index);
						$temp_val = substr($val2,$index+1);
						if (strtolower(trim($temp)) == strtolower(trim($name))) {
							$rtn = trim($temp_val);
							$rtn = trim($rtn,'"');
							$rtn = trim($rtn,'<');
							$rtn = trim($rtn,'>');
							break;
						}
					}
				}
			}
		}
		return $rtn;
	}
	
	/**
	 * �����ʼ��еĸ���
	 * @param array $temp ����ͷ��Ϣ
	 * @param array|string $subText �ļ�����
	 * @param string $key ����������
	 */
	private function parse_img($temp,$subText,$key){
		$name = $this->find_name($temp, 'name', '=');
		$encode = $this->find_name($temp, 'Content-Transfer-Encoding', ':');
		$jpeg_id = $this->find_name($temp, 'content-id', ':');
		$charset = $this->find_name($temp, 'charset', '=');
		if (!empty($charset)) { //������������ֱ���
			$name = $this->head_decode($name);
		} else { //�����ñ���ı��뷽ʽ
			$name = $this->iconv_subject($name, $this->subject_charset);
		}
		$len = count($this->email_text['attachment']);
		if (count($subText) > 0) {
			$this->email_text['attachment'][$len]['content'] = join('',str_replace("\r\n","",$subText));//$this->decodeText(join('',$subText),$encode);
			$this->email_text['attachment'][$len]['encode'] = $encode;
			$this->email_text['attachment'][$len]['name'] = $name;
			$this->email_text['attachment'][$len]['content-type'] = $key;
			$this->email_text['attachment'][$len]['id'] = $jpeg_id;
		}
	}
	
	/**
	 * �����ʼ����Ŀ�
	 * @param unknown_type $temp    ����Ϣͷ
	 * @param unknown_type $subText ������
	 * @param unknown_type $start   �鿪ʼ����
	 * @param unknown_type $key     �������
	 * @throws Exception
	 */
	private function parse_text($temp,$subText,$start,$key){
		//$temp = preg_replace("/\r\n/","",$temp);
		// �Ƿ��зָ���  $temp_sub ���طָ���
		$temp_sub = $this->find_name($temp, 'boundary', '=');
		if (!empty($temp_sub)){
			$this->format_mail_text(array_splice($subText, $start), $temp_sub);
		} else {
			//ȡ��������GB2312����UTF8��������ʲô����
			$charset = $this->find_name($temp, 'charset', '=');
			if ($charset == '') { //���û�б���,��Ĭ��2312 �в����ʼ�û�б����.
				if ($this->subject_charset != '') {
					$charset = $this->subject_charset;
				} else {
					$charset = 'gb2312';
				}
			}
			//ȡ�ü��ܷ�ʽ
			$encode = $this->find_name($temp, 'content-transfer-encoding', ':');
			if ($encode == '') {
				$encode = $this->find_name($temp, 'charset', '=');
			}
			if (empty($charset) || empty($encode)) {
				throw new Exception('�ʼ�δ֪���ı���!');
			}
			if (count($subText) > 0){
				//print_r($subText);
				$text = $this->decodeText(join('',$subText),$encode);
				if ($key == 'text/plain') { //����Ǵ��ı���,��Ӹ����ָ�ʽ���仯�ı�ǩ
					$text = '<pre>' . $text . '</pre>';
				}
				$this->email_text['text'][$key] = iconv($charset,'utf-8//IGNORE',$text);
			}
		}	
	}
	
	/**
	 * �滻����������Ҫ��ʾ��ͼƬ·��.
	 */
	private function replace_img(){
		if (isset($this->email_text['attachment']) && is_array($this->email_text['attachment'])) {
			foreach($this->email_text['attachment'] as $val) {
				if (!empty($val['id'])) {
					if (is_array($this->email_text['text'])) {
						foreach($this->email_text['text'] as $key2 => &$val2) {
							$val2 = preg_replace("/cid:" . preg_quote(trim($val['id'])) . "/im",$val['save_path'],$val2);
						}
					}
				}
			}
		}
		//print_r($this->email_text['text']);
	}
	
	/**
	 * ���ʼ����Ľ���
	 * @param string $str ��Ҫ���������
	 * @param string $encode ���ݱ��뷽ʽ �� base64 
	 * @return string
	 */
	private function decodeText($str,$encode){
		$encode = strtolower($encode);
		switch(trim($encode)){
			case 'base64':
				$rtn = base64_decode($str);
				break;
			case 'quoted-printable':
				$rtn = quoted_printable_decode($str);
				// ϵͳ�Ľ��뺯�� 
				// ϵͳ�ı��뺯�� quoted_printable_encode
				break;
			default:
				$rtn = $str;
				break;
		}
		return $rtn;
	}
	
	/**
	 * �Ѹ�������ͼƬ�浽��ʱ�ļ�
	 * ���ĸ���,�����һ��,��Ϊ����������Щ��������֧�ֲ���,���������ļ�ʧ��,��� LINUX
	 */
	private function save_tep_image() {

		$this->check_folder();
		$this->get_folder();
		if (isset($this->email_text['attachment']) && is_array($this->email_text['attachment'])) {
			foreach ($this->email_text['attachment'] as $key => &$val) {
				//��Щ�����������˼��ܷ�ʽ,��Ҫ�Ƚ���
				$val['name'] = $this->head_decode($val['name']);
				$index = strrpos($val['name'],'.');
				$tep_name = substr($val['name'],0,$index);
				$tep_ext = substr($val['name'],$index);
				$new_name = md5($tep_name) . $tep_ext;
				file_put_contents($this->img_temp_save_path . $new_name, $this->decodeText($val['content'],$val['encode']));
				$val['save_path'] = 'http://cn.test.com/admin/email/img_tmp/'. date('Y-m-d') . '/' . $new_name;
				$this->attachment[$val['name']] = $val['save_path'];
			}
		}
	}
	
	/**
	 * ����ʼ���ʱͼƬ�ļ����Ƿ����
	 */
	private function check_folder(){
		$base_path = '/var/www/html/888trip.com/wwwroot/admin/';
		$path_arr = str_replace($base_path,'',$this->img_temp_save_path);
		$path_arr = explode('/', $path_arr);
		foreach ($path_arr as $key => $val) {
			if (!is_dir($base_path.$val)) {
				if (!@mkdir($base_path.$val,0777)) {
					throw new Exception('Create folder failed, please check if there is a permissions to create folders!');
				}
			}
			$base_path .= $val . '/';
			
		}

	}
	
	/**
	 * ���·������û�й��ڵ��ļ���,�������ɾ��,�������һ�������ļ�
	 */
	private function get_folder(){
		$base_path = substr($this->img_temp_save_path,0,strrpos(substr($this->img_temp_save_path,0,-1),'/'));
		if (!is_dir($base_path)) {
			return;
		}
		$handle = opendir($base_path);
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..' && $file != (date('Y-m-d'))) {
				if (is_dir($base_path . '/' . $file)) {
					$this->deldir($base_path . '/' . $file);
				}
			}
		}
	}
	
	/**
	 * ɾ���ļ���
	 * @param string $dir Ҫɾ�����ļ���
	 */
	private function deldir($dir) {
		//��ɾ��Ŀ¼�µ��ļ���
		$dh=opendir($dir);
		while ($file=readdir($dh)) {
			if($file!="." && $file!="..") {
				$fullpath=$dir."/".$file;
				if(!is_dir($fullpath)) {
					if (!@unlink($fullpath)) {
						throw new Exception('ɾ���ļ�' . $fullpath . 'ʧ��');	
					}
				} else {
					$this->deldir($fullpath);
				}
			}
		}
		closedir($dh);
		//ɾ����ǰ�ļ��У�
		if(rmdir($dir)) {
			return true;
		} else {
			return false;
		}
	}
}


/*$a = new imap_get_mail('imap.qq.com','2683692314','123456789');
$a->set_debug(true);
$a->connection();
$total = $a->get_mail_totals();
$mail = $a->get_mail($total);
var_dump($mail);
*/



/*
	$email = array(
		'ZC0409-lY_VZoPqiXxf~mU1mieqT28.eml',
		'ZC3709-i5GQq04qhXBT~Gc3TECfA28.eml',
		'ZC1709-tK47jWhAYZS3lQpaRm9ZD28.eml',
		'ZC0409-yNJpWL3AqF1~73Ag_1HOD28.eml',
		'ZC0815-uaO39RBBtEFquSZ2aCbge28.eml',
		'ZC2016-hZ8sM9anxjMfkQ5eV4OYL28.eml'
	);
	if (is_numeric($_GET['i'])) {
		$index = (isset($_GET['i']) && !empty($_GET['i'])) ? (int)$_GET['i'] : 0;
		$email_name = $email[$index];
	} else if (isset($_GET['i'])) {
		header('Content-Type:text/html;charset=utf-8');
		$email_name = $_GET['i'];
	}
	if (isset($email_name)) {
		try{
			ini_set('display_errors', '1');
			error_reporting(E_ALL);
			$a = new mail_parse('/var/www/html/888trip.com/wwwroot/admin/email/'.$email_name);
			//ZC1709-tK47jWhAYZS3lQpaRm9ZD28.eml ZC0409-yNJpWL3AqF1~73Ag_1HOD28.eml ZC0815-uaO39RBBtEFquSZ2aCbge28.eml ZC2016-hZ8sM9anxjMfkQ5eV4OYL28.eml
			/ *echo iconv('gb2312','utf-8//IGNORE','�ʼ�����:') . $a->get_subject() . '<br/>';
			echo iconv('gb2312','utf-8//IGNORE','�ʼ�������:<br/>');
			print_r($a->get_from());
			echo iconv('gb2312','utf-8//IGNORE','<br/>�ռ���:<br/>');
			print_r($a->get_to());
			echo iconv('gb2312','utf-8//IGNORE','<br/>���͸�:<br/>');
			var_dump($a->get_cc());
			echo iconv('gb2312','utf-8//IGNORE','<br/>�ʼ�����:<br/>'); 
			print_r($a->get_type());
			echo iconv('gb2312','utf-8//IGNORE','<br/>�ʼ���������:<br/>');
			print_r($a->get_date());
			echo iconv('gb2312','utf-8//IGNORE','<br/>�ʼ����뷽ʽ:<br/>');
			print_r($a->get_encode());
			echo iconv('gb2312','utf-8//IGNORE','<br/>�ʼ�����<br/>');* /
			//echo $a->get_other('separator');
			
			$a->format_mail_text();
			$from = $a->get_from();
			foreach ((array)$from as $key => $val) {
				echo 'form:' . $val . '&lt;' . $key . '&gt;<br/>';
			}
			echo 'Date:' . $a->get_date() . '<br/>';
			$to = $a->get_to();
			
			foreach ((array)$to as $key => $val) {
				echo 'to:' . $val . '&lt;' . $key . '&gt;<br/>';
			}
			echo 'subject:' . $a->get_subject() . '<br/>';
			$a->get_content();
			echo '<br/>attachment:<br/>';
			print_r($a->get_attachment());
			//echo '�ʼ��ı�����:' . $a->get_subject() . '<br/>';
			//$a->test();
		}catch(Exception $e){
			header('Content-Type:text/html;charset=gb2312');
			var_dump($e);
			print_r($e);
		}
	}
	*/
?>
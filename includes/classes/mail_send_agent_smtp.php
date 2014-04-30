<?php
/*ini_set('display_errors', '1');
error_reporting(E_ALL & ~E_NOTICE);
set_time_limit(50);
ob_end_flush();*/
/**
 * ͨ��SMTP�������ӿڷ����ʼ�
 * @author lwkai 2013-1-7 ����4:47:45
 *
 */
class mail_send_agent_smtp {
	/**
	 * POP ������
	 * @var string
	 */
	private $_hostname = "";
	
	/**
	 * POP �û���
	 * @var string
	 */
	private $_user = '';
	
	/**
	 * POP ����
	 * @var string
	 */
	private $_pass = '';
	
	/**
	 * ������smtp�˿ڣ�һ����110�Ŷ˿�
	 * @var int
	 */
	private $_port = '25';
	
	/**
	 * ����������������
	 * @var resource
	 */
	private $_connection = 0;
	
	/**
	 * ���Կ��� ��֮�����������Ϣ
	 * @var boolean
	 */
	private $_debug = false;
	
	/**
	 * ��ʱ�������������Ӧ��Ϣ
	 * @var string
	 */
	private $_resp = '';
	
	/**
	 * �Ƿ���Ҫ��¼��־ 0����¼ 1��¼������־ 2��¼����ͳɹ�
	 * @var int
	 */
	private $_write_log = 0;
	
	/**
	 * ��־��¼��λ��
	 * @var string
	 * @author lwkai 2013-1-7 ����1:34:13
	 */
	private $_log_path = '';
	
	/**
	 * ��¼������Ϣ
	 * @var array
	 * @author lwkai 2013-1-7 ����1:13:12
	 */
	private $_error = array();
	
	/**
	 * 
	 * @var unknown_type
	 * @author lwkai 2013-1-7 ����2:54:15
	 */
	private $_helo_name = '';
	
	private $_log_info = array();
	
	private $_timeout = 30;
	private $_err_no = 0;
	private $_err_str = '';
	
	/**
     * Returns the server hostname or 'localhost.localdomain' if unknown.
      * @return string
     */
    private function serverHostname() {
    	if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != "") {
            $result = $_SERVER['SERVER_NAME'];
    	} else {
            $result = "localhost.localdomain";
    	}
        return $result;
    }
    
	/**
	 * ��ʼ�������ʼ��ķ�������Ϣ
	 * @param string $pop_server ��������ַ
	 * @param string $user �û���
	 * @param string $pass ����
	 * @param string $port �˿�
	 * @param boolean $debug �Ƿ�򿪵���
	 * @param int $write_log �Ƿ��¼��־[0����¼[Ĭ��],1��¼������־,2��¼����ͳɹ���־]
	 * @param string $log_path ��־��¼��λ��
	 * @author lwkai 2013-1-7 ����1:37:23
	 */
	public function __construct($pop_server,$user,$pass,$port = '25',$debug = false, $write_log = 0, $log_path = '') {
		$this->_hostname = $pop_server;
		$this->_user = $user;
		$this->_pass = $pass;
		$this->_port = $port;
		$this->_debug = $debug;
		if (is_dir($log_path)) {
			$this->_write_log = $write_log;
			$this->_log_path = $log_path;
		}
	}
	
	private function writeLog($status) {
		
		if ($this->_write_log >= 1 && strtolower($status) == 'failed') {
			$data = "\n\n----------------------------------------\n";
			$data .= join("\n", $this->_log_info);
			$data .= '������Ϣ:' . "\n";
			$data .= print_r($this->_error,true);
			$data .= "\n";
			
			if (is_dir($this->_log_path)) {
				if (!in_array(substr($this->_log_path,-1,1),array('/','\\'))) {
					$this->_log_path .= DIRECTORY_SEPARATOR; 
				}
				$error_log_file = $this->_log_path . 'smtp_send_failed.txt';
				
			}
		}
		
		if ($this->_write_log == 2 && strtolower($status) == 'success') {
			$data = "\n\n----------------------------------------\n";
			$data .= join("\n", $this->_log_info);
			$data .= "\n";
				
			if (is_dir($this->_log_path)) {
				if (!in_array(substr($this->_log_path,-1,1),array('/','\\'))) {
					$this->_log_path .= DIRECTORY_SEPARATOR;
				}
				$error_log_file = $this->_log_path . 'smtp_send_success.txt';
			
			}
		}
		if ($this->_write_log) {
			$write_type = "ab";
			$file_max_size = 1024*1024*2; //2M
			if(@filesize($error_log_file)>$file_max_size){
				copy($error_log_file,$error_log_file . '.' . date('Ymd_His') . '.txt');
				$write_type = "wb";
			}
			if($handle = fopen($error_log_file, $write_type)){
				fwrite($handle, $data);
				fclose($handle);
			}
		}
	}
	/**
	 * �׳��쳣
	 * @throws Exception
	 * @author lwkai 2013-1-7 ����1:25:56
	 */
	private function throwErr() {
		$this->writeLog('failed');
		throw new Exception($this->_error['error']);
	}
	
	/**
	 * �򿪷���������
	 * @return boolean
	 * @author lwkai 2013-1-7 ����1:52:53
	 */
	private function open() {
		if(empty($this->_hostname)) {
			$this->_error = array(
				"error" => "Hostname can't of empty! [����������Ϊ��]",
				"smtp_code" => '',
				"smtp_msg" => ''
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		}
		
		$this->outDebug("�������� $this->_hostname,$this->_port,<br/>");
		
		if(!$this->_connection = fsockopen($this->_hostname,$this->_port,$this->_err_no, $this->_err_str, $this->_timeout)) {
			$this->_error = array(
				"error" => "Failed of connect server! [���ӷ�����ʧ�ܣ�]",
				"errno" => $this->_err_no,
				"errstr" => $this->_err_str
			);
			$this->throwErr();
		} else {
			# sometimes the SMTP server takes a little longer to respond
			# so we will give it a longer timeout for the first read
			// Windows still does not have support for this timeout function
			if(substr(PHP_OS, 0, 3) != "WIN")
				socket_set_timeout($this->_connection, $this->_timeout, 0);
			
			if (!$this->check('220')) {
				$this->_error = array(
					"error" => "Invalid information! [���ӷ������󷵻���Ч��Ϣ��]",
					"errorno" => '',
					"errstr" => $this->_resp
				);
				$this->throwErr();
			}
			return true;
		}
	}
	
	/**
	 * ��鵱ǰ�����Ƿ���Ч
	 * @return boolean
	 * @author lwkai 2013-1-7 ����2:33:11
	 */
	private function connected() {
		if(!empty($this->_connection)) {
			$sock_status = socket_get_status($this->_connection);
			if($sock_status["eof"]) {
				$this->_error = array(
					'error'  => 'EOF caught while checking if connected! [��ǰ�����ѳ�ʱ��]',
					'errno'  => '',
					'errstr' =>	''
				);
				$this->outDebug($this->_error['error']);
				$this->throwErr();
			}
			return true;
		}
		return false;
	}
		
	/**
	 * ��¼
	 * 
	 * @author lwkai 2013-1-7 ����2:35:58
	 */
	private function login() {
		if (!$this->command(base64_encode($this->_user),'334') || !$this->command(base64_encode($this->_pass), '235')) {
			$this->_error = array(
					"error"   => "Failed of Username or Password! [������û����������룡]",
					"smtp_code" => $this->_user . ' ' . $this->_pass,
					"errstr"  => $this->_resp
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		}
	}
	
	/**
	 * �����������к�����
	 * @return boolean
	 * @author lwkai 2013-1-7 ����3:19:55
	 */
	private function hello(){
		if (!$this->connected()) {
			$this->_error = array(
				"error" => "without being connected! [�����ѳ�ʱ��]"
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		}

		if ($this->_helo_name) {
			$host = $this->_helo_name;
		} else {
			$host = $this->serverHostname();
		}
		
		if (!$this->sendHello("HELO", $host)) {
			if (!$this->sendHello("EHLO", $host)) {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Sends a HELO/EHLO command.
	 * @param string $hello
	 * @param string $host
	 * @return boolean
	 * @author lwkai 2013-1-7 ����2:39:31
	 */
	private function sendHello($hello, $host) {

		if (!$this->command($hello . " " . $host, "250")) {
			$this->_error = array(
				'error' => $hello . " not accepted from server",
				'smtp_code' => $hello . " " . $host,
				'smtp_msg' => $this->_resp
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		}
			
		return true;
	}
	
	/**
	 * ���ӷ���������¼
	 * 
	 * @author lwkai 2013-1-7 ����3:20:18
	 */
	public function connection() {
		$this->open();
		$this->hello();
		
		if (!$this->command("auth login",'334')) {
			$this->_error = array(
					'error' => "AUTH not accepted from server",
					'smtp_code' => 'auth login',
					'smtp_msg' => $this->_resp
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		}
		$this->login();
		$this->mailFrom($this->_user);
	}
	
	/**
	 * �������ݣ�������Ƿ�ɹ�ִ������
	 * @param string $tag ������ȷ��������Ϣ�ĵ�һ���ַ����Կո�ָ��ĵ�һ��Ԫ��
	 */
	private function check($tag = array('250')) {
		is_string($tag) && $tag = array($tag);
		$this->getResp();
		$this->outDebug($this->_resp);
		$str = explode(' ',$this->_resp);
		if (in_array($str[0],$tag)) {
			return true;
		}
		return false;
	}
	
	private function safeFeof($fp,&$start = NULL) {
		$start = microtime(true);
		return feof($fp);
	}

	/**
	 * ����SOCKET������������
	 * @return boolean
	 */
	private function getResp(){
		stream_set_timeout($this->_connection, $this->_timeout); // ����SOCKET��ʱʱ�� ��λΪ��
		$this->_resp = '';
		$start = null;
		$timeout = ini_get('default_socket_timeout');
		while (!$this->safeFeof($this->_connection,$start) && (microtime(true) - $start) < $timeout) {
			$this->_resp .= fgets($this->_connection);
			$length = strlen($this->_resp);
			if($length >= 2 && (substr($this->_resp, $length - 2, 2) == "\r\n" || substr($this->_resp, $length - 1, 1) == "\n")){
				$this->_resp = strtok($this->_resp,"\r\n");
				return true;
			}
		}
	}

	/**
	 * ���������Ϣ��������������������Ϣ
	 * �������þ��ǰѵ�����Ϣ$message��ʾ����������һЩ�����ַ�����ת���Լ�����β����<br>��ǩ��������Ϊ��ʹ������ĵ�����Ϣ�����Ķ��ͷ�����
	 * @param string $message
	 */
	private function outDebug($message) {
		if ($this->_debug) {
			echo htmlspecialchars($message)."<br>\n";
			flush();
		}
	}
	
	/**
	 * ����ָ��
	 * @param string $command ���͵������ַ���
	 * @param string $tag �жϷ��ص��ַ�������ַ����Ƿ�����������ж�����ִ�н��,false�򲻽��м��
	 * @throws Exception 
	 * @return string|boolean
	 * @author lwkai 2012-12-28 ����2:59:24
	 */
	private function command($command, $tag) {
		if(!$this->_connection) {
			$this->_error = array(
				'error' => 'Not connection to server! [û�����ӵ���������]',
				'errno' => '',
				'errstr' => ''	
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		}
		$this->outDebug(">>> $command");
		if (!fputs($this->_connection,"$command\r\n")) {
			$this->_error = array(
				'error' => 'Failed of send command! [����ָ��ʧ�ܣ�]',
				'smtp_code' => $command,
				'smtp_msg' => ''
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		} else {
			$tag && $rtn = $this->check($tag);
			if ($rtn == true) {
				return $this->_resp;
			}
			return false;
		}
	}
	
	/**
	 * ���õ�ǰ�ʼ��Ǵ��ĸ����䷢��
	 * @param unknown_type $string
	 * @author lwkai 2012-12-28 ����3:02:30
	 */
	private function mailFrom($string) {
		if (strpos($string,'@') === false) {
			$temp = explode('.',$this->_hostname);
			unset($temp[0]);
			$string = $string . '@' . join('.',$temp);
		}
		$this->_log_info[] = 'mail from: <' . $string . '>';
		if (!$this->command('mail from:<' . $string . '>', '250')) {
			$this->_error = array(
				'error' => 'mail from ����ִ��ʧ�ܣ�',
				'smtp_code' => 'mail from:<' . $string . '>',
				'smtp_msg' => $this->_resp
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		}
	}
	
	
	private function rcpt($to_address) {
		$to_mail = substr($to_address,strpos($to_address,'<'));
		if (!$this->command('rcpt to:' . $to_mail, array('250','251'))) {
			$this->_error[] = array(
					'error' => 'RCPT not accepted from server',
					'smtp_code' => 'rcpt to:' . $to_address,
					'smtp_smg' => $this->_resp
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		}
	}
	
	
	public function sendMail($to_address,$subject,$message,$headers) {
		if(!$this->connected()) {
			$this->_error = array(
					"error" => "Call sendMail without being connected!"
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		}
		
		$this->_error = array();
		$this->_log_info[] = 'to_address:' . $to_address;
		$this->rcpt($to_address);

		$headers = explode("\n",$headers);
		$bcc = $this->search('bcc', $headers);
		if ($bcc) {
			$this->_log_info[] = 'bcc:' . $bcc;
			$arr = explode(',', $bcc);
			foreach ($arr as $key => $val) {
				$this->rcpt($val);
			}
		}
		$cc = $this->search('cc', $headers);
		if ($cc) {
			$this->_log_info[] = 'cc:' . $cc;
			$arr = explode(',', $cc);
			foreach ($arr as $key => $val) {
				$this->rcpt($val);
			}
		}
		
		
		if (!$this->command('data', '354')) {
			$this->_error[] = array(
					'error' => 'DATA command not accepted from server',
					'smtp_code' => 'data',
					'smtp_smg' => $this->_resp
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		}
		
		$headers[] = 'To:' . $to_address;
		$headers[] = 'date:' . date('Y-m-d H:i:s');
		$headers[] = 'subject:' . $subject;
		$this->_log_info[] = 'date:' . date('Y-m-d H:i:s');
		$this->_log_info[] = 'subject:' . $subject;
		$this->command(join("\n",$headers), false);


		$this->command("\n",false);
		
		$this->command($message, false);

		
		if (!$this->command('.','250')) {
			$this->_error =	array(
				"error" => "DATA not accepted from server",
				"smtp_code" => '',
				"smtp_msg" => $this->_resp
			);
			$this->outDebug($this->_error['error']);
			$this->throwErr();
		}
		$this->writeLog('success');
		return true;
	}
	
	/**
	 * ����ָ����ͷ��Ϣ,�Ҳ��� ���� flase
	 * @param string $tag ͷ��Ϣ���
	 * @param array $array ͷ��Ϣ����
	 * @return string
	 * @author lwkai 2013-1-7 ����2:31:31
	 */
	private function search($tag,$array) {
		if (is_string($array)) $array = array($array);
		if (is_array($array)) {
			foreach ($array as $key => $val) {
				$temp = explode(':',$val);
				if (strtolower($temp[0]) == strtolower($tag)) {
					return $temp[1];
				}
			}
		}
		return false;
	}
	
	/**
	 * ���ٵ����ʱ�򣬶Ͽ�����
	 * 
	 * @author lwkai 2012-12-28 ����3:00:55
	 */
	public function __destruct() {
		if ($this->_connection) {
			$this->command("quit",'221');
		}
		$this->close();
	}
	
	/**
	 * �ر�����
	 * 
	 * @author lwkai 2013-1-7 ����2:30:26
	 */
	private function close() {
		if(!empty($this->_connection)) {
			fclose($this->_connection);
			$this->_connection = 0;
		}
	}
}
/*
try {
//$sendmail = new mail_send_agent_smtp('smtp.qq.com','username@qq.com','password','25',true);
$sendmail = new mail_send_agent_smtp('ssl://smtp.gmail.com', 'username', 'password','465',true,2,'/var/www/html/lwkai/usitrip.1/wwwroot/tmp/');
$sendmail->connection();
$sendmail->sendMail('<2355652780@qq.com>', 'test mail',"Hi , test2\nThis is a test mail,you don't reply it." . date('Y-m-d H:i:s'),"From:lwkai<li1275124829@gmail.com>\r\nCc:<27310221@qq.com>\r\nBcc:<2683692314@qq.com>\r\nDate:Mon,25 Oct 2013 14:24:27 +0800");
}catch (Exception $e) {
	echo($e->getMessage());
}
*/
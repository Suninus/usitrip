<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
/**
 * IMAP ��ʽ���ʼ�
 * @author lwkai by 2012-08-03
 *
 */
class imap_get_mail{

	/**
	 * POP ������
	 * @var string
	 */
	private $hostname = "";

	/**
	 * POP �û���
	 * @var string
	 */
	private $user = '';

	/**
	 * POP ����
	 * @var string
	 */
	private $pass = '';

	/**
	 * ������IMAP�˿ڣ�һ����143�Ŷ˿�
	 * @var int
	 */
	private $port = 143;

	/**
	 * �������������ʱʱ��
	 * @var int
	 */
	private $timeout = 5;

	/**
	 * ����������������
	 * @var resource
	 */
	private $connection = 0;

	/**
	 * ���浱ǰ��״̬ [�ַ���]
	 * @var string
	 */
	private $state = "DISCONNECTED";

	/**
	 * ���Կ��� ��֮�����������Ϣ
	 * @var boolean
	 */
	private $debug = false;

	/**
	 * ����������ﱣ�������Ϣ
	 * @var string
	 */
	private $err_str='';

	/**
	 * ����������ﱣ��������
	 * @var number
	 */
	private $err_no = 0;

	/**
	 * ��ʱ�������������Ӧ��Ϣ
	 * @var string
	 */
	private $resp = '';

	/**
	 * ����ǰ׺��
	 * @var string
	 */
	private $tag = '';

	/**
	 * �ʼ�����
	 * @var int
	 */
	private $mail_total = 0;
	
	/**
	 * δ���ʼ���
	 * @var int
	 */
	private $mail_unseen = 0;

	/**
	 * ���ʼ����ܴ�С
	 * @var int
	 */
	private $size;

	/**
	 * ��������ʼ��Ĵ�С�������ʼ������������
	 * @var array
	 */
	private $mail_list = array();

	/**
	 * �ʼ�ͷ�����ݣ�����
	 * @var array
	*/
	private $head=array();

	/**
	 * �ʼ�������ݣ�����;
	 * @var array
	*/
	private $body=array();

	/**
	 * IMAP��ʽ��ȡ�ʼ�
	 * @param string $hostname �ռ���ַ
	 * @param string $user ��¼�ʺ�
	 * @param string $pass ��¼����
	 * @param int $port �ռ��˿�
	 * @param int $time_out ��ʱʱ��
	*/
	public function __construct($hostname = "",$user = "", $pass = "", $port=143, $time_out=5) {
		$this->set_hostname($hostname);
		$this->set_port($port);
		$this->set_timeout($time_out);
		$this->set_user($user);
		$this->set_pass($pass);
		$str = 'abcdefghijklmnopqrstuvwxyz'; //����ַ���
		// ����ǰ׺
		$this->tag = $str[rand(0,25)] . $str[rand(0,25)];// ���ȡһ��
		
	}

	/**
	 * �����ռ�IMAP��ַ
	 * eg: $hostname = 'imap.qq.com';
	 * @param string $hostname
	 */
	public function set_hostname($hostname) {
		if (!empty($hostname)) {
			$this->hostname = $hostname;
		}
	}

	/**
	 * �����û���¼�ʺ�
	 * @param string $user
	 */
	public function set_user($user){
		if (!empty($user)) {
			$this->user = $user;
		}
	}

	/**
	 * �����û���¼����
	 * @param string $pass
	 */
	public function set_pass($pass){
		if (!empty($pass)) {
			$this->pass = $pass;
		}
	}
	
	/**
	 * �����ռ��˿ڣ�Ĭ����143
	 * @param int $port
	 */
	public function set_port($port) {
		if ((int)$port > 0) {
			$this->port = $port;
		}
	}

	/**
	 * ����������ʱʱ�䣬Ĭ����5�룬����Ϊ��λ
	 * @param int $timeout
	 */
	public function set_timeout($timeout) {
		if ((int)$timeout > 0) {
			$this->timeout = $timeout;
		}
	}

	/**
	 * ȡ�ô�����Ϣ
	 */
	public function get_error_message(){
		return $this->err_str;
	}

	/**
	 * ���õ��Կ���
	 * @param boolean $switch
	 */
	public function set_debug($switch){
		if ((boolean)$switch == true) {
			$this->debug = true;
		}
	}

	/**
	 * ��Զ������������
	 * @return boolean
	 */
	private function open(){
		if(empty($this->hostname)) {
			$this->err_str="��Ч��������!!";
			return false;
		}

		if ($this->debug) {
			echo "���ڴ� $this->hostname,$this->port,$this->err_no, $this->err_str, $this->timeout<BR>";
		}

		if(!$this->connection = @fsockopen($this->hostname,$this->port,$this->err_no, $this->err_str, $this->timeout)) {
				
			$this->err_str="���ӵ�IMAP������ʧ�ܣ�������Ϣ��" . $this->err_str . "����ţ�" . $this->err_no;
			return false;
		} else {
			$this->get_resp();
			if($this->debug){
				$this->out_debug($this->resp);
			}
			if (substr($this->resp,0,4)!="* OK")	{
				$this->err_str="������������Ч����Ϣ��".$this->resp."����IMAP�������Ƿ���ȷ";
				return false;
			}
			$this->state="AUTHORIZATION";
			return true;
		}
	}


	/**
	 * ����SOCKET������������
	 * @return boolean
	 */
	private function get_resp(){
		for($this->resp = ""; ; ){
			if(feof($this->connection)) {
				return false;
			}
			$this->resp .= fgets($this->connection);
			$length = strlen($this->resp);
			if($length>=2 && (substr($this->resp,$length-2,2)=="\r\n" || substr($this->resp,$length-1,1) == "\n")){
				$this->resp = strtok($this->resp,"\r\n");
				return true;
			}
		}
	}

	/**
	 * ���������Ϣ��������������������Ϣ
	 * �������ȡ�÷������˵ķ�����Ϣ�����м򵥵Ĵ���ȥ�����Ļس����з�����������Ϣ������resp����ڲ������С���������ں���Ķ�������ж����õ������⣬���и�С����Ҳ�ں���Ķ���������õ���
	 * �������þ��ǰѵ�����Ϣ$message��ʾ����������һЩ�����ַ�����ת���Լ�����β����<br>��ǩ��������Ϊ��ʹ������ĵ�����Ϣ�����Ķ��ͷ�����
	 * @param string $message
	 */
	private function out_debug($message) {
		echo htmlspecialchars($message)."<br>\n";
	}

	/**
	 * ���Ѿ����������������SOCKET���ӣ�����ָ��
	 *
	 * ���������������sock����֮�󣬾�Ҫ��������������ص������ˣ���μ��������������Ի��Ĺ��̣�������� POP�Ի��ķ������Կ�����
	 * ÿ�ζ��Ƿ���һ�����Ȼ�����������һ���Ļ�Ӧ����������ִ���ǶԵģ���Ӧһ������+OK��ͷ��������һЩ������Ϣ��
	 * ����һ���pop������˵������������ķ��ص�һ���ַ�Ϊ"+"���������Ϊ��������ȷִ���ˡ�Ҳ������ǰ���ᵽ���������ַ�"+OK"��Ϊ�жϵı�ʶ��
	 * @param string $command ���͸�������������
	 * @param int $return_lenth �ӷ�����������ȡֵ�ĳ���
	 * @param string $return_code �ӷ�����ȡ�ص�ֵ���ֵ�Ƿ���ͬ�����жϷ������Ƿ񷵻�����������Ϣ
	 * @return boolean
	 */
	private function command($command,$return_lenth=1,$return_code='+') {
		if($this->connection == 0) {
			$this->err_str = "û�����ӵ��κη�������������������";
			return false;
		}

		if($this->debug) {
			$this->out_debug(">>> $command");
		}

		if (!fputs($this->connection,"$command\r\n")) {
			$this->err_str = "�޷���������" . $command;
			return false;
		} else {
			$this->get_resp();
			if($this->debug) {
				$this->out_debug($this->resp);
			}
			if (substr($this->resp,0,$return_lenth) != $return_code) {
				$this->err_str = $command . " ���������������Ч:" . $this->resp;
				return false;
			} else {
				return true;
			}
		}
	}

	/**
	 * �����û��������룬��¼��������
	 * @param string $user ��¼�û���
	 * @param string $password ��¼����
	 * @return boolean
	 */
	private function login() {
		if($this->state!="AUTHORIZATION") {
			$this->err_str = "��û�����ӵ���������״̬����";
			return false;
		}

		if (!$this->command($this->tag . ' login ' . $this->user . ' ' . $this->pass, strlen($this->tag) + 3, $this->tag . " OK")){
			//return false;
		}
		echo 'get 1<hr>';
		flush();
		$this->get_resp();
		echo 'output<hr>';	
		if($this->debug) {
				$this->out_debug($this->resp);
			}
		$this->state = "TRANSACTION"; // �û���֤ͨ�������봫��ģʽ
		echo 'agen send messag<hr>';
		$box ='INBOX';
		$this->command($this->tag . ' select "' . $box . '"',2,"* ");
		echo '============';
		return true;
	}
	
	/**
	 * ѡ�����ŵ�����,һ��INBOX�����ռ���
	 * @param string $box
	 * @return boolean
	 */
	private function selectBox($box = "INBOX"){
		if($this->state!="TRANSACTION") {
			$this->err_str = "��û�����ӵ���������״̬����";
			return false;
		}
		if (!$this->command($this->tag . ' select "' . $box . '"',2,"* ")){
			return false;
		}
		$rtn = array();
		$rtn[] = $this->resp;
		$this->get_resp();
		if($this->debug) {
			$this->out_debug($this->resp);
		}
		$endTag = $this->tag . " OK";
		while (substr($this->resp,0,strlen($endTag)) != $endTag){
			$rtn[] = $this->resp;
			$this->get_resp();
			if($this->debug) {
				$this->out_debug($this->resp);
			}
		}
		$this->encodeBox($rtn);
	}

	/**
	 * ��ѡ���������ȡ���ܹ������ʼ�,�м���δ��
	 * @param array $arr ���������ص���Ϣ,ÿ��Ϊһ������Ԫ��
	 */
	private function encodeBox($arr){
		if (is_array($arr) == true) {
			foreach ($arr as $val){
				switch (true){
					case preg_match("/\*\s(\d+)\sEXISTS/",$val,$matchs):
						$this->mail_total = $matchs[1];
						if($this->debug) {
							$this->out_debug('�ܹ�' . $this->mail_total . '���ʼ�!');
						}
						break;
					case preg_match("/\*\sOK\s\[UNSEEN\s(\d+)\]/",$val,$matchs):
						$this->mail_unseen = $matchs[1];
						if($this->debug) {
							$this->out_debug('δ���ʼ�' . $this->mail_unseen . '��!');
						}
						break;
				}
			}
		}
	}
	
	
	/**
	 * ���ӷ�����
	 */
	public function connection(){
		if (!$this->open()) {
			return false;
		}
		echo '<hr>';
		if (!$this->login()){
			return false;
		}
		
		exit;
		$this->selectBox();
		return true;
	}

	/**
	 * ȡ���ʼ�����
	 * @return int
	 */
	public function get_mail_totals() {
		return $this->mail_total;
	}

	/**
	 * ȡ���м���δ���ʼ�
	 * @return number
	 */
	public function get_unseen(){
		return $this->mail_unseen;
	}
	
	/**
	 * ��ȡ�����ʼ���Ψһ��ʶ��
	 * return array(array(0=>'�ʼ����',1=>'��ʶ��'[,array(0=>'�ʼ����',1=>'��ʶ��')[,...]]))
	 * @return boolean|array
	 */
	public function get_identifier_all(){
		if ($this->state != 'TRANSACTION') {
			// ���û����������ȥ�ӽ�
			if (!$this->connection()){
				$this->err_str="��û�����ӵ���������û�гɹ���¼";
				return false;
			}
		}
		if (count($this->mail_total) == 0) {
			return false;
		}
		$rtn = $this->get_identifier('1:' . $this->mail_total); 
		return $rtn;
	}

	/**
	 * ��ȡ�ʼ�Ψһ��ʶ��
	 * ���� array(array(0=>'�ʼ����',1=>'��ʶ��')[,array(0=>'�ʼ����',1=>'��ʶ��')[,...]])
	 * @param string $num �ʼ���� (5����1:5) 1:5 ��ʾ�����1��ʼ,��5����������UID
	 * @return array
	 */
	public function get_identifier($num){
		if($this->state!="TRANSACTION") {
			// ���û����������ȥ�ӽ�
			if (!$this->connection()){
				$this->err_str="��û�����ӵ���������û�гɹ���¼";
				return false;
			}
		}
		if ((int)$num > 0) {
			$command = $this->tag . ' fetch ' . $num . ' uid';
			if (!$this->command("$command", 2, "* ")) {
				return false;
			} else {
				$rtn = array();
				do {
					if (preg_match("/\*\s(\d+)\sFETCH\s\(UID\s(\d+)\)/i", $this->resp,$matches)){
						$rtn[] = array($matches[1],$matches[2]);
					}
					$this->get_resp();
					if($this->debug) {
						$this->out_debug($this->resp);
					}
				} while (strtolower(substr($this->resp,strlen('Completed') * -1)) != 'completed');
				
				//+OK 1 ZL1526-aXMdkHUdbptyqjV68F5hS26
				//$rtn = explode(' ',$this->resp);
				//array_shift($rtn);
				return $rtn;
			}
		}
		return false;
	}

	/**
	 * ȡ���ʼ������ݣ�$num���ʼ������,ȡ�õ����ݴ�ŵ��ڲ�����$head��$body����������������ÿһ��Ԫ�ض�Ӧ�����ʼ�Դ�����һ�С�
	 * ����ɹ����򷵻�һ�����飬���򷵻�FALSE
	 * @param int $num �ʼ������
	 * @param int $type ȡ�ʼ��ķ�ʽ,Ĭ���� all ȡȫ�� ������ all,head,text,�������Լ�������IMAP���������
	 * ������������   tag fetch mailIndex Command . ��ֻ��Ҫ�� Command�Ϳ�����
	 * @return array | boolean
	 */
	public function get_mail($num=1,$type='all') {
		if($this->state!="TRANSACTION")	{
			// ���û����������ȥ�ӽ�
			if (!$this->connection()){
				$this->err_str="��û�����ӵ���������û�гɹ���¼";
				return false;
			}
		}
		
        $type = strtolower($type);
        
		switch(true){
			case $type == 'all':
				$command = $this->tag . " fetch " . $num . " body[]";
				break;
			case $type == 'head':
				$command = $this->tag . ' fetch ' . $num . ' body[header]';
				break;
			case $type == 'text':
				$command = $this->tag . ' fetch ' . $num . ' body[text]';
				break;
			default:
				$command = $this->tag . ' fetch ' . $num . ' ' . $type;
				break;			
		}
		
		$rtn = array('head'=>'','body'=>'');
		if (!$this->command("$command",2,"* ")) {
			return false;
		} else {

			$mail = array();
				
			$rtn = array();
			
			// ȡ�ʼ���� �� ���صĴ�С
			if(preg_match("/\*\s(\d+)\sFETCH\s[^\{]+\{(\d+)\}/", $this->resp,$matches)) {
				$rtn['num'] = $matches[1];
				$rtn['size'] = $matches[2];
				
			}
			
			
			$this->get_resp();
			$is_head=true;
			
			while (strtolower(substr($this->resp,strlen('completed') * -1)) != 'completed') {
				
				if ($this->resp == ')') {
					$mail[] = $rtn;
					$rtn = array();
					$is_head = true;
					$this->get_resp();
					if(preg_match("/\*\s(\d+)\sFETCH\s[^\{]+\{(\d+)\}/", $this->resp,$matches)) {
						$rtn['num'] = $matches[1];
						$rtn['size'] = $matches[2];
						$this->get_resp();
					}
					if (strtolower(substr($this->resp,strlen('completed') * -1)) == 'completed') {
						break;
					}
				}
				
				if ($this->debug) {
					$this->out_debug($this->resp);
				}
				if (substr($this->resp,0,1)==".") {
					$this->resp=substr($this->resp,1,strlen($this->resp)-1);
				}
				// �ʼ�ͷ�����Ĳ��ֵ���һ������
				if (trim($this->resp)=="") {
					$is_head=false;
				}
				if ($is_head) {
					//$this->head[]=$this->resp;
					$rtn['head'][] = $this->resp;
				} else {
					//$this->body[]=$this->resp;
					$rtn['body'][] = $this->resp;
				}
				$this->get_resp();
				

			}
			
			foreach ($mail as $key => $val) {
				$indent = $this->get_identifier($val['num']);
				if ($indent[0][0] == $val['num']) {
					$mail[$key]['indentifier'] = $indent[0][1];
				}
			}
			/*$indent = $this->get_identifier($m_index);
			if ($indent[0] == $m_index) {
				$rtn['indentifier'] = $indent[1];
			}*/
			
			return $mail;
		}
	}
	
	/**
	 * ���ʼ����ñ��
	 * 
	 * @param string $mail_tag
	 */
	private function set_store($mail_tag){
		if (empty($mail_tag)) {
			$this->err_str="û�в�������!";
			return false;
		}
		if($this->state!="TRANSACTION") {
			$this->err_str="����ʧ��! δ���ӷ�������δ��¼!";
			return false;
		}
		
		if (!$this->command("$mail_tag",0,"")) {
			return false;
		} else {
			while (strtolower(substr($this->resp,strlen('completed') * -1)) != 'completed') {
				$this->get_resp();
				if ($this->debug) {
					$this->out_debug($this->resp);
				}
			}
			return true;
		}
	}
		
	/**
	 * ɾ��ָ����ŵ��ʼ���$num �Ƿ������ϵ��ʼ����
	 * @param int $num
	 * @return boolean
	 */
	public function dele($num) {
		if (!is_numeric($num)){
			return false;
		}
		$command = $this->tag . ' store ' . $num . ' +flags (\Deleted)';
		return $this->set_store($command);
	}
	
	/**
	 * �����ʼ�Ϊ�Ѷ�
	 * @param int $num
	 * @return boolean
	 */
	public function seen($num) {
		if (!is_numeric($num)) {
			return false;
		}
		$command = $this->tag . ' store ' . $num . ' +flags (\Seen)';
		return $this->set_store($command);
	}
	
	/**
	 * �����ʼ�Ϊδ��
	 * @param int $num
	 * @return boolean
	 */
	public function unseen($num) {
		if (!is_numeric($num)) {
			return false;
		}
		$command = $this->tag . ' store ' . $num . ' -flags (\Seen)';
		return $this->set_store($command);
	}


	/**
	 * ���Ҫ�˳������ر��������������
	 */
	public function Close()	{
		if($this->connection!=0) {
			
			if($this->state=="TRANSACTION"){
				$this->command($this->tag . " logout", 5, "* BYE");
			}
			fclose($this->connection);
			$this->connection = 0;
			$this->state = "DISCONNECTED";
		}
	}

	/**
	 * ���ٵ����ʱ�򣬹ر�����
	 */
	public function __destruct(){
		$this->Close();
		echo $this->state;
	}
}




//$a = new imap_get_mail('imap.qq.com','2683692314','usitrip2012');
$a = new imap_get_mail('ssl://imap.gmail.com','service@usitrip.com','KLda$071233USI429','993');//557 û����Ϣ����
$a->set_debug(true);
$a->connection();
$total = $a->get_mail_totals();
$news = $a->get_unseen();
$arr = $a->unseen($total);
var_dump($arr);



/* $mb = imap_open("{imap.qq.com:143}inbox", "2683692314", "123456789");
$allheaders = imap_uid($mb);
imap_close($mb);
var_dump($allheaders);
 *//* echo "<pre>\n";
for ($i=0; $i < count($allheaders); $i++) {
echo $allheaders[$i]."<p><hr><p>\n";
}
echo "</pre>\n";  */

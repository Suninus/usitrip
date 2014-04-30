<?php 

class mail_receive_pop3{
	
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
	 * ������POP3�˿ڣ�һ����110�Ŷ˿�
	 * @var int
	 */
	private $port = 110;
	
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
	 * ָʾ��Ҫʹ�ü��ܷ�ʽ����������֤��һ�����������Ҫ
	 * @var boolean
	 */
	private $apop = false;
	
	/**
	 * �ʼ�����
	 * @var unknown_type
	 */
	private $messages;
	
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
	 * POP3��ʽ��ȡ�ʼ�
	 * @param string $hostname �ռ���ַ
	 * @param string $user ��¼�ʺ�
	 * @param string $pass ��¼����
	 * @param int $port �ռ��˿�
	 * @param int $time_out ��ʱʱ��
	*/
	public function __construct($hostname = "",$user = "", $pass = "", $port=110, $time_out=5) {
		$this->set_hostname($hostname);
		$this->set_port($port);
		$this->set_timeout($time_out);
		$this->set_user($user);
		$this->set_pass($pass);
	}
	
	/**
	 * �����ռ�POP��ַ
	 * eg: $hostname = 'pop.qq.com';
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
	 * �����ռ��˿ڣ�Ĭ����110
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
	 * ָʾ��Ҫʹ�ü��ܷ�ʽ����������֤��һ�����������Ҫ
	 * @param boolean $bool
	 */
	public function set_ssl($bool){
		if ($bool === true) {
			$this->apop = true;
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
		
		if(!$this->connection = fsockopen($this->hostname,$this->port,$this->err_no, $this->err_str, $this->timeout)) {
			
			$this->err_str="���ӵ�POP������ʧ�ܣ�������Ϣ��" . $this->err_str . "����ţ�" . $this->err_no;
			return false;
		} else {
			$this->get_resp();
			if($this->debug){
				$this->out_debug($this->resp);
			}
			if (substr($this->resp,0,3)!="+OK")	{
				$this->err_str="������������Ч����Ϣ��".$this->resp."����POP�������Ƿ���ȷ";
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
			$this->resp .= fgets($this->connection, 100);
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
		//�������Ƿ����APOP�û���֤
		if (!$this->apop) {
			if (!$this->command("USER $this->user", 3, "+OK")) {
				return false;
			}
			if (!$this->command("PASS $this->pass", 3, "+OK")){
				return false;
			}
		}else{
			if (!$this->command("APOP $this->user " . md5($this->pass), 3, "+OK")){
				return false;
			}
		}

		$this->state = "TRANSACTION"; // �û���֤ͨ�������봫��ģʽ
		return true;
	}

	/**
	 * ���ӷ�����
	 */
	private function connection(){
		if (!$this->open()) {
			return false;
		}
		if (!$this->login()){
			return false;
		}
		return true;
	}
	
	/**
	 * ȡ���ʼ������������ʼ����ܴ�С
	 * ͳ���ж����ʼ���һ�������ֽ�
	 * ���� array('mail_num'=>�ʼ�����,'mail_size'=>�ʼ��ܴ�С);
	 * ʧ���򷵻� false
	 * @return array | boolean
	 */
	public function get_mail_totals() {
		if($this->state!="TRANSACTION")	{
			if (!$this->connection()){
				$this->err_str="��û�����ӵ���������û�гɹ���¼";
				return false;
			}
		}

		if (!$this->command("STAT",3,"+OK")) {
			return false;
		} else {
			$this->resp=strtok($this->resp," ");
			$this->messages=strtok(" "); // ȡ���ʼ�����
			$this->size=strtok(" "); //ȡ���ܵ��ֽڴ�С
			//return true;
			return array('mail_num'=>$this->messages,'mail_size'=>$this->size);
		}
	}
	
	/**
	 * ��ȡ�����ʼ���Ψһ��ʶ��
	 * return array(array(0=>'�ʼ����',1=>'��ʶ��'[,array(0=>'�ʼ����',1=>'��ʶ��')[,...]]))
	 * @return boolean|array
	 */
	public function get_identifier_all(){
		if (count($this->mail_list) == 0) {
			if (!$this->get_list()){
				return false; 
			}
		}
		$rtn = array();
		foreach($this->mail_list as $val){
			$rtn[] = $this->get_identifier($val['num']);
		}
		return $rtn;
	}
	
	/**
	 * ��ȡ�ʼ�Ψһ��ʶ��
	 * ���� array(0=>'�ʼ����',1=>'��ʶ��')
	 * @param int $num �ʼ����
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
			$command = 'UIDL ' . $num;
			if (!$this->command("$command", 3, "+OK")) {
				return false;
			} else {
				//+OK 1 ZL1526-aXMdkHUdbptyqjV68F5hS26
				$rtn = explode(' ',$this->resp);
				array_shift($rtn);
				return $rtn;
			}
		}
		return false;
	}
	
	/**
	 * ȡ�õĸ����ʼ��Ķ�Ӧ������С
	 * ִ����ȷ���򷵻��ʼ��б������ʼ��źʹ�С,���򷵻�false
	 * ���� array(array('num'=>'�ʼ����','size'=>234234),array('num'=>'aaa','size'=>234234)...)
	 * @param int $num ��Ҫ��ȡ��С���ʼ���ţ�Ĭ��ȡ����
	 * @return array|boolean
	 */
	public function get_list($num = 0) {
		if($this->state!="TRANSACTION") {
			// ���û����������ȥ�ӽ�
			if (!$this->connection()){
				$this->err_str="��û�����ӵ���������û�гɹ���¼";
				return false;
			}
		}
		
		if ((int)$num > 0) {
			$command = "LIST " . $num;
			if (!$this->command($command, 3 ,"+OK")) {
				return false;
			} else {
				$rtn = explode(' ',$this->resp);
				array_shift($rtn);
				return array('num'=>$rtn[0],'size'=>$rtn[1]);
			}
		} else {
			$command="LIST ";
		}
		
		if (!$this->command($command, 3, "+OK")) {
			return false;
		} else {
			$i=0;
			$this->mail_list=array();
			$this->get_resp();
			while ($this->resp!=".")
			{
				$i++;
				if ($this->debug){
					$this->out_debug($this->resp);
				}
				
				/* strtok ����Ƿָ��ַ���
				 * ���ո�һ��ȡ�ַ�����ǰһ�����ݣ�eg:
				* $str = 'a b c';
				* strtok($str,' ') ����a; �ټ��� strtok(' '); �򷵻�B��ע�� �ڶ��� ����Ҫ�ٴ���ԭʼ�ַ�����
				*/
				$this->mail_list[$i]['num'] = intval(strtok($this->resp," "));
				$this->mail_list[$i]['size'] = intval(strtok(" "));
				$this->get_resp();
			}
			return $this->mail_list;
		}
	}
	
	/**
	 * ��ȡ�������ϵ������ʼ�
	 * @return array
	 */
	public function get_mail_all(){
		if (count($this->mail_list) == 0) {
			if (!$this->get_list()) {
				return false;
			}
		}
		$rtn = array();
		foreach($this->mail_list as $val){
			$rtn[] = $this->get_mail($val['num']);
		}
		return $rtn;
	}
	
	/**
	 * ȡ���ʼ������ݣ�$num���ʼ�����ţ�$line��ָ����ȡ�����ĵĶ����С���Щʱ�����ʼ��Ƚϴ������ֻ���Ȳ鿴�ʼ�������ʱ�Ǳ���ָ�������ġ�
	 * Ĭ��ֵ$line=-1����ȡ�����е��ʼ����ݣ�ȡ�õ����ݴ�ŵ��ڲ�����$head��$body����������������ÿһ��Ԫ�ض�Ӧ�����ʼ�Դ�����һ�С�
	 * ����ɹ����򷵻�һ�����飬���򷵻�FALSE
	 * @param int $num �ʼ������
	 * @param int $line ȡ�ʼ��Ķ����� Ĭ��ȫ�� ���������ʼ�
	 * @return array | boolean
	 */
	public function get_mail($num=1,$line=-1) {
		if($this->state!="TRANSACTION")	{
			/*$this->err_str="������ȡ�ż�����û�����ӵ���������û�гɹ���¼";
			return false;*/
			// ���û����������ȥ�ӽ�
			if (!$this->connection()){
				$this->err_str="��û�����ӵ���������û�гɹ���¼";
				return false;
			}
		}
		if ($line<0) {
			$command="RETR $num";
		} else {
			$command="TOP $num $line";
		}
		$rtn = array('head'=>'','body'=>'');
		if (!$this->command("$command",3,"+OK")) {
			return false;
		} else {
			$this->get_resp();
			$is_head=true;
			// . �����ʼ������ı�ʶ
			$rtn = array();
			while ($this->resp!=".") {
				if ($this->debug) {
					$this->out_debug($this->resp);
				}
				if (substr($this->resp,0,1)==".") {
					$this->resp=substr($this->resp,1,strlen($this->resp)-1);
				}
				// �ʼ�ͷ�����Ĳ��ֵ���һ������
				/*if (trim($this->resp)=="") {
					$is_head=false;
				}
				if ($is_head) {
					//$this->head[]=$this->resp;
					$rtn['head'][] = $this->resp;
				} else {
					//$this->body[]=$this->resp;
					$rtn['body'][] = $this->resp;
				}*/
				$rtn[] = $this->resp . "\r\n";
				$this->get_resp();
			}
			//return true;
			return $rtn;
		}
	}
			
	/**
	 * ɾ��ָ����ŵ��ʼ���$num �Ƿ������ϵ��ʼ����
	 * @param unknown_type $num
	 * @return boolean
	 */
	public function dele($num) {
		if($this->state!="TRANSACTION") {
			$this->err_str="����ɾ��Զ���ż�����û�����ӵ���������û�гɹ���¼";
			return false;
		}
		
		if (!$num) {
			$this->err_str="ɾ���Ĳ�������";
			return false;
		}

		if ($this->command("DELE $num ",3,"+OK")) {
			return true;
		} else {
			return false;
		}
	}

	//ͨ�����ϼ��������������Ѿ�����ʵ���ʼ��Ĳ鿴����ȡ��ɾ���Ĳ������������������Ҫ�˳������ر�������������ӣ�������������������
	/**
	 * ���Ҫ�˳������ر��������������
	 */
	public function Close()	{
		if($this->connection!=0) {
			if($this->state=="TRANSACTION"){
				$this->command("QUIT", 3, "+OK");
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
	}
}

/*
$host="pop.qq.com";
$user="2683692314@qq.com";
$pass="123456789";
*/




//$rec = new pop3_get_mail($host,$user,$pass);
//$rec->set_debug(true);
//$mail_count = $rec->get_mail_totals();
//print_r($mail_count);
//$list = $rec->get_list();
//print_r($list);
//$rtn = $rec->get_mail(50);
//$indent_arr = $rec->get_identifier(49);
//$rec->get_list(1);
/*$mail_arr = $rec->get_mail_all();
foreach($mail_arr as $key => $val){
	$content = join("\r\n", $val['head']) . "\r\n" . join("\r\n", $val['body']);
	echo $val['indentifier'] . "<br/>";
	file_put_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . $val['indentifier'] . '.eml', $content);
}*/
/*$email_content = $rec->get_mail(49);
$content = join("\r\n",$email_content['head']) . "\r\n" . join("\r\n",$email_content['body']);
file_put_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . $indent_arr[1] . '.eml',$content);
*/
//print_r($rtn);


/* $html = join("\n",$rtn['head']);
$html .= join("\n",$rtn['body']);
echo $html; */
/*
$rec=new pop3($host,110,2);
if (!$rec->open()) die($rec->err_str);
echo "open ";
if (!$rec->login($user,$pass)) die($rec->err_str);
echo "login";
if (!$rec->stat()) die($rec->err_str);
echo "����".$rec->messages."���ż�����".$rec->size."�ֽڴ�С<br>";
if($rec->messages>0)
{
	if (!$rec->listmail()) die($rec->err_str);
	echo "�������ż���<br>";

	for ($i=1;$i<=count($rec->mail_list);$i++)
	{
	echo "�ż�".$rec->mail_list[$i][num]."��С��".$rec->mail_list[$i][size]."<BR>";
	}

	$rec->getmail(1);
	echo "�ʼ�ͷ�����ݣ�<br>";
	for ($i=0;$i<count($rec->head);$i++)
	echo htmlspecialchars($rec->head[$i])."<br>\n";

	echo "�ʼ����ġ���<BR>";
    for ($i=0;$i<count($rec->body);$i++)
	echo htmlspecialchars($rec->body[$i])."<br>\n";
}
$rec->close();
*/
?>
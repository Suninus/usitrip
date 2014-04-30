<?php
/**
 * ���ݿ�ͬ����飬���ļ��ɷŵ�����������ʱִ�У�����ÿ��10������һ�Ρ�
 * @author Howard
 */
class dbRsyncCheck{
	/**
	 * �����ݿ���Դ
	 */
	private $dbM;
	/**
	 * �����ݿ���Դ
	 */	
	private $dbS;
	/**
	 * ���������ĵ�¼��Ϣ
	 */
	private $master;
	/**
	 * �ӷ������ĵ�¼��Ϣ
	 */
	private $slave;
	/**
	 * ��ʼ��ʱ�����������ݿ���˺š���¼����Ϣ
	 * @param array $dbInfo ���ݿ��¼������������ϣ�master�������ݿ�ģ�slave�Ǵ����ݿ��
	 */
	public function __construct(array $dbInfo){
		$this->master = $dbInfo['master'];
		$this->slave = $dbInfo['slave'];
		$this->logTextEnd = $this->master['host'].' to '.$this->slave['host'];
		//��������
		$this->dbM = new mysqli($this->master['host'], $this->master['user'], $this->master['passwd'], $this->master['dbname'], $this->master['port']);
		if ($this->dbM->connect_error) {
			die('db_m Connect Error: ' . $this->dbM->connect_error);
		}		
		$this->dbM->query('set names '.$this->dbM->character_set_name());
		//�ӿ�����
		$this->dbS = new mysqli($this->slave['host'], $this->slave['user'], $this->slave['passwd'], $this->slave['dbname'], $this->slave['port']);
		if ($this->dbS->connect_error) {
			die('db_m Connect Error: ' . $this->dbS->connect_error);
		}
		$this->dbS->query('set names '.$this->dbS->character_set_name());
		
	}
	/**
	 * ȡ�������ݿ��״̬��Ϣ�����ض���
	 * @return ����
	 */
	public function getMasterInfo(){
		$m = $this->dbM->query('show master status');
		$rows = $m->fetch_object();
		//echo $rows->File."<br>";
		//echo $rows->Position;
		//print_r($rows);
		//exit;
		return $rows;
	}
	/**
	 * ȡ�ô����ݿ��ͬ��״̬��Ϣ�����ض���
	 * @return ����
	 */
	public function getSlaveInfo(){
		$s = $this->dbS->query('show slave status');
		$rows = $s->fetch_object();
		//echo $rows->Slave_IO_Running;
		//echo $rows->Slave_SQL_Running;
		//echo $rows->Relay_Master_Log_File;
		return $rows;
	}
	
	/**
	 * ��ʼ����ͬ�����
	 * @return boolean �����ⷵ��������Ϣ���飬�����ͷ��ؼ�
	 */
	public function check(){
		$error = false;
		$msg = '';
		$mInfo = $this->getMasterInfo();
		$sInfo = $this->getSlaveInfo();
		switch (true){
			case $mInfo->File != $sInfo->Relay_Master_Log_File:
				$error = true;
				$msg = ('������־�ļ���һ�£�����['.$mInfo->File.'] �ӣ�['.$sInfo->Relay_Master_Log_File.']['.$sInfo->Master_Log_File.']');
			break;
			case strtoupper($sInfo->Slave_IO_Running)!='YES':
				$error = true;
				$msg = ('���ݿ�ͬ���Ѿ�ֹͣIO���У�');
			break;
			case strtoupper($sInfo->Slave_SQL_Running)!='YES':
				$error = true;
				$msg = ('���ݿ�ͬ���Ѿ�ֹͣSQL���У�');
			break;
			case $sInfo->Last_IO_Errno > 0:
				$error = true;
				$msg = ('���ݿ�ͬ���������:'.$sInfo->Last_IO_Error);
			break;
			case $sInfo->Last_SQL_Errno > 0:
				$msg = ('���ݿ�SQL������:'.$sInfo->Last_SQL_Error);
			break;
			case $sInfo->Read_Master_Log_Pos != $mInfo->Position :
				$done_rate = round($sInfo->Read_Master_Log_Pos/$mInfo->Position, 4)*100;
				if($done_rate < 99.9){	//�ݶ������С��99.9%ʱ����Ϊ������û����
					$error = true;				
					$msg = ('������ͬ��δ���ϣ�Position��'.$mInfo->Position.'��Read_Master_Log_Pos��'.$sInfo->Read_Master_Log_Pos.'������ʣ�'.$done_rate.'%');
				}
				if($done_rate < 99.5){	//С��99.5ʱ��Ҫ�������������ݿ��ͬ������
					$this->slaveRestart();
					$error = true;
					$msg = ('ͬ������'.$done_rate.'%̫��������ͬ��������');
				}
			break;
			default:break;
		}
		
		if($error === true){
			$msg.=$this->logTextEnd;
			$this->writeLog($msg);
			return array('error'=>'1', 'error_msg'=>$msg);
		}
		return false;
	}
	/**
	 * д������־��¼����Ҫ��д������������db_rsync_check_log���ݿ���
	 * @param string $logText ��־����
	 */
	public function writeLog($logText = ''){
		$db = new mysqli($this->master['host'], $this->master['user'], $this->master['passwd'], 'db_rsync_check_log', $this->master['port']);
		$db->query('set names '.$db->character_set_name());
		$query = 'INSERT INTO `error_log` (`add_time` ,`text`) VALUES ("'.date('Y-m-d H:i:s').'", "'.$db->real_escape_string($logText).'");';
		$db->query($query);
		$db->close();
		//echo $logText.PHP_EOL;
	}
	/**
	 * ����ϵͳ�ʼ���֪ͨϵͳ����Ա
	 * @param string $to ���������ַ
	 * @param string $subject �ʼ�����
	 * @param string $message �ʼ�����
	 */
	public function emailToAdmin($to, $subject='���ݿ�ͬ���쳣', $message='���ݿ�ͬ���쳣'){
		$date = date('Y-m-d H:i:s');
		$subject.= $date;
		$message.= "\n".$date;
		$message = wordwrap($message, 70);
		mail($to, $subject, $message);
	}
	/**
	 * �������������ݿ��ͬ������
	 * ע�⣺ֻ����������ͬ��δ����ʱ�����
	 */
	private function slaveRestart(){
		$this->dbS->query('stop slave;');
		$this->dbS->query('slave start;');
		return 1;
	}
	
	public function __destruct(){
		$this->dbM->close();
		$this->dbS->close();
	}
}

/**
 * һЩ���ܼ�
 * @author Howard Administrator
 */
class sys{
	/**
	 * ȡ��������ģʽ�µ�GET����
	 * @param unknown_type $args
	 * @return multitype:boolean unknown Ambigous <>
	 */
	public static function getArgs($args) {
		$out = array();
		$last_arg = null;
		for($i = 1, $il = sizeof($args); $i < $il; $i++) {
			if( (bool)preg_match("/^--(.+)/", $args[$i], $match) ) {
				$parts = explode("=", $match[1]);
				$key = preg_replace("/[^a-z0-9]+/", "", $parts[0]);
				if(isset($parts[1])) {
					$out[$key] = $parts[1];
				}
				else {
					$out[$key] = true;
				}
				$last_arg = $key;
			}
			else if( (bool)preg_match("/^-([a-zA-Z0-9]+)/", $args[$i], $match) ) {
				for( $j = 0, $jl = strlen($match[1]); $j < $jl; $j++ ) {
					$key = $match[1]{$j};
					$out[$key] = true;
				}
				$last_arg = $key;
			}
			else if($last_arg !== null) {
				$out[$last_arg] = $args[$i];
			}
		}
		return $out;
	}
}


/**
 * �߼��ж�
 * @author Howard Administrator
 */
class start{
	public function __construct($_SERVER){
		$args = sys::getArgs($_SERVER['argv']);
		
		if(isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR']){
			$masterHost = $_SERVER['SERVER_ADDR'];
		}elseif($args['host']){
			$masterHost = $args['host']; 
		}else{
			die('������������');
		}
		
		$ip0 = '120.136.45.200';
		$ip1 = '113.106.94.150';
		if($masterHost==$ip0){
			$slaveHost = $ip1;
		}elseif($masterHost==$ip1){
			$slaveHost = $ip0;
		}else{
			die('��ЧIP��');
		}
		
		$db = array('master'=>array('host'=>$masterHost, 'user'=>'zhhrsync2013', 'passwd'=>'2013rsynczhh2099', 'dbname'=>'usitrip_com', 'port'=>'3306'), 
					'slave' =>array('host'=>$slaveHost, 'user'=>'zhhrsync2013', 'passwd'=>'2013rsynczhh2099', 'dbname'=>'usitrip_com', 'port'=>'3306'));
		$c = new dbRsyncCheck($db);
		
		$errors = $c->check();
		if($errors === false){
			$c->writeLog('����');	
		}else{
			$c->emailToAdmin('Howard Zhou <2355652776@qq.com>', '���ݿ�ͬ���쳣', '���ݿ�ͬ���쳣����ȥ'.$masterHost.'���ݿ�db_rsync_check_log�鿴��־��������Ϣ���£�'."\n".$errors['error_msg']);
		}
	}
}
new start($_SERVER);

?>
<?php
/**
 * ���Ͷ�����(���ʶ���hi8d)
 * @example
 *  //�������ǵ����ݿ��������
 *  require('includes/application_top.php');
 *  session_start();
 *  // ���÷�������
 *  require('includes/classes/ensms.php');
 *  try {
 *  // ֱʵ�ķ��͵�ַ
 *  //$a = new ensms('usitrip','a63b4be2106e3128057cae3ab7a6e2e4','http://www.sms01.com/ensms/servlet/WebSend','http://www.sms01.com/ensms/servlet/BalanceService',true);	
 *  // ���Ե�ַ
 *  $a = new ensms('usitrip','a63b4be2106e3128057cae3ab7a6e2e4','http://192.168.1.86/lvtu/ensms/servlet/WebSend','http://192.168.1.86/lvtu/ensms/servlet/BalanceService',true);
 *  // ����ǽ��շ���״̬��ҳ�棬���ж��Ƿ��з�������
 *  if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
 *  	// ��¼���صķ���״̬
 *  	$a->checkMsg($GLOBALS['HTTP_RAW_POST_DATA']);
 *  } else {
 *  	// ���Ͷ��� �з���ֵ ���ط��ͺ� ���ͷ����ص��ַ���
 *  	$rets = $a->addMsg('�ٲ���һ���Ҹշ��������ֱ�������ֻ����Զ��ŷ��ͣ�','gb2312')->send('8618098916029,8615013502817');
 *		
 *	}
 *	// ��ʾ��ǰ���
 *	echo $a->getBalance();
 * } catch (Exception $e) {
 *	echo $e->getMessage();
 * }
 * @author lwkai 2013-1-23 ����2:51:00
 *
 */
class ensms {
	
	/**
	 * �ʺ�
	 * @var string
	 * @author lwkai 2013-1-10 ����1:20:08
	 */
	private $_user = '';
	
	/**
	 * ����
	 * @var string
	 * @author lwkai 2013-1-10 ����1:20:27
	 */
	private $_pass = '';
	
	/**
	 * ����ѯ�ӿڵ�ַ
	 * @var string
	 * @author lwkai 2013-1-10 ����1:21:08
	 */
	private $_balance_url = '';
	
	/**
	 * ������Ϣ�ӿڵ�ַ
	 * @var string
	 * @author lwkai 2013-1-23 ����11:09:04
	 */
	private $_send_url = '';
	
	/**
	 * URL������Ĳ���
	 * @var array
	 * @author lwkai 2013-1-10 ����3:57:05
	 */
	private $_param = array();
	
	/**
	 * ���͵�GB2312����Ķ�������
	 * @var string
	 * @author lwkai 2013-1-23 ����12:16:31
	 */
	private $_content = '';
	
	/**
	 * ���ݿ����
	 * @var ensmsdb
	 * @author lwkai 2013-1-23 ����12:00:40
	 */
	private $_db = null;
	
	/**
	 * ��ʼ�������ŵ���
	 * @param string $user �ʺ�
	 * @param string $pass ����
	 * @param string $send_url ���Ͷ��ŵ�URL
	 * @param string $balance_url ��ѯ����URL
	 * @param boolean $md5 �����Ƿ��Ѿ�ͨ��MD5����
	 * @throws Exception
	 * @author lwkai 2013-1-23 ����3:04:30
	 */
	public function __construct($user='usitrip',$pass='a63b4be2106e3128057cae3ab7a6e2e4',$send_url='http://www.sms01.com/ensms/servlet/WebSend',$balance_url='http://www.sms01.com/ensms/servlet/BalanceService',$md5 = true) {
		$md5 = !!$md5;
		if ($user && $pass && $send_url && $balance_url) {
			$this->_user = $user;
			$this->_pass = $md5 ? $pass : md5($md5);
			$this->_send_url = in_array(substr($send_url,0,5), array("http:","https")) ? $send_url : "http://" . $send_url;
			$this->_balance_url = in_array(substr($balance_url,0,5), array('http:','https')) ? $balance_url : 'http://' . $balance_url;
			$this->_db = new ensmsdb();
		} else {
			throw new Exception('��������������');
		}
	}
	
	/**
	 * ��URL��������
	 * @param unknown_type $url
	 * @return string
	 * @author lwkai 2013-1-23 ����2:58:54
	 */
	private function getInfo($url){
		/*$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		$cache = curl_exec ($ch);
		curl_close ($ch);
		//file_put_contents('/tmp/ensms.php.txt', $url . "\n\n" . $cache,FILE_APPEND);
		return (string)$cache;*/
		$str = file_get_contents($url);
		return $str;
	}
	
	/**
	 * ���URL
	 * @param string $url ��ʲô�����URL
	 * @return string
	 * @author lwkai 2013-1-11 ����11:21:08
	 */
	private function assemblyUrl($url) {
		$url .= '?userId=' . $this->_user . '&password=' . $this->_pass;
		foreach ($this->_param as $key => $val) {
			$url .= '&' . $key . '=' . urlencode(preg_replace("/\r|\n/","",$val));
		}
		return $url;
	}
	
	/**
	 * ȡ�õ�ǰ���
	 * @return string
	 * @author lwkai 2013-1-23 ����9:57:46
	 */
	public function getBalance() {
		$myGet = array();
		//$str = 'rspCode=0&rspDesc=��ѯ�ɹ�&balance=199160';
		$str = $this->getInfo($this->assemblyUrl($this->_balance_url));
		//print_r($str);
		$str = explode('&', $str);
		foreach ($str as $key => $val) {
			$tmp = explode('=', $val);
			$myGet[$tmp[0]] = isset($tmp[1]) ? $tmp[1] : '';
		}
		$balance = $myGet['balance'] / 1000;
		return $balance . 'Ԫ';
	}
	
	/**
	 * ���Ҫ���͵���Ϣ
	 * @param string $msg Ҫ���͵���Ϣ����
	 * @param string $msg_charset ���͵���Ϣ���ֱ���
	 * @return ensms
	 * @author lwkai 2013-1-23 ����10:12:16
	 */
	public function addMsg($msg,$msg_charset = 'gb2312') {
		$this->_param['content'] = iconv($msg_charset,'utf-8//IGNORE',$msg).iconv('gb2312','utf-8//IGNORE',"������ֱ�ӻظ������ķ�����");
		$this->_content = $msg_charset == 'gb2312' ? $msg : iconv($msg_charset,'gb2312//IGNORE',$msg);
		return $this;
	}
	
	/**
	 * ������Ϣ
	 * @param string $mobile ���͸��ĸ����룬֧�ֶ���ţ��ö��Ÿ���
	 * @return array
	 * @author lwkai 2013-1-23 ����10:13:15
	 */
	public function send($mobile) {
		$rtn = '';
		$mobile = str_replace('��',',',$mobile);
		$arr = explode(',',$mobile);
		$url = $this->assemblyUrl($this->_send_url);
		$temp = $this->getInfo($url . '&mobile=' . $mobile);
		preg_match("/msgId=(\d+)/", $temp,$match);
		$rtn = $match[1];
		foreach ($arr as $key => $val) {
			$this->_db->insertMsg($match[1], $this->_content, $val); 
		}
		$this->_param = array();
		$this->_content = '';
		return $rtn;
	}
	
	/**
	 * ������Ϣ���ͷ����͹����ķ��ͽ��
	 * <?xml version="1.0" encoding="utf-8"?>
	 * <reports>
	 * <report>
	 *	<userId>test</userId>
	 *	<msgId>001</msgId>
	 *	<mobile>13434343434</mobile>
	 *	<status>2</status>
	 * </report>
	 * <report>
	 *	<userId>test</userId>
	 *	<msgId>002</msgId>
	 *	<mobile>13434343435</mobile>
	 *	<status>1</status>
	 * </report>
	 * </reports>';
	 * @param string $text ���͹������ַ�����
	 * @author lwkai 2013-1-23 ����10:49:48
	 */
	public function checkMsg($text) {
		if (empty($text)) return;
		$xml = simplexml_load_string($text);
		foreach($xml->report as $key=>$val) {
			//echo $val->msgId . '<br/>';
			if ($val->userId != $this->_user) {
				//throw new Exception('���صĲ��������ʺŵ���Ϣ��');
			} else {
				$this->_db->checkMsg($val->msgId, $val->mobile, $val->status);
			}
		}
	}
}

class ensmsdb {
	
	/**
	 * ��ӷ��͵Ķ��ŵ���
	 * @param string $id ���������ص���ϢID
	 * @param string $msg ���͵���Ϣ����
	 * @param string $mobile ���յ��ֻ�����
	 * @author lwkai 2013-1-23 ����1:21:10
	 */
	public function insertMsg($id,$msg,$mobile){
		$data = array();
		$data['msg_id'] = $id;
		$data['to_phone'] = $mobile;
		$data['to_content'] = $msg;
		$data['add_date'] = date('Y-m-d H:i:s');
		$rtn = tep_db_perform('cpunc_sms_hi8d_history',$data);
	}
	
	/**
	 * ���뷢�ͽ��
	 * @param string $msg_id ��ϢID
	 * @param string $mobile �ֻ���
	 * @param string $status ����״̬
	 * @author lwkai 2013-1-23 ����1:20:08
	 */
	public function checkMsg($msg_id,$mobile,$status) {
		$data = array();
		$data['msg_status'] = strtoupper($status) == 'DELIVRD' ? 0 : $status;
		$data['check_data'] = date('Y-m-d H:i:s');
		$rtn = tep_db_perform('cpunc_sms_hi8d_history', $data,'update'," msg_id='" . $msg_id . "' and to_phone='" . $mobile . "'");
	}
}

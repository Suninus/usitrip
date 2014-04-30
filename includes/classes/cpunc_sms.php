<?php
require_once(DIR_FS_CATALOG.'includes/nusoaplib/nusoap.php');

/**
 * ��֤���̸�Ҫ:https://www.b2m.cn/
 * 
 * ��һ��ʹ��ʱ����ʹ��[���к�]��[����]����login(��¼����),���ڵ�¼ͬʱ����һ��session key
 * 
 * ��¼�ɹ��󣬳�Ϊ[�ѵ�¼״̬],��Ҫ����˲�����session key,�����Ժ����ز���(�緢�Ͷ��ŵȲ���)
 * 
 * logout(ע������)��, session key��ʧЧ�����Ҳ����ٷ�������, �����ٽ���login(��¼����)
 * 
 */
class cpunc_SMS{
	
	/**
	 * ���ص�ַ
	 */
	//var $url = 'http://sdk999ws.eucp.b2m.cn:8080/sdk/SDKService';
	var $url = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService?wsdl';
	
	/**
	 * ���к�,��ͨ������������Ա��ȡ
	 * 0SDK-EBB-0130-NERNP
	 */
	var $serialNumber = '3SDK-EMY-0130-NHZNM';
	
	/**
	 * ����,��ͨ������������Ա��ȡ
	 * 953836
	 */
	var $password = '254816';
	
	/**
	 * ��¼�������е�SESSION KEY������ͨ��login����ʱ����
	 */
	var $sessionKey = '621163';

	/**
	* ���ӳ�ʱʱ�䣬��λΪ�룬Ĭ��0��Ϊ����ʱ
	*/
	var $timeout = 2;
	
	/**
	* Զ����Ϣ��ȡ��ʱʱ�䣬��λΪ�룬Ĭ��30
	*/ 
	var $response_timeout = 10;
	
	/**
	$proxyhost		��ѡ�������������ַ��Ĭ��Ϊ false ,��ʹ�ô��������
	$proxyport		��ѡ������������˿ڣ�Ĭ��Ϊ false
	$proxyusername	��ѡ������������û�����Ĭ��Ϊ false
	$proxypassword	��ѡ��������������룬Ĭ��Ϊ false
	*/	
	var $proxyhost = false;
	var $proxyport = false;
	var $proxyusername = false;
	var $proxypassword = false; 
	
	/**
	 * webservice�ͻ���
	 */
	var $soap;
	
	/**
	 * Ĭ�������ռ�
	 */
	var $namespace = 'http://sdkhttp.eucp.b2m.cn/';
	
	/**
	 * ���ⷢ�͵����ݵı���,Ĭ��Ϊ GB2312
	 */
	var $outgoingEncoding = "GB2312";
	
	/**
	 * ���ڽ��ܵ����ݵı���,Ĭ��Ϊ GB2312
	 */
	var $incomingEncoding = '';
	
	
	function cpunc_SMS()
	{
		//$this->serialNumber = urlencode(CPUNC_ID);
		//$this->password = urlencode(CPUNC_PWD);
		/**
		 * ��ʼ�� webservice �ͻ���
		 */	
		$this->soap = new nusoap_client($this->url,false,$this->proxyhost,$this->proxyport,$this->proxyusername,$this->proxypassword,$this->timeout,$this->response_timeout); 
		$this->soap->soap_defencoding = $this->outgoingEncoding;
		$this->soap->decode_utf8 = false;
	}
	
	/**
	 * ���÷������� ���ַ�����
	 * @param string $outgoingEncoding ���������ַ�������
	 */
	function setOutgoingEncoding($outgoingEncoding)
	{
		$this->outgoingEncoding = $outgoingEncoding;
		$this->soap->soap_defencoding = $this->outgoingEncoding;
	}
	
	/**
	 * ���ý������� ���ַ�����
	 * @param string $incomingEncoding ���������ַ�������
	 */
	function setIncomingEncoding($incomingEncoding)
	{
		$this->incomingEncoding = $incomingEncoding;
		$this->soap->xml_encoding = $this->incomingEncoding;
	}
	
	function setNameSpace($ns)
	{
		$this->namespace = $ns;
	}
	
	function getSessionKey()
	{
		return $this->sessionKey;
	}
	
	function getError()
	{		
		return $this->soap->getError();
	}
	
	/**
	 * 
	 * ָ��һ�� session key �� ���е�¼����
	 * 
	 * @param string $sessionKey ָ��һ��session key 
	 * @return int �������״̬��
	 * 
	 * ������:
	 * 
	 * $sessionKey = $cpunc_sms->generateKey(); //�������6λ�� session key
	 * 
	 * if ($cpunc_sms->login($sessionKey)==0)
	 * {
	 * 	 //��¼�ɹ������������� $sessionKey �Ĳ����������Ժ���ز�����ʹ��
	 * }else{
	 * 	 //��¼ʧ�ܴ���
	 * }
	 * 
	 * 
	 */
	function login($sessionKey='')
	{
				
		if ($sessionKey!='')
		{
			$this->sessionKey = $sessionKey;
		}
		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey, 'arg2'=>$this->password);
		$result = $this->soap->call("registEx",$params,	$this->namespace);
		return $result;
	}
	
	/**
	 * ע������  (ע:�˷�������Ϊ�ѵ�¼״̬�·��ɲ���)
	 * 
	 * @return int �������״̬��
	 * 
	 * ֮ǰ�����sessionKey��������
	 * ����Ҫ��������login
	 */
	function logout()
	{
		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey);
		print_r($params); 
		$result = $this->soap->call("logout", $params ,
			$this->namespace
		);

		return $result;
	}
	
	/**
	 * ��ȡ�汾��Ϣ
	 * @return string �汾��Ϣ
	 */
	function getVersion()
	{
		$result = $this->soap->call("getVersion",
			array(),
			$this->namespace
		);
		return $result;
	}
	
	/**
	 * ��¼�ѷ��͵���Ϣ�����ݿ�
	 *
	 * @param string $phone
	 * @param string $content
	 * @param string $return_code
	 * @param string $type
	 * @param datetime $datetime
	 * @return ���ر����������idֵ
	 */
	function saveSMS($phone, $content, $return_code, $type='b2m.cn-send', $datetime=''){
		if($datetime==''){$datetime = date('Y-m-d H:i:s');}
		$phone = tep_db_input($phone);
		$content = tep_db_input($content);
		$type = tep_db_input($type);
		$return_code = tep_db_input($return_code);
		$data_array = array('to_phone'=>$phone, 'to_content'=> $content, 'to_type'=> $type, 'return_code'=> $return_code, 'add_date'=> $datetime);
		tep_db_perform('`cpunc_sms_history`', $data_array);
		return tep_db_insert_id();
	}
	
	/**
	 * ���������ݿ�
	 *
	 */
	function upBalance(){
		$_value = $this->getBalance();
		$balance_value = "&#65509;".$_value;
		$today = date('Y-m-d H:i:s');
		tep_db_query('update configuration SET configuration_value="'.tep_db_input($balance_value).'",last_modified="'.$today.'" WHERE configuration_key="CPUNC_BALANCE" ');
	}
	
	/**
	 * ���ŷ���  (ע:�˷�������Ϊ�ѵ�¼״̬�·��ɲ���)
	 * 
	 * @param string $strMobile		�ֻ���, ������ö���(,)���� 
	 * @param string $content		��������
	 * @param string $charset 		�����ַ���, Ĭ��GB2312
	 * @param string $sendTime		��ʱ����ʱ�䣬��ʽΪ yyyymmddHHiiss, ��Ϊ ����������������ʱʱ�ַ�����,����:20090504111010 ����2009��5��4�� 11ʱ10��10�룬�������Ҫ��ʱ���ͣ���Ϊ'' (Ĭ��)
	 * @param string $addSerial 	��չ��, Ĭ��Ϊ ''
	 * @param int $priority 		���ȼ�, Ĭ��5
	 * @param int $smsId 			��Ϣ����ID(Ψһ��������)
	 * @return int ��ʧ�ܷ��ز������״̬��0���ɹ��򷵻ر����뵽��ʷ��¼���е�����idֵ
	 */
	function SendSMS($strMobile,$content,$charset='GB2312',$sendTime='',$addSerial='',$priority=5,$smsId=8888)
	{
		if(!defined('CPUNC_SWITCH') || CPUNC_SWITCH !='true'){ return false; }	//�ܿ���
		//if(!defined('CPUNC_ID') || !defined('CPUNC_PWD') ){ return false; }
		$strMobile = str_replace(' ','',$strMobile);
		//����ֻ������Ƿ���ָ����Χ start
		if(defined('CPUNC_PHONE_NUMBER_HEADER') && CPUNC_PHONE_NUMBER_HEADER!=""){
			$numbers_header = explode(',',CPUNC_PHONE_NUMBER_HEADER);
			$numbers = explode(',',$strMobile);
			$strMobile = '';
			$strMobiles = array();
			for($i=0; $i<count($numbers); $i++){
				for($j=0; $j<count($numbers_header); $j++){
					if(preg_match('/^'.preg_quote($numbers_header[$j]).'/',$numbers[$i])){
					$strMobiles[]= $numbers[$i];
					break;
					}else{
						$split_h = explode('-',$numbers_header[$j]);
						if(count($split_h)==2){
							$substr_num = substr($numbers[$i],0,strlen($split_h[0]));
							if($substr_num>=$split_h[0] && $substr_num<=$split_h[1]){
							  $strMobiles[]= $numbers[$i];
							  break;
							}
						}
					}
				}
			}
			$strMobiles = array_unique($strMobiles);
			$strMobile = implode(',',$strMobiles);
		}else{
			$strMobiles = explode(',',$strMobile);
			$strMobiles = array_unique($strMobiles);
			$strMobile = implode(',',$strMobiles);
		}
		//����ֻ������Ƿ���ָ����Χ end
		
		//�Ƴ������˵ĺ���start
		if(defined('CPUNC_PHONE_FLITER_NUMBERS') && CPUNC_PHONE_FLITER_NUMBERS!=""){
			$f = ereg_replace('[:space:]','',CPUNC_PHONE_FLITER_NUMBERS);
			$f = explode(',',$f);
			$strMobiles = explode(',',$strMobile);
			$strMobiles = array_diff($strMobiles,$f);
			$strMobile = implode(',',$strMobiles);
		}
		//�Ƴ������˵ĺ���end
		
		if($strMobile==''){
			return false;
		}
		/*
		if(defined('CPUNC_TEST_STATUS') && CPUNC_TEST_STATUS=='true'){
			echo $strMobile. ' on testing, You can change test status it on back admin!';
			exit;
		}*/
		
		//�ֻ��ţ��� array('159xxxxxxxx')�� �����Ҫ����ֻ���Ⱥ��,�� array('159xxxxxxxx','159xxxxxxx2')
		$mobiles = explode(',', $strMobile);
		$content = iconv($charset, "GB2312//IGNORE", $content);
		$content .= "������ֱ�ӻظ������ķ�����";
		
		/**
		 * ������뷢�͵�xml���ݸ�ʽ�� 
		 * <arg3>159xxxxxxxx</arg3>
		 * <arg3>159xxxxxxx2</arg3>
		 * ....
		 * ������Ҫ����ĵ�������
		 * 
		 */
		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey,'arg2'=>$sendTime,
			'arg4'=>$content,'arg5'=>$addSerial, 'arg6'=>$charset,'arg7'=>$priority,'arg8'=>$smsId
		);
		foreach($mobiles as $mobile)
		{
			array_push($params,new soapval("arg3",false,$mobile));	
		}
		$result = $this->soap->call("sendSMS",$params,$this->namespace);
		$error = $this->soap->getError();
		
		$key_id = $this->saveSMS($strMobile, $content, $result);
		$this->upBalance();
		
		if($result!=null && $result=="0"){	//���ͳɹ�
			return $key_id; //true;
		}elseif(CPUNC_SHOW_ERROR_AND_STOP=='true'){
			echo $error; exit;
		}
		return false;
	}
	
	/**
	 * ����ѯ  (ע:�˷�������Ϊ�ѵ�¼״̬�·��ɲ���)
	 * @return double ���
	 */
	function getBalance()
	{
		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey);
		$result = $this->soap->call("getBalance",$params,$this->namespace);
		return $result;
	}
	
	/**
	 * ȡ������ת��  (ע:�˷�������Ϊ�ѵ�¼״̬�·��ɲ���)
	 * @return int �������״̬��
	 */
	function cancelMOForward()
	{
		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey);
		$result = $this->soap->call("cancelMOForward",$params,$this->namespace);
		return $result;
	}
	
	/**
	 * ���ų�ֵ  (ע:�˷�������Ϊ�ѵ�¼״̬�·��ɲ���)
	 * @param string $cardId [��ֵ������]
	 * @param string $cardPass [����]
	 * @return int �������״̬��
	 * 
	 * ��ͨ������������Ա��ȡ [��ֵ������]����Ϊ20�� [����]����Ϊ6
	 */
	function chargeUp($cardId, $cardPass)
	{
		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey,'arg2'=>$cardId,'arg3'=>$cardPass);
		$result = $this->soap->call("chargeUp",$params,$this->namespace);
		return $result;
	}
	
	/**
	 * ��ѯ��������  (ע:�˷�������Ϊ�ѵ�¼״̬�·��ɲ���)
	 * @return double ��������
	 */
	function getEachFee()
	{
		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey);
		$result = $this->soap->call("getEachFee",$params,$this->namespace);
		return $result;
	}

	/**
	 * �õ����ж���  (ע:�˷�������Ϊ�ѵ�¼״̬�·��ɲ���)
	 * 
	 * @return array ���ж����б�, ÿ��Ԫ����Mo����, Mo�������ݲο�������
	 * 
	 * 
	 * ��:
	 * 
	 * $moResult = $cpunc_sms->getMO();
	 * echo "��������:".count($moResult);
	 * foreach($moResult as $mo)
	 * {
	 * 	  //$mo ��λ�� cpunc_sms.php ��� Mo ����
	 * 	  echo "�����߸�����:".$mo->getAddSerial();
	 *	  echo "�����߸�����:".$mo->getAddSerialRev();
	 *	  echo "ͨ����:".$mo->getChannelnumber();
	 *	  echo "�ֻ���:".$mo->getMobileNumber();
	 * 	  echo "����ʱ��:".$mo->getSentTime();
	 *	  echo "��������:".$mo->getSmsContent();
	 * }
	 * 
	 * 
	 */
	function getMO()
	{
		$ret = array();
		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey);
		$result = $this->soap->call("getMO",$params,$this->namespace);
		//print_r($this->soap->response);
		//print_r($result);
		if (is_array($result) && count($result)>0)
		{
			if (is_array($result[0]))
			{
				foreach($result as $moArray)
					$ret[] = new Mo($moArray);	
			}else{
				$ret[] = new Mo($result);
			}
				
		}
		return $ret;
	}
	
	/**
	 * �õ�״̬����  (ע:�˷�������Ϊ�ѵ�¼״̬�·��ɲ���)
	 * @return array ״̬�����б�, һ�����ȡ5��
	 */
	function getReport()
	{
		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey);
		$result = $this->soap->call("getReport",$params,$this->namespace);
		return $result;
	}
	
	/**
	 * ��ҵע��  [��������]����Ϊ6 ������������Ϊ20����
	 * 
	 * @param string $eName 	��ҵ����
	 * @param string $linkMan 	��ϵ������
	 * @param string $phoneNum 	��ϵ�绰
	 * @param string $mobile 	��ϵ�ֻ�����
	 * @param string $email 	��ϵ�����ʼ�
	 * @param string $fax 		�������
	 * @param string $address 	��ϵ��ַ
	 * @param string $postcode  ��������
	 * 
	 * @return int �������״̬��
	 * 
	 */
	function registDetailInfo($eName,$linkMan,$phoneNum,$mobile,$email,$fax,$address,$postcode)
	{
		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey,
			'arg2'=>$eName,'arg3'=>$linkMan,'arg4'=>$phoneNum,
			'arg5'=>$mobile,'arg6'=>$email,'arg7'=>$fax,'arg8'=>$address,'arg9'=>$postcode		
		);
		$result = $this->soap->call("registDetailInfo",$params,$this->namespace);
		return $result;
	}
	
   	/**
   	 * �޸�����  (ע:�˷�������Ϊ�ѵ�¼״̬�·��ɲ���)
   	 * @param string $newPassword ������
   	 * @return int �������״̬��
   	 */
   	function updatePassword($newPassword) 
   	{
   		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey,
			'arg2'=>$this->password,'arg3'=>$newPassword		
		);
		$result = $this->soap->call("serialPwdUpd",$params,$this->namespace);
		return $result;
   	}       
   	
   	/**
   	 * 
   	 * ����ת��
   	 * @param string $forwardMobile ת�����ֻ�����
   	 * @return int �������״̬��
   	 * 
   	 */
   	function setMOForward($forwardMobile)
   	{
   		
   		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey,
			'arg2'=>$forwardMobile	
		);
		
		$result = $this->soap->call("setMOForward",$params,$this->namespace);
		return $result;
   	}
   	
   	/**
   	 * ����ת����չ
   	 * @param array $forwardMobiles ת�����ֻ������б�, �� array('159xxxxxxxx','159xxxxxxxx');
   	 * @return int �������״̬��
   	 */
   	function setMOForwardEx($forwardMobiles=array())
   	{
		$params = array('arg0'=>$this->serialNumber,'arg1'=>$this->sessionKey);
			
		/**
		 * ������뷢�͵�xml���ݸ�ʽ�� 
		 * <arg2>159xxxxxxxx</arg2>
		 * <arg2>159xxxxxxx2</arg2>
		 * ....
		 * ������Ҫ����ĵ�������
		 * 
		 */
		foreach($forwardMobiles as $mobile)
		{
			array_push($params,new soapval("arg2",false,$mobile));	
		}
		$result = $this->soap->call("setMOForwardEx",$params,$this->namespace);
		return $result;
   	}
   	
	/**
	 * ����6λ�����
	 */
	function generateKey()
	{
		return rand(100000,999999);
	}
}

class Mo{
	/**
	 * �����߸�����
	 */
	var $addSerial;
	
	/**
	 * �����߸�����
	 */
	var $addSerialRev;
	
	/**
	 * ͨ����
	 */
	var $channelnumber;
	
	/**
	 * �ֻ���
	 */
	var $mobileNumber;
	
	/**
	 * ����ʱ��
	 */
	var $sentTime;
	
	/**
	 * ��������
	 */
	var $smsContent;
	
	function Mo(&$ret=array())
	{
		$this->addSerial = $ret[addSerial];
		$this->addSerialRev = $ret[addSerialRev];
		$this->channelnumber = $ret[channelnumber];
		$this->mobileNumber = $ret[mobileNumber];
		$this->sentTime = $ret[sentTime];
		$this->smsContent = $ret[smsContent];
	}
	
	function getAddSerial()
	{
		return $this->addSerial;
	}
	function getAddSerialRev()
	{
		return $this->addSerialRev;
	}
	function getChannelnumber()
	{
		return $this->channelnumber;
	}
	function getMobileNumber()
	{
		return $this->mobileNumber;
	}
	function getSentTime()
	{
		return $this->sentTime;
	}
	function getSmsContent()
	{
		return $this->smsContent;
	}
}

?>

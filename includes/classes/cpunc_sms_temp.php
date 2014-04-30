<?php
//����ͨ�ģ��Ѿ�û�á�
//cpunc_sms�ֻ�����ƽ̨
//�й��ֻ����ŷ��ͽӿ�
//��ַhttp://www.cpunc.com/
//����Ϊhttp://www.winic.org/
//��ע��ӿ��ǲ���GB2312����

class cpunc_SMS {
	var $id;	//�˺�
	var $pwd;	//����
	function cpunc_SMS($uid="",$passwd=""){
		$this->id = urlencode(CPUNC_ID);
		$this->pwd = urlencode(CPUNC_PWD);
		if($uid!="" && $passwd!=""){
		  $this->id = urlencode($uid);
		  $this->pwd = urlencode($passwd);
		}
	}
	
	//��¼�ѷ��͵���Ϣ�����ݿ�
	function SaveSMS($to,$content,$return_code,$type='cpunc'){
		$data_array = array('to_phone'=>$to, 'to_content'=> tep_db_prepare_input($content), 'to_type'=>$type, 'return_code'=>tep_db_prepare_input($return_code), 'add_date'=> date('Y-m-d H:i:s'));
		tep_db_perform('`cpunc_sms_history`', $data_array); 
	}
	//���������ݿ�
	function UpBalance(){
		$balance_value = "&#65509;".$this->GetBalance();
		tep_db_query('update configuration SET configuration_value="'.tep_db_input($balance_value).'" WHERE configuration_key="CPUNC_BALANCE" ');
	}
	//ȡ�����
	function GetBalance(){
	  $url="http://service.winic.org:8009/webservice/public/remoney.asp?uid=%s&pwd=%s";
	  $rurl = sprintf($url, $this->id, $this->pwd);

	  $ch = curl_init();
	  $timeout = 5;
	  curl_setopt($ch, CURLOPT_URL, $rurl);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  //����Ҫ�û�������ҳ����Ҫ������������
	  //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	  //curl_setopt($ch, CURLOPT_USERPWD, US_NAME.��:��.US_PWD);
	  $result = curl_exec($ch);
	  curl_close($ch);
	  return $result;
	  
	}
	
	//������Ϣ$strMobileΪ�ֻ�����,$content����,$chartsetΪ���ݵ�Դ����
	function SendSMS($strMobile,$content, $chartset='GB2312'){
	  if(!defined('CPUNC_SWITCH') || CPUNC_SWITCH !='true'){ return false; }	//�ܿ���
	  $strMobile = str_replace(' ','',$strMobile);
	  if(!defined('CPUNC_ID') || !defined('CPUNC_PWD') ){ return false; }
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
	  
	  $url="http://service.winic.org:8009/sys_port/gateway/?id=%s&pwd=%s&to=%s&content=%s&time=";
	  $to = urlencode($strMobile);
	  $content = iconv($chartset,"GB2312".'//IGNORE',$content); //��utf-8תΪgb2312�ٷ�
	  $content = urlencode($content);
	  $rurl = sprintf($url, $this->id, $this->pwd, $to, $content);
	  
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_POST, true);
	  curl_setopt($ch, CURLOPT_HEADER, false);
	  curl_setopt($ch, CURLOPT_URL,$rurl);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	  $result = curl_exec($ch);
	  curl_close($ch);
	  
	  //$ret = file($result);
	  //000/Send:1/Consumption:.1/Tmoney:0/sid:1 
	  //000Ϊ�ɹ�����
	  //echo $result;
	  $send_status = explode('/',$result);
	  //print_r($send_status);
	  $this->SaveSMS(urldecode($strMobile),urldecode($content),$result);
	  $this->UpBalance();
	  if($send_status[0]=='000'){	//���ͳɹ�
		  return true; 
	  }elseif(CPUNC_SHOW_ERROR_AND_STOP=='true'){
		  echo $send_status[0]; exit;
	  }
	  return false;
  }
	
}
?>
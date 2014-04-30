<?php
/**
 * ���Ͷ���
 *
 * @param string $phone Ҫ���͵ĺ���
 * @param string $content Ҫ���͵�����
 * @param string $chartset ���ű���'GB2312'
 * @return int
 */
function sms_send($phone,$content,$chartset='GB2312',$sendTime=''){
	!isset($GLOBALS['tmp_sms']) && $GLOBALS['tmp_sms']=new cpunc_SMS;
	$sms = $GLOBALS['tmp_sms'];
	$maxsend = 100;
	if($phone!=''){
		$phone = explode(',',$phone);
		$phone = array_unique($phone);//ȥ���ظ���
		$phone = array_diff($phone, array(NULL,'null','',' '));//ȥ������
		$return = array();
		$z=0;
		$countphone = count($phone);
		while(true){
			$sendphone = array();
			$start = $z*$maxsend;
			$z++;
			$end = $start + $maxsend;
			$end > $countphone && $end = $countphone;
			for($i=$start;$i<$end;$i++){
				$sendphone[] = $phone[$i];
			}
			$sendphone = join(',',$sendphone);
			
			$return[] = $sms->SendSMS($sendphone,$content,$chartset,$sendTime);//���Ͳ����ؽ��
			if($countphone==$end)break;
		}
		$return_tmp = array_diff($return, array(false));
		if(count($return)!=count($return_tmp)){
			return 2;//���ֳɹ�������ʧ��
		}else{
			return 1;//�ɹ�
		}
	}
	return 0;//ʧ��
}
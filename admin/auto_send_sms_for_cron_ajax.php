<?php
/**
 * @author yichi.sun@usitrip.com
 * @time 2011-08-18
 */
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );
$smsajax = true;
require('includes/application_top.php');
require('includes/ajax_encoding_control.php');
require('sms_send.php');

//ÿ���Զ���һ�ζ��Ÿ���������Ŀͻ�
$today = date('Y-m-d');
$cron_sql = tep_db_query('SELECT * FROM `cron` WHERE cron_start_date <= "'.$today.'" AND (cron_latest_send_date < "'.$today.'" || cron_latest_send_date="0000-00-00") AND cron_ation_state!="1" AND cron_state ="true"');
//˵��:cron_state��ͬ��cron_ation_state��cron_ation_state��ָ����Ŀǰ��ִ��״̬��cron_state��ָ�Ƿ������ƻ����ܡ�

$weather_forecast_remind = false;
$preparatory_work_remind = false;
$shopping_sms = false;
$shopping_not_closing = false;
$not_logged_invited_six = false;
$end_greeting_message_remind = false;

while($cron_rows = tep_db_fetch_array($cron_sql)){
	//����ǰ����Ԥ������
	if($cron_rows['cron_code']=='WeatherForecastRemind'){
		$weather_forecast_remind = true;
		echo '����ǰ����Ԥ������: '.(string)$weather_forecast_remind."\n\n";
	}
	//����ǰ׼����������
	if($cron_rows['cron_code']=='PreparatoryWorkRemind'){
		$preparatory_work_remind = true;
		echo '����ǰ׼����������: '.(string)$preparatory_work_remind."\n\n";
	}    
    //���ﳵ�ڲ�Ʒ7��δ�¶���
	if($cron_rows['cron_code']=='ShoppingSMS'){
		$shopping_sms = true;
        echo '���ﳵ�ڲ�Ʒ7��δ�¶���: '.(string)$shopping_sms."\n\n";
	}
	//��Ʒ����3/7��δ����
    if($cron_rows['cron_code']=='ShoppingNotClosing'){
		$shopping_not_closing = true;
        echo '��Ʒ����3/7��δ����: '.(string)$shopping_not_closing."\n\n";
	}
	//�û��г̽��������û�е�¼���������ʺ������ٴε�¼
    if($cron_rows['cron_code']=='NotLoggedInvitedSix'){
		$not_logged_invited_six = true;
		echo '�û��г̽��������û�е�¼: '.(string)$not_logged_invited_six."\n\n";
	}
	//���Ž�������ʺ����
	if($cron_rows['cron_code']=='EndGreetingMessageRemind'){
		$end_greeting_message_remind = true;
		echo '���Ž�������ʺ����: '.(string)$end_greeting_message_remind."\n\n";
	}
}


tep_db_query('update `cron` set cron_ation_state = "1" ');

//�������ֻ�����
$test_phone_arr = array(
	//'andy'=>'13980965011', 
	//'richard'=>'18981831192', 
	//'tracy'=>'18780129392', 
	//'joanna'=>'13547864296', 
	//'gavin'=>'13699464385', 
	'yichi'=>'13880695761', 
	//'lollipop'=>'15828022554', 
);

//����ǰ����Ԥ������
if((preg_match('/'.preg_quote('[����Ԥ������]').'/',CPUNC_USE_RANGE) || preg_match('/'.preg_quote('[Ԥף�������]').'/',CPUNC_USE_RANGE)) && $weather_forecast_remind == true){
	tep_db_query('update `cron` set cron_latest_send_date = "'.date('Y-m-d').'" WHERE cron_code="WeatherForecastRemind" ');
	$qry_departure_info = "SELECT o.orders_id, op.products_name, DATE(op.products_departure_date) as products_departure_date, c.customers_telephone, c.customers_mobile_phone, c.customers_cellphone, c.confirmphone FROM orders o, orders_products op, customers c WHERE o.orders_status>99999 AND o.orders_status!=100004 AND o.orders_status!=100005 AND o.orders_status!=100036 AND DATE_SUB(DATE(op.products_departure_date), INTERVAL 1 DAY)='".$today."' AND op.orders_id = o.orders_id AND c.customers_id = o.customers_id";
	$res_departure_info = tep_db_query($qry_departure_info);
	while($row_departure_info = tep_db_fetch_array($res_departure_info)){
		//�ڲ���ǰһ����ÿͷ�������Ԥ����Ϣ
		$phone = '';
		$result = check_phone($row_departure_info['confirmphone']);
		if(!empty($result))$phone = $result[0];
		else{
			$result = check_phone($row_departure_info['customers_cellphone']);
			if(!empty($result))$phone = $result[0];
			else{
				$result = check_phone($row_flight_info['customers_mobile_phone']);
				if(!empty($result))$phone = $result[0];
				else{
					$result = check_phone($row_flight_info['customers_telephone']);
					if(!empty($result))$phone = $result[0];
				}
			}
		}
		
		if(!empty($phone)){
			//�Բ���ǰ�ÿͷ�������Ԥ����������
            if(preg_match('/'.preg_quote('[����Ԥ������]').'/',CPUNC_USE_RANGE)){
				$content = "�ÿ����ã��������Ĳ�����Ϣ�ط�δ�������������������£�";
				if(sms_send($phone, $content, 'GB2312')=='1'){
					echo $phone."�ÿͲ���ǰ����Ԥ�����ŷ��ͳɹ�"."\n\n";
				}
				else{
					echo $phone."�ÿͲ���ǰ����Ԥ�����ŷ���ʧ��"."\n\n";
				}
            }
			//Ԥף�ÿͳ���������
			if(preg_match('/'.preg_quote('[Ԥף�������]').'/',CPUNC_USE_RANGE)){
				$content = "�װ����ÿͣ�����Ԥ�������ķ���".$row_departure_info['products_name']."��".$row_departure_info['products_departure_date']."������ʼ�����ọ́�ף����;��죡";
				if(sms_send($phone, $content, 'GB2312')=='1'){
					echo $phone."Ԥף�ÿͳ��������ŷ��ͳɹ�"."\n\n";
				}
				else{
					echo $phone."Ԥף�ÿͳ��������ŷ���ʧ��"."\n\n";
				}
			}
		}
	}
	echo '����ǰ����Ԥ������ OK��'."\n\n";
}

//����ǰһ��׼����������
if(preg_match('/'.preg_quote('[׼����������]').'/',CPUNC_USE_RANGE) && $preparatory_work_remind == true){
	tep_db_query('update `cron` set cron_latest_send_date = "'.date('Y-m-d').'" WHERE cron_code="PreparatoryWorkRemind" ');
	$qry_departure_info = "SELECT o.orders_id, op.products_name, c.customers_telephone, c.customers_mobile_phone, c.customers_cellphone, c.confirmphone FROM orders o, orders_products op, customers c WHERE o.orders_status>99999 AND o.orders_status!=100004 AND o.orders_status!=100005 AND o.orders_status!=100036 AND DATE_SUB(DATE(op.products_departure_date), INTERVAL 7 DAY)='".$today."' AND op.orders_id = o.orders_id AND c.customers_id = o.customers_id";
	$res_departure_info = tep_db_query($qry_departure_info);
	while($row_departure_info = tep_db_fetch_array($res_departure_info)){
		//�ڲ���ǰһ�ܸ��ÿͷ���׼��������Ϣ
		$phone = '';
		$result = check_phone($row_departure_info['confirmphone']);
		if(!empty($result))$phone = $result[0];
		else{
			$result = check_phone($row_departure_info['customers_cellphone']);
			if(!empty($result))$phone = $result[0];
			else{
				$result = check_phone($row_flight_info['customers_mobile_phone']);
				if(!empty($result))$phone = $result[0];
				else{
					$result = check_phone($row_flight_info['customers_telephone']);
					if(!empty($result))$phone = $result[0];
				}
			}
		}
		
		if(!empty($phone)){
			//�Բ���ǰ�ÿͷ���׼��������������
			$content = "��Ԥ����".$row_departure_info['products_name']."���������ʼ�������������ó���׼�������ķ�����������ġ�����ָ�ϡ���Ϊ���ṩ��س�����Ѷ�����½���ķ��������˽⣡Ԥף��ӵ���������ڣ�";
			if(sms_send($phone, $content, 'GB2312')=='1'){
				echo $phone."�ÿͲ���ǰ׼���������ŷ��ͳɹ�"."\n\n";
			}
			else{
				echo $phone."�ÿͲ���ǰ׼���������ŷ���ʧ��"."\n\n";
			}
		}
	}
	echo '����ǰ׼���������� OK��'."\n\n";
}

//���ﳵ�ڲ�Ʒ7��δ�¶�������
if(preg_match('/'.preg_quote('[δ�¶�������]').'/',CPUNC_USE_RANGE) && $shopping_sms == true){
    $oday = date("Ymd", mktime(0,0,0,date("m"),date("d")-7,date("Y")));
    tep_db_query('update `cron` set cron_latest_send_date = "'.date('Y-m-d').'" WHERE cron_code="ShoppingSMS" ');  
    $sql = "SELECT cb.customers_id, cu.customers_telephone, cu.customers_mobile_phone, cu.customers_cellphone, cu.confirmphone FROM customers_basket as cb, customers as cu WHERE cb.customers_id = cu.customers_id and customers_basket_date_added = (".$oday.")  group by `customers_id`";
	$query = tep_db_query($sql);
    while($row = tep_db_fetch_array($query)){
    	//�Թ��ﳵ�ڵĲ�Ʒ7��δ�¶����Ŀͻ����Ͷ�������
		$phone = '';
		$result = check_phone($row['confirmphone']);
		if(!empty($result))$phone = $result[0];
		else{
			$result = check_phone($row['customers_cellphone']);
			if(!empty($result))$phone = $result[0];
			else{
				$result = check_phone($row['customers_mobile_phone']);
				if(!empty($result))$phone = $result[0];
				else{
					$result = check_phone($row['customers_telephone']);
					if(!empty($result))$phone = $result[0];
				}
			}
		}
		
		if(!empty($phone)){
			//�Թ��ﳵ�ڵĲ�Ʒ7��δ�¶����Ŀͻ����Ͷ�������
			$content = "���ķ������л��Ź����������������г�����Ͷ�����Ա����౶���ֵ��Żݻ������Ԥ�����������Żݡ���ѯ��400-637-8888��1-888-887-2816��";
			if(sms_send($phone, $content, 'GB2312')=='1'){
				echo $phone."���ﳵ�ڲ�Ʒ7��δ�¶��������Ѷ��ŷ��ͳɹ�"."\n\n";
			}
			else{
				echo $phone."���ﳵ�ڲ�Ʒ7��δ�¶��������Ѷ��ŷ���ʧ��"."\n\n";
			}
		}
    }
	echo '���ﳵ�ڲ�Ʒ7��δ�¶������� OK��'."\n\n";
}

//��Ʒ����3/7��δ��������
if(preg_match('/'.preg_quote('[δ��������]').'/',CPUNC_USE_RANGE) && $shopping_not_closing == true){
	tep_db_query('update `cron` set cron_latest_send_date = "'.date('Y-m-d').'" WHERE cron_code="ShoppingNotClosing" ');  
	$sql="SELECT orders_id FROM orders_status_history WHERE (orders_status_id = '1' or orders_status_id = '100054' or orders_status_id = '100060' or orders_status_id = '100094') GROUP BY orders_id";
	$orid = tep_db_query($sql);//�õ�״̬�Ѹ����ID
	$notin = '';
	$k = 1;
	while($row = tep_db_fetch_array($orid)){
		if($k==1){
			$notin .= "'".$row['orders_id']."'";
		}else{
			$notin .= ",'".$row['orders_id']."'";
		}
		$k++;
	}
	
	$day7 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-7,date("Y")));
	$day3 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-3,date("Y")));
	//�м۸��SQL
	/*$sql =
	"select ord.date_purchased, ord.orders_id, cu.customers_telephone, cu.customers_mobile_phone, cu.customers_cellphone, cu.confirmphone, orders_total.value from
	orders as ord, customers as cu, orders_total where 
	ord.orders_id in 
	(".$notin.") and 
	(ord.date_purchased like '".$day7."%' or ord.date_purchased like '".$day3."%') and 
	ord.customers_id=cu.customers_id and ord.orders_id=orders_total.orders_id and orders_total.class='ot_total' ";//group by ord.customers_id �������Ҫ��Ʒ����*/
	
	//û�м۸��SQL
	$sql =
	"select ord.date_purchased, ord.orders_id, cu.customers_telephone, cu.customers_mobile_phone, cu.customers_cellphone, cu.confirmphone from
	orders as ord, customers as cu where 
	ord.orders_id in 
	(".$notin.") and 
	(ord.date_purchased like '".$day7."%' or ord.date_purchased like '".$day3."%') and 
	ord.customers_id=cu.customers_id";//group by ord.customers_id �������Ҫ��Ʒ����
	
	$query = tep_db_query($sql);
	while($row = tep_db_fetch_array($query)){
		//�����¶���3/7��δ���˵Ŀͻ����Ͷ�������
		$phone = '';
		$result = check_phone($row['confirmphone']);
		if(!empty($result))$phone = $result[0];
		else{
			$result = check_phone($row['customers_cellphone']);
			if(!empty($result))$phone = $result[0];
			else{
				$result = check_phone($row['customers_mobile_phone']);
				if(!empty($result))$phone = $result[0];
				else{
					$result = check_phone($row['customers_telephone']);
					if(!empty($result))$phone = $result[0];
				}
			}
		}
		
		if(!empty($phone)){
			//�����¶���3/7��δ���˵Ŀͻ����Ͷ�������
			//�𾴵Ĺ˿ͣ����Ķ�����#".$row['orders_id']."���Ѿ����ɡ��������찲��֧����������($".$row['value'].")���Ա����Ǿ���Ϊ���������������г̡��������Ҫ���ǵ�Э����ɣ������������ǵĿͷ�����888-887-2816��������4006-333-926���й��������ǽ��߳�Ϊ������
			$content = "�𾴵��û���Ϊ��������Ԥ����λ����������֧�������������������벦��ͷ�����1-888-887-2816������4006-333-926���У������ǽ��߳�Ϊ������";
			if(sms_send($phone, $content, 'GB2312')=='1'){
				echo $phone."�ͻ����¶���3/7��δ���˵����Ѷ��ŷ��ͳɹ�"."\n\n";
			}
			else{
				echo $phone."�ͻ����¶���3/7��δ���˵����Ѷ��ŷ���ʧ��"."\n\n";
			}
		}
	}
	echo '��Ʒ����3/7��δ�������� OK��'."\n\n";
}

//�û��г̽��������û�е�¼���������ʺ������ٴε�¼
if(preg_match('/'.preg_quote('[δ��¼����]').'/',CPUNC_USE_RANGE) && $not_logged_invited_six == true){
	tep_db_query('update `cron` set cron_latest_send_date = "'.date('Y-m-d').'" WHERE cron_code="NotLoggedInvitedSix" ');
	$sql="SELECT orders_id FROM orders_status_history WHERE orders_status_id = '100006' GROUP BY orders_id";
	$query = tep_db_query($sql);//�г̽����Ķ���
	$i = 1;
	$in = '';
	while($row = tep_db_fetch_array($query)){
		if($i == 1){
			$in .= "'".$row['orders_id']."'";
		}else{
			$in .= ",'".$row['orders_id']."'";
		}
		$i++;
	}
	
	$sql = "select customers_id from orders as ord where ord.orders_id in(".$in.") GROUP BY ord.customers_id";//�õ��г���ɵ��û�ID��Ϊ�˰�ȫ��GROUP BY ID��һ���ʺſ���ͬʱ���ڼ��ֶ���
	$logid = tep_db_query($sql);
	$ik = 1;
	$lin = '';
	while($rows = tep_db_fetch_array($logid)){
		if($ik == 1){
			$lin .= "'".$rows['customers_id']."'";
		}else{
			$lin .= ",'".$rows['customers_id']."'";
		}
		$ik++;
	}
	
	$sql = "select customers_id,user_score_history_date,user_score_history_id from user_score_history where customers_id in (".$lin.") order by customers_id desc,user_score_history_date desc";
	$logged = tep_db_query($sql);
	$ari = 0;
	$temp = '';
	$cuin = '';
	while($ro = tep_db_fetch_array($logged)){
		if($ro['customers_id'] != $temp){
			if($ari == 0){
				$cuin .= "'".$ro['user_score_history_id']."'";
			}else{
				$cuin .= ",'".$ro['user_score_history_id']."'";
			}
			$temp = $ro['customers_id'];
			$ari++;
		}
	}
	
	$day186 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-186,date("Y")));
	$sql = "select cu.customers_telephone, cu.customers_mobile_phone, cu.customers_cellphone, cu.confirmphone from 
	user_score_history as user, customers as cu where 
	user.user_score_history_id in(".$cuin.") and user.user_score_history_date like '".$day186."%' and 
	user.customers_id = cu.customers_id";
	$resu = tep_db_query($sql);
	while($rownum = tep_db_fetch_array($resu)){
		//�û��г̽��������û�е�¼���������ʺ������ٴε�¼
		$phone = '';
		$result = check_phone($rownum['confirmphone']);
		if(!empty($result))$phone = $result[0];
		else{
			$result = check_phone($rownum['customers_cellphone']);
			if(!empty($result))$phone = $result[0];
			else{
				$result = check_phone($rownum['customers_mobile_phone']);
				if(!empty($result))$phone = $result[0];
				else{
					$result = check_phone($rownum['customers_telephone']);
					if(!empty($result))$phone = $result[0];
				}
			}
		}
		
		if(!empty($phone)){
			//�û��г̽��������û�е�¼�����Ͷ�������
			$content = "���ķ�����ѡ�����г̻��ȴ����У��ͼ��Ź�������Ͷ���������ʡ���ж౶�����Ͳ�ͣ����ӭ��½�˽��Ż����顣";
			if(sms_send($phone, $content, 'GB2312')=='1'){
				echo $phone."�û��г̽��������û�е�¼���Ѷ��ŷ��ͳɹ�"."\n\n";
			}
			else{
				echo $phone."�û��г̽��������û�е�¼���Ѷ��ŷ���ʧ��"."\n\n";
			}
		}
	}
	echo '�û��г̽��������û�е�¼���� OK��'."\n\n";
}

//���Ž�����������8��00���ÿͷ����ʺ���ţ�������ס�򲻷���
if(preg_match('/'.preg_quote('[�г̽����ʺ�]').'/',CPUNC_USE_RANGE) && $end_greeting_message_remind == true){
	tep_db_query('update `cron` set cron_latest_send_date = "'.date('Y-m-d').'" WHERE cron_code="EndGreetingMessageRemind" ');
	$qry_departure_info = "SELECT o.orders_id, op.orders_products_id, op.products_id, c.customers_telephone, c.customers_mobile_phone, c.customers_cellphone, c.confirmphone FROM orders o, orders_products op, products p, customers c WHERE o.orders_status>99999 AND o.orders_status!=100004 AND o.orders_status!=100005 AND o.orders_status!=100036 AND ADDDATE(DATE(op.products_departure_date), (p.products_durations-1))='".$today."' AND op.orders_id = o.orders_id AND p.products_id = op.products_id AND c.customers_id = o.customers_id";
	$res_departure_info = tep_db_query($qry_departure_info);
	$num = tep_db_num_rows($res_departure_info);
	if($num>0){
		while($row_departure_info = tep_db_fetch_array($res_departure_info)){
			//�ж��Ƿ����Ӻ��뿪����ס��Ϣ������ס�򷢶����ʺ�
			/*
			$tour_eticket_hotel = tep_get_products_eticket_hotel($row_departure_info['products_id'],$languages_id);
			$tour_eticket_hotel_arr = explode('!##!',$tour_eticket_hotel);
			$max = count($tour_eticket_hotel_arr)-1;
			$last_day_hotel = strtolower(trim($tour_eticket_hotel_arr[$max]));
			if($max==0 || $last_day_hotel=='' || $last_day_hotel=='���ṩ' || $last_day_hotel=='n/a'){
			*/
			$extended_hotel_sql = 'SELECT count(1) as cnt FROM `orders_products_extended_hotel` WHERE orders_id="'.(int)$row_departure_info['orders_id'].'" AND orders_products_id="'.(int)$row_departure_info['orders_products_id'].'" AND eh_type="after" AND (hotel_confirm_number!=NULL OR hotel_confirm_number!="")';
			$extended_hotel_query = tep_db_query($extended_hotel_sql);
			$extended_hotel_result = tep_db_fetch_array($extended_hotel_query);
			if($extended_hotel_result['cnt']<1){
				$phone = '';
				$result = check_phone($row_departure_info['confirmphone']);
				if(!empty($result))$phone = $result[0];
				else{
					$result = check_phone($row_departure_info['customers_cellphone']);
					if(!empty($result))$phone = $result[0];
					else{
						$result = check_phone($row_departure_info['customers_mobile_phone']);
						if(!empty($result))$phone = $result[0];
						else{
							$result = check_phone($row_departure_info['customers_telephone']);
							if(!empty($result))$phone = $result[0];
						}
					}
				}
				
				if(!empty($phone)){
					//���Ž�����������8��00���ÿͷ����ʺ����
					$content = "����������;��������;��Ƭ�ȵ����ķ�������ͨ���绰���ʼ������۵ȷ�ʽ�ṩ�������飬������Ϊ���������ṩ���вο��������������ķ����ֵ��Żݽ���������ڴ��ٴ�Ϊ������";
					$sendTime = date('Ymd').'200000';
					//$sendTime = '20110819143400';
					if(sms_send($phone, $content, 'GB2312', $sendTime)=='1'){
						echo $phone."�ÿͲ��Ž������ʺ���ŷ��ͳɹ�"."\n\n";
					}
					else{
						echo $phone."�ÿͲ��Ž������ʺ���ŷ���ʧ��"."\n\n";
					}
				}
			}
		}
	}
	echo '���Ž�������ʺ���� OK��'."\n\n";
}

tep_db_query('update `cron` set cron_ation_state = "0" ');


echo "Done";
?>
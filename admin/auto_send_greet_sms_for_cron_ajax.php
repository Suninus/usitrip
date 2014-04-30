<?php
/**
 * @author yichi.sun@usitrip.com
 * @time 2011-08-18
 */
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );
set_time_limit(0);

$smsajax = true;
require('includes/application_top.php');
require(DIR_WS_INCLUDES . 'ajax_encoding_control.php');
require('sms_send.php');

//ÿ���Զ���һ�ζ��Ÿ���������Ŀͻ�
$today = date('Y-m-d');
$cron_sql = tep_db_query('SELECT * FROM `cron` WHERE cron_start_date <= "'.$today.'" AND (cron_latest_send_date < "'.$today.'" || cron_latest_send_date="0000-00-00") AND cron_ation_state!="1" AND cron_state ="true"');
//˵��:cron_state��ͬ��cron_ation_state��cron_ation_state��ָ����Ŀǰ��ִ��״̬��cron_state��ָ�Ƿ������ƻ����ܡ�

$end_greeting_message_remind = false;
while($cron_rows = tep_db_fetch_array($cron_sql)){
	//���Ž�������ʺ����
	if($cron_rows['cron_code']=='EndGreetingMessageRemind'){
		$end_greeting_message_remind = true;
		echo '���Ž�������ʺ����: '.(string)$end_greeting_message_remind."\n\n";
	}
}

//�������ֻ�����
$test_phone_arr = array(
	//'andy'=>'13980965011', 
	//'richard'=>'18981831192', 
	//'tracy'=>'18780129392', 
	//'joanna'=>'13547864296', 
	//'gavin'=>'13699464385', 
	'yichi'=>'13880695761', 
);

//���Ž�����������8��00���ÿͷ����ʺ���ţ�������ס�򲻷���
if(0 && $end_greeting_message_remind == true){
	tep_db_query('update `cron` set cron_latest_send_date = "'.date('Y-m-d').'" WHERE cron_code="EndGreetingMessageRemind" ');
	
	$now_time = time();
	$send_sms_time = strtotime($today)+20*3600;
	$sleep_time = $send_sms_time - $now_time;
	$qry_departure_info = "SELECT o.orders_id, op.orders_products_id, op.products_id, c.customers_telephone, c.customers_mobile_phone, c.customers_cellphone, c.confirmphone FROM orders o, orders_products op, products p, customers c WHERE o.orders_status>99999 AND o.orders_status!=100004 AND o.orders_status!=100005 AND o.orders_status!=100036 AND ADDDATE(DATE(op.products_departure_date), (p.products_durations-1))='".$today."' AND op.orders_id = o.orders_id AND p.products_id = op.products_id AND c.customers_id = o.customers_id";
	$res_departure_info = tep_db_query($qry_departure_info);
	$num = tep_db_num_rows($res_departure_info);
	if($num>0 && $sleep_time>0 && $sleep_time<=72000){
		echo '�ȴ�ʱ�䣺'.$sleep_time.'��'."\n\n";
		sleep($sleep_time);
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
					//�����Ž������ÿͷ����ʺ����
					foreach($test_phone_arr as $test_phone){
						$content = $phone."����������;��������;��Ƭ�ȵ����ķ�������ͨ���绰���ʼ������۵ȷ�ʽ�ṩ�������飬������Ϊ���������ṩ���вο��������������ķ����ֵ��Żݽ���������ڴ��ٴ�Ϊ������";
						if(sms_send($test_phone, $content, 'GB2312')=='1'){
							echo $phone."�ÿͲ��Ž������ʺ���ŷ��ͳɹ�"."\n\n";
						}
						else{
							echo $phone."�ÿͲ��Ž������ʺ���ŷ���ʧ��"."\n\n";
						}
					}
				}
			}
		}
	}
	echo '���Ž�������ʺ���� OK��'."\n\n";
}

echo "Done";
?>
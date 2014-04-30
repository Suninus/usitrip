<?php
require_once('includes/application_top.php');
$p=array('/&amp;/','/&quot;/');
$r=array('&','"');

//�����ύ���� start
if($_POST || tep_not_null($_GET['randnumforajaxaction'])){
	$this_date_time = date('Y-m-d H:i:s');
	switch($_GET['action']){
		case 'submit_hotel_extend':
			$hotel_room_info = array();
			for($i=0; $i<count($_POST['room_pep']); $i++){
				if((int)$_POST['room_pep'][$i]){
					$hotel_room_info[] = (int)$_POST['room_pep'][$i];
				}
			}
			$hotel_room_info_str = "";
			if((int)sizeof($hotel_room_info)){
				$hotel_room_info_str = implode(',',$hotel_room_info);
				$_POST['people_number'] = array_sum($hotel_room_info);
			}
			$data_array = array('orders_id'=>(int)$_POST['orders_id'],
								'orders_products_id'=>(int)$_POST['orders_products_id'],
								'eh_type'=>tep_db_prepare_input($_POST['eh_type']),
								'hotel_id'=>(int)$_POST['hotel_id'],
								'hotel_name'=>ajax_to_general_string(tep_db_prepare_input($_POST['hotel_name'])),
								'hotel_price'=>tep_db_prepare_input($_POST['hotel_price']),
								'people_number'=>(int)$_POST['people_number'],
								'hotel_final_price'=>tep_db_prepare_input($_POST['hotel_final_price']),
								'hotel_room_info'=>$hotel_room_info_str,
								'start_date'=>tep_db_prepare_input($_POST['start_date']),
								'end_date'=>tep_db_prepare_input($_POST['end_date']),
								'customer_name'=>ajax_to_general_string(tep_db_prepare_input($_POST['customer_name'])),
								'customer_mobile'=>tep_db_prepare_input($_POST['customer_mobile']),
								'status_id'=>(int)$_POST['status_id'],
								'modified_by'=>$login_id,
								'modified'=>$this_date_time,
								'pay_method'=>ajax_to_general_string(tep_db_prepare_input($_POST['pay_method'])),
								'provider_code'=>ajax_to_general_string(tep_db_prepare_input($_POST['provider_code'])),
								'hotel_confirm_number'=>ajax_to_general_string(tep_db_prepare_input($_POST['hotel_confirm_number'])),
								'remarks'=>ajax_to_general_string(tep_db_prepare_input($_POST['remarks']))
								);
			$ckeck_sql = tep_db_query('SELECT extended_hotel_id FROM `orders_products_extended_hotel` WHERE extended_hotel_id="'.(int)$_POST['extended_hotel_id'].'" ');
			$ckeck = tep_db_fetch_array($ckeck_sql);
			if((int)$ckeck['extended_hotel_id']){
				tep_db_perform('orders_products_extended_hotel', $data_array, 'update', ' extended_hotel_id="'.(int)$_POST['extended_hotel_id'].'" ');
				$extended_hotel_id = (int)$_POST['extended_hotel_id'];
			}else{
				tep_db_perform('orders_products_extended_hotel', $data_array);
				$extended_hotel_id = tep_db_insert_id();
			}
			//��¼������ʷ
			//unset($data_array['orders_id']);
			$data_array['action_map']='OrdersOtherServices';
			$data_array['extended_hotel_id']=$extended_hotel_id;
			
			tep_db_perform('orders_products_extended_hotel_history', $data_array);
			
			$alert_str = '';
			//ϵͳ�Զ����͹�����ס�Ƶ���Ϣ�Ķ���
			$phone = trim($data_array['customer_mobile']);
			if(0 && tep_not_null($phone) && strlen($phone)==11 && $data_array['status_id']=='3' && tep_not_null(trim($data_array['hotel_confirm_number']))){
				require_once('sms_send.php');
				$hotel_query = tep_db_query('SELECT hotel_address,hotel_phone FROM `hotel` WHERE hotel_id="'.(int)$data_array['hotel_id'].'" ');
				$hotel_info = tep_db_fetch_array($hotel_query);
				$content = "�𾴵��û������ľƵ���ס�Ѿ�ȷ�ϡ��Ƶ�����:".$data_array['hotel_name']."���Ƶ��ַ:".$hotel_info['hotel_address']."���Ƶ�绰:".$hotel_info['hotel_phone']."���Ƶ���ס��Ϊ��#".$data_array['hotel_confirm_number']."���������Ʊ��ܾƵ���ס���룬��סʱ���ṩ�ú���ȷ�Ϸ��䣻ף����;���!";
				if(sms_send($phone, $content, 'GB2312')=='1'){
					$alert_str .=  $phone."�ÿ͵ľƵ���ס���ŷ��ͳɹ���";
				}
				else{
					$alert_str .=  $phone."�ÿ͵ľƵ���ס���ŷ���ʧ�ܡ�";
				}
			}
			
			$alert_str .= '�����ύ�ɹ���';
			$js_str = '[JS]';
			$js_str .= 'alert("'.db_to_html($alert_str).'");';
			if((int)$ckeck['extended_hotel_id']){
				$js_str .= 'parent.document.location.reload();';
			}else{
				$js_str .= 'parent.document.location.reload();';
			}
			$js_str .= '[/JS]';
			echo general_to_ajax_string($js_str);
		break;
		case "submit_airport_transfer":
			if($_POST['service_type']!="1"){
				$_POST['pick_up'] = "";
			}
			
			$data_array = array('orders_id'=>(int)$_POST['orders_id'],
								'orders_products_id'=>(int)$_POST['orders_products_id'],
								'flight_number'=>ajax_to_general_string(tep_db_prepare_input($_POST['flight_number'])),
								'arrival_airport'=>ajax_to_general_string(tep_db_prepare_input($_POST['arrival_airport'])),
								'final_price'=>tep_db_prepare_input($_POST['final_price']),
								'customer_name'=>ajax_to_general_string(tep_db_prepare_input($_POST['customer_name'])),
								'customer_mobile'=>tep_db_prepare_input($_POST['customer_mobile']),
								'arrival_time'=>ajax_to_general_string(tep_db_prepare_input($_POST['arrival_time'])),
								'status_id'=>(int)$_POST['status_id'],
								'modified_by'=>$login_id,
								'modified'=>$this_date_time,
								'pay_method'=>ajax_to_general_string(tep_db_prepare_input($_POST['pay_method'])),
								'provider_code'=>ajax_to_general_string(tep_db_prepare_input($_POST['provider_code'])),
								'remarks'=>ajax_to_general_string(tep_db_prepare_input($_POST['remarks'])),
								'drop_off'=>ajax_to_general_string(tep_db_prepare_input($_POST['drop_off'])),
								'pick_up'=>ajax_to_general_string(tep_db_prepare_input($_POST['pick_up'])),
								'service_type'=>(int)$_POST['service_type']
								);
			$ckeck_sql = tep_db_query('SELECT orders_products_id FROM `orders_products_airport_transfer` WHERE orders_products_id="'.(int)$_POST['orders_products_id'].'" ');
			$ckeck = tep_db_fetch_array($ckeck_sql);
			if((int)$ckeck['orders_products_id']){
				tep_db_perform('orders_products_airport_transfer', $data_array, 'update', ' orders_products_id="'.(int)$_POST['orders_products_id'].'" ');
			}else{
				tep_db_perform('orders_products_airport_transfer', $data_array);
			}
			//��¼������ʷ
			//unset($data_array['orders_id']);
			$data_array['action_map']='OrdersOtherServices';
			tep_db_perform('orders_products_airport_transfer_history', $data_array);

			$alert_str = '';
			//ϵͳ�Զ����͹��ڻ�����/�ͷ���Ķ���
			$phone = trim($data_array['customer_mobile']);
			if(0 && tep_not_null($phone) && strlen($phone)==11 && $data_array['status_id']=='3'){
				require_once('sms_send.php');
				$content = "�𾴵��û������������г̣�������#".$_POST['orders_id']."���ͻ�����Ӧ�Ѿ�ȫ��ȷ����ϣ�������Ϊ��ǩ���˵��ӿ�Ʊ�����½����������û����ġ��鿴���鲢��ӡ���ӿ�Ʊ��ף����죡";
				if(sms_send($phone, $content, 'GB2312')=='1'){
					$alert_str .=  $phone."�ÿ͵Ļ�����/�ͷ�����ŷ��ͳɹ���";
				}
				else{
					$alert_str .=  $phone."�ÿ͵Ļ�����/�ͷ�����ŷ���ʧ�ܡ�";
				}
			}
			
			$alert_str .= '�����ύ�ɹ���';
			$js_str = '[JS]';
			$js_str .= 'alert("'.db_to_html($alert_str).'");';
			if((int)$ckeck['orders_products_id']){
				$js_str .= 'parent.document.location.reload();';			
			}else{
				$js_str .= 'parent.document.location.reload();';			
			}
			$js_str .= '[/JS]';
			echo general_to_ajax_string($js_str);
		break;
		case "submit_address_transfer":
			if($_POST['service_type']!="1"){
				$_POST['transfer_time1'] = $_POST['transfer_address1'] = $_POST['transfer_to_address1'] = "";
			}
			
			$data_array = array('orders_id'=>(int)$_POST['orders_id'],
								'orders_products_id'=>(int)$_POST['orders_products_id'],
								'final_price'=>tep_db_prepare_input($_POST['final_price']),
								'customer_name'=>ajax_to_general_string(tep_db_prepare_input($_POST['customer_name'])),
								'customer_mobile'=>tep_db_prepare_input($_POST['customer_mobile']),
								'transfer_time'=>ajax_to_general_string(tep_db_prepare_input($_POST['transfer_time'])),
								'transfer_address'=>ajax_to_general_string(tep_db_prepare_input($_POST['transfer_address'])),
								'transfer_to_address'=>ajax_to_general_string(tep_db_prepare_input($_POST['transfer_to_address'])),
								'status_id'=>(int)$_POST['status_id'],
								'modified_by'=>$login_id,
								'modified'=>$this_date_time,
								'pay_method'=>ajax_to_general_string(tep_db_prepare_input($_POST['pay_method'])),
								'provider_code'=>ajax_to_general_string(tep_db_prepare_input($_POST['provider_code'])),
								'remarks'=>ajax_to_general_string(tep_db_prepare_input($_POST['remarks'])),
								'service_type'=>(int)$_POST['service_type'],
								'transfer_time1'=>ajax_to_general_string(tep_db_prepare_input($_POST['transfer_time1'])), 
								'transfer_address1'=>ajax_to_general_string(tep_db_prepare_input($_POST['transfer_address1'])), 
								'transfer_to_address1'=>ajax_to_general_string(tep_db_prepare_input($_POST['transfer_to_address1'])) 
								);
			$ckeck_sql = tep_db_query('SELECT orders_products_id FROM `orders_products_address_transfer` WHERE orders_products_id="'.(int)$_POST['orders_products_id'].'" ');
			$ckeck = tep_db_fetch_array($ckeck_sql);
			if((int)$ckeck['orders_products_id']){
				tep_db_perform('orders_products_address_transfer', $data_array, 'update', ' orders_products_id="'.(int)$_POST['orders_products_id'].'" ');
			}else{
				tep_db_perform('orders_products_address_transfer', $data_array);
			}
			//��¼������ʷ
			//unset($data_array['orders_id']);
			$data_array['action_map']='OrdersOtherServices';
			tep_db_perform('orders_products_address_transfer_history', $data_array);
			
			$js_str = '[JS]';
			$js_str .= 'alert("�ύ�ɹ���");';
			if((int)$ckeck['orders_products_id']){
				$js_str .= 'parent.document.location.reload();';			
			}else{
				$js_str .= 'parent.document.location.reload();';			
			}
			$js_str .= '[/JS]';
			echo general_to_ajax_string($js_str);
		break;
		case "submit_orders_changed":
			$data_array = array('orders_id'=>(int)$_POST['orders_id'],
								'orders_products_id'=>(int)$_POST['orders_products_id'],
								'final_price'=>tep_db_prepare_input($_POST['final_price']),
								'status_id'=>(int)$_POST['status_id'],
								'modified_by'=>$login_id,
								'modified'=>$this_date_time,
								'pay_method'=>ajax_to_general_string(tep_db_prepare_input($_POST['pay_method'])),
								'provider_code'=>ajax_to_general_string(tep_db_prepare_input($_POST['provider_code'])),
								'remarks'=>ajax_to_general_string(tep_db_prepare_input($_POST['remarks'])),
								'reason'=>(int)$_POST['reason']
								);
			$ckeck_sql = tep_db_query('SELECT orders_products_id FROM `orders_products_orders_change` WHERE orders_products_id="'.(int)$_POST['orders_products_id'].'" ');
			$ckeck = tep_db_fetch_array($ckeck_sql);
			if((int)$ckeck['orders_products_id']){
				tep_db_perform('orders_products_orders_change', $data_array, 'update', ' orders_products_id="'.(int)$_POST['orders_products_id'].'" ');
			}else{
				tep_db_perform('orders_products_orders_change', $data_array);
			}
			//��¼������ʷ
			//unset($data_array['orders_id']);
			$data_array['action_map']='OrdersOtherServices';
			tep_db_perform('orders_products_orders_change_history', $data_array);
			$js_str = '[JS]';
			$js_str .= 'alert("�ύ�ɹ���");';
			if((int)$ckeck['orders_products_id']){
				$js_str .= 'parent.document.location.reload();';			
			}else{
				$js_str .= 'parent.document.location.reload();';			
			}
			$js_str .= '[/JS]';
			echo general_to_ajax_string($js_str);
		break;
		case "search_hotel":	//�����Ƶ�
			$hotel_where = ' 1 ';
			if(tep_not_null($_POST['search_hotel_name'])){
				$hotel_where .= ' AND hotel_name Like ("'.ajax_to_general_string(tep_db_prepare_input($_POST['search_hotel_name'])).'%") ';
			}
			$hotel_sql = tep_db_query('SELECT hotel_id, hotel_name FROM `hotel` WHERE '.$hotel_where.' order by hotel_name limit 20');
			$html_codes = "";
			while($hotel_rows = tep_db_fetch_array($hotel_sql)){
				$html_codes .= '<li><label><input name="hotelListRadio" value="'.$hotel_rows['hotel_id'].'" title="'.tep_db_output($hotel_rows['hotel_name']).'" type="radio" onclick="SelectHotel(this);" />'.tep_db_output($hotel_rows['hotel_name']).'</label></li>';
			}
			if(tep_not_null($html_codes)){
				$js_str = '[JS]';
				$js_str .= 'var html_codes="";';
				$js_str .= 'html_codes="'.addslashes($html_codes).'";';
				$js_str .= '$("#HotelList").html(html_codes);';
				$js_str .= '[/JS]';
				echo general_to_ajax_string($js_str);
			}
		break;
		case "get_hotel_info":	//ȡ�õ����Ƶ���Ϣ
			$hotel_sql = tep_db_query('SELECT * FROM `hotel` WHERE hotel_id="'.(int)$_GET['hotel_id'].'" ');
			$hotel_row = tep_db_fetch_array($hotel_sql);
			if((int)$hotel_row['hotel_id']){
				$js_str = '[JS]';
				$js_str .= '$("#HotelDetail_h1").html("<a href=\"javascript:void(0);\">'.tep_db_output($hotel_row['hotel_name']).'</a> ��ϸ����");';
				$js_str .= '$("#HotelDetail_HotelName").html("'.tep_db_output($hotel_row['hotel_name']).'");';
				$js_str .= '$("#HotelDetail_HotelStars").html("'.tep_db_output($hotel_row['hotel_stars']).'");';
				$js_str .= '$("#HotelDetail_HotelAddress").html("'.tep_db_output($hotel_row['hotel_address']).'");';
				$js_str .= '$("#HotelDetail_HotelPhone").html("'.tep_db_output($hotel_row['hotel_phone']).'");';
				$js_str .= '$("#HotelDetail_Description").html("'.nl2br(tep_db_output($hotel_row['hotel_description'])).'");';
				//$js_str .= 'html_codes="'.addslashes($html_codes).'";';
				$js_str .= '$("#HotelDetail").show();';
				$js_str .= '[/JS]';
				$js_str = preg_replace('/[[:space:]]+/',' ',$js_str);
				echo general_to_ajax_string($js_str);
			}
		break;
		case "change_hotel_status":	//���ٸ��¾Ƶ���ס״̬
			$data_array = array('status_id'=>(int)$_GET['status_id'],
								'provider_code'=> tep_db_prepare_input($_GET['provider_code']),
								'modified_by'=> $login_id,
								'modified'=> $this_date_time
								);
			
			tep_db_perform('orders_products_extended_hotel', $data_array, 'update', ' orders_products_id="'.(int)$_GET['orders_products_id'].'" AND extended_hotel_id="'.(int)$_GET['extended_hotel_id'].'"');
			//��¼������ʷ
			$h_sql = tep_db_query('select * from orders_products_extended_hotel where orders_products_id="'.(int)$_GET['orders_products_id'].'" AND extended_hotel_id="'.(int)$_GET['extended_hotel_id'].'" ');
			$data_array = tep_db_fetch_array($h_sql);
			$data_array['action_map']='OrdersEditPage';
			$data_array['orders_products_id']=(int)$_GET['orders_products_id'];
			$data_array['extended_hotel_id']=(int)$_GET['extended_hotel_id'];
			tep_db_perform('orders_products_extended_hotel_history', $data_array);

			$js_str = '[JS]';
			$js_str .= 'if(confirm("����״̬�Ѹ��£����ȷ��ϵͳ���Զ����±�������")){';
			$js_str .= 'document.location.reload();}';
			$js_str .= '[/JS]';
			$js_str = preg_replace('/[[:space:]]+/',' ',$js_str);
			echo general_to_ajax_string($js_str);
		break;
		case "change_airport_status":	//���ٸ��»�������״̬
			$data_array = array('status_id'=>(int)$_GET['status_id'],
								'provider_code'=> tep_db_prepare_input($_GET['provider_code']),
								'modified_by'=> $login_id,
								'modified'=> $this_date_time
								);
			
			tep_db_perform('orders_products_airport_transfer', $data_array, 'update', ' orders_products_id="'.(int)$_GET['orders_products_id'].'" ');
			//��¼������ʷ
			$h_sql = tep_db_query('select * from orders_products_airport_transfer where orders_products_id="'.(int)$_GET['orders_products_id'].'" ');
			$data_array = tep_db_fetch_array($h_sql);
			$data_array['action_map']='OrdersEditPage';
			tep_db_perform('orders_products_airport_transfer_history', $data_array);
			
			$js_str = '[JS]';
			$js_str .= 'if(confirm("����״̬�Ѹ��£����ȷ��ϵͳ���Զ����±�������")){';
			$js_str .= 'document.location.reload();}';
			$js_str .= '[/JS]';
			$js_str = preg_replace('/[[:space:]]+/',' ',$js_str);
			echo general_to_ajax_string($js_str);
		break;
		case "change_address_status":	//���ٸ���ָ���ص����״̬
			$data_array = array('status_id'=>(int)$_GET['status_id'],
								'provider_code'=> tep_db_prepare_input($_GET['provider_code']),
								'modified_by'=> $login_id,
								'modified'=> $this_date_time
								);
			
			tep_db_perform('orders_products_address_transfer', $data_array, 'update', ' orders_products_id="'.(int)$_GET['orders_products_id'].'" ');
			//��¼������ʷ
			$h_sql = tep_db_query('select * from orders_products_address_transfer where orders_products_id="'.(int)$_GET['orders_products_id'].'" ');
			$data_array = tep_db_fetch_array($h_sql);
			$data_array['action_map']='OrdersEditPage';
			tep_db_perform('orders_products_address_transfer_history', $data_array);
			
			$js_str = '[JS]';
			$js_str .= 'if(confirm("����״̬�Ѹ��£����ȷ��ϵͳ���Զ����±�������")){';
			$js_str .= 'document.location.reload();}';
			$js_str .= '[/JS]';
			$js_str = preg_replace('/[[:space:]]+/',' ',$js_str);
			echo general_to_ajax_string($js_str);
		break;
		case "change_orders_change_status":	//���ٸ��¶����޸ķ���״̬
			$data_array = array('status_id'=>(int)$_GET['status_id'],
								'provider_code'=> tep_db_prepare_input($_GET['provider_code']),
								'modified_by'=> $login_id,
								'modified'=> $this_date_time
								);
			
			tep_db_perform('orders_products_orders_change', $data_array, 'update', ' orders_products_id="'.(int)$_GET['orders_products_id'].'" ');
			//��¼������ʷ
			$h_sql = tep_db_query('select * from orders_products_orders_change where orders_products_id="'.(int)$_GET['orders_products_id'].'" ');
			$data_array = tep_db_fetch_array($h_sql);
			$data_array['action_map']='OrdersEditPage';
			tep_db_perform('orders_products_orders_change_history', $data_array);
			$js_str = '[JS]';
			$js_str .= 'if(confirm("����״̬�Ѹ��£����ȷ��ϵͳ���Զ����±�������")){';
			$js_str .= 'document.location.reload();}';
			$js_str .= '[/JS]';
			$js_str = preg_replace('/[[:space:]]+/',' ',$js_str);
			echo general_to_ajax_string($js_str);
		break;
	}
	exit;
}
//�����ύ���� end

//����������Ŀ����Ƶ���ס��������/�ͷ���ָ���ص��/�ͷ��񡢶������ķ��񡭡�
if(!class_exists('OrderOtherService')){
	//class satrt
	class OrderOtherService{
		var $orders_products_id;
		
		function OrderOtherService($orders_products_id){
			$this->orders_products_id = (int)$orders_products_id;
		}
		function GetExtendedStayHotels(){
			$rows = array();
			$sql_str = 'select * from orders_products_extended_hotel where orders_products_id="'.$this->orders_products_id.'" Order By extended_hotel_id ASC';
			//echo $sql_str;
			$sql = tep_db_query($sql_str);
			while($row = tep_db_fetch_array($sql)){
				$rows[] = $row;
			}
			if((int)$rows[0]['extended_hotel_id']){
				return $rows;
			}else{
				return false;
			}
		}
		function GetAirportTransferService(){
			$sql_str = 'select * from orders_products_airport_transfer where orders_products_id="'.$this->orders_products_id.'" Limit 1';
			$sql = tep_db_query($sql_str);
			$row = tep_db_fetch_array($sql);
			if((int)$row['orders_products_id']){
				return $row;
			}else{
				return false;
			}
		}
		function GetAddressTransferService(){
			$sql_str = 'select * from orders_products_address_transfer where orders_products_id="'.$this->orders_products_id.'" Limit 1';
			$sql = tep_db_query($sql_str);
			$row = tep_db_fetch_array($sql);
			if((int)$row['orders_products_id']){
				return $row;
			}else{
				return false;
			}
		}
		function GetOrdersChangedService(){
			$sql_str = 'select * from orders_products_orders_change where orders_products_id="'.$this->orders_products_id.'" Limit 1';
			$sql = tep_db_query($sql_str);
			$row = tep_db_fetch_array($sql);
			if((int)$row['orders_products_id']){
				return $row;
			}else{
				return false;
			}
		}
		
		function GetAllStatus(){
			$sql_str = 'select os_status_id as id, os_status_name as text from orders_other_service_status where 1 order by os_sort';
			$sql = tep_db_query($sql_str);
			$array = array();
			while($rows = tep_db_fetch_array($sql)){
				$array[] = $rows;
			}
			if((int)sizeof($array)){
				return $array;
			}else{
				return false;
			}
		}
		function GetAllPayMethod(){
			$array = array();
			$array[] = array('id'=>'����ת��','text'=>'����ת��');
			$array[] = array('id'=>'���ÿ�','text'=>'���ÿ�');
			$array[] = array('id'=>'���е��','text'=>'���е��');
			$array[] = array('id'=>'����ת��/�ֽ���','text'=>'����ת��/�ֽ���');
			$array[] = array('id'=>'��Ʊ','text'=>'��Ʊ');
			$array[] = array('id'=>'Paypal','text'=>'Paypal');
			return $array;
		}
	}
	//class end
	
	//��ǰһ��¼�Ա��Բ����������Զ��ԱȺ������Ӧ��ɫ�����ݣ�������ʾ��ʷ��¼��
	function ComparativeOutput($CurrentString, $PreviousString, $SortNum){
		if(!(int)$SortNum){ return tep_db_output($CurrentString); }
		$output = $CurrentString;
		if($CurrentString==$PreviousString){
			$output = '<font style="color:#CCC">'.tep_db_output($CurrentString).'</font>';
		}else{
			$output = '<font style="color:#F00">'.(tep_not_null($CurrentString)? tep_db_output($CurrentString) : "NULL").'</font>';
		}
		return $output;
	}
	
}




//�����༭ҳ������Ҫ��ʾ�Ĳ��� start
if(basename($_SERVER['PHP_SELF'])=="edit_orders.php"){
	if(!(int)$oID || !(int)$order->products[$i]['orders_products_id']){
		echo ('Fatal Error! No find oID or orders_products_id!');
	}
	$class_name = 'OtherService_'.$oID.'_'.$order->products[$i]['orders_products_id'];
	$$class_name = new OrderOtherService($order->products[$i]['orders_products_id']);
	if(!isset($other_service_status) || !is_array($other_service_status)){
		$other_service_status = $$class_name->GetAllStatus();	//״̬�б�����
	}
	

?>

<?php
if($javascript_write_num != true){
	$javascript_write_num = true;
	//ֻ��Ҫдһ��
?>
<script type="text/javascript">
function UpatedStatus(type,orders_products_id,extended_hotel_id){
	var status_id = "";
	var provider_code = "";
	switch(type){
		case "change_hotel_status":
			if(typeof(extended_hotel_id) == "undefined" ||extended_hotel_id<1){
				alert('hotel need set extended_hotel_id');
				return false;
			}
			status_id = $('#os_hotel_status_id_'+orders_products_id+'_'+extended_hotel_id).val();
			provider_code = $('#HotelStayProviderCode'+orders_products_id+'_'+extended_hotel_id).val();
		break;
		case "change_airport_status":
			status_id = $('#os_airport_status_id_'+orders_products_id).val();
			provider_code = $('#AirportProviderCode'+orders_products_id).val();
		break;
		case "change_address_status":
			status_id = $('#os_address_status_id_'+orders_products_id).val();
			provider_code = $('#AddressProviderCode'+orders_products_id).val();
		break;
		case "change_orders_change_status":
			status_id = $('#os_orders_changed_status_id_'+orders_products_id).val();
			provider_code = $('#OrdersProviderCode'+orders_products_id).val();
		break;
		default: return false; break;
	}
	
	if(status_id =="3" && provider_code==""){
		alert("������Provider#���ݣ�");
		return false;
	}
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('orders_other_services.php','ajax=true')) ?>");
	var ex_pstr = "";
	if(extended_hotel_id>0){
		ex_pstr = '&extended_hotel_id='+extended_hotel_id;
	}
	url += '&action='+type+'&orders_products_id='+orders_products_id+'&status_id='+status_id+'&provider_code='+provider_code+ex_pstr;
	ajax_get_submit(url);
}

/* ����Frame������start */
var popup=function(element){
	if (arguments.length > 1){
		for (var i = 0, elements = [], length = arguments.length; i < length; i++)
		elements.push($(arguments[i]));
		return elements;
	}
	if (typeof element == 'string'){
		if (document.getElementById){
			element = document.getElementById(element);
		}else if (document.all){
			element = document.all[element];
		}else if (document.layers){
			element = document.layers[element];
		}
	}
	return element;
};

function showGMapHelper(gmapurl, titleStr){
	if(gmapurl!=''){
		//if(gmapurl != jQuery('#gMapIframe').attr('src')){
			//jQuery('#popupConMap').width(325);
			jQuery('#popupMapTitle').html(titleStr);
			jQuery('#gMaptips').show();
			jQuery('#gMapIframe').hide();
			jQuery('#gMapIframe').attr('src',gmapurl);

		//}
		
		showPopup('popupMap','popupConMap',true,0,0,'','',true);
		//showPopup('popupMap','popupConMap','','off');
	}
}

/* ����Frame������end */
</script>

<?php 
/*
<div class="popup" id="popupMap">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
<tr><td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td><td class="con" style="float:none;margin:0;width:auto;">
  <div class="popupCon" id="popupConMap" style="width:325px;">
    <div class="popupConTop" id="dragMap">
      <h3 style=" padding-left:0px;"><b><?= db_to_html("�����շѷ���");?></b></h3>
      <span onClick="closePopup('popupMap')"></span>
      <div onClick="minPopup(this)" class="popupMin">-</div>
    </div>
<iframe frameborder="0" src="" width="825" height="460" style="overflow:hidden; display:none;" id="gMapIframe"></iframe>
<div id="gMaptips" style="color:#999"><img src='ajaxtabs/loading.gif' align='absmiddle'><?= db_to_html("���ڼ��ص�ͼ�����Ժ�...");?></div>
</div>
</td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
</table>
</div>
*/
?>
<?php
$popupMap_body_con_pat = 
'<iframe frameborder="0" src="" width="100%" height="100%" style="overflow:auto; display:none;" id="gMapIframe"></iframe><div id="gMaptips" style="color:#999"><img src="images/loading.gif" align="absmiddle">'.db_to_html("���ڼ���ҳ����Ϣ�����Ժ�...").'</div>';
$layer_obj[sizeof($layer_obj)] = array('pop'=>'popupMap',
									   'drag'=>"popupMap_drag",
									   'con'=>"popupConMap",
									   'con_width'=>"1020px",
									   'body_id'=>"popupMap_LayerBody",
									   'title'=>'<b id="popupMapTitle">�����շѷ���</b>',
									   'body_con'=>$popupMap_body_con_pat
									   );

echo pop_layer_tpl($layer_obj[sizeof($layer_obj)-1], false);
?>

<?php
}
?>
<table id="hotelEx_<?= $order->products[$i]['orders_products_id'];?>" cellpadding="0" cellspacing="0" class="hotelEx">
    <?php
	//�Ƶ���ס
	$HotelPageLinks = tep_href_link('orders_other_services.php','modle=hotel&orders_products_id='.$order->products[$i]['orders_products_id'].'&oID='.$oID);
	$HotelPageLinksAdd = $HotelPageLinks;
	$HotelHistoryLinks = "";
	$HotelStay =$$class_name->GetExtendedStayHotels();
	$HotelStayCount = sizeof($HotelStay);
	if(tep_not_null($HotelStay)){
		for($n=0; $n<$HotelStayCount; $n++){
			$HotelPageLinks = tep_href_link('orders_other_services.php','modle=hotel&orders_products_id='.$order->products[$i]['orders_products_id'].'&oID='.$oID.'&extended_hotel_id='.$HotelStay[$n]['extended_hotel_id']);
			$HotelHistoryLinks = tep_href_link('orders_other_services.php','modle=hotel_history&orders_products_id='.$order->products[$i]['orders_products_id'].'&oID='.$oID.'&extended_hotel_id='.$HotelStay[$n]['extended_hotel_id']);
			//�����ͷ���������
			$hotel_room_info = explode(',',$HotelStay[$n]['hotel_room_info']);
			$hotel_room_num = sizeof($hotel_room_info);
			$hotel_pep_num = array_sum($hotel_room_info);
			//��ס���������ƥ����
			$start_strong_heard = "";
			$start_strong_foot = "";
			$end_strong_heard = "";
			$end_strong_foot = "";
			if($HotelStay[$n]['eh_type']=="before"){	//��ǰ��ס�ļ��
				if($HotelStay[$n]['end_date']==substr($order->products[$i]['products_departure_date'],0,10)){
					$end_strong_heard = '<strong>';  $end_strong_foot = '</strong>'; 
				}
			}
			
			$travel_end_date = substr($order->products[$i]['products_departure_date'],0,10);
			if($HotelStay[$n]['eh_type']=="after"){		//������ס�ļ��
				$products_sql = tep_db_query('select products_durations, products_durations_type from products where products_id="'.(int)$order->products[$i]['id'].'" ');
				$products_row = tep_db_fetch_array($products_sql);
				if($products_row['products_durations_type']=="0" && $products_row['products_durations']>0){
					$day_interval = intval($products_row['products_durations']) - 1;
					$travel_end_date = date('Y-m-d', strtotime($order->products[$i]['products_departure_date'].'+'.$day_interval.' days'));
				}
				unset($products_row);
				if($HotelStay[$n]['start_date']==$travel_end_date){
					$start_strong_heard = '<strong>';  $start_strong_foot = '</strong>'; 
				}
			}
	?>
		<tr>
			<td class="hotelExList">
				<h5>
				�Ƶ���ס <?php if($HotelStayCount>1){ echo ($n+1);}?>
				<?php if(($n+1)==$HotelStayCount){?><a href="javascript:showGMapHelper('<?= $HotelPageLinksAdd?>','�����Ƶ���ס')">����</a><?php }?>
				</h5>
				<div>
					<label>���ʽ:</label><?php echo tep_db_output($HotelStay[$n]['pay_method']);?>
					<label>�Ƶ����:</label><b><?php echo $currencies->format($HotelStay[$n]['hotel_final_price'], true, $order->info['currency'], $order->info['currency_value']);?></b>
					<label>״̬:</label>
					<?php
					foreach ($other_service_status as $value){
						if ($HotelStay[$n]['status_id'] == $value['id']) {
							echo tep_output_string($value['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;'));
							break;
						}
					}
					?>
					
					<?php
					$HotelStayProviderSpanStyle = 'display:none; ';
					if(tep_not_null($HotelStay[$n]['provider_code']) || $HotelStay[$n]['status_id']=="3"){
						$HotelStayProviderSpanStyle = 'display:; ';
					}
					?>
					<label id="<?= $label_id?>" style="<?= $HotelStayProviderSpanStyle?>">
					�Ƶ�ȷ�Ϻ��룺
					<?php echo tep_db_output($HotelStay[$n]['hotel_confirm_number']);?>
					</label>
					
					<?php
					//��ҳ���Ͽ��Ը�����ס״̬���Provider�ĳ���
					if(0){
					?>
					<?php
					$label_id = 'HotelStayProviderLabel'.$order->products[$i]['orders_products_id'].'_'.$HotelStay[$n]['extended_hotel_id'];
					$label_input_id = 'HotelStayProviderCode'.$order->products[$i]['orders_products_id'].'_'.$HotelStay[$n]['extended_hotel_id'];
					echo tep_draw_pull_down_menu('os_hotel_status_id_'.$order->products[$i]['orders_products_id'].'_'.$HotelStay[$n]['extended_hotel_id'], $other_service_status, $HotelStay[$n]['status_id'], 'id="os_hotel_status_id_'.$order->products[$i]['orders_products_id'].'_'.$HotelStay[$n]['extended_hotel_id'].'" class="Select1" onchange="if(this.value==3){ $(\'#'.$label_id.'\').show();}else if($(\'#'.$label_input_id.'\').val().length<1){ $(\'#'.$label_id.'\').hide();}" ');
					?>
					<?php
					$HotelStayProviderSpanStyle = 'display:none; ';
					if(tep_not_null($HotelStay[$n]['provider_code']) || $HotelStay[$n]['status_id']=="3"){
						$HotelStayProviderSpanStyle = 'display:; ';
					}
					?>
					<label id="<?= $label_id?>" style="<?= $HotelStayProviderSpanStyle?>">
					Provider#��
					<?php echo tep_draw_input_num_en_field('HotelStayProviderCode', $HotelStay[$n]['provider_code'], 'id="'.$label_input_id.'" class="textAll"');?>
					</label>
					<button class="AllbuttonHui update" type="button" onClick="UpatedStatus('change_hotel_status','<?= $order->products[$i]['orders_products_id']?>',<?php echo $HotelStay[$n]['extended_hotel_id']?>);">Update</button>
					<?php
					}
					?>
					
					<label>�Ƶ�����:</label><?php echo tep_db_output($HotelStay[$n]['hotel_name']);?>
					<label>��ס����:</label><?php echo $start_strong_heard.$HotelStay[$n]['start_date'].$start_strong_foot;?>
					<label>�������:</label><?php echo $end_strong_heard.$HotelStay[$n]['end_date'].$end_strong_foot;?>
					<label>������:</label><?php echo $hotel_room_num;?>��
					<label>��ס����:</label><?php echo $hotel_pep_num;?>
                    <!--<button class="Allbutton" type="button" onClick="popupWindow1('sms_send_input.php?sms=HotelAddr&orderid=<?php echo (int)$oID;?>&products_id=<?php echo (int)$order->products[$i]['id'];?>&ext_hotel_id=<?php echo $HotelStay[$n]['extended_hotel_id']?>')">�Ƶ꼰λ�ö���ȷ��</button>-->
				</div>
			</td>
			<td class="hotelExList">
				<div class="edit">
				<a href="javascript:showGMapHelper('<?= $HotelPageLinks?>','�༭�Ƶ���ס')">�༭</a>
				<a href="javascript:showGMapHelper('<?= $HotelHistoryLinks?>','�Ƶ���ס��ʷ��¼')" >Logs</a>
				</div>
			</td>
	
		</tr>
    <?php
		}
	}else{
	?>
		<tr>
		<td colspan="2" class="hotelExList">
			<h5>�Ƶ���ס <a href="javascript:showGMapHelper('<?= $HotelPageLinksAdd?>','�����Ƶ���ס')">����</a></h5>
			<!--
            <button class="Allbutton" type="button" onClick="popupWindow1('sms_send_input.php?sms=HotelYZ&orderid=<?php echo (int)$oID;?>&products_id=<?php echo (int)$order->products[$i]['id'];?>')">���������Ƿ���ס�Ƶꡢ���α���</button>
            -->
		</td>
		</tr>

	<?php
	}
	?>
	<?php
	//�������� start
	$AirportPageLinks = tep_href_link('orders_other_services.php','modle=airport&orders_products_id='.$order->products[$i]['orders_products_id'].'&oID='.$oID);
	$AirportHistoryLinks = tep_href_link('orders_other_services.php','modle=airport_history&orders_products_id='.$order->products[$i]['orders_products_id'].'&oID='.$oID);
	$AirportTransfer = $$class_name->GetAirportTransferService();
	if(tep_not_null($AirportTransfer)){
	?>
	<tr>
        <td class="hotelExList hotelExListEven">
            <h5>������/�ͷ���</h5>
            <!--
            <button class="Allbutton" type="button" onClick="popupWindow1('sms_send_input.php?sms=AirportShuttle&orderid=<?php echo (int)$oID;?>&products_id=<?php echo (int)$order->products[$i]['id'];?>')">������/�ͷ������ȷ��</button>
            -->
			<div>
				<label>���ʽ:</label><?php echo tep_db_output($AirportTransfer['pay_method'])?>
				<label>�������:</label><b><?php echo $currencies->format($AirportTransfer['final_price'], true, $order->info['currency'], $order->info['currency_value']);?></b>
				<label>״̬:</label>
				<?php
				foreach ($other_service_status as $value){
					if ($AirportTransfer['status_id'] == $value['id']) {
						echo tep_output_string($value['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;'));
						break;
					}
				}
				?>
				<?php
				$AirportProviderSpanStyle = 'display:none; ';
				if(tep_not_null($AirportTransfer['provider_code']) || $AirportTransfer['status_id']=="3"){
					$AirportProviderSpanStyle = 'display:; ';
				}
				?>
				<label id="<?= $label_id?>" style="<?= $AirportProviderSpanStyle?>">
				Provider#��
				<?php echo tep_db_output($AirportTransfer['provider_code']);?>
				</label>
				
				<?php
				//��ҳ���Ͽ��Ը��ķ���״̬���Provider�ĳ���
				if(0){
				?>
				<?php
				$label_id = 'AirportProviderLabel'.$order->products[$i]['orders_products_id'];
				$label_input_id = 'AirportProviderCode'.$order->products[$i]['orders_products_id'];
				echo tep_draw_pull_down_menu('os_airport_status_id_'.$order->products[$i]['orders_products_id'], $other_service_status, $AirportTransfer['status_id'], 'id="os_airport_status_id_'.$order->products[$i]['orders_products_id'].'" class="Select1" onchange="if(this.value==3){ $(\'#'.$label_id.'\').show();}else if($(\'#'.$label_input_id.'\').val().length<1){ $(\'#'.$label_id.'\').hide();}" ');
				?>
				<?php
				$AirportProviderSpanStyle = 'display:none; ';
				if(tep_not_null($AirportTransfer['provider_code']) || $AirportTransfer['status_id']=="3"){
					$AirportProviderSpanStyle = 'display:; ';
				}
				?>
				<label id="<?= $label_id?>" style="<?= $AirportProviderSpanStyle?>">
				Provider#��
				<?php echo tep_draw_input_num_en_field('AirportProviderCode', $AirportTransfer['provider_code'], 'id="'.$label_input_id.'" class="textAll"');?>
				</label>
                        
				<button class="AllbuttonHui update" type="button" onClick="UpatedStatus('change_airport_status','<?= $order->products[$i]['orders_products_id']?>');">Update</button>
				<?php
				}
				?>
				
				<label>�ִﺽ���:</label><?php echo tep_db_output($AirportTransfer['flight_number'])?>
				<label>�ִ����:</label><?php echo tep_db_output($AirportTransfer['arrival_airport'])?>
				<label>�ִ�ʱ��:</label><?php echo tep_db_output($AirportTransfer['arrival_time'])?>
				<label>��/����ϵ��:</label><?php echo tep_db_output($AirportTransfer['customer_name'])?>
				<label>��/����ϵ�绰:</label><?php echo tep_db_output($AirportTransfer['customer_mobile'])?>
			</div>
        </td>
		<td class="hotelExList hotelExListEven">
        	<div class="edit">
			<a href="javascript:showGMapHelper('<?= $AirportPageLinks?>','�༭������/�ͷ���')">�༭</a>
			<a href="javascript:showGMapHelper('<?= $AirportHistoryLinks?>','������/�ͷ�����ʷ��¼')" >Logs</a>
			</div>
        </td>
    </tr>
    <?php
	}else{
	?>
	<tr>
	<td colspan="2" class="hotelExList hotelExListEven">
		<h5>������/�ͷ��� <a href="javascript:showGMapHelper('<?= $AirportPageLinks?>','����������/�ͷ���')">����</a></h5>
	</td>
    </tr>
	<?php
	}
	//�������� end
	?>
	
	<?php
	//ָ���ص��/�ͷ��� start
	$AddressPageLinks = tep_href_link('orders_other_services.php','modle=address&orders_products_id='.$order->products[$i]['orders_products_id'].'&oID='.$oID);
	$AddressHistoryLinks = tep_href_link('orders_other_services.php','modle=address_history&orders_products_id='.$order->products[$i]['orders_products_id'].'&oID='.$oID);
	$AddressTransfer = $$class_name->GetAddressTransferService();
	if(tep_not_null($AddressTransfer)){
	?>
	<tr>
        <td class="hotelExList">
            <h5>ָ���ص��/�ͷ���</h5>
			<div>
				<label>���ʽ:</label><?php echo tep_db_output($AddressTransfer['pay_method'])?>
				<label>�������:</label><b><?php echo $currencies->format($AddressTransfer['final_price'], true, $order->info['currency'], $order->info['currency_value']);?></b>
				<label>״̬:</label>
				<?php
				$label_id = 'AddressProviderLabel'.$order->products[$i]['orders_products_id'];
				$label_input_id = 'AddressProviderCode'.$order->products[$i]['orders_products_id'];
				echo tep_draw_pull_down_menu('os_address_status_id_'.$order->products[$i]['orders_products_id'], $other_service_status, $AddressTransfer['status_id'], 'id="os_address_status_id_'.$order->products[$i]['orders_products_id'].'" class="Select1" onchange="if(this.value==3){ $(\'#'.$label_id.'\').show();}else if($(\'#'.$label_input_id.'\').val().length<1){ $(\'#'.$label_id.'\').hide();}" ');
				?>
				<?php
				$AddressProviderSpanStyle = 'display:none; ';
				if(tep_not_null($AddressTransfer['provider_code']) || $AddressTransfer['status_id']=="3"){
					$AddressProviderSpanStyle = 'display:; ';
				}
				?>
				<label id="<?= $label_id?>" style="<?= $AddressProviderSpanStyle?>">
				Provider#��
				<?php echo tep_draw_input_num_en_field('AddressProviderCode', $AddressTransfer['provider_code'], 'id="'.$label_input_id.'" class="textAll"');?>
				</label>
				<button class="AllbuttonHui update" type="button" onClick="UpatedStatus('change_address_status','<?= $order->products[$i]['orders_products_id']?>');">Update</button>
				
				<label>��/��ʱ��:</label><?php echo tep_db_output($AddressTransfer['transfer_time'])?>
				<label>��/����ϵ��:</label><?php echo tep_db_output($AddressTransfer['customer_name'])?>
				<label>��/����ϵ�绰:</label><?php echo tep_db_output($AddressTransfer['customer_mobile'])?>
			</div>
        </td>
        <td class="hotelExList">
            <div class="edit">
			<a href="javascript:showGMapHelper('<?= $AddressPageLinks?>','�༭ָ���ص��/�ͷ���')">�༭</a>
			<a href="javascript:showGMapHelper('<?= $AddressHistoryLinks?>','ָ���ص��/�ͷ�����ʷ��¼')" >Logs</a>
			</div>
        </td>
    </tr>
	<?php
	}else{
	?>
	<tr>
        <td colspan="2" class="hotelExList">
            <h5>ָ���ص��/�ͷ��� <a href="javascript:showGMapHelper('<?= $AddressPageLinks?>','����ָ���ص��/�ͷ���')">����</a> </h5>
        </td>
    </tr>
    <?php
	}
	//ָ���ص��/�ͷ��� end
	?>
	<?php
	//�������ķ��� start
	$OrdersChangedPageLinks = tep_href_link('orders_other_services.php','modle=orders_changed&orders_products_id='.$order->products[$i]['orders_products_id'].'&oID='.$oID);
	$OrdersChangedHistoryLinks = tep_href_link('orders_other_services.php','modle=orders_changed_history&orders_products_id='.$order->products[$i]['orders_products_id'].'&oID='.$oID);
	$OrdersChanged = $$class_name->GetOrdersChangedService();
	if(tep_not_null($OrdersChanged)){
	?>
	<tr>
        <td class="hotelExList hotelExListEven">
            <h5>�������ķ���</h5>
			<div>
				<label>���ʽ:</label><?php echo tep_db_output($OrdersChanged['pay_method'])?>
				<label>�������:</label><b><?php echo $currencies->format($OrdersChanged['final_price'], true, $order->info['currency'], $order->info['currency_value']);?></b>
				<label>״̬:</label>
				<?php
				$label_id = 'OrdersProviderLabel'.$order->products[$i]['orders_products_id'];
				$label_input_id = 'OrdersProviderCode'.$order->products[$i]['orders_products_id'];
				echo tep_draw_pull_down_menu('os_orders_changed_status_id_'.$order->products[$i]['orders_products_id'], $other_service_status, $OrdersChanged['status_id'], 'id="os_orders_changed_status_id_'.$order->products[$i]['orders_products_id'].'" class="Select1" onchange="if(this.value==3){ $(\'#'.$label_id.'\').show();}else if($(\'#'.$label_input_id.'\').val().length<1){ $(\'#'.$label_id.'\').hide();}" ');
				?>
				<?php
				$OrdersProviderSpanStyle = 'display:none; ';
				if(tep_not_null($OrdersChanged['provider_code']) || $OrdersChanged['status_id']=="3"){
					$OrdersProviderSpanStyle = 'display:; ';
				}
				?>
				<label id="<?= $label_id?>" style="<?= $OrdersProviderSpanStyle?>">
				Provider#��
				<?php echo tep_draw_input_num_en_field('OrdersProviderCode', $OrdersChanged['provider_code'], 'id="'.$label_input_id.'" class="textAll"');?>
				</label>
				<button class="AllbuttonHui update" type="button" onClick="UpatedStatus('change_orders_change_status','<?= $order->products[$i]['orders_products_id']?>');">Update</button>
			</div>
        </td>
        <td class="hotelExList hotelExListEven">
            <div class="edit">
			<a href="javascript:showGMapHelper('<?= $OrdersChangedPageLinks?>','�༭�������ķ���')">�༭</a>
			<a href="javascript:showGMapHelper('<?= $OrdersChangedHistoryLinks?>','�������ķ�����ʷ��¼')" >Logs</a>
			</div>
        </td>
		
    </tr>
    <?php
	}else{
	?>
	<tr>
        <td colspan="2" class="hotelExList hotelExListEven">
            <h5>�������ķ��� <a href="javascript:showGMapHelper('<?= $OrdersChangedPageLinks?>','�����������ķ���')">����</a> </h5>
        </td>
    </tr>
	<?php
	}
	//�������ķ��� end
	?>
</table>
<?php
}else
//�����༭ҳ������Ҫ��ʾ�Ĳ��� end
?>
<?php
//�༭ҳ����ʾ start
if(basename($_SERVER['PHP_SELF'])=="orders_other_services.php"){
	if(!(int)$_GET['oID'] || !(int)$_GET['orders_products_id']){
		echo ('Fatal Error! No find oID or orders_products_id!');
	}
	$oID = (int)$_GET['oID'];
	$orders_products_id = (int)$_GET['orders_products_id'];
	$PublicClass = new OrderOtherService($orders_products_id);
	$os_status = $PublicClass->GetAllStatus();
	$os_payments = $PublicClass->GetAllPayMethod();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css" />
<?php
switch($_GET['modle']){
	case "hotel": $title ="�Ƶ���ס"; break;
	case "airport": $title ="������/�ͷ���"; break;
	case "address": $title ="ָ���ص��/�ͷ���"; break;
	case "orders_changed": $title ="�������ķ���"; break;
	case "hotel_history": $title ="�Ƶ��޸���ʷ��¼"; break;
	case "airport_history":	$title ="������/�ͷ�����ʷ��¼"; break;
	case "address_history": $title ="ָ���ص��/�ͷ�����ʷ��¼"; break;
	case "orders_changed_history": $title ="�������ķ�����ʷ��¼"; break;
}
?>
<title><?= $title?></title>

<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript" src="includes/jquery-1.3.2/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="includes/javascript/calendar.js"></script>
<script type="text/javascript" src="includes/javascript/add_global.js"></script>
<script type="text/javascript" src="includes/javascript/popup.js"></script>
<script type="text/javascript" src="includes/big5_gb-min.js"></script>
<script type="text/javascript">
/*--������js����--*/
//��ʾ������Provider#�����
function ShowHideProviderSpan(obj){
	if($('#ProviderSpan').find('input[name="provider_code"]').val()!="" || obj.value=="3"){
		$('#ProviderSpan').show();
	}else{
		$('#ProviderSpan').hide();
	}
}
</script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!--<div class="pathLink">��ǰλ�ã�<a href="<?= tep_href_link('orders.php');?>">�����б�</a> -&gt; <a href="<?= tep_href_link('edit_orders.php','oID='.$oID);?>">�����༭#<?= $oID?></a> -&gt;<?= $title;?></div>-->
<div class="pathLink">��ǰλ�ã������б� -&gt; �����༭#<?= $oID?> -&gt;<?= $title;?></div>

<?php
	//�г���Ϣ
	$orders_products_sql = tep_db_query('select * from orders_products where orders_products_id="'.$orders_products_id.'" AND orders_id="'.$oID.'" ');
	$orders_products = tep_db_fetch_array($orders_products_sql);
	if(!(int)$orders_products['orders_products_id']){ die('No find orders_products'); }
	$products_departure_date = substr($orders_products['products_departure_date'],0,10);
	$departure_date = chardate($orders_products['products_departure_date'],'D','1');
	$departure_week = en_to_china_weeks(date('D',strtotime($orders_products['products_departure_date'])));
	$departure_time = $orders_products['products_departure_time'];
	
	$products_sql = tep_db_query('select products_durations, products_durations_type from products where products_id="'.$orders_products['products_id'].'" ');
	$products_row = tep_db_fetch_array($products_sql);
	if($products_row['products_durations_type']=="0" && $products_row['products_durations']>0){
		$day_interval = intval($products_row['products_durations']) - 1;
		$travel_end_date_time = date('Y-m-d H:i:s',strtotime($orders_products['products_departure_date'].'+'.$day_interval.' days'));
		$travel_end_date = chardate($travel_end_date_time, 'D','1');
		$travel_end_date .= ' '.en_to_china_weeks(date('D',strtotime($travel_end_date_time)));
		$products_departure_end_date = substr($travel_end_date_time,0,10);
	}else{
		$travel_end_date = '����';
		$products_departure_end_date = $products_departure_date;
	}
?>
<div class="hotelExtend">
	<div class="con">
		<h2>�г���Ϣ</h2>
		<h3><a href="<?= tep_catalog_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders_products['products_id'] );?>" target="_blank"><?php echo tep_db_output($orders_products['products_name']);?></a></h3>
		<ul>
			<li>
				<label>�г̳���ʱ�䣺</label><?php echo $departure_date.' '.$departure_week;?>
			</li>
			<?php
			if(strstr($departure_time,':')){
			?>
			<li>
				<label>�ϳ�ʱ�䣺</label><?php echo $departure_date.' '.$departure_week.' '.$departure_time;?>
			</li>
			<?php
			}
			?>
			<li>
				<label>�г̽���ʱ�䣺</label><?php echo $travel_end_date;?>
			</li>
		</ul>
	</div>
</div>

<?php 	
	switch($_GET['modle']){
		case "hotel":	//�Ƶ���ס
			//�Ƶ���Ϣ
			if((int)$_GET['extended_hotel_id']){
				$extended_hotel_sql = tep_db_query('SELECT * FROM `orders_products_extended_hotel` WHERE extended_hotel_id="'.(int)$_GET['extended_hotel_id'].'" ');
				$extended_hotel_row = tep_db_fetch_array($extended_hotel_sql);
				if((int)$extended_hotel_row['orders_products_id']){
					$HotelInfo = new objectInfo($extended_hotel_row);
					foreach($HotelInfo as $key => $val){
						$$key = $val;
					}
				}
			}
?>
<script type="text/javascript">
jQuery().ready(function() {
	var Form = jQuery("#hotelExtendForm");
	//ѡ�񷿼���������������
	function RoomNumSelect(){
		Form.find('#room_num').change(function(){
			var room_number = this.value;
			var old_room_number = $('#RoomCon').find('input').length;
			//alert(old_room_number);
			if(room_number>old_room_number){
				var add_num = room_number-old_room_number;
				var add_content = "";
				for(var i=0; i<add_num; i++){
					add_content += '<div class="roomCol">��'+(old_room_number+i+1)+'����:<input type="text" onBlur="FillPepNum()" style="ime-mode: disabled;" maxlength="2" class="textRoom" name="room_pep[]">��</div>';
				}
				$('#RoomCon').append(add_content);
			}
			if(room_number<old_room_number){
				var less_num = old_room_number-room_number;
				for(var i=0; i<less_num; i++){
					var last_ = $('#RoomCon div:last');
					last_.remove();
				}
			}
			FillPepNum();
			count_hotel_final_price();
		});
	}
	RoomNumSelect();
	
	//������סģʽ�Զ������ס���ڻ��������
	function Check_eh_type(){
		Form.find('#eh_type').change(function(){
			if($(this).val()=="after"){
				Form.find('input[name="start_date"]').val($('#products_departure_end_date').val());
				Form.find('input[name="end_date"]').val(""); 
			}else if($(this).val()=="before"){
				Form.find('input[name="end_date"]').val($('#products_departure_date').val()); 
				Form.find('input[name="start_date"]').val("");
			}else{
				alert("��ѡ�� ��סģʽ��");
			}
			
		});
	}
	Check_eh_type();
});

//�Ƶ���ס���ύ
function SubmitHotelExtendForm(){
	var Form = jQuery("#hotelExtendForm");
	var error = false;
	var error_msn = "";
	count_hotel_final_price();
	if(Form.find('input[name="start_date"]').val().length<10){
		error = true;
		error_msn+= '��ѡ����ס����'+"\n\n";
	}
	if(Form.find('input[name="end_date"]').val().length<10){
		error = true;
		error_msn+= '��ѡ���������'+"\n\n";
	}
	if($('#eh_type').val() ==""){
		error = true;
		error_msn+= '��ѡ�� ��סģʽ��'+"\n\n";
	}
	if(Form.find('input[name="start_date"]').val()>=Form.find('input[name="end_date"]').val()){
		error = true;
		error_msn+= '������� ��������ס����֮��'+"\n\n";
	}
	if(Form.find('select[name="status_id"]').val()=="3" && Form.find('input[name="provider_code"]').val().length<2){
		error = true;
		error_msn+= '������ Provider# ���ݣ�'+"\n\n";
	}
	
	
	
	if(error == true){
		alert(error_msn);
		return false;
	}else if($('#ConfirmationSubmitted').val()!="1"){
		if($('#eh_type').val() =="after" && Form.find('input[name="start_date"]').val()!=$('#products_departure_end_date').val()){
			error = true;
			showPopup('popupTime','popupConTime','','off');
			return false;
		}
		if($('#eh_type').val() =="before" && Form.find('input[name="end_date"]').val()!=$('#products_departure_date').val()){
			error = true;
			showPopup('popupTime','popupConTime','','off');
			return false;
		}
	}
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('orders_other_services.php','action=submit_hotel_extend')) ?>");
	var form_id = "hotelExtendForm";
	var success_msm = "";
	ajax_post_submit(url,form_id);
}

//�Զ������ס����
function FillPepNum(){
	var InputObj = $('#RoomCon').find('input[name="room_pep[]"]');
	var tmpVal = 0;
	InputObj.each(function(){
	  tmpVal += Number($(this).val());
	});
	$('#hotelExtendForm').find('input[name="people_number"]').val(tmpVal);
}

//ͳ����������(��ʽ=�Ƶ�۸�*������*��ס����)
function count_hotel_final_price(){
	var final_price = Number($('#hotel_price').val()) * Number($('#room_num').val());
	if($('#start_date').val().length==10 && $('#end_date').val().length==10){
		var time_num = strtotime($('#end_date').val())-strtotime($('#start_date').val());
		if(time_num>1){
			final_price = final_price * (time_num/86400);
		}
	}
	$('#hotel_final_price').val(final_price);
}

// strtotime
function strtotime(time_str, fix_time){
    var time  = (new Date()).getTime();
    if (time_str){
        var str = time_str.split('-');
        if (3 === str.length){
            var year  = str[0] - 0;
            var month = str[1] - 0 - 1;
            var day   = str[2] - 0;
            if (fix_time){
                var fix = fix_time.split(':');
                if (2 === fix.length){
                    var hour   = fix[0] - 0;
                    var minute = fix[1] - 0;
                    time = (new Date(year, month, day, hour, minute)).getTime();
                }
            } else{
                time = (new Date(year, month, day)).getTime();
            }
        }
    }
    time = time/1000;
    return time;
}

//ѡ��Ƶ�
function SelectHotel(obj){
	$('#hotelExtendForm').find('input[name="hotel_name"]').val(obj.title);
	$('#hotelExtendForm').find('input[name="hotel_id"]').val(obj.value);
	GetHotelInfo();
}
//���������Ƶ�
function SearchHotel(obj){
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('orders_other_services.php','action=search_hotel')) ?>");
	var form_id = "SearchHotelForm";
	var success_msm = "";
	ajax_post_submit(url,form_id);
}
//ȡ�þƵ���Ϣ
function GetHotelInfo(){
	var h_id = $('#hotelExtendForm').find('input[name="hotel_id"]').val();
	if(h_id>0){
		var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('orders_other_services.php','action=get_hotel_info&ajax=true')) ?>");
		url += '&hotel_id='+h_id;
		ajax_get_submit(url);
	}
}

//�Զ����þƵ����ס�Ŀ�ʼ����
function auto_set_start_date(obj){
	if(obj.value!=""){ return false;}
	if($('#end_date').val()!=""){
		var tmp_val = $('#end_date').val().substring(0,8);
		obj.value = tmp_val+"01";
	}
}
//�Զ����þƵ���������
function auto_set_end_date(obj){
	if(obj.value!=""){ return false;}
	if($('#start_date').val()!=""){
		var tmp_array = $('#start_date').val().split('-');
		//var tmpDate = new Date(2011,01,29);  
		var tmpDate = new Date(tmp_array[0], ((tmp_array[1]-1)+1), 1);
		tmpDate.setDate(tmpDate.getDate()-1);
		//tmpDate.setFullYear(tmp_array[0]);
		var Year = tmpDate.getFullYear();
		var Month = tmpDate.getMonth()+1;
		if(Month<10){ Month = "0"+Month; }
		var Dates = tmpDate.getDate();
		if(Dates<10){ Dates = "0"+Dates; }
		obj.value = Year+'-'+Month+'-'+ Dates;
	}
}
</script>
<div class="hotelExtend">
	<form id="hotelExtendForm" action="" enctype="multipart/form-data" method="post" onSubmit="SubmitHotelExtendForm(); return false;" >
	<input name="extended_hotel_id" type="hidden" id="extended_hotel_id" value="<?= $extended_hotel_id;?>" />
    <input name="hotel_id" type="hidden" value="<?= $hotel_id;?>" />
    <input name="orders_id" type="hidden" value="<?= $oID;?>" />
    <input name="orders_products_id" type="hidden" value="<?= $orders_products_id;?>" />
	<input type="hidden" name="products_departure_date" id="products_departure_date" value="<?= $products_departure_date?>" />
	<input type="hidden" name="products_departure_end_date" id="products_departure_end_date" value="<?= $products_departure_end_date?>" />
    <div class="head">�Ƶ���ס</div>
    <div class="con">
		<h2>�Ƶ�Ԥ����Ϣ</h2>
        <div id="HotelInfo" class="hotelInfo">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">	
                <tr>
                    <td width="65">��סģʽ��</td>
                    <td width="300">
                        <?php
						$options = array();
						$options[] = array('id'=>"", 'text'=>'��ѡ����סģʽ');
						$options[] = array('id'=>"before", 'text'=>'��ǰ��ס');
						$options[] = array('id'=>"after", 'text'=>'������ס');
						echo tep_draw_pull_down_menu('eh_type',$options,$eh_type,'id="eh_type" ');
						?>

                    </td>
                    <td width="65">Ԥ��������</td>
                    <td>
					<?php
					echo tep_draw_input_field('customer_name',$customer_name,'class="textAll" ');
					?>
					</td>
                    <td width="65">Ԥ���ֻ���</td>
                    <td>
					<?php
					echo tep_draw_input_num_en_field('customer_mobile',$customer_mobile,'class="textAll" ');
					?>
					</td>
                </tr> 
                <tr>
                    <td>�Ƶ����ƣ�</td>
                    <td>
					<?php
					echo tep_draw_input_field('hotel_name',$hotel_name,'onClick="showPopup(\'popupHotel\',\'popupConHotel\',\'\',\'off\');" class="textAll hotel" readonly="readonly" ');
					?>
					<div class="zoom" onClick="showPopup('popupHotel','popupConHotel','','off');"><img alt="zoom" src="images/zoom.gif" /></div>
					</td>
                    <td>��ס���ڣ�</td>
                    <td>
					<?php
					echo tep_draw_input_num_en_field('start_date',$start_date,'id="start_date" class="textTime" onBlur="count_hotel_final_price();" onclick="auto_set_start_date(this); GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);"');
					?>
					</td>
                    <td>������ڣ�</td>
                    <td>
					<?php
					echo tep_draw_input_num_en_field('end_date',$end_date,'id="end_date" class="textTime" onBlur="count_hotel_final_price();"  onclick="auto_set_end_date(this); GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);"');
					?>
					
					</td>
                </tr>
                <tr>
                    <td>�Ƶ�۸�</td>
                    <td>
					<?php
					echo tep_draw_input_num_en_field('hotel_price',$hotel_price,'id="hotel_price" onBlur="count_hotel_final_price();" class="textAll" ');
					?>
					</td>
                    <td>
					���ʽ��
					</td>
                    <td>
				   <?php
				   echo tep_draw_pull_down_menu('pay_method', $os_payments, $pay_method);
				   ?>
					</td>
                    <td>��ס������</td>
                    <td>
					<?php
					echo tep_draw_input_num_en_field('people_number',$people_number,'class="textAll" ');
					?>
					</td>
                </tr>

                <tr>
                    <td valign="top">��������</td>
                    <td>
					<div class="roomCon">
						<div>
					<?php
					$r_options = array();
					for($ii=0; $ii<15; $ii++){
						$t_num = $ii+1;
						$r_options[]=array('id'=>$t_num,'text'=>$t_num.'��');
					}
					
					$hotel_room_info = explode(',',$hotel_room_info);
					$hotel_room_num = sizeof($hotel_room_info);
					//$hotel_pep_num = array_sum($hotel_room_info);

					echo tep_draw_pull_down_menu('room_num',$r_options,$hotel_room_num,'id="room_num" class="selAll"');
					?>
						�������ã�<span class="price">$</span> <?php echo tep_draw_input_num_en_field('hotel_final_price',$hotel_final_price, 'id="hotel_final_price" class="textAll price"'); ?>
						</div>
					</div>
                    </td>
                    <td>
                    <label title="�Ƶ�ȷ�Ϻ��룬���ÿ�ȷ����ס����������ѷ���þƵ�󣬲���Ӵ���Ϣ">�Ƶ���룺</label>
                    </td>
                    <td colspan="3">
                    <?php
					echo tep_draw_input_field('hotel_confirm_number',$hotel_confirm_number,'class="textAll" ');
					?>
                    </td>
                </tr>

                <tr>
                    <td valign="top"> </td>
                    <td colspan="5">
					<div id="RoomCon" class="roomCon">
					<?php
					for($rn = 0; $rn < $hotel_room_num; $rn++){
						echo '<div class="roomCol">��'.($rn+1).'����:'.tep_draw_input_num_en_field('room_pep[]',$hotel_room_info[$rn],'onBlur="FillPepNum()" maxlength="2" class="textRoom" ').'��</div>';
					}
					?>
					</div>
                    </td>
                </tr>
                
                <tr>
                	<td valign="top">��ע��</td>
                	<td colspan="5">
					<?php
					echo  tep_draw_textarea_field('remarks','wrap','40','5',$remarks, ' class="textarea"');
					?>
					</td>
                	</tr>
            </table>

        </div>


        <h2>�Ƶ���ס״̬</h2>
        <div class="providerConfirm" id="ProviderConfirm">
            <label>��ǰ״̬:</label>
            <?php
			echo tep_draw_pull_down_menu('status_id', $os_status, $status_id,'onchange="ShowHideProviderSpan(this)" ');
			
			$ProviderSpanStyle = 'display:none; ';
			if(tep_not_null($provider_code) || $status_id=="3"){
				$ProviderSpanStyle = 'display:; ';
			}
			?>
			&nbsp;&nbsp;
            <span id="ProviderSpan" style="<?= $ProviderSpanStyle?>">
			<label>Provider#��</label>
			<?php echo tep_draw_input_num_en_field('provider_code', $provider_code, 'class="textAll"');?>
			</span>
        </div>
    </div>

    <div class="foot"><button type="submit" id="send" class="Allbutton" value="Update">Update</button>&nbsp;
    	
    	&nbsp;<!--<button type="button" id="Button1" class="Allbutton" value="Send E-ticket">Send E-ticket</button>&nbsp;&nbsp;--><button type="button" class="AllbuttonHui" onClick="parent.jQuery('#popupMap').hide()">����</button></div>
    </form>
</div>
<div id="popupBg" class="popupBg"></div>

<?php
//�Ƶ���б���Ϣ


?>
<div class="popup" id="popupHotel">

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
    <tr>
      <td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td>
        <td class="con">
          <div class="popupCon" id="popupConHotel" style="width:660px; padding:0;">
            <div class="popupConTop popupConTopHotel" id="dragHotel">
              <h3><b>��ѡ��Ҫ��ס�ľƵ�</b></h3><span onClick="closePopup('popupHotel')"></span>
            </div>
            <div class="popupSearch"><form id="SearchHotelForm" action="" enctype="multipart/form-data" method="post"><label>���ѣ�</label><input name="search_hotel_name" type="text" class="textAll"  onkeyup="SearchHotel(this)" /></form></div>
			<ul id="HotelList" class="hotelList" style="height:140px; overflow:auto;">
              <?php
			  $hotel_where = ' 1 ';
				if((int)$hotel_id){
					$hotel_where .= ' AND hotel_id="'.(int)$hotel_id.'" ';
				}
			  $hotel_sql = tep_db_query('SELECT hotel_id, hotel_name FROM `hotel` WHERE '.$hotel_where.' order by hotel_name ');
			  while($hotel_rows = tep_db_fetch_array($hotel_sql)){
			  ?>
			  <li><label><input name="hotelListRadio" value="<?= $hotel_rows['hotel_id']?>" title="<?php echo tep_db_output($hotel_rows['hotel_name']);?>" type="radio" onClick="SelectHotel(this);" /><?php echo tep_db_output($hotel_rows['hotel_name']);?></label></li>
              <?php
			  }
			  ?>
            </ul>
            
            
            <div class="hotelListBtn"><button type="submit" id="HotelListBtn" class="Allbutton" onClick="closePopup('popupHotel');" >ȷ��</button></div>
            
            <div class="hotelDetail" id="HotelDetail" style="display:none">

              <h1 id="HotelDetail_h1"><!--�Ƶ����--></h1>
              <table border="0" cellpadding="0" cellspacing="0" class="detailTable">
                <tr>
                  <td width="60"><label>�Ƶ����ƣ�</label></td><td id="HotelDetail_HotelName"></td>
                </tr>
                <tr>
                  <td><label>�Ƶ��Ǽ���</label></td><td id="HotelDetail_HotelStars"></td>
                </tr>
                <tr>
                  <td><label>��ַ��</label></td><td id="HotelDetail_HotelAddress"></td>
                </tr>
                <tr>
                  <td><label>�绰��</label></td><td id="HotelDetail_HotelPhone"></td>
                </tr>
                <tr>
                  <td valign="top"><label>��飺</label></td><td id="HotelDetail_Description"></td>
                </tr>
              </table>
              <!--
			  <h2>�Ƶ긽���ļ��ϵص��ʱ��</h2>
              <ul>
                <li><a href="">3:00pm ��˹ά��˹Tropicana�Ƶ��ʿͣ����</a></li>
                <li><a href="">8:00pm  Comfort Suites Rosemead�����޾Ƶ���ˣ�</a></li>
                <li><a href="">6:00pm С������»�ٺ��� (Westminster)</a></li>
              </ul>
              -->
            </div>
	     </div>
 </td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
  </table>
</div>


<div class="popup" id="popupTime" >
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
<tr><td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td><td class="con">

  <div class="popupCon" id="popupConTime" style="width:412px; padding:12px;">
    <div class="popupConTop" id="dragTime">
      <h3><b>�Ƶ�����ʱ�����г�ʱ�䲻ƥ��</b></h3><span onClick="$('#ConfirmationSubmitted').val('0'); closePopup('popupTime')"></span>
    </div>
    <p>
       �Ƶ���סʱ�����г�ʱ�䲻ƥ�䣬��ȷ��<br />Ԥ�����ʱ��εľƵ���
    </p>
    <div class="popBtn1">
        <input id="ConfirmationSubmitted" type="hidden" value="0" />
		<button value="Update" class="Allbutton" onClick="$('#ConfirmationSubmitted').val('1');SubmitHotelExtendForm();" type="submit">ȷ��</button>&nbsp;&nbsp;
        <button onClick="$('#ConfirmationSubmitted').val('0'); closePopup('popupTime');" class="AllbuttonHui" type="submit">�ر�</button>
    </div>
  </div>
  
</td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
</table>
</div>

<script type="text/javascript">
//���õ����㶥����ҷ 
new divDrag([popup('dragTime'),popup('popupTime')]); 
new divDrag([popup('dragHotel'),popup('popupHotel')]); 
</script>

<?php			
		break;
		case "airport"://��������
			//����������Ϣ
			if(!(int)$_POST['orders_products_id']){
				$airport_transfer_sql = tep_db_query('SELECT * FROM `orders_products_airport_transfer` WHERE orders_products_id="'.$orders_products_id.'" ');
				$airport_transfer_row = tep_db_fetch_array($airport_transfer_sql);
				if((int)$airport_transfer_row['orders_products_id']){
					$AirportTransferInfo = new objectInfo($airport_transfer_row);
					foreach($AirportTransferInfo as $key => $val){
						$$key = $val;
					}
				}
			}

?>
<script type="text/javascript">
function SubmitAirportTransferForm(obj){
	var error = false;
	var error_msn = "";
	if(obj.elements["status_id"].value=="3" && obj.elements["provider_code"].value.length<2){
		error = true;
		error_msn+= '������ Provider# ���ݣ�'+"\n\n";
	}
	if(error == true){
		alert(error_msn);
		return false;
	}
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('orders_other_services.php','action=submit_airport_transfer')) ?>");
	var form_id = obj.id;
	ajax_post_submit(url,form_id);
}
function sel_service_type(radioObj){
	var form = document.getElementById("AirportTransferForm");
	var PickUpTitle =document.getElementById("pick_up_title");
	if(radioObj.value=="1" && radioObj.checked){
		PickUpTitle.style.display="";
		form.elements["pick_up"].style.display="";
	}else{
		PickUpTitle.style.display="none";
		form.elements["pick_up"].style.display="none";
	}
}

jQuery().ready(function() {
	sel_service_type(document.getElementById("service_type_0"));
	sel_service_type(document.getElementById("service_type_1"));
});

</script>
<div class="hotelExtend">
  <form id="AirportTransferForm" action="" enctype="multipart/form-data" method="post" onSubmit="SubmitAirportTransferForm(this); return false;" >
    <input name="orders_id" type="hidden" value="<?= $oID;?>" />
    <input name="orders_products_id" type="hidden" value="<?= $orders_products_id;?>" />
  <div class="head">������Ŀ</div>
  <div class="con">
    <h2>������/�ͷ���</h2>
    <div class="hotelInfo">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">	
        <tr>
          <td width="90">������ã�</td>
          <td>
			<?php
			echo tep_draw_input_num_en_field('final_price','','class="textAll" ');
			?>
		</td>
          <td width="90">���ʽ��</td>
          <td>
           <?php
		   echo tep_draw_pull_down_menu('pay_method', $os_payments, $pay_method);
		   ?>
          </td>
          <td width="100">�ִ����ں�ʱ�䣺</td>
          <td><?php
			echo tep_draw_input_num_en_field('arrival_time','','class="textAll" ');
			?></td>
        </tr> 
        <tr>
          <td>�ִﺽ��ţ�</td>
          <td>
			<?php
			echo tep_draw_input_field('flight_number','','class="textAll" ');
			?>
		  </td>
          <td>�ִ������</td>
          <td>
			<?php
			echo tep_draw_input_field('arrival_airport','','class="textAll" ');
			?>
		  </td>
          <td>Drop off��</td>
          <td>
		  <?php
			echo tep_draw_input_num_en_field('drop_off','','class="textAll" ');
			?>
			&nbsp;<label><?php echo tep_draw_radio_field('service_type','0', '', '', 'id="service_type_0" onclick="sel_service_type(this);" ');?>����</label> <label><?php echo tep_draw_radio_field('service_type','1', '', '', 'id="service_type_1" onclick="sel_service_type(this);" ');?>����</label>
			</td>
        </tr>
        <tr>
        	<td>��/����ϵ�ˣ�</td>
        	<td>
        		<?php
			echo tep_draw_input_field('customer_name','','class="textAll" ');
			?>
        		</td>
        	<td>��/����ϵ�绰��</td>
        	<td>
        		<?php
			echo tep_draw_input_field('customer_mobile','','class="textAll" ');
			?>
        		</td>
        	<td><span id="pick_up_title">Pick up��</span></td>
        	<td><?php
			echo tep_draw_input_field('pick_up','','id="pick_up" class="textAll" ');
			?></td>
        	</tr>
        
		<tr>
			<td valign="top">��ע��</td>
			<td colspan="5">
				<?php
			echo tep_draw_textarea_field('remarks','wrap','40','5',$remarks, ' class="textarea"');
			?>
				</td>
		</tr>
      </table>

    </div>
    
    
    <h2>��������״̬</h2>
    <div class="providerConfirm" id="Div2">
		<label>��ǰ״̬:</label>
		<?php
		echo tep_draw_pull_down_menu('status_id', $os_status, $status_id,'onchange="ShowHideProviderSpan(this)" ');
		
		$ProviderSpanStyle = 'display:none; ';
		if(tep_not_null($provider_code) || $status_id=="3"){
			$ProviderSpanStyle = 'display:; ';
		}
		?>
		&nbsp;&nbsp;
		<span id="ProviderSpan" style="<?= $ProviderSpanStyle?>">
		<label>Provider#��</label>
		<?php echo tep_draw_input_num_en_field('provider_code', $provider_code, 'class="textAll"');?>
		</span>
    </div>
  </div>
  
  <div class="foot"><button type="submit" id="Button2" class="Allbutton" value="Update">Update</button>&nbsp;&nbsp;<button type="button" class="AllbuttonHui" onClick="parent.jQuery('#popupMap').hide()">����</button></div>
  </form>
</div>
<?php			
		break;
		case "address"://ָ���ص����
			//ָ���ص������Ϣ
			if(!(int)$_POST['orders_products_id']){
				$address_transfer_sql = tep_db_query('SELECT * FROM `orders_products_address_transfer` WHERE orders_products_id="'.$orders_products_id.'" ');
				$address_transfer_row = tep_db_fetch_array($address_transfer_sql);
				if((int)$address_transfer_row['orders_products_id']){
					$AddressTransferInfo = new objectInfo($address_transfer_row);
					foreach($AddressTransferInfo as $key => $val){
						$$key = $val;
					}
				}
			}
?>
<script type="text/javascript">
function SubmitAddressTransferForm(obj){
	var error = false;
	var error_msn = "";
	if(obj.elements["status_id"].value=="3" && obj.elements["provider_code"].value.length<2){
		error = true;
		error_msn+= '������ Provider# ���ݣ�'+"\n\n";
	}
	if(error == true){
		alert(error_msn);
		return false;
	}
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('orders_other_services.php','action=submit_address_transfer')) ?>");
	var form_id = obj.id;
	ajax_post_submit(url,form_id);
}
function sel_service_type(radioObj){
	var form = document.getElementById("AddressTransferForm");
	var tr1 =document.getElementById("tr_transfer1");
	if(radioObj.value=="1" && radioObj.checked){
		tr1.style.display="";
		if(form.elements["transfer_address1"].value==""){
			form.elements["transfer_address1"].value=form.elements["transfer_to_address"].value;
		}
		if(form.elements["transfer_to_address1"].value==""){
			form.elements["transfer_to_address1"].value=form.elements["transfer_address"].value;
		}
	}else{
		tr1.style.display="none";
	}
}

jQuery().ready(function() {
	sel_service_type(document.getElementById("service_type_0"));
	sel_service_type(document.getElementById("service_type_1"));
});
</script>
<div class="hotelExtend">
  <form id="AddressTransferForm" action="" enctype="multipart/form-data" method="post" onSubmit="SubmitAddressTransferForm(this); return false;" >
    <input name="orders_id" type="hidden" value="<?= $oID;?>" />
    <input name="orders_products_id" type="hidden" value="<?= $orders_products_id;?>" />
  <div class="head">������Ŀ</div>
  <div class="con">
    <h2>ָ���ص��/�ͷ���</h2>
    <div class="hotelInfo">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">	
        <tr>
          <td width="134">������ã�</td>
          <td>
			<?php
			echo tep_draw_input_num_en_field('final_price','','class="textAll" ');
			?>
		  </td>
          <td width="90">���ʽ��</td>
          <td>
           <?php
		   echo tep_draw_pull_down_menu('pay_method', $os_payments, $pay_method);
		   ?>
          </td>
          <td width="90">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr> 
        <tr>
          <td>������ϵ�ˣ�</td>
          <td>
			<?php
			echo tep_draw_input_field('customer_name','','class="textAll" ');
			?>
		  </td>
          <td>������ϵ�绰��</td>
          <td>
			<?php
			echo tep_draw_input_field('customer_mobile','','class="textAll" ');
			?>
		  </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        	<td><label><?php echo tep_draw_radio_field('service_type','0', '', '', 'id="service_type_0" onclick="sel_service_type(this);" ');?>����</label> <label><?php echo tep_draw_radio_field('service_type','1', '', '', 'id="service_type_1" onclick="sel_service_type(this);" ');?>����</label></td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	</tr>
        <tr>
        	<td>�������ں�ʱ�䣺</td>
        	<td><?php
			echo tep_draw_input_num_en_field('transfer_time','','class="textAll" ');
			?></td>
        	<td>From address��</td>
        	<td><?php
			echo tep_draw_input_field('transfer_address','','class="textAll" ');
			?></td>
        	<td>To address��</td>
        	<td><?php
			echo tep_draw_input_field('transfer_to_address','','class="textAll" ');
			?></td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	</tr>
        <tr id="tr_transfer1">
        	<td>�������ں�ʱ�䣨������</td>
        	<td><?php
			echo tep_draw_input_num_en_field('transfer_time1','','class="textAll" ');
			?></td>
        	<td>From address��</td>
        	<td><?php
			echo tep_draw_input_field('transfer_address1','','class="textAll" ');
			?></td>
        	<td>To address��</td>
        	<td><?php
			echo tep_draw_input_field('transfer_to_address1','','class="textAll" ');
			?></td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	</tr>
        
        <tr>
          <td valign="top">��ע��</td>
          <td colspan="7">
			<?php
			echo tep_draw_textarea_field('remarks','wrap','40','5',$remarks, ' class="textarea"');
			?>
          </td>
        </tr>
      </table>

    </div>
    
    
    <h2>״̬</h2>
    <div class="providerConfirm" id="Div2">
		<label>��ǰ״̬:</label>
		<?php
		echo tep_draw_pull_down_menu('status_id', $os_status, $status_id,'onchange="ShowHideProviderSpan(this)" ');
		
		$ProviderSpanStyle = 'display:none; ';
		if(tep_not_null($provider_code) || $status_id=="3"){
			$ProviderSpanStyle = 'display:; ';
		}
		?>
		&nbsp;&nbsp;
		<span id="ProviderSpan" style="<?= $ProviderSpanStyle?>">
		<label>Provider#��</label>
		<?php echo tep_draw_input_num_en_field('provider_code', $provider_code, 'class="textAll"');?>
		</span>
    </div>
  </div>
  
  <div class="foot"><button type="submit" id="Button3" class="Allbutton" value="Update">Update</button>&nbsp;&nbsp;<button type="button" class="AllbuttonHui" onClick="parent.jQuery('#popupMap').hide()">����</button></div>
  </form>
</div>
<?php
		break;
		case "orders_changed"://�������ķ���
			//�������ķ�����Ϣ
			if(!(int)$_POST['orders_products_id']){
				$oreders_change_sql = tep_db_query('SELECT * FROM `orders_products_orders_change` WHERE orders_products_id="'.$orders_products_id.'" ');
				$oreders_change_row = tep_db_fetch_array($oreders_change_sql);
				if((int)$oreders_change_row['orders_products_id']){
					$OrdersChangeInfo = new objectInfo($oreders_change_row);
					foreach($OrdersChangeInfo as $key => $val){
						$$key = $val;
					}
				}
			}
?>
<script type="text/javascript">
function SubmitOrdersChangedForm(obj){
	var error = false;
	var error_msn = "";
	if(obj.elements["status_id"].value=="3" && obj.elements["provider_code"].value.length<2){
		error = true;
		error_msn+= '������ Provider# ���ݣ�'+"\n\n";
	}
	if(error == true){
		alert(error_msn);
		return false;
	}
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('orders_other_services.php','action=submit_orders_changed')) ?>");
	var form_id = obj.id;
	ajax_post_submit(url,form_id);
}
</script>
<div class="hotelExtend">
  <form id="OrdersChangedForm" action="" enctype="multipart/form-data" method="post" onSubmit="SubmitOrdersChangedForm(this); return false;" >
    <input name="orders_id" type="hidden" value="<?= $oID;?>" />
    <input name="orders_products_id" type="hidden" value="<?= $orders_products_id;?>" />
  <div class="head">������Ŀ</div>
  <div class="con">
    <h2>�������ķ���</h2>
    <div class="hotelInfo">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">	
        <tr>
        	<td width="100">���ò���ԭ��</td>
        	<td>
			<?php
			//���ò���ԭ�򣺸��ĺ�����Ϣ�����Ĳ��������������г̣������ϳ��ص㣻���ĳ������ڣ�����
			$reason_options = array();
			$reason_options[] = array('id'=>0,'text'=>'--��ѡ��--');
			$reason_sql = tep_db_query('SELECT reason_id, reason_text FROM `orders_products_orders_change_reason` Order By reason_id ');
			while($reason_rows = tep_db_fetch_array($reason_sql)){
				$reason_options[] = array('id'=>$reason_rows['reason_id'],'text'=>$reason_rows['reason_text']);
			}
			echo tep_draw_pull_down_menu('reason', $reason_options, $reason);
			?>
		   </td>
        	<td width="80">&nbsp;</td>
        	<td>&nbsp;</td>
        	</tr>
        <tr>
          <td>������ã�</td>
          <td>
			<?php
			echo tep_draw_input_num_en_field('final_price','','class="textAll" ');
			?>
		  </td>
          <td>���ʽ��</td>
          <td>
           <?php
		   echo tep_draw_pull_down_menu('pay_method', $os_payments, $pay_method);
		   ?>
          </td>
        </tr> 
       
        <tr>
          <td valign="top">��ע��</td>
          <td colspan="3">
			<?php
			echo tep_draw_textarea_field('remarks','wrap','40','5',$remarks, ' class="textarea"');
			?>
          </td>
        </tr>
      </table>

    </div>
    
    
    <h2>��������״̬</h2>
    <div class="providerConfirm" id="Div3">
        <label>��ǰ״̬:</label>
		<?php
		echo tep_draw_pull_down_menu('status_id', $os_status, $status_id,'onchange="ShowHideProviderSpan(this)" ');
		
		$ProviderSpanStyle = 'display:none; ';
		if(tep_not_null($provider_code) || $status_id=="3"){
			$ProviderSpanStyle = 'display:; ';
		}
		?>
		&nbsp;&nbsp;
		<span id="ProviderSpan" style="<?= $ProviderSpanStyle?>">
		<label>Provider#��</label>
		<?php echo tep_draw_input_num_en_field('provider_code', $provider_code, 'class="textAll"');?>
		</span>
    </div>
  </div>
  
  <div class="foot"><button type="submit" id="Button4" class="Allbutton" value="Update">Update</button>&nbsp;&nbsp;<button type="button" class="AllbuttonHui" onClick="parent.jQuery('#popupMap').hide()">����</button></div>
  </form>
</div>
<?php			
		break;
		case "hotel_history":	//�Ƶ��޸���ʷ
		case "airport_history":	//������/�ͷ�����ʷ
		case "address_history": //ָ���ص��/�ͷ�����ʷ
		case "orders_changed_history": //�������ķ�����ʷ
			//echo orders_products_id
			$field_array = array();
			$field_array[] = array('title'=>'Date Added', 'field'=>'modified_str');
			$field_array[] = array('title'=>'Updated by', 'field'=>'modified_by_str');
			$field_array[] = array('title'=>'Status', 'field'=>'status_str');
			$field_array[] = array('title'=>'���ʽ', 'field'=>'pay_method');
			$field_array[] = array('title'=>'Provider#', 'field'=>'provider_code');
			
			if($_GET['modle']=="hotel_history"){
				$Table = ' `orders_products_extended_hotel_history` ';
				$Where = ' orders_products_id="'.(int)$orders_products_id.'" AND extended_hotel_id="'.(int)$_GET['extended_hotel_id'].'" ';
				$field_array[] = array('title'=>'��סģʽ', 'field'=>'eh_type');
				$field_array[] = array('title'=>'Ԥ������', 'field'=>'customer_name');
				$field_array[] = array('title'=>'Ԥ���ֻ�', 'field'=>'customer_mobile');
				$field_array[] = array('title'=>'�Ƶ�����', 'field'=>'hotel_name');
				$field_array[] = array('title'=>'��ס����', 'field'=>'start_date');
				$field_array[] = array('title'=>'�������', 'field'=>'end_date');
				$field_array[] = array('title'=>'�Ƶ�۸�', 'field'=>'hotel_price');
				$field_array[] = array('title'=>'�Ƶ����', 'field'=>'hotel_final_price');
				$field_array[] = array('title'=>'������Ϣ', 'field'=>'hotel_room_info');

			}
			if($_GET['modle']=="airport_history"){
				$Table = ' `orders_products_airport_transfer_history` ';
				$Where = ' orders_products_id="'.(int)$orders_products_id.'" ';
				$field_array[] = array('title'=>'�������', 'field'=>'final_price');
				$field_array[] = array('title'=>'�ִﺽ���', 'field'=>'flight_number');
				$field_array[] = array('title'=>'�ִ����ں�ʱ��', 'field'=>'arrival_time');
				$field_array[] = array('title'=>'�ִ����', 'field'=>'arrival_airport');
				$field_array[] = array('title'=>'Drop off', 'field'=>'drop_off');
				$field_array[] = array('title'=>'��/����ϵ��', 'field'=>'customer_name');
				$field_array[] = array('title'=>'��/����ϵ�绰', 'field'=>'customer_mobile');
				$field_array[] = array('title'=>'Pick up', 'field'=>'pick_up');
			}
			if($_GET['modle']=="address_history"){
				$Table = ' `orders_products_address_transfer_history` ';
				$Where = ' orders_products_id="'.(int)$orders_products_id.'" ';
				$field_array[] = array('title'=>'�������', 'field'=>'final_price');
				$field_array[] = array('title'=>'������ϵ��', 'field'=>'customer_name');
				$field_array[] = array('title'=>'������ϵ�绰', 'field'=>'customer_mobile');
				$field_array[] = array('title'=>'�������ں�ʱ��', 'field'=>'transfer_time');
				$field_array[] = array('title'=>'From address', 'field'=>'transfer_address');
				$field_array[] = array('title'=>'To address', 'field'=>'transfer_to_address');
				$field_array[] = array('title'=>'�������ں�ʱ�䣨����', 'field'=>'transfer_time1');
				$field_array[] = array('title'=>'From address������', 'field'=>'transfer_address1');
				$field_array[] = array('title'=>'To address������', 'field'=>'transfer_to_address1');
			}
			if($_GET['modle']=="orders_changed_history"){
				$Table = ' `orders_products_orders_change_history` ';
				$Where = ' orders_products_id="'.(int)$orders_products_id.'" ';
				$field_array[] = array('title'=>'�������', 'field'=>'final_price');
				$field_array[] = array('title'=>'���ò���ԭ��', 'field'=>'reason_str');
				
				$reason_sql = tep_db_query('SELECT reason_id, reason_text FROM `orders_products_orders_change_reason` ');
				$reason_array = array();
				while($reason_rows = tep_db_fetch_array($reason_sql)){
					$reason_array[] = array('id'=>$reason_rows['reason_id'],'text'=>$reason_rows['reason_text']);
				}
			}
			
			$field_array[] = array('title'=>'��ע', 'field'=>'remarks');
			$field_array[] = array('title'=>'Action Map', 'field'=>'action_map');
			
			$orders_changed_history_sql = tep_db_query('SELECT * FROM '.$Table.' WHERE '.$Where.' Order By history_id');
			$datas = array();
			$loop = 0;
			while($orders_changed_history = tep_db_fetch_array($orders_changed_history_sql)){
				$datas[$loop] = $orders_changed_history;
				$datas[$loop]['status_str'] = '';
				for($i=0; $i<sizeof($os_status); $i++){
					if($os_status[$i]['id']==$orders_changed_history['status_id']){
						$datas[$loop]['status_str'] = $os_status[$i]['text'];
						break;
					}
				}
				if(is_array($reason_array)){
					$datas[$loop]['reason_str'] = '';
					foreach((array)$reason_array as $key => $val){
						if($val['id']==$datas[$loop]['reason']){
							$datas[$loop]['reason_str'] = $val['text'];
							break;
						}
					}
				}
				$datas[$loop]['modified_str'] = tep_datetime_short($datas[$loop]['modified']);
				$datas[$loop]['modified_by_str'] = tep_get_admin_customer_name($datas[$loop]['modified_by']);
	
				$loop++;
			}
?>
<div class="hotelExtend">
	<div class="con" style="width:auto;">
	<h2><?php echo $title;?></h2>
	<div style="color:#F00; text-align:right; font-size:12px">˵������ɫ���ִ����޸Ĺ���NULL�����ֶε����ݱ���գ�</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bor_tab table_td_p">
		<tr>
			<?php 
			for($j=0; $j<sizeof($field_array); $j++){
			?>
				<th class="tab_t tab_line1" scope="col" nowrap="nowrap"><?php echo $field_array[$j]['title']?></th>
			<?php
			}
			?>
		</tr>
	<?php
				
		for($i=0; $i<sizeof($datas); $i++){
	?>
		<tr>
			<?php 
			for($j=0; $j<sizeof($field_array); $j++){
			?>
				<td class="tab_line1 p_l1">
				<?php
					if($j==0 || $j==1 || $j >=(sizeof($field_array)-1)){
						echo $datas[$i][$field_array[$j]['field']];
					}else{
						echo ComparativeOutput($datas[$i][$field_array[$j]['field']], $datas[($i-1)][$field_array[$j]['field']], $i );
					}
				?>
				</td>
			<?php
			}
			?>
		</tr>
	<?php				
		}
	?>
	
	</table>
	</div>
		<div class="foot"><button type="button" class="AllbuttonHui" onClick="parent.jQuery('#popupMap').hide()">����</button></div>
	</div>
<?php		
		break;
	}
?>
</body>
</html>
<script type="text/javascript">
parent.jQuery('#gMaptips').hide();
parent.jQuery('#gMapIframe').show();
parent.jQuery('#gMapIframe').height(document.body.clientHeight);
parent.showPopup('popupMap','popupConMap',true,0,0,'','',true);
</script>
<?php
}
//�༭ҳ����ʾ end
?>
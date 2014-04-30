<?php
/*
  $Id: invoice.php,v 1.2 2004/03/13 15:09:11 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $customer_number_query = tep_db_query("select customers_id from " . TABLE_ORDERS . " where orders_id = '". tep_db_input(tep_db_prepare_input($HTTP_GET_VARS['order_id'])) . "'");
  $customer_number = tep_db_fetch_array($customer_number_query);
/*
  if ($customer_number['customers_id'] != $customer_id) {
    tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
  }
*/
  $payment_info_query = tep_db_query("select payment_info from " . TABLE_ORDERS . " where orders_id = '". tep_db_input(tep_db_prepare_input($HTTP_GET_VARS['order_id'])) . "'");
  $payment_info = tep_db_fetch_array($payment_info_query);
  $payment_info = $payment_info['payment_info'];

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ORDERS);

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);
  $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");

  include(DIR_WS_CLASSES . 'order.php');
  $order = new order($oID);//���ܼӺ������ ���˽������,'op.products_departure_date asc');

  $email_list = get_order_travel_companion_email_list((int)$oID,(int)$_GET['products_id']);
  


//�����Զ�����
	$customers_char_set = 'gb2312';
	if((int)$order->customer['id']){
		//echo $order->customer['id'];
		$get_charset_sql = tep_db_query('SELECT customers_char_set FROM `customers` WHERE customers_id ="'.(int)$order->customer['id'].'"  LIMIT 1');
		$get_charset_row = tep_db_fetch_array($get_charset_sql);
		if(strtolower($get_charset_row['customers_char_set'])=='big5'){
			$customers_char_set = strtolower($get_charset_row['customers_char_set']);
		}
	}
	
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo 'usitrip - Eticket - ' . $oID; ?></title>
<base href="<?php echo (getenv('HTTPS') == 'on' ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="print.css">
<link rel="stylesheet" type="text/css" href="admin/includes/stylesheet.css">
</head>
<body marginwidth="10" marginheight="10" topmargin="10" bottommargin="10" leftmargin="10" rightmargin="10">
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td valign="top" align="left" class="main"><script language="JavaScript">
  if (window.print) {
    document.write('<a href="javascript:;" onClick="javascript:window.print()" onMouseOut=document.imprim.src="<?php echo (DIR_WS_IMAGES . 'printimage.gif'); ?>" onMouseOver=document.imprim.src="<?php echo (DIR_WS_IMAGES . 'printimage_over.gif'); ?>"><img src="<?php echo (DIR_WS_IMAGES . 'printimage.gif'); ?>" width="43" height="28" align="absbottom" border="0" name="imprim">' + '<?php echo IMAGE_BUTTON_PRINT; ?></a></center>');
  }
  else document.write ('<h2><?php echo IMAGE_BUTTON_PRINT; ?></h2>')
        </script></td>
        <td align="right" valign="bottom" class="main"><p align="right" class="main"><?php echo $customers_char_set;?><a href="javascript:window.close();"><img src='images/close_window.jpg' border=0></a></p></td>
      </tr>
	  <tr><td>
	  
<?php
 ob_start();
 include("eticket_email.php"); 
 $email_order = ob_get_contents();
//echo $email_order;
if(isset($_GET['sendmail']) && $_GET['sendmail']=='true'){
  
// zhh fix and added
  $_array = explode('<::>',(string)$order->products[$i]['eticket']['guest_email']);
  $_guest_email = '';
  foreach((array)$_array as $_email){
  	if(tep_validate_email($_email)){
		$_guest_email .= $_email.',';
	}
  }
  
  $_guest_email = substr($_guest_email,0,-1);
  if(tep_not_null($_guest_email)){
  	$email_list = $_guest_email.','.$email_list;
  }
  
  $emp_email = $order->customer['email_address'];
  $to_name = $order->customer['name'];
  if(tep_not_null($email_list)){
  	$emp_email = $email_list;
	$to_name = $email_list;
  }
  
  if(strpos($emp_email, $order->customer['email_address'])===false){
  	$emp_email .= ','.$order->customer['email_address'];
  	$to_name .= ','.$order->customer['name'];
  }
  
  
  //E-ticket Log Start
$eticket_log_data_array = array('orders_products_id' => $order->products[$i]['orders_products_id'],
								'orders_eticket_last_modified' => 'now()',
								'orders_eticket_content' => $email_order,
								'orders_eticket_is_customer_notified' => 1,
								'orders_eticket_updated_by' => tep_get_admin_customer_name($login_id),
								'orders_eticket_updator_type' => 0
							   );
tep_db_perform(TABLE_ORDERS_ETICKET_LOG, $eticket_log_data_array);	
$orders_eticket_log_id = tep_db_insert_id();
//E-ticket Log End
//Howard ɾ�����µ����ؽӼ�¼�� start {
tep_add_or_sub_sent_provider_not_re_rows ($order->products[$i]['orders_products_id'], $login_id, 'sub');
//Howard ɾ�����µ����ؽӼ�¼�� end }

  
  $email_subject = STORE_OWNER." ����ƾ֤ �����ţ�".(int)$oID." ";

	$emp_email = preg_replace('/,+/',',',$emp_email);
	$to_name = preg_replace('/,+/',',',$to_name);	
	$to_email_address = $emp_email;
	$email_subject = $email_subject;
	$email_text = preg_replace('/[[:space:]]+/',' ',$email_order);
	$email_text .= email_track_code('eTicket',$to_email_address,(int)$oID, 'orders_id', (int)$orders_eticket_log_id);
	
	$from_email_name = STORE_OWNER;
	$from_email_address = STORE_OWNER_EMAIL_ADDRESS;
	
	//ת���ַ�����
	$to_name = iconv('gb2312',$customers_char_set.'//IGNORE', $to_name);
	$email_subject = iconv('gb2312',$customers_char_set.'//IGNORE', $email_subject);
	$email_text = iconv('gb2312',$customers_char_set.'//IGNORE', $email_text);
	$from_email_name = iconv('gb2312',$customers_char_set.'//IGNORE', $from_email_name);
	tep_mail($to_name, $to_email_address, $email_subject, $email_text, $from_email_name, $from_email_address, 'true', $customers_char_set); //���͵��Ӳ���ƾ֤
	tep_mail($to_name, 'service@usitrip.com', $email_subject, $email_text, $from_email_name, $from_email_address, 'true', $customers_char_set); //���͵��Ӳ���ƾ֤[��������������������]
	
	/*//{���͵��Ӳ���ƾ֤�ɹ����͵���ʾ�ʼ�(��Package �ź�Local�ŵ���ʾ����)��
	//@author vincent 2011.7.21
	$vacation_check_query = tep_db_query("SELECT products_vacation_package,is_hotel FROM ".TABLE_PRODUCTS." WHERE products_id = ".intval($order->products[$i]['id']));
	$productInfo = tep_db_fetch_array($vacation_check_query);
	if(tep_not_null($productInfo)){
		$eticket_notify_email_extra_ch="";
		$eticket_notify_email_extra_en="";
		if($productInfo['products_vacation_package'] == 1){
			$eticket_notify_email_extra_ch = "
			������Ϣ�����ڰ����������ͷ����Ԥ��������ϸ�Ķ����Ӳ���ƾ֤�ϵĺ�����Ϣ���������뾡��֪ͨ���ǡ�<br/>
			<strong>���г̵ĵ�һ����Ҫ�ӻ���</strong>����ǰ72Сʱ���������ĺ�����Ϣ�ṩ�����ǡ���δ��ʱ�յ����ĺ�����Ϣ�����ķ����������г̵�һ��Ľӻ���������Ϊȷ������������졢˳��������ذ�����ĺ�����Ϣ�ṩ�����ǡ�<br/>
			<strong>���г̵�һ������ǰ���Ƶ꣬</strong>�뷢�ʼ���service@usitrip.comȷ�����İ��ţ���ʹ����ȷ���ڵ��Ӳ���ƾ֤���ṩ׼ȷ�ľƵ���Ϣ����Ƶ����ƣ��绰�͵�ַ�ȡ�Ϊȷ������������졢˳��������ط��ʼ�������ȷ�ϡ�<br/>";
			$eticket_notify_email_extra_en = "
			Below ONLY applies to customer whose reservation includes airport transfer. Please carefully review flight information on E-Ticket and let us know ASAP should there be an error.<br/>
			<strong>For customers who request airport transfers on day one,</strong> please provide the arriving flight information to usitrip 72 hours prior to your flight arrival. Should you fail to do so, usitrip will not be held accountable for failure of airport pickup on day one of your travel. This is extremely important to ensure you have a fun and smooth travel experience.<br/>
			<strong>For customers who will self transfer to hotel on day one,</strong> please email service@usitrip.com to confirm your arrangement so we can confirm accurate hotel information including hotel name, telephone number and address on your E-Ticket. This is extremely important to ensure you have a fun and smooth travel experience.Thank you for your time in advance.<br/>";			
		}
		$eticket_notify_email_content = "����ƾ֤�ѷ��͵����ĵ������䡣����ע����ӿ�ƱΪ������ƾ֤������Ҫ�����ӿ�Ʊ��ӡ�����ڲ��ŵ�����ͬ������Ч���֤����ʾ�赼�Ρ�����ϸ�Ķ�����ƾ֤�ϵ�������Ѷ����������κ����⣬�뼰ʱ֪ͨ�����Ա����ǽ�����ظ���������ڳ���ǰ72Сʱ��������δ�յ����йص��Ӳ���ƾ֤�����ʣ����ǽ�Ĭ�ϵ��Ӳ���ƾ֤��Ϣ��ȫ���󣬲����������������ĺ�����κ����Ρ�<br/>";		
		$eticket_notify_email_content .= $eticket_notify_email_extra_ch;
		$eticket_notify_email_content .="
		��������ͨ������<a href=\"http://208.109.123.18/login.php\">http://208.109.123.18/login.php</a> ��������鿴���������Ԥ������������������ƾ֤����ť�鿴���Ĳ���ƾ֤��<br/>
		�������δΪ����Ԥ������<a href=\"http://208.109.123.18/tour_america_need.php\">���α���</a>�����ǽ���ʱ���������򡣹���<a href=\"http://208.109.123.18/tour_america_need.php\">���α���</a>,���������ҽ���¹ʡ�ǩ֤����ʧ�ܡ��������ơ�����ȡ����������Ϊԭ���ȡ�����ж�����ʱ������з��ò����Ŀɿ���ʽ������ǿ���Ƽ���Ϊ�����п��ܳ��ֵ�ͻ���¹�����׼�����ձ�ѡ����Ϣ�����<a href=\"http://208.109.123.18/tour_america_need.php\">���α���</a>.<br/><br/>
		��л���Ĺ��򣬲�ף����;��죡<br/>
		Your E-Ticket has been delivered to your email address. Please remember E-Ticket is your proof of purchase. Simply print your E-Ticket and present it with your valid photo ID on the day of your activity to your tour guide. Please carefully review all the information on your E-Ticket and let us know should there be an error. We shall not be responsible for any consequences due to being notified of an error within 72 business hours before departure date by customer.<br/>";
		$eticket_notify_email_content .= $eticket_notify_email_extra_en;
		$eticket_notify_email_content .="
		You may also access your E-Ticket by logging into your account:<a href=\"http://208.109.123.18/login.php\">http://208.109.123.18/login.php</a> 'view' your previous reservations and click 'e-ticket' button.<br/>
		We would like to quickly remind you to purchase <a href=\"http://208.109.123.18/login.php\">Travel Insurance </a>for your reservation, if you have not done so yet. Purchasing <a href=\"http://208.109.123.18/login.php\">Travel Insurance</a> is a reliable way to recover your tour expenses in the event of cancellation or interruption of your tour (i.e. medical emergencies, Visa applications, weather restrictions, flight cancellations, or other personal reasons). We strongly encourage our travelers to be prepared to expect the unexpected during their travel. Please visit <a href=\"http://208.109.123.18/login.php\">Travel Insurance</a> for insurance coverage options.<br/>
		Thank you very much for your purchase.<br/>";
	}
	$eticket_notify_email_content = iconv('gb2312',$customers_char_set.'//IGNORE', $eticket_notify_email_content);
	$eticket_notify_email_subject = "�������ղ���ƾ֤(������C-".$oID."��Your E-Ticket has been issued. (Reservation #C-".$oID.")";
	$eticket_notify_email_subject = iconv('gb2312',$customers_char_set.'//IGNORE', $eticket_notify_email_subject);	
	tep_mail($to_name, $to_email_address, $eticket_notify_email_subject, $eticket_notify_email_content, $from_email_name, $from_email_address, 'true', $customers_char_set); //���͵��Ӳ���ƾ֤��ʾ�ʼ�	
	//}*/
	
	// �����ڴ��ļ�������start
	//������֪ͨ
	send_ticket_issued_sms($order->products[$i]['id'], $order->products[0]['name'], $order->products[0]['attributes'], $oID);
	//send_eticket_sms((int)$oID);
	//���¶���״̬
	$status = '100002';
	$customer_notified = '1';
	$comments = 'auto set orders status on eticket send page! products id:'.(int)$_GET['products_id'];
	tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . "
		(orders_id, orders_status_id, date_added, customer_notified, comments, updated_by)
		values ('" . tep_db_input($oID) . "', '" . tep_db_input($status) . "', now(), " . tep_db_input($customer_notified) . ", '" . tep_db_input($comments)  . "','".(int)$login_id."')");
	tep_db_query("update " . TABLE_ORDERS . " set last_modified = now(), orders_status ='".tep_db_input($status)."' where orders_id=".(int)$oID );
	//���µ��Ӳ���ƾ֤ ���û������ڸ������Ĳ鿴
	$admin_info = $login_id."|".date("Y-m-d H:i:s")."<::>";
	$admin_info = tep_db_input(tep_db_prepare_input($admin_info));
	tep_db_query("update ".TABLE_ORDERS_PRODUCTS_ETICKET." set confirmed=1 , sent_time='".date("Y-m-d H:i:s")."', sent_administrator_info=CONCAT(sent_administrator_info,'".$admin_info."') where  orders_products_id = '".$order->products[$i]['orders_products_id']."'"); // orders_id = '" . (int)$oID . "'  and products_id=".(int)$_GET['products_id']."");
	// �����ڴ��ļ�������end
  echo '<div align="center"><font color="#FF0000">E-Ticket has been sent successfully to '.$emp_email.'.</font></div>'; 
}

?><br />
</td></tr>
<?php if(!isset($_GET['sendmail'])){ ?>
 <tr>
		<td align="right">
			<table width="35%">
				<tr>
					<?php 
					if($can_send_eticket == true){	//��Ȩ�����Ӳ���ƾ֤���˲��ܷ�
						if($order->products[$i]['is_hotel'] == 1 && trim($order->products[$i]['customer_confirmation_no']) == ""){
						echo '<td align="center"><a href="#" onClick="javascript:confirm(\'Hotel confirmation number must be entered before ticket issue for hotel products.\'); return false;" target="_blank"><div class="but_3_long order_default">���͵��Ӳ���ƾ֤</div></a></td>';
						}else{
						echo '<td align="center"><a href="' .  (HTTP_SERVER . DIR_WS_ADMIN . 'eticket.php') . '?' . (tep_get_all_get_params(array('oID', 'show_eticket')) . 'oID=' . $HTTP_GET_VARS['oID']) . '&sendmail=true" target="_blank"><div class="but_3_long order_default">���͵��Ӳ���ƾ֤</div></a></td>';
						}
					}else{
						echo '<td align="center"><input type="button" value="���͵��Ӳ���ƾ֤" disabled="disabled" /></td>';
					}
					echo '<td align="center">'.'<a href="' . tep_href_link(FILENAME_EDIT_ORDERS, tep_get_all_get_params(array('oID', 'action', 'show_eticket')) . 'oID=' . $HTTP_GET_VARS['oID'] . '&show_eticket=true#show_eticket') . '"><div class="but_3 order_default">Edit E-Ticket</div></a></td><td align="center">'.' <a href="' . tep_href_link(FILENAME_EDIT_ORDERS, tep_get_all_get_params(array('action', 'show_eticket'))) . '"><div class="but_3 order_default">'.IMAGE_BACK.'</div></a>';
					?>
				</tr>
			</table>
		</td>
     </tr>
<?php } ?>
</table>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
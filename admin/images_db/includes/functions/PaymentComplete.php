<?php
function PaymentComplete($order_id, $order_status, $v_amount, $pay_text="֧����"){
/* 	require('../../../../includes/configure.php');
	require('../../../../includes/filenames.php');
	require('../../../../includes/functions/database.php');
	require('../../../../includes/functions/general.php');
	require('../../../../includes/database_tables.php');
	tep_db_connect() or die('Unable to connect to database server!');
 */	
	  $configuration_query = tep_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
	  while ($configuration = tep_db_fetch_array($configuration_query)) {
		define($configuration['cfgKey'], $configuration['cfgValue']);
	  }
	tep_db_query("UPDATE ".TABLE_ORDERS." SET orders_status = '".$order_status."' , payment_method ='".(string)$pay_text."' where orders_id = '".(int)$order_id."' ");
	////���û����ӻ���
/* 	$order_query = tep_db_query("select customers_id FROM  ".TABLE_ORDERS. " where orders_id='".(int)$order_id."' limit 1 ");
	$order_customers = tep_db_fetch_array($order_query);
	tep_db_query("update ".TABLE_CUSTOMERS_BANK. " set customers_bank_deposits = customers_bank_deposits + ".(int)BUY_A_TSHIRT_TY." where customers_id='".(int)$order_customers['customers_id']."'");
 */
//���ﲻ��ӻ��֣����û������յ�����ť���Զ����ӡ� 
	
	switch($order_status){	//���ݲ�ͬ��״̬���ò�ͬ����ʷ��־
		case '100000':	//�Ѹ���[��������]
			$comments = '�ͻ��Ѿ�ͨ���������߸��';
		  break;
		case '100001':	//�Ѹ���[֧����]
			$comments = '�ͻ��Ѿ�ͨ��֧����ת�ʵ�֧������˾��';
		  break;
		case '100006':	//�Ѹ���[֧����]
			$comments = '�ͻ��Ѿ�ͨ����Ǯ���߸���ת�ʵ���Ǯ��˾��';
		  break;
	}
	
	$customer_notified = '0';
	
	tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int)$order_id . "', '" . tep_db_input($order_status) . "', now(), '" . tep_db_input($customer_notified) . "', '" . tep_db_input($comments)  . "')");
	
}
?>
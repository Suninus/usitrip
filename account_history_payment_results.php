<?php
//�ҵ��˺���Paypal֧���������
require('includes/application_top.php');
$payment = $_GET['payment'];
if($payment=='paypal'){	
	if(($_POST['payment_status']=="Completed" || $_POST['payment_status']=="Pending")){
		//��¼������Ϣ���ͻ������¼��$_POST['payment_status']=="Completed"Ϊ�Ѿ���ȫ�յ��"Pending"��//������;��ĿǰPaypal�п��ܳ���״̬ΪPending��ʵ�����Ѿ�֧���ɹ�������� 
		$orders_id = (int)$_POST["invoice"];
		$usa_value = $_POST["payment_gross"];
		$orders_id_include_time = $_POST["invoice"];
		$comment = "����״̬��".$_POST['payment_status']."\n";
		$comment.= "��Ԫ��".$usa_value."\n";
		$comment.= "����ʱ�䣺".$_POST["payment_date"]."\n";
		$comment.= "��ˮ�ţ�".$_POST["txn_id"]."\n";
		$comment.= "�����ţ�".$_POST["invoice"]."\n";
		$comment.= "�����˵�Payal�˺ţ�".$_POST["payer_email"]."\n";
		$comment.= "֪ͨ���ͣ���ͬ��֪ͨ��\n".__FILE__;
		tep_payment_success_update($orders_id, $usa_value, 'paypal', $comment, 96, $orders_id_include_time);
		//�ɹ���ȥ������ϸҳ��
		tep_redirect(tep_href_link('account_history_info.php', 'order_id='.$orders_id, 'SSL'));
	}
}
?>
<?php 
require_once('includes/application_top.php');

function ajax_str($str){
	global $include;
	if($include!=true){
		return iconv(CHARSET,'utf-8'.'//IGNORE',$str);
	}else{
		return $str;
	}
}

if (!tep_session_is_registered('customer_id')) {
	echo ajax_str('����Ҫ��¼�������Ӻ��ѣ�');
	exit;
}


if((int)$_GET['customers_id'] && !check_friend($customer_id,$_GET['customers_id'])){
	tep_db_query("INSERT INTO `friends_list` ( `f0_customers_id` , `f1_customers_id` , `f_date` )VALUES ($customer_id, {$_GET['customers_id']}, NOW());");
	echo ajax_str('������ӳɹ���');
}else{
	echo ajax_str('���Ѿ������ĺ����ˡ�');
}
?>
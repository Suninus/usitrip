<?php
/**
 * �û����Ķ��������ύ���Ա���
 * @package PHPDoc
 */
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );

require_once('includes/application_top.php');
header("Content-type: text/html; charset=".CHARSET);

//����û�
if(!tep_session_is_registered('customer_id') || !(int)$customer_id){
	echo db_to_html('��δ��¼���ߵ�¼��ʱ�������µ�¼�˺ţ�');
	exit;
}
$message = iconv('utf-8',CHARSET,$_POST['message']);
if (CHARSET != 'gb2312') {
	$message = iconv(CHARSET,'gb2312//IGNORE',$message);
}
//$message = html_to_db($_POST['message']);
$orders_id = (int)$_POST['orders_id'];
$addtime = date('Y-m-d H:i:s');

if (!tep_not_null($message)) {
	echo db_to_html('��δ��д�������ݣ�');
	exit;
}
if ($orders_id < 0) {
	echo db_to_html('���ύ�����ݷǷ���');
	exit;
}

$ist_stk = tep_db_fast_insert('orders_message', array('orders_id'=>$orders_id,'message'=>$message,'addtime'=>$addtime,'customers_id'=>$customer_id));
if (!$ist_stk) {
	echo db_to_html('���ݱ���ʧ�ܣ������Ի�����ϵ�ҵĿͷ���');
	exit;	
}
echo db_to_html('�ύ�ɹ���');
?>
<?php
//====================�������߽ӿ������ļ�=============================================
// Howard added { 
// set timezone
ini_set('date.timezone','UTC-07:00');
// set the level of error reporting
ini_set('display_errors', '1');
error_reporting(E_ALL & ~E_NOTICE);

header("Content-type: text/html; charset=gb2312");
define('INCLUDES_DIR',preg_replace('@/includes/.*@','',dirname(__FILE__))."/includes/");
require_once(INCLUDES_DIR."configure.php");
require_once(INCLUDES_DIR."functions/database.php");
tep_db_connect() or die('Unable to connect to database server!');
//ȡ���������߶��������ݿ��еĳ���
$key_in = " 'MODULE_PAYMENT_A_CHINABANK_STATUS', 'MODULE_PAYMENT_A_CHINABANK_API_DIR','MODULE_PAYMENT_A_CHINABANK_API_WEB_DIR', 'MODULE_PAYMENT_A_CHINABANK_SORT_ORDER', 'MODULE_PAYMENT_A_CHINABANK_ID', 'MODULE_PAYMENT_A_CHINABANK_KEY','MODULE_PAYMENT_A_CHINABANK_RETURN_URL','MODULE_PAYMENT_A_CHINABANK_SHOW_URL','MODULE_PAYMENT_A_CHINABANK_MAIN_NAME' ";

$sql = tep_db_query("select configuration_key, configuration_value from configuration where configuration_key in (".$key_in.") ");
while($rows = tep_db_fetch_array($sql)){
	define($rows['configuration_key'], $rows['configuration_value']);
}
//����һЩ��Ҫ�ĺ�����
require_once(INCLUDES_DIR."functions/general.php");
require_once(INCLUDES_DIR."functions/webmakers_added_functions.php");

// Howard added }
?>
<?php
/**
 * AJAX����� 
 * 1.action=draw_full_address_input�ṩ������ַ����ؼ��ķ����֧�� 
 * @author vincent 
 */
require('includes/application_top.php');
$ajax = true;
//--------------------------------------------------------------------------------------------������ַ��
if($_GET['action'] == 'draw_full_address_input'){
	$refobj = ajax_to_general_string($_GET['refobj']);
	$country = ajax_to_general_string($_GET['country']);
	$state = ajax_to_general_string($_GET['state']);
	echo tep_draw_full_address_input($refobj, $country, $state);
	exit;
}
?>

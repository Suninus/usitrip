<?php
/*
  $Id: orders_status.php,v 1.1.1.1 2004/03/04 23:38:51 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
 */

require('includes/application_top.php');
//Ȩ���ж�
$order_dispaly_status_control_access =$login_groups_id == '1' ? true:false;
//Ȩ���ж�����

$DOC_TITLE = 'ҵ�����ϵͳ';

define('VIN_TMP_PATH' , realpath('./templates/ver1/').DIRECTORY_SEPARATOR); //ģ��·��

error_reporting(E_ALL);
ini_set('display_errors','1');
	
//���ҳ���� BEGIN
$page = (isset($HTTP_GET_VARS['page']) ? $HTTP_GET_VARS['page'] : '');
if($page == ''){		
	$DOC_LEFT = 'frame.php?page=left';
	$DOC_MAIN = 'orders_pointcards.php';
	//����ģ���Լ�layout
	include(VIN_TMP_PATH.'frame.php');
}else if($page == 'left'){
	include(VIN_TMP_PATH.'menu.php');
	
}
//���ҳ���� END
//----------
require(DIR_WS_INCLUDES . 'application_bottom.php'); 

?>
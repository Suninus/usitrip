<?php
/**
 * ���ķ������������ʦ��������
 * 
 * @author Panda
 * @category Project
 * @copyright Copyright(c) 2011 
 * @version $Id$
 */
require('includes/application_top.php');
$DOCTYPE = ""; //ȡ�����W3C��׼����
$title = "���ķ�����������ʦ��������";

$lift_frame_src = tep_href_link('daren_system_left_menu.php');
$right_frame_src = tep_href_link('daren_system_works_list.php');

$body_style = ' style="overflow:hidden"; ';//���������Ĺ�����

$main_file_name = "daren_system_index";
$JavaScriptSrc[] = 'includes/javascript/global.js';
$CssArray = array();
$CssArray[] = "css/daren.css";
$CssArray[] = "css/global.css";
$CssArray[] = "css/new_sys_indexDdan.css";

/* ��ʾ������� */


unset($Bread);	//����ʾ����
include_once(DIR_FS_DOCUMENT_ROOT.'smarty-2.0/libs/write_smarty_vars.php');
$smarty->display($main_file_name.'.tpl.html');

require(DIR_WS_INCLUDES . 'application_bottom.php');

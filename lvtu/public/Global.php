<?php
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Configure_Local.php')) {
	require('Configure_Local.php');
} else {
	require('Configure.php');
}
require('Function.php');
require(DIR_FS_SMARTY . 'Smarty.class.php');        //����smarty���ļ�
?>
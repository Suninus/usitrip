<?php
//дsmartyģ�������������->display֮ǰ����
if(is_object($smarty)){
	$defined_vars = get_defined_vars();
	foreach ($defined_vars as $key => $val) {
		if(in_array($key, array('_GET', '_POST', '_COOKIE', '_FILES', 'GLOBALS', '_SERVER')) ) {
		}else{
			$smarty->assign($key, ${$key});
		}
	}
}
?>
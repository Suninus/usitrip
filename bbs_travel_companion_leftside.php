<?php
require_once('includes/application_top.php');
require(DIR_FS_LANGUAGES . $language . '/bbs_travel_companion.php');


//print_r($usa_categories_array);
//echo count($usa_categories_array);

//���ô��Ŀ¼
$canada_categories_array = array();
//ŷ�޵�Ŀ¼
$europe_categories_array = array();


require_once(DIR_FS_CONTENT . '/bbs_travel_companion_leftside.tpl.php');
?>

<?php
require_once(DIR_FS_INCLUDES . 'application_bottom.php');
?>
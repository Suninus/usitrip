<?php
/**
 * ��������Э��
 * @package 
 */
require('includes/application_top.php');

$cookie_day = (AFFILIATE_COOKIE_LIFETIME/3600/24);

$content = 'affiliate_agreement';
$breadcrumb->add(db_to_html('��������Э��'), 'affiliate_agreement.php');
require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
require(DIR_FS_INCLUDES . 'application_bottom.php');
?>
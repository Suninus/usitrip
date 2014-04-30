<?php
/*
 * $Id: affiliate_details.php,v 1.1.1.1 2004/03/04 23:37:54 ccwjr Exp $
 * OSC-Affiliate Contribution based on: osCommerce, Open Source E-Commerce
 * Solutions http://www.oscommerce.com Copyright (c) 2002 - 2003 osCommerce
 * Released under the GNU General Public License
 */

require ('includes/application_top.php');

// ��վ���˿���
if (strtolower(AFFILIATE_SWITCH) === 'false') {
	echo '<div align="center">�˹����ݲ����ţ���<a href="' . tep_href_link ( 'index.php' ) . '">��ҳ</a></div>';
	exit ();
}

if (! tep_session_is_registered ( 'affiliate_id' )) {
	$navigation->set_snapshot ();
	if (tep_not_null ( $_COOKIE ['LoginDate'] )) {
		$messageStack->add_session ( 'login', LOGIN_OVERTIME );
		setcookie ( 'LoginDate', '' );
	}
	tep_redirect ( tep_href_link ( FILENAME_LOGIN, '', 'SSL' ) );
}
checkAffiliateVerified ();

require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_DETAILS);

if (isset ( $_POST ['action'] )) {
	$affiliate_payment_check = tep_db_prepare_input ( $_POST ['affiliate_payment_check'] );
	$affiliate_payment_paypal = tep_db_prepare_input ( $_POST ['affiliate_payment_paypal'] );
	$affiliate_payment_bank_name = tep_db_prepare_input ( $_POST ['affiliate_payment_bank_name'] );
	$affiliate_payment_bank_account_name = tep_db_prepare_input ( $_POST ['affiliate_payment_bank_account_name'] );
	$affiliate_payment_bank_account_number = tep_db_prepare_input ( $_POST ['affiliate_payment_bank_account_number'] );
	$affiliate_default_payment_method = tep_db_prepare_input ( $_POST ['affiliate_default_payment_method'] );
	$affiliate_payment_alipay_name = tep_db_prepare_input($_POST['affiliate_payment_alipay_name']);
	$affiliate_payment_alipay = tep_db_prepare_input($_POST['affiliate_payment_alipay']);
	$affiliate_mobile = tep_db_prepare_input($_POST['affiliate_mobile']);
	$error = false; // reset error flag
	$errmsg = '���ύ�ı���Ϣ��������';
	switch($affiliate_default_payment_method) {
	case 'Paypal':
		if (!tep_not_null($affiliate_payment_check) || !tep_not_null($affiliate_payment_paypal) || !tep_not_null($affiliate_mobile)) {
			$error = true;
		}
		if (!preg_match('/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/', $affiliate_payment_paypal)) {
			$error = true;
		}
		break;
	case 'Bank':
		if (!tep_not_null($affiliate_payment_bank_account_name) || !tep_not_null($affiliate_payment_bank_name) || !tep_not_null($affiliate_payment_bank_account_number) || !tep_not_null($affiliate_mobile)) {
			$error = true;
		}
		break;
	case 'Alipay':
		if (!tep_not_null($affiliate_payment_alipay_name) || !tep_not_null($affiliate_payment_alipay) ||  !tep_not_null($affiliate_mobile)) {
			$error = true;
		}
		break;
	}
	
	/*if (!preg_match('/(^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$)|(^(\+86)?((13)|(15)|(18))\d{9}$)/', $affiliate_mobile)) {
		$errmsg = '����д���ֻ���������';
		$error = true;
	}*/
	/*
	 * if (!$a_agb) { $error=true; $entry_agb_error=true;
	 * $messageStack->add('affiliate_details', ENTRY_AFFILIATE_AGB_ERROR); }
	 */
	
	if (! $error) {
		
		$sql_data_array = array (
				'affiliate_payment_check' => $affiliate_payment_check,
				'affiliate_payment_alipay_name' => $affiliate_payment_alipay_name,
				'affiliate_payment_paypal' => $affiliate_payment_paypal,
				'affiliate_payment_alipay' => $affiliate_payment_alipay,
				'affiliate_payment_bank_name' => $affiliate_payment_bank_name,
				'affiliate_payment_bank_account_name' => $affiliate_payment_bank_account_name,
				'affiliate_payment_bank_account_number' => $affiliate_payment_bank_account_number,
				'affiliate_default_payment_method' => $affiliate_default_payment_method,
				'affiliate_date_account_last_modified' => date ( "Y-m-d H:i:s" ),
				'affiliate_mobile' => $affiliate_mobile
		);
		$sql_data_array ['affiliate_date_account_last_modified'] = 'now()';
		
		$sql_data_array = html_to_db ( $sql_data_array );
		tep_db_perform ( TABLE_AFFILIATE, $sql_data_array, 'update', "affiliate_id = '" . tep_db_input ( $affiliate_id ) . "'" );
		//=========== �����ʼ����������俪ʼ ===============
		$var_num = (int) count($_SESSION['need_send_email']);
		$_SESSION['need_send_email'][$var_num]['to_name'] = db_to_html('����');
		$_SESSION['need_send_email'][$var_num]['to_email_address'] = '2355652793@qq.com';
		$_SESSION['need_send_email'][$var_num]['email_subject'] = db_to_html('���������˳�ԱIDΪ' . (int)$affiliate_id . '�ύ�������������');
		$_SESSION['need_send_email'][$var_num]['email_text'] = db_to_html('���������˳�ԱIDΪ' . (int)$affiliate_id . '�ύ������������룬��ȥ��̨��鲢��ˣ�лл����̨��ַ��http://www.usitrip.com/admin/affiliate_affiliates.php'); // can is html or text
		$_SESSION['need_send_email'][$var_num]['from_email_name'] = db_to_html(STORE_OWNER);
		//$_SESSION['need_send_email'][0]['from_email_address'] = STORE_OWNER_EMAIL_ADDRESS;
		$_SESSION['need_send_email'][$var_num]['from_email_address'] = 'automail@usitrip.com';
		$_SESSION['need_send_email'][$var_num]['action_type'] = EMAIL_USE_HTML;
		//=========== �����ʼ�������������� -==============
		$messageStack->add_session ( 'affiliate_details', SUCCESS_ACCOUNT_UPDATED, 'success' );
		tep_redirect ( tep_href_link ( 'affiliate_details.php', '', 'SSL' ) );
	} else {
		$messageStack->add_session ( 'affiliate_details', $errmsg, 'error' );
		tep_redirect ( tep_href_link ( 'affiliate_details.php', '', 'SSL' ) );
	}
}

$breadcrumb->add ( NAVBAR_TITLE_2, tep_href_link ( FILENAME_AFFILIATE_DETAILS, '', 'SSL' ) );

$affiliate_query = tep_db_query ( "select * from " . TABLE_AFFILIATE . " where affiliate_id = '" . $affiliate_id . "'" );
$affiliate = tep_db_fetch_array ( $affiliate_query );

// ����������������ύ���������{
foreach ( $affiliate as $key => $val ) {
	$$key = tep_db_prepare_input ( $val );
}
// ����������������ύ���������}
// �����������������ʾ����{
$affiliateInfo = $affiliate;
foreach ( $affiliateInfo as $key => $val ) {
	$affiliateInfo [$key] = tep_db_output ( $val );
}
// �����������������ʾ����}

$_str_paypal = 'Paypal';
$_str_alipay = '֧����';
$_str_paypal_check_name = '�տ���������';
$_str_paypal_check_email = 'Paypal�ʺ����䣺';
$_str_alipay_check_email = '֧�����ʺ����䣺';
$_str_bank = '����ת���տ�';
$_str_bank_name = '�������У�';
$_str_bank_check_name = '�տ���������';
$_str_bank_number = '�����˺ţ�';
$_str_telphone = '��ϵ�绰��';

if ($affiliateInfo ['affiliate_default_payment_method'] == "Paypal") {
	$method_string = $_str_paypal;
	$account_string = '<li><label>' . $_str_paypal_check_name . '</label>' . $affiliateInfo ['affiliate_payment_check'] . '</li>';
	$account_string .= '<li><label>' . $_str_paypal_check_email . '</label>' . $affiliateInfo ['affiliate_payment_paypal'] . '</li>';
}

if ($affiliateInfo ['affiliate_default_payment_method'] == "Alipay") {
	$method_string = $_str_alipay;
	$account_string = '<li><label>' . $_str_paypal_check_name . '</label>' . $affiliateInfo ['affiliate_payment_alipay_name'] . '</li>';
	$account_string .= '<li><label>' . $_str_alipay_check_email . '</label>' . $affiliateInfo ['affiliate_payment_alipay'] . '</li>';
}

if ($affiliateInfo ['affiliate_default_payment_method'] == "Bank") {
	$method_string = $_str_bank;
	$account_string = '<li><label>' . $_str_bank_check_name . '</label>' . $affiliateInfo ['affiliate_payment_bank_account_name'] . '</li>';
	$account_string .= '<li><label>' . $_str_bank_name . '</label>' . $affiliateInfo ['affiliate_payment_bank_name'] . '</li>';
	$account_string .= '<li><label>' . $_str_bank_number . '</label>' . $affiliateInfo ['affiliate_payment_bank_account_number'] . '</li>';
}
$account_string .= '<li><label>' . $_str_telphone . '</label>' . $affiliateInfo['affiliate_mobile'] . '</li>';

$content = CONTENT_AFFILIATE_DETAILS;

$is_my_account = true;
require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

require(DIR_FS_INCLUDES . 'application_bottom.php');

?>

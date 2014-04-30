<?php
require('includes/application_top.php');

define('NAVBAR_TITLE_2', db_to_html("�����˺���Ϣ"));

if (!tep_session_is_registered('affiliate_id')) {
	$navigation->set_snapshot();
	if(tep_not_null($_COOKIE['LoginDate'])){
		$messageStack->add_session('login', LOGIN_OVERTIME);
		setcookie('LoginDate', '');
	}
	tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
}

  // ��վ���˿���
  if (strtolower(AFFILIATE_SWITCH) === 'false') {
  	if ($_GET['action'] != '' || $_POST['ajax'] == 'true') {
  		echo '[JS]'.db_to_html('alert("�˹����ݲ����ţ�")').'[/JS]';
  	} else {
  		echo '<div align="center">�˹����ݲ����ţ���<a href="' . tep_href_link('index.php') . '">��ҳ</a></div>';
  	}
  	exit();
  }


require(DIR_FS_CLASSES . 'affiliate.php');
$affiliate = new affiliate;

$affiliate_id = $_SESSION['affiliate_id'];

//POST start{
if($_POST['ajax']=='true'){
	header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
	header( "Cache-Control: no-cache, must-revalidate" );
	header( "Pragma: no-cache" );
	require(DIR_FS_INCLUDES . 'ajax_encoding_control.php');
}

$submitBtnText = '�ύ������Ϣ';
$submitBtnText1 = '�ύ�С���';
switch($_GET['action']){
	case "verify_email":
		$error = false;
		$js_str = '';
		$email_adderss = $_GET['email_adderss'];
		if(!tep_not_null($email_adderss)){
			$error = true;
			$error_msn .= '���䣺����Ϊ�գ�'.'\n'; 
		}elseif(tep_validate_email($email_adderss)==false){
			$error = true;
			$error_msn .= '���䣺'.$email_adderss.'���Ǳ�׼������'.'\n'; 
		}elseif((int)checkDuplicateAffiliateEmail($email_adderss, (int)$affiliate_id)){
			$error = true;
			$error_msn .= '���䣺'.$email_adderss.'�Ѿ����ڣ�����ѡ����'.'\n'; 
		}
		if($error==false){
			if((int)send_affiliate_validation_mail($email_adderss)){
				$js_str.='jQuery("#EmailTips").html("��֤�ʼ��Ѿ����͵��������䣺'.$email_adderss.'");';
				$js_str.='jQuery("#EmailTips").addClass("normalTip");';
				$js_str.='jQuery("#EmailTips").hide(0);';
				$js_str.='jQuery("#EmailTips").show(300);';
				$js_str.='jQuery("#verifyBtn button[type=\'button\']").html("�ط���֤�ʼ�");';
			}else{
				$js_str = 'alert("����ʧ�ܣ�����������ظ�");';
			}
		}else{
			$js_str = 'alert("'.$error_msn.'");';
		}
		$js_str .= 'CanSendVerify = 1; ';
		$js_str = preg_replace('/[[:space:]]+/',' ',$js_str);
		echo '[JS]'.db_to_html($js_str).'[/JS]';
		exit;
	break;
	case "edit":
		$submitBtnText = 'ȷ������';
		$submitBtnText1 = '�����С���';
	break;
	case "SubmitMyInfo":	//�ύ������������
		
		if($_POST['ajax']=='true'){
			$error = false;
			$error_msn = "";
			$js_str = "";
			$affiliate_firstname = tep_db_prepare_input($_POST['affiliate_firstname']);
			$affiliate_lastname = tep_db_prepare_input(preg_replace('/[[:space:]]+/','',$_POST['surName'])).' '.tep_db_prepare_input(preg_replace('/[[:space:]]+/','',$_POST['givenName']));
			if(!preg_match('/^[\w]+ [\w]+$/',$affiliate_lastname)){
				$affiliate_lastname = "";
			}
			
			$affiliate_email_address = tep_db_prepare_input($_POST['affiliate_email_address']);
			$affiliate_mobile = tep_db_prepare_input($_POST['affiliate_mobile']);
			$affiliate_telephone = tep_db_prepare_input($_POST['affiliate_telephone']);
			$affiliate_qq = tep_db_prepare_input($_POST['affiliate_qq']);
			$affiliate_msn = tep_db_prepare_input($_POST['affiliate_msn']);
			$affiliate_homepage_name = tep_db_prepare_input($_POST['affiliate_homepage_name']);
			$affiliate_homepage = tep_db_prepare_input($_POST['affiliate_homepage']);
			$affiliate_site_type_id = (int)$_POST['affiliate_site_type_id'];
			$affiliate_site_profile = tep_db_prepare_input($_POST['affiliate_site_profile']);
			
			if(!tep_not_null($affiliate_firstname)){
				//$error = true;
				//$error_msn .= '��������������Ϊ�գ�'.'\n'; 
			}
			if(!tep_not_null($affiliate_email_address)){
				//$error = true;
				//$error_msn .= '���䣺����Ϊ�գ�'.'\n'; 
			}elseif(tep_validate_email($affiliate_email_address)==false){
				//$error = true;
				//$error_msn .= '���䣺'.$affiliate_email_address.'���Ǳ�׼������'.'\n'; 
			}elseif((int)checkDuplicateAffiliateEmail($affiliate_email_address, (int)$affiliate_id)){
				//$error = true;
				//$error_msn .= '���䣺'.$affiliate_email_address.'�Ѿ����ڣ�����ѡ����'.'\n'; 
			}elseif(update_affiliate_customers_email_address($affiliate_email_address)==false){	//�˴��Ǽ����޸Ŀͻ���Ͳ��ͱ��û�����
				//$error = true;
				//$error_msn .= '���䣺'.$affiliate_email_address.'�Ѿ���ע�ᣬ����ѡ����'.'\n'; 
			}
			
			if(!tep_not_null($affiliate_mobile)){
				//$error = true;
				//$error_msn .= '�ֻ�������Ϊ�գ�'.'\n'; 
			}
			if(!tep_not_null($affiliate_qq) && !tep_not_null($affiliate_msn)){
				$error = true;
				$error_msn .= 'QQ��MSN����һ�'.'\n'; 
			}
						
			if($error==false){
				$sql_data_array = array('affiliate_firstname' => ajax_to_general_string($affiliate_firstname),
										'affiliate_lastname' => ajax_to_general_string($affiliate_lastname),
										'affiliate_email_address' => ajax_to_general_string($affiliate_email_address),
										'affiliate_mobile' => ajax_to_general_string($affiliate_mobile),
										'affiliate_telephone' => ajax_to_general_string($affiliate_telephone),
										'affiliate_qq' => ajax_to_general_string($affiliate_qq),
										'affiliate_msn' => ajax_to_general_string($affiliate_msn),
										'affiliate_homepage_name' => ajax_to_general_string($affiliate_homepage_name),
										'affiliate_homepage' => ajax_to_general_string($affiliate_homepage),
										'affiliate_site_type_id' => $affiliate_site_type_id,
										'affiliate_site_profile' => ajax_to_general_string($affiliate_site_profile),
										'verified' => '1'
										);
				$sql_data_array = html_to_db ($sql_data_array);
				tep_db_perform(TABLE_AFFILIATE, $sql_data_array, 'update', ' affiliate_id ="'.(int)$affiliate_id.'" ');
				
				
				
				
				//����session
				if(!(int)$_SESSION['affiliate_verified']){
					$_SESSION['affiliate_verification_successful']=1;
				}else{
					$messageStack->add_session('affiliate_my_info', "��ϲ�������������ϸ��³ɹ���", 'success');
				}
				setSessionAffiliateInfo($customer_id);
				
				$js_str = 'document.location="'.tep_href_link('affiliate_my_info.php').'";';
				
			}else{
				$js_str = 'alert("'.$error_msn.'");';
				$js_str .= '_disabledAllowBtn("affiliateForm","show");';
			}
			
			$js_str = preg_replace('/[[:space:]]+/',' ',$js_str);
			//echo $affiliate_id;
			echo '[JS]'.db_to_html($js_str).'[/JS]';
		}
	exit;
	break;
}
//POST end}

//affiliate info {
$affiliateInfo = array();

// Ŀ¼�����������в��ֱ���������ǵ��ˡ�ע�ⲻһ����ע�͵�����Ϊ affiliate_affiliate����������û�����ֶβ�һ����ȫһ�� by lwkai add ע�� 2012-06-12
$affiliate_sql = tep_db_query("select * from " . TABLE_AFFILIATE . " where affiliate_id=" . (int)$affiliate_id);
$affiliateInfo = tep_db_fetch_array($affiliate_sql);


$affiliateInfo['surName'] = '��Surname';
$affiliateInfo['givenName'] = '��Given names';
$affiliateInfo['surNameParameter'] = 'onfocus="if(this.value!=\'��Surname\'){this.style.color=\'#000\'}else{this.value=\'\';this.style.color=\'#000\'}" onblur="if(this.value==\'\'){this.value=\'��Surname\';this.style.color=\'#b6b7b9\'}" class="text surName" ';
$affiliateInfo['givenNameParameter'] = 'onfocus="if(this.value!=\'��Given names\'){this.style.color=\'#000\'}else{this.value=\'\';this.style.color=\'#000\'}" onblur="if(this.value==\'\'){this.value=\'��Given names\';this.style.color=\'#b6b7b9\'}" class="text givenName" ';
if(tep_not_null($affiliateInfo['affiliate_lastname'])){
	$tmpArray = explode(' ',$affiliateInfo['affiliate_lastname']);
	$affiliateInfo['surName'] = $tmpArray[0];
	$affiliateInfo['givenName'] = $tmpArray[1];
}

$site_type_sql = tep_db_query("SELECT * FROM `affiliate_site_type` ORDER BY `affiliate_site_type_id` ASC ");
$affiliateInfo['siteTypeRadios'] = '';
$affiliateInfo['siteTypeString'] = '';
$radioFirst = ' class="radioFirst" ';
while($site_type_rows = tep_db_fetch_array($site_type_sql)){
	$_checked = '';
	if((int)$site_type_rows['affiliate_site_type_id'] && $site_type_rows['affiliate_site_type_id']==$affiliateInfo['affiliate_site_type_id']){
		$_checked = ' checked ';
		$affiliateInfo['siteTypeString'] = $site_type_rows['affiliate_site_type_name'];
	}
	$affiliateInfo['siteTypeRadios'] .= '<label><input type="radio" value="'.$site_type_rows['affiliate_site_type_id'].'" name="affiliate_site_type_id" '.$radioFirst.$_checked.' />'.$site_type_rows['affiliate_site_type_name']."</label>\n";
	unset($radioFirst);
}
// ���¿�ʼ���ǲ������ݡ��� by lwkai ���ע�� 2012-06-12

//���������ø����˻���Ϣ�����Af����Ϣ{
$customers = tep_db_query("select * from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
$customersInfo = tep_db_fetch_array($customers);

$affiliateInfo['affiliate_firstname'] = $customersInfo['customers_firstname'];
$affiliateInfo['affiliate_lastname'] = $customersInfo['customers_lastname'];
$tmpArray = explode(' ',$affiliateInfo['affiliate_lastname']);
$affiliateInfo['surName'] = $tmpArray[0];
$affiliateInfo['givenName'] = $tmpArray[1];
$affiliateInfo['affiliate_email_address'] = $customersInfo['customers_email_address'];
$affiliateInfo['affiliate_mobile'] = $customersInfo['customers_mobile_phone'];
$affiliateInfo['affiliate_telephone'] = $customersInfo['customers_telephone'];
//���������ø����˻���Ϣ�����Af����Ϣ}

//����������������ύ���������{
foreach($affiliateInfo as $key => $val){
	$$key = tep_db_prepare_input($val);
}
if(!tep_not_null($affiliate_email_address)) $affiliate_email_address = $_SESSION['customer_email_address'];
//����������������ύ���������}

$affiliate_verified = $_SESSION['affiliate_verified'];
$post_verification_successful = 0;
if((int)$affiliate_verified){	//�Ѿ���֤
	//�ύ����ɹ����ҳ�洦��{
	if((int)$_SESSION['affiliate_verification_successful']){
		$post_verification_successful = 1;
		unset($_SESSION['affiliate_verification_successful']);
		//�����г��Ƽ�{
		$hotProducts = getAffiliateAllProducts(10);
		//�����г��Ƽ�}
	}
	//}
	foreach($affiliateInfo as $key => $val){
		$affiliateInfo[$key] = tep_db_output($val);	//����Ҫ��ʾ����htmlҳ�������
	}
}

//affiliate info }
$breadcrumb->add(NAVBAR_TITLE_2, tep_href_link('affiliate_my_info.php', '', 'SSL'));

$content = 'affiliate_my_info';
$validation_include_js = 'true';
$validation_div_span = 'span';
$is_my_account = true;
require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

require(DIR_FS_INCLUDES . 'application_bottom.php');
?>
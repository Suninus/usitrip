<?php
/*
$Id: create_account.php,v 1.4 2004/09/25 15:09:15 DMG Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2003 osCommerce

Released under the GNU General Public License
*/

require('includes/application_top.php');
//��Ա���ֿ� BEGIN
//���ֿ��û� ���ֿ������ʼ��Ϊ�û���ע������
$error =false;
$password = tep_db_prepare_input($_POST['password']);
$confirmation = tep_db_prepare_input($_POST['confirmation']);//����ʼ����ǰ

if (tep_not_null($_GET['pointcards_code']) || tep_not_null($_POST['pointcards_code'])) {
	if(tep_not_null($_POST['pointcards_code'])) {
		$pointcards_code = $_POST['pointcards_code'];
	} else {
		$pointcards_code = $_GET['pointcards_code'];
	}
	$isPointCardUser=true;
	//$breadcrumb->add(db_to_html('��Ա���ֿ��û�ע��'));
	$pc_inf                = explode(":",vin_crypt($pointcards_code,'decode'));
	$pc_id                 = intval($pc_inf[0]);
	$pc_password           = tep_db_input($pc_inf[1]);
	$pointcards_id_display = format_pointcard($pc_id);

	if (isset($_POST['pc_change_password'])) {
		$pc_change_password  = tep_db_prepare_input($_POST['pc_change_password']);
		$pc_confirm_password = tep_db_prepare_input($_POST['pc_confirm_password']);
		if ( strlen($pc_change_password) < ENTRY_PASSWORD_MIN_LENGTH) {
			$error = true;
			$messageStack->add('create_account', ENTRY_PASSWORD_ERROR);
		}
		
		if ( $pc_change_password != $pc_confirm_password) {
			$error = true;
			$messageStack->add('create_account', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
		}
		if (!$error) {
			$password     = $pc_change_password;
			$confirmation = $pc_change_password;
		}
	}
	
	
	$_POST['password']     = $pc_password;
	$_POST['confirmation'] = $pc_password;
	
	$member_point_card_query = tep_db_query('SELECT pointcards_id,password,UNIX_TIMESTAMP(expire_date) as exdate,UNIX_TIMESTAMP(active_date) as actdate FROM '. TABLE_POINTCARDS.' WHERE pointcards_id = '.$pc_id.' AND password=\''.$pc_password.'\'');
	$pointcards_info = tep_db_fetch_array($member_point_card_query);
	// tep_db_free_result($pointcards_info);
} else {
	$isPointCardUser=false;
}


//��Ա���ֿ�END
// needs to be included earlier to set the success message in the messageStack
require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_CREATE_ACCOUNT);
require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_LOGIN);
/* ��������ķ�������ע����ע����Ϸ��� Panda */
if (isset($_GET['reg_method']) && tep_not_null($_GET['reg_method'])) {
	$_SESSION['reg_method'] = $_GET['reg_method'];
}

/* ��������ķ�������ע����ע����Ϸ��� Panda */

$process = false;
if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
	$process = true;
	
	if ((int)$Admin->login_id == 0) { //�����������ע��,����Ҫ��֤��
		//vincent ���ͼ����֤�� vvc
		if ( strtolower($_POST['visual_verify_code']) != strtolower($_SESSION['captcha_key'])) {
			$error = true;
			$messageStack->add('create_account', db_to_html('��֤�������������ȷ����֤�룡'),'error','verify_vvc');
		}
		//�����֤�����
	} else {
		//����ǿͷ������ע��,����Ҫ�����������.�����ʼ�����ǰע������� by lwkai add 2012-09-25 10:42
		$email_address = tep_db_prepare_input($_POST['email_address']);
		$temp=explode('@', $email_address);//12��17�գ�wtj��Ӱ��������ĳ�������
		$password = $temp[0];
// 		$password = tep_create_random_value(ENTRY_PASSWORD_MIN_LENGTH); //�ͷ������ע��,�������������.���˲���Ҫ�ṩ������ͷ�.
		$confirmation = $password; //��ȷ��������ԭ����һ�£������жϲ���ͨ��
	}
	if (ACCOUNT_GENDER == 'true' && USE_OLD_VERSION) {
		if (isset($_POST['gender'])) {
			$gender = tep_db_prepare_input($_POST['gender']);
		} else {
			$gender = false;
		}
	}
	
	$firstname = tep_db_prepare_input($_POST['firstname']);
	$lastname  = tep_db_prepare_input($_POST['lastname']);

	if (ACCOUNT_DOB == 'true' && USE_OLD_VERSION) {
		$dob = tep_db_prepare_input($_POST['dob']);	
	}

	$email_address = tep_db_prepare_input($_POST['email_address']);
	if (ACCOUNT_COMPANY == 'true' && USE_OLD_VERSION){
		$company = tep_db_prepare_input($_POST['company']);
	}

	if (FULL_ADDRESS_AND_POSTCODE == 'true' && USE_OLD_VERSION) {
		$street_address = tep_db_prepare_input($_POST['street_address']);
		$postcode       = tep_db_prepare_input($_POST['postcode']);
	}

	if (ACCOUNT_SUBURB == 'true' && USE_OLD_VERSION) {
		$suburb = tep_db_prepare_input($_POST['suburb']); 
	}

	$city = tep_db_prepare_input($_POST['city']);
	if (ACCOUNT_STATE == 'true'&& USE_OLD_VERSION) {
		$state = tep_db_prepare_input($_POST['state']);
		if (isset($_POST['zone_id'])) {
			$zone_id = tep_db_prepare_input($_POST['zone_id']);
		} else {
			$zone_id = false;
		}
	}
	$country = tep_db_prepare_input($_POST['country']);

	//warning: telephone is office phone, fax is home phone, mobile_phone ismobile phone.
	$telephone = '';
	$_POST['telephone'] = preg_replace('/\D/','',$_POST['telephone']);
	$confirmphone = $_POST['telephone'];
	if((int)$_POST['phone_type']==0 && USE_OLD_VERSION){
		$_POST['phone_type'] ='1';
	}
	if($_POST['phone_type'] == '1' && USE_OLD_VERSION){
		$telephone = tep_db_prepare_input($_POST['telephone_cc']).'-'.tep_db_prepare_input($_POST['telephone']);
	}
	if($_POST['phone_type'] == '2' && USE_OLD_VERSION){
		$mobile_phone = tep_db_prepare_input($_POST['telephone_cc']).'-'.tep_db_prepare_input($_POST['telephone']);
	}
	if($_POST['phone_type'] == '3' && USE_OLD_VERSION){
		$fax = tep_db_prepare_input($_POST['telephone_cc']).'-'.tep_db_prepare_input($_POST['telephone']);
	}

	if (isset($_POST['newsletter'])&& USE_OLD_VERSION) {
		$newsletter = tep_db_prepare_input($_POST['newsletter']);
	} else {
		$newsletter = '0';
	}
	//$password = tep_db_prepare_input($_POST['password']);
	//$confirmation = tep_db_prepare_input($_POST['confirmation']);

	//$error = false;

	if (ACCOUNT_GENDER == 'true' && USE_OLD_VERSION) {
		if ( ($gender != 'm') && ($gender != 'f') ) {
			$error = true;
			$messageStack->add('create_account', ENTRY_GENDER_ERROR);
		}
	}
	
	if (strlen($firstname) < 1) { //ENTRY_FIRST_NAME_MIN_LENGTH
		$error = true;
		$messageStack->add('create_account', ENTRY_FIRST_NAME_ERROR,'error','verify_firstname');
	}
	
	
	if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH && FULL_ADDRESS_AND_POSTCODE == 'true' && USE_OLD_VERSION) {
		$error = true;
		$messageStack->add('create_account', ENTRY_LAST_NAME_ERROR);
	}

	if (ACCOUNT_DOB == 'true' && USE_OLD_VERSION) {
		if (@checkdate(substr(tep_date_raw($dob), 4, 2), substr(tep_date_raw($dob), 6, 2), substr(tep_date_raw($dob), 0, 4)) == false) {
			$error = true;
			$messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);
		}
	}
	//��֤email��ַ
	$err_msg = tep_validate_email_for_register(html_to_db($email_address),true);
	if($err_msg != ''){
		$error = true;
		$messageStack->add('create_account', $err_msg,'error','verify_email');
	}
	
	$reg_arr = reg_filter();
	foreach($reg_arr as $val) {
		if (strpos($firstname,$val) !== false) {
			$error = true;
			$messageStack->add('create_account', db_to_html("��������ʹ����ͬ�����������뻻һ�����ơ�"));
			break;
		}
	}
	
	$temp_email = html_to_db($email_address);
	reset($reg_arr);
	foreach($reg_arr as $val) {
		if (strpos($temp_email,$val) !== false) {
			$error = true;
			$messageStack->add('create_account', db_to_html("������������Ѿ�ע���!��ȷ�ϻ�һ���������䡣"));
			break;
		}
	}
	/*
	if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
	$error = true;

	$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
	} elseif (tep_validate_email($email_address) == false) {
	$error = true;

	$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
	} else {
	$check_email_query = tep_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
	$check_email = tep_db_fetch_array($check_email_query);
	// BOF: daithik - PWA
	//	if ($check_email['total'] > 0) {
	//		$error = true;
	//		$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
	//	}
	if ($check_email['total'] > 0)
	{//PWA delete account
	$get_customer_info = tep_db_query("select customers_id, customers_email_address, purchased_without_account from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
		$customer_info = tep_db_fetch_array($get_customer_info);
		$customer_id = $customer_info['customers_id'];
		$customer_email_address = $customer_info['customers_email_address'];
		$customer_pwa = $customer_info['purchased_without_account'];
		if ($customer_pwa !='1')
		{
		$error = true;

		$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
				} else {
			tep_db_query("delete from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $customer_id . "'");
			tep_db_query("delete from " . TABLE_CUSTOMERS . " where customers_id = '" . $customer_id . "'");
			tep_db_query("delete from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . $customer_id . "'");
			tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . $customer_id . "'");
			tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . $customer_id . "'");
			tep_db_query("delete from " . TABLE_WHOS_ONLINE . " where customer_id = '" . $customer_id . "'");
		}
	}
	// EOF: daithik - PWA
	}*/

	if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH && FULL_ADDRESS_AND_POSTCODE == 'true' && USE_OLD_VERSION) {
		$error = true;
		$messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);
	}

	if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH && FULL_ADDRESS_AND_POSTCODE == 'true'&&USE_OLD_VERSION) {
		$error = true;
		$messageStack->add('create_account', ENTRY_POST_CODE_ERROR);
	}

	if (strlen($city) < ENTRY_CITY_MIN_LENGTH && FULL_ADDRESS_AND_POSTCODE == 'true'&&USE_OLD_VERSION) {
		$error = true;
		$messageStack->add('create_account', ENTRY_CITY_ERROR);
	}

	if (is_numeric($country) == false && $isPointCardUser == FALSE && USE_OLD_VERSION) {
		$error = true;
		$messageStack->add('create_account', ENTRY_COUNTRY_ERROR);
	}
	
	if (ACCOUNT_STATE == 'true' && FULL_ADDRESS_AND_POSTCODE == 'true' && $isPointCardUser == false && USE_OLD_VERSION) { //���ֿ����û�����Ҫ�������
		$zone_id = 0;
		$check_query = tep_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "'");
		$check = tep_db_fetch_array($check_query);
		$entry_state_has_zones = ($check['total'] > 0);
		// State selection bug fix applied 10/1/2004 DMG
		if ($entry_state_has_zones == true) {
			$zone_query = tep_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and (zone_name = '" . html_to_db(tep_db_input($state)) . "' OR zone_code = '" . html_to_db(tep_db_input($state)) . "')");
			if (tep_db_num_rows($zone_query) == 1) {
				$zone = tep_db_fetch_array($zone_query);
				$zone_id = $zone['zone_id'];
			} else {
				$error = true;
				$messageStack->add('create_account', ENTRY_STATE_ERROR_SELECT);
			}
		} else {
			if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
				$error = true;
				$messageStack->add('create_account', ENTRY_STATE_ERROR);
			}
		}
	}

	if($isPointCardUser == false && USE_OLD_VERSION == true) {//��Ա���ֿ��û�����Ҫ����绰����
		if ( (strlen($_POST['telephone'])-3) < ENTRY_TELEPHONE_MIN_LENGTH && (strlen($telephone)-3) < ENTRY_TELEPHONE_MIN_LENGTH && (strlen($mobile_phone)-3) < ENTRY_TELEPHONE_MIN_LENGTH && (strlen($fax)-3) < ENTRY_TELEPHONE_MIN_LENGTH ) {
			//-3��ָ���Ҵ���ŵĳ���
			$error = true;
			$messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
		} elseif ((int)$country=='44' && strlen($_POST['telephone']) < 10 && strlen($_POST['telephone']) > 1) {
			$error = true;
			$messageStack->add('create_account', db_to_html('�������д�����������룬����ǰ��������ţ��磺010'.(string)$_POST['telephone']));
		}
		if (!(int)$_POST['phone_type'] &&USE_OLD_VERSION) {
			$error = true;
			$messageStack->add('create_account', PHONE_TYPE_ERROR);
		}
	}
	//��Ա���ֿ� ������ begin
	//vincent
	if($isPointCardsUser){
		if (!tep_not_null($pointcards_info)) {
			$error=true;
			$messageStack->add('create_account',db_to_html('���Ļ��ֿ����Ż��������!'));
		}elseif(intval($pointcards_info['exdate']) < time() || intval($pointcards_info['actdate'])>time()){
			$error=true;
			$messageStack->add('create_account',db_to_html('���Ļ����Ѿ����ڻ�û�м��'));
		}else{
			$member_point_card_rel_query = tep_db_query('SELECT * FROM '. TABLE_POINTCARDS_TO_CUSTOMERS.' WHERE pointcards_id = '.$pointcards_info['pointcards_id']);
			$pointcards_rel_info = tep_db_num_rows($member_point_card_rel_query);
			//tep_db_free_result($member_point_card_rel_query);
			if($pointcards_rel_info > 0 ){
				$error=true;
				$messageStack->add('create_account',db_to_html('���Ļ����Ѿ�ע����ˣ�'));
			}
		}
	}



	if (!$isPointCardUser && strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
		$error = true;
		$messageStack->add('create_account', ENTRY_PASSWORD_ERROR,'error','verify_password');
	} elseif (!$isPointCardUser && $password != $confirmation) {
		$error = true;
		$messageStack->add('create_account', ENTRY_PASSWORD_ERROR_NOT_MATCHING,'error','verify_password2');
	}
	//��Ա���ֿ�������end
	
	//tom added ��֤���жϣ�
	if (tep_not_null($_POST['yanzhengma'])) {
		$sql = tep_db_query('SELECT to_content FROM `cpunc_sms_history` WHERE to_phone ="'.tep_db_prepare_input($_POST['telephone']).'" ORDER BY `add_date` desc limit 1');
		$row = tep_db_fetch_array($sql);
		$str = '';
		$to_content = $row['to_content'];
		$to_content = preg_replace("/\D+/", $str, $to_content);
		if($to_content!=$_POST['yanzhengma']){
			$error=true;
			$messageStack->add('create_account',db_to_html('��֤�����'));
		}
	}
	if (check_mobilephone_for_profile_update($confirmphone)) {
		$check_sql = tep_db_query('SELECT * FROM `customers` WHERE confirmphone ="'.tep_db_prepare_input($confirmphone).'"');
		if ((int)tep_db_num_rows($check_sql)>'0') {
			$error=true;
			$messageStack->add('create_account',db_to_html('���ֻ����Ѿ�ע���'));
		}
	}
	// �ͻ���Դutm_source id
	if (tep_not_null($customers_advertiser)){
		$referer_type_query = tep_db_query("SELECT customers_ref_type_id FROM ". TABLE_CUSTOMERS_REF_TYPE2 . " WHERE customers_ref_type_value ='". strtolower($customers_advertiser) ."'");
		$referer_type = tep_db_fetch_array($referer_type_query); 
		$referer_type_id = $referer_type['customers_ref_type_id'];
	}
	
	
	if ($error == false) {
		$newsletter = '1' ; //Ĭ�϶��ĵ��ӱ�
		if(check_mobilephone_for_profile_update($confirmphone)){
			$sql_data_array = array(
				'customers_firstname' => $firstname,
				'customers_lastname'=> $lastname,
				'customers_email_address' => $email_address,
				'customers_telephone' => $telephone,
				'customers_mobile_phone'=> $mobile_phone,
				'customers_fax' => $fax,
				'customers_newsletter'=> $newsletter,
				'customers_referer_url' => $referer_url,
				'customers_referer_type'=> $referer_type_id,
				'confirmphone'=> $confirmphone,
				'customers_notice'=> $customers_notice,
				'customers_password'=> tep_encrypt_password($password)
			);
		}else{
			$sql_data_array = array(
				'customers_firstname' => $firstname,
				'customers_lastname'=> $lastname,
				'customers_email_address' => $email_address,
				'customers_telephone' => $telephone,
				'customers_mobile_phone'=> $mobile_phone,
				'customers_fax' => $fax,
				'customers_newsletter'=> $newsletter,
				'customers_referer_url' => $referer_url,
				'customers_referer_type'=> $referer_type_id,
				'customers_notice'=> $customers_notice,
				'customers_password'=> tep_encrypt_password($password)
			);
		}

		if (ACCOUNT_GENDER == 'true') {
			$sql_data_array['customers_gender'] = $gender;
		}

		if (ACCOUNT_DOB == 'true') {
			$sql_data_array['customers_dob'] = tep_date_raw($dob);
		}

		$sql_data_array = html_to_db ($sql_data_array);
		tep_db_perform(TABLE_CUSTOMERS, $sql_data_array);
		
		$customer_id = tep_db_insert_id();
		//��Ա���ֿ� BEGIN
		//ע��ɹ�����û��Ƿ��Ա���ֿ��û�
		//�ǵĻ� ���»��ֿ�״̬/���ӻ���/�����˺Ź���
		//20011-4-6 vincent
		if ($isPointCardUser) {
			//$member_point_card_update_query= 'UPDATE '.TABLE_POINTCARDS." SET is_used = 1 ,last_login_date = '".date('Y-m-d H:i:s' ,time())."' WHERE pointcards_id=".$pc_id;
			///tep_db_query($member_point_card_update_query);//���»��ֿ���״̬
			$member_point_card_relation_insert_query = 'INSERT INTO '.TABLE_POINTCARDS_TO_CUSTOMERS.' SET customers_id='.$customer_id.' ,pointcards_id='.$pc_id;
			tep_db_query($member_point_card_relation_insert_query);//��д������
			tep_add_pending_points_pointcard_register($customer_id);
			$pointcards_id = $pc_id;
			$pointcards_id_string = format_pointcard($pc_id);
			tep_session_register('pointcards_id');
			tep_session_register('pointcards_id_string');
		}
		//��Ա���ֿ� END
		
		/* �Զ�ע��͵�¼���� */
		//$WordPress->auto_reg_user($email_address, $email_address, $password);
		//$_SESSION['WordPressLogin'] = $WordPress->auto_login_user($email_address, $password);
		$WordPressLogin = $WordPress->auto_reg_user($email_address, $email_address, $password); //�����ڵĺ������Ѿ�ע�͵���.���������Ǹ����õĵ���.�����κζ���
		tep_session_register('WordPressLogin');
		//���û����ĵ��ӱ�{
		$newsletter_info = array(
			'newsletters_email_address'=>$email_address,
			'newsletter_sent'=>'0',
			'agree_newsletter'=>'1',
			'content_id'=>'1',//���ķ�E��
		);
		tep_db_perform('newsletters_email', $newsletter_info);
		//}

		//���ע��ɹ�
		//�����Ƽ����ѵĻ���״̬
		//�����ID�Ѿ����������ٸ���
		if((int)$refriend_points_unique_id){
			$check_sql = tep_db_query('SELECT unique_id, customer_id, points_pending FROM '.TABLE_CUSTOMERS_POINTS_PENDING.' WHERE unique_id="'.(int)$refriend_points_unique_id.'" AND points_status="1" ');
			$check_row = tep_db_fetch_array($check_sql);
			if((int)$check_row['unique_id'] && (int)$check_row['customer_id']){
				tep_db_query('update '.TABLE_CUSTOMERS_POINTS_PENDING.' SET points_status="2" WHERE unique_id="'.(int)$refriend_points_unique_id.'" AND points_status="1" ');
				tep_auto_fix_customers_points((int)$check_row['customer_id']);	//�Զ�У���û�����

			}
			tep_session_unregister('refriend_points_unique_id');
		}
			//�����Ƽ����ѵĻ���״̬end

		//�Ͽͻ��Ƽ������ start
		$Old_Customer_Testimonials = (int)$_POST['Old_Customer_Testimonials'];
		$old_customer_email_address = tep_db_prepare_input(trim($_POST['old_customer_email_address']));
		$max_recommendation_num = 5;	//ÿ���Ͽͻ���಻���Ƽ�����5��
		$old_customer_add_points = 200;	//����Ƽ���200����
		if($Old_Customer_Testimonials_Action==true && $email_address!=$old_customer_email_address ){
			$old_customer_id = form_email_get_customers_id($old_customer_email_address);
			if($Old_Customer_Testimonials=='1' && (int)$old_customer_id){
				tep_db_query("update " . TABLE_CUSTOMERS . " set recommend_customer_id = '" . (int)$old_customer_id . "' where customers_id = '" . (int)$customer_id . "'");
				$check_old_sql = tep_db_query('SELECT count(*) as total FROM `old_customer_testimonials` WHERE old_customer_email_address="'.tep_db_input($old_customer_email_address).'" ');
				$check_old_row = tep_db_fetch_array($check_old_sql);
				$check_new_sql = tep_db_query('SELECT new_customer_email_address FROM `old_customer_testimonials` WHERE new_customer_email_address="'.tep_db_input($email_address).'" ');
				$check_new_row = tep_db_fetch_array($check_new_sql);

				if($check_old_row['total'] < $max_recommendation_num && !tep_not_null($check_new_row['new_customer_email_address'])){
					tep_db_query('INSERT INTO `old_customer_testimonials` (`old_customer_email_address`,`new_customer_email_address`,`add_date`) VALUES ("'.tep_db_input($old_customer_email_address).'", "'.tep_db_input($email_address).'", NOW());');
					//���Ͽͻ��ӷ�
					tep_add_pending_points_old_customer_refriend($old_customer_id, $old_customer_add_points);
				}

			}
		}
		//�Ͽͻ��Ƽ������ end


		//���ע��ɹ���дһ��Session����$_SESSION['account_success']=1������ʾGoogleע�����ҳ��
		$account_success = '1';
		tep_session_register('account_success');

		$sql_data_array = array(
			'customers_id' => $customer_id,
			'entry_firstname' => $firstname,
			'entry_lastname' => $lastname,
			'entry_street_address' => $street_address,
			'entry_postcode' => $postcode,
			'entry_city' => $city,
			'entry_country_id' => $country
		);

		if (ACCOUNT_GENDER == 'true') {
			$sql_data_array['entry_gender'] = $gender;
		}
		if (ACCOUNT_COMPANY == 'true') {
			$sql_data_array['entry_company'] = $company;
		}
		if (ACCOUNT_SUBURB == 'true') {
			$sql_data_array['entry_suburb'] = $suburb;
		}
		if (ACCOUNT_STATE == 'true') {
			if ($zone_id > 0) {
				$sql_data_array['entry_zone_id'] = $zone_id;
				$sql_data_array['entry_state']   = '';
			} else {
				$sql_data_array['entry_zone_id'] = '0';
				$sql_data_array['entry_state']   = $state;
			}
		}

		$sql_data_array = html_to_db ($sql_data_array);
		tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

		$address_id = tep_db_insert_id();
		//vincent- add lastlogin 
		//$customer_lastlogin	= date('Y-m-d H:i:s' ,time()); 
		
		//vincent- add lastlogin finish

		tep_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customer_id . "'");

		//vincent -��¼�ͻ���ע��IP
		tep_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_date_of_last_logon,customers_info_id, customers_info_number_of_logons, customers_info_date_account_created,customers_info_register_ip,last_ip_address) values (now(),'" . (int)$customer_id . "', '0', now(),'".get_client_ip()."','".get_client_ip()."')");

		if (SESSION_RECREATE == 'True') {
			tep_session_recreate();
		}

		//Howard added to set affiliate session and check if user exits in affiliate table start{
		setSessionAffiliateInfo($customer_id);
		//Howard added to set affiliate session and check if user exits in affiliate table end }

		$customer_first_name = html_to_db($firstname);
		$customer_default_address_id = $address_id;
		$customer_country_id = $country;
		$customer_zone_id = $zone_id;
		$customer_email_address = $email_address;
		$customer_validation = '0';
		tep_session_register('customer_id');
		tep_session_register('customer_first_name');
		tep_session_register('customer_default_address_id');
		tep_session_register('customer_country_id');
		tep_session_register('customer_zone_id');
		tep_session_register('customer_email_address');
		tep_session_register('customer_validation');
		//Howard fixed �ж������������ע��Ļ��ͼ�¼һ�����۱��
		if((int)$Admin->login_id >0){
			$Admin->login_check('', false);
		}
		//amit fixed to allow first time discount start
		$total_pur_suc_nos_of_cnt = 1;
		tep_session_register('total_pur_suc_nos_of_cnt');
		 // amit fixed to allow first time discount end
		//tep_session_register('customer_lastlogin'); //register last login
		 // restore cart contents
		$cart->restore_contents();
		// write favorites;
		auto_add_session_to_favorites();

		// james add for resolve the ill-font problem.

		$custer_info_query = tep_db_query("select * from customers where customers_id = '".$customer_id."'");//fetch customer info.
		$custer_info = tep_db_fetch_array($custer_info_query);
		$firstname1 = $custer_info['customers_firstname'];
		$lastname1 = $custer_info['customers_lastname'];
		//end of james add.

		// build the message content
		$name = $firstname . ' ' . $lastname;

		if (ACCOUNT_GENDER == 'true') {
			if ($gender == 'm') {
				//$email_text = sprintf(EMAIL_GREET_MR, $CharEncoding->EncodeString($lastname));
				$email_text = sprintf(EMAIL_GREET_MR, $firstname);
			} else {
				//$email_text = sprintf(EMAIL_GREET_MS, $CharEncoding->EncodeString($lastname));
				$email_text = sprintf(EMAIL_GREET_MS, $firstname);
			}
		} else {
			//$email_text = sprintf(EMAIL_GREET_NONE, $CharEncoding->EncodeString($firstname));
			$email_text = sprintf(EMAIL_GREET_NONE, $firstname);
		}

		// Points/Rewards system V2.1rc2a BOF
		if ((USE_POINTS_SYSTEM == 'true') && (NEW_SIGNUP_POINT_AMOUNT > 0)) {
			tep_add_welcome_points($customer_id);

			/*$points_account = '<a href="' . tep_href_link(FILENAME_MY_POINTS, '', 'SSL') . '"><b><u>' . EMAIL_POINTS_ACCOUNT . '</u></b></a>.';
			$points_faq = '<a href="' . tep_href_link(FILENAME_MY_POINTS_HELP, '', 'NONSSL') . '"><b><u>' . EMAIL_POINTS_FAQ . '</u></b></a>.';
			$text_points = sprintf(EMAIL_WELCOME_POINTS , $points_account, number_format(NEW_SIGNUP_POINT_AMOUNT,POINTS_DECIMAL_PLACES), $currencies->format(tep_calc_shopping_pvalue(NEW_SIGNUP_POINT_AMOUNT)), $points_faq) ."\n\n";

			$email_text .= EMAIL_WELCOME . EMAIL_TEXT . $text_points . EMAIL_CONTACT; // . EMAIL_WARNING;*/
		}
		/* else {
			$email_text .= EMAIL_WELCOME . EMAIL_TEXT .EMAIL_CONTACT; // . EMAIL_WARNING;
		}*/
		// Points/Rewards system V2.1rc2a EOF


		$email_text .= EMAIL_WELCOME . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;

		// ICW - CREDIT CLASS CODE BLOCK ADDED******************************************************* BEGIN
		if (NEW_SIGNUP_GIFT_VOUCHER_AMOUNT > 0) {
			$coupon_code = create_coupon_code();
			$insert_query = tep_db_query("insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $coupon_code . "', 'G', '" . NEW_SIGNUP_GIFT_VOUCHER_AMOUNT . "', now())");
			$insert_id = tep_db_insert_id($insert_query);
			$insert_query = tep_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id ."', '0', 'Admin', '" . $email_address . "', now() )");
			$email_text .= sprintf(EMAIL_GV_INCENTIVE_HEADER, $currencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)) . "\n\n" .
						 sprintf(EMAIL_GV_REDEEM, $coupon_code) . "\n\n" .
						 EMAIL_GV_LINK . tep_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code,'NONSSL', false) .
						 "\n\n";
		}
		if (NEW_SIGNUP_DISCOUNT_COUPON != '') {
			$coupon_code = NEW_SIGNUP_DISCOUNT_COUPON;
			$coupon_query = tep_db_query("select * from " . TABLE_COUPONS . " where coupon_code = '" . $coupon_code . "'");
			$coupon = tep_db_fetch_array($coupon_query);
			$coupon_id = $coupon['coupon_id'];
			$coupon_desc_query = tep_db_query("select * from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $coupon_id . "' and language_id = '" . (int)$languages_id . "'");
			$coupon_desc = tep_db_fetch_array($coupon_desc_query);
			$insert_query = tep_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $coupon_id ."', '0', 'Admin', '" . $email_address . "', now() )");
			$email_text .= EMAIL_COUPON_INCENTIVE_HEADER ."\n" .
						 sprintf("%s", $coupon_desc['coupon_description']) ."\n\n" .
						 sprintf(EMAIL_COUPON_REDEEM, $coupon['coupon_code']) . "\n\n" .
						 "\n\n";
		}

		//howard added send customers mail for new year
		if(date('Ymd')<=20090208){

			$email_text .= FEEDBACK_HTML;

		}
		//howard added send customers mail for new year end

		$email_text .= EMAIL_ACCOUNT_FOOTER;

		//	$email_text .= EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;
		// ICW - CREDIT CLASS CODE BLOCK ADDED******************************************************* END

		// zhh fix and added
		$to_name          = $name;
		$to_email_address = $email_address;
		$email_subject    = EMAIL_SUBJECT. db_to_html(' ��������ĵ�¼��Ϣ��');
		$email_text       = $email_text;

		//echo '[text]'.$email_text.'[text]';
		//exit;

		$from_email_name = STORE_OWNER;
		$from_email_address = STORE_OWNER_EMAIL_ADDRESS;

		//howard added new eamil tpl
		$patterns    = array();
		$patterns[0] = '{CustomerName}';
		$patterns[1] = '{images}';
		$patterns[2] = '{HTTP_SERVER}';
		$patterns[3] = '{EMAIL}';
		$patterns[4] = '{CONFORMATION_EMAIL_FOOTER}';
		if ((int)$Admin->login_id > 0) {
			$patterns[5] = '{PASSWORD}';
		}

		$replacements = array();
		//$replacements[0] = str_replace('<br>','',sprintf(EMAIL_GREET_NONE, $firstname));
		$replacements[0] = $firstname;
		$replacements[1] = HTTP_SERVER.'/email_tpl/images';
		$replacements[2] = HTTP_SERVER;
		$replacements[3] = $to_email_address;
		$replacements[4] = db_to_html(nl2br(CONFORMATION_EMAIL_FOOTER));
		if ((int)$Admin->login_id > 0) {
			$replacements[5] = db_to_html('<p style="margin:0;padding:0;">���룺<span style="color:#ff6600;font-size:16px;"><b>' . $password . '</b></span>&nbsp;ע�����ִ�Сд��</p>');
		}

		$email_tpl = file_get_contents(DIR_FS_CATALOG.'email_tpl/header.tpl.html');
		$email_tpl.= file_get_contents(DIR_FS_CATALOG.'email_tpl/create_account_table.tpl.html');
		$email_tpl.= file_get_contents(DIR_FS_CATALOG.'email_tpl/footer.tpl.html');
		
		$email_text = str_replace( $patterns ,$replacements, db_to_html($email_tpl)). email_track_code('RG',$to_email_address);
		$email_text = preg_replace('/[[:space:]]+/',' ',$email_text);
		
		//howard added new eamil tpl end

		//tep_mail($to_name, $to_email_address, $email_subject, $email_text, $from_email_name, $from_email_address, 'true');

		//howard add use session+ajax send email
		
		$_SESSION['need_send_email']                          = array();
		$_SESSION['need_send_email'][0]['to_name']            = $to_name;
		$_SESSION['need_send_email'][0]['to_email_address']   = $to_email_address;
		$_SESSION['need_send_email'][0]['email_subject']      = $email_subject;
		$_SESSION['need_send_email'][0]['email_text']         = $email_text;
		$_SESSION['need_send_email'][0]['from_email_name']    = $from_email_name;
		$_SESSION['need_send_email'][0]['from_email_address'] = $from_email_address;
		$_SESSION['need_send_email'][0]['action_type']        = 'true';
		//howard add use session+ajax send email end

		//howard added send notice email
		/*
		if($newsletter!='1'){
			$patterns = array();
			$patterns[0] = '{CustomerName}';
			$patterns[1] = '{images}';
			$patterns[2] = '{HTTP_SERVER}';
			$patterns[3] = '{EMAIL}';
			$patterns[4] = '{CONFORMATION_EMAIL_FOOTER}';

			$replacements = array();
			$replacements[0] = str_replace('<br>','',sprintf(EMAIL_GREET_NONE, $firstname));
			$replacements[1] = HTTP_SERVER.'/email_tpl/images';
			$replacements[2] = HTTP_SERVER;
			$replacements[3] = $to_email_address;
			$replacements[4] = db_to_html(nl2br(CONFORMATION_EMAIL_FOOTER));
			
			$email_tpl = file_get_contents(DIR_FS_CATALOG.'email_tpl/header.tpl.html');
			$email_tpl.= file_get_contents(DIR_FS_CATALOG.'email_tpl/confirmation_newslleter_email_table.tpl.html');
			$email_tpl.= file_get_contents(DIR_FS_CATALOG.'email_tpl/footer.tpl.html');
			
			$email_text = str_replace( $patterns ,$replacements, db_to_html($email_tpl));
			$email_text = preg_replace('/[[:space:]]+/',' ',$email_text);

			$_SESSION['need_send_email'][1]['to_name'] = $to_name;
			$_SESSION['need_send_email'][1]['to_email_address'] = $to_email_address;
			$_SESSION['need_send_email'][1]['email_subject'] = CONFI_NEWSLLETTER_SUBJECT;
			$_SESSION['need_send_email'][1]['email_text'] = $email_text;
			$_SESSION['need_send_email'][1]['from_email_name'] = $from_email_name;
			$_SESSION['need_send_email'][1]['from_email_address'] = $from_email_address;
			$_SESSION['need_send_email'][1]['action_type'] = 'true';
		}*/
		//howard added send notice email end
		 $DELAY_AJAX_EMAIL_SEND= true; //vincent add to delay email send

		//������֤����ͻ�
		//send_validation_mail($customer_email_address); //gavinҪ��ȥ��
		var_dump($navigation);
		
		//�Ż����ݱ�
		tep_db_query('OPTIMIZE TABLE `customers`, `address_book` ');
		//tep_redirect(tep_href_link(FILENAME_CREATE_ACCOUNT_SUCCESS, '', 'SSL'));
		/*reg shooping link*/
	
		$_SESSION['include_create_account_success'] = 1; 
		/* ��������ķ���������ԭ·���� Panda */
		if ($_SESSION['reg_method'] == 'tours-talent-contest'){
			unset($_SESSION['reg_method']);					 
			tep_redirect(tep_href_link('tours-talent-contest.php'));
		}else if(is_object($_SESSION['cart']) && count($_SESSION['cart']->contents)>0){
			tep_redirect(tep_href_link('shopping_cart.php'));
		}elseif((int)$Admin->login_id){/*�����������۰����ע��Ĳ�Ҫ���û�����*/
			//����Ҫ������������һ�£��ȰѲ�Ʒ���빺�ﳵ�ٰ����ע��
			tep_redirect(tep_href_link('shopping_cart.php'));
		}else{
			tep_redirect(tep_href_link('account.php', '', 'SSL'));
		}
	
	}
//---------------------------------------------------------------------------------------------------------------------
}elseif (isset($_GET['action']) && ($_GET['action'] == 'validate')) {
	$ajax = true;
	//����֤���ִ���	
	if($_GET['validator'] == 'email'){
		$email = html_to_db(ajax_to_general_string($_GET['data']));
		$error = html_to_db(tep_validate_email_for_register(html_to_db($email)));
		$reg_arr = reg_filter();
		foreach($reg_arr as $val) {
			if (strpos($email,$val) !== false) {
				$error = "������������Ѿ�ע���!��ȷ�ϻ�һ���������䡣";
				break;
			}
		}
		if($error!=''){
			echo general_to_ajax_string("1,".db_to_html($error));
		}else{
			echo general_to_ajax_string("0,ok");
		}
	}elseif($_GET['validator'] == 'name'){
		
		$data = html_to_db(ajax_to_general_string(rawurldecode($_GET['data'])));
		$num_name = tep_db_query( "SELECT `customers_lastname` FROM ".TABLE_CUSTOMERS." WHERE customers_firstname = '".tep_db_prepare_input($data)."'");
		$num = tep_db_num_rows($num_name);
		$reg_arr = reg_filter();
		foreach($reg_arr as $val) {
			if (strpos($data,$val) !== false) {
				$num = 1;
				break;
			}
		}
		if($num > 0)
			echo general_to_ajax_string(db_to_html("1,��������ʹ����ͬ�����������뻻һ�����ơ�"));
		else 
			echo general_to_ajax_string("0,ok");
	}elseif($_GET['validator'] == 'vvc'){
		if($_GET['data']!='' && strtolower($_GET['data'])==strtolower($_SESSION['captcha_key'])){
			echo general_to_ajax_string("0,ok");
		}else 
			echo general_to_ajax_string(db_to_html("1,��֤�����,��������������ͼƬ��һ�š�")); //.$_GET['data']." = ".$_SESSION['captcha_key']
	}
	exit;
}elseif (isset($_GET['action']) && ($_GET['action'] == 'updateVVC')) {//������֤��	
	$RandomStr = md5(microtime());// md5 to generate the random string										
	$_SESSION['captcha_key'] = substr($RandomStr,0,4);//trim 5 digit
	$RandomImg = 'php_captcha.php?code='. base64_encode($_SESSION['captcha_key']);
	echo $RandomImg;
	exit;
}
	//��֤��
	$RandomStr = md5(microtime());// md5 to generate the random string										
	$_SESSION['captcha_key'] = substr($RandomStr,0,4);//trim 5 digit
	$RandomImg = 'php_captcha.php?code='. base64_encode($_SESSION['captcha_key']);
 
$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
$validation_include_js = 'true';
$content = CONTENT_CREATE_ACCOUNT;
$javascript = 'create_account.js.php';
//if(!USE_OLD_VERSION)$other_css_base_name = 'login_reg';
$other_css_base_name = 'login_reg';
require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

require(DIR_FS_INCLUDES . 'application_bottom.php');
//tep_statistics_addpage(tep_current_url('',true).'?version='.USE_OLD_VERSION,$customer_id);//��¼ҳ��������
?>


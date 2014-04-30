<?php

/*
  $Id: login.php,v 1.1.1.1 2004/03/04 23:38:00 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
 */
require_once('includes/application_top.php');
// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
if ($session_started == false) {
    tep_redirect(tep_href_link(FILENAME_COOKIE_USAGE));
}

require_once(DIR_FS_LANGUAGES . $language . '/' . FILENAME_LOGIN);
require_once(DIR_FS_LANGUAGES . $language . '/' . FILENAME_CREATE_ACCOUNT);

$error = false;
$pointcarderror = false;
// by lwkai add ������վ������վ��¼�� ������վ�Ĵ���
if (isset($_GET['ret']) && $_GET['ret']) {
	$_SESSION['redirect_ret'] = $_GET['ret'];
}
// ����

$ajax_error = '';
if (!isset($ajax) && !isset($_POST['ajax']) && !isset($_GET['ajax'])) {
    $ajax = false;
} else {
    $ajax = (isset($_POST['ajax'])) ? (string) $_POST['ajax'] : (string) $_GET['ajax'];
}

if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {
	
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
    $password = tep_db_prepare_input($HTTP_POST_VARS['password']);
    $email_address_bk = $email_address; //$email_address_bk �������ֻ��Ż������䣬û�иı�ԭ��id

    if (checkregemail($email_address_bk) == true) {
        $check_customer_query = tep_db_query("select customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id, customers_default_ship_address_id, customers_validation, customers_state,customers_group from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address_bk) . "'");
    } else if (check_mobilephone_for_profile_update($email_address_bk)) {
        //$check_customer_query = tep_db_query("select customers_id, customers_firstname,customers_password, customers_email_address, customers_default_address_id, customers_default_ship_address_id, customers_validation, customers_state from " . TABLE_CUSTOMERS . " where customers_telephone LIKE '%" . tep_db_input($email_address_bk) . "'");
        $check_customer_query = tep_db_query("select customers_id, customers_firstname,customers_password, customers_email_address, customers_default_address_id, customers_default_ship_address_id, customers_validation, customers_state,customers_group from " . TABLE_CUSTOMERS . " where confirmphone = '" . tep_db_input($email_address_bk) . "'");

        //$row=tep_db_fetch_array($check_customer_query);
        //$email_address = $row['customers_email_address'];
//###��Ա���ֿ���¼֧��  -----------BEGIN
//2011.3.30 vincent
    }elseif(is_pointcard($email_address_bk)){    	
    	$cardId = intval(str_ireplace('tff','',$email_address_bk));    	    
    	$member_point_card_query = tep_db_query('SELECT pointcards_id,password,UNIX_TIMESTAMP(expire_date) as exdate,UNIX_TIMESTAMP(active_date) as actdate FROM '. TABLE_POINTCARDS.' WHERE pointcards_id = '.$cardId);     	
    	$pointcards_info = tep_db_fetch_array($member_point_card_query);    	
    	tep_db_free_result($member_point_card_query);
    	$member_point_card_rel_query = tep_db_query('SELECT * FROM '. TABLE_POINTCARDS_TO_CUSTOMERS.' WHERE pointcards_id = '.$cardId); 
		$pointcards_rel_info = tep_db_fetch_array($member_point_card_rel_query);
		tep_db_free_result($member_point_card_rel_query);
		if(!tep_not_null($pointcards_info)){
			$pointcarderror = true;
			$error_msn = db_to_html('���Ļ��ֿ����Ż��������');
			$error_target = 'Account';
		}else if(!tep_not_null($pointcards_rel_info)){//δʹ��
			if(intval($pointcards_info['exdate']) < time() || intval($pointcards_info['actdate'])>time()){
				$pointcarderror = true;
				$error_msn = db_to_html('���Ļ����Ѿ����ڻ�û�м��');
				$error_target = 'Account';
			}elseif($pointcards_info['password'] != $password){
				$pointcarderror = true;
				$error_msn = db_to_html('���Ļ��ֿ����Ż��������');
				$error_target = 'Account';
			}else{
				//���ֿ���һ��ʹ�� �����û�������ֿ�ע���û�����
				$pointcards_code = vin_crypt($pointcards_info['pointcards_id'].":".$pointcards_info['password']) ;
				tep_redirect(tep_href_link(FILENAME_CREATE_ACCOUNT,'pointcards_code='.urlencode($pointcards_code)));
				exit;
			}
		}else{//�Ѿ�ע�����
			$check_customer_query = tep_db_query("select customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id, customers_default_ship_address_id, customers_validation, customers_state,customers_group from " . TABLE_CUSTOMERS . " where customers_id = '" . tep_db_input($pointcards_rel_info['customers_id']) . "'");
		}
    	
//###��Ա���ֿ���¼֧�� -----------END
    } else {
        $check_customer_query = tep_db_query("select customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id, customers_default_ship_address_id, customers_validation, customers_state,customers_group from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address_bk) . "'");
    }

// Check if email exists
    //$check_customer_query = tep_db_query("select customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id, customers_default_ship_address_id, customers_validation, customers_state from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
//��ʾ���ֿ����ֵĴ��� BEGIN
// 2011-3-31 vincent
    if ($pointcarderror ) {    	
     	 $error = true;
    	if ($ajax == 'true') {
	           $ajax_error = '[ERROR]' . $error_msn . '[/ERROR]';
	            echo $ajax_error;
	            exit;
	     }
    }
//��ʾ���ֿ����ֵĴ��� END
    elseif (!tep_db_num_rows($check_customer_query)) {
        $error = true;
        $error_msn = db_to_html('�����ڵ��û���/���䣡����Ҫ��ע�ᡣ');
        $error_target = 'Account';
        if ($ajax == 'true') {
            $ajax_error = '[ERROR]' . $error_msn . '[/ERROR]';
            $ajax_error .= '[JS]location="' . tep_href_link("create_account.php", "", "SSL") . '";[/JS]';
            echo $ajax_error;
            exit;
        }
    } else {
        $check_customer = tep_db_fetch_array($check_customer_query);
// Check that password is good
        //����ͻ����ݿ��˺��е�����Ϊ�յĻ��Ͱ��ͻ���ǰ������д�����ݿ⣬���ÿͻ�ͨ����֤
		if(!tep_not_null($check_customer['customers_password']) && tep_not_null($password)){
			$input_password = tep_encrypt_password($password);
			tep_db_query('update '.TABLE_CUSTOMERS.' set customers_password="'.$input_password.'" where customers_email_address="'.tep_db_input($email_address_bk).'" ');
			$check_customer['customers_password'] = $input_password;
		}
		
		$validated = tep_validate_password($password, $check_customer['customers_password']);
		if ($validated == false ) {
            if(!(int)$Admin->login_id){
				$error = true;
				$error_msn = db_to_html('�������');
				$error_target = 'Password';
				if ($ajax == 'true') {
					$ajax_error = '[ERROR]' . $error_msn . '[/ERROR]';
					echo $ajax_error;
					exit;
				}
			}elseif(tep_not_null($password)){
				/*
				������������ж��ǲ������������ڸ������µ�(��̨������Ա)�������µ��������ܽ����û��������Ĳ鿴���޸�����(��������Ա�Ͳ������)
				���۴��͵�¼ʱ��Ҫʹ���Լ��ĵ�¼����
				*/
				if($Admin->login_check($password, true) != true){
					$error = true;
					$error_msn = db_to_html('<b title="����">�������</b>');
					$error_target = 'Password';
					if ($ajax == 'true') {
						$ajax_error = '[ERROR]' . $error_msn . '[/ERROR]';
						echo $ajax_error;
						exit;
					}
				}else{
					$customer_id = $check_customer['customers_id'];
					$customer_default_address_id = $check_customer['customers_default_address_id'];
					$customer_email_address = $check_customer['customers_email_address'];
					$customers_group=$check_customer['customers_group'];
					$customer_first_name = $check_customer['customers_firstname'];
					tep_session_register('customer_id');
					tep_session_register('customer_default_address_id');
					tep_session_register('customer_email_address');
					tep_session_register('customers_group');
					tep_session_register('customer_first_name');
					//ֱ��ȥ���ﳵҳ��
					tep_redirect(tep_href_link('shopping_cart.php', '', 'NONSSL')); 
				}	
			}
        } elseif ((int) $check_customer['customers_state'] < 1) {
            $error = true;
            $error_msn = db_to_html('���ʻ��ѱ����ᣬҪ�ⶳ����ϵ���ǣ�0086-4006-333-926��');
            $error_target = 'Account';
            if ($ajax == 'true') {
                $ajax_error = '[ERROR]' . $error_msn . '[/ERROR]';
                echo $ajax_error;
                exit;
            }
		}else {
            if (SESSION_RECREATE == 'True') {
                tep_session_recreate();
            }

            $check_country_query = tep_db_query("select entry_country_id, entry_zone_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int) $check_customer['customers_id'] . "' and address_book_id = '" . (int) $check_customer['customers_default_address_id'] . "'");
            $check_country = tep_db_fetch_array($check_country_query);

            $customer_id = $check_customer['customers_id'];
            $customer_default_address_id = $check_customer['customers_default_address_id'];
            $customer_default_ship_address_id = $check_customer['customers_default_ship_address_id'];
            $customer_first_name = $check_customer['customers_firstname'];
            $customer_country_id = $check_country['entry_country_id'];
            $customer_zone_id = $check_country['entry_zone_id'];
            $customer_email_address = $check_customer['customers_email_address'];
            $customer_validation = $check_customer['customers_validation'];
			$customers_group=$check_customer['customers_group'];
            tep_session_register('customer_id');
            
            tep_session_register('customer_default_address_id');
            tep_session_register('customer_default_ship_address_id');
            tep_session_register('customer_first_name');
            tep_session_register('customer_country_id');
            tep_session_register('customer_zone_id');
            tep_session_register('customer_email_address');
            tep_session_register('customer_validation');
			tep_session_register('customers_group');
			
			//��ȡ�û������һ�ε�¼ʱ��
			$lastloginRow = tep_db_fetch_array(tep_db_query('SELECT customers_info_date_of_last_logon  FROM '.TABLE_CUSTOMERS_INFO." WHERE  customers_info_id = ".(int)$customer_id));
			$customer_lastlogin	= trim($lastloginRow['customers_info_date_of_last_logon']); 
			tep_session_register('customer_lastlogin');
			
			setcookie('customer_name',$customer_first_name);
			setcookie('customer_id',$customer_id);
			  //��ס�û��˺�
			setcookie('user_remembered_accountname',$check_customer['customers_email_address'],time() + 3600*24*30*12 );
			/*if(tep_not_null($_POST['remember_me'])){
				 echo "<script>alert('Save cookie ".$check_customer['email_address']."');</script>";
				 setcookie('user_remembered_accountname',$check_customer['customers_email_address'],time() + 3600*24*30*12 );
			}else{
				 setcookie('user_remembered_accountname','',time() - 3600);
			}*/
			//
			
			/* �Զ���¼���� */
			//$WordPressLogin = $WordPress->auto_login_user($email_address, $password);
			//tep_session_register('WordPressLogin');

            // write favorites;
            auto_add_session_to_favorites();

            //howard added need create user for customers if table "user" no this customers.
            if (!get_user_id($customer_id)) {
                $sql_data_array = array();
                $sql_data_array = array('customers_id' => (int) $customer_id,
                    'user_nickname' => $customer_first_name,
                    'user_score_total' => FIRST_LOGIN_SCORE);
                tep_db_perform('user', $sql_data_array);

                //update user_score_history
                update_user_score($customer_id, FIRST_LOGIN_SCORE, FIRST_LOGIN, 'false');
            }
            //��Ա���ֿ� begin
            $is_point_card_user = false ;
            if((int)$customer_id){
            	$member_point_card_rel_query = tep_db_query('SELECT * FROM '. TABLE_POINTCARDS_TO_CUSTOMERS.' WHERE customers_id = '.$customer_id);
				$pointcards_rel_info = tep_db_fetch_array($member_point_card_rel_query);
				if(tep_not_null($pointcards_rel_info)){
					$pointcards_id = $pointcards_rel_info['pointcards_id'];
			      	$pointcards_id_string = format_pointcard($pointcards_id);
			      	tep_session_register('pointcards_id');
			      	tep_session_register('pointcards_id_string');
			      	$is_point_card_user = true ;
			      	//�ӷ�
			      	$lastlogin = tep_db_fetch_array(tep_db_query('SELECT DATE_FORMAT(customers_info_date_of_last_logon,\'%Y%m%d\') AS lastlogin FROM '.TABLE_CUSTOMERS_INFO." WHERE  customers_info_id = ".$customer_id));
			      	//print_r($lastlogin);
			      	if(tep_not_null($lastlogin))
			      		$isfirstlogin = (intval($lastlogin['lastlogin']) < intval(date('Ymd',time())) );
			      	else
			      		$isfirstlogin = true;
			      	
			      	if($isfirstlogin){
			      		tep_add_pending_points_pointcard_login($customer_id);
			      	}
				}
				
            }
            //��Ա���ֿ� end
			//����û��Ƿ��˶������ķ�E�Σ�û�оͰ������� {
			$check_newsletter = tep_db_fetch_array(tep_db_query('SELECT * FROM newsletters_email WHERE newsletters_email_address=\''.$email_address.'\' AND content_id  = 1')); 
			if(empty($check_newsletter)){
				$newsletter_info = array(
					'newsletters_email_address'=>$email_address,
					'newsletter_sent'=>'0',
					'agree_newsletter'=>'1',
					'content_id'=>'1',//���ķ�E��
				);
				tep_db_perform('newsletters_email', $newsletter_info);
			}
			//}
            
            if (!tep_not_null($_COOKIE['every_day_login'])) {
                /* every day login +5 */
                update_user_score($customer_id, EVERY_DAY_LOGIN_SCORE, EVERY_DAY_LOGIN);                
            }
            //howard added need create user for customers if table "user" no this customers. end
            //howard added write login date cookie to local
            //setcookie('LoginDate', date('Ymd'), time() +(3600*24 ));
            setcookie('LoginDate', date('Ymd'));
            //howard added write login date cookie to local end


            //ȡ���û��ǵڼ��ι��������
			$royal_customers_query_raw = tep_db_query("select orders_id from " . TABLE_ORDERS . " o, orders_status s where o.orders_status = s.orders_status_id and s.language_id = '" . (int) $languages_id . "' and o.orders_status='100006' and o.customers_id='" . $customer_id . "' ");

            if (tep_db_num_rows($royal_customers_query_raw) > 0) {
                $total_pur_suc_nos_of_cnt = tep_db_num_rows($royal_customers_query_raw) + 1;
                tep_session_register('total_pur_suc_nos_of_cnt');
            } else {
                $total_pur_suc_nos_of_cnt = 1;
                tep_session_register('total_pur_suc_nos_of_cnt');
            }

			//Howard added to set affiliate session and check if user exits in affiliate table start{
			setSessionAffiliateInfo($customer_id);
			//Howard added to set affiliate session and check if user exits in affiliate table end }

            tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1, last_ip_address='".get_client_ip()."' where customers_info_id = '" . (int) $customer_id . "'");
            tep_db_query("update " . TABLE_CUSTOMERS . " set  customers_char_set = '" . CHARSET . "' where customers_id = '" . (int) $customer_id . "' ");
			
			
// restore cart contents
            $cart->restore_contents();
            if ($ajax == false) {
            	// �������վ����������߱�վ�����������ת���������վ��ҳ
            	if (isset($_SESSION['redirect_ret']) && $_SESSION['redirect_ret'] != '') {
            		$url = explode('/',$_SESSION['redirect_ret']);
            		$fromurl = substr($url[2], strrpos($url[2],'.',-5) + 1);
            		$currentUrl = $_SERVER['SERVER_NAME'];
            		$currentUrl = substr($currentUrl,strrpos($currentUrl,'.',-5) + 1);
            		if ($fromurl != $currentUrl) {
            			$origin_href = tep_href_link('index.php');
            		} else {
            			$url = $_SESSION['redirect_ret'];
            			if (substr($url,-1) == '/'){
            				$domain = $url;
            				$origin_href = $url . '?oscsid=' . session_id();
            			} else {
	            			$index = strrpos($url,'.');
	            			$domain = substr($url,0,$index);
	            			$ext = substr($url,$index);
	            			$origin_href = $domain . '/oscsid--' . session_id() . $ext;
            			}
            			
            		}
            		unset($_SESSION['redirect_ret']);
            		tep_redirect($origin_href);
            		
            	} elseif ($_SESSION['reg_method'] == 'tours-talent-contest'){                               
                    tep_redirect(tep_href_link('tours-talent-contest.php'));
                } else if (sizeof($navigation->snapshot) > 0 && !preg_match('/^email_track/', $navigation->snapshot['page'])) {
					//check_neworder_remaining_seats_edit.phptotal_adult=2&products_id=1555&departure_date=2012-05-16&cPath=25_55NONSSL
					//echo $navigation->snapshot['page'];//, tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode'];
					//exit;
					// ���url�Ǳ༭��ַ�����������ﳵ��by lwkai add 2012-05-10
					if ($navigation->snapshot['page'] == 'check_neworder_remaining_seats_edit.php') {
						$origin_href = tep_href_link('shopping_cart.php','','NONSSL');
						$navigation->clear_snapshot();
					} else {
	                    $origin_href = tep_href_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);
	                   // echo $origin_href.'<br>';
	                    $origin_href = str_replace('index.phppackages/', '', $origin_href);
	                    $navigation->clear_snapshot();
	                    //exit;
					}
                    tep_redirect($origin_href);
                }elseif($_SERVER['HTTP_REFERER']!=''){
	                	$url = parse_url($_SERVER['HTTP_REFERER']);
	                	$url['basename'] = strtolower(basename($url['path'])); 
	                	if(preg_match('/usitrip/i',$url['host'])&&!preg_match('/ajax/', $url['basename'])&& !in_array($url['basename'],array("login.php","logoff.php","create_account.php","password_forgotten.php" ))){
	                		tep_redirect($_SERVER['HTTP_REFERER']);
	                	}else {
		                    tep_redirect(tep_href_link(FILENAME_ACCOUNT, '', 'NONSSL')); //tep_redirect(tep_href_link(FILENAME_DEFAULT, '', 'NONSSL'));
	                	}
                }else{
                          tep_redirect(tep_href_link(FILENAME_ACCOUNT, '', 'NONSSL')); //tep_redirect(tep_href_link(FILENAME_DEFAULT, '', 'NONSSL'));              	
                    }
                }
        }
    }
}


if ($ajax == false) { // if have ajax get no show the code
    if ($error == true) {
        $messageStack->add('login', $error_msn,'error',$error_target.'ErrorMessage');
    }

    $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_LOGIN, '', 'SSL'));

    $validation_include_js = 'true';
	$content = CONTENT_LOGIN;
    $javascript = $content . '.js.php';

	$other_css_base_name = 'login_reg';
	$MAINPAGE_HIDE_date_select_layer = true;
    require_once(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

    require_once(DIR_FS_INCLUDES . 'application_bottom.php');
   // tep_statistics_addpage(tep_current_url('',true).'?version='.USE_OLD_VERSION , $customer_id);//��¼ҳ��������
}
?>
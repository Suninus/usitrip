<?php
class alipay_direct_pay {
	var $code, $title, $description, $enabled, $currency;

	// class constructor
	function alipay_direct_pay() {
		$this->code = 'alipay_direct_pay';
		$this->title = MODULE_PAYMENT_ALIPAY_DIRECT_PAY_TEXT_TITLE;
		$this->sort_order = MODULE_PAYMENT_ALIPAY_DIRECT_PAY_SORT_ORDER;
		$this->description = MODULE_PAYMENT_ALIPAY_DIRECT_PAY_TEXT_DESCRIPTION;
		$this->email_footer = '';
		$this->enabled = MODULE_PAYMENT_ALIPAY_DIRECT_PAY_STATUS;
		$this->currency = MODULE_PAYMENT_ALIPAY_DIRECT_PAY_CURRENCY;

	}
	// class methods
	function javascript_validation() {
		return false;
	}

	function selection() {

		$cc_explain = '
		
		<div>
		<ul>
		<li>
		<img  src="'.MODULE_PAYMENT_ALIPAY_DIRECT_PAY_API_WEB_DIR.'images/alipay.gif" border="0" />
		<img  src="'.MODULE_PAYMENT_ALIPAY_DIRECT_PAY_API_WEB_DIR.'images/veriSign.gif" border="0" />
		</li>
	  
	  <li>
	  <b> ��ʾ��</b>
	  </li>
	  <li>1. ֧�����������֧��������ʹ�����ÿ�����������֧����</li>
		<li>2. USITRIP��֧������֤�������̼�  ʵʱ���ʣ����κ������ѣ�֧����ͨ������Ȩ����ȫ��֤��</li>
		<li>3. ������Ի��ʷ������κ����ʣ�����������ϵ��</li>
	  </ul>
	  </div>';
		$cc_explain = db_to_html($cc_explain);

		$fields[] = array('title' => '', //MODULE_PAYMENT_PAYPAL_TEXT_TITLE,
		'field' => $cc_explain /*.'<div><b>' . $paypal_cc_txt . '</b></div>' .*/  );

		$title_text = $this->title;

		$warm_tips = '<div>'.MODULE_PAYMENT_PAYPAL_TEXT_WARM_TIPS.'</div>';	//��ܰ��ʾ��

		return array('id' => $this->code,
		'module' => $title_text,
		'fields' => $fields,
		'warm_tips' => $warm_tips,
		'currency' => (tep_not_null($this->currency) ? $this->currency : 'CNY'));

	}
	//    function selection() {
	//      return false;
	//    }

	function pre_confirmation_check() {
		return false;
	}


	// I take no credit for this, I just hunted down variables, the actual code was stolen from the 2checkout
	// module.  About 20 minutes of trouble shooting and poof, here it is. -- Thomas Keats
	function confirmation() {
		global $HTTP_POST_VARS;

		$confirmation = array('title' => $this->title . ': ' . $this->check,
		'fields' => array(array('title' => MODULE_PAYMENT_ALIPAY_DIRECT_PAY_TEXT_DESCRIPTION)));

		return $confirmation;
	}

	// Below is the original pre-November snapshot code.  I have left it souly for the less technical minded might
	// be able to compare what some of the more indepth changes consisted of.  Perhaps it will facilitate more preNov
	// Snapshots to being modified to postNov snapshot compatibility -- Thomas Keats

	//    function confirmation() {
	//      $confirmation_string = '          <tr>' . "\n" .
	//                             '            <td class="main">&nbsp;' . MODULE_PAYMENT_ALIPAY_DIRECT_PAY_TEXT_DESCRIPTION . $
	//                             '          </tr>' . "\n";
	//      return $confirmation_string;
	//    }

	function process_button() {
		return false;
	}

	/**
	 * ֧�����̷������ݵ�֧�������������֧������
	 *
	 * @return unknown
	 */
	function before_process() {	//֧������ִ������
		global $order, $order_totals, $insert_id;
		/*
		$outputs = false;
		
		//�������----------------------------------------------------------------------------------------
		$to_charset = 'utf-8';	//���͸�֧����������ʱ���õ��ַ�����
		$out_trade_no = $insert_id.'_'.date('Ymdhis');	//���͵�֧�����Ķ����š�_��֮ǰ�Ƕ����ţ�_����������
		$subject = 'UsiTrip';	//�������ƣ���ʾ��֧��������̨��ġ���Ʒ���ơ����ʾ��֧�����Ľ��׹���ġ���Ʒ���ơ����б��
		$body = '';	//����������������ϸ��������ע����ʾ��֧��������̨��ġ���Ʒ��������
		$total_fee = '';	//�����ܽ���ʾ��֧��������̨��ġ�Ӧ���ܶ��
		foreach ($order_totals as $key => $val){
			if($order_totals[$key]['code']=='ot_total'){
				$total_fee = $order_totals[$key]['value'];
				break;
			}
		}
		$paymethod = '1';	//Ĭ��֧����ʽ��ȡֵ������ʱ���ʽӿڡ������ĵ��е���������б�
		$defaultbank  = '';	//Ĭ���������ţ������б������ʱ���ʽӿڡ������ĵ�����¼�����������б�
		
		//��չ���ܲ�������������----------------------------------------------------------------------------
		$anti_phishing_key  = '';	//������ʱ���
		$exter_invoke_ip = tep_get_ip_address();	//��ȡ�ͻ��˵�IP��ַ�����飺��д��ȡ�ͻ���IP��ַ�ĳ���
		//ע�⣺
		//1.������ѡ���Ƿ��������㹦��
		//2.exter_invoke_ip��anti_phishing_keyһ����ʹ�ù�����ô���Ǿͻ��Ϊ�������
		//3.���������㹦�ܺ󣬷��������������Ա���֧��SSL�������úøû�����
		//ʾ����
		//$exter_invoke_ip = '202.1.1.1';
		//$ali_service_timestamp = new AlipayService($aliapy_config);
		//$anti_phishing_key = $ali_service_timestamp->query_timestamp();//��ȡ������ʱ�������
	
		//�Զ���������ɴ���κ����ݣ���=��&�������ַ��⣩��������ʾ��ҳ����
		$extra_common_param = '';		
		//��չ���ܲ�����������(��Ҫʹ�ã��밴��ע��Ҫ��ĸ�ʽ��ֵ)
		$royalty_type		= "";			//������ͣ���ֵΪ�̶�ֵ��10������Ҫ�޸�
		$royalty_parameters	= "";
		//ע�⣺
		//�����Ϣ��������Ҫ����̻���վ���������̬��ȡÿ�ʽ��׵ĸ������տ��˺š��������������˵�������ֻ������10��
		//����������ܺ���С�ڵ���total_fee
		//�����Ϣ����ʽΪ���տEmail_1^���1^��ע1|�տEmail_2^���2^��ע2
		//ʾ����
		//royalty_type 		= "10"
		//royalty_parameters= "111@126.com^0.01^����עһ|222@126.com^0.01^����ע��"		

		$input_parameter = array(
		"service"			=> "create_direct_pay_by_user",	
		"payment_type"		=> "1",	//֧������
		"partner"			=> trim(MODULE_PAYMENT_ALIPAY_DIRECT_PAY_ID),	//���������id����2088��ͷ��16λ������
		"_input_charset"	=> trim(strtolower($to_charset)),
		"seller_email"		=> trim(MODULE_PAYMENT_ALIPAY_DIRECT_PAY_EMAIL),	//ǩԼ֧�����˺Ż�����֧�����ʻ�
		"return_url"		=> trim(MODULE_PAYMENT_ALIPAY_DIRECT_PAY_RETURN_URL),	//ҳ����תͬ��֪ͨҳ��·��
		"notify_url"		=> trim(MODULE_PAYMENT_ALIPAY_DIRECT_PAY_NOTIFY_URL),	//�������첽֪ͨҳ��·��
		"out_trade_no"		=> $out_trade_no,
		"subject"			=> $subject,
		"body"				=> $body,
		"total_fee"			=> $total_fee,
		"paymethod"			=> $paymethod,
		"defaultbank"		=> $defaultbank,
		"anti_phishing_key"	=> $anti_phishing_key,
		"exter_invoke_ip"	=> $exter_invoke_ip,
		"show_url"			=> trim(MODULE_PAYMENT_ALIPAY_DIRECT_PAY_SHOW_URL),	//��Ʒչʾ��ַ��Ҫ�� http://��ʽ������·�����������?id=123�����Զ������
		"extra_common_param"=> $extra_common_param,
		"royalty_type"		=> $royalty_type,
		"royalty_parameters"=> $royalty_parameters
		);
		$outputs.= tep_draw_form('alipaysubmit','https://mapi.alipay.com/gateway.do?_input_charset='.$to_charset,'get','id="alipaysubmit" ');
		foreach ($input_parameter as $key => $val){
			//echo tep_draw_hidden_field($key, $val);
			//if($val!=''){
				$outputs.=tep_draw_input_field($key, $val);
			//}
		}
		$outputs.= '<button type="submit">submit</button>';
		$outputs.= '</form>';
		//$outputs.= '<script type="text/javascript">document.getElementById("alipaysubmit").submit();</script>';
		return $outputs;
		//echo $outputs;
		*/
		return false;
	}

	function after_process() {
		return false;
	}

	function output_error() {
		return false;
	}

	function check() {
		if (!isset($this->check)) {
			$check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_STATUS'");
			$this->check = tep_db_num_rows($check_query);
		}
		return $this->check;
	}

	function install() {
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('�Ƿ����ô�ģ��', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_STATUS', '1', 'ֻ�������˴�ģ��֮��ǰ̨������ʾ��֧��ģ�顣', '6', '1', 'tep_cfg_select_option_change_display(array(\'1\', \'0\'), ', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('֧�����ӿ�·��', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_API_DIR', '".dirname(__FILE__)."/alipay/create_direct_pay_by_user_php_utf8/', '���֧�����ӿ�·����Ŀ¼·��', '6', '2', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('֧�����ӿ�http·��', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_API_WEB_DIR', '".HTTP_SERVER."/includes/modules/payment/alipay/create_direct_pay_by_user_php_utf8/', '���֧�����ӿ�·����httpĿ¼·��', '6', '2', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('�������', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_SORT_ORDER', '0', '������֧��ģ�����ŵڼ�λ��', '6', '3', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('���������ID', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_ID', '2088102151235921', '���������ID����2088��ͷ��16λ������', '6', '4', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('��ȫ������', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_KEY', 'wtnnm4j45fdmed9ntbqsxy4uk10hh3dl', '��ȫ�����룬�����ֺ���ĸ��ɵ�32λ�ַ�', '6', '5', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('����֧�����ʻ�', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_EMAIL', 'service@usitrip.com', 'ǩԼ֧�����˺Ż�����֧�����ʻ�', '6', '6', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('�첽֪ͨҳ��', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_NOTIFY_URL', '".HTTP_SERVER."/includes/modules/payment/alipay/create_direct_pay_by_user_php_utf8/notify_url.php', '���׹����з�����֪ͨ��ҳ�� Ҫ�� http://��ʽ������·�����������?id=123�����Զ������', '6', '7', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('��������ת��ҳ��', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_RETURN_URL', '".HTTP_SERVER."/includes/modules/payment/alipay/create_direct_pay_by_user_php_utf8/return_url.php', '��������ת��ҳ�� Ҫ�� http://��ʽ������·�����������?id=123�����Զ������', '6', '8', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('��վ��Ʒ��չʾ��ַ', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_SHOW_URL', '".HTTP_SERVER."/account_history.php', '��վ��Ʒ��չʾ��ַ���������?id=123�����Զ������', '6', '9', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('�տ����', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_MAIN_NAME', 'USITrip', '�տ���ƣ��磺��˾���ơ���վ���ơ��տ���������', '6', '10', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('ʹ�õı���', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_CURRENCY', 'CNY', '���յı�����CNY�������', '6', '11', now())");
	}

	function remove() {
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_STATUS'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_API_DIR'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_API_WEB_DIR'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_SORT_ORDER'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_ID'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_KEY'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_EMAIL'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_NOTIFY_URL'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_RETURN_URL'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_SHOW_URL'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_MAIN_NAME'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_CURRENCY'");
	}

	function keys() {
		$keys = array('MODULE_PAYMENT_ALIPAY_DIRECT_PAY_STATUS', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_API_DIR','MODULE_PAYMENT_ALIPAY_DIRECT_PAY_API_WEB_DIR', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_SORT_ORDER', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_ID', 'MODULE_PAYMENT_ALIPAY_DIRECT_PAY_KEY','MODULE_PAYMENT_ALIPAY_DIRECT_PAY_EMAIL','MODULE_PAYMENT_ALIPAY_DIRECT_PAY_NOTIFY_URL','MODULE_PAYMENT_ALIPAY_DIRECT_PAY_RETURN_URL','MODULE_PAYMENT_ALIPAY_DIRECT_PAY_SHOW_URL','MODULE_PAYMENT_ALIPAY_DIRECT_PAY_MAIN_NAME,MODULE_PAYMENT_ALIPAY_DIRECT_PAY_CURRENCY');
		return $keys;
	}
}
?>
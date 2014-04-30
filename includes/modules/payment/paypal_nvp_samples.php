<?php
class paypal_nvp_samples {
	//var $code, $title, $description, $enabled, $currency;

	/**
	 * ����
	 * @var string
	 * @author lwkai 2013-5-13 ����1:26:37
	 */
	public $code = '';
	
	/**
	 * ֧����ʽ��������
	 * @var string
	 * @author lwkai 2013-5-13 ����1:29:07
	 */
	public $title = '';
	
	/**
	 * ֧����ʽ��˵��
	 * @var string
	 * @author lwkai 2013-5-13 ����1:29:55
	 */
	public $description = '';
	
	/**
	 * �Ƿ����ø�֧����ʽ
	 * @var string
	 * @author lwkai 2013-5-13 ����1:31:02
	 */
	public $enabled = '';
	
	/**
	 * ����
	 * @var string
	 * @author lwkai 2013-5-13 ����1:31:57
	 */
	public $currency = '';
	
	/**
	 * ��ֹʹ�ñ�֧����ʽ�Ĳ�ƷID
	 * @var array
	 * @author lwkai 2013-5-13 ����2:40:06
	 */
	public $forbid_ids = array();
	
	// class constructor
	public function __construct() {//paypal_nvp_samples() {
		$this->code = 'paypal_nvp_samples';
		$this->title = MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_TEXT_TITLE;
		$this->sort_order = MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_SORT_ORDER;
		$this->description = MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_TEXT_DESCRIPTION;
		$this->email_footer = MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_TEXT_EMAIL_FOOTER;
		$this->enabled = MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_STATUS;
		$this->currency = MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_CURRENCY;
		$this->forbid_ids = defined('MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_FORBID_IDS') && tep_not_null(MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_FORBID_IDS) ? explode(',',MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_FORBID_IDS) : array();
	}
	// class methods
	function javascript_validation() {
		$js = false;
		/*
		$js = '
			if(document.getElementById("payment_paypal_nvp_samples").checked==true){
				if (document.checkout_payment.firstName.value=="") {
					error_message = error_message + "* ������ֿ�������\n";
					error = 1;
				}
				if (document.checkout_payment.lastName.value=="") {
					error_message = error_message + "* ������ֿ����ա�\n";
					error = 1;
				}
				if (document.checkout_payment.creditCardNumber.value=="") {
					error_message = error_message + "* ���������ÿ����š�\n";
					error = 1;
				}
				if (document.checkout_payment.cvv2Number.value=="") {
					error_message = error_message + "* ���������ÿ�CVV��֤���롣\n";
					error = 1;
				}
				
			}
		';
		$js = db_to_html($js);
		*/
		return $js;
	}
	
	public function selection() {
		/*
		//���ÿ��ֶ���Ϣ
		$card_menu = array();
		$card_menu[]= array('id'=>'Visa','text'=>'Visa');
		$card_menu[]= array('id'=>'MasterCard','text'=>'MasterCard');
		$card_menu[]= array('id'=>'Discover','text'=>'Discover');
		$card_menu[]= array('id'=>'Amex','text'=>'American Express');
		$expires_month = array();
		for($i=1; $i<=12; $i++){
			$m = str_pad($i,2,'0',STR_PAD_LEFT);
			$expires_month[] = array('id'=>$m,'text'=>$m);
		}
		$expires_year = array();
		for($i=date("Y"), $n=date("Y")+5; $i<=$n; $i++){
			$expires_year[] = array('id'=>$i,'text'=>$i);
		}
		$_states = array("AK","AL","AR","AZ","CA","CO","CT","DC","DE","FL","GA","HI","IA","ID","IL","IN","KS","KY","LA","MA","MD","ME","MI","MN","MO","MS","MT","NC","ND","NE","NH","NJ","NM","NV","NY","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VA","VT","WA","WI","WV","WY","AA","AE","AP","AS","FM","GU","MH","MP","PR","PW","VI");
		$states = array();
		$states[] = array('id'=>'X','text'=>'');
		foreach($_states as $key => $val){
			$states[] = array('id'=>$val, 'text'=>$val);
		}
		$_countrycode = array("CN"=>"�й�", "HK"=>"�й����", "TW"=>"�й�̨��", "AF"=>"AFGHANISTAN", "AX"=>"ALANDISLANDS", "AL"=>"ALBANIA", "DZ"=>"ALGERIA", "AS"=>"AMERICANSAMOA", "AD"=>"ANDORRA", "AO"=>"ANGOLA", "AI"=>"ANGUILLA", "AQ"=>"ANTARCTICA", "AG"=>"ANTIGUAANDBARBUDA", "AR"=>"ARGENTINA", "AM"=>"ARMENIA", "AW"=>"ARUBA", "AU"=>"AUSTRALIA", "AT"=>"AUSTRIA", "AZ"=>"AZERBAIJAN", "BS"=>"BAHAMAS", "BH"=>"BAHRAIN", "BD"=>"BANGLADESH", "BB"=>"BARBADOS", "BY"=>"BELARUS", "BE"=>"BELGIUM", "BZ"=>"BELIZE", "BJ"=>"BENIN", "BM"=>"BERMUDA", "BT"=>"BHUTAN", "BO"=>"BOLIVIA", "BA"=>"BOSNIAANDHERZEGOVINA", "BW"=>"BOTSWANA", "BV"=>"BOUVET ISLAND", "BR"=>"BRAZIL", "IO"=>"BRITISH INDIAN OCEAN TERRITORY", "BN"=>"BRUNEI DARUSSALAM", "BG"=>"BULGARIA", "BF"=>"BURKINA FASO", "BI"=>"BURUNDI", "KH"=>"CAMBODIA", "CM"=>"CAMEROON", "CA"=>"CANADA", "CV"=>"CAPE VERDE", "KY"=>"CAYMAN ISLANDS", "CF"=>"CENTRAL AFRICAN REPUBLIC", "TD"=>"CHAD", "CL"=>"CHILE", "CX"=>"CHRISTMAS ISLAND", "CC"=>"COCOS KEELING ISLANDS", "CO"=>"COLOMBIA", "KM"=>"COMOROS", "CG"=>"CONGO", "CD"=>"CONGO, THE DEMOCRATIC REPUBLIC OF THE", "CK"=>"COOK ISLANDS", "CR"=>"COSTA RICA", "CI"=>"COTE DIVOIRE", "HR"=>"CROATIA", "CU"=>"CUBA", "CY"=>"CYPRUS", "CZ"=>"CZECH REPUBLIC", "DK"=>"DENMARK", "DJ"=>"DJIBOUTI", "DM"=>"DOMINICA", "DO"=>"DOMINICAN REPUBLIC", "EC"=>"ECUADOR", "EG"=>"EGYPT", "SV"=>"EL SALVADOR", "GQ"=>"EQUATORIAL GUINEA", "ER"=>"ERITREA", "EE"=>"ESTONIA", "ET"=>"ETHIOPIA", "FK"=>"FALKLAND ISLANDS MALVINAS", "FO"=>"FAROE ISLANDS", "FJ"=>"FIJI", "FI"=>"FINLAND", "FR"=>"FRANCE", "GF"=>"FRENCH GUIANA", "PF"=>"FRENCH POLYNESIA", "TF"=>"FRENCH SOUTHERN TERRITORIES", "GA"=>"GABON", "GM"=>"GAMBIA", "GE"=>"GEORGIA", "DE"=>"GERMANY", "GH"=>"GHANA", "GI"=>"GIBRALTAR", "GR"=>"GREECE", "GL"=>"GREENLAND", "GD"=>"GRENADA", "GP"=>"GUADELOUPE", "GU"=>"GUAM", "GT"=>"GUATEMALA", "GG"=>"GUERNSEY", "GN"=>"GUINEA", "GW"=>"GUINEA-BISSAU", "GY"=>"GUYANA", "HT"=>"HAITI", "HM"=>"HEARD ISLAND AND MCDONALD ISLANDS", "VA"=>"HOLY SEE VATICAN CITY STATE", "HN"=>"HONDURAS", "HU"=>"HUNGARY", "IS"=>"ICELAND", "IN"=>"INDIA", "ID"=>"INDONESIA", "IR"=>"IRAN, ISLAMIC REPUBLIC OF", "IQ"=>"IRAQ", "IE"=>"IRELAND", "IM"=>"ISLE OF MAN", "IL"=>"ISRAEL", "IT"=>"ITALY", "JM"=>"JAMAICA", "JP"=>"JAPAN", "JE"=>"JERSEY", "JO"=>"JORDAN", "KZ"=>"KAZAKHSTAN", "KE"=>"KENYA", "KI"=>"KIRIBATI", "KP"=>"KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF", "KR"=>"KOREA, REPUBLIC OF", "KW"=>"KUWAIT", "KG"=>"KYRGYZSTAN", "LA"=>"LAO PEOPLE'S DEMOCRATIC REPUBLIC", "LV"=>"LATVIA", "LB"=>"LEBANON", "LS"=>"LESOTHO", "LR"=>"LIBERIA", "LY"=>"LIBYAN ARAB JAMAHIRIYA", "LI"=>"LIECHTENSTEIN", "LT"=>"LITHUANIA", "LU"=>"LUXEMBOURG", "MO"=>"MACAO", "MK"=>"MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF", "MG"=>"MADAGASCAR", "MW"=>"MALAWI", "MY"=>"MALAYSIA", "MV"=>"MALDIVES", "ML"=>"MALI", "MT"=>"MALTA", "MH"=>"MARSHALL ISLANDS", "MQ"=>"MARTINIQUE", "MR"=>"MAURITANIA", "MU"=>"MAURITIUS", "YT"=>"MAYOTTE", "MX"=>"MEXICO", "FM"=>"MICRONESIA, FEDERATED STATES OF", "MD"=>"MOLDOVA, REPUBLIC OF", "MC"=>"MONACO", "MN"=>"MONGOLIA", "MS"=>"MONTSERRAT", "MA"=>"MOROCCO", "MZ"=>"MOZAMBIQUE", "MM"=>"MYANMAR", "NA"=>"NAMIBIA", "NR"=>"NAURU", "NP"=>"NEPAL", "NL"=>"NETHERLANDS", "AN"=>"NETHERLANDS ANTILLES", "NC"=>"NEW CALEDONIA", "NZ"=>"NEW ZEALAND", "NI"=>"NICARAGUA", "NE"=>"NIGER", "NG"=>"NIGERIA", "NU"=>"NIUE", "NF"=>"NORFOLK ISLAND", "MP"=>"NORTHERN MARIANA ISLANDS", "NO"=>"NORWAY", "OM"=>"OMAN", "PK"=>"PAKISTAN", "PW"=>"PALAU", "PS"=>"PALESTINIAN TERRITORY, OCCUPIED", "PA"=>"PANAMA", "PG"=>"PAPUA NEW GUINEA", "PY"=>"PARAGUAY", "PE"=>"PERU", "PH"=>"PHILIPPINES", "PN"=>"PITCAIRN", "PL"=>"POLAND", "PT"=>"PORTUGAL", "PR"=>"PUERTO RICO", "QA"=>"QATAR", "RE"=>"REUNION", "RO"=>"ROMANIA", "RU"=>"RUSSIAN FEDERATION", "RW"=>"RWANDA", "SH"=>"SAINT HELENA", "KN"=>"SAINT KITTS AND NEVIS", "LC"=>"SAINT LUCIA", "PM"=>"SAINT PIERRE AND MIQUELON", "VC"=>"SAINT VINCENT AND THE GRENADINES", "WS"=>"SAMOA", "SM"=>"SAN MARINO", "ST"=>"SAO TOME AND PRINCIPE", "SA"=>"SAUDI ARABIA", "SN"=>"SENEGAL", "CS"=>"SERBIA AND MONTENEGRO", "SC"=>"SEYCHELLES", "SL"=>"SIERRA LEONE", "SG"=>"SINGAPORE", "SK"=>"SLOVAKIA", "SI"=>"SLOVENIA", "SB"=>"SOLOMON ISLANDS", "SO"=>"SOMALIA", "ZA"=>"SOUTH AFRICA", "GS"=>"SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS", "ES"=>"SPAIN", "LK"=>"SRI LANKA", "SD"=>"SUDAN", "SR"=>"SURINAME", "SJ"=>"SVALBARD AND JAN MAYEN", "SZ"=>"SWAZILAND", "SE"=>"SWEDEN", "CH"=>"SWITZERLAND", "SY"=>"SYRIAN ARAB REPUBLIC", "TJ"=>"TAJIKISTAN", "TZ"=>"TANZANIA, UNITED REPUBLIC OF", "TH"=>"THAILAND", "TL"=>"TIMOR-LESTE", "TG"=>"TOGO", "TK"=>"TOKELAU", "TO"=>"TONGA", "TT"=>"TRINIDAD AND TOBAGO", "TN"=>"TUNISIA", "TR"=>"TURKEY", "TM"=>"TURKMENISTAN", "TC"=>"TURKS AND CAICOS ISLANDS", "TV"=>"TUVALU", "UG"=>"UGANDA", "UA"=>"UKRAINE", "AE"=>"UNITED ARAB EMIRATES", "GB"=>"UNITED KINGDOM", "US"=>"UNITED STATES", "UM"=>"UNITED STATES MINOR OUTLYING ISLANDS", "UY"=>"URUGUAY", "UZ"=>"UZBEKISTAN", "VU"=>"VANUATU", "VE"=>"VENEZUELA", "VN"=>"VIET NAM", "VG"=>"VIRGIN ISLANDS, BRITISH", "VI"=>"VIRGIN ISLANDS, U.S.", "WF"=>"WALLIS AND FUTUNA", "EH"=>"WESTERN SAHARA", "YE"=>"YEMEN", "ZM"=>"ZAMBIA", "ZW"=>"ZIMBABWE");
		$countrycode = array();
		foreach($_countrycode as $key => $val){
			$_str = ucwords(db_to_html(strtolower($val)));
			$countrycode[] = array('id'=> $key, 'text'=> $_str);
		}
		
		$fields = array(array('title' => db_to_html('���ÿ�����(Card Type)��'),
					'field' => tep_draw_pull_down_menu('creditCardType', $card_menu, '', ' class="required" ')),
						array('title' => db_to_html('�ֿ�����(First Name)��'),
							'field' => tep_draw_input_num_en_field('firstName', '','class="required" size="10" ')),
						array('title' => db_to_html('��(Last Name)��'),
							'field' => tep_draw_input_num_en_field('lastName', '','class="required" size="10" ')), 
						array('title' => db_to_html('���ÿ�����(Card Number)��'),
							'field' => tep_draw_input_field('creditCardNumber','','class="required" size="30" ')),
						array('title' => db_to_html('��Ч����(Expiration Date)��'),
							'field' => tep_draw_pull_down_menu('expDateMonth', $expires_month) . '&nbsp;/&nbsp;' . tep_draw_pull_down_menu('expDateYear', $expires_year)),
						array('title' => db_to_html('CVV��֤����(Card Verification Number)��'),
							'field' => tep_draw_input_field('cvv2Number','','size="4" maxlength="4" class="required" '). ' ' .'<a href="javascript:CVVPopUpWindow(\'' . tep_href_link('cvv.html') . '\')">' .  '(' . MODULE_PAYMENT_AUTHORIZENET_TEXT_CVV_LINK . ')' . '</a>'),
						array('title' => '&nbsp;', 'field' => '&nbsp;'),
						array('title' => db_to_html('<b>Billing Address/�˵���ַ��</b>'),	'field'=> '&nbsp;'),
						array('title' => db_to_html('�ֵ���ַ1(Address 1)��</b>'),	'field'=> tep_draw_input_field('address1','',' size="30" ')),
						array('title' => db_to_html('�ֵ���ַ2(Address 2)��</b>'),	'field'=> tep_draw_input_field('address2','',' size="30" ').db_to_html(' (��ѡ)')),
						array('title' => db_to_html('����(City)��</b>'),	'field'=> tep_draw_input_field('city','',' size="30" ')),
						array('title' => db_to_html('�����ӣ���/ʡ(State)��</b>'),	'field'=> tep_draw_pull_down_menu('state', $states)),
						array('title' => db_to_html('���������ң���/ʡ(State1)��</b>'),	'field'=> tep_draw_input_field('state1','',' size="10" ')),
						array('title' => db_to_html('�ʱ�(Zip)��</b>'),	'field'=> tep_draw_input_num_en_field('zip', '',' size="10" maxlength="10" ').db_to_html('(5��9λ����)')),
						array('title' => db_to_html('����(Country)��</b>'),	'field'=> tep_draw_pull_down_menu('countrycode', $countrycode,'US')),
					);
		*/
		//$fields = '';
		//var_dump($this->_forbid_ids);			
		$selection = array(
			'id' => $this->code,
			'module' => $this->title,
			'fields' => $fields
		);
		//��ܰ��ʾ��
	 	//$selection['warm_tips'] = MODULE_PAYMENT_AUTHORIZENET_TEXT_WARM_TIPS;
	 	$selection['warm_tips'] = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="color: #a7a7a7;">' . "\n" . 
		  '<tr>' . "\n" .
		  '  <td rowspan="8">&nbsp;</td>' . "\n" .
		  '  <td height="22"><font color="#111">���ÿ�����</font><img src="' . MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_WEB_DIR . 'images/pay1.jpg" style=" vertical-align:middle;" />' . 
		  '<br/><b style="color:#ff6600;">��ܰ��ʾ��</b></td>' . "\n" .
		  '</tr>' . "\n" . 
		  '<tr>' . "\n" . 
		  '  <td height="22" style="color:#333;">1�����ǽ���Visa��MasterCard��American Express��Discover��Debit����֧�ֱ���Ϊ��Ԫ<img src="' . MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_WEB_DIR . 'images/pay-usa.jpg" style=" vertical-align:middle;" /></td>' . "\n" . 
		  '</tr>' . "\n" . 
		  '<tr>' . "\n" . 
		  '  <td height="22" style="color:#333;">2������վ�Ѱ�װ<a class="color_orange underline" target="_blank" href="https://seal.godaddy.com/verifySeal?sealID=Sw7SK8bpKlM5UcG9KesPbuhOlyKbqTQ85J99lyGiBVVfZRxR9Qcu">SSL֤��</a>���Ѱ�ȫ��֤��ʵʱ���ˣ����κ������ѣ�</td>' . "\n" .
		  '</tr>' . "\n" . 
		  '<tr>' . "\n" . 
		  '  <td height="22" style="color:#333;">3����ȷ�����ÿ�ʣ�����㹻�������ѣ�����ͨ����֧�����ܡ�</td>' . "\n" . 
		  '</tr>' . "\n" . 
		  '<!--' . "\n" . 
		  '<tr>' . "\n" . 
		  '  <td height="22" style="color:#F00">4.�ʵ���ַ��������ÿ�ʱ��д���ʵ����͵�<br>ַ,�粻�����ֱ���򷢿�����ѯ��.</td>' . "\n" . 
		  '</tr>' . "\n" . 
		  '<tr>' . "\n" . 
		  '  <td height="22">5. ���ÿ�֧������Ϊ<b>��Ԫ</b>��</td>' . "\n" . 
		  '</tr>' . "\n" . 
		  '<tr>' . "\n" . 
		  '  <td height="22">&nbsp;</td>' . "\n" .
		  '</tr>' . "\n" . 
		  '-->' . "\n" . 
		  '</table>';
		$selection['warm_tips'] = db_to_html($selection['warm_tips']);
		$selection['currency'] = (tep_not_null($this->currency) ? $this->currency : 'USD');
		return $selection;

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
		'fields' => array(array('title' => MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_TEXT_DESCRIPTION)));

		return $confirmation;
	}

	// Below is the original pre-November snapshot code.  I have left it souly for the less technical minded might
	// be able to compare what some of the more indepth changes consisted of.  Perhaps it will facilitate more preNov
	// Snapshots to being modified to postNov snapshot compatibility -- Thomas Keats

	//    function confirmation() {
	//      $confirmation_string = '          <tr>' . "\n" .
	//                             '            <td class="main">&nbsp;' . MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_TEXT_DESCRIPTION . $
	//                             '          </tr>' . "\n";
	//      return $confirmation_string;
	//    }

	function process_button() {
		return false;
	}

	function before_process() {
		global $order, $order_totals, $insert_id;
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
			$check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_STATUS'");
			$this->check = tep_db_num_rows($check_query);
		}
		return $this->check;
	}

	function install() {
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('�Ƿ����ô�ģ��', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_STATUS', '1', 'ֻ�������˴�ģ��֮��ǰ̨������ʾ��֧��ģ�顣', '6', '1', 'tep_cfg_select_option_change_display(array(\'1\', \'0\'), ', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Paypla���ÿ��ӿ�·��', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_DIR', '".dirname(__FILE__)."/paypal_nvp_samples/', '���Paypla���ÿ��ӿڵ�Ŀ¼·��', '6', '2', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Paypla���ÿ�http·��', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_WEB_DIR', '".HTTP_SERVER."/includes/modules/payment/paypal_nvp_samples/', '���Paypla���ÿ��ӿڵ�httpĿ¼·��', '6', '2', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('�������', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_SORT_ORDER', '299', '������֧��ģ�����ŵڼ�λ��', '6', '3', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('API_USERNAME', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_USERNAME', 'yug_api1.pbrc.edu', 'API_USERNAME�˺�', '6', '4', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('API_PASSWORD', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_PASSWORD', 'FV852YRKYPCPMEKJ', 'API_PASSWORD����', '6', '5', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('API_SIGNATURE', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_SIGNATURE', 'ArRerOJAp5TWrRjto4AcSV5KyyMAAq3Fnw015BmB-An9PUoRz6bHDr6J', 'API_SIGNATUREǩ��', '6', '6', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('API��nvp��ַ', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_ENDPOINT', 'https://api-3t.paypal.com/nvp', 'Paypal��nvp�ӿڵ�ַ��https://api-3t.paypal.com/nvp', '6', '7', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Paypal���ύ��ַ', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_PAYPAL_URL', 'https://www.paypal.com/webscr', 'Paypal���ύ��ַ������վ�ǣ�https://www.paypal.com/webscr&cmd=_express-checkout&token=������վ�ǣ�https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=', '6', '8', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('����', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_CURRENCY', 'USD', '����', '6', '9', now())");
		tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('ĳЩ�ض��Ĳ�Ʒ������ʹ�ô�֧����ʽ', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_FORBID_IDS', '', '������ʹ�ø�֧����ʽ�Ĳ�ƷID��д������', '6', '10', now())");
	}

	function remove() {
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_STATUS'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_DIR'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_WEB_DIR'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_SORT_ORDER'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_USERNAME'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_PASSWORD'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_SIGNATURE'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_ENDPOINT'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_PAYPAL_URL'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_CURRENCY'");
		tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_FORBID_IDS'");
	}

	function keys() {
		$keys = array('MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_STATUS', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_DIR','MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_WEB_DIR', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_SORT_ORDER', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_USERNAME', 'MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_PASSWORD','MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_SIGNATURE','MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_API_ENDPOINT','MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_PAYPAL_URL','MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_CURRENCY','MODULE_PAYMENT_PAYPAL_NVP_SAMPLES_FORBID_IDS');
		return $keys;
	}
}
?>
<?php
/**
 * �ͷ����۸����� ��¼�ͷ���id���ṩ���ͷ�id�Ĳ�Ʒҳ����ַ���ͷ��� ������$_COOKIE['a']�ǿͷ����ţ����ǿͷ���id��
 */
class servers_sales_track {

	/**
	 * Account���캯��
	 *
	 * @param unknown_type $email
	 * @param unknown_type $telephone
	 * @param unknown_type $password
	 */
	public function __construct($arr = array()) {
		if (is_array($arr) && count($arr) > 0) {
			foreach ($arr as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	/**
	 * ������ͷ�ID��html�����
	 *
	 * @param unknown_type $products_id
	 */
	public function output_url_box($products_id) {
		$string = '';
		if (tep_not_null($_COOKIE['login_id'])) {
			$sql = tep_db_query('SELECT admin_job_number, admin_email_address, admin_firstname, admin_lastname FROM `admin` WHERE admin_id="' . (int) $_COOKIE['login_id'] . '" ');
			$row = tep_db_fetch_array($sql);
			$alert = '���Ƴɹ������Է��������ˣ�';
			$s_url = tep_href_link('product_info.php', 'products_id=' . $products_id . '&a=' . $row['admin_job_number']);
			$string = '<div class="servers_box">
				   <input id="s_url" value="' . $s_url . '" size="100" onclick="this.select(); window.clipboardData.setData(\'text\', this.value); alert(\'' . $alert . '\'); " />
				   <input value="������ַ" type="button" onclick="window.clipboardData.setData(\'text\', document.getElementById(\'s_url\').value);alert(\'' . $alert . '\');" />
				   <input value="GO TO" onclick="window.location.href=\'' . $s_url . '\'" size="5" style="cursor:pointer;"/>
				   <br />				  
				   <span style="color:#000000;">&nbsp;ע�⣺������ȸ������������Լ��ֶ�����(Ctrl+C)��������ӣ�</span><br>';
			// <b>&nbsp;��̨���ţ�'.$row['admin_job_number'].'</b>';//.'&nbsp;&nbsp;&nbsp;&nbsp;����������'.$row['admin_firstname'].$row['admin_lastname'].'&nbsp;&nbsp;&nbsp;&nbsp;�������䣺'.$row['admin_email_address'].'</b>';
			$agent = (int) $_GET['a'];
			if (0 == $agent)
				$agent = (int) $_COOKIE['a'];
			if ($agent != $row['admin_job_number']) {
				if (0 == $agent) {
					$string .= '<div id="flick_agentnumber" style="background-color:#FF0000; color:#FFFFFF; font-size:24px; font-weight:bolder;">&nbsp;����������������Ӽ�¼</div>';
				} else {
					$string .= '<div id="flick_agentnumber" style="background-color:#FF0000; color:#FFFFFF; font-size:24px; font-weight:bolder;">&nbsp;����!   ��ǰ������е��������ӹ�����: ' . $agent . '</div>';
				}
			} else {
				$string .= '<div style="background-color:#FFFFFF; color:#000000; font-size:24px; font-weight:bolder;">&nbsp;��ǰ�������ӹ�����: ' . $agent . '</div>';
			}
			$string .= '<script>setInterval(function(){ jQuery("#flick_agentnumber").fadeOut(100).fadeIn(500); },1000); </script>';
			$string .= '<div class="clear"></div></div>';
		}
		return $string;
	}

	/**
	 * ��¼�ͷ���ID�ŵ����˵������
	 *
	 * @param unknown_type $life_cycle �������� Ĭ��30��
	 */
	public function save_login_id_to_customer_browser($life_cycle = 30) {
		if (tep_not_null($_GET['a'])) {
			setcookie('a', $_GET['a'], time() + (3600 * 24 * $life_cycle), '/', HTTP_COOKIE_DOMAIN);
		}
		return true;
	}

	/**
	 * ��¼�ͷ���ID��������
	 *
	 * @param unknown_type $orders_id
	 */
	public function add_login_id_to_order($orders_id) {
		if (!class_exists('OtherOrders'))
			require 'OtherOrders.class.php';
		$other = new OtherOrders();
		if(!$check_order_owner_have=$other->checkOrdersOwnerHave($orders_id))
			return $check_order_owner_have;
		$orders_owner_commission = 1;
		$login_str = '';
		$orders_owner_admin_id = '';
		if (tep_not_null($_COOKIE['a']) && $orders_owner_admin_id = tep_get_admin_id_from_job_number(trim($_COOKIE['a']))) {
			// $other->changeOwner($orders_id,
			// tep_get_admin_id_from_job_number(( int ) $_COOKIE['a']));
			// $orders_owner_admin_id=tep_get_admin_id_from_job_number($_COOKIE['a']);
			$login_str = (int) $_COOKIE['a'];
			$login_id_need = tep_get_admin_id_from_job_number($login_str);
			if ($login_id_here = $other->checkTrack($orders_id)) {
				$jobs_jobs_id = $other->tep_get_job_number_from_admin_id($login_id_here);
				if ($jobs_jobs_id != $login_str && $jobs_jobs_id) {
					$orders_owner_commission = 0.5;
					$login_str .= ',' . $jobs_jobs_id;
				}
			}
			if (isset($_COOKIE['login_id'])) {
				$other->changeMark($orders_id, 3);
			}
			// tep_db_query('update orders set
			// orders_owner_admin_id="'.tep_get_admin_id_from_job_number((int)$_COOKIE['a']).'",
			// orders_owner_commission="1" where orders_id="'.(int)$orders_id.'"
			// ');
		} else {
			// �����ﴦ����Щû�пͷ��Ķ�����
			if ($login_id_here = $other->checkTrack($orders_id)) {
				$login_id_need = $login_id_here;
				$other->changeOwner($orders_id, $login_id_here);
				$login_str = $other->tep_get_job_number_from_admin_id($login_id_here);
				$other->changeMark($orders_id, 2);
			} else {
				$b_time = strtotime(date('Y-m-d 7:30:00'));
				$e_time = strtotime(date('Y-m-d 17:30:00'));
				$n_time = strtotime(date('Y-m-d H:i:s'));
				if (date('w') == 0 && $n_time > $b_time && $n_time <= $e_time) {
					$other->changeMark($orders_id);
					$login_id_need = $login_str = 19;
					$orders_owner_admin_id = 19;
				} else {
					// �����ﴦ����Щû�пͷ��Ķ�����
					if ($login_id_here = $other->checkTrack($orders_id)) {
						$login_id_need = $login_id_here;
						$other->changeOwner($orders_id, $login_id_here);
						$login_str = $other->tep_get_job_number_from_admin_id($login_id_here);
						$other->changeMark($orders_id, 2);
					} else {
						$jobs_number = $other->getJobsNumber();
						$login_id_need = tep_get_admin_id_from_job_number($jobs_number);
						$other->changeMark($orders_id);
						$other->changeOwner($orders_id, tep_get_admin_id_from_job_number($jobs_number));
						// echo $jobs_number;
						$login_str = $jobs_number;
					}
				}
			}
		}
		$other->changeHaving($orders_id, $login_str, $orders_owner_commission, $orders_owner_admin_id);
		// echo $login_id_need;
		// $_SESSION['tmp_a']=;
// 		$other->changeFrom($orders_id);
		return $login_id_need;
	}

	private function changeOwner($orders_id, $login_id) {
		tep_db_query('update orders set orders_owner_admin_id="' . $login_id . '", orders_owner_commission="1" where orders_id="' . (int) $orders_id . '" ');
	}

	/**
	 * ����������˵��û�id������ѿͷ������˵��û�׬Ǯ
	 * ref=35109&utm_source=35109&utm_medium=af&utm_term=detaillink&affiliate_banner_id=1
	 * ����sofiaҪ������һ�ε����������Щ����
	 */
	public static function clear_ref_info() {
		// global $ref, $affiliate_ref, $affiliate_clickthroughs_id,
		// $utm_source, $utm_medium, $utm_term, $affiliate_banner_id;
		$_array = array (
				'ref',
				'affiliate_ref',
				'affiliate_clickthroughs_id',
				'utm_source',
				'utm_medium',
				'utm_term',
				'affiliate_banner_id' 
		);
		//if (tep_not_null($_COOKIE['a']) || tep_not_null($_COOKIE['login_id'])) {	//ɾ���ͻ��Ϳͷ�������cookie
		if (tep_not_null($_COOKIE['login_id'])) { //ֻɾ���ͷ���Ա������cookie	
			foreach ($_array as $key => $val) {
				unset($GLOBALS[$val]);
				unset($_GET[$val]);
				unset($_POST[$val]);
				// tep_session_unregister($val);
				unset($_SESSION[$val]);
				setcookie($val, NULL, time() - 3600); // ���cookie
			}
		}
	}
}

?>
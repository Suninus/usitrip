<?php
/**
 * ��¼��վ�Ĺ���
 * ��ʱӦ�ã��Ժ�Ҫ���ã�
 * @package 
 */

class login_old{
	/**
	 * ��ǰ��¼���û�ID�ţ����û��¼��ֵС��1
	 */
	var $customer_id;

	function __construct(){
		if((int)$_SESSION['customer_id']){
			$this->customer_id = (int)$_SESSION['customer_id'];
		}
	}
	/**
	 * ��������
	 * �̶���Կ��zhhlwk20*z
	 * ��̬��Կ��2λ����ַ�ֵ
	 * ���ܷ�ʽ:md5
	 * @param $str Ҫ�������ԭʼ�ַ���
	 */
	private function encrypt($str){
		$md5_str = '';
		$static_key = 'zhhlwk20*z';
		$dynamic_key = mt_rand(10,99);
		$md5_str = md5($str.$static_key.$dynamic_key).substr($dynamic_key,0,2);
		return $md5_str;
	}

	/**
	 * �����¼��
	 * @param $action ������index��ȥ��ҳ��ordersList��ȥ�����б�����ȥ�û�������ҳ
	 * @param $submit_button �ύ��ť����
	 * @param $submit_button_class �ύ��ť����ʽ���ƣ�Ĭ��Ϊ�գ�
	 */
	function output_from($action='index', $submit_button = 'ȥ�ɰ�', $submit_button_class = ''){
		$form = '';
		$target_url = 'http://old.usitrip.com/';
		$email = $key = '';
		if((int)$this->customer_id > 0 && (int)$this->customer_id < 60000){
			$target_url = 'http://old.usitrip.com/outer_login.asp';
			$email = tep_get_customers_email($this->customer_id);
			$key = $this->encrypt($email);
			$form = '<form action="'.$target_url.'" method="post" target="_blank">
				<input type="hidden" name="email" value="'.$email.'"/>
				<input type="hidden" name="key" value="'.$key.'" />
				<input type="hidden" name="action" value="'.$action.'"/>
				<input class="'.$submit_button_class.'" type="submit" value="'.$submit_button.'"/>
				</form>
			';
		}elseif($action=='index'){
			$form = '<form action="'.$target_url.'" method="get" target="_blank"><input class="'.$submit_button_class.'" type="submit" value="'.$submit_button.'"/></form>';
		}
		return $form;
	}
	/**
	 * �˳���¼
	 */
	function logoff(){
		$iframe = '';
		if((int)$this->customer_id < 60000){
			$url = 'http://old.usitrip.com/WebOld/logout.asp?notShowJsCode=1';
			$iframe = '<iframe src="'.$url.'" height="1" width="1" style="display:none;" ></iframe>';
		}
		return $iframe;
	}
}
?>
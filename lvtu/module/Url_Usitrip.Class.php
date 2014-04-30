<?php
/**
 * ����Usitrip��վ��URL
 * @author lwkai 2013-4-28 ����11:52:32
 *
 */
class Url_Usitrip {
	
	/**
	 * ��Ŀ��
	 * @var category
	 * @author lwkai 2012-11-20 ����11:31:23
	 */
	private $_category = null;
	
	/**
	 * ���ݿ�������Դ
	 * @var db_mysql
	 * @author lwkai 2012-11-20 ����10:45:36
	 */
	private $_db = null;
	
	public function __construct($db) {
		$this->_db = $db;
		$this->_category = new Category($this->_db);
	}
	
	/**
	 * ������վ����Ҫ��URL����
	 * $var['cpath'] ������������ʾҪ������վ����Ŀ����
	 * $var['pagename'] ��ʾָ��ĳһ��ҳ���ļ�ҳ �����Ҫת�����ļ��У��������Ӧת��������ֱ�Ӵ���ҳ������
	 * @param string $url ��վ����
	 * @param array $var ����
	 * @param array $action URL���ɶ���ָ��
	 * @return string
	 * @author lwkai 2013-3-1 ����11:17:15
	 */
	public function create($url, $var, $action) {
		unset($var['module'],$var['action']);
		if (empty($url) || !preg_match("/^http(s)?:\/\/\w{1}\.\w+\.\w+/", $url)) {
			if ($action['is_ssl'] == true && ENABLE_SSL == true) {
				$url = defined('HTTPS_USITRIPURL') ? HTTPS_USITRIPURL : 'No constant HTTPS_USITRIPURL configuration';
			} else {
				$url = defined('HTTP_USITRIPURL') ? HTTP_USITRIPURL : 'No constant HTTP_USITRIPURL configuration';
			}
		}
		if (isset($var['pagename'])) {
			switch ($var['pagename']) {
				case 'new_travel_companion_index.php' :
					$url .= 'jiebantongyou/';
					unset($var['pagename']);
					$url = $this->addParam($url, $var);
					break;
				default:
					$url .= $var['pagename'];
					unset($var['pagename']);
					$url = $this->addParam($url, $var, false);
			}
		} elseif (isset($var['cpath'])) {
			$rs = $this->_category->get_url((int)$var['cpath']);
			$url .= $rs;
		} elseif (isset($var['product_id'])) {
			$url .= Attractions_Usitrip::getProductUrl($var['product_id']);
			$url .= '.html';
		}
		return $url;
	}
	
	/**
	 * ������վ�Ǳߵķ�ʽ���ɵ�URL����
	 * @param string $url ���ɳ�����URL��ַ
	 * @param array $params ��û��ӽ�������������
	 * @param boolean $seo �Ƿ�����SEO��ʽ�Ĳ������� true �� false Ĭ��?���&
	 * @return string
	 * @author lwkai 2013-3-19 ����3:47:18
	 */
	private function addParam($url,$params,$seo = true){
		if (is_array($params)) {
			if ($seo && $params) {
				foreach($params as $key => $val) {
					$url .= $key . '-' . $val . '-';
				}
				$url = substr($url,0,-1).'.html';
			} elseif ($params) {
				$url .= strpos($url,'?') === false ? '?' : '&';
				foreach($params as $key => $val) {
					$url .= $key . '=' . $val . '&';
				}
				$url = rtrim($url,'&');
			}	
		}
		return $url;
	}
}
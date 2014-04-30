<?php
/**
 * ��վ���������ļ�
 * 
 * �رո�ʽ�����ļ���ִ��
 * @formatter:off
 */

/**
 * ��������ҳ�治��ֱ�ӷ��ʳ���
 * @var boolean
 */
define('IN_TRIP_IMAGE', true);

if ($_SERVER['HTTP_HOST'] == 'test.usitrip.com') {
	/**
	 * ���������վ(������վ)��������ΪTRUE
	 * @var boolean
	 */
	define('IS_LIVE_SITES', false);
	
	/**
	 * ����ǲ���վ,������ΪTRUE
	 * @var boolean
	 */
	define('IS_QA_SITES', true);
	
	/**
	 * ����ǿ���վ��������ΪTRUE
	 * @var boolean
	 */
	define('IS_DEV_SITES', false);
	
	define('CN_HTTP_SERVER', 'http://test.usitrip.com');
	define('CN_HTTPS_SERVER', 'https://test.usitrip.com');
	define('TW_HTTP_SERVER', 'http://test.usitrip.com');
	define('TW_HTTPS_SERVER', 'https://test.usitrip.com');
	define('EN_HTTP_SERVER','');
	define('EN_HTTPS_SERVER','');
	
	/**
	 * ��վ������
	 * @var string
	 * @author lwkai 2013-3-1 ����11:16:16
	 */
	define('HTTP_USITRIPURL','http://test.usitrip.com/');
	define('HTTPS_USITRIPURL','https://test.usitrip.com/');
} else {
	/**
	 * ���������վ(������վ)��������ΪTRUE
	 * @var boolean
	 */
	define('IS_LIVE_SITES', true);
	
	/**
	 * ����ǲ���վ,������ΪTRUE
	 * @var boolean
	*/
	define('IS_QA_SITES', false);
	
	/**
	 * ����ǿ���վ��������ΪTRUE
	 * @var boolean
	*/
	define('IS_DEV_SITES', false);
	
	define('CN_HTTP_SERVER', 'http://www.usitrip.com');
	define('CN_HTTPS_SERVER', 'https://www.usitrip.com');
	define('TW_HTTP_SERVER', 'http://www.usitrip.com');
	define('TW_HTTPS_SERVER', 'https://www.usitrip.com');
	define('EN_HTTP_SERVER','');
	define('EN_HTTPS_SERVER','');
	
	/**
	 * ��վ������
	 * @var string
	 * @author lwkai 2013-3-1 ����11:16:16
	 */
	define('HTTP_USITRIPURL','http://www.usitrip.com/');
	define('HTTPS_USITRIPURL','https://www.usitrip.com/');
}

/**
 * �Ƿ�����SSL
 * @var boolean
 */
define('ENABLE_SSL', true);


define('HTTP_COOKIE_DOMAIN', '.usitrip');
define('HTTPS_COOKIE_DOMAIN', '.usitrip');
/**
 * ϵͳ�ָ���
 * @var string
 */
define('DS', DIRECTORY_SEPARATOR);
/**
 * ��վ��Ŀ¼
 * @var string
 */
define('DIR_FS_ROOT', dirname(dirname(__FILE__)) . DS);

/**
 * ģ������Ŀ¼ module �ļ���
 * @var string
 */
define('DIR_FS_MODULE', DIR_FS_ROOT . 'module' . DS);

/**
 * ����������Ŀ¼ controller �ļ���
 * @var unknown_type
 * @author lwkai 2012-11-23 ����5:46:13
 */
define('DIR_FS_CONTROLLER', DIR_FS_ROOT . 'controller' . DS);

/**
 * �����ļ�����λ��
 * @var string
 * @author lwkai 2012-12-27 ����3:22:11
 */
define('DIR_FS_LANGUAGE', DIR_FS_ROOT . 'public' . DS . 'languages' . DS);

/**
 * ���ݿ������ļ�λ��
 * @var string
 */
define('DIR_FS_DATABASE',DIR_FS_ROOT . 'public' . DS . 'Datebase.php');

/**
 * ���ݿ��Ƿ���ó־�����
 * @var boolean
 */
define('DB_LASTING',false);

/**
 * SQL�Ƿ����û���
 * @var boolean
 */
define('ENABLE_SQL_CACHE', true);

/**
 * ���ܻ�������ݱ�����
 * @var string
 */
define('NO_CACHE_TABLES','sessions,sql_query_logs');

/**
 * ����session�ķ�ʽ��������浽���ݿ������Ϊmysql��������浽�ļ��о����ÿ�ֵ��ע���ֵҪ����վ����ͬ����ֵҪ����һ�£�
 * @var string
 */
define('STORE_SESSIONS', '');

/**
 * ������ļ��еķ�ʽ����session�������������ļ��еı���λ�á�ע���ֵҪ����վ����ͬ����ֵҪ����һ�£�
 * @var string
 */
define('SESSION_WRITE_DIRECTORY', '/tmp/usitrip.session');

/**
 * �Ƿ�����html��̬ҳ��
 * @var int
 * @author lwkai 2012-11-20 ����9:56:46
 */
define('IS_CREATE_HTML',0);

/**
 * SEO��ҳ����չ���������ɵ��ļ���չ��
 * @var string
 * @author lwkai 2012-11-20 ����9:57:46
 */
define('SEO_EXTENSION','.html');

/**
 * SEO��GET������ҳ��ķָ�����Ҫ��һЩ�ļ��������Ͳ���ֵ�в����׳��ֵ��ַ���������һ��-��Ҳ���Ƽ��á�\/:*"<>|������Ϊ�޷������ļ���������Щ���ŵľ�̬ҳ�棡����+�š�
 * ��URL�����ָ���
 * @var string
 * @author lwkai 2012-11-20 ����10:10:01
 */
define('SEO_EXTENSION_SEPARATOR','--');

/**
 * SMARTY����Ŀ¼
 * @var string
 */
define('DIR_FS_SMARTY', DIR_FS_ROOT . 'smarty' . DS);

/**
 * �Ƿ�򿪵���
 * @var boolean
 */
define('DEBUG', false);

/**
 * ҳ���ó�����WEB��Ŀ¼
 * @var string
 * @author lwkai 2012-12-25 ����10:10:16
 */
define('DIR_WS_ROOT', '/lvtu/');



?>
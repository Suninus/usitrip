<?php
/**
 * ���ݿ�������
 * @author lwkai
 * @date 2012-11-25 ����3:30:37
 * @link <1275124829@163.com>lwkai
 * @formatter:off
 */
class Db {
	/**
	 * �����Ѿ��򿪵����ݿ�����
	 * @var Array ���洴�������ݿ����Ӷ���
	 */
	private static $_db = array();
	
	private function __construct() {
		//˽�й��캯����������ֱ��NEW
	}
	
	/**
	 * ��ʼ�����ݿ����ӣ�ʹ�ô��࣬����ֱ��new�����ǵ��˾�̬����
	 * @param string $dbname Ҫ���ӵ����ݿ����������KEY��
	 * @return database object
	 */
	public static function get_db($dbname = 'trip_image', $type = 'MySQL') {
		$type = ucfirst(strtolower($type));
		if (empty(self::$_db[$dbname . $type])) {
			$class = 'Db_' . $type;
            $pdo_handle = new $class($dbname);
            self::$_db[$dbname . $type] = $pdo_handle;
        }
        return self::$_db[$dbname . $type];
	}
	
}
?>
<?php
/**
 * ϲ�������� ������Ҫ��������Ҫ����
 * @package Like
 * @author lwkai by 2013-04-01 17:32
 */
class Like_Factory {
	
	/**
	 * ���ݲ��������������
	 * @param string $name ��Ҫ���������ļ���
	 */
	static public function getLike($name) {
		$class_name = 'Like_' . ucfirst($name);
		return new $class_name();
	}
}
?>
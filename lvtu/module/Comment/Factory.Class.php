<?php
/**
 * ���۹����� ������Ҫ��������Ҫ����
 * @package Comment
 * @author lwkai by 2013-04-02 17:47
 */
class Comment_Factory {
	
	/**
	 * ���ݲ����������ǵ���
	 * @param string $name ��Ҫ���������ļ���
	 */
	static public function getComment($name) {
		$class_name = 'Comment_' . ucfirst($name);
		return new $class_name();
	}
}
?>
<?php
/**
 * ��������ת��������ת����ʱ����Щ�������ֲ���ת������Ԥ��������
 * @author lwkai
 * @date 2012-11-15 ����1:33:35
 * @link <1275124829@163.com>lwkai
 * @formatter:off
 */
class Rare_Convert {
	
	/**
	 * BIG5�������������
	 * @var array
	 * @author lwkai
	 * @date 2012-11-15 ����1:32:50
	 */
	private static $_text_big5 = array();
	
	/**
	 * GB2312��������
	 * @var array
	 * @author lwkai 2012-11-15 ����4:10:49
	 */
	private static $_text_gb2312 = array();

	/**
	 * ��������ת��������ʱ��Ԥ�ȴ�����Щ�����ܹ�ICONVת��������
	 * @param string $str ��Ҫת�����ַ���
	 * @return string
	 * @author lwkai 2012-11-19 ����11:07:18
	 */
	public static function big5_to_gb2312($str) {
		if ( $str == '' ) {
			return $str;
		}
		if (!self::$_text_big5) {
			self::$_text_big5 = require('Rare_Big5.php');
		}
		foreach (self::$_text_big5 as $key => $val) {
			$str = str_replace($val, '&#'.$key.';', $str);
		}
		return $str;
	}
	
	/**
	 * ��������ת��������ʱ��Ԥ�ȴ�����Щ�����ܹ�ICONVת��������
	 * @param string $str ��Ҫ������ַ���
	 * @return string
	 * @author lwkai 2012-11-19 ����11:11:11
	 */
	public static function gb2312_to_big5($str) {
		if (!$str) {
			return '';
		}
		if (!self::$_text_gb2312) {
			self::$_text_gb2312 = require('Rare_Gb2312.php');
		}
		foreach (self::$_text_gb2312 as $key => $val) {
			$str = str_replace($val, '&#'.$key.';', $str);
		}
		return $str;
	}
	
}


?>
<?php
/**
 * һЩ���õ�ת��
 * @author lwkai
 * @date 2012-11-9 ����4:48:53
 * @link <1275124829@163.com>lwkai
 * @formatter:off
 */
class Convert {
	
	/**
	 * �Ե����ź�˫���Ž���ת�塣
	 * �����ţ�'����˫���ţ�"������б�ߣ�\���� NUL��NULL �ַ����� 
	 * @param string $string
	 * @return string
	 */
	private static function _escape($string) {
		if(!get_magic_quotes_gpc()){
			$string = addslashes($string);
		}
		return $string;
	}
	
	/**
	 * �Ե����ź�˫���Ž���ת�塣
	 * �����ţ�'����˫���ţ�"������б�ߣ�\���� NUL��NULL �ַ����� 
	 * @param string|array $string ��Ҫת��Ķ����ַ�����������
	 * @return string|array
	 */
	public static function escape($string) {
		if (is_string($string) == true) {
			$string = self::_escape($string);
		} elseif (is_array($string) == true) {
			foreach ($string as $key => $val) {
				$string[$key] = self::escape($val);
			}
		}
	}
	
	/**
	 * �����ݽ��и�ʽ�����Ա�д�����ݿ� ע�� ��֧������
	 * @param string $string Ҫ������ַ�������
	 * @return string
	 * @author lwkai 2013-2-28 ����4:17:36
	 */
	public static function db_input($string){
		if (function_exists('mysql_real_escape_string')) {
			return mysql_real_escape_string($string);
		} elseif (function_exists('mysql_escape_string')) {
			return mysql_escape_string($string);
		} else {
			return self::escape($string);
		}	
	}
	
	/**
	 * �Ե����ź�˫���Ž��з�ת�塣
	 * �����ţ�'����˫���ţ�"������б�ߣ�\���� NUL��NULL �ַ�����
	 * @param string $string
	 * @return string
	 */
	private static function _unescape($string) {
		$string = str_replace("\\\"", "\"", $string);
		$string = str_replace("\\'", "'", $string);
		if (preg_match("/\\\\/",$string)) {
			$string = str_replace("\\\\", "\\", $string);
		}
		return $string;
	}
	
	/**
	 * �Ե����ź�˫���Ž��з�ת�塣
	 * �����ţ�'����˫���ţ�"������б�ߣ�\���� NUL��NULL �ַ�����
	 * @param string|Array $string
	 * @return string|Array
	 */
	public static function unescape($string) {
		if (is_string($string)) {
			$string = trim(self::_unescape($string));
		} elseif (is_array($string)) {
			foreach ($string as $key => $value) {
				$string[$key] = self::unescape($value);
			}
		}
		return $string;
	}
	
	/**
	 * ��HTML�����ַ�ת���ɱ�׼��HTML���롣
	 * & => &amp;   (&amp;amp;)  
	 * " => &quot;  (&amp;quot;) 
	 * ' => ' 
	 * < => &lt;    (&amp;lt;)��
	 * > => &gt;    (&amp;gt;) 
	 * @param string $string
	 * @return string|array
	 */
	private static function _special_chars_html($string) {
		return preg_replace("/&amp;/", "&", htmlspecialchars($string,ENT_QUOTES));
	}
	
	/**
	 * ��HTML�����ַ�ת���ɱ�׼��HTML���롣
	 * & => &amp;   (&amp;amp;)
	 * " => &quot;  (&amp;quot;)
	 * ' => '
	 * < => &lt;    (&amp;lt;)��
	 * > => &gt;    (&amp;gt;)
	 * @param string|array $string ��Ҫת���Ķ����ַ�����������
	 * @return string|array
	 */
	public static function special_chars_html($string) {
		if (is_string($string) == true) {
			$string = self::_special_chars_html($string);
		} elseif (is_array($string) == true) {
			foreach ($string as $key => $val) {
				$string[$key] = self::_special_chars_html($val);
			}
		}
		return $string;
	}
	
	/**
	 * ������ת����GB2312�ı���
	 * @param string|array $string ��Ҫת���Ķ����ַ��������ַ�������
	 * @return string|array
	 * @author lwkai 2012-11-19 ����11:22:19
	 */
	public static function html_to_db($string, $charset) {
		if ($charset == 'big5') {
			if (is_array($string) == true) {
				foreach ($string as $key => $val) {
					$string[$key] = self::html_to_db($val, $charset);
				}
			} elseif (is_string($string) == true) {
				$string = self::_html_to_db($string, $charset);
			}
		}
		return $string;
	}
	
	/**
	 * ת���ַ���ΪGB2312����
	 * @param string $string ��Ҫת�����ַ���
	 * @return string
	 * @author lwkai 2012-11-19 ����11:23:28
	 */
	private static function _html_to_db($string, $charset) {
		if ($charset == 'big5') {
			$string = rare_convert::big5_to_gb2312($string);
			$arr = array('��' => "��\\", '��' => "��\\", '��' => "��\\", '��' => "��\\", '��' => "��\\", '��' => "��\\", '��' => "��\\", '�' => "�\\");
			foreach ($arr as $key => $val) {
				$string = str_replace($val, $key, $string);
			}
			$string = iconv($charset,'gb2312//IGNORE',$string);
		}
		return $string;
	}

	/**
	 * ����ת����
	 * @param string|array $string ��Ҫת���Ķ����ַ��������ַ�������
	 * @param string $charset ��ǰҳ��ı���
	 * @return string|array
	 * @author lwkai 2012-11-19 ����11:45:34
	 */
	public static function db_to_html($string,$charset) {
		if ($charset != 'gb2312') {
			if (is_array($string) == true) {
				foreach ($string  as $key => $val) {
					$string[$key] = self::db_to_html($val,$charset);
				}
			} elseif (is_string($string) == true) {
				$string = Rare_Convert::gb2312_to_big5($string);
				$string = iconv('gb2312',$charset . '//IGNORE',$string);
			}
		}
		return $string;
	}
	
	/**
	 * ȥ���ַ�����β�ո�,Ȼ���ַ����еĶ���ո���һ���ո����, '<' ���� '>' ������ '_' ���
	 * @param string $string
	 * @return string
	 * @author lwkai 2012-12-26 ����1:36:45
	 */
	public static function sanitize_string($string) {
		$patterns = array ('/ +/','/[<>]/');
		$replace = array (' ', '_');
		return preg_replace($patterns, $replace, trim($string));
	}
	
	/**
	 *  ���������Ϊ�ַ�������ֵΪ�ַ���������ʱ,ȥ�� �ַ��� �� �����е�ֵ ����β�ո�,Ȼ���ַ����еĶ���ո���һ���ո����, '<' ���� '>' ������ '_' ���
	 * ��������ַ�������ֵ�����ַ���������ʱ, ��������
	 * @param string|array $string
	 * @return string
	 * @author lwkai 2012-12-26 ����1:37:57
	 */
	public static function db_prepare_input($string) {
		if (is_string($string)) {
			return trim(self::sanitize_string(stripslashes($string)));
		} elseif (is_array($string)) {
			foreach ($string as $key => $value) {
				//�ݹ�����Լ�
				$string[$key] = self::db_prepare_input($value);
			}
			return $string;
		} else {
			return $string;
		}
	}
	
	/**
	 * �ݹ�ת���ֱ���
	 * @param string $inCharset ��ǰ���ֱ���
	 * @param string $toCharset ת��������ֱ���
	 * @param string|array $str ת���Ķ���
	 * @return array|string
	 * @author lwkai 2013-2-27 ����2:33:39
	 */
	public static function iconv($inCharset,$toCharset,$str) {
		if (is_array($str) || is_object($str)) {
			foreach( $str as $key => $val) {
				$str[$key] = self::iconv($inCharset, $toCharset, $val);
			}
			return $str;
		} else {
			return iconv($inCharset,$toCharset . '//IGNORE',$str);
		} 
	}
	
	/**
	 * XMLת������
	 * @param string|object $xml XML�ַ������� XML����
	 * @param boolean $recursive ��������$xml����ֵ�����string����,��˲���ӦΪtrue
	 * @return array 
	 * @author lwkai 2013-2-27 ����6:10:11
	 */
	public static function XML2Array($xml, $recursive = false) {
		if (!$recursive) {
			$obj = simplexml_load_string($xml);
		} else 	{
			$obj = $xml;
		}
		$_arr = is_object($obj) ? get_object_vars($obj) : $obj;
		$arr = array();
		foreach ($_arr as $key => $val)
		{
			$val = (is_array($val) || is_object($val)) ? self::XML2Array($val,true) : $val;
			$arr[$key] = $val;
		}
		return $arr;
	}
}
?>
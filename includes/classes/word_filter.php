<?php
/**
 * �ļ��� ��ȡ�ļ����� �������ݵ��ļ�
 * @author lwkai 2012-4-15 <1275124829@163.com>
 * @version 1.0
 */
class read_file {
	/**
	 * ��Ҫ��ȡ���ļ�
	 *
	 * @var string|array
	 */
	protected  $_files = null;
	
	/**
	 * �����ȡ���ļ����ݣ����ߴ�д�������
	 * �����ȡ�������飬�������Ϊ����
	 * д��ʱ��ֻ�����ַ���
	 *
	 * @var string|array
	 */
	protected $_string = '';
	
	/**
	 * ���캯�� ��ʼ������ʱ �ɴ�����Ҫ��ȡ���ļ�
	 *
	 * @param array|string $file
	 */
	public function __construct($file = array()) {
		$this->setFiles($file);
	}
	
	/**
	 * ������Ҫ��ȡ���ļ�
	 *
	 * @param string|array $file
	 */
	public function setFiles($file = array()) {
		if (is_array($file)) {
			foreach ($file as $key => $val) {
				if (is_string($val)) {
					$this->_files[$key] = $val;
				}
			}
		} elseif (is_string($file)) {
			$this->_files = $file;
		}
	}
	
	/**
	 * ��һ���ļ�����ȡ����,���������ȷ��ȡ,�򷵻�true �����׳��쳣��
	 * 
	 *
	 * @param string $keyName ��Ҫ�򿪵��ļ���,�����ʼ��ʱ�����������,������Ҫ��ȡ���������,���
	 * @return boolean 
	 */
	private function open($keyName){
		if (file_exists($keyName)) {
			$file = $keyName;
		} elseif (isset($this->_files[$keyName])) {
			$file = $this->_files[$keyName];
		} elseif (is_string($this->_files) && file_exists($this->_files)) {
			$file = $this->_files;
		}
		if (!file_exists($file)) {
			throw new Exception('[' . $file . ']�ļ�������!');
		}
		$this->_string = file($file);
		return true;
		
	}
	
	/**
	 * ��ȡһ���ļ�,����ָ���� array ���� string
	 *
	 * @param string $file �ļ����߳�ʼ��ʱ������������KEYֵ
	 * @param array $type ���ص���������
	 */
	public function read($file,$type = 'string') {
		$this->open($file);
		return $this->_string;
	}
	
	/**
	 * ��ָ�����ַ���д���ļ�
	 *
	 * @param string $fileName д����ļ���[����·��]
	 * @param string $mode д�뷽ʽ a w �ȵ�
	 * @return boolean �ɹ������� �����׳��쳣
	 */
	public function write($fileName = '', $mode = 'a') {
		// ����ļ����ڲ��Ҳ���д 
		if (file_exists($fileName) && !is_writable($fileName)) {
			throw new Exception('�ļ�����,������д!');
		}
		if (!$handle = fopen($fileName,$mode)) {
			throw new Exception('���ܴ��ļ�[' . $fileName . ']');
		}
		if (fwrite($handle,$this->_string) == false) {
			throw new Exception('����д���ļ���[' . $fileName . ']');
		}
		fclose($handle);
		return true;
	}
}


if(!function_exists('mb_string_to_array')){
function mb_string_to_array($str,$charset) {
    $strlen = mb_strlen($str);
    while($strlen){
        $array[] = mb_substr($str,0,1,$charset);
        $str = mb_substr($str,1,$strlen,$charset);
        $strlen = mb_strlen($str);
    }
    return $array;
}
}
//$arr = mb_string_to_array($str,"gb2312");

/**
 * ��ʽ�����дʻ㣬���ɴʻ���
 * @author lwkai 2012-4-15 <1275124829@163.com>
 * @version 1.0
 */
class format extends read_file {
	
	/**
	 * �ʻ��� ��Ԫ����
	 *
	 * @var array
	 */
	public $_tree = array();
	
	/**
	 * ���캯�� �����ȴ���Ҫ��ȡ���ļ�
	 *
	 * @param string|array $file
	 */
	public function __construct($file = array()) {
		parent::__construct($file);
	}
	
	/**
	 * �жϵ�ǰ�ʻ����Ƿ��Ѿ���������ǰ�Ѿ�����Ĵʻ�����
	 * 
	 * �жϵ�ǰ�ʻ����Ƿ��Ѿ���������ǰ�Ѿ�����Ĵʻ����У���������򷵻�true�����򷵻�false
	 * @param array $arr1
	 * @param array $arr2
	 * @return boolean
	 */
	private function array_intersect($arr1=array(),$arr2=array()) {
		foreach ($arr1 as $key => $val) {
			if (is_array($val) && isset($arr2[$key])) {
				 return $this->array_intersect($val,$arr2[$key]);
			} elseif (!is_array($val) && isset($arr2[$key])) {
				return true;
			} else {
				return false;
			}
		}
	}
	/**
	 * �����ĵȺ��滻��Ӣ�ĵȺ�,����ȥ�����з�
	 *
	 * @param string $str
	 * @return string
	 */
	private function replaceEquals($str) {
		if (is_string($str)) {
			$str = preg_replace("/��/",'=',$str);
			$str = preg_replace("/\r|\n/",'',$str);
		}
		return $str;
	}
	
	/**
	 * �˺���(����)���ļ��е����� ת�� �ʻ�����
	 *
	 * @param string $file
	 */
	public function read($file=''){
		// ��ȡ�ļ�����������  [�����е�ÿ����Ԫ�����ļ�����Ӧ��һ��]
		$string = parent::read($file);
		$exit = false;
		if (is_array($string)) {
			foreach ($string as $key => $val) {
				$val = $this->replaceEquals($val);
				$arr = explode('=',$val);
				$temp = mb_string_to_array($arr[0],'gb2312');
				$arr_temp = array();
				for($i = $len = count($temp) - 1; $i >= 0; $i--) {
					if ($i == $len) {
						$arr_temp = array($temp[$i]=>array('text'=>$arr[1],'end' => true));
					} else {
						$arr_temp = array($temp[$i] => $arr_temp);
					}
				}
				// ȥ���ظ��Ĵ�
				if (!$this->array_intersect($arr_temp,$this->_tree)) {
					$this->_tree = array_merge_recursive($this->_tree,$arr_temp);
				} 
			}
		}
	}
	
	/**
	 * ��ȡ�����Ѿ����õ��ļ�����ת���ɴʻ���
	 *
	 */
	public function readAll(){
		set_time_limit(0);
		if (is_array($this->_files)) {
			foreach ($this->_files as $key => $val) {
				$this->read($val);
			}
		} else {
			$this->read($this->_files);
		}
	}
	
	/**
	 * ����ʻ���Ϊ�ļ�[php�ļ�]
	 *
	 * @param string $filePath ������ļ���
	 */
	public function write($filePath) {
		$str = var_export($this->_tree, true);
		$this->_string = '<?php' . "\nreturn " . $str . '?>';
		// var_export �ѱ�����PHP��׼���ַ�������, �ڶ�������Ϊ true �Ƿ���������� 
		parent::write($filePath,'w');
	}
}

/**
 * �ַ��������࣬���˷Ƿ��ؼ��ʣ������������վ�ϡ�
 * @author lwkai
 *
 */
class stringFilter{
	/**
	 * ת���ʻ����Ķ���
	 * @var Ojbect
	 */
	private $_format = null;
	/**
	 * �п����û��ڷǷ����м�����ַ�
	 *
	 * @var array
	 */
	private $_detection = array('*','#','@','��','!','$','%','^',' ','&','-','+','/','_');
	
	public function __construct($file = array()){
		if(!tep_not_null($file)){
			$file = DIR_FS_CATALOG.'txt'. DIRECTORY_SEPARATOR . 'MinGanCi_0523.txt';
		}
		$this->_format = new format($file);
		if (!file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'word_filter_array.php')) {
			$this->_format->readAll();
			$this->_format->write(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'word_filter_array.php');
		} else {
			$this->_format->_tree = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'word_filter_array.php');
		}
	}
	
	/**
	 * �Ƿ����û����ӵĴ�,���򷵻�true �񷵻�flase
	 *
	 * @param string $str
	 * @return boolean
	 */
	private function isDetection($str) {
		return !in_array($str,$this->_detection);
	}

	/**
	 * �滻���д�Ϊ�趨������
	 *
	 * @param string $word
	 * @param array $arr
	 * @return string
	 */
	private function replaceWord($word,$arr){
		foreach ($arr as $key => $val) {
			$word = str_replace($key,$val,$word);
		}
		return $word;
	}
	
	/**
	 * ���ַ������й��ǣ�ȥ�� ���� �滻���дʻ�
	 *
	 * @param string $word
	 * @return string 
	 */
	public function checkString($word,$charset = 'gb2312'){
		if (empty($word)) {
			return '';
		}
		$other=array('2655031585','2208222906','1852913829','255745376','8983881','92823258');
		$word=str_replace($other,'282972788', $word);
		// ���������Ż���
		$affiliate_filter = new couponCodeFilter();
		$word = $affiliate_filter->checkString($word);
		$temp = mb_string_to_array($word,$charset);
		$tempArr = $this->_format->_tree;
		$replaceArr = array();
		$keyString = '';
		foreach ($temp as $key => $val) {
			//echo '�������� [' . $val . ']<br/>';
			$keyString .= $val;
			// ������ַ��ǲ���Ҫ���� ������
			//var_dump(in_array($val,$this->_detection));
			if (!$this->isDetection($val)) {
				//echo '����Ҫ���ģ�����<br/>';
				continue;
			} 
			
			if (!isset($tempArr[$val])) { // �������ַ��������ǵ����дʻ����У�ִ����һ���ֵ��ж�
				//echo '���ڵ�ǰ�ʻ����У�<br/>';
				if ($keyNext == true) {
					//echo '֮ǰ��һ�����Ѿ�ƥ�䣬���ڼ�¼<br/>';
					$replaceArr[$name] = $text;
					$keyNext = false;
				}
				if (!isset($this->_format->_tree[$val])) {
					//echo 'Ҳ���ڶ����ʻ�������,��ʻ���ָ�뻹ԭ!<br/>';
					$tempArr = $this->_format->_tree;
					$keyString = '';	
				} else {
					//echo '���ڶ����ʻ����д���!ָ��ָ�����λ��<br/>';
					$tempArr = $this->_format->_tree[$val];
					$keyString = $val;
				}
				$keyNext = false;
				continue;
			}
			
			#echo '�������ʴ��ڣ����ҵ���һ����ʵĽ����������Ѿ�û�б�����ٳ��Ĵ�<br/>';
			if($tempArr[$val]['end'] == true && count($tempArr[$val]) == 2) {
				//echo '��¼�´˴�<br/>';
				$replaceArr[$keyString] = $tempArr[$val]['text'];
				$keyString = '';
				//echo '��ԭ�ʻ�ָ�뵽ͷ��<br/>';
				$tempArr = $this->_format->_tree;
				$keyNext = false;
				continue;
			} elseif ($tempArr[$val]['end'] == true && count($tempArr[$val] > 2)) {
				//echo '���и����Ĵ�.��¼״̬.NEXT<br/>';
				$keyNext = true;
				$name = $keyString;
				$text = $tempArr[$val]['text'];
			}
			
			//echo '�ƶ�����ָ�뵽[' . $val . ']<br/>';
			$tempArr = $tempArr[$val];
		}
		// ���ѭ�����ˣ�����û�м�¼�Ĵʣ������ӵ���¼����
		if ($keyNext == true) {
			$replaceArr[$name] = $text;
		}
		//print_r($replaceArr);
		// �滻���ҵ��Ĵ�
		$word = $this->replaceWord($word,$replaceArr);
		// ��{MOD}�滻��*��
		$_array = array('{MOD}'=>'*', '{BANNED}'=>'*');
		$word = strtr($word, $_array);
		return $word;
	}
}

/**
 * ���������ƹ��Ż���
 * @author lwkai 2013-08-02
 *
 */
class couponCodeFilter{
	
	/**
	 * �����ı��е����б�վ���Ż���
	 * @param unknown_type $word
	 */
	public function checkString($word){
		if (!$word) return '';
		$str_arr = preg_split("/[^a-zA-Z0-9\\-\\$\\&]+/", $word);
		$str_arr = $this->filterArray($str_arr);
		$rpl_arr = $this->databaseCheck($str_arr);
		$rtn = str_replace($rpl_arr, '*****', $word);
		return $rtn;
	}
	
	/**
	 * ���˵�������һЩ����Ҫ�˶Ե�������Ϣ
	 * @param array $arr �ַ����ָ�������
	 * @return array ���ع��˺������
	 */
	public function filterArray($arr){
		if(!function_exists('mycallback')){
			function mycallback($a){
				if (!$a) { //Ϊ�ջ���0����false null ��ȥ��
					return false;
				}
				if (preg_match('/(^\-+$)|(^\d+$)/', $a)) { // ȫ��-��ȥ�� ȫ�����ֵ�ȥ��
					return false;
				}
				if (strlen($a) < 6){ //����С��6��ȥ��
					return false;
				}
				return true;
			};
		}
		$arr = array_filter($arr,'mycallback');
		return $arr;
	}
	
	/**
	 * �����ݿ��е����˱��е����ݽ��жԱȣ��ҳ������г��ֵ��Ż��룬�������ҵ����Ż���
	 * @param array $arr ��Ҫ�����ݿ��е������Ż���˶Ե���������
	 * @return array �����ҵ��Ĵ��ڵ��Ż���
	 */
	private function databaseCheck($arr) {
		$arr = is_array($arr) ? $arr : array($arr);
		$rtn = array();
		foreach ($arr as $key => $val) {
			$sql = "select count(affiliate_id) as t from affiliate_affiliate where affiliate_coupon_code='" . tep_db_input($val) . "'";
			$result = tep_db_query($sql);
			$rs = tep_db_fetch_array($result);
			if ($rs['t'] > 0){
				$rtn[] = $val;
			}
		}
		return $rtn;
	}
}
?>
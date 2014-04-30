<?php
/**
 * ���ݿ�������
 * @author lwkai
 * @date 2012-11-9 ����4:49:37
 * @link <1275124829@163.com>lwkai
 * @formatter:off
 */
class Db_Mysql {
	
	/**
	 * ִ�е�SQL����
	 * @var int
	 */
	private $_query_num = 0;
	
	/**
	 * ִ��SQL����ʱ����ܺ�
	 * @var int
	 */
	private $_query_time = 0;
	
	/**
	 * ���һ��SQLִ�е�ʱ��
	 * @var int
	 */
	private $_last_query_time = 0;
	
	/**
	 * ���ݿ���Դ����
	 * @var resources
	 */
	private $_link = null;
	
	/**
	 * ִ��SQL֮�����Դ�����
	 * @var resources
	 */
	private $_result = null;
	
	/**
	 * ���ܻ���ı�
	 * @var array
	 */
	private $_no_cache_tables = array();
	
	/**
	 * �������ݿ�
	 * @param string $dbname database�����е�KEY�ַ���

	 */
	public function __construct($dbname) {
		if (defined('DIR_FS_DATABASE') && DIR_FS_DATABASE != '' && file_exists(DIR_FS_DATABASE)) {
			$dbinfo = require DIR_FS_DATABASE;
		} elseif (defined('DIR_FS_ROOT') && DIR_FS_ROOT != '') {
			$dbinfo = require(DIR_FS_ROOT . 'public/Datebase.php');
		} else {
			My_Exception::mythrow('dberr','���ݿ������ļ�δ�ҵ�!');
		}
		$dbinfo = $dbinfo[$dbname];
		$user     = !empty($dbinfo['user']) ? $dbinfo['user'] : My_Exception::mythrow('dberr','���ݿ������û���δ���ã�');
		$server   = !empty($dbinfo['host']) ? $dbinfo['host'] : My_Exception::mythrow('dberr','���ݿ����ӷ�������ַδ���ã�');
		$password = !empty($dbinfo['pwd']) ? $dbinfo['pwd'] : My_Exception::mythrow('dberr','���ݿ���������δ���ã�');
		$database = !empty($dbinfo['dbname']) ? $dbinfo['dbname'] : My_Exception::mythrow('dberr','���ݿ����δ���ã�');
		$port     = !empty($dbinfo['port']) ? $dbinfo['port'] : '3306';
		$charset  = !empty($dbinfo['charset']) ? $dbinfo['charset'] : 'utf8';

		$is_lasting = defined('DB_LASTING') && DB_LASTING == true ? DB_LASTING : false ;
		if ($is_lasting === true) {
			$this->_link = mysql_pconnect("{$server}:{$port}", $user, $password, 131072);
		} else {
			$this->_link = mysql_connect("{$server}:{$port}", $user, $password, 1, 131072);
		}
		if (!$this->_link) My_Exception::mythrow('dberr', '���ݿ�����ʧ�ܣ�');
		$this->_link && mysql_select_db($database,$this->_link);
		$charset && mysql_query('set names ' . $charset, $this->_link);
		
		/* ����Ҫ���л���ı� */
		$this->_no_cache_tables = defined('NO_CACHE_TABLES') && NO_CACHE_TABLES != '' ? explode(',',NO_CACHE_TABLES) : array();
	}
	
	/**
	 * ��ȡ�ɹ�ִ���˶��ٴ�SQL
	 * @return number
	 */
	public function getQueryNum() {
		return $this->_query_num;
	}
	
	/**
	 * ��ȡ����SQLִ�е�ʱ���ܺ�
	 * @return number
	 */
	public function getQueryTime() {
		return $this->_query_time;
	}
	
	/**
	 * ��ȡ���һ��SQLִ�����õ�ʱ��
	 * @return number
	 */
	public function getLastQueryTime() {
		return $this->_last_query_time;
	}
	
	/**
	 * ���SQL�Ƿ��ܻ��棬�Ƿ���true,����false
	 * @param string $sql
	 * @return boolean
	 */
	private function isDisableCache($sql){
		if ($this->_no_cache_tables) {
			foreach ($this->_no_cache_tables as $key => $val) {
				if (stripos($sql, $val) !== false) {
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 * �������ݿ⻺��󣬴���SQL���ӵĹ���
	 * @param string $query SQL���
	 * @return string
	 */
	private function isCache($query){
		if (defined('ENABLE_SQL_CACHE') && ENABLE_SQL_CACHE == true) {
			if (preg_match('/^(select )/iU',$query, $m) && stripos($query, 'SQL_CACHE') === false && stripos($query, 'SQL_NO_CACHE') === false) {
				
				if ($this->isDisableCache($query)){
					$query = preg_replace('/'.$m[1].'/iU',$m[1].' SQL_NO_CACHE ', $query, 1);
				}else{
					$query = preg_replace('/'.$m[1].'/iU',$m[1].' SQL_CACHE ', $query, 1);
				}
			}elseif(defined('SQL_OPEN_IGNORE') && SQL_OPEN_IGNORE == true && preg_match('/^(update |insert )/iU',$query, $m) && stripos($query, ' IGNORE ')===false){	//��Ӻ��Դ����д��
				$query = preg_replace('/'.$m[1].'/iU',$m[1].' IGNORE ', $query, 1);
			}
		}
		return $query;
	}
	
	/**
	 * ��¼��־���ļ�
	 * @param string $txt
	 */
	private function writeLog($txt) {
		/* ������˼�¼��ѯ��־��¼���ܣ����¼��ѯ��־�� STORE_PAGE_PARSE_TIME_LOG ����ָ����λ��  ���������������ݿ��У� */
		if (defined('STORE_DB_TRANSACTIONS') && STORE_DB_TRANSACTIONS == 'true') {
			if (defined('DIR_FS_ROOT') && defined('STORE_PAGE_PARSE_TIME_LOG')) {
				error_log($txt . "\n", 3, DIR_FS_ROOT . STORE_PAGE_PARSE_TIME_LOG);
			}
		}
	}
	
	/**
	 * ִ��SQL����ѯ
	 * @param string $query
	 * @return ������
	 */
	public function query($query) {
		
		$query = trim($query);
		$this->writeLog('QUERY ' . $query);
		$query = $this->isCache($query);
		$_db_query_time = 0;
		$_db_query_time = microtime(true);
		$result = mysql_query($query, $this->_link);
		if (!$result) {
			$result_error = mysql_error();
			$this->writeLog('RESULT ' . $result . ' ' . $result_error);
			My_Exception::mythrow('dberr', 'SQL���ִ��ʧ�ܣ�',$query, mysql_errno(), mysql_error());
		}
		$this->_query_num ++;
		$this->_last_query_time = microtime(true) - $_db_query_time;
		$this->_query_time += $this->_last_query_time;
	
		/*д���»�ɾ����������־�����ݿ�*/
		//if(preg_match('/^(update|delete)+/',trim(strtolower($query)) ,$m) && !preg_match('/(sessions)+/',trim(strtolower($query)) ) ){
		/*if(preg_match('/^(delete)+/',trim(strtolower($query)) ,$m) && !preg_match('/(sessions)+/',trim(strtolower($query))) && !preg_match('/(whos\_online)+/',trim(strtolower($query)) ) ){
			$query_a = ('insert into `sql_query_logs` ( `admin_id` , `query_sql` , `query_time` , `url_file_name`, `query_type` ) VALUES (9999999, "'.addslashes(trim($query)).'", "'.date("Y-m-d H:i:s").'", "'.$_SERVER['PHP_SELF'].'", "'.strtolower($m[1]).'");');
			mysql_query($query_a, $$link) or tep_db_error($query, mysql_errno(), mysql_error());
		}
	
		if($isshow_exectime){
			echo '<font style="color:red;">Query Execute Time :'.number_format((tep_db_mcrotime()-$_db_query_time),6).' (s)!</font><br>';
			echo 'SQL:<br>'.$query.'<hr>';
		}*/
		$this->_result = $result;
		return $this;
	}
	
	/**
	 * ��ȡ���м�¼�����
	 * @param int $type ��ѡ MYSQL_ASSOC��MYSQL_NUM �� MYSQL_BOTH Ĭ����MYSQL_ASSOC
	 */
	public function getAll($type = MYSQL_ASSOC) {
		$data = array();
		if (is_resource($this->_result)) {
			while (false != $row = mysql_fetch_array($this->_result, $type)) {
				$data[] = $row;
			}
		} else {
			my_exception::mythrow('dberr', '���ݽ��������һ����Ч����Դ���ӣ�');
		}
		return $data;
	}
	
	/**
	 * ֻ��ȡһ����¼
	 * @param int $type ��ѡ MYSQL_ASSOC��MYSQL_NUM �� MYSQL_BOTH Ĭ����MYSQL_ASSOC
	 */
	public function getOne($type = MYSQL_ASSOC) {
		$data = array();
		if (is_resource($this->_result)) {
			$data = mysql_fetch_array($this->_result, $type);
		} else {
			my_exception::mythrow('dberr', '���ݽ��������һ����Ч����Դ���ӣ�');
		}
		return $data;
	}
	
	/**
	 * ȡ��ָ����Ľṹ��Ϣ
	 * @param  string $table ��Ҫ��ȡ�ṹ�ı���
	 * @return array
	 */
	public function getFields($table){
		return $this->query('describe ' . $table)->get_all();
	}
	
	/**
	 * ����Ƿ�����Ҫ���ų����ֶΣ�����Щ�ֶβ��ܱ�д�����ݿ⣬���ع��˺������
	 * @param string $table
	 * @param array $formFields
	 * @param string $disableFields
	 * @return array
	 */
	private function filterFileds($table, $formFields, $disableFields = ""){
		if(!!$disableFields){
			$disableFields = explode(',',preg_replace('/[[:space:]]+/','',$disableFields));
		}
		$insert_id = 0;
		$fields = $this->getFields($table);
		$fields_new  = array();
		foreach($fields as $key => $val) {
			$fields_new[] = $val['Field'];
		}
		$fields = $fields_new;
		$formFields = convert::unescape($formFields);
		$sql_data_array = array();
		if ($fields) {
			foreach ($fields as $key => $val) {
				if (array_key_exists($val, $formFields) && !is_array($formFields[$val])) {
					if ($disableFields == '' || !in_array($val, (array)$disableFields)) {
						$sql_data_array[$val] = $formFields[$val];
					}
				}
			}
		}
		return $sql_data_array;
	}
	
	/**
	 * �����ݽ��и�ʽ�����Ա�д�����ݿ� ע�� ��֧������
	 * @param string $string Ҫ������ַ�������
	 * @return string
	 * @author lwkai 2013-2-28 ����4:17:36
	 */
	private function db_input($string) {
		if (function_exists('mysql_real_escape_string')) {
			return mysql_real_escape_string($string);
		} elseif (function_exists('mysql_escape_string')) {
			return mysql_escape_string($string);
		} else {
			if(!get_magic_quotes_gpc()){
				$string = addslashes($string);
			}
			return $string;
		}
	}
		
	/**
	 * ��ʽ�������������ݸ�ʽ��ת���ɶ�Ӧ��SQL��䣬�Ա���ȷִ�С�
	 * @param array $data 
	 * @return string
	 */
	private function formatSql($data) {
		$query = '';
		if (is_array($data)) {
			foreach ($data as $columns => $value) {
				switch (true) {
					case (string)$value == 'now()':
						$query .= $columns . ' = now(), ';
						break;
					case (string)$value == 'null':
						$query .= $columns . ' = null, ';
						break;
					case (preg_match('/^' . preg_quote($columns) . '\s*[\+\-]\s*\d+/', $value)):
						$query .= $columns . ' = ' . $value . ', ';
						break;
					default:
						$query .= $columns . ' = \'' . $this->db_input($value) . '\', ';
						break;
				}
			}
		}
		return $query;
	}
	
	/**
	 * ִ�в������ݶ���,�����ز���ɹ����������¼��ID
	 * @param string $table ��Ҫ�������ݵı���
	 * @param array $data Ҫ��������� ��ʽ�� array('fileds'=>'values'[,'fileds'=>'values'[,...]])
	 * @param string $disableFields ���ų����ֶΣ�����Щ�ֶβ��ܱ�д�����ݿ�
	 * @return number
	 */	
	public function insert($table, $data, $disableFields = "") {
			$query = 'insert into ' . $table . ' set ';
			if ($disableFields && $disableFields != "") {
				$data = $this->filterFileds($table, $data,$disableFields);
			}
			
			$query .= $this->formatSql($data);
			$query = substr($query, 0, -2);
			$this->query($query);
			return mysql_insert_id($this->_link);
	}
	
	/**
	 * ִ�и������ݶ�����������Ӱ��ļ�¼�ж�����
	 * @param string $table ��Ҫ���и��µı���
	 * @param array $data Ҫ���µ����� ��ʽ�� array('fileds'=>'values'[,'fileds'=>'values'[,...]])
	 * @param string $where ��������
	 * @param string $disableFields ���ų����ֶΣ�����Щ�ֶβ��ܱ�����
	 * @return int
	 */
	public function update($table, $data, $where = '', $disableFields = ""){
			$query = 'update ' . $table . ' set ';
			if ($disableFields) {
				$data = $this->filterFileds($table, $data,$disableFields);
			}
			$query .= $this->formatSql($data);
			$query = substr($query, 0, -2) . ' where ' . $where;
			$this->query($query);
			return mysql_affected_rows($this->_link);
	}
	
	/**
	 * ִ��ɾ������������Ӱ��ļ�¼����
	 * @param string $table Ҫɾ�����ݵı���
	 * @param string $where ɾ������
	 * @return number
	 */
	public function delete($table,$where) {
		$query = "delete from " . $table . " where " . $where;
		$this->query($query);
		return mysql_affected_rows($this->_link);
	}
	
	/**
	 * ִ������SQL���
	 * @param string $sql SQL����
	 * @author lwkai 2013-1-8 ����3:41:27
	 */
	public function execute($sql) {
		$sql = trim($sql);
		if ($sql) {
			$_db_query_time = microtime(true);
			$result = mysql_query($sql, $this->_link);
			if (!$result) {
				$result_error = mysql_error();
				$this->writeLog('RESULT ' . $result . ' ' . $result_error);
				My_Exception::mythrow('dberr', 'SQL���ִ��ʧ�ܣ�',$sql, mysql_errno(), mysql_error());
			}
			$this->_query_num ++;
			$this->_last_query_time = microtime(true) - $_db_query_time;
			$this->_query_time += $this->_last_query_time;
			return $result;
		}
	}
}
<?php
/*
  $Id: database.php,v 1.1.1.1 2004/03/04 23:40:48 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
$_SQL_QUERY_NUM = 0;
$_SQL_QUERY_TIME = 0;/*
function microtime_float1(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}*/
/*$logfp = fopen('/log.txt','a');
function parse_query($query ,$runtime=0){
	$query = strtoupper(trim($query));
	$queryInsert = str_replace('"','\\"',$query);
	if(strncmp($query, 'SELECT', 6)==0){		
		$pat = '/^SELECT.+?FROM\s+(.+?)\s+.*$/';
		if(preg_match($pat,$query,$match)){
			$tablename = str_replace('`','', $match[1]);
		}else{
			$tablename = 'unknow';
		}
		$logstr = '"SELECT","'.$tablename.'",'.$runtime;//.',"'.$queryInsert.'"';
	}else if(strncmp($query, 'INSERT', 6)==0){
		$logstr = '"INSERT","",'.$runtime;//.',"'.$queryInsert.'"';
	}else if(strncmp($query, 'UPDATE', 6)==0){
		$logstr = '"UPDATE","",'.$runtime;//.',"'.$queryInsert.'"';
	}else{
		$logstr = '"OTHER","",'.$runtime;//.'","'.$queryInsert.'"';
	}
	global $logfp;
	fwrite($logfp , $logstr."\n");
}*/

  function tep_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $$link;

    if (USE_PCONNECT == 'true') {
      $$link = mysql_pconnect($server, $username, $password, 131072);
    } else {
      $$link = mysql_connect($server, $username, $password, 1, 131072);	//֧�ִ洢����
    }

    if ($$link) mysql_select_db($database);

    return $$link;
  }

  function tep_db_close($link = 'db_link') {
    global $$link;

    return mysql_close($$link);
  }

  function tep_db_error($query, $errno, $error) {
    die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br><br>' . $query . '<br><br><small><font color="#ff0000">[TEP STOP]</font></small><br><br></b></font>');
  }

  function tep_db_query($query, $link = 'db_link', $isshow_exectime=false) {
    global $$link,$_SQL_QUERY_NUM,$_SQL_QUERY_TIME;
	
	//��ʱ�ر���php���������ݱ��Ż����� by howard 2013-05-28
	if(preg_match('/OPTIMIZE +TABLE/i', $query)) return false;
	
	if(defined('OPEN_SQL_EXPLAIN_CHECK') && OPEN_SQL_EXPLAIN_CHECK=='true'){
		echo '<div>explain '.$query.'</div>';
	}

	if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
      error_log('QUERY ' . $query . "\n", 3, DIR_FS_CATALOG.STORE_PAGE_PARSE_TIME_LOG);
    }
    //$isshow_exectime = true;
	$_db_query_time = 0;
	if($isshow_exectime){
		$_db_query_time = tep_db_mcrotime();
	}
	
	/*Mysql Cache Set Howard added*/
	$query = trim($query);
	if(preg_match('/^(select )/iU',$query, $m) && stripos($query, 'SQL_CACHE')===false && stripos($query, 'SQL_NO_CACHE')===false){
		if((stripos($query, 'sessions')===false && stripos($query, 'sql_query_logs')===false)){
			$query = preg_replace('/'.$m[1].'/iU',$m[1].' SQL_CACHE ', $query, 1);
		}else{
			$query = preg_replace('/'.$m[1].'/iU',$m[1].' SQL_NO_CACHE ', $query, 1);
		}
	}elseif(SQL_OPEN_IGNORE == true && preg_match('/^(update |insert )/iU',$query, $m) && stripos($query, ' IGNORE ')===false){	//��Ӻ��Դ����д��
		$query = preg_replace('/'.$m[1].'/iU',$m[1].' IGNORE ', $query, 1);
	}
    $result = mysql_query($query, $$link) or tep_db_error($query, mysql_errno(), mysql_error());
    $_SQL_QUERY_NUM++;
    //parse_query($query,microtime_float1() - $t1);
    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
       $result_error = mysql_error();
       error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, DIR_FS_CATALOG.STORE_PAGE_PARSE_TIME_LOG);
    }
	
	/*д���»�ɾ����������־�����ݿ⣨�Ѿ���ͣ�ã�*/
	//if(preg_match('/^(update|delete)+/',trim(strtolower($query)) ,$m) && !preg_match('/(sessions)+/',trim(strtolower($query)) ) ){
	if(0 && preg_match('/^(delete)+/',trim(strtolower($query)) ,$m) && !preg_match('/(sessions)+/',trim(strtolower($query))) && !preg_match('/(whos\_online)+/',trim(strtolower($query)) ) ){
		$query_a = ('insert into `sql_query_logs` ( `admin_id` , `query_sql` , `query_time` , `url_file_name`, `query_type` ) VALUES (9999999, "'.addslashes(trim($query)).'", "'.date("Y-m-d H:i:s").'", "'.$_SERVER['PHP_SELF'].'", "'.strtolower($m[1]).'");');
		mysql_query($query_a, $$link) or tep_db_error($query, mysql_errno(), mysql_error());
	}
	
	if($isshow_exectime){
		echo '<font style="color:red;">Query Execute Time :'.number_format((tep_db_mcrotime()-$_db_query_time),6).' (s)!</font><br>';
		echo 'SQL:<br>'.$query.'<hr>';
	}
    return $result;
  }
  
  function tep_db_query_check($query, $link = 'db_link') {
	   global $$link,$_SQL_QUERY_NUM;
	   return tep_db_query($query, $link,true);
  }
  
  function tep_db_mcrotime(){
		$t_array = explode(' ',microtime());
		return $t_array[0] + $t_array[1];
  }
  
  /**
   * д�����ݿ�
   * @param string $table Ҫд������ݱ���
   * @param array $data Ҫд������ݼ�ֵ��
   * @param string $action д�뷽ʽ insert|update��Ĭ���� insert
   * @param string $parameters д��ʱ������
   * @param string $link ���ӱ�ʶ
   * @return resource
   */
  function tep_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    reset($data);
    if ($action == 'insert') {
      $query = 'insert into ' . $table . ' (';
      while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      reset($data);
      while (list(, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . tep_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . tep_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }

    return tep_db_query($query, $link);
  }
  
  function tep_db_get_one($sql,$check = false) {
	  if($check){
		return tep_db_fetch_array(tep_db_query_check($sql));
	  }else{
		return tep_db_fetch_array(tep_db_query($sql));
	  }
  }

  function tep_db_fetch_array($db_query) {
    return mysql_fetch_array($db_query, MYSQL_ASSOC);
  }

  function tep_db_result($result, $row, $field = '') {
    return mysql_result($result, $row, $field);
  }
  /**
   * mysql_num_rows�ı������� [ȡ�ý��������������Ŀ]
   * @param ResultSet $db_query �����
   * @return int
   */
  function tep_db_num_rows($db_query) {
    return mysql_num_rows($db_query);
  }

  function tep_db_data_seek($db_query, $row_number) {
    return mysql_data_seek($db_query, $row_number);
  }

  function tep_db_insert_id() {
    return mysql_insert_id();
  }

  function tep_db_free_result($db_query) {
    return mysql_free_result($db_query);
  }

  function tep_db_fetch_fields($db_query) {
    return mysql_fetch_field($db_query);
  }

  function tep_db_output($string) {
	return tep_htmlspecialchars($string);
  }

  function tep_db_input($string) {
	if(!get_magic_quotes_gpc()){
		$string = addslashes($string);
  	}
	return $string;
  }

  /**
   * �Ե����ź�˫���Ž��з�ת�� ׼��д�����ݿ�
   * ���� \" ת���� " ׼��д�����ݿ�
   * @param array|string $string
   * @return string|array <unknown, string>
   */
  function tep_db_prepare_input($string) {
    if (is_string($string)) {
      return trim(stripslashes2($string));
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = tep_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }

  /**
   * �Ե����ź�˫���Ž��з�ת��
   * @param string $string
   * @return string
   */
function stripslashes2($string) {
  
   $string = str_replace("\\\"", "\"", $string);
  
   $string = str_replace("\\'", "'", $string);
  if(eregi("\\\\",$string)){
   $string = str_replace("\\\\", "\\", $string);
   }
   return $string;
}
/**
 * ����ָ����ѯ�Ľ������
 * ���������maxrow��ֻ��ȡǰmaxrow������ maxrowĬ��Ϊ500
 * @author vincent
 * @param string $sql
 * @param int maxrow 500
 */
function vin_db_fetch_all($sql,$maxrow=500){
	$result = tep_db_query($sql) ;	
	$rows = array();
	$i = 0 ;
	while(($row =  tep_db_fetch_array($result, MYSQL_ASSOC)) && $i < $maxrow){
		$rows[] = $row ;
		$i++;
	}
	tep_db_free_result($result);
	return $rows;
}
/**
 * ����ָ����ѯ�Ľ������ĵ�һ��
 * @author vincent
 * @param string $sql
 */
function vin_db_fetch_first($sql){
	$result = tep_db_query($sql) ;	
	$row =  tep_db_fetch_array($result, MYSQL_ASSOC);
	tep_db_free_result($result);
	return $row;
}


/**
 * ȡ��ָ������ֶ�����
 * @author howard
 * @param  string $table_name
 */
function tep_db_table_fields_names($table_name){
	$meta = false;	
	$array = tep_db_table_fields($table_name);
	foreach ($array as $key => $val) {
		$meta[] = $val["Field"];		
	}
	return $meta;
}
/**
 * ȡ��ָ������ֶ���Ϣ����
 * @author howard
 * @param  string $table_name
 * @return array
 */
function tep_db_table_fields($table_name){
	$data = array();
	$describe_query = tep_db_query("describe $table_name ");
	while ($d_row = tep_db_fetch_array($describe_query)) {
		$data[] = $d_row;		
	}
	return $data;
}
/**
 * ȡ��ĳ�����������
 * @param string $table_name
 * @return array
 */
function tep_db_table_primary_keys($table_name){
	$data = array();
	$fields = tep_db_table_fields($table_name);
	foreach ($fields as $field){
		if($field['Key']=='PRI') $data[] = $field['Field'];
	}
	return $data;
}

/**
 * ���ٲ������ݵ�ָ�����ݱ�
 * @param string $table ����
 * @param array $formFields �ֶ�ֵ���飨ԭʼ�ı����ݣ����þ���tep_db_prepare_input()���� �ύ����������KEY�����ݿ��ֶα�����ͬ
 * @param string $disableFields ���ų����ֶΣ�����Щ�ֶβ��ܱ�д�����ݿ�
 * @return int
 */
function tep_db_fast_insert($table, $formFields, $disableFields = ""){
	if(tep_not_null($disableFields)){
		$disableFields = explode(',',preg_replace('/[[:space:]]+/','',$disableFields));
	}
	$insert_id = 0;
	$fields = tep_db_table_fields_names($table);
	$formFields = tep_db_prepare_input($formFields);
	$sql_data_array = false;
	if(sizeof($fields)){
		foreach($fields as $key => $val){
			if(array_key_exists($val, $formFields) && !is_array($formFields[$val])){
				if(!in_array($val, (array)$disableFields) || $disableFields=="" ){
					$sql_data_array[$val] = $formFields[$val];
				}
			}
		}
		if(is_array($sql_data_array)){
			tep_db_perform($table, $sql_data_array);
			$insert_id = tep_db_insert_id(); 
		}
	}

	return $insert_id;
}

/**
 * ���ٸ��±����� *
 * @param string $table ����
 * @param string $where �����ַ�
 * @param array $formFields �ֶ�ֵ���飨ԭʼ�ı����ݣ����þ���tep_db_prepare_input()����
 * @param string $allowFields ������µ��ֶΣ����ֵΪ*����Ը��������ֶ�
 * @return int
 */
function tep_db_fast_update($table, $where, $formFields, $allowFields = "*"){
	if($allowFields!="*"){
		$allowFields = explode(',',preg_replace('/[[:space:]]+/','',$allowFields));
	}
	$fields = tep_db_table_fields_names($table);
	$formFields = tep_db_prepare_input($formFields);
	$sql_data_array = false;
	if(sizeof($fields)){
		foreach($fields as $key => $val){
			if(array_key_exists($val, $formFields) && !is_array($formFields[$val])){
				if(in_array($val, (array)$allowFields) || $allowFields=="*" ){
					$sql_data_array[$val] = $formFields[$val];
				}
			}
		}
		if(is_array($sql_data_array)){
			tep_db_perform($table, $sql_data_array, 'update', $where);
			return (int)tep_db_affected_rows();
		}
	}
	return 0;
}

function tep_db_affected_rows(){
	return mysql_affected_rows();
}


/**
 * �ж����ݱ��ĳ���ֶ��Ƿ����
 *
 * @param unknown_type $table ����
 * @param unknown_type $field �ֶ���
 * @return ���ز���ֵ
 */
function tep_db_field_exists($table, $field){
	$describe_query = tep_db_query("describe $table");
	while ($d_row = tep_db_fetch_array($describe_query)) {
		if ($d_row["Field"] == "$field")
		return true;
	}
	return false;
}

/**
 * ����ȡ��ĳ����ĳ���ֶε�ֵ�������ȡ�ò�ƷIDΪ125�Ĳ�Ʒ���Ƶ�
 * @param string $field_name �ֶ�����
 * @param string $table_name ���ݱ�����
 * @param string $where ɸѡ��������where�ַ�
 * @example tep_db_get_field_value('products_name', 'products_description', 'products_id=125 AND language_id=1 ')
 */
function tep_db_get_field_value($field_name, $table_name, $where ='1' ){
	$field_name = trim($field_name);	
	$sql = tep_db_query('SELECT '.(string)$field_name.' FROM '.(string)$table_name.' WHERE '.(string)$where.' Limit 1 ');
	$row = tep_db_fetch_array($sql);
	return $row[preg_replace('/(.+\.)/','',$field_name)];
}
?>

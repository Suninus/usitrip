<?php
/**
 * ��̨����Ա��¼��־������
 * @author lwkai 2013-10-10
 *
 */
class AdminLoginLogs {
	/**
	 * ����������ʼ����
	 * @var string
	 */
	private $_startDate = '';
	/**
	 * ����������������
	 * @var string
	 */
	private $_endDate = '';
	/**
	 * ��������IP
	 * @var string
	 */
	private $_ip = '';
	/**
	 * ������������
	 * @var string
	 */
	private $_job_number = '';
	
	/**
	 * ÿҳ��ʾ��������¼
	 * @var int
	 */
	private $_pageSize = 10;
		
	/**
	 * ���캯�� ��ʼ��ʱ�����Դ�������ʱ��Ҫ������
	 * @param string $StartDate ��ʼʱ���[��ѡ]
	 * @param string $EndDate ����ʱ���[��ѡ]
	 * @param string $IP IP��ַ[��ѡ]
	 * @param int $job_number �û�����[��ѡ]
	 * @param int $pagesize �б�һҳ������,Ĭ��10
	 */
	public function __construct($StartDate='',$EndDate='',$IP='',$job_number='',$pagesize=10){
		$this->_endDate = $EndDate;
		$this->_startDate = $StartDate;
		$this->_ip = $IP;
		$this->_job_number = $job_number;
		$this->_pageSize = $pagesize;
	}
	/**
	 * ���һ����¼
	 * @param int $admin_id ��ǰҪ��¼����־���û�ID
	 * @return number
	 */
	public function add($admin_id){
		$data = array();
		$data['ip'] = tep_get_ip_address();
		$data['time'] = date('Y-m-d H:i:s');
		$data['admin_id'] = intval($admin_id);
		tep_db_fast_insert('admin_login_logs', $data);
		return tep_db_insert_id();
	}
	
	/**
	 * ȡ�������б�
	 * @return multitype:NULL multitype:multitype:  string
	 */
	public function getList() {
		$rtn = array();
		$record = array();
		$sql = "select a.admin_job_number,alog.* from admin_login_logs as alog,admin as a ";
		$sql .= " where " . $this->createWhere() . " order by alog.id desc";
		$keywords_query_numrows = 0;
		$_split = new splitPageResults($_GET['page'], $this->_pageSize, $sql, $keywords_query_numrows);
		$rs = tep_db_query($sql);
		while($row = tep_db_fetch_array($rs)) {
			$record[] = $row;
		}
		$rtn['list'] = $record;
		$rtn['pagelink'] = $_split->display_links($keywords_query_numrows, $this->_pageSize, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], tep_get_all_get_params(array (
				'page',
				'y',
				'x',
				'action'
		)));
		$rtn['pagecount'] = $_split->display_count($keywords_query_numrows, $this->_pageSize, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS);
		return $rtn;
	}
	
	/**
	 * ����������ϲ�ѯ����������
	 * @return string
	 */
	private function createWhere(){
		$where = 'a.admin_id = alog.admin_id';
		$where .= $this->_startDate != '' ? ' and alog.time >= \'' . date('Y-m-d H:i:s',strtotime($this->_startDate)) . '\'' : '';
		$where .= $this->_endDate != '' ? ' and alog.time <= \'' . date('Y-m-d 23:59:59',strtotime($this->_endDate)) . '\'' : '';
		$where .= $this->_ip != '' ? ' and alog.ip=\'' . tep_db_input($this->_ip) . '\'' : '';
		$where .= $this->_job_number != '' ? ' and a.admin_job_number=\'' . intval($this->_job_number) . '\'' : '';
		return $where;
	}
	
	/**
	 * ɾ����¼
	 * @param array|string $id
	 */
	public function del($id=array()){
		$ids = '';
		if (is_array($id)) {			
			foreach($id as $key => $val) {
				$id = intval($val);
				$ids .= $id > 0 ? $id . ',' : '';
			}			
			$ids = trim($ids,',');
		} elseif (is_string($id)) {
			$id = intval($id);
			$ids = $id > 0 ? $id : '';
		}
		if ($ids) {
			$sql = "delete from admin_login_logs where id in (" . $ids . ")";
			tep_db_query($sql);
		}
	}
}
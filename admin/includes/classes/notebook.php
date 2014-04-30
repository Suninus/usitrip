<?php
/**
 * ���Ա��ֻ࣬���ں�̨��aben
 *
 */
class notebook {
	var $login_id;	//��ǰ��¼�Ĺ���Աid
	/**
	 * ���Ա�����������
	 */
	var $tables;

	/**
	 * Account���캯��
	 *
	 * @param unknown_type $arr
	 */
	function __construct($arr = array()){
		global $login_id, $messageStack;
		if(is_array($arr) && count($arr)>0){
			foreach($arr as $key => $value){
				$this->$key = $value;
			}
		}
		$this->login_id = $login_id;
		$this->tables = 'notebook'; //���Ա�����������
	}
	/**
	 * ��ȡĳ�����Ա����ݣ���������ɾ����ǵ����ԣ�
	 *@param  string $notebook_id (���±�ID)
	 *@return array $arr / false
	 */
	public function getnote($notebook_id){
		global $messageStack;
		$error = false;
		$notebook_id = (int)$notebook_id;
		if(!tep_not_null($notebook_id)){
			$error = true;
			$messageStack->add('id����Ϊ�գ�','error');
		}
		$data = false;
		if($error==false){
			$sql='SELECT * FROM '.$this->tables.' WHERE notebook_id='.$notebook_id.' AND is_deleted=0';
			$sqlQuery=tep_db_query($sql);
			while($rows = tep_db_fetch_array($sqlQuery)){
				$data[] = $rows;	//���ݼ�¼����
			}
			if(is_array($data[0])){
				return $data;
			}
			return false;
		}

	}
	/**
	 * ͨ������ID��ȡ�����б�
	 * @param int $orders_id ����ID
	 * @return array||NULL
	 */
	public function getListByOrdersId($orders_id){
		$str_sql='SELECT notebook_id FROM '.$this->tables.' WHERE orders_id='.(int)$orders_id;
		$sql_query=tep_db_query($str_sql);
		$rows=array();
		while($row=tep_db_fetch_array($sql_query)){
			$rows[]=$row;
		}
		return $rows;
	}
	/**
	 * ���루����£����Ե����ݿ�
	 * @param $post_array Ϊ׼��Ҫ�������ݿ��������$_POST
	 * @param $action Ĭ��Ϊ insert�ǲ��룬update�Ǹ���
	 * @param $update_where Ĭ��Ϊ�գ�����Ǹ������ݿ�����Ҫ��дWHERE֮�������
	 * @return boolen
	 */
	public function insert_or_update($post_array, $action='insert', $update_where=''){
		global $messageStack;
		$error = false;

		//��д�����жϴ���
		if(!tep_not_null($post_array['content'])){
			$error = true;
			$messageStack->add('�������ݲ���Ϊ�գ�','error');
		}
		if(!(int)$post_array['to_login_id']){
			$error = true;
			$messageStack->add('��ѡ�����Խ����ˣ�','error');
		}
		//��д���ݿ����
		if($error==false){
			if($action=='insert'){
				$post_array['add_date'] = date('Y-m-d H:i:s');
				$post_array['sent_login_id'] = $this->login_id;
				$post_array['orders_id']=$post_array['orders_id'];
				$insert_id = tep_db_fast_insert($this->tables, $post_array,'notebook_id,is_deleted');
				if((int)$insert_id){
					$messageStack->add_session('���ݲ���ɹ�', 'success');	//�������ɹ���������ҳ��ʱ�ô˷�����¼�ɹ���ʾ��Ϣ
				}
				return $insert_id;	//���ر��������notebook_id
			}else{
				$post_array['update_date'] = date('Y-m-d H:i:s');
				tep_db_fast_update($this->tables, 'notebook_id="'.(int)$post_array['notebook_id'].'" and sent_login_id ="'.(int)$this->login_id.'"', $post_array,'content,orders_id,to_login_id,update_date');
				$messageStack->add_session('���ݸ��³ɹ�', 'success');	//�������ɹ���������ҳ��ʱ�ô˷�����¼�ɹ���ʾ��Ϣ
			}
			return true;
		}
		//$messageStack->add('ʧ��', 'error');	//������������ҳ��ʱ�ô˷�����¼������ʾ��Ϣ
		return false; //�ɹ�����trueʧ�ܷ���false
	}

	/**
	 * �ظ�����
	 *
	 * @param unknown_type $post_array
	 * @param unknown_type $update_where
	 * @return none
	 */
	public function reply($post_array, $update_where=''){
		global $messageStack;
		$error = false;
		if(!tep_not_null($post_array['answer_content'])){
			$error=true;$messageStack->add('�ظ����ݲ���Ϊ��','error');
		}
		if($error==false){
			$sql = 'SELECT answer_content FROM '.$this->tables.' WHERE notebook_id="'.(int)$post_array['notebook_id'].'" AND is_deleted=0 AND is_finished=0 ';
			$sql_query = tep_db_query($sql);
			while($rows =  tep_db_fetch_array($sql_query))
			{
				$data = $rows;
			}
			//print_r($data); exit();
			$post_content=$post_array['answer_content'];
			if(is_array($data))
			{
				$post_array['answer_content'] = $post_array['answer_content'] . "\n" . $data['answer_content'];
				$post_array['answer_date']=date('Y-m-d H:i:s');
				$post_array['is_replyed']=1;
				$post_array['answer_login_id']=$this->login_id;
				//print_r($post_array);//exit();
				tep_db_fast_update($this->tables, 'notebook_id="'.(int)$post_array['notebook_id'].'" AND is_deleted=0 AND is_finished=0 ', $post_array,'answer_date,answer_login_id,answer_content,is_replyed,is_finished');
				$this->addHistoryReplay((int)$post_array['notebook_id'], $post_content);
				$messageStack->add_session('�ظ��ɹ�!','success');
			}
		}
	}
	/**
	 * �������ԵĻظ���ʷ��¼
	 * @param int $note_id ���Ե�ID
	 * @param string $content ���Ե�����
	 */
	public function addHistoryReplay($note_id,$content){
		$str_sql='insert into notebook_history set notebook_id='.$note_id.' ,replay_content="'.$content.'", replay_user='.$this->login_id.',replay_time=now()';
		tep_db_query($str_sql);
	}
	/**
	 * ��ȡһ�����Ե���ʷ��¼
	 * @param unknown_type $note_id
	 */
	public function getHistoryReplay($note_id){
		$data=array();
		$str_sql='select t1.*,CONCAT(t2.admin_lastname," ", t2.admin_firstname,"(",t2.admin_job_number,")") AS admin_name FROM `admin` t2, notebook_history t1 where t1.replay_user=t2.admin_id and t1.notebook_id='.$note_id.' order by t1.replay_time DESC';
		$query=tep_db_query($str_sql);
		while($rows =  tep_db_fetch_array($query)){
			$data[]=$rows;
		}
		return $data;
	}
	/**
	 * ɾ��һ�����������
	 * @param in: int / array $notebook_ids �����ǵ�������id��������(array)$_POST['notebook_ids']
	 * @return boolen
	 */
	public function delete($notebook_ids){
		global $messageStack;
		$error = false;
		$where = ' where sent_login_id='.$this->login_id;
		$ids='';
		if (is_array($notebook_ids)){
			$where .= ' AND notebook_id IN ('.implode(',',$notebook_ids).') ';
			$ids=implode(',',$notebook_ids);
		}elseif (is_string($notebook_ids)){
			$where .= ' AND notebook_id = "'.$notebook_ids.'" ';
			$ids=$notebook_ids;
		}else {
			$error = true;
			$messageStack->add('��ɾ��Ŀ���ID�ţ�����ɾ��ʧ�ܣ�','error');
		}
		//��д���ݿ����
		if($error==false){
			tep_db_query('UPDATE '.$this->tables.' SET is_deleted=1,deleted_login_id='.$this->login_id.', delete_date="'.date('Y-m-d H:i:s').'"'.$where);
			$messageStack->add_session('ID��Ϊ:'.$ids.'�����Լ�¼�ɹ���ɾ����');
			return true;
		}
		return false;
	}
	/**
	 * ���������г��������ݣ����������false
	 *
	 * @param unknown_type $tables Ҫ��ȡ�����ݱ�,��ȡ���,�� table1_1 t1, table_2 t2
	 * @param unknown_type $fields Ҫ��ȡ���ֶΣ�Ĭ��Ϊ*
	 * @param unknown_type $where ������Ĭ��Ϊ1
	 * @param unknown_type $group_by Ĭ��Ϊ�� GROUP BY �����ݣ��� GROUP BY abc
	 * @param unknown_type $order_by ����ʽĬ��Ϊ�ա���ORDER BY t1.t_it DESC
	 * @return unknown array $data or false	����$data['splitPages']Ϊ���ݵķ�ҳ��Ϣ
	 */
	public function lists($tables ='', $fields = '*', $where='',$group_by='',$order_by=''){
		$data = false;
		if(!tep_not_null($tables)){
			$tables = $this->tables;
		}
		$pageMaxRowsNum = 10; //ÿҳ��ʾ10����¼
		$sql = 'SELECT '.$fields.' FROM '.$tables.' where is_deleted=0 AND '.$where.$group_by.$order_by;
		//echo $sql;
		$keywords_query_numrows = 0;
		$_split = new splitPageResults($_GET['page'], $pageMaxRowsNum, $sql, $keywords_query_numrows);
		//var_dump($_split); exit;
		$data['splitPages']['count'] = $_split->display_count($keywords_query_numrows, $pageMaxRowsNum, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS);//��ҳ����,��ʾ����
		$data['splitPages']['links'] = $_split->display_links($keywords_query_numrows, $pageMaxRowsNum, MAX_DISPLAY_PAGE_LINKS, $_GET['page'],tep_get_all_get_params(array('page','y','x', 'action'))); ;//��ҳ���ݷ�ҳ
		//$sql = $_split->sql_query;
		$sqlQuery = tep_db_query($sql);
		while($rows = tep_db_fetch_array($sqlQuery)){
			$data[] = $rows;	//��¼����
		}
		//print_r($data);
		if(is_array($data[0])){
			return $data;
		}
		return false;	//������ʱ����false
	}

	/*
	 *�г�admin���б�
	 *@param none
	 *@return array $arr / false
	 */
	public function admin_list()
	{
		$data=false;
		$sql="SELECT admin_id,CONCAT(admin_lastname,' ', admin_firstname,'(',admin_job_number,')') AS admin_name FROM `admin` where admin_groups_id<>0 ORDER BY admin_job_number asc";
		$sqlQuery = tep_db_query($sql);
		$data[]=array('id'=>'','text'=>'------------');/*Ĭ��Ϊ�յ�ѡ��*/
		while($rows = tep_db_fetch_array($sqlQuery)){
			$data[] = array('id'=>$rows['admin_id'], 'text'=>$rows['admin_name']);	//���ݼ�¼����
		}
		if(is_array($data[0])){
			return $data;
		}
		return false;	//������ʱ����false
	}

	/*
	 * ƥ��admin������,ͨ������,���ٷ������ݿ�Ĵ���.
	 * @param int $admin_id ��̨ID
	 * @param array $admin_list ����Ա��Ϣ����
	 * @return string $text
	 */
	public function get_admin_name($admin_id,$admin_list){
		$data = '';
		if((int)$admin_id > 0){
			$n=count($admin_list);
			for($i=0;$i<$n;$i++){
				if($admin_list[$i]['id']==$admin_id){
					$data = $admin_list[$i]['text'];
					break;
				}
			}
		}
		return $data;
	}
	/**
	 * �ı�ĳ�����Եĵ�ǰ״̬
	 * @param int $id ����id
	 * @param int $value ״ֵ̬��1�ѽ����2Ϊδ���
	 * @return int û���޸�ʱ����0���ɹ��޸�ʱ���سɹ��޸ĵļ�¼��
	 */
	public function changeNext($id,$value,$owner_id){
		if($owner_id==$_SESSION['login_id']){
			$sql_add=' ,owner_click=1,owner_click_time="'.date('Y-m-d H:i:s').'" ';
		}
		$str_sql='update '.$this->tables.' set next_status='.(int)$value.$sql_add.' where notebook_id='.(int)$id;
		tep_db_query($str_sql);
		return tep_db_affected_rows();
	}
	/**
	 * ��Ŀ�����Խ�������/�ۼ�������ȷ�����֣�
	 * @param int $notebook_id ���Ա��
	 * @param int $status_value ��������״ֵ̬1Ϊ�ѽ����2Ϊδ���������ֵ������Ҳ������
	 * @param Assessment_Score $AS �ͷ�������
	 * @return 
	 */
	public function add_confirm_score($notebook_id, $status_value, Assessment_Score $AS){
		$login_id = $_SESSION['login_id'];
		if($login_id && in_array($status_value,array('1','2'))){ //������³ɹ��͸���value�����Զ����+1�֣��ѽ������-1�֣�δ�����
			$info = $this->getnote($notebook_id);
			$info = $info[0];
			if($info['to_login_id'] && $login_id!=$info['to_login_id']){	//�Լ����ܸ��Լ�+-��
				$score = '1';
				$score_cotent .= tep_get_admin_customer_name($login_id).'��'.tep_get_admin_customer_name($info['to_login_id']);
				if($status_value==1){
					$score_cotent.= '��'.$score.'�֣�ԭ�򣺰���ͬ�½�����⣡';
				}else if($status_value==2){
					$score = '-1';
					$score_cotent.= '��'.$score.'�֣�ԭ��û�н�����⣡';
				}
				if($AS->add_pending_score($info['to_login_id'],$score,$score_cotent,'notebook_id',$notebook_id,'1',$login_id, 2,$info['notebook_id'])){
					return $score;	//���سɹ���ӵķ���
				}
			}
		}
		return '';
	}
}
?>
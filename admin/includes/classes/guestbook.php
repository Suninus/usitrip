<?php
/**
 * ���Ա��ֻ࣬���ں�̨�����¹���δ��ӣ������·�ʵʩ���幦�ܡ�
 *
 */
class guestbook {
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
	 * ��ȡĳ�����Ա�����
	 *@param  string $notebook_id (���±�ID)
	 *@return array $arr / false
	*/
	public function getnote($notebook_id){
		global $messageStack;
		$error = false;
		if(!tep_not_null($_GET['notebook_id'])){
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
			$post_array['answer_date']=date('Y-m-d H:i:s');
			$post_array['is_replyed']=1;
			$post_array['answer_login_id']=$this->login_id;
			print_r($post_array);//exit();
			tep_db_fast_update($this->tables, 'notebook_id="'.(int)$post_array['notebook_id'].'" AND is_deleted=0', $post_array,'answer_date,answer_login_id,answer_content,is_replyed,is_finished');
		    $messageStack->add_session('�ظ��ɹ�!','success');
		}		
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
	public function adminList()
	{
	  $data=false;
	  $sql="SELECT admin_id,CONCAT(admin_lastname,' ', admin_firstname,'(',admin_job_number,')') AS admin_name FROM `admin` ORDER BY admin_lastname,admin_firstname";
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
	 * @param array $adminList ����Ա��Ϣ����
	 * @return string $text
	 */
	public function getadminname($admin_id,$adminList){
		if($admin_id=="0" or $admin_id==""){
			return '';
		}
		$n=count($adminList);
		for($i=0;i<$n;$i++){
			if($adminList[$i]['id']==$admin_id){
				return $adminList[$i]['text'];
			}
		}
		return '';
	}
}
?>
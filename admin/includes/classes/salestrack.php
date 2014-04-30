<?php
/**
 * ���۸����ֻ࣬���ں�̨��aben
 */
class salestrack {
	var $login_id;	//��ǰ��¼�Ĺ���Աid
	/**
	 * ���۸��ٵ���������
	 */
	var $tables;
	var $viewall;

	/**
	 * salestrack���캯��
	 *
	 * @param unknown_type $arr
	 * @param ref: boolen $this->viewall (�Ƿ������۸��ٹ���Ա)
	 * @param ref: string $this->tables (���۸�����������)
	 * @param ref: string $this->tb_code_history (���۸���code��ʷ��¼������)
	 * @param ref: string $this->tb_email_history (���۸���email��ʷ��¼������)
	 * @param ref: string $this->tb_item_history (���۸�������������ʷ��¼������)
	 */
	function __construct($arr = array()){
		global $login_id, $messageStack;
		global $can_top_salestrack; /*�����������Ϊtrue,����˿��Կ������˵����۸��ټ�¼,����ֻ�ܿ��Լ���*/
		if(is_array($arr) && count($arr)>0){
			foreach($arr as $key => $value){
				$this->$key = $value;
			}
		}
		$this->login_id = $login_id;
		$this->tables = 'salestrack'; //���Ա�����������
		$this->tb_code_history='salestrack_code_history';
		$this->tb_email_history='salestrack_email_history';
		$this->tb_item_history='salestrack_item_history';

		//$this->viewall �Ƿ��ܿ������˵����۸��ټ�¼
		if($can_top_salestrack === true){
			$this->viewall=true;
		}else{
			$this->viewall=false;
		}

	}

	/**
	 * ��ʾ��ѯ����֮��Ŀ�������
	 * @param none
	 * @return array $data
	 * */
	public function showKeyItem()
	{
		$data=false;
		$data[]=array('id'=>'customer_email','text'=>'����email');
		$data[]=array('id'=>'customer_name','text'=>'��������');
		$data[]=array('id'=>'customer_tel','text'=>'������ϵ�绰');
		$data[]=array('id'=>'customer_mobile','text'=>'�����ֻ�');
		$data[]=array('id'=>'customer_qq','text'=>'����QQ');
		$data[]=array('id'=>'customer_msn','text'=>'����MSN');
		$data[]=array('id'=>'customer_skype','text'=>'����SKYPE');
		return $data;
	}

	/**
	 * �������㲢���¶�������
	 * */
	public function calc_order_owner_batch()
	{
		//$sql ='SELECT a.orders_id FROM( SELECT orders_id,orders_owner_admin_id ,customers_email_address,date_purchased,orders_paid,orders_owners  FROM orders WHERE (orders_owners IS NULL OR orders_owners=\'\') AND (customers_email_address IS NOT NULL ) ) AS a, orders_total AS b  WHERE b.class=\'ot_total\' AND a.orders_id=b.orders_id AND a.orders_paid>=b.value;';
		/*$sql = "select o.orders_id from orders as o,orders_total as ot where ot.class='ot_total' AND o.orders_id = ot.orders_id AND cast(o.orders_paid as decimal) >= cast(ot.value as decimal) AND (o.orders_owners IS NULL OR o.orders_owners = '') AND (o.customers_email_address IS NOT NULL OR o.customers_email_address <> '')";
		$sql_query = tep_db_query($sql);
		$data = false;
		while($rows = tep_db_fetch_array($sql_query))
		{
			//echo $rows['orders_id'],'<br/>';
			tep_db_call_sp('call mysp_autobind_orders_ownerid('.$rows['orders_id'].');');
		}*/
	}

	/**
	*���ݶ����ż��㶩������
	*@para int $orders_id ������
	*@para bool $refix �Ƿ����¼��㶩������
	*@return bool
	*/
	public function fixed_orders_owners($orders_id, $refix = false)
	{
		return ;
		$orders_id=(int)$orders_id;
		$data = false;
		if($orders_id<1){ return false; }
		$sql = 'SELECT orders_owners FROM orders WHERE orders_id='.$orders_id;
		$sql_query = tep_db_query($sql);
		$data = tep_db_fetch_array($sql_query);

		//print_r($data); //return true;
		if(is_array($data))
		{
			$refix_flag = false;/*Ϊtrue�����¼��㶩������*/

			if(strlen($data['orders_owners'])<1) $refix_flag = false;

			if($refix == true ) $refix_flag = true;

			if($refix_flag == true)
			{
				$data2 = false;
				$sql2 = 'CALL mysp_autobind_orders_ownerid('.$orders_id.')';
				$data2 = tep_db_call_sp($sql2);
				/*$sql_query2 = tep_db_call_sp($sql2);
				while($rows = tep_db_fetch_array($sql_query2))
				{
				$data2 = $rows;
				}*/
				//print_r($data2);
			}
			return $refix_flag;
		}
	}


	/**
	 * ͨ��������,���ض�������Ҫ��Ϣ���������۸��ٵ����ϸ������������˹��ж����ο�
	 * @param int $orders_id
	 * @return array $data���� array{array['orders_main'],array['orders_code'],array['salestrack']}2ά����
	 */
	Public function getinfo_forOrdersOwner_check($orders_id)
	{
		$data=false;
		$orders_id=(int)$orders_id;
		if($orders_id<1){ return false; }
		/*������Ҫ��Ϣ*/
		$sql='SELECT customers_email_address,date_purchased,orders_owner_commission,admin_id_orders,orders_owner_admin_id,orders_owners FROM orders WHERE orders_id='.$orders_id;
		$sqlQuery=tep_db_query($sql);
		$data['orders_main'] = tep_db_fetch_array($sqlQuery);

		if(is_array($data['orders_main'])){
			$email=$data['orders_main']['customers_email_address'];
			$purchasedate=$data['orders_main']['date_purchased'];
			/*������·��Ϣ*/
			$sql2="SELECT products_id,products_name,products_model FROM orders_products WHERE orders_id=".$orders_id;
			$sqlQuery2 = tep_db_query($sql2);
			while($rows2 = tep_db_fetch_array($sqlQuery2)){
				$data['orders_code'][]=$rows2;
			}

			/*����֮email��Ӧ�����۸��ٵ���Ҫ��Ϣ*/
			$sql3 = 'SELECT distinct salestrack_id,login_id FROM salestrack_email_history ';
			if($data['orders_main']['orders_owner_commission']==1){
				$sql3 = $sql3.' WHERE email=\''.$email.'\' AND (add_date BETWEEN date_add(\''.$purchasedate.'\',interval -180 day) AND \''.$purchasedate.'\')';
			}
			else{
				$sql3 = $sql3.' WHERE email=\''.$email.'\' AND (add_date BETWEEN date_add(\''.$purchasedate.'\',interval -180 day) AND date_add(\''.$purchasedate.'\',interval 90 day))';
			}
			$sqlQuery3=tep_db_query($sql3);
			while($rows3=tep_db_fetch_array($sqlQuery3)){
				$data['salestrack'][]=$rows3;
			}
			return $data;

		}
		return false;
	}



	/**
	 * ��ȡĳ�����۸��ټ�¼����ϸ��¼
	 * @param  int $salestrack_id (���۸���ID)
	 * @return array $arr{['main']{},['code_history']{},['email_history']{},['item_history']{}} (����2ά����)
	*/
	public function get_st($salestrack_id){
		global $messageStack;
		$error = false;
		if(!tep_not_null($salestrack_id)){
			$error = true;
			$messageStack->add('id����Ϊ�գ�','error');
		}
		$data = false;
		$where = '';
		if(!($this->viewall)){
			$where = ' AND login_id='.$this->login_id;
		}

		if($error==false){
			/*����*/
			$sql='SELECT * FROM '.$this->tables.' WHERE salestrack_id=' . (int)$salestrack_id . $where;
			//echo '<br/>sql:'.$sql;
			$sqlQuery=tep_db_query($sql);
			while($rows = tep_db_fetch_array($sqlQuery)){
				$data['main'][] = $rows;	//���ݼ�¼����
			}
			if(is_array($data['main'])){
				/*code history*/
				$sql_code='SELECT * FROM '.$this->tb_code_history.' WHERE salestrack_id=' . (int)$salestrack_id;
				$sqlQuery_code=tep_db_query($sql_code);
				$rows1=false;
				while($rows1 = tep_db_fetch_array($sqlQuery_code)){
					$data['code_history'][]=$rows1;
				}
				/*email history*/
				$sql_email='SELECT * FROM '.$this->tb_email_history.' WHERE salestrack_id=' . (int)$salestrack_id;
				$sqlQuery_email=tep_db_query($sql_email);
				$rows2=false;
				while($rows2 = tep_db_fetch_array($sqlQuery_email)){
					$data['email_history'][]=$rows2;
				}
				/*other item history*/
				$sql_item='SELECT * FROM '.$this->tb_item_history.' WHERE salestrack_id=' . (int)$salestrack_id;
				$sqlQuery_item=tep_db_query($sql_item);
				$rows3=false;
				while($rows3 = tep_db_fetch_array($sqlQuery_item)){
					$data['item_history'][]=$rows3;
				}

				return $data;
			}
			return false;
		}
	}

	/**
	 * ���ݶ����Ų�ѯ������ص����۸��ټ�¼��ID
	 * ���붩����,�������۸���ID����
	 * @param  int $orders_id (������)
	*/
	public function get_correspond_salestrack_list($orders_id)
	{
		$checkout_date='';
		$email='';
		$data=false;


		return false;
	}


	/**
	 * ��Ҫ��¼�����������ʷ����Ŀ�б�
	 * @param none
	 * @return array $arr(��Ŀ�б�֮����)
	*/
	public function itemList(){
		$arr=false;
		$arr[]=array('key'=>'customer_name','text'=>'��������');
		$arr[]=array('key'=>'customer_tel','text'=>'���˵绰');
		$arr[]=array('key'=>'customer_mobile','text'=>'�ֻ�');
		$arr[]=array('key'=>'customer_qq','text'=>'QQ');
		$arr[]=array('key'=>'customer_msn','text'=>'MSN');
		$arr[]=array('key'=>'customer_skype','text'=>'SKYPE');
		$arr[]=array('key'=>'customer_plan_tdate','text'=>'�ƻ�����ʱ��');
		$arr[]=array('key'=>'next_condate','text'=>'�´���ϵʱ��');
		$arr[]=array('key'=>'customer_info','text'=>'�ͻ���ѯ��Ϣ');
		$arr[]=array('key'=>'orders_id','text'=>'������');
		return $arr;
	}

	/**
	 * ƥ��Ҫ��¼��������Ŀ������
	 * @param  string $key.���۸����м�¼���û�����Ŀ�����ݿ���λ����(Ӣ������)
	 * @return string $string (��Ŀ����)
	*/
	Public function getItemName($key)
	{
		$arr=$this->itemList();
		$n=count($arr);
		for($i=0;$i<$n;$i++){
			if($arr[$i]['key']==$key){
				return $arr[$i]['text'];
			}
		}
		return '';
	}

	/**
	 * �����µ����۸���
	 * @param $post_array Ϊ׼��Ҫ�������ݿ��������$_POST
	 * @param $action Ĭ��Ϊ insert�ǲ��룬update�Ǹ���
	 * @param $update_where Ĭ��Ϊ�գ�����Ǹ������ݿ�����Ҫ��дWHERE֮�������
	 * @return boolen
	 */
	public function addnew($post_array){
		global $messageStack;
		$error = false;
		//�����ж�
		if(!tep_not_null($post_array['customer_name'])){
			$error=true;
			$messageStack->add('��������������д','error');
		}
		if(!tep_not_null($post_array['customer_tel']) AND !tep_not_null($post_array['customer_mobile']) AND !tep_not_null($post_array['customer_email'])
		AND !tep_not_null($post_array['customer_qq']) AND !tep_not_null($post_array['customer_msn']) AND !tep_not_null($post_array['customer_skype'])){
			$error=true;
			$messageStack->add('���˵绰,�ֻ�,E-mail,QQ,MSN,SKYPE����Ҫ��дһ��','error');
		}
		if(!tep_not_null($post_array['customer_info'])){
			$error=true;
			$messageStack->add('���������û���ѯ����','error');
		}
		//��ӵ���������
		if($error==false){
			$tmp_now=date('Y-m-d H:i:s');
			$post_array['add_date'] = $tmp_now;
			$post_array['login_id'] = $this->login_id;
			if(!tep_not_null($post_array['customer_plan_tdate'])){
				$post_array['customer_plan_tdate']=null;
			}
			if(@tep_not_null($post_array['customer_email'])){
				$post_array['email_last_update_date']=$tmp_now;
			}
			//print_r($post_array);
			$insert_id = tep_db_fast_insert($this->tables, $post_array,'');
			if((int)$insert_id){
				//$messageStack->add_session('���ݲ���ɹ�', 'success');	//�������ɹ���������ҳ��ʱ�ô˷�����¼�ɹ���ʾ��Ϣ


				/*$ar_tmp�����洢��ʱ����*/
				$arr_tmp['salestrack_id']=$insert_id;
				$arr_tmp['add_date']=$tmp_now;
				$arr_tmp['login_id']=$this->login_id;
				/*���ǰ̨���ݹ�����code*/
				$arr_code=explode(',',$post_array['code']);

				/*��code��ֺ�ֱ���뵽code history����������д8��*/
				//�����д���ź�̫�����¼һ��־��Ϣ
				if(count($arr_code) > 8){
					$this->error_log($arr_code);
				}

				for($i=0, $n = min(count($arr_code), 8); $i<$n; $i++){
					if(tep_not_null($arr_code[$i])){
						$arr_tmp['code']=$arr_code[$i];
						tep_db_fast_insert($this->tb_code_history,$arr_tmp,'');
					}
				}

				/*�������дemail,���¼���������email history����*/
				if(tep_not_null($post_array['customer_email'])){
					$arr_tmp['email']=$post_array['customer_email'];
					tep_db_fast_insert($this->tb_email_history, $arr_tmp,'code');
				}
				$messageStack->add_session('���ݲ���ɹ�.'.$tmp_now, 'success');	//�������ɹ���������ҳ��ʱ�ô˷�����¼�ɹ���ʾ��Ϣ

				return $insert_id;	//���ر��������notebook_id
			}
			else{
				$error=true;
				$messageStack->add('����ʧ��.'.$tmp_now,'error');
			}
			return true;
		}
		return true; //�ɹ�����trueʧ�ܷ���false
	}

	/**
	 * �������۸��ټ�¼
	 * @param array $post_array
	 * @param int $salestrack_id
	 * @return true/false
	 */
	public function update($post_array,$salestrack_id){
		global $messageStack;
		$error = false;
		//�����ж�
		if(!tep_not_null($post_array['customer_name'])){
			$error=true;
			$messageStack->add('��������������д','error');
		}
		if(!tep_not_null($post_array['customer_tel']) AND !tep_not_null($post_array['customer_mobile']) AND !tep_not_null($post_array['customer_email'])
		AND !tep_not_null($post_array['customer_qq']) AND !tep_not_null($post_array['customer_msn']) AND !tep_not_null($post_array['customer_skype'])){
			$error=true;
			$messageStack->add('���˵绰,�ֻ�,E-mail,QQ,MSN,SKYPE����Ҫ��дһ��','error');
		}
		if(!tep_not_null($post_array['customer_info'])){
			$error=true;
			$messageStack->add('���������û���ѯ����','error');
		}
		$where = '';
		if(!($this->viewall)){
			$where = ' AND login_id='.$this->login_id;
		}
		if($error==false){
			$tmp_now=date('Y-m-d H:i:s');
			$data_old=false;
			/*��ȡԭ��¼,Ȼ��Ƚϱ��������,��ӱ��������ʷ��¼��,�ٸ�������*/
			$sql='SELECT * FROM '.$this->tables.' WHERE salestrack_id=' . (int)$salestrack_id . $where;
			/*��ȡԭ��¼*/
			$sqlQuery=tep_db_query($sql);
			$data_old = tep_db_fetch_array($sqlQuery);
			/* while($rows = tep_db_fetch_array($sqlQuery)){
			$data_old = $rows;	//��ȡԭ��¼
			} */

			//print_r($data_old); echo '<hr/>'; print_r($post_array);
			if(is_array($data_old)){
				$customer_name_old=$data_old['customer_name'];

				/*$ar_tmp�����洢��ʱ����--for�źź�����*/
				$arr_tmp['salestrack_id']=$salestrack_id;
				$arr_tmp['add_date']=$tmp_now;
				$arr_tmp['login_id']=$this->login_id;

				/*������µ��ź�,������µ�code history*/
				if(tep_not_null($post_array['code'])){

					/*���ǰ̨���ݹ�����code*/
					$arr_code=explode(',',$post_array['code']);
					//�����д���ź�̫�����¼һ��־��Ϣ
					if(count($arr_code) > 8){
						$this->error_log($arr_code);
					}
					/*��code��ֺ�ֱ���뵽code history�������8��*/
					for($i=0, $n=min(count($arr_code),8); $i<$n; $i++){
						if(tep_not_null($arr_code[$i])){
							$arr_tmp['code']=$arr_code[$i];
							tep_db_fast_insert($this->tb_code_history,$arr_tmp,'');
						}
					}
				}

				/*���email������,����email history�����Ӽ�¼*/
				if($post_array['customer_email']!=$data_old['customer_email']){
					$arr_tmp['email']=$post_array['customer_email'];
					$id11=tep_db_fast_insert($this->tb_email_history, $arr_tmp,'code');
					//echo $id11; exit();
				}

				//echo '<hr/>'.$tmp_now.'<hr/>';
				//print_r($data_old);

				/*other item history---�ж�������Ŀ�Ƿ��б仯,�����,���¼�����ʷ*/
				$arr_tmp1=false;/*��item history����Ҫ���ж��г�,Ȼ��һһ��ֵ*/
				$arr_tmp1['salestrack_id']=$salestrack_id;
				$arr_tmp1['add_date']=$tmp_now;
				$arr_tmp1['login_id']=$this->login_id;

				$arr_tmp2=$this->itemList();/*��Ҫ�жϵ���Ŀ�б�*/

				//print_r($arr_tmp2); //exit();
				$n1=count($arr_tmp2);
				for($i=0; $i<$n1;$i++){
					$item_name=$arr_tmp2[$i]['key'];
					$old_value=$data_old[$item_name];
					$new_value=$post_array[$item_name];
					//echo '<br/>'.$item_name;
					if($old_value!=$new_value){
						//echo '<br/>'.$item_name.':'.$new_value.', old: '.$old_value;
						$arr_tmp1['item_name']=$item_name;
						$arr_tmp1['old_value']=$old_value;
						$arr_tmp1['new_value']=$new_value;
						tep_db_fast_insert($this->tb_item_history, $arr_tmp1);
					}
				}

				/*��ʼ������������*/
				/*�ź��ۼ�*/
				if(tep_not_null($post_array['code'])){
					if(tep_not_null($data_old['code'])){
						$post_array['code'] = $data_old['code'].','.$post_array['code'];
					}
					else {
						$post_array['code'] = $post_array['code'];
					}
				}
				else{
					$post_array['code'] = $data_old['code'];
				}
				/*���emailû�б�,�򲻱����λemail_last_update_date*/
				if($post_array['customer_email']!=$data_old['customer_email']){
					$post_array['email_last_update_date']=$tmp_now;
				}else{
					$post_array['email_last_update_date']=$data_old['email_last_update_date'];
				}
				$where =' salestrack_id='.$salestrack_id;

				$rows_effected=tep_db_fast_update($this->tables, $where, $post_array);
				if((int)$rows_effected){
					$error=false;
					//$messageStack->add('���۸��ټ�¼���³ɹ�', 'success');
					$messageStack->add_session('���۸��ټ�¼���³ɹ�. '.$tmp_now,'success');
				}
				//print_r($post_array);

				return $rows_effected;

			}
			return false;
		}
		return true; //�ɹ�����trueʧ�ܷ���false
	}


	/**
	 * ɾ��һ����������۸��ټ�¼
	 * @param unknown_type $notebook_ids �����ǵ�������id��������(array)$_POST['notebook_ids'] �� 
	 
	public function delete($notebook_ids){		
		global $messageStack;
		$error = false;
		return false;
	}*/


	/**
	 * ���������г����۸������ݣ����������false
	 *
	 * @param unknown_type $tables Ҫ��ȡ�����ݱ�,��ȡ���,�� table1_1 t1, table_2 t2
	 * @param unknown_type $fields Ҫ��ȡ���ֶΣ�Ĭ��Ϊ*
	 * @param unknown_type $where ������Ĭ��Ϊ1
	 * @param unknown_type $group_by Ĭ��Ϊ�� GROUP BY �����ݣ��� GROUP BY abc
	 * @param unknown_type $order_by ����ʽĬ��Ϊ�ա���ORDER BY t1.t_it DESC
	 * @return unknown array $data or false	����$data['splitPages']Ϊ���ݵķ�ҳ��Ϣ
	 */
	public function getlists($tables ='', $fields = '*', $where='',$group_by='',$order_by=''){

		$data = false;
		if(!tep_not_null($tables)){
			$tables = $this->tables;
		}
		$pageMaxRowsNum = 10; //ÿҳ��ʾ10����¼
		$sql = 'SELECT '.$fields.' FROM '.$tables.' where '.$where.$group_by.$order_by;
		//echo $sql;
		$keywords_query_numrows = 0;
		$_split = new splitPageResults($_GET['page'], $pageMaxRowsNum, $sql, $keywords_query_numrows);
		//var_dump($_split); exit;
		$data['splitPages']['count'] = $_split->display_count($keywords_query_numrows, $pageMaxRowsNum, (int)$_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS);//��ҳ����,��ʾ����
		$data['splitPages']['links'] = $_split->display_links($keywords_query_numrows, $pageMaxRowsNum, MAX_DISPLAY_PAGE_LINKS, (int)$_GET['page'],tep_get_all_get_params(array('page','y','x', 'action'))); ;//��ҳ���ݷ�ҳ
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

	/**
	 * �ֶ��޸Ķ���������
	 * @para int $orders_id������
	 * @para string $orders_owners �ͷ�����,����Զ��Ÿ���
	 * @return unknown array $data or false
	 */
	public function edit_orders_owners($orders_id,$orders_owners,$login_id)
	{
		$datetime = date('Y-m-d H:i:s');
		//ɾ���ɵ�
		$sql = 'UPDATE `orders_owner_detail` SET is_deleted=1 WHERE orders_id='.$orders_id.' AND is_deleted=0';
		//�����µĶ���������¼����ϸ�� (bug: ����µ�û�н��,���ܼ�¼��˭�������¼����յ�)
		$sql2 = 'INSERT INTO `orders_owner_detail`(orders_id,owner_login_id,add_date,is_deleted,add_login_id) SELECT '.$orders_id.' AS orders_id, admin_id,\''.$datetime.'\' AS ad_date,0,'.$login_id.' AS add_login_id FROM `admin` WHERE admin_job_number IN('.$orders_owners.')';
		//���¶�������֮��������
		$sql3 = 'UPDATE `orders` SET orders_owners =(SELECT GROUP_CONCAT(admin_id) AS admin_job_number FROM `admin` WHERE admin_job_number IN('.$orders_owners.')) WHERE orders_id='.$orders_id;

		//echo $sql2.'<hr/>'; echo $sql3;

		tep_db_query($sql);
		tep_db_query($sql2);
		tep_db_query($sql3);
	}

	/**
	 * ���ݶ������г������������޸���ʷ
	 * @param int $orders_id������
	 * @return array $data or false
	 */
	public function show_edit_history($orders_id)
	{
		$data = false;
		$sql = 'SELECT owner_login_id,add_date,is_deleted,add_login_id FROM `orders_owner_detail` WHERE orders_id='.$orders_id;
		$sql_query =  tep_db_query($sql);
		while( $rows = tep_db_fetch_array($sql_query) )
		{
			$data[] = $rows;
		}
		return $data;
	}

	/**
	*�г�admin���б�
	*@param none
	*@return array $arr (����Ա�б�֮����)
	*/
	public function admin_list()
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

	/**
	 * ƥ��admin������,ͨ������,���ٷ������ݿ�Ĵ���.
	 * @param  int $admin_id (��̨ID)
	 * @param  array $admin_list (��̨����Ա��Ϣ����)
	 * @return string $string (����Ա����)
	 */
	public function get_admin_name($admin_id,$admin_list){
		if($admin_id=="0" or $admin_id==""){
			return '';
		}
		$n=count($admin_list);
		for($i=0;$i<$n;$i++){
			if($admin_list[$i]['id']==$admin_id){
				return $admin_list[$i]['text'];
			}
		}
		return '';
	}

	/**
	 * ��¼������־�ҳ���������
	 * @param array $code_array
	 */
	private function error_log(array $code_array){
		$error_log_file = DIR_FS_CATALOG.'tmp/max_code_log.txt';
		$error_notes.= 'date:'.date("Y-m-d H:i:s")." login_id:".$this->login_id."\n";
		$error_notes.= print_r($code_array, true)."\n";
		if($handle = fopen($error_log_file, 'ab')){
			fwrite($handle, $error_notes);
			fclose($handle);
		}
	}
}
?>
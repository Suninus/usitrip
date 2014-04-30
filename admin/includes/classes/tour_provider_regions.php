<?php
/**
 * ��Ʒ��Ӧ�̵��ϳ���ַ��
 * �����˱༭����ӡ�ɾ�����б����Ϣ
 */
class tour_provider_regions{
	/**
	 * �������ݱ�
	 * $postData['���ֶ���'] = ����ֵ
	 * @param unknown_type $postData
	 */
	function insert($postData, $message_type='session'){
		global $messageStack;
		$action = 'insert';
		return $this->insert_ro_update($action, $postData,$message_type);
	}
	/**
	 * ��������
	 * $postData['���ֶ���'] = ����ֵ
	 * @param unknown_type $postData
	 * @return unknown
	 */
	function update($postData, $message_type='session'){
		global $messageStack;
		$action = 'update';
		return $this->insert_ro_update($action, $postData, $message_type);
	}
	
	function insert_ro_update($action, $postData){
		global $messageStack;
		if($postData['region'] != ''){
			$region	= $postData['region'];
		}else{
			$region	= $postData['region_combo'];
		}
		if(preg_match('/(a|p)m/i',$postData['departure_time']) && substr($postData['departure_time'],0,-2)>='13:00'){ //���ʱ��>=13:00ͬʱ����am��pm�����۵ľ�ȥ��am,pm
			$postData['departure_time'] = substr($postData['departure_time'],0,-2);
		}
		$sql_data_array = array('agency_ids' => tep_db_prepare_input(implode(',',(array)$postData['agency_ids'])),
								'region' => tep_db_prepare_input($region),
								'address' => tep_db_prepare_input($postData['address']),
								'full_address' => tep_db_prepare_input($postData['full_address']),
								//'departure_time' => date('h:ia',strtotime(strtolower(preg_replace('/[[:space:]]+/','',$postData['departure_time'])))),
								'departure_time' => date('h:ia',strtotime(strtolower(preg_replace('/[[:space:]]+/','',date('Y-m-d ').$postData['departure_time'])))),
								'map_path' => tep_db_prepare_input($postData['map_path']),
								'departure_tips' => tep_db_prepare_input($postData['departure_tips']),
								'products_hotels_ids' => tep_db_prepare_input($postData['products_hotels_ids'])
								);

		if ($action == 'insert') {
			tep_db_perform(TABLE_TOUR_PROVIDER_REGIONS, $sql_data_array);
			$tour_provider_regions_id = tep_db_insert_id();
			if($message_type=='session'){
				$messageStack->add_session('�ϳ���ַ��ӳɹ�','success');
			}else {
				$messageStack->add('�ϳ���ַ��ӳɹ�','success');
			}
			return $tour_provider_regions_id;
		} elseif ($action == 'update') {
			tep_db_perform(TABLE_TOUR_PROVIDER_REGIONS, $sql_data_array, 'update', "tour_provider_regions_id ='".$postData['tour_provider_regions_id']."'");
			if($message_type=='session'){
				$messageStack->add_session('�ϳ���ַ���³ɹ�','success');
			}else {
				$messageStack->add('�ϳ���ַ���³ɹ�','success');
			}
			return $postData['tour_provider_regions_id'];
		}
		return false;
	}
	/**
	 * ɾ���ϳ���ַ
	 *
	 * @param unknown_type $tour_provider_regions_id
	 */
	function delete($tour_provider_regions_id){
		global $messageStack;
		$messageStack->add_session('�ϳ���ַɾ���ɹ�','success');
		tep_db_query("delete from " . TABLE_TOUR_PROVIDER_REGIONS . " where tour_provider_regions_id  = '" . (int)$tour_provider_regions_id  . "'");
		return $tour_provider_regions_id;
	}
	
	/**
	 * �г��б����ݣ�������ҳ����
	 *
	 * @param unknown_type $where
	 * @param unknown_type $order_by
	 */
	/* ��ʱ����Ҫ
	function lists($where, $order_by){
		
	}*/
}
?>
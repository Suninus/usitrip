<?php
/**
 * ͼƬ�������
 */

class picture_db{
	function __construct(){

	}

	/**
	 * ����ͼ�滻��ͼƬ
	 *
	 * @param unknown_type $imageDir 
	 */
	public function replaceImage(&$messageStack,$imageDir){
		if(!tep_not_null($imageDir)) return false;
		$data = false;
		$tmp_array = explode(';',$_POST['upload_all_picture']);
		$_n = 0;
		foreach((array)$tmp_array as $key => $val){
			$_array = explode('|',$val);
			if(sizeof($_array)==6){
				if((int)$_array[0] == 1 && tep_not_null($_array[3]) && tep_not_null($_array[4])){
					$data[$_n]['picture_name'] = $_POST['picture_name'];
					$data[$_n]['picture_dir_file'] = $_array[3];
					$data[$_n]['picture_url'] = $_array[4];
					$data[$_n]['picture_url_thumb'] = $_array[5];
					rename($data[$_n]['picture_dir_file'],$imageDir);
					rename(str_replace('detail_','thumb_',$data[$_n]['picture_dir_file']), str_replace('detail_','thumb_',$imageDir));
					@rename(str_replace('detail_','no_watermark_',$data[$_n]['picture_dir_file']), str_replace('detail_','no_watermark_',$imageDir));
					if((int)$_POST['add_watermark']===1){	//��ˮӡ
						$this->addWatermark($imageDir);
					}
					
					tep_db_fast_update('picture', 'picture_dir_file="'.$imageDir.'"',$data[$_n],'picture_name');
					$messageStack->add_session('��ϲ��ͼƬ���³ɹ���', 'success');
					break; //��ͼƬֻ�ܻ�1��
				}
			}
		}
		return $data;
	}

	/**
	 * �ϴ���ѹ��ͼƬ�����ַ�����JS����
	 *
	 * @param unknown_type $imageDir ͼƬ����λ�ã�Ĭ��������ļ�ֱ���ϴ���/images/picture/
	 * @param unknown_type $http_url ͼƬ��URLĿ¼
	 * @param $to_name Ҫ�����ͼƬ���ƣ�ֻ���ڵ���ͼƬ����ʱ����Ҫָ������ļ���
	 */
	public function uploadImage($imageDir='',$http_url='',$to_name=''){
		/*����ͼƬ�ļ�·��*/
		if($imageDir =='') $imageDir = DIR_FS_DOCUMENT_ROOT.'images/picture/';
		if($http_url =='') $http_url = IMAGES_HOST.'/images/picture/';
		if(!file_exists($imageDir)){
			die("The file $imageDir does not exist");
		}
		//�ϴ���ѹ��ͼƬ {
		$tmp_microtime = time();
		$new_name = 'detail_'.mt_rand(0,9).'_'.$tmp_microtime;
		if($to_name != ''){
			$new_name = $to_name;
		}

		$headers = getallheaders();
		//$a = print_r($headers,true);
		//$a.= print_r($GLOBALS,true);
		//return $a;

		$exc_name = preg_replace('/^.*\./','.',$headers['Image-Name']);
		/*�ϴ����ļ�����*/
		$new_name .= strtolower($exc_name);

		$image_name = $imageDir.$new_name;
		$file = fopen($image_name, 'wb');
		if(fwrite($file, $GLOBALS['HTTP_RAW_POST_DATA'])=== FALSE){
			return "0";
			exit();
		}

		//��������ͼ
		imageCompression($image_name,150, str_replace('detail_','thumb_',$image_name));
		fclose($file);

		return "1"."|".$new_name."|".$imageDir."|".$image_name."|".$http_url.$new_name."|".$http_url.str_replace('detail_','thumb_',$new_name);
		//״̬��  	|       �ļ��� |  Ŀ¼��      |ȫ����Ŀ¼+�ļ���|ͼƬ��ַ             	|ͼƬ����ͼ��ַ
		//�ϴ���ѹ��ͼƬ }
	}
	/**
	 * дͼƬ���ϵ����ݿ�
	 *
	 * @param unknown_type $messageStack ������ʾ����
	 * @return unknown
	 */
	public function insert(&$messageStack){
		//д���ϵ����ݿ� {
		if(!tep_not_null($_POST['upload_all_picture'])){
			$messageStack->add_session('�Բ�����û���ϴ��κ�ͼƬ��', 'error');
			return 'error';
			//tep_redirect(tep_href_link('picture_db.php'));
		}

		$data = false;
		$tmp_array = explode(';',$_POST['upload_all_picture']);
		$_n = 0;
		foreach((array)$tmp_array as $key => $val){
			$_array = explode('|',$val);
			if(sizeof($_array)==6){
				if((int)$_array[0] == 1 && tep_not_null($_array[3]) && tep_not_null($_array[4])){
					$data[$_n]['countries_id'] = $_POST['countries_id'];
					$data[$_n]['picture_name'] = $_POST['picture_name'];
					$data[$_n]['zone_id'] = $_POST['zone_id'];
					$data[$_n]['city_id'] = $_POST['city_id'];
					$data[$_n]['added_time'] = date('Y-m-d H:i:s');
					$data[$_n]['added_admin'] = $_SESSION['login_id'];

					$data[$_n]['picture_dir_file'] = $_array[3];
					$data[$_n]['picture_url'] = $_array[4];
					$data[$_n]['picture_url_thumb'] = $_array[5];
					//���ݹ��ҡ���ʡ���������¸�ʽ��ͼƬ�� start{
					$format_name = true;
					if($format_name == true){
						$ex_name = '';
						if(file_exists($data[$_n]['picture_dir_file']) && ((int)$_POST['countries_id'] || (int)$_POST['zone_id'] || (int)$_POST['city_id'])){
							$ex_name = '_'.str_replace(' ','-', strtolower(tep_get_country_iso_code_2((int)$_POST['countries_id'])).'_'.strtolower(tep_get_zone_code_from_zone((int)$_POST['zone_id'])).'_'.strtolower(tep_get_tour_city_code((int)$_POST['city_id'])) );
							$_strrpos = strrpos($data[$_n]['picture_dir_file'],'.');
							if($_strrpos!==false){
								$new_address = substr($data[$_n]['picture_dir_file'],0,$_strrpos) . $ex_name. substr($data[$_n]['picture_dir_file'],$_strrpos);
								rename($data[$_n]['picture_dir_file'], $new_address);
								rename(str_replace('detail_','thumb_',$data[$_n]['picture_dir_file']), str_replace('detail_','thumb_',$new_address));
								@rename(str_replace('detail_','no_watermark_',$data[$_n]['picture_dir_file']), str_replace('detail_','no_watermark_',$new_address));
								
								$data[$_n]['picture_dir_file'] = $new_address;

								$_strrpos = strrpos($data[$_n]['picture_url'],'.');
								$data[$_n]['picture_url'] = substr($data[$_n]['picture_url'],0,$_strrpos) . $ex_name. substr($data[$_n]['picture_url'],$_strrpos);

								$_strrpos = strrpos($data[$_n]['picture_url_thumb'],'.');
								$data[$_n]['picture_url_thumb'] = substr($data[$_n]['picture_url_thumb'],0,$_strrpos) . $ex_name. substr($data[$_n]['picture_url_thumb'],$_strrpos);
								if((int)$_POST['add_watermark']===1){	//��ˮӡ
									$this->addWatermark($data[$_n]['picture_dir_file']);
								}
							}

						}
					}
					//���ݹ��ҡ���ʡ���������¸�ʽ��ͼƬ�� end}
					$_n++;
				}
			}
		}
		if(is_array($data)){
			for($i = 0, $n = sizeof($data); $i < $n; $i++){
				if(file_exists($data[$i]['picture_dir_file'])){
					$picture_id = tep_db_fast_insert('`picture`', $data[$i]);
				}
			}

			$messageStack->add_session('��ϲ��ͼƬд�뵽���ݿ�ɹ���', 'success');
			return 'success';
			//tep_redirect(tep_href_link('picture_db.php'));
		}
		//д���ϵ����ݿ� }
	}

	/**
	 * ɾ��ͼƬ
	 *
	 * @param unknown_type $picture_id
	 * @return ���ر�ɾ����ͼƬ��Ŀ
	 */
	public function delete($picture_id){
		$delNum = 0;
		$sql = tep_db_query('SELECT picture_dir_file FROM `picture` WHERE picture_id ="'.(int)$picture_id.'" ');
		$row = tep_db_fetch_array($sql);
		if(tep_not_null($row['picture_dir_file'])){
			if(@unlink($row['picture_dir_file'])===true){
				@unlink(str_replace('/detail_','/thumb_',$row['picture_dir_file']));
				@unlink(str_replace('/detail_','/no_watermark_',$row['picture_dir_file']));
				tep_db_query('DELETE FROM `picture` WHERE picture_id ="'.(int)$picture_id.'" ');
				$delNum++;
			}
		}
		return $delNum;
	}

	/**
	 * ͼƬ���б�
	 *
	 * @param unknown_type $splitPage �Ƿ���Ҫ��ҳ���ܣ�Ĭ���ǲ���Ҫ�ġ�
	 * @return unknown
	 */
	public function lists($splitPage = false){
		$data = false;
		//ȡ��ͼƬ���� start{
		$field = ' pi.* ';
		$table = ' picture pi ';
		$where = ' where 1 ';
		$group_by = '';
		$order_by = 'order by pi.picture_id desc ';
		if((int)$_GET['countries_id']){
			$where .= ' AND pi.countries_id = '.(int)$_GET['countries_id'];
		}
		if((int)$_GET['zone_id']){
			$where .= ' AND pi.zone_id = '.(int)$_GET['zone_id'];
		}
		if((int)$_GET['city_id']){
			$where .= ' AND pi.city_id = '.(int)$_GET['city_id'];
		}
		if(tep_not_null($_GET['picture_name'])){
			$where .= ' AND pi.picture_name like "%'.tep_db_input(tep_db_prepare_input($_GET['picture_name'])).'%" ';
		}
		if(tep_not_null($_GET['city_name'])){
			$str_sql='select city_id from tour_city where city like "%'.$_GET['city_name'].'%"';
			//echo $str_sql;
			$sql_query=tep_db_query($str_sql);
			$sql_add='';
			while($tmp=tep_db_fetch_array($sql_query)){
				$sql_add.=','.$tmp['city_id'];
			}
			if($sql_add)
			$where.=' and pi.city_id in('.substr($sql_add, 1).')';
// 			echo $sql_add;
		}
		$sql_str = 'SELECT '.$field.' FROM '.$table.' '.$where.' '.$group_by.' '.$order_by;
		$picture_query_numrows = 0;
		if($splitPage != false){
			$picture_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_ADMIN, $sql_str, $picture_query_numrows);
		}
		$picture_query = tep_db_query($sql_str);
		while($picture_rows = tep_db_fetch_array($picture_query)){
			$data[] = $picture_rows;
		}
		if(is_array($data) && isset($picture_split)){
			$data['splitPageResults']['display_count'] = $picture_split->display_count($picture_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ADMIN, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS);
			$data['splitPageResults']['display_links'] = $picture_split->display_links($picture_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ADMIN, MAX_DISPLAY_PAGE_LINKS, $_GET['page'],tep_get_all_get_params(array('page','y','x', 'action')));

		}
		//ȡ��ͼƬ���� end}
		return $data;
	}

	/**
	 * ��ͼƬ����ȡ���Ѿ�ʹ���˸�ͼƬ�Ĳ�ƷIDs
	 *
	 * @param unknown_type $picture_id ͼƬid
	 */
	public function getProductsIds($picture_id){
		$products_ids = false;
		$sql = tep_db_query('SELECT picture_url, picture_url_thumb FROM `picture` WHERE picture_id="'.(int)$picture_id.'" ');
		$row = tep_db_fetch_array($sql);		
		if(tep_not_null($row['picture_url'])){
			$products_ids = $this->getProductsIdsFromImageUrl($row['picture_url']);
		}
		if(tep_not_null($row['picture_url_thumb'])){
			if(is_array($products_ids) && sizeof($products_ids)>0){
				$_tmp = $this->getProductsIdsFromImageUrl($row['picture_url_thumb']);
				$products_ids = array_merge($products_ids,(array)$_tmp );
			}else{
				$products_ids = $this->getProductsIdsFromImageUrl($row['picture_url_thumb']);
			}
		}
		if(is_array($products_ids)){
			$products_ids = array_unique($products_ids);
		}
		return $products_ids;
	}

	/**
	 * ����ͼƬurlȡ�ò�ƷIDs
	 *
	 * @param unknown_type $url
	 */
	private function getProductsIdsFromImageUrl($url){
		$products_ids = false;
		$p_where_str = ' products_image ="[S]" || products_image_med ="[S]" || products_image_lrg ="[S]" || products_image_sm_1 ="[S]" ||	products_image_xl_1 ="[S]" || products_image_sm_2 ="[S]" || products_image_xl_2 || products_image_sm_3 || products_image_xl_3 ="[S]" || products_image_sm_4 ="[S]" || products_image_xl_4 ="[S]" ';
		$pe_where_str = ' product_image_name ="[S]" ';
		$pt_where_str = ' travel_img ="[S]" ';
		
		if(tep_not_null($url)){
			//���Ʒ��
			$pSql = tep_db_query('SELECT products_id FROM `products` WHERE '.str_replace('[S]',$url,$p_where_str));
			while ($pRows = tep_db_fetch_array($pSql)) {
				if((int)$pRows['products_id']){
					$products_ids[] = $pRows['products_id'];
				}
			}
			//���Ʒ��չͼƬ��
			$peSql = tep_db_query('SELECT products_id FROM `products_extra_images` WHERE '.str_replace('[S]',$url,$pe_where_str));
			while ($peRows = tep_db_fetch_array($peSql)) {
				if((int)$peRows['products_id']){
					$products_ids[] = $peRows['products_id'];
				}
			}
			//���Ʒ�г̱�
			$ptSql = tep_db_query('SELECT products_id FROM `products_travel` WHERE '.str_replace('[S]',$url,$pt_where_str));
			while ($ptRows = tep_db_fetch_array($ptSql)) {
				if((int)$ptRows['products_id']){
					$products_ids[] = $ptRows['products_id'];
				}
			}			
		}
		if(is_array($products_ids)){
			$products_ids = array_unique($products_ids);
		}
		return $products_ids;
	}
	

	/**
	 * ��ͼƬ���ˮӡ
	 *
	 * @param unknown_type $image_name ��ͼ·��
	 * @param unknown_type $watermark_name ˮӡͼƬ·����������pngͼƬ��ˮӡ
	 */
	private function addWatermark($image_name){
		$watermark_name = DIR_FS_CATALOG."image/watermark/black.png";
		copy($image_name,str_replace('detail_','no_watermark_',$image_name));	//����û��ˮӡ��ͼ
		$make_action = makeCopyrightLwk($image_name, $watermark_name,9,100);			
	}

}

?>
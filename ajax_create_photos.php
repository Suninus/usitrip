<?php
/*AJAX д��Ƭ���μǵ����ݿ�*/
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );

require_once('includes/application_top.php');
header("Content-type: text/html; charset=".CHARSET);

//����û�
if(!tep_session_is_registered('customer_id') || !(int)$customer_id){
	echo db_to_html('[ERROR]�����µ�¼�˺ţ�[/ERROR]');
	exit;
}

//ɾ����Ƭ���� start
if($_GET['action']=='remover_comments' && $error == false){
	if((int)$_GET["comments_id"]){
		tep_db_query('UPDATE photo_comments SET has_remove="1" WHERE photo_comments_id="'.(int)$_GET["comments_id"].'" ');
		$comments_sql = tep_db_query('SELECT count(*) as total FROM `photo_comments` WHERE photo_id="'.(int)$_GET["photo_id"].'" and has_remove!="1" ');
		$comments = tep_db_fetch_array($comments_sql);
		$sms = '[JS] var aid = "#comments_'.(int)$_GET["comments_id"].'"; $(aid).fadeOut(1200); $("#comments_num").text("'.$comments['total'].'"); [/JS]';
		echo db_to_html($sms);
	}
	exit;
}
//ɾ����Ƭ���� end

//ɾ���μ� start
if($_GET['action']=='del_travel_notes' && $error == false){
	//�����ܲ�ɾ���μ����漰������Ƭ����Ƭ�ɵ������ɾ������ֻɾ���μǼ��μǵ�����
	if(!(int)$_GET["travel_notes_id"]){  echo db_to_html('��travel_notes_id'); exit; }
	$notes_query = tep_db_query('SELECT travel_notes_id, photo_ids FROM `travel_notes` WHERE travel_notes_id = "'.(int)$_GET["travel_notes_id"].'" and customers_id="'.(int)$customer_id.'" ');
	$notes = tep_db_fetch_array($notes_query);
	if((int)$notes['travel_notes_id']){
		tep_db_query('DELETE FROM `travel_notes_comments` WHERE `travel_notes_id` = "'.$notes['travel_notes_id'].'" ');	//�μ�����
		tep_db_query('DELETE FROM `travel_notes` WHERE `travel_notes_id` = "'.$notes['travel_notes_id'].'" ');	//�μ�
		
		$notes_content = '�μ�ɾ���ɹ���';
		$out_time = 2; //�ӳ�2��ر�
		$tpl_content = file_get_contents(DIR_FS_CONTENT . 'html_tpl/'.'out_time_notes.tpl.html');
		$tpl_content = str_replace('{notes_content}',$notes_content,$tpl_content);
		$tpl_content = str_replace('{out_time}',$out_time,$tpl_content);
		
		$sms = '
		$("#content").html("");
		var gotourl = "'.tep_href_link('individual_space.php').'";
		var notes_contes = "'.addslashes($tpl_content).'";
		write_success_notes('.$out_time.', notes_contes, gotourl);
		
		';
		$sms = '[JS]'.preg_replace('/[[:space:]]+/',' ',$sms).'[/JS]';
		echo db_to_html($sms);
	}
	exit;
}
//ɾ���μ� end

//ɾ����Ƭ start
if($_GET['action']=='del' && $error == false){
	//�ȼ��ԭ��Ƭ�ϴ���
	$check_sql = tep_db_query('select photo_id, photo_books_id, photo_name  from photo where photo_id ="'.(int)$_GET['photo_id'].'" and customers_id="'.$customer_id.'" ');
	$check_row = tep_db_fetch_array($check_sql);
	if((int)$check_row['photo_id']){
	//echo '[JS]alert("'.$check_row['photo_id'].':::'.$customer_id.'");[/JS]';
	//exit;
		@unlink(DIR_PHOTOS_FS_IMAGES.tep_db_output($check_row['photo_name']));	//ɾ����ͼ
		@unlink(DIR_PHOTOS_FS_IMAGES."thumb_".tep_db_output($check_row['photo_name']));	//ɾ��������ͼ
		tep_db_query('DELETE FROM `photo` WHERE `photo_id` = "'.$check_row['photo_id'].'" ');
		tep_db_query('UPDATE `photo_books` SET photo_sum=(photo_sum-1) WHERE `photo_books_id` = "'.$check_row['photo_books_id'].'" ');
		tep_db_query('DELETE FROM `photo_comments` WHERE `photo_id` = "'.$check_row['photo_id'].'" ');
		
		if($_GET['form_type']=="travel_notes_detail"){	//���μ���ϸ������ɾ��
			$sms = '
			$("#PicBlock_'.$check_row['photo_id'].'").hide(500);
			';
		}else{	//����������ɾ��
			$sms = '
			$("#content").html("");
			';
			
			$notes_content = '��Ƭɾ���ɹ���';
			$out_time = 2; //�ӳ�2��ر�
			$tpl_content = file_get_contents(DIR_FS_CONTENT . 'html_tpl/'.'out_time_notes.tpl.html');
			$tpl_content = str_replace('{notes_content}',$notes_content,$tpl_content);
			$tpl_content = str_replace('{out_time}',$out_time,$tpl_content);
			
			$sms .= '
			var gotourl = "'.tep_href_link('photo_list.php','photo_books_id='.(int)$check_row['photo_books_id']).'";
			var notes_contes = "'.addslashes($tpl_content).'";
			write_success_notes('.$out_time.', notes_contes, gotourl);
			
			';
		}
		
		$sms = '[JS]'.preg_replace('/[[:space:]]+/',' ',$sms).'[/JS]';
		echo db_to_html($sms);
	}
	exit;
}
//ɾ����Ƭ end

//�༭��Ƭ start
if($_GET['action']=='update' && $error == false && $_POST['update_photo_action']=="true"){
    $photo_name = tep_db_prepare_input($_POST['photo_name']);
	$photo_title = tep_db_prepare_input($_POST['photo_title']);
	$photo_content = tep_db_prepare_input($_POST['photo_content']);
	//�ȼ��ԭ��Ƭ����
	$check_sql = tep_db_query('select photo_name,photo_books_id from photo where photo_id ="'.(int)$_POST['photo_id'].'" ');
	$check_row = tep_db_fetch_array($check_sql);
	$old_photo_name = tep_db_output($check_row['photo_name']);
	$photo_books_id = (int)$check_row['photo_books_id'];
	
	$sql_data_array = array('photo_title' => ajax_to_general_string($photo_title),
							'photo_content' => ajax_to_general_string($photo_content),
							'photo_name' => $photo_name,
							'photo_update' => date('Y-m-d H:i:s'));
	@rename(DIR_FS_CATALOG.'tmp/'.$photo_name, DIR_PHOTOS_FS_IMAGES.$photo_name);
	$sql_data_array = html_to_db($sql_data_array);
	tep_db_perform('photo', $sql_data_array, 'update', ' photo_id="'.(int)$_POST['photo_id'].'" and customers_id="'.(int)$customer_id.'" ');
	out_thumbnails(DIR_PHOTOS_FS_IMAGES.$photo_name, DIR_PHOTOS_FS_IMAGES."thumb_".$photo_name, 145, 109);
	//$messageStack->add_session('update_photos', db_to_html('������Ƭ���³ɹ���').$photo_name, 'success');
	if($old_photo_name!=$photo_name && tep_not_null($old_photo_name)){
		@unlink(DIR_PHOTOS_FS_IMAGES.$old_photo_name);	//ɾ����ͼ
		@unlink(DIR_PHOTOS_FS_IMAGES."thumb_".$old_photo_name);	//ɾ��������ͼ
	}
	
	//����Ƭд��������
	if($_POST['set_cover']=="1"){
		tep_db_query('UPDATE `photo_books` SET `photo_books_cover` = "'.$photo_name.'" WHERE `photo_books_id` = "'.$photo_books_id.'" LIMIT 1 ;');
	}
	
	$img_wh = explode('@',getimgHW3hw_wh(DIR_PHOTOS_FS_IMAGES.$photo_name,500,375));
	
	$sms = '
	var Submit_Photo_Button = document.getElementById("submit_photo_button"); if(Submit_Photo_Button!=null){ Submit_Photo_Button.disabled = false;} 
	closeDiv("EditPotoDiv");
	$("#photo_title").hide();
	$("#photo_content").hide();
	$("#big_pic").hide();
	$("#load_icon").css({display: "none" });
	$("#photo_title").html("'.tep_db_output(html_to_db(ajax_to_general_string($photo_title))).'");
	$("#photo_title").slideDown(600);
	$("#photo_content").html("'.nl2br(tep_db_output(html_to_db(ajax_to_general_string($photo_content)))).'");
	$("#photo_content").slideDown(600);
	$("#big_pic").attr("src","images/photos/'.$photo_name.'");
	$("#big_pic").attr("width","'.$img_wh[0].'");
	$("#big_pic").attr("height","'.$img_wh[1].'");
	$("#big_pic").fadeIn(600);
	$("#href_big_pic").attr("herf","images/photos/'.$photo_name.'");
	';
	$sms = '[JS]'.preg_replace('/[[:space:]]+/',' ',$sms).'[/JS]';
	echo db_to_html($sms);
	exit;
}
//�༭��Ƭ end

//�����Ƭ start
if($_GET['action']=='process' && $error == false){
	if(is_array($_POST['photo_name'])){
		$photo_ids = array();
		for($i=0; $i<count($_POST['photo_name']); $i++){
			if(tep_not_null($_POST['photo_name'][$i]) && preg_match('/\./',$_POST['photo_name'][$i])){
				$photo_name = tep_db_prepare_input($_POST['photo_name'][$i]);
				$photo_title = tep_db_prepare_input($_POST['photo_title'][$i]);
				$photo_content = tep_db_prepare_input($_POST['photo_content'][$i]);
				$photo_books_id = (int)$_POST['photo_books_id'];
				$products_id = (int)$_POST['products_id'];
				if(ajax_to_general_string($photo_title) == db_to_html('��������Ƭ����')){
					$photo_title = db_to_html($photo_name);
				}
				if(ajax_to_general_string($photo_content) == db_to_html('���������Ƭ�����������ε��˵����������Լ��������š�')){
					$photo_content = db_to_html($photo_name);
				}
				
				$sql_data_array = array('photo_title' => ajax_to_general_string($photo_title),
										'photo_content' => ajax_to_general_string($photo_content),
										'photo_name' => $photo_name,
										'photo_books_id' => $photo_books_id,
										'products_id' => $products_id,
										'customers_id' => (int)$customer_id,
										'photo_update' => date('Y-m-d H:i:s'));
				@rename(DIR_FS_CATALOG.'tmp/'.$photo_name, DIR_PHOTOS_FS_IMAGES.$photo_name);
				$sql_data_array = html_to_db($sql_data_array);
				tep_db_perform('photo', $sql_data_array);
				$photo_ids[] = tep_db_insert_id();
				
				//����Ƭд��������(������Ϊ��ʱ)
				$ck_sql = tep_db_query('SELECT photo_books_cover FROM photo_books WHERE `photo_books_id` = "'.$photo_books_id.'" Limit 1');
				$ck_row = tep_db_fetch_array($ck_sql);
				if(!tep_not_null($ck_row['photo_books_cover'])){
					tep_db_query('UPDATE `photo_books` SET `photo_books_cover` = "'.$photo_name.'" WHERE `photo_books_id` = "'.$photo_books_id.'" LIMIT 1 ;');
				}
				//��������ͼ
				out_thumbnails(DIR_PHOTOS_FS_IMAGES.$photo_name, DIR_PHOTOS_FS_IMAGES."thumb_".$photo_name, 145, 109);
				$messageStack->add_session('create_photos', db_to_html('���������ϴ��ɹ���').$photo_name, 'success');
			}
		}
		//�������ӵ��μ�����Ҫд�μ����ݿ�travel_notes
		if((int)$products_id && tep_not_null($_POST['p_name']) && (int)count($photo_ids)){
			unset($sql_data_array);
			$sql_data_array = array('travel_notes_title' => ajax_to_general_string(tep_db_prepare_input($_POST['p_name'])),
									'products_id' => $products_id,
									'photo_ids' => implode(',',$photo_ids),
									'customers_id'=> (int)$customer_id,
									'added_time'=> date('Y-m-d H:i:s'),
									'comment_num'=> 0 );
			$sql_data_array = html_to_db($sql_data_array);
			tep_db_perform('travel_notes', $sql_data_array);
		}

		//����ĳ���˵������Ƭ����
		$poto_sql = tep_db_query('SELECT count(*) as total FROM `photo` WHERE photo_books_id ="'.$photo_books_id.'" ');
		$poto = tep_db_fetch_array($poto_sql);
		tep_db_query('UPDATE `photo_books` SET `photo_sum` =  "'.$poto['total'].'" WHERE `photo_books_id` = "'.$photo_books_id.'" ');
		
		//$sms .= "[JS]alert('���������ϴ��ɹ���'); [/JS]";
		$notes_content = '���������ϴ��ɹ���';
		$out_time = 3; //�ӳ�3��ر�
		$tpl_content = file_get_contents(DIR_FS_CONTENT . 'html_tpl/'.'out_time_notes.tpl.html');
		$tpl_content = str_replace('{notes_content}',$notes_content,$tpl_content);
		$tpl_content = str_replace('{out_time}',$out_time,$tpl_content);
		
		$sms .= '
		var gotourl = "'.tep_href_link('individual_space.php').'";
		var notes_contes = "'.addslashes($tpl_content).'";
		write_success_notes('.$out_time.', notes_contes, gotourl);
		
		';
		$sms = '[JS]'.preg_replace('/[[:space:]]+/',' ',$sms).'[/JS]';
		echo db_to_html($sms);
		exit;

	}
}
//�����Ƭ end
?>
<?php
    
    require_once("includes/application_top.php");
    
    if (!tep_session_is_registered('customer_id')) {
		echo db_to_html("0|��¼�ѳ�ʱ����ˢ��ҳ�����µ�¼��");
		exit;
	}		
	$http_url = 'http://'.$_SERVER['HTTP_HOST'].'/images/face/';
	/*�ϴ����ļ�����*/
	$dir = DIR_FACE_FS_IMAGES;//������ļ���·��
	$new_name = date('YmdHis',time()).'_'.$customer_id;	//������ļ�������������չ��
	$headers = getallheaders();
	$exc_name = preg_replace('/^.*\./','.',$headers['Image-Name']);
	$new_name .= strtolower($exc_name); //��׺

	$image_name = $dir.$new_name;
	$file = fopen($image_name, 'wb');
	if(fwrite($file, $GLOBALS['HTTP_RAW_POST_DATA'])=== FALSE){
		echo "0";
		exit();
	}
	tep_image_makethumb($image_name,$image_name,228,228);

	$customers_sql = tep_db_query('SELECT customers_face FROM `customers` WHERE customers_id="'.(int)$customer_id.'" ');
	$customers_row = tep_db_fetch_array($customers_sql);
	if(tep_not_null($customers_row['customers_face']) && $customers_row['customers_face']!=$new_file_name){
		@unlink(DIR_FACE_FS_IMAGES.$customers_row['customers_face']);
	}
	tep_db_query('UPDATE `customers` SET `customers_face` = "'.$new_name.'" WHERE `customers_id` = "'.(int)$customer_id.'" LIMIT 1;');

	//include($_SERVER['DOCUMENT_ROOT'].'/includes/functions/webmakers_added_functions.php');
	//imageCompression($image_name,250, str_replace('detail_','thumb_',$image_name));

	echo "1"."|".$new_name."|".$dir."|".$image_name."|".$http_url.$new_name."|".$http_url.str_replace('detail_','thumb_',$new_name);	//״̬��|�ļ���|Ŀ¼��|ȫ����Ŀ¼+�ļ���|ͼƬ��ַ|ͼƬ����ͼ
	fclose($file);
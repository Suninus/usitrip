<?php
#�����ͼ�ļ���Ŀǰ������jpeg��pngͼ���ݲ�֧��gifͼƬ
//$input_file = 'zhh04.jpg';
//$out_file = 'zhh04_sm.jpg';
//$max_width=150;
//$max_height=100;

function out_thumbnails($input_file, $out_file, $max_width=100, $max_height=100){	
	// File and new size
	$filename = $input_file;
	$out_file = $out_file;
	// Get image sizes and mime type 
	$image_array = getimagesize($filename);
	//���ͼƬ�Ƿ�png��gif��jpegͼƬ��ֹͣ����
	if($image_array[2]!=1 && $image_array[2]!=2 && $image_array[2]!=3){
		return false;
	}
	
	list($width, $height) = $image_array;
	$newwidth = $width;
	$newheight = $height;
	//���ȱȵ����ֵ
	$max_value = intval(($max_height/$max_width)*100)/100;
	//����ͼ�񳤿��
	$ratio_value = intval(($height/$width)*100)/100;
	if($max_value >= $ratio_value){
		if($width > (int)$max_width){	//���ȸߴ�
			$newwidth = (int)$max_width;
			$newheight = (int)($newwidth * $ratio_value);
		}
	}else{
		if($height > (int)$max_height){
			$newheight = (int)$max_height;
			$newwidth = (int)($newheight/$ratio_value);
		}
	}
	
	// Load
	if(function_exists('imagecreatetruecolor')){
		$thumb=imagecreatetruecolor($newwidth, $newheight);//������ͼƬ��ָ����С
	}else{
		$thumb = imagecreate($newwidth, $newheight);
	}
	switch ($image_array[2]) {	//ȡ��ͼƬ����
		case 1:   $source = @imagecreatefromgif($filename);  break;
		case 2:   $source = @imagecreatefromjpeg($filename);  break;
		case 3:   $source = @imagecreatefrompng($filename);  /*imagesavealpha($filename, true);*/  break;
	}

	if(function_exists('imagecopyresampled')){
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);	//��ʧ��
	}else{
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 	//ʧ��
	}
	
	switch ($image_array[2]) {	//���ͼƬ���ļ�$dstFile
		case 1:   imagegif($thumb,$out_file);  break;
		case 2:   imagejpeg($thumb,$out_file,100);   break;
		case 3:   /*imagesavealpha($thumb, true);*/ imagepng($thumb,$out_file);  break;
	}
	@imagedestroy($thumb);
	@imagedestroy($source);
	return $out_file;
}
//echo out_thumbnails($input_file, $out_file, $max_width, $max_height);


	

?>
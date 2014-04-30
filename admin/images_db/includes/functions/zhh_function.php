<?php
//err msn
function err_msn($str='�����ˣ�'){
	return '<span style="color:#FF0000">'.$str.'</span><br />';
}
//good msn
function ok_msn($str='��ȷ��'){
	return '<span style="color:#0066FF">'.$str.'</span><br />';
}

//���ص�ǰ Unix ʱ�����΢����(��λС��)
function microtime_float()
{
    list($msec, $sec) = explode(" ", microtime());
    return ((float)$msec + (float)$sec);
}

?>
<?php /*------------replace find for char �ı����������ַ��ĵ�ɫ-------------------*/
function char2c($char, $key) 
 {
   if(isset($key) && $key!="")
   {
		$keys= trim(eregi_replace("  "," ",$key));
		$keys= eregi_replace(" ","|",$keys);
		$keysary= explode("|",$keys); 
		$nchar=$char;
		for($i=0; $i<count($keysary); $i++)
		{
			$color="#00CC00";
			if($i%2==0){ $color="#0000FF"; } 
			$nchar= eregi_replace($keysary[$i],"<font style='color:$color '>".$keysary[$i]."</font>",$nchar);
		}
		return $nchar;
   
   }
   else return $char;
 }
?>
<?php 
//�Զ�΢��ͼ����
function makethumb($srcFile,$dstFile,$dstW,$dstH)
{

	$data = @getImagesize($srcFile);

	switch ($data[2])
	{
	case 1:
		$imgsrc = @imagecreatefromgif($srcFile);
		break;
	case 2:
		$imgsrc = imagecreatefromjpeg($srcFile);
		break;
	case 3:
		$imgsrc = @imagecreatefrompng($srcFile);
		break;
	default:
		return;
	}

	$srcW = @imagesx($imgsrc);
	$srcH = @imagesy($imgsrc);
	if ($dstH==0) $dstH = ($srcH/$srcW)*$dstW;
        if ($dstH*$srcW > $dstW*$srcH)
        {
            if($srcW<$dstW) $dstW=$srcW;
            $dstH=$dstW*$srcH/$srcW;
        }
        else 
        {
            if($srcH<$dstH) $dstH=$srcH;
            $dstW=$srcW*$dstH/$srcH;
        }
	$ni   = @imagecreate($dstW, $dstH);
	@imagecopyresized($ni,$imgsrc,0,0,0,0,$dstW,$dstH,$srcW,$srcH);
	@imagegif($ni,$dstFile);
}

//����ͼ���(��)��ȡ�óɱ����ĸ�(��)��
function getimgHW3hw($PathFile,$dstW,$dstH) //�����ֱ���·���ļ�,���Ⱥ͸߶�����
{
	$info = @getimagesize($PathFile);
	if ( ($info[0] > $dstW) || ($info[1] > $dstH) ) //��ȱ����õĴ�,��߶ȱ����õĴ�
	{
	  if(($info[0] - $info[1]) >= 0) //��ȸߴ�
	  {
	   $H = round($info[1]/$info[0]*$dstW);
	   $W = $dstW;
	  }
	  elseif(($info[0] - $info[1]) < 0) //��ȸ�С
	  {
	   $W = round($info[0]/$info[1]*$dstH);
	   $H = $dstH;
	  }
	}
	else
	{
	$W = $info[0];
	$H = $info[1];
	}
$wh=" width='".$W."' height='".$H."'";
return $wh;	
}

/*������ʱ���ʽ�����������ڣ���һ����$datetime�Ǵ����������ʱ��(������)��
�ڶ�����$datetype����ʾ������Χ��D����T��"I"Ϊ��"H"Ϊʱ,
��������$type�Ǵ�������ǰ����0�Ƿ�ȥ��*/
function chardate($datetime, $datetype="T", $type="0")
{
	if(!isset($type)) { $type = "0";}
	$year = substr($datetime,0,4);
	$month = substr($datetime,5,2);
	$date = substr($datetime,8,2);
	$hour = substr($datetime,11,2);
	$minute = substr($datetime,14,2);
	$second = substr($datetime,17,2);
	if($type!=0)
	{ 
		$month = intval($month);
		$date = intval($date);
		$hour = intval($hour);
		//$minute = intval($minute);
		//$second = intval($second);		
	}	
	switch ($datetype)
	{
		case "D": $chardate = $year."��".$month."��".$date."��"; break;
		case "T": $chardate = $year."��".$month."��".$date."��".$hour."��".$minute."��".$second."��"; break;
		case "I": $chardate = $year."��".$month."��".$date."��".$hour."��".$minute."��"; break;
		case "H": $chardate = $year."��".$month."��".$date."��".$hour."��"; break;
		default: $chardate = $year."��".$month."��".$date."��".$hour."��".$minute."��".$second."��";
	}
	return $chardate;
}

//==>��YYYY-MM-DD����ʽ��ʽ��YYYY-M-D������
function date2DATE($date)	
{
	if($date!="")
	{
		$date_arry = explode("-",$date);
		$check_year = intval($date_arry[0]) ;
		$check_month = intval($date_arry[1]) ;
		$check_day = intval($date_arry[2]) ;
		$checkdate = checkdate($check_month,$check_day,$check_year);
		if($checkdate!=1){ echo "�����ڵ�����" ; exit;}
		else 
		{
			if(strlen($check_year)==4){ $date = $check_year;}
			
			if(strlen($check_month)==2){ $date .= "-".$check_month;}
			elseif(strlen($check_month)==1){ $date .= "-0".$check_month;}
			else { echo "�·ݴ���"; exit; }
			
			if(strlen($check_day)==2){ $date .= "-".$check_day;}
			elseif(strlen($check_day)==1){ $date .= "-0".$check_day;}
			else { echo "��������"; exit;}		
		}
		return $date;
	}
	else { echo "����Ϊ��"; }
}

?>
<?php 
/** 
* �����ֽ��ת�������Ĵ�д���� 
* ����: 231123.402 => ��ʰ����ҼǪҼ�۷�ʰ��Ԫ������ 
* 
* @param float $num ��ʾ���ĸ����� 
* @return string �������Ĵ�д���ַ��� 
*/ 
function trans2rmb($num) 
{ 
    $rtn = ''; 
    $num = round($num, 2); 
    
    $s = array(); // �洢���ֵķֽⲿ�� 
    //==> ת��Ϊ�ַ���,$s[0]��������,$s[1]С������ 
    $s = explode('.', strval($num)); 
    
    // ����12λ(����ǧ��)���账�� 
    if (strlen($s[0]) > 12) 
    { 
        return '*'.$num; 
    } 
    
    // ���Ĵ�д�������� 
    $c_num = array('��', 'Ҽ', '��', '��', '��', '��', '½', '��', '��', '��'); 
    
    // ���洦��������ݵ����� 
    $r = array(); 
    
    //==> ���� ��/�� ���� 
    if (!empty($s[1])) 
    { 
        $jiao = substr($s[1], 0,1); 
        if (!empty($jiao)) 
        { 
            $r[0] .= $c_num[$jiao].'��'; 
        } 
        else 
        { 
            $r[0] .= '��'; 
        } 
        
        $cent = substr($s[1], 1,1); 
        if (!empty($cent)) 
        { 
            $r[0] .=  $c_num[$cent].'��'; 
        } 
    } 
  
    //==> ���ַ�Ϊ����,��λһ��,���ҵ���:Ԫ/��/��,����9λ���������λ����Ϊ"��" 
    $f1 = 1; 
    for ($i = strlen($s[0])-1; $i >= 0; $i--, $f1 ++) 
    { 
        $f2 = floor(($f1-1)/4)+1; // �ڼ��� 
        if ($f2 > 3) 
        { 
            $f2 = 3; 
        } 
        
        // ��ǰ���� 
        $curr = substr($s[0], $i, 1); 
        
        switch ($f1%4) 
        { 
            case 1: 
                $r[$f2] = (empty($curr) ? '��' : $c_num[$curr]).$r[$f2]; 
                break; 
            case 2: 
                $r[$f2] = (empty($curr) ? '��' : $c_num[$curr].'ʰ').$r[$f2]; 
                break; 
            case 3: 
                $r[$f2] = (empty($curr) ? '��' : $c_num[$curr].'��').$r[$f2]; 
                break; 
            case 0: 
                $r[$f2] = (empty($curr) ? '��' : $c_num[$curr].'Ǫ').$r[$f2]; 
                break; 
        } 
    } 
    
    $rtn .= empty($r[3]) ? '' : $r[3].'��'; 
    $rtn .= empty($r[2]) ? '' : $r[2].'��'; 
    $rtn .= empty($r[1]) ? '' : $r[1].'Ԫ'; 
    $rtn .= $r[0];
	
	if(empty($s[1])) //==>����Ǻͷֲ��ֶ�û�о�����Ϊ��β
	{
		$rtn .= '��';
	}
    //==> ����:���λ��Ϊ��,��"Ԫ"֮ǰ������"��",�ڿ�λ���Ҳ���"Ԫ"֮���,�����һ��"��"(numΪ0���������) 
    if ($num != 0) 
    { 
        while(1) 
        { 
            if (substr_count($rtn, "����") == 0 && substr_count($rtn, "��Ԫ") == 0 
                && substr_count($rtn, "����") == 0 && substr_count($rtn, "����") == 0) 
            { 
                break; 
            } 
            $rtn = str_replace("����", "��", $rtn); 
            $rtn = str_replace("��Ԫ", "Ԫ", $rtn); 
            $rtn = str_replace("����", "��", $rtn); 
            $rtn = str_replace("����", "��", $rtn); 
        } 
    } 
    return $rtn; 
} 

//������ʾ���ֺ���
function cutword($cutstring,$cutno,$endstr="..."){
 if(strlen($cutstring) > $cutno) { 
  for($i=0;$i<$cutno;$i++) { 
   $ch=substr($cutstring,$i,1); 
   if(ord($ch)>127) $i++; 
  } 
 $cutstring= substr($cutstring,0,$i).$endstr; 
 } 
return $cutstring; 
}

//�ļ��ϴ�����
	#���ã��ϴ�����Ҫ����ļ��������ϴ�����ļ�����
	#up_file($up_type, $up_size_max, $up_server_folder,$up_server_file_name,$up_file_name,$img,$imgpix,$imgpix_type)
	#$up_type�����ϴ����� �ö��ŷָ�			
	#$up_size_max�ļ���С����k*1024				
	#$up_server_folderĿ���ļ���Ŀ¼			
	#$up_server_file_name�����ļ���ǰ׺(��ѡ)	
	#$up_file_nameԴ�ļ��������(��ѡ)			
	#$img,���ָ���˲�����������ϴ�ͼƬ(��ѡ)
	#$imgpix,���ָ���˲������������ͼƬ�ĳ���������ش�С(��ѡ),��ʽΪ"��,��"���硰"1024,768"��
	#$imgpix_type,�����ͼ���ص����ͣ�1Ϊ�ϴ���ͼƬ���ر���==$imgpix

function up_file()
{
	
	$numargs = func_num_args();
	$arg_list = func_get_args();
	if($numargs > 8 || $numargs < 3 ){ echo "Warning������up_file��������Ҫ�󣬲�������3�������8����"; exit; }
	$up_type = $arg_list[0];
	$up_size_max =  $arg_list[1];
	$up_server_folder = $arg_list[2];
	$up_server_file_name = $arg_list[3];
	$up_file_name = $arg_list[4];
	if(!$arg_list[3]) { $up_server_file_name = date("YmdHis");}
	if(!$arg_list[4]){ $up_file_name = "file";}  
	if($arg_list[5]) { $img = "Y";}
	if($arg_list[6]) { $imgpix = $arg_list[6];}
	if($arg_list[7]) { $imgpix_type = $arg_list[7];}
	
		
	if($_FILES[$up_file_name]['name']!="")
	{
		#ȡ���ļ���չ������
		$spildname = preg_replace("/^(.*\.)/","", $_FILES[$up_file_name]['name']); 	
		//$spildname = $spildname[count($spildname)-1];
		
		#�����������ļ�������ʹ��strtolower��������չ���ĳ�Сд
		$newfile = $up_server_file_name.".".strtolower($spildname);  
		#�ж��ϴ����ļ�����
		$up_type = strtolower($up_type);
		$up_type_array = explode(",",$up_type);
		for($i=0; $i<count($up_type_array); $i++)
		{
			if(strtolower($spildname) == strtolower($up_type_array[$i])){ $typeY_N = "Y";  break; } else { $typeY_N = "N"; }
		}
		if($typeY_N == "N") 
		{
			
			//$imgmax = "�Բ���ֻ���ϴ�".$up_type."���͵��ļ���";
			//echo $imgmax; exit;
			
			return false;
			//exit;
		}else
		{	
			$accept_overwrite = true;	//�����д�ļ�
			if ($_FILES[$up_file_name]['size'] > $up_size_max) // ����ļ���С
			{			
				//$imgmax = "�Բ�������ļ���СΪ".ceil($_FILES[$up_file_name]['size']/1024)."K������".($up_size_max/1024)."K���ϴ�ʧ�ܡ�";		
				//echo $imgmax;  exit;
				return false;
				//exit;
			}else
			{	//�����ϴ��ļ��Ĳ���
				
				if(@!copy($_FILES[$up_file_name]['tmp_name'],$up_server_folder . $newfile))
				{
					//$imgmax = "����ԭ�����ļ��ϴ�ʧ��!";
					//echo $imgmax ."__".$_FILES[$up_file_name]['tmp_name']."_____".$up_server_folder . $newfile; exit;
					
					return false;
					//exit;
				} 
			}
		}
		
		//���ͼƬ�ļ��ļ��
		#���ͼƬ�Ƿ���Ч
		if($img == "Y")
		{
			$img_info = @getimagesize($up_server_folder . $newfile);
			if($img_info[0] < 1 || $img_info[1] < 1)
			{
				if(@unlink($up_server_folder . $newfile)) {
					/* $imgmax = "�Բ������ϴ���ͼƬ�޷���ʾ�����ϴ���Ч��ͼƬ!"; 
					echo "<script>alert('$imgmax')</script>"; */
					return false;
				}			
			}
		}
		#���ͼƬ�����Ƿ񳬳�ָ��Χ
		if($imgpix_type=='1'){
			$imgpix=explode(",",$imgpix);
			$img_info = @getimagesize($up_server_folder . $newfile);
			if($img_info[0] != $imgpix[0] || $img_info[1] != $imgpix[1])
			{
				if(@unlink($up_server_folder . $newfile)) {
					/* $imgmax = 'ͼƬ�ϴ�ʧ�ܡ����ͼƬ��СΪ'.$img_info[0]."*".$img_info[1].'���أ���ȷ��ͼƬ����'.$imgpix[0].'*'.$imgpix[1].'���أ�';
					echo "<script>alert('$imgmax')</script>"; */
					return false; 
				}	
			}
			
		}elseif($imgpix){
			
			$imgpix=explode(",",$imgpix);
			$img_info = @getimagesize($up_server_folder . $newfile);
			if($img_info[0] > $imgpix[0] || $img_info[1] > $imgpix[1])
			{
				if(@unlink($up_server_folder . $newfile)) {
					/* $imgmax = 'ͼƬ�ϴ�ʧ�ܡ����ͼƬ��СΪ'.$img_info[0]."*".$img_info[1].'���أ���ȷ��ͼƬ������'.$imgpix[0].'*'.$imgpix[1].'���أ�';
					echo "<script>alert('$imgmax')</script>"; */
					return false; 
				}	
			}
		}
		
		$up_server_folder . $newfile;
		
		return $newfile;
	}
}

//ȫ������ת�������
function NUM_num($Number)	
{
	if(eregi("��|��|��|��|��|��|��|��|��|��",$Number))
	{
		$array = array("��","��","��","��","��","��","��","��","��","��");
		for($i=0; $i<count($array); $i++) { $Number = ereg_replace($array[$i],"$i",$Number);}
	}
return $Number;
}

//�ַ���תASCII
function str_ascii($str){
	for($i=0;$i<strlen($str);$i++){  
		$ascii.= ord($str[$i])." ";
	}
	return trim($ascii);
}

//ASCIIת�ַ���
function asscii_str($asscii){
	$array=explode(" ",$asscii);
	foreach ($array as $value){
		$str.=chr($value);
	}
	return $str;
}

//��$_GET��ֵ�滻��ֵ����Ҫ�����滻��ַ���ϵĲ���ֵ
function rep_str($str_name){
	$queryString = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
		$params = explode("&", $_SERVER['QUERY_STRING']);
		$newParams = array();
		foreach ($params as $param) {
			if (stristr($param, $str_name ) == false ) {
				array_push($newParams, $param);
			}
		}
		if (count($newParams) != 0) {
			$queryString = "&amp;" . implode("&", $newParams);
		}
	}
	return preg_replace("/^&amp;/","?",$queryString);
}

////
// �����ı����ϵ����ݿ�,���Ʊ��\tΪ�ֶηָ���
// $table_nameΪ���ݱ���,$table_fieldsΪ���ݱ��е��ֶ�����,�ֶ�֮����","�Ÿ���,$file_nameΪ�ϴ����ļ��������,
// $begin_row=0Ϊ�ӵ�һ�п�ʼ����,����ǵڶ��п�ʼ��Ϊ1,��������. $htmlspecialchars=1Ϊת���������,0Ϊ��ת
function get_text_to_data($table_name,$table_fields,$file_name,$begin_row=0,$htmlspecialchars=1){
	global $db;
	if($table_name==""||!isset($table_name)){die("function get_text_to_data() ����:�����ݱ�����");}
	if(!$table_fields || !$file_name ){ die("function get_text_to_data() ����:���麯��get_text_data�Ĳ���!");}
	if($_FILES[$file_name]['name']!=""){
		define("DESTINATION_FOLDER", $servers_folder);
		//�����ϴ�����ļ���
		$spildname = strtolower(preg_replace("/^.+\./","", $_FILES[$file_name]['name'])); 	//ȡ���ļ���չ��
		//�ж��ļ�����
		if($spildname!="txt"){ 
			if(unlink($_FILES[$file_name]['tmp_name'])){ echo "�ļ��ѱ�ɾ��!<br />";}
			die("function get_text_to_data() �Բ������ϴ��� {$_FILES[$file_name]['name']} �����ı��ļ���");
		}
		// �����ļ��ϴ��������(bytes)
		$file_size_max = (1024*1024);
		if ($_FILES[$file_name]['size'] > $file_size_max) {// ����ļ���С
			if(unlink($_FILES[$file_name]['tmp_name'])){ echo "�ļ��ѱ�ɾ��!<br />";}
			die("�Բ�������ļ���СΪ".(int)($_FILES[$file_name]['size']/1024+1)."K������1M���ϴ�ʧ�ܡ�");
		}else{	//���ı�����д�����ݿ�
			$lines_array=file($_FILES[$file_name]['tmp_name']);
			$lines_rows=count($lines_array);
			if($htmlspecialchars==1){ $htmlspecialchars=htmlspecialchars;}	//ת���������
			else{$htmlspecialchars=trim;}	//��ת���������
			$fields_array=explode(",",$table_fields);
			$fields_count=count($fields_array);
			$sum=0;
			for($i=$begin_row; $i<$lines_rows; $i++){
				//���ÿ���Ƿ���Ϲ涨(ͳ��ÿ�е�\t��)
				$row_fields_array=explode("\t",$lines_array[$i]);
				if(count($row_fields_array)!=$fields_count){
					$err_row=$i+1;
					echo "function get_text_to_data() �����ı��ĵ� $err_row ���Ƿ������⣬Ҫ��������������ݿ��ֶ����������������Ʊ����<br />";
					echo "�ı��е�����->".count($row_fields_array).": �Ѿ���д���ֶ�����->".$fields_count;
					die();
				}
				//д�����ݿ�
				$SQL = " INSERT INTO $table_name ($table_fields) ";
				$SQL.= " VALUES (";
				for($j=0; $j<$fields_count; $j++){
					$SQL.= $db->GetSQL($htmlspecialchars(trim($row_fields_array[$j]))).",";	//"'$k_name', '$k_incname', '$k_jw', '$k_dianhua', '$k_fax', '$k_GSM', '$k_email', '$k_url', '$k_addr', '$k_post'";
				}
				$SQL = preg_replace("/,$/","",$SQL).");";
				mysql_query($SQL);
				$sum+=mysql_affected_rows();
			}
			if(!unlink($_FILES[$file_name]['tmp_name'])){ echo "<br />�ļ�ɾ��ʧ��!";}	//д�����ݺ�ɾ�����ϴ����ļ�
			return $sum;
		}
	}else { die("function get_text_to_data() �Բ�����û��ѡ���ļ����뵥�����������ťѡ���ļ����ϴ���"); }
}

?>
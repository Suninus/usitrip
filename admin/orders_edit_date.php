<?php 
/**
 * ���޸Ķ�������ʱ������������
 * 
 * @author panda
 * @category Project
 * @copyright Copyright(c) 2011 
 * @version $Id$
 */
//ini_set("memory_limit","1024M");
require('includes/functions/zhh_function.php');

/**
 * ��MM/DD/YYYY����ʽ��ʽ��YYYY-MM-DD������
 * @param $date
 */
function dbdate_to_endate($date){
	if(strlen(trim($date))!=10){return false;}
	$array = explode('-',$date);
	if(count($array)!=3){ return false;}
	$format_date = $array[1].'/'.$array[2].'/'.$array[0];
	return $format_date;
}
function dbdate_to_endate2($date){
	if(strlen(trim($date))!=10){return false;}
	$array = explode('/',$date);
	if(count($array)!=3){ return false;}
	$format_date = $array[0].'&nbsp;'.$array[1].'&nbsp;'.$array[2];
	return $format_date;
}
$html = $_REQUEST['html'];
$olddate = $_REQUEST['olddate'];
$newdate = $_REQUEST['newdate'];
$action = $_REQUEST['action'];
$oldweek = $_REQUEST['oldweek'];
$neweek = $_REQUEST['newweek'];
if ($action == 'top'){
    

    /* ȡ������ʱ�䰴˳��������� */
    preg_match_all('/\d{1,2}\/\d{1,2}\/\d{4}/', $html, $oldateArr);
    $dateArr = $oldateArr[0];
    $ic = count($dateArr);
    for ($i=0; $i<$ic; $i++){
        if ($i == 0){
            $newdateArr[$i] = $newdate;
        }else{        
            $newdateArr[$i] = endate_to_dbdate($dateArr[$i]);
        }    
    }

    
    /* �����µ��������� */
    
    for ($i=0; $i<count($newdateArr); $i++){
        if ($i == 0){
            //$arr[] = '<input type=text onclick=changedate(this) id=changedate value='.(string)dbdate_to_endate2(dbdate_to_endate(date('Y-m-d', strtotime($newdateArr[0])))).' >';
            $arr[] = (string)dbdate_to_endate2(dbdate_to_endate(date('Y-m-d', strtotime($newdateArr[0]))));
        }else{
            $arr[] = (string)dbdate_to_endate2(dbdate_to_endate(date('Y-m-d', strtotime($newdateArr[0]) + 86400 * $i)));
        }
    }
    
    /* ȫ���滻���� */
    $str2 = str_replace('&nbsp;', '/', str_replace($dateArr, $arr, $html));
    /* �滻���� */
    $str3 = str_replace($oldweek, $neweek, $str2);
    echo stripslashes($str3);
    
}elseif($action == 'button'){
    /*
    $Html = $_REQUEST['html'];
    */
    /* ƥ�京�����ڵĵ�һ��td �����¼� */
    /*
    preg_match('/\d{1,2}\/\d{1,2}\/\d{4}/isU', $html, $td);
    $replcae = '<p id=\'p1\'>'.$td[0].'</p>';
    $search = $td[0];
    $Html = str_replace($search, $replcae, $Html);
    //$date = dbdate_to_endate2($td[0]);
    
    $Html .= '<script type="text/javascript">
        $(function(){         
            alert($("#changedate").html());
        }); 
    </script>';
    
    echo $Html;
    */
}
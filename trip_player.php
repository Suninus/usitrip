<?php
/**
 * ���ķ����˴������ҳ
 * 
 * @author Administrator
 * @category Project
 * @copyright Copyright(c) 2011 
 * @version $Id$
 */
 
 define('_MODE_KEY','tours-talent-contest');
 if($_GET['mod'] == 'edit' || isset($_GET['ajax']) || isset($_POST['ajax']) || isset($_POST['jQueryAjaxPost'])){
    define('AJAX_MOD',1);	
}
 require_once('includes/application_top.php');
 require_once(DIR_FS_INCLUDES . 'ajax_encoding_control.php');
 require_once(DIR_FS_FUNCTIONS . 'dleno.function.php');
 
 $date = '2011-10-12 11:00:00';
 $current_date = time();
 if ($current_date > strtotime($date)){  
 
     // ͶƱ����ʱ������
     //$voteEndDate = '2011-11-23 00:00:00';
     $voteEndDate = '2011-11-23 00:00:00';
     if ($current_date < strtotime($voteEndDate)){
       $vote_is_end = 1;
     }else{
       $vote_is_end = 0;    
     }
     
 $BreadOff = true; 
 $content = _MODE_KEY;
 $baseName = '���ķ�����ר��';
 $baseUrl = _MODE_KEY.'.php';
 $baseDir = _MODE_KEY.'/';
 $baseUrl_HrefLink = tep_href_link($baseUrl);
 $breadcrumb->add(db_to_html($baseName), $baseUrl_HrefLink);
 /* SEO START*/
 $seoNotHtml = true;
 $the_title = $baseName.' - ȥ��������,�������ô�������η���ר��,���ķ���';
 $the_desc = '���ķ���Ϊ���ṩ������������ô������ײ�,���Գ�ֵ,�α�ȫ��������ô�,���ǵĹ˿Ϳ����������෱��,���ݷḻ,����Ϊ�����Ƶ������ײ�,�Լ��������ʵķ���.';
 $the_key_words = $baseName.',��������,���ô�����';
 /* SEO END */
 
 /* Mode Start */
 $mod = $_GET['mod'];
 !$mod && $mod = 'index';
 //Security restrictions. eg:mod=../../index
 !ereg('^[A-Za-z0-9_]+$',$mod) && $mod = 'default';

 $modePath = _TEP_ROOT_DIR_.'mode/'.$baseDir;
 $ckeditorLanguage = 'zh';
 if(strtolower(CHARSET)=='gb2312'){
    $ckeditorLanguage = 'zh-cn';   
    $smarty->assign('charset','gb2312');
 }

 if(strtolower(CHARSET)=='big5'){
    $ckeditorLanguage = 'zh-cn';
    $smarty->assign('charset','big5');
    echo "<script>location.href='trip_player.php?language=sc'</script>";
 }

 $modePFile = $modePath.$mod.'.php';
 if(!is_file($modePFile)){
    $mod = 'index';
    $_GET['uid'] = '';
 }
 $modePFile = $modePath.$mod.'.php';
 $modeHFile = $baseDir.$mod.'.tpl.html';

  
   

 $validation_include_js='true';	//�������֤��JS�ű�
 $validation_div_span='span';	//��Ϣ��ʾ�ĸ�ʽ��Ĭ��Ϊdiv���������ó�span
  /* �����û����� */
 $query = tep_db_query("SELECT 	works_id,works_author,customers_id,works_title FROM daren_works");
 while($db_result = tep_db_fetch_array($query)){
    $author = tep_customers_name($db_result['customers_id']);
    if ($author != $db_result['works_author']){
        $data_array['works_author'] = $author;
        tep_db_perform('daren_works', $data_array, 'update', 'works_id='.$db_result['works_id']);
    }
 }
 
 
 /* ģ��Ŀ¼ */
 $mode_path = _TEP_ROOT_DIR_.'mode/'.$baseDir;
 
 $content = 'trip_player';
 $BreadOff=true;
 $HideDateSelectLayer = true;
 $is_tours_talent = true; 
 // ����ͶƱ����ʱ�� 
 $smarty->assign('vote_is_end', $vote_is_end);
 $smarty->assign('severname','http://'.$_SERVER['SERVER_NAME']);
 /*ȡ���Ѿ���¼���û���*/
 
 if(tep_session_is_registered('customer_id') ){   
    $customer_id = $_SESSION['customer_id'];
    $smarty->assign('customer_first_name',$customer_first_name);
    $smarty->assign('customer_id',$customer_id);
    $smarty->assign('customer_id1',$customer_id);
 }
 
 $referer_url = $_SERVER['HTTP_REFERER'];
 
 require_once($modePFile);  
 
 $smarty->display($modeHFile);
 unset($smarty);
}else{
    $content = 'trip_player';
    //require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
    require(DIR_FS_TEMPLATES . 'content' . '/' . 'trip_player.tpl.php');
    require(DIR_FS_INCLUDES . 'application_bottom.php');
}
?>
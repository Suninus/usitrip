<?php
require('includes/application_top.php');

//Ĭ��ֵ����
if((int)$_GET['dir_id']){
    $dir_id = ((int)$_GET['dir_id']);
}
$pageHeading = "�������";
$WordsHeading = "��������";

$words_id = (int)$words_id ? (int)$words_id : (int)$_GET['words_id'];

if((int)$words_id){
    //��������
    $words_sql = tep_db_query('SELECT * FROM `zhh_system_words` WHERE words_id="'.$words_id.'" and (FIND_IN_SET( "' . $login_groups_id . '", r_groups_id) || FIND_IN_SET( "' . $login_groups_id . '", rw_groups_id) || FIND_IN_SET( "' . $login_groups_id . '", rwd_groups_id) || admin_id ="'.(int)$login_id.'" || last_admin_id ="'.(int)$login_id.'" ) Limit 1 ');
    $words = tep_db_fetch_array($words_sql);
    if(!(int)$words['words_id']){
        die("����Ȩ��������£�������²����ڣ�");
    }
    $WordsInf = new objectInfo($words);
    foreach((array)$WordsInf as $key => $val){
        $$key = $val;
    }
    $WordsHeading = tep_db_output($words_title);
    //��������Ŀ¼
    $dir_sql = tep_db_query('SELECT dir_id FROM `zhh_words_to_dir` WHERE words_id="'.$words_id.'" ' );
    $dirs_id = '';
    // ȡ�õ�ǰĿ¼����Ŀ¼�Ƿ��ǡ�ÿ�ձض��� 
    $top_to_current_dirs_arr[] = array();    
    while($dir_rows = tep_db_fetch_array($dir_sql)){
        $dirs_id .=",".$dir_rows['dir_id'];
        $top_to_current_dirs_arr[] = tep_get_top_to_now_class($dir_rows['dir_id']); 
    }
   
    $dirs_id = substr($dirs_id,1);
    
    //���¸���
    $annex_sql = tep_db_query('SELECT * FROM `zhh_system_words_annex` WHERE words_id ="'.$words_id.'" ORDER BY annex_id  ' );
    $annexs = array();
    while($annex_rows = tep_db_fetch_array($annex_sql)){
        $annexs[] = array('id'=>$annex_rows['annex_id'], 'file_name'=>$annex_rows['annex_file_name']);
    }
    $annexs_dir_string = "";
    for($i=0; $i<sizeof($annexs); $i++){
        $file_name = $annexs[$i]['file_name'];
        $file_name_base = explode('.', basename($file_name));	//���ڼ�������ַ������Ѿ�������չ�����������ﲻ���ٶ���
        $annexs_dir_string.= '<div>'.tep_draw_hidden_field('annex_files_name[]',$file_name).'<a href="'.tep_href_link('zhh_system_words_download.php','download=1&annex_id='.$annexs[$i]['id']).'" target="_blank">'.tep_db_output(ascii2string($file_name_base[0],'_')).'</a></div>';
    }
    
    //��������Ϣ
    $sent_name = tep_get_admin_customer_name($admin_id).'('.$admin_id.')';
    $last_up_per_name = tep_get_admin_customer_name($last_admin_id).'('.$last_admin_id.')';
    
    
    
    
    
}else{
    die("û��ID��");
}
if ((int)$_POST['read'] == 1){
    // ����ǡ�ÿ�ձض����¡������ı�Ϊ�Ѷ�״̬    
    $words_id = (int)$_POST['words_id'];
    $db_query = tep_db_query("SELECT id FROM ".TABLE_EVERYONE_TO_READ_REMIND." WHERE words_id=".$words_id. " AND admin_id=".(int)$login_id);
    $remind_array = tep_db_fetch_array($db_query);   
    if (tep_not_null($remind_array)){
        $data_array['is_read'] = 1;
        tep_db_perform(TABLE_EVERYONE_TO_READ_REMIND, $data_array, 'update', "id=".$remind_array['id']);
    }
    tep_redirect('zhh_system_words_list.php');
}
//�༭��ɾ����ť
$EditAHref = '';
$DeleteAHref = '';
$rw_groups_ids = explode(',',$rw_groups_id);
$rwd_groups_ids = explode(',',$rwd_groups_id);
if(in_array($login_groups_id,(array)$rw_groups_ids) || in_array($login_groups_id,(array)$rwd_groups_ids)){
    $EditAHref = '<a href="'.tep_href_link('zhh_system_words_detail_admin.php','words_id='.$words_id).'" class="caozuo">�༭</a>';
}
if(in_array($login_groups_id,(array)$rwd_groups_ids)){
    $DeleteAHref = '<a href="javascript:void(0)" onClick="del_words('.$words_id.',this)" class="caozuo" >ɾ��</a>';
}

// ȡ�õ�ǰĿ¼����Ŀ¼�Ƿ��ǡ�ÿ�ձض���   

foreach($top_to_current_dirs_arr as $k => $v){    
    for($i=0; $i<count($v); $i++){
        $current_str .= $v[$i]['text'].',';
    }
}
/*
echo $top_to_current_dirs_arr_str;
$top_to_current_dirs_arr = tep_get_top_to_now_class($dirs_id); 
$current_str = '';
foreach($top_to_current_dirs_arr as $key=>$value){
    $current_str .= $value['text'].','; 	
}*/




$none_div = '<div style="display:none">'.$current_str;
if (preg_match('/ÿ�ձض�/',  $current_str)){
    $have_everyone = true;
}else{
    $have_everyone = false;
}
$none_div .= $have_everyone.'</div>';
echo $none_div;
$main_file_name = "zhh_system_words_detail";
$JavaScriptSrc[] = 'includes/javascript/'.$main_file_name.'.js';
$CssArray = array(); //���application_top�����õ�CSS
$CssArray[] = 'css/new_sys_indexDdan.css';

//js �����еı���
$p = array('/&amp;/', '/&quot;/');
$r = array('&', '"');
$js_urladdress = preg_replace($p,$r,tep_href_link_noseo('zhh_system_words_detail_admin.php','ajax=true&action=delete'));

$breadcrumb->add($WordsHeading, tep_href_link('zhh_system_words_detail.php','words_id='.$words_id));

include_once(DIR_WS_MODULES.'zhh_system_header.php');	//����ͷ�ļ�
include_once(DIR_FS_DOCUMENT_ROOT.'smarty-2.0/libs/write_smarty_vars.php');

$smarty->display($main_file_name.'.tpl.html');

require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
<?php
//check new account
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
header("Pragma: no-cache");

require_once('includes/application_top.php');

get_Convertutf8($_SESSION['language']);

if(tep_not_null($_GET['yanzhengma'])){

	$sql = tep_db_query('SELECT to_content FROM `cpunc_sms_history` WHERE to_phone ="'.tep_db_prepare_input($_GET['telephone']).'" ORDER BY `add_date` desc limit 1');
	//$sql = tep_db_query('SELECT to_content FROM `cpunc_sms_history` WHERE to_phone ="15928966374" ORDER BY add_date desc limit 1');
	$row = tep_db_fetch_array($sql);

	$str = '';
    $to_content = $row['to_content'];
    $to_content = preg_replace("/\D+/", $str, $to_content);

	//echo $row['to_content'];
	if($to_content!=$_GET['yanzhengma']){
		echo '2';//��֤�벻��ȷ
	}else{
		echo '';
	}

}
if(tep_not_null($_GET['email_address'])){
	$sql = tep_db_query('SELECT customers_id FROM `customers` WHERE customers_email_address="'.tep_db_prepare_input($_GET['email_address']).'" limit 1 ');
	$row = tep_db_fetch_array($sql);
	if((int)$row['customers_id']){
		echo '2';	//�Ѿ����ڸõ����ʼ��ʻ�
	}else{
		echo '';
	}
}
/*
if(tep_not_null($_GET['yanzhengma2'])){

	$sql = tep_db_query('SELECT to_content FROM `cpunc_sms_history` WHERE to_phone ="'.tep_db_prepare_input($_GET['confirmphone']).'" ORDER BY `add_date` desc limit 1');
	//$sql = tep_db_query('SELECT to_content FROM `cpunc_sms_history` WHERE to_phone ="15928966374" ORDER BY add_date desc limit 1');
	$row = tep_db_fetch_array($sql);
        $str = '';
        $to_content = $row['to_content'];
        $to_content = preg_replace("/\D+/", $str, $to_content);

	//echo $row['to_content'];
	if($to_content!=$_GET['yanzhengma2']){
		echo '2';//��֤�벻��ȷ
	}

}*/
if(tep_not_null($_GET['cpunc_phone'])){
	
    if(check_mobilephone($_GET['cpunc_phone'])){
        //echo '<tr>';
        //echo '<td>';
    echo '<table cellspacing="0" cellpadding="0" border="0">';
	echo '<tr>';
	echo '<td class="create_rows">'.general_to_ajax_string(db_to_html('������֤:')).'</td>';
	echo '<td class="main"><input type="button" id="impwd" onclick="get_rndpwd()" value="'.general_to_ajax_string(db_to_html('��ȡ����')).'">&nbsp;<span id="pwd_send" class=""></span></td></tr>';
        echo '<tr><td class="create_rows">'.general_to_ajax_string(db_to_html('��֤��:')).'</td><td class="main">'.tep_draw_input_field('yanzhengma','','id="yanzhengma" size=4 class="required validate-number validate-length-telephone" style="ime-mode:disabled" title="'.general_to_ajax_string(db_to_html(ENTRY_TELEPHONE_NUMBER_ERROR)).'" onBlur="check_field(\'create_account\',\'yanzhengma\', \'chk-yanzhengma\');"').'&nbsp;' .'<span class="inputRequirement">*</span><span id="chk-yanzhengma" class="create_default">'.general_to_ajax_string(db_to_html('�������ֻ��յ�����֤��')).'</span></td>';
        echo '</tr>';
        echo '</table>';
        //echo '</td>';
        //echo '</tr>';

    }else{
		echo general_to_ajax_string(db_to_html('<label>&nbsp;</label><span class="errorTip">��������Ч���ֻ�����</span>'));
    }
}
?>
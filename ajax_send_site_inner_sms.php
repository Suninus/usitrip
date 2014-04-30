<?php
if($_POST['ajax']=='true'){
	header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
	header( "Cache-Control: no-cache, must-revalidate" );
	header( "Pragma: no-cache" );
	
	require_once('includes/application_top.php');
	require_once(DIR_FS_INCLUDES . 'ajax_encoding_control.php');
	
	//����û�
	if(!tep_session_is_registered('customer_id') || !(int)$customer_id){
		if(!tep_not_null($_POST['password'])){
			echo db_to_html('[ERROR]���������ĵ�¼���룡[/ERROR]');
			exit;
		}
		if(!tep_not_null($HTTP_GET_VARS['action'])){ $HTTP_GET_VARS['action'] = 'process'; }else{ $old_action = $HTTP_GET_VARS['action']; $HTTP_GET_VARS['action'] = 'process'; }
		$ajax = $_POST['ajax'];
		include('login.php');
		if(tep_not_null($old_action)){
			$HTTP_GET_VARS['action'] = $old_action;
		}
	}
	
	//����վ�ڶ���
	if($_GET['action']=='process' && $error == false){
		$error_sms = "";	
		
		$type_name = tep_db_prepare_input($_POST['type_name']);
		$key_id = (int)$_POST['key_id'];
		$to_customers_id = tep_db_prepare_input($_POST['to_customers_id']);
		if(!(int)$to_customers_id){
			$error_sms .= db_to_html('��to_customers_id\n\n');
			$error = true;
		}
		$sms_content = tep_db_prepare_input($_POST['sms_content']);
		if(strlen($sms_content)<2){
			$error_sms .= db_to_html('������������ݡ�\n\n');
			$error = true;
		}
		if($error == true){
			echo db_to_html($error_sms);
			exit;
		}
		$add_date = date('Y-m-d H:i:s');
		//Ҫд���Σ�һ���Ǹ������ˣ��ڶ����Ǹ�������
		$sql_data_array = array('customers_id' => (int)$customer_id ,
								'type_name' => $type_name,
								'key_id' => $key_id,
								'to_customers_id' => $to_customers_id,
								'sms_content' => iconv('utf-8',CHARSET.'//IGNORE',$sms_content),
								'add_date' => $add_date,
								'owner_id' => (int)$customer_id);
	
		$sql_data_array = html_to_db($sql_data_array);
		tep_db_perform('`site_inner_sms`', $sql_data_array);
		
		$sql_data_array['owner_id'] = $to_customers_id;
		tep_db_perform('`site_inner_sms`', $sql_data_array);
		
		$sis_id = tep_db_insert_id();
		//echo '[SUCCESS]'.(int)$sis_id.'[/SUCCESS]';
		$notes_content = '���ŷ��ͳɹ���';
		$out_time = 3; //�ӳ�3��ر�
		$tpl_content = file_get_contents(DIR_FS_CONTENT . 'html_tpl/'.'out_time_notes.tpl.html');
		$tpl_content = str_replace('{notes_content}',$notes_content,$tpl_content);
		$tpl_content = str_replace('{out_time}',$out_time,$tpl_content);
	
		$js_str =  
		'[JS]
		var form = document.getElementById("site_inner_sms_form");
		form.elements["type_name"].value = "";
		form.elements["key_id"].value = "";
		form.elements["to_customers_id"].value = "";
		form.elements["sms_content"].value = "";
		closeDiv("site_inner_sms_layer"); 
		
		var notes_contes = "'.addslashes($tpl_content).'";
		write_success_notes('.$out_time.', notes_contes, "");
		[/JS]';
		
		$js_str = preg_replace('/[[:space:]]+/',' ',$js_str);
		echo db_to_html($js_str);
		exit;
		
	}
}
?>

<!--������վ�ڶ��� start-->
<div class="jb_fb_tcAddXx" id="site_inner_sms_layer" style="text-decoration:none; display:none">
<?php echo tep_pop_div_add_table('top');?>
  <form method="post" enctype="multipart/form-data" id="site_inner_sms_form" onsubmit="send_site_inner_sms(this); return false;">
  <input name="type_name" type="hidden" value="" />
  <input name="key_id" type="hidden" value="" />
  <input name="to_customers_id" type="hidden" value="" />
  <div>
     <div class="jb_fb_tc_bt">
       <h3><?php echo db_to_html('��������Ϣ')?></h3>&nbsp;&nbsp;
	   <button type="button" title="<?php echo db_to_html('�ر�');?>" onclick="closeDiv('site_inner_sms_layer')" class="icon_fb_bt"/></button>
    </div>
     <div class="jb_fb_tc_tab">
      <table style="float:left;">
	  <tr>
	  <td><?= db_to_html("���ݣ�")?>
	  </td>
          <td><?php
            if(!(int)$customer_id){
               $onclick_onclick='onfocus=check_login("travel_companion_tips_2065",false) ';
            }else{
            $onclick_onclick='';
            }
          echo tep_draw_textarea_field('sms_content','',50,5,'','class="textarea_xx"'.$onclick_onclick);?>
	  </td>
          </tr>
	  <tr>
	  <td>&nbsp;
	  </td>
	  <td align="center"><button type="submit" class="jb_fb_all myjb_content_sq1_button" style="float:none;"><?= db_to_html('����')?></button>
	  </td>
	  
	  </tr>
	  </table> 
     </div>
</div>
</form>
<?php echo tep_pop_div_add_table('foot');?>
</div>
<script type="text/javascript">
//��վ�ڶ��Ų�
function show_site_inner_sms_layer(to_customers_id, type_name, key_id){
	var form = document.getElementById('site_inner_sms_form');
	if(to_customers_id <1 || key_id<1 ){ alert('no to_customers_id ro key_id!'); return false; }
	form.elements['type_name'].value = type_name;
	form.elements['key_id'].value = key_id;
	form.elements['to_customers_id'].value = to_customers_id;
	form.elements['sms_content'].value = "";
	
	showDiv('site_inner_sms_layer');
}

//����վ�ڶ���
function send_site_inner_sms(form_obj){
	var form = form_obj;
	if(form.elements['sms_content'].value.length<2){
		alert('<?= db_to_html("������Ҫ������Ϣ��");?>');
		return false;
	}
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('ajax_send_site_inner_sms.php','action=process')) ?>");
	var form_id = form.id;
	var success_msm = "";
	var success_go_to = "";
	ajax_post_submit(url,form_id,success_msm,success_go_to);
}

</script>
<!--������վ�ڶ��� end-->


<?php
//�ύ���۵Ĳ�
if($_GET['action']=='process' && $_POST['ajax']=='true'){

	header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
	header( "Cache-Control: no-cache, must-revalidate" );
	header( "Pragma: no-cache" );
	
	require_once('includes/application_top.php');
	require_once(DIR_FS_INCLUDES . 'ajax_encoding_control.php');

	//����û�
	if((!tep_session_is_registered('customer_id') || !(int)$customer_id) && (int)$_POST['anonymous']<1){
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
	
	//print_r($_POST);
	//exit;
	
	if($_GET['action']=='process' && $error == false){	//д���ݿ�
		$customers_name = ajax_to_general_string($_POST['customers_name']);
		$customers_email = ajax_to_general_string($_POST['email_address']);
		$reviews_title = ajax_to_general_string($_POST['review_title']); 
		$rating_0 = $_POST['rating_0'];
		$rating_1 = $_POST['rating_1'];
		$rating_2 = $_POST['rating_2'];
		$rating_3 = $_POST['rating_3'];
		$rating_4 = $_POST['rating_4'];
		$rating_5 = $_POST['rating_5'];

		//$rating = $_POST['rating'];
		$review =ajax_to_general_string($_POST['review']);
		
		$error = false;
	  
	 
		if($customers_name == ''){
		  $error = true;
		  $error_msg .= TEXT_ERROR_MSG_YOUR_NAME;
		}
		
		if($customers_email == ''){
		  $error = true;
		  $error_msg .= TEXT_ERROR_MSG_YOUR_EMAIL;
		}
		
		if($reviews_title == ''){
		  $error = true;
		  $error_msg .= TEXT_ERROR_MSG_REVIEW_TITLE;
		}
	 
		if (strlen($review) == 0) {
		  $error = true;
		  $error_msg .= TEXT_ERROR_MSG_REVIEW_TEXT;
		  //$messageStack->add('review', JS_REVIEW_TEXT);
		}
	
		if(!(int)$rating_0){
		  $error = true;
		  $error_msg .=  db_to_html('��ΪԤ��ѡ��һ������');
		}
		if(!(int)$rating_1){
		  $error = true;
		  $error_msg .=  db_to_html('��Ϊ�ͷ�ѡ��һ������');
		}
		if(!(int)$rating_2){
		  $error = true;
		  $error_msg .=  db_to_html('��Ϊס��ѡ��һ������');
		}
		if(!(int)$rating_3){
		  $error = true;
		  $error_msg .=  db_to_html('��Ϊ��ͨѡ��һ������');
		}
		if(!(int)$rating_4){
		  $error = true;
		  $error_msg .=  db_to_html('��Ϊ����ѡ��һ������');
		}
		if(!(int)$rating_5){
		  $error = true;
		  $error_msg .=  db_to_html('��Ϊ�г�ѡ��һ������');
		}
		/*if (($rating < 1) || ($rating > 5)) {
		  $error = true;
		  $error_msg .=  TEXT_ERROR_MSG_REVIEW_RATING;
		  //$messageStack->add('review', JS_REVIEW_RATING);
		}*/
		
		if($error==false){
			//��ת���� 1�ǣ�20-30��   2�ǣ�40-50��    3�ǣ�60-70��    4�ǣ�80-90��   5�ǣ�100��
			$rating = $rating_0+$rating_1+$rating_2+$rating_3+$rating_4+$rating_5;
			
			tep_db_query(html_to_db ("insert into " . TABLE_REVIEWS . " (products_id, customers_id, customers_name, rating_total, date_added, reviews_status, customers_email, rating_0, rating_1, rating_2, rating_3, rating_4, rating_5) values ('" . (int)$_POST['products_id'] . "', '" . (int)$customer_id . "', '" . tep_db_input($customers_name) . "', '" . tep_db_input($rating) . "', now(), '0', '".tep_db_input($customers_email)."', '".$rating_0."' , '".$rating_1."' , '".$rating_2."' , '".$rating_3."' , '".$rating_4."' , '".$rating_5."' )"));
			$insert_id = tep_db_insert_id();
			
			tep_db_query(html_to_db ("insert into " . TABLE_REVIEWS_DESCRIPTION . " (reviews_id, languages_id, reviews_text, reviews_title) values ('" . (int)$insert_id . "', '" . (int)$languages_id . "', '" . tep_db_input($review) . "',  '" . tep_db_input($reviews_title) . "')"));
			
			// write to products_index
			$index_type = 'reviews';
			auto_add_product_index((int)$_POST['products_id'],$index_type );
			// write to products_index end
			
			#### Points/Rewards Module V2.1rc2a BOF ####*/
			 if(isset($customer_id) && $customer_id!=''){
				if (USE_POINTS_SYSTEM == 'true' && (int)USE_POINTS_FOR_REVIEWS && tep_get_customers_reviews_total_today($customer_id) <= (int)EVERY_DAY_MAX_NUM_FOR_ADD_POINTS_FOR_REVIEWS ) {
					$points_toadd = USE_POINTS_FOR_REVIEWS;
					$comment = 'TEXT_DEFAULT_REVIEWS';
					$points_type = 'RV';
					tep_add_pending_points($customer_id, (int)$insert_id, $points_toadd, $comment, $points_type, '', (int)$_POST['products_id']);
				}
			 }
			#### Points/Rewards Module V2.1rc2a EOF ####*/
		
			echo '[SUCCESS]1[/SUCCESS]';
		}
	
	}

	if($error == true && $error_msg!=""){
		echo '[ERROR]'.$error_msg.'[/ERROR]';
	}

	exit;
}

?>

<!--д���۲�-->
<div id="WriteNewReview" class="popup" >
  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
		<tr>
		  <td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td  class="side"></td>
			<td class="con">
			  <div class="popupCon" id="WriteNewReviewCon" style="width:528px; ">
			  <div class="popupConTop">
				  <h4><?php echo db_to_html('��������')?></h4><span><a href="javascript:closePopup(&quot;WriteNewReview&quot;)"><img src="<?= DIR_WS_TEMPLATE_IMAGES;?>popup/icon_x.gif" /></a></span>
				</div>
				<form action="" method="post" name="WriteReviewForm" id="WriteReviewForm" onSubmit="Submit_Reviews(); return false" >
	<table style="float:left" cellSpacing=0 cellPadding=0 width="100%" border=0>
	
	<tr><td align="center" style="font-weight: normal;">
	
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td height="25" colspan="2" align="center" class="title_line">
		  <?php
		  if(!(int)$categories_id){
			$categories_id = (int)$categories;
		  }
		  if(!(int)$categories_id){
			$categories_id = (int)$cPathOnly;
		  }
		  ?>
		<input name="categories_id" type="hidden" id="categories_id" value="<?= $categories_id?>" />
		<input name="products_id" type="hidden" id="products_id" value="<?= $products_id?>" />
		</td>
		</tr>
	  <tr>
		<td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('����')?>&nbsp;</td>
		<td align="left" valign="top"><?php echo tep_draw_input_field('customers_name','','  class="required validate-length-lastname" style="width: 242px;" title="'.db_to_html('����������').'"') ?>
		<span class="inputRequirement"> * </span></td>
	  </tr>
	  
	  <?php if(!(int)$customer_id){//no login?>
	  <tr>
		<td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('�û���/����&nbsp;')?></td>
		<td align="left" valign="top">
		<?php echo tep_draw_input_field('email_address','','class="required validate-email" style="width: 160px;" title="'.db_to_html('���������ĵ�������').'"') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?>
		<?php echo db_to_html('���û����� <a href="'.tep_href_link("create_account.php","", "SSL").'" class="sp3">ע��</a>');?>	</td>
	  </tr>
	  <tr>
		<td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('����')?>&nbsp;</td>
		<td align="left" valign="top">
		<input name="password" type="password" class="required" id="password" title="<?php echo db_to_html('��������ȷ������')?>" style="width: 160px;" />
		<label><input name="anonymous" type="checkbox" id="anonymous" onClick="anonymous_comments(this)" value="1"> 
		<?php echo db_to_html('�������ۣ�������ȡ����')?></label>		</td>
	  </tr>
	  <?php
	  }else{//loging
		  if(!tep_not_null($email_address)){
			$email_address = $customer_email_address;
		  }
	  ?>
	  
	  <tr>
		<td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('����')?>&nbsp;</td>
		<td align="left" valign="top"><?php echo tep_draw_input_field('email_address','',' readonly="true" class="required validate-email" style="width: 242px;" title="'.db_to_html('���������ĵ�������').'"') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
	  </tr>
	  
	  <?php }?>
	  
	  <tr>
		<td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('����')?>&nbsp;</td>
		<td align="left" valign="top"><?php echo tep_draw_input_field('review_title','','  class="required" title="'.db_to_html('���������').'" style="width: 242px;"') ?><span class="inputRequirement"> * </span></td>
	  </tr>
	  <tr>
		<td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('��������')?>&nbsp;</td>
		<td align="left" valign="top" style="padding-top:2px;"><?php echo tep_draw_textarea_field('review', 'soft', '', '','',' class="required "  style="width: 242px; height: 80px; " id="review" title="'.db_to_html('��������������').'"'); ?><span class="inputRequirement"> * </span></td>
	  </tr>
	  
	  <tr>
	    <td height="25" colspan="2" align="center" valign="middle"><?php echo db_to_html('<b>��������</b>')?></td>
	    </tr>
	  <?php
	  /*ȡ������ 
	  <tr>
		<td height="25" align="right" valign="middle" class="title_line"><?php echo db_to_html('����')?>&nbsp;</td>
		<td align="left" valign="top" style="padding-top:2px;">
		
		<span class="sp1"><font color="#ff0000"><b><?php echo db_to_html('��')?></b></font></span> 													
		<input name="rating" value="1" type="radio" class="required" title="<?php echo db_to_html('��ѡ��һ������');?>">
		<input name="rating" value="2" type="radio" class="required" title="<?php echo db_to_html('��ѡ��һ������');?>">
		<input name="rating" value="3" type="radio" class="required" title="<?php echo db_to_html('��ѡ��һ������');?>">
		<input name="rating" value="4" type="radio" class="required" title="<?php echo db_to_html('��ѡ��һ������');?>">
		<input name="rating" value="5" type="radio" class="required" title="<?php echo db_to_html('��ѡ��һ������');?>">
		<span class="sp1"><font color="#ff0000"><b><?php echo db_to_html('��')?></b></font></span>		</td>
	  </tr>
	  */?>
	  <?php
	  $reviews_array = get_reviews_array();
	  for($i=0; $i<count($reviews_array); $i++){
	  ?>
	  <tr>
	    <td height="25" align="right" valign="middle" class="title_line"><?php echo db_to_html($reviews_array[$i]['title'])?>&nbsp;</td>
	    <td align="left" valign="middle" style="padding-top:2px;">
		<?php
		foreach($reviews_array[$i]['opction'] as $key_val => $text){
			echo '<label><input name="rating_'.$i.'" value="'.$key_val.'" type="radio" class="required" title="'.db_to_html('��Ϊ'.$reviews_array[$i]['title'].'ѡ��һ������').'"> '.db_to_html($text).'</label> ';
		}
		?>
		</td>
	  </tr>
	  <?php 	  }
	  ?>
	  
	  <tr>
		<td height="45" align="right" class="title_line">&nbsp;</td>
		<td align="left"><?php echo tep_template_image_submit('fabiao-button.gif', db_to_html('����')); ?></td>
	  </tr>
	</table>
	
	</td>
	</tr>
	</table>
	</form>
			  </div>
		  </td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
	  </table>
</div>

<?php
$p=array('/&amp;/','/&quot;/');
$r=array('&','"');
?>

<script type="text/javascript">
var WRForm = document.getElementById('WriteReviewForm');
function anonymous_comments(obj){
	var password = WRForm.elements['password'];
	if(password==null){ return false;}
	if(obj.checked==true){
		password.value = "";
		password.disabled = true;
	}else{
		password.disabled = false;
	}
}

function check_radio(name){
	var form_ = WRForm;
	if(form_.elements[name]!=null){
		for(i=0; i<form_.elements[name].length; i++){
			if(form_.elements[name][i].checked == true){
				return true;
			}
		}
	}
	return false;	
	
}


function Submit_Reviews() {
	var error_msn = '';
	var error = false;
	
	for(i=0; i<WRForm.length; i++){
	
		if(WRForm.elements[i]!=null){
			if(WRForm.elements[i].value.length < 1 && WRForm.elements[i].className.search(/required/g)!= -1 && WRForm.elements[i].disabled!=true){
				error = true;
				error_msn +=  "* " + WRForm.elements[i].title + "\n\n";
			}
		}
	}
	
	//check radio
	/*for(i=0; i<WRForm.length; i++){
		if(WRForm.elements[i]!=null){
			if(WRForm.elements[i].type=='radio'){
				var radio_name = WRForm.elements[i].name.toString();
				if(check_radio(radio_name)==false){
					//alert(radio_name);
					error = true;
					error_msn +=  "* " + WRForm.elements[radio_name][0].title + "\n\n";
				}
				i++;
			}
		}
	 }*/
	  <?php
	  $reviews_array = get_reviews_array();
	  for($i=0; $i<count($reviews_array); $i++){
	  ?>
		if(check_radio('rating_<?= $i?>')==false){
			error = true;
			if(WRForm.elements['rating_<?= $i?>']!=null){
				error_msn +=  "* " + WRForm.elements['rating_<?= $i?>'][0].title + "\n\n";
			}
		}
	  
	  <?php
	  }
	  ?>
	
	
	if(error==true){
		alert(error_msn);
		return false;
	}else{
		var form = WRForm;
		var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('write_review_ajax.php','action=process')) ?>");
		var aparams=new Array();  //����һ�����д������Ԫ�غ�ֵ
	
		for(i=0; i<form.length; i++){
			if(form.elements[i].type=="radio" || form.elements[i].type=="checkbox" ){	//����ѡ����ѡ��ťֵ
				var a = '';
				if(form.elements[i].checked){
					var sparam=encodeURIComponent(form.elements[i].name);  //ȡ�ñ�Ԫ����
					sparam+="=";     //����ֵ֮����"="������
					a = form.elements[i].value;
					sparam+=encodeURIComponent(a);   //��ñ�Ԫ��ֵ
					aparams.push(sparam);   //push�ǰ���Ԫ����ӵ�������ȥ
				}
			}else{
				var sparam=encodeURIComponent(form.elements[i].name);  //ȡ�ñ�Ԫ����
				sparam+="=";     //����ֵ֮����"="������
				sparam+=encodeURIComponent(form.elements[i].value);   //��ñ�Ԫ��ֵ1
				aparams.push(sparam);   //push�ǰ���Ԫ����ӵ�������ȥ
			}
		}
		var post_str = aparams.join("&");		//ʹ��&������Ԫ������
		post_str += "&ajax=true";
	
	
		ajax.open("POST", url, true); 
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
		ajax.send(post_str);
	
		ajax.onreadystatechange = function() { 
			if (ajax.readyState == 4 && ajax.status == 200 ) { 
				//alert(ajax.responseText);
				
				var error_regxp = /(.*\[ERROR\])|(\[\/ERROR\].*[:space:]*.*)/g;
				if(ajax.responseText.search(/(\[ERROR\].+\[\/ERROR\])/g)!=-1){
					var error = ajax.responseText.replace(error_regxp,'');
					error = error.replace(/\<br\/\>/g,"\n");
					alert(error);
				}
	
				var success_regxp = /(.*\[SUCCESS\])|(\[\/SUCCESS\].*[:space:]*.*)/g;
				if(ajax.responseText.search(/(\[SUCCESS\]\d+\[\/SUCCESS\])/g)!=-1){		
					alert("<?php echo db_to_html('���۷���ɹ���');?>");
					
					//д�����ݵ������б�
					var NewReviewsList = document.getElementById('NewReviewsList');
					if(NewReviewsList!=null){
						NewReviewsList.innerHTML = '<div class="pr_b_q"><div class="pr_b_q_1 sp10 sp6"><table width="100%"><tr><td width=18 align="left"><img src="image/q.gif" width="13" height="19"></td><td><B>'+ form.elements['review_title'].value +'</B></td><td align="right"></td></tr></table></div><div class="pr_b_qq sp10 sp6"><p style="text-align:right; padding-right:5px;">'+ form.elements['customers_name'].value +'&nbsp;|&nbsp;<span style="color:#F7860F"><?php echo db_to_html('[�����]');?></span><p><div>'+ form.elements['review'].value.replace(/\n/g,'<br/>') +'</div></div></div><div class="pr_b_qing"><div class="pr_b_qimg"><img src="image/pr_s.gif"></div></div>' + NewReviewsList.innerHTML;
					}
					
					form.elements['review_title'].value='';
					form.elements['review'].value='';
					closePopup('WriteNewReview');
					
				}
				
			}
			
		}

	}
}

</script>
<!--д���۲� end-->

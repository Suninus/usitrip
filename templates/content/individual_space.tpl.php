
<div class="item_left">
    <div class="jb_left">
	
      <?php
		//����Face
		include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'travel_companion_face.php');
		get_travel_companion_face((int)$customers_id);

	  ?>
    
	</div>
    <div class="item_left1">
	<?php
		//����ÿ���Ϣ
		include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'travel_companion_guest_history.php');
	?>

      </div>
	
</div>


	<div class="jb_right">
      <div class="right_tb">
          <?php
	   $face_onclick = "";
	   if($customers_id==$customer_id){
	   		$face_onclick = ' onclick="show_travel_companion_tips(1,20121221)" ';
	   }

	   $face_src = "image/touxiang_no-sex.gif";
	   $face_src = tep_customers_face($customers_id, $face_src);

           //$face_src ='http://localhost/images/face/20100721074138_2137.jpg';
           //echo $face_src;

	   ?>
        <h3><?= db_to_html($customers_name.'�ĸ�������')?></h3><a href="JavaScript:void(0)" class="grzx_grzl" onclick="showDiv('travel_companion_tips_2064');"><?= db_to_html('�鿴��������')?></a>
        
        
        <!--�����㿪ʼ-->
        <?php
		//ȡ���û��Ļ�����Ϣ
		$account_query = tep_db_query("select customers_gender,customers_mobile_phone, customers_dob, dob_secret, telephone_secret, email_secret, customers_firstname, customers_lastname, customers_email_address, customers_telephone, customers_fax, customers_remark, customers_face, space_public from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customers_id . "' limit 1 ");
		$account = tep_db_fetch_array($account_query);
		foreach($account as $key => $val){
			$$key = db_to_html($val);
		}
		
		$telephones = explode('-',$customers_telephone);
		if(count($telephones)>1){
			$telephone_cc = $telephones[0];
			$telephone = $telephones[1];
		}else{
			$telephone_cc = "0086";
			$telephone = $telephones[0];
		}
		$customers_dob = substr($customers_dob,0,10);
		?>
        <div class="jb_fb_tc" id="travel_companion_tips_2064">
		<?php echo tep_pop_div_add_table('top');?>
		<div>
     <div class="jb_fb_tc_bt">
       <h3><?= db_to_html($customers_name.'�Ļ�����Ϣ')?></h3>&nbsp;&nbsp;
	   <?php
	   if($customers_id==$customer_id){
	   ?>
	   <a href="JavaScript:void(0)" onclick="edit_or_show_account()" class="jb_fb_tc_bt_a"><?= db_to_html('�޸�')?></a>
	   <?php
	   }
	   ?>
	   <button class="icon_fb_bt" onclick="closeDiv('travel_companion_tips_2064');" title="<?= db_to_html('�ر�')?>" type="button"></button>
	   </div>
     <form action="" enctype="multipart/form-data" method="post" id="account_edit" name="account_edit" onsubmit="submit_account_edit(this);return false;">
	 <input name="customers_face" type="hidden" value="<?= $customers_face?>" />
	 <div class="grxx_tc">
       <div class="grxx_tx">

           <div class="grxx_tx_otherimg"><img id="img_customers_face" src="<?=$face_src?>" <?php echo getimgHW3hw($face_src,100,100)?> <?= $face_onclick;?>/></div>
	   <?php
	   if(tep_not_null($face_onclick)){
	   ?>
	   <div  class="grxx_tx_other"><a href="JavaScript:void(0)" <?=$face_onclick?>><?= db_to_html('����ͷ��');?></a></div>
	   <?php
	   }
	   ?>
	   </div>
       <div class="grxx_xx">
        <table id="show_info">
        <tr><td class="grxx_tc_td"><?= db_to_html('����:')?></td><td class="col_2"><?= tep_db_output($customers_firstname);?></td></tr>
        <tr><td class="grxx_tc_td"><?= db_to_html('Ӣ����:')?></td><td class="col_2"><?= tep_db_output($customers_lastname);?></td></tr>
        <tr><td class="grxx_tc_td"><?= db_to_html('�Ա�:')?></td><td class="col_2"><?= db_to_html(tep_db_output(tep_get_gender_string($customers_gender)));?></td></tr>
        <tr><td class="grxx_tc_td"><?= db_to_html('����:')?></td><td class="col_2">
		<?php
		if($dob_secret=="0"){
			echo tep_db_output($customers_dob);
		}
		if($dob_secret=="1"){
			echo db_to_html('[����]');
		}
		if($dob_secret=="2"){
			echo substr(tep_db_output($customers_dob),5,5);
		}
		?>
		</td></tr>
        <tr><td class="grxx_tc_td"><?= db_to_html('Email��')?></td><td class="col_2">
		<?php
		if($email_secret!="1"){
			echo tep_db_output($customers_email_address);
		}else{
			echo db_to_html('[����]');
		}
		?>
		</td></tr>
        <tr><td class="grxx_tc_td"><?= db_to_html('�绰��')?></td><td class="col_2">
		<?php
		if($telephone_secret!="1"){
			echo tep_db_output($customers_telephone);
		}else{
			echo db_to_html('[����]');
		}
		?>
		</td></tr>
        <tr><td colspan="2"><b><?= db_to_html('���˵����...')?></b></td></tr>
        <tr><td colspan="2" class="col_2">
		<?= nl2br(tep_db_output($customers_remark));?>
		<?php
		if(!tep_not_null($customers_remark)){
			echo db_to_html("��ʱû������ʲô����");
		}
		?>
		</td></tr>
        <tr>
		<td class="grxx_tc_td" nowrap="nowrap"><?= db_to_html('�������ģ�')?></td>
		<td class="col_2">
		<?php
		if($space_public=="1"){
			echo db_to_html("����");
		}else{
			echo db_to_html("�ر�");
		}
		?>
		</td>
		</tr>
       </table>
        <table id="edit_info" style="display:none">
        <tr><td colspan="2"><div class="grzx_notes" style="width:auto; margin-left:0px; margin-top:0px;"><span><?= db_to_html('�����Ҫ�޸�������Ӣ���������䡢�绰�뵽[<a href="'.tep_href_link('account_edit.php', '', 'SSL').'" target="_blank" class="jb_fb_tc_bt_a">�༭�˺�</a>]�޸�')?></span></div></td></tr>
		<tr><td class="grxx_tc_td"><?= db_to_html('����:')?></td><td class="col_2"><?= tep_db_output($customers_firstname);?><?= tep_draw_hidden_field('firstname',$customers_firstname);?></td></tr>
        <tr><td class="grxx_tc_td"><?= db_to_html('Ӣ����:')?></td><td class="col_2"><?= tep_db_output($customers_lastname);?><?= tep_draw_hidden_field('lastname',$customers_lastname);?></td></tr>
        <tr><td class="grxx_tc_td"><?= db_to_html('�Ա�:')?></td><td class="col_2">
		<?php
		if (isset($gender)) {
		  $male = ($gender == 'm') ? true : false;
		} else {
		  $male = ($customers_gender == 'm') ? true : false;
		}
		$female = !$male;
		?>
		<?php echo tep_draw_radio_field('gender', 'm', $male) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender', 'f', $female) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?>
		</td></tr>
        <tr><td class="grxx_tc_td"><?= db_to_html('���գ�')?></td><td class="col_2">
		<?php
		$dob_year = substr($customers_dob,0,4);
		$dob_month = substr($customers_dob,5,2);
		$dob_day = substr($customers_dob,8,2);
		//echo tep_draw_input_num_en_field('dob',$customers_dob);
		echo tep_draw_input_num_en_field('dob_year',$dob_year, ' size="5" maxlength="4" onFocus="select();" onBlur="format_date(this,&quot;Y&quot;)" ').db_to_html('��');
		echo tep_draw_input_num_en_field('dob_month',$dob_month, ' size="3" maxlength="2" onFocus="select();" onBlur="format_date(this,&quot;M&quot;)" ').db_to_html('��');
		echo tep_draw_input_num_en_field('dob_day',$dob_day, ' size="3" maxlength="2" onFocus="select();" onBlur="format_date(this,&quot;D&quot;)" ').db_to_html('��');


		$checked0 = $checked1 = $checked2 = false;
		if($dob_secret == "0"){ $checked0 = true;}
		if($dob_secret == "1"){ $checked1 = true;}
		if($dob_secret == "2"){ $checked2 = true;}
		echo '&nbsp;&nbsp;';
		echo tep_draw_radio_field('dob_secret','0',$checked0).'&nbsp;'.db_to_html('��ȫ����');
		echo '&nbsp;&nbsp;';
		echo tep_draw_radio_field('dob_secret','1',$checked1).'&nbsp;'.db_to_html('����');
		echo '&nbsp;&nbsp;';
		echo tep_draw_radio_field('dob_secret','2',$checked2).'&nbsp;'.db_to_html('ֻ��ʾ��/��');

		?>
		</td></tr>
        <tr><td class="grxx_tc_td"><?= db_to_html('Email��')?></td><td class="col_2"><?= tep_db_output($customers_email_address);?>&nbsp;<?= tep_draw_checkbox_field('email_secret','1').db_to_html('&nbsp;����&nbsp;&nbsp;').db_to_html('<span>��ѡ����ҳ�Ͻ�����ʾ�����ַ��</span>');?></td></tr>
        <tr><td class="grxx_tc_td"><?= db_to_html('�绰��')?></td><td class="col_2"><?= tep_db_output($customers_telephone);?>&nbsp;<?= tep_draw_checkbox_field('telephone_secret','1').db_to_html('&nbsp;����&nbsp;&nbsp;').db_to_html('<span>��ѡ����ҳ�Ͻ�����ʾ�绰���롣</span>');?></td></tr>
        <tr><td colspan="2"><b><?= db_to_html('���˵����...')?></b></td></tr>
        <tr><td colspan="2" class="col_2"><?= tep_draw_textarea_field('customers_remark','warp',50,5);?></td></tr>
		<tr><td class="grxx_tc_td" nowrap="nowrap"><?= db_to_html('��������:')?></td><td class="col_2">
		<?php
		if((int)$space_public) {
		  $space_public_1 = true;
		  $space_public_0 = false;
		}else{
		  $space_public_1 = false;
		  $space_public_0 = true;
		}
		?>
		<?php echo tep_draw_radio_field('space_public', '1', $space_public_1) . '&nbsp;&nbsp;' . db_to_html("����") . '&nbsp;&nbsp;' . tep_draw_radio_field('space_public', '0', $space_public_0) . '&nbsp;&nbsp;' . db_to_html("�ر�") ; ?>
		</td></tr>
		
        <tr><td colspan="2" class="col_2"><button id="submit_button" class="jb_fb_all" type="submit"><?= db_to_html('ȷ��')?></button>&nbsp;&nbsp;<button class="jb_fb_all" type="reset" style="display:none"><?= db_to_html('����')?></button></td></tr>

	   </table>
       </div>
     </div>
	 </form>
</div>
		<?php echo tep_pop_div_add_table('foot');?>
		</div>
 <script type="text/JavaScript">
     jQuery("#travel_companion_tips_2064").hide();
 </script>
		
 
 <!--�޸�face �ĵ�����start-->       
 <div id="travel_companion_tips_20121221" class="jb_fb_tc" style="text-decoration:none; display:none; top:70%; left:32%;">
	<?php echo tep_pop_div_add_table('top');?>
	<div class="jb_fb_tc_bt">
	<h3><?= db_to_html('����ͷ��')?></h3>
	<button class="icon_fb_bt" onclick="show_travel_companion_tips(0,20121221);" title="<?= db_to_html('�ر�')?>" type="button"></button>
	</div>
	<div class="jb_fb_tc_tab" style="width:480px;">
	<table>
	<tr>
	<td>
	<?php
	$width_height_px = '����ͼ���СΪ��114px��114px����С��'.$file_size.'KB!';
	$need_up_img_id = 'img_customers_face';	//�ύ��ɺ���Ҫ���µ�ͼƬ��id
	$need_up_form_id = 'account_edit'; //�ύ��ɺ���Ҫ���µı�id
	$need_up_form_input_name = 'customers_face'; //�ύ��ɺ���Ҫ���µı��ֶ�����
	$upload_type = 'face';	//�ϴ�����,�ͻ�ͷ��Ϊface
	$done_close_id = 'travel_companion_tips_20121221'; 
	require_once("ajax_upload.php");
	?>
	</td>
	</tr>
	</table>
	</div>
	<?php echo tep_pop_div_add_table('foot');?>
 </div>
 <!--�޸�face �ĵ�����end-->       
        
      </div>
      <div class="jb_grzx_bt"><span class="bt"><?= db_to_html($customers_name.'�����')?></span>
	  <?php
	  if($customers_id == $customer_id){
	  ?>
	  <a href="<?= tep_href_link('create_photos.php')?>" class="jb_fb_tc_bt_a"><?= db_to_html('�ϴ���Ƭ');?></a>
	  <a href="JavaScript:void(0)" class="jb_fb_tc_bt_a" onclick="create_album();"><?= db_to_html('�������');?></a>
		<?php
		//������Ṧ��
		require_once('ajax_create_album.php');
		?>

	  <?php
	  }
	  ?>
	  </div>
      
	  <?php
	  //�ҵ���� start
	  if(!(int)$photo_books['photo_books_id']){	//�����ʱ
	  ?>
	  <div class="grzx_notes"><span><?= db_to_html(preg_replace('/^��$/','��',$customers_name)."��û���ϴ���Ƭ�أ���ȥ������ҹ�ע�����ɣ�");?></span></div>
	  <div class="jb_grzx_bt"><a class="guanzhu" href="<?= tep_href_link('photo_books.php')?>"><?= db_to_html("��ҹ�ע�����");?></a></div>
	  <div class="jb_grzx_photo">
        <ul>
          <?php
		  $all_photo_books_sql = tep_db_query('SELECT * FROM `photo_books` Order By photo_sum DESC, photo_books_id DESC Limit 4 ');
		  while($all_photo_books = tep_db_fetch_array($all_photo_books_sql)){
			$books_cover_0 = "image/photo_1.gif";
			if(tep_not_null($all_photo_books['photo_books_cover'])){
				$tmp_img = 'images/photos/'.$all_photo_books['photo_books_cover'];
				if(file_exists($tmp_img)){
					$books_cover_0 = $tmp_img;
				}
			}
			$href_a_j = tep_href_link('photo_list.php','photo_books_id='.$all_photo_books['photo_books_id']);
			$href_a_t = db_to_html(tep_db_output($all_photo_books['photo_books_name']));
		  ?>
		  <li> 
                      <div class="jb_photo_a">
                          <p class="jb_photo">
                          <a href="<?= $href_a_j;?>"><img src="<?= get_thumbnails($books_cover_0);?>" <?php echo getimgHW3hw($books_cover_0,145,109)?> /></a>
                           </p>
                      </div>
            
            <p class="jb_photo_p col_5" style="text-align: center;"><a href="<?= $href_a_j;?>" title="<?= $href_a_t;?>"><?= cutword($href_a_t,20)?></a><br>
              <span><?= db_to_html('��'.$all_photo_books['photo_sum'].'��')?></span></p>
            
          </li>
          <?php
		  }
		  ?>
        </ul>
        
      </div>
	  <?php
	  }else{	//�����ʱ
	  ?>
	  <div class="jb_grzx_photo">
        <ul id="photo_books_ul">
          <?php
		  $loop_num = 0;
		  do{
			$books_cover = "image/photo_1.gif";
			if(tep_not_null($photo_books['photo_books_cover'])){
				$tmp_img = 'images/photos/'.$photo_books['photo_books_cover'];
				if(file_exists($tmp_img)){
					$books_cover = $tmp_img;
				}
			}
			$loop_num++;
			$dis_none = '';
			if($loop_num>4){ $dis_none = 'none';}
			$photo_list_href = tep_href_link('photo_list.php','photo_books_id='.$photo_books['photo_books_id']);
			$photo_list_href_text = db_to_html(tep_db_output($photo_books['photo_books_name']));
		  ?>
		  <li style="display:<?= $dis_none?>" id="photo_li_<?= $photo_books['photo_books_id']?>"> 
            <div class="jb_photo_a">
                <p class="jb_photo">
                <a href="<?= $photo_list_href?>"><img src="<?= get_thumbnails($books_cover);?>" <?php echo getimgHW3hw($books_cover,144,115)?> /></a>
                </p>
            </div>
            
            <p style="text-align:center" class="jb_photo_p col_5"><a href="<?= $photo_list_href?>" id="photo_books_name_<?= $photo_books['photo_books_id']?>" title="<?= $photo_list_href_text;?>"><?= cutword($photo_list_href_text,20)?></a>
			<br />
              <span><?= db_to_html('��'.$photo_books['photo_sum'].'��')?></span></p>
			  <p id="photo_books_description_<?= $photo_books['photo_books_id']?>" style="display:none"><?= db_to_html(tep_db_output($photo_books['photo_books_description']))?></p>
            <?php
			if($customers_id == $customer_id){
			?>
			<p style="text-align:center"><a href="JavaScript:void(0)" onclick="update_album(<?= $photo_books['photo_books_id']?>);" class="jb_fb_tc_bt_a"><?= db_to_html('�༭')?></a>&nbsp;<a href="JavaScript:void(0)" class="jb_fb_tc_bt_a" onclick="remove_album(<?= $photo_books['photo_books_id']?>, 'photo_li_<?= $photo_books['photo_books_id']?>')"><?= db_to_html('ɾ��')?></a>&nbsp;<a href="<?= tep_href_link('create_photos.php','photo_books_id='.$photo_books['photo_books_id'])?>" class="jb_fb_tc_bt_a"><?= db_to_html('�ϴ���Ƭ');?></a></p>
			<?php
			}
			?>
          </li>
          <?php
		  }while($photo_books = tep_db_fetch_array($photo_books_sql));
		  ?>
        </ul>
        <?php
		if($loop_num>4){
		?>
		<div class="more_photo"><a href="JavaScript:void(0)" onclick="show_all_li(this, 'photo_books_ul')"><?= db_to_html('�������')?> &gt;&gt;</a></div>
		<?php
		}
		?>
      </div>
      <?php
	  }
	  //�ҵ���� end
	  ?>
	  
	  <?php //��ȥ���ĵط� start?>
	  <div class="jb_hf">
        <h3><?= db_to_html($customers_name.'�¹������������ĵط�')?><span class="jb_gone_span"><!--(ÿ����·ǰ��λд�μ��߽������������)--></span></h3>
      </div>
     <?php
	 if (!(int)sizeof($orders_products) ) {	//�޽��ʱ
	 	
	 ?>
	 <div class="grzx_notes"><span><?= db_to_html('��û����ȥ�Ķ��𣿿���������Щ��ҳ�ȥ�ĵط�������Ȥ��');?></span></div>
	 <div class="jb_grzx_bt"><a class="guanzhu" href="<?php echo tep_href_link('all_orders_products.php');?>"><?= db_to_html('��ҳ�ȥ�ĵط�');?></a></div>
	 <?php
	 	$ord_sql = tep_db_query('SELECT o.customers_id , op.* FROM `orders` o, `orders_products` op WHERE o.orders_status = "100006" AND op.orders_id = o.orders_id Group By op.products_id Limit 5 ');
		while($ord = tep_db_fetch_array($ord_sql)){
			$ord_p_name = db_to_html(tep_get_products_name($ord['products_id']));
	 ?>
	 <div class="jb_gone_df line1">
        <div class="jb_gone_df_l"><a class="col_2" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $ord['products_id']);?>" title="<?= $ord_p_name?>"><?php echo cutword($ord_p_name,66)?></a></div>
        <div class="jb_gone_df_r">
          <p><?= substr($ord['products_departure_date'],0,10)?></p>
        </div>
     </div>
	 
	 <?php
		}
	 }else{	//�н��ʱ
		 foreach($orders_products as $key => $orders_rows){
	 		$products_name = db_to_html(tep_get_products_name($orders_rows['products_id']));
			//ͳ�Ƹ��û��ڸ����з����μ�����
			$photos_sql = tep_db_query('SELECT count(*) as total FROM `travel_notes` WHERE customers_id="'.$customers_id.'" AND products_id ="'.$orders_rows['products_id'].'" ');
			$travel_notes_total = tep_db_fetch_array($photos_sql);
			$travel_notes_total = $travel_notes_total['total'];
	 ?>
	  <div class="jb_gone_df line1">
        <div class="jb_gone_df_l"><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders_rows['products_id']);?>" class="col_2" title="<?= $products_name?>"><?php echo cutword($products_name,66)?></a></div>
        <div class="jb_gone_df_r">
          <p><?= substr($orders_rows['products_departure_date'],0,10)?>
		  <?php
		  if((int)$travel_notes_total){
		  ?>
		  <a href="<?= tep_href_link('travel_notes_list.php','products_id='.$orders_rows['products_id'].'&customers_id='.$customers_id);?>"><?= db_to_html('�μǣ�'.$travel_notes_total.'��')?></a>
		  <?php
		  }else{ echo db_to_html('�μǣ�'.$travel_notes_total.'��'); }
		  ?>
		  <?php 
		  if($customers_id == $customer_id){
		  ?>
		  &nbsp;
		  <img src="image/icons/write.gif" />&nbsp;<a href="<?= tep_href_link('create_photos.php','products_id='.$orders_rows['products_id'])?>" class="jb_fb_tc_bt_a"><?= db_to_html('дƪ�μ�')?></a>
		  <?php
		  }
		  ?>
		  </p>
        </div>
      </div>
     <?php
	 	}
	 }
	 ?> 
      
      
	  <?php //��ȥ���ĵط� end?>
	  
	  <?php
	  //�ҵİ��� start
	  $array_count = count($customers_travel_companion_per);
	  $loop_num = 0;
	  ?>
	  <div class="jb_hf">
        <h3><?= db_to_html($customers_name.'�İ���')?></h3>
      </div>
      <?php
	  if((int)$array_count){
	  ?>
	  <div class="jb_by">
        <ul id="travel_companion_per_ul">
        <?php
		for($i=0; $i<$array_count; $i++){
			$loop_num++;
			$li_none = '';
			if($loop_num>8){
				$li_none = 'none';
			}
			$links_href = tep_href_link('individual_space.php','customers_id='.$customers_travel_companion_per[$i]['customers_id']);
			$c_gender = tep_customer_gender($customers_travel_companion_per[$i]['customers_id']);
			$c_gender_str = tep_get_gender_string($c_gender, 1);
			$face_img = "tx_n_s.gif";
			if(strtolower($c_gender)=='m'){
				$face_img = "tx_b_s.gif";
			}
			if(strtolower($c_gender)=='f'){
				$face_img = "tx_g_s.gif";
			}
		?>
		  <li style="display:<?=$li_none?>"><a href="<?= $links_href?>"><img class="item_left_sec1_img" src="image/<?= $face_img?>" /></a>
            <p class="item_left_sec1_p1 col_5">
			<a href="<?= $links_href?>" class="t_c"><?= db_to_html(tep_db_output(tep_customers_name($customers_travel_companion_per[$i]['customers_id']).' '.$c_gender_str))?></a>
			<br />
			 <?= db_to_html('���'.$customers_travel_companion_per[$i]['travel_companion_total'].'��')?><br />
             <!--<a href="#" class="jb_fb_tc_bt_a">ɾ��</a>--></p>
          </li>
        <?php
		}
		?>
        </ul>
      </div>
	  <?php
	  	}else{
		?>
		<div class="grzx_notes"><span>
		<?php echo db_to_html("�Ҽ�������һ����У��ֺ����ֽ�ʡ��")?>
		<a class="t_c" href="<?php echo tep_href_link('new_travel_companion_index.php');?>"><?php echo db_to_html("ȥ���ͬ�ο�����")?></a></span></div>
	<?php
		}
	  ?>
      
	  <?php
	  if($loop_num>8){
	  ?>
	  <div class="more_photo"><a href="JavaScript:void(0)" onclick="show_all_li(this, 'travel_companion_per_ul')"><?= db_to_html('�������')?> &gt;&gt;</a></div>
	  <?php
	  }
	  //�ҵİ��� end
	  ?>
	  
    </div>


<?php
//���뷢վ�ڶ��Ź��ܿ�
require_once('ajax_send_site_inner_sms.php');
?>

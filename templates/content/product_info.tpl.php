<script type="text/javascript">
var data = <?php echo tep_get_product_month_price_datas((int)$products_id); //���������������Ҫ�����ںͼ۸����ݣ�?>;
</script>
<?php
	//��ƷͼƬ�ͻ�����Ϣ
	//include('product_info_module1.php');
	$shows_BigImageString = "";
	$shows_small_img_list = "";
	$img_n = 0;
	
	$ext_img_exist = tep_db_query("select prod_extra_image_id, product_image_name from ".TABLE_PRODUCTS_EXTRA_IMAGES." where products_id = '".$product_info['products_id']."' order by image_sort_order ");
	
	if(tep_db_num_rows($ext_img_exist)>0){
		if($product_info['products_image_med']!=''){
			$product_info['products_image_med'] = ((stripos($product_info['products_image_med'],'http://')===false) ? 'images/':'').$product_info['products_image_med'];
			
			$shows_BigImageString .= '<a id="lightBoxImg_'.$img_n.'" '.$a_big_img_style.' href="'.$product_info['products_image_med'].'" title="'.addslashes(db_to_html($product_info['products_name'])).'"><img src="'.$product_info['products_image_med'].'" /></a>';
			$shows_small_img_list .= '<li><img src="'.get_thumbnails_fast($product_info['products_image_med']).'" '.$small_class.' /></li>';
		}
		
		while($extra_images_rows = tep_db_fetch_array($ext_img_exist)){
			$img_n++;
			$url_product_image_name = 'images/'.$extra_images_rows['product_image_name'];
			if(preg_match('/^http:/',$extra_images_rows['product_image_name'])){
				$url_product_image_name = $extra_images_rows['product_image_name'];
			}
			$shows_BigImageString .= '<a id="lightBoxImg_'.$img_n.'" '.$a_big_img_style.' href="'.$url_product_image_name.'" title="'.addslashes(db_to_html($product_info['products_name'])).'"><img src="'. $url_product_image_name.'"  alt="'.db_to_html('����鿴��ͼ').'" title="'.db_to_html('����鿴��ͼ').'"/></a>';
			$shows_small_img_list .= '<li><img src="'.get_thumbnails_fast($url_product_image_name).'" '.$small_class.' /></li>';
		}
			
	}else{
		if ($product_info['products_image_med']!='') {
			$new_image = $product_info['products_image_med'];
		} else {
			$new_image = $product_info['products_image'];
		}
		
		if(!tep_not_null($new_image)){
			$new_image = 'noimage_large.jpg';
		}
		$new_image = ((stripos($new_image,'http://')===false) ? 'images/':'').$new_image;
		$shows_BigImageString .= '<a id="lightBoxImg_1" title="'.addslashes(db_to_html($product_info['products_name'])).'" href="'.$new_image.'"><img src="images/'.$new_image.'"  alt="'.db_to_html('����鿴��ͼ').'" title="'.db_to_html('����鿴��ͼ').'"/></a>';
		$shows_small_img_list .= '<li><img src="'.get_thumbnails_fast($new_image).'" /></li>';
	}
	//=====�Ƶ��ͼƬ��Ϣ{
	if($isHotels){
		
		$imagesInfos = getHotelImagesInfos($product_info['hotel_id']);
		if($imagesInfos!=false){
			$img_n = max($img_n,1);
			for($i=0, $n=sizeof($imagesInfos); $i<$n; $i++){
				$img_n++;
				$shows_BigImageString .= '<a id="lightBoxImg_'.$img_n.'" title="'.addslashes(db_to_html($imagesInfos[$i]['alt'])).'" href="'.$imagesInfos[$i]['src'].'"><img src="'.$imagesInfos[$i]['src'].'"  alt="'.db_to_html('����鿴��ͼ').'" title="'.db_to_html('����鿴��ͼ').'"/></a>';
				$shows_small_img_list .= '<li><img src="'.get_thumbnails_fast($imagesInfos[$i]['src']).'" /></li>';
			}
		}
	}
	//=====�Ƶ��ͼƬ��Ϣ}


	//������
$close_time_num =  count($PopupObj);
$question_done_tip = "PopupTransferServiceRequest";
$question_done_con_id = "PopupTransferServiceRequestCon";
$con_contents = db_to_html('		
			<div class="popupCon" id="PopupTransferServiceRequestCon" >
			<div id="CSR_SUCCESS" style="display:none">
				 <div class="popupConTop" id="drag">
	                <h3><b>�����Զ�������Ѿ��ɹ��ύ</b> </h3>
	                <span><a href="javascript:closePopup(\'PopupTransferServiceRequest\')"><img src="'.DIR_WS_ICONS.'icon_x.gif"></a></span>
	            </div>      
				<div class="successTip" >
					<div class="img"><img src="'.DIR_WS_TEMPLATE_IMAGES.'success.jpg"></div>
					<div class="words">����Ҫ�ķ��������Ѿ��ɹ��ύ�����ǽ��ᾡ��������ϵ��</div>
				</div>
				 <div class="btnCenter">
                 	<a href="javascript:;" class="btn btnOrange" onclick="closePopup(\'PopupTransferServiceRequest\')"><button type="button" >ȷ��</button></a>            	
           		 </div>
			</div>
			<div id="CSR_FORM">
	            <div class="popupConTop" >
	                <h3><b>����Ҫ�ķ���</b>(������Ϣ����) </h3>
	                <span><a href="javascript:closePopup(\'PopupTransferServiceRequest\')"><img src="'.DIR_WS_ICONS.'icon_x.gif"></a></span>
	            </div>           
				<div id="CSR_LOADING" style="display:none;text-align:center;line-height:50px;height:50px;" >
					<img src="image/loading_16x16.gif" align="absmiddle" /> �����ύ�����Ժ�
				</div>	
				'.tep_draw_form('customer_service', tep_href_link('ajax_customer_service_request.php'),'post','id="CustomerService" onsubmit="return false"').'					
	            <ul class="emailCon popupShuttleCon">
	                <li><label>����:</label>'.tep_draw_input_num_en_field('name' , '','class="text name required "  title="��������������"').'</li>
	                <li><label>&nbsp;</label><span>��ʹ��������ƴ����</span></li>
	                <li><label>�ֻ�:</label>'.tep_draw_input_field('mobile_phone' , '','class="text required " title="�����������ֻ�����"').'</li>
	                <li><label>����:</label>'.tep_draw_input_field('email' , '','class="text required validate-email" title="��������������"').'</li>
	                <li><label>����:</label>'.tep_draw_textarea_field('comment', false, '60', '3','����ϸ������Ҫ����Ϊ���ṩ�ķ��񣬰���׼ȷ��ʱ�䡢�ص�������Ϣ�����ǻ��һʱ������ȡ����ϵ��','onBlur="if(this.value==\'\'){this.value=\'����ϸ������Ҫ����Ϊ���ṩ�ķ��񣬰���׼ȷ��ʱ�䡢�ص�������Ϣ�����ǻ��һʱ������ȡ����ϵ��\';this.style.color=\'#999\';}" onFocus="if(this.value==\'����ϸ������Ҫ����Ϊ���ṩ�ķ��񣬰���׼ȷ��ʱ�䡢�ص�������Ϣ�����ǻ��һʱ������ȡ����ϵ��\'){this.value=\'\';this.style.color=\'#111\';}" style="color:#999;" class="textarea required "').'</li>
	            </ul>    				
	            <div class="btnCenter">            
	            	'.tep_draw_hidden_field('from_url' , '','id="CSR_FromUrl"').tep_draw_hidden_field('action' ,'add_service_request').'
	                 <a href="javascript:;" class="btn btnOrange"  id="csrbtn1" onclick=""><button type="submit" >�� ��</button></a>
	            	<a href="javascript:;" class="btn btnGrey"  style="display:none"  id="csrbtn2" onclick="javascript:;"><button type="button" id="csrbtn">���Ժ�</button></a>
	             </div>
				 </form>
             </div>
	     </div>
	     <script type="text/javascript">
		valid = new Validation(\'CustomerService\', {immediate : true,useTitles:true, onFormValidate : submit_csrform});	
		function submit_csrform(result, form){
			if(result == true) {
				jQuery(\'#csrbtn1\').hide();jQuery(\'#csrbtn2\').show();jQuery(\'#CSR_FromUrl\').val(location.href);
				ajax_submit(\'CustomerService\');
			}
			return false;
		}
		</script>
	     ');
$h4_contents = db_to_html("�ύ��Ҫ�ķ���");
$PopupObj[] = tep_popup_alert($question_done_tip, $question_done_con_id, "470", $h4_contents, $con_contents );

$close_time_num = count($PopupObj);
$question_done_tip = "PopupNotice";
$question_done_con_id = "PopupNoticeCon";
$con_contents = db_to_html('
	<div id="PopupNoticeConCompare" class="popupCon">
			<div class="addSuccess">
				<div class="popContent">
					<div class="popContentA">
						<div class="popContentWords" id="PopupNoticeWords">
							<p> ��Ϣ���ѡ�</p>
						</div>
					</div>
				</div>
				<div class="btnCenter">
					<a class="btn btnOrange" onclick="closePopup(\'PopupNotice\');" href="javascript:;"><button type="button">�ر�</button></a>
				</div>
			</div>
	</div>');
$h4_contents = db_to_html("��Ϣ����");
$PopupObj[] = tep_popup_alert($question_done_tip, $question_done_con_id, "400", $h4_contents, $con_contents );

	
	 //��ʾ�ؼ۱�ǩ������2��2����2��1��˫���ؼۡ���ͨ�ؼ۵����ȴ�����
	 $specials_num = 0;
	 $special_str = '';
	 $is_buy2get2 = check_buy_two_get_one($product_info['products_id'],'4');
	 $is_buy2get1 = check_buy_two_get_one($product_info['products_id'],'3');
	 $is_double_special = double_room_preferences($product_info['products_id']);
	 $is_special = check_is_specials($product_info['products_id'],true,true);
	 //tour_type_icon
	 /*
	 $tour_type_icon_sql = tep_db_query("select tour_type_icon from " . TABLE_PRODUCTS . " where products_id= '".$product_info['products_id']."' ");
	 $tour_type_icon_row = tep_db_fetch_array($tour_type_icon_sql);*/
	$tour_type_icon_row = array('tour_type_icon'=>$product_info['tour_type_icon']);					
	if((int)$is_special || preg_match('/\bspecil\-jia\b/i',$tour_type_icon_row['tour_type_icon'])){
		$specials_num++;
		$special_str = '�ؼ�';
	}
	if((int)$is_double_special || preg_match('/\b2\-pepole\-spe\b/i',$tour_type_icon_row['tour_type_icon'])){
		$specials_num++;
		$special_str = '˫���ۿ�';
	}
	if(($listing['products_class_id']=='4' && ($is_buy2get1=='1' || $is_buy2get1=='2') || preg_match('/\bbuy2\-get\-1\b/i',$tour_type_icon_row['tour_type_icon'])) ){
		$specials_num++;
		$special_str = '��2��1';
	}
	if(($listing['products_class_id']=='4' && ($is_buy2get2=='1' || $is_buy2get2=='3')) || preg_match('/\bbuy2\-get\-2\b/i',$tour_type_icon_row['tour_type_icon'])){
		$specials_num++;
		$special_str = '��2��2';
	}
	if($special_str!= '')$special_str = '<b>'.db_to_html($special_str).'</b>';
	$te_jia_on_list_div = '';
	if(tep_not_null($special_str)){
		$te_jia_on_list_div = '<div class="tag"  >'.$special_str.'</div> ';						
	}
?>


<div id="product_info_content">
	<?php
	if ($messageStack->size('product_info') > 0) {
	?>
		<div><?php echo $messageStack->output('product_info'); ?></div>
	<?php
	}
	?>
	<?php 
//���ٵ�¼���� ����review question begin
//@author vincent
$popupTip = "CommonFastLoginPopup";
$popupConCompare = "CommonFastLoginPopupConCompare";
function get_common_fast_login_popup(){
	global $customer_id, $popupTip, $popupConCompare;
	if(!(int)$customer_id)
		$con_contents ='<script language="javascript">fastlogin_success = false;</script>';
	else
		$con_contents='<script language="javascript">fastlogin_success = true;</script>';	

	$con_contents .= '<div class="login">'.tep_draw_form($popupTip.'_form','','post', ' id="'.$popupTip.'_form" ').'
        <ul>
            <li><label>'.db_to_html('��������:').'</label>'.tep_draw_input_field('email_address','','class="required validate-email text username" title="'.db_to_html('���������ĵ�������').'"').'</li>
            <li><label>'.db_to_html('����:').'</label><input name="password" type="password" class="required text password" title="'.db_to_html('��������ȷ������').'" /></li>
            <li><label>&nbsp;</label><input type="submit" class="loginBtn" value="'.db_to_html('&nbsp;��&nbsp;¼').' "></li>
            <li><label>&nbsp;</label><a href="'.tep_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL').'">'.db_to_html('��������?').'</a>'.db_to_html(sprintf('&nbsp;&nbsp;���û���&nbsp;<a href="%s">ע��</a>',tep_href_link("create_account.php","", "SSL"))).'</li>
        </ul></form>
    </div>';
	$h4_contents = db_to_html('<b>���ȵ�¼</b>');
	$PopupHtml = tep_popup($popupTip, $popupConCompare, "480", $h4_contents, $con_contents );
	return $PopupHtml;
}
$PopupObj[] = get_common_fast_login_popup();
//���ٵ�¼���� ����review question end
	?>
	<?php
	  if ($product_check['total'] < 1) {
	?>
	 <table width="786"  border="0" cellspacing="0" cellpadding="0">
	 <tr>
        <td ><?php new infoBox(array(array('text' => TEXT_PRODUCT_NOT_FOUND))); ?></td>
      </tr>
      <tr>
        <td ><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td ><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_template_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
	<?php
		} else { 
	  
		//howard added ���빺�ﳵ���� start
		$add_cart_msn = "add_cart_msn";
		$add_cart_msn_con_id = "add_cart_msn_con";
		$add_cart_msn_h4_contents = db_to_html("�����ѳɹ���ӵ����ﳵ��");
		$add_cart_msn_contents = '
		
		<div class="successTip">
            	<div class="img"><img src="'.DIR_WS_TEMPLATE_IMAGES.'success.jpg"></div>
				<div class="words">
<p>'.db_to_html('�г̡�').' <a href="'.tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('info','seeAll','vin_tab','mnu','page','rn'))).'">'.db_to_html($products_name).'</a>'.db_to_html('���Ѿ����빺�ﳵ��').'</p>
<p>'.db_to_html('���ﳵ�� <span>[Cart_Sum] </span>����').'&nbsp;&nbsp;&nbsp;&nbsp;'.db_to_html('�ϼƣ�<span>[Cart_Total]</span>').'</p>
				</div>
            </div>
		<div class="btnCenter">
			<a class="btn btnOrange" href="' . tep_href_link('shopping_cart.php') . '"><button type="button">'. db_to_html('�鿴���ﳵ').'</button></a>&nbsp;&nbsp;
			<a class="btn btnGrey" href="javascript:;" onclick="closePopup(&quot;'.$add_cart_msn.'&quot;)"><button type="button">'. db_to_html('��������').'</button></a>
		</div>
		';
		$PopupObj[] = tep_popup_notop($add_cart_msn, $add_cart_msn_con_id, "440", $add_cart_msn_h4_contents, $add_cart_msn_contents );
		//howard added ���빺�ﳵ���� end
		?>
	<?php 
				  //���ȫ����ѯ/���� ��Ƭ��ʱ�� Ϊ��Ʒ��������� 	
				  $num_question = get_product_question_num($product_info['products_id']);
				  $num_review = get_product_reviews_num($product_info['products_id']);
				  $num_photo = get_traveler_photos_num($product_info['products_id']);
				  $textPhoto = db_to_html('��������Ƭ����');
				  $textReview =db_to_html('�������ο�����');
				  $textQuestion = db_to_html('������������ѯ');
				  $num = 0;
				  if($mnu == 'photos'){
				  		$num =  $num_photo;				  		
				  		$text = $textPhoto;
				 }elseif($mnu == 'reviews'){
				  		$num =  $num_review;				  	
				  		$text = $textReview;
				}elseif($mnu == 'qanda'){
				  		$num =  $num_question;				  		
				  		$text = $textQuestion;
				}
 ?>
 <script type="text/javascript">
function updateTitle(type){
	if(type == "question"){
		jQuery("#view_all_counter1").html("<?php echo $num_question?>");
		jQuery("#view_all_title").html("<?php echo $textQuestion?>");
	}else if(type == "review"){
		jQuery("#view_all_counter1").html("<?php echo $num_review?>");
		jQuery("#view_all_title").html("<?php echo $textReview?>");
	}else if(type == "photo"){
		jQuery("#view_all_counter1").html("<?php echo $num_photo?>");
		jQuery("#view_all_title").html("<?php echo $textPhoto?>");
	}
}
</script>
			<div class="title titleDetailTop"><b></b><span></span></div>
			<div class="proDes">
				<?php 
				//���۵���ַ������Ϣ�� start {
				echo db_to_html(servers_sales_track::output_url_box($products_id));
				//���۵���ַ������Ϣ�� end }
				?>
				<div class="topTitle">
				  <h1>
				  <?php  if($_GET['seeAll']){?> 
				  <span><?php echo db_to_html(sprintf('��<span id="view_all_counter1">%d</span>λ�ο���',$num)) ?> </span>&quot;<a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('info','seeAll','vin_tab','mnu','page','rn')));?>"><?php echo db_to_html($products_name); ?></a> &quot;<span id="view_all_title" ><?php echo $text ?></span>
				  <?php }
				  else	  echo db_to_html($products_name); 
				  ?></h1>
				  <h2><?php echo db_to_html(str_replace('**','',$products_name1)); ?>&nbsp;</h2>
                  <em></em>
				  <?php
				  include(DIR_FS_MODULES.'product_info/share_to_friend.php');
				  ?>
				</div>
				
				<?php
				if((int)$product_info['GroupBuyType']){
				?>
				<div id="groupBuyDiv" class="groupBuy">
					<a href="<?= tep_href_link('group_buys.php');?>" class="groupTag"><?php echo db_to_html('�Ź�') ?></a>
					<div class="countdown">
						<label><?= db_to_html('���뱾���Ź���������:')?></label>
						<span id="CountDown<?= $product_info['products_id']?>"></span>
					</div>
					
					<div class="countdown orderNum">
						<span><?= db_to_html($product_info['orderNumMsn'])?></span>
					</div>
				</div>
				<script type="text/javascript">
				GruopBuyCountdown(<?= $product_info['products_id']?>, <?= $product_info['CountdownEndTime']?>,'CountDown<?= $product_info['products_id']?>','groupBuyDiv');
				</script>
				<?php
				}
				?>
				<div class="box">
				<div class="proDesDetail">			            
<div class="left">
			<?php echo 	$te_jia_on_list_div;?>
<div class="slider">
<div class="bigImage" id="BigImage">
<?php echo $shows_BigImageString;?>
</div>
<div class="scrollBar">
    <a href="javascript:;" class="goLeft" onfocus="this.blur()" id="PreBtn"></a>
    <div class="scroll" id="Scroll">
        <ul>
             <?php echo $shows_small_img_list;?>
        </ul>
    </div>
    <a href="javascript:;" class="goRight" onfocus="this.blur()" id="NextBtn" ></a>
</div>
            
</div>
		  
        </div>

		<div class="lwkClass">
				<!--�Ż������� start-->
				<div><ul class="mid">
				  <li>
					<label><?php 
					if($product_info['is_hotel']) {
						echo db_to_html('�Ƶ��ţ�');
					} else {
						echo TEXT_TOUR_CODE;
					}?></label>
					<p><?php echo $product_info['products_model'];?></p>
				  </li>
				  <li>
					<label>
					<?php 
					if($product_info['is_hotel']==1){
						$HEDING_TEXT_TOUR_DEPARS_AT = db_to_html("��������");
					}elseif($product_info['is_transfer']==1){
						$HEDING_TEXT_TOUR_DEPARS_AT = db_to_html("��������");
					}elseif($product_info['is_cruises']==1){
						$HEDING_TEXT_TOUR_DEPARS_AT = db_to_html("�����ۿڣ�");
					}else{
						$HEDING_TEXT_TOUR_DEPARS_AT = db_to_html('�� �� �أ�');//HEDING_TEXT_TOUR_DEPARS_AT;
					}
					echo $HEDING_TEXT_TOUR_DEPARS_AT;
				?>
					
					</label>
					<p>
						<?php 
						if($product_info['departure_city_id'] == '')$product_info['departure_city_id'] = 0;
						$city_class_departure_at_query = tep_db_query("select c.city_id, c.city, s.zone_code, co.countries_iso_code_3  from " . TABLE_TOUR_CITY . " as c ," . TABLE_ZONES . " as s, ".TABLE_COUNTRIES." as co where c.state_id = s.zone_id and s.zone_country_id = co.countries_id and c.city_id in (" . $product_info['departure_city_id'] . ") order by c.city ");
						while($city_class_departure_at = tep_db_fetch_array($city_class_departure_at_query)) {
							$product_info['departure_city_name'] = $city_class_departure_at['city'];
							echo  db_to_html($city_class_departure_at['city']).', '.$city_class_departure_at['zone_code'].', '.$city_class_departure_at['countries_iso_code_3'].'&nbsp;';
						}
						
						//���Ƶ��������� start
						if((int)$product_info['approximate_location_id']){
							echo db_to_html(getHotelApproximateLocation($product_info['approximate_location_id']));
						}
						//���Ƶ���������end 
						?>
                        
					</p>
				  </li>
				  
				<?php if($product_info['is_hotel']==0 && $product_info['is_transfer'] == '0'){
					$HEDING_TEXT_TOUR_DEPARS_ENDS_AT = HEDING_TEXT_TOUR_DEPARS_ENDS_AT;
					if($product_info['is_cruises']==1){
						$HEDING_TEXT_TOUR_DEPARS_ENDS_AT = db_to_html('�ִ�ۿڣ�');
					}
				?>
				  <li>
					<label><?php echo $HEDING_TEXT_TOUR_DEPARS_ENDS_AT;?></label>
					<p>
						<?php
						if($product_info['departure_end_city_id'] == '')$product_info['departure_end_city_id'] = 0;
						$city_class_departure_end_at_query = tep_db_query("select c.city_id, c.city, s.zone_code, co.countries_iso_code_3  from " . TABLE_TOUR_CITY . " as c ," . TABLE_ZONES . " as s, ".TABLE_COUNTRIES." as co where c.state_id = s.zone_id and s.zone_country_id = co.countries_id and c.city_id in (" . $product_info['departure_end_city_id'] . ")");
						while($city_class_departure_end_at = tep_db_fetch_array($city_class_departure_end_at_query)) {
							echo  db_to_html($city_class_departure_end_at['city']).', '.$city_class_departure_end_at['zone_code'].', '.$city_class_departure_end_at['countries_iso_code_3'].'<br />';
						}																						
						?>
					</p>
				  </li>
				  <?php }?>
				  <?php if($product_info['is_hotel'] == 0   ){ //hotel-extension �Ƶ��Ʒ����ʾ����ʱ��ͳ���ʱ��?>
				  <li>
					<label><?php 
							if($product_info['is_transfer'] == '1'){
								$TEXT_OPERATE = db_to_html("�������ڣ�");
							}elseif($product_info['is_cruises']==1){
								$TEXT_OPERATE = db_to_html("�������ڣ�");
							}else{
								$TEXT_OPERATE = TEXT_OPERATE;
							} 
							echo $TEXT_OPERATE; ?>
					</label>
					<p id="operate_info">
					<?php  
					$date_arr = explode('��',$product_info['operate'][0]);
					if (count($date_arr) > 3) {
						$show=true;
						$before = array_splice($date_arr,0,3);
						echo join('��',$before);
						if (count($product_info['operate']) == 1){
							echo '<span class="more" onmouseover="jQuery(\'#MoreCon1\').show();" onmouseout="jQuery(\'#MoreCon1\').hide();">'; 
							echo '<a href="javascript:;" >' . db_to_html('�鿴ȫ��') . '</a>'; 
							echo '<span id="MoreCon1" style="display:none" class="MoreCon"><span class="topArrow"></span><span class="con">';
							echo join('��',$date_arr);
							echo '</span><span id="tipBg"></span> 
									</span> 
								</span>';
						}
						
					} else {
						echo join('��',$date_arr);
					}
					
					
					//$product_info['operate'][0];?>
						<?php if(count($product_info['operate'])>1){
								//110815-2_������ϸҳ���鿴ȫ�����Ż�
								$all_operate = $product_info['operate'];
								$irregdate = trim($all_operate[count($all_operate) -1 ]);
								if(strpos($irregdate,'- ') === false){
									unset($all_operate[count($all_operate) -1 ]);
								}else{
									$irregdate = '';
								}
								$regdate = implode("<br />",$all_operate );								

							?>
							<span class="more" onmouseover="jQuery('#MoreCon').show();" onmouseout="jQuery('#MoreCon').hide();"> 
								<a href="javascript:;" ><?php echo db_to_html('�鿴ȫ��');?></a> 
								<span id="MoreCon"> 
									<span class="topArrow"></span><span class="con">									
									<?php 
									if ($show == true) {
										echo join('��',$date_arr);
									}
									$index = 1 ;
									if(trim($regdate) != '') {
										echo db_to_html('<strong>'.$index.'����������</strong><br/>');
										echo $regdate;
										$index++;
									}
									if(trim($irregdate) != '') {
										echo db_to_html('<br/><strong>'.$index.'����������</strong><br/>');
										echo  $irregdate;
									}

								//echo  implode("<br/>" ,$product_info['operate']);?></span><span id="tipBg"></span> 
								</span> 
							</span> 
                       <?php }?>
					</p>
				  </li>
				  <li style="display:none">
					<label><?php echo db_to_html('����ʱ�䣺'); ?></label>
					<p>
					<?php
					$h_or_d = "��";
					if($product_info['products_durations_type']=="1"){
						$h_or_d = "Сʱ";
					}
					echo $product_info['products_durations'].db_to_html($h_or_d);
					?>
					</p>
				  </li>
				  <?php }elseif($product_info['is_hotel']){
					  //hotel-extension
					  //$product_info['is_hotel']
				  
				  ?>
				  		<li><label><?php echo db_to_html('�Ƶ��Ǽ���');?></label><p class="stars<?= (int)$product_info['hotel_stars']?>"><?php echo db_to_html($product_info['hotel_stars']."��");?></p></li>
				  <?php
					  if((int)$product_info['meals_id']){
					  ?>
				 		<li><label><?php echo db_to_html('��������');?></label><p><?php echo db_to_html(getHotelMealsOptions($product_info['meals_id']));?></p></li>
					  <?php
					  }
					  if((int)$product_info['internet_id']){
					  ?>
				 		<li><label><?php echo db_to_html('�������');?></label><p><?php echo db_to_html(getHotelInternetOptions($product_info['internet_id']));?></p></li>
					  <?php
					  }
					  if((int)$product_info['approximate_location_id']){
					  ?>
				 		<li style="display:none"><label><?php echo db_to_html('��������');?></label><p><?php echo db_to_html(getHotelApproximateLocation($product_info['approximate_location_id']));?></p></li>
					  <?php
					  }
					  if(tep_not_null($product_info['hotel_address'])){
					  ?>
				 		<li><label><?php echo db_to_html('�Ƶ��ַ��');?></label><p><?php echo db_to_html($product_info['hotel_address']);?></p></li>
					  <?php
					  }
					  /*if(tep_not_null($product_info['hotel_phone'])){
					  ?>
				 		<li><label><?php echo db_to_html('�Ƶ�绰��');?></label><p><?php echo db_to_html($product_info['hotel_phone']);?></p></li>
					  <?php
					  }*/
				  }
				  ?>
				  <li>				<?php 
					//�����ǩ
					$tags = array();
					//if($product_info['upgrade_to_product_id']!='')$tags['recommend'] = db_to_html("ǿ���Ƽ�") ;//���ķ��Ƽ�
					if(($product_info['products_class_id']=='4' && ($is_buy2get1=='1' || $is_buy2get1=='2' )) || preg_match('/\bbuy2\-get\-1\b/i',$product_info['tour_type_icon']))
						$tags['buy2get1'] = array('title'=>db_to_html('�����һ'), 'tips'=>db_to_html('�����һ��ֻ��֧��2�ˣ�ͬסһ�������ŷѺ���Ӧ�ĸ��ӷѣ�����3�ˣ�ͬסһ�������š�')) ;//�����һ
											
					$is_buy2get2 = (int)check_buy_two_get_one($product_info['products_id'],'4');
					if(($product_info['products_class_id']=='4' && ($is_buy2get2=='3' || $is_buy2get2=='1')) || preg_match('/\bbuy2\-get\-2\b/i',$product_info['tour_type_icon']))
						$tags['buy2get2'] = array('title'=>db_to_html('����Ͷ�'), 'tips'=>db_to_html('����Ͷ���ֻ��֧��2�ˣ�ͬסһ�������ŷѣ�����4�ˣ�ͬסһ�������š�')) ;//����Ͷ���	
										
					if(double_room_preferences($product_info['products_id']) || preg_match('/\b2\-pepole\-spe\b/i',$product_info['tour_type_icon'])) 
						$tags['2peplespe']= array('title'=>db_to_html('˫���ۿ�'), 'tips'=>db_to_html('˫���ۿ�'));//˫���ۿ���
						
					if(check_is_specials($product_info['products_id'],true,true) || preg_match('/\bspecil\-jia\b/i',$product_info['tour_type_icon']))
						$tags['specil'] = array('title'=>db_to_html('�ؼ�'),'tips'=>db_to_html('�ؼ��ţ�5%�ۿ�')) ;//�ؼ���
						
					if($product_info['products_stock_status']=='0') 
						$tags['saleover'] = array('title'=>db_to_html('�Ѿ�����'),'tips'=>db_to_html('Ŀǰ���г���ʱ���꣡')) ;//�Ѿ�����		
					
					//�ͼ۱�֤
					if(defined('LOW_PRICE_GUARANTEE_PRODUCTS') && tep_not_null(LOW_PRICE_GUARANTEE_PRODUCTS)){
			        	$tmp_array = explode(',',LOW_PRICE_GUARANTEE_PRODUCTS);
			            for($i=0; $i<sizeof($tmp_array); $i++){
							if(trim($tmp_array[$i])==(int)$product_info['products_id']){
								$tags['lowprice'] = array('title'=>db_to_html('�ͼ۱�֤'),'tips'=>db_to_html('��֤ȫ����ͼ۸�')) ;											
								break;
							}
						}
			        }
					if (count($tags) > 0) {
					?>
					<ul class="tags">
                    <li class="caption"><?php echo db_to_html('�������')?></li>
					<?php $i=0 ;foreach($tags as $tag){	$class = $i%2 == 0 ? 'blue':'green';?>					
                        <li class="tooltip <?php echo $class?>" tooltip="<?php echo $tag['tips'];?>"><?php echo $tag['title'];?></li>
                    <?php $i++;}  ?> 
					</ul>
					<?php 
					}
					/* old ����� <label><?php echo db_to_html('�� �� �ȣ�')?></label>
					<p><img src="image/icons/icon_face.gif" /> <span id="comment_bai_fen_bi">99%</span></p> */ ?>
					</li>
				  </ul>
				<!--�ż۸� start-->
				<div class="right">
				  <?php 
				  //print_r($products_price);
				  echo $products_price;
				  ?>
					
					<?php if($display_fast==true){?>
						<?php /*<p><a href="javascript:void(0)" onClick="setProductTab('one',2,5); scroll(0,jQuery('#one2').offset().top)"><?php echo db_to_html('�۸���ϸ')?></a></p>*/?>
                        <?php if($product_info['display_room_option']=="1"){?>
						<p class="qi_p"><a href="javascript:void(0)" id="a1" class="icon_help"><?php echo db_to_html('���˵��')?><span><strong><i></i></strong><font><?php 
						if($product_info['is_hotel']) {
							echo db_to_html('�����ָ��λ������סͬһ����ÿ����֧���ļ۸�������ס�����˺͵����ˣ��۸�����ա��۸���ϸ����');
						} elseif((in_array($product_info['agency_id'], array("212","219")) && !in_array($product_info['products_id'], array('2782','2783','2784','2785','2786','2787','2788','2789'))) || in_array($product_info['products_id'],array(107,108,111,199,110,103,112,203,105,109,104,201,100,2681,2680,2679,2678,2677,2676,2732,2677,2733,2851,2676,2678,2852,2883,3041,3040,2754,2755,2756,2757,2758,2759,2760,2952,2953,2954,2955,2956,3081,3082,3083,3084,308,3199,3201,3203,3205,3207,3209,3211))) {
							echo db_to_html('����ͬסһ����׼����ÿ������֧���ļ۸񣬷���������Full size��Ϊ���������˼���ͯ���ټӴ���');
						} else{
							echo db_to_html('�������ָ����ͬסһ����׼��ÿ������֧���ļ۸񣬷���������Full size��Ϊ���������������˼���ͯ���ټӴ���');
						}
							?></font><label></label></span></a></p>
						<?php }?>
					<?php
					}else{
						echo '<p><a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'mnu=prices&'.tep_get_all_get_params(array('info','mnu','rn'))).'">'.db_to_html('�۸���ϸ').'</a></p>';
					}
					// ���� start {
					
					   // Points/Rewards system V2.1rc2a BOF
						if ((USE_POINTS_SYSTEM == 'true') && (DISPLAY_POINTS_INFO == 'true')) {
							if(!in_array($product_info['products_id'], array_trim(explode(',',NOT_GIFT_POINTS_PRODUCTS)))){
								if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
									$products_price_points = tep_display_points($new_price, tep_get_tax_rate($product_info['products_tax_class_id']));
								} else {
									$products_price_points = tep_display_points($product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']));
								}
								$products_points = tep_calc_products_price_points($products_price_points);
								$products_points = get_n_multiple_points($products_points , $product_info['products_id']);							
								//$products_points_value = tep_calc_price_pvalue($products_points);
								
								if ((USE_POINTS_FOR_SPECIALS == 'true') || $new_price == false) {
									echo db_to_html(sprintf('<p>�� %s <a href="'.tep_href_link('points.php').'">����</a></p>' , number_format($products_points,POINTS_DECIMAL_PLACES))) ;//old TEXT_PRODUCT_POINTS
								}
							}else{
								echo db_to_html(sprintf('<p>�� %s <a href="'.tep_href_link('points.php').'" title="������·����������Żݣ��������ͻ��֣�лл!">����</a></p>' , '0')) ;
							}
						}
					// Points/Rewards system V2.1rc2a EOF 
					//} ���� end

					//�Ź� group buy start
					if(GROUP_BUY_ON==true){	//�Ź�
				
						$discount_percentage = auto_get_group_buy_discount($product_info['products_id']);
						if($discount_percentage>0){
							echo '<div class="groupOrder">
                        <div class="tip" onmouseover="jQuery(\'#groupCon\').show();" onmouseout="jQuery(\'#groupCon\').hide();">
                            <img src="image/icons/green_right.gif"><div style=" display:none;" id="groupCon"><span class="botArrow"></span><span class="tipCon">'.db_to_html(GROUP_MIN_GUEST_NUM.'�˼����ϲμ��г�Ϊ��������ϵ��ż�����������Ԥ��'.($discount_percentage*100).'%���Żݡ�').'</span></div>
                        </div>
                       <a target="_blank" href="'.tep_href_link('landing-page.php','landingpagename=group_buy').'">'.db_to_html("����Ԥ��").'</a>
                    </div>';							
						}
					 }
					?>
					<?php
					if($product_info['upgrade_to_product_id']!=''){
						echo '<div class="recommended"><a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$product_info['upgrade_to_product_id']).'">'.tep_template_image_button('recommended.gif', '', '', '', 'align="absmiddle" ').'</a></div>';#
					}
					?>				
				<?php 
				//�����ǩ
				/* ��Sofia ����˼ �Ƶ�����ȥ�� 	$tags = array();
					//if($product_info['upgrade_to_product_id']!='')$tags['recommend'] = db_to_html("ǿ���Ƽ�") ;//���ķ��Ƽ�
					if(($product_info['products_class_id']=='4' && ($is_buy2get1=='1' || $is_buy2get1=='2' )) || preg_match('/\bbuy2\-get\-1\b/i',$product_info['tour_type_icon']))
						$tags['buy2get1'] = db_to_html('�����һ') ;//�����һ
											
					$is_buy2get2 = (int)check_buy_two_get_one($product_info['products_id'],'4');
					if(($product_info['products_class_id']=='4' && ($is_buy2get2=='3' || $is_buy2get2=='1')) || preg_match('/\bbuy2\-get\-2\b/i',$product_info['tour_type_icon']))
						$tags['buy2get2'] = db_to_html('����Ͷ�') ;//����Ͷ���	
										
					if(double_room_preferences($product_info['products_id']) || preg_match('/\b2\-pepole\-spe\b/i',$product_info['tour_type_icon'])) 
						$tags['2peplespe']=db_to_html('˫���ۿ�');//˫���ۿ���
						
					if(check_is_specials($product_info['products_id'],true,true) || preg_match('/\bspecil\-jia\b/i',$product_info['tour_type_icon']))
						$tags['specil'] = db_to_html('�ؼ�') ;//�ؼ���
						
					if($product_info['products_stock_status']=='0') 
						$tags['saleover'] = db_to_html('�Ѿ�����') ;//�Ѿ�����		
					
					//�ͼ۱�֤
					if(defined('LOW_PRICE_GUARANTEE_PRODUCTS') && tep_not_null(LOW_PRICE_GUARANTEE_PRODUCTS)){
			                    	$tmp_array = explode(',',LOW_PRICE_GUARANTEE_PRODUCTS);
			                    for($i=0; $i<sizeof($tmp_array); $i++){
										if(trim($tmp_array[$i])==(int)$product_info['products_id']){
											$tags['lowprice'] = db_to_html('�ͼ۱�֤') ;											
											break;
										}
									}
			                    }
					?>
					<ul class="tags">
					<?php $i=0 ;foreach($tags as $tag){	$class = $i%2 == 0 ? 'blue':'green';?>					
                        <li class="<?php echo $class?>"><?php echo $tag;?></li>
                    <?php $i++;}  ?> 
					</ul> */ ?>
                    <?php echo db_to_html('����ȣ�')?><img src="image/icons/icon_face.gif" /> <span id="comment_bai_fen_bi">99%</span>		
				</div>
                <div class="del_float"></div>
				</div>
				<div class="wenzi">  
				  <ul class="mid">
				  <li>
				<?php
				$TEXT_HIGHLIGHTS = TEXT_HIGHLIGHTS; 
				if($isHotels){
					$TEXT_HIGHLIGHTS = db_to_html("�Ƶ���ɫ��"); 
				}
				?>
				<label><?php echo $TEXT_HIGHLIGHTS;?></label><?php // �г���ɫ  ?>
				<div class="xcts">
				<?php
				/**
				 * ���products_small_description ���ַ���������������涨�ĳ��� ֻ��ʾǰ���ֺ󲿷�����
				 * �������δ�����򲻽��н�ȡ
				 * @var $displyNum ��ʾ��ǰ���ַ�������
				 */
				$products_small_description = $product_info['products_small_description'];
				$displyNum = 190 ;
				if(strlen($products_small_description) > $displyNum ) {
					$products_small_description = strip_tags($products_small_description);
					$products_small_description_first = cutword($products_small_description , 200,"");
						$products_small_description_last = str_replace($products_small_description_first, "", $products_small_description);
						echo stripslashes2(db_to_html($products_small_description_first));
						echo '<span id="morecon" style="display:none;">'.stripslashes2(db_to_html($products_small_description_last)).'</span><span id="MainPointMore">... <span class="more"><a href="javascript:;" >'.db_to_html('�鿴ȫ��') .'</a></span></span>';
				}else {
						echo stripslashes2(db_to_html($products_small_description));
				}
				
				?>
				</div>
				<script type="text/javascript"> 
				jQuery("#MainPointMore").toggle(function(){
					jQuery("#morecon").show();
					jQuery(this).html("<span class='more less'><a href='javascript:;' ><?php  echo db_to_html('����') ?></a></span>");
				},function(){
					jQuery("#morecon").hide();
					jQuery(this).html("... <span class='more'><a href='javascript:;' ><?php  echo db_to_html('�鿴ȫ��') ?></a></span>");
				}); 
				</script> 

				
				<?php
				//�鿴�����ͼ
				$maps_file = DIR_FS_CATALOG."products_swf_maps/".$product_info['products_id'].".swf";
				if(file_exists($maps_file)){
				?>
				<style>
				.ckmap{ padding-left:20px; padding-top:2px; padding-bottom:2px; background:url(image/icons/map.gif) no-repeat; background-position:2px 0px;}
				.ckmapLink{ color:#3180F6; text-decoration:none; font-size:12px;}
				.ckmapLink:hover{ text-decoration:underline;}
				</style>
				<span class="ckmap" id="view_attractions_swf_maps"><a target="_blank" href="<?php echo tep_href_link('product_info_maps.php','products_id='.$product_info['products_id'])?>" class="ckmapLink"><?php echo db_to_html("�鿴��ͼ");?></a></span>
				<?php
				}else{ echo "&nbsp;";}
				?>								
				</li>
				</ul>
				
		<!--��Ƭ,map������ͳ�� start-->
		  <div class="routeInfo">
            <ul>
              <li><a    href="javascript:void(0);" onClick="setProductTab('two',2,4); scroll(0,jQuery('#two2').offset().top);updateTitle('question');" ><?php echo sprintf(db_to_html('������ѯ(<span>%d</span>)'), $num_question);?></a></li>
                <li><a href="<?=tep_href_link('new_travel_companion_index.php');?>" ><?php echo sprintf(db_to_html('���ͬ��(<span>%d</span>)'), get_product_companion_post_num($product_info['products_id']));?></a></li>
              <li style="display:none;"><a href="javascript:void(0);" onClick="setProductTab('two',3,4); scroll(0,jQuery('#two3').offset().top); lazyload({defObj: '#reviews_photos_ul'});updateTitle('photo');" ><?php echo sprintf(db_to_html('��Ƭ����(<span>%d</span>)'), $num_photo);?></a></li>
			  <li class="comment"><a href="javascript:void(0);" onClick="setProductTab('two',1,4); scroll(0,jQuery('#two1').offset().top);updateTitle('review');" ><?php echo sprintf(db_to_html('�û�����(<span>%d</span>)'), $num_review);?></a> 
		</li>
		  <script type="text/javascript">
		  var myscroll = window.scroll;
			jQuery(document).ready(function(){
				if(jQuery("#comment_bai_fen_bi_h2").html()!=null){
					jQuery("#comment_bai_fen_bi").html(jQuery("#comment_bai_fen_bi_h2").html());
				}
			});
			</script>
			  <?php
				if($product_info['products_map'] != ''){
					$new_image_map = $product_info['products_map'];
					echo '<li><a href="'.DIR_WS_IMAGES . $new_image_map.'"  rel="lightbox" target="_blank">'.db_to_html("�г̵�ͼ").'</a></li>';
				}
				?>
              
            </ul>
          </div>
		  <!--��Ƭ,map������ͳ�� end-->

				</div>
		</div>		
				<div class="clear"></div>
                </div>
          </div>      
				<!--�Ż������� end-->
				<?php
				//����ģ��
				include('product_info_module_right_1.php');
				?>

			</div>
			<?php /*<div class="title titleDetailBot"><b></b><span></span></div>*/ ?>
		<div class="proDetailLeft">
			
			<?php
			//���ͷ����ײ�Ԥ��
			if($product_info['is_transfer']!= 1 && $product_info['recommend_transfer_id'] > 0){				 
			?>
			    <div class="shuttle" id="RecommendShuttleDiv">
		        <h3><?php echo db_to_html('�Ż��ײ��Ƽ�'); ?></h3>
		        <div class="shuttleLeft">
		            <dl>
		                <dt>
		                <?php 
		                $myurl = tep_href_link(FILENAME_PRODUCT_INFO,'products_id='.$products_id);
		                echo  '<a href="'.$myurl.'">'.substr(trim($shows_small_img_list) , 4, strpos($shows_small_img_list,'</li>')-4).'</a>'; 
		                ?>
		                </dt>
		                <dd>
		                <h4><a href="<?php echo $myurl;?>"><?php echo db_to_html(cutword($products_name,60,'')); ?></a></h4>
		                <h5><?php echo db_to_html(cutword($products_name1,60,'')); ?></h5>		                   
		                </dd>
		            </dl>
		            <div class="midLine">+</div>
		            <?php 
		                $tpid = intval($product_info['recommend_transfer_id']);
		                $query = tep_db_query("SELECT  p.products_image,pd.products_name FROM  " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd 
		                 WHERE p.products_id = '" .   $tpid . "' AND pd.products_id = p.products_id 
		                  AND pd.language_id = '" . (int) $languages_id . "'");
		                $tpinfo = tep_db_fetch_array($query);		                
		                $tpinfo['products_name1']=strstr($tpinfo['products_name'], '**');
						if($tpinfo['products_name1']!='' && $tpinfo['products_name1']!==false)$tpinfo['products_name']=str_replace($tpinfo['products_name1'],'',$tpinfo['products_name']);
						$tpurl = tep_href_link(FILENAME_PRODUCT_INFO,'products_id='.$tpid);
		                ?>
		            <dl>
		                <dt><a href="<?php echo $tpurl;?>"><?php echo tep_image(DIR_WS_IMAGES . $tpinfo['products_image'], $tpinfo['products_name'].$tpinfo['products_name1'], 60, 33) ;?></a></dt>
		                <dd>
		                    <h4><a href="<?php echo $tpurl;?>"><?php echo db_to_html(cutword($tpinfo['products_name'],60,'')); ?></a></h4>
		                     <h5><?php echo db_to_html(cutword($tpinfo['products_name1'],60,'')); ?></h5>
		                </dd>
		            </dl>
		        </div>
		        <div class="shuttleRight">
		            <p></p>
		            <p><a href="javascript:;" class="btn btnOrange" onclick="jQuery('#ShuttleOption').show();jQuery('#RecommendShuttleDiv').hide()"><button><?php echo db_to_html("����Ԥ��")?></button></a></p>
		        </div>
		    </div>
			<?php }?>
			<?php
			//��Ʒ�г���Ϣ���Ӳ˵�
			include('product_info_module2_2011.php');
			?>			
		</div>
		
		<div class="proDetailRight">
		<?php
		//right column ����Ŀ
		include('product_info_module_right_2011.php');
		?>
		</div>
</div>
  

		<?php
	    
		}
		?>   	
		  
		  
					

<script type="text/javascript">
    <!--
<?php /*���ټ��㲢��ʾ��ǰ����ļ۸�*/?>
function calculation_room_price(){
	auto_update_budget();
}
	
	
    function formCallback(result, form) {
        window.status = "valiation callback for form '" + form.id + "': result = " + result;
    }
    var check = true;
<?php
if ($departuredate_true == "in") {
?>
		var set2 = document.cart_quantity._1_H_address; 
		if(typeof(set2)=="undefined" || set2.value != ''){
            var check = false;    
        }    
<?php
}
?>
    var valid = new Validation('cart_quantity', {immediate : true,useTitles:true, onFormValidate : formCallback});
    Validation.add('validate-select-custom-pickup', '', function(v) {
        return ((v != "" && check == true) && (v != "<?php echo TEXT_SELECT_NOTHING; ?>" && check == true) && (v != "<?php echo TEXT_HEADING_NONE_AVAILABLE ?>" && check == true) && (v != 'Please make a selection...') && (v.length != 0) && (v != "0" && check == true));
    });

    /*������Ϣѡ�� start*/
    var textRooms="<?php echo TEXT_ROOMS; ?>";
    /* �Ƿ�������������������Ͷ� */
    var isMeiDongMaiErSongEr = <?php echo checkIsEastBuyTwoGetTwo($HTTP_POST_VARS['regions_id'],$HTTP_POST_VARS['tour_type_icon']) ? 'true' : 'false'?>;
    var textAdults= isMeiDongMaiErSongEr ? "<?php echo db_to_html('����')?>" : "<?php echo TEXT_ADULTS; ?>";
    var textChildren="<?php echo TEXT_CHILDREN; ?>";				 
    var textRoomX="<?php echo TEXT_ROOMS; ?> ?:";
    var textChildX="<?php echo TEXT_CHILDREN; ?> ?:";
    /* Ϊһ��������"���ͬ��"ѡ�� */
    var textTravelCompanion = "<?php echo db_to_html('���ͬ��') ?>";
    
    refresh();		   

    function refresh() {
        var cart_quantity = document.getElementById("cart_quantity");
        maxChildren = 0;

        for (var i = 0; i < numRooms; i++) {
            if (childrenPerRoom[i] > maxChildren) {
                maxChildren = childrenPerRoom[i];
            }
            if(numRooms==16){
                break;
            }
        }
		<?php
		if($product_info['display_room_option'] == 1){
			$h6_str = "��ѡ��Ƶ귿��";
		}else{
			$h6_str = "��ѡ�������Ա";
		}
		?>
        var x = '';//'<h6><b><?php echo db_to_html($h6_str);?></b><span onclick="jQuery(&quot;#hot-search-params&quot;).hide();"><img src="image/icons/icon_x.gif"></span></h6>';
        if(typeof(adultHelp)!="undefined"){
			if (adultHelp.length > 0) {
            	x += adultHelp + "<p>\n";
        	}
		}
        if (numRooms > 17) {
            x += textRooms;
            x += renderRoomSelect();

        } else {
            x += '<table cellspacing="0" cellpadding="0" width="400" class="roomPopTable" >\n';
			<?php
			if ($product_info['display_room_option'] == 1) {
				$colspan = 5;
				//if ($product_info['agency_id'] == "2") { $colspan = 4; }
			?>
            var _tmp_checked = '';
			if(jQuery('#_checkboxTravelCompanion').attr('checked') == true){ _tmp_checked = ' checked="checked" '; }
			
			
			x += '<thead><tr><td colspan="<?=$colspan?>"><span>'+textRooms+pad+'</span>'+renderRoomSelect()+' <label><input type="checkbox" '+ _tmp_checked +' id="_checkboxTravelCompanion" name="_checkboxTravelCompanion" onclick="fastSelectTravelCompanion(this);" /> <?php echo db_to_html('���ͬ��');?></label></td></tr></thead>';	//��ɫ����кͷ�������ѡ��˵�
			<?php
			}else{
			    //by panda  Ϊһ�������ӡ����ͬ��ѡ�{
			if(TRAVEL_COMPANION_OFF_ON=='true'){
			    //$colspan = 4; 
			
			?>     
			//x += '<thead><tr><td colspan="<?=$colspan?>"><span>'+textTravelCompanion+pad+'</span>'+renderRoomSelectForTravelCompanion()+'</td></tr></thead>';	//��ɫ����кͽ��ͬ��ѡ��˵�
			<?php 
			}
			//by panda  Ϊһ�������ӡ����ͬ��ѡ�}
			}
			?>
			x += '<tr>';
            //if (numRooms > 1 && numRooms < 16 ) {
                x += '<td>&nbsp;</td>';
            //}

            var title_bed_td = '';
            var min_num_guest = 1 ;
<?php
//��Ÿ�ţ�����ѡ������Щѡ�
//if ($product_info['agency_id'] == "2") {
/* ��Ÿ��Ӧ�̵�һ�����У�ɾ�����͵�ѡ����Ϊ������ס�Ƶ�Ͳ�Ӧ�ô��ڴ��͵�ѡ�� By Panda */
if ($product_info['agency_id'] == "2" && $product_info['products_durations'] != "1") {
?>
                var options_array = new Array();    
                options_array[0] = new Array(0,'<?php echo TEXT_BED_STANDARD; ?>');
                options_array[1] = new Array(1,'<?php echo TEXT_BED_KING; ?>');
                options_array[2] = new Array(2,'<?php echo TEXT_BED_QUEEN; ?>');
                title_bed_td = '<td><label>'+ '<?= db_to_html('����'); ?>' +'</label></td>';
    
<?php
}
//vincent {USLA54-102,USLA2-1650,USLA2-1651,USLA52-1665,USLA54-1350
if(in_array($product_info['products_id'],array(102,1650,1651,1665,1350))){
	$mng = intval($product_info['min_num_guest']);
	if($mng > 1 ){
		echo 'min_num_guest='.intval($product_info['min_num_guest']);
	}
}
//
?>

            //���������
			x += '<td><label>'+textAdults+pad+'</label></td><td><label ' + (isMeiDongMaiErSongEr ? 'style="display:none"' : '') + '>'+textChildren+pad+'</label></td>'+ title_bed_td +'<td><label id="room_price_title">&nbsp;</label></td></tr>\n';   
            for (var i = 0; i < numRooms; i++) {

                /*ȥ����ߵ��Ǹ��հ���
				x += '<tr><td>';
                    x += '&nbsp;';
                x += '</td>';
                */
				//if (numRooms > 1 && numRooms < 16 ) {
				    RoomLeftTitle = getValueChinese(textRoomX, i+1)+pad;				 
					if(numRooms<=0 ){ RoomLeftTitle = ""; }
					if(numRooms==16){ RoomLeftTitle = "<?= db_to_html("���ƴ��")?>"; }	
					<?php if($h6_str =="��ѡ�������Ա") { ?>RoomLeftTitle = "";<?php }?>
									
				x += '<td class="left" id="room-' + i + '-left-title"><nobr>&nbsp;'+ RoomLeftTitle + '</nobr></td>';
                //}
                x += '<td width="70">';               
                x += buildSelect('room-' + i + '-adult-total', 'setNumAdults(' + i + ', this.options[this.selectedIndex].value); calculation_room_price();', min_num_guest, 20, adultsPerRoom[i]);
                x += '</td><td width="70"><span ' + (isMeiDongMaiErSongEr ? 'style="display:none"' : '') + '>';
                <?php if($product_info['products_kids'] != '0.00' || $isCruises == true){ //fix vincent ,��������Ʒ��С���۸�����Ϊ0 ��ֹѡ��С�������������ų���(howard)?>
                x += buildSelect('room-' + i + '-child-total', 'setNumChildren(' + i + ', this.options[this.selectedIndex].value); calculation_room_price();', 0, 10, childrenPerRoom[i]);//setNumChildren(' + i + ', this.options[this.selectedIndex].value)
				<?php }else{?>
				  x += '<select name="'+'room-' + i + '-child-total'+'" disabled><option value="0">0</option></select>'
				<?php }?>
				x += '</span></td>';

                if(title_bed_td!=''){	//����ѡ���
                    var max_n = 1;
                    var sel_n = 0;
                    if( (Number(adultsPerRoom[i])+Number(childrenPerRoom[i])) == 2 ){ max_n = options_array.length; sel_n = 1;}
                    if(cart_quantity.elements['room-'+ i +'-bed']===undefined){
                    }else{
                        sel_n = cart_quantity.elements['room-'+ i +'-bed'].value;
                    }
                    x += '<td width="160">'+ buildStrSelect('room-' + i + '-bed', '', options_array, max_n , sel_n).replace(/class="sel2"/,'class="bedS"') +'</td>';
                }else{
                    x += '<td id="room-price-'+ i +'" width="160">&nbsp;</td>';
				}

                x += '</tr>\n';

                var travel_comp = document.getElementById("travel_comp");
                if(travel_comp!=null){
                    travel_comp.value = '0';
                }
                if(numRooms==16){
                    if(travel_comp!=null){
                        travel_comp.value = '1';
                    }
                    break;
                }
            }


<?php
//�����䷿ѡ�� start {
if ($product_info['products_single_pu'] > 0) {
    $checkbox_checked = '';
    $agree_single_occupancy_pair_up = $cart->contents[$_GET['products_id']]['roomattributes'][6];
    if ((int) $agree_single_occupancy_pair_up) {
        $checkbox_checked = ' checked ';
    }
    $dan_ren_pei_fang_str = "�������Ե����䷿";
    if (1 || (defined('SEXES_ROOM_PROD_IDS') && SEXES_ROOM_PROD_IDS != "")) {
        $both_ids = explode(',', str_replace(' ', '', SEXES_ROOM_PROD_IDS));
        if (1 || in_array($_GET['products_id'], $both_ids)) {
            $dan_ren_pei_fang_str = "���ܵ����䷿����ͬ�Ա�ͬ�ſ���ͬסһ������";
        }
    }
?>
			x += '<tr><td>&nbsp;</td><td colspan="<?= ($colspan-1);?>" id="div_agree_single_occupancy_pair_up"><label><input name="agree_single_occupancy_pair_up" type="checkbox" id="agree_single_occupancy_pair_up" value="1" <?= $checkbox_checked ?>> <?php echo db_to_html($dan_ren_pei_fang_str); ?></label></td></tr>';/*<span onmouseout="jQuery(&quot;#RoomTipCon&quot;).hide();" onmouseover="jQuery(&quot;#RoomTipCon&quot;).show();" class="roomTip">[?]<span id="RoomTipCon" style="display: none;"><?php echo TEXT_TOUR_SINGLE_PU_OCC_TIPS; ?></span></span>*/
<?php
}
//�����䷿ѡ�� end }
?>

            x += '</table>\n';
			/*x += '<div class="submit btnCenter"><a class="btn btnOrange" href="javascript:;" onClick="SetShowSteps3();"><button type="button"><?= db_to_html("ȷ ��");?></button></a><a class="btn btnGrey" href="javascript:void(0);"><button type="button"><?= db_to_html("ȡ ��");?></button></a></div>';	//ȷ����ť*/
			

            /*var didHeader = false;
            if (didHeader) {
                x += '</table>\n';
            }*/
        }

        if(document.getElementById("hot-search-params-room"))document.getElementById("hot-search-params-room").innerHTML = x;
        //�Զ�ȥ�������opctionѡ�
        sub_rooms_people_num();
        set_child_option();
    }

    /*������Ϣѡ�� end*/	

    //-->
</script>


<?php
if($departuredate_true != "in"){
?>
<script type="text/javascript">
function validate(){					
	/*if(document.cart_quantity.availabletourdate.value==""){
	alert("<?php echo TEXT_SELECT_VALID_DEPARTURE_DATE;?>")
	return false
	}*/
	return true
}

				

</script>
<?php } ?>
<script type="text/javascript">
function createRequestObject(){
	var request_;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer"){
		request_ = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		request_ = new XMLHttpRequest();
	}
	return request_;
}

			//var http = createRequestObject();
			var http1 = createRequestObject();
		
				function calculate_price(products_id,availabletourdate,numberOfRooms)
				{
					if(numberOfRooms > 0){
						var querystring = '';
						//alert(numberOfRooms);

						for(i=0;i<numberOfRooms;i++){
						//alert(adultsPerRoom[i]);
						//alert(childrenPerRoom[i]);
						querystring = querystring + '&room-'+i+'-adult-total='+adultsPerRoom[i]+'&room-'+i+'-child-total='+childrenPerRoom[i]+'';
						}
					
					}
					try{
							http1.open('get', 'budget_calculation_ajax.php?products_id='+products_id+'&availabletourdate='+availabletourdate+'&numberOfRooms='+numberOfRooms+querystring+'&action_calculate_price=true');
							http1.onreadystatechange = hendleInfo_change_attributes_list;
							http1.send(null);
					}catch(e){ 
						//alert(e);
					}
				}
				
				function hendleInfo_change_attributes_list()
					{
						
						if(http1.readyState == 4)
						{
						 var response1 = http1.responseText;
						 document.getElementById("price_ajax_response").innerHTML = response1;
						}
					}
</script>

<?php
//�Զ���Ӳ�Ʒ�����
$index_type = 'click';
auto_add_product_index($product_info['products_id'],$index_type );
//�Զ���Ӳ�Ʒ�����end
?>
<?php 
//д���۵ĵ����������°档�ɰ�ȡ��
	//require_once('write_review_ajax.php');
?>

<?php
// �����ķ���ϵ�ҵ����� start
echo db_to_html($TffContactMe->form_html());
echo db_to_html($TffContactMe->javascript());
// �����ķ���ϵ�ҵ����� end
?>
<?php
	//check for featured deal - start
	$featured_first_departure_date = substr($featured_first_availabletourdate,0,10);
	$check_featured_dept_restriction = tep_db_query("select departure_restriction_date, featured_deals_new_products_price from ".TABLE_FEATURED_DEALS." where products_id = '".(int)$product_info['products_id']."' and active_date <= '".date("Y-m-d")." 23:59:59' and expires_date >= '".date("Y-m-d")." 00:00:00'");
	if(check_is_featured_deal($product_info['products_id']) == 1 && tep_db_num_rows($check_featured_dept_restriction)>0){
		$expected_price_people_array = tep_get_featured_expected_people_and_price($product_info['products_id']);
		$featured_deal_price_for_this_tour = $expected_price_people_array[1];
		//$products_price = $currencies->display_price($featured_deal_price_array[0]['text'], tep_get_tax_rate($product_info['products_tax_class_id']));
		?>
		<script type="text/javascript">
		if(document.getElementById('featured_deal_discount_txt')==null){ alert('Not find id "featured_deal_discount_txt"');}
		document.getElementById('featured_deal_discount_txt').innerHTML = '<?php echo sprintf(TXT_FEATURED_DEAL_DISC_INFO,'<strong>' . $currencies->display_price($featured_deal_price_for_this_tour, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</strong>') ; ?><br/><a href="<?php echo tep_href_link(FILENAME_FEATURED_DEALS, 'products_id=' . $product_info['products_id']); ?>");"><?php echo TXT_FEATURED_MORE_INFO; ?></a>';
		</script>
<?php
	}							
	//check for featured deal - end
?>

<?php
/*zip_load ͼƬѹ���ϴ����� start*/
?>
    <script src="includes/javascript/zip_upload/jquery-jtemplates.js" type="text/javascript"></script>
    <script src="includes/javascript/zip_upload/swfobject.js" type="text/javascript"></script>
    <script type="text/javascript">
        var eAddPhoto;
        var eAppendPhoto;
        var jPhotoList;
        var jProcess;
        var allSize = 0;
        var doneCount = 0;
        var infos = [];
        var isInited = false;
        function showFlash() {
            jPhotoList = jQuery("#ulPhotoList");
            jSelect = jQuery("#divSelect");
            jProcess = jQuery("#divProcess");
            jDone = jQuery("#divDone");
            var vars = {
                serverUrl: "includes/javascript/zip_upload/upload_photos_share.php",
                jsUpdateInfo: "jsUpdateInfo",
                imgWidth: 800,
                imgHeight: 800,
                imgQuality: 80
            }
            var vars1 = vars;
            vars1.flashID = "divAddPhoto";
            vars1.labelColor = "#000000";
            vars1.labelText = "<?php echo db_to_html("�ϴ���Ƭ");?>";
            vars1.hasUnderLine = false;
            swfobject.embedSWF("includes/javascript/zip_upload/PhotoUploader.swf", "divAddPhoto", "80", "20", "10.0.0", "includes/javascript/zip_upload/expressInstall.swf", vars1, { wmode: "Transparent" });
            var vars2 = vars;
            vars2.flashID = "divAppendPhoto";
            vars2.labelColor = "#0096FF";
            vars2.labelText = "<?php echo db_to_html("���������Ƭ");?>";
            vars2.hasUnderLine = true;
            swfobject.embedSWF("includes/javascript/zip_upload/PhotoUploader.swf", "divAppendPhoto", "75", "20", "10.0.0", "includes/javascript/zip_upload/expressInstall.swf", vars2, { wmode: "Transparent" });
        }
        function upload() {
            if (infos.length == 0) {
                alert("<?php echo db_to_html("����ѡ����Ƭ");?>");
                return;
            }
		
            if (doneCount >= infos.length) {
                jProcess.hide();
                jDone.show();
                
				jQuery("div a", jDone).click(function() { //ȥ�༭���������
					clickDone();
				});
				jQuery("#dragUpload span").click(function() {	//�ϴ���ɺ����رհ�ťʱȥ�༭���������
					clickDone();
					setTimeout('submit_photo_data(document.getElementById("form_photo"))',700);
				});
				
                return;
            }
            //
            var index;
            for (var i = 0; i < infos.length; i++) {
                var info = infos[i];
                if (info.status == "selected") {
                    index = i;
                    break;
                }
            }
            //
            if (doneCount == 0) {
                jQuery("#divAppendPhoto").height(0);
                updateProgress();
                jSelect.hide();
                jProcess.show();
            }
            jQuery(".selected", jQuery("li:nth-child(" + (infos+1) + ")", jPhotoList)).unbind("click");
            swfobject.getObjectById(infos[index].flashID).Load(infos[index].name);
        }
		
        function clickDone(){	//�ϴ���ɺ���޸ı��������

			jQuery("#review_result_photo").html("");
			closePopup("popupUpload_Load");
			var boxs = jQuery("#uploaded_photos_box").val().split(';');
			var html_code = '<form id="form_photo" onsubmit="submit_photo_data(this); return false;">';
			
			<?php
			if(strtolower(CHARSET)=='gb2312'){
				$onblur = 'this.value = simplized(this.value);';
			}else{
				$onblur = 'this.value = traditionalized(this.value);';
			}
			?>
			
			for(var i=0; i<(boxs.length-1); i++){
				var tmp_boxs_array = boxs[i].split('|');
				html_code += '<li><div class="pic"><tr><td valign="middle" align="center"><a href="'+tmp_boxs_array[4]+'" target="_blank"><img title="<?= db_to_html('����鿴��ͼ')?>" alt="<?= db_to_html('����鿴��ͼ')?>" src="'+tmp_boxs_array[5]+'" /></a></div><p><label style="visibility:visible"><input type="hidden" name="image_name[]" value="'+tmp_boxs_array[1]+'"/><?php echo db_to_html("���⣺");?></label><input onblur="<?= $onblur;?>" type="text" name="image_title[]" class="text" value=""/></p><p><label style="visibility:visible"><?php echo db_to_html("������");?></label><textarea onblur="<?= $onblur;?>"  name="image_desc[]" class="textarea"></textarea></p></li>';
			}
			
			html_code += '<div class="btnCenter"><a href="javascript:;" class="btn btnOrange"><button type="submit"><?php echo db_to_html("ȷ��");?></button></a></div>';
			html_code += '</form>';
			jQuery("#review_result_photo").html(html_code);
			jQuery("#review_result_photo").removeClass("photoList");
			jQuery("#review_result_photo").addClass("photoUpload");
			
			
			//var jPhotoUpload = jQuery(".photoUpload");
			//jPhotoUpload.setTemplateElement("template1");
			//jPhotoUpload.processTemplate(infos);
			infos = [];
			// clear
        }
		function formatSize(size) {
            if (size > 1024 * 1024) {
                return Math.round(size * 100 / (1024 * 1024)) / 100 + "MB";
            } else {
                return Math.floor(size / 1024) + "KB";
            }
        }
        function updateProgress() {
            var allPersent = Math.floor(doneCount * 100 / infos.length) + "%";
            jQuery("div:nth-child(1) div:only-child", jProcess).width(allPersent);
            jQuery("span:nth-child(2)", jProcess).text(allPersent);
        }
        function updateSummary() {
            jQuery("#txtPhotoCount").text(infos.length);
            jQuery("#txtAllSize").text(formatSize(allSize));
        }
        function getIndexByName(name) {
            for (var i = 0; i < infos.length; i++) {
                if (infos[i].name == name) {
                    return i;
                }
            }
            return -1;
        }
        var uploading, percent;
        function jsUpdateInfo(flashID, name, status, size, message) {
            var index = (status == "selected" ? infos.length : getIndexByName(name));
            if (status == "selected") {
				if (infos.length == 0) {
                    allSize = 0;
                    doneCount = 0;
                    jPhotoList.children().remove();
                    showPopup('popupUpload_Load', 'popupConUpload');                    
                    jDone.hide();
                    jSelect.show();
                    jQuery("#divAppendPhoto").height(20);
                }
                if (getIndexByName(name) >= 0) {
                    alert(name + "<?php echo db_to_html("�Ѵ���!");?>");
                    return;
                }
				if(infos.length>=100){
                    //alert("<?php echo db_to_html("һ��ֻ���ϴ�100��!");?>");
                    return;
				}else{
					infos.push({
						name: name,
						flashID: flashID,
						title: name.substr(0, name.lastIndexOf(".")),
						status: status
					});
					jPhotoList.append('<li><div class="name">' + name + '</div><div class="size">' + formatSize(size) + '</div><div class="status ' + status + '"></div><div class="process" style="width:0%;"></div></li>');
				   jQuery(".selected",jQuery("li:nth-child(" + infos.length + ")",jPhotoList)).click(function() {
						swfobject.getObjectById(flashID).Remove(name);
					});
					allSize += size;
					updateSummary();
				}
            } else {
                var jPhoto = jQuery("li:nth-child(" + (index + 1) + ")", jPhotoList);
                var jSize = jQuery("div.size", jPhoto);
                var jStatus = jQuery(".status", jPhoto);
                var jProgress = jQuery(".process", jPhoto);
                infos[index].status = status;
                if (status == "void") {
                    jPhoto.remove();
                    allSize -= size;
                    var temp = [];
                    for (i = 0; i < infos.length; i++) {
                        if (infos[i].name != name) {
                            temp.push(infos[i]);
                        }
                    }
                    infos = temp;
                    updateSummary();
                } else {
                    jStatus.removeClass();
                    jStatus.addClass("status " + status);
					switch (status) {
                        case "loading":
                            jProgress.width(message);
                            break;
                        case "loaded":
                            jSize.text(formatSize(size));
                            break;
                        case "notLoad":
                            alert(message);
                            break;
                        case "uploaded":
							if(message=="0"){
								alert(message);
							}else{
								jProgress.width("100%");
								++doneCount;
								updateProgress();
								upload();
								var tmp_array = message.split('|');
								if(tmp_array[0]=="1"){
									tmp_array[1];	//���ص��ļ���
									tmp_array[3];	//���ص���ȫ·��
								}
								var tmp_var = jQuery("#uploaded_photos_box").val()+message+";";
								jQuery("#uploaded_photos_box").val(tmp_var);
								//alert(message);
							}
							
                            break;
                        case "notUpload":
                            jProgress.width("100%");
                            ++doneCount;
                            updateProgress();
                            alert(message);
                            upload();
                            break;
                    }
                }
            }
        }
		
		function submit_photo_data(from_obj){
			var inputObj = jQuery(from_obj).find(':input');
			for(var i=0; i<inputObj.length; i++){
			<?php
			if(strtolower(CHARSET)=='gb2312'){
				echo 'inputObj[i].value = simplized(inputObj[i].value); ';
			}else{
				echo 'inputObj[i].value = traditionalized(inputObj[i].value); ';
			}
			?>
			}
			var From = from_obj;
			var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('product_reviews_write.php','action=process_photos&products_id='.(int)$products_id)) ?>");
			var form_id = from_obj.id;
			ajax_post_submit(url,form_id);
			
		}

		//�ύ������ѯ		
		function submit_question_data(from_obj){
		
			var inputObj = jQuery('#'+from_obj).find(':input');			
			for(var i=0; i<inputObj.length; i++){
			<?php
			if(strtolower(CHARSET)=='gb2312'){
				echo 'inputObj[i].value = simplized(inputObj[i].value); ';
			}else{
				echo 'inputObj[i].value = traditionalized(inputObj[i].value); ';
			}
			?>
			}
			var From = from_obj;
			var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('tour_question_write.php','ajax=true&action=process&aryFormData=1&products_id='.(int)$products_id)) ?>");
			var form_id = from_obj;
			var success_msm="";
			var success_go_to="";
			var replace_id="";
			ajax_post_submit(url,form_id,success_msm,success_go_to, replace_id);
		}
	</script>
<div class="popup" id="popupUpload_Load">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
<tr><td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td><td class="con">
 
  <div class="popupCon" id="popupConUpload" style="width:490px;">
    <div class="popupConTop" id="dragUpload">
      <h3><b><?php echo db_to_html("�ϴ���Ƭ");?></b></h3><span onclick="infos=[];closePopup('popupUpload_Load');"><img src="<?= DIR_WS_ICONS;?>icon_x.gif" alt="<?php echo db_to_html("�ر�");?>" title="<?php echo db_to_html("�ر�");?>" /></span>
    </div>
	
    <div class="photoUploading">
        <ul id="ulPhotoList">
        </ul>
        <ul>
            <li class="count">
                <div class="name"><?php echo db_to_html("�ܼƣ�");?><b><b id="txtPhotoCount">0</b><?php echo db_to_html("����Ƭ");?></b><a  style="position:absolute;top:4px;"><span id="divAppendPhoto"><?php echo db_to_html("�����С�");?></span></a></div>
                <div class="size"><?php echo db_to_html("�ܼƣ�");?><b id="txtAllSize">0KB</b></div>
            </li>
        </ul>
        <div id="divSelect" class="btnCenter">
            <a href="javascript:;" class="btn btnOrange" onclick="upload()"><button type="submit"><?php echo db_to_html("�ϴ���Ƭ");?></button></a>
        </div>        
        <div id="divProcess" class="allstatus" style="display:none">
            <div class="processBar">
                <div class="barCon" style="width:0%;"></div> 
            </div>
            <span>0%</span>
            <div class="wait"><?php echo db_to_html("�����ϴ������Ժ�...");?></div>
        </div>
        <div id="divDone" class="allstatus" style="display:none">
            <div class="suc"><?php echo db_to_html("�ϴ��ɹ���");?><a href="javascript:void(0)"><?php echo db_to_html("���ھ�ȥ�޸ı��������");?></a></div>
        </div>

    </div>
  </div>

</td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
</table>
</div>
	
<script type="text/javascript">
new divDrag([GetIdObj('dragUpload'),GetIdObj('popupUpload_Load')]);
</script>
<?php 
//���ȫ�����⡢���ۡ���Ƭ -vincent
?>

<script type="text/javascript">

var active_divobj = '';
var active_type = 0;
//����޸�
    jQuery(".conTitle >h2> a").click(function() {
		active_type = 1;
        var idName = jQuery(this).attr("id");
        var tempName = idName.substr(idName.indexOf("_")+1);
		active_divobj = tempName;                
        //jQuery(".conTitle").removeClass("conTitleActive");
        //jQuery(".choosePop").hide();
        //jQuery(".conTitle .close").hide();    
		jQuery(".conTitle").removeClass("conTitleActive");
    	jQuery(".choosePop").hide();
        jQuery(".close").hide();
        jQuery("#ConTitle_"+tempName).addClass("conTitleActive");		
        jQuery("#"+tempName).show();		
        jQuery("#Close_"+tempName).show();  
    });

    //����ر�
    
    jQuery(".btnGrey button").click(function() {        
        active_type = 0;
    	jQuery(".conTitle").removeClass("conTitleActive");
    	jQuery(".choosePop").hide();
        jQuery(".close").hide();
    });
    jQuery(".btnGrey").click(function() {        
        active_type = 0;
    	jQuery(".conTitle").removeClass("conTitleActive");
    	jQuery(".choosePop").hide();
        jQuery(".close").hide();
    });
    jQuery(".close").click(function() {    	
		active_type = 0;
    	jQuery(".conTitle").removeClass("conTitleActive");
    	jQuery(".choosePop").hide();
        jQuery(".close").hide();
    
    });
    jQuery(".btnOrange button").click(function() {
    	jQuery(".roomClose").hide(); 
		jQuery(".conTitle").removeClass("conTitleActive");
        jQuery(".choosePop").hide();
        jQuery(".conTitle .close").hide();       
    
    });
    jQuery(document).click(function(e){        
		if(active_type == 1 && active_divobj!=""){
			if(!jQuery(e.target).closest("#"+active_divobj).is("div") && !jQuery(e.target).closest("#ConTitleA_"+active_divobj).is("a") && !jQuery(e.target).closest("#TextBox_"+active_divobj).is("div") && !jQuery(e.target).closest("#Close_"+active_divobj).is("div")){
				if(active_divobj == 'ShuttleRoute1_Detail' || active_divobj == 'ShuttleRoute2_Detail') return ;
				if(jQuery("#PopupNoticeCon").css('display')!='none') return  ;//when popAlert active ,dont hide popbox
				jQuery("#"+active_divobj).hide();				
				jQuery("#Close_"+active_divobj).hide();
				active_type = 0;
			}
		}
    });

    
    


//ѡ��ʱ�䲿��
  jQuery(".timePop p").hover(function() {
	  jQuery(this).addClass("pHover")
  },
  function() {
	  jQuery(this).removeClass("pHover")
  });
  
  jQuery(".timePop p input").click(function() {
	  jQuery(".timePop p").removeClass("pClick");
	  jQuery(this).parent().parent().addClass("pClick")
  });
  
//ѡ��ص㲿��
  jQuery(".placePop tr:gt(0)").hover(function() {
	  jQuery(this).addClass("trHover")
  },
  function() {
	  jQuery(this).removeClass("trHover")
  });
  
  jQuery(".placePop tr td input").click(function() {
	  jQuery(".placePop tr").removeClass("trClick");
	  jQuery(this).parent().parent().parent().addClass("trClick")
  });
  
  <?php if($is_has_priority_attribute == 1){ ?>
function show_priority_mail_date(val){
	var unique_prod_option_value_id = "<?php echo PRIORITY_MAIL_PRODUCTS_OPTIONS_VALUES_ID; ?>";
	if(val == unique_prod_option_value_id){
		document.getElementById('div_priority_mail_date_field').style.display = '';
	}else{
		document.getElementById('div_priority_mail_date_field').style.display = 'none';
		document.cart_quantity.priority_mail_ticket_needed_date.value = '';
		document.cart_quantity.priority_mail_delivery_address.value = '';
		document.cart_quantity.priority_mail_recipient_name.value = '';
	}
}
function callajaxonprioritydate(){
	sendFormData('cart_quantity', '<?php echo tep_href_link("budget_calculation_ajax.php", "action_calculate_price=true&products_id=" . $products_id); ?>', 'price_ajax_response', 'true');
}
if(document.cart_quantity.elements["id[<?php echo PRIORITY_MAIL_PRODUCTS_OPTIONS_ID; ?>]"].value == <?php echo PRIORITY_MAIL_PRODUCTS_OPTIONS_VALUES_ID; ?>){
	document.getElementById('div_priority_mail_date_field').style.display = '';
}
<?php } ?>

</script>
<?php
/*zip_load ͼƬѹ���ϴ����� end*/
?>


<?php //��Ʒ�ղؼв�{?>

<div class="popup popupCon " id="addToFavorites">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
    <tr>
      <td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td>
        <td class="con">
          <div class="popupCon addSuccess" id="addToFavoritesPanel" style="width:400px; ">
            <div class="successTip">
            	<div class="img"><img src="<?= DIR_WS_TEMPLATE_IMAGES;?>success.jpg"></div>
				<div class="words">
					<p><?php echo db_to_html('�г̡�');?><a href="" id="Favorites_Pname"></a><?php echo db_to_html('���Ѿ������ղؼС�');?></p>
					<div id="Favorites_Content"></div>
				</div>
            </div>
			<div class="btnCenter">
				<a href="javascript:void(0);" class="btn btnOrange"><button onclick="window.location.href='<?php echo tep_href_link('my_favorites.php','');?>'" type="button"><?php echo db_to_html('�����ղؼ�');?></button></a>
				<a href="javascript:void(0);" class="btn btnGrey" onclick="closePopup('addToFavorites');"><button type="button"><?php echo db_to_html('��������');?></button></a>
			</div>
          </div>
      </td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
  </table>
</div>

<?php //��Ʒ�ղؼв�}?>
<?php //�ָ�Ԥ��֪ͨ�ĵ�����{

	?>
<div class="popup" id="popupEmail">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
<tr><td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td><td class="con">

  <div class="popupCon" id="popupConEmail" style="width:400px;">
    <div class="popupConTop" id="dragEmail">
      <h3><b><?php echo db_to_html('�ָ�Ԥ��֪ͨ');?></b></h3><span onclick="closePopup('popupEmail')"><img src="<?= DIR_WS_ICONS;?>icon_x.gif"></a></span>
    </div>
    <div id="popupEmail_Content">
    </div>
  </div>
</td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
</table>
</div>
<?php  //�ָ�Ԥ��֪ͨ�ĵ�����}?>
<script type="text/javascript" src="/includes/javascript/tips.js"></script>

<?php //���򵼺���ť
if((int)$product_info['products_stock_status'] > 0 && count($product_info['operate'])>=1){ 
?>
	<div id="goBuyPanel" title="<?= db_to_html("ȥ����");?>" onclick="jQuery('html,body').animate({scrollTop:jQuery('#cart_quantity').position().top - 10});"></div>
<?php
}
?>

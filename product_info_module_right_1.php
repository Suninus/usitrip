<a name="edit_box"></a>
<?php
//��������ѡ�� start
if (is_array($array_avaliabledate_store)) {
// Remove sold dates
    //$array_avaliabledate_store = remove_soldout_dates((int) $HTTP_GET_VARS['products_id'], $array_avaliabledate_store);

    array_multisort($array_avaliabledate_store, SORT_ASC);
    $is_first_date = 1;
	$option_selected = "";
	if(sizeof($array_avaliabledate_store)==1){
		$option_selected = 'selected="selected" ';
	}
	$_loop = 0;
	$array_avaliabledate_store_size = sizeof($array_avaliabledate_store);
	foreach ($array_avaliabledate_store as $avaliabledate_key => $avaliabledate_val) {
		$_loop++;
		if($is_first_date == "1"){
			echo tep_draw_hidden_field('first_availabletourdate', $avaliabledate_key);
			$featured_first_availabletourdate = $avaliabledate_key;
			$is_first_date = 0;
		}
		if($_loop == $array_avaliabledate_store_size){
			echo tep_draw_hidden_field('end_availabletourdate', $avaliabledate_key);
		}
		
		if (eregi('(' . TEXT_HEADING_DEPARTURE_DATE_HOLIDAY_PRICE . ')', $avaliabledate_val)) {
            $dis_red_style_dep = " style='color:#F1740E;' ";
        } else {
            $dis_red_style_dep = "";
        }
        $date_split = substr($avaliabledate_val, 0, 10);
        $availabledate_val1 = tep_get_date_disp($date_split);
        $availabledate_val2 = en_to_china_weeks(substr($avaliabledate_val, 10));
		
		$remaining_seats_date = tep_get_remaining_seats($product_info['products_id']);
		$_YMD = date('Y-m-d', strtotime(substr($avaliabledate_key,0,10)));
		if(array_key_exists($_YMD, (array)$remaining_seats_date ) && $remaining_seats_date[$_YMD]==0){	//�жϵ����Ƿ��Ѿ����꣬������������ʾ��ɫ������ѡ��Howard added
			$avaliabledate .='<optgroup class="optgroup" label="' . tep_output_string(db_to_html($availabledate_val1 . html_to_db($availabledate_val2). ' ������') , array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '"></optgroup>';
		}else{
			$avaliabledate .= '<option ' . $dis_red_style_dep . ' value="' . $avaliabledate_key . '" '.$option_selected.' >' . db_to_html($availabledate_val1) . $availabledate_val2 . '</option>';
		}
    }
}

if ($product_info['products_durations'] > 0 && $product_info['products_durations_type'] == 0) {
    $prod_dura_day = $product_info['products_durations'] - 1;
} else {
    $prod_dura_day = 0;
}
if ($priority_use_calendar == true) {
    $time1_display = '';
    $availabletourdate_style = ' width:0px; height:0px; ';
    $change_button_style = '';
    $change_button1_style = ' display:none; ';
} else {
    $time1_display = ' display:none; ';
    $availabletourdate_style = ' width:180px; height:20px; ';
    $change_button_style = ' display:none; ';
    $change_button1_style = '';
}
//��������ѡ�� end

?>
<style type="text/css">
<?php  //�Ƶ�Ԥ����ʹ�õ��� CSS����?>
.checkDate{ border:1px solid #999; color:#223D6A; font-size:12px; height:16px; margin-top:3px; padding:2px 0 2px 5px; text-decoration: none; background:url(<?= DIR_WS_TEMPLATE_IMAGES;?>time-selction.gif) no-repeat scroll right center transparent; width:120px;}
.cal-TextBox{ width:100px; height:16px; padding:2px 3px; background:#ffffff url(<?= DIR_WS_TEMPLATE_IMAGES;?>icons/Calendar.gif) no-repeat 89px center;}
.checkDateCal{ float:left;}
.checkDateCal table{ float:inline;}
.checkDatePanel{width:235px;}
.checkDatePanel label{ float:left;width:60px;height:25px;}
.checkDatePanel div{ float:right;width:170px;height:25px;}
.cal-GreyInvalidDate{ text-decoration: none;}
.so-BtnLink  {visibility:hidden;}
input.validation-passed{ border:1px solid #ccc;}
.hotelCheckDate{float:left;line-height:20px;}
.hotelCheckDateItem{padding-top:3px; float:left;}
</style>

<script type="text/javascript">
//������ѡ�������˵�
function SetAvailableTourDate(){
	jQuery(".choosePop").hide();
	var DateSelectObj = '#availabletourdate';
	jQuery(DateSelectObj).attr("style"," width:180px; height: 20px; ");
	jQuery(DateSelectObj).show();
	jQuery('#time1').hide();
}
function SetPopBox(id){
	jQuery("#ConTitleA_"+id).trigger("click");
}

<?php
//����������˰��
if($isCruises){
?>
var CruisesTaxId = "<?= $cruisesData['tax_products_options_id'];?>";
jQuery(document).ready(function(){
	jQuery('#ConTitle_ProductsOptions'+CruisesTaxId).hide();
	jQuery('#TextBox_ProductsOptions'+CruisesTaxId).hide();
	
});
<?php
}
?>
</script>

<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_SHOPPING_CART, tep_get_all_get_params(array('action','maxnumber')) . 'action=add_product'),'post','id="cart_quantity"'); ?>
<?php
echo tep_draw_hidden_field('products_id', $product_info['products_id']);
?>

<?php 
if($product_info['is_hotel'] == 1 ){
	$text_soldout =db_to_html('����������');
	$text_buy = db_to_html('��������');
	$text_disbale_tips = db_to_html('�þƵ귿���Ѿ����꣬��ͣԤ�����������Ҫ�Ļ��������·����ı�������������Email��ַ,���"��·�ָ�ʱ֪ͨ��"��ť������·�ָ�Ԥ��ʱ���ǻ��ʼ�֪ͨ����');
}elseif($product_info['is_transfer'] == 1 ){
	$text_soldout =db_to_html('���ͷ���������');
	$text_buy = db_to_html('��������');
	$text_disbale_tips = db_to_html('�÷����Ѿ����꣬��ͣԤ�����������Ҫ�Ļ��������·����ı�������������Email��ַ,���"��·�ָ�ʱ֪ͨ��"��ť������·�ָ�Ԥ��ʱ���ǻ��ʼ�֪ͨ����');
}else {
	$text_soldout =db_to_html('�г�������');
	$text_buy = db_to_html('��������');
	$text_disbale_tips = db_to_html('���г��Ѿ����꣬��ͣԤ�����������Ҫ�Ļ��������·����ı�������������Email��ַ,���"��·�ָ�ʱ֪ͨ��"��ť������·�ָ�Ԥ��ʱ���ǻ��ʼ�֪ͨ����');
}
if($product_info['products_stock_status']=='0' || count($product_info['operate'])<1){?>
<div class="buyOptionSoldout">
    <div class="top"><div></div><?php echo $text_soldout?></div>
    <div class="optionCon" >
        <div class="disable"><?php echo $text_disbale_tips?>
        </div>
        <div class="addCart">
        
              <div style="margin-left:300px;">Email: <input name="product_soldout_email" id="product_soldout_email" class="required validate-email text" title="<?php echo db_to_html("��������Ч�ĵ������䣡")?>" />
			  <button id="sendSoldOutEmailButton" type="button" onclick="sendSoldOutEmail('<?php echo $product_info['products_id'];?>')"><?php echo db_to_html('��·�ָ�ʱ֪ͨ��');?></button>
			  
			  </div>
			  
           <ul class="otherOption otherOption2">       
            <li class="addFav"><a  id="add_favorites_a_link_<?php echo (int)$products_id?>" href="javascript:jQueryAddFavorites(<?php echo (int)$products_id?>);"><?php echo db_to_html('�����ղؼ�')?></a></li>
            <li class="post" id="NewCompanion"><a href="javascript:;" class="btnBuy btnBuyPosts" onclick="showPopup('CreateNewCompanion','CreateNewCompanionCon','off','','','fixedTop','NewCompanion');"><?php echo db_to_html('�������������')?></a><?php /*<a href="<?= tep_href_link('companions_process.php');?>" target="_blank"><img title="<?php echo db_to_html('��η��������')?>" alt="<?php echo db_to_html('��η��������')?>" src="image/buy_tip.gif"/></a>*/?></li>
        </ul>
        <div class="del_float"></div>
        </div>
     </div>
     <div class="bottom"><div></div></div>
</div>
<?php }	else{?>
<div id="product_book_module" class="order margin_b10">
        
		<div class="date">
              <div class="tit">
                <h3 class="font_bold font_size14 color_333"><?php echo db_to_html('��������/�۸�')?><em class="font_size12 noBold color_b3b3b3"><?php echo db_to_html('����������ϼ۸���Խ���Ԥ����')?></em></h3>
              </div>
			  <div id="divCalendar" class="cont"></div>
              
			  <!--<div class="tip color_gray"><a class="s_1" href="#">�ŷѰ���ʲô��</a><a class="s_2" href="#">�۸���»��Żݻʱ֪ͨ�ң�</a></div>-->
			  <div class="otherCurrency" id="price_ajax_response" style="display:none"></div>
            </div>
		<?php //�������۸��Ĵ��� ʵ����?>
		<div class="buyOption">
		<div class="top"><div></div><?php echo $text_buy?></div>

<!-- ����GMAP div -->
<div class="popup" id="popupMap">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
<tr><td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td><td class="con" style="float:none;margin:0;width:auto;">
  <div class="popupCon" id="popupConMap" style="width:825px;">
    <div class="popupConTop" id="dragMap">
      <h3 style=" padding-left:0px;"><b><?= db_to_html("�ϳ��ص�ѡ������");?></b></h3>
      <span onclick="closePopup('popupMap')"></span>
      <div onclick="minPopup(this)" class="popupMin">-</div>
    </div>
<iframe frameborder="0" src="" width="825" height="460" style="overflow:hidden; display:none;" id="gMapIframe"></iframe>
<div id="gMaptips" style="color:#999"><img src='ajaxtabs/loading.gif' align='absmiddle'><?= db_to_html("���ڼ��ص�ͼ�����Ժ�...");?></div>
</div>
</td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
</table>
</div>
<!-- ����GMAP div ���� vincent -->
<!-- ����customer waitlist div -->
<div class="popup" id="popupWaitlist">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
<tr><td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td><td class="con" style="float:none;margin:0;width:auto;">
  <div class="popupCon" id="popupConWaitlist" style="width:725px;">
    <div class="popupConTop" id="dragWaitlist">
      <h3 style=" padding-left:0px; margin:0;"><b><?php echo HEADING_TITLE_WAITLIST?></b></h3>
      <span onclick="closePopup('popupWaitlist')"></span>
      <div onclick="minPopupWaitlist(this)" class="popupMin">-</div>
    </div>
<iframe frameborder="0" src="" width="725" height="480" style="overflow:hidden; display:none;" id="gWaitlistIframe"></iframe>
<div id="gWaitlisttips" style="color:#999"><img src='ajaxtabs/loading.gif' align='absmiddle'><?= db_to_html("���ڼ���ҳ�棬���Ժ�...");?></div>
</div>
</td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
</table>
</div>
<!-- ����customer waitlist div ���� Howard -->

		<div class="optionCon">
		
		<div class="optionsWrap" id="OptionsWrap">
		<div id="option_guest_num_error_msg" style="display:none; color:#F00; font-size:12px;"></div>
		<div class="options">
		<?php 
		//���ͷ����в�ͬ��ѡ��
		 if($product_info['is_transfer'] != '1'){ 
		 ?>
          <ul>
            <?php
			//ѡ����԰ Howard added by 2012-10-13 start {
			if(is_array($manualRelatedProductsInfo)){
			?>
			<?php /*?><li class="manualRelated">
				<div class="num0"></div>
				<div class="con">
				<div class="conTitle">
					<h2><?= db_to_html($manualRelatedProductsInfo['title']);?></h2>
				</div>
				<ul id="con_nav">			  
					<?php
					foreach((array)$manualRelatedProductsInfo['content'] as $val){
						if($val['id']==$product_info['products_id']){
					?>
						<li class="cur"><a href="javascript:void(0)"><?= db_to_html($val['text']);?></a></li>
					<?php
						}else{
					?>
						<li><a href="<?= $val['href'];?>"><?= db_to_html($val['text']);?></a></li>
					<?php
						}
					}
					?>
					</ul>
				</div>
			</li><?php */?>
			<?php
			}
			//ѡ����԰ Howard added by 2012-10-13 end }
			?>
			<!--��һ�� �������� start-->
			<li id="booking_steps_1">
              <div class="num"></div>
              <div class="con">
              <div class="conTitle" id="ConTitle_1">
			<?php
			$is_start_date_required=is_tour_start_date_required((int)$HTTP_GET_VARS['products_id']);
			if(tep_check_product_is_hotel((int)$HTTP_GET_VARS['products_id'])!=1 && $product_info['is_transfer']!=1){
				$booking_h2 = "�������ڣ�";
				if($is_has_priority_attribute == 1){
					$booking_h2 = html_to_db(TEXT_SELECT_DATE_OF_USE);
				}
				if($isCruises){
					$booking_h2 = "�������ڣ�";
				}
				
			  	//$tmp_array = $array_avaliabledate_store;
				//$last_departure_date = array_pop($tmp_array);
				//$last_departure_date = preg_replace('/ \(.+$/','',$last_departure_date);				
				if((int)$product_info['GroupBuyType']==1 || (int)$product_info['GroupBuyType']==2){
					//$last_departure_date = date('Y-m-d',strtotime($last_departure_date)+86400);
					$booking_h2 = '�������ڣ�<a onmouseout="jQuery(\'#TimeTip\').hide();" onmouseover="jQuery(\'#TimeTip\').show();" style="color:#00388A;" href="javascript:void(0);">��ϸ˵��</a>';
					$group_time_tip = '';
					$note_info ='<p><b>˵����</b><br />&nbsp;&nbsp;&nbsp;&nbsp;�ڶ�����Ч���ڣ�������ѡ���������ĳ������ڳ��С�����ǰ����ϸ�Ķ�<a href="'.tep_href_link("group_buys.php","do=note").'">�Ź���֪</a>��</p>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;��ܰ��ʾ���Ź���ƷͬʱҲ�ṩ�Ƶ��������Ƶ���ס�ȷ���������������������ϵ����ȡ�ñ��ۡ�</p>                      
						<p>&nbsp;&nbsp;&nbsp;&nbsp;�ɹ������������ͨ���ʼ����½��<a target="_blank" href="'.tep_href_link("account.php").'">�ҵ����ķ�</a>���鿴�������飬���κ�������<a href="'.tep_href_link('contact_us.php').'">��ϵ</a>���ǡ�</p>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;���ķ����߳�Ϊ������</p>';
				}
				
				$date_count = sizeof($array_avaliabledate_store);
				if($date_count==1){
					$group_time_tip = 'groupTimeTipCon1';
					$note_info ='<p><b>˵����</b><br />&nbsp;&nbsp;&nbsp;&nbsp;���Ź�����ʱ����ȷ���������������ó���׼��������ǰ����ϸ�Ķ�<a href="'.tep_href_link("group_buys.php","do=note").'">�Ź���֪</a>��</p>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;��ܰ��ʾ���Ź���ƷͬʱҲ�ṩ�Ƶ��������Ƶ���ס�ȷ���������������������ϵ����ȡ�ñ��ۡ�</p>                      
						<p>&nbsp;&nbsp;&nbsp;&nbsp;�ɹ������������ͨ���ʼ����½��<a target="_blank" href="'.tep_href_link("account.php").'">�ҵ����ķ�</a>���鿴�������飬���κ�������<a href="'.tep_href_link('contact_us.php').'">��ϵ</a>���ǡ�</p>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;���ķ����߳�Ϊ������</p>';
				}				
				if($product_info['products_id']=="147"){ 
					$note_info = '<p><b>˵����</b><br />&nbsp;&nbsp;&nbsp;&nbsp;������Ԥ�����ķ����ṩ�Ź��Żݵ���Чʱ�������'.$timeText.'֮ǰÿ��������ÿ�����������κ�һ������ʱ����Ϊ���ĳ���ʱ�䣬�����ܴ��Żݣ�</p>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;��ܰ��ʾ���Ź���ƷͬʱҲ�ṩ�Ƶ��������Ƶ���ס�ȷ��񣬶���Ļ�����Ӧ������Ƶ��Ӧ�ȷ���������������������ϵ����ȡ�ñ��ۡ�</p>                      
						<p>&nbsp;&nbsp;&nbsp;&nbsp;�ɹ������������ͨ���ʼ����½��<a target="_blank" href="'.tep_href_link("account.php").'">�ҵ����ķ�</a>���鿴�������飬��������ͨ���ֻ����Ų�ѯ�������飬���κ�������<a href="'.tep_href_link('contact_us.php').'">��ϵ</a>���ǡ�</p>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;���ķ����߳�Ϊ������</p>';
				}
			?>
            <h2><?php echo  db_to_html($booking_h2)?><!-- <a href="javascript:;" id="ConTitleA_1"><?= db_to_html("��ѡ��")?></a> --></h2>
			  <?php if((int)$product_info['GroupBuyType']==1 || (int)$product_info['GroupBuyType']==2){?>
				<div id="TimeTip" class="groupTimeTip" onmouseover="jQuery('#TimeTip').show();" onmouseout="jQuery('#TimeTip').hide();">
					<div class="groupTimeTipCon <?=$group_time_tip?>"><?= db_to_html($note_info);?></div>
					<div class="groupTimeTipArrow"></div>
				</div>				
			  <?php }?>			  
              </div>
			  <?php if((int)$product_info['GroupBuyType']==2){	//��ʱ�Ź��Ųż������ǩ			  
			  /*$buy_tips = '������'.tep_get_date_disp($last_departure_date).'֮ǰ���κ�һ����Ч�������ڡ�';
			  if($product_info['products_id']=="147"){ //147 �ŵ���ʾ
				$buy_tips = '������Ԥ�������ķ����ṩ�Ź��Żݵ���Чʱ�������'.$timeText.'֮ǰÿ��������ÿ�����������κ�һ������ʱ����Ϊ���ĳ���ʱ�䣬�����ܴ��Żݡ�';
			  }
			  $buy_tips .= '<br>(����ǰ21����������ϵȷ����ĳ���ʱ�䣬��������Ѿ�ȷ������<a class="blue" onclick="jQuery(\'#GroupTime\').show(); to_first_availabletourdate(); jQuery(\'#no_sel_date_for_group_buy\').val(0);" href="javascript:;">ѡ��</a>)';
			  */
			  ?>
				<!--<div style="float:left; width:100%; line-height:18px;"><?php echo db_to_html($buy_tips);?><?php db_to_html('�����δȷ������ʱ�䣬��ֱ�ӹ����������ȷ������ʱ�䣬��<a class="blue" onclick="jQuery(\'#GroupTime\').show(); to_end_availabletourdate(); jQuery(\'#no_sel_date_for_group_buy\').val(0);" href="javascript:;">ѡ��</a>');?></div>-->																
				<div style="float:left; width:100%;" id="GroupTime">
			  <?php }?>
			  
			  <select style="<?php echo $availabletourdate_style ?>" id="availabletourdate" name="availabletourdate" title="<?php echo TEXT_SELECT_VALID_DEPARTURE_DATE?>" onchange="search_tour_end_date_ajax(&quot;<?php echo $prod_dura_day?>&quot;,this.value); document.body.focus();">
				<?php echo $avaliabledate;?>
				</select>
				<input autocomplete="off" type="text" style="<?= $time1_display ?>width: 195px; height: 16px; border: 1px solid #999999; font-size: 12px; text-decoration: none; color:#223D6A;  margin-top:3px; padding:2px 0px 2px 5px; background:url(<?= DIR_WS_TEMPLATE_IMAGES;?>time-selction.gif) no-repeat right center;" name="time1" id="time1" onclick="MyCalendar.SetDate(this)" value="<?= db_to_html('��ѡ�����ĳ�������')?>" onBlur="AvailabletourDate.style.display=&quot;&quot; ;AvailabletourDate.focus();AvailabletourDate.style.display=&quot;none&quot; ; search_tour_end_date_ajax(&quot;<?=$prod_dura_day?>&quot;,AvailabletourDate.value); " />			  <!--
              <a id="change_date_box_style_a" href="JavaScript:void(0)" onClick="change_date_box_style()" ><?=tep_template_image_button('goto_Drop_down_menu.gif', db_to_html('�л�����������ʾ����'), ' id="change_button" style="'.$change_button_style.'" ').tep_template_image_button('back_Calendar.gif', db_to_html('�л�����������ʾ����'), ' id="change_button1" style="'.$change_button1_style.'" ')?></a>
              -->		  
			<?php
			//ֻ��һ����������ʱҪ����ѡ��˵������Զ�ѡ���������ͬʱ����change��JS���� {
				if($date_count==1){					
			?>
				<label><?php //echo db_to_html('�������ڣ�');?></label>
				<span id="only_one_start_date" style="padding-right:20px;"></span>
				<script type="text/javascript">
				//jQuery(document).ready(function(){
					var sVal = jQuery("#availabletourdate").val();
					jQuery("#only_one_start_date").text(jQuery("#availabletourdate option:selected").text());
					search_tour_end_date_ajax("<?php echo $prod_dura_day?>",sVal); document.body.focus();
					jQuery("#availabletourdate").hide();
					jQuery("#change_date_box_style_a").hide();
				//});
				</script>
			<?php		}	//ֻ��һ����������ʱҪ����ѡ��˵������Զ�ѡ���������ͬʱ����change��JS���� } ?>
			  <span id="div_display_departure_end_date" style="display:none"><label><?= TEXT_HEADING_END_DATE?></label>  <span id="final_dep_date_div"><!--����������ʾ��--></span></span>
			<?php /*if((int)$product_info['GroupBuyType']==2){	//��ʱ�Ź��Ųż������ǩ?>
			  &nbsp;<a class="blue" onclick="jQuery('#GroupTime').hide(); to_end_availabletourdate(); jQuery('#no_sel_date_for_group_buy').val(1);" href="javascript:;" ><?= db_to_html('ȡ��');?></a>
			  
			  </div>
				<script type="text/javascript">
				// �Ź���Ĭ��Ϊ�ĳ�������Ϊ���һ��/
				jQuery(document).ready(function(){
					//to_end_availabletourdate();
				});
				
				function to_end_availabletourdate(){
					indexN = jQuery('#availabletourdate option:last').attr("index");
					jQuery('#availabletourdate').get(0).options[indexN].selected = true;
				}
				
				function to_first_availabletourdate(){
					if(jQuery('#availabletourdate').get(0).options[0].value!=""){
						jQuery('#availabletourdate').get(0).options[0].selected = true;
					}else{
						jQuery('#availabletourdate').get(0).options[1].selected = true;
					}
				}
				</script>
				<input id="no_sel_date_for_group_buy" name="no_sel_date_for_group_buy" type="hidden" value="1" />
			  <?php } */?>
				
			  <?php
			  $closeWaitList = true;	//�رա������ҵ��������ĳ��������𣿡�����
			  if(!(int)$product_info['GroupBuyType'] && $closeWaitList!=true){ //�Ź���ȡ�������ǩ
			  ?>
			  <div class="waitListLink"><a href="javascript:;" onclick="javascript:showGWaitlistHelper('<?php echo preg_replace($p,$r,tep_href_link_noseo(FILENAME_WAITLIST, 'products_id='.(int)$product_info['products_id'].'&tour_code='.$product_info['products_model'],'NONSSL'));?>')" ><?php echo TXT_ADDWAITLIST; ?></a></div>
			  <?php }?>
			  <?php
			//hotel-extension {
			//ʵ�ֵ���Ԥ���Ƶ�
			}elseif(tep_check_product_is_hotel((int)$HTTP_GET_VARS['products_id'])==1){			
						if(isset($_GET['hotel_attribute']) && $_GET['hotel_attribute']>0){
							$get_hotel_attr = $_GET['hotel_attribute'];
						}else{
							$get_hotel_attr = 3;
						}
						if($get_hotel_attr==2){
							$checkin_date_field_name = "late_hotel_checkin_date";
							$checkout_date_field_name = "late_hotel_checkout_date";							
							echo tep_draw_hidden_field('h_l_id['.HOTEL_EXT_ATTRIBUTE_OPTION_ID.']', 2); 
							echo tep_draw_hidden_field('staying_late_hotels', (int)$HTTP_GET_VARS['products_id']); 
						}else{
							$checkin_date_field_name = "early_hotel_checkin_date";
							$checkout_date_field_name = "early_hotel_checkout_date";
							echo tep_draw_hidden_field('h_e_id['.HOTEL_EXT_ATTRIBUTE_OPTION_ID.']', $get_hotel_attr); 
							echo tep_draw_hidden_field('early_arrival_hotels', (int)$HTTP_GET_VARS['products_id']);
						}
						echo tep_draw_hidden_field('availabletourdate', ''); 
						$getvalidcheckin_date = '';
						if(preg_match("/,".(int)$product_info['agency_id'].",/i", ",".TXT_PROVIDERS_DTE_BTL_IDS.",")) {
							$getvalidcheckin_date = GetWorkingDays(date('Y-m-d'),4);
						}
						//$getvalidcheckin_date = GetWorkingDays(date('Y-m-d'),4);
					 ?>					 
					 <div class="hotelCheckDateCon">
					 <div class="hotelCheckDateItem" >
					 <link href="includes/javascript/calendar_fangxiaomin.css" rel="stylesheet" type="text/css" />
					 <script type="text/javascript" src="includes/javascript/calendar_fangxiaomin.js" charset="utf-8"></script>
					 
						<h2 class="hotelCheckDate"><?php echo db_to_html("��ס���ڣ�"); ?></h2>
						<div class="checkDateCal" id="checkDateCalIn">
						<input id="early_hotel_checkin_date" name="early_hotel_checkin_date" class="cal-TextBox" size="15" onclick="checkinCalendar(this.id, &quot;checkDateCalIn&quot;);" />
						</div>	
						<script>
						/**
						 * �Ƶ���ס����ѡ����
						 * @outer ��ʾ����
						 * @param {string} inputId Ϊ���������id
						 * @param {string} inputParentId ���������ĸ�id����Ҫ��������������
						 * @param {string} mindate ��С��������:1980-01-01
						 * @param {string} maxdate �����������:2015-12-01
						 */
						var G_cal = '';
						function checkinCalendar(inputId, inputParentId){
							var mindate = jQuery('input[name="first_availabletourdate"]').val().substr(0,10);
							var maxdate = jQuery('input[name="end_availabletourdate"]').val().substr(0,10);
							if(G_cal == '') G_cal = new CalendarFxm();
							G_cal.appendTo(document.getElementById(inputParentId));
							var _mind = mindate, _maxd = maxdate;
							if(typeof(mindate)=='undefined'){
								var myDate = new Date();
								_mind = myDate.getFullYear() + '-'+ (myDate.getMonth()+1) +'-'+ myDate.getDate();
							}
							if(typeof(maxdate)=='undefined'){ _maxd = '2100-12-31';}
							G_cal.open(document.getElementById(inputId), {
								//acceptDate : ["2013-11-18", "2013-11-19", "2014-7-20", "2014-7-21", "2014-7-22", "2014-7-23", "2015-7-25", "2015-7-29"],
								minDate: _mind,
								maxDate: _maxd,
								selectedDate: jQuery("#"+inputId).val(),
								dataNum: 1
							}); 
							//G_cal.wrapper.style.left = 0;
							//G_cal.wrapper.style.top = 25 + "px";
							G_cal.notClickClose();
						};
						</script>
					 </div>
					 <div class="hotelCheckDateItem" >
						<h2 class="hotelCheckDate"><?php echo db_to_html("������ڣ�"); ?></h2>	
						<div class="checkDateCal" id="checkDateCalOut">
						<input id="early_hotel_checkout_date" name="early_hotel_checkout_date" class="cal-TextBox" size="15" onclick="checkoutCalendar(this.id, &quot;checkDateCalOut&quot;);" />
						</div>
						<script>
						/**
						 * �Ƶ��������ѡ����
						 * @outer ��ʾ����
						 * @param {string} inputId Ϊ���������id
						 * @param {string} inputParentId ���������ĸ�id����Ҫ��������������
						 * @param {string} mindate ��С��������:1980-01-01
						 * @param {string} maxdate �����������:2015-12-01
						 */
						var G_cal2 = '';
						function checkoutCalendar(inputId, inputParentId){
							var md = jQuery('input[id="early_hotel_checkin_date"]').val().substr(0,10);
							if(md.length < 8){
								alert("<?php echo db_to_html("����ѡ����ס����"); ?>");
								return false;
							}
							var mda = md.split('-');
							var TD = new Date(mda[0], (mda[1]-1), mda[2]);
							var time = TD.getTime() + (86400*1000);
							var TD1 = new Date();
							TD1.setTime(time);
							var mindate = (TD1.getFullYear() + '-'+ (TD1.getMonth() +1 ) +'-'+ TD1.getDate());
							var maxdate = jQuery('input[name="end_availabletourdate"]').val().substr(0,10);
							
							if(G_cal2 == '') G_cal2 = new CalendarFxm();
							G_cal2.appendTo(document.getElementById(inputParentId));
							var _mind = mindate, _maxd = maxdate;
							if(typeof(mindate)=='undefined'){
								var myDate = new Date();
								_mind = myDate.getFullYear() + '-'+ (myDate.getMonth()+1) +'-'+ myDate.getDate();
							}
							if(typeof(maxdate)=='undefined'){ _maxd = '2100-12-31';}
							G_cal2.open(document.getElementById(inputId), {
								//acceptDate : ["2013-11-18", "2013-11-19", "2014-7-20", "2014-7-21", "2014-7-22", "2014-7-23", "2015-7-25", "2015-7-29"],
								minDate: _mind,
								maxDate: _maxd,
								selectedDate: jQuery("#"+inputId).val(),
								dataNum: 1
							}); 
							//G_cal2.wrapper.style.left = 0;
							//G_cal2.wrapper.style.top = 25 + "px";
							G_cal2.notClickClose();
						};
						</script>
					 </div>
					 </div>
			<?php		}	//}hotel-extension?>
            </div>
            </li>
          <!--��һ�� �������� end-->
			<!--�ڶ��� ��Ʒѡ�� start-->
			<li id="booking_steps_2">
              <div class="num num2"></div>
              <div class="con">
				<?php
				//��ʾ ���ʸ��ӷ� �Ȳ�Ʒѡ��
				if(strlen($dis_buy_steps_2_products_options_name)>0){
					echo $dis_buy_steps_2_products_options_name;
				}
				//��ʾ ���ʸ��ӷ� �Ȳ�Ʒѡ��end
				?>
<?php              
//���͵�ַ�;Ƶ��ѡ�� start
$display_departure_region_combo = "";
$query_region = "select * from products_departure where departure_region<>'' and products_id = " . (int) $HTTP_GET_VARS['products_id'] . " group by departure_region";
$row_region = tep_db_query($query_region);

$totlaregioncount = tep_db_num_rows($row_region);
if ((int) $totlaregioncount > 1 || ($product_info['agency_id'] == 12 && $product_info['display_pickup_hotels'] == '1')) {

    $display_departure_region_combo = "true";
} else if ((int) $totlaregioncount == 1) {

    $display_departure_region_combo = "true";
    $display_departure_region_onecount = "true";
}

if ($display_departure_region_combo != "true") {
    $qry = "select * from " . TABLE_PRODUCTS_DEPARTURE . " where products_id = " . (int) $HTTP_GET_VARS['products_id'] . " ";
    $qryset = tep_db_query($qry);
    $pm = 0;
    $am = 0;
    $other = 0;
    while ($qry_rel = tep_db_fetch_array($qryset)) {
        $len = strlen($qry_rel['departure_time']);
        if ($len == 6) {
            $depart_final = '0' . $qry_rel['departure_time'];
        } else {
            $depart_final = $qry_rel['departure_time'];
        }

        if (strstr($depart_final, 'pm')) {
            $pma[$qry_rel['departure_id']] = $depart_final;
        }
        if (strstr($depart_final, 'am')) {
            $ama[$qry_rel['departure_id']] = $depart_final;
        }
    }
    if ($ama != '')
        array_multisort($ama, SORT_ASC);
    if ($pma != '')
        array_multisort($pma, SORT_ASC);


    //$depart_option = '';
	$depart_options = array();
    $finalid = 0;
    if ($ama != '') {
        foreach ($ama as $key => $val) {
            if (substr($val, 0, 1) == 0)
                $val = substr($val, 1, 7);
            $qryfinal = "select * from " . TABLE_PRODUCTS_DEPARTURE . " where products_id = " . (int) $HTTP_GET_VARS['products_id'] . " and departure_time Like '%" . $val . "' and departure_id not in(" . $finalid . ") Group By departure_id ";
            $departure_query = tep_db_query($qryfinal);
            $departure_result = tep_db_fetch_array($departure_query);
            if ((int) $departure_result['departure_id']) {
                $finalid .= "," . $departure_result['departure_id'];
            }
           // $depart_option .= '<option value="' . $departure_result['departure_time'] . '::::' . $departure_result['departure_address'] . '">' . substr($departure_result['departure_time'] . ' &nbsp; ' . $departure_result['departure_address'], 0, 100) . '</option>';
			$array_id = $departure_result['departure_time'] . '::::' . $departure_result['departure_address'];
			$array_text = $departure_result['departure_time'] . ' &nbsp; ' . $departure_result['departure_address'];
			if(tep_not_null($departure_result['departure_full_address'])){
				$array_id .= ', '.$departure_result['departure_full_address'];
				$array_text .= ', '.$departure_result['departure_full_address'];
			}
			if(tep_not_null($departure_result['departure_time'])){
				$depart_options[] = array('id'=>db_to_html($array_id), 'text'=>db_to_html($array_text) );
			}
        }
    }
    $finalidpm = 0;
    if ($pma != '') {
        foreach ($pma as $key => $val) {
            if (substr($val, 0, 1) == 0)
                $val = substr($val, 1, 7);
            $qryfinal = "select * from " . TABLE_PRODUCTS_DEPARTURE . " where products_id = " . (int) $HTTP_GET_VARS['products_id'] . " and departure_time Like '%" . $val . "' and departure_id not in(" . $finalidpm . ") Group By departure_id ";
            $departure_query = tep_db_query($qryfinal);
            $departure_result = tep_db_fetch_array($departure_query);
            if ((int) $departure_result['departure_id']) {
                $finalidpm .= "," . $departure_result['departure_id'];
            }
            //$depart_option .= '<option value="' . $departure_result['departure_time'] . '::::' . $departure_result['departure_address'] . '">' . $departure_result['departure_time'] . ' &nbsp; ' . substr($departure_result['departure_address'], 0, 2500) . '</option>';
			$array_id = $departure_result['departure_time'] . '::::' . $departure_result['departure_address'];
			$array_text = $departure_result['departure_time'] . ' &nbsp; ' . $departure_result['departure_address'];
			if(tep_not_null($departure_result['departure_full_address'])){
				$array_id .= ', '.$departure_result['departure_full_address'];
				$array_text .= ', '.$departure_result['departure_full_address'];
			}
			if(tep_not_null($departure_result['departure_time'])){
				$depart_options[] = array('id'=>db_to_html($array_id), 'text'=>db_to_html($array_text) );
			}

        }
    }
    //if ($depart_option != '') {
	if(tep_not_null($depart_options)){
		$TEXT_DEPARTURE = TEXT_DEPARTURE;
		if($content=="product_info_vegas_show"){
		//if ($product_info['products_type'] == 7) {
			$TEXT_DEPARTURE = db_to_html('�ݳ�ʱ��/�ص㣺');
		}
        /* panda ��Ӧ��ID 111�Ĳ�Ʒ����Ԥ����attribute���뿪����Ϊ������ʱ��͵ص㡱 start */
        if ($product_info['agency_id'] == '111'){
            $TEXT_DEPARTURE = db_to_html('����ʱ��/�ص㣺');
        }       
		/* panda ��Ӧ��ID 111�Ĳ�Ʒ����Ԥ����attribute���뿪����Ϊ������ʱ��͵ص㡱 end */
		//$depart_options_str = '<div><div class="conTitle" id="ConTitle_timePop"><h2>'.$TEXT_DEPARTURE.'<a  id="ConTitle_timePop" onclick="SetPopBox(&quot;departurelocations&quot;)" href="javascript:; ">'.db_to_html("ѡ��").'</a></h2>';		
		//$depart_options_str = '<div><div class="conTitle" id="ConTitle_timePop"><h2>'.$TEXT_DEPARTURE.'<a  id="departurelocationsBut" onclick="SetPopBox(&quot;departurelocations&quot;)" href="javascript:; ">'.db_to_html("ѡ��").'</a></h2>';		
		$depart_options_str = '<div><div class="conTitle" id="ConTitle_departurelocations"><h2>'.$TEXT_DEPARTURE.'<a  id="ConTitleA_departurelocations"   href="javascript:; ">'.db_to_html("ѡ��").'</a></h2>';		
		$depart_options_str.= '<div style="display: none;" class="close timeClose" id="Close_departurelocations"><a href="javascript:void(0);"></a></div>';
		/*show ���ݳ�ʱ�䵯���� start*/
		$depart_options_str .= '
			<div id="timePop" class="choosePop timePop"></div>
		';
		/*show ���ݳ�ʱ�䵯���� end*/
		$depart_options_str .= '<div class="choosePop placePop" id="departurelocations"> ';
		//<h6><b>'.$TEXT_DEPARTURE.'</b><span onclick="jQuery(&quot;#departurelocations&quot;).hide();"><img src="image/icons/icon_x.gif"></span></h6>
		//$depart_options_str .= '<select name="departurelocation" class="sel3">' . db_to_html($depart_option) . '</select>';
		$depart_options_str .='<table cellspacing="0" cellpadding="0"><tbody>';
		$radio_loop = 0;
		foreach($depart_options as $val){
			$radio_loop++;
			$selected_attribute = true;
			if($radio_loop>1){
				$selected_attribute = false;
			}
			
			$depart_options_str .= '<tr onmouseout="jQuery(this).removeClass(&quot;trHover&quot;)" onmouseover="jQuery(this).addClass(&quot;trHover&quot;)" onclick="jQuery(&quot;#departurelocation_' . $radio_loop.'&quot;).attr(&quot;checked&quot;,true); onclick_products_options(this)"><td><span class="timeS">'.tep_draw_radio_field('departurelocation', $val['id'], $selected_attribute, 'id="departurelocation_' . $radio_loop.'"').'<em id="departurelocation_em_' . $radio_loop.'" >'.$val['text'].'</em></span></td></tr>';
		}
		$depart_options_str .='</tbody></table>';
		
		$depart_options_str .= '<div class="submit btnCenter"><a class="btn btnOrange" href="javascript:;" onclick="SetShowDepartureLocationsBox();"><button type="button">'.db_to_html("ȷ ��").'</button></a><a class="btn btnGrey" href="javascript:;" onclick="jQuery(\'#departurelocationsClose\').hide();jQuery(\'#departurelocations\').hide();">
<button type="button">'.db_to_html("ȡ��").'</button>
</a></div></div></div><div class="place" id="TextBox_departurelocations" onclick="SetPopBox(&quot;departurelocations&quot;)" >&nbsp;&nbsp;</div></div>';
		
		echo $depart_options_str;
		
    }
} elseif ($display_departure_region_combo == "true") { //else of if($display_departure_region_combo == "true")
    $departuredate_true = "in";
    if ($product_info['agency_id'] == 12 && $product_info['display_pickup_hotels'] == '1') {
        include("pickuplocation_helicopter.php");
    } else {
        $first_time_after_location = false;
        if (FIRST_TIME_AFTER_LOCATION == 'true') {
            $first_time_after_location = true; //��ѡ����ʱ����ѡ���͵�ַ
        }
        if ($display_departure_region_onecount == "true") {
            if ($first_time_after_location == true) {
                include("first_time_after_location_pickuplocation_one.php");
            } else {
                include("pickuplocation_one.php");
            }
        } else {
            if ($first_time_after_location == true) {
                include("first_time_after_location_pickuplocation.php");
            } else {
                include("pickuplocation.php");
            }
        }
    }
}
//���͵�ַ�;Ƶ��ѡ�� end

//�ϳ���ַѡ�����Ż�����
require_once('optimization_location_address.php');
?>
            
            </li>
			<!--�ڶ��� ��Ʒѡ�� end-->
			<?php
			//ask cruise type - start
			/*
			if($parent_cat_array[sizeof($parent_cat_array)-1] == CRUISE_CATEGORY_ID){
			echo '<div class="eabo_co">
					<img src="'.DIR_WS_TEMPLATE_IMAGES.'ye'.$image_ye_cntr++.'.gif" class="fleft" alt="" />
					<div class="eabo_co_rt">
						<label class="txt12graybo fleft">'.ENTRY_CRUISE_TYPE.'&nbsp;&nbsp;</label>
						<div class="txt12gray" style="padding-left:5px;">
						<select name="cruise_type" style="width:80px;" onchange=" sendFormData(\'cart_quantity\', \''.tep_href_link('budget_calculation_ajax.php', 'action_calculate_price=true&products_id=' . $products_id).'\', \'price_ajax_response\', \'true\');">
							<option value="0">Interior</option>
							<option value="1">Outside</option>
							<option value="2">Balcony</option>
						</select>
						</div>
					</div>
				 </div>';
			}
			*/
			//ask cruise type - end
			?>			
			<!--������ ����������Ϣ����ˡ���ͯƱ����Ϣ start-->
			<li id="booking_steps_3" class="bot">
              <div class="num num3"></div>
              <div class="con">
                <div class="conTitle"  id="ConTitle_hot-search-params">
					<?php 
					$TEXT_TICKETS = TEXT_TICKETS ;
					if($product_info['display_room_option'] != 1){
						$TEXT_TICKETS = db_to_html('��ѡ�������Ա��');
					}
					if($isCruises){
						$TEXT_TICKETS = db_to_html('��ѡ�񷿼��������');
					}
					?>
				  <!--  <h2><?php echo $TEXT_TICKETS?><a id="SelBut3" href="javascript:;" onclick="SetPopBox('hot-search-params');"><?php echo db_to_html("��ѡ��");?></a></h2>-->
				   <h2><?php echo $TEXT_TICKETS?><a id="ConTitleA_hot-search-params"  href="javascript:;" ><?php echo db_to_html("��ѡ��");?></a></h2>
					<?php
					//ѡ�񷿼�ѡ�� start
					if ($product_info['display_room_option'] == 1 || $product_info['display_room_option'] == 0) {
					?>	
					<div id="Close_hot-search-params" class="close roomClose" style="display: none;"><a href="javascript:void(0);"></a></div>	
				     <div id="hot-search-params" class="choosePop roomPop"><div id="hot-search-params-room"><!--������Ϣ��ſ�--></div>
					 <?php if($isCruises){?>
					 <p style="padding:10px 10px 8px;border-bottom:1px dashed #DBDBDD;border-top:1px solid #D2EEFC;"><span style="color:#F8870F;font-weight:bold;"><?= db_to_html("��ܰ��ʾ��");?></span><?= db_to_html("ÿ��������ס��������ͬ��ÿ��ƽ��֧���Ľ��Ҳ��ͬ��");?></p>
					 <?php }?>
					 <div class="submit btnCenter"><a class="btn btnOrange" href="javascript:;" onClick="SetShowSteps3();"><button type="button"><?= db_to_html("ȷ ��");?></button></a><a class="btn btnGrey" href="javascript:void(0);"><button type="button"><?= db_to_html("ȡ ��");?></button></a></div></div>
					<?php
					}
					//ѡ�񷿼�ѡ�� end
					?>

                
				</div> 
				<div id="ShowSteps3" ><div class="place" id="TextBox_hot-search-params" onclick="jQuery('#ConTitleA_hot-search-params').trigger('click');">&nbsp;</div></div>
              </div>
          </li>
		<!--������ ����������Ϣ����ˡ���ͯƱ����Ϣ end-->
        </ul>
        </div>
		
		<div class="options extendOption">
			<!--���Ĳ� �Ƶ���סģ�� begin-->
			<?php
			if($product_info['is_hotel'] == "0"){ 
				if($product_info['hotels_for_early_arrival']!='' || $product_info['hotels_for_late_departure']!=''){
			 		include DIR_FS_CATALOG."product_info_hotel_extension.php";
				}
			}else if(tep_check_product_is_hotel((int)$HTTP_GET_VARS['products_id'])==1){
					 /* Early/Late check-in/out - start  hotel-extension {*/
						if(isset($_GET['hotel_attribute']) && $_GET['hotel_attribute']>0){
							$get_hotel_attr = $_GET['hotel_attribute'];
						}else{
							$get_hotel_attr = 3;
						}
						if($get_hotel_attr==2){
							$checkin_date_field_name = "late_hotel_checkin_date";
							$checkout_date_field_name = "late_hotel_checkout_date";							
							echo tep_draw_hidden_field('h_l_id['.HOTEL_EXT_ATTRIBUTE_OPTION_ID.']', 2); 
							echo tep_draw_hidden_field('staying_late_hotels', (int)$HTTP_GET_VARS['products_id']); 
						}else{
							$checkin_date_field_name = "early_hotel_checkin_date";
							$checkout_date_field_name = "early_hotel_checkout_date";
							echo tep_draw_hidden_field('h_e_id['.HOTEL_EXT_ATTRIBUTE_OPTION_ID.']', $get_hotel_attr); 
							echo tep_draw_hidden_field('early_arrival_hotels', (int)$HTTP_GET_VARS['products_id']);
						}
				 }
				 //}
			 ?>
			<!--���Ĳ� �Ƶ���סģ�� end-->
		</div>
		<?php
		//���ͷ������Ԥ��
		if($product_info['recommend_transfer_id'] > 0) {
			$transfer_products_id = intval($product_info['recommend_transfer_id']);
			echo '<ul id="ShuttleOption"  class="shuttleOption options"  style="display:none">';
			echo db_to_html('<li class="shuttleTitle bot"><b>���ͷ���Ԥ��</b> &nbsp;&nbsp;<a href="javascript:;" onclick="resetRoute(1);resetRoute(2);jQuery(\'#ShuttleOption\').fadeOut(\'fast\');jQuery(\'#RecommendShuttleDiv\').show();if(jQuery(\'\#Price\').css(\'display\') != \'none\') auto_update_budget();">ȡ��Ԥ��</a></li>');			
			include "product_info_module_buy_transfer_single.php";
			echo '</ul>';
		}
		}else{
				 // ���������Ӳ�����Ʒ����ѡ��
				 echo '<ul>';
				 include "product_info_module_buy_transfer_single.php";
				 echo '</ul>';
		?>
		</div>
		<?php }?>			
		
		</div>
<script type="text/javascript">
if(jQuery.browser.msie && (parseInt(jQuery.browser.version) <= 7)){
	var minHeight = parseInt(jQuery("#OptionsWrap").css('min-height'));
	if(jQuery("#OptionsWrap").height() < minHeight){
		jQuery("#OptionsWrap").height(minHeight);
	}
}

//jQuery(document).ready(function(){
	new lwkCalendar('divCalendar','availabletourdate',data);
//});
</script>
        <!-- �����û�Ԥ���г̷��� start -->
        <div class="addCart">
		<?php
		//��ʾ���ֵķ����ܼ���˰��
		if($isCruises){
		?>
		<div id="CruisesRoomPrice"></div>
		<div id="CruisesTaxDiv"></div>
		<?php
		}
		?>
		<?php
		/*echo '<div class="priceNull"  id="PriceNull">';
		
		$priceTips = 'ѡ�����ʱ��/�����ص�/�Ƶ귿��󣬽���ʾ�ܼ۸�';
		if($isHotels){
			$priceTips = 'ѡ����ס����/�������/�Ƶ귿��󣬽���ʾ�ܼ۸�';
		}
		echo db_to_html($priceTips);
		
		echo '</div>';*/
		?>
		<div class="price"  id="Price" style="display:none">
            <!--<p><label><?php echo db_to_html("(������������ȷ�ϵ����ռ۸�Ϊ׼)")?><br /></label></p>-->
            <p><label><br><?php echo db_to_html("�ܷ��ã�")?></label><span class="us" id="currecy_display_usd">0.00</span><?php echo db_to_html('(�Ѻ�˰�Ѻͷ����)')?></p>
            <p class="hotelExtensionCurrencyTips" id="hotel_extension_display_usd"></p>
            <p class="cn"><label><?php echo db_to_html("����ң�")?></label><span id="currecy_display_cny">0.00</span></p>
            <div id="discount_info" style="display:none">
				<p class="cn"><label><?php echo db_to_html("������Ϣ��")?></label><?php echo db_to_html("�Ѿ��Ż���")?><span class="style_discount_price" id="currecy_discount_usd">0.00</span></p>
				<p class="cn"><?php echo db_to_html("�����")?><span class="style_discount_price" id="currecy_discount_cny">0.00</span></p>
            </div>
        </div>
        <div class="add">
        <?php
		//���ͬ��ѡ��
		if(TRAVEL_COMPANION_OFF_ON=='true'){
			echo tep_draw_hidden_field('travel_comp', '0', ' id="travel_comp" ');
		}
		 
		//����Ѿ����Ϊ�Ѿ�����������ʾ���빺�ﳵ�Ͷ�����ť�� start
		if($product_info['products_stock_status']=='0' || count($product_info['operate'])<1){
		?>
			  <div style="margin-left:300px;">Email: <input name="product_soldout_email" id="product_soldout_email" class="required validate-email text" title="<?php echo db_to_html("��������Ч�ĵ������䣡")?>" />
			  <button id="sendSoldOutEmailButton" onclick="sendSoldOutEmail('<?php echo $product_info['products_id'];?>')"><?php echo db_to_html('��·�ָ�ʱ֪ͨ��');?></button>
			  
			  </div>
		 <?php
		 }else{
		 ?>
		 
		 	<a  href="javascript:;"  id="check_remaining_seats_cart"   onclick="AddToCart();" title="<?php echo db_to_html('����Ԥ��')?>"  alt="<?php echo db_to_html('����Ԥ��')?>" class="addCartBtn <?php if($language == 'tchinese')echo ' addCartBtnTchinese';?> "  ><?php echo db_to_html('����Ԥ��')?></a>
		 
			  <!-- <a href="javascript:;" id="check_remaining_seats_cart" class="btnBuy btnBuyCart" onclick="AddToCart();"><ins><button id="check_remaining_seats_cart_img" type="button"><?= db_to_html('���빺�ﳵ');?></button></ins></a>
			  <div id="check_remaining_seats_td">
			  <a href="javascript:;" id="check_remaining_seats_buy" class="btnBuy btnBuyBook" onclick="return SubmitCartQuantityFrom()" onmousemove="check_remaining_seats()"><ins><button type="button"><?= db_to_html('��������');?></button></ins></a>
			  </div>--> 
		  <?php
		  }
		  //����Ѿ����Ϊ�Ѿ�����������ʾ���빺�ﳵ�Ͷ�����ť�� end
		  ?>
            
        </div>		 
        <ul class="otherOption">       
            <li class="addFav"><a  id="add_favorites_a_link_<?php echo (int)$products_id?>" href="javascript:jQueryAddFavorites(<?php echo (int)$products_id?>);"><?php echo db_to_html('�����ղؼ�')?></a></li>
            <li class="post" id="NewCompanion"><a href="javascript:;" class="btnBuy btnBuyPosts" onclick="showPopup('CreateNewCompanion','CreateNewCompanionCon','off','','','fixedTop','NewCompanion');"><?php echo db_to_html('�������ͬ����')?></a><?php /*<a href="<?= tep_href_link('companions_process.php');?>" target="_blank"><img title="<?php echo db_to_html('��η������ͬ����')?>" alt="<?php echo db_to_html('��η������ͬ����')?>" src="/image/nav/help_icon_03.gif"/></a>*/ ?></li>
        </ul>
     </div>
     <!-- �����û�Ԥ���г̷��� end -->
		</div>

		<div class="bottom"><div></div></div>
<script type="text/javascript">
<?php
//�����2��û��������Ҫ�����2��html���ѵ�3���ı�ɵ�2���ı��
?>
if(jQuery("#booking_steps_2").find(".conTitle").size()==0){
	jQuery("#booking_steps_2").remove();
	jQuery("#booking_steps_3").find(".num3").removeClass("num3").addClass("num2");
}
</script>		
        
        
		</div>
		
        <!--<div class="otherCurrency" id="price_ajax_response" style="display:none"></div>-->
      
		<?php
		//��ʯ���֪ͨ
		if($show_yellow_table_notes == true ){
			//echo '<div class="seatTip">* '.YELLOWSTONE_TABLE_NOTES.'</div>';
		}
		?>
		<div id="div_display_notice_remaining_seats">
			<div id="notice_remaining_seats_div" class="sp1"></div></div>
		<div class="clear"></div>
		</div>

<?php //echo '</form>';?>
<?php }?>
		
</form>
<?php
//����������ʾ
include('product_recoverybook.php');
?>
<script type="text/javascript">
function sendSoldOutEmail(product_id){
	var ajaxurl = '<?php echo tep_href_link('product_recoverybook.php','');?>';
	var postdata='action=fastsubmitemail&ajaxPost=1&product_id='+product_id;
	postdata=postdata+'&product_soldout_email='+encodeURIComponent(jQuery('#product_soldout_email').val());
	jQuery('#sendSoldOutEmailButton,#product_soldout_email').attr('disabled','disabled');
	
	jQuery.ajax({
        global: false,
        url: ajaxurl,
        type: 'POST',
        data: postdata,
        cache: false,
        dataType: 'html',
        success: function(data){
            if(data=="1"){ alert("<?php echo db_to_html('�������������Ѿ��յ���лл���Ĺ�ע��')?>"); }else{
				alert(data);
				jQuery('#sendSoldOutEmailButton,#product_soldout_email').attr('disabled',false);
			}
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Ajax Error!Refresh Please!');
        }
    });
}
</script>

<script type="text/javascript">

//���ݲ�ͬ�����������availabletourdate����ʾ��ʽ
var AvailabletourDate = document.getElementById('availabletourdate');
var rslt = navigator.appVersion.indexOf('MSIE');
<?php
if($priority_use_calendar==true){
?>
if(AvailabletourDate !=null && rslt == -1){
	AvailabletourDate.style.display = 'none';
}
<?php
}
?>
//�ı�������������ķ��,��������������˵�����
function change_date_box_style(){
	var time1 = document.getElementById('time1');
	var change_button = document.getElementById('change_button');
	var change_button1 = document.getElementById('change_button1');
	if(AvailabletourDate!=null && time1!=null){
		if(time1.style.display == 'none'){
			if(rslt == -1){
				AvailabletourDate.style.display = 'none';
			}
			AvailabletourDate.style.width='0px';
			AvailabletourDate.style.height='0px';
			time1.style.display = '';
			change_button.style.display = '';
			change_button1.style.display = 'none';
		}else{
			AvailabletourDate.style.display = '';
			AvailabletourDate.style.width='180px';
			AvailabletourDate.style.height='20px';
			time1.style.display = 'none';
			change_button.style.display = 'none';
			change_button1.style.display = '';
		}
	}
}
</script>
<?php
/*show�ŵ��ݳ�ʱ���Ż���JS���� start*/
if($content=='product_info_vegas_show'){
?>
<script type="text/javascript">
//ѡ��a_obj�ڵĵ�ѡ��ť������a_obj��class����Ϊselected
function selected_radio(a_obj){
	var timepop = document.getElementById('timePop');
	var a_array = timepop.getElementsByTagName('a');
	for(i=0; i<a_array.length; i++){
		if(a_array[i].className=="selected"){
			a_array[i].className = "";
		}
	}
	a_obj.className = "selected";
	var s_radio = a_obj.getElementsByTagName('input');
	for(j=0; j<s_radio.length; j++){
		if(s_radio[j].type=="radio"){
			s_radio[j].checked = true;
		}
	}
}

//1����ݳ�ʱ��̫��������10�����Ż��ķ�ʽ����
var q_from = document.getElementById('cart_quantity');	//������
var d_selects = q_from.elements['departurelocation'];	//�ݳ�ʱ�䵥ѡ��ť��
var time_pop = document.getElementById('timePop');	//������ʱ���
var sel_date = document.getElementById('availabletourdate');		//��������
var OperateInfo = document.getElementById('operate_info');


function auto_hide_time_select(){
	if(typeof(d_selects.length)!='undefined' && d_selects.length>10){
		//���ر������ڵ����� 
		if(OperateInfo!=null){
			OperateInfo.innerHTML = '<div style="position:relative; z-index:100;"><a href="javascript:void(0)" onclick="show_time_pop(); "><?= db_to_html("�鿴�����ݳ�ʱ��");?></a> <div id="timePopShow" class="choosePop timePop" style="left:-85px; top:25px;"></div><iframe id="DivShim" src="javascript:;" scrolling="no"></iframe></div>';
		}
		//�޸�departurelocationsBut��ť��onclick�¼�
		jQuery("#departurelocationsBut").attr('onclick','');
		jQuery("#departurelocationsBut").bind('click',function() {
		  open_time_pop();
		});
		jQuery("#TextBox_departurelocations").attr('onclick','');
		jQuery("#TextBox_departurelocations").bind('click',function() {
		  open_time_pop();
		});
	}
}

jQuery(document).ready(function() {
	auto_hide_time_select();
});

//��ʾ���е��ݳ�ʱ��
function show_time_pop(){
	sel_date.value = sel_date.options[1].value;
	open_time_pop("only_show");
}

//2 ��d_selects�����˵�ȡ�����������time_pop
function open_time_pop(parameter){
	if(sel_date.value==""){ alert("<?= db_to_html("����ѡ�� �ƻ���������");?>"); return false;}
	var tergetobj = time_pop;
	var time_pop_show = document.getElementById('timePopShow');
	if(parameter=="only_show"){
		tergetobj = time_pop_show;
		time_pop.innerHTML = "";
		SetPopBox("timePopShow");
	}else{
		DivSetVisible();
		time_pop_show.innerHTML = "";
		SetPopBox("timePop");
	}

	tergetobj.innerHTML = '<div style="text-align:right"><img src="image/loading.gif" /></div>';
	tergetobj.style.display = "block";
	
	var TimeAndLocaltion = "";
	var QuFaDate = "";
	var AllQuFaDate = "";
	var ProductsOptions = "";
	for(i=0; i<d_selects.length; i++){
		TimeAndLocaltion += d_selects[i].value+"<::>";
	}
	//alert(TimeAndLocaltion);
	for(i=0; i<sel_date.options.length; i++){
		AllQuFaDate += sel_date.options[i].value+"<::>";
		if(sel_date.options[i].selected){
			QuFaDate = sel_date.options[i].value;
		}
	}
	//alert(QuFaDate);
	var p_options = q_from.getElementsByTagName('select');
	for(i=0; i<p_options.length; i++){
		if(p_options[i].name.indexOf('id[')>-1){
			
			for(j=0; j<p_options[i].options.length; j++){
				if(p_options[i].options[j].selected){
					ProductsOptions+= p_options[i].options[j].text+"<::>";
				}
			}
		}
	}
	var url = 'ajax_product_info_module_right_1_for_vegas_show.php?ajax=true';
	if(parameter=="only_show"){
		url += '&parameter='+parameter;
	}
	
	
	var datas = 'p_id=<?php echo $products_id?>&TimeAndLocaltion='+TimeAndLocaltion+"&QuFaDate="+QuFaDate+"&ProductsOptions="+ProductsOptions+"&AllQuFaDate="+AllQuFaDate;
	
	if(parameter=="only_show"){
		XMLHttp.sendReq('POST', url, datas, set_show_time_pop_html);
	}else{
		XMLHttp.sendReq('POST', url, datas, set_time_pop_html);
	}
}

function set_show_time_pop_html(obj){
	if(obj.responseText=="TimeAndAddressFormatError"){
		alert(obj.responseText);
		return false;
	}
	
	var time_pop_show = document.getElementById('timePopShow');
	time_pop_show.innerHTML = obj.responseText;
	time_pop_show.style.display = "block";
	DivSetVisible('open');
	show_or_hide_split_page_botton();
}
function set_time_pop_html(obj){
	if(obj.responseText=="TimeAndAddressFormatError"){
		q_from.elements['tmp_show_time'].style.display = "none";
		q_from.elements['tmp_show_time'].value = d_selects.value;
		time_pop.style.display = "none";
		d_selects.style.display = "block";
	}
	time_pop.innerHTML = obj.responseText;
	show_or_hide_split_page_botton();
}

//ȡ���ϸ��µ������б�
function GetPreviousDate(){
	FlipDate("back");
}
//ȡ���¸��µ������б�
function GetNextDate(){
	FlipDate("next");
}
//ȡ��ĳ���µ������б�
function GetMonthList(DateMonth){
	FlipDate(DateMonth);
}

//ȡ���ϸ��µ������б�����ʾ�ķ�ʽ��
function GetPreviousDateOnlyShow(){
	FlipDate("back");
	DivSetVisible("open");
}
//ȡ���¸��µ������б�����ʾ�ķ�ʽ��
function GetNextDateOnlyShow(){
	FlipDate("next");
	DivSetVisible("open");
}
//ȡ��ĳ���µ������б�����ʾ�ķ�ʽ��
function GetMonthListOnlyShow(DateMonth){
	FlipDate(DateMonth);
	DivSetVisible("open");
}


function FlipDate(Direction){
	var TableList = document.getElementById('date_address_list');
	var tr = TableList.getElementsByTagName('tr');
	var will_show_id_sub = "";
	var now_id = "";
	for(i=0; i<tr.length; i++){
		//ȡ���Ѿ���ʾ���Ǹ��·ݵ���һ����
		if(Direction=="back"){
			if(tr[i].id.search(/^\d{8,8}$/)>-1 && tr[i].style.display!="none"){
				var back_id = tr[i-1].id;
				if(back_id.id=="" || back_id.search(/^\d{8,8}$/)==-1){ alert('<?= db_to_html('�ѵ���һҳ')?>'); return false;}
				else{
					will_show_id_sub = back_id.substr(0,6);
				}
				break;
			}
		}
		//ȡ���Ѿ���ʾ���Ǹ��·ݵ����¸���
		if(Direction=="next"){
			if(tr[i].id.search(/^\d{8,8}$/)>-1 && tr[i].style.display!="none"){
				now_id = tr[i].id;
			}
		}
		//����Direction�ṩ���·���ʾ
		if(Direction.search(/^\d{6,6}$/)>-1){
			if(Direction==tr[i].id.substr(0,6)){
				will_show_id_sub=Direction;
				break;
			}
		}
	}
	
	if(Direction=="next" && now_id!=""){
		var nowRow = document.getElementById(now_id).rowIndex;
		var nextRowObj = TableList.rows[(nowRow+1)];
		if(nextRowObj!=null){ will_show_id_sub = nextRowObj.id.substr(0,6); }else{  alert('<?= db_to_html('�ѵ����һҳ')?>'); return false; }
	}
		
	//��ʾ����
	var MonthSelect = document.getElementById("CanUseMonth");
	if(will_show_id_sub!=""){
		//alert(will_show_id_sub+"  "+tr[n].id.substr(0,6));
		for(n=0; n<tr.length; n++){
			if(tr[n].id.substr(0,6)==will_show_id_sub){
				tr[n].style.display ="";
			}else if(tr[n].id.search(/^\d{8,8}$/)>-1){
				tr[n].style.display ="none";
			}
		}
		MonthSelect.value = will_show_id_sub;
	}
	//�����е�ѡ��ť�ָ���δѡ�е�״̬
	var input_obj = TableList.getElementsByTagName('input');
	for(i=0; i<input_obj.length; i++){
		if(input_obj[i].type=="radio" && input_obj[i].checked==true){
			input_obj[i].checked = false;
		}
	}
	//���º����°�ť�Ƿ����
	show_or_hide_split_page_botton();
}

//�������º����°�ť�Ƿ���ú���
function show_or_hide_split_page_botton(){
	var MonthSelect = document.getElementById("CanUseMonth");
	var PreButton = document.getElementById("chooseTimePopPreButton");
	var NextButton = document.getElementById("chooseTimePopNextButton");
	if(MonthSelect.value==MonthSelect.options[0].value){
		PreButton.style.display = "none";
	}else{
		PreButton.style.display = "";
	}
	if(MonthSelect.value==MonthSelect.options[(MonthSelect.options.length-1)].value){
		NextButton.style.display = "none";
	}else{
		NextButton.style.display = "";
	}

}

//ȷ���ݳ�ʱ���ֵ
function ConfirmDeparturelocation(){
	//d_selects.value = "";
	var TableList = document.getElementById('date_address_list');
	var TmpShowTime = document.getElementById('TextBox_departurelocations');
	var input_obj = TableList.getElementsByTagName('input');
	var NewAvailDate = "";
	var d_selects_value = null;
	for(i=0; i<input_obj.length; i++){
		if(input_obj[i].type=="radio" && input_obj[i].checked==true){
			d_selects_value = input_obj[i].value;
			TmpShowTime.innerHTML = input_obj[i].title;
			NewAvailDate = input_obj[i].title.substr(0,10);
			break;
		}
	}
	if(d_selects_value!=null){
		for(var i=0; i<d_selects.length; i++){
			if(d_selects[i].value==d_selects_value){
				d_selects[i].checked = true;
				break;
			}
		}
	}
	//�Զ���ѡ��������
	if(NewAvailDate!=""){
		for(i=0; i<sel_date.options.length; i++){
			if(sel_date.options[i].value.indexOf(NewAvailDate)>-1){
				sel_date.value = sel_date.options[i].value;
				break;
			}
		}
	}else{
		alert("<?= db_to_html('��ѡ��һ���ݳ�ʱ�䣡');?>");
		return false;
	}
	
	time_pop.style.display="none";
	TmpShowTime.focus();
	
}

//������ʾ���ط��� 
function DivSetVisible(state){ 
    var DivRef = document.getElementById('timePopShow'); 
    var IfrRef = document.getElementById('DivShim'); 
  if(state=='open'){
    DivRef.style.display = "block"; 
    IfrRef.style.display = "block"; 
    IfrRef.style.width = (DivRef.offsetWidth) + "px"; 
    IfrRef.style.height = (DivRef.offsetHeight) + "px"; 
    IfrRef.style.top = getStyle(DivRef,"top"); 
    IfrRef.style.left = getStyle(DivRef,"left"); 
    IfrRef.style.zIndex = getStyle(DivRef,"zIndex")-1; 
  }else{
	IfrRef.style.display = "none";
    DivRef.style.display= 'none'; 
  }
}
//ȡ��ʽ���������ֵ ���� 
function getStyle(elem, name){
if (elem.style[name])return elem.style[name];
else if (elem.currentStyle)return elem.currentStyle[name]; 
else if (window.getComputedStyle) return document.defaultView.getComputedStyle(elem,null).getPropertyValue(name);else return null; 
} 
</script>
<?php
}
/*show�ŵ��ݳ�ʱ���Ż���JS���� end*/
?>
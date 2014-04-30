<?php
ob_start();
$cruisesStartDateOptions = str_replace('��ѡ�����ĳ�������', '��ѡ���������', html_to_db($avaliabledate));
if(is_array($cruisesData)){
?>
  <!-- ���ּ۸���ϸ��ʼ -->
  <div class="cruisePrices">
	<div class="condition"><span>���¼۸�����ο�������������ͬ���۸����в�ͬ�����ռ۸�����������������ȷ�ϵ�Ϊ׼��</span></div>
	<?php foreach((array)$cruisesData['cabins'] as $key => $cabins){ //�Ͳ�ѭ��?>

	<table border="0" cellpadding="0" cellspacing="0" class="cabin">
	  <tr class="title">
		<td rowspan="9" class="cabinDes"><ul>
			<li>
			  <h4><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'mnu=cruisesIntroduction&'.tep_get_all_get_params(array('info','mnu','page'))).'#anchorCabin';?>"><?= tep_db_output($cabins['cruises_cabin_name']);?></a></h4>
			</li>
			<li><a target="_blank" href="<?= tep_db_output($cabins['images'][0]['images_url']);?>"><img src="<?= tep_db_output($cabins['images'][0]['images_url_thumb_min']);?>" alt="�Ͳ��ھ�" title="�Ͳ��ھ�" /></a></li>
			<li><?= tep_db_output($cabins['cruises_cabin_content']);?></li>
		  </ul></td>
		<td>����</td>
		<td>�װ�</td>
		<td>�۸�/��</td>
		<td>����<i>(����鿴)</i></td>
		<td>&nbsp;</td>
	  </tr>
	  
	<?php
	$ln=0;
	foreach((array)$cabins['decks'] as $key1 => $decks){
		$ln++;
		$tr_class="tableColor";
		if($ln>0 && $ln%2==0){
			$tr_class="";
		}
		$deck_type = preg_replace('@:.*$@','',$decks['cruises_cabin_deck_name']);
		$deck_name = preg_replace('@^.*:@','',$decks['cruises_cabin_deck_name']);
		$detailedPrice = $currencies->display_price($decks['options_values_price'], $tax_rate_val_get);	//��ϸ��׼��
		if($product_info['display_room_option']=="1"){
			$detailedPrice = '����:'.$currencies->display_price($decks['single_values_price'], $tax_rate_val_get).' ';	//��ϸ��׼��1��
			$detailedPrice .= '����:'.$currencies->display_price($decks['double_values_price'], $tax_rate_val_get).' ';	//��ϸ��׼��2��
			$detailedPrice .= '����:'.$currencies->display_price($decks['triple_values_price'], $tax_rate_val_get).' ';	//��ϸ��׼��3��
			$detailedPrice .= '����:'.$currencies->display_price($decks['quadruple_values_price'], $tax_rate_val_get).' ';	//��ϸ��׼��3��
			$detailedPrice .= 'С��:'.$currencies->display_price($decks['kids_values_price'], $tax_rate_val_get).' ';	//��ϸ��׼�۶�ͯ
		}
	?>
	  <tr class="<?= $tr_class;?>">
		<td><?= $deck_type?></td>
		<td><p><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'mnu=cruisesIntroduction&'.tep_get_all_get_params(array('info','mnu','page'))).'#anchorDeck';?>"><?= $deck_name?></a></p></td>
		<td><span><?= $currencies->display_price($decks['optionsValuesMinPrice'], $tax_rate_val_get)?> <?php if($product_info['display_room_option']=="1") echo "��";?></span></td>
		<td><span><a href="javascript:;" onclick="javascript:showPopupDecks('viewDeck_<?= $decks['products_options_values_id']?>');">�鿴</a></span>
		<div id="viewDeck_<?= $decks['products_options_values_id']?>" style="display:none">
		<?= tep_db_output($decks['cruises_cabin_deck_content']);?>
		<hr />
		��ס������<?= $decks['min_num_guest']?> - <?= $decks['max_per_of_guest']?>�ˡ�
		<hr />
		��ϸ�۸�<?= $detailedPrice;?>
		</div>
		</td>
		<td><strong><a href="javascript:void(0)" onclick="AddToCartForCruises(<?= $decks['products_options_id']?>, <?= $decks['products_options_values_id']?>, <?= $decks['min_num_guest']?>, <?= $decks['max_per_of_guest']?>);">ȥԤ��&gt;&gt;</a></strong></td>
	  </tr>
	  
	  <?php }?>
	<?php
	//�������6�У��򲹹�6��
	if($ln<6){
		for($i=$ln; $i<6; $i++){
		$tr_class="";
		if($i>0 && $i%2==0){
			$tr_class="tableColor";
		}
	?>  
	  <tr class="<?= $tr_class;?>">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	<?php
		}
	}
	?>
	</table>
	<?php } ?>
	<div class="explain">
	<strong>�����շѺ�˰��: <span><?= tep_db_output($cruisesData['tax']);?></span></strong>
	<?= tep_db_output($cruisesData['tax_content']);?>
	</div>
  </div>
  <!-- ���ּ۸���ϸ���� -->
  
	<div class="popup" id="PopupCabinDescriptions">
            <table cellpadding="0" cellspacing="0" border="0" class="popupTable">
              <tr>
                <td class="topLeft"></td>
                <td class="side"></td>
                <td class="topRight"></td>
              </tr>
              <tr>
                <td class="side"></td>
                <td class="con"><div class="popupCon" id="PopupCabinDescriptionsCon" >
                    <div class="popupTitle" id="drag">
                      <div class="popupTitleCon"><b>�װ���ϸ����</b></div>
                      <div class="popupClose" id="PopupCabinDescriptionsClose" onclick="closePopup('PopupCabinDescriptions')"></div>
                    </div>
                    <div class="description" style="width:500px;">�˴���żװ���ϸ�����ͼ۸���Ϣ</div>
                    <div class="btnCenter"> <a href="javascript:void(0);"  class="btn btnGrey" ><button type="button" onclick="closePopup('PopupCabinDescriptions')">�� ��</button></a> </div>

                  </div></td>
                <td class="side"></td>
              </tr>
              <tr>
                <td class="botLeft"></td>
                <td class="side"></td>
                <td class="botRight"></td>
              </tr>
            </table>
          </div>
<script type="text/javascript">
function showPopupDecks(sroceId){
    var PopupDecks = new showPopup('PopupCabinDescriptions','PopupCabinDescriptionsCon','PopupCabinDescriptionsClose',{dragId:"drag"});
	jQuery("#PopupCabinDescriptionsCon .description").html(jQuery("#"+sroceId).html());
}

<?php //���뵽���ﳵ������ר��?>
function AddToCartForCruises(optionId, optionValueId, roomMinPer, roomMaxPer){
	
	var error = false;
	var errorMsg = '';
	/*
	var dateBox = document.getElementById('availabletourdate');
	if(dateBox==null || dateBox.value.length<10){
		errorMsg +="��ѡ��������ڣ�"+"\n";
		error = true;
	}
	var perObj = document.getElementById('room-0-adult-total');
	if(perObj==null || perObj.value<1){
		errorMsg +="��ѡ��������"+"\n";
		error = true;
	}
	*/
	var radioOption = document.getElementById("radioid_"+optionId+"__"+optionValueId);
	if(radioOption==null){
		errorMsg +="�޷��ҵ��üװ壡"+"\n";
		error = true;
	}
	
	if(error == true){
		alert(errorMsg);
		return false;
	}
	
	//�Զ��򿪷���ѡ�������Լ����Ʒ�������
	jQuery('#ConTitleA_hot-search-params').trigger('click');
	
	//}
	/*id="radioid_187__1019" name="id[187]" value="1019"*/
	//�Զ�ȷ�ϿͲռװ������Ϣ{
	cleanAllCruisesOptionForBookingBox();
	jQuery('#radioid_'+optionId+'__'+optionValueId).attr("checked", true);
	selected_radio_deck(document.getElementById("deckTd_"+optionId+'__'+optionValueId), roomMinPer, roomMaxPer);
	ConfirmDeckInfo();
	//�������÷���
	setNumRooms(1);
	
	//�Զ�ִ�����õڶ�����˰��������Ʒѡ���Ĭ��ֵ
	var conTitleProductsOptions = jQuery("div [id^='ConTitle_ProductsOptions']");
	for(var i=0; i<conTitleProductsOptions.length; i++){
		var Steps2Num = conTitleProductsOptions[i].id.replace('ConTitle_ProductsOptions','');
		if(parseInt(Steps2Num,10) > 0){
			SetShowSteps2(parseInt(Steps2Num,10));
		}
	}
	jQuery("html,body").animate({scrollTop:jQuery('#product_book_module').position().top}); //��booking��
	//}
	
	//AddToCart();
}


</script>
 
 <?php
}
echo db_to_html(ob_get_clean());
//print_vars($cruisesData);
?>
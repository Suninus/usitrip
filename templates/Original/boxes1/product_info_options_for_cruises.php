<?php
/**
* �����ŵĿͲռװ�ѡ��ģ�飬���ļ��ĸ���product_info.php��ajax_edit_tour.php���Ӹ�����$cruises_products_options����
*/

if($includeSource == 'product_info'){
//��Ʒ��ϸҳҳ������

	ob_start();
	//print_vars($cruises_products_options);
?>
<div>
    <div class="conTitle" id="ConTitle_CruisesPlacePop">
        <h2>ѡ��Ͳ����ͺͷ��ࣺ<a id="ConTitleA_CruisesPlacePop" href="javascript:; " >��ѡ��</a> </h2>
        <div class="close timeClose" id="Close_CruisesPlacePop" style="display: none;"><a href="javascript:void(0);"></a></div>
        <div class="choosePop placePop" id="CruisesPlacePop">		
            <div class="placePopCon">
                <div id="CruisesDiv">
				<table cellspacing="0" cellpadding="0"><thead><tr><td>&nbsp;��ѡ��Ͳ�����</td></tr></thead><tbody>
				
				<?php
				$products_option_values = false;
				$imagesC = false;
				$cabinTitles = false; 
				
				foreach((array)$cruises_products_options as $n => $products_option){
					//����Ͳ�ͼƬstart
					$cabinTitles[$products_option['id']] = $products_option['text'];
					$imagesC[$products_option['id']] = getCruisesImages($products_option['id'],'cabin', (int)$cruises_id);
					//����Ͳ�ͼƬend
					foreach((array)$products_option['products_options_value_obj'] as $key => $val){
						if($val['value']>0 || 1){
							$products_option_values[$val['id']] = array('option_id'=>$products_option['id'], 'value_text'=>$val['text'], 'min_num_guest'=>$val['min_num_guest'], 'max_per_of_guest'=>$val['max_per_of_guest']);
						}
					}
				?>
				
				<tr id="cabinTR_<?= $products_option['id']?>" onmouseout="jQuery(this).removeClass(&quot;trHover&quot;);" onmouseover="jQuery(this).addClass(&quot;trHover&quot;);" class=""><td onclick="selected_radio_cabin(this)" class="selected"><span class="timeS">
					<input type="radio" value="<?= $products_option['id']?>" name="tmpRadioC" />
					<em><?= tep_db_output($products_option['text'])?></em></span></td></tr>
				<?php }?>
					
				</tbody></table>
				</div>

                <div id="DeckDiv">
				<table cellspacing="0" cellpadding="0" style="margin: 0px; border-top: 0px none;" id="DeckTable"><thead>
				<tr><td id="setCruisesDeckTitle">&nbsp;��ѡ�����</td></tr></thead>
				
				<tbody>				
				<tr class="placeList data_row_title"><td>
				<span class="data_col_0">&nbsp;</span>
				<span class="data_col_1">����</span>
				<span class="data_col_2">�װ�</span>
				<span class="data_col_3">������ס����</span>
				
				</td></tr>
				<?php
				//print_vars($products_option_values);
				foreach((array)$products_option_values as $idKey => $products_option_value){
				?>
				<tr id="deckTR_<?= $products_option_value['option_id']?>__<?=$idKey?>" parentid="cabinTR_<?= $products_option_value['option_id']?>" onmouseout="jQuery(this).removeClass(&quot;trHover&quot;);" onmouseover="jQuery(this).addClass(&quot;trHover&quot;);" class="placeList data_row_content" style="display:none"><td id="deckTd_<?= $products_option_value['option_id']?>__<?=$idKey?>" parentid="cabinTR_<?= $products_option_value['option_id']?>" onclick="selected_radio_deck(this,&quot;<?=$products_option_value['min_num_guest']?>&quot;,&quot;<?=$products_option_value['max_per_of_guest']?>&quot;);" ondblclick="ConfirmDeckInfo()">
				<span class="data_col_0">
				<input id="radioid_<?= $products_option_value['option_id']?>__<?=$idKey?>" name="id[<?= $products_option_value['option_id']?>]" type="radio" value="<?=$idKey?>">
				
				</span>
				<span class="data_col_1" id="id_<?= $products_option_value['option_id']?>__<?=$idKey?>"><?= str_replace(':','&nbsp;</span><span class="data_col_2">',html_to_db($products_option_value['value_text']))?></span>
				<span class="data_col_3"><?= $products_option_value['min_num_guest'].'-'.$products_option_value['max_per_of_guest']?>��</span>
				
				</td></tr>
				<?php }?>
				
				</tbody>
				</table>
				</div>
				
				<?php
				foreach((array)$imagesC as $option_id => $vale){
					if(!tep_not_null($vale[0]['images_title'])){
						$vale[0]['images_title'] = $cabinTitles[$option_id];
					}
				?>
					<div id="cruisesCabinInfo_<?=$option_id?>"style="display:none;" class="cruisesDesc">
					<h5><b><?= $vale[0]['images_title'];?></b><!--<a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'mnu=cruisesIntroduction&'.tep_get_all_get_params(array('info','mnu','page'))).'#anchorCabin';?>">�鿴�Ͳ�����&gt;&gt;</a>--></h5>
					<div class="cruisesDetail"><img src="<?php echo $vale[0]['images_url_thumb_min']?>" /><p><?= cutword($vale[0]['images_content'],160);?></p>
					  <div style="clear:both"></div>
					</div>
				  </div>
				<?php }?>
				
				<div class="submit btnCenter">
                    <a href="javascript:void(0);" class="btn btnOrange" onclick="ConfirmDeckInfo()"><button type="button">ȷ ��</button></a>
                    <a href="javascript:void(0);" class="btn btnGrey"><button type="button">ȡ ��</button></a>
                </div>
            </div>
        </div>
    </div>
    <div class="place" onclick="SetPopBox(&quot;CruisesPlacePop&quot;);" id="TextBox_CruisesProductsOptions">&nbsp;&nbsp;</div>
</div>

<script type="text/javascript">
var _DeckDiv = document.getElementById("DeckDiv");

/*ѡ��ȷ�ϼװ�*/
function ConfirmDeckInfo(){
	var Sel = false;
	<?php 
	$cOptionIDs = getAllCruisesOptionIds();
	foreach((array)$cOptionIDs as $oId){
	?>	
	jQuery('input[id^="radioid_<?= $oId?>"]').each(function(){
		if(jQuery(this).attr("checked")==true){
			//alert(jQuery(this).attr('id'));
			Sel = true;
		}
	});
	<?php
	}
	?>
	
	if(Sel!=true){
		alert("��ѡ��װ壡");
		return false;
	}
	
	var PlacePop = document.getElementById("CruisesPlacePop");
	PlacePop.style.display="none";
    var Close_placePop = document.getElementById("Close_CruisesPlacePop");
	jQuery("#ConTitleA_CruisesProductsOptions").html("�޸�");
	Close_placePop.style.display="none";	//��ȷ����ť���ܹرղ�		
	
	setNumRooms(1);	//�������÷���
	
	auto_update_budget(); //�Զ�����Ԥ���۸�
}

/*ѡ��Ͳյĵ�ѡ��ť�����ȡ�üװ��б�*/
var _CruisesDiv = document.getElementById("CruisesDiv");
function selected_radio_cabin(a_obj){
	cleanAllCruisesOptionForBookingBox();
	jQuery("#DeckTable tr[parentid^='cabinTR_']").hide();
	jQuery("div[id^='cruisesCabinInfo_']").hide();
	var a_array = _CruisesDiv.getElementsByTagName('a');
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
			jQuery("#DeckTable tr[parentid='cabinTR_"+ s_radio[j].value +"']").fadeIn(300);
			jQuery("#cruisesCabinInfo_" + s_radio[j].value).fadeIn(350);
			var DeckTitle = document.getElementById("setCruisesDeckTitle");
			if(DeckTitle!=null){
				DeckTitle.innerHTML = '&nbsp;ѡ��'+jQuery(a_obj).find('em').html()+'�ķ���';
			}
		}
	}
	jQuery(a_obj).parent().parent().children().removeClass("trClick");
	jQuery(a_obj).parent().addClass("trClick");
}
/*ͨ����ѡ�мװ嵥ѡ��ť*/
function selected_radio_deck(a_obj,roomMinPer,roomMaxPer){
	//alert(roomMinPer+' '+roomMaxPer);
	if(typeof(roomMinPer)!="undefined" && roomMinPer>0){
		min_num_guest = roomMinPer;
	}
	if(typeof(roomMaxPer)!="undefined" && roomMaxPer>0){
		maxPerRoomPeopleNum = roomMaxPer;
	}
	cleanAllCruisesOptionForBookingBox();
	
	var a_array = _DeckDiv.getElementsByTagName('a');
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
	var TextBoxtHtml = "<dl style='margin:0;border:0;'>";
	if(jQuery("#"+jQuery(a_obj).attr("parentid")).find("em").html()!=null){
		TextBoxtHtml += "<dd style='width:auto;margin-right:10px;_display:inline;'><label>�Ͳգ�</label>"+ jQuery("#"+jQuery(a_obj).attr("parentid")).find("em").html()+ "</dd>";
	}
	
	TextBoxtHtml += "<dd style='width:auto;margin-right:10px;_display:inline;'><label>���ࣺ</label>"+jQuery(a_obj).find('span.data_col_1').html()+ "</dd>";
	TextBoxtHtml += "<dd style='width:auto;'><label>�װ壺</label>"+jQuery(a_obj).find('span.data_col_2').html()+ "</dd>";
	TextBoxtHtml += "</dl>";
	jQuery("#TextBox_CruisesProductsOptions").html(TextBoxtHtml);	//����Ҫ��ʾ���Ǹ����
	jQuery("#AllAddressBoxtTip").show();
	jQuery(a_obj).parent().parent().children().removeClass("trClick");
	jQuery(a_obj).parent().addClass("trClick");
	jQuery("#ConTitleA_CruisesPlacePop").html('�޸�');
}

</script>

<?php
	$dis_buy_steps_2_products_options_name .= db_to_html(ob_get_clean());

}elseif($includeSource == 'ajax_edit_tour'){
//���ﳵҳ������start{
	
	ob_start();
?>

<tr>
  <td class="main"><b>ѡ��Ͳ�:</b></td>
  <td>
  <?php
  $cruisesCabinTmps = array();
  $cruisesCabinTmps[0] = array('id'=>0, 'text'=>"��ѡ��Ͳ�");
  $cruisesCabinTmpsSelected = 0;
  $cruisesCabinDeckSelected = 0;
  foreach((array)$cruises_products_options as $key => $val){
	  $cruisesCabinTmps[] = $cruises_products_options[$key];
	  if((int)$cruises_products_options[$key]['selected_attribute']){
	  	$cruisesCabinTmpsSelected = $cruises_products_options[$key]['id'];
		$cruisesCabinDeckSelected = $cruises_products_options[$key]['selected_attribute'];
	  }
  }
  echo tep_draw_pull_down_menu('cruisesCabinTmp', $cruisesCabinTmps,$cruisesCabinTmpsSelected,' class="sel3" onChange="select_deck(this.value)" ');
  ?>
<script type="text/javascript">

function select_deck(optionId){
	if(optionId==0 || optionId==""){
		alert("��ѡ��Ͳգ�");
	}
	
	document.getElementById("cruisesCabinDeckOptionTr").style.display = "none";
	var selectObj = document.getElementsByTagName('select');
	for(var i=0; i<selectObj.length; i++){
		<?php
		//�װ�ѡ�����
		$cOptionIDs = getAllCruisesOptionIds();
		foreach((array)$cOptionIDs as $oId){
		?>
		
		if(selectObj[i].name=="id[<?= $oId?>]"){
			selectObj[i].disabled = true;
			selectObj[i].style.display = "none";
		}
		
		<?php
		}
		?>
		
		if(selectObj[i].name=="id["+optionId+"]"){
			selectObj[i].disabled = false;
			selectObj[i].style.display = "";
			document.getElementById("cruisesCabinDeckOptionTr").style.display = "";
		}

	}
	//alert(document.getElementById("id["+optionId+"]").value);
	selected_deck(document.getElementById("id["+optionId+"]").value);
}  
</script>
  </td>
</tr>
<?php
$cruisesCabinDeckOptionTrDisplay = 'display:none;';
if($cruisesCabinDeckSelected>0){
	$cruisesCabinDeckOptionTrDisplay = '';
}
?>

<tr id="cruisesCabinDeckOptionTr" style="<?= $cruisesCabinDeckOptionTrDisplay;?>">
  <td class="main"><b>ѡ��װ�:</b></td>
  <td>
  <?php
	foreach((array)$cruises_products_options as $n => $products_option){ 
		
		$products_option_values = false;
		$selDisplay = 'display:none;';
		$_disabled = "disabled";
		foreach((array)$products_option['products_options_value_obj'] as $key => $val){		
			if($val['value']>0 || 1){
				$products_option_values[] = array('id'=>$val['id'], 'text'=>html_to_db($val['text']), 'min_num_guest'=>$val['min_num_guest'], 'max_per_of_guest'=>$val['max_per_of_guest']);
				if($cruisesCabinDeckSelected==$val['id']){
					$selDisplay = '';
					$_disabled = '';
				}
			}
		}
		
		if(is_array($products_option_values)){
			echo tep_draw_pull_down_menu('id['.$products_option['id'].']', $products_option_values, $cruisesCabinDeckSelected ,'id="id['.$products_option['id'].']" onchange="selected_deck(this.value);" class="sel3" '.$_disabled.' style="'.$selDisplay.'" ');
		}
	}
  ?>
  <?php //print_vars($cruises_products_options);?>
  
  </td>
</tr>

<script type="text/javascript">
/*ѡ�мװ�˵�*/
function selected_deck(vId){
  var roomMinPer = new Array();
  var roomMaxPer = new Array();
  <?php
	foreach((array)$cruises_products_options as $n => $products_option){ 
		foreach((array)$products_option['products_options_value_obj'] as $key => $val){		
			if($val['value']>0 || 1){
				echo 'roomMinPer['.$val['id'].'] = "'.$val['min_num_guest'].'"; ';
				echo 'roomMaxPer['.$val['id'].'] = "'.$val['max_per_of_guest'].'"; ';
			}
		}		
	}
  ?>
	//alert(roomMinPer[vId]+' '+roomMaxPer[vId]);
	
	if(typeof(roomMinPer[vId])!="undefined" && roomMinPer[vId]>0){
		min_num_guest = roomMinPer[vId];
	}
	if(typeof(roomMaxPer[vId])!="undefined" && roomMaxPer[vId]>0){
		maxPerRoomPeopleNum = roomMaxPer[vId];
	}
	setNumRooms(1);	//�������÷���
}

<?php
/*��������ҳ�������ʱ�Զ��������Ʒ�������start{*/
?>
function autoRestartRoom(){
	var form_obj = document.getElementById("cart_quantity");
	if(typeof(form_obj.elements["numberOfRooms"]) == 'undefined') return false;
	if(typeof(form_obj.elements["cruisesCabinTmp"]) == 'undefined') return false;
	var deckId = form_obj.elements["cruisesCabinTmp"].value;
	if(typeof(form_obj.elements["id["+ deckId +"]"]) == 'undefined') return false;
	var vId = form_obj.elements["id["+ deckId +"]"].value;
	var roomMinPer = new Array();
	var roomMaxPer = new Array();
	<?php
	foreach((array)$cruises_products_options as $n => $products_option){ 
		foreach((array)$products_option['products_options_value_obj'] as $key => $val){		
			if($val['value']>0 || 1){
				echo 'roomMinPer['.$val['id'].'] = "'.$val['min_num_guest'].'"; ';
				echo 'roomMaxPer['.$val['id'].'] = "'.$val['max_per_of_guest'].'"; ';
			}
		}		
	}
	?>
	
	if(typeof(roomMinPer[vId])!="undefined" && roomMinPer[vId]>0){
		min_num_guest = roomMinPer[vId];
	}
	if(typeof(roomMaxPer[vId])!="undefined" && roomMaxPer[vId]>0){
		maxPerRoomPeopleNum = roomMaxPer[vId];
	}
	
	setNumRooms(form_obj.elements["numberOfRooms"].value);
}

jQuery(document).ready(function(){
	autoRestartRoom();
});
<?php
/*��������ҳ�������ʱ�Զ��������Ʒ�������end}*/
?>
</script>
<?php
	echo db_to_html(ob_get_clean());
//���ﳵҳ������end}

}
?>
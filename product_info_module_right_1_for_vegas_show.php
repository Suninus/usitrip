<link rel="stylesheet" type="text/css" href="templates/Original/page_css/popup_choose_time.css">

					   <div class="nr_l_table">
						  <?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_SHOPPING_CART, tep_get_all_get_params(array('action','maxnumber')) . 'action=add_product'),'post','id="cart_quantity"'); ?>
						  <?php
						  echo tep_draw_hidden_field('products_id', $product_info['products_id']);
						  ?>

						 <div class="title_buy_center" id="title_buy_center" style="position: relative;">
						  <?php
                          /*show ���ݳ�ʱ�䵯���� start*/
						  $pop_div_time = '
 							<div class="timePop" id="timePop" style="display:none; top:25px; left:-206px;">
                            </div>
                          ';
						  /*show ���ݳ�ʱ�䵯���� end*/
						  ?>
                         <table cellpadding="0" cellspacing="0" >
								
								
								<tr>
								<td width="43%" valign="top">
								
								
								<table width="99%" border="0" cellpadding="0" >
								  <tr>
									<td width="1%" style="height:3px;"></td>
									<td width="15%" style="height:3px;"></td>
									<td width="84%" style="height:3px;"></td>
								  </tr>
								<?php 
				 	
				 	if(is_array($array_avaliabledate_store)){
					array_multisort($array_avaliabledate_store,SORT_ASC);					
					$option_selected = "";
					if(sizeof($array_avaliabledate_store)==1){
						$option_selected = 'selected="selected" ';
					}
					foreach($array_avaliabledate_store as $avaliabledate_key=>$avaliabledate_val){
					 	  if (eregi('('.TEXT_HEADING_DEPARTURE_DATE_HOLIDAY_PRICE.')', $avaliabledate_val)) {
						  $dis_red_style_dep = " style='color:#F1740E;' ";
						  }else{
						  $dis_red_style_dep = "";
						  }	
						  	//$avaliabledate .= '<option '.$dis_red_style_dep.' value="'.$avaliabledate_key.'">'.$avaliabledate_val.'</option>';	
							$date_split = substr($avaliabledate_val,0,10);
							$availabledate_val1 = tep_get_date_disp($date_split);
							$availabledate_val2 = en_to_china_weeks(substr($avaliabledate_val,10));
							$avaliabledate .= '<option '.$dis_red_style_dep.' value="'.$avaliabledate_key.'" '.$option_selected.' >'.db_to_html($availabledate_val1).$availabledate_val2.'</option>';	

						  													
						   }						
					}
					
					   if($product_info['products_durations'] > 0 && $product_info['products_durations_type'] == 0){
						  $prod_dura_day = $product_info['products_durations']-1;
						  }else{
						  $prod_dura_day = 0;
						  }
					if($priority_use_calendar==true){
						$time1_display = '';
						$availabletourdate_style = ' width:0px; height:0px; '; 
						$change_button_style = '';
						$change_button1_style = ' display:none; ';
					}else{
						$time1_display = ' display:none; ';
						$availabletourdate_style = ' width:180px; height:20px; '; 
						$change_button_style = ' display:none; ';
						$change_button1_style = '';
					}
					
						  
					echo '
						<tr><td width="1">&nbsp;</td><td class="buy_steps_1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td class="buy_options_title"><b>'.TEXT_DATE.'</b></td></tr><tr>
						  <td width="1">&nbsp;</td>
						  <td >&nbsp;</td>
						  <td >
						  <input autocomplete="off" type="text" style="'.$time1_display.'width: 130px; height: 16px; border: 1px solid #999999; font-size: 12px; text-decoration: none; color:#223D6A;  margin-top:3px; padding:2px 0px 2px 5px; background:url('.DIR_WS_TEMPLATE_IMAGES.'time-selction.gif) no-repeat right center #FFFFFF;" name="time1" id="time1" onclick="MyCalendar.SetDate(this)" value="'.db_to_html('��ѡ�����ĳ�������').'" onBlur="AvailabletourDate.style.display=\'\';AvailabletourDate.focus();AvailabletourDate.style.display=\'none\'; search_tour_end_date_ajax(\''.$prod_dura_day.'\',AvailabletourDate.value); ClearTmpShowTime();" />
						  
						  <select style="'.$availabletourdate_style.'" class="validate-selection-blank sel3" id="availabletourdate" name="availabletourdate" title="'.TEXT_SELECT_VALID_DEPARTURE_DATE.'" onchange="search_tour_end_date_ajax(\''.$prod_dura_day.'\',this.value); ClearTmpShowTime();">
							  '.$avaliabledate.' 
							</select>
							<!--
							<a href="JavaScript:void(0)" onClick="change_date_box_style()">'.tep_template_image_button('goto_Drop_down_menu.gif', db_to_html('�л�����������ʾ����'), ' id="change_button" style="'.$change_button_style.'" ').tep_template_image_button('back_Calendar.gif', db_to_html('�л�����������ʾ����'), ' id="change_button1" style="'.$change_button1_style.'" ').'</a>
							-->
							
							</td>
						</tr>
						  <tr><td style="height:1px;"></td></tr>';
					
					  echo '<tr id="div_display_departure_end_date" style="display:none">
							<td width="1">&nbsp;</td>
							<td nowrap="nowrap">&nbsp;</td>
							<td class="buy_options_title"><b>'.TEXT_HEADING_END_DATE.'</b><div id="final_dep_date_div" class="sp1"></div></td>
							</tr>';	  
					
					echo '</table></td><td width="47%" valign="top" id="BuySteps2">';
					
					//��ʾ ���ʸ��ӷ� �Ȳ�Ʒѡ��
					if(strlen($dis_buy_steps_2_products_options_name)>0){
						echo '<table cellpadding="0" border="0">
								 <tr>
									<td width="1%" style="height:3px;"></td>
									<td width="11%" style="height:3px;"></td>
									<td width="88%" style="height:3px;"></td>
								  </tr>';
						echo $dis_buy_steps_2_products_options_name;
						echo '</table>';
					}
					//��ʾ ���ʸ��ӷ� �Ȳ�Ʒѡ��end
					?>

								<!--����ѡ�� ���͵ص� �Ƶ�-->
								<table width="99%" border="0" cellpadding="0">
								 <tr>
									<td width="1%" style="height:0px;"></td>
									<td width="11%" style="height:0px;"></td>
									<td width="88%" style="height:0px;"></td>
								  </tr>
									<?php
									
									$display_departure_region_combo = "";
									$query_region = "select * from products_departure where departure_region<>'' and products_id = ".(int)$HTTP_GET_VARS['products_id']." group by departure_region";
									$row_region = tep_db_query($query_region);
									
									$totlaregioncount = tep_db_num_rows($row_region);
									if((int)$totlaregioncount > 1 || ($product_info['agency_id'] == 12 && $product_info['display_pickup_hotels'] == '1')  ){
									
									$display_departure_region_combo = "true";
									
									}else if((int)$totlaregioncount == 1){
									
									$display_departure_region_combo = "true";
									$display_departure_region_onecount = "true";
									}
									
									if($display_departure_region_combo != "true")
									{	
											$qry ="select * from ".TABLE_PRODUCTS_DEPARTURE." where products_id = ".(int)$HTTP_GET_VARS['products_id']." ";
											$qryset = tep_db_query($qry);
											$pm = 0 ;
											$am = 0;
											$other = 0;
											while($qry_rel = tep_db_fetch_array($qryset))
											{
												$len=strlen($qry_rel['departure_time']);
												if($len == 6){
													$depart_final = '0'.$qry_rel['departure_time'];
												}else{
													$depart_final = $qry_rel['departure_time'];
												}
												
												
												if(strstr($depart_final,'pm'))
												{
													$pma[$qry_rel['departure_id']] = $depart_final ;
												}
												if(strstr($depart_final,'am'))
												{
													$ama[$qry_rel['departure_id']] = $depart_final ;
												}
											
											}
											if($ama != '')
											array_multisort($ama,SORT_ASC);
											if($pma != '')
											array_multisort($pma,SORT_ASC);
											
											
											$depart_option = '';
											$finalid = 0;
											if($ama != '')
											{
												foreach($ama as $key => $val)
												{
													if(substr($val,0,1) == 0)
													$val = substr($val,1,7);
													$qryfinal ="select * from ".TABLE_PRODUCTS_DEPARTURE." where products_id = ".(int)$HTTP_GET_VARS['products_id']." and departure_time Like '%".$val."' and departure_id not in(".$finalid.") ";
													$departure_query = tep_db_query($qryfinal);
													$departure_result = tep_db_fetch_array($departure_query);
													if((int)$departure_result['departure_id']){
														$finalid .= ",".$departure_result['departure_id'];
													}
													$depart_option .= '<option value="'.$departure_result['departure_time'].'::::'.$departure_result['departure_address'].'">'.mb_substr($departure_result['departure_time'].' &nbsp; '.$departure_result['departure_address'],0,100).'</option>';
												}
											}	
											$finalidpm = 0;
											if($pma != '')
											{
												foreach($pma as $key => $val)
												{
													if(substr($val,0,1) == 0)
													$val = substr($val,1,7);
													$qryfinal ="select * from ".TABLE_PRODUCTS_DEPARTURE." where products_id = ".(int)$HTTP_GET_VARS['products_id']." and departure_time Like '%".$val."' and departure_id not in(".$finalidpm.") ";
													$departure_query = tep_db_query($qryfinal);
													$departure_result = tep_db_fetch_array($departure_query);
													if((int)$departure_result['departure_id']){
														$finalidpm .= ",".$departure_result['departure_id'];
													}
													$depart_option .= '<option value="'.$departure_result['departure_time'].'::::'.$departure_result['departure_address'].'">'.$departure_result['departure_time'].' &nbsp; '.mb_substr($departure_result['departure_address'],0,100).'</option>';
												}
											}
											if($depart_option != ''){
											  
											  									
												if($dis_buy_steps_2!=true){
													$html_str = '<td class="buy_steps_2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
													$dis_buy_steps_2=true;
												}else{
													$html_str = '<td>&nbsp;</td>';
												}
											  
											  echo'
											  <tr>
											     <td width="1">&nbsp;</td>
												  '.$html_str.'
												  <td class="buy_options_title" ><b>'.PERFORMANCE_TIME.'</b></td>
												</tr>
											  <tr>
											     <td width="1">&nbsp;</td>
												  <td class="buy_options_title" >&nbsp;</td>
												  <td  class="main">
												  <select name="departurelocation" class="sel3" >'.db_to_html($depart_option).'</select>
												  <div style=" position:relative; z-index:50;" id="tmp_show_time_top">
												  '.tep_draw_input_field('tmp_show_time',db_to_html('ѡ���ݳ�ʱ��'),'id="tmp_show_time" title="'.db_to_html('ѡ���ݳ�ʱ��').'" style="display:none; width:209px; cursor:pointer; height: 16px; border: 1px solid #999999; font-size: 12px; text-decoration: none; color:#223D6A;  margin-top:3px; padding:2px 0px 2px 5px; background:url('.DIR_WS_TEMPLATE_IMAGES.'time-selction.gif) no-repeat right center #FFFFFF;" onclick="open_time_pop()" readonly="true" ')
												  .$pop_div_time.'												  
												  </div>
												  
												  
												  
												  
												  
												  
												  </td>
												</tr>';
											}	
									
									}
									elseif($display_departure_region_combo == "true" ) //else of if($display_departure_region_combo == "true")
									{
									$departuredate_true = "in";
									/*
									if($product_info['products_type'] == 2 && (int)$HTTP_GET_VARS['products_id'] != 422 && (int)$HTTP_GET_VARS['products_id'] != 546 && (int)$HTTP_GET_VARS['products_id'] != 574){
										include("pickuplocation_helicopter.php"); 
									}else if($product_info['products_type'] == 3 && $product_info['agency_id'] == 12){									
										include("pickuplocation_helicopter.php");
									}else{
										if($display_departure_region_onecount == "true"){
											include("pickuplocation_one.php"); 
										}else{
											include("pickuplocation.php");
										}
									}	
									*/
										if($product_info['agency_id'] == 12 && $product_info['display_pickup_hotels'] == '1'){									
											include("pickuplocation_helicopter.php");
										}else{
											
											$first_time_after_location = false;
											if(FIRST_TIME_AFTER_LOCATION=='true'){
												$first_time_after_location = true;	//��ѡ����ʱ����ѡ���͵�ַ
											}
											if($display_departure_region_onecount == "true"){
												if($first_time_after_location == true){
													include("first_time_after_location_pickuplocation_one.php");
												}else{
													include("pickuplocation_one.php");
												}
												
											}else{
												if($first_time_after_location == true){
													include("first_time_after_location_pickuplocation.php");
												}else{
													include("pickuplocation.php");
												}
												
											}
										}	
									
										
										
										
									}  //end of if($display_departure_region_combo == "true")	
										
													  
									 ?> 	
																	
								  </table>	
								<!--����ѡ�� ���͵ص� �Ƶ� end-->
								 
									  <!--�Ź���ʾ��Ԥ�㡢������ť start -->
									  <table style="margin-left:40px; margin-top:20px;">
									  <tr>
									  <td>
									  <img src="image/yusuan_icon2.gif" align="absmiddle" />
									  <?php
										//popDiv code Ԥ���
										include('product_info_module3.php');
										?>
										<a class="sp3" href="javascript:sendFormData('cart_quantity','<?php echo tep_href_link('budget_calculation_ajax.php', 'action_calculate_price=true&products_id=' . $products_id);?>','price_ajax_response','true'); showPopup(&quot;<?=$popupTip;?>&quot;,&quot;<?=$popupConCompare;?>&quot;);"><?php echo TEXT_BUDGET?></a>  
										</td>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td align="right">
									 <?php
									//�Ź� group buy start
									if(GROUP_BUY_ON==true){	//�Ź�
									 	$discount_percentage = auto_get_group_buy_discount($product_info['products_id']);
									 	if($discount_percentage>0){
									 		echo '<a class="tipslayer sp3" style=" position:relative" target="_blank" href="'.tep_href_link('landing-page.php','landingpagename=group_buy').'">'.db_to_html('����Ԥ����<span>'.GROUP_MIN_GUEST_NUM.'�˼����ϲμ��г�Ϊ��������ϵ��ż�����������Ԥ��'.($discount_percentage*100).'%���Żݡ�').'</span></a>';
										}
									 
									 }else{
									  	echo '&nbsp;';
									 }
									 
									 ?>
									  </td>
									  <td>&nbsp;</td>
									  
									  </tr>
									  </table>

									<table style="margin-left:38px;"> 
									 <?php
									 //����Ѿ����Ϊ�Ѿ�����������ʾ���빺�ﳵ�Ͷ�����ť�� start
									 if($product_info['products_stock_status']=='0'){
									 ?>
									  <tr>
										  <td align="right" style="padding-right:10px;">
										  <?php echo tep_template_image_button('book_now_out.gif', db_to_html('������֧��'),'onclick="alert(\''.db_to_html('�����Ѿ����꣡').'\')"');  ?>										  </td>
										  
										  <td height="32" align="left">
										<?php
										//���빺�ﳵ��ť
										echo '<a href="JavaScript: void(0);" onclick="alert(\''.db_to_html('�����Ѿ����꣡').'\')" >'.tep_template_image_button('shopping-cart-button-out.gif', db_to_html('���빺�ﳵ'),'').'</a>';
										?>
										</td>
									  </tr>
									 <?php
									 }else{
									 ?> 
									  <tr>
										  <td align="right" style="padding-right:10px;">
										  <?php echo tep_template_image_submit('book_now.gif', db_to_html('������֧��'),'onclick="return validate()"');  ?>									  </td>
										  
										  <td height="32" align="left">
										<?php
										//���빺�ﳵ��ť
										echo '<a href="JavaScript: void(0);" onclick="AddToCart();" >'.tep_template_image_button('shopping-cart-button.gif', db_to_html('���빺�ﳵ'),'').'</a>';
										?>
										</td>
									  </tr>
									  <?php
									  }
									  //����Ѿ����Ϊ�Ѿ�����������ʾ���빺�ﳵ�Ͷ�����ť�� end
									  ?>
									  </table>

									  <!--�Ź���ʾ��Ԥ�㡢������ť end -->
								  

								<?php echo '</td>';?>
								
								
								<?php 
								  if($dis_buy_steps_2!=true){
									$buy_steps_class = 'buy_steps_2';
									$class_bustep = '';
								  }else{
									$buy_steps_class = 'buy_steps_3';
									$class_bustep = '';
								  }
								?>
								
								<td class="<?php echo $class_bustep?>" valign="top">
								<!--��Ʊ��Ϣ-->
								<table width="99%" border="0" cellpadding="0" >
								 <tr>
									<td width="1%" style="height:3px;"></td>
									<td width="15%" style="height:3px;"></td>
									<td width="84%" style="height:3px;"></td>
								  </tr>
								<?php 	
									/*if($product_info['display_room_option']==1){
									  echo'<tr>
										  <td width="1">&nbsp;</td>
										  <td class="buy_options_title" ><b>'.TEXT_LODGING.'</b></td>
										  <td><div id="hot-search-params"></div></td>
										</tr>';
									}elseif($product_info['display_room_option']==0){
									  echo'<tr>
										  <td width="1">&nbsp;</td>
										  <td class="buy_options_title" ><b>'.TEXT_TICKETS.'</b></td>
										  <td><div id="hot-search-params"></div></td>
										</tr>';
									}*/	
									if($product_info['display_room_option']==1 || $product_info['display_room_option']==0){
										  
										$TEXT_TICKETS = TEXT_TICKETS;
										if($content=='product_info_vegas_show'){ $TEXT_TICKETS = WATCH_PEOPLE_NUM; }
										  echo'<tr>
											  <td width="1">&nbsp;</td>
											  <td class="'.$buy_steps_class.'" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
											  <td class="buy_options_title" ><b>'.$TEXT_TICKETS.'</b></td>
											</tr>
											<tr>
											  <td width="1">&nbsp;</td>
											  <td>&nbsp;</td>
											  <td><div id="hot-search-params"></div></td>
											</tr>';
									}		
								  ?>
								  
								 <?php
								 //���ͬ��ѡ��
								 if(TRAVEL_COMPANION_OFF_ON=='true'){
								 ?> 
								  <tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td><input name="travel_comp" type="hidden" id="travel_comp" value="0" /></td>
								  </tr>
								 <?php
								 }
								 ?> 
								  
								  
								  </table>
								<!--��Ʊ��Ϣ end--> 
								  </td>
								</tr>
								
						</table>
						</td></tr>
						</table>

						
						</div>

						 </form>
					   </div>

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
			AvailabletourDate.style.width='137px';
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
var d_selects = q_from.elements['departurelocation'];	//�ݳ�ʱ�������б�
var time_pop = document.getElementById('timePop');	//������ʱ���
var sel_date = document.getElementById('availabletourdate');		//��������
var OperateInfo = document.getElementById('operate_info');


function auto_hide_time_select(){
	if(d_selects.options.length>10){
		d_selects.style.display = "none";
		q_from.elements['tmp_show_time'].style.display = "block";
		//���ر������ڵ����� 
		if(OperateInfo!=null){
			OperateInfo.innerHTML = '<div style="position:relative; z-index:100;"><a href="javascript:void(0)" onclick="show_time_pop(); "><?= db_to_html("�鿴�����ݳ�ʱ��");?></a> <div id="timePopShow" class="timePopShow" style="display:none"></div><iframe id="DivShim" src="javascript:;" scrolling="no"></iframe></div>';
		}
	}
}
auto_hide_time_select();

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
	}else{
		DivSetVisible();
		time_pop_show.innerHTML = "";
	}

	tergetobj.innerHTML = '<div style="text-align:right"><img src="image/loading.gif" /></div>';
	tergetobj.style.display = "block";
	
	var TimeAndLocaltion = "";
	var QuFaDate = "";
	var AllQuFaDate = "";
	var ProductsOptions = "";
	for(i=0; i<d_selects.options.length; i++){
		TimeAndLocaltion += d_selects.options[i].value+"<::>";
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
	var TmpShowTime = document.getElementById('tmp_show_time');
	var input_obj = TableList.getElementsByTagName('input');
	var NewAvailDate = "";
	for(i=0; i<input_obj.length; i++){
		if(input_obj[i].type=="radio" && input_obj[i].checked==true){
			d_selects.value = input_obj[i].value;
			TmpShowTime.value = input_obj[i].title;
			NewAvailDate = input_obj[i].title.substr(0,10);
			break;
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
</script>

<script type="text/javascript">
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
/*show�ŵ��ݳ�ʱ���Ż���JS���� end*/
?>
<script type="text/javascript">

function Check_Onfocus(obj){
	if(obj.value=="<?php echo PLX_INPUT_KEY?>"){
		obj.value="";
		obj.className='input_search2';
	}
}
function Check_Onblur(obj){
	if(obj.value=="" || obj.value=="<?php echo PLX_INPUT_KEY?>"){
		obj.value="<?php echo PLX_INPUT_KEY?>";
	}
}

function show_and_hidden(id_name){
	var id = document.getElementById(id_name);
	if(id.style.display=='none'){
		id.style.display='';
	}else{
		id.style.display='none';
	}
}
function show2un(id_name){
	var id = document.getElementById(id_name);
	var bot = document.getElementById('bot_' + id_name.replace(/.+\_/g,''));
	var img = document.getElementById('img_b_' + id_name.replace(/.+\_/g,''));
	if(id.style.display=='none'){
		id.style.display='';
		bot.innerHTML='<?php echo db_to_html("����")?>';
		img.src = '<?php echo HTTP_SERVER?>/image/shouqi.gif';
		
	}else{
		id.style.display='none';
		bot.innerHTML='<?php echo db_to_html("չ��")?>';
		img.src = '<?php echo HTTP_SERVER?>/image/zhankai.gif';
	}
}
<?php
$p=array('/&amp;/','/&quot;/');
$r=array('&','"');
?>

function Submit_Companion_Re(From_id){

	var Companion = document.getElementById(From_id);
	var error_msn = '';
	var error = false;
	for(i=0; i<Companion.length; i++){
	
		if(Companion.elements[i]!=null){
			if(Companion.elements[i].value.length < 1 && Companion.elements[i].className.search(/required/g)!= -1){
				error = true;
				error_msn +=  "* " + Companion.elements[i].title + "\n\n";
			}
		}
	}
	
	if(error==true){
		alert(error_msn);
		return false;
	}else{
		var form = Companion;
		var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('ajax_travel_companion_re.php','action=process')) ?>");
		var aparams=new Array();  //����һ�����д������Ԫ�غ�ֵ
	
		for(i=0; i<form.length; i++){
			var sparam=encodeURIComponent(form.elements[i].name);  //ȡ�ñ�Ԫ����
			sparam+="=";     //����ֵ֮����"="������
			
			if(form.elements[i].type=="radio"){	//����ѡ��ťֵ
				var a = a;
				if(form.elements[i].checked){
					a = form.elements[i].value;
				}
				sparam+=encodeURIComponent(a);   //��ñ�Ԫ��ֵ
			}else{
				sparam+=encodeURIComponent(form.elements[i].value);   //��ñ�Ԫ��ֵ1
			}
			
			aparams.push(sparam);   //push�ǰ���Ԫ����ӵ�������ȥ
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
					alert(ajax.responseText.replace(error_regxp,''));
					if(ajax.responseText.search(/(\[JS\].+\[\/JS\])/g)!=-1){
						
						eval(ajax.responseText.replace(/(.*\[JS\])|(\[\/JS\].*[:space:]*.*)/g, ''));
					}
				}
	
				var success_regxp = /(.*\[SUCCESS\])|(\[\/SUCCESS\].*[:space:]*.*)/g;
				if(ajax.responseText.search(/(\[SUCCESS\]\d+\[\/SUCCESS\])/g)!=-1){		
					//alert("<?php echo db_to_html('��Ϣ��ӳɹ���');?>");
					var t_rid = ajax.responseText.replace(success_regxp,'');
					var reply = document.getElementById('reply_' + From_id.replace(/.+\_/g,''));
					reply.innerHTML += ajax.responseText.replace(/\[SUCCESS\].+\[\/SUCCESS\]/,'');
					reply.style.display ='';
					for(i=0; i<form.length; i++){
						if(form.elements[i].type!='hidden'){
							form.elements[i].value = '';
						}
					}
					var loginid = document.getElementsByTagName('td');
					for(i=0; i<loginid.length ; i++){
						if(loginid[i].id.indexOf("Login_tr_")> -1 ){
							loginid[i].innerHTML = '';
						}
					}

				}
				
			}
			
		}

	}
}

</script>

<table cellSpacing=0 cellPadding=0 width="100%" border=0  style="margin-top:5px;">
              <tbody>
              <tr>
                <td class=main style="BACKGROUND-COLOR: rgb(255,255,255)" 
                vAlign=middle width="72%">
                <div class="product_detail_content"  style=" width:98%" >
      <div class="product_tab_b_n" style=" width:97%">
      <div class=tab1 id=tab1>
	  <UL>
        <LI <?= $li_class0?>><a href="<?php echo tep_href_link('travel_companion_list.php','top_class=west')?>"><?php echo USA_WEST?></a></LI>
        <LI <?= $li_class1?>><a href="<?php echo tep_href_link('travel_companion_list.php','top_class=east')?>"><?php echo USA_EAST?></a></LI>
        <LI <?= $li_class2?>><a href="<?php echo tep_href_link('travel_companion_list.php','top_class=hawaii')?>"><?php echo USA_HAWAII?></a></LI>
        <LI <?= $li_class3?>><a href="<?php echo tep_href_link('travel_companion_list.php','top_class=canada')?>"><?php echo USA_CANADA?></a></LI></UL></div></div></div>
                <div class="friend-active-bar">
				<div style="float:left; padding-top:10px;">
				<form action="<?php echo tep_href_link('bbs_travel_companion_content.php')?>" method="get" name="sc_form" id="sc_form">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td valign="middle">&nbsp;</td>
                                <td valign="middle" nowrap="nowrap"><b><?php echo db_to_html('����')?></b>&nbsp;</td>
                                <td valign="middle">
								<?php
								//
								$sel_option =array();
								$sel_option[0] = array('id'=>'all','text'=>db_to_html('ȫ��'));
								$sel_option[1] = array('id'=>'noid','text'=>db_to_html('ԭ��'));
								$sel_option[2] = array('id'=>'west','text'=>db_to_html('����������'));
								$sel_option[3] = array('id'=>'east','text'=>db_to_html('����������'));
								$sel_option[4] = array('id'=>'hawaii','text'=>db_to_html('������'));
								$sel_option[5] = array('id'=>'canada','text'=>db_to_html('���ô�'));
								echo tep_draw_pull_down_menu('top_class',$sel_option);
								?>
								
								</td>
								<td height="22" align="center">&nbsp;</td>
                                <td align="center">
								<?php
								if(!tep_not_null($_GET['s_c_keyword'])){
									$s_c_keyword = PLX_INPUT_KEY;
								}
								echo tep_draw_input_field('s_c_keyword','','class="input_search2" size="22" onfocus="Check_Onfocus(this)"; onBlur="Check_Onblur(this)" style="margin-top:0px; margin-bottom:0px;" ');
								?>

								</td>
                                <td valign="middle">&nbsp;</td>
                                <td valign="middle"><?php echo tep_image_submit('button_search.gif', db_to_html('����')) ?></td>
                                <td valign="middle">&nbsp;</td>
                                <td align="right" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if(!(int)$customer_id){ echo db_to_html('Ҫ����������<a href="'.tep_href_link('login.php').'" class="sp3">��¼</a>��<a href="'.tep_href_link("create_account.php","", "SSL").'" class="sp3">ע��</a>');}?>
				 				</td>
				  				<td align="right"><?php echo '<a href="javascript:void(0);" onClick="showPopup(&quot;CreateNewCompanion&quot;,&quot;CreateNewCompanionCon&quot;,1);" >' . tep_template_image_button('activte-button.gif', db_to_html('����'),'style="float:left; margin-left:5px;"') . '</a>'; ?>
								&nbsp;<a target="_blank" href="<?php echo tep_href_link('companions_process.php')?>"><img src="image/what.gif" alt="<?php echo db_to_html('����')?>" border="0" align="absmiddle" /></a>
								</td>
                              </tr>
                  </table>
				</form>
				</div>
				
                </div>
				
                <div class="friend-active-bar" style="margin-top:0px; margin-bottom:7px; border-bottom:1px solid #93CEF3;"><div style="float:left; font-size:14px;"><b><?php echo db_to_html($categories_name);?></b></div>
                </div>
                
				<?php
				if((int)$travel_rows['t_companion_id']){
				do{
					//���µ����
					tep_db_query('update travel_companion set click_num=(click_num+1) WHERE t_companion_id="'.(int)$travel_rows['t_companion_id'].'" ' );

				?>
				
				<div class="friend-active-bar" style="margin-top:0px; padding-top:0px;">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td colspan="7"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#DAF0FD" style="border:1px solid #108BCE; border-left:0px; border-right:0px;">
                          <tr>
                            <td width="68%" height="27" class="cu"><p style="padding-left:8px; font-weight:bold;" >
							
							<?php
							$inde_name = '�����';
							if((int)$travel_rows['products_id']){
								$products_name = tep_get_products_name((int)$travel_rows['products_id']);
								$prod_sql = tep_db_query('SELECT products_model FROM `products` WHERE products_id="'.(int)$travel_rows['products_id'].'" limit 1');
								$prod_row = tep_db_fetch_array($prod_sql);
								$inde_name = '<a href="'.tep_href_link('product_info.php','products_id='.(int)$travel_rows['products_id']).'" class="sp3" title="'.$products_name.'">['.$prod_row['products_model'].']</a>';
							}
							echo db_to_html($inde_name).' ';
							echo db_to_html(tep_db_output($travel_rows['t_companion_title']));
							?></p></td>
                            <td width="18%" nowrap="nowrap" class="cu"><?php echo db_to_html('�����ˣ�')?><span class="jifen_num">
							
							<?php
							$sex_string = '';
							if($travel_rows['t_gender']=='1'){
								$sex_string = ' ����';
							}
							if($travel_rows['t_gender']=='2'){
								$sex_string = ' Ůʿ';
							}

							echo db_to_html(tep_db_output($travel_rows['customers_name']). $sex_string);
							?></span>&nbsp;
							
							</td>
                            <td width="14%" nowrap="nowrap" class="cu"><?php echo db_to_html('��������'.(int)$travel_rows['reply_num'])?>&nbsp;</td>
                            <td width="14%" nowrap="nowrap" class="cu"><?php echo db_to_html('�������'.(int)$travel_rows['click_num'])?>&nbsp;</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td colspan="4" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #6F6F6F;">
                          <tr>
                            <td width="95%" height="20" align="right" bgcolor="#ECECEC"><span class="jifen_num cu"><?php echo db_to_html('¥��')?></span></td>
                            <td width="5%" align="right" bgcolor="#ECECEC">&nbsp;</td>

                          </tr>
                          <tr>
                            <td colspan="2" valign="middle" bgcolor="#ECECEC"><p style="padding-left:8px"><?php echo db_to_html(nl2br(tep_db_output($travel_rows['t_companion_content'])))?></p></td>
                          </tr>
                          <tr>
                            <td height="32" colspan="2" valign="middle" bgcolor="#ECECEC"><p style="padding-left:8px; color:#666666">
							<?php
							echo db_to_html('�����ˣ�'.tep_db_output($travel_rows['customers_name']). $sex_string);
							?>&nbsp;
							<?php
							if((int)$travel_rows['t_show_email']){
								echo db_to_html('���䣺').tep_db_output($travel_rows['email_address']).'&nbsp;';
							}
							?>
							<?php
							$phone_open=false;
							if($phone_open==true && (int)$travel_rows['t_show_phone'] && strlen($travel_rows['customers_phone'])>6){
								echo db_to_html('�绰��').tep_db_output($travel_rows['customers_phone']).'&nbsp;';
							}
							?>
							<?php echo db_to_html('ʱ�䣺'.chardate($travel_rows['last_time'],'D'));?>&nbsp;<?php echo db_to_html('������'.$travel_rows['reply_num']);?></p></td>
                          </tr>
                      </table></td>
                    </tr>
                    
					<tr>
                      <td colspan="4" valign="top" id="reply_<?=(int)$travel_rows['t_companion_id']?>">
					<?php
					//ȡ�ûظ���
					if($travel_rows['reply_num']){
						$reply_sql = tep_db_query('SELECT * FROM `travel_companion_reply` WHERE t_companion_id="'.(int)$travel_rows['t_companion_id'].'" AND status=1  Order By t_c_reply_id');
						$start_num = 0;
						while($reply_rows = tep_db_fetch_array($reply_sql)){
							$start_num++;
					?>
					  
					  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px dashed #6f6f6f;">
                          <tr>
                            <td width="78%" height="20"  ></td>
                            <td width="14%" nowrap="nowrap" >
							
							<?php
							if(tep_not_null($reply_rows['customers_name'])){
								if($reply_rows['customers_id']==$travel_rows['customers_id']){
									echo '<b class="jifen_num">'.db_to_html('¥��</b> �Ļظ�');
								}else{
									echo db_to_html(tep_db_output($reply_rows['customers_name']).' �Ļظ�').'&nbsp;&nbsp;'.$reply_rows['last_time'];
								}
							}else{
								echo db_to_html(tep_db_output(tep_customers_name($reply_rows['customers_id'])) .' �Ļظ�').'&nbsp;&nbsp;'.$reply_rows['last_time'];
							}
							?>							</td>
                            <td width="8%" align="right" nowrap="nowrap" ><span style="color:#6f6f6f;"><?php echo $start_num.db_to_html('¥')?></span></td>
                          </tr>
                          <tr>
                            <td height="32" colspan="3" style="color:#6f6f6f" ><p style="padding-left:32px;"><?php echo db_to_html(nl2br(tep_db_output($reply_rows['t_c_reply_content'])))?></p></td>
                          </tr>
                      </table>
					 <?php
					 	}
					 }
					 ?>					  </td>
                    </tr>
                    
					
                    <tr style="height:4px;">
                      <td></td>
                    </tr>
                    <tr>
                      <td width="81%" valign="top">&nbsp;</td>
                      <td width="4%" align="center" valign="middle">
					  <a href="JavaScript:void(0)" onclick="show2un('reply_<?=(int)$travel_rows['t_companion_id']?>')"><img src="image/shouqi.gif" id="img_b_<?=(int)$travel_rows['t_companion_id']?>" border="0" /></a>
					  </td>
                      <td width="6%" valign="middle" class="dazi">
					  <a href="JavaScript:void(0)" onclick="show2un('reply_<?=(int)$travel_rows['t_companion_id']?>')" id="bot_<?=(int)$travel_rows['t_companion_id']?>"><?php echo db_to_html('����')?></a>
					  </td>
                      <td width="9%" valign="top"><a href="JavaScript:void(0)" onclick="show_and_hidden('reply_input_<?=(int)$travel_rows['t_companion_id']?>')" style="display:block; width:50px; height:18px; padding-top:2px;  text-align:center; background:#EDF8FE; border:1px solid #90C2E1; font-weight:bold;"><?php echo db_to_html('����')?></a></td>
                    </tr>
                    <tr>
                      <td colspan="4" valign="top" id="reply_input_<?=(int)$travel_rows['t_companion_id']?>" style="display:<?= 'none';?>">
					  <div id="reply_input_<?=(int)$travel_rows['t_companion_id']?>">
					    <form action="" method="post" name="CompanionForm_<?=(int)$travel_rows['t_companion_id']?>" id="CompanionForm_<?=(int)$travel_rows['t_companion_id']?>" onsubmit="Submit_Companion_Re('CompanionForm_<?=(int)$travel_rows['t_companion_id']?>'); return false">
					      <input name="t_companion_id" type="hidden" id="t_companion_id" value="<?= (int)$travel_rows['t_companion_id']?>" />
						  
						  <table width="99%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td colspan="2">
							  
							  <?php echo tep_draw_textarea_field('t_c_reply_content', 'soft', '', '6','',' class="required textarea_bg validation-passed"  style="width:99% " id="t_companion_content" title="'.db_to_html('�������������').'"'); ?>
							  </td>
                              </tr>
                            
							<?php if(!(int)$customer_id){?>
							<tr>
							<td  colspan="2" id="Login_tr_<?=(int)$travel_rows['t_companion_id']?>">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
									  <td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('��δ��¼��������������䣺')?>&nbsp;
									  <?php echo tep_draw_input_field('email_address','','class="required validate-email" style="width: 160px;" title="'.db_to_html('���������ĵ�������').'"') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
		
									  <td height="25" align="right" valign="top" class="title_line"><?php echo db_to_html('����')?>&nbsp;<input name="password" type="password" class="required" id="password" title="<?php echo db_to_html('��������ȷ������')?>" /><span class="inputRequirement"> * </span><?php echo db_to_html('���û����� <a href="'.tep_href_link("create_account.php","", "SSL").'" class="sp3">ע��</a>');?></td>
									</tr>
								
							  </table>
							</td>
							</tr>
							
							<?php }?>
							<tr>
							  <td height="25" colspan="2" align="right" valign="top" class="title_line"><P style="text-align:right; padding-top:5px;"><?php echo tep_template_image_submit('fabiao-button.gif', db_to_html('����')); ?></P></td>
							  </tr>
                          </table>
						  
						</form>
					    
                		</div>					  </td>
                      </tr>
                    <tr>
                      <td colspan="4" valign="top" id="reply_input_<?=(int)$travel_rows['t_companion_id']?>">&nbsp;</td>
                    </tr>
                  </table>
                </div>
                
				<?php
				}while($travel_rows = tep_db_fetch_array($travel_query));
				}
				?>
				
				<div class="jianyi_title_content page_link" style="margin-left:15px; margin-top:0px; width:650px;">
				
				<?php echo TEXT_RESULT_PAGE . ' ' . $travel_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page'))); ?>
				
				</div>                  </td>
                <td valign="top" bgColor=#e3f5ff><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  
                  <tr>
                    <td><div class="help_phone_call">
					<?php 
					echo db_to_html('���κ������벦��<br>
					<span style="font-weight:bold;">1-626-898-7800 888-887-2816</span><br>
					��<span style="font-weight:bold;">0086-4006-333-926</span>��ͷ�����<br>
					<span style="font-weight:bold;">service@usitrip.com</span>
					')?>
					</div></td>
                  </tr>
                  <tr>
                    <td><div style="border:1px solid #FFD011; width:254px; margin-top:10px; margin-left:6px; background:url(image/youshi_bg.gif); background-repeat:repeat-x;"><table width="94%" border="0" cellpadding="0" cellspacing="0" style="margin-left:12px;">
                      <tr>
                        <td height="25"><b><?php echo db_to_html('���ǵ�����')?></b></td>
                      </tr>
                      <tr>
                       <td>
                       <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                          <td height="25"><img src="image/list_jiantou3.gif"></td>
                          <td width="92%"><a href="<?php echo tep_href_link('our-advantages.php')?>" class="text"><?php echo db_to_html('��Ʒ�������г̱�֤')?></a></td>
                          </tr>
                          <tr>
                          <td height="25"><img src="image/list_jiantou3.gif"></td>
                          <td width="92%"><a href="<?php echo tep_href_link('our-advantages.php')?>" class="text"><?php echo db_to_html('BBB���������ķ�������ΪA-��')?></a>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25"><img src="image/list_jiantou3.gif"></td>
                            <td><a href="<?php echo tep_href_link('our-advantages.php')?>" class="text">GODADDY.COM<?php echo db_to_html('��֤�İ�ȫ�ɿ���վ')?></a></td>
                          </tr>
                          <tr>
                            <td height="25"><img src="image/list_jiantou3.gif"></td>
                            <td><a href="<?php echo tep_href_link('our-advantages.php')?>" class="text">7/24<?php echo db_to_html('Сʱ��ȫ�����վ����')?></a></td>
                          </tr>
                          <tr>
                            <td height="25"><img src="image/list_jiantou3.gif"></td>
                            <td><a href="<?php echo tep_href_link('our-advantages.php')?>" class="text">1000+<?php echo db_to_html('��ѡ�г��ʺϸ�������')?></a></td>
                          </tr>
                          <tr>
                            <td height="25"><img src="image/list_jiantou3.gif"></td>
                            <td><a href="<?php echo tep_href_link('our-advantages.php')?>" class="text"><?php echo db_to_html('�߶ȹ�ע�ͻ�����')?></a></td>
                          </tr>  
                      </table>
                    </table>
                    </div>                    </td>
                  </tr>
                </table></td>
                </tr></tbody></table>

<?php require_once('travel_companion_tpl.php');?>

<?php
if($_SESSION['hawaii_self']){
	//print_r($_SESSION['hawaii_self']['free_combination_day']);
	//exit;
}
/*
����������ҳ��

��ҳ������������$_SESSION['hawaii_self']������������$_SESSION['hawaii_self']�ڸ����ֵ����ѡ��Ƶ������Ƶ��г̵�ʱ����Ҫ��������һ�θ�ֵ
tours_day
room-0-adult-total
room-0-child-total

hotel_ids
tour_ids
start_dates
end_dates
*/

?>
<?php
$p=array('/&amp;/','/&quot;/');
$r=array('&','"');
?>
<script type="text/javascript"> 
//��ʼ�����е��ύ
function free_combination_day_html(){
	var from = document.getElementById('cart_quantity');
	var day_num = from.elements['tours_day'].value;
	var html_code = '';
	for(i=0; i<day_num; i++){
		class_name = 'daybyday daybyday_ou';
		if(i%2==0){
			class_name = 'daybyday';
		}
		if(i==0){
			class_name = ' daybyday s ';
		}
		if(i%5==0 && i>0){
			//html_code += '</div><div>';
		}
		html_code += '<div class="'+class_name+'" id="free_'+i+'"><div class="day_box" id="free_box_'+i+'"><p class="day_title" id="free_p_'+i+'"><span><?php echo db_to_html("�� '+(i+1)+' ��")?> </span><a id="EmptyButton_'+i+'" href="javascript:void(0)" onClick="ClearHasBeenSelectedHotels(this)"><?php echo db_to_html('���')?></a></p><div id="free_img_'+i+'"><img src="image/example_tu.gif" width="93" height="60" ></div><p class="day_des" id="free_hotel_name_'+i+'"></p><p class="day_des2" id="free_des_text_'+i+'"></p></div></div>';
	}
	
	var free_combination_day = document.getElementById('free_combination_day');
	var free_combination_step2 = document.getElementById('free_combination_step2');
	free_combination_day.innerHTML = html_code;
	free_combination_step2.style.display = '';
	var Hotel_Cearch_Results = document.getElementById('hotel_cearch_results');
	Hotel_Cearch_Results.innerHTML = '';
	EmptySubMitTours();

	hc_f = document.getElementById('hotel_cearch_form');
	hc_f.elements['filtration'].value = '';
	
	var tmp_box = document.getElementById('tmp_box');
	tmp_box.innerHTML = '';
	
}

//��հ�ť
function ClearHasBeenSelectedHotels(obj){
	var num = Number(obj.id.replace(/EmptyButton_/,''));
	var free_img = document.getElementById('free_img_'+num);
	var need_re_load = false;
	//�ж��Ƿ��Ѿ������
	if(free_img!=null){
		var img = free_img.getElementsByTagName('img');
		if(img[0].src.indexOf("example_tu.gif")>-1){	//�յ��ճ��Ƴ�
			var free = document.getElementById('free_'+num);
			var obj_f = document.getElementById('free_combination_day');
			var div = obj_f.getElementsByTagName('div');
			var rm_all = false;
			if(rm_all==true){		//���켰�Ժ�������콫���ᱻɾ��
				if(window.confirm("<?php echo db_to_html("���켰�Ժ�������콫���ᱻɾ����Ҫ������\t")?>")==true){
					for(h=0; h<div.length; h++){
						if(div[h].id.search(/^free_[0-9]+$/)>-1 && Number(div[h].id.replace(/free_/,'')) >= num ){
							var rm_div = div[h];
							rm_div.parentNode.removeChild(rm_div);
							h--;
						}
					}
					need_re_load = true;
				}
			}else{	//ֻɾ����ǰѡ����
				free.parentNode.removeChild(free);
				need_re_load = true;
			}


		}else if(img[0].src.length>1){
			if(window.confirm("<?php echo db_to_html("�����Ҫ��ոþƵ꼰���г���\t")?>")==true){
				//ȡ�õ�ǰɾ���㿪ʼ��ͽ�����
				var free_des_text = document.getElementById('free_des_text_'+num);
				
				if(free_des_text.innerHTML.length > 2){	//��ʼ�ͽ�β��ɾ���㴦��
					var input = free_des_text.getElementsByTagName('input');
					if(input.length>0){//�����ǰɾ�����Ǵ��г̶ε����һ�㣬��Ӻ���ǰɾ
						for(i=num; i>=0; i--){
							var stop_action = false;
							if(document.getElementById('free_des_text_'+i).innerHTML.length > 2 && num!=i){
								 stop_action = true;
							}
							var rm_obj = document.getElementById('free_'+i);
							rm_obj.parentNode.removeChild(rm_obj);
							if(stop_action==true){
								break;
							}
						}
					}else{	//�����ǰɾ�����Ǵ��г̶εĵ�һ�㣬���ǰ����ɾ
						for(i=num; i<1000; i++){
							var stop_action = false;
							if(document.getElementById('free_des_text_'+i).innerHTML.length > 2 && num!=i){
								 stop_action = true;
							}
							var rm_obj = document.getElementById('free_'+i);
							rm_obj.parentNode.removeChild(rm_obj);
							if(stop_action==true){
								break;
							}
						}
					}
				}else{	//�м��ɾ���㴦��
					for(i=num; i<1000; i++){
						var stop_action = false;
						if(document.getElementById('free_des_text_'+i).innerHTML.length > 2 ){
							 stop_action = true;
						}
						var rm_obj = document.getElementById('free_'+i);
						rm_obj.parentNode.removeChild(rm_obj);
						if(stop_action==true){
							break;
						}
					}
					for(i=num; i>=0; i--){
						var stop_action = false;
						var rm_obj = document.getElementById('free_'+i);
						if(rm_obj!=null){
							if(document.getElementById('free_des_text_'+i).innerHTML.length > 2 ){
								 stop_action = true;
							}
							rm_obj.parentNode.removeChild(rm_obj);
							if(stop_action==true){
								break;
							}
						}
					}
				}
				
				need_re_load = true;
			}
		}
	}
	
	if(need_re_load==true){
		//��պ�����ʾ��ѡ����г�����
		var Hotel_Cearch_Results = document.getElementById('hotel_cearch_results');
		var hotel_div = Hotel_Cearch_Results.getElementsByTagName('div');
		for(i=0; i<hotel_div.length; i++){
			if(hotel_div[i].className =="hotel_single_slect"){
				Hotel_Cearch_Results.innerHTML = '';
				break;
			}
		}
		
		//ɾ������Ҫ���������г��б�
		var free_sum_num = get_free_num();
		var tmp_box = document.getElementById('tmp_box');
		var free_combination_day = document.getElementById('free_combination_day');
		tmp_box.innerHTML = free_combination_day.innerHTML;
		free_combination_day.innerHTML = '';
		//�����齨free_combination_day���Ӷ���
		for(i=0; i<free_sum_num; i++){
			var free_ = document.createElement('div');
			var class_ = 'daybyday daybyday_ou';
			if(i%2==0){
				class_ = 'daybyday';
			}
			if(document.all){	//ie
				free_.className = class_;
				free_.id = 'free_'+i;
			}else{
				free_.setAttribute("class",class_);
				free_.setAttribute("id",'free_'+i);
			}
			
			//ȡ��tmp_box.free_��Ӧ���Ӵ���
			var free_tmp = tmp_box.getElementsByTagName('div');
			var free_no = 0;
			var tmp_html_code = '';
			for(j=0; j<free_tmp.length; j++){
				if(free_tmp[j].id.search(/^free_[0-9]+$/)>-1){
					free_no++;
					if((free_no-1)==i){
						tmp_html_code = free_tmp[j].innerHTML.replace(/(free_box_)([0-9])+/g,'$1'+i);
						tmp_html_code = tmp_html_code.replace(/(free_p_)([0-9])+/g,'$1'+i);
						tmp_html_code = tmp_html_code.replace(/(free_img_)([0-9])+/g,'$1'+i);
						tmp_html_code = tmp_html_code.replace(/(free_hotel_name_)([0-9])+/g,'$1'+i);
						tmp_html_code = tmp_html_code.replace(/(free_des_text_)([0-9])+/g,'$1'+i);
						tmp_html_code = tmp_html_code.replace(/(EmptyButton_)([0-9])+/g,'$1'+i);
						
						tmp_html_code = tmp_html_code.replace(/\<span\><?php echo db_to_html('�� [0-9]+ �� ')?>\<\/span\>/i, '<span><?php echo db_to_html("�� '+(i+1)+' �� ")?></span>');
						//����show_hotel_tours(1139,1040, 2,1);��֮��ĺ���,��һ���������봦��
						tmp_html_code = tmp_html_code.replace(/show_hotel_tours\(([0-9]+),([0-9]+), ([0-9]+),([0-9]+)\)/,'show_hotel_tours($1,$2, $3,'+i+')');
						
					}
				}
			}
			free_.innerHTML = tmp_html_code;
			free_combination_day.appendChild(free_);
			//alert(free_sum_num);
		}
		tmp_box.innerHTML = '';
		
		if(document.all){	//ie ��Ҫ�������free_����� onClick�¼� show_hotel_tours(1137,1040, 2,1); s_free_class(this.parentNode.parentNode.parentNode.id)
			var free_img_re = free_combination_day.getElementsByTagName('div');
			
			var hid = 0;
			var tid = 0;
			var no_day = 0;		//��ǰ��Ŀǰ�г��еĵڼ��죿
			var all_day = 0;	//��ǰ���������еĵڼ��죿
			
			for(r=Number(free_img_re.length-1); r>=0; r--){
				if(free_img_re[r].id.indexOf('free_img_')>-1){
					var img_r = free_img_re[r].getElementsByTagName('img');
					if(img_r.length==1 && img_r[0].src.indexOf('example_tu.gif')==-1){
						var now_array_id = img_r[0].parentNode.id.replace(/free_img_/,'');
						var free_des_text_input = document.getElementById('free_des_text_'+now_array_id);
						if(free_des_text_input==null){
							alert('No obj free_des_text_input_XX');
						}
						var input_box = free_des_text_input.getElementsByTagName('input');
						if(input_box.length>0){
							for(loop=0; loop<input_box.length; loop++){
								switch(input_box[loop].name){
									case 'hotel_ids[]': hid=input_box[loop].value; break;
									case 'tour_ids[]': tid=input_box[loop].value; break;
								}
							}
							
							no_day = free_des_text_input.innerHTML.replace(/.+\<span .+\>([0-9]+)<?php echo db_to_html('��')?>\<\/span\>.+/i,'$1');	
							no_day = Number(no_day);
							//alert(no_day);								
						}
						
						var span_obj = document.getElementById('free_p_'+now_array_id).getElementsByTagName('span');
						all_day = span_obj[0].innerHTML.replace(/<?php echo db_to_html("(.+)([0-9]+)(.+)")?>/,'$2');
						all_day = Number(all_day)-1;
						img_r[0].onclick = Function('show_hotel_tours('+ hid +','+ tid +', '+ no_day +','+ all_day +'); s_free_class(this.parentNode.parentNode.parentNode.id) ');						
						no_day--;
						
					}
				}
			}
			
		}
		// ie ����end
		
		//����г̿�free_combination_day���Ѿ���ȫ����գ�����Ҫ��free_combination_step2��SubMitToursDiv����
		if(free_combination_day.innerHTML.length<1){
			if(document.getElementById('free_combination_step2')!=null){
				document.getElementById('free_combination_step2').style.display = 'none';
			}
			if(document.getElementById('SubMitToursDiv')!=null){
				document.getElementById('SubMitToursDiv').style.display = 'none';
			}
		}
		
		//��պ���Ҫ���¼�¼SESSIONֵ
		write_coockie();		
	}
	
}

//����г̺;Ƶ굽�г̿��Լ���¼���ݵ�Ŀ����Ա��ύ�������
function FillTravel(num_value,hotel_id,tour_id){
	var top_obj = document.getElementById('free_combination_day');
	var p = top_obj.getElementsByTagName('p');
	var i_max = p.length-1;
	var hc_f = document.getElementById('hotel_cearch_form');
	var target_from = document.getElementById('SubMitToursForm');

	//alert('ѡ��'+num_value+'���г�');
	var for_loop = 1;
	for(i = i_max; i>-1; i--){
		//��һ�� or ������
		if((p[i].id.indexOf('free_des_text_0')> -1 && p[i].innerHTML=="") || (p[i].id.indexOf('free_des_text_')>-1 && p[i].innerHTML!="")){
			//��ʼ���
			var tmp_num = p[i].id.replace(/free_des_text_/,'');
			var patrn=/^[0-9]{1,20}$/; 
			if (patrn.test(tmp_num)!= false){
				var int_tmp_num = Number(tmp_num);
				var free_des_text_obj_start = document.getElementById('free_des_text_'+ String(int_tmp_num));
				var free_hotel_name_start = document.getElementById('free_hotel_name_'+ String(int_tmp_num));
				var free_hotel_name_end = document.getElementById('free_hotel_name_'+ String(int_tmp_num+num_value-1));
				var free_img = document.getElementById('free_img_'+ String(int_tmp_num));
				var free_des_text_obj_end = document.getElementById('free_des_text_'+ String(int_tmp_num+num_value-1));
				var sum_num = String(int_tmp_num+num_value);
				var sum_num_min = String(int_tmp_num);

				if(int_tmp_num>0){
					free_des_text_obj_start = document.getElementById('free_des_text_'+ String(int_tmp_num+1));
					free_hotel_name_start = document.getElementById('free_hotel_name_'+ String(int_tmp_num+1));
					free_hotel_name_end = document.getElementById('free_hotel_name_'+ String(int_tmp_num+num_value));
					free_img = document.getElementById('free_img_'+ String(int_tmp_num+1));
					free_des_text_obj_end = document.getElementById('free_des_text_'+ String(int_tmp_num+num_value));
					//alert(String(int_tmp_num+num_value));
					sum_num = String(int_tmp_num+num_value+1);
					sum_num_min = String(int_tmp_num+1);
				}
				
				if(free_des_text_obj_start==null){
					//alert('no '+ ('free_des_text_'+ String(int_tmp_num)) );
				}
				//������ start
				var add_date_tab = true;
				if(free_des_text_obj_end==null && add_date_tab == false){
					alert('<?php echo db_to_html('ʣ�µ����ڲ��㣡');?>');
				}
				if(free_des_text_obj_start!=null && free_des_text_obj_end==null && add_date_tab == true){
					if(window.confirm('<?php echo db_to_html('ʣ�µ����ڲ��㣡��Ҫ��������������')?>')==true){
						
						//ɾ�����ʱ��εĿն���
						var rmd_div = top_obj.getElementsByTagName('div');
						for(uu=0; uu<rmd_div.length; uu++){
							if(rmd_div[uu].id.search(/^free_[0-9]+$/)>-1 && Number(rmd_div[uu].id.replace(/free_/,'')) >= sum_num_min ){
								var rm_div = rmd_div[uu];
								rm_div.parentNode.removeChild(rm_div);
								uu--;
							}
						}
						//ѭ�����free_X����ֱ������Ϊֹ
						var class_f = 'daybyday daybyday_ou';
						//alert(sum_num_min+'  '+sum_num);
						for(a=Number(sum_num_min); a<Number(sum_num); a++){
							//alert(a);
							var newfree =  document.createElement('div');
							if(document.all){	//ie
								newfree.className = class_f;
								newfree.id = 'free_'+a;
							}else{
								newfree.setAttribute("class",class_f);
								newfree.setAttribute("id",'free_'+a);
							}
							newfree.innerHTML = '<div class="day_box" id="free_box_'+a+'"><p class="day_title" id="free_p_'+a+'"><span><?php echo db_to_html("�� '+(Number(a)+1)+' ��")?> </span><a id="EmptyButton_'+a+'" href="javascript:void(0)" onClick="ClearHasBeenSelectedHotels(this)"><?php echo db_to_html('���')?></a></p><div id="free_img_'+a+'"><img src="image/example_tu.gif" width="93" height="60" ></div><p class="day_des" id="free_hotel_name_'+a+'"></p><p class="day_des2" id="free_des_text_'+a+'"></p></div>';
							top_obj.appendChild(newfree);
							
						}
						
						//alert('<?php echo db_to_html('��ӳɹ���')?>');
						//setTimeout("alert(1)",1000);
						var free_des_text_obj_end = document.getElementById('free_des_text_'+ String(sum_num-1));
						var free_des_text_obj_start = document.getElementById('free_des_text_'+ String(sum_num_min));
						var free_hotel_name_start = document.getElementById('free_hotel_name_'+ String(sum_num_min));
						var free_hotel_name_end = document.getElementById('free_hotel_name_'+ String(sum_num-1));
						var free_img = document.getElementById('free_img_'+ String(sum_num_min));
					}
				}
				//������ end
				
				
				if(free_des_text_obj_start!=null && free_des_text_obj_end!=null){
					if(free_des_text_obj_start!=null){
						free_des_text_obj_start.innerHTML = '<?php echo db_to_html("ƥ��<span style=\"color:#F58610\">' + num_value + '��</span>�г̿�ʼ")?>';
						for(b=0; b<hc_f.length; b++){
							if(hc_f[b].type=="radio" && hc_f[b].checked==true){
								
								if(hc_f[b].id.indexOf('hotel_ids_')>-1){	//�Ƶ�
									var fv = hc_f[b].value;
									free_hotel_name_start.innerHTML = free_hotel_name_end.innerHTML = hc_f.elements['hotel_name_'+ fv ].value;
									//target_from.elements['hotel_id'].value += fv+'<::>';

								}
								
								if(hc_f[b].id.indexOf('tours_ids_')>-1){	//��
									/*����ͻ�ѡ����г̳����ڳ����˾Ƶ��������ڣ������г̽�����Ϊ׼������г̽����ձȾƵ������С������Ҫ����һ��������ʣ�����ڵľƵ굱�������Ĳ�Ʒ������ʼ�������г̽������ڣ�������ھ���ԭ����������ڣ��������ܳ��ֶ��ͬһ�Ƶ겻ͬ����ס���ڶ����¹��ﳵֻ��¼����һ���������Ķ�ʧ����Ŀǰ�����г̽�������Ϊ׼��*/
									var ftv = hc_f[b].value;
									//target_from.elements['tours_id'].value += ftv+'<::>';
									//target_from.elements['start_date'].value += hc_f.elements['date_free_start'].value+'<::>';
									var start_date = hc_f.elements['date_free_start'].value;
									hc_f.elements['date_free_start'].value = hc_f.elements['tmp_end_date_'+fv+'_'+ftv].value;
									hc_f.elements['date_frees_end'].value = '';
									//target_from.elements['end_date'].value += hc_f.elements['date_free_start'].value+'<::>';
									var end_date = hc_f.elements['date_free_start'].value;
								}
								
							}
						}

						free_img_num = free_img.id.replace(/free_img_/,'');
						var free_p_id = free_img_num;
						free_img.innerHTML = '';
						//����ͼƬ����
						var src_v = hc_f.elements['hotel_image_'+ fv ].value;
						var newimg = document.createElement('img');
						newimg.setAttribute("src",src_v);
						newimg.setAttribute("width",'93');
						newimg.setAttribute("height",'60');
						newimg.setAttribute("title",free_hotel_name_start.innerHTML);
					
						if(document.all){	//ie
							newimg.onclick = Function('show_hotel_tours('+ fv +','+ ftv +', '+ for_loop +','+ free_p_id +'); s_free_class(this.parentNode.parentNode.parentNode.id) ');
							newimg.style.cursor = 'pointer';
						}else{	//���
							newimg.setAttribute("onclick",'show_hotel_tours('+ fv +','+ ftv +', '+ for_loop +','+ free_p_id +'); s_free_class(this.parentNode.parentNode.parentNode.id) ');
							newimg.setAttribute("style",'cursor:pointer');
							
						}	
						
						free_img.appendChild(newimg);
						for_loop++;
						
					}
					if(free_des_text_obj_end!=null){
						free_des_text_obj_end.innerHTML = '<?php echo db_to_html("ƥ��<span style=\"color:#F58610\">' + num_value + '��</span>�г̽���")?>';
						free_des_text_obj_end.innerHTML += '<input type="hidden" name="hotel_ids[]" value="'+hotel_id+'">';
						free_des_text_obj_end.innerHTML += '<input type="hidden" name="tour_ids[]" value="'+tour_id+'">';
						free_des_text_obj_end.innerHTML += '<input type="hidden" name="start_dates[]" value="'+start_date+'">';
						free_des_text_obj_end.innerHTML += '<input type="hidden" name="end_dates[]" value="'+end_date+'">';
						
						//�������Զ���ת����һ���հ׵���������Ϊѡ����״̬��
						//alert(free_des_text_obj_end.id);
						var free_l = document.getElementById('free_'+ String(Number(free_des_text_obj_end.id.replace(/free_des_text_/,'')) +1 ));
						if(free_l!=null){
							//free_l.className = ' daybyday s ';
							s_free_class(free_l.id);
						}

					}
					
					var cart_quantity = document.getElementById('cart_quantity');
					//target_from.elements['date_num'].value = cart_quantity.elements['tours_day'].value;
					target_from.elements['adult_num'].value = cart_quantity.elements['room-0-adult-total'].value;
					target_from.elements['child_num'].value = cart_quantity.elements['room-0-child-total'].value;
					
					//����б����� hotel_cearch_results
					var Hotel_Cearch_Results = document.getElementById('hotel_cearch_results');
					Hotel_Cearch_Results.innerHTML = '';
					
				}
				
				break;
			}
		}
	}
	
	//��free_des_text_obj_start��free_des_text_obj_end֮��Ŀ��Ҳ��� start
	if(free_des_text_obj_start !=null && free_des_text_obj_end !=null ){
		var start_number = Number(free_des_text_obj_start.id.replace(/free_des_text_/,''));
		var end_number = Number(free_des_text_obj_end.id.replace(/free_des_text_/,''));
		for(j=(start_number+1); j<(end_number+1); j++){
			var free_img_c = document.getElementById('free_img_'+ j);
			//var free_img_o = document.getElementById('free_img_'+ start_number);
			//free_img_c.innerHTML = free_img_o.innerHTML;
			//alert(j);
			free_img_c.innerHTML = '';
			//�ڼ��죿
			var new_c_img = document.createElement('img');
			new_c_img.setAttribute("src",src_v);
			new_c_img.setAttribute("width",'93');
			new_c_img.setAttribute("height",'60');
			new_c_img.setAttribute("title",free_hotel_name_start.innerHTML);
			if(document.all){	//ie
				new_c_img.onclick = Function('show_hotel_tours('+ fv +','+ ftv +', '+ for_loop +','+ j +'); s_free_class(this.parentNode.parentNode.parentNode.id) ');
				new_c_img.style.cursor = 'pointer';
			}else{	//���
				new_c_img.setAttribute("onclick",'show_hotel_tours('+ fv +','+ ftv +', '+ for_loop +','+ j +'); s_free_class(this.parentNode.parentNode.parentNode.id) ');
				new_c_img.setAttribute("style",'cursor:pointer');
				
			}	
			free_img_c.appendChild(new_c_img);
			for_loop++;
		}
	}
	//��free_des_text_obj_start��free_des_text_obj_end֮��Ŀ��Ҳ��� end
	

}

// �ı�free_ ��div��className
function s_free_class(free_obj_id){
	var top_divs = document.getElementById('free_combination_day').getElementsByTagName("div");
	for(i=0; i<top_divs.length; i++){
		if(top_divs[i].id.search(/^free_\d+$/)>-1){
			//alert(top_divs[i].id);
			var tmp_num = Number(top_divs[i].id.replace(/free_/,''));
			if(tmp_num%2==0){
				top_divs[i].className = 'daybyday';
			}else{
				top_divs[i].className = 'daybyday daybyday_ou';
			}
		}
	}
	
	var free_div = document.getElementById(free_obj_id);
	
	if(free_div!=null){
		free_div.className = ' daybyday s ';
	}
}

//ȡ���г��б������������
function get_free_num(){
	var free_combination_day = document.getElementById('free_combination_day');
	var free_div = free_combination_day.getElementsByTagName('div');
	var num_ = 0;
	for(i=0; i<free_div.length; i++){
		if(free_div[i].id.search(/^free_[0-9]+$/)>-1){
			num_++;
		}
	}
	return num_;
}

//��ʾѡ��ľƵ���г� No_day ��ָ��N�죬����ȡ���г��еĵ�N������


function show_hotel_tours(h_id, t_id, No_day, No_day_for_all){
	if(h_id<1 || t_id<1){ return false;}
	var Hotel_Cearch_Results = document.getElementById('hotel_cearch_results');
	Hotel_Cearch_Results.innerHTML = '<img alt="Please wait..." src="image/loading.gif" />';
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('ajax_free_show_hotel_tours.php','action=process')) ?>");
	var aparams=new Array();
	var post_str = aparams.join("&");
	post_str += "&ajax=true";
	post_str += "&h_id="+h_id;
	post_str += "&t_id="+t_id;
	post_str += "&No_day="+No_day;
	post_str += "&No_day_for_all="+No_day_for_all;
	
	var date_num_value = get_free_num();
	post_str += "&date_num="+date_num_value;

	ajax.open("POST", url, true); 
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
	ajax.send(post_str);

	ajax.onreadystatechange = function() { 
		if (ajax.readyState == 4 && ajax.status == 200 ) { 
			Hotel_Cearch_Results.innerHTML = ajax.responseText;
			//����id=products_description�е�����
			FilterProductsDescription(No_day);
		}
	}
	
}

function FilterProductsDescription(num){
	var TopDiv = document.getElementById('products_description');
	var div = TopDiv.getElementsByTagName('div');
	var now_pl_1 = 0;
	for(i=0; i<div.length; i++){
		if(div[i].className =="pl_1"){
			now_pl_1++;
			if(now_pl_1==num ){
				TopDiv.innerHTML = div[i].innerHTML;
				break;
			}
		}
	}
	
	//�ٴ�����TopDiv������
	var div_new = TopDiv.getElementsByTagName('div');
	for(j=0; j<div_new.length; j++){
		if(div_new[j].className =="p_p_img"){	//��Ҫͼ
			div_new[j].innerHTML = "";
			div_new[j].style.display = "none";
		}
		if(div_new[j].className=="p_p_1"){	//ȥ����ʽ
			div_new[j].className = "";
		}
		
	}
	//�滻��N������
	var h5 = TopDiv.getElementsByTagName('h5');
	var day_for_all = document.getElementById('day_for_all');
	var span_tag = h5[0].getElementsByTagName('span');
	for(n=0; n<span_tag.length; n++){
		if(span_tag[n].innerHTML.search(/<?php echo db_to_html('��.*��')?>/)>-1){
			span_tag[n].innerHTML = day_for_all.innerHTML +'&nbsp;';
		}
	}

}

//�����Ƶ��ƥ����г��ύ
function cearch_hotel(){
	var from = document.getElementById('hotel_cearch_form');
	if(from.elements['date_free_start'].value.search(/^\d{4}-\d{2}-\d{2}$/) == -1){
		alert('<?php echo db_to_html('��ѡ����ȷ����ס����')?>');
		return false;
	}
	if(from.elements['date_frees_end'].value.search(/^\d{4}-\d{2}-\d{2}$/) == -1){
		alert('<?php echo db_to_html('��ѡ����ȷ���������')?>');
		return false;
	}
	
	var Hotel_Cearch_Results = document.getElementById('hotel_cearch_results');
	Hotel_Cearch_Results.innerHTML = '<img alt="Please wait..." src="image/loading.gif" />';
	
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('ajax_free_tours.php','action=process')) ?>");
	var aparams=new Array();

	for(i=0; i<from.length; i++){
		var sparam=encodeURIComponent(from.elements[i].name);
		sparam+="=";
		if(from.elements[i].type=="radio"){
			var a = a;
			if(from.elements[i].checked){
				a = from.elements[i].value;
			}
			sparam+=encodeURIComponent(a); 
		}else{
			sparam+=encodeURIComponent(from.elements[i].value);
		}
		aparams.push(sparam);
	}
	var post_str = aparams.join("&");
	post_str += "&ajax=true";
	
	var cart_quantity = document.getElementById('cart_quantity');
	post_str += "&max_date="+ cart_quantity.elements['tours_day'].value;

	ajax.open("POST", url, true); 
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
	ajax.send(post_str);

	ajax.onreadystatechange = function() { 
		if (ajax.readyState == 4 && ajax.status == 200 ) { 
			//alert(ajax.responseText);
			Hotel_Cearch_Results.innerHTML = ajax.responseText;
			var SubMitToursDiv = document.getElementById('SubMitToursDiv');
			SubMitToursDiv.style.display = '';
			//�����ȫ��Ͽ��ڵ�ֵ
			//EmptySubMitTours();
		}
	}
}

//��ʾ������ƥ���г�
function show_hide_pipei_tours(id, show_or_hidden){
	if(show_or_hidden !="show" && show_or_hidden !="hidden"){
		if(document.getElementById(id).style.display=='none')
		{
			document.getElementById(id).style.display='';
		}else{
			document.getElementById(id).style.display='none'
		}
	}
	if(show_or_hidden =="show"){
		document.getElementById(id).style.display='';
	}
	if(show_or_hidden =="hidden"){
		document.getElementById(id).style.display='none';
	}
}

//���ŵĵ�ѡ��ťʱ�����ϼ��ľƵ�Ҳѡ��
function sel_hotel(hotel_id){
	var from = document.getElementById('hotel_cearch_form');
	if(hotel_id>0){
		var hotel_ids = document.getElementById('hotel_ids_'+hotel_id);
		hotel_ids.checked = true;
		
		for(i=0; i<from.length; i++){
			if(from[i].type=="radio" && from[i].checked==true){
				
				if(from[i].id.indexOf('hotel_ids_')>-1){
					var date_num_hid = from[i].value;
				}	
				if(from[i].id.indexOf('tours_ids_')>-1){
					var date_num_tid = from[i].value;
				}
				
			}
		}
		var v_date_num = Number(from.elements['durations_'+ date_num_hid+'_'+date_num_tid].value);
		
		//�ѵ�ǰ��id�ŵ����˿��Ա��´β�����ʾ��
		from.elements['filtration'].value += date_num_tid+',';
		
		//alert(v_date_num);
		if(v_date_num>0 && v_date_num!='NaN'){
			var hotel_id = date_num_hid;
			var tour_id = date_num_tid;
			FillTravel(v_date_num,hotel_id,tour_id);
		}
		write_coockie();
	}	
}

function write_coockie(){
	var free_combination_day = document.getElementById('free_combination_day');
	var cart_quantity = document.getElementById('cart_quantity');
	var cookie_val = free_combination_day.innerHTML;
	var post_str = ''; 
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('ajax_free_tours.php','action=write_cookie')) ?>");
	post_str += "&free_combination_day="+cookie_val;
	post_str += "&adult_total="+cart_quantity.elements['room-0-adult-total'].value;
	post_str += "&child_total="+cart_quantity.elements['room-0-child-total'].value;
	
	var free_num_div = free_combination_day.getElementsByTagName("div");
	var tours_day = 0;
	for(i=0; i<free_num_div.length; i++){
		if(free_num_div[i].id.search(/^free_[0-9]+$/)>-1){
			tours_day++;
		}
	}
	post_str += "&tours_day="+tours_day;
	post_str += "&ajax=true";
	
	ajax.open("POST", url, true); 
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
	ajax.send(post_str);

	ajax.onreadystatechange = function() { 
		if (ajax.readyState == 4 && ajax.status == 200 ) { 
			//alert(ajax.responseText);
		}
	}
}

//����Ƶ굥ѡ��ťʱ�����е��ŵ�����ťȡ��
function ClearTours(i_id){
	var from = document.getElementById('hotel_cearch_form');
	for(i=0; i<from.length; i++){
		if(from.elements[i].type=="radio" && from.elements[i].id.indexOf('tours_ids_') >-1 ){
			from.elements[i].checked = false;
		}
	}
	//�����޹ص���
	var Hotel_Cearch_Results = document.getElementById('hotel_cearch_results');
	var pipei_tours_tr = Hotel_Cearch_Results.getElementsByTagName("tr");
	for(j=0; j<pipei_tours_tr.length; j++){
		if(pipei_tours_tr[j].id.indexOf('pipei_tours_tr') >-1 ){
			pipei_tours_tr[j].style.display = 'none';
		}
	}
	show_hide_pipei_tours("pipei_tours_tr_"+i_id,'show');
}


//�����ɺ��ύ���
function SubMitToursFormFun(){
	var Form = document.getElementById('SubMitToursForm');
	var have_hotel_ids = false;
	for(i=0; i<Form.length; i++){
		if(Form[i].name=="hotel_ids[]"){
			have_hotel_ids = true;
		}
	}
	if(have_hotel_ids==false || Form.elements['hotel_ids[]'].value==""){
		alert('<?php echo db_to_html("��ѡ��Ƶ���г̣�");?>');
	}else{
		//alert('<?php echo db_to_html("�ύ�Ƶ�");?>');
		Form.action = "<?php echo preg_replace($p,$r,tep_href_link_noseo('free_buy_list.php','action=process')) ?>";
		Form.submit();
	}
}

//
function EmptySubMitTours(){
	var target_from = document.getElementById('SubMitToursForm');
	target_from.elements['adult_num'].value = '';
	target_from.elements['child_num'].value = '';
}
</script>

<DIV id="free_tours">
  <form action="" method="post" enctype="multipart/form-data" name="cart_quantity" id="cart_quantity" onSubmit="free_combination_day_html(); return false;">
  <input name="numberOfRooms" type="hidden" value="1">
  <div class="free_combination_step1">
    <div class="hawaii_hotel_search_title free_combination" style=" font-weight:normal; margin-top:10px; "><img src="image/free_tours_icon.gif"><br>
      <a><?php echo db_to_html('��ο�ʼ������?')?></a></div>
    <div class="hawaii_search_input hawaii_search_input2">
      <p><?php echo db_to_html('����')?></p>
      <?php
	  $day_array = array();
	  //$day_array [] = array('id'=>1,'text'=>db_to_html('1��'));
	  //$day_array [] = array('id'=>2,'text'=>db_to_html('2��'));
	  $day_array [] = array('id'=>3,'text'=>db_to_html('3��'));
	  $day_array [] = array('id'=>4,'text'=>db_to_html('4��'));
	  $day_array [] = array('id'=>5,'text'=>db_to_html('5��'));
	  $day_array [] = array('id'=>6,'text'=>db_to_html('6��'));
	  $day_array [] = array('id'=>7,'text'=>db_to_html('7��'));
	  $day_array [] = array('id'=>8,'text'=>db_to_html('8��'));
	  $day_array [] = array('id'=>9,'text'=>db_to_html('9��'));
	  $day_array [] = array('id'=>10,'text'=>db_to_html('10��'));
	  if(tep_not_null($_SESSION['hawaii_self']['tours_day'])){
	  	$tours_day = $_SESSION['hawaii_self']['tours_day'];
		if($tours_day>10 || (int)$tours_day==1 || (int)$tours_day==2){
	  		$day_array [] = array('id'=>(int)$tours_day,'text'=>(int)$tours_day.db_to_html('��'));
		}
	  }
	  echo tep_draw_pull_down_menu('tours_day',$day_array);
	  ?>
    </div>
    <div class="hawaii_search_input hawaii_search_input2">
      <p><?php echo db_to_html('����')?></p>
      <?php
	  $adult_array = array();
	  $adult_array [] = array('id'=>1,'text'=>db_to_html('1'));
	  $adult_array [] = array('id'=>2,'text'=>db_to_html('2'));
	  $adult_array [] = array('id'=>3,'text'=>db_to_html('3'));
	  if(tep_not_null($_SESSION['hawaii_self']['adult_total'])){
	  	$var_name = "room-0-adult-total";
		$$var_name = $adult_num = $_SESSION['hawaii_self']['adult_total'];
	  }
	  echo tep_draw_pull_down_menu('room-0-adult-total',$adult_array,'',' onChange="setNumAdults(0,this.options[this.selectedIndex].value)" ').db_to_html('��');
	  ?>
    </div>
    <div class="hawaii_search_input hawaii_search_input2">
      <p><?php echo db_to_html('��ͯ')?></p>
      <?php
	  $child_array = array();
	  $child_array [] = array('id'=>0,'text'=>db_to_html('0'));
	  $child_array [] = array('id'=>1,'text'=>db_to_html('1'));
	  if(tep_not_null($_SESSION['hawaii_self']['child_total'])){
	  	$var_name = "room-0-child-total";
		$$var_name = $child_num = $_SESSION['hawaii_self']['child_total'];
	  }
	  echo tep_draw_pull_down_menu('room-0-child-total',$child_array).db_to_html('��');
	  ?>
    </div>
    <div class="hawaii_search_input" style="padding:28px 0px 0px 15px;"><?php echo tep_image_submit('free_combination_button.gif', db_to_html('�ύ'),' style="border:0px; width:89px; height:20px;" ')?></div>
       <div class="free_combination_shadow"></div>
  </div>
  </form>
   
  <form action="<?php echo tep_href_link('free_buy_list.php','action=process');?>" method="post" name="SubMitToursForm" id="SubMitToursForm" onSubmit="SubMitToursFormFun(); return false;">
		<input name="adult_num" type="<?= 'hidden'?>" id="adult_num" value="<?= (int)$adult_num;?>">
		<input name="child_num" type="<?= 'hidden'?>" id="child_num" value="<?= (int)$child_num;?>">
		<input name="ajax" type="<?= 'hidden'?>" value="true">

  <div class="free_combination_day" id="free_combination_day">
  <?php
  $SubMitToursDiv_display = $free_combination_step2_display = 'none';
  if(tep_not_null($_SESSION['hawaii_self']['free_combination_day'])){
  	echo db_to_html($_SESSION['hawaii_self']['free_combination_day']);
	$SubMitToursDiv_display = $free_combination_step2_display = '';
  }
  ?>
  </div>
  
  <div id="tmp_box" style="display:"></div>
  
  </form>

  <div class="free_combination_step2" id="free_combination_step2" style="display:<?= $free_combination_step2_display?>">
  <p class="highline-txt" style="padding:5px 0px 15px 5px"><?php echo db_to_html('ע��ѡ����ס����Ƶ꣬ϵͳ�Զ�����Ϸ���Ӧ���г������հ׿�,ƥ����г̿��Բ�ѡ��')?></p>
  <h2 style="text-align:center; padding-bottom:15px"><?php echo db_to_html('ѡ���Ƶ꣬�г��Զ�ƥ��')?></h2>
 <form action="" method="post" enctype="multipart/form-data" name="hotel_cearch_form" id="hotel_cearch_form" onSubmit="cearch_hotel(); return false;"> 
  <div class="step2_hotel">
	   <table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><P>&nbsp;<?php echo db_to_html('��ס����')?>&nbsp;</P></td>
			<td>
			  <script type="text/javascript"><!--
				var DateFreeStart = new ctlSpiffyCalendarBox("DateFreeStart", "hotel_cearch_form", "date_free_start","btnDateFree1","",scBTNMODE_CUSTOMBLUE);
				DateFreeStart.writeControl(); DateFreeStart.dateFormat="yyyy-MM-dd";
			//--></script>
			</td>
		    <td style="padding-left:18px"><p><?php echo db_to_html('���ʱ��')?>&nbsp;</p></td>
		    <td>
			  <script type="text/javascript"><!--
				var DateFreeEnd = new ctlSpiffyCalendarBox("DateFreeEnd", "hotel_cearch_form", "date_frees_end","btnDateFree2","",scBTNMODE_CUSTOMBLUE);
				DateFreeEnd.writeControl(); DateFreeEnd.dateFormat="yyyy-MM-dd";
			//--></script>
			</td>
		    <td style="padding-left:18px"><p><?php echo db_to_html('�� ��')?>&nbsp;</p></td>
		    <td>
			  <?php
			  $hotel_price_array = array();
			  $hotel_price_array [] = array('id'=>'0','text'=>db_to_html('����'));
			  $hotel_price_array [] = array('id'=>'1,100','text'=>db_to_html('$100����'));
			  $hotel_price_array [] = array('id'=>'100,200','text'=>db_to_html('$100��$200'));
			  $hotel_price_array [] = array('id'=>'200,400','text'=>db_to_html('$200��$400'));
			  $hotel_price_array [] = array('id'=>'400,600','text'=>db_to_html('$400��$600'));
			  $hotel_price_array [] = array('id'=>'600,10000','text'=>db_to_html('$600����'));
			  echo tep_draw_pull_down_menu('hotel_price_range',$hotel_price_array);
			  ?>
			  &nbsp;
			</td>
		    <td>&nbsp;<input name="search_categories_id" type="<?= 'hidden'?>" value="<?php echo $cPathOnly?>"><input name="filtration" type="<?= 'hidden'?>" value=""><?php echo tep_image_submit('search_hotel_hawaii.gif', db_to_html('�����Ƶ�'),' style="border:0px; width:54px; height:20px;" ')?>&nbsp;</td>
		  </tr>
		</table>
  </div>
	
	<div id="hotel_cearch_results">
	</div>
	</form>	
  	

  
  </div>
  
</DIV>

	<div id="SubMitToursDiv" style="display:<?= $SubMitToursDiv_display?>">
		<?php echo tep_image_submit('combination_ok.gif', db_to_html('������'),' onClick="SubMitToursFormFun();" style="margin-left:260px; margin-top:20px; border:0px; width:89px; height:29px;" ')?>
	</div>


<div class="leftside">
  <div class="chanpin_xg6">
    <div class="left_rongqi margen_b  lvyou_sousuo">
	  <script type="text/javascript"><!--ExperienceSearchForm�ļ��
	  function ExperienceSearchFormCheck_Onfocus(obj){
	  	if(obj.value=="<?php echo db_to_html('���ν�������')?>"){
			obj.value="";
		}
	  }
	  function ExperienceSearchFormCheck_Onblur(obj){
	  	if(obj.value=="" || obj.value=="<?php echo db_to_html('���ν�������')?>"){
			obj.value="<?php echo db_to_html('���ν�������')?>";
		}
		alert(obj.value);
	  }
	  function ExperienceSearchFormSubmit_Check(){
		var ExperienceSearchForm = document.getElementById('ExperienceSearchForm');
		var error = false;
		var error_message = "";
		if(ExperienceSearchForm.elements['experience_keyword'].value=="" || ExperienceSearchForm.elements['experience_keyword'].value=="<?php echo db_to_html('���ν�������')?>"){
			error_message += '<?php echo db_to_html('�����������Ĺؼ���')?>'+"\n";
			error = 'true';
		}
		if(error == 'true'){
			alert(error_message);
			return false;
		}else{
			ExperienceSearchForm.submit();
			
		}
	  }
	  --></script>
	<form action="<?php echo tep_href_link('tours-experience.php')?>" method="get" name="ExperienceSearchForm" id="ExperienceSearchForm" onSubmit="ExperienceSearchFormSubmit_Check(); return false;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="4%">&nbsp;</td>
      <td width="70%" align="right">
	  <?php
	  if(!tep_not_null($experience_keyword)){
	  	$experience_keyword = db_to_html('���ν�������');
	  }
	  echo tep_draw_input_field('experience_keyword','','class="input_search4" size="25" onFocus="ExperienceSearchFormCheck_Onfocus(this)" onBlur="ExperienceSearchFormCheck_Onblur(this)" ')
	  ?>
	  
	  </td>
      <td width="7%">&nbsp;</td>
      <td width="19%"><?php echo tep_template_image_submit('button_search2.gif', db_to_html('����')); ?></td>
    </tr>
  </table>
  </form>
  </div>
    
<?php //���ν������?>	
<?php 
//ȡ�÷���
$categories_sql = tep_db_query('SELECT * FROM `tours_experience_categories` WHERE parent_id=0');
while($categories_rows=tep_db_fetch_array($categories_sql)){
?>
	<table width="98%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:2px #FF5A00 solid; float:left;">
      <tr>
        <td width="2%">&nbsp;</td>
      <td width="4%"><img src="image/changshi_liebiao.gif" /></td>
      <td width="2%">&nbsp;</td>
      <td width="63%"><h3><?php echo db_to_html($categories_rows['tours_experience_categories_name']) ?></h3></td>
	  <td width="20%"align="right">
	  <?php if($categories_rows['tours_experience_categories_id']=='1'){?>
	  <a href="<?php echo tep_href_link('tours-experience.php')?>" class="ff_a"><?php echo db_to_html('ȫ������')?></a>
	  <?php }else{ echo "&nbsp;";}?>
	  
	  </td>
      </tr>
  </table>
  <dl>
  <?php
  
  $categories_1_sql = tep_db_query('SELECT * FROM `tours_experience_categories` WHERE parent_id='.(int)$categories_rows['tours_experience_categories_id'] );
  while($categories_1_rows=tep_db_fetch_array($categories_1_sql)){
  	$class_a = 'cheng3';
  	if((int)$_GET['tours_experience_categories_id']==(int)$categories_1_rows['tours_experience_categories_id']){
		$class_a = 'cheng3 cu';
	}
  ?>
	  <dd><a href="<?php echo tep_href_link('tours-experience.php','tours_experience_categories_id='.(int)$categories_1_rows['tours_experience_categories_id'])?>" class="<?php echo $class_a ?>"><?php echo db_to_html($categories_1_rows['tours_experience_categories_name']) ?></a> </dd>
  <?php }?>
  </dl>
<?php }?>
<?php //���ν������end?>	

    
<?php //�������Ľ���?>    
  <table width="98%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:2px #FF5A00 solid; float:left;">
      <tr>
        <td width="2%">&nbsp;</td>
      <td width="4%"><img src="image/changshi_liebiao.gif" /></td>
      <td width="2%">&nbsp;</td>
      <td width="83%"><h3><?php echo db_to_html('�������Ľ���')?></h3></td>
      </tr>
  </table>
  <dl>
  	<?php
	$ding_sql = tep_db_query('SELECT tours_experience_id,tours_experience_title FROM `tours_experience` ORDER BY tours_ding DESC Limit 5 ');
	while($ding_rows = tep_db_fetch_array($ding_sql)){
	?>
	<dd><a href="<?php echo tep_href_link('tours-experience.php','tours_experience_id='.(int)$ding_rows['tours_experience_id']) ?>" title="<?php echo db_to_html(tep_db_output($ding_rows['tours_experience_title'])) ?>" class="cheng3"><?php echo cutword(db_to_html(tep_db_output($ding_rows['tours_experience_title'])),30)?></a> </dd>
	<?php }?>
  </dl>
<?php //�������Ľ���end?>    

<?php //���ű�ǩ
/*    
	<div class="hot_tag_jy"><h3>���ű�ǩ</h3> 
      <div class="hot_tg_jy_rongqi"><a href="#" class="cheng3">��������ĵط�</a> <a href="#" class="cheng3">������Ȫˮ</a> <a href="#" class="cheng3">��Ů��̲</a> <a href="#" class="cheng3">����</a>
  <a href="#" class="cheng3">�Ϳ˹���ֱ��</a> <a href="#" class="cheng3">������</a> <a href="#" class="cheng3">���˵�ipod</a></div></div>
*/
//���ű�ǩend?>    
  
  </div>
  
  <?php //��������
	$info_type_sql = tep_db_query('SELECT * FROM `usa_tours_info_type` WHERE  usa_tours_info_type_id=2 ');
	$info_type_row = tep_db_fetch_array($info_type_sql);
  	if((int)$info_type_row['usa_tours_info_type_id']){
		$info_sql = tep_db_query('SELECT * FROM `usa_tours_info` uti, `usa_tours_info_to_type` utt WHERE  uti.usa_tours_info_id=utt.usa_tours_info_id AND utt.usa_tours_info_type_id="'.(int)$info_type_row['usa_tours_info_type_id'].'" Group By utt.usa_tours_info_id limit 4 ');
  ?>
  <div class="fenlei3"><div class="biaoti">
    <h3><?php echo db_to_html('��������')?></h3> 
        <div class="more2">
                <a href="<?php echo tep_href_link('usa-tours-info.php','usa_tours_info_type_id='.(int)$info_type_row['usa_tours_info_type_id'])?>" class="ff_a2">+ <?php echo db_to_html('����')?></a>                </div>
		       </div>
    <div class="content4">
	      
      <div class="fenlei_left2"><div class="middle_img2"><a href="<?php echo tep_href_link('usa-tours-info.php','usa_tours_info_type_id='.(int)$info_type_row['usa_tours_info_type_id'])?>"><img src="image/wenhua.jpg" width="247" height="56" border="0" /></a></div>
        <div class="clear"></div>
      </div>
      <div class="fenlei_list3"> 
		<ul>
	 	<?php while($info_rows = tep_db_fetch_array($info_sql)){?>
	 	<li>- <a href="<?php echo tep_href_link('usa-tours-info.php','usa_tours_info_id='.(int)$info_rows['usa_tours_info_id'])?>" class="ff_a"><?php echo db_to_html(tep_db_output($info_rows['usa_tours_info_title']))?></a></li>
		<?php }?>
		</ul>
      </div>
      <div class="clear"></div>
    </div>
    <div class="clear"></div> 
   </div>
   <?php }?>
   <?php //��������end?>
   
</div>

<?php 
//����������������
?>  


<div id="right" class="rightside"> 

<?php if(!(int)$_GET['tours_experience_id']){?>
<?php //�������ν���Ŀ¼?>
<div class="left_bg2" ><h1><?php echo db_to_html('�������ν���')?><span class="bg3_right_title_r xiaozi" style="margin-top:-15px;"><a href="http://www.usitrip.com/resources/" class="chengse_font cu"><?php echo db_to_html('���ཨ��(Ӣ��)')?></a></span></h1>
      
	 <?php
	 do{
	 	//ȡ�ö�Ӧ�ı�ǩ
		$tag_sql = tep_db_query('SELECT * FROM `tours_experience_tags` tag, `tours_experience_to_tags` tot WHERE tag.tours_experience_tags_id=tot.tours_experience_tags_id AND tot.tours_experience_id='.(int)$experience_rows['tours_experience_id'].' Group BY tag.tours_experience_tags_id ');
		$exp_tags ='';
		while($tag_rows=tep_db_fetch_array($tag_sql)){
			$exp_tags .= db_to_html(tep_db_output($tag_rows['tours_experience_tags_name'])).' ';
		}
	 ?>
	  
	  <div class="jianyi_title_content "><div class="margen_b"><span class="jianyi_title"><?php echo cutword(db_to_html(tep_db_output($experience_rows['tours_experience_title'])),60)?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="huise"><?php echo tep_db_output($experience_rows['tours_experience_update_time'])?></span></div>
      <div class="left_rongqi2 jianyi_neirong">
      <p class="huise" style="font-size:12px;"><?php echo db_to_html('��ǩ��').$exp_tags;?> </p>
      <p class="jianyi_text"><?php echo cutword(db_to_html(strip_tags($experience_rows['tours_experience_content'])),200)?></p>
<div class="left_rongqi"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="16%" align="right" class="chengse_font"><span  class="cu" ><a href="<?php echo tep_href_link('tours-experience.php','tours_experience_id='.(int)$experience_rows['tours_experience_id']) ?>" class="cheng2"><?php echo db_to_html('�Ķ�ȫ��');?></a></span> | <span class="chengse_font"><?php echo (int)$experience_rows['tours_ding'].db_to_html('��');?></span></td>
    <td width="84%" align="left" ><img src="image/ding.gif" width="21" height="20" style="margin-left:2px; border:0px;" /></td>
  </tr>
</table>
</div></div> </div>
	 <?php }while($experience_rows = tep_db_fetch_array($experience_sql));?>


    <div class="jianyi_title_content page_link">
	   <?php
	   //��ʾ��ҳ��ť
	   echo db_to_html($page_split_display);	   
	   ?>
	</div>
      </div>   
<?php //�������ν���Ŀ¼end?>
<?php }elseif((int)$_GET['tours_experience_id']){?>
<?php
$tours_sql = tep_db_query('SELECT * FROM `tours_experience` WHERE tours_experience_id="'.(int)$_GET['tours_experience_id'].'" ');
$tours_row = tep_db_fetch_array($tours_sql);
if(!(int)$tours_row['tours_experience_id']){ tep_redirect(tep_href_link('index.php')); }



//ȡ�ñ�ǩ
$tag_sql = tep_db_query('SELECT * FROM `tours_experience_tags` tag, `tours_experience_to_tags` tot WHERE tag.tours_experience_tags_id=tot.tours_experience_tags_id AND tot.tours_experience_id='.(int)$tours_row['tours_experience_id'].' Group BY tag.tours_experience_tags_id ');
$exp_tags ='';
while($tag_rows=tep_db_fetch_array($tag_sql)){
	$exp_tags .= db_to_html(tep_db_output($tag_rows['tours_experience_tags_name'])).' | ';
}
$exp_tags = preg_replace('/\| $/','',$exp_tags);

?>
<?php //����?>
<?php
$p=array('/&amp;/','/&quot;/');
$r=array('&','"');
?>
<script type="text/javascript">
function ding_experience(id){
	var id = id;
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('tours_ding.php','tours_experience_id='))?>")+id;
	ajax.open('GET', url, true);  
	ajax.send(null);
	ajax.onreadystatechange = function() { 
		if (ajax.readyState == 4 && ajax.status == 200 ) { 
			document.getElementById('ding_shu_'+id).innerHTML = ajax.responseText;
			alert('<?php echo db_to_html('�٣��ɹ�����һ�£�')?>');
		}
	}
}
</script>

<div class="left_bg2" ><h1><?php echo db_to_html('�������ν���')?></h1>
      <h2><?php echo db_to_html(tep_db_output($tours_row['tours_experience_title']))?></h2>
      <div class="text_gjz"><span><?php echo db_to_html('���¹ؼ��֣�')?></span><?php echo $exp_tags?></div>
      <p>
	  <?php
	  //��ʾ������������������
	  $tours_experience_content = get_thesaurus_replace($tours_row['tours_experience_content'],$tours_row['thesaurus_ids'],1);
	  echo nl2br(db_to_html(($tours_experience_content)) );
	  ?>
	  </p>
	<div class="foot_tag_link"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="center" class="chengse_font"><table width="34%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="40%" height="28" align="center"><table width="50%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFDCAB" align="center">
			  <tr>
				<td height="25" align="center" bgcolor="#FFDCAB"><a href="JavaScript:ding_experience('<?php echo (int)$tours_row['tours_experience_id']?>')" ><img src="image/ding.gif" width="21" height="20" style="margin:0px; border:0px;" /></a></td>
				<td width="65%" align="center" bgcolor="#FFFFFF"><span id="ding_shu_<?php echo (int)$tours_row['tours_experience_id']?>" class="ding_shu"><?php echo (int)$tours_row['tours_ding']?></span></td>
			  </tr>
			  
			</table></td>
			<?php /*��ʱ����ʾ����ť
			<td width="6%">&nbsp;</td>
			<td width="26%" align="center" valign="middle">
			<div class="fenxiang"><a href="javascript:showDiv()" class="fenxiang_zi">����</a></div>
			</td>
			*/?>
			<?php /*��ʱ����ʾ�ղذ�ť
			<td width="6%">&nbsp;</td>
			<td width="27%" align="center" valign="middle">
			<div  class="fenxiang"><a href="#" class="fenxiang_zi">�ղ�</a></div>
			</td>
			*/?>
		  </tr>
		  
		</table>
		  </td>
		</tr>
	</table>
	</div>
</div>

<?php //����end?>
<?php }?>
   
</div>


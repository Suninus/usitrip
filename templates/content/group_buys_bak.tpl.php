<script type="text/javascript" src="includes/javascript/group_scroll.js"></script>
<script type="text/javascript" src="includes/javascript/pop.js"></script>

<?php ob_start();?>
<?php
$numTclass = 'num numOn';
$timeTclass = 'time';
if($_GET['gb_type']=="2"){
	$numTclass = 'num';
	$timeTclass = 'time timeOn';
}
?>
<div class="group">
            <div class="groupTab">
                <span id="GroupTabNum" class="<?= $numTclass?>">������</span>
                <span id="GroupTabTime" class="<?= $timeTclass?>">��ʱ��</span>
            </div>
			<script type="text/javascript">
                jQuery("#GroupTabNum").click(function(){
                        jQuery(this).addClass("numOn");
                        jQuery("#GroupTabTime").removeClass("timeOn");
                        jQuery("#GroupNum").show();
                        jQuery("#GroupTime").hide();
                });
                jQuery("#GroupTabTime").click(function(){
                        jQuery(this).addClass("timeOn");
                        jQuery("#GroupTabNum").removeClass("numOn");
                        jQuery("#GroupTime").show();
                        jQuery("#GroupNum").hide();
                });
            </script>
			
			<div class="groupLeft">


<?php // ������{?>			
			<div id="GroupNum"  class="groupNum">
<?php
$datas = $datas0;
$datas_count = sizeof($datas0);
$loop = 0;
for($i=0; $i<$datas_count; $i++){
	$loop++;
	if($datas[$i]['specials_type']!=1){ break; } /* ������ǵ��������뿪�������� */
	if(isset($datas[$i]['balanceNum']) && $datas[$i]['balanceNum']==0){	//��������Ѿ�û�˾Ͳ���ʾ�����ˡ�
		continue;
	}
	
	if($datas[$i]['specials_type']==1){	//2Ϊ��ʱ�š�1Ϊ������
		$con_class = "con conNum";
		$start_days_class = "";
		if($loop==1) $con_class = "con conNum conIndex";
	}elseif($datas[$i]['specials_type']==2){
		$con_class = "con";
		$start_days_class = "";
		if($loop==1) $con_class = "con conIndex";
	}
	
	$pic_ids = 'Scroll_'.$datas[$i]['products_id'];	//ͼƬ��ID
	$products_info_links = tep_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$datas[$i]['products_id']);
	
?>                
				<div id="ProductsObj_<?=$datas[$i]['products_id']?>" class="<?= $con_class?>">
                    <div id="ProductsTitle_<?=$datas[$i]['products_id']?>" class="top">
                        <h2><a href="<?= $products_info_links?>"><?= $datas[$i]['products_name'];?></a></h2>
                        <h3><?= $datas[$i]['products_name1'];?></h3>
                    </div>
                    
                    <div class="info">
                        <h4>�г̽��ܣ�</h4>
                        <p><?= $datas[$i]['products_small_description'];?></p>
                    </div>
                    
					<div class="main">
                    <div class="mainLeft">
						<div class="priceTag">
							<div class="priceTagCon">
								<?= $datas[$i]['priceTag'];?>                            
								<a href="<?= $products_info_links?>" class="buyBtn">������</a>
							</div>
                        </div>
                        
                        <div class="priceDetail">
                            <div class="priceTop">
                                <div class="col1">�г���</div><div class="col2">�ۿ�</div><div class="col3">��ʡ</div>
                            </div>
                            <div class="priceCon">
                                <div id="oldPrice_<?= $datas[$i]['products_id']?>" class="col1"><?= $datas[$i]['oldPrice']?></div><div id="Discount_<?= $datas[$i]['products_id']?>" class="col2"><?= $datas[$i]['Discount']?></div><div id="Save_<?= $datas[$i]['products_id']?>" class="col3"><?= $datas[$i]['Save']?></div>
                            </div>
                        </div>
                        
						<div class="countdown startTime">
                            <h3>����ʱ��:</h3>
                            <p><?= str_replace(array(' ',"\n",'<br>','<br />',"\t"),'',$datas[$i]['display_start_days'])?></p>
                        </div>
						
                        <div class="countdown">
                            <h3>���뱾���Ź���������:</h3>
                            <p id="CountDown<?= $datas[$i]['products_id']?>"></p>
							<?php //�����JS���벻�����ƶ��������ط��������ʱƫ��̫��?>
							<script type="text/javascript">
							GruopBuyCountdown(<?= $datas[$i]['products_id']?>, <?= $datas[$i]['CountdownEndTime']?>,'CountDown<?= $datas[$i]['products_id']?>','ProductsObj_<?=$datas[$i]['products_id']?>');
							</script>
                        </div>
                        
                        <div class="countdown orderNum">
                            <h3>�������ޣ�����������</h3>
							<p><?= $datas[$i]['orderNumInfo']?></p>
                        </div>
                        
                        <div class="invite">
                            <p>
							<?php
							if(tep_not_null($datas[$i]['invite_info'])){
								echo $datas[$i]['invite_info'];
							}else{?>
								���Ŷ���<?= trim($datas[$i]['display_start_days'])?>���ţ������г̣������Żݼۣ��������ޣ����꼴ֹ�����ķ���ǿ���Ƽ���
							<?php
							}
							?>
							�µ�ǰ����ϸ�Ķ�<a href="<?= tep_href_link('group_buys.php','do=note');?>" target="_blank">�Ź���֪</a></p>
                            <a href="javascript:;" onclick="showPopEmail(<?= $datas[$i]['products_id']?>)" class="inviteBtn">��������Ҳ������</a>
                            <p class="inviteTip">�ɹ���������ǰ�����ţ���������1000���ֽ�����</p>
                        </div>
                        
                        
                    </div><div class="mainRight">
                        <div class="slider">
                            <div id="<?= $pic_ids?>" class="scroll">
                                <div class="preBtn"></div>
                                <ul>
								<?php for($j=0; $j<sizeof($datas[$i]['products_pics_src']); $j++){ //��ƷͼƬ?>
                                    <li><a href="<?= $products_info_links?>"><img src="<?= $datas[$i]['products_pics_src'][$j]?>" /></a></li>
								<?php }?>	
                                </ul>
                                <div class="nextBtn"></div>
                            </div>
                        </div>
                        
                        <div class="basicInfo">
                            <ul>
                                <li><label>��Ʒ��ţ�</label><?= $datas[$i]['products_model']?></li>
                                <li><label>�����ص㣺</label><?= trim($datas[$i]['display_str_departure_city'])?></li>
                                <li><label>����ʱ�䣺</label><?= trim($datas[$i]['display_products_durations'])?></li>
                                <li><label>�����ص㣺</label><?= trim($datas[$i]['display_str_end_city'])?></li>
                                <li><label>����ʱ�䣺</label><?= str_replace(array(' ',"\n",'<br>','<br />',"\t"),'',$datas[$i]['display_start_days'])?></li>
                                <li><label>������Ϣ��</label><?= strip_tags($datas[$i]['products_points_info'])?></li>
                            </ul>
                        </div>
                        
                    <?php if((int)sizeof($datas[$i]['reviews'])){ //��һ������?>    
						<div class="des"><?= $datas[$i]['reviews']['reviews_text']?><span>��</span></div>
                        <div class="comment">
                            <span><label>���� </label><?= $datas[$i]['reviews']['booking_ratings'][0];?></span>
                            <span><label>���� </label><?= $datas[$i]['reviews']['travel_ratings'][0];?></span>
                            <div class="signature"><?= $datas[$i]['reviews']['modified_date']?><a href="<?= tep_href_link('individual_space.php','customers_id='.$datas[$i]['reviews']['customers_id']);?>"><?= $datas[$i]['reviews']['customers_name']?></a></div>
                        </div>
					<?php }?>
						
                    </div>
                    </div>
<script type="text/javascript">

    jQuery("#<?= $pic_ids?>").Scroll({
        scroll           : "#<?= $pic_ids?>",
        nextBtn          : "#<?= $pic_ids?> .nextBtn",
        preBtn           : "#<?= $pic_ids?> .preBtn",
        scrollCon        : "#<?= $pic_ids?>>ul",
        scrollConLi      : "#<?= $pic_ids?>>ul>li"
    });


</script>
     
                </div>
			
				<?php	//Ĭ�ϵ��ʼ�����{?>
				<div style="display:none">
					<div id="emailTitle_<?= $datas[$i]['products_id']?>"><?= $datas[$i]['emailTitle']?></div>
					<div id="emailContent_<?= $datas[$i]['products_id']?>"><?= $datas[$i]['emailContent']?></div>
				</div>
				<?php //Ĭ�ϵ��ʼ�����}?>
<?php
}

//�޲�Ʒ������{
if($datas_count<1){
?>

	<div class="groupNull"><img src="image/<?= $noGroups['group_null_image'];?>" /></div>
	<div class="groupNullHistory">
		<h2>���ڳɹ��Ź�</h2>
		<ul>
			<?php
			foreach((array)$noGroups['expired_products'] as $expireds){
			?>
			<li><a href="<?= $expireds['link']?>" target="<?= $expireds['link_target']?>"><?= $expireds['name']?></a></li>
			<?php
			}
			?>
		</ul>
	</div>

<?php
}
//�޲�Ʒ������}
?>
			
			<?php if($group_split0->number_of_pages > 1) {?>
				<div class="pageWrap">
					<div class="page">
					<?php echo TEXT_RESULT_PAGE . ' ' . html_to_db($group_split0->display_links_2011(5, 'gb_type=1&'.tep_get_all_get_params(array('page', 'info', 'gb_type'))));?>
					</div>
				</div>
			<?php }?>
                
            </div>
<?php // ������}?>

<?php // ��ʱ��{?>
			<div id="GroupTime" class="groupTime" >
<?php
$datas = $datas1;
$datas_count = sizeof($datas1);
$loop = 0;
for($ii=0; $ii<$datas_count; $ii++){
	$loop++;
	if($datas[$ii]['specials_type']!=2){ break; }
	if(isset($datas[$ii]['balanceNum']) && $datas[$ii]['balanceNum']==0){	//��������Ѿ�û�˾Ͳ���ʾ�����ˡ�
		continue;
	}
	
	if($datas[$ii]['specials_type']==1){	//2Ϊ��ʱ�š�1Ϊ������
		$con_class = "con conNum";
		$start_days_class = "";
		if($loop==1) $con_class = "con conNum conIndex";
	}elseif($datas[$ii]['specials_type']==2){
		$con_class = "con";
		$start_days_class = "";
		if($loop==1) $con_class = "con conIndex";
	}
	
	$pic_ids = 'Scroll_'.$datas[$ii]['products_id'];	//ͼƬ��ID
	$products_info_links = tep_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$datas[$ii]['products_id']);
	
?>                
				<div id="ProductsObj_<?=$datas[$ii]['products_id']?>" class="<?= $con_class?>">
                    <div id="ProductsTitle_<?=$datas[$ii]['products_id']?>" class="top">
                        <h2><a href="<?= $products_info_links?>"><?= $datas[$ii]['products_name'];?></a></h2>
                        <h3><?= $datas[$ii]['products_name1'];?></h3>
                    </div>
                    
                    <div class="info">
                        <h4>�г̽��ܣ�</h4>
                        <p><?= $datas[$ii]['products_small_description'];?></p>
                    </div>
                    
					<div class="main">
                    <div class="mainLeft">
						<div class="priceTag">
							<div class="priceTagCon">
								<?= $datas[$ii]['priceTag'];?>                            
								<a href="<?= $products_info_links?>" class="buyBtn">������</a>
							</div>
                        </div>
                        
                        <div class="priceDetail">
                            <div class="priceTop">
                                <div class="col1">�г���</div><div class="col2">�ۿ�</div><div class="col3">��ʡ</div>
                            </div>
                            <div class="priceCon">
                                <div id="oldPrice_<?= $datas[$ii]['products_id']?>" class="col1"><?= $datas[$ii]['oldPrice']?></div><div id="Discount_<?= $datas[$ii]['products_id']?>" class="col2"><?= $datas[$ii]['Discount']?></div><div id="Save_<?= $datas[$ii]['products_id']?>" class="col3"><?= $datas[$ii]['Save']?></div>
                            </div>
                        </div>
                        
                        <div class="countdown">
                            <h3>���뱾���Ź���������:</h3>
                            <p id="CountDown<?= $datas[$ii]['products_id']?>"></p>
							<?php //�����JS���벻�����ƶ��������ط��������ʱƫ��̫��?>
							<script type="text/javascript">
							GruopBuyCountdown(<?= $datas[$ii]['products_id']?>, <?= $datas[$ii]['CountdownEndTime']?>,'CountDown<?= $datas[$ii]['products_id']?>','ProductsObj_<?=$datas[$ii]['products_id']?>');
							</script>
							
                        </div>
                        
                        <div class="countdown orderNum">
                            <h3>�Żݶ�࣬����������</h3>
							<p><?= $datas[$ii]['orderNumInfo']?></p>
                        </div>
                        
                        <div class="invite">
                            <p>
							<?php
							if(tep_not_null($datas[$ii]['invite_info'])){
								echo $datas[$ii]['invite_info'];
							}else{?>
								���Ŷ���<?= trim($datas[$ii]['display_start_days'])?>���ţ������г̣������Żݼۣ�������Ч�ڣ��ؼ۹�����ʱ���Σ����ķ���ǿ���Ƽ���
							<?php
							}
							?>
							�µ�ǰ����ϸ�Ķ�<a href="<?= tep_href_link('group_buys.php','do=note');?>" target="_blank">�Ź���֪</a></p>
                            <a href="javascript:;" onclick="showPopEmail(<?= $datas[$ii]['products_id']?>)" class="inviteBtn">��������Ҳ������</a>
                            <p class="inviteTip">�ɹ���������ǰ�����ţ���������1000���ֽ�����</p>
                        </div>
                        
                        
                    </div><div class="mainRight">
                        <div class="slider">
                            <div id="<?= $pic_ids?>" class="scroll">
                                <div class="preBtn"></div>
                                <ul>
								<?php for($j=0; $j<sizeof($datas[$ii]['products_pics_src']); $j++){ //��ƷͼƬ?>
                                    <li><a href="<?= $products_info_links?>"><img src="<?= $datas[$ii]['products_pics_src'][$j]?>" /></a></li>
								<?php }?>	
                                </ul>
                                <div class="nextBtn"></div>
                            </div>
                        </div>
                        
                        <div class="basicInfo">
                            <ul>
                                <li><label>��Ʒ��ţ�</label><?= $datas[$ii]['products_model']?></li>
                                <li><label>�����ص㣺</label><?= trim($datas[$ii]['display_str_departure_city'])?></li>
                                <li><label>����ʱ�䣺</label><?= trim($datas[$ii]['display_products_durations'])?></li>
                                <li><label>�����ص㣺</label><?= trim($datas[$ii]['display_str_end_city'])?></li>
                                <li><label>����ʱ�䣺</label>��ֹ��<?= $datas[$ii]['last_departure_date']?></li>
                                <li><label>������Ϣ��</label><?= strip_tags($datas[$ii]['products_points_info'])?></li>
                            </ul>
                        </div>
                        
                    <?php if((int)sizeof($datas[$ii]['reviews'])){ //��һ������?>    
						<div class="des"><?= $datas[$ii]['reviews']['reviews_text']?><span>��</span></div>
                        <div class="comment">
                            <span><label>���� </label><?= $datas[$ii]['reviews']['booking_ratings'][0];?></span>
                            <span><label>���� </label><?= $datas[$ii]['reviews']['travel_ratings'][0];?></span>
                            <div class="signature"><?= $datas[$ii]['reviews']['modified_date']?><a href="<?= tep_href_link('individual_space.php','customers_id='.$datas[$ii]['reviews']['customers_id']);?>"><?= $datas[$ii]['reviews']['customers_name']?></a></div>
                        </div>
					<?php }?>
						
                    </div>
                    </div>
<script type="text/javascript">

    jQuery("#<?= $pic_ids?>").Scroll({
        scroll           : "#<?= $pic_ids?>",
        nextBtn          : "#<?= $pic_ids?> .nextBtn",
        preBtn           : "#<?= $pic_ids?> .preBtn",
        scrollCon        : "#<?= $pic_ids?>>ul",
        scrollConLi      : "#<?= $pic_ids?>>ul>li"
    });


</script>
     
                </div>
				<?php	//Ĭ�ϵ��ʼ�����{?>
				<div style="display:none">
					<div id="emailTitle_<?= $datas[$ii]['products_id']?>"><?= $datas[$ii]['emailTitle']?></div>
					<div id="emailContent_<?= $datas[$ii]['products_id']?>"><?= $datas[$ii]['emailContent']?></div>
				</div>
				<?php //Ĭ�ϵ��ʼ�����}?>
<?php
}

//�޲�Ʒ��ʱ��{
if($datas_count<1){
?>

	<div class="groupNull"><img src="image/<?= $noGroups['group_null_image'];?>" /></div>
	<div class="groupNullHistory">
		<h2>���ڳɹ��Ź�</h2>
		<ul>
			<?php
			foreach((array)$noGroups['expired_products'] as $expireds){
			?>
			<li><a href="<?= $expireds['link']?>" target="<?= $expireds['link_target']?>"><?= $expireds['name']?></a></li>
			<?php
			}
			?>
		</ul>
	</div>

<?php
}
//�޲�Ʒ��ʱ��}
?>
			<?php if($group_split1->number_of_pages > 1) {?>
				<div class="pageWrap">
					<div class="page">
					<?php echo TEXT_RESULT_PAGE . ' ' . html_to_db($group_split1->display_links_2011(5, 'gb_type=2&'.tep_get_all_get_params(array('page', 'info', 'gb_type'))));?>
					</div>
				</div>
			<?php }?>

			</div>
<?php // ��ʱ��}?>
			
			</div><div class="groupRight">
                <div class="title titleSmall">
                    <b></b><span></span>
                    <h3>�����Ź�</h3>
                </div>
                
                <div class="con">
                    <h4 class="yellow">������</h4>
                    <p>����Ϊ��ɫ���ż�Ϊ�������š����Ѿ�Ϊ�����ź��˳���ʱ�䣬��ʱ���ǽ�׼ʱ���ţ�����ȷ�ϳ���ʱ���Ƿ�������г̰��������</p>
                    
                    <h4 class="blue">��ʱ��</h4>
                    <p>����Ϊ��ɫ���ż�Ϊ����ʱ�š���û�й̶��ĳ���ʱ�䡣������ѡ������Ч����������Ч�����ճ��С�</p>
                    
                    <h4>�Ź���֪</h4>
                    <p>���ķ���������ѡ�����г̣�������ѡ���ڳ��ŵ������ţ�Ҳ����ѡ���޶�ʱ������Ч����ʱ�ţ��ͼ۲�������ʣ����ķ���һ������Ĵ���������������ֵ������г̡�</p>
                    
                    <h4>�Ź�����</h4>
                    <p>1.���͵ͼ�<br/>2.����Ʒ��<br/>
                    </p>
                    
                </div>
                
          
            </div>
            
            
        </div>


<?php // ��������Ҳ�����ŵ����� start { ?>
<div class="pop" id="GroupBuyRecommendEmail">
<form method="post" enctype="multipart/form-data" id="formGroupBuyRecommendEmail" onSubmit="return false;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="popTable">
    <tr>
      <td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td>
        <td class="con">
          <div class="popCon" id="GroupBuyRecommendEmailCon" style="width:510px;" >

            <div class="popTitle" id="drag">
                <div class="popTitleCon"><b>��������Ҳ������</b></div>
                <div class="popClose" id="GroupBuyRecommendEmailClose"></div>
            </div>
            <ul id="emailCon" class="emailCon">
                <?php if(!(int)$customer_id){?>
				<li><label>�����˺�:</label><?= tep_draw_input_field('FromAddress',$customer_email_address,'style="ime-mode: disabled;" class="required validate-email text" title="�������������ķ������˺ţ��������䣩���ɹ���������ǰ�����ţ���������1000���ֽ�����" ')?></li>
				<?php }?>
				<li><label>�ռ�������:</label><input name="to_email_address" type="text" class="required validate-email text" onblur="if(this.value==''){this.value='����������á�,��������';this.style.color='#777';}" onfocus="if(this.value=='����������á�,��������'){this.value='';this.style.color='#333';}" value="����������á�,��������" style="ime-mode: disabled; color:#777;" /></li>
				
                <li><label>�ʼ�����:</label><?= tep_draw_input_field('mail_subject','','class="required text" title="�������ʼ�����" ')?></li>
                <li><label>�ʼ�����:</label><?= tep_draw_textarea_field('mail_text','','','','',' class="textarea" title="�������ʼ�����" ')?></li>
				<input name="prod_id" type="hidden" />
				<input name="ProdName" type="hidden" />
				
            </ul>
            <div id="emailBtnCenter" class="btnCenter">
                <a href="javascript:;" class="btn btnOrange"><button type="submit">�� ��</button></a>
            </div>
			<div id="emailConSuccess" class="emailConSuccess" style="display:none">
			�ʼ����ͳɹ���<b id="emailConSuccessTime"></b> ���رմ˴��ڣ�
			</div>
	     </div>
 </td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
  </table>
</form>
</div>

<script type="text/javascript">
function showPopEmail(prod_id){
    var popEmails = new Pop('GroupBuyRecommendEmail','GroupBuyRecommendEmailCon','GroupBuyRecommendEmailClose',{dragId:"drag"});
	var formObj = document.getElementById('formGroupBuyRecommendEmail');
	formObj.elements['mail_subject'].value = jQuery("#emailTitle_"+prod_id).text() +' - ���ķ���';
	formObj.elements['mail_text'].value = jQuery("#emailContent_"+prod_id).text() +"\n";
	formObj.elements['prod_id'].value = prod_id;
	formObj.elements['ProdName'].value = jQuery("#ProductsTitle_"+prod_id).find("h2").text() + jQuery("#ProductsTitle_"+prod_id).find("h3").text();
	
}

var ShareEmailFormValid = new Validation('formGroupBuyRecommendEmail', {immediate : true,useTitles:true, onFormValidate : formGroupBuyRecommendEmailCallback});

function formGroupBuyRecommendEmailCallback(result, form) {
	window.status = "valiation callback for form '" + form.id + "': result = " + result;
	if(result==true){
		//���͵����ʼ�������
		var url = url_ssl("group_buys.php?action=SendGroupBuyRecommendEmailToFriend");
		ajax_post_submit(url,form.id);
	}
	return false;
}

function SendEmaiSuccessAction(){
	Num = 6;
	TimeObj = document.getElementById('emailConSuccessTime');
	if(TimeObj==null){
		alert("No id=emailConSuccessTime"); return false; 
	}else if(TimeObj!=null && TimeObj.innerHTML!=""){
		Num = TimeObj.innerHTML;
	}
	
	if(Num <= 1 ){
		jQuery("#emailCon").show();
		jQuery("#emailBtnCenter").show();
		jQuery("#emailConSuccess").hide();
		jQuery("#GroupBuyRecommendEmailClose").click();
		
		TimeObj.innerHTML = 6;
	}else{
		TimeObj.innerHTML = (Num-1);
		window.setTimeout("SendEmaiSuccessAction()",1000);
	}
}

<?php if($_GET['gb_type']==2){	//����Ҫ���������Tab?>
jQuery("#GroupNum").hide();
<?php }else{?>
jQuery("#GroupTime").hide();
<?php }?>

</script>
<?php // ��������Ҳ�����ŵ����� end } ?>

<?php //echo preg_replace('/[[:space:]]+/',' ',db_to_html(ob_get_clean()));?>
<?php echo db_to_html(ob_get_clean());?>
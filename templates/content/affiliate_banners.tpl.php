<?php ob_start();?>
<script type="text/javascript" src="includes/javascript/hash.history.min.js"></script>
<div id="userTitle" class="userTitle">
<ul>
<li id="promocode_tag" onclick="setTab('promocode');">�Ż���</li>
<li id="imagetext_tag" onclick="setTab('imagetext');">ͼ�Ĺ��</li>
<li id="search_tag" onclick="setTab('search');">������Ƕ��</li>
<li id="custom_tag" onclick="setTab('custom');">�Զ�������</li>
</ul>
</div>

<form action="" method="post" enctype="multipart/form-data" name="formBanners" id="formBanners">
<div id="panelCon" class="mainbox">

<div class="promo_box">
<ol class="promo_step">
	<li>ѡ�����ú��ʵĴ�����ַ�ʽ���"��ȡ����"��ȡ���롣</li>
	<li>����ȡ�Ĵ���ճ����������վ��չʾ�������û���</li>
	<li class="nomargr">�û���������վ�ϵ��ƹ������������ķ�����������Ӷ������Ի�ȡӶ��</li>
</ol>

<?php //�Ż���{?>
		<div panel="yes" id="promocode_panel">
        	<div class="get_code_panel">
                <div class="promo_header">
                    <h2>Coupon Code(�Ż���)</h2>
                    <h3>&mdash;&mdash;����˫Ӯ!�����ۿ�����Ӷ��!</h3>
                </div>
                <div class="promo_msg">
                    <i class="icons"></i>
                    ͨ��Coupon Code����������׬ȡ3%Ӷ���ͬʱ����������Ҳ�����ܵ�2%���ۿ��Ż�Ŷ������˫Ӯ���ƹ㷽�������ݡ��ϲ�������ĵ�����ģʽ��
                </div>
                <div class="promo_user_code">
                    <p>����Coupon Code(�Ż���)��<input readonly="readonly" id="CouponCode" class="code" value="<?= $my_coupon_code;?>"><a href="javascript:void(0);" onclick="_copyClipboard('CouponCode')">[��������Ż���]</a></p>
                </div>
                <div style="color:#ff9600;">&nbsp;&nbsp;&nbsp;&nbsp;ѡ���Ż��롱�ƹ���ܻ����Ӷ��Ϊ�������������ͻ��Ķ������С��ƹ�������Ϣ��ʹ���ˡ��Ż��롱��ϵͳ��ֻ�ԡ��ƹ�������Ϣ�ṩ�߷���Ӷ�𣬲��ԡ��Ż��롱�ṩ�߷���Ӷ��Ϊ��֤����������棬������ѡ���ƹ����������ƹ㡣���ڡ��ƹ������͡��Ż��롱����ͬʱ��Ӷ����ϸ˵������<a href="<?php echo tep_href_link('affiliate_faq.php')?>#list14"><?php  echo tep_href_link('affiliate_faq.php')?>#list14</a>
                </div>
                <div class="promo_cnt">
                    <p>ÿ�����Ƕ���Ϊ��ǧ��Ա�����Ͽͻ�������Ϊ���ĵ�ʵ����</p>
                    <p>����ʱ��ؿ�ͨ���绰���ʼ������ŵ����ⷽʽ�������ļ��˼������Ƽ����ķ�����������������Coupon Code(�Ż���)�������ǡ������ļ��˼����ѹ������ǵ����β�Ʒʱ�����Coupon Code(�Ż���)���������Ѽ����̻��2%�Ż��ۿۣ�ͬʱ��ͨ����Coupon Code(�Ż���)������3%��Ӷ�����¼�������ʻ��</p><br>
                    <p>���Խ�ߣ��ۿ�Խ���ˣ��ƹ�Խ�࣬Ӷ��Խ���</p><br>
                    <p>����ʲô���Ͽ��Ƽ���Ϊ�������Ѵ�ȥʵ�ݣ� Ҳ���Լ��ջ�һ�ݾ�ϲ�ɣ�</p>
                </div>
			</div>
            <div class="ui_notice_msg">
                <p><strong>������Ҫע�����¼���Coupon Code(�Ż���) �Ĺ���</strong></p>
                <p>1.�������С��<strong>700</strong>������ʹ���Ż���(Coupon Code)���д��ۡ�</p>
                <p>2.����Coupon Code(�Ż���)�����������Լ��Ķ����</p>
                <p>3.ʹ����Coupon Code(�Ż���)�����������ͻ��֡�</p>
                <p>4.��վ��Ա�����õ�Coupon Code(�Ż���)����վ����Ȼ��Ч��</p>
            </div>
        </div> 
<?php
//�Ż���}
//ͼ�Ĺ��{
?>

<div panel="yes" id="imagetext_panel">



<?= tep_draw_hidden_field('rProductsId','','id="rProductsId"');?>
<?= tep_draw_hidden_field('rCatId','','id="rCatId"');?>

<div class="get_code_panel">
<h2>ѡ���ƹ�Ŀ��</h2>

<div class="adLinks">
    
	<?php /* ��ȡ���˵��г�ѡ����?>
	<h2>ѡ��Ҫ�Ƽ����г�<a id="ChooseRoute1" class="blue" href="javascript:showPopup('popupRoute','popupConRoute','fixedTop','off','ChooseRoute1');">ѡ���г�</a></h2>
    <div class="createCode">
        <div id="routeTitleProducts" class="routeTitle"><!--���Ƽ��Ĳ�Ʒ����Box-->&nbsp;</div>
    </div>
	<?php */ ?>
	
	<div class="createCode">
	<ul class="af_textpic">
	<li>
	<label class="textpic_label">ѡ������Ŀ��ҳ��</label>
	<select name="tips" class="select_links_page" id="tips" onchange="tips_fun(this)">
		<option value="selIndex">��ҳ</option>
		<option value="selTheme">����</option>
		<option value="selCategories">����</option>
		<option value="selProducts" <?php if((int)$rProductsId){?> selected="selected" <?php }?>>��·�г�</option>
	</select>	
	</li>
	<li>
	<label class="textpic_label">ѡ��������ʽ��</label> 
	<label><input name="links_type" id="links_type_0" type="radio" value="imageTextAdPr" onclick="links_type_fun(this)" checked="checked" /> ͼƬ+����</label>
	<label><input name="links_type" type="radio" value="imageAdPr" onclick="links_type_fun(this)" /> ͼƬ</label>
	<label><input name="links_type" type="radio" value="textAdPr" onclick="links_type_fun(this)" /> ��������</label>
	</li>
	<li id="image_size_li">
	<label class="textpic_label">ѡ�������С��</label>
	<label><input name="image_size" type="radio" value="760-90" checked="checked" onclick="clear_view();" /> 760*90</label>
	<label><input name="image_size" type="radio" value="468-60" onclick="clear_view();" /> 468*60</label>
	<label><input name="image_size" type="radio" value="120-600" onclick="clear_view();" /> 120*600</label>
	<label><input name="image_size" type="radio" value="300-300" onclick="clear_view();" /> 300*300</label>
	<a href="<?= HTTP_SERVER.'/download/ad_diy.2012.zip';?>">DIY�ز�����</a>
	</li>
	<li id="selProducts" parent="tips" tips="��·�г�">
	<h2>��д�����źţ�
	<?= tep_draw_input_num_en_field('products_model','','id="pModel" class="get_pro"');?>
	<span class="line_help" id="getHelp">����ҵ������ź�?
		<div class="help_tooltip" id="helpPanel">
			<i class="icons"></i>
			<div class="help_panel_title">
				<p>ͨ��������ֱ�ӽ����Ʒ����ҳ�󣬿��ڻ�����Ϣ���в鵽<strong>�������źš�</strong>�����£�</p>
			</div>
			<img src="/image/affiliate/help_tuan_nub.jpg" width="287" height="99" align="�����ź�" />
		</div>
	</span>
    <a href="<?= tep_href_link('advanced_search_result.php');?>" class="choose_linexc" target="_blank">ȥ��ѡ��·&gt;&gt;</a>
	</h2>
	
	<script type="text/javascript">
	window.onload = function(){
		function getId(id){
			return document.getElementById(id);
		}
		var getHelp = getId("getHelp");
		var helpPanel = getId("helpPanel");
		getHelp.onmousemove = function(){
			helpPanel.style.display = "block";
		}
		getHelp.onmouseout = function(){
			helpPanel.style.display = "none";
		}
	}
	</script>

	<div class="submit">
	<a href="javascript:;" class="btn btnOrange"><button id="createCodeButtonP" type="button" onclick="createCode('Products')">���ɴ���</button></a>
	</div>
	</li>
	<li id="selCategories" parent="tips" tips="����">
		<h2>��������Ĺ�����ӣ�<a id="ChooseSort" class="blue" href="javascript:showPopup('popupSort','popupConSort','fixedTop','off','ChooseSort');">ѡ�񾰵�</a></h2>
		<div id="routeTitleCat" class="routeTitle" onclick="showPopup('popupSort','popupConSort','fixedTop','off','ChooseSort');"><!--���Ƽ���Ŀ¼����Box-->&nbsp;</div>
		<div class="submit"><a href="javascript:;" class="btn btnOrange"><button id="createCodeButtonC" type="button" onclick="createCode('Cat')">���ɴ���</button></a>
		</div>
	</li>
	<li id="selIndex" parent="tips" tips="��ҳ">
	<div class="submit"><a href="javascript:;" class="btn btnOrange"><button id="createCodeButtonF" type="button" onclick="createCode('Index')">������ҳ����</button></a>
	</div>
	</li>
	
	<li id="selTheme" parent="tips" tips="����">
	<h2>��ѡ��������
		<select name="theme_name" onchange="createCode('Theme')" >
			<option value="googleapple">��ȿƼ�֮����ƻ���ȸ�</option>
			<option value="familyfun">������-һ����У���</option>
			<option value="shopping">ȥ���������</option>
			<option value="2012yellow_stone">��ʯ��԰�����д���</option>
			<option value="yhuts">������ס����ʯ��԰Сľ��</option>
			</select>
	</h2>	
		<div class="submit"><a href="javascript:;" class="btn btnOrange"><button id="createCodeButtonG" type="button" onclick="createCode('Theme')">���ɴ���</button></a></div>
	</li>
	
	</ul>
	</div>
	</div>


</div>
	
	<div class="get_code_view">
	<h2>��ȡ������</h2>
	<div class="get_code_panel">
	<div class="adLinks">
	<div id="textAdPr" parent="links_type">
    <h4>���ֹ��<span>�����´���ŵ�����վ�򲩿͡���̳��ҳԴ���С�</span></h4>
	<textarea isCodeBox="yes" id="codeProductsText" class="code" ><?= $bLink2?></textarea>
    <div id="codeProductsHtml"></div>
	<div class="copyCode">
	<a href="javascript:;" class="get_code_btn" onclick="_copyClipboard('codeProductsText')">��ȡ����</a>
	<a href="javascript:;" class="btn btnGrey"><button type="button" onclick="_preview('codeProductsText')">Ԥ��Ч��</button></a>
	</div>
    </div>
	
	<div id="imageAdPr" parent="links_type">
	<h4>ͼƬ���<span>�����´���ŵ�����վ�򲩿͡���̳��ҳԴ���С�</span></h4>
    <textarea isCodeBox="yes" id="codeProductsImages" class="code" ><?= $bLink?></textarea>
	<div id="codeProductsImagesHtml"></div>
	<div class="copyCode">
	<a href="javascript:;" class="get_code_btn" onclick="_copyClipboard('codeProductsImages')">��ȡ����</a>
	<a href="javascript:;" class="btn btnGrey"><button type="button" onclick="_preview('codeProductsImages')">Ԥ��Ч��</button></a>
	</div>
	</div>
	
	<div id="imageTextAdPr" parent="links_type">
	<h4>ͼ�Ĺ��<span>�����´���ŵ�����վ�򲩿͡���̳��ҳԴ���С�</span></h4>
    <textarea isCodeBox="yes" id="codeProductsImagesText" class="code" ><?= $bLink?></textarea>
	<div id="codeProductsImagesTextHtml"></div>	
	<div class="copyCode"><a href="javascript:;" class="get_code_btn" onclick="_copyClipboard('codeProductsImagesText')">��ȡ����</a>
	<a href="javascript:;" class="btn btnGrey"><button type="button" onclick="_preview('codeProductsImagesText')">Ԥ��Ч��</button></a>
	</div>
	</div>
	
</div>
</div>
	</div>

<?php /* �г̵������Ѿ���ȡ��?>
<div class="popup" id="popupRoute">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
<tr><td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td><td class="con">

  <div class="popupCon" id="popupConRoute" style="width:650px;">
    <div class="popupConTop" id="dragRoute">
      <h3><b>��ѡ����Ҫ�Ƽ����г�</b></h3><span onclick="closePopup('popupRoute')"><img src="image/icons/icon_x.gif" alt="�ر�" title="�ر�" /></span>
    </div>
    
    <ul class="chooseRoute" id="ChooseRoute">
        <?php
		$li_page = 1;
		$li_class = "";
		for($i=0, $n=sizeof($referProducts); $i<$n; $i++ ){
			if((int)$i && $i%10==0){
				$li_page++;
				$li_class = 'displayNone';
			}
		?>
		<li page="<?= $li_page?>" class="<?= $li_class?>"><input type="radio" name="route" value="<?= $referProducts[$i]['products_id']?>" /><a target="_blank" href="<?= tep_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$referProducts[$i]['products_id']);?>"><?= tep_db_prepare_input($referProducts[$i]['products_name'])?></a></li>
        <?php }?>
    </ul>
    
	<?php if($li_page>1){?>
    <div class="page routePage">
        <a class="go pre" style="display:none" href="javascript:_goto(-1,'ChooseRoute','popupConRoute')">��һҳ</a>
        <a class="go next" href="javascript:_goto(1,'ChooseRoute','popupConRoute')">��һҳ</a>
    </div>
    <?php }?>
	
    <div class="popupBtn">
        <a class="btn btnOrange" href="javascript:;"><button onclick="_selProducts()" type="button">ȷ ��</button></a>
    </div>
    
<script type="text/javascript">

//ѡ���Ƽ����г�
jQuery("#ChooseRoute li").click(function(){
	jQuery("#ChooseRoute li").removeClass("over");
	jQuery(this).find("input[type='radio']").attr('checked',true);
	jQuery(this).addClass("over");
	jQuery('#rProductsId').val(jQuery(this).find("input[type='radio']").val());
	jQuery('#routeTitleProducts').html(jQuery(this).html());
	jQuery('#routeTitleProducts input').remove();
});
//ȷ��
function _selProducts(){
	var _pID = jQuery('#rProductsId').val();
	if(_pID=="" || parseInt(_pID)==0){
		alert("��ѡ��һ���г̣�");
	}else{
		closePopup('popupRoute');
	}
}
//��ҳ
function _goto(num,ulID,popupID){
	var oldPage = jQuery('#'+ulID+' li[class=""]').attr('page');
	jQuery('#'+ulID+' li[class=""]').attr('class','displayNone');
	var nowPage = parseInt(oldPage)+parseInt(num);
	var preNextPage = nowPage+parseInt(num);
	var nowPageObj = jQuery("#"+ulID+" li[page='"+nowPage+"']");
	var preNextPageObj = jQuery("#"+ulID+" li[page='"+preNextPage+"']");
	if(nowPageObj.length>0){
		jQuery(nowPageObj).attr('class','');
	}
	
	jQuery('#'+popupID+' a[class="go pre"]').show();
	jQuery('#'+popupID+' a[class="go next"]').show();
	if(preNextPageObj.length<1){
		if(num=="-1"){ jQuery('#'+popupID+' a[class="go pre"]').hide(); }
		if(num=="1"){ jQuery('#'+popupID+' a[class="go next"]').hide(); }
	}
	
}

</script>
    
    
  </div>
  
</td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
</table>
</div>
<?php */?>

<div class="popup" id="popupSort">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
<tr><td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td><td class="con">

  <div class="popupCon" id="popupConSort" style="width:650px;">
    <div class="popupConTop" id="dragSort">
      <h3><b>��ѡ����Ҫ�Ƽ��ľ���</b></h3><span onclick="closePopup('popupSort')"><img src="<?= DIR_WS_ICONS;?>icon_x.gif" alt="�ر�" title="�ر�" /></span>
    </div>
    
    <div class="chooseSort">
        <dl>
            <?php
			for($i=0, $n=sizeof($rfCats); $i < $n; $i++){
			?>
			<dt id="rfCats_<?=$rfCats[$i]['id']?>"><label><input name="route" type="radio" value="<?=$rfCats[$i]['id']?>" onclick="_showChild('rfCats_<?=$rfCats[$i]['id']?>')" link="<?=tep_href_link(FILENAME_DEFAULT, 'cPath='.$rfCats[$i]['id']);?>" _alt="<?= $rfCats[$i]['name']?>" /><?= $rfCats[$i]['name']?></label></dt>
            	<?php foreach((array)$rfCats[$i]['child'] as $key => $val){?>
				<dd parent="rfCats_<?=$rfCats[$i]['id']?>"><label><input name="route" type="radio" value="<?= $rfCats[$i]['child'][$key]['id']?>" link="<?=tep_href_link(FILENAME_DEFAULT, 'cPath='.$rfCats[$i]['child'][$key]['id']);?>" _alt="<?= $rfCats[$i]['child'][$key]['name']?>" /><?= $rfCats[$i]['child'][$key]['name']?></label></dd>
				<?php }?>
			<?php
			}
			?>
        </dl>
    </div>
    
    <div class="popupBtn">
        <a class="btn btnOrange" href="javascript:;"><button onclick="_selCat()" type="button">ȷ ��</button></a>
    </div>
    
<script type="text/javascript">
jQuery('#popupConSort dd').hide();
function _showChild(id){
	jQuery('#popupConSort dd').hide();
	jQuery('dd[parent="'+ id +'"]').fadeIn(300);
}
//ѡ���Ƽ���Ŀ¼
jQuery('#popupSort input[type="radio"]').click(function(){
	jQuery('#rCatId').val(jQuery(this).val());
	var _boxHtml = '<a href="'+ jQuery(this).attr('link') +'" target="_blank">' + jQuery(this).attr('_alt') + '</a>';
	jQuery('#routeTitleCat').html(_boxHtml);
});
//ȷ��
function _selCat(){
	var _cID = jQuery('#rCatId').val();
	if(_cID=="" || parseInt(_cID)==0){
		alert("��ѡ��һ�����㣡");
	}else{
		createCode('Cat');
		closePopup('popupSort');
	}
}
</script>
    
    
  </div>
  
</td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
</table>
</div>

<div id="popupBg" class="popupBg"></div>



</div>
<?php 
//ͼ�Ĺ��}
//������Ƕ��{
?>
<div panel="yes" id="search_panel">
<div class="get_code_panel">
	<table>
		<tbody>
			<tr>
				<td align="right" style="width:180px;">ѡ�����������ͣ�</td>
				<td>
					<span><input type="radio" checked="checked" id="sideSearch" name="searchType" value="side" onclick="jQuery('#search_panel_all').hide(); clear_view();"><label for="sideSearch">�߲�������</label></span>
					<span><input type="radio" id="allSearch" name="searchType" value="all" onclick="jQuery('#search_panel_all').show(); clear_view();"><label for="allSearch">ͨ��������</label></span>
				</td>
			</tr>
			<tr id="search_panel_all" style="display:none">
				<td  align="right">���ýṹ��</td>
				<td>
					<span><input type="checkbox" checked="checked" name="search_logo" id="search_logo" value="1" onclick="clear_view();"><label for="search_logo">���ķ�logo</label></span>
					<span><input type="checkbox" checked="checked" name="search_keywords" id="search_keywords" value="1" onclick="clear_view();"><label for="search_keywords">���Źؼ���</label></span>
				</td>
			</tr>
			<tr>
				<td  align="right">��ȡ���룺</td>
				<td>
					<textarea isCodeBox="yes" id="codeSearchHtml" class="code_view" readonly="readonly"></textarea>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<a href="javascript:;" class="btn btnOrange"><button id="createCodeButtonE" type="button" onclick="createCode('Search')">���ɴ���</button></a>
				<a href="javascript:;" class="get_code_btn" onclick="_copyClipboard('codeSearchHtml')">��ȡ����</a>
				</td>
			</tr>
		</tbody>
	</table>
</div>
</div>
<?php 
//������Ƕ��}
//�Զ�������{
?>
<div panel="yes" id="custom_panel">
        <div class="links_form">
        	<p><label for="custom_links_text">�Զ������֣�</label><input type="text" name="custom_links_text" id="custom_links_text" value="���ķ�" /></p>
            <p><label for="custom_links_url">���ӵ���ַ��</label><input type="text" name="custom_links_url" id="custom_links_url" value="<?= HTTP_SERVER;?>/" /><span>�����뺬��<?= HTTP_SERVER;?>����ַ</span></p>
        <div class="submit"><a href="javascript:;" class="btn btnOrange"><button id="createCodeButtonD" type="button" onclick="createCode('Custom')">���ɴ���</button></a>
		</div>
		</div>
        <h3 class="get_code_head">��ȡ�Զ����HTML����</h3>
        <div class="get_code_panel">
        	<p class="get_code_tips"><em>ע�⣺</em>��������ID�ڡ����ɴ��롱ʱ��Ƕ��</p>
            <textarea isCodeBox="yes" id="codeCustomHtml" name="codeCustomHtml" class="get_code_textarea"></textarea>
            <p>
			<a href="javascript:;" onclick="_copyClipboard('codeCustomHtml')" class="get_code_btn">��ȡHTML����</a>
			
			<!--<a href="javascript:;" class="btn btnGrey"><button type="button" onclick="_preview('codeCustomHtml')">Ԥ��Ч��</button></a>-->
			</p>
        </div>
        <h3 class="get_code_head">��ȡ�Զ����URL����</h3>
        <div class="get_code_panel">
        	<p class="get_code_tips"><em>ע�⣺</em>��������ID��"���ɴ���"ʱ��Ƕ��</p>
            <textarea isCodeBox="yes" id="codeCustomUrl" name="codeCustomUrl" class="get_code_textarea"></textarea>
            <p>
			<a href="javascript:;" onclick="_copyClipboard('codeCustomUrl')" class="get_code_btn">��ȡURL����</a>
			<!--<a href="javascript:;" class="btn btnGrey"><button type="button" onclick="_preview('codeCustomUrl')">Ԥ��Ч��</button></a>-->
			</p>
        </div>

</div>
<?php 
//�Զ�������}
?>

<div id="pview" class="get_code_view">
	<h2>Ԥ��Ч��</h2>
	<div class="get_code_view_panel" id="get_code_view_panel">
	</div>
</div>
</div>
</div>
</form>

<script type="text/javascript">
/* ���Ԥ����ʹ��������*/
function clear_view(){
	jQuery('#get_code_view_panel').html('');
	jQuery('textarea[isCodeBox="yes"]').val('');
}

/*�л�Tags*/
function setTab(TabStr){
	clear_view();
	jQuery('#userTitle ul li').removeClass('cur');
	jQuery('#panelCon div[panel="yes"]').hide();
	jQuery('#pview').hide();
	
	if(TabStr!=''){
		var li = '#'+ TabStr +'_tag';
		var panel = '#'+ TabStr +'_panel';
		jQuery(li).addClass('cur');
		jQuery(panel).show();
		if(TabStr!='promocode' && TabStr!='custom'){
			jQuery('#pview').show();
		}
		if(document.all){			
			//IE
			var hashString = 'tag=' + TabStr +'_tag';
			if(hashString!=''){
				unFocus.History.addHistory(hashString);
			}		
		}else{
			//FF
			window.location.hash = '#tag=' + TabStr +'_tag';
		}
	}
}

<?php
//����в�ƷID��Ӧ��ʾͼ�Ĺ���ǩ
$TabStr = '';
if((int)$rProductsId || !isset($_GET['tag'])){
	$TabStr = 'imagetext';
}elseif(tep_not_null($_GET['tag'])){
	$TabStr = str_replace('_tag','',$_GET['tag']);
}
?>
var TabStr = '<?= $TabStr?>';
setTab(TabStr);
/*��ʱִ��setTab*/
var _tmp_num = 0;
setInterval(function(){
	var oldTabStr = TabStr;
	hash = window.location.hash.substring(1);
	_tab = hash.split('=');
	if(_tab.constructor == Array){
		if(_tab[0]=='tag'){
			TabStr = _tab[1].replace('_tag','');
		}
	}
	if(TabStr != oldTabStr ||  _tmp_num == 0){
		_tmp_num = 1;
		setTab(TabStr);
	}
} , 700 );


//���õ����㶥����ҷ 
//new divDrag([GetIdObj('dragRoute'),GetIdObj('popupRoute')]); 
new divDrag([GetIdObj('dragSort'),GetIdObj('popupSort')]); 

function _copyClipboard(id){
	var _text = jQuery('#'+id).val();
	if(document.all){
		var e=_text;
		window.clipboardData.setData('text', e);
		if(e.length>2){
			alert("��ϲ���Ѿ��ɹ�������ճ���壡");
		}else{ /*alert("�յ�");*/ }
	}else{
		alert("�����������֧�ּ���������������и��ơ�");
	};
}

//Ԥ��Ч��
function _preview(htmlIpnutID){
	var ID = '#'+htmlIpnutID;
	jQuery('#get_code_view_panel').hide();
	jQuery('#get_code_view_panel').html(jQuery(ID).val());
	jQuery('#get_code_view_panel').fadeIn();
	//alert(jQuery(ID).val());
}

//���ɴ���
function createCode(action){
	clear_view();
	var error = false;
	var Form = document.getElementById("formBanners");
	switch(action){
		case 'Products':
			var _pID = jQuery('#rProductsId').val();
			var _pModel = jQuery('#pModel').val();
			if((_pID=="" || parseInt(_pID)==0) && _pModel == "" ){
				error = true;
				alert("������дһ�������źţ�");
			}else{
				disabledBtn = jQuery('#createCodeButtonP');
			}			
		break;
		case 'Cat':
			var _cID = jQuery('#rCatId').val();
			if(_cID=="" || parseInt(_cID)==0){
				error = true;
				alert("����ѡ�񾰵㣡");
			}else{
				disabledBtn = jQuery('#createCodeButtonC');
			}
		break;
		case 'Custom':
			var val = jQuery('#custom_links_url').val();
			var textVal = jQuery('#custom_links_text').val();
			if(val.length<1 || textVal.length<1){
				error = true;
				alert("���������ӵ���ַ���Զ������֣�");
			}else if(val.search(/^<?= preg_quote(HTTP_SERVER,'/');?>/)==-1){
				error = true;
				alert("���ӵ���ַ��������<?= HTTP_SERVER;?>/��ͷ");
			}else{
				disabledBtn = jQuery('#createCodeButtonD');
			}
		break;
		case 'Search':	
			disabledBtn = jQuery('#createCodeButtonE');
		break;
		case 'Index':
			disabledBtn = jQuery('#createCodeButtonF');
		break;
		case 'Theme':
			disabledBtn = jQuery('#createCodeButtonG');
		break;
	}
	
	if(error == true){
		return false;
	}
	
	jQuery(disabledBtn).attr('disabled',true);
	jQuery(disabledBtn).html('�����С���');
	
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('affiliate_banners.php','ajax=true')) ?>");
	url+='&action='+action;
	ajax_post_submit(url,Form.id);
}

<?php
if((int)$rProductsId){	//���в�Ʒ������ʱ�Զ�ִ�����ɴ���
?>
createCode('Products');
<?php 
}
?>

/* ѡ������Ŀ��ҳʱ�Ĺ���*/
function tips_fun(obj){
	clear_view();
	jQuery('#imagetext_panel li[parent="tips"]').hide();
	jQuery('#'+obj.value).fadeIn();
	switch(obj.value){
		case 'selCategories':
			showPopup('popupSort','popupConSort','fixedTop','off','ChooseSort');
		break;
		case 'selProducts':		/* �г̲���ʾ�����С */
			jQuery('#image_size_li').hide();
		break;		
		default: jQuery('#image_size_li').fadeIn();		
	}
};

tips_fun(document.getElementById('tips'));

/* ѡ��������ʽʱ�Ĺ��� */
function links_type_fun(obj){
	 clear_view();
	jQuery('#imagetext_panel div[parent="links_type"]').hide();
	jQuery('#image_size_li').hide();
	jQuery('#'+obj.value).fadeIn();
	if((obj.value == 'imageTextAdPr' || obj.value == 'imageAdPr') && jQuery('#tips').val()!='selProducts'){	/* �г̲���ʾ�����С */
		jQuery('#image_size_li').fadeIn();
	}
};

links_type_fun(document.getElementById('links_type_0'));

</script>
<?php echo db_to_html(ob_get_clean());?>
<!--*******************************ǩ֤����********************************-->
<?php
ob_start();
?>
<script language="javascript" type="text/javascript">
// ǩ֤��ҳ�������
jQuery(function(){
	//jQuery(".visa_list > li:not(:third)").hide();  
	//jQuery(".visa_list > li").show();
	jQuery(".visa_list li h3").click(function(){	//alert(jQuery(this).parent().next().html());
			if(jQuery(this).parent().next().css('display') == "none"){//alert('=none');
				jQuery(this).parent().parents(".visa_list")
					   .find("li").removeClass("current");
					   //.end();
					   //.find("div").stop(true,true).slideUp("slow");
				jQuery(this).parent().parent().addClass("current")
					   .slideDown("slow");
			}
			else{ //alert('not none');//alert(jQuery(this).parent().parent().parent().html());
			  jQuery(this).parent().parents(".visa_list")
					   .find("li").removeClass("current");
					   //.end()
					   //.find("div").stop(true,true).slideUp("slow");
			}
	})	
})

jQuery(function(){
	jQuery("#faq_visa_cont > div").not(":first").hide();
	jQuery("#faq_visa_tit > li").hover(function(){
		jQuery(this).addClass("cur").siblings().removeClass("cur");
		var index = jQuery("#faq_visa_tit > li").index(this);
		jQuery("#faq_visa_cont > div").eq(index).show().siblings().hide();
	})
});
</script>
<div id="visa_wrap">
	<div id="left_wrap">
    	<div class="visa_content">
            <div class="usa_visa"><!--����ǩ֤-->
               	<dl>
                	<dt><img src="/image/visa/usa_siva_img1.gif" alt="����ǩ֤"/></dt>
                    <dd>
                    	<ul>
                        	<li><h1>����ǩ֤</h1></li>
                            <li><strong class="font14 color1">��������������дǩ֤�����DS-160 </strong>  </li>
                            <li>���ҶԽ�������ʹ��ǩ֤ϵͳ��ֱ�Ӵ�ӡȷ����(����ʹ��������)��ǩʱЯ����ȷ���ţ�</li>
                        </ul>
                    </dd>
                </dl>
          	</div>
            <div class="visa_flow" <?php if(CHARSET=='big5') {?> style="background: url(<?= DIR_WS_TEMPLATE_IMAGES;?>visa/visa_flow_bg_big5.gif) no-repeat scroll center 0 transparent;"<?php }?>><!--ǩ֤��������-->
            	<ul class="arrowhead">
                	<li></li>
                	<li></li>
                	<li></li>
                	<li></li>
                </ul>
            	<ul class="imgs">
                	<li><img src="/image/visa/visa_flow_img1.gif" alt="�����������"/><p>�����������</p></li>
                    <li><img src="/image/visa/visa_flow_img2.gif" alt="ԤԼ��ǩʱ��"/><p>ԤԼ��ǩʱ��</p></li>
                    <li><img src="/image/visa/visa_flow_img3.gif" alt="�������/ǩ֤��ѵ"/><p>�������/ǩ֤��ѵ</p></li>
                    <li><img src="/image/visa/visa_flow_img4.gif" alt="��ͬ���"/><p>��ͬ���</p></li>
                    <li><img src="/image/visa/visa_flow_img5.gif" alt="��ǩ����"/><p>��ǩ����</p></li>
                </ul>
          </div>

            
<!--ǩ֤����-->
<!--����ҪĬ��չ���ĵط����:1.li��class="current", 2.�¼�div��style="display:block;"//-->
            <div class="visa_list">			
   	 			<ul>
                	<li>
						<div class="tit">
							<?php echo get_visa_info_title($visa_product,'̽�׷���ǩ֤(B2)');?>              
                		</div>
						<div class="visa_list_content">
							<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
                				<tr>
                					<td width="167" bgcolor="#FFFFFF" class="paddingL">������Ч���գ�</td>
                					<td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ����̸֮ǰ������һ���»��ա�</td>
                				</tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL">����ǩ֤��Ƭ��</td>
				                	<td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա����������ƬҪ������͸��������������Ƭ���ڻ��շ����ϡ� </td>
				                </tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL">����ǩ֤������վ�ԭ����<br /></td>
				                	<td bgcolor="#FFFFFF" class="padding15">�������������������й����κη���֧��ǩ֤�����896Ԫ�����()���뽫�վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
				                </tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL">����ǩ֤������վ�ԭ����</td>
				                	<td bgcolor="#FFFFFF" class="padding15"> ���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
				                </tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL">��������֤����</td>
				                	<td bgcolor="#FFFFFF" class="padding15">֤�������������蹤������֧������ͣ�������ڼ�ķ��ã������ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ���ע�⣺�벻Ҫ��ʾ���д��֤���������֤������ǩ֤����û�а�������</td>
				                </tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL">����������ϵ֤����</td>
				                	<td bgcolor="#FFFFFF" class="padding15">�����������Ĺ�ϵ֤��������֤ԭ������Ů����֤ԭ�����������źͼ�ͥ��Ӱ�ȡ�</td>
				                </tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL">�������������Ϸ����֤����</td>
				                	<td bgcolor="#FFFFFF" class="padding15">���������ĺϷ����֤�����绤�ռ�����ǩ֤�ĸ�ӡ������ѧ����I-20����������ѧ�ߵ�DS-2019�����ڹ�����Ա��I-797��ȡ�</td>
				                </tr>
                			</table>
						</div>
					</li>
	                <li>
						<div class="tit">
							<?php echo get_visa_info_title($visa_product,'��������ǩ֤(B2)');?> 
						</div>                
		                <div class="visa_list_content">
							<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
				                <tr>
				                	<td width="167" bgcolor="#FFFFFF" class="paddingL"><strong>1</strong>����Ч���գ�</td>
				                	<td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ��ǩ֤֮ǰ������һ���»��ա� </td>
				                </tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL"><strong>2</strong>��DS-160���ȷ��ҳ��</td>
				                	<td bgcolor="#FFFFFF" class="padding15">��������ע���������������������������ĵ籨�롢���ļ�ͥ��ַ����˾���ּ���ַ���뽫���ı��ȷ��ҳ���Ŵ�ӡ��A4ֽ�ϡ���̸ʱ��Я����ӡ������DS-160���ȷ��ҳ����Ҫʹ�ô����ȷ��ҳ�� </td>
				                </tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL"><strong>3</strong>��һ����Ƭ��<br /></td>
				                	<td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա�����͸��������������Ƭ���ڻ��շ����ϡ�</td>
				                </tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL"><strong>4</strong>��ǩ֤������վ�ԭ����</td>
				                	<td bgcolor="#FFFFFF" class="padding15"> ���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
				                </tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL"><strong>5</strong>�����գ�</td>
				                	<td bgcolor="#FFFFFF" class="padding15">������ǰ����ǩ֤�Ļ��գ�������ʧЧ�Ļ���</td>
				                </tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL"><strong>6</strong>���ܹ�˵����Ϊ��һ���᷵���й���֤�ݣ�</td>
				                	<td bgcolor="#FFFFFF" class="padding15">��ʾ���á���ᡢ��ͥ�����������������Լ�������ļ����԰�����֤��������������ͣ�������ⷵ���й������ڸ�������Ĳ�ͬ��������Ӧ��ʾ��֤��Ҳ������ͬ�������ļ����԰���ǩ֤���������Ƿ����ⷵ���й������ڱ������֤����Ӷ֤�����ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ� </td>
				                </tr>
				                <tr>
				                	<td bgcolor="#FFFFFF" class="paddingL"><strong>7</strong>���ʽ�֤����</td>
				                	<td bgcolor="#FFFFFF" class="padding15">֤�������������蹤������֧������ͣ�������ڼ�ķ��ã������ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ���ע�⣺�벻Ҫ��ʾ���д��֤���������֤������ǩ֤����û�а�������</td>
				                </tr>
			                </table>
						</div>
					</li>
                <li>
				<div class="tit">
				<?php echo get_visa_info_title($visa_product,'��������ǩ֤(B2)');?>
                </div>
                <div class="visa_list_content" >
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
                <tr>
                <td width="167" bgcolor="#FFFFFF" class="paddingL"><strong>1</strong>����Ч���գ�</td>
                <td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ��ǩ֤֮ǰ������һ���»��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>2</strong>��DS-160���ȷ��ҳ��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������ע���������������������������ĵ籨�롢���ļ�ͥ��ַ����˾���ּ���ַ���뽫���ı��ȷ��ҳ���Ŵ�ӡ��A4ֽ�ϡ���̸ʱ��Я����ӡ������DS-160���ȷ��ҳ����Ҫʹ�ô����ȷ��ҳ������������� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>3</strong>��һ����Ƭ��<br /></td>
                <td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա����������ƬҪ������͸��������������Ƭ���ڻ��շ����ϡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>4</strong>��ǩ֤������վ�ԭ����</td>
                <td bgcolor="#FFFFFF" class="padding15">���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>5</strong>�����գ�</td>
                <td bgcolor="#FFFFFF" class="padding15">������ǰ����ǩ֤�Ļ��գ�������ʧЧ�Ļ��ա�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>6</strong>���ܹ�˵����Ϊ��һ���᷵���й���֤�ݣ�</td>
                <td bgcolor="#FFFFFF" class="padding15">��ʾ���á���ᡢ��ͥ�����������������Լ�������ļ����԰�����֤��������������ͣ�������ⷵ���й������ڸ�������Ĳ�ͬ��������Ӧ��ʾ��֤��Ҳ������ͬ�������ļ����԰���ǩ֤���������Ƿ����ⷵ���й������ڱ������֤����Ӷ֤�����ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>7</strong>�������ţ�</td>
                <td bgcolor="#FFFFFF" class="padding15">�������������������ĳλ������ô�ṩ������Ϣ������������������������������Ϣ������Ŀ�ġ����Ȱ��ŵ�����ʱ�̱������ֻ�ǵ����������Σ���ô�������ʾ�����š�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>8</strong>���ʽ�֤����</td>
                <td bgcolor="#FFFFFF" class="padding15">֤�������������蹤������֧������ͣ�������ڼ�ķ��ã������ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ���ע�⣺�벻Ҫ��ʾ���д��֤���������֤������ǩ֤����û�а�������</td>
                </tr>
                </table>
				</div>
                </li>
                <li>
				<div class="tit">
				<?php echo get_visa_info_title($visa_product,'�μӻ���չ��ǩ֤(B1/B2)');?>
                </div>
                <div class="visa_list_content" >
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
                <tr>
                <td width="167" bgcolor="#FFFFFF" class="paddingL"><strong>1</strong>����Ч���գ�</td>
                <td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ��ǩ֤֮ǰ������һ���»��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>2</strong>��DS-160���ȷ��ҳ��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������ע���������������������������ĵ籨�롢���ļ�ͥ��ַ����˾���ּ���ַ���뽫���ı��ȷ��ҳ���Ŵ�ӡ��A4ֽ�ϡ���̸ʱ��Я����ӡ������DS-160���ȷ��ҳ����Ҫʹ�ô����ȷ��ҳ������������� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>3</strong>��һ����Ƭ��<br /></td>
                <td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա����������ƬҪ������͸��������������Ƭ���ڻ��շ����ϡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>4</strong>��ǩ֤������վ�ԭ����</td>
                <td bgcolor="#FFFFFF" class="padding15">���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>5</strong>�����գ�</td>
                <td bgcolor="#FFFFFF" class="padding15">������ǰ����ǩ֤�Ļ��գ�������ʧЧ�Ļ��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>6</strong>���ܹ�˵����Ϊ��һ���᷵���й���֤�ݣ�</td>
                <td bgcolor="#FFFFFF" class="padding15">��ʾ���á���ᡢ��ͥ�����������������Լ�������ļ����԰�����֤��������������ͣ�������ⷵ���й������ڸ�������Ĳ�ͬ��������Ӧ��ʾ��֤��Ҳ������ͬ�������ļ����԰���ǩ֤���������Ƿ����ⷵ���й������ڱ������֤����Ӷ֤�����ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>7</strong>�����뺯��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������������������뿼��Я��������Ϣǰ����̸������������������Щ��Ա����������н�������Щ�����Լ�������������������Щ��Ʒ�������ļ����ܻ��������һ���������� �����������ߵ���ϸ���뺯��˵�������˵ķ���Ŀ�ģ�������������ǩ���ĺ�ͬ������Э�飻������������Ļ���������������豸�������Ϣ�����Ʒ������ ����ƷĿ¼�ȡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>8</strong>���ʽ�֤����</td>
                <td bgcolor="#FFFFFF" class="padding15">֤�������������蹤������֧������ͣ�������ڼ�ķ��ã������ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ���ע�⣺�벻Ҫ��ʾ���д��֤���������֤������ǩ֤����û�а�������</td>
                </tr>
                </table>
				</div>
                </li>
                <li>
				<div class="tit">
				<?php echo get_visa_info_title($visa_product,'���񿼲�ǩ֤(B1/B2)');?>
                </div>
                <div class="visa_list_content">
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
                <tr>
                <td width="167" bgcolor="#FFFFFF" class="paddingL"><strong>1</strong>����Ч���գ�</td>
                <td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ��ǩ֤֮ǰ������һ���»��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>2</strong>��DS-160���ȷ��ҳ��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������ע���������������������������ĵ籨�롢���ļ�ͥ��ַ����˾���ּ���ַ���뽫���ı��ȷ��ҳ���Ŵ�ӡ��A4ֽ�ϡ���̸ʱ��Я����ӡ������DS-160���ȷ��ҳ����Ҫʹ�ô����ȷ��ҳ������������� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>3</strong>��һ����Ƭ��<br /></td>
                <td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա����������ƬҪ������͸��������������Ƭ���ڻ��շ����ϡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>4</strong>��ǩ֤������վ�ԭ����</td>
                <td bgcolor="#FFFFFF" class="padding15">���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>5</strong>�����գ�</td>
                <td bgcolor="#FFFFFF" class="padding15">������ǰ����ǩ֤�Ļ��գ�������ʧЧ�Ļ��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>6</strong>���ܹ�˵����Ϊ��һ���᷵���й���֤�ݣ�</td>
                <td bgcolor="#FFFFFF" class="padding15">��ʾ���á���ᡢ��ͥ�����������������Լ�������ļ����԰�����֤��������������ͣ�������ⷵ���й������ڸ�������Ĳ�ͬ��������Ӧ��ʾ��֤��Ҳ������ͬ�������ļ����԰���ǩ֤���������Ƿ����ⷵ���й������ڱ������֤����Ӷ֤�����ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>7</strong>�����뺯��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������������������뿼��Я��������Ϣǰ����̸������������������Щ��Ա����������н�������Щ�����Լ�������������������Щ��Ʒ�������ļ����ܻ��������һ���������� �����������ߵ���ϸ���뺯��˵�������˵ķ���Ŀ�ģ�������������ǩ���ĺ�ͬ������Э�飻������������Ļ���������������豸�������Ϣ�����Ʒ������ ����ƷĿ¼�ȡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>8</strong>���ʽ�֤����</td>
                <td bgcolor="#FFFFFF" class="padding15">֤�������������蹤������֧������ͣ�������ڼ�ķ��ã������ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ���ע�⣺�벻Ҫ��ʾ���д��֤���������֤������ǩ֤����û�а�������</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>9</strong>���������������������</td>
                <td bgcolor="#FFFFFF" class="padding15">�뿼��Я��������Ϣǰ����̸������������������Щ��Ա����������н�������Щ�����Լ�������������������Щ��Ʒ�������ļ����ܻ��������һ���������������������ߵ���ϸ�����ţ�˵�������˵ķ���Ŀ�ģ�������������ǩ���ĺ�ͬ������Э�飻������������Ļ���������������豸�������Ϣ�����Ʒ�����ֲ���ƷĿ¼�ȡ�</td>
                </tr>
                </table>
				</div>
                </li>
                <li>
				<div class="tit">
				<?php echo get_visa_info_title($visa_product,'��ѵǩ֤(B1/B2)');?>
                </div>
                <div class="visa_list_content">
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
                <tr>
                <td width="167" bgcolor="#FFFFFF" class="paddingL"><strong>1</strong>����Ч���գ�</td>
                <td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ��ǩ֤֮ǰ������һ���»��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>2</strong>��DS-160���ȷ��ҳ��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������ע���������������������������ĵ籨�롢���ļ�ͥ��ַ����˾���ּ���ַ���뽫���ı��ȷ��ҳ���Ŵ�ӡ��A4ֽ�ϡ���̸ʱ��Я����ӡ������DS-160���ȷ��ҳ����Ҫʹ�ô����ȷ��ҳ������������� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>3</strong>��һ����Ƭ��<br /></td>
                <td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա����������ƬҪ������͸��������������Ƭ���ڻ��շ����ϡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>4</strong>��ǩ֤������վ�ԭ����</td>
                <td bgcolor="#FFFFFF" class="padding15">���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>5</strong>�����գ�</td>
                <td bgcolor="#FFFFFF" class="padding15">������ǰ����ǩ֤�Ļ��գ�������ʧЧ�Ļ��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>6</strong>���ܹ�˵����Ϊ��һ���᷵���й���֤�ݣ�</td>
                <td bgcolor="#FFFFFF" class="padding15">��ʾ���á���ᡢ��ͥ�����������������Լ�������ļ����԰�����֤��������������ͣ�������ⷵ���й������ڸ�������Ĳ�ͬ��������Ӧ��ʾ��֤��Ҳ������ͬ�������ļ����԰���ǩ֤���������Ƿ����ⷵ���й������ڱ������֤����Ӷ֤�����ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>7</strong>�������ţ�</td>
                <td bgcolor="#FFFFFF" class="padding15">���������ȥ�����μ�ҵ����ѵ����ô�ṩ������Ϣ������������������������������Ϣ������Ŀ�ġ����Ȱ��ŵ�����ʱ�̱�ȵȡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>8</strong>���ʽ�֤����</td>
                <td bgcolor="#FFFFFF" class="padding15">֤�������������蹤������֧������ͣ�������ڼ�ķ��ã������ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ���ע�⣺�벻Ҫ��ʾ���д��֤���������֤������ǩ֤����û�а�������</td>
                </tr>
                </table>
				</div>
                </li>
                <li>
				<div class="tit">
				<?php echo get_visa_info_title($visa_product,'��쿴��ǩ֤(B2)');?>
                </div>
                <div class="visa_list_content">
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
                <tr>
                <td width="167" bgcolor="#FFFFFF" class="paddingL"><strong>1</strong>����Ч���գ�</td>
                <td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ��ǩ֤֮ǰ������һ���»��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>2</strong>��DS-160���ȷ��ҳ��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������ע���������������������������ĵ籨�롢���ļ�ͥ��ַ����˾���ּ���ַ���뽫���ı��ȷ��ҳ���Ŵ�ӡ��A4ֽ�ϡ���̸ʱ��Я����ӡ������DS-160���ȷ��ҳ����Ҫʹ�ô����ȷ��ҳ������������� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>3</strong>��һ����Ƭ��<br /></td>
                <td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա����������ƬҪ������͸��������������Ƭ���ڻ��շ����ϡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>4</strong>��ǩ֤������վ�ԭ����</td>
                <td bgcolor="#FFFFFF" class="padding15">���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>5</strong>�����գ�</td>
                <td bgcolor="#FFFFFF" class="padding15">������ǰ����ǩ֤�Ļ��գ�������ʧЧ�Ļ��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>6</strong>���ܹ�˵����Ϊ��һ���᷵���й���֤�ݣ�</td>
                <td bgcolor="#FFFFFF" class="padding15">��ʾ���á���ᡢ��ͥ�����������������Լ�������ļ����԰�����֤��������������ͣ�������ⷵ���й������ڸ�������Ĳ�ͬ��������Ӧ��ʾ��֤��Ҳ������ͬ�������ļ����԰���ǩ֤���������Ƿ����ⷵ���й������ڱ������֤����Ӷ֤�����ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>7</strong>���ʽ�֤����</td>
                <td bgcolor="#FFFFFF" class="padding15">֤�������������蹤������֧������ͣ�������ڼ�ķ��ã������ܿ͹۷�ӳ��ÿ������Ĺ��ʵ��������������ɵĴ�ȡ��¼�Ĵ��۵ȡ���ע�⣺�벻Ҫ��ʾ���д��֤���������֤������ǩ֤����û�а�������</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>8</strong>����ע��</td>
                <td bgcolor="#FFFFFF" class="padding15">����������������Щ��Ա����������н�������Щ�����Լ�������������������Щ��Ʒ�������ļ����ܻ��������һ���������������������ߵ���ϸ���뺯��˵�������˵ķ���Ŀ�ģ�������������ǩ���ĺ�ͬ������Э�飻������������Ļ���������������豸�������Ϣ�����Ʒ�����ֲ���ƷĿ¼�ȡ�</td>
                </tr>
                </table>
				</div>
                </li>
                <li>
				<div class="tit">
				<?php echo get_visa_info_title($visa_product,'��ѧǩ֤(F-1)');?>
                </div>
                <div class="visa_list_content">
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
                <tr>
                <td width="167" bgcolor="#FFFFFF" class="paddingL"><strong>1</strong>����Ч���գ�</td>
                <td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ��ǩ֤֮ǰ������һ���»��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>2</strong>��DS-160���ȷ��ҳ��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������ע���������������������������ĵ籨�롢���ļ�ͥ��ַ����˾���ּ���ַ���뽫���ı��ȷ��ҳ���Ŵ�ӡ��A4ֽ�ϡ���̸ʱ��Я����ӡ������DS-160���ȷ��ҳ����Ҫʹ�ô����ȷ��ҳ������������� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>3</strong>��һ����Ƭ��<br /></td>
                <td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա����������ƬҪ������͸��������������Ƭ���ڻ��շ����ϡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>4</strong>��ǩ֤������վ�ԭ����</td>
                <td bgcolor="#FFFFFF" class="padding15">���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>5</strong>�����գ�</td>
                <td bgcolor="#FFFFFF" class="padding15">������ǰ����ǩ֤�Ļ��գ�������ʧЧ�Ļ��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>6</strong>����д������ѧ���ͽ�������ѧ����Ϣϵͳ(SEVIS)���</td>
                <td bgcolor="#FFFFFF" class="padding15">��д������I-20A-B�����Ÿ�F1ѧ������I-20M-N�����Ÿ�M-1ѧ����������ѧУָ����Ա��DSO���������˱���ǩ�֡�����ϵ������������������ϵ�������ȫһ�£����ѱ�������ѧ����������SEVISϵͳ�������鿴�����й�ѧ���ͽ�������ѧ����Ϣϵͳ(SEVIS)����Ϣ�� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>7</strong>��SEVIS���վݣ�</td>
                <td bgcolor="#FFFFFF" class="padding15">�����J, F �� M ��ǩ֤�����������ڱ���֧��ά��ѧ���ͽ�������ѧ����Ϣϵͳ��SEVIS���ķ��á�����ǰ����̸ʱЯ�����Ӱ��վݻ�I-797�վ�ԭ���� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>8</strong>�����й����ι�Լ������֤����</td>
                <td bgcolor="#FFFFFF" class="padding15">��ʾ���á���ᡢ��ͥ����������Լ�������ļ����԰�����֤��������������ͣ��������Ը�����й��� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>9</strong>���ʽ�֤����</td>
                <td bgcolor="#FFFFFF" class="padding15">֤�������������蹤������֧������ͣ�������ڼ�ķ��á� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>10</strong>�� �о�/ѧϰ�ƻ���</td>
                <td bgcolor="#FFFFFF" class="padding15">�����ڼ�ƻ��õ�ѧϰ���о���������ϸ��Ϣ������������������ѧ�ĵ�ʦ��/��ϵ���ε����ּ������ʼ���ַ��</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>11</strong>�����˼�����</td>
                <td bgcolor="#FFFFFF" class="padding15">��ϸ��������ȥ��ѧ���͹�������ľ���������һ�����������µ��嵥��</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>12</strong>����У������ѧУ�ɼ�����</td>
                <td bgcolor="#FFFFFF" class="padding15">����������ѧУ�Ͷ�������Ӧ��������ǩ֤ʱ�ݽ���ѧ�γ̵Ĺٷ��ɼ�����</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>13</strong>����ʦ�ĸ���������ܣ�</td>
                <td bgcolor="#FFFFFF" class="padding15">�Ѿ���������ѧ�ﱻ�����˵�ʦ���о���Ӧ��������ʦ�ĸ���������ܡ���������ҳ��ӡ����</td>
                </tr>
                </table>
				</div>
                </li>
                <li>
				<div class="tit">
				<?php echo get_visa_info_title($visa_product,'��ѧǩ֤(B2)');?>
                </div>
                <div class="visa_list_content">
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
                <tr>
                <td width="167" bgcolor="#FFFFFF" class="paddingL"><strong>1</strong>����Ч���գ�</td>
                <td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ��ǩ֤֮ǰ������һ���»��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>2</strong>��DS-160���ȷ��ҳ��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������ע���������������������������ĵ籨�롢���ļ�ͥ��ַ����˾���ּ���ַ���뽫���ı��ȷ��ҳ���Ŵ�ӡ��A4ֽ�ϡ���̸ʱ��Я����ӡ������DS-160���ȷ��ҳ����Ҫʹ�ô����ȷ��ҳ������������� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>3</strong>��һ����Ƭ��<br /></td>
                <td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա����������ƬҪ������͸��������������Ƭ���ڻ��շ����ϡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>4</strong>��ǩ֤������վ�ԭ����</td>
                <td bgcolor="#FFFFFF" class="padding15">���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>5</strong>�����գ�</td>
                <td bgcolor="#FFFFFF" class="padding15">������ǰ����ǩ֤�Ļ��գ�������ʧЧ�Ļ��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>6</strong>����д������ѧ���ͽ�������ѧ����Ϣϵͳ(SEVIS)���</td>
                <td bgcolor="#FFFFFF" class="padding15">��д������I-20A-B�����Ÿ�F1ѧ������I-20M-N�����Ÿ�M-1ѧ����������ѧУָ����Ա��DSO���������˱���ǩ�֡�����ϵ������������������ϵ�������ȫһ�£����ѱ�������ѧ����������SEVISϵͳ�������鿴�����й�ѧ���ͽ�������ѧ����Ϣϵͳ(SEVIS)����Ϣ�� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>7</strong>��SEVIS���վݣ�</td>
                <td bgcolor="#FFFFFF" class="padding15">�����J, F �� M ��ǩ֤�����������ڱ���֧��ά��ѧ���ͽ�������ѧ����Ϣϵͳ��SEVIS���ķ��á�����ǰ����̸ʱЯ�����Ӱ��վݻ�I-797�վ�ԭ���� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>8</strong>�����й����ι�Լ������֤����</td>
                <td bgcolor="#FFFFFF" class="padding15">��ʾ���á���ᡢ��ͥ����������Լ�������ļ����԰�����֤��������������ͣ��������Ը�����й��� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>9</strong>���ʽ�֤����</td>
                <td bgcolor="#FFFFFF" class="padding15">֤�������������蹤������֧������ͣ�������ڼ�ķ��á� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>10</strong>�� �о�/ѧϰ�ƻ���</td>
                <td bgcolor="#FFFFFF" class="padding15">�����ڼ�ƻ��õ�ѧϰ���о���������ϸ��Ϣ������������������ѧ�ĵ�ʦ��/��ϵ���ε����ּ������ʼ���ַ��</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>11</strong>�����˼�����</td>
                <td bgcolor="#FFFFFF" class="padding15">��ϸ��������ȥ��ѧ���͹�������ľ���������һ�����������µ��嵥��</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>12</strong>����У������ѧУ�ɼ�����</td>
                <td bgcolor="#FFFFFF" class="padding15">����������ѧУ�Ͷ�������Ӧ��������ǩ֤ʱ�ݽ���ѧ�γ̵Ĺٷ��ɼ�����</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>13</strong>����ʦ�ĸ���������ܣ�</td>
                <td bgcolor="#FFFFFF" class="padding15">�Ѿ���������ѧ�ﱻ�����˵�ʦ���о���Ӧ��������ʦ�ĸ���������ܡ���������ҳ��ӡ����</td>
                </tr>
                </table>
				</div>
                </li>
                <li>
				<div class="tit">  
				<?php echo get_visa_info_title($visa_product,'����ѧ��ǩ֤(J-1)');?>
                </div>
                <div class="visa_list_content">
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
                <tr>
                <td width="167" bgcolor="#FFFFFF" class="paddingL"><strong>1</strong>����Ч���գ�</td>
                <td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ��ǩ֤֮ǰ������һ���»��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>2</strong>��DS-160���ȷ��ҳ��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������ע���������������������������ĵ籨�롢���ļ�ͥ��ַ����˾���ּ���ַ���뽫���ı��ȷ��ҳ���Ŵ�ӡ��A4ֽ�ϡ���̸ʱ��Я����ӡ������DS-160���ȷ��ҳ����Ҫʹ�ô����ȷ��ҳ������������� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>3</strong>��һ����Ƭ��<br /></td>
                <td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա����������ƬҪ������͸��������������Ƭ���ڻ��շ����ϡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>4</strong>��ǩ֤������վ�ԭ����</td>
                <td bgcolor="#FFFFFF" class="padding15">���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>5</strong>����д������DS-2019��</td>
                <td bgcolor="#FFFFFF" class="padding15">����ϵ������������������ϵ�������ȫһ�£����ѱ�������ѧ����������ѧ���ͽ�������ѧ����Ϣϵͳ��SEVIS���������鿴�����й�ѧ���ͽ�������ѧ����Ϣϵͳ(SEVIS)����Ϣ��</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>6</strong>����д������ѧ���ͽ�������ѧ����Ϣϵͳ(SEVIS)���</td>
                <td bgcolor="#FFFFFF" class="padding15">��д������I-20A-B�����Ÿ�F1ѧ������I-20M-N�����Ÿ�M-1ѧ����������ѧУָ����Ա��DSO���������˱���ǩ�֡�����ϵ������������������ϵ�������ȫһ�£����ѱ�������ѧ����������SEVISϵͳ�������鿴�����й�ѧ���ͽ�������ѧ����Ϣϵͳ(SEVIS)����Ϣ�� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>7</strong>��SEVIS���վݣ�</td>
                <td bgcolor="#FFFFFF" class="padding15">�����J, F �� M ��ǩ֤�����������ڱ���֧��ά��ѧ���ͽ�������ѧ����Ϣϵͳ��SEVIS���ķ��á�����ǰ����̸ʱЯ�����Ӱ��վݻ�I-797�վ�ԭ���������鿴���֧��SEVIS��</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>8</strong>�����й����ι�Լ������֤����</td>
                <td bgcolor="#FFFFFF" class="padding15">��ʾ���á���ᡢ��ͥ����������Լ�������ļ����԰�����֤��������������ͣ��������Ը�����й��� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>9</strong>���ʽ�֤����</td>
                <td bgcolor="#FFFFFF" class="padding15">֤�������������蹤������֧������ͣ�������ڼ�ķ���</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>10</strong>���о�/ѧϰ�ƻ���</td>
                <td bgcolor="#FFFFFF" class="padding15">�����ڼ�ƻ��õ�ѧϰ���о���������ϸ��Ϣ������������������ѧ�ĵ�ʦ��/��ϵ���ε����ּ������ʼ���ַ��</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>11</strong>�����˼�����</td>
                <td bgcolor="#FFFFFF" class="padding15">��ϸ��������ȥ��ѧ���͹�������ľ���������һ�����������µ��嵥��</td>
                </tr>
                
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>12</strong>����ʦ�ĸ���������ܣ�</td>
                <td bgcolor="#FFFFFF" class="padding15">�Ѿ���������ѧ�ﱻ�����˵�ʦ���о���Ӧ��������ʦ�ĸ���������ܡ���������ҳ��ӡ����</td>
                </tr>
                </table>
				</div>
                </li>
                <li>
				<div class="tit">
				<?php echo get_visa_info_title($visa_product,'ʵϰǩ֤(J-1)');?>
                </div>
                <div class="visa_list_content">
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
                <tr>
                <td width="167" bgcolor="#FFFFFF" class="paddingL"><strong>1</strong>����Ч���գ�</td>
                <td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ��ǩ֤֮ǰ������һ���»��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>2</strong>��DS-160���ȷ��ҳ��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������ע���������������������������ĵ籨�롢���ļ�ͥ��ַ����˾���ּ���ַ���뽫���ı��ȷ��ҳ���Ŵ�ӡ��A4ֽ�ϡ���̸ʱ��Я����ӡ������DS-160���ȷ��ҳ����Ҫʹ�ô����ȷ��ҳ�� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>3</strong>��һ����Ƭ��<br /></td>
                <td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա����������ƬҪ������͸��������������Ƭ���ڻ��շ����ϡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>4</strong>��ǩ֤������վ�ԭ����</td>
                <td bgcolor="#FFFFFF" class="padding15">���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>5</strong>�����գ�</td>
                <td bgcolor="#FFFFFF" class="padding15">������ǰ����ǩ֤�Ļ��գ�������ʧЧ�Ļ��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>6</strong>������/�о��ƻ���</td>
                <td bgcolor="#FFFFFF" class="padding15">�й��������ڼ佫Ҫ���µĹ������о�����ϸ������</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>7</strong>�����˼�����</td>
                <td bgcolor="#FFFFFF" class="padding15">��ϸ��������ȥ��ѧ���͹�������ľ���������һ�����������µ��嵥��</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>8</strong>���ر����</td>
                <td bgcolor="#FFFFFF" class="padding15">Blanket L-1��������Ҫ�ṩI-129S �������˾���������׼�飩��ԭ�������ݸ�ӡ���Լ� I-797���ӡ����</td>
                </tr>
                </table>
				</div>
                </li>
                <li>
				<div class="tit">
				<?php echo get_visa_info_title($visa_product,'����ǩ֤(H-1)');?>
                </div>
                <div class="visa_list_content">
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#dedede">
                <tr>
                <td width="167" bgcolor="#FFFFFF" class="paddingL"><strong>1</strong>����Ч���գ�</td>
                <td width="490" bgcolor="#FFFFFF" class="padding15">������Ļ��ս��ھ���Ԥ�Ƶ������ڵ��������ڹ��ڡ������𻵡����������޿հ׵�ǩ֤ǩ��ҳ, ����ǰ��ǩ֤֮ǰ������һ���»��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>2</strong>��DS-160���ȷ��ҳ��</td>
                <td bgcolor="#FFFFFF" class="padding15">��������ע���������������������������ĵ籨�롢���ļ�ͥ��ַ����˾���ּ���ַ���뽫���ı��ȷ��ҳ���Ŵ�ӡ��A4ֽ�ϡ���̸ʱ��Я����ӡ������DS-160���ȷ��ҳ����Ҫʹ�ô����ȷ��ҳ�� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>3</strong>��һ����Ƭ��<br /></td>
                <td bgcolor="#FFFFFF" class="padding15">��6�����������2Ӣ��x2Ӣ�磨51����x51���ף������ΰ�ɫ�����Ĳ�ɫ�����ա����������ƬҪ������͸��������������Ƭ���ڻ��շ����ϡ� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>4</strong>��ǩ֤������վ�ԭ����</td>
                <td bgcolor="#FFFFFF" class="padding15">���������Ի���ί���ҹ�˾�������������й����κη���֧��ǩ֤����ѣ�����Ҫ���վ��ý�ˮ����ճ����ȷ��ҳ���°�ҳ�ϡ�</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>5</strong>�����գ�</td>
                <td bgcolor="#FFFFFF" class="padding15">������ǰ����ǩ֤�Ļ��գ�������ʧЧ�Ļ��ա� </td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>6</strong>������/�о��ƻ���</td>
                <td bgcolor="#FFFFFF" class="padding15">�й��������ڼ佫Ҫ���µĹ������о�����ϸ������</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>7</strong>�����˼�����</td>
                <td bgcolor="#FFFFFF" class="padding15">��ϸ��������ȥ��ѧ���͹�������ľ���������һ�����������µ��嵥��</td>
                </tr>
                <tr>
                <td bgcolor="#FFFFFF" class="paddingL"><strong>8</strong>���ر����</td>
                <td bgcolor="#FFFFFF" class="padding15">Blanket L-1��������Ҫ�ṩI-129S �������˾���������׼�飩��ԭ�������ݸ�ӡ���Լ� I-797���ӡ����</td>
                </tr>
                </table>
				</div>
                </li>
                </ul>
            </div>
        </div>
        <div class="embassy"><!--ʹ�ݷ���-->
        	<h3>ʹ�ݷ���</h3>
            <ul>
            	<li style="height:60px;"><strong>����ʹ�ݣ�</strong>�����ڱ����У�����У�����ʡ���ӱ�ʡ������ʡ������ʡ������ʡ�����ɹ�������������ʡ�����Ļ�����������ɽ��ʡ��ɽ��ʡ������ʡ���ຣʡ���½�ά��������� ���ճ�����</a>
</li>
                <li><strong>����ʹ�ݣ�</strong>������ʡ���㶫ʡ������׳���������ͺ���ʡ ���ճ����� </li>
                <li><strong>�Ϻ�ʹ�ݣ�</strong>ֻ�����Ϻ��У�����ʡ������ʡ���㽭ʡ ���ճ�����</li>
				<li><strong>�������¹ݣ�</strong>������ʡ������ʡ������ʡ</li>
				<li><strong>�ɶ����¹ݣ�</strong>�Ĵ������죬���ϣ����ݣ�����</li>
				<li><strong>������¹ݣ�</strong>��ۺͰ��ŵ���</li>				
            </ul>
			<p>
			�й�����Ӧ�õ���Ͻ���ס�ص�������ʹ�ݻ����¹ݵݽ����룬�������ס���Ƿ��뻧��һ�£�ֻ�е��ʵ���ʹ������룬�õ�ǩ֤�Ļ��ʲŻ��������ס�ز���Ͼ�ס����������Ա��������ס��������룬�����ṩ���֤����
			</p>
        </div>
        <div class="faq_visa"><!--ǩ֤��������-->
        	<div class="tit">
            	<ul id="faq_visa_tit">
            	<li class="cur">ע������</li>
                <li>��ܰ��ʾ</li>
                <li>�����ʴ�</li>
                </ul>
            </div>
            <div  id="faq_visa_cont" class="cont">
            	<div>
            		<ul>
                    	<li><strong>1</strong>�����������ǩ֤�Ƿ���Գɹ���ȡ��������ʹ���ǩ֤�ٵ�ֱ����˽���������շ�����ǩ״����������Ӧ��Ȼ���ܴ˽��</li>
                    	<li><strong>2</strong>��" Ԥ�ƹ�����"Ϊ����ʹ��ǩ��ǩ֤ʱ����������µĴ���ʱ�䣻�� ������ԭ������ڡ�ʹ���ڲ���Ա������ǩ֤��ӡ�����ϵȣ����п��ܻ�����ӳٳ�ǩ��������������˸���ǩ֤Ԥ��������ʾ�������еĺ� ���ó̰�������ɵĿ��ܾ�����ʧ������˾���е��κ����Ρ�</li>
                    	<li><strong>3</strong>���й�ǩ֤�����Ϲ�����ǩ֤��Ч�ں�ͣ�������������ο������κη�����ŵ��һ�о�������ǩ֤��ǩ����ǩ֤����ΪΨһ���ݡ�</li>
                    	<li><strong>4</strong>��ǩ֤������Ӧ��ǩ֤��׼���ٹ����Ʊ��������ǰ�����Ʊ��ǩ֤δ����׼����ɵľ�����ʧ������Դ˲������Ρ�</li>
                    </ul>
                </div>
                <div style="display:none;">
            		<ul>
                    	<li><strong>1</strong>����˾����������յķ��񣬰����տ�ҵ����ֱ����ѯ���صİ��ֳ��뾳������</li>
                        <li><strong>2</strong>���������⼮����ǰ���й����⣬��ȷ�������г��е������ٴν����й���½����Чǩ֤��</li> 
                        <li><strong>3</strong>. ǩ֤δ�н���벻Ҫ����Ʊ������һ����ʧ�������������ге��� </li> 
                        <li><strong>4</strong>. ���и�ӡ����ͳһ��A4ֽ�����ӡ��</li> 
                        <li><strong>5</strong>����ס��һ����һ����ʵ�ʹ���������ĵط����ڸõض�������6���»�δ�����㳤�ڶ����õص������ˣ�������Ϊ�õصĳ�ס���������ס���뻧�����ڵػ���ǩ���ز������������Ӧ�ύ��֤����Ϊ��ס����Ĳ��ϣ���Ч��ס֤�������ͬ��������֤���ȣ���</li> 
                       
                    </ul>
                </div>
                <div style="display:none;">
				<dl>
					<dt>1.��̸ʱ��Щ�����ǽ�ֹЯ���ģ�</dt>
					<dd>
����������İ����ֻ�����������������Ӳ�Ʒ�Ͻ�Я�������¹ݡ�û��ǩ֤ԤԼ�ļ��ˡ�����Ҳ�������ڡ���Ҫ�����������������ǰ������������񴦣���������ϣ����ͬ��������̸�����������ڴ˵ȴ��� </dd>
				</dl>
				<dl>
					<dt>2.Ӧ�ں�ʱ���</dt>
					<dd>�벻Ҫ����ԤԼʱ��ǰ1Сʱ������ڵȺ��ҿռ����ޡ������������ڶ࣬��������Ҫ�Ⱥ�1Сʱ���ϣ���ʱ�����ڻ�����װҪ���塣</dd>
				</dl>
				<dl>
					<dt>3.��Ҫ���ɼ�ָ����</dt>
					<dd>���������������������˶��뱻�ɼ�ʮָָ�ơ��˹���Ѹ�١���ʹ�С���մȾīˮ���������ָ��������������Ȭ���󷵻�������������̸�������ܾ����ɼ�ָ�ƣ������޷��������ǩ֤��</dd>
				</dl>
				<dl>
					<dt>4.��̸ʱ��Ҫ˵Ӣ����</dt>
					<dd>���ܴ���������˶�˵Ӣ���ǩ֤��ԱͬʱҲͨ����ͨ������Ҫ���ѵ���ĳЩ�ض���ǩ֤������Ҫǩ֤��������Ӣ���������ڴ�����������ܾ�ʹ��Ӣ����̸�������ܲ�������Щǩ֤��Ҫ��</dd>
				</dl>
				<dl>
					<dt>5.ǩ֤���Ƿ�ᷭ�����еĲ��ϣ�</dt>
					<dd>�����ڸ���ǩ֤�ľ޴���Ҫ����ǩ֤�ٱ�����١���Ч�ع���������׼���ش���������Ƿǳ���Ҫ�ġ�������Я���κ�֧����ǩ֤����Ĳ��ϣ���Ҳ���½�ǩ֤��û�г�ֵ�ʱ�䷭�����в��ϡ�������ˣ����Ⲣ������������ҪЯ��������Ӧ�Ĳ��ϡ�</dd>
				</dl>
				<dl>
					<dt>6.ʲô��̽������ǩ֤��</dt>
					<dd>   ��������ǩ֤��B��2ǩ֤����B��2ǩ֤�䷢�����������ε������ˣ�������1.̽�׷��ѣ�2.���ι۹⣻3.��ҽ��4.����ͻ���¼�?�����������Ʋ����׵ȣ�5.�μӶ�Ů��ҵ��������6.�μӸ������ʵ����Ż��7.�μӸ���ҵ���Ե����ֻ���˶���ȡ�</dd>
				</dl>
				<dl>
					<dt>7.ʲô��ǩ֤����Ч�ڣ�</dt>
					<dd>
ǩ֤��Ч����ǩ֤��һ��ʮ����Ҫ�����ݡ�������������Ȩ����ǩ����ǩ֤�����϶��� ����Ч�ڡ�Ҳ����˵�� û����Ч�ڵ�ǩ֤�ǲ����ڵġ�ǩ֤��Ч�ڣ�����˵ǩ֤��ĳһ��ʱ������Ч�������� ���ʱ�䣬ǩ֤Ҳ�� ��Ч�ˡ����ԣ���������ĳ����������ǩ֤�������������������ڻ��ǩ֤���μ�ס ��ǩ֤����Ч�ڣ��� �ڸ���Ч���ڵִ�Ŀ�ĵء�</dd>
				</dl>
				<dl>
					<dt>8.ʲô��ǩ֤��ͣ���ڣ�</dt>
					<dd>ǩ֤��ͣ���ڣ���ָ׼��ǩ֤�������ǰ�����ң�������ͣ�������ޡ�����ǩ֤ҳ�ϵ� ��﷽ʽ�У� <br/>
��1��ÿ��ͣ��XX��Ӣ��Ϊ��DURATION OF EACH STAY����DAYS����DURATION OF STAY ����DAYS���� <br/>
��2��ͣ��������Ч����һ�µ�Ӣ��Ϊ��FROM����TO�������� <br/>
��3��׼��ͣ��XX��Ӣ��Ϊ��WITH A STAY OF ���� DAYS ������������ ����д������ ���֡� </dd>
				</dl>
				<dl>
					<dt>9. �����ľ�ǩ��������Щ��</dt>
					<dd>ǩ֤����޷����֣���ǩ���ǩ����ǩ��һ����ڻ����ϼӸ�ʹ�ݵ�ӡ�£��׳ƾ�ǩ�� ���Ա����˱�����ʹ�������û�з���ǩ֤��ʹ�ݾ�ǩ��ԭ����ֶ����������²�������м��֣�<br/> 
��1�����ϲ��뱸��ʹ��Ϊ�˾���������Ϊ���ض�ǩ֤��Ӱ�죬���Ĺ涨�˶�������� ��Ҫ�����������ϲ��룬����ɵ�Ӱ���ǣ�Ҫ�󲹲��ϻ��ǩ��<br/>
��2�����ϲ���ʵ��ʹ�������ʱ��Ҫȷ�����ṩ�Ĳ�����ʵ��������Ϊ���ϲ��� ʵ���ٷ�֮�ٻᱻ��ǩ�� <br/>
��3������Ŀ�Ĳ���ȷ����������ܻ������������ǩ֤���ݲ�һ�µĻ������ֶ� ������ǩ֤ȥ̽�ף�������������ȡ�ǩ֤�������������жϣ������Ǹ�������ԭ���������ڹ��� ��ְλ������̫�ͣ��ᱻ����Ĺ���������������������̫���ᣬ��ǣ�޹ң���������Ŀ����Խϴ� �������˼�ͥ����״�����ã���������������������ǿ����������ȵȡ� </dd>
				</dl>
				<dl>
					<dt>10. �ڹ��ⶺ���ڼ�ǩ֤�����ˣ�����ô�죿</dt>
					<dd>
����������������£�Ӧ����ǩ֤��Ч�ں�ͣ����֮�ڵ�����뿪ǰ�������������� �ڷǷ������������ߣ��п��ܱ���������������������������ȷ������ԭ��Ҫ���ӳ�ͣ������ ��Ӧ��ͣ����֮����ǰ��ǰ�����������������������롣������ɳ�֣����п��ܻ�׼���ڡ���� ������δ��ͣ����֮������������룬��ǩ֤��Ч�ں�ͣ���ھ������ڣ� ��������δ�뿪�ù������ �����Ӧ����Ч֤�����ϣ���������������� ��</dd>
				</dl>
				<dl>
					<dt>11.ʲô����ѧǩ֤��</dt>
					<dd>��������Ϊ������ѧ��Ա�ṩ�����ַ�����ǩ֤���"F" ǩ֤���Ÿ���������ѧ��ѧϰ����ѧ������"M" ǩ֤�򷢷Ÿ����з�ѧ����ְҵѧϰ����ѧ����Ҫ���ѧ��ǩ֤�������˱�����������һ������ѧУ��������ա����������պ�ѧУ��Ϊ��ǩ��һ��I-20�� I-20M���<br/>
      ���븰����ѧǩ֤�������˱�������֤���Լ���������������ȫ����ѧ���������˻�����֤�����������������ͣ����ΨһĿ�������ѽ�����ѧ���������ѧҵ�����⣬�����˻�����֤���Լ�������֧��ѧ�Ѻ���ѧ�ڼ������������á�</dd>
	  			</dl>
				<dl>
					<dt>12.ʲôʱ����Ҫ��ǩ��</dt>
					<dd>������ƻ�����������ʱ��������ǩ֤�ϵĵ����գ�����Ҫ�����µ�ǩ֤����ʹ��Ԥ��ͣ����������ʱ�䳬����ǩ֤�ϵĵ����գ�Ҳ����Ҫ��ǩ֤�����磬���ƻ���2005��10��5�ս�������������ǩ֤������Ϊ2005��10��11�գ���������Ҫ�µ�ǩ֤����Ϊ���ڵ�����֮�䵽������������ǩ֤��Ȼ��Ч��</dd>
				</dl>
				<dl>
					<dt>13.ʲô�Ƕ�������������дϵͳ��</dt>
					<dd>ȫ�������״���������DS�����дϵͳ��ֱ�ӶԽ�������ʹ�ݹ������ɿ��ٶ������ǩ֤�����д��ֱ�Ӵ�ӡDSȷ��ҳ����ǩʱ��Я����</dd>
				</dl>
				<dl>
					<dt>14.���ǵ����뺯��ǩ֤��ʲô������</dt>
					<dd>������һ��������ע��߱������뺯�ʸ�Ĺ�˾������ӵ�кϷ���������������������ִ��(ע���Registration #: 2110393-40�����������ݼ��Ժ�ٷ���վ���к�ʵ),��ӵ�кϷ�������������Ӫҵִ�գ�һֱ������������ҵ�ල��(better business bureau)Ȩ��������֤A+����������������������ǿ���Ϊ������������ʹ���Ͽɵ����뺯�����������Ĺ�ǩ�ʡ�</dd>
				</dl>
				<dl>
					<dt>15.ǩ֤�������̾����������ģ�</dt>
					<dd>ƾ��������ҵ���飬���ǵ�ǩ֤�Ŷӻ����������ͻ�����ҵ�ص㡢��ҵ������Ϊ��������רҵ����ݵ�ǩ֤��������Ϊ�ͻ���д�����DS��񡢴���ǩ֤�ѡ�ԤԼ��̸ʱ�䡢��̸��ѵ����̸��ͬ��ǩ֤��ǩ���͵ȵȶ������ĸ�Ч�ķ������̣��ÿͻ����Ŀ�ݵĻ��ǩ֤��</dd>
				</dl>
				<dl>
					<dt>16.��ǩ���˷���</dt>
					<dd>����ӵ��������ǩ֤ͨ���ʣ����ǲ��ų������������ǩ֤��ǩ�Ŀͻ���Ϊ���ų������ĺ��֮�ǣ�������ҹ�˾�����г̲��״ΰ���ǩ֤�Ŀͻ������о�ǩ��¼�Ŀͻ����⣩�����ǳ�ŵ�������Ϊ���ٴΰ���ǩ֤ҵ���Ա����������ǩ֤�������״β�����ǩ֤���ò����˻���</dd>
				</dl>
				
                </div>
            </div>
        </div>
    </div>
    <div id="right_wrap">
    	<div class="visa100"><!--����ǩ֤100%-->
       		<img src="/image/visa/<?php if(CHARSET=='big5'){ echo 'visa_100_big5.jpg';}else{echo 'visa_100.jpg';} ?>" alt="����ǩ֤100%" />
        </div>
        <div class="module prime"><!--���������������-->
        	<div class="tit_visa">���������������DS-160 </div>
            <div class="cont">
           	  <p class="aerobus">7X24Сʱ�ͷ����߰���</p>
                <dl>
                	<dt><img src="/image/visa/prime_dot1.gif" alt="ǩ֤����"/></dt>
                    <dd>����ֱ�ӶԽ�������ʹ��ϵͳ����<br />���ǩ֤���룬����ȴ�</dd>
                </dl>
                <dl>
                	<dt><img src="/image/visa/prime_dot2.gif" alt="�����ݵİ�������"/></dt>
                    <dd>�����ݵİ�������<br />���߲�������֧�����Ѹ��</dd>
                </dl>
                <dl>
                	<dt><img src="/image/visa/prime_dot3.gif" alt="רҵ����100%"/></dt>
                    <dd>רҵ����100%<br />רҵ�Ŷӱ������ĳ�ǩ��</dd>
                </dl>
                <dl style="border-bottom:none;">
                	<dt><img src="/image/visa/prime_dot4.gif"  alt="��˽����100%"/></dt>
                    <dd>��˽����100%<br />���ķ�Ʒ�Ʊ�֤����������˽</dd>
                </dl>
                
            </div>
        </div>
        <div class="module contact_visa"><!--��ϵ����-->
        	<div class="tit_visa">��ϵ����</div>
            <div class="cont">
            	<dl>
                	<dt class="s_1">�ܲ�:����</dt>
                    <dd>
                    	<ul>
                        	<li class="s1">�����ܻ�(60����)�� 1-626-898-7800</li>
                        	<?php /*<li class="s1">Tel��225-754-4326(����)</li>*/?>
                        	<li class="s1">������ѣ�1-888-887-2816</li>
                        	<li class="s2">Email��service@usitrip.com</li>
                        </ul>
                    </dd>
                </dl>
                <dl>
                	<dt class="s_2">�й���ѿͷ��绰</dt>
                    <dd>
                    	<ul>
                        	<li>4006-333-926</li>
                        	<li>�ܻ�(100����)��86-0755-2305-4633</li>
                        </ul>
                    </dd>
                </dl>
                <?php /*<dl style="border-bottom:none;">
                	<dt class="s_3">̨����ѿͷ��绰</dt>
                    <dd>
                    	<ul>
                        	<li>(02)4050-2999 ת 8991271816</li>
                        </ul>
                    </dd>*/ ?>
                </dl>
            </div>
        </div>
    </div>
</div>
<?php
echo db_to_html(ob_get_clean());
?>
   
  
	

<?php ob_start();?>
	<div id="abouts">
    	<?php
		require(DIR_FS_TEMPLATES . TEMPLATE_NAME .'/faq_left.php');
		?>
        <div class="abouts_right" id="right">
        	<div class="aboutsTit">
            	<ul>
                	<li>֧����ʽ</li>
                </ul>
            </div>
            <div class="aboutsCont ">
            	<div class="help5">
               	  <div class="dot">
                   	<h3>��Ԫ֧��</h3>
                      <ul class="paymentLinks">
					  <?php
						for ($i=0, $n=sizeof($_all_payments['USD']); $i<$n; $i++) {							
						?>
						  <li style=" <?= $_all_payments['USD'][$i]['width'];?>">
                              <p><a href="<?php echo tep_href_link('payment.php')?>#<?= $_all_payments['USD'][$i]['id']?>"><img alt="<?= $_all_payments['USD'][$i]['name']?>" src="/image/nav/<?= $_all_payments['USD'][$i]['id']?>.gif"></a></p>
                              <span><a href="<?php echo tep_href_link('payment.php')?>#<?= $_all_payments['USD'][$i]['id']?>"><?= $_all_payments['USD'][$i]['name']?></a></span>
                       	  </li>
						  <?php }?>
						  
                          <li>
                              <p><a href="<?php echo tep_href_link('payment.php')?>#western_union"><img alt="�������" src="/image/nav/western_union.gif"></a></p>
                              <span><a href="<?php echo tep_href_link('payment.php')?>#western_union">�������</a></span>
                       	  </li>
                          
                      </ul>
                    </div>
                  <div class="dot">
                   	<h3>�����֧��</h3>
                      <ul class="paymentLinks">
                       	<?php
						for ($i=0, $n=sizeof($_all_payments['CNY']); $i<$n; $i++) {	
						?>
						  <li>
                              <p><a href="<?php echo tep_href_link('payment.php')?>#<?= $_all_payments['CNY'][$i]['id']?>"><img alt="<?= $_all_payments['CNY'][$i]['name']?>" src="/image/nav/<?= $_all_payments['CNY'][$i]['id']?>.gif"></a></p>
                              <span><a href="<?php echo tep_href_link('payment.php')?>#<?= $_all_payments['CNY'][$i]['id']?>"><?= $_all_payments['CNY'][$i]['name']?></a></span>
                       	  </li>
						  <?php }?>
                          <li>
                              <p><a href="<?php echo tep_href_link('payment.php')?>#face_to_face"><img alt="���Ÿ���" src="/image/nav/face_to_face.gif"></a></p>
                              <span><a href="<?php echo tep_href_link('payment.php')?>#face_to_face">���Ÿ���</a></span>
                       	  </li>
                      </ul>
                    </div>
                   
				   <?php if(in_array('paypal_nvp_samples', $_all_payments_ids)){?>
				   <div class="content_h">
                   		<a name="paypal_nvp_samples" style="height:0;font-size:0;"></a>
                   		<h4 class="font_bold font_size14 color_blue">���ÿ�֧��</h4>
                        <p>���ǽ���Visa��MasterCard��American Express��Discover��ͬʱ���ǽ�����������Debit Card���������п��������ÿ�����֧����ͨ����ȫ�ֱ�ݵ�Paypalϵͳʵ�ֵģ�����ע���ΪPaypal�Ļ�Ա������ʹ�ø�֧����ʽ��ʵʱ���ˣ������κ������ѡ����⣬����վ��<a class="color_orange underline" target="_blank" href="https://seal.godaddy.com/verifySeal?sealID=Sw7SK8bpKlM5UcG9KesPbuhOlyKbqTQ85J99lyGiBVVfZRxR9Qcu">��װSSL֤��</a>�����ڱ���վ�ύ��֧����Ϣ��ͨ��256λ���ܺ��䡣<br />
�й���Visa �� Matercard �������������������<br />
1.�������ÿ�<br />
2.�ѿ�ͨ�������Ϲ���ҵ��</p>
                   </div>
				   <?php }?>
				   
                   <?php if(in_array('paypal', $_all_payments_ids)){?>
				   <div class="content_h ">
                   		<a name="paypal" style="height:0;font-size:0;"></a>
                   		<h4 class="font_bold font_size14 color_blue">PAYPAL֧�� </h4>
                        <p>������Ѿ���Paypal���û���������ֱ��ʹ�������ʻ���������֧����ʵʱ���ˣ����κ������ѡ�</p>
                   </div>
				   <?php }?>
				   
                    <?php if(in_array('moneyorder', $_all_payments_ids)){?>
					<div class="content_h">
                    	<a name="moneyorder" style="height:0;font-size:0;"></a>
                   		<h4 class="font_bold font_size14 color_blue">֧Ʊ֧�� </h4>
                        <p class="paddingB">���ո���֧Ʊ ��Personal Check������˾֧Ʊ ��Business Check�����ֽ�֧Ʊ��Money Order��������֧Ʊ ��Travel Check��������֧Ʊ ��Bank Check����</p>
						<p class="paddingB">�뽫֧Ʊ������<b><?= MODULE_PAYMENT_MONEYORDER_PAYTO?></b>
                        <p class="paddingB">(A).  ����Ǹ���֧Ʊ��˾֧Ʊ�������ʼ�֧Ʊ��ֻ����д<a class="color_orange underline" href="<?= tep_href_link('CheckDraftAuthorizationForm.pdf');?>">֧Ʊ֧����Ȩ��</a> ,�����ɨ���EMAIL�����ǵ�����service@usitrip.com ���ɡ�
						<a class="color_orange underline" href="<?= tep_href_link('CheckDraftAuthorizationForm.pdf');?>">Download ֧Ʊ֧����Ȩ��</a>
						
						</p>
                        <p>(B).  ������ֽ�֧Ʊ��Money Order��������֧Ʊ ��Travel Check��������֧Ʊ ��Bank Check���������ɨ���EMAIL�����ǵ�����service@usitrip.com �����뽫֧Ʊԭ��ͨ������ʼĸ����ǹ�˾��Unitedstars International Ltd.��133B W Garvey Ave, Monterey Park, CA, USA 91754</p>
                   </div>
				   <?php } ?>
				   
				   <?php if(in_array('cashdeposit', $_all_payments_ids)){?>
                    <div class="content_h">
                    	<a name="cashdeposit" style="height:0;font-size:0;"></a>
                   		<h4 class="font_bold font_size14 color_blue">����ת��/�ֽ���</h4>
                        <p class="paddingB">���٣�ʵʱ���ˣ������㣨�������ϲ�����ȥ���а�������ѡ�
����ͨ��ת�ˣ�Account Transfer������ֱ�Ӵ�Direct Deposit��ȥʵ�֡�</p>
                        <p class="paddingB">
						<?php if(0){ //ȡ���˺���ʾ?>
						���������<?= MODULE_PAYMENT_CASEDEPOSIT_BANKNAM?>���п���������ֱ��ת�˻�ֱ�Ӵ��ֽ����ǹ�˾<?= MODULE_PAYMENT_CASEDEPOSIT_BANKNAM?>�����˻���
						
						<br />
						Account Name: <b><?= MODULE_PAYMENT_CASEDEPOSIT_ACCNAM?></b>
						<br />
						Account #: <b><?= MODULE_PAYMENT_CASEDEPOSIT_ACCNUM?></b>
						<br />
						Routing Number�� <b><?= MODULE_PAYMENT_CASEDEPOSIT_ROUNUM?></b>
						</p>
                        
						<p class="paddingB">���������<?= MODULE_PAYMENT_CASEDEPOSIT_BANKNAM_1?>����������ֱ��ת�˻�ֱ�Ӵ��ֽ�����<?= MODULE_PAYMENT_CASEDEPOSIT_BANKNAM_1?>�����˻���<br />
						Account Name: <b><?= MODULE_PAYMENT_CASEDEPOSIT_ACCNAM_1?></b><br />
						Account��<b><?= MODULE_PAYMENT_CASEDEPOSIT_ACCNUM_1?></b> <br />
						Routing Number:  <b><?= MODULE_PAYMENT_CASEDEPOSIT_ROUNUM_1?></b></p>
						
						<p>���������Wells Fargo����������ֱ��ת�˻�ֱ�Ӵ��ֽ�����Wells Fargo�����˻���<br />
						Account Name: <b>Unitedstars International Ltd.</b><br />
						Account��<b>7296761336</b> <br />
						Routing Number:  <b>121000248</b>
						<?php }else{?>
						���������<?= MODULE_PAYMENT_CASEDEPOSIT_BANKNAM.'��'.MODULE_PAYMENT_CASEDEPOSIT_BANKNAM_1?>��Wells Fargo���п���������ֱ��ת�˻�ֱ�Ӵ��ֽ����ǹ�˾�����˻�����˾���ƣ�<b>Unitedstars International Ltd.</b>
						���������˻���Ϣ����ʱ���򱾹�˾��ȡ��лл��
						<?php
						}
						?>
						</p>
						
                   </div>
                   <?php }?>
                   
                  <div class="content_h">
                  	<?php if(in_array('banktransfer', $_all_payments_ids)){?>
						<a name="banktransfer" style="height:0;font-size:0;"></a>
                   		<h4 class="font_bold font_size14 color_blue">���е��</h4>
                        <p class="paddingB">������ͨ�����л��ķ�ʽ����֧�����߽�����ֱ�ӻ������ǵ��ʻ������ʱע�����Ķ����ţ��Ա����ǵĲ����ź˶ԡ���������������������ге���</p>
                        <p class="paddingB"><strong>A--���������ʻ���</strong> <br />
						Beneficiary Name ����������<b><?= MODULE_PAYMENT_BANKTRANSFER_ACCNAM?></b><br />
						<?php if(0){ //ȡ���˺���ʾ?>
						Beneficiary Account Number ���ʺţ���<b><?= MODULE_PAYMENT_BANKTRANSFER_ACCNUM?></b><br />
						ank Swift Code �����д��룩: <b><?= MODULE_PAYMENT_BANKTRANSFER_SORTCODE?></b><br />
						Bank ABA Number: <b><?= MODULE_PAYMENT_BANKTRANSFER_ROUNUM?></b><br />
						Receiving  Bank Name ���������֣���<b><?= MODULE_PAYMENT_BANKTRANSFER_BANKNAM?></b><br />
						Receiving Bank Address: �����е�ַ����<b><?= MODULE_PAYMENT_BANKTRANSFER_ADDRESS?></b><br />
						<?php }else{?>
						���������˻���Ϣ����ʱ���򱾹�˾��ȡ��лл��
						<?php }?>
						</p>
                    <?php }?>
					
					<?php if(in_array('transfer', $_all_payments_ids)){?>
					<a name="transfer" style="height:0;font-size:0;"></a>
                    <p class="paddingB"><strong>B--�й������ʻ���</strong><br />�й�����ת��     �����Բ��������������е�ֱ��ת�� �� ȥ���а���֧��ʱ����ǵô��ϱ������֤ԭ����
</p>
                    <table cellspacing="1" cellpadding="0" border="0" bgcolor="#f1f1f1" style="font-family:'����'">
                      <tbody><tr>
                        <td align="center" width="55" bgcolor="#3b70c7" class="color_fff">���ڵ�</td>
                        <td align="center" width="125" height="22" bgcolor="#3b70c7" class="color_fff">����</td>
                        <td align="center" width="198" bgcolor="#3b70c7" class="color_fff">������</td>
                        <td align="center" width="154" bgcolor="#3b70c7" class="color_fff">�����˺�</td>
                        <td align="center" width="54" bgcolor="#3b70c7" class="color_fff">�տ���</td>
                      </tr>
                      <?php
					  for($j=0, $n = sizeof($_transfers); $j<$n; $j++){
					  ?>
					  <tr>
                        <td align="center" height="42" bgcolor="#ffffff"><?= $_transfers[$j]['city'];?></td>
                        <td align="center" bgcolor="#ffffff"><a target="_blank" href="<?= $_transfers[$j]['href'];?>"><img border="0" src="/image/nav/<?= $_transfers[$j]['img'];?>" alt="<?= $_transfers[$j]['bank'];?>"></a></td>
                        <td align="left" bgcolor="#ffffff">&nbsp;<?= $_transfers[$j]['bank'];?></td>
                        <td align="left" bgcolor="#ffffff">&nbsp;<?= $_transfers[$j]['account'];?></td>
                        <td align="center" bgcolor="#ffffff">&nbsp;<?= $_transfers[$j]['payto'];?></td>
                      </tr>
					  <?php }?>
                    </tbody></table>
					
					<p class="paddingB"><strong>C--�й����ڶԹ��ʻ���</strong><br />
						��ʹ�����·�ʽ���
</p>
					<table cellspacing="1" cellpadding="0" border="0" bgcolor="#f1f1f1" style="font-family:'����'" width="100%">
					<tbody>
					<tbody><tr>
                        <td align="center" bgcolor="#3b70c7" class="color_fff">��˾����</td>
						<td height="22" align="center" bgcolor="#3b70c7" class="color_fff">������</td>
                        <td align="center" bgcolor="#3b70c7" class="color_fff">�����˺�</td>
                        
                      </tr>
					<tr>
						<td align="center" bgcolor="#ffffff"><b>���������������÷������޹�˾</b></td>
						<td height="42" align="center" bgcolor="#ffffff">&nbsp;<b>�й������������ڷ�������֧��</b></td>
						<td align="center" bgcolor="#ffffff">&nbsp;<b>4000026639202013164</b></td>
						
					</tr>
					</tbody>
					</table>
                    <?php }?>
					<p>��*���ڻ�����ϵ�������ķ��ͷ���Ա���Ա��������ķ��ɾ�����ոö���������Ϊ������г�Ԥ��*��<br />
���迪���й���Ʊ����֧����Ʊ����3%��˰�ѺͿ�ݷ��á�</p>
					
                  </div>
                    
					<div class="content_h ">
                    	<a name="face_to_face" style="height:0;font-size:0;"></a>
                   		<h4 class="font_bold font_size14 color_blue">���Ÿ���</h4>
                        <p>�й��ͷ�����<br />
                          ��ַ�������б�������������С��ҵ��ҵ�ܲ������δ��ţ��ǰ���ã�B1508��1510�� 518000<br />
                        �й���ѵ绰��400-6333-926</p>
                        <p>������<br />
                          ��������Monterey ParkӪҵ��<br />
                          ��ַ��133B W Garvey Ave, Monterey Park, CA 91754<br />
                          <br />
                          ��������Rowland HeightsӪҵ��<br />
                        ��ַ��17506 Colima Road, Suite 101, Rowland Heights, CA 91748 </p>
					</div>
				   
				   <?php if(in_array('alipay_direct_pay', $_all_payments_ids)){?>
                    <div class="content_h">
                    	<a name="alipay_direct_pay" style="height:0;font-size:0;"></a>
                   		<h4 class="font_bold font_size14 color_blue">֧�����˺ţ�<b><?= MODULE_PAYMENT_ALIPAY_DIRECT_PAY_EMAIL?></b></h4>
                        <p>1. ����ʹ��֧�����˺�ֱ��֧���� <br />2. Ҳ����ʹ�ù����������з��еĸ����ǿ������ÿ�</p>
                   </div>
				   <?php }?>
				   
                   <?php if(in_array('netpay', $_all_payments_ids)){?>
					<div class="content_h">
                    	<a name="netpay" style="height:0;font-size:0;"></a>
                   		<h4 class="font_bold font_size14 color_blue">��������֧����</h4>
                        <p>֧�ֹ����������з��еĸ����ǿ������ÿ�</p>
                   </div>
				   <?php }?>
				   
                   <div class="content_h">
                   		<a name="western_union" style="height:0;font-size:0;"></a>
						<h4 class="font_bold font_size14 color_blue">������� <span class="font_size12 noBold">����֧����ʽ��������������Ļ���</span></h4>
                        <p class="paddingB">�տ�����������(Gang), ��(Yu)<br /> 
�տ��˵绰��(001)225-7544328<br />
�տ��˵�ַ��133B W Garvey Ave, Monterey Park, CA, USA 91754<br /><br />
��*���ڻ�����ϵ�������ķ��ͷ���Ա���Ա��������ķ��ɾ�����ջ�����Ϊ������г�Ԥ��*��</p><p>
���취��<br />
1. Ѱ�Ҿͽ��������㣭�������ǰ�����������������㣨�磺�й��������й������������С�ũҵ���С�������еȣ�������ҵ��<br />
2. ��д������ȷ��д�������Ϣ���տ�����Ϣ��������ʾ��<br />
3. �ṩ��غ��룭�����ϣ���ϵ�������ķ��ͷ���Ա����֪�����ϵġ���غ��롱��MTCN#�����˺���Ϊ���ȡ����룬��ʱ��Ч�������Ʊ��ܻ��ݡ�
</p>
                   </div>
                   <div class="content_h ">
                   <strong class="color_orange font_size14">��˾����</strong><br />
  ��������ע���Ӫҵִ�գ�UNITED STATES OF AMERICA LICENSE�� ��������飬��ֱ����ϵ�ҹ�˾��
                   </div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("ul.paymentLinks li a").click(function(){
		var urlstr = this.href;
		var anchorstr = urlstr.split("#")[1];
		jQuery("a[name=" + anchorstr + "]").parent().siblings("div").removeClass("bg");
		jQuery("a[name=" + anchorstr + "]").parent().addClass("bg");
	});
});
</script>                 
                   
                </div>
            </div>
        </div>
    </div>

<?php echo  db_to_html(ob_get_clean());?>
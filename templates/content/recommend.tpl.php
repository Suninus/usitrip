<?php
ob_start();
?>
<div id="abouts">
<?php
		require(DIR_FS_TEMPLATES . TEMPLATE_NAME .'/about_left.php');
		?>
        <div class="abouts_right">
        	<div class="aboutsTit">
            	<ul>
                	<li>�����Ƽ�</li>
                </ul>
        </div>
            <div class="aboutsCont ">
                <div class="about8_1">
                	<ul>
                    	<li class="s_1">����Ϣ��������</li>
                    	<li class="s_2">���������ͬ�¼��������ǵ�������·�ɣ� ��������ͬ�¼����ѿ�<br />
��ù����ۿ��⣬��Ҳ�ܻ�����Ѷ�<strong class="color_orange">3%</strong>���Ƽ�ӵ��</li>
                    	<li class="s_3">��Ѽ��ˣ� ����������</li>
                    	<li class="s_4"><strong class="font_size14">��1����:</strong><a href="<?php echo tep_href_link(FILENAME_CREATE_ACCOUNT)?>"><em></em>����ע�����</a></li>
                    </ul>
                </div>
                <div class="about8_2">
                	<h4><strong class="color_blue font_size14">�����Ƽ�?</strong></h4>
                  <p>1�� ��������������վ���ע��ɻᣬ ����һ���ӡ�<br />
2�� ��Աע��ɹ��������������Ļ�Ա�ʺ�����һ���ۿۺţ�Coupon Code�����ʼ��Ƽ����������link�ȡ�<br />
3�� ������ͨ���绰�Ƽ��������κ��������Coupon Code, ���������ѹ������ǵ����β�Ʒʱ�������Coupon Code�����ɻ���Ż��ۿۡ�ͬʱ��ͨ����Coupon Code�������Ĺ���Ӷ�����������ʻ��<br />
4�� ���ʼ��Ƽ�ʱ�����ڻ�Ա�ʻ���ֱ�ӷ��͸�������ѡ� ��������ͨ���ʼ�link����������վ�������Ĺ���Ӷ��Ҳ����������ʻ��<br />
5�� ͬʱ��Ҳ�������Լ�����վ��blog��������̳���Ƽ����ǵ���վ��������·�����ϸ�����link��ÿ��ͨ����link����������վ�������Ĺ���Ӷ��Ҳ����������ʻ��<br />
6�� ��������ʱ�����Լ����ʻ��鿴�Լ���Ӷ���ȼ���ʷ��¼, ����Ӷ��ÿ����check��ʽ��paypalת�˷�ʽ����һ�Σ�ÿ�δ���$50��.</p>
                </div>
              
			  <?php if(!tep_not_null($customer_id)){?>
			  <form name="logform" id="logform"  action="<?php echo tep_href_link(FILENAME_LOGIN, 'action=process', 'SSL')?>"  method="POST" enctype="application/x-www-form-urlencoded" onsubmit="return validateFormData();">
			  <div class="about8_3">
           	  <h4><strong class="color_blue font_size14">��Ա��¼</strong></h4>
                    <p>��Ա���½,�������˻������ʹ���Ƽ�Link,�Ա�ϵͳ��¼����Ӷ��.�ǻ�Ա�ɵ��<a href="<?php echo tep_href_link(FILENAME_CREATE_ACCOUNT)?>" class="color_orange underline">���ע�����.</a></p>
                    <div class="logins">
                    	<dl>
                        	<dt>��½ID��</dt>
                            <dd><?php echo tep_draw_input_field('email_address',$account_value,' tabindex="1" class="box1 inset_shadow"  autocomplete="off" id="email" '.$input_style)?><span class="color_orange">*</span></dd>
                        </dl>
                        <dl>
                        	<dt>��¼���룺</dt>
                            <dd><?php echo tep_draw_password_field('password','','tabindex="2" id="password" class="box1 inset_shadow"  ')?><span class="color_orange">*</span></dd>
                        </dl>
                        <dl>
						<dt>&nbsp;</dt>	
						<dd>					
						<button type="submit" class="refer"><em></em><t>�� ��</t></button>
						</dd>
						</dl>
                    </div>
              </div>
			  </form>
			  <?php }?>
			  
   	      	</div>
        </div>
    </div>
    <?php echo db_to_html(ob_get_clean());?>
<div class="page-location"><?php echo HEADING_TITLE; ?></div>
<?php
ob_start();
echo tep_draw_form('password_forgotten', tep_href_link(FILENAME_PASSWORD_FORGOTTEN, 'action=process', 'SSL'));
?>
<div class="ui-checked-tab fix">
    <ul class="ui-checked-type">
        <li class="disabled" title="��δ��ͨ�ֻ���֤ƽ̨��"><label for="mobile"><input type="radio" name="checktype" id="mobile" disabled>�ֻ���֤</label></li>
        <li class="checked"><label for="email"><input type="radio" name="checktype" id="email" checked="checked">������֤</label></li>
    </ul>
    <div class="ui-checked-wrap">
    	<!--
    	<div id="J_Mobile">
        	<i class="role m"></i>
            <div class="m-box fix">
            	<p class="tips-text">������ͨ����Ч�İ��ֻ����õ�¼���롣</p>
                <div class="fp_form">
                	<form>
                    	<input type="text" class="fp_ipt" placeholder="���������󶨵��ֻ�����" />
                        <input type="button" class="fp_btn" value="�һ�����" />
                    </form>
                </div>
            </div>
        </div>
        -->
        <div id="J_Email">
        	<i class="role e"></i>
			<div class="e-box fix">
            <div id="ErrorMsg"></div>
            	<p class="tips-text">������ͨ����Ч�İ��������õ�¼���롣</p>
                <div class="fp_form">
						<?php  echo tep_draw_hidden_field('email_sms_post',"email",'id="email_sms_post_id"');?>
						<?php echo tep_draw_input_field('email_sms_input','','class="fp_ipt" placeholder="���������󶨵������ʺ�" '); ?>
                        <input type="submit" class="fp_btn" value="�һ�����" />
					
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php echo db_to_html(ob_get_clean());?>
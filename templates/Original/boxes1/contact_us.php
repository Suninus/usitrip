<?php
//��ϵ���� start{

$contact_phone = tep_get_us_contact_phone();

ob_start();
if($content=='index_default'){
//��ҳ satrt{
?>
<div id="contact_us_index" class="contact_warp border_1" style="overflow:hidden;">
        <!--��ϵ-->
        <div class="title_1">
          <p class="fr"><em class="color_blue font_size16 font_bold italic">7*24</em>&nbsp;&nbsp;Сʱ����</p>
          <h2 style="font-size:14px;">��ϵ��ʽ</h2>
        </div>
        <div class="cont">
          <ul class="list">
        <?php
		foreach($contact_phone as $key => $val){
		?>
		<li class="<?php echo $val['class']?> font_bold"><?php echo '<span>' . $val['name'] . '</span>' . $val['phone'];?></li>
		<?php
		}
		?>
        <li class="s_5"><span>�������䣺</span><em class="font_size14 color_blue font_bold"><?php echo STORE_OWNER_EMAIL_ADDRESS;?></em></li>
          </ul>
          <ul class="refer"><!-- WPA Button Begin --> <script type="text/javascript" src="http://static.b.qq.com/account/bizqq/js/wpa.js?type=9&kfuin=4006333926&ws=&btn1=%E5%87%BA%E5%A2%83%E6%97%85%E6%B8%B8%E9%A1%BE%E9%97%AE&btn2=7*24%E5%B0%8F%E6%97%B6%E5%9C%A8%E7%BA%BF%E5%92%A8%E8%AF%A2&tx=4&aty=0&a="></script> <!-- WPA Button END -->
          </ul>
        </div>
      </div>
<?php
//��ҳ end}
}else{
//����ҳ�� start}
?>
<div id="contact_us_other" class="contact_warp border_1 margin_b10">
      <!--��ϵ-->
      <div class="title_1">
        <p class="fr"><em class="color_blue font_size16 font_bold italic">7*24</em>&nbsp;&nbsp;Сʱ����</p>
        <h3 style="font-size:14px;">��ϵ��ʽ</h3>
      </div>
      <div class="cont">
        <ul class="list">
        <?php
		foreach($contact_phone as $key => $val){
		?>
		<li class="<?php echo $val['class']?> font_bold"><?php echo '<span>' . $val['name'] . '</span>' . $val['phone'];?></li>
		<?php
		}
		?>
        <li class="s_5"><span>�������䣺</span><em class="font_size14 color_blue font_bold"><?php echo STORE_OWNER_EMAIL_ADDRESS;?></em></li>
        </ul>
        <ul class="refer"><!-- WPA Button Begin --> <script type="text/javascript" src="http://static.b.qq.com/account/bizqq/js/wpa.js?type=9&kfuin=4006333926&ws=&btn1=%E5%87%BA%E5%A2%83%E6%97%85%E6%B8%B8%E9%A1%BE%E9%97%AE&btn2=7*24%E5%B0%8F%E6%97%B6%E5%9C%A8%E7%BA%BF%E5%92%A8%E8%AF%A2&tx=4&aty=0&a="></script> <!-- WPA Button END -->
        </ul>
      </div>
    </div>
<?php
}
//����ҳ�� end}

echo db_to_html(ob_get_clean());

//��ϵ����end}
?>

<?php
//overseas_study_fqa.php
//������ѧFAQ
ob_start();
?>
<div class="mate_warp border_1 margin_b10">
	<div class="title_1"><h3 class="left-side-title">������ѧ��������</h3></div>
    <ul class="studytour">
    	<li><a href="<?php echo tep_href_link('studytour.php')?>#st1">��α���������ѧ?</a></li>
        <li><a href="<?php echo tep_href_link('studytour.php')?>#st2">�μ���ѧ���������Щ����?</a></li>
        <li><a href="<?php echo tep_href_link('studytour.php')?>#st3">ѧ���ܴ�����Ӫ��ѧ��Щʲô?</a></li>
        <li><a href="<?php echo tep_href_link('studytour.php')?>#st4">��ѧ��Ӫ����������?����ϸ������?</a></li>
        <li><a href="<?php echo tep_href_link('studytour.php')?>#st11">�ҳ�����˽⺢���ھ����ѧϰ�������?</a></li>
        <li><a href="<?php echo tep_href_link('studytour.php')?>#st13">������ӪӪԱ�ļҳ��Ƿ��������?</a></li>
        <p class="more"><a href="<?php echo tep_href_link('studytour.php')?>" style="float:right;">&gt;&gt;�˽����</a></p>
    </ul>
</div>

<?php
echo db_to_html(ob_get_clean());
?>
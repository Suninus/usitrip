<?php
$use_advantages = true;
if($use_advantages == false){
	include (dirname(__FILE__).'/tours_info.php');
}else{


ob_start();
//���ǵ�����start{

?>
<?php $temp_href = tep_href_link('about_us.php'); $temp_href='http://208.109.123.18/web_action/2013_6youshi/';?>
      <div class="advantage_warp border_1 margin_b10 background_1"> 
          <div class="title_1">
            <h2><a href="<?php echo $temp_href?>" target="_blank">Ϊʲôѡ�����ķ�</a></h2>
          </div>
          <div class="cont">
            <ul>
              <li class="bg1"><a href="<?php echo $temp_href?>" target="_blank">�����ٷ���֤�������</a></li>
              <li class="bg2"><a href="<?php echo $temp_href?>" target="_blank">͸������ �ͼ۱�֤</a></li>
              <li class="bg3"><a href="<?php echo $temp_href?>" target="_blank">Ʒ����· ������ѡ</a></li>
              <li class="bg4"><a href="<?php echo $temp_href?>" target="_blank">��ȫ���� ��������</a></li>
              <li class="bg5"><a href="<?php echo $temp_href?>" target="_blank">רҵ�ͷ� ���ʷ���</a></li>
              <li class="bg6" style="border:none;"><a  href="<?php echo $temp_href?>" target="_blank">��Чǩ֤ ���ɳ���</a></li>
            </ul>
          </div>
	  </div>
<?php //���ǵ�����end }
echo db_to_html(ob_get_clean());

}
?>

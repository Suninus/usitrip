<?php
  require('includes/application_top.php');

  $breadcrumb->add(db_to_html('�Ƶ�Ԥ��'), tep_href_link('booking.php'));

  $content = 'booking';
  $off_corner_tl_tr = true;
	//seo��Ϣ
	$the_title = db_to_html('usitrip���ķ�������-����������_�������ξƵ�Ԥ��_�����Ƶ�Ԥ��_���ô�Ƶ깥��');
	$the_desc = db_to_html('Usitrip���ķ���������Ϊ��֪������������,Ϊȫ�����ṩ�������ξƵ�Ԥ��,�Ƶ�ס�޹���,�Ƶ��Ż���Ϣ,��������,���ô�,ŷ��,����,Ӣ��,�����,�¹�,���޵ȳ������ι���,������ʢ��,ŦԼ,�ѳ�,��˹ά��˹,��ɼ�,�κ���,�ɽ�ɽ,�׶�,Ϥ����������г���');
	$the_key_words = db_to_html('�������ξƵ�Ԥ��,�����Ƶ�Ԥ��,���ô�Ƶ���Ϣ,�Ƶ��Żݴ���');
	//seo��Ϣ end

  require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_FS_INCLUDES . 'application_bottom.php');


?>
<div class="proLeft">
<?php
//���ͬ��
if($cat_mnu_sel== 'vcpackages')$tabname='vp';
if($content=='index_products' || $content=='index_nested'){
	//include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'attractions.php');
	//��������Ѿ��Ƶ�ҳ���ұߵ�ɸѡ��ȥ�ˡ�
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'destinations.php');//�����ξ���鿴
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'departures.php');//���������в鿴
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'special.php');//�����ؼ�
	
	$display_all_departure_city = true;//����������п���
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'departures.php');//�����������
	//include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'travel_companion_box.php'); 
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'advantages.php');//���ǵ�����
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'contact_us.php');//��ϵ����

}else{
	if($content=='advanced_search_result'){
		include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'tours_theme.php');
		$display_all_departure_city = true;//����������п���
		include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'departures.php');//�����������
	}
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'travel_companion_box.php');
	
	
	//��ø������ķ���ֵ��Ʒ
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'email.php');
	//�������а�
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'my_tours.php');
	
	//for other page
	
	//include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'search2.php');
	//������ʶ 
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'tours_faq.php');
	//����������� notOK
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'view_history.php');
	//�ؼ���
	//include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'special.php');
	//ʲô�Ǵ��ˣ���γ�Ϊ���ˣ����˵ĺô�������ע�����ӣ�
	//include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'create_account.php');
	
	//����������֪
	//include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'tours_info.php');
	//���ǵ�����
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'advantages.php');
	//���ķ����ֵ���
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'vote_system.php');
	//��ϵ����
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'contact_us.php');
}

//С�����
include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'banner_box.php');
?>
</div>
    <div class="pathLinks">
        <?php
			$currPageName='';
			$curr_schtle = '';
			$category_breadcrumb = '';
			for ($ib=0, $nb=sizeof($breadcrumb->_trail); $ib<$nb; $ib++) {
				$link_class = '';
				if(($nb-1) != $ib){
					$link_class = ' class="breadlink_gray"';
					$category_breadcrumb .= '&nbsp;<a href="' . $breadcrumb->_trail[$ib]['link'] . '" '.$link_class.'>' . $breadcrumb->_trail[$ib]['title'] . '</a>&nbsp;';
					$category_breadcrumb .= '&gt;';
				}else{
					$category_breadcrumb .=  '&nbsp;<span>' . trim($breadcrumb->_trail[$ib]['title']) . '</span>';
					$curr_schtle = trim($breadcrumb->_trail[$ib]['title']);
					$currPageName =  $breadcrumb->_trail[$ib]['title'];
				}
			}
			echo '<p>'.$category_breadcrumb.'</p>';
			
		?>
      </div>
    <div class="proLeft">
<?php
	//������
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'search.php');
	/* ��¼������ʷ��COOKIE by lwkai add 2012-11-6 15:11*/
	?>
<script type="text/javascript">
lwkai.setCookie("search_history","<?php echo $js_save_cookie?>",true,31536000,'<?php echo CHARSET;?>');
</script>
	<?php
	/* ��¼������� */
	//С�����
	$search_banner = true; // ǿ�ƴ��������
	$banner_name = 'search_banner 265px';
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'banner_box.php');
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'special.php');//�����ؼ�
/*	if(!$isHotels && !$isCruises){	//�Ƶꡢ�����б�ȡ�����������������
		include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'departuresall.php');//�����������
	}
*/	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'advantages.php');//���ǵ�����
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'contact_us.php');//��ϵ����
?>
	</div>
    <div class="proRight">
      
	  <?php
	  	if(tep_not_null($excessKeyWordsTips)){
			echo '<div class="searchNoResult">'.$excessKeyWordsTips.'</div>';
		}
	  ?>
<?php include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'right_topadvert.php');//�����������?>
<div style=" height:10px; border-bottom:1px solid #C5E6F9;display:none;"></div>
<style>
.chooseCon{margin-top:0;}
</style>
<?php
	//������������ѡ��ģ��
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'search_search_mode.php');
	//��Ʒ�б�
	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'search_list_mode.php');
?>
	</div>
<?php
if($cPathOnly=="33"){	//������ ������� start
	//ѡ���������ĵ�����Ϊ���
	$hawaii_b_prod_ids = array();
	$hawaii_b_prod_ids[] = array('id'=>'370',
								'name'=>'������Ͽ�Ȳ�����,��˹ά��˹����ס�����ߵر�',
								'text'=>'�ι����С���������֮������������˹ά��˹��ӵ�й�ҵ�����ߴ����֮һ�����ĺ�����Ҳ���ݴ��');

	$hawaii_b_prod_ids[] = array('id'=>'1036',
								'name'=>'����������̴��ɽ����֮�� B (Ʒ����)',
								'text'=>'����ʮ�������������������ĵؽӣ�Ϊ���ṩ����Ʒ�ʵ�����֮�ã����Ҽӳ������������ӭ��...');
	
	
?>
	<div class="hawaii_pro">
	<?php
	//����ͼ
	$big_banner_hawaii = array('link'=> tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=2158'), 'img'=>'image/hawaii_banner_2.jpg');
	?>
	<a href="<?= $big_banner_hawaii['link']?>"><img width="580" height="220" src="<?= $big_banner_hawaii['img']?>" class="hawaii_banner"></a> 
	
		<div class="hawaii_two_pro" style="margin:0px;">
            <div class="two_pro_t_l"></div>
            <div class="two_pro_t_r"></div>
            <div class="two_pro_b_l"></div>
            <div class="two_pro_b_r"></div>
		<?php
			for($i=0; $i<count($hawaii_b_prod_ids); $i++){
		?>
		<p><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $hawaii_b_prod_ids[$i]['id']);?>"><?php echo db_to_html($hawaii_b_prod_ids[$i]['name'])?></a><br>
		<?php echo db_to_html($hawaii_b_prod_ids[$i]['text'])?>
		</p>
		<?php
			}
		?>
		
		</div>
	</div>
<?php	
}
//������ �������end
?>
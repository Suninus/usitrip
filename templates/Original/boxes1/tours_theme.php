   <?php
   //��������box start
   if($content=='index_default' || ($content=='advanced_search_result' && (int)$_GET['tours_type'])){
	   $class_tt='';
	   if($content=='advanced_search_result'){
		$class_tt=' class="left-side-title"';
	   }
   ?>
	    <h3 <?= $class_tt?>><?php echo db_to_html('��������')?></h3>
	    <div class="dongtai2">
	      <ul class="dongtai21">
	        <?php
			$english_sql = tep_db_query('SELECT categories_id FROM `categories`  WHERE categories_id="140" AND categories_status="1" limit 1');
			$english_row = tep_db_fetch_array($english_sql);
			if((int)$english_row['categories_id']){
			?>
			<li><a href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath='.(int)$english_row['categories_id'].'&mnu=tours');?>" ><?php echo db_to_html('ȫӢ����')?></a></li>
			<?php
			}
			?>
			
	  <li style="margin-left:30px;"><a href="<?php echo tep_href_link('advanced_search_result.php','tours_type=4&country=us-tours')?>" ><?php echo db_to_html('���ֶȼ�')?></a></li>
	  <li style="margin-left:41px;"><a href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=24_142_189&mnu=tours');?>" ><?php echo db_to_html('ֱ������')?></a></li>
       </ul>
        <ul class="dongtai3">
	        <li><a href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=24_142_31&mnu=tours');?>" ><?php echo db_to_html('�ɻ���')?></a></li>
	  <li style="margin-left:42px;"><a href="<?php echo tep_href_link('tour_question.php')?>" ><?php echo db_to_html('������')?></a>---<a href="<?php echo tep_href_link('tour_question.php')?>"><?php echo db_to_html('������Ի�����')?></a></li>
       </ul>
	      </div>
   <?php
   //��������box end
   }
   ?>       
       

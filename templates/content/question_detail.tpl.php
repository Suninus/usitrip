<?php ob_start();?>
	<div class="cui_wrap">
		<div class="cui_cmt_top">
			<div class="cui_cmt_hotkw">
				<dl>
					<dt>����������</dt>
					<dd>
					<?=$hit_key_string?$hit_key_string:''?>
					</dd>
				</dl>
			</div>
			<div class="cui_cmt_search">
				<h2>��ѯǰҲ��������һ�£����������Ƿ�Ҳ����ͬ��������</h2>
				<div class="cui_clearfix">
					<form action="<?php echo tep_href_link('all_question_answers.php')?>" method="get" name="question_search" id="question_search">
						<!--<input type="text" class="kw_input" placeholder="<?=('���������˽�����Ĺؼ���');?>" name="keyword"/>-->
						<?php $html_search_dafault_text = ('���������˽�����Ĺؼ���');echo tep_draw_input_field('keyword',$html_search_dafault_text, ' class="kw_input" onkeydown="this.style.color=\'#111\'" onblur="if(this.value==\'\'){this.value=\''.$html_search_dafault_text.'\';this.style.color=\'#ccc\'}" onfocus="if(this.value!=\''.$html_search_dafault_text.'\'){this.style.color=\'#111\'}else{this.value=\'\';this.style.color=\'#111\'}"   style="color: #ccc;"')?>
						<input type="submit" class="sh_button" value="����" />
							<input name="action" type="hidden" value="search" />
					</form>
				</div>
				<p>�йظ���Ĳ��ų������⣬�������̣�֧����ʽ���������������</p>
			</div>
		</div>
		<div class="cui_cmt_box">
			<div class="cui_cmt_cont cui_clearfix">
				<div class="cui_cmt_ask">
					<dl>
						<dt>
							<div class="cui_avator">
								<img src="<?php echo $head_img?>" alt="user icon" />
							</div>
							<p><?php echo (tep_db_output($question['customers_name']));?></p>
						</dt>
						<dd>
							<p class="cui_ask_question"><?php echo char2c((tep_db_output($question['question'])), tep_db_prepare_input($keyword), '#FF6600'); ?></p>
							<p class="cui_ask_from">
								��ѯ��Դ��<a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $question['products_id'])?>"><?php echo (tep_db_output($question['products_name']));?></a>
							</p>
							<p class="cui_ask_timer">
								<span><?php echo (date('Y-m-d H:i',strtotime($question['date'])));?></span>
							</p>
						</dd>
					</dl>
				</div>
				<div class="cui_cmt_abox">
					<i class="cui_role">&nbsp;</i>
					 <?php if(count($answers)>0){
					 $vin_default_comment_header ="/.*�𾴵�(.|\n)*?����.*(��|!).*\n+/";
					$vin_default_comment_footer= '/.*лл������ѯ(.|\n)*���ķ����ͷ���(.|\n)*www\.usitrip\.com.*/';	
				    foreach($answers as $answer_rows){
					$answer_rows['ans'] = preg_replace($vin_default_comment_header , '',$answer_rows['ans']);
					$answer_rows['ans'] = preg_replace($vin_default_comment_footer , '',$answer_rows['ans']);	
					$ans = auto_add_tff_links($answer_rows['ans']);
					if($question_ans['modified_by'] > 0){
						$replyName = tep_get_admin_customer_name($answer_rows['modified_by']);
					}else 
						$replyName = $answer_rows['replay_name'];
					}
					?>
					<div class="cui_cmt_answer">
						<div class="cui_answer_cont">
							<h4><?php echo (sprintf('�𾴵� %s�����ã���л�������ķ�����֧�֡�',tep_db_output($question['customers_name'])));?></h4>
							<p><?=nl2br(($ans))?></p>
							<p>
								<span><?php echo (tep_db_output($answer_rows['date']))?></span>
							</p>
						</div>
						<div class="cui_answer_service">
							<div class="cui_answer_avator">
								<img src="/image/nav/xlogo_15.gif" />
							</div>
							<p><?php //echo ('���ķ����ͷ�'.tep_db_output($replyName))?>���ķ������������</p>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
			
			<div class="cui_cmt_list cui_clearfix">
			<?php if($products_list){ ?>
				<div class="cui_recom_mod">
					<div class="cui_list_head">
						<h3>���ķ��Ƽ���·��</h3>
						<a href="#">&nbsp;</a>
					</div>
					<ul>
					<?php foreach($products_list as $product){?>
						<li><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['products_id'])?>" alt="<?php echo tep_db_output($product['name'])?>" title="<?php echo tep_db_output($product['name'])?>"><?php echo cutword(tep_db_output($product['name']),60)?></a><strong>
						<?php
						//price
						 $price_text = "";
 $tour_agency_opr_currency =
 tep_get_tour_agency_operate_currency($product['products_id']);
 if($tour_agency_opr_currency != 'USD' && $tour_agency_opr_currency != ''){
 $product['products_price'] =
 tep_get_tour_price_in_usd($product['products_price'],$tour_agency_opr_currency);
 }
 if (tep_get_products_special_price($product['products_id']))
 {
 $price_text.= '<del style="display:none">' .
 $currencies->display_price($product['products_price'],
 tep_get_tax_rate($product['products_tax_class_id'])) . '</del> <b>' .
 $currencies->display_price(tep_get_products_special_price($product['products_id']),
 tep_get_tax_rate($product['products_tax_class_id'])) . '</b>';
 }
 else
 {
 $price_text.= '<b>'.$currencies->display_price($product['products_price'],
 tep_get_tax_rate($product['products_tax_class_id'])).'</b>';
 }
 echo $price_text;
						
						?>
						</strong></li>
						<?php }?>
					</ul>
				</div>
				<?php }?>
				<div class="cui_related_mod">
					<div class="cui_list_head">
						<h3>
						<!-- ��<strong><?php echo ($question['question'])?></strong>�� -->
							������⣺
						</h3>
						<a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $question['products_id'].'mnu=reviews&seeAll=all-reviews&'.tep_get_all_get_params(array('info','mnu','rn','seeAll')))?>#anchor2">����&gt;&gt;</a>
					</div>
					<ul>
						<?php foreach($the_same_way as $value){?>
						<li><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $value['products_id'])?>"><?php echo cutword(tep_db_output($value['question']),60);?></a></li>
					<?php }?>
					</ul>
				</div>
				<div class="cui_questions_mod">
					<div class="cui_list_head">
						<h3>������ѯ�����б�</h3>
						<a href="<?php echo tep_href_link('all_question_answers.php')?>">����&gt;&gt;</a>
					</div>
					<ul>
					<?php foreach($the_new_way as $value){?>
						<li><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $value['products_id'])?>"><?php echo cutword(tep_db_output($value['question']),60);?></a></li>
					<?php }?>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php echo  db_to_html(ob_get_clean());?>
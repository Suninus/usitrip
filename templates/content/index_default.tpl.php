<?php
//������ʾ
if(strtotime(date('Y-m-d')) < strtotime('2013-02-16')){?>
	<div id="ServerSuspendTip">
		<div class="con">
			<?= db_to_html('�����ڼ䣨2��9��-15�գ�24Сʱ�ͷ������ճ����񣬾�����ѯ�����ķ���ף��λ������֡�����ʤ�⡢��;��죡');?>
		</div>
	</div>
<?php }?>
    <div id="in_left">
      <!--===============���===============-->
        <?php
		//������
		include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'search.php');
		//�������а�
		//include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'my_tours.php');
		//���ͬ��
		include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'travel_companion_box.php');
		//����{
		require('admin/includes/classes/T.class.php');
		require('admin/includes/classes/Raiders.class.php');
		$raiders=new Raiders;
		$raiders_list=$raiders->getList();
		//print_r($raiders_list);
		if($raiders_list){
		ob_start();
		?>
		<div class="usa_func border_1 margin_b10">
		<div class="title_1">
		<a target="_blank" style="color:#86888a;" class="fr color_gray" href="<?=tep_href_link('raiders_list.php')?>" title="�������ι���">����&gt;&gt;</a>
		<h2>�������ι���</h2>
		</div>
		<div class="cont">
		<ul>
		<?php foreach($raiders_list as $value){?>
		<li class="cfix"><a title="<?=$value['article_title']?>" href="<?=tep_href_link('raiders_info.php','parent_id='.$value['parent_id'].'type_id='.$value['article_type'].'&article_id='.$value['article_id'])?>"><?=cutword($value['article_title'], 28)?></a><span class="news_date"><?=date('m��d��',strtotime($value['add_time']))?></span></li>
		<?php }?>
		
		</ul>
		</div>
		</div>
		<?php 
		echo db_to_html(ob_get_clean());
		}
		//����}
		// ����
		include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'email.php');
		//��ϵ����
	  	include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'contact_us.php');
		?>
    </div>
	
    <?php //�м䲿�� start {?>
    <div id="in_right_imgbox">
      <?php
	  //�õ�Ƭ start{
	  $banner_obj = get_banners("Home Page Big 468x262");
	  ?>
	  <div class="foucus margin_b10">
        <!--����ͼ-->
        <div id="myjQuery">
          <div id="myjQueryContent">
            <?php
			$_class = '';//smask';
			for($i=0,$n=count($banner_obj);$i<$n;$i++){			
			?>
			<div class="<?php echo $_class;?>"><a href="<?php echo $banner_obj[$i]['links'];?>" target="_blank" title="<?php echo $banner_obj[$i]['alt'];?>"><img src="<?php echo $banner_obj[$i]['src'];?>" /></a></div>
            <?php
				$_class = '';
			}
			?>
          </div>
          <ul id="myjQueryNav">
            <?php
			$_class = 'current';
			for($i=0,$n=count($banner_obj);$i<$n;$i++){			
			?>
			<li class="<?php echo $_class;?>"><?php /*?><a href="javascript:void(0)"><?php echo $banner_obj[$i]['alt'];?></a><?php */?></li>
			<?php
				$_class = '';
			}
			?>
          </ul>
          <div class="bgUl"></div>
        </div>
      </div>
      </div>
      <?php
	  //�õ�Ƭ end }
	  ?>
	  <div id="in_center">
	  <?php
	  //�ؼ��ػ�ר��start {
	  $specials = Index::specials();
	  $buy2_get12 = Index::buy2_get_12();
	  //�Ź�
	  $group_buys = Index::group_buys();
	  if($specials!=false || $buy2_get12!=false || $group_buys){
	  	ob_start();
	  	$current = true;
	  ?>
	  <div class="sale_warp border_1 margin_b10">
        <!--�ؼ��������ػ�ר��-->
        <div class="title_1">
          <ul class="tabTits">
            <?php if ($specials != false){?><li<?php if ($current){?> class="current"<?php 
            $current = false;
            }?>><h2>�ؼ�����</h2></li><?php }?>
            <?php if ($buy2_get12 != false){?><li<?php if ($current){?> class="current"<?php 
            $current = false;
            }?>><h2>�ػ�ר��</h2></li><?php }?>
            <?php if ($group_buys){?>
            <li<?php if ($current){?> class="current"<?php 
            $current = false;
            }?>><h2>�����Ź�</h2><span class="arr_new"><img alt="" src="image/nav/arr_new.gif"/></span></li>
            <?php }?>
          </ul>
        </div>
        <div class="cont tabCons">
          <!--�ؼ�start-->
		<?php 
        $isshow = false;
        if ($specials) {
        	$isshow = true;
        ?>
		  <div>
            <div class="box1 cfix">
            <?php
			  //ǰ3���ؼ���ʾͼƬstart{
			  for($i=0; $i<3; $i++){
				  $_class = '';
				  if($i==2){
				  	$_class = 'noMargin';
				  }
			?>
			  <dl class="<?php echo $_class;?>">
                <dt><span class="icon fiveoff">5%OFF</span><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials[$i]['products_id']);?>">
				<?php 
                $specials[$i]['products_image'] = (stripos($specials[$i]['products_image'],'http://') === false ? 'images/':'') . $specials[$i]['products_image'];
                echo tep_image(get_thumbnails_fast($specials[$i]['products_image']), $specials[$i]['products_name']);
				?>
				</a></dt>
                <dd>
				  <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials[$i]['products_id']);?>" class="font_bold color_blue " title="<?php echo $specials[$i]['products_name']?>"><?php echo $specials[$i]['products_name']?></a>
                  <span class="font_bold color_orange"><?php echo preg_replace('/\..+/','',$currencies->display_price($specials[$i]['specials_new_products_price'],tep_get_tax_rate($specials[$i]['products_tax_class_id'])))?></span>
				  <span class="minderLine"><?php echo preg_replace('/\..+/','',$currencies->display_price($specials[$i]['products_price'], tep_get_tax_rate($specials[$i]['products_tax_class_id'])))?></span>
                  <span>ʡ<?php echo preg_replace('/\..+/','',$currencies->display_price(($specials[$i]['products_price']-$specials[$i]['specials_new_products_price']),tep_get_tax_rate($specials[$i]['products_tax_class_id'])))?></span>
                </dd>
              </dl>
            <?php
			  }
			  //ǰ3���ؼ���ʾͼƬend}
			?>
            </div>
            <div class="box2 cfix">
              <ul>
                <?php
				//��3���ؼ۲���ʾͼƬ start{
				for($i=$i; $i<min(6, sizeof($specials)); $i++){
				?>
				<li><span class="fr color_orange"><?php echo preg_replace('/\..+/','',$currencies->display_price($specials[$i]['specials_new_products_price'],tep_get_tax_rate($specials[$i]['products_tax_class_id'])))?>+</span><em>��</em><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials[$i]['products_id']);?>"><?php echo $specials[$i]['products_name']?></a></li>
                <?php
				}
				//��3���ؼ۲���ʾͼƬ end}
				?>
              </ul>
              <span style="float:right;"><a target="_blank" href="<?php echo tep_href_link(FILENAME_DEFAULT,'cPath=25&mnu=special');?>">�����ؼ���·&gt;&gt;</a></span>
            </div>
          </div>
          <?php }?>
          <!--�ؼ�end-->
		  <!--�ػ�start-->
		  <?php if ($buy2_get12) {?>
		  <div class="<?php if ($isshow){?>displayNone<?php }
		  $isshow = true;
		  ?>">
            <div class="box1 cfix">
              <?php
			  //ǰ3���ػ���ʾͼƬstart{
			  for($i=0, $_n = min(3, sizeof($buy2_get12)); $i<$_n; $i++){
				  $_class = '';
				  if($i==2){
				  	$_class = 'noMargin';
				  }
				  $_tClass = 't1';
				  if(strpos($buy2_get12[$i]['tour_type_icon'],'buy2-get-2') !== false){
					  $_tClass = 't2';
				  }
			?>

			  <dl class="<?php echo $_class;?>">
                <dt><span class="icon <?= $_tClass;?>"><?php echo $buy2_get12[$i]['tour_type_icon'];?></span><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $buy2_get12[$i]['products_id']);?>"><?php 
                $buy2_get12[$i]['products_image'] = (stripos($buy2_get12[$i]['products_image'],'http://') === false ? 'images/':'') . $buy2_get12[$i]['products_image'];
                echo tep_image(get_thumbnails_fast($buy2_get12[$i]['products_image']), $buy2_get12[$i]['products_name']) ;?></a></dt>
                <dd>
				<a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $buy2_get12[$i]['products_id']);?>" class="font_bold color_blue "><?php echo $buy2_get12[$i]['products_name']?></a>
                <span class="font_bold color_orange"><?php echo preg_replace('/\..+/','',$currencies->display_price($buy2_get12[$i]['products_price'], tep_get_tax_rate($buy2_get12[$i]['products_tax_class_id'])))?></span>
				</dd>
              </dl>
            <?php
			  }
			  //ǰ3���ػ���ʾͼƬend}
			?>
            </div>
            <div class="box2 cfix">
              <ul>
                <?php
				//��3���ػݲ���ʾͼƬ start{
				for($i=$i, $_n = min(6, sizeof($buy2_get12)); $i<$_n; $i++){
				?>
				<li><span class="fr color_orange"><?php echo preg_replace('/\..+/','',$currencies->display_price($buy2_get12[$i]['products_price'],tep_get_tax_rate($buy2_get12[$i]['products_tax_class_id'])))?>+</span><em>��</em><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $buy2_get12[$i]['products_id']);?>"><?php echo $buy2_get12[$i]['products_name']?></a></li>
                <?php
				}
				//��3���ػݲ���ʾͼƬ end}
				?>
              </ul>
            </div>
          </div>
          <?php }?>
		  <!--�ػ�end-->
		  <!-- �����Ź� -->
		  <?php if ($group_buys) {?>
          <div class="hot_tuan <?php if ($isshow){?>displayNone<?php }
		  $isshow = true;
		  ?>">
          <?php 
          $i=0;
          foreach ($group_buys as $key => $val) {?>
              <ul style="<?php if ($i==0){?> margin-right:12px;<?php
					$i++;
				 }?>" id="ProductsObj_<?=$val['products_id']?>">
                  <li class="s_1 color_blue"><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $val['products_id']);?>"><?php echo cutword($val['products_name'],80,'...')?></a></li>
                  <li class="s_2"><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $val['products_id']);?>">ȥ����</a><span style="color:#bfc1c2">�Ź��ۣ�</span><em class="color_orange" style="color:#fcc199;"><?php echo str_replace('.00','',$currencies->display_price($val['specials_new_products_price'],tep_get_tax_rate($val['products_tax_class_id'])));?></em></li>
                  <li class="s_3">
                    <p><span class="left">ԭ��</span><span class="center">�ۿ�</span><span class="right">��ʡ</span></p>
                    <p style=" border-bottom:0;"><span class="left minderLine italic"><?php echo str_replace('.00','',$currencies->display_price($val['products_price'],tep_get_tax_rate($val['products_tax_class_id'])));?></span><span class="center color_orange"><?php echo $val['Discount'];?></span><span class="right color_orange"><?php echo str_replace('.00','',$currencies->display_price($val['Savings'],tep_get_tax_rate($val['products_tax_class_id'])));?></span></p>
                  </li>
                  <li class="s_4"><span class="col999">ʣ��ʱ�䣺</span><span class="group_buys_span" id="CountDown<?= $val['products_id']?>">
                  <strong class="font_size14">3</strong>��<strong class="font_size14">10</strong>Сʱ<strong class="font_size14">4</strong>��<strong class="font_size14">35.0</strong>��
                  </span>
                  <script type="text/javascript">
					GruopBuyCountdown(<?= $val['products_id']?>, <?= $val['CountdownEndTime']?>,'CountDown<?= $val['products_id']?>','ProductsObj_<?=$val['products_id']?>');
				  </script>
                  </li>
            </ul>
            <?php }?>
            <div style="clear:both;"></div>
            <p class="tuan_more"><a href="<?php echo tep_href_link('group_buys.php');?>">�����Ź�·��&gt;&gt;</a></p>
        </div>
        <?php }?>
        <!-- �����Ź� end -->
        </div>
      </div>
      <?php
	  	echo db_to_html(ob_get_clean());
	  }
	  //�ؼ��ػ�ר��end }
	  ?>
	  
	<?php
	//�������а�start{
	$best_sellers = Index::best_sellers();
	if($best_sellers!=false){
		ob_start();
	?>
	  <div class="arrange_warp border_1 margin_b10">
        <!--�������а�-->
        <div class="title_1">
          <h2>�������а�<span class="my_hide"> �������β�Ʒ��������������</span></h2>
        </div>
        <div class="cont">
          <ul>
            <?php for($i=0, $n=min(5,sizeof($best_sellers)); $i<$n; $i++){?>
			<li class="s_<?php echo ($i+1);?>"><span class="color_orange fr"><?php echo str_replace('.00','',$currencies->display_price($best_sellers[$i]['products_price'],tep_get_tax_rate($best_sellers[$i]['products_tax_class_id'])))?>+</span><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers[$i]['products_id']);?>" title="<?php echo $best_sellers[$i]['products_name']?>"><?php echo $best_sellers[$i]['products_name']?></a></li>
            <?php }?>
          </ul>
        </div>
      </div>
	<?php
		echo db_to_html(ob_get_clean());
	}
	//�������а�end}
	?>
	<?php
	//�����Ƽ�start{
	//  ŦԼ       ��ʯ��԰       ��ɼ�      ��˹ά��˹      �ɽ�ɽ     ������   
	//55,35,29,32,30,33
	//55,33,29,32,30,35
	$hot_catalog_id = '55,33,29,32,30,35';
	$hot_recommend = Index::hot_recommend($hot_catalog_id);
	ob_start();
	if($hot_recommend!=false){
	?>  
      <div class="recommend_warp border_1 margin_b10">
        <!--�����Ƽ�-->
        <div class="title_1">
        <div class="xmenu" style="position:relative">
          <ul class="tabTits" style="position:absolute;">
            <?php 
			$_isOne = true;
			foreach((array)$hot_recommend as $key => $val){?>
			<li<?php if ($_isOne) {
						echo ' class="current"';
						$_isOne = false;
					  }
				?>><h3><span></span><?php echo $val['title'];?></h3></li>
            <?php }?>
          </ul>
          </div>
          <h2>�����Ƽ�</h2>
          <p style="display:"><a href="javascript:void(0)" id="rm_leftBtn" class="s_1">����</a><a id="rm_rightBtn" href="javascript:void(0)" class="s_2">����</a></p>
        </div>
        <script type="text/javascript">
		jQuery(document).ready(function() {
			var index = 0;
			var len = jQuery('.xmenu ul li').length;
			var margin = parseInt(jQuery('.xmenu li').eq(0).css('margin-left'),10) + parseInt(jQuery('.xmenu li').eq(0).css('margin-right'),10);
			var padding = parseInt(jQuery('.xmenu li').eq(0).css('padding-left'),10) + parseInt(jQuery('.xmenu li').eq(0).css('padding-right'),10);
			var lastWidth = jQuery('.xmenu li').eq(len - 1).width();
			var divLeft = jQuery('.xmenu').offset().left;
			var divWidth = jQuery('.xmenu').width();
			var staticLeft = 0; /*��¼����λ�� ��������� Ҫ��ס�������� �����ٹ���Ҫ�ۼ����� ��֮���ȥ��Ӧ��ֵ*/
			var fx = 'left'; /* �ж����ı�Ϊ�жϷ��� */
			/*  ��߰�ť */
			jQuery('#rm_leftBtn').click(function() {
				if (fx == 'left') {
					if (staticLeft > 0) {
						index --;
						jQuery('.xmenu').attr('index',index);
						staticLeft += jQuery('.xmenu li').eq(index).offset().left - divLeft;
						jQuery('.xmenu ul').animate({'left':staticLeft * -1});
					}
				} else {
					if (jQuery('.xmenu li').eq(0).offset().left < divLeft) {
						staticLeft -= jQuery('.xmenu li').eq(index).width() + padding + 3; 
						if (staticLeft < 0) {
							staticLeft = 0;
							fx = 'left';
							index = 0;
						} else {
							index --;
						}
						jQuery('.xmenu ul').animate({'left':staticLeft * -1});
						/*index --;*/
						
					}
				}
				jQuery('.xmenu').attr({'index' : index,'fx' : fx});
            });
			/*  �ұ߰�ť �����ж����ұߵ�һ������λ�� */
			jQuery('#rm_rightBtn').click(function() {
				if (fx == 'left') { /*�жϹ�������*/
					 /*������ұ�һ������߾� ��ȥ ��������߾� + �����ڲ������ⲹ�� ���� �����Ŀ�� ��ô����Ҫ�����ƶ�*/
					if ((jQuery('.xmenu li').eq(len - 1).offset().left - divLeft + lastWidth + padding + margin) > divWidth) {
						 /*�ƶ�ֵ����*/
						index ++;
						 /*ȡ�����һ��TAB����߾� - ������߾� + TAB������+���ⲹ���߾�  �����ж����һ���Ƿ��Ѿ���ʾ����һ��*/
						var lastRWidth = jQuery('.xmenu li').eq(len - 1).offset().left - divLeft + lastWidth + padding + margin;
						 /*������һ������߾�������� ���� �����ܿ�� ���� ��Ҫ�ƶ��ľ��� С�� ����Ŀ�� ��ֻ�ƶ�ʣ�µľ���*/
						if (lastRWidth > divWidth && (lastRWidth - divWidth) < (lastWidth + padding)) {
							 /*���ƶ���ʽ ��Ϊ��*/
							fx = 'right';
							 /*�����ƶ����������һ��*/
							index = len - 1;
							 /*��ԭ���Ѿ����Ƶ�ƫ�� �ټ� ��ǰҪ�ƶ����� */
							staticLeft += lastRWidth - divWidth;
						} else {
							 /*�˾��ʡ ֻ�ǵ���ʱ ���������Լ�������ֵ*/
							jQuery('.xmenu').attr('index',index);
							 /*����һ��TAB�߾� - ������߾� �õ���Ҫ���ƶ���ƫ���� - 3 ��Ϊ���������������� ������Ϊ����*/
							staticLeft += jQuery('.xmenu li').eq(index).offset().left - divLeft - 3; 
						}
						 /*ִ�ж��� �ƶ�����Ҫ��λ��*/
						jQuery('.xmenu ul').animate({'left':staticLeft * -1});
					}
				} else {
					if ((jQuery('.xmenu li').eq(len - 1).offset().left - divLeft + lastWidth + padding + margin) > divWidth && index < len - 1) {
						index ++;
						jQuery('.xmenu').attr('index',index);
						if (staticLeft == 0) {
							staticLeft = (jQuery('.xmenu li').eq(index).offset().left - divLeft + jQuery('.xmenu li').eq(index).width() + padding) - divWidth;
						} else {
							staticLeft += jQuery('.xmenu li').eq(index).width() + padding + margin;	
						}
						jQuery('.xmenu ul').animate({'left' : staticLeft * -1});
					}
				}
				jQuery('.xmenu').attr({'index' : index,'fx' : fx});
            });
            
            /*  ���hover�¼� ������ʾδ��ʾ������TABԪ��  */
            jQuery('.xmenu li').hover(
				function(){
					jQuery('.xmenu ul').stop(true,true);
					var curLeft = jQuery(this).offset().left;/*��ǰ������ȥ��Ԫ����߾���*/
					var curLiWidth = jQuery(this).width();/*��ǰԪ�صĿ��*/
					var right = curLeft - divLeft + curLiWidth + padding;
					var left = curLeft - divLeft;
					if ( right - divWidth > 0) { /*�����ǰԪ�ؼӱ����ȴ����������*/
						staticLeft += right - divWidth;
						index = jQuery('.xmenu li').index(jQuery(this));
						fx = 'right';
						jQuery('.xmenu ul').animate({'left' : staticLeft * -1});
					} else if (left < 0) { /*�����ǰԪ����߾� С�� ������߾�*/
						index = jQuery('.xmenu li').index(jQuery(this));
						fx = 'left';
						staticLeft += left;
						jQuery('.xmenu ul').animate({'left' : staticLeft * -1}); 
					}
					jQuery('.xmenu').attr({'index' : index,'fx' : fx});
					
				}
			);
        });
		</script>
        <div class="cont tabCons">
          <?php 
		  $_isOne = true;
		  foreach((array)$hot_recommend as $key => $val){
			$val['image'] = (stripos($val['image'],'http://') === false ? 'images/':'') . $val['image'];
		?>
		  <div <?php if ($_isOne) {$_isOne = false;} else { echo ' class="displayNone"';}?>>
            <dl>
              <dt><a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'cPath='.$val['cPath']);?>"><img src="<?php echo $val['image'];?>" alt="<?php echo $val['title'];?>����" /></a></dt>
              <dd><?php echo $val['title'];?>����</dd>
            </dl>
            <ul>
              <?php for($i=0, $n=sizeof($val['content']); $i<$n; $i++){?>
			  <li><span class="fr color_orange"><?php echo str_replace('.00','',$currencies->display_price($val['content'][$i]['products_price'],tep_get_tax_rate($val['content'][$i]['products_tax_class_id'])))?>+</span><em>��</em><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $val['content'][$i]['products_id']);?>"><?php echo $val['content'][$i]['products_name']?></a></li>
              <?php }?>
              <li class="text_r color_gray"><a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'cPath='.$val['cPath']);?>">����<?php echo $val['title'];?>��·&gt;&gt;</a></li>
            </ul>
          </div>
		  <?php }?>
        </div>
      </div>
	<?php
	}
	//ѹ�����
	$_html = db_to_html(ob_get_clean());
	echo preg_replace('/[[:space:]]+|(\/\*+[^\*]+\*?\*\/)/',' ', $_html);
	//�����Ƽ�end}
	?>  
	<?php 
	//�м���2 start {
	$banners2 = get_banners('Home Page2 470x93');
	?>	   
		   <div class="in_banner margin_b10">
			<?php 
			if(tep_not_null($banners2[0]['FinalCode'])){
				echo $banners2[0]['FinalCode'];
			}else{
			?>
			<a href="<?=$banners2[0]['links'];?>"><img border="0" alt="<?=$banners2[0]['alt'];?>" src="<?=$banners2[0]['src'];?>" /></a>
			<?php
			}
			?>
		  </div>
	<?php 
	//�м���2 end }
	?>  
	<?php 
	//�ͻ���ѯ �û����� ��Ƭ����{
	$questions = Index::question();
	$reviews = Index::reviews();
	$photos = Index::photos();
	ob_start();
	?>
	<div class="refer_warp border_1">
        <!--�ͻ���ѯ-->
        <div class="title_1">
          <ul class="fr color_gray">
            <li><a href="<?php echo tep_href_link('tour_question.php')?>">��Ҫ��ѯ</a></li>
            <li><a href="<?php echo tep_href_link('all_question_answers.php')?>">ȫ��</a></li>
          </ul>
          <h2>�ͻ���ѯ</h2>
        </div>
        <div class="cont">
          <ul>
            <?php foreach((array)$questions as $key => $question){?>
			<li><!--<em><?php echo tep_db_output($question['customers_name'])?>: </em>--><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'mnu=qanda&products_id=' . $question['products_id']);?>#anchor2" title="<?php echo tep_db_output($question['question'])?>"><?php echo tep_db_output($question['question'])?></a>
			<span><?php echo date('m/d/Y',strtotime($question['date']));?></span>
			</li>
            <?php }?>
          </ul>
        </div>
        <div class="title_2"> <span class="fr color_gray"><a href="<?php echo tep_href_link('reviews.php')?>">ȥ�����û���</a></span>
          <ul class="tabTits">
            <li class="current">�û�����</li>
            <?php /* ��Sofia����˼ ��Ƭ������ȥ�� <li>��Ƭ����</li> */ ?>
          </ul>
        </div>
        <div class="cont2 tabCons">
          <div>
            <?php
			$_class = '';
			foreach((array)$reviews as $key => $review){
			?>
			<dl class="<?php echo $_class;?> clearfix">
              <dt class="s_1">�����<br />
                <em><?php echo $review['rating_total']?>%</em></dt>
              <dt class="s_2"><?php echo tep_db_output($review['customers_name'])?>:</dt>
              <dd><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $review['products_id'].'&mnu=reviews');?>#two1"><?php echo tep_db_output($review['reviews_text'])?></a></dd>
              <div class="del_float"></div>
            </dl>
			<?php
				$_class = 'noBorder';
			}
			?>
          </div>
          <?php /* �� Sofia ����˼ ��������Ƭ����
          <div class="displayNone">
          	<ul style="width:100%"><?php for ($i = 0; $i < count($photos); $i++) {
            	echo '<li><div><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'mnu=photos&products_id=' . $photos[$i]['products_id']) . '#anchor2" target="_blank"><img src="' . $photos[$i]['img'] . '" /></a></div><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'mnu=photos&products_id=' . $photos[$i]['products_id']) . '#anchor2" target="_blank">' . $photos[$i]['image_title'] . '</a></li>';
				if ($i > 2) break;
             }?></ul><pre><?php #print_r($photos);?></pre> </div>*/ ?>
        </div>
		 
      </div>
	<?php 
	echo db_to_html(ob_get_clean());
	//�ͻ���ѯ �û����� ��Ƭ����}
	?> 
	 
    </div>
    <?php //�м䲿�� end }?>
	
    <div id="in_right">
      <!--===============�ұ�===============-->
      <?php
	  //�ҵ�����
	  include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'advantages.php');
	  ?>
            
	  
	  
      <?php
	  //�������� start {
	  //�������ε�����Ŀǰ�Ѿ����ô���
	  ob_start();
	  ?>
	  <!--����������-->
        <div class="mythos_warp margin_b10 border_1">
        	<div class="title_1">
                 <a target="_blank" style="color:#86888a;" class="fr color_gray" href="/web_action/zt_catalog_2013/">��������&gt;&gt;</a>
                 <h2>����������</h2>
	        </div>
            <div class="cont">
            	<ul>
                	<li><a href="/famous-city-school/packages/" target="_blank"><img src="image/nav/usa_main_01.jpg" alt="" /><p>������У</p></a></li>
                    <li><a href="/famous-shopping/packages/" target="_blank"><img src="image/nav/usa_main_02.jpg" alt="" /><p>��Ʒ����</p></a></li>
                    <li><a href="/theme-park/packages/" target="_blank"><img src="image/nav/usa_main_03.jpg" alt="" /><p>������԰</p></a></li>
                    <li><a href="/island-vacation/packages/" target="_blank"><img src="image/nav/usa_main_04.jpg" alt="" /><p>�����ȼ�</p></a></li>
                    <li><a href="/buy-get-free/packages/" target="_blank"><img src="image/nav/usa_main_05.jpg" alt="" /><p>ѧ���ػ�</p></a></li>
                    <li><a href="/honeymoon-tour/packages/" target="_blank"><img src="image/nav/usa_main_06.jpg" alt="" /><p>��������</p></a></li>
                </ul>
                <div style="clear:both;"></div>
            </div>
        </div> 	
        <!--���������� end-->        
       <?php if (0){?> 
	  <div class="mythos_warp margin_b10">
        <!--��������-->
        <div class="mythos_tit">
          <h2><span class="ztmore">����>></span>��������<span class="my_hide"> ��������ר���Ƽ�</span></h2>
        </div>
        <div class="cont">
          <dl id="foldingDL" class="color_gray folding">
          	<dt><a target="_blank" class="atitle" href="/web_action/googleapple/index.html">���ҹ��֮��!ƻ���ȸ��Ż�!</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/web_action/googleapple/index.html"><img src="images/theme_img4.jpg" /></a></dd>
            
			<dt><a target="_blank" class="atitle" href="/web_action/familyfun/index.html">������У�����Ρ��Ļ�Ѭ��֮��!</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/web_action/familyfun/index.html"><img src="images/qinziyou.jpg" /></a></dd>
            
			<dt><a target="_blank" class="atitle color_orange font_bold" href="/web_action/shopping/index.html">���������!��������let's��!</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle color_orange font_bold" href="/web_action/shopping/index.html"><img src="images/gouwuyou.jpg" /></a></dd>
 
 			<dt><a target="_blank" class="atitle" href="/florida-tours/packages/">�����������֮��</a></dt>
            <dd><a target="_blank" class="atitle" href="/florida-tours/packages/"><img src="images/florida_tours_packages_min.jpg" /></a></dd>
            
			<dt><a target="_blank" class="atitle" href="/zhuanti/ruzhuxixia/packages/">������ס��Ͽ��</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/ruzhuxixia-lvyou/packages/"><img src="images/xixiagu.jpg" /></a></dd>
            
			<dt><a target="_blank" class="atitle" href="/web_action/2013_6youshi/">6���ϣ���ת����</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/web_action/2013_6youshi/"><img src="images/6dabaozhang.jpg" /></a></dd>
            <dt><a target="_blank" class="atitle" href="/web_action/students/">2013��ѧ��������ѧ</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/web_action/students/"><img src="images/jiariyouxue.jpg" /></a></dd>
            <dt><a target="_blank" class="atitle" href="/web_action/a380_guangzhou/">A380�ж�����������ȡ�����</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/web_action/a380_guangzhou/"><img src="images/A380gouwu.jpg" /></a></dd>
            <dt><a target="_blank" class="atitle" href="/web_action/2013_new_year/">2013�기���촺������</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/web_action/2013_new_year/"><img src="images/chunjie.jpg" /></a></dd>
            <dt><a target="_blank" class="atitle" href="/web_action/year_award/">һ�λ������ս�Բ����������</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/web_action/year_award/"><img src="images/nianzhoujiang.jpg" /></a></dd>
            <dt><a target="_blank" class="atitle" href="/advanced_search_result.php?fcw=%CA%E4%C8%EB%B3%F6%B7%A2%B5%D8&tcw=%CA%E4%C8%EB%C4%BF%B5%C4%B5%D8&d=&w=%C8%FD%CD%ED%C0%AD%CB%B9">������ס��˹ά��˹</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/advanced_search_result.php?fcw=%CA%E4%C8%EB%B3%F6%B7%A2%B5%D8&tcw=%CA%E4%C8%EB%C4%BF%B5%C4%B5%D8&d=&w=%C8%FD%CD%ED%C0%AD%CB%B9"><img src="images/sanwanlasi.jpg" /></a></dd>
            <dt><a target="_blank" class="atitle" href="/web_action/xiaweiyi/">�����ģ������ȼٵ�����</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/web_action/xiaweiyi/"><img src="images/xiaweiyi.jpg" /></a></dd>
            <dt><a target="_blank" class="atitle" href="/web_action/2013yellow_stone/">2013��ʯ��԰�׷���</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/web_action/2013yellow_stone/"><img src="images/huangshi.jpg" /></a></dd>
            <!-- dt><a target="_blank" class="atitle" href="/tachunshangyinghua/">���ķ�̤����ӣ�������ػ�</a></dt-->
            <dd style="display:none"><a target="_blank" class="atitle" href="/tachunshangyinghua/"><img src="images/shanghua.jpg" /></a></dd>
            <dt><a target="_blank" class="atitle" href="/buy-get-free/packages/">���ķ�ѧ����-ȫ������</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/buy-get-free/packages/"><img src="images/chunjia.jpg" /></a></dd>	
            <dt><a target="_blank" class="atitle" href="/menpiao-lvyou/">�������⹫԰�ۿ���Ʊ</a></dt>
            <dd style="display:none"><a target="_blank" class="atitle" href="/menpiao/lvyou/"><img src="images/menpiao.jpg" /></a></dd>			
          </dl>
		  
          
        </div>
      </div>
      <?php
	  }
	  $_html = ob_get_clean();
	  echo db_to_html(preg_replace('/[[:space:]]+/',' ', $_html));
	  //�������� end }
	  ?>
	  <?php 
	  
	  //����� start{
	  ob_start();
	  ?>
	        <div class="affiche_warp border_1 background_1">
	          <!--�����(��4��)-->
	          <div class="title_1">
			  <a href="<?php echo tep_href_link('announce.php');?>" class="fr color_gray" style="color:#86888a;" target="_blank">����&gt;&gt;</a>
	            <h2>�����</h2>
	          </div>
	          <div class="cont">
	            <ul>
	  			<?php
	  			$announce_index = Index::get_latest_announce(8);
	  			for($i=0,$n=count($announce_index); $i<$n; $i++)
	  			{
	  			?>
	  			<li><em>��</em><a href="announce.php?id=<?php echo $announce_index[$i]['articles_id'];?>" title="<?php echo $announce_index[$i]['articles_name'];?>"><?php echo cutword($announce_index[$i]['articles_name'],26);?></a></li>
	  			<?php
	  			}
	  			?>
	            </ul>
	          </div>
	        </div>
	  	<?php 
	  	echo db_to_html(ob_get_clean());
	  	//����� end}
	  ?>
      <?php
	  //�ұ߹���� start{
	  $_tag1 = "Home Page Right 1";
	  $_tag2 = "Home Page Right 2";
	  $bannersR1 = get_banners($_tag1);
	  $bannersR2 = get_banners($_tag2);
	  ?>
	  <div class="banner_warp margin_b10">
        <!--�����-->
        <?php 
		for($i=0, $n=sizeof($bannersR1); $i<$n; $i++){
			if(tep_not_null($bannersR1[$i]['FinalCode'])){
				echo $bannersR1[$i]['FinalCode'];
			}else{
			?>
			<a href="<?=$bannersR1[$i]['links'];?>" tag="<?= $_tag1?>" target="_blank"><img border="0" alt="<?=$bannersR1[$i]['alt'];?>" src="<?=$bannersR1[$i]['src'];?>" /></a>
			<?php
			}
		}
		?>
        <?php 
		for($i=0, $n=sizeof($bannersR2); $i<$n; $i++){
			if(tep_not_null($bannersR2[$i]['FinalCode'])){
				echo $bannersR2[$i]['FinalCode'];
			}else{
			?>
			<a href="<?=$bannersR2[$i]['links'];?>" tag="<?= $_tag2?>" target="_blank"><img border="0" alt="<?=$bannersR2[$i]['alt'];?>" src="<?=$bannersR2[$i]['src'];?>" /></a>
			<?php
			}
		}
		?>
		</div>      
      <?php
	  //�ұ߹���� end}
	  ?>
	  
	  
	  
	<?php
	//����ָ�� start{
	ob_start();	  
	?>
      <div class="enchiridion_warp border_1 margin_b10 background_1">
        <!--����ָ��-->
        <div class="title_1">
          <h2>����ָ��</h2>
        </div>
        <div class="cont">
          <ul>
            <li class="s_1"><a href="#">����ʱ��</a></li>
            <li class="s_2"><a href="#">����Ԥ��</a></li>
            <li class="s_3"><a href="#">��ѹ��ͷ</a></li>
            <li class="s_4"><a href="#">�����ͼ</a></li>
            <li class="s_5"><a href="#">����ָ��</a></li>
            <li class="s_6"><a href="#">������</a></li>
          </ul>
        </div>
      </div>
	<?php
	db_to_html(ob_get_clean());
	//�ݲ���ʾ
	//����ָ�� end}
	?>
	<?php 
	
	//���Ź�ʱ�Ĺ��Ŀ� start {
	if($group_buys == false){
		$_tag = 'index_right_down';
		$bannersR3 = get_banners($_tag);
		if($bannersR3){
	?>
	<div class="banner_warp margin_b10" tag="<?= $_tag;?>" style="height:202px;">
        <!--�����-->
        <?php 
		if(tep_not_null($bannersR3[0]['FinalCode'])){
			echo $bannersR3[0]['FinalCode'];
		}else{
		?>
		<a href="<?=$bannersR3[0]['links'];?>"><img border="0" alt="<?=$bannersR3[0]['alt'];?>" src="<?=$bannersR3[0]['src'];?>" /></a>
		<?php
		}
		?>
		</div>
	<?php	
		}
	}
	//���Ź�ʱ�Ĺ��Ŀ� end }
	
	?>
	  
    </div>
    <div class="del_float"></div>

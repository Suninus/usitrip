<?php ob_start();?>
<div id="footpage">
	<div id="abouts">
    	<div class="abouts_left" id="left">
        	<div class="left_func">
                <!-- ���Ա��� -->
				<?php foreach($type_info as $value){?>
                <div class="func_list">
				
                    <h2><a <?php if($value['type_id']==$parent_id)echo 'class="click"';?> href="<?= tep_href_link('raiders_list.php','parent_id='.$value['type_id']);?>"><?=$value['type_name']?>����</a></h2>
                    <ul>
						<?php foreach($value['son'] as $v){?>
                        <li><a <?php if($v['type_id']==$type_id)echo 'class="click"';?> href="<?= tep_href_link('raiders_list.php','type_id='.$v['type_id'].'&parent_id='.$value['type_id']);?>"><?=$v['type_name']?>����<b>></b></a></li>
						<?php }?>
                    </ul>
                </div>
				<?php }?>
            </div>
        	
            <!-- ����ר�� -->
            <div class="lastest_action">
            	<h2>����ר��</h2>
                <ul>
				  <?php
	  //�ұ߹���� start{
	  $_tag1 = "raiders_banner_1";
	  $_tag2 = "raiders_banner_2";
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
			<li><a href="<?=$bannersR1[$i]['links'];?>" tag="<?= $_tag1?>" target="_blank"><img border="0" alt="<?=$bannersR1[$i]['alt'];?>" src="<?=$bannersR1[$i]['src'];?>" /></a></li>
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
			<li><a href="<?=$bannersR2[$i]['links'];?>" tag="<?= $_tag1?>" target="_blank"><img border="0" alt="<?=$bannersR2[$i]['alt'];?>" src="<?=$bannersR2[$i]['src'];?>" /></a></li>
			<?php
			}
		}
		?>
                <!--	<li><a href="" target="_blank"><img src="http://www.xiaoming.com/image/nav/abouts_img4.jpg" alt="" /></a></li>
                    <li><a href="" target="_blank"><img src="http://www.xiaoming.com/image/nav/abouts_img4.jpg" alt="" /></a></li>-->
                </ul>
            </div>
            <!-- ����ר�� end -->
            
            <!-- �������� -->
            <div class="arrange_warp cfix">
                <div class="title_1"><h2>�������а�</h2></div>
                    <div class="cont">
                        <ul>
						<?php foreach($best_sell as $value){?>
                            <li class="s_1"><span class="color_orange fr">$<?php echo (int)$value['products_price']?>+</span><a title="<?=$value['products_name']?>" href="<?=tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $value['products_id'])?>"><?=$value['products_name']?></a></li>
							<?php }?>
                       </ul>
                    </div>
              </div>
  </div>  
    
        <div class="abouts_right" id="right">
        	<div class="aboutsTit">
            	<ul>
                	<li><?=$type_name?>����</li>
                </ul>
            </div>
            <div class="aboutsCont ">
            	<div class="func_cont_list cifx">
                	<!-- ���±��� -->
                	<h1 class="gl_title"><?=$info['info']['article_title']?></h1>
                    <p class="gl_from"><span>����ʱ�䣺<?=date('Y-m-d',strtotime($info['info']['add_time']))?></span><span class="blank"></span><span>��Դ�ڣ�<?=$info['info']['article_from']?></span></p>
                    <!-- ���±��� end -->
                    
                   	<!-- �������� -->
                    <div class="article_cont">
                    	<?=$info['info']['article_content']?>
                    </div>
                    <!-- �������� end  -->
                    
                    <div class="article_about">
                    	<p class="art_search">���������<?php foreach($info['tags'] as $value){?><a href="<?=RaidersTags::checkTagsUrl($value['tags_url'])?>" target="_blank"><?=$value['tags_name']?></a><?php }?></p>
                        <p class="art_pn cfix">
                        	<span class="art_prev">��һƪ��<?php if($info['ago']){?><a href="<?=tep_href_link('raiders_info.php','parent_id='.$parent_id.'&type_id='.$type_id.'&article_id='.$info['ago']['article_id'])?>"><?=$info['ago']['article_title']?></a><?php }else{echo 'û����!!!';}?></span>
                            <span class="art_next">��һƪ��<?php if($info['after']){?><a href="<?=tep_href_link('raiders_info.php','parent_id='.$parent_id.'&type_id='.$type_id.'&article_id='.$info['after']['article_id'])?>"><?=$info['after']['article_title']?></a><?php }else{echo 'û����!!!';}?></span>
                        </p>
                    </div>
                    
                    <div class="cfix">
                    <!-- Baidu Button BEGIN -->
                    	<span class="share_title">������</span>
                        <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
                        <a class="bds_qzone">QQ�ռ�</a>
                        <a class="bds_tsina">����΢��</a>
                        <a class="bds_tqq">��Ѷ΢��</a>
                        <a class="bds_renren">������</a>
                        <a class="bds_t163">����΢��</a>
                        <span class="bds_more">����</span>
                        <a class="shareCount"></a>
                        </div>
                        <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=18719" ></script>
                        <script type="text/javascript" id="bdshell_js"></script>
                        <script type="text/javascript">
                        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
                        </script>
					<!-- Baidu Button END -->
                    </div> 
                </div>
            </div>
            <!-- ����Ƽ� -->
            <div class="recom_box">
                <h2 class="recom_title">�Ƽ��������</h2>
                <ul>
				<?php foreach($recommend as $value){?>
                    <li class="fl"><em>��</em><a href="<?=tep_href_link('raiders_info.php','parent_id='.$parent_id.'&type_id='.$value['article_type'].'&article_id='.$value['article_id'])?>"><?=$value['article_title']?></a></li>
					<?php }?>
                </ul>
            </div>
            <!-- ����Ƽ� end -->
        </div>
    </div>

</div>
<?php echo  db_to_html(ob_get_clean());?>
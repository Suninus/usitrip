<?php ob_start();?>
<link href="templates/Original/page_css/index-min.css"  rel="stylesheet" type="text/css" />
<link href="templates/Original/page_css/jiathis_share.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.productLeftAd{float:left}
.timeColor{color:#0063db;}
</style>

<?php
//����ʾ��� 
$search_banner = true;
//С�����
$banner_name = 'group_buys_big';
include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'banner_box.php');
// echo '<div>';
// //С�����
// $banner_name = 'group_buys_1';
// include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'banner_box.php');
// //С�����
// $banner_name = 'group_buys_2';
// include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'banner_box.php');
// //С�����
// $banner_name = 'group_buys_3';
// include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'banner_box.php');
// //С�����
// $banner_name = 'group_buys_4';
// include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'banner_box.php');?>
<!-- <div style="clear:both"></div> -->
<!-- </div> -->
<div class="bulk">
        	<div class="bulkLeft">
<?php
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
	$page = 1;
}
foreach((array)$datas1 as $key => $pInfo){
?>
            	<div class="bulkBox" id="ProductsObj_<?=$pInfo['products_id']?>">
            		<a name="to_<?=$pInfo['products_id']?>"></a>
                	<div class="base num<?= ($key+1)+($max_rows_page*($page-1));?>"></div>
                	<div class="tit" style="margin-top:-80px;">
                		<h2><span>�����Ź���</span><a target="_blank" href="<?= tep_href_link('product_info.php','products_id='.$pInfo['products_id'])?>"><?= $pInfo['products_name']?></a></h2>
                        <p>
						<a href="javascript:void(0)" class="colorfd9300 underline fr">�Ź���֪<span class="con" style="color:#000000"><i class="a tips"></i>1.���ǻᰴ���Ź��ϵ�ʱ��׼ʱ���ţ�������Ԥ��ǰ������һ����ϸ�Ķ����ǵĳ���ʱ�䣬�����������г̷�����ͻ�������������㡣<br/>
2.�˴������Ź��Żݣ��������������Ƶģ�Ϊ��ȷ��������Ը�����Ź���ֵ֮�ã��ǵ�һ��ץ��ʱ��Ԥ��������˿��ܾͲ�����Ŷ!<br/>
3.�Ź���Ʒ�����������Ż�ͬʱ���ܣ�����̫̰��Ŷ!<br/>
˵������������Ź���·�����������������������Բ���绰4006-333-926,���д�������Ԥ�����������ǻ���������Ŷ��ر�İ���,������Ż��Լ�����ľ�ϲ��������</span></a>
						<?= $pInfo['products_name1']?>
						</p>
                    </div>
              	<div class="pro">
              			
                    	<div class="proDalet">
                    	<div class="snapping">
                            	<dl>
                                	<dt><?= $pInfo['priceTag']?></dt>
                                    <dd><a href="<?= tep_href_link('product_info.php','products_id='.$pInfo['products_id'])?>"><img src="/image/bulk/<?= CHARSET?>.bulk_dot8.gif"/></a></dd>
                                </dl>
                  </div>
                            <div class="proDalet1">
                       	  <div class="proDalet1_1 underlines">
                                	<ul>
                                    	<li><span>ԭ��</span><?= $pInfo['oldPrice']?></li>
                                    	<li><span>�ۿ�</span><?= $pInfo['Discount']?></li>
                                    	<li><span>��ʡ</span><?= $pInfo['Save']?></li>
                                    </ul>
                                </div>
                           	  <div class="proDalet1_2 underlines" title="<?= $pInfo['display_start_days']?>">����ʱ�䣺<?php
                           	  $date_arr = array();
                           	  if (preg_match("/([^:]+:\s*[^\s]*)([^$]*)$/",$pInfo['display_start_days'],$matchs)){
								if (empty($matchs[2])){
									echo $pInfo['display_start_days'];
									$date_arr[] = $pInfo['display_start_days'];
								} else {
									echo $matchs[1];
									$date_arr[] = $matchs[1];
									$date_arr[] = $matchs[2];
								}
							 } else {
								$temp = explode("��",$pInfo['display_start_days']);
								if (count($temp) > 2) {
									echo join("��",array_slice($temp, 0 , 2)) . "...";
								} else {
									echo $pInfo['display_start_days'];
								}
							 }
                           	 // = $pInfo['display_start_days']?></div>
                       	  <div class="proDalet1_3 underlines" style="text-align:right">
                                	<!--<p>��<span>40</span>��  ��ʣ<em>34</em>�ˣ�</p>-->
                                    <!-- �������ޣ����������� -->
                                    <span style="color:#fd9300;font-size:24px;font-weight:bold"><?php 
                                    $purchasedNum = tep_get_product_orders_guest_count($pInfo['products_id'],'',$Today_date);
                                    //����Ѿ���������20���ڴ˻�����20�ˣ��൱�������
                                    if($purchasedNum<20){
                                    	$purchasedNum += 20;
                                    }
                                    echo $purchasedNum;
                                    ?>��</span>����
                                </div>
                       	  <div class="proDalet1_4">
                                	<span>ʣ��ʱ��</span>
                                    <p id="CountDown<?= $pInfo['products_id']?>" style="color: #FF7000;font-size:16px;"><strong>0</strong>��<strong>0</strong>Сʱ<strong>0</strong>��<strong>0</strong>��</p>
		<?php //�����JS���벻�����ƶ��������ط��������ʱƫ��̫��?>
		  <script type="text/javascript">
			GruopBuyCountdown(<?= $pInfo['products_id']?>, <?= $pInfo['CountdownEndTime']?>,'CountDown<?= $pInfo['products_id']?>','ProductsObj_<?=$pInfo['products_id']?>');
		</script>
                                </div>
                            </div>
                        </div>
                        <div class="proImg"><a href="<?= tep_href_link('product_info.php','products_id='.$pInfo['products_id'])?>"><img src="<?= $pInfo['products_pics_src'][0]?>"/></a></div>
                        <div class="del_float"></div>
                </div>
                <div class="information">
                	<ul>
                    	<li><span>��Ʒ��ţ�</span><?= $pInfo['products_model']?></li>
                    	<li><span>�����ص㣺</span><?= $pInfo['display_str_departure_city']?></li>
                    	<li><span>����ʱ�䣺</span><?= ($pInfo['products_durations_type']=="0" ? $pInfo['products_durations'].'��' : 'Сʱ');?></li>
                    	<li><span>�����ص㣺</span><?= $pInfo['display_str_end_city']?></li>
                    	<li><span>����ʱ�䣺</span><?php
							//echo $pInfo['display_start_days'];

                    	if (count($date_arr) > 1){
							if (empty($date_arr[1])){
								echo $pInfo['display_start_days'];
							} else {
								echo $date_arr[0] . '<span class="more" onmouseover="jQuery(\'#date_' . $pInfo['products_id'] . '\').show();" onmouseout="jQuery(\'#date_' . $pInfo['products_id'] . '\').hide()"><a href="javascript:void(0)">�鿴ȫ��</a>';
								echo '<span class="MoreCon" id="date_' . $pInfo['products_id'] . '">
                    					<span class="topArrow"></span>
                    					<span class="con"><strong>1����������</strong><br/>' . $date_arr[0] . '<br/><strong>2����������</strong><br/>' . $date_arr[1] . '</span></span></span>';
							}
						} else {
							$temp = explode("��",$pInfo['display_start_days']);
							if (count($temp) > 2) {
								echo join("��",array_slice($temp, 0 , 2));
								echo '<span class="more" onmouseover="jQuery(\'#date_' . $pInfo['products_id'] . '\').show();" onmouseout="jQuery(\'#date_' . $pInfo['products_id'] . '\').hide()"><a href="javascript:void(0)">�鿴ȫ��</a>';
								echo '<span class="MoreCon" id="date_' . $pInfo['products_id'] . '">
                    					<span class="topArrow"></span>
                    					<span class="con">' . $pInfo['display_start_days'] . '</span></span></span>';
							} else {
								echo $pInfo['display_start_days'];
							}
						}
						//echo $pInfo['display_start_days']?></li>
                    	<li><span>������Ϣ��</span><?= (tep_not_null($pInfo['products_points_info']) ? $pInfo['products_points_info'] : "��")?></li>
                    </ul>
                </div>
              <!--<div class="invited">
                	<dl>
                    	<dt>
                        ���Ŷ���2012��04��07�ճ��ţ�<br />
�����г̣������Żݼۣ��������ޣ����꼴ֹ��<br />
���ķ�ǿ���Ƽ��� �µ�ǰ����ϸ�Ķ� <a href="#" class="colorfd9300 underline">�Ź���֪</a>
                        </dt>
                      <dd>
                        <a href="#">��������Ҳ������</a>
                        <p>�������ѹ������ǵ�������· ���ɻ��<strong class="color_orange font_size14">3%</strong>��Ӷ��</p>
                      </dd>
                    </dl>
                </div>-->
                <div class="introduction">
               	    <div class="tit">
               	  	    <h3>�г���ɫ</h3>
               	  		<div class="share jiathis_style" style="float:right;margin:5px;">
    						<div class="icon jiathis ckepop" id="">
    							<a href="javascript:void(0)" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank">������</a>
    							<a class="jiathis_button_tools_1"></a>
    							<a class="jiathis_button_tools_2"></a>
    							<a class="jiathis_button_tools_3"></a>
    							<a class="jiathis_button_tools_4"></a>
    						</div>
    					</div>
    				</div>
                    <div class="cont">
                     <?= $pInfo['products_small_description']?>
				         [<a href="<?= tep_href_link('product_info.php','products_id='.$pInfo['products_id'])?>">����</a>]                   
                     </div>
                </div>
                
            </div>
<?php
}
// ��ӷ�ҳ
echo '<div>';
echo $page_links;
echo '</div>';
?>

                            
            </div>
            <div class="bulkRight">
            	
                <?php 
				echo db_to_html(ob_get_clean());
                //���ǵ�����
				include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'advantages.php');
				?>
				<div class="sinaWeibo">
<!--<iframe width="258" height="550" class="share_self"  frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=258&height=550&fansRow=2&ptype=1&speed=0&skin=9&isTitle=1&noborder=1&isWeibo=1&isFans=0&uid=1762593610&verifier=4b318246&dpc=1"></iframe>-->
<iframe width="258" height="348" class="share_self"  frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=228&height=348&fansRow=2&ptype=1&speed=100&skin=9&isTitle=1&noborder=1&isWeibo=1&isFans=0&uid=3223551651&verifier=4922923e&colors=d6f3f7,ffffff,666666,0082cb,ecfbfd&dpc=1"></iframe>
                </div>
                <?php 
				//��ϵ����
				include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'contact_us.php');
				ob_start();
				?>
           
        <div class="comment margin_b10">
                	<div class="tit"><span class="color_orange fr"><a href="<?php echo tep_href_link('reviews.php')?>">����&gt;&gt;</a></span><h3>�û�����</h3></div>
                    <div class="cont">
                    <?php 
                    $reviews_query_raw = "select r.rating_total, r.reviews_id, rd.reviews_text as reviews_text, rd.reviews_title, r.reviews_rating, r.date_added, p.products_id, pd.products_name, p.products_image, r.customers_name, r.rating_0, r.rating_1, r.rating_2, r.rating_3, r.rating_4, r.rating_5 from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = r.products_id and r.reviews_id = rd.reviews_id and r.reviews_status='1' and p.products_id = pd.products_id and pd.language_id = '1' and rd.languages_id = '1' and r.parent_reviews_id=0 order by r.reviews_id DESC Limit 5";
                    $sql = tep_db_query($reviews_query_raw);
					while ($rows = tep_db_fetch_array($sql)){
			?>
			<ul>
                        	<li class="s_1"><span class="xcyd"><?php 
                        	$ul_array = get_reviews_array();
                        	$dinggou = $xincheng = '';
                        	
                        	for($i=0; $i<count($ul_array); $i++){
                        		foreach($ul_array[$i]['opction'] as $key_val => $text){
                        			if($rows['rating_'.$i] == $key_val && ($ul_array[$i]['title'] == 'Ԥ��' || $ul_array[$i]['title'] == '�г�')){
                        				if ($ul_array[$i]['title'] == 'Ԥ��') {
                        					echo '������' . $text . '&nbsp;&nbsp;';
                        				} else {
                        					echo '�г̣�' . $text . '&nbsp;&nbsp;';
                        				}
                        				//echo $ul_array[$i]['title'] . ':' . $text . '&nbsp;';//.$reviews['rating_'.$i]
                        				break;
                        			}
                        		}
                        	}
                        	?></span><?php echo tep_db_output($rows['customers_name'])?></li>
                            <li class="s_2"><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $rows['products_id'].'&mnu=reviews');?>#two1"><?php echo tep_db_output($rows['reviews_text'])?></a></li>
                            <li class="s_3"><?php echo date('Y-m-d H:i:s',strtotime($rows['date_added']))?></li>
                        </ul>
                    
			<?php
				}
			?>                  
                </div>
              </div>
                <?php 
                echo db_to_html(ob_get_clean());
                // ����
                include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'email.php');
                ?>
            </div>
        </div>
        <!--��·����Script Start<script type="text/javascript" src="http://v2.jiathis.com/code_mini/jia.js" charset="utf-8"></script> ��·����Script End-->
        <script type="text/javascript" src="<?= IMAGES_HOST?>/includes/javascript/jiathis-min.js" charset="utf-8"></script>
        <script type="text/javascript">jQuery.jiathis.init(jQuery(".ckepop"));</script>
        
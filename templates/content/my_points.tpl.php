<?php //echo tep_get_design_body_header(HEADING_TITLE,1); ?>
<!-- content main body start -->
<style type="text/css">
h2{ line-height:24px;}
.pointsIntro li{ list-style:disc inside none; padding-left:15px; color:#F7860F; line-height:18px;}
</style>
<!-- body //-->
<table border="0" width="100%" cellspacing="3" cellpadding="3" style="border:1px solid #AED5FF">
  <tr>
    <!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
        <?php /* ?><tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main"><b><?php echo HEADING_TITLE; ?></b></td>
            <td class="main" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'money.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr><?php */ ?>
        <tr>
          <td><?php
		//require('includes/rewards4fun_page_navi.php');		
		?>
          </td>
        </tr>
        <?php
 //howard added rewards4fun banner
 //if(!(int)$has_point){
 	require(DIR_FS_LANGUAGES . $language . '/' . FILENAME_JOIN_REWARDS4FUN);
 ?>
        <tr>
          <td><div>
              <?php if($customer_validation!='1'){?>
              <?php
		require(DIR_FS_CONTENT .'customers_validation.tpl.php');		
		?>
              <?php }?>
            </div>
            <?php /*<div><img src="image/banner_logo/<?php echo $language ?>/jifen_f.jpg" alt="Affiliate, travel" style="margin-top:10px;" /></div> */ //ע���������� ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" padding:15px 0 10px; font-size:14px;">
              <tr>
                <?php
		$has_point = tep_get_shopping_points($customer_id);
		if ($has_point > 0){
		?>
                <td class="main" style=" font-size:14px;"><?php echo sprintf(MY_POINTS_CURRENT_BALANCE, number_format($has_point,POINTS_DECIMAL_PLACES),$currencies->format(tep_calc_shopping_pvalue($has_point))); ?>
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo db_to_html('��Ҫ���ڵĻ���');?> <b style="color:#FF0000">0</b><?php echo db_to_html('��һ�����ڣ�');?>
				
				</td>
                <?php
		}else{
		?>
                <td class="main" style=" font-size:14px;"><b> <?php echo TEXT_NO_POINTS?> </b></td>
                <?php 
		}
		?>
              </tr>
            </table>
            <div class="title titleSmall"> <b></b><span></span>
              <h3><?php echo TEXT_INTRO_STRING_TOP; ?></h3>
            </div>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><?php
				$pending_points_query = "select unique_id, orders_id, points_pending, points_comment, date_added, points_status, points_type, feedback_other_site_url, products_id, admin_id from " . TABLE_CUSTOMERS_POINTS_PENDING . " where customer_id = '" . (int)$customer_id . "' order by unique_id desc limit 5";
				//$pending_points_split = new splitPageResults($pending_points_query, MAX_DISPLAY_POINTS_RECORD);
				//$pending_points_query = tep_db_query($pending_points_split->sql_query);
				$pending_points_query = tep_db_query($pending_points_query);
				
				if (tep_db_num_rows($pending_points_query)) {
				?>
                  <table border="0" width="100%" cellspacing="0" cellpadding="0" class="infoBox">
                    <tr class="productListing-heading">
                      <td class="productListing-heading"><?php echo HEADING_ORDER_DATE; ?></td>
                      <td class="productListing-heading" width="10%"><?php echo HEADING_ORDERS_NUMBER; ?></td>
                      <td class="productListing-heading"><?php echo HEADING_POINTS_COMMENT; ?></td>
                      <td class="productListing-heading"><?php echo HEADING_POINTS_STATUS; ?></td>
                      <td class="productListing-heading" align="right"><?php echo HEADING_POINTS_TOTAL; ?></td>
                    </tr>
                    <tr>
                      <?php
				while ($pending_points = tep_db_fetch_array($pending_points_query)) {
				$orders_status_query = tep_db_query("select o.orders_id, o.orders_status, s.orders_status_name_1 from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$customer_id . "' and o.orders_id = '" . (int)$pending_points['orders_id'] . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "'");
				$orders_status = tep_db_fetch_array($orders_status_query);
				
				if ($pending_points['points_status'] == '1') $points_status_name = TEXT_POINTS_PENDING;
				if ($pending_points['points_status'] == '2') $points_status_name = TEXT_POINTS_CONFIRMED;
				if ($pending_points['points_status'] == '3') $points_status_name = '<span class="pointWarning">' . TEXT_POINTS_CANCELLED . '</span>';
				if ($pending_points['points_status'] == '4') $points_status_name = '<span class="pointWarning">' . TEXT_POINTS_REDEEMED . '</span>';
				
				if ($orders_status['orders_status'] == 2 && $pending_points['points_status'] == 1 || $orders_status['orders_status'] == 3 && $pending_points['points_status'] == 1) {
				$points_status_name = TEXT_POINTS_PROCESSING;
				}
				
				if (tep_not_null($pending_points['points_comment']) && defined($pending_points['points_comment'])) {
					$pending_points['points_comment'] = constant($pending_points['points_comment']);
				}
				/*
				if (($pending_points['points_type'] == 'SP') && ($pending_points['points_comment'] == 'TEXT_DEFAULT_COMMENT')) {
				$pending_points['points_comment'] = TEXT_DEFAULT_COMMENT;
				}
				if (($pending_points['points_type'] == 'TP') && ($pending_points['points_comment'] == 'USE_POINTS_EVDAY_FOR_TOP_TRAVEL_COMPANION_TEXT')) {
				$pending_points['points_comment'] = USE_POINTS_EVDAY_FOR_TOP_TRAVEL_COMPANION_TEXT;
				}
				
				if ($pending_points['points_comment'] == 'TEXT_DEFAULT_REDEEMED') {
				$pending_points['points_comment'] = TEXT_DEFAULT_REDEEMED;
				}
				if ($pending_points['points_comment'] == 'TEXT_WELCOME_POINTS_COMMENT') {
				$pending_points['points_comment'] = TEXT_WELCOME_POINTS_COMMENT;
				}
				if ($pending_points['points_comment'] == 'TEXT_VALIDATION_ACCOUNT_POINT_COMMENT') {
				$pending_points['points_comment'] = TEXT_VALIDATION_ACCOUNT_POINT_COMMENT;
				}
				if ($pending_points['points_comment'] == 'TEXT_DEFAULT_REVIEWS_PHOTOS') {
				$pending_points['points_comment'] = TEXT_DEFAULT_REVIEWS_PHOTOS;
				}
				if ($pending_points['points_comment'] == 'TEXT_DEFAULT_FEEDBACK_APPROVAL') {
				$pending_points['points_comment'] = TEXT_DEFAULT_FEEDBACK_APPROVAL;
				}
				if ($pending_points['points_comment'] == 'TEXT_DEFAULT_ANSWER') {
				$pending_points['points_comment'] = TEXT_DEFAULT_ANSWER;
				}
				//��Ա���ֿ� begin
				if ($pending_points['points_comment'] == 'TEXT_POINTCARD_REGISTER') {
				$pending_points['points_comment'] = TEXT_POINTCARD_REGISTER;
				}
				if ($pending_points['points_comment'] == 'TEXT_POINTCARD_PROFILE') {
				$pending_points['points_comment'] = TEXT_POINTCARD_PROFILE;
				}
				if ($pending_points['points_comment'] == 'TEXT_POINTCARD_LOGIN') {
				$pending_points['points_comment'] = TEXT_POINTCARD_LOGIN;
				}
				//��Ա���ֿ� end
				*/
				$referred_customers_name = '';
				if ($pending_points['points_type'] == 'RF') {
					$referred_name_query = tep_db_query("select customers_name from " . TABLE_ORDERS . " where orders_id = '" . (int)$pending_points['orders_id'] . "' limit 1");
					$referred_name = tep_db_fetch_array($referred_name_query);
					/*if ($pending_points['points_comment'] == 'TEXT_DEFAULT_REFERRAL') {
						$pending_points['points_comment'] = TEXT_DEFAULT_REFERRAL;
					}*/
					$referred_customers_name = $referred_name['customers_name'];
				}
				/*
				if (($pending_points['points_type'] == 'RV') && ($pending_points['points_comment'] == 'TEXT_DEFAULT_REVIEWS')) {
				$pending_points['points_comment'] = TEXT_DEFAULT_REVIEWS;
				}
				if(($pending_points['points_type'] == 'VT') && ($pending_points['points_comment'] == 'TEXT_VOTE_POINTS_COMMENT')){
				$pending_points['points_comment'] = TEXT_VOTE_POINTS_COMMENT;
				}
				*/
				if (($pending_points['orders_id'] > '0') && (($pending_points['points_type'] == 'SP')||($pending_points['points_type'] == 'RD'))) {
				?>
                    <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $pending_points['orders_id'], 'SSL'); ?>'" title="<?php echo TEXT_ORDER_HISTORY .'&nbsp;' . $pending_points['orders_id']; ?>">
                      <?php
				}
				
				if ($pending_points['points_type'] == 'RV') {
				?>
                    <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $pending_points['products_id'].'&mnu=reviews', 'NONSSL'); ?>'" title="<?php echo TEXT_REVIEW_HISTORY; ?>">
                      <?php
				}
				
				if ($pending_points['points_type'] == 'PH') {
				?>
                    <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $pending_points['products_id'].'&mnu=photos', 'NONSSL'); ?>'" title="<?php echo TEXT_REVIEW_HISTORY; ?>">
                      <?php
				}
				if ($pending_points['points_type'] == 'FA') {
				?>
                    <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="window.open('<?php echo $pending_points['feedback_other_site_url']; ?>');" title="">
                      <?php
				}
				if ($pending_points['points_type'] == 'QA') {
				/*$get_products_id = tep_db_query("select products_id from ".TABLE_QUESTION." where que_id='".$pending_points['orders_id']."'");
				$row_products_id = tep_db_fetch_array($get_products_id);*/
				?>
                    <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $pending_points['products_id'].'&mnu=qanda', 'NONSSL'); ?>'" title="<?php echo TEXT_REVIEW_HISTORY; ?>">
                      <?php
				}
				
				if (($pending_points['orders_id'] == 0) || ($pending_points['points_type'] == 'RF') || ($pending_points['points_type'] == 'RV')  || ($pending_points['points_type'] == 'PH') || ($pending_points['points_type'] == 'QA')) {
				$orders_status['orders_status_name_1'] = '<span class="pointWarning">' . TEXT_STATUS_ADMINISTATION . '</span>';
				$pending_points['orders_id'] = '<span class="pointWarning">' . TEXT_ORDER_ADMINISTATION . '</span>';
				}
				?>
                      <td class="productListing-data"width="13%"><?php echo tep_date_short($pending_points['date_added']); ?></td>
                      <td class="productListing-data" nowrap="nowrap"><?php echo '#' . $pending_points['orders_id'] . '&nbsp;&nbsp;' . db_to_html($orders_status['orders_status_name_1']); ?></td>
                      <td class="productListing-data" nowrap="nowrap"><?php 
							if($pending_points['admin_id']!=0) {
								echo db_to_html(nl2br($pending_points['points_comment'])) .'&nbsp;' . db_to_html($referred_customers_name); 
							}else{
								echo nl2br($pending_points['points_comment']) .'&nbsp;' . db_to_html($referred_customers_name); 
							}
							
					  ?>
                      </td>
                      <td class="productListing-data"><?php echo $points_status_name; ?></td>
                      <td class="productListing-data" align="right"><?php echo number_format($pending_points['points_pending'],POINTS_DECIMAL_PLACES); ?></td>
                    </tr>
                    <?php
				}
				
				?>
                  </table></td>
              </tr>
            </table>
            
           <!-- <div style="line-height:24px;"><?php #echo TEXT_INTRO_STRING_BOTTOM; ?>
              <?php /* ?> <a href="#" class="sp3">Click here</a> to learn more. <?php */ ?>
            </div>-->
            <?php ob_start()?>
            <!--������ȷ���ֹ�����Ϣ by _Afei-->
            <!--<h5 style="line-height:32px;">���ķ�����׬ȡ��ϸ</h5>
            <ul class="pointsIntro">
            	<li>���û�ע�� (+100����)</li>
                <li>�û���֤ע������ (+80����)</li>
                <li>�������ķ����β�Ʒ����·�г̡��Ƶ�� (+1��Ԫ=1����)</li>
                <li>���������г̡�������;���ܵȣ�����֤ͨ���� (+20����/��)</li>
                <li>������д���ķ������������ڵ��ʾ���� (�����)</li>
                <li>���ྫ�ʻ�����Ƴ� (�����)</li>
                <li>���ȷ���û��������Ч����������ķ���bug (�����)</li>
            </ul>
            <h5 style="line-height:32px;">���������ۿ��޶�</h5>
            <ol style="line-height:24px;">
            	<li>1.�ͻ����״ζ�����Ʒʱ��ֻ��ʹ��200���ϵĻ��ֲ��֡����μ����ϵ����ѣ��������κ����ơ�</li>
                <li>2.���ķ����ֵĶһ�����Ϊ��100����=1��Ԫ�������ޣ��ж��ٶҶ��٣�����Խ���ֽ��ۿ�Խ�ߣ�����������ѻ�ȡ�����ţ���ȫ���ܵ����100%���Żݣ�</li>
            </ol>-->
            <div class="ui_item">
                <h3 class="ui_rules_listitle">���ֶһ���ʽ</h3>
                <p>�ͻ�������Ʒʱ���ڸ������ҳ����ж�Ӧ�ġ��һ����Ĵ��ڣ����Կ����ͻ�Ŀǰ�Ļ�����������Ӧ�ֽ𼰱�������ʹ�õ���߻���������Ϣ�������ȷ���һ�����ť��ϵͳ�Զ�Ϊ�ͻ�������ۿ۽�չʾ�����Żݺ󶩵�ʵ�����ܼۣ�ȷ�ϵֻ���ȥ֧�����󣬻��ּ��Ѷһ����ֽ���Ӧ�۳����ͻ�ֻ��ֱ��֧���Ż��ۿۺ�����ɡ�</p>
            </div>
            <div class="ui_item">
                <h3 class="ui_rules_listitle">����׬ȡ����</h3>
                <p>�û�ͨ����������ķ��������ϵ�һϵ�в�����Ϳɻ����Ӧ���֡����¹������£�</p>
                <table class="ui_rules_table">
                    <thead>
                        <tr>
                            <th>�û���Ϊ</th>
                            <th>��Դ˵��</th>
                            <th>�����ۼ�</th>
                            <th>�����޶�</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ע��</td>
                            <td>���û�ע��</td>
                            <td>+<?= NEW_SIGNUP_POINT_AMOUNT?>����</td>
                            <td>ֻ��һ��</td>
                        </tr>
                        <tr>
                            <td>��֤����</td>
                            <td>�û���֤ע������</td>
                            <td>+<?= VALIDATION_ACCOUNT_POINT_AMOUNT?>����</td>
                            <td>ֻ��һ��</td>
                        </tr>
                        <tr>
                            <td>������Ʒ</td>
                            <td>�������ķ����β�Ʒ����·�г̡��Ƶ��</td>
                            <td>+1��Ԫ=<?= POINTS_PER_AMOUNT_PURCHASE;?>����</td>
                            <td>������</td>
                        </tr>
                        <tr>
                            <td>����</td>
                            <td>���������г̡��Ƶ�ס�ޡ�������;���ܡ��������۵ȣ�����֤ͨ����</td>
                            <td>+<?= USE_POINTS_FOR_REVIEWS?>����/��</td>
                            <td>ÿ������<?= EVERY_DAY_MAX_NUM_FOR_ADD_POINTS_FOR_REVIEWS?>��</td>
                        </tr>
                        <tr>
                            <td>�����ʾ�</td>
                            <td>������д���ķ������������ڵ��ʾ����</td>
                            <td>�����</td>
                            <td>ֻ��һ��</td>
                        </tr>
                        <tr>
                            <td>�����ڻ</td>
                            <td>���ྫ�ʻ�����Ƴ�</td>
                            <td>�����</td>
                            <td>����</td>
                        </tr>
                        <tr>
                            <td>����&amp;bug����</td>
                            <td>���ȷ���û��������Ч����������ķ���bug</td>
                            <td>�����</td>
                            <td>������</td>
                        </tr>
                    </tbody>
                </table>
                <p class="ui_rules_notice">һ��ˢ������Ϊ�����ܵ�������Ʋã�</p>
            </div>
            <div class="ui_item">
                <h3 class="ui_rules_listitle">���������ۿ��޶����</h3>
                <p>1.�ͻ����״ζ�����Ʒʱ��ֻ��ʹ��200���ϵĻ��ֲ��֡����μ����ϵ����ѣ��������κ����ơ�</p>
                <p>2.���ķ����ֵĶһ�����Ϊ��100����=1��Ԫ�������ޣ��ж��ٶҶ��٣�����Խ���ֽ��ۿ�Խ�ߣ�����������ѻ�ȡ�����ţ���ȫ���ܵ����100%���Żݣ�</p>
            </div>
            <?php echo db_to_html(ob_get_clean()) ?>
            <?php
			//����ԭ����Ļ��ֹ�����Ϣ by _Afei 20120530
			if (false) {?>
            <h2><?php echo TEXT_EARN_POINTS; ?></h2>
            <ul class="pointsIntro">
              <?php /* �����ֽ��ۿۣ� 100����=1��Ԫ��USD��
		<li><?php echo TEXT_POINT_TO_USD;?></li>
		*/?>
              <?php
		if(abs(NEW_SIGNUP_POINT_AMOUNT)>0){
		?>
              <li><?php echo TEXT_REG_POINTS; ?></li>
              <?php
		}
		?>
		<li><?php echo TEXT_IMPROVE_INFO_FOR_POINT ?></li>
              <?php
		if(abs(POINTS_PER_AMOUNT_PURCHASE)>0){
		?>
              <li><?php echo TEXT_TOUR_POINTS; ?></li>
              <?php
		}
		?>
              <?php
		if(abs(USE_REFERRAL_SYSTEM)>0){
		?>
              <li><?php echo TEXT_REFER_POINTS; ?></li>
              <?php
		}
		?>
              <?php
		if(abs(USE_POINTS_FOR_REVIEWS)>0){
		?>
              <li><?php echo TEXT_REVIEW_POINTS; ?></li>
              <?php
		}
		?>
              <?php
		if(abs(USE_POINTS_FOR_ANSWER)>0){
		?>
              <li><?php echo TEXT_ANS_POINTS; ?></li>
              <?php
		}
		?>
              <?php			
		if(abs(USE_POINTS_FOR_PHOTOS)>0){
		?>
              <li><?php echo TEXT_PHOTO_POINTS; ?></li>
              <?php
		}
		?>
              <?php
		if(abs(USE_POINTS_FOR_FEEDBACK_APPROVAL)>0){
		?>
              <li><?php echo TEXT_FEEDBACK_POINTS; ?> </li>
              <?php
		}
		?>
            </ul>
            <br/>
            <br/>
            <h2><?php echo TFF_POINTS_DESCRIPTION; ?><?php echo db_to_html('��');?></h2>
            <p><?php echo TFF_POINTS_DESCRIPTION_CONTENT;?><br/>
              <br/>
            </p>
            <h2><?php echo TEXT_HOW_SAVE; ?><?php echo db_to_html('��');?></h2>
            <p><?php echo TEXT_SAVINGS;?><br/>
              <br/>
            </p>
            <p><?php echo TEXT_MORE; ?></p>
            <?php }?></td>
        </tr>
        <?php
 //}
  //howard added rewards4fun banner end
 ?>
        <?php
  }
?>
        <?php /* close button_back
	  <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
		        <td><a href="javascript:history.go(-1)"><?php echo tep_image_button('button_back.gif', IMAGE_BUTTON_BACK); ?></a></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
	  close button_back end */ ?>
      </table></td>
    <!-- body_text_eof //-->
  </tr>
</table>

<!-- body_eof //-->
<?php echo tep_get_design_body_footer();?>
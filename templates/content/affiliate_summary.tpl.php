<?php /*echo tep_get_design_body_header(HEADING_TITLE,1);*/ ?>
<table border="0" width="99%" cellspacing="0" cellpadding="0">
<?php
//amit added to affiliate page navigation start
require('includes/affiliate_page_navi.php');
//amit added to affiliate page navigation end
?>
</table>
<div class="f-mytours-msgwrap">
	<div class="f-mytours-msghead">
    	<p><?= PAGE_HEADER_TEXT?></p>
    </div>
    <div class="f-mytours-msginfo">
    	<div id="J_Msgbox" class="f-mytours-msgtext">
            <h3><?= TEXT_AFFILATE_SUMMERRY_COMMISSION_INFO?></h3>
            <p><?= TEXT_AFFILATE_SUMMERRY_LI1?></p>
            <p><?= TEXT_AFFILATE_SUMMERRY_LI2?></p>
        </div>
        <div class="f-pullback-wrap">
        	<i id="J_pullback" class="f-pullback">����</i>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery('#J_pullback').toggle(function(){
	jQuery('#J_Msgbox').hide();
	jQuery(this).html('<?= db_to_html("չ��")?>');	
},function(){
	jQuery('#J_Msgbox').show();
	jQuery(this).html('<?= db_to_html("����")?>');	
});
</script>
<div class="f-myunion-wrap">
	<div class="f-myunion-account">
    	<span><?= TEXT_GREETING?><strong><?= db_to_html(tep_customers_name($affiliate_id));?></strong></span><span><?= TEXT_AFFILIATE_ID?><strong><?= $affiliate_id;?></strong></span>
    </div>
    <div class="f-myunion-info">
    	<h3><a id="helpInfo" href="javascript:showPopup('popupInfo','popupConInfo','fixedTop','off','helpInfo','200','500');"><?php echo TEXT_SUMMARY; ?></a><?php echo TEXT_SUMMARY_TITLE; ?></h3>
        <div class="f-myunion-total">
        	<ul class="f-myunion-list">
            	<li><span><?= TEXT_IMPRESSIONS?></span> <?= $AffiliateInfo['affiliate_impressions']; ?></li>
                <li><span><?= TEXT_VISITS?></span> <?= $AffiliateInfo['affiliate_clickthroughs']; ?></li>
                <li><span><?= TEXT_TRANSACTIONS?></span> <?= $AffiliateInfo['affiliate_transactions'];?></li>
                <li><span><?= TEXT_CONVERSION?></span> <?= $AffiliateInfo['affiliate_conversions'];?></li>
                <li><span><?= TEXT_AMOUNT?></span> <?= $currencies->display_price($AffiliateInfo['affiliate_amount'], ''); ?></li>
                <li><span><?= TEXT_AVERAGE?></span> <?= $currencies->display_price($AffiliateInfo['affiliate_average'], ''); ?></li>
                <li class="last"><span><?= TEXT_COMMISSION_RATE?></span> <?= tep_round($AffiliateInfo['affiliate_percent'], 2). '%'; ?></li>
                <li class="last"><span><?= TEXT_COMMISSION_A; ?></span> <?= $currencies->display_price($AffiliateInfo['affiliate_commission'], ''); ?></li>
            </ul>
        </div>
    </div>
    <?php
		if(0){	//��ʱ����
		 //�Ƽ���¼�б�{?>
		<h2><?= TEXT_AFFILATE_SUMMERRY_YOUR_REFERRALS?></h2>
        
        <div class="salesHistory">
            <div class="title titleSmall">
                <b></b><span></span>
                <div class="col1"><?= TEXT_AFFILATE_SUMMERRY_REFERRAL_DATE;?></div>
                <div class="col2"><?= TEXT_AFFILATE_SUMMERRY_REFERRAL_EMAIL;?></div>
                <div class="col3"><?= TEXT_AFFILATE_SUMMERRY_SIGNUP;?></div>
                <div class="col4"><?= TEXT_AFFILATE_SUMMERRY_MADE_PURCHASE;?></div>
            </div>
            <div class="con">
            <ul>
		<?php
		
			$customer_referral_query_row = "select * from " . TABLE_REBATES_REFERRALS_INFO . " where customers_id=".$customer_id."  order by referrals_date desc" ;
			//$customer_referral_query_row = "select * from " . TABLE_REBATES_REFERRALS_INFO . " where 1  order by referrals_date desc" ;
			
			$products_new_split = new splitPageResults($customer_referral_query_row, MAX_DISPLAY_AFFILIATE_REFERRALS_REPORT);
			
			if ($products_new_split->number_of_rows > 0) {
				$customer_referral_query = tep_db_query($products_new_split->sql_query);
				
				while ($customer_referral = tep_db_fetch_array($customer_referral_query)) {
				
					$referrals_email = $customer_referral['referrals_email'];//�Ƽ�ע�������
					// ���û����в��� �Ƽ����û� �Ƿ� ע��
					$check_customer_query = tep_db_query("select customers_id, customers_default_address_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($referrals_email) . "' ");
					if (tep_db_num_rows($check_customer_query) > 0 ) {
						$issignup = 'Y'; // ��¼��ע��״̬
						if ($customer_check_done = tep_db_fetch_array($check_customer_query)) {
							$refferalid = $customer_check_done['customers_id'];	//�õ�ע�����û�ID			
						}
						// �������û��Ѿ�ע�ᣬ�����Ѿ����˶�����
						$select_purchase_query = tep_db_query("select o.orders_id from " . TABLE_ORDERS ." as o, " . TABLE_AFFILIATE_SALES . " as s where s.affiliate_orders_id = o.orders_id  and o.customers_id='".(int) $refferalid."'");
						if (tep_db_num_rows($select_purchase_query) > 0 ) {
							// �µ�״̬
							$ispurchase = 'Y';	
						}		
					}else{
						$issignup = 'N';
						$ispurchase = 'N';
					}
		?>			
				<li>
                    <div class="col1"><?php echo tep_date_short($customer_referral['referrals_date']); ?></div>
                    <div class="col2"><?php echo tep_db_output($customer_referral['referrals_email']); ?></div>
                    <div class="col3"><?php echo $issignup; ?></div>
                    <div class="col4"><?php echo $ispurchase; ?></div>
                </li>
		<?php 
				}
			} //end of if loop
		?>
            </ul>
            <div class="page" style="width:680px;">
		<?php
		  //��ҳ
		  if (($products_new_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
		  	echo TEXT_RESULT_PAGE . ' ' . $products_new_split->display_links_2011(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y')));
		  }
		?>
			
			</div>
            </div>
            </div>
        <?php
		 //�Ƽ���¼�б�}
		}
		?> 
</div>

<?php //��վ�����˻��ܱ����������{?>
<?php ob_start();?>
<div class="popup" id="popupInfo">
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="popupTable">
<tr><td class="topLeft"></td><td class="side"></td><td class="topRight"></td></tr><tr><td class="side"></td><td class="con">

  <div class="popupCon" id="popupConInfo" style="width:500px;">
    <div class="popupConTop" id="dragInfo">
      <h3><b>��վ���˰���</b></h3><span onclick="closePopup('popupInfo')"><img src="<?= DIR_WS_ICONS;?>icon_x.gif" alt="�ر�" title="�ر�" /></span>
    </div>
    
    <ul class="f-myunion-poplist" id="J_popList">
        <li><b>�����ʾ�ܴ���:</b>�ڸ�����ʱ���ڹ������������չʾ���ܴ�����</li>
        <li class="even"><b>������ܴ���:</b>ͨ��������վ��������������ӻ�õ��ܵ������</li>
        <li><b>���׶�������:</b>ͨ���������۴����˻�Ϊ���ķ��������ĳɹ����׵��ܶ�������</li>
        <li class="even"><b>ת����:</b>������õĵ���ɹ�ת���ɶ����ı��ʡ�</li>
        <li><b>�����ܽ��:</b>��Ϊ���ķ������������۶������ܽ�</li>
        <li class="even"><b>ƽ�����۶�:</b>���������������ܶ��������ܽ��������ƽ�����۶</li>
        <li><b>Ӷ�����:</b>��ÿΪ���ķ�������һ����������׬ȡ��Ӷ�������</li>
        <li class="even"><b>Ӷ���ܶ�:</b>�������ķ�����ͨ���μӴ����۴���������׬ȡ��Ӷ���ܶ</li>
    </ul>
   
  </div>
<script type="text/javascript">
jQuery('#J_popList li').hover(function(){
	jQuery(this).addClass('hover').siblings('li').removeClass('hover');	
});
</script>  
</td><td class="side"></td></tr><tr><td class="botLeft"></td><td class="side"></td><td class="botRight"></td></tr>
</table>
</div>

<script type="text/javascript">
//���õ����㶥����ҷ 
new divDrag([GetIdObj('dragInfo'),GetIdObj('popupInfo')]); 
</script>
<?php echo  db_to_html(ob_get_clean());?>
<?php //��վ�����˻��ܱ����������}?>

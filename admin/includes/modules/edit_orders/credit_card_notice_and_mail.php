<?php
/**
 * ���ÿ�������Ϣ�Զ�ʶ��
 *
 * <p>1��������ÿ����˷ǲ����ˡ���������$1800����AVS not match at all������ҳ�����ʾ��ɫ��ʾ�������ѿͷ���Ҫ�����ṩACB��</p>
 * <p>2��������ҳ��ͬʱ�����������ֺ�ɫ��ʾʱ��ϵͳ�Զ�����һ���ʼ���������ҪACB</p>
 * <p>��1����Customer and Guest Information�е�	Billing Address-> Name��졣
 *��2��>$1800ʱ���ܼ��б��
 *��3����Address Verification Status:�������а�����Street�� Zip ͬʱ����Not��ʱ��������ֱ�죻���⣬Card Code Status: Match������ǡ�Match���ĸ��б�졣</p>
 */

$billing_name_is_guest = false;	//���ÿ������Ƿ��ǲ�����
$guest_info_sql = tep_db_query('SELECT guest_name FROM `orders_product_eticket` WHERE orders_id="'.(int)$oID.'" ');
while($guest_info = tep_db_fetch_array($guest_info_sql)){
	if(tep_not_null($order->billing['name']) && strpos(strtolower($guest_info['guest_name']), strtolower($order->billing['name']))!==false){
		$billing_name_is_guest = true;
		break;
	}
}

$credit_max_amount = 1800; //$1800
$totals_exceeds = false; //�ܶ��Ƿ񳬹�����
foreach($order->totals as $key => $val){
	if($val['value'] > $credit_max_amount && $val['class']=="ot_total"){
		$totals_exceeds = true;
		break;
	}
}

$street_and_zip_match = true;	//�ֵ���ַ��༭�Ƿ�ƥ��
$replace_str = '';
$orders_history_sql = tep_db_query("select comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . tep_db_input($oID) . "' and orders_status_id in(100060,100062) ");
$tmp_array = array();
while($orders_history_rows = tep_db_fetch_array($orders_history_sql)){
	if(tep_not_null($orders_history_rows['comments'])){
		$tmp_array[] = explode("\n",$orders_history_rows['comments']);
	}
}
if(sizeof($tmp_array)){
	foreach($tmp_array as $key => $val){
		if(strpos($val[0], 'Address Verification Status:') !==false){
			if((strpos(strtolower($val[0]), 'street') !==false || strpos(strtolower($val[0]), 'zip') !== false) && strpos(strtolower($val[0]), ' not ') !== false){
				$replace_str = substr($val[0],0,-1);
				$street_and_zip_match = false;
				break;
			}
		}
	}
}

if($billing_name_is_guest == false && $totals_exceeds == true && $street_and_zip_match == false && !(int)$order->info['sent_acb_mail']){	//ϵͳ�Զ�����һ���ʼ���������ҪACB start
	$acb_mail_text = 'лл���Ĺ����֧�����������ڴ������Ķ�����Ϊ�˱�֤˳�����ţ��������췢������֧�ֵ���ȷ������˳����ɡ�'."\n";
	$acb_mail_text.= '���ķ�����usitrip.com�����߾�ȫ����֤�����Ϲ���İ�ȫ�ԡ� Ϊ�˼���Ϊ���ṩ������ļ۸�ͱ������������ÿ���թ, ����������ѷ�������һ������������������ṩ���֤ʵ����֤����'."\n\n";
	$acb_mail_text.= '&bull; ���ÿ��ֿ��˲��μ�����<br />&bull; �������ÿ���ַ����ͨ��ϵͳ��ʵ<br />&bull; �������ѽ���$1800'."\n\n";
	$acb_mail_text.= '������Ҫ��Щ֤ʵ�ļ���֤��: '."\n";
	$acb_mail_text.= '1. ���ÿ���������Ч���֤����Ӱӡ��(<b>��Ч���֤���������Ļ��ջ�������ǩ���Ĵ��б���ǩ���ļ�ʻִ�ջ�������ǩ���Ĵ��б���ǩ�������֤</b>)��'."\n";
	$acb_mail_text.= '2. ��д��������ǩ�������ÿ�������ǩ�������ڵ����ÿ�֧����֤��(<a href="'.tep_catalog_href_link('credit_card_holder_verification_form_simplified.doc').'" target="_blank">�������������Ȩ��</a>)��'."\n";
	$acb_mail_text.= '3. ������ÿ������˲��ǲ��������ŵĳ�Ա���븽���ο͵Ļ���Ӱӡ����'."\n\n";
	$acb_mail_text.= '���ּķ����֤ʵ����֤���ķ�ʽ:'."\n";
	$acb_mail_text.= '&bull; �������䣺�����֤ʵ�ļ���֤����Ӱӡ����ɨ�豾����������Ƭ������'.STORE_OWNER_EMAIL_ADDRESS.' <br>
&bull; ��ַ��<br>'.nl2br(db_to_html(strip_tags(STORE_NAME_ADDRESS)))."\n";
	$acb_mail_text.= ''."\n";
	
	$acb_mail_to = $order->customer['email_address'];
	$acb_mail_to_name = strip_tags($order->customer['name']);
	if(IS_LIVE_SITES!=true){
		$acb_mail_to = "xmzhh2000@hotmail.com";
	}
	if(tep_not_null($acb_mail_to)){
		$acb_mail_subject = '���ķ��������ṩACB��Ȩ�� �����ţ�'.$oID;
		tep_mail($acb_mail_to_name, $acb_mail_to, $acb_mail_subject, $acb_mail_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
		
		tep_db_query('update orders set sent_acb_mail="1" where orders_id="'.(int)$oID.'" ');
	}
//ϵͳ�Զ�����һ���ʼ���������ҪACB end
}
?>
<script type="text/javascript">
jQuery().ready(function() {
<?php 
//JS start
if($billing_name_is_guest == false){
?>
	jQuery("#customer_billing_info input[name='update_billing_name']").addClass('col_red');
	jQuery("#CustomerAndGuestInformation").show();

<?php
}
if($totals_exceeds == true){
?>
	jQuery("#TotalModule td").addClass('col_red');
	
<?php
}
if($street_and_zip_match == false && tep_not_null($replace_str)){
?>
	var tmp_hmtl_codes = document.getElementById("OrderStatusHistoryList").innerHTML.replace("<?= $replace_str?>", "<?= '<b class=col_red>'.$replace_str.'</b>';?>");
	document.getElementById("OrderStatusHistoryList").innerHTML = tmp_hmtl_codes;
<?php
}
//JS end
?>
});
</script>

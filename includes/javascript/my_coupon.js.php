<?php
$p=array('/&amp;/','/&quot;/');
$r=array('&','"');
$is_js_file = false;	/* ���Ϊfalse����php�ĸ�ʽһ��һ���е�ҳ�� */
if($base_php_self == "javascript.php"){
	$is_js_file = true;
}
if($is_js_file==false){
?>
<script type="text/javascript"><!--
<?php
}
?>
$().ready(function() {
	<?php //����ύ�����Ż�ȯ��?>
	$("#active_coupon").submit(function(){
		var CouponCode = this.elements["coupon_code"];
		var error_msn = "";
		if(typeof(CouponCode)!="undefined" && CouponCode.value==""){
			error_msn = "<?= db_to_html("�������Ż�ȯ��ţ�")?>";
		}else if(typeof(CouponCode)!="undefined"){
			var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('my_coupon.php','action=do_active')) ?>");
			ajax_post_submit(url,this.id,"","", "");
		}else{
			error_msn = "<?= db_to_html("�Ż�ȯ�������򲻴��ڣ�");?>";
		}
		if(error_msn!=""){
			$("#active_coupon_msn").html("<span style=color:#F00;>&nbsp;"+error_msn+"</span>");
			$("#active_coupon_msn").fadeIn(200);
			$("#active_coupon_msn").fadeOut(2000);
			//alert(error_msn);
		}
		return false;
	});
});

<?php
if($is_js_file==false){
?>
//--></script>
<?php
}
?>
<?php if(tep_not_null($swf_file)){
	$width_height = getimagesize($maps_file);
	
	$swf_w = $width_height[0];
	$swf_h = $width_height[1];
	if(!(int)$swf_w || !(int)$swf_h ){
		$swf_w = 800;
		$swf_h = 600;
	}
	$swf_w = min(930,$swf_w);
	if($swf_w==930){
		$swf_h = round($swf_w*($width_height[1]/max(1,$width_height[0])),0);
	}
?>
<script src="includes/javascript/swfobject_modified.js" type="text/javascript"></script>
<div style="padding-top:10px;">
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?= $swf_w?>" height="<?= $swf_h?>" align="top" id="FlashID" title="title">
		<param name="movie" value="<?php echo $swf_file;?>" />
		<param name="quality" value="high" />
		<param name="wmode" value="opaque" />
		<param name="swfversion" value="9.0.45.0" />
		<!-- �� param ��ǩ��ʾʹ�� Flash Player 6.0 r65 �͸��߰汾���û��������°汾�� Flash Player��������������û���������ʾ���뽫��ɾ���� -->
		<param name="expressinstall" value="Scripts/expressInstall.swf" />
		<param name="SCALE" value="exactfit" />
		<!-- ��һ�������ǩ���ڷ� IE �����������ʹ�� IECC ����� IE ���ء� -->
		<!--[if !IE]>-->
		<object data="<?php echo $swf_file;?>" type="application/x-shockwave-flash" width="<?= $swf_w?>" height="<?= $swf_h?>" align="top">
			<!--<![endif]-->
			<param name="quality" value="high" />
			<param name="wmode" value="opaque" />
			<param name="swfversion" value="9.0.45.0" />
			<param name="expressinstall" value="includes/javascript/expressInstall.swf" />
			<param name="SCALE" value="exactfit" />
			<!-- ��������������������ʾ��ʹ�� Flash Player 6.0 �͸��Ͱ汾���û��� -->
			<div>
				<h4><?php echo db_to_html("��ҳ���ϵ�������Ҫ���°汾�� Adobe Flash Player��")?></h4>
				<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" width="112" height="33" /></a></p>
			</div>
			<!--[if !IE]>-->
		</object>
		<!--<![endif]-->
	</object>
</div>
<script type="text/javascript">
<!--
swfobject.registerObject("FlashID");
//-->
</script>
<?php
}else{ echo db_to_html("�����ڵĵ�ͼ�ļ���"); };
?>
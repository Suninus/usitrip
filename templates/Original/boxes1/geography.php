<?php
$geographyData[]=array('cid'=>'25','name'=>db_to_html('�� ��'));
$geographyData[]=array('cid'=>'24','name'=>db_to_html('�� ��'));
$geographyData[]=array('cid'=>'33','name'=>db_to_html('������'));
$geographyData[]=array('cid'=>'196','name'=>db_to_html('��ɫ������'));
$geographyData[]=array('cid'=>'54','name'=>db_to_html('���ô�'));
$geographyData[]=array('cid'=>'208','name'=>db_to_html('��������'));
$geographyData[]=array('cid'=>'157','name'=>db_to_html('ŷ ��'));
$geographyData[]=array('cid'=>'193','name'=>db_to_html('�� ��'));
?>
<div class="title titleBig">
        <b></b><span></span>
        <h3><?php echo db_to_html('ɸѡ�������')?></h3>
      </div>
      <dl class="place placeBot">
        <dt><?php echo db_to_html('������λ�ò鿴��')?></dt>
<?php
foreach($geographyData as $geography){
	$class = $cid==$geography['cid']?' class="selected"':'';
?>
        <dd><a href="<?php echo makesearchUrl('cid',$geography['cid']);?>"<?php echo $class?>><?php echo $geography['name']?></a></dd>
<?}?>
</dl>
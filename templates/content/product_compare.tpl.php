<link href="<?php echo DIR_WS_TEMPLATES . TEMPLATE_NAME . '/page_css/index_products.css'?>" rel="stylesheet" type="text/css" />
    <div class="title titleSmall titleCompare">
      <b></b><span></span>
      <h3><?php echo db_to_html($_h3Title)?></h3>
    </div>
<?php
$n = count($DataList);
$countWidth = 287*3;

$canCompare = true;

if($n>1){
	foreach($_isHotels as $key => $val){
		if($_isHotels[0]!=$val){
			//�Ա�ҳ��ֻ�ǶԱ�����һ�µĲ�Ʒ��Ҳ����˵�г�ֻ�ܺ��г̶Աȣ��Ƶ�ֻ�ܺ;Ƶ�Աȡ�
			$canCompare = false;
			$errorMsn = "�����ܰ���ͨ�г���Ƶ�ŵ�һ��Աȣ�";
		}
	}
}else{
	$canCompare = false;
	$errorMsn = "������Ӧѡ��2����Ŀ���жԱȣ�";
}

if($canCompare == true){
?>
    <table cellpadding="0" cellspacing="0" border="0" class="compareTable">
      <tr>
        <td class="left"><?php echo db_to_html($_prodNameTitle)?></td>
<?php for($i=0;$i<$n;$i++){?>
        <td style="width:<?php echo $countWidth/$n;?>px;"><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $DataList[$i]['products_id'])?>" target="_blank"><h1><?php echo db_to_html($DataList[$i]['products_name'])?></h1></a><h2><?php echo db_to_html($DataList[$i]['products_name1'])?></h2></td>
<?php }?>
      </tr>
      <tr>
        <td class="left"><?php echo db_to_html('���ķ��۸�')?></td>
<?php for($i=0;$i<$n;$i++){?>
        <td class="even"><h3><?php echo $currencies->display_price($DataList[$i]['final_price'],tep_get_tax_rate($DataList[$i]['products_tax_class_id']))?></h3></td>
<?php }?>
      </tr>
      <tr>
        <td class="left"><?php echo db_to_html($_prodModelTitle)?></td>
<?php for($i=0;$i<$n;$i++){?>
        <td><?php echo db_to_html($DataList[$i]['products_model'])?></td>
<?php }?>
      </tr>
<?php
if($_isHotels[0]==1){
?>
	  <tr>
        <td class="left"><?php echo db_to_html('�Ƶ꼶��')?></td>
<?php for($i=0;$i<$n;$i++){?>        
        <td class="even"><p class="stars<?= (int)$DataList[$i]['hotel_stars']?>"><?php echo db_to_html($DataList[$i]['hotel_stars'].'��')?></p></td>
<?php }?>
      </tr>
	  <tr>
        <td class="left"><?php echo db_to_html('��ͷ���')?></td>
<?php for($i=0;$i<$n;$i++){?>        
        <td><?php echo db_to_html(getHotelMealsOptions($DataList[$i]['meals_id']));?></td>
<?php }?>
      </tr>
	  <tr>
        <td class="left"><?php echo db_to_html('��������')?></td>
<?php for($i=0;$i<$n;$i++){?>        
        <td class="even"><?php echo db_to_html(getHotelInternetOptions($DataList[$i]['internet_id']))?></td>
<?php }?>
      </tr>
	  <tr>
        <td class="left"><?php echo db_to_html('�Ƶ�λ��')?></td>
<?php for($i=0;$i<$n;$i++){?>        
        <td><?php echo db_to_html(getHotelApproximateLocation($DataList[$i]['approximate_location_id']))?></td>
<?php }?>
      </tr>
	  <tr>
        <td class="left"><?php echo db_to_html('�Ƶ�绰')?></td>
<?php for($i=0;$i<$n;$i++){?>        
        <td class="even"><?php echo db_to_html($DataList[$i]['hotel_phone'])?></td>
<?php }?>
      </tr>
	  <tr>
        <td class="left"><?php echo db_to_html('�Ƶ��ַ')?></td>
<?php for($i=0;$i<$n;$i++){?>        
        <td><?php echo db_to_html($DataList[$i]['hotel_address'])?></td>
<?php }?>
      </tr>
<?php
	$_tmpTitle = "���ڳ���";
}else{
	$_tmpTitle = "��������";
}
?>      
	  <tr>
        <td class="left"><?php echo db_to_html($_tmpTitle)?></td>
<?php for($i=0;$i<$n;$i++){?>        
        <td class="even"><?php echo db_to_html(join(', ',$DataList[$i]['s_city']))?></td>
<?php }?>
      </tr>
<?php if($_isHotels[0]!=1){?>      
	  <tr>
        <td class="left"><?php echo db_to_html('��������')?></td>
<?php for($i=0;$i<$n;$i++){?>        
        <td><?php echo db_to_html(join(', ',$DataList[$i]['e_city']))?></td>
<?php }?>
      </tr>
      <tr>
        <td class="left"><?php echo db_to_html('��������')?></td>
<?php for($i=0;$i<$n;$i++){?>        
        <td class="even"><?php echo join('<br>',$DataList[$i]['operate'])?></td>
<?php }?>
      </tr>
<?php }?>

<?php 
$_tmpTitle = "��Ҫ����";
if($_isHotels[0]==1){ $_tmpTitle = "�Ƶ���"; }
?>	  
      <tr>
        <td class="left"><?php echo db_to_html($_tmpTitle)?></td>
<?php for($i=0;$i<$n;$i++){?>
        <td><?php echo ($DataList[$i]['products_small_description'])?></td>
<?php }?>
      </tr>
<?php
if($_isHotels[0]!=1){
	for($x=0;$x<$maxTravelnum;$x++){
		$trclass = $x==($maxTravelnum-1)?'even':($x%2?'even evenB':'evenB');
		$firsttdcls = ($x==($maxTravelnum-1))?'left':'left leftB';
		$firsttdstl = ($x==0||$x==($maxTravelnum-1))?'':' style="border-bottom:#F3FBFE"';
?>
      <tr>
        <td class="<?php echo $firsttdcls?>"<?php echo $firsttdstl?>><?php if($x==0){echo db_to_html('�г̽���');}?></td>
<?php for($i=0;$i<$n;$i++){?>
        <td class="<?php echo $trclass?>">
        <?php if($DataList[$i]['travel'][$x]){?>
          <div>
          <b><?php echo db_to_html("��".($x+1)."��")?></b>
          <?php echo db_to_html($DataList[$i]['travel'][$x]['travel_name'])?>
          </div>
          <?php 
		  if(is_array($DataList[$i]['travel'][$x]['travel_hotel']) && count($DataList[$i]['travel'][$x]['travel_hotel'])>0){
		  ?>
          <div>
          <span class="hotel"><?php echo db_to_html('�Ƶ�:')?>
          <?php
			    $hotelext='';
				foreach($DataList[$i]['travel'][$x]['travel_hotel'] as $shotel){
					echo $hotelext.db_to_html($shotel['name']);
					$hotelext = ', ';
				}
				echo db_to_html('����ͬ�ȼ��Ƶ�');
		  ?>
           </span>
           </div>
		   <?php }?>
        <?php }?>
        </td>
<?php }?>
      </tr>
<?php 
	}
}
?>
      <tr>
        <td class="left" rowspan="3"><?php echo db_to_html('�۸���ϸ')?></td>
<?php for($i=0;$i<$n;$i++){?>
        <td class="evenB">
        <b><?php echo db_to_html('��׼�۸�')?></b> <br />
        <?php if($DataList[$i]['display_room_option'] == '1'){?>
			<?php if($DataList[$i]['products_double']>0){echo db_to_html('˫��һ����').$currencies->display_price($DataList[$i]['products_double'],$DataList[$i]['products_tax_class_id'])?><br /><?php } ?>
            <?php if($DataList[$i]['products_triple']>0){echo db_to_html('����һ����').$currencies->display_price($DataList[$i]['products_triple'],$DataList[$i]['products_tax_class_id'])?><br /><?php } ?>
            <?php if($DataList[$i]['products_quadr']>0){echo db_to_html('����һ����').$currencies->display_price($DataList[$i]['products_quadr'],$DataList[$i]['products_tax_class_id'])?><br /><?php } ?>
            <?php if($DataList[$i]['products_single']>0){echo db_to_html('����һ����').$currencies->display_price($DataList[$i]['products_single'],$DataList[$i]['products_tax_class_id'])?><br /><?php } ?>
            <?php if($DataList[$i]['products_single_pu']>0){echo db_to_html('�����䷿��').$currencies->display_price($DataList[$i]['products_single_pu'],$DataList[$i]['products_tax_class_id'])?><br /><?php } ?>
            <?php if($DataList[$i]['products_kids']>0){echo db_to_html('С��������').$currencies->display_price($DataList[$i]['products_kids'],$DataList[$i]['products_tax_class_id'])?><br /><?php } ?>
        <?php }else{?>
        	<?php if($DataList[$i]['products_single']>0){echo db_to_html('���ˣ�').$currencies->display_price($DataList[$i]['products_single'],$DataList[$i]['products_tax_class_id'])?><br /><?php } ?>
            <?php if($DataList[$i]['products_kids']>0){echo db_to_html('С����').$currencies->display_price($DataList[$i]['products_kids'],$DataList[$i]['products_tax_class_id'])?><br /><?php } ?>
        <?php }?>
        </td>
<?php }?>
      </tr>
      <tr>
<?php for($i=0;$i<$n;$i++){?>
        <td class="even evenB">
        <b><?php echo db_to_html('���ð���')?></b> <br />
		<?php echo ($DataList[$i]['products_other_description'])?>
        </td>
<?php }?>
      </tr>
      <tr>
<?php for($i=0;$i<$n;$i++){?>
        <td>
        <b><?php echo db_to_html('���ò�����')?></b> <br />
		<?php echo ($DataList[$i]['products_package_excludes'])?>
        </td>
<?php }?>
      </tr>
    </table>
<?php
}else{
?>
<table cellpadding="0" cellspacing="0" border="0" class="compareTable">
      <tr>
        <td class="left"><?php echo db_to_html('��ʾ��')?></td>
        <td><h1><?php echo db_to_html($errorMsn);?></h1></td>
        <td></td>
        <td></td>
      </tr>
</table>
<?php
}
?>
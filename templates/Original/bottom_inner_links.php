<?php
$no_show_cat_city_and_tours = false;

if(preg_match('/^24_/',$cPath)){	//�������µ��Ӿ���
	$no_show_cat_city_and_tours = true;
	$sql_query = tep_db_query('SELECT c.categories_id,cd.categories_name FROM `categories` c, `categories_description` cd WHERE c.parent_id = "24" AND c.categories_id =cd.categories_id  AND c.categories_status="1" order by c.categories_id ');
	while($rows=tep_db_fetch_array($sql_query)){
?>
	<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath='.$rows['categories_id']);?>"><?php echo db_to_html(preg_replace('/ .+/','',$rows['categories_name']).'����')?></a>
<?php
	}
}
?>

<?php
if(preg_match('/^25_/',$cPath)){	//�������µ��Ӿ���
	$no_show_cat_city_and_tours = true;
	$sql_query = tep_db_query('SELECT c.categories_id,cd.categories_name FROM `categories` c, `categories_description` cd WHERE c.parent_id = "25" AND c.categories_id =cd.categories_id  AND c.categories_status="1" order by c.categories_id ');
	while($rows=tep_db_fetch_array($sql_query)){
?>
	<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath='.$rows['categories_id']);?>"><?php echo db_to_html(preg_replace('/ .+/','',$rows['categories_name']).'����')?></a>
<?php
	}
}
?>

<?php
if(preg_match('/^54_/',$cPath)){	//���ô���Ӿ���
	$no_show_cat_city_and_tours = true;
	$sql_query = tep_db_query('SELECT c.categories_id,cd.categories_name FROM `categories` c, `categories_description` cd WHERE c.parent_id = "54" AND c.categories_id =cd.categories_id  AND c.categories_status="1" order by c.categories_id ');
	while($rows=tep_db_fetch_array($sql_query)){
?>
	<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath='.$rows['categories_id']);?>"><?php echo db_to_html(preg_replace('/ .+/','',$rows['categories_name']).'����')?></a>
<?php
	}
}
?>


<?php
if($no_show_cat_city_and_tours==false && (int)$cPath>0 || $content=='index_default'){//��ҳ��Ŀ¼ҳ
?>
<span style="color:#627FAF"><?php echo db_to_html('�������У�')?></span>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=29');?>"><?php echo db_to_html('��ɼ�����')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=30');?>"><?php echo db_to_html('�ɽ�ɽ����')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=32');?>"><?php echo db_to_html('��˹ά��˹����')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=55');?>"><?php echo db_to_html('ŦԼ����')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=52');?>"><?php echo db_to_html('��ʢ������')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=59');?>"><?php echo db_to_html('��ʿ������')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=148');?>"><?php echo db_to_html('�¸绪����')?></a>

<?php
}//��ҳend
?>

<br>


<?php
if($no_show_cat_city_and_tours==false && (int)$cPath>0 || $content=='index_default'){//��ҳ��Ŀ¼ҳ
?>

<span style="color:#627FAF"><?php echo db_to_html('���ž��㣺')?></span>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=35');?>"><?php echo db_to_html('��ʯ��԰����')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=142');?>"><?php echo db_to_html('��Ͽ������')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=48');?>"><?php echo db_to_html('��ʤ��������')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=41');?>"><?php echo db_to_html('���⹫԰����')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=57');?>"><?php echo db_to_html('���Ǽ����ٲ�����')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=151');?>"><?php echo db_to_html('���ɽ����')?></a>
<a style="color:#627FAF" href="<?=tep_href_link(FILENAME_DEFAULT, 'cPath=33');?>"><?php echo db_to_html('����������')?></a>
<?php
	if($content=='index_default'){	//ֻ����ҳ����ʾ
?>
<br>
<span style="color:#627FAF"><?php echo db_to_html('�������ӣ�')?></span>
<a style="color:#627FAF" href="<?=tep_href_link('links.php', 'cId=1');?>"><?php echo db_to_html('����1')?></a>
<a style="color:#627FAF" href="<?=tep_href_link('links.php', 'cId=2');?>"><?php echo db_to_html('����2')?></a>
<a style="color:#627FAF" href="<?=tep_href_link('links.php', 'cId=3');?>"><?php echo db_to_html('����3')?></a>
<a style="color:#627FAF" href="<?=tep_href_link('links.php', 'cId=4');?>"><?php echo db_to_html('����4')?></a>
<a style="color:#627FAF" href="<?=tep_href_link('links.php', 'cId=5');?>"><?php echo db_to_html('����5')?></a>

<?php
	}
}//��ҳend
?>


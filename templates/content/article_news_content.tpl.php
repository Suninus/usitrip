<DIV class="product_content22" style="margin-top:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="74%" valign="top"><div style="width:95%; margin-left:10px; margin-top:10px; text-align:center;"> <h2><?php echo db_to_html($rows['news_title'])?><br>
    <p style=" color:#6f6f6f; font-size:12px; font-weight:normal; margin-top:4px;"><?php echo db_to_html($rows['news_add_date'])?></p> </h2></div><div style="background:#EDF8FE; border:1px solid #B8E4FD; width:93%; margin-left:10px; margin-top:15px; padding:15px; line-height:21px;
    " >
<div>
<?php

//��ʾ������������������
$thesaurus_ids = $rows['thesaurus_ids'];
$news_description = get_thesaurus_replace($rows['news_description'],$thesaurus_ids,1);

echo db_to_html($news_description);
?>
</div>

<?php 
//�������
if(tep_not_null($rows['news_links_ids'])){
	$links_news_sql = tep_db_query('SELECT * FROM `seo_news` WHERE news_id in ('.$rows['news_links_ids'].') AND news_state="1" ');
	$links_rows = tep_db_fetch_array($links_news_sql);
	if((int)$links_rows['news_id']){
?>
<div style="background:#fff; margin-top:35px; padding:5px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr><td width="53%"><?php echo sprintf(db_to_html('�� <b>%s</b>  ���������'),db_to_html($rows['news_title']));?></td>
  <td width="47%"><hr width="90%" size="1" noshade >
</td></tr></table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr style="height:6px;"><td></td></tr>
<?php do{?>
<tr><td width="3%">&#8231;</td>
  <td width="97%"> <a href="<?php echo tep_href_link('article_news_content.php','news_id='.(int)$links_rows['news_id'])?>"><?php echo db_to_html(strip_tags($links_rows['news_title']))?></a> <span style=" color:#6f6f6f; font-size:12px;"><?php echo preg_replace('/[[:space:]]+.+$/','',$links_rows['news_add_date'])?></span></td>
</tr>
<?php }while($links_rows = tep_db_fetch_array($links_news_sql));?>
</table>
</div>
<?php 
	}
}
//������� end
?>

    </div>
    <div style="text-align:center; margin:20px 0px 15px 0px;"><a href="<?php echo tep_href_link('seo_news.php')?>"><img src="image/back_news_list_button.gif"></a></div></td>
    <td width="26%" valign="top" >
	<?php /* ���Ͻǹ�沿�� 
		<div style="float:left; margin-left:10px; margin-top:8px; width:225px;">����ȫ�ǹ�档����225px����Ҫ����ֱ�Ӹ��ƴ������������ʲôӡ��Ϊ��ȷ�����ҾͲ������ˣ������ڿ��ϵĲ��ַŸ�ͼƬ��֮������֡�
		</div>
		<div style="float:left; margin-left:10px; margin-top:10px; width:217px; line-height:16px;">����ȫ�ǹ�档����225px������4ͼԪ���ڱ߾�,�о���16px
		</div>
	*/?>
 
 
 <div style="float:left; margin-left:10px; margin-top:10px; width:217px; line-height:16px;">
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr><td width="27%"><?php echo db_to_html('��������')?></td>
  <td width="73%"><hr width="90%" size="1" noshade >
</td></tr></table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr style="height:4px;"><td></td></tr>
<?php 
//��������
$new_news_sql = tep_db_query('SELECT * FROM `seo_news` WHERE news_state="1" order by news_id DESC limit 5');
while($new_news_rows = tep_db_fetch_array($new_news_sql)){
?>
<tr><td width="3%" height="20">&#8231;</td>
  <td width="97%"> <a href="<?php echo tep_href_link('article_news_content.php','news_id='.$new_news_rows['news_id'])?>" class="text2"><?php echo db_to_html($new_news_rows['news_title'])?></a></td>
</tr>
<?php
}
//�������� end
?>
</table>

 </div>
 <div style="float:left; margin-left:10px; margin-top:10px; width:217px; line-height:16px;">
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr><td width="27%"><?php echo db_to_html('��������')?></td>
  <td width="73%"><hr width="90%" size="1" noshade >
</td></tr></table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr style="height:4px;"><td></td></tr>
<?php 
//��������
$hot_news_sql = tep_db_query('SELECT * FROM `seo_news` WHERE news_state="1" order by  news_click_num DESC, news_id DESC limit 5');
while($hot_news_rows = tep_db_fetch_array($hot_news_sql)){
?>
<tr><td width="3%" height="20">&#8231;</td>
  <td width="97%"> <a href="<?php echo tep_href_link('article_news_content.php','news_id='.$hot_news_rows['news_id'])?>" class="text2"><?php echo db_to_html($hot_news_rows['news_title'])?></a></td>
</tr>
<?php
}
//�������� end
?>
</table>

 </div></td>
  </tr>
</table>


</DIV>

<table width="100%" border=0>
<tr><td width="50%" valign="top">
<table class="tableList" >
<caption><h4><?php echo $LIST_TITLE ?> </h4><small><?php echo $start_date ?> - <?php echo $end_date ?></small></caption>
<tr class="heading">
<th width="40%">��Ŀ</th>
<th width="30%">����</th>
<th width="30%">ÿ��ƽ��</th>
</tr>
<?php  foreach ($records as $record){?>
<tr onmouseover="this.style.background='#ffc'" onmouseout="this.style.background=''" >
	<td><?php echo $record['statsName']?></td>
	<td><?php echo $record['total']?></td>
	<td><?php echo $record['avg']?></td>
</tr>
<?php }?>
</table>

<table class="tableList" >
<caption><h4>������ʷ�����ֲ� </h4><small><?php echo $start_date ?> - <?php echo $end_date ?></small></caption>
<tr class="heading">
<th width="50%">��Ŀ</th>
<th width="50%">����</th>
</tr>
<?php $total = 0 ;  foreach ($records3 as $record){?>
<tr onmouseover="this.style.background='#ffc'" onmouseout="this.style.background=''" >
	<td><?php echo tep_get_orders_status_name($record['orders_status_id'])?></td>
	<td><?php echo $record['total']?></td>
</tr>
<?php $total+= intval($record['total']);}?>
<tr class="total" >
	<td>�ϼ�</td>
	<td ><?php echo $total?></td>
</tr>
</table>

</td>

<td width="50%" valign="top">

<table class="tableList" >
<caption><h4>�����������ͳ�� </h4><small><?php echo $start_date ?> - <?php echo $end_date ?></small></caption>
<tr class="heading">
<th width="50%">��Ŀ</th>
<th width="50%">����</th>
</tr>
<?php $total=0; foreach ($records2 as $record){?>
<tr onmouseover="this.style.background='#ffc'" onmouseout="this.style.background=''" >
	<td><?php echo tep_get_orders_status_name($record['orders_status'])?></td>
	<td><?php echo $record['total']?></td>
</tr>
<?php $total+= intval($record['total']);}?>
<tr class="total" >
	<td>��������</td>
	<td ><?php echo $total?></td>
</tr>
</table>
</td></tr></table>
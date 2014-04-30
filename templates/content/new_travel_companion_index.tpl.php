<?php
//�°� start
?>
<style type="text/css">
.widget .companion li {
    overflow: hidden;
    text-align: left;
	line-height: 16px;
    padding: 5px 10px;
}
.widget .companion li a {
    float: left;
    width: 75%;
}
.widget ul{
-moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color:#C5E6F9;
    border-image: none;
    border-style: none solid solid;
    border-width: 0 1px 1px;
    padding: 5px 0;
}
.companion {
    color: #777777;
    text-align: right;
}
</style>
<?php


//������Ŀ¼24/25/33/34
function get_categories_tree2($categories_ids=false, $level=0, $include_self=true){
	global $languages_id;
	
	$data = false;
	$where_cat_ids='';
	if($categories_ids!=false && strlen($categories_ids)){
		$tmp_array = explode(',',$categories_ids);
		$count = count($tmp_array);
		if( $count > 1 ){
			$where_cat_ids =" AND c.categories_id in(".$categories_ids.") ";
		}else{
			$where_cat_ids =" AND c.categories_id ='".$categories_ids."' ";
		}
	}
    if($include_self==false){
		$where_cat_ids =" AND c.parent_id in('".$categories_ids."') ";
	}

	//echo "select c.categories_id, cd.categories_name, c.parent_id, c.categories_status_for_tc_bbs_display as bbs_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.categories_status =1  and c.categories_status_for_tc_bbs =1 ".$where_cat_ids ." ORDER BY FIND_IN_SET(c.categories_id,'" .$categories_ids . "'),  bbs_status DESC, c.sort_order, c.tc_bbs_total desc, c.parent_id, cd.categories_name";
	$categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id, c.categories_status_for_tc_bbs_display as bbs_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.categories_status =1  and c.categories_status_for_tc_bbs =1 ".$where_cat_ids ." ORDER BY FIND_IN_SET(c.categories_id,'" .$categories_ids . "'),  bbs_status DESC, c.sort_order, c.tc_bbs_total desc, c.parent_id, cd.categories_name");
	$string = "";
	$i = 0;
	while($rows = tep_db_fetch_array($categories_query)){
		$TcPath = tep_get_category_patch($rows['categories_id']);

		//ȡ�õڶ����˵�
		$sql_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id, c.categories_status_for_tc_bbs_display as bbs_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.categories_status =1  and c.categories_status_for_tc_bbs =1 AND c.parent_id = ".$rows['categories_id']." ORDER BY  bbs_status DESC, c.sort_order, c.tc_bbs_total desc, c.parent_id, cd.categories_name");
		$rows2 = tep_db_fetch_array($sql_query);
		if((int)$rows2['categories_id']){
			//$string .= '<li class="imatm" style="width:100%">';
			//$string .= '<a href="'.tep_href_link('new_travel_companion_index.php','TcPath='.$TcPath).'"><span class="imea imeam"><span></span></span>'.preg_replace('/ .+/','',$rows['categories_name']).'</a>';
			$data[$i]['link'] = tep_href_link('new_travel_companion_index.php','TcPath='.$TcPath);
			$data[$i]['id'] = $rows['categories_id'];
			$data[$i]['title'] = preg_replace('/ .+/','',$rows['categories_name']);
			
			//$string .= '<div class="imsc"><div class="imsubc" style="width:364px; top:-52px; left:181px;"><ul class="subul"><li><dl>';
			do{
				$TcPath = tep_get_category_patch($rows2['categories_id']);
				//$string .= '<dd><a href="'.tep_href_link('new_travel_companion_index.php','TcPath='.$TcPath).'">'.preg_replace('/ .+/','',$rows2['categories_name']).'</a></dd>';
				$data[$i]['subdata'][$rows2['categories_id']] = array('link' => tep_href_link('new_travel_companion_index.php','TcPath='.$TcPath), 'name' => preg_replace('/ .+/','',$rows2['categories_name'])); 
			}while($rows2 = tep_db_fetch_array($sql_query));
			//$string .= '</dl></li></ul></div></div>';
		}else{
			//$string .= '<li class="nomatm" style="width:100%">';
			//$string .= '<a href="'.tep_href_link('new_travel_companion_index.php','TcPath='.$TcPath).'"><span class="imea imeam"><span></span></span>'.preg_replace('/ .+/','',$rows['categories_name']).'</a>';
			$data[$i]['title'] = preg_replace('/ .+/','',$rows['categories_name']);
			$data[$i]['subdata'] = array();
		}
		
		//$string .= '</li>';
		$i++;
	}
	return $data;
}

?>

<?php
//�°�֪ͨ
if(!tep_not_null($HiddenNewVersionNote)){
/*?>
<div id="NewVersionNote" class="jbIndex_notes"><?php echo db_to_html('�°���ͬ������������ӭ���Ĺ��٣��°���ͬ�θո����ߣ����ᱣ����ǰ���ѷ��������н��ͬ�����������°���ͬ�������˺ܶ๦�ܣ����磺�����������͡��������ص㡱������״̬����Ѱ���Ա𡱹������Ӻ͡������顱��ͬ�����롱�ȹ��ܽ�����ǰ�Ľ��ͬ������Ч���°�����ǰ�����Ľ�������Ǳ�עΪV1��<br>
�°����ߺ��������ġ�������������͡�δȷ����·������������ʹ�������������ܣ���������Ĳ��㣬����ԭ�£�Ԥף�����ճɹ����ͬ�Ρ�');?><button id="NewVersionNoteButton" class="grzx_notes_button"><img src="/image/icons/X_s_on.gif" /></button></div>
<?php
*/}

$page_name = 'index.html';
if(strtolower(CHARSET)=="big5"){
	$page_name = 'index_f.html';
}
/*
?>
<div style="margin-left:-5px;">
<a href="/landing-page/2012-spring-offer/<?= $page_name;?>" target="_blank"><img src="image/banner_logo/<?= $language?>/new_travel_companion_index.940x80.jpg" /></a>
</div>
<?php */ ?>
<div class="item_left">
<div class="posted_line">
		<?php
		
		 if($Tccurrent_category_id>0){echo(db_to_html('<p><b>ȥ<i class="posted_title">'.tep_get_categories_name($Tccurrent_category_id).' </i>��ؽ����</b></p>'));}?>
		<a class="posted_btn" href="javascript:void(0)" onclick="showPopup('CreateNewCompanion','CreateNewCompanionCon',1);">
			<img alt="<?php echo db_to_html('��������');?>" src="/image/nav/posted_line_btn.png" />
		</a>
		<p><?php echo db_to_html('���������');?><i><?php echo $rows_count;?></i></p>
</div>
<?php
	
	/*
		$key = "companion_".intval($products_id) ;
		$data = MCache::instance()->fetch($key,MCache::HOURS); //ÿСʱ����һ��
		if($data != '') 
			echo db_to_html($data) ;
		else{*/
		require_once('travel_companion_tpl.php');
			ob_start();
//���ͬ�������б� start
$product_info_travel_companion = TRAVEL_COMPANION_OFF_ON;
if($product_info_travel_companion== 'true'){
	//ͳ�Ƶ�ǰ�ŵĽ��ͬ������
	$sql = tep_db_query('SELECT count(*) as total  FROM `travel_companion` WHERE products_id="'.(int)$products_id.'" AND status=1 ');
	$row = tep_db_fetch_array($sql);
	$total_companion = (int)$row['total'];
	//ȡ�õ�ǰ�ŵ�����Ŀ¼
	if((int)count($cPath_array)){
		$categories_id = $cPath_array[(count($cPath_array)-1)];
		$categories_name = preg_replace('/ .+/','',tep_get_categories_name($categories_id,1));
	}

	

	//$travel_sql = tep_db_query('SELECT * FROM `travel_companion` WHERE products_id="'.(int)$products_id.'" AND status=1 ORDER BY t_companion_id DESC Limit 10 ');
	if(isset($_GET['type'])&&$_GET['type']!=''){
		$my_where ='and _type='.(int)$_GET['type'];
	}
	$travel_sql = tep_db_query('SELECT t_companion_id,t_companion_title,customers_name,DATE_FORMAT(hope_departure_date,\'%m/%e/%Y\') AS formated_add_time FROM `travel_companion` WHERE  status=1 '.$my_where.' AND  hope_departure_date>"'.date('Y-m-d').'" ORDER BY hope_departure_date ASC Limit 10 ');
	$travel_rows = tep_db_fetch_array($travel_sql);
//echo 'SELECT t_companion_id,t_companion_title,customers_name,DATE_FORMAT(add_time,\'%m/%e/%Y\') AS formated_add_time FROM `travel_companion` WHERE  status=1 AND _type='.(isset($_GET['_type'])?(int)$_GET['_type']:1).' ORDER BY t_companion_id DESC Limit 10 ';
	
?>
	<div class="widget mate_warp margin_b10">
		<div class=" title titleSmall ">

		<h3><?php echo '�������ͬ��';?></h3><span><a  href="javascript:void(0)" onclick="showPopup(&quot;CreateNewCompanion&quot;,&quot;CreateNewCompanionCon&quot;,'off','','','fixedTop','CreateNewCompanionLink');"><?php echo '��Ҫ����'?></a></span>
	</div>
	<ul class="companion">
		<?php
		if((int)$travel_rows['t_companion_id']){
			do{
			$sir_ro_ms = '';
			if((int)$travel_rows['t_gender']=='1'){
				//$sir_ro_ms = '����';
			}
			if((int)$travel_rows['t_gender']=='2'){
				//$sir_ro_ms = 'Ůʿ';
			}
		?>
		<li><a title="<?php echo tep_db_output($travel_rows['t_companion_title']);?>" href="<?php echo tep_href_link('new_bbs_travel_companion_content.php','t_companion_id='.(int)$travel_rows['t_companion_id']).$TcPaStr?>"><?php echo cutword(tep_db_output($travel_rows['t_companion_title']),22);?></a>
		<span style="display:none"><?php 
		echo tep_db_output($travel_rows['customers_name']). $sir_ro_ms;?></span><?php echo date('m��d��',strtotime($travel_rows['formated_add_time'])); #echo substr($travel_rows['formated_add_time'],0,10).'����'?>
			<?php
				$TcPaStr = '';
				if(tep_not_null($TcPath)){
					$TcPaStr = '&TcPath='.$TcPath;
				}
				?>
		</li>
		<?php
			}while($travel_rows = tep_db_fetch_array($travel_sql));
		}else{
			echo '<li>Ѱ���ΰ飬ƴ����ʡ���ðɣ�</li>';
		}
		?>
		  
	</ul>
    <div class="del_float"></div>
	</div>
			
<?php
	$data = ob_get_clean() ;
	echo  db_to_html($data);
/*
$data = ob_get_clean() ;
MCache::instance()->add($key,$data);
echo  db_to_html($data);}*/
		
}
?>
<?php 
//������
include_once(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'search.php');

include_once(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'special.php');//�����ؼ�
//С�����
$banner_name = 'bbs_list_left 265px';
$search_banner = true;
include(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'banner_box.php');
?>
<?php
include_once(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/boxes1/' .'contact_us.php');//��ϵ����


//�������⳵��˾��� start{ ��2013-07-04 ��ȥ��
if(0){
?>
<iframe id="externalAdvertising" width="263" scrolling="no" height="370" frameborder="0" src="">autos</iframe>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#externalAdvertising').attr('src','http://www.rentalcars.com/affxml/Home.do?affiliateCode=usitrip&preflang=zs');
});
</script>

<?php
}
//�������⳵��˾��� end}

// �ұ߿�ʼ������  by  lwkai add {

// ԭ���������Ŀ ���ڻ��µ���  by lwkai 2012-04-01 start {
/*
?>

<div class="jb_left">
  <div class="box1">
    <span class="tl"></span><span class="tr"></span>
      <div class="cc">
        <h3><?php echo db_to_html('��������ҽ��ͬ��');?></h3>
       </div>
  </div>
	<div class="imrcmain0 imgl" style="width:183px; border:1px solid #58baf9; border-top:none; z-index:100;position:relative; height:auto">
	<div class="imcm imde" id="imouter0">
	<ul id="imenus0">
	  <h3 style="font-size:14px; color:#00398a; padding:15px 0 5px 10px"><?php echo db_to_html('�������');?></h3>

	  <?php #echo db_to_html(get_categories_tree2('24,25,33,34','0',true));?>
	  
	  <h3 style="font-size:14px; color:#00398a; padding:15px 0 5px 10px"><?php echo db_to_html('���ô���')?></h3>
	  <?php #echo db_to_html(get_categories_tree2('54','0',true));?>

	  <h3 style="font-size:14px; color:#00398a; padding:15px 0 5px 10px"><?php echo db_to_html('ŷ�޽��')?></h3>
	  <?php #echo db_to_html(get_categories_tree2('157','0',true));?>

	</ul>
	<div class="imclear">&nbsp;</div></div></div>
</div>
<script type="text/javascript" src="includes/javascript/ocscript.js"></script>

<?php
//������������ start
if((int)count($_COOKIE['view_history'])){
?>
<div class="item_left1">
     <div class="box2">
	 <img class="box_f_l" src="image/box2_bg_l.jpg" />

        <h3><?php echo db_to_html('������������');?></h3>
		<img class="box_f_r" src="image/box2_bg_r.jpg" />

  </div>
  <div class="item_left_sec" style="width:183px; border:1px solid #c5e6f9; border-top:none;">
   <ul>
	<?php
	$tmp_var = 0;
	foreach ($_COOKIE['view_history'] as $key => $value){
		$tmp_var++;
		if($tmp_var<9){
			$sql = tep_db_query("select p.products_id, p.products_price, p.products_tax_class_id, pd.products_name FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$value['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
			$row = tep_db_fetch_array($sql);
			if((int)$row['products_id']){
				$price_text = "";
				$tour_agency_opr_currency = tep_get_tour_agency_operate_currency($row['products_id']);
				if($tour_agency_opr_currency != 'USD' && $tour_agency_opr_currency != ''){
					$row['products_price'] = tep_get_tour_price_in_usd($row['products_price'],$tour_agency_opr_currency);
				}
				if (tep_get_products_special_price($row['products_id'])) 
				{
					$price_text.= '<span class="sp8">' .  $currencies->display_price($row['products_price'], tep_get_tax_rate($row['products_tax_class_id'])) . '</span>&nbsp;&nbsp;<span class="sp2">' . $currencies->display_price(tep_get_products_special_price($row['products_id']), tep_get_tax_rate($row['products_tax_class_id'])) . '</span>';
				} 
				else 
				{
					$price_text.= '<span class="sp2">'.$currencies->display_price($row['products_price'], tep_get_tax_rate($row['products_tax_class_id'])).'</span>';
				}
				echo db_to_html('<li><a title="'.tep_db_output($row['products_name']).'" href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $row['products_id']).'" class="text">'.cutword(tep_db_output($row['products_name']),78).'</a><br />'.$price_text.'</li>');
			}
		}
	}
	?>
	 
   </ul>   
  </div>
</div>
<?php
}
//������������ end
?>

<div class="item_left1">
	 <a href="<?php echo tep_href_link('vote_system.php','v_s_id=9');?>" target="_blank"><img src="image/banner_logo/<?= $language?>/survey_180x110.jpg" /></a>
</div>


<?php
*/
// ԭ����߽��� end  by lwkai 2012-04-01 }

?>  
</div>


<?php  
// ��߽��� end }
 
// �ұ߿�ʼ start {?>
<div class="jb_right">
 <div class="jieban_bar">
 <span class="bar">
<?php
/*if($Tccurrent_category_id>0){
	echo trim($breadcrumb->_trail[(sizeof($breadcrumb->_trail)-1)]['title']);
}else{
	echo db_to_html('���ͬ��');
}*/


		if($Tccurrent_category_id>0){
	?>
	  <a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','TcPath','utm_source','utm_medium','utm_term','utm_campaign','utm_source','utm_medium','utm_term','utm_campaign')))?>" title="<?= db_to_html('ɾ��������')?>"><?php echo db_to_html('ȥ'.tep_get_categories_name($Tccurrent_category_id) . '��')?></a><?php
		}
	echo db_to_html('�����');  
?>
 </span>
 
<?php /*?> <a href="<?= tep_href_link('companions_process.php');?>" target="_blank"><span class="help_zs"><?= db_to_html('����')?></span><img src="image/icons/help.gif" onmouseout="show_travel_companion_tips(0,2073)" onmousemove="show_travel_companion_tips(1,2073)" target="_blank" style="z-index:4" /></a><?php */?>
</div>
<!--<div class="xtitle"><?php echo db_to_html('��Ŀ�ĵز��ҽ��ͬ������');?></div>-->

<div class="jb_right_tab">
	<ul>
		<li><b><?php echo(db_to_html('�������:'));?></b>
		<?php 
		$search_all_type1=$search_all_type2=$search_all_type3='a_fav';
		$search_all_type='a_fav jb_right_cf_a';
		switch($_type){
			case '1':
			$search_all_type1 = "a_selecd";
			break;
			case '2':
			$search_all_type2="a_selecd";
			break;
			case '3':
			$search_all_type3="a_selecd";
			break;
			default:
			$search_all_type='a_selecd jb_right_cf_a';
		}?>
		  <dl class="jb_cfaddress">
			  <dd><a href="<?= tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','products_id','customers_id','m_products_id','utm_source','utm_medium','utm_term','utm_campaign','type')));?>" class="<?php echo $search_all_type;?>"><?php echo(db_to_html('����'));?></a></dd>
			  <dd><a href="<?= tep_href_link('new_travel_companion_index.php','type=1&&'.tep_get_all_get_params(array('page','x', 'y','products_id','customers_id','m_products_id','utm_source','utm_medium','utm_term','utm_campaign','type')));?>" class="<?php echo $search_all_type1;?>"><?php echo(db_to_html('����ƴ��'));?></a></dd>
			  <dd><a href="<?= tep_href_link('new_travel_companion_index.php','type=2&&'.tep_get_all_get_params(array('page','x', 'y','products_id','customers_id','m_products_id','utm_source','utm_medium','utm_term','utm_campaign','type')));?>" class="<?php echo $search_all_type2;?>"><?php echo(db_to_html('������'));?></a></dd>
			  <dd><a href="<?= tep_href_link('new_travel_companion_index.php','type=3&&'.tep_get_all_get_params(array('page','x', 'y','products_id','customers_id','m_products_id','utm_source','utm_medium','utm_term','utm_campaign','type')));?>" class="<?php echo $search_all_type3;?>"><?php echo(db_to_html('�Լ���'));?></a></dd>
		  </dl>
	  </li>
   </ul>
</div>
<?php
// by lwkai  add Ŀ�ĵ�����
$fcw_data_arr = get_categories_tree2('25,24,33,34,54,157','0',true);
//print_r($fcw_data_arr);

$fcw_tab_string = '';
$fcw_tabCons_string = '';
$j = $jj = $fined = 0; 

//$defalut_destination = tep_get_categories_name($Tccurrent_category_id);
//print_r($Tccurrent_category_id);
//print_r($fcw_data_arr);
foreach($fcw_data_arr as $key => $val) {
	//print_r($val['subdata']);
	//echo '<br/>===========================================================<br/>';
	if(tep_not_null($Tccurrent_category_id) && array_key_exists($Tccurrent_category_id,(array)$val['subdata'])){
		$fcw_tab_string .= '<li class="current"><a href="' . $val['link'] . '">' . $val['title'] . '</a></li>';
		$fined = $j = $jj = 1;
	} else if($Tccurrent_category_id == $val['id']) {
		$fcw_tab_string .= '<li class="current"><a href="' . $val['link'] . '">' . $val['title'] . '</a></li>';
		$fined = $j = $jj = 1;
	} else {
		$fcw_tab_string .= '<li' . ($j == 0 && !tep_not_null($Tccurrent_category_id) ? ' class="current"' : '') . '><a href="' . $val['link'] . '">' . $val['title'] . '</a></li>';
	}
	
	if($fined == 1){
		$fcw_tabCons_string .= '<div>';
		$fined = 0;
	} else {
		$fcw_tabCons_string .= '<div ' . ($jj == 0 && !tep_not_null($Tccurrent_category_id)  ? '' : 'class="displayNone"') . '>';
	}
	
	foreach($val['subdata'] as $key2 => $val2) {
		$fcw_tabCons_string .= '<a href="' . $val2['link'] . '"' . ($Tccurrent_category_id == $key2 ? ' class="cur"' : '') . '>' . $val2['name'] . '</a>';
	}
	$fcw_tabCons_string .= '</div>';
	$j = $jj = 1;

}
?>
<div class="clear"></div>
<div class="mudidi">
	<div class="menu"><span class="mud_1"><?php echo db_to_html("Ŀ �� ��")?></span><ul class="tabTits"><?php echo db_to_html($fcw_tab_string) ?></ul></div>
	<div class="tabCon">
		<div class="tabCons">
			<?php echo db_to_html($fcw_tabCons_string);?>
		</div>
    	<div class="del_float"></div>
    </div>
</div>
<?php 

//������ start?>
 <form class="form_search">
 <div class="jb_right_tab">
    <ul>
    	<?php
	if($m_products_id!=2){	//����δȷ����·����ѡ��ʱ������ʾ��������
		if(!tep_not_null($departure_city)){
			$departure_all_class = 'a_selecd jb_right_cf_a';
		}else{
			$departure_all_class = 'a_fav jb_right_cf_a';
		}
	?>
	  <li><b><?php echo db_to_html("��������:")?></b>
	  <dl class="jb_cfaddress">
	  	<dd><a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','products_id','customers_id','departure_city','utm_source','utm_medium','utm_term','utm_campaign')))?>" class="<?=$departure_all_class?>"><?php echo db_to_html("����")?></a></dd>
	  <?php
		//�г���Ӧ�ĳ������� start
		//echo '$_GET[\'TcPath\']=' . $_GET['TcPath'] . '<br/>';
		$cat_and_subcate_ids = tep_get_category_subcategories_ids($Tccurrent_category_id);
		$get_depature_city_ids_sql = "select p.departure_city_id  from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c  where p.products_status = '1' and p.products_id = p2c.products_id  and p2c.categories_id in (" . $cat_and_subcate_ids . ") Group By p.departure_city_id ";
		$get_depature_city_ids_sql = tep_db_query($get_depature_city_ids_sql);
		$drop_dwn_depature_city_ids = array();
		while($get_depature_city_ids_row = tep_db_fetch_array($get_depature_city_ids_sql)){		 
			$drop_dwn_depature_city_ids[] = $get_depature_city_ids_row['departure_city_id'];
		}
		// �Ƴ��������ظ���ֵ
		$drop_dwn_depature_city_ids = array_unique($drop_dwn_depature_city_ids);
		$drop_dwn_depature_city_ids = implode(',',$drop_dwn_depature_city_ids);       
		$drop_dwn_depature_city_ids = explode(',',$drop_dwn_depature_city_ids);
		// �������ֵΪ      ��    null  false ��Ԫ��        
        $drop_dwn_depature_city_ids = array_filter($drop_dwn_depature_city_ids);        
		$drop_dwn_depature_city_ids = array_unique($drop_dwn_depature_city_ids);
		$drop_dwn_depature_city_ids = implode(',',$drop_dwn_depature_city_ids);
        
		
		if(!tep_not_null($drop_dwn_depature_city_ids)) { $drop_dwn_depature_city_ids = '0';}
		//ɸѡ�����ӵĲ�Ʒ����
		
		$departure_city_class_sql_pr = "select  ct.city_id as city_id , ct.city, ct.travel_comp_sort from ".TABLE_TOUR_CITY." ct  where  ct.city_id in (" . $drop_dwn_depature_city_ids . ") AND `is_attractions` !='1' group by  ct.city_id order by ct.travel_comp_sort, ct.city Limit 17";
		//echo $departure_city_class_sql_pr;
		//$rtn = array();
		$departure_city_class_query = tep_db_query($departure_city_class_sql_pr);
		while($departure_city_class = tep_db_fetch_array($departure_city_class_query)){
			//$rtn[] = $departure_city_class;
			$c_class = 'a_fav';
			
			
			//���û������ľ�Ҫ�жϸó����صĲ�Ʒ�Ƿ������ӣ���û�����Ӿ���Ҫʹ���в��ɵ㲢���
			$h_links = tep_href_link('new_travel_companion_index.php','departure_city='.$departure_city_class['city_id'].'&'.tep_get_all_get_params(array('page','x', 'y','products_id','customers_id','departure_city','utm_source','utm_medium','utm_term','utm_campaign')));
			
			if($departure_city_class['travel_comp_sort']==9999 || !(int)$departure_city_class['travel_comp_sort'] || tep_not_null($TcPath)){	
				$products_id_list = array();
				
				$prod_sql = tep_db_query("select p.products_id  from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c  where p.products_status = '1' and p.products_id = p2c.products_id  and p2c.categories_id in (" . $cat_and_subcate_ids . ") and FIND_IN_SET('".$departure_city_class['city_id']."', p.departure_city_id ) Group By p.products_id ");
				while($prod_rows = tep_db_fetch_array($prod_sql)){
					$products_id_list[] = $prod_rows['products_id'];
				}
				$products_id_list = array_unique($products_id_list);
				$products_id_list = implode(',',$products_id_list);
				
				//echo 'SELECT t_companion_id FROM travel_companion t WHERE t.status="1" and t.products_id in('.$products_id_list.') and categories_id in (' . $cat_and_subcate_ids . ') Limit 1';
				$cat_and_subcate_ids_arr = explode(',',$cat_and_subcate_ids);
				$c_class = 'a_none_selecd';
				$sql = 'SELECT t_companion_id FROM travel_companion t WHERE t.status="1" and t.products_id in('.$products_id_list.') and find_in_set(' . $departure_city_class['city_id'] . ',t.categories_id)  Limit 1';
				
				$ckeck_tc_sql = tep_db_query($sql);
				$check_tc_row = tep_db_fetch_array($ckeck_tc_sql);
				if((int)$check_tc_row['t_companion_id'] > 0){
					$c_class = 'a_fav';
					//break;
					//$h_links = 'javascript:void(0)';
				}
				
			}
			
			if($c_class != 'a_none_selecd'){
                if($departure_city==$departure_city_class['city_id']){ $c_class = 'a_selecd'; }
				echo '<dd><a href="'.$h_links.'" class="'.$c_class.'">'.db_to_html($departure_city_class['city']).'</a></dd>';
			}
		}
		//print_r($rtn);
		//�г���Ӧ�ĳ������� end
	  ?>
	  </dl>
	  </li>
    <?php
	}
	?>
    <li><b><?php echo db_to_html("�������Ա�:")?></b>
          <dl class="jb_cfaddress">
              <?php
              /*
              $seeking_women_value = '1';
              $seeking_women_class = "fav";
              if($_GET['seeking_women']=='1'){
                        $seeking_women_class = "del";
                        $seeking_women_value = '0';
              }
              $seeking_man_value = '1';
              $seeking_man_class = "fav";
              if($_GET['seeking_man']=='1'){
                        $seeking_man_class = "del";
                        $seeking_man_value = '0';
              }
              $search_all_sex = 'a_selecd jb_right_cf_a';
              if($_GET['seeking_man']=='1'||$_GET['seeking_women']=='1'){
                  $search_all_sex = 'a_fav jb_right_cf_a';
              }*/
              $seeking_women_class = "a_fav";
              $seeking_man_class = "a_fav";
              $search_all_sex = 'a_selecd jb_right_cf_a';
              if($_GET['seeking_man']=='1'){
                   // $undone_value = '0';
                    $seeking_women_class = "a_fav";
                    $seeking_man_class = "a_selecd";
                    $search_all_sex = 'a_fav jb_right_cf_a';
            }
            if($_GET['seeking_women']=='1'){
                  // $done_value = '0';
                   $seeking_women_class = "a_selecd";
                   $seeking_man_class = "a_fav";
                   $search_all_sex = 'a_fav jb_right_cf_a';
            }
             if($_GET['seaking_all_sex']=='1'){
                   //$done_value = '0';
                   $seeking_women_class = "a_fav";
                   $seeking_man_class = "a_fav";
                   $search_all_sex = 'a_selecd jb_right_cf_a';
            }
              ?>
              <dd><a href="<?= tep_href_link('new_travel_companion_index.php','seaking_all_sex=1&'.tep_get_all_get_params(array('page','x', 'y','seeking_women','seeking_man','seaking_all_sex','utm_source','utm_medium','utm_term','utm_campaign')));?>" class="<?= $search_all_sex?>"><?php echo db_to_html('����')?></a></dd>
              <dd><a href="<?= tep_href_link('new_travel_companion_index.php', 'seeking_women=1&'.tep_get_all_get_params(array('page','x', 'y','seeking_women','seeking_man','seaking_all_sex','utm_source','utm_medium','utm_term','utm_campaign')))?>" class="<?= $seeking_women_class?>"><?php echo db_to_html('Ůʿ')?></a></dd>
	      <dd><a href="<?= tep_href_link('new_travel_companion_index.php', 'seeking_man=1&'.tep_get_all_get_params(array('page','x', 'y','seeking_women','seeking_man','seaking_all_sex','utm_source','utm_medium','utm_term','utm_campaign')))?>" class="<?= $seeking_man_class?>"><?php echo db_to_html('����')?></a></dd>

          </dl>
      </li>
	  <li><b><?php echo db_to_html("��������:")?></b>
	<?php
	switch((int)$m_products_id){
		case '0': $prod_all_class = 'a_selecd jb_right_cf_a'; $prod_all_class1 = 'a_fav'; $prod_all_class2 = 'a_fav';
		break;
		case '1': $prod_all_class = 'a_fav jb_right_cf_a'; $prod_all_class1 = 'a_selecd'; $prod_all_class2 = 'a_fav';
		break;
		case '2': $prod_all_class = 'a_fav jb_right_cf_a'; $prod_all_class1 = 'a_fav'; $prod_all_class2 = 'a_selecd';
		break;
	}
	?>
	  <dl class="jb_cfaddress">
	  <dd><a href="<?= tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','products_id','customers_id','m_products_id','utm_source','utm_medium','utm_term','utm_campaign')));?>" class="<?= $prod_all_class?>"><?php echo db_to_html('����')?></a></dd>
	  <dd><a href="<?= tep_href_link('new_travel_companion_index.php','m_products_id=1&'.tep_get_all_get_params(array('page','x', 'y','products_id','customers_id','m_products_id','utm_source','utm_medium','utm_term','utm_campaign')));?>" class="<?= $prod_all_class1;?>"><?php echo db_to_html("��ȷ��ʱ����·��")?></a></dd>
	  <dd><a href="<?= tep_href_link('new_travel_companion_index.php','m_products_id=2&'.tep_get_all_get_params(array('page','x', 'y','products_id','customers_id','m_products_id','departure_city','utm_source','utm_medium','utm_term','utm_campaign')));?>" class="<?=$prod_all_class2?>"><?php echo db_to_html("δȷ��ʱ��·����")?></a></dd>
	  </dl>
	  </li>
	

      <li><b><?php echo db_to_html("����״̬:")?></b>
          <dl class="jb_cfaddress">
         <?php
         /*
            $undone_value = '1';
            $undone_class = "a_fav";
            if($_GET['undone']=='1'){
                    $undone_value = '0';
                    $undone_class = "a_selecd";
                    //$done_class = "a_fav";
            }
            $done_value = '1';
            $done_class = "a_fav";
            if($_GET['done']=='1'){
                  // $undone_class = "a_fav";
                   $done_value = '0';
                   $done_class = "a_selecd";
            }*/
            //$undone_value = '1';
            $undone_class = "a_fav";
           // $done_value = '1';
            $done_class = "a_fav";
            $undone_done_class = 'a_selecd jb_right_cf_a';
            /*
            if($_GET['done']=='1'||$_GET['undone']=='1'){
                  $undone_done_class = 'a_fav jb_right_cf_a';
	  
            }else if($_GET['done']=='1'){
                   $done_value = '0';
                   $done_class = "a_selecd";
                   $undone_class = "a_fav";
            }else if($_GET['undone']=='1'){
                    $undone_value = '0';
                    $undone_class = "a_selecd";
                     $done_class = "a_fav";

            }*/
            if($_GET['undone']=='1'){
                   // $undone_value = '0';
                    $undone_class = "a_selecd";
                    $done_class = "a_fav";
                    $undone_done_class = 'a_fav jb_right_cf_a';

            }
            if($_GET['done']=='1'){
                  // $done_value = '0';
                   $done_class = "a_selecd";
                   $undone_class = "a_fav";
                   $undone_done_class = 'a_fav jb_right_cf_a';
            }
             if($_GET['undone_done']=='1'){
                   //$done_value = '0';
                   $done_class = "a_fav";
                   $undone_class = "a_fav";
                   $undone_done_class = 'a_selecd jb_right_cf_a';
            }


              ?>
              <dd><a href="<?= tep_href_link('new_travel_companion_index.php','undone_done=1&'.tep_get_all_get_params(array('page','x', 'y','undone','done','undone_done','utm_source','utm_medium','utm_term','utm_campaign')));?>" class="<?= $undone_done_class?>"><?php echo db_to_html('����')?></a></dd>
              <dd><a href="<?= tep_href_link('new_travel_companion_index.php', 'undone=1&'.tep_get_all_get_params(array('page','x', 'y','undone','done','undone_done','utm_source','utm_medium','utm_term','utm_campaign')))?>" class="<?= $undone_class?>"><?php echo db_to_html('δ��ɽ����')?></a></dd>
              <dd><a href="<?= tep_href_link('new_travel_companion_index.php', 'done=1&'.tep_get_all_get_params(array('page','x', 'y','undone','done','undone_done','utm_source','utm_medium','utm_term','utm_campaign')))?>" class="<?= $done_class?>"><?php echo db_to_html('����ɽ����')?></a></dd>
			  <dd class="fr_btn">
              <a href="javascript:void(0)" onclick="showPopup('CreateNewCompanion','CreateNewCompanionCon',1);"><?php echo db_to_html('��δȷ����·��');?>
              	<span class="box">
 					<span class="lin1"><i></i></span>
                    <span class="poptext"><?php echo db_to_html('�����ȷ����������·����Ϣ�����鵽������·��ϸҳ�淢�������������������״�ɽ��ͬ�Ρ�');?></span>
 				</span>
               </a>
               </dd>
          </dl>

      </li>
      
    </ul>
 </div>
 </form>
 <?php
 // ���������ĳһ����ֵ ����˵ ��Ϊ�� ����ʾ�˿� by lwkai add {
 if ($Tccurrent_category_id > 0 || tep_not_null($departure_city) || (int)$m_products_id || (tep_not_null($tc_keyword) && $tc_keyword!=$search_str_check) || 
 	(int)$products_id || (int)$customers_id || (int)$undone || (int)$done || (int)$seeking_women || (int)$seeking_man) {
 ?>
 <div class="xxjg">
 <span class="xx_caption"><?php echo db_to_html('��ѡ����');?></span>
 <div class="tiaojian">
 	<?php
		if($Tccurrent_category_id>0){
	?>
	  <a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','TcPath','utm_source','utm_medium','utm_term','utm_campaign','utm_source','utm_medium','utm_term','utm_campaign')))?>" title="<?= db_to_html('ɾ��������')?>"><b><?php echo db_to_html('���㣺'.tep_get_categories_name($Tccurrent_category_id))?></b><i class="icon_2"></i></a>
	<?php
		}
	  ?>
	  <?php if(tep_not_null($departure_city)){?>
	  <a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','departure_city','utm_source','utm_medium','utm_term','utm_campaign','utm_source','utm_medium','utm_term','utm_campaign')))?>" title="<?= db_to_html('ɾ��������')?>"><b><?php echo db_to_html('�����أ�'.tep_db_output(tep_get_city_name($departure_city)))?></b><i class="icon_2"></i></a>
	  <?php
	  }
	  ?>
	  <?php
	  if((int)$m_products_id){
	  	if((int)$m_products_id==1){
			$m_products_str = '���������';
		}
	  	if((int)$m_products_id==2){
			$m_products_str = 'δȷ����·��';
		}
	  ?>
	  <a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','m_products_id','utm_source','utm_medium','utm_term','utm_campaign','utm_source','utm_medium','utm_term','utm_campaign')))?>" title="<?= db_to_html('ɾ��������')?>"><b><?php echo db_to_html(tep_db_output($m_products_str))?></b><i class="icon_2"></i></a>
	  <?php
	  }
	  ?>
	  <?php
          $search_str_check = db_to_html('������ؼ��֣���һ������');
          if(tep_not_null($tc_keyword) && ($tc_keyword != $search_str_check)){?>
	  <a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','tc_keyword','utm_source','utm_medium','utm_term','utm_campaign','utm_source','utm_medium','utm_term','utm_campaign')))?>" title="<?= db_to_html('ɾ��������')?>"><b><?php echo tep_db_output($tc_keyword);?></b><i class="icon_2"></i></a>
	  <?php
	  }
	  ?>
	  <?php if((int)$products_id){?>
	  <a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','products_id','utm_source','utm_medium','utm_term','utm_campaign','utm_source','utm_medium','utm_term','utm_campaign')))?>" title="<?= db_to_html(tep_db_output(tep_get_products_name($products_id)))?>"><b><?php echo cutword(db_to_html('������'.tep_db_output(tep_get_products_name($products_id))),40,'')?></b><i class="icon_2"></i></a>
	  <?php
	  }
	  ?>
	  <?php if((int)$customers_id){?>
	  <a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','customers_id','utm_source','utm_medium','utm_term','utm_campaign','utm_source','utm_medium','utm_term','utm_campaign')))?>" title="<?= db_to_html('ɾ��������')?>"><b><?php echo db_to_html('�����ߣ�'.tep_db_output(tep_customers_name($customers_id)))?></b><i class="icon_2"></i></a>
	  <?php
	  }
	  ?>
	<?php
           $undone_str = 'δ��ɽ����';
           $done_str = '����ɽ����';
           $seeking_women_str = 'ѰŮ��ͬ����';
           $seeking_man_str = 'Ѱ�а�ͬ����';
          ?>
          <?php if((int)$undone){?>
	  <a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','undone','utm_source','utm_medium','utm_term','utm_campaign','utm_source','utm_medium','utm_term','utm_campaign')))?>" title="<?= db_to_html('ɾ��������')?>"><b><?php echo db_to_html(tep_db_output($undone_str))?></b><i class="icon_2"></i></a>
	  <?php
	}
          ?>
          <?php if((int)$done){?>
	  <a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','done','utm_source','utm_medium','utm_term','utm_campaign','utm_source','utm_medium','utm_term','utm_campaign')))?>" title="<?= db_to_html('ɾ��������')?>"><b><?php echo db_to_html(tep_db_output($done_str))?></b><i class="icon_2"></i></a>
	  <?php
	}
          ?>
          <?php if((int)$seeking_women){?>
	  <a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','seeking_women','utm_source','utm_medium','utm_term','utm_campaign','utm_source','utm_medium','utm_term','utm_campaign')))?>" title="<?= db_to_html('ɾ��������')?>"><b><?php echo db_to_html(tep_db_output($seeking_women_str))?></b><i class="icon_2"></i></a>
	  <?php
	}
	?>
          <?php if((int)$seeking_man){?>
	  <a href="<?php echo tep_href_link('new_travel_companion_index.php',tep_get_all_get_params(array('page','x', 'y','seeking_man','utm_source','utm_medium','utm_term','utm_campaign','utm_source','utm_medium','utm_term','utm_campaign')))?>" title="<?= db_to_html('ɾ��������')?>"><b><?php echo db_to_html(tep_db_output($seeking_man_str))?></b><i class="icon_2"></i></a>
	  <?php
	  }
          ?>
          
          </div>
 <div class="del_float"></div>
 </div>
<?php 
	}
	// end if by lwkai end }
	
	
//������ end?>


 <?php /*?><div class="jb_right_button"><div class="note-jb-fb" id="travel_companion_tips_2074" style="text-decoration:none; display:none;"><div class="note-jb-fb_1"><?php echo db_to_html('�����ȷ����������·����Ϣ�����鵽������·��ϸҳ�淢"���������"������״�ɽ��ͬ�Ρ�');?></div><div class="note-jb-fb_2"></div>
 </div><button class="jb_fb jb_right_button_but" type="submit" onmouseout="show_travel_companion_tips(0,2074)" onmousemove="show_travel_companion_tips(1,2074)" target="_blank" style="z-index:5" onclick="showPopup(&quot;CreateNewCompanion&quot;,&quot;CreateNewCompanionCon&quot;,1);"><div class="botton_nei"><span><?php echo db_to_html('��δȷ����·��');?></span></div></button>
 <!--���������-->
 </div><?php */?>
 <div class="jb_r_b">
    <div class="jb_r_b_top">
      <span><?php echo db_to_html('����'.$rows_count.'������������');?></span>
      <?php
		//Ҫȥ����GET����
		$close_parameters = array('page','sort_by_s','sort_by_d','sort_name', 'x', 'y','cPath','utm_source','utm_medium','utm_term','utm_campaign');
		
		?>
        <?php
        $sort_by_s = 'DESC';
        $sort_by_d = 'DESC';
        if($_GET['sort_by_s']=='DESC'){
             $sort_by_s = 'ASC';
        }
        if($_GET['sort_by_d']=='DESC'){
             $sort_by_d = 'ASC';
        }


        ?>
	   <div class="jb_r_b_cent_s"><?php echo db_to_html('����');?><a href="<?php echo tep_href_link('new_travel_companion_index.php','sort_by_d='.$sort_by_d.'&sort_name=departure&'.tep_get_all_get_params($close_parameters))?>" class="atime" ><?php echo db_to_html('����ʱ��');?><i class="<?= $iclass_departure?>"></i></a><a href="<?php echo tep_href_link('new_travel_companion_index.php','sort_by_s='.$sort_by_s.'&sort_name=sendtime&'.tep_get_all_get_params($close_parameters))?>" class="atime"><?php echo db_to_html('����ʱ��');?><i class="<?= $iclass_sendtime?>"></i></a></div>
	</div>
    <div class="jb_r_b_cent">
       <div class="jb_r_b_cent_f">
           <form action="<?=tep_href_link('new_travel_companion_index.php');?>" method="get" name="form_search" id="form_search" target="_self">
               <table border="0" cellspacing="0" cellpadding="0">
	            <tr>
                        <td nowrap="nowrap">
                            <b><?php echo db_to_html("����ʱ��:")?></b>
                            <input name="date_step" type="hidden" id="date_step" value="5">
                            <?php echo tep_draw_hidden_field('TcPath') ?>
                            <?php echo tep_draw_hidden_field('departure_city') ?>
                            <?php echo tep_draw_hidden_field('m_products_id') ?>
                            <?php echo tep_draw_hidden_field('products_id') ?>
                            <?php echo tep_draw_hidden_field('customers_id') ?>
                        </td>
		        <td nowrap="nowrap" style="padding-left:10px; padding-right:10px;">
						<?php echo tep_draw_input_num_en_field('search_date_1', $search_date_1, 'style="width:65px;" class="text_time" onclick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" ')?>
                        </td>
                        <td><?php echo db_to_html('��');?></td>
                        <td nowrap="nowrap" style="padding-left:10px; padding-right:10px;">
                        <?php echo tep_draw_input_num_en_field('search_date_2', $search_date_2, 'style="width:65px;" class="text_time" onclick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" ')?>
	               </td>
                       <td><?php echo tep_draw_input_field('tc_keyword','','id="tc_keyword" class="text4" style="color:#BBBBBB" value="'.db_to_html('������ؼ��֣���һ������').'"title="'.db_to_html('������ؼ��֣���һ������').'" onFocus="Check_Onfocus(this)" onBlur="Check_Onblur(this)" ');?></td><td><button class="jb_fb_sh m_l1" onclick="travel_companion_search()"><div class="botton_nei_sh"><span><?php echo db_to_html('����')?></span></div></button></td></tr>
           </table>
           </form>
	   </div>
    </div>
<div class="jb_item line2" style="padding:5px 15px;border:0;font-weight:bold;">
	<table cellpadding="0" cellspacing="0" border="0">
    	<tr>
        	<td width="55%" align="center"><?php echo db_to_html('����');?></td>
            <td width="25%" align="center"><?php echo db_to_html('����ʱ��');?></td>
            <td width="20%"><?php echo db_to_html('������');?></td>
         </tr>   
    </table>
</div>
<?php
// loop $dates list start
//�Ƿ���ʾĿ¼�жϣ������ǰĿ¼û����Ŀ¼��ʱ������ʾĿ¼����
$check_query = tep_db_query("select categories_id from " . TABLE_CATEGORIES . " where parent_id='" .(int)$Tccurrent_category_id ."' limit 1 ");
$check_row = tep_db_fetch_array($check_query);

for($i=0; $i<count($dates); $i++){
?>
	<div class="jb_item line2">
		<table cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td width="55%" style="color:#b3b3b3;">
			
			<?php
			//���ǹ���������Ƿ��Ǿɰ����ݵı�־
			if($dates[$i]['type']!="1" && $dates[$i]['hope_man']=="0" && $dates[$i]['hope_woman']=="0"){
				echo '<img style="vertical-align:middle;" src="image/icons/icon0616_ago.jpg" title="'.db_to_html("������Ϊ�ɰ����淢������").'" /> ';
			}else{
				echo '<img style="vertical-align:middle;" src="image/icons/icon0616_new.jpg" /> ';
			}
			//����	$dates[$i]['type'] 1Ϊ���棬2Ϊ�ö���3Ϊ������100Ϊ��ͨ��
			$d_type = tep_bbs_type_name($dates[$i]['type']);
			if(tep_not_null($d_type)){
				echo '<span class="jifen_num cu">['.db_to_html($d_type).']</span>'; 
			}
			//����
			$TcPathForTitle = tep_get_category_patch((int)$dates[$i]['categories_id']);
			$TcPaStr = '';
			if(tep_not_null($TcPathForTitle)){
				$TcPaStr = '&TcPath='.$TcPathForTitle;
			}
			$t_title = db_to_html(tep_db_output($dates[$i]['title']));
			if($dates[$i]['type']=="1"){ $t_title = db_to_html($dates[$i]['title']); }
			echo '<a class="dazi col_2 jieban_text" href="'.tep_href_link('new_bbs_travel_companion_content.php','t_companion_id='.(int)$dates[$i]['id'].$TcPaStr).'" title="'.$t_title.'" >'.cutword($t_title,52,'').'</a>';
			

			$echo_other = "";
			//ȡ��bbs ����ҳ����Ϣ start
			$show_bbs_page = false; //�رո���ҳ��
			if($show_bbs_page == true){
				$reply_sql = tep_db_query('SELECT count(*) as total FROM `travel_companion_reply` WHERE t_companion_id="'.$dates[$i]['id'].'" AND `status`="1" ');
				$reply_row = tep_db_fetch_array($reply_sql);
				$reply_total = (int)$reply_row['total'];
				//$row_max = 3;	//ÿҳ��ʾ����
				$row_max = TRAVEL_LIST_MAX_ROW;
				$reply_total_page = ceil($reply_total/$row_max);
				if($reply_total_page>1){
					$reply_page = '<span id="reply_page_'.$dates[$i]['id'].'"> [ ';
					for($p=1; $p<($reply_total_page+1); $p++){
						if($p<=5 || $p==$reply_total_page){
							$TcPaStr = '';
							if(tep_not_null($TcPath)){
								$TcPaStr = '&TcPath='.$TcPath;
							}
							$reply_page .= ' <a href="'.tep_href_link('new_bbs_travel_companion_content.php','t_companion_id='.(int)$dates[$i]['id'].$TcPaStr.'&page='.$p).'" >'.$p.'</a> ';
						}else{
							$reply_page .= '...';
						}
					}
					$reply_page = preg_replace('/(\.{3})+/', '...', $reply_page);
					$reply_page .= ' ]</span>';
					$echo_other .= $reply_page;
			}
			}
			//ȡ��bbs ����ҳ����Ϣ end
			if($dates[$i]['_type']==1){
			if(!(int)$products_id){	//��ʾ��ǰ�����ڵĲ�Ʒ
				
				$p_name = tep_get_products_name((int)$dates[$i]['products_id']);
				if(tep_not_null($p_name)){
					$PrcPath = tep_get_category_patch((int)$dates[$i]['categories_id']);
					//$echo_other .= '<div>'.'<p title="'.db_to_html($p_name).'" ><label><a href="'.tep_href_link('new_travel_companion_index.php', 'TcPath='.$PrcPath.'&products_id=' . (int)$dates[$i]['products_id']).'" title="'.db_to_html($p_name).'" >'.cutword(db_to_html($p_name),58,'').'<span> '.db_to_html('ͬ����').'</span></a></label></p></div>';
					$echo_other .= '<span title="' . tep_db_output(db_to_html($p_name)) . '" style="color:#b3b3b3;" >' . db_to_html('������·��') . cutword(tep_db_output(db_to_html($p_name)),58,'').'</span>';
				}
			}
			//Ŀ¼
			elseif((int)$check_row['categories_id'] &&(int)$dates[$i]['categories_id'] && !(int)$products_id){

				$ChildTcPath = tep_get_category_patch((int)$dates[$i]['categories_id']);
				
				$c_cate_name = tep_get_categories_name($dates[$i]['categories_id']);
				$c_cate_name = preg_replace('/ .+/','',$c_cate_name);
				if(tep_not_null($c_cate_name)){
					$echo_other .= '<label>[<a href="'.tep_href_link('new_travel_companion_index.php','TcPath='.$ChildTcPath).'">'.db_to_html($c_cate_name).'</a>]</label>';
				}
			}}else{
					$echo_other.='<span style="color:#b3b3b3;" title="'.db_to_html($dates[$i]['end_place']).'">'.db_to_html('Ŀ�ĵأ�'.$dates[$i]['end_place']).'</span>';
					}
			//�����Ͼ�����Ϣ�����뵱ǰ��������
			if(!tep_not_null($echo_other)){
				$echo_other .= '<span title="'.db_to_html(tep_db_output($dates[$i]['content'])).'" style="color:#b3b3b3;" >'.cutword(db_to_html(tep_db_output($dates[$i]['content'])),58,'').'</span>';
			}
			?>
			  
			  </td>
              	<td  width="25%" style="text-align:center">
                
                <label><?php echo date('m/d/Y',strtotime($dates[$i]['hope_departure_date'])) . db_to_html('����')?></label><br/><span class="bylwka">by&nbsp;
			<?php 
			if((int)$dates[$i]['customers_id']){
				$cu_name = db_to_html(tep_db_output($dates[$i]['name']));
				if(!tep_not_null($cu_name)){
					$cu_name = db_to_html('����');
				}
				echo '<a class="t_c" href="'.tep_href_link('individual_space.php','customers_id='.(int)$dates[$i]['customers_id']).'" title="'.$cu_name.'">'.cutword($cu_name,8,'').'</a>';
				
				if($dates[$i]['gender']=='1'){echo db_to_html('<label>����</label>');}
				if($dates[$i]['gender']=='2'){echo db_to_html('<label>Ůʿ</label>');}
			}elseif((int)$dates[$i]['admin_id']){
				echo db_to_html('<label>ϵͳ����Ա</label>');
			}
			#echo db_to_html(' <label>����</label>&nbsp;&nbsp;');
			
			
			?></span>
			  </td>
              	<td  width="20%"><label><?php echo db_to_html('�ظ���<span>'.$dates[$i]['reply'].'</span>���鿴��<span>'.$dates[$i]['click'].'</span>��')?></label></td>
            </tr>
            <tr>
            	<td>
					<?php
                    if(tep_not_null($echo_other)){
                        echo $echo_other;
                    }
                    ?>			  
                </td>
                <td style="text-align:right">&nbsp;
					
				</td>
				<td><?php
			//ȡ�����������˵����������ӵ����һҳ

			$last_reply_sql = tep_db_query('SELECT customers_name FROM `travel_companion_reply` WHERE t_companion_id="'.$dates[$i]['id'].'" AND `status`="1" ORDER BY t_c_reply_id DESC Limit 1 ');
			$last_reply_row = tep_db_fetch_array($last_reply_sql);
			if(tep_not_null($last_reply_row['customers_name'])){
				$TcPaStr = '';
				if(tep_not_null($TcPath)){
					$TcPaStr = '&TcPath='.$TcPath;
				}
				$ccut_name = db_to_html(tep_db_output($last_reply_row['customers_name']));
				
				echo '<label>' . db_to_html("�����£�by") . '<a class="t_c" href="'.tep_href_link('new_bbs_travel_companion_content.php','t_companion_id='.(int)$dates[$i]['id'].$TcPaStr.'&page='.$reply_total_page).'" title="'.$ccut_name.'">'.cutword($ccut_name,8,'').'</a></label>';
			}
			?>
			<?php /*?><label><?php echo substr($dates[$i]['time'],5,11)?></label><?php */?></td>
            </tr>
        </table>
    </div>
<?php
}
?>    

    <div class="jb_fenye line2">
      <div class="jb_fenye_l type<?php echo $page_type;?>">
	  <?php
	  if((int)$rows_count_pages>1){
		echo $rows_page_links_code;
	  }
	  ?>
      </div>
      <?php /*?><div class="jb_fenye_r"><button class="jb_fb" type="submit" onclick="showPopup(&quot;CreateNewCompanion&quot;,&quot;CreateNewCompanionCon&quot;,1);"><div class="botton_nei"><span><?php echo db_to_html('��δȷ����·��');?></span></div></button></div><?php */?></div>
    </div>
    
 </div>
<?php

// �ұ߽��� end }
//�°� end
require_once('travel_companion_tpl.php');
?>
<?php
		$temp = '';
			if((int)$products_id){
				$t_companion_content1 = db_to_html(tep_get_products_name((int)$products_id));
				$temp = $t_companion_content__content;
			}
			//$title_and_value = '��������ϣ��ȥ�ľ����·��';
			if(!tep_not_null($t_companion_content__content)){
				//$t_companion_content__content = db_to_html($title_and_value); // ���û�н����· ����Ҫ�ṩ����ɸѡ
				$t_companion_content1 = tep_simple_drop_down('area1', db_to_html(array(
					'0' => '��ѡ������',
					'25' => '����',
					'24' => '����',
					'33' => '������',
					'54' => '���ô�',
					'157' => 'ŷ��',
					'298' => '������ѧ'
				)),db_to_html('��ѡ������'),'id="area" onchange="getCity(this)"');
				$t_companion_content1 .= db_to_html('����:');
				$t_companion_content1 .= tep_simple_drop_down('start_city', array('0' => db_to_html('��ѡ��')),'','id="start_city"');
			//echo $t_companion_content1;
			$temp = '';
			$t_companion_content1=$t_companion_content__content='';
			if((int)$products_id){
				$t_companion_content__content = db_to_html(tep_get_products_name((int)$products_id));
				$temp = $t_companion_content__content;
			}
			//$title_and_value = '��������ϣ��ȥ�ľ����·��';
			if(!tep_not_null($t_companion_content__content)){
				//$t_companion_content__content = db_to_html($title_and_value); // ���û�н����· ����Ҫ�ṩ����ɸѡ
				$t_companion_content1 = tep_simple_drop_down('area', db_to_html(array(
					'0' => '��ѡ������',
					'25' => '����',
					'24' => '����',
					'33' => '������',
					'54' => '���ô�',
					'157' => 'ŷ��',
					'298' => '������ѧ'
				)),db_to_html('��ѡ������'),'id="area" onchange="getCity(this)"');
				$t_companion_content1 .= db_to_html('�����س���:');
				$t_companion_content1 .= tep_simple_drop_down('start_city', array('0' => db_to_html('��ѡ��')),'','id="start_city" onchange="getProducts()"');
				
				$t_companion_content__content .= $t_companion_content1.db_to_html('Ŀ�ĵ�:');
				$t_companion_content__content .= tep_simple_drop_down('end_city', array('0'=>db_to_html('��ѡ��')),'','id="end_city" onchange="getProducts()"');
				$t_companion_content__content .= '<br/>' . tep_simple_drop_down('products_names', array('0'=>db_to_html('��ѡ��������·')),'','id="products_select" style="width:435px;overflow:hidden" onchange="set_products_id(this)"');
				/*$t_companion_content__content = tep_draw_pull_down_menu('area',array(
						array('text'=>'��ѡ������'), 
						array('id' => '25', 'text' => '����'), 
						array('id' => '24', 'text' => '����'),
						array('id' => '33', 'text' => '������'),
						array('id' => '4', 'text' => '���ô�'),
						array('id' => '5', 'text' => 'ŷ��'),

				), '��ѡ������');*/
			}
			$textarea_class = "required textarea_fb_bt";
			$textarea_readonly = "";
			$textarea_display = ' style="border:1px solid #d5d5d5; width:429px; padding:3px; margin:0; height:30px;" ';
			if((int)$products_id){
				$textarea_class = "";
				$textarea_readonly = ' readonly="true" ';
				$textarea_display = ' style="display:none"; ';
				$t_companion_content__content .= $t_companion_content__content;
			}
			$t_companion_content__content .= '<span style="display:none">';
			$t_companion_content__content .= tep_draw_textarea_field('t_companion_content', 'soft', '', '',$temp,' class="'.$textarea_class.'" id="t_companion_content" title="'.db_to_html($title_and_value).'" onFocus="Check_Onfocus(this)" onBlur="Check_Onblur(this)" '.$textarea_readonly.$textarea_display);
			$t_companion_content__content .= '</span>';
			//unset($t_companion_content__content);
			$t_companion_content1.='<div class="dest_box">'.tep_draw_hidden_field("end_place",'','id=destinationVal').'<div class="destination" id="my_destination"><ul></ul><input type="text" name="end_place_tmp" data="" value="" id="dest_text" onkeyup="getMyCity(this)"><div style="clear:both;"></div></div><ul class="dest_list"></ul></div>';
			}
			?>
<script type="text/javascript">
jQuery(document).ready(function(jQuery){
	jQuery('.partner_sty .par_pinfang').click();
	jQuery('#dest_text').val('');
	var _sty = jQuery('jb_fb_tc_tab p.partner_sty label');
	var destVal = [];
	_sty.click(function(){
		if(jQuery(this).attr('class') == 'par_pinfang'){
			
		}else{
			
		}
	});
	var _list = jQuery('.dest_box .dest_list li');
	var _text = jQuery('#dest_text');
	_list.live('hover',function(){ jQuery(this).toggleClass('hover');});
	_list.live('click',function(){
		var _t = jQuery(this).text(), _d = jQuery(this).attr('data');
		var _html = '<li class="dest_val">'+ _t +' <label><?php echo db_to_html(��);?></label></li>'; 
		var _abc = destVal.push(_d); jQuery('#destinationVal').val(destVal);
		jQuery('.destination ul').append(_html);
		jQuery(this).parent('ul').hide();
		jQuery('#dest_text').val('').focus();
	});
	//ɾ��Ŀ�ĵ�
	jQuery('.dest_box .destination ul li.dest_val label').live('click',function(){
		var _num = jQuery(this).parent('li').index();
		jQuery(this).parent('li').fadeOut('fast').remove();
		var _abc = destVal.splice(_num,1);jQuery('#destinationVal').val(destVal);
		jQuery('#dest_text').val('').focus();
	});
});
function getMyCity(doc){
	setTimeout('getMyCity1("'+doc.value+'")',800);
}
function getMyCity1(value){
var _val = value;

var destination=document.getElementById('my_destination');
		var html = '';
		//var data = [{"id":"101","text":"ŦԼ����"},{"id":"102","text":"ŦԼ����"},{"id":"103","text":"ŦԼ����"},{"id":"104","text":"ŦԼ����"},{"id":"105","text":"ŦԼ����"}];
		if(_val.replace(/[ ]/g,'') == ''){
			jQuery('.dest_box .dest_list').hide();
		}else{
			destination.class='ajax_loading';
			jQuery.post('/ajax_travel_city.php',{limit:"10",city:_val},function(data){
				destination.class='destination';
				if(data != ''){
					for(var i=0; i<data.length; i++){
						html+='<li data="'+ data[i].id +'">'+ data[i].text +'</li>';
						jQuery('.dest_box .dest_list').html(html).show();
						destination.style.borderColor="";
					}	
				}else{
					jQuery('.dest_box .dest_list').html('<font color="red">'+_val+'</font>:<?php echo db_to_html('�޴�Ŀ�ĵ�');?>').show();
					destination.style.borderColor="red";
					}
			},'json');
		}
		}
function MychangeWay(doc){
				if(doc.value==1){
					jQuery("#my_span").html("<?php echo db_to_html('������·��');?>");
					jQuery('#my_td').html('<?php echo $t_companion_content__content?>');
					jQuery('#my_plane').hide();
					
					}else{
						jQuery("#my_span").html("<?php echo db_to_html('�����أ�</br>Ŀ�ĵأ�');?>");
						jQuery('#my_td').html('<?php echo $t_companion_content1?>');
						jQuery('#my_plane').show();
						}
			}
			</script>
<?php
/**
 * ȡ���û����ͬ�ε�ͷ����Ϣ
 *
 * @param int $customers_id ��Ҫ��ȡ���û�ID
 * @param int $bbs_id  �����ͬ��ͬ�εķ���������ش�������ID������������Ҫ����
 * @param string $customers_name �û�����[��ѡ]
 * @param string $gender �û��Ա� eg:(���� �� Ůʿ) [��ѡ] 
 * @param bool $only_face �Ƿ�ֻ��ʾͷ�� [��ѡ] 
 */
function get_travel_companion_face( $customers_id,  $customers_name = '', $gender = '',$bbs_id = 0 , $only_face = false){
	global $content,$customer_id;
	// $customer_id ��ǰ��¼���û�ID
	// $customers_id 
	if($customers_name==''){
		$customers_name = tep_customers_name($customers_id,1);
	}
	//ע��ʱ��
	$created_sql = tep_db_query('SELECT customers_info_date_account_created FROM `customers_info` WHERE customers_info_id ="'.(int)$customers_id.'" ');
	$created_row = tep_db_fetch_array($created_sql);
	$account_created = '';
	if(strtr($created_row['customers_info_date_account_created'], array('-'=>'',' '=>'',':'=>'')) > 0){
		$account_created .= chardate($created_row['customers_info_date_account_created'], "D", "1");
		//$account_created .= 'ע��';
	}
	//����״̬
	$customers_online_status = '����';
	$online_sql = tep_db_query("SELECT customer_id from " . TABLE_WHOS_ONLINE . " where customer_id = '".$customers_id."' ");
	$online_row = tep_db_fetch_array($online_sql);
	if((int)$online_row['customer_id']){
		$customers_online_status = '����';
	}
	
	//ͷ��
	if(!tep_not_null($gender)){
		$gender = tep_customer_gender($customers_id);
	}
	$head_img = "touxiang_no-sex.gif";
	if(strtolower($gender)=='m' || $gender=='1'){ $head_img = "touxiang_boy.gif"; }
	if(strtolower($gender)=='f' || $gender=='2'){ $head_img = "touxiang_girl.gif"; }
	$head_img = 'image/'.$head_img;
	$head_img = tep_customers_face($customers_id, $head_img);
	
	//�������ĵ�����
	if($content != 'individual_space'){
		$individual_space_links = tep_href_link('individual_space.php','customers_id='.$customers_id);
		$onclick = "";
	}else{
		$individual_space_links = 'JavaScript:void(0)';
		$onclick = "showDiv('travel_companion_tips_2064');";
	}
	// ��Sofia����˼ ��ȥ�� ����
	$has_point = tep_get_shopping_points($customers_id);
?>
      <div class="jb_ljjb_tx ">	  
	  <?php if($only_face == false){?>
	  <div class="user_name"><?php 
	  echo db_to_html(tep_db_output($customers_name));
	  ?>&nbsp;<span class="col_3"><?php echo db_to_html($customers_online_status); ?></span></div>
	  <?php }?>
	  
	 <?php /* ������� <a href="<?= $individual_space_links?>" class="t_c" onclick="<?= $onclick?>">*/ ?><img id="img_customers_face" src="<?= $head_img?>" <?php echo getimgHW3hw($head_img,131,121)?>  /><?php #</a>?>
	  
        <?php 
		// ������ �û��� ��� start{
		/*<p>
		<a href="<?= $individual_space_links?>" class="t_c" onclick="<?= $onclick?>" id="CustomersNameGender">
		<?php
		echo db_to_html(tep_db_output($customers_name));
		echo db_to_html(tep_get_gender_string($gender,1));
		?>
		</a>
		 <span class="col_3"><?php echo db_to_html($customers_online_status);?></span></p>*/
		 // ���� �û������ end }
		 ?>
        <?php if($only_face == false){?>
		<ul>
		
        <?php // �������������� ��Sofia����˼  start { ?>
			
        <li><?php echo db_to_html('���֣�') . number_format($has_point,POINTS_DECIMAL_PLACES);?></li>
		<?php
		// �������ؽ��� end  }
		if(tep_not_null($account_created)){
		?>
        <li><?php echo db_to_html('ע�᣺' . $account_created);?></li>
        <?php
		}?>

		<?php 
		 //�Լ�����Լ������Ľ����ʱ��ȥ������������Ϣ��
		 if($customers_id!=$customer_id && $bbs_id != 0 && (int)$customers_id && (int)$customer_id){
		 ?>
		 <li><a href="JavaScript:void(0)" class="jb_fb_tc_bt_a" onclick="show_site_inner_sms_layer(<?php echo $customers_id?>,'travel_companion', <?php echo $bbs_id?>)"><?php echo db_to_html('��������Ϣ')?></a></li>
		 <?php
		 }
		 // ����ǵ�¼���ʺž��Ǳ��� ����ʾ��������
		 /*if($customers_id == $customer_id) {
		 ?>
        <li><a href="<?= tep_href_link('individual_space.php','customers_id='.$customers_id)?>" class="t_c"><?= db_to_html('��������')?></a></li>
        <?php } */?>
      </ul>
	  	<?php }?>
	  
	  </div>

<?php
}
?>
<?php
//��ҳ����ʹ��SSL���ӣ������²���ǩ֤��
if($_SERVER['SERVER_PORT']=='443'){
	$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	header('Location: ' . $url);
	exit;
}

require('includes/application_top.php');
require('includes/classes/visa.php');

//ͨ����Ʒ����ȡ��Title��Ϣ
function get_visa_info_title($visa_product,$visa_purpose){
	$data =false;
	$rt = '';
	for($i=0, $n=count($visa_product); $i<$n; $i++)
	{		
		if ($visa_product[$i]['visa_purpose'] == $visa_purpose)
		{
			$data = $visa_product[$i];
			break;
		}		
	}	
	
	if (is_array($data))
	{
		//$rt .= '<p><a href="'.tep_href_link_noseo('visa.php','action=loginto&visa_products_id='.$data['visa_products_id']).'" rel="nofollow" target="_blank">����Ԥ��</a><span class="color1">$'.$data['visa_product_price'].'</span></p><h3>'.$data['visa_purpose'].'</h3>';
		$rt .= '<p><a href="'.tep_href_link('product_info.php','products_id=2750').'" rel="nofollow" target="_blank">����Ԥ��</a><span class="color1">$'.$data['visa_product_price'].'</span></p><h3>'.$data['visa_purpose'].'</h3>';
	}
	return $rt;
}
	

$visa = new visa();

$action_ = $_GET['action'];
switch($action_){
	case 'loginto': //��ǩ֤���� start{
		//$VIS_TAG_NAME = urlencode(iconv('gb2312','utf-8',iconv(CHARSET,'gb2312',urldecode($_GET['VIS_TAG_NAME']))));
		$visa_products_id = (int)$_GET['visa_products_id'];
		
		$visa_product = $visa->get_product_by_visa_products_id($visa_products_id);
		if ( is_array($visa_product) ){	
		
			if (!tep_session_is_registered('customer_id')) {
				$messageStack->add_session('login', NEXT_NEED_SIGN);
				//$navigation->set_snapshot();
				if(tep_not_null($_COOKIE['LoginDate'])){
					$messageStack->add_session('login', LOGIN_OVERTIME);
					setcookie('LoginDate', '');
				}
				tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
			}
			$visa_info = $visa->get_visa_info($customer_id);
			if(is_array($visa_info)){			
				$SRV_UNID = $visa_product['visa_srv_unid'];
				$VIS_TAG_NAME = urlencode( iconv('gb2312','utf-8',$visa_product['visa_vis_tag_name']) );//�����ݿ����ȡ�����ľ���gb2312��
				//$url = VISA_DOMAIN . VISA_USER_ORDER_URL. $visa_info['URL_VISA_ORDER'].'&VIS_TAG_NAME='.$VIS_TAG_NAME.'&SRV_UNID='.$SRV_UNID;//����VISA_USER_ORDER_URL����
				$url = VISA_DOMAIN . $visa_info['URL_VISA_ORDER'].'&VIS_TAG_NAME='.$VIS_TAG_NAME.'&SRV_UNID='.$SRV_UNID;
				//echo 'page redirecting,please wait.........';
				tep_redirect($url);
			} else {
				exit('ǩ֤ϵͳ��æ�����Ժ����ԣ�');
			}
		}else {
			//echo 'redirect to visa home page';
			tep_redirect(tep_href_link('visa.php'));
		}
	//��ǩ֤���� end }
	break;
	case 'viewMyVisaOrder': //�鿴�ҵ�ǩ֤���� start{
		if (!tep_session_is_registered('customer_id')){
			tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
		}
		$visa_info = $visa->get_visa_info($customer_id);
		$url = VISA_DOMAIN . $visa_info['URL_VISA_ORDER_LIST'];
		tep_redirect($url);
	//�鿴�ҵ�ǩ֤���� end}
	break;
	case 'add_order_from_lujia': //visa�Ķ���״̬�ı��lujia��ط����ݣ��������ǹܶԷ��ύ�� start { 
		echo 'prepare.';
		$fromUrl = $_SERVER['HTTP_REFERER'];
		$fromUrl = preg_replace('/^http:\/\//i', '', $fromUrl);
		$arr = split('/',$fromUrl);
		$fromDomain = $arr[0];
		echo 'check source.';
		
		//���������վ,һ��Ҫ�ж���Դ
		if(IS_LIVE_SITES ===true){
			if ($fromDomain != str_replace('http://','',VISA_DOMAIN)){
				echo '';
				exit();
			}
		}
		
		//���￪ʼ��������	
		$order_info = tep_db_prepare_input($_POST['order']);
		$sql = 'INSERT INTO `visa_temp`(`order`)values(\''.$order_info.'\')';
		$sql_query=tep_db_query($sql);
		
		$visa->visa_add_order_info_returned_fromlujia($order_info);	
		echo 'finished.';		
		exit();
	//visa�Ķ���״̬�ı��lujia��ط����ݣ��������ǹܶԷ��ύ�� end }
	break;
	case 'add_visa_from_lujia':	//ǩ֤�����ύ����ʹ�ݺ�,���״̬�ı�,��·���ύ��Ϣ����,����֮ start{
		echo 'visa_prepare.';
		$fromUrl = $_SERVER['HTTP_REFERER'];
		$fromUrl = preg_replace('/^http:\\/\\//i', '', $fromUrl);
		$arr = split('/',$fromUrl);
		$fromDomain = $arr[0];
		echo 'visa_check_source.';
		
		//���������վ,һ��Ҫ�ж���Դ
		if(IS_LIVE_SITES ===true){
			if ($fromDomain != str_replace('http://','',VISA_DOMAIN)){
				echo 'domain check error';
				exit();
			}
		}
		
		//���￪ʼ��������	
		//$order_info = tep_db_prepare_input($_POST['order']);
		//$sql = 'INSERT INTO `visa_temp`(`order`)values(\''.$order_info.'\')';
		//$sql_query=tep_db_query($sql);
	
		$visa_data = $_POST['visa_data'];
		
		$rt = $visa->visa_add_visa_info_returned_fromlujia($visa_data);
		echo 'visa_finished.';		
		exit();
	//ǩ֤�����ύ����ʹ�ݺ�,���״̬�ı�,��·���ύ��Ϣ����,����֮ end}
	break;
	case 'communication': //��·�ν���/���ԵĲ鿴 start{
		//������Ҫ�����ԱȨ���жϵĹ���
		if (!tep_not_null($_SESSION['visa_com_session'])){		
			$cert_rt = false;
			$cert_rt = $visa->get_cert($_GET['cert']);
			if ($cert_rt == false){ 
				echo 'ERROR: user cert fail.'; exit();
			}else{
				$_SESSION['visa_com_session'] = "1";
			}
		}
		
		$visa_lujia_user = $_GET['user_name'];
		$visa_order_id = (int)$_GET['visa_order_id'];	
		if($visa_order_id>0 && tep_not_null($visa_lujia_user)){
			$off_corner_tl_tr = true;
			$BreadOff = true;
			$content = 'visa';
			
			$the_title = db_to_html('��������ǩ֤_����ǩ֤����_������ǩ֤����Ǯ_Usitrip���ķ�������');
			$the_key_words = db_to_html('ȥ��������ǩ֤,��������ǩ֤����Ǯ,��������ǩ֤,����ǩ֤ԤԼ');
			$the_desc = db_to_html('�������ػ���������-���ķ��ṩ����,��ѧ��ѧ,����ǩ֤����;ȫ��Ψһ������ǩ֤���������ύϵͳ��ǩ֤����,רҵ�Ŷ�,100%����!');
			ob_start();
	?>
	<style type="text/css">
	body{font-size:12px;}
	.tbList { border:1px solid #CCCCCC; border-collapse:collapse; font-size:14px; }
	.tbList th{ background-color:#006699; color:#FFFFFF; font-weight:bolder; font-size:90%; border:1px solid #CCCCCC; padding:3px;}
	.tbList td{ border:1px solid #CCCCCC; padding:3px; font-size:90%;}
	.tbList td span.imp2{color:#FF0000; font-weight:bolder;}
	.tbList td span.imp1{color:#FF0000; font-weight:normal;}
	.tbList td span.imp0{color:#000000; font-weight:normal;}
	.tbList tr.bc{ background-color:#EEEEEE}
	</style>
	<script type="text/javascript" src="jquery-1.3.2/merger/merger.min.js"></script>
	<script language="javascript" type="text/javascript">
	function fn_visa_msg_read(id)
	{
		var url = "visa.php?action=communication_read&id="+id;;
	
		jQuery.get(url, {}, function(data){
			if (data.substring(0,5).toUpperCase()=="ERROR"){ alert(data); }	else{ alert("�����ɹ�"); window.location.href = window.location.href; }
		}); 
	}
	</script>
	
		ǩ֤���� (������ <b><?php echo $visa_order_id;?></b> ) �����ķ�����������:
		<div>
		<?php
		$data2 = $visa->get_visa_order_info_by_visa_order_id($visa_order_id);
		$visa_VIS_STATUS = $visa->get_visa_to_embassy_status($visa_order_id);
		?>
		<table class="tbList">
			<tr>
				<th>������</th>
				<th>�ͻ�����</th>
				<th>����Ŀ��</th>
				<th>ǩ֤״̬</th>
				<th>����״̬</th>
				<th>Ԥ�Ƹ�������</th>
				<th>ϣ��ǩ֤����</th>
			</tr>
			<tr>
				<td><?php echo $visa_order_id;?></td>
				<td><?php echo $data2['ORD_USR_NAME'];?></td>
				<td><?php echo $data2['ORD_NAME'];?></td>
				<td><?php echo $visa->match_visa_to_embassy_status_name($rows['VIS_STATUS']);?></td>
				<td><?php if ($data2['ORD_PAY_MONEY']>= $data2['ORD_PRICE']){ echo '�Ѹ���'; }else{ echo 'δ����';} ?></td>
				<td><?php echo $data2['ORD_EXT2'];?></td>
				<td><?php echo $data2['ORD_EXT3'];?></td>
			</tr>
		</table>
		</div>
	
		<div style="width:1100px;">
		<div style="float:left; width:500px; height:20px; background-color:#FFFFFF; overflow:hidden; border:1px solid #CCCCCC; padding:5px; margin:2px; text-align:center; font-weight:bolder; font-size:16px;">���ķ�</div>
		<div style="float:left; width:500px; height:20px; background-color:#CCFFFF; overflow:hidden; border:1px solid #CCCCCC; padding:5px; margin:2px; text-align:center; font-weight:bolder; font-size:16px;">·��</div>
		<?php
		
		//$visa_order_com = $visa->visa_order_com_get_lists($visa_order_id);
		//tep_get_admin_customer_name
		$sql = 'SELECT * FROM visa_order_communication WHERE visa_order_id='.$visa_order_id.' ORDER BY CASE visa_order_com_root_id WHEN 0 THEN visa_order_com_id ELSE visa_order_com_root_id END DESC, visa_order_com_parent_id ASC, add_date ASC';
		$sql_query = tep_db_query($sql);
		
		$admin_id_temp = -1;
		$last_from = '';
		$last_from_temp = '';
		
		while($rows = tep_db_fetch_array($sql_query))
		{
			if ($rows['admin_id']>0) { 
				$last_from_temp = 'usi'; 
			} 
			else {
				$last_from_temp = 'lujia'; 
			}
		?>
		<?php
			if ((int)$rows['visa_order_com_root_id']==0) {
				$last_from = '';
		?>
		<div style="line-height:5px; height:15px; float:left; width:95%; background-color: #CCCCCC;">
			<a href="javascript:void(0)" style="float:right;">����</a>
		</div>
		<?php }?>
		<div>
			<?php if( ($rows['admin_id']==0 && (int)$rows['visa_order_com_root_id']==0) || ($last_from_temp == $last_from ) ){?>
			<div style="float:left; width:500px; height:90px; overflow:hidden; border:1px solid #FFFFFF; padding:5px; margin:2px;"></div>
			<?php }?>
			
			<div style="float:left; width:500px; height:90px; overflow:hidden; border:1px solid #CCCCCC; padding:5px; margin:2px; 
			<?php if($rows['admin_id']==0){ ?> background-color:#CCFFFF;<?php }?>
			<?php if ((int)$_GET['visa_order_com_parent_id']==(int)$rows['visa_order_com_id']){ ?> background-color:#FFCC33;<?php }?>
			">
				<div>
					<span style="color:#999999;"><?php if($rows['admin_id']>0){ echo tep_get_admin_customer_name($rows['admin_id']);}else{ echo '<b>'.tep_db_output($rows['sender_name']).'</b>';}?></span>
					<?php echo tep_db_output($rows['title']);?><br/>
					<div style=" padding:5px 3px; height:50px; overflow:auto;"><?php echo tep_db_output( $rows['message']);?>	</div>
				</div>
				<div style="">
					<span style="float:right;color:#666666;">ʱ��:<?php echo $rows['add_date'];?></span>				
	
				
				<?php
				if($rows['admin_id']==0){ $to_name = '���ķ�'; }else{ $to_name = '·��'; }
				
				if ($rows['need_reply']=='1')
				{ 				
					if($rows['is_replied']=='1'){ echo '<span style="color:#0000FF">'.$to_name.'�ѻظ�</span>'; }
					else{ echo '<span style="color:#FF0000">'.$to_name.'δ�ظ�</span>'; }			
				?>
				<a href="<?php 
				echo '?action=communication&visa_order_id='.$visa_order_id;
				
				if ($rows['visa_order_com_root_id']==0) { echo '&visa_order_com_root_id='.$rows['visa_order_com_id']; }
				else { echo '&visa_order_com_root_id='.$rows['visa_order_com_root_id']; }
				
				echo '&visa_order_com_parent_id='.$rows['visa_order_com_id'];
				echo '&user_name='.$visa_lujia_user;
				echo '#a_form_add';
				?>">
					<?php 
					if( $rows['admin_id']==0) {
						//if ($rows['is_replied']=='1'){ echo '׷��';} else { echo '�ظ�'; }
						echo '׷��';
					}else{
						if ($rows['is_replied']=='1'){ echo '׷��';} else { echo '�ظ�'; }
					}
					?>
				</a>
				<?php 
				}
								
				if($rows['is_read']=='0'){ 
					echo '<span style="color:#FF0000">';
					if ($rows['admin_id']>0){ echo '·��';}else{ echo '���ķ�';}
					echo 'δ��</span>'; 
				}				
				
				if(($rows['admin_id']>0) && ($rows['is_read']=='0')){?>
				<input name="" type="button" value="���Ѷ�" onclick="fn_visa_msg_read(<?php echo $rows['visa_order_com_id'];?>)" style="font-size:12px; padding:0;">
				<?php
				}
				?>
				</div>
			</div>
		</div>
		<?php
			if ($rows['admin_id']>0) { 
				$last_from = 'usi';
			} 
			else {
				$last_from = 'lujia';
			}
		}
		?>
		</div>
		<div style="clear:both;"></div>
		<a name="a_form_add"></a>
		<br/>
		<a href="?action=communication&visa_order_id=<?php echo $visa_order_id;?>&user_name=<?php echo $visa_lujia_user;?>">�����ķ���������</a>
		<?php
		$data =false;
		$is_reply = false;
		$visa_order_com_parent_id = (int)$_GET['visa_order_com_parent_id'];
		if ($visa_order_com_parent_id>0){
			$sql = 'SELECT title,message FROM visa_order_communication WHERE visa_order_com_id='.$visa_order_com_parent_id;
			$is_reply = true;
			$sql_query = tep_db_query($sql);
			while($rows =  tep_db_fetch_array($sql_query))
			{
				$data = $rows ;
			}
		}
		?>
		
		
		<form name="form1" id="form1" action="<?= tep_href_link_noseo('visa.php','action=communication_add&visa_order_id='.$visa_order_id.'&visa_order_com_root_id='.$visa_order_com_root_id.'&visa_order_com_parent_id='.$visa_order_com_parent_id.'&user_name='.$visa_lujia_user)?>" method="post" style=" margin-top:10px;">
		
		<table class="tbList">
			<tr>
				<td width="100" align="right">����:</td>
				<td width="300">
				
				<?php if ($is_reply == true){?>			
				<input name="title" type="text" style="width:300px;" value="<?php echo 're:'.$data['title'];?>">			
				<?php
				}else{ 
				?>
				<select name="title" style="width:300px;">
					<option value="��д���">��д���</option>
					<option value="������">������</option>
					<option value="�ύ�ɹ�">�ύ�ɹ�</option>
					<option value="ԤԼ��ǩ">ԤԼ��ǩ</option>
					<option value="����׼��">����׼��</option>
					<option value="��ǩ����">��ǩ����</option>
					<option value="ǩ֤���">ǩ֤���</option>
				</select>
				<?php
				}
				?>
				<span style="color:#FF0000">*</span></td>
			</tr>
			<?php if ($is_reply == true){ ?>
			<tr>
				<td align="right">����:</td><td><?php echo $data['message'];?></td>
			</tr>
			<?php } ?>
			<tr>
				<td align="right"><?php if ($is_reply == true){ echo '�ظ���';}?>����:</td>
				<td>
				<?php echo tep_draw_textarea_field('message', '', '50', '3', $text = '', $parameters = '', $reinsert_value = true);?>
				<span style="color:#FF0000">*</span></td>
			</tr>
			<tr>
				<td align="right">�Ƿ���Ҫ�ظ�:</td>
				<td>
				<label><input name="need_reply" type="radio" value="1" <?php if ($is_reply <> true){?>checked="checked"<?php }?>>�ǵ�,��Ҫ�Է��ظ�</label>
				<label><input name="need_reply" type="radio" value="0" <?php if ($is_reply == true){?>checked="checked"<?php }?>>��,����Ҫ�ظ�</label>
				</td>
			</tr>
			<tr><td></td><td><input name="" type="submit" value="<?php if ($is_reply == true){ echo '�ظ�';}else{ echo '����';}?>"></td></tr>		
		</table>
		</form>	
	<?php
			echo db_to_html(ob_get_clean());
			require(DIR_FS_INCLUDES . 'application_bottom.php');
		}
		else
		{
			echo '[visa order id] OR [user_name] error';
			exit();
		}	

	//��·�ν���/���ԵĲ鿴 end}
	break;
	case 'communication_add': //�����ķ��������� start{
				
		if (!tep_not_null($_SESSION['visa_com_session']))
		{
			echo 'ERROR: user certicate fail, maybe logined too long.';
			exit();
		}
		
		$visa_lujia_user = $_GET['user_name'];
		$visa_order_id = (int)$_GET['visa_order_id'];
		$visa_order_com_root_id = (int)$_GET['visa_order_com_root_id'];
		$visa_order_com_parent_id = (int)$_GET['visa_order_com_parent_id'];
		if($visa_order_id>0) //AND $visa_order_com_parent_id>0
		{
			$data = false;
			$data['admin_id'] = 0;
			
			$data['title'] = tep_db_prepare_input(iconv(CHARSET,'gb2312',$_POST['title']));
			$data['message'] = tep_db_prepare_input(iconv(CHARSET,'gb2312',$_POST['message']));
			$data['need_reply'] = (int)$_POST['need_reply'];
			$data['visa_order_id'] = $visa_order_id;
			$data['add_date'] = date('Y-m-d H:i:s');		
			$data['sender_name'] = tep_db_prepare_input(iconv(CHARSET,'gb2312',$visa_lujia_user));
			$data['visa_order_com_root_id'] = $visa_order_com_root_id;
			$data['visa_order_com_parent_id'] = $visa_order_com_parent_id;
	
			if(tep_not_null($data['title']) && tep_not_null($data['message']) )
			{
				if( $visa_order_com_parent_id >0 )
				{
					$sql = 'UPDATE visa_order_communication SET is_replied=\'1\',is_read=\'1\',read_date=\''.date('Y-m-d H:i:s').'\' WHERE visa_order_com_id='.$visa_order_com_parent_id.' AND admin_id>0 AND is_replied=\'0\' AND admin_id>0';
					tep_db_query($sql);
				}
			
				tep_db_fast_insert('visa_order_communication',$data);
				
				echo '<script>alert("success"); window.location.href="visa.php?action=communication&visa_order_id='.$visa_order_id.'&user_name='.$visa_lujia_user.'";</script>';
				exit();
			}
			else
			{
				echo '<script>alert("error"); window.history.go(-1);</script>';
				exit();
			}
			
		}	
	//�����ķ��������� end}
	break;
	case 'communication_read': //�����Ķ�����֮���ݲ��� start{
		if (!tep_not_null($_SESSION['visa_com_session']))
		{
			echo 'ERROR: user certicate fail, maybe logined too long.';
			exit();
		}
	
		$id = (int)$_GET['id'];
	
		if($id>0)
		{	
			$sql = 'UPDATE visa_order_communication SET is_read=\'1\',read_date=\''.date('Y-m-d H:i:s').'\' WHERE visa_order_com_id='.$id;
			tep_db_query($sql);
		}
		else
		{
			echo 'ERROR: parameter lost';
			exit();	
		}
	//�����Ķ�����֮���ݲ��� end}
	break;
	case 'communication_status': //��ȡ���Զ�ȡ�ظ���״̬ start{
		$cert_rt = false;
		$cert_rt = $visa->get_cert($_GET['cert']);
		if ($cert_rt == false){ 
			echo '{"RST":"fail"}'; 
			exit();
		}
		$sql = 'SELECT a.`lujia_not_replied`,b.`lujia_not_read`,c.`usitrip_not_replied`,d.`usitrip_not_read` FROM  (  SELECT 1 AS id, GROUP_CONCAT(a1.visa_order_id) AS `lujia_not_replied` FROM( SELECT distinct visa_order_id FROM visa_order_communication  WHERE admin_id >0 AND need_reply = \'1\' AND is_replied = \'0\' ) AS a1  ) AS a, (  SELECT 1 AS id, GROUP_CONCAT(b1.visa_order_id) AS `lujia_not_read` FROM( SELECT distinct visa_order_id FROM visa_order_communication  WHERE admin_id >0 AND is_read = \'0\' ) AS b1  ) AS b, (  SELECT 1 AS id, GROUP_CONCAT(c1.visa_order_id) AS `usitrip_not_replied` FROM( SELECT distinct visa_order_id FROM visa_order_communication  WHERE admin_id =0 AND need_reply = \'1\' AND is_replied = \'0\' ) AS c1  ) AS c, (  SELECT 1 AS id, GROUP_CONCAT(d1.visa_order_id) AS `usitrip_not_read` FROM( SELECT distinct visa_order_id FROM visa_order_communication WHERE admin_id =0 AND is_read = \'0\' ) AS d1  ) AS d WHERE a.id=b.id and a.id=c.id and a.id=d.id';
		//echo $sql; exit();
		$sql_query = tep_db_query($sql);
		$rows = tep_db_fetch_array($sql_query);
		echo '{"RST":"ok","lujia_not_replied":"'.$rows['lujia_not_replied'].'","lujia_not_read":"'.$rows['lujia_not_read'].'","usitrip_not_replied":"'.$rows['usitrip_not_replied'].'","usitrip_not_read":"'.$rows['usitrip_not_read'].'"}';
		exit();	
	//��ȡ���Զ�ȡ�ظ���״̬ end}
	break;
	case 'email_from_lujia': //��·�������ʼ�����,�յ������ת��,���·�η������뷢���˵�������ƥ������ start{
		
		$cert_rt = false;
		$cert_rt = $visa->get_cert($_GET['cert']);
		//$cert_rt = true;
		if ($cert_rt == false)
		{ 
			echo 'ERROR: user cert fail.'; exit();
		}
		else
		{
			/*
			TO_EMAIL �ռ��˵�ַ
			TO_NAME �ռ�������
			TITLE �ʼ�����
			CONTENT �ʼ����ݣ�HTML��
			FILE0��FILE1��FILE2... �������ļ������Ƶ�BASE64��ʽ���룩,FILENAME0,FILENAME1,FILENAME2...
			*/
			echo 'prepare to forward email from lujia.';		
			
			$POST = $_POST;
			
	//		$POST = false;
	//		$POST['TO_EMAIL'] = 'xuyuefang1998@163.com';
	//		$POST['TO_NAME'] = '';
	//		$POST['TITLE'] = '����һ������aben�Ĳ����ʼ�';
	//		$POST['CONTENT'] = '<html><body>start���Ŀ�ʼend</body></html>';
	//		$POST['FILE0'] = base64_encode(file_get_contents(DIR_FS_CATALOG.'tmp/1.gif'));
	//		$POST['FILE1'] = base64_encode(file_get_contents(DIR_FS_CATALOG.'tmp/1.gif'));
	//		$POST['FILENAME0'] = '1.gif';
	//		$POST['FILENAME1'] = '2.gif';
			
			//echo $POST['FILE0'];exit();
			
			$visa->visa_forward_email_fromlujia($POST);
			echo 'email forward finished.';
			exit();//��ֹ���
		}
		
	//��·�������ʼ�����,�յ������ת��,���·�η������뷢���˵�������ƥ������ end}
	break;
	default: //һ�����ҳ��start{
		$off_corner_tl_tr = true;
		$BreadOff = true;
		$content = 'visa';
		
		
		$the_title = db_to_html('��������ǩ֤_����ǩ֤����_������ǩ֤����Ǯ_Usitrip���ķ�������');
		$the_key_words = db_to_html('ȥ��������ǩ֤,��������ǩ֤����Ǯ,��������ǩ֤,����ǩ֤ԤԼ');
		$the_desc = db_to_html('�������ػ���������-���ķ��ṩ����,��ѧ��ѧ,����ǩ֤����;ȫ��Ψһ������ǩ֤���������ύϵͳ��ǩ֤����,רҵ�Ŷ�,100%����!');
		
		$visa_product = $visa -> get_visa_product_list();
	//һ�����ҳ��end}
}

require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
require(DIR_FS_INCLUDES . 'application_bottom.php');
?>
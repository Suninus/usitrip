<?php 
require('includes/application_top.php'); 

$message = '';
$error = false;
if($_POST['action']=='upload'){
	//�ϴ�ͼƬ������С
	if($_FILES['creative_file']['name']!=""){
		//echo "yes have images.";
		$pic_name = date('YmdHis');
		$tmp = false;
		$creative_file_name_sm="";
		if($_POST['root_creative_id']<1){		
			if(!tep_not_null($_POST['creative_name'])){
				$error = true;
				$message .= '<div class="warning">����д���⡣</div>';
			}
			if($_POST['group_id']<1){
				$error = true;
				$message .= '<div class="warning">��ѡ��ͼƬ���</div>';
			}
		}
		if(!tep_not_null($_POST['creative_upload_people'])){
			$error = true;
			$message .= '<div class="warning">����д����������</div>';
		}

		if($error==false){
			//�涨ͼƬ���ⲻ���ظ�
			$_POST['creative_name'] = trim($_POST['creative_name']);
			$check_sql = tep_db_query('SELECT * FROM `creative`  WHERE creative_name ="'.tep_db_prepare_input($_POST['creative_name']).'" limit 1');
			$check_row = tep_db_fetch_array($check_sql);
			if($check_row['creative_id']>0){
				$error = true;
				$message .= '<div class="warning">ͼƬ���ⲻ���ظ�����ʹ���������⡣</div>';
			}
		}

		if($error==false){
			$tmp = up_file('gif,jpg,jpeg,png', 1024*1024, IMAGES_DIR.'creative/' , $pic_name ,'creative_file','Y');
			if($tmp!=false){
				$pic_name = $tmp;
				$input_file = IMAGES_DIR.'creative/'.$pic_name;
				$out_file = IMAGES_DIR.'creative/'.preg_replace("/^(.*)\./","$1_sm.",$pic_name);
				$max_width = SM_WIDTH;
				$max_height = SM_HEIGHT;
				//��������ͼ
				if(out_thumbnails($input_file, $out_file, $max_width, $max_height)){
					$creative_file_name_sm = basename($out_file);
				}
				//echo $pic_name;
			}else{
				$error = true;
				$message .= '<div class="warning">�ϴ�ʧ�ܣ��������ͼƬ���ܴ���1M�����ͱ�����gif,jpg,jpeg,png����ЧͼƬ��</div>';
			}
		}
		
		
		if($error == false){
			if(strlen(trim($_POST['creative_description'])) < 1){
				//$_POST['creative_description'] = "��ͼƬ�� ". date('Y-m-d'). " �� ". $_POST['creative_upload_people']." �ϴ���";
			}
			if($_POST['root_creative_id']<1){
				//����creative���ݿ�
				$sql_data_array = array('creative_file_name' => tep_db_prepare_input($pic_name),
									'creative_file_name_sm' => tep_db_prepare_input($creative_file_name_sm),
									'creative_name' => tep_db_prepare_input($_POST['creative_name']),
									'creative_description' => tep_db_prepare_input($_POST['creative_description']),
									'creative_date' => date('Y-m-d H:i:s'),
									'creative_upload_people' => tep_db_prepare_input($_POST['creative_upload_people']),
									'group_id' => (int)$_POST['group_id']
									);
				tep_db_perform('creative', $sql_data_array);
			}else{
			//����creative_a���ݿ�
			$sql_data_array = array('creative_a_file_name' => tep_db_prepare_input($pic_name),
									'creative_a_file_name_sm' => tep_db_prepare_input($creative_file_name_sm),
									'creative_id' => (int)$_POST['root_creative_id'],
									'creative_a_date' => date('Y-m-d H:i:s'),
									'creative_a_upload_people' => tep_db_prepare_input($_POST['creative_upload_people']),
									);
				tep_db_perform('creative_a', $sql_data_array);
				tep_db_query('update `creative` set creative_date="'.date('Y-m-d H:i:s').'" WHERE creative_id ="'.(int)$_POST['root_creative_id'].'" ');
			}
			
			header('Location: creative.php');
			exit;
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ϴ����Ч��ͼ</title>
<base href="<?php echo WEB_DIR?>" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<fieldset>
<legend align="left"><span class="STYLE1">�ϴ����Ч��ͼ</span></legend>

<table border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><?php echo $message ?></td>
        </tr>
        <tr>
          <td align="right">ѡ�񸸼���</td>
          <td align="left">
		  
<?php
	$sql = tep_db_query('SELECT *  FROM `creative` ');	
	$row = tep_db_fetch_array($sql);
	$state_select="";
	$option_array = array();
	$option_array[0]['id']='0';
	$option_array[0]['text']='--��ѡ--';
	$do=1;
	do{
		$option_array[$do]['id'] = $row['creative_id'];
		$option_array[$do]['text'] = $row['creative_name'];
		$do++;
	}while( $row = tep_db_fetch_array($sql));
	echo tep_draw_pull_down_menu('root_creative_id', $option_array);

?>		  </td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left">��ʾ������ѡ���˸�����ֻ��Ҫ�ϴ�ͼƬ����д�������ֱ���ύ���ɡ�</td>
        </tr>
        <tr>
          <td align="right">ͼƬ���</td>
          <td align="left">
<?php
	$sql = tep_db_query('SELECT group_id,group_name,group_type_id  FROM `images_group` where group_name!="��Ʋο�" AND group_name!="���̷��ο�" ORDER BY group_id ASC');	
	$row = tep_db_fetch_array($sql);
	$state_select="";
	$option_array = array();
	$option_array[0]['id']='0';
	$option_array[0]['text']='--ѡ�����--';
	$do=1;
	do{
		$option_array[$do]['id'] = $row['group_id'];
		$option_array[$do]['text'] = $row['group_name'];
		$do++;
	}while( $row = tep_db_fetch_array($sql));
	echo tep_draw_pull_down_menu('group_id', $option_array);

?>			</td>
        </tr>
        <tr>
          <td align="right">ͼƬ���⣺</td>
          <td align="left">
		  <?php echo tep_draw_input_field('creative_name', '', ' size="30" ') ?>
            <span class="warning">*</span></td>
        </tr>
        <tr>
          <td align="right">ͼƬ��ַ��</td>
          <td align="left"><input name="creative_file" type="file" id="creative_file" onchange="show_image.src=this.value" size="30" /></td>
        </tr>
        <tr>
          <td align="right">ͼƬ˵����</td>
          <td align="left">
		  <?php echo tep_draw_textarea_field('creative_description', 'virtual', 30, 5) ?>		  </td>
        </tr>
        <tr>
          <td align="right"><?php echo YOUR_NAME?>��</td>
          <td align="left">
		  <?php echo tep_draw_input_field('creative_upload_people', '', ' size="20" ') ?>
            <span class="warning">*</span></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input type="submit" name="Submit" value="�ύ" />
            <input name="Submit2" type="button" onclick="MM_goToURL('parent','creative.php');return document.MM_returnValue" value="����" />
            <input name="action" type="hidden" id="action" value="upload" /></td>
        </tr>
      </table>
        </form>    </td>
    <td><img id="show_image" src="creative/boy.gif" width="144" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</fieldset>
</body>
</html>

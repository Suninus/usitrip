<?php
require('../includes/classes/visa_invitation.php');
require('../includes/classes/visa_invitation_print.php');
require('../includes/classes/mail_send_smtp.php');
require('includes/application_top.php');
$opid = (int)$_GET['opid'];
try {
	if (isset($_GET['action']) && $_GET['action'] != '') {
		$action = $_GET['action'];
		switch ($action) {
			case 'send': //Ԥ�����뺯
				$invitation = new visa_invitation_print($opid);
				$invitation->set_template_file(DIR_FS_CATALOG . 'email_tpl/visa_invitation.tpl.html');
				if (isset($_POST['dob']) && isset($_POST['passport_number']) && isset($_POST['nationality']) && isset($_POST['index'])) {
					$user_dob = array();
					if(isset($_POST['check'])){
						foreach($_POST['check'] as $i=>$value){
							if ($_POST['dob'][$i] == '' || $_POST['passport_number'][$i] == '' || $_POST['nationality'][$i] == '') {
								exit('��δ��д������<a href="javascript:history.go(-1)">Return</a>');
							}
							$user_dob[$_POST['index'][$i]] = array(
								'dob'             => tep_db_output($_POST['dob'][$i]),
								'passport_number' => tep_db_output($_POST['passport_number'][$i]),
								'nationality'     => tep_db_output($_POST['nationality'][$i]),
								'money'           => tep_db_output($_POST['money'][$i]),
								'guest_name'      => tep_db_output($_POST['guest_name'][$i]),
								'email'           => tep_db_output($_POST['email'][$i]),
								'sex'             => tep_db_output($_POST['sex'][$i])
							);
							if(empty($_POST['email'][$i])){
								die('����������Ϣ��ȫ������д��������������');
							}
						}
					} else {
						die('δ��ѡ������');
					}
					//print_r($user_dob);
					//die();
					$invitation->set_user_dob($user_dob);
					//$invitation->save_guest_to_db();
					//$invitation->addInvitationToDb();
					$name = $invitation->doit();
					$_SESSION['invitation'] = serialize($invitation);
					header('content-type:text/html;charset=' . CHARSET);
					echo($name);
					echo '<div style="margin:0 auto;text-align:center"><a href="?action=send_ok&opid=' . $opid . '">' . db_to_html('ȷ�ϲ��ҷ���֪ͨ�ʼ�') . '</a></div>';
					exit;
				} else {
					exit('������д������');
				}
				break;
			case 'send_ok': //�������뺯�ʼ�
				//print_r($_SESSION);
				//require('../includes/classes/visa_invitation_print.php');
				if (isset($_SESSION['invitation'])) {
					$invitation = unserialize($_SESSION['invitation']);
					unset($_SESSION['invitation']);
				} else {
					exit('<script type="text/javascript">alert("' . db_to_html('��ǰû���ʼ�Ҫ����!') . '");</script>');
				}
				$invitation->addInvitationToDb();
				$invi = new visa_invitation($opid);
 				$to_arr=$invitation->getEmailArray();
 				list($email,$name) = each($to_arr);
 				array_splice($to_arr, 0,1);
				$subject = '���ķ�--���뺯';
				$str = "�𾴵�";
				if (!empty($name)) {
					$str .= $name;
				}
 				if (!empty($to_arr)) {
 					$str .= '��'.implode('��',array_values($to_arr));
 				}
				$str .= "����/Ůʿ�����ã�\r\n";
				$str .= "&nbsp;&nbsp;&nbsp;&nbsp;����ǩ֤���뺯�Ѿ�������ɣ�������ʹ�ô����ӵ�¼�����û����Ĵ�ӡ����";
				$href = str_replace('/admin/','/',tep_href_link('visa_invitation.php','opid=' . $opid));
				$str .= '<a href="' . $href . '" target="_blank">' . $href . '</a>';
				$str .= "����ǩ֤ʱ����Я�������뺯�����պ�����ļ���ף��ǩ֤˳����\r\n";
				$str .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;лл\r\nע���������δ�ڱ�վע�ᣬ��ʹ�õ�ǰ���ʼ��������ַ����ע�ᣡ�ٵ��������Ӵ�ӡ���뺯��\r\n";
				$str .= "\r\n" . CONFORMATION_EMAIL_FOOTER . "\r\n";
				$str .= "<b>���ʼ���ϵͳ�Զ�����������ֱ�ӻظ���</b>";
				
				$job_number = tep_get_admin_customer_name($_SESSION['login_id']);
				$invi->isSendMail($job_number);
				$mail = new mail_send_smtp();
				$mail->set_from_address('automail@usitrip.com');
				$mail->set_from_name('���ķ�');
				$mail->set_subject('���뺯--���ķ�');
				$mail->set_charset('gb2312');
				$mail->set_to_name($name);
				$mail->set_to_address($email);
 				if (!empty($to_arr)) {
 					$mail->set_copy_to($to_arr);//����
 				}
 				$mail->set_bcc_to(array('2355652793@qq.com' => '����','2355652780@qq.com' => '��'));//����
				$mail->set_mail_type('html');
				$mail->set_body($str);//�����ʼ�����
				
				//��ȡ��վ�������ʼ�������Ϣ
				$rs = tep_db_query("select * from smtp_mail where mail_id=4 and action_status = true");
				$rs = tep_db_fetch_array($rs);
				$host_name = $rs['host_name'];
				$port_code = $rs['port_code'];
				$user = $rs['mail_address'];
				$pass = $rs['mail_password'];
				require '../includes/classes/mail_send_agent_smtp.php';
				
				$rtn = $mail->send_mail(new mail_send_agent_smtp($host_name, $user, $pass, $port_code,false,2,DIR_FS_CATALOG . 'tmp'));//�����ʼ�

				
				header('Content-type:text/html;charset=' . CHARSET);
				exit('<script type="text/javascript">alert("' . db_to_html('�ʼ��ѷ���!') . '");window.close();</script>');
				die();
				break;
		}
		
	} else {
		$invitation = new visa_invitation_print($opid);
		$guest_name = $invitation->getGuestName();
	}
	$invitation = new visa_invitation_print($opid);
} catch (Exception $e) {
	print_r($e->getMessage());
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title>�༭/���� ���뺯</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css" />
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/big5_gb-min.js"></script>
<script language="javascript" src="includes/javascript/add_global.js"></script>
<script type="text/javascript" src="includes/jquery-1.3.2/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="includes/javascript/calendar.js"></script>
<style type="text/css">
#connter{width:960px;margin:0 auto;}
</style>
</head>

<body>
<?php
require(DIR_WS_INCLUDES . 'header.php'); 
if ($messageStack->size > 0) {
	echo $messageStack->output();
}
?>
<div id="connter">

<form action="visa_edit_invitation.php?action=send&opid=<?php echo $opid?>" method="post">
		<?php 
		echo tep_draw_hidden_field('opid',''.$opid.'');
		?>
		<fieldset><legend>������Ա�б�</legend>
		<table id="TableList" width="100%">
			<tr style="text-align:center">
				<th>����</th>
				<th>����</th>
				<th>����</th>
				<th>��������</th>
				<th>���պ���</th>
				<th>����</th>
				<th>���</th>
				<th>�Ƿ���</th>
			</tr>
			<?php 
			if (is_array($guest_name)) {
				foreach($guest_name as $key => $val) {?>
			<tr>
				<td><input type="checkbox" name="check[<?=$val['guest_id']?>]" /></td>
				<td><?php echo $val['e_mail'] ?></td>
				<td>
					<input type="hidden" value="<?=$val['e_mail'] ?>" name="email[<?=$val['guest_id']?>]" />
					<input type="hidden" value="<?php echo $val['sex']?>" name="sex[<?php echo $val['guest_id']?>]" />
					<input type="hidden" value="<?=$val['guest_name'] ?>" name="guest_name[<?=$val['guest_id']?>]" />
					
					<?php 
						echo $val['guest_name'];
						echo tep_draw_hidden_field('index[' . $val['guest_id'] . ']',(string)$val['guest_id']);
					?>
				</td>
				<td><?php echo tep_draw_input_field('dob[' . $val['guest_id'] . ']', $val['dob'])?></td>
				<td><?php echo tep_draw_input_field('passport_number[' . $val['guest_id'] . ']',$val['passport_number'])?></td>
				<td><?php echo tep_draw_input_field('nationality[' . $val['guest_id'] . ']',$val['nationality'])?></td>
				<td><input type="text" name="money[<?=$val['guest_id']?>]" value="<?=$val['money']?>" /></td>
				<td><?php if($val['is_send']){?><font color="red">�ѷ���</font><?php }else{?><font>δ����</font><?php }?>
				</td>
			</tr>
			<?php 
				}
			}?>
			<tr>
				<td><input type="submit" value="Ԥ�����뺯" /></td>
			</tr>
		</table>
		</fieldset>
</form>
</div>

</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>


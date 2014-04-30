<?php
/*
  $Id: articles.php, v1.0 2003/12/04 12:00:00 ra Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  
  require('includes/application_top.php');
  define('ONLY_USE_NEW_CSS',true);
  
	$_GET['landingpagename'];
	$landing_path = 'landing-page/'.$_GET['landingpagename'].'/';
	
	if($_GET['landingpagename']=="rocky-mountain"){
		$the_title = db_to_html('���ɽ�����ž�ѡ-�������ɽ�� - ���ķ���');
	}
	if($_GET['landingpagename']=="family-travel"){
		$the_title = db_to_html('2011���������Σ�����������У����ת������԰ - ���ķ���');
	}
	
	$patterns = array();
	$patterns[0] = '{PATH}';
	
	$replacements = array();
	$replacements[0] = $landing_path;

	//���Ƹ����ó�Landing Page start
	if($_GET['landingpagename']=="group_buy_form"){
		if($_POST['action_submit_mail']=="1"){
			$error = false;
			$EmailAddress=$_POST['EmailAddress'];
			$ChineseName=$_POST['ChineseName'];
			$City=$_POST['City'];
			$PhoneNum=$_POST['PhoneNum'];
			$EmailContents=$_POST['EmailContents'];
			if(!tep_not_null($EmailAddress)){
				$error = true;
				$messageStack->add('LandingPageMsn', db_to_html('���������ĵ������䣡'));
			}elseif(tep_validate_email($EmailAddress) == false){
				$error = true;
				$messageStack->add('LandingPageMsn', db_to_html('������ĵ��������ʽ����'));
			}
			if(!tep_not_null($EmailContents)){
				$error = true;
				$messageStack->add('LandingPageMsn', db_to_html('�г�Ҫ����Ϊ�գ�'));
			}
			if($error==false){
				$to_name = "";
				$to_email_address = "group@usitrip.com";
				if(!preg_match('/cn\.usitrip\.com/',HTTP_SERVER) && !preg_match('/www\.usitrip\.com/',HTTP_SERVER)){
					$to_email_address = "allegro.li@usitrip.com";
				}
				$email_subject = $ChineseName.db_to_html(" ѯ�ʰ��ţ������г̣�������Ϣ ");
				$email_text = $EmailContents.db_to_html("<hr>����������").$ChineseName.db_to_html(" ���˵绰��").$PhoneNum.db_to_html(" ���ڳ��У�").$City.db_to_html(" �������䣺").$EmailAddress."<hr>";
				$email_text .= db_to_html("�ʼ�����ҳ��").tep_href_link('landing-page.php', 'landingpagename='.$_GET['landingpagename'])."<hr>";
				$from_email_name = $ChineseName." ";
				$from_email_address = $EmailAddress;
				//howard add use session+ajax send email
				$array_count = sizeof($_SESSION['need_send_email']);
				$_SESSION['need_send_email'][$array_count]['to_name'] = $to_name;
				$_SESSION['need_send_email'][$array_count]['to_email_address'] = $to_email_address;
				$_SESSION['need_send_email'][$array_count]['email_subject'] = $email_subject;
				$_SESSION['need_send_email'][$array_count]['email_text'] = $email_text;
				$_SESSION['need_send_email'][$array_count]['from_email_name'] = $from_email_name;
				$_SESSION['need_send_email'][$array_count]['from_email_address'] = $from_email_address;
				$_SESSION['need_send_email'][$array_count]['action_type'] = 'true';
				//howard add use session+ajax send email end
				$messageStack->add_session('LandingPageMsn', db_to_html('��Ϣ���ͳɹ���'),'success');
				tep_redirect(tep_href_link('landing-page.php', 'landingpagename='.$_GET['landingpagename']));
				
			}
		}
		
		$LandingPageMsn = "";
		if ($messageStack->size('LandingPageMsn') > 0) {
			$LandingPageMsn = $messageStack->output('LandingPageMsn'); 
		}
		
		$patterns[sizeof($patterns)] = '{LandingPageMsn}';
		$replacements[sizeof($replacements)] = $LandingPageMsn;
		//�����
		$input_ChineseName = tep_draw_input_field('ChineseName','',' class="contenttext1" ');
		$patterns[sizeof($patterns)] = '{input_ChineseName}';
		$replacements[sizeof($replacements)] = $input_ChineseName;
		
		$input_City = tep_draw_input_field('City','',' class="contenttext1" ');
		$patterns[sizeof($patterns)] = '{input_City}';
		$replacements[sizeof($replacements)] = $input_City;
		
		$input_EmailAddress = tep_draw_input_field('EmailAddress','',' class="contenttext1" ');
		$patterns[sizeof($patterns)] = '{input_EmailAddress}';
		$replacements[sizeof($replacements)] = $input_EmailAddress;
		
		$input_PhoneNum = tep_draw_input_field('PhoneNum','',' class="contenttext1" ');
		$patterns[sizeof($patterns)] = '{input_PhoneNum}';
		$replacements[sizeof($replacements)] = $input_PhoneNum;
		if(!isset($_POST['EmailContents'])){
			$EmailContents = db_to_html('1.����������С���ʹ��˵�������
2.��������
3.��������
4.ϣ��ȥ����Ŀ�ĵ�
5.ϣ�������ľ���
6.��ס�Ƶ꼶��
7.�Ƿ�����ʳ
8.�г�Ԥ��
9.�Ƿ�ӵ��Ŀ�ĵ�ǩ֤');
		}
		
		$textarea_EmailContents = tep_draw_textarea_field('EmailContents','','','',$EmailContents,' class="contenttext2" ');
		$patterns[sizeof($patterns)] = '{textarea_EmailContents}';
		$replacements[sizeof($replacements)] = $textarea_EmailContents;
	}
	//���Ƹ����ó�Landing Page end
  $content = 'landing-page';
  $BreadOff = true;

  require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_FS_INCLUDES . 'application_bottom.php'); 
 ?>
<?php
/*
  $Id: moneyorder.php,v 1.2 2004/03/05 00:36:42 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', '�䲼��I(����)');
  
  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', '
  <ul>
  <li>
  �ڥq�����ӤH�䲼�]Personal Check�^�A���q�䲼�]Business Check�^�A�{���䲼�]Money Order�^, �Ȧ�䲼�]Travel Check�^�M�Ȧ�䲼�]Bank Check�^�C
  <br>
  <span class="color_blue">�бN�䲼�I���G<strong>'.MODULE_PAYMENT_MONEYORDER_PAYTO.'</strong></span>
  </li>
  <li><a class="download" href="'.tep_href_link('CheckDraftAuthorizationForm.pdf').'">Download�䲼��I���v�� </a>(A).  �p�G�O�ӤH�䲼�Τ��q�䲼�z�L���l�H�䲼�A�u�ݶ�g<a class="color_orange" href="'.tep_href_link('CheckDraftAuthorizationForm.pdf').'">�䲼��I���v��</a>,<br>
�ǯu�α��y��EMAIL���ڭ̪��l�c<a class="color_orange" href="mailto:service@usitrip.com">service@usitrip.com</a> �Y�i�C  </li>
  <li class="last">(B).  �p�G�O�{���䲼�]Money Order�^, �Ȧ�䲼�]Travel Check�^�λȦ�䲼�]Bank Check�^�A�ǯu�α��y��EMAIL���ڭ̪��l�c<a class="color_orange" href="mailto:service@usitrip.com">service@usitrip.com </a>�A�ýбN�䲼���q�L�ֻ��l�H���ڭ̤��q�GUnitedstars International Ltd.�A Address: 133B W Garvey Ave, Monterey Park, CA, USA 91754<br>
<br>
<img alt="�䲼�˪O" src="'.HTTP_SERVER.'/image/pic11.jpg"><br><br></li>
  </ul>
  ');
 
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', 
  '
  �ڥq�����ӤH�䲼�]Personal Check�^�A���q�䲼�]Business Check�^�A�{���䲼�]Money Order�^, �Ȧ�䲼�]Travel Check�^�M�Ȧ�䲼�]Bank Check�^�C'."\n".
  '�бN�䲼�I���G<strong>'.MODULE_PAYMENT_MONEYORDER_PAYTO.'</strong>'."\n".
  '(A). �p�G�O�ӤH�䲼�Τ��q�䲼�z�L���l�H�䲼�A�u�ݶ�g<a class="color_orange" href="'.tep_href_link('CheckDraftAuthorizationForm.pdf').'">�䲼��I���v��</a>,�ǯu�α��y��EMAIL���ڭ̪��l�c<a class="color_orange" href="mailto:service@usitrip.com">service@usitrip.com</a> �Y�i�C'."\n".
  '(B). �p�G�O�{���䲼�]Money Order�^, �Ȧ�䲼�]Travel Check�^�λȦ�䲼�]Bank Check�^�A�ǯu�α��y��EMAIL���ڭ̪��l�c<a class="color_orange" href="mailto:service@usitrip.com">service@usitrip.com </a>�A�ýбN�䲼���q�L�ֻ��l�H���ڭ̤��q�GUnitedstars International Ltd.�A Address: 133B W Garvey Ave, Monterey Park, CA, USA 91754'."\n".
  '<img alt="�䲼�˪O" src="'.HTTP_SERVER.'/image/pic11.jpg">'
  );
?>
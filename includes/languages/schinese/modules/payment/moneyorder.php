<?php
/*
  $Id: moneyorder.php,v 1.2 2004/03/05 00:36:42 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', '֧Ʊ֧��(����)');
  
  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', '
  <ul>
  <li>
  ��˾���ո���֧Ʊ��Personal Check������˾֧Ʊ��Business Check�����ֽ�֧Ʊ��Money Order��, ����֧Ʊ��Travel Check��������֧Ʊ��Bank Check����
  <br>
  <span class="color_blue">�뽫֧Ʊ������<strong>'.MODULE_PAYMENT_MONEYORDER_PAYTO.'</strong></span>
  </li>
  <li><a class="download" href="'.tep_href_link('CheckDraftAuthorizationForm.pdf').'">Download֧Ʊ֧����Ȩ�� </a>(A).  ����Ǹ���֧Ʊ��˾֧Ʊ�������ʼ�֧Ʊ��ֻ����д<a class="color_orange" href="'.tep_href_link('CheckDraftAuthorizationForm.pdf').'">֧Ʊ֧����Ȩ��</a>,<br>
�����ɨ���EMAIL�����ǵ�����<a class="color_orange" href="mailto:service@usitrip.com">service@usitrip.com</a> ���ɡ�  </li>
  <li class="last">(B).  ������ֽ�֧Ʊ��Money Order��, ����֧Ʊ��Travel Check��������֧Ʊ��Bank Check���������ɨ���EMAIL�����ǵ�����<a class="color_orange" href="mailto:service@usitrip.com">service@usitrip.com </a>�����뽫֧Ʊԭ��ͨ������ʼĸ����ǹ�˾��Unitedstars International Ltd.�� Address: 133B W Garvey Ave, Monterey Park, CA, USA 91754<br>
<br>
<img alt="֧Ʊ����" src="'.HTTP_SERVER.'/image/pic11.jpg"><br><br></li>
  </ul>
  ');
 
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', 
  '
  ��˾���ո���֧Ʊ��Personal Check������˾֧Ʊ��Business Check�����ֽ�֧Ʊ��Money Order��, ����֧Ʊ��Travel Check��������֧Ʊ��Bank Check����'."\n".
  '�뽫֧Ʊ������<strong>'.MODULE_PAYMENT_MONEYORDER_PAYTO.'</strong>'."\n".
  '(A). ����Ǹ���֧Ʊ��˾֧Ʊ�������ʼ�֧Ʊ��ֻ����д<a class="color_orange" href="'.tep_href_link('CheckDraftAuthorizationForm.pdf').'">֧Ʊ֧����Ȩ��</a>,�����ɨ���EMAIL�����ǵ�����<a class="color_orange" href="mailto:service@usitrip.com">service@usitrip.com</a> ���ɡ�'."\n".
  '(B). ������ֽ�֧Ʊ��Money Order��, ����֧Ʊ��Travel Check��������֧Ʊ��Bank Check���������ɨ���EMAIL�����ǵ�����<a class="color_orange" href="mailto:service@usitrip.com">service@usitrip.com </a>�����뽫֧Ʊԭ��ͨ������ʼĸ����ǹ�˾��Unitedstars International Ltd.��Address: 133B W Garvey Ave, Monterey Park, CA, USA 91754'."\n".
  '<img alt="֧Ʊ����" src="'.HTTP_SERVER.'/image/pic11.jpg">'
  );
?>
<?php
/*
  $Id: banktransfer.php,v 1.3 2002/05/31 19:02:02 thomasamoulton Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE', '�Ȧ�q��(����)');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION', 
		  '<ul>
		  <li><br>�z�i�H�q�L�Ȧ�״ڪ��覡�i���I�Ϊ̱N�ڶ������s�J�ڭ̪��b��G<br>'.
		  '<br>�b��W�G &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>' . MODULE_PAYMENT_BANKTRANSFER_ACCNAM .'</b>'. 
		  '<br>�b���G &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>' . MODULE_PAYMENT_BANKTRANSFER_ACCNUM .'</b>'. 
		  '<br>�Ȧ�Swift Code�G &nbsp;<b>' . MODULE_PAYMENT_BANKTRANSFER_SORTCODE . '</b>' .
		  '<br>Bank ABA Number�G <b>' . MODULE_PAYMENT_BANKTRANSFER_ROUNUM .'</b>' .
		  '<br>�Ȧ�W�r�G &nbsp;&nbsp;&nbsp;<b>' . MODULE_PAYMENT_BANKTRANSFER_BANKNAM .'</b>'. 
		  "<br>�Ȧ�a�}�G<br>".MODULE_PAYMENT_BANKTRANSFER_ADDRESS.
		  '
		  </li>
		  <li>
		  <b>�S�O���ܡG</b><span style="color:#6F6F6F;">�о��q�b�״ڸ�T�Ƶ����d�U�z���q�渹�A�m�W����T�I�H�K�ڭ̪��]�ȳ��ֹ�O�ӭq�檺�״ڡC �����I�ګ�Фή��pô�ڭ̪��u�W�ȪA�i���I�ڧ����C�@�������Ȧ����O�ѱz�ۦ�Ӿ�I</span>
		  </li>
		  </ul>
		  '
		  );

  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_EMAIL_FOOTER', 
		  "\n�z�i�H�q�L�Ȧ�״ڪ��覡�i���I�Ϊ̱N�ڶ������s�J�ڭ̪��b��G\n".
		  "\n�b��W�G &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>" . MODULE_PAYMENT_BANKTRANSFER_ACCNAM ."</b>". 
		  "\n�b���G &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>" . MODULE_PAYMENT_BANKTRANSFER_ACCNUM ."</b>". 
		  "\n�Ȧ�Swift Code�G &nbsp;<b>" . MODULE_PAYMENT_BANKTRANSFER_SORTCODE . "</b>" .
		  "\nBank ABA Number�G <b>" . MODULE_PAYMENT_BANKTRANSFER_ROUNUM ."</b>" .
		  "\n�Ȧ�W�r�G &nbsp;&nbsp;&nbsp;<b>" . MODULE_PAYMENT_BANKTRANSFER_BANKNAM ."</b>". 
		  "\n�Ȧ�a�}�G\n".MODULE_PAYMENT_BANKTRANSFER_ADDRESS.
		  "\n\n�S�O���ܡG�о��q�b�״ڸ�T�Ƶ����d�U�z���q�渹�A�m�W����T�I�H�K�ڭ̪��]�ȳ��ֹ�O�ӭq�檺�״ڡC �����I�ګ�Фή��pô�ڭ̪��u�W�ȪA�i���I�ڧ����C�@�������Ȧ����O�ѱz�ۦ�Ӿ�I\n\n"
		  );
?>
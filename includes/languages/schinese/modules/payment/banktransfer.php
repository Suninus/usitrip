<?php
/*
  $Id: banktransfer.php,v 1.3 2002/05/31 19:02:02 thomasamoulton Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE', '���е��(����)');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION', 
		  '<ul>
		  <li><br>������ͨ�����л��ķ�ʽ����֧�����߽�����ֱ�Ӵ������ǵ��ʻ���<br>'.
		  '<br>�˻����� &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>' . MODULE_PAYMENT_BANKTRANSFER_ACCNAM .'</b>'. 
		  '<br>�˺ţ� &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>' . MODULE_PAYMENT_BANKTRANSFER_ACCNUM .'</b>'. 
		  '<br>����Swift Code�� &nbsp;<b>' . MODULE_PAYMENT_BANKTRANSFER_SORTCODE . '</b>' .
		  '<br>Bank ABA Number�� <b>' . MODULE_PAYMENT_BANKTRANSFER_ROUNUM .'</b>' .
		  '<br>�������֣� &nbsp;&nbsp;&nbsp;<b>' . MODULE_PAYMENT_BANKTRANSFER_BANKNAM .'</b>'. 
		  "<br>���е�ַ��<br>".MODULE_PAYMENT_BANKTRANSFER_ADDRESS.
		  '
		  </li>
		  <li>
		  <b>�ر���ʾ��</b><span style="color:#6F6F6F;">�뾡���ڻ����Ϣ��ע���������Ķ����ţ���������Ϣ���Ա����ǵĲ��񲿺˶��Ǹö����Ļ� ��ɸ�����뼰ʱ��ϵ���ǵ����߿ͷ���֪������ϡ�һ����������������������ге���</span>
		  </li>
		  </ul>
		  '
		  );

  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_EMAIL_FOOTER', 
		  "\n������ͨ�����л��ķ�ʽ����֧�����߽�����ֱ�Ӵ������ǵ��ʻ���\n".
		  "\n�˻����� &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>" . MODULE_PAYMENT_BANKTRANSFER_ACCNAM ."</b>". 
		  "\n�˺ţ� &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>" . MODULE_PAYMENT_BANKTRANSFER_ACCNUM ."</b>". 
		  "\n����Swift Code�� &nbsp;<b>" . MODULE_PAYMENT_BANKTRANSFER_SORTCODE . "</b>" .
		  "\nBank ABA Number�� <b>" . MODULE_PAYMENT_BANKTRANSFER_ROUNUM ."</b>" .
		  "\n�������֣� &nbsp;&nbsp;&nbsp;<b>" . MODULE_PAYMENT_BANKTRANSFER_BANKNAM ."</b>". 
		  "\n���е�ַ��\n".MODULE_PAYMENT_BANKTRANSFER_ADDRESS.
		  "\n\n<b>�ر���ʾ��</b>�뾡���ڻ����Ϣ��ע���������Ķ����ţ���������Ϣ���Ա����ǵĲ��񲿺˶��Ǹö����Ļ� ��ɸ�����뼰ʱ��ϵ���ǵ����߿ͷ���֪������ϡ�һ����������������������ге���\n\n"
		  );
?>
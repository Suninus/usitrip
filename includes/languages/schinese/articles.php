<?php
/*
  $Id: articles.php, v1.0 2003/12/04 12:00:00 ra Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('TEXT_MAIN', '');
define('TABLE_HEADING_NEW_ARTICLES', '�й��� %s ��ѶϢ');

if ( ($topic_depth == 'articles') || (isset($HTTP_GET_VARS['authors_id'])) ) {
  define('HEADING_TITLE', $topics['topics_name']);
  define('TABLE_HEADING_ARTICLES', '����');
  define('TABLE_HEADING_AUTHOR', '����');
  define('TEXT_NO_ARTICLES', 'Ŀǰ�޴�����֮�������');
  define('TEXT_NO_ARTICLES2', 'Ŀǰ�޴�����֮�������');
  define('TEXT_NUMBER_OF_ARTICLES', '��������: ');
  define('TEXT_SHOW', '��ʾ:');
  define('TEXT_NOW', '\' Ŀǰ');
  define('TEXT_ALL_TOPICS', '��������');
  define('TEXT_ALL_AUTHORS', '��������');
  define('TEXT_ARTICLES_BY', '������');
  define('TEXT_ARTICLES', '����������µ�ѶϢ������');  
  define('TEXT_DATE_ADDED', '�ѳ���:');
  define('TEXT_AUTHOR', '����:');
  define('TEXT_TOPIC', '�й���:');
  define('TEXT_BY', '��');
  define('TEXT_READ_MORE', '��ϸ����...');
  define('TEXT_MORE_INFORMATION', '������ϸ���������������վ <a href="http://%s" target="_blank">��ҳ</a>.');
} elseif ($topic_depth == 'top') {
  define('HEADING_TITLE', '��������');
  define('TEXT_ALL_ARTICLES', '���������������һ�ڵ�����');
  define('TEXT_CURRENT_ARTICLES', 'Ŀǰ����');
  define('TEXT_UPCOMING_ARTICLES', '�����Ƴ�������');
  define('TEXT_NO_ARTICLES', 'Ŀǰ������');
  define('TEXT_DATE_ADDED', '�ѳ���:');
  define('TEXT_DATE_EXPECTED', 'Ԥ���Ƴ�:');
  define('TEXT_AUTHOR', '����:');
  define('TEXT_TOPIC', '����:');
  define('TEXT_BY', '��');
  define('TEXT_READ_MORE', '��ϸ����...');
} elseif ($topic_depth == 'nested') {
  define('HEADING_TITLE', '����');
}

?>
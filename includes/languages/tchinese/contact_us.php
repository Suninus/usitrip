<?php

/*

  $Id: contact_us.php,v 1.1.1.1 2003/03/22 16:56:02 nickle Exp $



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License



  Traditional Chinese language pack(Big5 code) for osCommerce 2.2 ms1

  Community: http://forum.kmd.com.tw

  Author(s): Nickle Cheng (nickle@mail.kmd.com.tw)

  Released under the GNU General Public License ,too!!



*/



define('HEADING_TITLE', '��ڭ��p��');

define('NAVBAR_TITLE', '��ڭ��p��');

define('TEXT_SUCCESS', '�w�g����z���t�ߡA�ڭ̷|�ɧֻP�z�pô�I');

define('EMAIL_SUBJECT', '�@�ʥ�'. STORE_NAME .'�H�Ӫ��U�ȸ߫H��');

define('ENTRY_NAME', '�m�W:');

define('ENTRY_EMAIL', '�q�l�l�c:');

define('ENTRY_ENQUIRY', '���ߨƶ�:');





//amit added more

define('TEXT_CONTINE_APPROVE','<br /><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">�z���ӫH���ڭ̤��_�i�B�C</font></strong>');



	  define('TEXT_CONTECT_EXPLAINE','<font size="2" face="Verdana, Arial, Helvetica, sans-serif">�P�±z�飼�|����]usitrip.com�^���X��, �o�O�z�u�W�ʹΪ��̦n��ܡA�O�z�r�֮ȵ{���_�I�C�ڭ̫O�ұz�b�����ʤ߻��ȹC���~���P�ɡA�٥i�H�`�٤@�j������C�z�O�_���ҺðݩιJ��@�ǧ޳N���D? �άO���@�ǷN���Ϋ�ĳ? �z�H�ɥi�H�P�ڭ��pô�C<br>
<p style="padding:5px 0 10px;">���|������U�Ӽ�<img src="image/logo_s.gif" alt="���Ӽ��k���|����Ҧ��C" title="���Ӽ��k���|����Ҧ��C" style="vertical-align:middle;" />�C</p>
      <br>

      �L�צ�ح�]�A�Х���g�U��C�ڭ̱N�ɤO�b1-2�Ӥu�@�餺���z�^�_</font>');

	  define('TEXT_TOUR_NAME','�Ȧ�ΦW��');

	  define('TEXT_TOUR_CODE','�Ȧ�ΥN�X');

	  define('TEXT_RESERVATION_NUMBER','�w�q���X');

	  define('TEXT_COMMENT_QEUESTIONS','��ĳ/�ð�');

	  define('TEXT_CONTECT_FOOTER_SEO','
�z�o�l���<a href="mailto:'.STORE_OWNER_EMAIL_ADDRESS.'">'.STORE_OWNER_EMAIL_ADDRESS.'</a>.
�|�o���ֱ������`�C�p�G�z�w�w�q�A�Цb�l��D�D�̪��W�z���w�q���X�C <br>
<br>
       <br>      
<br>

	  <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">�q�l�l��</font></strong> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />

     �p������i�ܲ��~����{�O�ΡB��{�Ӹ`�B�s���ξ������������ðݡA�еo�l���<a href="mailto:'.STORE_OWNER_EMAIL_ADDRESS.'"> '.STORE_OWNER_EMAIL_ADDRESS.'</a>�A�Ъ`���q�l�ѹξ��Ҹ��X�έq�渹�A�ȪA�H���N�b�@�Ӥu�@�餺�ѵ��C <br>
�p�ݳ�W���Ρ]�p�]�Ρ^�έөʤƭq�s��{�A�еo�l���<a href="mailto:group@usitrip.com">group@usitrip.com</a>�A�M�~�H���N�b1��2�Ӥu�@�餺�^�`�C<br />

      <br />

      <strong>�s�i�p�Y</strong><br />

      �p�G�z�������P���ĳ�A�@�N�b�z�������W�����|������s�i, �еo�l��� <a href="mailto:marketing@usitrip.com">marketing@usitrip.com</a><br />

      <br />

      <strong>�������D/�����]�p: <br />

      </strong>�p�G�z�o�{�ڭ̪�������������D, (�]�A�챵�B�ʪ����Ψ䥦�@�����D), �ХߧY�o�l��� <a href="mailto:webmaster@usitrip.com">webmaster@usitrip.com</a><br />

      <br />

      <strong>��D�p�Y: <br />

      </strong>�p�G�b���|����ʪ��A�O�z���Ҥ���, �z�i�H�H�ɧi�D�ڭ̡C �ڭ̪��v���N�O���U�Ⱥ��N���k�C ���z����D�B��ĳ�M����ڭ̷|���ָѨM�A�ô��ݱz�����X�C�еo�l��� <a href="mailto:'."jiandu@usitrip.com".'" class="pageResults">'."jiandu@usitrip.com".'</a>.<br>

      <br />


       <br>

       <strong>�H��:</strong><br>

       </strong>�ȪA<br>
     '.nl2br(db_to_html(strip_tags(STORE_NAME_ADDRESS))).'

	  </font>');



?>

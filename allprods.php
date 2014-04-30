<?php
/*
  $Id: all_prods.php,v 3.0 2004/02/21 by Ingo (info@gamephisto.de)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce
  Copyright (c) 2002 HMCservices

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  include(DIR_FS_LANGUAGES . $language . '/' . FILENAME_ALLPRODS);


// Set number of columns in listing
define ('NR_COLUMNS', 1);
//
  $breadcrumb->add(HEADING_TITLE, tep_href_link(FILENAME_ALLPRODS, '', 'NONSSL'));
   
  if($cId !=''){
	$linkcroot = array();
	tep_get_parent_categories($linkcroot, $cId);
	$linkcroot = array_reverse($linkcroot);
	//$cRootsize = sizeof($linkcroot);

	foreach($linkcroot as $lkey => $lval)
		{
		$breadcrumb->add(db_to_html(tep_get_category_name($lval)));
		/*
		echo "size".(int)$cRootsize."</br>";
		echo "$lkey => $lval"."</br>";
		 if((int)$cRootsize < sizeof($linkcroot)){
		  $breadcrumb->add(tep_get_category_name($lval), FILENAME_LINKS . '?cRoot=' . $lval);
		 }else{
		 $breadcrumb->add(tep_get_category_name($lval), FILENAME_LINKS . '?lPath=' . $lval);		 
		 }
		 $cRootsize=$cRootsize -1;
		*/
		}
		$breadcrumb->add(db_to_html(tep_get_category_name($cId)));		
	}

	//seo��Ϣ
	$the_title = db_to_html('���о��㵼��-���ķ�������');
	$the_desc = db_to_html('�����������Է���鿴��������ķ����ṩ������������ξ���Ļ���,���������ξ���,���ô����ξ���,ŷ�����ξ�����������ξ���͸������');
	$the_key_words = db_to_html('�������ξ���,ŷ�����ξ���,�������ξ���');
	//seo��Ϣ end

  $content = CONTENT_ALL_PRODS;

  require(DIR_FS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_FS_INCLUDES . 'application_bottom.php');
?>

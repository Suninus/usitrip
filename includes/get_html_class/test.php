<?php
//echo file_get_contents('http://news.sina.com.cn/c/p/2011-09-09/221623134565.shtm');
//exit;
$charset = 'gb2312';
if($_POST['charset']){
	$charset = $_POST['charset'];
}
$t=microtime(true);
ini_set('display_errors', '1'); 
error_reporting(E_ALL & ~E_NOTICE);
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );
header("Content-type: text/html; charset=".$charset);

include('get_html_class.php');

//ץȡ��ҳ������
if($_POST){
	$error = false;
	$errorMsn = "";
	$filesName = trim($_POST['filesName']);
	$fielsCharset = trim($_POST['fielsCharset']);
	$domGetType = $_POST['domGetType'];
	
	$heardSeparatedTag = $_POST['heardSeparatedTag'];
	$footSeparatedTag = $_POST['footSeparatedTag'];
	
	$tagName = trim($_POST['tagName']);
	$attrName = trim($_POST['attrName']);
	$attrValue = trim($_POST['attrValue']);
	$attrValue = trim($_POST['attrValue']);
	$tagRange = trim($_POST['tagRange']);
	
	$titleTag = trim($_POST['titleTag']);
	$titleAttrName = trim($_POST['titleAttrName']);
	$titleAttrValue = trim($_POST['titleAttrValue']);
	$titleTagRange = trim($_POST['titleTagRange']);
	
	
	$filterTagNames = $_POST['filterTagNames'];
	$filterAttrNames = $_POST['filterAttrNames'];
	$filterAttrValues = $_POST['filterAttrValues'];
	
	if($filesName==""){
		$error = true;
		$errorMsn.= "��ҳ��ַ�����<br />";
	}
	if($fielsCharset==""){
		$error = true;
		$errorMsn.= "��ҳ���룺���<br />";
	}
	
	if($tagName==""){
		$error = true;
		$errorMsn.= "�������ı�ǩ�����<br />";
	}
	
	$dateTagName=trim($_POST['dateTagName']);
	$dateAttrName=trim($_POST['dateAttrName']);
	$dateAttrValue=trim($_POST['dateAttrValue']);
	$dateTagRange=trim($_POST['dateTagRange']);
	
	$pageTag=trim($_POST['pageTag']);
	$pageTagAttrName=trim($_POST['pageTagAttrName']);
	$pageTagAttrValue=trim($_POST['pageTagAttrValue']);
	$pageTagRange=trim($_POST['pageTagRange']);
	if($error==false){
		$dom = new GetHtml;
		$dom -> getHmtlAllContent($filesName, $fielsCharset, $charset, $domGetType, $heardSeparatedTag, $footSeparatedTag);
		//����
		if($titleTag!=""){
			$title = $dom->getTags($titleTag,$titleAttrName,$titleAttrValue, $filterTagNames, $filterAttrNames, $filterAttrValues, $titleTagRange);
			echo "<b>���⣺</b>".$title;
			echo "<hr />";
		}
		//����
		if($dateTagName!=""){
			$date = $dom->getTags($dateTagName, $dateAttrName, $dateAttrValue, $filterTagNames, $filterAttrNames, $filterAttrValues, $dateTagRange);
			$dateFormat = $_POST['dateFormat'];
			echo "<b>���ڣ�</b>Դ���ݣ�".$date.'<br />';
			if(strlen($dateFormat)>2){
				
				$dateFormat=str_replace(array('Y','M','D','H','I','S'),'\d',$dateFormat);
				
				$dateText = preg_replace('@.*('.$dateFormat.').*@si','$1',preg_replace('/[[:space:]]+/',' ',strip_tags($date)));
				$dateText1 = str_replace(array('��','��','��'),array('-','-',' '), $dateText);
				
				echo '��ȡ��['.$dateText.']'.'==>��׼���ڣ�'.date('Y-m-d H:i:s',strtotime($dateText1)).'<br />';
			}
			
			echo "<hr />";
		}
		//����
		if($tagName!=""){
			$content = $dom->getTags($tagName, $attrName, $attrValue, $filterTagNames, $filterAttrNames, $filterAttrValues, $tagRange);
			echo $content;
			echo "<hr />";
		}
		//��ҳ����
		if($pageTag!=""){
			$pages = $dom->getTags($pageTag, $pageTagAttrName, $pageTagAttrValue, $filterTagNames, $filterAttrNames, $filterAttrValues, $pageTagRange);
			echo $pages;
			echo "<hr />";
		}
		
		$tt=microtime(true);
		echo "<b>��ʱ��</b>".($tt-$t);
		echo "<hr />";
	}else{
		echo "<div class=error>".$errorMsn."</div>";
		echo "<hr />";
	}
}

//������ַ��������� {
/**
 * ��ʽ������Ϊ�������ݿ���׼��
 *
 * @param unknown_type $string
 * @return unknown
 */
  function tep_db_prepare_input($string) {
    if (is_string($string)) {
      return trim(stripslashes2($string));
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = tep_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }

function stripslashes2($string) {
  
   $string = str_replace("\\\"", "\"", $string);
  
   $string = str_replace("\\'", "'", $string);
  if(eregi("\\\\",$string)){
   $string = str_replace("\\\\", "\\", $string);
   }
   return $string;
}

function tep_output_string($string, $translate = false, $protected = false) {
	if ($protected == true) {
		return tep_htmlspecialchars($string);
	} else {
		if ($translate == false) {
			return tep_parse_input_field_data($string, array('"' => '&quot;'));
		} else {
			return tep_parse_input_field_data($string, $translate);
		}
	}
}

function tep_parse_input_field_data($data, $parse) {
	return strtr(trim($data), $parse);
}

function tep_htmlspecialchars($str){
	//return preg_replace("/&amp;(#[0-9]+|[a-z]+);/i", "&$1;", htmlspecialchars($str));
	return preg_replace("/&amp;/", "&", htmlspecialchars($str,ENT_QUOTES));
}

//������ַ��������� }

foreach((array)$_POST as $key => $val){
	if(is_string($val)){
		$$key = tep_output_string(tep_db_prepare_input($val));
	}
}
?>
<style type="text/css">
<!--
label {
	display: block;
	height:30px;
	clear:both;
}

label span{
	width:175px;
	float:left;
}
label input, select{
	float:left;
}
label i{
	margin-left:5px;
	color:#666;
	font-size:12px;
	font-style: normal;
	float:left;
}
.error {color:#F00; size:24px;}
-->
</style>


<form action="" method="post" enctype="multipart/form-data" name="form" target="_self">
	<label>
		<span>ץȡ��ʽ��</span>
		<?php
		$dom_selected = '';
		$curl_selected = 'selected="selected"';
		if($domGetType=="dom"){
			$dom_selected = 'selected="selected"';
			$curl_selected = '';
		}
		?>
		<select name="domGetType">
			<option value="curl" <?= $curl_selected?> >curl</option>
			<option value="dom" <?= $dom_selected?> >dom</option>
		</select>
		<i>�磺����������dom��QQ������curl</i>
	</label>
	<label>
		<span>��ҳ��ַ��</span><input name="filesName" type="text" id="filesName" size="60" value="<?= $filesName?>" /><i>�磺http://news.sina.com.cn/c/p/2011-09-09/221623134565.shtml</i>
	</label>
	<label>
		<span>��ҳԴ���룺</span><input name="fielsCharset" type="text" id="fielsCharset" size="10" value="<?= $fielsCharset?>" /><i>�磺gb2312</i>
	</label>
	<label>
		<span>Ŀ����룺</span>
		<?php
		if($charset!=""){
			$varName = str_replace('-','_',$charset).'_selected';
			$$varName = 'selected="selected"';
		}
		?>
		<select name="charset">
			<option value="gb2312" <?= $gb2312_selected?> >gb2312</option>
			<option value="big5" <?= $big5_selected?> >big5</option>
			<option value="gbk" <?= $gbk_selected?> >gbk</option>
			<option value="utf-8" <?= $utf_8_selected?> >utf-8</option>
		</select>
		<i>Ŀ����룺��ָ��ʲô�����������big5��gbk��utf-8��gb2312��</i>
	</label>
	<label>
	<span>���ݿ�ʼ�㣺</span><input name="heardSeparatedTag" type="text" id="heardSeparatedTag" size="60" value="<?= $heardSeparatedTag;?>" />
	<i>�磺body&gt;</i>
	</label>
	<label>
	<span>���ݽ����㣺</span><input name="footSeparatedTag" type="text" id="footSeparatedTag" size="60" value="<?= $footSeparatedTag;?>" />
	<i>�磺&lt;/body</i>
	</label>
	<label>
	<strong>����</strong> </label>
	
	<label>
		<span>�����ǩ��</span><input name="titleTag" type="text" id="titleTag" size="10" value="<?= $titleTag?>" /><i>�磺h2</i>
	</label>
	<label>
		<span>�����ǩ���ԣ�</span><input name="titleAttrName" type="text" id="titleAttrName" size="20" value="<?= $titleAttrName?>" /><i>�磺class</i>
	</label>
	<label>
		<span>�����ǩ����ֵ��</span><input name="titleAttrValue" type="text" id="titleAttrValue" size="50" value="<?= $titleAttrValue?>" /><i>�磺className</i>
	</label>
	<label><span>��Χ��</span><input name="titleTagRange" type="text" id="titleTagRange" size="10" value="<?= $titleTagRange?>" /><i>��������ظ��ı�ǩ�����������ָ��ץȡ�ķ�Χ���磺"1,4-6"������ץȡ��1�κ͵�4��5��6�γ��ֵı�ǩ���ݣ������ֵΪ0�����ɼ����С�</i></label>
	<label>
	<strong>ץȡ��������</strong> </label>
	<label>
		<span>�������ڱ�ǩ��</span><input name="dateTagName" type="text" id="dateTagName" size="10" value="<?= $dateTagName?>" /><i>�磺div</i>
	</label>
	<label>
		<span>�������ڱ�ǩ���ԣ�</span><input name="dateAttrName" type="text" id="dateAttrName" size="20" value="<?= $dateAttrName?>" /><i>�磺id</i>
	</label>
	<label>
		<span>�������ڱ�ǩ����ֵ��</span><input name="dateAttrValue" type="text" id="dateAttrValue" size="50" value="<?= $dateAttrValue?>" /><i>�磺idVal</i>
	</label>
	<label><span>��Χ��</span><input name="dateTagRange" type="text" id="dateTagRange" size="10" value="<?= $dateTagRange?>" /><i>��������ظ��ı�ǩ�����������ָ��ץȡ�ķ�Χ���磺"1,4-6"������ץȡ��1�κ͵�4��5��6�γ��ֵı�ǩ���ݣ������ֵΪ0�����ɼ����С�</i></label>
	<label><span>���ڸ�ʽ��</span><input name="dateFormat" type="text" id="dateFormat" size="10" value="<?= $dateFormat?>" /><i>������ڱ�ǩ�����ݹ��࣬����ڴ˶������ڵĸ�ʽ��:YYYY��MM��DD��HH:II:SS</i></label>

	<label>
	<strong>��������</strong> </label>

	<label>
		<span>�������ı�ǩ��</span><input name="tagName" type="text" id="tagName" size="10" value="<?= $tagName?>" /><i>�磺div</i>
	</label>
	<label>
		<span>�������ı�ǩ���ԣ�</span><input name="attrName" type="text" id="attrName" size="20" value="<?= $attrName?>" /><i>�磺id</i>
	</label>
	<label>
		<span>�������ı�ǩ����ֵ��</span><input name="attrValue" type="text" id="attrValue" size="50" value="<?= $attrValue?>" /><i>�磺idVal</i>
	</label>
	<label><span>��Χ��</span><input name="tagRange" type="text" id="tagRange" size="10" value="<?= $tagRange?>" /><i>��������ظ��ı�ǩ�����������ָ��ץȡ�ķ�Χ���磺"1,4-6"������ץȡ��1�κ͵�4��5��6�γ��ֵı�ǩ���ݣ������ֵΪ0�����ɼ����С�</i></label>
	<label>
	<strong>�Ƿ�Ҫ����ץȡ�����һЩ���ݣ�</strong> </label>
	<?php for($i=0; $i<5; $i++){ $n=$i+1;?>
	<label>
		<span>Ҫ���˵ı�ǩ<?=$n?>��</span><input name="filterTagNames[<?=$i?>]" type="text" size="10"  value="<?= $filterTagNames[$i]?>" />
	</label>
	<label>
		<span>Ҫ���˵ı�ǩ����<?=$n?>��</span><input name="filterAttrNames[<?=$i?>]" type="text" size="20"  value="<?= $filterAttrNames[$i]?>" />
	</label>
	<label>
		<span>Ҫ���˵ı�ǩ����ֵ<?=$n?>��</span><input name="filterAttrValues[<?=$i?>]" type="text" size="20"  value="<?= $filterAttrValues[$i]?>" />
	</label>
	<?php
	}
	?>
	
	<label><strong>���з�ҳ��д����ʼ��ǩ�ͽ�����ǩ</strong></label>
	<label><span>��ҳ��ǩ��</span><input name="pageTag" type="text" id="pageTag" size="10" value="<?= $pageTag?>" /></label>
	<label><span>��ҳ��ǩ���ԣ�</span><input name="pageTagAttrName" type="text" id="pageTagAttrName" size="20" value="<?= $pageTagAttrName?>" /></label>
	<label><span>��ҳ��ǩ����ֵ��</span><input name="pageTagAttrValue" type="text" id="pageTagAttrValue" size="20" value="<?= $pageTagAttrValue?>" /></label>
	<label><span>��Χ��</span><input name="pageTagRange" type="text" id="pageTagRange" size="10" value="<?= $pageTagRange?>" /><i>��������ظ��ı�ǩ�����������ָ��ץȡ�ķ�Χ���磺"1,4-6"������ץȡ��1�κ͵�4��5��6�γ��ֵı�ǩ���ݣ������ֵΪ0�����ɼ����С�</i></label>
	<label>
		<span>&nbsp;</span><button type="submit">����ץȡ</button>
	</label>
</form>
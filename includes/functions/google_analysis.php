<?php
define('GOOGLE_OFF_ON','false');

//����ָ���룺������������ҳ��ԭʼ��ʽ����ʼ���������µĳ�ʽ�롣
function google_test_top(){
global $content;
if(GOOGLE_OFF_ON=='true'){
if($content=='index_default'){
$js_code = 
'<script>
function utmx_section(){}function utmx(){}
(function(){var k=\'0543547271\',d=document,l=d.location,c=d.cookie;function f(n){
if(c){var i=c.indexOf(n+\'=\');if(i>-1){var j=c.indexOf(\';\',i);return c.substring(i+n.
length+1,j<0?c.length:j)}}}var x=f(\'__utmx\'),xx=f(\'__utmxx\'),h=l.hash;
d.write(\'<sc\'+\'ript src="\'+
\'http\'+(l.protocol==\'https:\'?\'s://ssl\':\'://www\')+\'.google-analytics.com\'
+\'/siteopt.js?v=1&utmxkey=\'+k+\'&utmx=\'+(x?x:\'\')+\'&utmxx=\'+(xx?xx:\'\')+\'&utmxtime=\'
+new Date().valueOf()+(h?\'&utmxhash=\'+escape(h.substr(1)):\'\')+
\'" type="text/javascript" charset="utf-8"></sc\'+\'ript>\')})();
</script>';
	return $js_code;
}
}
}

//׷��ָ���룺������������ҳ��ԭʼ��ʽ���β���������µĳ�ʽ�롣
function google_test_bottom(){
global $content;
if(GOOGLE_OFF_ON=='true'){
if($content=='index_default'){
	$js_code = 
'<script type="text/javascript">
if(typeof(_gat)!=\'object\')document.write(\'<sc\'+\'ript src="http\'+
(document.location.protocol==\'https:\'?\'s://ssl\':\'://www\')+
\'.google-analytics.com/ga.js"></sc\'+\'ript>\')</script>
<script type="text/javascript">
try {
var pageTracker=_gat._getTracker("UA-1565452-3");
pageTracker._trackPageview("/0543547271/test");
}catch(err){}</script>';
	return $js_code;
}
}
}

//������Ҫ�仯������֮ǰ�����������ݣ�
function google_tags($tag_name='tours'){
	global $content;
	if(GOOGLE_OFF_ON=='true'){
	if($content=='index_default'){
		return '<script>utmx_section("'.$tag_name.'")</script>';
	}
	}
}

//������Ҫ�仯������֮��������������
function google_tags_end($tag_name='tours'){
	global $content;
	if(GOOGLE_OFF_ON=='true'){
	if($content=='index_default'){
	return '</noscript>';
	}
	}
}

?>
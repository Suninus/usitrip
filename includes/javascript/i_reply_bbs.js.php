<?php
$p=array('/&amp;/','/&quot;/');
$r=array('&','"');
$is_js_file = false;	/* ���Ϊfalse����php�ĸ�ʽһ��һ���е�ҳ�� */
if($base_php_self == "javascript.php"){
	$is_js_file = true;
}
if($is_js_file==false){
?>
<script type="text/javascript"><!--
<?php
}
?>

function SubmitReply(obj){
	if(obj.elements['t_c_reply_content'].value==""){
		alert("<?php echo db_to_html('���ݲ���Ϊ�գ�')?>");
		return false;
	}
	var form = obj;
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('ajax_travel_companion_re.php','action=confirm_update')) ?>");
	var aparams=new Array();  /* ����һ�����д������Ԫ�غ�ֵ */
	for(i=0; i<form.length; i++){
		var sparam=encodeURIComponent(form.elements[i].name);  /* ȡ�ñ�Ԫ���� */
		sparam+="=";     /* ����ֵ֮����"="������ */
		
		if(form.elements[i].type=="radio"){	/* ����ѡ��ťֵ */
			var a = a;
			if(form.elements[i].checked){
				a = form.elements[i].value;
			}
			sparam+=encodeURIComponent(a);   /* ��ñ�Ԫ��ֵ */
		}else{
			sparam+=encodeURIComponent(form.elements[i].value);   /* ��ñ�Ԫ��ֵ1 */
		}
		
		aparams.push(sparam);   /* push�ǰ���Ԫ����ӵ�������ȥ */
	}
	var post_str = aparams.join("&");		/* ʹ��&������Ԫ������ */
	post_str += "&ajax=true";


	ajax.open("POST", url, true); 
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
	ajax.send(post_str);

	ajax.onreadystatechange = function() { 
		if (ajax.readyState == 4 && ajax.status == 200 ) { 
/* alert(ajax.responseText); */
			var error_regxp = /(.*\[ERROR\])|(\[\/ERROR\].*[:space:]*.*)/g;
			if(ajax.responseText.search(/(\[ERROR\].+\[\/ERROR\])/g)!=-1){
				alert(ajax.responseText.replace(error_regxp,''));
				if(ajax.responseText.search(/(\[JS\].+\[\/JS\])/g)!=-1){
					
					eval(ajax.responseText.replace(/(.*\[JS\])|(\[\/JS\].*[:space:]*.*)/g, ''));
				}
			}

			var success_regxp = /(.*\[SUCCESS\])|(\[\/SUCCESS\].*[:space:]*.*)/g;
			if(ajax.responseText.search(/(\[SUCCESS\]\d+\[\/SUCCESS\])/g)!=-1){		
				/* alert("<?php echo db_to_html('��Ϣ�ɹ����£�');?>"); */
				/* �������һҳ */
				/* location = ""; */
				var reply_content = document.getElementById("reply_content_"+obj.elements['t_c_reply_id'].value);
				reply_content.innerHTML = nl2br(obj.elements['t_c_reply_content'].value);
				show_edit(obj,reply_content);
			}
			
		}
		
	}
}

function show_edit(obj,obj1){
	if(obj!=null && obj1!=null){
		if(obj.style.display=='none'){
			obj.style.display='';
			obj1.style.display='none';
			
		}else{
			obj.style.display='none';
			obj1.style.display='';
		}
	}
}

/* ת���ո�ֵ */
function nl2br(value) {
	return value.replace(/\n/ig, "<br>");
}

<?php
if($is_js_file==false){
?>
//--></script>
<?php
}
?>
<?php
//ȫ�ֵ�js���룬ȫվ����

$p=array('/&amp;/','/&quot;/');
$r=array('&','"');
$is_js_file = false;	//���Ϊfalse����php�ĸ�ʽһ��һ���е�ҳ��
if($base_php_self == "javascript.php"){
	$is_js_file = true;
}
if($is_js_file==false){
?>
<script type="text/javascript"><!--

<?php
}
?>
//head�·��������棡����
// 2013-06-25 close by lwkai
/*jQuery(document).ready(function($){
	var html = '<div class="temp_notice" style=" position:relative; width:943px; margin:10px auto; padding:5px 10px 7px 30px; border:solid 1px #f46e19; background:url(/image/icons/warning.gif) no-repeat 10px 8px #fffce1;"><?php echo db_to_html('˹̹����ѧ���¹涨6��19���𣬲��ٽ��������Ž�У԰��Ҳ���������δ�ͽ�У԰�����ķ���������������г̽��е������������⡣<span style="  float:right; height:20px; display:inline-block; line-height:20px; text-align:center; cursor:pointer; position:absolute; right:5px; top:3px;">�� �ر�</span>');?></div>';
	var _switch = getCookie('isNotice0620') || 'true';
	if(_switch == 'true'){
		$('#head').append(html);
	}
	$('.temp_notice span').click(function(){
		$('.temp_notice').fadeOut(300);
		setCookie('isNotice0620','false');
	});
});
*/

/* д��ȡ�� cookie {*/
function setCookie(name, value) {
	var argv = setCookie.arguments;
	var argc = setCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	if (expires != null) {
	   var LargeExpDate = new Date ();
	   LargeExpDate.setTime(LargeExpDate.getTime() + (expires*1000*3600*24));
	}
	document.cookie = name + "=" + escape (value)+"; path=/"+((expires == null) ? "" : ("; expires=" +LargeExpDate.toGMTString()));
}
function getCookie(Name) {
	var search = Name + "="
	if (document.cookie.length > 0) {
	   offset = document.cookie.indexOf(search);
	   if(offset != -1) {
		offset += search.length;
		end = document.cookie.indexOf(";", offset);
		if(end == -1) end = document.cookie.length;
		return unescape(document.cookie.substring(offset, end));
	   }else {
		return '';
	   }
	}
}
/* д��ȡ�� cookie }*/

/* ���¶���alert */
function style_alert(msn){
	var General_Notes = document.getElementById("GeneralNotes");
	var General_Notes_Content = document.getElementById("GeneralNotesContent");
	<?php
	$notes_content = "msn";
	$tpl_content = file_get_contents(DIR_FS_CONTENT . 'html_tpl/'.'error_notes.tpl.html');
	$tpl_content = preg_replace('/'.preg_quote('<!--','/').'(.+)'.preg_quote('-->','/').'/','',$tpl_content);
	//$tpl_content = str_replace('{notes_content}',$notes_content,$tpl_content);
	$tpl_content = db_to_html($tpl_content);
	echo 'var tpl_code ="'.preg_replace('/[[:space:]]+/',' ',addslashes($tpl_content)).'"; ';
	echo 'General_Notes_Content.innerHTML = tpl_code.replace("{notes_content}",msn); ';
	?>
	showDiv("GeneralNotes");
	/* this.location.href="http://www.baidu.com/"; */
}
function url_ssl(url){
	var SSL_ = false;
	if(document.location.protocol.toLowerCase()=='https:'){
		SSL_ = true;
	}
	/*
	if(document.URL.search(/^https:\/\//)>-1){
		SSL_ = true;
	}*/
	
	var new_url = url;
	if(SSL_==true){
		new_url = url.replace(/^http:\/\//,"https://");
	}else{
		new_url = url.replace(/^https:\/\//,"http://");
	}
	new_url = new_url.split('?');
	if(new_url[1]==null){
		new_url[1]='';	
	}
	var osCsid = request('osCsid');
	var lang_session = '';
    if(osCsid!=null && osCsid!=''){
       lang_session += (lang_session==''?'':'&')+'osCsid='+osCsid;
    }
    var language = request('language');
    if(language!=null && language!=''){
       lang_session += (lang_session==''?'':'&')+'language='+language;
    }
	new_url = new_url[0]+'?'+lang_session+'&'+new_url[1];
	return new_url;
}

function S_Check_Onfocus(obj){
	if(obj.value=="<?php echo SEARCH_BOX_TIPS1 ?>"){
		obj.value="";
		/* obj.className='input_search2'; */
	}
}
function S_Check_Onblur(obj){
	if(obj.value=="" || obj.value=="<?php echo SEARCH_BOX_TIPS1 ?>"){
		obj.value="<?php echo SEARCH_BOX_TIPS1 ?>";
	}
}
/* /������ͨ���͵� */
function Check_Onfocus(obj){
	if(obj.value==obj.title){
		obj.value="";
		/* obj.className='input_search2'; */
		obj.style.color = "#353535";
	}
}
function Check_Onblur(obj){
	if(obj.value==""){
		obj.value=obj.title;
		obj.style.color = "#BBBBBB";
	}
}

/* ���´�����ʾ��ҳ replace window.open */
function win_open(Url){
	if(document.all){
		var newA = document.createElement("a");
		newA.id ='links_windows_open';
		newA.target = '_blank';
		newA.href = Url;
	
		document.body.appendChild(newA);
		newA.click();
		document.body.removeChild(newA);
	}else{
		window.open(Url,'','');	
	}
}

/* ����XMLHttp���� start */
var XMLHttp = {
    _objPool: [],
   
    _getInstance: function ()
    {
        for (var i = 0; i < this._objPool.length; i ++)
        {
            if (this._objPool[i].readyState == 0 || this._objPool[i].readyState == 4)
            {
                return this._objPool[i];
            }
        }
   
        /*  IE5�в�֧��push���� */
        this._objPool[this._objPool.length] = this._createObj();
   
        return this._objPool[this._objPool.length - 1];
    },
   
    _createObj: function ()
    {
        if (window.XMLHttpRequest)
        {
            var objXMLHttp = new XMLHttpRequest();
   
        }
        else
        {
            var MSXML = ['MSXML2.XMLHTTP.5.0', 'MSXML2.XMLHTTP.4.0',
                  'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP', 'Microsoft.XMLHTTP'];
            for(var n = 0; n < MSXML.length; n ++)
            {
                try
                {
                    var objXMLHttp = new ActiveXObject(MSXML[n]);
                    break;
                }
                catch(e)
                {
                }
            }
         }         
   
        /*  mozillaĳЩ�汾û��readyState���� */
        if (objXMLHttp.readyState == null)
        {
            objXMLHttp.readyState = 0;
   
            objXMLHttp.addEventListener("load", function ()
                {
                    objXMLHttp.readyState = 4;
   
                    if (typeof objXMLHttp.onreadystatechange == "function")
                    {
                        objXMLHttp.onreadystatechange();
                    }
                },  false);
        }
   
        return objXMLHttp;
    },
   
    /*  ��������(����[post,get], ��ַ, ����, �ص�����) */
    sendReq: function (method, url, data, callback)
    {
        var objXMLHttp = this._getInstance();
   
        with(objXMLHttp)
        {
            try
            {
                /*  ���������ֹ���� */
                if (url.indexOf("?") > 0)
                {
                    url += "&randnumforajaxaction=" + Math.random();
                }
                else
                {
                    url += "?randnumforajaxaction=" + Math.random();
                }
   
                open(method, url, true);
   
                /*  �趨������뷽ʽ */
                setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                send(data);
                onreadystatechange = function ()
                {
                    if (objXMLHttp.readyState == 4 && (objXMLHttp.status == 200 || objXMLHttp.status == 304))
                    {
                        callback(objXMLHttp);
                    }
                }
            }
            catch(e)
            {
                alert(e);
            }
        }
    }
};
/* ����XMLHttp���� end */

/* ����ajax���� */
var ajax = false;
if(window.XMLHttpRequest) {
	 ajax = new XMLHttpRequest();
}
else if (window.ActiveXObject) {
	try {
			ajax = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
	try {
			ajax = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {}
	}
}
if (!ajax) {
	window.alert("<?php echo db_to_html('���ܴ���XMLHttpRequest����ʵ��.')?>");
}
/* ajax �ύGET���� */
function ajax_get_submit(url,success_msm,success_go_to,replace_id){
	var url = url;
	XMLHttp.sendReq('GET', url, null, ajax_get_return_data);
	/*ajax.open("GET", url, true);
	ajax.send(null); 
	ajax.onreadystatechange = function() { 
		if (ajax.readyState == 4 && ajax.status == 200 ) { 
			var error_regxp = /(.*\[ERROR\])|(\[\/ERROR\].*[:space:]*.*)/g;
			var success_regxp = /(.*\[SUCCESS\])|(\[\/SUCCESS\].*[:space:]*.*)/g;
			if(ajax.responseText.search(/(\[ERROR\].+\[\/ERROR\])/g)!=-1){
				alert(ajax.responseText.replace(error_regxp,''));
			}else if(ajax.responseText.search(/(\[JS\].+\[\/JS\])/g)!=-1){
				eval(ajax.responseText.replace(/(.*\[JS\])|(\[\/JS\].*[:space:]*.*)/g, ''));
			}else if(ajax.responseText.search(/(\[SUCCESS\]\d+\[\/SUCCESS\])/g)!=-1){		
				if(success_msm!=""){
					alert(success_msm);
				}
				if(success_go_to!=""){
					location = success_go_to;
				}
			}else if(typeof(replace_id)!="undefined"){
				var Replace_ID = document.getElementById(replace_id);
				if(Replace_ID!=null){
					Replace_ID.innerHTML = ajax.responseText;
				}
			}
		}
	}*/
}


function ajax_get_return_data(obj){
	var error_regxp = /(.*\[ERROR\])|(\[\/ERROR\].*[:space:]*.*)/g;
	var success_regxp = /(.*\[SUCCESS\])|(\[\/SUCCESS\].*[:space:]*.*)/g;
	if(obj.responseText.search(/(\[ERROR\].+\[\/ERROR\])/g)!=-1){
		alert(obj.responseText.replace(error_regxp,''));
	}else if(obj.responseText.search(/(\[JS\].+\[\/JS\])/g)!=-1){
		eval(obj.responseText.replace(/(.*\[JS\])|(\[\/JS\].*[:space:]*.*)/g, ''));
	}else if(obj.responseText.search(/(\[SUCCESS\]\d+\[\/SUCCESS\])/g)!=-1){		
		if(success_msm!=""){
			alert(success_msm);
		}else{
			alert("<?php echo db_to_html("���β����ɹ���");?>");
		}
		if(success_go_to!=""){
			location = success_go_to;
		}
	}/*else if(typeof(replace_id)!="undefined"){
		var Replace_ID = document.getElementById(replace_id);
		if(Replace_ID!=null){
			Replace_ID.innerHTML = obj.responseText;
		}
	}else{
		alert(obj.responseText);
	}*/
	
}
//��������ajax�ύ
function ajax_submit(form_id,success_msm,success_go_to, replace_id){
	var formobj = jQuery("#"+form_id);
	var url = formobj.attr('action');
	var method = formobj.attr('method');
	if(typeof(url) == 'undefined') {
		alert(form_id+" form action not setup.");
		return ;
	}
	method = typeof(method) == 'undefined'? 'post':method;
	method = method.toLowerCase();
	if(method == 'get'){
		ajax_get_submit(url,success_msm,success_go_to,replace_id);
	}else{
		ajax_post_submit(url,form_id,success_msm,success_go_to, replace_id)
	}
}
/* ajax �ύPOST���� */
function ajax_post_submit(url,form_id,success_msm,success_go_to, replace_id){
	var form = document.getElementById(form_id);
	var aparams=new Array();  /* ����һ�����д������Ԫ�غ�ֵ */

	for(i=0; i<form.length; i++){
		if(form.elements[i].type=="radio" || form.elements[i].type=="checkbox" ){	/* ����ѡ����ѡ��ťֵ */
			var a = '';
			if(form.elements[i].checked == true){
				var sparam=encodeURIComponent(form.elements[i].name);  /* ȡ�ñ�Ԫ���� */
				sparam+="=";     /* ����ֵ֮����"="������ */
				a = form.elements[i].value;
				sparam+=encodeURIComponent(a);   /* ��ñ�Ԫ��ֵ */
				aparams.push(sparam);   /* push�ǰ���Ԫ����ӵ�������ȥ */
			}
		}else{
			var sparam=encodeURIComponent(form.elements[i].name);  /* ȡ�ñ�Ԫ���� */
			sparam+="=";     /* ����ֵ֮����"="������ */
			sparam+=encodeURIComponent(form.elements[i].value);   /* ��ñ�Ԫ��ֵ1 */
			aparams.push(sparam);   /* push�ǰ���Ԫ����ӵ�������ȥ */
		}
	}
	var post_str = aparams.join("&");		/* ʹ��&������Ԫ������ */
	post_str += "&ajax=true";

	/*  ���������ֹ���� */
	if (url.indexOf("?") > 0)
	{
		url += "&randnumforajaxaction=" + Math.random();
	}
	else
	{
		url += "?randnumforajaxaction=" + Math.random();
	}
	ajax.open("POST", url, true); 
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
	ajax.send(post_str);

	ajax.onreadystatechange = function() { 
		if (ajax.readyState == 4 && ajax.status == 200 ) { 
/* alert(ajax.responseText); */
			var error_regxp = /(.*\[ERROR\])|(\[\/ERROR\].*[:space:]*.*)/g;
			var success_regxp = /(.*\[SUCCESS\])|(\[\/SUCCESS\].*[:space:]*.*)/g;
			if(ajax.responseText.search(/(\[ERROR\].+\[\/ERROR\])/g)!=-1){
				alert(ajax.responseText.replace(error_regxp,''));
			}else if(ajax.responseText.search(/(\[JS\].+\[\/JS\])/g)!=-1){
				eval(ajax.responseText.replace(/(.*\[JS\])|(\[\/JS\].*[:space:]*.*)/g, ''));
			}else if(ajax.responseText.search(/(\[SUCCESS\]\d+\[\/SUCCESS\])/g)!=-1){		
				if(success_msm!=""){
					alert(success_msm);
				}
				if(success_go_to!=""){
					location = success_go_to;
				}
			}else if(typeof(replace_id)!="undefined"){
				var Replace_ID = document.getElementById(replace_id);
				if(Replace_ID!=null){
					Replace_ID.innerHTML = ajax.responseText;
				}
			}
			
		}
		
	}

}

/* �ռ���������Ϣ */
function get_form_data(form_id, type ){
		var form = document.getElementById(form_id);
		var aparams = new Array();															/* ����һ�����д������Ԫ�غ�ֵ */
		var eval_string = new Array();														
		for(var i=0; i<form.elements.length; i++){
			var name = encodeURIComponent(form.elements[i].name); 							/* ȡ�ñ�Ԫ���� */
			var value = '';
			if(form.elements[i].type=="radio" || form.elements[i].type=="checkbox" ){		/* ����ѡ����ѡ��ťֵ */
				var a = '';
				if(form.elements[i].checked == true){
					a = form.elements[i].value;
					value = encodeURIComponent(a);   									/* ��ñ�Ԫ��ֵ */
				}else{
					name ='';
				}
			}else{
				value = encodeURIComponent(form.elements[i].value);   					/* ��ñ�Ԫ��ֵ1 */
			}
			
			if(name!=""){
				var _l = aparams.length;
				aparams[_l] = new Array();
				aparams[_l][name] = value;
				eval_string[eval_string.length] = name + '='+value;
			}
		}
		if(type == "array"){
			return aparams;
		}
		var string = eval_string.join('&');
		string += "&ajax=true";
		
		return string;
}


/* �ж�������ַ���,input_ojbΪ��������max_string_numΪ�����������ַ�����sms_info_id��ʾ�������ַ�����Ϣ�� */
function check_input_string_num(input_ojb, max_string_num, sms_info_id){
	var can_input_num = max_string_num;
	can_input_num = can_input_num - input_ojb.value.length;
	if(can_input_num<=0){
		input_ojb.value = input_ojb.value.substr(0,max_string_num); 
		can_input_num = 0;
	}
	var sms = "<?php echo db_to_html('�㻹��������<span>"+ can_input_num +"</span>��');?>";
	var sms_info_obj = document.getElementById(sms_info_id);
	if(sms_info_obj!=null){
		sms_info_obj.innerHTML = sms;
	}else{
		alert(sms);
	}
}


/* ���䷽ʽ�򿪺͹رղ� start */
var prox;
var proy;
var proxc;
var proyc;
function open_layer(id){/*--��--*/
	clearInterval(prox);
	clearInterval(proy);
	clearInterval(proxc);
	clearInterval(proyc);
	var o = document.getElementById(id);
	o.style.display = "block";
	o.style.width = "1px";
	o.style.height = "1px"; 
	prox = setInterval(function(){openx(o,500)},10);
}	
function openx(o,x){/*--��x--*/
	var cx = parseInt(o.style.width);
	if(cx < x)
	{
		o.style.width = (cx +  Math.ceil((x-cx)/5)) + "px";
	}
	else
	{
		clearInterval(prox);
		proy = setInterval(function(){openy(o,200)},10);
	}
}	
function openy(o,y){/*--��y--*/	
	var cy = parseInt(o.style.height);
	if(cy < y)
	{
		o.style.height = (cy  + Math.ceil((y-cy)/5)) + "px";
	}
	else
	{
		clearInterval(proy);			
	}
}	
function close_layer(id){/*--�ر�--*/
	clearInterval(prox);
	clearInterval(proy);
	clearInterval(proxc);
	clearInterval(proyc);		
	var o = document.getElementById(id);
	if(o.style.display == "block")
	{
		proyc = setInterval(function(){closey(o)},10);			
	}		
}	
function closey(o){/*--��y--*/	
	var cy = parseInt(o.style.height);
	if(cy > 0)
	{
		o.style.height = (cy - Math.ceil(cy/5)) + "px";
	}
	else
	{
		clearInterval(proyc);				
		proxc = setInterval(function(){closex(o)},10);
	}
}	
function closex(o){/*--��x--*/
	var cx = parseInt(o.style.width);
	if(cx > 0)
	{
		o.style.width = (cx - Math.ceil(cx/5)) + "px";
	}
	else
	{
		clearInterval(proxc);
		o.style.display = "none";
	}
}	
	
/* ���䷽ʽ�򿪺͹رղ� end */

/* /��ʾn���رյ�ǰ��򵽴���ҳ��start  */
function OutTimeGoto(url,time_num){
	var numSpan=document.getElementById("out_time_number");
	var i=time_num;
	var interval=window.setInterval(
		function(){
				if(i>=1){
					numSpan.innerHTML=i=i-1
				}else{
					if(typeof(url)!='undefined' && url!=""){
						window.clearInterval(interval,goIndex(url));
					}
				}
		}, 
	1000);
}
function goIndex(url){
	/* ���뵽��ҳ�� */
	if(typeof(url)!='undefined' && url!=""){
		this.location.href=url;
	}
	/* �رյ�ǰҳ�� */
	/* parent.window.close(); */

}
function write_success_notes(out_time, notes_contes, gotourl){	/* ��Ϣ���ɹ��������ʾ����Ϣ����ҳ�� */
	var Notes = document.getElementById("OutTimeNotes");
	if(Notes==null){ alert("No OutTimeNotes");}
	var Content = document.getElementById("OutTimeNotesContent");
	if(Content==null){ alert("No OutTimeNotesContent");}
	Content.innerHTML = notes_contes;
	var pointer = "1"; 
	showDiv(Notes.id, pointer);
	OutTimeGoto(gotourl,out_time);
	if(typeof(gotourl)!='undefined' && gotourl!=""){
	}else{
		var out_num = out_time*1000;
		window.setTimeout('closeDiv("'+Notes.id+'")',out_num);
	}
}
/* /��ʾn���رյ�ǰ��򵽴���ҳ�� end */



<?php
/* �����������ڴ���̫����ֻ���ض���ҳ����ʾ */
if($Show_Calendar_JS=="true"){
?>
/* Start - Javascript string pad */
var STR_PAD_LEFT = 1;
var STR_PAD_RIGHT = 2;
var STR_PAD_BOTH = 3;
function str_pad(str, len, pad, dir) {
	if (typeof(len) == "undefined") { var len = 0; }
	if (typeof(pad) == "undefined") { var pad = ' '; }
	if (typeof(dir) == "undefined") { var dir = STR_PAD_RIGHT; }
	str=str.toString();

	if (len + 1 >= str.length) {
		switch (dir){
			case STR_PAD_LEFT:
				str = Array(len + 1 - str.length).join(pad) + str;
			break;
			case STR_PAD_BOTH:
				var right = Math.ceil((padlen = len - str.length) / 2);
				var left = padlen - right;
				str = Array(left+1).join(pad) + str + Array(right+1).join(pad);
			break;
			default:
				str = str + Array(len + 1 - str.length).join(pad);
			break;
		} /*  switch */
	}
	return str;
}
/* End - Javascript string pad */

/*��ͨ����start*/
function G_calendar(){}
G_calendar.prototype={
    Unlimited: false,	/* ����ȡ�����ƣ����Ϊtrue���������ھ���ʹ�� */
	HelpMsg:"<?php echo db_to_html('1.������ѡ�����;<br>2.����¿�ѡ���·�;<br>3.���&gt;��&lt;�ɸı��·�;<br>4.�����ײ������Ƕ����ڵ�˵��');?>",/* ��������Ӻ��޸İ����ĵ������� */

    DayInfo:new Array(),
    Moveable:false,
    NewName:"",
    insertId:"",
    ClickObject:null,
    InputObject:null,
    InputDate:null,
    IsOpen:false,
    MouseX:0,
    MouseY:0,
    GetDateLayer:function(){
        return window.G_DateLayer;
    },
    L_TheYear:new Date().getFullYear(), /* ������ı����ĳ�ʼֵ */
    L_TheMonth:new Date().getMonth()+1,/* �����µı����ĳ�ʼֵ */
    L_WDay:new Array(39),/* ����д���ڵ����� */
    MonHead:new Array(31,28,31,30,31,30,31,31,30,31,30,31),/* ����������ÿ���µ�������� */
    GetY:function(){
        var obj;
        if (arguments.length > 0){
            obj==arguments[0];
        }
        else{
            obj=this.ClickObject;
        }
        if(obj!=null){
            var y = obj.offsetTop;
            while (obj = obj.offsetParent) y += obj.offsetTop;
            return y;
        }
        else{return 0;}
    },
    GetX:function(){
        var obj;
        if (arguments.length > 0){
            obj==arguments[0];
        }
        else{
            obj=this.ClickObject;
        }
        if(obj!=null){
            var y = obj.offsetLeft;
            while (obj = obj.offsetParent) y += obj.offsetLeft;
            return y;
        }
        else{return 0;}
    },
    CreateHTML:function(){
        var htmlstr="";
        htmlstr+="<div id=\"G_calendar\">\r\n";
        htmlstr+="<span id=\"SelectYearLayer\" style=\"z-index: 9999;position: absolute;top: 3; left: 45;display: none\"></span>\r\n";
        htmlstr+="<span id=\"SelectMonthLayer\" style=\"z-index: 9999;position: absolute;top: 3; left: 105;display: none\"></span>\r\n";
        htmlstr+="<div id=\"G_calendar-year-month\">\r\n";
        htmlstr+="<div id=\"G_calendar-PrevM\" onclick=\"parent."+this.NewName+".PrevM()\" title=\"<?php echo db_to_html('ǰһ��')?>\"><b>&lt;</b><span id=\"G_calendar-PrevM-text\"></span></div>\r\n";
        htmlstr+="<div id=\"G_calendar-year\" onmouseover=\"style.backgroundColor='#ffeadd'\" onmouseout=\"style.backgroundColor='white'\" onclick=\"parent."+this.NewName+".SelectYearInnerHTML()\"></div>\r\n";
        htmlstr+="<div id=\"G_calendar-month\"  onmouseover=\"style.backgroundColor='#ffeadd'\" onmouseout=\"style.backgroundColor='white'\" onclick=\"parent."+this.NewName+".SelectMonthInnerHTML()\"></div>\r\n";
        htmlstr+="<div id=\"G_calendar-NextM\" onclick=\"parent."+this.NewName+".NextM()\" title=\"<?php echo db_to_html('��һ��')?>\"><span id=\"G_calendar-NextM-text\"></span><b>&gt;</b></div>\r\n";
        htmlstr+="</div>\r\n";
        htmlstr+="<div id=\"G_calendar-week\"><ul  onmouseup=\"StopMove()\"><li><b><?php echo db_to_html('��')?></b></li><li><?php echo db_to_html('һ')?></li><li><?php echo db_to_html('��')?></li><li><?php echo db_to_html('��')?></li><li><?php echo db_to_html('��')?></li><li><?php echo db_to_html('��')?></li><li><b><?php echo db_to_html('��')?></b></li></ul></div>\r\n";
        htmlstr+="<div id=\"G_calendar-day\">\r\n";
        htmlstr+="<ul>\r\n";
        for(var i=0;i<this.L_WDay.length;i++){
            htmlstr+="<li id=\"G_calendar-day_"+i+"\" style=\"background:#fff;border:1px solid #6bc4f3\" ></li>";
        }
        htmlstr+="</ul>\r\n";
        htmlstr+="</div>\r\n";
        htmlstr+="<div>\r\n";
        htmlstr+="<div id=\"G_calendar-help\" onclick='sAlert(\""+this.HelpMsg+"\")'><span><?php echo db_to_html('����')?></span></div>\r\n";
        htmlstr+="<div id=\"G_calendar-show-week\"><span>"+this.GetDOWToday()+"</span></div>\r\n";
        htmlstr+="<div id=\"G_calendar-show-info\"><span></span><b id=\"G_calendar-show-price\"></b></div>\r\n";
        htmlstr+="<div id=\"G_calendar-close\" onclick='parent."+this.NewName+".OnClose()'><span><?php echo db_to_html('�ر�')?></span></div>\r\n";
        htmlstr+="</div>\r\n";
        htmlstr+="</div>\r\n";
        htmlstr+="<scr" + "ipt type=\"text/javas" + "cript\">\r\n";
        htmlstr+="var MouseX,MouseY;";
        htmlstr+="var Moveable="+this.Moveable+";\r\n";
        htmlstr+="var MoveaStart=false;\r\n";
        htmlstr+="document.onmousemove=function(e)\r\n";
        htmlstr+="{\r\n";
        htmlstr+="var DateLayer=parent.document.getElementById(\"G_DateLayer\");\r\n";
        htmlstr+="	e = window.event || e;\r\n";
        htmlstr+="var DateLayerLeft=DateLayer.style.posLeft || parseInt(DateLayer.style.left.replace(\"px\",\"\"));\r\n";
        htmlstr+="var DateLayerTop=DateLayer.style.posTop || parseInt(DateLayer.style.top.replace(\"px\",\"\"));\r\n";
        htmlstr+="if(MoveaStart){DateLayer.style.left=(DateLayerLeft+e.clientX-MouseX)+\"px\";DateLayer.style.top=(DateLayerTop+e.clientY-MouseY)+\"px\"};\r\n";
        htmlstr+="}\r\n";

        htmlstr+="document.getElementById(\"G_calendar-week\").onmousedown=function(e){\r\n";
        htmlstr+="if(Moveable){MoveaStart=true;}\r\n";
        htmlstr+="	e = window.event || e;\r\n";
        htmlstr+="  MouseX = e.clientX;\r\n";
        htmlstr+="  MouseY = e.clientY;\r\n";
        htmlstr+="	}\r\n";
        htmlstr+="function StopMove(){\r\n";
        htmlstr+="MoveaStart=false;\r\n";
        htmlstr+="	}\r\n";
        htmlstr+="function sAlert(str){\r\n";
        htmlstr+="var msgw,msgh,bordercolor;\r\n";
        htmlstr+="msgw=200;\r\n";
        htmlstr+="msgh=180;\r\n";
        htmlstr+="titleheight=25;\r\n";
        htmlstr+="bordercolor=\"#336699\";\r\n";
        htmlstr+="titlecolor=\"#99CCFF\";\r\n";
        htmlstr+="var msgObj=document.createElement(\"div\");\r\n";
        htmlstr+="msgObj.setAttribute(\"id\",\"msgDiv\"); \r\n";
        htmlstr+="msgObj.setAttribute(\"align\",\"center\"); \r\n";
        htmlstr+="msgObj.style.background=\"white\"; \r\n";
        htmlstr+="msgObj.style.border=\"1px solid \" + bordercolor; \r\n";
        htmlstr+="msgObj.style.position = \"absolute\";\r\n";
        htmlstr+="var parentObj=document.getElementById(\"G_calendar-help\");\r\n";
        htmlstr+="msgObj.style.left = parentObj.offsetLeft; \r\n";
        htmlstr+="msgObj.style.top = parentObj.offsetTop-msgh+14; \r\n";
        htmlstr+="msgObj.style.font=\"12px/1.6em Verdana, Geneva, Arial, Helvetica, sans-serif\";\r\n";
        htmlstr+="msgObj.style.width = msgw + \"px\"; \r\n";
        htmlstr+="msgObj.style.height =msgh + \"px\"; \r\n";
        htmlstr+="msgObj.style.textAlign = \"left\"; \r\n";
        htmlstr+="msgObj.style.lineHeight =\"22px\"; \r\n";
        htmlstr+="msgObj.style.zIndex = \"10001\"; \r\n";
        htmlstr+="var title=document.createElement(\"h4\"); \r\n";
        htmlstr+="title.setAttribute(\"id\",\"msgTitle\"); \r\n";
        htmlstr+="title.setAttribute(\"align\",\"right\"); \r\n";
        htmlstr+="title.style.margin=\"0\"; \r\n";
        htmlstr+="title.style.padding=\"3px\"; \r\n";
        htmlstr+="title.style.background=bordercolor;\r\n";
        htmlstr+="title.style.border=\"1px solid \" + bordercolor; \r\n";
        htmlstr+="title.style.height=\"18px\";\r\n";
        htmlstr+="title.style.font=\"12px Verdana, Geneva, Arial, Helvetica, sans-serif\";\r\n";
        htmlstr+="title.style.color=\"white\";\r\n";
        htmlstr+="title.style.cursor=\"pointer\";\r\n";
        htmlstr+="title.innerHTML=\"<?php echo db_to_html('�ر�')?>\";\r\n";
        htmlstr+="title.onclick=function(){\r\n";
        htmlstr+="document.getElementById(\"msgDiv\").removeChild(title);\r\n";
        htmlstr+="document.body.removeChild(msgObj);\r\n";
        htmlstr+="}\r\n";
        htmlstr+="document.body.appendChild(msgObj);\r\n";
        htmlstr+="document.getElementById(\"msgDiv\").appendChild(title);\r\n";
        htmlstr+="var txt=document.createElement(\"p\"); \r\n";
        htmlstr+="txt.style.margin=\"1em 0\";\r\n";
        htmlstr+="txt.setAttribute(\"id\",\"msgTxt\");\r\n";
        htmlstr+="txt.innerHTML=str;\r\n";
        htmlstr+="document.getElementById(\"msgDiv\").appendChild(txt);\r\n";
        htmlstr+="}\r\n";
        htmlstr+="</scr"+"ipt>\r\n";
        var stylestr="";
        stylestr+="<style type=\"text/css\">";
        stylestr+="body{background:#fff;font-size:12px;margin:0px;padding:0px;text-align:left;position:relative;}\r\n";
        stylestr+="#G_calendar{border:1px solid #6bc4f3;width:205px;padding:1px;height:245px;z-index:9998;text-align:center;}\r\n";
        stylestr+="#G_calendar-year-month{height:23px;line-height:23px;z-index:9998;border-bottom:1px solid #6bc4f3;}\r\n";
        stylestr+="#G_calendar-year{line-height:20px;width:60px;float:left;z-index:9998;position: absolute;top: 3; left: 45;cursor:default;font-weight:bold;text-align:right;}\r\n";
        stylestr+="#G_calendar-month{line-height:20px;width:45px;float:left;z-index:9998;position: absolute;top: 3; left: 105;cursor:default;font-weight:bold;text-align:left;}\r\n";
        stylestr+="#G_calendar-PrevM{position: absolute;top: 3px; left: 5px;cursor:pointer;color:#f7860f;}\r\n";
        stylestr+="#G_calendar-PrevM-text{margin-left:3px;color:#108bcd;}\r\n";
        stylestr+="#G_calendar-NextM{position: absolute;top: 3px; left:160px;cursor:pointer;color:#f7860f;width:40px;text-align:right;}\r\n";
        stylestr+="#G_calendar-week{height:23px;line-height:23px;z-index:9998;}\r\n";
        stylestr+="#G_calendar-NextM-text{color:#108bcd;}\r\n";
        stylestr+="#G_calendar-day{height:175px;;z-index:9998;}\r\n";
        stylestr+="#G_calendar-week{background:#edf8fe;}\r\n";
        stylestr+="#G_calendar-week ul{cursor:move;list-style:none;margin:0px;padding:0px;margin-left:5px;}\r\n";
        stylestr+="#G_calendar-week li{width:24px !important;width:23px;height:24px !important;height:23px;line-height:23px;float:left;margin:2px;padding:0px;text-align:center;}\r\n";
        stylestr+="#G_calendar-day{background:#edf8fe;border-bottom:1px solid #d5d5d5}\r\n";
        stylestr+="#G_calendar-day ul{list-style:none;margin:0px;padding:0px;margin-left:5px;}\r\n";
        stylestr+="#G_calendar-day li{cursor:pointer;width:22px !important;width:23px;height:22px !important;height:23px;line-height:23px;float:left;;margin:2px;padding:0px;border:1px solid #6bc4f3;}\r\n";
        stylestr+="#G_calendar-help{color:#108bcd;float:left;width:30px;margin-top:8px;cursor:pointer;}\r\n";
        stylestr+="#G_calendar-show-week{float:left;width:60px;margin-top:8px;text-align:right;}\r\n";
        stylestr+="#G_calendar-show-info{float:left;width:85px;*width:80px;margin-top:8px;}\r\n";
        stylestr+="#G_calendar-show-price{color:f7860f;}\r\n";
        stylestr+="#G_calendar-close{color:#108bcd;float:left;width:30px;margin-top:8px;cursor:pointer;}\r\n";
        stylestr+="</style>";
        var TempLateContent="<html>\r\n";
        TempLateContent+="<head>\r\n";
        TempLateContent+="<title></title>\r\n";
        TempLateContent+=stylestr;
        TempLateContent+="</head>\r\n";
        TempLateContent+="<body>\r\n";
        TempLateContent+=htmlstr;
        TempLateContent+="</body>\r\n";
        TempLateContent+="</html>\r\n";
        this.GetDateLayer().document.writeln(TempLateContent);
        this.GetDateLayer().document.close();
    },
    InsertHTML:function(id,htmlstr){
        var G_DateLayer=this.GetDateLayer();
        if(G_DateLayer){G_DateLayer.document.getElementById(id).innerHTML=htmlstr;}
    },
    WriteHead:function (yy,mm)  /* �� head ��д�뵱ǰ�������� */
    {
        this.InsertHTML("G_calendar-year",yy + "<?php echo db_to_html('��')?>");
        this.InsertHTML("G_calendar-month",mm + "<?php echo db_to_html('��')?>");

        mm=Number(mm);
        var prevM=mm==1?12:mm-1;
        var nextM=mm==12?1:mm+1;

        this.InsertHTML("G_calendar-PrevM-text",prevM + "<?php echo db_to_html('��')?>");
        this.InsertHTML("G_calendar-NextM-text",nextM + "<?php echo db_to_html('��')?>");
    },
    IsPinYear:function(year)            /* �ж��Ƿ���ƽ�� */
    {
        if (0==year%4&&((year%100!=0)||(year%400==0))) return true;else return false;
    },
    GetMonthCount:function(year,month)  /* �������Ϊ29�� */
    {
        var c=this.MonHead[month-1];if((month==2)&&this.IsPinYear(year)) c++;return c;
    },
    GetDOW:function(day,month,year)     /* ��ĳ������ڼ� */
    {
        var day = new Date(year,month-1,day); /* ������ֵ��ʽ�� */
        var today = new Array("<?php echo db_to_html('����')?>","<?php echo db_to_html('��һ')?>","<?php echo db_to_html('�ܶ�')?>","<?php echo db_to_html('����')?>","<?php echo db_to_html('����')?>","<?php echo db_to_html('����')?>","<?php echo db_to_html('����')?>");
        return today[day.getDay()];
    },
    GetDOWToday:function()     /* ��ĳ������ڼ� */
    {
        var day = new Date(new Date().getFullYear(),new Date().getMonth(),new Date().getDate()); /* ������ֵ��ʽ�� */
        var today = new Array("<?php echo db_to_html('����')?>","<?php echo db_to_html('��һ')?>","<?php echo db_to_html('�ܶ�')?>","<?php echo db_to_html('����')?>","<?php echo db_to_html('����')?>","<?php echo db_to_html('����')?>","<?php echo db_to_html('����')?>");
        return today[day.getDay()];
    },
    GetDateDiff:function (sDate1, sDate2)
    {/*  �����������ڵļ������ */
        /* sDate1��sDate2��2002-12-18��ʽ */
        var aDate, oDate1, oDate2, iDays;

        aDate = sDate1.split("-");
        oDate1 = new Date(aDate[0],aDate[1]-1,aDate[2],01,00,00);
        aDate = sDate2.split("-");
        oDate2 = new Date(aDate[0],aDate[1]-1,aDate[2],00,00,00);

        iDays = parseInt((oDate1 - oDate2) / 1000 / 60 / 60 /24); /* �����ĺ�����ת��Ϊ���� */
        return iDays;
    },
    GetText:function(obj){
        if(obj.innerText){return obj.innerText}
        else{return obj.textContent}
    },
    PrevM:function()  /* ��ǰ���·� */
    {
        if(this.L_TheMonth>1){this.L_TheMonth--}else{this.L_TheYear--;this.L_TheMonth=12;}
        this.SetDay(this.L_TheYear,this.L_TheMonth);
    },
    NextM:function()  /* �����·� */
    {
        if(this.L_TheMonth==12){this.L_TheYear++;this.L_TheMonth=1}else{this.L_TheMonth++}
        this.SetDay(this.L_TheYear,this.L_TheMonth);
    },
    SetDay:function (yy,mm)   /* ��Ҫ��д����********** */
    {
		var arr_soldout_dates=Array();
        var infoCount=this.DayInfo.length;
        this.WriteHead(yy,mm);
        /* ���õ�ǰ���µĹ�������Ϊ����ֵ */
        this.L_TheYear=yy;
        this.L_TheMonth=mm;
        /* ��ҳ�汾��λ�ڿ����ʱ IE�᷵�ش����parent */
        if(window.top.location.href!=window.location.href){
            for(var i_f=0;i_f<window.top.frames.length;i_f++){
                    if(window.top.frames[i_f].location.href==window.location.href){G_DateLayer_Parent=window.top.frames[i_f];}
            }
        }
        else{
            G_DateLayer_Parent=window.parent;
        }
        for (var i = 0; i < 39; i++){this.L_WDay[i]=""}  /* ����ʾ�������ȫ����� */
        var day1 = 1,day2=1,firstday = new Date(yy,mm-1,1).getDay();  /* ĳ�µ�һ������ڼ� */
        for (i=0;i<firstday;i++)this.L_WDay[i]=this.GetMonthCount(mm==1?yy-1:yy,mm==1?12:mm-1)-firstday+i+1;	/* �ϸ��µ������ */
        for (i = firstday; day1 < this.GetMonthCount(yy,mm)+1; i++){this.L_WDay[i]=day1;day1++;}
        for (i=firstday+this.GetMonthCount(yy,mm);i<39;i++){this.L_WDay[i]=day2;day2++}
        for (i = 0; i < 39; i++)
        {
            var da=this.GetDateLayer().document.getElementById("G_calendar-day_"+i+"");
            var month,day;
            if (this.L_WDay[i]!="")
            {
                if(i<firstday){
                    da.style.border="1px solid #6bc4f3";
                    da.style.visibility="hidden";
                    da.innerHTML="<span style=\"color:gray\">" + this.L_WDay[i] + "</span>";
                    month=(mm==1?12:mm-1);
                    day=this.L_WDay[i];
                }
                else if(i>=firstday+this.GetMonthCount(yy,mm)){
                    da.style.visibility="hidden";
                    da.style.border="1px solid #6bc4f3";
                    da.innerHTML="<span style=\"color:gray\">" + this.L_WDay[i] + "</span>";
                    month=(mm==12?1:mm+1);
                    day=this.L_WDay[i];
                }
                else{
                    month=mm;
                    day=this.L_WDay[i];
                    var monthNow=new Date().getMonth()+1;
                    var dateDiff=this.GetDateDiff(yy+"-"+month+"-"+day,new Date().getFullYear()+"-"+monthNow+"-"+new Date().getDate());
					if(infoCount>=dateDiff-1 && this.Unlimited == false)
                    {	/* �����õ����� */
						da.style.visibility="visible";
						da.style.border="1px solid #d5d5d5";
						da.style.background='#fff';
						da.style.cursor="default";
						da.innerHTML="<span style=\"color:#d5d5d5\">" + this.L_WDay[i] + "</span>";
						if(document.all){
							da.onclick=Function("");
							da.onmouseover=Function("");
							da.onmouseout=Function("");
						}
						else{
							da.setAttribute("onclick","");
							da.setAttribute("onmouseover","");
							da.setAttribute("onmouseout","");
						}
                    }else{/* ���õ����� */
                        da.style.visibility="visible";
                        da.style.border="1px solid #d5d5d5";
                        da.style.background='#fff';
                        da.style.cursor="default";
                        da.innerHTML="<span style=\"color:#d5d5d5\">" + this.L_WDay[i] + "</span>";
                                
								da.style.visibility="visible";
                                da.style.border="1px solid #6bc4f3";
                                da.style.background='#fff';
                                da.innerHTML="<span style=\"color:#108bcd\">" + this.L_WDay[i] + "</span>";
								
                        if(document.all){
							da.onclick=Function("G_DateLayer_Parent."+this.NewName+".DayClick("+month+","+day+","+"false"+",'',"+"3"+")");
							da.onmouseover=Function("G_DateLayer_Parent."+this.NewName+".OnMouseOverDay(this,"+yy+","+month+","+day+","+dateDiff+")");
							da.onmouseout=Function("G_DateLayer_Parent."+this.NewName+".OnMouseOutDay(this,"+dateDiff+","+"false"+")");
                        }
                        else{
							da.setAttribute("onclick","parent."+this.NewName+".DayClick("+month+","+day+","+"false"+",'"+""+"',"+"3"+")");
							da.setAttribute("onmouseover","parent."+this.NewName+".OnMouseOverDay(this,"+yy+","+month+","+day+","+dateDiff+")");
							da.setAttribute("onmouseout","parent."+this.NewName+".OnMouseOutDay(this,"+dateDiff+","+"false"+")");
                        }
						da.style.cursor="pointer";
                    }
                }
                
				da.title=month+" <?php echo db_to_html('��')?>"+day+" <?php echo db_to_html('��')?>";

                if(yy == new Date().getFullYear()&&month==new Date().getMonth()+1&&day==new Date().getDate())
                {
                    da.style.border="1px solid #f7860f";
                    da.firstChild.style.color="#f7860f";
                    da.firstChild.style.fontWeight="bold";
                }
            }
        }
    },
    SelectYearInnerHTML:function () /* ��ݵ������� */
    {
        var DateLayer=this.GetDateLayer();
        var strYear=DateLayer.document.getElementById("G_calendar-year").innerHTML.substr(0,4);
        if(strYear.match(/\D/)!=null){alert("<?php echo db_to_html('�����������������֣�')?>");return;}

        var m = (strYear) ? strYear : new Date().getFullYear();
        if (m < 1000 || m > 9999) {alert("<?php echo db_to_html('���ֵ���� 1000 �� 9999 ֮�䣡')?>");return;}
        var n = m - 10;
        if (n < 1000) n = 1000;
        if (n + 26 > 9999) n = 9974;
        var s = "<select name=\"L_SelectYear\" id=\"L_SelectYear\" style='font-size: 12px' ";
        s += "onblur='document.getElementById(\"SelectYearLayer\").style.display=\"none\"' ";
        s += "onchange='document.getElementById(\"SelectYearLayer\").style.display=\"none\"; ";
        s += "parent."+this.NewName+".L_TheYear = this.value; parent."+this.NewName+".SetDay(parent."+this.NewName+".L_TheYear,parent."+this.NewName+".L_TheMonth)'>\r\n";
        var selectInnerHTML = s;
        for (var i = n; i < n + 26; i++)
        {
            if (i == m){
                selectInnerHTML += "<option value='" + i + "' selected>" + i + "<?php echo db_to_html('��')?>" + "</option>\r\n";
            }
            else{
                selectInnerHTML += "<option value='" + i + "'>" + i + "<?php echo db_to_html('��')?>" + "</option>\r\n";
            }
        }
        selectInnerHTML += "</select>";
        DateLayer.document.getElementById("SelectYearLayer").style.display="";
        DateLayer.document.getElementById("SelectYearLayer").innerHTML = selectInnerHTML;
        DateLayer.document.getElementById("L_SelectYear").focus();

    },
    SelectMonthInnerHTML:function () /* �·ݵ������� */
    {
        var DateLayer=this.GetDateLayer();
        var strMonth=DateLayer.document.getElementById("G_calendar-month").innerHTML.substr(0,2);
        if (strMonth.match(/\D/)!=null){strMonth=strMonth.substr(0,1);}
        if (strMonth.match(/\D/)!=null){alert("<?php echo db_to_html('�·���������������֣�')?>");return;}

        var m = (strMonth) ? strMonth : new Date().getMonth() + 1;
        var s = "<select name=\"L_SelectYear\" id=\"L_SelectMonth\" style='font-size: 12px' ";
        s += "onblur='document.getElementById(\"SelectMonthLayer\").style.display=\"none\"' ";
        s += "onchange='document.getElementById(\"SelectMonthLayer\").style.display=\"none\"; ";
        s += "parent."+this.NewName+".L_TheMonth = this.value; parent."+this.NewName+".SetDay(parent."+this.NewName+".L_TheYear,parent."+this.NewName+".L_TheMonth)'>\r\n";
        var selectInnerHTML = s;
        for (var i = 1; i < 13; i++)
        {
            if (i == m){
                selectInnerHTML += "<option value='"+i+"' selected>"+i+"<?php echo db_to_html('��')?>"+"</option>\r\n";
            }
            else{
                selectInnerHTML += "<option value='"+i+"'>"+i+"<?php echo db_to_html('��')?>"+"</option>\r\n";
            }
        }
        selectInnerHTML += "</select>";
        DateLayer.document.getElementById("SelectMonthLayer").style.display="";
        DateLayer.document.getElementById("SelectMonthLayer").innerHTML = selectInnerHTML;
        DateLayer.document.getElementById("L_SelectMonth").focus();
    },
    DayClick:function(mm,dd,ynJQ,info,selectIndex)  /* �����ʾ��ѡȡ���ڣ������뺯��************* */
    {
        var yy=this.L_TheYear;
        /* �ж��·ݣ������ж�Ӧ�Ĵ��� */
        if(mm<1){yy--;mm=12+mm;}
        else if(mm>12){yy++;mm=mm-12;}
        if (mm < 10){mm = "0" + mm;}
        if (this.ClickObject){
            if (!dd) {return;}
            if ( dd < 10){dd = "0" + dd;}

            if(ynJQ==false){
                /* this.InputObject.value= mm+"/"+dd+"/"+yy+" ("+this.GetDOW(dd,mm,yy)+")"; //ע�����������������ĳ�����Ҫ�ĸ�ʽ */
                this.InputObject.value= yy+"-"+mm+"-"+dd; /* ע�����������������ĳ�����Ҫ�ĸ�ʽ */
            }
            else{
                this.InputObject.value= mm+"/"+dd+"/"+yy+" ("+this.GetDOW(dd,mm,yy)+") ("+info+")";
            }
            
            this.CloseLayer();
        	this.InputObject.focus();
		}
        else {this.CloseLayer(); alert("<?php echo db_to_html('����Ҫ����Ŀؼ����󲢲����ڣ�')?>");}
    },
    SetUnlimited:function(val){	/* ���valΪ1���������ڣ��������ڿ��� */
		if(val==1){ this.Unlimited = true;	}else{ this.Unlimited = false;}
	},
	SetDate:function(){

        if (arguments.length <  1){alert("<?php echo db_to_html('�Բ��𣡴������̫�٣�')?>");return;}
        else if (arguments.length >  2){alert("<?php echo db_to_html('�Բ��𣡴������̫�࣡')?>");return;}
        this.InputObject=(arguments.length==1) ? arguments[0] : arguments[1];
        this.ClickObject=arguments[0];
        var reg = /^(\d+)-(\d{1,2})-(\d{1,2})$/;
        var r = this.InputObject.value.match(reg);
        var atd = "";
        if(r!=null){
            r[2]=r[2]-1;
            var d= new Date(r[1], r[2],r[3]);
            if(d.getFullYear()==r[1] && d.getMonth()==r[2] && d.getDate()==r[3]){
                    this.InputDate=d;		/* �����ⲿ��������� */
            }
            else this.InputDate="";
            this.L_TheYear=r[1];
            this.L_TheMonth=r[2]+1;
        }
        else if(atd){
            atdArray=atd.split("-");
            this.L_TheYear=atdArray[0];
            this.L_TheMonth=atdArray[1];
        }
        else{
            this.L_TheYear=new Date().getFullYear();
            this.L_TheMonth=new Date().getMonth() + 1
        }
        this.CreateHTML();
        var top=this.GetY();
        var left=this.GetX();
        var DateLayer=document.getElementById("G_DateLayer");
        DateLayer.style.top=top+this.ClickObject.clientHeight+5+"px";
        DateLayer.style.left=left+"px";
        DateLayer.style.display="block";
        if(document.all){
            this.GetDateLayer().document.getElementById("G_calendar").style.width="205px";
            this.GetDateLayer().document.getElementById("G_calendar").style.height="245px"
        }
        else{
            this.GetDateLayer().document.getElementById("G_calendar").style.width="205px";
            this.GetDateLayer().document.getElementById("G_calendar").style.height="245px"
            DateLayer.style.width="220px";
            DateLayer.style.height="250px";
        }
        this.SetDay(this.L_TheYear,this.L_TheMonth);
    },
    CloseLayer:function(){
        try{
            var DateLayer=document.getElementById("G_DateLayer");
            if((DateLayer.style.display=="" || DateLayer.style.display=="block") && arguments[0]!=this.ClickObject && arguments[0]!=this.InputObject){
                    DateLayer.style.display="none";
            }
        }
        catch(e){}
    },
    OnClose:function(){
        var DateLayer=document.getElementById("G_DateLayer");
        DateLayer.style.display="none";
    },
    OnMouseOverDay:function(e,yy,mm,day,dateDiff){
        e.style.border='1px solid #243c6c';
        e.firstChild.style.color='#243c6c';
        this.GetDateLayer().document.getElementById("G_calendar-show-week").innerHTML=this.GetDOW(day,mm,yy);
    },
    OnMouseOutDay:function(e,dateDiff,ynJQ){
        if(ynJQ)
        {
            e.style.border="1px solid #f7860f";
            e.style.background='#ffeadd';
        }
        else
        {
            e.style.background='#fff';
            e.style.border='1px solid #6bc4f3';
        }
        e.firstChild.style.color='#108bcd';
        if(dateDiff==0)
        {
            e.style.border="1px solid #f7860f";
            e.firstChild.style.color='#f7860f';
        }
        this.GetDateLayer().document.getElementById("G_calendar-show-week").innerHTML=this.GetDOWToday();
        this.GetDateLayer().document.getElementById("G_calendar-show-price").innerHTML="";
        if(window.ActiveXObject){
            var showinfo =this.GetDateLayer().document.getElementById("G_calendar-show-info");
            showinfo.style.marginTop="8px";
        }
    }
};

if(document.all){
	document.writeln('<iframe id="G_DateLayer" name="G_DateLayer" frameborder="0" style="position:absolute;width:220px; height:250px;z-index:1410065407;display:none;"></iframe>');
}else{
	document.writeln('<iframe id="G_DateLayer" name="G_DateLayer" frameborder="0" style="position:absolute;width:0px; height:0px;z-index:1410065407;display:none;"></iframe>');
}
var G_DateLayer_Parent=null;
var GeCalendar=new G_calendar();
GeCalendar.NewName="GeCalendar";

document.onclick=function(e)
{
    e = window.event || e;
    var srcElement = e.srcElement || e.target;
    GeCalendar.CloseLayer(srcElement);
}

/*��ͨ����end*/
<?php
}
/* �����������ڴ���̫����ֻ���ض���ҳ����ʾ */
?>


function hasClass(ele,cls) {
    return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}
function addClass(ele,cls) {
    if (!this.hasClass(ele,cls)) ele.className += " "+cls;
}
function removeClass(ele,cls) {
    if (hasClass(ele,cls)) {
    var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
        ele.className=ele.className.replace(reg,' ');
    }
}
function toggleClass(ele,cls) {
    if(hasClass(ele,cls)){
        removeClass(ele,cls);
    }
    else
        addClass(ele,cls);
}
function getStyle(elem,styleName){
    if(elem.style[styleName]){
        return elem.style[styleName];
    }
    else if(elem.currentStyle){/* IE */
        return elem.currentStyle[styleName];
    }
    else if(document.defaultView && document.defaultView.getComputedStyle){
        styleName = styleName.replace(/([A-Z])/g,'-$1').toLowerCase();
        var s = document.defaultView.getComputedStyle(elem,'');
        return s&&s.getPropertyValue(styleName);
    }
    else{
        return null;
    }
}


<!--TOP������-->
jQuery().ready(function() {
	/* jQuery.noConflict(); */
	jQuery("input.autocomplete_input").autocomplete('', {
		minChars: 1,
		resultsClass: "recommend",
		selectFirst: false,
		matchContains: "word",
		autoFill: false,
		max: 10,
		scroll: true,
		scrollHeight: 280,
		inputDefaultsVal: function(row) {
			return row[0] + " (<strong>id: " + row[1] + "</strong>)";
		},
		formatResult:function(row) {
			return row[0].replace(/(<.+?>)/gi, '');
		}
	});
});

function showHideLyer(tit,con,cls){
	toggleClass(tit,cls);
	var t = document.getElementById(con);	
	/* if(t){t.style.display = getStyle(t,'display') == 'none' ? 'block' : 'none';} */
	jQuery("#"+con).slideToggle(150);
}

<?php
if((int)$customer_id){
/* howard added for get new Short Message */
?>
function get_short_message(){
	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo('ajax_auto_update_top_msn_box.php','action=process')) ?>");
	ajax_get_submit(url,"","","");
	window.setTimeout('get_short_message()',60000);
}
/*
jQuery().ready(function() {
	get_short_message();
})
*/
<?php
}
?>


/*  ������ */
function GetIdObj(id){
  return document.getElementById(id);
}
function bodySize(){
  var a=new Array();
  a.st = document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop;
  a.sl = document.body.scrollLeft?document.body.scrollLeft:document.documentElement.scrollLeft;
  a.sw = document.documentElement.clientWidth;
  a.sh = document.documentElement.clientHeight;
  return a;
}

function getElementPos(elementId) {
	var ua = navigator.userAgent.toLowerCase();
	var isOpera = (ua.indexOf('opera') != -1);
	var isIE = (ua.indexOf('msie') != -1 && !isOpera); // not opera spoof
	var el = document.getElementById(elementId);
	if (el.parentNode === null || el.style.display == 'none') {
		return false;
	}
	var parent = null;
	var pos = [];
	var box;
	if (el.getBoundingClientRect) //IE
	{
		box = el.getBoundingClientRect();
		var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
		var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
		return {
			x: box.left + scrollLeft,
			y: box.top + scrollTop
		};
	} else if (document.getBoxObjectFor) // gecko
	{
		box = document.getBoxObjectFor(el);
		var borderLeft = (el.style.borderLeftWidth) ? parseInt(el.style.borderLeftWidth) : 0;
		var borderTop = (el.style.borderTopWidth) ? parseInt(el.style.borderTopWidth) : 0;
		pos = [box.x - borderLeft, box.y - borderTop];
	} else // safari & opera
	{
		pos = [el.offsetLeft, el.offsetTop];
		parent = el.offsetParent;
		if (parent != el) {
			while (parent) {
				pos[0] += parent.offsetLeft;
				pos[1] += parent.offsetTop;
				parent = parent.offsetParent;
			}
		}
		if (ua.indexOf('opera') != -1 || (ua.indexOf('safari') != -1 && el.style.position == 'absolute')) {
			pos[0] -= document.body.offsetLeft;
			pos[1] -= document.body.offsetTop;
		}
	}
	if (el.parentNode) {
		parent = el.parentNode;
	} else {
		parent = null;
	}
	while (parent && parent.tagName != 'BODY' && parent.tagName != 'HTML') { // account for any scrolled ancestors
		pos[0] -= parent.scrollLeft;
		pos[1] -= parent.scrollTop;
		if (parent.parentNode) {
			parent = parent.parentNode;
		} else {
		    parent = null;
		}
	}
	return {
		x: pos[0],
		y: pos[1]
	};
}

function centerElement(obj,top,fixedId){
  var s = bodySize();
  if(GetIdObj(obj)==null){ alert("No "+obj); return false;}
  var w = GetIdObj(obj).offsetWidth;
  var h = GetIdObj(obj).offsetHeight;
  GetIdObj(obj).style.left = parseInt((s.sw - w)/2) + s.sl + "px";
/*  if(top!="" && top!=null){
    GetIdObj(obj).style.top = top + "px";
  }else{
    GetIdObj(obj).style.top = parseInt((s.sh - h)/2) + s.st + "px";
  }
*/  
  
  
  if(top!="" && top!=null){
    if(top == "fixedTop"){
        //alert(GetIdObj('CreateNewCompanionLink').offsetTop);
		if(GetIdObj(fixedId)==null){
			alert('no fixedId:'+fixedId);
		}
		GetIdObj(obj).style.top = getElementPos(fixedId).y + "px";
    }else{
         GetIdObj(obj).style.top = top + "px";
    }
  }else{
    GetIdObj(obj).style.top = parseInt((s.sh - h)/2) + s.st + "px";
  }
  
  
}

/* ��ʾ������ 2010-09-14 */
function popupBg(){
  var _scrollWidth = document.body.scrollWidth;
  var _scrollHeight = document.body.scrollHeight;
  GetIdObj("popupBg").style.width = _scrollWidth + "px";  /* ���õ������ı�����Ⱥ���Ļ�Ĵ�Сһ�� */
  GetIdObj("popupBg").style.height = _scrollHeight + "px";


 isIE6 = navigator.userAgent.toLowerCase().indexOf("msie 6.0") != -1;/* �ж��������ie6, ������div���һ��iframe����������˵�select���ܱ��ڸǵ����� */
  if(isIE6){/* ie6����� */
    GetIdObj("popupBg").innerHTML="<iframe scrolling='no' height='100%' width='100%' marginwidth='0' marginheight='0' frameborder='0' class='popupBgIframe123' id='popupBgIframe'/></iframe>";
    GetIdObj("popupBgIframe").style.width = _scrollWidth + "px";  /* ���õ������ı��������ڸ�select��bug,���˸�iframe�Ŀ�Ⱥ͸߶Ⱥ���Ļ�Ĵ�Сһ�� */
    GetIdObj("popupBgIframe").style.height = _scrollHeight + "px";
 }

 
}
function showPopup(popupId,popupCon,ScrollOff,width,height,top,fixedId,hidebg){

/* popupId�ǵ������id,popupCon�ǵ��������ݲ��֣�popupCon�Ŀ�ȱ����趨���߶ȿɲ��趨 */
 GetIdObj(popupId).style.display="block";  /* ��ʾ������ */
  if(width!=null && width>0 && height!=null && height>0){
	  GetIdObj(popupId).style.width = width+"px";   /* �������ݵĿ�� */
	  GetIdObj(popupId).style.height = height+"px";  /* �������ݵĸ߶� */
  }else{
		
	  GetIdObj(popupId).style.width = (GetIdObj(popupCon).offsetWidth + 12) + "px";   /* �������ݵĿ�� */
	  GetIdObj(popupId).style.height = (GetIdObj(popupCon).offsetHeight + 12) + "px";  /* �������ݵĸ߶� */
  }
  centerElement(popupId,top,fixedId);
  
  if(typeof(hidebg)=='undefined' || hidebg == false || hidebg == '0' || hidebg==0 || hidebg=='false') {
	GetIdObj("popupBg").style.display="block";  /* ���õ������ı��� */
	  popupBg();
  }
  window.onresize = function() {centerElement(popupId,top,fixedId); popupBg();}/* ��Ļ�ı��ʱ�������趨������ */
  if(ScrollOff!="" && ScrollOff!=null){}else{
  	window.onscroll = function() {centerElement(popupId,top,fixedId); popupBg();}/* ���¹���ʱ������λ�������趨 */
  }
  /* window.setTimeout("showPopup('popupTip','popupConCompare')",1000); */

}

/*���ٵ�¼���JS ��ʼ*/
/*vincent 2011.3.30*/

function showPopupForm(formActionUrl,popupId,popupCon,ScrollOff,width,height,top,fixedId,hidebg){
	showPopup(popupId,popupCon,ScrollOff,width,height,top,fixedId,hidebg);	
	jQuery("#"+popupId+"_form").bind("submit",{'formId':popupId+"_form",'formAction':formActionUrl},function(e){common_fast_login(e.data.formId,e.data.formAction);return false;});//common_fast_login(popupId+"_form",formActionUrl);
}

function common_fast_login(form_id,action){
	var from = document.getElementById(form_id);
	if(from.elements["email_address"].value.length<2){
		alert("<?php echo db_to_html('�����������˺ţ��������䣩��')?>");
		return false;
	}
	if(from.elements["password"].value.length<1){
		alert("<?php echo db_to_html('�������������룡')?>");
		return false;
	}
	var url = url_ssl(action); 
	ajax_post_submit(url,form_id);
	return true;
}
/*���ٵ�¼���JS ����*/
function closePopup(popupId){
	if(GetIdObj(popupId)!=null){
		GetIdObj(popupId).style.display='none';
	}
	GetIdObj("popupBg").style.display='none';
}

//�����㶥����ҷ 
Array.prototype.extend = function(C) {
  for (var B = 0, A = C.length; B < A; B++) {
    this.push(C[B]);
  }
  return this;
}
function divDrag() {
  var A, B, popupcn;
  var zIndex = 1000;
  this.dragStart = function(e) {
    e = e || window.event;
    if ((e.which && (e.which != 1)) || (e.button && (e.button != 1))) return;
    var pos = this.popuppos;
    popupcn = this.parent || this;
    if (document.defaultView) {
      _top = document.defaultView.getComputedStyle(popupcn, null).getPropertyValue("top");
      _left = document.defaultView.getComputedStyle(popupcn, null).getPropertyValue("left");
    }
    else {
      if (popupcn.currentStyle) {
        _top = popupcn.currentStyle["top"];
        _left = popupcn.currentStyle["left"];
      }
    }
    pos.ox = (e.pageX || (e.clientX + document.documentElement.scrollLeft)) - parseInt(_left);
    pos.oy = (e.pageY || (e.clientY + document.documentElement.scrollTop)) - parseInt(_top);
    if ( !! A) {
      if (document.removeEventListener) {
        document.removeEventListener("mousemove", A, false);
        document.removeEventListener("mouseup", B, false);
      }
      else {
        document.detachEvent("onmousemove", A);
        document.detachEvent("onmouseup", B);
      }
    }
    A = this.dragMove.create(this);
    B = this.dragEnd.create(this);
    if (document.addEventListener) {
      document.addEventListener("mousemove", A, false);
      document.addEventListener("mouseup", B, false);
    }
    else {
      document.attachEvent("onmousemove", A);
      document.attachEvent("onmouseup", B);
    }
    popupcn.style.zIndex = (++zIndex);
    this.stop(e);
  }
  this.dragMove = function(e) {
    e = e || window.event;
    var pos = this.popuppos;
    popupcn = this.parent || this;
    popupcn.style.top = (e.pageY || (e.clientY + document.documentElement.scrollTop)) - parseInt(pos.oy) + 'px';
    popupcn.style.left = (e.pageX || (e.clientX + document.documentElement.scrollLeft)) - parseInt(pos.ox) + 'px';
    this.stop(e);
  }
  this.dragEnd = function(e) {
    var pos = this.popuppos;
    e = e || window.event;
    if ((e.which && (e.which != 1)) || (e.button && (e.button != 1))) return;
    popupcn = this.parent || this;
    if ( !! (this.parent)) {
      this.style.backgroundColor = pos.color;
    }
    if (document.removeEventListener) {
      document.removeEventListener("mousemove", A, false);
      document.removeEventListener("mouseup", B, false);
    }
    else {
      document.detachEvent("onmousemove", A);
      document.detachEvent("onmouseup", B);
    }
    A = null;
    B = null;
    popupcn.style.zIndex = (++zIndex);
    this.stop(e);
  }
  this.shiftColor = function() {
    this.style.backgroundColor = "#EEEEEE";
  }
  this.position = function(e) {
    var t = e.offsetTop;
    var l = e.offsetLeft;
    while (e = e.offsetParent) {
      t += e.offsetTop;
      l += e.offsetLeft;
    }
    return {
      x: l,
      y: t,
      ox: 0,
      oy: 0,
      color: null
    }
  }
  this.stop = function(e) {
    if (e.stopPropagation) {
      e.stopPropagation();
    } else {
      e.cancelBubble = true;
    }
    if (e.preventDefault) {
      e.preventDefault();
    } else {
      e.returnValue = false;
    }
  }
  this.stop1 = function(e) {
    e = e || window.event;
    if (e.stopPropagation) {
      e.stopPropagation();
    } else {
      e.cancelBubble = true;
    }
  }
  this.create = function(bind) {
    var B = this;
    var A = bind;
    return function(e) {
      return B.apply(A, [e]);
    }
  }
  this.dragStart.create = this.create;
  this.dragMove.create = this.create;
  this.dragEnd.create = this.create;
  this.shiftColor.create = this.create;
  this.initialize = function() {
    for (var A = 0, B = arguments.length; A < B; A++) {
      C = arguments[A];
      if (! (C.push)) {
        C = [C];
      }
      popupC = (typeof(C[0]) == 'object') ? C[0] : (typeof(C[0]) == 'string' ? popup(C[0]) : null);
      if (!popupC) continue;
      popupC.popuppos = this.position(popupC);
      popupC.dragMove = this.dragMove;
      popupC.dragEnd = this.dragEnd;
      popupC.stop = this.stop;
      if ( !! C[1]) {
        popupC.parent = C[1];
        popupC.popuppos.color = popupC.style.backgroundColor;
      }
      if (popupC.addEventListener) {
        popupC.addEventListener("mousedown", this.dragStart.create(popupC), false);
        if ( !! C[1]) {
          popupC.addEventListener("mousedown", this.shiftColor.create(popupC), false);
        }
      }
      else {
        popupC.attachEvent("onmousedown", this.dragStart.create(popupC));
        if ( !! C[1]) {
          popupC.attachEvent("onmousedown", this.shiftColor.create(popupC));
        }
      }
    }
  }
  this.initialize.apply(this, arguments);
}



/* ȫ�ֱ���֤ */
function from_field_check(){
	var msn_type = "span";
	jQuery("input").blur(function(){
		if(this.className.indexOf('required')>-1 && this.title!=""){
			if(this.value.length<1){
				/* alert(this.title); */
			}
		}
	});
}
jQuery().ready(function() {
	from_field_check();
	/* �ҵ����ķ�����Ч�� */
	jQuery("#tit").mouseover(function(){
		jQuery('#my_another_tours').show();
		jQuery(this).addClass("myTours2");
	});
	jQuery("#tit").mouseout(function(){
		jQuery('#my_another_tours').hide();
		jQuery(this).removeClass("myTours2");
	});
	
});
function jQuery_Enter(event,obj,fun){
	var key = -1;
	if (event.which == null){
		key = event.keyCode;    /* IE*/
	}else{
		key = event.which;	  /* All others*/
	}
	if(key==13){
		eval("obj.value="+fun+"(obj.value)");
	}
	return true;
}

/* �Ź���ʱʱ���� */
function GruopBuyCountdown(ProductsId,TimeNum,ShowBoxId, HideId){
	var CountdownObj = ('#'+ShowBoxId);
	if(TimeNum>=0){
		/*�� Сʱ �� �� strart*/
		RSeconds = TimeNum;
		ThisDay = Math.floor(RSeconds/86400);
		RSeconds -= (ThisDay*86400);
		ThisHours = Math.floor(RSeconds/3600);
		RSeconds -= (ThisHours*3600);
		ThisMinutes = Math.floor(RSeconds/60);
		RSeconds -= (ThisMinutes*60);
		
		if(RSeconds>0){
			jQuery(CountdownObj).html('<b>'+RSeconds+'</b><?= db_to_html('��')?>');
		}
		if(ThisMinutes>0){
			jQuery(CountdownObj).html('<b>'+ThisMinutes+'</b><?= db_to_html('��')?><b>'+RSeconds+'</b><?= db_to_html('��')?>');
		}
		if(ThisHours>0){
			jQuery(CountdownObj).html('<font class="timeColor"><b>'+ThisHours+'</b><?= db_to_html('Сʱ')?></font><b>'+ThisMinutes+'</b><?= db_to_html('��')?><b>'+RSeconds+'</b><?= db_to_html('��')?>');
		}
		if(ThisDay>0){
			jQuery(CountdownObj).html('<font class="timeColor"><b>'+ThisDay+'</b><?= db_to_html('��')?><b>'+ThisHours+'</b><?= db_to_html('Сʱ')?></font><b>'+ThisMinutes+'</b><?= db_to_html('��')?><b>'+RSeconds+'</b><?= db_to_html('��')?>');
		}
		
		TimeNum--;
		window.setTimeout('GruopBuyCountdown('+ProductsId+','+TimeNum+',"'+ShowBoxId+'","'+HideId+'")',1000);
	}else{
		jQuery('#'+HideId).fadeOut(200);
		//alert('<?= db_to_html('�Ѿ�������')?>'+ProductsId);
	}
}

<?php
$_tmps = tep_get_countries_tel_code_array();
$_tmp = array();
foreach($_tmps as $val){
	$_tmp[] = $val['id'];
}
rsort($_tmp);
$json = json_encode($_tmp);
?>
; var ALL_COUNTRY_TEL_CODES = <?php echo $json;?>;
/* ���ݹ����������õ绰���� */
function set_tel_code(code, inputObj){
	var _value = code+' '+jQuery(inputObj).val();
	var input_old_val = jQuery(inputObj).val();
	for(var i=0; i<ALL_COUNTRY_TEL_CODES.length; i++){
		if(input_old_val.indexOf(ALL_COUNTRY_TEL_CODES[i]) >-1){
			_value = code+' '+input_old_val.replace(ALL_COUNTRY_TEL_CODES[i],'');
			_value = _value.replace(/\s+/gi,' ');
			break;
		}
	}
	jQuery(inputObj).val(_value);
}

/* ���ݵ绰�����жϹ������ţ�����绰����ǰ�治��+���򷵻ؿ�ֵ */
function get_tel_code(tel_number){
	var code = '';
	if(tel_number.indexOf('+')===0){
		for(var i=0; i<ALL_COUNTRY_TEL_CODES.length; i++){
			if(tel_number.indexOf(ALL_COUNTRY_TEL_CODES[i]) >-1){
				code = ALL_COUNTRY_TEL_CODES[i];
				break;
			}
		}
	}
	return code;
}

<?php
if($is_js_file==false){
?>
//--></script>
<?php
}
?>

///������ͨ���͵�
function Check_Onfocus(obj){
	if(obj.value==obj.title){
		obj.value="";
		//obj.className='input_search2';
		obj.style.color = "#353535";
	}
}
function Check_Onblur(obj){
	if(obj.value==""){
		obj.value=obj.title;
		obj.style.color = "#BBBBBB";
	}
}
function url_ssl(url){
	var SSL_ = false;
	if(document.URL.search(/^https:\/\//)>-1){
		SSL_ = true;
	}
	var new_url = url;
	if(SSL_==true){
		new_url = url.replace(/^http:\/\//,"https://");
	}else{
		new_url = url.replace(/^https:\/\//,"http://");
	}
	return new_url;
}
//����XMLHttp���� start
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

        // IE5�в�֧��push����
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

        // mozillaĳЩ�汾û��readyState����
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

    // ��������(����[post,get], ��ַ, ����, �ص�����)
    sendReq: function (method, url, data, callback)
    {
        var objXMLHttp = this._getInstance();

        with(objXMLHttp)
        {
            try
            {
                // ���������ֹ����
                if (url.indexOf("?") > 0)
                {
                    url += "&randnumforajaxaction=" + Math.random();
                }
                else
                {
                    url += "?randnumforajaxaction=" + Math.random();
                }

                open(method, url, true);

                // �趨������뷽ʽ
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
//����XMLHttp���� end
//ajax �ύGET����
function ajax_get_submit(url,success_msm,success_go_to,replace_id){
	var url = url;
	XMLHttp.sendReq('GET', url, null, ajax_get_return_data);
	/*
	ajax.open("GET", url, true);
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
			alert('���β����ɹ�');
		}
		if(success_go_to!=""){
			location = success_go_to;
		}
	}else if(typeof(replace_id)!="undefined"){
		var Replace_ID = document.getElementById(replace_id);
		if(Replace_ID!=null){
			Replace_ID.innerHTML = obj.responseText;
		}
	}else{
		//alert(obj.responseText);
	}

}

//ajax �ύPOST����
function ajax_post_submit(url,form_id,success_msm,success_go_to, replace_id){

	var form = document.getElementById(form_id);
	var aparams=new Array();  //����һ�����д������Ԫ�غ�ֵ

	for(var i=0; i<form.length; i++){
		if(form.elements[i].type=="radio" || form.elements[i].type=="checkbox" ){	//����ѡ����ѡ��ťֵ
			var a = '';
			if(form.elements[i].checked == true){
				var sparam=encodeURIComponent(form.elements[i].name);  //ȡ�ñ�Ԫ����
				sparam+="=";     //����ֵ֮����"="������
				a = form.elements[i].value;
				sparam+=encodeURIComponent(a);   //��ñ�Ԫ��ֵ
				aparams.push(sparam);   //push�ǰ���Ԫ����ӵ�������ȥ
			}
		}else{
			var sparam=encodeURIComponent(form.elements[i].name);  //ȡ�ñ�Ԫ����
			sparam+="=";     //����ֵ֮����"="������
			sparam+=encodeURIComponent(form.elements[i].value);   //��ñ�Ԫ��ֵ1
			aparams.push(sparam);   //push�ǰ���Ԫ����ӵ�������ȥ
		}
	}
	var post_str = aparams.join("&");		//ʹ��&������Ԫ������
	post_str += "&ajax=true";

	// ���������ֹ����
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
//alert(ajax.responseText);
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

//����XMLHttp���� end

//����ajax����
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
	window.alert("���ܴ���XMLHttpRequest����ʵ��");
}

//�Զ�����https��httpȡֵ
function url_ssl(url){
	var SSL_ = false;
	if(document.URL.search(/^https:\/\//)>-1){
		SSL_ = true;
	}
	var new_url = url;
	if(SSL_==true){
		new_url = url.replace(/^http:\/\//,"https://");
	}else{
		new_url = url.replace(/^https:\/\//,"http://");
	}
	return new_url;
}

function write_success_notes(out_time, notes_contes, gotourl){	//��Ϣ���ɹ��������ʾ����Ϣ����ҳ��
	var Notes = document.getElementById("OutTimeNotes");
	if(Notes==null){ alert("No OutTimeNotes");}
	var Content = document.getElementById("OutTimeNotesContent");
	if(Content==null){ alert("No OutTimeNotesContent");}
	Content.innerHTML = notes_contes;
	showDiv(Notes.id);
	OutTimeGoto(gotourl,out_time);
	if(typeof(gotourl)!='undefined' && gotourl!=""){
	}else{
		var out_num = out_time*1000;
		window.setTimeout('closeDiv("'+Notes.id+'")',out_num);
	}
}
///��ʾn���رյ�ǰ��򵽴���ҳ�� end


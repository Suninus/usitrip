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

/* js��ҳ��ť�����������ڷ�ajax��ʽ */
function split_page(start_row, end_row, page_max_row, count_rows, top_obj, TagNameStr, indexOfTag, split_page_obj){	
/*
����˵��: start_row��ʼ��,end_row������;
page_max_rowÿҳ��ʾ�ļ�¼��,count_rows�ܼ�¼��,
top_obj��ҳ���������ĸ���ģ��,TagNameStr�еı�ʶ����div��tr��,indexOfTagÿ�м�¼id�ŵ�ǰ��ı�ʶ��(�������ֲ���);
split_page_obj�Ǵ�ŷ�ҳ��ť�Ķ���
*/
	
	var top_obj = document.getElementById(top_obj);
	var TagName = top_obj.getElementsByTagName(TagNameStr);
	var split_page_obj = document.getElementById(split_page_obj);
	for(i=0; i<TagName.length; i++){
		if(TagName[i].id.indexOf(indexOfTag) >-1 && TagName[i].style.display!="none"){	/* �������� */
			TagName[i].style.display = "none";
		}
	}
	for(b=start_row; b<(end_row+1); b++){
		if(document.getElementById(indexOfTag+b )!=null){	/* ��ʾ���� */
			document.getElementById(indexOfTag+b ).style.display = "";
		}
	}
	/* ����ҳ��html���� */
	var max_page_num_rows = 7; /* �����ʾ��ҳ�������������� */
	/* ��ҳ�� */
	var count_page_num = Math.ceil(count_rows/page_max_row);
	/* ��ǰҳ */
	var new_page_num = 1;
	if(end_row>0){
		new_page_num = end_row/page_max_row;
		new_page_num = Math.ceil(new_page_num);
		if(end_row==start_row){
			new_page_num = count_page_num;
		}
	}
	/* alert(new_page_num); */
	var tmp_html ="";
	tmp_html += '<div class="tab1_2_1" >';
	/* ǰһҳ */
	if(new_page_num>1){
		tmp_start = Math.max(0,(new_page_num-1)*page_max_row) - page_max_row;
		tmp_end = Math.min((count_rows-1),(tmp_start + page_max_row -1 ));
		tmp_html += '<a href="javascript:void(0);" class="pageResults" onclick="split_page('+ tmp_start +','+ tmp_end +', '+page_max_row+', '+count_rows+', \''+top_obj.id+'\',\''+ TagNameStr+'\',\''+ indexOfTag+'\',\''+ split_page_obj.id+'\' );" title="<?php echo db_to_html('ǰһҳ')?>"><u>&lt;&lt; <?php echo db_to_html('��һҳ')?></u></a>&nbsp;&nbsp;&nbsp;';
	}
	/* ��ǰҳ֮ҳ��ҳ�� */
	back_num = (max_page_num_rows-1)/2;
	for(i=(new_page_num-back_num); i<new_page_num; i++){
		if(i>0){
			tmp_start = Math.max(0,i*page_max_row) - page_max_row;
			tmp_end = Math.min((count_rows-1),(tmp_start + page_max_row -1 ));
			tmp_html += '<a href="javascript:void(0);" class="pageResults" onclick="split_page('+ tmp_start +','+ tmp_end +', '+page_max_row+', '+count_rows+', \''+top_obj.id+'\',\''+ TagNameStr+'\',\''+ indexOfTag+'\',\''+ split_page_obj.id+'\' );" title="<?php echo db_to_html('��')?>'+i+'<?php echo db_to_html('ҳ')?>"><u>'+i+'</u></a>&nbsp;&nbsp;';
		}
	}
	tmp_html += '<b>'+new_page_num+'</b>&nbsp;&nbsp;';
	/* ��ǰҳ֮���ҳ�� */
	next_num = (max_page_num_rows-1)/2;
	for(i=(new_page_num+1); i<(new_page_num+next_num+1); i++){
		if(i<=count_page_num){
		tmp_start = Math.max(0,i*page_max_row) - page_max_row;
		tmp_end = Math.min((count_rows-1),(tmp_start + page_max_row -1 ));
			tmp_html += '<a href="javascript:void(0);" class="pageResults" onclick="split_page('+ tmp_start +','+ tmp_end +', '+page_max_row+', '+count_rows+', \''+top_obj.id+'\',\''+ TagNameStr+'\',\''+ indexOfTag+'\',\''+ split_page_obj.id+'\' );" title="<?php echo db_to_html('��')?>'+i+'<?php echo db_to_html('ҳ')?>"><u>'+i+'</u></a>&nbsp;&nbsp;';
		}
	}
	/* ��һҳ */
	if(new_page_num<count_page_num){
		tmp_start = Math.max(0,(new_page_num-1)*page_max_row) + page_max_row;
		tmp_end = Math.min((count_rows-1),(tmp_start + page_max_row -1 ));
		tmp_html += '<a href="javascript:void(0);" class="pageResults" onclick="split_page('+ tmp_start +','+ tmp_end +', '+page_max_row+', '+count_rows+', \''+top_obj.id+'\',\''+ TagNameStr+'\',\''+ indexOfTag+'\',\''+ split_page_obj.id+'\' );" title="<?php echo db_to_html('��һҳ')?>"><u><?php echo db_to_html('��һҳ')?> &gt;&gt;</u></a>&nbsp;&nbsp;&nbsp;';
	}
	tmp_html += '</div>';
	tmp_html += '<div class="tab1_2_2"><?php echo db_to_html('��')?><b>'+new_page_num+'</b><?php echo db_to_html('ҳ')?> (<?php echo db_to_html('��')?><b>'+count_page_num+'</b><?php echo db_to_html('ҳ')?>)</div>';
	split_page_obj.innerHTML = tmp_html;
	
}

/* ѡ����͵�id��ʾ��Ӧ�ľƵ���Ϣ */
function SelDeparture(departure_id){
	var TopObj = document.getElementById('c_hotel');
	var div = TopObj.getElementsByTagName('div');
	for(i=0; i<div.length; i++){
		if(div[i].id.indexOf('hotel_list_')>-1){
			div[i].style.display="none";
		}
	}
	for(i=0; i<div.length; i++){
		var idstr = div[i].id;
		if(idstr.indexOf('hotel_list_')>-1){
			var subid = idstr.replace(/hotel_list_\d+##/,'');
			if(subid==departure_id || subid.indexOf(departure_id+',')>-1 || subid.indexOf(','+departure_id)>-1 || subid.indexOf(','+departure_id+',')>-1 || departure_id==0){
				div[i].style.display="";
			}
		}
	}
	
}

/* ��꾭���ı䱳��ɫ */
function rowOverEffect(object,buttonSelect) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
  /* ѡ�и�Ԫ������ĵ�1����ѡ��ť */
  var button_Select = document.getElementById(buttonSelect);
  	if(button_Select!=null){
		button_Select.checked=true;
	}
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}

/* �Ƶ�Ԥ��start */
function Booking_Hotel(form_object){
	var form = form_object;
	var form_id = form.id;
	var main_id = form_id.replace(/^hotel_form_/,'');
	/* ��ס���� */
	if(form.elements['availabletourdate'].value==""){
		alert(form.elements['availabletourdate'].title);
		return false;
	}

	/* �ж����ַ��䱻ѡ�� */
	var input_ = form.getElementsByTagName("input");
	form.elements['numberOfRooms'].value = '1';
	var RoomType = 0;
	for(i=0; i<input_.length; i++){
		if(input_[i].checked==true && input_[i].type=='radio'){
			/* ȡ�÷������� */
			form.elements['numberOfRooms'].value = form.elements['numberOfRooms_'+input_[i].value].value;
			/* ȡ�÷������� */
			var RoomType = input_[i].value.replace(/.*\_/,'');
			break;
		}
	}
	/* ���ݷ�����������room_field�ڵķ������� */
	var room_field = document.getElementById("room_field_"+ main_id);
	var input_html = '';
	var adult_num = (parseInt(RoomType)+1);
	for(b=0; b<form.elements['numberOfRooms'].value; b++){
		input_html += '<input name="room-' +b+ '-adult-total" type="hidden" value="'+adult_num+'" /><input name="room-' +b+ '-child-total" type="hidden" value="0" />';
	}
	room_field.innerHTML = input_html;
	form.submit();
}
/* �Ƶ�Ԥ��end */

/* Ԥ������ѡ������start */
function L_calendar(){}
L_calendar.prototype={
    HelpMsg:"<?php echo db_to_html('1.��ɫ������Ϊ��ͨ�ɳ�������;<br>2.�ۺ챳�����Ϊ�ر�۸�����;<br>3.��ɫ������Ϊ��������;<br>4.��ɫ����û���г̰���,����ѡ;<br>5.�����ײ������Ƕ����ڵ�˵��;');?>",/* ��������Ӻ��޸İ����ĵ������� */

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
        return window.L_DateLayer;
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
        htmlstr+="<div id=\"L_calendar\">\r\n";
        htmlstr+="<span id=\"SelectYearLayer\" style=\"z-index: 9999;position: absolute;top: 3; left: 45;display: none\"></span>\r\n";
        htmlstr+="<span id=\"SelectMonthLayer\" style=\"z-index: 9999;position: absolute;top: 3; left: 105;display: none\"></span>\r\n";
        htmlstr+="<div id=\"L_calendar-year-month\">\r\n";
        htmlstr+="<div id=\"L_calendar-PrevM\" onclick=\"parent."+this.NewName+".PrevM()\" title=\"<?php echo db_to_html('ǰһ��')?>\"><b>&lt;</b><span id=\"L_calendar-PrevM-text\"></span></div>\r\n";
        htmlstr+="<div id=\"L_calendar-year\" onmouseover=\"style.backgroundColor='#ffeadd'\" onmouseout=\"style.backgroundColor='white'\" onclick=\"parent."+this.NewName+".SelectYearInnerHTML()\"></div>\r\n";
        htmlstr+="<div id=\"L_calendar-month\"  onmouseover=\"style.backgroundColor='#ffeadd'\" onmouseout=\"style.backgroundColor='white'\" onclick=\"parent."+this.NewName+".SelectMonthInnerHTML()\"></div>\r\n";
        htmlstr+="<div id=\"L_calendar-NextM\" onclick=\"parent."+this.NewName+".NextM()\" title=\"<?php echo db_to_html('��һ��')?>\"><span id=\"L_calendar-NextM-text\"></span><b>&gt;</b></div>\r\n";
        htmlstr+="</div>\r\n";
        htmlstr+="<div id=\"L_calendar-week\"><ul  onmouseup=\"StopMove()\"><li><b><?php echo db_to_html('��')?></b></li><li><?php echo db_to_html('һ')?></li><li><?php echo db_to_html('��')?></li><li><?php echo db_to_html('��')?></li><li><?php echo db_to_html('��')?></li><li><?php echo db_to_html('��')?></li><li><b><?php echo db_to_html('��')?></b></li></ul></div>\r\n";
        htmlstr+="<div id=\"L_calendar-day\">\r\n";
        htmlstr+="<ul>\r\n";
        for(var i=0;i<this.L_WDay.length;i++){
            htmlstr+="<li id=\"L_calendar-day_"+i+"\" style=\"background:#fff;border:1px solid #6bc4f3\" ></li>";
        }
        htmlstr+="</ul>\r\n";
        htmlstr+="</div>\r\n";
        htmlstr+="<div>\r\n";
        htmlstr+="<div id=\"L_calendar-help\" onclick='sAlert(\""+this.HelpMsg+"\")'><span><?php echo db_to_html('����')?></span></div>\r\n";
        htmlstr+="<div id=\"L_calendar-show-week\"><span>"+this.GetDOWToday()+"</span></div>\r\n";
        htmlstr+="<div id=\"L_calendar-show-info\"><span></span><b id=\"L_calendar-show-price\"></b></div>\r\n";
        htmlstr+="<div id=\"L_calendar-close\" onclick='parent."+this.NewName+".OnClose()'><span><?php echo db_to_html('�ر�')?></span></div>\r\n";
        htmlstr+="</div>\r\n";
        htmlstr+="</div>\r\n";
        htmlstr+="<scr" + "ipt type=\"text/javas" + "cript\">\r\n";
        htmlstr+="var MouseX,MouseY;";
        htmlstr+="var Moveable="+this.Moveable+";\r\n";
        htmlstr+="var MoveaStart=false;\r\n";
        htmlstr+="document.onmousemove=function(e)\r\n";
        htmlstr+="{\r\n";
        htmlstr+="var DateLayer=parent.document.getElementById(\"L_DateLayer\");\r\n";
        htmlstr+="	e = window.event || e;\r\n";
        htmlstr+="var DateLayerLeft=DateLayer.style.posLeft || parseInt(DateLayer.style.left.replace(\"px\",\"\"));\r\n";
        htmlstr+="var DateLayerTop=DateLayer.style.posTop || parseInt(DateLayer.style.top.replace(\"px\",\"\"));\r\n";
        htmlstr+="if(MoveaStart){DateLayer.style.left=(DateLayerLeft+e.clientX-MouseX)+\"px\";DateLayer.style.top=(DateLayerTop+e.clientY-MouseY)+\"px\"};\r\n";
        htmlstr+="}\r\n";

        htmlstr+="document.getElementById(\"L_calendar-week\").onmousedown=function(e){\r\n";
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
        htmlstr+="var parentObj=document.getElementById(\"L_calendar-help\");\r\n";
        htmlstr+="msgObj.style.left = parentObj.offsetLeft; \r\n";
        htmlstr+="msgObj.style.top = parentObj.offsetTop-msgh+14; \r\n";
        htmlstr+="msgObj.style.font=\"12px/1.6em Verdana, Geneva, Arial, Helvetica, sans-serif\";\r\n";
        htmlstr+="msgObj.style.width = msgw + \"px\"; \r\n";
        htmlstr+="msgObj.style.height =msgh + \"px\"; \r\n";
        htmlstr+="msgObj.style.textAlign = \"left\"; \r\n";
        htmlstr+="msgObj.style.lineHeight =\"25px\"; \r\n";
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
        stylestr+="#L_calendar{border:1px solid #6bc4f3;width:205px;padding:1px;height:245px;z-index:9998;text-align:center;}\r\n";
        stylestr+="#L_calendar-year-month{height:23px;line-height:23px;z-index:9998;border-bottom:1px solid #6bc4f3;}\r\n";
        stylestr+="#L_calendar-year{line-height:20px;width:60px;float:left;z-index:9998;position: absolute;top: 3; left: 45;cursor:default;font-weight:bold;text-align:right;}\r\n";
        stylestr+="#L_calendar-month{line-height:20px;width:45px;float:left;z-index:9998;position: absolute;top: 3; left: 105;cursor:default;font-weight:bold;text-align:left;}\r\n";
        stylestr+="#L_calendar-PrevM{position: absolute;top: 3px; left: 5px;cursor:pointer;color:#f7860f;}\r\n";
        stylestr+="#L_calendar-PrevM-text{margin-left:3px;color:#108bcd;}\r\n";
        stylestr+="#L_calendar-NextM{position: absolute;top: 3px; left:160px;cursor:pointer;color:#f7860f;width:40px;text-align:right;}\r\n";
        stylestr+="#L_calendar-week{height:23px;line-height:23px;z-index:9998;}\r\n";
        stylestr+="#L_calendar-NextM-text{color:#108bcd;}\r\n";
        stylestr+="#L_calendar-day{height:175px;;z-index:9998;}\r\n";
        stylestr+="#L_calendar-week{background:#edf8fe;}\r\n";
        stylestr+="#L_calendar-week ul{cursor:move;list-style:none;margin:0px;padding:0px;margin-left:5px;}\r\n";
        stylestr+="#L_calendar-week li{width:24px !important;width:23px;height:24px !important;height:23px;line-height:23px;float:left;margin:2px;padding:0px;text-align:center;}\r\n";
        stylestr+="#L_calendar-day{background:#edf8fe;border-bottom:1px solid #d5d5d5}\r\n";
        stylestr+="#L_calendar-day ul{list-style:none;margin:0px;padding:0px;margin-left:5px;}\r\n";
        stylestr+="#L_calendar-day li{cursor:pointer;width:22px !important;width:23px;height:22px !important;height:23px;line-height:23px;float:left;;margin:2px;padding:0px;border:1px solid #6bc4f3;}\r\n";
        stylestr+="#L_calendar-help{color:#108bcd;float:left;width:30px;margin-top:8px;cursor:pointer;}\r\n";
        stylestr+="#L_calendar-show-week{float:left;width:60px;margin-top:8px;text-align:right;}\r\n";
        stylestr+="#L_calendar-show-info{float:left;width:85px;*width:80px;margin-top:8px;}\r\n";
        stylestr+="#L_calendar-show-price{color:f7860f;}\r\n";
        stylestr+="#L_calendar-close{color:#108bcd;float:left;width:30px;margin-top:8px;cursor:pointer;}\r\n";
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
        var L_DateLayer=this.GetDateLayer();
        if(L_DateLayer){L_DateLayer.document.getElementById(id).innerHTML=htmlstr;}
    },
    WriteHead:function (yy,mm)  /* �� head ��д�뵱ǰ�������� */
    {
        this.InsertHTML("L_calendar-year",yy + "<?php echo db_to_html('��')?>");
        this.InsertHTML("L_calendar-month",mm + "<?php echo db_to_html('��')?>");

        mm=Number(mm);
        var prevM=mm==1?12:mm-1;
        var nextM=mm==12?1:mm+1;

        this.InsertHTML("L_calendar-PrevM-text",prevM + "<?php echo db_to_html('��')?>");
        this.InsertHTML("L_calendar-NextM-text",nextM + "<?php echo db_to_html('��')?>");
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
        oDate1 = new Date(aDate[0],aDate[1]-1,aDate[2]);
        aDate = sDate2.split("-");
        oDate2 = new Date(aDate[0],aDate[1]-1,aDate[2]);
        
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
        var infoCount=this.DayInfo.length;
        this.WriteHead(yy,mm);
        /* ���õ�ǰ���µĹ�������Ϊ����ֵ */
        this.L_TheYear=yy;
        this.L_TheMonth=mm;
        /* ��ҳ�汾��λ�ڿ����ʱ IE�᷵�ش����parent */
        if(window.top.location.href!=window.location.href){
            for(var i_f=0;i_f<window.top.frames.length;i_f++){
                    if(window.top.frames[i_f].location.href==window.location.href){L_DateLayer_Parent=window.top.frames[i_f];}
            }
        }
        else{
            L_DateLayer_Parent=window.parent;
        }
        for (var i = 0; i < 39; i++){this.L_WDay[i]=""}  /* ����ʾ�������ȫ����� */
        var day1 = 1,day2=1,firstday = new Date(yy,mm-1,1).getDay();  /* ĳ�µ�һ������ڼ� */
        for (i=0;i<firstday;i++)this.L_WDay[i]=this.GetMonthCount(mm==1?yy-1:yy,mm==1?12:mm-1)-firstday+i+1	/* �ϸ��µ������ */
        for (i = firstday; day1 < this.GetMonthCount(yy,mm)+1; i++){this.L_WDay[i]=day1;day1++;}
        for (i=firstday+this.GetMonthCount(yy,mm);i<39;i++){this.L_WDay[i]=day2;day2++}
        for (i = 0; i < 39; i++)
        {
            var da=this.GetDateLayer().document.getElementById("L_calendar-day_"+i+"");
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
                    if(infoCount>=dateDiff+1)
                    {
                        if(dateDiff>=0&&this.DayInfo[dateDiff][0])
                        {
                            if(this.DayInfo[dateDiff][1])
                            {
                                da.style.visibility="visible";
                                da.style.border="1px solid #f7860f";
                                da.style.background='#ffeadd';
                                da.innerHTML="<span style=\"color:#108bcd\">" + this.L_WDay[i] + "</span>";
                                if(document.all){
                                    da.onclick=Function("L_DateLayer_Parent."+this.NewName+".DayClick("+month+","+day+","+this.DayInfo[dateDiff][1]+",'"+this.DayInfo[dateDiff][2]+"',"+this.DayInfo[dateDiff][3]+")");
                                    da.onmouseover=Function("L_DateLayer_Parent."+this.NewName+".OnMouseOverDay(this,"+yy+","+month+","+day+","+dateDiff+")");
                                    da.onmouseout=Function("L_DateLayer_Parent."+this.NewName+".OnMouseOutDay(this,"+dateDiff+","+this.DayInfo[dateDiff][1]+")");
                                }
                                else{
                                    da.setAttribute("onclick","parent."+this.NewName+".DayClick("+month+","+day+","+this.DayInfo[dateDiff][1]+",'"+this.DayInfo[dateDiff][2]+"',"+this.DayInfo[dateDiff][3]+")");
                                    da.setAttribute("onmouseover","parent."+this.NewName+".OnMouseOverDay(this,"+yy+","+month+","+day+","+dateDiff+")");
                                    da.setAttribute("onmouseout","parent."+this.NewName+".OnMouseOutDay(this,"+dateDiff+","+this.DayInfo[dateDiff][1]+")");
                                }
                            }
                            else
                            {
                                da.style.visibility="visible";
                                da.style.border="1px solid #6bc4f3";
                                da.style.background='#fff';
                                da.innerHTML="<span style=\"color:#108bcd\">" + this.L_WDay[i] + "</span>";
                                if(document.all){
                                    da.onclick=Function("L_DateLayer_Parent."+this.NewName+".DayClick("+month+","+day+","+this.DayInfo[dateDiff][1]+",'',"+this.DayInfo[dateDiff][3]+")");
                                    da.onmouseover=Function("L_DateLayer_Parent."+this.NewName+".OnMouseOverDay(this,"+yy+","+month+","+day+","+dateDiff+")");
                                    da.onmouseout=Function("L_DateLayer_Parent."+this.NewName+".OnMouseOutDay(this,"+dateDiff+","+this.DayInfo[dateDiff][1]+")");
                                }
                                else{
                                    da.setAttribute("onclick","parent."+this.NewName+".DayClick("+month+","+day+","+this.DayInfo[dateDiff][1]+",'',"+this.DayInfo[dateDiff][3]+")");
                                    da.setAttribute("onmouseover","parent."+this.NewName+".OnMouseOverDay(this,"+yy+","+month+","+day+","+dateDiff+")");
                                    da.setAttribute("onmouseout","parent."+this.NewName+".OnMouseOutDay(this,"+dateDiff+","+this.DayInfo[dateDiff][1]+")");
                                }
                            }
                            da.style.cursor="pointer";
                        }
                        else{
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
                        }
                    }
                    else{
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
        var strYear=DateLayer.document.getElementById("L_calendar-year").innerHTML.substr(0,4);
        if(strYear.match(/\D/)!=null){alert("<?php echo db_to_html('�����������������֣�')?>");return;}

        var m = (strYear) ? strYear : new Date().getFullYear();
        if (m < 1000 || m > 9999) {alert("<?php echo db_to_html('���ֵ���� 1000 �� 9999 ֮�䣡')?>");return;}
        var n = m - 10;
        if (n < 1000) n = 1000;
        if (n + 26 > 9999) n = 9974;
        var s = "<select name=\"L_SelectYear\" id=\"L_SelectYear\" style='font-size: 12px' "
        s += "onblur='document.getElementById(\"SelectYearLayer\").style.display=\"none\"' "
        s += "onchange='document.getElementById(\"SelectYearLayer\").style.display=\"none\";"
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
        var strMonth=DateLayer.document.getElementById("L_calendar-month").innerHTML.substr(0,2);
        if (strMonth.match(/\D/)!=null){strMonth=strMonth.substr(0,1);}
        if (strMonth.match(/\D/)!=null){alert("<?php echo db_to_html('�·���������������֣�')?>");return;}

        var m = (strMonth) ? strMonth : new Date().getMonth() + 1;
        var s = "<select name=\"L_SelectYear\" id=\"L_SelectMonth\" style='font-size: 12px' "
        s += "onblur='document.getElementById(\"SelectMonthLayer\").style.display=\"none\"' "
        s += "onchange='document.getElementById(\"SelectMonthLayer\").style.display=\"none\";"
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
                this.InputObject.value= mm+"/"+dd+"/"+yy+" ("+this.GetDOW(dd,mm,yy)+")"; /* ע�����������������ĳ�����Ҫ�ĸ�ʽ */
            }
            else{
                if(info=="<?php echo db_to_html('(����)')?>")
                {
                    this.InputObject.value= mm+"/"+dd+"/"+yy+" ("+this.GetDOW(dd,mm,yy)+") <?php echo db_to_html('(���ռ۸�)')?>";
                }
                else
                {
                    this.InputObject.value= mm+"/"+dd+"/"+yy+" ("+this.GetDOW(dd,mm,yy)+") ("+info+")";
                }
            }
            document.getElementById("availabletourdate_833##43491,43492").options[selectIndex].selected = true;
            this.CloseLayer();
        	this.InputObject.focus();
		}
        else {this.CloseLayer(); alert("<?php echo db_to_html('����Ҫ����Ŀؼ����󲢲����ڣ�')?>");}
    },
    SetDate:function(){
        /* ����״�ʹ���������ҳ����ؿ������� */
        if(this.DayInfo.length==0){
            var availabletourdate=document.getElementById("availabletourdate_833##43491,43492");
            var aDateCount=availabletourdate.length;
            var nowMonth=new Date().getMonth()+1;
            var todayString=new Date().getFullYear()+"-"+nowMonth+"-"+new Date().getDate();
            var infoCount=this.GetDateDiff(availabletourdate.options[aDateCount-1].value.substr(0,10),todayString);
            var nowDate=new Date(new Date().getFullYear(),new Date().getMonth(),new Date().getDate());
            
            var dateOption = availabletourdate.options[1].value.substr(0,10);
            var dateOptionArray=dateOption.split("-");
            var dateTemp=new Date(dateOptionArray[0],dateOptionArray[1]-1,dateOptionArray[2]);

            var j=1;
            while(dateTemp-nowDate < 0)
            {
                j++;
                dateOption = availabletourdate.options[j].value.substr(0,10);
                dateOptionArray=dateOption.split("-");
                dateTemp=new Date(dateOptionArray[0],dateOptionArray[1]-1,dateOptionArray[2]);
            }
            
            for(var i=0;i<=infoCount;i++)
            {
                if(dateTemp-nowDate==0){
                    var dateOptionValue = availabletourdate.options[j].value;
                    if(dateOptionValue.indexOf("!!!")>-1){
                        this.DayInfo[i]=new Array(true,false,'',j);
                    }
                    else{
                        var indexFirst=dateOptionValue.indexOf("(");
                        if(indexFirst>-1)
                        {
                            var price=dateOptionValue.substr(indexFirst+1,1);
                            var indexSecond=dateOptionValue.indexOf("$");
                            var indexEnd=dateOptionValue.indexOf(")");
                            price=price+dateOptionValue.substr(indexSecond,indexEnd-indexSecond);
                            this.DayInfo[i]=new Array(true,true,price,j);
                        }
                        else
                        {
                            this.DayInfo[i]=new Array(true,true,"<?php echo db_to_html('(����)')?>",j);
                        }
                    }
                    j++;
                    nowDate=new Date(nowDate-0+1*86400000);
                    if(i<infoCount){
                        dateOption = availabletourdate.options[j].value.substr(0,10);
                        dateOptionArray=dateOption.split("-");
                        dateTemp=new Date(dateOptionArray[0],dateOptionArray[1]-1,dateOptionArray[2]);
                    }
                }
                else{
                    this.DayInfo[i]=new Array(false);
                    nowDate=new Date(nowDate-0+1*86400000);
                }           
            }
        }
                
        if (arguments.length <  1){alert("<?php echo db_to_html('�Բ��𣡴������̫�٣�')?>");return;}
        else if (arguments.length >  2){alert("<?php echo db_to_html('�Բ��𣡴������̫�࣡')?>");return;}
        this.InputObject=(arguments.length==1) ? arguments[0] : arguments[1];
        this.ClickObject=arguments[0];
        var reg = /^(\d+)-(\d{1,2})-(\d{1,2})$/;
        var r = this.InputObject.value.match(reg);
        var atd = document.getElementById("availabletourdate_833##43491,43492").options[1].value.substr(0,10);
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
        var DateLayer=document.getElementById("L_DateLayer");
        DateLayer.style.top=top+this.ClickObject.clientHeight+5+"px";
        DateLayer.style.left=left+"px";
        DateLayer.style.display="block";
        if(document.all){
            this.GetDateLayer().document.getElementById("L_calendar").style.width="205px";
            this.GetDateLayer().document.getElementById("L_calendar").style.height="245px"
        }
        else{
            this.GetDateLayer().document.getElementById("L_calendar").style.width="205px";
            this.GetDateLayer().document.getElementById("L_calendar").style.height="245px"
            DateLayer.style.width="220px";
            DateLayer.style.height="250px";
        }
        this.SetDay(this.L_TheYear,this.L_TheMonth);
    },
    CloseLayer:function(){
        try{
            var DateLayer=document.getElementById("L_DateLayer");
            if((DateLayer.style.display=="" || DateLayer.style.display=="block") && arguments[0]!=this.ClickObject && arguments[0]!=this.InputObject){
                    DateLayer.style.display="none";
            }
        }
        catch(e){}
    },
    OnClose:function(){
        var DateLayer=document.getElementById("L_DateLayer");
        DateLayer.style.display="none";
    },
    OnMouseOverDay:function(e,yy,mm,day,dateDiff){
        e.style.border='1px solid #243c6c';
        e.firstChild.style.color='#243c6c';
        this.GetDateLayer().document.getElementById("L_calendar-show-week").innerHTML=this.GetDOW(day,mm,yy);
        if(this.DayInfo[dateDiff][1])
        {
            this.GetDateLayer().document.getElementById("L_calendar-show-price").innerHTML=this.DayInfo[dateDiff][2];
            if(window.ActiveXObject){
                var showinfo =this.GetDateLayer().document.getElementById("L_calendar-show-info");
                showinfo.style.marginTop="6px";
            }
        }
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
        this.GetDateLayer().document.getElementById("L_calendar-show-week").innerHTML=this.GetDOWToday();
        this.GetDateLayer().document.getElementById("L_calendar-show-price").innerHTML="";
        if(window.ActiveXObject){
            var showinfo =this.GetDateLayer().document.getElementById("L_calendar-show-info");
            showinfo.style.marginTop="8px";
        }
    }
}
	

document.writeln('<iframe id="L_DateLayer" name="L_DateLayer" frameborder="0" style="position:absolute;width:220px; height:250px;z-index:9998;display:none;"></iframe>');
var L_DateLayer_Parent=null;

var MyCalendar=new L_calendar();
MyCalendar.NewName="MyCalendar";
document.onclick=function(e)
{
    e = window.event || e;
    var srcElement = e.srcElement || e.target;
    MyCalendar.CloseLayer(srcElement);
}
/* Ԥ������ѡ������end */

<?php
if($is_js_file==false){
?>
//--></script>
<?php
}
?>

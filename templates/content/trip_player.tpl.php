<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET ?>" />
<title><?php echo db_to_html('���ķ���������ʦ����')?></title>
<meta content="<?php echo db_to_html('���ķ�|���ķ���|���ķ�����|�������ķ�|����|����|������|��ɫ������|���ô�|��������|ŷ��|�ձ�|�Ƶ�Ԥ��|Ŀ�ĵ�ָ��|���ͬ��') ?>" name="keywords"/>
<meta content="<?php echo db_to_html('���ķ���Ϊ���ṩ������������ô������ײͣ����Գ�ֵ���α�ȫ��������ô����ǵĹ˿Ϳ����������෱�࣬���ݷḻ������Ϊ�����Ƶ������ײͣ��Լ��������ʵķ���')?>" name="description"/>
<style type="text/css">
body,p{ margin:0; padding:0;}
img{border:0;}
body{ background: url(image/trip_player/daren_bg.png) no-repeat top center #b7e3f6; font-size:12px; font-family:"宋体",Tahoma,Arial,Helvetica,sans-serif; color:#777;}
.darenAll{ width:950px; margin:0 auto;}
.darenTop1{ width:950px; height:67px;}
.darenTop2{ background:url(image/trip_player/style1_02.jpg) no-repeat top left; width:950px; height:72px; padding-top:160px;}
.darenTop2 p{ font-size:24px; color:#d8bf9e; font-weight:bold;  margin-left:340px; }
.darenTop2 p span{ width:72px; height:44px; display:block; text-align:center; float:left; background:url(image/trip_player/darends_bg.png) no-repeat top left; color:#FFFFFF; font-size:48px; line-height:46px; }
.darenTop2 p b{ display:block; float:left; line-height:48px;}
.darenTop2 p img{ display:block; float:left; line-height:44px;}
.darenTop3{ width:950px; height:354px;}
.darendsJs{ width:910px; text-align:right; padding-top:0px; font-size:16px; color:#000000; padding-right:40px;}


</style>
</head>
<script src="jquery-1.3.2/jquery-1.4.2.min.js"></script>
<script language="JavaScript">
function _fresh()
{
 var endtime=new Date("2011/10/12,12:00:00");
 var nowtime = new Date();
 var leftsecond=parseInt((endtime.getTime()-nowtime.getTime())/1000);
 __d=parseInt(leftsecond/3600/24);
 __h=parseInt((leftsecond/3600)%24);
 __m=parseInt((leftsecond/60)%60);
 __s=parseInt(leftsecond%60);
 jQuery("#days").html(__d);
 jQuery("#hours").html(__h);
 jQuery("#minutes").html(__m);
 jQuery("#seconds").html(__s);
 if(leftsecond<=0){
 	jQuery("#time").html("<?php echo db_to_html('�����') ?>");
 	clearInterval(sh);
 }
}
_fresh()
var sh;
sh=setInterval(_fresh,1000);

function addFavorites(sURL, sTitle){    
    if (document.all){    
        try{    
            window.external.addFavorite(sURL,sTitle);    
        }catch(e){    
            alert( "<?php echo db_to_html('�����ղ�ʧ�ܣ���ʹ��Ctrl+D������ӣ�') ?>" );    
        }    
            
    }else if (window.sidebar){    
        window.sidebar.addPanel(sTitle, sURL, "");    
     }else{    
        alert( "<?php echo db_to_html('�����ղ�ʧ�ܣ���ʹ��Ctrl+D������ӣ�') ?>" );    
    }    
} 
</script>
	
<body>
<div id="time"></div>
<div class="darenAll">
<div class="darenTop1"><img src="image/trip_player/style1_01.png" alt="<?php echo db_to_html('���ķ��������ķ���������ʦ����')?>" title="<?php echo db_to_html('���ķ��������ķ���������ʦ����')?>" width="950" height="67"/></div>
<div class="darenTop2" title="<?php echo db_to_html('���ķ��������ķ���������ʦ������Ipad2�󽱵����ã����л���Ӯȡ$1000����֮�ã�')?>">
  <p><span id='days'>00</span> <b><?php echo db_to_html('��')?></b> 
  <span class="darenShi" id="hours">00</span><img src="image/trip_player/darends_f.png" alt="ʱ" /> 
  <span id="minutes">00</span><img src="image/trip_player/darends_f.png" alt="��" /> 
  <span id="seconds">00</span> </p>
</div>
<div class="darenTop3"><img src="image/trip_player/style1_03.jpg" alt="<?php echo db_to_html('���ķ��������ķ���������ʦ������Ipad2�󽱵����ã����л���Ӯȡ$1000����֮�ã�')?>" title="<?php echo db_to_html('���ķ��������ķ���������ʦ������Ipad2�󽱵����ã����л���Ӯȡ$1000����֮�ã�')?>" width="950" height="354" usemap="#Map" />
  <map name="Map" id="Map">
    <area shape="rect" coords="810,230,933,264" href="javascript:addFavorites(this.location.href, '<?php echo db_to_html('���ķ���������ʦ����') ?>');" alt="<?php echo db_to_html('�ղ�')?>" title="<?php echo db_to_html('�ղ�')?>"  />
  </map>
  <div class="darendsJs"><p><?php echo db_to_html('���ʼ��2011��10��12��') ?></p></div>
</div>
<!--<div class="darendsJs"><p>���ϸ��Ʒ��ʵ��Ϊ׼�����ս���Ȩ�����ķ�������</p></div>
</div>-->
<a class="bshareDiv" href="http://www.bshare.cn/share"><?php echo db_to_html('����ť')?></a>
<script language="javascript" type="text/javascript" src="http://static.bshare.cn/b/button.js#uuid=929efbd7-68d3-4cc2-b113-24c3cb6d957f&amp;style=3&amp;fs=4&amp;textcolor=#fff&amp;bgcolor=#F60&amp;text=<?php echo db_to_html('����...')?>"></script>
<script type="text/javascript">
jQuery(function(){
if(typeof(bShare)!='undefined'){
bShare.addEntry({
     title: "#<?php echo db_to_html('���ķ���������ʦ')?>#",
     summary: "<?php echo db_to_html('�����������У�@���ķ��� ΢�����ɲ��룬IPAD2�󽱵����ã����л�����ѳ���������')?>"
}) 
}
});
</script>
</body>
</html>

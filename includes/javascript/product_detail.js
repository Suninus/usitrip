/**
 * product_detail.js
 * ��Ʒ��ϸҳ��JS
 *
 * date:2011-4-2
 * 
 */

jQuery(function(){
    //��Ʒ�õ�Ƭ start
	new Scroll("Scroll");
	//fdp.fixedHeight = 238;
	jQuery('#BigImage a').lightBox();
	jQuery("#Scroll li:first").addClass("on");
	jQuery("#Scroll li").hover(function(){
		jQuery("#Scroll li").remove("on");
		jQuery(this).addClass("on");
		var tmpImg = jQuery("#BigImage a:eq("+jQuery("#Scroll li").index(this)+") img");
		jQuery("#BigImage a:eq("+jQuery("#Scroll li").index(this)+")").show().siblings("#BigImage a").hide(); 
	});
	//��Ʒ�õ�Ƭ end
	
	//�ײ��������� start
	/*if(navigator.userAgent.toLowerCase().match(/iPad/i) != "ipad"){
		var pageTop = function() {
			return document.documentElement.clientHeight + Math.max(document.documentElement.scrollTop, document.body.scrollTop);
		};
		jQuery(window).bind('scroll resize', function(){
			if (jQuery("#anchor1").offset().top <= pageTop() && jQuery("#Guid").offset().top >= pageTop()) {
				jQuery("#QuickLinks").show();
			}else{
				jQuery("#QuickLinks").hide();
			}
		});
	};*/
	/*  ������ �����ڶ��� lwkaiRem */
	if(navigator.userAgent.toLowerCase().match(/iPad/i) != "ipad"){
		var pageTop = function() {
			//return document.documentElement.clientHeight + Math.max(document.documentElement.scrollTop, document.body.scrollTop);
			return Math.max(document.documentElement.scrollTop, document.body.scrollTop);
		};
		jQuery(window).bind('scroll resize', function(){
			if (jQuery("#tit_one_1").offset().top <= pageTop() && jQuery("#Guid").offset().top >= pageTop() ) {
				if(jQuery("#SuspendedLocation").attr('class').indexOf('Suspended') == -1){
					jQuery("#SuspendedLocation").addClass('Suspended');
				}
				jQuery('#SuspendedLocation li[suspension="true"]').each(function(i){
					//�Զ�����ǰ��li��ǩclass������Ϊselect
					var Tit = jQuery(this).attr('toid'); //'tit_two_4';
					var Con = Tit.replace('tit_','con_');//'con_two_4';
					if(jQuery('#' + Tit).offset() != null && jQuery('#' + Con).offset() != null){
						if(jQuery(this).offset().top >= (jQuery('#' + Tit).offset().top-35) && jQuery(this).offset().top <= (jQuery('#' + Tit).offset().top + jQuery('#' + Con).height()) ){
							jQuery(this).attr('class', "selected");
						}else{
							jQuery(this).removeClass("selected");
						}
					}
				});
			}else if(jQuery("#SuspendedLocation").attr('class').indexOf('Suspended') > -1){
				jQuery("#SuspendedLocation").removeClass('Suspended');
			}
			//���½ǵĿ��ٹ���ť��ʾ
			if(jQuery("#cart_quantity").offset().top <= pageTop() ){
				jQuery('#goBuyPanel').show();
			}else{
				jQuery('#goBuyPanel').hide();
			}
		});
	};
//������������ı�ǩʱ�Ķ���
jQuery(document).ready(function(e) {
	jQuery('ul[id^="tit_one_"] a, ul[id^="tit_two_"] a').click(function(){
		var _top = jQuery(this).parents("ul").position().top;
		jQuery('html,body').animate({scrollTop:_top});
	});
});
	
	//�ײ��������� end
	
    //ͼƬ�ӳټ���(lazyload) start
	lazyload({
		defObj: ".lazyLoad",
		defHeight: 0
	});
	//ͼƬ�ӳټ���(lazyload) end
	
	//����lazyload ����IPad start
	if(navigator.userAgent.toLowerCase().match(/iPad/i) == "ipad"){
		jQuery('img').each(function() {
		    var src2 = jQuery(this).attr("src2");
	        if(src2){
		        jQuery(this).attr("src", src2).removeAttr("src2");
	        }
        });
	};
	//����lazyload ����IPad end
	
});
		

//ͼƬ�ӳټ���(lazyload)�������� by Rocky start
function lazyload(option) {
	var settings = {
		defObj: null,
		defHeight: 0
	};
	settings = jQuery.extend(settings, option || {});
	var defHeight = settings.defHeight,
	defObjImg = (typeof settings.defObj == "object") ? settings.defObj.find("img") : jQuery(settings.defObj).find("img");
	var pageTop = function() {
		return document.documentElement.clientHeight + Math.max(document.documentElement.scrollTop, document.body.scrollTop) - settings.defHeight;
	};
	var imgLoad = function() {
		defObjImg.each(function() {
			if (jQuery(this).offset().top <= pageTop()) {
				var src2 = jQuery(this).attr("src2");
				if (src2) {
					jQuery(this).attr("src", src2).removeAttr("src2");
				}
			};
		});
	};
	imgLoad();
	jQuery(window).bind('scroll resize',
	function() {
		imgLoad();
	});
};
//ͼƬ�ӳټ���(lazyload)�������� by Rocky end

//������src2�ĳ�src start
function showAllImg(n){
    jQuery(n).each(function() {
	    var src2 = jQuery(this).attr("src2");
        if(src2){
	        jQuery(this).attr("src", src2).removeAttr("src2");
        };
    });
}
//������src2�ĳ�src end

//����IE6����Ⱥ�����ȸ߶ȵ�Bug start
function ie6Max(n){
	
	if(jQuery.browser.msie && (parseInt(jQuery.browser.version) <= 7)){
		jQuery(n).each(function() {
			var maxWidth = parseInt(jQuery(this).css('max-width'));
			var maxHeight = parseInt(jQuery(this).css('max-height'));
			
			if(jQuery(this).height() > maxHeight || jQuery(this).width() > maxWidth){
				var wh = jQuery(this).width() / jQuery(this).height();
				if( jQuery(this).height() > jQuery(this).width()){
					jQuery(this).height(maxHeight);
					jQuery(this).width(jQuery(this).height() * wh);
				}else{
					jQuery(this).width(maxWidth);
					jQuery(this).height(jQuery(this).width() / wh);
				};
			}
		});
	}
}
//����IE6����Ⱥ�����ȸ߶ȵ�Bug end

//�����ҳ����ǰTabͷ��
function AutoToTabHead(){
	/*jQuery().ready(function() {
		jQuery("#QuickLinksCon a").not('.green,.orange').click(function(){
			var topOffset = jQuery("#two2").offset().top;
			scroll(0,topOffset);
		});
	});*/
	jQuery(function(){
		jQuery("#QuickLinksCon .orange").click(function(){
			jQuery("html,body").animate({scrollTop:jQuery('#cart_quantity').position().top - 10});
		});	
	});
}
//AutoToTabHead();

//customer waitlist start
var popupWaitlist=function(element){
	if (arguments.length > 1){
		for (var i = 0, elements = [], length = arguments.length; i < length; i++)
		elements.push($(arguments[i]));
		return elements;
	}
	if (typeof element == 'string'){
		if (document.getElementById){
			element = document.getElementById(element);
		}else if (document.all){
			element = document.all[element];
		}else if (document.layers){
			element = document.layers[element];
		}
	}
	return element;
};
function showGWaitlistHelper(gmapurl){
	if(gmapurl!=''){
		if(gmapurl != jQuery('#gWaitlistIframe').attr('src')){
			jQuery('#popupConWaitlist').width(700);
			jQuery('#gWaitlisttips').show();
			jQuery('#gWaitlistIframe').hide();
			jQuery('#gWaitlistIframe').attr('src',gmapurl);
		}
		showPopup('popupWaitlist','popupConWaitlist',true,0,0,'','',true);
		
	}
}
function minPopupWaitlist(obj){
	obj = jQuery(obj);
	var t=obj.attr('isMin');
	if(t=='true'){
		obj.attr('isMin','false');
		obj.html('-');
		jQuery('#popupConWaitlist').width(725);
		jQuery('#gWaitlisttips').hide();
		jQuery('#gWaitlistIframe').show();
		showPopup('popupWaitlist','popupConWaitlist',true,0,0,'','',true);
	}else{
		obj.attr('isMin','true');
		obj.html('+');
		jQuery('#popupConWaitlist').width(700);
		jQuery('#gWaitlisttips').hide();
		jQuery('#gWaitlistIframe').hide();
		showPopup('popupWaitlist','popupConWaitlist',true,0,0,'','',true);
	}
}

var divDragActionFomWaitlist = false;
jQuery().ready(function() {
	if(divDragActionFomWaitlist == false){
		divDragActionFomWaitlist = true;
		new divDrag([popupWaitlist('dragWaitlist'),popupWaitlist('popupWaitlist')]);
	}
});
//customer waitlist end


//�ó����ר��
jQuery(document).ready(function($){
	var _li = $('.train_design li');
	_li.hover(function(){
		$(this).addClass('show').siblings().removeClass('show');
	});
});
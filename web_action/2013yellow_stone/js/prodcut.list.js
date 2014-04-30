

	var FixedBox=function(el){ //�¶���һ������ΪFixedBox�ĺ������¼�һ��el����
		this.element=el; //����һ���ֲ�����this.element = el
		this.BoxY=getXY(this.element).y;//�������ΪBoxY��ֵΪgetXY(this.element).y,�õ���ҳ�涥���ľ���
	}

    
	FixedBox.prototype={
	    setCss:function(){
	        var windowST=(document.compatMode && document.compatMode!="CSS1Compat")? document.body.scrollTop:document.documentElement.scrollTop||window.pageYOffset;
            if(windowST>this.BoxY){
              var scrollTop = document.documentElement.scrollTop + document.body.scrollTop;
              var offsetTop = document.getElementById("proListTop").offsetTop;
              this.element.style.top = scrollTop - offsetTop + 0 +"px";
			}else{
			  this.element.style.top = "0px";
			}
		}
	};
	
	function addEvent(elm, evType, fn, useCapture) {
		if (elm.addEventListener) {
			elm.addEventListener(evType, fn, useCapture);
		return true;
		}else if (elm.attachEvent) {
			var r = elm.attachEvent('on' + evType, fn);
			return r;
		}
		else {
			elm['on' + evType] = fn;
		}
	}

	function getXY(el) {
        return document.documentElement.getBoundingClientRect && (function() {
            var pos = el.getBoundingClientRect();
            return { x: pos.left + document.documentElement.scrollLeft, y: pos.top + document.documentElement.scrollTop };
        })() || (function() {
            var _x = 0, _y = 0;
            do {
                _x += el.offsetLeft;
                _y += el.offsetTop;
            } while (el = el.offsetParent);
            return { x: _x, y: _y };
        })();
    }

	var divA=new FixedBox(document.getElementById("compareBar"));
	
   	addEvent(window,"scroll",function(){
	  divA.setCss();
	});
	window.onresize = function(){
      divA.setCss();
    }
	
	

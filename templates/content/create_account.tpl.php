<!-- content main body start -->
<?php 
ob_start();	
?>
<!-- content main body end -->
<script type="text/javascript">
var suffixArr= ["@hotmail.com" , "@gmail.com" , "@163.com" , "@qq.com" , "@126.com" , "@yahoo.com.cn" , "@yahoo.com" , "@sina.com" , "@yahoo.cn"];
var suffixArr2= ["@hotmail.com" , "@gmail.com","@163.com","@qq.com ","@126.com","@yahoo.com.cn","@yahoo.com",'@sina.com','@yahoo.cn','@yahoo.com.tw','@sohu.com','@msn.com','@live.cn','@yahoo.com.hk','@tom.com','@yeah.net'];
(function(){
	jQuery.fn.autoComplete=function(options){
        var defaults={
            subBox:"#suggest",
            subOp:"li",
            id:"#email_address",
            suffixArr:suffixArr,
			suffixArr2:suffixArr2,
            hoverClass:"on",
            _cur:-1
        };
        var option = jQuery.extend({}, defaults, options || {});

        jQuery(option.id).keyup(function(e){
        	jQuery('#AccountErrorMessage').hide();
            var _that=jQuery(this);
            if(_that.val()!=""){
                if(e.keyCode!=38 && e.keyCode!=40 && e.keyCode!=13 && e.keyCode!=27 && e.keyCode!=9){
                    var _inputVal=_that.val();
                    jQuery.fn.autoComplete.tipFun(_inputVal,_that);
                }
                jQuery(this).removeClass("textMid"); 
                jQuery(this).removeClass("textSmall"); 
                if(jQuery(this).val().length>25){ 
                    jQuery(this).removeClass("textSmall");
                    jQuery(this).addClass("textMid");  
                    if(jQuery(this).val().length>30){
                        jQuery(this).addClass("textSmall");
                    }
                };
            }else{
                jQuery(option.subBox).hide();
            }
        });

        jQuery(option.id).blur(function(){
        	if(jQuery.trim(jQuery(this).val())==''){
        		jQuery(this).removeClass("textMid"); 
                jQuery(this).removeClass("textSmall");
        		jQuery(this).val('<?php echo $account_input_blankvalue ?>');
        	}
        });

        jQuery(option.id).focus(function(){
        	if(jQuery(this).val()=="<?php echo $account_input_blankvalue ?>"){
        		jQuery(this).val("");
        	}
        });
	   
        jQuery.fn.autoComplete.tipFun=function(_v,o){
            option._cur=-1;
            var _that=o;
            jQuery(option.subBox).show();
            var str="<ul>";
            var e=_v.indexOf("@");
            if(e==-1){
                jQuery.each(option.suffixArr,function(s,m){
                    str+='<li><a href="javascript:void(0)"  >' + _v + m + "</a></li>";							
                });
            }else{
                var _sh=_v.substring(0,e)
                var _se=_v.substring(e);
                var ind = 0;
                jQuery.each(option.suffixArr2, function (s,m) {
                    if(m.indexOf(_se)!=-1){
                        str += '<li><a href="javascript:void(0)" >' + _sh + m + "</a></li>";
                        ind = 1;
                    }
                });
                if(ind==0){
                    str += '<li><a class="cur_val" href="javascript:void(0)" >' + _v + "</a></li>";
                }
            }
            str+="</ul>";
            jQuery(option.subBox).html(str); 

            jQuery(option.subBox).find(option.subOp).hover(function(){
                var _that=jQuery(this);
                _that.addClass(option.hoverClass);					   
            },function(){
                var _that=jQuery(this);
                _that.removeClass(option.hoverClass)			
            });

            jQuery(option.subBox).find(option.subOp).each(function(){
                jQuery(this).click(function(e){
                        jQuery(option.id).val(jQuery(e.target).html());
                        jQuery(option.subBox).hide();
                        e.stopPropagation();
                        jQuery(option.id).focus();
                });											  
            })
        };

		jQuery(document).bind("click",function(e){
            jQuery(option.subBox).hide();
		});

		jQuery.fn.autoComplete.itemFun=function(){
		    
			var _tempArr=jQuery(option.subBox).find(option.subOp);
			var _size=_tempArr.size();
			for(var i=0;i<_size;i++){
				_tempArr.eq(i).removeClass(option.hoverClass);
			}
			
			if(_size>0){
				if(option._cur>_size-1){
					option._cur=0;	
				}
				if(option._cur<0){
					option._cur=_size-1;	
				}
				_tempArr.eq(option._cur).addClass(option.hoverClass);
			}else{
				option._cur=-1;	
			}
		};
		
		jQuery(document).keydown(function(e){
            switch(e.keyCode){
                case 40:
                    option._cur++;
                    jQuery.fn.autoComplete.itemFun()
                    break;
                case 38:
                    option._cur--;					
                    jQuery.fn.autoComplete.itemFun()
                    break;
				case 9:
					jQuery("#suggest").hide();
					break;
                default:
                   break;
            }
		})

	    jQuery(option.id).keydown(function(e){
		    var _temp=jQuery(option.subBox).find(option.subOp);
		    if(e.keyCode==13){
		        if(option._cur!=-1){
		            jQuery(this).val(_temp.eq(option._cur).text());
			        option._cur=-1;
		        }
		        jQuery(option.subBox).hide();
			    e.stopPropagation();
		    }							  
	    });
	    return this;	
    }	  
})(jQuery);

</script>

<script type="text/javascript">
    verified_email = false;  
    verified_name = false;    
    verified_password = false;
    verified_confirmation = false;
    verified_agreement = false ;
    verified_vvc = false;
    function validateResult(msg){
        this.code = -1;
        this.message = "null" ;
        if(typeof(msg) == "string"){
          var sepPos = msg.search(/,/);
          this.code = parseInt(msg.substring(0,sepPos),10);
          this.message = msg.substring(sepPos+1,msg.length);
        }
       this.isSuccess = function(){return this.code == 0 ;}     
       this.toString=function(){return "CODE:"+this.code+" MESSAGE:"+this.message ; }      
    }
    function updateVVC(){
    	 var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo(FILENAME_CREATE_ACCOUNT)) ?>");     
     	jQuery.get(url,{"action":"updateVVC",'random':Math.random()},function(data){
                    jQuery("#vvc").attr('src', data); 
           });
    }
    function verifyVVC(){
    	verified_vvc = false;
        var vvc = jQuery("#vvcInput").val();       
    	var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo(FILENAME_CREATE_ACCOUNT)) ?>");   
    	var doSubmit = arguments.length>0;  
    	if(vvc == ""){
    		jQuery('#verify_vvc').html('<span class="errorTip">������ͼƬ����ʾ���ַ��������ִ�Сд��</span>');
			jQuery('#verify_vvc').fadeIn("slow");
			return ;
    	}
    	jQuery.get(url,{"action":"validate","data":vvc,"validator":"vvc"},function(data){
                     result = new validateResult(data);                   
                     if(result.isSuccess()){
                    	 verified_vvc = true;             			
                    	jQuery('#verify_vvc').html('<span class="rightTip">��֤��������ȷ��</span>');
                    	jQuery('#verify_vvc').fadeIn("slow");
                    	 if(doSubmit)dosubmit();
         			}else{
         				jQuery('#verify_vvc').html('<span class="errorTip">'+result.message+'</span>');
         				jQuery('#verify_vvc').fadeIn("slow");
         			} 
          });
    }
    function verifyName(){    	
    	 verified_name = false;
         var name = jQuery.trim(document.regform.firstname.value);
         var error = '';
         if(name == ''){
             error = "����д��������������ƴ����";
             verified_name = false;
         }else if(name.length < 2){
        	 error = "����д����ȫ����";
        	 verified_name = false;
         }else{
        	 var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo(FILENAME_CREATE_ACCOUNT)) ?>");  
        	 var doSubmit = arguments.length>0;     
        	jQuery.get(url,{"action":"validate","data":name,"validator":"name"},function(data){
                         result = new validateResult(data);
                         var verify = jQuery('#verify_firstname');
                         if(result.isSuccess()){        			
                        	jQuery('#verify_firstname').html('<span class="rightTip">������������ע�ᡣ</span>');
                        	jQuery('#verify_firstname').fadeIn("slow");
                        	 if(doSubmit)dosubmit();
             			}else{
             				
             				jQuery('#verify_firstname').html('<span class="alertTip">'+result.message+'</span>');
             				jQuery('#verify_firstname').fadeIn("slow");
             			} 
              });
        	verified_name = true;
         }
		if(error != ""){			
			jQuery('#verify_firstname').html('<span class="errorTip">'+error+'</span>');
			jQuery('#verify_firstname').fadeIn("slow");
		}
    }
    
    function verifyEmail(){
       if(jQuery("#suggest").css("display") !="none") {return false;}    
    	verified_email = false;
        var email_address = jQuery.trim(document.regform.email_address.value);        
        var emailPat = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        if(email_address!="" && email_address.match(emailPat)!=null){
            var url = url_ssl("<?php echo preg_replace($p,$r,tep_href_link_noseo(FILENAME_CREATE_ACCOUNT)) ?>");      
            var doSubmit = arguments.length>0;     
            jQuery.get(url,{"action":"validate","data":email_address,"validator":"email"}
                    ,function(data){
                        result = new validateResult(data);
                        var verify = jQuery('#verify_email');
                        if(result.isSuccess()){
            				verified_email = true;
            				verify.fadeOut("slow");
            				verify.html('<span class="rightTip">���������ַ����ע�ᡣ</span>');
            	        	verify.fadeIn("slow");            	        	
            	        	if(doSubmit)dosubmit();            	        	 
            			}else{
            				verify.html('<span class="errorTip">'+result.message+'</span>');
            				verify.fadeIn("slow");
            			} 
                        });
        } else{
        	var verify = jQuery('#verify_email');
        	verify.html('<span class="errorTip">��������Ч�������ַ��</span>');
        	verify.fadeIn("slow");
        }
        return verified_email;
    }

    function verifyPassword(fullcheck){          
    	verified_password = false;
    	var verify = jQuery('#verify_password') ;
    	var password = document.regform.password.value;
    	
    	if(typeof(fullcheck)!= 'undefined'){
    		if(password.length < 5){
    			verify.html('<span class="errorTip">������5-12���ַ������롣</span>');
            	verify.fadeIn("slow");
            	return false;
    		}
        }   
		if(password.length < 5) return ;
    	if(password.length < 5 || password.length > 12){
    		verify.html('<span class="errorTip">������5-12���ַ������롣</span>');
        	verify.fadeIn("slow");
        	return false;
    	}
    	if(password.match(/^[0-9]{5,12}$/)){
    		verify.html('<span class="normalTip">���밲ȫ�ȣ�<b class="on">��</b><b>��</b><b>ǿ</b></span>');
    		verify.show();
    	}else if(password.match(/^[a-zA-Z0-9]{5,12}$/)){
    		verify.html('<span class="normalTip">���밲ȫ�ȣ�<b>��</b><b  class="on">��</b><b>ǿ</b></span>');
    		verify.show();
    	}else if(password.match(/^[a-zA-Z0-9@\?-_\$%&=\*\)\(]{5,12}$/)){
    		verify.html('<span class="normalTip">���밲ȫ�ȣ�<b>��</b><b >��</b><b  class="on">ǿ</b></span>');
    		verify.show();
    	}else{
    		verify.html('<span class="normalTip">���밲ȫ�ȣ�<b>��</b><b  class="on">��</b><b >ǿ</b></span>');
    		verify.show();
    	}
    	verified_password = true;
    }

    function verifyConfirmation(){ 
    	verified_confirmation = false    ;	
        if(document.regform.password.value == "") {
        	var verify = jQuery('#verify_password') ;
        	verify.html('<span class="errorTip">������5-12���ַ������롣</span>');
        	verify.fadeIn("slow");
        	document.regform.password.focus();
        	return ;
        }            	
    	var verify = jQuery('#verify_password2') ;
        if(document.regform.password.value == document.regform.confirmation.value){        	      	
        	verified_confirmation = true;  
        	jQuery("#verify_password2").fadeOut("slow");      	
        }else {
        	verify.html('<span class="errorTip">�����������벻һ�¡�</span>');
        	jQuery("#verify_password2").fadeIn("slow");
        }
        
    }

    function dosubmit(){
		console.log('verified_email=' + verified_email);
		console.log('verified_name=' + verified_name);
		console.log('verified_password=' + verified_password);
		console.log('verified_confirmation=' + verified_confirmation);
		console.log('verified_vvc=' + verified_vvc);
		console.log('================');
    	if(verified_email == true && verified_name == true&& verified_vvc == true && verified_password==true &&verified_confirmation == true ){         		
            //return true;
			jQuery('form[name="regform"]').submit();
    	} else {
			return false;	
		}
		
    }
    
    function validateFormData(){
    	if(verified_email == false) verifyEmail(1);
    	if(verified_name == false) verifyName(1);
    	if(verified_password == false) verifyPassword();
    	if(verified_confirmation == false) verifyConfirmation();
    	if(verified_vvc == false) verifyVVC(1);
    	dosubmit();    	

		return false;
    }
    </script>
<link rel="stylesheet" href="/templates/Original/page_css/login_reg.css"/>
<div class="pathLinks borderB_e6e6e6">�����ڵ�λ�ã�<a href="<?php echo HTTP_SERVER?>">��ҳ</a> &gt; ע�����û�</div>
<?php if ($messageStack->size('create_account') > 0) {
	 echo '<div style="margin:8px;">' . $messageStack->output('create_account') . "</div>"; 
}?>
<div class="loginContent">
<?php #$isPointCardUser = $pointcards_id_display = 'S-58454511545674';?>

  <div class="tip"><?php if($isPointCardUser){?>
  ��ʾ������ӵ��$2�����޸ĸ�����Ϣ�ٻ��$8��<a class="font_bold font_size14" href="<?php echo tep_href_link(FILENAME_LOGIN)?>">�����ʺ�ֱ�ӵ�¼</a>
  <?php }else{?>
  ��ʾ��������Ѿ�ע��<strong>��USITRIP����Ա</strong>����ֱ��<a href="<?php echo tep_href_link(FILENAME_LOGIN)?>" class="font_bold font_size14">��¼</a>
  <?php }?></div>
    <form name="regform" action="<?php echo tep_href_link(FILENAME_CREATE_ACCOUNT,'','SSL')?>"  method="POST"   enctype="application/x-www-form-urlencoded" onsubmit="">
  <div class="regtext">
            <?php if($pointcards_id_display){?>
          <dl>
            <dt><em class="color_orange">*</em>����:</dt>
            <dd><?php echo $pointcards_id_display;?><?php echo tep_draw_hidden_field('pointcards_code',$pointcards_code)?> </dd>
           </dl>
          <dl class="even">
            <dt>&nbsp;</dt>
            <dd><span ></span></dd> </dl>
          <?php }?>
    <dl style="z-index:1;position:relative">
      <dt><em class="color_orange">*</em> <?php if ((int)$Admin->login_id > 0) {?>�ͻ�<?php }else{?>����<?php }?>�ʼ���ַ:</dt>
      <dd>
        <?php echo tep_draw_input_field('email_address',$_POST['email_address'],'tabindex="2" id="email_address" class="box1" autocomplete="off" onfocus="jQuery(\'#email_address\').addClass(\'on\');jQuery(\'#verify_email\').fadeOut(\'slow\')" onblur="jQuery(\'#email_address\').removeClass(\'on\');verifyEmail()"');?>
        <span class="color_b3b3b3">������<?php if ((int)$Admin->login_id > 0) {?>�ͻ�<?php }else{?>������<?php }?>�ĵ������䣬�����ڵ�¼�����ܶ���֪ͨ�ȡ� </span>
        <div class="suggest" id="suggest"></div>
        </dd>
    </dl>
    <dl class="even">
          <dt>&nbsp;</dt>
          <dd><span id="verify_email" style="display:none;"></span></dd>
    </dl>
    <dl>
      <dt><em class="color_orange">*</em> <?php if ((int)$Admin->login_id > 0) {?>�ͻ�<?php }else{?>����<?php }?>����:</dt>
      <dd>
        <?php echo tep_draw_input_field('firstname' , $_POST['firstname'],' tabindex="3" id="firstname"  class="box1"  onblur=" jQuery(\'#firstname\').removeClass(\'on\'); verifyName();"  onfocus="jQuery(\'#firstname\').addClass(\'on\');jQuery(\'#verify_firstname\').fadeOut(\'slow\')"')?>
        <span class="color_b3b3b3">������2���ַ��������Ǻ��ֻ�ƴ����</span></dd>
    </dl>
    <dl class="even">
            <dt>&nbsp;</dt>
            <dd><span id="verify_firstname" style="display:none;"></span></dd>
    </dl>
    <?php 
    // ����ǿͷ������ע��,�򲻳���������������֤��
    if ((int)$Admin->login_id == 0) {?>
    
    <dl>
      <dt><em class="color_orange">*</em> ��������:</dt>
      <dd>
        <?php echo tep_draw_password_field('password' ,'','tabindex="4" id="pass" class="box1"  onkeyup="verifyPassword();"  onfocus="jQuery(\'#pass\').addClass(\'on\');jQuery(\'#verify_password\').fadeOut(\'slow\');" onblur="jQuery(\'#pass\').removeClass(\'on\');verifyPassword(0);"')?>
        <span class="color_b3b3b3">5-12���ַ������������֡�Ӣ�ġ�������ɡ� </span></dd>
    </dl>
    <dl class="even">
            <dt>&nbsp;</dt>
            <dd><span id="verify_password" style="display:none;"></span></dd> 
    </dl>
    <dl>
      <dt><em class="color_orange">*</em> ȷ������:</dt>
      <dd>
        <?php echo tep_draw_password_field('confirmation' ,'','tabindex="5" class="box1" id="pass2"  onfocus="jQuery(\'#pass2\').addClass(\'on\');jQuery(\'#verify_password2\').fadeOut(\'slow\')" onblur="jQuery(\'#pass2\').removeClass(\'on\');verifyConfirmation()"')?>
        <span class="color_b3b3b3">��������һ�����롣 </span></dd>
    </dl>
    <dl class="even" id="verify_password2_warp"  >
            <dt>&nbsp;</dt>
            <dd><span id="verify_password2" ></span></dd> 
    </dl>
    <dl>
      <dt><em class="color_orange">*</em> �� ֤ ��:</dt>
      <dd class="verification" ><?php echo tep_draw_input_field('visual_verify_code' ,'','tabindex="6" id="vvcInput" class="box2"  onfocus="jQuery(\'#vvcInput\').addClass(\'on\');jQuery(\'#verify_vvc\').fadeOut(\'slow\')" onblur="jQuery(\'#vvcInput\').removeClass(\'on\');verifyVVC()"' )?> 
        <img src="<?php echo $RandomImg?>"  onclick="updateVVC()" align="absmiddle" id="vvc" width="75" height="25"  alt="������?�����һ��ͼ��" title="������?�����һ��ͼ��"/> <a href="javascript:;" onclick="updateVVC()">������?�����һ��ͼ��</a></dd>
    </dl>
    <dl class="even" id="vvc_warp"  >
            <dt>&nbsp;</dt>
            <dd><span id="verify_vvc" ></span></dd>
    </dl>
    <?php }?>
    <dl class="dlbtn">
      <dt></dt>
      <dd>
        <input type="submit" class="submit" value="ͬ�����ǵ�Э�鲢ע��" onclick="return validateFormData()"/>
      </dd>
    </dl>
	<div>
          <input type="hidden" name="action" value="process">
          <!--<a href="javascript:;"   class="btn btnOrange btnReg"  onclick="validateFormData();">
          <button type="button" tabindex="7">ͬ������Э�鲢ע��</button>
          </a>--> </div>
        <div class="agreement">
          <h3>�������ġ�ͬ�����ǵ�Э�鲢ע�ᡱ������ʾ��ͬ��������ǵ�<a target="_blank" href="<?php echo tep_href_link('order_agreement.php')?>">����Э��</a>��</h3>
          <?php /*<div class="agreementCon" >
            <p>����Ԥ���͹������ķ�����usitrip.com����վ�ϵ��������Լ���������صĲ�Ʒǰ��ϸ�Ķ��˹˿���֪�ĸ�������Ա�����ȫ���˽�˫����Ȩ�������Ρ���Ϊ���ķ����Ĺ˿ͣ���������ͬ�����Ķ������ݣ���Ⲣͬ�����¸���������޳�����������, ����������һЩ���£� ���ķ����������ս���Ȩ�� </p>
            <br>
            <p style="padding-bottm:10px;">���ķ���ע���̱�<img src="image/logo_s.gif" alt="���̱�����ķ������С�" title="���̱�����ķ������С�" style="vertical-align:middle;" />��</p>
            <p> <strong>����Ȩ�� </strong><br>
              ����������;�л�Ϊ�����Ƽ��Է���Ŀ���������������Ƿ�μӡ�<br />
              �г��е�������Υ����֮ͬ�����ÿ���Ȩ���ơ��������飬���ÿͺ͵��������Ѻ�Э�̣����뼰ʱ�������Ƿ��������ǽ�Э�������Ϊ����Ч��ά���ÿ͵����棬���ÿ������˿�ʼǰ�������ǵ��⡣�г̽���֮���Ͷ�ߣ�����֤��֤���������籣�����������Ȩ����<br/>
              ��·��Ʒ���Ҫ�أ���Ϊ�������ķ����ϸ�����ѡ���ľ߱�������ʵĵؽ����ṩ�����ķ���ֻ����Ӳ����ʩ�ȱ�׼�������ͳ�ŵ�е����Σ��������������ѹ����п����漰����Ա���Է�����߲��ɿ�����ɵĲ���е����Ρ� </p>
            <br>
            <br>
            <p> <strong>�����ʸ�</strong><br>
              ��������18���18�����ϵĸ��塣 �����δ��18��, �������ڸ�ĸ���ɼ໤�˵Ĵ�����ʹ�����ķ����� </p>
            <br />
            <p> <strong>��������</strong> <br>
              ����Ԥ��ǰ, ���������Ķ����к�����Ҫ�����ŵ������Ϣ�������ü۸���֪ͨ��·�߽��ܡ� �ŷѰ�����Щ����������Щ��ȡ�����˿����ߡ���������Լ��ر���ʾ�ȡ�һ�����Ķ������������������ݺ��ڹ����Ͳ������κ����顣 </p>
            <br />
            <p> <strong>��Ʊ���򼰵��Ӱ���Ʊ</strong> <br>
              1.�����ύԤ��֮���������ͨ��E-Mail�յ�һ��Ԥ���վݡ�<br>
              2.�����ύԤ����һ�����������ڣ������յ����Ƿ�������ȷ���ʼ���<br>
              3.���Ӱ���Ʊ����������ǰ�Ķ������죬���߸����ʱ���ڣ�ͨ���ʼ����͸������ڵ��Ӱ���Ʊ�����ǻ��ṩ�����ŵ�������ϸ��Ϣ��Ϊ�����ķ������ٴ�ȷ�ϣ����������Ź�Ӧ�̵���Ϣ���ǽ�һ�����͸�����<br>
              4.��ֻ��Ҫ��ӡ�����ĵ��Ӱ���Ʊ�����ڳ��ŵ��츽����������Ƭ����Ч���֤����ʾ�����α�����ˡ� ���ס�����Ӱ���Ʊ�����Ĺ���ƾ֤��</p>
            <p>�������ڳ���ǰ��ϵ���ĺ���͵��������Ź�Ӧ�����ٴ�ȷ�����ĵִ�ӻ����� </p>
            <br />
            <p> <strong>��˽�������ռ� </strong><br>
              ���ķ��� ����վ�ռ���Ϣ��Ψһ�����ߣ� ���ǲ������Ϣ����������������޸��κ����塣���ķ��� �Ӳ�ͬ��վ���ռ��û���Ϣ�����Դ������͸��õ��������ϢΪ��������Ϣ�������������͵�ַ���ʻ���ַ���绰���롢�����ʼ���ַ�Լ�������Ϣ���������ÿ������ķ��� ����Ҫ���ύ�����û����������Ա����������Ϣ�����ñ�֤�����û����������ǻ��ܵĲ������������κ��˷��� </p>
            <p> ���ķ�������Ϣ��ȫʹ�ý�����<a class="sp3" href="privacy-policy.php">��˽�Ͱ�ȫ����</a>����ϸ����. ���ķ�������˽�Ͱ�ȫ�����Ǵ�Э���һ���֣�������ͬ��������Ƕ������ἰ���ݵ�ʹ��Ȩ������֮Ϊ�ַ�������˽�͹���Ȩ����<br>
              <br>
            <p> <strong>ע�ἰ��¼ </strong><br>
              Ϊ�����������㼰ʱ�ز������ķ����Ƴ���һЩ�Żݻ�����ǿ��ܻ����ã�������¼�������ķ���ע���Աʹ�õ����䲢������ķ���ע����߻���ʼ���Ϣ���ӵ������ķ���ʱ�����ķ�����Ĭ�����Ѿ���¼�����ķ�����վ�����ķ���ȷ������й©�����κθ�����Ϣ���������ȷ��������İ�ȫ��</p>
            <br>
            <br>
            <p> <strong>���α���</strong><br>
              ���ķ��� ǿ���Ƽ�������ҽ�ơ��г�ȡ���Լ�����ȱ�����Ŀ�����ķ��� ���ݲ��ṩ�κ��г̰��ţ���վ���г������β�Ʒ�����ɶ����������Ź�Ӧ����ʵʩ�����ġ������������Ź�Ӧ�̡����͡��۹���ù�ס�޵Ĵ����̡����ķ��� ���������¹ʳе��κ����Σ�������ʧ����Ʒ���Ȼ���Ա��;���������Լ�һ�е��Ƴ١������������������˻���ѭ���չ�˾���Ƶ�͹���������˾��ָ���Ĺ������ķ��������κ��������������Ź�Ӧ�̻���������۶�����Ŀ������𺦸��𣬰���һ���漰������վ��ʹ����վ����Ϣ�����ˣ������÷����κ�������ķ����Լ��������г�Ա���������������ۡ� </p>
            <br />
            <br>
            <p> <strong>�����޸ĺ�ȡ��</strong> <br>
              �����Ź�Ӧ�̻ᾡ����֤�г̰��ź�Ԥ�Ƶı���һ�¡���Ϊ�˱�֤�г�˳��, �����Ź����̱�����������������ͨ��������������ʱ�������Ϻ�����һЩ�޷����Ƶ�ԭ�������¶��г̸��ġ��Ƴٺ�ȡ����Ȩ����<br>
              �����Ź�Ӧ�̱����ڳ���ǰ����������������Գ��ŵ������ȡ���г̵�Ȩ�������ķ�������ǰ֪ͨ��<br>
              �����Ź�Ӧ�̱�����Ϊ�������������������������Ȩ����<br>
              �����Ź�Ӧ��������ʱ��ȡ����Ϊ, �������������������������ǡ�����Ϊ�����ķ�����ȫ�޹أ��������ķ�����ȫ��Э�����ķ������ȡȨ�ˡ�<br>
            </p>
            <br />
            <p> <strong>���պ�ǩ֤</strong> <br>
              ��������Я��һ������֤����/������/������ѡ��·���й����������һ�бر�֤������ͬ�������˻��в�ͬ���뾳���ɡ����ķ��� ���ᱣ���˿͵�˽������֤�����ǳе�֪ͨÿ��������������֤�������Ρ���Ҫ�е�����ȱ������֤������ɵ��Ƴٻ��г̸��ĵ����з��á� </p>
            <p> ��Ӧ���ϸ����ط����Լ��������������������ķ��棬��������ͺ��ط��������ȡ����ķ��� ����������Υ������������������������ķ����</p>
            <br />
            <p> <strong>�۸�ȡ���Լ��˿�����</strong> <br>
              ���е����β�Ʒ�۸�������Ԫ���㡣 ��ͬʱ�ڵļ۸��������ͬ�� ���磬�۸��ڽڼ��ջ����������� ���м۸���Ҫ����ȷ�ϡ� ����ϸ�����ǻ���<a class="sp3" href="cancellation-and-refund-policy.php">ȡ�����˿�����</a>.���ķ��� ��ȡ�����˿������Ǵ�Э���һ���֣�����Ԥ��ǰ��Ҫȷ���Ѿ��Ķ���ͬ�����������ݡ� </p>
            <br />
            <p> <strong>��������Ͷ��������һ����</strong><br />
              ֻ�����õ���������Ч�������г�ȷ�Ϻ�����޸Ļ�ȡ������Ҫ����һ���ķ��á���ǰ�ڳ�����7�켰����ȡ����Ѳ������г̣���������ȡ$30.00��ȡ�����á���ǰ�ڳ�����7������ȡ����Ѳ������г̣�����ȡ�����˿����������շѡ�����Ѳ������ڳ��ŵ���ȱϯ��������ÿ�����趨�ı�׼������ȡһ�������ķ���ÿ�ˣ��������ɵ������ֽ�ķ�ʽǿ���Դ����������˴���ȡ��<br />
              ����������ķ���ȡ�����˿���������Ϣ��ο�ȡ�����˿����������ķ����ͻ�Э�顢ȡ�����˿�����������Э�����ݡ�ͬ��Э���ʾ����Ԥ��ǰ�Ѿ��Ķ���ͬ��Э�����ݡ� </p>
            <br />
            <p> <strong>�����˿�</strong><br>
              �����ö����ķ��� ʹ��Discover, MasterCard, VISA, American Express ���κ��������ÿ��ĵ��Ӽ�¼�˿���������顣ͬ�����ķ��� ͨ�������ʼ���������, ���������ṩ�ķ��������ʼ���ʽ���͵ġ�������Ҫ����Ʊ������ȡ�����ʼģ����ܵ����ʼ���Ϊ���ͷ�ʽ��֪ͨDiscover, MasterCard, VISA, American Express �ͷ������ÿ����������ǻ�ͨ�������ʼ�������Ϊ����Ԥ������������ķ��� �����ṩ���Ӱ���Ʊ�Ѿ�ͨ�������ʼ����ͳ�ȥ���ṩ����ϵͳ��¼���ݺ�ʱ��֤����������ͨ�����棨�ṩ��ʾ�Ѵ��͵�ָ���������ɹ��ĸ�ӡ��֤����������ͨ���ʼģ��ṩ�ض�ĳ��������������������Ͷ����Ʊ��ǩ�������������Ͳ��ö��ѻ�ȡ����������շ��ý������ۡ� <br>
              �����ò������Ķ��շѽ������ۡ����������ķ�������ͬ������������˿ ��������ʵ��������˿�(ֻҪ ���ķ��� �ж�)�������˻����з��á�������������������˿�������ṩһ����д�����ÿ���˾��ȷ�������Ǻ���������������������һ�ݴ��ż��ĸ��������ķ�����
              ���ڴ���վ�����˿���ķ�������ȡ�����ж�����ȡ�أ�����ȡ�����˿���á� ������ķ������ϳɹ����������е����Ϸ��á� </p>
            <br />
            <p><strong>���λ���</strong><br>
              ���ķ������������˿��ṩ��ȷ�����ƺ����µ���Ϣ����Ҳ���ų�����һЩ�������Ű��ϵĴ�����ڡ��˿���ʹ��ǰ��������к�ʵ��������Ȩ�ڲ���ǰ֪ͨ����������κ��޸ĺ͸��¡��˿����ге�����ʹ����վ��Ϣ�����з��ա����ǻ��ṩһЩ������վ�������Է��������ʡ���Щ��վ�����ķ������κι�ϵ�����ǲ������ṩ���ݸ�������ѡ��ʱҪ��߾��裬������ʹ��ʱ��Ⱦ�������������κ��𺦡�<br>
              <br>
              <strong>��������</strong><br>
              ��Э����ѭ���������������������ݷ���֮���ݣ������䷨������ִ���һ���˿Ͷ����ķ����Ľ���ʹ�ò��������ṩ֮���񣬼���Ϊͬ��������ɼ�ͼ��������Ƿ�Ժ���еĸ���ר����ϽȨ�������ͬ��������������ɼ����ڷ�Ժ�涨֮���з������һ����Э���е����������Ч���ǿ���ԵĹ涨���ù涨��������޶ȵĵõ�ǿ��ִ�С�ǿ�ƹ����а����������涨��Ȼ���ӳ�ַ���Ч�������ķ�����֧�ֻ�ǿ��ִ�и�Э�����κι涨����Ϊ����Ϊ���κ�Ȩ�޺͹涨����Ȩ����Э�������������ķ������Ʒ��Ӧ�̻��κ�������˾������������������ʺʹ���ȹ�ϵ֮ƾ֤�����ݡ���Ʒ��Ӧ�̺��κ�������˾�������Ȩ�����ķ�����������ʹ�κ������ְ�𡣸�Э���ǹ˿ͺ����ķ�������Թ˿Ͷ����ķ�����ʹ�ö��ƶ��ġ�</p>
          </div> */ ?>
        </div>

    <div class="del_float"></div>
  </div>
  </form>
</div>
<script type="text/javascript">
jQuery("#email_address").autoComplete();
</script>
<?php 
	echo db_to_html(ob_get_clean());
	if($messageStack->size('create_account') > 0 ) echo $messageStack->output_newstyle('create_account','verify_email');
 ?>

<script language="javascript" charset="gb2312"><!--
function checkForm() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";


 if (document.product_question_answer_write.replay_name.value == "") {
    error_message = error_message + "* ����д��������.\n";
    error = 1;
  }
  
  if (document.product_question_answer_write.replay_email.value == "") {
    error_message = error_message + "* ����������E-mail��ַ.\n";
    error = 1;
  }else{
    if (document.product_question_answer_write.replay_email.value != document.product_question_answer_write.c_replay_email.value) {
    error_message = error_message + "* ȷ��E-mail��ַ���������E-mail��ַ�Ǻ�.\n";
    error = 1;
	}  
  }
  
  if (!validEmail(document.product_question_answer_write.replay_email.value) && document.product_question_answer_write.replay_email.value != "")
{
		
		error_message = error_message + "* ��������ȷ��Ч�������ַ.\n";
    	error = 1;
}

   if (document.product_question_answer_write.anwers.value == "") {
    error_message = error_message + "* ���Ļش�.\n";
    error = 1;
  }
 
  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}
function validEmail(strEmail)
{	
	
	
    if (strEmail.search(/[A-Za-z0-9\._]+\@[A-Za-z0-9\-]+\.[A-Za-z0-9\.]/gi) != -1)
		return true;
    else
        return false; 
}	
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}
//--></script>

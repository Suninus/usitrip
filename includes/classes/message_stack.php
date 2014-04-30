<?php
/*
  $Id: message_stack.php,v 1.1.1.1 2004/03/04 23:40:44 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License

  Example usage:

  $messageStack = new messageStack();
  $messageStack->add('general', 'Error: Error 1', 'error');
  $messageStack->add('general', 'Error: Error 2', 'warning');
  if ($messageStack->size('general') > 0) echo $messageStack->output('general');
*/
//Lango Added for template mod: BOF
  class messageStack extends tableBoxMessagestack {
//Lango Added for template mod: EOF

// class constructor
    function messageStack() {
      global $messageToStack;

      $this->messages = array();

      if (tep_session_is_registered('messageToStack')) {
        for ($i=0, $n=sizeof($messageToStack); $i<$n; $i++) {
          $this->add($messageToStack[$i]['class'], $messageToStack[$i]['text'], $messageToStack[$i]['type']);
        }
        tep_session_unregister('messageToStack');
      }
    }

// class methods
/**
 * ���һ����Ϣ����Ϣ��ջ
 * vincent �޸���֧���µĽ���Ҫ��
 * @param string $class ��Ϣ��Χ
 * @param string $message ��Ϣ����
 * @param string $type ��Ϣ���� error, warning,successĬ���Ǵ���
 *@param string $uiTarget Ҫ���Ӹô���ĳ��UIĿ��
 * @author vincent
 * @modify by vincent at 2011-5-6 ����01:15:00
 */
    function add($class, $message, $type = 'error',$uiTarget='') {
      if ($type == 'error') {
        $this->messages[] = array('params' => 'class="messageStackError"','type'=>$type,'target'=>$uiTarget, 'class' => $class, 'msg'=>$message ,'text' => tep_image(DIR_WS_ICONS . 'error.gif', ICON_ERROR) . '&nbsp;' . $message);
      } elseif ($type == 'warning') {
        $this->messages[] = array('params' => 'class="messageStackWarning"','type'=>$type,'target'=>$uiTarget, 'class' => $class, 'msg'=>$message ,'text' => tep_image(DIR_WS_ICONS . 'warning.gif', ICON_WARNING) . '&nbsp;' . $message);
      } elseif ($type == 'success') {
        $this->messages[] = array('params' => 'class="messageStackSuccess"','type'=>$type, 'target'=>$uiTarget,'class' => $class,'msg'=>$message , 'text' => tep_image(DIR_WS_ICONS . 'success.gif', ICON_SUCCESS) . '&nbsp;' . $message);
      } else {
        $this->messages[] = array('params' => 'class="messageStackError"','type'=>$type, 'target'=>$uiTarget,'class' => $class, 'msg'=>$message ,'text' => $message);
      }
    }

    function add_session($class, $message, $type = 'error') {
      global $messageToStack;

      if (!tep_session_is_registered('messageToStack')) {
        tep_session_register('messageToStack');
        $messageToStack = array();
      }

      $messageToStack[] = array('class' => $class, 'text' => $message, 'type' => $type);
    }

    function reset() {
      $this->messages = array();
    }

    function output($class, $output_type='html') {
      $this->table_data_parameters = 'class="messageBox"';

      $output = array();
	  for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
        if ($this->messages[$i]['class'] == $class) {
          $output[] = $this->messages[$i];
        }
      }
//Lango Added for template mod: BOF
	  if($output_type=='text'){
	  	$text = "";
		foreach((array)$output as $key => $val){
			$text.= $output[$key]["msg"]."<br />";
		}
		return preg_replace('/\<br \/\>$/','',$text);
	  }
      return $this->tableBoxMessagestack($output);
//Lango Added for template mod: EOF
    }
    /**
     * ��ȡ�����ջ����Ϣ����
     * @param unknown_type $class
     * @author vincent
     * @modify by vincent at 2011-5-24 ����09:51:23
     */
    function output_array($class){
   		$output = array();	     
	    for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
	      if ($this->messages[$i]['class'] == $class) {
	          $output[] = $this->messages[$i];
	     }
	    }
	    return $output;	   
    }
   /**
    * �������Ϊ�µ���ʽ
    * @param string $class Ҫ��ʾ����Ϣ��Χ
    * @param string $defaultUITarget null �Ƿ�ǿ�ƽ����󸽼ӵ�����Ԫ��,���ں�֮ǰ�Ĵ�����Ϣ��������Ϊnull�򲻻��޸Ľ���Ŀ��
    * @author vincent
    * @modify by vincent at 2011-5-6 ����01:28:41
    */
  function output_newstyle($class,$defaultUITarget = null,$showLastError =false ){
	      $output = array();	     
	      for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
	        if ($this->messages[$i]['class'] == $class) {
	          $output[] = $this->messages[$i];
	        }
	      }
	      $outputHtml = '';
	      $outputJs = '';
	      //ֻ��ʾ���һ������
	      if($showLastError){
	      	$output = array(array_pop($output));
	      }
	     
	      foreach($output as $msg){
	      	//ѡ��ͼ��
	      	switch($msg['type']){
	      		case 'error':$icon = 'errorTip';break;
	      		case 'warning':$icon = 'alertTip';break;
	      		case 'success':$icon = 'successTip';break;
	      		default: $icon = strtolower($msg['type']);break;
	      	}
	      	$msgText = '<span class="'.$icon.'">'.$msg['msg']."</span>";
	      	if($defaultUITarget !== null && $msg['target'] == '' ) $msg['target'] = $defaultUITarget;
	      	if($msg['target'] == ''){
	      		$outputHtml.= 	$msgText;
	      	}else{
	      		$outputJs.= 'jQuery("#'.$msg['target'].'").append( "'.format_for_js($msgText).'");jQuery("#'.$msg['target'].'").fadeIn("slow");';
	      	}
	      }
	      $return  = '';
	      if($outputHtml != '') $return .= $outputHtml ;
	      if($outputJs != '')$return .= '<script type="text/javascript">'.$outputJs.'</script>';
	      return $return;
  }

    function size($class) {
      $count = 0;

      for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
        if ($this->messages[$i]['class'] == $class) {
          $count++;
        }
      }

      return $count;
    }
  }
?>

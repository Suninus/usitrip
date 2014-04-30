<?php
/**
 * �쳣��
 * @author lwkai 2013-1-31 ����2:04:54
 *
 */
Class My_Exception extends Exception {
	public function __construct($type = 'exception',$message) {
		//parent::__construct($message);
	}
	
	static public function mythrow($type,$message,$sql = '') {
		switch(strtolower($type)) {
			case 'notfind':
				$_SESSION['err_message'] = $message;
				$url = 'Location:' . DIR_WS_ROOT . 'error';
				header($url);
				break;
			case '404':
				$_SESSION['err_404'] = $message;
				header('Location:' . DIR_WS_ROOT . 'error/fzf');
				break;
			case 'dberr':
				if (DEBUG == true) {
					echo 'DEBUG ������Ϣ�� SQL��' . $sql . '��ϣ��������رյ��ԣ������ļ��У��ر�DEBUG';
				} else {
					echo $message;
				}
				break;
			case 'rare_convert':
			case 'ioerror':
			default:
				if (DEBUG == true) {
					echo $sql;
				}
				throw new Exception($message);
		}
		exit();
	}
	
	function __toString(){
		
	}
}
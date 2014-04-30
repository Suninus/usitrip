<?php
/**
 * ����������
 * @author wtj
 * @date 2013-9-24
 */
class DownLoad {
	//private $xml_path = 'download/file/down_load.xml';
	private $xml_path = 'images/down_load.xml';
	private $xml_handle;
	private $click_array = array ();
	private $click;
	private $file_path;
	private $file_name;
	private $node_number;
	/**
	 * ���췽������ʼ��XML�ĸ��ֱ���
	 * @param string $file_name ��Ҫ���ص��ļ���
	 */
	function __construct($file_name = '') {
		$this->file_name = $file_name;
		$this->xml_handle = simplexml_load_file($this->xml_path);
		if ($this->xml_handle) {
			$i = 0;
			$mark = true;
			foreach ($this->xml_handle->file as $file) {
				$this->click_array[(string)$file->fileName]['downNumber'] = (string)$file->downNumber;
				$this->click_array[(string)$file->fileName]['cnName'] = iconv('utf-8', 'gb2312',(string)$file->cn_name);
				$this->click_array[(string)$file->fileName]['img'] = $this->getImg((string)$file->fileName);
				if ($file_name && $file_name == (string)$file->fileName) {
					$this->click = (string)$file->downNumber;
					$this->file_path = (string)$file->filePath;
					$mark = false;
				}
				if ($mark)
					$i ++;
			}
			$this->node_number = $i;
		}
	}
	/**
	 * ͨ���ļ���ʽ�ж�ҳ������ʾ��ͼ��
	 * @param string $fileName
	 * @return string
	 */
	private function getImg($fileName) {
		$tmp = explode('.', $fileName);
		$return = '';
		switch ($tmp[1]) {
			case 'doc':
				$return = 'down_icon_01.gif';
				break;
			case 'docx':
				$return = 'down_icon_01.gif';
				break;
			case 'pdf':
				$return = 'down_icon_02.gif';
				break;
			default:
				$return = 'down_icon_01.gif';
				break;
		}
		return $return;
	}
	/**
	 * �����ļ�
	 */
	function downFile() {
		$this->addOneRecode();
		$size=filesize($this->file_path);
		$fileext  = substr(strrchr($this->file_name,'.'),1);
// 		header('Content-Type: '.$fileext);
		header("Content-Type: application/msword");
		header("Content-Type: application/force-download");
		header('Content-Type: application/octet-stream');
		header("Content-Type: application/download");
		header("Content-Transfer-Encoding:binary");
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
// 		header("Content-Disposition: attachment; filename=" . $this->file_name . '; modification-date=' . date('r') . ';');
		header("Content-Disposition: attachment;filename=".$this->file_name);
		header("Content-Length: " . $size);
		header("HTTP/1.0 200 OK");
		header("Status: 200 OK");
		if (file_exists($this->file_path) && $file = fopen($this->file_path, "r")) 		//�ж��ļ��Ƿ���ڲ���
{ 
// 	header("X-Sendfile: $file");
			echo fread($file, $size); //��ȡ�ļ����ݲ��¸������
			fclose($file);
		}
	}
	/**
	 * ����һ�����ش���
	 */
	function addOneRecode() {
		if($this->node_number<count($this->xml_handle->file)){
		$this->xml_handle->file[$this->node_number]->downNumber=(int)$this->xml_handle->file[$this->node_number]->downNumber+1;
		$this->xml_handle->asXML($this->xml_path);
		}
	}
	/**
	 * ����XML�����Ϣ
	 * @return string
	 */
	function getClickInfo() {
		return $this->click_array;
	}
}
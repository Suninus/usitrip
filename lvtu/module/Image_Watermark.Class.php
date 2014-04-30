<?php
class Image_Watermark {
	private $message; // �ദ���г��ֵ�����Ļ���
	/**
	 * ͼƬ��Դ���
	 *
	 * @var resources
	 */
	private $im;
	/**
	 * ͼƬ���
	 *
	 * @var float
	 */
	private $x;
	/**
	 * ͼƬ�߶�
	 *
	 * @var float
	 */
	private $y;
	private $image_type;//ͼƬ������
	private $water_im; // ˮӡͼƬ���
	private $water_x; // ˮӡͼƬ���
	private $water_y; // ˮӡͼƬ�߶�
	private $save_path;//����·��
	/**
	 * �������������
	 *
	 * @var array
	 */
	private $all_type = array(
			"jpg" => array(
					"output" => "imagejpeg" 
			),
			"gif" => array(
					"output" => "imagegif" 
			),
			"png" => array(
					"output" => "imagepng" 
			),
			"wbmp" => array(
					"output" => "image2wbmp" 
			),
			"jpeg" => array(
					"output" => "imagejpeg" 
			) 
	);
	public function __construct() {
	}
	/**
	 * ����ͼƬ�����Դ
	 *
	 * @param string $src
	 *        	//ͼƬ��·��
	 * @param ���� $name
	 *        	//im==base,water==ˮӡ
	 */
	public function createImage($src, $name = 'im') {
		if (file_exists($src)) {
			$data = file_get_contents($src);
			$im = imagecreatefromstring($data);
			switch ($name) {
				case 'im' :
					$this->im = $im;
					$this->x = $this->getImgWidth($im);
					$this->y = $this->getImagHeight($im);
					$this->image_type=image_type_to_extension($im); 
					break;
				case 'water' :
					$this->water_im = $im;
					$this->water_x = $this->getImgWidth($im);
					$this->water_y = $this->getImagHeight($im);
					break;
				default :
					$this->addMessage('����ͼƬ���ʱ��û���ṩ��ȷ�ľ������');
			}
		} else {
			$this->addMessage($src . ' ·����ͼƬ������');
		}
	}
	/**
	 * ħ������set
	 * 
	 * @param string $name
	 *        	��
	 * @param string $value
	 *        	ֵ
	 * @return Image
	 */
	private function __set($name, $value) {
		if ($name == 'water_src' || $name == 'base_src' || $name = 'save_src') {
			$this->$name = $value;
			return $this;
		}
	}
	/**
	 * ��ȡͼƬ���
	 *
	 * @param sorce $src        	
	 * @return int
	 */
	function getImgWidth($src) {
		return imagesx($src);
	}
	/**
	 * ��ȡͼƬ�ĸ߶�
	 * 
	 * @param boject $src
	 *        	ͼƬ����Դ���
	 * @return number
	 */
	function getImagHeight($src) {
		return imagesy($src);
	}
	/**
	 * ��ˮӡ
	 * @param int $type
	 */
	public function addWater($type=4) {
		$this->createImage($this->base_src);
		if($this->water_im){
			$xy=$this->countWaterXY($type);
			imagecopymerge($this->im, $this->water_im, $xy['x'], $xy['y'], 0, 0, $this->water_x, $this->water_y, 30);
		}else{
			$this->addMessage('ˮӡͼƬδ���������ȴ���ˮӡͼƬ');
		}
	}
	/**
	 * ѹ��ͼƬ
	 * @param float $x ѹ���ɵ�ͼƬ�Ŀ��
	 * @param float $Y ѹ���ɵ�ͼƬ�ĸ߶�
	 */
	public function zipImage($x,$y=null) {
		$num=func_num_args();
		switch($num){
			case 1 :
				
				break;
			case 2 :
				break;
			
		}
	}
	/**
	 * ����ͼƬ
	 */
	public function save() {
		$this->all_type[$this->image_type]['output']($this->im,$this->save_path);
	}
	/**
	 * ����ͼƬ�����·��
	 * @param string $path ·��
	 */
	public function setSavePath($path){
		return $this->getDir($path);
	}
	/**
	 * ����ͼƬ
	 */
	public function destory($im) {
		imagedestroy($im);
	}
	/**
	 * ����ˮӡͼƬ��λ��
	 * 
	 * @param int $type
	 *        	���� 1���ϣ�2���ϣ�3���£�4���£�5���У�6���У�7���У�8����
	 */
	public function countWaterXY($type) {
		switch ($type) {
			case 1 :
				$x = 0;
				$y = 0;
				break; // ����
			case 2 :
				$y = 0;
				$x = $this->x - $this->water_x;
				break; // ����
			case 3 :
				$x=0;
				$y=$this->y-$this->water_y;
				break; // ����
			case 4 :
				$x=$this->x-$this->water_x;
				$y=$this->y-$this->water_y;
				break; // ����
			case 5 :
				$x=($this->x-$this->water_x)/2;
				$y=0;
				break; // ����
			case 6 :
				$x=$this->x-$this->water_x;
				$y=($this->y-$this->water_y)/2;
				break; // ����
			case 7 :
				$x=($this->x-$this->water_x)/2;
				$y=$this->y-$this->water_y;
				break; // ����
			case 8 :
				$x=0;
				$y=($this->y-$this->water_y)/2;
				break; // ����
			case 9 :
				$x=($this->x-$this->water_x)/2;
				$y=$y=($this->y-$this->water_y)/2;
				break;
			default: $this->addMessage('�����ˮӡͼƬλ�ò���������µ���');
		}
		return array(
				'x' => $x,
				'y' => $y 
		);
	}
	/**
	 * ��ȡͼƬ����·����������ʱ����
	 *
	 * @param string $path
	 *        	·��
	 */
	function getDir($path) {
		if (is_dir($path)) {
			if ($this->createDir($path)) {
				return $path;
			} else {
				$this->addMessage('����ͼƬ��·�������ڣ��Ҵ������ɹ�����ȷ��Ŀ¼��д��Ȩ��');
			}
		} else {
			return $path;
		}
	}
	/**
	 * ����·��
	 *
	 * @param string $path
	 *        	·��
	 */
	function createDir($path) {
		$mark = true;
		$path_arr = explode('/', $path);
		$root_path = array_shift($path_arr);
		if (($root_path != '.' || $root_path != '..') && ! is_file($path)) {
			$mark = @mkdir($root_path);
		}
		$dirlist = '';
		foreach ( $path_arr as $value ) {
			if ($value != '.' && $value != '..') {
				$dirlist .= "/" . $value;
				$dirpath = $root_path . $dirlist;
				if (! file_exists($dirpath)) {
					$mark = @mkdir($dirpath);
					if (! $mark)
						break;
					$mark = @chmod($dirpath, 0777);
					if (! $mark)
						break;
				}
			}
		}
		return $mark;
	}
	public function addMessage($msg) {
		$this->message .= $msg . '<br />';
	}
	public function getMessage() {
		return $this->message;
	}
}
?>
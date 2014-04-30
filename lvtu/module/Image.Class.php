<?php
/**
 * ��ͼƬ�Ĳ����࣬��ʱֻʵ����ɾ��
 * @author lwkai by 2013-04-08
 */
class Image extends Abstract_Manage{
	
	/**
	 * ͼƬ�ߴ� 
	 * @var array('projector'=>�õ�ͼ��С,'list'=>�б�ͼ��С,'face'=>�ҵķ���ҳͼƬ��С,'min'=>�ϴ��ɹ�����ʾ��Ԥ��Сͼ,'preview'=>�õ�ͼСͼ)
	 * projector=>array('width'=>���,'height'=>�߶�,'quality'=>���ɵ�ͼƬ����[0-100])
	 * @author lwkai 2013-4-11 ����10:01:48
	 */
	private static $_size = array(
		'projector' => array('width' => 1728,'height' => 1080,'quality' => 100),
		'list'      => array('width' => 665, 'height' => 416, 'quality' => 100),
		'face'      => array('width' => 600, 'height' => 400, 'quality' => 100),
		'min'       => array('width' => 225, 'height' => 186, 'quality' => 90),
		'preview'   => array('width' => 90,  'height' => 60,  'quality' => 90)
	);
	
	/**
	 * ������Ҫ���������ݱ�
	 * @var string [travel_image]
	 */
	protected $_table = 'travel_image';
	
	/**
	 * ��ǰ�������ͱ�� ��ͼƬΪ1 ����Ϊ 2 �μ�Ϊ3��
	 * @var string
	 */
	protected $_target = 'Image';
	
	/**
	 * ��λǰ׺����
	 * @var string
	 */
	protected $_field_prefix = 'image';
	
	/**
	 * �ļ���������
	 * @return File
	 * @author lwkai 2013-4-11 ����9:29:43
	 */
	private function file() {
		if (isset($this->_obj['file']) && $this->_obj instanceof File) {
			return $this->_obj['file'];
		} else {
			$this->_obj['file'] = new File(); // ע���������δ�����ж��� ������ʱ �������ǹ��С��ش˱�ע
			return  $this->_obj['file'];
		}
	}
	
	/**
	 * ͼƬ�������
	 */
	public function __construct() {
		//parent::__construct();
	}
	
	/**
	 * ����ͼƬ��С�ߴ�����
	 * @param string $name ��Ҫ��ͼƬ�����['projector'�õƴ�ͼ,'list'�б�ҳͼ,'face'����ͼ,'min'Ԥ��Сͼ]
	 * @author lwkai 2013-4-12 ����3:23:43
	 */
	public static function getSize($name){
		if (in_array($name,array_keys(self::$_size))) {
			return self::$_size[$name];
		}
		return false;
	}
	
	/**
	 * ��ͼƬ���д�����������Ҫ�Ĺ��ͼ
	 * @param string $pic_address ��Ҫ�����ͼƬ��ַ����������·��
	 * @param string $orientation ͼƬ��ת���򣬴��뼴������ת��⣬��Ϊ����⣬Ĭ��Ϊ��
	 * @author lwkai 2013-4-11 ����10:21:21
	 */
	public function handlePic($pic_address, $orientation = ''){
		$name = basename($pic_address);
		$datePath = date('Y-m-d');
		$datePath = str_replace("-",DS,$datePath);
		$rotate = false;
		if ($orientation != '') { //�����������ת����ֵ���������ת���
			$new_address = DIR_FS_ROOT . 'upimg' . DS .$name;
			$pic = new Picture_Zoom(array('img'=>$pic_address, 'saveimg' => $new_address));
			$rotate = $pic->rotate($orientation); // ��Ⲣ������Ҫ������ת
			if($rotate == true) { // ���ͼƬ��������ת�����Դͼ��ַ�ı����ת���ͼƬ
				$pic_address = $new_address;
			}
		}
		foreach(self::$_size as $key => $val) {
			if ($key == 'face') continue; //�ҵķ���ҳ����Ҫ��ͼ,����ÿ��ͼ����Ҫ��������������
			$newimg = DIR_FS_ROOT . 'upimg' . DS . $val['width'] . 'x' . $val['height'] . DS . $datePath;
			$this->file()->createDir($newimg);
			$newimg .= DS . $name;
			isset($val['quality']) || $val['quality'] = 90;
			$pic = new Picture_Zoom(array('img' => $pic_address, 'saveimg' => $newimg, 'maxheight'=>$val['height'],'maxwidth'=>$val['width'],'quality'=>$val['quality']));
			if ($key == 'min' || $key == 'preview') {
				$pic->cut(true);
			} else {
				$pic->zoom();
			} 
		}
		if ($rotate == true) {
			$this->file()->delete($new_address);
		}
		return DIR_WS_ROOT . 'upimg/' . self::$_size['min']['width'] . 'x' . self::$_size['min']['height'] . '/' . str_replace("\\",'/',$datePath) . '/' .  $name;
	}
	
	/**
	 * �������ͼƬ
	 * @param string ͼƬ��ַ�����ݿ��е�ԭ��������Ҫ����·��
	 * @author lwkai 2013-4-11 ����11:20:35
	 */
	public function frontCover($pic_address) {
		$newname = DIR_FS_ROOT . 'upimg' . DS . self::$_size['face']['width'] . 'x' . self::$_size['face']['height'] . DS . str_replace('/',DS,$pic_address);
		$path = dirname($newname);
		$this->file()->createDir($path);
		$source = DIR_FS_ROOT . 'upimg' . DS . self::$_size['projector']['width'] . 'x' . self::$_size['projector']['height'] . DS . str_replace('/',DS,$pic_address);
		$pic = new Picture_Zoom(array('img'=>$source,'saveimg'=>$newname,'maxheight'=>self::$_size['face']['height'],'maxwidth'=>self::$_size['face']['width']));
		$pic->cut(true);
	}
	
	/**
	 * ���ͼƬ��
	 * ���ز���ļ�¼ID
	 * @param array $data ��Ҫ�������ݱ�ļ�ֵ������
	 * @return int
	 */
	public function add($data) {
		$rs = $this->db()->insert($this->_table, $data);
		return $rs;
	}
	
	/**
	 * �޸�ͼƬ����,������Ӱ��ļ�¼��
	 * @param array $data ��������ݿ���ֶ���ֵ�Ľ�ֵ��Ӧ����
	 * @param string $where ����
	 * @return number
	 * @author lwkai 2013-4-17 ����4:13:40
	 */
	public function update($data, $where) {
		$rs = $this->db()->update($this->_table, $data, $where);
		return $rs;
	}

	/**
	 * ɾ��ͼƬ
	 * @param int $id �μ�ID
	 * @author lwkai 2013-4-9 ����1:23:25 
	 */
	public function del($id) {
		$sql = "select * from travel_image where travel_notes_id='" . intval($id) . "'";
		$rs = $this->db()->query($sql)->getAll();
		foreach ($rs as $key => $val) {
			// ����д��ɾ��ͼƬ�Ĵ���
			foreach(self::$_size as $k => $v) {
				if ($k == 'face') continue; //�ҵķ���ҳ����Ҫ��ͼ,ɾ���μǵ�ʱ���ɾ��
				$img = DIR_FS_ROOT . 'upimg' . DS . $v['width'] . 'x' . $v['height'] . $val['image_src'];
				$this->file()->delete($img);
			}
			//ɾ��ԭͼ
			$this->file()->delete(DIR_FS_ROOT . 'upimg' . DS . 'source' . $val['image_src']);
			$rtn = $this->delOne($val['image_id'],true);
		}
		return $rtn;
	}
	
	/**
	 * ɾ��һ������
	 * @param int $id ����ID
	 * @param boolean $del ͼƬ�ļ��Ƿ��Ѿ�ɾ����true ��ʾ����Ҫ��ɾ��ͼƬ
	 * @return Ambigous <number, number>
	 * @author lwkai 2013-4-27 ����1:48:13
	 */
	public function delOne($id,$del = false) {
		if ($del == false) {
			$sql = "select image_src from " . $this->_table . " where " . $this->_field_prefix . "_id='" . intval($id) . "'";
			$rs = $this->db()->query($sql)->getOne();
			foreach(self::$_size as $k=>$v) {
				if ($k == 'face') continue;
				$img = DIR_FS_ROOT . 'upimg' . DS . $v['width'] . 'x' . $v['height'] . $rs['image_src'];
				$this->file()->delete($img);
			}
			//ɾ��ԭͼ
			$this->file()->delete(DIR_FS_ROOT . 'upimg' . DS . 'source' . $rs['image_src']);
		}
		// ��ʼ��EXIF�࣬ɾ������Ӧ��EXIF��Ϣ
		$exif = new Exif_Manage();
		$exif->del($id);
		return parent::del($id);
	}
	
	/**
	 * ����ͼƬIDȡ���μ�ID
	 * @param int $image_id ͼƬID
	 * @return int
	 * @author lwkai 2013-4-12 ����23:27:15
	 */
	public function getTravelId($image_id) {
		$rs = $this->db()->query("select travel_notes_id from " . $this->_table . " where " . $this->_field_prefix . "_id='" . intval($image_id) . "'")->getOne();
		return intval($rs['travel_notes_id']);
	}
	
	/**
	 * ���ݴ����IDȡ�ö�Ӧ������ͼƬ
	 * @param string $by �����������������򲻽�������,ע[����Ҫд order by �ؼ���]
	 * @return array
	 * @author lwkai 2013-4-16 ����1:23:34
	 */
	public function getList($where = '') {
		$sql = "select * from " . $this->_table;// . " where travel_notes_id='" . intval($id) . "'";
		if ($where != '') {
			$sql .= ' where ' . $where;
		}
		$rtn = $this->db()->query($sql)->getAll();
		return $rtn;
	}
	
	/**
	 * �������1
	 * @param int $id �����������ID
	 * @author lwkai 2013-5-3 ����2:29:39
	 */
	public function addViews($id) {
		return $this->update(array('read_number'=>'read_number + 1'), 'image_id=' . intval($id));
	}
	
	/**
	 * ����ͼƬIDȡ�������
	 * @param int $id ͼƬID
	 * @return Ambigous <>|number
	 * @author lwkai 2013-5-3 ����3:05:58
	 */
	public function getViews($id) {
		$sql = "select read_number from " . $this->_table . " where image_id='" . intval($id) . "'";
		$rs = $this->db()->query($sql)->getOne();
		if ($rs) {
			return $rs['read_number'];
		} else {
			return 0;
		}
	}
	
	/**
	 * �����μ�IDȡ��������
	 * @param int $id �μ�ID
	 * @return int 
	 * @author lwkai 2013-4-22 ����9:34:41
	 */
	public function getCountDay($id) {
		$sql = "select time_taken from " . $this->_table . " where travel_notes_id='" . intval($id) . "' order by time_taken asc limit 1";
		$rs = $this->db()->query($sql)->getOne();
		$start_date = $rs['time_taken'];
		$sql = "select time_taken from " . $this->_table . " where travel_notes_id='" . intval($id) . "' order by time_taken desc limit 1";
		$rs = $this->db()->query($sql)->getOne();
		$end_date = $rs['time_taken'];
		$day_temp = round((strtotime($end_date)-strtotime($start_date))/3600/24) + 1;
		return $day_temp;
	}
	
	/**
	 * �����û�ȡ��������������ͼƬ����
	 * @param int $userid �û�ID
	 * @return number
	 * @author lwkai 2013-4-23 ����9:52:51
	 */
	public function getUserImagesNum($userid) {
		$sql = "select count(img.image_id) as number from " . $this->_table . " as img, travel_notes as tn where tn.travel_notes_id=img.travel_notes_id and customers_id='" . intval($userid) . "'";
		$rs = $this->db()->query($sql)->getOne();
		return $rs['number'];
	}
	
	/**
	 * ����ͼƬIDȡ�ö�Ӧ�е�����
	 * @param int $image_id ͼƬID
	 * @return array
	 * @author lwkai 2013-4-17 ����3:40:57
	 */
	public function get($image_id) {
		$sql = "select * from " . $this->_table . " where " . $this->_field_prefix . "_id='" . intval($image_id) . "'";
		$rs = $this->db()->query($sql)->getOne();
		return $rs;
	}
	
	/**
	 * ���ݲ�ƷIDȡ�����µļ���ͼƬ
	 * @param int $productid ��ƷID
	 * @param int $num ��Ҫ��ͼƬ����
	 * @return array
	 */
	public function getImageByProductId($productid, $num=6){
		$num = intval($num) > 0 ? intval($num) : 6;
		$sql = "select tn.travel_notes_id,ti.image_src,tn.customers_id from travel_image ti,travel_notes tn where tn.products_id='" . intval($productid) . "' and ti.travel_notes_id=tn.travel_notes_id order by ti.image_id desc limit " . $num;
		$rs = $this->db()->query($sql)->getAll();
		return $rs;
	}
}
?>
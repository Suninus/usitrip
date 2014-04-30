<?php
/**
 * �μǲ�����
 * @formatter:off
 * @author lwkai 2013-4-9 ����5:46:22
 */
class Travel {
	
	/**
	 * ���ݿ��������
	 * @var Db_Mysql
	 * @author lwkai 2013-4-9 ����11:56:54
	 */
	private $_db = null;
	
	/**
	 * �μǱ�
	 * @var string
	 * @author lwkai 2013-4-9 ����11:57:19
	 */
	private $_table = 'travel_notes';
	
	/**
	 * ����һЩ��ϣ���ظ�NEW�Ķ��󣬱�����÷���ʱ��NEW����N����ͬ�Ķ���
	 * @var array
	 * @author lwkai 2013-4-11 ����11:17:03
	 */
	private $_obj = array();
	
	/**
	 * ��ҳ����
	 * @var Paging
	 * @author lwkai 2013-4-19 ����3:30:46
	 */
	private $_pageing = null;
	
	/**
	 * �����ǰ����Ҫ��ʽ�����ֶ�
	 * @var array
	 * @author lwkai 2013-4-23 ����3:14:13
	 */
	private $_format = array('travel_notes_title');
	
	/**
	 * ����ͼƬ��������
	 * @return Image
	 * @author lwkai 2013-4-11 ����9:16:41
	 */
	private function image() {
		if (isset($this->_obj['image']) && $this->_obj['image'] != null) {
			return $this->_obj['image'];
		} else {
			$this->_obj['image'] = new Image();
			return $this->_obj['image'];
		}
	}
	
	/**
	 * ȡ��ͼƬ������Ϣ��������
	 * @return Exif_Manage
	 * @author lwkai 2013-4-11 ����9:21:08
	 */
	private function exif(){
		if (isset($this->_obj['exif']) && $this->_obj['exif'] != null) {
			return $this->_obj['exif'];
		} else {
			$this->_obj['exif'] = new Exif_Manage();
			return $this->_obj['exif'];
		}
	}
	
	/**
	 * �μǲ�����
	 * 
	 * @author lwkai 2013-4-23 ����3:14:40
	 */
	public function __construct(){
		$this->_db = Db::get_db();
	}
	
	/**
	 * �����μ�ID����ȡ�μǵķ�����ID
	 * @param int $id �μ�ID
	 * @return number ���ط����û���ID
	 * @author lwkai 2013-4-9 ����5:43:51
	 */
	public function getUserId($id) {
		$rs = $this->_db->query("select customers_id from " . $this->_table . " where travel_notes_id='" . intval($id) . "'")->getOne();
		return $rs['customers_id'];
	}
	
	/**
	 * �����μ�IDȡ�ö�Ӧ�ļ�¼��
	 * @param int $id �μ�ID
	 * @return array
	 * @author lwkai 2013-4-16 ����2:51:12
	 */
	public function get($id) {
		$rs = $this->_db->query("select * from " . $this->_table . " where travel_notes_id='" . intval($id) . "'")->getOne();
		if ($rs) {
			$rs['travel_notes_title'] = htmlspecialchars($rs['travel_notes_title']);
		}
		return $rs;
	}
	
	/**
	 * ���һ�������
	 * @param int $id �μ�ID
	 * @return number
	 * @author lwkai 2013-5-3 ����2:42:25
	 */
	public function addViews($id) {
		$num = 0;
		$rs = $this->_db->query("select image_id from travel_image where travel_notes_id='" . intval($id) . "'")->getAll();
		$image = new Image();
		foreach($rs as $key => $val) {
			$num += $image->getViews($val['image_id']);
		}
		$sql = "select day_id from travel_day where travel_notes_id='" . intval($id) . "'";
		$rs = $this->_db->query($sql)->getAll();
		$mood = new Mood();
		foreach($rs as $key=>$val) {
			$num += $mood->getViews($val['day_id']);
		}
		return ($this->update(array('read_number'=>$num), 'travel_notes_id=' . intval($id)));
	}
	
	/**
	 * �����û�ID��ȡ�ø��û��������μ�
	 * @param int $user_id �����μǵ��û�ID
	 * @param string $order_by ����[��ѡ]
	 * @return array 
	 * @author lwkai 2013-4-17 ����2:34:16
	 */
	public function getUserListAll($user_id, $order_by = '') {
		$sql = "select * from " . $this->_table . " where customers_id='" . intval($user_id) . "'";
		if ($order_by != '') {
			$sql .= ' order by ' . $order_by;
		}
		$rs = $this->_db->query($sql)->getAll();
		$rs = $this->format($rs);
		return $rs;
	}
	
	/**
	 * ȡ���û����μ�ҳ,��ǰ�����$_GET['page']����ȡ��һҳ������ȡ��һҳ
	 * @param int $user_id �û�ID
	 * @param int $pagesize һҳ��ʾ�������μ�[��ѡ��Ĭ��10��]
	 * @param string $order_by ����[��ѡ]
	 * @return multitype:multitype: 
	 * @author lwkai 2013-4-23 ����10:20:05
	 */
	public function getUserList($user_id, $pagesize = 10, $order_by = '') {
		$sql = "select * from " . $this->_table . " where customers_id='" . intval($user_id) . "'";
		if ($order_by != '') {
			$sql .= ' order by ' . $order_by;
		}
		$this->_pageing = new Paging($this->_db, new Url($this->_db, 'index'), $sql, $pagesize);
		$pageing = new Paging($this->_db, $this->_url, $sql, 10);
		$rs = $this->_db->query($this->_pageing->getSql())->getAll();
		$rs = $this->format($rs);
		return $rs;
	}
	
	/**
	 * �����û���ͼƬ����
	 * @param int $user_id �û�ID
	 * @return int
	 * @author lwkai 2013-4-23 ����9:58:01
	 */
	public function getUserImagesNum($user_id){
		return $this->image()->getUserImagesNum($user_id);
	}
	
	/**
	 * ȡ���μǵ�ĳһҳ����
	 * @param number $pagesize һҳ��������¼
	 * @param string $where ����[��ѡ]
	 * @author lwkai 2013-4-19 ����3:26:25
	 */
	public function getList($pagesize = 10,$where = '',$sql = '') {
		if ($sql == '') {
			$sql = "select * from " . $this->_table . " where 1=1";
			if (SYS_IS_AUDIT == 'true') { // �������Ҫ��˵Ŀ���
				$sql .= " and verify=1";
			}
			if ($where != '') {
				$sql .= ' and ' . $where;
			}
			$sql .= " order by is_top desc,add_time desc";
		}
		$this->_pageing = new Paging($this->_db, new Url($this->_db, 'index'), $sql, $pagesize);
		$rs = $this->_db->query($this->_pageing->getSql())->getAll();
		$rs = $this->format($rs);
		return $rs;
	}
	
	/**
	 * ȡ�õ�ǰ�Ѿ�����������Ŀ�ĵ�
	 * @return multitype:NULL 
	 * @author lwkai 2013-4-22 ����1:04:21
	 */
	public function getAttractionslist(){
		$sql = "SELECT city_id FROM `travel_city_top` where `sort_id` > 0 order by `sort_id` asc";
		$rs = $this->_db->query($sql)->getAll();
		$rtn = array();
		foreach($rs as $key => $val) {
			$_t = Attractions_Usitrip::getAttractionsById($val['city_id']);
			$rtn[$val['city_id']] = $_t[0]['city'];
		}
		return $rtn;
	}
	
	/**
	 * ȡ��ǰһ�η�ҳ��ѯ��ҳ����Ϣ
	 * @param int $max_page_num ��ʾ���ٸ�ҳ��
	 * @return array
	 * @author lwkai 2013-4-19 ����3:34:13
	 */
	public function getPageInfo($max_page_num){
		if ($this->_pageing != null) {
			return $this->_pageing->getPageLinksToArray($max_page_num);
		}
		return array();
	}
	
	/**
	 * ȡ��ǰһ�η�ҳ��ѯ���ܼ�¼��
	 * @return number
	 * @author lwkai 2013-4-19 ����5:23:08
	 */
	public function getRowsTotal(){
		if ($this->_pageing != null) {
			return $this->_pageing->getRowsCount();
		}
		return 0;
	}
	
	/**
	 * ɾ��һ���μ�,������Ӱ��ļ�¼��
	 * @param int $id ��Ҫɾ�����μ�ID
	 * @return number
	 * @author lwkai 2013-4-9 ����11:58:54
	 */
	public function del($id) {
		$pic = new Image();
		$mood = new Mood();
		$pic->del($id);
		$mood->del($id);
		// ɾ������ͼ
		$rs = $this->_db->query("select cover_image from " . $this->_table . " where travel_notes_id='" . intval($id) . "'")->getOne();
		$file = new File();
		$size = Image::getSize('face');
		$file->delete(DIR_FS_ROOT . 'upimg' . DS . $size['width'] . 'x' . $size['height'] . DS . $rs['cover_image']);
		
		// ɾ���μ������¼
		$rtn = $this->_db->delete($this->_table, "travel_notes_id='" . intval($id) . "'");
		return $rtn;
	}
	
	/**
	 * ɾ��ͼƬ������
	 * @param int $id ͼƬ��������ID
	 * @param string $target ���ֱ��[ImageͼƬ,Mood����]
	 * @author lwkai 2013-4-26 ����2:48:01
	 */
	public function delPicOrMood($id, $target){
		if ('Image' == $target || 'Mood' == $target) {
			$delobj = new $target();
			$travel_id = $delobj->getTravelId($id);
			$rtn = $delobj->delOne($id);
			// ���ɾ������һ���������ͼƬ������Ҫ�������������������
			// �����������
			$travel_like = Like_Factory::getLike('Travels');
			$like_num = $travel_like->countLike($travel_id);
			// �����������
			$travel_comment = Comment_Factory::getComment('Travels');
			$comment_num = $travel_comment->getCommentsNum($travel_id);
			$this->update(array('like_number' => $like_num,'replay_number'=>$comment_num), "travel_notes_id='" . intval($travel_id) . "'");
		}
		return $rtn;
	}
	
	/**
	 * �޸��μ����ݣ�������Ӱ��ļ�¼��
	 * @param array $date Ҫ�޸ĵļ�ֵ������
	 * @param string $where �޸�����
	 * @return int
	 */
	public function update($data,$where) {
		$rs = $this->_db->update($this->_table, $data, $where);
		return $rs;
	}
	
	/**
	 * ��ͼƬ���浽���ݿ�
	 * @param XML $val2 XML����
	 * @param int $location_id ���㾰��ID
	 * @param int $travel_notes_id �μ�ID
	 * @param string $date ���ĳ���������ͼƬʱ�ľ�������[��ѡ]
	 * @author lwkai 2013-4-9 ����3:46:02
	 */
	private function addToImage($val2, $location_id, $travel_notes_id, $date='') {
		$data = array();
		$data['location_id'] = $location_id;
		$data['image_src'] = $val2->getElementsByTagName('url')->item(0)->nodeValue;
		$data['image_src'] = str_replace(DIR_WS_ROOT . 'upimg/source', '', $data['image_src']);
		$data['image_desc'] = $val2->getElementsByTagName('desc')->item(0)->nodeValue;
		$data['is_cover'] = $val2->getElementsByTagName('isCover')->item(0)->nodeValue == 'false' ? 0 : 1;
		
		/* ��¼����ʱ�䣬�������������  */
		$date_arr = explode('-',$date);
		$len = count($date_arr);
		if ($len == 3 && checkdate($date_arr[1], $date_arr[2], $date_arr[0])) {
			$data['time_taken'] = $date;
		} else {
			$data['time_taken'] = $val2->getElementsByTagName('exif')->item(0)->getElementsByTagName('Camera_Time')->item(0)->nodeValue;
		}
		$data['travel_notes_id'] = $travel_notes_id;
		$data = Convert::iconv('utf-8','gb2312', $data);
		$pic_id = $this->image()->add($data);
		$this->addToExif($val2->getElementsByTagName('exif')->item(0), $pic_id);
		// ���ɷ���ͼ
		if ($data['is_cover'] == 1) {
			$this->image()->frontCover($data['image_src']);
			$this->_db->update($this->_table, array('cover_image'=>$data['image_src']),"travel_notes_id='" . $travel_notes_id . "'");
		}
	}
	
	/**
	 * �޸ķ���ͼ
	 * @param int $travel_id �μ�ID
	 * @param int $image_id  ͼƬID
	 * @author lwkai 2013-4-17 ����3:08:55
	 */
	public function updateCover($travel_id,$image_id){
		$image = new Image();
		$rs = $image->get($image_id);
		$wh = Image::getSize('face');
		$travel_rs = $this->get($travel_id);
		$file = new File();
		$file->delete(DIR_FS_ROOT . 'upimg' . DS . $wh['width'] . 'x' . $wh['height'] . $travel_rs['cover_image']);
		$image->update(array('is_cover'=>0),"travel_notes_id='" . intval($travel_id) . "' and is_cover=1");
		$this->image()->frontCover($rs['image_src']);
		$image->update(array('is_cover'=>1),"travel_notes_id='" . intval($travel_id) . "' and image_id='" . intval($image_id) . "'");
		$this->update(array('cover_image'=>$rs['image_src']), "travel_notes_id='" . intval($travel_id) . "'");
	}
	
	/**
	 * ����ͼƬ�ϵ�EXIF��Ϣ�����ݱ�
	 * @param XML $exif XML���ݶ���
	 * @param int $pic_id �����ͼƬID
	 * @author lwkai 2013-4-9 ����3:45:07
	 */
	private function addToExif($exif, $pic_id) {
		/* ����ͼƬ��EXIF��Ϣ */
		$data = array();
		$data['exif_camera'] = $exif->getElementsByTagName('Camera_Model')->item(0)->nodeValue;
		$data['exif_time'] = $exif->getElementsByTagName('Camera_Time')->item(0)->nodeValue;
		$data['exif_iso'] = $exif->getElementsByTagName('Camera_ISO')->item(0)->nodeValue;
		$data['exif_aperture'] = $exif->getElementsByTagName('Fnumber')->item(0)->nodeValue;
		$data['exif_shutter_speed'] = $exif->getElementsByTagName('Exposure_Time')->item(0)->nodeValue;
		$data['exif_exposure_compensation'] = $exif->getElementsByTagName('Exposure_Bias')->item(0)->nodeValue;
		$data['exif_focal_length'] = $exif->getElementsByTagName('Focal_Length')->item(0)->nodeValue;
		$data['image_id'] = $pic_id;
		$data = Convert::iconv('utf-8', 'gb2312', $data);
		$this->exif()->add($data);
	}
	
	/**
	 * ����μ�
	 * @param string $param Ҫ��ӵ����ݣ����ַ�������һ����׼��XML���ַ��������ʽ����
	 * @param boolean $id_have �����ID�Ļ����Ͳ�ִ���Ȳ�����;�����Ĳ�����ֱ�Ӳ���ͼƬ����;ͼƬ��
	 * <xml> 
	 *     <userId>255</userId>
	 *     <name>�����μ���</name> 
	 *     <description></description> 
	 *     <destination>!517!</destination> 
	 *     <coverPic>!517!</coverPic> 
	 *     <tripLine>!140!</tripLine>
	 *     ���ο�ʼ 
	 *     <batchList> 
	 *         <batch> 
	 *             <batchdes>!</batchdes> 
	 *             <batchPicList>
	 *                 ͼƬ��ʼѭ�� 
	 *                 <batchPic> 
	 *                     <url>/lvtu/upimg/1365491849.2768.jpg</url> 
	 *                     <category>undefined</category> 
	 *                     <desc></desc> 
	 *                     <isCover>false</isCover> 
	 *                     <picWidth>1920</picWidth> 
	 *                     <picLength>1200</picLength> 
	 *                     <exif> 
	 *                         <Camera_Time>2013:04:09 15:17:53</Camera_Time> 
	 *                         <Camera_Model>undefined</Camera_Model> 
	 *                         <Fnumber></Fnumber> 
	 *                         <Camera_ISO>undefined</Camera_ISO> 
	 *                         <Exposure_Time></Exposure_Time> 
	 *                         <Exposure_Bias></Exposure_Bias> 
	 *                         <Focal_Length></Focal_Length> 
	 *                         <GpsLongitude>0</GpsLongitude> 
	 *                         <GpsLatitude>0</GpsLatitude> 
	 *                     </exif> 
	 *                 </batchPic>
	 *                 ѭ������ 
	 *             </batchPicList> 
	 *         </batch> 
	 *     </batchList>
	 *     ���ν��� 
	 *     <picNum>6</picNum>
	 * </xml>
	 * @return �μ������²����������¼��ID
	 * @author lwkai 2013-4-9 ����3:15:12
	 */
	public function add($param) {
		$xml = $this->stringToXml($param);
		if ($xml) {
			$data = array();
			$data['travel_notes_title'] = $xml->getElementsByTagName('name')->item(0)->nodeValue;
			$data['customers_id'] = $_SESSION['customer_id'];
			$data['image_number'] = $xml->getElementsByTagName('picNum')->item(0)->nodeValue;
			$data['add_time'] = date('Y-m-d H:i:s');
			$data['destination'] = $xml->getElementsByTagName('destination')->item(0)->nodeValue;
			$data['products_id'] = $xml->getElementsByTagName('tripLine')->item(0)->nodeValue;
			$data['products_id'] = $data['products_id'] ? trim($data['products_id'],'!') : '';
			$data = Convert::iconv('utf-8', 'gb2312', $data);
			$travel_notes_id = $this->_db->insert($this->_table, $data);
	
			/* ����ͼƬ ע�� ������Ҫ�ȱ��������õ��ղ���ļ�¼ID �������� */
			$this->rraversalPictures($xml, $travel_notes_id);
			return $travel_notes_id;
		}
		return false;
	}
	
	/**
	 * ���ĳһ���μ��Ƿ񻹴���,���ڷ����棬���򷵻ؼ�
	 * @param int $id �μ�ID
	 * @return boolean
	 * @author lwkai 2013-4-27 ����5:46:59
	 */
	public function isHave($id){
		$sql = "select travel_notes_id from " . $this->_table . " where travel_notes_id='" . intval($id) . "'";
		$rtn = $this->_db->query($sql)->getOne();
		if ($rtn) {
			return true;
		}
		return false;
	}
	
	/**
	 * ���Ѿ����ڵ��μǼ����µ�ͼƬ����������ĳһ�����ͼƬ����$data���������٣�����μ����ͼƬ����$data����Ҫ��
	 * ����׷��ͼƬ
	 * @param string $param XML��ʽ��ͼƬ�����ַ�������ʽ��ADD�����е�˵��
	 * @param string $date ���뵽��һ����Ǹ������ַ���
	 * @return boolean
	 */
	public function addImage($param, $date='') {
		$xml = $this->stringToXml($param);
		if ($xml) {
			$travel_notes_id = $xml->getElementsByTagName('id')->item(0)->nodeValue;
			if ($this->isHave($travel_notes_id)) {
				$num = $this->rraversalPictures($xml, $travel_notes_id, $date);
				$this->update(array('image_number'=>'image_number + ' . $num), "travel_notes_id='" . intval($travel_notes_id) . "'");
				return $travel_notes_id;
			}
		}
		return false;
	}
	
	/**
	 * ����μ��Ƿ��Ѿ����,ͨ�������棬���򷵻ؼ�
	 * @param int $id �μ�ID
	 * @return boolean
	 * @author lwkai 2013-4-19 ����2:29:16
	 */
	public function isVerify($id) {
		$sql = "select travel_notes_id from " . $this->_table . " where travel_notes_id='" . intval($id) . "' and verify=1";
		$rs = $this->_db->query($sql)->getOne();
		if ($rs) {
			return true;
		}
		return false;
	}
	
	/**
	 * �ж��Ƿ����Լ�������μ�,���Լ��ķ����档
	 * @param int $id �μ�ID
	 * @return boolean
	 * @author lwkai 2013-4-19 ����2:46:35
	 */
	public function isSelf($id) {
		$user_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;
		$sql = "select customers_id from " . $this->_table . " where travel_notes_id='" . intval($id) . "'";
		$rs = $this->_db->query($sql)->getOne();
		if ($rs['customers_id'] == $user_id) {
			return true;
		}
		return false;
	}
	
	/**
	 * �� XML��ʽ���ַ�����ת����XML���󣬳ɹ�����XML����ʧ�ܷ���false
	 * @param string $str xml��ʽ���ַ���
	 * @return DOMDocument|boolean
	 */
	private function stringToXml($str) {
		if ($str != '') {
			$xml = new DOMDocument();
			if ($xml->loadXML($str)){
				return $xml;
			}
		}
		return false;
	}
	
	/**
	 * ����XMLͼƬ���ݣ�������
	 * @param DOMDocument $xml XML����
	 * @param int $travel_notes_id �μ�ID
	 * @param string $date �����ַ�����ֻ��Ҫ������, ��ѡ����������ĳ�����ͼƬ�������ڲ�����
	 * @return number
	 */
	private function rraversalPictures($xml, $travel_notes_id, $date = '') {
		$i = 0;
		foreach($xml->getElementsByTagName('batchList')->item(0)->getElementsByTagName('batch') as $val) { //����
			foreach($val->getElementsByTagName('batchPicList')->item(0)->getElementsByTagName('batchPic') as $val2) { // ÿһ��ͼ
				/* ����ͼƬ��Ϣ */
				$this->addToImage($val2, trim($val->getElementsByTagName('batchdes')->item(0)->nodeValue,'!'), $travel_notes_id,$date);
				$i++;
			}
		}
		return $i;
	}
	
	/**
	 * ����μǱ����Ƿ��Ѿ�����,���ڷ����棬���򷵻ؼ�
	 * @param string $title Ҫ���ı�������
	 * @return boolean
	 * @author lwkai 2013-4-23 ����11:30:53
	 */
	public function checkTravelTitle($title){
		$sql = "select travel_notes_id from travel_notes where travel_notes_title = '" . Convert::db_input($title) . "'";
		$rs = $this->_db->query($sql)->getOne();
		if ($rs) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * ����Ҫ���ֶθ���ʽ��
	 * @param array $rs ���ݿ�����������
	 * @return string
	 * @author lwkai 2013-4-23 ����3:16:59
	 */
	private function format($rs){
		foreach($rs as $key=>$val) {
			foreach($this->_format as $k=>$v){
				$val[$v] = htmlspecialchars($val[$v]);
			}
			$rs[$key] = $val;
		}
		return $rs;
	}
	
	/**
	 * �μǱ������ϲ�������Ĵ���
	 * @param int $id Ҫ����ϲ�������Ķ���ID
	 * @param string $targetType Ҫ����ϲ������������[Image:ͼƬ1,Mood:����2,Travels:�μ�3]
	 * @param int $praiseActivityType ϲ���Ĳ�������[1���,2ȡ��]
	 * @param int $userid �������û�ID
	 * @author lwkai 2013-4-24 ����1:48:49
	 */
	public function like($id, $targetType, $praiseActivityType, $userid){
		// ͼƬ��1 ���� �����1 ����Ҫ���μǵ�ϲ�������ϼ�1
		$like = Like_Factory::getLike($targetType);
		switch ($praiseActivityType) {
			case 1: //���ϲ��
				if (!$like->isLike($id, $userid)) {
					$status = $like->addLike($id, $userid);
				}
				$status = $status > 0 ? 0 : 618; //JS�Ǳ� 0 Ϊ�ɹ� ���Է��صĽ������0���ʾ�м�¼���޸�
				break;
			case 2:// ȡ��ϲ��
				if ($like->isLike($id, $userid)) {
					$status = $like->delLike($id, $userid);
				}
				$status = $status > 0 ? 0 : 618; //JS�Ǳ� 0 Ϊ�ɹ� ���Է��صĽ������0���ʾ�м�¼���޸�
				break;
		}
		if ($targetType != 'Travels') { // ������Ƕ��μǽ���ϲ������,�����ϲ������
			$travel_like = Like_Factory::getLike('Travels');
			$travel_id = $like->getTravelId($id);
			$num = $travel_like->countLike($travel_id);
			$this->update(array('like_number' => $num), "travel_notes_id='" . intval($travel_id) . "'");
		}
		return $status;
	}
}
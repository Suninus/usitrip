<?php
/**
 * ͼƬ���۲�����
 * @package Comment
 * @author lwkai by 2013-04-02
 */
class Comment_Image extends Comment_Abstract {
	
	/**
	 * ͼƬ���۱��
	 * @var int
	 */
	protected $_target = 1;
	
	/**
	 * ͼƬ��
	 * @var string
	 */
	protected $_table = 'travel_image';
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * ���ݴ�������ͼƬ��������ID��ȡ���μ�ID
	 * @param int $id �����۵��������ͼƬID
	 * @return �μ�ID
	 */
	protected function getTravelsId($id) {
		$sql = "select travel_notes_id from " . $this->_table . " where image_id='" . intval($id) . "'";
		$rs = $this->_db->query($sql)->getOne();
		return $rs['travel_notes_id'];
	}
	
	/**
	 * ��ͼƬ�������������1
	 * @param int $id Ҫ���ӣ������۵ļ�¼id
	 * @return int ��Ӱ��ļ�¼����
	 */
	protected function addOne($id) {
		$num = $this->getCommentsNum($id);
		$data = array('replay_number' => $num);
		$rs = $this->_db->update($this->_table, $data,'image_id="' . intval($id) . '"');
		return $rs;
	}
}

?>
<?php
/**
 * �������۲�����
 * @package Comment
 * @author lwkai by 2013-04-02
 */
class Comment_Mood extends Comment_Abstract {
	
	/**
	 * �������۵ı��ID
	 * @var int
	 */
	protected $_target = 2;
	
	/**
	 * �������ÿ���˵����
	 * @var string
	 */
	protected $_table = 'travel_day';
	
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * ���ݴ�������ͼƬ��������ID��ȡ���μ�ID
	 * @param int $id �����۵��������ͼƬID
	 * @return �μ�ID
	 */
	protected function getTravelsId($id) {
		$sql = "select travel_notes_id from " . $this->_table . " where day_id='" . intval($id) . "'";
		$rs = $this->_db->query($sql)->getOne();
		return $rs['travel_notes_id'];
	}
	
	/**
	 * �Ե�ǰ����������������1
	 * @param int $id ��Ҫ��������������ID
	 * @return int ��Ӱ��ļ�¼����
	 */
	protected function addOne($id) {
		$num = $this->getCommentsNum($id);
		$data = array('replay_number' => $num);
		$rtn = $this->_db->update($this->_table, $data, 'day_id="' . intval($id) . '"');
		return $rtn;
	}
}

?>
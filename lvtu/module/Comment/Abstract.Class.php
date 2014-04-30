<?php
/**
 * ���۳�����
 * @package Comment
 * @author lwkai by 2013-04-02
 */
abstract class Comment_Abstract {
	
	/**
	 * ���ݿ������
	 * @var Db_Mysql
	 */
	protected $_db = null;
	
	/**
	 * Ҫ�����ı����� ͼƬ�� �����
	 * @var string
	 */
	protected $_table = '';
	 
	/**
	 * ���۱�
	 * @var string
	 */
	protected $_comment_table = 'travel_comment';
	

	
	/**
	 * �������ֱ�� 1ΪͼƬ 2Ϊ���� 3Ϊ�μ�
	 */
	protected $_target = 0;
	
	/**
	 * ȡ���۵�ʱ��һҳ��������¼
	 */
	protected $_pagesize = 10;
	
	/**
	 * ��ʼ�����ݿ������
	 */
	public function __construct() {
		$this->_db = Db::get_db();
	}
	
	/**
	 * ȡ������������
	 * @return number
	 */
	public function getCommentsNum($id) {
		$rs = $this->_db->query("select count(comment_id) as num from " . $this->_comment_table . " where target_id='" . $this->_target . "' and commented_id='" . intval($id) . "'")->getOne();
		return $rs['num'];
	}
	
	/**
	 * ȡ����������
	 * @param int $page ȡ���ݵĵڼ�ҳ��ҳ��
	 * @param int $id Ҫȡ�õ��������ĸ������ϵģ�������ͼƬ���������ͼƬ��ID
	 * @return array
	 */
	public function getComments($page, $id){
		$page = intval($page);
		$recordset_count = $this->getCommentsNum();
		$page_count = ceil($recordset_count / $this->_pagesize);
		if ($page > $page_count) {
			$page = $page_count;
		}
		if ($page < 1) {
			$page = 1;
		}
		$offset = ($this->_pagesize * ($page - 1));
		$sql="select * from " . $this->_comment_table . " where target_id='" . $this->_target . "' and commented_id='" . $id . "' order by create_time desc,comment_id desc limit " . $offset . "," . $this->_pagesize;
		$rs = $this->_db->query($sql)->getAll();
		return $rs;	
	}
	
	/**
	 * �������۵����ݱ�,�������²����������¼��ID
	 * @param array $data �������� array('content'=>'��������','commented_id'=>'���۶���ID','user_id'=>'������ID'[,'replay_to'=>'�ظ���ĳ���û�(ID)','parent_id'=>���ظ������۵�ID]);
	 * @return number
	 */
	public function saveComment($data) {
		$rtn = 0;
		if (isset($data['content'],$data['commented_id'],$data['user_id'])) {
			$data['create_time'] = date('Y-m-d H:i:s');
			$data['target_id'] = $this->_target;
			$rtn = $this->_db->insert($this->_comment_table, $data);
			$travles_id = $this->getTravelsId($data['commented_id']);
			$this->addOne($data['commented_id']);
			if ($travles_id > 0) {
				//$this->addTravelsOne($travles_id);
				$travels = Comment_Factory::getComment('Travels');
				$travels->addOne($travles_id);
			}
		}
		return $rtn;
	}
	
	/**
	 * ɾ������
	 * @param int $id Ҫɾ���Ķ���ID[��ͼ��ID������ID]
	 * @return int ��Ӱ��ļ�¼��
	 */
	public function delComment($id) {
		$rtn = 0;
		if (intval($id)) {
			$rtn = $this->_db->delete($this->_comment_table, "target_id='" . $this->_target . "' and commented_id='" . $id . "'");
			$travels_id = $this->getTravelsId($id);
			if ($travels_id > 0 && $rtn > 0) {
				//$this->delTravels($travels_id, $rtn);
				$travels = Comment_Factory::getComment('Travels');
				$travels->addOne($travels_id);
			}
		}
		
		return $rtn;
	}
	
	/**
	 * �ظ�����
	 */
	public function replayComment($data) {
		$rtn = 0;
		if (isset($data['content'],$data['commented_id'],$data['user_id'],$data['replay_to'])) {
			$data['parent_id'] = $data['replay_to'];
			$user_rs = $this->_db->query("select user_id from " . $this->_comment_table . " where comment_id='" . $data['replay_to'] . "'")->getOne();
			$data['replay_to'] = $user_rs['user_id'];
			$rtn = $this->saveComment($data);
		}
		return $rtn;
	}
	
	/**
	 * ���ݴ�������ͼƬ��������ID��ȡ���μ�ID
	 * @param int $id �����۵��������ͼƬID
	 * @return �μ�ID
	 */
	abstract protected function getTravelsId($id);
	
	/**
	 * ���۸���������
	 * @param int $id Ҫ�������۵ļ�¼ID
	 * @return int ��Ӱ��ļ�¼����
	 */
	abstract protected function addOne($id);
	
// 	/**
// 	 * ���μǵ���������1,������Ӱ��ļ�¼��
// 	 * @param int $id ��Ҫ��һ���μ�ID
// 	 * @return int
// 	 */
// 	private function addTravelsOne($id) {
// 		$data = array('replay_number' => 'replay_number + 1');
// 		$rtn = $this->_db->update($this->_travels_table, $data, 'travel_notes_id="' . intval($id) . '"');
// 		return $rtn;
// 	}
	
// 	/**
// 	 * ���μǵ���������ȥ$num,������Ӱ��ļ�¼��
// 	 * @param int $id  Ҫ��ȥ���μ�ID
// 	 * @param int $num  Ҫ��ȥ��ֵ[Ĭ��1]
// 	 * @return int
// 	 */
// 	private function delTravels($id, $num = 1) {
// 		$num = (intval($num) > 0 ? intval($num) : 1);
// 		$data = array('replay_number' => 'replay_number - ' . $num);
// 		$rtn = $this->_db->update($this->_travels_table, $data, 'travel_notes_id="' . intval($id) . '"');
// 		return $rtn;
// 	}
}

?>

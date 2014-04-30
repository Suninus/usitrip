<?php
/**
 * ����������
 * @author wtj
 * @date 2013-11-6
 */
class RaidersCatalog extends T {
	private $deep;
	function __construct() {
		$this->setTableName('raiders_type');
		$this->setIdName('type_id');
	}
	/**
	 * (non-PHPdoc)
	 * @see T::set()
	 */
	function set($arr) {
		switch ($this->select_type) {
			case 1: //�б�ҳ
				$this->setFileds('type_id,type_name,parent_id');
				$this->setOderBy('parent_id');
			case 2: //��̨�б�ҳ
				$str_sql='SELECT DISTINCT t1.type_id,t1.type_name,t1.parent_id,IF(t1.parent_id=0,"��Ŀ¼",t2.type_name) AS parent_name FROM '.$this->table.' t1,'.$this->table.' t2 WHERE t1.parent_id=t2.type_id OR t1.parent_id=0 order by t1.type_id';
				$this->setStrSql($str_sql);
			case 3 : // ͨ������ID��ȡ����ڵ�����
				$this->setFileds('type_id,type_name');
				$this->data=array('parent_id'=>$arr);
		}
	}
	/**
	 * ����OPTION�����ߴ���
	 * @param array $arr ��ѯ����������
	 * @param int $select ѡ�е���
	 * @param int $parent_id ����ID
	 * @param int $deep ���
	 * @return string
	 */
	function getOptionShow($arr, $select = '', $parent_id = 0, $deep = 0) {
		$str_need = '';
		$str_nbsp = '';
		for ($i = 0; $i < $deep; $i ++) {
			$str_nbsp .= '&nbsp;&nbsp;';
		}
		foreach ($arr as $key => $value) {
			if ($select) {
				$select_str = ($select == $value['type_id']) ? 'selected' : '';
			}
			if ($value['parent_id'] == $parent_id) {
				$str_need .= '<option value="' . $value['type_id'] . '" ' . $select_str . '>' . $str_nbsp . $value['type_name'] . '</option>';
				unset($arr[$key]);
				$str_need .= $this->getOptionShow($arr, $select, $value['type_id'], ++ $deep);
			}
		}
		return $str_need;
	}
	/**
	 * ��ȡ���޼������OPTION
	 * @param int $select ѡ�е�ID
	 * @return string
	 */
	function getOption($select = '') {
		$this->setGetType(1);
		$info = $this->getList();
		return $this->getOptionShow($info, $select);
	}
	/**
	 * ͨ����ID��ȡ������Ϣ
	 * @param int $parent_id ��ID
	 */
	function getInfoFromParentId($parent_id){
		$this->setGetType(3);
		$arr=$this->getList($parent_id);
		return $arr;
	}
	/**
	 * ��ȡ��̨�������ӵ�select OPTINѡ��
	 */
	function getBackAddOption(){
		$arr=$this->getInfoFromParentId(0);
		$str_need='';
		foreach($arr as $value){
			$str_need.="<option value='$value[type_id]'>$value[type_name]</option>";
		}
		return $str_need;
	}
	/**
	 * ɾ��
	 */
	function dropType($type_id){
		$str_sql="SELECT article_id FROM raiders_article WHERE article_type=".$type_id.' LIMIT 1';
		if($this->doSelect($str_sql)&&$this->getInfoFromParentId($type_id)){
			return 0;
		}else{
			if(!is_null($this->getParentIdByType($type_id))){
				$this->dropOne($type_id);
			return 1;
			}else{
				return 0;
			}
			
		}
	}
	/**
	 * �޸�
	 * @param string $type_name ��������
	 * @param int $type_id ����ID
	 */
	function changeOne($type_name,$type_id){
		return $this->update(array('type_name'=>$type_name), $type_id);
	}
	/**
	 * ��̨��ʾ����
	 */
	function getTd() {
		
		$this->setGetType(2);
		$info = $this->getList();
		return $info;
	}
	/**
	 * ��ȡǰ̨����ʵ�б�����
	 * @param int $parent ������ID
	 * @return array
	 */
	function getIndexInfo($parent){
		$arr=$this->getInfoFromParentId(0);
		foreach($arr as $key=>$value){
			if($value['type_id']==$parent&&$parent!=0){
				$arr[$key]['son']=$this->getInfoFromParentId($parent);
			}else{
				$arr[$key]['son']=array();
			}
		}
		return $arr;
	}
	/**
	 * �������и������õ�����������
	 * @param int $parent_id
	 * @return string
	 */
	function createAllTypeByParentId($parent_id){
		$str_need='';
		if($parent_id==0)
			return 0;
		$info=$this->getInfoFromParentId($parent_id);
		foreach($info as $value){
			$str_need.=','.$value['type_id'];
		}
		return substr($str_need, 1).','.$parent_id;
	}
	function getTypeName($id=0,$parent_id=0){
		$str_sql='SELECT type_name FROM '.$this->table.' WHERE type_id='.($id?$id:$parent_id);
		$this->setStrSql($str_sql);
		$info=$this->getList();
		return $info[0]['type_name'];
	}
	function getParentIdByType($type_id){
		$info=$this->getOne($type_id);
		return $info['parent_id'];
	}
}
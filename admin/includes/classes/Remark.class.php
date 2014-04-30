<?php
/**
 * ��ע�࣬���ڶ�ĳ��ҳ����б�ע������
 * @author lwkai 2013-10-08
 *
 */
class Remark {
	
	/**
	 * ��ע����
	 * @var string
	 */
	private $type = '';
	
	
	/**
	 * ��ʼ������
	 * @param string $type ��ǰ�����ķ��౸ע����
	 */
	public function __construct($type) {
		$this->type = $type;
	}
	
	/**
	 * ���汸ע,�����²�������ݼ�¼ID
	 * @param array $data Ҫ���������
	 * @return int
	 */
	public function add($data){
		$data['type'] = $this->type;
		$data['time'] = date('Y-m-d H:i:s');
		tep_db_fast_insert('remark', $data);
		return tep_db_insert_id();
	}
	
	/**
	 * ȡ�ñ�ע�б�
	 * @param string $limit ȡ���ټ�¼��
	 * @return array
	 */
	public function getList($limit = 'all'){
		$rtn = array();
		$search = isset($_GET['search']) ? tep_db_input($_GET['search']) : '';
		$sql = "select * from remark where type='" . $this->type . "'";
		if ($search != '') {
			$sql .= ' and remark like "%' . $search . '%"';
		}
		$sql .= " order by id desc";
		if ($limit != 'all' && is_numeric($limit)) {
			$sql .= " limit " . $limit;
		}
		$rs = tep_db_query($sql);
		while($result = tep_db_fetch_array($rs)) {
			$result['remark'] = htmlspecialchars($result['remark']);
			$rtn[] = $result; 
		}
		return $rtn;
	}
	
	/**
	 * ɾ����ע
	 * @param array|string $id
	 */
	public function del($id){
		$ids = '';
		if (is_array($id)) {
			foreach($id as $key => $val) {
				$id = intval($val);
				$ids .= $id > 0 ? $id . ',' : '';
			}
			$ids = trim($ids,',');
		} elseif (is_string($id) || is_numeric($id)) {
			$id = intval($id);
			$ids = $id > 0 ? $id : '';
		}
		if ($ids) {
			$sql = "delete from remark where type='" . $this->type . "' and id in (" . $ids . ")";
			tep_db_query($sql);
		}
	}
	
	/**
	 * ��⶯���Ƿ���Ҫ������
	 * @param unknown_type $action
	 * @param unknown_type $login_id
	 */
	public function checkAction($action,$login_id){
		switch ($action) {
			case 'G_addremark':
				$data = array();
				$data['remark'] = iconv("utf-8","gb2312",$_POST['G_remark']);
				$data['admin_id'] = $login_id;
				$inserted_id = $this->add($data);
				if ((int)$inserted_id>0)
				{
					echo 'success';
				}else{
					echo 'error: ����ʧ��';
				}
				exit();
				break;
			case 'G_del':
				$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : false);
				if ($id) {
					$this->del($id);
				}
				tep_redirect($_SERVER['HTTP_REFERER']);
				exit;
				break;
			default:
		}
	}
	
	/**
	 * ��ʾ��ע�б�HTML
	 */
	public function showRemark($param=''){
		global $can_delete_remark;
		$html = '
		<fieldset>
		<legend style="text-align:left">��ע</legend>
		<div>
		<script type="text/javascript">
		/* ���OP��ע��ť */
		function G_fn_addremark()
		{
			var s=prompt("�����뱸ע������:';
			if (isset($_GET['search']) && $_GET['search']) {
				$html .= '[ע��:�����������Ǽ������������(' . $_GET['search'] . ')]';
			}
			$html .= '");
		
			if (s.length==0){ alert("��������뱸ע����"); return false;}
			//if (s.length>100){ alert("���ݳ��ȳ�������"); return false;}';
			if (isset($_GET['search']) && $_GET['search']) {
				$html .= 'if (s.indexOf(\'' . $_GET['search'] . '\') == -1) {
					if(!confirm("\n\n\n\n��ע��δ��������϶�Ӧ�Ĵʣ�\n\n\n������:' . $_GET['search'] . '\n\n\n����д�����ݣ�"+s+"\n\n\n����㲻���϶�Ӧ�����Ĵʣ���ˢ�º�Ϳ������㵱ǰ�ı�ע���ݡ�\n\n\n��ȷ��Ҫ�ύ��\n\n\n\n")){
						return false;
					}';
			}
			$html .= '
			//ajax
			var url="?ajax=true&action=G_addremark&sid=" + Math.random() + "&' . $param . '";
		
			jQuery.post(url, {"G_remark": s}, function (data, textStatus){
				data = data.replace(/^\s+/,"").replace(/\s+$/,"");
				if(\'success\' == data ){
					alert("ok");
					window.location.reload();
				}
				else
				{
					alert(data);
				}
			});
			return true;
		}
		
		function G_show_remark(btn){
			var obj = jQuery(\'#remark_table\');
			if(obj.css(\'display\') == \'none\') {
				obj.css(\'display\',\'block\');
				btn.value = "���ر�ע";
			} else {
				obj.css(\'display\',\'none\');
				btn.value = "��ʾ��ע";
			}
		}
				
		function unselect(){
			jQuery(\'input[name=\\\'id[]\\\']\').each(function(){
				if($(this).attr(\'checked\')){
					$(this).attr(\'checked\',false);
				} else {
					$(this).attr(\'checked\',true);
				}
			});
		}
		function showall(obj){
			jQuery(\'tr.remark_hide\').toggle();		
		}
		</script>
		<input type="button" value="��ʾ��ע" onclick="G_show_remark(this)" /><input type="button" value="��ӱ�ע" onclick="G_fn_addremark()"/>
		<div>';
		$list = $this->getList();
		
		$html .= '		<form action="?action=G_del&ajax=true" method="post"><table id="remark_table" style="display:none">
				<tr class="dataTableHeadingRow">
				<td class="dataTableHeadingContent">���</td>
				<td class="dataTableHeadingContent">��ע</td>
				<td class="dataTableHeadingContent">��ע����</td>
				<td class="dataTableHeadingContent">��עʱ��</td>';
		if ($can_delete_remark) {
			$html .= '<td class="dataTableHeadingContent"><input type="button" value="ȫѡ" onClick="jQuery(\'input[name=\\\'id[]\\\']\').attr(\'checked\',true);" />
				<input type="button" value="��ѡ" onClick="unselect()"/></td>';
		}
		$html .= '</tr>';
		$count_i = 0;
		foreach($list as $key => $val) {
			$html .='<tr class="dataTableRow ';
			if ($count_i >= 5) {
				$html .= 'remark_hide" style="display:none"';
			}
			$html .= '">
					<td  class="dataTableContent">' . $val['id'] . '</td>
					<td  class="dataTableContent">' . $val['remark'] . '</td>
					<td  class="dataTableContent">' . tep_get_job_number_from_admin_id($val['admin_id']) . '</td>
					<td  class="dataTableContent">' . $val['time'] . '</td>';
			if ($can_delete_remark) {
				$html .= '<td class="dataTableContent"><input type="checkbox" name="id[]" id="id[]" value="' . $val['id'] . '"/></td>';
			}
			$html .= '</tr>';
			$count_i ++;
		}
		if ($can_delete_remark) {
		$html .='	<tr class="dataTableRow">
				<td class="dataTableContent"></td>
				<td class="dataTableContent"></td>
				<td class="dataTableContent"></td>
				<td class="dataTableContent"></td>
				<td class="dataTableContent"><input type="button"  onClick="if(confirm(\'��ȷ��Ҫ����ɾ����Щ��ע�𣿸ò��������棡\')){this.form.submit();} else {return false}" value="����ɾ��"/></td>
				</tr>';
		}
		$html .= '	<tr class="dataTableRow">
				<td class="dataTableContent"><input type="button" onclick="showall(this)" value="��ʾȫ��" /></td>
				<td class="dataTableContent"></td>
				<td class="dataTableContent"></td>
				<td class="dataTableContent"></td>
				<td class="dataTableContent"></td>
				</tr>	</table></form>
				</div>
				</div>
		</fieldset>';
		echo $html;
	}
}
<?php
/*
����������춸����������ܱ��ѡ��
����˵��$now_type��ָ��ǰѡ���ID��$dis��ָ����ʾ��ѡ���ܱ��ǰѵ�ǰѡ���ID���е�ֱֵ����ʾ������0Ϊ�½��б�����ֵΪֱ����ʾ
*/

class SelectMenusObj{
	//$arrayΪѡ���ܱ��ѡ��ֵ����
	function selected_option($array,$now_type=0,$dis=0){
		//print_r($array);
		$now_type = strip_tags($now_type);
		$option_str="";
		$selected="";
		if($dis==0){
			foreach((array)$array as $key => $val){
				if($now_type==$key){$selected=' selected="selected" ';}
				$option_str.='<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
				unset($selected);
			}
		}else{
			$option_str = $array[$now_type];
		}
		return $option_str;
	}
	//$table=db_table_name,$id=��ʾ�Ĺ��ܱ��ֵ,$text=��ʾ�Ĺ��ܱ�ѡ������
	function selected_menus($table,$id,$text, $now_type=0,$dis=0,$begin='PleaseSelect', $parameters=''){
		$array=array();
		$array[0]=$begin;
		$query = tep_db_query("select $id , $text  from " . $table .$parameters);
		$row = tep_db_fetch_array($query);
		do{
			$k=preg_replace('/^.*\./','',$id);
			$t=preg_replace('/^.*\./','',$text);
			$array[(int)$row[$k]] = tep_output_string($row[$t]);
		} while ($row = tep_db_fetch_array($query));
		return $this->selected_option($array,$now_type,$dis);
	}
	
	
	//������������
}
?>
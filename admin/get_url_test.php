<?php
  // ɭ���ҡ����� 2002 ��ǻ��
  // ������������� 2003 ��
  $text = "<div><div>aaa</div><div>bbb</div><div>ccc</div></div>";
  $text = "0<div>1<div>2<div>dd</div>0aaa</div>1 3<div>bbb</div>2 4<div>ccc</div>3</div>4";

  //�������������������
  $text_h_array = preg_split('/<div>/',$text);
  $text_f_array = preg_split('/<\/div>/',$text);
  if(count($text_h_array)!=count($text_f_array)){ echo '���������'; }
  $out ='';
  $e = '';
  for($i=0; $i<count($text_h_array); $i++){
  	if($i>0){ $e='<howard_'.$i.'>'.'<div>';}
	$out .= $e.$text_h_array[$i];
  }
  
  echo $out;
  //print_r($text_array);


?>

<?php
require_once("chinabank.config.php");
?>

<!--  
 * ====================================================================
 *
 *                 Receive.php ���������߼���֧���ṩ
 *
 *     ��ҳ��Ϊ֧����ɺ��ȡ���صĲ���������......
 *
 *
 * ====================================================================
-->
<?
//****************************************	//MD5��ԿҪ�������ύҳ��ͬ����Send.asp��� key = "test" ,�޸�""���� test Ϊ������Կ
											//�������û������MD5��Կ���½����Ϊ���ṩ�̻���̨����ַ��https://merchant3.chinabank.com.cn/
	$key = MODULE_PAYMENT_A_CHINABANK_KEY;	//��½��������ĵ�����������ҵ���B2C�����ڶ������������С�MD5��Կ���á�
											//����������һ��16λ���ϵ���Կ����ߣ���Կ���64λ��������16λ�Ѿ��㹻��
//****************************************
	
$v_oid     =trim($_POST['v_oid']);       // �̻����͵�v_oid�������   
$v_pmode   =trim($_POST['v_pmode']);    // ֧����ʽ���ַ�����   
$v_pstatus =trim($_POST['v_pstatus']);   //  ֧��״̬ ��20��֧���ɹ�����30��֧��ʧ�ܣ�
$v_pstring =trim($_POST['v_pstring']);   // ֧�������Ϣ �� ֧����ɣ���v_pstatus=20ʱ����ʧ��ԭ�򣨵�v_pstatus=30ʱ,�ַ������� 
$v_amount  =trim($_POST['v_amount']);     // ����ʵ��֧�����
$v_moneytype  =trim($_POST['v_moneytype']); //����ʵ��֧������    
$remark1   =trim($_POST['remark1']);      //��ע�ֶ�1
$remark2   =trim($_POST['remark2']);     //��ע�ֶ�2���Ǵ��json����Ϣ��
$v_md5str  =trim($_POST['v_md5str']);   //ƴ�պ��MD5У��ֵ  

/**
 * ���¼���md5��ֵ
 */
                           
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

/**
 * �жϷ�����Ϣ�����֧���ɹ�������֧��������ţ�������һ���Ĵ���
 */


if ($v_md5str==$md5string)
{
	if($v_pstatus=="20")
	{
		//֧���ɹ����ɽ����߼�����
		//�̻�ϵͳ���߼����������жϽ��ж�֧��״̬�����¶���״̬�ȵȣ�......
		$orders_id = (int)$v_oid;
		$out_trade_no = $v_oid;
		$total_fee = $v_amount;
		$notify_time = date("Y-m-d H:i:s");
		$notify_type = 'ʵʱ֪ͨ';
		$extra_common_param = $remark2;	//json������Ϣ
		//��¼�ɹ�������Ϣ�����¶�����Ϣ{
			$usa_value = tep_cny_to_usd($orders_id, $total_fee);
			$payment_method = '��������';
			//$comment = print_r($_GET, true);
			$comment = "\n";
			$comment .= '����ң�'.$total_fee."\n";
			$comment .= '����ʱ�䣺'.$notify_time."\n";
			$comment .= 'MD5У��ֵ��'.$v_md5str."\n";
			$comment .= '�����ţ�'.$out_trade_no."\n";
			//$comment .= '�������ֻ���������䣺'.$buyer_email."\n";
			$comment .= '֪ͨ���ͣ�'.$notify_type."\n".__FILE__;
			//$comment = iconv('utf-8','gb2312',$comment);
			$update_action = tep_payment_success_update($orders_id, $usa_value, $payment_method, $comment, 96, $out_trade_no);
			//����ҳ
			$return_url_page = HTTP_SERVER.'/account_history_info.php?order_id='.(int)$orders_id;
			
			//���ͬ����Ϣ{
			if($update_action==true && isset($extra_common_param) && $extra_common_param!="" && strlen($extra_common_param)<150 ){	//��̬���������ߣ�ֻ�ܴ�150���ַ���remark2
				$travelCompanionPayStr = base64_decode($extra_common_param);
				$travelCompanionPay = json_decode($travelCompanionPayStr,true);
				
				if(number_format($usa_value,2,'.','') == number_format($travelCompanionPay['i_need_pay'],2,'.','')){
					$orders_travel_companion_status = '2';
				}
				//���ݾ���
				$averge_usa_value = $usa_value / (max(1, sizeof(explode(',',$travelCompanionPay['orders_travel_companion_ids']))));
				$averge_usa_value = number_format($averge_usa_value, 2,'.','');
				$sql_date_array = array(
										'last_modified' => date('Y-m-d H:i:s'),
										'orders_travel_companion_status' => $orders_travel_companion_status,
										'payment' => 'alipay_direct_pay',
										'payment_name' => $payment_method, 
										'payment_customers_id' => $travelCompanionPay['customer_id']
										);
				tep_db_perform('orders_travel_companion', $sql_date_array, 'update',' orders_id="'.(int)$orders_id.'" AND orders_travel_companion_id in('.$travelCompanionPay['orders_travel_companion_ids'].') ');
				tep_db_query('update orders_travel_companion set payment_description = CONCAT(`payment_description`,"\n '.tep_db_input($comment).'"), paid = paid+'.$averge_usa_value.' where orders_id="'.(int)$orders_id.'" AND orders_travel_companion_id in('.$travelCompanionPay['orders_travel_companion_ids'].') ');
				// ���ض���ҳ��
				$return_url_page = HTTP_SERVER.'/orders_travel_companion_info.php?order_id='.(int)$orders_id;
				//print_r($travelCompanionPay);
			}
			//���ͬ����Ϣ}
			header('Location: '.$return_url_page);
		//��¼�ɹ�������Ϣ�����¶�����Ϣ}

	}else{
		echo "֧��ʧ��";
	}
	?>
	<html>
	<body>
	<TABLE width=500 border=0 align="center" cellPadding=0 cellSpacing=0>
		  <TBODY>
			<TR> 
			  <TD vAlign=top align=middle> <div align="left"><B><FONT style="FONT-SIZE:14px">MD5У����:<? echo $v_md5str?></FONT></B></div></TD>
			</TR>
			<TR> 
			  <TD vAlign=top align=middle> <div align="left"><B><FONT style="FONT-SIZE: 14px">������:<? echo $v_oid?></FONT></B></div></TD>
			</TR>
			<TR> 
			  <TD vAlign=top align=middle> <div align="left"><B><FONT style="FONT-SIZE: 14px">֧������:<? echo $v_pmode?></FONT></B></div></TD>
			</TR>
			<TR> 
			  <TD vAlign=top align=middle> <div align="left"><B><FONT style="FONT-SIZE: 14px">֧�����:<? echo $v_pstring?></FONT></B></div></TD>
			</TR>
			<TR> 
			  <TD vAlign=top align=middle> <div align="left"><B><FONT style="FONT-SIZE: 14px">֧�����:<? echo $v_amount?></FONT></B></div></TD>
			</TR>
			<TR> 
			  <TD vAlign=top align=middle> <div align="left"><B><FONT style="FONT-SIZE: 14px">֧������:<? echo $v_moneytype?></FONT></B></div></TD>
			</TR>
		  </TBODY>
		</TABLE>
		<?

}else{
	echo "<br>У��ʧ��,���ݿ���";
}
?>
</BODY>
</HTML>
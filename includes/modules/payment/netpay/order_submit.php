<?php
	header('Content-type: text/html; charset=gb2312');
	include_once("config.php");
	
	//���� netpayclient ���
	include_once("netpayclient.php");
	
	//����˽Կ�ļ�, ����ֵ��Ϊ�����̻��ţ�����15λ
	$merid = buildKey(PRI_KEY);
	if(!$merid) {
		echo "����˽Կ�ļ�ʧ�ܣ�";
		exit;
	}
	
	//==ȡ�ö�������========================================================={
	$_totals = tep_get_need_pay_value((int)$_GET['order_id']);
	$total_fee = $_totals[1];
	
	$extra_common_param = '';
	//��ӽ��ͬ��֧����������{
	if(isset($_GET['travelCompanionPay'])){
		$travelCompanionPayStr = base64_decode($_GET['travelCompanionPay']);
		$extra_common_param = $travelCompanionPayStr;
		$travelCompanionPay = json_decode($travelCompanionPayStr,true);
		$i_need_pay = tep_usd_to_cny((int)$_GET['order_id'], $travelCompanionPay['i_need_pay']);
		$total_fee = $i_need_pay;
		$body = '���ͬ�ζ���';
	}
	//$total_fee = 0.01;
	//��ӽ��ͬ��֧����������}
	
	$ordid = str_pad(trim($_GET['order_id']), 10, 0, STR_PAD_LEFT) .date('His');	//����16λ������������ϣ�һ���ڲ������ظ� ����(ǰ��10λ������ϵͳ�Ķ����ź�6λ��ʱ��His)
	$transamt = padstr($total_fee * 100,12);	//֧����� ����12λ���Է�Ϊ��λ��������0������
	$priv1 = "";//$_GET['travelCompanionPay']; //���ͬ�ε����鴮
	//==ȡ�ö�������=========================================================}
	
	//���ɶ����ţ�����16λ������������ϣ�һ���ڲ������ظ����������õ�ǰʱ���������
	//$ordid = "00" . date('YmdHis');
	//����������12λ���Է�Ϊ��λ��������0������
	//$transamt = padstr('1',12);
	//���Ҵ��룬3λ�������̻��̶�Ϊ156����ʾ����ң�����
	$curyid = "156";
	//�������ڣ��������õ�ǰ���ڣ�����
	$transdate = date('Ymd');
	//�������ͣ�0001 ��ʾ֧�����ף�0002 ��ʾ�˿��
	$transtype = "0001";
	//�ӿڰ汾�ţ�����֧��Ϊ 20070129������
	$version = "20070129";
	//ҳ�淵�ص�ַ(���������Ͽɷ��ʵ�URL)���80λ�����û����֧��������ҳ����Զ���ת����ҳ�棬��POST���������Ϣ����ѡ
	$pagereturl = MODULE_PAYMENT_NETPAY_RETURN_URL; //; "{$site_url}/order_feedback.php";
	//��̨���ص�ַ(���������Ͽɷ��ʵ�URL)���80λ�����û����֧�����ҷ���������POST���������Ϣ����ҳ�棬����
	$bgreturl = MODULE_PAYMENT_NETPAY_RETURN_URL; //"{$site_url}/order_feedback.php";
	
	/************************
	ҳ�淵�ص�ַ�ͺ�̨���ص�ַ������
	��̨���ش��ҷ������������������û��������������Ӱ�죬�Ӷ���֤���׽�����ʹ
	************************/
	
	//֧�����غţ�4λ������ʱ�������գ�����ת�������б�ҳ�����û�����ѡ�񣬱�ʾ��ѡ��0001ũ�������ر��ڲ��ԣ���ѡ
	//$gateid = "0001";
	$gateid = "";
	//��ע���60λ�����׳ɹ����ԭ�����أ������ڶ���Ķ������ٵȣ���ѡ
	//$priv1 = "memo";
	
	//��������϶�����ϢΪ��ǩ����
	$plain = $merid . $ordid . $transamt . $curyid . $transdate . $transtype . $priv1;
	//����ǩ��ֵ������
	$chkvalue = sign($plain);
	if (!$chkvalue) {
		echo "ǩ��ʧ�ܣ�";
		exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN"><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta name="robots" content="noindex,nofollow">
<title>��������Ŀ����ҳ......��������</title>
<link href="global.css" rel="stylesheet" type="text/css">
<style type="text/css">
.wait{ height:auto; padding:10px 50px 20px 50px;}
.wait .s_1 img{ margin:0 auto;}
/*��ת*/
#jump{	width:860px;height:388px;position:absolute;left:50%;top:50%;z-index:5; margin:-229px 0 0 -430px;text-align:center; padding-top:70px; border:1px solid #e9e9e9;}
#jump h1{ display:inline;}
#jump .usitrip,#jump .usitrip h1{ font-size:24px; font-family:"΢���ź�",Arial, Helvetica, sans-serif; }
.wait{ width:243px; padding:0 40px; border:1px solid #dadada; margin:62px auto;} 
.pop_copyright{ background:#f9f9f9; padding:20px 0; line-height:24px; color:#888;}
.wait .s_1{ padding:12px 0;}
.wait .s_2{ background:#ececec; height:16px; font-size:0; line-height:0; margin-bottom:7px;}
.wait .s_2 img{ width:243px; height:16px;}

</style>
</head>
<body scroll="no" style="position:static;" bgcolor="#FFFFFF" onLoad="javascript:document.netpay_form.submit()">
<div id="jump">
	<div class="usitrip color_orange">����ǰ����������֧��ҳ�����֧��&hellip;&hellip;</div>
    <div class="wait">
    	<p class="s_1" style="text-align:center;"><img src="images/logo.gif" alt="chinabank_logo"/></p>
        <p class="s_2"><img src="images/loading.gif"></p>
    	<p class="s_3">
		<strong class="color_green font_bold">USITRIP���ķ�������һ�����ķ���</strong>
		</p>
    </div>
	<div>
	</div>
</div>

<form style="display:none;" action="<?php echo REQ_URL_PAY; ?>" method="post" name="netpay_form" target="_self">
<label>�̻���</label><br/>
<input type="text" name="MerId" value="<? echo $merid; ?>" readonly/><br/>
<label>֧���汾��</label><br/>
<input type="text" name="Version" value="<? echo $version; ?>" readonly/><br/>
<label>������</label><br/>
<input type="text" name="OrdId" value="<? echo $ordid; ?>" readonly/><br/>
<label>�������</label><br/>
<input type="text" name="TransAmt" value="<? echo $transamt; ?>" readonly/><br/>
<label>���Ҵ���</label><br/>
<input type="text" name="CuryId" value="<? echo $curyid; ?>" readonly/><br/>
<label>��������</label><br/>
<input type="text" name="TransDate" value="<? echo $transdate; ?>" readonly/><br/>
<label>��������</label><br/>
<input type="text" name="TransType" value="<? echo $transtype; ?>" readonly/><br/>
<label>��̨���ص�ַ</label><br/>
<input type="text" name="BgRetUrl" value="<? echo $bgreturl; ?>"/><br/>
<label>ҳ�淵�ص�ַ</label><br/>
<input type="text" name="PageRetUrl" value="<? echo $pagereturl; ?>"/><br/>
<label>���غ�</label><br/>
<input type="text" name="GateId" value="<? echo $gateid; ?>"/><br/>
<label>��ע</label><br/>
<input type="text" name="Priv1" value="<? echo $priv1; ?>" readonly/><br/>
<label>ǩ��ֵ</label><br/>
<input type="text" name="ChkValue" value="<? echo $chkvalue; ?>" readonly/><br/>
<input type="submit" value="֧��">
</form>
</body>
</html>

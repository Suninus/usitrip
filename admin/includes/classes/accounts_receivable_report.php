<?php
/**
 * ���ɵ���ͼ�α�����
 * @author Howard
 */
class accounts_receivable_report{
	/**
	 * �������json����
	 * @var array
	 */
	private $jsonData = array();
	/*
	 * ������
	 */
	private $pic_width = 800;
	/**
	 * ����߶�
	 */
	private $pic_height = 670;
	/**
	 * ��ʼ��ʱ����GET����
	 * @param array $get
	 */
	public function __construct(array $get){
		$this->jsonData['chart']['numberPrefix'] = '$';			//����ǰ׺
		$this->jsonData['chart']['formatNumberScale'] = '0';	//�Ƿ��ʽ������,Ĭ��Ϊ1(True),�Զ��ĸ�������ּ���K��ǧ����M�����򣩣���ȡ0,�򲻼�K��M
		$this->jsonData['chart']['baseFontSize'] = '12';		//ͼ�������С
		$this->jsonData['chart']['formatNumber'] = '0';			//�������ָ�����(ǧλ������λ),Ĭ��Ϊ1(True)����ȡ0,�򲻼ӷָ���
		
		$this->jsonData['chart']['yaxisname'] = iconv('gb2312','utf-8','���˱���');
		
		$this->tables = ' `orders_payment_history` oph, orders o  ';
		$this->where = ' 1 and oph.orders_id=o.orders_id ';
		$this->sql_str = 'SELECT SUM(oph.orders_value) as TotalRevenue FROM '.$this->tables.' WHERE '.$this->where;
		$date_start = date('Y-m-d',strtotime($get['add_date_start']));
		$date_end = date('Y-m-d',strtotime($get['add_date_end']));
	
		switch($get['reportType']){
			case 'year':	//������ȱ�������				
				$Y_start = date('Y',strtotime($date_start));
				$Y_end = date('Y',strtotime($date_end));
				$this->getDataYear($Y_start, $Y_end);
				break;
			case 'week':	//���ɵ��ܱ�������
				$this->getDataWeek($date_start);
				break;
			case 'day':		//���ɵ���ÿ������
				$this->getDataDay(date('Y-m',strtotime($date_start)));
				break;
			case 'month':	//�����¶ȱ�������
				$this->getDataMonth(date('Y',strtotime($date_start)));
				break;
			case 'hours':	//����Сʱ��������
				$this->getDataHours(date('Y-m-d',strtotime($date_start)));
				break;
			default:
				break;
		}	
	}
	/**
	 * ȡ��������
	 * @param int $start_year ��ʼ��
	 * @param int $end_year ������
	 */
	public function getDataYear($start_year, $end_year){
		$this->jsonData['chart']['caption'] = iconv('gb2312','utf-8',$start_year.'-'.$end_year."��ȵ��˱���");
		$this->jsonData['chart']['xaxisname'] = iconv('gb2312','utf-8',$start_year.'-'.$end_year);
		for($i=$start_year; $i<=$end_year; $i++){
			$sql = $this->sql_str.' and oph.add_date Like "'.$i.'-%" ';
			//echo $sql."\n"; 
			$sql = tep_db_query($sql);
			$array['data'] = array();
			while ($rows = tep_db_fetch_array($sql)){
				$this->jsonData['data'][] = array('label'=>$i.iconv('gb2312','utf-8','��'), 'value'=>$rows['TotalRevenue']);
			}
		}
	}
	/**
	 * ȡ��������
	 * @param int $year Ҫͳ�Ƶ���
	 */
	public function getDataMonth($year){
		$this->jsonData['chart']['caption'] = iconv('gb2312','utf-8',$year."��ÿ�µ��˱���");
		$this->jsonData['chart']['xaxisname'] = iconv('gb2312','utf-8','1-12��');
		for($i=1; $i<=12; $i++){
			$sql = $this->sql_str.' and oph.add_date Like "'.(int)$year.'-'.str_pad($i,2,'0',STR_PAD_LEFT).'-%" ';
			$sql = tep_db_query($sql);
			$array['data'] = array();
			while ($rows = tep_db_fetch_array($sql)){
				$this->jsonData['data'][] = array('label'=>str_pad($i,2,'0',STR_PAD_LEFT).iconv('gb2312','utf-8','��'), 'value'=>$rows['TotalRevenue']);
			}
		}	
	}
	/**
	 * ȡ��ÿ������
	 * @param int $year_month Ҫͳ�Ƶ�����2013-09
	 */
	public function getDataDay($year_month){
		$this->pic_width = 1200;
		$max_i = date('t',strtotime($year_month));
		$this->jsonData['chart']['caption'] = iconv('gb2312','utf-8',$year_month."��ÿ�쵽�˱���");
		$this->jsonData['chart']['xaxisname'] = iconv('gb2312','utf-8','1-'.$max_i.'��');
		for($i=1; $i<=$max_i; $i++){
			$sql = $this->sql_str.' and oph.add_date Like "'.(string)$year_month.'-'.str_pad($i,2,'0',STR_PAD_LEFT).' %" ';
			$sql = tep_db_query($sql);
			$array['data'] = array();
			while ($rows = tep_db_fetch_array($sql)){
				$this->jsonData['data'][] = array('label'=>str_pad($i,2,'0',STR_PAD_LEFT).iconv('gb2312','utf-8','��'), 'value'=>$rows['TotalRevenue']);
			}
		}
	}
	/**
	 * ȡ�õ���ÿСʱ����
	 * @param int $year_month Ҫͳ�Ƶ�������2013-09-16
	 */
	public function getDataHours($year_month_day){
		$this->pic_width = 1200;
		$max_i = 23;
		$this->jsonData['chart']['caption'] = iconv('gb2312','utf-8',$year_month_day."ÿСʱ���˱���");
		$this->jsonData['chart']['xaxisname'] = iconv('gb2312','utf-8','0-'.$max_i.'��');
		for($i=0; $i<=$max_i; $i++){
			$sql = $this->sql_str.' and oph.add_date Like "'.(string)$year_month_day.' '.str_pad($i,2,'0',STR_PAD_LEFT).':%" ';
			$sql = tep_db_query($sql);
			$array['data'] = array();
			while ($rows = tep_db_fetch_array($sql)){
				$this->jsonData['data'][] = array('label'=>str_pad($i,2,'0',STR_PAD_LEFT).iconv('gb2312','utf-8','��'), 'value'=>$rows['TotalRevenue']);
			}
		}
	}
	/**
	 * ȡ��������
	 * @param Y-m-d $date Ҫͳ�Ƶ�����������2013-09-01
	 */
	public function getDataWeek($date){
		$now_week = date('w',strtotime($date));
		$week_start_date = date('Y-m-d', strtotime($date)-($now_week*86400));
		$whereDate = $week_start_date;
		$this->jsonData['chart']['caption'] = iconv('gb2312','utf-8',$date."���ܵ��˱���");
		$this->jsonData['chart']['xaxisname'] = iconv('gb2312','utf-8','����������');
		for($i=0; $i<=6; $i++){
			$sql = $this->sql_str.' and oph.add_date Like "'.(string)$whereDate.' %" ';
			$sql = tep_db_query($sql);
			$array['data'] = array();
			while ($rows = tep_db_fetch_array($sql)){
				$this->jsonData['data'][] = array('label'=>date('D(m-d)',strtotime($whereDate)), 'value'=>$rows['TotalRevenue']);
			}
			$whereDate = date('Y-m-d', strtotime($whereDate)+86400);
		}
	}
	/**
	 * ����json����
	 * var objJSON = {
     "chart": {
         "caption": "���ܱ��浽�˱���",
         "xaxisname": "���ܱ���",
         "yaxisname": "���˱���",
         "numberPrefix": "��"
     },
     "data": [
         {
             "label": "������",
             "value": "14400"
         },
         {
             "label": "����һ",
             "value": "14400"
         }
     ]
                            };
	 */
	public function jsonData() {
		/* $array = array ();
		$array['chart'] = array (
								"caption" => iconv('gb2312','utf-8',"���ܱ��浽�˱���"),
								"xaxisname" => iconv('gb2312','utf-8',"���ܱ���"),
								"yaxisname" => iconv('gb2312','utf-8',"���˱���"),
								"numberPrefix" => "$" 
		);
		$array['data'] = array();
		$array['data'][] = array('label'=>'001','value'=>"14400");
		$array['data'][] = array('label'=>'002','value'=>"16000"); */
		return json_encode($this->jsonData);
	}
	/**
	 * ���htmlͼ�δ���
	 * @return string
	 */
	public function output(){
		$str = 
		'<script type="text/javascript" src="/includes/javascript/chart_report/FusionCharts.js"></script>
		<div id="chartContainer"></div>
		<script type="text/javascript">
			var objJSON = '.$this->jsonData().';
			var myChart = new FusionCharts("/includes/javascript/chart_report/Column3D.swf", "myChartId", "'.$this->pic_width.'", "'.$this->pic_height.'", "0", "0" );
            myChart.setJSONData(objJSON);
            myChart.render("chartContainer");
		</script>';
		return $str;
	}
}
?>
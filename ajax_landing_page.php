<?php
//�Զ�����landing page �۸�
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );
require_once('includes/application_top.php');
require_once(DIR_FS_INCLUDES . 'ajax_encoding_control.php');

/**
 * ר��ҳ�������Զ�����
 * @author Howard
 */
class ajax_landing_page{
	/**
	 * �źű�ǩ��idǰ׺
	 * @var string
	 */
	private $model_tag = 'model_';
	/**
	 * �۸��ǩ��idǰ׺
	 * @var string
	 */
	private $new_price_tag = 'new_price_';
	/**
	 * ԭ�۱�ǩ��idǰ׺
	 * @var string
	 */
	private $old_price_tag = 'old_price_';
	/**
	 * ��Ʒ�����idǰ׺
	 * @var string
	 */
	private $title_tag = 'title_';
	/**
	 * �������idǰ׺
	 * @var string
	 */
	private $sub_title_tag = 'sub_title_';
	/**
	 * ������idǰ׺
	 * @var string
	 */
	private $start_city_tag = 'start_city_';
	/**
	 * ������idǰ׺
	 * @var string
	 */
	private $end_city_tag = 'end_city_';
	/**
	 * ��������id��ǩ
	 * @var string
	 */
	private $departure_date_tag = 'departure_date_';
	/**
	 * �г���ɫid��ǩ
	 * @var string
	 */
	private $small_description = 'small_description_';
	/**
	 * ��ƷͼƬ��idǰ׺
	 * @var string
	 */
	private $image_tag = 'image_';
	/**
	 * Ҫ�Զ������Ĳ�Ʒid��
	 * @var string
	 */
	private $p_ids;
	/**
	 * ����Ҫ�����js����
	 * @var string
	 */
	public $js_str;

	/**
	 * ר��ҳ�������Զ�������
	 * ע�⣺��1��ǰ��ҳ��Ĳ�Ʒ�۸�id��������new_price_+��Ʒid�ĸ�ʽ����2������id������title_+��Ʒid��
	 * @example 
	 * �źţ�<span id="model_3121">$100</span>
	 * ԭ�ۣ�<span id="old_price_3121">$100</span>
	 * �ּۣ�<span id="new_price_3121">$98</span>
	 * ���⣺<a id="title_3121" href="http://www.usitrip.com/niuyue-jiujinshan-hafo-daxiagu-guigu-15d-lvyou.html">ŦԼ,�ɽ�ɽ,����,��Ͽ��,���ʮ������</a>
	 * �����⣺<div id="sub_title_3121">2013��1��1�� - 2014��3��31�� : ����/����</div>
	 * �������ڣ�<div id="departure_date_3121">2013��1��1�� - 2014��3��31�� : ����/����</div>
	 * �����أ�<div id="start_city_3121">ŦԼ</div>
	 * �����أ�<div id="end_city_3121">ŦԼ, ��ʿ��</div>
	 * ͼƬ��<img id="image_3121" src="http://www.usitrip.com/web_action/familyfun/images/city2.jpg" />
	 * @param array $GET GET������
	 */
	public function __construct($GET){
		$this->p_ids = substr($_GET['p_ids'],0,-1);
		$this->js_str = '[JS]';
		$this->fixStart();
	}
	public function __destruct(){
		//print_r($this->Products);
		$this->js_str .= '[/JS]';
		$this->js_str = preg_replace('/[[:space:]]+/',' ',$this->js_str);
		echo $this->js_str;
	}
	/**
	 * ��ʼд�޸�����
	 */
	public function fixStart(){
		$p = $this->getProducts();
		if($p){
			foreach ($p as $key => $val){
				$this->fixOldPrice($val);
				$this->fixNewPrice($val);
				$this->fixModel($val);
				$this->fixTitle($val);
				$this->fixSubTitle($val);
				$this->fixStartCity($val);
				$this->fixEndCity($val);
				$this->fixDepartureDate($val);
				$this->fixSmallDescription($val);
				$this->fixImage($val);
			}
		}
	}
	
	/**
	 * �޸��ź�
	 */
	private function fixModel($rows){
		$model = $this->model_tag . $rows['products_id'];
		$this->js_str .= '
			  var '.strtoupper($model).' = document.getElementById("'.$model.'");
				if('.strtoupper($model).'!=null){
					'.strtoupper($model).'.innerHTML = "'.$rows['products_model'].'";
				}
			  ';
	}
	/**
	 * �޸���Ʒԭ��
	 */
	private function fixOldPrice($rows){
		$old_p = $this->old_price_tag . $rows['products_id'];
		$products_price = $rows['productsPrice'];
		$this->js_str .= '
			  var '.strtoupper($old_p).' = document.getElementById("'.$old_p.'");
				if('.strtoupper($old_p).'!=null){
					'.strtoupper($old_p).'.innerHTML = "'.$products_price.'";
				}
			  ';
		
	}
	/**
	 * �޸��۸�
	 */
	private function fixNewPrice($rows){		
		$new_p = $this->new_price_tag . $rows['products_id'];
		$price = $rows['newPrice'] ? $rows['newPrice'] : $rows['productsPrice'];
		$this->js_str .= '
			  var '.strtoupper($new_p).' = document.getElementById("'.$new_p.'");
				if('.strtoupper($new_p).'!=null){
					'.strtoupper($new_p).'.innerHTML = "'.$price.'";
				}
			  ';
	}
	/**
	 * �޸�����
	 */
	private function fixTitle($rows){
		$title = $this->title_tag . $rows['products_id'];
		$this->js_str .= '
			  var '.strtoupper($title).' = document.getElementById("'.$title.'");
				if('.strtoupper($title).'!=null){
					'.strtoupper($title).'.innerHTML = "'. db_to_html(tep_db_output(preg_replace('/\*\*.+/','',$rows['products_name']))).'";
				}
			  ';
	}
	/**
	 * �޸�������
	 */
	private function fixSubTitle($rows){
		$subTitle = $this->sub_title_tag . $rows['products_id'];
		if(preg_match('/\*\*(.+)\*\*/', $rows['products_name'], $matches )){
			$this->js_str .= '
				  var '.strtoupper($subTitle).' = document.getElementById("'.$subTitle.'");
					if('.strtoupper($subTitle).'!=null){
						'.strtoupper($subTitle).'.innerHTML = "'. db_to_html(tep_db_output($matches[1])) .'";
					}
				  ';
		}
	}
	/**
	 * �޸�������
	 */
	private function fixStartCity($rows){
		$tag = $this->start_city_tag . $rows['products_id'];
		$city = tep_get_product_departure_city($rows['products_id']);
		$this->js_str .= '
			  var '.strtoupper($tag).' = document.getElementById("'.$tag.'");
				if('.strtoupper($tag).'!=null){
					'.strtoupper($tag).'.innerHTML = "'. db_to_html(tep_db_output($city)) .'";
				}
			  ';
	}
	/**
	 * �޸�������
	 * @todo Ŀǰȡ�Ļ��ǳ�����
	 */
	private function fixEndCity($rows){
		$tag = $this->end_city_tag . $rows['products_id'];
		$city = tep_get_city_names($rows['departure_end_city_id']);
		$city = implode(', ', $city);
		$this->js_str .= '
			  var '.strtoupper($tag).' = document.getElementById("'.$tag.'");
				if('.strtoupper($tag).'!=null){
					'.strtoupper($tag).'.innerHTML = "'. db_to_html(tep_db_output($city)) .'";
				}
			  ';
	}
	/**
	 * �޸���������
	 */
	private function fixDepartureDate($rows){
		$tag = $this->departure_date_tag . $rows['products_id'];
		$data = tep_get_display_operate_info($rows['products_id'],1);
		$data = implode(', ', $data);
		$this->js_str .= '
			  var '.strtoupper($tag).' = document.getElementById("'.$tag.'");
				if('.strtoupper($tag).'!=null){
					'.strtoupper($tag).'.innerHTML = "'. tep_db_output($data) .'";
				}
			  ';
	}
	/**
	 * �޸��г���ɫ
	 */
	private function fixSmallDescription($rows){
		$tag = $this->small_description . $rows['products_id'];
		$this->js_str .= '
			  var '.strtoupper($tag).' = document.getElementById("'.$tag.'");
				if('.strtoupper($tag).'!=null){
					'.strtoupper($tag).'.innerHTML = "'. db_to_html(tep_db_output($rows['products_small_description'])) .'";
				}
			  ';
	}
	/**
	 * �޸�ͼƬ
	 * @todo ͼƬ��ʱ������
	 */
	private function fixImage($rows){
		
	}
	/**
	 * ȡ��Ʒ����
	 */
	private function getProducts(){
		global $currencies;
		$data = array();
		$sql = tep_db_query("select p.products_id, p.products_model, p.products_tax_class_id, p.products_price, p.departure_end_city_id, pd.products_name, pd.products_small_description from " . TABLE_PRODUCTS . " p, products_description pd where pd.language_id=1 and p.products_id=pd.products_id and p.products_id in (".$this->p_ids.") ");
		$i = 0;
		while(true && $rows = tep_db_fetch_array($sql)){
			$tax_rate_val_get = tep_get_tax_rate($rows['products_tax_class_id']);
			$new_price = tep_get_products_special_price($rows['products_id']);
			if ($new_price) {	//���ؼ�
				$products_price = $currencies->display_price($rows['products_price'], $tax_rate_val_get);
				$new_price = $currencies->display_price($new_price, $tax_rate_val_get);
				$rows['newPrice'] = $new_price;
				$rows['productsPrice'] = $products_price;		
			} else {	//���ؼ�
				//������ַ���Ԫ������
				$tour_agency_opr_currency = tep_get_tour_agency_operate_currency($rows['products_id']);
				if($tour_agency_opr_currency != 'USD' && $tour_agency_opr_currency != ''){
					$rows['products_price'] = tep_get_tour_price_in_usd($rows['products_price'],$tour_agency_opr_currency);
				}
				$rows['productsPrice'] = $currencies->display_price($rows['products_price'], $tax_rate_val_get);				
			}
			$data[$i] = $rows;
			$i++;
		}
		return $data;
	}
	
}


$content = 'ajax_landingPages';
if($_GET['action']=="process" && tep_not_null($_GET['p_ids'])){
	new ajax_landing_page($_GET);
}
?>
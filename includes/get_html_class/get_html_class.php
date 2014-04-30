<?php
/**
 * ���²ɼ���GetHtml
 * @author Howard
 * @modify by Howard at 2011-09-11
 */

class GetHtml {
	var $fileURL;	//��ҳ�ļ�����
	var $inputCharSet = "gb2312";   //��ҳԴ����
	var $outCharSet = "gb2312";   //�������
	var $dom;
	var $domGetType;	//ץȡ���ͣ���dom��curl���ַ�ʽ
	var $heardSeparatedTag; //���ݵĿ�ʼ��
	var $footSeparatedTag; //���ݵĽ�����
/**
 * ������ҳ����
 * @param $fileURL ��ҳ�ļ���ַ
 */
	function getHmtlAllContent($fileURL, $inputCharSet="", $outCharSet="", $domGetType="dom", $heardSeparatedTag="", $footSeparatedTag=""){
		if($inputCharSet!=""){
			$this->inputCharSet = $inputCharSet;
		}
		if($outCharSet!=""){
			$this->outCharSet = $outCharSet;
		}
		
		$this->dom = new DOMDocument;//new DOMDocument("1.0","utf-8");
		$this->dom->preserveWhiteSpace = false;
		$this->domGetType = $domGetType;
		$this->heardSeparatedTag = $heardSeparatedTag;
		$this->footSeparatedTag = $footSeparatedTag;
		
		if($this->heardSeparatedTag!="" || $this->footSeparatedTag!=""){ //��Ҫ�е�ͷβ����curl��ʽ��ȡ
			$this->domGetType = "curl";
		}
		
		if($this->domGetType=="curl"){
			$dm = $this->cUrlGet($fileURL);
			$dm = mb_convert_encoding($dm, 'HTML-ENTITIES', $this->inputCharSet); //�˴�ת�����룬�ǳ���Ҫ��
			if($this->heardSeparatedTag!=""){
				$hTag = mb_convert_encoding($this->heardSeparatedTag, 'HTML-ENTITIES', $this->inputCharSet);
				$dm = preg_replace('@^.*'.$hTag.'@si','',$dm);
			}
			if($this->footSeparatedTag!=""){
				$fTag = mb_convert_encoding($this->footSeparatedTag, 'HTML-ENTITIES', $this->inputCharSet);
				$dm = preg_replace('@'.$fTag.'.*@si','',$dm);
			}
			
			if(@$this->dom->loadHTML($dm)==false){
				sleep(2);
				$this->getHmtlAllContent($fileURL, $inputCharSet, $outCharSet, $domGetType, $heardSeparatedTag, $footSeparatedTag);
			}
			//echo '['.$dm.']';
			//exit;
		}else{
			if(@$this->dom->loadHTMLFile($fileURL)==false){
				sleep(2);
				$this->getHmtlAllContent($fileURL, $inputCharSet, $outCharSet, $domGetType, $heardSeparatedTag, $footSeparatedTag);
			}
		}
		//echo $this->domGetType;
	}
	
/**
 * �����������ҳ�����л�ȡ������Ҫ����Щ����
 * @param $tagName Ŀ��ı�ǩ
 * @param $attrName Ŀ������� ��id��class��
 * @param $attrValueĿ������Ե�ֵ
 * @param $filterTagName�ų�һЩ��ǩ(֧������)
 * @param $filterAttrName���ų�����Щ��ǩ������(֧������)
 * @param $filterAttrValue���ų�����Щ��ǩ������ֵ(֧������)
 * @param $getRange ��������ظ��ı�ǩ�����Ƿ�ץȡ�������ݣ������Ϊ0��ץȡȫ����Ĭ��Ϊ0���������$getRange��ֵ��ץȡ����ʽ��1,3,5-9,12��
 */
	function getTags($tagName, $attrName="", $attrValue="", $filterTagName="", $filterAttrName="", $filterAttrValue="", $getRange=0){
		$html = '';
		//$dom = new DOMDocument("1.0","utf-8");
		//$dom->preserveWhiteSpace = false;
		//@$dom->loadHTMLFile($fileURL);
		
		$domxpath = new DOMXPath($this->dom);
		$newDom = new DOMDocument;
		$newDom->formatOutput = true;
		if($attrName!=""){
			$filtered = $domxpath->query("//".$tagName. '[@' . $attrName . "='".$attrValue."']");
		}else{
			$filtered = $domxpath->query("//".$tagName);
		}
		
		// $filtered =  $domxpath->query('//div[@class="className"]');
		// '//' when you don't know 'absolute' path
	
		// since above returns DomNodeList Object
		// I use following routine to convert it to string(html); copied it from someone's post in this site. Thank you.
		
		$ns = array();
		if($getRange!=0 && $getRange!=""){
			$tmpArray = explode(',', $getRange);
			foreach($tmpArray as $key => $val){
				$val = trim($val);
				if(preg_match('/^\d+$/',$val)){
					$ns[]=($val-1);
				}else{
					$nArray = explode('-',$val);
					$st = min($nArray[0],$nArray[1]);
					$et = max($nArray[0],$nArray[1]); 
					for($j=$st; $j<=$et; $j++){
						$ns[]=($j-1);
					}
				}
			}
		}else{
			$ns[0]=0;
		}
		
		$i = 0;
		while( $myItem = $filtered->item($i++) ){
			$_i = $i-1;
			if(!in_array($_i, $ns) && $getRange!="0" && $getRange!=""){
				continue;
			}
			
			$node = $newDom->importNode( $myItem, true );    // import node
			$newDom->appendChild($node);                    // append node
		}
		$html = $newDom->saveHTML();
		//����js��css��ʽ�����
		$fp = array('@<script[^>]*?>.*?</script>@si',
					'@<noscript[^>]*?>.*?</noscript>@si',
					'@<style[^>]*?>.*?</style>@si'
					);
		$html = preg_replace($fp,'',$html);
		//���˲���Ԫ��(֧���ַ�������)
		if($filterTagName!=""){
			if(is_array($filterTagName)){
				$filterTagNames = $filterTagName;
				$filterAttrNames = $filterAttrName;
				$filterAttrValues = $filterAttrValue;
			}else{
				$filterTagNames[0] = $filterTagName;
				$filterAttrNames[0] = $filterAttrName;
				$filterAttrValues[0] = $filterAttrValue;
			}
			for($i=0, $n=sizeof($filterTagNames); $i<$n; $i++){
				$fDom =  new DOMDocument();
				@$fDom->loadHTML($html);
				$root = $fDom -> documentElement;
				foreach($root->getElementsByTagName($filterTagNames[$i]) as $elem) {
					if($filterAttrNames[$i]=="" || $elem->getAttribute($filterAttrNames[$i])==$filterAttrValues[$i]){
						$elem->parentNode->removeChild($elem);
						$i--;
						//echo $filterTagName.":".$filterAttrName.":".$_AttrVal.":".$filterAttrValue."<hr />";
					}
				} 
				$html = $fDom->saveHTML();
			}
		}
		
		if(function_exists('mb_convert_encoding')){
			$html = mb_convert_encoding($html, 'utf-8', 'HTML-ENTITIES');
		}else{
			$html = $this->html_to_utf8($html);
		}
		
		if(strtolower($this->inputCharSet)!="utf-8" && $this->inputCharSet!=""){
			$html = iconv('utf-8',$this->inputCharSet.'//IGNORE', $html);
		}
		if(strtolower($this->inputCharSet) != strtolower($this->outCharSet)){
			$html = iconv($this->inputCharSet ,$this->outCharSet.'//IGNORE', $html);
		}
		
		return $html;
	}
	
	//����ҳ����ת��utf8
	function html_to_utf8 ($data){
		return preg_replace("/\\&\\#([0-9]{3,10})\\;/e", '$this->_html_to_utf8("\\1")', $data);
	}
	
	function _html_to_utf8 ($data){
		if ($data > 127)
			{
			$i = 5;
			while (($i--) > 0)
				{
				if ($data != ($a = $data % ($p = pow(64, $i))))
					{
					$ret = chr(base_convert(str_pad(str_repeat(1, $i + 1), 8, "0"), 2, 10) + (($data - $a) / $p));
					for ($i; $i > 0; $i--)
						$ret .= chr(128 + ((($data % pow(64, $i)) - ($data % ($p = pow(64, $i - 1)))) / $p));
					break;
					}
				}
			}
			else
			$ret = "&#$data;";
		return $ret;
	}
	//��cURL��ʽȡ������
	function cUrlGet($url){
		// ��ʼ��һ�� cURL ����
		$curl = curl_init();
		// ��������Ҫץȡ��URL
		curl_setopt($curl, CURLOPT_URL, $url);
		// ����header
		curl_setopt($curl, CURLOPT_HEADER, 1);
		// ����cURL ������Ҫ�������浽�ַ����л����������Ļ�ϡ�
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// ����cURL��������ҳ
		$data = curl_exec($curl);
		// �ر�URL����
		curl_close($curl);
		// ��ʾ��õ�����
		return $data;
	}
	
}
?>
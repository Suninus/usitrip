<?php
/**
 * ��ȡͼƬ��EXIF��Ϣ
 * @author lwkai 2013-3-1 ����4:58:04
 *
 */
class Exif {
	
	/**
	 * ͼƬ�ļ�����������
	 * @var array
	 * @author lwkai 2013-3-1 ����1:43:17
	 */
	private $_img_type = array(
			"", 
			"GIF", 
			"JPG", 
			"PNG", 
			"SWF", 
			"PSD", 
			"BMP", 
			"TIFF(intel byte order)", 
			"TIFF(motorola byte order)", 
			"JPC", 
			"JP2", 
			"JPX", 
			"JB2", 
			"SWC", 
			"IFF", 
			"WBMP", 
			"XBM"
	);
	
	/**
	 * ͼƬ��Ϣ����Ƭ��������
	 * @var array
	 * @author lwkai 2013-3-1 ����1:56:48
	 */
	private $_orientation = array(
			"", 
			"top left side", 
			"top right side", 
			"bottom right side", 
			"bottom left side", 
			"left side top", 
			"right side top", 
			"right side bottom", 
			"left side bottom"
	);
	
	/**
	 * �ֱ��ʵĵ�λ
	 * @var array
	 * @author lwkai 2013-3-1 ����1:58:15
	 */
	private $_resolution_unit = array("", "", "Ӣ��", "����");
	
	/**
	 * YCbCrλ�ÿ���
	 * @var array
	 * @author lwkai 2013-3-1 ����2:00:29
	 */
	private $_ycbcr_positioning = array("", "the center of pixel array", "the datum point");
	
	/**
	 * �������
	 * @var array
	 * @author lwkai 2013-3-1 ����2:01:51
	 */
	private $_exposure_program = array(
			"δ����", 
			"�ֶ�", 
			"��׼����", 
			"��Ȧ�Ⱦ�", 
			"�����Ⱦ�", 
			"�����Ⱦ�", 
			"�˶�ģʽ", 
			"Ф��ģʽ", 
			"�羰ģʽ"
	);
	
	/**
	 * ���ģʽ
	 * @var array
	 * @author lwkai 2013-3-1 ����2:04:21
	 */
	private $_metering_mode = array(
		"0"   => "δ֪",
		"1"   => "ƽ��",
		"2"   => "�����ص�ƽ�����",
		"3"   => "���",
		"4"   => "����",
		"5"   => "����",
		"6"   => "�ֲ�",
		"255" => "����"
	);
	
	/**
	 * ��Դ
	 * @var array
	 * @author lwkai 2013-3-1 ����2:20:02
	 */
	private $_lightsource = array(
		"0"   => "δ֪",
		"1"   => "�չ�",
		"2"   => "ӫ���",
		"3"   => "��˿��",
		"10"  => "�����",
		"17"  => "��׼�ƹ�A",
		"18"  => "��׼�ƹ�B",
		"19"  => "��׼�ƹ�C",
		"20"  => "D55",
		"21"  => "D65",
		"22"  => "D75",
		"255" => "����"
	);

	/**
	 * �����
	 * @var array
	 * @author lwkai 2013-3-1 ����2:26:07
	 */
	private $_flash = array(
			"0" => "flash did not fire",
			"1" => "flash fired",
			"5" => "flash fired but strobe return light not detected",
			"7" => "flash fired and strobe return light detected",
	);
	
	/**
	 * ��ȡ��������Ϣ
	 * @var array
	 * @author lwkai 2013-3-1 ����2:34:03
	 */
	private $_info = array();
	
	/**
	 * info�н���Ӧ����������
	 * @var array
	 * @author lwkai 2013-3-1 ����4:14:40
	 */
	private $_cn_name = array(
		'FileName' => '�ļ���',	
		'FileType' => '�ļ�����',
		'MimeType' => '�ļ���ʽ',
		'FileSize' => '�ļ���С',
		'FileDateTime' => 'ʱ���',
		'ImageDescription' => 'ͼƬ˵��',
		'Make' => '������',
		'Model' => '�ͺ�',
		'Orientation' => '����',
		'XResolution' => 'ˮƽ�ֱ���',
		'YResolution' => '��ֱ�ֱ���',
		'Software' => '�������',
		'DateTime' => '�޸�ʱ��',
		'Atrist' => '����',
		'YCbCrPositioning' => 'YCbCrλ�ÿ���',
		'Copyright' => '��Ȩ',
		'Copyright.Photographer' => '��Ӱ��Ȩ',
		'Copyright.Editor' => '�༭��Ȩ',
		'ExifVersion' => 'Exif�汾',
		'FlashPixVersion' => 'FlashPix�汾',
		'DateTimeOriginal' => '����ʱ��',
		'DateTimeDigitized' => '���ֻ�ʱ��',
		'Height' => '����ֱ��ʸ�',
		'Width' => '����ֱ��ʿ�',
		'ApertureValue' => '��Ȧ',
		'ShutterSpeedValue' => '�����ٶ�',
		'ApertureFNumber' => '���Ź�Ȧ',
		'MaxApertureValue' => '����Ȧֵ',
		'ExposureTime' => '�ع�ʱ��',
		'F-Number' => 'F-Number',
		'MeteringMode' => '���ģʽ',
		'LightSource' => '��Դ',
		'Flash' => '�����',
		'ExposureMode' => '�ع�ģʽ',
		'WhiteBalance' => '��ƽ��',
		'ExposureProgram' => '�ع����',
		'ExposureBiasValue' => '�عⲹ��',
		'ISOSpeedRatings' => 'ISO�й��',
		'ComponentsConfiguration' => '��������',
		'CompressedBitsPerPixel' => 'ͼ��ѹ����',
		'FocusDistance' => '�Խ�����',
		'FocalLength' => '����',
		'FocalLengthIn35mmFilm' => '�ȼ�35mm����',
		'UserCommentEncoding' => '�û�ע�ͱ���',
		'UserComment' => '�û�ע��',
		'ColorSpace' => 'ɫ�ʿռ�',
		'ExifImageLength' => 'Exifͼ��߶�',
		'ExifImageWidth' => 'Exifͼ����',
		'FileSource' => '�ļ���Դ',
		'SceneType' => '��������',
		'Thumbnail.FileType' => '����ͼ�ļ���ʽ',
		'Thumbnail.MimeType' => '����ͼMime��ʽ'
	);

	/**
	 * ����ͼƬ��EXIF��Ϣ
	 * @param string $img ͼƬ�ľ��������ַ
	 * @return void 
	 * @author lwkai 2013-3-1 ����4:53:21
	 */
	public function __construct($img) {
		if (!file_exists($img)) {
			return;
		} 
		$exif = exif_read_data($img,"IFD0");
		if ($exif === false) {
			return;
		} else {
			$exif = exif_read_data ($img,0,true);
			/* �ļ���Ϣ */
			$this->_info['file'] = array(
				'FileName' => (isset($exif['FILE']['FileName']) ? $exif['FILE']['FileName'] : ''),
				'FileType' => (isset($exif['FILE']['FileType']) ? $this->_img_type[$exif['FILE']['FileType']] : ''),
				'MimeType' => (isset($exif['FILE']['MimeType']) ? $exif['FILE']['MimeType'] : ''),
				'FileSize' => (isset($exif['FILE']['FileSize']) ? $exif['FILE']['FileSize'] : ''),
				'FileDateTime' => (isset($exif['FILE']['FileDateTime']) ? date("Y-m-d H:i:s",$exif['FILE']['FileDateTime']) : '')
			);
			/* ͼƬ��Ϣ */
			$this->_info['picture'] = array(
				'ImageDescription' => (isset($exif['IFD0']['ImageDescription']) ? $exif['IFD0']['ImageDescription'] : ''),
				'Make' => (isset($exif['IFD0']['Make']) ? $exif['IFD0']['Make'] : ''),
				'Model' => (isset($exif['IFD0']['Model']) ? $exif['IFD0']['Model'] : ''),
				'Orientation' => (isset($exif['IFD0']['Orientation']) ? $this->_orientation[$exif['IFD0']['Orientation']] : ''),
				'XResolution' => (isset($exif['IFD0']['XResolution']) ?  $exif['IFD0']['XResolution'] : '') . (isset($exif['IFD0']['ResolutionUnit']) ? $this->_resolution_unit[$exif['IFD0']['ResolutionUnit']] : ''),
				'YResolution' => (isset($exif['IFD0']['YResolution']) ? $exif['IFD0']['YResolution'] : '')  . (isset($exif['IFD0']['ResolutionUnit']) ? $this->_resolution_unit[$exif['IFD0']['ResolutionUnit']] : ''),
				'Software' => (isset($exif['IFD0']['Software']) ? $exif['IFD0']['Software'] : ''),
				'DateTime' => (isset($exif['IFD0']['DateTime']) ? $exif['IFD0']['DateTime'] : ''),
				'Atrist' => (isset($exif['IFD0']['Artist']) ? $exif['IFD0']['Artist'] : ''),
				'YCbCrPositioning' => (isset($exif['IFD0']['YCbCrPositioning']) ? $this->_ycbcr_positioning[$exif['IFD0']['YCbCrPositioning']] : ''),
				'Copyright' => (isset($exif['IFD0']['Copyright']) ? $exif['IFD0']['Copyright'] : ''),
				'Copyright.Photographer' => (isset($exif['COMPUTED']['Copyright.Photographer']) ? $exif['COMPUTED']['Copyright.Photographer'] : ''),
				'Copyright.Editor' => (isset($exif['COMPUTED']['Copyright.Editor']) ? $exif['COMPUTED']['Copyright.Editor'] : '')
			);
			/* ������Ϣ */
			$this->_info['shooting'] = array(
				'ExifVersion' => (isset($exif['EXIF']['ExifVersion']) ? $exif['EXIF']['ExifVersion'] : ''),
				'FlashPixVersion' => (isset($exif['EXIF']['FlashPixVersion']) ? "Ver. " . number_format($exif['EXIF']['FlashPixVersion']/100, 2) : ''),
				'DateTimeOriginal' => (isset($exif['EXIF']['DateTimeOriginal']) ? $exif['EXIF']['DateTimeOriginal'] : ''),
				'DateTimeDigitized' => (isset($exif['EXIF']['DateTimeDigitized']) ? $exif['EXIF']['DateTimeDigitized'] : ''),
				'Height' => (isset($exif['COMPUTED']['Height']) ? $exif['COMPUTED']['Height'] : ''),
				'Width' => (isset($exif['COMPUTED']['Width']) ? $exif['COMPUTED']['Width'] : ''),
				/*
				 The actual aperture value of lens when the image was taken.
				Unit is APEX.
				To convert this value to ordinary F-number(F-stop),
				calculate this value's power of root 2 (=1.4142).
				For example, if the ApertureValue is '5', F-number is pow(1.41425,5) = F5.6.
				*/
				'ApertureValue' => (isset($exif['EXIF']['ApertureValue']) ? $exif['EXIF']['ApertureValue'] : ''),
				'ShutterSpeedValue' => (isset($exif['EXIF']['ShutterSpeedValue']) ? $exif['EXIF']['ShutterSpeedValue'] : ''),
				'ApertureFNumber' => (isset($exif['COMPUTED']['ApertureFNumber']) ? $exif['COMPUTED']['ApertureFNumber'] : ''),
				'MaxApertureValue' => (isset($exif['EXIF']['MaxApertureValue']) ? "F" . $exif['EXIF']['MaxApertureValue'] : ''),
				'ExposureTime' => (isset($exif['EXIF']['ExposureTime']) ? $exif['EXIF']['ExposureTime'] : ''),
				'F-Number' => (isset($exif['EXIF']['FNumber']) ? $exif['EXIF']['FNumber'] : ''),
				'MeteringMode' => (isset($exif['EXIF']['MeteringMode']) ? $this->getImageInfoVal($exif['EXIF']['MeteringMode'],$this->_metering_mode) : ''),
				'LightSource' => (isset($exif['EXIF']['LightSource']) ? $this->getImageInfoVal($exif['EXIF']['LightSource'], $this->_lightsource) : ''),
				'Flash' => (isset($exif['EXIF']['Flash']) ? $this->getImageInfoVal($exif['EXIF']['Flash'], $this->_flash) : ''),
				'ExposureMode' => (isset($exif['EXIF']['ExposureMode']) ? ($exif['EXIF']['ExposureMode'] == 1 ? "�ֶ�" : "�Զ�") : ''),
				'WhiteBalance' => (isset($exif['EXIF']['WhiteBalance']) ? ($exif['EXIF']['WhiteBalance'] == 1 ? "�ֶ�" : "�Զ�") : ''),
				'ExposureProgram' => (isset($exif['EXIF']['ExposureProgram']) ? $this->_exposure_program[$exif['EXIF']['ExposureProgram']] : ''),
					/*
					 Brightness of taken subject, unit is APEX. To calculate Exposure(Ev) from BrigtnessValue(Bv), you must add SensitivityValue(Sv).
					Ev=Bv+Sv   Sv=log((ISOSpeedRating/3.125),2)
					ISO100:Sv=5, ISO200:Sv=6, ISO400:Sv=7, ISO125:Sv=5.32.
					*/
				'ExposureBiasValue' => (isset($exif['EXIF']['ExposureBiasValue']) ? $exif['EXIF']['ExposureBiasValue'] . "EV" : ''),
				'ISOSpeedRatings' => (isset($exif['EXIF']['ISOSpeedRatings']) ? $exif['EXIF']['ISOSpeedRatings'] : ''),
				'ComponentsConfiguration' => (isset($exif['EXIF']['ComponentsConfiguration']) ? (bin2hex($exif['EXIF']['ComponentsConfiguration']) == "01020300" ? "YCbCr" : "RGB") : ''),//'0x04,0x05,0x06,0x00'="RGB" '0x01,0x02,0x03,0x00'="YCbCr"
				'CompressedBitsPerPixel' => (isset($exif['EXIF']['CompressedBitsPerPixel']) ? $exif['EXIF']['CompressedBitsPerPixel'] . "Bits/Pixel" : ''),
				'FocusDistance' => (isset($exif['COMPUTED']['FocusDistance']) ? $exif['COMPUTED']['FocusDistance'] . "m" : ''),
				'FocalLength' => (isset($exif['EXIF']['FocalLength']) ? $exif['EXIF']['FocalLength'] . "mm" : ''),
				'FocalLengthIn35mmFilm' => (isset($exif['EXIF']['FocalLengthIn35mmFilm']) ? $exif['EXIF']['FocalLengthIn35mmFilm'] . "mm" : ''),
					/*
					 Stores user comment. This tag allows to use two-byte character code or unicode. First 8 bytes describe the character code. 'JIS' is a Japanese character code (known as Kanji).
					'0x41,0x53,0x43,0x49,0x49,0x00,0x00,0x00':ASCII
					'0x4a,0x49,0x53,0x00,0x00,0x00,0x00,0x00':JIS
					'0x55,0x4e,0x49,0x43,0x4f,0x44,0x45,0x00':Unicode
					'0x00,0x00,0x00,0x00,0x00,0x00,0x00,0x00':Undefined
					*/
				'UserCommentEncoding' => (isset($exif['COMPUTED']['UserCommentEncoding']) ? $exif['COMPUTED']['UserCommentEncoding'] : ''),
				'UserComment' => (isset($exif['COMPUTED']['UserComment']) ? $exif['COMPUTED']['UserComment'] : ''),
				'ColorSpace' => (isset($exif['EXIF']['ColorSpace']) ? ($exif['EXIF']['ColorSpace'] == 1 ? "sRGB" : "Uncalibrated") : ''),
				'ExifImageLength' => (isset($exif['EXIF']['ExifImageLength']) ? $exif['EXIF']['ExifImageLength'] : ''),
				'ExifImageWidth' => (isset($exif['EXIF']['ExifImageWidth']) ? $exif['EXIF']['ExifImageWidth'] : ''),
				'FileSource' => (isset($exif['EXIF']['FileSource']) ? (bin2hex($exif['EXIF']['FileSource']) == 0x03 ? "digital still camera" : "unknown") : ''),
				'SceneType' => (isset($exif['EXIF']['SceneType']) ? (bin2hex($exif['EXIF']['SceneType']) == 0x01 ? "A directly photographed image" : "unknown") : ''),
				'Thumbnail.FileType' => (isset($exif['COMPUTED']['Thumbnail.FileType']) ? $exif['COMPUTED']['Thumbnail.FileType'] : ''),
				'Thumbnail.MimeType' => (isset($exif['COMPUTED']['Thumbnail.MimeType']) ? $exif['COMPUTED']['Thumbnail.MimeType'] : '')
			);
		}
	}
	
	/**
	 * ��ö���������ҳ���Ӧ��ֵ
	 * @param string $image_info Ҫ���ҵļ���
	 * @param array $val_arr ö�ٵ�����
	 * @return string
	 * @author lwkai 2013-3-1 ����2:06:17
	 */
	private function getImageInfoVal($image_info,$val_arr) {
		$InfoVal    =    "δ֪";
		if (!is_array($val_arr) && !is_object($val_arr)) {
			return $InfoVal;
		}
		foreach ($val_arr as $name=>$val) {
			if ($name == $image_info) {
				$InfoVal = $val;
				break;
			}
		}
		return $InfoVal;
	}

	/**
	 * ȡ��ͼƬ��EXIF��Ϣ
	 * @return array
	 * @author lwkai 2013-3-1 ����4:56:11
	 */
	public function getExif() {
		return $this->_info;
	}
	
	/**
	 * ����getExif������õ������е�KEY��ȡ�ö�Ӧ����������
	 * @param string $key
	 * @return string
	 * @author lwkai 2013-3-1 ����4:57:11
	 */
	public function getCnName($key) {
		return $this->_cn_name[$key];
	}
	
	/**
	 * ���ݶ�Ӧ���ַ�����ȡ�ö�Ӧ��KEY�����δ�ҵ����򷵻�FLASE��
	 * ע���жϵ�ʱ����===����������Ϊ0��ʱ��Ҳ��FLASH������Ҫ�þ��Ե���
	 * @param string $orientation Ҫ���ҵ��ַ�����ע���������ִ�Сд
	 * @return ��Ӧ��KEY����FLASH
	 * @author lwkai 2013-3-13 ����10:53:53
	 */
	public function getOrientationOfNumber($orientation) {
		if ($orientation) {
			return array_search($orientation, $this->_orientation);
		}
		return false;
	}
}
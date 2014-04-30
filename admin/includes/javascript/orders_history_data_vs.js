//orders_history_data_vs.js
//�������µ���ʷ��¼ǰ�����Ĳ�ͬ��Ϣ����ɫ����
!function(){
	//�Ա����鵥Ԫ���������ݣ����ı����ݲ�ͬ�ĵ�Ԫ�����ʽ���¶���Ӵ֣��ɶ�����л��ߣ���vs_class�ǶԱȵľ�ϸ��tdΪ�Աȵ�Ԫ��strΪ��Ԫ���е�ÿ���ַ����Ա�spaceΪ�Կո�Ϊ�߽�Ա�
	function cell_vs(newTd, oldTd, vs_class ){	
		if(vs_class!='str' && vs_class!='space' && vs_class!='td'){
			alert('ֻ����str|space|td����ĶԱȣ�');
			return false;
		}
		for(var j=0; j<Math.max(newTd.length, oldTd.length); j++){
			var oldText = '';
			var newText = '';
			if(jQuery(oldTd[j]).text() != jQuery(newTd[j]).text()){
				switch(vs_class){
					case 'td':	//��Ԫ�񼶱�Ա�
						newText = '<ufo>' + jQuery(newTd[j]).text() + '</ufo>';
						oldText = '<del>' + jQuery(oldTd[j]).text() + '</del>';
					break;
					case 'str':		//���뼶��Ա�
						var nTexts = jQuery(newTd[j]).text();
						var oTexts = jQuery(oldTd[j]).text();
						var delimiter = '';
					case 'space': //�ո�ָ�Ա�
						if(vs_class=='space'){
							delimiter = ' ';
							nTexts = jQuery(newTd[j]).text().split(delimiter);
							oTexts = jQuery(oldTd[j]).text().split(delimiter);
						}
						for(var k=0; k<Math.max(nTexts.length, oTexts.length); k++){
							if(typeof(nTexts[k])!='undefined' && typeof(oTexts[k])!='undefined' && nTexts[k]!=oTexts[k]){	//�¾ɶ��е���ͬ
								newText+= '<ufo>' + nTexts[k] + '</ufo>' + delimiter;
								oldText+= '<del>' + oTexts[k] + '</del>' + delimiter;
							}else if(typeof(nTexts[k])=='undefined' && typeof(oTexts[k])!='undefined'){	//�о�û����
								oldText+= '<del>' + oTexts[k] + '</del>' + delimiter;
							}else if(typeof(nTexts[k])!='undefined' && typeof(oTexts[k])=='undefined'){	//����û�о�
								newText+= '<ufo>' + nTexts[k] + '</ufo>' + delimiter;
							}else{	//�¾�һ��
								newText+= nTexts[k] + delimiter;
								oldText+= oTexts[k] + delimiter;
							}
						}
					break;
				}
			}
			
			if(typeof(oldTd[j])!='undefined' && oldText!=''){
				jQuery(oldTd[j]).html(oldText);
			}
			if(typeof(newTd[j])!='undefined' && newText!=''){
				jQuery(newTd[j]).html(newText);
			}
		}
	};

	
	//�ϳ���ַ��ʷ��¼����Ա�
	departure_location = function() {
		var newLineTd = new Array();
		var oldLineTd = new Array();
		jQuery('table[id^="departureLocationHistory_"] > tbody > tr:nth-child(3)').each(function(i) {	//���¼�¼����һ����¼(1�Ǳ��⣬2�����¼�¼��3�����¼�¼����һ����¼)
			oldLineTd[i] = jQuery(this).find(' > td').first();
			var id = jQuery(this).parents('table').attr('id');
			newLineTd[i] = jQuery('table[id^="'+id+'"] > tbody > tr:nth-child(2) > td').first();
		});
		cell_vs(newLineTd, oldLineTd, 'space');
	};
	
	//������Ϣ��ʷ��¼����Ա�
	flightInfo = function() {
		jQuery('table[id^="flightInformationHistory_"]').each(function() {
			var id = jQuery(this).attr('id');
			var newTable = '';
			var oldTable = '';
			jQuery('table[id="'+ id +'"] .flignt_info_history').each(function(i){
				//ֻ�Ա��������ʷ��¼
				if(i==0){	//��1����¼����
					newTable = jQuery(this);
				}
				if(i==1){	//��2����¼����
					oldTable = jQuery(this);
				}
			});
			if(newTable!='' && oldTable!=''){	//ȡ������Ԫ�����ݱȶ�
				var checked = true;
				var newTd = jQuery(newTable).find('td:gt(1)');	//��1��2����������ڵĵ�Ԫ�����ݣ����öԱ�
				var oldTd = jQuery(oldTable).find('td:gt(1)');
				if(jQuery(newTd).length != jQuery(oldTd).length || jQuery(newTd).length!=20){
					alert('������Ϣ��ʷ����Ѿ��޸ģ���Ҫ������Ƴ���');
					checked = false;
				}
				if(checked == true){	//��ʼ�ȶԸ�����Ԫ������
					var vsClass = 'space';	//���öԱȼ���'td'Ϊ��Ԫ�񼶱�Աȣ�'str'�Ǵ��뼶��Աȣ����뼶���ϸ��
					cell_vs(newTd, oldTd, vsClass);
				}
			}
		});
	};
	
	//������Ϣ������ʷ��¼�Ա�(ֻ�Աȵ�1��2����¼�ĵ�2(����������Ϣ)����3��(����������Ϣ))
	guest_info = function() {
		
		var newGuest = new Array();	//����������Ϣ���£�
		var oldGuest = new Array();	//����������Ϣ���ɣ�
		var newLodging = new Array();	//����������Ϣ���£� 
		var oldLodging = new Array();	//����������Ϣ���ɣ� 
		
		jQuery('table[id^="guestInfoUpdatedHistories_"] > tbody > tr:nth-child(3)').each(function(i) {	
			var _ob = jQuery(this).find(' > td');
			//alert(jQuery(_ob).length);
			oldGuest[i] = jQuery(_ob).eq(1);
			oldLodging[i] = jQuery(_ob).eq(2);	//�����������Ҫ��Ҫ�����һ������˵����ȵĻ���Ҫ�Ѵ�ֵ2�ĳɡ�����ˡ��ĵ�һ��������ֵ����
			var id = jQuery(this).parents('table').attr('id');
			var _nb = jQuery('table[id^="'+id+'"] > tbody > tr:nth-child(2) > td');
			newGuest[i] = jQuery(_nb).eq(1);
			newLodging[i] = jQuery(_nb).eq(2); //�����������Ҫ��Ҫ�����һ������˵����ȵĻ���Ҫ�Ѵ�ֵ2�ĳɡ�����ˡ��ĵ�һ��������ֵ����
		});
		//1.���������Ա�
		for(var i=0; i<oldGuest.length; i++){
			var oldGuestTable = jQuery(oldGuest[i]).find('table');	//first();	//�˵�Ԫ����ֻ��һ�����
			var newGuestTable = jQuery(newGuest[i]).find('table');	//first();	//�˵�Ԫ����ֻ��һ�����
			var oldTd = jQuery(oldGuestTable).find('td');	//�������к����td
			var newTd = jQuery(newGuestTable).find('td');
			cell_vs(newTd, oldTd, 'td');
		}
		//2.���������Ա�
		for(var i=0; i<oldLodging.length; i++){
			//alert('��'+ (i+1) +'����Ʒ������Ϣ��'+ "\n\n" +jQuery(oldLodging[i]).html());
			var oldTd = jQuery(oldLodging[i]).find('td');	//�������к����td
			var newTd = jQuery(newLodging[i]).find('td');
			cell_vs(newTd, oldTd, 'td');
		}
	};
	
	//�����ο��ֻ�������ʷ�Ա�
	cellphone_number = function(){
		var newLineTd = new Array();
		var oldLineTd = new Array();
		jQuery('table[id^="TcellphoneUpdatedHistory_"] > tbody > tr:nth-child(3)').each(function(i) {	//���¼�¼����һ����¼(1�Ǳ��⣬2�����¼�¼��3�����¼�¼����һ����¼)
			oldLineTd[i] = jQuery(this).find(' > td').first();
			var id = jQuery(this).parents('table').attr('id');
			newLineTd[i] = jQuery('table[id^="'+id+'"] > tbody > tr:nth-child(2) > td').first();
		});
		cell_vs(newLineTd, oldLineTd, 'str');
	};
	
	//ִ���ϳ���ַ�Ա�
	departure_location();
	//ִ�к�����Ϣ�Ա�
	flightInfo();
	//ִ�пͻ���Ϣ�Ա�
	guest_info();
	//ִ�е����ο��ֻ�������ʷ�Ա�
	cellphone_number();
}();
function show_rights(test){
	if (test) {$("table#grouprights tr.more").show();
	} else {$("table#grouprights tr.more").hide(); }
}
function open_dialog(url,title,height,width) {
	var round_id = 'dm_'+getRandomInt(1,9999);
	var div_dialog = '<div id="'+round_id+'"></div>';
	bootbox.dialog({message: div_dialog,title: title});
	$.post(url + "ajax-1/" , {},  function(data) {
		$('#'+round_id).html(data);
		ui_add();
		$('#'+round_id).find('form').append('<input type="hidden" name="round_id" value="'+round_id+'"/>');
	});	
}

function showThem(id){
	opendialog(id,'Форма входа',350,320);
}

function opendialog(id,title,height,width){
	var div_dialog = $('#'+id).html();
	bootbox.dialog({
		  message: div_dialog,
		  title: title
	});
}

function open_text(data,title) {
	data = data==''?'Описание скоро будет...':data;
	bootbox.dialog({ message: data, title: title}).find("div.modal-dialog").addClass("largeWidth");	
}

function bank_res(url,title) {
	$.post(url, function(data) {
		bootbox.dialog({ message: data, title: title});	
	});	
}

function ui_add(){
	$('input[type="text"],input[type="password"], textarea').addClass('form-control');
	$('select').addClass('form-control dropdown-toggle');
	$('input[type="button"]').addClass('btn btn-default');
	$('input[type="submit"]').addClass('btn btn-success');
	$('table').addClass('table');
	$('.pass_num').maskInput('** *******');
//	$('.pass_num').maskInput('** **********');
	jQuery('.daty').datepicker( {dateFormat: 'dd.mm.yy'});
	$( ".daty_from" ).datepicker({dateFormat: 'dd.mm.yy',onClose: function( selectedDate ) {$( ".daty_to" ).datepicker( "option", "minDate", selectedDate );}});
	$( ".daty_to" ).datepicker({dateFormat: 'dd.mm.yy',onClose: function( selectedDate ) {$( ".daty_from" ).datepicker( "option", "maxDate", selectedDate );}});
//	$("select.multiselect").multiselect();
	$("select").select2({enableFiltering: true});
//	$("select.multi").multiselect({enableFiltering: true});
//	$("select.multi_tur").multiselect({enableFiltering: true});
	//jQuery('.multiselect').multiselect().multiselectfilter();
	//jQuery('.multi').multiselect({multiple:false,selectedList:1}).multiselectfilter();
	//jQuery('.multi_tur').multiselect({multiple:false,selectedList:1}).multiselectfilter();
	$( ".radio" ).buttonset();
	var def_mp = $('.multi_tur').find('option:selected').attr('rel'); 
	$('#id_mp_new').val(def_mp);
	if ($('#locEdit_color').lenght)
		$('#locEdit_color').colorPicker();
	/*$('.multi_tur').bind('multiselectclick', function(event, ui) {
		var rel = $("option:selected", this).attr("rel"); 
		$("#mp_result select").val(rel);

		//$("#mp_result select").multiselect("widget").find(":radio[value='"+rel+"']").each(function() {  this.click();}); 
	});*/
}
function getRandomInt(min, max)
{
	return Math.floor(Math.random() * (max - min + 1)) + min;
}

function save_ct(user_id,round_id){
	var name = $('#name_ct').val();
	var code = $('#code_ct').val();
	if (name == '' || code == ''){
		alert('Введите название!')
	}else{
		$.post("/tc/countryNew-1/ajax-1/", {name:name,code:code},  function(data) {
			$('#result_save').html(data);
			$.post('/tc/userEdit-'+user_id+'/ajax-1/' , {},  function(data) {
				$('#'+round_id).html(data);
				ui_add();
				$('#'+round_id).find('form').append('<input type="hidden" name="round_id" value="'+round_id+'"/>');
			});
		});
	}
}

function save_mp(user_id,round_id){
	var name = $('#name_mp').val();
	if (name==''){
		alert('Введите название!')
	}else{
		var loc_id = $('#location_mp').val();
		$.post("/tc/mpNew-1/ajax-1/", {name:name,loc_id:loc_id},  function(data) {
			$('#result_save').html(data);
			$.post('/tc/userEdit-'+user_id+'/ajax-1/' , {},  function(data) {
				$('#'+round_id).html(data);
				ui_add();
				$('#'+round_id).find('form').append('<input type="hidden" name="round_id" value="'+round_id+'"/>');
			});
		});
	}
}

function save_loc(id,round_id){
	var name = $('#name_loc').val();
	if (name==''){
		alert('Введите название!')
	}else{
		$.post("/tc/locNew-1/ajax-1/", {name:name},  function(data) {
			$('#result_save').html(data);
			$.post('/tc/turEdit-'+id+'/ajax-1/' , {},  function(data) {
				$('#'+round_id).html(data);
				ui_add();
				$('#'+round_id).find('form').append('<input type="hidden" name="round_id" value="'+round_id+'"/>');
			});
		});
	}
}

function save_city(id,round_id){
	var name = $('#name_ru').val();
	if (name==''){
		alert('Введите название!')
	}else{
		var name_en = $('#name_en').val();
		var countrys = $('#countrys').val();
		$.post("/tc/cityNew-1/ajax-1/", {name:name,name_en:name_en,ct_id:countrys},  function(data) {
			$('#result_save').html(data);
			$.post('/tc/turEdit-'+id+'/ajax-1/' , {},  function(data) {
				$('#'+round_id).html(data);
				ui_add();
				$('#'+round_id).find('form').append('<input type="hidden" name="round_id" value="'+round_id+'"/>');
			});
		});
	}
}

function save_data(main,type,id,round_id){
	$.post("/tc/"+type+"-1/ajax-1/", $("#new_"+type).serialize(),  function(data) {
		$('#result_save').html(data);
		$.post('/tc/'+main+'Edit-'+id+'/ajax-1/' , {},  function(data) {
			$('#'+round_id).html(data);
			//	ui_add();
			$('#'+round_id).find('form').append('<input type="hidden" name="round_id" value="'+round_id+'"/>');
		});
	});
}

function tourist_by_passport(obj) {
	pass_num = $(obj).find('.pass_num').val();
	if (pass_num == '') {
		alert('Введите правильный номер паспорта.');
	}else{
		$.post("/turs/search_tourist-1/ajax-1/", {pn:pass_num},  function(data) {
			//Записываем по инпутам значения
			var tags = $.parseJSON(data);
			$(obj).find('tbody').show();
			if (data != '[]') {
				$(obj).find('.turist_f').val(tags[0].name_f);
				$(obj).find('.turist_i').val(tags[0].name_i);
				$(obj).find('.turist_o').val(tags[0].name_o);
				$(obj).find('.turist_dob').val(tags[0].dob);
				$(obj).find('.turist_passport').val(tags[0].passport);
				$(obj).find('.turist_country').val(tags[0].name_f);
				$(obj).find('.turist_id').val(tags[0].id);
			}else{
				alert('К сожалению, мы не нашли ваших данных.\nПопробуйте повторить поиск \nили введите данные туриста в ручную.');
			}

		});
	}

}

function check_passport (pass_input){
	var obj = $(pass_input).parent().parent().parent().parent();
	pass_num = $(obj).find('.turist_passport').val();
	pass_num = pass_num.replace(/_/g,'');
	if (pass_num.length == 10) {
		$.post("/turs/search_tourist-1/ajax-1/", {pn:pass_num},  function(data) {
			//Записываем по инпутам значения
			var tags = $.parseJSON(data);
			$(obj).find('tbody').show();
			if (data != '[]') {
				$(obj).find('.turist_passport').addClass('cheked_pass');
				$(obj).find('.turist_f').val(tags[0].name_f);
				$(obj).find('.turist_i').val(tags[0].name_i);
				$(obj).find('.turist_o').val(tags[0].name_o);
				$(obj).find('.turist_dob').val(tags[0].dob);
				$(obj).find('.turist_passport').val(tags[0].passport);
				$(obj).find('.turist_country').val(tags[0].name_f);
				$(obj).find('.turist_id').val(tags[0].id);
			}else{
				//$(obj).find('tbody input').val('');
				//$(obj).find('.turist_passport').val(pass_num);
				$(obj).find('.turist_passport').removeClass('cheked_pass');
			}

		});
	}
}

function add_turist_table(){
	var tur_table = $( '.turists_in_order:first' ).clone(false).appendTo( '.turists' ); 
	var cols = $('.turists_in_order').length;
	$(tur_table).find('.radio input').each(function( index ){
		$(this).attr('id','radio'+index+''+cols);
		$(this).attr('name','radio'+cols);
	});
	$(tur_table).find('.radio label').each(function( index ){
		var text_button = $(this).find('span').html();
		$(this).html(text_button);
		$(this).attr('for','radio'+index+''+cols);
	});
	$(tur_table).find('.mp_result div').get(0).remove();
	$(tur_table).find('.number').html(cols);
	$(tur_table).find('.turist_dob').attr('id','dob_input_'+cols).removeClass('hasDatepicker');
	$(tur_table).find('input').val('');
	$(tur_table).find('.turist_passport').removeClass('cheked_pass');
	$(tur_table).find('.delete_button').show();
	ui_add();
}

function delete_row(obj) {
    var row = obj.parentNode.parentNode;
    var table =  row.parentNode;
    if ($('tr', table).length <= 1) {
      bootbox.alert ('Эту строку нельзя удалить!');
      return false; //Не удалять последнюю строку с данными
    }else{

      //проверка на кнопку копирования
      var clone_row ='';
      if ($('.clone_row', row).html() != '') {
          clone_row = $('.clone_row', row).html();                
      }
     
      $(row).remove();  
      $('tr', table).each(function( index ) { //смещение индексов
          if (index >= 0) {
        	  var index_num = +index + 1;
              $(this).attr('class', index_num);
              //если кнопку копирования нужно вернуть
              if (clone_row != '' && ($('tr', table).length) == index_num)
                  $('.clone_row', this).html(clone_row);
          }
      });
     }
}
function clone_row(obj) {
  var row = obj.parentNode.parentNode;
  class_id=$(row).attr("class");
  class_id_new = +class_id+1;
  new_el=$(row).clone().insertAfter($(row));
  $(new_el).attr("class",class_id_new);
  $(new_el).find("input").attr('id','');
  $(new_el).find("input.daty_from").attr('class','daty_from form-control');
  $(new_el).find("input.daty_to").attr('class','daty_to form-control');
  $( ".daty_from", new_el).datepicker({dateFormat: 'dd.mm.yy',onClose: function( selectedDate ) {$( ".daty_to", new_el ).datepicker( "option", "minDate", selectedDate );}});
  $( ".daty_to", new_el).datepicker({dateFormat: 'dd.mm.yy',onClose: function( selectedDate ) {$( ".daty_from", new_el ).datepicker( "option", "maxDate", selectedDate );}});
}

/**
 *
 * @param value Значение
 * @param toId Куда записываем
 * @param toType Тип хранилища [input | select | dom DOMElement]
 * @param isSend Установить переменную и сразуже отправить
 */
function buttonSetFilter(filter_id, toValue, toId, toType, host, isSend) {
	// FilterSendRedirect()
	var fNode = document.getElementById(toId);
	if(fNode != undefined) {
		if(toType == 'input') {
			fNode.value = toValue;
		}
		if(toType == 'select') {
			/* value - is eq. SelectedIndex !!! */
			fNode.value = value;
		}
		if(toType == 'dom') {
			fNode.innerHTML = value;
		}

		if(isSend) {
			Filter_fromId = filter_id;
			Filter_host = host;
			FilterKey++;
			FilterSendRedirect();
		}
		return true;
	}
	return false;
}

var FilterWait = false;
var FilterTimer = undefined;

var Filter_host = undefined;
var Filter_fromId = undefined;
var Filter_backID = undefined;
var FilterKey = 0;

function FilterKeyUP() {
	// FilterTimer = setTimeout('');
	FilterKey++;
	FilterTimer = setTimeout('FilterSendByTimer('+FilterKey+')', 500);
}

function FilterSendByTimer(_FilterKey) {
	if(FilterKey == _FilterKey) {
		FilterSend();
	}
}

function sendFilter(_host, _fromId, _backID) {
	Filter_host = _host;
	Filter_fromId = _fromId;
	Filter_backID = _backID;

	FilterKeyUP();
}

function FilterSend() {
	host = Filter_host;
	fromId = Filter_fromId;
	backID = Filter_backID;

	var str = jQuery("#"+fromId).serialize();
	next = false;
	i = 0;
	jQuery(":text").each(function (i) {
		if(jQuery(this).val().length > 2) {
			next = true;
			i++;
		}
	});

	if(!next && i > 0) return false;


	jQuery.ajax({
		type: "POST",
		url: host,
		data: str,
		success: function(data){
			jQuery('#'+backID).html(data);
			jQuery(".datepicker").datepicker(jQuery.extend({showOn: 'button', buttonImage: '/images/calendar.gif', buttonImageOnly: true},jQuery.datepicker.regional['ru']));
		},
		error: function() {
		}
	});

	Filter_host = undefined;
	Filter_fromId = undefined;
	Filter_backID = undefined;

}

function FilterSendRedirect() {
	host = Filter_host;
	fromId = Filter_fromId;
	backID = Filter_backID;

	var str = jQuery("#"+fromId).serialize();
	next = false;
	i = 0;
	jQuery(":text").each(function (i) {
		if(jQuery(this).val().length > 2) {
			next = true;
			i++;
		}
	});

	if(!next && i > 0) return false;

	fForm = document.getElementById(fromId);

	// alert(host + '/' + str);
	if(fForm) {
		fForm.setAttribute('action', host  );
		// fForm.action = host + '/' + str;
		fForm.setAttribute('method', 'post');
		fForm.setAttribute('target', '_blank');
		fForm.submit();
	} else {
		return false;
	}

	Filter_host = undefined;
	Filter_fromId = undefined;
	Filter_backID = undefined;
}

function update_select_travels(mask){
	$('#upd_loading').html('Идет поиск...');
	$.post("/tc/travelEditSelect-0/", {mask:mask},  function(data) {
		$('#update_select').parent().html(data);
		change_mp_by_tourist ();
	});
	$('#upd_loading').html('');
}
function change_mp_by_tourist () {
	var def_mp = $('#update_select').find('option:selected').attr('rel'); 
	$("#id_mp_new").select2("val", def_mp);
	//$('#id_mp_new').val(def_mp);
}

function printBlock(printLink){
	productDesc = $('#'+printLink).html();
	$('body').addClass('printSelected');
	$('body').append('<div class="printSelection">' + productDesc + '</div>');
	window.print();
	window.setTimeout('pageCleaner()', 100); 
	return false;
}
function pageCleaner(){
	$('body').removeClass('printSelected');
	$('.printSelection').remove();
}



function email_submit(){
	var emailer_subj = $('#emailer_subj').val();
	var emailer_mails = $('#emailer_mails').val();
	var emailer_text = CKEDITOR.instances['edit_content'].getData()
	var emailer_yourmail = $('#e_from').val();
	var logs_int = setInterval('email_log_online()', 500);
	$.ajax({
		  type: "POST",
		  url: "/email/send-1/ajax-1/",
		  data: {emailer_subj:emailer_subj,emailer_mails:emailer_mails,emailer_text:emailer_text,emailer_yourmail:emailer_yourmail},
		  global: false,
		  success:function(data){
			clearInterval(logs_int);
			$('#submit_input').css('background-image', 'none');
			$("#submit_result").html(data);	
			$("#reload_button").show();	
		  }
		});
}

function email_log_online(){
	var old_data = $('#submit_input').val();
	
	$.ajax({
		  type: "POST",
		  url: "/email_log.php",
		  global: false,
		  success:function(data){
			  if (data != '' && old_data != data){
					$('#submit_input').val(data);
					$("#submit_button").hide();
					$("#submit_input").show();
			}
		  }
		});
}
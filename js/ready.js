jQuery(function($){
	
	 // Please wait...
	  var $loading = $('#loadingDiv').hide();
	  $(document)
	  .ajaxStart(function () {
	    $loading.show();
	  })
	  .ajaxStop(function () {
	    $loading.hide();
	  });
	// Защита от бэкспейса и ентера в формах
	  var keyStop = {
			   8: ":not(input:text, textarea, input:file, input:password)", // stop backspace = back
			   13: "input:text, input:password", // stop enter = submit 

			   end: null
			 };
			 $(document).bind("keydown", function(event){
			  var selector = keyStop[event.which];

			  if(selector !== undefined && $(event.target).is(selector)) {
			      event.preventDefault(); //stop event
			  }
			  return true;
			 });
	  
$('.thumbnail').click(function(){
  	var src = $(this).attr("src");
  	var img = '<img src="'+src+'" style="width: 100%;" />'
	bootbox.alert(img);
});
	  
	if ($('.camera_wrap').length > 0)
		$('.camera_wrap').camera({
			height: '300px'
		});
	
	$("#back-top").hide();
	$(function () {
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

	ui_add();

	$.datepicker.regional['ru'] = {
			changeMonth: true,
			changeYear: true,
			closeText: 'Закрыть',
			prevText: '&#x3c;Пред',
			nextText: 'След&#x3e;',
			currentText: 'Сегодня',
			monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
			             'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
			             monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
			                               'Июл','Авг','Сен','Окт','Ноя','Дек'],
			                               dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
			                               dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
			                               dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
			                               yearRange: "1930:2020",
			                               dateFormat: 'dd.mm.yy', firstDay: 1,
			                               isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
	
/** Форма подписки на новости */	
	$('#newsletter-signup').submit(function(){
		
		//Проверяем, не отправляется ли уже форма в текущий момент времени
		if($(this).data('formstatus') !== 'submitting'){
		
			//Устанавливаем переменные
			var form = $(this),
				formData = form.serialize(),
				formUrl = form.attr('action'),
				formMethod = form.attr('method'), 
				responseMsg = $('#signup-response');
			
			//Добавляем дату к форме
			form.data('formstatus','submitting');
			
			//Показываем соообщение с просьбой подождать
			responseMsg.hide()
					   .addClass('response-waiting')
					   .text('Пожалуйста, подождите...')
					   .fadeIn(200);
			
			//Отправляем данные на сервер для проверки
			$.ajax({
				url: formUrl,
				type: formMethod,
				data: formData,
				success:function(data){
					
					//Устанавливаем переменные
					var responseData = jQuery.parseJSON(data), 
						klass = '';
					
					//Состояния ответа
					switch(responseData.status){
						case 'error':
							klass = 'response-error';
						break;
						case 'success':
							klass = 'response-success';
						break;	
					}
					
					//Показываем сообщение ответа
					responseMsg.fadeOut(200,function(){
						$(this).removeClass('response-waiting')
							   .addClass(klass)
							   .text(responseData.message)
							   .fadeIn(200,function(){
								   //Устанавливаем таймаут для скрытия сообщения ответа
								   setTimeout(function(){
									   responseMsg.fadeOut(200,function(){
									       $(this).removeClass(klass);
										   form.data('formstatus','idle');
									   });
								   },3000)
								});
					});
				}
			});
		}
		
		//Предотвращаем отправку формы
		return false;
	});

});
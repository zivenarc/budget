var MAX_FILE_SIZE=10000000;
var DATE_FORMAT = 'dd.mm.yy';
var MYSQL_DATE_FORMAT = 'yy-mm-dd';
var isrc = new Array();
var strLocal = strLocal || '';
var cache = {},	lastXhr;

$(document).ready(function(){
		$.datepicker.setDefaults({
			constrainInput:true
			,dateFormat:DATE_FORMAT
			,altFormat: MYSQL_DATE_FORMAT
			,firstDay:1
			,showOtherMonths: true
			,selectOtherMonths: true
			,showWeek: true
		});
		if(jQuery().timepicker) {
			$.timepicker.setDefaults({
				dateFormat:DATE_FORMAT,
				timeFormat:'HH:mm',
				altFormat:MYSQL_DATE_FORMAT,
				altTimeFormat:'HH:mm',
				altSeparator:' ',
				altFieldTimeOnly: false,
				stepMinute:15,
				parse:'strict',
				pickerTimeFormat:'HH:mm'		
			});
		} else {
			console.log('jQ.timepicker needs to be attached');
		}
		if (strLocal){
			$.datepicker.setDefaults({
				dayNamesMin:['Вс','Пн','Вт','Ср','Чт','Пт','Сб']
				,dayNames:['Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота']
				,monthNames:['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь']
				,monthNamesShort:['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек']
			});
			if(jQuery().timepicker) {
				$.timepicker.setDefaults({
					timeOnlyTitle: 'Выберите время',
					timeText: 'Время',
					hourText: 'Часы',
					minuteText: 'Минуты',
					secondText: 'Секунды',
					millisecText: 'Миллисекунды',
					timezoneText: 'Часовой пояс',
					currentText: 'Сейчас',
					closeText: 'Закрыть',				
					amNames: ['AM', 'A'],
					pmNames: ['PM', 'P'],
					isRTL: false
				});	
			}
		}
		
		MsgShow();
		
		if (typeof(itemGUID)!='undefined'){
			loadEventLog(itemGUID);
			loadFileList(itemGUID);
			loadStickers(itemGUID);
		}
		
		initCheckboxes();
		initGroups($('#entity'));
		initialize_autocomplete($('#entity'));
		
		$.event.props.push('dataTransfer');
		$("body").on('drop', function(event) {
			event.preventDefault();	
			if (typeof(event.dataTransfer.files) == 'undefined') {
				$('#sysmsg').text("Этот браузер не поддерживает функции перетаскивания файлов. Воспользуйтесь Google Chrome.").addClass('error').show().delay(15000).fadeOut();
				 $('.upload_container').removeClass('container_droppable');	
				 
				return (false);
			};
			for(i=0;i<event.dataTransfer.files.length;i++){			
				if($('#entity_files div').css('display')=='none') $('#entity_files div').slideDown();
				file = event.dataTransfer.files[i];
				if (file.type.match('application/pdf')) {
					var xhr = new XMLHttpRequest();
					xhr.open('POST', "ajax_upload.php", true);
					xhr.newLi = getFileItem({},{type:'loading'}).prependTo('#entity_files table tbody');
					xhr.onreadystatechange = function(xhr) {
						switch (this.readyState){
							case 0:							
								this.newLi.show();
								break;
							case 4:
								if(this.status == 200) {
									var fileResult = $.parseJSON(this.responseText);
									console.log(fileResult);	
									this.newLi.hide();
									getFileItem(fileResult).prependTo('#entity_files tbody').fadeIn();															 
								}
								break;
							default:						
								break;	
						
						}
						
					};
					var fd = new FormData();
					fd.append('file', file);				
					var fuData = $('form#entity').serializeArray();				
					for (j=0;j<fuData.length;j++){
						fd.append(fuData[j].name,fuData[j].value);
					}
					fd.append('guid',itemGUID);
					fd.append('field',prefix+'File');
					xhr.send(fd);
				
				} else {
					this.newTr = getFileItem(file,{type:'error'}).prependTo('#entity_files table tbody').delay(10000).fadeOut();
					console.error('Unsupported file type was dragged. It should be PDF only.');
				}
			}
			 $('.upload_container').removeClass('container_droppable');
		}).on("dragover", function(event) {
		  $('.upload_container').addClass('container_droppable');		  
		  return false;
		}).on("dragleave", function(event) {
			 $('.upload_container').removeClass('container_droppable');			 
		});
		
		
});

function efAutocompleteSettings(field){
	var res = {
				minLength: 3,
				source: function( request, response ) {
					
					var term = request.term;
					if ( term in cache ) {
						response( cache[ term ] );
						return;
					}
					
					lastXhr = $.getJSON( 'json_list.php?table='+field.table, request, function( data, status, xhr ) {
						cache[ term ] = data;
						if ( xhr === lastXhr ) {
							response( data );
						}
					});
				},
				search: function (event,ui) {
				$( "#input_"+field_id).addClass('autocomplete-loading');
				},
				select: function( event, ui ) {
					field_id = field.field;
					$( "#"+field.field ).val(ui.item.value);
					$( "#input_"+field.field).val(ui.item.label).removeClass('autocomplete-loading') ;
					/*if (window.autocomplete_callback) {
						autocomplete_callback(field_id,ui.item.value); //---defined in {entity_form}.js
					}*/
					return false;
				}
			};
	return (res);
}

function loadFileList(guid){
	$('#entity_files').html('').append($('<div>',{'class':'panel'})
								.append($('<h4>',{text:(strLocal?'Файлы':'Files')}))
								.append($('<div>',{id:'filelist_spinner','class':'spinner',text:(strLocal?'Загрузка...':'Loading')}))
							);
	$.ajax({
		type: "GET",
		dataType: 'json',
		url: 'json_files.php',
		data: {guid:guid, order:'asc'},		
		success: function(data){	
			$('#filelist_spinner').detach();
			var filelist = $('<table>',{'class':'log files',id:'file_list_table'}).appendTo('#entity_files div');
			filelist.append('<thead>').append('<tbody>');
			filelist.children('thead').append($('<tr>')
										.append($('<th>',{text:(strLocal?'Файл':'File')}))
										.append($('<th>',{text:(strLocal?'Размер':'Size')}))
										.append($('<th>',{text:(strLocal?'Автор':'Author')}))
										.append($('<th>',{text:(strLocal?'Время':'Timestamp')}))										
										);
			for(i=0;i<data.length;i++){
				filelist.children('tbody').prepend(getFileItem(data[i]));				
			}
		}
	});
	;
}

function getFileItem(data, options){
	options = options || {type:''};	
	switch (options.type){
		case 'error':
			fileItem = $('<tr>').append($('<td>',{colspan:"4"}).append($('<div>',{'class':"error", text: 'Тип файлов ['+data.type+'] запрещен администратором. Файл '+data.name+' не может быть загружен'})));
			break;
		case 'loading':
			fileItem = $('<tr>').append($('<td>',{colspan:"4"}).append($('<div>',{'class':"spinner", text:(strLocal?'Загрузка...':'Loading...')})));
			break;
		default:			
			fileItem = $('<tr>').append($('<td>').append($('<a>',{href:'getfile.php?id='+data.file,
																'class':data['class'],
																text:data.alias})))
								.append($('<td>',{text:data.size}))
								.append($('<td>',{text:data.author}))
								.append($('<td>',{text:data.date}));
	}
	return (fileItem);
}

function process_entity(event_id, flagMessage, flagValidation, event){ //====================== Переведен на UI =====================
	

	var vac_form = $("form#entity").get(0);
	var $actID = $('#actID');
	
	if ($actID.length){
		$actID.val(event_id);
	} else {
		$("form#entity").append($("<input/>",{type: "hidden"
											,id: "actID"
											,name: "actID"
											,value: event_id}));
	};
	
	flagMessage = flagMessage || event.ctrlKey;
	
	if (flagMessage) {
		if (flagValidation) {
			var res = validate();
			if (!res) return (false);
		};
		
		fadePDF('out');
		
		//$('#actionComment').dialog('destroy');
		$('#actionComment').dialog({
			title: (strLocal?'Прокомментируйте это действие':'Please make a comment'),
			modal:true,
			width:'auto',
			buttons:[
				{	
					text:'Ok',
					click: function(){
						if (mysubmitfunc($(this))){
							an = $(this).children('#aclComment_');	
							var comment = an.val().replace("\n","<br/>");
							$("form#entity").append($('<input/>',{type:'hidden'
																,id: 'aclComment' 
																,name: 'aclComment'
																,value: comment}));							
								save(!flagValidation);
							$(this).dialog('close');
						}
					}
				},
				{	
					text:(strLocal?'Отмена':'Cancel'),
					click: function(){
						$(this).dialog('close');
					}
				}
			]
		});		
	} else {
		save(!flagValidation);
	}
}

function mysubmitfunc(o){
      var an = o.children('#aclComment_');
      if(an.val() == ""){
            an.addClass('error_field');
            return false;
      }
     return true;
}
	



function showRequest(formData, jqForm, options) { 
	console.log(formData);
    return (true); 
} 

function save(flagExempt){
	flagExempt = flagExempt || false;
	var options;
	
	if (!flagExempt){
		var options = {
					success: updateEntity,
					url: PHP_SELF,
					beforeSubmit: function(){ return easyValidate($('#entity'));}
					};
	} else {
		var options = {
					success: updateEntity,
					url: PHP_SELF
					};
	};
	
	$('#loader').ajaxStart(function() {$(this).show();})
				.ajaxStop(function() {$(this).fadeOut('slow');});
	
	$("#error_log").ajaxError(function(event, request, settings, exception){
		$(this).text("Error requesting page " + settings.url+ ": "+ exception);
	});
	
	$('#entity').ajaxSubmit(options);

}


function updateEntity(responseText, statusText, xhr){
	
	var myHTML = $(responseText);

	//console.log(myHTML);
	var sFrameContent = myHTML.children('#frameContent').html();
	
	if (sFrameContent == null){
		$("#error_log").html(myHTML.html()).addClass('warning');
		var sErrorMessage = strLocal ?'<h4>Ошибка обновления окна документа. Необходимо <a href="'+location.href+'">открыть</a> документ заново</h4>'
									:'<h4>There was an error during the update, you need to <a href="'+location.href+'">reopen</a> this document</h4>';
		$('#menubar').html(sErrorMessage);
		$('input').attr('disabled',true);
		$('#frameContent *').children().css('color','#777');
	} else {
		$('#menubar').html(myHTML.children('#menubar').html());
		$('#frameContent').html(sFrameContent);
		$('#sysmsg').html(myHTML.find('#sysmsg').html());
		MsgShow();
		fadePDF('in');
		$('input.hasDatepicker').removeClass('hasDatepicker');
		initializeForm();
		initCheckboxes();
		initialize_autocomplete($('#entity'));
		//initialize_inputs($('#entity'));
		itemID=$('#'+prefix+'ID').val();
	}
	
	if (typeof(itemGUID)!='undefined'){
		loadEventLog(itemGUID);
		loadFileList(itemGUID);
		//loadStickers(itemGUID);
	}
}

function whosNext(){ //====================== Переведен на UI =====================
	
	//var txt = "<div id='whosNext'></div>";

	fadePDF('out');
	
	$('#whosNext').dialog({
		create:function(){
				$(this).load('rep_entity_access.php?ID='+itemID+'&entity='+entity+'  #frameContent');
			}
		,title:(strLocal?'Кто следующий?':'Who is next?')
		,width:'auto'
		,minWidth:400
		,position:[60,40]
		,close: function(){
			fadePDF('in');
		}
		,modal:true	
		,buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		}
	);

}

function copy_entity(){
	
	alert('Функция пока не реализована');
	return false;
	var itemID=0;
	$('#'+prefix+'ID').val('');
	$('#'+prefix+'StateID').val('');
	$('#'+prefix+'GUID').val('');
	save(true);
	
	itemID=$('#'+prefix+'ID').val()*1;
	
}

function assign(){ //====================== Переведен на UI =====================
	//$('#sendTo').dialog('destroy');
	$('#sendTo').dialog({
		modal:true,
		width:'auto',
		title:(strLocal?'Отправить сообщение':'Send a message'),
		create:function(){
					initialize_autocomplete($('#send_form'));
		},
		buttons:  [
					{
						text: "Ok",
						click: function() { 
								var addr = $('#recipient');
								var addrCc = $('#recipient_cc');
								var addrText = $('#input_recipient');
								var message = $('#message');
						
							if(addrText.val() == ""){
								addrText.addClass('error_field');
								return false;
							}
							
							if(message.val() == ""){
								message.addClass('error_field');
								return false;
							}
							
							$.post("sp_inform.php",{ID:itemID, message:message.val(), recipient:addr.val(), recipient_cc: addrCc.val(), entity: entity}, function(data){
								if(data.status=='success'){
									$("#sysmsg").text((strLocal?'Сообщение отправлено по адресу ':'Message sent to')+data.to);
									MsgShow();									
								} else {
									$('#error_log').append($('<div>',{'class':'error',html:data.errorText}));
								}
								getSticker(data).prependTo($('#sticky_notes')).fadeIn();
							});
							fadePDF('in');
							
							$(this).dialog("close"); 
						}
					},
					{
						text: "Cancel",
						click: function() { $(this).dialog("close"); }
					}
				]
		
	
	});
	
}
/*function __initialize_autocomplete($Input, flagMultiple){
		
		flagMultiple = flagMultiple || false;
			
		arrData = $.parseJson($input.attr('src'));
		var url = 'ajax_list.php?table='+arrData.table+"&prefix="+arrData.prefix;
		
		$Input.autocomplete(url, {
			width: $(this).attr('width'),
			multiple: flagMultiple,
			matchContains: true,
			minChars: 3,
			formatItem: formatItem,
			formatResult: formatResult
		});
		$Input.result(function(event, data, formatted) {
			if (data)
				var $hidden = $(this).prev("input")
				if (flagMultiple){
					$hidden.val( ($hidden.val() ? $hidden.val() + ";" : $hidden.val()) + data[1]);
				} else {
					$hidden.val(data[1]);
				};
		});

}*/

function load_user_status(obj,id){
	var $invoker = $(obj.currentTarget);
	var sID = $invoker.attr('id').replace('input_','')+'_details';
	var $details = $('#'+sID);
	//console.log(sID);
	$.get("ajax_user_where.php"
			, {user:id}
			, function(data, textStatus){						
				$details.html(data);				
			}
			,'html'
		);	

}

function loadEventLog(guid){
	$('#event_log').html('');
	$('#event_log').append($('<div>',{'class':'panel'})
									.append($('<h4>',{text:(strLocal?'История изменений':'Event log')}))
									.append($('<div>',{id:'event_log_spinner','class':'spinner',text:(strLocal?'Загрузка...':'Loading...')}))
							);
		
	$.ajax({
		type: "GET",
		dataType: 'json',
		url: 'json_action_log.php',
		data: {guid:guid, order:'asc'},		
		success: function(data){
			$('#event_log_spinner').detach();
			var eventLog = $('<table>',{'class':'log',id:'event_log_table'}).appendTo('#event_log div');
			eventLog.append('<thead>').append('<tbody>');
			eventLog.children('thead').append($('<tr>')
										.append($('<th>',{text:(strLocal?'Действие':'Action')}))
										.append($('<th>',{text:(strLocal?'Ответственный':'User')}))
										.append($('<th>',{text:(strLocal?'Время':'Timestamp')}))										
										);
			for(i=0;i<data.length;i++){
				eventLog.children('tbody').append(getEventItem(data[i]));				
			}
		}
	});
	

}

function getEventItem(data){
	var eventItem = $('<tr>').append($('<td>',{text:data.actTitlePastLocal}))
							.append($('<td>',{text:data.usrTitleLocal}))
							.append($('<td>',{text:data.aclInsertDate}));
	if(data.aclComment!=''){				
					eventItem = $().add(eventItem).add($('<tr>').append($('<td>',{colspan:3,'class':'log_comment',html:data.aclComment})))
	}										
	return(eventItem);
}

function loadStickers(guid, options){
	options = options || {limit:''};
	if(options.limit==''){ 
		$('#sticky_notes').html('');
	}
	$.ajax({
		type: "GET",
		dataType: 'json',
		url: 'json_stickers.php',
		data: {guid:guid, limit:options.limit},		
		success: function(data){									
			for(i=0;i<data.length;i++){
				$('#sticky_notes').append(getSticker(data[i]));
			}
		}
	});
}

function getSticker(data){
	var sticker = $('<div>',{'class':'sticky_note'})
										.append($('<h3>',{text:data.msgInsertDate}))
										//.append($('<p>',{text:data.msgRecipient}))
										.append($('<p>',{text:data.msgText}))										
										.append($('<p>',{'class':'sticky_note_footer',text:data.usrTitle}));
	return(sticker);
}

function getEmployeeData(id, target){
	//----- Under construction
}

function getCompanyData(id, target){
	
}

function fadePDF(direction){
	direction = direction || 'out';
	if ($.browser.webkit) return(false);
	switch (direction){
		case 'out':
			$('iframe').each(function(i){
				isrc[i] = $(this).attr('src');
				$(this).attr('src','about:blank');
			});
		break;
		case 'in':
			
			$('iframe').each(function(i){
				$(this).attr('src',isrc[i]);
			});
		break;
		default:
			return (false);
		break;
	};
}

function easyValidate($form){
		
	$('input, textarea').removeClass('error_field');
	$('span.i-error, div.i-error').html('');
		
	if (validate()) {
		$form = $form || $('#entity');
		
		var res;
		$form.children('input').each(function(){
			if ($(this).hasClass('mandatory') && $(this).val()=='') {
				$(this).addClass('error_field');
				res = false;
			}
		});
	} else { 
		res = false;
	}
	return (res);
}

function bookmark(flag, event){
	var $button = $(event.srcElement);
	if (flag) {
		$.post('sp_bookmark.php',{ID:itemID, entity:entity, DataAction:'mark'}, function(data){
			$button.html(data);
			$button.attr('href','javascript:bookmark(0,event);').toggleClass('bookmark').toggleClass('unbookmark');
		});
	} else {
		$.post('sp_bookmark.php',{ID:itemID, entity:entity, DataAction:'unmark'}, function(data){
			$button.html(data);
			$button.attr('href','javascript:bookmark(1,event);').toggleClass('bookmark').toggleClass('unbookmark');
		});
	}

}

function init_fileAddButton(obj){
	if (obj){	
		var file_inputs =obj.parent().find('input[type="file"]');
		if(file_inputs){
			//console.log(file_inputs);
			var file_input_name = file_inputs.attr('name');
			file_input_name = file_input_name.replace('[]','');
			file_input_name += '[]';
			file_inputs.attr('name',file_input_name);
			
			var file_input_new = file_inputs.parent('div').parent('div').clone();
			file_input_new.find('button').remove();
			file_input_new.insertAfter(file_inputs.parent('div').parent('div')).find('input[type="file"]').val('');
		} else {
			console.error ("Couldn't find the input object");
			return(false);
		}
	} else {
		console.error('Warning: there is no object to init');
		return(false);
	}
}

function initialize_autocomplete(oForm){

	console.log('Looking for AC in '+oForm.attr('id')+'...');

	oForm.find("input.autocomplete").each(function(){
		var arrData = $.parseJSON($(this).attr('data-autocomplete'));		
		var field_id = $(this).attr('id').replace('input_','');
		var url = 'json_list.php?table='+arrData.table;
		
		console.log(this);
		
		$(this).autocomplete({
			minLength: 3,
			source: function( request, response ) {
				
				var term = request.term;
				if ( term in cache ) {
					response( cache[ term ] );
					return;
				}
				
				lastXhr = $.getJSON( url, request, function( data, status, xhr ) {
					cache[ term ] = data;
					if ( xhr === lastXhr ) {
						response( data );
					}
				});
			},
			search: function (event,ui) {
				$( "#input_"+field_id).addClass('autocomplete-loading');
			},
			select: function( event, ui ) {
				$( "#"+field_id ).val(ui.item.value);
				$( "#input_"+field_id).val(ui.item.label).removeClass('autocomplete-loading') ;
				if (window.autocomplete_callback) {
					autocomplete_callback(field_id,ui.item.value); //---defined in {entity_form}.js
				}
				return false;
			}
		});
	});
}

function field_autocomplete(obj){
		
}

function load_employee_details(id){
	$.post("ajax_details.php"
			, {table:'vw_employee_short',empID:id}
			, function(data, textStatus){
				console.log(data);
				$('#employee_photo_container').load('ajax_employee_photo.php?empID='+id);
				
				$('#brqBeneficiary').val(data.empBeneficiary);	
				$('#brqAccount').val(data.empAccount);	
				$('#brqPayment').val(data.empPaymentOptions);	
				$('#brqBankID').val(data.empBankID);	
				$('#brqINN').val(data.empBeneficiaryINN);	
				
				if(window.load_bank_details) {
					load_bank_details(data.empBankID);
				}
				
				$('#otmProfitID').val(data.empProfitID);	
				$('#otmEmployeeID_details').html('<span>'+data.funTitleLocal+'</span>').children('span').addClass((data.funFlagWC?'white-collar':'blue-collar'));
				
				$('#rsgProfitID').val(data.empProfitID);

				$('#sklProfitID').val(data.empProfitID);					
				
				$('#trvProfitID').val(data.empProfitID);
				
				$('#vacProfitID').val(data.empProfitID);	
			}
			,'json'
		);

}

function getEasyField(data){
	
}

function fillEasyForm(data){
	
	//$('#entity').html('');
	for (f=0;f<data.length;f++){		
		if(data[f].group){
			groupID = data[f].group.hashCode();
			var fs = $('#'+groupID);
			if(fs.length==0){
				fs = $('<fieldset>',{id:groupID}).appendTo('#entity').append($('<legend>',{text:data[f].group}));
			};
			fs.append(getEasyField(data[f]));
		} else {
			$('#entity').append(getEasyField(data[f]));
		}
	}	
}

function initGroups($Form){
	$Form.find('div.f-row').each(function(){
		var group = $(this).attr('data-group');
		if(group){
			if(group.length){
				groupID = group.hashCode();
				var fs = $('#'+groupID);
				if(fs.length==0){
					fs = $('<fieldset>',{id:groupID}).appendTo('#entity').append($('<legend>',{text:group}));
				};
				fs.append($(this));
			} else {
				
			}
		}
	});
}

function initCheckboxes(){
	$("input.i-checkbox").click(function(){
		var b = $(this).is(":checked");
		$(this).toggleClass("checked");
		var oInput = $(this).prev("input");
		oInput.attr("value", b*1);
	});
}

function mysqlParseDate(input){
	if(input){
		try {
		var arrDT = input.split(' ');
		var arrD = arrDT[0].split('-');
		var arrT = arrDT[1].split(':');
		var res = new Date();
		res.setDate(+arrD[2]);
		res.setMonth(+arrD[1]-1);
		res.setFullYear(+arrD[0]);
		res.setHours(+arrT[0]);
		res.setMinutes(+arrT[1]);
		res.setSeconds(+arrT[2]);
		return(res);
		} catch (err) {
			console.log(err);
			return(false);
		}
	} else {
		console.log('Error, no input supplied');
		return(false);
	}
		
}

String.prototype.hashCode = function(){
	var hash = 0;
	if (this.length == 0) return hash;
	for (i = 0; i < this.length; i++) {
		char = this.charCodeAt(i);
		hash = ((hash<<5)-hash)+char;
		hash = hash & hash; // Convert to 32bit integer
	}
	return hash;
}

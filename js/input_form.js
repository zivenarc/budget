var months = Array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');
var cache = {},	lastXhr;

var tabs_options = {beforeLoad: function( event, ui ) {
				$(ui.panel).html(spinner_div());
				ui.jqXHR.error(function() {
					  $(ui.panel).html(
						"<div class='error'>Error loading the data</div>" );
					});
				 },
				create:function(){
					if(doc){
						if(doc.flagPosted==1){
							$(this).tabs('option','active',2);
						}
					}
				},
				spinner:'',
				load: function (event, ui) {
					
				},	
			};

function spinner_div(){
	var res = $('<div>',{'class':'spinner',html:'Loading...'});
	return (res);
}

$(document).ready(function(){
	$('#tabs').tabs(tabs_options);
		
		initCheckboxes();
		initGroups($('#entity'));
		initialize_autocomplete($('#entity'));
});

function rowTotalsInitialize(){
	var styles = new Array();
	if (doc!=undefined){
		for (m=0;m<months.length;m++){
			styles.push('.'+doc.gridName+'_'+months[m]);	
		};
		$(styles.join()).each(function(){
			$(this).change(function(){
				recalcYTD($(this));
			})
		});
		$('form').submit(function(){
			event.preventDefault();
		});
	}
}

function formulaInitialize(){
	$("input[name='formula[]']").each(function(index){
		paintDependent($(this));
		$(this).change(function(){		
				paintDependent($(this));			
		});
	});
}

function hookListeners($o){
	$o.removeClass('error_field');
	if($o.val().match(/^=R[0-9]+/)){
		var matches = $o.val().match(/[0-9]+$/);
		console.log(matches);
		var tr = $o.parents('tr');
		tr.addClass('budget-dependent');
		for(m=0;m<months.length;m++){
			var mask = "input[name='"+months[m]+"[]']";
			var $inp = tr.find(mask);
			$inp.focus(function(){
				$(this).blur();
			});
			var id = tr.find("input[name='id[]']").val();
			$inp.attr('id',months[m]+'_'+id);

			$(mask).each(function(index){
				if (index==matches[0]){					
					$(this).change(function(){
						target_id = '#'+$(this).attr('name').replace('[]','')+'_'+id;	
						// console.log('QQ'+$(this).val()+'->'+target_id);						
						$(target_id).val($(this).val()).change();
						//recalcYTD($o);
					})
				}
			});
			
		}
		
		//grid.enable_formula = true;
	} else {
		unhookListeners($o);
		$o.addClass('error_field');
		return (false);
	}
}

function paintDependent($o){
	var tr = $o.parents('tr');
	var grid=eiseGrid_find(doc.gridName);
	//grid.enable_formula = false;
	if ($o.val()){
		hookListeners($o);
	} else {
		tr.removeClass('budget-dependent');
		unhookListeners($o);
	}
}

function unhookListeners($o){
	
}

function recalcYTD($o){
	var $row = $o.parent('tr');
	if(doc!=undefined){
		var $ytd = $row.find('td.'+doc.gridName+'_YTD div');
		
		var res = 0;
		for (m=0;m<months.length;m++){
			res += parseFloat($row.find('td.'+doc.gridName+'_'+months[m]+' input').val());
		}
		$ytd.text(res);
	}
}

function budget_save(arg){
	arg=arg||'update';
	$('#DataAction').val(arg);
	var data = $( "input, textarea, select" ).serialize();
	
	if (validate()){
		
		//console.log(data);
		$('#loader').show();
		$.post(location.pathname,data, function(responseText){
			console.log(responseText);
			
			if (responseText.status=='success'){

				
				$gridUpdated = $("input[name='inp_"+doc.gridName+"_updated[]']");
				var flagUpdated = false;
				$gridUpdated.each(function(){
					if ($(this).val()) flagUpdated = true;
				});
				
				
				$gridDeleted = $("input[name='inp_"+doc.gridName+"_deleted']");
				
				console.log($gridUpdated);
				console.log($gridDeleted);
				
				if (flagUpdated || $gridDeleted.val()){
					$gridUpdated.val('');
					$gridDeleted.val('');		
					
					$('#tabs-input').load(location.href+' #tabs-input', function(){
						$('#'+doc.gridName).eiseGrid();
					});
				}
				
				$('#timestamp').text(responseText.timestamp);
				$menu = $('ul.menu-h');
				$menu.children('li').detach();
			
				if(doc.flagPosted!=responseText.flagPosted || doc.ID!=responseText.ID || doc.flagDeleted!=responseText.flagDeleted){
					location.href = location.pathname+'?'+responseText.prefix+'ID='+responseText.ID;
				}
				
				
				for(i=0;i<responseText.arrActions.length;i++){
					//console.log(responseText.arrActions[i]);
					var $li = $('<li>').append($('<a>',{'class':responseText.arrActions[i].class,'href':responseText.arrActions[i].action,'text':responseText.arrActions[i].title}))
					$menu.append($li);
				}
			}
			$('#loader').hide();
		});
	} else {
		return false;
	}
}

function fillGrid(type){

	var type=type||'';
	
	switch (type){
		case '_kaizen':
		case '_kaizen_revenue':
			var $dialog = $('<div>').append($('<select>',{id:'prtGHQ',name:'prtGHQ'}));
			for (i=0;i<arrGHQ.length;i++){
			
				$('#prtGHQ',$dialog).append($('<option>',{value:arrGHQ[i],text:arrGHQ[i]}));
			}
			$dialog.dialog({
					title:'Choose activity',
					modal:true,
					buttons:{
						"Ok":function(){
							send(type);
							$(this).dialog( "close" );
						},
						'Cancel':function(){
							$(this).dialog( "close" );
						}
					}
			});
			break;
		default:
			send('fill'+type);
			break;
	}
		
}

function send(action){
		$('#DataAction').val(action);
		var input = $( "input, textarea, select" ).serialize();
		$('#loader').show();
		$.post(location.href,input,function(data){
			console.log(data);
			var temp = $('<div/>');
			$.get(location.href+' body', function(html){
				html = $(html);
				$('#tabs-input').html($('#tabs-input',html));
				$('#timestamp').html($('#timestamp',html));
				$('#entity input,#entity textarea').each(function(){
					console.log($(this).attr('id'));
					$(this).val($('#'+$(this).attr('id'),html).val());
				});
				$('#'+doc.gridName).eiseGrid();
				$('#loader').hide();	
			});

			// $('#tabs-input').load(location.href+' #tabs-input', function(){
				// eiseGridInitialize();
				// rowTotalsInitialize();
				// $('#loader').hide();
			// });
			
		});
};

function parse_textarea(){
	var strInput = $("#input_textarea").val().replace(/\r\n/g, "\n");
	var arrLines = strInput.split("\n");
	for(i=0;i<arrLines.length-1;i++){
		arrLines[i] = arrLines[i].split("\t");
		for (j=0;j<arrLines[i].length;j++){
			arrLines[i][j] = parseFloat(arrLines[i][j].replace(',',''));
			if(isNaN(arrLines[i][j])){
				arrLines[i][j]=0;
			}
		}
		// console.log(arrLines[i]);
	}
		var inputs = new Array();
	if (doc!=undefined){
		for (m=0;m<months.length;m++){
			$("input[name='"+months[m]+"[]']").each(function(index, element){
				if(index!=0 && index<arrLines.length){
					//$(this).val(arrLines[index-1][m]);
					var hDom = $(this).get(0); console.log(hDom);
					hDom.value = arrLines[index-1][m];
					var $inpUpdated = $(this).parents('tr').find("input[name='inp_"+doc.gridName+"_updated[]']").val(1);
				}
			});
		};
	}
	$("#input_textarea").val();
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
	$("input.i-checkbox, input[type='checkbox']").click(function(){
		var b = $(this).is(":checked");
		$(this).toggleClass("checked");
		var oInput = $(this).prev("input");
		oInput.attr("value", b*1);
	});
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

function validate(){

	var res = true;

	$('input.mandatory').each(function(){
		if (!$(this).val()){
			$(this).addClass('error_field');
			res = false;
		}
	});
	
	return (res);
}

function init_monthlyCopy(){
	// var grid=eiseGrid_find(doc.gridName);
    // if (grid!=null){  
		// grid.change ("jan[]", function(oTr, input){
			// for (m=1;m<months.length;m++){
				// oTr.find("input[name='"+months[m]+"[]']").val(input.val());
			// }
		// })
    // };
}

function init_productProperties(){
// var grid=eiseGrid_find(doc.gridName);
    // if (grid!=null){  
		// grid.change ("product[]", function(oTr, input){ 
			// console.log(oTr);
			// $.post("ajax_details.php"
				// , {table:'vw_product',prdID:oTr.find("[name='product[]']").val()}
				// , function(data, textStatus){
					// console.log(data);
					// oTr.find("[name='unit[]']").val(data.prtUnit);
					// oTr.find("[name='prdExternalID[]']").val(data.prdExternalID);
					// oTr.find("div").text(data.prdExternalID);
				// }
				// ,'json'
			// );
		// })
    // }
}
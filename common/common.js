function GetXmlHttpObject()
{
  var xmlHttp=null;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
  return xmlHttp;
}

function MsgClose(){
       $("#sysmsg").fadeOut("slow");
    }
function MsgShow(){
	var msg = $('#sysmsg').html();
	if (msg !=""){
       $("#sysmsg").slideDown("slow", function(){ window.setTimeout("MsgClose()", 10000);});
	  }
    }
/*jQuery(function($){
	$.datepicker.regional['ru'] = {clearText: 'Очистить', clearStatus: '',
		closeText: 'Закрыть', closeStatus: '',
		prevText: 'Пред.',  prevStatus: '',
		nextText: 'След.', nextStatus: '',
		currentText: 'Сегодня', currentStatus: '',
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
		'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort: ['янв','фев','мар','апр','май','июн',
		'июл','авг','сен','окт','ноя','дек'],
		monthStatus: '', yearStatus: '',
		weekHeader: 'Неделя', weekStatus: '',
		dayNames: ['Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'],
		dayNamesShort: ['вс','пн','вт','ср','чт','пт','сб'],
		dayNamesMin: ['вс','пн','вт','ср','чт','пт','сб'],
		dayStatus: 'DD', dateStatus: 'D, M d',
		dateFormat: 'dd.mm.yy', firstDay: 1, 
		initStatus: '', isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
});*/
/*============= Hide and show system messages ==================*/

 
function getNewGUID() 
{
    try
    {
        var x = new ActiveXObject("Scriptlet.TypeLib");
    return (x.GUID);
    }
    catch (e)
    {
    return ("error creating GUID");
    }
}

function getSelectBoxValue(oSelect){
   if (oSelect!=null)
      return oSelect.options[oSelect.options.selectedIndex].value;
   else
      return null;
}
function getSelectBoxText(oSelect){
   if (oSelect!=null)
      return oSelect.options[oSelect.options.selectedIndex].text;
   else
      return null;
}
function getDecimalValue(oInput){
   var retVal = parseFloat(oInput.value.replace(",", ""));
   if (isNaN(retVal)){
         alert ("Number is entered in incorrect format. Decimal separator is '.', thousands separator is ','.");
         oInput.focus();
         return null;
   }
   return retVal;
}

/* Made by Mathias Bynens <http://mathiasbynens.be/> */
function number_format(a, b, c, d) {
 a = Math.round(a * Math.pow(10, b)) / Math.pow(10, b);
 e = a + '';
 f = e.split('.');
 if (!f[0]) {
  f[0] = '0';
 }
 if (!f[1]) {
  f[1] = '';
 }
 if (f[1].length < b) {
  g = f[1];
  for (i=f[1].length + 1; i <= b; i++) {
   g += '0';
  }
  f[1] = g;
 }
 if(d != '' && f[0].length > 3) {
  h = f[0];
  f[0] = '';
  for(j = 3; j < h.length; j+=3) {
   i = h.slice(h.length - j, h.length - j + 3);
   f[0] = d + i +  f[0] + '';
  }
  j = h.substr(0, (h.length % 3 == 0) ? 3 : (h.length % 3));
  f[0] = j + f[0];
 }
 c = (b <= 0) ? '' : c;
 return f[0] + c + f[1];
}

function addslashes(str) {
str=str.replace(/\'/g,"\'");
str=str.replace(/\"/g,'\\"');
str=str.replace(/\\/g,'\\\\');
str=str.replace(/\0/g,'\\0');
return str;
}
function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\\\/g,'\\');
str=str.replace(/\\0/g,'\0');
return str;
}

/* ----------- ex-forms.js ------------------------------ */
function initialize_inputs(oParent){

	oParent.find(".ajax").one('focus',function(){
		var data = $(this).attr('src');
		eval ("arrData="+data+";");
		var table = arrData.table;
		var prefix = arrData.prefix;
		var url = 'ajax_list.php?table='+table+"&prefix="+prefix;
		
		
		$(this).autocomplete(url, {
			width: 300,
			multiple: false,
			matchContains: true,
			minChars: 3,
			formatItem: formatItem,
			formatResult: formatResult
		});
		$(this).result(function(event, data, formatted) {
			if (data)
				$(this).prev("input").val(data[1]);
		});
	});
	
	oParent.find(".select").bind("click",turn_into_select);
		
	oParent.find(".userid").one('focus',function(){
		$(this).autocomplete("ajax_peoplefinder.php", {
			width: 300,
			multiple: false,
			matchContains: true,
			minChars: 3,
			formatItem: formatItem,
			formatResult: formatResult
		});
		$(this).result(function(event, data, formatted) {
			if (data)
				$(this).prev("input").val(data[1]);
		});
	});
	
	oParent.find(".textarea").keyup(function(){
		$(this).prev("input").val = $(this).attr("text");
	});
		
	oParent.find("label").bind("click", function(){
		target = "#"+$(this).attr("for");
		$(target).click();
		
	});
	
	oParent.find(":checkbox").bind("click", function(){
		var b = $(this).is(":checked");
		$(this).toggleClass("checked");
		/*alert ("checkbox changed");*/
		var oInput = $(this).prev("input");
			//var a = oInput.attr("value");
			//var b = 1-a ;
			
			oInput.attr("value", b*1);
			/*$(this).text(b);*/
			
	oInput.parents("tr").find("input:last").attr("value",1); //если чекбокс в таблице
		
	});
}

function easyFormValidate(){
				var res = true;
				$('input, textarea').removeClass('error_field');
				$('input.mandatory, textarea.mandatory').each(function(){
					if(!$(this).val()) {
						$(this).addClass('error_field');
						res &= false;
					}
				});
				
				$('input').each(function(){
				var meta = $(this).attr('src') ? $(this).attr('src') : '{}';
				eval ("arrMeta="+meta+";");
				
				var mask=new RegExp(arrMeta.validation,'gi')
				
				if ($(this).val() && !mask.test($(this).val())){
						$(this).addClass('error_field');
						res &= false;
				};
				
				});
				
				return (res==true);
			}	

function formatItem(row) {
		return row[0] ;
	}
function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
function turn_into_select(){
			var id_field = $(this).prev('input')
			var field_name = id_field.attr('name');
			var id=id_field.val();
			var wrapper = $(this).parent('div');
			var table = eval(wrapper.attr('data'))[0];
			var prefix = eval(wrapper.attr('data'))[1];
			
			wrapper.load("ajax_select.php"
			,{id: id,table: table,prefix: prefix}
			,function(){
				var selector = wrapper.children('select');
				selector.attr('name',field_name);
				selector.parents("tr").find("input:last").attr("value",1); //если селектор в таблице
				selector.bind("blur",turn_into_div);
			});
			
	}
function turn_into_div(){
			var wrapper = $(this).parent('div');
			var table = eval(wrapper.attr('data'))[0];
			var prefix = eval(wrapper.attr('data'))[1];
			var field_name = $(this).attr('name');
			wrapper.html("<input data=\"['"+table+"','"+prefix+"']\" type=\"hidden\" name=\""+field_name+"\" value=\""+$(this).val()+"\">"+"<div class=\"select input\">"+$(this).children("[@selected]").text()+"</div>");
			var selector = wrapper.children(".select");
			selector.bind("click",turn_into_select);
	}	
/* ------ /ex-forms.js ---------------------- */

function showDropDownWindow(o, divID){
//   alert(o.nodeName+" "+o.offsetLeft+" "+o.offsetTop);
   var div = document.getElementById(divID);
   if (div.style.visibility=="hidden"){
      div.style.left=o.offsetLeft+"px";
      div.style.top="30px";
      div.style.visibility="visible";
   } else {
      div.style.visibility="hidden";
   }
}  

function resetStatus(entID){
    document.getElementById('actID').value='';
    document.getElementById('actComments').value='';
    var oldStatus = document.getElementById(entID+'OldStatusID').value;
    document.getElementById(entID+'StatusID').value = oldStatus;
}

function replaceCyrillicLetters(str){
    var arrRepl = [['410', '430','A']
       , ['412', '432','B']
       , ['415', '435','E']
       , ['41A', '43A', 'K']
       , ['41C', '43C', 'M']
       , ['41D', '43D', 'H']
       , ['41E', '43E', 'O']
       , ['420', '440', 'P']
       , ['421','441', 'C']
       , ['422','442', 'T']
       , ['423','443', 'Y']
       , ['425','445', 'X']
       ];
    str = escape(str);
    for (var i=0;i<arrRepl.length;i++){
       eval("str = str.replace(/\%u0"+arrRepl[i][0]+"/g, arrRepl[i][2]);");
       eval("str = str.replace(/\%u0"+arrRepl[i][1]+"/g, arrRepl[i][2]);");
    }
    return unescape(str);
}

function getInputValue(o){
   if(o.nodeName=="INPUT"){
      return o.value;
   }else if (o.nodeName=="SELECT"){
      return getSelectBoxValue(o);
   }
}
function updateChart(id, data){
	var arrColumns = ['this_scenario','that_scenario','diff'];
	// console.log(data.table);
	chart[id].update({
						series:[{data:data.chart}],
						yAxis:{min:data.min,max:data.max}							
					});
	var datatable = $('#table_'+id+' tbody');
	$('#table_'+id+' caption').removeClass('ajax-loading');
	$('tr',datatable).remove();
	for(var i=0;i<data.table.length;i++){
		var tr = $('<tr>',{'class':data.table[i]['class']}).appendTo(datatable);
		$('<td>',{html:data.table[i]['title']}).appendTo(tr);
		// console.log(data.table[i]);
		for(var j=0;j<arrColumns.length;j++){			
			datapoint = data.table[i][arrColumns[j]];			
					$('<td>',{'class':'budget-decimal',
						html:wf_format(data.table[i][arrColumns[j]])
					}).appendTo(tr);
		}
		$('<td>',{'class':'budget-decimal budget-ratio',
					html:wf_format(data.table[i]['ratio'])}).appendTo(tr);
	};
};

function wf_format(value){
	var res = (value == null ? '' : number_format(value,0,'.',','));
	if(value<0){
		res = '<span class="budget-negative">'+res+'</span>';
	}
	return (res);
}
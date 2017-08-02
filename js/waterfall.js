function updateChart(id, data){
	console.log(data);
	chart[id].update({
						series:[{data:data.chart}],
						yAxis:{min:data.min,max:data.max}							
					});
	var datatable = $('#table_'+id+' tbody');
	$('tr',datatable).remove();
	for(i=0;i<data.table.length;i++){
		var tr = $('<tr>',{'class':data.table[i][4]}).appendTo(datatable);
		$('<td>',{html:data.table[i][0]}).appendTo(tr);
		for(var j=1;j<=3;j++){
			var strNumber = (data.table[i][j] == null ? '' : number_format(data.table[i][j],0,'.',','));
			if (data.table[i][j]<0) {
				strNumber = '<span class="budget-negative">'+strNumber+'</span>';
			};
			$('<td>',{'class':'budget-decimal',html:strNumber}).appendTo(tr);
		}
	}
};
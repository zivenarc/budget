var google_chart_data = [];

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(draw);
				  
				  function draw(){					
					$('.google_chart').each(function(){
						drawChart($(this).attr('id'));					
					});
					drawToolbar();
				  };
				  
				 function drawToolbar() {

				};

function drawChart(target) {		  				
	var data = new google.visualization.DataTable();
	data.addColumn({'type':'string'});
	data.addColumn({'type':'number'});
	data.addColumn({'type':'number'});
	data.addColumn({'type':'number'});
	data.addColumn({'type':'number'});
	data.addColumn({'type':'string','role':'tooltip','p':{'html': true}});
	// var data = google.visualization.arrayToDataTable(<?php echo json_encode($arrChart);?>, true);		
	data.addRows(google_chart_data[target].data);		
	// data.setColumnProperty(5,'p','html');
	// data.setColumnProperty(5,'role','tooltip');
	
	var options = {
		title: google_chart_data[target].title,
	  legend: 'none',
	  bar: { groupWidth: '100%' }, 
	  candlestick: {
		fallingColor: { strokeWidth: 0, fill: '#EFA8B4' }, 
		risingColor: { strokeWidth: 0, fill: '#A8D1EF' }   
	  },
	  tooltip: {isHtml: true},
	  hAxis: {slantedTextAngle:90, textStyle:{fontSize: 10}},
	  vAxis: {textStyle:{fontSize: 10}},
	  chartArea: {top:'10%', bottom:'50%', height: '50%'}
	};

	var chart = new google.visualization.CandlestickChart(document.getElementById(target));
	
	google.visualization.events.addListener(chart, 'ready', function () {
	document.getElementById('chart_png_href_'+target).href = chart.getImageURI();
	//console.log(chart_div.innerHTML);
  });
	
	chart.draw(data, options);
}
<?php
$arrJS[] = 'https://www.google.com/jsapi';
class Waterfall {
	
	private $arrReport, $arrChart, $chartID;
	public $title;
	
	public function __construct($options){		
		$this->sqlBase = $options['sqlBase'];
		$this->limit = $options['limit'];
		$this->chartID = md5($this->sqlBase);
		$this->title = $options['title'];
		$this->tolerance = $options['tolerance']?$options['tolerance']:0.1;
	}
	
	private function _initData(){
		GLOBAL $oSQL;
		$sql = "SELECT SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
		({$this->sqlBase}) Q1";

		$rs = $oSQL->q($sql);
		$baseData = $oSQL->f($rs);
		$this->arrReport[] = Array('Budget',null,null,$baseData['Budget'], 'budget-subtotal');
		$this->arrChart[] = Array('Budget',0,0,(integer)$baseData['Budget'],(integer)$baseData['Budget'], $this->getTooltip('Budget',$baseData['Budget']));
		$diffBalance = $baseData['Diff'];
		$thisBalance = $baseData['Actual'];
		$thatBalance = $baseData['Budget'];
		$lastValue = $baseData['Budget'];

		$sql = Array();

		if ($this->limit!=0){
			$sql[] = "SELECT optValue, optText, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
			({$this->sqlBase}) Q1
			GROUP BY optText
			ORDER BY SUM(DIFF) DESC
			LIMIT {$this->limit}";

			$sql[] = "SELECT optValue, optText, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
			({$this->sqlBase}) Q1
			GROUP BY optText
			ORDER BY SUM(DIFF) ASC
			LIMIT {$this->limit}";
		} else {
			$sql[] = "SELECT optValue, optText, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
			({$this->sqlBase}) Q1
			GROUP BY optText
			ORDER BY SUM(DIFF) DESC";
		}

		for ($i=0;$i<count($sql);$i++){
			$rs = $oSQL->q($sql[$i]);
			while ($rw = $oSQL->f($rs)){
				
				$strTooltip = $this->getTooltip($rw['optText'],$rw['Diff']);
				
				if (abs($rw['Diff'])>=$this->tolerance*abs($baseData['Diff'])){
					// $this->arrReport[] = Array($rw['optText'],$rw['Diff']);
					$this->arrReport[] = Array($rw['optText'],$rw['Actual'],$rw['Budget'],$rw['Diff']);
					$this->arrChart[] = Array($rw['optText'],(integer)$lastValue,(integer)$lastValue,(integer)($lastValue+$rw['Diff']),(integer)($lastValue+$rw['Diff']), $strTooltip);
					$lastValue += $rw['Diff'];
					$diffBalance -= $rw['Diff'];
					$thisBalance -= $rw['Actual'];
					$thatBalance -= $rw['Budget'];
				}
			}
		}
		
		if (round($diffBalance)!=0){
			$this->arrReport[] = Array('Other',$thisBalance, $thatBalance, $diffBalance);
			$this->arrChart[] = Array('Other',(integer)$lastValue,(integer)$lastValue, (integer)($lastValue+$diffBalance), (integer)($lastValue+$diffBalance)
							, $this->getTooltip('Other factors not included before',$diffBalance));
		}
		$this->arrReport[] = Array('Actual',null, null, $baseData['Actual'],'budget-subtotal');
		$this->arrChart[] = Array('Actual',0,0,(integer)$baseData['Actual'],(integer)$baseData['Actual'], $this->getTooltip('Actual',$baseData['Actual']));
		
		$this->arrReport[] = Array('Total diff',null, null, $baseData['Diff'],'budget-subtotal');
		$this->arrReport[] = Array('Ratio',null, null, $baseData['Actual']/$baseData['Budget']*100,'budget-ratio');
		
	}
	
	public function drawTable($strClass="budget"){
		?>
		<h2><?php echo $this->title;?></h2>
		<p>Tolerance = <?php echo ($this->tolerance*100).'%';?></p>
		<table id="table_<?php echo $this->chartID;?>" class="<?php echo $strClass;?>" style="width:auto;">
		<?php
		foreach($this->arrReport as $record){
			?>
			<tr class="<?php echo $record[4];?>">
				<td><?php echo $record[0];?></td>
				<td class='budget-decimal'><span style='color:<?php echo $record[1]<0?'red':'black';?>;'><?php echo number_format($record[1],0,'.',',');?></span></td>
				<td class='budget-decimal'><span style='color:<?php echo $record[2]<0?'red':'black';?>;'><?php echo number_format($record[2],0,'.',',');?></span></td>
				<td class='budget-decimal'><span style='color:<?php echo $record[3]<0?'red':'black';?>;'><?php echo number_format($record[3],0,'.',',');?></span></td>
			</tr>
			<?php
		}
		?>
		</table>
		<nav>
		<li><a href="javascript:SelectContent('table_<?php echo $this->chartID;?>');">Select table</a></li>
		<li><a id="chart_png_href">Get chart as image</a></li>
		</nav>
		<?php
	}
	
	public function drawChart(){
		?>
		<div id="chart_div" style="width: 1200px; height: 700px;"></div>
		<div id="toolbar_div"></div>
		<script>
			google.load("visualization", "1", {packages:["corechart"]});
				  google.setOnLoadCallback(draw);
				  
				  function draw(){
					drawChart();
					drawToolbar();
				  };
				  
				 function drawToolbar() {

				};
				  
				  
				  function drawChart() {
					var data = new google.visualization.DataTable();
					data.addColumn({'type':'string'});
					data.addColumn({'type':'number'});
					data.addColumn({'type':'number'});
					data.addColumn({'type':'number'});
					data.addColumn({'type':'number'});
					data.addColumn({'type':'string','role':'tooltip','p':{'html': true}});
					// var data = google.visualization.arrayToDataTable(<?php echo json_encode($arrChart);?>, true);		
					data.addRows(<?php echo json_encode($this->arrChart);?>);		
					// data.setColumnProperty(5,'p','html');
					// data.setColumnProperty(5,'role','tooltip');
					
					var options = {
						title: '<?php echo $this->title;?>',
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

					var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));
					
					google.visualization.events.addListener(chart, 'ready', function () {
					document.getElementById('chart_png_href').href = chart.getImageURI();
					//console.log(chart_div.innerHTML);
				  });
					
					chart.draw(data, options);
				  }
			</script>
		<?php
	}
	
	public function draw (){
		
		$this->_initData();
		?>
		<table>
		<tr>
		<td>
		<?php $this->drawTable(); ?>
		</td>
		<td>
		<?php $this->drawChart(); ?>
		</td>
		</table>
		<?php						
	}
	
	private function getTooltip($title, $number){
		$res = '<div><h4>'.$title.'</h4><p style="color:'.($number<0?'red':'black').';">'.number_format($number,0,'.',',').'</p></div>';;
		return($res);
	}
}
?>
<?php
// $arrJS[] = 'https://www.google.com/jsapi';
//$arrJS[] = 'js/waterfall.js';

$arrJS[]="https://code.highcharts.com/highcharts.js";
$arrJS[]="https://code.highcharts.com/highcharts-more.js";
$arrJS[]="https://code.highcharts.com/modules/exporting.js";

class Waterfall {
	
	private $arrReport, $arrChart, $chartID;
	public $title;
	
	public function __construct($options){		
		$this->sqlBase = $options['sqlBase'];
		$this->limit = $options['limit'];
		$this->chartID = md5($this->sqlBase);
		$this->title = $options['title'];
		$this->tolerance = $options['tolerance']?$options['tolerance']:0.1;
		$this->currency = $options['currency']?$options['currency']:'RUB';
		$this->denominator = $options['denominator']?$options['denominator']:1;
		$this->actual_title = $options['actual_title']?$options['actual_title']:'Actual';
		$this->budget_title = $options['budget_title']?$options['budget_title']:'Budget';
		
		switch ($this->denominator){
			case 1000:
				$this->denominator_title = "k";
				break;
			case 1000000:
				$this->denominator_title = "M";
				break;
			default:
				$this->denominator_title = "";			
		}
		
	}
	
	private function _initData(){
	
		$this->arrReport = Array();
		$this->arrChart = Array();
		$this->arrHSChart = Array();
		
		
		
		GLOBAL $oSQL;
		$sql = "SELECT SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
		({$this->sqlBase}) Q1";

		$rs = $oSQL->q($sql);
		$baseData = $oSQL->f($rs);
		
		$this->min = $baseData['Budget'];
		$this->max = $baseData['Budget'];
		
		$this->arrReport[] = Array($this->budget_title,null,null,$baseData['Budget']/$this->denominator, 'budget-subtotal');
		$this->arrChart[] = Array('Budget',0,0,(integer)$baseData['Budget'],(integer)$baseData['Budget'], $this->getTooltip('Budget',$baseData['Budget']));
		$this->arrHSChart[] = Array('name'=>$this->budget_title,'y'=>(integer)$baseData['Budget'], 'color'=>'blue');
		$diffBalance = $baseData['Diff'];
		$thisBalance = $baseData['Actual'];
		$thatBalance = $baseData['Budget'];
		$lastValue = $baseData['Budget'];

		$sql = Array();

		if ($this->limit!=0){
			
			$sqlLimit = "SELECT optValue, optText, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
			({$this->sqlBase}) Q1
			GROUP BY optValue
			ORDER BY SUM(DIFF) DESC
			";
			$rs = $oSQL->q($sqlLimit);
			$limit = (integer)min($this->limit,$oSQL->n($rs)/2);
		
			$sql[] = "SELECT optValue, optText, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
			({$this->sqlBase}) Q1
			GROUP BY optText
			ORDER BY SUM(DIFF) DESC
			LIMIT {$limit}";

			$sql[] = "SELECT optValue, optText, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
			({$this->sqlBase}) Q1
			GROUP BY optText
			ORDER BY SUM(DIFF) ASC
			LIMIT {$limit}";
		} else {
			$sql[] = "SELECT optValue, optText, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
			({$this->sqlBase}) Q1
			GROUP BY optText
			ORDER BY SUM(DIFF) DESC";
		}

		for ($i=0;$i<count($sql);$i++){
			if ($_GET['debug']){
				echo '<pre>',$sql[$i],'</pre>';
			}
			$rs = $oSQL->q($sql[$i]);
			while ($rw = $oSQL->f($rs)){
				
				$strTooltip = $this->getTooltip($rw['optText'],$rw['Diff']);
				
				if (abs($rw['Diff'])>=$this->tolerance*abs($baseData['Diff'])){
					// $this->arrReport[] = Array($rw['optText'],$rw['Diff']);
					
					$this->arrReport[] = Array($rw['optText'],$rw['Actual']/$this->denominator,$rw['Budget']/$this->denominator,$rw['Diff']/$this->denominator);
					$this->arrChart[] = Array($rw['optText'],(integer)$lastValue,(integer)$lastValue,(integer)($lastValue+$rw['Diff']),(integer)($lastValue+$rw['Diff']), $strTooltip);
					$this->arrHSChart[] = Array('name'=>$rw['optText'],'y'=>(integer)$rw['Diff']);
					$lastValue += $rw['Diff'];
					$diffBalance -= $rw['Diff'];
					$thisBalance -= $rw['Actual'];
					$thatBalance -= $rw['Budget'];
					
					if ($lastValue > $this->max){
						$this->max = $lastValue;
					}
					if ($lastValue < $this->min){
						$this->min = $lastValue;
					}
					
				}
			}
		}
		
		if (round($diffBalance)!=0){
			$this->arrReport[] = Array('Other',$thisBalance/$this->denominator, $thatBalance/$this->denominator, $diffBalance/$this->denominator);
			$this->arrChart[] = Array('Other',(integer)$lastValue,(integer)$lastValue, (integer)($lastValue+$diffBalance), (integer)($lastValue+$diffBalance)
							, $this->getTooltip('Other factors not included before',$diffBalance));
			$this->arrHSChart[] = Array('name'=>'Other','y'=>(integer)$diffBalance);
		}
		$this->arrReport[] = Array($this->actual_title,null, null, $baseData['Actual']/$this->denominator,'budget-subtotal');
		$this->arrChart[] = Array('Actual',0,0,(integer)$baseData['Actual'],(integer)$baseData['Actual'], $this->getTooltip('Actual',$baseData['Actual']));
		$this->arrHSChart[] = Array('name'=>$this->actual_title,'y'=>(integer)$baseData['Actual'],'isSum'=>true, 'color'=>'blue');

		if ($baseData['Actual'] > $this->max){
			$this->max = $baseData['Actual'];
		}
		if ($baseData['Actual'] < $this->min){
			$this->min = $baseData['Actual'];
		}
		
		$this->arrReport[] = Array('Total diff',null, null, $baseData['Diff']/$this->denominator,'budget-subtotal');
		$this->arrReport[] = Array('Ratio',null, null, $baseData['Actual']/$baseData['Budget']*100,'budget-ratio');
		
		if ($this->min > 0){
			$this->min *= 0.95;
		} else {
			$this->min *= 1.05;	
		}
		
		if ($this->max > 0){
			$this->max *= 1.05;
		} else {
			$this->max *= 0.95;
		}
		
	}
	
	public function drawTable($strClass="budget"){
		?>		
		<p>Tolerance = <?php echo ($this->tolerance*100).'%';?></p>
		<table id="table_<?php echo $this->chartID;?>" class="<?php echo $strClass;?>" style="width:auto;">
		<caption><?php echo $this->title, ': ', $this->actual_title,' vs ',$this->budget_title, ', ', $this->currency, 'x', $this->denominator;?></caption>
		<thead>			
			<tr>
				<th>Factors</th>			
				<th><?php echo $this->actual_title;?></th>			
				<th><?php echo $this->budget_title;?></th>			
				<th>Diff</th>			
			</tr>
		</thead>
		<?php
		foreach($this->arrReport as $record){
			?>
			<tr class="<?php echo $record[4];?>">
				<td><?php echo $record[0];?></td>
				<td class='budget-decimal'><span style='color:<?php echo $record[1]<0?'red':'black';?>;'><?php echo $record[1]==null?'&nbsp;':number_format($record[1],0,'.',',');?></span></td>
				<td class='budget-decimal'><span style='color:<?php echo $record[2]<0?'red':'black';?>;'><?php echo $record[2]==null?'&nbsp;':number_format($record[2],0,'.',',');?></span></td>
				<td class='budget-decimal'><span style='color:<?php echo $record[3]<0?'red':'black';?>;'><?php echo number_format($record[3],0,'.',',');?></span></td>
			</tr>
			<?php
		}
		?>
		</table>
		<ul class='link-footer'>
		<li><a href="javascript:SelectContent('table_<?php echo $this->chartID;?>');">Select table</a></li>
		<li><a target="_blank" id="chart_png_href_<?php echo $this->chartID;?>">Get chart as image</a></li>
		</ul>
		<?php
	}
	
	public function drawChart(){			
		?>
		<div id="<?php echo $this->chartID;?>" class="google_chart" style="width: 1200px; height: 700px;"></div>
		<div id="toolbar_div"></div>
		<script>
			var hs_data = [];
			
			//google_chart_data["<?php echo $this->chartID;?>"] = {data:<?php echo json_encode($this->arrChart);?>,title:'<?php echo $this->title;?>'};			
			hs_data["<?php echo $this->chartID;?>"] = {chart: {type: 'waterfall'},
													title: {text: '<?php echo $this->title, ': "', $this->actual_title,'" vs "',$this->budget_title,'"';?>'},
													xAxis: {type: 'category'},
													yAxis: {
															min: <?php echo (integer)$this->min;?>,
															max: <?php echo (integer)$this->max;?>,
															title: {
																text: '<?php echo $this->currency;?>'
															}},
													legend: {enabled: false},
													tooltip: {pointFormat: '<b>{point.y:,.0f}</b> <?php echo $this->currency;?>'},
													series: [{upColor: 'green',
															color: 'red',
													data: <?php echo json_encode($this->arrHSChart);?>,
													dataLabels: {
														enabled: true,
														formatter: function () {
															return Highcharts.numberFormat(this.y/<?php echo $this->denominator;?>, 0, ',');
														},
													style: {
														color: '#FFFFFF',
														fontWeight: 'bold',
														textShadow: '0px 0px 3px black'
														}
													},
													pointPadding: 0
												}]};
				
				$('#<?php echo $this->chartID;?>').highcharts(hs_data["<?php echo $this->chartID;?>"]);
			
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
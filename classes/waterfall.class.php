<?php
// $arrJS[] = 'https://www.google.com/jsapi';
$arrJS[]="https://code.highcharts.com/highcharts.js";
$arrJS[]="https://code.highcharts.com/highcharts-more.js";
$arrJS[]="https://code.highcharts.com/modules/exporting.js";
$arrJS[] = 'js/waterfall.js';

class Waterfall {
	
	private $chartID, $min, $max;
	public $arrReport, $arrHSChart, $title;
	
	public function __construct($options){		
		$this->sqlBase = $options['sqlBase'];
		$this->limit = isset($_REQUEST['limit'])?$_REQUEST['limit']:$options['limit'];
		$this->chartID = md5($this->sqlBase?$this->sqlBase:time());
		$this->title = $options['title'];
		$this->tolerance = isset($_REQUEST['tolerance'])?$_REQUEST['tolerance']:(isset($options['tolerance'])?$options['tolerance']:0.05);
		$this->currency = $options['currency']?$options['currency']:'RUB';
		$this->denominator = $options['denominator']?$options['denominator']:1;
		$this->actual_title = $options['actual_title']?$options['actual_title']:'Actual';
		$this->budget_title = $options['budget_title']?$options['budget_title']:'Budget';
		$this->href = $options['href'];
		
		if(isset($options['filter'])){
			foreach($options['filter'] as $field=>$value){
				if(is_array($value)){
					$strWhere[] = "`$field` IN ('".implode("','",$value)."')";
				} else {
					$strWhere[] = "`$field` = '$value'";
				}
			}
			$sqlWhere = ' AND '.implode(" AND ",$strWhere);
		};
		
		$this->sqlBase = str_replace("%WHERE%", $sqlWhere, $this->sqlBase);
		
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
		
		$this->arrReport = Array();
		$this->arrChart = Array();
		$this->arrHSChart = Array();
		
		if($_REQUEST['DataAction']=='waterfall_reload'){
			header('Content-type: application/json');
			echo json_encode($this->getDataTable());
			die();
		}	
		
	}
	
	private function _initData(){
	
		
		GLOBAL $oSQL;
		$sql = "SELECT SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
		({$this->sqlBase}) Q1";

		$rs = $oSQL->q($sql);
		$baseData = $oSQL->f($rs);
		
		$this->min = $baseData['Budget'];
		$this->max = $baseData['Budget'];
		
		$this->arrReport[] = Array('title'=>$this->budget_title,
									'this_scenario'=>null,
									'that_scenario'=>null,
									'diff'=>$baseData['Budget']/$this->denominator,
									'ratio'=>'',
									'class'=>'budget-subtotal');
									
		$this->arrChart[] = Array('Budget',0,0,(integer)$baseData['Budget'],(integer)$baseData['Budget'], $this->getTooltip('Budget',$baseData['Budget']));
		$this->arrHSChart[] = Array('name'=>$this->budget_title,'y'=>(integer)$baseData['Budget'], 'color'=>'#646464');
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
					
					$this->arrReport[] = Array('title'=>$rw['optText'],
												'this_scenario'=>$rw['Actual']/$this->denominator,
												'that_scenario'=>$rw['Budget']/$this->denominator,
												'diff'=>$rw['Diff']/$this->denominator,
												'ratio'=>($rw['Budget']!=0?$rw['Actual']/$rw['Budget']*100:'n/a')
												);
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
			$this->arrReport[] = Array('title'=>'Other',
										'this_scenario'=>$thisBalance/$this->denominator, 
										'that_scenario'=>$thatBalance/$this->denominator, 
										'diff'=>$diffBalance/$this->denominator,
												'ratio'=>$thatBalance?$thisBalance/$thatBalance*100:'n/a');
			$this->arrChart[] = Array('Other',(integer)$lastValue,(integer)$lastValue, (integer)($lastValue+$diffBalance), (integer)($lastValue+$diffBalance)
							, $this->getTooltip('Other factors not included before',$diffBalance));
			$this->arrHSChart[] = Array('name'=>'Other','y'=>(integer)$diffBalance);
		}
		$this->arrReport[] = Array('title'=>$this->actual_title,
									'this_scenario'=>null, 
									'that_scenario'=>null, 
									'diff'=>$baseData['Actual']/$this->denominator,
									'ratio'=>'',
									'class'=>'budget-subtotal');
		$this->arrChart[] = Array('Actual',0,0,(integer)$baseData['Actual'],(integer)$baseData['Actual'], $this->getTooltip('Actual',$baseData['Actual']));
		$this->arrHSChart[] = Array('name'=>$this->actual_title,'y'=>(integer)$baseData['Actual'],'isSum'=>true, 'color'=>'#646464');

		if ($baseData['Actual'] > $this->max){
			$this->max = $baseData['Actual'];
		}
		if ($baseData['Actual'] < $this->min){
			$this->min = $baseData['Actual'];
		}
		
		$this->arrReport[] = Array('title'=>'Total diff',
									'this_scenario'=>null, 
									'that_scenario'=>null, 
									'diff'=>$baseData['Diff']/$this->denominator,
									'ratio'=>'',
									'class'=>'budget-subtotal');
		$this->arrReport[] = Array('title'=>'Ratio',
									'this_scenario'=>null, 
									'that_scenario'=>null, 
									'diff'=>($baseData['Budget']!=0?$baseData['Actual']/$baseData['Budget']*100:"0"),
									'ratio'=>'',
									'class'=>'budget-ratio');
		
		// if ($this->min > 0){
			// $this->min *= 0.95;
		// } else {
			// $this->min *= 1.05;	
		// }
		
		// if ($this->max > 0){
			// $this->max *= 1.05;
		// } else {
			// $this->max *= 0.95;
		// }
		
	}
	
	public function drawTable($strClass="budget"){
		?>		
		<label>Tolerance</label>
		<div id="tolerance_<?php echo $this->chartID;?>" class='tolerance'>
			<div id="tolerance_<?php echo $this->chartID;?>-handle" class="ui-slider-handle"></div>
		</div>
		<label>Limit</label>
		<div id="limit_<?php echo $this->chartID;?>" class='limit'>
			<div id="limit_<?php echo $this->chartID;?>-handle" class="ui-slider-handle"></div>
		</div>
		<table id="table_<?php echo $this->chartID;?>" class="<?php echo $strClass;?>" style="width:auto;">
		<caption><?php echo $this->title, ': ', $this->actual_title,' vs ',$this->budget_title, ', ', $this->currency, 'x', $this->denominator;?></caption>
		<thead>			
			<tr>
				<th>Factors</th>			
				<th><?php echo $this->actual_title;?></th>			
				<th><?php echo $this->budget_title;?></th>			
				<th>Diff</th>			
				<th>Ratio</th>			
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($this->arrReport as $record){
			?>
			<tr class="<?php echo $record['class'];?>">
				<td><?php echo $record['title'];?></td>
				<td class='budget-decimal'><span style='color:<?php echo $record['this_scenario']<0?'red':'black';?>;'><?php echo $record['this_scenario']==null?'&nbsp;':number_format($record['this_scenario'],0,'.',',');?></span></td>
				<td class='budget-decimal'><span style='color:<?php echo $record['that_scenario']<0?'red':'black';?>;'><?php echo $record['that_scenario']==null?'&nbsp;':number_format($record['that_scenario'],0,'.',',');?></span></td>
				<td class='budget-decimal'><span style='color:<?php echo $record['diff']<0?'red':'black';?>;'><?php echo number_format($record['diff'],0,'.',',');?></span></td>
				<td class='budget-decimal'><?php echo $record['that_scenario']?number_format($record['this_scenario']/$record['that_scenario']*100,0,'.',','):'n/a';?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
		</table>		
		<button onclick="javascript:SelectContent('table_<?php echo $this->chartID;?>');">Copy table</button>				
		<?php
	}
	
	public function drawChart(){
		
		$lastValue = $this->arrHSChart[0]['y'];
		$this->min = min($this->arrHSChart[0]['y']*0.98,$this->arrHSChart[0]['y']);
		$this->max = max($this->arrHSChart[0]['y']*1.02,$this->arrHSChart[0]['y']);
		
		
		for($i=1;$i<count($this->arrHSChart);$i++){
			if (!$this->arrHSChart[$i]['isSum']){
				$lastValue += $this->arrHSChart[$i]['y'];
				$this->min = min($this->min,$lastValue);
				$this->max = max($this->max,$lastValue);
			}
		}
				
		?>
		<div id="<?php echo $this->chartID;?>" class="google_chart" style="width: 1200px; height: 700px;"></div>
		<div id="toolbar_div"></div>
		<script>
			var hs_data = [];
			var chart = [];
			var chartID = '<?php echo $this->chartID;?>';
			//google_chart_data["<?php echo $this->chartID;?>"] = {data:<?php echo json_encode($this->arrChart);?>,title:'<?php echo $this->title;?>'};			
			hs_data[chartID] = {chart: {type: 'waterfall'},
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
													series: [{upColor: '#3BACEE',
																	color: '#FF6D10',
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
				
				// $('#<?php echo $this->chartID;?>').highcharts(hs_data["<?php echo $this->chartID;?>"]);	
				chart[chartID] = Highcharts.chart(chartID,hs_data[chartID]);
				var handle = $('#tolerance_'+chartID''-handle');
				$('#tolerance_'+chartID).slider({
					  value: <?php echo ($this->tolerance*100);?>,
					  create: function() {
						handle.text( $( this ).slider( "value" )+'%');
					  },
					  slide: function( event, ui ) {
						handle.text( ui.value+'%' );
						var request = {DataAction:'waterfall_reload',	tolerance:ui.value/100};
						if (typeof(requestOptions)!='undefined'){
							request[requestOptions.tabKey] = requestOptions.tabValue;
						};
						$('#table_'+chartID+' caption').addClass('ajax-loading');
						$.get(location.href,request, function(data){
							updateChart(chartID,data);
						});
					  },
					  min: 1,
					  max: 15
					});
				$('#limit_'+chartID).slider({
					  value: <?php echo ($this->limit);?>,
					  create: function() {
						handle.text( $( this ).slider( "value" )+'%');
					  },
					  slide: function( event, ui ) {
						handle.text( ui.value+'%' );
						var request = {DataAction:'waterfall_reload', limit:ui.value};
						if (typeof(requestOptions)!='undefined'){
							request[requestOptions.tabKey] = requestOptions.tabValue;
						};
						$('#table_'+chartID+' caption').addClass('ajax-loading');
						$.get(location.href,request, function(data){
							updateChart(chartID,data);
						});
					  },
					  min: 5,
					  max: 20
					});
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
	
	public function processSQL($sqlBase,$limit=3, $title=""){
		GLOBAL $oSQL;
		$sql = "SELECT optValue, optText, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
				({$sqlBase}) Q1
				";
		$rs = $oSQL->q($sql);
		$rwOther = $oSQL->f($rs);
		
		$this->max += $rwOther['Diff'];
		
		$sql = "SELECT optValue, optText, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
			({$sqlBase}) Q1
			GROUP BY optText
			ORDER BY SUM(DIFF) DESC
			LIMIT {$limit}";
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){			
			$this->arrReport[] = Array('title'=>$rw['optText'],
										'this_scenario'=>$rw['Actual']/$this->denominator,
										'that_scenario'=>$rw['Budget']/$this->denominator,
										'diff'=>$rw['Diff']/$this->denominator,
										'ratio'=>$rw['Budget']?$rw['Actual']/$rw['Budget']*100:'n/a');
			if((integer)$rw['Diff']) {
				$this->arrHSChart[] = Array('name'=>$rw['optText'],'y'=>(integer)$rw['Diff']);
			}
			$rwOther['Actual']-=$rw['Actual'];
			$rwOther['Budget']-=$rw['Budget'];
			$rwOther['Diff']-=$rw['Diff'];			
		}
		$sql = "SELECT optValue, optText, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff FROM 
				({$sqlBase}) Q1
				GROUP BY optText
				ORDER BY SUM(DIFF) ASC
				LIMIT {$limit}";
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){			
			$this->arrReport[] = Array('title'=>$rw['optText'],
										'this_scenario'=>$rw['Actual']/$this->denominator,
										'that_scenario'=>$rw['Budget']/$this->denominator,
										'diff'=>$rw['Diff']/$this->denominator,
										'ratio'=>$rw['Budget']?$rw['Actual']/$rw['Budget']*100:'n/a'
										);
			if((integer)$rw['Diff']) {
				$this->arrHSChart[] = Array('name'=>$rw['optText'],'y'=>(integer)$rw['Diff']);
			}
			$rwOther['Actual']-=$rw['Actual'];
			$rwOther['Budget']-=$rw['Budget'];
			$rwOther['Diff']-=$rw['Diff'];
		}
		$this->arrReport[] = Array('title'=>$title.', others',
									'this_scenario'=>$rwOther['Actual']/$this->denominator,
									'that_scenario'=>$rwOther['Budget']/$this->denominator,
									'diff'=>$rwOther['Diff']/$this->denominator,
									'ratio'=>$rwOther['Budget']?$rwOther['Actual']/$rwOther['Budget']*100:'n/a'
									);
		if((integer)$rwOther['Diff']) {
			$this->arrHSChart[] = Array('name'=>$title.', others','y'=>(integer)$rwOther['Diff']);
		}
	}
		
	function getDataTable(){
		$this->_initData();
		$res = Array('chart'=>$this->arrHSChart,'table'=>$this->arrReport,'min'=>(integer)$this->min, 'max'=>(integer)$this->max);
		return $res;
	}
}
?>
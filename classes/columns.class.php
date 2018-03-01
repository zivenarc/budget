<?php
// $arrJS[] = 'https://www.google.com/jsapi';
//$arrJS[] = 'js/waterfall.js';

$arrJS[]="https://code.highcharts.com/highcharts.js";
$arrJS[]="https://code.highcharts.com/modules/drilldown.js";
$arrJS[]="https://code.highcharts.com/highcharts-more.js";
$arrJS[]="https://code.highcharts.com/modules/exporting.js";

class Columns {
	
	private $arrReport, $arrChart, $chartID;
	public $title;
	
	public function __construct($options){		
		$this->sqlBase = $options['sqlBase'];
		$this->limit = $options['limit']?$options['limit']:20;
		$this->chartID = md5($this->sqlBase);
		$this->title = $options['title'];
		$this->xTitle = $options['xTitle'];
		$this->tolerance = $options['tolerance']?$options['tolerance']:0.1;
		$this->currency = $options['currency']?$options['currency']:'RUB';
		$this->denominator = $options['denominator']?$options['denominator']:1000;
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
		
		$this->hsMasterData = Array(
			'chart'=>Array('type'=>'column'),
			'title'=>Array('text'=>$this->actual_title.' vs '.$this->budget_title),
			'subtitle'=>Array('text'=>'Top '.$this->limit),
			'series'=>Array(),
			'xAxis'=>Array('type'=>'category'),
			'yAxis'=>Array('title'=>Array('text'=>$this->xTitle.', '.$this->currency))
		);
		
	}
	
	private function _initData(){
	
		$this->arrReport = Array();
		$this->arrHSChart = Array();
		
		
		
		GLOBAL $oSQL;
		$sql = "SELECT optGroupValue, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Actual+Budget) as OrderKey FROM 
		({$this->sqlBase}) Q1
		GROUP BY optGroupValue
		ORDER BY OrderKey DESC
		LIMIT {$this->limit}";

		$rs = $oSQL->q($sql);
		while($baseData = $oSQL->f($rs)){
			$this->arrReport[$baseData['optGroupValue']] = Array();
		}

		$sql = Array();
		$sqlFields = "optValue, optText, optGroupValue, optGroupText, SUM(Actual) as Actual, SUM(Budget) as Budget, SUM(Diff) as Diff";
		
		// if ($this->limit!=0){	
		if (false){	
			
			$sqlLimit = "SELECT {$sqlFields} FROM 
			({$this->sqlBase}) Q1
			GROUP BY optGroupValue
			ORDER BY SUM(DIFF) DESC
			";
			$rs = $oSQL->q($sqlLimit);
			$limit = (integer)min($this->limit,$oSQL->n($rs)/2);
		
			$sql[] = "SELECT {$sqlFields} FROM 
			({$this->sqlBase}) Q1
			GROUP BY optGroupValue
			ORDER BY SUM(DIFF) DESC
			LIMIT {$limit}";

			$sql[] = "SELECT {$sqlFields} FROM 
			({$this->sqlBase}) Q1
			GROUP BY optGroupValue
			ORDER BY SUM(DIFF) ASC
			LIMIT {$limit}";
		} else {
		
			//------------------------------------------SET TO DEFAULT
			$sql[] = "SELECT {$sqlFields} FROM 
			({$this->sqlBase}) Q1
			GROUP BY optGroupValue,optValue
			ORDER BY SUM(DIFF) DESC";
		}

		for ($i=0;$i<count($sql);$i++){
			if ($_GET['debug']){
				echo '<pre>',$sql[$i],'</pre>';
			}
			$rs = $oSQL->q($sql[$i]);
			while ($rw = $oSQL->f($rs)){
				
				$strTooltip = $this->getTooltip($rw['optText'],$rw['Diff']);				
				
				if(is_array($this->arrReport[$rw['optGroupValue']])){				
					$drillDownId = $rw['optGroupValue']; 
					$this->arrReport[$drillDownId]['name'] = $rw['optGroupText'];
				} else {
					$drillDownId = 'other';
					$this->arrReport[$drillDownId]['name'] = 'Others';
				}
					
				
				$this->arrReport[$drillDownId]['series']['this'] += $rw['Actual'];
				$this->arrReport[$drillDownId]['series']['that'] += $rw['Budget'];
				$this->arrReport[$drillDownId]['drilldown'][] = Array('subtitle'=>$rw['optGroupText'], 'name'=>$rw['optText'],'this'=>$rw['Actual'],'that'=>$rw['Budget']);					
				
			}
		}
		
		if ($_GET['debug']){
			echo '<pre>',print_r($this->arrReport);echo '</pre>';
		};
			
		$this->arrHSChart = $this->hsMasterData;
			
		foreach($this->arrReport as $group=>$data){
			if(count($data['drilldown'])>1){
				$flagDrillDown = $group;
				$this->arrHSDrillDown[$group] = $this->hsMasterData;
				$this->arrHSDrillDown[$group]['subtitle'] = Array('text'=>$data['name']);				
				$this->arrHSDrillDown[$group]['exporting'] = Array('buttons'=>Array(
							'customButton'=>Array('symbol'=>'square','text'=>'Back')
						)
					);
				foreach($data['drilldown'] as $drilldown){
						$this->arrHSDrillDown[$group]['xAxis']['categories'][] = $drilldown['name'];
						$this->arrHSDrillDown[$group]['series'][0]['name'] = $this->actual_title;
						$this->arrHSDrillDown[$group]['series'][1]['name'] = $this->budget_title;
						$this->arrHSDrillDown[$group]['series'][0]['data'][] = (integer)$drilldown['this'];
						$this->arrHSDrillDown[$group]['series'][1]['data'][] = (integer)$drilldown['that'];
				}
			} else {
				$flagDrillDown = false;
			}
			
			$series['this'][] = Array('name'=>$data['name'],'y'=>(integer)$data['series']['this'],'drilldown'=>$flagDrillDown);
			$series['that'][] = Array('name'=>$data['name'],'y'=>(integer)$data['series']['that'],'drilldown'=>$flagDrillDown);
			$this->arrHSChart['xAxis']['categories'][] = $data['name'];

			
			
		}
		
		$this->arrHSChart['series'][] = Array('name'=>$this->actual_title,'data'=>$series['this']);
		$this->arrHSChart['series'][] = Array('name'=>$this->budget_title,'data'=>$series['that']);
		$this->arrHSChart['drilldown'] = Array('series'=>Array());
		
		//echo '<pre>',print_r($this->arrHSChart);echo '</pre>';
		
	}
	
	public function drawTable($strClass="budget"){
		?>
		<div style='display:none;'>
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
		<li><a href="javascript:SelectContent('table_<?php echo $this->chartID;?>');">Copy table</a></li>
		<li><a target="_blank" id="chart_png_href_<?php echo $this->chartID;?>">Get chart as image</a></li>
		</ul>
		</div>
		<?php
	}
	
	public function drawChart(){			
		?>
		<div id="<?php echo $this->chartID;?>" class="highchart" style="width: 1000px; height: 700px;"></div>
		<div id="drilldown" class="highchart" style="width: 1000px; height: 700px;"></div>
		<div id="toolbar_div"></div>
		<script>
			var hs_data = [];
			var drilldown = [];
			//google_chart_data["<?php echo $this->chartID;?>"] = {data:<?php echo json_encode($this->arrChart);?>,title:'<?php echo $this->title;?>'};			
			drilldown = <?php echo json_encode($this->arrHSDrillDown);?>;			
			
			hs_data["<?php echo $this->chartID;?>"] = <?php echo json_encode($this->arrHSChart);?>;
			hs_data["<?php echo $this->chartID;?>"].chart.events = {
					drilldown: function (e) {
						//console.log(drilldown[e.point.drilldown]);
						var chart=this;
						chart.showLoading('Loading details...');
						drilldown[e.point.drilldown].exporting.buttons.customButton.onclick = function(){
							Highcharts.chart('<?php echo $this->chartID;?>',hs_data["<?php echo $this->chartID;?>"]);
						};
						setTimeout(function () {
                            chart.hideLoading();
                           Highcharts.chart('<?php echo $this->chartID;?>',drilldown[e.point.drilldown]);
                        }, 1000); 						
					}
			};
			
			//console.log(hs_data["<?php echo $this->chartID;?>"]);
			//console.log(drilldown);
			
			Highcharts.chart('<?php echo $this->chartID;?>',hs_data["<?php echo $this->chartID;?>"]);
			
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
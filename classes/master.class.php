<?php
require_once ('master_record.class.php');

class Master {
	public $records;
	protected $oSQL;
	
	function __construct($scenario, $source){
		GLOBAL $oSQL;
		$this->oSQL = $oSQL;
		$this->id = $source;
		$this->scenario = $scenario;		
		$this->budget = new Budget($scenario);
	}
	
	public function add_master(){
		$oBR = new master_record($this->id,$this->scenario);
		$this->records['master'][] = $oBR;
		return ($oBR);	
	}
	
	public function add_headcount(){
		$oBR = new headcount_record($this->id,$this->scenario);
		$this->records['headcount'][] = $oBR;
		return ($oBR);	
	}
	
	public function clear(){
		$this->records['master'] = Array();
	}
	
	public function save($flagPostActualPeriods = false){
		
		GLOBAL $arrUsrData;
		
		$sql = Array();
		$sql[] = "SET AUTOCOMMIT = 0;";
		$sql[] = "START TRANSACTION;";
		
		$sql[] = "DELETE FROM `reg_master` WHERE `source`='".$this->id."'";
		
		for ($i=0;$i<count($this->records['master']);$i++){
			$sql[] = $this->records['master'][$i]->getSQLstring(date('n',$this->budget->date_start),15,$flagPostActualPeriods);
		}
		
		// $sql[] = "DELETE FROM `tbl_headcount` WHERE `source`='".$this->id."'";
		// for ($i=0;$i<count($this->records['headcount']);$i++){
			// $sql[] = $this->records['headcount'][$i]->getSQLstring();
		// }
		
		$sql[] = "UPDATE tbl_scenario 
					SET scnTotal = (SELECT SUM(`jan`)+SUM(`feb`)+SUM(`mar`)+SUM(`apr`)+SUM(`may`)+SUM(`jun`)+SUM(`jul`)+SUM(`aug`)+SUM(`sep`)+SUM(`oct`)+SUM(`nov`)+SUM(`dec`) FROM reg_master WHERE scenario='".$this->scenario."') 
					,scnLastSource='".$this->id."'
					,scnEditBy='".$arrUsrData['usrID']."'
					,scnEditDate=NOW()
					WHERE scnID='".$this->scenario."';";
		
		$sql[] = "COMMIT;";
		
		// $this->oSQL->startProfiling();		
		// echo '<pre>',implode(";\r\n",$sql),'</pre>';
		for($i=0;$i<count($sql);$i++){
			if ($sql[$i]) $this->oSQL->q($sql[$i]);
		}
		
		$res = $this->read();
		//echo $res['html'];
		// $this->oSQL->showProfileInfo();
	}
	
	public function read(){
	
		for($m=1;$m<=15;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));
			$month = $this->budget->arrPeriod[$m];
			$arrSqlMonth[] = "SUM(`$month`) as '$month'";
			$arrHeader[] = ucfirst($month);			
		}
		
		$strHeader = '<tr><th>Profit</th><th>'.implode('</th><th>',$arrHeader).'</th><th class="budget-ytd">Total</th></tr>';
		$sqlMonths = implode(', ',$arrSqlMonth);
	
		$sql = "SELECT Profit, $sqlMonths FROM `vw_master` 
				WHERE source='".$this->id."'
				GROUP BY Profit 
				##ORDER BY Profit
				WITH ROLLUP";
		$rs = $this->oSQL->q($sql);
		while ($rw = $this->oSQL->f($rs)){
			$arrRes['data'][] = $rw;
		}
		
		ob_start();
		?>
		<table class='budget'>
			<thead><?php echo $strHeader;?></thead>
			<tbody>
			<?php
				foreach($arrRes['data'] as $record=>$values){
					$ytd = 0;
					echo '<tr>';
					echo '<td>',$values['Profit'],'</td>';
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$ytd += $values[$month];
						echo '<td class="budget-decimal '.($values[$month]<0?'budget-negative':'').'">',number_format($values[$month],0,'.',','),'</td>';
					}
					echo '<td class="budget-decimal budget-ytd">',number_format($ytd,0,'.',','),'</td>';
					echo '</tr>';
				}
			?>
		</table>
		<?php
		$arrRes['html']=ob_get_clean();
		return($arrRes);
	}
}

?>
<?php
class budget_session {
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
	
	public function save(){
		
		GLOBAL $arrUsrData;
		
		$sql = Array();
		$sql[] = "SET AUTOCOMMIT = 0;";
		$sql[] = "START TRANSACTION;";
		
		$sql[] = "DELETE FROM `reg_master` WHERE `source`='".$this->id."'";
		
		for ($i=0;$i<count($this->records['master']);$i++){
			$sql[] = $this->records['master'][$i]->getSQLstring(date('m',$this->budget->date_start));
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
		
				
		// echo '<pre>',implode(";\r\n",$sql),'</pre>';
		for($i=0;$i<count($sql);$i++){
			if ($sql[$i]) $this->oSQL->q($sql[$i]);
		}
		
		$res = $this->read();
		//echo $res['html'];
		
	}
	
	public function read(){
	
		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$arrSqlMonth[] = "SUM(`$month`) as '$month'";
			$arrHeader[] = $month;			
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

class master_record{
	public $Jan;
	public $Feb;
	public $Mar;
	public $Apr;
	public $May;
	public $Jun;
	public $Jul;
	public $Aug;
	public $Sep;
	public $Oct;
	public $Nov;
	public $Dec;
	public $company;
	public $account;
	public $item;
	public $customer;
	public $activity;
	public $source;
	public $particulars;
	//private $session_id;
	
	function __construct($session, $scenario){
		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$this->{$month} = 0;
		}
		
		$this->source = $session;
		$this->scenario = $scenario;
		
		return (true);
	}	
		
	public function set_month_value($i, $value){
		$month = date('M',mktime(0,0,0,(integer)$i,15));
		$this->{$month} =(double)$value;
		return(true);
	}
	
	public function getSQLstring($mStart=1, $mEnd=12){
		
		GLOBAL $oSQL;
	
		for($m=$mStart;$m<=$mEnd;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$arrRes[] = "`$month`=".$this->{$month};
		}
		
		//========= Быдлокод
		$arrRes[] = "`company`='OOO'";
		$arrRes[] = "`account`='".$this->account."'";
		$arrRes[] = "`item`='".$this->item."'";
		$arrRes[] = "`pc`=".$this->profit;
		$arrRes[] = "`source`='".$this->source."'";
		$arrRes[] = "`scenario`='".$this->scenario."'";
		$arrRes[] = "`customer`=".($this->customer?(integer)$this->customer:'NULL');
		$arrRes[] = "`activity`=".($this->activity?(integer)$this->activity:'NULL');
		$arrRes[] = "`part_type`=".($this->part_type?$oSQL->e($this->part_type):'NULL');
		$arrRes[] = "`particulars`=".$oSQL->e($this->particulars);
		//$arrRes[] = "`part_type`=".(is_object($this->particulars['obj'])?"'".$this->particulars['obj']->TYPE."'":'NULL');
		$res = "INSERT INTO `reg_master` SET ". implode(',',$arrRes).';';
		return $res;
	}
	
	public function total(){
		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$res += $this->{$month};
		}
		return ($res);
	}
}

class Budget{
	public $year;
	public $settings;
	public $title;
	protected $oSQL;
	
	function __construct($scenario){
		global $strLocal;
		global $oSQL;
		$this->oSQL = $oSQL;
		
		$sql = "SELECT * FROM `tbl_scenario` 
				LEFT JOIN stbl_user ON usrID=scnEditBy
				LEFT JOIN vw_journal ON guid=scnLastSource
				WHERE scnID='$scenario'";
		$rs = $this->oSQL->q($sql);
		$rw = $this->oSQL->f($rs);
				
		$this->year = $rw['scnYear'];
		$this->date_start = strtotime($rw['scnDateStart']);
		$this->title = $rw["scnTitle$strLocal"];
		$this->total = $rw['scnTotal'];
		$this->id = $scenario;
		$this->timestamp = "Updated by ".$rw['usrTitle']." on ".date('d.m.Y H:i',strtotime($rw['scnEditDate'])).", <a href='{$rw['script']}?{$rw['prefix']}ID={$rw['id']}'>".$rw['title']." #".$rw['id']."</a>";
		$this->type = $rw['scnType'];
		
		
		$this->flagUpdate = !$rw['scnFlagReadOnly'];
		
		$this->getSettings($this->oSQL, $this-id);
		
	}
	
	public function getSettings($oSQL=null, $scenario=''){
		
		if (!$scenario) $scenario = $this->id;
		if (!$oSQL) $oSQL = $this->oSQL;
		
		$sql = "SELECT SCV.*, VAR.* FROM tbl_scenario_variable SCV
					JOIN tbl_variable VAR ON varID=scvVariableID
					WHERE scvScenarioID='".$scenario."'";
			
			$rs = $oSQL->q($sql);
			while($rw = $oSQL->f($rs)){
				switch ($rw['varType']){
					case 'int':
						$value = (integer) $rw['scvValue'];
						break;
					case 'decimal':
						$value = (double) $rw['scvValue'];
						break;
					default:
						$value = $rw['scvValue'];
						break;
				}
				$this->settings[$rw['varID']] = $value;
			}
		return($this->settings);
	}
	
	public function getYTDSQL($mStart=1, $mEnd=12){
		for($m=$mStart;$m<=$mEnd;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$arrRes[] = "`$month`";
		}
		$res = implode('+',$arrRes);
		return($res);
	}
		
	public function getMonthlySQL($start=1, $end=12){
		for($m=$start;$m<=$end;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$arrRes[] = "`$month`";
		}
		$res = implode(',',$arrRes);
		return($res);
	}
	public function getMonthlySumSQL($start=1, $end=12){
		for($m=$start;$m<=$end;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$arrRes[] = "SUM(`$month`) as '$month'";
		}
		$res = implode(',',$arrRes);
		return($res);
	}
	
	public function getQuarterlySumSQL(){
			for($m=1;$m<5;$m++){
			$arrRes[] = "SUM(`Q$m`) as 'Q$m'";
		}
		$res = implode(',',$arrRes);
		return($res);
	}
	
	public function getTableHeader($type='monthly', $start=1, $end=12){
		switch($type){
			case 'quarterly':
				for($m=1;$m<5;$m++){
					$arrRes[] = 'Q'.$m;
				}
				$res = '<th class="budget-quarterly">'.implode('</th><th class="budget-quarterly">',$arrRes).'</th>';
				return($res);
				break;
			default:
				for($m=$start;$m<=$end;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					$arrRes[] = $month;
				}
				$res = '<th class="budget-monthly">'.implode('</th><th class="budget-monthly">',$arrRes).'</th>';
				return($res);
				break;
		}
	}
	
	public function getProfitTabs($register='', $acl = false){
		GLOBAL $oSQL;
		GLOBAL $arrUsrData;
		GLOBAL $budget_scenario;
		
		if ($acl){
			$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";
			$sqlWhere = "JOIN stbl_profit_role ON pccID=pcrProfitID WHERE pcrRoleID IN ($strRoles) AND pcrFlagRead=1";
		}
		
		ob_start();
		?>
		<div id='tabs' class='tabs'>
			<ul>
			<?php
			if (!$register){
				$sql = "SELECT DISTINCT pccGUID, pccTitle$strLocal as pccTitle FROM vw_profit $sqlWhere";
			} else {
				$sql = "SELECT DISTINCT pccGUID, pccTitle$strLocal as pccTitle 
						FROM `$register` 
						JOIN vw_profit ON pccID=pc
						 $sqlWhere
						";
				
			}
			$rs = $oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				echo "<li><a href='",$_SERVER['PHP_SELF'],"?budget_scenario={$budget_scenario}&tab=",$rw['pccGUID'],"'>",$rw['pccTitle'],"</a></li>\r\n";
			}
			echo "<li><a href='",$_SERVER['PHP_SELF'],"?budget_scenario={$budget_scenario}&tab=all'>All</a></li>\r\n";
			?>
			</ul>
		</div>
		<?php
		ob_flush();
	}
	
	public function getGHQTabs($register='', $acl = false){
		GLOBAL $oSQL;
		GLOBAL $arrUsrData;
		GLOBAL $budget_scenario;
			
		ob_start();
		?>
		<div id='tabs' class='tabs'>
			<ul>
			<?php
			if (!$register){
				$sql = "SELECT DISTINCT prtGHQ FROM vw_product_type";
			} else {
				$sql = "SELECT DISTINCT prtGHQ 
						FROM `$register`
						JOIN vw_product_type ON prtID=activity						
						 $sqlWhere
						";
				
			}
			$rs = $oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				echo "<li><a href='",$_SERVER['PHP_SELF'],"?budget_scenario={$budget_scenario}&tab=",$rw['prtGHQ'],"'>",$rw['prtGHQ'],"</a></li>\r\n";
			}
			echo "<li><a href='",$_SERVER['PHP_SELF'],"?budget_scenario={$budget_scenario}&tab=all'>All</a></li>\r\n";
			?>
			</ul>
		</div>
		<?php
		ob_flush();
	}
	
	public function getScenarioTabs(){
		GLOBAL $oSQL;
		GLOBAL $arrUsrData;
		GLOBAL $budget_scenario;
						
		ob_start();
		?>
		<div id='tabs' class='tabs'>
			<ul>
			<?php
			$sql = "SELECT * FROM tbl_scenario WHERE scnFlagDeleted=0";			
			$rs = $oSQL->q($sql);
			while ($rw=$oSQL->f($rs)){
				echo "<li><a href='",$_SERVER['PHP_SELF'],"?tab=",$rw['scnID'],"'>",$rw['scnTitle'],"</a></li>\r\n";
			}
			// echo "<li><a href='",$_SERVER['PHP_SELF'],"?tab=all'>All</a></li>\r\n";
			?>
			</ul>
		</div>
		<?php
		ob_flush();
	}
	
	public function getProfitAlias($rw){
		if ($rw['pccFlagProd']){
			switch ($rw['Profit']){
				case 'TMMR':
				case 'ICD':
					$keyProfit = 'Toyota';
					break;
				case 'Forwarding':
				case 'STP office':
				case 'NOVO':
				case 'Krekshino':
					$keyProfit = 'FWD';
					break;						
				default:
					$keyProfit = $rw['Profit'];
			}
		} else {
			$keyProfit = 'Corporate';
		}
		return ($keyProfit);
	}
	
	public function getScenarioSelect(){
		GLOBAL $budget_scenario;
		GLOBAL $oSQL;
		GLOBAL $strLocal;
		
		$sql = "SELECT * FROM tbl_scenario";
		$rs = $oSQL->q($sql);
		ob_start();
		?>
		<select name='budget_scenario' id='budget_scenario'>
		<?php
		while ($rw=$oSQL->f($rs)){
			echo "<option ".($budget_scenario==$rw['scnID']?'SELECTED':'')." value='{$rw['scnID']}'>{$rw["scnTitle$strLocal"]}</option>";
		}
		?>
		</select>
		<?
		$res = ob_get_clean();
		return($res);
	}
}

?>
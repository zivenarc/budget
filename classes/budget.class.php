<?php
class Budget{
	public $year;
	public $settings;
	public $title;
	protected $oSQL;	
	public static $arrPeriod;
	
	function __construct($scenario, $from = null){
	
		global $strLocal;
		global $oSQL;
		$this->oSQL = $oSQL;
		
		$sql = "SELECT * FROM `tbl_scenario` 
				LEFT JOIN stbl_user ON usrID=scnEditBy
				LEFT JOIN vw_journal ON guid=scnLastSource
				WHERE scnID='$scenario'";
		$rs = $this->oSQL->q($sql);
		$rw = $this->oSQL->f($rs);
			
		$this->arrPeriod = Array(1=>'jan',2=>'feb',3=>'mar',4=>'apr',5=>'may',6=>'jun',7=>'jul',8=>'aug',9=>'sep',10=>'oct',11=>'nov',12=>'dec',13=>'jan_1',14=>'feb_1',15=>'mar_1');
		$this->year = $rw['scnYear'];
		$this->date_start = strtotime($rw['scnDateStart']);
		$this->cm = date('n',$this->date_start-1); 
		$this->nm = $this->cm+1;
		$this->title = $rw["scnTitle$strLocal"];
		$this->total = $rw['scnTotal'];
		$this->id = $scenario;
		$this->timestamp = "Updated by ".$rw['usrTitle']." on ".date('d.m.Y H:i',strtotime($rw['scnEditDate'])).", <a href='{$rw['script']}?{$rw['prefix']}ID={$rw['id']}'>".$rw['title']." #".$rw['id']."</a>";
		$this->type = $rw['scnType'];
		$this->length = $rw['scnLength'];
		
		$this->flagUpdate = !$rw['scnFlagReadOnly'];
		$this->flagArchive = (integer)$rw['scnFlagArchive'];
		
		$this->getSettings($this->oSQL, $this->id);
		$this->rates = "<a href='?currency=840'>USD</a> = {$this->settings['usd']}, <a href='?currency=978'>EUR</a> = {$this->settings['eur']}";
		
		if ($rw['scnLastID']) {
			if (!$from) {
				$this->reference_scenario = new Budget($rw['scnLastID'], $this->id);
			}
		};				
	}
	
	public function getSettings($oSQL=null, $scenario=''){
		
		if (!$scenario) $scenario = $this->id;
		if (!$oSQL) $oSQL = $this->oSQL;
		
		$sql = "SELECT SCV.*, VAR.* FROM tbl_scenario_variable SCV
					JOIN tbl_variable VAR ON varID=scvVariableID
					WHERE scvScenarioID='".$scenario."'";
					
			// echo '<pre>',$sql,'</pre>';
			
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
				$this->extendedSettings[$rw['varID']] = Array('title'=>$rw['varTitle'],'value'=>$value);
			}
		
		return($this->settings);
		
	}
	
	public function getYTDSQL($mStart=1, $mEnd=12, $arrRates = null){
		for($m=$mStart;$m<=$mEnd;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));			
			$month = $this->arrPeriod[$m];
			
			if (is_array($arrRates)){				
				$arrRes[] = "`$month`/{$arrRates[$month]}";
			} else {
				$arrRes[] = "`$month`";
			}
		}
		if(is_array($arrRes)){
			$res = implode('+',$arrRes);
		} else {
			$res = '0';
		}
		return($res);
	}
	
	public function getThisYTDSQL($period_type = 'ytd',$arrRates = null){		
		$cm = date('M',$this->date_start - 1);
		$nm = date('M',$this->date_start);		
		$nCurrent = (integer)date('m',$this->date_start - 1);	
		
		switch ($period_type){
			case 'ytd':
				return($this->getYTDSQL(1,$nCurrent,$arrRates));
				break;
			case 'am':
				return($this->getYTDSQL(4,15,$arrRates));
				break;
			case 'cm':
				return($this->getYTDSQL($nCurrent,$nCurrent,$arrRates));
				break;
			case 'nm':
				return($this->getYTDSQL($nCurrent,$nCurrent,$arrRates));
				break;
			case 'roy':
				return($this->getYTDSQL($nCurrent+1,12,$arrRates));
				break;
			case 'q1':
				return($this->getYTDSQL(1,3,$arrRates));
				break;
			case 'q2':
				return($this->getYTDSQL(4,6,$arrRates));
				break;	
			case 'q3':
				return($this->getYTDSQL(7,9,$arrRates));
				break;
			case 'q4':
				return($this->getYTDSQL(10,12,$arrRates));
				break;
			case 'q5':
				return($this->getYTDSQL(13,15,$arrRates));
				break;
			default:
				return($this->getYTDSQL(1,12,$arrRates));
				break;
		}
		
	}
	
	public function getMonthlySQL($start=1, $end=12){
		for($m=$start;$m<=$end;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));
			$month = $this->arrPeriod[$m];
			$arrRes[] = "`$month`";
		}
		$res = implode(',',$arrRes);
		return($res);
	}
	public function getMonthlySumSQL($start=1, $end=12, $arrRates = null, $denominator=1){
		for($m=$start;$m<=$end;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));			
			$month = $this->arrPeriod[$m];
			if (is_array($arrRates)){				
				$arrRes[] = "SUM(`$month`)/{$arrRates[$month]}/{$denominator} as '$month'";
			} else {
				$arrRes[] = "SUM(`$month`)/{$denominator} as '$month'";
			}			
			
		}
		$res = implode(',',$arrRes);
		return($res);
	}
	
	public function getQuarterlySumSQL($arrRates = null){
			if(is_array($arrRates)){
				$arrRes[] = "SUM(`jan`/{$arrRates['jan']}+`feb`/{$arrRates['feb']}+`mar`/{$arrRates['mar']}) as 'Q1'";
				$arrRes[] = "SUM(`apr`/{$arrRates['apr']}+`may`/{$arrRates['may']}+`jun`/{$arrRates['jun']}) as 'Q2'";
				$arrRes[] = "SUM(`jul`/{$arrRates['jul']}+`aug`/{$arrRates['aug']}+`sep`/{$arrRates['sep']}) as 'Q3'";
				$arrRes[] = "SUM(`oct`/{$arrRates['oct']}+`nov`/{$arrRates['nov']}+`dec`/{$arrRates['dec']}) as 'Q4'";
				$arrRes[] = "SUM(`jan_1`/{$arrRates['jan_1']}+`feb_1`/{$arrRates['feb_1']}+`mar_1`/{$arrRates['mar_1']}) as 'Q5'";
			} else {
				for($q=1;$q<=5;$q++){			
					$arrRes[] = "SUM(`Q$q`) as 'Q$q'";
				}
			}
		$res = implode(',',$arrRes);
		return($res);
	}
	
	public function getTableHeader($type='monthly', $start=1, $end=12){
		switch($type){
			case 'quarterly':
				for($q=1;$q<5;$q++){
					$arrRes[] = 'Q'.$q;
				}
				$res = '<th class="budget-quarterly">'.implode('</th><th class="budget-quarterly">',$arrRes).'</th>';
				return($res);
				break;
			case 'mr':
				ob_start();
				?>
					<th colspan="4">Current month (<?php echo date('M',$this->date_start-1);?>)</th>
					<th colspan="4">YTD</th>				
					<th colspan="4">Next month (<?php echo date('M',$this->date_start);?>)</th>
				</tr>
				<tr>
					<th class='budget-ytd'>Actual</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<th class='budget-quarterly'>Actual</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<th class='budget-ytd'>Forecast</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
				</tr>
				<?php
				$res = ob_get_contents();
				break;
			default:
				for($m=$start;$m<=$end;$m++){
					// $month = date('M',mktime(0,0,0,$m,15));
					$month = $this->arrPeriod[$m];
					$arrRes[] = ucfirst($month);
				}
				$res = '<th class="budget-monthly">'.implode('</th><th class="budget-monthly">',$arrRes).'</th>';
				return($res);
				break;
		}
	}
	
	public function getProfitTabs($register='', $acl = false, $params = Array()){
		GLOBAL $oSQL;
		GLOBAL $arrUsrData;
		GLOBAL $budget_scenario;
		
		if ($acl){
			$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";
			$sqlWhere = "JOIN stbl_profit_role ON pccID=pcrProfitID WHERE pcrRoleID IN ($strRoles) AND pcrFlagRead=1";
		}
		
		foreach ($params as $key=>$value){
			if (is_array($value)){
				$sqlWhere .= " AND `{$key}` IN ('".implode("','",$value)."')\r\n";
			} else {
				$sqlWhere .= " AND `{$key}`='{$value}'\r\n";
			}
		}
		
		$sqlWhere .= " AND scenario='$budget_scenario'";
		
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
			
			// echo '<pre>',$sql,'</pre>';
			$rs = $oSQL->q($sql);
			
			$arrGET = $_GET;
			
			if (isset($_GET['currency'])){
				$strCurrencyURL = "&currency=".$_GET['currency'];
			}
			
			while ($rw=$oSQL->f($rs)){
				$arrGET['pccGUID'] = $rw['pccGUID'];				
				echo "<li><a href='",$_SERVER['PHP_SELF'],"?",http_build_query($arrGET),"'>",$rw['pccTitle'],"</a></li>\r\n";
				
			}
			$arrGET['pccGUID'] = 'all';	
			echo "<li><a href='",$_SERVER['PHP_SELF'],"?",http_build_query($arrGET),"'>All</a></li>\r\n";
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
				echo "<li><a href='",$_SERVER['PHP_SELF'],"?budget_scenario={$budget_scenario}&prtGHQ=",urlencode($rw['prtGHQ']),"'>",($rw['prtGHQ']?$rw['prtGHQ']:'[None]'),"</a></li>\r\n";
			}
			echo "<li><a href='",$_SERVER['PHP_SELF'],"?budget_scenario={$budget_scenario}&prtGHQ=all'>All</a></li>\r\n";
			?>
			</ul>
		</div>
		<?php
		ob_flush();
	}
	
	public function getActivityTabs($register='', $acl = false, $sqlWhere=""){
		GLOBAL $oSQL;
		GLOBAL $arrUsrData;
		GLOBAL $budget_scenario;
			
		ob_start();
		?>
		<div id='tabs' class='tabs'>
			<ul>
			<?php
			if (!$register){
				$sql = "SELECT DISTINCT prtID, prtTitle{$arrUsrData['strLocal']} as prtTitle FROM vw_product_type";
			} else {
				$sql = "SELECT DISTINCT prtID, prtTitle{$arrUsrData['strLocal']} as prtTitle
						FROM `$register`
						JOIN vw_product_type ON prtID=activity						
						 $sqlWhere
						";
				
			}
			$rs = $oSQL->q($sql);
			
			$arrGET = $_GET;
						
			while ($rw=$oSQL->f($rs)){
				$arrGET['tab'] = $rw['prtID'];
				$arrGET['budget_scenario'] = $budget_scenario;
				// echo "<li><a href='",$_SERVER['PHP_SELF'],"?budget_scenario={$budget_scenario}&tab=",$rw['prtID'],"'>",$rw['prtTitle'],"</a></li>\r\n";
				echo "<li><a href='",$_SERVER['PHP_SELF'],"?",http_build_query($arrGET),"'>",$rw['prtTitle'],"</a></li>\r\n";
			}
			
			$arrGET['tab'] = 'all';
			// echo "<li><a href='",$_SERVER['PHP_SELF'],"?budget_scenario={$budget_scenario}&tab=all'>All</a></li>\r\n";
			echo "<li><a href='",$_SERVER['PHP_SELF'],"?",http_build_query($arrGET),"'>All</a></li>\r\n";
			?>
			</ul>
		</div>
		<?php
		ob_flush();
	}
	
	public function getScenarioTabs($flagWrite=0){
		GLOBAL $oSQL;
		GLOBAL $arrUsrData;
		GLOBAL $budget_scenario;
						
		ob_start();
		?>
		<div id='tabs' class='tabs'>
			<ul>
			<?php
			$sql = "SELECT * FROM tbl_scenario WHERE scnFlagDeleted=0 AND scnFlagArchive=0 ".($flagWrite?" AND scnFlagReadOnly=0":"");			
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
	
	public function getProfitAlias($arrData, $structure = true){
			
		GLOBAL $oSQL;
		
		if ($structure){ // Подбор структуры в соответствии с 1С
			if (!isset($this->arrPccID)){
				$sql = "SELECT * FROM common_db.tbl_profit";
				$rs = $oSQL->q($sql);
				while ($rw = $oSQL->f($rs)){
					$this->arrPccID[$rw['pccCode1C']] = $rw;
					$this->arrProfit[$rw['pccTitle']] = $rw;
				}
			}
			$keyProfit = $this->arrPccID[$this->arrProfit[$arrData['Profit']]['pccParentCode1C']]['pccTitle'];
		} else {
			// По понятиям, быдлокод
			if ($arrData['pccFlagProd']){
				switch ($arrData['Profit']){
					case 'TMMR':
					case 'ICD':
						$keyProfit = 'Toyota';
						break;
					case 'Forwarding':				
					//case 'NOVO':
					case 'Krekshino':
						$keyProfit = 'FWD';
						break;
					// case 'STP':
					// case 'CHB':
						// $keyProfit = 'STP+CHB';
						// break;
					default:
						$keyProfit = $arrData['Profit'];
				}
			} else {
				$keyProfit = 'Corporate';
			}
		}
		
		if(!$keyProfit) $keyProfit = $arrData['Profit'];
		
		return ($keyProfit);
	}
	
	public function getScenarioSelect($params = Array()){
		GLOBAL $budget_scenario;
		GLOBAL $oSQL;
		GLOBAL $strLocal;
		
		if (isset($params['budget_scenario'])){
			$scnID=$params['budget_scenario'];
		} else {
			$scnID=$budget_scenario;
		}
		
		if (isset($params['type'])){
			$sqlWhere = "WHERE ";
		}
		
		switch ($params['type']){
			case 'FYE':
				$sqlWhere .= "scnType IN('FYE','Actual') ";
				break;
			case 'Budget':
				$sqlWhere .= "scnType='Budget' ";
				break;
			default:
				break;
		}
		
		if ($params['active']===false){
			$sql = "SELECT * FROM `tbl_scenario` {$sqlWhere}";
		} else {
			$sql = "SELECT * FROM `vw_active_scenario` {$sqlWhere}";
		}
		$rs = $oSQL->q($sql);
		ob_start();
		
		$id = $params['name']?$params['name']:'budget_scenario';
		?>
		<select name='<?php echo $id;?>' id='<?php echo $id;?>'>
		<?php
		while ($rw=$oSQL->f($rs)){
			echo "<option ".($scnID==$rw['scnID']?'SELECTED':'')." value='{$rw['scnID']}'>{$rw["scnTitle$strLocal"]}</option>";
		}
		?>
		</select>
		<?
		$res = ob_get_clean();
		return($res);
	}
	
	public function getMonthlyRates($currency=643){		
		
		// $this->oSQL->startProfiling();
		
		$res = Array('YTD'=>1,'ROY'=>1, 'Total'=>1, 'Estimate'=>1);
		for($m=1;$m<=15;$m++){
				// $month = date('M',mktime(0,0,0,$m,15));
				$month = $this->arrPeriod[$m];
				$res[$month] = 1;
		}
		for($m=1;$m<=5;$m++){
				// $month = date('M',mktime(0,0,0,$m,15));
				$quarter = 'Q'.$m;
				$res[$quarter] = 1;
		}
		
		if ($currency==643 || !$currency){
			return ($res);
		}
		
		$start_month = date('n',$this->date_start);
		
		$sql = "SELECT * FROM common_db.tbl_currency WHERE curID={$currency}";
		$rs = $this->oSQL->q($sql);
		
		if ($this->oSQL->n($rs)){
			switch($this->type){
				case 'FYE':
					$sql = "SELECT DATE_FORMAT(erhDate,'%b') as 'month', AVG(erhRate) as Rate
								FROM common_db.tbl_rate_history
								WHERE erhCurrencyID={$currency} 
									AND YEAR(erhDate)={$this->year} 
									AND MONTH(erhDate)<{$start_month}
								GROUP BY DATE_FORMAT(erhDate,'%b')";
					
					$rs = $this->oSQL->q($sql);
					$i=0;
					while ($rw = $this->oSQL->f($rs)){
						$res[strtolower($rw['month'])] = $rw['Rate'];
						$ytd_rate+=$rw['Rate'];
						$i++;
					}
					$res['YTD'] = $ytd_rate/$i;
					
					$sql = "SELECT scvValue as Rate FROM tbl_scenario_variable, vw_currency 
								WHERE curTitle=scvVariableID AND scvScenarioID='{$this->id}'
									AND curID={$currency}";
					$rs = $this->oSQL->q($sql);
					$rw = $this->oSQL->f($rs);
					
					for($m=$start_month;$m<=15;$m++){
						$month = $this->arrPeriod[$m];
						$res[$month] = $rw['Rate'];
					}
					
					if ($start_month>1) {
						$res['ROY'] = $res[$this->arrPeriod[$start_month]];
					}
					
					$res['Q1'] = ($res['jan']*31+$res['feb']*28+$res['mar']*31)/90;
					$res['Q2'] = ($res['apr']*30+$res['may']*31+$res['jun']*30)/91;
					$res['Q3'] = ($res['jul']*31+$res['aug']*31+$res['sep']*30)/93;
					$res['Q4'] = ($res['oct']*31+$res['nov']*30+$res['dec']*31)/92;
					$res['Q5'] = ($res['jan_1']*31+$res['feb_1']*28+$res['mar_1']*31)/90;
					
					$res['Total'] = ($res['Q1']+$res['Q2']+$res['Q3']+$res['Q4'])/4;
					
					break;
				case 'Budget':
					$sql = "SELECT scvValue as Rate FROM tbl_scenario_variable, vw_currency
								WHERE curTitle=scvVariableID 
									AND scvScenarioID='{$this->id}'
									AND curID={$currency}";
					$rs = $this->oSQL->q($sql);
					$rw = $this->oSQL->f($rs);
					for($m=1;$m<=15;$m++){
						$month = $this->arrPeriod[$m];
						$res[$month] = $rw['Rate'];
					}
					for($m=1;$m<=5;$m++){
							$quarter = 'Q'.$m;
							$res[$quarter] =  $res['dec'];
					}
					$res['Total'] = $res['dec'];
					break;
			}
			
			// $this->oSQL->showProfileInfo();
			return ($res);
			
		} else {
			return (false);
		}
		
		
	}
	
	function readOnly($flag = true){
		
		GLOBAL $arrUsrData;
		
		$sql = "UPDATE tbl_scenario SET scnFlagReadOnly=".(integer)$flag.", scnEditBy='{$arrUsrData['usrID']}', scnEditDate=NOW() WHERE scnID='{$this->id}'";
		$this->oSQL->q($sql);
	
	}
	
	function archive($flag = true){
		
		GLOBAL $arrUsrData;
		
		$sql[] = "UPDATE tbl_scenario SET scnFlagArchive=".(integer)$flag.", scnEditBy='{$arrUsrData['usrID']}', scnEditDate=NOW() WHERE scnID='{$this->id}'";
		
		if ($flag){
			$sqlDoc = "SELECT * FROM stbl_entity WHERE entType='REF'";
			$rs = $this->oSQL->q($sqlDoc);
			while ($rw = $this->oSQL->f($rs)){			
				$sql[] = "DELETE FROM `{$rw['entTable']}` WHERE `{$rw['entPrefix']}FlagPosted`=0 AND `{$rw['entPrefix']}Scenario`='{$this->id}'";
			}
		}
		
		for ($i=0;$i<count($sql);$i++){
			$this->oSQL->q($sql[$i]);
		};
	
	}
	
	function getBUGroupSelect(){
		GLOBAL $bu_group;
		
		$sql = "SELECT * FROM common_db.tbl_profit WHERE pccFlagFolder=1";
		$rs = $this->oSQL->q($sql);
		while ($rw = $this->oSQL->f($rs)){
			$arrSelect[$rw['pccCode1C']] = $rw['pccTitle'];
		}
		$arrSelect[] = "---None---";
		?>
		<select name='bu_group' id='bu_group'>
			<?php 
				foreach($arrSelect as $key=>$value){
					echo "<option value='{$key}' ".($key==$bu_group?'selected':'').">{$value}</option>";
				}
			?>
		</select>
		<?php
			
	}
}

?>
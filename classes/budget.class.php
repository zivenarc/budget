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
		
		$sql = "SELECT * FROM `budget`.`tbl_scenario` 
				LEFT JOIN `budget`.stbl_user ON usrID=scnEditBy
				LEFT JOIN `budget`.vw_journal ON guid=scnLastSource
				WHERE scnID='$scenario'";
		$rs = $this->oSQL->q($sql);
		if(!$this->oSQL->n($rs)){
			throw new Exception("Budget scenario {$scenario} doesn't exist");
		};
		$rw = $this->oSQL->f($rs);
		
		$this->year = (integer)$rw['scnYear'];
		
		$this->arrPeriod = Array(1=>'jan',2=>'feb',3=>'mar',4=>'apr',5=>'may',6=>'jun',7=>'jul',8=>'aug',9=>'sep',10=>'oct',11=>'nov',12=>'dec',13=>'jan_1',14=>'feb_1',15=>'mar_1');
		$this->arrPeriodTitle = Array(1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec',13=>'Jan\''.($this->year - 1999),14=>'Feb\''.($this->year - 1999),15=>'Mar\''.($this->year - 1999));
		$this->type = $rw['scnType'];
		if (strpos($this->type,'AM')){
			$this->offset = 3;
		}
		
		$this->date_start = strtotime($rw['scnDateStart']);
		$this->date_end = mktime(23,59,59,12+$this->offset,31,$this->year);
		
		if ($this->type=='Actual' || $this->type=='Budget'){
			$this->cm=12;
			$this->nm = 99;
		} elseif ($this->type=='Actual_AM'){
			$this->cm=15;
			$this->nm = 4;
		} elseif ($this->type=='Budget_AM'){
			$this->cm=3;
			$this->nm=4;
		} else {
			$this->cm = date('n',$this->date_start-1)+12*(date('Y',$this->date_start-1)-$this->year); 
			$this->nm = $this->cm+1;
		};
		
		$this->title = $rw["scnTitle$strLocal"];
		$this->total = $rw['scnTotal'];
		$this->id = $scenario;
		$this->editDate = strtotime($rw['scnEditDate']);
		$this->timestamp = "Updated by ".$rw['usrTitle']." on ".date('d.m.Y H:i',$this->editDate).", <a href='{$rw['script']}?{$rw['prefix']}ID={$rw['id']}'>".$rw['title']." #".$rw['id']."</a>";
		$this->length = $rw['scnLength'];
		
		$this->flagUpdate = !$rw['scnFlagReadOnly'] && strtotime($rw['scnDeadline'])>time();
		$this->flagReadOnly = $rw['scnFlagReadOnly'];
		$this->flagArchive = (integer)$rw['scnFlagArchive'];
		$this->flagPublic = (integer)$rw['scnFlagPublic'];
		
		$this->checksum = $rw['scnChecksum'];
		
		$this->getSettings($this->oSQL, $this->id);
		$this->rates = "<a href='?currency=840'>USD</a> = ".number_format($this->settings['usd'],2,'.',',').", <a href='?currency=978'>EUR</a> = ".number_format($this->settings['eur'],0,'.',',');
		
		if ($rw['scnLastID']) {
			if (!$from) {
				$this->reference_scenario = new Budget($rw['scnLastID'], $this->id);
			}
		};	

		$this->reference = $rw['scnLastID'];
		$this->forecast = $rw['scnForecastID'];
		$this->lastyear = $rw['scnLastYearID'];
		$this->deadline = date('d M Y H:i',strtotime($rw['scnDeadline']));
		
		$sql = "SELECT * FROM common_db.tbl_profit";
		$rs = $this->oSQL->q($sql);
		while ($rw = $this->oSQL->f($rs)){
			$this->arrProfit[$rw['pccGUID']] = $rw;
		}		
	}
	
	public function getSettings($oSQL=null, $scenario=''){
		
		if (!$scenario) $scenario = $this->id;
		if (!$oSQL) $oSQL = $this->oSQL;
		
		$sql = "SELECT SCV.*, VAR.* FROM `budget`.`tbl_scenario_variable` SCV
					JOIN `budget`.`tbl_variable` VAR ON varID=scvVariableID
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
	
	public function getYTDSQL($mStart=1, $mEnd=12, $arrRates = null, $denominator=1){
		for($m=$mStart;$m<=$mEnd;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));			
			$month = $this->arrPeriod[$m];
			
			if($denominator>1) $strDenominator = "/{$denominator}";
			
			if (is_array($arrRates)){				
				$arrRes[] = "`$month`/{$arrRates[$month]}".$strDenominator;
			} else {
				$arrRes[] = "`$month`".$strDenominator;
			}
		}
		if(is_array($arrRes)){
			$res = implode('+',$arrRes);
		} else {
			$res = '0';
		}
		return($res);
	}
	
	public function getThisYTDSQL($period_type = 'ytd',$arrRates = null, $denominator=1){		
		$cm = $this->cm;
		$nm = $this->nm;	
		$nCurrent = $this->cm;	
		
		switch ($period_type){
			case 'ytd':
				return($this->getYTDSQL(1+$this->offset,$nCurrent,$arrRates,$denominator));
				break;
			case 'am':
				return($this->getYTDSQL(4,15,$arrRates,$denominator));
				break;
			case 'cm':
				return($this->getYTDSQL($nCurrent,$nCurrent,$arrRates,$denominator));
				break;
			case 'cq':				
				return($this->getYTDSQL($nCurrent-2,$nCurrent,$arrRates,$denominator));
				break;
			case 'nm':
				return($this->getYTDSQL($nm,$nm,$arrRates,$denominator));
				break;
			case 'roy':
				return($this->getYTDSQL($nCurrent+1,12+$this->offset,$arrRates,$denominator));
				break;
			case 'q1':
				return($this->getYTDSQL(1,3,$arrRates,$denominator));
				break;
			case 'q2':
				return($this->getYTDSQL(4,6,$arrRates,$denominator));
				break;	
			case 'q3':
				return($this->getYTDSQL(7,9,$arrRates,$denominator));
				break;
			case 'q4':
				return($this->getYTDSQL(10,12,$arrRates,$denominator));
				break;
			case 'q5':
				return($this->getYTDSQL(13,15,$arrRates,$denominator));
				break;
			default:
				return($this->getYTDSQL(1+$this->offset,12+$this->offset,$arrRates,$denominator));
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
	public function getMonthlySumSQL($start=4, $end=15, $arrRates = null, $denominator=1){
		
		if ($start>$end) return ('');
		
		for($m=$start;$m<=$end;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));			
			$month = $this->arrPeriod[$m];
			if (is_array($arrRates)){				
				$arrRes[] = "SUM(`$month`)/{$arrRates[$month]}".($denominator>1?"/{$denominator}":"")." AS '$month'";
			} else {
				$arrRes[] = "SUM(`$month`)".($denominator>1?"/{$denominator}":"")." AS '$month'";
			}			
			
		}
		$res = implode(',',$arrRes);
		return($res);
	}
	
	public function getQuarterlySumSQL($arrRates = null, $denominator=1, $suffix=""){
	
			$strDenominator = $denominator>1?"/$denominator":"";
	
			if(is_array($arrRates)){
				$arrRes[] = "SUM(`jan`/{$arrRates['jan']}+`feb`/{$arrRates['feb']}+`mar`/{$arrRates['mar']}){$strDenominator} as 'Q1{$suffix}'";
				$arrRes[] = "SUM(`apr`/{$arrRates['apr']}+`may`/{$arrRates['may']}+`jun`/{$arrRates['jun']}){$strDenominator} as 'Q2{$suffix}'";
				$arrRes[] = "SUM(`jul`/{$arrRates['jul']}+`aug`/{$arrRates['aug']}+`sep`/{$arrRates['sep']}){$strDenominator} as 'Q3{$suffix}'";
				$arrRes[] = "SUM(`oct`/{$arrRates['oct']}+`nov`/{$arrRates['nov']}+`dec`/{$arrRates['dec']}){$strDenominator} as 'Q4{$suffix}'";
				$arrRes[] = "SUM(`jan_1`/{$arrRates['jan_1']}+`feb_1`/{$arrRates['feb_1']}+`mar_1`/{$arrRates['mar_1']}){$strDenominator} as 'Q5{$suffix}'";
			} else {
				for($q=1;$q<=5;$q++){			
					$arrRes[] = "SUM(`Q{$q}`){$strDenominator} as 'Q{$q}{$suffix}'";
				}
			}
		$res = implode(',',$arrRes);
		return($res);
	}
	
	public function getTableHeader($type='monthly', $start=1, $end=12){
		switch($type){
			case 'quarterly':
				for($q=1+$this->offset/3;$q<=4+$this->offset/3;$q++){
					$arrRes[] = 'Q'.$q;
				}
				$res = '<th class="budget-quarterly">'.implode('</th><th class="budget-quarterly">',$arrRes).'</th>';
				return($res);
				break;
			case 'mr':
				ob_start();
				?>
					<th colspan="4">Current month (<?php echo date('M',$this->date_start-1);?>)</th>
					<?php if (!($this->cm % 3) && $this->cm>6){ ?>
					<th colspan="4">Current quarter</th>
					<?php } ?>
					<th colspan="4">YTD</th>				
					<th colspan="6">Next month (<?php echo $this->arrPeriodTitle[$this->nm];?>)</th>
					<?php if (!($this->nm % 3)){ ?>
					<th colspan="4">Full year</th>
					<?php } ?>
				</tr>
				<tr>
					<th class='budget-quarterly'>Actual</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<?php if (!($this->cm % 3) && $this->cm>6 ){ ?>
					<th class='budget-quarterly'>Actual</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<?php } ?>
					<th class='budget-ytd'>Actual</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<th class='budget-quarterly'>Forecast</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<th>Diff to <?php echo $this->arrPeriodTitle[$this->cm];?></th>
					<th>%</th>
					<?php if (!($this->nm % 3)){ ?>
					<th class='budget-ytd'>Forecast</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<?php } ?>
				</tr>
				<?php
				$res = ob_get_clean();				
				break;
			case 'mr_rhq':
				ob_start();
				?>
					<th colspan="6">Current month (<?php echo date('M',$this->date_start-1);?>)</th>					
					<th colspan="6">YTD</th>				
					<th colspan="6">Full year<?php if ($this->flagUpdate) echo " <em>(in progress)</em>";?></th>					
				</tr>
				<tr>
					<th class='budget-ytd'>Actual</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<th>Forecast</th>
					<th>%</th>
					<th class='budget-ytd'>Actual</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<th>Last year</th>					
					<th>%</th>
					<th class='budget-ytd'>Forecast</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<th>Last year</th>
					<th>%</th>					
				</tr>
				<?php
				$res = ob_get_clean();				
				break;
			case 'budget':
				ob_start();
				?>
					<th colspan="4"><?php echo $this->year;?></th>
				</tr>
				<tr>
					<th class='budget-ytd'>Budget</th>
					<th>Reference</th>
					<th>Diff</th>
					<th>%</th>
				</tr>
				<?php
				$res = ob_get_clean();					
				break;
			case 'roy':
			case 'fye':
				ob_start();
				?>
					<th colspan="4">YTD</th>
					<th colspan="4">Rest of year</th>				
					<th colspan="4">FYE</th>
				</tr>
				<tr>
					<th class='budget-ytd'>Actual</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<th class='budget-quarterly'>Forecast</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
					<th class='budget-ytd'>Forecast</th>
					<th>Budget</th>
					<th>Diff</th>
					<th>%</th>
				</tr>
				<?php
				$res = ob_get_clean();				
				break;
			default:
				for($m=$start;$m<=$end;$m++){
					// $month = date('M',mktime(0,0,0,$m,15));
					if ($m>12){
						$month = $this->arrPeriod[$m-12]."'".($this->year-1999);
					} else {
						$month = $this->arrPeriod[$m];
					};
					
					$arrRes[] = ucfirst($month);
					
				}
				$res = '<th class="budget-monthly">'.implode('</th><th class="budget-monthly">',$arrRes).'</th>';				
				break;
		}
		return($res);
	}
	
	public function getGHQTabs(){
		GLOBAL $oSQL;
		GLOBAL $arrUsrData;
		
		$sql = "SELECT DISTINCT prtGHQ FROM vw_product_type ORDER BY prtGHQ";
		$rs = $oSQL->q($sql);
		ob_start();
		?>
		<div id='tabs' class='tabs'>
			<ul>
			<?php
			while ($rw=$oSQL->f($rs)){
				$arrGET['prtGHQ'] = urlencode($rw['prtGHQ']);				
				echo "<li><a href='",$_SERVER['PHP_SELF'],"?",http_build_query($arrGET),"'>",($rw['prtGHQ']?$rw['prtGHQ']:'[None]'),"</a></li>\r\n";
				
			}
			$arrGET['prtGHQ'] = 'OFF';	
			echo "<li><a href='",$_SERVER['PHP_SELF'],"?",http_build_query($arrGET),"'>OFF</a></li>\r\n";
			$arrGET['prtGHQ'] = 'AFF';	
			echo "<li><a href='",$_SERVER['PHP_SELF'],"?",http_build_query($arrGET),"'>AFF</a></li>\r\n";
			$arrGET['prtGHQ'] = 'CLT';	
			echo "<li><a href='",$_SERVER['PHP_SELF'],"?",http_build_query($arrGET),"'>CLT</a></li>\r\n";
			$arrGET['prtGHQ'] = 'all';	
			echo "<li><a href='",$_SERVER['PHP_SELF'],"?",http_build_query($arrGET),"'>-= All =-</a></li>\r\n";
			?>
			</ul>
		</div>
		<?php
		ob_flush();
	}
	
	public function getProfitTabs($register='', $acl = false, $params = Array()){
		GLOBAL $oSQL;
		GLOBAL $arrUsrData;
		GLOBAL $budget_scenario;
		GLOBAL $bu_group;
		
		if ($acl && $arrUsrData['usrID']){
			$strRoles = "'".implode("','",$arrUsrData['roleIDs'])."'";
			$sqlWhere = "JOIN stbl_profit_role 
							ON pccID=pcrProfitID 
							WHERE pcrRoleID IN ({$strRoles}) 
							AND pcrFlagRead=1";
		}
		
		foreach ($params as $key=>$value){
			if (is_array($value)){
				$sqlWhere .= " AND `{$key}` IN ('".implode("','",$value)."')\r\n";
			} else {
				$sqlWhere .= " AND `{$key}`='{$value}'\r\n";
			}
		}
				
		ob_start();
		?>
		<div id='tabs' class='tabs'>
			<ul>
			<?php
			if ($bu_group==0){
				$sql = "SELECT DISTINCT pccGUID as optValue, pccTitle as optText 
						FROM vw_profit 
						WHERE pccFlagFolder=1 AND pccFlagDeleted=0
						ORDER BY pccID";
			} else {
				$sql = "SELECT * FROM common_db.tbl_profit WHERE pccParentCode1C='{$bu_group}'";
				$rs = $oSQL->q($sql);
				while ($rw = $oSQL->f($rs)){
					$arrBus[] = $rw['pccID']; 
				}
				$sqlWhere .= " AND pccID IN (".implode(',',$arrBus).")";
				
				if (!$register){
					$sql = "SELECT DISTINCT pccGUID as optValue, pccTitle$strLocal as optText 
								FROM vw_profit 
								{$sqlWhere} 
								ORDER BY pccParentCode1C, pccTitle";
				} else {
					$sqlWhere .= " AND scenario='$budget_scenario'";
					$sql = "SELECT DISTINCT pccGUID as optValue, pccTitle$strLocal as optText 
							FROM `$register` 
							JOIN vw_profit ON pccID=pc
							{$sqlWhere}
							ORDER BY pccParentCode1C, pccTitle";
					
				}
			}
			// echo '<pre>',$sql,'</pre>';
			$rs = $oSQL->q($sql);
			
			$arrGET = $_GET;
			
			if (isset($_GET['currency'])){
				$strCurrencyURL = "&currency=".$_GET['currency'];
			}
			
			$arrGET['pccGUID'] = 'all';	
			echo "<li><a href='",$_SERVER['PHP_SELF'],"?",http_build_query($arrGET),"'>All</a></li>\r\n";
			
			while ($rw=$oSQL->f($rs)){
				$arrGET['pccGUID'] = $rw['optValue'];				
				echo "<li><a href='",$_SERVER['PHP_SELF'],"?",http_build_query($arrGET),"'>",$rw['optText'],"</a></li>\r\n";
				
			}

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
				echo "<li><a class='",($rw['scnFlagReadOnly']?'budget-readonly':''),"' href='",$_SERVER['PHP_SELF'],"?tab=",$rw['scnID'],"'>",$rw['scnTitle'],"</a></li>\r\n";
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
					case 'Automotive':
					case 'TRU':
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
				$sqlWhere .= "scnType IN('FYE','Actual','FYE_AM','Actual_AM') ";
				break;
			case 'Budget':
				$sqlWhere .= "scnType IN ('Budget','Budget_AM') ";
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
		<?php
		$res = ob_get_clean();
		return($res);
	}
	
	public function getMonthlyRates($currency=643){		
		
		// $this->oSQL->startProfiling();
		$keys = Array('YTD','ROY','Total','Estimate');
		for($m=1;$m<=15;$m++){
				// $month = date('M',mktime(0,0,0,$m,15));
				$month = $this->arrPeriod[$m];
				$keys[] = $month;
		}
		for($m=1;$m<=5;$m++){
				// $month = date('M',mktime(0,0,0,$m,15));
				$quarter = 'Q'.$m;
				$keys[] = $quarter;
		}
		$res = array_fill_keys($keys, 1);
		
		if ($currency=='rhq'){
			$sql = "SELECT scvValue as Rate FROM tbl_scenario_variable, vw_currency 
					WHERE curTitle=scvVariableID AND scvScenarioID='{$this->id}'
					AND curID=978";
					$rs = $this->oSQL->q($sql);
					$rate = $this->oSQL->get_data($rs);
			$res = array_fill_keys($keys, $rate);
			return($res);
		}
		

		
		if ($currency==643 || !$currency){
			return ($res);
		}
		
		$start_month = $this->nm;
		
		$sql = "SELECT * FROM common_db.tbl_currency WHERE curID={$currency}";
		$rs = $this->oSQL->q($sql);
		
		if ($this->oSQL->n($rs)){
			switch($this->type){
				case 'Actual':
					$sql = "SELECT DATE_FORMAT(erhDate,'%b') as 'month',YEAR(erhDate) as Year, AVG(erhRate)/curDecRate as Rate
					FROM common_db.tbl_rate_history, common_db.tbl_currency
					WHERE erhCurrencyID={$currency} AND erhCurrencyID=curID
						AND erhDate BETWEEN '{$this->year}-01-01' AND '".($this->year+1)."-03-31'									
					GROUP BY DATE_FORMAT(erhDate,'%b')";
					// echo $sql;
					$rs = $this->oSQL->q($sql);
					$i=0;
					while ($rw = $this->oSQL->f($rs)){
						$month = strtolower($rw['month'].($rw['Year']>$this->year?"_1":""));
						$res[$month] = $rw['Rate'];
						$ytd_rate+=$rw['Rate'];
						$i++;
					}
					$res['YTD'] = $ytd_rate/$i;
					break;
				case 'Actual_AM':
					$sql = "SELECT DATE_FORMAT(erhDate,'%b') as 'month',YEAR(erhDate) as Year, AVG(erhRate)/curDecRate as Rate
								FROM common_db.tbl_rate_history, common_db.tbl_currency
								WHERE erhCurrencyID={$currency} AND erhCurrencyID=curID
									AND erhDate BETWEEN '{$this->year}-04-01' AND '".($this->year+1)."-03-31'									
								GROUP BY DATE_FORMAT(erhDate,'%b')";
					// echo $sql;
					$rs = $this->oSQL->q($sql);
					$i=0;
					while ($rw = $this->oSQL->f($rs)){
						$month = strtolower($rw['month'].($rw['Year']>$this->year?"_1":""));
						$res[$month] = $rw['Rate'];
						$ytd_rate+=$rw['Rate'];
						$i++;
					}
					$res['YTD'] = $ytd_rate/$i;
					break;
				case 'FYE':
				case 'FYE_AM':
					$sql = "SELECT DATE_FORMAT(erhDate,'%b') as 'month',YEAR(erhDate) as Year, AVG(erhRate)/curDecRate as Rate
								FROM common_db.tbl_rate_history, common_db.tbl_currency
								WHERE erhCurrencyID={$currency} AND erhCurrencyID=curID
									AND erhDate BETWEEN '{$this->year}-04-01' AND '".date('Y-m-d',$this->date_start)."'
								GROUP BY DATE_FORMAT(erhDate,'%b')";
					// echo '<pre>',$sql,'</pre>';
					$rs = $this->oSQL->q($sql);
					$i=0;
					while ($rw = $this->oSQL->f($rs)){
						$month = strtolower($rw['month'].($rw['Year']>$this->year?"_1":""));
						$res[$month] = $rw['Rate'];
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
					
					if ($start_month>1+$this->offset) {
						$res['ROY'] = $res[$this->arrPeriod[$start_month]];
					}
					
					$res['Q1'] = ($res['jan']*31+$res['feb']*28+$res['mar']*31)/90;
					$res['Q2'] = ($res['apr']*30+$res['may']*31+$res['jun']*30)/91;
					$res['Q3'] = ($res['jul']*31+$res['aug']*31+$res['sep']*30)/93;
					$res['Q4'] = ($res['oct']*31+$res['nov']*30+$res['dec']*31)/92;
					$res['Q5'] = ($res['jan_1']*31+$res['feb_1']*28+$res['mar_1']*31)/90;
					
					$res['Total'] = ($res['Q2']+$res['Q3']+$res['Q4']+$res['Q5'])/4;
					
					break;
				case 'Budget':
				case 'Budget_AM':
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
					$res['Total'] = $res[$this->arrPeriod[12+$this->offset]];
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
		$this->flagUpdate = !$flag;
		$sql = "UPDATE tbl_scenario SET scnFlagReadOnly=".(integer)$flag.", scnEditBy='{$arrUsrData['usrID']}', scnEditDate=NOW() WHERE scnID='{$this->id}'";
		$this->oSQL->q($sql);
	
	}
	
	function archive($flag = true){
		
		GLOBAL $arrUsrData;
		$this->flagArchive = $flag;
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
		$arrSelect['0'] = "--- All ---";
		$arrSelect['no_h'] = "--- No hierarchy ---";
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
	
	////////////-----------to finalize snippets
	function syncCustomerSales($cntID){
		$sql = "UPDATE reg_master,	common_db.tbl_counterparty 
				SET sales = UCASE( cntUserID ) 
				WHERE cntID = customer AND scenario IN ('{$this->id}','{$this->reference_scenario->id}') 
					AND customer ={$cntID}";
	}
	
	function setAsDefault(){
		GLOBAL $oSQL, $arrUsrData;
		if (strpos($this->type,'Budget')!==false){
			$oSQL->q("UPDATE tbl_setup SET stpCharValue='{$this->id}' 
					,stpEditBy='{$arrUsrData['usrID']}', stpEditDate=NOW()
				WHERE stpVarName='stpScenarioID'");
		} else {
			$oSQL->q("UPDATE tbl_setup SET stpCharValue='{$this->id}' 
					,stpEditBy='{$arrUsrData['usrID']}', stpEditDate=NOW()
				WHERE stpVarName='stpFYEID'");
		}
		return (true);
	}
	
	function delete(){
		GLOBAL $oSQL;
		$sql = "SELECT entPrefix, entTable, entRegister FROM stbl_entity";
		$rs = $oSQL->q($sql);
		
		$sqlAction = Array();
		$sqlAction[] = "DELETE FROM tbl_scenario_variable WHERE scvScenarioID='{$this->id}';";
		$sqlAction[] = "DELETE FROM reg_master WHERE scenario='{$this->id}';";
		$sqlAction[] = "DELETE FROM reg_profit_ghq WHERE scenario='{$this->id}';";
		
		
		while ($rw = $oSQL->f($rs)){
			$sqlAction[] = "DELETE FROM `{$rw['entTable']}` WHERE `{$rw['entPrefix']}Scenario`='{$this->id}';";
			$sqlAction[] = "DELETE FROM `{$rw['entRegister']}` WHERE `scenario`='{$this->id}';";
		}
		
		$sql = "SELECT guid FROM vw_journal WHERE scenario='{$this->id}';";
		$rs = $oSQL->q($sql);
		while ($rw = $oSQL->f($rs)){
			$sqlAction[] = "DELETE FROM stbl_action_log WHERE aclGUID='{$rw['guid']}';";
		}
		
		$sqlAction[] = "DELETE FROM tbl_scenario WHERE scnID='{$this->id}';";
		
		$sqlAction[] = "COMMIT;";
		
		$success = true;
		$res['id']=$this->id;
		for ($i=0;$i<count($sqlAction);$i++){			
			$res['log'][] = $sqlAction[$i];
			try {
				$success &= $oSQL->q($sqlAction[$i]);
				$res['log'][] = "##Affected rows - ".$oSQL->affected_rows;
			} catch (Exception $e){
				$res['status'] = 'error';
				$res['log'][] = $e->getMessage();
				return ($res);
			}
			
		}
		if ($success) $res['status'] = 'success';
		return ($res);
	}
	
	function write_checksum(){
		$this->oSQL->q("START TRANSACTION");
		$this->oSQL->q("DELETE FROM reg_summary WHERE scenario='{$this->id}'");
		$this->oSQL->q("INSERT INTO reg_summary 
						SELECT company,pc,pccFlagProd,activity,account,item,scenario,SUM(`jan`) AS 'jan',SUM(`feb`) AS 'feb',SUM(`mar`) AS 'mar',SUM(`apr`) AS 'apr',SUM(`may`) AS 'may',SUM(`jun`) AS 'jun',SUM(`jul`) AS 'jul',SUM(`aug`) AS 'aug',SUM(`sep`) AS 'sep',SUM(`oct`) AS 'oct',SUM(`nov`) AS 'nov',SUM(`dec`) AS 'dec',SUM(`jan_1`) AS 'jan_1',SUM(`feb_1`) AS 'feb_1',SUM(`mar_1`) AS 'mar_1'
						FROM reg_master
						LEFT JOIN common_db.tbl_profit ON pccID=pc
						WHERE scenario='{$this->id}'
						GROUP BY company,pc,pccFlagProd,activity,account,item,scenario");
		$this->oSQL->q("UPDATE tbl_scenario SET scnEditDate=NOW(), scnChecksum='".$this->get_checksum()."' WHERE scnID='{$this->id}'");
		$this->oSQL->q("COMMIT");
	}
	
	function get_checksum(){
		$this->oSQL->q("SET SESSION group_concat_max_len = 10000000");
		$this->oSQL->q("SET @@group_concat_max_len = 10000000");
		$sql = "SELECT md5(GROUP_CONCAT(MD5(CONCAT_WS('#',company,pc,activity,customer,account,item,jan,feb,mar,apr,may,jun,jul,aug,sep,oct,nov,`dec`,jan_1,feb_1,mar_1,source,scenario,sales,bdv,customer_group_code)))) 
					FROM reg_master 
					WHERE scenario='{$this->id}'";
		$res = $this->oSQL->get_data($sql);
		return($res);
	}
	
}

?>
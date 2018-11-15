<?php
include_once ('classes/reports.class.php');
include_once ('classes/document.class.php');
include_once ('classes/msf_record.class.php');
include_once ('classes/item.class.php');
include_once ('classes/profit.class.php');

$Items = new Items();

class MSF extends Document{
	
	const MSF_ITEM = '090d883b-5061-11e4-926a-00155d010e0b';
	const REVENUE_ITEM = 'cdce3c68-c8da-4655-879e-cd8ec5d98d95';
	
	function __construct($id=''){
		GLOBAL $strLocal;
		//GLOBAL $arrUsrData;
		
		$this->register = 'reg_msf';
		$this->gridName = 'msf';
		$this->gridClass = 'msf_record';
		$this->table = 'tbl_msf';
		$this->prefix = 'msf';
		
		parent::__construct($id);	

	}
	public function refresh($id){
		
		$sqlWhere = $this->getSqlWhere($id);
		
		$sql = "SELECT ".$this->prefix.".*, `usrTitle` FROM `".$this->table."` ".$this->prefix."
				LEFT JOIN `stbl_user` ON `usrID`=`".$this->prefix."EditBy`
				WHERE $sqlWhere";
		
		parent::refresh($sql);		
				
		$this->total = $this->data[$this->prefix."Total"];
		// $this->item = self::MSF_ITEM;
		$this->item = $this->data[$this->prefix."ItemGUID"];
				
		if($this->GUID){
			$this->subtotal = Array();
			$sql = "SELECT * FROM `".$this->register."` WHERE `source`='".$this->GUID."';";
			$rs = $this->oSQL->q($sql);			
			while($rw = $this->oSQL->f($rs)){
				// print_r($rw);
				$this->records[$this->gridName][$rw['id']] = new msf_record($this->GUID, $this->scenario,  $this->company, $rw['id'], $rw);			
				for($m=1;$m<=15;$m++){
					// $month = strtolower(date('M',mktime(0,0,0,$m,15)));					
					$month = $this->budget->arrPeriod[$m];
					$this->subtotal[$month] += $rw[$month];
				}				
			}		
		}
	}
	
	public function defineEF(){
	
		global $arrUsrData;
		global $budget_scenario;
		global $Items;
		
		parent::defineEF();
		
		$this->Columns[] = Array(
					'title'=>'Item'
					,'field'=>$this->prefix.'ItemGUID'
					,'type'=>'combobox'
					,'sql'=>$Items->getStructuredRef()
					, 'mandatory' => true
					, 'disabled'=>!$this->flagUpdate					
				);
			
		$this->Columns[] =Array(
					'title'=>'Total'
					,'field'=>$this->prefix."Total"
					,'type'=>'money'
					,'mandatory'=>true
					, 'disabled'=>true //!$this->flagUpdate
				);
			
	}
	
	public function defineGrid(){
		
		GLOBAL $Items;
	
		$this->grid->Columns[] = Array(
				'title'=>'PC'
				,'field'=>'pc'
				,'type'=>'combobox'
				,'table'=>'vw_profit'
				,'source'=>'vw_profit'
				,'prefix'=>'pcc'
				,'sql'=>"SELECT pccID as optValue, pccTitle as optText FROM vw_profit"
				, 'mandatory' => true
				, 'disabled'=>false
				, 'default'=>0
				// , 'class'=>'costs_supplier'
			);		

		$this->grid->Columns[] =Array(
			'title'=>'Unit'
			,'field'=>'unit'
			,'type'=>'text'
			,'mandatory'=>true
		);
		
	
		$this->setMonthlyEG('decimal', false);
		
		$this->grid->Columns[] =Array(
			'title'=>'Average'
			,'field'=>'AVG'
			,'type'=>'money'
			,'totals'=>true
			,'disabled'=>true
		);
		
		return ($this->grid);
	}
		
	public function save($mode='update'){
		
		GLOBAL $arrUsrData;
		GLOBAL $Activities;
		GLOBAL $YACT;
		GLOBAL $Items;
		
		$ProfitCenters = new ProfitCenters();
		
		parent::save($mode);			
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if($mode=='update' || $mode=='post'){						
			$this->profit = isset($_POST[$this->prefix.'ProfitID'])?$_POST[$this->prefix.'ProfitID']:$this->profit;
			$this->item = isset($_POST[$this->prefix.'ItemGUID'])?$_POST[$this->prefix.'ItemGUID']:$this->item;
			
			$sql = "SELECT SUM(".$this->budget->getYTDSQL(1,15).") as Total, ".$this->budget->getMonthlySumSQL(1,15)." 
						FROM reg_master 
						WHERE active=1 AND scenario='{$this->scenario}' AND pc={$this->profit} AND source NOT IN ('Estimate')";
			$rs = $this->oSQL->q($sql);	
			$total = $this->oSQL->f($rs);
			
			$this->total = -$total['Total'];
		}
		//-------------------Updating grid records---------------------------------
		$arrUpdated = $_POST['inp_'.$this->gridName.'_updated'];
		if(is_array($arrUpdated)){
			$nRows = count($_POST['inp_'.$this->gridName.'_updated']);
			for($id=1;$id<$nRows;$id++){		

				$row = $this->get_record($_POST['id'][$id]);					

				if ($row){
					if ($arrUpdated[$id]){				
						$row->flagUpdated = true;				
						$row->pc = isset($_POST['pc'][$id]) ? $_POST['pc'][$id] : $this->profit;						
						$row->unit = $_POST['unit'][$id];	
						for ($m=1;$m<=15;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];	
							$row->{$month} = (double)$_POST[strtolower($month)][$id];
						}
					} else {
						$row->flagUpdated = false;
					}
				}
			}	
		}
		
		$this->deleteGridRecords();
		
		$settings = Budget::getSettings($this->oSQL,$this->scenario);
		// echo '<pre>';print_r($settings);echo '</pre>';			
		
		$sql = Array();
		$sql[] = "SET AUTOCOMMIT = 0;";
		$sql[] = "START TRANSACTION;";
		if ($mode!='new'){
			$sql[] = "UPDATE `".$this->table."` 
							SET ".$this->prefix."ProfitID=".$this->profit."
							,".$this->prefix."ItemGUID=".$this->oSQL->e($this->item)."						
							,".$this->prefix."Total=".(double)$this->total."						
							,".$this->prefix."Comment=".$this->oSQL->e($this->comment)."
							,".$this->prefix."Scenario='".$this->scenario."'
							,".$this->prefix."EditBy='".$arrUsrData['usrID']."'
							,".$this->prefix."EditDate=NOW()
							WHERE ".$this->prefix."ID={$this->ID};";
		}
		if(is_array($this->records[$this->gridName])){			
			foreach ($this->records[$this->gridName] as $i=>$row){				
				if ($row->flagUpdated || $row->flagDeleted){
					$sql[] = $row->getSQLstring();
				}
			}
		};
		
		$sql[] = "SET AUTOCOMMIT = 1;";
		$sql[] = 'COMMIT;';				
		//echo '<pre>';print_r($sql);echo '</pre>';die();
		$sqlSuccess = $this->doSQL($sql);
				
		if($mode=='post'){
			
			//$this->oSQL->startProfiling();
		
			$this->refresh($this->ID);//echo '<pre>',print_r($this->data);echo '</pre>';
			$oMaster = new Master($this->scenario, $this->GUID, $this->company);
			// print_r($this->subtotal);
			if(is_array($this->records[$this->gridName])){
					//-------------- Get activity distribution for every PC ---------------
					$sql = "SELECT pc, activity, ".$this->budget->getMonthlySumSQL(1,15)."
							FROM reg_master							
							WHERE account IN ('J00400','J40010')
							AND scenario =  '{$this->scenario}' AND company='{$this->company}' AND source NOT IN ('Estimate')
							GROUP BY pc, activity";
					$rs = $this->oSQL->q($sql);
					while ($rw = $this->oSQL->f($rs)){
						for($m=1;$m<=15;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];
							$arrDistribution[$rw['pc']][$rw['activity']][$month] = $rw[$month];
							$arrPCSubtotal[$rw['pc']][$month] += $rw[$month];
						}						
					}
					
					//-------------- Get all costs for donor unit ---------------
					$sql = "SELECT account, activity, item, SUM(".$this->budget->getYTDSQL(1,15).") as Total, ".$this->budget->getMonthlySumSQL(1,15)." 
						FROM reg_master 
						WHERE scenario='{$this->scenario}' AND company='{$this->company}' AND pc={$this->profit} AND source NOT IN ('Estimate')
						GROUP BY account, activity, item"; 
					 
					$rs = $this->oSQL->q($sql);
					while ($rw = $this->oSQL->f($rs)){		
						for($m=1;$m<=15;$m++){
							$month = $this->budget->arrPeriod[$m];					
							if ($rw[$month]!=0){
								$arrAccounts[$rw['account']][$rw['item']][$month] += $rw[$month];
								//----------- Distribute SG&A costs in place ------------------------------
								if(strpos($rw['account'],'5')===0 && $rw['account']!='527000'){
									$arrSource[$rw['account']][$rw['activity']][$rw['item']][$month] += $rw[$month];								
								}
							}
						}
					}					
					 // echo '<pre>';print_r($arrAccounts);echo '</pre>'; die();
					// echo '<pre>';print_r($arrDistribution);echo '</pre>';die();
					
					foreach($this->records[$this->gridName] as $id=>$record){
						if(is_array($arrDistribution[$record->pc])){ //////////////////////////////// For Business unit with revenue and activity distribution base
							foreach ($arrDistribution[$record->pc] as $activity=>$values){
								foreach ($arrAccounts as $account=>$arrItems){
									foreach($arrItems as $item_code=>$item_values){									
										$master_row = $oMaster->add_master();
										$master_row->profit = $record->pc;
										$master_row->bdv = $this->profit;
										$master_row->activity = $activity;
										if (strpos($account,'6')===0 || $account=='527000'){
											$item = $Items->getById($item_code); 
											$master_row->item = $item_code; //Distribute non-operating costs and MSF in place
										} else {
											$item = $Items->getById($this->item); 
											$master_row->item = $this->item; //Collect all other items into corporate cost total
										}
										$master_row->account = $item->getYACT($record->pc);									
										
										for($m=1;$m<=15;$m++){										
											$month = $this->budget->arrPeriod[$m];										
											if ($record->{$month}){
												if ($arrPCSubtotal[$record->pc][$month]) {
												$master_row->{$month} = round(
																			$record->{$month}/$this->subtotal[strtolower($month)]
																			*$item_values[$month]															
																			*($values[$month]/$arrPCSubtotal[$record->pc][$month])
																		,2);
												} else {
													$master_row->{$month} = 0;
												}
												
												$arrDestination[$account][$master_row->activity][$item_code][$month] += $master_row->{$month};
												
											}									
										}				
									}
								}
							}	
						} else { //////////////////////////////// For Business unit without revenue and activity distribution base
							foreach ($arrAccounts as $account=>$arrItems){
								foreach($arrItems as $item_code=>$item_values){									
									$master_row = $oMaster->add_master();
									$master_row->profit = $record->pc;									
									$master_row->bdv = $this->profit;									
									$oProfit = $ProfitCenters->getById($record->pc);
									$master_row->activity = $oProfit->activity;									
									if (strpos($account,'6')===0 || $account=='527000'){
										$item = $Items->getById($item_code);
										$master_row->item = $item_code;
									} else {
										$item = $Items->getById($this->item);
										$master_row->item = $this->item;
									}									
									$master_row->account = $item->getYACT($record->pc);																		
									for($m=1;$m<=15;$m++){										
										$month = $this->budget->arrPeriod[$m];										
										if ($record->{$month}){											
											$master_row->{$month} = round(
																		$record->{$month}/$this->subtotal[strtolower($month)]
																		*$item_values[$month]
																	,2);

											$arrDestination[$account][$master_row->activity][$item_code] += $master_row->{$month};
										}									
									}				
								}
							}
						}
						//echo $id,"\r\n";
					}
					
				// echo '<pre>';print_r($arrAccounts); echo '</pre>';
				
				foreach ($arrAccounts as $account=>$arrItems){	
					foreach($arrItems as $item_code=>$item_values){
						$master_row = $oMaster->add_master();
						$master_row->profit = $this->profit;
						if (strpos($account,'6')===0 || $account=='527000'){
							$item = $Items->getById($item_code);
							$master_row->item = $item_code;
						} else {
							$item = $Items->getById($this->item);
							$master_row->item = $this->item;
						}	
						
						$master_row->account = $item->getYACT($this->profit);
						for($m=1;$m<=15;$m++){							
							$month = $this->budget->arrPeriod[$m];							
							$master_row->{$month} = -$item_values[$month];
						}
					}
					
					if(is_array($arrSource[$account])){
						foreach ($arrSource[$account] as $activity=>$arrItem){
							foreach ($arrItem as $item=>$item_values){
								$master_row = $oMaster->add_master();
								$master_row->profit = $this->profit;														
								$master_row->item = $item_code;						
								$master_row->account = $account;
								$master_row->activity = $activity;
								for($m=1;$m<=15;$m++){							
									$month = $this->budget->arrPeriod[$m];							
									$master_row->{$month} = -$item_values[$month];
								}
								// echo '<pre>',$account; print_r($master_row);echo '</pre>\r\n';
							}
						}
						foreach ($arrDestination[$account] as $activity=>$arrItem){
							foreach ($arrItem as $item=>$item_values){
								$master_row = $oMaster->add_master();
								$master_row->profit = $this->profit;														
								$master_row->item = $item_code;						
								$master_row->account = $account;
								$master_row->activity = $activity;
								for($m=1;$m<=15;$m++){							
									$month = $this->budget->arrPeriod[$m];							
									$master_row->{$month} = $item_values[$month];
								}
							}
						}
					}
				}
										
				
				$oMaster->save(true);//Save into actual periods				
				$this->markPosted();
			}
		
		// $this->oSQL->showProfileInfo();
		
		}		
		
		return($sqlSuccess);
				
	}
	
	public function fill_distribution($oBudget,$type='sqm',$params=Array()){
		GLOBAL $company;
		
		if (is_array($this->records[$this->gridName])){
			foreach($this->records[$this->gridName] as $id=>$record){
				$record->flagDeleted = true;
			}
		}
		
		switch ($type) {
			case 'fte':
				$sql = "SELECT 'FTE' as unit, pc, ".$this->budget->getMonthlySumSQL(1,15)." FROM reg_headcount
						LEFT JOIN vw_profit ON pccID=pc
						WHERE scenario='".$oBudget->id."' 
							AND posted=1 
							AND pc<>'{$this->profit}'
							AND pccFlagProd=1
							##AND company='{$this->company}'
						GROUP BY pc"; 
			break;
			case 'sales':
				$sql = "SELECT 'RUB' as unit, pc, ".$this->budget->getMonthlySumSQL(1,15, null, 1000)." FROM reg_master
						LEFT JOIN vw_profit ON pccID=pc
						WHERE scenario='".$oBudget->id."' 
							AND active=1 
							AND pc<>'{$this->profit}'
							AND pccFlagProd=1 AND pc<>99
							AND account='J00400'
							##AND company='{$this->company}'
						GROUP BY pc"; 
			break;
			case 'net_sales':
				$sql = "SELECT 'RUB' as unit, pc, ".$this->budget->getMonthlySumSQL(1,15, null, 1000)." FROM reg_master
						LEFT JOIN vw_profit ON pccID=pc
						WHERE scenario='".$oBudget->id."' 
							AND active=1 
							AND pc NOT IN ('{$this->profit}',99)
							AND pccFlagProd=1							
							".Reports::REVENUE_FILTER."
							##AND company='{$this->company}'
						GROUP BY pc"; 
			break;
			case 'users':
				$sql = "SELECT pc, wc, 'user' as unit, ".$this->budget->getMonthlySumSQL(1,15)." FROM reg_headcount
					LEFT JOIN vw_profit ON pccID=pc				
					WHERE scenario='".$oBudget->id."' 
						AND posted=1 AND wc=1 AND salary>10000
						AND pccFlagProd=1 AND pc<>99
						##AND company='{$this->company}'
						GROUP BY pc";
				break;
			default:
				return (false);
			break;
		}
			
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$row = $this->add_record();
			$row->flagUpdated = true;				
			$row->unit = $rw['unit'];
			$row->pc = $rw['pc'];			
			for ($m=1;$m<=15;$m++){
				// $month = date('M',mktime(0,0,0,$m,15));							
				$month = $this->budget->arrPeriod[$m];
				$row->set_month_value($m, $rw[$month]);
				$arrSubtotal[$month] += $rw[$month];
				$arrSum[$month] = $this->total - $arrSubtotal[$month];
			}
		}
		return($sql); 
	}
	
}

?>


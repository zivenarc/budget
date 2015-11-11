<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('classes/msf_record.class.php');
include_once ('classes/item.class.php');

$Items = new Items();

class MSF extends Document{
	
	const MSF_ITEM = '090d883b-5061-11e4-926a-00155d010e0b';
	
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
				$this->records[$this->gridName][$rw['id']] = new msf_record($this->GUID, $this->scenario, $rw['id'], $rw);			
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
	
		$grid = new eiseGrid($this->oSQL
                    ,$this->gridName
                    , Array(
                            'flagKeepLastRow' => false
                            , 'arrPermissions' => Array("FlagWrite" => !$this->flagPosted)
                            , 'flagStandAlone' => true
							, 'controlBarButtons' => "add|delete"
                            )
                    );
		$grid->Columns[]=Array(
			'field'=>"id"
			,'type'=>'row_id'
		);
		
		$grid->Columns[] = Array(
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

		$grid->Columns[] =Array(
			'title'=>'Unit'
			,'field'=>'unit'
			,'type'=>'text'
			,'mandatory'=>true
		);
		
	
		for ($m=1;$m<=$this->budget->length;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));
			$month = $this->budget->arrPeriod[$m];			
			$grid->Columns[] = Array(
			'title'=>ucfirst($month)
			,'field'=>strtolower($month)
			,'class'=>'budget-month'
			,'type'=>'money'
			, 'mandatory' => true
			, 'disabled'=>!$this->flagUpdate
			,'totals'=>true
		);
		}
		$grid->Columns[] =Array(
			'title'=>'Total'
			,'field'=>'YTD'
			,'type'=>'money'
			,'totals'=>true
			,'disabled'=>true
		);
		
		$this->grid = $grid;
		return ($grid);
	}
		
	public function save($mode='update'){
		
		GLOBAL $arrUsrData;
		GLOBAL $Activities;
		GLOBAL $YACT;
		GLOBAL $Items;
		
		parent::save($mode);			
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if($mode=='update' || $mode=='post'){						
			$this->profit = isset($_POST[$this->prefix.'ProfitID'])?$_POST[$this->prefix.'ProfitID']:$this->profit;
			$this->item = isset($_POST[$this->prefix.'ItemGUID'])?$_POST[$this->prefix.'ItemGUID']:$this->item;
			
			$sql = "SELECT SUM(".$this->budget->getYTDSQL().") as Total, ".$this->budget->getMonthlySumSQL()." 
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
						for ($m=1;$m<=$this->budget->length;$m++){
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
			$oMaster = new Master($this->scenario, $this->GUID);
			// print_r($this->subtotal);
			if(is_array($this->records[$this->gridName])){
					// echo '<pre>';print_r($this->records[$this->gridName]);echo '</pre>';die();					
					$sql = "SELECT pc, activity, ".$this->budget->getMonthlySumSQL()."
							FROM reg_master							
							WHERE account='J00400'
							AND scenario =  '{$this->scenario}' AND source NOT IN ('Estimate')
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
					
					$sql = "SELECT account, item, SUM(".$this->budget->getYTDSQL().") as Total, ".$this->budget->getMonthlySumSQL()." 
						FROM reg_master 
						WHERE active=1 AND scenario='{$this->scenario}' AND pc={$this->profit} AND source NOT IN ('Estimate')
						GROUP BY account, item"; 
					 
					$rs = $this->oSQL->q($sql);
					while ($rw = $this->oSQL->f($rs)){
					
						if(strpos($rw['account'],'6')===0){
							$item = $rw['item'];
						} else {
							$item = $this->item;							
						}
						for($m=1;$m<=15;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];
							
							if ($rw[$month]!=0){
								$arrAccounts[$item][$month] += $rw[$month];
							}
						}
					}					
					// echo '<pre>';print_r($arrAccounts);echo '</pre>';
					// echo '<pre>';print_r($arrDistribution);echo '</pre>';die();
					
					foreach($this->records[$this->gridName] as $id=>$record){						
						foreach ($arrDistribution[$record->pc] as $activity=>$values){							
							foreach($arrAccounts as $item_code=>$item_values){
								// echo '<pre>',$item_code,"\r\n";print_r($item_values);echo '</pre>';
								$master_row = $oMaster->add_master();
								$master_row->profit = $record->pc;
								$master_row->activity = $activity;
								// $master_row->customer = $record->customer;					
								//$item = $Items->getById($this->item);
								$item = $Items->getById($item_code);
								// echo '<pre>';print_r($item);echo '<pre>';
								$master_row->account = $item->getYACT($record->pc);
								// $master_row->item = $this->item;
								$master_row->item = $item_code;
								for($m=1;$m<=15;$m++){
									$month = date('M',mktime(0,0,0,$m,15));
									$month = $this->budget->arrPeriod[$m];
									// $master_row->{$month} = $record->{$month}/$this->subtotal[strtolower($month)]
															// *$total[$month]															
															// *($values[$month]/$arrPCSubtotal[$record->pc][$month]);	
									$master_row->{$month} = round(
																$record->{$month}/$this->subtotal[strtolower($month)]
																*$item_values[$month]															
																*($values[$month]/$arrPCSubtotal[$record->pc][$month])
															,2);
																		
								}				
														
								// echo '<pre>';print_r($master_row);echo '</pre>';
							}																					
						}						
						//echo $id,"\r\n";
					}
					
					
					
					foreach($arrAccounts as $item_code=>$item_values){
						$master_row = $oMaster->add_master();
						$master_row->profit = $this->profit;
						// $master_row->activity = $total['activity'];
						// $master_row->customer = self::EMPTY_CUSTOMER;					
						//$item = $Items->getById($this->item);
						$item = $Items->getById($item_code);
						$master_row->account = $item->getYACT($this->profit);
						// $master_row->item = $this->item;
						$master_row->item = $item_code;
						for($m=1;$m<=15;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];
							//$master_row->{$month} = -$total[$month];
							$master_row->{$month} = -$item_values[$month];
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
						GROUP BY pc"; 
			break;
			case 'users':
				$sql = "SELECT pc, wc, 'user' as unit, ".$this->budget->getMonthlySumSQL(1,15)." FROM reg_headcount
					LEFT JOIN vw_profit ON pccID=pc				
					WHERE scenario='".$oBudget->id."' 
						AND posted=1 AND wc=1 
						AND pccFlagProd=1 AND pc<>99
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
			for ($m=1;$m<=$this->budget->length;$m++){
				// $month = date('M',mktime(0,0,0,$m,15));							
				$month = $this->budget->arrPeriod[$m];
				$row->set_month_value($m, $rw[$month]);
				$arrSubtotal[$month] += $rw[$month];
				$arrSum[$month] = $this->total - $arrSubtotal[$month];
			}
		}
		//die($sql); 
	}
	
}

?>


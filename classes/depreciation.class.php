<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('classes/depreciation_record.class.php');
include_once ('classes/yact_coa.class.php');
include_once ('classes/item.class.php');
include_once ('classes/product.class.php');
include_once ('classes/fixedassets.class.php');

//$Activities = new Activities ();
$YACT = new YACT_COA();
$Items = new Items();
$FixedAssets = new FixedAssets();

class Depreciation extends Document{
	
	const PROPERTY_TAX = 0.022;

	// const Register='reg_depreciation';
	// const GridName = 'depreciation';
	// const Prefix = 'dep';
	// const Table = 'tbl_depreciation';	
	
	function __construct($id='',$type='current'){
		GLOBAL $strLocal;
		//GLOBAL $arrUsrData;
		
		
		$this->register = 'reg_depreciation';
		
		if ($type=='new'){
			$this->gridName = 'investment';
			$this->table = 'tbl_investment';
			$this->prefix = 'inv';
		} else {
			$this->gridName = 'depreciation';
			$this->table = 'tbl_depreciation';
			$this->prefix = 'dep';
		}
		
		// $this->gridClass = 'depreciation_record';
		
		$this->type=$type;
		
		parent::__construct($id);	
		$this->gridClass = 'depreciation_record';

	}
	public function refresh($id){
		
		$sqlWhere = $this->getSqlWhere($id);
		
		$sql = "SELECT ".$this->prefix.".*, `usrTitle` FROM `".$this->table."` ".$this->prefix."
				LEFT JOIN `stbl_user` ON `usrID`=`".$this->prefix."EditBy`
				WHERE $sqlWhere";
		
		parent::refresh($sql);
		
		$this->disposal_date = strtotime($this->data[$this->prefix."DisposalDate"]);
		$this->disposal_value = $this->data[$this->prefix."DisposalValue"];
		
		if($this->GUID){
			$sql = "SELECT * FROM `".$this->register."` WHERE `source`='".$this->GUID."';";
			$rs = $this->oSQL->q($sql);			
			while($rw = $this->oSQL->f($rs)){
				$this->records[$this->gridName][$rw['id']] = new depreciation_record($this->GUID, $this->scenario, $rw['id'], $rw);
			}		
		}
	}
	
	public function defineEF(){
	
		global $arrUsrData;
		global $budget_scenario;
		global $Items;
		
		parent::defineEF();
		
		if ($this->type=='current'){
			$this->Columns[] = Array(
						'title'=>'Disposal date'
						,'field'=>$this->prefix.'DisposalDate'
						,'type'=>'date'					
						, 'mandatory' => false
						, 'disabled'=>!$this->flagUpdate
					);
			
			$this->Columns[] =Array(
						'title'=>'Disposal value'
						,'field'=>$this->prefix."DisposalValue"
						,'type'=>'money'
						,'mandatory'=> false
						, 'disabled'=>!$this->flagUpdate
					);
		}
			
	}

	public function defineGrid(){
		
		GLOBAL $Items;
		GLOBAL $FixedAssets;
		
		$grid = new eiseGrid($this->oSQL
                    ,$this->gridName
                    , Array(
                            'flagKeepLastRow' => false
                            , 'arrPermissions' => Array("FlagWrite" => !$this->flagPosted)
                            , 'flagStandAlone' => true
							, 'controlBarButtons' => "add"
                            )
                    );
		$grid->Columns[]=Array(
			'field'=>"id"
			,'type'=>'row_id'
		);
		
		if ($this->type=='current'){
			$grid->Columns[] = Array(
				'title'=>'Code'
				,'field'=>'fixID'
				,'type'=>'text'
				, 'disabled'=>true
			);	
			
			$grid->Columns[] = Array(
				'title'=>'Asset'
				,'field'=>'particulars'
				,'type'=>'combobox'
				,'arrValues'=>$FixedAssets->getStructuredRef()
				, 'mandatory' => true
				, 'disabled'=>true
			);		
		};
		
		$grid->Columns[] = Array(
			'title'=>'Description'
			,'field'=>'comment'
			,'type'=>'text'
			,'width'=>'auto'
			, 'disabled'=>false
		);
		
		$grid->Columns[] = Array(
			'title'=>'Item'
			,'field'=>'item'
			,'type'=>'combobox'
			,'arrValues'=>($this->type=='current'?$Items->getStructuredRef():Array(
																		Items::DEPRECIATION=>'Depreciation',																		
																		Items::IT_EQUIPMENT=>'IT Equipment',
																		Items::MOBILE=>'Mobile phones'
																		))
			, 'mandatory' => true
			, 'disabled'=>$this->type=='current'
			, 'default'=>Items::DEPRECIATION
		);
		
		$grid->Columns[] = parent::getActivityEG();
		
		$grid->Columns[] =Array(
			'title'=>'Initial value'
			,'field'=>'value_start'
			,'type'=>'money'
			,'disabled'=>$this->type=='current'
			,'totals'=>true
		);
		
		if ($this->type=='new'){
			$grid->Columns[] =Array(
				'title'=>'Count'
				,'field'=>'count'
				,'type'=>'integer'
				,'disabled'=>false
				,'totals'=>true
			);
		}
		
		
		$grid->Columns[] =Array(
			'title'=>'Value Jan'
			,'field'=>'value_primo'
			,'type'=>'money'
			,'disabled'=>true
			,'totals'=>true
		);
		
		$grid->Columns[] =Array(
			'title'=>'Value Dec'
			,'field'=>'value_ultimo'
			,'type'=>'money'
			,'disabled'=>true
			,'totals'=>true
		);
		
		
		
		$grid->Columns[] =Array(
			'title'=>'Start date'
			,'field'=>'date_start'
			,'type'=>'date'
			,'mandatory'=>true
			,'disabled'=>$this->type=='current'
		);
		
		$grid->Columns[] =Array(
			'title'=>'End date'
			,'field'=>'date_end'
			,'type'=>'date'
			,'mandatory'=>true
			,'disabled'=>$this->type=='current'
		);
		
		$grid->Columns[] =Array(
			'title'=>'Duration'
			,'field'=>'duration'
			,'type'=>'int'
			,'mandatory'=>true
			
		);
		
		

		
		for ($m=1;$m<13;$m++){
			$month = $this->budget->arrPeriod[$m];
					
			$grid->Columns[] = Array(
			'title'=>''//hidden
			,'field'=>strtolower($month)
			,'class'=>'budget-month'
			,'type'=>'decimal'
			, 'mandatory' => true
			, 'disabled'=>true//
			,'totals'=>true
		);
		}
		$grid->Columns[] =Array(
			'title'=>'Total'
			,'field'=>'YTD'
			,'type'=>'decimal'
			,'totals'=>true
			,'disabled'=>true
		);
		
		$this->grid = $grid;
		return ($grid);
	}
	
	public function fillGrid(){
		parent::fillGrid($this->grid, Array('fixID'),'reg_depreciation LEFT JOIN vw_fixed_assets ON fixGUID=particulars');
	}
	
	public function save($mode='update'){
		
		GLOBAL $arrUsrData;
			
		parent::save($mode);
		
		$budget_year_start = time(0,0,0,1,1,$this->budget->year);
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if ($mode=='update' || $mode=='post'){
			$this->profit = isset($_POST[$this->prefix.'ProfitID'])?$_POST[$this->prefix.'ProfitID']:$this->profit;			
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
						$row->profit = $this->profit;
						$row->item = $_POST['item'][$id];						
						$row->particulars = $_POST['particulars'][$id];									
						$row->count = $_POST['count'][$id];									
						$row->activity = $_POST['activity'][$id];	
							$date_start = strtotime($_POST['date_start'][$id]);
						$row->date_start = date('Y-m-d',$date_start);
							$date_end = strtotime($_POST['date_end'][$id]);
						$row->date_end = date('Y-m-d',$date_end);				
						$row->value_start = (double)str_replace(',','',$_POST['value_start'][$id]);
						
						if($this->type=='new'){
							if($date_start>$budget_year_start){
								$row->value_primo = 0;
							} else {
								$row->value_primo = $row->value_start;
							}
							
							$row->periodStart = date(strtotime($row->date_start));
							$row->periodEnd = date(strtotime($row->date_end));								
							$row->duration = floor(($row->periodEnd - $row->periodStart)/60/60/24/30);
							
						} else {
							$row->duration = $_POST['duration'][$id];
							$row->value_primo = (double)str_replace(',','',$_POST['value_primo'][$id]);				
							$row->value_ultimo = (double)str_replace(',','',$_POST['value_ultimo'][$id]);	
						}
						
						
						$row->comment = $_POST['comment'][$id];				
						for ($m=1;$m<=15;$m++){
							$month = $this->budget->arrPeriod[$m];
							$current_month_start = mktime(0,0,0,$m,1,$this->budget->year);
							if ($this->type=='current'){
								$row->{$month} = (integer)$_POST[strtolower($month)][$id];
							} else {
								if($date_start>$current_month_start){
									$row->{$month} = 0;
								} else {
									// $hc = $_POST['new_fte'][$id]*(date('t',$current_month_start)-date('j',$start_date))/date('t',$current_month_start);							 
									$row->{$month} = $row->count;//(integer)$_POST['new_fte'][$id];
									$row->depreciation_months ++;
								} 
								$row->value_ultimo = $row->value_start*(1-$row->depreciation_months/$row->duration);
							}
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
		// $sql[] = "UPDATE `".$this->table."` 
				// SET ".$this->prefix."ProfitID=".(integer)$this->profit."				
				// ,".$this->prefix."Comment=".$this->oSQL->e($this->comment)."
				// ,".$this->prefix."Scenario='".$this->scenario."'
				// ,".$this->prefix."EditBy='".$arrUsrData['usrID']."'
				// ,".$this->prefix."EditDate=NOW()
				// WHERE ".$this->prefix."ID={$this->ID};";
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
			$this->post();			
		}
		
		return($sqlSuccess);
				
	}
	
	public function fill_replacement($oBudget){
		
		if (is_array($this->records[$this->gridName])){
			foreach($this->records[$this->gridName] as $id=>$record){
				$record->flagDeleted = true;
			}
		}
		
		$dateReplacementStart = ($oBudget->year-1).'-12-01';
		$dateReplacementEnd = $oBudget->year.'-12-01';
		
		$sql = "SELECT *, PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetStart}'), EXTRACT(YEAR_MONTH FROM fixDeprStart)) AS months,
				fixValueStart*(1-PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetStart}'), EXTRACT(YEAR_MONTH FROM fixDeprStart))/fixDeprDuration) as fixValuePrimo,
				fixValueStart*(1-PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '{$dateBudgetEnd}'), EXTRACT(YEAR_MONTH FROM fixDeprStart))/fixDeprDuration) as fixValueUltimo
				FROM vw_fixed_assets 
				LEFT JOIN vw_item ON itmID=fixItemID
				WHERE fixProfitID=".$this->profit." AND DATEDIFF(fixDeprEnd,'{$dateReplacementStart}')>0 AND DATEDIFF(fixDeprEnd,'{$dateReplacementEnd}')<0 AND fixFlagDeleted=0
				ORDER BY fixItemID";//die($sql);
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$row = $this->add_record();
			$row->flagUpdated = true;				
			$row->replace = true;				
			$row->profit = $this->profit;
			$row->particulars = $rw['fixGUID'];				
			$row->item = $rw['itmGUID'];				
			$row->duration = $rw['fixDeprDuration'];				
			$row->activity = $rw['fixProductTypeID'];				
			$row->date_start = $rw['fixDeprEnd'];				
			$row->date_end = date('Y-m-d',strtotime($rw['fixDeprEnd'])+24*60*60*30*$rw['fixDeprDuration']);
			$row->value_start = (double)$rw['fixValueStart'];				
			$row->value_primo = (double)$rw['fixValuePrimo'];				
			$row->value_ultimo = max(0,(double)$rw['fixValueUltimo']);				
			$row->count = 1;				
			
			$arrDescr = null;
			if ($rw['fixPlateNo']) $arrDescr[] = $rw['fixPlateNo'];
			if ($rw['fixVIN']) $arrDescr[] = $rw['fixVIN'];
			$row->comment = "Replacement: [".trim($rw['fixID'])."] ".$rw['fixTitleLocal']." ".(is_array($arrDescr)?implode('|',$arrDescr):'');				
			
			$dateEnd = strtotime($row->date_end);
			$dateStart = strtotime($row->date_start);
			
			for($m=1;$m<13;$m++){
				$month = $this->budget->arrPeriod[$m];
				$bom = mktime(0,0,0,$m,1, $oBudget->year);
				if ($dateStart<$bom){
					$row->{$month} = 1;
				} else {
					$row->{$month} = 0;
				}
			}
			
		}
	}
	
	function post(){
	
		GLOBAL $Activities;
		GLOBAL $YACT;
		GLOBAL $Items;
		
		$this->refresh($this->ID);//echo '<pre>',print_r($this->data);echo '</pre>';
			$oMaster = new Master($this->scenario, $this->GUID);
					
			if(is_array($this->records[$this->gridName])){
				
				$residual_value = Array();
				
				foreach($this->records[$this->gridName] as $id=>$record){

						$master_row = $oMaster->add_master(); //-----------------------Depreciation
						$master_row->profit = $this->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;										
						$master_row->particulars = $record->particulars;										
						$master_row->part_type = 'FIX';	
						
						if ($record->duration) {
							$monthly_depr = $record->value_start/$record->duration;
						} else {
							$monthly_depr = 0;
						}
						
						$record->periodStart = date(strtotime($record->date_start));
						$record->periodEnd = date(strtotime($record->date_end));
						
						$item = $Items->getById($record->item);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $record->item;
						
						if ($this->disposal_date){
							$disposal_month = date('Ym', $this->disposal_date) - date('Ym',$this->budget->date_start)+1;
						} else {
							$disposal_month = 15;
						}
						
						for($m=1;$m <= $disposal_month;$m++){
							$month = $this->budget->arrPeriod[$m];
							$master_row->{$month} = -$record->{$month}*$monthly_depr;
							
							switch ($this->type){
								case 'current':
									$residual_value[$m] += max(0,$record->value_primo - $monthly_depr*$m);
									break;
								case 'new':
									$period = date(mktime(0,0,0,$m,15)); 
									$months_elapsed = floor(($period-$record->periodStart)/86400/30);
									$residual_value[$m] += max(0,$record->value_start - $monthly_depr*$months_elapsed);
									break;
							}
							
						}				
															
						//echo '<pre>';print_r($master_row);echo '</pre>';
	
				}
												
				$master_row = $oMaster->add_master();//------------------------ Property tax
				$master_row->profit = $this->profit;
				$master_row->activity = $record->activity;
				$master_row->customer = $record->customer;										
				
				$item = $Items->getById(Items::PROPERTY_TAX);
				$master_row->account = $item->getYACT($master_row->profit);
				$master_row->item = Items::PROPERTY_TAX;
				
				for($m=1;$m <= $disposal_month;$m++){
					$month = $this->budget->arrPeriod[$m];
					$master_row->{$month} = -self::PROPERTY_TAX*$record->{$month}*$residual_value[$m]/12;
				}
				
				if ($this->disposal_date){
					$master_row = $oMaster->add_master();//------------------------ Property tax
					$master_row->profit = $this->profit;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;										
					
					$month = $this->budget->arrPeriod[$disposal_month];
					
					if ($this->disposal_value > $residual_value[$disposal_month]) {
						$master_row->account = YACT_COA::GAIN_ON_SALE;
					} else {
						$master_row->account = YACT_COA::LOSS_ON_SALE;
					}
					$master_row->item = Items::GAIN_ON_SALE;
							
					$master_row->{$month} = $this->disposal_value - $residual_value[$disposal_month];
					
				}
				
				$oMaster->save();
				$this->markPosted();
			}
	}
	
}

?>


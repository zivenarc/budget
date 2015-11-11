<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('classes/vehicle_record.class.php');
include_once ('classes/reference.class.php');
include_once ('classes/yact_coa.class.php');
include_once ('classes/item.class.php');
include_once ('classes/product.class.php');
include_once ('classes/fixedassets.class.php');

//$Activities = new Activities ();
$YACT = new YACT_COA();
$Items = new Items();
$FixedAssets = new FixedAssets();

class Vehicle extends Document{
	
	function __construct($id='',$type='current'){
		GLOBAL $strLocal;
		//GLOBAL $arrUsrData;
		
		
		$this->register = 'reg_vehicles';
		
		if ($type=='new'){

		} else {
			$this->gridName = 'vehicle';
			$this->gridClass = 'vehicle_record';
			$this->table = 'tbl_vehicle';
			$this->prefix = 'veh';
		}
		
		$this->type=$type;
		
		parent::__construct($id);	

	}
	public function refresh($id){
		
		$sqlWhere = $this->getSqlWhere($id);
		
		$sql = "SELECT ".$this->prefix.".*, `usrTitle` FROM `".$this->table."` ".$this->prefix."
				LEFT JOIN `stbl_user` ON `usrID`=`".$this->prefix."EditBy`
				WHERE $sqlWhere";
		
		parent::refresh($sql);
		
		foreach ($this->data as $key=>$value){
			$dataField = strtolower(str_replace($this->prefix,'',$key));
			$this->{$dataField} = $value;
		}
			
		if($this->GUID){
			$sql = "SELECT * FROM `".$this->register."` WHERE `source`='".$this->GUID."';";
			$rs = $this->oSQL->q($sql);			
			while($rw = $this->oSQL->f($rs)){
				$this->records[$this->gridName][$rw['id']] = new vehicle_record($this->GUID, $this->scenario, $rw['id'], $rw);
			}		
		}
	}
	
	public function defineEF(){
	
		global $arrUsrData;
			
		parent::defineEF();
		
		$this->Columns[] = Array(
			'title'=>'CASCO rate, %'
			,'field'=>$this->prefix.'CASCO'
			,'type'=>'decimal'
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array(
			'title'=>'OSAGO rate, RUB'
			,'field'=>$this->prefix.'OSAGO'
			,'type'=>'money'
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array(
			'title'=>'Fuel, l/100km'
			,'field'=>$this->prefix.'Consumption'
			,'type'=>'decimal'
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array(
			'title'=>'Fuel price'
			,'field'=>$this->prefix.'FuelPrice'
			,'type'=>'money'
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array(
			'title'=>'Monthly wash cost'
			,'field'=>$this->prefix.'Wash'
			,'type'=>'money'
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array(
			'title'=>'Annual maintenance'
			,'field'=>$this->prefix.'Maintenance'
			,'type'=>'money'
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array(
			'title'=>'Consumables, monthly'
			,'field'=>$this->prefix.'Consumables'
			,'type'=>'money'
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array(
			'title'=>'Power, HP'
			,'field'=>$this->prefix.'Power'
			,'type'=>'integer'
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array(
			'title'=>'Tax rate'
			,'field'=>$this->prefix.'Rate'
			,'type'=>'decimal'
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array(
			'title'=>'Office car'
			,'field'=>$this->prefix.'FlagOffice'
			,'type'=>'checkbox'
			,'disabled'=>!$this->flagUpdate
		);
		

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
				, 'disabled'=>false
			);		
		};
		
		$grid->Columns[] = Array(
			'title'=>'Description'
			,'field'=>'comment'
			,'type'=>'text'
			, 'disabled'=>false
		);
			
		$grid->Columns[] = parent::getActivityEG();
			
		$grid->Columns[] =Array(
			'title'=>'Value Jan'
			,'field'=>'value_primo'
			,'type'=>'money'
			,'disabled'=>false
			,'totals'=>true
		);
				

		
		for ($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
					
			$grid->Columns[] = Array(
			'title'=>$month
			,'field'=>strtolower($month)
			,'class'=>'budget-month'
			,'type'=>'integer'
			, 'mandatory' => true
			, 'disabled'=>!$this->flagUpdate
			,'totals'=>true
		);
		}
		$grid->Columns[] =Array(
			'title'=>'Total'
			,'field'=>'YTD'
			,'type'=>'integer'
			,'totals'=>true
			,'disabled'=>true
		);
		
		$this->grid = $grid;
		return ($grid);
	}
	
	public function fillGrid(){
		parent::fillGrid($this->grid, Array('fixPlateNo','fixVIN'),'reg_vehicles LEFT JOIN vw_fixed_assets ON fixGUID=particulars');
	}
	
	
	public function save($mode='update'){
		
		GLOBAL $arrUsrData;
		GLOBAL $Activities;
		GLOBAL $YACT;
		GLOBAL $Items;
		GLOBAL $oBudget;
		
		$budget_year_start = time(0,0,0,1,1,$oBudget->year);
		
		parent::save($mode);
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if ($mode=='update' || $mode=='post'){
			$this->profit = isset($_POST[$this->prefix.'ProfitID'])?$_POST[$this->prefix.'ProfitID']:$this->profit;			
			$this->casco = isset($_POST[$this->prefix.'CASCO'])?$_POST[$this->prefix.'CASCO']:$this->casco;
			$this->osago = isset($_POST[$this->prefix.'OSAGO'])?$_POST[$this->prefix.'OSAGO']:$this->osago;
			$this->fuelprice = isset($_POST[$this->prefix.'FuelPrice'])?$_POST[$this->prefix.'FuelPrice']:$this->fuelprice;
			$this->consumption = isset($_POST[$this->prefix.'Consumption'])?$_POST[$this->prefix.'Consumption']:$this->consumption;
			$this->wash = isset($_POST[$this->prefix.'Wash'])?$_POST[$this->prefix.'Wash']:$this->wash;
			$this->maintenance = isset($_POST[$this->prefix.'Maintenance'])?$_POST[$this->prefix.'Maintenance']:$this->maintenance;
			$this->consumables = isset($_POST[$this->prefix.'Consumables'])?$_POST[$this->prefix.'Consumables']:$this->consumables;
			$this->flagoffice = isset($_POST[$this->prefix.'FlagOffice'])?(integer)$_POST[$this->prefix.'FlagOffice']:$this->flagoffice;
			$this->power = isset($_POST[$this->prefix.'Power'])?$_POST[$this->prefix.'Power']:$this->power;
			$this->rate = isset($_POST[$this->prefix.'Rate'])?$_POST[$this->prefix.'Rate']:$this->rate;
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
						$row->activity = $_POST['activity'][$id];	
							$date_start = strtotime($_POST['date_start'][$id]);
						$row->date_start = date('Y-m-d',$date_start);
							$date_end = strtotime($_POST['date_end'][$id]);
						$row->date_end = date('Y-m-d',$date_end);				
						$row->value_primo = (double)str_replace(',','',$_POST['value_primo'][$id]);
								
						
						$row->comment = $_POST['comment'][$id];				
						for ($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
								$row->{$month} = (integer)$_POST[strtolower($month)][$id];
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
					SET ".$this->prefix."ProfitID=".(integer)$this->profit."				
					,".$this->prefix."Comment=".$this->oSQL->e($this->comment)."
					,".$this->prefix."Scenario='".$this->scenario."'
					,".$this->prefix."CASCO='".(double)$this->casco."'
					,".$this->prefix."OSAGO='".(double)$this->osago."'
					,".$this->prefix."Consumption='".(double)$this->consumption."'
					,".$this->prefix."FuelPrice='".(double)$this->fuelprice."'
					,".$this->prefix."Wash='".(double)$this->wash."'
					,".$this->prefix."Maintenance='".(double)$this->maintenance."'
					,".$this->prefix."Consumables='".(double)$this->consumables."'
					,".$this->prefix."Power='".(double)$this->power."'
					,".$this->prefix."Rate='".(double)$this->rate."'
					,".$this->prefix."FlagOffice='".$this->flagoffice."'
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
			$this->refresh($this->ID);//echo '<pre>',print_r($this->data);echo '</pre>';
			$oMaster = new Master($this->scenario, $this->GUID);
					
			if(is_array($this->records[$this->gridName])){
				
				$residual_value = Array();
				
				foreach($this->records[$this->gridName] as $id=>$record){

						$master_row = $oMaster->add_master(); //-----------------------Fuel consumption
						$master_row->profit = $this->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;															
						$master_row->particulars = $record->particulars;															
						$item_guid = $this->flagoffice?Items::COMPANY_CARS:Items::FUEL;
						$item = $Items->getById($item_guid);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item_guid;						
						
						for($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$master_row->{$month} = -$record->{$month}*$this->fuelprice*$this->consumption/100;							
							
						}				
															
						$master_row = $oMaster->add_master(); //-----------------------Maintenance
						$master_row->profit = $this->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;															
						$master_row->particulars = $record->particulars;															
						$item_guid = $this->flagoffice?Items::COMPANY_CARS:Items::MAINTENANCE;
						$item = $Items->getById($item_guid);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item_guid;						
						
						for($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$master_row->{$month} = -($record->{$month}?1:0)*
								($this->maintenance/12 + $this->consumables + $this->wash);							
							
						}
						
							
						$master_row = $oMaster->add_master(); //-----------------------INSURANCE
						$master_row->profit = $this->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;															
						$master_row->particulars = $record->particulars;															
						$item_guid = Items::INSURANCE;
						$item = $Items->getById($item_guid);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item_guid;						
						
						for($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$master_row->{$month} = - ($record->value_primo*$this->casco/100 + $this->osago)/12;							
							
						}
						
						$master_row = $oMaster->add_master(); //-----------------------Transportation tax
						$master_row->profit = $this->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;															
						$master_row->particulars = $record->particulars;															
						$item_guid = Items::TRANSPORTATION_TAX;
						$item = $Items->getById($item_guid);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item_guid;						
						
						for($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$master_row->{$month} =	- $this->power*$this->rate/12;															
						}
	
				}				
				
				$oMaster->save();
				$this->markPosted();
			}
		}
		
		return($sqlSuccess);
				
	}
	
}

?>


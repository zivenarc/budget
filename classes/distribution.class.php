<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('classes/distribution_record.class.php');
include_once ('classes/item.class.php');
include_once ('classes/product.class.php');

$Items = new Items();
$Activities = new Activities();

class Distribution extends Document{
	
	const EMPTY_CUSTOMER = 1894;
	
	function __construct($id=''){
		GLOBAL $strLocal;
		//GLOBAL $arrUsrData;
		
		$this->register = 'reg_rent';
		$this->gridName = 'rent';
		$this->gridClass = 'distribution_record';
		$this->table = 'tbl_rent';
		$this->prefix = 'rnt';
		
		parent::__construct($id);	

	}
	public function refresh($id){
		
		$sqlWhere = $this->getSqlWhere($id);
		
		$sql = "SELECT ".$this->prefix.".*, `usrTitle` FROM `".$this->table."` ".$this->prefix."
				LEFT JOIN `stbl_user` ON `usrID`=`".$this->prefix."EditBy`
				WHERE $sqlWhere";
		
		parent::refresh($sql);		
				
		$this->total = $this->data[$this->prefix."Total"];
		$this->item = $this->data[$this->prefix."ItemGUID"];
		$this->activity = $this->data[$this->prefix."ActivityID"];
				
		if($this->GUID){
			$this->subtotal = Array();
			$sql = "SELECT * FROM `".$this->register."` WHERE `source`='".$this->GUID."';";
			$rs = $this->oSQL->q($sql);			
			while($rw = $this->oSQL->f($rs)){
				// print_r($rw);
				$this->records[$this->gridName][$rw['id']] = new distribution_record($this->GUID, $this->scenario, $rw['id'], $rw);			
				for($m=1;$m<=$this->budget->length;$m++){
					$month = $this->budget->arrPeriod[$m];
					$this->subtotal[$month] += $rw[$month];
				}				
			}		
		}
	}
	
	public function defineEF(){
	
		global $arrUsrData;
		global $budget_scenario;
		global $Items,$Activities;
		
		parent::defineEF();
		
		$this->Columns[] = Array(
					'title'=>'Item'
					,'field'=>$this->prefix.'ItemGUID'
					,'type'=>'combobox'
					// ,'sql'=>$Items->getStructuredRef()
					,'sql'=>"SELECT itmGUID as optValue, itmTitle as optText FROM vw_item"
					, 'mandatory' => true
					, 'disabled'=>!$this->flagUpdate
				);
				
		$this->Columns[] = Array(
					'title'=>'Activity'
					,'field'=>$this->prefix.'ActivityID'
					,'type'=>'combobox'
					,'sql'=>"SELECT prtID as optValue, prtTitle as optText FROM vw_product_type"
					// ,'sql'=>$Activities->getStructuredRef()
					, 'mandatory' => true
					, 'disabled'=>!$this->flagUpdate
					, 'defaultText'=>"[All]"
				);
		$this->Columns[] =Array(
					'title'=>'Total'
					,'field'=>$this->prefix."Total"
					,'type'=>'decimal'
					,'mandatory'=>true
					, 'disabled'=>!$this->flagUpdate
				);
			
	}
	
	public function defineGrid(){
		
		GLOBAL $Items;
	
		$this->grid->Columns[] = Array(
				'title'=>'Customer'
				,'field'=>'customer'
				,'type'=>'ajax_dropdown'
				,'table'=>'vw_customer'
				,'source'=>'vw_customer'
				,'prefix'=>'cnt'
				,'sql'=>"SELECT cntID as optValue, cntTitle as optText FROM vw_customer"
				, 'mandatory' => true
				, 'disabled'=>!$this->flagUpdate
				, 'default'=>0
				, 'class'=>'costs_supplier'
			);		

		$this->grid->Columns[] =Array(
			'title'=>'Unit'
			,'field'=>'unit'
			,'type'=>'text'
			,'mandatory'=>true
		);
		
		
		$this->setMonthlyEG('int');
		
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
		
	
		parent::save($mode);
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if($mode=='update' || $mode=='post'){						
			$this->profit = isset($_POST[$this->prefix.'ProfitID'])?$_POST[$this->prefix.'ProfitID']:$this->profit;
			$this->item = isset($_POST[$this->prefix.'ItemGUID'])?$_POST[$this->prefix.'ItemGUID']:$this->item;
			$this->activity = isset($_POST[$this->prefix.'ActivityID'])?$_POST[$this->prefix.'ActivityID']:$this->activity;
			$this->total = isset($_POST[$this->prefix.'Total'])?$_POST[$this->prefix.'Total']:$this->rate;
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
						$row->activity = $this->activity;						
						$row->customer = isset($_POST['customer'][$id]) ? $_POST['customer'][$id] : $this->customer;						
						$row->unit = $_POST['unit'][$id];					
						for ($m=1;$m<=$this->budget->length;$m++){
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
		
		$sql = Array();
		$sql[] = "SET AUTOCOMMIT = 0;";
		$sql[] = "START TRANSACTION;";
		// $sql[] = "UPDATE `".$this->table."` 
						// SET ".$this->prefix."ItemGUID=".$this->oSQL->e($this->item)."
						// ,".$this->prefix."Total=".(double)$this->total."						
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
	
	public function fill_distribution($oBudget,$type='sqm',$params=Array()){
		
		if (is_array($this->records[$this->gridName])){
			foreach($this->records[$this->gridName] as $id=>$record){
				$record->flagDeleted = true;
			}
		}
		
		$dateEstStart = ($oBudget->year-2).'-10-01';
		$dateEstEnd = ($oBudget->year-1).'-09-30';
		
		switch ($type) {
			case 'sqm':
				$sql = "SELECT unit, customer, ".str_replace('SUM','MAX',$this->budget->getMonthlySumSQL())." FROM reg_sales
						WHERE scenario='".$this->budget->id."' 
							AND active=1 
							AND pc='{$this->profit}'
							AND unit='sqm'
						GROUP BY customer"; 
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
			$row->customer = $rw['customer'];			
			for ($m=1;$m<=$this->budget->length;$m++){
				$month = $this->budget->arrPeriod[$m];				
				$row->set_month_value($m, $rw[$month]);
				$arrSubtotal[$month] += $rw[$month];
				$arrSum[$month] = $this->total - $arrSubtotal[$month];
			}
		}
		$row = $this->add_record();
		$row->flagUpdated = true;				
		$row->unit = 'sqm';
		$row->customer = 0;
		$row->set_months($arrSum);
		
	}
	
	function post(){
	
		GLOBAL $arrUsrData;
		GLOBAL $Activities;
		GLOBAL $YACT;
		GLOBAL $Items;
	
		$this->refresh($this->ID);//echo '<pre>',print_r($this->data);echo '</pre>';
			$oMaster = new Master($this->scenario, $this->GUID);
			// print_r($this->subtotal);
			if(is_array($this->records[$this->gridName])){
				
				$sql = "SELECT * FROM vw_item WHERE itmGUID='{$this->item}'";
				$rs = $this->oSQL->q($sql);
				$rw = $this->oSQL->f($rs);
				if ($rw['itmFlagFolder']){
					$sql = "SELECT * FROM vw_item WHERE itmParentID={$rw['itmID']}";
					$rs = $this->oSQL->q($sql);
					while ($rw = $this->oSQL->f($rs)){
						$arrItemFilter[] = $rw['itmGUID'];
					}
					$strItemFilter = implode("','",$arrItemFilter);
				} else {
					$strItemFilter = $this->item;
				}
				
				$sql = "SELECT activity, item, ".$this->budget->getMonthlySumSQL(1,$this->budget->length)." FROM reg_master
						WHERE scenario='{$this->scenario}'
							AND pc='{$this->profit}'
							AND item IN ('{$strItemFilter}')
							AND IFNULL(customer,".self::EMPTY_CUSTOMER.")=".self::EMPTY_CUSTOMER."
							".($this->activity?" AND activity={$this->activity}":"")."
						GROUP BY item, activity;";
				$this->log($sql);
				$rs = $this->oSQL->q($sql);
				while ($total = $this->oSQL->f($rs)){				
					foreach($this->records[$this->gridName] as $id=>$record){

							$master_row = $oMaster->add_master();
							$master_row->profit = $this->profit;
							$master_row->activity = $total['activity'];
							$master_row->customer = $record->customer;					
							$item = $Items->getById($total['item']);
							$master_row->account = $item->getYACT($this->profit);
							$master_row->item = $total['item'];
							for($m=1;$m<=$this->budget->length;$m++){
								$month = $this->budget->arrPeriod[$m];
								$master_row->{$month} = $record->{$month}/$this->subtotal[strtolower($month)]*$total[$month];
							}				
													
							
							//echo '<pre>';print_r($master_row);echo '</pre>';
		
					}
					
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->profit;
					$master_row->activity = $total['activity'];
					$master_row->customer = self::EMPTY_CUSTOMER;					
					$item = $Items->getById($total['item']);
					$master_row->account = $item->getYACT($this->profit);
					$master_row->item = $total['item'];
					for($m=1;$m<=$this->budget->length;$m++){
						$month = $this->budget->arrPeriod[$m];
						$master_row->{$month} = -$total[$month];
					}
				}
				$oMaster->save();
				$this->markPosted();
			}
	}
	
}

?>


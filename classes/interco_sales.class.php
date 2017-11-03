<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('classes/sales_record.class.php');
include_once ('classes/item.class.php');
include_once ('classes/product.class.php');
include_once ('classes/yact_coa.class.php');

$Products = new Products ();
$Activities = new Activities ();
$YACT = new YACT_COA();

class Interco_sales extends Document{

	const Register='reg_sales';
	const GridName = 'interco_sales';
	const Prefix = 'ics';
	const Table = 'tbl_interco_sales';
	
	function __construct($id=''){
		GLOBAL $strLocal;
		GLOBAL $arrUsrData;
		
		$this->gridName = self::GridName;
		$this->gridClass = 'sales_record';
		$this->table = self::Table;
		$this->prefix = self::Prefix;
		$this->register = self::Register;
		
		parent::__construct($id);
		
	}
	public function refresh($id){
		
		$sqlWhere = $this->getSqlWhere($id);
				
		$sql = "SELECT ICS.*, prdIdxLeft, prdIdxRight, usrTitle FROM tbl_interco_sales ICS
				LEFT JOIN vw_product ON prdID=icsProductFolderID
				LEFT JOIN stbl_user ON usrID=icsEditBy
				WHERE $sqlWhere";
		
		parent::refresh($sql);
		
		$this->type = $this->data[$this->prefix.'Type'];
		
		if($this->GUID){
			$sql = "SELECT * FROM `".self::Register."` WHERE `source`='".$this->GUID."';";
			$rs = $this->oSQL->q($sql);			
			while($rw = $this->oSQL->f($rs)){
				$this->records[$this->gridName][$rw['id']] = new sales_record($this->GUID, $this->scenario,  $this->company, $rw['id'], $rw);
			}		
		}
	}
	
	public function defineEF(){
	
		global $arrUsrData;
		global $budget_scenario;
	
		parent::defineEF();
		// $this->Columns = Array();
		
		// $this->Columns[] = Array(
			// 'field'=>self::Prefix.'ID'	
		// );
		// $this->Columns[] = Array(
			// 'field'=>self::Prefix.'GUID'
			// ,'type'=>'guid'
		// );
		// $this->Columns[] = Array(
			// 'title'=>'Scenario'
			// ,'field'=>self::Prefix.'Scenario'
			// ,'type'=>'combobox'
			// ,'sql'=>'SELECT scnID as optValue, scnTitle as optText FROM tbl_scenario'
			// ,'default'=>$budget_scenario			
		// );
		// $this->Columns[] = Array(
			// 'title'=>'Profit center'
			// ,'field'=>self::Prefix.'ProfitID'
			// ,'type'=>'combobox'
			// ,'sql'=>'SELECT pccID as optValue, pccTitle as optText FROM vw_profit'
			// ,'default'=>$arrUsrData['usrProfitID']
		// );
		
		$this->Columns[] = Array( //------------SPECIAL CASE, Customer is another profit center
			'title'=>'Customer'
			,'field'=>self::Prefix.'CustomerID'
			,'type'=>'combobox'
			,'table'=>'vw_profit'
			,'prefix'=>'pcc'
			,'sql'=>'vw_profit'
			,'default'=>6
			, 'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array(
			'title'=>'Product folder'
			,'field'=>self::Prefix.'ProductFolderID'
			,'type'=>'combobox'
			,'sql'=>'vw_folder'
			,'prefix'=>'prd'
			,'default'=>22
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array( 
			'title'=>'Type'
			,'field'=>self::Prefix.'Type'
			,'type'=>'combobox'
			,'sql'=>Array('DC'=>'Operational','SC'=>'Staff costs')			
			,'default'=>'DC'
			, 'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = $this->getResponsibleEF();
		
	}
	
	public function defineGrid(){
		
		$this->grid->Columns[] = parent::getCustomerEG();
		
		$this->grid->Columns[] = Array(
			'title'=>'Code'
			,'field'=>'prdExternalID'
			,'type'=>'text'
			,'disabled'=>true
		);
		
		$this->grid->Columns[] = parent::getProductEG();
		
		$this->grid->Columns[] = Array(
			'title'=>'Description'
			,'field'=>'comment'
			,'type'=>'text'
			, 'disabled'=>false
		);
		$this->grid->Columns[] =Array(
			'title'=>'Unit'
			,'field'=>'unit'
			,'type'=>'text'
			,'mandatory'=>true
		);

		$this->grid->Columns[] =Array(
			'title'=>'Selling rate'
			,'field'=>'selling_rate'
			,'type'=>'money'
			,'mandatory'=>true
		);
		
		$this->grid->Columns[] = parent::getCurrencyEG('selling_curr');
		
		$this->grid->Columns[] =Array(
			'title'=>'Buying rate'
			,'field'=>'buying_rate'
			,'type'=>'money'
			,'mandatory'=>true
			
		);
		
		$this->grid->Columns[] = parent::getCurrencyEG('buying_curr');		
		
		if (!$this->flagPosted){		
			$this->setMonthlyEG('int');
		} else {
			$grid->Columns[] = parent::getActivityEG();
		}
		
		$this->grid->Columns[] =Array(
			'title'=>'Total'
			,'field'=>'YTD'
			,'type'=>'integer'
			,'totals'=>true
			,'disabled'=>true
		);
		
		return ($this->grid);
	}
	
	public function fillGrid(){
		parent::fillGrid($this->grid,Array('prdExternalID'),'reg_sales LEFT JOIN vw_product ON prdID=product');
	}
	
	public function save($mode='update'){
		
		GLOBAL $arrUsrData;
		GLOBAL $Activities;
		GLOBAL $YACT;
		
		parent::save($mode);
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if ($mode=='update' || $mode=='post'){
			$this->profit = isset($_POST[self::Prefix.'ProfitID'])?$_POST[self::Prefix.'ProfitID']:$this->profit;
			$this->product_folder = isset($_POST[self::Prefix.'ProductFolderID'])?$_POST[self::Prefix.'ProductFolderID']:$this->product_folder;			
			$this->customer = isset($_POST[self::Prefix.'CustomerID'])?$_POST[self::Prefix.'CustomerID']:$this->customer;
			$this->sales = isset($_POST[$this->prefix.'UserID'])?$_POST[$this->prefix.'UserID']:$this->sales;						
			$this->type = isset($_POST[$this->prefix.'Type'])?$_POST[$this->prefix.'Type']:$this->type;						
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
						$row->profit = $_POST[$this->prefix.'ProfitID'];
						$row->product = $_POST['product'][$id];				
						$row->customer = $_POST['customer'][$id];
						$row->sales = $this->sales;							
						$row->comment = $_POST['comment'][$id];				
						$row->selling_rate = (double)str_replace(',','',$_POST['selling_rate'][$id]);				
						$row->selling_curr = $_POST['selling_curr'][$id];				
						$row->buying_rate = (double)str_replace(',','',$_POST['buying_rate'][$id]);				
						$row->buying_curr = $_POST['buying_curr'][$id];				
						for ($m=1;$m<=15;$m++){
							$month = $this->budget->arrPeriod[$m];
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
		// $sql[] = "UPDATE `{$this->table}` 
				// SET {$this->prefix}ProfitID=".(integer)$this->profit."
				// ,{$this->prefix}ProductFolderID=".(integer)$this->product_folder."
				// ,{$this->prefix}CustomerID=".(integer)$this->customer."
				// ,{$this->prefix}Comment=".$this->oSQL->e($this->comment)."
				// ,{$this->prefix}Scenario='".$this->scenario."'
				// ,{$this->prefix}EditBy='".$arrUsrData['usrID']."'
				// ,{$this->prefix}EditDate=NOW()
				// WHERE {$this->prefix}ID={$this->ID};";
		if(is_array($this->records[$this->gridName])){			
			foreach ($this->records[$this->gridName] as $i=>$row){				
				if ($row->flagUpdated || $row->flagDeleted){
					$sql[] = $row->getSQLstring();
				}
			}
		};
		
		$sql[] = "SET AUTOCOMMIT = 1;";
		$sql[] = 'COMMIT;';				

		$sqlSuccess = $this->doSQL($sql);		
		
		if($mode=='post'){
			$this->refresh($this->ID);
			$oMaster = new Master($this->scenario, $this->GUID, $this->company);
			
			if(is_array($this->records[$this->gridName])){
				foreach($this->records[$this->gridName] as $id=>$record){
					//-------------------------------------- Income for supplier --------------------------------------------------
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->profit;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;	
					$master_row->sales = $this->getSales($master_row->customer);					
					$activity = $Activities->getByCode($record->activity);
					switch ($this->type) {
						case 'DC':
							$master_row->account = 'J00400';
							$master_row->item = Items::INTERCOMPANY_REVENUE;
							break;
						case 'SC':
							$master_row->account = 'J00801';
							$master_row->item = Items::OUTSOURCING;
							break;
					}
					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
						$master_row->{$month} = ($record->{$month})*$record->selling_rate*$settings[strtolower($record->selling_curr)];
					}				

					//-------------------------------------- Intercompany cost for department --------------------------------------------------
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->customer;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					$master_row->sales = $this->getSales($master_row->customer);
					$activity = $Activities->getByCode($record->activity);
					switch ($this->type) {
						case 'DC':			
							$master_row->account = 'J00802';
							$master_row->item = Items::INTERCOMPANY_COSTS;
							break;
						case 'SC':
							$master_row->account = 'J00801';
							$master_row->item = Items::OUTSOURCING;
							break;
					}
					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
						$master_row->{$month} = -($record->{$month})*$record->selling_rate*$settings[strtolower($record->selling_curr)];
					}
					
					if ($this->type=='DC'){					
					//-------------------------------------- Cost for supplier --------------------------------------------------
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->profit;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					$master_row->sales = $this->getSales($master_row->customer);
					$activity = $Activities->getByCode($record->activity);
					$master_row->account = 'J00802';
					$master_row->item = $activity->item_cost;

					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
						$master_row->{$month} = -($record->{$month})*$record->buying_rate*$settings[strtolower($record->buying_curr)];
					}
					

					
					//-------------------------------------- Elimination of revenue --------------------------------------------------
					$master_row = $oMaster->add_master();
					$master_row->profit = 99;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					$master_row->sales = $this->getSales($master_row->customer);
					$activity = $Activities->getByCode($record->activity);
					$account = 'J00400';
					
					$master_row->account = $account;
					$master_row->item = Items::INTERCOMPANY_REVENUE;
					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
						$master_row->{$month} = -($record->{$month})*$record->selling_rate*$settings[strtolower($record->selling_curr)];
					}
					
					//-------------------------------------- Elimination of revenue --------------------------------------------------
					$master_row = $oMaster->add_master();
					$master_row->profit = 99;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					$master_row->sales = $this->getSales($master_row->customer);
					$activity = $Activities->getByCode($record->activity);
					$account = 'J00802';
					
					$master_row->account = $account;
					$master_row->item = Items::INTERCOMPANY_COSTS;
					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
						$master_row->{$month} = ($record->{$month})*$record->selling_rate*$settings[strtolower($record->selling_curr)];
					}
					
					//-------------------------------------- Replacement of direct costs in customer department--------------------------
					
						$master_row = $oMaster->add_master();
						$master_row->profit = $this->customer;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;				
						$master_row->sales = $this->getSales($master_row->customer);
						$activity = $Activities->getByCode($record->activity);
						$account = 'J00802';
									
						$master_row->account = $account;
						$master_row->item = $activity->item_cost;
						
						$rate = ($record->buying_rate==0?$record->selling_rate*$settings[strtolower($record->selling_curr)]:$record->buying_rate*$settings[strtolower($record->buying_curr)]);
						
						for($m=1;$m<=15;$m++){
							$month = $this->budget->arrPeriod[$m];
							$master_row->{$month} = ($record->{$month})*$rate;
						}
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
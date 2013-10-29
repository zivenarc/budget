<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('../common/eiseGrid/inc_eiseGrid.php');
include_once ('classes/reference.class.php');
include_once ('classes/item.class.php');
include_once ('classes/product.class.php');
include_once ('classes/yact_coa.class.php');

$Products = new Products ();
$Activities = new Activities ();
$YACT = new YACT_COA();

$arrJS[] = '../common/eiseGrid/eiseGrid.js';
$arrCSS[] = '../common/eiseGrid/eiseGrid.css';

class Sales extends Document{

	const Register='reg_sales';
	const GridName = 'sales';
	const Prefix = 'sal';
	const Table = 'tbl_sales';
	
	function __construct($id=''){
		GLOBAL $strLocal;
		GLOBAL $arrUsrData;
		
		$this->gridName = self::GridName;
		$this->table = self::Table;
		$this->prefix = self::Prefix;
		$this->register = self::Register;
		
		parent::__construct($id);
		
	}
	public function refresh($id){
		
		$sqlWhere = $this->getSqlWhere($id);
				
		$sql = "SELECT SAL.*, prdIdxLeft, prdIdxRight, usrTitle FROM tbl_sales SAL
				LEFT JOIN vw_product ON prdID=salProductFolderID
				LEFT JOIN stbl_user ON usrID=salEditBy
				WHERE $sqlWhere";
		
		parent::refresh($sql);
		
		if($this->GUID){
			$sql = "SELECT * FROM `".self::Register."` WHERE `source`='".$this->GUID."';";
			$rs = $this->oSQL->q($sql);			
			while($rw = $this->oSQL->f($rs)){
				$this->records[$this->gridName][$rw['id']] = new sales_record($this->GUID, $this->scenario, $rw['id'], $rw);
			}		
		}
	}
	
	public function defineEF(){
	
		global $arrUsrData;
		global $budget_scenario;
	
		$this->Columns = Array();
		
		$this->Columns[] = Array(
			'field'=>self::Prefix.'ID'	
		);
		$this->Columns[] = Array(
			'field'=>self::Prefix.'GUID'
			,'type'=>'guid'
		);
		$this->Columns[] = Array(
			'title'=>'Scenario'
			,'field'=>self::Prefix.'Scenario'
			,'type'=>'combobox'
			,'sql'=>'SELECT scnID as optValue, scnTitle as optText FROM tbl_scenario'
			,'default'=>$budget_scenario			
		);
		$this->Columns[] = Array(
			'title'=>'Profit center'
			,'field'=>self::Prefix.'ProfitID'
			,'type'=>'combobox'
			,'sql'=>'SELECT pccID as optValue, pccTitle as optText FROM vw_profit'
			,'default'=>$arrUsrData['usrProfitID']
		);
		
		$this->Columns[] = Array(
			'title'=>'Customer'
			,'field'=>self::Prefix.'CustomerID'
			,'type'=>'ajax'
			,'table'=>'vw_customer'
			,'prefix'=>'cnt'
			,'sql'=>'vw_customer'
			,'default'=>9022
		);
		
		$this->Columns[] = Array(
			'title'=>'Product folder'
			,'field'=>self::Prefix.'ProductFolderID'
			,'type'=>'combobox'
			,'sql'=>'
				SELECT 
				PRD1.prdID AS optValue, PRD1.prdTitle AS optText, PRD1.prdParentID
				, COUNT(DISTINCT PRD2.prdID) as prdLevelInside     
				FROM vw_product PRD1 INNER JOIN vw_product PRD2 ON PRD2.prdIdxLeft<=PRD1.prdIdxLeft AND PRD2.prdIdxRight>=PRD1.prdIdxRight
				WHERE PRD1.prdIdxRight-PRD1.prdIdxLeft>1
				GROUP BY PRD1.prdID
				HAVING prdLevelInside=1'
			,'default'=>22
		);
		$this->Columns[] = Array(
			'title'=>'Comments'
			,'field'=>self::Prefix.'Comment'
			,'type'=>'text'
		);
	}
	
	public function defineGrid(){
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
		
		if (!$this->data[self::Prefix.'CustomerID']){
			$grid->Columns[] = parent::getCustomerEG();
		}
		
		$grid->Columns[] = Array(
			'title'=>'Product'
			,'field'=>'product'
			,'type'=>'combobox'
			,'sql'=>"SELECT PRD.prdID as optValue
				".
				   (!empty($this->data["prdIdxLeft"]) 
				   ? "
					, GROUP_CONCAT(PRD_P.prdTitle SEPARATOR ' / ') as optText
					FROM vw_product PRD 
					INNER JOIN vw_product PRD_P ON PRD_P.prdIdxLeft<=PRD.prdIdxLeft 
						AND PRD_P.prdIdxRight>=PRD.prdIdxRight AND PRD_P.prdParentID >0 
					WHERE PRD.prdIdxLeft BETWEEN  '{$this->data["prdIdxLeft"]}' AND '{$this->data["prdIdxRight"]}'
						AND PRD.prdFlagFolder=0
					GROUP BY PRD.prdID
					ORDER BY PRD.prdParentID"
				   : "
				   , prdTitle as optText, prdFlagDeleted as optDeleted
				   FROM vw_product PRD")."      
				"
			, 'mandatory' => true
			, 'disabled'=>false
		);
		$grid->Columns[] = Array(
			'title'=>'Description'
			,'field'=>'comment'
			,'type'=>'text'
			, 'disabled'=>false
		);
		$grid->Columns[] =Array(
			'title'=>'Unit'
			,'field'=>'unit'
			,'type'=>'text'
			,'mandatory'=>true
		);

		$grid->Columns[] =Array(
			'title'=>'Selling rate'
			,'field'=>'selling_rate'
			,'type'=>'money'
			,'mandatory'=>true
		);
		
		$grid->Columns[] = parent::getCurrencyEG('selling_curr');
		
		$grid->Columns[] =Array(
			'title'=>'Buying rate'
			,'field'=>'buying_rate'
			,'type'=>'money'
			,'mandatory'=>true
			
		);
		
		$grid->Columns[] = parent::getCurrencyEG('buying_curr');		
		
		for ($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
					
			$grid->Columns[] = Array(
			'title'=>$month
			,'field'=>strtolower($month)
			,'class'=>'budget-month'
			,'type'=>'int'
			, 'mandatory' => true
			, 'disabled'=>false
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
		
		return ($grid);
	}
	

	public function add_record(){		
		$oBR = new sales_record($this->GUID,$this->scenario);
		$this->records[$this->gridName][] = $oBR;
		return ($oBR);	
	}
	
	public function save($mode='update'){
		
		GLOBAL $arrUsrData;
		GLOBAL $Activities;
		GLOBAL $YACT;
		
		if (!$this->ID){
			$this->Update();
			return(true);
		}
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		
		$this->profit = $_POST[self::Prefix.'ProfitID'];
		$this->product_folder = $_POST[self::Prefix.'ProductFolderID'];
		$this->comment = $_POST[self::Prefix.'Comment'];
		$this->customer = $_POST[self::Prefix.'CustomerID'];
		
		//-------------------Updating grid records---------------------------------
		$arrUpdated = $_POST['inp_'.$this->gridName.'_updated'];
		if(is_array($arrUpdated)){
			$nRows = count($_POST['inp_'.$this->gridName.'_updated']);
			for($id=1;$id<$nRows;$id++){		

				$row = $this->get_record($_POST['id'][$id]);					

				if ($row){
					if ($arrUpdated[$id]){				
						$row->flagUpdated = true;				
						$row->profit = $_POST['salProfitID'];
						$row->product = $_POST['product'][$id];				
						$row->customer = $_POST['customer'][$id]?$_POST['customer'][$id]:$this->customer;				
						$row->comment = $_POST['comment'][$id];				
						$row->selling_rate = str_replace(',','',$_POST['selling_rate'][$id]);				
						$row->selling_curr = $_POST['selling_curr'][$id];				
						$row->buying_rate = str_replace(',','',$_POST['buying_rate'][$id]);				
						$row->buying_curr = $_POST['buying_curr'][$id];				
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
		$sql[] = "UPDATE `tbl_sales` 
				SET salProfitID=".(integer)$this->profit."
				,salProductFolderID=".(integer)$this->product_folder."
				,salCustomerID=".(integer)$this->customer."
				,salComment=".$this->oSQL->e($this->comment)."
				,salScenario='".$this->scenario."'
				,salEditBy='".$arrUsrData['usrID']."'
				,salEditDate=NOW()
				WHERE salID={$this->ID};";
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
		
		if ($mode=='unpost'){
			$this->unpost();
		}
		
		if($mode=='post'){
			$this->refresh($this->ID);
			$oMaster = new budget_session($this->scenario, $this->GUID);
			
			if(is_array($this->records[$this->gridName])){
				foreach($this->records[$this->gridName] as $id=>$record){
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->profit;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					
					$activity = $Activities->getByCode($record->activity);
					$account = $YACT->getByCode($activity->YACT);
					
					$master_row->account = $account;
					$master_row->item = $activity->item_income;
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = ($record->{$month})*$record->selling_rate*$settings[strtolower($record->selling_curr)];
					}				
					
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->profit;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					
					$activity = $Activities->getByCode($record->activity);
					$account = $YACT->getByCode('J00802');
					
					$master_row->account = $account;
					$master_row->item = $activity->item_cost;
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = -($record->{$month})*$record->buying_rate*$settings[strtolower($record->buying_curr)];
					}
					
					}
				$oMaster->save();
				$this->markPosted();
			}
		}
		
		return($sqlSuccess);
				
	}
	
}

class Interco_sales extends Document{

	const Register='reg_sales';
	const GridName = 'interco_sales';
	const Prefix = 'ics';
	const Table = 'tbl_interco_sales';
	
	function __construct($id=''){
		GLOBAL $strLocal;
		GLOBAL $arrUsrData;
		
		$this->gridName = self::GridName;
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
		
		if($this->GUID){
			$sql = "SELECT * FROM `".self::Register."` WHERE `source`='".$this->GUID."';";
			$rs = $this->oSQL->q($sql);			
			while($rw = $this->oSQL->f($rs)){
				$this->records[$this->gridName][$rw['id']] = new sales_record($this->GUID, $this->scenario, $rw['id'], $rw);
			}		
		}
	}
	
	public function defineEF(){
	
		global $arrUsrData;
		global $budget_scenario;
	
		$this->Columns = Array();
		
		$this->Columns[] = Array(
			'field'=>self::Prefix.'ID'	
		);
		$this->Columns[] = Array(
			'field'=>self::Prefix.'GUID'
			,'type'=>'guid'
		);
		$this->Columns[] = Array(
			'title'=>'Scenario'
			,'field'=>self::Prefix.'Scenario'
			,'type'=>'combobox'
			,'sql'=>'SELECT scnID as optValue, scnTitle as optText FROM tbl_scenario'
			,'default'=>$budget_scenario			
		);
		$this->Columns[] = Array(
			'title'=>'Profit center'
			,'field'=>self::Prefix.'ProfitID'
			,'type'=>'combobox'
			,'sql'=>'SELECT pccID as optValue, pccTitle as optText FROM vw_profit'
			,'default'=>$arrUsrData['usrProfitID']
		);
		
		$this->Columns[] = Array( //------------SPECIAL CASE, Customer is another profit center
			'title'=>'Customer'
			,'field'=>self::Prefix.'CustomerID'
			,'type'=>'combobox'
			,'table'=>'vw_profit'
			,'prefix'=>'pcc'
			,'sql'=>'vw_profit'
			,'default'=>6
		);
		
		$this->Columns[] = Array(
			'title'=>'Product folder'
			,'field'=>self::Prefix.'ProductFolderID'
			,'type'=>'combobox'
			,'sql'=>'
				SELECT 
				PRD1.prdID AS optValue, PRD1.prdTitle AS optText, PRD1.prdParentID
				, COUNT(DISTINCT PRD2.prdID) as prdLevelInside     
				FROM vw_product PRD1 INNER JOIN vw_product PRD2 ON PRD2.prdIdxLeft<=PRD1.prdIdxLeft AND PRD2.prdIdxRight>=PRD1.prdIdxRight
				WHERE PRD1.prdIdxRight-PRD1.prdIdxLeft>1
				GROUP BY PRD1.prdID
				HAVING prdLevelInside=1'
			,'default'=>22
		);
		$this->Columns[] = Array(
			'title'=>'Comments'
			,'field'=>self::Prefix.'Comment'
			,'type'=>'text'
		);
	}
	
	public function defineGrid(){
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
		
		$grid->Columns[] = parent::getCustomerEG();
				
		$grid->Columns[] = Array(
			'title'=>'Product'
			,'field'=>'product'
			,'type'=>'combobox'
			,'sql'=>"SELECT PRD.prdID as optValue
				".
				   (!empty($this->data["prdIdxLeft"]) 
				   ? "
					, GROUP_CONCAT(PRD_P.prdTitle SEPARATOR ' / ') as optText
					FROM vw_product PRD 
					INNER JOIN vw_product PRD_P ON PRD_P.prdIdxLeft<=PRD.prdIdxLeft 
						AND PRD_P.prdIdxRight>=PRD.prdIdxRight AND PRD_P.prdParentID >0 
					WHERE PRD.prdIdxLeft BETWEEN  '{$this->data["prdIdxLeft"]}' AND '{$this->data["prdIdxRight"]}'
						AND PRD.prdFlagFolder=0
					GROUP BY PRD.prdID
					ORDER BY PRD.prdParentID"
				   : "
				   , prdTitle as optText, prdFlagDeleted as optDeleted
				   FROM vw_product PRD")."      
				"
			, 'mandatory' => true
			, 'disabled'=>false
		);
		$grid->Columns[] = Array(
			'title'=>'Description'
			,'field'=>'comment'
			,'type'=>'text'
			, 'disabled'=>false
		);
		$grid->Columns[] =Array(
			'title'=>'Unit'
			,'field'=>'unit'
			,'type'=>'text'
			,'mandatory'=>true
		);

		$grid->Columns[] =Array(
			'title'=>'Selling rate'
			,'field'=>'selling_rate'
			,'type'=>'money'
			,'mandatory'=>true
		);
		
		$grid->Columns[] = parent::getCurrencyEG('selling_curr');
		
		$grid->Columns[] =Array(
			'title'=>'Buying rate'
			,'field'=>'buying_rate'
			,'type'=>'money'
			,'mandatory'=>true
			
		);
		
		$grid->Columns[] = parent::getCurrencyEG('buying_curr');		
		
		for ($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
					
			$grid->Columns[] = Array(
			'title'=>$month
			,'field'=>strtolower($month)
			,'class'=>'budget-month'
			,'type'=>'int'
			, 'mandatory' => true
			, 'disabled'=>false
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
		
		return ($grid);
	}
	

	public function add_record(){		
		$oBR = new sales_record($this->GUID,$this->scenario);
		$this->records[$this->gridName][] = $oBR;
		return ($oBR);	
	}
	
	public function save($mode='update'){
		
		GLOBAL $arrUsrData;
		GLOBAL $Activities;
		GLOBAL $YACT;
		
		if (!$this->ID){
			$this->Update();
			return(true);
		}
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		
		$this->profit = $_POST[self::Prefix.'ProfitID'];
		$this->product_folder = $_POST[self::Prefix.'ProductFolderID'];
		$this->comment = $_POST[self::Prefix.'Comment'];
		$this->customer = $_POST[self::Prefix.'CustomerID'];
		
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
						$row->comment = $_POST['comment'][$id];				
						$row->selling_rate = str_replace(',','',$_POST['selling_rate'][$id]);				
						$row->selling_curr = $_POST['selling_curr'][$id];				
						$row->buying_rate = str_replace(',','',$_POST['buying_rate'][$id]);				
						$row->buying_curr = $_POST['buying_curr'][$id];				
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
		$sql[] = "UPDATE `{$this->table}` 
				SET {$this->prefix}ProfitID=".(integer)$this->profit."
				,{$this->prefix}ProductFolderID=".(integer)$this->product_folder."
				,{$this->prefix}CustomerID=".(integer)$this->customer."
				,{$this->prefix}Comment=".$this->oSQL->e($this->comment)."
				,{$this->prefix}Scenario='".$this->scenario."'
				,{$this->prefix}EditBy='".$arrUsrData['usrID']."'
				,{$this->prefix}EditDate=NOW()
				WHERE {$this->prefix}ID={$this->ID};";
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
		
		if ($mode=='unpost'){
			$this->unpost();
		}
		
		if($mode=='post'){
			$this->refresh($this->ID);
			$oMaster = new budget_session($this->scenario, $this->GUID);
			
			if(is_array($this->records[$this->gridName])){
				foreach($this->records[$this->gridName] as $id=>$record){
					//-------------------------------------- Income for supplier --------------------------------------------------
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->profit;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;							
					$activity = $Activities->getByCode($record->activity);
					$account = $YACT->getByCode('J00400');			
					$master_row->account = $account;
					$master_row->item = Items::INTERCOMPANY_REVENUE;
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = ($record->{$month})*$record->selling_rate*$settings[strtolower($record->selling_curr)];
					}				
					
					//-------------------------------------- Cost for supplier --------------------------------------------------
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->profit;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					
					$activity = $Activities->getByCode($record->activity);
					$account = $YACT->getByCode('J00802');
					
					$master_row->account = $account;
					$master_row->item = $activity->item_cost;
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = -($record->{$month})*$record->buying_rate*$settings[strtolower($record->buying_curr)];
					}
					
					//-------------------------------------- Intercompany cost for department --------------------------------------------------
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->customer;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					
					$activity = $Activities->getByCode($record->activity);
					$account = $YACT->getByCode('J00802');
					
					$master_row->account = $account;
					$master_row->item = Items::INTERCOMPANY_COSTS;
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = -($record->{$month})*$record->selling_rate*$settings[strtolower($record->selling_curr)];
					}
					
					//-------------------------------------- Elimination of revenue --------------------------------------------------
					$master_row = $oMaster->add_master();
					$master_row->profit = 99;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					
					$activity = $Activities->getByCode($record->activity);
					$account = $YACT->getByCode('J00400');
					
					$master_row->account = $account;
					$master_row->item = Items::INTERCOMPANY_REVENUE;
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = -($record->{$month})*$record->selling_rate*$settings[strtolower($record->selling_curr)];
					}
					
					//-------------------------------------- Elimination of revenue --------------------------------------------------
					$master_row = $oMaster->add_master();
					$master_row->profit = 99;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					
					$activity = $Activities->getByCode($record->activity);
					$account = $YACT->getByCode('J00802');
					
					$master_row->account = $account;
					$master_row->item = Items::INTERCOMPANY_COSTS;
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = ($record->{$month})*$record->selling_rate*$settings[strtolower($record->selling_curr)];
					}
					
					//-------------------------------------- Replacement of direct costs in customer department--------------------------
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->customer;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					
					$activity = $Activities->getByCode($record->activity);
					$account = $YACT->getByCode('J00802');
					
					$master_row->account = $account;
					$master_row->item = $activity->item_cost;
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = ($record->{$month})*$record->selling_rate*$settings[strtolower($record->selling_curr)];
					}
				}
				$oMaster->save();
				$this->markPosted();
			}
		}
		
		return($sqlSuccess);
				
	}
	
}

class sales_record{
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
	
	public $flagUpdated;
	public $flagDeleted;
	public $id;
	
	function __construct($session, $scenario, $id='', $data=Array()){
		//GLOBAL $Products;
		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$this->{$month} = 0;
		}
		$this->id = $id;
		$this->source = $session;
		$this->scenario = $scenario;
		//$this->product_ref = $Products;
		
		if (count($data)){
			for($m=1;$m<13;$m++){
				$month = date('M',mktime(0,0,0,$m,15));
				$this->{$month} = $data[strtolower($month)];			
			}
			$this->product = $data['product'];
			$this->company = $data['company'];
			$this->profit = $data['profit'];
			$this->activity = $data['activity'];
			$this->customer = $data['customer'];
			$this->comment = $data['comment'];
			$this->unit = $data['unit'];
			$this->selling_curr = $data['selling_curr'];
			$this->buying_curr = $data['buying_curr'];
			$this->selling_rate = $data['selling_rate'];
			$this->buying_rate= $data['buying_rate'];	
		}		
		return (true);
	}	
		
	public function set_month_value($i, $value){
		$month = date('M',mktime(0,0,0,(integer)$i,15));
		$this->{$month} =(double)$value;
		return(true);
	}
	
	public function getSQLstring(){
		
		if ($this->flagDeleted && $this->id){
			$res = "DELETE FROM `reg_sales` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
		
		GLOBAL $Products;

		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$arrRes[] = "`$month`=".(integer)$this->{$month};
		}
			
			$oProduct = $Products->getByCode($this->product);
			
			$arrRes[] = "`company`='OOO'";
			$arrRes[] = "`pc`=".$this->profit;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";
			$arrRes[] = "`customer`='".$this->customer."'";
			$arrRes[] = "`comment`='".$this->comment."'";
			$arrRes[] = "`product`='".$this->product."'";
			$arrRes[] = "`selling_rate`='".$this->selling_rate."'";
			$arrRes[] = "`selling_curr`='".$this->selling_curr."'";
			$arrRes[] = "`buying_rate`='".$this->buying_rate."'";
			$arrRes[] = "`buying_curr`='".$this->buying_curr."'";
			$arrRes[] = "`activity`='".$oProduct->activity."'";
			$arrRes[] = "`unit`='".$oProduct->unit."'";
			if ($this->id){
				$res = "UPDATE `reg_sales` SET ". implode(',',$arrRes)." WHERE id=".$this->id;
			} else {
				$res = "INSERT INTO `reg_sales` SET ". implode(',',$arrRes);
			}
			//echo '<pre>',$res,'</pre>';
			return $res;
	}
	
	public function total(){
		for($m=1;$m<12;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$res += $this->{$month};
		}
		return ($res);
	}
}

?>


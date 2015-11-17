<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('classes/sales_record.class.php');
include_once ('classes/reference.class.php');
include_once ('classes/item.class.php');
include_once ('classes/product.class.php');
include_once ('classes/yact_coa.class.php');

$Products = new Products ();
$Activities = new Activities ();
$YACT = new YACT_COA();
$Items = new Items();

class Sales extends Document{

	const Register='reg_sales';
	const GridName = 'sales';
	const Prefix = 'sal';
	const Table = 'tbl_sales';
	const GridClass = 'sales_record';
	
	function __construct($id=''){
		GLOBAL $strLocal;
		GLOBAL $arrUsrData;
		
		$this->gridName = self::GridName;
		$this->table = self::Table;
		$this->prefix = self::Prefix;
		$this->register = self::Register;
		$this->gridClass = self::GridClass;
		
		parent::__construct($id);
		
		$this->sales = $this->data['salUserID'];
		$this->ps_profit = $this->data['salPSProfitID'];
		$this->ps_rate = $this->data['salPSRate'];
		
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
	
		parent::defineEF();
		
		$this->Columns[] = Array(
			'title'=>'Customer'
			,'field'=>self::Prefix.'CustomerID'
			,'type'=>'ajax'
			,'table'=>'vw_customer'
			,'prefix'=>'cnt'
			,'sql'=>'vw_customer'
			,'default'=>9022
			,'disabled'=>!$this->flagUpdate
			,'mandatory'=>true
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
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = $this->getResponsibleEF();
		
		$this->Columns[] = Array(
			'title'=>'Profit share with'
			,'field'=>self::Prefix.'PSProfitID'
			,'type'=>'combobox'			
			,'prefix'=>'pcc'
			,'sql'=>'vw_profit'
			,'mandatory'=>false
			,'default'=>null
			,'defaultText'=>'---NONE---'
			,'disabled'=>!$this->flagUpdate
		);
		
		$this->Columns[] = Array(
			'title'=>'P/S rate, %'
			,'field'=>self::Prefix.'PSRate'
			,'type'=>'int'						
			,'mandatory'=>false
			,'default'=>0			
			,'disabled'=>!$this->flagUpdate
		);
	}
	
	//==========================================Definition of document GRID ===================================================
	public function defineGrid(){
		
		GLOBAL $Products;
	
		$grid = new eiseGrid($this->oSQL
                    ,$this->gridName
                    , Array(
                            'flagKeepLastRow' => false
                            , 'arrPermissions' => Array("FlagWrite" => $this->flagUpdate)
                            , 'flagStandAlone' => true
							, 'controlBarButtons' => "add|delete"
                            )
                    );
		
		$this->grid = $grid;
		
		$this->grid->Columns[]=Array(
			'field'=>"id"
			,'type'=>'row_id'
		);
		
		if (!$this->data[self::Prefix.'CustomerID']){
			$this->grid->Columns[] = parent::getCustomerEG();
		}
		
		$this->grid->Columns[] = Array(
			'title'=>'Code'
			,'field'=>'prdExternalID'
			,'width'=>'60px'
			,'type'=>'text'
			,'disabled'=>true
		);
		
		$this->grid->Columns[] = parent::getProductEG();
		
		$this->grid->Columns[] = Array(
			'title'=>'Description'
			,'field'=>'comment'
			,'width'=>'160px'
			,'type'=>'text'
			, 'disabled'=>false
		);
		$this->grid->Columns[] =Array(
			'title'=>'Unit'
			,'field'=>'unit'
			,'width'=>'50px'
			,'type'=>'text'
			,'mandatory'=>true
		);

		$this->grid->Columns[] =Array(
			'title'=>'Selling rate'
			,'field'=>'selling_rate'
			,'width'=>'60px'
			,'type'=>'money'
			,'mandatory'=>true
		);
		
		$this->grid->Columns[] = parent::getCurrencyEG('selling_curr');
		
		$this->grid->Columns[] =Array(
			'title'=>'Buying rate'
			,'field'=>'buying_rate'
			,'type'=>'money'
			,'width'=>'60px'
			,'mandatory'=>true
			
		);
		
		$this->grid->Columns[] = parent::getCurrencyEG('buying_curr');		
		
		$this->grid->Columns[] =Array(
				'title'=>"KPI"
				,'field'=>'kpi'
				,'type'=>'boolean'
				,'width'=>'28px'
				,'mandatory'=>false
				, 'disabled'=>$this->flagPosted
		);	
		
		if (!$this->flagPosted){		
			
			$this->setMonthlyEG('int');
			
		} else {
			$this->grid->Columns[] = parent::getActivityEG();
		}
		
		$this->grid->Columns[] =Array(
			'title'=>'Total'
			,'field'=>'YTD'
			,'type'=>'integer'
			,'width'=>'100px'
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

		
		parent::save($mode);
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if ($mode=='update' || $mode=='post'){
			$this->profit = isset($_POST[$this->prefix.'ProfitID'])?$_POST[$this->prefix.'ProfitID']:$this->profit;
			$this->product_folder = isset($_POST[$this->prefix.'ProductFolderID'])?$_POST[$this->prefix.'ProductFolderID']:$this->product_folder;			
			$this->customer = isset($_POST[$this->prefix.'CustomerID'])?$_POST[$this->prefix.'CustomerID']:$this->customer;
			$this->sales = isset($_POST[$this->prefix.'UserID'])?$_POST[$this->prefix.'UserID']:$this->sales;

			if (isset($_POST[$this->prefix.'ProfitID']) && count($this->records[$this->gridName])){
				foreach ($this->records[$this->gridName] as $id=>$row){
					$row = $this->get_record($id); 
					if ($row->profit!=$this->profit){		
						$row->flagUpdated = true;				
						$row->profit = $this->profit;
					}
				}	 			
			}

			if ($this->customer && count($this->records[$this->gridName])){
				foreach ($this->records[$this->gridName] as $id=>$row){
					$row = $this->get_record($id);
					if ($row->customer!=$this->customer){
						$row->flagUpdated = true;				
						$row->customer = $this->customer;
					}
				}
			}
						
		}
		
		// print_r($this->records[$this->gridName]);die();
		
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
						$row->product = $_POST['product'][$id];				
						$row->activity = $_POST['activity'][$id];				
						$row->customer = isset($_POST['customer'][$id])?$_POST['customer'][$id]:$this->customer;					
						$row->comment = $_POST['comment'][$id];				
						$row->selling_rate = (double)str_replace(',','',$_POST['selling_rate'][$id]);				
						$row->selling_curr = $_POST['selling_curr'][$id];				
						$row->buying_rate = (double)str_replace(',','',$_POST['buying_rate'][$id]);				
						$row->buying_curr = $_POST['buying_curr'][$id];				
						$row->formula = $_POST['formula'][$id];				
						$row->kpi = $_POST['kpi'][$id];				
						$row->sales = $this->sales;				
						for ($m=1;$m<=$this->budget->length;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];	
							$row->{$month} = (integer)$_POST[strtolower($month)][$id];
						}					
					} else {
						// $row->flagUpdated = false;
					}
				}
			}	
		}
		
		$this->deleteGridRecords();
		
		
		// echo '<pre>';print_r($settings);echo '</pre>';	
		
		$sql = Array();
		$sql[] = "SET AUTOCOMMIT = 0;";
		$sql[] = "START TRANSACTION;";
		// if ($mode!='new'){
			// $sql[] = "UPDATE `tbl_sales` 
					// SET salProfitID=".(integer)$this->profit."
					// ,salProductFolderID=".(integer)$this->product_folder."
					// ,salCustomerID=".(integer)$this->customer."
					// ,salComment=".$this->oSQL->e($this->comment)."
					// ,salScenario='".$this->scenario."'
					// ,salEditBy='".$arrUsrData['usrID']."'
					// ,salUserID='".$this->sales."'
					// ,salEditDate=NOW()
					// WHERE salID={$this->ID};";
		// };
		if(is_array($this->records[$this->gridName])){			
			foreach ($this->records[$this->gridName] as $i=>$row){				
				if ($row->flagUpdated || $row->flagDeleted){
					$sql[] = $row->getSQLstring();
					// print_r($sql);die();
				}
			}
		};
		
		$sql[] = "SET AUTOCOMMIT = 1;";
		$sql[] = 'COMMIT;';				

		$sqlSuccess = $this->doSQL($sql);
				
		if($mode=='post'){
			$this->post();
		}
		
		return($sqlSuccess);
				
	}
	
	function post(){
	
		GLOBAL $Activities;
		GLOBAL $YACT;
		GLOBAL $Items;
		
		$this->refresh($this->ID);		
		$oMaster = new Master($this->scenario, $this->GUID);
			
			if(is_array($this->records[$this->gridName])){
				foreach($this->records[$this->gridName] as $id=>$record){
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->profit;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					$master_row->sales = $record->sales;				
					
					$activity = $Activities->getByCode($record->activity);
					$account = $activity->YACT;
					
					$master_row->account = $account;
					$master_row->item = $activity->item_income;
					for($m=1;$m<=$this->budget->length;$m++){
						// $month = date('M',mktime(0,0,0,$m,15));
						$month = $this->budget->arrPeriod[$m];	
						$master_row->{$month} = ($record->{$month})*$record->selling_rate*$this->settings[strtolower($record->selling_curr)];
					}				
					
					if ($record->buying_rate!=0){
						$master_row = $oMaster->add_master();
						$master_row->profit = $this->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;				
						$master_row->sales = $record->sales;
						
						$activity = $Activities->getByCode($record->activity);
						$account = 'J00802';
						
						$master_row->account = $account;
						$master_row->item = $activity->item_cost;
						for($m=1;$m<=$this->budget->length;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];	
							$master_row->{$month} = -($record->{$month})*$record->buying_rate*$this->settings[strtolower($record->buying_curr)];
						}
					}
					
					if ($record->product==Product::OFT_Import || $record->product==Product::OFT_Export){
						$master_row = $oMaster->add_master();	
						$master_row->profit = $this->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;				
						$master_row->sales = $record->sales;
						
						$activity = $Activities->getByCode($record->activity);
						$account = $activity->YACT;
						
						//$master_row->item = Items::PROFIT_SHARE;
						$item = $Items->getById(Items::PROFIT_SHARE);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item->id;
						
						for($m=1;$m<=$this->budget->length;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];	
							$master_row->{$month} = -($record->{$month})*($record->selling_rate*$this->settings[strtolower($record->selling_curr)]-$record->buying_rate*$this->settings[strtolower($record->buying_curr)])/2;
						}
					}
					
					if ($this->ps_profit && $this->ps_rate){
					
						//------------------------------------------Deduct PS from main department-----------------
						$master_row = $oMaster->add_master();	
						$master_row->profit = $this->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;				
						$master_row->sales = $record->sales;
						
						$activity = $Activities->getByCode($record->activity);
						$account = $activity->YACT;
						
						//$master_row->item = Items::PROFIT_SHARE;
						$item = $Items->getById(Items::INTERCOMPANY_COSTS);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item->id;
						
						for($m=1;$m<=$this->budget->length;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];	
							$master_row->{$month} = -($record->{$month})*($record->selling_rate*$this->settings[strtolower($record->selling_curr)]-$record->buying_rate*$this->settings[strtolower($record->buying_curr)])*$this->ps_rate/100;
						}
						
						//------------------------------------------Elimination of costs-----------------
						$master_row = $oMaster->add_master();	
						$master_row->profit = 99;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;				
						$master_row->sales = $record->sales;
						
						$activity = $Activities->getByCode($record->activity);
						$account = $activity->YACT;
						
						//$master_row->item = Items::PROFIT_SHARE;
						$item = $Items->getById(Items::INTERCOMPANY_COSTS);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item->id;
						
						for($m=1;$m<=$this->budget->length;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];	
							$master_row->{$month} = ($record->{$month})*($record->selling_rate*$this->settings[strtolower($record->selling_curr)]-$record->buying_rate*$this->settings[strtolower($record->buying_curr)])*$this->ps_rate/100;
						}
						
						//------------------------------------------Create income for supplementary department-----------------
						$master_row = $oMaster->add_master();	
						$master_row->profit = $this->ps_profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;				
						$master_row->sales = $record->sales;
						
						$activity = $Activities->getByCode($record->activity);
						$account = $activity->YACT;
						
						//$master_row->item = Items::PROFIT_SHARE;
						$item = $Items->getById(Items::INTERCOMPANY_REVENUE);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item->id;
						
						for($m=1;$m<=$this->budget->length;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];	
							$master_row->{$month} = ($record->{$month})*($record->selling_rate*$this->settings[strtolower($record->selling_curr)]-$record->buying_rate*$this->settings[strtolower($record->buying_curr)])*$this->ps_rate/100;
						}
						
						//------------------------------------------Elimination of income-----------------
						$master_row = $oMaster->add_master();	
						$master_row->profit = 99;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;				
						$master_row->sales = $record->sales;
						
						$activity = $Activities->getByCode($record->activity);
						$account = $activity->YACT;
						
						//$master_row->item = Items::PROFIT_SHARE;
						$item = $Items->getById(Items::INTERCOMPANY_REVENUE);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item->id;
						
						for($m=1;$m<=$this->budget->length;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];	
							$master_row->{$month} = -($record->{$month})*($record->selling_rate*$this->settings[strtolower($record->selling_curr)]-$record->buying_rate*$this->settings[strtolower($record->buying_curr)])*$this->ps_rate/100;
						}
						
					}
					
				}
				$oMaster->save();
				$this->markPosted();				
			}		
	}
	
}



?>


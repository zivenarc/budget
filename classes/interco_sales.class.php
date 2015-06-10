<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('classes/sales_record.class.php');
include_once ('../common/eiseGrid/inc_eiseGrid.php');
include_once ('classes/item.class.php');
include_once ('classes/product.class.php');
include_once ('classes/yact_coa.class.php');

$Products = new Products ();
$Activities = new Activities ();
$YACT = new YACT_COA();

$arrJS[] = '../common/eiseGrid/eiseGrid.js';
$arrCSS[] = '../common/eiseGrid/eiseGrid.css';

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
			,'sql'=>'
				SELECT 
				PRD1.prdID AS optValue, PRD1.prdTitle AS optText, PRD1.prdParentID
				, COUNT(DISTINCT PRD2.prdID) as prdLevelInside     
				FROM vw_product PRD1 INNER JOIN vw_product PRD2 ON PRD2.prdIdxLeft<=PRD1.prdIdxLeft AND PRD2.prdIdxRight>=PRD1.prdIdxRight
				WHERE PRD1.prdIdxRight-PRD1.prdIdxLeft>1
				GROUP BY PRD1.prdID
				HAVING prdLevelInside=1'
			,'default'=>22
			, 'disabled'=>!$this->flagUpdate
		);
		$this->Columns[] = Array(
			'title'=>'Comments'
			,'field'=>self::Prefix.'Comment'
			,'type'=>'text'
			, 'disabled'=>!$this->flagUpdate
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
			'title'=>'Code'
			,'field'=>'prdExternalID'
			,'type'=>'text'
			,'disabled'=>true
		);
		
		$grid->Columns[] = parent::getProductEG();
		
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
		
		if (!$this->flagPosted){		
			$grid->Columns[] =Array(
				'title'=>"Formula"
				,'field'=>'formula'
				,'type'=>'text'
				,'mandatory'=>false
				
			);		
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
		} else {
			$grid->Columns[] = parent::getActivityEG();
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
		parent::fillGrid($this->grid,Array('prdExternalID'),'reg_sales LEFT JOIN vw_product ON prdID=product');
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
		if ($mode=='update' || $mode=='post'){
			$this->profit = isset($_POST[self::Prefix.'ProfitID'])?$_POST[self::Prefix.'ProfitID']:$this->profit;
			$this->product_folder = isset($_POST[self::Prefix.'ProductFolderID'])?$_POST[self::Prefix.'ProductFolderID']:$this->product_folder;
			$this->comment = isset($_POST[self::Prefix.'Comment'])?$_POST[self::Prefix.'Comment']:$this->comment;
			$this->customer = isset($_POST[self::Prefix.'CustomerID'])?$_POST[self::Prefix.'CustomerID']:$this->customer;
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
					$account = 'J00400';			
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
					$account = 'J00802';
					
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
					$account = 'J00802';
					
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
					$account = 'J00400';
					
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
					$account = 'J00802';
					
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
					$account = 'J00802';
					
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


?>
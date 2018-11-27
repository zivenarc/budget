<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('classes/sales_record.class.php');
include_once ('classes/sales_ghq_record.class.php');
include_once ('classes/reference.class.php');
include_once ('classes/item.class.php');
include_once ('classes/product.class.php');
include_once ('classes/yact_coa.class.php');

$oProducts = new Products ();
$oActivities = new Activities ();
$oYACT = new YACT_COA();
$oItems = new Items();

class Sales extends Document{
	
	const PB_Ourselves=714;
	
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
		$this->route = $this->data['salRoute'];
		$this->job_owner = $this->data['salJO'];
		$this->destination_agent = $this->data['salDA'];
		$this->business_owner = $this->data['salBO'];
		$this->gbr = $this->data['salGBR'];
		$this->pol = $this->data['salPOL'];
		$this->pod = $this->data['salPOD'];
		$this->ghq = $this->data['salGHQ'];
		$this->new_biz = $this->data['salFlagNew'];
		
		
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
				$this->records[$this->gridName][$rw['id']] = new sales_record($this->GUID, $this->scenario, $this->company, $rw['id'], $rw);
				if ($rw['unit']=='TEU'&& $rw['kpi']){
					$this->arrTEU = $rw;
				}
				if ($rw['unit']=='Kgs'&& $rw['kpi']){
					$this->arrKgs = $rw;
				}
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
		
		// $this->Columns[] = Array(
			// 'title'=>'Product folder'
			// ,'field'=>self::Prefix.'ProductFolderID'
			// ,'type'=>'combobox'
			// ,'sql'=>'vw_folder'
			// ,'prefix'=>'prd'
			// ,'default'=>22
			// ,'disabled'=>!$this->flagUpdate
		// );
		
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
		
		if (strpos($this->ghq,'Ocean')!==false){
			$this->Columns[] = Array(
				'title'=>'Port of loading'
				,'field'=>self::Prefix.'POL'
				,'mandatory'=>true
				,'type'=>'ajax'
				,'table'=>'tbl_port'
				,'prefix'=>'prt'
				,'sql'=>'tbl_port'			
				,'disabled'=>!$this->flagUpdate			
			);
			
			$this->Columns[] = Array(
				'title'=>'Port of discharge'
				,'field'=>self::Prefix.'POD'
				,'mandatory'=>true
				,'type'=>'ajax'
				,'table'=>'tbl_port'
				,'prefix'=>'prt'
				,'sql'=>'tbl_port'			
				,'disabled'=>!$this->flagUpdate			
			);
		}
		
		if (strpos($this->ghq,'Ocean')!==false || strpos($this->ghq,'Air')!==false){
			$this->Columns[] = Array(
				'title'=>'Ocean/Air route'
				,'field'=>self::Prefix.'Route'
				,'mandatory'=>true
				,'type'=>'combobox'			
				,'prefix'=>'rte'
				,'sql'=>'tbl_route'
				,'mandatory'=>false
				,'default'=>2
				,'defaultText'=>'---Undefined---'
				,'disabled'=>!$this->flagUpdate
			);
			
			$this->Columns[] = Array(
				'title'=>'Job owner'
				,'field'=>self::Prefix.'JO'
				,'mandatory'=>true
				,'type'=>'ajax'
				,'table'=>'vw_pb_intercompany'
				,'prefix'=>'cnt'
				,'sql'=>'vw_pb_intercompany'			
				,'disabled'=>!$this->flagUpdate			
			);
			
			$this->Columns[] = Array(
				'title'=>'Business owner'
				,'field'=>self::Prefix.'BO'
				,'mandatory'=>true
				,'type'=>'ajax'
				,'table'=>'vw_pb_intercompany'
				,'prefix'=>'cnt'
				,'sql'=>'vw_pb_intercompany'			
				,'disabled'=>!$this->flagUpdate			
			);
			
			$this->Columns[] = Array(
				'title'=>'Destination agent'
				,'field'=>self::Prefix.'DA'
				,'mandatory'=>true
				,'type'=>'ajax'
				,'table'=>'vw_pb_intercompany'
				,'prefix'=>'cnt'
				,'sql'=>'vw_pb_intercompany'			
				,'disabled'=>!$this->flagUpdate			
			);
			
			$this->Columns[] = Array(
				'title'=>'SAP/GBR (USD per TEU)'
				,'field'=>self::Prefix.'GBR'
				,'type'=>'integer'		
				,'disabled'=>!$this->flagUpdate			
			);
		};

	}
	
	//==========================================Definition of document GRID ===================================================
	public function defineGrid(){
		
		GLOBAL $oProducts;
	
		if (!$this->data[self::Prefix.'CustomerID']){
			$this->grid->Columns[] = parent::getCustomerEG();
		}
		
		// $this->grid->Columns[] = Array(
			// 'title'=>'Code'
			// ,'field'=>'prdExternalID'
			// ,'width'=>'60px'
			// ,'type'=>'text'
			// ,'disabled'=>true
		// );
		
		// $this->grid->Columns[] = parent::getProductEG();
		$this->grid->Columns[] = parent::getActivityEG();
		
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
		
		$this->grid->Columns[] =Array(
				'title'=>"Gross billing"
				,'field'=>'hbl'
				,'type'=>'boolean'
				,'width'=>'35px'
				,'mandatory'=>false
				, 'disabled'=>$this->flagPosted
		);	
		
		
		if (!$this->flagPosted){		
			
			$this->setMonthlyEG('int');
			
		} else {
			//$this->grid->Columns[] = parent::getActivityEG();
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
		// parent::fillGrid($this->grid,Array('prdExternalID'),'reg_sales LEFT JOIN vw_product ON prdID=product');
		parent::fillGrid($this->grid,Array('prtGHQ'),'reg_sales LEFT JOIN vw_product_type ON prtID=activity');
	}
	
	
	public function save($mode='update'){
		
		GLOBAL $arrUsrData;

		
		parent::save($mode);
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if ($mode=='update' || $mode=='post'){
			$this->profit = isset($_POST[$this->prefix.'ProfitID'])?$_POST[$this->prefix.'ProfitID']:$this->profit;
			// $this->product_folder = isset($_POST[$this->prefix.'ProductFolderID'])?$_POST[$this->prefix.'ProductFolderID']:$this->product_folder;			
			$this->customer = isset($_POST[$this->prefix.'CustomerID'])?$_POST[$this->prefix.'CustomerID']:$this->customer;
			$this->sales = isset($_POST[$this->prefix.'UserID'])?$_POST[$this->prefix.'UserID']:$this->sales;
			$this->route = isset($_POST[$this->prefix.'Route'])?$_POST[$this->prefix.'Route']:$this->route;
			
			$this->job_owner = isset($_POST[$this->prefix.'JO'])?$_POST[$this->prefix.'JO']:$this->job_owner;
			$this->destination_agent = isset($_POST[$this->prefix.'DA'])?$_POST[$this->prefix.'DA']:$this->destination_agent;
			$this->business_owner = isset($_POST[$this->prefix.'BO'])?$_POST[$this->prefix.'BO']:$this->business_owner;
			$this->gbr = isset($_POST[$this->prefix.'GBR'])?$_POST[$this->prefix.'GBR']:$this->gbr;
			$this->pol = isset($_POST[$this->prefix.'POL'])?$_POST[$this->prefix.'POL']:$this->pol;
			$this->pod = isset($_POST[$this->prefix.'POD'])?$_POST[$this->prefix.'POD']:$this->pod;
			
			if (isset($_POST[$this->prefix.'ProfitID']) && count($this->records[$this->gridName])){
				foreach ($this->records[$this->gridName] as $id=>$row){
					$row = $this->get_record($id); 
					if ($row->profit!=$this->profit){		
						$row->flagUpdated = true; 
						// die('row #'.$id." updated	with profit value (".$this->profit.")");
						$row->profit = $this->profit;
					}
				}	 			
			}

			if ($this->customer && count($this->records[$this->gridName])){
				foreach ($this->records[$this->gridName] as $id=>$row){
					$row = $this->get_record($id);
					if ($row->customer!=$this->customer){
						$row->flagUpdated = true;				
						// die('row #'.$id." updated with customer value (".$this->customer.")");
						$row->customer = $this->customer;
					}
					if ($row->sales!=$this->sales){
						$row->flagUpdated = true;
						// echo '<pre>';print_r($row);echo '</pre>';
						// die('row #'.$id." updated with sales value (".$this->sales.")");						
						$row->sales = $this->sales;
					}
					if ($row->route!=$this->route){
						$row->flagUpdated = true;	
						// die('row #'.$id." updated with route value (".$this->route.")");							
						$row->route = $this->route;
					}
					
					if ($row->bo!=$this->business_owner){
						$row->flagUpdated = true;	
						// die('row #'.$id." updated with route value (".$this->route.")");							
						$row->bo = $this->business_owner;
					}
					
					if ($row->jo!=$this->job_owner){
						$row->flagUpdated = true;	
						// die('row #'.$id." updated with route value (".$this->route.")");							
						$row->jo = $this->job_owner;
					}
					
					if ($row->pol!=$this->pol){
						$row->flagUpdated = true;							
						$row->pol = $this->pol;
					}
					
					if ($row->pod!=$this->pod){
						$row->flagUpdated = true;							
						$row->pod = $this->pod;
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
						// $row->product = $_POST['product'][$id];				
						$row->activity = $_POST['activity'][$id];				
						$row->customer = isset($_POST['customer'][$id])?$_POST['customer'][$id]:$this->customer;					
						$row->comment = $_POST['comment'][$id];				
						$row->selling_rate = (double)str_replace(',','',$_POST['selling_rate'][$id]);				
						$row->selling_curr = $_POST['selling_curr'][$id];				
						$row->buying_rate = (double)str_replace(',','',$_POST['buying_rate'][$id]);				
						$row->buying_curr = $_POST['buying_curr'][$id];				
						$row->formula = $_POST['formula'][$id];				
						$row->kpi = $_POST['kpi'][$id];				
						$row->hbl = $_POST['hbl'][$id];				
						$row->sales = $this->sales;				
						$row->bo = $this->business_owner;
						$row->jo = $this->job_owner;						
						$row->pol = $this->pol;						
						$row->pod = $this->pod;						
						$row->route = $this->route;	
						$row->gbr = $this->gbr?1:0;						
						$row->freehand = in_array($row->activity,Array(48,63,46,47,52,58)) && $this->business_owner==self::PB_Ourselves;				
						for ($m=1;$m<=15;$m++){							
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
		if(is_array($this->records[$this->gridName])){			
			foreach ($this->records[$this->gridName] as $i=>$row){
				if (!isset($sqlGHQ)){
					$sqlGHQ = "UPDATE `{$this->table}`, `common_db`.`tbl_product_type` 
								SET `{$this->prefix}GHQ`=`prtGHQ`
								WHERE `prtID`='{$row->activity}'
								AND `{$this->prefix}GUID`='{$this->GUID}';";
				};
				if ($row->flagUpdated || $row->flagDeleted){
					$sql[] = $row->getSQLstring();
				}
			}
			$sql[] = $sqlGHQ;
		};
		
		$sql[] = "SET AUTOCOMMIT = 1;";
		$sql[] = 'COMMIT;';				

		$sqlSuccess = $this->doSQL($sql);
				
		if($mode=='post'){
			$this->post();
		} else {
			$this->doSQL("DELETE FROM `reg_sales_rhq` WHERE source='{$this->GUID}'");	
		}
		
		return($sqlSuccess);
				
	}
	
	function post(){
	
		GLOBAL $oActivities;
		GLOBAL $oYACT;
		GLOBAL $oItems;
		GLOBAL $oBudget;
		
		$dateProjectBridge = strtotime('1 April 2016');				
		
		$this->refresh($this->ID);		
		$oMaster = new Master($this->scenario, $this->GUID, $this->company);
		
		$oSalesGHQ = new sales_ghq_record((array)$this);
		
		
			if(is_array($this->records[$this->gridName])){
				foreach($this->records[$this->gridName] as $id=>$record){
					
					// echo '<pre>';print_r($record);echo '</pre>';
					
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->profit;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					$master_row->sales = $record->sales;				
					
					$activity = $oActivities->getByCode($record->activity);
					$master_row->item = $activity->item_income;
					
					$account = $activity->YACT;
					$master_row->account = $account;
					
					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];	
						$master_row->{$month} = ($record->{$month})*$record->selling_rate*$this->settings[strtolower($record->selling_curr)];
												
						//------Update for Project bridge since 1st April 2016-----------
						$current_month_start = mktime(0,0,0,$m,1,$oBudget->year);
						if ($current_month_start>=$dateProjectBridge && $this->job_owner!=self::PB_Ourselves){							
							if ($record->hbl){							
								if (!isset($freight_r_row)){
									$freight_r_row = $oMaster->add_master();
								}
								// $freight_r_row->item = $activity->item_cost;
								$freight_r_row->item = $oItems::PROFIT_SHARE_COST;
								$freight_r_row->account = 'J00400';
								$freight_r_row->profit = $this->profit;
								$freight_r_row->activity = in_array($record->activity,Array(46))?$oActivities::AFIGB:$oActivities::OFIGB;
								$freight_r_row->customer = $record->customer;				
								$freight_r_row->sales = $record->sales;	
								$freight_r_row->{$month} -= ($record->{$month})*$record->selling_rate*$this->settings[strtolower($record->selling_curr)];
								//$master_row->{$month} = 0;
								
								
								
							} else{
								// leave it alone
							}
						}
						
					}		

					$oSalesGHQ->addRecord(Array('ghq'=>$activity->GHQ,'account'=>$activity->YACT_Title),(array)$master_row);
					$oSalesGHQ->addRecord(Array('ghq'=>$activity->GHQ,'account'=>$activity->YACT_Title),(array)$freight_r_row);
					
					if ($record->buying_rate!=0){
						$master_row = $oMaster->add_master();
						$master_row->profit = $this->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;				
						$master_row->sales = $record->sales;
						
						$activity = $oActivities->getByCode($record->activity);
						$master_row->item = $activity->item_cost;
						
						$item = $oItems->getById($master_row->item);
						$master_row->account = $item->YACT;
						
						// $account = 'J00802';
						// $master_row->account = $account;
						
						for($m=1;$m<=15;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];	
							$master_row->{$month} = -($record->{$month})*$record->buying_rate*$this->settings[strtolower($record->buying_curr)];
							
							//------Update for Project bridge since 1st April 2016-----------
							$current_month_start = mktime(0,0,0,$m,1,$oBudget->year);
							if ($current_month_start>=$dateProjectBridge && $this->job_owner!=self::PB_Ourselves){
								if ($record->hbl){
									if (!isset($freight_c_row)){
										$freight_c_row = $oMaster->add_master();
									}					
									$freight_c_row->item = $activity->item_cost;
									$freight_c_row->item =  $oItems::PROFIT_SHARE_COST;
									$freight_c_row->account = 'J00400';
									$freight_c_row->profit = $this->profit;
									$freight_c_row->activity = in_array($record->activity,Array(46))?$oActivities::AFIGB:$oActivities::OFIGB;
									$freight_c_row->customer = $record->customer;				
									$freight_c_row->sales = $record->sales;	
									$freight_c_row->{$month} += ($record->{$month})*$record->buying_rate*$this->settings[strtolower($record->buying_curr)];
									//$master_row->{$month} = 0;
									} else {
									// leave it alone
								}
							}
							
						}
						
						$oSalesGHQ->addRecord(Array('ghq'=>$activity->GHQ,'account'=>$item->YACT_Title),(array)$master_row);
						$oSalesGHQ->addRecord(Array('ghq'=>$activity->GHQ,'account'=>$activity->YACT_Title),(array)$freight_c_row);	
						
					}
					
					if ($record->hbl){
					
						$flagProjectBridge = true;
					
						$master_row = $oMaster->add_master();	
						$master_row->profit = $this->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;				
						$master_row->sales = $record->sales;
						
						$activity = $oActivities->getByCode($record->activity);
						$account = $activity->YACT;
						
						$item = $oItems->getById(Items::PROFIT_SHARE);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item->id;
						
						for($m=1;$m<=15;$m++){
							$month = $this->budget->arrPeriod[$m];	
							$master_row->{$month} = -($record->{$month})*($record->selling_rate*$this->settings[strtolower($record->selling_curr)]-$record->buying_rate*$this->settings[strtolower($record->buying_curr)])/2;
							//------Update for Project bridge since 1st April 2016-----------
							$current_month_start = mktime(0,0,0,$m,1,$oBudget->year);
							if ($current_month_start>=$dateProjectBridge){
								$master_row->{$month} = 0;	// do not calculate Profit share							
							}
						}
					} else {
						$flagProjectBridge = false;
					}
					
					if ($flagProjectBridge){
										
						for($m=1;$m<=15;$m++){
							$month = $this->budget->arrPeriod[$m];	
							$arrGP[$month] = ($record->{$month})*($record->selling_rate*$this->settings[strtolower($record->selling_curr)] - $record->buying_rate*$this->settings[strtolower($record->buying_curr)]);
						}
						
						if ($this->gbr){
							//////////////////////// SAP/GBR scheme. OFT loss to be compensated and rate per TEU to be paid
							$SCC = $this->gbr;
							// OFT loss compensation	
							$master_row = $oMaster->add_master();	
							$master_row->profit = $this->profit;
							$activity = ($this->destination_agent==self::PB_Ourselves?$oActivities::OFIGB:$record->activity);
							$master_row->activity = $activity;
							$master_row->customer = $record->customer;				
							$master_row->sales = $record->sales;
							$item = $oItems->getById(Items::REVENUE);
							$master_row->account = 'J00400';
							$master_row->item = $item->id;
							for($m=1;$m<=15;$m++){
								$month = $this->budget->arrPeriod[$m];
								if($arrGP[$month]) { 
									$master_row->{$month} = -$arrGP[$month];
								}
							}
							//SAP rate per TEU
							$master_row = $oMaster->add_master();	
							$master_row->profit = $this->profit;
							$activity = ($this->destination_agent==self::PB_Ourselves?$oActivities::OFICOM:$oActivities::OFECOM);
							$master_row->activity = $activity;
							$master_row->customer = $record->customer;				
							$master_row->sales = $record->sales;					
							$item = $oItems->getById(Items::REVENUE);
							$master_row->account = 'J00400';
							$master_row->item = $item->id;
							for($m=1;$m<=15;$m++){
								$month = $this->budget->arrPeriod[$m];								
								if(is_array($this->arrTEU)) $master_row->{$month} = ($this->arrTEU[$month])*$SCC*$this->settings['usd'];
							}
							
							$oSalesGHQ->gbr = true;
							$oSalesGHQ->addRecord(Array('ghq'=>$activity->GHQ,'account'=>"Profit Share as BO"),(array)$master_row);	
						
						} elseif($this->settings['PS_Scheme']=='PS2018'){
							$arrProfit = Array();
							//Profit share for 2018 and onwards
							if($this->job_owner!=self::PB_Ourselves){ //Import commissions
								if($this->business_owner==self::PB_Ourselves){ 
									$master_row = $oMaster->add_master();	
									$master_row->profit = $this->profit;
									$master_row->activity = $record->activity;
									$master_row->customer = $record->customer;				
									$master_row->sales = $record->sales;
									$activity = $oActivities->getByCode($record->activity);
									$account = $activity->YACT;
									$item = $oItems->getById(Items::PROFIT_SHARE_COST);
									$master_row->account = 'J00400';
									$master_row->item = $item->id;
									for($m=1;$m<=15;$m++){
										$month = $this->budget->arrPeriod[$m];
										$master_row->{$month} = 0.4 * $arrGP[$month];
									}	
								}
								$oSalesGHQ->addRecord(Array('ghq'=>$activity->GHQ,'account'=>"Profit Share as BO"),(array)$master_row);	
								
								if($this->destination_agent==self::PB_Ourselves){
									$master_row = $oMaster->add_master();	
									$master_row->profit = $this->profit;
									$master_row->activity = $record->activity;
									$master_row->customer = $record->customer;				
									$master_row->sales = $record->sales;
									$activity = $oActivities->getByCode($record->activity);
									$account = $activity->YACT;
									$item = $oItems->getById(Items::PROFIT_SHARE_COST);
									$master_row->account = 'J00400';
									$master_row->item = $item->id;
									for($m=1;$m<=15;$m++){
										$month = $this->budget->arrPeriod[$m];
										$master_row->{$month} = 0.2 * $arrGP[$month];
									}	
								}
								$oSalesGHQ->addRecord(Array('ghq'=>$activity->GHQ,'account'=>"Profit Share as DA"),(array)$master_row);	
								
							} else { //export commissions
								if($this->business_owner!=self::PB_Ourselves){ 
									$master_row = $oMaster->add_master();	
									$master_row->profit = $this->profit;
									$master_row->activity = $record->activity;
									$master_row->customer = $record->customer;				
									$master_row->sales = $record->sales;
									$activity = $oActivities->getByCode($record->activity);
									$account = $activity->YACT;
									$item = $oItems->getById(Items::PROFIT_SHARE_COST);
									$master_row->account = '523000';
									$master_row->item = $item->id;
									for($m=1;$m<=15;$m++){
										$month = $this->budget->arrPeriod[$m];
										$master_row->{$month} = -0.4 * $arrGP[$month];
									}

									$oSalesGHQ->addRecord(Array('ghq'=>$activity->GHQ,'account'=>"COS Profit Share to BO"),(array)$master_row);	
									
								}
								if($this->destination_agent!=self::PB_Ourselves){ 
									$master_row = $oMaster->add_master();	
									$master_row->profit = $this->profit;
									$master_row->activity = $record->activity;
									$master_row->customer = $record->customer;				
									$master_row->sales = $record->sales;
									$activity = $oActivities->getByCode($record->activity);
									$account = $activity->YACT;
									$item = $oItems->getById(Items::PROFIT_SHARE_COST);
									$master_row->account = 'J00802';
									$master_row->item = $item->id;
									for($m=1;$m<=15;$m++){
										$month = $this->budget->arrPeriod[$m];
										$master_row->{$month} = -0.2 * $arrGP[$month];
									}
									
									$oSalesGHQ->addRecord(Array('ghq'=>$activity->GHQ,'account'=>"COS Profit Share to DA"),(array)$master_row);	
								}
							}								
						}  else {
							
							///////////////////////////////////////////////////////// OLD OFF/AFF scheme before 1/04/2018
							
							$sql = "SELECT * FROM tbl_route WHERE rteID=".(integer)$this->route;
							$rs = $this->oSQL->q($sql);
							$arrRoute = $this->oSQL->f($rs);
							$SCC_OFF = $arrRoute['rteSC_OFF'];
							$SCC_AFF = $arrRoute['rteSC_AFF'];
							
							//------- Sales commission receivable ----------
							if ($this->job_owner!=self::PB_Ourselves && $this->business_owner==self::PB_Ourselves){
								$master_row = $oMaster->add_master();
								$master_row->profit = $this->profit;
								$master_row->activity =is_array($this->arrTEU)?$oActivities::OFICOM:(is_array($this->arrKgs)?$oActivities::AFICOM:$record->activity);
								$master_row->customer = $record->customer;				
								$master_row->sales = $record->sales;
								
								$activity = $oActivities->getByCode($master_row->activity);
								$account = $activity->YACT;
								
								//$master_row->item = Items::PROFIT_SHARE;
								$item = $oItems->getById(Items::REVENUE);
								$master_row->account = $item->getYACT($master_row->profit);
								$master_row->item = $item->id;
								
								for($m=1;$m<=15;$m++){
									// $month = date('M',mktime(0,0,0,$m,15));
									$month = $this->budget->arrPeriod[$m];									
									//------Update for Project bridge since 1st April 2016-----------
									$current_month_start = mktime(0,0,0,$m,1,$oBudget->year);
									if ($current_month_start>=$dateProjectBridge){										
										if(is_array($this->arrTEU)) $master_row->{$month} = ($this->arrTEU[$month])*$SCC_OFF*$this->settings['usd'];
										if(is_array($this->arrKgs)) $master_row->{$month} = ($this->arrKgs[$month])*$SCC_AFF*$this->settings['jpy'];
									} else {
										$master_row->{$month} = 0;	// do not calculate Profit share						
									}
								}
							} elseif ($this->job_owner==self::PB_Ourselves && $this->business_owner!=self::PB_Ourselves) {
								$master_row = $oMaster->add_master();
								$master_row->profit = $this->profit;
								$master_row->activity =is_array($this->arrTEU)?$oActivities::OFECOM:(is_array($this->arrKgs)?$oActivities::AFECOM:$record->activity);
								$master_row->customer = $record->customer;				
								$master_row->sales = $record->sales;
								
								$activity = $oActivities->getByCode($master_row->activity);
								$account = $activity->YACT;
								
								//$master_row->item = Items::PROFIT_SHARE;
								$item = $oItems->getById(Items::PROFIT_SHARE);
								$master_row->account = $item->getYACT($master_row->profit);
								$master_row->item = $item->id;
								
								for($m=1;$m<=15;$m++){
									// $month = date('M',mktime(0,0,0,$m,15));
									$month = $this->budget->arrPeriod[$m];									
									//------Update for Project bridge since 1st April 2016-----------
									$current_month_start = mktime(0,0,0,$m,1,$oBudget->year);
									if ($current_month_start>=$dateProjectBridge){										
										if(is_array($this->arrTEU)) $master_row->{$month} = -($this->arrTEU[$month])*$SCC_OFF*$this->settings['usd'];
										if(is_array($this->arrKgs)) $master_row->{$month} = -($this->arrKgs[$month])*$SCC_AFF*$this->settings['jpy'];
									} else {
										$master_row->{$month} = 0;	// do not calculate Profit share						
									}
								}
							} else {
								// no SSC in our books
							}
							//------- Destination handling charge
							if ($this->job_owner!=self::PB_Ourselves && $this->destination_agent==self::PB_Ourselves && !$this->gbr){
								$master_row = $oMaster->add_master();
								$master_row->profit = $this->profit;
								$master_row->activity = is_array($this->arrTEU)?$oActivities::OFICOM:(is_array($this->arrKgs)?$oActivities::AFICOM:$record->activity);
								$master_row->customer = $record->customer;				
								$master_row->sales = $record->sales;
								
								$activity = $oActivities->getByCode($master_row->activity);
								$account = $activity->YACT;
								
								//$master_row->item = Items::PROFIT_SHARE;
								$item = $oItems->getById(Items::REVENUE);
								$master_row->account = $item->getYACT($master_row->profit);
								$master_row->item = $item->id;
								
								for($m=1;$m<=15;$m++){
									// $month = date('M',mktime(0,0,0,$m,15));
									$month = $this->budget->arrPeriod[$m];									
									//------Update for Project bridge since 1st April 2016-----------
									$current_month_start = mktime(0,0,0,$m,1,$oBudget->year);
									if ($current_month_start>=$dateProjectBridge){										
										if(is_array($this->arrTEU)) $master_row->{$month} = ($this->arrTEU[$month])*6*$this->settings['usd'];
										if(is_array($this->arrKgs)) $master_row->{$month} = 750*$this->settings['jpy'];
									} else {
										$master_row->{$month} = 0;	// do not calculate Profit share						
									}
								}
							} elseif ($this->job_owner==self::PB_Ourselves && $this->destination_agent!=self::PB_Ourselves) {
								$master_row = $oMaster->add_master();
								$master_row->profit = $this->profit;
								$master_row->activity = is_array($this->arrTEU)?$oActivities::OFECOM:(is_array($this->arrKgs)?$oActivities::AFECOM:$record->activity);
								$master_row->customer = $record->customer;				
								$master_row->sales = $record->sales;
								
								$activity = $oActivities->getByCode($master_row->activity);
								$account = $activity->YACT;
								
								//$master_row->item = Items::PROFIT_SHARE;
								$item = $oItems->getById(Items::DIRECT_COSTS);
								$master_row->account = $item->getYACT($master_row->profit);
								$master_row->item = $item->id;
								
								for($m=1;$m<=15;$m++){
									// $month = date('M',mktime(0,0,0,$m,15));
									$month = $this->budget->arrPeriod[$m];									
									//------Update for Project bridge since 1st April 2016-----------
									$current_month_start = mktime(0,0,0,$m,1,$oBudget->year);
									if ($current_month_start>=$dateProjectBridge){										
										if(is_array($this->arrTEU)) $master_row->{$month} = -($this->arrTEU[$month])*6*$this->settings['usd'];
										if(is_array($this->arrKgs)) $master_row->{$month} = -750*$this->settings['jpy'];
									} else {
										$master_row->{$month} = 0;	// do not calculate Profit share						
									}
								}
							} else {
								// no DHC in our books
							}
						}
					}
					
					if ($this->ps_profit && $this->ps_rate){
					
						//------------------------------------------Deduct PS from main department-----------------
						$master_row = $oMaster->add_master();	
						$master_row->profit = $this->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;				
						$master_row->sales = $record->sales;
						
						$activity = $oActivities->getByCode($record->activity);
						$account = $activity->YACT;
						
						//$master_row->item = Items::PROFIT_SHARE;
						$item = $oItems->getById(Items::INTERCOMPANY_COSTS);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item->id;
						
						for($m=1;$m<=15;$m++){
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
						
						$activity = $oActivities->getByCode($record->activity);
						$account = $activity->YACT;
						
						//$master_row->item = Items::PROFIT_SHARE;
						$item = $oItems->getById(Items::INTERCOMPANY_COSTS);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item->id;
						
						for($m=1;$m<=15;$m++){
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
						
						$activity = $oActivities->getByCode($record->activity);
						$account = $activity->YACT;
						
						//$master_row->item = Items::PROFIT_SHARE;
						$item = $oItems->getById(Items::INTERCOMPANY_REVENUE);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item->id;
						
						for($m=1;$m<=15;$m++){
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
						
						$activity = $oActivities->getByCode($record->activity);
						$account = $activity->YACT;
						
						//$master_row->item = Items::PROFIT_SHARE;
						$item = $oItems->getById(Items::INTERCOMPANY_REVENUE);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $item->id;
						
						for($m=1;$m<=15;$m++){
							// $month = date('M',mktime(0,0,0,$m,15));
							$month = $this->budget->arrPeriod[$m];	
							$master_row->{$month} = -($record->{$month})*($record->selling_rate*$this->settings[strtolower($record->selling_curr)]-$record->buying_rate*$this->settings[strtolower($record->buying_curr)])*$this->ps_rate/100;
						}
						
					}
					
				}
				$oMaster->save();
				
				$arrSalesGHQ = $oSalesGHQ->getSQL();
				for($i=0;$i<count($arrSalesGHQ);$i++){
					$this->doSQL($arrSalesGHQ[$i]);
				};
				
				$this->doSQL("UPDATE `{$this->table}`, (SELECT SUM(".$this->budget->getYTDSQL(1+$this->budget->offset,max($this->budget->length,12+$this->budget->offset)).") as Total, source 
							FROM reg_master 
							WHERE item='".Items::REVENUE."' 
							GROUP BY source) Budget 
							SET `{$this->prefix}Revenue`=`Budget`.`Total`
							WHERE `{$this->prefix}ID`={$this->ID} 
							AND `{$this->prefix}GUID`=`Budget`.`source`;");
				
				$this->doSQL("UPDATE reg_master SET `new`=".(integer)$this->new_biz." WHERE source='".$this->GUID."';");
				$this->doSQL("UPDATE reg_sales SET `new`=".(integer)$this->new_biz." WHERE source='".$this->GUID."';");
				
				$this->doSQL("UPDATE tbl_sales
							SET salKg=(SELECT SUM(".$this->budget->getYTDSQL($this->budget->cm, max($this->budget->length,12+$this->budget->offset)).") FROM reg_sales
									   WHERE source=salGUID AND activity IN (46,47) and kpi=1),
								salTEU=(SELECT SUM(".$this->budget->getYTDSQL($this->budget->cm, max($this->budget->length,12+$this->budget->offset)).") FROM reg_sales
									   WHERE source=salGUID AND activity IN (48,58,63,52) and kpi=1)
							WHERE `{$this->prefix}ID`={$this->ID}");
				
				$this->markPosted();				
			}		
	}
	
	function calc_commission(){
		
		if(!$this->flagPosted) return (false);
		
		if(is_array($this->records[$this->gridName])){
			foreach($this->records[$this->gridName] as $id=>$record){
				if ($record->hbl){
						if($this->gbr){
							$SCC = $this->gbr;
						} else {
							$sql = "SELECT * FROM tbl_route WHERE rteID=".(integer)$this->route;
							$rs = $this->oSQL->q($sql);
							$arrRoute = $this->oSQL->f($rs);
							$SCC_OFF = $arrRoute['rteSC_OFF'];
							$SCC_AFF = $arrRoute['rteSC_AFF'];
						}
						
						//------- Sales commission receivable ----------
						if ($this->job_owner!=self::PB_Ourselves && $this->business_owner==self::PB_Ourselves){
							$amountOFF = 0;$amountAFF=0;
							for($m=1;$m<=15;$m++){
								$month = $this->budget->arrPeriod[$m];									
								$amountOFF += ($this->arrTEU[$month])*$SCC_OFF*$this->settings['usd'];
								$amountAFF += ($this->arrKgs[$month])*$SCC_AFF*$this->settings['jpy'];
							}
							if($amountOFF) $arrComm[] = Array('product'=>'OFI','charge'=>'SCC','type'=>'revenue','amount'=>$amountOFF);
							if($amountAFF) $arrComm[] = Array('product'=>'AFI','charge'=>'SCC','type'=>'revenue','amount'=>$amountAFF);
							
						} elseif ($this->job_owner==self::PB_Ourselves && $this->business_owner!=self::PB_Ourselves) {
							$amountOFF = 0;$amountAFF=0;
							for($m=1;$m<=15;$m++){
								$month = $this->budget->arrPeriod[$m];									
								$amountOFF += -($this->arrTEU[$month])*$arrRoute['rteSC_OFF']*$this->settings['usd'];
								$amountAFF += -($this->arrKgs[$month])*$arrRoute['rteSC_AFF']*$this->settings['jpy'];
							}
							if($amountOFF) $arrComm[] = Array('product'=>'OFE','charge'=>'SCC','type'=>'cost','amount'=>$amountOFF);
							if($amountAFF) $arrComm[] = Array('product'=>'AFE','charge'=>'SCC','type'=>'cost','amount'=>$amountAFF);
						} 
						
						//------- Destination handling charge
						if ($this->job_owner!=self::PB_Ourselves && $this->destination_agent==self::PB_Ourselves && !$this->gbr){
							$amountOFF = 0;$amountAFF=0;
							for($m=1;$m<=15;$m++){
								$month = $this->budget->arrPeriod[$m];																
								$amountOFF += ($this->arrTEU[$month])*6*$this->settings['usd'];
								$amountAFF += 750*$this->settings['jpy'];
							}
							if($amountOFF) $arrComm[] = Array('product'=>'OFI','charge'=>'DHC','type'=>'revenue','amount'=>$amountOFF);
							if($amountAFF) $arrComm[] = Array('product'=>'AFI','charge'=>'DHC','type'=>'revenue','amount'=>$amountAFF);
							
						} elseif ($this->job_owner==self::PB_Ourselves && $this->destination_agent!=self::PB_Ourselves) {
							$amountOFF = 0;$amountAFF=0;
							for($m=1;$m<=15;$m++){
								$month = $this->budget->arrPeriod[$m];															
								$amountOFF += -($this->arrTEU[$month])*6*$this->settings['usd'];
								$amountAFF += -750*$this->settings['jpy'];
							}
							if($amountOFF) $arrComm[] = Array('product'=>'OFE','charge'=>'DHC','type'=>'cost','amount'=>$amountOFF);
							if($amountAFF) $arrComm[] = Array('product'=>'AFE','charge'=>'DHC','type'=>'cost','amount'=>$amountAFF);
						} else {
							// no DHC in our books
						}
				}
			}
		}
		
		return($arrComm);
		
		for($i=0;$i<count($arrComm);$i++){
			
		}
	}
	
}



?>


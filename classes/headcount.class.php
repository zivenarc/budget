<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('../common/eiseGrid/inc_eiseGrid.php');
include_once ('classes/headcount_record.class.php');
include_once ('classes/product.class.php');
include_once ('classes/item.class.php');
include_once ('classes/employees.class.php');
include_once ('classes/yact_coa.class.php');
include_once ('classes/profit.class.php');

$YACT = new YACT_COA();
$Items = new Items();
$ProfitCenters = new ProfitCenters();

$arrJS[] = '../common/eiseGrid/eiseGrid.js';
$arrCSS[] = '../common/eiseGrid/eiseGrid.css';

class Headcount extends Document{

	const Register='reg_headcount';
	const GridName = 'headcount';
	// const Prefix = 'cem';
	// const Table = 'tbl_current_employee';
	
	function __construct($id='', $type='current'){
		GLOBAL $strLocal;
		GLOBAL $arrUsrData;
		
		$this->gridName = self::GridName;		
		$this->register = self::Register;
		
		switch($type){
			case 'new':
				$this->table = 'tbl_new_employee';
				$this->prefix = 'nem';
			break;
			case 'current':
			default:
				$this->table = 'tbl_current_employee';
				$this->prefix = 'cem';
				break;
		}
		
		$this->type = $type;
		
		parent::__construct($id);
		
	}
	
	public function refresh($id){
		
		GLOBAl $ProfitCenters;
		
		$sqlWhere = $this->getSqlWhere($id);
				
		$sql = "SELECT ".$this->prefix.".*, usrTitle FROM `".$this->table."` ".$this->prefix."
				LEFT JOIN stbl_user ON `usrID`=`".$this->prefix."EditBy`
				WHERE $sqlWhere";
		
		parent::refresh($sql);
				
		$this->pc = $ProfitCenters->getByCode($this->profit);
		$this->overtime = $this->data[$this->prefix.'Overtime'];
		$this->turnover = $this->data[$this->prefix.'Turnover'];
		
		if($this->GUID){
			$sql = "SELECT * FROM `".self::Register."` WHERE `source`='".$this->GUID."';";
			$rs = $this->oSQL->q($sql);			
			while($rw = $this->oSQL->f($rs)){
				$this->records[$this->gridName][$rw['id']] = new headcount_record($this->GUID, $this->scenario, $rw['id'], $rw);
			}		
		}
	}
	
	public function defineEF(){
	
		global $arrUsrData;

		parent::defineEF();
		
		if ($this->type=='current'){
			$this->Columns[] = Array(
				'title'=>'Turnover ratio, %'
				,'field'=>$this->prefix.'Turnover'			
				,'type'=>'int'
				, 'disabled'=>!$this->flagUpdate				
			);
			
			$this->Columns[] = Array(
				'title'=>'Overtime ratio, %'
				,'field'=>$this->prefix.'Overtime'			
				,'type'=>'int'
				, 'disabled'=>!$this->flagUpdate
			);
		}
		
		$this->Columns[] = Array(
			'title'=>'Comments'
			,'field'=>$this->prefix.'Comment'
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
		
		// $grid->Columns[] = Array(
			// 'title'=>'Employee'
			// ,'field'=>'particulars'
			// ,'type'=>'ajax_dropdown'
			// ,'source'=>'vw_employee_select'
			// ,'prefix'=>'emp'
			// ,'sql'=>'SELECT empGUID1C as optValue, empTitleLocal as optText FROM vw_employee_select'
			// , 'disabled'=>false
		// );
		
		if ($this->type=='current'){
			$grid->Columns[] = Array(
				'title'=>'Employee'
				,'field'=>'particulars'
				,'type'=>'combobox'
				,'source'=>'vw_employee_select'
				,'prefix'=>'emp'
				,'sql'=>"SELECT empGUID1C as optValue, empTitleLocal as optText FROM vw_employee_select WHERE empProfitID={$this->profit}"
				, 'disabled'=>false
			);
		}
		
		if ($this->type=='new'){
			$grid->Columns[] = Array(
				'title'=>'Start date'
				,'field'=>'start_date'
				,'type'=>'date'				
				, 'disabled'=>false
			);
		}
		
		$grid->Columns[] = Array(
			'title'=>'Function'
			,'field'=>'function'
			,'type'=>'combobox'
			,'sql'=>"SELECT funGUID as optValue, funTitle as optText FROM vw_function"
			, 'disabled'=>false
		);
		
		$grid->Columns[] = Array(
			'title'=>'W/collar'
			,'field'=>'wc'
			,'type'=>'boolean'			
			, 'disabled'=>($this->type=='current')
		);
		
		$grid->Columns[] = Array(
			'title'=>'VKS'
			,'field'=>'vks'
			,'type'=>'boolean'			
			, 'disabled'=>false
		);
		
		$grid->Columns[] = Array(
			'title'=>'Location'
			,'field'=>'location'
			,'type'=>'combobox'
			,'sql'=>"SELECT locID as optValue, locTitle as optText FROM vw_location"
			,'default'=>$this->pc->location
			, 'disabled'=>false
		);
		
		$grid->Columns[] = parent::getActivityEG();
		
		if ($this->type=='new'){
			$grid->Columns[] = Array(
				'title'=>'PC'
				,'field'=>'pc_profile'
				,'type'=>'combobox'				
				,'arrValues'=>Array(1=>'Desktop',2=>'Laptop',3=>'Full laptop set',0=>'None')
				,'default'=>1
				, 'disabled'=>false
			);
		}
		
		$grid->Columns[] =Array(
			'title'=>'Salary'
			,'field'=>'salary'
			,'type'=>'money'
			,'mandatory'=>true
			,'totals'=>true
		);
		
		$grid->Columns[] =Array(
			'title'=>'Mobile'
			,'field'=>'mobile_limit'
			,'type'=>'money'
			,'totals'=>true
			,'disabled'=>false
			,'totals'=>true
		);
		
		$grid->Columns[] =Array(
			'title'=>'Fuel'
			,'field'=>'fuel'
			,'type'=>'money'
			,'totals'=>true
			,'disabled'=>false
			,'totals'=>true
		);
		
		$grid->Columns[] =Array(
			'title'=>'DMS'
			,'field'=>'insurance'
			,'type'=>'money'
			,'totals'=>true
			,'disabled'=>false
			,'totals'=>true
		);
		
		if($this->type=='new'){
			$grid->Columns[] = Array(
				'title'=>'FTE'
				,'field'=>'new_fte'
				,'type'=>'int'
				, 'mandatory' => true
				, 'disabled'=>false
				,'totals'=>true
				,'default'=>0
				);	
		}
		
		for ($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
					
			$grid->Columns[] = Array(
			'title'=>''//$month------------------------ Title hidden
			,'field'=>strtolower($month)
			,'class'=>'budget-month'
			,'type'=>'int'
			, 'mandatory' => true
			, 'disabled'=>false
			,'totals'=>true
			,'default'=>1
			);		
		}
		
		$grid->Columns[] =Array(
			'title'=>'Average FTE'
			,'field'=>'AVG'
			,'type'=>'decimal'
			,'totals'=>true
			,'disabled'=>true
		);
		$this->grid = $grid;
		return ($grid);
	}
	

	public function add_record(){		
		$oBR = new headcount_record($this->GUID,$this->scenario);
		$this->records[$this->gridName][] = $oBR;
		return ($oBR);	
	}
	
	public function save($mode='update'){
		
		GLOBAL $arrUsrData;
		//GLOBAL $Activities;
		// GLOBAL $YACT;
		GLOBAL $Items;
		GLOBAL $oBudget;
		GLOBAL $ProfitCenters;
		
		if (!$this->ID){
			$this->Update();
			return(true);
		}
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if ($mode=='update' || $mode=='post') {
			$this->profit = isset($_POST[$this->prefix.'ProfitID'])?$_POST[$this->prefix.'ProfitID']:$this->profit;
			if (!$this->pc){
				$this->pc = $ProfitCenters->getByCode($this->profit);
			}
			$this->comment = isset($_POST[$this->prefix.'Comment'])?$_POST[$this->prefix.'Comment']:$this->comment;
			$this->overtime = isset($_POST[$this->prefix.'Overtime'])?$_POST[$this->prefix.'Overtime']:$this->overtime;
			$this->turnover = isset($_POST[$this->prefix.'Turnover'])?$_POST[$this->prefix.'Turnover']:$this->turnover;
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
						$row->comment = $_POST['comment'][$id];				
						$row->location = $_POST['location'][$id];				
						$row->activity = $_POST['activity'][$id];				
						$row->employee = $_POST['particulars'][$id];				
						$row->job = $_POST['function'][$id];				
						$row->pc_profile = $_POST['pc_profile'][$id];				
						$row->wc = (integer)$_POST['wc'][$id];
						$row->vks = (integer)$_POST['vks'][$id];			
						$row->insurance = str_replace(',','',$_POST['insurance'][$id]);							
						$row->salary = str_replace(',','',$_POST['salary'][$id]);							
						$row->mobile_limit = str_replace(',','',$_POST['mobile_limit'][$id]);							
						$row->fuel = str_replace(',','',$_POST['fuel'][$id]);
						if ($this->type=='new'){
							$row->start_date = isset($_POST['start_date'][$id])?date('Y-m-d',strtotime($_POST['start_date'][$id])):$row->start_date;							
							$row->new_fte = (integer)$_POST['new_fte'][$id];
						};
								
						$start_date = strtotime($_POST['start_date'][$id]);
								
						for ($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$current_month_start = mktime(0,0,0,$m,1,$oBudget->year);
							$current_month_end = mktime(0,0,0,$m+1,0,$oBudget->year);
							// echo date('d.m.Y',$start_date),';',date('d.m.Y',$current_month_start),"\r\n";
							if ($this->type=='current'){
								$row->{$month} = (integer)$_POST[strtolower($month)][$id];
							} else {
								if($start_date>$current_month_end){
									$row->{$month} = 0;
								} else {
									$row->hc = $_POST['new_fte'][$id]*(date('t',$current_month_start)-date('j',$start_date))/date('t',$current_month_start);							 
									// $row->{$month} = $hc;
									$row->{$month} = (integer)$_POST['new_fte'][$id];
								}
							
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
		$sql[] = "UPDATE `{$this->table}` 
				SET {$this->prefix}ProfitID=".(integer)$this->profit."
				,{$this->prefix}Comment=".$this->oSQL->e($this->comment)."				
				,{$this->prefix}Scenario='".$this->scenario."'
				,{$this->prefix}EditBy='".$arrUsrData['usrID']."'
				,{$this->prefix}EditDate=NOW()				
				WHERE {$this->prefix}ID={$this->ID};";
		if ($this->type=='current'){
			$sql[] = "UPDATE `{$this->table}` 
				SET {$this->prefix}Turnover=".(integer)$this->turnover."
				,{$this->prefix}Overtime=".(integer)$this->overtime."				
				WHERE {$this->prefix}ID={$this->ID};";
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
		// echo '<pre>';print_r($sql);echo '</pre>';
		$sqlSuccess = $this->doSQL($sql);
		
		if ($mode=='delete'){
			$this->delete();
		}
		
		if ($mode=='unpost'){
			$this->unpost();
		}
		
		if($mode=='post'){
			$this->refresh($this->ID);
			$oMaster = new budget_session($this->scenario, $this->GUID);
			
			if(is_array($this->records[$this->gridName])){
				foreach($this->records[$this->gridName] as $id=>$record){
				
					$eligible_date = mktime(0,0,0,10,1,$oMaster->budget->year-1);
					$start_date = strtotime($record->start_date);
					$probation = $start_date + 91*24*60*60;
					$eligible = ($start_date < $eligible_date) && ($settings['salary_review_month']>date('m',$oMaster->budget->date_start));

					//-----------------------------------------------------------------Salary, gross
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code; 
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;
					$master_row->particulars = $record->employee;
					$master_row->part_type = 'EMP';
					
					$master_row->item = Items::SALARY;
					
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;
					
					$social_tax = Array();					
					$salarySubtotal = 0;
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						
						
						if ($eligible) {						
							$salary[$month] = ($record->{$month})*$record->salary*($m<$settings['salary_review_month']?1:1+$settings['salary_increase_ratio']);
						} else {
							if ($this->type=='current'){
								$salary[$month] = ($record->{$month})*$record->salary;
							} else {
								$current_month_start = mktime(0,0,0,$m,1,$oBudget->year);
								$current_month_end = mktime(0,0,0,$m+1,0,$oBudget->year);
								if(date('YM',$start_date)==date('YM',$current_month_start)){
									$record->hc = $record->new_fte*(date('t',$current_month_start)-date('j',$start_date))/date('t',$current_month_start);							 
								} elseif($start_date<$current_month_start){
									$record->hc = $record->new_fte;
								} else {
									$record->hc = 0;
								}
								$salary[$month] = $record->hc*$record->salary;
							}
						}
						
						$salarySubtotal += $salary[$month];
						$master_row->{$month} = -$salary[$month];
						if ($salarySubtotal<$settings['social_cap']){
							$social_tax[$month] = ($settings['social_tax_1']*(1-$record->vks)+$settings['social_tax_accident']) * $salary[$month];
						} else {
							$social_tax[$month] = $settings['social_tax_accident'] * $salary[$month] 
												+ $settings['social_tax_1']*(1-$record->vks) * max(0,$settings['social_cap'] - ($salarySubtotal - $salary[$month])) 
												+ $settings['social_tax_2']*(1-$record->vks)* min($salary[$month],($salarySubtotal - $settings['social_cap']));
						}

						$hcCount[$month][$record->wc] += $record->{$month};
						$payroll[$month] += $salary[$month];
						
					}				
					
					//-----------------------------------------------------------------Social tax
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;					
					$master_row->particulars = $record->employee;
					$master_row->part_type = 'EMP';	
					$master_row->item = Items::SOCIAL_TAX;
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;
					
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = -$social_tax[$month];
					}
					
										
					//-----------------------------------------------------------------Mobile costs
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;
					$master_row->particulars = $record->employee;
					$master_row->part_type = 'EMP';					
					$master_row->item = Items::MOBILE;
					
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;
					
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = - $record->{$month}*$record->mobile_limit;
					}
					
					//-----------------------------------------------------------------IT Equipment
					if ($this->type=='new'){
						$master_row = $oMaster->add_master();
						$master_row->profit = $this->pc->code;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;
						// $master_row->particulars = $record->employee;
						// $master_row->part_type = 'EMP';					
						$master_row->item = Items::IT_EQUIPMENT;
						
						$oItem = $Items->getById($master_row->item);
						$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;
						
						for($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$next_month_start = mktime(0,0,0,$m+1,1,$oBudget->year);
							if(date('Ym',$start_date) < date('Ym',$next_month_start)){
								$master_row->{$month} = - $record->{$month}*$settings['pc_profile_'.$record->pc_profile]*$settings['usd']/36;
							}
							
						}
					}
					//-----------------------------------------------------------------Fuel costs
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;
					$master_row->particulars = $record->employee;
					$master_row->part_type = 'EMP';					
					$master_row->item = Items::FUEL;
					
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;
					
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = - $record->{$month}*$record->fuel;
					}
					
					//-----------------------------------------------------------------Bonus
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;
					$master_row->particulars = $record->employee;
					$master_row->part_type = 'EMP';					
					
					$master_row->item = Items::BONUS;
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;
					
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = - 	$salary[$month]
													*$settings['regular_bonus_avg']/100
													*$settings['regular_bonus_base']/100/3;
					}
					
					//-----------------------------------------------------------------Medical insurance
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;
					$master_row->activity = $record->activity;					
					$master_row->customer = $record->customer;
					$master_row->particulars = $record->employee;
					$master_row->part_type = 'EMP';					
					
					$master_row->item = Items::MEDICAL_INSURANCE;
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;
					
					$insurance_base = $record->insurance/12;
					$insurance_roy = $insurance_base*(1+$settings['medical_insurance_index']);
					$insurance_expiry = strtotime($settings['medical_insurance_expiry']);
					$ins_exp_day = date('j',$insurance_expiry);
					$ins_exp_month = date('n',$insurance_expiry);
					$ins_exp_full = date('t',$insurance_expiry);
					
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$month_start = mktime(0,0,0,$m,1,$oBudget->year);
						if ($probation<$month_start){
							if ($m == $ins_exp_month){
								$master_row->{$month} = - $record->{$month}
														*$insurance_base *($ins_exp_day/$ins_exp_full) ;
							} elseif ($m == $ins_exp_month+1){
								$master_row->{$month} = - $record->{$month} 
														*$insurance_roy	*(1+(($ins_exp_full-$ins_exp_day)/$ins_exp_full));
							} elseif ($m < $ins_exp_month){
								$master_row->{$month} = - $record->{$month}*$insurance_base;
							} else {
								$master_row->{$month} = - $record->{$month}*$insurance_roy;
							}
						}						
					}
					
					if ($this->type=='new'){
						//-----------------------------------------------------------------Hiring for newcomers
						$master_row = $oMaster->add_master();
						$master_row->profit = $this->pc->code;
						$master_row->activity = $record->activity;					
						$master_row->customer = $record->customer;
						$master_row->particulars = $record->employee;
						$master_row->part_type = 'EMP';	
						
						$master_row->item = Items::HIRING_COSTS;
						$oItem = $Items->getById($master_row->item);
						$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;
												
						
						for($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$month_start = mktime(0,0,0,$m,1,$oBudget->year);
							if (date('m.Y',$start_date)==date('m.Y',$month_start)){
								$master_row->{$month} = - abs($record->new_fte) * $settings['hiring'] * $record->salary * 12;							
							}						
						}
					}
					
				}//---end of record cycle
				
				//=================================================================Reserves on total headcount/payroll
				//-----------------------------------------------------------------Hiring (turnover reserve)
				if ($this->type=='current'){
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;
					// $master_row->activity = $record->activity;
					// $master_row->customer = $record->customer;					
					
					$master_row->item = Items::HIRING_COSTS;
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;

					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m,15));
						$master_row->{$month} = - $settings['hiring'] * $payroll[$month] * $this->turnover/100;
					}
				}
				//-----------------------------------------------------------------Overtime
				$master_row = $oMaster->add_master();
				$master_row->profit = $this->pc->code;
				// $master_row->activity = $record->activity;
				// $master_row->customer = $record->customer;					
				
				$master_row->item = Items::OVERTIME_WORK;
				$oItem = $Items->getById($master_row->item);
				$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;
					
				for($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					$master_row->{$month} = - $payroll[$month] * $this->overtime/100;
				}
				//-----------------------------------------------------------------Unused vacation accrual
				$master_row = $oMaster->add_master();
				$master_row->profit = $this->pc->code;
				// $master_row->activity = $record->activity;
				// $master_row->customer = $record->customer;								
				$master_row->item = Items::UNUSED_VACATION_ACCRUAL;
				$oItem = $Items->getById($master_row->item);
				$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;
					
				for($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					$master_row->{$month} = - 0.13 * $payroll[$month];
				}
				
				//-----------------------------------------------------------------Canteen
				$master_row = $oMaster->add_master();
				$master_row->profit = $this->pc->code;
				// $master_row->activity = $record->activity;
				// $master_row->customer = $record->customer;					
				$master_row->item = Items::CANTEEN;
				$oItem = $Items->getById($master_row->item);
				$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;				
				
				for($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					$master_row->{$month} = - $hcCount[$month][1]*$settings['canteen_wc'] - $hcCount[$month][0]*$settings['canteen_bc'];
				}
				
				$oMaster->save();
				$this->markPosted();
			}
		}
		
		return($sqlSuccess);
				
	}
	
	public function fillData($oBudget){
		
		if (is_array($this->records[$this->gridName])){
			foreach($this->records[$this->gridName] as $id=>$record){
				$record->flagDeleted = true;
			}
		}
		
		$dateEstStart = ($oBudget->year-2).'-10-01';
		$dateEstEnd = ($oBudget->year-1).'-09-30';
		
		
		$sql = "select empProfitID, SUM(case when (datediff(empStartDate, '{$dateEstStart}')<0 and datediff (ifnull(empEndDate, '9999-12-31'), '{$dateEstStart}')>0) THEN 1 ELSE 0 END) AS hc_opening,
				SUM(case when (datediff(empStartDate, '{$dateEstEnd}')<0 and datediff (ifnull(empEndDate, '9999-12-31'), '{$dateEstEnd}')>0) THEN 1 ELSE 0 END) AS hc_closing,
				SUM(case when (datediff(empEndDate, '{$dateEstStart}')>0 and datediff (empEndDate, '{$dateEstEnd}')<=0) THEN 1 ELSE 0 END) AS hc_dismissed
				from vw_employee WHERE empProfitID='{$this->pc->code}'
				group by empProfitID"; 
		
		$rs = $this->oSQL->q($sql);
		if ($rw=$this->oSQL->f($rs)){
			$turnover = ceil(100*$rw['hc_dismissed']/(($rw['hc_opening']+$rw['hc_closing'])/2));
			$this->turnover = min(15, $turnover );
			$this->comment = "Actual turnover for last year - {$turnover}%";
		}
		
		
		$sql = "SELECT *, (SELECT SUM(dmsPrice) FROM tbl_employee_insurance LEFT JOIN tbl_insurance ON dmsID=emdInsuranceID WHERE emdEmployeeID=empGUID1C) as insurance 
					FROM vw_employee_select WHERE empProfitID={$this->pc->code}";//die($sql);
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$row = $this->add_record();
			$row->flagUpdated = true;				
			$row->profit = $this->pc->code;
			$row->employee = $rw['empGUID1C'];				
			$row->job = $rw['empFunctionGUID'];
			$row->wc = $rw['funFlagWC'];				
			$row->location = $rw['empLocationID'];			
			$row->activity = $rw['empProductTypeID'];			
			$row->salary = $rw['empSalary'];
			$row->insurance = $rw['insurance'];
			$row->mobile_limit = $rw['empMobileLimit'];
			$row->fuel = $rw['funFuel'];
			for ($m=1;$m<13;$m++){
				$month = date('M',mktime(0,0,0,$m,15));
				$row->{$month} = $rw['empSalary']?1:0;
			}
		}	
	}
	
}



?>


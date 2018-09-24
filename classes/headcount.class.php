<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('classes/headcount_record.class.php');
include_once ('classes/product.class.php');
include_once ('classes/item.class.php');
include_once ('classes/employees.class.php');
include_once ('classes/yact_coa.class.php');
include_once ('classes/profit.class.php');

$YACT = new YACT_COA();
$Items = new Items();
$ProfitCenters = new ProfitCenters();
$Employees = new Employees();

class Headcount extends Document{

	const Register='reg_headcount';
	const GridName = 'headcount';
	// const Prefix = 'cem';
	// const Table = 'tbl_current_employee';
	
	function __construct($id='', $type='current'){
		GLOBAL $strLocal;
		GLOBAL $arrUsrData;
		
		$this->gridName = self::GridName;		
		$this->gridClass = 'headcount_record';		
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
		$this->bonus_corporate = $this->data[$this->prefix.'BonusCorporate'];
		$this->bonus_department = $this->data[$this->prefix.'BonusDepartment'];
		
		if($this->GUID){
			$sql = "SELECT * FROM `".self::Register."` WHERE `source`='".$this->GUID."';";
			$rs = $this->oSQL->q($sql);			
			while($rw = $this->oSQL->f($rs)){
				$this->records[$this->gridName][$rw['id']] = new headcount_record($this->GUID, $this->scenario,  $this->company, $rw['id'], $rw);
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
			$this->Columns[] = Array(
				'title'=>'Corporate bonus, %'
				,'field'=>$this->prefix.'BonusCorporate'			
				,'type'=>'int'
				, 'disabled'=>!$this->flagUpdate
			);
			$this->Columns[] = Array(
				'title'=>'Department bonus, %'
				,'field'=>$this->prefix.'BonusDepartment'			
				,'type'=>'int'
				, 'disabled'=>!$this->flagUpdate
			);
		}
		
		$this->Columns[] = $this->getResponsibleEF();
		
	}
	
	public function defineGrid(){
				
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
			$this->grid->Columns[] = Array(
				'title'=>'Employee'
				,'field'=>'particulars'
				,'type'=>'combobox'
				,'width'=>'200px'
				//,'source'=>'vw_employee_select'
				,'prefix'=>'emp'
				,'sql'=>"SELECT empGUID1C as optValue, empTitleLocal as optText FROM vw_employee_select WHERE empProfitID={$this->profit}"
				, 'disabled'=>false
			);
		}
		
		if ($this->type=='new'){
			$this->grid->Columns[] = Array(
				'title'=>'Start date'
				,'field'=>'start_date'
				,'type'=>'date'	
				,'width'=>'60px'				
				, 'disabled'=>false
			);
		}
		
		if ($this->type=='current'){
			$this->grid->Columns[] = Array(
				'title'=>'End date'
				,'field'=>'end_date'
				,'type'=>'date'				
				,'width'=>'60px'				
				, 'disabled'=>false
			);
			$this->grid->Columns[] =Array(
				'title'=>'Compensation'
				,'field'=>'compensation'
				,'type'=>'money'
				,'width'=>'70px'							
				,'mandatory'=>false
				,'totals'=>true
			);
		}
		
		$this->grid->Columns[] = Array(
			'title'=>'Function'
			,'field'=>'function'
			,'type'=>'combobox'
			,'width'=>'180px'				
			,'sql'=>"SELECT funGUID as optValue, funTitle as optText FROM vw_function"
			, 'disabled'=>false
		);
		
		$this->grid->Columns[] = Array(
			'title'=>'W/collar'
			,'field'=>'wc'
			,'type'=>'boolean'		
			,'width'=>'30px'							
			, 'disabled'=>false//($this->type=='current')
		);
		
		$this->grid->Columns[] = Array(
			'title'=>'SGA'
			,'field'=>'sga'
			,'type'=>'boolean'		
			,'width'=>'30px'							
			, 'disabled'=>($this->type=='current')
		);
		
		$this->grid->Columns[] = Array(
			'title'=>'VKS'
			,'field'=>'vks'
			,'type'=>'boolean'			
			,'width'=>'30px'							
			, 'disabled'=>false
		);
		
		$this->grid->Columns[] = Array(
			'title'=>'Location'
			,'field'=>'location'
			,'type'=>'combobox'
			,'width'=>'70px'							
			,'sql'=>"SELECT locID as optValue, locTitle as optText FROM vw_location"
			,'default'=>$this->pc->location
			, 'disabled'=>false
		);
		
		$this->grid->Columns[] = parent::getActivityEG();
		
		if ($this->type=='new'){
			$this->grid->Columns[] = Array(
				'title'=>'PC'
				,'field'=>'pc_profile'
				,'type'=>'combobox'				
				,'width'=>'80px'							
				,'arrValues'=>Array(1=>'Desktop',2=>'Laptop',3=>'Full laptop set',0=>'None')
				,'default'=>1
				, 'disabled'=>false
			);
		}
		
		$this->grid->Columns[] =Array(
			'title'=>'Salary'
			,'field'=>'salary'
			,'type'=>'money'
			,'width'=>'70px'							
			,'mandatory'=>true
			,'totals'=>true
		);
		
		$this->grid->Columns[] = Array(
			'title'=>'Review date'
			,'field'=>'review_date'
			,'type'=>'date'	
			,'width'=>'60px'				
			, 'disabled'=>true
		);
		
		$this->grid->Columns[] =Array(
			'title'=>'M.bonus'
			,'field'=>'monthly_bonus'
			,'type'=>'money'
			,'width'=>'70px'							
			,'mandatory'=>false
			,'totals'=>true
		);
		
		$this->grid->Columns[] =Array(
			'title'=>'Mobile'
			,'field'=>'mobile_limit'
			,'type'=>'money'
			,'width'=>'70px'							
			,'totals'=>true
			,'disabled'=>false
			,'totals'=>true
		);
		
		$this->grid->Columns[] =Array(
			'title'=>'Fuel'
			,'field'=>'fuel'
			,'type'=>'money'
			,'width'=>'70px'							
			,'totals'=>true
			,'disabled'=>false
			,'totals'=>true
		);
		
		$this->grid->Columns[] =Array(
			'title'=>'DMS'
			,'field'=>'insurance'
			,'type'=>'money'
			,'width'=>'70px'							
			,'totals'=>true
			,'disabled'=>false
			,'totals'=>true
		);
		
		if($this->type=='new'){
			$this->grid->Columns[] = Array(
				'title'=>'FTE'
				,'field'=>'new_fte'
				,'type'=>'int'
				,'width'=>'40px'							
				, 'mandatory' => true
				, 'disabled'=>false
				,'totals'=>true
				,'default'=>0
				);	
		}
		
		for ($m=1;$m<=15;$m++){
			$month = $this->budget->arrPeriod[$m];
					
			$this->grid->Columns[] = Array(
			'title'=>''//ucfirst($month)------------------------ Title hidden
			,'field'=>strtolower($month)
			,'class'=>'budget-month'
			,'type'=>'int'
			, 'mandatory' => true
			, 'disabled'=>false
			,'totals'=>true
			,'default'=>1
			);		
		}
		
		$this->grid->Columns[] =Array(
			'title'=>'Average FTE'
			,'field'=>'AVG'
			,'type'=>'decimal'
			,'width'=>'90px'							
			,'totals'=>true
			,'disabled'=>true
		);
		
		return ($this->grid);
	}
	

	public function save($mode='update'){
		
		GLOBAL $arrUsrData;
		//GLOBAL $Activities;
		// GLOBAL $YACT;
		GLOBAL $Items;
		GLOBAL $oBudget;
		GLOBAL $ProfitCenters;
		GLOBAL $Employees;
		
		parent::save($mode);
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if ($mode=='update' || $mode=='post') {
			$this->profit = isset($_POST[$this->prefix.'ProfitID'])?$_POST[$this->prefix.'ProfitID']:$this->profit;
			if (!$this->pc){
				$this->pc = $ProfitCenters->getByCode($this->profit);
			}
			$this->comment = isset($_POST[$this->prefix.'Comment'])?$_POST[$this->prefix.'Comment']:$this->comment;
			$this->overtime = isset($_POST[$this->prefix.'Overtime'])?$_POST[$this->prefix.'Overtime']:$this->overtime;
			$this->turnover = isset($_POST[$this->prefix.'Turnover'])?$_POST[$this->prefix.'Turnover']:$this->turnover;
			$this->bonus_corporate = isset($_POST[$this->prefix.'BonusCorporate'])?$_POST[$this->prefix.'BonusCorporate']:$this->bonus_corporate;
			$this->bonus_department = isset($_POST[$this->prefix.'BonusDepartment'])?$_POST[$this->prefix.'BonusDepartment']:$this->bonus_department;
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
						$row->comment = $_POST['comment'][$id];				
						$row->location = $_POST['location'][$id];				
						$row->activity = $_POST['activity'][$id];				
						$row->employee = $_POST['particulars'][$id];				
						$row->job = $_POST['function'][$id];				
						$row->pc_profile = $_POST['pc_profile'][$id];				
						$row->wc = (integer)$_POST['wc'][$id];
						$row->vks = (integer)$_POST['vks'][$id];			
						$row->insurance = (double)str_replace(',','',$_POST['insurance'][$id]);							
						$row->salary = (double)str_replace(',','',$_POST['salary'][$id]);							
						$row->compensation = (double)str_replace(',','',$_POST['compensation'][$id]);							
						$row->monthly_bonus = (double)str_replace(',','',$_POST['monthly_bonus'][$id]);							
						$row->mobile_limit = (double)str_replace(',','',$_POST['mobile_limit'][$id]);							
						$row->fuel = (double)str_replace(',','',$_POST['fuel'][$id]);
						
						$row->start_date = isset($_POST['start_date'][$id])?strtotime($_POST['start_date'][$id]):$row->start_date;							
						$row->end_date = isset($_POST['end_date'][$id])?strtotime($_POST['end_date'][$id]):$row->end_date;							
						
						if ($this->type=='new'){							
							$row->new_fte = (double)$_POST['new_fte'][$id];
						};
								
						// $start_date = strtotime($_POST['start_date'][$id]);
								
						for ($m=1;$m<=15;$m++){
							$month = $this->budget->arrPeriod[$m];
							$current_month_start = mktime(0,0,0,$m,1,$this->budget->year);
							$current_month_end = mktime(0,0,0,$m+1,0,$this->budget->year);
							// echo date('d.m.Y',$row->start_date),';',date('d.m.Y',$current_month_start),"\r\n";
							if ($this->type=='current'){
								
								$row->{$month} = (integer)$_POST[strtolower($month)][$id];
								$row->{$month} = $row->getFTE($m, $this->budget->year);
								
							} else {
								
								if($row->start_date<=$current_month_start){
									$row->{$month} = $_POST['new_fte'][$id];
								} elseif($row->start_date>$current_month_end){
									$row->{$month} = 0;
								} else {
									$row->hc = $_POST['new_fte'][$id]*(date('t',$current_month_start)-date('j',$row->start_date))/date('t',$current_month_start);							 
									// $row->{$month} = $hc;
									$row->{$month} = (double)$_POST['new_fte'][$id];
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
		
		$this->settings = Budget::getSettings($this->oSQL,$this->scenario);
		// echo '<pre>';print_r($this->settings);echo '</pre>';	
		
		$sql = Array();
		$sql[] = "SET AUTOCOMMIT = 0;";
		$sql[] = "START TRANSACTION;";
		if	($mode!='new'){
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
					,{$this->prefix}BonusCorporate=".(integer)$this->bonus_corporate."				
					,{$this->prefix}BonusDepartment=".(integer)$this->bonus_department."				
					WHERE {$this->prefix}ID={$this->ID};";
			}
		}
		if(is_array($this->records[$this->gridName])){			
			foreach ($this->records[$this->gridName] as $i=>$row){				
				if ($row->flagUpdated || $row->flagDeleted){
					$sql[] = $row->getSQLstring(date('m',$this->budget->date_start),12,false);
				}
			}
		};
		
		$sql[] = "SET AUTOCOMMIT = 1;";
		$sql[] = 'COMMIT;';				
		// echo '<pre>';print_r($sql);echo '</pre>';
		$sqlSuccess = $this->doSQL($sql);
				
		if($mode=='post'){
			$this->refresh($this->ID);
			$oMaster = new Master($this->scenario, $this->GUID,$this->company);
			
			if(is_array($this->records[$this->gridName])){
					
					
					
					//--------------------------------- Calculate vacations for the department
					$arrVacation = Array();	
					for($m=1+$this->budget->offset;$m<=12+$this->budget->offset;$m++){ 
						$month = $this->budget->arrPeriod[$m];
						
						$current_month_start = mktime(0,0,0,$m,1,$this->budget->year);
						$current_month_end = mktime(23,59,59,$m+1,0,$this->budget->year);
						
						$sqlV = Array();
						$sqlV[]="SET @dateStart:='".date('Y-m-d',$current_month_start)."',
									@dateEnd:='".date('Y-m-d',$current_month_end)."', 
									@daysMonth := nlogjc.fn_daycount('".date('Y-m-d',$current_month_start)."', '".date('Y-m-d',$current_month_end)."', 'workdays');";
						$sqlV[] = "SELECT empGUID1C, vacEmployeeID, empTitle, vacDateStart, vacDateEnd, IF(vacDateStart<@dateStart,@dateStart, vacDateStart),IF(vacDateEnd>@dateEnd,@dateEnd, vacDateEnd), 
							nlogjc.fn_daycount(IF(vacDateStart<@dateStart,@dateStart, vacDateStart),IF(vacDateEnd>@dateEnd,@dateEnd, vacDateEnd),'workdays') as Duration,@daysMonth as daysMonth
						FROM treasury.tbl_vacation
						JOIN common_db.tbl_employee ON empID=vacEmployeeID
						WHERE ((vacDateStart BETWEEN @dateStart AND @dateEnd) OR (vacDateEnd BETWEEN @dateStart AND @dateEnd))
						AND vacStateID BETWEEN 410 AND 450
						AND empProfitID={$this->pc->code}";
						
						for($i=0;$i<count($sqlV);$i++){
							$rs = $this->oSQL->q($sqlV[$i]);
						};
						while ($rw = $this->oSQL->f($rs)){							
							if($rw['Duration']) $arrVacation[$rw['empGUID1C']][$month] = $rw['Duration']/$rw['daysMonth'];
						}
						
					}
			
				$eligible_date = mktime(0,0,0,10,1,$this->budget->year-1);
				
				foreach($this->records[$this->gridName] as $id=>$record){
					
					// $start_date = strtotime($record->start_date);
					$start_date = ($record->start_date);
					// $review_date = strtotime($record->review_date);
					$review_date = ($record->review_date);
					$probation = $start_date + 91*24*60*60;
					$eligible = (max($start_date,$review_date) < $eligible_date) && ($this->settings['salary_review_month']>=date('m',$this->budget->date_start));
					
					// echo "\r\n-----------";
					// echo "Employee: ",$record->employee->name,"\r\n";
					// echo "Eligible date:",date('Y-m-d',$eligible_date),"\r\n";
					// echo "Start date:",date('Y-m-d',$start_date),"\r\n";
					// echo "Review date:",date('Y-m-d',$review_date),"\r\n";
					// echo "Eligible:",$eligible,"\r\n";
					// print_r($record);
					
					
					$oEmployee = $Employees->getById($record->employee);
					// echo '<pre>';print_r($oEmployee);echo '</pre>';
						
					//-----------------------------------------------------------------Salary, gross
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code; 
					$master_row->activity = $record->activity?$record->activity:$this->pc->activity;
					$master_row->customer = $record->customer;
					$master_row->particulars = $record->employee;
					$master_row->part_type = 'EMP';
					
					$master_row->item = Items::SALARY;
					
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? ($record->sga?$oItem->YACTCorp:$oItem->YACTProd) : $oItem->YACTCorp;
								
					$social_tax = Array();					
					$salarySubtotal = 0;
					
					$sql = "SELECT IF(bnsStateID=2270,bnsApprovedSalary,bnsReviewedSalary) as bnsReviewedSalary
							FROM treasury.tbl_bonus 
							WHERE bnsEmployeeID=(SELECT empID FROM common_db.tbl_employee WHERE empGUID1C='{$record->employee}')
								AND bnsStateID BETWEEN 2220 AND 2270
								AND bnsPeriodID=(SELECT MAX(bpdID) FROM treasury.tbl_bonus_period WHERE bpdDateEnd<'".date('Y-m-d',$this->budget->date_start)."' AND bpdFlagSalaryReview=1)";
					$rs = $this->oSQL->q($sql);
					$bnsReviewedSalary = $this->oSQL->get_data($rs);
					
					// echo '<pre>',$sql,'</pre>';die();
					
					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
						
						$current_month_start = mktime(0,0,0,$m,1,$this->budget->year);
						$current_month_end = mktime(23,59,59,$m+1,0,$this->budget->year);
						

						if($bnsReviewedSalary){
							$salary[$month] = ($record->{$month})*(($m<$this->settings['salary_review_month']?$record->salary:$bnsReviewedSalary)+$record->monthly_bonus);
						} elseif ($eligible && $this->type=='current') {						
							$salary[$month] = ($record->{$month})*($record->salary+$record->monthly_bonus)*($m<$this->settings['salary_review_month']?1:1+$this->settings['salary_increase_ratio']);
						} else {
							if (true || $this->type=='current'){
								$salary[$month] = ($record->{$month})*($record->salary+$record->monthly_bonus);
							} else {
								//------------disabled--------------------------------------
								$current_month_start = mktime(0,0,0,$m,1,$this->budget->year);
								$current_month_end = mktime(0,0,0,$m+1,0,$this->budget->year);
								if(date('YM',$start_date)==date('YM',$current_month_start)){
									$record->hc = $record->new_fte*(date('t',$current_month_start)-date('j',$start_date))/date('t',$current_month_start);							 
								} elseif($start_date<$current_month_start){
									$record->hc = $record->new_fte;
								} else {
									$record->hc = 0;
								}
								$salary[$month] = $record->hc*($record->salary+$record->monthly_bonus);
							}
						}
						

						
						$salarySubtotal += $salary[$month];
						$master_row->{$month} = -$salary[$month]*(1 - $arrVacation[$record->employee][$month]);
						$hcCount[$month][$record->wc] += $record->{$month};
						$payroll[$month] += $salary[$month];
						
						if($record->end_date>=$current_month_start && $record->end_date<=$current_month_end){
							$master_row->{$month} -= $record->compensation;
							$salarySubtotal += $record->compensation;
							$salary[$month] += $record->compensation;
						}
						
						$social_tax[$month] = $this->_getSocialTax($salary[$month],$m)*(1-$record->vks) + $this->settings['social_tax_accident'] * $salary[$month] ;
						// if ($salarySubtotal<$this->settings['social_cap']){
							// $social_tax[$month] = ($this->settings['social_tax_1']*(1-$record->vks)+$this->settings['social_tax_accident']) * $salary[$month];
						// } else {
							// $social_tax[$month] = $this->settings['social_tax_accident'] * $salary[$month] 
												// + $this->settings['social_tax_1']*(1-$record->vks) * max(0,$this->settings['social_cap'] - ($salarySubtotal - $salary[$month])) 
												// + $this->settings['social_tax_2']*(1-$record->vks)* min($salary[$month],($salarySubtotal - $this->settings['social_cap']));
						// }


						
					}
					if($record->activity){
						$master_row->activity = $record->activity;
					} else {
						$oMaster->distribute_activity($master_row,$this->pc->activity);
					}
					
					//-----------------------------------------------------------------Unused vacation accrual
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;
					$master_row->customer = $record->customer;							
					$master_row->item = Items::UNUSED_VACATION_ACCRUAL;
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? ($record->sga?$oItem->YACTCorp:$oItem->YACTProd) : $oItem->YACTCorp;
						
					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
						$master_row->{$month} = - (28+$oEmployee->addlVacation)/12/29.4 * ($record->{$month})*($record->salary+$record->monthly_bonus);
					}
					if($record->activity){
						$master_row->activity = $record->activity;
					} else {
						$oMaster->distribute_activity($master_row,$this->pc->activity);
					}
					//-----------------------------------------------------------------Social tax
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;
					$master_row->customer = $record->customer;					
					$master_row->particulars = $record->employee;
					$master_row->part_type = 'EMP';	
					$master_row->item = Items::SOCIAL_TAX;
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? ($record->sga?$oItem->YACTCorp:$oItem->YACTProd) : $oItem->YACTCorp;
					
					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
						$master_row->{$month} = -$social_tax[$month];
					}
					if($record->activity){
						$master_row->activity = $record->activity;
					} else {
						$oMaster->distribute_activity($master_row,$this->pc->activity);
					}
										
					//-----------------------------------------------------------------Mobile costs
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;
					$master_row->customer = $record->customer;
					$master_row->particulars = $record->employee;
					$master_row->part_type = 'EMP';					
					$master_row->item = Items::MOBILE;
					
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? ($record->sga?$oItem->YACTCorp:$oItem->YACTProd) : $oItem->YACTCorp;
					
					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
						$master_row->{$month} = - $record->{$month}*$record->mobile_limit;
					}
					if($record->activity){
						$master_row->activity = $record->activity;
					} else {
						$oMaster->distribute_activity($master_row,$this->pc->activity);
					}
					//-----------------------------------------------------------------IT Equipment
					if ($this->type=='new'){
						$master_row = $oMaster->add_master();
						$master_row->profit = $this->pc->code;
						$master_row->customer = $record->customer;
						// $master_row->particulars = $record->employee;
						// $master_row->part_type = 'EMP';					
						$master_row->item = Items::IT_EQUIPMENT;
						
						$oItem = $Items->getById($master_row->item);
						$master_row->account = $this->pc->prod ? ($record->sga?$oItem->YACTCorp:$oItem->YACTProd) : $oItem->YACTCorp;
						
						for($m=1;$m<=15;$m++){
							$month = $this->budget->arrPeriod[$m];
							$next_month_start = mktime(0,0,0,$m+1,1,$oBudget->year);
							if(date('Ym',$start_date) < date('Ym',$next_month_start)){
								$master_row->{$month} = - $record->{$month}*$this->settings['pc_profile_'.$record->pc_profile]*$this->settings['usd']/36;
							}
							
						}
						if($record->activity){
							$master_row->activity = $record->activity;
						} else {
							$oMaster->distribute_activity($master_row,$this->pc->activity);
						}
					}
					//-----------------------------------------------------------------Fuel costs
					if ($record->fuel>0){
						$master_row = $oMaster->add_master();
						$master_row->profit = $this->pc->code;
						$master_row->customer = $record->customer;
						$master_row->particulars = $record->employee;
						$master_row->part_type = 'EMP';					
						$master_row->item = Items::FUEL;
						
						$oItem = $Items->getById($master_row->item);
						$master_row->account = $this->pc->prod ? ($record->sga?$oItem->YACTCorp:$oItem->YACTProd) : $oItem->YACTCorp;
						
						for($m=1;$m<=15;$m++){
							$month = $this->budget->arrPeriod[$m];
							$master_row->{$month} = - $record->{$month}*$record->fuel;
						}
						if($record->activity){
							$master_row->activity = $record->activity;
						} else {
							$oMaster->distribute_activity($master_row,$this->pc->activity);
						}
					}
					//-----------------------------------------------------------------Bonus
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;
					$master_row->customer = $record->customer;
					$master_row->particulars = $record->employee;
					$master_row->part_type = 'EMP';					
					
					$master_row->item = Items::BONUS;
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? ($record->sga?$oItem->YACTCorp:$oItem->YACTProd) : $oItem->YACTCorp;
					
					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
						$master_row->{$month} = - 	$salary[$month]
													*(0.5*$this->settings['regular_bonus_avg']/100 
														+$this->bonus_corporate/100
														+$this->bonus_department/100)
													*$this->settings['regular_bonus_base']/100/3;
					}
					if($record->activity){
						$master_row->activity = $record->activity;
					} else {
						$oMaster->distribute_activity($master_row,$this->pc->activity);
					}
					//-----------------------------------------------------------------Medical insurance
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;	
					$master_row->customer = $record->customer;
					$master_row->particulars = $record->employee;
					$master_row->part_type = 'EMP';					
					
					$master_row->item = Items::MEDICAL_INSURANCE;
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? ($record->sga?$oItem->YACTCorp:$oItem->YACTProd) : $oItem->YACTCorp;
					
					$insurance_base = $record->insurance/12;
					$insurance_roy = $insurance_base*(1+$this->settings['medical_insurance_index']);
					$insurance_expiry = strtotime($this->settings['medical_insurance_expiry']);
					$ins_exp_day = date('j',$insurance_expiry);
					$ins_exp_month = date('n',$insurance_expiry);
					$ins_exp_full = date('t',$insurance_expiry);
					
					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
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
					if($record->activity){
						$master_row->activity = $record->activity;
					} else {
						$oMaster->distribute_activity($master_row,$this->pc->activity);
					}
					if ($this->type=='new'){
						//-----------------------------------------------------------------Hiring for newcomers
						$master_row = $oMaster->add_master();
						$master_row->profit = $this->pc->code;
						$master_row->customer = $record->customer;
						$master_row->particulars = $record->employee;
						$master_row->part_type = 'EMP';	
						
						$master_row->item = Items::HIRING_COSTS;
						$oItem = $Items->getById($master_row->item);
						$master_row->account = $this->pc->prod ? ($record->sga?$oItem->YACTCorp:$oItem->YACTProd) : $oItem->YACTCorp;
												
						
						for($m=1;$m<=15;$m++){
							$month = $this->budget->arrPeriod[$m];
							$month_start = mktime(0,0,0,$m,1,$oBudget->year);
							if (date('m.Y',$start_date)==date('m.Y',$month_start)){
								$master_row->{$month} = - abs($record->new_fte) * $this->settings['hiring'] * $record->salary * 12;							
							}						
						}
						if($record->activity){
							$master_row->activity = $record->activity;
						} else {
							$oMaster->distribute_activity($master_row,$this->pc->activity);
						}
					}
					
				}//---end of record cycle
				
				//=================================================================Reserves on total headcount/payroll
				//-----------------------------------------------------------------Hiring (turnover reserve)
				if ($this->type=='current'){
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->pc->code;
					$master_row->item = Items::HIRING_COSTS;
					$oItem = $Items->getById($master_row->item);
					$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;

					for($m=1;$m<=15;$m++){
						$month = $this->budget->arrPeriod[$m];
						$master_row->{$month} = - $this->settings['hiring'] * $payroll[$month] * $this->turnover/100;
					}
					$oMaster->distribute_activity($master_row,$this->pc->activity);
				}
				//-----------------------------------------------------------------Overtime
				$master_row = $oMaster->add_master();
				$master_row->profit = $this->pc->code;
				$master_row->activity = $this->pc->activity;	
				$master_row->item = Items::OVERTIME_WORK;
				$oItem = $Items->getById($master_row->item);
				$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;
					
				for($m=1;$m<=15;$m++){
					$month = $this->budget->arrPeriod[$m];
					$master_row->{$month} = - $payroll[$month] * $this->overtime/100;
				}
				$oMaster->distribute_activity($master_row,$this->pc->activity);
				//-----------------------------------------------------------------Canteen
				$master_row = $oMaster->add_master();
				$master_row->profit = $this->pc->code;			
				$master_row->item = Items::CANTEEN;
				$oItem = $Items->getById($master_row->item);
				$master_row->account = $this->pc->prod ? $oItem->YACTProd : $oItem->YACTCorp;				
				
				for($m=1;$m<=15;$m++){
					$month = $this->budget->arrPeriod[$m];
					$master_row->{$month} = - $hcCount[$month][1]*$this->settings['canteen_wc'] - $hcCount[$month][0]*$this->settings['canteen_bc'];
				}
				$oMaster->distribute_activity($master_row,$this->pc->activity);
									
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
		
		
		
		$dateBudgetStart = date('Y-m-d',$this->budget->date_start);
		$dateBudgetEnd = date('Y-m-d h:i:s',$this->budget->date_end);
		
		$dateEstStart = date('Y-m-d',$this->budget->date_start-365*24*60*60);
		$dateEstEnd = date('Y-m-d h:i:s',$this->budget->date_end-365*24*60*60);
		
		// if ($oBudget->length ==15){
			// $dateBudgetEnd = ($oBudget->year+1).'-03-31 23:59:59';
		// } else {
			// $dateBudgetEnd = ($oBudget->year).'-12-31 23:59:59';
		// }
		
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
		
		
		
		$arrMaternity = Array();
		$sql = "SELECT DISTINCT(vacEmployeeID) as empID, empTitle 
					FROM treasury.tbl_vacation 
					LEFT JOIN common_db.tbl_employee ON empID=vacEmployeeID
					WHERE vacVactypeID IN (4,5) AND vacDateStart<'{$dateBudgetEnd}' AND vacDateEnd>'{$dateBudgetStart}'";
		$rs = $this->oSQL->q($sql);
		while ($rw = $this->oSQL->f($rs)){
			$arrMaternity[] = $rw['empID'];
			$this->comment .= "/r/n".$rw['empTitle']." on maternity leave";
		}
		$sql = "SELECT DISTINCT(sklEmployeeID) as empID, empTitle 
					FROM treasury.tbl_sickleave
					LEFT JOIN common_db.tbl_employee ON empID=sklEmployeeID
					WHERE DATEDIFF(sklDateEnd, sklDateStart)>=139 AND sklDateStart<'{$dateBudgetEnd}' AND sklDateEnd>'{$dateBudgetStart}'";
		$rs = $this->oSQL->q($sql);
		while ($rw = $this->oSQL->f($rs)){
			$arrMaternity[] = $rw['empID'];
			$this->comment .= "/r/n".$rw['empTitle']." on maternity leave";
		}
		// if (is_array($arrMaternity)){
			// $strMaternity = implode(',',$arrMaternity);
		// } else {
			// $strMaternity = 'NULL';
		// }
		
		$sql = "SELECT empID, empGUID1C,empFunctionGUID,funFlagWC,empLocationID,empProductTypeID,funMobile,funFuel,funFlagSGA, empStartDate,empEndDate,
						empSalary
						,empFTE
						,empSalaryRevision
						,IF(empMonthly=0,funBonus,empMonthly) as empMonthly
						,(SELECT SUM(dmsPrice) FROM tbl_insurance WHERE dmsLocationID=empLocationID) as insurance
					, (SELECT MAX(rsgDateEnd) FROM treasury.tbl_resignation WHERE rsgEmployeeID=empID AND rsgStateID<>1090 AND DATEDIFF(rsgDateEnd,'".date('Y-m-d',$this->budget->date_start)."')>0) as empEndDate
					FROM vw_employee_select 
					WHERE empProfitID={$this->pc->code}
						AND empFlagDeleted=0 AND (empEndDate IS NULL OR DATEDIFF(empEndDate,'".date('Y-m-d',$this->budget->date_start)."')>=0)
					ORDER BY empSalary DESC, empFunctionGUID, empTitleLocal";//die($sql);
		
				
		$this->Documentlog[] = $this->budget->id;
		$this->Documentlog[] = $this->budget->date_start;
		$this->Documentlog[] = $this->budget->date_end;
		$this->Documentlog[] = $sql;
		// echo $sql;
		// echo '<pre>';print_r($oBudget);echo '</pre>';
		
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$row = $this->add_record();
			$row->flagUpdated = true;				
			$row->profit = $this->pc->code;
			$row->employee = $rw['empGUID1C'];				
			$row->job = $rw['empFunctionGUID'];
			$row->wc = $rw['funFlagWC'];				
			$row->sga = $rw['funFlagSGA'];				
			$row->location = $rw['empLocationID'];			
			$row->activity = $rw['empProductTypeID'];//?$rw['empProductTypeID']:$this->pc->activity;			
			$row->salary = in_array($rw['empID'],$arrMaternity)? 0 : $rw['empSalary'];
			$row->review_date = strtotime($rw['empSalaryRevision']);
			$row->monthly_bonus = $rw['empMonthly'];
			$row->insurance = $rw['insurance'];
			$row->mobile_limit = $rw['funMobile'];
			$row->fuel = $rw['funFuel'];
			$row->start_date = strtotime($rw['empStartDate']);
			$row->end_date = strtotime($rw['empEndDate']);
			
			for ($m=$this->budget->nm;$m<=15;$m++){
				$month = $this->budget->arrPeriod[$m];
				$row->{$month} = $rw['empFTE']*$row->getFTE($m, $oBudget->year);						
			}
		}	
	}

	private function _getSocialTaxYTD($salary, $period){
		
		if ($period>12) $period = $period - 12;
		if ($period <= 0) return (0);
		
		if ($this->budget->year >= 2016){
			$tax_base['pfr'] = min ($salary * $period, $this->settings['social_cap_pfr']);
			$tax_base['fss'] = min ($salary * $period, $this->settings['social_cap_fss']);
			$tax_base['foms'] = $salary * $period;
			$res = $this->settings['social_rate_pfr']*$tax_base['pfr'] + $this->settings['social_rate_fss']*$tax_base['fss'] + $this->settings['social_rate_foms']*$tax_base['foms'];			
		} else {
			$tax_base =  min ($salary * $period, $this->settings['social_cap']);
			$res = max(0,$salary*$period - $tax_base)*$this->settings['social_tax_2'] + $tax_base * $this->settings['social_tax_1'];
		}
		
		return ($res);
	}
	
	private function _getSocialTax($salary, $period){
		if ($period>12) $period = $period - 12;
		$res = $this->_getSocialTaxYTD($salary, $period) - $this->_getSocialTaxYTD($salary, $period-1);
		return ($res);
	}
	
}



?>


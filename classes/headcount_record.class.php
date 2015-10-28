<?php
require_once('table_record.class.php');

class headcount_record extends table_record{

	public $account;
	public $item;
	public $customer;
	public $activity;
	public $employee;
	public $job;
	public $salary;
	
	public function __construct($session, $scenario, $id='', $data=Array()){

		parent::__construct($session, $scenario, $id, $data);
		
		if (count($data)){			
			$this->product = $data['product'];			
			$this->profit = $data['profit'];
			$this->activity = $data['activity'];
			$this->customer = $data['customer'];
			$this->job = $data['function'];
			$this->employee = $data['particulars'];
			$this->salary = $data['salary'];
			$this->mobile_limit = $data['mobile_limit'];
			$this->fuel = $data['fuel'];
			$this->insurance = $data['insurance'];
			$this->pc_profile = $data['pc_profile'];
			$this->wc = $data['wc'];
			$this->vks = $data['vks'];
			$this->start_date = strtotime($data['start_date']);
			$this->end_date = strtotime($data['end_date']);
			$this->new_fte = $data['new_fte'];
	
		}		
		return (true);
	}	
		
	public function getSQLstring($mStart=1, $mEnd=12, $flagPostActualPeriods = false){
		
		GLOBAL $oSQL;
		
		if ($this->flagDeleted && $this->id){
			$res = "DELETE FROM `reg_headcount` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
		
		if ($flagPostActualPeriods) {
			$mStart = 1;
		}
	
		for($m=$mStart;$m<=$mEnd;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$arrRes[] = "`$month`=".(double)$this->{$month};
		}
		
		if($this->salary+$this->insurance){
			$arrRes[] = "`company`='OOO'";
			$arrRes[] = "`account`='".$this->account->code."'";
			$arrRes[] = "`item`='".Items::SALARY."'";
			$arrRes[] = "`pc`=".(integer)$this->profit;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";
			$arrRes[] = "`function`='".$this->job."'";
			$arrRes[] = "`location`='".$this->location."'";
			$arrRes[] = "`activity`=".(integer)$this->activity;
			$arrRes[] = "`pc_profile`=".(integer)$this->pc_profile;
			$arrRes[] = "`salary`=".(double)$this->salary;
			$arrRes[] = "`insurance`=".(double)$this->insurance;
			$arrRes[] = "`mobile_limit`=".(double)$this->mobile_limit;
			$arrRes[] = "`wc`=".($this->wc?1:0);
			$arrRes[] = "`vks`=".($this->vks?1:0);
			$arrRes[] = "`fuel`=".(double)$this->fuel;
			$arrRes[] = "`start_date`=".($this->start_date ? $oSQL->e(date('Y-m-d',$this->start_date)) : 'NULL');
			$arrRes[] = "`end_date`=".($this->end_date ? $oSQL->e(date('Y-m-d',$this->end_date)) : 'NULL');
			$arrRes[] = "`new_fte`=".(double)$this->new_fte;
			$arrRes[] = "`particulars`=".($this->employee?$oSQL->e($this->employee):'NULL');
			if ($this->id){
				$res = "UPDATE `reg_headcount` SET ". implode(',',$arrRes)." WHERE id=".$this->id;
			} else {
				$res = "INSERT INTO `reg_headcount` SET ". implode(',',$arrRes);
			}
			return $res;
		} else{
			return false;
		}
	}
	
	public function getFTE($m, $year){
		$res = 1;
		
		$current_month_start = mktime(0,0,0,$m,1,$year);
		$current_month_end = mktime(23,59,59,$m+1,0,$year);
		
		// echo date('d.m.Y',$current_month_start), " - ",date('d.m.Y',$current_month_end), "\r\n";
		// echo "Start date - ", date('d.m.Y', $this->start_date), "\r\n";
		
		if($this->start_date>$current_month_end){
			$res = 0; 
		} elseif ($this->start_date>$current_month_start) {			
			$res = 1 - ($this->start_date - $current_month_start)/($current_month_end-$current_month_start); 
			// echo 'Partial employment since ',date('d.m.Y',$this->start_date),' = 1 - (',$this->start_date,'-',$current_month_start,')/(',$current_month_end,' - ',$current_month_start,') = ', $res,"\r\n";
		};
		
		if ($this->end_date){
			if($this->end_date<$current_month_start){
				$res = 0; 
			} elseif ($this->end_date<$current_month_end) {
				$res = 1 - ($current_month_end - $this->end_date)/($current_month_end-$current_month_start); 
			};
		}
		
		return($res);
	}
}
?>
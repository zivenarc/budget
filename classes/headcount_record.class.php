<?php
class headcount_record {
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
	public $company;
	public $account;
	public $item;
	public $customer;
	public $activity;
	public $source;
	public $employee;
	public $job;
	public $salary;
	private $session_id;
	
	public function __construct($session, $scenario, $id='', $data=Array()){

		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$this->{$month} = 0;
		}
		$this->id = $id;
		$this->source = $session;
		$this->scenario = $scenario;
		
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
			$this->job = $data['function'];
			$this->employee = $data['particulars'];
			$this->salary = $data['salary'];
			$this->mobile_limit = $data['mobile_limit'];
			$this->fuel = $data['fuel'];
			$this->insurance = $data['insurance'];
			$this->pc_profile = $data['pc_profile'];
			$this->wc = $data['wc'];
			$this->vks = $data['vks'];
			$this->start_date = $data['start_date'];
			$this->new_fte = $data['new_fte'];
	
		}		
		return (true);
	}	
		
	public function set_month_value($i, $value){
		$month = date('M',mktime(0,0,0,(integer)$i,15));
		$this->{$month} =(double)$value;
		return(true);
	}
	
	public function getSQLstring(){
		
		GLOBAL $oSQL;
		
		if ($this->flagDeleted && $this->id){
			$res = "DELETE FROM `reg_headcount` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
	
	
		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$arrRes[] = "`$month`=".(integer)$this->{$month};
		}
		
		if($this->salary){
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
			$arrRes[] = "`wc`=".(integer)$this->wc;
			$arrRes[] = "`vks`=".(integer)$this->vks;
			$arrRes[] = "`fuel`=".(double)$this->fuel;
			$arrRes[] = "`start_date`=".($this->start_date ? $oSQL->e($this->start_date) : 'NULL');
			$arrRes[] = "`new_fte`=".(integer)$this->new_fte;
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
	
	public function total(){
		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$res += $this->{$month};
		}
		return ($res);
	}
}
?>
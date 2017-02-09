<?php
class master_record{
	public $company;
	public $account;
	public $item;
	public $customer;
	public $activity;
	public $source;
	public $particulars;
	//private $session_id;
	
	function __construct($session, $scenario, $company){
		
		$this->arrPeriod = Array(1=>'jan',2=>'feb',3=>'mar',4=>'apr',5=>'may',6=>'jun',7=>'jul',8=>'aug',9=>'sep',10=>'oct',11=>'nov',12=>'dec',13=>'jan_1',14=>'feb_1',15=>'mar_1');
	
		for($m=1;$m<=15;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));
			$month = $this->arrPeriod[$m];
			$this->{$month} = 0;
		}		
		
		$this->source = $session;
		$this->scenario = $scenario;
		$this->company = $company;
		
		return (true);
	}	
		
	public function set_month_value($i, $value){
		//$month = date('M',time(0,0,0,(integer)$i,15));
		$month = $this->arrPeriod[$m];
		$this->{$month} =(double)$value;
		return(true);
	}
	
	public function getSQLstring($mStart=1, $mEnd=12, $flagPostActualPeriods = false){
		
		GLOBAL $oSQL;
		
		if ($flagPostActualPeriods) {
			$mStart = 1;
		}
		
		$arrRes = Array();
		
		// echo '<pre>';print_r($this);echo '</pre>';die();
		
		for($m=$mStart;$m<=$mEnd;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));
			$month = $this->arrPeriod[$m];			
			$arrRes[] = "`$month`=".$this->{$month};
		}
				
		$arrRes[] = "`company`='{$this->company}'"; 
		$arrRes[] = "`account`='".$this->account."'";		
		$arrRes[] = "`item`='".$this->item."'";		
		$arrRes[] = "`pc`=".$this->profit;
		$arrRes[] = "`source`='".$this->source."'";
		$arrRes[] = "`scenario`='".$this->scenario."'";
		$arrRes[] = "`customer`=".($this->customer?(integer)$this->customer:'NULL');
		$arrRes[] = "`customer_group_code`=".($this->customer?"`common_db`.`fn_parentl2`(".(integer)$this->customer.")":'NULL');
		$arrRes[] = "`activity`=".($this->activity?(integer)$this->activity:'NULL');
		$arrRes[] = "`part_type`=".($this->part_type?$oSQL->e($this->part_type):'NULL');
		$arrRes[] = "`particulars`=".$oSQL->e($this->particulars);
		$arrRes[] = "`sales`=".($this->sales?$oSQL->e($this->sales):'NULL');		
		$arrRes[] = "`bdv`=".($this->bdv?$this->bdv:"IFNULL((SELECT usrProfitID FROM stbl_user WHERE usrID=".$oSQL->e($this->sales)."),0)");
		//$arrRes[] = "`part_type`=".(is_object($this->particulars['obj'])?"'".$this->particulars['obj']->TYPE."'":'NULL');
		$res = "INSERT INTO `reg_master` SET ". implode(',',$arrRes).';';
		return $res;
	}
	
	public function total(){
		for($m=1;$m<=15;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));
			$month = $this->arrPeriod[$m];
			$res += $this->{$month};
		}
		return ($res);
	}
	
	public function total_am(){
		for($m=4;$m<=15;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));
			$month = $this->arrPeriod[$m];
			$res += $this->{$month};
		}
		return ($res);
	}
	
	public function total_jd(){
		for($m=4;$m<=12;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));
			$month = $this->arrPeriod[$m];
			$res += $this->{$month};
		}
		return ($res);
	}
	
}
?>
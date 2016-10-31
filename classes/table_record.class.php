<?php
include_once ('../common/eiseGrid2/inc_eiseGrid.php');
$arrJS[] ='/common/eiseGrid2/eiseGrid.jQuery.js';
$arrCSS[] = '/common/eiseGrid2/themes/default/screen.css';

class table_record {
	public $jan,  $feb,  $mar,  $apr,  $may,  $jun,  $jul,  $aug,  $sep,  $oct,  $nov,  $dec, $jan_1, $feb_1, $mar_1;
	
	public $flagUpdated;
	public $flagDeleted;
	public $id;
	
	public $source;
	public $scenario;
	public $company;
	public $profit;
	
	protected $oSQL;
	
	function __construct($session, $scenario, $company, $id='', $data=Array()){
		GLOBAL $oSQL;
		
		$this->oSQL = $oSQL;
		$this->source = $session;
		$this->scenario = $scenario;		
		$this->company = $company;		
	
		$this->id=$id;
		$this->arrPeriod = Array(1=>'jan',2=>'feb',3=>'mar',4=>'apr',5=>'may',6=>'jun',7=>'jul',8=>'aug',9=>'sep',10=>'oct',11=>'nov',12=>'dec',13=>'jan_1',14=>'feb_1',15=>'mar_1');
		
		if (count($data)){
			for($m=1;$m<=15;$m++){
				// $month = date('M',mktime(0,0,0,$m,15));
				$month = $this->arrPeriod[$m];
				$this->{$month} = $data[strtolower($month)];			
			}
			//$this->company = $data['company'];
			$this->profit = $data['pc'];
		}
	}
	
	public function set_month_value($m, $value){
		// $month = date('M',mktime(0,0,0,(integer)$i,15));
		$month = $this->arrPeriod[$m];
		$this->{$month} =(double)$value;
		return(true);
	}
	
	public function set_months($rw){
		for ($m=1;$m<=15;$m++){
				// $month = date('M',mktime(0,0,0,$m,15));	
				$month = $this->arrPeriod[$m];				
				$this->set_month_value($m, $rw[$month]);
		}		
	}
	
	public function setMonthsFromPOST(){
		for ($m=1;$m<=15;$m++){
			$month = $this->arrPeriod[$m];				
			$this->set_month_value($m, $_POST[$month][$this->id]);
		}	
	}
	
	public function total(){
		for($m=1;$m<=15;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));
			$month = $this->arrPeriod[$m];
			$res += $this->{$month};
		}
		return ($res);
	}	
	
	public function count(){
		for($m=1;$m<=15;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));
			$month = $this->arrPeriod[$m];
			if ($this->{$month}) $res++;
		}
		return ($res);
	}	
	
	public function getMonthlySQL(){
	
		for($m=1;$m<=15;$m++){
			// $month = date('M',mktime(0,0,0,$m,15));
			$month = $this->arrPeriod[$m];
			$arrRes[] = "`$month`=".(double)$this->{$month};
		}
		return ($arrRes);
	}
}
?>
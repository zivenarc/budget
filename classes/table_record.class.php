<?php
class table_record {
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
	
	function __construct(){
	
	}
	
	public function set_month_value($i, $value){
		$month = date('M',time(0,0,0,(integer)$i,15));
		$this->{$month} =(double)$value;
		return(true);
	}
	
	public function set_months($rw){
		for ($m=1;$m<13;$m++){
				$month = date('M',time(0,0,0,$m,15));				
				$this->set_month_value($m, $rw[$month]);
		}
	}
	
	public function total(){
		for($m=1;$m<13;$m++){
			$month = date('M',time(0,0,0,$m,15));
			$res += $this->{$month};
		}
		return ($res);
	}	

}
?>
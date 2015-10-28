<?php
include_once ('../common/eiseGrid2/inc_eiseGrid.php');
$arrJS[] ='/common/eiseGrid2/eiseGrid.jQuery.js';
$arrCSS[] = '/common/eiseGrid2/themes/default/screen.css';

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
	
	public $source;
	public $scenario;
	public $company;
	
	protected $oSQL;
	
	function __construct($session, $scenario, $id='', $data=Array()){
		GLOBAL $oSQL;
		
		$this->oSQL = $oSQL;
		$this->source = $session;
		$this->scenario = $scenario;
		$this->id=$id;
		
		if (count($data)){
			for($m=1;$m<13;$m++){
				$month = date('M',mktime(0,0,0,$m,15));
				$this->{$month} = $data[strtolower($month)];			
			}
			$this->company = $data['company'];
		}
	}
	
	public function set_month_value($i, $value){
		$month = date('M',mktime(0,0,0,(integer)$i,15));
		$this->{$month} =(double)$value;
		return(true);
	}
	
	public function set_months($rw){
		for ($m=1;$m<13;$m++){
				$month = date('M',mktime(0,0,0,$m,15));				
				$this->set_month_value($m, $rw[$month]);
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
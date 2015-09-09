<?php
class costs_record{
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
	
	private $oSQL;
	
	function __construct($session, $scenario, $id='', $data=Array()){
		//GLOBAL $Products;
		
		GLOBAL $oSQL;
		
		for($m=1;$m<13;$m++){
			$month = date('M',time(0,0,0,$m,15));
			$this->{$month} = 0;
		}
		$this->id = $id;
		$this->source = $session;
		$this->scenario = $scenario;
		//$this->product_ref = $Products;
		$this->oSQL = $oSQL;
		
		if (count($data)){
			for($m=1;$m<13;$m++){
				$month = date('M',time(0,0,0,$m,15));
				$this->{$month} = $data[strtolower($month)];			
			}
			$this->product = $data['product'];
			$this->item = $data['item'];
			$this->company = $data['company'];
			$this->profit = $data['pc'];
			$this->activity = $data['activity'];
			$this->customer = $data['customer'];
			$this->supplier = $data['supplier'];
			$this->agreement = $data['agreement'];
			$this->comment = $data['comment'];
			$this->unit = $data['unit'];			
			$this->buying_curr = $data['buying_curr'];			
			$this->buying_rate= $data['buying_rate'];	
			$this->period= $data['period'];	
		}		
		return (true);
	}	
		
	public function set_month_value($i, $value){
		$month = date('M',time(0,0,0,(integer)$i,15));
		$this->{$month} =(double)$value;
		return(true);
	}
	
	public function getSQLstring(){
		
		if ($this->flagDeleted && $this->id){
			$res = "DELETE FROM `reg_costs` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
		
		GLOBAL $Products;

		for($m=1;$m<13;$m++){
			$month = date('M',time(0,0,0,$m,15));
			$arrRes[] = "`$month`=".(double)$this->{$month};
		}
			
			//$oProduct = $Products->getByCode($this->product);
			
			$arrRes[] = "`company`='OOO'";
			$arrRes[] = "`pc`=".(integer)$this->profit;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";
			//$arrRes[] = "`customer`='".$this->customer."'";
			$arrRes[] = "`supplier`=".(integer)$this->supplier;
			$arrRes[] = "`item`='".$this->item."'";
			//$arrRes[] = "`product`='".$this->product."'";
			$arrRes[] = "`agreement`=".(integer)$this->agreement;			
			$arrRes[] = "`buying_rate`=".(double)$this->buying_rate;
			$arrRes[] = "`buying_curr`='".$this->buying_curr."'";
			$arrRes[] = "`activity`=".(integer)$this->activity;
			$arrRes[] = "`comment`=".$this->oSQL->e($this->comment);
			$arrRes[] = "`unit`='".$this->unit."'";
			$arrRes[] = "`period`='".$this->period."'";
			if ($this->id){
				$res = "UPDATE `reg_costs` SET ". implode(',',$arrRes)." WHERE id=".$this->id;
			} else {
				$res = "INSERT INTO `reg_costs` SET ". implode(',',$arrRes);
			}
			//echo '<pre>',$res,'</pre>';
			return $res;
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
<?php
require_once('table_record.class.php');

class costs_record extends table_record{

	function __construct($session, $scenario, $id='', $data=Array()){
		
		parent::__construct($session, $scenario, $id, $data);
		
		if (count($data)){
			$this->product = $data['product'];
			$this->item = $data['item'];			
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
		
	public function getSQLstring(){
		
		if ($this->flagDeleted && $this->id){
			$res = "DELETE FROM `reg_costs` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
		
		GLOBAL $Products;

			$arrRes = $this->getMonthlySQL();	
			
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

}
?>
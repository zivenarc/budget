<?php
require_once('table_record.class.php');

class sales_record extends table_record{
	
	function __construct($session, $scenario, $id='', $data=Array()){

		parent::__construct($session, $scenario, $id, $data);
		
		if (count($data)){			
			$this->product = $data['product'];			
			$this->profit = $data['profit'];
			$this->activity = $data['activity'];
			$this->customer = $data['customer'];
			$this->comment = $data['comment'];
			$this->unit = $data['unit'];
			$this->selling_curr = $data['selling_curr'];
			$this->buying_curr = $data['buying_curr'];
			$this->selling_rate = $data['selling_rate'];
			$this->buying_rate= $data['buying_rate'];	
			$this->formula= $data['formula'];	
			$this->kpi= $data['kpi'];	
			$this->sales= $data['sales'];	
			$this->route= $data['route'];	
		}		
		return (true);
	}	
		
	public function getSQLstring(){
		
		GLOBAL $oSQL;
		
		if ($this->flagDeleted && $this->id){
			$res = "DELETE FROM `reg_sales` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
		
		GLOBAL $Products;
		
			$arrRes = $this->getMonthlySQL();		
			
			$oProduct = $Products->getByCode($this->product);
			
			$arrRes[] = "`company`='OOO'";
			$arrRes[] = "`pc`=".$this->profit;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";
			$arrRes[] = "`customer`=".(integer)$this->customer;
			$arrRes[] = "`comment`=".$oSQL->e($this->comment);
			$arrRes[] = "`product`=".(integer)$this->product;
			$arrRes[] = "`selling_rate`=".(double)$this->selling_rate;
			$arrRes[] = "`selling_curr`='".$this->selling_curr."'";
			$arrRes[] = "`buying_rate`=".(double)$this->buying_rate;
			$arrRes[] = "`buying_curr`='".$this->buying_curr."'";
			$arrRes[] = "`activity`=".(integer)$oProduct->activity;
			$arrRes[] = "`unit`='".$oProduct->unit."'";
			$arrRes[] = "`formula`=".$oSQL->e($this->formula);
			$arrRes[] = "`sales`=".$oSQL->e($this->sales);
			$arrRes[] = "`route`=".($this->route?(integer)$this->route:'NULL');
			$arrRes[] = "`kpi`=".(integer)$this->kpi;
			if ($this->id){
				$res = "UPDATE `reg_sales` SET ". implode(',',$arrRes)." WHERE id=".$this->id;
			} else {
				$res = "INSERT INTO `reg_sales` SET ". implode(',',$arrRes);
			}
			//echo '<pre>',$res,'</pre>';
			return $res;
	}
	
}


?>
<?php
require_once('table_record.class.php');

class depreciation_record extends table_record{

	const TABLE='reg_depreciation';
	
	function __construct($session, $scenario, $company, $id='', $data=Array()){
		
		parent::__construct($session, $scenario, $company, $id, $data);
		
		if (count($data)){
			$this->particulars = $data['particulars'];
			$this->item = $data['item'];
			$this->profit = $data['profit'];
			$this->activity = $data['activity'];
			$this->customer = $data['customer'];
			$this->comment = $data['comment'];
			$this->unit = $data['unit'];			
			$this->value_start = $data['value_start'];			
			$this->value_primo = $data['value_primo'];			
			$this->value_ultimo = $data['value_ultimo'];			
			$this->duration = $data['duration'];			
			$this->replace = $data['replace'];			
			$this->date_start = $data['date_start'];			
			$this->date_end = $data['date_end'];			
			$this->replace = $data['replace'];			
			$this->count = $data['count'];			
		}		
		return (true);
	}	
		
	public function getSQLstring(){
		
		if ($this->flagDeleted && $this->id){
			$res = "DELETE FROM `".self::TABLE."` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
		
		GLOBAL $oProducts;

			$arrRes = $this->getMonthlySQL();	
			
			//$oProduct = $oProducts->getByCode($this->product);
			
			$arrRes[] = "`company`='{$this->company}'";
			$arrRes[] = "`pc`=".(integer)$this->profit;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";
			//$arrRes[] = "`customer`='".$this->customer."'";
			// $arrRes[] = "`supplier`=".(integer)$this->supplier;
			$arrRes[] = "`item`='".$this->item."'";
			//$arrRes[] = "`product`='".$this->product."'";
			// $arrRes[] = "`agreement`=".(integer)$this->agreement;			
			$arrRes[] = "`value_start`=".(double)$this->value_start;
			$arrRes[] = "`date_start`=".$this->oSQL->e($this->date_start);
			$arrRes[] = "`date_end`=".$this->oSQL->e($this->date_end);
			$arrRes[] = "`value_primo`=".(double)$this->value_primo;
			$arrRes[] = "`value_ultimo`=".(double)$this->value_ultimo;
			$arrRes[] = "`replace`=".(integer)$this->replace;
			$arrRes[] = "`duration`=".(integer)$this->duration;
			$arrRes[] = "`particulars`='".$this->particulars."'";
			$arrRes[] = "`activity`=".(integer)$this->activity;
			$arrRes[] = "`count`=".(integer)$this->count;
			$arrRes[] = "`comment`=".$this->oSQL->e($this->comment);
			if ($this->id){
				$res = "UPDATE `".self::TABLE."` SET ". implode(',',$arrRes)." WHERE id=".$this->id;
			} else {
				$res = "INSERT INTO `".self::TABLE."` SET ". implode(',',$arrRes);
			}
			//echo '<pre>',$res,'</pre>';
			return $res;
	}

}
?>
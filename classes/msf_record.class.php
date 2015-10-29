<?php
require_once ('table_record.class.php');

class msf_record extends table_record{
	
	const TABLE = 'reg_msf';
	
	function __construct($session, $scenario, $id='', $data=Array()){
		
		parent::__construct($session, $scenario, $id, $data);
		
		if (count($data)){			
			$this->customer = $data['customer'];
			$this->comment = $data['comment'];
			$this->unit = $data['unit'];			
			$this->pc = $data['pc'];			
		}		
		return (true);
	}	
		

	
	public function getSQLstring(){
		
		if ($this->flagDeleted && $this->id){
			$res = "DELETE FROM `".self::TABLE."` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
		
		GLOBAL $Products;

		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$arrRes[] = "`$month`=".(double)$this->{$month};
		}
			
			//$oProduct = $Products->getByCode($this->product);
			
			$arrRes[] = "`company`='OOO'";
			$arrRes[] = "`pc`=".(integer)$this->pc;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";
			// $arrRes[] = "`customer`='".$this->customer."'";
			// $arrRes[] = "`supplier`=".(integer)$this->supplier;
			// $arrRes[] = "`item`='".$this->item."'";
			//$arrRes[] = "`product`='".$this->product."'";
			// $arrRes[] = "`agreement`=".(integer)$this->agreement;			
			// $arrRes[] = "`buying_rate`=".(double)$this->buying_rate;
			// $arrRes[] = "`buying_curr`='".$this->buying_curr."'";
			// $arrRes[] = "`activity`=".(integer)$this->activity;
			$arrRes[] = "`comment`=".$this->oSQL->e($this->comment);
			$arrRes[] = "`unit`='".$this->unit."'";
			// $arrRes[] = "`period`='".$this->period."'";
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
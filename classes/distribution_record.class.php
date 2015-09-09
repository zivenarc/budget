<?php
require_once ('table_record.class.php');

class distribution_record extends table_record{
	
	private $oSQL;
	
	const TABLE = 'reg_rent';
	
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
			$this->customer = $data['customer'];
			$this->comment = $data['comment'];
			$this->unit = $data['unit'];			
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
			$month = date('M',time(0,0,0,$m,15));
			$arrRes[] = "`$month`=".(double)$this->{$month};
		}
			
			//$oProduct = $Products->getByCode($this->product);
			
			$arrRes[] = "`company`='OOO'";
			// $arrRes[] = "`pc`=".(integer)$this->profit;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";
			$arrRes[] = "`customer`='".$this->customer."'";
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
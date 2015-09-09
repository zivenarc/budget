<?php
class depreciation_record{
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
	
	const TABLE='reg_depreciation';
	
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
			
			$this->particulars = $data['particulars'];
			$this->item = $data['item'];
			$this->company = $data['company'];
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
		
	public function set_month_value($i, $value){
		$month = date('M',time(0,0,0,(integer)$i,15));
		$this->{$month} =(double)$value;
		return(true);
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
	
	public function total(){
		for($m=1;$m<13;$m++){
			$month = date('M',time(0,0,0,$m,15));
			$res += $this->{$month};
		}
		return ($res);
	}
}
?>
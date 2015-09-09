<?php
class vehicle_record{
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
	
	const TABLE='reg_vehicles';
	
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
			$this->item = $data['item'];
			$this->company = $data['company'];
			$this->pc = $data['pc'];
			$this->activity = $data['activity'];
			$this->comment = $data['comment'];		
			$this->particulars = $data['particulars'];					
			$this->value_primo = $data['value_primo'];					
		
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
			$arrRes[] = "`$month`=".(integer)$this->{$month};
		}
			
			//$oProduct = $Products->getByCode($this->product);
			
			$arrRes[] = "`company`='OOO'";
			$arrRes[] = "`pc`=".(integer)$this->pc;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";							
			$arrRes[] = "`particulars`=".$this->oSQL->e($this->particulars);
			$arrRes[] = "`activity`=".(integer)$this->activity;
			$arrRes[] = "`value_primo`=".(double)$this->value_primo;
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
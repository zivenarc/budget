<?php
require_once('table_record.class.php');

class vehicle_record extends table_record{
	
	const TABLE='reg_vehicles';
	
	function __construct($session, $scenario, $company, $id='', $data=Array()){
		
		parent::__construct($session, $scenario, $company, $id, $data);
		
		if (count($data)){
			$this->item = $data['item'];
			$this->pc = $data['pc'];
			$this->activity = $data['activity'];
			$this->comment = $data['comment'];		
			$this->particulars = $data['particulars'];					
			$this->value_primo = $data['value_primo'];					
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
}
?>
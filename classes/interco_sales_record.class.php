<?php
require_once('table_record.class.php');

class interco_sales_record extends table_record{
	
	function __construct($session, $scenario, $company, $id='', $data=Array()){

		parent::__construct($session, $scenario, $company, $id, $data);
		
		if (count($data)){
			foreach($data as $key=>$value){
				$this->{$key} = $value;
			}		
		}		
		return (true);
	}	
		
	public function getSQLstring(){
		
		GLOBAL $oSQL;
		
		if ($this->flagDeleted && $this->id){
			$res = "DELETE FROM `reg_interco_sales` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
		
		GLOBAL $oProducts;
		
			$arrRes = $this->getMonthlySQL();		
			
			$arrRes[] = "`company`='{$this->company}'";
			$arrRes[] = "`pc`=".$this->profit;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";
			$arrRes[] = "`customer`=".(integer)$this->customer;
			$arrRes[] = "`customer_group_code`=(SELECT IFNULL(cntGroupID,cntID) FROM common_db.tbl_counterparty WHERE cntID=".(integer)$this->customer.")";
			$arrRes[] = "`comment`=".$oSQL->e($this->comment);			
			$arrRes[] = "`selling_rate`=".(double)$this->selling_rate;
			$arrRes[] = "`selling_curr`='".$this->selling_curr."'";
			$arrRes[] = "`buying_rate`=".(double)$this->buying_rate;
			$arrRes[] = "`buying_curr`='".$this->buying_curr."'";
			$arrRes[] = "`activity`=".(integer)$this->activity;
			$arrRes[] = "`activity_cost`=".(integer)$this->activity_cost;
			$arrRes[] = "`unit`=".$oSQL->e($this->unit);			
			$arrRes[] = "`sales`=".$oSQL->e($this->sales);
			$arrRes[] = "`bdv`=(SELECT usrProfitID FROM stbl_user WHERE usrID=".$oSQL->e($this->sales).")";			
			$arrRes[] = "`kpi`=".(integer)$this->kpi;			
			if ($this->id){
				$res = "UPDATE `reg_interco_sales` SET ". implode(',',$arrRes)." WHERE id=".$this->id;
			} else {
				$res = "INSERT INTO `reg_interco_sales` SET ". implode(',',$arrRes);
			}
			//echo '<pre>',$res,'</pre>';
			return $res;
	}
	
}


?>
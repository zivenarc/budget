<?php
require_once('table_record.class.php');

class sales_record extends table_record{
	
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
			$res = "DELETE FROM `reg_sales` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
		
		GLOBAL $oProducts;
		
			$arrRes = $this->getMonthlySQL();		
			
			$oProduct = $oProducts->getByCode($this->product);
			
			$arrRes[] = "`company`='{$this->company}'";
			$arrRes[] = "`pc`=".$this->profit;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";
			$arrRes[] = "`customer`=".(integer)$this->customer;
			$arrRes[] = "`customer_group_code`=(SELECT IFNULL(cntGroupID,cntID) FROM common_db.tbl_counterparty WHERE cntID=".(integer)$this->customer.")";
			$arrRes[] = "`comment`=".$oSQL->e($this->comment);
			$arrRes[] = "`product`=".(integer)$this->product;
			$arrRes[] = "`selling_rate`=".(double)$this->selling_rate;
			$arrRes[] = "`selling_curr`='".$this->selling_curr."'";
			$arrRes[] = "`buying_rate`=".(double)$this->buying_rate;
			$arrRes[] = "`buying_curr`='".$this->buying_curr."'";
			$arrRes[] = "`activity`=".(integer)$this->activity;
			$arrRes[] = "`unit`=".$oSQL->e($this->unit);
			$arrRes[] = "`formula`=".$oSQL->e($this->formula);
			$arrRes[] = "`sales`=".$oSQL->e($this->sales);
			$arrRes[] = "`pol`=".$oSQL->e($this->pol);
			$arrRes[] = "`pod`=".$oSQL->e($this->pod);
			$arrRes[] = "`bdv`=(SELECT usrProfitID FROM stbl_user WHERE usrID=".$oSQL->e($this->sales).")";
			$arrRes[] = "`route`=".($this->route?(integer)$this->route:'NULL');
			$arrRes[] = "`kpi`=".(integer)$this->kpi;
			$arrRes[] = "`gbr`=".(integer)$this->gbr;
			$arrRes[] = "`hbl`=".(integer)$this->hbl;
			$arrRes[] = "`bo`=".(integer)$this->bo;
			$arrRes[] = "`jo`=".(integer)$this->jo;
			$arrRes[] = "`freehand`=".(integer)$this->freehand;
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
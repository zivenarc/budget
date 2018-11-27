<?php
class sales_ghq_record{
	
	function __construct($data=Array()){		
				
		$this->arrPeriod = Array(1=>'jan',2=>'feb',3=>'mar',4=>'apr',5=>'may',6=>'jun',7=>'jul',8=>'aug',9=>'sep',10=>'oct',11=>'nov',12=>'dec',13=>'jan_1',14=>'feb_1',15=>'mar_1');
		$this->company = $data['company'];
		$this->source = $data['GUID'];
		$this->scenario = $data['scenario'];
		$this->customer = $data['customer'];
		$this->profit = $data['profit'];
		$this->sales = $data['sales'];
		$this->jo = $data['job_owner'];
		$this->bo = $data['business_owner'];
		$this->da = $data['destination_agent'];
		
		$this->masterData = Array();
		
		return (true);
	}	
	
	function addRecord($keys, $data=Array()){
		
		if(!is_array($keys)) return(false);
		
		for($m=1;$m<=15;$m++){
			$month = $this->arrPeriod[$m];
			$this->masterData[$keys['ghq']][$keys['account']][$month] += (double)$data[$month];
		}
	}
	
	public function getSQL(){
		
		GLOBAL $oSQL;
			
			
			
			foreach($this->masterData as $ghq=>$accounts){
				
				foreach($accounts as $account=>$data){								
					
					$arrRes = Array();
					$arrRes[] = "`company`='{$this->company}'";
					$arrRes[] = "`pc`=".$this->profit;
					$arrRes[] = "`source`='".$this->source."'";
					$arrRes[] = "`scenario`='".$this->scenario."'";
					$arrRes[] = "`customer`=".(integer)$this->customer;
					$arrRes[] = "`customer_group_code`=(SELECT IFNULL(cntGroupID,cntID) FROM common_db.tbl_counterparty WHERE cntID=".(integer)$this->customer.")";
					// $arrRes[] = "`comment`=".$oSQL->e($this->comment);						
					$arrRes[] = "`ghq`=".$oSQL->e($ghq);
					$arrRes[] = "`account`=".$oSQL->e($account);
					$arrRes[] = "`sales`=".$oSQL->e($this->sales);
					$arrRes[] = "`bdv`=(SELECT usrProfitID FROM stbl_user WHERE usrID=".$oSQL->e($this->sales).")";
					$arrRes[] = "`gbr`=".(integer)$this->gbr;
					$arrRes[] = "`hbl`=".(integer)$this->hbl;
					$arrRes[] = "`jo`=".(integer)$this->jo;
					$arrRes[] = "`bo`=".(integer)$this->bo;
					$arrRes[] = "`da`=".(integer)$this->da;
					$arrRes[] = "`freehand`=".(integer)$this->freehand;
					
					for($m=1;$m<=15;$m++){
						$month = $this->arrPeriod[$m];
						$arrRes[] = "`{$month}` = '{$data[$month]}'";
					}
					
					$res[] = "INSERT INTO `reg_sales_rhq` SET ". implode(',',$arrRes);
					
				}
							
			}
			
			return $res;
	}
	
		
}


?>
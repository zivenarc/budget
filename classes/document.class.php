<?php
require_once ('../common/easyForm/inc_easyForm.php');

class Document extends easyForm{
	
	public  $profit;
	public  $location;
	public  $scenario;
	public  $flagPosted;
	public  $flagDeleted;
	public  $data;
	// public static $GUID;
	// public static $prefix;
	
	function __construct($id){
		GLOBAL $arrUsrData;			
		GLOBAL $oBudget;
		
		easyForm::__construct("entity", $this->table , $this->prefix, $id, $arrUsrData);
			if ($id) {
				$this->ID=$id;
				$this->refresh($id);
				
				if ($this->flagDeleted || $this->flagPosted){
					$this->flagUpdate = false;
				}
				
				if(!$this->budget->flagUpdate){
					$this->flagUpdate = false;
				}
				
			} else {
				//$this->budget = $oBudget;
				//do nothing
		}
	}
	
	protected function getSqlWhere($id){
		if(!$id) $id=$this->ID;		
		if (preg_match('/^(\{){0,1}[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}(\}){0,1}$/',$id)){
				$sqlWhere = $this->prefix."GUID='".$id."'";
			} else {
				$sqlWhere = $this->prefix.'ID='.(integer)$id;
			}
		return($sqlWhere);
	}
	
	protected function refresh($sql){
	
		$rs = $this->oSQL->q($sql);			
		$this->data = $this->oSQL->f($rs);
						
		$this->GUID = $this->data[$this->prefix.'GUID'];
		$this->flagDeleted = $this->data[$this->prefix.'FlagDeleted'];
		$this->flagPosted = $this->data[$this->prefix.'FlagPosted'];
		$this->scenario = $this->data[$this->prefix.'Scenario'];
		$this->profit = $this->data[$this->prefix.'ProfitID'];
		$this->customer = $this->data[$this->prefix.'CustomerID'];
		$this->location = $this->data[$this->prefix.'LocationID'];
		$this->product_folder = $this->data[$this->prefix.'ProductFolderID'];
		$this->comment = $this->data[$this->prefix.'Comment'];
		$this->amount = $this->data[$this->prefix.'Amount'];
		
		$this->budget = new Budget($this->scenario);
		
		if ($this->data[$this->prefix.'EditDate']){
			$this->timestamp = "Last edited by ".$this->data['usrTitle']." on ".date('d.m.Y H:i',strtotime($this->data[$this->prefix.'EditDate']));
			$this->timestamp_short = date('d.m.Y H:i',strtotime($this->data[$this->prefix.'EditDate']));
			$this->editor = $this->data['usrTitle'];
		};		
	}
	
	public function defineEF(){
		
		GLOBAL $arrUsrData;
		global $budget_scenario;
		
		$this->Columns = Array();
		
		$this->Columns[] = Array(
			'field'=>$this->prefix.'ID'	
		);
		$this->Columns[] = Array(
			'field'=>$this->prefix.'GUID'
			,'type'=>'guid'
		);
		$this->Columns[] = Array(
			'title'=>'Scenario'
			,'field'=>$this->prefix.'Scenario'
			,'type'=>'combobox'
			,'sql'=>'SELECT scnID as optValue, scnTitle as optText FROM tbl_scenario'
			,'default'=>$budget_scenario	
			,'disabled'=>!$this->flagUpdate
		);
		$this->Columns[] = self::getProfitEG();
	}
		
	
	public function fillGrid($grid, $arrFields = Array(), $sqlFrom=""){
		$sqlFields = implode(', ',$arrFields);
		$sqlFrom = $sqlFrom?$sqlFrom:"`".$this->register."`";
		
		$sql = "SELECT *, ".Budget::getYTDSQL()." as YTD, (".Budget::getYTDSQL().")/12 as 'AVG'".($sqlFields?",".$sqlFields:"")."
					FROM $sqlFrom 
					WHERE source='{$this->GUID}'";//to add where
		$rs = $this->oSQL->q($sql);
		while ($rw = $this->oSQL->f($rs)){
			$grid->Rows[] = $rw;
		}
	}
	
	public function get_record($id){	
			$oBR = $this->records[$this->gridName][$id];			
			if (!$oBR){
				$oBR = $this->add_record();				
			}	
			return ($oBR);	
	}
	
	protected function deleteGridRecords(){
				//-------------------Deleting grid records---------------------------------
		$arrDeleted = explode('|',$_POST['inp_'.$this->gridName.'_deleted']);
		if(is_array($arrDeleted)){
			for($i=0;$i<count($arrDeleted);$i++){			
				if ($arrDeleted[$i]) {
					$row = $this->get_record($arrDeleted[$i]);					
					if ($row){		
							$row->flagDeleted = true;												
					}
				}
			}	
			
		}
	}
	
	protected function delete(){
		GLOBAL $arrUsrData;
		if ($arrUsrData['FlagDelete']){
			$sql = Array();
			$sql[] = "SET AUTOCOMMIT=0;";
			$sql[] = "START TRANSACTION;";
			$sql[] = "UPDATE `{$this->table}` SET `{$this->prefix}Amount`=0, `{$this->prefix}FlagDeleted`=1, `{$this->prefix}EditBy`='{$arrUsrData['usrID']}', `{$this->prefix}EditDate`=NOW() WHERE `{$this->prefix}ID`={$this->ID} LIMIT 1;";
			$sql[] = "UPDATE `{$this->register}` SET `active`=0 WHERE `source`='{$this->GUID}';";
			$sql[] = $this->getActionSQL('delete');
			$sql[] = "SET AUTOCOMMIT=1;";
			$sql[] = "COMMIT;";
					
			return($this->doSQL($sql));
			
		} else {
			return (false);
		}
		
	}
	
	protected function restore(){
		GLOBAL $arrUsrData;
		if ($arrUsrData['FlagUpdate']){
			$sql = Array();
			$sql[] = "SET AUTOCOMMIT=0;";
			$sql[] = "START TRANSACTION;";
			$sql[] = "UPDATE `{$this->table}` SET `{$this->prefix}FlagDeleted`=0, `{$this->prefix}EditBy`='{$arrUsrData['usrID']}', `{$this->prefix}EditDate`=NOW() WHERE `{$this->prefix}ID`={$this->ID} LIMIT 1;";
			$sql[] = "UPDATE `{$this->register}` SET `active`=1 WHERE `source`='{$this->GUID}';";
			$sql[] = $this->getActionSQL('restore');
			$sql[] = "SET AUTOCOMMIT=1;";
			$sql[] = "COMMIT;";
					
			return($this->doSQL($sql));
			
		} else {
			return (false);
		}
		
	}
	
	protected function markPosted(){
		GLOBAL $arrUsrData;
		$sql[] = "UPDATE `{$this->table}` 
			SET `{$this->prefix}FlagPosted`=1, `{$this->prefix}EditBy`='{$arrUsrData['usrID']}', `{$this->prefix}EditDate`=NOW() 
			WHERE `{$this->prefix}ID`={$this->ID} LIMIT 1;";
		$sql[] = "UPDATE `{$this->table}`, (SELECT SUM(`Jan`+`Feb`+`Mar`+`Apr`+`May`+`Jun`+`Jul`+`Aug`+`Sep`+`Oct`+`Nov`+`Dec`) as Total, source FROM reg_master GROUP BY source) Budget 
			SET `{$this->prefix}Amount`=`Budget`.`Total`
			WHERE `{$this->prefix}ID`={$this->ID} AND `{$this->prefix}GUID`=`Budget`.`source`;";
		$sql[] = "UPDATE `{$this->register}` SET posted=1 WHERE source='{$this->GUID}';";
		$sql[]=$this->getActionSQL('post', $this->postComment);
		$success = $this->doSQL($sql);
		return($success);
	}
		
	protected function unmarkPosted(){
		GLOBAL $arrUsrData;
		$sql[] = "UPDATE `{$this->table}` 
			SET `{$this->prefix}FlagPosted`=0, `{$this->prefix}EditBy`='{$arrUsrData['usrID']}', `{$this->prefix}EditDate`=NOW() 
			WHERE `{$this->prefix}ID`={$this->ID} LIMIT 1;";
		$sql[] = $this->getActionSQL('unpost');
		$success = $this->doSQL($sql);
		return($success);
	}
	protected function doSQL($sql){
		$sql[]= "COMMIT;";
		$sqlSuccess = true;
		for ($i=0;$i<count($sql);$i++){
			if ($sql[$i]){
				$sqlSuccess &= $this->oSQL->q($sql[$i]);
			}
		}
		return($sqlSuccess);
	}
	
	protected function getActionSQL($action, $comment=''){
		GLOBAL $arrUsrData;
		
		$sql = "INSERT INTO stbl_action_log
					SET aclGUID='{$this->GUID}'
					,aclEntityID='{$this->table}'
					,aclActionID='$action'
					,aclInsertBy='{$arrUsrData['usrID']}'
					,aclComment=".$this->oSQL->e($comment)."
					,aclInsertDate=NOW();";
		
		return($sql);
	}
	
	protected function unpost(){
		$oMaster = new budget_session($this->scenario, $this->GUID);
		$oMaster->clear();
		$oMaster->save();
		$this->unmarkPosted();
	}
	
	protected function getProfitEG(){
		GLOBAL $arrUsrData;
		$res = Array(
			'title'=>'Profit center'
			,'field'=>$this->prefix.'ProfitID'
			,'type'=>'combobox'
			,'sql'=>'SELECT pccID as optValue, pccTitle as optText FROM vw_profit'
			,'default'=>$arrUsrData['empProfitID']
			,'disabled'=>!$this->flagUpdate
		);
		return($res);
	}
	
	protected function getSupplierEG(){
		$res = Array(
				'title'=>'Supplier'
				,'field'=>$this->prefix.'SupplierID'
				,'type'=>'ajax_dropdown'
				,'table'=>'vw_supplier'
				,'source'=>'vw_supplier'
				,'prefix'=>'cnt'
				,'sql'=>"SELECT cntID as optValue, cntTitle as optText FROM vw_supplier"				
				, 'disabled'=>!$this->flagUpdate
				, 'default'=>0
				, 'class'=>'costs_supplier'
			);
		return($res);
	}
	
	protected function getCustomerEG(){
		$res = Array(
			'title'=>'Customer'
			,'field'=>'customer'
			,'type'=>'ajax_dropdown'
			,'table'=>'vw_customer'
			,'source'=>'vw_customer'
			,'prefix'=>'cnt'
			,'sql'=>"SELECT cntID as optValue, cntTitle as optText FROM vw_customer"
			, 'mandatory' => true
			, 'disabled'=>!$this->flagUpdate
			, 'default'=>9907 //[NEW Customer]
		);
		return ($res);
	}
	
	protected function getCurrencyEG($field){
		$res = Array(
			'title'=>'Curr'
			,'field'=>$field
			,'type'=>'combobox'
			,'sql'=>"SELECT curTitle as optValue, curTitle as optText FROM vw_currency"
			,'mandatory'=>true
			,'default'=>'RUB'
			, 'disabled'=>!$this->flagUpdate
		);
		return ($res);
	}
	
	protected function getPeriodEG($field='period'){
		$res = Array(
			'title'=>'Period'
			,'field'=>$field
			,'type'=>'combobox'
			,'arrValues'=>Array('monthly'=>'per month','annual'=>'per annum')
			,'sql'=>Array('monthly'=>'per month','annual'=>'per annum')
			,'mandatory'=>true
			, 'disabled'=>!$this->flagUpdate
		);
		
		return($res);
	}
	
	protected function getActivityEG($field='activity'){
		$res = Array(
			'title'=>'Activity'
			,'field'=>$field
			,'type'=>'combobox'
			,'arrValues'=>Activities::getStructuredRef()
			// ,'sql'=>"SELECT prtID as optValue, prtTitle as optText FROM vw_product_type ORDER BY prtRHQ, prtTitle"
			, 'disabled'=>!$this->flagUpdate
		);
		
		return($res);
	}
	
	protected function getProductEG(){
	
		GLOBAL $Products;
		
		$res = Array(
			'title'=>'Product'
			,'field'=>'product'
			,'type'=>'combobox'
			, 'arrValues'=>$Products->getStructuredRef($this->data["prdIdxLeft"],$this->data["prdIdxRight"])
			// ,'sql'=>"SELECT PRD.prdID as optValue
				// ".
				   // (!empty($this->data["prdIdxLeft"]) 
				   // ? "
					// , GROUP_CONCAT(PRD_P.prdTitle SEPARATOR ' / ') as optText
					// FROM vw_product PRD 
					// INNER JOIN vw_product PRD_P ON PRD_P.prdIdxLeft<=PRD.prdIdxLeft 
						// AND PRD_P.prdIdxRight>=PRD.prdIdxRight AND PRD_P.prdParentID >0 
					// WHERE PRD.prdIdxLeft BETWEEN  '{$this->data["prdIdxLeft"]}' AND '{$this->data["prdIdxRight"]}'
						// AND PRD.prdFlagFolder=0
					// GROUP BY PRD.prdID
					// ORDER BY PRD.prdParentID"
				   // : "
				   // , prdTitle as optText, prdFlagDeleted as optDeleted
				   // FROM vw_product PRD")."      
				// "
			, 'mandatory' => true
			, 'disabled'=>!$this->flagUpdate
		);
		return($res);
	}	
		
	
	public function getJSON(){
		$jsonData  = (array)$this;
		foreach ($jsonData as $key=>$value){
			if (is_a($value,'sql')){
				$jsonData[$key] = null;
			}
			if ($key=='grid'){
				$jsonData[$key] = '[Contains resources, protected]';
			}			
		}
		echo json_encode($jsonData);
	}
	
}
?>
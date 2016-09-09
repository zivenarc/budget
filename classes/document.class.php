<?php
require_once ('../common/easyForm/inc_easyForm.php');
require_once ('master.class.php');

class Document extends easyForm{
	
	public  $profit;
	public  $location;
	public  $scenario;
	public  $flagPosted;
	public  $flagDeleted;
	public  $data;
	
	private $log;
	// public static $GUID;
	// public static $prefix;
	
	function __construct($id){
		GLOBAL $arrUsrData;			
		GLOBAL $oBudget;
		
		easyForm::__construct("entity", $this->table , $this->prefix, $id, $arrUsrData);
			if ($id) {
				$this->ID=$id;
				$this->refresh($id);
				
				$this->settings = $this->budget->getSettings();
				
				if ($this->flagDeleted || $this->flagPosted){
					$this->flagUpdate = false;
				}
				
				if(!$this->budget->flagUpdate){
					$this->flagUpdate = false;
				}
				
				$this->grid = new eiseGrid($this->oSQL
				,$this->gridName
				, Array(
						'flagKeepLastRow' => false
						, 'arrPermissions' => Array("FlagWrite" => $this->flagUpdate)
						, 'flagStandAlone' => true
						, 'controlBarButtons' => "add|delete"
						)
				);
				
				$this->grid->Columns[]=Array(
					'field'=>"id"
					,'type'=>'row_id'
				);
				
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
		$this->CopyOf = $this->data[$this->prefix.'CopyOf'];
		$this->flagDeleted = $this->data[$this->prefix.'FlagDeleted'];
		$this->flagPosted = $this->data[$this->prefix.'FlagPosted'];
		$this->scenario = $this->data[$this->prefix.'Scenario'];
		$this->profit = $this->data[$this->prefix.'ProfitID'];
		$this->company = $this->data[$this->prefix.'CompanyID'];
		$this->customer = $this->data[$this->prefix.'CustomerID'];
		$this->supplier = $this->data[$this->prefix.'SupplierID'];		
		$this->product_folder = $this->data[$this->prefix.'ProductFolderID'];
		$this->comment = $this->data[$this->prefix.'Comment'];
		$this->amount = $this->data[$this->prefix.'Amount'];
		$this->classified = $this->data[$this->prefix.'ClassifiedBy'];
		$this->type = $this->data[$this->prefix.'Type'];
		
		$this->budget = new Budget($this->scenario);
		
		if ($this->data[$this->prefix.'EditDate']){
			$this->timestamp = "Last edited by ".$this->data['usrTitle']." on ".date('d.m.Y H:i',strtotime($this->data[$this->prefix.'EditDate']));
			$this->timestamp_short = date('d.m.Y H:i',strtotime($this->data[$this->prefix.'EditDate']));
			$this->editor = $this->data['usrTitle'];
		};		
	}
	
	public function add_record(){		
		$reflector = new ReflectionClass($this->gridClass);
		$oBR = $reflector->newInstance ($this->GUID,$this->scenario);
		$this->records[$this->gridName][] = $oBR;
		return ($oBR);	
	}
	
	protected function save($mode='update'){
		GLOBAL $arrUsrData;
				
		$this->scenario = isset($_POST[$this->prefix.'Scenario'])?$_POST[$this->prefix.'Scenario']:$this->scenario;
		$this->company = isset($_POST[$this->prefix.'CompanyID'])?$_POST[$this->prefix.'CompanyID']:$this->company;
		$this->comment = isset($_POST[$this->prefix.'Comment'])?$_POST[$this->prefix.'Comment']:$this->comment;
		
		$this->Update();
		
		// if (!$this->ID){
			// $this->Update();
			// return(true);
		// }
		
		switch ($mode){
			case 'new':
				return (true);
				break;
			case 'update':
			case 'post':
				$this->_updateSpecificFields();
				break;
			case 'delete':
				$this->delete();
				break;
			case 'restore':
				$this->restore();
				break;
			case 'unpost':
				if ($this->flagDeleted){
					return (false);
				} else {
					$this->unpost();
				}
				break;				
			case 'repost':
				$this->unpost();
				$this->post();
				break;				
		}		
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
			,'sql'=>'SELECT scnID as optValue, scnTitle as optText FROM tbl_scenario '.($this->flagUpdate?" WHERE scnFlagReadOnly=0":"")
			,'default'=>$budget_scenario	
			,'disabled'=>!$this->flagUpdate
		);
		$this->Columns[] = self::getProfitEG();
		
		$this->Columns[] = Array('title'=>'Comments','field'=>$this->prefix.'Comment','type'=>'text', 'disabled'=>!$this->flagUpdate);
	}
		
	
	public function fillGrid($grid, $arrFields = Array(), $sqlFrom=""){
		if ($this->ID){
			$sqlFields = implode(', ',$arrFields);
			$sqlFrom = $sqlFrom?$sqlFrom:"`".$this->register."`";
			
			$sql = "SELECT *, ".$this->budget->getYTDSQL(1,$this->budget->length)." as YTD, (".$this->budget->getYTDSQL(1,$this->budget->length).")/".$this->budget->length." as 'AVG'".($sqlFields?",".$sqlFields:"")."
						FROM $sqlFrom 
						WHERE source='{$this->GUID}'";//to add where
			$rs = $this->oSQL->q($sql);
			while ($rw = $this->oSQL->f($rs)){
				$grid->Rows[] = $rw;
			}
		} else {
			return (false);
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
	
	public function classify(){
		GLOBAL $arrUsrData;
		//if ($arrUsrData['FlagUpdate']){
		if (true){
			$sql = Array();
			$sql[] = "SET AUTOCOMMIT=0;";
			$sql[] = "START TRANSACTION;";
			$sql[] = "UPDATE `{$this->table}` SET `{$this->prefix}ClassifiedBy`='{$arrUsrData['usrID']}', `{$this->prefix}EditBy`='{$arrUsrData['usrID']}', `{$this->prefix}EditDate`=NOW() WHERE `{$this->prefix}ID`={$this->ID} LIMIT 1;";			
			$sql[] = $this->getActionSQL('classify');
			$sql[] = "SET AUTOCOMMIT=1;";
			$sql[] = "COMMIT;";
				//echo '<pre>';print_r($sql);echo '</pre>';
			return($this->doSQL($sql));
			
		} else {
			return (false);
		}
		
	}
	
	public function declassify(){
		GLOBAL $arrUsrData;
		if ($arrUsrData['FlagUpdate']){
			$sql = Array();
			$sql[] = "SET AUTOCOMMIT=0;";
			$sql[] = "START TRANSACTION;";
			$sql[] = "UPDATE `{$this->table}` SET `{$this->prefix}ClassifiedBy`='', `{$this->prefix}EditBy`='{$arrUsrData['usrID']}', `{$this->prefix}EditDate`=NOW() WHERE `{$this->prefix}ID`={$this->ID} LIMIT 1;";			
			$sql[] = $this->getActionSQL('declassify');
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
		$sql[] = "UPDATE `{$this->table}`, (SELECT SUM(".$this->budget->getYTDSQL(1+$this->budget->offset,max($this->budget->length,12+$this->budget->offset)).") as Total, source 
							FROM reg_master 
							WHERE account NOT LIKE 'SZ%' 
							GROUP BY source) Budget 
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
		if($this->flagDeleted){
			return(false);
		} else {
			if (!$this->flagPosted){
				return (true);
			}			
			$oMaster = new Master($this->scenario, $this->GUID);
			$oMaster->clear();
			$oMaster->save();
			$res = $this->unmarkPosted();
			return ($res);
		}
	}
	
	protected function _updateSpecificFields(){
		//to be defined in specific class
	}
	
	protected function _updateGrid(){
		//to be defined in specific class
	}
	
	protected function post(){
		
		$this->_specificPost();
	}
	
	protected function _specificPost(){
		//to be defined in specific class
	}
	
	protected function getResponsibleEF(){
		GLOBAL $arrUsrData;
		$res = Array(
			'title'=>'Responsible'
			,'field'=>$this->prefix.'UserID'
			,'type'=>'ajax'
			,'table'=>'stbl_user'
			,'prefix'=>'usr'
			,'sql'=>'stbl_user'
			,'mandatory'=>true
			,'default'=>$arrData['usrID']
			,'disabled'=>!$this->flagUpdate
		);
		
		return ($res);
	}
	
	protected function getProfitEG(){
		GLOBAL $arrUsrData;
		$res = Array(
			'title'=>'Profit center'
			,'field'=>$this->prefix.'ProfitID'
			,'type'=>'combobox'
			,'width'=>'80px'
			,'sql'=>'SELECT pccID as optValue, pccTitle as optText FROM vw_profit WHERE pccFlagFolder=0'
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
				,'width'=>'100px'
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
			,'width'=>'100px'
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
			,'width'=>'40px'
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
			,'width'=>'40px'
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
			,'width'=>'100px'
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
			,'width'=>'100px'
			,'arrValues'=>$Products->getStructuredRef($this->data["prdIdxLeft"],$this->data["prdIdxRight"])
			,'source'=>"vw_product_select"      							
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
	
	public function setMonthlyEG($type='decimal', $flagDisableActual=true){
		
		if(!$this->grid) return (false);
		$start = (integer)date('n',$this->budget->date_start);
		
		for ($m=1+$this->budget->offset;$m<=max(12+$this->budget->offset,$this->budget->length);$m++){
			
			$flagDisabled = !$this->flagUpdate;
			$strClassDisabled = '';
			
			if (strpos($this->budget->type,'FYE')!==false){				
				if ($m < $start && $flagDisableActual) {
					$flagDisabled = true;
					$strClassDisabled = ' budget-inactive';
				}
			}
			
			$month = $this->budget->arrPeriod[$m];					
			$this->grid->Columns[] = Array(
				'title'=>ucfirst($month)
				,'field'=>strtolower($month)
				,'class'=>'budget-month'.$strClassDisabled
				,'type'=>$type
				, 'mandatory' => true
				, 'disabled'=>$flagDisabled
				,'totals'=>true
				,'witdh'=>'10%'
			);
		}
	}
	
	function log($data){
		$this->log[] = var_export($data, true);
	}

	function getSales($customer=0){
		$sql = "SELECT cntUserID FROM common_db.tbl_counterparty WHERE cntID={$customer}";
		$rs = $this->oSQL->q($sql);
		$res = strtoupper($this->oSQL->get_data($rs));
		return($res);
	}
}

?>
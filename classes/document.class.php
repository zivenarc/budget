<?php
include_once ('../common/easyForm/inc_easyForm.php');

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
		easyForm::__construct("entity", $this->table , $this->prefix, $id, $arrUsrData);
			if ($id) {
				$this->ID=$id;
				$this->refresh($id);
			} else {
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
		$this->location = $this->data[$this->prefix.'LocationID'];
		
		
		if ($this->data[$this->prefix.'EditDate']){
			$this->timestamp = "Last edited by ".$this->data['usrTitle']." on ".date('d.m.Y H:i',strtotime($this->data[$this->prefix.'EditDate']));
		};		
	}
	
	public function fillGrid($grid){
		$sql = "SELECT *, ".Budget::getYTDSQL()." as YTD FROM `".$this->register."` WHERE source='{$this->GUID}'";//to add where
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
			$sql[] = "UPDATE `{$this->table}` SET `{$this->prefix}FlagDeleted`=1, `{$this->prefix}EditBy`='{$arrUsrData['usrID']}', `{$this->prefix}EditDate`=NOW() WHERE `{$this->prefix}ID`={$this->ID} LIMIT 1;";
			// $sql[] = "UPDATE `{$this->register}` SET `active`=0 WHERE `source`={$this->GUID};"
			$sql[] = $this->getActionSQL('delete');
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
		$sql[]=$this->getActionSQL('post');
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
			// echo '<pre>',$sql[$i],'</pre>';
			$sqlSuccess &= $this->oSQL->q($sql[$i]);
		}
		return($sqlSuccess);
	}
	
	protected function getActionSQL($action){
		GLOBAL $arrUsrData;
		
		$sql = "INSERT INTO stbl_action_log
					SET aclGUID='{$this->GUID}'
					,aclEntityID='{$this->table}'
					,aclActionID='$action'
					,aclInsertBy='{$arrUsrData['usrID']}'
					,aclInsertDate=NOW();";
		
		return($sql);
	}
	
	protected function unpost(){
		$oMaster = new budget_session($this->scenario, $this->GUID);
		$oMaster->clear();
		$oMaster->save();
		$this->unmarkPosted();
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
			, 'disabled'=>false
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
		);
		return ($res);
	}
}
?>
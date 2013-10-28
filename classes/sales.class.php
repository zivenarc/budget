<?php
include_once ('classes/budget.class.php');
include_once ('../common/eiseGrid/inc_eiseGrid.php');
include_once ('../common/easyForm/inc_easyForm.php');
include_once ('classes/reference.class.php');
include_once ('classes/product.class.php');
include_once ('classes/yact_coa.class.php');

$Products = new Products ();
$Activities = new Activities ();
$YACT = new YACT_COA();

$arrJS[] = '../common/eiseGrid/eiseGrid.js';
$arrCSS[] = '../common/eiseGrid/eiseGrid.css';

class Sales extends easyForm{

	const Register='reg_sales';
	const GridName = 'sales';
	
	function __construct($id=''){
		GLOBAL $strLocal;
		GLOBAL $arrUsrData;
		
		$this->gridName = 'sales';
		
		parent::__construct("entity", "tbl_sales", "sal", $id, $arrUsrData);
		if ($id) {
			$this->ID=$id;
			$this->refresh($id);
		} else {
			//do nothing
		}
	}
	public function refresh($id){
		
		if(!$id) $id=$this->ID;
		
		if (preg_match('/^(\{){0,1}[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}(\}){0,1}$/',$id)){
				$sqlWhere = "salGUID='".$id."'";
			} else {
				$sqlWhere = 'salID='.(integer)$id;
			}
		
		$sql = "SELECT SAL.*, prdIdxLeft, prdIdxRight, usrTitle FROM tbl_sales SAL
				LEFT JOIN vw_product ON prdID=salProductFolderID
				LEFT JOIN stbl_user ON usrID=salEditBy
				WHERE $sqlWhere";
		
		$rs = $this->oSQL->q($sql);			
		$this->data = $this->oSQL->f($rs);
						
		$this->GUID = $this->data['salGUID'];
		$this->flagDeleted = $this->data['salFlagDeleted'];
		$this->flagPosted = $this->data['salFlagPosted'];
		$this->scenario = $this->data['salScenario'];
		$this->profit = $this->data['salProfitID'];
		
		
		if ($this->data['salEditDate']){
			$this->timestamp = "Last edited by ".$this->data['usrTitle']." on ".date('d.m.Y H:i',strtotime($this->data['salEditDate']));
		};
		
		if($this->GUID){
			$sql = "SELECT * FROM `".self::Register."` WHERE `source`='".$this->GUID."';";
			$rs = $this->oSQL->q($sql);			
			while($rw = $this->oSQL->f($rs)){
				$this->records['sales'][$rw['id']] = new sales_record($this->GUID, $this->scenario, $rw['id'], $rw);
			}		
		}
	}
	
	public function defineEF(){
	
		global $arrUsrData;
		global $budget_scenario;
	
		$this->Columns = Array();
		
		$this->Columns[] = Array(
			'field'=>'salID'	
		);
		$this->Columns[] = Array(
			'field'=>'salGUID'
			,'type'=>'guid'
		);
		$this->Columns[] = Array(
			'title'=>'Scenario'
			,'field'=>'salScenario'
			,'type'=>'combobox'
			,'sql'=>'SELECT scnID as optValue, scnTitle as optText FROM tbl_scenario'
			,'default'=>$budget_scenario			
		);
		$this->Columns[] = Array(
			'title'=>'Profit center'
			,'field'=>'salProfitID'
			,'type'=>'combobox'
			,'sql'=>'SELECT pccID as optValue, pccTitle as optText FROM vw_profit'
			,'default'=>$arrUsrData['usrProfitID']
		);
		$this->Columns[] = Array(
			'title'=>'Product folder'
			,'field'=>'salProductFolderID'
			,'type'=>'combobox'
			,'sql'=>'
				SELECT 
				PRD1.prdID AS optValue, PRD1.prdTitle AS optText, PRD1.prdParentID
				, COUNT(DISTINCT PRD2.prdID) as prdLevelInside     
				FROM vw_product PRD1 INNER JOIN vw_product PRD2 ON PRD2.prdIdxLeft<=PRD1.prdIdxLeft AND PRD2.prdIdxRight>=PRD1.prdIdxRight
				WHERE PRD1.prdIdxRight-PRD1.prdIdxLeft>1
				GROUP BY PRD1.prdID
				HAVING prdLevelInside=1'
			,'default'=>22
		);
		$this->Columns[] = Array(
			'title'=>'Comments'
			,'field'=>'salComment'
			,'type'=>'text'
		);
	}
	
	public function defineGrid(){
		$grid = new eiseGrid($this->oSQL
                    ,$this->gridName
                    , Array(
                            'flagKeepLastRow' => false
                            , 'arrPermissions' => Array("FlagWrite" => !$this->flagPosted)
                            , 'flagStandAlone' => true
							, 'controlBarButtons' => "add"
                            )
                    );
		$grid->Columns[]=Array(
			'field'=>"id"
			,'type'=>'row_id'
		);
		$grid->Columns[] = Array(
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
		$grid->Columns[] = Array(
			'title'=>'Product'
			,'field'=>'product'
			,'type'=>'combobox'
			,'sql'=>"SELECT PRD.prdID as optValue
				".
				   (!empty($this->data["prdIdxLeft"]) 
				   ? "
					, GROUP_CONCAT(PRD_P.prdTitle SEPARATOR ' / ') as optText
					FROM vw_product PRD 
					INNER JOIN vw_product PRD_P ON PRD_P.prdIdxLeft<=PRD.prdIdxLeft 
						AND PRD_P.prdIdxRight>=PRD.prdIdxRight AND PRD_P.prdParentID >0 
					WHERE PRD.prdIdxLeft BETWEEN  '{$this->data["prdIdxLeft"]}' AND '{$this->data["prdIdxRight"]}'
						AND PRD.prdFlagFolder=0
					GROUP BY PRD.prdID
					ORDER BY PRD.prdParentID"
				   : "
				   , prdTitle as optText, prdFlagDeleted as optDeleted
				   FROM vw_product PRD")."      
				"
			, 'mandatory' => true
			, 'disabled'=>false
		);
		$grid->Columns[] = Array(
			'title'=>'Description'
			,'field'=>'comment'
			,'type'=>'text'
			, 'disabled'=>false
		);
		$grid->Columns[] =Array(
			'title'=>'Unit'
			,'field'=>'unit'
			,'type'=>'text'
			,'mandatory'=>true
		);

		$grid->Columns[] =Array(
			'title'=>'Selling rate'
			,'field'=>'selling_rate'
			,'type'=>'money'
			,'mandatory'=>true
		);
		$grid->Columns[] =Array(
			'title'=>'Curr'
			,'field'=>'selling_curr'
			,'type'=>'combobox'
			,'sql'=>"SELECT curTitle as optValue, curTitle as optText FROM vw_currency"
			,'mandatory'=>true
			,'default'=>'RUB'
		);
		$grid->Columns[] =Array(
			'title'=>'Buying rate'
			,'field'=>'buying_rate'
			,'type'=>'money'
			,'mandatory'=>true
			
		);
		$grid->Columns[] =Array(
			'title'=>'Curr'
			,'field'=>'buying_curr'
			,'type'=>'combobox'
			,'sql'=>"SELECT curTitle as optValue, curTitle as optText FROM vw_currency"
			,'mandatory'=>true
			,'default'=>'RUB'
		);
		for ($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m));
					
			$grid->Columns[] = Array(
			'title'=>$month
			,'field'=>strtolower($month)
			,'class'=>'budget-month'
			,'type'=>'int'
			, 'mandatory' => true
			, 'disabled'=>false
			,'totals'=>true
		);
		}
		$grid->Columns[] =Array(
			'title'=>'Total'
			,'field'=>'YTD'
			,'type'=>'integer'
			,'totals'=>true
			,'disabled'=>true
		);
		
		return ($grid);
	}
	
	public function fillGrid($grid){
		$sql = "SELECT *, ".Budget::getYTDSQL()." as YTD FROM `".self::Register."` WHERE source='{$this->GUID}'";//to add where
		$rs = $this->oSQL->q($sql);
		while ($rw = $this->oSQL->f($rs)){
			$grid->Rows[] = $rw;
		}
	}
	
	public function add_record(){		
		$oBR = new sales_record($this->GUID,$this->scenario);
		$this->records['sales'][] = $oBR;
		return ($oBR);	
	}
	public function get_record($id){
		//$oBR = new sales_record($this->GUID,$this->scenario,$id);
		//if ($id){
			$oBR = $this->records['sales'][$id];			
			if (!$oBR){
				$oBR = $this->add_record();				
			}	
			return ($oBR);	
		//} else {
		//	return(false);
		//}
	}
	
	public function save($mode='update'){
		
		GLOBAL $arrUsrData;
		GLOBAL $Activities;
		GLOBAL $YACT;
		
		if (!$this->ID){
			$this->Update();
			return(true);
		}
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		
		$this->profit = $_POST['salProfitID'];
		$this->product_folder = $_POST['salProductFolderID'];
		$this->comment = $_POST['salComment'];
		
		//-------------------Updating grid records---------------------------------
		$arrUpdated = $_POST['inp_'.$this->gridName.'_updated'];
		if(is_array($arrUpdated)){
			$nRows = count($_POST['inp_'.$this->gridName.'_updated']);
			for($id=1;$id<$nRows;$id++){		

				$row = $this->get_record($_POST['id'][$id]);					

				if ($row){
					if ($arrUpdated[$id]){				
						$row->flagUpdated = true;				
						$row->profit = $_POST['salProfitID'];
						$row->product = $_POST['product'][$id];				
						$row->customer = $_POST['customer'][$id];				
						$row->selling_rate = str_replace(',','',$_POST['selling_rate'][$id]);				
						$row->selling_curr = $_POST['selling_curr'][$id];				
						$row->buying_rate = str_replace(',','',$_POST['buying_rate'][$id]);				
						$row->buying_curr = $_POST['buying_curr'][$id];				
						for ($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m));
							$row->{$month} = (integer)$_POST[strtolower($month)][$id];
						}					
					} else {
						$row->flagUpdated = false;
					}
				}
			}	
		}
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
		
		$settings = Budget::getSettings($this->oSQL,$this->scenario);
		// echo '<pre>';print_r($settings);echo '</pre>';
				
			
			if ($mode=='post'){
				$this->flagPosted = 1;
			}
			if ($mode=='unpost'){
				$this->flagPosted = 0;
			}
			
		
		$sql = Array();
		$sql[] = "SET AUTOCOMMIT = 0;";
		$sql[] = "START TRANSACTION;";
		$sql[] = "UPDATE `tbl_sales` 
				SET salProfitID=".(integer)$this->profit."
				,salProductFolderID=".(integer)$this->product_folder."
				,salComment=".$this->oSQL->e($this->comment)."
				,salScenario='".$this->scenario."'
				,salFlagPosted = ".$this->flagPosted."
				,salEditBy='".$arrUsrData['usrID']."'
				,salEditDate=NOW()
				WHERE salID={$this->ID};";
		if(is_array($this->records['sales'])){			
			foreach ($this->records['sales'] as $i=>$row){				
				if ($row->flagUpdated || $row->flagDeleted){
					$sql[] = $row->getSQLstring();
				}
			}
		};
		
		if ($mode!='update'){
			$sql[]="INSERT INTO stbl_action_log
					SET aclGUID='".$this->GUID."'
					,aclEntityID='tbl_sales'
					,aclActionID='$mode'
					,aclInsertBy='{$arrUsrData['usrID']}'
					,aclInsertDate=NOW();";
		}
		
		$sql[] = "SET AUTOCOMMIT = 1;";
		$sql[] = 'COMMIT;';				
		//echo '<pre>';print_r($sql);echo '</pre>';die();
		$sqlSuccess = true;
		for ($i=0;$i<count($sql);$i++){
			$sqlSuccess &= $this->oSQL->do_query($sql[$i]);
		}
		
		if ($mode=='unpost'){
			$oMaster = new budget_session($this->scenario, $this->GUID);
			$oMaster->clear();
			$oMaster->save();
		}
		
		if($mode=='post'){
			$this->refresh($this->ID);
			$oMaster = new budget_session($this->scenario, $this->GUID);
			
			if(is_array($this->records['sales'])){
				foreach($this->records['sales'] as $id=>$record){
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->profit;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					
					$activity = $Activities->getByCode($record->activity);
					$account = $YACT->getByCode($activity->YACT);
					
					$master_row->account = $account;
					$master_row->item = $activity->item_income;
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m));
						$master_row->{$month} = ($record->{$month})*$record->selling_rate*$settings[strtolower($record->selling_curr)];
					}				
					
					$master_row = $oMaster->add_master();
					$master_row->profit = $this->profit;
					$master_row->activity = $record->activity;
					$master_row->customer = $record->customer;				
					
					$activity = $Activities->getByCode($record->activity);
					$account = $YACT->getByCode('J00802');
					
					$master_row->account = $account;
					$master_row->item = $activity->item_cost;
					for($m=1;$m<13;$m++){
						$month = date('M',mktime(0,0,0,$m));
						$master_row->{$month} = -($record->{$month})*$record->buying_rate*$settings[strtolower($record->buying_curr)];
					}
					
					//echo '<pre>';print_r($master_row);echo '</pre>';
				

					
				}
				$oMaster->save();
			}
		}
		
		return($sqlSuccess);
				
	}
	
}

class sales_record{
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
	
	function __construct($session, $scenario, $id='', $data=Array()){
		//GLOBAL $Products;
		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m));
			$this->{$month} = 0;
		}
		$this->id = $id;
		$this->source = $session;
		$this->scenario = $scenario;
		//$this->product_ref = $Products;
		
		if (count($data)){
			for($m=1;$m<13;$m++){
				$month = date('M',mktime(0,0,0,$m));
				$this->{$month} = $data[strtolower($month)];			
			}
			$this->product = $data['product'];
			$this->company = $data['company'];
			$this->profit = $data['profit'];
			$this->activity = $data['activity'];
			$this->customer = $data['customer'];
			$this->unit = $data['unit'];
			$this->selling_curr = $data['selling_curr'];
			$this->buying_curr = $data['buying_curr'];
			$this->selling_rate = $data['selling_rate'];
			$this->buying_rate= $data['buying_rate'];	
		}		
		return (true);
	}	
		
	public function set_month_value($i, $value){
		$month = date('M',mktime(0,0,0,(integer)$i));
		$this->{$month} =(double)$value;
		return(true);
	}
	
	public function getSQLstring(){
		
		if ($this->flagDeleted && $this->id){
			$res = "DELETE FROM `reg_sales` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
		
		GLOBAL $Products;

		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m));
			$arrRes[] = "`$month`=".(integer)$this->{$month};
		}
			
			$oProduct = $Products->getByCode($this->product);
			
			$arrRes[] = "`company`='OOO'";
			$arrRes[] = "`pc`=".$this->profit;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";
			$arrRes[] = "`customer`='".$this->customer."'";
			$arrRes[] = "`product`='".$this->product."'";
			$arrRes[] = "`selling_rate`='".$this->selling_rate."'";
			$arrRes[] = "`selling_curr`='".$this->selling_curr."'";
			$arrRes[] = "`buying_rate`='".$this->buying_rate."'";
			$arrRes[] = "`buying_curr`='".$this->buying_curr."'";
			$arrRes[] = "`activity`='".$oProduct->activity."'";
			$arrRes[] = "`unit`='".$oProduct->unit."'";
			if ($this->id){
				$res = "UPDATE `reg_sales` SET ". implode(',',$arrRes)." WHERE id=".$this->id;
			} else {
				$res = "INSERT INTO `reg_sales` SET ". implode(',',$arrRes);
			}
			//echo '<pre>',$res,'</pre>';
			return $res;
	}
	
	public function total(){
		for($m=1;$m<12;$m++){
			$month = date('M',mktime(0,0,0,$m));
			$res += $this->{$month};
		}
		return ($res);
	}
}

?>


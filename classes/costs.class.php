<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('../common/eiseGrid/inc_eiseGrid.php');
include_once ('classes/reference.class.php');
include_once ('classes/yact_coa.class.php');

//$Activities = new Activities ();
$YACT = new YACT_COA();

$arrJS[] = '../common/eiseGrid/eiseGrid.js';
$arrCSS[] = '../common/eiseGrid/eiseGrid.css';

class Location_costs extends Document{

	const Register='reg_costs';
	const GridName = 'location_costs';
	const Prefix = 'lco';
	const Table = 'tbl_location_costs';
	
	function __construct($id=''){
		GLOBAL $strLocal;
		//GLOBAL $arrUsrData;
		
		$this->gridName = self::GridName;
		$this->table = self::Table;
		$this->prefix = self::Prefix;
		$this->register = self::Register;
		
		parent::__construct($id);	

	}
	public function refresh($id){
		
		$sqlWhere = $this->getSqlWhere($id);
		
		$sql = "SELECT LCO.*, usrTitle FROM tbl_location_costs LCO
				LEFT JOIN stbl_user ON usrID=lcoEditBy
				WHERE $sqlWhere";
		
		parent::refresh($sql);
		
		if($this->GUID){
			$sql = "SELECT * FROM `".$this->register."` WHERE `source`='".$this->GUID."';";
			$rs = $this->oSQL->q($sql);			
			while($rw = $this->oSQL->f($rs)){
				$this->records[$this->gridName][$rw['id']] = new costs_record($this->GUID, $this->scenario, $rw['id'], $rw);
			}		
		}
	}
	
	public function defineEF(){
	
		global $arrUsrData;
		global $budget_scenario;
	
		$this->Columns = Array();
		
		$this->Columns[] = Array(
			'field'=>self::Prefix.'ID'	
		);
		$this->Columns[] = Array(
			'field'=>self::Prefix.'GUID'
			,'type'=>'guid'
		);
		$this->Columns[] = Array(
			'title'=>'Scenario'
			,'field'=>self::Prefix.'Scenario'
			,'type'=>'combobox'
			,'sql'=>'SELECT scnID as optValue, scnTitle as optText FROM tbl_scenario'
			,'default'=>$budget_scenario			
		);
		$this->Columns[] = Array(
			'title'=>'Location'
			,'field'=>self::Prefix.'LocationID'
			,'type'=>'combobox'
			,'sql'=>'SELECT locID as optValue, locTitle as optText FROM vw_location'
			,'default'=>$arrUsrData['empLocationID']
		);
		$this->Columns[] = Array(
			'title'=>'Comments'
			,'field'=>self::Prefix.'Comment'
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
			'title'=>'Supplier'
			,'field'=>'supplier'
			,'type'=>'ajax_dropdown'
			,'table'=>'vw_supplier'
			,'source'=>'vw_supplier'
			,'prefix'=>'cnt'
			,'sql'=>"SELECT cntID as optValue, cntTitle as optText FROM vw_supplier"
			, 'mandatory' => true
			, 'disabled'=>false
			, 'default'=>0
			, 'class'=>'costs_supplier'
		);		

		$grid->Columns[] = Array(
			'title'=>'Item'
			,'field'=>'item'
			,'type'=>'combobox'
			,'sql'=>"SELECT itmGUID as optValue, itmTitle as optText, itmFlagDeleted as optDeleted FROM vw_item;"
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
			'title'=>'Rate'
			,'field'=>'buying_rate'
			,'type'=>'money'
			,'mandatory'=>true
			
		);
		
		$grid->Columns[] = parent::getCurrencyEG('buying_curr');
		
		for ($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
					
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
	

	
	public function add_record(){		
		$oBR = new costs_record($this->GUID,$this->scenario);
		$this->records[$this->gridName][] = $oBR;
		return ($oBR);	
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
		
		$this->location = $_POST[self::Prefix.'LocationID'];
		$this->comment = $_POST[self::Prefix.'Comment'];
		$this->scenario = $_POST[self::Prefix.'Scenario'];
		
		//-------------------Updating grid records---------------------------------
		$arrUpdated = $_POST['inp_'.$this->gridName.'_updated'];
		if(is_array($arrUpdated)){
			$nRows = count($_POST['inp_'.$this->gridName.'_updated']);
			for($id=1;$id<$nRows;$id++){		

				$row = $this->get_record($_POST['id'][$id]);					

				if ($row){
					if ($arrUpdated[$id]){				
						$row->flagUpdated = true;				
						// $row->profit = $_POST['salProfitID'];
						// $row->product = $_POST['product'][$id];				
						$row->item = $_POST['item'][$id];				
						$row->supplier = $_POST['supplier'][$id];				
						$row->agreement = $_POST['agreement'][$id];				
						// $row->selling_rate = str_replace(',','',$_POST['selling_rate'][$id]);				
						// $row->selling_curr = $_POST['selling_curr'][$id];				
						$row->buying_rate = str_replace(',','',$_POST['buying_rate'][$id]);				
						$row->buying_curr = $_POST['buying_curr'][$id];				
						$row->unit = $_POST['unit'][$id];				
						$row->comment = $_POST['comment'][$id];				
						for ($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$row->{$month} = (integer)$_POST[strtolower($month)][$id];
						}					
					} else {
						$row->flagUpdated = false;
					}
				}
			}	
		}
		
		$this->deleteGridRecords();
		
		$settings = Budget::getSettings($this->oSQL,$this->scenario);
		// echo '<pre>';print_r($settings);echo '</pre>';			
		
		$sql = Array();
		$sql[] = "SET AUTOCOMMIT = 0;";
		$sql[] = "START TRANSACTION;";
		$sql[] = "UPDATE `tbl_location_costs` 
				SET lcoLocationID=".(integer)$this->location."				
				,lcoComment=".$this->oSQL->e($this->comment)."
				,lcoScenario='".$this->scenario."'
				,lcoEditBy='".$arrUsrData['usrID']."'
				,lcoEditDate=NOW()
				WHERE lcoID={$this->ID};";
		if(is_array($this->records[$this->gridName])){			
			foreach ($this->records[$this->gridName] as $i=>$row){				
				if ($row->flagUpdated || $row->flagDeleted){
					$sql[] = $row->getSQLstring();
				}
			}
		};
		
		$sql[] = "SET AUTOCOMMIT = 1;";
		$sql[] = 'COMMIT;';				
		//echo '<pre>';print_r($sql);echo '</pre>';die();
		$sqlSuccess = $this->doSQL($sql);
		
		if ($mode=='unpost'){
			$this->unpost();
		}
		
		if($mode=='post'){
			$this->refresh($this->ID);//echo '<pre>',print_r($this->data);echo '</pre>';
			$oMaster = new budget_session($this->scenario, $this->GUID);
			
			$sql = "SELECT pc, ".Budget::getMonthlySumSQL()." FROM reg_headcount 
						WHERE scenario='{$this->scenario}' AND location=".(integer)$this->location." 
						GROUP BY pc";//добавить фильтр по воротничкам
			
			// echo '<pre>';print($sql);echo '</pre>';						
			
			$rs = $this->oSQL->q($sql);	
			$headcount = array();
			while ($rw = $this->oSQL->f($rs)){
				$arrLoc[] = $rw;
				for($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					$headcount[$month] += $rw[$month];
				}
			}
			
			if(is_array($this->records[$this->gridName])){
			
				foreach($this->records[$this->gridName] as $id=>$record){
					foreach($arrLoc as $loc=>$hc_data){
						$master_row = $oMaster->add_master();
						$master_row->profit = $hc_data['pc'];
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;										
						//$activity = $Activities->getByCode($record->activity);
						//$account = $YACT->getByCode($activity->YACT);
						
						//$master_row->account = $account;
						$master_row->item = $record->item;
						for($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$master_row->{$month} = -$hc_data[$month]*($record->{$month})*$record->buying_rate*$settings[strtolower($record->buying_curr)]/$headcount[$month];
						}				
												
						
						//echo '<pre>';print_r($master_row);echo '</pre>';
					}
				}
				$oMaster->save();
				$this->markPosted();
			}
		}
		
		return($sqlSuccess);
				
	}
	
}

class costs_record{
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
	
	function __construct($session, $scenario, $id='', $data=Array()){
		//GLOBAL $Products;
		
		GLOBAL $oSQL;
		
		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$this->{$month} = 0;
		}
		$this->id = $id;
		$this->source = $session;
		$this->scenario = $scenario;
		//$this->product_ref = $Products;
		$this->oSQL = $oSQL;
		
		if (count($data)){
			for($m=1;$m<13;$m++){
				$month = date('M',mktime(0,0,0,$m,15));
				$this->{$month} = $data[strtolower($month)];			
			}
			$this->product = $data['product'];
			$this->item = $data['item'];
			$this->company = $data['company'];
			$this->profit = $data['profit'];
			$this->activity = $data['activity'];
			$this->customer = $data['customer'];
			$this->supplier = $data['supplier'];
			$this->agreement = $data['agreement'];
			$this->comment = $data['comment'];
			$this->unit = $data['unit'];			
			$this->buying_curr = $data['buying_curr'];			
			$this->buying_rate= $data['buying_rate'];	
		}		
		return (true);
	}	
		
	public function set_month_value($i, $value){
		$month = date('M',mktime(0,0,0,(integer)$i,15));
		$this->{$month} =(double)$value;
		return(true);
	}
	
	public function getSQLstring(){
		
		if ($this->flagDeleted && $this->id){
			$res = "DELETE FROM `reg_costs` WHERE id={$this->id} LIMIT 1;";	
			return ($res);
		}
		
		GLOBAL $Products;

		for($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$arrRes[] = "`$month`=".(integer)$this->{$month};
		}
			
			//$oProduct = $Products->getByCode($this->product);
			
			$arrRes[] = "`company`='OOO'";
			$arrRes[] = "`pc`=".(integer)$this->profit;
			$arrRes[] = "`source`='".$this->source."'";
			$arrRes[] = "`scenario`='".$this->scenario."'";
			//$arrRes[] = "`customer`='".$this->customer."'";
			$arrRes[] = "`supplier`=".(integer)$this->supplier;
			$arrRes[] = "`item`='".$this->item."'";
			//$arrRes[] = "`product`='".$this->product."'";
			$arrRes[] = "`agreement`=".(integer)$this->agreement;			
			$arrRes[] = "`buying_rate`=".(double)$this->buying_rate;
			$arrRes[] = "`buying_curr`='".$this->buying_curr."'";
			$arrRes[] = "`activity`=".(integer)$oProduct->activity;
			$arrRes[] = "`comment`=".$this->oSQL->e($this->comment);
			$arrRes[] = "`unit`='".$this->unit."'";
			if ($this->id){
				$res = "UPDATE `reg_costs` SET ". implode(',',$arrRes)." WHERE id=".$this->id;
			} else {
				$res = "INSERT INTO `reg_costs` SET ". implode(',',$arrRes);
			}
			//echo '<pre>',$res,'</pre>';
			return $res;
	}
	
	public function total(){
		for($m=1;$m<12;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
			$res += $this->{$month};
		}
		return ($res);
	}
}

?>


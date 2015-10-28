<?php
include_once ('classes/budget.class.php');
include_once ('classes/document.class.php');
include_once ('classes/costs_record.class.php');
include_once ('../common/eiseGrid/inc_eiseGrid.php');
include_once ('classes/yact_coa.class.php');
include_once ('classes/item.class.php');
include_once ('classes/product.class.php');

//$Activities = new Activities ();
$YACT = new YACT_COA();
$Items = new Items();

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
		
		$sql = "SELECT ".self::Prefix.".*, `usrTitle` FROM `".self::Table."` ".self::Prefix."
				LEFT JOIN `stbl_user` ON `usrID`=`".self::Prefix."EditBy`
				WHERE $sqlWhere";
		
		parent::refresh($sql);
		
		$this->distribution = $this->data[$this->prefix.'Distribution'];
		
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
			, 'disabled'=>!$this->flagUpdate
		);
		$this->Columns[] = Array(
			'title'=>'Location'
			,'field'=>self::Prefix.'LocationID'
			,'type'=>'combobox'
			,'sql'=>'SELECT locID as optValue, locTitle as optText FROM vw_location'
			,'default'=>$arrUsrData['empLocationID']
			, 'disabled'=>!$this->flagUpdate
		);
		$this->Columns[] = Array(
			'title'=>'Distribution method'
			,'field'=>self::Prefix.'Distribution'
			,'type'=>'combobox'
			,'sql'=>Array('all'=>'All employees','wc'=>'White collars','bc'=>'Blue collars','users'=>'Domain users')
			,'default'=>'all'
			, 'disabled'=>!$this->flagUpdate
		);
	}
	
	public function defineGrid(){
	
		GLOBAL $Items;
	
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
			,'arrValues'=>$Items->getStructuredRef()
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
		
		$grid->Columns[] = parent::getPeriodEG();
		
		for ($m=1;$m<13;$m++){
			$month = date('M',mktime(0,0,0,$m,15));
					
			$grid->Columns[] = Array(
			'title'=>$month
			,'field'=>strtolower($month)
			,'class'=>'budget-month'
			,'type'=>'decimal'
			, 'mandatory' => true
			, 'disabled'=>false
			,'totals'=>true
		);
		}
		$grid->Columns[] =Array(
			'title'=>'Total'
			,'field'=>'YTD'
			,'type'=>'decimal'
			,'totals'=>true
			,'disabled'=>true
		);
		$this->grid = $grid;
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
		GLOBAL $Items;
		
		parent::save($mode);
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if ($mode=='update' || $mode=='post'){
			$this->location = isset($_POST[$this->prefix.'LocationID'])?$_POST[$this->prefix.'LocationID']:$this->location;
			$this->comment = isset($_POST[$this->prefix.'Comment'])?$_POST[$this->prefix.'Comment']:$this->comment;
			$this->scenario = isset($_POST[$this->prefix.'Scenario'])?$_POST[$this->prefix.'Scenario']:$this->scenario;
			$this->distribution = isset($_POST[$this->prefix.'Distribution'])?$_POST[$this->prefix.'Distribution']:$this->distribution;
		}
		
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
						$row->period = $_POST['period'][$id];				
						$row->comment = $_POST['comment'][$id];				
						for ($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$row->{$month} = (double)$_POST[strtolower($month)][$id];
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
		$sql[] = "UPDATE `".self::Table."` 
				SET ".self::Prefix."LocationID=".(integer)$this->location."				
				,".self::Prefix."Comment=".$this->oSQL->e($this->comment)."
				,".self::Prefix."Scenario='".$this->scenario."'
				,".self::Prefix."Distribution='".$this->distribution."'
				,".self::Prefix."EditBy='".$arrUsrData['usrID']."'
				,".self::Prefix."EditDate=NOW()
				WHERE ".self::Prefix."ID={$this->ID};";
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
	
		if($mode=='post'){
			$this->refresh($this->ID);//echo '<pre>',print_r($this->data);echo '</pre>';
			$oMaster = new budget_session($this->scenario, $this->GUID);
			
			
			$sqlSelect = "SELECT pc,pccTitle, activity, prtTitle, ".Budget::getMonthlySumSQL();
			$sqlFrom = " FROM reg_headcount 
							LEFT JOIN vw_profit ON pccID=pc
							LEFT JOIN vw_product_type ON prtID=activity";
			$sqlWhere = " WHERE scenario='{$this->scenario}' 
							AND location=".(integer)$this->location." 
							AND posted=1
							AND salary>0";
			$sqlGroup = " GROUP BY pc, activity";
			
			switch ($this->distribution){
				case 'all':
					//change nothing
					break;
				case 'wc':
					$sqlWhere .= " AND wc=1";						
					break;
				case 'bc':
					$sqlWhere = " AND wc=0";
					break;
				case 'users':
						$sqlFrom .= " LEFT JOIN vw_employee ON empGUID1C=particulars
										JOIN stbl_user ON usrEmployeeID = empID";
					break;
			
			}
			
			$sql = $sqlSelect.$sqlFrom.$sqlWhere.$sqlGroup;
			// echo '<pre>';print($sql);echo '</pre>';						
			
			$rs = $this->oSQL->q($sql);	
			
			if (!$this->oSQL->num_rows($rs)){
				die ('ERROR: No data found for this location');
			}
			
			$headcount = array();
			while ($rw = $this->oSQL->f($rs)){
				$arrLoc[] = $rw;
				$avg = 0;
				for($m=1;$m<13;$m++){
					$month = date('M',mktime(0,0,0,$m,15));
					$headcount[$month] += $rw[$month];
					$avg +=  $rw[$month];
				}
				$avg = $avg/12;
				$arrPostComment[] = "{$rw['pccTitle']} ({$rw['prtTitle']}) - ".number_format($avg,1,'.',',');
			}
						
			
			if(is_array($this->records[$this->gridName])){
			
				foreach($this->records[$this->gridName] as $id=>$record){
					foreach($arrLoc as $loc=>$hc_data){
						
						if ($record->item == Items::WH_RENT) {
							$record->customer = 1894;
						}
					
						$master_row = $oMaster->add_master();
						$master_row->profit = $hc_data['pc'];
						$master_row->activity = $hc_data['activity'];
						$master_row->customer = $record->customer;										
						//$activity = $Activities->getByCode($record->activity);
						$denominator = $record->period=='annual'?12:1;
						$item = $Items->getById($record->item);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $record->item;
						for($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$master_row->{$month} = -$hc_data[$month]*($record->{$month})*$record->buying_rate*$settings[strtolower($record->buying_curr)]/$headcount[$month]/$denominator;
						}				
												
						
						//echo '<pre>';print_r($master_row);echo '</pre>';
					}
				}
				$oMaster->save();
				$this->postComment = implode(', ',$arrPostComment);
				$this->markPosted();
			}
		}
		
		return($sqlSuccess);
				
	}
	
}
?>
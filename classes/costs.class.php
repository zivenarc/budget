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

class Indirect_costs extends Document{
	
	const EMPTY_CUSTOMER = 1894;
	
	function __construct($id='',$type='indirect'){
		GLOBAL $strLocal;
		//GLOBAL $arrUsrData;
		
		$this->register = 'reg_costs';
		$this->type = $type;
		switch($this->type){
		case 'general':
			$this->gridName = 'general_costs';
			$this->table = 'tbl_general_costs';
			$this->prefix = 'gen';
			break;
		case 'kaizen':
			$this->gridName = 'kaizen';
			$this->table = 'tbl_kaizen';
			$this->prefix = 'kzn';
			$this->period = 'monthly';
			$this->currency = 'RUB';
			break;
		default:
			$this->gridName = 'indirect_costs';
			$this->table = 'tbl_indirect_costs';
			$this->prefix = 'ico';
			break;
		}
		
		parent::__construct($id);	

	}
	public function refresh($id){
		
		$sqlWhere = $this->getSqlWhere($id);
		
		$sql = "SELECT ".$this->prefix.".*, `usrTitle` FROM `".$this->table."` ".$this->prefix."
				LEFT JOIN `stbl_user` ON `usrID`=`".$this->prefix."EditBy`
				WHERE $sqlWhere";
		
		parent::refresh($sql);		
		
		if ($this->type=='general'){
			$this->period = $this->data[$this->prefix."Period"];
			$this->rate = $this->data[$this->prefix."Rate"];
			$this->currency = $this->data[$this->prefix."CurrencyID"];
			$this->item = $this->data[$this->prefix."ItemGUID"];
		}
		if ($this->type=='kaizen'){			
			$this->rate = $this->data[$this->prefix."Rate"];			
			$this->item = $this->data[$this->prefix."ItemGUID"];
		}
		
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
		global $Items;
	
		parent::defineEF();
		
		switch ($this->type) {
			case 'general':
				$this->Columns[] = parent::getSupplierEG();
				$this->Columns[] = Array(
					'title'=>'Item'
					,'field'=>$this->prefix.'ItemGUID'
					,'type'=>'combobox'
					,'sql'=>$Items->getStructuredRef()
					, 'mandatory' => true
					, 'disabled'=>!$this->flagUpdate
				);
				$this->Columns[] =Array(
					'title'=>'Rate'
					,'field'=>$this->prefix."Rate"
					,'type'=>'decimal'
					,'mandatory'=>true
					, 'disabled'=>!$this->flagUpdate
				);
				$this->Columns[] = parent::getCurrencyEG($this->prefix."CurrencyID");
				$this->Columns[] = parent::getPeriodEG($this->prefix."Period");
				break;
			case 'kaizen':
				$this->Columns[] = Array(
					'title'=>'Item'
					,'field'=>$this->prefix.'ItemGUID'
					,'type'=>'combobox'
					,'sql'=>$Items->getStructuredRef()
					, 'mandatory' => true
					, 'disabled'=>!$this->flagUpdate
				);
				$this->Columns[] =Array(
					'title'=>'Rate'
					,'field'=>$this->prefix."Rate"
					,'type'=>'decimal'
					,'mandatory'=>true
					, 'disabled'=>!$this->flagUpdate
				);
				break;
			default:
				$this->Columns[] = parent::getProfitEG();
				break;
		}
	
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
		
		if ($this->type=='indirect'){
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
		} else {
			
			$grid->Columns[] = Array(
				'title'=>'Profit center'
				,'field'=>'pc'
				,'type'=>'combobox'
				,'sql'=>'SELECT pccID as optValue, pccTitle as optText FROM vw_profit'
				,'default'=>$arrUsrData['empProfitID']
			);
		}
		
		$grid->Columns[] = parent::getActivityEG();
		
		
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
		
		if ($this->type=='indirect'){
			$grid->Columns[] =Array(
				'title'=>'Rate'
				,'field'=>'buying_rate'
				,'type'=>'decimal'
				,'mandatory'=>true
				
			);
			
			$grid->Columns[] = parent::getCurrencyEG('buying_curr');
			
			$grid->Columns[] = parent::getPeriodEG();
		}				
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
		
		parent::save($mode);
		
		GLOBAL $arrUsrData;
		GLOBAL $Activities;
		GLOBAL $YACT;
		GLOBAL $Items;
		
		//echo '<pre>';print_r($_POST);die('</pre>');
		if($mode=='update' || $mode=='post'){						
			switch ($this->type){
				case 'indirect':
					$this->profit = isset($_POST[$this->prefix.'ProfitID'])?$_POST[$this->prefix.'ProfitID']:$this->profit;
					break;
				case 'general':
					$this->supplier = isset($_POST[$this->prefix.'SupplierID'])?$_POST[$this->prefix.'SupplierID']:$this->supplier;
					$this->item = isset($_POST[$this->prefix.'ItemGUID'])?$_POST[$this->prefix.'ItemGUID']:$this->item;
					$this->rate = isset($_POST[$this->prefix.'Rate'])?$_POST[$this->prefix.'Rate']:$this->rate;
					$this->currency = isset($_POST[$this->prefix.'CurrencyID'])?$_POST[$this->prefix.'CurrencyID']:$this->currency;
					$this->period = isset($_POST[$this->prefix.'Period'])?$_POST[$this->prefix.'Period']:$this->period;
					break;
				case 'kaizen':
					$this->item = isset($_POST[$this->prefix.'ItemGUID'])?$_POST[$this->prefix.'ItemGUID']:$this->item;
					$this->rate = isset($_POST[$this->prefix.'Rate'])?$_POST[$this->prefix.'Rate']:$this->rate;
					$this->period = 'monthly';
			}	
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
						$row->profit = isset($_POST['pc'][$id]) ? $_POST['pc'][$id] : $this->profit;	
						$row->item = isset($_POST['item'][$id]) ? $_POST['item'][$id] : $this->item;				
						$row->supplier = isset($_POST['supplier'][$id]) ? $_POST['supplier'][$id] : $this->supplier;				
						$row->agreement = $_POST['agreement'][$id];						
						$row->buying_rate = isset($_POST['buying_rate'][$id]) ? str_replace(',','',$_POST['buying_rate'][$id]) : $this->rate;				
						$row->buying_curr = isset($_POST['buying_curr'][$id]) ? $_POST['buying_curr'][$id] : $this->currency;				
						$row->unit = $_POST['unit'][$id];				
						$row->activity = $_POST['activity'][$id];				
						$row->period = isset($_POST['period'][$id])?$_POST['period'][$id]:$this->period;				
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
		switch ($this->type){
			case 'general':
				$sql[] = "UPDATE `".$this->table."` 
						SET ".$this->prefix."SupplierID=".(integer)$this->supplier."				
						,".$this->prefix."ItemGUID=".$this->oSQL->e($this->item)."
						,".$this->prefix."Rate=".(double)$this->rate."
						,".$this->prefix."CurrencyID=".$this->oSQL->e($this->currency)."
						,".$this->prefix."Period=".$this->oSQL->e($this->period)."
						,".$this->prefix."Comment=".$this->oSQL->e($this->comment)."
						,".$this->prefix."Scenario='".$this->scenario."'
						,".$this->prefix."EditBy='".$arrUsrData['usrID']."'
						,".$this->prefix."EditDate=NOW()
						WHERE ".$this->prefix."ID={$this->ID};";
			
				break;
			case 'kaizen':
				$sql[] = "UPDATE `".$this->table."` 
						SET ".$this->prefix."ItemGUID=".$this->oSQL->e($this->item)."
						,".$this->prefix."Rate=".(double)$this->rate."						
						,".$this->prefix."Comment=".$this->oSQL->e($this->comment)."
						,".$this->prefix."Scenario='".$this->scenario."'
						,".$this->prefix."EditBy='".$arrUsrData['usrID']."'
						,".$this->prefix."EditDate=NOW()
						WHERE ".$this->prefix."ID={$this->ID};";
			
				break;
			default:
				$sql[] = "UPDATE `".$this->table."` 
						SET ".$this->prefix."ProfitID=".(integer)$this->profit."				
						,".$this->prefix."Comment=".$this->oSQL->e($this->comment)."
						,".$this->prefix."Scenario='".$this->scenario."'
						,".$this->prefix."EditBy='".$arrUsrData['usrID']."'
						,".$this->prefix."EditDate=NOW()
						WHERE ".$this->prefix."ID={$this->ID};";
				break;
		}
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
					
			if(is_array($this->records[$this->gridName])){
			
				foreach($this->records[$this->gridName] as $id=>$record){
						
						if ($record->item == Items::WH_RENT) {
							$record->customer = self::EMPTY_CUSTOMER;
						}
						
						$master_row = $oMaster->add_master();
						$master_row->profit = $record->profit;
						$master_row->activity = $record->activity;
						$master_row->customer = $record->customer;					
						$item = $Items->getById($record->item);
						$master_row->account = $item->getYACT($master_row->profit);
						$master_row->item = $record->item;
						for($m=1;$m<13;$m++){
							$month = date('M',mktime(0,0,0,$m,15));
							$denominator = $record->period=='annual'?$record->{$month}/$record->total():1;
							$master_row->{$month} = -$record->{$month}*$record->buying_rate*$settings[strtolower($record->buying_curr)]*$denominator;
						}				
												
						
						//echo '<pre>';print_r($master_row);echo '</pre>';
	
				}
				$oMaster->save();
				$this->markPosted();
			}
		}
		
		return($sqlSuccess);
				
	}
	
	public function fill_general_costs($oBudget,$type='all',$params=Array()){
		
		if (is_array($this->records[$this->gridName])){
			foreach($this->records[$this->gridName] as $id=>$record){
				$record->flagDeleted = true;
			}
		}
		
		$dateEstStart = ($oBudget->year-2).'-10-01';
		$dateEstEnd = ($oBudget->year-1).'-09-30';
		
		switch ($type) {
			case 'all':
				$sql = "SELECT pc, wc, activity, 'fte' as unit, ".Budget::getMonthlySumSQL()." FROM reg_headcount WHERE scenario='".$this->budget->id."' AND active=1 GROUP BY pc, activity";
				break;
			case 'users':
				$sql = "SELECT pc, wc, activity, 'user' as unit, ".Budget::getMonthlySumSQL()." FROM reg_headcount 
					WHERE scenario='".$oBudget->id."' AND posted=1 AND wc=1 GROUP BY pc, activity";
				break;
			case 'bc':
				$sql = "SELECT pc, wc, activity, funTitleLocal as comment, 'fte' as unit, ".Budget::getMonthlySumSQL()." FROM reg_headcount 
					LEFT JOIN vw_function ON funGUID=function
					WHERE scenario='".$oBudget->id."' AND posted=1 AND wc=0 GROUP BY pc, function, activity";
				break;				
			case 'teu':
				$sql =  "SELECT pc, activity, customer, cntTitle as comment, unit, ".Budget::getMonthlySumSQL()." FROM reg_sales 
					JOIN vw_product ON product=prdID
					LEFT JOIN vw_customer ON customer=cntID
					WHERE scenario='".$oBudget->id."' AND posted=1 AND prdGDS='OFT' GROUP BY pc, activity, customer";
				break;
			case 'revenue':
				$sql =  "SELECT pc, activity, 9802 as customer, '' as comment, 'RUB' as 'unit', ".Budget::getMonthlySumSQL()." FROM reg_master 
					LEFT JOIN vw_customer ON customer=cntID
					WHERE scenario='".$oBudget->id."' AND item='".Items::REVENUE."' AND source<>'estimate' 
					GROUP BY pc, activity";
				break;
			case 'kaizen':
				$sql =  "SELECT pc, activity, 9802 as customer, '' as comment, 'RUB' as 'unit', ".Budget::getMonthlySumSQL()." FROM reg_master
					JOIN vw_product_type ON prtID=activity AND prtGHQ='{$params['prtGHQ']}'
					WHERE scenario='".$this->budget->id."' AND item='".Items::DIRECT_COSTS."' AND source NOT IN ('estimate','Actual')
					GROUP BY pc, activity";
				break;
			case 'kaizen_revenue':
				$sql =  "SELECT pc, activity, 9802 as customer, '' as comment, 'RUB' as 'unit', ".Budget::getMonthlySumSQL()." FROM reg_master
					JOIN vw_product_type ON prtID=activity AND prtGHQ='{$params['prtGHQ']}'
					WHERE scenario='".$oBudget->id."' AND item IN('".Items::REVENUE."','".Items::INTERCOMPANY_REVENUE."') AND source<>'estimate'
					GROUP BY pc, activity";
				break;
		}
		 	
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$row = $this->add_record();
			$row->flagUpdated = true;				
			$row->profit = $rw['pc'];
			$row->unit = $rw['unit'];
			$row->customer = $rw['customer'];
			$row->comment = $rw['comment'];
			$row->activity = $rw['activity'];
			$row->period = $this->period;
			$row->buying_rate = $this->data[$this->prefix."Rate"];
			$row->buying_curr = $this->currency;
			$row->item = $this->data[$this->prefix."ItemGUID"];
			$row->supplier = $this->data[$this->prefix."SupplierID"];
			for ($m=1;$m<13;$m++){
				$month = date('M',mktime(0,0,0,$m,15));
				$row->{$month} = abs($rw[$month]);
			}
		}	
	}
	
}

?>


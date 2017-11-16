<?php
require_once ('classes/reference.class.php');

class Products extends Reference{
	
	// public $oSQL;	
	// private $data;
	// private $pointers;
	// private $codes;
	// private $pointer;
	// public $current;
	
	const TABLE = 'vw_product';
	
	function __construct(){
		parent::__construct();
		$this->child_class = 'Product';
		
		$sql = "SELECT * FROM `".self::TABLE."`";
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$this->data[$rw['prdGUID']]=$rw;
			$this->pointers[] = $rw['prdGUID'];
			$this->codes[$rw['prdID']] = $rw['prdGUID'];
			$this->pointer = 0;
		}
	}
	
	public function getStructuredRef($prdIdxLeft, $prdIdxRight){

		$sql = "SELECT prdID, prdFlagDeleted, CONCAT_WS('|',prdGDS,prdTitleLocal) as prdTitleLocal, prtGHQ as parent_code, prtGHQ as parent_title
			FROM vw_product			
			LEFT JOIN common_db.tbl_product_type ON prdCategoryID=prtID
			WHERE prdIdxLeft BETWEEN  '{$prdIdxLeft}' AND '{$prdIdxRight}'
			AND prdFlagFolder=0
			GROUP BY prdID
			ORDER BY prtGHQ, prdTitleLocal
		";
		$rs = $this->oSQL->q($sql);
		
		$group = '';		
		
		while ($rw=$this->oSQL->f($rs)){
			
			$group = strlen($rw['parent_title'])?$rw['parent_title']:'Undefined froup';
			
			$arrRes[$group][$rw['prdID']]  = $rw['prdTitleLocal'];
			
		}
		// echo '<pre>';print_r($arrRes); echo '</pre>';
		return($arrRes);
	}
	
}

class Product{
	public $name;
	public $parent;
	public $id;
	
	const PRS_Import = 2888;
	const OFT_Import = 2852;	
	const OFT_Export = 2941;
	const PRS_Export = 5712;
	const OFT_DHC_Import = 7036;
	const OFT_SSC_Import = 7037;
	const OFT_DHC_Export = 7038;
	const OFT_SSC_Export = 7039;
	
	function __construct($id,$params){
		$this->code = $params['prdID'];
		$this->id = $id;
		$this->name = $params['prdTitle'];
		$this->activity = $params['prdCategoryID'];
		$this->activity_cost = $params['prdCostID'];
		$this->unit = $params['prtUnit'];
	}
	
}

class Activities extends Reference{
		
		const OFIGB = 74;
		const OFICOM = 72;
		const TABLE = 'vw_product_type';
	
	function __construct(){
		parent::__construct();
		$this->child_class = 'Activity';
		
		$sql = "SELECT * FROM `".self::TABLE."`";
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$this->data[$rw['prtGUID']]=$rw;
			$this->pointers[] = $rw['prtGUID'];
			$this->codes[$rw['prtID']] = $rw['prtGUID'];
			$this->pointer = 0;
		}
	}
	
	function getStructuredRef(){
		GLOBAL $oSQL, $strLocal;
		$sql = "SELECT * FROM vw_product_type WHERE prtFlagDeleted=0 ORDER BY prtGHQ";
		$rs = $oSQL->q($sql);
		$arrRes['Undefined group'][0] = '[None]';
		while ($rw=$oSQL->f($rs)){
			$group = strlen($rw['prtGHQ'])?$rw['prtGHQ']:'Undefined group';
			$arrRes[$group][$rw['prtID']] = $rw["prtTitle$strLocal"];
		}
		
		return($arrRes);
	}
}

class Activity{
	public $name;
	public $parent;
	public $id;
	
	function __construct($id,$params){
		$this->code = $params['prtID'];
		$this->id = $id;
		$this->name = $params['prtTitle'];
		$this->RHQ = $params['prtRHQ'];
		$this->YACT = $params['prtYACT'];
		$this->item_income = $params['prtBudgetIncomeID'];
		$this->item_cost = $params['prtBudgetCostID'];
	}
	
}
?>
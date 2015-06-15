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
		$sql = "SELECT PRD.*, PRD_P.prdTitleLocal as prdParentTitle
					FROM vw_product PRD 
					INNER JOIN vw_product PRD_P ON PRD_P.prdIdxLeft<=PRD.prdIdxLeft 
						AND PRD_P.prdIdxRight>=PRD.prdIdxRight AND PRD_P.prdParentID >0 
					WHERE PRD.prdIdxLeft BETWEEN  '{$prdIdxLeft}' AND '{$prdIdxRight}'
						##AND PRD.prdFlagFolder=0
					GROUP BY PRD.prdID
					ORDER BY PRD.prdIdxLeft, PRD.prdIdxRight, PRD.prdTitleLocal
				";
		$rs = $this->oSQL->q($sql);
		
		$group = '';		
		
		while ($rw=$this->oSQL->f($rs)){
			 		
			if ($group!='' && $group<>$rw['prdParentID'] && $flagGroupOpen[$group]){
				$arrRes['##optgroupclose##'.$group] = '';
				$flagGroupOpen[$group] = false;
			}
			
			if ($rw['prdFlagFolder']){
				$arrRes['##optgroupopen##'.$rw['prdID']] = $rw['prdTitle'];
				$flagGroupOpen[$rw['prdID']] = true;
			} else {
				$arrRes[$rw['prdID']] = mb_strlen($rw['prdTitleLocal'],'UTF-8')>200?mb_substr($rw['prdTitleLocal'],0,200,'UTF-8').'[...]':$rw['prdTitleLocal'];
				$group = $rw['prdParentID'];
			}
		}
		// echo '<pre>';print_r($arrRes); echo '</pre>';
		return($arrRes);
	}
	
}

class Product{
	public $name;
	public $parent;
	public $id;
	
	function __construct($id,$params){
		$this->code = $params['prdID'];
		$this->id = $id;
		$this->name = $params['prdTitle'];
		$this->activity = $params['prdCategoryID'];
		$this->unit = $params['prtUnit'];
	}
	
}

class Activities extends Reference{
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
		GLOBAL $oSQL;
		$sql = "SELECT * FROM vw_product_type WHERE prtFlagDeleted=0 ORDER BY prtRHQ";
		$rs = $oSQL->q($sql);
		$rhq='';
		while ($rw=$oSQL->f($rs)){
			if ($rw['prtRHQ']!=$rhq){
				$arrRes['##optgroupopen##'.$rw['prtRHQ']] = $rw['prtRHQ'];
			}
			$arrRes[$rw['prtID']] = $rw['prtTitle'];
			$rhq = $rw['prtRHQ'];
		}
		$arrRes['##optgroupclose##'.$rhq] = '';
		$arrRes[0] = '[None]';
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
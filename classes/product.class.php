<?php
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
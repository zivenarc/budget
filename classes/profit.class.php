<?php
require_once ('classes/reference.class.php');

class ProfitCenters extends Reference{
	// public $oSQL;	
	// private $data;
	// private $pointers;
	// private $codes;
	// private $pointer;
	// public $current;
	
	const TABLE = 'vw_profit';
	
	function __construct(){
		parent::__construct();		
		$this->child_class = 'ProfitCenter';
		
		$sql = "SELECT * FROM `".self::TABLE."` WHERE pccFlagDeleted=0";
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$this->data[$rw['pccGUID']]=$rw;
			$this->pointers[] = $rw['pccGUID'];
			$this->codes[$rw['pccID']] = $rw['pccGUID'];
			$this->pointer = 0;
		}
	}
}

class ProfitCenter {
	
	function __construct($id,$params){
		GLOBAL $strLocal;
		
		$this->code = $params['pccID'];
		$this->id = $id;
		$this->name = $params["pccTitle$strLocal"];
		$this->prod = $params["pccFlagProd"];
		$this->location = $params["pccDefaultLocation"];
		// $this->manager = parent::getByCode($params['empManagerID']);
	}
	
}
?>
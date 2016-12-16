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
		$this->prefix='pcc';
		
		$sql = "SELECT * FROM `".self::TABLE."` WHERE pccFlagDeleted=0";
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$this->data[$rw['pccGUID']]=$rw;
			$this->pointers[] = $rw['pccGUID'];
			$this->codes[$rw['pccID']] = $rw['pccGUID'];
			$this->pointer = 0;
		}
	}
	
	public function getStructuredRef(){	
		GLOBAL $oSQL, $strLocal;	
		$sql = "SELECT P.pccTitle$strLocal as pccParentTitle, PCC.* FROM `".self::TABLE."` PCC 
				LEFT JOIN `".self::TABLE."` P ON P.pccCode1C=PCC.pccParentCode1C
				WHERE PCC.pccFlagDeleted=0";
		$rs = $oSQL->q($sql);
		while ($rw=$oSQL->f($rs)){		
			if(!$rw['pccFlagFolder']){
				$arrRes[$rw['pccParentTitle']][$rw['pccID']] = $rw["pccTitle$strLocal"];			
			}
		}
		return ($arrRes);
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
		$this->activity = $params["pccProductTypeID"];
		// $this->manager = parent::getByCode($params['empManagerID']);
	}
	
}
?>
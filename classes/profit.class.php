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
		
		$sql = "SELECT * FROM `".self::TABLE."`";
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$this->data[$rw['pccGUID']]=$rw;
			$this->pointers[] = $rw['pccGUID'];
			$this->codes[$rw['pccID']] = $rw['pccGUID'];
			$this->pointer = 0;
		}
	}
	
	public function getStructuredRef(){		
		$group = '';		
		foreach ($this->data as $key=>$value){
			if ($group!=$value[$this->prefix.'ParentID']){
				$arrRes['##optgroupopen##'.$value[$this->prefix.'ParentID']] = $value[$this->prefix.'ParentTitle'];
			}
			if ($value[$this->prefix.'ParentID']){
				$arrRes[$key] = $value[$this->prefix.'Title'];
				$group = $value[$this->prefix.'ParentID'];
			}
			
		}
		return ($arrRes);
	}
	
}

class ProfitCenter {
	
	function __construct($id,$params){
		GLOBAL $oSQL, $strLocal;
		
		$this->code = $params['pccID'];
		$this->guid = $params['pccGUID'];
		$this->id = $id;
		$this->name = $params["pccTitle$strLocal"];
		$this->prod = $params["pccFlagProd"];
		$this->location = $params["pccDefaultLocation"];
		$this->activity = $params["pccProductTypeID"];
		$sql = "SELECT activity, value FROM ref_distr WHERE pc='{$this->guid}'";
		$rs = $oSQL->q($sql);
		if($oSQL->n($rs)){
			$this->activity = Array();
			while($rw = $oSQL->f($rs)){
				$this->activity[$rw['activity']] = $rw['value'];
			}
			$total = array_sum($this->activity);
			foreach($this->activity as $key=>$value){
				$this->activity[$key] = $value/$total;
			}
		}
		// $this->manager = parent::getByCode($params['empManagerID']);
	}
	
}
?>
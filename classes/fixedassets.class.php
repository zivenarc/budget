<?php
require_once ('classes/reference.class.php');

class FixedAssets extends Reference{
	
	// public $oSQL;	
	// private $data;
	// private $pointers;
	// private $codes;
	// private $pointer;
	// public $current;
	
	const TABLE = 'vw_fixed_assets';

	
	function __construct(){
		parent::__construct();
		$this->child_class = 'Asset';
		$this->prefix = 'fix';
		
		$sql = "SELECT fa.*, parent.fixTitle as fixParentTitle FROM `".self::TABLE."` fa
				LEFT JOIN `".self::TABLE."` parent on parent.fixID=fa.fixParentID
				ORDER BY fa.fixIdxLeft, fa.fixIdxRight";
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$this->data[$rw['fixGUID']]=$rw;
			$this->pointers[] = $rw['fixGUID'];
			$this->codes[$rw['fixID']] = $rw['fixGUID'];
			$this->pointer = 0;
		}
	}
	
	public function getStructuredRef(){		
		$group = '';
		foreach ($this->data as $key=>$value){			
			if ($group!='' && $group<>$value[$this->prefix.'ParentID'] && $flagGroupOpen[$group]){
				$arrRes['##optgroupclose##'.$group] = '';
				$flagGroupOpen[$group] = false;
			}
			
			if ($value[$this->prefix.'FlagFolder']){
				$arrRes['##optgroupopen##'.$key] = $value[$this->prefix.'Title'];
				$flagGroupOpen[$key] = true;
			} else {
				$arrRes[$key] = $value[$this->prefix.'Title'];
				$group = $value[$this->prefix.'ParentID'];
			}
			
		}
		return ($arrRes);
	}
	
}

class Asset{
	public $name;
	public $parent;
	public $id;
	
	function __construct($id,$params){
		$this->code = $params['fixID'];
		$this->id = $id;
		$this->name = $params['fixTitle'];
		$this->date_start = strtotime($params['fixDateStart']);
		$this->date_end = strtotime($params['fixDateEnd']);
		$this->value = strtotime($params['fixValueStart']);
	}
	
}


?>
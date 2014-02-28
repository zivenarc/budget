<?php
require_once ('classes/reference.class.php');

class YACT_COA extends Reference{
	
	// public $oSQL;	
	// private $data;
	// private $pointers;
	// private $codes;
	// private $pointer;
	// public $current;
	
	const TABLE = 'vw_yact';
	
	function __construct(){
		parent::__construct();
		$this->child_class = 'YACT';
		
		$sql = "SELECT * FROM `".self::TABLE."`";
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$this->data[$rw['yctGUID']]=$rw;
			$this->pointers[] = $rw['yctGUID'];
			$this->codes[$rw['yctID']] = $rw['yctGUID'];
			$this->pointer = 0;
		}
	}
	
}

class YACT{
	public $name;
	public $parent;
	public $id;
	
	function __construct($id,$params){
		$this->code = $params['yctID'];
		$this->id = $id;
		$this->name = $params['yctTitle'];
	}
	
}
?>
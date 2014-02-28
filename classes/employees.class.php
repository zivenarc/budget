<?php
require_once ('classes/reference.class.php');

class Employees extends Reference{
	// public $oSQL;	
	// private $data;
	// private $pointers;
	// private $codes;
	// private $pointer;
	// public $current;
	
	const TABLE = 'vw_employee';
	
	function __construct(){
		parent::__construct();		
		$this->child_class = 'Employee';
		
		$sql = "SELECT * FROM `".self::TABLE."` WHERE NOT(empFlagDeleted=1 OR empEndDate IS NOT NULL)";
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$this->data[$rw['empGUID1C']]=$rw;
			$this->pointers[] = $rw['empGUID1C'];
			$this->codes[$rw['empID']] = $rw['empGUID1C'];
			$this->pointer = 0;
		}
	}
}

class Employee {
	public $name;
	public $manager;
	public $profit;
	public $job;
	public $id;
	const TYPE = 'EMP';
	
	function __construct($id,$params){
		$this->code = $params['empCode1C'];
		$this->id = $id;
		$this->name = $params['empTitleLocal'];
		$this->profit = $params['empProfitID'];
		$this->job = $params['empFunction'];
		$this->activity = $params['empProductTypeID'];
		$this->salary = $params['empSalary'];
		// $this->manager = parent::getByCode($params['empManagerID']);
	}
	
}
?>
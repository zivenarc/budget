<?php
require_once ('classes/reference.class.php');

class Items extends Reference{
	
	// public $oSQL;	
	// private $data;
	// private $pointers;
	// private $codes;
	// private $pointer;
	// public $current;
	
	const TABLE = 'vw_item';
	
	const BONUS = 'f0b14b33-f52b-11de-95b2-00188bc729d2';
	const CANTEEN = 'f0b14b34-f52b-11de-95b2-00188bc729d2';
	const COMPANY_CARS = 'f0b14b37-f52b-11de-95b2-00188bc729d2';
	const CLOTHES = 'f0b14b36-f52b-11de-95b2-00188bc729d2';
	const CLAIMS = 'f0b14b35-f52b-11de-95b2-00188bc729d2';
	const DEPRECIATION = 'f0b14b3c-f52b-11de-95b2-00188bc729d2';
	const EXPAT_HOUSING = 'f0b14b3f-f52b-11de-95b2-00188bc729d2';
	const EXPAT_COSTS = 'f0b14b3e-f52b-11de-95b2-00188bc729d2';
	const DIRECT_COSTS = '094e839a-095d-405f-af6a-77441bf66246';
	const HIRING_COSTS = 'f0b14b45-f52b-11de-95b2-00188bc729d2';
	
	const OUTSOURCING = '602b628b-f52f-11de-95b2-00188bc729d2';
	
	const IT_EQUIPMENT = '602b626b-f52f-11de-95b2-00188bc729d2';
	const INTERNET = '602b627c-f52f-11de-95b2-00188bc729d2';
	const IT_COSTS = '602b626a-f52f-11de-95b2-00188bc729d2';
	const IT_SUPPORT = '602b626c-f52f-11de-95b2-00188bc729d2';
	const SATELLITE = '17ae1750-48e3-11e1-b30e-005056930d2f';
	const ONEASS = 'f0b14b2e-f52b-11de-95b2-00188bc729d2';
	const RHQ_IT_COST = '1ab25fd9-7c3f-11e3-b664-00155d010e0b';
	
	const OFFICE_RENT = '602b627d-f52f-11de-95b2-00188bc729d2';
	const OTHER_OFFICE = '602b6287-f52f-11de-95b2-00188bc729d2';
	const STATIONERY = '602b629c-f52f-11de-95b2-00188bc729d2';
	const OTHER_COMMUNICATION = '602b6280-f52f-11de-95b2-00188bc729d2';
	
	const MEDICAL_INSURANCE = '602b6277-f52f-11de-95b2-00188bc729d2';
	const MOBILE = '602b6278-f52f-11de-95b2-00188bc729d2';
	const REVENUE = 'cdce3c68-c8da-4655-879e-cd8ec5d98d95';
	const KAIZEN = '4d99e16c-b832-11e0-b9fe-005056930d2f';
	const SALARY = '453d8da7-963b-4c4f-85ca-99e26d9fc7a2';
	const SOCIAL_TAX = '34c9c610-e7c1-4ccc-8af5-558278c03f4d';
	const INTERCOMPANY_REVENUE = '17ae174f-48e3-11e1-b30e-005056930d2f';
	const INTERCOMPANY_COSTS = 'ae6f6cd5-4bdc-11e1-b30e-005056930d2f';
	const CY_RENT = 'f0b14b3a-f52b-11de-95b2-00188bc729d2';
	const WH_RENT = 'f0b14b32-f52b-11de-95b2-00188bc729d2';
	const OVERTIME_WORK = '0380b288-7278-11e1-8337-00505693002f';
	const UNUSED_VACATION_ACCRUAL = 'a25fa224-c5cd-11e1-9f9b-00505693002f';
	const FUEL = 'f0b14b42-f52b-11de-95b2-00188bc729d2';
	const MAINTENANCE = '602b6274-f52f-11de-95b2-00188bc729d2';
	const PROPERTY_TAX = '602b628f-f52f-11de-95b2-00188bc729d2';
	const TRANSPORTATION_TAX = '602b629f-f52f-11de-95b2-00188bc729d2';
	const INSURANCE = 'f0b14b46-f52b-11de-95b2-00188bc729d2';
	
	const PROFIT_SHARE = 'fd09fb23-efd0-11e3-926a-00155d010e0b';
	
	const GAIN_ON_SALE = 'ac7d2f1e-63f0-11df-9a0b-005056930d2f';	
	
	function __construct(){
		parent::__construct();
		$this->child_class = 'Item';
		$this->prefix = 'itm';
		
		$sql = "SELECT items.*, parent.itmTitle as itmParentTitle FROM `".self::TABLE."` items
				LEFT JOIN `".self::TABLE."` parent on parent.itmID=items.itmParentID
				ORDER BY items.itmParentID, items.itmOrder";
		$rs = $this->oSQL->q($sql);
		while ($rw=$this->oSQL->f($rs)){
			$this->data[$rw['itmGUID']]=$rw;
			$this->pointers[] = $rw['itmGUID'];
			$this->codes[$rw['itmID']] = $rw['itmGUID'];
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

class Item{
	public $name;
	public $parent;
	public $id;
	
	function __construct($id,$params){
		$this->code = $params['itmID'];
		$this->id = $id;
		$this->name = $params['itmTitle'];		
		$this->YACTProd = $params['itmYACTProd'];
		$this->YACTCorp = $params['itmYACTCorp'];		
		$this->YACT = $params['itmYACTProd'];		
	}
	
	function getYACT($pc){
		GLOBAL $arrProfitConfig;
		if ($arrProfitConfig[$pc]['pccFlagProd']){
			return $this->YACTProd ;
		} else {
			return $this->YACTCorp ;
		}
	}
	
}


?>
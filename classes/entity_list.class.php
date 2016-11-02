<?php
require_once ('../common/eiseList/inc_eiseList.php');
class EntityList extends eiseList {
	private $sqlAttr;
	private $oSQL;
	
	function __construct($params){
		GLOBAL $strLocal;
		GLOBAL $oSQL;
		
		$this->oSQL = $oSQL;
		$this->entID = $params['entID'];
		$this->entTable = $params['table'];
		$this->tabKey = $params['strTabKey'];
		$this->showTabField = $params['showTabField'];
		$this->getEntityData();
		$this->sqlWhere=$params['sqlWhere'];		
		
		parent::__construct($oSQL,$this->prefix."_entitylist"
		, Array('title'=>""
				, 'sqlFrom' => $this->table
				, 'sqlWhere' => $this->sqlWhere
				, 'defaultOrderBy'=>$this->prefix.'ID'
				, 'defaultSortOrder'=>'ASC'//$orderingTypeASC_DESC
				, 'intra' => $intra
				, 'strLocal'=>$strLocal
				, 'calcFoundRows'=>false
				, 'controlBarButtons' => 'btnSearch|btnOpenInExcel|btnReset'
				));
		
		$this->setSQL();
		$arrInput = $this->getAttributes();
		$this->elFillArray($arrInput);
	}
	
	private function getEntityData(){
		GLOBAL $strLocal;
		
		$sqlEntity = "SELECT * FROM `stbl_entity` WHERE entID='".$this->entID."' OR entTable='".$this->entTable."'";
		$rsEntity = $this->oSQL->do_query($sqlEntity);
		$rwEntity = $this->oSQL->fetch_array($rsEntity);
		$this->prefix = $rwEntity['entPrefix'];
		$this->table = $rwEntity['entTable'];
		$this->form = $rwEntity['entForm'];
		$this->type = $rwEntity['entType'];
		$this->title = $rwEntity['entTitle'.$strLocal];
		return($rwEntity);
	}
	
	private function setSQL(){
		//$strStateField = $this->prefix."_".$this->prefix."StateID";
		$strStateField = $this->prefix."StateID";		
		switch ($this->type){
			case 'DOC':
			if (!$_GET[$strStateField]){
				$this->sqlAttr = "SELECT ATR.*,MAX(satFlagShowInList) as FlagShowInList FROM stbl_attribute ATR
					JOIN stbl_status_attribute SAT
					ON atrID=satAttributeID
					WHERE atrEntityID='".$this->entID."' 
					GROUP BY atrID
					ORDER BY atrOrder ASC
					";
			//$strGridName = $this->prefix."My";
			
			} else {
				//$sqlWhere = "`".$this->prefix."StateID` = ".$_GET[$this->prefix."StateID"];
				//$sql="SELECT * FROM stbl_status WHERE staID=".$_GET[$strStateField].";";
				//$rs = $oSQL->do_query($sql);
				//$rwState = $oSQL->fetch_array($rs);
				//$strGridName = $this->prefix.$rw["staTitle"];
				
				$this->sqlAttr = "SELECT ATR.*,SAT.*, satFlagShowInList AS FlagShowInList FROM stbl_attribute ATR
						JOIN stbl_status_attribute SAT
						ON atrID=satAttributeID
						WHERE satStatusID='".$_GET[$strStateField]."' 
						ORDER BY atrOrder ASC";

			}
			//echo 'QQ','<pre>',$this->sqlAttr,'</pre>QQ';
			break;
			case 'REF':
				$this->sqlAttr = "SELECT ATR.*, atrFlagShowInList as FlagShowInList FROM stbl_attribute ATR
						WHERE atrEntityID='".$this->table."' 
						ORDER BY atrOrder ASC";
			break;
		}
	}
	
	private function getAttributes(){
	
		$this->Columns[] = array('title' => "##"
							 , 'field' => "phpLNums"
							 , 'type' => "num"
							 );
		/*$this->Columns[] = array('title' => ""
									 , 'field' => $this->prefix."StateID"
									 , 'type' => "integer"
									 , 'filter'=>$this->prefix."StateID"
									 );							 */
		$rs = $this->oSQL->q($this->sqlAttr);
		$i = 1;
		while ($rw=$this->oSQL->f($rs)){			
			$this->elFillArray($rw);			
		}
	}
	
	private function elFillArray($arrInput){
		GLOBAL $strLocal;
		//$prefix = substr($arrInput['atrFieldName'],0,3);
		$strPK = $this->prefix."ID";
		
		/*
		if($strEntityForm=='') {
			$entity = preg_replace('/stbl_|tbl_|vw_/','',$arrInput['atrEntityID']);
			$strEntityForm = $entity.'_form.php';
		};
		*/
		
		$comboSQL = null;
		$i++;
		
		$comboSQL = readSourceAttribute($arrInput['atrProgrammerReserved']);
		
		
		
		//if ($arrInput['satFlagShowInList']||$arrInput['atrFlagShowInList']) {
		if ($arrInput['FlagShowInList']) {
			$title = $arrInput["atrTitle".$strLocal];
		} else {
			$title = '';
		}
		
		
		if (isset($_GET[$arrInput['atrFieldName']]) || ($this->tabKey==$arrInput['atrFieldName'] && !$this->showTabField)){
			$title = '';
		}
		
		switch ($arrInput['atrType']){ //Конверсия типов для eiseList
			case 'checkbox':
				$type = 'boolean';
				break;
			case 'ajax':
				$type='ajax_dropdown';
				break;
			default:
				$type = $arrInput['atrType'];
				break;
		}
		
			$this->Columns[] = array('title' => $title
										 , 'type' => $type
										 , 'PK'=> $arrInput['atrFlagPK']//($arrInput['atrFieldName']==$strPK)
										 , 'field' => $arrInput['atrFieldName']
										 , 'order_field' => $arrInput['atrFieldName']
										 , 'source'=>$comboSQL
										 , 'source_prefix'=>$arrInput['atrPrefix']
										 , 'defaultText'=>$arrInput['atrDefault']
										 , 'sql'=>((isset($comboSQL) && !is_array($comboSQL) && !preg_match('/^(vw_|tbl_|stbl_)/i',$comboSQL))?"SELECT `optText` FROM ($comboSQL) Q$i WHERE `optValue`=`{$arrInput['atrFieldName']}`":"")
										 , 'filter' => $arrInput['atrFieldName']	
										, 'href' => (preg_match("/title|$strPK/i",$arrInput['atrFieldName']) ? $this->form."?".$this->prefix."ID=[$strPK]" : $arrInput['atrHref'])
										 );
										 
		//};
	}
	
	public function show(){
		if (count($this->Columns)){
			parent::show();
		} else {
			echo "<div class='error'>Fields are not defined for [".$this->sqlFrom."]</div>";
			echo "<p><a target='_blank' href='sp_insert_attr.php?entity=".$this->sqlFrom."&DataAction=insert'>Create field definitions</a></p>";				
		}
	}
	
	public function getHeader(){
		GLOBAL $arrUsrData;
		GLOBAL $strLocal;
		//echo "<h1>",$arrUsrData["pagTitle$strLocal"],"</h1>";
		echo "<h1>",$this->title,"</h1>";
	}

}


/*--some entity functions, to be moved to Entity class--*/
class Entity {
	private $oSQL;
	private $strLocal;
	
	public $prefix;
	public $table;
	public $title;
		
	function __construct(){
		GLOBAL $oSQL;
		GLOBAL $strLocal;
		$this->oSQL = $oSQL;
		$this->strLocal = $strLocal;
		
	}
	
	public function getByID($id){
		$sql = "SELECT * FROM stbl_entity WHERE entID=".(integer)$id;		
		$rs = $this->oSQL->q($sql);		
		$rw = $this->oSQL->f($rs);
		$this->setFields($rw);
		$this->status = $this->getStatusData();
		return($rw);
	}
	public function getByName($name){
		$sql = "SELECT * FROM stbl_entity WHERE entEntity=".$this->oSQL->e($name);
		$rs = $this->oSQL->q($sql);
		$rw = $this->oSQL->f($rs);
		$this->setFields($rw);
		$this->status = $this->getStatusData();
		return($rw);
	}
	public function getByPrefix($prefix){
		$sql = "SELECT * FROM stbl_entity WHERE entPrefix=".$this->oSQL->e($prefix);
		$rs = $this->oSQL->q($sql);
		$rw = $this->oSQL->f($rs);
		$this->setFields($rw);
		$this->status = $this->getStatusData();
		return($rw);
	}
	
	public function getCostTabs($sqlWhere){/*------------------- Tabsheets for Cost selection ----------------------*/
		
		$this->tabKey = $this->prefix.'CostID';
		
		if(!isset($sqlWhere)){
			$sqlWhere = $this->prefix."StateID=".(integer)$_GET[$this->prefix."StateID"];
		} 	
	
		$sqlTabs = "SELECT `cstID` as optValue, CONCAT(`cstTitle".$this->strLocal."`,' (', count(`".$this->prefix."ID`),')') as optText, count(`".$this->prefix."ID`) as nCount
				FROM `".$this->table."`
				INNER JOIN `vw_cost` on `cstID`=`".$this->prefix."CostID`
				WHERE $sqlWhere
				GROUP BY cstID
				ORDER BY cstID";
		$rs = $this->oSQL->q($sqlTabs);
		return ($this->fillTabs($rs));
	}
	
	public function getProfitTabs($sqlWhere){/*------------------- Tabsheets for Profit selection ----------------------*/
		GLOBAL $company;
		
		$this->tabKey = $this->prefix.'ProfitID';
		
		if(!$sqlWhere){
			if ($this->type=='ENT'){
				$sqlWhere = $this->prefix."StateID=".(integer)$_GET[$this->prefix."StateID"];
			} else {
				$sqlWhere = '1=1';
			}
			//$sqlWhere = $this->prefix."StateID=".(integer)$_GET["StateID"];
		} 	
		
		$sqlTabs = "SELECT `pccID` as optValue, CONCAT(`pccTitle".$this->strLocal."`,' (', count(`".$this->prefix."ID`),')') as optText, count(`".$this->prefix."ID`) as nCount
				FROM `".$this->table."`
				INNER JOIN `vw_profit` on `pccID`=`".$this->prefix."ProfitID`
				WHERE {$sqlWhere} AND `".$this->prefix."CompanyID`='{$company}'
				GROUP BY pccID
				ORDER BY pccID";
		$rs = $this->oSQL->q($sqlTabs);
		return ($this->fillTabs($rs));
	}
	
	public function getItemTabs($sqlWhere){/*------------------- Tabsheets for Profit selection ----------------------*/
		
		$this->tabKey = $this->prefix.'ItemGUID';
		
		if(!$sqlWhere){
			if ($this->type=='ENT'){
				$sqlWhere = $this->prefix."StateID=".(integer)$_GET[$this->prefix."StateID"];
			} else {
				$sqlWhere = '1=1';
			}
			//$sqlWhere = $this->prefix."StateID=".(integer)$_GET["StateID"];
		} 	
		
		$sqlTabs = "SELECT `itmGUID` as optValue, CONCAT(`itmTitle".$this->strLocal."`,' (', count(`".$this->prefix."ID`),')') as optText, count(`".$this->prefix."ID`) as nCount
				FROM `".$this->table."`
				INNER JOIN `vw_item` on `itmGUID`=`".$this->prefix."ItemGUID`
				WHERE $sqlWhere
				GROUP BY itmGUID
				ORDER BY itmOrder";
		$rs = $this->oSQL->q($sqlTabs);
		return ($this->fillTabs($rs));
	}
	
	public function getLocationTabs($sqlWhere){/*------------------- Tabsheets for Location selection ----------------------*/
		GLOBAL $company;
		
		$this->tabKey = $this->prefix.'LocationID';
		
		if(!$sqlWhere){
			if ($this->type=='ENT'){
				$sqlWhere = $this->prefix."StateID=".(integer)$_GET[$this->prefix."StateID"];
			} else {
				$sqlWhere = '1=1';
			}
			//$sqlWhere = $this->prefix."StateID=".(integer)$_GET["StateID"];
		} 	
		
		$sqlTabs = "SELECT `locID` as optValue, CONCAT(`locTitle".$this->strLocal."`,' (', count(`".$this->prefix."ID`),')') as optText, count(`".$this->prefix."ID`) as nCount
				FROM `".$this->table."`
				INNER JOIN `vw_location` on `locID`=`".$this->prefix."LocationID`
				WHERE $sqlWhere AND `".$this->prefix."CompanyID`='{$company}'
				GROUP BY locID
				ORDER BY locID";
		$rs = $this->oSQL->q($sqlTabs);
		return ($this->fillTabs($rs));
	}
	public function getStatusTabs($sqlWhere){
				
		$this->tabKey = $this->prefix.'StateID';
		
		/*------------------- Tabsheets for Status selection ----------------------*/
		$sqlTabs = "SELECT `staID` as optValue, CONCAT(`staTitle".$this->strLocal."`,' (', count(`".$this->prefix."ID`),')') as optText, count(`".$this->prefix."ID`) as nCount
				FROM `".$this->table."`
				LEFT JOIN `stbl_status` on `staID`=`".$this->prefix."StateID`
				WHERE $sqlWhere
				GROUP BY staID
				ORDER BY staID";
		$rs = $this->oSQL->q($sqlTabs);
		return ($this->fillTabs($rs));
	}
	
	public function getEmptyTabs($sqlWhere){		
		$this->tabKey = '';		
		$arrTabs[] = Array('optValue'=>'all','optText'=>($this->strLocal?"Все":"All"));
		return($arrTabs);
	}
	
	public function fillTabs($rs){
		while ($rw=$this->oSQL->f($rs)) {
			$arrTabs[]=$rw;
			$nCount += $rw['nCount'];
		}
		if(count($arrTabs)>1) {
			$arrTabs[] = Array('optValue'=>'all','optText'=>($this->strLocal?"Все":"All").' ('.$nCount.')');
		}
		return($arrTabs);
	}
	
	public function getSqlWhere(){
		if ($_GET[$this->prefix."StateID"]){		 	
			
			$sql = $this->prefix."StateID=".(integer)$_GET[$this->prefix."StateID"];
			$_SESSION[$this->prefix.'_where'] = $sql;
			

		} else {
			$sql = "{$this->prefix}Scenario IN (SELECT scnID FROM tbl_scenario WHERE scnFlagArchive=0)";//$_SESSION[$this->prefix.'_where'];
		}
		return ($sql);
	}
	
	private function getStatusData(){
		if (isset($_GET[$this->prefix."StateID"])){		 	
			$sql = "SELECT * FROM stbl_status WHERE staID=".(integer)$_GET[$this->prefix."StateID"];
			$rs = $this->oSQL->q($sql);		
			$res = $this->oSQL->f($rs);
		}
		return($res);
	}
	
	private function setFields($rw){		
		$this->prefix = $rw['entPrefix'];
		$this->table = $rw['entTable'];
		$this->form = $rw['entForm'];
		$this->type = $rw['entType'];
		$this->title = $rw['entTitle'.$this->strLocal];
	}
	
}

?>
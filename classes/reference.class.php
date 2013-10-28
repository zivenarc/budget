<?php

interface Ref{
	public function getById($id);
	public function getByCode($code);
	public function next();
}



class Reference{
	
	public static $child_class;
	public $pointer;
	public $pointers = Array();
	
	function __construct(){
		GLOBAL $oSQL;
		$this->oSQL = $oSQL;
	}
	
	function getById($id){
		$params = $this->data[$id];
		if (is_array($params)){	
			$mapperClass = new ReflectionClass($this->child_class);			
			$oInstance = $mapperClass->newInstance($id,$params);
			// $oInstance = new $$this->child_class($id,$params);
			return ($oInstance);
		} else {
			return (false);
		}
	}
	
	function getByCode($code){
		$guid = $this->codes[$code];
		return ($this->getById($guid)); 
	}
	
	function next(){
		$this->pointer++;
		$guid = $this->pointers[$this->pointer];
		
		if ($guid){
			$this->current = $this->getById($guid);
			
			return (true);
		} else {
			return (false);
		}
	}
}
?>
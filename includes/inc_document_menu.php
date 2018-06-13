<?php
if($oDocument->flagUpdate){
	if ($oDocument->flagPosted){
		$arrActions[] = Array('title'=>'Unpost','class'=>'reject', 'action'=>'javascript:budget_save(\'unpost\');');
	} elseif ($oDocument->GUID) {
		if (!$oDocument->flagDeleted){
			$arrActions[] = Array ('title'=>($strLocal?"Сохранить":'Update'),'class'=>'save', 'action'=>'javascript:budget_save();');
			$arrActions[] = Array ('title'=>($strLocal?"Провести":'Post'),'class'=>'accept', 'action'=>'javascript:budget_save(\'post\');');
			$arrActions[] = Array ('title'=>($strLocal?"Удалить":'Delete'),'class'=>'delete', 'action'=>'javascript:budget_save(\'delete\');');			
		} else {
			$arrActions[] = Array ('title'=>($strLocal?"Восстановить":'Restore'),'class'=>'undo', 'action'=>'javascript:budget_save(\'restore\');');			
		}
	} else {
		$arrActions[] = Array('title'=>'Save','class'=>'save', 'action'=>'javascript:budget_save(\'new\');');
	}
} elseif (!isset($oDocument->budget)) {
	$arrActions[] = Array('title'=>'Save','class'=>'save', 'action'=>'javascript:budget_save(\'new\');');
}

if ($oDocument->GUID) {
	$arrActions[] = Array ('title'=>($strLocal?"Данные":"Master data"), 'action'=>$_SERVER['REQUEST_URI']."&DataAction=master", 'class'=>'table');
	$arrActions[] = Array ('title'=>($strLocal?"Поделиться...":"Share..."), 'action'=>"javascript:assign()", 'class'=>'send');
	$arrActions[] = Array ('title'=>($strLocal?"Печать":"Print"), 'action'=>"javascript:print()", 'class'=>'print');
}
?>
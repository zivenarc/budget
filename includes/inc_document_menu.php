<?php
if($oDocument->budget->flagUpdate){
	if ($oDocument->flagPosted){
		$arrActions[] = Array('title'=>'Unpost','class'=>'reject', 'action'=>'javascript:budget_save(\'unpost\');');
	} elseif ($oDocument->GUID) {
		if (!$oDocument->flagDeleted){
			$arrActions[] = Array('title'=>'Update','class'=>'save', 'action'=>'javascript:budget_save();');
			$arrActions[] = Array('title'=>'Post','class'=>'accept', 'action'=>'javascript:budget_save(\'post\');');
			$arrActions[] = Array('title'=>'Delete','class'=>'delete', 'action'=>'javascript:budget_save(\'delete\');');
		}
	} else {
		$arrActions[] = Array('title'=>'Save','class'=>'save', 'action'=>'javascript:budget_save(\'new\');');
	}
} elseif (!isset($oDocument->budget)) {
	$arrActions[] = Array('title'=>'Save','class'=>'save', 'action'=>'javascript:budget_save(\'new\');');
}
?>
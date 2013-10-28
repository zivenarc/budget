<?php
if ($oDocument->flagPosted){
	$arrActions[] = Array('title'=>'Unpost','class'=>'reject', 'action'=>'javascript:save(\'unpost\');');
} elseif ($oDocument->GUID) {
	$arrActions[] = Array('title'=>'Update','class'=>'save', 'action'=>'javascript:save();');
	$arrActions[] = Array('title'=>'Post','class'=>'accept', 'action'=>'javascript:save(\'post\');');
} else {
	$arrActions[] = Array('title'=>'Save','class'=>'save', 'action'=>'javascript:save(\'new\');');
}
?>
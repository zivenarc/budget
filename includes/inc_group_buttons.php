<?php
	$arrActions[] = Array ('title'=>$strLocal?'Группы клиентов':'By customer group','action'=>"?type=customer_group");
	$arrActions[] = Array ('title'=>$strLocal?'Клиенты':'By customer','action'=>"?type=customer");
	$arrActions[] = Array ('title'=>$strLocal?'Номенклатура':'By activity','action'=>"?type=activity");
	$arrActions[] = Array ('title'=>$strLocal?'Продукты GHQ':'By GHQ type','action'=>"?type=ghq");
	$arrActions[] = Array ('title'=>$strLocal?'Ответственные':'By BDV staff','action'=>"?type=sales");	
	$arrActions[] = Array ('title'=>$strLocal?'Подразделения':'By BU','action'=>"?type=pc");	
	$arrActions[] = Array ('title'=>$strLocal?'Группы БЮ':'By BU Group','action'=>"?type=bu_group");	
	$arrActions[] = Array ('title'=>$strLocal?'Отделы продаж':'By BDV dept','action'=>"?type=bdv");	
	$arrActions[] = Array ('title'=>$strLocal?'Отрасли':'By IV','action'=>"?type=iv");	
	$arrActions[] = Array ('title'=>$strLocal?'Фильтр по номенклатуре':'Activity filter','action'=>"javascript:showActivityList();",'class'=>'filter');	
?>
<?php
if ($arrUsrData["FlagCreate"]){
		$arrActions[] = Array(
		   "title" => ($strLocal?"Создать":"Create")
		   , "action" => $entity->form
		   , "class" => "new" 
		);
	}

$arrActions[] = Array(
	   "title" => ($strLocal?"Печать":"Print")
	   , "action" => "javascript:window.print()"
	   , "class" => 'print'
);

$arrActions[] = Array(
	   "title" => ($strLocal?"Справка":"Help")
	   , "action" => "/wiki".$prj_path."/".$entity->title
	   , "class" => 'question'
);

?>
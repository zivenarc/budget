<?php
require ('common/auth.php');

if ($arrUsrData['FlagInsert']){
require ("../common/easyGrid/inc_easyGrid.php");
$grid = new easyGrid($oSQL,"setup",40,true,false, $arrUsrData,"tbl_setup","stp", true);

$grid->Columns[] = Array(
    'field' => "stpID"
    , 'type' => "row_id"
    , 'nowrap' => true
);

$grid->Columns[] = Array(
      'title' => "Name"
    , 'field' => "stpCharName"
    , 'type' => "text"
    , 'mandatory' => "true"
    , 'width'=>"17em"
    , 'nowrap' => true

);

if ($arrUsrData["FlagWrite"]) {
    $grid->Columns[] = Array(
          'title' => "System name"
        , 'field' => "stpVarName"
        , 'type' => "text"
        , 'mandatory' => "true"
        , 'width'=>"120"
        , 'nowrap' => true
		, 'maxlength' => 20
    );
    $grid->Columns[] = Array(
          'title' => "Type"
        , 'field' => "stpCharType"
        , 'type' => "text"
        , 'mandatory' => "true"
        , 'width'=>"4em"
        , 'nowrap' => true
    );
    $grid->Columns[] = Array(
          'title' => "RO"
        , 'field' => "stpFlagReadOnly"
        , 'type' => "checkbox"
        , 'mandatory' => "true"
        , 'width' => '40'
    );
}
    $grid->Columns[] = Array(
          'title' => "Value"
        , 'field' => "stpCharValue"
        , 'type' => "textarea"
        , 'mandatory' => "true"
        , 'width'=>"30em"
        , 'nowrap' => true
    );
    $grid->Columns[] = Array(
          'title' => "Edited"
        , 'field' => "stpEditBy"
        , 'type' => "userid"
        , 'disabled' => true
    );
    $grid->Columns[] = Array(
          'title' => "on"
        , 'field' => "stpEditDate"
        , 'type' => "datetime"
        , 'disabled' => true
    );



   $sql = "SELECT * FROM tbl_setup
             ORDER BY stpCharName";
   $rs = $oSQL->do_query($sql);
   while ($rw = $oSQL->fetch_array($rs))
       $grid->Rows[] =  $rw;

   $oSQL->free_result($rs);

	 if ($_POST){
		$grid->Update();
		SetCookie("UserMessage", "List successfully updated");
		redirect($_SERVER["PHP_SELF"]);
		die();
	}


require ("common/inc_list_menu.php");
require ('includes/inc-frame_top.php');
$strTitle = "pagTitle".$strLocal;
echo "<h1>",$arrUsrData[$strTitle],"</h1>";

$grid->Execute($oSQL);
} else {
	
	if ($_POST && $arrUsrData['FlagUpdate']){
		$sql = Array();
		foreach ($_POST as $key=>$value){
			$sql[] = "UPDATE `tbl_setup` SET `stpCharValue` = ".$oSQL->escape_string($value)." WHERE `stpVarName`='".$key."' LIMIT 1;";
		}
		
		$success = true;
		for ($i=0;$i<count($sql);$i++) $success &= $oSQL->do_query($sql[$i]);
		if ($success) SetCookie('UserMessage',"Setup table successfully updated");
		
		redirect($_SERVER['PHP_SELF']);
		die();
	}
$sql = "SELECT * FROM tbl_setup ORDER BY stpFlagReadOnly DESC, stpCharName";
$rs = $oSQL->do_query($sql);
while ($rw = $oSQL->fetch_array($rs)){
	$arrForm[] = Array('title'=>$rw["stpCharName"]
						,'field'=>$rw['stpVarName']
						,'disabled'=>$rw['stpFlagReadOnly']
						,'value'=>$rw['stpCharValue']
						,'type'=>$rw['stpCharType']);
}

$arrActions[] = Array('title'=>'Save', 'action'=>"javascript:$('#entity').submit();", 'class'=>'save');

require ('includes/inc-frame_top.php');
$strTitle = "pagTitle".$strLocal;
echo "<h1>",$arrUsrData[$strTitle],"</h1>";	
?>
	<div class="panel">
			<?php
				$data = Array ('PHP_SELF'=>$_SERVER["PHP_SELF"],
								'myForm'=>Array('columns'=>$arrForm
								,'ID'=>'setup'
								,'name'=>'setup'
								,'method'=>'post'),
				); 
				simpleForm($data);
			?>
	</div>
<?php
}
require ('includes/inc-frame_bottom.php');
?>
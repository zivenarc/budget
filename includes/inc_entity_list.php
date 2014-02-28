<?php
if (!$_GET['tab'] && !$_GET['DataAction']){
	$arrJS[] = "/common/eiseList/eiseList.js";
	$arrJS[]='js/lst_entity.js';
	$arrCSS[] = "/common/eiseList/themes/default/screen.css";
	require ("includes/inc_entity_list_menu.php");
	require ('includes/inc-frame_top.php');
	
	?>
	<h1><?php echo $arrUsrData["pagTitle$strLocal"];?></h1>
	<h2><?php echo $entity->status["staTitle$strLocal"];?></h2>
	<p><?php echo $entity->status["staDescription$strLocal"];?></p>
	<?php
		if (count($arrTabs)){
			getUITabs($arrTabs);
		} else {
			echo '<center>',($strLocal?"Нет записей":"No records"),'</center>';
		}
	?>
	<ul class='link-footer'>
		<li><a href='<?php echo $_SERVER['REQUEST_URI']; ?>'><?php echo ($strLocal?"Постоянная ссылка":"Link to this list");?></a></li>
	</ul>
	<?php
	require ('includes/inc-frame_bottom.php');
} else {
	//$_DEBUG = true;
	$sqlWhere = $entity->getSqlWhere();
		
	$strTabKeyValue=$_GET['tab'];
	if ($_GET['tab']==='all' || !$_GET['tab']) {
		$sqlTabFilter = "1=1";
	} else {
		$sqlTabFilter = $entity->tabKey."='$strTabKeyValue'";
	};
			
	$sqlWhere .= ($sqlWhere && $sqlTabFilter?" AND ":"").$sqlTabFilter;
	$sqlWhere .= ($sqlWhere && $sqlMyFilter?" AND ":"").$sqlMyFilter;
	
	$lst = new EntityList(Array('entID'=>$entID,
								'strTabKey'=>$entity->tabKey,
								'sqlWhere'=>$sqlWhere,
								'showTabField'=>($_GET['tab']=='all')));
	$lst->debug = $_DEBUG;	
	$lst->handleDataRequest();
	
	if ($_DEBUG){
		echo '<pre>';
		print_r ($lst);
		echo '</pre>';
	}
	
	$lst->show();
}
	
?>
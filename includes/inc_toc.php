<?php 
$pagParentID = (integer)$_GET['pagID'];
/*-----------------------------Standard menu from stbl_page table---------------------------------*/	
$sql = "SELECT PG1.pagID
            , PG1.pagParentID
            , PG1.pagTitle$strLocal
            , PG1.pagFile
            , PG1.pagIdxLeft
            , PG1.pagIdxRight
            , PG1.pagFlagShowInMenu
            , PG1.pagClass
            , PG1.pagEntityID
            , COUNT(DISTINCT PG2.pagID) as iLevelInside
            , MAX(PGR.pgrFlagRead) as FlagRead
            , MAX(PGR.pgrFlagWrite) as FlagWrite
    FROM stbl_page PG1
            INNER JOIN stbl_page PG2 ON PG2.pagIdxLeft<=PG1.pagIdxLeft AND PG2.pagIdxRight>=PG1.pagIdxRight
            INNER JOIN stbl_page PG3 ON PG3.pagIdxLeft BETWEEN PG1.pagIdxLeft AND PG1.pagIdxRight AND PG3.pagFlagShowInMenu=1
            INNER JOIN stbl_page_role PGR ON PG1.pagID = PGR.pgrPageID
            INNER JOIN stbl_role ROL ON PGR.pgrRoleID=ROL.rolID
            LEFT JOIN stbl_role_user RLU ON PGR.pgrRoleID=RLU.rluRoleID
    WHERE 
     (RLU.rluUserID='$usrID' OR ROL.rolFlagDefault=1)
     AND PG1.pagFlagShowInMenu=1
	 ##AND PG1.pagParentID<>1
    GROUP BY 
            PG1.pagID
            , PG1.pagParentID
            , PG1.pagTitle
            , PG1.pagFile
            , PG1.pagIdxLeft
            , PG1.pagIdxRight
            , PG1.pagFlagShowInMenu
    HAVING (MAX(PGR.pgrFlagRead)=1 OR MAX(PGR.pgrFlagWrite)=1) 
    ORDER BY PG1.pagIdxLeft";

    $rs = $oSQL->do_query($sql);
	?>

    
<ul role="nav" class="sidebar-menu" id="toc">
<li class='sidebar-header'><?php echo $title;?></li>
<?php
$strOutput .= "";	
$rw_old["iLevelInside"] = 3;

while ($rw = $oSQL->fetch_array($rs)){
    
    $hrefSuffix = "";
    
    for ($i=$rw_old["iLevelInside"]; $i>$rw["iLevelInside"]; $i--)
       echo str_repeat("\t",$i-1),"</ul>\r\n";
    
    for ($i=$rw_old["iLevelInside"]; $i<$rw["iLevelInside"]; $i++)
       echo str_repeat("\t",$i),"<ul class='treeview-menu sidebar-submenu'>\r\n";
    
    if (preg_match("/list\.php$/", $rw["pagFile"]) && $rw["pagEntityID"]!=""){
       $hrefSuffix = "?".$rw["pagEntityID"]."_staID=";
    }
    
    echo str_repeat("\t",$rw["iLevelInside"]);
		if ($rw['pagFile']){
		?>
		<li class="<?php echo ($rw["pagParentID"]==1? "open": "");?>" id="<?php echo $rw["pagID"];?>">
			<a target='pane' href='<?php echo $app_path.$prj_path.$rw["pagFile"].$hrefSuffix;?>'><span class='fa <?php echo $rw['pagClass'];?>'></span><span><?php echo $rw["pagTitle$strLocal"];?></span></a>			
		</li>
		<?php
		} else {
			?>
		<li class='treeview'><a href='#'><span class='fa <?php echo $rw['pagClass'];?>'></span><span><?php echo $rw["pagTitle$strLocal"];?></span><span class="fa fa-angle-left pull-right"></span></a>
		
		<?php }
		
    if ($hrefSuffix){
      $sqlSta = "SELECT * FROM stbl_status WHERE staEntityID='".$rw["pagEntityID"]."'";
      $rsSta = $oSQL->do_query($sqlSta);
      while ($rwSta = $oSQL->fetch_array($rsSta)){
         echo "<li id='".$rw["pagID"]."_".$rwSta["staID"]."'><a target='pane' href='".
            $app_path.$prj_path.$rw["pagFile"]."?".$rw["pagEntityID"]."_staID=".$rwSta["staID"]."'>".$rwSta["staTitle$strLocal"]."</a></li>";
            //$rw["pagFile"]."?".$rw["pagEntityID"]."_staID=".$rwSta["staID"]."'>".$rwSta["staTitle$strLocal"]."</a>\r\n";
      }
   }
   
   $rw_old = $rw;
}
for ($i=$rw_old["iLevelInside"]; $i>1; $i--)
   echo str_repeat("\t",$i),"</li>\r\n\r\n";
/*============================= OUTPUT ==================================*/	

?>
</ul>
<div>&nbsp;</div>
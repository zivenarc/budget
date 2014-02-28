<?php
$flagNoAuth = true;
define ("CRLF","\r\n");
define ("TAB","\t");
require ('common/auth.php');
$pccCode1C = $_GET['pccCode1C']?$_GET['pccCode1C']:"";
$scenario = $_GET['scenario']?$_GET['scenario']:$budget_scenario;

$sql = "select `pc`
			,LPAD(`activity`,9,'0') AS 'КодНоменклатурнойГруппы'
			,`customer`
			,`cntTitleLocal`
			,LPAD(`cntCode1C`,9,'0') AS 'КодКонтрагента'
			,`account` as 'YACT'
			,`item`
			,`itmTitle`
			,LPAD(`itmID`,5,'0') AS 'КодБюджетногоСчета'
			,SUM(`Jan`) as 'Jan'
			,SUM(`Feb`) as 'Feb'
			,SUM(`Mar`) as 'Mar'
			,SUM(`Apr`) as 'Apr'
			,SUM(`May`) as 'May'
			,SUM(`Jun`) as 'Jun'
			,SUM(`Jul`) as 'Jul'
			,SUM(`Aug`) as 'Aug'
			,SUM(`Sep`) as 'Sep'
			,SUM(`Oct`) as 'Oct'
			,SUM(`Nov`) as 'Nov'
			,SUM(`Dec`) as 'Dec'
			,`scenario`
			,`particulars`
			,PART.`КодФизЛица`
			,PART.`ТипФизЛица`			
			,`pccTitle`
			,`pccCode1C`			
		FROM `reg_master` 
			left join `vw_item` on `itmGUID` = `item`
			left join `vw_profit` on `pccID` = `pc`
			left join `vw_customer` on `cntID` = `customer`
			left join (SELECT 'EMP' as 'ТипФизЛица', empGUID1C as 'guid', TRIM(empCode1C) as 'КодФизЛица' FROM vw_employee
						UNION ALL
						SELECT 'FIX', fixGUID, TRIM(fixID) FROM vw_fixed_assets
						UNION ALL
						SELECT 'CNT', cntGUID1C, TRIM(cntID) FROM vw_supplier) PART
				on PART.guid=particulars
		where `active` = 1 AND scenario=".$oSQL->e($scenario)." 
			AND source<>'estimate'
			 AND pccCode1C=".$oSQL->e($pccCode1C)."
		GROUP BY activity, customer, account, item, particulars";

// echo '<pre>',$sql,'</pre>';
// ob_flush();
// die ();

$rs = $oSQL->q($sql);

ob_start();
echo '<?xml version="1.0" encoding="utf-8"?>'.CRLF;
echo '<root>';
while ($rw = $oSQL->f($rs)){
		echo '<item>'.CRLF;
			foreach ($rw as $key=>$value){
			echo TAB."<$key>".str_replace('&','&amp;',$value)."</$key>".CRLF;
		}
		echo '</item>'.CRLF;
}
?>
</root>
<?php
$res = ob_get_clean();
$resLength = strlen($res);
header("Content-type: application/xml");
// header("Content-type: text/plain");
header("Content-length: $resLength");
echo ($res);
?>


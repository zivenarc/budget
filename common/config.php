<?php
define ('ADMIN_EMAIL_ADDR', 'igor.zhuravlev@gmail.com');
define ('APP_NAME', 'Budget');
define ('GENERIC_ERR_PAGE', 'budget/error.html');

$DBHOST = "localhost";
$DB = "budget";
$DBUSER = "root";
$DBPASS = "Yu$3NSQL";
$prj_path = "/budget";
$app_path = "";

$dbType ="MySQL";

$title = 'Budget';
$strSubTitle = 'localhost';

$strPageTitle = (isset($strPageTitle) ? $strPageTitle : "Budget");
$strAuthMode="cookie";
$strMode = "LDAP";

define ('DWOO_FILE_LOG','../common/dwoo/templates/inc_files.tpl');
define ('DWOO_ACTION_LOG','../common/dwoo/templates/inc_action_log.tpl');
define ('DWOO_STICKY','../common/dwoo/templates/inc_sticky.tpl');
define ('DWOO_ENTITY_HEADER','../common/dwoo/templates/inc_entity_header.tpl');
define ('DWOO_ENTITY_FOOTER','../common/dwoo/templates/inc_entity_footer.tpl');
define ('DWOO_EASYFORM','../common/dwoo/templates/inc_easyform.tpl');

$arrJS[] = '/common/jquery/jquery-1.7.1.min.js';
$arrJS[] = '/common/jquery/ui/js/jquery-ui-1.10.1.custom.min.js';
//$arrJS[] = 'js/ef_common.js';
$arrCSS[] = "common/style.css";
$arrCSS[] = "/common/jquery/ui/css/redmond/jquery-ui-1.10.2.custom.min.css";

// function __autoload($class_name) {
    // include_once ('classes/'.strtolower($class_name).'.class.php');
// }

$budget_scenario = 'B2014';

?>

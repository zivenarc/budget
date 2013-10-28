<?php
define ('ADMIN_EMAIL_ADDR', 'igor.zhuravlev@gmail.com');
define ('APP_NAME', 'Treasury');
define ('GENERIC_ERR_PAGE', 'treasury/error.html');

$DBHOST = "localhost";
$DB = "treasury";
$DBUSER = "root";
$DBPASS = "Yu$3NSQL";
$prj_path = "/treasury";
$app_path = "";

$dbType ="MySQL";

$title = 'Treasury';
$strSubTitle = 'server_alias';

$strPageTitle = (isset($strPageTitle) ? $strPageTitle : "Treasury");
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
$arrCSS[] = "common/style.css";
$arrCSS[] = "/common/jquery/ui/css/redmond/jquery-ui-1.10.2.custom.min.css";

?>

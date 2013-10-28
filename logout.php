<?php
SetCookie ("authstring",NULL);
SetCookie ("UserMessage","You have successfully logged out");
header ("Location: login.php");
?>
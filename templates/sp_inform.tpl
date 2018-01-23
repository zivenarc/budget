<html>
<head>
<style>
{literal}
body{font-family: Arial, Helvetica, sans-serif; font-size: 10pt;}
.message{
	font-family: Georgia, serif;
	font-size: 12pt;
	font-weight: bold;
	color: #444;
	}
{/literal}
</style>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 10pt;">
<p>Dear {$recipient},</p>
<p>Please follow this link to the document [<strong>{$entity} {$title}</strong>], it needs your attention</p>
<p><a target="_blank" href="{$href}">{$href}</a></p>
<div class="message" style="font-family: Georgia, serif;
	font-size: 12pt;
	font-weight: bold;
	color: #000055;">{$message}</div>
<p>Thanks and best regards,</p>
<p>{$sender}</p>
<div><a href="{$link}">{$link}</a></div>
<p><small>Sent from Budget subsystem</small></p>
</body>
</html>
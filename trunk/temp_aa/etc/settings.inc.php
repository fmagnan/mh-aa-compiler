<?php

require_once dirname(__FILE__). '/../lib/maintenance.inc.php';

header('Content-type: text/html; charset=utf-8');
error_reporting(0);

if (isSiteStoppedForMaintenance()) {
	echo	'<body style="background-color:black;"><div style="margin-left:2%;color:gray;'.
			'border:2px dotted gray;text-align:center;width:55%;font-size:1.2em;font-weight:bold;'.
			'margin-bottom:30px;">Le site est actuellement en maintenance.<br />'.
			'Merci de bien vouloir patienter.</div></body>';
	exit();
}

?>

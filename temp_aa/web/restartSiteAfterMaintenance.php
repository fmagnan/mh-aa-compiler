<?php
require_once dirname(__FILE__) . '/../lib/maintenance.inc.php';

$activationCode = $_GET['activation_code'];
if ($activationCode == 'doubleZero') {
	restartSiteAfterMaintenance();
	echo 'OK';
}


?>

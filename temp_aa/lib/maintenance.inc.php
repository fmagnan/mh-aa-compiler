<?php

require_once 'core.inc.php';

function isSiteStoppedForMaintenance() {
	connectToDB();
	$selectQuery = "SELECT `data_value` FROM `global_data` WHERE `data_key`='maintenance'";
	$result = mysql_fetch_array(mysql_query($selectQuery));
	disconnectFromDB();
	return $result;
}

function stopSiteForMaintenance() {
	if (isSiteStoppedForMaintenance()) {
		$updateQuery = "UPDATE `global_data` set `data_value`='1' WHERE `data_key`='maintenance'";
	}
	else {
		$updateQuery = "INSERT INTO `global_data` ( `data_key` , `data_value` ) VALUES ('maintenance', '1');";
	}
	
	connectToDB();
	mysql_query($updateQuery);
	disconnectFromDB();
}

function restartSiteAfterMaintenance() {
	connectToDB();
	$deleteQuery = "DELETE FROM `global_data` WHERE `data_key`='maintenance'";
	$result = mysql_query($deleteQuery);
	disconnectFromDB();
}

?>

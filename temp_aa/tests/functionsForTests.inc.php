<?php

function getAbsolutePathForFile($fileName) {
	return dirname(__FILE__). '/' . $fileName;
}
		
function getMySQLCommandLine() {
	return 'mysql -u '._USER_.' -p'._PWD_.' -h '._HOST_.' '._DB_.' < ';
}

?>
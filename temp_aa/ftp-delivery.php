<?php

require_once 'lib/maintenance.inc.php';

$ftpPassword= $ftpConfig['ftpPassword'];
$httpUser= $ftpConfig['httpUser'];
$httpPassword= $ftpConfig['httpPassword'];
$host = $ftpConfig['host'];

$wgetCommand = 'wget --http-user='.$httpUser.' --http-password='.$httpPassword.' ' . $host;

$ncftpCommand = dirname(__FILE__) . '/ncftpreplace.sh ' . $ftpPassword;
activatePageByWget('stopSiteForMaintenance.php');

uploadByFTP('/etc/settings.inc.php', 'etc');
uploadByFTP('/etc/constants.inc.php', 'etc');
uploadByFTP('/lib/*.php', 'lib');
uploadByFTP('/sql/*.sql', 'sql');
uploadByFTP('/web/*.php', 'web');
uploadByFTP('/web/css/*.css', 'web/css');
uploadByFTP('/web/images/*.*', 'web/images');
uploadByFTP('/web/js/*.js', 'web/js');
uploadByFTP('/web/smarty/templates/*.tpl', 'web/smarty/templates');

activatePageByWget('restartSiteAfterMaintenance.php');

function uploadByFTP($localPattern, $destinationFolder) {
	global $ncftpCommand;
	global $ftpConfig;
	
	$lib = glob(dirname(__FILE__) . $localPattern);
	foreach ($lib AS $filePath) {
		shell_exec($ncftpCommand . ' ' . $filePath . ' ' . $ftpConfig['remoteRootDirectory'] . $destinationFolder);
	}
}

function activatePageByWget($pageURL) {
	global $wgetCommand;
	$activationCode = 'doubleZero';
	$completeLineCommand = $wgetCommand . $pageURL . '?activation_code='.$activationCode;
	echo $completeLineCommand;
	
	shell_exec($completeLineCommand);
	shell_exec('rm ' . $pageURL . '*');
}
?>
<?php

require_once 'lib/maintenance.inc.php';

if(!isset($argv[1]) || !isset($argv[2]) || !isset($argv[3])) {
	echo 'usage : [php4|php5] livraison.php <ftpPassword> <httpUser> <httpPassword>' . "\n";
	die();
}

$ftpPassword= $argv[1];
$httpUser= $argv[2];
$httpPassword= $argv[3];


$wgetCommand = 'wget --http-user='.$httpUser.' --http-password='.$httpPassword.' http://sirherbert.byethost32.com/AA/web/';

$ncftpCommand = dirname(__FILE__) . '/ncftpreplace.sh ' . $ftpPassword;
$remote_root_directory = ' /htdocs/AA/';

activatePageByWget('stopSiteForMaintenance.php');

uploadByFTP('/etc/settings.inc.php', 'etc');
uploadByFTP('/etc/constants.inc.php', 'etc');
uploadByFTP('/lib/*.php', 'lib');
uploadByFTP('/sql/*.sql', 'sql');
uploadByFTP('/web/*.php', 'web');
uploadByFTP('/web/.htaccess', 'web');
uploadByFTP('/web/css/*.css', 'web/css');
uploadByFTP('/web/images/*.*', 'web/images');
uploadByFTP('/web/js/*.js', 'web/js');
uploadByFTP('/web/smarty/templates/*.tpl', 'web/smarty/templates');

activatePageByWget('restartSiteAfterMaintenance.php');

function uploadByFTP($localPattern, $destinationFolder) {
	global $ncftpCommand;
	global $remote_root_directory;
	
	$lib = glob(dirname(__FILE__) . $localPattern);
	foreach ($lib AS $filePath) {
		shell_exec($ncftpCommand . ' ' . $filePath . ' ' . $remote_root_directory . $destinationFolder);
	}
}

function activatePageByWget($pageURL) {
	global $wgetCommand;
	$activationCode = 'doubleZero';
	
	echo $wgetCommand . $pageURL . '?activation_code='.$activationCode;
	
	shell_exec($wgetCommand . $pageURL . '?activation_code='.$activationCode);
	shell_exec('rm ' . $pageURL . '*');
}
?>
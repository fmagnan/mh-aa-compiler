<?php

// put full path to Smarty.class.php
require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
require_once dirname(__FILE__).'/../lib/core.inc.php';
require_once dirname(__FILE__).'/../etc/settings.inc.php';

$smarty = new Smarty();

$smarty->template_dir = dirname(__FILE__).'/smarty/templates';
$smarty->compile_dir = dirname(__FILE__).'/smarty/templates_c';
$smarty->cache_dir = dirname(__FILE__).'/smarty/cache';
$smarty->config_dir = dirname(__FILE__).'/smarty/configs';

if (array_key_exists('aa', $_POST)) {
	$analysis = stripslashes($_POST['aa']);

	$infosTroll = processAnalysis($analysis, dirname(__FILE__). '/../pub');
	if ($infosTroll != null) {
		$messageResultat = "Enregistrement pris en compte avec les infos suivantes :";
		$log_content = print_r($infosTroll, TRUE);
		
	}
	else {
		$messageResultat = "Impossible d'intégrer l'enregistrement avec les données suivantes :";
		$log_content = $analysis;
	}
}
else {
	$messageResultat = "Veuillez copier/coller l'intégralité du message du bot";
}

if (isset($log_content)) {
	$smarty->assign('logContent', $log_content);
}
$smarty->assign('messageResultat', $messageResultat);
$smarty->display('ajoute_AA.tpl');

?>
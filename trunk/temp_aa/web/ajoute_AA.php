<?php

// put full path to Smarty.class.php
require(dirname(__FILE__).'/../lib/Smarty/Smarty.class.php');
require(dirname(__FILE__).'/../lib/core.inc.php');

header('Content-type: text/html; charset=utf-8');

$smarty = new Smarty();

$smarty->template_dir = dirname(__FILE__).'/smarty/templates';
$smarty->compile_dir = dirname(__FILE__).'/smarty/templates_c';
$smarty->cache_dir = dirname(__FILE__).'/smarty/cache';
$smarty->config_dir = dirname(__FILE__).'/smarty/configs';

$analysis = stripslashes($_POST['aa']);

if ($analysis != '') {
	$infosTroll = processAnalysis($analysis);
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

$smarty->assign('messageResultat', $messageResultat);
$smarty->assign('logContent', $log_content);
$smarty->display('ajoute_AA.tpl');

?>
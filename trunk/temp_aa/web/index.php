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

if (!array_key_exists('fieldSort', $_GET)) {
	$fieldSort = 'numero';
}
else {
	$fieldSort = $_GET['fieldSort'];
}

if (!array_key_exists('typeSort', $_GET)) {
	$typeSort = 'ASC';
}
else {
	$typeSort = $_GET['typeSort'];
}

$tousLesTrolls = getTousLesTrolls($fieldSort, $typeSort);

$smarty->assign('typeSort', $typeSort);
$smarty->assign('fieldSort', $fieldSort);
$smarty->assign('trolls', $tousLesTrolls);
$smarty->assign('nombreDeLignes', count($tousLesTrolls));

if (array_key_exists('id', $_GET)) {
	$id = $_GET['id'];
	$infosTrollFromDB = getInfosTrollFromDB(intval($id));
	$smarty->assign('id', $id);
	$smarty->assign('ficheTroll', $infosTrollFromDB);
	$ageAnalyse = getAgeAnalyse($infosTrollFromDB['date_compilation']);
	$smarty->assign('ageAnalyse', $ageAnalyse);
}

$smarty->display('main_template.tpl');

?>
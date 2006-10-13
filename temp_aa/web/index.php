<?php

// put full path to Smarty.class.php
require(dirname(__FILE__).'/../Smarty/Smarty.class.php');
require(dirname(__FILE__).'/../lib/core.inc.php');

header('Content-type: text/html; charset=utf-8');

$smarty = new Smarty();

$smarty->template_dir = dirname(__FILE__).'/smarty/templates';
$smarty->compile_dir = dirname(__FILE__).'/smarty/templates_c';
$smarty->cache_dir = dirname(__FILE__).'/smarty/cache';
$smarty->config_dir = dirname(__FILE__).'/smarty/configs';

$id = $_GET['id'];
$fieldSort = $_GET['fieldSort'];
if ('' == $fieldSort) {
	$fieldSort = 'numero';
}

$typeSort = $_GET['typeSort'];
if ('' == $typeSort) {
	$typeSort = 'ASC';
}

$tousLesTrolls = getTousLesTrolls($fieldSort, $typeSort);

$smarty->assign('typeSort', $typeSort);
$smarty->assign('trolls', $tousLesTrolls);
$smarty->assign('nombreDeLignes', count($tousLesTrolls));


if ($id != '') {
	$infosTrollFromDB = getInfosTrollFromDB(intval($id));
	$smarty->assign('id', $id);
	$smarty->assign('ficheTroll', $infosTrollFromDB);
	$ageAnalyse = getAgeAnalyse($infosTrollFromDB['date_compilation']);
	$smarty->assign('ageAnalyse', $ageAnalyse);
}

$smarty->display('main_template.tpl');

?>
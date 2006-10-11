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

$tousLesTrolls = getTousLesTrolls();
$smarty->assign('trolls', $tousLesTrolls);

$id = $_GET['id'];
if ($id != '') {
	$infosTrollFromDB = getInfosTrollFromDB(intval($id));
	$smarty->assign('id', $id);
	$smarty->assign('ficheTroll', $infosTrollFromDB);
}

$smarty->display('main_template.tpl');

?>
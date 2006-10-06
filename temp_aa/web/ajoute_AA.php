<?php

// put full path to Smarty.class.php
require(dirname(__FILE__).'/../lib/Smarty/Smarty.class.php');
require(dirname(__FILE__).'/../lib/core.inc.php');

$smarty = new Smarty();

$smarty->template_dir = dirname(__FILE__).'/smarty/templates';
$smarty->compile_dir = dirname(__FILE__).'/smarty/templates_c';
$smarty->cache_dir = dirname(__FILE__).'/smarty/cache';
$smarty->config_dir = dirname(__FILE__).'/smarty/configs';

$analysis = utf8_encode(stripslashes($_POST['aa'])); 

if ($analysis != '') {
	$infosTroll = processAnalysis($analysis);
	echo 'Enregistrement pris en compte avec les infos suivantes :<br />';
	echo '<pre>' . print_r($infosTroll, TRUE) . '<pre/>';
}
else {
	$smarty->display('ajoute_AA.tpl');
}


?>
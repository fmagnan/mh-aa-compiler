<?php

// put full path to Smarty.class.php
require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';

$smarty = new Smarty();

$smarty->template_dir = dirname(__FILE__).'/smarty/templates';
$smarty->compile_dir = dirname(__FILE__).'/smarty/templates_c';
$smarty->cache_dir = dirname(__FILE__).'/smarty/cache';
$smarty->config_dir = dirname(__FILE__).'/smarty/configs';

$smarty->display('formulaire_ajout_AA.tpl');

?>
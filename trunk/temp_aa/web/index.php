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

if (!array_key_exists('fieldSort', $_REQUEST)) {
	$fieldSort = 'numero';
}
else {
	$fieldSort = $_REQUEST['fieldSort'];
}

if (!array_key_exists('typeSort', $_REQUEST)) {
	$typeSort = 'ASC';
}
else {
	$typeSort = $_REQUEST['typeSort'];
}

$tousLesTrolls = getTousLesTrolls($fieldSort, $typeSort);

$smarty->assign('typeSort', $typeSort);
$smarty->assign('fieldSort', $fieldSort);
$smarty->assign('trolls', $tousLesTrolls);
$smarty->assign('sortileges', $SORTILEGES);

if (array_key_exists('id', $_REQUEST)) {
	$id = $_REQUEST['id'];
	$intvalId = intval($id);
	if (array_key_exists('ajout_sortilege', $_REQUEST)) {
		$sortilegeAAjouter = $_REQUEST['ajout_sortilege'];
		addKnownSpell($intvalId, $sortilegeAAjouter);
	}
	if (array_key_exists('action', $_REQUEST)) {
		if ('delete' == $_REQUEST['action']) {
			$sortilegeASupprimer = $_REQUEST['sortilege'];
			deleteSpell($intvalId, $sortilegeASupprimer);
		}
	}
	
	$infosTrollFromDB = getInfosTrollFromDB($intvalId);
	$smarty->assign('id', $id);
	$smarty->assign('ficheTroll', $infosTrollFromDB);
	$ageAnalyse = getAgeAnalyse(time(), $infosTrollFromDB['date_compilation']);
	$smarty->assign('ageAnalyse', $ageAnalyse);
	$listeSortileges = getSpellsList($intvalId);
	if ('' == $listeSortileges) {
		$smarty->assign('aucunSortConnu', 'aucun sort connu');
	}
	else {
		$sortilegesConnus = explode(';', $listeSortileges);
		$smarty->assign('sortilegesConnus', $sortilegesConnus);
	}
}

$smarty->display('main_template.tpl');

?>
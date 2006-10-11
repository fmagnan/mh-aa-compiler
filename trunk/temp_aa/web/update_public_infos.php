<?php
	
	require_once dirname(__FILE__).'/../lib/PublicInfos.class.php';
	require_once dirname(__FILE__).'/../lib/core.inc.php';
	
	header('Content-type: text/html; charset=utf-8');
	
	$publicInfos = new PublicInfos();
    $publicInfos->updatePublicInfos();

	echo '<h2>mise à jour des infos : OK</h2>';
?>

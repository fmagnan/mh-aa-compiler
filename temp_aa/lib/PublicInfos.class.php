<?php

class PublicInfos {

    function PublicInfos() {
    }
    
    function getPublicInfosByFTP() {
    	$this->getFileByFTP("Public_Trolls.txt");
    	$this->getFileByFTP("Public_Guildes.txt");
    }
    
    function getFileByFTP($fileName) {
    	$ftpFileName = "ftp://ftp.mountyhall.com/".$fileName;//, ; 
    	$fileContents = utf8_encode(file_get_contents($ftpFileName));
    	$handle = @fopen(dirname(__FILE__).'/../pub/'.$fileName, "w");
    	if ($handle) {
    		fwrite($handle, $fileContents);
    		fclose($handle);
    		return TRUE;	
    	}    	
    	return FALSE;
    }
    
    function getTrollListByFTP() {
    	return $this->getFileByFTP("Public_Trolls.txt");
    }
    
    function getAllianceListByFTP() {
    	return $this->getFileByFTP("Public_Guildes.txt");
    }
    
    function updatePublicInfos() {
    	$tousLesTrolls = getTousLesTrolls();
    	foreach($tousLesTrolls AS $infosTroll) {
    		$numero = intval($infosTroll['numero']);
    		$publicInfos = getPublicInfos($numero, dirname(__FILE__).'/../pub');
    		$infosTroll['race'] = $publicInfos['race'];
    		$infosTroll['niveau_actuel'] = intval($publicInfos['niveau_actuel']);
    		$infosTroll['numero_guilde'] = intval($publicInfos['numero_guilde']);
    		$infosTroll['guilde'] = $publicInfos['guilde'];
    		updateTrollInDB($infosTroll);
    	}
    }
    	
}
?>
<?php

require_once 'maintenance.inc.php';

class PublicInfos {

    function PublicInfos() {
    }
    
    function getPublicInfosByFTP() {
    	$result = TRUE;
    	if (!$this->getFileByFTP("Public_Trolls.txt")) {
    		$result = FALSE;
    	}
    	if (!$this->getFileByFTP("Public_Guildes.txt")) {
    		$result = FALSE;
    	}
    	return $result;
    }
    
    function getFileByFTP($fileName) {
    	$ftpFileName = "ftp://ftp.mountyhall.com/".$fileName;
    	$localFileName = dirname(__FILE__).'/../pub/'.$fileName;
    	
    	$contentsInISO = file_get_contents($ftpFileName);
    	if (FALSE == $contentsInISO) {
    		trigger_error("Unable to retrieve file " . $ftpFileName);
    		return FALSE;
    	}
    	
    	$contentsInUTF8 = utf8_encode($contentsInISO);
    	$handle = @fopen($localFileName, "w");
    	if (FALSE == $handle) {
    		trigger_error("Unable to open local file " . $localFileName);
    		return FALSE;
    	}
    	fwrite($handle, $contentsInUTF8);
    	fclose($handle);
    	return TRUE;	
     }
    
    function getTrollListByFTP() {
    	return $this->getFileByFTP("Public_Trolls.txt");
    }
    
    function getAllianceListByFTP() {
    	return $this->getFileByFTP("Public_Guildes.txt");
    }
    
    function updatePublicInfos() {
    	if ($this->getPublicInfosByFTP()) {
	    	stopSiteForMaintenance();
    		$tousLesTrolls = getTousLesTrolls('numero', 'ASC');
    		foreach($tousLesTrolls AS $infosTroll) {
	    		$numero = intval($infosTroll['numero']);
	    		
	    		$publicInfos = getPublicInfos($numero, dirname(__FILE__).'/../pub');
    			$infosTroll['race'] = $publicInfos['race'];
    			$infosTroll['niveau_actuel'] = intval($publicInfos['niveau_actuel']);
    			$infosTroll['numero_guilde'] = intval($publicInfos['numero_guilde']);
    			$infosTroll['guilde'] = $publicInfos['guilde'];
    			updateTrollInDB($infosTroll);
    		}
    		restartSiteAfterMaintenance();
    	}
    }
    	
}
?>
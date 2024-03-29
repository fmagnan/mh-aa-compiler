<?php

require_once 'maintenance.inc.php';

class PublicInfos {

	var $defaultLocalPublicFolder;
	var $localPublicFolder;

    function PublicInfos() {
    	$this->defaultLocalPublicFolder = dirname(__FILE__).'/../pub/';
    	$this->localPublicFolder = $this->defaultLocalPublicFolder;
    }
    
    function setlocalPublicFolder($folderPath) {
    	$this->localPublicFolder = $folderPath;
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
    	$remoteFileName = "http://www.mountyhall.com/ftp/".$fileName;
    	$localFileName = $this->defaultLocalPublicFolder . $fileName;
    	
    	$remoteHandle = @fopen($remoteFileName, "r");
    	$localHandle = @fopen($localFileName, "w");
    	if (FALSE == $remoteHandle) {
    		trigger_error("Unable to open remote file " . $remoteFileName);
    		return FALSE;
    	}
    	if (FALSE == $localHandle) {
    		trigger_error("Unable to open local file " . $localFileName);
    		return FALSE;
    	}
    	
    	while (!feof($remoteHandle)) {
     		$lineInUTF8 = utf8_encode(fgets($remoteHandle));
     		fwrite($localHandle, $lineInUTF8);
		}
   		fclose($remoteHandle);
   		fclose($localHandle);
    	
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
	    		
	    		$publicInfos = getPublicInfos($numero, $this->localPublicFolder);
	    		if ($publicInfos != null) {
	    			$infosTroll['nom'] = $publicInfos['nom'];
    				$infosTroll['race'] = $publicInfos['race'];
    				$infosTroll['niveau_actuel'] = intval($publicInfos['niveau_actuel']);
    				$infosTroll['numero_guilde'] = intval($publicInfos['numero_guilde']);
	    			$infosTroll['guilde'] = $publicInfos['guilde'];
    				updateTrollInDB($infosTroll);
	    		}
    		}
    		restartSiteAfterMaintenance();
    	}
    }
    	
}
?>
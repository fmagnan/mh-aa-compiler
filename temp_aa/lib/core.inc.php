<?php

require_once 'Parser.class.php';
require_once 'Troll.class.php';
require_once 'database.inc.php';

function debugArray($array) {
	error_log(print_r($array, TRUE));
}

function isUpgradeFoundBetween($debut, $fin, $eventsFilePath) {
	$isUpgradeFound = false;
	$fileHandler = fopen($eventsFilePath, 'r');
	if ($fileHandler) {
		while (!feof($fileHandler)) {
     		$entireLine = trim(fgets($fileHandler, 4096));
     		preg_match("/(<td .*>)(.*\/.*\/.*:.*:.*)(<\/td>)/i", $entireLine, $dateCellArray);
     		
     		if (!empty($dateCellArray)) {
     			$dateCell = $dateCellArray[2];
     			$dateElements = explode(' ', $dateCell);
     			$dayDate = $dateElements[0];
     			$dayDateElements = explode('/', $dayDate);
     			$timeDate = $dateElements[1];
     			$timeDateElements = explode(':',$timeDate);
     			$upgradeTimeStamp = mktime($timeDateElements[0], $timeDateElements[1], $timeDateElements[2], $dayDateElements[1], $dayDateElements[0], $dayDateElements[2]);
     			
     			if ($upgradeTimeStamp > $debut && $upgradeTimeStamp < $fin) {
     				$isUpgradeFound = true;
     			}
     		}
   		}
   		fclose($fileHandler);
	}
	else {
		return true;
	}
	
	return $isUpgradeFound;
}

function getPathToEventsFile($numeroTroll, $eventsFilePath = false) {
	if ($eventsFilePath != false) {
		return $eventsFilePath;
	}
	else {
		return 'http://games.mountyhall.com/mountyhall/View/PJView_Events.php?ai_IDPJ='.$numeroTroll.'&as_EventType=AMELIORATION&as_Action=Afficher';
	}
}

function getTimeStampFromTrollDate($dateCompilation) {
	$date = explode('-', trim(substr($dateCompilation, 0, 10)));
    $time = explode(':', trim(substr($dateCompilation,11,strlen($dateCompilation))));
    return mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
}

function isDataOk($infosTroll) {
	foreach($infosTroll AS $key => $value) {
		if ($value == null) {
			trigger_error('isDataOk(): '.$key.' is null, AA creation is aborted');
			return FALSE;
		}
	}
	return TRUE;
}

function processAnalysis($analysis, $pathToPublicFiles, $pathToEventFiles = false) {
	$parser = new Parser($analysis);
	
	$infosTroll = $parser->parseDataAndRetrieveInfos($pathToPublicFiles);
	if ($infosTroll == null) {
		return null;
	}
	
	if (!isDataOk($infosTroll)) {
		return null;
	}
	
	$infosFromDB = getInfosTrollFromDB($infosTroll['numero']);
	if ($infosFromDB == FALSE) {
    	createTrollInDB($infosTroll);
    }
    else {
    	$timeStamp = getTimeStampFromTrollDate($infosTroll['date_compilation']);
    	$timeStampInDB = getTimeStampFromTrollDate($infosFromDB['date_compilation']);
    	
    	if ($timeStamp > $timeStampInDB) {
			$referenceInfos = $infosFromDB;
   			$updatingInfos = $infosTroll;
   			$startDate = $timeStampInDB;
   			$endDate = $timeStamp;
		}
    	else {
	  		$referenceInfos = $infosTroll;
    		$updatingInfos = $infosFromDB;
    		$startDate = $timeStamp;
   			$endDate = $timeStampInDB;
    	}
    	
    	$referenceInfos['sortileges'] = '';
    	$troll = new Troll($referenceInfos);
    	$isTrollUpgradingSinceLastTime = isUpgradeFoundBetween($startDate, $endDate, getPathToEventsFile($troll->getNumero(), $pathToEventFiles));
    	
    	error_log($isTrollUpgradingSinceLastTime);
    	
    	$troll->update($updatingInfos, $isTrollUpgradingSinceLastTime);
    	$updateData = $troll->getDonnees();
    	$updateData['date_compilation'] = $updatingInfos['date_compilation'];
    	$updateData['nom'] = $infosTroll['nom'];
    	$updateData['race'] = $infosTroll['race'];
    	$updateData['numero_guilde'] = $infosTroll['numero_guilde'];
    	$updateData['guilde'] = $infosTroll['guilde'];
    		
	    updateTrollInDB($updateData);
    	return $updateData;
    }
	return $infosTroll;
	
}

function getPublicInfos($numero, $pathToPublicFiles) {
	$publicInfos = array();
	$handle = fopen($pathToPublicFiles.'/Public_Trolls.txt', "r");
	if ($handle) {
		while (!feof($handle)) {
   			$line = fgets($handle);
   			
    		$trollInfosArray = explode(';', $line);
    		if ($numero == intval($trollInfosArray[0])) {
    			$publicInfos['nom'] = $trollInfosArray[1];
    			$publicInfos['race'] = $trollInfosArray[2];
    			$publicInfos['niveau_actuel'] = intval($trollInfosArray[3]);
    			$publicInfos['numero_guilde'] = intval($trollInfosArray[6]);
    			fclose($handle);
	   			break;
     		}
		}
	}
	
	if (!array_key_exists('nom', $publicInfos)) {
		trigger_error('Troll n°'.$numero.' does not exist anymore');
		deleteTrollInDB($numero);
		return null;
	}
   	else {	
   		if (1 == $publicInfos['numero_guilde']) {
   			$publicInfos['guilde'] = '-';
   		}
   		else {
   			$handle = @fopen($pathToPublicFiles.'/Public_Guildes.txt', "r");
			if ($handle) {
	  			while (!feof($handle)) {
   					$line = fgets($handle);
   					$trollInfosArray = explode(';', $line);
   					if ($publicInfos['numero_guilde'] == intval($trollInfosArray[0])) {
	     				$publicInfos['guilde'] = $trollInfosArray[1];
     					fclose($handle);
     					break;
   	 				}
   				}
			}
   		}
   	}
   	
   	return $publicInfos;
}

function getAgeAnalyse($referenceTimeStamp, $dateCompilation) {
	$dateDuJour = explode('-', date('Y-m-d', $referenceTimeStamp));
	$dateAnalyse = explode('-', substr($dateCompilation, 0, 10));
	$timeDateDuJour = mktime(0, 0, 0, $dateDuJour[1], $dateDuJour[2], $dateDuJour[0]);
	$timeAnalyse = mktime(0, 0, 0, $dateAnalyse[1], $dateAnalyse[2], $dateAnalyse[0]);
	
	$valeurAge = round(($timeDateDuJour - $timeAnalyse) / 3600 / 24);
	
	if ($valeurAge == 0) {
		return 'analyse du jour';
	}
	elseif ($valeurAge == 1) {
		return 'analyse de la veille';
	} 
	else {
		return $valeurAge . ' jours';
	} 
}

?>
<?
require_once 'Parser.class.php';
require_once 'Troll.class.php';
require_once 'database.inc.php';

function debugArray($array) {
	error_log(print_r($array, TRUE));
}

function getTimeStampFromTrollDate($dateCompilation) {
	$date = explode('-', trim(substr($dateCompilation, 0, 10)));
    $time = explode(':', trim(substr($dateCompilation,11,strlen($dateCompilation))));
    return mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
}

function isDataOk($infosTroll) {
	$isDataOk = TRUE;
	foreach($infosTroll AS $key => $value) {
		if ($value == null) {
			trigger_error('isDataOk(): '.$key.' is null, AA creation is aborted');
			$isDataOk = FALSE;
		}
	}
	return $isDataOk;
}

function processAnalysis($analysis, $pathToPublicFiles) {
	$parser = new Parser($analysis, $pathToPublicFiles);
	$parser->parseData();
	$infosTroll = $parser->getInfosTroll();
	
	if (isDataOk($infosTroll)) {
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
	    	}
    		else {
	    		$referenceInfos = $infosTroll;
    			$updatingInfos = $infosFromDB;
    		}
    		$referenceInfos['sortileges'] = '';
    		$troll = new Troll($referenceInfos);
    		$troll->update($updatingInfos);
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
	else {
		return null;
	}
}
?>
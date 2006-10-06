<?
require_once 'Parser.php';
require_once 'Troll.php';
require_once 'database.inc.php';

function debugArray($array) {
	error_log(print_r($array, TRUE));
}

function getTimeStampFromTrollDate($dateCompilation) {
	$date = explode('-', trim(substr($dateCompilation, 0, 10)));
    $time = explode(':', trim(substr($dateCompilation,11,strlen($dateCompilation))));
    return mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
}

function processAnalysis($analysis) {
	$parser = new Parser($analysis);
	$parser->parseData();
	$infosTroll = $parser->getInfosTroll();
	
    $infosFromDB = getInfosTrollFromDB($infosTroll['numero']);
    if ($infosFromDB == FALSE) {
    	createOrUpdateTrollInDB($infosTroll, 'getQueryForCreate');
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
    	$troll = new Troll($referenceInfos);
    	$troll->update($updatingInfos);
    	$updateData = $troll->getDonnees();
    	$updateData['date_compilation'] = $updatingInfos['date_compilation'];
    	createOrUpdateTrollInDB($updateData, 'getQueryForUpdate');
    	return $updateData;
    }
	return $infosTroll;
}

?>
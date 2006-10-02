<?
require_once('variables.inc.php');

function isNotEmptyInputArray($inputArray) {
	$isNotEmptyInputArray = FALSE;
	if (!is_array($inputArray)) {
		trigger_error('error: input data is not an array');
	}
	elseif (empty($inputArray)) {
		trigger_error('error: input data array is empty');
	}
	else {
		$isNotEmptyInputArray = TRUE;
	}
	return $isNotEmptyInputArray;
}

function getInfosTrollFromDB($numero) {
	connectToDB();
	$query = 'SELECT * FROM mountyhall_troll WHERE mountyhall_troll.numero = ' . $numero . ';';
	$result = mysql_query($query);
	$nombreDeReponses = mysql_num_rows($result); 
	if ($nombreDeReponses == 0) {
		$infos = FALSE;
	}
	elseif ($nombreDeReponses != 1) {
		trigger_error('error[getInfosTrollFromDB()]: too many responses for query "' . $query . '"');
	}
	else {
		$infos = mysql_fetch_array($result);
	}
	disconnectFromDB();
	return $infos;
}

function createOrUpdateTrollInDB($infosTroll, $getQueryFunctionName) {
	if (isNotEmptyInputArray($infosTroll)) {
		connectToDB();
		$result = mysql_query($getQueryFunctionName($infosTroll));
		disconnectFromDB();
	}
}

function getQueryForCreate($infosTroll) {
	$createTrollQuery = "INSERT INTO `mountyhall_troll` (`numero`, `nom`, `race`, `niveau`, `vie`, `attaque`, ".
		"`esquive`, `degats`, `regeneration`, `armure`, `vue`, `date_compilation`, `sortileges`) VALUES (".
		"{$infosTroll['numero']},'{$infosTroll['nom']}','{$infosTroll['race']}',{$infosTroll['niveau']},".
		"'{$infosTroll['vie']}','{$infosTroll['attaque']}','{$infosTroll['esquive']}',".
		"'{$infosTroll['degats']}','{$infosTroll['regeneration']}','{$infosTroll['armure']}',".
		"'{$infosTroll['vue']}',CURDATE(),'{$infosTroll['sortileges']}')";
		error_log('new: ' . $createTrollQuery);
	return $createTrollQuery;
}

function getQueryForUpdate($infosTroll) {
	$updateFieldsArray = array();
	$updateTrollQuery = "UPDATE `mountyhall_troll` SET ";
	foreach($infosTroll AS $clefChamp => $valeurChamp) {
		if ('numero' != $clefChamp && 'niveau' != $clefChamp) {
			$valeurChamp = "'$valeurChamp'";
		}
		$updateFieldsArray[] = "`$clefChamp`=$valeurChamp";
		
	}
	$updateTrollQuery .= implode(",", $updateFieldsArray) . ",`date_compilation`=CURDATE() WHERE ".
		"`numero`={$infosTroll['numero']}";
	return $updateTrollQuery;
}

function getQueryForDelete($trollId) {
	return 'DELETE FROM `mountyhall_troll` WHERE `numero` = '.$trollId;
}

function createTrollInDB($infosTroll) {
	createOrUpdateTrollInDB($infosTroll, 'getQueryForCreate');
}

function updateTrollInDB($infosTroll) {
	createOrUpdateTrollInDB($infosTroll, 'getQueryForUpdate');
}

function deleteTrollInDB($trollId) {
	connectToDB();
	$result = mysql_query(getQueryForDelete($trollId));
	disconnectFromDB();
}

function connectToDB() {
	@mysql_connect( _HOST_ , _USER_ , _PWD_ ) or trigger_error('error[connectToDB()]: unable to connect to database');
 	@mysql_select_db( _DB_ ) or trigger_error('error[connectToDB()]: unable to select a database');
}

function disconnectFromDB() {
	@mysql_close();
}
?>
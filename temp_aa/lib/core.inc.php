<?
require_once('variables.inc.php');

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
	if (!is_array($infosTroll)) {
		trigger_error('error[createOrUpdateTrollInDB()]: input data not an array');
	}
	elseif (empty($infosTroll)) {
		trigger_error('error[createOrUpdateTrollInDB()]: input array data is empty');
	}
	else {
		connectToDB();
		$result = mysql_query($getQueryFunctionName($infosTroll));
		disconnectFromDB();
	}
}

function getQueryForCreate($infosTroll) {
	$createTrollQuery = 'INSERT INTO `mountyhall_troll` (`numero`, `nom`, `race`, `vie`, `attaque`, `esquive`,'.
		' `degats`, `regeneration`, `vue`, `armure`, `date_compilation`, `sortileges`)'.
		' VALUES (\''.$infosTroll['numero'].'\',\''.$infosTroll['nom'].'\',\''.$infosTroll['race'].
		'\',\''.$infosTroll['vie'].'\',\''.$infosTroll['attaque'].'\',\''.$infosTroll['esquive'].
		'\',\''.$infosTroll['degats'].'\',\''.$infosTroll['regeneration'].'\',\''.$infosTroll['vue'].
		'\',\''.$infosTroll['armure'].'\',\''.$infosTroll['date_compilation'].'\',\''.$infosTroll['sortileges'].'\')';
	return $createTrollQuery;
}

function getQueryForUpdate($infosTroll) {
	$updateFieldsArray = array();
	$updateTrollQuery = 'UPDATE `mountyhall_troll` SET ';
	foreach($infosTroll AS $clefChamp => $valeurChamp) {
		$updateFieldsArray[] = '`' . $clefChamp . '`=\'' . $valeurChamp . '\'';
	}
	$updateTrollQuery .= implode(',', $updateFieldsArray) . ' WHERE `numero` = \'' . $infosTroll['numero']. '\'';
	return $updateTrollQuery;
}

function createTrollInDB($infosTroll) {
	createOrUpdateTrollInDB($infosTroll, 'getQueryForCreate');
}

function updateTrollInDB($infosTroll) {
	createOrUpdateTrollInDB($infosTroll, 'getQueryForUpdate');
}

function deleteTrollInDB($trollId) {
	connectToDB();
	$query = 'DELETE FROM `mountyhall_troll` WHERE `numero` = \''.$trollId.'\'';
	$result = mysql_query($query);
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
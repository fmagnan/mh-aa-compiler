<?
require_once dirname(__FILE__).'/../etc/config.inc.php';
require_once dirname(__FILE__).'/../etc/constants.inc.php';

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

function getQueryForAllTrollsInOrder($fieldSort, $typeSort) {
	return 'SELECT * FROM mountyhall_troll WHERE 1=1 ORDER BY '.$fieldSort.' '.$typeSort; 
}

function getSpellsList($trollNumber) {
	$selectQuery = "SELECT `sortileges` FROM mountyhall_troll WHERE `numero`=".$trollNumber;
	connectToDB();
	$resourceId = mysql_query($selectQuery);
	if (FALSE != $resourceId) {
		$row = mysql_fetch_assoc($resourceId);
		$spellsList = $row['sortileges'];
	}
	disconnectFromDB();
	return $spellsList;
}

function addKnownSpell($trollNumber, $spell) {
	$spellsList = getSpellsList($trollNumber);
	if ('' == $spellsList) {
		$spellsList .= $spell;
	}
	else {
		$spellsArray = explode(';', $spellsList);	
		if (!in_array($spell, $spellsArray)) {
			$spellsArray[] = $spell;
		}
		$spellsList = implode(';', $spellsArray);
	}
	
	$addSpellQuery = "UPDATE `mountyhall_troll` SET `sortileges`='".$spellsList."' WHERE `numero`=".$trollNumber;
	
	connectToDB();
	mysql_query($addSpellQuery);
	disconnectFromDB();
}
	
function deleteSpell($trollNumber, $spell) {
	global $SORTILEGES;
	
	if (!array_key_exists($spell, $SORTILEGES)) {
		trigger_error('Unknown spell ' . $spell);	
		return null;
	}	

	$spellsList = getSpellsList($trollNumber);
	$spellsArray = explode(';', $spellsList);
	
	$restrictedSpellsArray = array();
	foreach ($spellsArray AS $knownSpell) {
		if ($spell != $knownSpell) {
			$restrictedSpellsArray[] = $knownSpell;
		}
	}	

	$restrictedSpellsList = implode(';', $restrictedSpellsArray);
	$deleteQuery = "UPDATE `mountyhall_troll` SET `sortileges`='".$restrictedSpellsList."' WHERE `numero`=".$trollNumber;
	connectToDB();
	$resourceId = mysql_query($deleteQuery);
	disconnectFromDB();
}

function getTousLesTrolls($fieldSort, $typeSort) {
	$tousLesTrolls = array();
	connectToDB();
	$query = getQueryForAllTrollsInOrder($fieldSort, $typeSort);
	$result = mysql_query($query);
	if ($result != FALSE) {
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$tousLesTrolls[] = $row;
		}
	}
	disconnectFromDB();
	return $tousLesTrolls;
}

function getInfosTrollFromDB($numero) {
	if (!is_int($numero)) {
		trigger_error('error: input data needs a valid troll number');
	}
	else {
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
	}
	return $infos;
}

function createOrUpdateTrollInDB($infosTroll, $getQueryFunctionName) {
	if (isNotEmptyInputArray($infosTroll)) {
		$link = connectToDB();
		$query = $getQueryFunctionName($infosTroll);
		$result = mysql_query($query);
		disconnectFromDB();
	}
	
	return $result;
}

function addslashesForArray($inputArray) {
	$escapedArray = array();
	foreach ($inputArray AS $key => $value) {
		$escapedArray[$key] = addslashes($value);
	}
	return $escapedArray;
}

function getQueryForCreate($infosTroll) {
	$data = addslashesForArray($infosTroll);

	$sortileges = '';
	if (array_key_exists('sortileges', $data)) {
		$sortileges = $data['sortileges'];
	}

	$createTrollQuery = "INSERT INTO `mountyhall_troll` (`numero`, `nom`, `race`, `numero_guilde`, `guilde`, ".
		"`niveau`, `niveau_actuel`, `vie`, `attaque`, `esquive`, `degats`, `regeneration`, `armure`, `vue`, ".
		"`date_compilation`, `sortileges`) VALUES ".
		"({$data['numero']},'{$data['nom']}','{$data['race']}',{$data['numero_guilde']},".
		"'{$data['guilde']}',{$data['niveau']},{$data['niveau_actuel']},".
		"'{$data['vie']}','{$data['attaque']}','{$data['esquive']}',".
		"'{$data['degats']}','{$data['regeneration']}','{$data['armure']}',".
		"'{$data['vue']}','{$data['date_compilation']}','$sortileges')";
	return $createTrollQuery;
}

function getQueryForUpdate($infosTroll) {
	$data = addslashesForArray($infosTroll);
	$updateFieldsArray = array();
	$updateTrollQuery = "UPDATE `mountyhall_troll` SET ";
	foreach($data AS $clefChamp => $valeurChamp) {
		if ('numero' != $clefChamp && 'niveau' != $clefChamp) {
			$valeurChamp = "'$valeurChamp'";
		}
		$updateFieldsArray[] = "`$clefChamp`=$valeurChamp";
	}
	$updateTrollQuery .= implode(",", $updateFieldsArray) . " WHERE `numero`={$infosTroll['numero']}";
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

function connectToDB($host='', $user='', $password='', $database='') {
	if ($host == '') {
		$host = _HOST_;
	}
	if ($user == '') {
		$user = _USER_;
	}
	if ($password == '') {
		$password = _PWD_;
	}
	if ($database == '') {
		$database = _DB_;
	}
	
	$link = mysql_connect($host, $user, $password) or trigger_error('error[connectToDB()]: unable to connect to database');
 	@mysql_select_db($database) or trigger_error('error[connectToDB()]: unable to select a database');
 	return $link;
}

function disconnectFromDB() {
	@mysql_close();
}

?>
<?
require_once('variables.inc.php');

function getInfosTrollFromDB($numero) {
	connexion();
	$query = 'SELECT * FROM mountyhall_troll WHERE mountyhall_troll.numero = ' . $numero . ';';
	$result = query($query);
	$nombreDeReponses = mysql_num_rows($result); 
	if ($nombreDeReponses == 0) {
		$infos = FALSE;
	}
	elseif ($nombreDeReponses != 1) {
		trigger_error('error : too many responses for query "' . $query . '"');
	}
	else {
		$infos = mysql_fetch_array($result);
	}
	deconnexion();
	return $infos;
}

function createTrollInDB($infosTroll) {
	if (!is_array($infosTroll)) {
		trigger_error('error: input data not an array');
	}
	elseif (empty($infosTroll)) {
		trigger_error('error: input array data is empty');
	}
	else {
		connexion();
		$query = 'INSERT INTO `mountyhall_troll` (`numero`, `nom`, `race`, `vie`, `attaque`, `esquive`, `degats`, `regeneration`, `vue`, `armure`, `date_compilation`, `sortileges`)'.
				' VALUES (\''.$infosTroll['numero'].
				'\',\''.$infosTroll['nom'].
				'\',\''.$infosTroll['race'].
				'\',\''.$infosTroll['vie'].
				'\',\''.$infosTroll['attaque'].
				'\',\''.$infosTroll['esquive'].
				'\',\''.$infosTroll['degats'].
				'\',\''.$infosTroll['regeneration'].
				'\',\''.$infosTroll['vue'].
				'\',\''.$infosTroll['armure'].
				'\',\''.$infosTroll['date_compilation'].
				'\',\''.$infosTroll['sortileges'].'\')';
		$result = query($query);
		deconnexion();
	}
}

function connexion() {
	@mysql_connect( _HOST_ , _USER_ , _PWD_ ) or trigger_error( 'Connexion au serveur de données impossible' ) ;
 
	@mysql_select_db( _DB_ ) or trigger_error( 'Sélection de la base de donnée impossible' ) ;
}

function deconnexion() {
	@mysql_close();
}

function query($requete) {
	if($resultat = mysql_query( $requete )) {
		return $resultat ;
	}
	else {
 		trigger_error('Erreur dans la requête : $requete<br />' . mysql_error());
	}
}

?>
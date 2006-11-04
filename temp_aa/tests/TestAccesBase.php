<?php
	require_once dirname(__FILE__).'/../lib/database.inc.php';
	require_once 'functionsForTests.inc.php';

	class TestAccesBase extends UnitTestCase {
		
		var $cradoc = array(
			'numero' => 1,
			'nom' => 'Cradoc',
			'race' => 'Inconnue',
			'numero_guilde' => 1,
			'guilde' => '-',
			'vie' => 'entre 95 et 115',
			'niveau' => 28,
			'niveau_actuel' => 29,
			'attaque' => 'entre 17 et 19',
			'esquive' => 'entre 10 et 12',
			'degats' => 'entre 12 et 14',
			'regeneration' => 'entre 3 et 4',
			'armure' => 'entre 12 et 14',
			'vue' => 'entre 2 et 4',
			'date_compilation' => '2006-06-25 14:09:23',  
			'sortileges' => '',
		);
		
		var $ninja = array(
			'numero' => 10368,
    		'nom' => "Ninja R'din",
    		'race' => "Skrim",
    		'numero_guilde' => 1758,
    		'guilde' => "Le Royaume Troll d'Aubrane",
    		'niveau' => 29,
    		'niveau_actuel' => 29,
    		'vie' => "entre 85 et 105",
    		'attaque' => "entre 17 et 19",
    		'esquive' => "entre 12 et 14",
    		'degats' => "entre 14 et 16",
    		'regeneration' => "entre 6 et 7",
    		'armure' => "entre 8 et 10",
    		'vue' => "entre 4 et 6",
    		'date_compilation' => "2006-10-12 11:57:40",
		);
		
		function setUp() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
		}
		
		function tearDown() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
		}
		
		function test_ecritureTrollEnBaseSansTableau() {
			$result = createTrollInDB('donnee non valide');
			$this->assertError('error: input data is not an array');
		} 
		
		function test_ecritureTrollEnBaseAvecTableauVide() {
			$result = createTrollInDB(array());
			$this->assertError('error: input data array is empty');
		}
		
		function test_ecritureTrollEnBase() {
			$createQuery = getQueryForCreate($this->cradoc);
			$referenceQuery = "INSERT INTO `mountyhall_troll` (`numero`, `nom`, `race`, `numero_guilde`,".
				" `guilde`, `niveau`, `niveau_actuel`, `vie`, `attaque`, `esquive`, `degats`, `regeneration`,".
				" `armure`, `vue`, `date_compilation`, `sortileges`) VALUES ".
				"(1,'Cradoc','Inconnue',1,'-',28,29,'entre 95 et 115','entre 17 et 19','entre 10 et 12',".
				"'entre 12 et 14','entre 3 et 4','entre 12 et 14','entre 2 et 4','2006-06-25 14:09:23','')";
			$this->assertEqual($referenceQuery, $createQuery);
		}
		
		function test_ecritureTrollAvecApostrophesEnBase() {
			$createQuery = getQueryForCreate($this->ninja);
			$referenceQuery = "INSERT INTO `mountyhall_troll` (`numero`, `nom`, `race`, `numero_guilde`, `guilde`,".
				" `niveau`, `niveau_actuel`, `vie`, `attaque`, `esquive`, `degats`, `regeneration`, `armure`,".
				" `vue`, `date_compilation`, `sortileges`) VALUES ".
				"(10368,'Ninja R\'din','Skrim',1758,'Le Royaume Troll d\'Aubrane',29,29,'entre 85 et 105',".
				"'entre 17 et 19','entre 12 et 14','entre 14 et 16','entre 6 et 7','entre 8 et 10','entre 4 et 6',".
				"'2006-10-12 11:57:40','')";
			$this->assertEqual($referenceQuery, $createQuery);
		}
		
		function test_suppressionTrollEnBase() {
			$deleteQuery = getQueryForDelete(1);
			$this->assertEqual("DELETE FROM `mountyhall_troll` WHERE `numero` = 1", $deleteQuery);
		}
		
		function test_ModificationTrollEnBaseSansTableau() {
			updateTrollInDB('donnée non valide');
			$this->assertError('error: input data is not an array');
		}
		
		function test_ModificationTrollEnBaseAvecTableauVide() {
			updateTrollInDB(array());
			$this->assertError('error: input data array is empty');
		}
		
		function test_ModificationTrollEnBase() {
			$donneesDeModification = array(
				'numero'=> 1,
				'niveau' => 29,
				'degats' => 'entre 13 et 15',
				'regeneration' => '5',
				'date_compilation' => '2006-10-02 08:52:45',
			);
			$updateQuery = getQueryForUpdate($donneesDeModification);
			$this->assertEqual(
				"UPDATE `mountyhall_troll` SET `numero`=1,`niveau`=29,`degats`='entre 13 et 15',`regeneration`='5',".
				"`date_compilation`='2006-10-02 08:52:45' WHERE `numero`=1", $updateQuery);
		}
		
		function test_ModificationTrollEnBaseAvecApostrophe() {
			$donneesDeModification = array(
				'numero'=> 1,
				'niveau' => 29,
				'guilde' => "La guil'de des apo'strophes",
			);
			$updateQuery = getQueryForUpdate($donneesDeModification);
			$this->assertEqual(
				"UPDATE `mountyhall_troll` SET `numero`=1,`niveau`=29,".
				"`guilde`='La guil\'de des apo\'strophes' WHERE `numero`=1", $updateQuery);
		}
		
		function test_recuperationInfosTrollEnBaseSansNumero() {
			$infosTrolls = getInfosTrollFromDB('');
			$this->assertError('error: input data needs a valid troll number');
		}
		
		function test_recuperationInfosTrollEnBase() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			$infosTrolls = getInfosTrollFromDB(1);
			$array_diff_assoc = array_diff_assoc($this->cradoc, $infosTrolls);
			$this->assertTrue(empty($array_diff_assoc));
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
		}
		
		function test_recupereTousLesTrolls() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			$tousLesTrolls = getTousLesTrolls('numero', 'ASC');
			$this->assertEqual(2, count($tousLesTrolls));
			$this->assertEqual($this->cradoc, $tousLesTrolls[0]);
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
		}
		
		function test_recupereTousLesTrollsDansLOrdre() {
			$referenceQuery = "SELECT * FROM mountyhall_troll WHERE 1=1 ORDER BY numero ASC";
			$query = getQueryForAllTrollsInOrder('numero', 'ASC');
			$this->assertEqual($referenceQuery, $query);
		}
		
		function test_recupereTousLesTrollsDansLOrdreDecroissantDesGuildes() {
			$referenceQuery = "SELECT * FROM mountyhall_troll WHERE 1=1 ORDER BY guilde DESC";
			$query = getQueryForAllTrollsInOrder('guilde', 'DESC');
			$this->assertEqual($referenceQuery, $query);
		}
		
		function test_ajoutePremierSortilege() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('', $listeDeSorts);
			addKnownSpell(2097, 'AA');
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('AA', $listeDeSorts);
		}
		
		function test_ajoutePlusieursSortileges() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			addKnownSpell(2097, 'AA');
			addKnownSpell(2097, 'AE');
			addKnownSpell(2097, 'VA');
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('AA;AE;VA', $listeDeSorts);
		}
		
		function test_ajouteSortilegeDejaConnu() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			addKnownSpell(2097, 'AA');
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('AA', $listeDeSorts);
			addKnownSpell(2097, 'AA');
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('AA', $listeDeSorts);
		}
		
		function test_supprimeSortilegeAvecErreur() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			addKnownSpell(2097, 'AA');
			deleteSpell(2097, 'Sort inconnu');
			$this->assertError('Unknown spell Sort inconnu');
		}
		
		function test_supprimeSortilegeUnique() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			addKnownSpell(2097, 'AA');
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('AA', $listeDeSorts);
			deleteSpell(2097, 'AA');
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('', $listeDeSorts);
		}
		
		function test_supprimeSortilegeParmiPlusieurs() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			addKnownSpell(2097, 'AA');
			addKnownSpell(2097, 'AE');
			addKnownSpell(2097, 'Sacro');
			deleteSpell(2097, 'AA');
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('AE;Sacro', $listeDeSorts);
		}
		
		function test_supprimeSortilegeDansListeVide() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			deleteSpell(2097, 'AA');
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('', $listeDeSorts);
		}
		
		function test_ajouteSortilegesAvecApostrophes() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			addKnownSpell(2097, 'AA');
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('AA', $listeDeSorts);
			addKnownSpell(2097, 'AdE');
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('AA;AdE', $listeDeSorts);
			addKnownSpell(2097, 'Sacro');
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual('AA;AdE;Sacro', $listeDeSorts);
		}
		
		function test_supprimeSortilegeAvecApostrophe() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			$AA = 'AA';
			$AdE = 'AdE';
			$AdA = 'AdA';
			addKnownSpell(2097, $AA);
			addKnownSpell(2097, $AdE);
			addKnownSpell(2097, $AdA);
			deleteSpell(2097, $AdE);
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual($AA.';'.$AdA, $listeDeSorts);
		}
		
		function test_ajouteSortAvecApostropheSeul() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			$AdE = 'AdE';
			addKnownSpell(2097, $AdE);
			$listeDeSorts = getSpellsList(2097);
			$this->assertEqual($AdE, $listeDeSorts);
		}
		
	}
?>

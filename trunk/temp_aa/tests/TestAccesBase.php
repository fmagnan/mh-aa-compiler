<?php
	include dirname(__FILE__).'/../lib/database.inc.php';
	require_once 'functionsForTests.inc.php';

	class TestAccesBase extends UnitTestCase {
		
		var $grobide = array(
			'numero' => 31629,
			'nom' => 'GROBIDE',
			'race' => 'Inconnue',
			'numero_guilde' => 1,
			'guilde' => '-',
			'vie' => 'entre 95 et 115',
			'niveau' => 28,
			'attaque' => 'entre 17 et 19',
			'esquive' => 'entre 10 et 12',
			'degats' => 'entre 12 et 14',
			'regeneration' => 'entre 3 et 4',
			'armure' => 'entre 12 et 14',
			'vue' => 'entre 2 et 4',
			'date_compilation' => '2006-06-25 14:09:23',  
			'sortileges' => '',
		);
		
		function setUp() {
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
			$createQuery = getQueryForCreate($this->grobide);
			$referenceQuery = "INSERT INTO `mountyhall_troll` (`numero`, `nom`, `race`, `numero_guilde`, `guilde`, `niveau`, `vie`, `attaque`, ".
				"`esquive`, `degats`, `regeneration`, `armure`, `vue`, `date_compilation`, `sortileges`) VALUES (".
				"31629,'GROBIDE','Inconnue',1,'-',28,'entre 95 et 115','entre 17 et 19','entre 10 et 12','entre 12 et 14',".
				"'entre 3 et 4','entre 12 et 14','entre 2 et 4','2006-06-25 14:09:23','')";
			$this->assertEqual($referenceQuery, $createQuery);
		}
		
		function test_suppressionTrollEnBase() {
			$deleteQuery = getQueryForDelete(31629);
			$this->assertEqual("DELETE FROM `mountyhall_troll` WHERE `numero` = 31629", $deleteQuery);
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
				'numero'=> 31629,
				'niveau' => 29,
				'degats' => 'entre 13 et 15',
				'regeneration' => '5',
				'date_compilation' => '2006-10-02 08:52:45',
			);
			$updateQuery = getQueryForUpdate($donneesDeModification);
			$this->assertEqual(
				"UPDATE `mountyhall_troll` SET `numero`=31629,`niveau`=29,`degats`='entre 13 et 15',`regeneration`='5',".
				"`date_compilation`='2006-10-02 08:52:45' WHERE `numero`=31629", $updateQuery);
		}
		
		function test_recuperationInfosTrollEnBaseSansNumero() {
			$infosTrolls = getInfosTrollFromDB('');
			$this->assertError('error: input data needs a valid troll number');
		}
		
		function test_recuperationInfosTrollEnBase() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			$infosTrolls = getInfosTrollFromDB(31629);
			$array_diff_assoc = array_diff_assoc($this->grobide, $infosTrolls);
			$this->assertTrue(empty($array_diff_assoc));
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
		}
		
		function test_recupereTousLesTrolls() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
			$tousLesTrolls = getTousLesTrolls();
			$this->assertEqual(1, count($tousLesTrolls));
			$this->assertEqual($this->grobide, $tousLesTrolls[0]);
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
		}
	}
?>

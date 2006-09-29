<?php
	include dirname(__FILE__).'/../lib/core.inc.php';

	class TestAccesBase extends UnitTestCase {
		
		function test_ecritureTrollEnBaseSansTableau() {
			$result = createTrollInDB('donnee non valide');
			$this->assertError('error: input data is not an array');
		} 
		
		function test_ecritureTrollEnBaseAvecTableauVide() {
			$result = createTrollInDB(array());
			$this->assertError('error: input data array is empty');
		}
		
		function test_ecritureTrollEnBase() {
			$grobide = array(
				'numero' => '31629',
				'nom' => 'GROBIDE',
				'race' => 'Skrim',
				'vie' => 'entre 95 et 115',
				'attaque' => 'entre 17 et 19',
				'esquive' => 'entre 10 et 12',
				'degats' => 'entre 12 et 14',
				'regeneration' => 'entre 3 et 4',
				'vue' => 'entre 2 et 4',
				'armure' => 'entre 12 et 14',
				'date_compilation' => '2006-06-25',  
				'sortileges' => '',
			);
			$createQuery = getQueryForCreate($grobide);
			$this->assertEqual(
				"INSERT INTO `mountyhall_troll` (`numero`, `nom`, `race`, `vie`, `attaque`, `esquive`,".
				"`degats`, `regeneration`, `vue`, `armure`, `date_compilation`, `sortileges`) VALUES (".
				"'31629','GROBIDE','Skrim','entre 95 et 115','entre 17 et 19','entre 10 et 12','entre 12 et 14',".
				"'entre 3 et 4','entre 2 et 4','entre 12 et 14',CURDATE(),'')", $createQuery);
		}
		
		function test_suppressionTrollEnBase() {
			$deleteQuery = getQueryForDelete('31629');
			$this->assertEqual("DELETE FROM `mountyhall_troll` WHERE `numero` = '31629'", $deleteQuery);
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
			$donneesDeModification = array('numero'=> '31629', 'degats' => 'entre 13 et 15','regeneration' => '5');
			$updateQuery = getQueryForUpdate($donneesDeModification);
			$this->assertEqual(
				"UPDATE `mountyhall_troll` SET `numero`='31629',`degats`='entre 13 et 15',`regeneration`='5',".
				"`date_compilation`=CURDATE() WHERE `numero`='31629'", $updateQuery);
		}
	}
?>

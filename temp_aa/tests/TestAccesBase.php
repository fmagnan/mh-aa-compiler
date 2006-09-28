<?php
	include dirname(__FILE__).'/../lib/core.inc.php';

	class TestAccesBase extends UnitTestCase {
		
		var $donneesDeTest = array(
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
		
		function getAbsolutePathForFile($fileName) {
			return dirname(__FILE__). '/' . $fileName;
		}
		
		function getTemporaryMySQLDumpFile() {
			return $this->getAbsolutePathForFile('temporary_MySQL_dump_file.sql');
		}

		function getMySQLCommandLine() {
			return 'mysql -u '._USER_.' -p'._PWD_.' -h '._HOST_.' '._DB_.' < ';
		}
		
		function getMySQLTemporaryDump() {
			return 'mysqldump -u '._USER_.' -p'._PWD_.' -h '._HOST_.' -c -t '._DB_.' > '.$this->getTemporaryMySQLDumpFile();
		}
		
		function setUp() {
			shell_exec($this->getMySQLCommandLine() . $this->getAbsolutePathForFile('donnees_initiales.sql'));
		}
		
		function tearDown() {
			shell_exec($this->getMySQLCommandLine() . $this->getAbsolutePathForFile('vidange_donnees.sql'));
		}
		
		function test_ecritureTrollEnBaseSansTableau() {
			$result = createTrollInDB('donnee non valide');
			$this->assertError('error[createOrUpdateTrollInDB()]: input data not an array');
		} 
		
		function test_ecritureTrollEnBaseAvecTableauVide() {
			$result = createTrollInDB(array());
			$this->assertError('error[createOrUpdateTrollInDB()]: input array data is empty');
		}
		
		function test_ecritureTrollEnBase() {
			createTrollInDB($this->donneesDeTest);
			shell_exec($this->getMySQLTemporaryDump());
			$diffCommandLine = 'diff '.$this->getAbsolutePathForFile('donnees_apres_insertion.sql').' '.$this->getTemporaryMySQLDumpFile(); 
			$output = shell_exec($diffCommandLine);
			$this->assertEqual('', $output);
			shell_exec('rm ' . $this->getTemporaryMySQLDumpFile());
		}
		
		function test_suppressionTrollEnBaseAvecIdentifiantInconnu() {
			deleteTrollInDB('identifiant inconnu');
			shell_exec($this->getMySQLTemporaryDump());
			$diffCommandLine = 'diff '.$this->getAbsolutePathForFile('donnees_initiales.sql').' '.$this->getTemporaryMySQLDumpFile(); 
			$output = shell_exec($diffCommandLine);
			$this->assertEqual('', $output);
			shell_exec('rm ' . $this->getTemporaryMySQLDumpFile());
		}
		
		function test_suppressionTrollEnBase() {
			deleteTrollInDB('29201');
			shell_exec($this->getMySQLTemporaryDump());
			$diffCommandLine = 'diff '.$this->getAbsolutePathForFile('donnees_apres_suppression.sql').' '.$this->getTemporaryMySQLDumpFile(); 
			$output = shell_exec($diffCommandLine);
			$this->assertEqual('', $output);
			shell_exec('rm ' . $this->getTemporaryMySQLDumpFile());
		}
		
		function test_ModificationTrollEnBaseSansTableau() {
			updateTrollInDB('donnée non valide');
			$this->assertError('error[createOrUpdateTrollInDB()]: input data not an array');
		}
		
		function test_ModificationTrollEnBaseAvecTableauVide() {
			updateTrollInDB(array());
			$this->assertError('error[createOrUpdateTrollInDB()]: input array data is empty');
		}
		
		function test_ModificationTrollEnBase() {
			$donneesDeModification = array('numero'=> '29201', 'degats' => 'entre 13 et 15','regeneration' => '5');
			updateTrollInDB($donneesDeModification);
			shell_exec($this->getMySQLTemporaryDump());
			$diffCommandLine = 'diff '.$this->getAbsolutePathForFile('donnees_apres_modification.sql').' '.$this->getTemporaryMySQLDumpFile(); 
			$output = shell_exec($diffCommandLine);
			$this->assertEqual('', $output);
			shell_exec('rm ' . $this->getTemporaryMySQLDumpFile());
		}
	}
?>

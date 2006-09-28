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
			$this->assertError('error: input data not an array');
		} 
		
		function test_ecritureTrollEnBaseAvecTableauVide() {
			$result = createTrollInDB(array());
			$this->assertError('error: input array data is empty');
		}
		
		function test_ecritureTrollEnBaseNormale() {
			$result = createTrollInDB($this->donneesDeTest);
			shell_exec($this->getMySQLTemporaryDump());
			$diffCommandLine = 'diff '.$this->getAbsolutePathForFile('donnees_apres_insertion.sql').' '.$this->getTemporaryMySQLDumpFile(); 
			$output = shell_exec($diffCommandLine);
			$this->assertEqual('', $output);
			shell_exec('rm ' . $this->getTemporaryMySQLDumpFile());
		}
		
	}
	
?>

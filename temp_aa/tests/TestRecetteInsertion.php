<?php
	require_once dirname(__FILE__).'/../lib/Parser.class.php';
	require_once dirname(__FILE__).'/../lib/core.inc.php';
	require_once 'functionsForTests.inc.php';
	
	class TestRecetteInsertion extends UnitTestCase {

		var $currentDirectory;
		var $pathToPublicFiles;
		
		function setUp() {
			$this->currentDirectory = dirname(__FILE__);
    		$this->pathToPublicFiles = $this->currentDirectory . '/../pub';
		}
    	
    	function test_insertionImpossibleCarChampManquant() {
    		$infosTroll = processAnalysis(file_get_contents($this->currentDirectory.'/messageBotAAChampManquantSquatman.txt'), $this->pathToPublicFiles);
    		$this->assertError('isDataOk(): date_compilation is null, AA creation is aborted');
    		$this->assertNull($infosTroll);
    	}
    	
    	function test_insertionImpossibleCarTrollInconnu() {
    		$infosTroll = processAnalysis(file_get_contents($this->currentDirectory.'/messageBotAATrollInconnu.txt'), $this->pathToPublicFiles);
    		$this->assertError('Troll n°1559 does not exist anymore');
    		$this->assertNull($infosTroll);
    	}
    	
    	function test_insertionNouveauTroll() {
    		$referenceInfosTroll = array(
	    		'numero' => 62465,
    			'nom' => 'Squatman',
    			'race' => 'Durakuir',
    			'numero_guilde' => 147,
    			'guilde' => 'X-Trolls',
	    		'niveau' => 22,
    			'vie' => 'entre 120 et 140',
    			'attaque' => 'entre 4 et 6',
    			'esquive' => 'entre 7 et 9',
    			'degats' => 'entre 11 et 13',
    			'regeneration' => 'entre 4 et 5',
    			'armure' => 'entre 16 et 18',
    			'vue' => 'entre 3 et 5',
    			'date_compilation' => '2006-09-30 16:12:05',
    		);
    	
			$infosTroll = processAnalysis(file_get_contents($this->currentDirectory.'/messageBotAASquatman.txt'), $this->pathToPublicFiles);
			
			$array_diff_assoc = array_diff_assoc($referenceInfosTroll, $infosTroll);
    		$this->assertTrue(empty($array_diff_assoc));
    	}
    	
    	function test_insertionNouveauTrollAvecSelectionALaMain() {
    		$referenceInfosTroll = array(
    			'numero' => 30905,
    			'nom' => 'Boohraj Dekrane',
    			'race' => 'Kastar',
    			'numero_guilde' => 2435,
    			'guilde' => 'Les questeurs du Vent',
    			'niveau' => 28,
    			'vie' => 'entre 95 et 115',
    			'attaque' => 'entre 3 et 5',
    			'esquive' => 'entre 12 et 14',
    			'degats' => 'supérieur à 20',
    			'regeneration' => 'entre 4 et 5',
    			'armure' => 'entre 2 et 4',
    			'vue' => 'entre 5 et 7',
    			'date_compilation' => '2006-10-07 18:49:44', 
    		);
    	
			$infosTroll = processAnalysis(file_get_contents($this->currentDirectory.'/messageBotAABoorajEnSelectionALaMain.txt'), $this->pathToPublicFiles);
			
			$array_diff_assoc = array_diff_assoc($referenceInfosTroll, $infosTroll);
    		$this->assertTrue(empty($array_diff_assoc));
    	}
    	
    	function test_miseAJourTrollAvecDatePlusRecente() {
    		$compiledInfosTroll = array(
	    		'numero' => 1,
    			'nom' => 'Cradoc',
    			'race' => 'Skrim',
    			'numero_guilde' => 2299,
    			'guilde' => 'Le Sombre Ragnarok',
	    		'niveau' => 29,
	    		'niveau_actuel' => 29,
    			'vie' => 'entre 110 et 120',
    			'attaque' => 'entre 18 et 20',
    			'esquive' => 'entre 10 et 12',
    			'degats' => 'entre 12 et 13',
    			'regeneration' => 'entre 4 et 5',
    			'armure' => 'entre 12 et 14',
    			'vue' => 'entre 3 et 4',
    			'date_compilation' => '2006-10-03 08:05:26',
    			'sortileges' => '',
    		);
    		
    		shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
    		$infosTroll = processAnalysis(file_get_contents($this->currentDirectory.'/messageBotAA.txt'), $this->pathToPublicFiles);
    		
    		$array_diff = array_diff_assoc($compiledInfosTroll, $infosTroll);
    		$this->assertTrue(empty($array_diff));
    	}
    	
    	function test_miseAJourTrollAvecDatePlusAncienne() {
    		$compiledInfosTroll = array(
	    		'numero' => 1,
    			'nom' => 'Cradoc',
    			'race' => 'Skrim',
    			'numero_guilde' => 2299,
    			'guilde' => 'Le Sombre Ragnarok',
	    		'niveau' => 28,
	    		'niveau_actuel' => 48,
    			'vie' => 'entre 95 et 115',
    			'attaque' => 'entre 17 et 19',
    			'esquive' => '12',
    			'degats' => 'entre 12 et 14',
    			'regeneration' => 'entre 3 et 4',
    			'armure' => 'entre 12 et 14',
    			'vue' => 'entre 3 et 4',
    			'date_compilation' => '2006-06-25 14:09:23',
    			'sortileges' => '',
    		);
    		
    		shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
    		$infosTroll = processAnalysis(file_get_contents($this->currentDirectory.'/messageBotAAAncien.txt'), $this->pathToPublicFiles);
    		
    		$array_diff = array_diff_assoc($compiledInfosTroll, $infosTroll);
    		$this->assertTrue(empty($array_diff));
    	}
    	
    	function test_miseAJourTrollAvecValeurSuperieure() {
    		$compiledInfosTroll = array(
    		 	'numero' => 2097,
    			'nom' => 'Nebuchadnezzar',
    			'race' => 'Kastar',
    			'numero_guilde' => 91,
    			'guilde' => 'In Trollum Veritas',
	    		'niveau' => 32,
	    		'niveau_actuel' => 32,
    			'vie' => 'entre 125 et 140',
    			'attaque' => 'entre 15 et 17',
    			'esquive' => 'entre 6 et 7',
    			'degats' => 'supérieur à 20',
    			'regeneration' => 'entre 5 et 6',
    			'armure' => 'entre 16 et 18',
    			'vue' => 'entre 5 et 6',
    			'date_compilation' => '2006-10-13 18:27:18',
    			'sortileges' => '',
    		);
    		
    		shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
    		$infosTroll = processAnalysis(file_get_contents($this->currentDirectory.'/messageBotAANebuchadnezzar.txt'), $this->pathToPublicFiles);
    		
    		$array_diff = array_diff_assoc($compiledInfosTroll, $infosTroll);
    		$this->assertTrue(empty($array_diff));
    	}
    	
    	function tearDown() {
    		shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));	
    	}
	}
?>
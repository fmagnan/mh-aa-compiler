<?php
	require_once(dirname(__FILE__).'/../lib/Parser.php');
	include dirname(__FILE__).'/../lib/core.inc.php';
	require_once 'functionsForTests.inc.php';
	
	class TestRecetteInsertion extends UnitTestCase {
    	
    	function test_insertionNouveauTroll() {
    		$referenceInfosTroll = array(
	    		'numero' => 62465,
    			'nom' => 'SQUATMAN',
    			'race' => 'Inconnue',
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
    	
			$infosTroll = processAnalysis(file_get_contents(dirname(__FILE__).'/messageBotAASquatman.txt'));
			
			$array_diff_assoc = array_diff_assoc($referenceInfosTroll, $infosTroll);
    		$this->assertTrue(empty($array_diff_assoc));
    		
    		shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
    	}
    	
    	function test_miseAJourTrollAvecDatePlusRecente() {
    		$compiledInfosTroll = array(
	    		'numero' => 31629,
    			'nom' => 'GROBIDE',
    			'race' => 'Skrim',
	    		'niveau' => 29,
    			'vie' => 'entre 110 et 120',
    			'attaque' => 'entre 18 et 20',
    			'esquive' => '10',
    			'degats' => 'entre 12 et 13',
    			'regeneration' => 'entre 4 et 5',
    			'armure' => 'entre 12 et 14',
    			'vue' => 'entre 3 et 4',
    			'date_compilation' => '2006-10-03 08:05:26',
    		);
    		
    		shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
    		$infosTroll = processAnalysis(file_get_contents(dirname(__FILE__).'/messageBotAAGrobide.txt'));
    		
    		$array_diff = array_diff_assoc($compiledInfosTroll, $infosTroll);
    		$this->assertTrue(empty($array_diff));
    		
    		shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
    	}
    	
    	function test_miseAJourTrollAvecDatePlusAncienne() {
    		$compiledInfosTroll = array(
	    		'numero' => 31629,
    			'nom' => 'GROBIDE',
    			'race' => 'Inconnue',
	    		'niveau' => 28,
    			'vie' => 'entre 95 et 115',
    			'attaque' => 'entre 17 et 19',
    			'esquive' => '12',
    			'degats' => 'entre 12 et 14',
    			'regeneration' => 'entre 3 et 4',
    			'armure' => 'entre 12 et 14',
    			'vue' => 'entre 3 et 4',
    			'date_compilation' => '2006-06-25 14:09:23',
    		);
    		
    		shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertTroll.sql'));
    		$infosTroll = processAnalysis(file_get_contents(dirname(__FILE__).'/messageBotAAGrobideAncien.txt'));
    		
    		$array_diff = array_diff_assoc($compiledInfosTroll, $infosTroll);
    		$this->assertTrue(empty($array_diff));
    		
    		shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
    	}
	}
?>
<?php
	require_once(dirname(__FILE__).'/../lib/Parser.php');
		
	class TestParser extends UnitTestCase {
    	
    	function test_creationAvecBonFichier() {
    		$parser = new Parser(file_get_contents(dirname(__FILE__).'/messageBotAASquatman.txt'));
    		$referenceInfos = array(
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
    		$infosTroll = $parser->getInfosTroll();
    		$diff_assoc = array_diff_assoc($referenceInfos, $infosTroll);
    		$this->assertTrue(empty($diff_assoc));
    	}
	}
?>
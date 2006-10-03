<?php
	require_once(dirname(__FILE__).'/../lib/Parser.php');
		
	class TestParser extends UnitTestCase {
    	
    	function test_creationAvecMauvaisDescripteurDeFichier() {
    		$parser = new Parser('pas de fichier');
    		$this->assertError('error: file not found');
    	}
    	    	   	
    	function test_sanityCheck() {
    		$referenceArray = array(
				'fraise' => 'rouge',
				'pomme' => 'verte',
				'orange' => 'orange',
				'banane' => 'jaune'
			);
			
			$sameArray = array(
				'fraise' => 'rouge',
				'orange' => 'orange',
				'pomme' => 'verte',
				'banane' => 'jaune'
			);
			$diff = array_diff($referenceArray, $sameArray);
			$diff_assoc = array_diff_assoc($referenceArray, $sameArray);
			$this->assertTrue(empty($diff));
			$this->assertTrue(empty($diff_assoc));
    	}
    	
    	function test_creationAvecBonFichier() {
    		$parser = new Parser(dirname(__FILE__).'/messageBotAA.txt');
    		$referenceInfos = array(
    			'numero' => 62465,
    			'nom' => 'SQUATMAN',
    			'race' => 'Inconnue',
    			'niveau' => 22,
    			'vie' => 'Excellent (entre 120 et 140)',
    			'attaque' => 'Moyen (entre 4 et 6)',
    			'esquive' => 'Très Fort (entre 7 et 9)',
    			'degats' => 'Excellent (entre 11 et 13)',
    			'regeneration' => 'Remarquable (entre 4 et 5)',
    			'armure' => 'Exceptionnel (entre 16 et 18)',
    			'vue' => 'Moyen (entre 3 et 5)',
    			'date_compilation' => '2006-09-30 16:12:05',
    		);
    		$infosTroll = $parser->getInfosTroll();
    		$diff = array_diff($referenceInfos, $infosTroll);
    		$diff_assoc = array_diff_assoc($referenceInfos, $infosTroll);
    		$this->assertTrue(empty($diff));
			$this->assertTrue(empty($diff_assoc));
    	}
	}
?>
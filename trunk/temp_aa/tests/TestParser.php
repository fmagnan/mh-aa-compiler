<?php
	require_once(dirname(__FILE__).'/../lib/Parser.class.php');
	require_once(dirname(__FILE__).'/functionsForTests.inc.php');
		
	class TestParser extends UnitTestCase {
    	
    	function test_champAttaqueIntrouvable() {
    		$inputData = "Points de Vie : Excellent (entre 120 et 140) \nBlessure (Approximatif) : 0 %";
    		$parser = new Parser($inputData);
    		$value = $parser->extractValue("/Dés d'Attaque/", 'extractParenthesisMethod');
    		$this->assertNull($value);
    	}
    	
    	function test_champVie() {
    		$inputData = "Points de Vie : Excellent (entre 120 et 140)";
    		$parser = new Parser($inputData);
    		$value = $parser->extractValue("/^Points de Vie/", 'extractParenthesisMethod');
    		$this->assertEqual("entre 120 et 140", $value);
    	}
    	
    	function test_champNiveauIntrouvable() {
    		$inputData = "Points de Vie : Excellent (entre 120 et 140) \nBlessure (Approximatif) : 0 %";
    		$parser = new Parser($inputData);
    		$value = $parser->extractValue("/^Niveau/", 'extractSimpleMethod');
    		$this->assertNull($value);
    	}
    	   	
    	function test_champNiveau() {
    		$inputData = "Niveau : 22";
    		$parser = new Parser($inputData);
    		$value = $parser->extractValue('/^Niveau/', 'extractSimpleMethod');
    		$this->assertEqual(22, $value);
    	}
    	
    	function test_champDate() {
    		$inputData = "Expéditeur (Id) 	MountyHall 	Date d'envoi 	30/09/2006 16:12:05";
    		$parser = new Parser($inputData);
    		$value = $parser->extractValue('/Date/', 'extractDateMethod');
    		$this->assertEqual("2006-09-30 16:12:05", $value);
    	}
    	
    	function test_champDateIntrouvable() {
    		$inputData = "Expéditeur (Id)";
    		$parser = new Parser($inputData);
    		$value = $parser->extractValue('/Date/', 'extractDateMethod');
    		$this->assertNull($value);
    	}
    	
    	function test_champNumero() {
    		$inputData = "Le Troll Ciblé : SQUATMAN - N° 62465)";
    		$parser = new Parser($inputData);
    		$value = $parser->extractValue('/^Le Troll/', 'extractNumberMethod');
    		$this->assertEqual(62465, $value);
    	}
    	
    	function test_champNumeroIntrouvable() {
    		$inputData = "TMAN - N° 62465)";
    		$parser = new Parser($inputData);
    		$value = $parser->extractValue('/^Le Troll/', 'extractNumberMethod');
    		$this->assertNull($value);
    	}
    		
    	function test_reconnaitLigneDansChaineInitiale() {
    		$inputData = "Points de Vie : Excellent (entre 120 et 140) \nBlessure (Approximatif) : 0 % \nDés d'Attaque : Moyen (entre 4 et 6)";
    		$parser = new Parser($inputData);
    		$value = $parser->extractValue("/Dés d'Attaque/", 'extractSimpleMethod');
    		$this->assertEqual("entre 4 et 6", $value);
    	}
    	
    	function test_recuperationInfosPubliques() {
    		$parser = new Parser('rien');
    		$publicInfos = $parser->getPublicInfos(6807);
    		$this->assertEqual("Herb'", $publicInfos['nom']);
    		$this->assertEqual('Durakuir', $publicInfos['race']);
    	}
    	
    	function test_creationAvecBonFichier() {
    		$parser = new Parser(file_get_contents(dirname(__FILE__).'/messageBotAASquatman.txt'));
    		$referenceInfos = array(
    			'numero' => 62465,
    			'nom' => 'Squatman',
    			'race' => 'Durakuir',
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
    		$parser->parseData();
    		$infosTroll = $parser->getInfosTroll();
    		
    		//error_log(print_r($infosTroll), TRUE);
    		
    		$diff_assoc = array_diff_assoc($referenceInfos, $infosTroll);
    		$this->assertTrue(empty($diff_assoc));
    	}
    	
	}
?>
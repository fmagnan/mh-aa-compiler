<?php
	require_once dirname(__FILE__).'/../lib/Parser.class.php';
	require_once dirname(__FILE__).'/functionsForTests.inc.php';
	require_once dirname(__FILE__).'/../lib/core.inc.php';
		
	class TestParser extends UnitTestCase {
    	
    	function test_recuperationInfosPubliquesTrollInconnu() {
    		error_log("--à--" . ' ' . utf8_encode("--à--"));	
    	
    		$parser = new Parser('rien');
    		$publicInfos = getPublicInfos(1559, dirname(__FILE__));
    		$this->assertError('Troll n°1559 does not exist');
    		$this->assertNull($publicInfos);
    	}
    	
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
    		$publicInfos = getPublicInfos(6807, dirname(__FILE__));
			$this->assertEqual("Herb'", $publicInfos['nom']);
    		$this->assertEqual('Durakuir', $publicInfos['race']);
    		$this->assertEqual('3053', $publicInfos['numero_guilde']);
    		$this->assertEqual('Les 12 salopards', $publicInfos['guilde']);
    		$this->assertEqual(42, $publicInfos['niveau_actuel']);
    	}
    	
    	function test_recuperationInfosPubliquesSansGuilde() {
    		$parser = new Parser('rien');
    		$publicInfos = getPublicInfos(31725, dirname(__FILE__));
    		$this->assertEqual('Madjestoet', $publicInfos['nom']);
    		$this->assertEqual('Skrim', $publicInfos['race']);
    		$this->assertEqual('1', $publicInfos['numero_guilde']);
    		$this->assertEqual('-', $publicInfos['guilde']);
    	}
    	
    	function test_creationAvecBonFichier() {
    		$parser = new Parser(file_get_contents(dirname(__FILE__).'/messageBotAASquatman.txt'));
    		$referenceInfos = array(
    			'numero' => 62465,
    			'nom' => 'Squatman',
    			'race' => 'Durakuir',
    			'numero_guilde' => 147,
    			'guilde' => 'X-Trolls',
    			'niveau' => 22,
    			'niveau_actuel' => 22,
    			'vie' => 'entre 120 et 140',
    			'attaque' => 'entre 4 et 6',
    			'esquive' => 'entre 7 et 9',
    			'degats' => 'entre 11 et 13',
    			'regeneration' => 'entre 4 et 5',
    			'armure' => 'entre 16 et 18',
    			'vue' => 'entre 3 et 5',
    			'date_compilation' => '2006-09-30 16:12:05',
    		);
    		$infosTroll = $parser->parseDataAndRetrieveInfos(dirname(__FILE__));
    		
    		$diff_assoc = array_diff_assoc($referenceInfos, $infosTroll);
    		$this->assertTrue(empty($diff_assoc));
    	}
    	
    	function test_creationAvecSelectionALaMain() {
    		$parser = new Parser(file_get_contents(dirname(__FILE__).'/messageBotAABoorajEnSelectionALaMain.txt'));
    		$referenceInfos = array(
    			'numero' => 30905,
    			'nom' => 'Boohraj Dekrane',
    			'race' => 'Kastar',
    			'numero_guilde' => 2435,
    			'guilde' => 'Les questeurs du Vent',
    			'niveau' => 28,
    			'niveau_actuel' => 28,
    			'vie' => 'entre 95 et 115',
    			'attaque' => 'entre 3 et 5',
    			'esquive' => 'entre 12 et 14',
    			'degats' => 'supérieur à 20',
    			'regeneration' => 'entre 4 et 5',
    			'armure' => 'entre 2 et 4',
    			'vue' => 'entre 5 et 7',
    			'date_compilation' => '2006-10-07 18:49:44', 
    		);
    		$infosTroll = $parser->parseDataAndRetrieveInfos(dirname(__FILE__));
    		
    		$diff_assoc = array_diff_assoc($referenceInfos, $infosTroll);
    		$this->assertTrue(empty($diff_assoc));
    	}
    	
    	function test_creationAvecTrollInconnu() {
    		$parser = new Parser(file_get_contents(dirname(__FILE__).'/messageBotAATrollInconnu.txt'));
    		$data = $parser->parseDataAndRetrieveInfos(dirname(__FILE__));
    		$this->assertError('Troll n°1559 does not exist');
    		$this->assertNull($data);
    	}
    	
    	function test_creationAvecChampManquant() {
    		$parser = new Parser(file_get_contents(dirname(__FILE__).'/messageBotAAChampManquantSquatman.txt'));
    		$referenceInfos = array(
    			'numero' => 62465,
    			'nom' => 'Squatman',
    			'race' => 'Durakuir',
    			'numero_guilde' => 147,
    			'guilde' => 'X-Trolls',
    			'niveau' => 22,
    			'niveau_actuel' => 22,
    			'vie' => 'entre 120 et 140',
    			'attaque' => 'entre 4 et 6',
    			'esquive' => 'entre 7 et 9',
    			'degats' => 'entre 11 et 13',
    			'regeneration' => 'entre 4 et 5',
    			'armure' => 'entre 16 et 18',
    			'vue' => 'entre 3 et 5',
    			'date_compilation' => '',
    		);
    		$infosTroll = $parser->parseDataAndRetrieveInfos(dirname(__FILE__));
    		
    		$diff_assoc = array_diff_assoc($referenceInfos, $infosTroll);
    		$this->assertTrue(empty($diff_assoc));
    	}
    	
	}
?>
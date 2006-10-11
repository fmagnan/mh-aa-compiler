<?php
	require_once(dirname(__FILE__).'/../lib/Troll.class.php');
	require_once 'functionsForTests.inc.php';
	
	class TestTroll extends UnitTestCase {
    	
    	var $donneesDeTest = array(
			'numero' => 3573,
			'nom' => 'DIAPPE',
			'race' => 'Skrim',
			'numero_guilde' => 2441,
			'guilde' => 'Saigneurs des Profondeurs',
			'niveau' => 40,
			'niveau_actuel' => 40,
			'vie' => 'entre 115 et 135',
			'attaque' => 'supérieur à 20',
			'esquive' => 'entre 14 et 16',
			'degats' => 'entre 18 et 20',
			'regeneration' => 'entre 4 et 5',
			'armure' => 'entre 12 et 14',
			'vue' => 'inférieur à 3',
			'date_compilation' => '2006-03-10 15:12:45',
			'sortileges' => '',
		);
    	
    	var $donneesTronquees = array(
			'numero' => 3573,
			'nom' => 'DIAPPE',
			'race' => 'Skrim',
			'niveau' => 40,
			'niveau_actuel' => 40,
			'vie' => 'entre 115 et 135',
			'attaque' => 'supérieur à 20',
			'esquive' => 'entre 14 et 16',
			'degats' => 'entre 18 et 20',
			'regeneration' => 'entre 4 et 5',
			'armure' => 'entre 12 et 14',
			'vue' => 'inférieur à 3',
		);
    	
    	var $troll;
    	
    	function test_creationTrollSansTableau() {
    		$troll = new Troll('Ceci n\'est pas une chaine valide');
    		$this->troll = $troll;
    		$this->assertError('error: input data is not an array');
		}
		
		function test_creationTrollAvecTableauVide() {
			$troll = new Troll(array());
			$this->troll = $troll;
    		$this->assertError('error: input data array is empty');
		}
		
		function test_creationTrollAvecDonneesTronquees() {
			$troll = new Troll($this->donneesTronquees);
			$this->troll = $troll;
			$this->assertError('unable to instanciate Troll, data is missing (numero_guilde;guilde;date_compilation;sortileges)');
		}
		
		function test_creationTrollAvecDonnees() {
			$troll = new Troll($this->donneesDeTest);
			$this->troll = $troll;
			$this->assertNotNull($troll);
		}
		
		function test_accesseurs() {
			$troll = new Troll($this->donneesDeTest);
			$this->troll = $troll;
			$this->assertEqual(3573, $troll->getNumero());
			$this->assertEqual('DIAPPE', $troll->getNom());
			$this->assertEqual('Skrim', $troll->getRace());
			$this->assertEqual(40, $troll->getNiveau());
			$this->assertEqual('entre 115 et 135', $troll->getVie());
			$this->assertEqual('supérieur à 20', $troll->getAttaque());
			$this->assertEqual('entre 14 et 16', $troll->getEsquive());
			$this->assertEqual('entre 18 et 20', $troll->getDegats());
			$this->assertEqual('entre 4 et 5', $troll->getRegeneration());
			$this->assertEqual('inférieur à 3', $troll->getVue());
			$this->assertEqual('entre 12 et 14', $troll->getArmure());
			
			$array_diff = array_diff_assoc($this->donneesDeTest, $troll->getDonnees());
			$this->assertTrue(empty($array_diff));
		}
		
		function test_miseAJourTrollSansTableau() {
			$troll = new Troll($this->donneesDeTest);
			$this->troll = $troll;
			$troll->update('donnees invalides');
			$this->assertError('error: input data is not an array');
		}
		
		function test_miseAJourTrollAvecTableauVide() {
			$troll = new Troll($this->donneesDeTest);
			$this->troll = $troll;
			$troll->update(array());
			$this->assertError('error: input data array is empty');
		}
		
		function test_miseAJourTrollAvecResultatUnique() {
			$troll = new Troll($this->donneesDeTest);
			$this->troll = $troll;
			$donneesDeMiseAJour = array(
				'nom' => 'DIAPPE',
				'race' => 'Inconnue',
				'attaque' => 'entre 18 et 20',
				'degats' => 'entre 16 et 18',
				'champInconnu' => '42 !!',
			);
			$troll->update($donneesDeMiseAJour);
			$this->assertEqual('DIAPPE', $troll->getNom());
			$this->assertEqual('Skrim', $troll->getRace());
			$this->assertEqual('20', $troll->getAttaque());
			$this->assertEqual('18', $troll->getDegats());
		}
		
	}
?>
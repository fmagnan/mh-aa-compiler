<?php
	require_once(dirname(__FILE__).'/../lib/Troll.php');
		
	class TestTroll extends UnitTestCase {
    	
    	var $donneesDeTest = array(
			'numero' => 3573,
			'nom' => 'DIAPPE',
			'race' => 'Skrim',
			'niveau' => 40,
			'vie' => 'Excellent (entre 115 et 135)',
			'attaque' => 'Jamais vu (supérieur à 20)',
			'esquive' => 'Impressionant (entre 14 et 16)',
			'degats' => 'Incroyable (entre 18 et 20)',
			'regeneration' => 'Remarquable (entre 4 et 5)',
			'armure' => 'Excellent (entre 12 et 14)',
			'vue' => 'inférieur à 3',
			'sortileges' => '',
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
			$donneesDeMiseAJour = array('attaque' => 'entre 18 et 20', 'degats' => 'entre 16 et 18');
			$troll->update($donneesDeMiseAJour);
			$this->assertEqual('20', $troll->getAttaque());
			$this->assertEqual('18', $troll->getDegats());
		}
		
		function tearDown() {
			$this->troll->delete();	
		}
		
	}
?>
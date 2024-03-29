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
    	
    	function test_creationTrollSansTableau() {
    		$troll = new Troll('Ceci n\'est pas une chaine valide');
    		$this->assertError('error: input data is not an array');
		}
		
		function test_creationTrollAvecTableauVide() {
			$troll = new Troll(array());
			$this->assertError('error: input data array is empty');
		}
		
		function test_creationTrollAvecDonneesTronquees() {
			$troll = new Troll($this->donneesTronquees);
			$this->assertError('unable to instanciate Troll, data is missing (numero_guilde;guilde;date_compilation;sortileges)');
		}
		
		function test_creationTrollAvecDonnees() {
			$troll = new Troll($this->donneesDeTest);
			$this->assertNotNull($troll);
		}
		
		function test_accesseurs() {
			$troll = new Troll($this->donneesDeTest);
			$this->assertEqual(3573, $troll->getNumero());
			$this->assertEqual('DIAPPE', $troll->getNom());
			$this->assertEqual('Skrim', $troll->getRace());
			$this->assertEqual(40, $troll->getNiveau());
			$this->assertEqual(40, $troll->getNiveauActuel());
			$this->assertEqual('entre 115 et 135', $troll->getVie());
			$this->assertEqual('supérieur à 20', $troll->getAttaque());
			$this->assertEqual('entre 14 et 16', $troll->getEsquive());
			$this->assertEqual('entre 18 et 20', $troll->getDegats());
			$this->assertEqual('Saigneurs des Profondeurs', $troll->getNomGuilde());
			$this->assertEqual(2441, $troll->getNumeroGuilde());
			$this->assertEqual('entre 4 et 5', $troll->getRegeneration());
			$this->assertEqual('inférieur à 3', $troll->getVue());
			$this->assertEqual('entre 12 et 14', $troll->getArmure());
			$this->assertEqual('217 jours', $troll->getAgeAnalyse(mktime ( 15, 42, 13, 10, 13, 2006)));
			
			$array_diff = array_diff_assoc($this->donneesDeTest, $troll->getDonnees());
			$this->assertTrue(empty($array_diff));
		}
		
		function test_TrollSansSortilege() {
			$troll = new Troll($this->donneesDeTest);
			$this->assertEqual('Aucun sort connu', $troll->getListeSortileges());
		}
		
		function test_TrollAvecSortileges() {
			$donneesDeTest = $this->donneesDeTest;
			$donneesDeTest['sortileges'] = 'Analyse Anatomique;Armure Ethérée';
			$listeReference = array('Analyse Anatomique', 'Armure Ethérée');
			$trollAvecSortileges = new Troll($donneesDeTest);
			$array_diff = array_diff($listeReference, $trollAvecSortileges->getListeSortileges());
			$this->assertTrue(empty($array_diff));
		}
		
		function test_miseAJourTrollSansTableau() {
			$troll = new Troll($this->donneesDeTest);
			$troll->update('donnees invalides');
			$this->assertError('error: input data is not an array');
		}
		
		function test_miseAJourTrollAvecTableauVide() {
			$troll = new Troll($this->donneesDeTest);
			$troll->update(array());
			$this->assertError('error: input data array is empty');
		}
		
		function test_miseAJourTrollAvecResultatUnique() {
			$troll = new Troll($this->donneesDeTest);
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
		
		function test_miseAJourTrollAvecValeurSuperieure() {
			$troll = new Troll($this->donneesDeTest);
			$donneesDeMiseAJour = array(
				'nom' => 'DIAPPE',
				'race' => 'Inconnue',
				'attaque' => 'entre 18 et 20',
				'degats' => 'supérieur à 20',
			);
			$troll->update($donneesDeMiseAJour);
			$this->assertEqual('DIAPPE', $troll->getNom());
			$this->assertEqual('Skrim', $troll->getRace());
			$this->assertEqual('20', $troll->getAttaque());
			$this->assertEqual('supérieur à 20', $troll->getDegats());
		}
		
		function test_miseAJourTrollAvecAmelioration() {
			$troll = new Troll($this->donneesDeTest);
			$donneesDeMiseAJour = array(
				'nom' => 'DIAPPE',
				'race' => 'Inconnue',
				'esquive' => 'entre 15 et 17',
			);
			$troll->update($donneesDeMiseAJour);
			$this->assertEqual('DIAPPE', $troll->getNom());
			$this->assertEqual('Skrim', $troll->getRace());
			$this->assertEqual('entre 15 et 17', $troll->getEsquive());
		}
		
		function test_miseAJourTrollSansAmelioration() {
			$troll = new Troll($this->donneesDeTest);
			$donneesDeMiseAJour = array(
				'nom' => 'DIAPPE',
				'race' => 'Inconnue',
				'esquive' => 'entre 15 et 17',
			);
			$troll->update($donneesDeMiseAJour, false);
			$this->assertEqual('DIAPPE', $troll->getNom());
			$this->assertEqual('Skrim', $troll->getRace());
			$this->assertEqual('entre 15 et 16', $troll->getEsquive());
		}
		
		function test_creationTrollSansGuilde() {
			$infosTrollSansGuilde = array(
				'numero' => 72332,
				'nom' => 'hhrrhha',
				'race' => 'Skrim',
				'numero_guilde' => 1,
				'guilde' => '-',
				'niveau' => 10,
				'niveau_actuel' => 10,
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
			$trollSansGuilde = new Troll($infosTrollSansGuilde);
			$this->assertEqual('Aucune', $trollSansGuilde->getNomGuilde());
			$this->assertEqual(1, $trollSansGuilde->getNumeroGuilde());
		}
		
	}
?>
<?php
	require_once(dirname(__FILE__).'/../lib/Compiler.class.php');
		
	class TestCompiler extends UnitTestCase {
    	
    	function test_creationAvecMauvaiseDonnee() {
    		$compiler = new Compiler('mauvaise entrée');
    		$this->assertError('error[Compiler()]: wrong input data');
    	}
    	
    	function test_creationAvecDonneeUnique() {
    		$compiler = new Compiler('120');
    		$this->assertEqual(120, $compiler->getMinimumValue());
    		$this->assertEqual(120, $compiler->getMaximumValue());
    	}
    	
    	function test_creationAvecIntervalle() {
    		$compiler = new Compiler('entre 11 et 13');
    		$this->assertEqual(11, $compiler->getMinimumValue());
    		$this->assertEqual(13, $compiler->getMaximumValue());
    	}
    	
    	function test_creationAvecBorneInferieure() {
    		$compiler = new Compiler('inférieur à 3');
    		$this->assertEqual(0, $compiler->getMinimumValue());
    		$this->assertEqual(3, $compiler->getMaximumValue());
    	}
    	
    	function test_creationAvecBorneSuperieure() {
    		$compiler = new Compiler('supérieur à 200');
    		$this->assertEqual(200, $compiler->getMinimumValue());
    		$this->assertEqual(1000, $compiler->getMaximumValue());
    	}
    	
    	function test_nouvelleDonneeInferieureAReferenceSimple() {
    		$compiler = new Compiler('100');
    		$compiler->analyse('entre 80 et 90');
    		$this->assertError('Compiler->analyse(): valeur maximale[90] < valeur minimale[100]');
		}
		
		function test_nouvelleDonneeInferieureAReferenceDouble() {
    		$compiler = new Compiler('entre 80 et 90');
    		$compiler->analyse('entre 60 et 70');
    		$this->assertError('Compiler->analyse(): valeur maximale[70] < valeur minimale[80]');
		}
	
		function test_nouvelleDonneeInferieureATout() {
    		$compiler = new Compiler('entre 5 et 6');
    		$compiler->analyse('inférieur à 3');
    		$this->assertError('Compiler->analyse(): valeur maximale[3] < valeur minimale[5]');
		}
		
		function test_nouvelleDonneeInferieureEtEgaleAReferenceSimple() {
    		$compiler = new Compiler('120');
    		$compiler->analyse('entre 110 et 120');
    		$this->assertEqual(120, $compiler->getMinimumValue());
    		$this->assertEqual(120, $compiler->getMaximumValue());
		}
		
		function test_nouvelleDonneeSuperieureEtEgaleAReferenceSimple() {
    		$compiler = new Compiler('120');
    		$compiler->analyse('entre 120 et 130');
    		$this->assertEqual(120, $compiler->getMinimumValue());
    		$this->assertEqual(130, $compiler->getMaximumValue());
		}
		
		function test_nouvelleDonneeSuperieureEtEgaleAReferenceSimpleSansAmelioration() {
    		$compiler = new Compiler('120');
    		$compiler->analyse('entre 120 et 130', false);
    		$this->assertEqual(120, $compiler->getMinimumValue());
    		$this->assertEqual(120, $compiler->getMaximumValue());
		}
		
		function test_nouvelleDonneeSuperieureAReferenceSimple() {
    		$compiler = new Compiler('120');
    		$compiler->analyse('entre 150 et 160');
    		$this->assertEqual(150, $compiler->getMinimumValue());
    		$this->assertEqual(160, $compiler->getMaximumValue());
		}
		
		function test_nouvelleDonneeInferieureEtEgaleAReferenceDouble() {
    		$compiler = new Compiler('entre 120 et 140');
    		$compiler->analyse('entre 110 et 130');
    		$this->assertEqual(120, $compiler->getMinimumValue());
    		$this->assertEqual(130, $compiler->getMaximumValue());
		}
		
		function test_nouvelleDonneeInferieureDonneResultatSimple() {
    		$compiler = new Compiler('entre 12 et 14');
    		$compiler->analyse('entre 10 et 12');
    		$this->assertEqual(12, $compiler->getMinimumValue());
    		$this->assertEqual(12, $compiler->getMaximumValue());
		}
		
		function test_nouvelleDonneeSuperieureEtEgaleAReferenceDouble() {
    		$compiler = new Compiler('entre 120 et 140');
    		$compiler->analyse('entre 130 et 150');
    		$this->assertEqual(130, $compiler->getMinimumValue());
    		$this->assertEqual(150, $compiler->getMaximumValue());
		}
		
		function test_nouvelleDonneeSuperieureEtEgaleAReferenceDoubleSansAmelioration() {
    		$compiler = new Compiler('entre 120 et 140');
    		$compiler->analyse('entre 130 et 150', false);
    		$this->assertEqual(130, $compiler->getMinimumValue());
    		$this->assertEqual(140, $compiler->getMaximumValue());
		}
		
		function test_nouvelleDonneeSuperieureAReferenceDouble() {
    		$compiler = new Compiler('entre 120 et 140');
    		$compiler->analyse('entre 170 et 180');
    		$this->assertEqual(170, $compiler->getMinimumValue());
    		$this->assertEqual(180, $compiler->getMaximumValue());
		}
		
		function test_nouvelleDonneeSuperieureATout() {
    		$compiler = new Compiler('entre 120 et 140');
    		$compiler->analyse('supérieur à 200');
    		$this->assertEqual(200, $compiler->getMinimumValue());
    		$this->assertEqual(1000, $compiler->getMaximumValue());
		}
		
		function test_donneValeurUnique() {
    		$compiler = new Compiler('entre 120 et 140');
    		$compiler->analyse('entre 100 et 120');
    		$this->assertEqual(120, $compiler->getMinimumValue());
    		$this->assertEqual(120, $compiler->getMaximumValue());
		}
		
	}
?>
<?php
	require_once(dirname(__FILE__).'/../lib/core.inc.php');
	require_once 'functionsForTests.inc.php';
	
	class TestTrollUpgrades extends UnitTestCase {
    	
    	var $mockFilePath;
    	var $mockCss2FilePath;
    	
    	function setUp() {
    		$publicFilesDirectoryPath = dirname(__FILE__).'/pub/';
    		$this->mockFilePath = $publicFilesDirectoryPath.'eventsFromCradoc.php';
    		$this->mockCss2FilePath = $publicFilesDirectoryPath.'eventsFromCradocCss2Profile.php';
    	}
    	
    	function test_trollSansAmelioration() {
    		$debut = mktime(0, 0, 0, 02, 20, 2007);
    		$fin = mktime(0, 0, 0, 03, 04, 2007);
    		$this->assertFalse(isUpgradeFoundBetween($debut, $fin, $this->mockFilePath));
    		$this->assertFalse(isUpgradeFoundBetween($debut, $fin, $this->mockCss2FilePath));
		}
		
		function test_trollAvecDateCommuneAuDebut() {
    		$debut = mktime(22, 38, 16, 02, 17, 2007);
    		$fin = mktime(0, 0, 0, 02, 18, 2007);
    		$this->assertFalse(isUpgradeFoundBetween($debut, $fin, $this->mockFilePath));
    		$this->assertFalse(isUpgradeFoundBetween($debut, $fin, $this->mockCss2FilePath));
		}
		
		function test_trollAvecDateCommuneALaFin() {
    		$debut = mktime(8, 28, 18, 01, 17, 2007);
    		$fin = mktime(15, 11, 45, 01, 26, 2007);
    		$this->assertFalse(isUpgradeFoundBetween($debut, $fin, $this->mockFilePath));
    		$this->assertFalse(isUpgradeFoundBetween($debut, $fin, $this->mockCss2FilePath));
		}
		
		function test_trollJusteAvantDebut() {
    		$debut = mktime(22, 38, 15, 02, 17, 2007);
    		$fin = mktime(0, 0, 0, 02, 18, 2007);
    		$this->assertTrue(isUpgradeFoundBetween($debut, $fin, $this->mockFilePath));
    		$this->assertTrue(isUpgradeFoundBetween($debut, $fin, $this->mockCss2FilePath));
		}
	}
?>
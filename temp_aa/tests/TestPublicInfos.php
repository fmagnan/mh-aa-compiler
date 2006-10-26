<?php
	require_once dirname(__FILE__).'/../lib/PublicInfos.class.php';
	require_once dirname(__FILE__).'/../lib/core.inc.php';
	require_once 'functionsForTests.inc.php';
	
	class TestPublicInfos extends UnitTestCase {
    	
    	function setUp() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
    	}
    	
    	function test_recupereListeTrolls() {
    		$publicInfos = new PublicInfos();
    		$result = $publicInfos->getTrollListByFTP();
    		$this->assertTrue($result);
    	}
    	    		
    	function test_recupereListeGuilde() {
    		$publicInfos = new PublicInfos();
    		$result = $publicInfos->getAllianceListByFTP();
    		$this->assertTrue($result);
    	}    		
    	
    	function test_metAJourInfosPubliques() {
    		shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertIncompleteData.sql'));
    		$publicInfos = new PublicInfos();
    		$publicInfos->setLocalDestinationFolder(dirname(__FILE__) . '/pub/');
    		$publicInfos->updatePublicInfos();
    		$infosTroll = getInfosTrollFromDB(3);
    		$this->assertEqual(46, $infosTroll['niveau_actuel']);
    		$this->assertEqual('Skrim', $infosTroll['race']);
    		$this->assertEqual(1979, $infosTroll['numero_guilde']);
    		$this->assertEqual('Orcheströll In The Dark', $infosTroll['guilde']);
    	}
    	
    	function test_metAJourInfosPubliquesAvecTrollInconnu() {
    		shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('insertVanishedTrollAmongRealTrolls.sql'));
    		$publicInfos = new PublicInfos();
    		$publicInfos->setLocalDestinationFolder(dirname(__FILE__) . '/pub/');
    		$trolls = $publicInfos->updatePublicInfos();
    		$this->assertError('Troll n°31902 does not exist anymore');
    	}
    	
    	function tearDown() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
    	}
    	    	
	}
?>
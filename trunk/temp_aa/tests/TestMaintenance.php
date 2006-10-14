<?php
	require_once dirname(__FILE__).'/../lib/maintenance.inc.php';
	require_once 'functionsForTests.inc.php';
	
	class TestMaintenance extends UnitTestCase {

		function test_siteEstDisponible() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
			$this->assertFalse(isSiteStoppedForMaintenance());
		}		
		
		function test_siteEstEnMaintenance() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('metSiteEnMaintenance.sql'));
			$this->assertTrue(isSiteStoppedForMaintenance());
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
		}
		
		function test_arreteSitePourMaintenance() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
			$this->assertFalse(isSiteStoppedForMaintenance());
			stopSiteForMaintenance();
			$this->assertTrue(isSiteStoppedForMaintenance());
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
		}
		
		function test_relanceSitePourMaintenance() {
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
			$this->assertFalse(isSiteStoppedForMaintenance());
			stopSiteForMaintenance();
			$this->assertTrue(isSiteStoppedForMaintenance());
			restartSiteAfterMaintenance();
			$this->assertFalse(isSiteStoppedForMaintenance());
			shell_exec(getMySQLCommandLine() . getAbsolutePathForFile('truncateTable.sql'));
		}
		
	}
?>

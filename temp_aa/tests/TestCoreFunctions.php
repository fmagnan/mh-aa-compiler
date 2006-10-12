<?php
	require_once dirname(__FILE__).'/../lib/core.inc.php';
		
	class TestCoreFunctions extends UnitTestCase {
    	
    	function test_calculAgeAnalyse() {
    		$dateCompilation = '2006-10-08 00:00:00';
    		$this->assertEqual('4 jours', getAgeAnalyse($dateCompilation));
    	}
    	
    }
?>
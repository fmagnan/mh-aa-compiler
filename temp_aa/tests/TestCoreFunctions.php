<?php
	require_once dirname(__FILE__).'/../lib/core.inc.php';
		
	class TestCoreFunctions extends UnitTestCase {
    	
    	function test_calculAgeAnalyse() {
    		$dateCompilation = '2006-10-08 00:00:00';
    		$referenceTimeStamp = mktime ( 15, 42, 13, 10, 13, 2006);
    		$this->assertEqual('5 jours', getAgeAnalyse($referenceTimeStamp, $dateCompilation));
    	}
    	
    	function test_calculAgeAnalyseEnArrondi() {
    		$dateCompilation = '2006-03-10 15:12:45';
    		$referenceTimeStamp = mktime ( 15, 42, 13, 10, 13, 2006);
    		$this->assertEqual('217 jours', getAgeAnalyse($referenceTimeStamp, $dateCompilation));
    	}
    }
?>
<?php
	class TousLesTests extends GroupTest {
		function TousLesTests() {
			$dirname = dirname(__FILE__);
			parent::GroupTest('');
        	$this->addTestFile($dirname.'/TestAccesBase.php');
        	$this->addTestFile($dirname.'/TestCompiler.php');
        	$this->addTestFile($dirname.'/TestMaintenance.php');
        	$this->addTestFile($dirname.'/TestParser.php');
        	$this->addTestFile($dirname.'/TestPublicInfos.php');
        	$this->addTestFile($dirname.'/TestRecetteInsertion.php');
        	$this->addTestFile($dirname.'/TestTroll.php');
        	$this->addTestFile($dirname.'/TestCoreFunctions.php');
        }
	}
?>
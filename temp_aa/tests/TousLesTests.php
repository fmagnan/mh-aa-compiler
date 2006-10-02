<?php
	class TousLesTests extends GroupTest {
		function TousLesTests() {
        	parent::GroupTest('');
        	$this->addTestFile(dirname(__FILE__).'/TestAccesBase.php');
        	$this->addTestFile(dirname(__FILE__).'/TestTroll.php');
        	$this->addTestFile(dirname(__FILE__).'/TestCompiler.php');
        	$this->addTestFile(dirname(__FILE__).'/TestParser.php');
        }
	}
?>
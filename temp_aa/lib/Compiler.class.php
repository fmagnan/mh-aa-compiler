<?php

class Compiler {
	
	var $minimumValue;
	var $maximumValue;
	
	function Compiler($inputString) {
		$values = $this->getValuesFromString($inputString);
		$this->minimumValue = $values['minimum'];
		$this->maximumValue = $values['maximum'];
	}
	
	function getValuesFromString($inputString) {
		$values = array();
		if (ereg('^entre', $inputString)) {
			$endOfString = preg_replace('/entre/', '', $inputString);
			$valuesArray = explode('et', $endOfString);
			$values['minimum'] = intval(trim($valuesArray[0]));
			$values['maximum'] = intval(trim($valuesArray[1]));
		}
		elseif ($uniqueValue = $this->checkIfStringContainsPatternAndEraseIt('inférieur à', $inputString)) {
			$values['minimum'] = 0;
			$values['maximum'] = intval($uniqueValue);
		}
		elseif ($uniqueValue = $this->checkIfStringContainsPatternAndEraseIt('supérieur à', $inputString)) {
			$values['minimum'] = intval($uniqueValue);
			$values['maximum'] = 1000;
		}
		elseif (($uniqueValue = intval(trim($inputString))) != 0) {
			$values['minimum'] = intval($uniqueValue);
			$values['maximum'] = intval($uniqueValue);
		}
		else {
			trigger_error('error[Compiler()]: wrong input data');
		}
				
		return $values;
	}
	
	function checkIfStringContainsPatternAndEraseIt($pattern, $referenceString) {
		$result = FALSE;
		if (ereg('^'.$pattern, $referenceString)) {
			$result = trim(preg_replace('/'.$pattern.'/','',$referenceString));
		}
		return $result;
	}
	
	function analyse($newData) {
		$newValues = $this->getValuesFromString($newData);
		if ($newValues['maximum'] < $this->getMinimumValue()) {
			trigger_error('Compiler->analyse(): valeur maximale['.$newValues['maximum'].
			'] < valeur minimale['.$this->getMinimumValue().']');
		}
		else {
			$referenceMinimumValue = $this->getMinimumValue();
			$newMinimumValue = $newValues['minimum'];
			$referenceMaximumValue = $this->getMaximumValue();
			$newMaximumValue = $newValues['maximum'];
		
			if ($newMinimumValue > $referenceMinimumValue) {
				$this->minimumValue = $newMinimumValue;
			}
			$this->maximumValue = $newMaximumValue;
		}
	}
	
	function getMinimumValue() {
		return $this->minimumValue;
	}
	
	function getMaximumValue() {
		return $this->maximumValue;
	}
}
?>

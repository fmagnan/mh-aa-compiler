<?php

require_once 'Compiler.php';
require_once 'core.inc.php';

class Troll {
	
	var $primaryKeyFieldsNames = array('numero','nom','race');
	var $dataFieldsNames = array('vie','attaque','esquive','degats','regeneration','vue','armure');
	var $data;
	
	function Troll($donnees) {
		if (isNotEmptyInputArray($donnees)) {
			$allFieldsNames = array_merge($this->primaryKeyFieldsNames, $this->dataFieldsNames);
	
			foreach ($allFieldsNames AS $fieldName) {
				$this->data[$fieldName] = $this->formateDonnee($donnees[$fieldName]);
			}
		}
	}
	
	function update($infos) {
		if (isNotEmptyInputArray($infos)) {
			foreach ($infos AS $fieldName => $fieldValue) {
				$compiler = new Compiler($this->data[$fieldName]);
				$compiler->analyse($fieldValue);
				$minimumValue = $compiler->getMinimumValue();
				$maximumValue = $compiler->getMaximumValue();
				if ($minimumValue == $maximumValue) {
					$this->data[$fieldName] = $minimumValue;
				}
				else {
					$this->data[$fieldName] = 'entre ' . $minimumValue . ' et ' . $maximumValue;
				}
			}
		}
	}
	
	function formateDonnee($donnee) {
		$chaineEntreParentheses = strstr($donnee, '(');
		if ($chaineEntreParentheses == FALSE) {
			return $donnee;
		}else {
			$suppressionDesParentheses = substr($chaineEntreParentheses, 1, strlen($chaineEntreParentheses)-2);
			return $suppressionDesParentheses;
		}
	}
	
	function delete() {
		$this = null;
	}
	
	function getNumero() {
		return $this->data['numero'];
	}
	
	function getNom() {
		return $this->data['nom'];
	}
	
	function getRace() {
		return $this->data['race'];
	}
	
	function getVie() {
		return $this->data['vie'];
	}
	
	function getAttaque() {
		return $this->data['attaque'];
	}
	
	function getEsquive() {
		return $this->data['esquive'];
	}
	
	function getDegats() {
		return $this->data['degats'];
	}
	
	function getRegeneration() {
		return $this->data['regeneration'];
	}
	
	function getVue() {
		return $this->data['vue'];
	}
	
	function getArmure() {
		return $this->data['armure'];
	}
	
}
?>

<?php

require_once 'Compiler.class.php';
require_once 'database.inc.php';

class Troll {
	
	var $primaryKeyFieldsNames = array('numero','nom','race','date_compilation','sortileges');
	var $dataFieldsNames = array('niveau', 'vie','attaque','esquive','degats','regeneration','armure','vue');
	var $data;
	
	function Troll($donnees) {
		if (isNotEmptyInputArray($donnees)) {
			$allFieldsNames = array_merge($this->primaryKeyFieldsNames, $this->dataFieldsNames);
	
			foreach ($allFieldsNames AS $fieldName) {
				$this->data[$fieldName] = $donnees[$fieldName];
			}
		}
	}
	
	function update($infos) {
		if (isNotEmptyInputArray($infos)) {
			foreach ($infos AS $fieldName => $fieldValue) {
				if (!in_array($fieldName, $this->primaryKeyFieldsNames) &&
					in_array($fieldName, $this->dataFieldsNames)) {
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
	
	function getNiveau() {
		return $this->data['niveau'];
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
	
	function getDonnees() {
		return $this->data;
	}
	
}
?>

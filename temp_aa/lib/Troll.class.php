<?php

require_once 'Compiler.class.php';
require_once 'core.inc.php';

class Troll {
	
	var $primaryKeyFieldsNames = array('numero','nom','race','numero_guilde', 'guilde', 'date_compilation','sortileges', 'niveau_actuel');
	var $dataFieldsNames = array('niveau', 'vie','attaque','esquive','degats','regeneration','armure','vue');
	var $data;
	
	function Troll($donnees) {
		if (isNotEmptyInputArray($donnees)) {
			$allFieldsNames = array_merge($this->primaryKeyFieldsNames, $this->dataFieldsNames);
	
			$missingData = array_diff($allFieldsNames, array_keys($donnees)); 
			if ($missingData) {
				$error_message = 'unable to instanciate Troll, data is missing (';
				$error_message .= implode(';', $missingData) . ')';
				trigger_error($error_message);
			}
			else {
				foreach ($allFieldsNames AS $fieldName) {
					$this->data[$fieldName] = $donnees[$fieldName];
				}
			}
		}
	}
	
	function update($infos, $isTrollUpgradingSinceLastTime = true) {
		if (isNotEmptyInputArray($infos)) {
			foreach ($infos AS $fieldName => $fieldValue) {
				if (!in_array($fieldName, $this->primaryKeyFieldsNames) &&
					in_array($fieldName, $this->dataFieldsNames)) {
					if ($fieldName == 'armure' || $fieldName == 'niveau') {
						$compiler = new Compiler($infos[$fieldName]);
					}
					else {
						$compiler = new Compiler($this->data[$fieldName]);
						$compiler->analyse($fieldValue, $isTrollUpgradingSinceLastTime);
					}
					
					$minimumValue = $compiler->getMinimumValue();
					$maximumValue = $compiler->getMaximumValue();
					if ($minimumValue == $maximumValue) {
						$this->data[$fieldName] = $minimumValue;
					}
					elseif($minimumValue == 0) {
						$this->data[$fieldName] = 'inférieur à ' . $maximumValue;
					}
					elseif($maximumValue == 1000) {
						$this->data[$fieldName] = 'supérieur à ' . $minimumValue;
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
	
	function getNiveauActuel() {
		return $this->data['niveau_actuel'];
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
	
	function getNumeroGuilde() {
		return $this->data['numero_guilde'];
	}
	
	function getNomGuilde() {
		$guilde = $this->data['guilde'];
		 
		if ('-' == $guilde) {
			return 'Aucune';
		}
		else {
			return $guilde;
		}
	}
	
	function getAgeAnalyse($referenceTimeStamp) {
		return getAgeAnalyse($referenceTimeStamp, $this->data['date_compilation']);
	}
	
	function getListeSortileges() {
		if ('' == $this->data['sortileges']) {
			return 'Aucun sort connu';
		}
		else {
			return explode(';',$this->data['sortileges']);
		}
	}
}
?>

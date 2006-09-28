<?php

class Troll {
	
	var $numero;
	var $nom;
	var $race;
	var $vie;
	var $attaque;
	var $esquive;
	var $degats;
	var $regeneration;
	var $vue;
	var $armure;
	
	function Troll($donnees) {
		if (!is_array($donnees)) {
			trigger_error('error: input data are not an array');
		}
		elseif (empty($donnees)) {
			trigger_error('error: input data array is empty');
		}
		else {
			$this->setNumero($donnees['numero']);
			$this->setNom($donnees['nom']);
			$this->setRace($donnees['race']);
			$this->setVie($this->formateDonnee($donnees['vie']));
			$this->setAttaque($this->formateDonnee($donnees['attaque']));
			$this->setEsquive($this->formateDonnee($donnees['esquive']));
			$this->setDegats($this->formateDonnee($donnees['degats']));
			$this->setRegeneration($this->formateDonnee($donnees['regeneration']));
			$this->setVue($this->formateDonnee($donnees['vue']));
			$this->setArmure($this->formateDonnee($donnees['armure']));
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
	
	function getNumero() {
		return $this->numero;
	}
	
	function setNumero($numero) {
		$this->numero = $numero;
	}
	
	function getNom() {
		return $this->nom;
	}
	
	function setNom($nom) {
		$this->nom = $nom;
	}
	
	function getRace() {
		return $this->race;
	}
	
	function setRace($race) {
		$this->race = $race;
	}
	
	function getVie() {
		return $this->vie;
	}
	
	function setVie($vie) {
		$this->vie = $vie;
	}
	
	function getAttaque() {
		return $this->attaque;
	}
	
	function setAttaque($attaque) {
		$this->attaque = $attaque;
	}
	
	function getEsquive() {
		return $this->esquive;
	}
	
	function setEsquive($esquive) {
		$this->esquive = $esquive;
	}
	
	function getDegats() {
		return $this->degats;
	}
	
	function setDegats($degats) {
		$this->degats = $degats;
	}
	
	function getRegeneration() {
		return $this->regeneration;
	}
	
	function setRegeneration($regeneration) {
		$this->regeneration = $regeneration;
	}
	
	function getVue() {
		return $this->vue;
	}
	
	function setVue($vue) {
		$this->vue = $vue;
	}
	
	function getArmure() {
		return $this->armure;
	}
	
	function setArmure($armure) {
		$this->armure = $armure;
	}
	
	function delete() {
		$this = null;
	}
	
	/*function writeInDB() {
		$infosTrollFromDB = getInfosTrollFromDB($this->getNumero());
		if ($infosTrollFromDB) {
			updateTrollInDB($infosTrollFromDB);
		}
		else {
			createTrollInDB($infosTrollFromDB);
		}
	}*/
}
?>

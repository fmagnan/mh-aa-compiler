<?php

class Parser {

	var $inputData;
	var $infosTroll;

	function Parser($content) {
		$contentArray = explode("\n", $content);
		$this->inputData = $contentArray;
	}
	
	function getSimpleValue($pattern) {
		$lineInArray = array_values(preg_grep($pattern, $this->inputData));
		$dividedLineArray = explode(':', $lineInArray[0]);
		return intval(trim($dividedLineArray[1]));
	}
	
	function getParenthesisValue($pattern) {
		$lineInArray = array_values(preg_grep($pattern, $this->inputData));
		$dividedLineArray = explode(':', $lineInArray[0]);
		$lineWithParenthesis = trim($dividedLineArray[1]);
		preg_match('/\(.*\)/', $lineWithParenthesis, $matches);
		$value = substr($matches[0], 1, $matches[0]-1);
		return $value;
	}
	
	function getDateValue() {
		$lineInArray = array_values(preg_grep("/Date/", $this->inputData));
		$lineInString = $lineInArray[0];
		preg_match ("/[0-9]{1,2}\/[01]?[0-9]\/[0-9]{4}/",$lineInString, $dateMatches);
		preg_match ("/[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}/",$lineInString, $timeMatches);
		$formattedDate = implode('-', array_reverse(explode('/', $dateMatches[0])));
		return $formattedDate . ' ' . $timeMatches[0]; 
	}
	
	function retrieveValuesForNumberAndName() {
		$lineInArray = array_values(preg_grep("/^Le Troll/", $this->inputData));
		$lineInString = $lineInArray[0];
		$lineArray = explode(':', $lineInString);
		$partieDroite = trim($lineArray[1]);
		$nomEtNumero = explode('- N°', $partieDroite);
		$nomEtNumero['numero'] = intval(substr(trim($nomEtNumero[1]), 0, strlen(trim($nomEtNumero[1]))-1));
		$nomEtNumero['nom'] = trim($nomEtNumero[0]);
		return $nomEtNumero;
	}
	
	function parseData() {
		$numberAndName = $this->retrieveValuesForNumberAndName();
		
		$this->infosTroll = array(
			'numero' => $numberAndName['numero'],
			'nom' => $numberAndName['nom'],
			'race' => 'Inconnue',
			'niveau' => $this->getSimpleValue("/^Niveau/"),
			'vie' => $this->getParenthesisValue("/^Points de Vie/"),
			'attaque' => $this->getParenthesisValue("/Attaque/"),
			'esquive' => $this->getParenthesisValue("/Esquive/"),
			'degats' => $this->getParenthesisValue("/Dégât/"),
			'regeneration' => $this->getParenthesisValue("/Régénération/"),
			'armure' => $this->getParenthesisValue("/^Armure/"),
			'vue' => $this->getParenthesisValue("/^Vue/"),
			'date_compilation' => $this->getDateValue(),
		);
		
	}

	function getInfosTroll() {
		return $this->infosTroll;
	}
}
?>
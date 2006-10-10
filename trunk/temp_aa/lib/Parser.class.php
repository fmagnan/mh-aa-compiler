<?php

class Parser {

	var $inputData;
	var $infosTroll;

	function Parser($content) {
		$contentArray = explode("\n", $content);
		$this->inputData = $contentArray;
	}
	
	function extractValue($pattern, $methodName) {
		$matchPattern = preg_grep($pattern, $this->inputData);
		if (!empty($matchPattern)) {
			return $this->$methodName($matchPattern);
		}
		else {
			return null;
		}
	}
	
	function extractSimpleMethod($matchPattern) {
		$lineInArray = array_values($matchPattern);
		$dividedLineArray = explode(':', $lineInArray[0]);
		return intval(trim($dividedLineArray[1]));
	}
	
	function extractParenthesisMethod($matchPattern) {
		$lineInArray = array_values($matchPattern);
		$dividedLineArray = explode(':', $lineInArray[0]);
		$lineWithParenthesis = trim($dividedLineArray[1]);
		preg_match('/\(.*\)/', $lineWithParenthesis, $matches);
		$value = substr($matches[0], 1, $matches[0]-1);
		return $value;
	}
	
	function extractDateMethod($matchPattern) {
		$lineInArray = array_values($matchPattern);
		$lineInString = $lineInArray[0];
		preg_match ("/[0-9]{1,2}\/[01]?[0-9]\/[0-9]{4}/",$lineInString, $dateMatches);
		preg_match ("/[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}/",$lineInString, $timeMatches);
		$formattedDate = implode('-', array_reverse(explode('/', $dateMatches[0])));
		return $formattedDate . ' ' . $timeMatches[0]; 
	}
	
	function extractNumberMethod($matchPattern) {
		$lineInArray = array_values($matchPattern);
		$lineInString = $lineInArray[0];
		$lineArray = explode(':', $lineInString);
		$partieDroite = trim($lineArray[1]);
		$nomEtNumero = explode('- N°', $partieDroite);
		$numero = intval(substr(trim($nomEtNumero[1]), 0, strlen(trim($nomEtNumero[1]))-1));
		return $numero;
	}
	
	function parseData() {
		$number = $this->extractValue("/^Le Troll Ciblé/", 'extractNumberMethod');
		$publicInfos = $this->getPublicInfos($number);
		$dateCompilation = $this->extractValue("/Date/", 'extractDateMethod');
		if ($dateCompilation == null) {
			$dateCompilation = $this->extractValue("/^Il était/", 'extractDateMethod');
		}
		
		$this->infosTroll = array(
			'numero' => $number,
			'nom' => $publicInfos['nom'],
			'race' => $publicInfos['race'],
			'numero_guilde' => $publicInfos['numero_guilde'],
			'guilde' => $publicInfos['guilde'],
			'niveau' => $this->extractValue("/^Niveau/", 'extractSimpleMethod'),
			'vie' => $this->extractValue("/^Points de Vie/", 'extractParenthesisMethod'),
			'attaque' => $this->extractValue("/Attaque/", 'extractParenthesisMethod'),
			'esquive' => $this->extractValue("/Esquive/", 'extractParenthesisMethod'),
			'degats' => $this->extractValue("/Dégât/", 'extractParenthesisMethod'),
			'regeneration' => $this->extractValue("/Régénération/", 'extractParenthesisMethod'),
			'armure' => $this->extractValue("/^Armure/", 'extractParenthesisMethod'),
			'vue' => $this->extractValue("/^Vue/", 'extractParenthesisMethod'),
			'date_compilation' => $dateCompilation,
		);
		
	}

	function getInfosTroll() {
		return $this->infosTroll;
	}
	
	function getPublicInfos($numero) {
		$pathToPublicFiles = dirname(__FILE__).'/../txt/';
		$publicInfos = array();
		$handle = @fopen($pathToPublicFiles.'Public_Trolls.txt', "r");
		if ($handle) {
   			while (!feof($handle)) {
     			$line = fgets($handle);
     			$trollInfosArray = explode(';', $line);
     			if ($numero == intval($trollInfosArray[0])) {
     				$publicInfos['nom'] = $trollInfosArray[1];
     				$publicInfos['race'] = $trollInfosArray[2];
     				$publicInfos['numero_guilde'] = $trollInfosArray[6];
	     			break;
    	 		}
	   		}
		}
   		fclose($handle);
   		
   		if ('1' == $publicInfos['numero_guilde']) {
   			$publicInfos['guilde'] = '-';
   		}
   		else {
   			$handle = @fopen($pathToPublicFiles.'Public_Guildes.txt', "r");
			if ($handle) {
	   			while (!feof($handle)) {
     				$line = fgets($handle);
     				$trollInfosArray = explode(';', $line);
     				if ($publicInfos['numero_guilde'] == intval($trollInfosArray[0])) {
	     				$publicInfos['guilde'] = $trollInfosArray[1];
	     				break;
    	 			}
	   			}
			}
   			fclose($handle);
   		}
   		return $publicInfos;
	}
	
}
?>
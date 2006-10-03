<?php

class Parser {

	var $infosTroll;

	function Parser($content) {
		$infosTroll = array();
		$contentArray = explode("\n", stripslashes($content));
		foreach($contentArray AS $entireLine) {
			switch (true) {
				case (ereg("^Expéditeur", $entireLine)):
					preg_match ("/[0-9]{1,2}\/[01]?[0-9]\/[0-9]{4}/",$entireLine, $dateMatches);
					preg_match ("/[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}/",$entireLine, $timeMatches);
					$formattedDate = implode('-', array_reverse(explode('/', $dateMatches['0'])));
					$infosTroll['date_compilation'] = $formattedDate . ' ' . $timeMatches['0']; 
   				break;
				case (ereg("^Le Troll Ciblé", $entireLine)):
   					$lineArray = explode(':', $entireLine);
   					$nomEtNumeroEnLigne = trim($lineArray[1]);
   					$tableauNomEtNumero = explode('- N°', $nomEtNumeroEnLigne);
   					$infosTroll['nom'] = trim($tableauNomEtNumero[0]);
   					$infosTroll['numero'] = intval(substr(trim($tableauNomEtNumero[1]), 0, strlen(trim($tableauNomEtNumero[1]))-1));
       			break;
   				case (ereg("^Niveau", $entireLine)):
   					$lineArray = explode(':', $entireLine);
   					$infosTroll['niveau'] = intval(trim($lineArray[1]));
       			break;
   				case (ereg("^Points de Vie", $entireLine)):
   					$infosTroll['vie'] = $this->extractFieldValueFrom($entireLine);
       			break;
       			case (ereg("^Dés d'Attaque", $entireLine)):
   					$infosTroll['attaque'] = $this->extractFieldValueFrom($entireLine);
       			break;
       			case (ereg("^Dés d'Esquive", $entireLine)):
   					$infosTroll['esquive'] = $this->extractFieldValueFrom($entireLine);
       			break;
       			case (ereg("^Dés de Dégât", $entireLine)):
   					$infosTroll['degats'] = $this->extractFieldValueFrom($entireLine);
       			break;
       			case (ereg("^Dés de Régénération", $entireLine)):
   					$infosTroll['regeneration'] = $this->extractFieldValueFrom($entireLine);
       			break;
       			case (ereg("^Armure", $entireLine)):
       				$infosTroll['armure'] = $this->extractFieldValueFrom($entireLine);
	   			break;
       			case (ereg("^Vue", $entireLine)):
   					$infosTroll['vue'] = $this->extractFieldValueFrom($entireLine);
       			break;
       			
  				default:
       		}
   		}
		$infosTroll['race'] = 'Inconnue';
		$this->infosTroll = $infosTroll;
	}
	
	function extractFieldValueFrom($line) {
		$lineArray = explode(':', $line);
		$lineWithParenthesis = trim($lineArray[1]);
		preg_match('/\(.*\)/', $lineWithParenthesis, $matches);
		$fieldValue = substr($matches[0], 1, $matches[0]-1);
		return $fieldValue;
	}
	
	function getInfosTroll() {
		return $this->infosTroll;
	}
}
?>
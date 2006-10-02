<?php

class Parser {

	var $infosTroll;

	function Parser($fileName) {
		if (!file_exists($fileName)) {
			trigger_error('error: file not found');
		}
		else {
			$infosTroll = array();
			$fileDescriptor = fopen($fileName, "r");
			while (!feof($fileDescriptor)) {
     			$entireLine = fgets($fileDescriptor, 4096);
				switch (true) {
					case (ereg("^Le Troll Ciblé", $entireLine)):
   						$lineArray = explode(':', $entireLine);
   						$nomEtNumeroEnLigne = trim($lineArray[1]);
   						$tableauNomEtNumero = explode('- N°', $nomEtNumeroEnLigne);
   						$infosTroll['nom'] = trim($tableauNomEtNumero[0]);
   						$infosTroll['numero'] = intval(substr(trim($tableauNomEtNumero[1]), 0, strlen(trim($tableauNomEtNumero[1]))-1));
       				break;
   					case (ereg("^Niveau", $entireLine)):
   						$infosTroll['niveau'] = intval($this->extractFieldValueFrom($entireLine));
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
   			fclose($fileDescriptor);
   			
   			$this->infosTroll = $infosTroll;
   		}
	}
	
	function extractFieldValueFrom($line) {
		$lineArray = explode(':', $line);
   		return trim($lineArray[1]);
	}
	
	function getInfosTroll() {
		return $this->infosTroll;
	}

}

?>
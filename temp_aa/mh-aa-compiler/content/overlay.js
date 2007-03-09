var messageMountyHallUrl = 'http://games.mountyhall.com/mountyhall/messagerie/viewmessage';
var urlToSendAnalyse = "http://localhost/temp_aa/web/resultat_ajout_AA.php";

window.addEventListener("load", mainEventListener, true);

function getURL() {
  var wm = Components.classes["@mozilla.org/appshell/window-mediator;1"].
           getService(Components.interfaces.nsIWindowMediator);
  var recentWindow = wm.getMostRecentWindow("navigator:browser");
  return recentWindow ? recentWindow.content.document.location : null;
}

function showData(elementName) {
	var botMessageDocument = window.content.document;
	elements = botMessageDocument.getElementsByTagName(elementName);
	buffer = "";
	buffer += "nombre de " + elementName + ": " + elements.length + "\n";
	for (i = 0; i < elements.length; i++)
		buffer += elements[i] + "\n";
	
	alert(buffer);
}

function addButtonToBodyDocument() {
	var botMessageDocument = window._content.document;
	
	if( !botMessageDocument.getElementById('AAButton') ) {
		var firstTable = botMessageDocument.getElementsByTagName("table")[0];

		var messageTitle = firstTable.childNodes[1].childNodes[0].childNodes[1].childNodes[0].childNodes[1].firstChild.nodeValue;
		if(messageTitle.indexOf('[MountyHall] Sort AA')!=-1) {
			var form = botMessageDocument.getElementsByTagName("form")[0];
			form.setAttribute('action', urlToSendAnalyse);
			
			var htmlPageCopy = firstTable.childNodes[1].childNodes[8].childNodes[1].innerHTML;
			var analyseToSend = htmlPageCopy.replace(/<br>/g, "\n");
			var existingCloseButton = botMessageDocument.getElementsByName('bClose')[0];

			var unsecableSpace = botMessageDocument.createTextNode(' ');
			firstTable.childNodes[1].childNodes[10].childNodes[1].insertBefore(unsecableSpace, existingCloseButton);

			var sendAAButton = botMessageDocument.createElement('input');
			sendAAButton.setAttribute('type', 'submit');
			sendAAButton.setAttribute('class', 'mh_form_submit');
			sendAAButton.setAttribute('id', 'AAButton');
			sendAAButton.setAttribute('value', "Envoyer l'analyse au compilateur");
			sendAAButton.setAttribute('onmouseover', "this.style.cursor='pointer'");
			firstTable.childNodes[1].childNodes[10].childNodes[1].insertBefore(sendAAButton, unsecableSpace);
			
			var hiddenStorageField = botMessageDocument.createElement('input');
			hiddenStorageField.setAttribute('type', 'hidden');
			hiddenStorageField.setAttribute('name', 'aa');
			hiddenStorageField.setAttribute('value', analyseToSend);
			firstTable.childNodes[1].childNodes[10].childNodes[1].insertBefore(hiddenStorageField, unsecableSpace);
		}
	}
}

function mainEventListener() {
	var currentUrl = getURL().toString().toLowerCase();
	if (currentUrl.indexOf(messageMountyHallUrl) != -1) {
		addButtonToBodyDocument();	
	}
}
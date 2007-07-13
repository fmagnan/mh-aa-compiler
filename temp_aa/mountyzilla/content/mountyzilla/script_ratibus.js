// Configuration
var pageVueURL = '/mountyhall/MH_Play/Play_vue.php';
var pageCdmURL = '/mountyhall/MH_Play/Actions/Competences/Play_a_Competence16b.php';
var pageCdmRecord = 'http://trolls.game-host.org/mountyhall/cdm_record.php';
var pageMessageBot = '/mountyhall/Messagerie/ViewMessageBot.php';
var pageCdmInfos = 'http://trolls.game-host.org/mountyhall/cdm.php';

var tresorsConfig = new Array();
tresorsConfig['gg'] = new Array();
tresorsConfig['gg']['libelleTableau'] = 'Gigots de Gob';
tresorsConfig['comp'] = new Array();
tresorsConfig['comp']['libelleTableau'] = 'Composant';
tresorsConfig['bid'] = new Array();
tresorsConfig['bid']['libelleTableau'] = 'Bidouille';
tresorsConfig['potion'] = new Array();
tresorsConfig['potion']['libelleTableau'] = 'Potion';
tresorsConfig['arme'] = new Array();
tresorsConfig['arme']['libelleTableau'] = 'Arme';
tresorsConfig['armure'] = new Array();
tresorsConfig['armure']['libelleTableau'] = 'Armure';

// Variables globales
var bodyVue;
var documentVue;
var totaltab;
var x_monstres;
var x_trolls;
var x_tresors;
var x_lieux;

// Détection de la page de vue
if( window.self.location.toString().indexOf(pageVueURL)!=-1 ) {
	traitementPageDeVue(window.self);
} else if( window.self.location.toString().indexOf(pageCdmURL)!=-1 ) {
	traitementPageCdm(window.self);
} else if( window.self.location.toString().indexOf(pageMessageBot)!=-1 ) {
	traitementPageMessageBot(window.self);
}

function traitementPageMessageBot(win) {
	var documentBotCdm = win.document;
	if (!documentBotCdm || !("body" in documentBotCdm)) {
		return false;
	}
	
	var bodyBotCdm = documentBotCdm.body;
	
	if( !documentBotCdm.getElementById('CdmButton') ) {
		var table = documentBotCdm.getElementsByTagName('table')[0];
		
		var messageTitle = table.childNodes[1].childNodes[0].childNodes[1].childNodes[0].childNodes[1].firstChild.nodeValue;
		
		if(messageTitle.indexOf('MountyHall] CdM sur')==-1) { // Ce message du bot n'est pas un message de CdM
			return false;
		}
		
		// Récupération de la CdM
		var cdmHTML = table.childNodes[1].childNodes[8].childNodes[1].innerHTML;
		var cdm = cdmHTML.replace(/<br>/g, "\n");
				
		var espace = documentBotCdm.createTextNode('        > > > > > > > > > >        ');
		var myButton = documentBotCdm.createElement('input');
		myButton.setAttribute('type', 'button');
		myButton.setAttribute('class', 'mh_form_submit');
		myButton.setAttribute('id', 'CdmButton');
		myButton.setAttribute('value', "Participer au bestiaire");
		myButton.setAttribute('onmouseover', "this.style.cursor='pointer'");
		myButton.setAttribute('onclick', "window.open('" + pageCdmRecord + "?cdm=" + escape(cdm) + "', 'popupCdm', 'width=400, height=240, toolbar=no, status=no, location=no, resizable=yes'); this.value='Merci de votre participation'; this.disabled = true;");
		
		table.childNodes[1].childNodes[10].childNodes[1].insertBefore(espace, documentBotCdm.getElementsByName('bClose')[0]);
		table.childNodes[1].childNodes[10].childNodes[1].insertBefore(myButton, espace);
	}
	
	return true;
}

function traitementPageCdm(win) {
	var documentCdm = win.document;
	if (!documentCdm || !("body" in documentCdm)) {
		return false;
	}
	
	var bodyCdm = documentCdm.body;
	
	if( !documentCdm.getElementById('CdmButton') ) {
	
		var form = documentCdm.getElementsByName('ActionForm')[0];
	
		if(form.innerHTML.indexOf('RÉUSSI')==-1) { // La connaissance des monstres a échoué
			return false;
		}
		var cdm = form.childNodes[3];
		var tableauCdm = cdm.childNodes[1].firstChild;
	
		// Construction de la chaine de Cdm
		// Monstre
		var cdmTexte = cdm.firstChild.firstChild.nodeValue + "\n";
	
		// Niveau
		cdmTexte += "Niveau : " + tableauCdm.childNodes[0].childNodes[1].childNodes[0].firstChild.nodeValue + "\n";
		// Points de vie
		cdmTexte += "Points de Vie : " + tableauCdm.childNodes[1].childNodes[1].childNodes[0].firstChild.nodeValue + "\n";
		// Attaque
		cdmTexte += "Dés d'Attaque : " + tableauCdm.childNodes[3].childNodes[1].childNodes[0].firstChild.nodeValue + "\n";
		// Esquive
		cdmTexte += "Dés d'Esquive : " + tableauCdm.childNodes[4].childNodes[1].childNodes[0].firstChild.nodeValue + "\n";
		// Degats
		cdmTexte += "Dés de Dégat : " + tableauCdm.childNodes[5].childNodes[1].childNodes[0].firstChild.nodeValue + "\n";
		// Regeneration
		cdmTexte += "Dés de Régénération : " + tableauCdm.childNodes[6].childNodes[1].childNodes[0].firstChild.nodeValue + "\n";
		// Armure
		cdmTexte += "Armure : " + tableauCdm.childNodes[7].childNodes[1].childNodes[0].firstChild.nodeValue + "\n";
		// Vue
		cdmTexte += "Vue : " + tableauCdm.childNodes[8].childNodes[1].childNodes[0].firstChild.nodeValue + "\n";

		if(tableauCdm.childNodes[9]) { // Il n'y a pas toujours de capacité 
			// Capacite
			cdmTexte += "Capacité spéciale : " + tableauCdm.childNodes[9].childNodes[1].childNodes[0].firstChild.nodeValue + "\n";
		}
		
		var espace = documentCdm.createTextNode('        > > > > > > > > > >        ');
		var myButton = documentCdm.createElement('input');
		myButton.setAttribute('type', 'button');
		myButton.setAttribute('class', 'mh_form_submit');
		myButton.setAttribute('id', 'CdmButton');
		myButton.setAttribute('value', "Participer au bestiaire");
		myButton.setAttribute('onmouseover', "this.style.cursor='pointer'");
		myButton.setAttribute('onclick', "window.open('" + pageCdmRecord + "?cdm=" + escape(cdmTexte) + "', 'popupCdm', 'width=400, height=240, toolbar=no, status=no, location=no, resizable=yes'); this.value='Merci de votre participation'; this.disabled = true;");
		
		form.childNodes[5].insertBefore(espace, documentCdm.getElementsByName('as_Action')[0]);
		form.childNodes[5].insertBefore(myButton, espace);
	}
	
	return true;
}

function traitementPageDeVue(win) {
	documentVue = win.document;
	if (!documentVue || !("body" in documentVue)) {
		return false;
	}
	
	// Enregistrement de la variable globale
	bodyVue = documentVue.body;
    	
	totaltab=documentVue.getElementsByTagName('table');
	x_monstres = totaltab[4].childNodes[0].childNodes;
	x_trolls = totaltab[5].childNodes[0].childNodes;
	x_tresors = totaltab[6].childNodes[0].childNodes;
	x_lieux = totaltab[8].childNodes[0].childNodes;
	
	if( !documentVue.getElementById('vue2DForm') ) {
	
		// On crée le bouton pour la vue 2d
		var myForm = documentVue.createElement('form');
		myForm.setAttribute('method', 'post');
		myForm.setAttribute('accept-charset', 'iso-8859-1, iso-8859-15');
		myForm.setAttribute('action', 'http://trolls.game-host.org/mountyhall/vue_form.php');
		myForm.setAttribute('name', 'frmvue');
		myForm.setAttribute('target', '_blank');
		myForm.setAttribute('id', 'vue2DForm');
		
		var myTA = documentVue.createElement('input');
		myTA.setAttribute('type', 'hidden');
		myTA.setAttribute('name', 'vue');
		myTA.setAttribute('wrap', 'off');
		myTA.setAttribute('id', 'vueField');
		myTA.setAttribute('value', getVueScript2());
		myForm.appendChild(myTA);
		
		myTA = documentVue.createElement('input');
		myTA.setAttribute('type', 'hidden');
		myTA.setAttribute('name', 'screen_width');
		myTA.setAttribute('value', screen.width);
		myForm.appendChild(myTA);
		
		myTA = documentVue.createElement('input');
		myTA.setAttribute('type', 'hidden');
		myTA.setAttribute('name', 'mode');
		myTA.setAttribute('value', 'vue_SP_Vue2');
		myForm.appendChild(myTA);
		
		myTA = documentVue.createElement('input');
		myTA.setAttribute('type', 'submit');
		myTA.setAttribute('class', 'mh_form_submit');
		myTA.setAttribute('value', "La Vue 2D des Bricol\' Trolls");
		myTA.setAttribute('onmouseover', "this.style.cursor='pointer'");
		myTA.setAttribute('style', 'margin:3px');
		myForm.appendChild(myTA);
		
		var arr = documentVue.getElementsByTagName('a');
		arr[7].parentNode.appendChild(documentVue.createElement('br'));
		arr[7].parentNode.appendChild(myForm);
		
		// Affichage du lien vers le bestiaire
		var newLinkText;
		var newLink;
		for (var i=2;i<x_monstres.length;i++) {
			espace = documentVue.createTextNode('   =>   ');
			newLinkText = documentVue.createTextNode('CdM');
			newLink = documentVue.createElement('a');
			newLink.appendChild(newLinkText);
			newLink.setAttribute('class', 'mh_trolls_0');
			newLink.setAttribute('href', pageCdmInfos + '?monstre='+x_monstres[i].childNodes[2].childNodes[0].firstChild.nodeValue);
			newLink.setAttribute('onclick', "window.open(this.href, 'popupCdm', 'width=600, height=400, toolbar=no, status=no, location=no, resizable=yes, scrollbars=yes'); return false;");
			newLink.setAttribute('target', '\"_blank\"');
			x_monstres[i].childNodes[2].appendChild(espace);
			x_monstres[i].childNodes[2].appendChild(newLink);
		}
	}

	return true;
}

function deleteMonstres(element) {
	if(!bodyVue.innerHTML) return;

	var from = (arguments.length>2) ? arguments[2] : '';
	
	_deleteTable(element, 4, from);
}

function deleteTrolls(element) {
	if(!bodyVue.innerHTML) return;

	var from = (arguments.length>2) ? arguments[2] : '';
	
	_deleteTable(element, 5, from);
}

function deleteTresors(element) {
	if(!bodyVue.innerHTML) return;

	var from = (arguments.length>2) ? arguments[2] : '';
	
	_deleteTable(element, 6, from);
}

function deleteChampignons(element) {
	if(!bodyVue.innerHTML) return;

	var from = (arguments.length>2) ? arguments[2] : '';
	
	_deleteTable(element, 7, from);
}

function deleteLieux(element) {
	if(!bodyVue.innerHTML) return;

	var from = (arguments.length>2) ? arguments[2] : '';
	
	_deleteTable(element, 8, from);
}

function _deleteTable(element, table, from) {
	
	// If the menu is checked
	var display;
	if(element.getAttribute("checked")) {
		display = 'none';
	} else if(from=='mountyhallCheckAndParse' ) {
		return;
	} else {
		display = '';
	}
	
	documentVue.getElementsByTagName('table')[table].style.display = display;
}

function deleteTresorsCategorie(element, type) {

	if(!tresorsConfig[type] || !bodyVue.innerHTML) return;
	
	var from = (arguments.length>2) ? arguments[2] : '';

	x_tresors = bodyVue.getElementsByTagName('table')[6].childNodes[0].childNodes;

	// If the menu is checked
	var display;
	if(element.getAttribute("checked")) {
		display = 'none';
	} else if(from=='mountyhallCheckAndParse' ) {
		return;
	} else {
		display = '';
	}
    	
	for (var i=2;i<x_tresors.length;i++) {
		if(x_tresors[i].className == 'mh_tdpage'
			&& x_tresors[i].childNodes.length==6
			&& x_tresors[i].childNodes[2].childNodes[0].innerHTML.indexOf(tresorsConfig[type]['libelleTableau'])!=-1) {
			
			x_tresors[i].style.display = display;
		}
	}
}

function getVueScript() {

	var maChaine = "#DEBUT TROLLS\n"
	var arrtable;
	var malade;
	var tr;
	arrtable = totaltab[5];
	for(i=2;i<arrtable.childNodes[0].childNodes.length;i++) {
		tr = arrtable.childNodes[0].childNodes[i];
		malade = '-';
		if(tr.childNodes[2].childNodes.length>2) {
			malade = 'Malade';
		}
		maChaine += tr.childNodes[1].childNodes[0].nodeValue+";"+tr.childNodes[6].childNodes[0].nodeValue+";"+tr.childNodes[7].childNodes[0].nodeValue+";"+tr.childNodes[8].childNodes[0].nodeValue+";"+malade+"\n";
	}
	maChaine += "#FIN TROLLS\n#DEBUT MONSTRES\n";
	arrtable = totaltab[4];
	for(i=2;i<arrtable.childNodes[0].childNodes.length;i++) {
		tr = arrtable.childNodes[0].childNodes[i];
		maChaine += tr.childNodes[1].childNodes[0].nodeValue+";"+tr.childNodes[2].childNodes[0].childNodes[0].nodeValue+";"+tr.childNodes[3].childNodes[0].nodeValue+";"+tr.childNodes[4].childNodes[0].nodeValue+";"+tr.childNodes[5].childNodes[0].nodeValue+"\n";
	}
	maChaine += "#FIN MONSTRES\n#DEBUT TRESORS\n";
	arrtable = totaltab[6];
	for(i=2;i<arrtable.childNodes[0].childNodes.length;i++) {
		tr = arrtable.childNodes[0].childNodes[i];
		maChaine += tr.childNodes[1].childNodes[0].nodeValue+";"+tr.childNodes[2].childNodes[0].childNodes[0].nodeValue+";"+tr.childNodes[3].childNodes[0].nodeValue+";"+tr.childNodes[4].childNodes[0].nodeValue+";"+tr.childNodes[5].childNodes[0].nodeValue+"\n";
	}
	maChaine += "#FIN TRESORS\n#DEBUT LIEUX\n";
	arrtable = totaltab[8];
	for(i=2;i<arrtable.childNodes[0].childNodes.length;i++) {
		tr = arrtable.childNodes[0].childNodes[i];
		maChaine += tr.childNodes[1].childNodes[0].nodeValue+";"+tr.childNodes[2].childNodes[0].nodeValue+";"+tr.childNodes[3].childNodes[0].nodeValue+";"+tr.childNodes[4].childNodes[0].nodeValue+";"+tr.childNodes[5].childNodes[0].nodeValue+"\n";
	}
	maChaine += "#FIN LIEUX\n#DEBUT CHAMPIGNONS\n";
	arrtable = totaltab[7];
	for(var i=2;i<arrtable.childNodes[0].childNodes.length;i++) {
		tr = arrtable.childNodes[0].childNodes[i];
		maChaine += tr.childNodes[1].childNodes[0].nodeValue+";"+tr.childNodes[2].childNodes[0].nodeValue+";"+tr.childNodes[3].childNodes[0].nodeValue+";"+tr.childNodes[4].childNodes[0].nodeValue+";"+tr.childNodes[5].childNodes[0].nodeValue+"\n";
	}
	maChaine += "#FIN CHAMPIGNONS\n";
	return maChaine;
}

function getVueScript2() {
	var arrtable=totaltab[3];
	var pos=arrtable.getElementsByTagName('li')[0].innerHTML;
	var posx=pos.substring(pos.indexOf('=')+2,pos.indexOf(','));
	pos=pos.substr(pos.indexOf(',')+1);
	var posy=pos.substring(pos.indexOf('=')+2,pos.indexOf(','));
	var posn=pos.substring(pos.lastIndexOf('=')+2,pos.lastIndexOf('</b>'));
	pos=arrtable.getElementsByTagName('li')[2].innerHTML;
	var vue=pos.substring(pos.indexOf('à<b>')+5,pos.indexOf('cases')-1);
	return getVueScript()+"#DEBUT ORIGINE\n"+vue+";"+posx+";"+posy+";"+posn+"\n#FIN ORIGINE\n";
}

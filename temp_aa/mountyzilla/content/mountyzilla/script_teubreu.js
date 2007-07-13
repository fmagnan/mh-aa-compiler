/*********************************************************************************
*    This file is part of Mountyzilla.                                           *
*                                                                                *
*    Mountyzilla is free software; you can redistribute it and/or modify         *
*    it under the terms of the GNU General Public License as published by        *
*    the Free Software Foundation; either version 2 of the License, or           *
*    (at your option) any later version.                                         *
*                                                                                *
*    Foobar is distributed in the hope that it will be useful,                   *
*    but WITHOUT ANY WARRANTY; without even the implied warranty of              *
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the               *
*    GNU General Public License for more details.                                *
*                                                                                *
*    You should have received a copy of the GNU General Public License           *
*    along with Mountyzilla; if not, write to the Free Software                  *
*    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA  *
*********************************************************************************/


// Configuration
var pageVueURL = 'http://'+MHURL+'/mountyhall/MH_Play/Play_vue.php';
var pageProfilURL = 'http://'+MHURL+'/mountyhall/MH_Play/Play_profil.php';
var pageOptionURL = 'http://'+MHURL+'/mountyhall/MH_Play/Options/Play_o_Interface.php';
var pageCdmURL = 'http://'+MHURL+'/mountyhall/MH_Play/Actions/Competences/Play_a_Competence16b.php';
var pageMessageBot = 'http://'+MHURL+'/mountyhall/Messagerie/ViewMessageBot.php';
var pageNews = 'http://'+MHURL+'/mountyhall/MH_Play/Play_news.php';
var pagePackURL = 'http://'+MHURL+'/mountyhall/installPack.php';
var attaqueURL = 'http://'+MHURL+'/mountyhall/MH_Play/Actions/Play_a_Attack.php';
var combatURL = 'http://'+MHURL+'/mountyhall/MH_Play/Actions/Play_a_Combat.php';
var diploURL ='http://'+MHURL+'/mountyhall/MH_Guildes/Guilde_o_AmiEnnemi.php';
var lieuURL = 'http://'+MHURL+'/mountyhall/MH_Lieux/Lieu_Description.php';
var menuURL= 'http://'+MHURL+'/mountyhall/MH_Play/Play_menu.php';
var autresURL = 'http://'+MHURL+'/mountyhall/MH_Play/Actions';
var pageTanEquip = 'http://'+MHURL+'/mountyhall/MH_Taniere/TanierePJ_o_Stock.php';
var pageComEquip = 'http://'+MHURL+'/mountyhall/MH_Comptoirs/Comptoir_o_Stock.php';
var pageSacEquip = 'http://'+MHURL+'/mountyhall/MH_Play/Play_e_ChampComp.php';
var pageEquip = 'http://'+MHURL+'/mountyhall/MH_Play/Play_equipement.php';
var pageEvent = 'http://'+MHURL+'/mountyhall/View/PJView.php';

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
	traitementVue(window.self);
} else if( window.self.location.toString().indexOf(pageProfilURL) != -1) {
	traitementProfil(window.self);
} else if( window.self.location.toString().indexOf(pageOptionURL) != -1 ||  window.self.location.toString().indexOf(pagePackURL) != -1) {
	traitementOption(window.self);
} else if( window.self.location.toString().indexOf(pageCdmURL)!=-1 ) {
	traitementPageCdm(window.self);
} else if( window.self.location.toString().indexOf(pageEvent)!=-1 ) {
        traitementPageEvent(window.self);
} else if( window.self.location.toString().indexOf(pageMessageBot)!=-1 ) {
	traitementPageMessageBot(window.self);
} else if( window.self.location.toString().indexOf(pageNews)!=-1 ) {
        traitementNews(window.self);
} else if( window.self.location.toString().indexOf(pageEquip)!=-1 ) {
        traitementEquip(window.self);
} else if( window.self.location.toString().indexOf(attaqueURL)!=-1 ) {
        traitementAttaque(window.self);
} else if( window.self.location.toString().indexOf(diploURL)!=-1 ) {
        traitementDiplo(window.self);
} else if( window.self.location.toString().indexOf(lieuURL)!=-1 ) {
        traitementLieu(window.self);
} else if( window.self.location.toString().indexOf(combatURL)!=-1 ) {
        traitementCombat(window.self);
} else if( window.self.location.toString().indexOf(menuURL)!=-1 ) {
        traitementMenu(window.self);
} else if( window.self.location.toString().indexOf(pageTanEquip)!=-1 || window.self.location.toString().indexOf(pageComEquip)!=-1) {
        traitementPageTanEquip(window.self);
} else if( window.self.location.toString().indexOf(pageSacEquip)!=-1 ) {
	traitementPageSacEquip(window.self);
} else if( window.self.location.toString().indexOf(autresURL)!=-1 ) {
        traitementRM(window.self);
}

function pausecomp(Amount)
{
	d = new Date() //today's date
	while (1)
	{
		mill=new Date() // Date Now
		diff = mill-d //difference in milliseconds
		if( diff > Amount ) {break;}
	}
}

function chargerScript( win, script ) {
        var aList = win.document.getElementsByTagName( 'A' );

        if( !win.document.getElementById( 'monScript' ) ) {
                var newScript = win.document.createElement( 'script' );
                newScript.setAttribute( 'language', 'JavaScript' );
                newScript.setAttribute( 'id', 'monScript' );
                newScript.setAttribute( 'src', script );

                (aList[aList.length-1]).parentNode.appendChild( newScript );
        }
}

function traitementRM(win)
{
	chargerScript(win,"http://mountyzilla.tilk.info/scripts/rm_FF.js");
	return true;
}

function traitementNews(win)
{
	chargerScript(win,"http://echoduhall.free.fr/Echo/tilk.php3");
	return true;
}

function traitementPageEvent(win)
{
        chargerScript(win,"http://mountyzilla.tilk.info/scripts/event_FF.js");
        return true;
}


function traitementAttaque(win)
{
	chargerScript(win,"http://mountyzilla.tilk.info/scripts/attaque_FF.js");
	return true;
}

function traitementMenu(win)
{
	chargerScript(win,"http://mountyzilla.tilk.info/scripts/menu_FF.js");
	return true;
}

function traitementEquip(win)
{
	chargerScript(win,"http://mountyzilla.tilk.info/scripts/equip_FF.js");
	return true;
}

function traitementCombat(win)
{
	chargerScript(win,"http://mountyzilla.tilk.info/scripts/combat_FF.js");
	return true;
}

function traitementPageTanEquip(win)
{
	chargerScript(win,"http://mountyzilla.tilk.info/scripts/tancompo_FF.js");
        return true;
}

function traitementPageSacEquip(win)
{
        chargerScript(win,"http://mountyzilla.tilk.info/scripts/saccompo_FF.js");
        return true;
}

function traitementProfil(win) {
	chargerScript(win,'http://mountyzilla.tilk.info/scripts/profil_FF.js');
}

function traitementVue(win) {
	chargerScript(win,'http://mountyzilla.tilk.info/scripts/vue_FF.js');
	return true;
}

function traitementOption(win) {
	chargerScript(win,'http://mountyzilla.tilk.info/scripts/option_FF.js');
	return true;
}

function traitementPageMessageBot(win) {
	chargerScript(win,'http://mountyzilla.tilk.info/scripts/cdmbot_FF.js');
	return true;
}

function traitementPageCdm(win) {
	chargerScript(win,'http://mountyzilla.tilk.info/scripts/cdmcomp_FF.js');
	return true;
}

function traitementLieu(win)
{
	chargerScript(win,"http://mountyzilla.tilk.info/scripts/lieu_FF.js");
	return true;
}

function traitementDiplo(win) {
	chargerScript(win,'http://mountyzilla.tilk.info/scripts/diplo_FF.js');
	return true;
}



function trim( string ) {
   return string.replace(/(^\s*)|(\s*$)/g,'');
}

function str_woa( str ) {
        str = str.replace( /[éèêë]/g, 'e');
        str = str.replace( /[àâä]/g, 'a' );
        str = str.replace( /[ùûü]/g, 'u' );
        str = str.replace( /[ïî]/g, 'i' );
        str = str.replace( /[öô]/g, 'o' );

        return str;
}

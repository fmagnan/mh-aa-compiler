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

// Loads preferences into the UI.
var defaultURL = "chrome://mountyzilla/content/script_teubreu.js";

function loadPrefWindow() {

	try {
		var prefObj = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefService);
		var Branch = prefObj.getBranch("mountyzilla.");
		var Enabled = !Branch.prefHasUserValue("enabled") || Branch.getBoolPref("enabled"); // default:true
		var ShowUpdate = !Branch.prefHasUserValue("showupdate") || Branch.getBoolPref("showupdate");
		var fileURL = Branch.prefHasUserValue("fileURL") ? Branch.getCharPref("fileURL") : defaultURL;
 		var enablebox = document.getElementById("enabled");
		enablebox.checked = Enabled;
		var updatebox = document.getElementById("showupdate");
		updatebox.checked = ShowUpdate;
		var url = document.getElementById("newScript");
		url.value = fileURL;
	} catch(e) {alert(e)}
}

function findfile() {
	var fp = Components.classes["@mozilla.org/filepicker;1"].createInstance(Components.interfaces.nsIFilePicker);
	
	fp.init(window, "Sélectionnez un script", fp.modeOpen);
	fp.appendFilter("Java Script","*.js");
	fp.appendFilter("Tous","*");

	if (fp.show() != fp.returnCancel) {
		var url = document.getElementById("newScript");
		url.value = fp.fileURL.spec;
	}
}
function setDefault() {
	var url = document.getElementById("newScript");
	url.value = defaultURL;
}

// Save the settings and close the window.
function saveSettings() {
	var prefObj = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefService);
	var Branch = prefObj.getBranch("mountyzilla.");
	
	var enablebox = document.getElementById("enabled");
	Branch.setBoolPref("enabled", enablebox.checked);
	
	var updatebox = document.getElementById("showupdate");
	Branch.setBoolPref("showupdate", updatebox.checked);
	
	var newScript = document.getElementById("newScript");
	Branch.setCharPref("fileURL",newScript.value);
	
	window.close(); // close out. -- triggers an 'onclose' handler to call "loadSettings()" *in the overlay*
}

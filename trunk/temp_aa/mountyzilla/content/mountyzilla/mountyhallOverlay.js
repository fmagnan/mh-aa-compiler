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




function mountyhallDisplayCheck() {
        setTimeout("mountyhallCheckAndParse()", 100);
        return true;
}

function mountyhallCheckAndParse(win) {
	try {	
        var prefObj = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefService);
        var Branch = prefObj.getBranch("mountyzilla.");
        var Enabled = !Branch.prefHasUserValue("enabled") || Branch.getBoolPref("enabled"); // default:true
        var ShowUpdate = !Branch.prefHasUserValue("showupdate") || Branch.getBoolPref("showupdate"); // default:true
        var fileURL = Branch.prefHasUserValue("fileURL") ? Branch.getCharPref("fileURL") : "chrome://mountyzilla/content/script_teubreu.js";
        var MHURL = Branch.prefHasUserValue("serveur") ? Branch.getCharPref("serveur") : "games.mountyhall.com";
        } catch(e) {alert(e);}
	if (!win) {
		// This appears to only highlight the current tab.
		// Rather than grab _content we can get the window
		// itself and highlight all the tabs at once.
		//
		//win = window._content;
		win = window.self;
	}
	if(!Enabled)
	{
		return true;
	}
	for (var i = 0; win.frames && i < win.frames.length; i++) {
                mountyhallCheckAndParse(win.frames[i]);
        }
	if(win.location.toString().toLowerCase().indexOf("http://"+MHURL)==0)
	{
		if(!win.document.getElementById('idScript'))
		{	
			var ioService=Components.classes["@mozilla.org/network/io-service;1"].getService(Components.interfaces.nsIIOService);
		        var scriptableStream=Components.classes["@mozilla.org/scriptableinputstream;1"].getService(Components.interfaces.nsIScriptableInputStream);
        		var channel=ioService.newChannel(fileURL,null,null);
                	var input=channel.open();
	                scriptableStream.init(input);
	        	var str=scriptableStream.read(-1);
        	        scriptableStream.close();
	        	input.close();
			var aList=win.document.getElementsByTagName('html');
			var newScript = win.document.createElement('script');
			newScript.setAttribute('language','JavaScript');
			newScript.appendChild(win.document.createTextNode("var MHURL='"+MHURL+"';"));
			(aList[0]).appendChild(newScript);
			newScript = win.document.createElement('script');
			newScript.setAttribute('language','JavaScript');
			newScript.setAttribute('id','idScript');
			newScript.appendChild(win.document.createTextNode(str));
                        (aList[0]).appendChild(newScript);
		}
		if(ShowUpdate && win.location.toString().toLowerCase().indexOf("http://"+MHURL+"/mountyhall/mh_play/play_news.php")==0 && !win.document.getElementById('idScript_Version'))
		{
			var aList=win.document.getElementsByTagName('html');
			var newScript = win.document.createElement('script');
			newScript.setAttribute('language','JavaScript');
			newScript.setAttribute('id','idScript_Version');
			newScript.appendChild(win.document.createTextNode("var numVersionMountyzilla='0.7.1';"));
			(aList[0]).appendChild(newScript);
			newScript = win.document.createElement('script');
			newScript.setAttribute('language','JavaScript');
			newScript.setAttribute('src','http://mountyzilla.tilk.info/extension/update.js');
			(aList[0]).appendChild(newScript);
		}
	}
	return true;
}

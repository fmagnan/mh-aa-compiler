function EnterPJView(IdCible){
	var url = 'http://games.mountyhall.com/mountyhall/View/PJView.php?ai_IDPJ='+IdCible;
	window.open(url,'DetailView','width=750,height=550,toolbar=0,location=0,directories=0,status=0,menubar=0,resizable=1,scrollbars=1');
}

function EnterAllianceView(IdCible){
	var url = "http://games.mountyhall.com/mountyhall/View/AllianceView.php?ai_IDAlliance=" + IdCible;
	window.open(url,"DetailView",'width=750,height=550,toolbar=0,location=0,directories=0,status=0,menubar=0,resizable=1,scrollbars=1');
}
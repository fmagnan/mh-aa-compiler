<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	 	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	 	<link rel="stylesheet" type="text/css" href="css/screen.css" media="screen" title="Normal" />
	</head>
	<body>
		<script language="JavaScript" src="js/functions_MH.js"></script>
		<h2>Tous les Trolls</h2>
		<table id="tous_les_trolls">
 			<tr>
 				<th>N°</th>
 				<th>Nom</th>
 				<th>Race</th>
 				<th>Niveau</th>
 				<th>Guilde</th>
			</tr>
 				{section name=tout loop=$trolls}
 				<tr>
  					<td><a href="#" onClick="EnterPJView({$trolls[tout].numero});">{$trolls[tout].numero}</a></td>
  					<td><a href="index.php?id={$trolls[tout].numero}">{$trolls[tout].nom}</a></td>
  					<td>{$trolls[tout].race}</td>
  					<td>{$trolls[tout].niveau}</td>
  					<td><a href="#" onClick="EnterAllianceView({$trolls[tout].numero_guilde});">{$trolls[tout].guilde}</a></td>
  				<tr>
 				{/section}
		</table>
		{if isset($id)}
			<div id="fiche_troll">
				<ul>
					<li><strong>Numéro : </strong>{$ficheTroll.numero}</li>
					<li><strong>Nom : </strong>{$ficheTroll.nom}</li>
					<li><strong>Race : </strong>{$ficheTroll.race}</li>
					<li><strong>Guilde : </strong>{$ficheTroll.guilde} -- ({$ficheTroll.numero_guilde})</li>
					<li><strong>Niveau : </strong>{$ficheTroll.niveau}</li>
					<li><strong>Points de vie : </strong>{$ficheTroll.vie}</li>
					<li><strong>Dés d'Attaque : </strong>{$ficheTroll.attaque}</li>
					<li><strong>Dés d'Esquive : </strong>{$ficheTroll.esquive}</li>
					<li><strong>Dés de Dégâts : </strong>{$ficheTroll.degats}</li>
					<li><strong>Dés de Régénération : </strong>{$ficheTroll.regeneration}</li>
					<li><strong>Armure : </strong>{$ficheTroll.armure}</li>
					<li><strong>Vue : </strong>{$ficheTroll.vue}</li>
				</ul>
			</div>
		{/if}
	</body>
</html>
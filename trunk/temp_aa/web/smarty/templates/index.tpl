<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	 	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	 	<link rel="stylesheet" type="text/css" href="/AA/web/css/screen.css" media="screen" title="Normal" />
	</head>
	<body>
		<h2>Tous les Trolls</h2>
		<table id="tous_les_trolls">
 			<tr>
 				<th>N°</th>
 				<th>Nom</th>
 				<th>Race</th>
 				<th>Niveau</th>
 				<th>PV</th>
 				<th>ATT</th>
 				<th>ESQ</th>
 				<th>DEG</th>
 				<th>REG</th>
 				<th>ARM</th>
 				<th>VUE</th>
			</tr>
 				{section name=tout loop=$trolls}
 				<tr>
  					<td>{$trolls[tout].numero}</td>
  					<td>{$trolls[tout].nom}</td>
  					<td>{$trolls[tout].race}</td>
  					<td>{$trolls[tout].niveau}</td>
  					<td>{$trolls[tout].vie}</td>
  					<td>{$trolls[tout].attaque}</td>
  					<td>{$trolls[tout].esquive}</td>
  					<td>{$trolls[tout].degats}</td>
  					<td>{$trolls[tout].regeneration}</td>
  					<td>{$trolls[tout].armure}</td>
  					<td>{$trolls[tout].vue}</td>
  				<tr>
 				{/section}
		</table>
	</body>
</html>
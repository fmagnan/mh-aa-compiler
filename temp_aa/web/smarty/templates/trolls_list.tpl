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
  			<td><a name="{$trolls[tout].numero}" href="#" onClick="EnterPJView({$trolls[tout].numero});">{$trolls[tout].numero}</a></td>
  			<td><a href="index.php?id={$trolls[tout].numero}#{$trolls[tout].numero}">{$trolls[tout].nom}</a></td>
  			<td>{$trolls[tout].race}</td>
  			<td>{$trolls[tout].niveau}</td>
  			<td><a href="#" onClick="EnterAllianceView({$trolls[tout].numero_guilde});">{$trolls[tout].guilde}</a></td>
  		</tr>
 	{/section}
</table>
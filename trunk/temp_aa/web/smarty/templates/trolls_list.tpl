<table id="tous_les_trolls">
	<tr>
 		<th>N°
			<a href="index.php?fieldSort=numero&typeSort=ASC"><img src="images/fleche_bas.png" /></a>
			<a href="index.php?fieldSort=numero&typeSort=DESC"><img src="images/fleche_haut.png" /></a>
 		</th>
 		<th>Nom
			<a href="index.php?fieldSort=nom&typeSort=ASC"><img src="images/fleche_bas.png" /></a>
 			<a href="index.php?fieldSort=nom&typeSort=DESC"><img src="images/fleche_haut.png" /></a>
 		</th>
 		<th>Race
			<a href="index.php?fieldSort=race&typeSort=ASC"><img src="images/fleche_bas.png" /></a>
			<a href="index.php?fieldSort=race&typeSort=DESC"><img src="images/fleche_haut.png" /></a>
		</th>
 		<th>Niveau
			<a href="index.php?fieldSort=niveau&typeSort=ASC"><img src="images/fleche_bas.png" /></a>
			<a href="index.php?fieldSort=niveau&typeSort=DESC"><img src="images/fleche_haut.png" /></a>
		</th>
 		<th>
 			Guilde
			<a href="index.php?fieldSort=guilde&typeSort=ASC"><img src="images/fleche_bas.png" /></a>
 			<a href="index.php?fieldSort=guilde&typeSort=DESC"><img src="images/fleche_haut.png" /></a>
 		</th>
	</tr>
 	{section name=tout loop=$trolls}
 		{if $smarty.section.tout.index is even}
   			<tr class="even">
		{else}
   			<tr class="odd">
		{/if}
			<td class="numero">
				<a name="{$trolls[tout].numero}" href="#" onClick="EnterPJView({$trolls[tout].numero});">{$trolls[tout].numero}</a>
			</td>
  			<td>
  				<a href="index.php?fieldSort={$fieldSort}&typeSort={$typeSort}&id={$trolls[tout].numero}">{$trolls[tout].nom}</a>
  			</td>
  			<td class="race">{$trolls[tout].race}</td>
  			<td class="niveau">{$trolls[tout].niveau_actuel}</td>
  			<td><a href="#" onClick="EnterAllianceView({$trolls[tout].numero_guilde});">{$trolls[tout].guilde}</a></td>
  		</tr>
 	{/section}
</table>
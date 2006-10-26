<table class="cadre" id="tous_les_trolls">
	<tr class="haut">
		<th class="coin_haut_gauche"></th>
 		<th class="bandeau_haut_gauche">N°
			<a href="index.php?fieldSort=numero&typeSort=ASC"><img src="images/fleche_bas.png" /></a>
			<a href="index.php?fieldSort=numero&typeSort=DESC"><img src="images/fleche_haut.png" /></a>
 		</th>
 		<th class="bandeau_haut_gauche">Nom
			<a href="index.php?fieldSort=nom&typeSort=ASC"><img src="images/fleche_bas.png" /></a>
 			<a href="index.php?fieldSort=nom&typeSort=DESC"><img src="images/fleche_haut.png" /></a>
 		</th>
 		<th class="bandeau_haut_gauche">Race
			<a href="index.php?fieldSort=race&typeSort=ASC"><img src="images/fleche_bas.png" /></a>
			<a href="index.php?fieldSort=race&typeSort=DESC"><img src="images/fleche_haut.png" /></a>
		</th>
 		<th class="bandeau_haut_gauche">Niveau
			<a href="index.php?fieldSort=niveau_actuel&typeSort=ASC"><img src="images/fleche_bas.png" /></a>
			<a href="index.php?fieldSort=niveau_actuel&typeSort=DESC"><img src="images/fleche_haut.png" /></a>
		</th>
 		<th class="bandeau_haut_gauche">
 			Guilde
			<a href="index.php?fieldSort=guilde&typeSort=ASC"><img src="images/fleche_bas.png" /></a>
 			<a href="index.php?fieldSort=guilde&typeSort=DESC"><img src="images/fleche_haut.png" /></a>
 		</th>
 		<th class="bandeau_haut_droit"></th>
		<th class="coin_haut_droit"></th>
	</tr>
 	{section name=tout loop=$trolls}
 		{if $smarty.section.tout.index is even}
   			<tr class="centre even">
		{else}
   			<tr class="centre odd">
		{/if}
			<td class="bandeau_gauche"></td>
			<td class="numero fond">
				<a name="{$trolls[tout].numero}" href="#" onClick="EnterPJView({$trolls[tout].numero});">{$trolls[tout].numero}</a>
			</td>
  			<td class="fond">
  				<a href="index.php?fieldSort={$fieldSort}&typeSort={$typeSort}&id={$trolls[tout].numero}">{$trolls[tout].nom}</a>
  			</td>
  			<td class="race  fond">{$trolls[tout].race}</td>
  			<td class="niveau  fond">{$trolls[tout].niveau_actuel}</td>
  			<td class="fond" colspan="2"><a href="#" onClick="EnterAllianceView({$trolls[tout].numero_guilde});">{$trolls[tout].guilde}</a></td>
  			<td class="bandeau_droit"></td>
  		</tr>
 	{/section}
 	<tr class="bas">
		<td class="coin_bas_gauche"></td>
		<td class="bandeau_bas" colspan="6"></td>
		<td class="coin_bas_droit"></td>
	</tr>
</table>
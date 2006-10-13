<table id="tous_les_trolls">
	<tr>
 		<th><a href="index.php?fieldSort=numero&typeSort={$typeSort}">N°</a></th>
 		<th><a href="index.php?fieldSort=nom&typeSort={$typeSort}">Nom</a></th>
 		<th><a href="index.php?fieldSort=race&typeSort={$typeSort}">Race</a></th>
 		<th><a href="index.php?fieldSort=niveau&typeSort={$typeSort}">Niveau</a></th>
 		<th><a href="index.php?fieldSort=guilde&typeSort={$typeSort}">Guilde</a></th>
	</tr>
 	{section name=tout loop=$trolls}
 		{if $smarty.section.tout.index is even}
   			<tr class="even">
		{else}
   			<tr class="odd">
		{/if}
			<td class="numero"><a name="{$trolls[tout].numero}" href="#" onClick="EnterPJView({$trolls[tout].numero});">{$trolls[tout].numero}</a></td>
  			<td><a href="index.php?fieldSort={$fieldsort}&typeSort={$typeSort}&id={$trolls[tout].numero}#{$trolls[tout].numero}">{$trolls[tout].nom}</a></td>
  			<td>{$trolls[tout].race}</td>
  			<td>{$trolls[tout].niveau}</td>
  			<td><a href="#" onClick="EnterAllianceView({$trolls[tout].numero_guilde});">{$trolls[tout].guilde}</a></td>
  		</tr>
 	{/section}
</table>
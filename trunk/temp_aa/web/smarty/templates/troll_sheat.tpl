{if isset($id)}
	<form id="fiche_troll" method="post">
		<ul>
			<li><strong>Numéro : </strong>{$ficheTroll.numero}</li>
			<li><strong>Nom : </strong>{$ficheTroll.nom}</li>
			<li><strong>Race : </strong>{$ficheTroll.race}</li>
			<li><strong>Guilde : </strong>{$ficheTroll.guilde} -- ({$ficheTroll.numero_guilde})</li>
			<li><strong>Niveau au moment de l'analyse : </strong>{$ficheTroll.niveau}</li>
			<li><strong>Niveau Actuel : </strong>{$ficheTroll.niveau_actuel}</li>
			<li><strong>Points de vie : </strong>{$ficheTroll.vie}</li>
			<li><strong>Dés d'Attaque : </strong>{$ficheTroll.attaque}</li>
			<li><strong>Dés d'Esquive : </strong>{$ficheTroll.esquive}</li>
			<li><strong>Dés de Dégâts : </strong>{$ficheTroll.degats}</li>
			<li><strong>Dés de Régénération : </strong>{$ficheTroll.regeneration}</li>
			<li><strong>Armure : </strong>{$ficheTroll.armure}</li>
			<li><strong>Vue : </strong>{$ficheTroll.vue}</li>
			<li>
				<strong>Sortilèges : </strong>
				{if isset($aucunSortConnu)}
					{$aucunSortConnu}
				{else}
					<ul>
					{section name=sortilegesConnus loop=$sortilegesConnus}
						<li>{$sortilegesConnus[$smarty.section.sortilegesConnus.index]}</li>
					{/section}
					</ul>
				{/if}
			</li>
		</ul>
		<select name="ajout_sortilege">
			{section name=sortileges loop=$sortileges}
				<option>{$sortileges[$smarty.section.sortileges.index]}</option>
			{/section}
		</select>
		<input type="submit" name="ajout_sort" value="Ajouter un sortilège" />
		<input type="hidden" name="numero" value="{$ficheTroll.numero}">
		<input type="hidden" name="id" value="{$id}">
		<input type="hidden" name="typeSort" value="{$typeSort}">
		<input type="hidden" name="fieldSort" value="{$fieldSort}">
	</form>
{/if}
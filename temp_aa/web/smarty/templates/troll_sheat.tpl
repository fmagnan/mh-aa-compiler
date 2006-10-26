{if isset($id)}
	<table class="cadre" id="fiche_troll">
		<tr class="haut">
			<th class="coin_haut_gauche"></th>
			<th class="bandeau_haut_gauche"></th>
			<th class="bandeau_haut_droit"></th>
			<th class="coin_haut_droit"></th>
		</tr>
		<tr class="centre">
			<td class="bandeau_gauche"></td>
			<td class="fond" colspan="2">
				<form method="post">
					<ul>
						<li><strong>{$ficheTroll->getNom()}</strong> ({$ficheTroll->getNumero()}) -- {$ficheTroll->getRace()} {$ficheTroll->getNiveauActuel()}</li>
						<li><strong>Points de vie : </strong>{$ficheTroll->getVie()}</li>
						<li><strong>Dés d'Attaque : </strong>{$ficheTroll->getAttaque()}</li>
						<li><strong>Dés d'Esquive : </strong>{$ficheTroll->getEsquive()}</li>
						<li><strong>Dés de Dégâts : </strong>{$ficheTroll->getDegats()}</li>
						<li><strong>Dés de Régénération : </strong>{$ficheTroll->getRegeneration()}</li>
						<li><strong>Armure : </strong>{$ficheTroll->getArmure()}</li>
						<li><strong>Vue : </strong>{$ficheTroll->getVue()}</li>
						<br />
						<li><strong>Guilde : </strong>{$ficheTroll->getGuilde()}</li>
						<li><strong>Niveau au moment de l'analyse : </strong>{$ficheTroll->getNiveau()}</li>
						<li><strong>Age de l'analyse : </strong>{$ageAnalyse}</li>
						<li>
							<strong>Sortilèges : </strong>
							{if !is_array($sortilegesConnus)}
								{$sortilegesConnus}
							{else}
								<ul>
								{section name=sortilegesConnus loop=$sortilegesConnus}
									<li>
										{$sortilegesConnus[$smarty.section.sortilegesConnus.index]}
										<a href="index.php?action=delete&sortilege={$sortilegesConnus[$smarty.section.sortilegesConnus.index]}&id={$id}&typeSort={$typeSort}&fieldSort={$fieldSort}">
											<img src="images/supprime_sort.png" />
										</a>
									</li>
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
					<input type="hidden" name="id" value="{$id}">
					<input type="hidden" name="typeSort" value="{$typeSort}">
					<input type="hidden" name="fieldSort" value="{$fieldSort}">
				</form>
			</td>
			<td class="bandeau_droit"></td>
		</tr>
		<tr class="bas">
			<td class="coin_bas_gauche"></td>
			<td class="bandeau_bas" colspan="2"></td>
			<td class="coin_bas_droit"></td>
		</tr>
	</table>
	{/if}
{if isset($id)}
	<div id="fiche_troll">
		<form method="post">
			<ul>
				<li>
					<a href="#" onClick="EnterPJView({$ficheTroll->getNumero()});">{$ficheTroll->getNom()}</a>
					({$ficheTroll->getNumero()}) -- {$ficheTroll->getRace()} {$ficheTroll->getNiveauActuel()}
				</li>
				<li><strong>Points de vie : </strong>{$ficheTroll->getVie()}</li>
				<li><strong>Dés d'Attaque : </strong>{$ficheTroll->getAttaque()}</li>
				<li><strong>Dés d'Esquive : </strong>{$ficheTroll->getEsquive()}</li>
				<li><strong>Dés de Dégâts : </strong>{$ficheTroll->getDegats()}</li>
				<li><strong>Dés de Régénération : </strong>{$ficheTroll->getRegeneration()}</li>
				<li><strong>Armure : </strong>{$ficheTroll->getArmure()}</li>
				<li><strong>Vue : </strong>{$ficheTroll->getVue()}</li>
				<br />
				<li>
					<a href="#" onClick="EnterAllianceView({$ficheTroll->getNumeroGuilde()});">{$ficheTroll->getNomGuilde()}</a>
					-- ({$ficheTroll->getNumeroGuilde()})
				</li>
				<li><strong>Niveau au moment de l'analyse : </strong>{$ficheTroll->getNiveau()}</li>
				<li><strong>Age de l'analyse : </strong>{$ageAnalyse}</li>
				<li>
					<strong>Sortilèges : </strong>
					{if !is_array($sortilegesConnus)}
						{$sortilegesConnus}
					{else}
						<ul>
							{foreach item=clef_sort from=$sortilegesConnus}
								<li>
									{$sortileges[$clef_sort]}
									<a href="index.php?action=delete&sortilege={$clef_sort}&id={$id}&typeSort={$typeSort}&fieldSort={$fieldSort}">
										<img src="images/supprime_sort.png" />
									</a>
								</li>
							{/foreach}
						</ul>
					{/if}
				</li>
			</ul>
			<select name="ajout_sortilege">
				{foreach key=clef_sort item=nom_sort from=$sortileges}
					<option value="{$clef_sort}">{$nom_sort}</option>
				{/foreach}
			</select>
			<br />
			<input type="submit" name="ajout_sort" value="Ajouter un sortilège" />
			<input type="hidden" name="id" value="{$id}">
			<input type="hidden" name="typeSort" value="{$typeSort}">
			<input type="hidden" name="fieldSort" value="{$fieldSort}">
		</form>
	</div>
{/if}
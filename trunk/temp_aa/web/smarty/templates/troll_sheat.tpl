{if isset($id)}
	<ul id="fiche_troll">
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
{/if}
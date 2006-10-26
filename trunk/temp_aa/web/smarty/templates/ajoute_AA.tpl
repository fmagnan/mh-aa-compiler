<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	{include file='header.tpl'}
	<body>
		{include file='top_banner.tpl'}
		{include file='menu.tpl'}
		<h3>{$messageResultat}</h3>
		{if isset($logContent)}
			<div class="log_result">
				<pre>{$logContent}</pre>
			</div>
		{/if}
		<form method="post">
			<fieldset id="ajout_AA">
				<legend>Message du Bot</legend>
				<textarea name="aa"></textarea>
				<br />
				<input type="submit" name="valider" value="Valider" />
			</fieldset>
		</form>
	</body>
</html>
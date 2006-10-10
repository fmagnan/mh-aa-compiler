<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	{include file='header.tpl'}
	<body>
		{include file='menu.tpl'}
		{if $logContent != ""}
			<div class="log_result">
				<pre>{$logContent}</pre>
			</div>
		{/if}
		<form method="post">
			<fieldset>
				<legend>Message du Bot</legend>
				<textarea name="aa" rows="10" cols="60"></textarea>
				<br />
				<input type="submit" name="valider" value="Valider" />
			</fieldset>
		</form>
		<h3>{$messageResultat}</h3> 
	</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	 	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	 	<link rel="stylesheet" type="text/css" href="css/screen.css" media="screen" title="Normal" />
	</head>
	<body>
		<h2>{$messageResultat}</h2>
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
	</body>
</html>
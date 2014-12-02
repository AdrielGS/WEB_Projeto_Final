<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo URL; ?>">
	<meta charset="UTF-8">
	<title>INF</title>
</head>
<body>
	<form id="login" method="POST" action="home/login">
		<label>Login: <input type="text" name="login" placeholder="Digite seu login" /></label><br>
		<label>Senha: <input type="password" name="pass" placeholder="Digite sua senha" /></label>
		<input type="submit" value="Entrar">
	</form>
	<?php 
		if(!empty($error)):
	?>
	<div id="error">
		<?php echo $error; ?>
	</div>
	<?php
		endif;
	?>
</body>
</html>
<?php
	include PAGES.'header.php';
	$login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
?>	
	<style>
		article > form {
			display: block;
			margin: 10px auto;
			width: 400px;
		}
		form > input {
			font-family: 'Segoe UI';
			width: 100%;
			height: 30px;
			margin: 5px auto;
			padding: 0px 7px;
		}
		form > input[type=submit] {
			width: 104%;
			background: #3F51B5;
			border: 1px solid #5C6BC0;
			border-radius: 3px;
			color: white;
			box-shadow: 0px 0px 7px 0px rgba(0,0,0,.3);
		}
	</style>
	<article>
		<form id="login" method="POST" action="home/login">
			<input type="text" name="login" placeholder="Digite seu login" value="<?php echo $login; ?>" /><br>
			<input type="password" name="pass" placeholder="Digite sua senha" /><br>
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
	</article>
<?php
	include PAGES.'footer.php';
?>
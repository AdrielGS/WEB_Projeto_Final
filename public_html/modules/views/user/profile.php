<?php
	include PAGES.'header.php';
	include PAGES.'user/sidebar.php';
?>
	<style>
		article > div {
			padding:25px;
		}
		article > div > img {
			float:left;
			width:80px;
			height:80px;
			border-radius:100%;
			margin-right:20px;
			box-shadow:0px 0px 6px 0px rgba(0,0,0,.6);
		}
	</style>
	<article>
		<div>
			<img src="images/user.png">
			<?php
				if(!empty($user)){
					echo '<div>Nome: <span>'.$user->name.'</span></div>';
					echo '<div>Registro: <span>'.$user->regNumber.'</span></div>';
					echo '<div>Email: <span>'.$user->email.'</span></div>';
					echo '<div>Turma: <span>'.$user->class.'</span></div>';
				}
			?>
		</div>
	</article>
<?php
	include PAGES.'footer.php';
?>
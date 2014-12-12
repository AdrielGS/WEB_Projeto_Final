<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	<title>INF</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="js/js.js"></script>
	<?php
		$username = isset($user->name) ? $user->name : "Lucas C. Felicíssimo";
	?>
</head>
<body>
	<nav>
		<div id="menu">
			<div id="menuIcon">
				<span></span>
				<span></span>
				<span></span>
			</div>
			<h2 id="title">Início</h2>
			<div id="menuLinks">
				<a href="home">Início</a>
				<a href="#">Mural</a>
				<a href="#">Aplicativos</a>
				<a href="#">Repositório de fotos</a>
				<a href="#">Cabaçalho de provas</a>
				<a href="questoes">Banco de questões</a>
				<a href="#">Correções</a>
				<a href="#">Calendário</a>
				<a href="#">Fórum</a>
				<a href="#">Chat</a>
				<a href="home/logout">Logout</a>
			</div>
		</div>
		<div id="logo"></div>
		<div id="user">
			<img id="userPhoto"
				src="http://dummyimage.com/50x50/FF9800/FFF.png
				&text=<?php echo strtoupper($username[0])?>">
			<span><?php echo $username; ?></span>
		</div>
	</nav>
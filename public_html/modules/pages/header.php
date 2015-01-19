<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo URL; ?>">
	<meta charset="UTF-8">
	<title>INF</title>
	<link rel="stylesheet" href="css/style.css">
	<!-- <script src="js/js.js"></script> -->
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function(){
			
			links = menuLinks.getElementsByTagName('a');
			divMenuTitle = document.getElementById('menuTitle');
			menuLinks = document.getElementById('menuLinks');

			// ---------- CONFIGURAR TITULO DO MENU SUPERIOR
			function attTitle(){
				url = window.location.pathname.split('/');
				controller = !url[3] || url[3] == '' ? 'home' : url[3];
				
				for(i=0;i<links.length;i++){
					if(links[i].getAttribute('href') == controller){
						divMenuTitle.innerHTML = links[i].innerHTML;	
					}
				}
			}
			attTitle();

			// ---------- CONFIGURAR CLASS MENU LATERAL
			subMenu = document.getElementsByTagName('aside')[0];
			subMenuLinks = subMenu.getElementsByTagName('a');
			function attSidebar(){
				url = window.location.pathname.split('/');
				controller = !url[2] || url[2] == '' ? 'home' : url[2];
				action = !url[3] || url[3] == '' ? 'home' : url[3];

				for(i=0; i<subMenuLinks.length; i++){
					if(subMenuLinks[i].getAttribute('href') == controller+'/'+action){
						subMenuLinks[i].className = 'active';
						if(subMenuLinks[i].parentNode.className == 'subMenu'){
							subMenuLinks[i].parentNode.className = 'subMenuActive';
						}
					}
				}
			}
			attSidebar();

			function activate(obj){
				if (obj.className.search('Active') > 0)
					obj.className = obj.className.replace('Active', '');
				else
					obj.className += 'Active';
			}

			subMenus = document.getElementsByClassName('subMenu');
			for (var i = 0; i < subMenus.length; i++){
				subMenus[i].addEventListener('click', function(){
					activate(this);
				});
			}

			document.querySelector('.userMenu').addEventListener('click', function(){
				activate(this);
			});

		});
	</script>
	<?php
		$username = isset($user->name) ? $user->name : "Convidado";
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
			<h2 id="menuTitle"></h2>
			<div id="menuLinks">
				<a href="home">Início</a>
				<a href="user">Usuário</a>
				<a href="mural">Mural</a>
				<a href="aplicativos">Aplicativos</a>
				<a href="fotos">Repositório de fotos</a>
				<a href="provas">Cabaçalho de provas</a>
				<a href="questoes">Banco de questões</a>
				<a href="correcoes">Correções</a>
				<a href="calendario">Calendário</a>
				<a href="forum">Fórum</a>
				<a href="chat">Chat</a>
			</div>
		</div>
		<div id="logo"></div>
		<!-- <img src="images/logo.svg" id="logo"> -->
		<div id="user" class="userMenu">
			<img id="userPhoto"
				src="http://dummyimage.com/50x50/FF9800/FFF.png
				&text=<?php echo strtoupper($username[0])?>">
			<span><?php echo $username; ?></span>		
			<?php if ($username != 'Convidado')
				echo '<div>
						<a href="user">Perfil</a>
						<a href="user/notifications">Notificações</a>
						<a href="home/logout">Sair</a>
					</div>'; ?>
		</div>
	</nav>
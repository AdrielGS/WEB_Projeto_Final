<?php
	$title = (!empty($title) ? ' - '.$title : '');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<base href="<?php echo URL; ?>">
	<title>INF<?php echo $title; ?></title>
	
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function(){
			url = window.location.pathname.split('/');
			action = !url[3] || url[3] == '' ? 'home' : url[3];
			links = document.body.childNodes[1].childNodes[1].getElementsByTagName('a');
			for(i=0;i<links.length;i++){
				if(links[i].getAttribute('href') == action){
					links[i].classList.add('active');
				}
			}
		});
	</script>
	<style type="text/css">
		a:link,a:visited{text-decoration:none;}

		body{
			margin:43px 0px 0px 0px;
			padding:0px;
			font:normal 12px Verdana, Arial, sans-serif;
		}

		body > nav{
			background:#f7f7f7;
			background:-moz-linear-gradient(#F6F6F6,#E5E5E5);
			background:-webkit-linear-gradient(#F6F6F6,#E5E5E5);
			background:-ms-linear-gradient(#F6F6F6,#E5E5E5);
			position:fixed;
			top:0px;
			width:100%;
			overflow:hidden;
			box-shadow:0px 0px 5px rgba(0,0,0,.5);
		}

		nav > nav{
			width:100%;
			max-width:900px;
			overflow:hidden;
			float:center;
			margin:0px auto;
		}

		nav > a{
			display:block;
			float:left;
			padding:12px;
			color:#000;
		}

		nav > a:hover, nav > .active{
			background:#5ee;
			background:-moz-linear-gradient(#5ee,#2dd);
			background:-webkit-linear-gradient(#5ee,#2dd);
			background:-ms-linear-gradient(#5ee,#2dd);
		}

		nav > a:last-child{
			float:right;
			background:#ff7072;
			background:-moz-linear-gradient(#ff7072,#ff4c4f);
			background:-webkit-linear-gradient(#ff7072,#ff4c4f);
			background:-ms-linear-gradient(#ff7072,#ff4c4f);
			font-weight:bold;
		}

		nav > a:last-child:active{
			background:#ff4c4f;
			background:-moz-linear-gradient(#ff4c4f,#ff7072);
			background:-webkit-linear-gradient(#ff4c4f,#ff7072);
			background:-ms-linear-gradient(#ff4c4f,#ff7072);
		}

		*{
			-webkit-transition:	all .4s ease;
			-moz-transition: all .4s ease;
			-o-transition: all .4s ease;
			transition: all .4s ease;
		}
	</style>
</head>
<body>
<nav>
	<nav>
		<a href="home">Home</a>
		<a href="example/example">Exemplo</a>
		<a href="home/logout">Sair</a>
	</nav>
</nav>
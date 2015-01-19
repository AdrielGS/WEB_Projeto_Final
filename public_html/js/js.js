document.addEventListener('DOMContentLoaded', function(){
	url = window.location.pathname.split('/');
	controller = !url[3] || url[3] == '' ? 'home' : url[3];

	list = document.getElementById('menuLinks');
	links = list.getElementsByTagName('a');

	menu = document.getElementById('menu');
	menuTitle = document.getElementById('title');

	for(i=0;i<links.length;i++){
		if(links[i].getAttribute('href') == controller){
			menuTitle.innerHTML = links[i].innerHTML;	
		}
	}

	/*for(i=0;i<links.length;i++){
		links[i].addEventListener('click', function(){
			if( this.href.indexOf('127.0.0.1') != -1 ){
				event.preventDefault();
			}
		});
	}*/

	document.addEventListener('click', function(){
		if( !hasParent(event.target, userLogo) && userLogo.className == 'active'){
			statsUserMenu();
		}
	});

	userMenu = document.getElementById('userMenu');
	userLogo = document.getElementById('userLogo');
	userLogo.addEventListener('click', statsUserMenu);

	function statsUserMenu(){
		if(userLogo.className == 'active'){
			userLogo.removeAttribute('class');
		}else{
			userLogo.className = 'active';
		}
	}

	function hasParent(initial, parent){
		while(initial != document.body){
			if(initial == parent){
				return true;
			}else{
				initial = initial.parentNode;
			}
		}
		return false;
	}

	function goTo(link){

	}
});
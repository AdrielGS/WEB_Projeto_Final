function getSelected(){
	var value = ";" + document.cookie;
	var parts = value.split(";selecteds=");
	if (parts.length == 2) 
		strSelected = parts.pop().split(";").shift();

	j = 0;
	for (var i = 0; i < 3; i++) {
		document.getElementById('type' + (i + 1) ).checked = 
			strSelected.charAt(j++)=='0' ? false : true;
		document.getElementById('difficulty' + (i + 1) ).checked = 
			strSelected.charAt(j++)=='0' ? false : true;
	}
	document.getElementById('subject').value = strSelected.substring(6, strSelected.lenght);
	document.cookie = 'selecteds=000000Todas;expires=0';
}

function setSelected(){
	var strSelected = '';
	for (var i = 1; i < 4; i++) {
		strSelected += document.getElementById("type" + i).checked ? '1' : '0';
		strSelected += document.getElementById("difficulty" + i).checked ? '1' : '0';
	}
	strSelected += document.getElementById('subject').value;
	document.cookie = 'selecteds='+strSelected+';expires=0';
}

document.addEventListener('DOMContentLoaded', function(){
	getSelected();
});

function iniciaAjax() { 
	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	return xmlhttp; 
}

function deleteQuestion(n){
	var question;
	decisão = confirm("Voce tem certeza que quer deletar a questão?");
	if (decisão) {
		ajax = iniciaAjax();
		if(ajax) {
			document.getElementById("q" + n).remove ();
			ajax.open("GET", "questoes/delete/" + n, false);
			ajax.send();
			alert('Deletada com sucesso');
		}
		
	}
	
}

function update(q,v,a,typeId,id,id_answer) {
	decisão = confirm("Voce tem certeza que quer alterar a questão?");
	if(decisão) {
		var correct = [];
		var j = 0;
		question = document.q.value;
		value = document.v.value;
		answers = document.a.value;
		for(i = 0; i<answers.lenght; i++) {
			if(answers[i].checked) {
				correct[j] = answers[i];
				j++;
			}
		}
		type_id = document.typeId.value;
		ajax = iniciaAjax();
		if(ajax) {
			ajax.open("GET", "questoes/update/" + question + "/" + value + "/" + correct + "/" + id + "/" + id_answer + "/" + type, false);
			ajax.send();
			alert('Alterada com sucesso');
		}
	}
}

function updateOpen(q,v,a,id,id_answer)  {
	decisão = confirm("Voce tem certeza que quer alterar a questão?");
	if(decisão) {
		question = document.q.value;
		value = document.v.value;
		answer = document.a.value;
		ajax = iniciaAjax();
		if(ajax) {
			ajax.open("GET", "questoes/update/" + question + "/" + value + "/" + answer + "/" + id + "/" + id_answer, false);
			ajax.send();
			alert('Alterada com sucesso');
		}
	}
}
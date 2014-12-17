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
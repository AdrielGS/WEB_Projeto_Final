var i = 0;
var y = 0;
var type_id = 0;
var a = "";

primeiraOpcao = true;

function setType(x){
  if (type_id == x || type_id == 0)
    primeiraOpcao = false;
  else
    primeiraOpcao = true;

  type_id = x;
}

function createOptions(){
  //type_id = getType();

  switch(type_id){
    case "1":
      if (primeiraOpcao == true){
        for (var j = 1; j <= i; j++) 
          document.getElementById("option" + j).outerHTML = "";
        primeiraOpcao = false;
        i = 0;
      }
      i++;
     /* if (i == 1) {
        a = "<tr><td>Introdução: </td><td colspan='3'><input type='text' id='introduction' name='introduction'></td></tr>";
      }
      else{*/
      a = "<tr id='option"+i+"'><td></td><td colspan='2'>P: <input type='text' id ='opt"+i+"' ></td>" + 
        "<td colspan='2' id='option'>R: <input type = 'text' name = 'answer_op' id ='answer_op"+i+"'> </td></tr> ";
     // }
      break;

     case "2":
      if (primeiraOpcao == true){
        for (var j = 1; j <= i; j++) 
          document.getElementById("option" + j).outerHTML = "";
        primeiraOpcao = false;
        i = 0;
      }
      i++;
      a = "<tr id='option"+i+"'><td></td><td colspan='4'><input type = 'text' id ='opt"+i+"'>" + 
      "<input type = 'radio' name = 'answer_mc' id ='answer_mc"+i+"'> </td></tr> " ;
      break;

     case "3":
      if (primeiraOpcao == true){
        for (var j = 1; j <= i; j++) 
          document.getElementById("option" + j).outerHTML = "";
        primeiraOpcao = false;
        i = 0;
      }
      i++;
      a = "<tr id='option"+i+"'><td></td><td colspan='4'><input type = 'text' id ='opt"+i+"'>" + 
      "<input type = 'checkbox' name = 'answer_tf' id ='answer_tf"+i+"'> </td></tr> " ;
      break;
   }

   document.getElementById("table").insertAdjacentHTML('beforeEnd', a);
 }

function addTag(value){
  if (value == 'add') {
    document.getElementById('subject').innerHTML = 'Adicionar materia.';
    var txt = "<td colspan='3'><input type = 'text' id = 'newTag' onchange='changeTitle(this.value)'> </td>";
    document.getElementById("select_subject").insertAdjacentHTML('afterEnd', txt);
  }
  // MARRETA ! 
  else{
    if(document.getElementById("newTag")){
      document.getElementById("newTag").outerHTML = "";
    }
  }
}

function changeTitle(title){
  document.getElementById('subject').innerHTML = title;
}
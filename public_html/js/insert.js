

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
      a = "<tr id='option"+i+"' >" + 
      "<td></td>" + 
      "<td colspan='2' align='center'>" + 
        "P: <input type='text' id ='opt"+i+"' name='opt"+i+"' value='"+i+"'>" + 
      "</td>" + 
      "<td colspan='1' id='option' align='center'>" + 
        "R: <input type = 'text' name='answer_op"+i+"' id='answer_op"+i+"'>" + 
      "</td></tr> ";
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
      a = "<tr id='option"+i+"'>" + 
      "<td></td>" + 
      "<td colspan='3'> " + 
        "<input type = 'text' id ='opt"+i+"' name='opt"+i+"' value='"+i+"'>" + 
        "<input type = 'radio' id='answer_mc' name='answer_mc' value='"+i+"'>" + 
      "</td></tr>";
      break;

     case "3":
      if (primeiraOpcao == true){
        for (var j = 1; j <= i; j++) 
          document.getElementById("option" + j).outerHTML = "";
        primeiraOpcao = false;
        i = 0;
      }
      i++;
      a = "<tr id='option"+i+"'>" +
      "<td></td>" +
      "<td colspan='3'>" + 
        "<input type = 'text' id ='tf"+i+"' name='tf"+i+"' value='"+i+"'>" + 
        "<input type = 'checkbox' id ='answer_tf"+i+"' name='answer_tf"+i+"' value='"+i+"'>" + 
      "</td></tr>";
      break;
   }

   document.getElementById("table").insertAdjacentHTML('beforeEnd', a);
 }

function addTag(value){
  
  if (value == 'add') {
    document.getElementById('subject').innerHTML = 'Adicionar materia.';
    var txt = "<td colspan='3'><input type = 'text' id = 'newTag' onchange='changeTitle(this.value), setValue()'> </td>";
    document.getElementById("select_subject").insertAdjacentHTML('afterEnd', txt);
  }
  // MARRETA ! 
  else{
    if(document.getElementById("newTag")){
      document.getElementById("newTag").outerHTML = "";
      document.getElementById("new_subject").value = "add";
    }
  }

}

function changeTitle(title){
  document.getElementById('subject').innerHTML = title;
}

function setValue(){
   document.getElementById("new_subject").value = document.getElementById("newTag").value;

}
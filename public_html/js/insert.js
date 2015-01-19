

var i;
var y = 0;
var type_id = 0;
var a = "";
var countOpt;
var validateOptions = false;

primeiraOpcao = true;

function setType(x){
  if(isNaN(i))
    i = 0;
  if (!(type_id == x || type_id == 0)) {
    for (var j = 1; j <= i; j++) 
      document.getElementById("option" + j).outerHTML = "";
    i = 0;
  }
    // primeiraOpcao = false;

  type_id = x;
}

function createOptions(){ 
  //type_id = getType();
  if(isNaN(i))
    i = 0;
  validateOptions = true;
  switch(type_id){
    case "1":
      
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
      
      i++;
      a = "<tr id='option"+i+"'>" + 
      "<td></td>" + 
      "<td colspan='3'> " + 
        "<input type = 'text' id ='opt"+i+"' name='opt"+i+"' value='"+i+"'>" + 
        "<input type = 'radio' id='answer_mc"+i+"' name='answer_mc' value='"+i+"'>" + 
      "</td></tr>";
      break;

     case "3":
      
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

function validateForm() {
  var invalidateAnswer = false;
  var optionsValidate = new Array();
  radioDifficulty1 = document.getElementById("difficulty1").checked;
  radioDifficulty2 = document.getElementById("difficulty2").checked;
  radioDifficulty3 = document.getElementById("difficulty3").checked;
  
  if(document.getElementById("subject_opt").value == "Selecione a matéria:") {
    alert("Selecione a matéria desejada");
    return false;
  }
  if(document.getElementById("tags").value == "") {
    alert("Selecione a tag");
    return false;
  }
  if(radioDifficulty1 == false && radioDifficulty2 == false && radioDifficulty3 == false ) {
    alert("Selecione a dificuldade");
    return false;
  }
  if(validateOptions == false) {
    alert("Coloque pelo menos uma resposta");
    return false;
  }
  /*if(document.getElementById("question").value == "") {
    alert("Coloque o enunciado");
    return false;
    }
  */
  for (count = 1; count <= i; count++) {
    if(type_id == 2)
      optionsValidate = document.getElementById("answer_mc"+count).checked;
    else
      optionsValidate = document.getElementById("answer_tf"+count).checked;
    if(optionsValidate == true) {
      invalidateAnswer = false;
      break;
    }
    else
      invalidateAnswer = true;
     
  }
  if (invalidateAnswer) {
    alert("Marque ao menos uma alternativa");
    return false;
  }
  
  return true;
}

function validateType() {
  radioType1 = document.getElementById("type1").checked;
  radioType2 = document.getElementById("type2").checked;
  radioType3 = document.getElementById("type3").checked;
  if (radioType1 == false && radioType2 == false && radioType3 == false )
    alert("Selecione o tipo");
}
<html>
<head>
  <title> Teste 01 </title>
  <meta charset = 'UTF-8' />
  <script type="text/javascript">
    var i = 0;
   /* var y = 0;
    var type_id = 0;
    var a = "";
*/
    function setType(x){
      type_id = x;
    }

    function createOptions(){
        //type_id = getType();

        switch(type_id){
          case "1":
          i++;
         /* if (i == 1) {
            a = "<tr><td>Introdução: </td><td colspan='3'><input type='text' id='introduction' name='introduction'></td></tr>";
          }
          else{*/
            a = "<tr><td></td><td colspan='2'>P: <input type='text' id ='opt"+i+"'></td>" + 
            "<td colspan='2'>R: <input type = 'text' name = 'answer_op' id ='answer_op"+i+"'> </td></tr> ";
         // }
          break;

          case "2":
          i++;
          a = "<tr><td></td><td colspan='4'><input type = 'text' id ='opt"+i+"'>" + 
          "<input type = 'radio' name = 'answer_mc' id ='answer_mc"+i+"'> </td></tr> " ;
          break;

          case "3":
          i++;
          a = "<tr><td></td><td colspan='4'><input type = 'text' id ='opt"+i+"'>" + 
          "<input type = 'checkbox' name = 'answer_tf' id ='answer_tf"+i+"'> </td></tr> " ;
          break;
        }

        document.getElementById("table").insertAdjacentHTML('beforeEnd', a);
      }

      function addTag(value){
        if (value == 'add') {
          var txt = "<td colspan='3'><input type = 'text' id = 'newTag' > </td>";
          document.getElementById("select_subject").insertAdjacentHTML('afterEnd', txt);
        }
        // MARRETA ! 
        else{
          if(document.getElementById("newTag")){
            document.getElementById("newTag").outerHTML = "";
          }
         
        }

      }



    </script>
  </head> 

  <body >
    <!-- Aparece depois de selecionar materia no SELECT -->
    <h1 id = "subject"> Selecione a matéria:  </h1>
    <form method='POST' action="/INF2A_2014/public_html/questoes/add">
      <table id = "table">
       <tr> 
        <td id="select_subject">
         <select id = "subject_opt" onchange="addTag(this.value)">
          <option> Materia 01 </option>
          <option> Materia 02 </option>
          <option value="add" > Adicionar </option>
          <!-- se for adicionar nova materia, aparece um prompt ou input ao lado -->
        </select>

      </td>       
    </tr>

    <tr> 
      <td> Tipo: </td>
      <td><input type = "radio" name = "type" id="type" value = "1" onclick="setType(this.value)"> Aberta</td>
      <td><input type = "radio" name = "type" id="type" value = "2" onclick="setType(this.value)"> Multipla Escolha</td>
      <td><input type = "radio" name = "type" id="type" value = "3" onclick="setType(this.value)"> Verdadeiro/Falso</td>
    </tr>
    <tr> 
      <td> Tags: </td>
      <td colspan = "3"> <input type = "text" id = "tags" size = "50"> </td>

    </tr>
    <tr> 
      <td> Dificuldade: </td>
      <td><input type = "radio" name = "difficulty" id="difficulty" value = "1" > Fácil</td>
      <td><input type = "radio" name = "difficulty" id="difficulty" value = "2" > Médio</td>
      <td><input type = "radio" name = "difficulty" id="difficulty" value = "3" > Difícil</td>
    </tr>
    <tr> 
      <td> Enunciado: </td>
      <td colspan = "3"> <input type = "text" id = "question" size = "50"></td>
    </tr>
    <tr>
      <td>
       Opções: 
     </td>
     <td> <input type = "button" id = "add" value = "+" onclick= "createOptions()"></td>
     <td>
     </td>
     <td>
     </td>
   </tr>
 </table>
  <input type = "reset" value = "Limpar">
  <input type = "submit" value = "Enviar" >
  </form>
</body>

</html>
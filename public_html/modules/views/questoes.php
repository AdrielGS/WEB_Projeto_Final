<?php include PAGES.'header.php'; ?>

<aside></aside>


<article>
  <!-- Aparece depois de selecionar materia no SELECT -->
  <h1 id = "subject"> Selecione a matéria:  </h1>
  
  <form method='POST' action="questoes/add">
    <table id = "table">
     <tr> 
      <td id="select_subject">
       <select id = "subject_opt" name="subject_opt" onchange="changeTitle(this.value), addTag(this.value)">
        <option> Selecione:  </option>
        <option> Materia 01 </option>
        <option> Materia 02 </option>
        <option value="add" id = "new_subject" > Adicionar </option>
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
    <td colspan = "3"> <input type = "text" id = "tags" name="tags" size = "50"> </td>

  </tr>
  <tr> 
    <td> Dificuldade: </td>
    <td><input type = "radio" name = "difficulty" id="difficulty" value = "1" > Fácil</td>
    <td><input type = "radio" name = "difficulty" id="difficulty" value = "2" > Médio</td>
    <td><input type = "radio" name = "difficulty" id="difficulty" value = "3" > Difícil</td>
  </tr>
  <tr> 
    <td> Enunciado: </td>
    <td colspan = "3"> <input type = "text" id = "question" name="question" size = "50"></td>
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
<input type = "reset" value = "Limpar" >
<input type = "submit" value = "Enviar" >
</form>
</article>

<?php include PAGES.'footer.php'; ?>
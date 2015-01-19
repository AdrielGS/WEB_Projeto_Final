<?php include PAGES.'header.php' ?>
<?php include PAGES.'questoes/sidebar.php'; ?>
<script type="text/javascript" src="js/insert.js"></script>


<article style="overflow: auto;">
  <!-- <h1 id = "subject" align="center"> Selecione a matéria:  </h1> -->
  
  <form method='POST' action="questoes/add" enctype="multipart/form-data" onSubmit="javascript: return validateForm()">
    <table id = "table" align="center">
      <tr><td colspan="6" align="center"><h1 id = "subject"> Adicione uma nova questão:  </h1></td></tr>
      <tr> 
        <td id="select_subject">
          <select id = "subject_opt" name="subject_opt" onchange="changeTitle(this.value), addTag(this.value)">
            <option value="Selecione a matéria:"> Selecione:  </option>            
            <?php 
              foreach ($subjects as $s) 
                echo " <option> $s </option>";
             ?>
            <option value="add" id = "new_subject" > Adicionar </option>
          </select>
        </td>       
      </tr>

      <tr> 
        <td> Tipo: </td>
        <td colspan="3"><input type = "radio" name = "type" id="type1" value = "1" onclick="setType(this.value)"> Aberta
        <input type = "radio" name = "type" id="type2" value = "2" onclick="setType(this.value)"> Multipla Escolha
        <input type = "radio" name = "type" id="type3" value = "3" onclick="setType(this.value)"> Verdadeiro/Falso</td>
      </tr>
      <tr> 
        <td> Assuntos: </td>
        <td colspan = "3"> <input type = "text" id = "tags" name="tags" size = "50"> </td>
      </tr>
      <tr> 
        <td> Dificuldade: </td>
        <td colspan="3"><input type = "radio" name = "difficulty" id="difficulty1" value = "1" > Fácil
        <input type = "radio" name = "difficulty" id="difficulty2" value = "2" > Médio
        <input type = "radio" name = "difficulty" id="difficulty3" value = "3" > Difícil</td>
      </tr>
      <tr> 
        <td> Enunciado: </td>
        <td colspan = "3"> <input type = "text" id = "question" name="question" size = "50"></td>
      </tr>
      <tr>
        <td colspan="3">Opções: <input type = "button" id = "add" value = "+" onclick= "validateType(); createOptions();" style="margin: 5px;"></td>
      </tr>
      <tr>
        <td> Imagem: <input type="file" name="img"></td>
      </tr>
    </table>

    <table align="center" style="margin-top: 20px;">
    <td><input type = "reset" value = "Limpar" ></td>
    <td><input type = "submit" value = "Enviar" ></td>
    </table>
  </form>
</article>

  <?php include PAGES.'footer.php' ?> 
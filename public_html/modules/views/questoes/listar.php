<?php include PAGES.'questoes/sidebar.php'; ?>
<?php include PAGES.'header.php'; ?>
<style>
  article > div {
    padding: 25px;
  }
</style>
<article>

<script type="text/javascript" src="js/js_listar.js"></script>
	
	<div>
		<table id = "table" align="center" style="margin-top: 16px;">
			<form method = "POST" action = "questoes/listar">
            <tr> 
              <td align="right"> Materia: </td>
              <td id="select_subject">
                <select id = "subject" name="subject">
                  <option> Todas </option>
                  <option> Materia 01 </option>
                  <option> Materia 02 </option>        
               </select>
            </td>       
         </tr>

         <tr> 
           <td align="right"> Tipo: </td>
           <td><input type = "checkbox" name = "type1" id="type1" value = "1" >Aberta </td>
           <td><input type = "checkbox" name = "type2" id="type2" value = "2" >Multipla Escolha </td>
           <td><input type = "checkbox" name = "type3" id="type3" value = "3" >Verdadeiro/Falso </td>
        </tr>  

        <tr> 
           <td align="right"> Dificuldade: </td>
           <td><input type = "checkbox" name = "difficulty1" id="difficulty1" value = "1"  >Fácil </td>
           <td><input type = "checkbox" name = "difficulty2" id="difficulty2" value = "2"  >Médio </td>
           <td><input type = "checkbox" name = "difficulty3" id="difficulty3" value = "3" >Difícil </td>
        </tr>

        <tr>
           <td colspan="4" align="center"> <input type = "submit" value = "Filtrar" onclick="setSelected()" style="margin: 20px 5px;">
             <a href="listar/showAll"><input type = "button" value = "Mostrar tudo" style="margin: 20px 5px;"></a></td>
          </tr>
       </form>
    </table>
    <hr>

    <?php 
      if(!empty($questions)){
        foreach ($questions as $i){
          echo $i->value.'<br>';
          foreach ($answers as $j) 
            if ($j->question_id == $i->id )
              echo '<input value="'.$j->value.'"><br></div>';
        }
      }
    ?>
 </div>
</article>

<?php include PAGES.'footer.php'; ?>
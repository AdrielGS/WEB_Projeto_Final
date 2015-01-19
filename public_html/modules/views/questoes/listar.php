<?php include PAGES.'questoes/sidebar.php'; ?>
<?php include PAGES.'header.php'; ?>
<style>
  article > div {
    padding: 20px;
  }
  .espaco {
    position: relative;
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
                   <?php 
                     foreach ($subjects as $s) 
                        echo " <option> $s </option>";
                   ?>      
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
      //include "js/js_listar.js";
      $a = 1;
      $b = 1;
      $c = 1;
	  $d = 1;
    $e = 1;
	  $p = null;
      if(!empty($questions)){
        foreach ($questions as $i){
          $e = 1;
          echo  '<form method="POST" action="questoes/update/'.$i->id.'/'.$i->type.'" enctype="multipart/form-data" ">';
          echo "<div id=\"q$i->id\"><input id = 'question" . $c . "' name='question" . $i->id . "' value = '".$i->value."'>";
		  
          echo "<button onclick = 'deleteQuestion(". $i->id .");' ><img width=\"20\" height=\"20\" src=\"images/x.jpg\"></button><br/>";
          foreach ($images as $k) {
            if ($k->question_id == $i->id) {
              echo "<img width=\"350\" height=\"350\" src=\"" . $k->name . " \" ><br>";
            }
          }
          if (empty($answers)) {
            echo "vazia";
          }
          else { 
            foreach ($answers as $j) {
              if ($j->question_id == $i->id ) {
                if ($i->type == 2) {
                  if ($j->correct == 1)
                    echo "<input type = 'radio' name = 'answer_mc". $i->id ."' value = '". $e ."' checked><input type = 'text' name= 'opt".$i->id.$e."' style = 'margin-left: 25' value='" . $j->value."'><br/>";    
                  else
                    echo "<input type = 'radio' name = 'answer_mc". $i->id ."' value = '". $e ."' ><input type = 'text' name= 'opt".$i->id.$e."' style = 'margin-left: 25' value='" . $j->value."'><br/>";
                  $e++;
                }

                else if ($i->type == 3) {
                  if ($j->correct == 1)
                    echo "<input type = 'checkbox' name = 'answer_tf". $i->id . $e ."' value = '". $j->value ."' checked><input type = 'text' name= 'tf" .$i->id .$e."' style = 'margin-left: 25' value='" . $j->value."'><br/>";    
                  else
                    echo "<input type = 'checkbox' name = 'answer_tf" . $i->id .$e ."' value = '". $j->value ."' ><input type = 'text' name= 'tf". $i->id .$e."' style = 'margin-left: 25' value='" . $j->value."'><br/>";
                  $e++;
                  //$b++;
                }
                else {
                  $str =  "<input type = 'text' name = 'opt".$i->id.$e."' style = 'margin-left: 25' value='" . $j->value."'>";
                  if(!empty($j->answer))
                    $str .= "<input type = 'text' name='answer_op".$i->id.$e."' style = 'margin-left: 10' value='". $j->answer ."'><br/>";
                  echo $str;
				          $e++;
                }
                //$d++;
              }
            }
            echo '<input type = "submit" value = "Enviar" >';
            echo '</div>';
            echo '</form>';
          }
          echo "<br>";
          /*
		      if($i->type == 2) {
			      $p = 'rdo'.$a;
			      echo '<button onclick = "update(question'.$c.','. $d .','.$p.','.$i->type.', '.$i->id.', '.$j->id.')">Update</button>';
		      }
		      else if($i->type == 3) {
			      $p = 'chk'.$a;
			      echo '<button onclick = "update(question'.$c.','. $d .','.$p.','.$i->type.', '.$i->id.', '.$j->id.')">Update</button>';
		      }
          else
			      echo '<button onclick = "updateOpen(question'.$c.','. $d .', answer'.$d.', '.$i->id.', '.$j->id.')">Update</button>';
		     */
          echo "<br>";
          $a++;
          $c++;
        }
      }
    ?>
 </div>
</article>

<?php include PAGES.'footer.php'; ?>
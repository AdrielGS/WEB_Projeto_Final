<meta charset=utf-8>

<?php class Questao extends DB
{
	
	public function __construct()
	{}

	public function add($question, $type, $difficulty, $subject, $tags, $opcoes, $resp, $correct, $file, $regNumber){
	/*
		ob_start();		
		include CONTROLLERS . 'questoesController.class.php';
		$conteudo = ob_get_contents();
		ob_end_clean();
	*/	
		$tamOpcoes = count($opcoes);

		$query_questao = DB::conn()->prepare("INSERT INTO __questions_question (value, type, difficulty, subject, tag) VALUES (:question, :type, :difficulty, :subject, :tags)");
		$query_questao = DB::conn()->prepare("INSERT INTO __questions_question (value, type, difficulty, subject, tag, regNumber) VALUES (:question, :type, :difficulty, :subject, :tags, :regNumber)");
		$query_questao->bindValue(':regNumber', $regNumber, PDO::PARAM_STR);
		
		$query_questao->bindValue(':question', $question, PDO::PARAM_STR);
		$query_questao->bindValue(':type', $type, PDO::PARAM_INT);
		$query_questao->bindValue(':difficulty', $difficulty, PDO::PARAM_INT);
		$query_questao->bindValue(':subject', $subject, PDO::PARAM_STR);
		$query_questao->bindValue(':tags', $tags, PDO::PARAM_STR);
		$query_questao->execute();

		$question_id = DB::conn()->lastInsertId();

		

		//var_dump($file);

		if ($file["img_name"]  != ""){
			$query_image = DB::conn()->prepare("INSERT INTO __questions_image (name, question_id) VALUES (:image, :question_id)");
			$query_image->bindValue(':image', $file["file_name"],PDO::PARAM_STR);
			$query_image->bindValue(':question_id', $question_id,PDO::PARAM_INT);
			$query_image->execute();

		}
		

		if($question == "")
			$type = 0;

		switch ($type) {

			case "0":

			$value = $opcoes[0];
			$right = $correct[0]; 
			$answer = $resp[0]; 
			$query_questao = DB::conn()->prepare("UPDATE __questions_question SET value = :value WHERE id = :question_id");
			$query_questao->bindValue(':value', $value, PDO::PARAM_STR);
			$query_questao->bindValue(':question_id', $question_id, PDO::PARAM_INT);
			$query_questao->execute();

			$query_opcoes = DB::conn()->prepare("INSERT INTO __questions_options (question_id, value, correct) VALUES (:question_id, :answer, :correct)");
			$query_opcoes->bindValue(':question_id', $question_id, PDO::PARAM_INT);
			$query_opcoes->bindValue(':answer', $answer, PDO::PARAM_STR);
			$query_opcoes->bindValue(':correct', $right, PDO::PARAM_INT);
			$query_opcoes->execute();

			break;

			case '1':
			for ($cont = 0; $cont < $tamOpcoes; $cont++) {
				$value = $opcoes[$cont];
				$answer = $resp[$cont]; 
				$query_opcoes = DB::conn()->prepare("INSERT INTO __question_open (question_id, value, answer) VALUES (:question_id, :value, :answer)");
				$query_opcoes->bindValue(':question_id', $question_id, PDO::PARAM_INT);
				$query_opcoes->bindValue(':value', $value, PDO::PARAM_STR);
				$query_opcoes->bindValue(':answer', $answer, PDO::PARAM_STR);
				$query_opcoes->execute();
			}
			break;

			case '2':
			case '3':
			for ($cont = 0; $cont < $tamOpcoes; $cont++) {
				$value = $opcoes[$cont];
				$right = $correct[$cont]; 
				$query_opcoes = DB::conn()->prepare("INSERT INTO __questions_options (question_id, value, correct) VALUES (:question_id, :value, :correct)");
				$query_opcoes->bindValue(':question_id', $question_id, PDO::PARAM_INT);
				$query_opcoes->bindValue(':value', $value, PDO::PARAM_STR);
				$query_opcoes->bindValue(':correct', $right, PDO::PARAM_INT);
				$query_opcoes->execute();
			}
			break;		
			
		}
		
	}

	public function update($id, $question, $options, $resp, $correct){

		$query_question = DB::conn()->prepare("UPDATE __questions_question SET value = :question WHERE id = :id");
		$query_question->bindValue(':question', $question, PDO::PARAM_STR);
		$query_question->bindValue(':id', $id, PDO::PARAM_INT);
		$query_question->execute();

		var_dump($options);
		var_dump($correct);

		//---- Condição para ver se é aberta ou fechada ----
		if (!$resp) {
			$query_questionId = DB::conn()->prepare("SELECT id FROM __questions_options WHERE question_id = :id");
			$query_questionId->bindValue(':id', $id, PDO::PARAM_INT);
			$query_questionId->execute();
			$options_id = $query_questionId->fetchAll(PDO::FETCH_OBJ);

			// ---- Condição para ver se existe nova opção ----
			if ( count($options_id) > count($options) ) {  
				
			}else{
				for ($i=0; $i < count($options); $i++) { 
					$query_options = DB::conn()->prepare("UPDATE __questions_options SET value = :options, correct = :correct WHERE id = :options_id");
					$query_options->bindValue(':options_id', $options_id[$i]->id, PDO::PARAM_STR);
					$query_options->bindValue(':options', $options[$i], PDO::PARAM_STR);
					$query_options->bindValue(':correct', $correct[$i], PDO::PARAM_INT);
					$query_options->execute();
				}	
			}

		}else{
			$query_questionId = DB::conn()->prepare("SELECT id FROM __question_open WHERE question_id = :id");
			$query_questionId->bindValue(':id', $id, PDO::PARAM_INT);
			$query_questionId->execute();
			$options_id = $query_questionId->fetchAll(PDO::FETCH_OBJ);

			// ---- Condição para ver se existe nova opção ----
			if ( count($options_id) > count($options) ) {

			}else{
				for ($i=0; $i < count($options); $i++) { 
					$query_options = DB::conn()->prepare("UPDATE __question_open SET value = :options, answer = :resp WHERE id = :options_id");
					$query_options->bindValue(':options_id', $options_id[$i]->id, PDO::PARAM_STR);
					$query_options->bindValue(':options', $options[$i], PDO::PARAM_STR);
					$query_options->bindValue(':resp', $resp[$i], PDO::PARAM_STR);
					$query_options->execute();	
				}
			}

		}
		
		



		


	}

	public function getAll(){

		$login = new Login();
			$id = $login->isLogged();
			if($id){
				$user = new User($id);
				$regNumber = $user->regNumber;
				// echo $regNumber;
			}
				else
					header( 'Location: http://localhost/WEB_Projeto_Final/public_html/home' ) ;



		$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE regNumber = $regNumber ");
		$query_questoes->execute();
/*
		$query_options = DB::conn()->prepare("SELECT * FROM __questions_options ");
		$query_options->execute();

		$query_open = DB::conn()->prepare("SELECT * FROM __question_open ");
		$query_open->execute();
*/

		$query = $query_questoes->fetchAll(PDO::FETCH_OBJ);
		/*
		$query['questions'] = $query_questoes->fetchAll(PDO::FETCH_OBJ);
		$query['options'] = $query_options->fetchAll(PDO::FETCH_OBJ);
		$query['open'] = $query_open->fetchAll(PDO::FETCH_OBJ);
*/

		return $query;
	}

	public function getSubjects($regNumber){

		

		$getSubject = DB::conn()->prepare("SELECT * FROM __questions_question WHERE regNumber = :regNumber ORDER BY subject ");
		$getSubject->bindValue(':regNumber', $regNumber, PDO::PARAM_STR);
		$getSubject->execute();

		

		return $getSubject->fetchAll(PDO::FETCH_COLUMN, 4);
		
	}

	public function getWithFilter($subject, $type, $difficulty, $regNumber){
		$strSubject = $subject == 'Todas' ? '1=1' : '`subject` = \''.$subject.'\'';
		$strType = empty($type) ? '1, 2, 3' : $type[0];
		$strDifficulty = empty($difficulty) ? '1, 2, 3' : $difficulty[0];

		for ($i = 1; $i < count($type); $i++)
			$strType .= ', '.$type[$i];

		for ($i = 1; $i < count($difficulty); $i++)
			$strDifficulty .= ', '.$difficulty[$i];

/*
		$query = DB::conn()->prepare('SELECT * FROM __questions_question WHERE 
			'.$strSubject.' AND (`type` IN ('.$strType.')) AND (`difficulty` IN ('.$strDifficulty.'))');
*/

		$query = DB::conn()->prepare('SELECT * FROM __questions_question WHERE 
			'.$strSubject.' AND (`type` IN ('.$strType.')) AND (`difficulty` IN ('.$strDifficulty.') AND regNumber = '.$regNumber.')');
		

		/*$query = DB::conn()->prepare('SELECT * FROM __questions_question JOIN __questions_options, __questions_open 
			ON __questions_question.id=__questions_open.question_id OR __questions_question.id=__questions_options.question_id WHERE 
			'.$strSubject.' AND (`type` IN ('.$strType.')) AND (`difficulty` IN ('.$strDifficulty.')) ');*/
		

		$query->execute();
		
		return $query->fetchAll(PDO::FETCH_OBJ);

	}

	public function getAnswer($questions){
		
		$strId = (!empty($questions)) ? $questions[0]->id : null;

		for ($i = 1; $i < count($questions); $i++) { 
			$strId .= ', ' . $questions[$i]->id;
		}

		//echo $strId;

		$query_options = DB::conn()->prepare('SELECT * FROM __questions_options WHERE question_id IN (' . $strId . ')');
		$query_options->execute();
		
		$query_open = DB::conn()->prepare('SELECT * FROM __question_open WHERE question_id IN (' . $strId . ')');
		$query_open->execute();
		
		$options = $query_options->fetchAll(PDO::FETCH_OBJ);
		$open = $query_open->fetchAll(PDO::FETCH_OBJ);

		$query = array_merge($options, $open);
		
		return $query;
		
	}

	public function getImages($questions) {
		$strId = (!empty($questions)) ? $questions[0]->id : null;

		for ($i=1; $i < count($questions); $i++) { 
			$strId .= ', ' . $questions[$i]->id;
		}

		$query = DB::conn()->prepare('SELECT * FROM __questions_image WHERE question_id IN (' . $strId . ')');
		$query->execute();

		return $query->fetchAll(PDO::FETCH_OBJ);
	}

	/*public function update($question, $value, $correct, $id, $id_answer) {
		$question_update = DB::conn()->prepare('UPDATE __questions_question SET question='.$question.' WHERE id='.$id.' ');
		$question_update->execute();
		$id_answer = $id_answer - (count($value) + 1);
		for($i = 0; $i < count($value); $i++) {
			$question_update = DB::conn()->prepare('UPDATE __questions_options SET value='.$value[$i].', correct='.$correct[$i].' WHERE id='.$id_answer.' ' );
			$question_update->execute();
			$id_answer++;
		}
	}*/

	public function updateOpen($question, $value, $answer, $id, $id_answer) {
		$question_update = DB::conn()->prepare('UPDATE __questions_question SET question='.$question.' WHERE id='.$id.' ');
		$question_update->execute();
		$id_answer = $id_answer - (count($value) + 1);
		for($i = 0; $i < count($value); $i++) {
			$question_update = DB::conn()->prepare('UPDATE __questions_open SET value='.$value[$i].', correct='.$answer[$i].' WHERE id='.$id_answer.' ' );
			$question_update->execute();
			$id_answer++;
		}	
	}

	public function deletar($id){
		// $query_questionId = DB::conn()->prepare('SELECT id FROM __questions_question WHERE value = "'. $question .'"');
		// $query_questionId->execute();
		// $question_id = $query_questionId->fetch(PDO::FETCH_OBJ);

		$question_delete = DB::conn()->prepare('DELETE FROM __questions_question WHERE id = "'. $id .'"');
		$question_delete->execute();
		$question_delete = DB::conn()->prepare('DELETE FROM __questions_options WHERE question_id = "'. $id .'"');
		$question_delete->execute();
		$question_delete = DB::conn()->prepare('DELETE FROM __question_open WHERE question_id = "'. $id .'"');
		$question_delete->execute();
		$question_delete = DB::conn()->prepare('DELETE FROM __questions_image WHERE question_id = "'. $id .'"');
		$question_delete->execute();	
		
	}


	public function getFilter($subject, $type, $difficulty){
		$str_subject = "";
		$str_type = "";
		$str_difficulty = "";
		$allSubject = true;
		$allType = false;
		$allDifficulty = false;
		$firstDifficulty = true;
		$firstType = true;

		if($subject == "Todas"){
			$str_subject = "";
			$subject = null;
		}
		else{
			$str_subject = "subject = :subject";
			$allSubject = false;
			$firstDifficulty = false;
		}

		if($type == null){
			$str_type = "";
			$allType = true;
		}
		else
			$firstDifficulty = false;


		if($difficulty == null)
			$allDifficulty = true;


		/*for($i=0; $i < count($type); $i++){
			if($subject == "Todas" && $allType == false && $firstType == true){
				$str_type .= "type = :type". $i;
				$firstType = false;
			}
			else{
				if ($i == 0){
					if ($allSubject == true) {
						$str_type .= "type = :type". $i;
					}
					else
						$str_type .= "AND type = :type". $i;
				}
				else
					$str_type .= " OR type = :type". $i;

			}
		}

		for($i=0; $i < count($difficulty); $i++){
			if ($i == 0 && $allDifficulty == false && $firstDifficulty == true) {
				$str_difficulty .= " difficulty = :difficulty". $i;
				$firstDifficulty = false;
			}
			else{
				if ($i == 0 && $firstDifficulty == false) {
					$str_difficulty .= " AND difficulty = :difficulty". $i;
				}
				else{
					$str_difficulty .= " OR difficulty = :difficulty". $i;
				}
			}
		}*/

		echo "Número de subject selecionados:<br>";
		echo count($subject);

		$j = 0; $k = 0;
		$placeGeneral = array();

		for ($i=0; $i < ( count($type) + count($difficulty) + count($subject) ) ; $i++) { 
			if ($i < count($subject)) {
				$placeGeneral[$i] = $subject;
			}else{
				if ($i < ( count($subject) + count($type) ) ) {
					$placeGeneral[$i] = $type[$j];
					$j++;
				}else{
					$placeGeneral[$i] = $difficulty[$k];
					$k++;
				}
			}
			
		}

		echo '<br><br>$placeGeneral:<br>';
		print_r($placeGeneral);
		echo "<br>";

		$placeType = implode(',', array_fill(0, count($type), '?'));
		$placeDifficulty = implode(',', array_fill(0, count($difficulty), '?'));
		$placeSubject = implode(',', array_fill(0, count($subject), '?'));

		echo '<br><br>$placeType:<br>';
		print_r($placeType);
		echo '<br><br>$placeDifficulty:<br>';
		print_r($placeDifficulty);
		echo '<br><br>$placeSubject:<br>';
		print_r($placeSubject);

		if ($allType == true && $allSubject == true && $allDifficulty == true) {
			$aux = $this->getAll();
			$query_questoes['questions'] = $aux->questions;
		}else{
			if ($allType == true && $allDifficulty == true)
				$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE subject IN($placeSubject) ");
			else{
				if ($allType == true && $allSubject == true)
					$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE difficulty IN($placeDifficulty)");
				else{
					if ($allDifficulty == true && $allSubject == true)
						$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE type IN($placeType)");
					else{
						if ($allSubject == true)
							$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE type IN($placeType) AND difficulty IN($placeDifficulty)");
						else{
							if ($allType == true)
								$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE subject IN($placeSubject) AND difficulty IN($placeDifficulty)");
							else{
								if ($allDifficulty == true)
									$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE subject IN($placeSubject) AND type IN($placeType)");
								else
									$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE subject IN($placeSubject) AND type IN($placeType) AND difficulty IN($placeDifficulty)");
							}
						}
					}
				}
			}
		}


			//$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE type IN($placeType) AND difficulty IN($placeDifficulty)");

		echo "<br><br>Query:<br>";
		print_r($query_questoes);
		$query_questoes->execute($placeGeneral);

			//echo "<br/>" . $str_type;
			//echo "<br/>" . $str_difficulty;

		/*if ($allDifficulty == true && $allSubject == true && $allType == true) {
			$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question");
		}
		else
			$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE $str_subject $str_type $str_difficulty");
		
		
		print_r($query_questoes);

		if ($allSubject == false) {
			$query_questoes->bindValue(':subject', $subject, PDO::PARAM_STR);	
		}

		for($i=0; $i < count($type); $i++)
			$query_questoes->bindValue(':type'.$i, $type[$i], PDO::PARAM_INT);

		for($i=0; $i < count($difficulty); $i++)
			$query_questoes->bindValue(':difficulty'.$i, $difficulty[$i], PDO::PARAM_INT);

			$query_questoes->execute();*/


/*
		$query_options = DB::conn()->prepare("SELECT * FROM __questions_options ");
		$query_options->execute();

		$query_open = DB::conn()->prepare("SELECT * FROM __questions_open ");
		$query_open->execute();
*/
		$query['questions'] = $query_questoes->fetchAll(PDO::FETCH_OBJ);
		/*$query['options'] = $query_options->fetchAll(PDO::FETCH_OBJ);
		$query['open'] = $query_open->fetchAll(PDO::FETCH_OBJ);
		*/
		/*	echo "<br/>";
		echo "<br/>";
		foreach ($variable as $query) {
			echo $variable;
		}*/
		echo "<br/><br>Resultado:<br>";
		for ( $i=0; $i < count($query['questions']); $i++ ) { 
			echo $i + 1 . " - ";
			print_r($query['questions'][$i]);
			echo "<br>";
		}

		return $query;

	}

}


?>
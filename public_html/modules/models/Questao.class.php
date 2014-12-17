<meta charset=utf-8>

<?php class Questao extends DB
{
	
	public function __construct()
	{}

	public function add($question, $type, $difficulty, $subject, $tags, $opcoes, $resp, $correct){
	/*
		ob_start();		
		include CONTROLLERS . 'questoesController.class.php';
		$conteudo = ob_get_contents();
		ob_end_clean();
	*/	
		$tamOpcoes = count($opcoes);

		$query_questao = DB::conn()->prepare("INSERT INTO __questions_question (value, type, difficulty, subject, tag) VALUES (:question, :type, :difficulty, :subject, :tags)");
		$query_questao->bindValue(':question', $question, PDO::PARAM_STR);
		$query_questao->bindValue(':type', $type, PDO::PARAM_INT);
		$query_questao->bindValue(':difficulty', $difficulty, PDO::PARAM_INT);
		$query_questao->bindValue(':subject', $subject, PDO::PARAM_STR);
		$query_questao->bindValue(':tags', $tags, PDO::PARAM_STR);


		$query_questao->execute();
		$question_id = DB::conn()->lastInsertId();

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
				$query_opcoes = DB::conn()->prepare("INSERT INTO __questions_open (question_id, value, answer) VALUES (:question_id, :value, :answer)");
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

	public function getAll(){

		$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question ");
		$query_questoes->execute();

		$query_options = DB::conn()->prepare("SELECT * FROM __questions_options ");
		$query_options->execute();

		$query_open = DB::conn()->prepare("SELECT * FROM __questions_open ");
		$query_open->execute();

		$query['questions'] = $query_questoes->fetchAll(PDO::FETCH_OBJ);
		$query['options'] = $query_options->fetchAll(PDO::FETCH_OBJ);
		$query['open'] = $query_open->fetchAll(PDO::FETCH_OBJ);


		return $query;
	}

	public function getWithFilter($subject, $type, $difficulty){
		$strSubject = $subject == 'Todas' ? '1=1' : '`subject` = \''.$subject.'\'';
		$strType = empty($type) ? '1, 2, 3' : $type[0];
		$strDifficulty = empty($difficulty) ? '1, 2, 3' : $difficulty[0];

		for ($i = 1; $i < count($type); $i++)
			$strType .= ', '.$type[$i];

		for ($i = 1; $i < count($difficulty); $i++)
			$strDifficulty .= ', '.$difficulty[$i];

		$query = DB::conn()->prepare('SELECT * FROM __questions_question WHERE 
			'.$strSubject.' AND (`type` IN ('.$strType.')) AND (`difficulty` IN ('.$strDifficulty.'))');
		$query->execute();
		
		return $query->fetchAll(PDO::FETCH_OBJ);

	}

	public function getAnswer($questions){
		$strId = $questions[0]->id;

		for ($i = 1; $i < count($questions); $i++) { 
			$strId .= ', ' . $questions[$i]->id;
		}

		echo $strId;

		$query = DB::conn()->prepare('SELECT * FROM __questions_open, __questions_options WHERE `__questions_open.question_id` IN(' . $strId . ') OR `__questions_options.question_id` IN(' . $strId . ')');
		
		$query->execute();
		
		$result = $query->fetchAll(PDO::FETCH_OBJ);
		return $result;

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
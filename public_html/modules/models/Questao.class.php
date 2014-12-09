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

	public function getFilter($subject, $type, $difficulty){
			$str_subject = "";
			$str_type = "";
			$str_difficulty = "";
			$allSucject = true;

			if($subject == "Todas"){
				$str_subject = "";
			}
			else{
				$str_subject = "subject = :subject";
				$allSucject = false;
			}
						
			if($type == null){
				$str_type = "";
				$allType = true;
			}


			if($difficulty == null)
				for($i=0; $i < count($difficulty); $i++)
					$difficulty[$i] = $i;			
/*
			echo "<br/>" . $subject;
			var_dump($type);
			var_dump($difficulty);
*/			for($i=0; $i < count($type); $i++)
				if($subject == "Todas" && $allType == false){
					$str_type .= "type = :type". $i;
					$allType = true;
				}
				else{
					if ($i == 0){
						if ($allSucject == true) {
							$str_type .= "type = :type". $i;
						}
						else
							$str_type .= "AND type = :type". $i;
					}
					else
						$str_type .= " OR type = :type". $i;
					
				}

			for($i=0; $i < count($difficulty); $i++)
				if($i == 0)
					$str_difficulty .= " difficulty = :difficulty". $i;
				else 
					$str_difficulty .= " OR difficulty = :difficulty". $i;


			echo "<br/>" . $str_type;
			echo "<br/>" . $str_difficulty;


		$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE $str_subject $str_type AND $str_difficulty");
		print_r($query_questoes);

		if ($allSucject == false) {
			$query_questoes->bindValue(':subject', $subject, PDO::PARAM_STR);	
		}

		for($i=0; $i < count($type); $i++)
			$query_questoes->bindValue(':type'.$i, $type[$i], PDO::PARAM_INT);

		for($i=0; $i < count($difficulty); $i++)
			$query_questoes->bindValue(':difficulty'.$i, $difficulty[$i], PDO::PARAM_INT);

		$query_questoes->execute();


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
		echo "<br/>";
		print_r($query['questions']);


		return $query;

	}

}


 ?>
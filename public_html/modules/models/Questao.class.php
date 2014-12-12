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
			$str_id = "";
			$allSubject = true;
			$allType = false;
			$allDifficulty = false;
			$firstDifficulty = true;
			$firstType = true;
			$firstID = true;

			if($subject == "Todas"){
				$str_subject = "";
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


			for($i=0; $i < count($type); $i++)
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

			for($i=0; $i < count($difficulty); $i++)
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

			echo "<br/>" . $str_type;
			echo "<br/>" . $str_difficulty;

		if ($allDifficulty == true && $allSubject == true && $allType == true) {
			$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question");
		}
		else {
			$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE $str_subject $str_type $str_difficulty");
		}
		
		print_r($query_questoes);

		if ($allSubject == false) {
			$query_questoes->bindValue(':subject', $subject, PDO::PARAM_STR);	
		}

		for($i=0; $i < count($type); $i++)
			$query_questoes->bindValue(':type'.$i, $type[$i], PDO::PARAM_INT);

		for($i=0; $i < count($difficulty); $i++)
			$query_questoes->bindValue(':difficulty'.$i, $difficulty[$i], PDO::PARAM_INT);

		$query_questoes->execute();

		$aux = 0;
		$id = array();
		while ($take = $query_questoes->setFetchMode(PDO::FETCH_ASSOC)) {
			if ($take['correct'] == 1) {
				if ($firstID == true) 
					$str_id = "id = :id";
				else
					$str_id .="AND id = :id";
				$id[$aux] = $take['id'];
				$aux++;
			}
		};

		if ($type != 1) {
			$query_options = DB::conn()->prepare("SELECT * FROM __questions_options WHERE $str_id ");
			for ($i=0; $i < count($id); $i++) { 
				$query_options->bindValue(':id'.$i, $id[$i], PDO::PARAM_INT);
			}
			$query_options->execute();
			$query['options'] = $query_options->fetchAll(PDO::FETCH_OBJ);
		}
		else {
			$query_open = DB::conn()->prepare("SELECT * FROM __questions_open WHERE $str_id ");
			for ($i=0; $i < count($id); $i++) { 
				$query_open->bindValue(':id'.$i, $id[$i], PDO::PARAM_INT);
			}
			$query_open->execute();
			$query['open'] = $query_open->fetchAll(PDO::FETCH_OBJ);	
		}
		

		
		$query['questions'] = $query_questoes->fetchAll(PDO::FETCH_OBJ);
		/*$query['options'] = $query_options->fetchAll(PDO::FETCH_OBJ);
		$query['open'] = $query_open->fetchAll(PDO::FETCH_OBJ);
		*/
		/*	echo "<br/>";
		echo "<br/>";
		foreach ($variable as $query) {
			echo $variable;
		}*/
		echo "<br/>";
		echo "<br/>";
		print_r($query['questions']);
		print_r($query['open']);
		print_r($query['options']);


		return $query;

	}

}


 ?>
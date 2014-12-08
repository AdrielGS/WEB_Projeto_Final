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

			if($subject == "Todas")
				$subject = "*";
			if($type == null)
				$type = "*";
			if($difficulty == null)
				$difficulty = "*";			
/*
			echo "<br/>" . $subject;
			var_dump($type);
			var_dump($difficulty);
*/	for($i=0; $i < count())
		$query_questoes = DB::conn()->prepare("SELECT * FROM __questions_question WHERE subject = ':subject' AND type = ':type' AND difficulty = ':difficulty'");
		$query_questoes->bindValue(':subject', $subject, PDO::PARAM_STR);
		$query_questoes->bindValue(':type', $type, PDO::PARAM_INT);
		$query_questoes->bindValue(':difficulty', $difficulty, PDO::PARAM_INT);
		$query_questoes->execute();



		$query_options = DB::conn()->prepare("SELECT * FROM __questions_options ");
		$query_options->execute();

		$query_open = DB::conn()->prepare("SELECT * FROM __questions_open ");
		$query_open->execute();

		$query['questions'] = $query_questoes->fetchAll(PDO::FETCH_OBJ);
		$query['options'] = $query_options->fetchAll(PDO::FETCH_OBJ);
		$query['open'] = $query_open->fetchAll(PDO::FETCH_OBJ);
		var_dump($query['questions']);


		return $query;

	}

}


 ?>
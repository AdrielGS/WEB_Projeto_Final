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

		switch ($type) {
			case '1':
				for ($cont = 0; $cont < $tamOpcoes; $cont++) {
					$value = $opcoes[$cont];
					$answer = $resp[$cont]; 
					$query_opcoes = DB::conn()->prepare("INSERT INTO __question_open (question_id, value, answer) VALUES (:question_id, :value, :answer)");
					$query_opcoes->bindValue(':question_id', $question_id, PDO::PARAM_INT);
					$query_opcoes->bindValue(':value', $value, PDO::PARAM_STR);
					$query_opcoes->bindValue(':answer', $answer, PDO::PARAM_INT);
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

}


 ?>
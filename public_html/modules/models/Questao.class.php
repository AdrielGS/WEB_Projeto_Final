<?php 

/**
* 
*/
class Questao extends DB
{
	
	function __construct(argument)
	{}

public function add(){
		ob_start();
		include 'questoesController.php';
		$conteudo = ob_get_contents();
		ob_end_clean();
		$tamOpcoes = count($opcoes);
		for ($cont=0; $cont < $tamOpcoes; $cont++) {
			$value = $opcoes[$cont];
			$correct = $resp[$cont]; 
			$query_opcoes = DB::conn()->prepare("INSERT INTO __questoes_opcoes (question_id, value, correct) VALUES ($question_id, $value, $correct)");
		}
			
		$query_questao = DB::conn()->prepare("INSERT INTO __questoes_questoes (value, type, difficulty, subject, tag) VALUES ($question, $type, $difficulty, $subject, $tag, __questoes_opcoes)");
	}

}


 ?>
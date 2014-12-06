<?php 

/**
* 
*/
class Questao extends DB
{
	
	function __construct(argument)
	{}

	public function add($enunciado, $tipo, $materia, $assunto, $dificuldade, $resposta, $opcoes){
		ob_start();
		include 'questoes.php';
		$conteudo = ob_get_contents();
		ob_end_clean();
		foreach ($value as $opcoes)
			$query_opcoes = DB::conn()->prepare("INSERT INTO __questoes_opcoes (question, value) VALUES ($question, $value)");

		$query_questao = DB::conn()->prepare("INSERT INTO __questoes_questoes (value, type, difficulty, subject, tag) VALUES ($question, $type, $difficulty, $subject, $tag, __questoes_opcoes)");
	}

}

 ?>
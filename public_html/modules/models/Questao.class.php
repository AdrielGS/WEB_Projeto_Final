<?php 

/**
* 
*/
class Questao extends DB
{
	
	function __construct(argument)
	{}

	public function add($enunciado, $tipo, $materia, $assunto, $dificuldade, $resposta, $opcoes){
		foreach ($value as $opcoes)
			$query_opcoes = DB::conn()->prepare("INSERT INTO __questoes_opcoes (question, value) VALUES ($question, $value)");

		$query_questao = DB::conn()->prepare("INSERT INTO __questoes_questoes (enunciado, tipo, materia, assunto, dificuldade, resposta) VALUES ($enunciado, $tipo, $materia, $assunto, $dificuldade, $resposta, __questoes_opcoes)");
	}

}

 ?>
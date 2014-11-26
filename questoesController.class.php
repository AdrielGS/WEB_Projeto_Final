<?php 

/**
* 
*/
class questoes extends Controller
{
	
	function __construct(){}

	public function home(){
		$this->view('Teste01');
	}

	public function add(){
		$tipo = $_POST["tipo"];
		$dificuldade = $_POST['dificuldade'];
		$enunciado = $_POST["enunciado"];
		$materia = $_POST["materia"];
		$numero_opcoes = $_POST["numero"];
		$resposta = $_POST["resposta"];
		$assunto = $_POST["assunto"];
		for ($i=0; $i < $numero_opcoes ; $i++) { 
			$opcoes[$i] = $_POST["opcao" . $i];
		}

		$questao = new Questao();
		$questao->add($enunciado, $tipo, $materia, $dificuldade, $resposta, $opcoes);

	}
}

?>
<?php 

/**
* 
*/
class questoes extends Controller
{
	
	function __construct(){}

	public function home(){
		$this->view('questoes');
	}

	public function add(){
		$subject = $_POST["subject_opt"];
		$type = $_POST["type"];
		$tags = $_POST["tags"];
		$difficulty = $_POST['difficulty'];
		$question = $_POST["question"];
		// Não dá erro, mas  $numero_opcoes nao aparece;
		$numero_opcoes = "<script type = 'text/script' src='js/js.js'>document.write(i)</script>";
		echo ">>> $numero_opcoes $subject";

/*
		if ($type == 1) {
			for ($i=0; $i <  ; $i++) { 
				$opts[] = 
			}
		}

		$numero_opcoes = $_POST["numero"];
		$resposta = $_POST["resposta"];
		for ($i=0; $i < $numero_opcoes ; $i++) { 
			$opcoes[$i] = $_POST["opcao" . $i];
		}

		$questao = new Questao();
		$questao->add($enunciado, $tipo, $materia, $dificuldade, $resposta, $opcoes);*/

	}
}

?>
<?php 

/**
* 
*/
class questoes extends Controller
{
	$question_id = 0;
	
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
		$i = 1;
		$opcoes = array();
		$resp = array();
		$j = 0;
		
		/*$opcao = $_POST["opt1"];
		$opcao2 = $_POST["opt2"];
		echo ">>>" . $numero_opcoes . $subject . "<br/>" . $opcao . "  " . $opcao2;*/
		switch ($type) {
			case '1':
				while ( !empty($_POST["opt" . $i]) ) {
					$opcoes[ ($i - 1) ] = $_POST["opt" . $i];
					$resp[($i - 1)] = $_POST["answer_op".$i];
					$i++; 	
				}	
				break;
			case '2':
				while ( !empty($_POST["opt" . $i])) {
					$opcoes[($i - 1)] = $_POST["opt" . $i];
					$resp[($i - 1)] = 0;
					$i++;
				}
				$indice = $_POST["answer_mc"];
				echo $indice;
				$indice--;
				$resp[ $indice ] = 1;
				break;
			
			case '3':
				while ( !empty($_POST["tf".$i])) {
					$opcoes[($i - 1)] = $_POST["tf" . $i];
					if(isset($_POST["answer_tf" . $i])) {
						$resp[($i - 1)] = 1;
					}
					else
						$resp[($i - 1)] = 0;
					$i++;
				}
				break;
			
			default:
				$question_id++;
				break;
		}
		
		echo "<br/>Perguntas:<br/>";
		var_dump($opcoes);
		echo "<br/>Respostas:<br/>";
		var_dump($resp);

		$Questao = new Questao();
		$Questao->add();

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
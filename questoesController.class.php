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
		echo "<base href='<?php echo URL; ?>'";
		$subject = $_POST["subject_opt"];
		$type = $_POST["type"];
		$tags = $_POST["tags"];
		$difficulty = $_POST['difficulty'];
		$question = $_POST["question"];
		$numero_opcoes = "<script src='js/js.js'></script><script>document.write(i)</script>";
		$i = 1;
		
		/*$opcao = $_POST["opt1"];
		$opcao2 = $_POST["opt2"];
		echo ">>>" . $numero_opcoes . $subject . "<br/>" . $opcao . "  " . $opcao2;*/

		while ( !empty($_POST["opt" . $i]) ) {
			$opcoes[ ($i - 1) ] = $_POST["opt" . $i];
			$i++;	
		}

		var_dump($opcoes);

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
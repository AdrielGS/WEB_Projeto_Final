<?php

class questoesController extends Controller{
	public function home(){
		$this->view('questoes/home');
	}

	public function inserir(){
		$this->view('questoes/inserir');
	}

	public function listar(){
		$data = array();
		if(!empty($_POST['subject'])) {
			$subject = $_POST['subject'];			
			$type = array();
			$difficulty = array();
			$j = 0;
			$k = 0;
			//--- Função para pegar as respostas pelo id --- $id = array();
			//--- Função para pegar as respostas pelo id (fazer for) --- $show_question->getAnswers($id);

			for($i = 1; $i < 4; $i++ ){
				if(isset($_POST["type".$i])){
					$type[$j] = $_POST["type".$i];
					$j++;
				}
				if(isset($_POST["difficulty".$i])){
					$difficulty[$k] = $_POST["difficulty".$i];
					$k++;
				}
				
			}

			$show_question = new Questao();
			$result = $show_question->getWithFilter($subject, $type, $difficulty);
			$data['questions'] = $result;
			$data['answers'] = $show_question->getAnswer($result);
			var_dump($data['answers']);
		}
		$this->view('questoes/listar', $data);
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
		$correct = array();
		
		switch ($type) {
			case '1':
			while ( !empty($_POST["opt" . $i]) ) {
				$opcoes[ ($i - 1) ] = $_POST["opt" . $i];
				$resp[($i - 1)] = $_POST["answer_op".$i];
				$correct[($i - 1)] = 1;
				$i++; 	
			}	
			break;
			case '2':
			while ( !empty($_POST["opt" . $i])) {
				$opcoes[($i - 1)] = $_POST["opt" . $i];
				$correct[($i - 1)] = 0;
				$i++;
			}
			$indice = $_POST["answer_mc"];
			echo $indice;
			$indice--;
			$correct[ $indice ] = 1;
			break;

			case '3':
			while ( !empty($_POST["tf".$i])) {
				$opcoes[($i - 1)] = $_POST["tf" . $i];
				if(isset($_POST["answer_tf" . $i])) {
					$correct[($i - 1)] = 1;
				}
				else
					$correct[($i - 1)] = 0;
				$i++;
			}
			break;

		}

		echo "<br/>Perguntas:<br/>";
		var_dump($opcoes);
		echo "<br/>Respostas:<br/>";
		var_dump($correct);

		$new_questao = new Questao();
		$new_questao->add($question, $type, $difficulty, $subject, $tags, $opcoes, $resp, $correct);

	}
	


}

?>
<?php

class questoesController extends Controller{
	public function home(){
		$this->view('questoes/home');
	}

	public function showInserir(){
		session_start();

		$login = new Login();
		$id = $login->isLogged();
		if($id){
			$user = new User($id);
			$regNumber = $user->regNumber;
			$data["user"] = $user;
			//echo $regNumber;
		}
		else
			header( 'Location: http://localhost/WEB_Projeto_Final/public_html/home' ) ;

		$subjects = new Questao();
		$getSubjects = $subjects->getSubjects($regNumber);
		//var_dump($getSubjects);
		$data["subjects"] = array_unique($getSubjects);
		//var_dump($data["subjects"]);

		$this->view('questoes/inserir', $data);

	}

	public function showListar(){
		session_start();

		$login = new Login();
			$id = $login->isLogged();
			if($id){
				$user = new User($id);
				$regNumber = $user->regNumber;
				$data["user"] = $user;
				//echo $regNumber;
			}
				else
					header( 'Location: http://localhost/WEB_Projeto_Final/public_html/home' ) ;

		$subjects = new Questao();
		$getSubjects = $subjects->getSubjects($regNumber);
		//var_dump($getSubjects);
		$data["subjects"] = array_unique($getSubjects);

		$this->view('questoes/listar', $data);

	}

	public function listar(){
		session_start();
		$data = array();
		if(!empty($_POST['subject'])) {
			$subject = $_POST['subject'];			
			$type = array();
			$difficulty = array();
			$j = 0;
			$k = 0;

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

			$login = new Login();
			$id = $login->isLogged();
			if($id){
				$user = new User($id);
				$regNumber = $user->regNumber;
				$data["user"] = $user;
			}
				else
					header( 'Location: http://localhost/WEB_Projeto_Final/public_html/home' ) ;

				

			//$regNumber = "0136";

			$show_question = new Questao();
			$result = $show_question->getWithFilter($subject, $type, $difficulty, $regNumber);
			$data['questions'] = $result;
			$data['images'] = $show_question->getImages($result);
			$data['answers'] = $show_question->getAnswer($result);
			//var_dump($data['answers']);
			$subjects = new Questao();
			$getSubjects = $subjects->getSubjects($regNumber);
			//var_dump($getSubjects);

			$data["subjects"] = array_unique($getSubjects);
			//var_dump($data["subjects"]);
			
		}
		$this->view('questoes/listar', $data);
	}

	public function add(){
		session_start();
		
		$subject = $_POST["subject_opt"];
		$type = $_POST["type"];
		$tags = $_POST["tags"];
		$difficulty = $_POST['difficulty'];
		$question = $_POST["question"];
		$i = 1;
		$opcoes = array();
		$resp = array();
		$correct = array();
		$file["file_name"] = "";
		$file["img_name"] = "";

		
		$login = new Login();
		$id = $login->isLogged();
		
			if($id){
				$user1 = new User($id);
				var_dump($user1);			
				$regNumber = $user1->regNumber;
				echo "regNumber: $regNumber ";


			}
				else
					header( 'Location: http://localhost/WEB_Projeto_Final/public_html/showInserir' ) ;
		

		
		if(isset($_FILES["img"])){
			$image = $_FILES["img"];
			echo "<br>Image name-> " . $image["name"] . ",algo?";
			//Precisa checar  se a pasta existe ?
			$folder = "images/questions/";
			$file["img_name"] = $image["name"];
			$file["file_name"] = $folder.$image["name"];
			move_uploaded_file($image["tmp_name"],$file["file_name"]);
		}
		
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
		$new_questao->add($question, $type, $difficulty, $subject, $tags, $opcoes, $resp, $correct, $file, $regNumber);
		header( 'Location: http://localhost/Adriel/public_html/questoes/showInserir' ) ;

	}
	
	/*public function update($params = null) {
		if(!empty($params)) {
			$update_question = new Questao();
			$question = $params[0];
			$value = $params[1];
			$id = $params[3];
			$id_answer = $params[4];
			if(!empty($params[5])){
				$correct = $params[2];
				$update_question->update($question,$value,$correct,$id,$id_answer);
			}
			else {
				$answer = $params[2];
				$update_question->updateOpen($question,$value,$answer,$id,$id_answer);
			}
		}
	}*/

	public function update($params = null){
		//session_start();

		var_dump($params);
		$id = $params[0];
		$type = $params[1];
		$question = $_POST["question".$id];
		$i = 1;
		$resp = null;
		$options = null;
		$correct = null;
		echo "";
	
		switch ($type) {
			case '1':
			while ( !empty($_POST["opt" .$id. $i]) ) {
				$options[ ($i - 1) ] = $_POST["opt" .$id. $i];
				$resp[($i - 1)] = $_POST["answer_op".$id.$i];
				$correct[($i - 1)] = 1;
				$i++; 	
			}	
			break;
			case '2':
			while ( !empty($_POST["opt" .$id. $i])) {
				$options[($i - 1)] = $_POST["opt".$id. $i ];
				$correct[($i - 1)] = 0;
				$i++;
			}
			$indice = $_POST["answer_mc".$id];
			echo $indice;
			$indice--;
			$correct[ $indice ] = 1;
			break;

			case '3':
			while ( !empty($_POST["tf".$id.$i])) {
				echo $i;
				$options[($i - 1)] = $_POST["tf" .$id. $i];
				if(isset($_POST["answer_tf" .$id. $i])) {
					$correct[($i - 1)] = 1;
				}
				else
					$correct[($i - 1)] = 0;
				$i++;
			}
			break;

		}
		echo "<br/>Pergunta:<br/>";
		echo "$question";
		echo "<br/>Perguntas:<br/>";
		var_dump($options);
		echo "<br/>Respostas:<br/>";
		var_dump($correct);
		//var_dump($resp);

		$update_question = new Questao();
		$update_question->update($id, $question, $options, $resp, $correct);
		



	}

	public function delete($params = null) {
		session_start();
		if(!empty($params)) {
			$question = $params[0];
			$delete_question = new Questao();
			$delete_question->deletar($question);
		}
	}
	
	


}

?>
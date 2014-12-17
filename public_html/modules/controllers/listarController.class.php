<?php 
	class listarController extends Controller{
		public function home(){
			$this->view("listar");
		}

		public function filter(){
			$subject = $_POST["subject"];			
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
			
			/*
			var_dump($subject);
			var_dump($type);
			var_dump($difficulty);
			*/

			$show_question = new Questao();
			$result = $show_question->getWithFilter($subject, $type, $difficulty);

			//var_dump($result);

		}

		public function showAll(){

			$show_questions = new Questao();
			$results = $show_questions->getAll();			

		//	echo $result[0]->value;
			var_dump($results);


		}
	}

 ?>
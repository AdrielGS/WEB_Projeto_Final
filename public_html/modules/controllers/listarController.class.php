<?php 
	class listarController extends Controller{
		public function home(){
			$this->view("listar");
		}
/*
		public function filter(){
			session_start();
			$data = array();
			if(!empty($_POST['subject'])) {
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
				$login = new Login();
				$id = $login->isLogged()
				if($id){}
					$user = new User($id)/
					$regNumber = $user->$regNumber;
				}
					else
					//Redirecionar para pagina de login

				

				$regNumber = "0136";
				
				/*
				var_dump($subject);
				var_dump($type);
				var_dump($difficulty);
				

				$show_question = new Questao();
				$result = $show_question->getWithFilter($subject, $type, $difficulty, $regNumber);

				$data['questions'] = $result;
				$data['images'] = $show_question->getImages($result);
				$data['answers'] = $show_question->getAnswer($result);
		}

			$this->view('questoes/listar', $data);



		//var_dump($result);

		}
*/
		public function showAll(){
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

			$show_questions = new Questao();
			$results = $show_questions->getAll();	
			$getSubjects = $show_questions->getSubjects($regNumber);
			//var_dump($getSubjects);
			$data["subjects"] = array_unique($getSubjects);

			$data['questions'] = $results;
			$data['images'] = $show_questions->getImages($results);
			$data['answers'] = $show_questions->getAnswer($results);

			$this->view('questoes/listar', $data);



		//	echo $result[0]->value;
		//	var_dump($results);


		}
	}

 ?>
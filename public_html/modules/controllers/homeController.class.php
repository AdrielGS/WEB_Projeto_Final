<?php class homeController extends Controller{
	
	public function params($params = null){
		$data['var'] = $params[0];
		$this->view('params', $data);
	}
	
	public function home($params = null){
		session_start();
		$data = array();
		$loginClass = new Login();
		$id = $loginClass->isLogged();

		if($id){
			$user = new User($id);
			$data['user'] = $user;
			$this->view('panel', $data);
		}else
			$this->view('index');
	}

	public function info(){
		$this->view('info');
	}

	public function credits(){		
		$this->view('credits');
	}

	public function login(){
		$loginClass = new Login();
		$stats = $loginClass->login($_POST['login'], $_POST['pass']);

		if($stats){
			$this->redirect('');
		}else{
			$this->redirect('home/home/mismatch');
		}
	}

	public function logout(){
		session_start();
		$loginClass = new Login();
		$loginClass->logout();
		$this->redirect('');
	}

	public function r($params = null){
		session_start();
		$loginClass = new Login();
		$loginClass->register($params[0],$params[1],$params[2],$params[3],$params[4],$params[5]);
		$this->redirect('');
	}
}
?>
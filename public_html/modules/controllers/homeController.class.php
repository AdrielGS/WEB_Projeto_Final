<?php class home extends Controller{
	public function __construct(){ }

	public function home($params = null){
		/*session_start();

		$data = array();
		if(!empty($params[0]))
			$data['error'] = $params[0]; 

		$loginClass = new Login();
		if($loginClass->isLogged())
			$this->view('panel', $data);
		else
			$this->view('index', $data);*/

		$this->view('questoes');
	}

	public function login(){
		session_start();
		$loginClass = new Login();
		$stats = $loginClass->login($_POST['login'], $_POST['pass']);

		if($stats){
			$this->redirect(URL);
		}else{
			$this->redirect(URL.'home/home/mismatch');
		}
	}

	public function logout(){
		session_start();
		$loginClass = new Login();
		$loginClass->logout();
		$this->redirect(URL);
	}
}
?>
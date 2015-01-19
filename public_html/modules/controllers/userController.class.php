<?php class userController extends Controller{
	public function home($params = null){	
		session_start();
		$data = array();
		$loginClass = new Login();
		$id = $loginClass->isLogged();

		if($id){
			$user = new User($id);
			$data['user'] = $user;
			$this->redirect('user/profile');
		}else
			$this->redirect('');
	}

	public function profile(){	
		session_start();
		$data = array();
		$loginClass = new Login();
		$id = $loginClass->isLogged();

		if($id){
			$user = new User($id);
			$data['user'] = $user;
			$this->redirect('user/profile');
		}else
			$this->redirect('');
	}

	public function config(){
		session_start();
		$data = array();
		$loginClass = new Login();
		$id = $loginClass->isLogged();

		if($id){
			$user = new User($id);
			$data['user'] = $user;
			$this->redirect('user/profile');
		}else
			$this->redirect('');
	}

	public function notifications(){
		session_start();

		$data = array();
		$loginClass = new Login();
		$id = $loginClass->isLogged();

		if($id){
			$user = new User($id);
			$data['user'] = $user;

			$notifClass = new Notifications();
			$notif = $notifClass->getNotifications($id);
			$messages = array();
			foreach ($notif as $i)
				$messages[$i->id] = $notifClass->getMessage($i);
			$data['messages'] = $messages;

			$this->view('user/notif', $data);
		}else
			$this->redirect('');		
	}

	public function g(){
		session_start();

		$data = array();
		$loginClass = new Login();
		$id = $loginClass->isLogged();

		if($id){
			$notif = new Notifications();
			$notif->newNotification(2,0);
		}else
			$this->redirect('');		
	}
}
?>
<?php class Controller{
	public function __construct($action, $params = null){
		if(method_exists($this, $action))
			$this->$action($params);
		else{
			require_once CONTROLLERS.'errorController.class.php';
			$error = new errorController('error404');
		}
	}

	protected function view($page, $data = null){
		if (!empty($data)) {
			extract($data);
			unset($data);
		}
		require_once VIEWS.$page.'.php';
	}

	protected function redirect($to){
		header('Location: '.URL.$to);
	}
}
?>
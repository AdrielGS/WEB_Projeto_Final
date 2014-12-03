<?php class Settings{
	private $_url;
	private $_explode;
	private $_controller;
	private $_action;
	private $_params;

	public function __construct(){
		$this->setUrl();
		$this->setExplode();
		$this->setController();
		$this->setAction();
		$this->setParams();
		$this->run();
	}

	public function setUrl(){
		$this->_url = isset($_GET['url']) ? $_GET['url'] : 'home/home';
	}

	public function setExplode(){
		$this->_explode = explode('/', $this->_url);
	}

	public function setController(){
		$this->_controller = $this->_explode[0];
	}

	public function setAction(){
		$this->_action = empty($this->_explode[1]) ? 'home' : $this->_explode[1];
	}

	public function setParams(){
		for($i=2; $i < count($this->_explode); $i++)
			$this->_params[] = $this->_explode[$i];
	}

	public function run(){
		$path = CONTROLLERS.$this->_controller.'Controller.class.php';

		if(!file_exists($path)){
			require_once CONTROLLERS.'errorController.class.php';
			$error = new error();
			$error->error404();
		}else{
			require_once $path;
			$app = new $this->_controller();

			$ac = $this->_action;
			if(method_exists($app, $ac))
				$app->$ac($this->_params);
			else{
				require_once CONTROLLERS.'errorController.class.php';
				$error = new error();
				$error->error404();
			}
		}
	}
}
?>
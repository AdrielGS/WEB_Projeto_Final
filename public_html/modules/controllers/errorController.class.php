<?php class error extends Controller{
	public function __construct(){ }

	public function error404(){
		if($_SERVER['REQUEST_URI'] != URL.'error/error404')
			$this->redirect(URL.'error/error404');
		else{
			echo 'Arquivo nao encontrado';
		}
	}

	public function error403(){
		if($_SERVER['REQUEST_URI'] != URL.'error/error403')
			$this->redirect(URL.'error/error403');
		else{
			echo 'Acesso negado';
		}
	}
}
?>
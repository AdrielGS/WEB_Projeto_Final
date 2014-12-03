<?php class Controller{
	protected function view($page, $data = null){
		if(!empty($data)){
			extract($data);
			unset($data);
		}
		require_once VIEWS.$page.'.php';
	}

	protected function redirect($to) {
		header('Location: '.$to);
	}
}
?>
<?php class errorController extends Controller{
	public function error404(){
		if($_SERVER['REQUEST_URI'] != URL.'error/error404')
			$this->redirect('error/error404');
		else{
			$this->view('404', array());
		}
	}
}
?>
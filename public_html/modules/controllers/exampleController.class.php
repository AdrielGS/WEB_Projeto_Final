<?php class exampleController extends Controller{
	public function home($params = null){
		$this->view('index');
	}

	public function example($params = null){
		$min = isset($params[0]) ? $params[0] : null;

		$data['title'] = 'Example';
		$data['params'] = $params;

		$classExample = new Example();
		$data['values'] = $classExample->exampleValues($min);

		$data['lastId'] = $classExample->addValue(rand(0,100));

		$this->view('example', $data);
	}
}
?>
<?php class example extends Controller{
	public function __construct(){ }

	public function home($params = null){
		$this->view('index');
	}

	public function example($params = null){
		$min = isset($params[0]) ? $params[0] : null;

		$data['title'] = 'Example';
		$data['params'] = $params;

		$classExample = new Exemplo();
		$data['values'] = $classExample->exampleValues($min);

		$data['lastId'] = $classExample->addValue(rand(0,100));

		$this->view('example', $data);
	}
}
?>
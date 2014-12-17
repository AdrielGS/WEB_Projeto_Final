<?php class User extends DB{
	public $regNumber;
	public $name;
	public $email;
	public $class;
	public $isTeacher;

	public function __construct($id){
		$query = DB::$conn->prepare('SELECT * FROM `users` WHERE id = :id');
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);

		$this->regNumber = $result->regnumber;
		$this->name = $result->name;
		$this->email = $result->email;
		$this->class = $result->class;
		$this->isTeacher = $result->isteacher;
	}
}
?>
<?php class DB{
	static $salt = 'd0238551f12dc39ece174b61f05c6a26';
	static $host = '127.0.0.1';
	static $dbname = 'questions';
	static $login = 'root';
	static $pass = '';
	protected static $conn;

	public function conn(){
		if(DB::$conn == null){
			try{
				DB::$conn = new PDO('mysql:host='.DB::$host.';dbname='.DB::$dbname.';charset=UTF8',
					DB::$login, DB::$pass, array(
						PDO::ATTR_PERSISTENT => true
					));
			} catch (PDOException $error) {
				echo $error->getMessage();
				exit();
			}
		}
		return DB::$conn;
	}
}
?>
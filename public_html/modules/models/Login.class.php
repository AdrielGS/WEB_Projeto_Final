<?php class Login extends DB{
	public $id;
	public $name;
	public $email;
	public $regNumber;
	public $isTeacher;

	public function __construct(){ }

	public function register($name, $pass, $email, $regNumber, $class, $isTeacher){
		$pass = hash('sha512', DB::$salt.$pass);
		$query = DB::conn()->prepare('INSERT INTO `users` (`regNumber`, `name`,
			`pass`, `email`, `class`, `isTeacher`) VALUES ( :regNumber, :name,
			:pass, :email, :class, :isteacher )');
		$query->bindValue(':regNumber', $regNumber, PDO::PARAM_STR);
		$query->bindValue(':name', $name, PDO::PARAM_STR);
		$query->bindValue(':pass', $pass, PDO::PARAM_STR);
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->bindValue(':class', $class, PDO::PARAM_INT);
		$query->bindValue(':isteacher', $isTeacher, PDO::PARAM_BOOL);
		return $query->execute();
	}

	/*
		Loga o usuário e cria a session
		Args:
			$login: numero de matricula ou e-mail do usuario
			$pass: senha do usuario
		Return:
			Retorna (bool)true caso consiga logar
			Retorna (bool)false caso ocorra um erro
	*/
	public function login($login, $pass){
		$pass = hash('sha512', DB::$salt.$pass);

		$query = DB::conn()->prepare('SELECT id FROM `users` WHERE
			(`regnumber` = :regNumber OR `email` = :email) AND `pass` = :pass');
		$query->bindValue(':regNumber', $login, PDO::PARAM_STR);
		$query->bindValue(':email', $login, PDO::PARAM_STR);
		$query->bindValue(':pass', $pass, PDO::PARAM_STR);
		$query->execute();

		if($query->rowCount() == 1){
			$result = $query->fetch(PDO::FETCH_OBJ);
			$_SESSION['login'] = $this->generateToken($result->id);
			$_SESSION['time'] = time();
			setcookie('login', $login, time() + 2592000);
			return true;
		}else{
			setcookie('login', $login);
			return false;
		}
		
	}

	/*
		Verifica se o usuario está logado e seta as variaveis da classe
		com as informações do usuário
		Args:
			$initialPage: opcional, sete como true caso esteja verificado
			se o usuário está logado na página de login, para o redirecionamento
			funcionar corretamente, default = false
		Return:
			Retorna (bool)true quando logado
			Retorna (bool)false quando não logado
			Redireciona para a página inicial com um aviso caso exista a session
				mas o login não tenha sido encontrado no banco de dados
	*/
	public function isLogged(){
		if(isset($_SESSION['login'])){
			if( empty($_SERVER['HTTP_X_FORWARDED_FOR']) ){
				$ip_address = $_SERVER['REMOTE_ADDR'];
			}else{
				$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}

			$hash = $_SESSION['login'];

			$query = DB::conn()->prepare('SELECT `id_user` FROM `tokens` WHERE
				`hash` = :hash AND `ip` = :ip');
			$query->bindValue(':hash', $hash, PDO::PARAM_STR);
			$query->bindValue(':ip', $ip_address, PDO::PARAM_STR);
			$query->execute();

			if($query->rowCount() == 1){
				$result = $query->fetch(PDO::FETCH_OBJ);
				return $result->id_user;
			}else{
				session_destroy();
				header('Location: '.URL.'home/home/expired');
			}
		}else{
			return false;
		}
	}

	private function deleteToken(){
		if(isset($_SESSION['login'])){
			$hash = htmlentities($_SESSION['login'], ENT_QUOTES, 'UTF-8');
			$query = DB::conn()->prepare('DELETE FROM `tokens` WHERE `hash` = :hash');
			$query->bindValue(':hash', $hash, PDO::PARAM_STR);
			$query->execute();
		}
	}


	private function generateToken($id){
		if( empty($_SERVER['HTTP_X_FORWARDED_FOR']) ){
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}else{
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		$hash = hash('sha256', $id.DB::$salt.date('U') );
		$ip = htmlentities($ip_address, ENT_QUOTES, 'UTF-8');     

		$query = DB::conn()->prepare('INSERT INTO `tokens` (`id_user`, `hash`,
			`ip`, `date`) VALUES (:id, :hash, :ip, NOW())');
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->bindValue(':hash', $hash, PDO::PARAM_STR);
		$query->bindValue(':ip', $ip_address, PDO::PARAM_STR);
		$query->execute();

		if($query->rowCount() == 1)
			return $hash;
		else
			return $this->generateToken($id);
	}

	public function logout(){
		$this->deleteToken();
		session_destroy();
	}
}
?>
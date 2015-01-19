<?php class Notifications extends DB{
	public function newNotification($id_user, $type, $id_link = 0, $id_aux = 0){
		$query = DB::conn()->prepare('INSERT INTO `notifications` (`id_user`,
		`type`, `id_link`, `id_aux`) VALUES (:id_user, :type, :id, :id_aux)');
		$query->bindValue(':id_user', $id_user, PDO::PARAM_INT);
		$query->bindValue(':type', $type, PDO::PARAM_INT);
		$query->bindValue(':id', $id_link, PDO::PARAM_INT);
		$query->bindValue(':id_aux', $id_aux, PDO::PARAM_INT);
		return $query->execute();
	}

	public function getNotifications($id_user){
		$query = DB::conn()->prepare('SELECT * FROM `notifications` WHERE
			`id_user` = :id_user');
		$query->bindValue(':id_user', $id_user, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}

	public function getMessage($notification){
		$type = $notification->type;
		$id = $notification->id;
		$id_aux = $notification->id_aux;
		switch($type){
			case 0:
				return 'Sua publicação no mural foi aprovada.';
				break;

			case 1:
				return 'Sua publicação no mural foi recusada.';
				break;

			case 2:
				$userInfo = new User($id_aux);
				$userName = $userInfo->name;
				return $userName.' comentou sua publicação no mural.'; 

			case 3:
				$app = new Aplicativos();
				$appInfo = $app->getInfo($id);
				$appName = $appInfo->name;
				return 'Seu aplicativo <b>'.$appName.'</b> foi aprovado.';
				break;
			
			case 4:
				$app = new Aplicativos();
				$appInfo = $app->getInfo($id);
				$appName = $appInfo->name;
				return 'Seu aplicativo <b>'.$appName.'</b> foi recusado.';
				break;

			case 5:
				$app = new Aplicativos();
				$appInfo = $app->getInfo($id);
				$appName = $appInfo->name;

				$user = new User($id_aux);
				$userName = $user->name;
				return '';
				break;
		}
	}

	public function getLink($type, $id){
		switch($type){
			case 0:
			case 1:
			case 2:
				return 'mural/post'.$id;
				break;
				
			case 3:
			case 4:
				return 'aplicativos/app/'.$id;
				break;
		}
	}
}
?>
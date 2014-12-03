<?php class Exemplo extends DB{
	public function __construct(){ }

	/*
		Retorna os valores maiores que $min da tabela examples
		Args:
			$min: opcional, valor mínimo a ser procurado, default = 50
		Return:
			Retorna vetor de objetos com as linhas encontradas:
			Ex:
				$values[0]->id = 1
				$values[0]->value = 54
				$values[1]->id = 2
				$values[1]->value = 18

	*/
	public function exampleValues($min = null){
		$min = !empty($min) ? $min : '50';

		$query = DB::conn()->prepare('SELECT * FROM `examples` WHERE `value` >= :min');
		$query->bindValue(':min', $min, PDO::PARAM_INT);
		$query->execute();

		return $query->fetchAll(PDO::FETCH_OBJ);
	}

	/*
		Adiciona uma linha na tabela examples
		Args:
			$value: valor a ser adicionado
		Return:
			Retorna 0 caso não seja possivel adicionar
			Retorna o ID da linha adicionada caso não ocorra erro
	*/
	public function addValue($value){
		$query = DB::conn()->prepare('INSERT INTO `examples` (`value`) VALUES (:valor)');
		$query->bindValue(':valor', $value, PDO::PARAM_INT);
		$query->execute();
		return DB::conn()->lastInsertId();
	}

	/*
		Deleta valores da tabela examples iguais a $value
		Args:
			$value: valor a ser deletado
		Retorn:
			Retorna a quantidade de linhas deletadas
	*/
	public function deleteValue($value){
		$query = DB::conn()->prepare('DELETE FROM `examples` WHERE `value` = :valor');
		$query->bindValue(':valor', $value, PDO::PARAM_INT);
		$query->execute();

		return $query->rowCount();
	}

	/*
		Modifica os valores encontrados por um novo valor
		Args:
			$old: valores antigos que serão modificados
			$new: valores que substituirão os antigos
		Retorn:
			Retorna a quantidade de linhas que foram modificadas
	*/
	public function updateValue($old, $new){
		$query = DB::conn()->prepare('UPDATE `examples` SET `value` = :new WHERE `value` = :old');
		$query->bindValue(':new', $new, PDO::PARAM_INT);
		$query->bindValue(':old', $old, PDO::PARAM_INT);
		$query->execute();
		
		return $query->rowCount();
	}
}
?>
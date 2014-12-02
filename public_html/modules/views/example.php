<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Example</title>
</head>
<body>
<h1>Example</h1>
<?php
	echo '<p><b>Parametros da URL: </b><br>';
	if(isset($params))
		var_dump($params);
	echo '</p>';
	echo '<p><b>Ultimo id adicionado: </b>'.$lastId.'</p>';
	echo '<b>Valores encontrados: </b>';
	var_dump($values);
	echo '<p><b>Primeiro valor: </b>'. $values[0]->value.'</p>';
	echo '<p><b>Último valor: </b>'. end($values)->value.'</p>';
?>
</body>
</html>
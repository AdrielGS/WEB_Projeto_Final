<?php include PAGES.'header.php'; ?>

<aside>
  <a href="questoes">Home</a>
  <a href="questoes/insert">Inserir</a>
  <a href="listar">Listar</a>
</aside>

<article>
	<header>

		<table id = "table">
			<form method = "POST" action = "listar/filter">
				<tr> 
					<td> Materia: </td>
					<td id="select_subject">

						<select id = "subject" name="subject">
							<option> Selecione:  </option>
							<option> Todas </option>
							<option> Materia 01 </option>
							<option> Materia 02 </option>        
						</select>

					</td>       
				</tr>

				<tr> 
					<td> Tipo: </td>
					<td><input type = "checkbox" name = "type1" id="type1" value = "1" > Aberta</td>
					<td><input type = "checkbox" name = "type2" id="type2" value = "2" > Multipla Escolha</td>
					<td><input type = "checkbox" name = "type3" id="type3" value = "3" > Verdadeiro/Falso</td>
				</tr>  
				<tr> 
					<td> Dificuldade: </td>
					<td><input type = "checkbox" name = "difficulty1" id="difficulty1" value = "1" > Fácil</td>
					<td><input type = "checkbox" name = "difficulty2" id="difficulty2" value = "2" > Médio</td>
					<td><input type = "checkbox" name = "difficulty3" id="difficulty3" value = "3" > Difícil</td>
				</tr>
				<tr>
					<td> <input type = "submit" value = "Filtrar"/></td>
					<td> <a href="listar/showAll"><input type = "button" value = "Mostrar tudo"/></a></td>
				</tr>
			</form>
		</table>

	</header>
</article>

<?php include PAGES.'footer.php'; ?>
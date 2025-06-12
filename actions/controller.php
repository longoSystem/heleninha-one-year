<?php

	/**
	 * 
	 */
	function saveGuest() {
		$conn = pg_connect("host=dpg-d1541vbe5dus73980sh0-a.ohio-postgres.render.com port=5432 dbname=heleninha_db user=heleninha_db_user password=OExfCg0LVLKE6kymhYJlU9xXRLF6I8ke");
		#$conn = pg_connect("host=localhost port=5432 dbname=heleninha_db user=postgres password=root");
		if (!$conn) {
			die("Erro na conexão: " . pg_last_error());
		}

		// Dados do formulário (exemplo)
		$name 		= pg_escape_string($conn, $_POST['name'] ?? 'João');
		$celPhone 	= pg_escape_string($conn, $_POST['celPhone'] ?? '(99) 99999-9999');
		$attendance = pg_escape_string($conn, $_POST['attendance'] ?? 'yes');
		$guests 	= $_POST['guests'];

		// Query de inserção
		$sql = "INSERT INTO guest (name, celphone, attendance, guests) VALUES ('$name', '$celPhone', '$attendance', $guests)";
		$result = pg_query($conn, $sql);

		if ($result) {
			echo "true";
		} else {
			echo $sql;
		}
		pg_close($conn);
	}

	/**
	 * 
	 */
	function loadPresentList() {
		#$conn = pg_connect("host=localhost port=5432 dbname=heleninha_db user=postgres password=root");
		$conn = pg_connect("host=dpg-d1541vbe5dus73980sh0-a.ohio-postgres.render.com port=5432 dbname=heleninha_db user=heleninha_db_user password=OExfCg0LVLKE6kymhYJlU9xXRLF6I8ke");
		if (!$conn) {
			die("Erro na conexão: " . pg_last_error());
		}

		if (!$conn) {
			die("Erro na conexão com o banco de dados: " . pg_last_error());
		}

		// Consulta SQL
		$query = "SELECT id, image, name, link, buyed FROM presents WHERE buyed = 'no' ORDER BY id ASC";

		// Executa a consulta
		$result = pg_query($conn, $query);

		if (!$result) {
			die("Erro na consulta: " . pg_last_error());
		}

		// Inicializa um array para armazenar os resultados
		$presents = [];

		// Itera sobre os resultados e adiciona ao array
		while ($row = pg_fetch_assoc($result)) {
			$presents[] = [
				'id' => $row['id'],
				'image' => $row['image'],
				'name' => $row['name'],
				'link' => $row['link'],
				'buyed' => $row['buyed']
			];
		}

		// Libera o resultado
		pg_free_result($result);

		// Fecha a conexão
		pg_close($conn);

		// Retorna o array
		return $presents;
	}
	
	/**
	 * 
	 */
	function saveBoughtThisItem() {
		echo("saveBoughtThisItem -> ");
	}
	
	/**
	 * Controller Actions.
	 */
	if (!empty($_POST['action'])) {
		switch($_POST['action']) {
			case 1:
				saveGuest();
			break;
			case 2:
				saveBoughtThisItem();
			break;
			default: "NONE";
		}
	}
	

?>
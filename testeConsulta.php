<html>
	<head>
		<title>Consulta de Municipios</title>
		<style>

			table{
				border-collapse: collapse;
			}

			td,th{
				border: 1px solid black;
			}

		</style>
	</head>
	<body>
		<center>
		<h1>Consulta de Municipios</h1>
		<p>

		<?php
		
		include_once "conexao.php";
		
		$sql = "SELECT * FROM projeto_ms.municipio";
		$result = mysqli_query($conn, $sql);

		// verifica os registros retornados
		echo "<table border=\"\">";
		echo "<tr>";
			echo "<th>Codigo</td>";
			echo "<th>Municipio</td>";
			echo "<th>UF</td>";
		echo "</tr>";
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
		{ ?>
			
				<tr>
					<td><?php echo $row[0]; ?></td>
					<td><?php echo $row[1]; ?></td>
					<td><?php echo $row[2]; ?></td>
				</tr>
		<?php
		}
		echo "</table>";

		mysqli_close($conn);
		?>

		<form action="../index.html">
			<input value="Voltar" type="submit">
		</form>

		</center>
	</body>
</html>
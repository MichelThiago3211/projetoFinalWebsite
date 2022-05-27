<?php
    include_once "../common/conexao.php";

    $nome = $_POST['nome'];
    $estado = $_POST['estado'];

    $conn = mysqli_connect($localhost, $user, $password, $banco);

    //nome, sobrenome, email, telefone, cpf, endereco, complemento, senha

	$sql = "INSERT INTO municipios (cidade, uf) VALUES ('$nome', '$estado')";
	$result = mysqli_query($conn, $sql);
        
    if (!$result) {
		echo  "<script>alert('Não foi possível conectar ao Banco de Dados!');</script>";
		header('Location: index.php');
	}
?>
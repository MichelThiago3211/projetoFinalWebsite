<?php
    include_once "conexao.php";

    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
	$sobrenome = $_POST['sobrenome'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	$cnp = $_POST['cnp'];

    //nome, sobrenome, email, telefone, cpf, endereco, complemento, senha

	$sql = "INSERT INTO municipios (cidade, uf) VALUES ('$nome', '$estado')";
	$result = mysqli_query($conn, $sql);
        
    if (!$result) {
		echo  "<script>alert('Não foi possível conectar ao Banco de Dados!');</script>";
		header('Location: index.php');
	}
?>
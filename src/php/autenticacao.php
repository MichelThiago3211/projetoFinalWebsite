<?php
	include_once "conexao.php";

	$email = $_POST['email'];
	$senha = $_POST['senha'];
	
	$sql = "SELECT * FROM fornecedor WHERE (email='$email') AND (senha='$senha')";
	$resultado = mysqli_query($conexao, $sql);

	if (mysqli_num_rows($resultado) > 0) {
		// Cria a sessão
		session_start();
		$_SESSION['email'] = $email;
		$_SESSION['senha'] = $senha;
		header('Location: ../catalogo.php');
	}
	else {
		// Volta para a tela de login
		header('Location: ../login.php');
	}
?>
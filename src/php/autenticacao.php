<?php
	// conexão
	include_once "conexao.php";

	$email = $_POST['email'];
	$senha = $_POST['senha'];
	
	$sql = "SELECT * FROM fornecedor WHERE (email='$email') AND (senha='$senha')";

	$result = mysqli_query($conn, $sql);
	$row = mysqli_num_rows($result);

	if ($row > 0)
	{
		// cria sessão
		session_start();
		$_SESSION['usuario'] = $user;
		$_SESSION['senha'] = $password;
		header('Location: ../sobre.html');
	}
	else
	{
		// volta para a tela de login
		header('Location: login.html');
	}
?>
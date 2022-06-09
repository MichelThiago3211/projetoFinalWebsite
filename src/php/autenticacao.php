<?php
	// conexão
	include_once "conexao.php";

	$email = $_POST['email'];
	$senha = $_POST['senha'];
	
	$sql = "SELECT * FROM fornecedor WHERE (email='$email') AND (senha='$senha')";

	$resultado = mysqli_query($conexao, $sql);
	$linha = mysqli_num_rows($resultado);

    var_dump($linha);

	if ($linha > 0)
	{
		// cria sessão
		session_start();
		$_SESSION['email'] = $email;
		$_SESSION['senha'] = $senha;
		header('Location: ../catalogo.php');
	}
	else
	{
		// volta para a tela de login
		header('Location: ../login.php');
	}
?>
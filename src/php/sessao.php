<?php
	// conexão
	include_once "conexao.php";

	$conn = mysqli_connect($localhost, $user, $password, $banco);

	if (!$conn)
	{
		echo  "<script>alert('Não foi possível conectar ao Banco de Dados!');</script>";
		header('Location: logout.php');
	}			

	// abre sessão
	session_start();
	if ((!isset($_SESSION["usuario"])) || (!isset($_SESSION["senha"])))
	{
		header("Location: login.html");
	}
	else
	{
		$usuario = $_SESSION["usuario"];
		$senha = $_SESSION["senha"];
	}
?>
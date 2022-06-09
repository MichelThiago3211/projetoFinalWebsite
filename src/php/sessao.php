<?php
	// conexão
	include_once "conexao.php";

	// abre sessão
	session_start();
	if ((!isset($_SESSION["email"])) || (!isset($_SESSION["senha"])))
	{
		header("Location: ../login.php");
	}
	else
	{
		$email = $_SESSION["email"];
		$senha = $_SESSION["senha"];
	}
?>
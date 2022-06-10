<?php
	include_once "conexao.php";

	// Abre a sessão
	session_start();
	if (isset($_SESSION["email"]) && isset($_SESSION["senha"])) {
		$email = $_SESSION["email"];
		$senha = $_SESSION["senha"];
	}
?>
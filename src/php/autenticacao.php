<?php
	include_once "conexao.php";

    if (!isset($email) || !isset($senha)) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
    }
	
	$sql = "SELECT id_fornecedor FROM fornecedor WHERE (email='$email') AND (senha='$senha')";
	$resultado = mysqli_query($conexao, $sql);

	if (mysqli_num_rows($resultado) > 0) {
		// Cria a sessão
		session_start();
		$_SESSION['id_fornecedor'] = mysqli_fetch_array($resultado, MYSQLI_NUM)[0];
		header('Location: ../catalogo.php');
	}
	else {
		// Volta para a tela de login
		header('Location: ../login.php');
	}
?>
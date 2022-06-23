<?php

include_once "conexao.php";

// Permite com que esse arquivo seja chamado por um form ou por outros arquivos.
if (!isset($email) || !isset($senha)) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
}

$senhaCriptografada = hash("sha256", $senha);

// Busca o ID do fornecedor que possui as informações passadas
$stm = $conexao->prepare("SELECT id_fornecedor FROM fornecedor WHERE email=? AND senha=?");
$stm->bind_param("ss", $email, $senhaCriptografada);
$stm->execute();
$res = $stm->get_result();

// Se encontrou, inicia a sessão
if ($res->num_rows > 0) {
    session_start();
    $_SESSION["id_fornecedor"] = $res->fetch_array()[0];
    header("Location: ../catalogo");
}
else {
    header("Location: ../login");
}
<?php

include_once "conexao.php";

$id = $_GET["id"];

$stm = $conexao->prepare("UPDATE fornecedor SET ativo = 1 WHERE id_fornecedor = ?");
$stm->bind_param("i", $id);
$stm->execute();

header("Location: ../perfil?id=$id");
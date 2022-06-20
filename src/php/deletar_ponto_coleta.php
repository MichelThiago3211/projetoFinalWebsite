<?php

include_once "sessao.php";

$id = $_GET["id"] ?? false;

if ($id) {
    $stm = $conexao->prepare("DELETE FROM ponto_coleta WHERE id_ponto_coleta = ?");
    $stm->bind_param("i", $id);
    $stm->execute();
}

header("Location: ../catalogo");
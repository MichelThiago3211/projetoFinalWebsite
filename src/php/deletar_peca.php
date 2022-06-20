<?php

include_once "sessao.php";

$id = $_GET["id"] ?? false;

if ($id) {
    $stm = $conexao->prepare("SELECT imagem FROM imagem_peca WHERE id_peca = ?");
    $stm->bind_param("i", $id);
    $stm->execute();
    $res = $stm->get_result();
    
    while ($imagem = $res->fetch_array()) {
        unlink("../" . $imagem[0]);
    }

    $stm = $conexao->prepare("DELETE FROM imagem_peca WHERE id_peca = ?");
    $stm->bind_param("i", $id);
    $stm->execute();

    $stm = $conexao->prepare("DELETE FROM peca WHERE id_peca = ?");
    $stm->bind_param("i", $id);
    $stm->execute();
}

header("Location: ../catalogo");
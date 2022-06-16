<?php

include_once "conexao.php";

function buscarIdMunicipio($cidade, $uf) {
    global $conexao;
    
    $stm = $conexao->prepare("SELECT id_municipio FROM municipio WHERE nome = ? AND estado = ?");
    $stm->bind_param("ss", $cidade, $uf);
    $stm->execute();
    $res = $stm->get_result();
    
    if ($res->num_rows > 0) {
        return $res->fetch_array()[0];
    }

    $stm = $conexao->prepare("INSERT INTO municipio (nome, estado) VALUES (?, ?)");
    $stm->bind_param("ss", $cidade, $uf);
    $stm->execute();
    return $conexao->insert_id;
}
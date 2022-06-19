<?php

include_once "conexao.php";

// Retorna o ID do município com o nome e estado passados, inserindo-o no banco caso necessário
function buscarIdMunicipio($cidade, $uf) {
    global $conexao;
    
    // Busca o município
    $stm = $conexao->prepare("SELECT id_municipio FROM municipio WHERE nome = ? AND estado = ?");
    $stm->bind_param("ss", $cidade, $uf);
    $stm->execute();
    $res = $stm->get_result();
    
    // Se encontrou, retorna o ID
    if ($res->num_rows > 0) {
        return $res->fetch_array()[0];
    }

    // Se não encontrou, insere no banco
    $stm = $conexao->prepare("INSERT INTO municipio (nome, estado) VALUES (?, ?)");
    $stm->bind_param("ss", $cidade, $uf);
    $stm->execute();
    return $conexao->insert_id;
}
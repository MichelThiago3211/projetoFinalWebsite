<?php

include_once "sessao.php";

// Dados
$tamanho = $_POST["tamanho"];
$cor = $_POST["cor"];
$descricao = $_POST["descricao"];
$titulo = $_POST["titulo"];
$preco = $_POST["preco"];
$idCategoria = $_POST["categoria"];
$idPontoColeta = $_POST["ponto-coleta"];

$stm = $conexao->prepare("INSERT INTO peca (tamanho, cor, descricao, titulo, preco, id_categoria_peca, id_ponto_coleta) values (?, ?, ?, ?, ?, ?, ?)");
$stm->bind_param("isssiii", $tamanho, $cor, $descricao, $titulo, $preco, $idCategoria, $idPontoColeta);
$stm->execute();
$res = $stm->get_result();

// Imagens

foreach ($_FILES as $img) {
    // TODO
}
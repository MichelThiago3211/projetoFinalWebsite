<?php

include_once "sessao.php";

// Dados
$tamanho = $_POST["tamanho"];
$cor = $_POST["cor"];
$descricao = $_POST["descricao"];
$titulo = $_POST["titulo"];
$preco = $_POST["preco"] * 100;
$idCategoria = $_POST["categoria"];
$idPontoColeta = $_POST["ponto-coleta"];

$stm = $conexao->prepare("INSERT INTO peca (tamanho, cor, descricao, titulo, preco, id_categoria_peca, id_ponto_coleta) values (?, ?, ?, ?, ?, ?, ?)");
$stm->bind_param("isssiii", $tamanho, $cor, $descricao, $titulo, $preco, $idCategoria, $idPontoColeta);
$stm->execute();
$res = $stm->get_result();

// Imagens

$numImagens = count($_FILES["imagens"]["name"]);
$idPeca = $conexao->insert_id;

// Adiciona cada uma das imagens inseridas na tabela imagem_peca
for ($i = 0; $i < $numImagens; $i++) {
    $extensao = pathinfo($_FILES["imagens"]["name"][$i], PATHINFO_EXTENSION);
    $imagemCaminho = "../imagens/peca/".$idPeca."_".$i.".".$extensao;

    $movido = move_uploaded_file($_FILES["imagens"]["tmp_name"][$i], '../'.$imagemCaminho);
    if (!$movido) {
        echo "<script>alert('Erro ao salvar imagem');</script>";
        header("Location: ../adicionar_peca");
    }
    $stm = $conexao->prepare("INSERT INTO imagem_peca (imagem, id_peca) values (?, ?)");
    $stm->bind_param("si", $imagemCaminho, $idPeca);
    $stm->execute();
}
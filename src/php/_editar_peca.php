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

// Se um ID for passado, a operação é de edição
if (isset($_POST["id"])) {
    $id = $_POST["id"];
}
$edicao = isset($id);

if ($edicao) {
    $stm = $conexao->prepare("UPDATE peca SET tamanho=?, cor=?, descricao=?, titulo=?, preco=?, id_categoria_peca=?, id_ponto_coleta=? WHERE id_peca=?");
    $stm->bind_param("isssiiii", $tamanho, $cor, $descricao, $titulo, $preco, $idCategoria, $idPontoColeta, $id);
    $stm->execute();
}
else {
    $stm = $conexao->prepare("INSERT INTO peca (tamanho, cor, descricao, titulo, preco, id_categoria_peca, id_ponto_coleta) values (?, ?, ?, ?, ?, ?, ?)");
    $stm->bind_param("isssiii", $tamanho, $cor, $descricao, $titulo, $preco, $idCategoria, $idPontoColeta);
    $stm->execute();
    $id = $conexao->insert_id;
}

// Imagens

if ($_FILES["imagens"]["size"][0] == 0) {
    header("Location: ../perfil?id=$idSessao");
    exit;
}

$numImagens = count($_FILES["imagens"]["name"]);

if ($edicao) {
    
    // Remove as imagens antigas do diretório
    $stm = $conexao->prepare("SELECT imagem FROM imagem_peca WHERE id_peca = ?");
    $stm->bind_param("i", $id);
    $stm->execute();
    $res = $stm->get_result();

    while ($linha = $res->fetch_assoc()) {
        unlink("../" . $linha["imagem"]);
    }

    // Remove as imagens antigas do banco de dados
    $stm = $conexao->prepare("DELETE FROM imagem_peca WHERE id_peca = ?");
    $stm->bind_param("i", $id);
    $stm->execute();
}

// Adiciona cada uma das imagens inseridas na tabela imagem_peca
for ($i = 0; $i < $numImagens; $i++) {
    $extensao = pathinfo($_FILES["imagens"]["name"][$i], PATHINFO_EXTENSION);
    $imagemCaminho = "../imagens/peca/".$id."_".$i.".".$extensao;

    $movido = move_uploaded_file($_FILES["imagens"]["tmp_name"][$i], '../'.$imagemCaminho);
    if (!$movido) {
        echo "<script>alert('Erro ao salvar imagem');</script>";
        header("Location: ../perfil?id=$idSessao");
    }
    $stm = $conexao->prepare("INSERT INTO imagem_peca (imagem, id_peca) values (?, ?)");
    $stm->bind_param("si", $imagemCaminho, $id);
    $stm->execute();
}

header("Location: ../perfil?id=$idSessao");
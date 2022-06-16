<?php

include_once "sessao.php";
include_once "buscar_municipio.php";

// Dados
$cep = $_POST["cep"];
$cidade = $_POST["cidade"];
$uf = $_POST["uf"];
$rua = $_POST["rua"];
$numero = $_POST["numero"];
$referencia = $_POST["referencia"];
$complemento = $_POST["complemento"];
$horario = $_POST["horario"];

$idMunicipio = buscarIdMunicipio($cidade, $uf);

// Se um ID for passado, a operação é de edição
if (isset($_POST["id"])) {
    $id = $_POST["id"];
}
$edicao = isset($id);

if ($edicao) {
    $stm = $conexao->prepare("UPDATE ponto_coleta SET horario=?, complemento=?, numero=?, rua=?, cep=?, id_municipio=?, referencia=? WHERE id_ponto_coleta=?");
    $stm->bind_param("ssisiisi", $horario, $complemento, $numero, $rua, $cep, $idMunicipio, $referencia, $id);
    $stm->execute();
}
else {
    $stm = $conexao->prepare("INSERT INTO ponto_coleta (horario, complemento, numero, rua, cep, id_municipio, id_fornecedor, referencia, sede) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
    $stm->bind_param("ssisiiis", $horario, $complemento, $numero, $rua, $cep, $idMunicipio, $idSessao, $referencia);
    $stm->execute();
    $id = $conexao->insert_id;
}

header("Location: ../perfil?id=$idSessao");
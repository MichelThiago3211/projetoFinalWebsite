<?php

include_once "conexao.php";

$idPeca = $_GET['id'];
$nome = $_POST["nome"];
$cpf = $_POST["cpf"];
$dataAtual = date("Y-m-d H:i:s");

$stm = $conexao->prepare("INSERT INTO reserva (nome, cpf, data) VALUES (?, ?, ?)");
$stm->bind_param("sss", $nome, $cpf, $dataAtual);
$stm->execute();

$idReserva = $stm->insert_id;

$stm = $conexao->prepare("update peca set id_reserva = ? where id_peca = ?");
$stm->bind_param("ii", $idReserva, $idPeca);
$stm->execute();

header("Location: ../catalogo");
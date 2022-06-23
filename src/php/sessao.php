<?php

include_once "conexao.php";

session_start();
if (isset($_SESSION["id_fornecedor"])) {
    $idSessao = $_SESSION["id_fornecedor"];
}
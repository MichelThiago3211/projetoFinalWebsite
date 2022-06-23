<?php

include "env.php";

$endereco = $_ENV['DB_ENDERECO'];
$usuario = $_ENV['DB_USUARIO'];
$senha = $_ENV['DB_SENHA'];
$banco = $_ENV['DB_BANCO'];

$conexao = mysqli_connect($endereco, $usuario, $senha, $banco);

if (!$conexao) {
    echo "<script>alert('Não foi possível conectar ao banco de dados.');</script>";
}
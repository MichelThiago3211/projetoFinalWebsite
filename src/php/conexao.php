<?php
  $endereco = "localhost";
  $usuario = "root";
  $senha = "projeto_MS_2022";
  $banco = "projeto_ms";

  $conn = mysqli_connect($endereco, $usuario, $senha, $banco);

  if (!$conn) {
    echo "<script>alert('Não foi possível conectar ao banco de dados.');</script>";
  }
?>
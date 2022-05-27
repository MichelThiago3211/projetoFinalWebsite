<?php
  $endereco = "192.168.20.3";
  $usuario = "root";
  $senha = "12345";
  $banco = "projeto_ms";

  $conn = mysqli_connect($endereco, $usuario, $senha, $banco);

  if (!$conn) {
    echo "<script>alert('Não foi possível conectar ao banco de dados.');</script>";
  }
?>
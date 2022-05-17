<?php

    // conexão com o banco
    $localhost = "192.168.20.3";
    $user = "root";
    $password = "12345";
    $banco = "projeto_ms";

    $conn = mysqli_connect($localhost, $user, $password, $banco);

    if (!$conn)
    {
        echo  "<script>alert('Não foi possível conectar ao Banco de Dados!');</script>";
        header('Location: index.php');
    }

?>
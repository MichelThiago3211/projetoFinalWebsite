<?php
    foreach (parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/projetoFinalWebsite/.env') as $variavel => $valor) {
        $_ENV[$variavel] = $valor;
    }
?>
<?php
    // Lê as variáveis de ambiente do arquivo '.env' e as armazena em '$_ENV'
    foreach (parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/projetoFinalWebsite/.env') as $variavel => $valor) {
        $_ENV[$variavel] = $valor;
    }
?>
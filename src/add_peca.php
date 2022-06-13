<?php
    include_once "php/sessao.php";

    // Asserta que haja uma sessão em aberto
    if (!isset($idSessao)) {
        header("Location: login");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar peça</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/add_peca.css">

    <!-- Javascript -->
    <script src="js/add_peca.js" type="module"></script>

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <!-- Ícones -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
</head>
<body>
    <?php include "_header.php"; ?>

    <main>
        <form action="">
            <h1>Adicionar nova peça</h1>
            <fieldset id="imagens-fs">
                <h2>Imagens</h2>
                <div id="imagens">
                    <?php
                        // mostrar imagens
                    ?>
                    <label id="add-imagem" class="img-cont">
                        <i class="fa fa-plus fa-2x" aria-hidden="true"></i>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1MB / elemento exigido pelo PHP -->
                        <input type="file" multiple name="imagens" id="imagens-input" accept="image/png, image/jpeg">
                    </label>
                </div>
            </fieldset>
            <fieldset id="dados-fs"></fieldset>
            <fieldset id="descricao-fs"></fieldset>
        </form>
    </main>
</body>
</html>
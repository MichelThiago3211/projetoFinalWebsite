<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="styleCadastroPF.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
</head>
<body>
    <?php
        include_once "../conexao.php";
    ?>
    <form id="cadastroPF-forms" action="adicionarPF.php" method="post" class="flex-coluna">
        <div id="header-form">
            <h1>Cadastro Pessoa física</h1>
            <i class="fa fa-home fa-2x" aria-hidden="true"></i>
        </div>
        <div>
            <input class="campo" type="text" placeholder="Nome">
            <input class="campo" type="text" placeholder="Sobrenome">
        </div>
        <div>
            <input class="campo" type="email" placeholder="Email">
            <input class="campo" type="text" placeholder="Telefone">
        </div>
        <div>
            <input class="campo" type="text" placeholder="CPF">
        </div>
        <div>
            <input id="endereco" class="campo" type="text" placeholder="Endereço">
        </div>
        <div>
            <input class="campo" type="text" placeholder="Complemento">
        </div>
        <div>
            <input class="campo" type="password" placeholder="Senha">
            <input class="campo" type="password" placeholder="Confirmar senha">
        </div>

        <?php
            
            
        
        ?>

        <input type="submit" id="botao-cadastroPF" value="Cadastre-se">

        
     
    </form>
</body>
</html>
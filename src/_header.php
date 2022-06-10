<?php
    include_once "php/sessao.php";

    $nome = false;

    if (isset($email)) {
        $sql = "select nome, imagem from fornecedor where email='$email' && senha='$senha'";
        $resultado = mysqli_query($conexao, $sql);

        $linha = mysqli_fetch_array($resultado, MYSQLI_NUM);
        $nome = $linha[0];
        $logo = $linha[1];
    }
?>

<link href="css/header.css" rel="stylesheet">
<header>
    <div id="logo">
        <img src="img/logo_branco.png" alt="Logo">
        <h1>Site Supremo</h1>
    </div>
    <nav>
        <a href="cadastro.php">HOME</a>
        <a href="catalogo.php">CATÁLOGO</a>
        <a href="sobre.html">SOBRE NÓS</a>
    </nav>
    <div id="usuario">
        <?php
            if ($nome) {
                echo "<a href='perfil.php'>$nome";
            }
            else {
                echo "<a href='login.php'>Login";
            }
        ?>
        <?php
            if (isset($logo)) {
                echo "<img src='$logo' alt='Logo'>";
            }
        ?>
        </a>
    </div>
</header>
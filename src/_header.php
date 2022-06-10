<?php
    include_once "php/sessao.php";

    if (isset($idSessao)) {
        $sql = "select nome, imagem from fornecedor where id_fornecedor='$idSessao'";
        $resultado = mysqli_query($conexao, $sql);

        $linha = mysqli_fetch_array($resultado, MYSQLI_NUM);
        $nome = $linha[0];
        $logo = $linha[1];
    }
?>

<link href="css/header.css" rel="stylesheet">
<header>
    <a id="logo" href="cadastro.php">
        <img src="img/logo_branco.png" alt="Logo">
        <h1>Site Supremo</h1>
    </a>
    <nav>
        <a href="cadastro.php">HOME</a>
        <a href="catalogo.php">CATÁLOGO</a>
        <a href="sobre.php">SOBRE NÓS</a>
    </nav>
    <div id="usuario">
        <?php
            if (isset($idSessao)) {
                echo "<a href='perfil.php?id_fornecedor=$idSessao'>$nome";
                if ($logo != null) {
                    echo "<img src='$logo' alt='Logo'>";
                }
            }
            else {
                echo "<a href='login.php'>Login";
            }
        ?>
        </a>
    </div>
</header>
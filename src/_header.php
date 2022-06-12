<?php
    include_once "php/sessao.php";

    if (isset($idSessao)) {
        $stm = $conexao->prepare("select nome, imagem from fornecedor where id_fornecedor=?");
        $stm->bind_param("i", $idSessao);
        $stm->execute();
        $res = $stm->get_result();

        if ($res->num_rows == 0) {
            header("Location: php/logout.php");
        }
        
        $valores = $res->fetch_assoc();
        $nome = $valores["nome"];
        $logo = $valores["imagem"];
    }
?>

<link href="css/header.css" rel="stylesheet">

<header>
    <a id="logo" href="cadastro.php">
        <img src="img/logo_branco.png" alt="Logo">
        <h1>Site Supremo</h1>
    </a>
    <nav>
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
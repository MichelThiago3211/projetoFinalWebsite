<?php
    include_once "php/sessao.php";

    // Verifica se há uma sessão aberta
    if (isset($idSessao)) {

        // Caso haja, busca o nome e imagem do fornecedor
        $stm = $conexao->prepare("select nome, imagem from fornecedor where id_fornecedor=?");
        $stm->bind_param("i", $idSessao);
        $stm->execute();
        $res = $stm->get_result();

        // Se existir uma sessão aberta mas o usuário não existir, redireciona para o login
        if ($res->num_rows == 0) {
            header("Location: php/logout");
            exit;
        }
        
        // Pega os dados do usuário
        $valores = $res->fetch_assoc();
        $nome = $valores["nome"];
        $logo = $valores["imagem"] ?? "img/perfil.png";
    }
?>

<link href="css/header.css" rel="stylesheet">

<header>
    <a class="logo" href="catalogo">
        <img src="img/logo_branco.png" alt="Logo">
        <h1 class="desktop">Nome do Site</h1>
    </a>
    <div class="usuario">
        <!-- Se estiver logado, exibe o perfil do usuário; caso contrário, um botão de login -->
        <?php if (isset($idSessao)): ?>
            <div>
                <a class="desktop" href="perfil?id=<?= $idSessao ?>"><h2><?= $nome ?></h2></a>
                <a class="desktop" href="php/logout" id="sair">Sair</a>
            </div>
            <a href="perfil?id=<?= $idSessao ?>"><img src="<?= $logo ?>" alt="Logo"></a>
            <a href="php/logout" class="botao transparente mobile">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        <?php else: ?>
            <a href="login" class="botao transparente">Login</a>
        <?php endif; ?>
    </div>
</header>
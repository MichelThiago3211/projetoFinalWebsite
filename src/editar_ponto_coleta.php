<?php
    include_once "php/sessao.php";
    include_once "model/ponto_coleta.php";

    // Assegura que haja uma sessão em aberto
    if (!isset($idSessao)) {
        header("Location: login");
        exit;
    }

    // Caso um ID tenha sido passado na URL, a operação é de edição
    $id = $_GET["id"] ?? -1;
    $edicao = $id != -1;

    if ($edicao) {
        // Consulta os dados do ponto de coleta
        $stm = $conexao->prepare("SELECT * FROM ponto_coleta WHERE id_ponto_coleta = ?");
        $stm->bind_param("i", $id);
        $stm->execute();
        $res = $stm->get_result();

        $pontoColeta = PontoColeta::ler($res->fetch_assoc());

        // Verifica se o usuário tem permissão para editar o ponto de coleta
        if ($pontoColeta->fornecedor != $idSessao) {
            header("Location: login");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $edicao ? "Editar" : "Adicionar" ?> ponto de coleta</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/editar_ponto_coleta.css">

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include "_header.php"; ?>

    <main>
        <form action="php/_editar_ponto_coleta" method="post" enctype="multipart/form-data">
            <h1><?= $edicao ? "Editar" : "Adicionar" ?> ponto de coleta</h1>

            <?php if ($edicao): ?>
                <input type="hidden" name="id" value="<?= $id ?>">
            <?php endif; ?>

            <?php include "_endereco.php"; ?>

            <!-- Horário -->
            <div class="campo" id="horario">
                <textarea type="text" maxlength=250 name="horario"><?= $pontoColeta->horario ?? "" ?></textarea>
                <label>Horário de funcionamento</label>
            </div>

            <!-- Confirmação -->
            <input type="submit" class="botao" value="<?php echo $edicao ? "Editar" : "Adicionar"; ?>">
        </form>
    </main>
</body>
</html>
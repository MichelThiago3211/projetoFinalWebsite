<?php     
    include_once "php/sessao.php";
    include_once "model/peca.php";

    // Pega o ID da peça na URL
    $id = $_GET['id'] ?? false;
    if (!$id) {
        header("Location: catalogo");
        exit;
    }

    // Busca a peça no banco de dados
    $stm = $conexao->prepare("SELECT * FROM peca WHERE id_peca = ?");
    $stm->bind_param("i", $id);
    $stm->execute();
    $res = $stm->get_result();

    if ($res->num_rows == 0) {
        header("Location: catalogo");
        exit;
    }

    $peca = Peca::ler($res->fetch_assoc());
    $dono = $peca->pontoColeta()->fornecedor == ($idSessao ?? -1);

    $urlImagens = array_map(fn($img) => "'".$img->caminho."'", $peca->imagens());
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $peca->titulo ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/ver_peca.css">

    <!-- JavaScript -->
    <script src="js/ver_peca.js" defer></script>

    <?php include "_fontes.php" ?>
</head>
<body>
    <?php include "_header.php"; ?>

    <script>
        window.imagens = [<?= implode(",", $urlImagens) ?>];
    </script>

    <main>
        <div id="peca" class="box">
            <?php if ($dono): ?>
                <a id="botao-editar" href="editar_peca?id=<?= $id ?>">
                    <i class="fa fa-2x fa-edit"></i>
                </a>
            <?php endif; ?>

            <!-- Imagens -->
            <div id="carrossel" style="background-image: url('<?= $peca->imagens()[0]->caminho ?>');">
                <div id="controles">
                    <i class="fa fa-angle-left" id="anterior"></i>
                    <i class="fa fa-angle-right" id="proxima"></i>
                </div>
            </div>

            <!-- Informações -->
            <div id="informacoes">
                <!-- Título -->
                <h1><?= $peca->titulo ?></h1>

                <!-- Descrição -->
                <p id="descricao"><?= $peca->descricao ?></p>
                <span id="dados-lista">
                    <!-- Categoria -->
                    <span>
                        <i class="fa fa-tag"></i>
                        <?= $peca->categoria()->descricao ?>
                    </span>

                    <!-- Tamanho -->
                    <span>
                        <i class="fa fa-arrows-v"></i>
                        Tamanho <?= Peca::$tamanhos[$peca->tamanho] ?? $peca->tamanho ?>
                    </span>

                    <!-- Cor -->
                    <span>
                        <i class="fa fa-paint-brush"></i>
                        <?= Peca::$cores[$peca->cor] ?>
                    </span>
                </span>
            </div>
        </div>

        <!-- Ponto de coleta -->
        <div id="ponto-coleta" class="box">
            <iframe
                height="100%" width="100%" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed/v1/place?key=<?= $_ENV["MAPS_API"] ?>&q=<?= urlencode($peca->pontoColeta()->formatar()) ?>">
            </iframe>
            <div>
                <?php
                    $endereco = $peca->pontoColeta();
                    $municipio = $endereco->municipio();
                ?>

                <h2>Distribuído por <a href="perfil?id=<?= $endereco->fornecedor ?>"><?= $endereco->fornecedor()->nome ?></a></h2>
                <p>
                    <?php if ($endereco->referencia != ""): ?>
                        <b><?= $endereco->referencia ?></b>
                        <br>
                    <?php endif; ?>

                    <?= $endereco->rua . ", " . $endereco->numero ?><br>
                    <?= $municipio->nome . " - " . $municipio->estado ?><br>
                    <br>
                    <b>Horário de funcionamento:</b><br>
                    <span id="horario"><!--
                     --><?= $endereco->horario != "" ? $endereco->horario : "<i>Não informado</i>" ?>
                    </span>
                </p>
            </div>
        </div>

        <form id="reserva" action="php/reservar?id=<?= $id ?>" method="post" class="box">
            <h2>Reservar</h2>
            <div class="campo">
                <input type="text" name="nome" required>
                <label>Nome</label>
            </div>
            <div class="campo">
                <input type="text" name="cpf" required autocomplete="off" pattern="[0-9]{11}" placeholder="___.___.___-__">
                <label>CPF</label>
            </div>
            <input type="submit" value="Reservar" class="botao">
            <div id="preco">Custo: <?= $peca->preco == 0? "Gratuito" : "R$ " . number_format((float)$peca->preco, 2, ',', '') ?></div>
        </form>
    </main>
</body>
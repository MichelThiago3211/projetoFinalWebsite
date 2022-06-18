<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre nós</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/ver_peca.css">

    <!-- Javascript -->
    <script src="js/ver_peca.js" defer></script>

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- Ícones -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
</head>
<body>
    <?php 
        include "_header.php";
        
        include_once "php/sessao.php";
        include_once "model/peca.php";

        $id = $_GET['id'];

        $stm = $conexao->prepare("SELECT * FROM peca WHERE id_peca = ?");
        $stm->bind_param("i", $id);
        $stm->execute();
        $res = $stm->get_result();

        if ($res->num_rows == 0) {
            ?>
                <main style = "display: flex; justify-content: center; align-items: center;">
                    <h1>Peça não encontrada</h1>
                </main>
                </body>
                </html>
            <?php
            exit;
        }

        $peca = Peca::ler($res->fetch_assoc());
        $dono = $peca->pontoColeta()->fornecedor == ($idSessao ?? -1);
        $urlImagens = array_map(fn($img) => "'".$img->caminho."'", $peca->imagens());
    ?>

    <script>
        window.imagens = [<?= implode(",", $urlImagens) ?>];
    </script>

    <main>
        <div id="peca">
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
                <div id="descricao"><?= $peca->descricao ?></div>
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
        <div id="ponto-coleta">
            <iframe
                height="100%" width="100%" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed/v1/place?key=<?= $_ENV["MAPS_API"] ?>&q=<?= urlencode($peca->pontoColeta()->formatar()) ?>">
            </iframe>
            <div>
                <?php
                    $endereco = $peca->pontoColeta();
                    $municipio = $endereco->municipio();
                ?>

                <h2>Ponto de coleta</h2>
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

        <form id="reserva" action="php/reservar?id=<?= $id ?>" method="post">
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
        </form>
    </main>
</body>
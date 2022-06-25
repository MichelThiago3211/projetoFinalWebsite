<?php
    include_once "php/sessao.php";
    include_once "model/ponto_coleta.php";   
    include_once "model/peca.php";
    include_once "model/fornecedor.php";
    
    $id = $_GET["id"];
    
    // Se os IDs forem iguais, o usuário é o dono do perfil
    $dono = isset($idSessao) && $idSessao == $id;

    // Consulta os dados do fornecedor
    $stm = $conexao->prepare("SELECT * FROM fornecedor WHERE id_fornecedor = ?");
    $stm->bind_param("i", $id);
    $stm->execute();
    $res = $stm->get_result();

    // Se o perfil não existir, volta para o catálogo
    if ($res->num_rows == 0) {
        header("Location: catalogo");
        exit;
    }

    // Dados do fornecedor
    $fornecedor = Fornecedor::ler($res->fetch_assoc());
    $imagem = $fornecedor->imagem ?? "img/perfil.png";

    // Consulta os pontos de coleta do fornecedor
    $stm = $conexao->prepare("SELECT * FROM ponto_coleta WHERE id_fornecedor = ?");
    $stm->bind_param("i", $id);
    $stm->execute();
    $res = $stm->get_result();

    $pontosColeta = array();
    while ($ponto = $res->fetch_assoc()) {
        $p = PontoColeta::ler($ponto);
        $pontosColeta[] = $p;
    }

    // Consulta as peças do fornecedor
    $stm = $conexao->prepare("SELECT * FROM peca WHERE (SELECT id_fornecedor FROM ponto_coleta WHERE ponto_coleta.id_ponto_coleta = peca.id_ponto_coleta) = ? ORDER BY titulo;");
    $stm->bind_param("i", $id);
    $stm->execute();
    $res = $stm->get_result();

    $pecas = array();
    while ($linha = $res->fetch_assoc()) {
        $pecas[] = Peca::ler($linha);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $fornecedor->nome ?></title>

    <!-- JavaScript -->
    <script src="js/perfil.js" defer></script>
    <script>
        window.urlMapa = "https://www.google.com/maps/embed/v1/place?key=<?= $_ENV["MAPS_API"] ?>&q=";
    </script>

    <!-- CSS -->
    <link rel="stylesheet" href="css/perfil.css">
    
    <?php include "_fontes.php" ?>
</head>
<body>
    <?php include "_header.php" ?>

    <main>
        <div id="dados" class="box">
            <h2><?= $fornecedor->nome ?></h2>
            <img id="logo" src="<?= $imagem ?>" alt="<?= $fornecedor->nome ?>"></h2>
            <p>
                <b>Telefone:</b> <?= $fornecedor->telefoneFormatado() ?><br>
                <b>Email:</b> <?= $fornecedor->email ?><br>
                <b>Tipo:</b> <?= $fornecedor->tipo? "Instituição" : "Brechó" ?><br>
            </p>
        </div>

        <div id="pontos-coleta" class="box">
            <iframe
                height="100%" width="100%" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed/v1/place?key=<?= $_ENV["MAPS_API"] ?>&q=<?= urlencode($pontosColeta[0]->formatar()) ?>">
            </iframe>
            
            <div id="pontos-lista">
                <h2>Pontos de coleta</h2>
                
                <?php if($dono): ?>
                    <?php if ($fornecedor->ativo): ?>
                        <a href="editar_ponto_coleta" class="botao">Adicionar ponto de coleta</a>
                    <?php else: ?>
                        <a href="" class="botao desabilitado" title="Sua conta ainda não está ativa">Adicionar ponto de coleta</a>
                    <?php endif; ?>
                <?php endif; ?>
    
                <?php foreach($pontosColeta as $pc): ?>
                    <div class="endereco <?= $pc->sede? "sede" : ""?>" onclick="alterarMapa('<?= $pc->formatar() ?>')">
                        <i class="fa fa-2x <?= $pc->sede? "fa-flag" : "fa-map-marker"?>" aria-hidden="true"></i>
                        <div>
                            <?php if($pc->referencia != ""): ?>
                                <span><b><?= $pc->referencia?></b></span><br>
                            <?php endif; ?>
                            <span><?= $pc->formatar()?></span><br>
                            <span><b>Horário de funcionamento: </b><br>
                            <?= $pc->horario? "$pc->horario" : "<i>Não informado</i>"?></span>
                        </div>

                        <?php if($dono && $fornecedor->ativo): ?>
                            <div class="editar-ponto-coleta">
                                <a href="editar_ponto_coleta?id=<?= $pc->id ?>"><i class="fa fa-edit fa-2x"></i></a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                
            </div>
        </div>
        <div id="pecas" class="box">
            <div class="controles">
                <h2 class="mobile">Peças</h2>
                
                <?php if($dono): ?>
                    <?php if ($fornecedor->ativo): ?>
                        <a href="editar_peca" id="add-peca" class="botao">Adicionar peça</a>
                    <?php else: ?>
                        <a href="" class="botao desabilitado" id="add-peca" title="Sua conta ainda não está ativa">Adicionar peça</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div id="lista-pecas">
                <?php include "_pecas.php"; ?>
            </div>
        </div>
    </main>
</body>
</html>
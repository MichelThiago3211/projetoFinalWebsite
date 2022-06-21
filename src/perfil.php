<?php
    include_once "php/sessao.php";
    include_once "model/ponto_coleta.php";   
    include_once "model/peca.php";
    include_once "model/fornecedor.php";
    
    $idGet = $_GET["id"];
    
    // Se os IDs forem iguais, o usuário é o dono do perfil
    $dono = isset($idSessao) && $idSessao == $idGet;

    // Consulta os dados do fornecedor
    $stm = $conexao->prepare("SELECT * FROM fornecedor WHERE id_fornecedor = ?");
    $stm->bind_param("i", $idGet);
    $stm->execute();
    $res = $stm->get_result();

    // Se o perfil não existir, volta para o catálogo
    if ($res->num_rows == 0) {
        header("Location: catalogo");
        exit;
    }

    // Dados do fornecedor
    $dados = $res->fetch_assoc();
    $nome = $dados["nome"];
    $imagem = $dados["imagem"] ?? "img/perfil.png";
    $telefone = $dados["telefone"];
    $email = $dados["email"];
    
    $telefoneFormatado = "(".substr($telefone, 0, 2).") ".substr($telefone, 2, 5)."-".substr($telefone, 7, 4);

    // Consulta os pontos de coleta do fornecedor
    $stm = $conexao->prepare("SELECT * FROM ponto_coleta WHERE id_fornecedor = ?");
    $stm->bind_param("i", $idGet);
    $stm->execute();
    $res = $stm->get_result();

    $sedes = array();
    $pontos = array();

    while ($ponto = $res->fetch_assoc()) {
        $p = PontoColeta::ler($ponto);
        
        if ($ponto["sede"]) {
            $sedes[] = $p;
        } else {
            $pontos[] = $p;
        }
    }

    // Consulta as peças do fornecedor
    $stm = $conexao->prepare("SELECT * FROM peca WHERE (SELECT id_fornecedor FROM ponto_coleta WHERE ponto_coleta.id_ponto_coleta = peca.id_ponto_coleta) = ?;");
    $stm->bind_param("i", $idGet);
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
    <title>Catálogo</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/perfil.css">
    
    <?php include "_fontes.php" ?>
</head>
<body>
    <?php include "_header.php" ?>

    <main>
        <div id="dados" class="box">
            <h2><?= $nome ?></h2>
            <img id="logo" src="<?= $imagem ?>" alt="<?= $nome ?>"></h2>
            <p>
                <b>Telefone:</b> <?= $telefoneFormatado ?><br>
                <b>Email:</b> <?= $email ?><br>
                <?php
                    $stm = $conexao->prepare("SELECT tipo FROM fornecedor WHERE id_fornecedor = ?");
                    $stm->bind_param("i", $idGet);
                    $stm->execute();
                    $res = $stm->get_result();

                    $tipo = $res->fetch_array()[0];

                    if($tipo == 0){
                        $tipoEscreve = "Brechó";
                    } else{
                        $tipoEscreve = "Instituição";
                    }
                ?>
                <b>Tipo:</b> <?= $tipoEscreve ?><br>
            </p>
        </div>

        <div id="pontos-coleta" class="box">
            <iframe
            height="100%" width="100%" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps/embed/v1/place?key=<?= $_ENV["MAPS_API"] ?>&q=<?= urlencode($sedes[0]->formatar()) ?>">
            </iframe>
            <div id="pontos-lista">
                <h2>Sede</h2>
                
                <?php foreach ($sedes as $p): ?>
                    <p><b>Endereço:</b> <?= $p->formatar()?></p>
                <?php endforeach; ?>
                    
                <h2>Pontos de coleta</h2>
                    
                <?php foreach ($pontos as $p): ?>
                    <div class="ponto-coleta">
                        <i class="fa fa-map-marker fa-2x" aria-hidden="true"></i>
                        <div class="elementos">
                            <p><b>Endereço:</b> <?= $p->formatar()?></p>
                            <?php if($p->referencia != ""): ?>
                            <p><b>Referência:</b> <?= $p->referencia?></p>                         
                            <?php endif; ?>
                            
                            <p><b>Horário de funcionamento:</b> <?= $p->horario?></p>
                        </div>    
                    </div>
                <?php endforeach; ?>
                
                <?php if($dono): ?>
                    <a href="editar_ponto_coleta" class="botao">Adicionar ponto de coleta</a>
                <?php endif; ?>  

            </div>
        </div>

        <div id="pecas" class="box">           
            <?php
                include "_pecas.php";
            ?>

            <?php if($dono): ?>
                <a href="editar_peca" id="add-peca" class="botao"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <?php endif; ?>         
        
        </div>
    </main>
</body>
</html>
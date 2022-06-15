<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/perfil.css">
    
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
    include_once "model/ponto_coleta.php";   
    $idGet = $_GET["id"];
    
    // Se os IDs forem iguais, o usuário é o dono do perfil
    $dono = isset($idSessao) && $idSessao == $idGet;

    // Consulta os dados do fornecedor
    $stm = $conexao->prepare("SELECT * FROM fornecedor WHERE id_fornecedor = ?");
    $stm->bind_param("i", $idGet);
    $stm->execute();
    $res = $stm->get_result();

    // Se o perfil não existir, exibe apenas um aviso
    if ($res->num_rows == 0) {
        ?>
            <main style = "display: flex; justify-content: center; align-items: center;">
                <h1>Perfil não encontrado</h1>
            </main>
            </body>    
            </html>
        <?php
        exit();
    }

    // Dados do fornecedor
    $dados = $res->fetch_assoc();
    $nome = $dados["nome"];
    $imagem = $dados["imagem"];
    if ($imagem == null) {
        $imagem = "img/perfil.png";
    }
    $telefone = $dados["telefone"];
    $email = $dados["email"];
    
    $telefoneFormatado = "(".substr($telefone, 0, 2).") ".substr($telefone, 2, 5)."-".substr($telefone, 7, 4);

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
?>
    <main>
        <div id="dados">
            <h2><?= $nome ?></h2>
            <img id="logo" src="<?= $imagem ?>" alt="<?= $nome ?>"></h2>
            <p>
                <b>Telefone:</b> <?= $telefoneFormatado ?><br>
                <b>Email:</b> <?= $email ?><br>
                <a href="editar_peca">Adicionar peça</a>
            </p>
        </div>

        <div id="pontos">
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
                    <p><b>Endereço:</b> <?= $p->formatar() ?></p>
                <?php endforeach; ?>
                
                <?php if($dono): ?>
                    <button class="botao">Adicionar ponto de coleta</button>
                <?php endif; ?>  

            </div>
        </div>
        <div id="pecas">
            <h2>Peças anunciadas</h2>
            
            <?php if($dono): ?>
                <a href="editar_peca"><button class="botao" id="add-peca">Adicionar peça</button></a>
            <?php endif; ?>         
        
        </div>
    </main>
</body>
</html>
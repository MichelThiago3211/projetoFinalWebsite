<?php
    include_once "php/sessao.php";
    include_once "model/ponto_coleta.php";
    include_once "model/categoria_peca.php";

    // Assegura que haja uma sessão em aberto
    if (!isset($idSessao)) {
        header("Location: login");
    }

    // Carrega as categorias
    $categorias = array();
    
    $stm = $conexao->prepare("SELECT * FROM categoria_peca");
    $stm->execute();
    $res = $stm->get_result();
    
    while ($linha = $res->fetch_assoc()) {
        $categorias[] = CategoriaPeca::ler($linha);
    }

    // Carrega os pontos de coleta
    $pontosColeta = array();
    
    $stm = $conexao->prepare("SELECT * FROM ponto_coleta WHERE id_fornecedor = ?");
    $stm->bind_param("i", $idSessao);
    $stm->execute();
    $res = $stm->get_result();

    while ($linha = $res->fetch_assoc()) {
        $pontosColeta[] = PontoColeta::ler($linha);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar peça</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/editar_peca.css">

    <!-- Javascript -->
    <script src="js/file_input.js" defer></script>
    <script> window.id = <?php echo $idSessao; ?>; </script>
    <script src="js/editar_peca.js" type="module"></script>

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <!-- Ícones -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
</head>
<body>
    <?php include "_header.php"; ?>

    <!-- Template para as imagens -->
    <template id="template-imagem">
        <div class="imagem">
            <img>
            <div class="remover">
                <i class="fa fa-times fa-2x"></i>
            </div>
        </div>
    </template>

    <main>
        <form action="php/adicionar_peca" method="post" enctype="multipart/form-data">
            <h1>Adicionar peça</h1>

            <!-- Título -->
            <div class="campo" id="titulo" maxlength=100>
                <input type="text" name="titulo" required>
                <label>Título</label>
            </div>

            <!-- Imagens da peça -->
            <div id="imagens">
                <!-- Botão para adicionar novas imagens -->
                <label id="add-imagem" class="imagem">
                    <i class="fa fa-plus fa-2x" aria-hidden="true"></i>
                    Adicionar imagens
                    
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1MB -->
                    <input type="file" multiple id="imagens-input" accept="image/png, image/jpeg" required>
                </label>
            </div>

            <!-- Dados básicos da peça -->
            <div id="dados-div">
                <select name="categoria" required>
                    <option value="">Categoria</option>

                    <!-- Carrega as categorias do banco de dados -->
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria->id ?>"><?= $categoria->descricao ?></option>
                    <?php endforeach; ?>

                </select>
                <div id="caracteristicas">
                    <!-- Cor -->
                    <select name="cor" required>
                        <option value="">Cor</option>
                        <option value="azul">Azul</option>
                        <option value="verde">Verde</option>
                        <option value="vermelho">Vermelho</option>
                        <option value="preto">Preto</option>
                        <option value="branco">Branco</option>
                        <option value="cinza">Cinza</option>
                        <option value="rosa">Rosa</option>
                        <option value="laranja">Laranja</option>
                        <option value="amarelo">Amarelo</option>
                        <option value="roxo">Roxo</option>
                    </select>
                    <!-- Tamanho -->
                    <div class="campo" id="tamanho">
                        <input type="text" name="tamanho" maxlength=3 required>
                        <label>Tamanho</label>
                    </div>
                </div>
                <!-- Preço -->
                <div class="campo" id="preco">
                    <span>R$</span>
                    <input type="number" min="0" step="0.01" name="preco" value="0" required>
                    <label>Preço</label>
                </div>
            </div>
            
            <!-- Descrição -->
            <div class="campo" id="descricao">
                <textarea type="text" name="descricao" maxlength=500 placeholder="Descreva a peça..."></textarea>
                <label>Descrição</label>
            </div>

            <!-- Ponto de coleta -->
            <select name="ponto-coleta" id="ponto-coleta" required>
                <option value="">Ponto de coleta</option>
                
                <?php foreach ($pontosColeta as $ponto): ?>
                    <option value="<?= $ponto->id ?>"><?= $ponto->formatar() ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Confirmação -->
            <input type="submit" value="Adicionar" class="botao">
        </form>
    </main>
</body>
</html>
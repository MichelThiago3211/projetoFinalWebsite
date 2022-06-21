<?php
    include_once "php/sessao.php";
    include_once "model/ponto_coleta.php";
    include_once "model/categoria_peca.php";
    include_once "model/peca.php";

    // Assegura que haja uma sessão em aberto
    if (!isset($idSessao)) {
        header("Location: login");
        exit;
    }

    // Caso um ID tenha sido passado na URL, a operação é de edição
    $id = $_GET["id"] ?? -1;
    $edicao = $id != -1;

    if ($edicao) {
        // Consulta os dados da peça
        $stm = $conexao->prepare("SELECT * FROM peca WHERE id_peca = ?");
        $stm->bind_param("i", $id);
        $stm->execute();
        $res = $stm->get_result();
        
        $peca = Peca::ler($res->fetch_assoc());

        // Verifica se o usuário tem permissão para editar a peça
        $stm = $conexao->prepare("SELECT * FROM ponto_coleta WHERE id_fornecedor = ? AND id_ponto_coleta = ?");
        $stm->bind_param("ii", $idSessao, $peca->pontoColeta);
        $stm->execute();
        $res = $stm->get_result();

        if ($res->num_rows == 0) {
            header("Location: login");
            exit;
        }
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
    <title><?= $edicao ? "Editar" : "Adicionar" ?> peça</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/editar_peca.css">

    <!-- JavaScript -->
    <script src="js/arquivos.js" defer></script>
    <script src="js/editar_peca.js" type="module"></script>

    <?php include "_fontes.php" ?>
</head>
<body>
    <?php include "_header.php"; ?>

    <main>
        <form action="php/_editar_peca" method="post" enctype="multipart/form-data" class="box">
            <h1><?= $edicao ? "Editar" : "Adicionar" ?> peça</h1>

            <?php if ($edicao): ?>
                <input type="hidden" name="id" value="<?= $id ?>">
            <?php endif; ?>

            <!-- Título -->
            <div class="campo" id="titulo" maxlength=100>
                <input type="text" name="titulo" required value="<?= $peca->titulo ?? "" ?>">
                <label>Título</label>
            </div>

            <!-- Imagens da peça -->
            <div id="imagens">
                <!-- Carrega as imagens já adicionadas -->
                <?php if ($edicao): ?>
                    <?php foreach ($peca->imagens() as $imagem): ?>
                        <img src="<?= $imagem->caminho ?>">
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Botão para adicionar novas imagens -->
                <label id="add-imagem" class="imagem">
                    <i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i>
                    Carregar imagens
                    
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1MB -->
                    <input type="file" multiple id="imagens-input" name="imagens[]" accept="image/png, image/jpeg" <?= !$edicao ? "required" : "" ?>>
                </label>
            </div>

            <!-- Dados básicos da peça -->
            <div id="dados-div">
                <select name="categoria" required>
                    <option value="">Categoria</option>

                    <!-- Carrega as categorias do banco de dados -->
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria->id ?>" <?php if ($edicao && $peca->categoria == $categoria->id) echo "selected"; ?>>
                            <?= $categoria->descricao ?>
                        </option>
                    <?php endforeach; ?>

                </select>
                <div id="caracteristicas">
                    <!-- Cor -->
                    <select name="cor" required>
                        <option value="">Cor</option>

                        <!-- Carrega as cores da classe Peca -->
                        <?php foreach (Peca::$cores as $k => $v): ?>
                            <option value="<?= $k ?>" <?php if ($edicao && $peca->cor == $k) echo "selected"; ?>>
                                <?= $v ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Tamanho -->
                    <div class="campo" id="tamanho">
                        <input type="text" name="tamanho" maxlength=3 required value="<?= $peca->tamanho ?? "" ?>">
                        <label>Tamanho</label>
                    </div>
                </div>
                <!-- Preço -->
                <div class="campo" id="preco">
                    <span>R$</span>
                    <input type="number" min="0" step="0.01" name="preco" required value="<?= $peca->preco ?? "0" ?>">
                    <label>Preço</label>
                </div>
            </div>
            
            <!-- Descrição -->
            <div class="campo" id="descricao">
                <textarea type="text" name="descricao" maxlength=500 placeholder="Descreva a peça..."><?= $peca->descricao ?? "" ?></textarea>
                <label>Descrição</label>
            </div>

            <!-- Ponto de coleta -->
            <select name="ponto-coleta" id="ponto-coleta" required>
                <option value="">Ponto de coleta</option>
                
                <?php foreach ($pontosColeta as $ponto): ?>
                    <option value="<?= $ponto->id ?>" <?php if ($edicao && $peca->pontoColeta == $ponto->id) echo "selected"; ?>>
                        <?= $ponto->formatar() ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Confirmação -->
            <div id="botoes">
                <input type="submit" class="botao" value="<?= $edicao ? "Editar" : "Adicionar" ?>">
                <?php if ($edicao): ?>
                    <a href="php/deletar_peca?id=<?= $id ?>" id="deletar" class="botao">Deletar</a>
                <?php endif; ?>
            </div>
        </form>
    </main>
</body>
</html>
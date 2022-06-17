<?php
    include_once "php/conexao.php";
    include_once "model/peca.php";
    include_once "model/categoria_peca.php";
    include_once "model/imagem_peca.php";

    $cor = $_GET["cor"] ?? "";
    $categoria = $_GET["categoria"] ?? "";
    $tamanho = $_GET["tamanho"] ?? "";
    $preco = $_GET["preco"] ?? "";
    $pesquisa = $_GET["pesquisa"] ?? "";

    // Carrega as categorias
    $categorias = array();
    
    $stm = $conexao->prepare("SELECT * FROM categoria_peca");
    $stm->execute();
    $res = $stm->get_result();
    
    while ($linha = $res->fetch_assoc()) {
        $categorias[] = CategoriaPeca::ler($linha);
    }

    // Carrega as peças
    $pecas = array();
    
    $filtros = array();
    if ($cor != "") {
        $filtros[] = "cor = '$cor'";
    }
    if ($categoria != "") {
        $filtros[] = "id_categoria_peca = $categoria";
    }
    if ($tamanho != "") {
        $filtros[] = "tamanho = '$tamanho'";
    }
    if ($preco != "") {
        $filtros[] = "preco <=" . $preco * 100;
    }
    if ($pesquisa != "") {
        $filtros[] = "titulo LIKE '%$pesquisa%'";
    }

    $stm = $conexao->prepare("SELECT * FROM peca" . (count($filtros) > 0 ? " WHERE " . implode(" AND ", $filtros) : ""));
    $stm->execute();
    $res = $stm->get_result();

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
    <link rel="stylesheet" href="css/catalogo.css">
    <link rel="stylesheet" href="css/carrossel.css">

    <!-- Javascript -->
    <script src="js/catalogo.js" defer></script>
    <script src="js/carrossel.js" defer></script>

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include "_header.php"; ?>

    <main>
        <!-- Menu de filtros -->
        <form id="filtros" action="catalogo" method="get">
            <h2>Filtros</h2>
            
            <!-- Categoria -->
            <select name="categoria">
                <option value="">Categoria</option>

                <!-- Carrega as categorias do banco de dados -->
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c->id ?>" <?= $c->id == $categoria ? "selected" : "" ?>>
                        <?= $c->descricao ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Cor -->
            <select name="cor">
                <option value="">Cor</option>

                <!-- Carrega as cores da classe Peca -->
                <?php foreach (Peca::$cores as $k => $v): ?>
                    <option value="<?= $k ?>" <?= $k == $cor ? "selected" : "" ?>>
                        <?= $v ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <!-- Tamanho -->
            <select name="tamanho">
                <option value="">Tamanho</option>

                <!-- Carrega os tamanhos da classe Peca -->
                <?php foreach (Peca::$tamanhos as $k => $v): ?>
                    <option value="<?= $k ?>" <?= $k == $tamanho ? "selected" : "" ?>>
                        <?= $v ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Preço máximo -->
            <div class="campo" id="preco">
                <span>R$</span>
                <input type="number" min="0" step="0.01" name="preco" value="<?= $preco ?>">
                <label>Preço máximo</label>
            </div>

            <div id="botoes">
                <input type="submit" value="Filtrar" class="botao">
                <input type="reset" id="limpar" value="Limpar filtros" class="botao">
            </div>
        </form>

        <!-- Pesquisa -->
        <div id="pesquisa" class="campo">
            <input type="text" form="filtros" name="pesquisa" value="<?= $pesquisa ?>">
            <label>Pesquisar</label>
        </div>

        <!-- Peças -->
        <div id="pecas">
            <?php foreach ($pecas as $p): ?>
                <div class="peca <?= $p->preco == 0? "doacao" : "venda" ?>">
                    <?php
                        // Carrega a imagem da peça
                        $stm = $conexao->prepare("SELECT * FROM imagem_peca WHERE id_peca = $p->id LIMIT 1");
                        $stm->execute();
                        $res = $stm->get_result();
                        $primeiraImagem = ImagemPeca::ler($res->fetch_assoc());

                        // Carrega a categoria da peça
                        $stm = $conexao->prepare("SELECT descricao FROM categoria_peca WHERE id_categoria_peca = $p->categoria");
                        $stm->execute();
                        $res = $stm->get_result();
                        $categoriaNome = $res->fetch_array()[0];
                    ?>
                    <img src="<?= $primeiraImagem->caminho ?>" alt="<?= $p->titulo ?>">
                    
                    <h3><?= $p->titulo ?></h3><br>
                    <span>
                        <?= $categoriaNome ?> &bull; <?= Peca::$cores[$p->cor] ?><br>
                        Tamanho <?php
                            if (isset(Peca::$tamanhos[$p->tamanho] )) {
                                echo Peca::$tamanhos[$p->tamanho];
                            } else {
                                echo $p->tamanho;
                            }
                        ?>
                    </span>
                    <span class="preco"><?= $p->preco == 0? "DOAÇÃO" : "R$ " . $p->preco ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
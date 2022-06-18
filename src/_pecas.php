<link rel="stylesheet" href="css/pecas.css">

<?php 
    include_once "model/peca.php";
    include_once "model/imagem_peca.php";

    foreach ($pecas as $p): ?>

    <a href="ver_peca?id=<?= $p->id ?>">
        <div class="peca <?= $p->preco == 0? "doacao" : "venda" ?>">
            <?php
                // Imagem
                $stm = $conexao->prepare("SELECT * FROM imagem_peca WHERE id_peca = $p->id LIMIT 1");
                $stm->execute();
                $res = $stm->get_result();
                $primeiraImagem = ImagemPeca::ler($res->fetch_assoc());

                // Categoria
                $stm = $conexao->prepare("SELECT descricao FROM categoria_peca WHERE id_categoria_peca = $p->categoria");
                $stm->execute();
                $res = $stm->get_result();
                $categoriaNome = $res->fetch_array()[0];

                // Município
                $m = $p->pontoColeta()->municipio();
            ?>

            <!-- Imagem -->
            <img src="<?= $primeiraImagem->caminho ?>" alt="<?= $p->titulo ?>">
            
            <!-- Título -->
            <h3><?= $p->titulo ?></h3>

            <!-- Informações básicas -->
            <span>
                <?= $categoriaNome ?> &bull; <?= Peca::$cores[$p->cor] ?><br>
                Tamanho <?= Peca::$tamanhos[$p->tamanho] ?? $p->tamanho ?><br>
                <?= $m->nome . " - " . $m->estado ?>
            </span>

            <!-- Preço -->
            <span class="preco"><?= $p->preco == 0? "DOAÇÃO" : "R$ " . number_format((float)$p->preco, 2, ',', '') ?></span>
        </div>
    </a>
<?php endforeach; ?>
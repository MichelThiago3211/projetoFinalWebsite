<link rel="stylesheet" href="css/pecas.css">

<?php 
    include_once "model/peca.php";
    include_once "model/imagem_peca.php";
?>

<?php foreach ($pecas as $p): ?>
    <a href="ver_peca?id=<?= $p->id ?>" class="peca-wrapper">
        <div class="peca box <?= $p->preco == 0? "doacao" : "venda" ?>">
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
            <img loading="lazy" src="<?= $primeiraImagem->caminho ?>" alt="<?= $p->titulo ?>">
            
            <div class="dados">
                <!-- Título -->
                <h3><?= $p->titulo ?></h3>

                <!-- Informações básicas -->
                <span>
                    Tamanho <?= Peca::$tamanhos[$p->tamanho] ?? $p->tamanho ?>
                    &bull;
                    <?= $m->nome . " - " . $m->estado ?>
                </span>

            </div>
            <!-- Preço -->
            <div class="preco"><?= $p->preco == 0? "DOAÇÃO" : $p->precoFormatado() ?></div>
        </div>
    </a>
<?php endforeach; ?>
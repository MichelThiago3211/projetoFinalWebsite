<?php foreach ($pecas as $p): ?>
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
        <img src="<?= $primeiraImagem->caminho ?>" alt="<?= $p->titulo ?>">
        
        <h3><?= $p->titulo ?></h3>

        <span>
            <?= $categoriaNome ?> &bull; <?= Peca::$cores[$p->cor] ?><br>
            <?php if (isset(Peca::$tamanhos[$p->tamanho] )): ?>
                Tamanho <?= Peca::$tamanhos[$p->tamanho] ?>
            <?php else: ?>
                Tamanho <?= $p->tamanho ?>
            <?php endif; ?>
            <br>
            <?= $m->nome . " - " . $m->estado ?>
        </span>
        <span class="preco"><?= $p->preco == 0? "DOAÇÃO" : "R$ " . $p->preco ?></span>
    </div>
<?php endforeach; ?>
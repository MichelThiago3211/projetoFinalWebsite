<link href="css/endereco.css" rel="stylesheet">

<script src="js/endereco.js" type="module"></script>

<div class="endereco">
    <!-- Primeira linha -->
    <div class="endereco-1">
        <div class="campo">
            <input type="text" name="cep" placeholder="_____-___" autocomplete="postal-code" required value="<?= $pontoColeta->cep ?? "" ?>">
            <label>CEP</label>
        </div>
        <div class="campo">
            <input type="text" name="cidade" autocomplete="address-level2" required>
            <label>Cidade</label>
        </div>
        <div class="campo">
            <input type="text" name="uf" autocomplete="address-level1" pattern="[A-Z]{2}" required>
            <label>UF</label>
        </div>
    </div>

    <!-- Segunda linha -->
    <div class="endereco-2">
        <div class="campo">
            <input type="text" name="rua" autocomplete="address-level3" required maxlength=50 value="<?= $pontoColeta->rua ?? "" ?>">
            <label>Rua</label>
        </div>
        <div class="campo">
            <input type="text" name="numero" autocomplete="cc-number" required maxlength=3 value="<?= $pontoColeta->numero ?? "" ?>">
            <label>Nº</label>
        </div>
    </div>

    <!-- Terceira linha -->
    <div class="endereco-3">
        <div class="campo">
            <input type="text" name="referencia" maxlength=100 value="<?= $pontoColeta->referencia ?? "" ?>">
            <label>Referência</label>
        </div>
        <div class="campo">
            <input type="text" name="complemento" maxlength=20 value="<?= $pontoColeta->complemento ?? "" ?>">
            <label>Complemento</label>
        </div>
    </div>
</div>
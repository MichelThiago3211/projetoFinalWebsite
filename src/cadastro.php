<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/cadastro.css">

    <!-- JavaScript -->
    <script src="js/arquivos.js" defer></script>
    <script src="js/cadastro.js" type="module"></script>

    <?php include "_fontes.php" ?>
</head>
<body>
    <?php include "_lateral.html"; ?>

    <main>
        <form enctype="multipart/form-data" action="php/adicionar_fornecedor.php" method="post" class="box">
            <h1 id>Cadastro</h1>
            
            <fieldset id="dados-fs">
                <!-- Tipo -->
                <select name="tipo" id="tipo">
                    <option value="brecho" selected>Brechó</option>
                    <option value="instituicao">Instituição</option>
                </select>
                <!-- Nome -->
                <div class="campo" id="nome">
                    <input type="text" name="nome" autocomplete="name" autofocus maxlength=100 required>
                    <label></label>
                </div>
                <div id="dados-imagem">
                    <div class="campos">
                        <!-- E-mail -->
                        <div class="campo">
                            <input type="text" name="email" pattern=".+@\w+\.\w[\w\.]*" placeholder="exemplo@email.com" autocomplete="email" maxlength=254 required>
                            <label>E-mail</label>
                        </div>
                        <!-- Telefone -->
                        <div class="campo">
                            <input type="text" name="telefone" placeholder="(__) _____-____" pattern="[0-9]{10,11}" autocomplete="tel-national" required>
                            <label>Telefone</label>
                        </div>
                        <!-- CNP -->
                        <div class="campo" id="cnp">
                            <input type="text" name="cnp" required autocomplete="off">
                            <label></label>
                        </div>
                    </div>
                    <!-- Logo do brechó/instituição -->
                    <label class="imagem-input" for="imagem">
                        <img id="preview">
                        <i class="fa fa-file-image-o" aria-hidden="true"></i>
                        Inserir imagem (opcional)
                    </label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> <!-- 1MB -->
                    <input type="file" name="imagem" id="imagem" accept="image/png, image/jpeg">
                </div>
            </fieldset>

            <!-- Endereço -->
            <fieldset id="endereco-fs">
                <?php include "_endereco.php"; ?>
            </fieldset>

            <fieldset id="senha-fs">
                <!-- Senha -->
                <div class="campo" id="senha">
                    <input name="senha" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}" name="senha" autocomplete="new-password" required>
                    <label>Senha</label>
                </div>
                <!-- Confirmar senha -->
                <div class="campo" id="confirmar-senha">
                    <input type="password" required autocomplete="off">
                    <label>Confirmar senha</label>
                </div>
                <div id="senha-requisitos">
                    <span><i class="fa fa-times-circle" aria-hidden="true"></i>8 ou mais caracteres</span>
                    <span><i class="fa fa-times-circle" aria-hidden="true"></i>Número</span>
                    <span><i class="fa fa-times-circle" aria-hidden="true"></i>Letra minúscula</span>
                    <span><i class="fa fa-times-circle" aria-hidden="true"></i>Letra maiúscula</span>
                </div>
            </fieldset>

            <fieldset id="botoes">
                <input type="submit" class="botao" value="Cadastrar">
                <a href="login">Já possue uma conta?</a>
            </fieldset>
        </form>
    </main>
</body>
</html>
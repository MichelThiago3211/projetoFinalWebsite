<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/cadastro.css">

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- Javascript -->
    <script src="js/cadastro.js" type="module"></script>
</head>
<body>
    <?php include "_lateral_forms.html"; ?>

    <main>
        <form enctype="multipart/form-data" action="php/adicionar_fornecedor.php" method="post">
            <h1 id>Cadastro</h1>
            
            <fieldset id="dados-fs">
                <!-- Tipo -->
                <div id="tipo-fornecedor">
                    <label for="tipo">Tipo de fornecedor</label>
                    <select name="tipo" id="tipo">
                        <option value="brecho" selected>Brechó</option>
                        <option value="instituicao">Instituição</option>
                    </select>
                </div>
                <!-- Nome -->
                <div class="campo">
                    <input type="text" name="nome" autocomplete="given-name" autofocus required>
                    <label>Nome</label>
                </div>
                <!-- Sobrenome -->
                <div class="campo">
                    <input type="text" name="sobrenome" autocomplete="family-name" required>
                    <label>Sobrenome</label>
                </div>
                <div id="dados-imagem">
                    <div class="campos">
                        <!-- E-mail -->
                        <div class="campo">
                            <input type="text" name="email" pattern=".+@\w+\.\w[\w\.]*" placeholder="exemplo@email.com" autocomplete="email" required>
                            <label>E-mail</label>
                        </div>
                        <!-- Telefone -->
                        <div class="campo">
                            <input type="text" name="telefone" placeholder="(__) _____-____" pattern="[0-9]{11}" autocomplete="tel-national" required>
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
                        Inserir imagem
                    </label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576"/> <!-- 1MB -->
                    <input type="file" name="imagem" id="imagem" accept="image/png, image/jpeg">
                </div>
                <!-- Endereço -->
                <div class="campo" id="endereco">
                    <input type="hidden" name="rua" id="rua-hidden">
                    <input type="hidden" name="numero" id="numero-hidden">
                    <input type="hidden" name="cep" id="cep-hidden">
                    <input type="hidden" name="cidade" id="cidade-hidden">
                    <input type="hidden" name="estado" id="estado-hidden">
                    <input type="text" id="endereco-input" name="endereco" autocomplete="off" required>
                    <label>Endereço</label>
                    <div class="sugestoes"></div>
                </div>
                <!-- Complemento -->
                <div class="campo">
                    <input type="text" name="complemento" autocomplete="none">
                    <label>Complemento</label>
                </div>
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
            </fieldset>

            <fieldset id="botoes">
                <input type="submit" class="botao" value="Cadastre-se">
                <a href="login.php">Já possue uma conta?</a>
            </fieldset>
        </form>
    </main>
</body>
</html>
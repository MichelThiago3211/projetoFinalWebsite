<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/login.css">

    <?php include "_fontes.php" ?>
</head>
<body>
    <?php include "_lateral.html"; ?>

    <main>
        <form action="php/autenticacao.php" method="post" class="box">
            <h1 id>Login</h1>
            
            <fieldset id="dados-fs">
                <div class="campo">
                    <input placeholder="exemplo@email.com" type="text" name="email" autocomplete="email" autofocus required>
                    <label>E-mail</label>
                </div>
                <div class="campo" id="senha">
                    <input type="password" name="senha" autocomplete="current-password" required>
                    <label>Senha</label>
                </div>
            </fieldset>
            <fieldset id="botoes">
                <input type="submit" class="botao" value="Entrar">
                <a href="cadastro">Não possue uma conta?</a>
            </fieldset>
        </form>
    </main>
</body>
</html>
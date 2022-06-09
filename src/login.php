<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/login.css">

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include "_lateral_forms.html"; ?>

    <main>
        <form action="php/autenticacao.php" method="post">
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
                <input type="submit" class="botao" value="Logar">
            </fieldset>
        </form>
    </main>
</body>
</html>
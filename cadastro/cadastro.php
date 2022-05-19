<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <a href="">link1</a>
            <a href="">link2</a>
            <a href="">link3</a>
        </nav>
    </header>

    <main>
        <form action="adicionar_pf.php" method="post" class="flex-coluna">
            <h1>Cadastrar brechó</h1>
            
            <fieldset id="dados-basicos">
                    <input class="campo" type="text" placeholder="Nome">
                    <input class="campo" type="text" placeholder="Sobrenome">
                    <input class="campo" type="email" placeholder="Email">
                    <input class="campo" type="text" placeholder="Telefone">
                    <input class="campo" type="text" placeholder="CPF">
                    <input id="endereco" class="campo" type="text" placeholder="Endereço">
                    <input class="campo" type="text" placeholder="Complemento">
            </fieldset>

            <fieldset id="senha">
                <input class="campo" type="password" placeholder="Senha">
                <input class="campo" type="password" placeholder="Confirmar senha">
            </fieldset>

            <fieldset id="botoes">
                <input type="submit" class="botao" value="Cadastre-se">
                <a href="../login/login.php">Já possue uma conta?</a>
            </fieldset>
        </form>
    </main>

    <footer>
        <p>Teste</p>
    </footer>
</body>
</html>
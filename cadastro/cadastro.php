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
        <img src="https://valensbusinessservices.com/wp-content/uploads/2020/11/10-1024x796.png" style="width: 500px">
        <h1 style="font-size:50px;">O SITE FODA</h1>
        <p style="width: 500px; font-size:20px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum, consequuntur. Eaque dolore itaque, voluptatibus accusantium atque molestiae dolorum fuga. Quod est quia ex totam, autem incidunt maiores ipsam dolores debitis.</p>
        <nav style="display:flex; gap:20px; font-size:20px">
            <button>Sobre nós</button>
            <button>Catálogo</button>
        </nav>
    </header>

    <main>
        <form action="adicionar_pf.php" method="post" class="flex-coluna">
            <h1 style="margin-right: 10px;">Cadastro</h1>
            
            <fieldset>
                <label for="tipo" style="font-size: 20px; font-family: Ubuntu;">Tipo de cadastro:</label>
                <select name="tipo" id="tipo" class="campo">
                    <option value="">Instituição</option>
                    <option value="">Brechó</option>
                </select>
            </fieldset>

            <fieldset id="dados-basicos">
                <input class="campo" type="text" placeholder="Nome" required>
                <input class="campo" type="text" placeholder="Sobrenome" required>
                <input class="campo" type="email" placeholder="Email" required>
                <input class="campo" type="text" placeholder="Telefone" required>
                <input class="campo" type="text" placeholder="CPF" required>
                <input class="campo" type="text" placeholder="Endereço" required>
                <input class="campo" type="text" placeholder="Complemento" required>
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
</body>
</html>
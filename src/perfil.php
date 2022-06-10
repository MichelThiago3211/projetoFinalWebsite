<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/perfil.css">

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
<?php
    include '_header.php';

    @include_once "php/sessao.php";

    $idGet = $_GET["id_fornecedor"];
    
    // Se os IDs forem iguais, o usuário é o dono do perfil
    $dono = isset($idSessao) && $idSessao == $idGet;

    // Dados do fornecedor
    $fornecedorConsultaSql = "select * from fornecedor where id_fornecedor='$idGet'";
    $fornecedorConsultaRes = mysqli_query($conexao, $fornecedorConsultaSql);
    $dados = mysqli_fetch_array($fornecedorConsultaRes, MYSQLI_NUM);

    $perfilExiste = mysqli_num_rows($fornecedorConsultaRes) > 0;
    if (!$perfilExiste) {
        ?>
                <main style = "display: flex; justify-content: center; align-items: center;">
                    <h1>Perfil não encontrado</h1>
                </main>
            </body>    
            </html>
        <?php 
        exit();
    }
    $nome = $dados[5];
    $imagem = $dados[11];
    if ($imagem == null) {
        $imagem = "img/perfil.png";
    }
    $telefone = $dados[6];
    $email = $dados[7];
    
?>

    <main>
        <div id="dados">
            <h2><?php echo $nome; ?></h2>
            <img id="logo" src="<?php echo $imagem; ?>" alt="<?php echo $nome; ?>"></h2>
            <p>
                <b>Telefone:</b> <?php echo $telefone; ?><br>
                <b>Email:</b> <?php echo $email; ?><br>
                
            </p>
        </div>
        <div id="local">
            <h1>Local</h1>
        </div>
        <div id="pecas">
            <h1>Peças</h1>
        </div>
    </main>
</body>
</html>
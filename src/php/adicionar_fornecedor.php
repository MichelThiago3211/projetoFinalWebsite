<?php
    include_once "conexao.php";

    // Dados básicos
    $tipo = ($_POST['tipo']=='brecho'?0:1);
    $nomeCompleto = $_POST['nome'] . " " . $_POST['sobrenome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cnp = $_POST['cnp'];
    $complemento = $_POST['complemento'];
    $senha = $_POST['senha'];

    // Endereço    
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $cep = str_replace("-", "", $_POST['cep']);
    $cidade = $_POST['cidade'];

    // Logo
    $diretorio  = "../images/";
    $temArquivo = $_FILES["imagem"]['name'] != '';
    $logoCaminho = $diretorio . $cnp . "." . pathinfo($_FILES["imagem"]['name'], PATHINFO_EXTENSION);

    //  Busca a cidade no banco de dados
    $cidadeConsultaSql = "SELECT id_municipio FROM municipio WHERE (nome='$cidade')";
    $cidadeRes = mysqli_query($conexao, $cidadeConsultaSql);  
    
    // Se a cidade não existir, insere ela no banco de dados
    if(is_null(mysqli_fetch_array($cidadeRes, MYSQLI_NUM))) {
        $cidadeInserirSql = "INSERT INTO MUNICIPIO (NOME,ESTADO) VALUES ('$cidade', 'RS')";
        mysqli_query($conexao, $cidadeInserirSql);
    }

    // Repete a query para atualizar os resultados
    $cidadeRes = mysqli_query($conexao, $cidadeConsultaSql);
    // Salva o ID da cidade
    $idMunicipio = mysqli_fetch_array($cidadeRes, MYSQLI_NUM)[0];      
    
    // Insere o fornecedor no banco de dados
    $fornecedorInserirSql = "INSERT INTO fornecedor(complemento, numero, rua, cep, nome, telefone, email, senha, ativo, cnp, tipo, id_municipio". ($temArquivo? ', imagem' : '') . ") VALUES ('$complemento', $numero, '$rua', $cep, '$nomeCompleto', '$telefone', '$email', '$senha', 0, '$cnp', '$tipo', $idMunicipio " . ($temArquivo? ", '" . $logoCaminho . "'" : '') . ");";
    $fornecedorInserirRes = mysqli_query($conexao, $fornecedorInserirSql);
   
    // Verifica se ocorreu algum erro
    if (!$fornecedorInserirRes) {
        echo  "<script>alert('Não foi possível conectar ao Banco de Dados!');</script>";
        header('Location: ../cadastro.php');
    }
    else {
        if ($temArquivo && !move_uploaded_file($_FILES["imagem"]["tmp_name"], '../'.$logoCaminho)) {
            echo "<script>alert('Erro ao enviar a imagem!');</script>";
        }
        header('Location: ../login.php');
    }
?>
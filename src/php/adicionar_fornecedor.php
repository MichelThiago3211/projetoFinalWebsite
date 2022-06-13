<?php
    include_once "conexao.php";

    // Informações básicas
    $tipo = ($_POST['tipo'] == 'brecho'? 0 : 1);
    $nomeCompleto = $tipo == 1? $_POST['nome'] : ($_POST['nome'] . " " . $_POST['sobrenome']);
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cnp = $_POST['cnp'];
    $senha = $_POST['senha'];

    // Endereço    
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $referencia = $_POST['referencia'];
    $complemento = $_POST['complemento'];

    // Logo
    $logo = $_FILES['imagem'];
    $temImagem = $logo['name'] != '' && $logo['error'] == 0;
    if ($temImagem) {
        $extensao = pathinfo($logo['name'], PATHINFO_EXTENSION);
        $imagemCaminho = "../imagens/fornecedor/$cnp.$extensao";
    }

    $idMunicipio = buscarIdCidade($cidade, $uf);
    $senhaCriptografada = hash("sha256", $senha);

    // Insere o fornecedor no banco de dados
    $stm = $conexao->prepare("INSERT INTO fornecedor(nome, telefone, email, senha, cnp, tipo, ativo) VALUES (?, ?, ?, ?, ?, ?, 0)");
    $stm->bind_param("sssssi", $nomeCompleto, $telefone, $email, $senhaCriptografada, $cnp, $tipo);
    $stm->execute();

    $idFornecedor = $stm->insert_id;

    // Adiciona a imagem do fornecedor
    if ($temImagem) {
        $stm = $conexao->prepare("UPDATE fornecedor SET imagem = ? WHERE id_fornecedor = ?");
        $stm->bind_param("ss", $imagemCaminho, $idFornecedor);
        $stm->execute();
    }
   
    // Verifica se ocorreu algum erro
    if ($stm->error) {
        echo "<script>alert('Erro ao inserir fornecedor no banco de dados');</script>";
        header("Location: ../cadastro");
    }
    
    if ($temImagem) {
        $movido = move_uploaded_file($logo["tmp_name"], '../'.$imagemCaminho);
        if (!$movido) {
            echo "<script>alert('Erro ao salvar imagem');</script>";
            header("Location: ../cadastro");
        }
    }

    // Cria o ponto de coleta que representa a sede do fornecedor
    $stm = $conexao->prepare("INSERT INTO ponto_coleta (horario, complemento, numero, rua, cep, id_municipio, id_fornecedor, referencia, sede) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)");
    $stm->bind_param("ssisiiis", $horario, $complemento, $numero, $rua, $cep, $idMunicipio, $idFornecedor, $referencia);
    $stm->execute();

    // Verifica se ocorreu algum erro
    if ($stm->error) {
        echo "<script>alert('Erro ao inserir ponto de coleta no banco de dados');</script>";
        header("Location: ../cadastro");
    }

    // Autenticação
    include "autenticacao.php";

    function buscarIdCidade($cidade, $uf) {
        global $conexao;
        
        $stm = $conexao->prepare("SELECT id_municipio FROM municipio WHERE nome = ? AND estado = ?");
        $stm->bind_param("ss", $cidade, $uf);
        $stm->execute();
        $res = $stm->get_result();
        
        if ($res->num_rows > 0) {
            return $res->fetch_array()[0];
        }

        $stm = $conexao->prepare("INSERT INTO municipio (nome, estado) VALUES (?, ?)");
        $stm->bind_param("ss", $cidade, $uf);
        $stm->execute();
        return $conexao->insert_id;
    }
?>
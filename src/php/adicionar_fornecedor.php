<?php
    include_once "conexao.php";

    $tipo = $_POST['tipo'];
    $nome = $_POST['nome'];
	$sobrenome = $_POST['sobrenome'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	$cnp = $_POST['cnp'];
    $complemento = $_POST['complemento'];
    $senha = $_POST['senha'];
    $cidade = $_POST[''];


    $sql = "SELECT id_municipio FROM municipio WHERE (nome='$cidade')";

    /* PEGA A IMAGEM */
    if(isset($_FILES['arquivo'])){
        $conteudoDoArquivo = file_get_contents($_FILES['imagem']['tmp_name']);

        switch ($_FILES['arquivo']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }
    }
    else {
        echo "No file found";
    }


    //nome, sobrenome, email, telefone, cpf, endereco, complemento, senha

	$sql = "INSERT INTO municipios (cidade, uf) VALUES ('$nome', '$estado')";
	$result = mysqli_query($conn, $sql);
        
    if (!$result) {
		echo  "<script>alert('Não foi possível conectar ao Banco de Dados!');</script>";
		header('Location: index.php');
	}
?>
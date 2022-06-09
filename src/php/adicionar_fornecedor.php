<?php
    include_once "conexao.php";

    $tipo = ($_POST['tipo']=='brecho'?0:1);
    $nome = $_POST['nome'];
	$sobrenome = $_POST['sobrenome'];
	
    $nomeCompleto = $nome . " " . $sobrenome;
    
    $email = $_POST['email'];
	$telefone = $_POST['telefone'];
	$cnp = $_POST['cnp'];
    $complemento = $_POST['complemento'];
    $senha = $_POST['senha'];
    
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $cep = str_replace("-", "", $_POST['cep']);
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    echo $estado;
    $UF;

    switch(){
        case '':


    }

	$diretorio  = "../images/";
    $temArquivo = $_FILES["imagem"]['name'] != '';
	$arquivo    = $temArquivo ? $_FILES["imagem"] : FALSE;
    $logo       = $diretorio.$arquivo['name'];

    $sql = "SELECT id_municipio FROM municipio WHERE (nome='$cidade')";
    $result = mysqli_query($conn, $sql);
    $idMunicipio = mysqli_fetch_array($result, MYSQLI_NUM)[0];  
    
    if(is_null($idMunicipio)){

        $sql = "INSERT INTO MUNICIPIO(NOME,ESTADO) VALUES ('$idMunicipio', '')"

    }



    $sql = "INSERT INTO fornecedor(complemento, numero, rua, cep, nome, telefone, email, senha, ativo, cnp, tipo, id_municipio". ($temArquivo? ', imagem' : '') . ") VALUES ('$complemento', $numero, '$rua', $cep, '$nomeCompleto', '$telefone', '$email', '$senha', 0, '$cnp', '$tipo', $idMunicipio " . ($temArquivo? ", '".$logo."'" : '') . ");";
    $result = mysqli_query($conn, $sql);
   
    if (!$result) {
        echo  "<script>alert('Não foi possível conectar ao Banco de Dados!');</script>";
        header('Location: sobre.html');
    }
    else {
		if ($temArquivo && !move_uploaded_file($arquivo["tmp_name"], '../'.$diretorio.$arquivo["name"])) {
			echo "<script>alert('Erro ao enviar a imagem!');</script>";
		}
    }
?>
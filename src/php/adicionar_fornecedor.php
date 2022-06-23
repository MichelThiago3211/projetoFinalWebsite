<?php
    include_once "conexao.php";
    include_once "buscar_municipio.php";

    // Informações básicas
    $tipo = ($_POST["tipo"] == "brecho"? 0 : 1);
    $nome = trim($_POST["nome"]);
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $cnp = $_POST["cnp"];
    $senha = $_POST["senha"];

    // Endereço    
    $cep = $_POST["cep"];
    $cidade = $_POST["cidade"];
    $uf = $_POST["uf"];
    $rua = $_POST["rua"];
    $numero = $_POST["numero"];
    $referencia = $_POST["referencia"];
    $complemento = $_POST["complemento"];

    // Logo
    $logo = $_FILES["imagem"];
    $temImagem = $logo["name"] != "" && $logo["error"] == 0;
    if ($temImagem) {
        $extensao = pathinfo($logo["name"], PATHINFO_EXTENSION);
        $imagemCaminho = "../imagens/fornecedor/$cnp.$extensao";
    }

    $idMunicipio = buscarIdMunicipio($cidade, $uf);
    $senhaCriptografada = hash("sha256", $senha);

    // Insere o fornecedor no banco de dados
    $stm = $conexao->prepare("INSERT INTO fornecedor(nome, telefone, email, senha, cnp, tipo, ativo) VALUES (?, ?, ?, ?, ?, ?, 0)");
    $stm->bind_param("sssssi", $nome, $telefone, $email, $senhaCriptografada, $cnp, $tipo);
    $stm->execute();

    $idFornecedor = $stm->insert_id;

    // Adiciona a imagem do fornecedor
    if ($temImagem) {
        $stm = $conexao->prepare("UPDATE fornecedor SET imagem = ? WHERE id_fornecedor = ?");
        $stm->bind_param("ss", $imagemCaminho, $idFornecedor);
        $stm->execute();
    
        $movido = move_uploaded_file($logo["tmp_name"], "../".$imagemCaminho);
        if (!$movido) {
            echo "<script>alert('Erro ao salvar imagem');</script>";
            header("Location: ../cadastro");
        }
    }

    // Cria o ponto de coleta que representa a sede do fornecedor
    $stm = $conexao->prepare("INSERT INTO ponto_coleta (horario, complemento, numero, rua, cep, id_municipio, id_fornecedor, referencia, sede) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)");
    $stm->bind_param("ssisiiis", $horario, $complemento, $numero, $rua, $cep, $idMunicipio, $idFornecedor, $referencia);
    $stm->execute();

    // Enviar notificações via Telegram
    if (isset($_ENV["TELEGRAM_API"])) {
        $host = str_replace("localhost", "127.0.0.1", $_SERVER["HTTP_HOST"]);
        $caminho = dirname($_SERVER["REQUEST_URI"]);
        $urlAtivacao = "http://$host$caminho/ativar_fornecedor?id=$idFornecedor";
        $conteudoMensagem = "<b>Um novo usuário entrou para a plataforma:</b> %0A%0AID: $idFornecedor %0ANome: $nome %0ATelefone: $telefone %0AE-mail: $email %0A%0A<a href='$urlAtivacao'>Ativar fornecedor</a>";

        $tokenTelegram = $_ENV["TELEGRAM_API"];
        $canaisTelegram = explode(",", $_ENV["ID_CANAIS_TELEGRAM"]);

        // Envia a notificação para cada canal/chat passado
        foreach ($canaisTelegram as $canal) {
            $url = "https://api.telegram.org/bot$tokenTelegram/sendMessage?chat_id=$canal&text=$conteudoMensagem&parse_mode=html";
            $parametros = array(
                "chat_id" => $canal,
                "text" => $conteudoMensagem,
                "parse_mode" => "html"
            );
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $parametros);
            $response = curl_exec($curl);
            curl_close($curl);
        }
    }

    // Autenticação
    include "autenticacao.php";
?>
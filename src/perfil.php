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

    <!-- Ícones -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
</head>
<body>

<?php
    include '_header.php';
    include_once "php/sessao.php";

    $idGet = $_GET["id_fornecedor"];
    
    // Se os IDs forem iguais, o usuário é o dono do perfil
    $dono = isset($idSessao) && $idSessao == $idGet;

    // Consulta os dados do fornecedor
    $stm = $conexao->prepare("SELECT * FROM fornecedor WHERE id_fornecedor = ?");
    $stm->bind_param("i", $idGet);
    $stm->execute();
    $res = $stm->get_result();

    // Se o perfil não existir, exibe apenas um aviso
    if ($res->num_rows == 0) {
        ?>
            <main style = "display: flex; justify-content: center; align-items: center;">
                <h1>Perfil não encontrado</h1>
            </main>
            </body>    
            </html>
        <?php
        exit();
    }

    // Dados do fornecedor
    $dados = $res->fetch_assoc();
    $nome = $dados["nome"];
    $imagem = $dados["imagem"];
    if ($imagem == null) {
        $imagem = "img/perfil.png";
    }
    $telefone = $dados["telefone"];
    $email = $dados["email"];
    
    $telefoneFormatado = "(".substr($telefone, 0, 2).") ".substr($telefone, 2, 5)."-".substr($telefone, 7, 4);

    // Pontos de coleta
    class Ponto {
        public $horario;
        public $rua;
        public $numero;
        public $cep;
        public $cidade;
        public $estado;
        public $referencia;
        public $complemento;

        public function localFormatado() {
            return $this->rua.", ".$this->numero." - ".$this->cidade.", ".$this->estado;
        }

        public function renderizar() { ?>
        <div>
            <?php
                if (!is_null($this->referencia)) {
                    echo "<h3>" . $this->referencia . "</h3>";
                }
            ?>
            <p>
                <?php
                    echo "<b>Endereço: </b>" . $this->localFormatado() . "<br>";
                    if (!is_null($this->complemento)) {
                        echo "<b>Complemento: </b> ".$this->complemento."<br>";
                    }
                    if (!is_null($this->horario)) {
                        echo "<b>Horário de funcionamento: </b>" . $this->horario;
                    } 
                ?>
            </p>
        </div>
    <?php }
    }

    $stm = $conexao->prepare("SELECT * FROM ponto_coleta WHERE id_fornecedor = ?");
    $stm->bind_param("i", $idGet);
    $stm->execute();
    $res = $stm->get_result();

    $sedes = array();
    $pontos = array();

    while ($ponto = $res->fetch_assoc()) {
        $p = new Ponto();
        $p->horario = $ponto["horario"];
        $p->complemento = $ponto["complemento"];
        $p->numero = $ponto["numero"];
        $p->rua = $ponto["rua"];
        $p->cep = $ponto["cep"];
        $p->referencia = $ponto["referencia"];
            
        // Consulta a cidade e estado do endereço
        $stm = $conexao->prepare("SELECT nome, estado FROM municipio WHERE id_municipio = ?");
        $stm->bind_param("i", $ponto["id_municipio"]);
        $stm->execute();
        $res = $stm->get_result();

        $dados = $res->fetch_assoc();
        $p->cidade = $dados["nome"];
        $p->estado = $dados["estado"];

        if ($ponto["sede"]) {
            $sedes[] = $p;
        } else {
            $pontos[] = $p;
        }
    }
?>

    <main>
        <div id="dados">
            <h2><?php echo $nome; ?></h2>
            <img id="logo" src="<?= $imagem ?>" alt="<?= $nome ?>"></h2>
            <p>
                <b>Telefone:</b> <?= $telefoneFormatado ?><br>
                <b>Email:</b> <?= $email ?><br>
                <a href="peca">Adicionar peça</a>
            </p>
        </div>

        <div id="pontos">
            <iframe
            height="100%" width="100%" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps/embed/v1/place?key=<?php echo $_ENV["MAPS_API"] ?>&q=<?php echo urlencode($sedes[0]->localFormatado()) ?>">
            </iframe>
            <div id="pontos-lista">
                <h2>Sede</h2>
                <?php
                    foreach ($sedes as $p) {
                        $p->renderizar();
                    }
                ?>
                <h2>Pontos de coleta</h2>
                </div>
            </div>
        </div>
        <div id="pecas"></div>
    </main>
</body>
</html>
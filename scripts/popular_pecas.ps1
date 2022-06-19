param([Int32]$num=20) 

# Clona o repositório contendo as imagens das peças
if (!(Test-Path "./temp")) {
    git clone "https://github.com/alexeygrigorev/clothing-dataset-small" "./temp"
}

# Lê as credenciais do banco de dados do arquivo '.env'
$env = (Get-content "../.env").Split([Char]::CrLf)
$valores = @{}
foreach ($linha in $env) {
    $valores[$linha.Split("=")[0]] = $linha.Split("=")[1]
}

# Faz a conexão com o banco de dados
[void][System.Reflection.Assembly]::LoadWithPartialName("MySql.Data")
$con = New-Object MySql.Data.MySqlClient.MySqlConnection
$con.ConnectionString = "Server={0};Uid={1};Pwd={2};database={3};" -f $valores["DB_ENDERECO"], $valores["DB_USUARIO"], $valores["DB_SENHA"], $valores["DB_BANCO"]
$con.Open()

function Executar($sql) {
    $cmd = New-Object MySql.Data.MySqlClient.MySqlCommand($sql, $con)
    $dataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($cmd)
    $dataSet = New-Object System.Data.DataSet
    $dataAdapter.Fill($dataSet, "data")
    return $dataSet.Tables["data"]
}

function PontoColetaAleatorio() {
    $sql = "SELECT id_ponto_coleta FROM ponto_coleta ORDER BY RAND() LIMIT 1"
    $res = Executar($sql)
    return $res.Get(1)["id_ponto_coleta"]
}

$mapaCategorias = @{
    "dress" = "Vestido";
    "hat" = "Chapeu";
    "longsleeve" = "Manga comprida";
    "outwear" = "Jaqueta";
    "pants" = "Calca";
    "shirt" = "Camisa";
    "shoes" = "Sapato";
    "shorts" = "Bermuda";
    "skirt" = "Saia";
    "t-shirt" = "Camiseta";
}
$idCategorias = @{}

# Adiciona as categorias ao banco de dados
foreach ($item in $mapaCategorias.GetEnumerator()) {
    $chave = $item.Key
    $descricao = $item.Value

    $sql = "SELECT COUNT(*) FROM categoria_peca WHERE descricao = '{0}'" -f $descricao
    $res = (Executar($sql))
    if ($res.Get(1)["COUNT(*)"] -eq 0) {
        $sql = "INSERT INTO categoria_peca (descricao) VALUES ('$descricao')"
        Executar($sql)
    }

    # Associa o nome da categoria ao seu ID
    $id = (Executar("SELECT id_categoria_peca FROM categoria_peca WHERE descricao = '{0}'" -f $descricao)).Get(1)["id_categoria_peca"]
    $idCategorias[$chave] = $id
}

$tamanhos = @(
    "P",
    "M",
    "G",
    "GG",
    "XGG"
)
$cores = @(
    "branco",
    "azul",
    "verde",
    "vermelho",
    "preto",
    "cinza",
    "rosa",
    "laranja",
    "amarelo",
    "roxo"
)

function InserirPecaAleatoria($idPontoColeta) {
    $categoria = $mapaCategorias.Keys | Get-Random

    $idCategoria = $idCategorias[$categoria]
    $cor = $cores | Get-Random
    $idPontoColeta = PontoColetaAleatorio
    # Tamanho
    if ($categoria -eq "shoes") {
        $tamanho = (Get-Random -Minimum 15 -Maximum 25) * 2
    }
    elseif ($categoria -eq "hat") {
        $tamanho = "N/A"
    }
    else {
        $tamanho = $tamanhos | Get-Random
    }
    # Preço
    if ((Get-Random -Maximum 3) -gt 0) {
        $preco = (Get-Random -Minimum 10 -Maximum 30) * 100
    }
    else {
        $preco = 0
    }

    $titulo = "$($mapaCategorias[$categoria]) $cor, tamanho $tamanho"
    $descricao = "$titulo | Lorem ipsum dolor sit amet consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate."

    # Realiza a inserção
    $sql = "INSERT INTO peca (tamanho, cor, descricao, titulo, preco, id_reserva, id_categoria_peca, id_ponto_coleta) values ('{0}', '{1}', '{2}', '{3}', {4}, NULL, {5}, {6});" `
     -f $tamanho, $cor, $descricao, $titulo, $preco, $idCategoria, $idPontoColeta
    Executar($sql)

    $idInserido = (Executar("SELECT LAST_INSERT_ID()")).Get(1)["LAST_INSERT_ID()"]

    # Escolhe uma imagem aleatória
    $img = Get-ChildItem "./temp/train/$categoria" | Get-Random -Count 1

    # Copia a imagem para o seu diretório
    $destino = "../imagens/peca/$idInserido.jpg"
    $img | Copy-Item -Destination $destino

    # Insere a imagem no banco de dados
    $sql = "INSERT INTO imagem_peca (imagem, id_peca) values ('{0}', {1});" `
     -f $destino, $idInserido
    Executar($sql)
}

for ($i = 0; $i -lt $num; $i++) {
    InserirPecaAleatoria
}

# Fecha a conexão com o banco de dados
$con.close()
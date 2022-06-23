<?php

class Peca {
    public $id;
    public $titulo;
    public $tamanho;
    public $cor;
    public $preco;
    public $descricao;

    // FK
    public $categoria;
    public $pontoColeta;
    public $reserva;

    public static $cores = [
        "branco" => "Branco",
        "azul" => "Azul",
        "verde" => "Verde",
        "vermelho" => "Vermelho",
        "preto" => "Preto",
        "cinza" => "Cinza",
        "rosa" => "Rosa",
        "laranja" => "Laranja",
        "amarelo" => "Amarelo",
        "roxo" => "Roxo"
    ];

    public static $tamanhos = [
        "p" => "P",
        "m" => "M",
        "g" => "G",
        "gg" => "GG",
        "xgg" => "XGG"
    ];

    public static function ler($obj) {
        $p = new Peca();
        $p->id = $obj["id_peca"];
        $p->titulo = $obj["titulo"];
        $p->tamanho = $obj["tamanho"];
        $p->cor = $obj["cor"];
        $p->preco = $obj["preco"] / 100;
        $p->descricao = $obj["descricao"];
        $p->categoria = $obj["id_categoria_peca"];
        $p->pontoColeta = $obj["id_ponto_coleta"];
        $p->reserva = $obj["id_reserva"];
        return $p;
    }

    public function categoria() {
        include_once "categoria_peca.php";
        global $conexao;

        $stm = $conexao->prepare("SELECT * FROM categoria_peca WHERE id_categoria_peca = ?");
        $stm->bind_param("i", $this->categoria);
        $stm->execute();
        $res = $stm->get_result();

        return CategoriaPeca::ler($res->fetch_assoc());
    }

    public function pontoColeta() {
        include_once "ponto_coleta.php";
        global $conexao;

        $stm = $conexao->prepare("SELECT * FROM ponto_coleta WHERE id_ponto_coleta = ?");
        $stm->bind_param("i", $this->pontoColeta);
        $stm->execute();
        $res = $stm->get_result();

        return PontoColeta::ler($res->fetch_assoc());
    }

    public function reserva() {
        include_once "reserva.php";
        global $conexao;

        $stm = $conexao->prepare("SELECT * FROM reserva WHERE id_reserva = ?");
        $stm->bind_param("i", $this->reserva);
        $stm->execute();
        $res = $stm->get_result();

        return Reserva::ler($res->fetch_assoc());
    }

    public function imagens() {
        include_once "imagem_peca.php";
        global $conexao;

        $stm = $conexao->prepare("SELECT * FROM imagem_peca WHERE id_peca = ?");
        $stm->bind_param("i", $this->id);
        $stm->execute();
        $res = $stm->get_result();

        $imagens = [];
        while ($obj = $res->fetch_assoc()) {
            $imagens[] = ImagemPeca::ler($obj);
        }
        
        return $imagens;
    }

    public function precoFormatado() {
        return "R$ ".number_format((float)$this->preco, 2, ",", "");
    }
}
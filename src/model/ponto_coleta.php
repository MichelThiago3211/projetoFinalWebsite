<?php

class PontoColeta {
    public $id;
    public $horario;
    public $rua;
    public $numero;
    public $cep;
    public $referencia;
    public $complemento;
    public $sede;

    // FK
    public $municipio;
    public $fornecedor;

    public function formatar() {
        $m = $this->municipio();
        return $this->rua.", ".$this->numero." - ".$m->nome.", ".$m->estado;
    }

    public static function ler($obj) {
        $pc = new PontoColeta();
        $pc->id = $obj["id_ponto_coleta"];
        $pc->horario = $obj["horario"];
        $pc->complemento = $obj["complemento"];
        $pc->numero = $obj["numero"];
        $pc->rua = $obj["rua"];
        $pc->cep = $obj["cep"];
        $pc->municipio = $obj["id_municipio"];
        $pc->fornecedor = $obj["id_fornecedor"];
        $pc->referencia = $obj["referencia"];
        $pc->sede = $obj["sede"];
        return $pc;
    }

    public function municipio() {
        include_once "municipio.php";
        global $conexao;

        $stm = $conexao->prepare("SELECT * FROM municipio WHERE id_municipio = ?");
        $stm->bind_param("i", $this->municipio);
        $stm->execute();
        $res = $stm->get_result();

        return Municipio::ler($res->fetch_assoc());
    }

    public function fornecedor() {
        include_once "fornecedor.php";
        global $conexao;

        $stm = $conexao->prepare("SELECT * FROM fornecedor WHERE id_fornecedor = ?");
        $stm->bind_param("i", $this->fornecedor);
        $stm->execute();
        $res = $stm->get_result();

        return Fornecedor::ler($res->fetch_assoc());
    }
}
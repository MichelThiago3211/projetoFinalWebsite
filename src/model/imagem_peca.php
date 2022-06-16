<?php

class ImagemPeca {
    public $id;
    public $caminho;

    // FK
    public $peca;

    public static function ler($obj) {
        $p = new ImagemPeca();
        $p->id = $obj["id_imagem_peca"];
        $p->caminho = $obj["imagem"];
        $p->peca = $obj["id_peca"];
        return $p;
    }

    public function peca() {
        include_once "peca.php";
        global $conexao;

        $stm = $conexao->prepare("SELECT * FROM peca WHERE id_peca = ?");
        $stm->bind_param("i", $this->peca);
        $stm->execute();
        $res = $stm->get_result();

        return Peca::ler($res->fetch_assoc());
    }
}
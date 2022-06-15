<?php

class CategoriaPeca {
    public $id;
    public $descricao;
   
    public static function ler($obj) {
        $cp = new CategoriaPeca();
        $cp->id = $obj["id_categoria_peca"];
        $cp->descricao = $obj["descricao"];
        return $cp;
    }
}
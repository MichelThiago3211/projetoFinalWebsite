<?php

class Municipio {
    public $id;
    public $nome;
    public $estado;
   
    public static function ler($obj) {
        $m = new Municipio();
        $m->id = $obj["id_municipio"];
        $m->nome = $obj["nome"];
        $m->estado = $obj["estado"];
        return $m;
    }
}
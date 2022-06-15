<?php

class Reserva {
    public $id;
    public $cpf;
    public $nome;
    public $data;

    public static function ler($obj) {
        $r = new Reserva();
        $r->id = $obj["id_reserva"];
        $r->cpf = $obj["cpf"];
        $r->nome = $obj["nome"];
        $r->data = $obj["data"];
        return $r;
    }
}
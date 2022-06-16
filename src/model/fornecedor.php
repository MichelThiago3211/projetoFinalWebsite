<?php

class Fornecedor {
    public $id;
    public $nome;
    public $telefone;
    public $email;
    public $hashSenha;
    public $cnp;
    public $tipo;
    public $ativo;
    public $imagem;

    public static function ler($obj) {
        $f = new Fornecedor();
        $f->id = $obj["id_fornecedor"];
        $f->nome = $obj["nome"];
        $f->telefone = $obj["telefone"];
        $f->email = $obj["email"];
        $f->hashSenha = $obj["senha"];
        $f->cnp = $obj["cnp"];
        $f->tipo = $obj["tipo"];
        $f->ativo = $obj["ativo"];
        $f->imagem = $obj["imagem"];
        return $f;
    }
}
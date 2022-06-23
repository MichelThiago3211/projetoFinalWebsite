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

    public function telefoneFormatado() {
        $ddd = substr($this->telefone, 0, 2);
        if (strlen($this->telefone) == 10) {
            $inicio = substr($this->telefone, 2, 4);
            $fim = substr($this->telefone, 6);
        }
        else {
            $inicio = substr($this->telefone, 2, 5);
            $fim = substr($this->telefone, 7);
        }
        return "($ddd) $inicio-$fim";
    }

    public function cnpFormatado() {
        if (strlen($this->cnp) == 11) {
            // CPF
            $partes = array(
                substr($this->cnp, 0, 3),
                substr($this->cnp, 3, 3),
                substr($this->cnp, 6, 3),
                substr($this->cnp, 9)
            );
            return "$partes[0].$partes[1].$partes[2]-$partes[3]";
        }

        // CNPJ
        $partes = array(
            substr($this->cnp, 0, 2),
            substr($this->cnp, 2, 3),
            substr($this->cnp, 5, 3),
            substr($this->cnp, 12)
        );
        return "$partes[0].$partes[1].$partes[2]/0001-$partes[3]";
    }
}
<?php

use Livro\Database\Record;

class Cidade extends Record
{
    const TABLENAME = 'cidade';
    private $estado;

    public function getEstado()
    {
        if (empty($this->estado)) {
            $this->estado = new Estado($this->id_estado);
        }
        return $this->estado;
    }

    public function getNomeEstado()
    {
        if (empty($this->estado)) {
            $this->estado = new Estado($this->id_estado);
        }
        return $this->estado->nome;
    }
}

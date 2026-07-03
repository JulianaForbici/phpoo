<?php

namespace Model;

use Livro\Database\Record;

class Produto extends Record
{
    const TABLENAME = 'produto';
    private $fabricante;

    public function getNomeFabricante()
    {
        if (empty($this->fabricante)) {
            $this->fabricante = new Fabricante($this->id_fabricante);
        }
        return $this->fabricante->nome;
    }
}

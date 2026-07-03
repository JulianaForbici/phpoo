<?php

namespace Model;

use Livro\Database\Record;

class ItemVenda extends Record
{
    const TABLENAME = 'item_venda';
    private $produto;

    public function setProduto(Produto $p)
    {
        $this->produto = $p;
        $this->id_produto = $p->id;
    }

    public function getProduto()
    {
        if (empty($this->produto)) {
            $this->produto = new Produto($this->id_produto);
        }
        return $this->produto;
    }
}

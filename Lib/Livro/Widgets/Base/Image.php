<?php

use Livro\Widgets\Base\Element;

class Image extends Element
{
    private $source;

    public function __construct($source)
    {
        parent::__construct();
        $this->src = $source;
        $this->border = 0;
    }
}

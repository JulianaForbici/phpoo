<?php

namespace Widgets\Form;

use Livro\Widgets\Base\Element;
use Livro\Widgets\Form\Field;
use Livro\Widgets\Form\FormElementInterface;

class Text extends Field implements FormElementInterface
{
    private $width;
    private $height = 100;
    public function setSize($width, $height = NULL)
    {
        $this->size = $width;

        if (isset($height))
        {
            $this->height = $height;
        }
    }
    public function show()
    {
        $tag = new Element('textarea');
        $tag->class = 'field';
        $tag->name = $this->name;
        $tag->style = "width:{$this->size};height:{$this->height}"; // tamanho em pixels
        if (!parent::getEditable())
        {
            $tag->readonly = "1";
        }
        $tag->add(htmlspecialchars((string) $this->value));
        if ($this->properties)
        {
            foreach ($this->properties as $property => $value)
            {
                $tag->$property = $value;
            }
        }
        $tag->show();
    }
}
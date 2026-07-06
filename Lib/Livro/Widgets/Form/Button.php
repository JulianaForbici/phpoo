<?php

namespace Widgets\Form;

use Livro\Control\ActionInterface;
use Livro\Widgets\Base\Element;
use Livro\Widgets\Form\Field;
use Livro\Widgets\Form\FormElementInterface;

class Button extends Field implements FormElementInterface
{
    private $action;
    private $label;
    private $formName;

    public function setAction(ActionInterface $action, $label)
    {
        $this->action = $action;
        $this->label = $label;
    }

    public function setFormName($name)
    {
        $this->formName = $name;
    }

    public function show()
    {
        $url = $this->action->serialize();
        $tag = new Element('button');
        $tag->name    = $this->name;
        $tag->type    = 'button';
        $tag->add($this->label);
        $tag->onclick =	"document.{$this->formName}.action='{$url}'; " . "document.{$this->formName}.submit()";

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
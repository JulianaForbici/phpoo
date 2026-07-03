<?php

namespace Livro\Database;
class Criteria
{
    private $properties;
    private $filters;

    function __construct()
    {
        $this->filters = [];
    }

    public function add($variable, $compare_operator, $value, $logic_operator = 'and')
    {
        if (empty($this->filters)) {
            $logic_operator = null;
        }
        $this->filters[] = [$variable, $compare_operator, $this->transform($value), $logic_operator];
    }

    private function transform($value)
    {
        if (is_array($value)) {
            foreach ($value as $x) {
                if (is_integer($x)) {
                    $foo[] = $x;
                } elseif (is_string($x)) {
                    $foo[] = "'$x'";
                }
            }
            $result = '(' . implode(',', $foo) . ')';
        } elseif (is_string($value)) {
            $result = "'$value'";
        } elseif (is_null($value)) {
            $result = 'null';
        } elseif (is_bool($value)) {
            $result = $value ? 'true' : 'false';
        } else {
            $result = $value;
        }
        return $result;
    }

    public function dump()
    {
        if (is_array($this->filters) and count($this->filters) > 0) {
            $result = '';
            foreach ($this->filters as $filter) {
                $result .= $filter[3] . ' ' . $filter[0] . ' ' . $filter[1] . ' ' . $filter[2] . ' ';
            }
            $result = trim($result);
            return "({$result})";
        }
    }

    public function setProperty($property, $value)
    {
        if (isset($value)) {
            $this->properties[$property] = $value;
        } else {
            $this->properties[$property] = null;
        }
    }

    public function getProperty($property)
    {
        if (isset($this->properties[$property])) {
            return $this->properties[$property];
        }
    }
}

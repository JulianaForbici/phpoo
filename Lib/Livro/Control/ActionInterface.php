<?php

interface ActionInterface
{
    public function setParameter($param, $value);
    public function serialize();
}

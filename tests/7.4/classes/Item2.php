<?php

class Item2
{
    public int $id;
    public string $string;
    public bool $active;
    public $missing;

    function __toString()
    {
        return "this is from __toString()";
    }
}

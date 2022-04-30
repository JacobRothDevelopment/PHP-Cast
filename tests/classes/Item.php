<?php

class Item
{
    public int $id;
    public string $string;
    public bool $active;
    public ?int $nullableInt;
    public array $array;
    public object $object;
    public float $float;
    // public mixed $mixedP; // mixed is only valid for php 8^
    public $missing;
}

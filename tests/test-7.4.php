<?php

use PhpCast\Cast;

require_once __DIR__ . "/loader.php";
require_once __DIR__ . "/../src/Cast.php";

$item = [
    "name" => "name",
    "type" => "type",
    "active" => false,
    "another" => false,
];

$item2 = [
    "name" => "less than what expected",
    "active" => false,
];

print(\PhpCast\Cast::cast(9.2324, "int") . "\r\n");
print(\PhpCast\Cast::cast(9.2324, "double") . "\r\n");
print(\PhpCast\Cast::cast(9.2324, "float") . "\r\n");
print(\PhpCast\Cast::cast(9.2324, "bool") . "\r\n");
print(\PhpCast\Cast::cast(9.2324, "string") . "\r\n");
print(json_encode(\PhpCast\Cast::cast(9.2324, "object")) . "\r\n");

// print(\PhpCast\Cast::cast($item, "int") . "\r\n");
// print(\PhpCast\Cast::cast($item, "double") . "\r\n");
// print(\PhpCast\Cast::cast($item, "float") . "\r\n");
// print(\PhpCast\Cast::cast($item, "bool") . "\r\n");
// print(\PhpCast\Cast::cast($item, "string") . "\r\n");
print(json_encode(\PhpCast\Cast::cast($item, "object")) . "\r\n");

print(json_encode(\PhpCast\Cast::cast($item, "Item")) . "\r\n");

print(json_encode(\PhpCast\Cast::cast($item2, "Item")) . "\r\n");

<?php

require_once __DIR__ . "/loader.php";
require_once __DIR__ . "/../src/Cast.php";

$item1 = [
    "id" => 10,
    "string" => "string name",
    "active" => false,
    "nullableInt" => 101,
    "array" => [1, 2, 3],
    "object" => (object)[
        "id" => 3
    ],
    "float" => 10.003,
    "missing" => 10.003,
];

$item2 = [
    "id" => 11,
    "string" => "string name 2",
    "active" => false,
    // "nullableInt" => null, // test missing nullable property
    "array" => [1, 2, 3],
    "object" => (object)[
        "id" => 3
    ],
    "float" => 10.003,
    "missing" => 10.003,
    "extraParameter" => 909.3,
];

$item2_2 = [
    "id" => 200,
    "string" => "string value 2200",
    "active" => true,
]; // I really need a better naming scheme

$master = [
    "item1" => $item1,
    "item2" => $item2,
];

$object1 = (object)$item1;

$fullItem = new Item2();
$fullItem->id = 2;
$fullItem->string = "string value";
$fullItem->active = true;

// Cast to int
print(\PhpCast\Cast::cast("int", null) . "\r\n"); // 0
print(\PhpCast\Cast::cast("int", 9) . "\r\n"); // 9
print(\PhpCast\Cast::cast("int", false) . "\r\n"); // 0
print(\PhpCast\Cast::cast("int", 9.2324) . "\r\n"); // 9
print(\PhpCast\Cast::cast("int", "string") . "\r\n"); // 0
print(\PhpCast\Cast::cast("int", "432") . "\r\n"); // 432
print(\PhpCast\Cast::cast("int", "432.901") . "\r\n"); // 432
print(\PhpCast\Cast::cast("int", []) . "\r\n"); // 0
print(\PhpCast\Cast::cast("int", [1, 2, 3]) . "\r\n"); // 1
print(\PhpCast\Cast::cast("int", [1.11, 2.22]) . "\r\n"); // 1
print(\PhpCast\Cast::cast("int", (object)[]) . "\r\n"); // 1; Notice: Object of class stdClass could not be converted to int
print(\PhpCast\Cast::cast("int", new Item()) . "\r\n"); // 1; Notice: Object of class Item could not be converted to int

// Cast to string
print(\PhpCast\Cast::cast("string", null) . "\r\n"); // ""
print(\PhpCast\Cast::cast("string", 9) . "\r\n"); // "9"
print(\PhpCast\Cast::cast("string", false) . "\r\n"); // ""
print(\PhpCast\Cast::cast("string", 9.2324) . "\r\n"); // "9.2324"
print(\PhpCast\Cast::cast("string", "string") . "\r\n"); // "string"
print(\PhpCast\Cast::cast("string", []) . "\r\n"); // "Array"; Notice: Array to string conversion
print(\PhpCast\Cast::cast("string", (object)[]) . "\r\n"); // Fatal error: Uncaught Error: Object of class stdClass could not be converted to string
print(\PhpCast\Cast::cast("string", new Item()) . "\r\n"); // Fatal error: Uncaught Error: Object of class Item could not be converted to string
print(\PhpCast\Cast::cast("string", new Item2()) . "\r\n"); // "this is from __toString()"

// Cast to float
print(\PhpCast\Cast::cast("float", null) . "\r\n"); // 0
print(\PhpCast\Cast::cast("float", 9) . "\r\n"); // 9
print(\PhpCast\Cast::cast("float", false) . "\r\n"); // 0
print(\PhpCast\Cast::cast("float", 9.2324) . "\r\n"); // 9.2324
print(\PhpCast\Cast::cast("float", "string") . "\r\n"); // 0
print(\PhpCast\Cast::cast("float", "432") . "\r\n"); // 432
print(\PhpCast\Cast::cast("float", "432.901") . "\r\n"); // 432.901
print(\PhpCast\Cast::cast("float", []) . "\r\n"); // 0
print(\PhpCast\Cast::cast("float", []) . "\r\n"); // 0
print(\PhpCast\Cast::cast("float", [1, 2, 3]) . "\r\n"); // 1
print(\PhpCast\Cast::cast("float", [1.11, 2.22]) . "\r\n"); // 1
print(\PhpCast\Cast::cast("float", (object)[]) . "\r\n"); // 1; Notice: Object of class stdClass could not be converted to float
print(\PhpCast\Cast::cast("float", new Item()) . "\r\n"); // 1; Notice: Object of class Item could not be converted to float

// Cast to bool
print(\PhpCast\Cast::cast("bool", null) . "\r\n"); // false
print(\PhpCast\Cast::cast("bool", 9) . "\r\n"); // true
print(\PhpCast\Cast::cast("bool", false) . "\r\n"); // false
print(\PhpCast\Cast::cast("bool", 9.2324) . "\r\n"); // true
print(\PhpCast\Cast::cast("bool", "string") . "\r\n"); // true
print(\PhpCast\Cast::cast("bool", "432") . "\r\n"); // true
print(\PhpCast\Cast::cast("bool", "") . "\r\n"); // false
print(\PhpCast\Cast::cast("bool", []) . "\r\n"); // false
print(\PhpCast\Cast::cast("bool", [1, 2, 3]) . "\r\n"); // true
print(\PhpCast\Cast::cast("bool", (object)[]) . "\r\n"); // true
print(\PhpCast\Cast::cast("bool", new Item()) . "\r\n"); // true

// Cast to array
print_r(\PhpCast\Cast::cast("array", null)); // Array ( )
print_r(\PhpCast\Cast::cast("array", 9)); // Array ( [0] => 9 ) 
print_r(\PhpCast\Cast::cast("array", false)); // Array ( [0] => ) 
print_r(\PhpCast\Cast::cast("array", 9.2324)); // Array ( [0] => 9.2324 ) 
print_r(\PhpCast\Cast::cast("array", "string")); // Array ( [0] => string ) 
print_r(\PhpCast\Cast::cast("array", [])); // Array ( ) 
print_r(\PhpCast\Cast::cast("array", (object)[])); // Array ( ) 
print_r(\PhpCast\Cast::cast("array", new Item())); // Array ( [missing] => )
print_r(\PhpCast\Cast::cast("array", $fullItem)); // Array ( [name] => string name [type] => string type [active] => 1 )

// Cast to object
print_r(\PhpCast\Cast::cast("object", null)); // stdClass Object ( ) 
print_r(\PhpCast\Cast::cast("object", 9)); // stdClass Object ( [scalar] => 9 ) 
print_r(\PhpCast\Cast::cast("object", false)); // stdClass Object ( [scalar] => ) 
print_r(\PhpCast\Cast::cast("object", 9.2324)); // stdClass Object ( [scalar] => 9.2324 ) 
print_r(\PhpCast\Cast::cast("object", "string")); // stdClass Object ( [scalar] => string ) 
print_r(\PhpCast\Cast::cast("object", "432")); // stdClass Object ( [scalar] => 432 ) 
print_r(\PhpCast\Cast::cast("object", "432.901")); // stdClass Object ( [scalar] => 432.901 ) 
print_r(\PhpCast\Cast::cast("object", [])); // stdClass Object ( ) 
print_r(\PhpCast\Cast::cast("object", [1, 2, 3])); // stdClass Object ( [0] => 1 [1] => 2 [2] => 3 )
print_r(\PhpCast\Cast::cast("object", (object)[])); // stdClass Object ( ) 
print_r(\PhpCast\Cast::cast("object", new Item())); // Item Object ( [missing] => ) 
print_r(\PhpCast\Cast::cast("object", $fullItem)); // Item2 Object ( [id] => 2 [string] => string value [active] => 1 )
print_r(\PhpCast\Cast::cast("object", $object1)); // stdClass Object ( [id] => 10 [string] => string name [active] => [nullableInt] => 101 [array] => Array ( [0] => 1 [1] => 2 [2] => 3 ) [object] => stdClass Object ( [id] => 3 ) [float] => 10.003 [missing] => 10.003 )

// Cast to Custom Class
print_r(\PhpCast\Cast::cast("Item", $item1)); // Item Object ( [id] => 10 [string] => string name [active] => [nullableInt] => 101 [array] => Array ( [0] => 1 [1] => 2 [2] => 3 ) [object] => stdClass Object ( [id] => 3 ) [float] => 10.003 [missing] => 10.003 )
print_r(\PhpCast\Cast::cast("Item", $item2)); // Item Object ( [id] => 11 [string] => string name 2 [active] => [nullableInt] => [array] => Array ( [0] => 1 [1] => 2 [2] => 3 ) [object] => stdClass Object ( [id] => 3 ) [float] => 10.003 [missing] => 10.003 ) 
print_r(\PhpCast\Cast::cast("Item2", $item1)); // Item2 Object ( [id] => 10 [string] => string name [active] => ) 
print_r(\PhpCast\Cast::cast("Item2", $item2)); // Item2 Object ( [id] => 11 [string] => string name 2 [active] => )
print_r(\PhpCast\Cast::cast("Item", $item2_2)); // Fatal error: Uncaught TypeError: Typed property Item::$array must be array, null used
print_r(\PhpCast\Cast::cast("Item2", $item2_2)); // Item2 Object ( [id] => 200 [string] => string value 2200 [active] => 1 )
print_r(\PhpCast\Cast::cast("MasterItem", $master)); // MasterItem Object ( [item1] => Item Object ( [id] => 10 [string] => string name [active] => [nullableInt] => 101 [array] => Array ( [0] => 1 [1] => 2 [2] => 3 ) [object] => stdClass Object ( [id] => 3 ) [float] => 10.003 [missing] => 10.003 ) [item2] => Item Object ( [id] => 11 [string] => string name 2 [active] => [nullableInt] => [array] => Array ( [0] => 1 [1] => 2 [2] => 3 ) [object] => stdClass Object ( [id] => 3 ) [float] => 10.003 [missing] => 10.003 ) [item3] => )

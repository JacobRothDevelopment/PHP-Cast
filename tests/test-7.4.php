<?php

require_once __DIR__ . "/loader.php";
require_once __DIR__ . "/../src/Cast.php";

function test(string $class, $value)
{
    try {
        print(print_r(\PhpCast\Cast::cast($class, $value), true) . "\r\n");
    } catch (\Error $e) {
        print_r($e->getMessage() . "\r\n");
    }
}

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
    // test missing nullable property nullableInt
    "array" => [1, 2, 3],
    "object" => (object)[
        "id" => 3
    ],
    "float" => 10.003,
    "missing" => 10.003,
    "extraParameter" => 909.3, // test property not in class
];

$item2_2 = [ // I really need a better naming scheme
    "id" => 200,
    "string" => "string value 2200",
    "active" => true,
];

$master = [
    "item1" => $item1,
    "item2" => $item2,
    // missing nullable property item3
];

$object1 = (object)$item1;

$fullItem = new Item2();
$fullItem->id = 2;
$fullItem->string = "string value";
$fullItem->active = true;

// Cast to int
test("int", null); // 0
test("int", 9); // 9
test("int", false); // 0
test("int", 9.2324); // 9
test("int", "string"); // 0
test("int", "432"); // 432
test("int", "432.901"); // 432
test("int", []); // 0
test("int", [1, 2, 3]); // 1
test("int", [1.11, 2.22]); // 1
test("int", (object)[]); // 1; Notice: Object of class stdClass could not be converted to int
test("int", new Item()); // 1; Notice: Object of class Item could not be converted to int

// Cast to string
test("string", null); // ""
test("string", 9); // "9"
test("string", false); // ""
test("string", 9.2324); // "9.2324"
test("string", "string"); // "string"
test("string", []); // "Array"; Notice: Array to string conversion
test("string", (object)[]); // Fatal error: Uncaught Error: Object of class stdClass could not be converted to string
test("string", new Item()); // Fatal error: Uncaught Error: Object of class Item could not be converted to string
test("string", new Item2()); // "this is from __toString()"

// Cast to float
test("float", null); // 0
test("float", 9); // 9
test("float", false); // 0
test("float", 9.2324); // 9.2324
test("float", "string"); // 0
test("float", "432"); // 432
test("float", "432.901"); // 432.901
test("float", []); // 0
test("float", []); // 0
test("float", [1, 2, 3]); // 1
test("float", [1.11, 2.22]); // 1
test("float", (object)[]); // 1; Notice: Object of class stdClass could not be converted to float
test("float", new Item()); // 1; Notice: Object of class Item could not be converted to float

// Cast to bool
test("bool", null); // false
test("bool", 9); // true
test("bool", false); // false
test("bool", 9.2324); // true
test("bool", "string"); // true
test("bool", "432"); // true
test("bool", ""); // false
test("bool", []); // false
test("bool", [1, 2, 3]); // true
test("bool", (object)[]); // true
test("bool", new Item()); // true

// Cast to array
test("array", null); // Array ( )
test("array", 9); // Array ( [0] => 9 ) 
test("array", false); // Array ( [0] => ) 
test("array", 9.2324); // Array ( [0] => 9.2324 ) 
test("array", "string"); // Array ( [0] => string ) 
test("array", []); // Array ( ) 
test("array", (object)[]); // Array ( ) 
test("array", new Item()); // Array ( [missing] => )
test("array", $fullItem); // Array ( [name] => string name [type] => string type [active] => 1 )

// Cast to stdClass object
test("object", null); // stdClass Object ( ) 
test("object", 9); // stdClass Object ( [scalar] => 9 ) 
test("object", false); // stdClass Object ( [scalar] => ) 
test("object", 9.2324); // stdClass Object ( [scalar] => 9.2324 ) 
test("object", "string"); // stdClass Object ( [scalar] => string ) 
test("object", "432"); // stdClass Object ( [scalar] => 432 ) 
test("object", "432.901"); // stdClass Object ( [scalar] => 432.901 ) 
test("object", []); // stdClass Object ( ) 
test("object", [1, 2, 3]); // stdClass Object ( [0] => 1 [1] => 2 [2] => 3 )
test("object", (object)[]); // stdClass Object ( ) 
test("object", new Item()); // Item Object ( [missing] => ) 
test("object", $fullItem); // Item2 Object ( [id] => 2 [string] => string value [active] => 1 )
test("object", $item1); // stdClass Object ( [id] => 10 [string] => string name [active] => [nullableInt] => 101 [array] => Array ( [0] => 1 [1] => 2 [2] => 3 ) [object] => stdClass Object ( [id] => 3 ) [float] => 10.003 [missing] => 10.003 )
test("object", $object1); // stdClass Object ( [id] => 10 [string] => string name [active] => [nullableInt] => 101 [array] => Array ( [0] => 1 [1] => 2 [2] => 3 ) [object] => stdClass Object ( [id] => 3 ) [float] => 10.003 [missing] => 10.003 )

// Cast to Custom Classes
test("Item", $item1); // Item Object ( [id] => 10 [string] => string name [active] => [nullableInt] => 101 [array] => Array ( [0] => 1 [1] => 2 [2] => 3 ) [object] => stdClass Object ( [id] => 3 ) [float] => 10.003 [missing] => 10.003 )
test("Item", $item2); // Item Object ( [id] => 11 [string] => string name 2 [active] => [nullableInt] => [array] => Array ( [0] => 1 [1] => 2 [2] => 3 ) [object] => stdClass Object ( [id] => 3 ) [float] => 10.003 [missing] => 10.003 ) 
test("Item2", $item1); // Item2 Object ( [id] => 10 [string] => string name [active] => ) 
test("Item2", $item2); // Item2 Object ( [id] => 11 [string] => string name 2 [active] => )
test("Item", $item2_2); // Fatal error: Uncaught TypeError: Typed property Item::$array must be array, null used
test("Item2", $item2_2); // Item2 Object ( [id] => 200 [string] => string value 2200 [active] => 1 )
test("MasterItem", $master); // MasterItem Object ( [item1] => Item Object ( [id] => 10 [string] => string name [active] => [nullableInt] => 101 [array] => Array ( [0] => 1 [1] => 2 [2] => 3 ) [object] => stdClass Object ( [id] => 3 ) [float] => 10.003 [missing] => 10.003 ) [item2] => Item Object ( [id] => 11 [string] => string name 2 [active] => [nullableInt] => [array] => Array ( [0] => 1 [1] => 2 [2] => 3 ) [object] => stdClass Object ( [id] => 3 ) [float] => 10.003 [missing] => 10.003 ) [item3] => )

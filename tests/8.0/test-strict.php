<?php

require_once __DIR__ . "/loader.php";
require_once __DIR__ . "/../../src/Cast.php";
require_once __DIR__ . "/../testFuncs.php";

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
    "mixed" => "mixed value",
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
    "mixed" => null,
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
    // missing mixed property mixedVal
];

$object1 = (object)$item1;

$fullItem = new Item2();
$fullItem->id = 2;
$fullItem->string = "string value";
$fullItem->active = true;

// Cast to int
test_strict("int", null, TEST_FAILURE);
test_strict("int", 9, 9);
test_strict("int", false, TEST_FAILURE);
test_strict("int", 9.2324, TEST_FAILURE);
test_strict("int", "string", TEST_FAILURE);
test_strict("int", "432", TEST_FAILURE);
test_strict("int", "432.901", TEST_FAILURE);
test_strict("int", [], TEST_FAILURE);
test_strict("int", [1, 2, 3], TEST_FAILURE);
test_strict("int", [1.11, 2.22], TEST_FAILURE);
test_strict("int", (object)[], TEST_FAILURE);
test_strict("int", new Item(), TEST_FAILURE);

// Cast to string
test_strict("string", null, TEST_FAILURE);
test_strict("string", 9, TEST_FAILURE);
test_strict("string", false, TEST_FAILURE);
test_strict("string", 9.2324, TEST_FAILURE);
test_strict("string", "string", "string");
test_strict("string", [], TEST_FAILURE);
test_strict("string", (object)[], TEST_FAILURE);
test_strict("string", new Item(), TEST_FAILURE);
test_strict("string", new Item2(), TEST_FAILURE);

// Cast to float
test_strict("float", null, TEST_FAILURE);
test_strict("float", 9, 9.0);
test_strict("float", false, TEST_FAILURE);
test_strict("float", 9.2324, 9.2324);
test_strict("float", "string", TEST_FAILURE);
test_strict("float", "432", TEST_FAILURE);
test_strict("float", "432.901", TEST_FAILURE);
test_strict("float", [], TEST_FAILURE);
test_strict("float", [], TEST_FAILURE);
test_strict("float", [1, 2, 3], TEST_FAILURE);
test_strict("float", [1.11, 2.22], TEST_FAILURE);
test_strict("float", (object)[], TEST_FAILURE);
test_strict("float", new Item(), TEST_FAILURE);

// Cast to bool
test_strict("bool", null, TEST_FAILURE);
test_strict("bool", 9, TEST_FAILURE);
test_strict("bool", false, false);
test_strict("bool", 9.2324, TEST_FAILURE);
test_strict("bool", "string", TEST_FAILURE);
test_strict("bool", "432", TEST_FAILURE);
test_strict("bool", "", TEST_FAILURE);
test_strict("bool", [], TEST_FAILURE);
test_strict("bool", [1, 2, 3], TEST_FAILURE);
test_strict("bool", (object)[], TEST_FAILURE);
test_strict("bool", new Item2(), TEST_FAILURE);

// Cast to array
test_strict("array", null, TEST_FAILURE);
test_strict("array", 9, TEST_FAILURE);
test_strict("array", false, TEST_FAILURE);
test_strict("array", 9.2324, TEST_FAILURE);
test_strict("array", "string", TEST_FAILURE);
test_strict("array", [], unserialize('a:0:{}')); // []
test_strict("array", (object)[], TEST_FAILURE);
test_strict("array", new Item2(), TEST_FAILURE);
test_strict("array", $fullItem, TEST_FAILURE);

// Cast to stdClass object
test_strict("object", null, TEST_FAILURE);
test_strict("object", 9, TEST_FAILURE);
test_strict("object", false, TEST_FAILURE);
test_strict("object", 9.2324, TEST_FAILURE);
test_strict("object", "string", TEST_FAILURE);
test_strict("object", "432", TEST_FAILURE);
test_strict("object", "432.901", TEST_FAILURE);
test_strict("object", [], unserialize('O:8:"stdClass":0:{}'));
test_strict("object", [1, 2, 3], unserialize('O:8:"stdClass":3:{s:1:"0";i:1;s:1:"1";i:2;s:1:"2";i:3;}'));
test_strict("object", (object)[], unserialize('O:8:"stdClass":0:{}'));
test_strict("object", new Item(), unserialize('O:8:"stdClass":1:{s:7:"missing";N;}'));
test_strict("object", $fullItem, unserialize('O:8:"stdClass":4:{s:2:"id";i:2;s:6:"string";s:12:"string value";s:6:"active";b:1;s:7:"missing";N;}'));
test_strict("object", $item1, unserialize('O:8:"stdClass":9:{s:2:"id";i:10;s:6:"string";s:11:"string name";s:6:"active";b:0;s:11:"nullableInt";i:101;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;s:5:"mixed";s:11:"mixed value";}'));
test_strict("object", $object1, unserialize('O:8:"stdClass":9:{s:2:"id";i:10;s:6:"string";s:11:"string name";s:6:"active";b:0;s:11:"nullableInt";i:101;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;s:5:"mixed";s:11:"mixed value";}'));

// Cast to Custom Classes
test_strict("Item", $item1, unserialize('O:4:"Item":9:{s:2:"id";i:10;s:6:"string";s:11:"string name";s:6:"active";b:0;s:11:"nullableInt";i:101;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;s:5:"mixed";s:11:"mixed value";}'));
test_strict("Item", $item2, unserialize('O:4:"Item":9:{s:2:"id";i:11;s:6:"string";s:13:"string name 2";s:6:"active";b:0;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;s:11:"nullableInt";N;s:5:"mixed";N;}'));
test_strict("Item2", $item1, unserialize('O:5:"Item2":4:{s:2:"id";i:10;s:6:"string";s:11:"string name";s:6:"active";b:0;s:7:"missing";d:10.003;}'));
test_strict("Item2", $item2, unserialize('O:5:"Item2":4:{s:2:"id";i:11;s:6:"string";s:13:"string name 2";s:6:"active";b:0;s:7:"missing";d:10.003;}'));
test_strict("Item", $item2_2, TEST_FAILURE);
test_strict("Item2", $item2_2, unserialize('O:5:"Item2":4:{s:2:"id";i:200;s:6:"string";s:17:"string value 2200";s:6:"active";b:1;s:7:"missing";N;}'));
test_strict("MasterItem", $master, unserialize('O:10:"MasterItem":4:{s:5:"item1";O:4:"Item":9:{s:2:"id";i:10;s:6:"string";s:11:"string name";s:6:"active";b:0;s:11:"nullableInt";i:101;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;s:5:"mixed";s:11:"mixed value";}s:5:"item2";O:4:"Item":9:{s:2:"id";i:11;s:6:"string";s:13:"string name 2";s:6:"active";b:0;s:11:"nullableInt";N;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;s:5:"mixed";N;}s:5:"item3";N;s:8:"mixedVal";N;}'));

print("all tests passed \n");

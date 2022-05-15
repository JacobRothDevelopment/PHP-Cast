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
test("int", null, 0);
test("int", 9, 9);
test("int", false, 0);
test("int", 9.2324, 9);
test("int", "string", 0);
test("int", "432", 432);
test("int", "432.901", 432);
test("int", [], 0);
test("int", [1, 2, 3], 1);
test("int", [1.11, 2.22], 1);
test("int", (object)[], 1);
test("int", new Item(), 1);

// Cast to string
test("string", null, "");
test("string", 9, "9");
test("string", false, "");
test("string", 9.2324, "9.2324");
test("string", "string", "string");
test("string", [], "Array");
test("string", (object)[], TEST_FAILURE);
test("string", new Item(), TEST_FAILURE);
test("string", new Item2(), "this is from __toString()");

// Cast to float
test("float", null, 0.0);
test("float", 9, 9.0);
test("float", false, 0.0);
test("float", 9.2324, 9.2324);
test("float", "string", 0.0);
test("float", "432", 432.0);
test("float", "432.901", 432.901);
test("float", [], 0.0);
test("float", [], 0.0);
test("float", [1, 2, 3], 1.0);
test("float", [1.11, 2.22], 1.0);
test("float", (object)[], 1.0);
test("float", new Item(), 1.0);

// Cast to bool
test("bool", null, false);
test("bool", 9, true);
test("bool", false, false);
test("bool", 9.2324, true);
test("bool", "string", true);
test("bool", "432", true);
test("bool", "", false);
test("bool", [], false);
test("bool", [1, 2, 3], true);
test("bool", (object)[], true);
test("bool", new Item2(), true);

// Cast to array
test("array", null, []);
test("array", 9, [9]);
test("array", false, [false]);
test("array", 9.2324, [9.2324]);
test("array", "string", ["string"]);
test("array", [], []);
test("array", (object)[], []);
test("array", new Item2(), ["missing" => null]);
test("array", $fullItem, ["id" => 2, "string" => "string value", "active" => true, "missing" => null]);

// Cast to stdClass object
test("object", null, (object)[]);
test("object", 9, (object)["scalar" => 9]);
test("object", false, (object)["scalar" => false]);
test("object", 9.2324, (object)["scalar" => 9.2324]);
test("object", "string", (object)["scalar" => "string"]);
test("object", "432", (object)["scalar" => "432"]);
test("object", "432.901", (object)["scalar" => "432.901"]);
test("object", [], (object)[]);
test("object", [1, 2, 3], (object)["0" => 1, "1" => 2, "2" => 3]);
test("object", (object)[], unserialize('O:8:"stdClass":0:{}'));
test("object", new Item(), unserialize('O:8:"stdClass":1:{s:7:"missing";N;}'));
test("object", $fullItem, unserialize('O:8:"stdClass":4:{s:2:"id";i:2;s:6:"string";s:12:"string value";s:6:"active";b:1;s:7:"missing";N;}'));
test("object", $item1, unserialize('O:8:"stdClass":8:{s:2:"id";i:10;s:6:"string";s:11:"string name";s:6:"active";b:0;s:11:"nullableInt";i:101;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;}'));
test("object", $object1, unserialize('O:8:"stdClass":8:{s:2:"id";i:10;s:6:"string";s:11:"string name";s:6:"active";b:0;s:11:"nullableInt";i:101;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;}'));

// Cast to Custom Classes
test("Item", $item1, unserialize('O:4:"Item":8:{s:2:"id";i:10;s:6:"string";s:11:"string name";s:6:"active";b:0;s:11:"nullableInt";i:101;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;}'));
test("Item", $item2, unserialize('O:4:"Item":8:{s:2:"id";i:11;s:6:"string";s:13:"string name 2";s:6:"active";b:0;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;s:11:"nullableInt";N;}'));
test("Item2", $item1, unserialize('O:5:"Item2":4:{s:2:"id";i:10;s:6:"string";s:11:"string name";s:6:"active";b:0;s:7:"missing";d:10.003;}'));
test("Item2", $item2, unserialize('O:5:"Item2":4:{s:2:"id";i:11;s:6:"string";s:13:"string name 2";s:6:"active";b:0;s:7:"missing";d:10.003;}'));
test("Item", $item2_2, TEST_FAILURE);
test("Item2", $item2_2, unserialize('O:5:"Item2":4:{s:2:"id";i:200;s:6:"string";s:17:"string value 2200";s:6:"active";b:1;s:7:"missing";N;}'));
test("MasterItem", $master, unserialize('O:10:"MasterItem":3:{s:5:"item1";O:4:"Item":8:{s:2:"id";i:10;s:6:"string";s:11:"string name";s:6:"active";b:0;s:11:"nullableInt";i:101;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;}s:5:"item2";O:4:"Item":8:{s:11:"nullableInt";N;s:2:"id";i:11;s:6:"string";s:13:"string name 2";s:6:"active";b:0;s:5:"array";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:6:"object";O:8:"stdClass":1:{s:2:"id";i:3;}s:5:"float";d:10.003;s:7:"missing";d:10.003;}s:5:"item3";N;}'));

print("all tests passed \n");

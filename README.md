# PHP-Cast

Cast variables to different types. Native types, generic types, custom classes, nested classes, and more

# Install

```bash
composer require php-cast/php-cast
```

# Usage

```php
// Example Classes and Data
class Item
{
    public int $id;
    public string $string;
    public bool $active;
    public ?int $nullableInt;
    public array $array;
    public object $object;
    public float $float;
    public $missing;
}

class MasterItem
{
    public Item $item1;
    public Item $item2;
    public ?Item $item3;
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

$master = [
    "item1" => $item1,
    "item2" => $item2,
    // missing nullable property item3
];
```

```php
// Usage Examples of PhpCast

// Casting values to int
\PhpCast\Cast::cast("int", null); // 0
\PhpCast\Cast::cast("int", 9.2324); // 9

// Cast to stdClass object
\PhpCast\Cast::cast("object", (object)[]);
/* stdClass Object
(
) */
\PhpCast\Cast::cast("object", "432.901");
/* stdClass Object
(
    [scalar] => 432.901
) */
\PhpCast\Cast::cast("object", $item1);
/* stdClass Object
(
    [id] => 10
    [string] => string name
    [active] =>
    [nullableInt] => 101
    [array] => Array
        (
            [0] => 1
            [1] => 2
            [2] => 3
        )

    [object] => stdClass Object
        (
            [id] => 3
        )

    [float] => 10.003
    [missing] => 10.003
) */

// Cast to Custom Classes
\PhpCast\Cast::cast("Item", $item1);
/* Item Object
(
    [id] => 10
    [string] => string name
    [active] =>
    [nullableInt] => 101
    [array] => Array
        (
            [0] => 1
            [1] => 2
            [2] => 3
        )

    [object] => stdClass Object
        (
            [id] => 3
        )

    [float] => 10.003
    [missing] => 10.003
) */
\PhpCast\Cast::cast("Item", $item2);
/* Item Object
(
    [id] => 11
    [string] => string name 2
    [active] =>
    [nullableInt] =>
    [array] => Array
        (
            [0] => 1
            [1] => 2
            [2] => 3
        )

    [object] => stdClass Object
        (
            [id] => 3
        )

    [float] => 10.003
    [missing] => 10.003
) */
\PhpCast\Cast::cast("MasterItem", $master);
/* MasterItem Object
(
    [item1] => Item Object
        (
            [id] => 10
            [string] => string name
            [active] =>
            [nullableInt] => 101
            [array] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                )

            [object] => stdClass Object
                (
                    [id] => 3
                )

            [float] => 10.003
            [missing] => 10.003
        )

    [item2] => Item Object
        (
            [id] => 11
            [string] => string name 2
            [active] =>
            [nullableInt] =>
            [array] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                )

            [object] => stdClass Object
                (
                    [id] => 3
                )

            [float] => 10.003
            [missing] => 10.003
        )

    [item3] =>
) */
```

See more usage cases in `tests/`. Full and up-to-date examples will be available at `https://github.com/JacobRothDevelopment/PHP-Cast/tree/main/tests`

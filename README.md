# PHP-Cast

Cast variables to different types. Native types, generic types, custom classes, nested classes, and more

# Install

```bash
composer require php-cast/php-cast
```

# Usage

```php
// Example Classes and Data
class Item1
{
    public int $id;
}

class Item2
{
    public int $id;
    public string $name;
    public ?int $nullableInt;
}

class ItemCollective
{
    public Item1 $item1;
    public Item2 $item2;
}

$i1_arr = [
    "id" => 1,
];

$i1_arr_str_id = [
    "id" => "11",
];
$i2_arr = [
    "id" => 2,
    "name" => "name value",
];

$ic_arr = [
    "item1" => $i1_arr,
    "item2" => $i2_arr,
];
```

```php
// Usage Examples of PhpCast

\PhpCast\Cast::cast("Item1", $i1_arr);
/* Item1 Object
(
    [id] => 1
) */

\PhpCast\Cast::cast("Item2", $i2_arr);
/* Item2 Object
(
    [id] => 2
    [name] => name value
    [nullableInt] =>
) */

\PhpCast\Cast::cast("ItemCollective", $ic_arr);
/* ItemCollective Object
(
    [item1] => Item1 Object
        (
            [id] => 1
        )

    [item2] => Item2 Object
        (
            [id] => 2
            [name] => name value
            [nullableInt] =>
        )

) */

\PhpCast\Cast::cast("Item1", $i2_arr);
/* Item1 Object
(
    [id] => 2
) */

\PhpCast\Cast::cast("Item1", $i1_arr_str_id);
/* Item1 Object
(
    [id] => 11
) */

\PhpCast\Cast::cast("int", 9.234);
// 9

\PhpCast\Cast::cast("int", 9.234, true); // TypeError - input is not of type "int"
\PhpCast\Cast::cast("Item2", $i1_arr); // TypeError - non-nullable property "name"
\PhpCast\Cast::cast("Item1", $i1_arr_str_id, true); // TypeError - property Item1::id is of type "int"
```

See more usage cases in `tests/`. Full and up-to-date examples will be available at `https://github.com/JacobRothDevelopment/PHP-Cast/tree/main/tests`
